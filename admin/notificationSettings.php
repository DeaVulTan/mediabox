<?php
/**
 * This file hadling the email notification settings
 *
 * email notification settings used to control the email send
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php'); //configurations
$CFG['lang']['include_files'][] = 'languages/%s/admin/notificationSettings.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------- Class editConfigData begins --------------->>>>>//
/**
 * This class hadling the email notification settings
 *
 * @category	Rayzz
 * @package		Admin
 */
class notificationSettings extends FormHandler
	{
		/**
		 * notificationSettings::populateNotification()
		 * To populate the email notification settings
		 *
		 * @return 	array
		 * @access 	public
		 */
		public function populateNotification()
			{
				$sql = ' SELECT * FROM '.$this->CFG['db']['tbl']['notification'].' ORDER BY module';

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
								$populateNotification_arr[$inc]['record'] = $row;
								$populateNotification_arr[$inc]['notification_text'] = $this->LANG['notificationSettings_'.$row['notification']];
								$populateNotification_arr[$inc]['module_text'] = $this->LANG['notificationSettings_module_'.$row['module']];
								$populateNotification_arr[$inc]['default_status_id'] = 'defaultstatus_'.$row['notification_id'];
								$populateNotification_arr[$inc]['changeable_by_user_id'] = 'changeablebyuser_'.$row['notification_id'];
								$this->setFormField($populateNotification_arr[$inc]['default_status_id'], $row['default_status']);
								$this->setFormField($populateNotification_arr[$inc]['changeable_by_user_id'], $row['changeable_by_user']);
								$inc++;
							}
					}
				return $populateNotification_arr;
			}

		/**
		 * notificationSettings::resetFieldsArray()
		 * To inirtialize the form fields value
		 *
		 * @return
		 * @access 	public
		 */
		public function resetFieldsArray()
			{
				$this->setFormField('nid', '');
			}

		/**
		 * notificationSettings::updateNotification()
		 * To update the email notification settings
		 *
		 * @return
		 * @access 	public
		 */
		public function updateNotification()
			{
				foreach($this->block_notification_edit['populateNotification'] as $key=>$value)
					{
						$data_arr = array();
						$data_arr[] = $this->getFormField($value['default_status_id']);
						$data_arr[] = $this->getFormField($value['changeable_by_user_id']);
						$data_arr[] = $value['record']['notification_id'];

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['notification'].' SET'.
								' default_status = '.$this->dbObj->Param('default_status').','.
								' changeable_by_user = '.$this->dbObj->Param('changeable_by_user').' WHERE'.
								' notification_id = '.$this->dbObj->Param('notification_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $data_arr);
							if (!$rs)
								trigger_db_error($this->dbObj);
					}
			}
	}

//<<<<<-------------- Class editConfigData begins ---------------//
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
		if($CFG['admin']['is_demo_site'])
			{
				$notificationSettings->setCommonErrorMsg($LANG['general_config_not_allow_demo_site']);
				$notificationSettings->setPageBlockShow('block_msg_form_error');
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
$notificationSettings->left_navigation_div = 'generalSetting';
//include the header file
$notificationSettings->includeHeader();
//include the content of the page
setTemplateFolder('admin/');
$smartyObj->display('notificationSettings.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$notificationSettings->includeFooter();
?>