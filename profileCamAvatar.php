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

/**
 * To include config file
 */
require_once('./common/configs/config.inc.php'); //configurations
$CFG['lang']['include_files'][] = 'languages/%s/members/profileCamAvatar.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
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
		public $capture_images = '';

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
	 	  * @param string $cam_file
	 	  * @param mixed $camImage
	 	  * @return
	 	  */
	 	 public function storeImagesTempServer($uploadUrl, $extern, $cam_file = '', $camImage = false)
	 	 	{
				//GET LARGE IMAGE
				@chmod($uploadUrl.'.'.$extern, 0777);
				if($camImage)
					@chmod($cam_file.'.'.$extern, 0777);
				if($this->CFG['image_large_name']=='L')
					{
						if($this->CFG['image_large_height'] or $this->CFG['image_large_width'])
							{
								$this->imageObj->resize($this->CFG['image_large_width'], $this->CFG['image_large_height'], '-');
								$this->imageObj->output_resized($uploadUrl.'L.'.$extern, strtoupper($extern));
								if($camImage){
									$this->imageObj->output_resized($cam_file.'L.'.$extern, strtoupper($extern));
								}
								$image_info = getImageSize($uploadUrl.'L.'.$extern);
								$this->L_WIDTH = $image_info[0];
						        $this->L_HEIGHT = $image_info[1];
							}
						else
							{
								$this->imageObj->output_original($uploadUrl.'L.'.$extern, strtoupper($extern));
								if($camImage){
									$this->imageObj->output_original($cam_file.'L.'.$extern, strtoupper($extern));
								}
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
						if($camImage){
							$this->imageObj->output_resized($cam_file.'T.'.$extern, strtoupper($extern));
						}
						$image_info = getImageSize($uploadUrl.'T.'.$extern);
						$this->T_WIDTH = $image_info[0];
						$this->T_HEIGHT = $image_info[1];
					}

				//GET SMALL IMAGE
				if($this->CFG['image_small_name']=='S')
					{
						$this->imageObj->resize($this->CFG['image_small_width'], $this->CFG['image_small_height'], '-');
						$this->imageObj->output_resized($uploadUrl.'S.'.$extern, strtoupper($extern));
						if($camImage){
							$this->imageObj->output_resized($cam_file.'S.'.$extern, strtoupper($extern));
						}
						$image_info = getImageSize($uploadUrl.'S.'.$extern);
						$this->S_WIDTH = $image_info[0];
						$this->S_HEIGHT = $image_info[1];
					}

				//GET MINI IMAGE
				/*if($this->CFG['image_small_name']=='M')
					{
						$this->imageObj->resize($this->CFG['image_small_width'], $this->CFG['image_small_height'], '-');
						$this->imageObj->output_resized($uploadUrl.'M.'.$extern, strtoupper($extern));
						if($camImage){
							$this->imageObj->output_resized($cam_file.'M.'.$extern, strtoupper($extern));
						}
						$image_info = getImageSize($uploadUrl.'M.'.$extern);
						$this->M_WIDTH = $image_info[0];
						$this->M_HEIGHT = $image_info[1];
					}*/
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

				/*$wname = $this->CFG['admin']['members_profile']['mini_name'].'_WIDTH';
				$hname = $this->CFG['admin']['members_profile']['mini_name'].'_HEIGHT';
				$this->M_WIDTH = $this->$wname;
				$this->M_HEIGHT = $this->$hname;*/
			}

		/**
		 * EditProfileAvatarFormHandler::updateProfileImageExt()
		 *
		 * @param mixed $profile_image_ext
		 * @return
		 */
		public function updateProfileImageExt($profile_image_ext)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET '.
						'image_ext = '.$this->dbObj->Param($profile_image_ext).', '.
						'large_width='.$this->dbObj->Param('large_width').', large_height='.$this->dbObj->Param('large_height').', '.
						'thumb_width='.$this->dbObj->Param('thumb_width').', thumb_height='.$this->dbObj->Param('thumb_height').', '.
						'small_width='.$this->dbObj->Param('small_width').', small_height='.$this->dbObj->Param('small_height').' '.
						'WHERE user_id = '.$this->dbObj->Param('user_id');
						//'mini_width='.$this->dbObj->Param('mini_width').', mini_height='.$this->dbObj->Param('mini_height').' '.


				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($profile_image_ext,$this->L_WIDTH, $this->L_HEIGHT, $this->T_WIDTH, $this->T_HEIGHT, $this->S_WIDTH, $this->S_HEIGHT, $this->CFG['user']['user_id']));
				//$rs = $this->dbObj->Execute($stmt, array($profile_image_ext,$this->L_WIDTH, $this->L_HEIGHT, $this->T_WIDTH, $this->T_HEIGHT, $this->S_WIDTH, $this->S_HEIGHT, $this->M_WIDTH, $this->M_HEIGHT, $this->CFG['user']['user_id']));
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
		  	  $sql = 'SELECT image_ext FROM '.$this->CFG['db']['tbl']['users'].' WHERE user_id='.$this->dbObj->Param('user_id');
		  	  $stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				 $image_ext='';
				if($row = $rs->FetchRow())
				   $image_ext=$row['image_ext'];
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
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET '.
							    'image_ext =\'\', large_width=0, large_height=0, '.'thumb_width=0, thumb_height=0, '.'small_width=0, small_height=0 '.' WHERE user_id = '.$this->dbObj->Param('user_id');
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt,array($this->CFG['user']['user_id']));
						if (!$rs)
					        trigger_db_error($this->dbObj);

						$affected = $this->dbObj->Affected_Rows();
						if($affected>0){
							unlink($this->CFG['admin']['members_profile']['user_profile_folder'].$this->CFG['user']['user_id'].'L.'.$profile_avatar_ext);
							unlink($this->CFG['admin']['members_profile']['user_profile_folder'].$this->CFG['user']['user_id'].'T.'.$profile_avatar_ext);
							unlink($this->CFG['admin']['members_profile']['user_profile_folder'].$this->CFG['user']['user_id'].'S.'.$profile_avatar_ext);
							//unlink($this->CFG['admin']['members_profile']['user_profile_folder'].$this->CFG['user']['user_id'].'M.'.$profile_avatar_ext);
						}
					}
			}

		/**
		 * EditProfileAvatarFormHandler::deleteUserCamProfilePhoto()
		 *
		 * @param mixed $imageID
		 * @param mixed $imageName
		 * @return
		 */
		public function deleteUserCamProfilePhoto($imageID, $imageName)
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['profile_cam_image'].' WHERE profile_cam_image_id = '.$imageID;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				        trigger_db_error($this->dbObj);

				$affected = $this->dbObj->Affected_Rows();
				if($affected>0){
						unlink($this->CFG['admin']['members_profile']['user_profile_folder'].$this->CFG['user']['user_id'].'/'.$imageName.'L.jpg');
						unlink($this->CFG['admin']['members_profile']['user_profile_folder'].$this->CFG['user']['user_id'].'/'.$imageName.'T.jpg');
						unlink($this->CFG['admin']['members_profile']['user_profile_folder'].$this->CFG['user']['user_id'].'/'.$imageName.'S.jpg');
						//unlink($this->CFG['admin']['members_profile']['user_profile_folder'].$this->CFG['user']['user_id'].'/'.$imageName.'M.jpg');
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
				return implode(',',$arry_value);
			}

		/**
		 * EditProfileAvatarFormHandler::getCapturedImage()
		 *
		 * @param mixed $all
		 * @return
		 */
		public function getCapturedImage($all = false, $count=false)
			{
				 global $smartyObj;
				 $start = $this->getFormField('start');
			   	 $total_row='2';
			     $record_per_row='2';
			     //$limit = $total_row * $record_per_row;
			     $limit = $this->getFormField('total_captured_image_count');
				 $user_id = $this->CFG['user']['user_id'];

				 $sql = 'SELECT profile_cam_image_id, user_id, profile_image_name, profile_image_extension, date_added '.
						' FROM '.$this->CFG['db']['tbl']['profile_cam_image'].
						' WHERE user_id = '.$user_id.' ORDER BY date_added DESC';

				/*if(!$all){
					$sql .= ' ORDER BY date_added DESC LIMIT '.$start.','.$limit;
				}*/

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$record_count = $rs->PO_RecordCount();
				//echo 'total--->'.$record_count;
				if($count){
					return $record_count;
				}

				$capturePhotoArray = array();
				$inc = 0;
				$recordPerRow = '2';
				$count = 0;
				$found = false;

				if ($rs->PO_RecordCount()> 0){
					while($row = $rs->FetchRow()){
			       		$capturePhotoArray[$inc]['open_tr'] = false;
			      		if ($count%$recordPerRow==0)
				 			$capturePhotoArray[$inc]['open_tr']=true;

					   	$capturePhotoArray[$inc]['profile_cam_image_id']    = $row['profile_cam_image_id'];
					   	$capturePhotoArray[$inc]['user_id']                 = $row['user_id'];
					   	$capturePhotoArray[$inc]['profile_image_name']      = $row['profile_image_name'];
					   	$capturePhotoArray[$inc]['profile_image_extension'] = $row['profile_image_extension'];
					   	$capturePhotoArray[$inc]['date_added']              = $row['date_added'];

						$photos_folder = $this->CFG['admin']['members_profile']['user_profile_folder'].$user_id.'/';
					   	$url = $this->CFG['site']['url'].$photos_folder.$row['profile_image_name'].'%s.'.$row['profile_image_extension'];
					   	$capturePhotoArray[$inc]['imageSrc'] 				= (sprintf($url, 'S'));
					   	$capturePhotoArray[$inc]['imageLargeSrc']			= (sprintf($url, 'L'));

						$count++;
						$capturePhotoArray[$inc]['end_tr']=false;
						if ($count%$recordPerRow==0){
							$count = 0;
							$capturePhotoArray[$inc]['end_tr']=true;
				    	}
						$inc++;
					}
					$smartyObj->assign('LANG', $this->LANG);
					$smartyObj->assign('CFG', $this->CFG);
					$this->captureimage_last_tr_close = false;
					if ($found and $count and $count<$recordPerRow){
					    $this->captureimage_last_tr_close  = true;
				  	    $this->captureimage_per_row=$recordPerRow-$count;
			    	}
					$capturePhotoArray;
				}else{
					$capturePhotoArray=0;
				}

				$smartyObj->assign('capture_images',$capturePhotoArray);
				setTemplateFolder('members/');
				$smartyObj->display('profileCamAvatar.tpl');
			}

		/**
		 * EditProfileAvatarFormHandler::updateAjaxProfileImageExt()
		 *
		 * @param mixed $profile_image_ext
		 * @return
		 */
		public function updateAjaxProfileImageExt($profile_image_ext)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET '.
						'image_ext = '.$this->dbObj->Param($profile_image_ext).' '.
						'WHERE user_id = '.$this->dbObj->Param('user_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($profile_image_ext, $this->CFG['user']['user_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				return true;
			}

		/**
		 * EditProfileAvatarFormHandler::insertProfileImage()
		 *
		 * @param mixed $profile_image_name
		 * @param mixed $profile_image_ext
		 * @return
		 */
		public function insertProfileImage($profile_image_name, $profile_image_ext)
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['profile_cam_image'].' SET '.
							' user_id='.$this->dbObj->Param('user_id').','.
							' profile_image_name = '.$this->dbObj->Param($profile_image_name).', '.
							' profile_image_extension = '.$this->dbObj->Param($profile_image_ext).', '.
							' date_added=NOW()';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $profile_image_name, $profile_image_ext));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				return true;
			}

		/**
		 * EditProfileAvatarFormHandler::deleteCapturedImage()
		 *
		 * @return
		 */
		public function deleteCapturedImage()
			{
				$totalCapturedImages = '0';
				$capturedImageLimit = $this->CFG['profile']['captured_images_limit'];
				$sql = 'SELECT count(*) as total_captured_images FROM '.$this->CFG['db']['tbl']['profile_cam_image'].' WHERE user_id = '.$this->CFG['user']['user_id'];
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array());
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if($row = $rs->FetchRow()){
					$totalCapturedImages = $row['total_captured_images'];
				}
				$limitValue = ($totalCapturedImages - $capturedImageLimit)+1;
				$sql = 'SELECT * FROM '.$this->CFG['db']['tbl']['profile_cam_image'].' WHERE user_id = '.$this->CFG['user']['user_id'].' ORDER BY date_added ASC LIMIT '.$limitValue;

				$stmt = $this->dbObj->Prepare($sql);
				$result = $this->dbObj->Execute($stmt, array());

				if (!$result)
				        trigger_db_error($this->dbObj);

				if ($result->PO_RecordCount()){
					while($row = $result->FetchRow()){
						$this->deleteUserCamProfilePhoto($row['profile_cam_image_id'], $row['profile_image_name']);
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['profile_cam_image'].' WHERE profile_cam_image_id = '.$row['profile_cam_image_id'].' ORDER BY date_added ASC LIMIT 1';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array());
						if (!$rs)
						        trigger_db_error($this->dbObj);
				    }
				}
				return true;
			}
	}
