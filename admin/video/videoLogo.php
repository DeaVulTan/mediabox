<?php
/**
 * This file is to manage video logo
 *
 * This file is having logoupload class to manage video logo
 *
 *
 * @category	Rayzz
 * @package		Admin
 *
 **/
require_once('../../common/configs/config.inc.php');
require_once('../../common/configs/config_video.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/admin/videoLogo.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/help.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['site']['is_module_page']='video';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class logoupload begins -------------------->>>>>//
/**
 *
 * @category	rayzz
 * @package		Admin
 **/
class logoupload extends FormHandler
	{
		/**
		 * logoupload::chkFileNameIsNotEmpty()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return
		 **/
		public function chkFileNameIsNotEmpty($field_name, $err_tip = '')
			{
				if(!$_FILES[$field_name]['name'])
					{
						//$this->setFormFieldErrorTip($field_name,$err_tip);
						return false;
					}
				return true;
			}

		/**
		 * logoupload::chkValidFileType()
		 *
		 * @param $field_name
		 * @param string $err_tip
		 * @return
		 **/
		public function chkValidFileType($field_name, $err_tip = '')
			{
				$extern = strtolower(substr($_FILES[$field_name]['name'], strrpos($_FILES[$field_name]['name'], '.')+1));
				if (!in_array(strtolower($extern), $this->CFG['admin']['videos']['logo_format_arr']))
					{
						$this->fields_err_tip_arr[$field_name] = $err_tip;
						return false;
					}
				return true;
			}

		/**
		 * logoupload::chkValideFileSize()
		 *
		 * @param $field_name
		 * @param string $err_tip
		 * @return
		 **/
		public function chkValideFileSize($field_name, $logo_size, $err_tip='')
			{
				$max_size = $logo_size * 1024;
				if ($_FILES[$field_name]['size'] > $max_size)
					{
						$this->fields_err_tip_arr[$field_name] = $err_tip;
						return false;
					}
				return true;
			}

		/**
		 * logoupload::chkErrorInFile()
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

		/**
		 * logoupload::resetFieldsArray()
		 *
		 * @return
		 */
		public function resetFieldsArray()
			{
				$this->setFormField('logo_id', '');
				$this->setFormField('logo_name', '');
				$this->setFormField('logo_description', '');
				$this->setFormField('logo_url', '');
				$this->setFormField('logo_position', 'Left_bottom');
				$this->setFormField('logo_transparency', '');
				$this->setFormField('logo_rollover_transparency', '');

				$this->setFormField('logo_image', '');
				$this->setFormField('logo_ext', '');
				$this->setFormField('video_logo_file', '');

				$this->setFormField('mini_logo_image', '');
				$this->setFormField('mini_logo_ext', '');
				$this->setFormField('mini_logo_file', '');

				$this->setFormField('date_added', '');
				$this->setFormField('mini_logo', '1');
				$this->setFormField('animated_logo', 'no');
				$this->setFormField('main_logo', 'no');
				$this->setFormField('remove', '');

			}

		/**
		 * PhotoEdit::populateLogoDetails()
		 *
		 * @return
		 **/
		public function populateLogoDetails()
			{
				$sql = 'SELECT logo_id, logo_name, logo_description, logo_url, logo_position, logo_transparency,'.
						' logo_rollover_transparency, main_logo, logo_image, logo_ext, mini_logo_image, mini_logo,'.
						' mini_logo_ext, animated_logo FROM '.$this->CFG['db']['tbl']['video_logo'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						$this->fields_arr['logo_id'] = $row['logo_id'];
						$this->fields_arr['logo_name'] = $row['logo_name'];
						$this->fields_arr['logo_description'] = $row['logo_description'];
						$this->fields_arr['logo_url'] = $row['logo_url'];
						$this->fields_arr['logo_position'] = $row['logo_position'];
						$this->fields_arr['logo_transparency'] = $row['logo_transparency'];
						$this->fields_arr['logo_rollover_transparency'] = $row['logo_rollover_transparency'];

						$this->fields_arr['logo_image'] = $row['logo_image'];
						$this->fields_arr['logo_ext'] = $row['logo_ext'];

						$this->fields_arr['mini_logo_image'] = $row['mini_logo_image'];
						$this->fields_arr['mini_logo_ext'] = $row['mini_logo_ext'];
						$this->fields_arr['mini_logo'] = $row['mini_logo'];
						$this->fields_arr['animated_logo'] = $row['animated_logo'];
						$this->fields_arr['main_logo'] = $row['main_logo'];
					}
			}

		/**
		 * logoupload::getLogoImage()
		 *
		 * @return
		 */
		public function getLogoImage()
			{
				$relative_path = '../../'.$this->CFG['admin']['videos']['logo_folder'].$this->fields_arr['logo_image'].'.'.$this->fields_arr['logo_ext'];
				switch($this->fields_arr['logo_ext'])
					{
						case 'jpg':
							$image_path = $this->CFG['site']['url'].$this->CFG['admin']['videos']['logo_folder'].$this->fields_arr['logo_image'].'.'.$this->fields_arr['logo_ext'];
							break;

						case 'swf':
							$image_path = $this->CFG['site']['url'].'images/swflogo.jpg';
							break;

						default:
							$image_path = $this->CFG['site']['url'].'images/nologo.jpg';
							break;
					}
				if(!is_file($relative_path))
					return false;
				?>
					<img src="<?php echo $image_path;?>" alt="<?php echo $this->LANG['logo'];?>" width="66px" height="66px" />
					<a href="<?php echo './videoLogo.php?remove=logo'; ?>"><?php echo $this->LANG['rmve_this_image']; ?></a>
				<?php
			}

		/**
		 * logoupload::getMiniLogoImage()
		 *
		 * @return
		 */
		public function getMiniLogoImage()
			{
				$relative_path='../../'.$this->CFG['admin']['videos']['logo_folder'].$this->fields_arr['mini_logo_image'].'.'.$this->fields_arr['mini_logo_ext'];
				switch($this->fields_arr['mini_logo_ext'])
					{
						case 'jpg':
							$image_path = $this->CFG['site']['url'].$this->CFG['admin']['videos']['logo_folder'].$this->fields_arr['mini_logo_image'].'.'.$this->fields_arr['mini_logo_ext'];
							break;

						case 'swf':
							$image_path = $this->CFG['site']['url'].'images/swflogo.jpg';
							break;

						default:
							$image_path = $this->CFG['site']['url'].'images/nologo.jpg';
							break;
					}
				if(!is_file($relative_path))
					return false;
				?>
					<img src="<?php echo $image_path;?>" alt="<?php echo $this->LANG['mini_logo'];?>" width="66px" height="66px" />
					<a href="<?php echo './videoLogo.php?remove=mini_logo'; ?>"><?php echo $this->LANG['rmve_this_image']; ?></a>
				<?php
			}

		/**
		 * logoupload::removeImages()
		 *
		 * @return
		 */
		public function removeImages()
			{
				$set_field=' logo_image=\'\', logo_ext=\'\'';
				$image_path = '../../'.$this->CFG['admin']['videos']['logo_folder'].$this->fields_arr['logo_image'].'.'.$this->fields_arr['logo_ext'];
				if($this->fields_arr['remove']=='mini_logo')
					{
						$set_field=' mini_logo_image=\'\', mini_logo_ext=\'\' ';
						$image_path = '../../'.$this->CFG['admin']['videos']['logo_folder'].$this->fields_arr['mini_logo_image'].'.'.$this->fields_arr['mini_logo_ext'];
					}
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['video_logo'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($rs->PO_RecordCount())
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_logo'].' SET'. $set_field.

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
					}
				if(is_file($image_path))
					@unlink($image_path);
			}

		/**
		 * logoupload::updateLogoTable()
		 *
		 * @return
		 */
		public function updateLogoTable()
			{
				$add_arr = array();
				$add_field = '';
				if($this->logoUpload)
					{
						$extern = strtolower(substr($_FILES['video_logo_file']['name'], strrpos($_FILES['video_logo_file']['name'], '.')+1));
						$dir = '../../'.$this->CFG['admin']['videos']['logo_folder'];
						$this->chkAndCreateFolder($dir);
						move_uploaded_file($_FILES['video_logo_file']['tmp_name'],$dir.$this->CFG['admin']['videos']['logo_name'].'.'.strtolower($extern));
						$this->fields_arr['logo_image'] = $this->CFG['admin']['videos']['logo_name'];
						$this->fields_arr['logo_ext'] = $extern;
						$add_arr = array($this->CFG['admin']['videos']['logo_name'], $extern);
						$add_field = ', logo_image='.$this->dbObj->Param('logo_image').','.
										' logo_ext='.$this->dbObj->Param('logo_ext');
					}
				if(isset($this->miniLogoUpload))
					{
						$extern = strtolower(substr($_FILES['mini_logo_file']['name'], strrpos($_FILES['mini_logo_file']['name'], '.')+1));
						$dir = '../../'.$this->CFG['admin']['videos']['logo_folder'];
						$this->chkAndCreateFolder($dir);
						move_uploaded_file($_FILES['mini_logo_file']['tmp_name'],$dir.$this->CFG['admin']['videos']['mini_logo_name'].'.'.strtolower($extern));
						$this->fields_arr['mini_logo_image'] = $this->CFG['admin']['videos']['mini_logo_name'];
						$this->fields_arr['mini_logo_ext'] = $extern;
						$add_arr = array($this->CFG['admin']['videos']['mini_logo_name'], $extern);
						$add_field = ', mini_logo_image='.$this->dbObj->Param('mini_logo_image').','.
										' mini_logo_ext='.$this->dbObj->Param('mini_logo_ext');
					}
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['video_logo'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($rs->PO_RecordCount())
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_logo'].' SET'.
								' logo_name='.$this->dbObj->Param('logo_name').','.
								' logo_description='.$this->dbObj->Param('logo_description').','.
								' animated_logo='.$this->dbObj->Param('animated_logo').','.
								' logo_url='.$this->dbObj->Param('logo_url').','.
								' logo_position='.$this->dbObj->Param('logo_position').','.
								' logo_transparency='.$this->dbObj->Param('logo_transparency').','.
								' mini_logo='.$this->dbObj->Param('mini_logo').','.
								' main_logo='.$this->dbObj->Param('main_logo').','.
								' logo_rollover_transparency='.$this->dbObj->Param('logo_rollover_transparency').$add_field;

						$array = array($this->fields_arr['logo_name'], $this->fields_arr['logo_description'],
										$this->fields_arr['animated_logo'], $this->fields_arr['logo_url'],
										 $this->fields_arr['logo_position'], $this->fields_arr['logo_transparency'],
										 $this->fields_arr['mini_logo'], $this->fields_arr['main_logo'], $this->fields_arr['logo_rollover_transparency']);

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array_merge($array, $add_arr));
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
					}
				else
					{
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['video_logo'].' SET'.
								' logo_name='.$this->dbObj->Param('logo_name').','.
								' logo_description='.$this->dbObj->Param('logo_description').','.
								' animated_logo='.$this->dbObj->Param('animated_logo').','.
								' logo_url='.$this->dbObj->Param('logo_url').','.
								' logo_position='.$this->dbObj->Param('logo_position').','.
								' logo_transparency='.$this->dbObj->Param('logo_transparency').','.
								' mini_logo='.$this->dbObj->Param('mini_logo').','.
								' main_logo='.$this->dbObj->Param('main_logo').','.
								' logo_rollover_transparency='.$this->dbObj->Param('logo_rollover_transparency').','.
								' date_added=NOW()'.$add_field;

						$array = array($this->fields_arr['logo_name'], $this->fields_arr['logo_description'],
										$this->fields_arr['animated_logo'], $this->fields_arr['logo_url'],
										 $this->fields_arr['logo_position'], $this->fields_arr['logo_transparency'],
										 $this->fields_arr['mini_logo'],$this->fields_arr['main_logo'],$this->fields_arr['logo_rollover_transparency']);

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array_merge($array, $add_arr));
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
					}
			}
	}
