<?php
/**
 * This file is use for manage Search Settings
 *
 * This file is having Manage set as default search module,status changes, priority change
 *
 *
 * @category	Rayzz
 * @package		Admin
 *
 **/
require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/photo/admin/waterMarkSetting.php';
$CFG['mods']['include_files'][] = 'common/classes/class_CreateTextImage.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['site']['is_module_page'] = 'photo';
require($CFG['site']['project_path'].'common/application_top.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_templates.inc.php');
//---------------------------- Class SearchSettingsHandler begins -------------------->>>>>//
/**
 *
 * @category	rayzz
 * @package		Admin
 **/
class watermarkSettingsHandler extends MediaHandler
{

	/**
	* watermarkSettingsHandler::setIHObject()
	*
	* @param mixed $imObj
	* @return void
	*/
	public function setIHObject($imObj)
	{
		$this->imageObj = $imObj;
	}

	/**
	 * watermarkSettingsHandler::chkFileIsNotEmpty()
	 *
	 * @param string $field_name
	 * @param string $err_tip
	 * @return boolean
	 */
	public function chkFileIsNotEmpty($field_name, $err_tip = '')
	{
		if(!isset($_FILES[$field_name]))
			{
				$this->setFormFieldErrorTip($field_name, $err_tip);
				return false;
			}
		return true;
	}

	/**
	 * watermarkSettingsHandler::chkFileNameIsNotEmpty()
	 *
	 * @param string $field_name
	 * @param string $err_tip
	 * @return boolean
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
	* watermarkSettingsHandler::chkValideFileSize()
	*
	* @param string $field_name
	* @param string $err_tip
	* @return boolean
	*/
	public function chkValideFileSize($field_name, $err_tip='')
	{
		$extern = strtolower(substr($_FILES[$field_name]['name'], strrpos($_FILES[$field_name]['name'], '.')+1));
		if($extern!='')
		{
			$max_size = $this->CFG['admin']['watermark']['water_mark_max_size'] * 1024;
			if ($_FILES[$field_name]['size'] > $max_size)
			{
				$this->fields_err_tip_arr[$field_name] = $err_tip;
				return false;
			}
		}
		return true;
	}

	/**
	 * watermarkSettingsHandler::chkErrorInFile()
	 *
	 * @param string $field_name
	 * @param string $err_tip
	 * @return boolean
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

	/**
	 * templateSettingsHandler::setDefaultArray()
	 *
	 * @return
	 **/

	public function setDefaultArray()
	{
		$this->templateArray = $this->CFG['html']['template']['allowed'];
	}
	/**
	 * templateSettingsHandler::generalPopulateTemplateArray()
	 *
	 * @return
	 **/
	public function generalPopulateTemplateArray($list, $highlight_value='')
	{

		foreach($list as $value)
		{
			$selected = trim($highlight_value) == trim($value)?' selected="selected"':'';
?>
<option value="<?php echo $value;?>"<?php echo $selected;?>><?php echo $value;?></option>
<?php
		}
	}
	/**
	 * templateSettingsHandler::writeTemplateValues()
	 *
	 * @return
	 **/
	public function writeTemplateValues()
	{
		$handle = fopen($this->CFG['site']['project_path'].'common/configs/config_templates.inc.php', 'r+');
		if ($handle) {
			$newValue = '';
		    while (!feof($handle)) {
		        $buffer = fgets($handle, 4096);
		        $valuearr = split('=',$buffer);

		        if(is_array($valuearr))
		        {
		        	$replacdvalue=str_replace('$','',$valuearr[0]);
		        	$is_template_support = "CFG['html']['template']['is_template_support']";
		        	$is_style_support = "CFG['html']['stylesheet']['screen']['is_style_support']";
		        	$template_default = "CFG['html']['template']['default']";
		        	$stylesheet_screen_default = "CFG['html']['stylesheet']['screen']['default']";
			        if(trim($replacdvalue)==trim($is_template_support))
					{
						if($this->getFormField('is_template_support')=='Yes')
							$value = 'true';
						if($this->getFormField('is_template_support')=='No')
							$value = 'false';
						$newValue.=trim($valuearr[0]).'='.$value.';'."\n";
					}
					elseif(trim($replacdvalue)==trim($is_style_support))
					{
						if($this->getFormField('is_style_support')=='Yes')
							$value = 'true';
						if($this->getFormField('is_style_support')=='No')
							$value = 'false';
						$newValue.=trim($valuearr[0]).'='.$value.';'."\n";
					}
					elseif(trim($replacdvalue)==trim($template_default))
					{
						$newValue.=trim($valuearr[0]).'='."'".$this->getFormField('default_template')."'".';'."\n";
					}
					elseif(trim($replacdvalue)==trim($stylesheet_screen_default))
					{
						$newValue.=trim($valuearr[0]).'='."'".$this->getFormField('default_theme')."'".';'."\n";
					}
					else
					{
						$newValue .= $buffer;
					}
				}
				else
				{
					$newValue .= $buffer;
				}
		    }
		    fclose($handle);
		}
		$fp = fopen($this->CFG['site']['project_path'].'common/configs/config_templates.inc.php', 'w+');
		fwrite($fp, $newValue);
		fclose($fp);
	}

