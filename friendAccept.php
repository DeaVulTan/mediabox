<?php
/**
 * Accept as Friend from Inbox.
 *
 * @category	rayzz
 * @package		MailInboxFormHandler
 **/
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/members/friendAdd.php';
$CFG['mods']['include_files'][] = 'common/classes/class_GeneralActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FriendHandler.lib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//--------------class FriendAcceptor--------------->>>//
/**
 * FriendAcceptor
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class FriendAcceptor extends FriendHandler
	{
		/**
		 * FriendAcceptor::deleteMessage()
		 *
		 * @return void
		 */
		public function deleteMessage()
			{
				$infoId = $this->getFormField('messageInfoId');
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['messages_info'].
						' SET to_delete=\'Trash\''.
						' WHERE info_id='.$this->dbObj->Param($infoId);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($infoId));
				if (!$rs)
				    trigger_db_error($this->dbObj);
			}

		/**
		 * FriendAcceptor::chkIsAlreadyFriend()
		 *
		 * @return boolean
		 */
		public function chkIsAlreadyFriend()
			{
				$ownerId = $this->getFormField('owner');
				$friendId = $this->getFormField('friend');

				if($friendId == 0 OR $ownerId == 0 OR $friendId == $this->CFG['user']['user_id'] OR $ownerId == $friendId)
					return true;

				$sql = 	'SELECT 1 FROM '.$this->CFG['db']['tbl']['friends_list'].
						' WHERE owner_id='.$this->dbObj->Param($ownerId).
						' AND friend_id='.$this->dbObj->Param($friendId).
					    ' LIMIT 0,1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($ownerId, $friendId));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$isAlreadyFriend = false;
				if ($rs->PO_RecordCount())
					{
						$isAlreadyFriend = true;
				    }
				return $isAlreadyFriend;
			}

		/**
		 * FriendAcceptor::addNewFriendDetails()
		 *
		 * @return void
		 */
		public function addNewFriendDetails()
			{
				$ownerId = $this->getFormField('owner');
				$friendId = $this->getFormField('friend');

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['friends_list'].
					   ' SET owner_id = '.$this->dbObj->Param($ownerId).
					   ', friend_id = '.$this->dbObj->Param($friendId);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($ownerId, $friendId));
				if (!$rs)
				    trigger_db_error($this->dbObj);

				$this->content_id = $this->dbObj->Insert_ID();

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['friends_list'].
					   ' SET owner_id = '.$this->dbObj->Param($friendId).
					   ', friend_id = '.$this->dbObj->Param($ownerId);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($friendId, $ownerId));
				if (!$rs)
				    trigger_db_error($this->dbObj);

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
						' SET total_friends=total_friends+1 WHERE'.
						' user_id IN ('.$this->dbObj->Param($ownerId).', '.$this->dbObj->Param($friendId).')';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($ownerId, $friendId));
				if (!$rs)
				    trigger_db_error($this->dbObj);

				$_SESSION['user']['total_friends'] = $_SESSION['user']['total_friends'] + 1;

				//To Add BeFriended Log
				$this->addBeFriendedLog();
			}

		/**
		 * FriendAcceptor::addBeFriendedLog()
		 *
		 * @return void
		 */
		public function addBeFriendedLog()
			{
				$ownerId = $this->getFormField('owner');
				$friendId = $this->getFormField('friend');

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['be_friended_log'].
					   ' SET owner_id = '.$this->dbObj->Param($ownerId).
					   ', friend_id = '.$this->dbObj->Param($friendId).
					   ', date_added = NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($ownerId, $friendId));
				if (!$rs)
				    trigger_db_error($this->dbObj);
			}
	}
//<<<<<<<--------------class FriendAcceptor---------------//

//--------------------Code begins-------------->>>>>//
$friend = new FriendAcceptor();
if($CFG['admin']['show_recent_activities'])
	{
		$GeneralActivity = new GeneralActivityHandler();
	}

$friend->setFormField('owner', $CFG['user']['user_id']);
$friend->setFormField('friend', 0);
$friend->setFormField('messageInfoId', 0);

if ($friend->isFormPOSTed($_POST, 'friend'))
	{
	   	$friend->sanitizeFormInputs($_REQUEST);
		$friend->setFriendId($friend->getFormField('friend'));
		$friend->setOwnerId($friend->getFormField('owner'));

		if (!$friend->chkIsAlreadyFriend())
    		{
				if ($friend->isFormPOSTed($_POST, 'acceptSubmit'))
				    {
						$_SESSION['friend_request_accepted_message'] = $LANG['friend_request_accepted_message'];
				        $friend->removeFromFriendSuggestions();
						$friend->addNewFriendDetails();
						$friend->sendAcceptedMessage();

						//Add Activity
						if($CFG['admin']['show_recent_activities'])
							{
								$GeneralActivity->activity_arr['action_key'] = 'be_friended';
								$GeneralActivity->activity_arr['owner_id'] = $friend->getFormField('owner');
								$GeneralActivity->activity_arr['friend_id'] = $friend->getFormField('friend');
								$GeneralActivity->activity_arr['content_id'] = $friend->content_id;
								$GeneralActivity->addActivity($GeneralActivity->activity_arr);
							}
				    }
				if ($friend->isFormPOSTed($_POST, 'declineSubmit'))
				    {
						$_SESSION['friend_request_accepted_message'] = $LANG['friend_request_accepted_declined'];
				        $friend->sanitizeFormInputs($_POST);
						$friend->sendDeclinedMessage();
				    }
			}
	}
$friend->deleteMessage();
$mailBoxUrl = getUrl('mail', '?folder=inbox', 'inbox/', 'members');
Redirect2URL($mailBoxUrl);
?>