//<<<<<-------------- Class logoupload begins ---------------//
//-------------------- Code begins -------------->>>>>//
$logoupload = new logoupload();
$logoupload->setDBObject($db);
$logoupload->makeGlobalize($CFG,$LANG);
$logo_position_array = array('Left_bottom'=>$LANG['left_bottom'], 'Left_top'=>$LANG['left_top'], 'Right_bottom'=>$LANG['right_bottom'], 'Right_top'=>$LANG['right_top']);
$logoupload->setPageBlockNames(array('logo_upload_form'));

//default form fields and values...
$logoupload->resetFieldsArray();
$logoupload->setAllPageBlocksHide();
$logoupload->setPageBlockShow('logo_upload_form');
$logoupload->sanitizeFormInputs($_REQUEST);
if($logoupload->isFormPOSTed($_POST, 'upload'))
	{
		if ($CFG['admin']['is_demo_site'])
			{
				$logoupload->setCommonSuccessMsg($logoupload->LANG['general_config_not_allow_demo_site']);
				$logoupload->setPageBlockShow('block_msg_form_success');
			}
		else
			{

				$logoupload->logoUpload = $logoupload->chkFileNameIsNotEmpty('video_logo_file', $LANG['err_tip_compulsory']) and
					$logoupload->chkValidFileType('video_logo_file',$LANG['err_tip_invalid_file_type']) and
					$logoupload->chkValideFileSize('video_logo_file', $CFG['admin']['videos']['logo_max_size'],$LANG['err_tip_invalid_file_size']) and
					$logoupload->chkErrorInFile('video_logo_file',$LANG['err_tip_invalid_file']);
				/*$logoupload->miniLogoUpload = $logoupload->chkFileNameIsNotEmpty('mini_logo_file', $LANG['err_tip_compulsory']) and
					$logoupload->chkValidFileType('mini_logo_file',$LANG['err_tip_invalid_file_type']) and
					$logoupload->chkValideFileSize('mini_logo_file', $CFG['admin']['videos']['mini_logo_max_size'],$LANG['err_tip_invalid_file_size']) and
					$logoupload->chkErrorInFile('mini_logo_file',$LANG['err_tip_invalid_file']);*/
				$logoupload->getFormField('logo_transparency') and
					$logoupload->chkIsNumeric('logo_transparency',$LANG['err_tip_numeric']);
				$logoupload->getFormField('logo_rollover_transparency') and
					$logoupload->chkIsNumeric('logo_rollover_transparency',$LANG['err_tip_numeric']);
				if($logoupload->isValidFormInputs())
					{
						$logoupload->updateLogoTable();
						$logoupload->setCommonSuccessMsg($LANG['msg_success_updated']);
						$logoupload->setPageBlockShow('block_msg_form_success');
					}
				else
					{
						$logoupload->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$logoupload->setPageBlockShow('block_msg_form_error');
					}
			}
	}