	public function generalPopulateColorArray($list, $highlight_value='')
	{
		foreach($list as $key=>$value)
		{
			$selected = trim($highlight_value) == trim($key)?' selected="selected"':'';
			$color    = 'background-color:'.$key;
?>
			<option value="<?php echo $key;?>"<?php echo $selected;?> style='<?php echo $color;?>' ><?php $key = empty($key)?$value:$key;echo $key;?></option>
<?php
		}
	}

	public function generalPopulateTextSizeArray($list, $highlight_value='')
	{
		foreach($list as $key=>$value)
		{
			$selected = trim($highlight_value) == trim($key)?' selected="selected"':'';
?>
			<option value="<?php echo $key;?>"<?php echo $selected;?> ><?php echo $value;?></option>
<?php
		}
	}

	/**
	 * watermarkSettingsHandler::writeTemplateValues()
	 *
	 * @return boolean
	 **/
	public function writeConfigValues()
	{
		$handle = fopen($this->CFG['site']['project_path'].'common/configs/config_photo_water_mark.inc.php', 'r+');
		if ($handle) {
			$newValue = '';
		    while (!feof($handle))
			{
		        $buffer = fgets($handle, 4096);
		        $valuearr = split('=',$buffer);

		        if(is_array($valuearr))
		        {
		        	$replacdvalue=str_replace('$','',$valuearr[0]);
		        	$water_text_image_bg_color 	 = "CFG['admin']['watermark']['water_mark_text_image_back_ground_color']";
		        	$water_text_image_text_color = "CFG['admin']['watermark']['water_mark_text_image_text_color']";
		        	$water_text_image_text_size  = "CFG['admin']['watermark']['water_mark_text_image_text_size']";
		        	$water_text_image_text       = "CFG['admin']['watermark']['water_mark_text_image_text']";
					$water_mark_type             = "CFG['admin']['watermark']['water_mark_type']";
					$water_text_image_text_xposition  = "CFG['admin']['watermark']['water_mark_text_xposition']";
					$water_text_image_text_yposition  = "CFG['admin']['watermark']['water_mark_text_yposition']";
					$water_text_image_text_width  = "CFG['admin']['watermark']['water_mark_text_width']";
					$water_text_image_text_height = "CFG['admin']['watermark']['water_mark_text_height']";

			        if(trim($replacdvalue)==trim($water_text_image_bg_color))
						$newValue.=trim($valuearr[0])."='".$this->getFormField('back_ground_color')."';"."\n";
					elseif(trim($replacdvalue)==trim($water_text_image_text_color))
						$newValue.=trim($valuearr[0])."='".$this->getFormField('text_color')."';"."\n";
					elseif(trim($replacdvalue)==trim($water_text_image_text_size))
						$newValue.=trim($valuearr[0]).'='.$this->getFormField('text_size').';'."\n";
					elseif(trim($replacdvalue)==trim($water_text_image_text_xposition))
						$newValue.=trim($valuearr[0]).'='.$this->getFormField('water_mark_text_xposition').';'."\n";
					elseif(trim($replacdvalue)==trim($water_text_image_text_yposition))
						$newValue.=trim($valuearr[0]).'='.$this->getFormField('water_mark_text_yposition').';'."\n";
					elseif(trim($replacdvalue)==trim($water_text_image_text_width))
						$newValue.=trim($valuearr[0]).'='.$this->getFormField('water_mark_text_width').';'."\n";
					elseif(trim($replacdvalue)==trim($water_text_image_text_height))
						$newValue.=trim($valuearr[0]).'='.$this->getFormField('water_mark_text_height').';'."\n";
					elseif(trim($replacdvalue)==trim($water_text_image_text))
						$newValue.=trim($valuearr[0]).'='."'".$this->getFormField('water_mark_text')."'".';'."\n";
					elseif(trim($replacdvalue)==trim($water_mark_type))
						$newValue.=trim($valuearr[0])."='font';"."\n";
					else
						$newValue .= $buffer;
				}
				else
					$newValue .= $buffer;
		    }

		    fclose($handle);
		}
		$fp = fopen($this->CFG['site']['project_path'].'common/configs/config_photo_water_mark.inc.php', 'w+');
		fwrite($fp, $newValue);
		fclose($fp);
	}

