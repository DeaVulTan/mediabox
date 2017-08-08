<?php
/**
 * File to allow the users to insert images in the article description
 *
 * Provides an interface to get images and thambnails of the images are
 * displayed. By clicking the thumbnail the image can be added to the
 * file element to insert the image.
 *
 * @category	Rayzz
 * @package		Members
 */
require_once('../common/configs/config.inc.php');
$CFG['site']['is_module_page'] = 'article';
$CFG['lang']['include_files'][] = 'languages/%s/article/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/help.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/imageInsertPopUp.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['auth']['is_authenticate'] = 'members';
if(isset($_REQUEST['ajax_page']) and $_REQUEST['ajax_page'])
	{
		$CFG['mods']['is_include_only']['non_html_header_files'] = true;
	}
else
	{
		$CFG['html']['header'] = 'general/html_header_no_header.php';
		$CFG['html']['footer'] = 'general/html_footer_no_footer.php';
		$CFG['mods']['is_include_only']['html_header'] = false;
		$CFG['html']['is_use_header'] = false;
	}
require($CFG['site']['project_path'].'common/application_top.inc.php');
/**
 * ImageInsert
 *
 * @category	Rayzz
 * @package		Members
 */
//<<<<<-------------- Class ArticleWriting begins ---------------//
class ImageInsert extends FormHandler
	{
		/**
		 * ImageInsert::chkFileNameIsNotEmpty()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkFileNameIsNotEmpty($field_name, $err_tip = '')
			{
				if(!(isset($_FILES) and $_FILES[$field_name]['name']))
					{
						$this->setFormFieldErrorTip($field_name,$err_tip);
						return false;
					}
				return true;
			}

		/**
		* ImageInsert::setIHObject()
		*
		* @param mixed $imObj
		* @return void
		*/
		public function setIHObject($imObj)
		{
			$this->imageObj = $imObj;
		}


		/**
		 * ImageInsert::chkValideFileSize()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkValideFileSize($field_name, $err_tip='')
			{
				$max_size = $this->CFG['admin']['articles']['image_max_size'] * 1024;
				if ($_FILES[$field_name]['size'] > $max_size)
					{
						$this->fields_err_tip_arr[$field_name] = $err_tip;
						return false;
					}
				return true;
			}

		/**
		 * ImageInsert::chkErrorInFile()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkErrorInFile($field_name, $err_tip='')
			{
				if($_FILES[$field_name]['error'])
					{
						$this->fields_err_tip_arr[$field_name] = $err_tip;
						return false;
					}
				return true;
			}

		/**
		 * ImageInsert::imageUpload()
		 *
		 * @return
		 */
		public function imageUpload()
			{
				$dir_count = 0;
				$file_path = '../'.$this->CFG['admin']['articles']['temp_article_image_folder'].$this->CFG['user']['user_id'].'/';
				$this->chkAndCreateFolder($file_path);
				if($handle = opendir($file_path))
					{
						while(false !== ($file = readdir($handle)))
							{
								$dir_count++;
							}
						closedir($handle);
					}
				$extern = strtolower(substr($_FILES['insertimage']['name'], strrpos($_FILES['insertimage']['name'], '.')+1));
				$newfilename=str_pad($dir_count,10,"0",STR_PAD_LEFT);
				//$file_path = '../'.$this->CFG['admin']['articles']['article_image_folder'];
				//$file_path = $file_path .$newfilename.'.'.$extern;
				$file_path = $file_path .$newfilename;
				$this->storeImagesTempServer($file_path, $extern);
				//move_uploaded_file($_FILES['insertimage']['tmp_name'], $file_path);
			}


	   /**
		* ImageInsert::storeImagesTempServer()
		*
		* @param string $uploadUrl
		* @param string $extern
		* @return void
		*/
		public function storeImagesTempServer($uploadUrl, $extern)
			{
				$imageObj = new ImageHandler($_FILES['insertimage']['tmp_name']);
				$this->setIHObject($imageObj);
				@chmod($uploadUrl.'.'.$extern, 0777);
				if($this->CFG['admin']['articles']['image_width'] or $this->CFG['admin']['articles']['image_height'])
				{
					$this->imageObj->resize($this->CFG['admin']['articles']['image_width'], $this->CFG['admin']['articles']['image_height'], '-');
					$this->imageObj->output_resized($uploadUrl.'.'.$extern, strtoupper($extern));
				}
				else
				{
					$this->imageObj->output_original($uploadUrl.'.'.$extern, strtoupper($extern));
				}

			}
	}
//-------------------- Code begins -------------->>>>>//
$ImageInsert = new ImageInsert();

$ImageInsert->setFormField('insertimage', '');
$ImageInsert->setFormField('operation', '');
$ImageInsert->setFormField('f_url', '');
$ImageInsert->image_format =  implode(', ', $CFG['admin']['articles']['articles_format_arr']);
$ImageInsert->CFG['admin']['articles']['image_width'] = 300;
$ImageInsert->CFG['admin']['articles']['image_height'] = 225;

$ImageInsert->setPageBlockNames(array('insert_image_form'));

$ImageInsert->setAllPageBlocksHide();
$ImageInsert->setPageBlockShow('insert_image_form');
$ImageInsert->sanitizeFormInputs($_REQUEST);

$ImageInsert->insert_image_form['image_list_url'] = getUrl('imagelist', '', '', 'members', 'article');
if($ImageInsert->isFormPOSTed($_POST, 'file-upload-submit'))
{
	$ImageInsert->chkValidFileType('insertimage', $CFG['admin']['articles']['articles_format_arr'], $LANG['insertimage_err_tip_invalid_file_type']) and
	$ImageInsert->chkValideFileSize('insertimage',$LANG['insertimage_err_tip_invalid_file_size']) and
	$ImageInsert->chkErrorInFile('insertimage',$LANG['insertimage_err_tip_invalid_file']);
	if($ImageInsert->isValidFormInputs())
		{
		$ImageInsert->imageUpload();
		$ImageInsert->setFormField('insertimage', '');
		$ImageInsert->setCommonSuccessMsg($LANG['insertimage_msg_success']);
		$ImageInsert->setPageBlockShow('block_msg_form_success');
		}
	else
		{
			$ImageInsert->setCommonErrorMsg($LANG['common_msg_error_sorry']);
			$ImageInsert->setPageBlockShow('block_msg_form_error');
			$ImageInsert->setPageBlockShow('insert_image_form');
		}
}
//-------------------- Code ends -------------->>>>>//
//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$ImageInsert->includeHeader();
?>
<script type="text/javascript">
	var image_base_path = '../files/article_avatar/<?php echo $CFG['user']['user_id'];?>/';
</script>
<script type="text/javascript" src="<?php echo $CFG['site']['article_url']; ?>js/imageInsertPopUp.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['article_url']; ?>js/imageManager.js"></script>
<link rel="stylesheet" href="css/imageInsertPopUp.css" type="text/css">
<?php
//include the content of the page
setTemplateFolder('members/', 'article');
$smartyObj->display('imageInsertPopUp.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$ImageInsert->includeFooter();
?>