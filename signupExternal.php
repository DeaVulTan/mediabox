<?php
/**
 * File handling the signup for the external login user
 *
 * There user has to enter their valid details for successful signup. After successful
 * signup the user will receive the mail with a link to activate the account. By clicking
 * the link the user can activate his account.
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Index
 */
require_once('./common/configs/config.inc.php');
if ($CFG['admin']['module']['facebook'])
	{
		if (version_compare(PHP_VERSION,'5','>=')) {
			require_once ('tools/facebook/client/facebook.php');
		} else {
		 	require_once ('tools/facebook/php4client/facebook.php');
		  	require_once ('tools/facebook/php4client/facebookapi_php4_restlib.php');
		}
	}
require_once('./common/configs/config_members.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/root/signupExternal.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FriendHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_SignupAndLoginHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/recaptchalib.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/countries_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/gender_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/months_list_array.inc.php';

$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'root';
//To load Calendar related JS files
$CFG['admin']['calendar_page'] = true;
require($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------- Class SignUpFormHandler begins --------------->>>>>//
/**
 * SignUpFormHandler
 * This class handles the new user signup
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class SignUpFormHandler extends SignupAndLoginHandler
	{
		public $publickey;
		public $privatekey;
		public $error = null;
		public $resp = null;

		/**
		 * PhotoUpload::setIHObject()
		 *
		 * @param  $imObj
		 * @return
		 */
		public function setIHObject($imObj)
			{
				$this->imageObj = $imObj;
			}

		/**
		 * SignUpFormHandler::chkIsNotDuplicateUserName()
		 * To check for the duplicate user name
		 *
		 * @param 		string $table_name table name
		 * @param 		string $field_name field name
		 * @param 		string $err_tip error tip
		 * @return 		boolean true/false
		 * @access 		public
		 */
		public function chkIsNotDuplicateUserName($table_name, $field_name, $err_tip='')
			{
				$sql = 'SELECT user_id FROM ' . $table_name .
				 	   	' WHERE user_name = '.$this->dbObj->Param('user_name').
						' AND usr_status!=\'Deleted\' LIMIT 0,1';

               	$stmt = $this->dbObj->Prepare($sql);
               	$rs = $this->dbObj->Execute($stmt, array($this->fields_arr[$field_name]));
               	if (!$rs)
               	    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount()<=0)
				    {
				        return true;
				    }
				$this->fields_err_tip_arr[$field_name] = $err_tip;
				return false;
			}

		/**
		 * SignUpFormHandler::chkIsNotDuplicateEmail()
		 * To check for the duplicate email id
		 *
		 * @param 		string $table_name table name
		 * @param 		string $field_name email field name
		 * @param 		string $err_tip error tip
		 * @return 		boolean true/false
		 * @access 		public
		 */
		public function chkIsNotDuplicateEmail($table_name, $field_name, $err_tip='')
			{
				$sql = 'SELECT 1 FROM ' . $table_name .
				 	   	' WHERE email = '.$this->dbObj->Param('email').
						' AND usr_status!=\'Deleted\' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
                $rs = $this->dbObj->Execute($stmt, array($this->fields_arr[$field_name]));
                if (!$rs)
                	    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount()<=0)
				    {
				        return true;
				    }
				$this->fields_err_tip_arr[$field_name] = $err_tip;
				return false;
			}

		/**
		 * SignUpFormHandler::chkIsSamePasswords()
		 * To check the confirmation of password and password are same
		 *
		 * @param 		string $field_name1 password Field name
		 * @param 		string $field_name2 confirmation password field name
		 * @param 		string $err_tip error tip message
		 * @return 		boolean $is_ok true/false
		 * @access 		public
		 */
		public function chkIsSamePasswords($field_name1, $field_name2, $err_tip='')
			{
				$is_ok = ($this->fields_arr[$field_name1]==$this->fields_arr[$field_name2]);
				if (!$is_ok)
						$this->fields_err_tip_arr[$field_name1] = $this->fields_err_tip_arr[$field_name2] = $err_tip;
				return $is_ok;
			}

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
						$checked = (strcmp($key, $this->fields_arr[$field_name])==0)?"Checked":"";
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
		 * @param  string $invitationTable
		 * @return invitation id
		 * @access public
		 */
		public function setInvitationDetails($invitationTable)
			{
				$user_id = $this->getFormField('id');
				$invitation_code = $this->getFormField('icode');
			    $sql = 'SELECT invitation_id FROM '.$invitationTable.
						' WHERE user_id='.$this->dbObj->Param($user_id).
						' AND invitation_code='.$this->dbObj->Param($invitation_code).
						' LIMIT 0,1';

                $stmt = $this->dbObj->Prepare($sql);
                $rs = $this->dbObj->Execute($stmt, array($user_id, $invitation_code));
                if (!$rs)
            	    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount()>0)
				    {
				        $row = $rs->FetchRow();
						$this->setFormField('invitation_id', $row['invitation_id']);
				    }
			}

        /**
		 * SignUpFormHandler::sendRequestToAddToGroup()
		 * To insert subject and mail in mails table and return messgage id
		 *
		 * @param  string $subject
		 * @param  string $message
		 * @access public
		 * @return integer $message_id
		 **/
		public function sendRequestToAddToGroup( $newUserId = 0, $groupId = 0, $invitationUserId=0 )
			{
				if (!$invitationUserId or !$newUserId or !$groupId)
				    {
				        return false;
				    }

				$sql = 'SELECT user_name FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_id='.$this->dbObj->Param('user_id');

                $stmt = $this->dbObj->Prepare($sql);
                $rs = $this->dbObj->Execute($stmt, array($invitationUserId));
                if (!$rs)
            	    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
				    {
						$row = $rs->FetchRow();
						$friend_id = $invitationUserId;
						$friendName = $row['user_name'];

						$sql = 'SELECT group_name, group_url FROM '.$this->CFG['db']['tbl']['groups'].
								' WHERE group_id='.$this->dbObj->Param('groupId');

		                $stmt = $this->dbObj->Prepare($sql);
		                $rs = $this->dbObj->Execute($stmt, array($groupId));
	                    if (!$rs)
	                	    trigger_db_error($this->dbObj);

						$groupName = '';
						if ($rs->PO_RecordCount()>0)
						    {
						        $row = $rs->FetchRow();
								$groupName = $row['group_name'];
								$groupUrl = $row['group_url'];
						    }

						if ($groupName)
						    {
								$subject = $this->LANG['mail_group_invite_member_subject'];
								$subject = str_replace('VAR_GROUP_NAME', $groupName, $subject);

								$message = $this->LANG['mail_group_invite_member_message'];
								$message = str_replace('VAR_FRIEND_NAME', $this->fields_arr['user_name'], $message);

								$friendName = '<a href="'.getUrl('viewprofile','?user='.$friendName, $friendName, 'root').'">'.$friendName.'</a>';
								$message = str_replace('VAR_USER_NAME', $friendName, $message);
								$message = str_replace('VAR_GROUP_NAME', $groupName, $message);
								$message = str_replace('VAR_ADMIN_NAME', $this->CFG['user']['admin_user_name'], $message);
								$message = nl2br($message);

								$sql = 'INSERT INTO ' . $this->CFG['db']['tbl']['messages'] .
										' SET subject = '.$this->dbObj->Param('subject').
										', message ='.$this->dbObj->Param('message').
										', mess_date = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($subject, $message));
							    if (!$rs)
								    trigger_db_error($this->dbObj);

								$messageId  =  $this->dbObj->Insert_ID();

								$sql =  'INSERT INTO '.$this->CFG['db']['tbl']['messages_info'].
										' SET message_id = '.$this->dbObj->Param('message_id').
										', email_status = \'Request\''.
										', from_id ='.$this->dbObj->Param('from_id').
										', to_id ='.$this->dbObj->Param('to_id');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($messageId, $invitationUserId, $newUserId));
								    if (!$rs)
									    trigger_db_error($this->dbObj);

								$messageInfoId = $this->dbObj->Insert_ID();

								$acceptance_form = '<form name="form_join_member" id="selFormJoinMember" method="post" action="'.getUrl('groupjoinmember').'" autocomplete="off" >';
								$acceptance_form .= '<input type="submit" class="clsSubmitButton" name="accept" id="accept" value="'.$this->LANG['signup_group_request_accept'].'" />&nbsp;&nbsp;&nbsp;&nbsp;';
								$acceptance_form .= '<input type="submit" class="clsSubmitButton" name="deny" id="deny" value="'.$this->LANG['signup_group_request_decline'].'" />';
								$acceptance_form .= '<input type="hidden" name="group_id" value="'.$groupUrl.'" />';
								$acceptance_form .= '<input type="hidden" name="user_id" value="'.$invitationUserId.'" />';
								$acceptance_form .= '<input type="hidden" name="message_id" value="'.$messageInfoId.'" />';
								$acceptance_form .= '</form>';
								$message = str_replace('VAR_ACCEPTANCE_FORM', htmlentities($acceptance_form), $message);

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['messages'].
										' SET message='.$this->dbObj->Param('message').
									   	' WHERE message_id='.$this->dbObj->Param('message_id');

				               	$stmt = $this->dbObj->Prepare($sql);
				               	$rs = $this->dbObj->Execute($stmt, array($message, $messageId));
				            	if (!$rs)
				               		trigger_db_error($this->dbObj);

								$this->updateNewRequestCount($newUserId);
								return true;
							}
				    }
				return false;
			}

		/**
		 * SignUpFormHandler::sendRequestToAddAsFriend()
		 * To insert subject and mail in mails table and return messgage id
		 *
		 * @param  string $subject
		 * @param  string $message
		 * @access public
		 * @return integer $message_id
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

				if ($rs->PO_RecordCount())
				    {
						$row = $rs->FetchRow();
						$friend_id = $invitationUserId;
						$friend_name = $row['user_name'];

						$subject = str_replace('VAR_FRIEND_NAME', $friend_name, $this->LANG['request_friend_subject']);

						$acceptance_form = '';

						$friend_profile_link = '<a href="'.getUrl('viewprofile', '?user='.$friend_name, $friend_name, 'root').'" target="_blank">'.$friend_name.'</a>';

						$message = str_replace('VAR_USER_NAME',$this->getFormField('user_name') , $this->LANG['request_friend_content']);
						$message = str_replace('VAR_FRIEND_NAME', $friend_name, $message);
						$message = str_replace('{friend_profile_link}', $friend_profile_link, $message);
						$message = str_replace('{user_message}', '', $message);


						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['messages'].
								' SET subject = '.$this->dbObj->Param('subject').
								', message ='.$this->dbObj->Param('message').
								', mess_date = NOW()';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($subject, $message));
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						$message_id = $this->dbObj->Insert_ID();

						$sql =  'INSERT INTO '.$this->CFG['db']['tbl']['messages_info'].
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
						$message = str_replace('VAR_ACCEPTANCE_FORM', $acceptance_form, $message);

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
		 * SignUpFormHandler::sendInvitaionForGroupsAndFriends()
		 * To send the invitation for groups and friends
		 *
		 * @param  integer $user_id
		 * @param  integer $invitationId
		 * @return void
		 * @access public
		 */
		public function sendInvitaionForGroupsAndFriends($user_id=0, $invitationId=0)
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

						if (strcmp(strtolower($row['email']), strtolower($this->fields_arr['email']))==0)
						    {
								if ($this->CFG['admin']['members']['add_group_automatically'] AND $row['for_groups']=='1')
								    {
										$sql = 'SELECT group_id FROM '.$this->CFG['db']['tbl']['users_group_invitation'].
												' WHERE invitation_id='.$this->dbObj->Param('invitation_id');

						                $stmt = $this->dbObj->Prepare($sql);
						                $rs = $this->dbObj->Execute($stmt, array($invitationId));
					                    if (!$rs)
					                	    trigger_db_error($this->dbObj);

										if ($rs->PO_RecordCount() > 0)
										    {
										        while($row = $rs->FetchRow())
										            {
										        	    $group_id = $row['group_id'];
														$this->sendRequestToAddToGroup($user_id, $group_id, $invitationUserId);
										            } // while
										    }
								    }
							}
				    }
			}

		/**
		 * SignUpFormHandler::displayMandatoryIcon()
		 * Display the mandatory icon
		 *
		 * @param  string $field_name
		 * @return string
		 * @access public
		 */
		public function displayMandatoryIcon($field_name='')
			{
				$mandatoryFields = array('user_name', 'password', 'confirm_password', 'email', 'first_name', 'last_name', 'sex', 'country', 'dob', 'pin_code', 'postal_code', 'captcha', 'bank_info');
				if($field_name == '*' OR (in_array($field_name, $mandatoryFields)))
					{
						return $this->LANG['common_mandatory_field_icon'];
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
				$activation_link = getUrl('verify', '?code='.$code, '?code='.$code , 'root');

				if($this->CFG['admin']['signup_auto_activate'] AND $this->CFG['admin']['external_signup_auto_activate'])
					Redirect2URL($activation_link);

				$activation_subject = $this->LANG['activation_subject'];
				$link = $this->CFG['site']['url'];
				$this->setEmailTemplateValue('user_name', $this->fields_arr['user_name']);
				$this->setEmailTemplateValue('link', $link);
				$this->setEmailTemplateValue('activation_link', $activation_link);
				$activation_message = $this->LANG['activation_message'];

				$is_ok = $this->_sendMail($this->fields_arr['email'], $activation_subject, $activation_message, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);
				if($is_ok)
					$this->setCommonSuccessMsg($this->LANG['signup_activation_code_sent']);
				else
					$this->setCommonErrorMsg($this->LANG['signup_activation_code_not_sent']);
			}

		/**
		 * SignUpFormHandler::chkIsPasswordAndUserNameAreSame()
		 * To check username and password are same or not
		 *
		 * @param  string $err_tip
		 * @return boolean value
		 * @access public
		 */
		public function chkIsPasswordAndUserNameAreSame($err_tip = '')
			{
				if($this->fields_arr['user_name'] and $this->fields_arr['password'])
					{
						if($this->fields_arr['user_name'] == $this->fields_arr['password'])
							{
								$this->fields_err_tip_arr['password'] = $err_tip;
								return false;
							}
					}
				return true;
			}

		/**
		 * SignUpFormHandler::chkIsAllowedUserName()
		 * To check whether the username is allowed username or not
		 *
		 * @param  string $err_tip
		 * @return boolean value
		 */
		public function chkIsAllowedUserName($err_tip = '')
			{
				$user_name = strtolower($this->fields_arr['user_name']);
				if(in_array($user_name, $this->CFG['admin']['not_allowed_usernames']))
					{
						$this->fields_err_tip_arr['user_name'] = $err_tip;
						return false;
					}
				return true;
			}

		/**
		 * SignUpFormHandler::getDetailsFromIdentity()
		 *
		 * @return
		 */
		public function getDetailsFromIdentity()
			{
				$sql  = 'SELECT * FROM ' . $this->CFG['db']['tbl']['user_identity'] .
						' WHERE hashcode = ' . $this->dbObj->Param('hashcode');
				$rs = $this->dbObj->Execute($this->dbObj->Prepare($sql), array($this->getFormField('id')));
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$getEmailArray=array('imap','pop3');
						if(in_array($row['identity_from'],$getEmailArray))
							$this->setFormField('email', $row['identity']);

						$this->setFormField('identity', $row['identity']);
						$this->setFormField('user_id', $row['user_id']);
						return true;
					}
				return false;
			}

		/**
		 * SignUpFormHandler::getDetailsFromFacebookIdentity()
		 *
		 * @return
		 */
		public function getDetailsFromFacebookIdentity()
			{
				$sql  = 'SELECT * FROM ' . $this->CFG['db']['tbl']['facebook_identity'] .
						' WHERE hashcode = ' . $this->dbObj->Param('hashcode');

				$rs = $this->dbObj->Execute($this->dbObj->Prepare($sql), array($this->getFormField('hashcode')));
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$this->setFormField('hashcode', $row['hashcode']);
						$this->setFormField('user_id', $row['user_id']);
						return true;
					}
				return false;
			}

		/**
		 * SignUpFormHandler::updateUserIdentityWithHashCode()
		 *
		 * @param mixed $user_id
		 * @param mixed $status
		 * @return
		 */
		public function updateUserIdentityWithHashCode($user_id, $status)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['user_identity'].
						' SET status = '. $this->dbObj->Param('status').
						', user_id = ' . $this->dbObj->Param('user_id') .
						' WHERE hashcode = ' . $this->dbObj->Param('id');

				$rs = $this->dbObj->Execute($this->dbObj->Prepare($sql), array($status, $user_id , $this->getFormField('id')));
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);
			}

		/**
		 * SignUpFormHandler::updateFacebookIdentityWithHashCode()
		 *
		 * @param mixed $user_id
		 * @param mixed $status
		 * @return
		 */
		public function updateFacebookIdentityWithHashCode($user_id, $status)
			{
				$sql = 'UPDATE ' . $this->CFG['db']['tbl']['facebook_identity'].
						' SET status = '. $this->dbObj->Param('status').
						', user_id = ' . $this->dbObj->Param('user_id').
						' WHERE hashcode = ' . $this->dbObj->Param('hashcode');

				$rs = $this->dbObj->Execute($this->dbObj->Prepare($sql), array($status, $user_id , $this->getFormField('hashcode')));
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);
			}

		 /**
    	  * EditProfileFormHandler::updateFormFieldsInUsersTable()
		  * To update the form values into users table
		  *
		  * @param 		string $table_name Table name
		  * @param 		integer $user_id User id
		  * @param 		array $fields_to_update_arr Array of fields to update
		  * @return 	void
		  * @access 	public
		  */
		public function updateFormFieldsInUsersTable($table_name, $user_id, $fields_to_update_arr=array())
			{
				$sql = 'UPDATE '.$table_name.' SET ';
				foreach($fields_to_update_arr as $field_name) {
					if (isset($this->fields_arr[$field_name]))
						{
							$sql .= $field_name.'='.$this->dbObj->Param($this->fields_arr[$field_name]).', ';
							$paramFields[] = $this->fields_arr[$field_name];
						}
				}
				$sql = substr($sql, 0, strrpos($sql, ','));
				$sql .= ' WHERE user_id ='.$this->dbObj->Param($user_id);
				$paramFields[] = $user_id;
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, $paramFields);
				//raise user error... fatal
				if (!$rs)
				    trigger_db_error($this->dbObj);
				$updated = 	($this->dbObj->Affected_Rows()>0);
				return $updated;
			}

		/**
		 * SignUpFormHandler::InsertFacebookProfile()
		 *
		 * @param mixed $uid
		 * @return
		 */
		public function InsertFacebookProfile($uid)
	   		{
		  		$sql = 'INSERT INTO  '.$this->CFG['db']['tbl']['facebook_profile'].
						' (user_id) VALUES ('.$uid.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
			        trigger_db_error($this->dbObj);
		  	}

		/**
		 * PhotoUpload::storeImagesTempServer()
		 *
		 * @param  $uploadUrl
		 * @param  $extern
		 * @return
		 */
		public function storeImagesTempServer($uploadUrl, $extern)
			{
				// GET LARGE IMAGE
				if ($this->CFG['image_large_name'] == 'L')
					{
						if ($this->CFG['image_large_height'] or $this->CFG['image_large_width'])
							{
								$this->imageObj->resize($this->CFG['image_large_width'], $this->CFG['image_large_height'], '-');								$this->imageObj->output_resized($uploadUrl . 'L.' . $extern, strtoupper($extern));
								$image_info = getImageSize($uploadUrl . 'L.' . $extern);
								$this->L_WIDTH = $image_info[0];
								$this->L_HEIGHT = $image_info[1];

							}
						else
							{
								$this->imageObj->output_original($uploadUrl . 'L.' . $extern, strtoupper($extern));
								$image_info = getImageSize($uploadUrl . 'L.' . $extern);
								$this->L_WIDTH = $image_info[0];
								$this->L_HEIGHT = $image_info[1];
							}
					}
				// GET THUMB IMAGE
				if ($this->CFG['image_thumb_name'] == 'T')
					{
						$this->imageObj->resize($this->CFG['image_thumb_width'], $this->CFG['image_thumb_height'], '-');
						$this->imageObj->output_resized($uploadUrl . 'T.' . $extern, strtoupper($extern));
						$image_info = getImageSize($uploadUrl . 'T.' . $extern);
						$this->T_WIDTH = $image_info[0];
						$this->T_HEIGHT = $image_info[1];
					}
				// GET SMALL IMAGE
				if ($this->CFG['image_small_name'] == 'S')
					{
						$this->imageObj->resize($this->CFG['image_small_width'], $this->CFG['image_small_height'], '-');
						$this->imageObj->output_resized($uploadUrl . 'S.' . $extern, strtoupper($extern));
						$image_info = getImageSize($uploadUrl . 'S.' . $extern);
						$this->S_WIDTH = $image_info[0];
						$this->S_HEIGHT = $image_info[1];
					}
				$wname = $this->CFG['image_large_name'] . '_WIDTH';
				$hname = $this->CFG['image_large_name'] . '_HEIGHT';
				$this->L_WIDTH = $this->$wname;
				$this->L_HEIGHT = $this->$hname;

				$wname = $this->CFG['image_thumb_name'] . '_WIDTH';
				$hname = $this->CFG['image_thumb_name'] . '_HEIGHT';
				$this->T_WIDTH = $this->$wname;
				$this->T_HEIGHT = $this->$hname;

				$wname = $this->CFG['image_small_name'] . '_WIDTH';
				$hname = $this->CFG['image_small_name'] . '_HEIGHT';
				$this->S_WIDTH = $this->$wname;
				$this->S_HEIGHT = $this->$hname;
			}

		/**
		 * PhotoUpload::getServerDetails()
		 *
		 * @return
		 */
		public function getServerDetails()
			{
				$sql = 'SELECT server_url, ftp_server, ftp_usrename, ftp_password'.
						' FROM '.$this->CFG['db']['tbl']['server_settings'].
						' WHERE server_for=\'avatar\' AND server_status=\'Yes\' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				if ($row = $rs->FetchRow())
					{
						$this->fields_arr['ftp_server'] = $row['ftp_server'];
						$this->fields_arr['ftp_usrename'] = $row['ftp_usrename'];
						$this->fields_arr['ftp_password'] = $row['ftp_password'];
						$this->fields_arr['server_url'] = $row['server_url'];
						return true;
					}
				return false;
			}

		/**
		 * AddMemberFormHandler::getAge()
		 *
		 * @param mixed $dob
		 * @return
		 */
		public function getAge($dob)
			{
				$sql = 'SELECT TIMEDIFF(NOW(), \''.$dob.' 00:00:00\') AS date_added';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$date_added_pc = explode(':', $row['date_added']);
						$date_added_pc[0] = intval($date_added_pc[0]);
						$date_added_pc[1] = intval($date_added_pc[1]);
						$date_added_pc[2] = intval($date_added_pc[2]);

						$day = floor($date_added_pc[0]/24);
						$time = 0;
						if($day>365)
							{
								$year = floor($day/365);
								$time = $year;
							}
						return $time;
					}
			}

		/**
		 * AddMemberFormHandler::chkIsCorrectDateSignup()
		 * Verifies the date value
		 *
		 * @param string $date date
		 * @param string $month month
		 * @param string $year year
		 * @param string $field form field for the date
		 * @param $err_tip error tip
		 * @return
		 **/
		public function chkIsCorrectDateSignup($day, $field='', $err_tip_empty='', $err_tip_invalid='')
			{
				$dodArray = explode('-', $day);
				$date = $dodArray[2];
				$month = $dodArray[1];
				$year = $dodArray[0];
				if (empty($field))
				    {
						$this->fields_err_tip_arr[$field] = $err_tip_empty;
						return false;
				    }
				if (checkdate(intval($month), intval($date), intval($year)))
				    {
						$dob = $year.'-'.$month.'-'.$date;
						$date_to_validation = date('Y')-$this->CFG['admin']['members_signup']['age_limit_start']-2;
						if($year>$date_to_validation)
							$age = $this->getAge($dob);
						else
							$age = date('Y')-$year+2;
						if($age<$this->CFG['admin']['members_signup']['age_limit_start'])
							{
								$this->LANG['err_tip_age_min'] = str_replace('VAR_MIN_AGE', $this->CFG['admin']['members_signup']['age_limit_start'], $this->LANG['err_tip_age_min']);
								$this->fields_err_tip_arr[$field] = $this->LANG['err_tip_age_min'];
								return false;
							}
						if($age>$this->CFG['admin']['members_signup']['age_limit_end'])
						  	{
								$this->LANG['err_tip_age_max'] = str_replace('VAR_MAX_AGE', $this->CFG['admin']['members_signup']['age_limit_end'], $this->LANG['err_tip_age_max']);
								$this->fields_err_tip_arr[$field] = $this->LANG['err_tip_age_max'];
								return false;
							}
						 $this->fields_arr[$field] = $dob;
					     return true;
				    }
				else
					{
						$this->fields_err_tip_arr[$field] = $err_tip_invalid;
						return false;
					}
			}

		/**
         * SignUpFormHandler::chkCaptcha()
         *
         * @param mixed $field_name
         * @param string $err_tip
         * @return boolean
         */
        public function chkCaptcha($field_name, $err_tip='')
			{
				if ($this->fields_arr["recaptcha_response_field"])
					{
			        	$resp = recaptcha_check_answer ($this->CFG['captcha']['private_key'],
						 					$_SERVER["REMOTE_ADDR"],
						 					$this->fields_arr["recaptcha_challenge_field"],
											$this->fields_arr["recaptcha_response_field"]);

			        	if ($resp->is_valid)
						 	{
	                			return true;
	                		}
						else
							{
							    $this->fields_err_tip_arr[$field_name] = $err_tip;
								return false;
							}
					}
			}
}
//<<<<<-------------- Class SignUpFormHandler begins ---------------//
//-------------------- Code begins -------------->>>>>//
$sgnfrm = new SignUpFormHandler();