	/**
	 * watermarkSettingsHandler::writeTemplateValues()
	 *
	 * @return boolean
	 **/
	public function writeConfigImageValues($imageName)
	{
		$handle = fopen($this->CFG['site']['project_path'].'common/configs/config_photo_water_mark.inc.php', 'r+');
		if ($handle) {
			$newValue = '';
		    while (!feof($handle))
			{
		        $buffer = fgets($handle, 4096);
		        $valuearr = split('=',$buffer);

		        if(is_array($valuearr))
		        {
		        	$replacdvalue		  = str_replace('$','',$valuearr[0]);
		        	$watermark_image_name = "CFG['admin']['watermark']['image_name']";
		        	$water_mark_type      = "CFG['admin']['watermark']['water_mark_type']";

			        if(trim($replacdvalue)==trim($watermark_image_name))
						$newValue.=trim($valuearr[0])."='".$imageName."';"."\n";
					elseif(trim($replacdvalue)==trim($water_mark_type))
						$newValue.=trim($valuearr[0])."='image';"."\n";
					else
						$newValue .= $buffer;
				}
				else
					$newValue .= $buffer;
		    }
		    fclose($handle);
		}
		$fp = fopen($this->CFG['site']['project_path'].'common/configs/config_photo_water_mark.inc.php', 'w+');
		fwrite($fp, $newValue);
		fclose($fp);
	}

	/**
	 * watermarkSettingsHandler::insertWaterMarkImage()
	 *
	 * @return void
	 */
	public function insertWaterMarkImage()
	{
		$this->writeConfigValues();
		$createtextimageclass = new createTextImageClass();
		$waterMarkPath        = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['watermark_folder'].'/'.$this->CFG['admin']['watermark']['image_name'];
		$redirectUrl          = $this->CFG['site']['current_url'];

		/*$createtextimageclass->creatTextImage($this->getFormField('water_mark_text'), $this->getFormField('text_size'),
								$this->CFG['admin']['watermark']['water_mark_text_xposition'], $this->CFG['admin']['watermark']['water_mark_text_yposition'],
								$this->CFG['admin']['watermark']['water_mark_text_width'], $this->CFG['admin']['watermark']['water_mark_text_height'],
		                         $this->getFormField('text_color'), $this->getFormField('back_ground_color'), $waterMarkPath, $redirectUrl);*/
		$createtextimageclass->creatTextImage($this->getFormField('water_mark_text'), $this->getFormField('text_size'),
								$this->getFormField('water_mark_text_xposition'), 	$this->getFormField('water_mark_text_yposition'),
								$this->getFormField('water_mark_text_width'), $this->getFormField('water_mark_text_height'),
		                         $this->getFormField('text_color'), $this->getFormField('back_ground_color'), $waterMarkPath, $redirectUrl);
	}

