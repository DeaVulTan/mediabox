<?php
/**
 * This file hadling the favicon settings
 *
 * Favicon settings used to change favicon for various template themes
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/faviconSettings.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Parser.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class EditTemplateSettings begins -------------------->>>>>//
/**
 * This class hadling the favicon settings
 *
 * @category	Rayzz
 * @package		Admin
 */
class EditFaviconSettings extends FormHandler
	{
		/**
		 * EditFaviconSettings::populateTemplateCssDetails()
		 * To populate template and css details to default option field
		 *
		 * @return 	array
		 * @access 	public
		 */
		public function populateTemplateCssDetails()
			{
				$dir_array = readDirectory($this->CFG['site']['project_path']. 'design/templates/', 'dir');
				$template_arr = array();
				foreach($dir_array as $template)
					{
						$template_arr[$template] = readDirectory($this->CFG['site']['project_path']. 'design/templates/'.$template.'/root/css/', 'dir');
					}
				return $template_arr;
			}

		/**
		 * EditFaviconSettings::populateTemplates()
		 * To populate the templates list
		 *
		 * @return 	array
		 * @access 	public
		 */
		public function populateTemplates()
			{
				$dir_array = readDirectory($this->CFG['site']['project_path']. 'design/templates/', 'dir');
				$template_arr = array();
				foreach($dir_array as $template)
					{
						$template_arr[] = $template;
					}
				return $template_arr;
			}

		/**
		 * EditFaviconSettings::populateCssDetails()
		 * To populate the css list under the given template
		 *
		 * @param  string $template template name
		 * @return 	array
		 * @access 	public
		 */
		public function populateCssDetails($template)
			{
				$css_array = readDirectory($this->CFG['site']['project_path']. 'design/templates/'.$template.'/root/css/', 'dir');
				foreach($css_array as $css)
					{
						$css_files_array[] = $css.'.css';
					}
                return $css_files_array;
			}


		/**
		 * EditFaviconSettings::unlinkSiteFavicon()
		 * To unlink the exisitng site favicon
		 *
		 * @param  string $template template name
		 * @return 	array
		 * @access 	public
		 */
		public function unlinkSiteFavicon($dir_name)
			{
				if(is_dir($dir_name))
				{
					if ($hndDir = opendir($dir_name))
					{
						while (false !== ($strFilename = readdir($hndDir)))
						{
							if ($strFilename != "." && $strFilename != "..")
							{
								$log_file_name = $strFilename;
								$extern = substr($log_file_name,strrpos($log_file_name, '.')+1);
			 					$original_file_name = substr($log_file_name, 0,strrpos($log_file_name, '.'));
			 					//Condition checked while unlinking image when files are in svn path
			 					if($original_file_name == 'favicon')
									unlink($dir_name.$strFilename);
							}
						}
						closedir($hndDir);
					}
				}
			}

		/**
		 * EditFaviconSettings::chkFileNameIsNotEmpty()
		 *
		 * @param mixed $field_name
		 * @param string $err_tip
		 * @return
		 */
		public function chkFileNameIsNotEmpty($field_name, $err_tip = '')
			{
				if(!$_FILES[$field_name]['name'])
					{
						$this->setFormFieldErrorTip($field_name,$err_tip);
						return false;
					}
				return true;
			}

		/**
		 * EditFaviconSettings::chkValideFileSize()
		 *
		 * @param mixed $field_name
		 * @param string $err_tip
		 * @return
		 */
		public function chkValideFileSize($field_name, $err_tip='')
			{
				$image_size = getimagesize($_FILES[$field_name]['tmp_name']);
				$image_width = $image_size[0];
				$image_height = $image_size[1];
				if (($image_width == $this->CFG['admin']['site']['favicon_image_max_width']) && ($image_height == $this->CFG['admin']['site']['favicon_image_max_height']))
					{
						return true;
					}
				else
					{
						$this->fields_err_tip_arr[$field_name] = $err_tip;
						return false;
					}

			}

		/**
		 * EditFaviconSettings::chkErrorInFile()
		 *
		 * @param mixed $field_name
		 * @param string $err_tip
		 * @return
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
		 * EditFaviconSettings::getSiteFavicon()
		 *  To get site favicon
		 * @return string
		 */
		public function getSiteFavicon($dir_name)
		{
			$image_extn='';
			if(is_dir($dir_name))
			{
				if ($hndDir = opendir($dir_name))
				{
					while (false !== ($strFilename = readdir($hndDir)))
					{
						if ($strFilename != "." && $strFilename != "..")
						{
							$log_file_name = $strFilename;
							$extern = substr($log_file_name,strrpos($log_file_name, '.')+1);
			 				$original_file_name = substr($log_file_name, 0,strrpos($log_file_name, '.'));
			 				if($original_file_name == 'favicon')
			 				{
								$image_extn =  $extern;
							}
						}
					}
					closedir($hndDir);
					return $image_extn;
				}
			}
		}

		/**
		 * EditFaviconSettings::changeArrayToCommaSeparator()
		 *
		 * @param array $arry_value
		 * @return
		 */
		public function changeArrayToCommaSeparator($arry_value = array())
			{
				return implode(',',$arry_value);
			}


	  	/**
		 * EditFaviconSettings::resetFieldValues()
		 * To initialize the form field values
		 *
		 * @return
		 * @access 	public
		 */
		public function resetFieldValues()
           {
                $this->setFormField('default_screen', $this->CFG['html']['template']['default'].'__'.$this->CFG['html']['stylesheet']['screen']['default']);
                $this->setFormField('temp_arr', $this->CFG['html']['template']['allowed']);
                $this->setFormField('css_arr', $this->CFG['html']['stylesheet']['allowed']);
           }
	}
