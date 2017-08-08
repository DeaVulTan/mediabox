<?php
require_once('../common/configs/config.inc.php');
$CFG['site']['is_module_page'] = 'article';
$CFG['lang']['include_files'][] = 'languages/%s/article/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/pageBreakPopUp.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['auth']['is_authenticate'] = 'members';
if(isset($_REQUEST['ajax_page']) and $_REQUEST['ajax_page'])
	{
		$CFG['mods']['is_include_only']['non_html_header_files'] = true;
	}
else
	{
		$CFG['html']['header'] = 'general/html_header_popup.php';
		$CFG['html']['footer'] = 'general/html_footer_popup.php';
		$CFG['mods']['is_include_only']['html_header'] = false;
		$CFG['html']['is_use_header'] = false;

	}
require($CFG['site']['project_path'].'common/application_top.inc.php');

class ImageList extends FormHandler
	{
		public function populateImage()
			{
				//$dirname='../files/article_avatar/';
				$this->CFG['site']['url'];
				$dirname1 = '../'.$this->CFG['admin']['articles']['article_image_folder'].$this->CFG['user']['user_id'].'/';
				$dirname2 = '../'.$this->CFG['admin']['articles']['temp_article_image_folder'].$this->CFG['user']['user_id'].'/';
				$dirname3 = $this->CFG['site']['url'].$this->CFG['admin']['articles']['article_image_folder'].$this->CFG['user']['user_id'].'/';
				$dirname4 = $this->CFG['site']['url'].$this->CFG['admin']['articles']['temp_article_image_folder'].$this->CFG['user']['user_id'].'/';
				$dirname = array($dirname1,$dirname2,$dirname3,$dirname4);

				$pattern = "\.(jpg|jpeg|png|gif|bmp)$";
				$files = array();
				$imageDetail = array();
				$curimage = 0;
				$inc = 0;
				for($i=0;$i<=1;$i++)
				{
					$this->chkAndCreateFolder($dirname[$i]);
				    if($handle = opendir($dirname[$i]))
						{
						   while(false !== ($file = readdir($handle)))
						   {
								if(eregi($pattern, $file))
								{

									$imageDetail[$inc]['image_path']=$dirname[$i+2].$file;
									$imageDetail[$inc]['image_name']=$file;
								}
								$inc++;
					       }
					      closedir($handle);
					    }
				}
				return $imageDetail;
			}
	}
$ImageList = new ImageList();
$ImageList->setPageBlockNames(array('image_list_block'));
$smartyObj->assign('file_array', $ImageList->populateImage());
//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$ImageList->includeIframeHeader();
?>
<script type="text/javascript">
	var ImageManager = parent.ImageManager;
</script>
<?php
//include the content of the page
setTemplateFolder('members/', 'article');
$smartyObj->display('imageList.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$ImageList->includeIframeFooter();
?>