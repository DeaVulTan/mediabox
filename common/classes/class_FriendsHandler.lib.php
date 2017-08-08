<?php
/**
 * Class to handle the form fields
 *
 * This is having class FriendsHandler to handle the internal mails.
 *
 * PHP version 5.0
 *
 * @category	Discuzz
 * @package		FriendsHandler
 * @author		senthil_52ag05
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id : $
 * @since 		2008-11-02
 */

if(class_exists('DiscussionHandler'))
	{
		$parent_class = 3;
	}
elseif(class_exists('ListRecordsHandler'))
	{
		$parent_class = 2;
	}
else
	{
		$parent_class = 1;
	}

switch($parent_class)
	{
		case 3:
			class Handlers1 extends DiscussionHandler{}
			break;
		case 2:
			class Handlers1 extends ListRecordsHandler{}
			break;
		case 1:
		default:
			class Handlers1 extends FormHandler{}
			break;
	}

class FriendsHandler extends Handlers1
	{

		/**
		 * FriendsHandler::getFriendDetails()
		 *
		 * @param integer $id1
		 * @param integer $id2
		 * @return
		 */
		public function getFriendDetails($id1=0, $id2=0)
			{
				$sql = 'SELECT request_id, request_from, status as req_status FROM '.$this->CFG['db']['tbl']['friends_requests'].
						' WHERE (request_from ='.$this->dbObj->Param('from_id').' AND request_to ='.$this->dbObj->Param('to_id').')'.
						' OR (request_from ='.$this->dbObj->Param('from_id').' AND request_to ='.$this->dbObj->Param('to_id').')';


				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($id1, $id2, $id2, $id1));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				$friends_details = array('request_id'=>'', 'request_from'=>'', 'req_status'=>'');
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$friends_details = $row;
					}

				return $friends_details;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function isValidUsers($from_id, $to_id)
			{
				//Check from id or to id is currect user
				if ($this->CFG['user']['user_id'] != $from_id AND $this->CFG['user']['user_id'] != $to_id)
					return false;

				//Check from id is active
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE '.getUserTableField('user_id').'='.$this->dbObj->Param($from_id).' AND '.getUserTableField('user_status').'=\'Ok\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($from_id));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				if (!$rs->PO_RecordCount())
					return false;

				//Check from id is active
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE '.getUserTableField('user_id').'='.$this->dbObj->Param($to_id).' AND '.getUserTableField('user_status').'=\'Ok\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($to_id));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				if (!$rs->PO_RecordCount())
					return false;

				return true;
			}

		/**
		 * FriendsHandler::insertFriendRequest()
		 *
		 * @param integer $from_id
		 * @param integer $to_id
		 * @return
		 */
		public function insertFriendRequest($from_id=0, $to_id=0)
			{
				if (!$this->isValidUsers($from_id, $to_id))
					return ;

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['friends_requests'].
						' SET request_from ='.$this->dbObj->Param('from_id').
						' ,request_to ='.$this->dbObj->Param('to_id').
						' ,date = NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($from_id, $to_id));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				$friend_request_id = $this->dbObj->Insert_ID();
				//Add Activity
				if($this->CFG['admin']['index']['activity']['show'])
					{
						$activity_arr['action_key'] = 'request_added';
						$activity_arr['owner_id'] = $to_id;
						$activity_arr['friend_id'] = $from_id;
						$activity_arr['content_id'] = $friend_request_id;
						$this->generalActivityObj->addActivity($activity_arr);
					}
				return true;
			}
		/**
		 * FriendsHandler::ifRequestExists()
		 *
		 * @param integer $from_id
		 * @param integer $to_id
		 * @return
		 */
		public function ifRequestExists($from_id=0, $to_id=0, $status = '')
			{
				$stmt_arr[] = $from_id;
				$stmt_arr[] = $to_id;

				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['friends_requests'].
						' WHERE (request_from ='.$this->dbObj->Param('from_id').
						' AND request_to ='.$this->dbObj->Param('to_id').')';

				if($status == 'Pending')
					{
						$sql.=' AND status='.$this->dbObj->Param('status');
						$stmt_arr[] = $status;
					}
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $stmt_arr);
				if (!$rs)
					    trigger_db_error($this->dbObj);
				return $rs->PO_RecordCount();
			}

		/**
		 * FriendsHandler::deleteFriendRequest()
		 *
		 * @param integer $from_id
		 * @param integer $to_id
		 * @param string $status
		 * @return
		 */
		public function deleteFriendRequest($from_id=0, $to_id=0, $status = '')
			{
				$stmt_arr[] = $from_id;
				$stmt_arr[] = $to_id;

				if (!$this->isValidUsers($from_id, $to_id))
					return ;

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['friends_requests'].
						' WHERE ((request_from ='.$this->dbObj->Param('from_id').
						' AND request_to ='.$this->dbObj->Param('to_id').')';

				if($status == 'Accepted')
					{
						$sql .= ' OR (request_from ='.$this->dbObj->Param('from_id').' AND request_to ='.$this->dbObj->Param('to_id').')';
						$stmt_arr[] = $to_id;
						$stmt_arr[] = $from_id;
					}

				$stmt_arr[] = $status;
				$sql .= ') AND status ='.$this->dbObj->Param('status');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $stmt_arr);
				if (!$rs)
					    trigger_db_error($this->dbObj);
				//Add Activity
				if($this->dbObj->Affected_Rows() AND $this->CFG['admin']['index']['activity']['show'])
					{
						$activity_arr['action_key'] = 'request_removed';
						$activity_arr['owner_id'] = $to_id;
						$activity_arr['friend_id'] = $from_id;
						$activity_arr['content_id'] = $to_id;
						$this->generalActivityObj->addActivity($activity_arr);
					}
			}
		/**
		 * FriendsHandler::removeSubscribed()
		 *
		 * @param integer $from_id
		 * @param integer $to_id
		 * @return
		 */
		public function removeSubscribed($from_id, $to_id)
			{
				$stmt_arr[] = $from_id;
				$stmt_arr[] = $to_id;

				if (!$this->isValidUsers($from_id, $to_id))
					return ;

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['user_bookmarked'].
						' WHERE user_id ='.$this->dbObj->Param('from_id').
						' AND content_id ='.$this->dbObj->Param('to_id').' AND content_type=\'User\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $stmt_arr);
				if (!$rs)
					    trigger_db_error($this->dbObj);

				//Add Activity
				if($this->CFG['admin']['index']['activity']['show'])
					{
						$activity_arr['action_key'] = 'unsubscribed';
						$activity_arr['owner_id'] = $to_id;
						$activity_arr['actor_id'] = $from_id;
						$activity_arr['content_id'] = $to_id;
						$this->generalActivityObj->addActivity($activity_arr);
					}
			}

		/**
		 * FriendsHandler::updateFriendRequest()
		 *
		 * @param integer $from_id
		 * @param integer $to_id
		 * @param string $status
		 * @return
		 */
		public function updateFriendRequest($from_id=0, $to_id=0, $status = '')
			{
				if (!$this->isValidUsers($from_id, $to_id))
					return ;

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['friends_requests'].
						' SET status = '.$this->dbObj->Param('status').' WHERE request_from ='.$this->dbObj->Param('from_id').
						' AND request_to ='.$this->dbObj->Param('to_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($status, $from_id, $to_id));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				//Add Activity
				if($this->CFG['admin']['index']['activity']['show'] && $status != '')
					{
						$activity_arr['action_key'] = 'friend_'.strtolower($status);
						$activity_arr['owner_id'] = $from_id;
						$activity_arr['friend_id'] = $to_id;
						$activity_arr['content_id'] = $to_id;
						$this->generalActivityObj->addActivity($activity_arr);
					}
			}

		/**
		 * FriendsHandler::removeBlocked()
		 *S
		 * @param mixed $removeBy
		 * @param mixed $toBeRemoved
		 * @return
		 */
		public function removeBlocked($removeBy, $toBeRemoved)
			{
				if (!$this->isValidUsers($removeBy, $toBeRemoved))
					return ;

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['block_members'].
						' WHERE user_id = '.$this->dbObj->Param('user_id').
						' AND block_id ='.$this->dbObj->Param('blocked_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($removeBy, $toBeRemoved));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				//Add Activity
				if($this->CFG['admin']['index']['activity']['show'])
					{
						$activity_arr['action_key'] = 'remove_blocked';
						$activity_arr['owner_id'] = $toBeRemoved;
						$activity_arr['blocker_id'] = $removeBy;
						$activity_arr['content_id'] = $toBeRemoved;
						$this->generalActivityObj->addActivity($activity_arr);
					}
			}

		/**
		 * FriendsHandler::isAmBlocked()
		 *
		 * @param mixed $blockedBy
		 * @return
		 */
		public function isAmBlocked($blockedBy)
			{
				$sql = 'SELECT * FROM '.$this->CFG['db']['tbl']['block_members'].
						' WHERE (user_id = '.$this->dbObj->Param('user_id').' AND block_id ='.$this->dbObj->Param('blocked_id').')'.
						' OR (user_id = '.$this->dbObj->Param('blocked_id').' AND block_id ='.$this->dbObj->Param('user_id').')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($blockedBy, $this->CFG['user']['user_id'], $this->CFG['user']['user_id'], $blockedBy));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
					return true;

				return false;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function isBlockedByMe($blockedBy)
			{
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['user_blocked'].
						' WHERE user_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
						' AND block_id ='.$this->dbObj->Param($blockedBy);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $blockedBy));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
					return true;

				return false;
			}
	}
?>