//<<<<<---------------class EditProfileAvatarFormHandler------///
//--------------------Code begins-------------->>>>>//
$personal = new EditProfileAvatarFormHandler();
if(!$personal->chkAllowedModule(array('cam_profile_avatar')))
 	Redirect2URL($CFG['redirect']['dsabled_module_url']);
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
$personal->setFormField('start', 0);
$personal->setFormField('total_captured_image_count', $CFG['mugshot']['total_captured_image_count']);
$personal->setFormField('block', 'capturedImages');
$personal->setFormField('capturedPhoto', '');
$profile_image_max_size = ($CFG['admin']['members_profile']['profile_image_max_size'] * 1024);
//$personal->getCapturedImage(true);
// Default page block
$personal->setAllPageBlocksHide();
$personal->setPageBlockShow('form_editprofile');
if($personal->isFormPOSTed($_POST, 'confirm')){
   $personal->sanitizeFormInputs($_POST);
   if($personal->getFormField('action')=='delete_avatar'){
	   $personal->deleteUserProfilePhoto();
	   $personal->setAllPageBlocksHide();
	   $personal->setPageBlockShow('form_editprofile');
	   $personal->setPageBlockShow('block_msg_form_success');
	   $personal->setCommonSuccessMsg($LANG['profileavatar_success_delete_message']);
   }
}
if ($personal->isShowPageBlock('form_editprofile'))
	{
	  $LANG['profileavatar_upload_images']   = str_replace('{link}', $personal->getUrl('profileavatar'), $LANG['profileavatar_upload_images']);
	  $LANG['profileavatar_note'] 			 = str_replace('{limit}', $CFG['mugshot']['captured_images_limit'], $LANG['profileavatar_note']);
	  $personal->profileavatar_upload_images = $LANG['profileavatar_upload_images'];
	  $personal->profileavatar_note			 = $LANG['profileavatar_note'];
      $personal->avatar_image_exists         = $personal->checkAvatarImage();
      $personal->mugshotVersion              = $CFG['mugshot']['version'];
      if($CFG['mugshot']['version'] == 'mugshot_pro')
      	$personal->mugshotPath         		 = $CFG['site']['url'].'mugshot/pro/';
      else
      	$personal->mugshotPath         		 = $CFG['site']['url'].'mugshot/lite/';

      	$personal->mugshotLicensePath        = $CFG['site']['url'].'admin/';

      if(isAjaxPage() and $personal->isFormPOSTed($_POST, 'block'))
		{
			if(isset($_POST['start']) && !empty($_POST['start']))
				$personal->setFormField('start', $_POST['start']);
			$personal->includeAjaxHeaderSessionCheck();
			$block = $personal->getFormField('block');
			if($block == 'capturedImages'){
				$smartyObj->assign('personal',$personal);
				$personal->getCapturedImage(true);
			}
			$personal->includeAjaxFooter();
			exit;
		}
	}

