<?php
//-------------------------class FriendsListHandler ----------------------->>>
/**
 * FriendsListHandler
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class FriendsListHandler extends ListRecordsHandler
	{
		public $linkFieldsArray = array();
		private $isValidUser = false;
		private $_isCurrentUser = false;

		/**
		 * FriendsListHandler::buildConditionQuery()
		 *
		 * @return void
		 */
		public function buildConditionQuery()
			{
				$user_id = $this->getFormField('user_id');
				$this->sql_condition =  '(friends_tbl.owner_id='.$user_id.') AND (users_tbl.user_id = friends_tbl.friend_id) AND (users_tbl.user_id!='.$user_id.' AND usr_status=\'Ok\')';
			}

		/**
		 * FriendsListHandler::buildConditionTopQuery()
		 *
		 * @return void
		 */
		public function buildConditionTopQuery()
			{
				$user_id = $this->getFormField('user_id');
				$this->sql_condition =  '(friends_tbl.user_id='.$user_id.' OR friends_tbl.friend_id='.$user_id.') AND (users_tbl.user_id = friends_tbl.friend_id OR users_tbl.user_id=friends_tbl.user_id) AND users_tbl.user_id!='.$user_id;
			}

		/**
		 * FriendsListHandler::displayMyFriends()
		 *
		 * @return void
		 */
		public function displayMyFriends()
			{
				global $smartyObj;
				$displayMyFriends_arr = array();

				$usersPerRow = 5;
				$count = 0;
				$found = false;

				$displayMyFriends_arr['row'] = array();
				$inc = 0;
				while($row = $this->fetchResultRecord())
				    {
						$displayMyFriends_arr['row'][$inc]['icon'] = getMemberAvatarDetails($row['user_id']);
						$online = ($row['logged_in'])?$this->CFG['admin']['members']['online_anchor_attributes']:$this->CFG['admin']['members']['offline_anchor_attributes'];
						$online = str_replace('{online_status}', $this->LANG['online_status'], $online);
						$displayMyFriends_arr['row'][$inc]['online'] = $online;

						$found = true;
						$joined = 0;
						$displayMyFriends_arr['row'][$inc]['friendProfileUrl'] = getMemberProfileUrl($row['friend_id'], $row['friend_name']);
						$displayMyFriends_arr['row'][$inc]['add_top_friend_confirm_msg'] = str_replace('VAR_USER_NAME', $row['friend_name'], $this->LANG['viewfriends_confirm_add_topfriend']);
						$displayMyFriends_arr['row'][$inc]['delete_top_friend_confirm_msg'] = str_replace('VAR_USER_NAME', $row['friend_name'], $this->LANG['viewfriends_confirm_delete_topfriend']);
						$displayMyFriends_arr['row'][$inc]['delete_friend_confirm_msg'] = str_replace('VAR_USER_NAME', $row['friend_name'], $this->LANG['viewfriends_confirm_delete_friend']);
						$displayMyFriends_arr['row'][$inc]['open_tr'] = false;
						if ($count%$usersPerRow==0)
						    {
						    	$displayMyFriends_arr['row'][$inc]['open_tr'] = true;
						    }
						$displayMyFriends_arr['row'][$inc]['sendMessageUrl'] = getUrl('mailcompose', '?mcomp='.$row['friend_name'], '?mcomp='.$row['friend_name'], 'members');
						$displayMyFriends_arr['row'][$inc]['record'] = $row;
						$displayMyFriends_arr['row'][$inc]['anchor'] = 'dAlt_'.$row['friend_id'];
						if ($this->isCurrentUser())
						    {
						    	$sql = 'SELECT user_id, friend_id FROM '.$this->CFG['db']['tbl']['top_friends'].
						    			' WHERE user_id='.$this->CFG['user']['user_id'].
										' AND friend_id='.$row['friend_id'];
						    	$stmt = $this->dbObj->Prepare($sql);
						    	$res = $this->dbObj->Execute($stmt);
						    	if (!$res)
						    		    trigger_db_error($this->dbObj);

						    	$result = $res->FetchRow();
						    	$displayMyFriends_arr['row'][$inc]['top_friends']['result'] = $result;
						    }

						$count++;
						$displayMyFriends_arr['row'][$inc]['end_tr'] = false;
						if ($count%$usersPerRow==0)
						    {
								$count = 0;
								$displayMyFriends_arr['row'][$inc]['end_tr'] = true;
						    }
						$inc++;
				    } // while
				$displayMyFriends_arr['extra_td_tr'] = false;
				if ($found and $count and $count<$usersPerRow)
				    {
						$displayMyFriends_arr['extra_td_tr'] = true;
						$displayMyFriends_arr['records_per_row'] = $usersPerRow - $count;
					}
				$smartyObj->assign('displayMyFriends_arr', $displayMyFriends_arr);
			}

		/**
		 * FriendsListHandler::hasAtleastOneFriend()
		 *
		 * @return boolean
		 */
		public function hasAtleastOneFriend()
			{
				$totalFriends = $this->getFormField('total_friends');
				return ($totalFriends > 0);
			}

		/**
		 * FriendsListHandler::isValidUserId()
		 *
		 * @return boolean
		 */
		public function isValidUserId()
			{
				return $this->isValidUser;
			}

		/**
		 * FriendsListHandler::validateUserId()
		 *
		 * @return boolean
		 */
		public function validateUserId()
			{
				$currentUserId = $this->getCurrentUserId();
				$sql = 'SELECT user_name,total_friends FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_id='.$this->dbObj->Param($currentUserId);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($currentUserId));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$return = false;
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$this->setFormField('user', $row['user_name']);
						$this->setFormField('total_friends', $row['total_friends']);
						$return = true;
						$this->isValidUser = true;
						$this->_isCurrentUser = (strcmp($this->getCurrentUserId(), $this->CFG['user']['user_id'])==0);
				    }
				return $return;
			}

		/**
		 * FriendsListHandler::validateUserName()
		 *
		 * @return void
		 */
		public function validateUserName()
			{
				$userName = $this->fields_arr['user'];
				$sql = 'SELECT user_id, total_friends FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_name='.$this->dbObj->Param($userName);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($userName));
				if (!$rs)
					trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$this->setFormField('user_id', $row['user_id']);
						$this->setFormField('total_friends', $row['total_friends']);
						$this->isValidUser = true;
						$this->_isCurrentUser = (strcmp($this->getCurrentUserId(), $this->CFG['user']['user_id'])==0);
					}
			}

		/**
		 * FriendsListHandler::buildSearchConditionQuery()
		 *
		 * @return void
		 */
		public function buildSearchConditionQuery()
			{
				$this->sql_condition .= ' ';
				if (!$this->isEmpty($this->fields_arr['uname']))
				    {
						$this->sql_condition .= 'AND users_tbl.user_name LIKE \'%'.addslashes($this->fields_arr['uname']).'%\' ';
						$this->linkFieldsArray[] = 'uname';
				    }
				if (!$this->isEmpty($this->fields_arr['email']))
				    {
						$this->sql_condition .= 'AND users_tbl.email LIKE \'%'.addslashes($this->fields_arr['email']).'%\' ';
						$this->linkFieldsArray[] = 'email';
				    }
				if (!$this->isEmpty($this->fields_arr['tagz']))
				    {
						$this->sql_condition .= 'AND '.getSearchRegularExpressionQueryModified($this->fields_arr['tagz'], 'users_tbl.profile_tags', '');
						//$this->sql_condition .= 'AND '.getSearchRegularExpressionQuery($this->fields_arr['tagz'], 'users_tbl.profile_tags', '');
						$this->linkFieldsArray[] = 'tagz';
				    }
			}

		/**
		 * FriendsListHandler::removeThisFriend()
		 *
		 * @param integer $friendship_id
		 * @return integer
		 */
		public function removeThisFriend($friendship_id = 0)
			{
				$sql = 'SELECT owner_id, friend_id'.
						' FROM '.$this->CFG['db']['tbl']['friends_list'].
						' WHERE id='.$this->dbObj->Param($friendship_id);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($friendship_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$removed = 0;
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$ownerId = $row['owner_id'];
						$friendId = $row['friend_id'];

						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['friends_list'].
								' WHERE id='.$this->dbObj->Param($friendship_id);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($friendship_id));
						if (!$rs)
						    trigger_db_error($this->dbObj);
						$removed = $this->dbObj->Affected_Rows();

						//Removing from friends relation table..!
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['friends_relation'].
								' WHERE friendship_id='.$this->dbObj->Param($friendship_id);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($friendship_id));
						if (!$rs)
						    trigger_db_error($this->dbObj);

						$sql = 'SELECT id, owner_id, friend_id'.
								' FROM '.$this->CFG['db']['tbl']['friends_list'].
								' WHERE owner_id = '.$this->dbObj->Param($friendId).
								' AND friend_id ='.$this->dbObj->Param($ownerId);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($friendId, $ownerId));
						if (!$rs)
							trigger_db_error($this->dbObj);

						if ($rs->PO_RecordCount())
							{
								$row = $rs->FetchRow();

								$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['friends_list'].
										' WHERE id='.$this->dbObj->Param($row['id']);
								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($row['id']));
								if (!$rs)
								    trigger_db_error($this->dbObj);
								$removed = $this->dbObj->Affected_Rows();

								//Removing from friends relation table..!
								$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['friends_relation'].
										' WHERE friendship_id='.$this->dbObj->Param($row['id']);
								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($row['id']));
								if (!$rs)
								    trigger_db_error($this->dbObj);
							}

						//updating friends count
						$this->resetFriendsCountForThisUser($ownerId);
						$this->resetFriendsCountForThisUser($friendId);
				    }
				return $removed;
			}

		/**
		 * FriendsListHandler::resetFriendsCountForThisUser()
		 *
		 * @param integer $user_id
		 * @return void
		 */
		public function resetFriendsCountForThisUser($user_id = 0)
			{
				if ($user_id > 0)
				    {
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
								' SET total_friends = (SELECT COUNT(id) AS cnt FROM '.$this->CFG['db']['tbl']['friends_list'].' WHERE owner_id='.$this->dbObj->Param($user_id).')'.
								' WHERE user_id = '.$this->dbObj->Param($user_id);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($user_id, $user_id));
						if (!$rs)
						    trigger_db_error($this->dbObj);
				    }
			}

		/**
		 * FriendsListHandler::isEmpty()
		 *
		 * @param mixed $value
		 * @return boolean
		 */
		public function isEmpty($value)
			{
				$is_not_empty = is_string($value)?trim($value)=='':empty($value);
				return $is_not_empty;
			}

		/**
		 * FriendsListHandler::getCurrentUserId()
		 *
		 * @return integer
		 */
		public function getCurrentUserId()
			{
				return $this->fields_arr['user_id'];
			}

		/**
		 * FriendsListHandler::getCurrentUserName()
		 *
		 * @return string
		 */
		public function getCurrentUserName()
			{
				return $this->fields_arr['user'];
			}

		/**
		 * FriendsListHandler::setCurrentUserId()
		 *
		 * @param integer $user_id
		 * @return void
		 */
		public function setCurrentUserId($user_id = 0)
			{
				$this->fields_arr['user_id'] = $user_id;
			}

		/**
		 * FriendsListHandler::isCurrentUser()
		 *
		 * @return boolean
		 */
		public function isCurrentUser()
			{
				return $this->_isCurrentUser;
			}

		/**
		 * FriendsListHandler::insertTopFriend()
		 *
		 * @param integer $friendId
		 * @return void
		 */
		public function insertTopFriend($friendId)
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['top_friends'].
						' SET user_id='.$this->dbObj->Param('user_id').
						', friend_id='.$this->dbObj->Param($friendId);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $friendId));
				if (!$rs)
					trigger_db_error($this->dbObj);
			}

		/**
		 * FriendsListHandler::deleteTopFriend()
		 *
		 * @param integer $friendId
		 * @return void
		 */
		public function deleteTopFriend($friendId)
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['top_friends'].
						' WHERE user_id='.$this->dbObj->Param('user_id').
						' AND friend_id='.$this->dbObj->Param($friendId);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $friendId));
				if (!$rs)
					trigger_db_error($this->dbObj);
			}

		/**
		 * FriendsListHandler::getTotalTopFriends()
		 *
		 * @return integer
		 */
		public function getTotalTopFriends()
			{
				$sql = 'SELECT COUNT(friend_id) as count FROM '.$this->CFG['db']['tbl']['top_friends'].
						' WHERE user_id='.$this->dbObj->Param($this->CFG['user']['user_id']);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				$row = $rs->FetchRow();
				return $row['count'];
			}

		/**
		 * FriendsListHandler::displayTopFriends()
		 *
		 * @return void
		 */
		public function displayTopFriends()
			{
				global $smartyObj;
				$displayTopFriends_arr = array();

				$sql = 'SELECT u.user_id, u.user_name, u.icon_id, u.icon_type, u.image_ext, u.logged_in, u.sex, t.friend_id'.
						' FROM '.$this->CFG['db']['tbl']['top_friends'].' as t LEFT JOIN '.$this->CFG['db']['tbl']['users'].' as u'.
						' ON u.user_id = t.friend_id, '.$this->CFG['db']['tbl']['friends_list'].' AS friends_tbl'.
					 	' WHERE friends_tbl.owner_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
						' AND u.user_id = friends_tbl.friend_id'.
						' AND (u.user_id !='.$this->dbObj->Param($this->CFG['user']['user_id']).' AND u.usr_status = \'Ok\')'.
						' AND t.user_id='.$this->dbObj->Param($this->CFG['user']['user_id']).
						' ORDER BY friend_order';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->CFG['user']['user_id'], $this->CFG['user']['user_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$usersPerRow = 4;
				$count = 0;
				$found = false;
				$isCurrentUser = $this->isCurrentUser();

				$sendMessageUrl = getUrl('mailcompose', '', '', 'members');
				$displayTopFriends_arr['row'] = array();
				$inc = 0;
				while($row = $rs->FetchRow())
				    {
						$displayTopFriends_arr['row'][$inc]['icon'] = getMemberAvatarDetails($row['user_id']);
						$displayTopFriends_arr['row'][$inc]['online'] = ($row['logged_in'])?$this->CFG['admin']['members']['online_anchor_attributes']:$this->CFG['admin']['members']['offline_anchor_attributes'];

						$found = true;
						$joined = 0;
						$displayTopFriends_arr['row'][$inc]['friendProfileUrl'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
						$displayTopFriends_arr['row'][$inc]['delete_top_friend_confirm_msg'] = str_replace('VAR_USER_NAME', $row['user_name'], $this->LANG['viewfriends_confirm_delete_topfriend']);
						$displayTopFriends_arr['row'][$inc]['record'] = $row;

						$inc++;
				    }
				$smartyObj->assign('displayTopFriends_arr', $displayTopFriends_arr);
			}

		/**
		 * FriendsListHandler::updateFriendOrder()
		 *
		 * @param integer $key
		 * @param string $value
		 * @return void
		 */
		public function updateFriendOrder($key, $value)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['top_friends'].
						' SET friend_order ='.$key.' WHERE friend_id='.$this->dbObj->Param($value).
						' AND user_id='.$this->dbObj->Param($this->CFG['user']['user_id']);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($value, $this->CFG['user']['user_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);
			}
	}
//<<<<<---------------class FriendsListHandler------///
//--------------------Code begins-------------->>>>>//
$friends = new FriendsListHandler();
$friends->setPageBlockNames(array('msg_form_info', 'block_form_error','form_list_friends', 'form_list_top_friends', 'form_search_friend'));
$friends->setAllPageBlocksHide();

$friends->setFormField('user_id', $CFG['user']['user_id']);

$friends->setFormField('numpg', $CFG['data_tbl']['numpg']);
$friends->setFormField('start', 0);

$friends->setFormField('user_id', 0);
$friends->setFormField('user', 0);
$friends->setFormField('total_friends', '0');
$friends->setFormField('fsrch', '1');
$friends->setFormField('uname', '');
$friends->setFormField('friendship_id', '');
$friends->setFormField('email', '');
$friends->setFormField('tagz', '');
$friends->setFormField('act', '');
$friends->setFormField('pg', '');
$friends->setFormField('ajax_page', '');
$friends->setFormField('orderId', '');
$friends->setFormField('friendshipId', array());
$friends->setReturnColumns(array());
$friends->sanitizeFormInputs($_REQUEST);
$friends->profile_url = '';
$friends->otherUser = '';
$friends->is_myFriendsPage =false;
if ($friends->isPageGETed($_GET, 'user_id'))
    {
		$friends->linkFieldsArray = array('user_id');
		$friends->validateUserId();
		$friends->setCurrentUserId($friends->getFormField('user_id'));
		$defaultFormAction = getUrl('viewfriends', '?user='.$friends->getCurrentUserName(), $friends->getCurrentUserName().'/');
    }
elseif ($friends->isPageGETed($_GET, 'user'))
    {
    	$friends->otherUser = true;
    	$friends->profile_url = getMemberProfileUrl($friends->getFormField('user_id'), $friends->getCurrentUserName());
    	$friends->page_title = str_replace('VAR_USER_NAME', ucfirst($friends->getCurrentUserName()), $LANG['viewfriends_user_name']);
    	$friends->linkFieldsArray = array();
		if ($CFG['feature']['rewrite_mode'] == 'normal')
			$friends->linkFieldsArray = array('user');

		$friends->validateUserName();
		$friends->setCurrentUserId($friends->getFormField('user_id'));
		$defaultFormAction = getUrl('viewfriends', '?user='.$friends->getCurrentUserName(), $friends->getCurrentUserName().'/');
    }
elseif(isset($___myFriendsPage))
	{
	   $friends->is_myFriendsPage =true;
		$friends->page_title = str_replace('VAR_USER_NAME', $LANG['viewfriends_my'], $LANG['viewfriends_title']);
		$friends->setCurrentUserId($CFG['user']['user_id']);
		$friends->validateUserId();
		$friends->setCurrentUserId($friends->getFormField('user_id'));
		$defaultFormAction = getUrl('myfriends');
	}
else
	{
		$defaultFormAction = getUrl('myfriends');
	}

if (isAjaxPage())
    {
    	if($friends->getFormField('act') == 'saveOrder')
    		{
				$orderId = $friends->getFormField('orderId');
				$orderArray = explode(',', $orderId);
				foreach($orderArray as $key=>$value)
					{
						if($value != '')
							$friends->updateFriendOrder($key, $value);
					}
				exit;
			}
    }

if ($friends->isValidUserId())
    {
		if ($friends->isFormPOSTed($_POST, 'friendshipId'))
		    {
				$friendShipId = $friends->getFormField('friendshipId');
				$removed = $friends->removeThisFriend($friendShipId);
				if ($removed)
				    {
				        $friends->setPageBlockShow('block_msg_form_success');
						$friends->setCommonSuccessMsg($LANG['viewfriends_friends_list_updated']);
				    }
			}

		if ($friends->isPageGETed($_GET, 'start'))
		    {
				$start = $friends->getFormField('start');
				if (!is_numeric($start))
				    {
				        $friends->setFormField('start', 0);
				    }
		    }

		if ($friends->hasAtleastOneFriend())
		    {
				$friends->setMinRecordSelectLimit(2);
				$friends->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
				$friends->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
				$friends->setTableNames(array($CFG['db']['tbl']['friends_list'], $CFG['db']['tbl']['users']));

				$friends->setTableNameAliases(
												array(
													$CFG['db']['tbl']['friends_list'] => 'friends_tbl',
													$CFG['db']['tbl']['users'] => 'users_tbl'
													)
												);
				$friends->setReturnColumns(array('friendship_id', 'friend_id', 'friend_name', 'icon_id', 'icon_type','image_ext', 'logged_in', 'relation_id', 'sex', 'user_id'));
				$friends->setReturnColumnsAliases(array(
							'friendship_id'	=> 'friends_tbl.id',
							'friend_id' 	=> 'friends_tbl.friend_id',
							'friend_name'	=> 'users_tbl.user_name',
							'icon_id' 		=> 'users_tbl.icon_id',
							'icon_type' 	=> 'users_tbl.icon_type',
							'image_ext' 	=> 'users_tbl.image_ext',
							'relation_id'	=> 'friends_tbl.id',
							'sex'			=> 'users_tbl.sex',
							'logged_in'		=> '(users_tbl.logged_in=\'1\'  AND DATE_SUB(NOW(), INTERVAL 20 SECOND) < users_tbl.last_active)',
							)
						);

				$friends->buildSelectQuery();
				$friends->buildConditionQuery();
				if ($friends->isFormPOSTed($_POST, 'friendSearch'))
				    {
						$friends->buildSearchConditionQuery();
				    }
				$friends->buildSortQuery();
				$friends->buildQuery();
				$friends->executeQuery();

				if($friends->getFormField('pg') == 'top_friends')
					{
						$friends->setPageBlockShow('form_list_top_friends');
					}
				else
					{
						if ($friends->isCurrentUser())
						    {
								$friends->setPageBlockShow('form_search_friend');
						    }
				        $friends->setPageBlockShow('form_list_friends');
		    		}
		    }
		else
			{
		        $friends->setPageBlockShow('msg_form_info');
			}
	}
else
	{
		$friends->setPageBlockShow('block_form_error');
	}
if($friends->isFormPOSTed($_POST, 'yes'))
	{
		$friends->sanitizeFormInputs($_POST);
		if($friends->getFormField('act') == 'add')
			{
				$friends->deleteTopFriend($friends->getFormField('friendship_id'));
				$friends->insertTopFriend($friends->getFormField('friendship_id'));
			}

		if($friends->getFormField('act') == 'delete')
			{
				$friends->deleteTopFriend($friends->getFormField('friendship_id'));
			}
	}
//<<<<--------------------Code Ends----------------------//
if ($friends->isShowPageBlock('msg_form_info'))
	{
		$friends->LANG['msg_no_friends'] = str_replace('VAR_USER_NAME', $friends->getFormField('user'), $LANG['msg_no_friends']);
	}

if ($friends->isShowPageBlock('form_search_friend'))
    {
    	$friends->form_search_friend_arr = array();
		$friends->form_search_friend_arr['form_action'] = URL($defaultFormAction);
		$friends->form_search_friend_arr['hidden_arr'] = array('start', 'user_id');
    }

if ($friends->isShowPageBlock('form_list_top_friends'))
	{
		$friends->page_title = $LANG['viewfriends_manage_top_friends'];
		$friends->displayTopFriends();
	}

if ($friends->isShowPageBlock('form_list_friends'))
	{
		$friends->form_list_friends_arr = array();
		$friends->form_list_friends_arr['form_action'] = URL($defaultFormAction);
		if ($friends->isResultsFound())
		    {
		    	$smartyObj->assign('smarty_paging_list', $friends->populatePageLinksGET($friends->getFormField('start'), $friends->linkFieldsArray));
		  		$friends->displayMyFriends();
			}
		else
			{
				if ($friends->isFormPOSTed($_POST, 'friendSearch'))
					{
						$friends->form_list_friends_arr['not_found_msg'] = $LANG['myfriends_msg_no_friends_by_search'];
					}
				else
					{
						$friends->form_list_friends_arr['not_found_msg'] = $LANG['myfriends_msg_no_friends'];
					}
			}

		$friends->form_list_friends_arr['hidden_arr'] = array('start', 'user_id');
	}
$CFG['feature']['auto_hide_success_block'] = false;
$friends->includeHeader();
?>
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgConfirm', 'selMsgConfirmDelete', 'selMsgConfirmMulti', 'selEditPhotoComments');
	var top_friend_updated = '<?php echo $LANG['myfriends_manage_top_friends_updated']; ?>';
</script>
<?php
setTemplateFolder('general/');
$smartyObj->display('viewFriends.tpl');
$friends->includeFooter();
?>