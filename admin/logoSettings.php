<?php
/**
 * This file hadling the logo settings
 *
 * logo settings used to change logo for various templates
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/logoSettings.php';
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
 * This class hadling the logo settings
 *
 * @category	Rayzz
 * @package		Admin
 */
class EditLogoSettings extends FormHandler
	{
		/**
		 * EditLogoSettings::populateTemplateCssDetails()
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
		 * EditLogoSettings::populateTemplates()
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
		 * EditLogoSettings::populateCssDetails()
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
		 * EditLogoSettings::unlinkSiteLogo()
		 * To unlink the exisitng site logo
		 *
		 * @param  string $template template name
		 * @return 	array
		 * @access 	public
		 */
		public function unlinkSiteLogo($dir_name)
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
			 					if($original_file_name == 'logo')
									unlink($dir_name.$strFilename);
							}
						}
						closedir($hndDir);
					}
				}
			}

		/**
		 * EditLogoSettings::chkFileNameIsNotEmpty()
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
		 * EditLogoSettings::chkValideFileSize()
		 *
		 * @param mixed $field_name
		 * @param string $err_tip
		 * @return
		 */
		public function chkValideFileSize($field_name, $err_tip='')
			{
				$max_size = $this->CFG['admin']['site']['logo_image_max_size'] * 1024;
				if ($_FILES[$field_name]['size'] > $max_size)
					{
						$this->fields_err_tip_arr[$field_name] = $err_tip;
						return false;
					}
				return true;
			}

		/**
		 * EditLogoSettings::chkErrorInFile()
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
		 * EditLogoSettings::changeArrayToCommaSeparator()
		 *
		 * @param array $arry_value
		 * @return
		 */
		public function changeArrayToCommaSeparator($arry_value = array())
			{
				return implode(',',$arry_value);
			}


	  	/**
		 * EditLogoSettings::resetFieldValues()
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

        /**
		 * EditLogoSettings::getSiteLogo()
		 *  To get site logo
		 * @return string
		 */
		public function getSiteLogo($dir_name)
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
			 				if($original_file_name == 'logo')
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
	}
//<<<<<--------------------- Class EditTemplateSettings ends ------------------------//
//------------------ Code begins------------------>>>//
$logoSetting = new EditLogoSettings();
$logoSetting->setPageBlockNames(array('show_config_variable'));
$logoSetting->setFormField('default_screen', '');
$logoSetting->setFormField('temp_arr', array());
$logoSetting->setFormField('css_arr', array());
$logoSetting->setFormField('image_ext', '');
$logoSetting->setFormField('site_logo', '');
$logoSetting->CFG['admin']['site']['logo_image_format_arr'] = array('jpg', 'jpeg', 'gif', 'png');
$logoSetting->CFG['admin']['site']['logo_image_max_size'] = 500;
$logoSetting->setAllPageBlocksHide();
$logoSetting->sanitizeFormInputs($_REQUEST);