if((isset($_POST['ajax']) && $_POST['ajax'] == '1') && (isset($_POST['capturedPhoto']))){
	$jpg       = base64_decode($_POST['capturedPhoto']);
	$imageName = $CFG['user']['user_id'];
	$dir       = $CFG['site']['project_path'].$CFG['admin']['members_profile']['user_profile_folder'];

	$personal->chkAndCreateFolder($dir);

	$profile_image_name = $imageName.'_'.time();
	$imageExtension     = 'jpg';
	$f                  = fopen($dir.$imageName.'.jpg', 'w');
	fwrite($f, $jpg);
	fclose($f);

	$imageObj = new ImageHandler($dir.$imageName.'.jpg');
	$personal->setIHObject($imageObj);
	$temp_dir = './'.$CFG['admin']['members_profile']['user_profile_folder'];
	$personal->chkAndCreateFolder($temp_dir);
	$temp_file = $temp_dir.$imageName;

	$cam_dir   = './'.$CFG['admin']['members_profile']['user_profile_folder'].$CFG['user']['user_id'].'/';
	$personal->chkAndCreateFolder($cam_dir);
	$cam_file  = $cam_dir.$profile_image_name;
	$camImage  = true;

	$capturedImageCount = $personal->getCapturedImage(true, true);
	/*if($capturedImageCount < $CFG['profile']['captured_images_limit'] || $CFG['profile']['captured_images_limit'] == 0)
		$camImage  = true;*/

	if($capturedImageCount >= $CFG['mugshot']['captured_images_limit'] AND $CFG['mugshot']['captured_images_limit'] !=0)
		$personal->deleteCapturedImage();


	$personal->storeImagesTempServer($temp_file, $imageExtension, $cam_file, $camImage);
	$personal->setFormField('image_ext', $imageExtension);
	$personal->updateProfileImageExt($imageExtension);
	$personal->insertProfileImage($profile_image_name, $imageExtension);
	/*if($camImage)
		$personal->insertProfileImage($profile_image_name, $imageExtension);*/

	@unlink($dir.$imageName.'.jpg');
	$copy = 'Y';
	$src      = $CFG['site']['url'].$CFG['admin']['members_profile']['user_profile_folder'].$CFG['user']['user_id'].$CFG['image_thumb_name'].'.'.$imageExtension.'?'.time();
	$userName = $CFG['user']['user_name'];
	$imgPath  = '<p><a onClick="return Confirmation(\'selMsgConfirm\', \'msgConfirmform\', Array(\'action\', \'confirmMessage\'), Array(\'delete_avatar\', \''.$LANG['profileavatar_delete_confirmation'].'\'), Array(\'value\', \'innerHTML\'))">'.$LANG['profileavatar_delete_image'].'</a></p>';
	$imgPath .= '<div class="cls90PXthumbImage clsThumbImageOuter"><div class="clsrThumbImageMiddle"><div class="clsThumbImageInner">';
	$imgPath .= '<img src="'.$src.'" alt="'.$userName.'" title="'.$userName.'" border="0">';
	$imgPath .= '</div></div></div>';

	$copy .= '|'.$imgPath;
	echo $copy;exit;
}
elseif((isset($_POST['ajax']) && $_POST['ajax'] == '1') && (isset($_POST['delImageId']))){
	$personal->deleteUserCamProfilePhoto($_POST['delImageId'], $_POST['ImageName']);
	echo 'Y';exit;
}
elseif(isset($_POST['ajax']) && $_POST['ajax'] == '1'){
	$copy = 'N';
	$imageName = $_POST['imageName'];
	$photos_folder = $CFG['admin']['members_profile']['user_profile_folder'].$CFG['user']['user_id'].'/';
	//$source = $CFG['site']['project_path'].$photos_folder.$_POST['imageName'].'%s.'.$_POST['imageExtension'];
	$destination = $CFG['site']['project_path'].$CFG['admin']['members_profile']['user_profile_folder'];

	@chmod($destination, 0777);
	if($CFG['image_large_name']=='L'){
		$source = $CFG['site']['project_path'].$photos_folder.$_POST['imageName'].'%s.'.$_POST['imageExtension'];
		$source      = sprintf($source, $CFG['image_large_name']);
		if(is_file($source)){
			if(@copy($source, $destination.$CFG['user']['user_id'].$CFG['image_large_name'].'.'.$_POST['imageExtension'])){
				$copy = 'Y';
			}
		}
	}

	/*if($CFG['admin']['members_profile']['mini_name']=='M'){
		$source = $CFG['site']['project_path'].$photos_folder.$_POST['imageName'].'%s.'.$_POST['imageExtension'];
		$source      = sprintf($source, $CFG['admin']['members_profile']['mini_name']);
		if(is_file($source)){
			if(@copy($source, $destination.$CFG['user']['user_id'].$CFG['admin']['members_profile']['mini_name'].'.'.$_POST['imageExtension'])){
				$copy = 'Y';
			}
		}
	}*/

	if($CFG['image_small_name']=='S'){
		$source = $CFG['site']['project_path'].$photos_folder.$_POST['imageName'].'%s.'.$_POST['imageExtension'];
		$source      = sprintf($source, $CFG['image_small_name']);
		if(is_file($source)){
			if(@copy($source, $destination.$CFG['user']['user_id'].$CFG['image_small_name'].'.'.$_POST['imageExtension'])){
				$copy = 'Y';
			}
		}
	}

	if($CFG['image_thumb_name']=='T'){
		$source = $CFG['site']['project_path'].$photos_folder.$_POST['imageName'].'%s.'.$_POST['imageExtension'];
		$source      = sprintf($source, $CFG['image_thumb_name']);
		if(is_file($source)){
			if(@copy($source, $destination.$CFG['user']['user_id'].$CFG['image_thumb_name'].'.'.$_POST['imageExtension'])){
				$copy = 'Y';
			}
		}
	}
	if(!$personal->updateAjaxProfileImageExt($_POST['imageExtension']))
		$copy = 'N';

	$src      = $CFG['site']['url'].$CFG['admin']['members_profile']['user_profile_folder'].$CFG['user']['user_id'].$CFG['image_thumb_name'].'.'.$_POST['imageExtension'].'?'.time();
	$userName = $CFG['user']['user_name'];
	$imgPath  = '<p><a onClick="return Confirmation(\'selMsgConfirm\', \'msgConfirmform\', Array(\'action\', \'confirmMessage\'), Array(\'delete_avatar\', \''.$LANG['profileavatar_delete_confirmation'].'\'), Array(\'value\', \'innerHTML\'))">'.$LANG['profileavatar_delete_image'].'</a></p>';
	$imgPath .= '<div class="cls90PXthumbImage clsThumbImageOuter"><div class="clsrThumbImageMiddle"><div class="clsThumbImageInner">';
	$imgPath .= '<img src="'.$src.'" alt="'.$userName.'" title="'.$userName.'" border="0">';
	$imgPath .= '</div></div></div>';
	$copy .= '|'.$imgPath;
	echo $copy;exit;

}