if(!$sgnfrm->chkAllowedModule(array('external_login')))
 	Redirect2URL($CFG['site']['url']);

$sgnfrm->setPageBlockNames(array('form_signup','form_facebook_signup'));
$sgnfrm->setFormField('user_name', '');
$sgnfrm->setFormField('password', '');
$sgnfrm->setFormField('confirm_password', '');
$sgnfrm->setFormField('email', '');
$sgnfrm->setFormField('first_name', '');
$sgnfrm->setFormField('last_name', '');
$sgnfrm->setFormField('sex', 'male');
$sgnfrm->setFormField('country', '');
$sgnfrm->setFormField('agreement', '');
$sgnfrm->setFormField('dob', '');
$sgnfrm->setFormField('bank_info', '');
$sgnfrm->setFormField('signup_ip', $CFG['remote_client']['ip']);
$sgnfrm->setFormField('icode', '');
$sgnfrm->setFormField('id', '');
$sgnfrm->setFormField('hashcode', '');
$sgnfrm->setFormField('identity', '');
$sgnfrm->setFormField('invitation_id', 0);
$sgnfrm->setFormField('postal_code', '');
$sgnfrm->setFormField('captcha', '');
$sgnfrm->setFormField('signup_facebook', 'No');
$sgnfrm->setFormField('recaptcha_challenge_field', '');
$sgnfrm->setFormField('recaptcha_response_field', '');

