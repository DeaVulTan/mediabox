<?php
/**
 * This file manages the user profile
 *
 * This file is having EditProfileFormHandler class to edit the user profile
 * and update the changes made by admin
 *
 * PHP version 5.0
 *
 * @category	###Framework###
 * @package		###Admin###
 * @author 		selvaraj_47ag04###
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: userProfilesEdit.php 766 2008-06-26 09:52:00Z selvaraj_47ag04 $
 * @since 		2008-04-02
 */
 /**
  * Including the config file to get the global data for site
  */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/userProfilesEdit.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
//The Language stuffs for help tips. This include file will also be used in other files where help tips are necessary.
$CFG['mods']['include_files'][] = 'languages/%s/lists_array/countries_list_array.inc.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//--------------class EditProfileFormHandler --------------->>>//
/**
 * EditProfileFormHandler is to edit the user profiles and update the changes
 */
class EditProfileFormHandler extends FormHandler
	{
		/**
		  * Update the form values into users table
		  *
		  * @param 		array $fields_to_update_arr Array of fields
		  * @return 	void
		  * @access 	public
		  */
		public function updateFormFieldsInUsersTable($fields_to_update_arr=array())
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET ';
				foreach($fields_to_update_arr as $field_name)
					if (isset($this->fields_arr[$field_name]))
						$sql .= $field_name.'=\''.addslashes($this->getFormField($field_name)).'\', ';
				$sql = substr($sql, 0, strrpos($sql, ','));
				// set status
				if ($this->getFormField('usr_status'))
					$sql .= ',usr_status = \''.$this->getFormField('usr_status').'\'';
				// condition
				$sql .= ' WHERE user_id ='.$this->dbObj->Param('user_id');

				// prepare query
				$stmt = $this->dbObj->Prepare($sql);
				// execute query
				$result = $this->dbObj->Execute($stmt, array($this->getFormField('user_id')));
				//raise user error... fatal
				if (!$result)
						trigger_db_error($this->dbObj);
			}

		/**
		 * To get the user details
		 *
		 * @return 		array has array with field values
		 * @access 		public
		 */
		public function getUserDetailsArrFromDB()
			{
				$fields_arr = array('user_name', 'password', 'first_name',
							 	   'last_name', 'gender', 'dob', 'email', 'phone', 'fax',
								   'address', 'city', 'state',
								   'country', 'usr_status');

				$user_detail = $this->getUserDetail('user_id', $this->fields_arr['user_id']);
				if($user_detail)
					{
						foreach($fields_arr as $field_name)
							$this->setFormField($field_name, isset($user_detail[$field_name]) ? $user_detail[$field_name] : '');
						return true;
					}
				return false;
			}

		/**
		 * To check for the duplicate user name
		 *
		 * @param 		string $err_tip error tip
		 * @return 		boolean true/false
		 * @access 		public
		 */
		public function chkIsDuplicateUserName($err_tip='')
			{
				$user_detail = $this->getUserDetail('user_name', $this->fields_arr['user_name']);
				if(!$user_detail)
					{
						return true;
					}
				$this->setFormFieldErrorTip('user_name', $err_tip);
				return false;
			}

		/**
		 * To insert the form fields
		 *
		 * @param		array $fields_to_insert_arr Array of fields to insert
		 * @return 		void
		 * @access		public
		*/
		public function insertFormFieldsInUSerTable($fields_to_insert_arr=array())
			{
				// field name, parameters and fields value are intialized
				$field_names_separated_by_comma = 'doj, ';
				$parameters_separated_by_comma  = 'NOW(), ';
				$field_values_arr = array();
				// field name, parameters and fields value are set
				foreach($fields_to_insert_arr as $field_name)
					if (isset($this->fields_arr[$field_name]))
						{
							$field_names_separated_by_comma .= $field_name.', ';
							$parameters_separated_by_comma .= $this->dbObj->Param($field_name).', ';
							$field_values_arr[] = $this->getFormField($field_name);
						}
				// eleminates last comma
				$field_names_separated_by_comma = substr($field_names_separated_by_comma, 0, strrpos($field_names_separated_by_comma, ','));
				$parameters_separated_by_comma = substr($parameters_separated_by_comma, 0, strrpos($parameters_separated_by_comma, ','));
				// generates query INSERT INTO users (user_name, email, password, first_name, last_name, phone, fax, address, city, state, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['users'].
						' ( '.$field_names_separated_by_comma.') '.
						' VALUES ('.$parameters_separated_by_comma.')';
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$result = $this->dbObj->Execute($stmt, $field_values_arr);
				//raise user error... fatal
				if (!$result)
						trigger_db_error($this->dbObj);
		    }

		/**
		 * To check the username has changed or not
		 *
		 * @param		string $err_tip Error tip
		 * @return 		void
		 * @access		public
		*/
		public function chkIsSameUserNameAndPassword($err_tip = '')
			{
				$user_detail = $this->getUserDetail('user_name', $this->fields_arr['user_name']);
				if($user_detail)
					{
						return true;
					}
				$this->setCommonErrorMsg($err_tip);
				return false;
		    }

		public function chkIsDuplicateEmail($err_tip = '')
			{
				$user_id = $this->getUserDetail('email', $this->fields_arr['email'], 'user_id');
				if($user_id and ($this->fields_arr['user_id']!=$user_id))
					{
						$this->setFormFieldErrorTip('email', $err_tip);
						return false;
					}
				return true;
			}

		public function chkIsAllowedUserName($err_tip = '')
			{
				if($this->CFG['restricted_user_name'])
					{
						$user_name = strtolower($this->fields_arr['user_name']);
						if(in_array($user_name, $this->CFG['admin']['not_allowed_usernames']))
							{
								$this->setFormFieldErrorTip('user_name', $err_tip);
								return false;
							}
						return true;
					}
			}

		public function chkIsUserNameAndPasswordEqual($err_tip = '')
			{
				if(strtolower($this->fields_arr['user_name']) == strtolower($this->fields_arr['password']))
					{
						$this->setFormFieldErrorTip('user_name', $err_tip);
						$this->setFormFieldErrorTip('password', $err_tip);
						return false;
					}
				return true;
			}

		public function chkIsAllowableAge($field_name, $err_tip = '')
			{
				$sql = 'SELECT IF(DATE_FORMAT(DATE_SUB(NOW(), INTERVAL '.$this->CFG['signup_age_limit'].') , \'%Y-%m-%d\')<\''.$this->getFormField($field_name).'\',\'false\',\'true\') AS d';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();

				if($row['d']=='false')
					{
						$this->setFormFieldErrorTip($field_name, $err_tip);
						return false;
					}
				return true;
			}
	}
