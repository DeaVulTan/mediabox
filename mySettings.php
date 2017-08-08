<?php
/**
 * File handling the My_Ssettings
 *
 *
 * PHP version 5.0
 *
 * @category	framework
 * @package		members
 * @author 		guruprasad_20ag08
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: pollManagement.php 197 2008-04-22 14:33:47Z guruprasad_20ag08 $
 * @since 		2008-04-22
 */
require_once('./common/configs/config.inc.php'); //configurations
$CFG['lang']['include_files'][] = 'languages/%s/members/mySettings.php';
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
//-------------- Class mySettingsFormHandler begins --------------->>>>>//
/**
 * mySettings
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class mySettings extends FormHandler
	{
		/**
		 * Update user table for settings
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function updateChangedSettings()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
						 ' SET pref_lang ='.$this->dbObj->Param('lang').
						 ', pref_template ='.$this->dbObj->Param('template').
						 ', news_letter ='.$this->dbObj->Param('news_letter').
						 ' WHERE user_id ='.$this->CFG['user']['user_id'];

				$input_arr = array($this->getformfield('lang'),
									$this->getformfield('template'),
									$this->getformfield('news_letter'));
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $input_arr);
					if (!$rs)
						trigger_db_error($this->dbObj);
			}

		/**
		 * To get the user details from the DB
		 *
		 * @return 		array has array with field values
		 * @access 		public
		 */
		public function getUserDetailsArrFromDB()
			{
				return $user_detail = $this->getUserDetail('user_id', $this->CFG['user']['user_id']);
			}
	}
//<<<<<-------------- Class mySettings FormHandler begins ---------------//
//-------------------- Code begins -------------->>>>>//
$myset = new mySettings();
$myset->setPageBlockNames(array('block_form_update_password'));
//default form fields and values...
$myset->setFormField('lang', '');
$myset->setFormField('template', '');
$myset->setFormField('news_letter', 'Yes');

$myset->setAllPageBlocksHide();
$myset->setPageBlockShow('block_form_my_settings'); //default page block. show it. All others hidden
$myset->sanitizeFormInputs($_POST);

if ($myset->isFormPOSTed($_POST, 'cancel_settings'))
	{
		Redirect2Url(getUrl('index'));
	}

if ($myset->isFormPOSTed($_POST, 'change_settings'))
	{
		if ($myset->isValidFormInputs())
			{
				$myset->setAllPageBlocksHide();
				// update the details into user table
				$myset->updateChangedSettings();
				$myset->setCommonSuccessMsg($myset->LANG['my_settings_update_message']);
				$myset->setPageBlockShow('block_msg_form_success');
				$myset->setFormField('lang', '');
				$myset->setFormField('template', '');
				$myset->setPageBlockShow('block_form_my_settings');
			}
		else //error in form inputs
			{
				$myset->setAllPageBlocksHide();
				$myset->setCommonErrorMsg($myset->LANG['common_msg_error_sorry']);
				$myset->setPageBlockShow('block_msg_form_error');
				$myset->setPageBlockShow('block_form_my_settings');
			}
	}
else
	{
		$user_detail = $myset->getUserDetailsArrFromDB();
		$myset->setFormField('lang', $user_detail['pref_lang']);
		$myset->setFormField('template',  $user_detail['pref_template']);
		$myset->setFormField('news_letter',  $user_detail['news_letter']);
	}
//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//
//include the header file
$myset->includeHeader();
//include the content of the page
setTemplateFolder('members/');
$smartyObj->display('mySettings.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$myset->includeFooter();
?>