if($CFG['signup']['captcha'] and $CFG['signup']['captcha_method']=='honeypot' and phFormulaRayzz())
	$sgnfrm->setFormField(phFormulaRayzz(), '');

$sgnfrm->setCountriesListArr($LANG_LIST_ARR['countries'],array('' => $LANG['signup_choose']));
$sgnfrm->setAllPageBlocksHide();

$LANG['signup_user_name'] = str_replace('VAR_MIN_COUNT', $CFG['fieldsize']['username']['min'], $LANG['signup_user_name']);
$LANG['signup_user_name'] = str_replace('VAR_MAX_COUNT', $CFG['fieldsize']['username']['max'], $LANG['signup_user_name']);
$LANG['signup_password'] = str_replace('VAR_MIN_COUNT', $CFG['fieldsize']['password']['min'], $LANG['signup_password']);
$LANG['signup_password'] = str_replace('VAR_MAX_COUNT', $CFG['fieldsize']['password']['max'], $LANG['signup_password']);
$LANG['help']['first_name'] = str_replace('VAR_MIN_COUNT', $CFG['fieldsize']['first_name']['min'], $LANG['help']['first_name']);
$LANG['help']['first_name'] = str_replace('VAR_MAX_COUNT', $CFG['fieldsize']['first_name']['max'], $LANG['help']['first_name']);
$LANG['help']['last_name'] = str_replace('VAR_MIN_COUNT', $CFG['fieldsize']['last_name']['min'], $LANG['help']['last_name']);
$LANG['help']['last_name'] = str_replace('VAR_MAX_COUNT', $CFG['fieldsize']['last_name']['max'], $LANG['help']['last_name']);

