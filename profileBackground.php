<?php
/**
 * This file is to display profile background
 *
 * @category	Rayzz
 * @package		Members
 */
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/members/profileBackground.php';
$CFG['html']['header'] = 'general/html_header.php';;
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['db']['is_use_db'] = true;

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------------------class ProfileBackground-------------------->>>
/**
 * ProfileBackground
 *
 * @package
 * @author shankar_044at09
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
Class ProfileBackground extends MediaHandler
	{
		public $background_ext;
		public $background_path;

		/**
		 * ProfileBackground::chkFileNameIsNotEmpty()
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
		 * ProfileBackground::chkValidFileType()
		 *
		 * @param $field_name
		 * @param string $err_tip
		 * @return
		 **/
		public function chkValidFileType($field_name, $err_tip = '')
			{
				$extern = strtolower(substr($_FILES[$field_name]['name'], strrpos($_FILES[$field_name]['name'], '.')+1));
				if (!in_array($extern, $this->CFG['profile']['background_format_arr']))
					{
						$this->fields_err_tip_arr[$field_name] = $err_tip;
						return false;
					}
				return true;
			}

		/**
		 * ProfileBackground::chkValideFileSize()
		 *
		 * @param $field_name
		 * @param string $err_tip
		 * @return
		 **/
		public function chkValideFileSize($field_name, $err_tip='')
			{
				$max_size = $this->CFG['profile']['background_image_max_size'] * 1024;
				if ($_FILES[$field_name]['size'] > $max_size)
					{
						$this->fields_err_tip_arr[$field_name] = $err_tip;
						return false;
					}
				return true;
			}

		/**
		 * ProfileBackground::chkErrorInFile()
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
		 * ProfileBackground::chkOffsetSize()
		 *
		 * @param mixed $field_name
		 * @param mixed $err_tip
		 * @return
		 */
		public function chkOffsetSize($field_name, $err_tip)
			{
				if($this->fields_arr[$field_name] > $this->CFG['profile']['background_offset_size'])
					{
						$this->setFormFieldErrorTip($field_name, $err_tip);
						return false;
					}
				return true;
			}

		/**
		 * ProfileBackground::storeUploadFile()
		 *
		 * @return
		 */
		public function storeUploadFile()
			{
				//$this->background_folder = $this->media_relative_path.$this->CFG['profile']['background_image_folder'];
				$this->background_folder = $this->CFG['profile']['background_image_folder'];
				$this->chkAndCreateFolder($this->background_folder);
				$extern = substr($_FILES['profile_background_image']['name'],
							strrpos($_FILES['profile_background_image']['name'],'.')+1,
								strlen($_FILES['profile_background_image']['name']));

				$image_storePath = $this->background_folder.$this->CFG['user']['user_id'].'.'.$extern;
				if(isset($_FILES['profile_background_image']) && $_FILES['profile_background_image']['name'])
					{
						if(move_uploaded_file($_FILES['profile_background_image']['tmp_name'],$image_storePath))
							{
								if(!$this->cur_bg)
									{
										$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['users_profile_background'].
												 ' SET background_ext='.$this->dbObj->Param('background_ext').
												 ', background_offset='.$this->dbObj->Param('background_offset').
												 ', background_repeat='.$this->dbObj->Param('background_repeat').
												 ', user_id='.$this->dbObj->Param('user_id');
									}
								else
									{
										$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_profile_background'].
												' SET background_ext='.$this->dbObj->Param('background_ext').
												', background_offset='.$this->dbObj->Param('background_offset').
												', background_repeat='.$this->dbObj->Param('background_repeat').
												' WHERE user_id='.$this->dbObj->Param('user_id');
									}


								$value_arr = array($extern,
												$this->fields_arr['profile_background_offset'],
												$this->fields_arr['profile_background_repeat'],
												$this->CFG['user']['user_id']);

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $value_arr);
								if (!$rs)
									    trigger_db_error($this->dbObj);

								$this->background_ext = $extern;

								$this->setPageBlockShow('block_msg_form_success');
								$this->setCommonSuccessMsg($this->LANG['profilebackground_upload_success']);
							}
						else
							{
								$this->setPageBlockShow('block_msg_form_error');
								$this->setCommonErrorMsg($this->LANG['profilebackground_upload_failure']);
							}
					}
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_profile_background'].
						' SET background_offset='.$this->dbObj->Param('background_offset').
						', background_repeat='.$this->dbObj->Param('background_repeat').
						' WHERE user_id='.$this->dbObj->Param('user_id');

				$value_arr = array($this->fields_arr['profile_background_offset'],
									$this->fields_arr['profile_background_repeat'],
										$this->CFG['user']['user_id']);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $value_arr);
				if (!$rs)
					    trigger_db_error($this->dbObj);
			}

		/**
		 * ProfileBackground::getBackgroundOffset()
		 *
		 * @param mixed $user_id
		 * @return
		 */
		public function getBackgroundOffset($user_id)
			{
				$sql = 'SELECT background_offset, background_repeat FROM '.
						$this->CFG['db']['tbl']['users_profile_background'].
							' WHERE user_id='.$this->dbObj->Param('user_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$this->setFormField('profile_background_offset',$row['background_offset']);
				$this->setFormField('profile_background_repeat',$row['background_repeat']);
			}

		/**
		 * ProfileBackground::removeFile()
		 *
		 * @return
		 */
		public function removeFile()
			{
				//$this->background_folder = $this->media_relative_path.$this->CFG['profile']['background_image_folder'];
				$this->background_folder = $this->CFG['profile']['background_image_folder'];
				$this->background_path=$this->background_folder.$this->CFG['user']['user_id'].'.'.$this->background_ext;
				@unlink($this->background_path);
			}

		/**
		 * ProfileBackground::removeBackgroundImageExt()
		 *
		 * @return
		 */
		public function removeBackgroundImageExt()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_profile_background'].
						' SET background_ext=\'\', background_offset=\'0\''.
						' WHERE user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$this->setPageBlockShow('block_msg_form_success');
				$this->setCommonSuccessMsg($this->LANG['profilebackground_deleted_success']);
			}

		/**
		 * ProfileBackground::updateBackgroundOffset()
		 *
		 * @return
		 */
		public function updateBackgroundOffset()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_profile_background'].
						' SET background_offset='.$this->dbObj->Param('background_offset').','.
						' background_repeat='.$this->dbObj->Param('background_repeat').
						' WHERE user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['profile_background_offset'],
														  $this->fields_arr['profile_background_repeat'],
														  $this->CFG['user']['user_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$this->setPageBlockShow('block_msg_form_success');
				$this->setCommonSuccessMsg($this->LANG['profilebackground_update_success']);
			}

		/**
		 * ProfileBackground::getProfileBackgroud()
		 *
		 * @return
		 */
		public function getProfileBackgroud()
			{
				$sql = 'SELECT background_color, background_ext, background_offset, background_repeat'.
						' FROM '.$this->CFG['db']['tbl']['users_profile_background'].
						' WHERE user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$this->background_ext = $row['background_ext'];
						$this->fields_arr['profile_background_offset'] = $this->background_offset = $row['background_offset'];
						$this->fields_arr['profile_background_repeat'] = $this->background_repeat = $row['background_repeat'];
						$this->background_color = $this->fields_arr['profile_background_color'] = $row['background_color'];
						return true;
					}
				return false;
			}

		/**
		 * ProfileBackground::getProfileBackgroundImage()
		 *
		 * @param mixed $user_id
		 * @return
		 */
		public function getProfileBackgroundImage($user_id)
			{
				$folder = $this->CFG['profile']['background_image_folder'];
				$this->background_folder = $this->CFG['site']['url'].$this->CFG['profile']['background_image_folder'];

				$this->image_width = $this->background_path = '';
				$path = $folder.$user_id.'.'.$this->background_ext;
				$this->background_path='';
				if(file_exists($path))
					{
						//To Get width of the image
						$image_size = @getimagesize($path);
						if(isset($image_size[0]) && !empty($image_size[0]))
							$this->image_width = $image_size[0];

						$this->background_path = $this->background_folder.
													$user_id.'.'.$this->background_ext;

						$this->setPageBlockShow('block_image_display');
						$this->background_path.='?'.time();
					}
			}

		/**
		 * ProfileBackground::updateBackgroundColor()
		 *
		 * @return
		 */
		public function updateBackgroundColor()
			{
				if(!$this->cur_bg)
					{
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['users_profile_background'].
								 ' SET background_color='.$this->dbObj->Param('background_color').
								 ', user_id='.$this->dbObj->Param('user_id');
					}
				else
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_profile_background'].
								' SET background_color='.$this->dbObj->Param('background_color').
								' WHERE user_id='.$this->dbObj->Param('user_id');
					}

				$value_arr = array($this->fields_arr['profile_background_color'],
									$this->CFG['user']['user_id']);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $value_arr);
				if (!$rs)
					    trigger_db_error($this->dbObj);

				$this->setPageBlockShow('block_msg_form_success');
				$this->setCommonSuccessMsg($this->LANG['profilebackground_color_update_success']);
			}

		/**
		 * ProfileBackground::checkAndUpdateBackground()
		 *
		 * @return
		 */
		public function checkAndUpdateBackground()
			{
				if(!empty($this->fields_arr['profile_background_color'])
					&& $this->fields_arr['profile_background_color'] != $this->background_color)
					{
						//update color
						$this->updateBackgroundColor();
					}
				if($_FILES['profile_background_image']['name'] != '')
					{
						$this->chkValidFileType('profile_background_image',$this->LANG['profilebackground_err_tip_invalid_file_type']) and
							$this->chkValideFileSize('profile_background_image',$this->LANG['profilebackground_err_tip_invalid_file_size']) and
								$this->chkErrorInFile('profile_background_image',$this->LANG['profilebackground_err_tip_invalid_file']);

						$this->chkIsNotEmpty('profile_background_offset', $this->LANG['common_err_tip_compulsory']) AND
							$this->chkIsNumeric('profile_background_offset', $this->LANG['profilebackground_err_tip_invalid_offset']) AND
								$this->chkOffsetSize('profile_background_offset', $this->LANG['profilebackground_err_tip_invalid_offset_size']) ;

						if($this->isValidFormInputs())
							{
								//upload file and offset
								$this->storeUploadFile();
							}
						else
							{
								$this->setCommonErrorMsg($this->LANG['common_msg_error_sorry']);
								$this->setPageBlockShow('block_msg_form_error');
							}
					}
				else if($this->fields_arr['profile_background_offset'] != '')
					{
						if($this->background_ext == '')
							{
								$this->chkFileNameIsNotEmpty('profile_background_image', $this->LANG['profilebackground_err_tip_compulsory']) and
									$this->chkValidFileType('profile_background_image',$this->LANG['profilebackground_err_tip_invalid_file_type']) and
										$this->chkValideFileSize('profile_background_image',$this->LANG['profilebackground_err_tip_invalid_file_size']) and
											$this->chkErrorInFile('profile_background_image',$this->LANG['profilebackground_err_tip_invalid_file']);

								$this->chkIsNotEmpty('profile_background_offset', $this->LANG['common_err_tip_compulsory']) AND
									$this->chkIsNumeric('profile_background_offset', $this->LANG['profilebackground_err_tip_invalid_offset']) AND
										$this->chkOffsetSize('profile_background_offset', $this->LANG['profilebackground_err_tip_invalid_offset_size']) ;

								$this->setCommonErrorMsg($this->LANG['common_msg_error_sorry']);
								$this->setPageBlockShow('block_msg_form_error');
							}
						else
							{
								$this->chkIsNotEmpty('profile_background_offset', $this->LANG['common_err_tip_compulsory']) AND
									$this->chkIsNumeric('profile_background_offset', $this->LANG['profilebackground_err_tip_invalid_offset']) AND
										$this->chkOffsetSize('profile_background_offset', $this->LANG['profilebackground_err_tip_invalid_offset_size']) ;

								if($this->isValidFormInputs())
									{
										//update offset
										$this->updateBackgroundOffset();
									}
								else
									{
										$this->setCommonErrorMsg($this->LANG['common_msg_error_sorry']);
										$this->setPageBlockShow('block_msg_form_error');
									}
							}
					}
			}

		/**
		 * ProfileBackground::__destruct()
		 *
		 */
		public function __destruct()
			{
				unset($this->background_ext);
				unset($this->background_path);
			}
	}
