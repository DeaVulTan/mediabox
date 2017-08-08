<?php
if(class_exists('signupAndLoginHandler'))
	{
		$parent_class = 2;
	}
else
	{
		$parent_class = 1;
	}

switch($parent_class)
	{
		case 2:
			class fh extends signupAndLoginHandler{}
			break;
		case 1:
		default:
			class fh extends FormHandler{}
			break;
	}

/**
 * FriendHandler
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class FriendHandler extends fh
	{
		private $_ownerId = 0;
		private $_friendId = 0;
		public $ownerDetails 	= array();
		public $friendDetails 	= array();
		private $_isValidFriend = false;
		private $_isFriendIsMe = false;
		private $_defaultTemplateVariables = array();
		private $_invitationDetails = array();

		/**
		 * FriendHandler::setOwnerId()
		 *
		 * @param integer $id
		 * @return
		 */
		public function setOwnerId($id = 0)
			{
				$this->_ownerId = $id;
				$this->setOwnerDetails();
			}

		/**
		 * FriendHandler::makeGlobalize()
		 *
		 * @param array $cfg
		 * @param array $lang
		 * @return
		 */
		public function makeGlobalize($cfg = array(), $lang=array())
			{
				parent::makeGlobalize($cfg, $lang);
				$this->setOwnerId($this->CFG['user']['user_id']);
				$this->_defaultTemplateVariables = array(
					'site_name' => $this->CFG['site']['name'],
					'site_link' => $this->CFG['site']['url'],
					'end_link'	=> '</a>'
				);

			}

		/**
		 * FriendHandler::getOwnerId()
		 *
		 * @return
		 */
		public function getOwnerId()
			{
				return $this->_ownerId;
			}

		/**
		 * FriendHandler::setFriendId()
		 *
		 * @param integer $friend_id
		 * @param mixed $gather_details
		 * @return
		 */
		public function setFriendId($friend_id = 0, $gather_details=true)
			{
				$this->_friendId = $friend_id;
				if ($gather_details)
				    {
						$this->setFriendDetails();
				    }
			}

		/**
		 * FriendHandler::getFriendId()
		 *
		 * @return
		 */
		public function getFriendId()
			{
				return $this->_friendId;
			}

		/**
		 * FriendHandler::setOwnerDetails()
		 *
		 * @return
		 */
		public function setOwnerDetails()
			{
				$this->ownerDetails = $this->gatherUserDetails($this->getOwnerId());
				if ($this->ownerDetails)
				    {
						$this->_isValidOwner = true;
				    }
			}

		/**
		 * FriendHandler::setFriendDetails()
		 *
		 * @return
		 */
		public function setFriendDetails()
			{
				$this->friendDetails = $this->gatherUserDetails($this->getFriendId());
				if ($this->friendDetails)
				    {
						$this->_isValidFriend = true;
						$this->_isFriendIsMe = (strcmp($this->getOwnerId(), $this->getFriendId())==0);
				    }
			}

		/**
		 * FriendHandler::isThisFriendRequested()
		 *
		 * @return
		 */
		public function isThisFriendRequested()
			{
				$ownerId = $this->getOwnerId();
				$friendId = $this->getFriendId();

				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['messages_info'].
						' WHERE ((from_id='.$this->dbObj->Param('from_id').' AND to_id='.$this->dbObj->Param('to_id').')'.
						' OR (from_id='.$this->dbObj->Param('from_id').' AND to_id='.$this->dbObj->Param('to_id').'))'.
						' AND email_status = \'Request\''.
						' AND to_delete = \'No\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($ownerId, $friendId, $friendId, $ownerId));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					return true;
				return false;
			}

		/**
		 * FriendHandler::setFriendDetailsWithEmail()
		 *
		 * @param string $email
		 * @return
		 */
		public function setFriendDetailsWithEmail($email='')
			{
				$this->_isValidFriend = false;
				if ($this->friendDetails = getUserDetail('email', $email))
					{
						$this->_isValidFriend = true;
						$this->setFriendId($this->friendDetails['user_id'], false);
						$this->_isFriendIsMe = (strcmp($this->getOwnerId(), $this->getFriendId())==0);
					}
			}

		/**
		 * FriendHandler::gatherUserDetails()
		 *
		 * @param integer $user_id
		 * @return
		 */
		public function gatherUserDetails($user_id = 0)
			{
				return getUserDetail('user_id', $user_id);
			}

		/**
		 * FriendHandler::isValidFriend()
		 *
		 * @return
		 */
		public function isValidFriend()
			{
				return $this->_isValidFriend;
			}

		/**
		 * FriendHandler::isFriendIsMe()
		 *
		 * @return
		 */
		public function isFriendIsMe()
			{
				return $this->_isFriendIsMe;
			}

		/**
		 * FriendHandler::isFriendIsAMember()
		 *
		 * @return
		 */
		public function isFriendIsAMember()
			{
				return $this->_isValidFriend;
			}

		/**
		 * FriendHandler::chkIsAlreadyFriend()
		 *
		 * @return
		 */
		public function chkIsAlreadyFriend()
			{
				$ownerId = $this->getOwnerId();
				$friendId = $this->getFriendId();
				$sql = 	' SELECT 1 FROM '.$this->CFG['db']['tbl']['friends_list'].
						' WHERE (owner_id='.$this->dbObj->Param($ownerId).' AND friend_id='.$this->dbObj->Param($friendId).')'.
					    ' OR (owner_id='.$this->dbObj->Param($friendId).' AND friend_id='.$this->dbObj->Param($ownerId).') LIMIT 0,1';
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($ownerId, $friendId, $friendId, $ownerId));
				//raise user error... fatal
				if (!$rs)
				trigger_db_error($this->dbObj);
				$isAlreadyFriend = false;
				if ($rs->PO_RecordCount())
					{
						$user_details_arr=$this->gatherUserDetails($friendId);
						$this->fields_arr['friend_name']=isset($user_details_arr['user_name'])?$user_details_arr['user_name']:'';
						$isAlreadyFriend = true;
				    }
				return $isAlreadyFriend;
			}

		/**
		 * FriendHandler::isThisFriendBlocked()
		 *
		 * @return
		 */
		public function isThisFriendBlocked()
			{
				$ownerId = $this->getOwnerId();
				$friendId = $this->getFriendId();

				$sql = 	' SELECT user_id='.$this->dbObj->Param($ownerId).' as uBlocked, user_id='.$this->dbObj->Param($friendId).' as heBlocked '.
						' FROM '.$this->CFG['db']['tbl']['block_members'].
						' WHERE '.
						' (user_id='.$this->dbObj->Param($ownerId).' AND block_id='.$this->dbObj->Param($friendId).') '.
						' OR ( user_id='.$this->dbObj->Param($friendId).' AND block_id='.$this->dbObj->Param($ownerId).') LIMIT 1';

				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($ownerId, $friendId, $ownerId, $friendId, $friendId, $ownerId));
				//raise user error... fatal
				if (!$rs)
				trigger_db_error($this->dbObj);
				$row = array();
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
				        return $row;
				    }
				else
					{
						return false;
					}
			}

		/**
		 * FriendHandler::sendInternalMessage()
		 *
		 * @param integer $from_id
		 * @param integer $to_id
		 * @param string $subject
		 * @param string $message
		 * @param string $email_status
		 * @return
		 */
		public function sendInternalMessage($from_id = 0, $to_id = 0, $subject='', $message = '', $email_status='Normal')
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['messages']. ' SET '.
						' subject = '.$this->dbObj->Param($subject).','.
						' message ='.$this->dbObj->Param($message).','.
						' mess_date = now()';
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($subject, $message));
				//raise user error... fatal
				if (!$rs)
				    trigger_db_error($this->dbObj);

				$message_id = $this->dbObj->Insert_ID();

				$sql =  ' INSERT INTO '.$this->CFG['db']['tbl']['messages_info'] . ' SET '.
						' message_id = '.$this->dbObj->Param($message_id).','.
						' email_status='.$this->dbObj->Param($email_status).','.
						' from_id ='.$this->dbObj->Param($from_id).','.
						' to_id ='.$this->dbObj->Param($to_id);
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($message_id, $email_status, $from_id, $to_id));
				//raise user error... fatal
				if (!$rs)
				    trigger_db_error($this->dbObj);
				$message_info_id = $this->dbObj->Insert_ID();
				$messageDetails = array();
				$messageDetails['message_id'] = $message_id;
				$messageDetails['message_info_id'] = $message_info_id;
				return $messageDetails;
			}

		/**
		 * FriendHandler::_sendFriendRequest()
		 *
		 * @param integer $from_id
		 * @param integer $to_id
		 * @param string $subject
		 * @param string $message
		 * @return
		 */
		private function _sendFriendRequest($from_id = 0, $to_id = 0, $subject='', $message = '')
			{
				return $this->sendInternalMessage($from_id, $to_id, $subject, $message, 'Request');
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function sendToTrashOwnerSentMail($message_info_id)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['messages_info'].
						' SET from_delete = \'Trash\''.
						' WHERE info_id = '.$this->dbObj->Param($message_info_id);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($message_info_id));
				if (!$rs)
					    trigger_db_error($this->dbObj);
			}

		/**
		 * FriendHandler::sendFriendRequestMessage()
		 *
		 * @param string $user_message
		 * @return
		 */
		public function sendFriendRequestMessage($user_message = '')
			{
				$subjectTemplate = $this->LANG['request_friend_subject'];
				$messageTemplate = $this->LANG['request_friend_content'];
				$subjectVariables = $messageVariables = array();

				$ownerId = $this->getOwnerId();
				$ownerName = $this->ownerDetails['user_name'];
				$friendId = $this->getFriendId();
				$friendName = $this->friendDetails['user_name'];
				$subjectVariables['VAR_FRIEND_NAME'] = $ownerName;

				$subject = $this->_replaceConfigVariables($subjectTemplate, $subjectVariables);
				$newFriendRequestDetails = $this->_sendFriendRequest($ownerId, $friendId, $subject);
				$message_id = $newFriendRequestDetails['message_id'];
				$message_info_id = $newFriendRequestDetails['message_info_id'];

				//Delete the sent mail list of owner id
				$this->sendToTrashOwnerSentMail($message_info_id);

				$ownerProfileUrl = getMemberProfileUrl($ownerId, $ownerName);
				$friend_profile_link = '<a href="'.$ownerProfileUrl.'" target="_blank">'.$ownerName.'</a>';
				$messageVariables['VAR_USER_NAME'] = $friendName;
				$messageVariables['VAR_FRIEND_PROFILE_LINK'] = $friend_profile_link;
				$messageVariables['VAR_USER_MESSAGE']  = $user_message;

				$friendAcceptanceFormAction = getUrl('friendaccept');
				$acceptance_form = '<div><form name="friendRequestAcceptanceForm" id="friendRequestAcceptanceForm" action="'.$friendAcceptanceFormAction.'" method="post">'.
								   '<p><input type="submit" class="clsSubmitButton" name="acceptSubmit" value="'.$this->LANG['invite_request_accept'].'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" class="clsSubmitButton" name="declineSubmit" value="'.$this->LANG['invite_request_decline'].'"><input type="hidden" name="friend" value="'.$ownerId.'" /><input type="hidden" name="messageInfoId" value="'.$message_info_id.'" /></form></div>';
				$acceptance_form = addslashes(htmlentities($acceptance_form));
				$messageVariables['VAR_ACCEPTANCE_FORM'] = $acceptance_form;
				$message = $this->_replaceConfigVariables($messageTemplate, $messageVariables);

				$this->updateInternalMessage($message_id, $message);
				$this->updateNewRequestCount($friendId);
				$message = html_entity_decode($message);

				if(chkIsAllowedNotificationEmail('friend_invitation', $friendId))
					{
						//External mail sending
						$subject_external = $this->LANG['new_friend_request_received_subject'];
						$message_external = $this->LANG['new_friend_request_received_content'];

						$url = getUrl('mailread','?folder=inbox&message_id='.$message_info_id, 'inbox/?message_id='.$message_info_id);

						$mail_link = '<a href="'.$url.'">'.$url.'</a>';
						$link = '<a href="'.$this->CFG['site']['url'].'">'.$this->CFG['site']['url'].'</a>';

						$this->setEmailTemplateValue('receiver_name', $friendName);
						$this->setEmailTemplateValue('sender_name', $ownerName);
						$this->setEmailTemplateValue('mail_link', $mail_link);
						$this->setEmailTemplateValue('link', $link);

						$mailSent = $this->_sendEmail($this->friendDetails['email'], $subject_external, $message_external, false, false);
					}
				$this->removeFromFriendSuggestions();
			}

		/**
		 * FriendHandler::removeFromFriendSuggestions()
		 *
		 * @return
		 */
		public function removeFromFriendSuggestions()
			{
				$ownerId = $this->getOwnerId();
				$friendId = $this->getFriendId();

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['friend_suggestion'].
						' SET status =\'Deleted\''.
						' WHERE (user_id = '.$this->dbObj->Param('ownerId').
						' AND friend_id = '.$this->dbObj->Param('friendId').')'.
						' OR (friend_id = '.$this->dbObj->Param('friendId1').
						' AND user_id = '.$this->dbObj->Param('ownerId2').')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($ownerId, $friendId, $ownerId, $friendId));
			    if (!$rs)
				    trigger_db_error($this->dbObj);
			}

		/**
		 * FriendHandler::updateInternalMessage()
		 *
		 * @param integer $message_id
		 * @param string $message
		 * @return
		 */
		public function updateInternalMessage($message_id=0, $message='')
			{
				$message = nl2br($message);
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['messages']. ' SET '.
					   ' message='.$this->dbObj->Param($message).
					   ' WHERE message_id='.$this->dbObj->Param($message_id);
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($message, $message_id));
				//raise user error... fatal
				if (!$rs)
				    trigger_db_error($this->dbObj);

			}

		/**
		 * FriendHandler::updateNewRequestCount()
		 *
		 * @param integer $user_id
		 * @return
		 */
		public function updateNewRequestCount($user_id = 0)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET new_requests = new_requests + 1, new_mails = new_mails + 1 WHERE user_id = '.$this->dbObj->Param($user_id);
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($user_id));
				//raise user error... fatal
				if (!$rs)
				    trigger_db_error($this->dbObj);
			}

		/**
		 * FriendHandler::updateNewMailCount()
		 *
		 * @param integer $user_id
		 * @return
		 */
		public function updateNewMailCount($user_id = 0)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET new_mails = new_mails + 1 WHERE user_id = '.$this->dbObj->Param($user_id);
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($user_id));
				//raise user error... fatal
				if (!$rs)
				    trigger_db_error($this->dbObj);
			}

		/**
		 * FriendHandler::_mergeTemplateVariablesWithTemplateString()
		 *
		 * @param string $template_string
		 * @param array $template_variables
		 * @return
		 */
		private function _mergeTemplateVariablesWithTemplateString($template_string='', $template_variables=array())
			{
				$clearedText = $template_string;
				if ($template_variables)
				    {
				        foreach($template_variables as $key=>$value)
							{
								$replaceString = $key;
								$clearedText = str_replace($replaceString, $value, $clearedText);
							}
				    }
				return $clearedText;
			}

		/**
		 * FriendHandler::_replaceConfigVariables()
		 *
		 * @param string $template
		 * @param array $currentVariables
		 * @param array $configVariables
		 * @return
		 */
		private function _replaceConfigVariables($template='', $currentVariables=array(), $configVariables=array())
			{
				$clearedText = $template;
				$clearedText = $this->_mergeTemplateVariablesWithTemplateString($clearedText, $currentVariables);
				$clearedText = $this->_mergeTemplateVariablesWithTemplateString($clearedText, $this->_defaultTemplateVariables);
				$clearedText = $this->_mergeTemplateVariablesWithTemplateString($clearedText, $configVariables);
				return $clearedText;
			}

		/**
		 * FriendHandler::mergeTemplageVariables()
		 *
		 * @param string $template
		 * @param array $currentVariables
		 * @param array $configVariables
		 * @return
		 */
		public function mergeTemplageVariables($template='', $currentVariables=array(), $configVariables=array())
			{
				return $this->_replaceConfigVariables($template, $currentVariables, $configVariables);
			}

		/**
		 * FriendHandler::sendFriendRequestToThisEmailId()
		 *
		 * @param string $friend_email
		 * @param string $friend_name
		 * @param integer $from_user_id
		 * @return
		 */
		public function sendFriendRequestToThisEmailId($friend_email='', $friend_name='' , $from_user_id=0)
			{
				if ($from_user_id)
				    {
				        $this->setOwnerId($from_user_id);
				    }
				$this->setFriendDetailsWithEmail($friend_email);
				if ($this->isFriendIsAMember())
				    {
						$this->sendFriendRequestMessage('');
				     	$this->_sendInvitationEmailForMember();
				    }
				else
					{
						$this->_sendInvitationEmailForNonMember($friend_email, $friend_name);
					}
			}

		/**
		 * FriendHandler::_sendInvitationEmailForMember()
		 *
		 * @return
		 */
		private function _sendInvitationEmailForMember()
			{
				$subjectTemplate = $this->LANG['invite_friend_subject'];
				$messageTemplate = $this->LANG['invite_friend_content'];
				$subjectVariables = $messageVariables = array();

				$ownerId = $this->getOwnerId();
				$ownerName = $this->ownerDetails['user_name'];

				$friendName = $this->friendDetails['user_name'];
				$email = $this->friendDetails['email'];

				$previousInvitationDetails = $this->getInvitationDetailsForThisEmailIfAny($email);
				$invitationId = 0;
				if ($previousInvitationDetails)
				    {
				        $invitationCode = $previousInvitationDetails['invitation_code'];
						$invitationId = $previousInvitationDetails['invitation_id'];
				    }
				else
					{
						$invitationCode = $this->generateInvitationCode($email);
					}

				$blockMemberLink = getMemberReferrerUrl(getUrl('memberblock'));

				$friendLink = getMemberReferrerUrl(getUrl('mail'));
				$friendLink = $friendLink;

				$blockMemberLink = $blockMemberLink.'&block_id='.$ownerId;
				$blockMemberLink = $blockMemberLink;
				$subjectVariables['VAR_USER_NAME'] = $ownerName;
				$subjectVariables['VAR_SITE_NAME']  = $this->CFG['site']['name'];
				$messageVariables['VAR_USER_NAME'] = $ownerName;
				$messageVariables['VAR_FRIEND_NAME'] = $friendName;
				$messageVariables['VAR_LINK'] = $friendLink;
				$messageVariables['VAR_BLOCK_LINK']  = $blockMemberLink;
				$messageVariables['VAR_SITE_NAME']  = $this->CFG['site']['name'];
				$messageVariables['VAR_PERSONAL_MESSAGE']  = isset($this->fields_arr['personal_message'])?$this->fields_arr['personal_message']:'';
				$subject = $this->_replaceConfigVariables($subjectTemplate, $subjectVariables);
				$message = $this->_replaceConfigVariables($messageTemplate, $messageVariables);
				$mailSent = $this->_sendEmail($email, $subject, $message);
				if ($mailSent)
				    {
				        $this->updateInvitationDetails($email, $invitationCode, $invitationId);
				    }
			}

		/**
		 * FriendHandler::_sendInvitationEmailForNonMember()
		 *
		 * @param string $email
		 * @param string $friend_name
		 * @return
		 */
		private function _sendInvitationEmailForNonMember($email='', $friend_name='')
			{
				$subjectTemplate = $this->LANG['invite_friend_subject'];
				$messageTemplate = $this->LANG['invite_friend_content'];
				$subjectVariables = $messageVariables = array();
				$ownerId = $this->getOwnerId();
				$ownerName = $this->ownerDetails['user_name'];

				$friendName = (empty($friend_name))?$email:$friend_name;
				$previousInvitationDetails = $this->getInvitationDetailsForThisEmailIfAny($email);
				$invitationId = 0;
				if ($previousInvitationDetails)
				    {
				        $invitationCode = $previousInvitationDetails['invitation_code'];
						$invitationId = $previousInvitationDetails['invitation_id'];
				    }
				else
					{
						$invitationCode = $this->generateInvitationCode($email);
					}

				$signupUrl = getMemberReferrerUrl(getUrl('signup','','','root'));

				$blockMemberLink = getMemberReferrerUrl(getUrl('memberblock'));
				$friendLink = $signupUrl.'&icode='.$invitationCode.'&amp;id='.$this->CFG['user']['user_id'];
				$friendLink = $friendLink;

				$blockMemberLink = $blockMemberLink.'&block_id='.$ownerId.'&invite_code='.$invitationCode;
				$blockMemberLink = $blockMemberLink;

				$subjectVariables['VAR_USER_NAME'] = $ownerName;

				$messageVariables['VAR_USER_NAME'] = $ownerName;
				$messageVariables['VAR_FRIEND_NAME'] = $friendName;
				$messageVariables['VAR_LINK'] = $friendLink;
				$messageVariables['VAR_BLOCK_LINK']  = $blockMemberLink;
				$messageVariables['VAR_PERSONAL_MESSAGE']  = isset($this->fields_arr['personal_message'])?$this->fields_arr['personal_message']:'';
				$subject = $this->_replaceConfigVariables($subjectTemplate, $subjectVariables);
				$message = $this->_replaceConfigVariables($messageTemplate, $messageVariables);
				$mailSent = $this->_sendEmail($email, $subject, $message);
				if ($mailSent)
				    {
				        $this->updateInvitationDetails($email, $invitationCode, $invitationId);
				    }
			}

		/**
		 * FriendHandler::getInvitationDetailsForThisEmailIfAny()
		 *
		 * @param string $email
		 * @return
		 */
		public function getInvitationDetailsForThisEmailIfAny($email='')
			{
				$email_encoded = urlencode($email);
				if (isset($this->_invitationDetails[$email_encoded]) AND $this->_invitationDetails)
				    {
				      	$invitationDetails = array();
						$invitationDetails['invitation_code'] = $this->_invitationDetails['invitation_code'];
						$invitationDetails['invitation_id'] = $this->_invitationDetails['invitation_id'];
						return $invitationDetails;
				    }

				$ownerId = $this->getOwnerId();
				$sql = 'SELECT invitation_code, invitation_id FROM '.$this->CFG['db']['tbl']['users_invitation'].
					   ' WHERE user_id = '.$this->dbObj->Param($ownerId).' AND email='.$this->dbObj->Param($email).' LIMIT 0,1';
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($ownerId, $email));
				//raise user error... fatal
				if (!$rs)
				trigger_db_error($this->dbObj);
				$details = array();
				if ($rs->PO_RecordCount())
					{
						$details = $rs->FetchRow();
					}
				return $details;
			}

		/**
		 * FriendHandler::updateInvitationDetails()
		 *
		 * @param string $email
		 * @param string $invitation_code
		 * @param integer $invitation_id
		 * @param string $is_member
		 * @return
		 */
		public function updateInvitationDetails($email='', $invitation_code='', $invitation_id=0, $is_member='0')
			{
				if (!$invitation_id)
				    {
						$ownerId = $this->getOwnerId();
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['users_invitation'].
							   ' SET user_id='.$this->dbObj->Param($ownerId).','.
							   ' invitation_code='.$this->dbObj->Param($invitation_code).','.
							   ' email='.$this->dbObj->Param($email).','.
							   ' attempts = 1,'.
							   ' for_friend = \'1\','.
							   ' is_member='.$this->dbObj->Param($this->dbObj->Param($is_member)).','.
							   ' date_added = NOW()';
						// prepare sql
						$stmt = $this->dbObj->Prepare($sql);
						// execute sql
						$rs = $this->dbObj->Execute($stmt, array($ownerId, $invitation_code, $email, $is_member));
						//raise user error... fatal
						if (!$rs)
						    trigger_db_error($this->dbObj);
				    }
				else
					{
				        $sql = 'UPDATE '.$this->CFG['db']['tbl']['users_invitation'].' SET attempts = attempts + 1,for_friend=\'1\' WHERE invitation_id='.$this->dbObj->Param($invitation_id);
						// prepare sql
						$stmt = $this->dbObj->Prepare($sql);
						// execute sql
						$rs = $this->dbObj->Execute($stmt, array($invitation_id));
						//raise user error... fatal
						if (!$rs)
						    trigger_db_error($this->dbObj);
					}
			}

		/**
		 * FriendHandler::generateInvitationCode()
		 *
		 * @param string $email
		 * @return
		 */
		public function generateInvitationCode($email='')
			{
				$ownerId = $this->getOwnerId();
				$ownerName = $this->ownerDetails['user_name'];
				$sql = 'SELECT SUBSTRING(HEX(ENCODE('.$this->dbObj->Param($ownerName).', '.$this->dbObj->Param($email).')), 1, 16) as keyword';

				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($ownerName, $email));
				//raise user error... fatal
				if (!$rs)
				trigger_db_error($this->dbObj);
				$keyword =  null;
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$keyword = $row['keyword'];
				    }

				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['users_invitation'].' WHERE user_id='.$this->dbObj->Param($ownerId).' AND invitation_code='.$this->dbObj->Param($keyword).' LIMIT 0,1';
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($ownerId, $keyword));
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);
				$row = array();
					if ($rs->PO_RecordCount())
						{
					        return $this->generateInvitationCode($email.date('dmyhis'));
					    }
				// done!
				return $keyword;
			}

		/**
		 * FriendHandler::_sendEmail()
		 *
		 * @param string $reciever_email
		 * @param string $subject
		 * @param string $message
		 * @param mixed $html_subject
		 * @param mixed $html_content
		 * @return
		 */
		public function _sendEmail($reciever_email='', $subject='', $message='', $html_subject = false, $html_content = true)
			{
				$this->buildEmailTemplate($subject, $message, false, true);

				$sender_name  = $this->ownerDetails['user_name'];
				//$sender_email = $this->ownerDetails['email'];
				$sender_email = $this->CFG['site']['noreply_email'];

				$EasySwift = new EasySwift($this->getSwiftConnection());
				$EasySwift->flush();

				$EasySwift->addPart($this->getEmailContent(true), "text/html");

				$from_address = $sender_name.'<'.$sender_email.'>';
				return $EasySwift->send($reciever_email, $from_address, $this->getEmailSubject(), $message);
			}

		/**
		 * FriendHandler::remindFriendInvitaion()
		 *
		 * @param integer $invitation_id
		 * @return
		 */
		public function remindFriendInvitaion($invitation_id = 0)
			{
				$ownerId = $this->getOwnerId();
				$sql = 'SELECT email,invitation_code FROM '.$this->CFG['db']['tbl']['users_invitation'].' WHERE invitation_id='.$this->dbObj->Param($invitation_id).' AND user_id='.$this->dbObj->Param($ownerId);
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($invitation_id, $ownerId));
				//raise user error... fatal
				if (!$rs)
				trigger_db_error($this->dbObj);
				$details = array();
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$email = $row['email'];
						$email_encoded = urlencode($email);
						$this->sendFriendRequestToThisEmailId($row['email']);
						$this->_invitationDetails[$email_encoded]['invitation_code'] = $row['invitation_code'];
						$this->_invitationDetails[$email_encoded]['invitation_id'] = $invitation_id;
				    }
			}

		/**
		 * FriendHandler::addNewFriendDetails()
		 *
		 * @return
		 */
		public function addNewFriendDetails()
			{
				$ownerId = $this->getFormField('owner');
				$friendId = $this->getFormField('friend');
				if(!($friendId and $ownerId))
					return;

				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['friends_list'].' WHERE'.
						' (owner_id = '.$this->dbObj->Param($ownerId).' AND friend_id = '.$this->dbObj->Param($friendId).') OR'.
						' (owner_id = '.$this->dbObj->Param($friendId).' AND friend_id = '.$this->dbObj->Param($ownerId).')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($ownerId, $friendId, $friendId, $ownerId));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					return;

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['friends_list'].
					   ' SET '.
					   ' owner_id = '.$this->dbObj->Param($ownerId).','.
					   ' friend_id = '.$this->dbObj->Param($friendId);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($ownerId, $friendId));
				if (!$rs)
				    trigger_db_error($this->dbObj);

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['friends_list'].
					   ' SET '.
					   ' owner_id = '.$this->dbObj->Param($ownerId).','.
					   ' friend_id = '.$this->dbObj->Param($friendId);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($friendId, $ownerId));
				if (!$rs)
				    trigger_db_error($this->dbObj);

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET total_friends=total_friends+1 WHERE user_id IN ('.$this->dbObj->Param($ownerId).','.$this->dbObj->Param($friendId).')';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($ownerId, $friendId));
				if (!$rs)
				    trigger_db_error($this->dbObj);

				if(isset($_SESSION['user']['total_friends']))
					$_SESSION['user']['total_friends'] = $_SESSION['user']['total_friends'] + 1;
			}

		/**
		 * FriendHandler::sendAcceptedMessage()
		 *
		 * @return
		 */
		public function sendAcceptedMessage()
			{
				$subjectTemplate = $this->LANG['accept_friend_subject'];
				$messageTemplate = $this->LANG['accept_friend_content'];

				$ownerId = $this->getOwnerId();
				$friendId = $this->getFriendId();

				$friendName = $this->friendDetails['user_name'];
				$ownerName = $this->ownerDetails['user_name'];
				$subjectVariables = $messageVariables = array();

				$subjectVariables['VAR_USER_NAME'] = $ownerName;
				$ownerProfileLink = getMemberProfileUrl($ownerId, $ownerName);
				$ownerProfileLink = '<a href="'.$ownerProfileLink.'" target="_blank">'.$ownerName.'</a>';
				$messageVariables['VAR_USER_NAME'] = $ownerName;
				$messageVariables['VAR_FRIEND_NAME'] = $friendName;
				$messageVariables['VAR_USER_PROFILE_LINK'] = $ownerProfileLink;

				$subject = $this->mergeTemplageVariables($subjectTemplate, $subjectVariables);
				$message = $this->mergeTemplageVariables($messageTemplate, $messageVariables);

				$messageDetails = $this->sendInternalMessage($ownerId, $friendId, $subject, $message);
				$this->updateNewMailCount($friendId);
			}

		/**
		 * FriendHandler::sendDeclinedMessage()
		 *
		 * @return
		 */
		public function sendDeclinedMessage()
			{
				$subjectTemplate = $this->LANG['decline_friend_subject'];
				$messageTemplate = $this->LANG['decline_friend_content'];

				$ownerId = $this->getOwnerId();
				$friendId = $this->getFriendId();

				$friendName = $this->friendDetails['user_name'];
				$ownerName = $this->ownerDetails['user_name'];
				$subjectVariables = $messageVariables = array();

				$subjectVariables['VAR_USER_NAME'] = $ownerName;
				$ownerProfileLink = getMemberProfileUrl($ownerId, $ownerName);
				$ownerProfileLink = '<a href="'.$ownerProfileLink.'" target="_blank">'.$ownerName.'</a>';
				$messageVariables['VAR_USER_NAME'] = $ownerName;
				$messageVariables['VAR_FRIEND_NAME'] = $friendName;
				$messageVariables['VAR_USER_PROFILE_LINK'] = $ownerProfileLink;

				$subject = $this->mergeTemplageVariables($subjectTemplate, $subjectVariables);
				$message = $this->mergeTemplageVariables($messageTemplate, $messageVariables);

				$messageDetails = $this->sendInternalMessage($ownerId, $friendId, $subject, $message);
				$this->updateNewMailCount($friendId);
			}

		/**
		 * FriendHandler::sendMailCopytoMyEmailId()
		 *
		 * @param string $my_email
		 * @param integer $from_user_id
		 * @return
		 */
		public function sendMailCopytoMyEmailId($my_email='',$from_user_id=0)
			{
				$this->CopyForMe = true;
				if ($from_user_id)
				    {
						$this->setOwnerId($my_email);
				    }
				$this->setFriendDetailsWithEmail($my_email);
				if ($this->isFriendIsAMember())
				    {
						$this->_sendInvitationEmailForMember($my_email);
				    }
				else
					{
						$this->_sendInvitationEmailForNonMember($my_email);
					}
			}
	}
?>