if ($sgnfrm->isPageGETed($_GET, 'icode') and $sgnfrm->isPageGETed($_GET, 'id'))
    {
     	$sgnfrm->sanitizeFormInputs($_GET);
		$icode = $sgnfrm->getFormField('icode');
		if ($icode)
		    {
				$sgnfrm->setInvitationDetails($CFG['db']['tbl']['users_invitation']);
		    }
    }
if($sgnfrm->isFormGETed($_GET, 'id'))
	{
		$sgnfrm->sanitizeFormInputs($_GET);
		if($sgnfrm->getDetailsFromIdentity())
			{
				$sgnfrm->setPageBlockShow('form_signup');
			}
		else
			{
				$sgnfrm->setPageBlockShow('msg_form_error');
			}
	}
else if(!$sgnfrm->isFormPOSTed($_POST, 'signup_submit') and $sgnfrm->isFormGETed($_GET, 'hashcode'))
	{
		$sgnfrm->sanitizeFormInputs($_GET);

		if($sgnfrm->getDetailsFromFacebookIdentity())
			{
				$sgnfrm->setFormField('signup_facebook', 'Yes');

				$facebook = new Facebook($CFG['facebook']['api_key'], $CFG['facebook']['appsecret']);
				$facebook_userid = $facebook->require_login();
				$user_details = $facebook->api_client->users_getInfo($facebook_userid, array('last_name','first_name','name','sex', 'pic', 'pic_with_logo', 'pic_small'));

				$sgnfrm->setFormField('first_name', $user_details[0]['first_name']);
				$sgnfrm->setFormField('last_name', $user_details[0]['last_name']);
				$sgnfrm->setFormField('sex', $user_details[0]['sex']);
				$sgnfrm->setFormField('openid_type', 'facebook');

				$sgnfrm->setPageBlockShow('form_signup');
			}
		else
			{
				$sgnfrm->setPageBlockShow('block_msg_form_error');
				$sgnfrm->setCommonErrorMsg($LANG['common_msg_error_sorry']);
			}
	}