//<<<<<---------------class EditProfileFormHandler ends -------------///
//--------------------Code begins-------------->>>>>//
$editprofilefrm = new EditProfileFormHandler();
$editprofilefrm->edit_profile_commit = false;
$editprofilefrm->setPageBlockNames(array('block_form_editprofile'));
//default form fields and values...
$editprofilefrm->setFormField('user_id', '');
$editprofilefrm->setFormField('act', '');
$editprofilefrm->setFormField('user_name', '');
$editprofilefrm->setFormField('password', '');
$editprofilefrm->setFormField('first_name', '');
$editprofilefrm->setFormField('last_name', '');
$editprofilefrm->setFormField('gender', 'm');
$editprofilefrm->setFormField('dob', '');
$editprofilefrm->setFormField('email', '');
$editprofilefrm->setFormField('phone', '');
$editprofilefrm->setFormField('fax', '');
$editprofilefrm->setFormField('address', '');
$editprofilefrm->setFormField('city', '');
$editprofilefrm->setFormField('state', '');
$editprofilefrm->setFormField('country', '');
$editprofilefrm->setFormField('usr_status', '');
$editprofilefrm->setFormField('backkey', '');

// Array of user status
$status_arr = array('Ok' => $LANG['editprofile_active'],
				    'Locked' => $LANG['editprofile_locked']);

//Submit button name and value
$submit_button_name = 'editprofile_add_submit';
$submit_button_value = $LANG['editprofile_add_submit'];
if ($editprofilefrm->isFormPOSTed($_POST, 'cancel'))
	{
		Redirect2Url('userProfiles.php');
	}