$personal->icon = getMemberAvatarDetails($CFG['user']['user_id']);
$icon_arr = explode('/',$personal->icon['t_url']);
$count = count($icon_arr);
$val = $count-2;
if($icon_arr[$val] == 'no_image')
	$noimage = 'Yes';
else
    $noimage = 'No';
$smartyObj->assign('noimage',$noimage);
$smartyObj->assign('personal',$personal);
//<<<<--------------------Code Ends----------------------//
//--------------------Page block templates begins-------------------->>>>>//

//include the header file
$personal->includeHeader();
//include the content of the page
?>
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/root/css/<?php echo $CFG['html']['stylesheet']['screen']['default'];?>/mugshot_avatar.css">
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgConfirm');
	function uploadCapturePhoto(rawData){
		var url    = '<?php echo $CFG['site']['current_url'];?>';
		var pars   = "ajax=1&capturedPhoto="+encodeURIComponent(rawData);
		var site_url = '<?php echo $CFG['site']['url'];?>';
		var template_default = '<?php echo $CFG['html']['template']['default']; ?>';
		var loadingImage = "<img src='"+site_url+"/design/templates/"+template_default+"/images/loader.gif"+"' alt='loading'\/>";
		$Jq.ajax({
			type: 'POST',
			url: url,
			data: pars,
			processData:false,
			beforeSend:function(){
				$Jq('#displayProfileImage').html(loadingImage);
			},
			success:function (data){
				data = data.split("|");
				if(data[0] == 'Y'){
						$Jq('#displayProfileImage').html(data[1]);
						loadCapturedImage();
						alert('<?php echo $LANG['profileavatar_success_update_message'];?>');
					}else{
						alert('<?php echo $LANG['common_msg_error_sorry'];?>');
					}
			}
		 });
	}

	/**
	 *
	 * @access public
	 * @return void
	 **/
	function loadCapturedImage(){
			var site_url = '<?php echo $CFG['site']['url'];?>';
			var template_default = '<?php echo $CFG['html']['template']['default']; ?>';
			var url    = '<?php echo $CFG['site']['current_url'];?>';
			var pars = "block=capturedImages";
			var loadingImage = "<img src='"+site_url+"/design/templates/"+template_default+"/images/loader.gif"+"' alt='loading'\/>";
			$Jq.ajax({
				type: 'POST',
				url: url,
				data: pars,
				beforeSend:function(){
					$Jq('#camImages').html(loadingImage);
				},
				success:function (data){
					if(data){
							$Jq('#camImages').html(data);
						}else{
							alert('<?php echo $LANG['common_msg_error_sorry'];?>');
						}
				}
			});
	}

	function displayDeletelmage(displayOption, divId){
		$Jq('#profileImageDel_'+divId).css("visibility", displayOption);
		return false;
	}

	function deleteImage(imageId, ImageName){
		var url    = '<?php echo $CFG['site']['current_url'];?>';
		var pars   = 'ajax=1&delImageId='+imageId+'&ImageName='+ImageName;
		$Jq.ajax({
			type: 'POST',
			url: url,
			data: pars,
			success:function (data){
				if(data == 'Y'){
					loadCapturedImage();
					alert('<?php echo $LANG['captured_images_success_delete_message'];?>');
				}else{
					alert('<?php echo $LANG['common_msg_error_sorry'];?>');
				}
			}
			});
	}

	function makeProfileImage(imageId, imageName, imageExtension){
		var url  = '<?php echo $CFG['site']['current_url'];?>';
		var pars = 'ajax=1&imageId='+imageId+'&imageName='+imageName+'&imageExtension='+imageExtension;
		var site_url = '<?php echo $CFG['site']['url'];?>';
		var template_default = '<?php echo $CFG['html']['template']['default']; ?>';
		var loadingImage = "<img src='"+site_url+"/design/templates/"+template_default+"/images/loader.gif"+"' alt='loading'\/>";
		$Jq.ajax({
			type: 'POST',
			url: url,
			data: pars,
			beforeSend:function(){
				$Jq('#displayProfileImage').html(loadingImage);
			},
			success:function (data){
				data = arguments[0].responseText;
				data = data.split("|");
				if(data[0] == 'Y'){
					alert('<?php echo $LANG['profileavatar_success_update_message'];?>');
					$Jq('#displayProfileImage').html(data[1]);
				}else{
					alert('<?php echo $LANG['common_msg_error_sorry'];?>');
				}
			}
		});
	}

   	function popupWindow(url){
   		alert(url);
   		window.open (url, "","status=0,toolbar=0,resizable=1,scrollbars=1");
		return false;
	}

</script>
<?php
setTemplateFolder('members/');
$smartyObj->display('profileCamAvatar.tpl');
?>
<?php
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$personal->includeFooter();
?>