if ($sgnfrm->isFormPOSTed($_POST, 'signup_submit'))
	{
		$sgnfrm->sanitizeFormInputs($_REQUEST);

		$sgnfrm->chkIsNotEmpty('email', $LANG['common_err_tip_required']) and
			$sgnfrm->chkIsValidEmail('email', $LANG['common_err_tip_invalid_email_format']) and
				$sgnfrm->chkIsNotDuplicateEmail($CFG['db']['tbl']['users'], 'email',  $LANG['signup_err_tip_email_already_exists']);

		$sgnfrm->chkIsNotEmpty('user_name', $LANG['common_err_tip_required']) and
			$sgnfrm->chkIsAlphaNumeric('user_name', $LANG['signup_err_tip_invalid_username']) and
			$sgnfrm->chkIsValidSize('user_name', 'username', $LANG['common_err_tip_invalid_size']) and
			$sgnfrm->chkIsAllowedUserName($LANG['not_allowed_username']) and
			($sgnfrm->chkIsNotDuplicateUserName($CFG['db']['tbl']['users'], 'user_name', $LANG['signup_err_tip_name_already_exists']) or
				$sgnfrm->setCommonErrorMsg($LANG['signup_err_tip_name_already_exists']));

		$sgnfrm->chkIsNotEmpty('first_name', $LANG['common_err_tip_required']) and
			$sgnfrm->chkIsValidSize('first_name', 'first_name', $LANG['common_err_tip_invalid_size']);
		$sgnfrm->chkIsNotEmpty('last_name', $LANG['common_err_tip_required']) and
			$sgnfrm->chkIsValidSize('last_name', 'first_name', $LANG['common_err_tip_invalid_size']);

		$sgnfrm->chkIsNotEmpty('dob', $LANG['common_err_tip_required']) ;
		if($sgnfrm->chkIsValidDate('dob',$LANG['signup_err_tip_dob_invalid']))
			{
				// check age limit......
				$sgnfrm->chkIsCorrectDateSignup($sgnfrm->getFormField('dob'), 'dob', $LANG['signup_err_tip_dob_invalid'], $LANG['signup_err_tip_dob_invalid']);
			}

		$sgnfrm->chkIsNotEmpty('country', $LANG['common_err_tip_required']);
		$sgnfrm->chkIsNotEmpty('postal_code', $LANG['common_err_tip_required']);
		$sgnfrm->chkIsNotEmpty('agreement', $LANG['common_err_tip_required']);

		if($sgnfrm->isValidFormInputs() and $CFG['signup']['captcha'])
			{
				if($CFG['signup']['captcha_method'] == 'recaptcha' and $CFG['captcha']['public_key'] and $CFG['captcha']['private_key'])
					{
						$sgnfrm->chkIsNotEmpty('recaptcha_response_field', $LANG['common_err_tip_compulsory']) and
						$sgnfrm->chkCaptcha('recaptcha_response_field', $LANG['common_err_tip_invalid_captcha']);
					}
				elseif($CFG['signup']['captcha_method']=='image')
					{
						$sgnfrm->chkIsNotEmpty('captcha', $LANG['common_err_tip_required']) and
						$sgnfrm->chkIsValidCaptcha('captcha', $LANG['signup_err_tip_invalid']);
					}
				elseif($CFG['signup']['captcha_method']=='honeypot')
						$sgnfrm->chkIsValidHoneyPot('captcha');
			}
		if ($sgnfrm->isValidFormInputs())
			{
				$sgnfrm->setFormField('referrer_id', getReferer());

				if($CFG['admin']['allow_all_post_article'])
					$sgnfrm->setFormField('allow_article', 'Yes');
				else
					$sgnfrm->setFormField('allow_article', 'No');

				$sgnfrm->setFormField('openid_used', 'Yes');
				$sgnfrm->setFormField('openid_type', '');

				if($sgnfrm->getFormField('signup_facebook')=='Yes')
					{
						$sgnfrm->setFormField('openid_used', 'FB');

						$sgnfrm->setFormField('openid_type', 'facebook');
					}

				$user_id = $sgnfrm->insertFormFieldsInUserTable(array('user_name', 'email', 'password', 'first_name', 'last_name', 'sex',
																	'dob', 'country', 'postal_code', 'signup_ip', 'referrer_id', 'allow_article','openid_used','openid_type'));

				$sgnfrm->setFormField('user_id', $user_id);
				$sgnfrm->updateUsersAgeValue($CFG['db']['tbl']['users'], $user_id);
				if($sgnfrm->getFormField('signup_facebook')=='Yes')
					{
						$facebook = new Facebook($CFG['facebook']['api_key'], $CFG['facebook']['appsecret']);
						$facebook_userid = $facebook->require_login();
						$user_details = $facebook->api_client->users_getInfo($facebook_userid, array('last_name','first_name','name','sex', 'pic', 'pic_with_logo', 'pic_small'));

						if(!empty($user_details[0]['pic_with_logo']))
							$sgnfrm->chkIsFaceBookImageUploaded($user_details[0]['pic_with_logo'], $user_id);
						$sgnfrm->InsertFacebookProfile($user_id);
						$sgnfrm->updateFacebookIdentityWithHashCode($user_id, 'Ok');

					}
				else
					{
						$sgnfrm->updateUserIdentityWithHashCode($user_id, 'Ok');

					}

				$sgnfrm->sendActivationCode();
				$invitationId = $sgnfrm->getFormField('invitation_id');
				if ($invitationId >0  AND ($CFG['admin']['members']['add_friend_automatically'] || $CFG['admin']['members']['add_group_automatically']) )
				    {
						$sgnfrm->sendInvitaionForGroupsAndFriends($user_id,  $invitationId);
						//Add Activity
						if($CFG['admin']['show_recent_activities'])
							{
								$GeneralActivity->activity_arr['action_key'] = 'new_member';
								$GeneralActivity->activity_arr['user_id'] = $user_id;
								$user_details = $sgnfrm->getUserDetail('user_id', $user_id);
								$GeneralActivity->activity_arr['user_name'] = $user_details['user_name'];
								$GeneralActivity->activity_arr['doj'] = $user_details['doj'];
								$GeneralActivity->addActivity($GeneralActivity->activity_arr);
							}
						//Insert records to friend_suggestion table
						$sgnfrm->insertToFriendSuggestionTable($user_id);
				    }
				$sgnfrm->setAllPageBlocksHide();
				$CFG['feature']['auto_hide_success_block'] = false;
				$sgnfrm->setCommonSuccessMsg($LANG['signup_success'].'<br />'.
					($sgnfrm->getCommonSuccessMsg()?$sgnfrm->getCommonSuccessMsg():$sgnfrm->getCommonErrorMsg()));
				$sgnfrm->setPageBlockShow('block_msg_form_success');
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
//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($sgnfrm->isShowPageBlock('form_signup'))
	{
		$sgnfrm->LANG['signup_user_name_errormsg'] = str_replace('VAR_MIN', $CFG['fieldsize']['username']['min'], $LANG['common_err_tip_invalid_character_size']);
		$sgnfrm->LANG['signup_user_name_errormsg'] = str_replace('VAR_MAX', $CFG['fieldsize']['username']['max'], $sgnfrm->LANG['signup_user_name_errormsg']);
		$sgnfrm->LANG['signup_password_errormsg'] = str_replace('VAR_MIN', $CFG['fieldsize']['password']['min'], $LANG['common_err_tip_invalid_password']);
		$sgnfrm->LANG['signup_password_errormsg'] = str_replace('VAR_MAX', $CFG['fieldsize']['password']['max'], $sgnfrm->LANG['signup_password_errormsg']);

		$terms_link = '<a href="'.getUrl('static','?pg=terms', 'terms/', 'root').'">'.$LANG['terms_of_use_link'].'</a>';
		$privacy_link = '<a href="'.getUrl('static','?pg=privacy', 'privacy/', 'root').'">'.$LANG['privacy_policy_link'].'</a>';
		$sgnfrm->form_signup['signup_agreement'] = str_replace('VAR_TERMS_OF_USE_LINK', $terms_link, $LANG['signup_agreement']);
		$sgnfrm->form_signup['signup_agreement'] = str_replace('VAR_PRIVACY_POLICY_LINK', $privacy_link, $sgnfrm->form_signup['signup_agreement']);
		$sgnfrm->form_signup['signup_user_name'] = $LANG['signup_user_name'];
		$sgnfrm->form_signup['signup_password']  = $LANG['signup_password'];
		$first_option_arr = array(''=>$LANG['signup_choose']);
		$smartyObj->assign('smarty_country_list', $first_option_arr + $LANG_LIST_ARR['countries']);
		$sgnfrm->form_signup['showSexOptionButtons'] = $sgnfrm->showSexOptionButtons($LANG_LIST_ARR['gender'], 'sex');
	}

$sgnfrm->includeHeader();
?>
<script language="javascript" type="text/javascript">
	var img_count=1;
	function changeCaptchaImage(){
		document.getElementById('captchaImage').src = '<?php echo $CFG['site']['url']; ?>captchaSignup.php?img_count='+img_count;
		img_count++;
		return false;
	}
</script>
<?php
setTemplateFolder('root/');
$smartyObj->display('signupExternal.tpl');
$sgnfrm->includeFooter();
?>