if ($editprofilefrm->isPageGETed($_REQUEST, 'act'))
	{
		$editprofilefrm->sanitizeFormInputs($_REQUEST);
		if ($editprofilefrm->getFormField('act') == 'edit')
			{
			    if ($editprofilefrm->isFormGETed($_REQUEST, 'user_id'))
					{
						$is_user_exists = FALSE;
						$is_user_exists = $editprofilefrm->getUserDetailsArrFromDB();

						if ($is_user_exists)
							{
								$submit_button_name = 'editprofile_edit_submit';
								$submit_button_value = $LANG['editprofile_update_submit'];
								$editprofilefrm->setAllPageBlocksHide();
								$editprofilefrm->setPageBlockShow('block_form_editprofile');
							}
						else
							{
								$editprofilefrm->setAllPageBlocksHide();
								$editprofilefrm->setFormField('error_message', $LAGN['editprofile_user_not_found']);
								$editprofilefrm->setPageBlockShow('block_msg_form_error');
							}
					 }
				else
					{
						$editprofilefrm->setAllPageBlocksHide();
						$editprofilefrm->setPageBlockShow('block_form_editprofile');
					}
			}
		else
			{
				$editprofilefrm->setAllPageBlocksHide();
				$editprofilefrm->setPageBlockShow('block_form_editprofile');
			}
	}
else
	{
		$editprofilefrm->setAllPageBlocksHide();
		$editprofilefrm->setPageBlockShow('block_form_editprofile');
	}

if ($editprofilefrm->isFormPOSTed($_POST, 'editprofile_add_submit'))
	{
		$editprofilefrm->sanitizeFormInputs($_POST);
		// Validations
		$editprofilefrm->chkIsNotEmpty('user_name', $LANG['common_err_tip_compulsory']) and
			$editprofilefrm->chkIsAlphaNumeric('user_name', $LANG['editprofile_err_tip_invalid_username']) and
			$editprofilefrm->chkIsValidSize('user_name', 'username', $editprofilefrm->LANG['editprofile_err_tip_username_size']) and
			$editprofilefrm->chkIsAllowedUserName($editprofilefrm->LANG['editprofile_err_tip_username_restricted']) and
			$editprofilefrm->chkIsDuplicateUserName($LANG['editprofile_name_already_exists']);
		$editprofilefrm->chkIsNotEmpty('password', $LANG['common_err_tip_compulsory']) and
			$editprofilefrm->chkIsValidSize('password', 'password', $editprofilefrm->LANG['editprofile_err_tip_password_size']) and
			$editprofilefrm->chkIsUserNameAndPasswordEqual($editprofilefrm->LANG['editprofile_err_tip_username_password_not_equal']);
		$editprofilefrm->chkIsNotEmpty('first_name', $LANG['common_err_tip_compulsory']);
		$editprofilefrm->chkIsNotEmpty('last_name', $LANG['common_err_tip_compulsory']);

		$editprofilefrm->chkIsNotEmpty('dob', $editprofilefrm->LANG['common_err_tip_compulsory']) and
			$editprofilefrm->chkIsValidDate('dob', $editprofilefrm->LANG['editprofile_err_tip_invalid_date']) and
			$editprofilefrm->chkIsAllowableAge('dob', str_replace('VAR_MIN_AGE', $editprofilefrm->CFG['signup_age_limit'], $editprofilefrm->LANG['editprofile_err_tip_minimum_age']));

		$editprofilefrm->chkIsNotEmpty('gender', $editprofilefrm->LANG['common_err_tip_compulsory']);
		$editprofilefrm->chkIsNotEmpty('email', $LANG['common_err_tip_compulsory']) and
		$editprofilefrm->chkIsValidEmail('email', $LANG['editprofile_err_tip_invalid']) and
			$editprofilefrm->chkIsDuplicateEmail($LANG['editprofile_err_tip_email_exist']);
		$editprofilefrm->chkIsNotEmpty('phone', $LANG['common_err_tip_compulsory']);
		$editprofilefrm->chkIsNotEmpty('fax', $LANG['common_err_tip_compulsory']);
		$editprofilefrm->chkIsNotEmpty('address', $LANG['common_err_tip_compulsory']);
		$editprofilefrm->chkIsNotEmpty('city', $LANG['common_err_tip_compulsory']);
		$editprofilefrm->chkIsNotEmpty('state', $LANG['common_err_tip_compulsory']);
		$editprofilefrm->chkIsNotEmpty('country', $LANG['common_err_tip_compulsory']);
		$editprofilefrm->edit_profile_commit = true;
	}