//<<<<<-------------- Class ProfileBackground begins ---------------//
$LANG['help']['profile_background_offset'] = str_replace('VAR_SIZE', $CFG['profile']['background_offset_size'], $LANG['help']['profile_background_offset']);
$profileBackground = new ProfileBackground();
$profileBackground->setMediaPath('../');

$profileBackground->setPageBlockNames(array('block_image_display'));

$profileBackground->setFormField('profile_background_color','');
$profileBackground->setFormField('profile_background_image','');
$profileBackground->setFormField('profile_background_offset','0');
$profileBackground->setFormField('profile_background_repeat','No');
$profileBackground->setFormField('action','');

$profileBackground->cur_bg = $profileBackground->getProfileBackgroud($CFG['user']['user_id']);

$profileBackground->setAllPageBlocksHide();

$profileBackground->imageFormat = implode(',',$CFG['profile']['background_format_arr']);
$profileBackground->sanitizeFormInputs($_REQUEST);
if($profileBackground->isPageGETed($_POST, 'uploadBackground'))
	{
		$profileBackground->checkAndUpdateBackground();
	}
if($profileBackground->getFormField('action') == 'delete')
	{
		$profileBackground->removeFile();
		$profileBackground->removeBackgroundImageExt();
	}

$profileBackground->getProfileBackgroundImage($CFG['user']['user_id']);
$profileBackground->getBackgroundOffset($CFG['user']['user_id']);

