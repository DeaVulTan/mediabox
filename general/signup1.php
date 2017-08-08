<?php
//-------------- Class SignUpFormHandler begins --------------->>>>>//
/**
 * This class handles the new user signup
 *
 * @category	Rayzz
 * @package		Index
 */
class SignUpFormHandler extends SignupAndLoginHandler
	{
		public $publickey;
		public $privatekey;
		public $error = null;
		public $resp = null;

		/**
		 * SignUpFormHandler::chkIsValidCaptcha()
		 * checks whethere valid captcha
		 *
		 * @param 		$field_name field name
		 * @param		$err_tip error tip message
		 * @return 		boolean true/false
		 * @access 		public
		 */
		public function chkIsValidCaptcha($field_name, $err_tip='')
			{
				$is_ok = (isset($_SESSION['signup_captcha']) and
							($_SESSION['signup_captcha']==$this->fields_arr[$field_name]));
				if (!$is_ok)
						$this->fields_err_tip_arr[$field_name] = $err_tip;
				return $is_ok;
			}

		/**
		* SignUpFormHandler::showSexOptionButtons()
		* Populates the Gender option List
		*
		* @param  array $sex_array Sex Array
		* @param  string $field_name name of the radio button
		* @access public
		*
		**/
		public function showSexOptionButtons($sex_array, $field_name)
			{
				$showSexOptionButtons_arr = array();
				$inc = 0;
				foreach($sex_array as $key=>$desc)
					{
						$checked = (strcmp($key, $this->fields_arr[$field_name])==0)?"checked=\"checked\"":"";
						$showSexOptionButtons_arr[$inc]['value'] = $key;
						$showSexOptionButtons_arr[$inc]['description'] = $desc;
						$showSexOptionButtons_arr[$inc]['checked'] = $checked;
						$inc++;
					}
				return $showSexOptionButtons_arr;
			}

		/**
		 * SignUpFormHandler::setInvitationDetails()
		 * To get the invitation details
		 *
		 * @return invitation id
		 * @access public
		 */
		public function setInvitationDetails()
			{
				$sql = 'SELECT invitation_id FROM '.$this->CFG['db']['tbl']['users_invitation'].
						' WHERE user_id='.$this->dbObj->Param('user_id').
						' AND invitation_code='.$this->dbObj->Param('invitation_code').' LIMIT 0, 1';

                $stmt = $this->dbObj->Prepare($sql);
                $rs = $this->dbObj->Execute($stmt, array($this->getFormField('id'), $this->getFormField('icode')));
                if (!$rs)
            	    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount()>0)
				    {
				        $row = $rs->FetchRow();
						$this->setFormField('invitation_id', $row['invitation_id']);
				    }

			}

		/**
		 * SignUpFormHandler::sendRequestToAddAsFriend()
		 * To insert subject and mail in mails table and return messgage id
		 *
		 * @param  int user_id to whom the mail should be sent
		 * @param  int user_id from whom the invitation request ahs to be sent
		 * @access public
		 * @return boolean
		 **/
		public function sendRequestToAddAsFriend($invitationUserId=0, $new_user_id=0)
			{
				if (!$invitationUserId or !$new_user_id)
				    {
				        return false;
				    }

				$sql = 'SELECT user_name FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_id='.$this->dbObj->Param('user_id');

                $stmt = $this->dbObj->Prepare($sql);
                $rs = $this->dbObj->Execute($stmt, array($invitationUserId));
                if (!$rs)
            	    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount()>0)
				    {
						$row = $rs->FetchRow();
						$friend_id = $invitationUserId;
						$friend_name = $row['user_name'];

						$subject = $this->buildDisplayText($this->LANG['request_friend_subject'], array('VAR_FRIEND_NAME'=>$friend_name));

						$acceptance_form = '';

						$friend_profile_link = '<a href="'.getUrl('viewprofile', '?user='.$friend_name, $friend_name, 'root').'" target="_blank">'.$friend_name.'</a>';

						$message = $this->buildDisplayText($this->LANG['request_friend_content'], array('VAR_USER_NAME'=>$this->getFormField('user_name'), 'VAR_FRIEND_NAME'=>$friend_name, '{friend_profile_link}'=>$friend_profile_link, '{user_message}'=>''));

						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['messages'].
								' SET subject = '.$this->dbObj->Param('subject').
								', message ='.$this->dbObj->Param('message').
								', mess_date = now()';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($subject, $message));
						    if (!$rs)
							    trigger_db_error($this->dbObj);

						$message_id = $this->dbObj->Insert_ID();

						$sql =  'INSERT INTO ' . $this->CFG['db']['tbl']['messages_info'] .
								' SET message_id = '.$this->dbObj->Param('message_id').
								', email_status=\'Request\''.
								', from_id ='.$this->dbObj->Param('from_id').
								', to_id ='.$this->dbObj->Param('to_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($message_id, $invitationUserId, $new_user_id));
						    if (!$rs)
							    trigger_db_error($this->dbObj);

						$message_info_id = $this->dbObj->Insert_ID();

						$acceptance_form = '<form name="friendRequestAcceptanceForm" id="friendRequestAcceptanceForm" action="'.getUrl('friendaccept').'" method="post"><p><input type="submit" class="clsSubmitButton" name="acceptSubmit" value="'.$this->LANG['signup_friend_request_accept'].'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" class="clsSubmitButton" name="declineSubmit" value="'.$this->LANG['signup_friend_request_decline'].'"><input type="hidden" name="friend" value="'.$invitationUserId.'" /><input type="hidden" name="messageInfoId" value="'.$message_info_id.'" /></form>';
						$acceptance_form = addslashes(htmlentities($acceptance_form));
						$message = $this->buildDisplayText($message, array('VAR_ACCEPTANCE_FORM'=>$acceptance_form));

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['messages'].
								' SET message='.$this->dbObj->Param('message').
							   	' WHERE message_id='.$this->dbObj->Param('message_id');

		                $stmt = $this->dbObj->Prepare($sql);
		                $rs = $this->dbObj->Execute($stmt, array($message, $message_id));
		                    if (!$rs)
		                	    trigger_db_error($this->dbObj);

						$this->updateNewRequestCount($new_user_id);
						return true;
				    }
				return false;
			}

		/**
		 * SignUpFormHandler::updateNewRequestCount()
		 * update the friend request count
		 *
		 * @param  integer $user_id
		 * @return void
		 * @access public
		 */
		public function updateNewRequestCount($user_id=0)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
						' SET new_requests = new_requests + 1'.
						', new_mails = new_mails + 1'.
						' WHERE user_id = '.$this->dbObj->Param('user_id');

	            $stmt = $this->dbObj->Prepare($sql);
	            $rs = $this->dbObj->Execute($stmt, array($user_id));
                if (!$rs)
            	    trigger_db_error($this->dbObj);
			}

		/**
		 * SignUpFormHandler::sendInvitationForFriends()
		 * To send the invitation for friends
		 *
		 * @param  integer $user_id
		 * @param  integer $invitationId
		 * @return void
		 * @access public
		 */
		public function sendInvitationForFriends($user_id=0, $invitationId=0)
			{
				$sql = 'SELECT for_friend, for_groups, email, user_id'.
						' FROM '.$this->CFG['db']['tbl']['users_invitation'].
						' WHERE invitation_id='.$this->dbObj->Param('invitation_id');

	            $stmt = $this->dbObj->Prepare($sql);
	            $rs = $this->dbObj->Execute($stmt, array($invitationId));
                if (!$rs)
            	    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount() > 0)
				    {
				        $row = $rs->FetchRow();
						$invitationUserId = $row['user_id'];

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
								' SET referrer_id='.$this->dbObj->Param('referrer_id').
								' WHERE user_id='.$this->dbObj->Param('user_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($row['user_id'], $user_id));
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						if ($this->CFG['admin']['members']['add_friend_automatically'] AND $row['for_friend']=='1')
							{
								$this->sendRequestToAddAsFriend($invitationUserId, $user_id);
							}
				    }
			}

		/**
		 * SignUpFormHandler::displayMandatoryIcon()
		 * Display the mandatory icon if the form field is listed in mandatory fields array
		 *
		 * @param  string $field_name
		 * @return string
		 * @access public
		 */
		public function displayMandatoryIcon($field_name='')
			{
				$mandatoryFields = array('user_name', 'password', 'confirm_password', 'email', 'first_name', 'last_name', 'sex', 'country', 'dob', 'pin_code', 'postal_code', 'captcha');
				if($field_name == '*' OR (in_array($field_name, $mandatoryFields)))
					{
						$this->displayCompulsoryIcon();
					}
			}

		/**
		 * SignUpFormHandler::sendActivationCode()
		 * To send the activation code.
		 *
		 * @access public
		 * @return void
		 */
		public function sendActivationCode()
			{
				$code = urlencode($this->getActivationCode('Signup', $this->fields_arr['user_id']));
				$activation_link = getUrl('verify', '?code='.$code, '?code='.$code, 'root');
				$this->setEmailTemplateValue('USER_NAME', $this->fields_arr['user_name']);
				$this->setEmailTemplateValue('LINK', $this->CFG['site']['url']);
				$this->setEmailTemplateValue('ACTIVATION_LINK', $activation_link);

				if(isAdmin())
					{
						$activation_subject = $this->LANG['activation_admin_subject'];
						$activation_message = $this->LANG['activation_admin_message'];
						$this->setEmailTemplateValue('PASSWORD', $this->fields_arr['password']);
					}
				else
					{
						if($this->CFG['admin']['signup_auto_activate'])
							Redirect2URL($activation_link);

						$activation_subject = $this->LANG['activation_subject'];
						$activation_message = $this->LANG['activation_message'];
					}

				$is_ok = $this->_sendMail($this->fields_arr['email'], $activation_subject, $activation_message, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);
				if($is_ok)
					{
						if(!isAdmin())
							{
								$this->setPageBlockShow('activation_mail_details_block');
							}
						else
							{
								$this->setPageBlockShow('memberadd_form_success');
							}
						return true;
					}
				else
					{
						$this->setCommonSuccessMsg($this->LANG['signup_success'].'<br />'.$this->LANG['signup_activation_code_not_sent']);
						$this->setPageBlockShow('block_msg_form_success');
						return false;
					}
			}

		/**
		 * SignUpFormHandler::checkUserStatusForEmail()
		 * return the usr_status of the user with the email
		 *
		 * @param string $email
		 * @return usr_status or ''
		 */
		public function checkUserStatusForEmail($email, $user_id)
			{
				$sql = 'SELECT usr_status, user_id FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE email = '. $this->dbObj->Param('email');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($email));
				if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						if($row['usr_status'] == 'ToActivate' AND $row['user_id'] == $user_id)
							return $row['usr_status'];
						else
							return $this->LANG['err_tip_email_already_used'];
					}
				else // no user record with the same email, update the email of the current user with this
					{
						$this->updateNewEmailForUser($email, $user_id);
						return '';
					}
			}

		/**
		 * SignUpFormHandler::updateNewEmailForUser()
		 * update the email field for the user_id
		 *
		 * @param string $email
		 * @param int $user_id
		 * @return
		 */
		public function updateNewEmailForUser($email, $user_id)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
						' SET email = '. $this->dbObj->Param('email').
						' WHERE usr_status = \'ToActivate\''.
						' AND user_id = '.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($email, $user_id));
				if (!$rs)
				    trigger_db_error($this->dbObj);

			}

		/**
		 * SignUpFormHandler::resendActivationCode()
		 * resend the activation code, if the new email provided usr status is ToActivate
		 * or no record with that email
		 * else send to the old email provided in the previous step accordingly assign the
		 * error messages and display
		 *
		 * @return void
		 */
		public function resendActivationCode()
			{
				global $smartyObj;

				$add = ' user_name='.$this->dbObj->Param('user_name');
				if($this->CFG['admin']['email_using_to_login'])
					$add = ' email='.$this->dbObj->Param('email');

				$sql = 'SELECT user_id,  email, user_name FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE'.$add.' AND usr_status=\'ToActivate\'';


				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_name']));
				if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->fields_arr['username'] = $row['user_name'];
						$this->fields_arr['user_id'] = $row['user_id'];
						$this->fields_arr['email'] = $row['email'];
						$new_email_user_status = 'ToActivate';
						$new_email_valid = true;
						//if the new email is different from the old email, check the user status for the mail
						// and handle accordingly
						if($this->fields_arr['new_email'] != $row['email'])
							{
								$new_email_user_status = $this->checkUserStatusForEmail($this->fields_arr['new_email'], $this->fields_arr['user_id']);
								if($new_email_user_status == 'ToActivate' or $new_email_user_status == '')
									{
										$this->fields_arr['email'] = $this->fields_arr['new_email'];
									}
							}
						$message = '';
						//send activation code again
						if(!($new_email_user_status == 'ToActivate' or $new_email_user_status == ''))
							{
								$message = $this->LANG['signup_resend_code_message_mail_taken'];
							}
						$mail_sent = $this->sendActivationCode();
						if($mail_sent)
							$message .= '<p>'.$this->LANG['signup_resend_code_message_mail_sent'].'</p>'.$this->fields_arr['email'];
						$smartyObj->assign('resend_activation_message', $message);
						$smartyObj->assign('resend_activation_message_step', 'step2');
					}
				else
					{
						$message = '<p>'.$this->LANG['signup_resend_code_message_no_match'].'</p>' ;
						$smartyObj->assign('resend_activation_message', $message);
						$smartyObj->assign('resend_activation_message_step', 'step2');
					}
			}

		/**
		 * SignUpFormHandler::resetFieldsArray()
		 *
		 * @return
		 */
		public function resetFieldsArray()
			{
				$this->setFormField('user_id', '');
				$this->setFormField('user_name', '');
				$this->setFormField('password', '');
				$this->setFormField('confirm_password', '');
				$this->setFormField('email', '');
				$this->setFormField('new_email', '');
				$this->setFormField('usr_access', '');
				$this->setFormField('usr_type', 0);
				$this->setFormField('first_name', '');
				$this->setFormField('last_name', '');
				$this->setFormField('sex', 'male');
				$this->setFormField('country', '');
				$this->setFormField('agreement', '1');
				$this->setFormField('dob', '');
				$this->setFormField('signup_ip', $this->CFG['remote_client']['ip']);
				$this->setFormField('icode', '');
				$this->setFormField('id', '');
				$this->setFormField('invitation_id', 0);
				$this->setFormField('postal_code', '');
				$this->setFormField('captcha', '');
				$this->setFormField('recaptcha_challenge_field', '');
				$this->setFormField('recaptcha_response_field', '');
				$this->setFormField('bba_token', $this->generateBBAToken());
			}

		/**
		 * SignUpFormHandler::populateUserDetails()
		 *
		 * @return
		 */
		public function populateUserDetails()
			{
				if($user_details = getUserDetail('user_id', $this->getFormField('user_id')))
					{
						$this->setFormField('user_name', $user_details['user_name']);
						$this->setFormField('password', '');
						$this->setFormField('confirm_password', '');
						$this->setFormField('email', $user_details['email']);
						$this->setFormField('usr_access', $user_details['usr_access']);
						$this->setFormField('usr_type', $user_details['usr_type']);
						$this->setFormField('first_name', $user_details['first_name']);
						$this->setFormField('last_name', $user_details['last_name']);
						$this->setFormField('sex', $user_details['sex']);
						$this->setFormField('country', $user_details['country']);
						$this->setFormField('dob', $user_details['dob']);
						$this->setFormField('postal_code', $user_details['postal_code']);
						return true;
					}
				return false;
			}

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
		 * SignUpFormHandler::validateSignupForm()
		 * To validate the signup form
		 *
		 * @param string $edit_mode edit mode is true or not
		 * @return
		 */
		public function validateSignupForm($edit_mode = false)
			{
				$this->chkIsNotEmpty('email', $this->LANG['common_err_tip_required']) and
					$this->chkIsValidEmail('email', $this->LANG['common_err_tip_email']) and
					$this->chkIsNotDuplicateEmail('email',  $this->LANG['signup_err_tip_email_already_exists']);

				if(!$this->isFormPOSTed($_POST, 'signup_update'))
					{
						$this->chkIsNotEmpty('user_name', $this->LANG['common_err_tip_required']) and
							$this->chkIsAlphaNumeric('user_name', $this->LANG['signup_err_tip_invalid_username']) and
							$this->chkIsValidSize('user_name', 'username', $this->LANG['common_err_tip_invalid_size']) and
							$this->chkIsAllowedUserName($this->LANG['not_allowed_username']) and
							($this->chkIsNotDuplicateUserName('user_name', $this->LANG['signup_err_tip_name_already_exists']) or
							$this->setCommonErrorMsg($this->LANG['signup_err_tip_name_already_exists']));
					}

				if($edit_mode)
					{
						$this->getFormField('password') and
							$this->chkIsValidSize('password', 'password', $this->LANG['common_err_tip_invalid_size']);

						($this->getFormField('password') or $this->getFormField('confirm_password')) and
							$this->chkIsSamePasswords('password', 'confirm_password', $this->LANG['signup_err_tip_same_password']);
					}
				else
					{
						$this->chkIsNotEmpty('password', $this->LANG['common_err_tip_required']) and
							$this->chkIsValidSize('password', 'password', $this->LANG['common_err_tip_invalid_size']);

						$this->chkIsNotEmpty('confirm_password', $this->LANG['common_err_tip_required']) and
							$this->chkIsSamePasswords('password', 'confirm_password', $this->LANG['signup_err_tip_same_password']);
					}

				$this->chkIsPasswordAndUserNameAreSame($this->LANG['password_user_name']);

				$this->chkIsNotEmpty('first_name', $this->LANG['common_err_tip_required']) and
					$this->chkIsValidSize('first_name', 'first_name', $this->LANG['common_err_tip_invalid_size']);
					$this->chkIsNotEmpty('last_name', $this->LANG['common_err_tip_required']) and
					$this->chkIsValidSize('last_name', 'first_name', $this->LANG['common_err_tip_invalid_size']);

				$this->chkIsNotEmpty('dob', $this->LANG['common_err_tip_required']) ;
				if($this->chkIsValidDate('dob',$this->LANG['common_err_tip_date_invalid']))
					{
						// check age limit......
						$this->chkIsCorrectDateSignup($this->getFormField('dob'), 'dob', $this->LANG['common_err_tip_date_invalid'], $this->LANG['common_err_tip_date_invalid']);
					}

				$this->chkIsNotEmpty('country', $this->LANG['common_err_tip_required']);

				$this->chkIsNotEmpty('postal_code', $this->LANG['common_err_tip_required']);

				if(isAdmin())
					{
						$this->chkIsNotEmpty('usr_type', $this->LANG['common_err_tip_required']);
					}
				if(!isAdmin())
					{
						$this->chkIsNotEmpty('agreement', $this->LANG['common_err_tip_required']);

						if($this->isValidFormInputs() and $this->CFG['signup']['captcha'])
							{
								if($this->CFG['signup']['captcha_method'] == 'recaptcha' and $this->CFG['captcha']['public_key'] and $this->CFG['captcha']['private_key'])
									{
										$this->chkIsNotEmpty('recaptcha_response_field', $this->LANG['common_err_tip_compulsory']) and
										$this->chkCaptcha('recaptcha_response_field', $this->LANG['common_err_tip_invalid_captcha']);
									}
								elseif($this->CFG['signup']['captcha_method']=='image')
									{
										$this->chkIsNotEmpty('captcha', $this->LANG['common_err_tip_compulsory']) and
										$this->chkIsValidCaptcha('captcha', $this->LANG['common_err_tip_invalid_captcha']);
									}
								elseif($this->CFG['signup']['captcha_method']=='honeypot')
									{
										$this->chkIsValidHoneyPot('captcha');
									}
							}
					}
			}
	}