	/**
	 * watermarkSettingsHandler::waterMarkImageExists()
	 *
	 * @return boolean
	 */
	public function waterMarkImageExists()
	{
		global $smartyObj;
		$imagePath = $this->CFG['site']['project_path'].$this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['watermark_folder'].'/'.$this->CFG['admin']['watermark']['image_name'];
		if(file_exists($imagePath))
		{
			$imagePath = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['watermark_folder'].'/'.$this->CFG['admin']['watermark']['image_name'];
			$smartyObj->assign('imagePath', $imagePath);
			return true;
		}
		else
		{
			$smartyObj->assign('imagePath', '');
			return false;
		}
	}

	/**
	 * watermarkSettingsHandler::removeWaterMarkImage()
	 *
	 * @return boolean
	 */
	public function removeWaterMarkImage()
	{
		$imagePath = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['watermark_folder'].'/'.$this->CFG['admin']['watermark']['image_name'];
		if(is_file($imagePath))
		{
			unlink($imagePath);
			return true;
		}
	}

   /**
	* watermarkSettingsHandler::storeImagesTempServer()
	*
	* @param string $uploadUrl
	* @param string $extern
	* @return void
	*/
	public function storeImagesTempServer($uploadUrl, $extern)
	{
		@chmod($uploadUrl.'.'.$extern, 0777);
		if($this->CFG['admin']['watermark']['image_height'] or $this->CFG['admin']['watermark']['image_width'])
		{
			$this->imageObj->resize($this->CFG['admin']['watermark']['image_width'], $this->CFG['admin']['watermark']['image_height'], '-');
			$this->imageObj->output_resized($uploadUrl.'.'.$extern, strtoupper($extern));
		}
		else
		{
			$this->imageObj->output_original($uploadUrl.'.'.$extern, strtoupper($extern));
		}
	}
}

/*echo '<pre>'; print_r($_FILES); echo '</pre>';*/
$watermarksetting = new watermarkSettingsHandler();
$watermarksetting->setMediaPath('../../');
$watermarksetting->setPageBlockNames(array('list_settings_block','image_setting_block','font_setting_block'));
$watermarksetting->setFormField('watermark_type', 'image');
$watermarksetting->setFormField('block','');
$watermarksetting->setFormField('water_mark_text','');
$watermarksetting->setFormField('back_ground_color','');
$watermarksetting->setFormField('text_color','');
$watermarksetting->setFormField('text_size','');
$watermarksetting->setFormField('water_mark_text_xposition','');
$watermarksetting->setFormField('water_mark_text_yposition','');
$watermarksetting->setFormField('water_mark_text_width','');
$watermarksetting->setFormField('water_mark_text_height','');
$watermarksetting->setFormField('msg','');
$watermarksetting->setFormField('default_template',$CFG['html']['template']['default']);
$watermarksetting->setFormField('default_theme',$CFG['html']['stylesheet']['screen']['default']);
$watermarksetting->setAllPageBlocksHide();
$watermarksetting->sanitizeFormInputs($_REQUEST);
$watermarksetting->imageFormat=implode(', ',$CFG['admin']['watermark']['water_mark_format_arr']);

$createtextimageclass = new createTextImageClass();
$first_option_arr = array(''=>$LANG['select_background_color']);
$colorList 		  = $first_option_arr + $createtextimageclass->rgb_array;
$smartyObj->assign('smarty_color_list', $colorList);

$first_option_txt_arr = array(''=>$LANG['select_text_size']);
$textList 	  	      = $first_option_txt_arr + $createtextimageclass->text_size;
$smartyObj->assign('smarty_text_list', $textList);





