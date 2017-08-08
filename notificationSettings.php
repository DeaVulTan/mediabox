<?php
/**
 * File handling Email notification settings
 *
 *
 * PHP version 5.0
 *
 * @category	Members
 * @package		notification settings
 * @author 		selvaraj_007at09
 * @copyright 	Copyright (c) 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2010-04-30
 */
/**
 * File having common configuration variables required for the entire project
 */
require_once('./common/configs/config.inc.php'); //configurations
$CFG['lang']['include_files'][] = 'languages/%s/admin/notificationSettings.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------- Class notificationSettings begins --------------->>>>>//
/**
 * notificationSettings
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class notificationSettings extends FormHandler
	{
		/**
		 * notificationSettings::populateNotification()
		 *
		 * @return
		 */
		public function populateNotification()
			{
				$sql = 'SELECT * FROM '.$this->CFG['db']['tbl']['notification'].' ORDER BY module';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array());
				if (!$rs)
					trigger_db_error($this->dbObj);

				$populateNotification_arr = array();
				if($rs->PO_RecordCount())
					{
						$inc = 0;
						while($row = $rs->FetchRow())
							{
								if($row['changeable_by_user'] == 'No')
									{
										continue;
									}
								if($status = getNotificationUserSettings($this->CFG['user']['user_id'], $row['notification_id']))
									{
										$row['default_status'] = $status;
									}
								$populateNotification_arr[$inc]['record'] = $row;
								$populateNotification_arr[$inc]['notification_text'] = $this->LANG['notificationSettings_'.$row['notification']];
								$populateNotification_arr[$inc]['module_text'] = $this->LANG['notificationSettings_module_'.$row['module']];
								$populateNotification_arr[$inc]['default_status_id'] = 'defaultstatus_'.$row['notification_id'];
								$this->setFormField($populateNotification_arr[$inc]['default_status_id'], $row['default_status']);
								$inc++;
							}
					}
				return $populateNotification_arr;
			}

		/**
		 * notificationSettings::resetFieldsArray()
		 *
		 * @return
		 */
		public function resetFieldsArray()
			{
				$this->setFormField('nid', '');
			}

		/**
		 * notificationSettings::chkIsAlreadyAdded()
		 *
		 * @param mixed $notification_id
		 * @return
		 */
		public function chkIsAlreadyAdded($notification_id)
			{
				$data_arr[] = $this->CFG['user']['user_id'];
				$data_arr[] = $notification_id;

				$sql = 'SELECT notification_settings_id FROM '.$this->CFG['db']['tbl']['notification_settings'].
						' WHERE user_id = '.$this->dbObj->Param('user_id').
						' AND notification_id = '.$this->dbObj->Param('notification_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $data_arr);
				if (!$rs)
					trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						return $row['notification_settings_id'];
					}
				return false;
			}

		/**
		 * notificationSettings::updateNotification()
		 *
		 * @return
		 */
		public function updateNotification()
			{
				foreach($this->block_notification_edit['populateNotification'] as $key=>$value)
					{
						$data_arr = array();

						if($notification_settings_id = $this->chkIsAlreadyAdded($value['record']['notification_id']))
							{
								$data_arr[] = $this->getFormField($value['default_status_id']);
								$data_arr[] = $notification_settings_id;

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['notification_settings'].
										' SET status = '.$this->dbObj->Param('status').
										' WHERE notification_settings_id = '.$this->dbObj->Param('notification_settings_id');
							}
						else
							{
								$data_arr[] = $this->CFG['user']['user_id'];
								$data_arr[] = $value['record']['notification_id'];
								$data_arr[] = $this->getFormField($value['default_status_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['notification_settings'].
										' SET user_id = '.$this->dbObj->Param('user_id').
										', notification_id = '.$this->dbObj->Param('notification_id').
										', status = '.$this->dbObj->Param('status').
										', date_added = NOW()';
							}
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $data_arr);
						if (!$rs)
							trigger_db_error($this->dbObj);
					}
			}
	}
//<<<<<-------------- Class notificationSettings begins ---------------//
//-------------------- Code begins -------------->>>>>//
$notificationSettings = new notificationSettings();
$notificationSettings->setPageBlockNames(array('block_notification_edit'));
//default form fields and values...
$notificationSettings->resetFieldsArray();

$notificationSettings->setAllPageBlocksHide();
$notificationSettings->setPageBlockShow('block_notification_edit'); //default page block. show it. All others hidden
$notificationSettings->sanitizeFormInputs($_REQUEST);

if(!($notificationSettings->block_notification_edit['populateNotification'] = $notificationSettings->populateNotification()))
	{
		$notificationSettings->setAllPageBlocksHide();
		$notificationSettings->setCommonErrorMsg($LANG['notificationSettings_no_data_to_edit']);
		$notificationSettings->setPageBlockShow('block_msg_form_error');
	}
if($notificationSettings->isFormPOSTed($_POST, 'update_submit'))
	{
		if(isAdmin() and $CFG['admin']['is_demo_site'])
			{
				$notificationSettings->setAllPageBlocksHide();
				$notificationSettings->setCommonErrorMsg($LANG['general_config_not_allow_demo_site']);
				$notificationSettings->setPageBlockShow('block_msg_form_error');
				$notificationSettings->setPageBlockShow('block_notification_edit');
			}
		else
			{
				$notificationSettings->sanitizeFormInputs($_REQUEST);

				if($notificationSettings->isValidFormInputs())
					{
						$notificationSettings->updateNotification();
						$notificationSettings->setPageBlockShow('block_msg_form_success');
						$notificationSettings->setCommonSuccessMsg($LANG['common_success_updated']);
					}
				else
					{
						$notificationSettings->setAllPageBlocksHide();
						$notificationSettings->setPageBlockShow('block_notification_edit');
						$notificationSettings->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$notificationSettings->setPageBlockShow('block_msg_form_error');
					}
			}
	}
//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//
//include the header file
$notificationSettings->includeHeader();
//include the content of the page
setTemplateFolder('members/');
$smartyObj->display('notificationSettings.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$notificationSettings->includeFooter();
?>