if (isAjaxPage())
{
	if(isset($_POST['logo']) && (!empty($_POST['logo'])))
	{
		$logo_arr = explode('__',$_POST['logo']);
		$logodir = $CFG['site']['project_path'].'design/templates/'.$logo_arr[0].'/root/images/'.$logo_arr[1].'/header/logo/';
		$logo_extn = $logoSetting->getSiteLogo($logodir);
		$width = isset($CFG['admin'][$logo_arr[0]]['logo_width'])? $CFG['admin'][$logo_arr[0]]['logo_width'] : '200';
		$height = isset($CFG['admin'][$logo_arr[0]]['logo_height'])? $CFG['admin'][$logo_arr[0]]['logo_height'] :'100';
		$image_src = '<img src="'.$CFG['site']['url'].'design/templates/'.$logo_arr[0].'/root/images/'.$logo_arr[1].'/header/logo/logo.'.$logo_extn.'"'.'>';
		echo $image_src.'~~'.$width.'~~'.$height;
		exit;
	}
}
else
{
	$logodir = $CFG['site']['project_path'].'design/templates/'.$CFG['html']['template']['temp_default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['temp_default'].'/header/logo/';
	$logo_extn = $logoSetting->getSiteLogo($logodir);
	$image_src = '<img src="'.$CFG['site']['url'].'design/templates/'.$CFG['html']['template']['temp_default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['temp_default'].'/header/logo/logo.'.$logo_extn.'"'.'>';
	$width = isset($CFG['admin'][$CFG['html']['template']['default']]['logo_width'])? $CFG['admin'][$CFG['html']['template']['default']]['logo_width'] : '200';
	$height = isset($CFG['admin'][$CFG['html']['template']['default']]['logo_height'])? $CFG['admin'][$CFG['html']['template']['default']]['logo_height'] :'100';
	$logo_image = $image_src.'~~'.$width.'~~'.$height;
}

if ($logoSetting->isFormPOSTed($_POST, 'edit_submit'))
	{
		$selected_template_theme_arr = explode('__', $logoSetting->getFormField('default_screen'));
		if($CFG['admin']['is_demo_site'])
			{
				$logoSetting->setCommonErrorMsg($logoSetting->LANG['general_config_not_allow_demo_site']);
				$logoSetting->setPageBlockShow('block_msg_form_error');
			}
		else
			{
				$logoSetting->chkIsNotEmpty('default_screen', $LANG['common_err_tip_required']);
				$logoSetting->chkFileNameIsNotEmpty('site_logo', $LANG['common_err_tip_required']) and
				$logoSetting->chkValidFileType('site_logo', $logoSetting->CFG['admin']['site']['logo_image_format_arr'], $LANG['common_err_tip_invalid_image_format']) and
				$logoSetting->chkValideFileSize('site_logo',$LANG['common_err_tip_invalid_file_size']) and
				$logoSetting->chkErrorInFile('site_logo',$LANG['common_err_tip_invalid_image']);

				if($logoSetting->isValidFormInputs())
				 	{
					    $extern = strtolower(substr($_FILES['site_logo']['name'], strrpos($_FILES['site_logo']['name'], '.')+1));
						$image_name = 'logo';
						$temp_dir = $CFG['site']['project_path'].'design/templates/'.$selected_template_theme_arr[0].'/root/images/'.$selected_template_theme_arr[1].'/header/logo/';
						$logoSetting->chkAndCreateFolder($temp_dir);
						$image_storePath = $temp_dir.$image_name.'.'.$extern;
						$logoSetting->unlinkSiteLogo($temp_dir);
						move_uploaded_file($_FILES['site_logo']['tmp_name'], $image_storePath);
						$logoSetting->setFormField('image_ext', $extern);
						$logoSetting->setAllPageBlocksHide();
						$logoSetting->setPageBlockShow('show_config_variable');
						$logoSetting->setPageBlockShow('block_msg_form_success');
						$logoSetting->setCommonSuccessMsg($LANG['logosetting_success_update_message']);
				  	}
				else
				  	{
				   	 	$logoSetting->setAllPageBlocksHide();
					 	$logoSetting->setPageBlockShow('block_msg_form_error');
					 	$logoSetting->setCommonErrorMsg($LANG['common_msg_error_sorry']);
					 	$logoSetting->setPageBlockShow('show_config_variable');
				  	}
			}
	}
else
	{
		$logoSetting->resetFieldValues();
    }
$logoSetting->setPageBlockShow('show_config_variable');
//<<<<<---------------------Code ends------------------//
//-----------------Page block template begins----------->>>>>//
if ($logoSetting->isShowPageBlock('show_config_variable'))
	{
		$smartyObj->assign('template_arr12', $logoSetting->populateTemplateCssDetails());
     }
$logoSetting->left_navigation_div = 'generalSetting';
$logoSetting->faviconSettingUrl = $CFG['site']['url'].'admin/faviconSettings.php';
//<<<<<<--------------------Page block templates Ends--------------------//
$logoSetting->includeHeader();
setTemplateFolder('admin/');
$smartyObj->display('logoSettings.tpl');
?>
<script type="text/javascript">
function populateLogoImage(template_theme)
{
	var site_url = '<?php echo $CFG['site']['url'];?>';
	var template_default = '<?php echo $CFG['html']['template']['default']; ?>';
	var screen_default = '<?php echo $CFG['html']['stylesheet']['screen']['default']; ?>';
	var loadingImage = "<img src='"+site_url+"/design/templates/"+template_default+"/admin/images/"+screen_default+"/loading.gif"+"' alt='loading'\/>";
	var url = '<?php echo $CFG['site']['current_url'];?>';
	var pars = 'ajax_page=true&logo='+template_theme;
	var method_type = 'post';
	$Jq.ajax({
			type: method_type,
			url: url,
			data: pars,
				beforeSend:function(){
				$Jq('#logoImage').html(loadingImage);
			},
			success:function (data){
				data = data.split("~~");
				$Jq('#logoImage').html(data[0]);
				$Jq('#logoWidth').html(data[1]);
				$Jq('#logoHeight').html(data[2]);
			}
		});
}
</script>
<?php
if(!isAjaxPage())
{
?>
<script type="text/javascript">
	data = '<?php echo $logo_image; ?>';
	data = data.split("~~");
	$Jq('#logoImage').html(data[0]);
	$Jq('#logoWidth').html(data[1]);
	$Jq('#logoHeight').html(data[2]);
</script>
<?php
}
$logoSetting->includeFooter();
?>