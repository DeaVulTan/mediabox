<?php
require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_blog.inc.php');
$CFG['site']['is_module_page'] = 'blog';
$CFG['lang']['include_files'][] = 'languages/%s/blog/manageBlog.php';
$CFG['lang']['include_files'][] = 'languages/%s/blog/help.inc.php';
$CFG['html']['header'] = 'general/html_header.php';;
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_BlogActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_BlogHandler.lib.php';
$CFG['db']['is_use_db'] = true;
$CFG['auth']['is_authenticate'] = 'members';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;

require_once($CFG['site']['project_path'].'common/application_top.inc.php');
/**
 * manageBlog
 *
 * @package
 * @author edwin_048at09
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
Class manageBlog extends BlogHandler
	{
		public $blog_logo_ext;
		public $logo_image_path;


		public function chkBlogsAddedByUser()
		{
		    $this->blogadded =false;
		    $this->is_logo_image =false;
			$sql = 'SELECT blog_id, blog_name, blog_title, blog_slogan, width, height, blog_logo_ext, blog_status FROM '.
					$this->CFG['db']['tbl']['blogs'].
						' WHERE blog_status =\'Active\' AND user_id='.$this->dbObj->Param('user_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
			if (!$rs)
				trigger_db_error($this->dbObj);
			$logo_folder=$this->media_relative_path.$this->CFG['media']['folder'].'/'.
													$this->CFG['admin']['blog']['folder'].'/'.
													$this->CFG['admin']['blog']['blog_logo_folder'].'/';
			if($row = $rs->FetchRow())
			{
				$this->setFormField('blog_id',$row['blog_id']);
				$this->setFormField('blog_name',$row['blog_name']);
				$this->setFormField('blog_title',$row['blog_title']);
				$this->setFormField('blog_slogan',$row['blog_slogan']);
				$this->setFormField('blog_logo_ext',$row['blog_logo_ext']);
				$this->setFormField('blog_status',$row['blog_status']);
				$this->setFormField('width',$row['width']);
				$this->setFormField('height',$row['height']);
				$this->blog_id=$row['blog_id'];
				if($row['blog_logo_ext'])
				  {
				   $this->is_logo_image =true;
				   $this->logo_image_path =$logo_folder.$row['blog_id'].'.'.$row['blog_logo_ext'].'?'.time();
				   }
				else
					$this->is_logo_image =false;
				$this->blogadded =true;
			}
		}
		public function insertBlogDetail()
		{
			$status='Active';

		 	 $sql  = 'INSERT INTO '.$this->CFG['db']['tbl']['blogs'].
					 ' SET blog_name='.$this->dbObj->Param('blog_name').','.
					 ' blog_title='.$this->dbObj->Param('blog_title').','.
					 ' blog_slogan='.$this->dbObj->Param('blog_slogan').','.
					 ' blog_status='.$this->dbObj->Param('blog_status').','.
					 ' date_added = NOW(),'.
					 ' user_id='.$this->dbObj->Param('user_id');

				$value_arr = array(
								$this->fields_arr['blog_name'],
								$this->fields_arr['blog_title'],
								$this->fields_arr['blog_slogan'],
								$status,
								$this->CFG['user']['user_id']);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $value_arr);
				$this->blog_id = $this->dbObj->Insert_ID();
				return $this->dbObj->Insert_ID();

		}
		public function chkBlogNameExists($field_name, $err_tip='',$blog_id=0)
		{
		    $aditional_query='';
		    if($blog_id)
			  $aditional_query = ' AND blog_id!='.$blog_id;
			$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['blogs'].
					' WHERE blog_name='.$this->dbObj->Param('blog_name').
					' AND blog_status!='.$this->dbObj->Param('blog_status').$aditional_query;

			$status='Deleted';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_name'],$status));
			if (!$rs)
				trigger_db_error($this->dbObj);

			if($row = $rs->FetchRow())
			   {
			  	 $this->fields_err_tip_arr[$field_name] = $err_tip;
			  	 return false;
			   }
			return true;
		}
		/**
		 * manageBlog::chkValideFileSize()
		 *
		 * @param $field_name
		 * @param string $err_tip
		 * @return
		 **/
		public function chkValideFileSize($field_name, $err_tip='')
		{
			$max_size = $this->CFG['admin']['blog']['logo_max_size'] * 1024;
			if ($_FILES[$field_name]['size'] > $max_size)
				{
					$this->fields_err_tip_arr[$field_name] = $err_tip;
					return false;
				}
			return true;
		}

		/**
		 * manageBlog::chkErrorInFile()
		 *
		 * @param $field_name
		 * @param string $err_tip
		 * @return
		 **/
		public function chkErrorInFile($field_name, $err_tip='')
		{
			if($_FILES[$field_name]['error'])
				{
					$this->fields_err_tip_arr[$field_name] = $err_tip;
					return false;
				}
			return true;
		}
		public function setIHObject($imObj)
		{
			$this->imageObj = $imObj;
		}
		public function storeImagesTempServer($uploadUrl, $extern)
		{
			@chmod($uploadUrl.'.'.$extern, 0777);
			if($this->CFG['admin']['blog']['logo_height'] or $this->CFG['admin']['blog']['logo_width'])
			{
				$this->imageObj->resize($this->CFG['admin']['blog']['logo_width'], $this->CFG['admin']['blog']['logo_height'], '-');
				$this->imageObj->output_resized($uploadUrl.'.'.$extern, strtoupper($extern));
				$image_info = getImageSize($uploadUrl.'.'.$extern);
				$this->WIDTH = $image_info[0];
		        $this->HEIGHT = $image_info[1];
			}
			else
			{
				$this->imageObj->output_original($uploadUrl.'.'.$extern, strtoupper($extern));
				$image_info = getImageSize($uploadUrl.'.'.$extern);
				$this->WIDTH = $image_info[0];
		        $this->HEIGHT = $image_info[1];
			}
		}
		public function updateBlogImageExt($user_id,$logo_ext)
		{
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['blogs'].' SET '.
			'blog_logo_ext = '.$this->dbObj->Param('blog_logo_ext').', '.
			'width = '.$this->dbObj->Param('width').', '.
			'height = '.$this->dbObj->Param('height').' '.
			'WHERE user_id = '.$this->dbObj->Param('user_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($logo_ext, $this->WIDTH, $this->HEIGHT, $user_id));
			if (!$rs)
				trigger_db_error($this->dbObj);
			return true;
		}
		public function updateBlogDetail($blog_id)
		{
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['blogs'].' SET '.
			'blog_name = '.$this->dbObj->Param('blog_name').', '.
			'blog_title = '.$this->dbObj->Param('blog_title').', '.
			'blog_slogan = '.$this->dbObj->Param('blog_slogan').' '.
			'WHERE blog_id = '.$this->dbObj->Param('blog_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_name'],$this->fields_arr['blog_title'],$this->fields_arr['blog_slogan'],$blog_id));
			if (!$rs)
		 		trigger_db_error($this->dbObj);

			$condition = '  SUBSTRING_INDEX(action_value, \'~\', 1 ) IN ('.$blog_id.') AND action_key = \'blog_created\'';
			$sql='UPDATE '.$this->CFG['db']['tbl']['blog_activity'].' SET '.
				  'action_value  = '.$this->dbObj->Param('action_value').' '.
			     ' WHERE '.$condition;
			$stmt = $this->dbObj->Prepare($sql);
			$action_value = $blog_id.'~'.$this->CFG['user']['user_id'].'~'.$this->CFG['user']['user_name'].'~'.$this->fields_arr['blog_name'];
			$rs = $this->dbObj->Execute($stmt, array($action_value));
			if (!$rs)
				trigger_db_error($this->dbObj);

			return true;
		}
		public function removeFile()
		{
			@unlink($this->logo_image_path);
		}

		public function removeBlogImageExt()
		{
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['blogs'].
						' SET blog_logo_ext=\'\', width=\'0\', height=\'0\''.
						' WHERE blog_id='.$this->dbObj->Param('blog_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_id']));
			if (!$rs)
					trigger_db_error($this->dbObj);

			$this->setPageBlockShow('block_msg_form_success');
			$this->setCommonSuccessMsg($this->LANG['manageblog_deleted_success']);
		}
		/**
		 * manageBlog::__destruct()
		 *
		 */
		public function __destruct()
		{
			unset($this->blog_logo_ext);
			unset($this->logo_image_path);
		}
		/**
		 * manageBlog::chkValidBlogFileType()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 **/
		public function chkValidBlogFileType($field_name, $err_tip = '')
		{
			$this->chkValidFileType($field_name, $this->CFG['admin']['members_profile']['image_format_arr'], $err_tip = '');
		}
		/**
		 * manageBlog::chkValidBlogFileSize()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 **/
		public function chkValidBlogFileSize($field_name, $err_tip='')
		{
			if($this->CFG['admin']['blog']['max_size'])
				{
					$max_size = $this->CFG['admin']['blog']['max_size']*1024*1024;
					if ($_FILES[$field_name]['size'] > $max_size)
						{
							$this->fields_err_tip_arr[$field_name] = $err_tip;
							return false;
						}
				}
			return true;
		}
	}