//<<<<<-------------- Class SignUpFormHandler begins ---------------//
//-------------------- Code begins -------------->>>>>//
$sgnfrm = new SignUpFormHandler();

$LANG['signup_user_name'] = $sgnfrm->buildDisplayText($LANG['signup_user_name'], array('VAR_MIN_COUNT'=>$CFG['fieldsize']['username']['min'], 'VAR_MAX_COUNT'=>$CFG['fieldsize']['username']['max']));
$LANG['signup_password'] = $sgnfrm->buildDisplayText($LANG['signup_password'], array('VAR_MIN_COUNT'=>$CFG['fieldsize']['password']['min'], 'VAR_MAX_COUNT'=>$CFG['fieldsize']['password']['max']));
$LANG['signup_dob'] = $sgnfrm->buildDisplayText($LANG['signup_dob'], array('VAR_DOB_FORMAT'=>'yyyy-mm-dd'));
$LANG['help']['first_name'] = $sgnfrm->buildDisplayText($LANG['help']['first_name'], array('VAR_MIN_COUNT'=>$CFG['fieldsize']['first_name']['min'], 'VAR_MAX_COUNT'=>$CFG['fieldsize']['first_name']['max']));
$LANG['help']['last_name'] = $sgnfrm->buildDisplayText($LANG['help']['last_name'], array('VAR_MIN_COUNT'=>$CFG['fieldsize']['last_name']['min'], 'VAR_MAX_COUNT'=>$CFG['fieldsize']['last_name']['max']));
$LANG['signup_submit'] = $sgnfrm->buildDisplayText($LANG['signup_submit']);
$LANG['signup_user_name_errormsg'] = $sgnfrm->buildDisplayText($LANG['common_err_tip_invalid_character_size'], array('VAR_MIN'=>$CFG['fieldsize']['username']['min'], 'VAR_MAX'=>$CFG['fieldsize']['username']['max']));
$LANG['signup_password_errormsg'] = $sgnfrm->buildDisplayText($LANG['common_err_tip_invalid_password'], array('VAR_MIN'=>$CFG['fieldsize']['password']['min'], 'VAR_MAX'=>$CFG['fieldsize']['password']['max']));
$LANG['signup_first_name_errormsg'] = $sgnfrm->buildDisplayText($LANG['common_err_tip_invalid_character_size'], array('VAR_MIN'=>$CFG['fieldsize']['first_name']['min'], 'VAR_MAX'=>$CFG['fieldsize']['first_name']['max']));
$LANG['signup_last_name_errormsg'] = $sgnfrm->buildDisplayText($LANG['common_err_tip_invalid_character_size'], array('VAR_MIN'=>$CFG['fieldsize']['last_name']['min'], 'VAR_MAX'=>$CFG['fieldsize']['last_name']['max']));