if (isAjaxPage())
{
   	if($watermarksetting->getFormField('block') == 'setTheme')
 	{
        $watermarksetting->generalPopulateTemplateArray($watermarksetting->styleThemeArray, $watermarksetting->getFormField('default_theme'));
		exit;
	}
}
$watermarksetting->left_navigation_div = 'generalMenu';

if($watermarksetting->waterMarkImageExists())
{
	$watermarksetting->setPageBlockShow('list_settings_block');
	$smartyObj->assign('form_display', 'none');
}

if($watermarksetting->isFormGETed($_GET, 'block'))
{
	if($CFG['admin']['is_demo_site'])
	{
		$watermarksetting->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
		$watermarksetting->setPageBlockShow('block_msg_form_success');
	}
	else
	{
		if($watermarksetting->getFormField('block') == 'edit')
	 	{
			$watermarksetting->setFormField('watermark_type', $CFG['admin']['watermark']['water_mark_type']);
			$watermarksetting->setFormField('water_mark_text',$CFG['admin']['watermark']['water_mark_text_image_text']);
			$watermarksetting->setFormField('back_ground_color',$CFG['admin']['watermark']['water_mark_text_image_back_ground_color']);
			$watermarksetting->setFormField('text_color',$CFG['admin']['watermark']['water_mark_text_image_text_color']);
			$watermarksetting->setFormField('text_size',$CFG['admin']['watermark']['water_mark_text_image_text_size']);
			$watermarksetting->setFormField('water_mark_text_xposition',$CFG['admin']['watermark']['water_mark_text_xposition']);
			$watermarksetting->setFormField('water_mark_text_yposition',$CFG['admin']['watermark']['water_mark_text_yposition']);
			$watermarksetting->setFormField('water_mark_text_width',$CFG['admin']['watermark']['water_mark_text_width']);
			$watermarksetting->setFormField('water_mark_text_height',$CFG['admin']['watermark']['water_mark_text_height']);
	 	}
	 	$smartyObj->assign('form_display', '');
	 }
}