//<<<<<--------------------- Class EditTemplateSettings ends ------------------------//
//------------------ Code begins------------------>>>//
$faviconSetting = new EditFaviconSettings();
$faviconSetting->setPageBlockNames(array('show_config_variable'));
$faviconSetting->setFormField('default_screen', '');
$faviconSetting->setFormField('temp_arr', array());
$faviconSetting->setFormField('css_arr', array());
$faviconSetting->setFormField('image_ext', '');
$faviconSetting->setFormField('site_favicon', '');
$faviconSetting->CFG['admin']['site']['favicon_image_format_arr'] = array('ico');
$faviconSetting->CFG['admin']['site']['favicon_image_max_width'] = 16;
$faviconSetting->CFG['admin']['site']['favicon_image_max_height'] = 16;
$faviconSetting->setAllPageBlocksHide();
$faviconSetting->sanitizeFormInputs($_REQUEST);

if (isAjaxPage())
{
	if(isset($_POST['favicon']) && (!empty($_POST['favicon'])))
	{
		$favicon_arr = explode('__',$_POST['favicon']);
		$favicondir = $CFG['site']['project_path'].'design/templates/'.$favicon_arr[0].'/root/images/'.$favicon_arr[1].'/header/favicon/';
		$favicon_extn = $faviconSetting->getSiteFavicon($favicondir);
		echo $image_src = '<img src="'.$CFG['site']['url'].'design/templates/'.$favicon_arr[0].'/root/images/'.$favicon_arr[1].'/header/favicon/favicon.'.$favicon_extn.'"'.'>';
		exit;
	}
}
else
{
	$favicondir = $CFG['site']['project_path'].'design/templates/'.$CFG['html']['template']['temp_default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['temp_default'].'/header/favicon/';
	$favicon_extn = $faviconSetting->getSiteFavicon($favicondir);
	$favicon_image = '<img src="'.$CFG['site']['url'].'design/templates/'.$CFG['html']['template']['temp_default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['temp_default'].'/header/favicon/favicon.'.$favicon_extn.'"'.'>';
}


if ($faviconSetting->isFormPOSTed($_POST, 'edit_submit'))
	{
		$selected_template_theme_arr = explode('__', $faviconSetting->getFormField('default_screen'));
		if($CFG['admin']['is_demo_site'])
			{
				$faviconSetting->setCommonErrorMsg($faviconSetting->LANG['general_config_not_allow_demo_site']);
				$faviconSetting->setPageBlockShow('block_msg_form_error');
			}
		else
			{
				$faviconSetting->chkIsNotEmpty('default_screen', $LANG['common_err_tip_required']);
				$faviconSetting->chkFileNameIsNotEmpty('site_favicon', $LANG['common_err_tip_required']) and
				$faviconSetting->chkValidFileType('site_favicon', $faviconSetting->CFG['admin']['site']['favicon_image_format_arr'], $LANG['common_err_tip_invalid_image_format']) and
				$faviconSetting->chkValideFileSize('site_favicon',$LANG['common_err_tip_invalid_file_size']) and
				$faviconSetting->chkErrorInFile('site_favicon',$LANG['common_err_tip_invalid_image']);


				if($faviconSetting->isValidFormInputs())
				 	{
					    $extern = strtolower(substr($_FILES['site_favicon']['name'], strrpos($_FILES['site_favicon']['name'], '.')+1));
						$image_name = 'favicon';
						$temp_dir = $CFG['site']['project_path'].'design/templates/'.$selected_template_theme_arr[0].'/root/images/'.$selected_template_theme_arr[1].'/header/favicon/';
						$faviconSetting->chkAndCreateFolder($temp_dir);
						$image_storePath = $temp_dir.$image_name.'.'.$extern;
						$faviconSetting->unlinkSiteFavicon($temp_dir);
						move_uploaded_file($_FILES['site_favicon']['tmp_name'], $image_storePath);
						$faviconSetting->setFormField('image_ext', $extern);
						$faviconSetting->setAllPageBlocksHide();
						$faviconSetting->setPageBlockShow('show_config_variable');
						$faviconSetting->setPageBlockShow('block_msg_form_success');
						$faviconSetting->setCommonSuccessMsg($LANG['faviconsetting_success_update_message']);
				  	}
				else
				  	{
				   	 	$faviconSetting->setAllPageBlocksHide();
					 	$faviconSetting->setPageBlockShow('block_msg_form_error');
					 	$faviconSetting->setCommonErrorMsg($LANG['common_msg_error_sorry']);
					 	$faviconSetting->setPageBlockShow('show_config_variable');
				  	}
			}
	}
else
	{
		$faviconSetting->resetFieldValues();
    }
$faviconSetting->setPageBlockShow('show_config_variable');
//<<<<<---------------------Code ends------------------//
//-----------------Page block template begins----------->>>>>//
if ($faviconSetting->isShowPageBlock('show_config_variable'))
	{
		$smartyObj->assign('template_arr12', $faviconSetting->populateTemplateCssDetails());
     }
$faviconSetting->left_navigation_div = 'generalSetting';
$faviconSetting->logoSettingUrl = $CFG['site']['url'].'admin/logoSettings.php';
//<<<<<<--------------------Page block templates Ends--------------------//
$faviconSetting->includeHeader();
setTemplateFolder('admin/');
$smartyObj->display('faviconSettings.tpl');
?>
<script type="text/javascript">
function populateFaviconImage(template_theme)
{
	var site_url = '<?php echo $CFG['site']['url'];?>';
	var template_default = '<?php echo $CFG['html']['template']['default']; ?>';
	var screen_default = '<?php echo $CFG['html']['stylesheet']['screen']['default']; ?>';
	var loadingImage = "<img src='"+site_url+"/design/templates/"+template_default+"/admin/images/"+screen_default+"/loading.gif"+"' alt='loading'\/>";
	var url = '<?php echo $CFG['site']['current_url'];?>';
	var pars = 'ajax_page=true&favicon='+template_theme;
	var method_type = 'post';
	$Jq.ajax({
			type: method_type,
			url: url,
			data: pars,
				beforeSend:function(){
				$Jq('#faviconImage').html(loadingImage);
			},
			success:function (data){
				$Jq('#faviconImage').html(data);
			}
		});
}
</script>
<?php
if(!isAjaxPage())
{
?>
<script type="text/javascript">
	data = '<?php echo $favicon_image; ?>';
	$Jq('#faviconImage').html(data);
</script>
<?php
}
$faviconSetting->includeFooter();
?>