$manageblog = new manageBlog();
if(!chkAllowedModule(array('blog')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$manageblog->setMediaPath('../');


$manageblog->setPageBlockNames(array('block_logo_image_display'));

$manageblog->setFormField('blog_id','');
$manageblog->setFormField('blog_name','');
$manageblog->setFormField('blog_title','');
$manageblog->setFormField('blog_slogan','');
$manageblog->setFormField('blog_logo_ext','');
$manageblog->setFormField('blog_status','');
$manageblog->setFormField('width','');
$manageblog->setFormField('height','');
$manageblog->setFormField('action','');

$manageblog->setAllPageBlocksHide();
$manageblog->imageFormat = implode(',',$CFG['admin']['blog']['logo_image_format_arr']);

$logo_folder=$manageblog->media_relative_path.$CFG['media']['folder'].'/'.
													$CFG['admin']['blog']['folder'].'/'.
													$CFG['admin']['blog']['blog_logo_folder'].'/';

$manageblog->chkBlogsAddedByUser();
$manageblog->sanitizeFormInputs($_REQUEST);
if($manageblog->isPageGETed($_POST, 'addBlog'))
	{
		$manageblog->chkIsNotEmpty('blog_name', $LANG['common_err_tip_compulsory']) AND
			 $manageblog->chkIsAlphaNumeric('blog_name', $LANG['manageblog_err_tip_invalid_blog_name']) AND
			 	 $manageblog->chkIsValidSize('blog_name', 'blog_name', $LANG['common_err_tip_invalid_size']) AND
					$manageblog->chkBlogNameExists('blog_name', $LANG['manageblog_err_tip_blog_already_exists']);

		$manageblog->chkIsNotEmpty('blog_title', $LANG['common_err_tip_compulsory']);

		if($_FILES['blog_logo_image']['name'] != '')
				{
					$manageblog->chkValidBlogFileType('blog_logo_image',$LANG['manageblog_err_tip_invalid_file_type']) and
						$manageblog->chkValidBlogFileSize('blog_logo_image',$LANG['manageblog_err_tip_invalid_file_size']) and
							$manageblog->chkErrorInFile('blog_logo_image',$LANG['manageblog_err_tip_invalid_file']);

				}
		if($manageblog->isValidFormInputs())
			{

				$insert_blog_id=$manageblog->insertBlogDetail();
				$manageblog->addBlogCreatedActivity($insert_blog_id);
				if($_FILES['blog_logo_image']['name'] != '')
				{
					$extern = strtolower(substr($_FILES['blog_logo_image']['name'], strrpos($_FILES['blog_logo_image']['name'], '.')+1));
					$imageObj = new ImageHandler($_FILES['blog_logo_image']['tmp_name']);
					$manageblog->setIHObject($imageObj);
					$image_name = $insert_blog_id;
					$temp_dir =$manageblog->media_relative_path.$CFG['media']['folder'].'/'.
													$CFG['admin']['blog']['folder'].'/'.
													$CFG['admin']['blog']['blog_logo_folder'].'/';
					$manageblog->chkAndCreateFolder($temp_dir);
					$temp_file = $temp_dir.$image_name;
					$manageblog->storeImagesTempServer($temp_file, $extern);
					$manageblog->setFormField('blog_logo_ext', $extern);
					$manageblog->updateBlogImageExt($CFG['user']['user_id'],$extern);
					if($manageblog->getFormField('blog_logo_ext'))
					  {
					   $manageblog->is_logo_image =true;
					   $manageblog->logo_image_path =$logo_folder.$insert_blog_id.'.'.$manageblog->getFormField('blog_logo_ext').'?'.time();
					   }
					else
					   {
						$manageblog->is_logo_image =false;
					   }

				}
				$manageblog->setPageBlockShow('block_msg_form_success');
				$manageblog->setCommonSuccessMsg($LANG['manageblog_success_created_message']);

			}
		else
			{
				$manageblog->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$manageblog->setPageBlockShow('block_msg_form_error');
			}

	}
if($manageblog->isPageGETed($_POST, 'updateBlog'))
	{
		$manageblog->chkIsNotEmpty('blog_name', $LANG['common_err_tip_compulsory']) AND
			 $manageblog->chkIsAlphaNumeric('blog_name', $LANG['manageblog_err_tip_invalid_blog_name']) AND
			 	 $manageblog->chkIsValidSize('blog_name', 'blog_name', $LANG['common_err_tip_invalid_size']) AND
					$manageblog->chkBlogNameExists('blog_name', $LANG['manageblog_err_tip_blog_already_exists'],$manageblog->getFormField('blog_id'));
		$manageblog->chkIsNotEmpty('blog_title', $LANG['common_err_tip_compulsory']);

		if($_FILES['blog_logo_image']['name'] != '')
				{
					$manageblog->chkValidBlogFileType('blog_logo_image',$LANG['manageblog_err_tip_invalid_file_type']) and
						$manageblog->chkValidBlogFileSize('blog_logo_image',$LANG['manageblog_err_tip_invalid_file_size']) and
							$manageblog->chkErrorInFile('blog_logo_image',$LANG['manageblog_err_tip_invalid_file']);

				}
		if($manageblog->isValidFormInputs())
			{

				$manageblog->updateBlogDetail($manageblog->getFormField('blog_id'));
				if($_FILES['blog_logo_image']['name'] != '')
				{
					$extern = strtolower(substr($_FILES['blog_logo_image']['name'], strrpos($_FILES['blog_logo_image']['name'], '.')+1));
					$imageObj = new ImageHandler($_FILES['blog_logo_image']['tmp_name']);
					$manageblog->setIHObject($imageObj);
					$image_name = $manageblog->getFormField('blog_id');
					$temp_dir =$manageblog->media_relative_path.$CFG['media']['folder'].'/'.
													$CFG['admin']['blog']['folder'].'/'.
													$CFG['admin']['blog']['blog_logo_folder'].'/';
					$manageblog->chkAndCreateFolder($temp_dir);
					$temp_file = $temp_dir.$image_name;
					$manageblog->storeImagesTempServer($temp_file, $extern);
					$manageblog->setFormField('blog_logo_ext', $extern);
					$manageblog->updateBlogImageExt($CFG['user']['user_id'],$extern);
					if($manageblog->getFormField('blog_logo_ext'))
					  {
					   $manageblog->is_logo_image =true;
					   $manageblog->logo_image_path =$logo_folder.$manageblog->getFormField('blog_id').'.'.$manageblog->getFormField('blog_logo_ext').'?'.time();
					   }
					else
					   {
						$manageblog->is_logo_image =false;
					   }

				}
				$manageblog->setPageBlockShow('block_msg_form_success');
				$manageblog->setCommonSuccessMsg($LANG['manageblog_success_updated_message']);

			}
		else
			{
				$manageblog->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$manageblog->setPageBlockShow('block_msg_form_error');
			}
	}
if($manageblog->getFormField('action')=='delete')
	{
		$manageblog->removeFile();
		$manageblog->removeBlogImageExt($manageblog->getFormField('blog_id'));
		$manageblog->setFormField('blog_logo_ext','');
		$manageblog->is_logo_image =false;
	}
if($manageblog->isPageGETed($_POST, 'cancelBlogMangage'))
	{
		Redirect2URL(getUrl('bloglist','','','','blog'));
	}
$LANG['manageblog_blog_name_with_size'] = str_replace('{min_count}', $CFG['fieldsize']['blog_name']['min'], $LANG['manageblog_blog_name_with_size']);
$LANG['manageblog_blog_name_with_size'] = str_replace('{max_count}', $CFG['fieldsize']['blog_name']['max'], $LANG['manageblog_blog_name_with_size']);
$manageblog->LANG['help']['blog_name'] =$LANG['manageblog_blog_name_with_size'];

$LANG['manageblog_blog_name_lbl'] = str_replace('{min_count}', $CFG['fieldsize']['blog_name']['min'], $LANG['manageblog_blog_name_lbl']);
$LANG['manageblog_blog_name_lbl'] = str_replace('{max_count}', $CFG['fieldsize']['blog_name']['max'], $LANG['manageblog_blog_name_lbl']);
$manageblog->LANG['manageblog_blog_name_lbl'] =$LANG['manageblog_blog_name_lbl'];


if(!$manageblog->blogadded)
$manageblog->manageblog_blog_name_lang=$LANG['manageblog_blog_name_lbl'];
else
$manageblog->manageblog_blog_name_lang=$LANG['manageblog_blog_name_lbl'];

if($manageblog->is_logo_image)
$manageblog->setPageBlockShow('block_logo_image_display');
//include the header file
$manageblog->includeHeader();
//include the content of the page
setTemplateFolder('members/', $CFG['site']['is_module_page']);
$smartyObj->display('manageBlog.tpl');
?>
<script type="text/javascript">
var block_arr= new Array('selMsgConfirm');

function cancelRedirect()
{
	var redirectUrl='<?php echo $manageblog->getUrl('bloglist','','','','blog'); ?>';
	location.href=redirectUrl;
}
</script>
<?php
/* Added code to validate mandataory fields in photo defaut settings page */
if ($CFG['feature']['jquery_validation'])
{
$allowed_image_formats = implode("|", $CFG['admin']['members_profile']['image_format_arr']);
?>
<script type="text/javascript">
$Jq("#manageBlogFrm").validate({
	rules: {
	    blog_name: {
	    	required: true,
	    	checkSpecialChr: true,
	    	minlength: <?php echo $CFG['fieldsize']['blog_name']['min']; ?>,
			maxlength: <?php echo $CFG['fieldsize']['blog_name']['max']; ?>
		 },
	    blog_title: {
	    	required: true
	    },
	    blog_logo_image: {
	    	isValidFileFormat: "<?php echo $allowed_image_formats; ?>"
	    }
	},
	messages: {
		blog_name: {
			required: "<?php echo $LANG['common_err_tip_required'];?>"
		},
		blog_title: {
			required: "<?php echo $LANG['common_err_tip_required'];?>"
		},
		blog_logo_image: {
			isValidFileFormat: "<?php echo $manageblog->LANG['common_err_tip_invalid_image_format']; ?>"
		}
	}
});
</script>
<?php
}
$manageblog->includeFooter();
?>