if($watermarksetting->isFormPOSTed($_POST, 'update'))
{
	if($CFG['admin']['is_demo_site'])
	{
		$watermarksetting->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
		$watermarksetting->setPageBlockShow('block_msg_form_success');
	}
	else
	{
		$watermarkType = $watermarksetting->getFormField('watermark_type');
		if($watermarkType == 'image')
		{
			$watermarksetting->chkFileIsNotEmpty('photo_file', $LANG['common_photo_err_tip_no_file']) and
				$watermarksetting->chkFileNameIsNotEmpty('photo_file', $LANG['common_photo_err_tip_required']) and
					$watermarksetting->chkValidFileType('photo_file', $CFG['admin']['watermark']['water_mark_format_arr'], $LANG['common_photo_err_tip_invalid_file_type']) and
						$watermarksetting->chkValideFileSize('photo_file', $LANG['common_photo_err_tip_invalid_file_size']) and
							$watermarksetting->chkErrorInFile('photo_file', $LANG['common_photo_err_tip_invalid_file']);
		}
		if($watermarkType == 'font')
		{
			$watermarksetting->chkIsNotEmpty('water_mark_text', $LANG['common_err_tip_required']);
			$watermarksetting->chkIsNotEmpty('back_ground_color', $LANG['common_err_tip_required']);
			$watermarksetting->chkIsNotEmpty('text_color', $LANG['common_err_tip_required']);
			$watermarksetting->chkIsNotEmpty('text_size', $LANG['common_err_tip_required']);
			$watermarksetting->chkIsNotEmpty('water_mark_text_width', $LANG['common_err_tip_required']) and
				$watermarksetting->chkIsNumeric('water_mark_text_width', $LANG['common_err_tip_numeric']);
			$watermarksetting->chkIsNotEmpty('water_mark_text_height', $LANG['common_err_tip_required']) and
				$watermarksetting->chkIsNumeric('water_mark_text_height', $LANG['common_err_tip_numeric']);
			$watermarksetting->chkIsNotEmpty('water_mark_text_xposition', $LANG['common_err_tip_required']) and
				$watermarksetting->chkIsNumeric('water_mark_text_xposition', $LANG['common_err_tip_numeric']);
			$watermarksetting->chkIsNotEmpty('water_mark_text_yposition', $LANG['common_err_tip_required']) and
				$watermarksetting->chkIsNumeric('water_mark_text_yposition', $LANG['common_err_tip_numeric']);
			$LANG['settings_msg_error'] = $LANG['settings_text_msg_error'];
		}

		if($watermarksetting->isValidFormInputs())
		{
			if($watermarkType == 'image')
			{
				if (isset($_FILES['photo_file']['name']) && trim($_FILES['photo_file']['name']!=''))
				{
					$extern = strtolower(substr($_FILES['photo_file']['name'], strrpos($_FILES['photo_file']['name'], '.')+1));
					if ($_FILES['photo_file']['name'])
					{
						$imageObj   = new ImageHandler($_FILES['photo_file']['tmp_name']);
						$watermarksetting->setIHObject($imageObj);
						$watermarksetting->removeWaterMarkImage();
						$image      = explode('.',$CFG['admin']['watermark']['image_name']);
						$image_name = $image['0'];
						$temp_dir   = $watermarksetting->media_relative_path.$CFG['media']['folder'].'/'.$CFG['admin']['photos']['watermark_folder'].'/';
						$watermarksetting->chkAndCreateFolder($temp_dir);
						$temp_file  = $temp_dir.$image_name;
						$watermarksetting->storeImagesTempServer($temp_file, $extern);
						$watermarksetting->writeConfigImageValues($image_name.'.'.$extern);
					}
				}
			}
			elseif($watermarkType == 'font')
			{
				$watermarksetting->insertWaterMarkImage();
			}

			$watermarksetting->setCommonSuccessMsg($LANG['image_updated_successfully']);
			$watermarksetting->setPageBlockShow('block_msg_form_success');
		}
		else
		{
			$smartyObj->assign('form_display', '');
			$watermarksetting->setCommonErrorMsg($LANG['settings_msg_error']);
			$watermarksetting->setPageBlockShow('block_msg_form_error');
		}
	}
}

$msg = $watermarksetting->getFormField('msg');
if($msg == '1')
{
	$watermarksetting->setCommonSuccessMsg($LANG['image_updated_successfully']);
	$watermarksetting->setPageBlockShow('block_msg_form_success');
}
elseif($msg != '')
{
	$watermarksetting->setCommonErrorMsg($LANG['settings_text_msg_error']);
	$watermarksetting->setPageBlockShow('block_msg_form_error');
}


$watermarksetting->left_navigation_div = 'photoSetting';
$watermarksetting->includeHeader();
setTemplateFolder('admin/','photo');
$smartyObj->display('waterMarkSetting.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
?>
<script language="javascript"   type="text/javascript">
	function changeWaterMarkType(watermark_type)
	{
		if(watermark_type == 'image')
		{
			$Jq('#selImageMarker').css('display', 'block');
			$Jq('#selFontMarker').css('display', 'none');
		}
		else
		{
			$Jq('#selImageMarker').css('display', 'none');
			$Jq('#selFontMarker').css('display', 'block');
		}
	}

	function setTheme(url, val,id)
	{
		var method_type = 'post';
		var pars        = 'ajax=true&block=setTheme&default_template='+val;
		var myAjax      =  $Jq.ajax({
							type: method_type,
							url: url,
							data: pars,
							success: function (data){
											data = data;
											data = data.split('###');
											$Jq('#'+id).html(data);
										}
							});
	}

	changeWaterMarkType("<?php echo $watermarksetting->getFormField('watermark_type');?>");
</script>
<?php
$watermarksetting->includeFooter();
?>