else
	{
		$logoupload->populateLogoDetails();
	}
if($logoupload->isFormGETed($_GET, 'remove'))
	{
		if ($CFG['admin']['is_demo_site'])
			{
				$logoupload->setCommonSuccessMsg($logoupload->LANG['general_config_not_allow_demo_site']);
				$logoupload->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				if(trim($logoupload->getFormField('remove')) and ($logoupload->getFormField('remove')=='mini_logo' or  $logoupload->getFormField('remove')=='logo'))
					$logoupload->removeImages();
			}
	}
//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($logoupload->isShowPageBlock('logo_upload_form'))
    {
		$logoupload->logo_upload_form['hidden_array'] = array('mini_logo_image', 'mini_logo_ext', 'logo_ext', 'logo_image');
		$logoupload->logo_upload_form['logo_position_array'] = $logo_position_array;
		$logoupload->logo_upload_form['implode_logo_format_arr'] = implode(', ', $CFG['admin']['videos']['logo_format_arr']);
		$logoupload->logo_upload_form['implode_mini_logo_format_arr'] = implode(', ', $CFG['admin']['videos']['mini_logo_format_arr']);
	}
$logoupload->left_navigation_div = 'videoPlayerSetting';
//include the header file
$logoupload->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'video');
$smartyObj->display('videoLogo.tpl');
?>
<?php
/* Added code to validate mandataory fields in video defaut settings page */
if ($CFG['feature']['jquery_validation'])
{
$allowed_image_formats = implode("|", $CFG['admin']['videos']['logo_format_arr']);
?>
<script type="text/javascript">
$Jq("#logo_video_upload_form").validate({
	rules: {
	    logo_transparency: {
	          number: true
		 },
	    logo_rollover_transparency: {
	    	number: true
	    },
	     video_logo_file: {
	    	isValidFileFormat: "<?php echo $allowed_image_formats; ?>"
	    }
	},
	messages: {
		logo_transparency: {
			number: LANG_JS_NUMBER
		},
		logo_rollover_transparency: {
			number: LANG_JS_NUMBER
		},
		video_logo_file: {
			isValidFileFormat: "<?php echo $logoupload->LANG['common_err_tip_invalid_image_format']; ?>"
		}

	}
});
</script>
<?php
}
//<<<<<-------------------- Page block templates ends -------------------//
$logoupload->includeFooter();
?>