if(isAdmin())
	{
		$LANG_LIST_ARR['usr_access']['User'] = $LANG['signup_personal_usr_access_user'];
		$LANG_LIST_ARR['usr_access']['Admin'] = $LANG['signup_personal_usr_access_admin'];
		$sgnfrm->user_types = $sgnfrm->getUserTypes();
	}

//its necessary only for this file
$sgnfrm->makeGlobalize($CFG, $LANG);

if(!chkAllowedModule(array('signup')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$sgnfrm->setPageBlockNames(array('form_signup', 'form_edit_member', 'activation_mail_details_block', 'memberadd_form_success'));
$sgnfrm->resetFieldsArray();
//added the field since we didn't get the value in the resend activation  code block
$sgnfrm->setFormField('new_username', '');
$sgnfrm->sanitizeFormInputs($_REQUEST);
$smartyObj->assign('resend_activation_message_step', 'step1');
if($CFG['signup']['captcha'] and $CFG['signup']['captcha_method']=='honeypot' and phFormulaRayzz())
	$sgnfrm->setFormField(phFormulaRayzz(), '');

$sgnfrm->setCountriesListArr($LANG_LIST_ARR['countries'],array('' => $LANG['signup_choose']));
$sgnfrm->setMonthsListArr($LANG_LIST_ARR['months']);
$sgnfrm->current_year = date("Y");
$sgnfrm->setAllPageBlocksHide();
$sgnfrm->setPageBlockShow('form_signup');
//set the invitation_id form field if icode is present
if ($sgnfrm->isPageGETed($_GET, 'icode') and $sgnfrm->isPageGETed($_GET, 'id'))
    {
     	$sgnfrm->sanitizeFormInputs($_GET);
		$icode = $sgnfrm->getFormField('icode');
		if ($icode)
		    {
				$sgnfrm->setInvitationDetails();
		    }
    }
if (isAdmin() and $sgnfrm->isPageGETed($_GET, 'user_id') and $sgnfrm->populateUserDetails())
    {
    	$sgnfrm->setPageBlockShow('form_edit_member');
    }
//handling of sending the activation mail again from the sign up success block ..
if($sgnfrm->isFormPOSTed($_POST, 'code'))
	{
		$sgnfrm->chkIsNotEmpty('new_email', $sgnfrm->LANG['common_err_tip_required']) and
			$sgnfrm->chkIsValidEmail('new_email', $sgnfrm->LANG['common_err_tip_email']) and
			$sgnfrm->chkIsNotDuplicateEmail('new_email',  $sgnfrm->LANG['signup_err_tip_email_already_exists']);
		if ($sgnfrm->isValidFormInputs())
			{
				$sgnfrm->resendActivationCode();
				$sgnfrm->setAllPageBlocksHide();
				$sgnfrm->setPageBlockShow('activation_mail_details_block');
			}
		else
			{
				$sgnfrm->setAllPageBlocksHide();
				$sgnfrm->setPageBlockShow('activation_mail_details_block');
				$sgnfrm->setCommonErrorMsg($LANG['common_msg_error_sorry']);
			}
	}
if (isAdmin() and $sgnfrm->isFormPOSTed($_POST, 'signup_update'))
	{
		$sgnfrm->setFormField('user_name', getUserDetail('user_id', $sgnfrm->getFormField('user_id'), 'user_name'));
		if($CFG['admin']['is_demo_site'])
			{
				$sgnfrm->setAllPageBlocksHide();
				$sgnfrm->setCommonErrorMsg($LANG['general_config_not_allow_demo_site']);
				$sgnfrm->setPageBlockShow('block_msg_form_error');
				$sgnfrm->setPageBlockShow('form_signup');
				$sgnfrm->setPageBlockShow('form_edit_member');
			}
		else
			{
				$sgnfrm->validateSignupForm(true);
				if ($sgnfrm->isValidFormInputs())
					{
						$add_arr = array();
						if($sgnfrm->getFormField('password'))
							{
								$add_arr = array('password', 'bba_token');
							}
						$password_temp = $sgnfrm->getFormField('password');
						$sgnfrm->setFormField('password', md5($password_temp.$sgnfrm->getFormField('bba_token')));
						$update_fields = array_merge(array('email', 'first_name', 'last_name',
											 'sex', 'dob', 'country', 'postal_code', 'usr_type'), $add_arr);

						$sgnfrm->updateFormFieldsInUsersTable($update_fields);
						$sgnfrm->setFormField('password', $password_temp);

						$sgnfrm->setAllPageBlocksHide();
						$sgnfrm->setPageBlockShow('form_signup');
						$sgnfrm->setPageBlockShow('form_edit_member');
						$sgnfrm->setCommonSuccessMsg($LANG['signup_update_successfully']);
						$sgnfrm->setPageBlockShow('block_msg_form_success');
					}
				else
					{
						$sgnfrm->setAllPageBlocksHide();
						$sgnfrm->setPageBlockShow('block_msg_form_error');
						$sgnfrm->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$sgnfrm->setPageBlockShow('form_signup');
						$sgnfrm->setPageBlockShow('form_edit_member');
					}
			}
	}
if ($sgnfrm->isFormPOSTed($_POST, 'signup_submit'))
	{
		$sgnfrm->validateSignupForm();

		if(isAdmin() and $CFG['admin']['is_demo_site'])
			{
				$sgnfrm->setAllPageBlocksHide();
				$sgnfrm->setCommonErrorMsg($LANG['general_config_not_allow_demo_site']);
				$sgnfrm->setPageBlockShow('block_msg_form_error');
				$sgnfrm->setPageBlockShow('form_signup');
			}
		else
			{
				if ($sgnfrm->isValidFormInputs())
					{
						$sgnfrm->setFormField('referrer_id', getReferer());
						$password_temp = $sgnfrm->getFormField('password');
						$sgnfrm->setFormField('password', md5($password_temp.$sgnfrm->getFormField('bba_token')));
						$insert_fields = array('user_name', 'email', 'password', 'bba_token', 'first_name', 'last_name',
											 'sex', 'dob', 'country', 'postal_code', 'signup_ip', 'usr_type', 'referrer_id');
						if(isAdmin())
							{
								//$insert_fields = array_merge($insert_fields, array('usr_access'));
							}

						$user_id = $sgnfrm->insertFormFieldsInUserTable($insert_fields);
						//Update default user type if user type not selected
						if (!$sgnfrm->getFormField('usr_type'))
							{
								$sgnfrm->updateDefaultUserTypeForUser($user_id);
							}

						$sgnfrm->setFormField('password', $password_temp);
						$sgnfrm->setFormField('user_id', $user_id);
						$sgnfrm->setFormField('new_email', $sgnfrm->getFormField('email'));
						$sgnfrm->setFormField('new_username', $sgnfrm->getFormField('user_name'));

						$sgnfrm->updateUsersAgeValue($user_id);
						foreach($CFG['site']['modules_arr'] as $value)
						{
							if(chkAllowedModule(array(strtolower($value))))
							{
								$funtion_name = 'insertUploadDefaultDetailsFor'.ucfirst($value);
								if(function_exists($funtion_name))
									$funtion_name($user_id,$sgnfrm->getFormField('user_name'));
						    }
						}
						$sgnfrm->setAllPageBlocksHide();
						$mail_sent = $sgnfrm->sendActivationCode();
						$invitationId = $sgnfrm->getFormField('invitation_id');
						if ($invitationId >0  AND ($CFG['admin']['members']['add_friend_automatically']) )
						    {
								$sgnfrm->sendInvitationForFriends($user_id,  $invitationId);
						    }
						$CFG['feature']['auto_hide_success_block'] = false;
					}
				else
					{
						$sgnfrm->setFormField('password', '');
						$sgnfrm->setFormField('confirm_password', '');
						$sgnfrm->setAllPageBlocksHide();
						$sgnfrm->setFormField('captcha', '');
						$sgnfrm->setPageBlockShow('block_msg_form_error');
						$sgnfrm->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$sgnfrm->setPageBlockShow('form_signup');
					}
			}
	}
//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($sgnfrm->isShowPageBlock('activation_mail_details_block'))
	{
		$sgnfrm->form_error['hidden_arr'] = array('user_name','user_id');
		$click_here  = getUrl('login');
		$click_here = '<a href="'.$click_here.'" onclick="document.errorForm.submit();return false;">'.'Send Me another'.'</a>';
		$smartyObj->assign('resend_activation_link', $click_here);
	}

if ($sgnfrm->isShowPageBlock('form_signup'))
	{
		$terms_link = '<a href="'.getUrl('static','?pg=useterms', 'useterms/', 'root').'">'.$LANG['terms_of_use_link'].'</a>';
		$privacy_link = '<a href="'.getUrl('static','?pg=privacy', 'privacy/', 'root').'">'.$LANG['privacy_policy_link'].'</a>';

		$sgnfrm->form_signup['signup_agreement'] = $sgnfrm->buildDisplayText($LANG['signup_agreement'], array('VAR_TERMS_OF_USE_LINK'=>$terms_link, 'VAR_PRIVACY_POLICY_LINK'=>$privacy_link));


		$sgnfrm->form_signup['signup_user_name'] = $LANG['signup_user_name'];
		$sgnfrm->form_signup['signup_password']  = $LANG['signup_password'];
		$first_option_arr = array(''=>$LANG['signup_choose']);
		$smartyObj->assign('smarty_country_list', $first_option_arr + $LANG_LIST_ARR['countries']);
		$sgnfrm->form_signup['showSexOptionButtons'] = $sgnfrm->showSexOptionButtons($LANG_LIST_ARR['gender'], 'sex');

		$sgnfrm->form_signup['LANG_LIST_ARR'] = $LANG_LIST_ARR;
	}
$calendar_options_arr = array('minDate' => '-70Y',
							  'maxDate'	=> '-1D',
							  'yearRange'=> '-100:+20'
							 );
$smartyObj->assign('dob_calendar_opts_arr', $calendar_options_arr);

if(isAdmin())
	{
		$sgnfrm->left_navigation_div = 'generalMember';
		if($sgnfrm->isShowPageBlock('form_edit_member'))
			{
				$sgnfrm->LANG['signup_title'] = $LANG['signup_edit_profile_title'];
			}
		else
			{
				$sgnfrm->LANG['signup_title'] = $LANG['signup_member_add_title'];
				$sgnfrm->LANG['signup_submit'] = $LANG['common_submit'];
				$sgnfrm->LANG['signup_success'] = $LANG['signup_memberadd_success'];
				$sgnfrm->LANG['signup_link_view_new_member'] = $sgnfrm->buildDisplayText($LANG['signup_link_view_new_member'], array('VAR_CLICK_HERE'=>'<a href="viewProfile.php?user_id='.$sgnfrm->getFormField('user_id').'">'.$LANG['common_msg_click_here'].'</a>'));;
			}
	}
$sgnfrm->includeHeader();
?>
<script type="text/javascript">
	var img_count=1;

	function changeCaptchaImage(){
		document.getElementById('captchaImage').src = '<?php echo $CFG['site']['url']; ?>captchaSignup.php?img_count='+img_count;
		img_count++;
		return false;
	}
</script>
<?php
setTemplateFolder('root/');
$smartyObj->display('signup.tpl');
if ($sgnfrm->isShowPageBlock('form_signup') and $CFG['feature']['jquery_validation']) {
?>
<script type="text/javascript">
	$Jq("#form_signup").validate({
		rules: {
			user_name: {
				required: true,
				minlength: <?php echo $CFG['fieldsize']['username']['min']; ?>,
				maxlength: <?php echo $CFG['fieldsize']['username']['max']; ?>
		    },
		    password: {
<?php
	if(!$sgnfrm->isShowPageBlock('form_edit_member'))
		{
?>
		    	required: true,
<?php
		}
?>
		    	minlength: <?php echo $CFG['fieldsize']['password']['min']; ?>,
				maxlength: <?php echo $CFG['fieldsize']['password']['max']; ?>
		    },
		    confirm_password: {
		    	equalTo: "#password"
		    },
		    email: {
		    	required: true,
				isValidEmail: true
		    },
		    first_name: {
		    	required: true,
		    	minlength: <?php echo $CFG['fieldsize']['first_name']['min']; ?>,
		    	maxlength: <?php echo $CFG['fieldsize']['first_name']['max']; ?>
		    },
		    last_name: {
		    	required: true,
		    	minlength: <?php echo $CFG['fieldsize']['last_name']['min']; ?>,
		    	maxlength: <?php echo $CFG['fieldsize']['last_name']['max']; ?>
		    },
		    dob: {
		    	required: true,
		    	isValidDate: true,
		    	dateISO: true,
		    	isValidDateVal: true,
		    	isValidMinAge: <?php echo $sgnfrm->CFG['admin']['members_signup']['age_limit_start']; ?>,
		    	isValidMaxAge: <?php echo $sgnfrm->CFG['admin']['members_signup']['age_limit_end']; ?>
		    },
		    country: {
		    	selectCountry: true
		    },
		    postal_code: {
		    	required: true
		    },
		    captcha: {
		    	required: true
		    }
<?php
	if(isAdmin())
		{
?>
			,
		    usr_type: {
		    	selectUserType: true
		    }
<?php
		}
	if(!isAdmin())
		{
?>
			,
		    agreement: {
		    	required: true
		    }
<?php
		}
?>
		},
		messages: {
			user_name: {
				required: "<?php echo $sgnfrm->LANG['signup_user_name_errormsg'];?>",
				minlength: jQuery.format("{0} <?php echo $sgnfrm->LANG['signup_err_tip_min_characters'];?>"),
				maxlength: jQuery.format("<?php echo $sgnfrm->LANG['signup_err_tip_max_characters'];?> {0}")
			},
			password: {
				required: "<?php echo $sgnfrm->LANG['signup_password_errormsg'];?>"
			},
			confirm_password: {
				equalTo: "<?php echo $sgnfrm->LANG['common_err_tip_invalid_passwordmatch'];?>"
			},
			email: {
				required: "<?php echo $sgnfrm->LANG['common_err_tip_required'];?>",
				isValidEmail: "<?php echo $sgnfrm->LANG['common_err_tip_email'];?>"
			},
			first_name: {
				required: "<?php echo $sgnfrm->LANG['signup_first_name_errormsg'];?>",
				minlength: jQuery.format("{0} <?php echo $sgnfrm->LANG['signup_err_tip_min_characters'];?>"),
				maxlength: jQuery.format("<?php echo $sgnfrm->LANG['signup_err_tip_max_characters'];?> {0}")
			},
			last_name: {
				required: "<?php echo $sgnfrm->LANG['signup_last_name_errormsg'];?>",
				minlength: jQuery.format("{0} <?php echo $sgnfrm->LANG['signup_err_tip_min_characters'];?>"),
				maxlength: jQuery.format("<?php echo $sgnfrm->LANG['signup_err_tip_max_characters'];?> {0}")
			},
		    dob: {
		    	required: "<?php echo $sgnfrm->LANG['common_err_tip_required'];?>",
		    	isValidDate: "<?php echo $sgnfrm->LANG['common_err_tip_date_formate'];?>",
		    	dateISO: "<?php echo $sgnfrm->LANG['common_err_tip_date_invalid'];?>",
		    	isValidDateVal: "<?php echo $sgnfrm->LANG['common_err_tip_date_invalid'];?>",
		    	isValidMinAge: "<?php echo str_replace('VAR_MIN_AGE', $sgnfrm->CFG['admin']['members_signup']['age_limit_start'], $sgnfrm->LANG['common_err_tip_age_min']);?>",
		    	isValidMaxAge: "<?php echo str_replace('VAR_MAX_AGE', $sgnfrm->CFG['admin']['members_signup']['age_limit_end'], $sgnfrm->LANG['commom_err_tip_age_max']);?>"
		    },
			postal_code: {
				required: "<?php echo $sgnfrm->LANG['common_err_tip_required'];?>"
			},
		    captcha: {
		    	required: "<?php echo $sgnfrm->LANG['common_err_tip_required'];?>"
		    }
<?php
	if(!isAdmin())
		{
?>
			,
			agreement: {
				required: "<?php echo $sgnfrm->LANG['signup_err_tip_agreement'];?>"
			}
<?php
		}
?>
		}
	});
</script>
<?php
}
if ($sgnfrm->isShowPageBlock('activation_mail_details_block') and $CFG['feature']['jquery_validation']) {
?>
<script type="text/javascript">
	$Jq("#errorForm").validate({
		rules: {
			new_email: {
				required: true,
				isValidEmail: true
		    }
		},
		messages: {
			new_email: {
				required: "<?php echo $sgnfrm->LANG['common_err_tip_required'];?>",
				isValidEmail: "<?php echo $sgnfrm->LANG['common_err_tip_email'];?>"
			}
		}
	});
</script>
<?php
}
if(isAdmin())
	{
		setTemplateFolder('admin/');
	}
$sgnfrm->includeFooter();
?>