if ($editprofilefrm->isFormPOSTed($_POST, 'editprofile_edit_submit'))
	{
		$editprofilefrm->sanitizeFormInputs($_POST);

		$editprofilefrm->chkIsNotEmpty('first_name', $LANG['common_err_tip_compulsory']);
		$editprofilefrm->chkIsNotEmpty('last_name', $LANG['common_err_tip_compulsory']);

		$editprofilefrm->chkIsNotEmpty('dob', $editprofilefrm->LANG['common_err_tip_compulsory']) and
			$editprofilefrm->chkIsValidDate('dob', $editprofilefrm->LANG['editprofile_err_tip_invalid_date']) and
			$editprofilefrm->chkIsAllowableAge('dob', str_replace('VAR_MIN_AGE', $editprofilefrm->CFG['signup_age_limit'], $editprofilefrm->LANG['editprofile_err_tip_minimum_age']));

		$editprofilefrm->chkIsNotEmpty('gender', $editprofilefrm->LANG['common_err_tip_compulsory']);
		$editprofilefrm->chkIsNotEmpty('email', $LANG['common_err_tip_compulsory']) and
			$editprofilefrm->chkIsValidEmail('email', $LANG['editprofile_err_tip_invalid']) and
			$editprofilefrm->chkIsDuplicateEmail($LANG['editprofile_err_tip_email_exist']);
		$editprofilefrm->chkIsNotEmpty('phone', $LANG['common_err_tip_compulsory']);
		$editprofilefrm->chkIsNotEmpty('fax', $LANG['common_err_tip_compulsory']);
		$editprofilefrm->chkIsNotEmpty('address', $LANG['common_err_tip_compulsory']);
		$editprofilefrm->chkIsNotEmpty('city', $LANG['common_err_tip_compulsory']);
		$editprofilefrm->chkIsNotEmpty('state', $LANG['common_err_tip_compulsory']);
		$editprofilefrm->chkIsNotEmpty('country', $LANG['common_err_tip_compulsory']);
		$editprofilefrm->edit_profile_commit = true;
	}

if ($editprofilefrm->edit_profile_commit)
	{
		if ($editprofilefrm->isValidFormInputs())
			{
				if ($editprofilefrm->getFormField('user_id') != '')
					{
						$fields_to_update_arr = array('first_name', 'last_name', 'dob', 'gender', 'email',
						                          'phone', 'fax', 'address', 'city',
						                           'state', 'country');
						$editprofilefrm->updateFormFieldsInUsersTable($fields_to_update_arr);
						$success_message = 'update';
					}
				else
					{
						$fields_to_insert_arr = array('user_name', 'password', 'first_name',
						                          'last_name', 'dob', 'gender', 'email', 'phone',
												  'fax', 'address', 'city',
												  'state', 'country');
						$editprofilefrm->insertFormFieldsInUSerTable($fields_to_insert_arr);
						$success_message = 'add';
					}
				// Page block shown
				$editprofilefrm->setAllPageBlocksHide();
				//now redirect to members page...
				$editprofilefrm->redirectReferrerUrl();
			}
		else
			{
				$editprofilefrm->setAllPageBlocksHide();
				$editprofilefrm->setCommonErrorMsg($editprofilefrm->LANG['common_msg_error_sorry']);
				$editprofilefrm->setPageBlockShow('block_msg_form_error');
				$editprofilefrm->setPageBlockShow('block_form_editprofile');
			}
	}
$editprofilefrm->getReferrerUrl(array('userProfilesEdit'), 'userProfiles.php?action_back='.$editprofilefrm->getFormField('act'), 'action_back='.$editprofilefrm->getFormField('act'));

//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//
// Title of the page
$title = $editprofilefrm->LANG['editprofile_add_title'];
if ($editprofilefrm->getFormField('user_id') != '')
	{
		$title = $editprofilefrm->LANG['editprofile_edit_title'];
	}
$smartyObj->assign('status_arr', $status_arr);

if ($editprofilefrm->isShowPageBlock('block_form_editprofile'))
	{
		$editprofilefrm->form_editprofile_hidden_arr = array('user_id', 'user_name', 'password', 'backkey', 'act');
		$smartyObj->assign('current_date', date('Y-m-d'));
		$smartyObj->assign('submit_button_name', $submit_button_name);
		$smartyObj->assign('submit_button_value', $submit_button_value);
	}

$smartyObj->assign('page_title', $title);
$smartyObj->assign('gender_list_arr', array('m'=>$editprofilefrm->LANG['common_male_option'], 'f'=>$editprofilefrm->LANG['common_female_option']));
$editprofilefrm->left_navigation_div = 'generalMember';
//include the header file
$editprofilefrm->includeHeader();
//include the content of the page
setTemplateFolder('admin/');
$smartyObj->display('userProfilesEdit.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$editprofilefrm->includeFooter();
?>