//include the header file
$profileBackground->includeHeader();
//include the content of the page
setTemplateFolder('members/');
$smartyObj->display('profileBackground.tpl');
?>
<script type="text/javascript">
var block_arr= new Array('selMsgConfirm');
function showImageTip()
	{
		if($Jq('#imageTip').css('display') == 'none')
			{
				$Jq('#imageTip').css('display', 'block');
			}
		else
			{
				$Jq('#imageTip').css('display', 'none');
			}
	}
</script>
<?php
if ($CFG['feature']['jquery_validation']) {
$allowed_image_formats = implode("|", $CFG['profile']['background_format_arr']);
?>
<script type="text/javascript">
	$Jq("#selFormEditProfileBackground").validate({
		rules: {
			profile_background_image: {
		    	isValidFileFormat: "<?php echo $allowed_image_formats; ?>"

		    },
		    profile_background_offset: {
		    	required: "#profile_background_image:filled"
		    }
		},
		messages: {
			profile_background_image: {
				isValidFileFormat: "<?php echo $profileBackground->LANG['common_err_tip_invalid_image_format']; ?>"
			},
			profile_background_offset: {
				required: "<?php echo $profileBackground->LANG['common_err_tip_required'];?>"
			}
		}
	});
</script>
<?php
}
$profileBackground->includeFooter();
?>