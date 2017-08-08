<?php
/**
 * This file is to edit Member's Personal Information
 *
 * PHP version 5.0
 *
 * @category	Rayzz
 * @package		Members
 * @author		vijayanand39ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: profilePersonal.php 1157 2006-06-09 07:16:00Z vijayanand39ag05 $
 * @since 		2006-04-01
 */
require_once('./common/configs/config.inc.php'); //configurations
$CFG['lang']['include_files'][] = 'common/configs/config_members.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/members/profileAvatar.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';

$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
/**
 * To include application top file
 */
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------------------class EditProfileAvatarFormHandler-------------------->>>
/**
 * EditProfileAvatarFormHandler
 *
 * @package
 * @author edwin_90ag08
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id$
 * @access public
 */
class EditProfileAvatarFormHandler extends FormHandler
	{
	   	 /**
	   	  * EditProfileAvatarFormHandler::setIHObject()
	   	  *
	   	  * @param mixed $imObj
	   	  * @return
	   	  */
		public function setIHObject($imObj)
			{
				$this->imageObj = $imObj;
			}

		/**
		 * EditProfileAvatarFormHandler::storeImagesTempServer()
		 *
		 * @param mixed $uploadUrl
		 * @param mixed $extern
		 * @return
		 */
		public function storeImagesTempServer($uploadUrl, $extern)
			{
				//GET LARGE IMAGE
				@chmod($uploadUrl.'.'.$extern, 0777);
				if($this->CFG['image_large_name']=='L')
					{
						if($this->CFG['image_large_height'] or $this->CFG['image_large_width'])
							{
								$this->imageObj->resize($this->CFG['image_large_width'], $this->CFG['image_large_height'], '-');
								$this->imageObj->output_resized($uploadUrl.'L.'.$extern, strtoupper($extern));
								$image_info = getImageSize($uploadUrl.'L.'.$extern);
								$this->L_WIDTH = $image_info[0];
						        $this->L_HEIGHT = $image_info[1];
							}
						else
							{
								$this->imageObj->output_original($uploadUrl.'L.'.$extern, strtoupper($extern));
								$image_info = getImageSize($uploadUrl.'L.'.$extern);
								$this->L_WIDTH = $image_info[0];
						        $this->L_HEIGHT = $image_info[1];
							}
					}

				//GET THUMB IMAGE
				if($this->CFG['image_thumb_name']=='T')
					{
						$this->imageObj->resize($this->CFG['image_thumb_width'], $this->CFG['image_thumb_height'], '-');
						$this->imageObj->output_resized($uploadUrl.'T.'.$extern, strtoupper($extern));
						$image_info = getImageSize($uploadUrl.'T.'.$extern);
						$this->T_WIDTH = $image_info[0];
						$this->T_HEIGHT = $image_info[1];
					}

				//GET SMALL IMAGE
				if($this->CFG['image_small_name']=='S')
					{
						$this->imageObj->resize($this->CFG['image_small_width'], $this->CFG['image_small_height'], '-');
						$this->imageObj->output_resized($uploadUrl.'S.'.$extern, strtoupper($extern));
						$image_info = getImageSize($uploadUrl.'S.'.$extern);
						$this->S_WIDTH = $image_info[0];
						$this->S_HEIGHT = $image_info[1];
					}

				//GET MINI IMAGE
				if($this->CFG['image_small_name']=='M')
					{
						$this->imageObj->resize($this->CFG['image_small_width'], $this->CFG['image_small_height'], '-');
						$this->imageObj->output_resized($uploadUrl.'M.'.$extern, strtoupper($extern));
						$image_info = getImageSize($uploadUrl.'M.'.$extern);
						$this->M_WIDTH = $image_info[0];
						$this->M_HEIGHT = $image_info[1];
					}
				$wname = $this->CFG['image_large_name'].'_WIDTH';
				$hname = $this->CFG['image_large_name'].'_HEIGHT';
				$this->L_WIDTH = $this->$wname;
				$this->L_HEIGHT = $this->$hname;

				$wname = $this->CFG['image_thumb_name'].'_WIDTH';
				$hname = $this->CFG['image_thumb_name'].'_HEIGHT';
				$this->T_WIDTH = $this->$wname;
				$this->T_HEIGHT = $this->$hname;

				$wname = $this->CFG['image_small_name'].'_WIDTH';
				$hname = $this->CFG['image_small_name'].'_HEIGHT';
				$this->S_WIDTH = $this->$wname;
				$this->S_HEIGHT = $this->$hname;

				$wname = $this->CFG['image_small_name'].'_WIDTH';
				$hname = $this->CFG['image_small_name'].'_HEIGHT';
				$this->M_WIDTH = $this->$wname;
				$this->M_HEIGHT = $this->$hname;
			}

		/**
		 * EditProfileAvatarFormHandler::updateProfileImageExt()
		 *
		 * @param mixed $profile_image_ext
		 * @return
		 */
		public function updateProfileImageExt($profile_image_ext)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
						' SET image_ext = '.$this->dbObj->Param($profile_image_ext).
						', large_width='.$this->dbObj->Param('large_width').', large_height='.$this->dbObj->Param('large_height').
						', thumb_width='.$this->dbObj->Param('thumb_width').', thumb_height='.$this->dbObj->Param('thumb_height').
						', small_width='.$this->dbObj->Param('small_width').', small_height='.$this->dbObj->Param('small_height').
						', mini_width='.$this->dbObj->Param('mini_width').', mini_height='.$this->dbObj->Param('mini_height').
						' WHERE user_id = '.$this->dbObj->Param('user_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($profile_image_ext,$this->L_WIDTH, $this->L_HEIGHT, $this->T_WIDTH, $this->T_HEIGHT, $this->S_WIDTH, $this->S_HEIGHT, $this->M_WIDTH, $this->M_HEIGHT, $this->CFG['user']['user_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				return true;
			}

		/**
		 * EditProfileAvatarFormHandler::checkAvatarImage()
		 *
		 * @return
		 */
		public function checkAvatarImage()
		   {
		  	  	$sql = 'SELECT image_ext FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_id='.$this->dbObj->Param('user_id');
		  	  	$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				$image_ext='';
				if($row = $rs->FetchRow())
				   $image_ext = $row['image_ext'];

				if($image_ext!='')
				   return true;
				return false;
		   }

		/**
		 * EditProfileAvatarFormHandler::deleteUserProfilePhoto()
		 *
		 * @return
		 */
		public function deleteUserProfilePhoto()
			{
				$sql = 'SELECT image_ext FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_id='.$this->dbObj->Param('user_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$profile_avatar_ext=$row['image_ext'];

				if($profile_avatar_ext)
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
								' SET image_ext =\'\''.
								', large_width=0, large_height=0'.
								', thumb_width=0, thumb_height=0'.
								', small_width=0, small_height=0'.
								' WHERE user_id = '.$this->dbObj->Param('user_id');
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt,array($this->CFG['user']['user_id']));
						if (!$rs)
						        trigger_db_error($this->dbObj);

						$affected = $this->dbObj->Affected_Rows();
						if($affected>0)
							{
								@unlink($this->CFG['admin']['members_profile']['user_profile_folder'].$this->CFG['user']['user_id'].'L.'.$profile_avatar_ext);
								@unlink($this->CFG['admin']['members_profile']['user_profile_folder'].$this->CFG['user']['user_id'].'T.'.$profile_avatar_ext);
								@unlink($this->CFG['admin']['members_profile']['user_profile_folder'].$this->CFG['user']['user_id'].'S.'.$profile_avatar_ext);
								@unlink($this->CFG['admin']['members_profile']['user_profile_folder'].$this->CFG['user']['user_id'].'M.'.$profile_avatar_ext);
							}
					}
			}

		/**
		 * EditProfileAvatarFormHandler::changeArrayToCommaSeparator()
		 *
		 * @param array $arry_value
		 * @return
		 */
		public function changeArrayToCommaSeparator($arry_value = array())
			{
				return implode(', ',$arry_value);
			}

		/**
		 * EditProfileAvatarFormHandler::chkFileNameIsNotEmpty()
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
		 * EditProfileAvatarFormHandler::chkValideFileSize()
		 *
		 * @param mixed $field_name
		 * @param string $err_tip
		 * @return
		 */
		public function chkValideFileSize($field_name, $err_tip='')
			{
				$max_size = $this->CFG['admin']['members_profile']['profile_image_max_size'] * 1024;
				if ($_FILES[$field_name]['size'] > $max_size)
					{
						$this->fields_err_tip_arr[$field_name] = $err_tip;
						return false;
					}
				return true;
			}

		/**
		 * EditProfileAvatarFormHandler::chkErrorInFile()
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
	}
//<<<<<---------------class EditProfileAvatarFormHandler------///
//--------------------Code begins-------------->>>>>//
$personal = new EditProfileAvatarFormHandler();
$personal->makeGlobalize($CFG,$LANG);
$personal->setPageBlockNames(array('msg_form_error', 'msg_form_success', 'form_editprofile'));
$personal->setCSSFormFieldErrorTipClass('clsFormFieldErrTip');
$personal->setCSSFormLabelCellDefaultClass('clsFormLabelCellDefault');
$personal->setCSSFormFieldCellDefaultClass('clsFormFieldCellDefault');
$personal->setCSSFormLabelCellErrorClass('clsFormLabelCellError');
$personal->setCSSFormFieldCellErrorClass('clsFormFieldCellError');
// To set the DB object
$personal->setDBObject($db);
$personal->setFormField('user_id', $CFG['user']['user_id']);
$personal->setFormField('action', '');
$personal->setFormField('image_ext', '');
$personal->setFormField('user_image', '');

$profile_image_max_size = ($CFG['admin']['members_profile']['profile_image_max_size'] * 1024);
// Default page block
$personal->setAllPageBlocksHide();
$personal->setPageBlockShow('form_editprofile');

if ($personal->isFormPOSTed($_POST, 'editprofile_submit'))
	{
		$personal->sanitizeFormInputs($_POST);
		// Validations
		$personal->chkFileNameIsNotEmpty('user_image', $LANG['common_err_tip_required']) and
		$personal->chkValidFileType('user_image',$CFG['admin']['members_profile']['image_format_arr'],$LANG['profileavatar_errot_invalid_image']) and
		$personal->chkValideFileSize('user_image',$LANG['profileavatar_errot_invalid_size']) and
		$personal->chkErrorInFile('user_image',$LANG['profileavatar_err_tip_invalid_file']);
		if($personal->isValidFormInputs())
		 	{
			    $extern = strtolower(substr($_FILES['user_image']['name'], strrpos($_FILES['user_image']['name'], '.')+1));
				$imageObj = new ImageHandler($_FILES['user_image']['tmp_name']);
				$personal->setIHObject($imageObj);
				$image_name = $CFG['user']['user_id'];
				//$temp_dir = '../'.$CFG['admin']['members_profile']['user_profile_folder'];
				$temp_dir = $CFG['admin']['members_profile']['user_profile_folder'];
				$personal->chkAndCreateFolder($temp_dir);
				$temp_file = $temp_dir.$image_name;
				$personal->storeImagesTempServer($temp_file, $extern);
				$personal->setFormField('image_ext', $extern);
				$personal->updateProfileImageExt($extern);

				$personal->setAllPageBlocksHide();
				$personal->setPageBlockShow('form_editprofile');
				$personal->setPageBlockShow('block_msg_form_success');
				$personal->setCommonSuccessMsg($LANG['profileavatar_success_update_message']);
		  	}
		else
		  	{
		   	 	$personal->setAllPageBlocksHide();
			 	$personal->setPageBlockShow('block_msg_form_error');
			 	$personal->setCommonErrorMsg($LANG['common_msg_error_sorry']);
			 	$personal->setPageBlockShow('form_editprofile');
		  	}
	}
if ($personal->isFormPOSTed($_POST, 'cancel_avatar'))
	{
		Redirect2URL(getUrl('myprofile'));
	}
if($personal->isFormPOSTed($_POST, 'confirm'))
	{
	   	$personal->sanitizeFormInputs($_POST);
	   	if($personal->getFormField('action')=='delete_avatar')
	    	{
				$personal->deleteUserProfilePhoto();
				$personal->setAllPageBlocksHide();
				$personal->setPageBlockShow('form_editprofile');
				$personal->setPageBlockShow('block_msg_form_success');
				$personal->setCommonSuccessMsg($LANG['profileavatar_success_delete_message']);
	    	}
	}
if ($personal->isShowPageBlock('form_editprofile'))
	{
      $personal->avatar_image_exists = $personal->checkAvatarImage();
	}
//<<<<<-------------- Class PostComment ends ---------------//
//-------------------- Code begins -------------->>>>>//
$profile = $personal->getUserDetail('user_id', $CFG['user']['user_id']);
$personal->icon = getMemberAvatarDetails($CFG['user']['user_id']);
//<<<<--------------------Code Ends----------------------//
//--------------------Page block templates begins-------------------->>>>>//
//include the header file
$personal->includeHeader();
//include the content of the page
?>
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgConfirm');
</script>
<?php
setTemplateFolder('members/');
$smartyObj->display('profileAvatar.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
if ($CFG['feature']['jquery_validation']) {
$allowed_image_formats = implode("|", $CFG['admin']['members_profile']['image_format_arr']);
?>
<script type="text/javascript">
	$Jq("#selFormEditPersonalProfile").validate({
		rules: {
		    user_image: {
		    	required: true,
		    	isValidFileFormat: "<?php echo $allowed_image_formats; ?>"
		    }
		},
		messages: {
			user_image: {
				required : "<?php echo $personal->LANG['common_err_tip_required'];?>",
				isValidFileFormat: "<?php echo $personal->LANG['common_err_tip_invalid_image_format']; ?>"
			}
		}
	});
</script>
<?php
}
$personal->includeFooter();
?>