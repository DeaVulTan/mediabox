<?php
/**
 * This file to delete users
 *
 * @category	Rayzz
 * @package		Cron
 */
$called_from_cron = true;
require_once(dirname(dirname(__FILE__)).'/common/configs/config.inc.php');
$CFG['mods']['is_include_only']['non_html_header_files'] = true;

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require(dirname(dirname(__FILE__)).'/common/classes/class_CronHandler.lib.php');

$module_class_arr = array();
$module_obj_arr = array();
$scope_module_obj = array();
$module = array();
$inc = 0;
foreach($CFG['site']['modules_arr'] as $key=>$value)
	{
		//if (chkAllowedModule(array($value)))
			{
				$file_name = $CFG['site']['project_path'].'common/classes/class_'.$value.'RelatedCron.lib.php';

				if(file_exists($file_name))
					{
						require_once($file_name);
						$module_class_arr[$inc] = 'CronDelete'.ucfirst($value).'Handler';
						$module_obj[$inc] = $value.'Cron';
						$module[$inc] = $value;
						$scope_module_obj[$inc] = $value.'CronObj';
						$inc++;
					}
			}
	}
require($CFG['site']['project_path'].'common/application_top.inc.php');
//------------------- Class CronDeleteUsersFormHandler Begins ------->>>>>//
set_time_limit(0);
/**
 * CronDeleteUsersFormHandler
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class CronDeleteUsersFormHandler extends CronHandler
	{
		public $userVideo = array();
		public $userFriendIds = array();
		public $userFriendshipIds = array();
		public $userFriendRelationIds = array();

		/**
		 * CronDeleteUsersFormHandler::setHandlerObject()
		 *
		 * @param mixed $moduleObj
		 * @param string $obj
		 * @return
		 */
		public function setHandlerObject($moduleObj, $obj='')
			{
				$this->$moduleObj = $obj;
			}

		/**
		 * CronDeleteUsersFormHandler::getDeletedUsers()
		 *
		 * @param integer $limit
		 * @return array
		 */
		public function getDeletedUsers($limit = 10)
			{
				if(isset($this->CFG['admin']['inactive_users_delete_period'])
					AND $this->CFG['admin']['inactive_users_delete_period']
						AND intval($this->CFG['admin']['inactive_users_delete_period']) > 0)
					{
						$condition = ' usr_status=\'ToActivate\'
										AND doj < DATE_SUB(now(), INTERVAL 2 DAY) ';

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
								' SET usr_status=\'Deleted\''.
								' WHERE '.$condition;

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_db_error($this->dbObj);
					}

				$sql = 'SELECT user_id FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE usr_status = \'Deleted\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);

				if (!$rs)
					trigger_db_error($this->dbObj);

				$deletedUsers = array();
				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
							$deletedUsers[] = $row['user_id'];
						    }
					}

				return $deletedUsers;
			}

		/**
		 * CronDeleteUsersFormHandler::deleteTheseUserRelatedEntriesFromSite()
		 *
		 * @param mixed $deletedUsers
		 * @return void
		 */
		public function deleteTheseUserRelatedEntriesFromSite($deletedUsers)
			{

				foreach($deletedUsers as $userId)
					{
						$this->removeInternalMessageRelatedEntries($userId);
						$this->removeFriendRelatedEntries($userId);
						$this->removeActivities($userId);

				    	foreach($this->module_obj as $key=>$value)
				    		{

				    			if(chkAllowedModule(array($this->module[$key])))
				    				{
										$method = 'remove'.ucfirst($this->module[$key]).'RelatedEntries';
										$scope_module_obj = $this->scope_module_obj[$key];
										$this->$scope_module_obj->$method($userId, 'user_id');
									}
							}

						#User Related Entries
						$this->clearUserRelatedEntries($userId);
						#Everthing Cleared, remove user from users table
						$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['users'], 'user_id', $userId);
					}

				$this->resetRelatedFriendEntries();
			}

		/**
		 * CronDeleteUsersFormHandler::clearUserRelatedEntries()
		 *
		 * @param integer $user_id
		 * @return
		 */
		public function clearUserRelatedEntries($user_id = 0)
			{
				$user_id_equal_to = ' user_id='.$this->dbObj->Param($user_id);
				//Profile Comments Made & Received
				$commentCondition = 'profile_user_id='.$this->dbObj->Param($user_id).' OR comment_user_id='.$this->dbObj->Param($user_id);
				$this->deleteFromTable($this->CFG['db']['tbl']['users_profile_comments'], $commentCondition, array($user_id, $user_id));

				//Friend Invitation Sent
				$friendInviteCondition = $user_id_equal_to;
				$this->deleteFromTable($this->CFG['db']['tbl']['users_invitation'], $friendInviteCondition, array($user_id));

				//Theme
				$themeCondition = $user_id_equal_to;
				$this->deleteFromTable($this->CFG['db']['tbl']['users_profile_theme'], $themeCondition, array($user_id));

				//Status Messages
				$statusMsgInfoCondition = $user_id_equal_to;
				$this->deleteFromTable($this->CFG['db']['tbl']['users_status_messages'], $statusMsgInfoCondition, array($user_id));

				//Block Members
				$blockCondition = 'user_id='.$this->dbObj->Param($user_id).' OR block_id='.$this->dbObj->Param($user_id);
				$this->deleteFromTable($this->CFG['db']['tbl']['block_members'], $blockCondition, array($user_id, $user_id));

				//Flagged Contents
				$flagCondition = 'reporter_id='.$this->dbObj->Param($user_id);
				$this->deleteFromTable($this->CFG['db']['tbl']['flagged_contents'], $flagCondition, array($user_id));

				//users featured
				$usersFeaturedCondition = 'user_id='.$this->dbObj->Param($user_id);
				$this->deleteFromTable($this->CFG['db']['tbl']['users_featured'], $usersFeaturedCondition, array($user_id));
			}

		/**
		 * CronDeleteUsersFormHandler::removeInternalMessageRelatedEntries()
		 *	//Internal Mails
		 *
		 * @param integer $user_id
		 * @return void
		 */
		public function removeInternalMessageRelatedEntries($user_id = 0)
			{
				$sql = 	'UPDATE '.$this->CFG['db']['tbl']['messages_info'].
						' SET from_delete=\'Trash\', '.
						' to_delete=\'Trash\''.
						' WHERE from_id='.$this->dbObj->Param($user_id).
						' OR to_id='.$this->dbObj->Param($user_id);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id, $user_id));
				if (!$rs)
				    trigger_db_error($this->dbObj);
			}

		//Friends
		/**
		 * CronDeleteUsersFormHandler::removeFriendRelatedEntries()
		 *
		 * @param integer $user_id
		 * @return
		 */
		public function removeFriendRelatedEntries($user_id = 0)
			{
				$this->clearFriends($user_id);
				$this->clearFriendRelations($user_id);
				$this->clearFriendRelationName($user_id);
			}

		/**
		 * CronDeleteUsersFormHandler::clearFriends()
		 *
		 * @param integer $user_id
		 * @return
		 */
		public function clearFriends($user_id = 0)
			{
				$sql = 'SELECT friend_id as user_friend_id, id as friendship_id'.
						' FROM '.$this->CFG['db']['tbl']['friends_list'].
						' WHERE owner_id='.$this->dbObj->Param($user_id);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = array();
				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
								$this->userFriendIds[] = $row['user_friend_id'];
								$this->userFriendshipIds[] = $row['friendship_id'];
						    } // while
					}

				$sql = 'SELECT id as friendship_id'.
						' FROM '.$this->CFG['db']['tbl']['friends_list'].
						' WHERE friend_id='.$this->dbObj->Param($user_id);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = array();
				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
								$this->userFriendshipIds[] = $row['friendship_id'];
						    } // while
					}
			}

		/**
		 * CronDeleteUsersFormHandler::clearFriendRelationName()
		 *
		 * @param integer $user_id
		 * @return
		 */
		public function clearFriendRelationName($user_id = 0)
			{
				$sql = 'SELECT relation_id '.
						' FROM '.$this->CFG['db']['tbl']['friends_relation_name'].
						' WHERE user_id='.$this->dbObj->Param($user_id);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));

				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = array();
				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
								$relationId = $row['relation_id'];
								$friendsRelationTblCondition = 'relation_id='.$this->dbObj->Param($relationId);
								$this->deleteFromTable($this->CFG['db']['tbl']['friends_relation'], $friendsRelationTblCondition, array($relationId));

								//Remove This entry
								$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['friends_relation_name'], 'relation_id', $relationId);
						    } // while
					}
			}

		/**
		 * CronDeleteUsersFormHandler::resetRelatedFriendEntries()
		 *
		 * @return
		 */
		public function resetRelatedFriendEntries()
			{
				if ($this->userFriendshipIds)
				    {
						$friendshipIds = array_keys($this->userFriendshipIds);
				        foreach($friendshipIds as $friendshipId)
							{
								$this->clearFriendRelations($friendshipId);
								$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['friends_list'], 'id', $friendshipId);
							}

				    }

				if ($this->userFriendIds)
				    {
						$userFriends = array_keys($this->userFriendIds);
				        foreach($userFriends as $friendId)
							{
								$this->resetFriendCount($friendId);
							}
				    }

			}

		/**
		 * CronDeleteUsersFormHandler::clearFriendRelations()
		 *
		 * @param integer $friendship_id
		 * @return
		 */
		public function clearFriendRelations($friendship_id = 0)
			{
				$sql = 'SELECT id, relation_id FROM '.$this->CFG['db']['tbl']['friends_relation'].
						' WHERE friendship_id='.$this->dbObj->Param($friendship_id);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($friendship_id));

				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = array();
					if ($rs->PO_RecordCount())
						{
				    		while($row = $rs->FetchRow())
							    {
									//Reset totalCounts in Relation Name Table
									$total_contacts = ' total_contacts = total_contacts - 1 ';
									$relationId = $row['relation_id'];
									$condition = ' relation_id='.$this->dbObj->Param($relationId);
									$this->updateTable($this->CFG['db']['tbl']['friends_relation_name'], $total_contacts, $condition, array($relationId));

									//Remove this Relation
									$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['friends_relation'], 'id', $row['id']);
							    } // while
						}
			}

		/**
		 * CronDeleteUsersFormHandler::resetFriendCount()
		 *
		 * @param integer $user_id
		 * @return
		 */
		public function resetFriendCount($user_id = 0)
			{
				$friendCondition = ' owner_id='.$this->dbObj->Param($user_id);
				$totalFriends = $this->getNumRowsForThisSql($this->CFG['db']['tbl']['friends_list'], $friendCondition, array($user_id));
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
						' SET total_friends='.$this->dbObj->Param($totalFriends).
						' WHERE user_id='.$this->dbObj->Param($user_id);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($totalFriends, $user_id));
				if (!$rs)
				    trigger_db_error($this->dbObj);
			}

		/**
		 * CronDeleteUsersFormHandler::removeActivities()
		 *
		 * @param integer $user_id
		 * @return
		 */
		public function removeActivities($user_id = 0)
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['activity'].
						' WHERE actor_id='.$this->dbObj->Param('actor_id').
						' OR owner_id='.$this->dbObj->Param('owner_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id, $user_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['general_activity'].
						' WHERE actor_id='.$this->dbObj->Param('actor_id').
						' OR owner_id='.$this->dbObj->Param('owner_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id, $user_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['video_activity'].
						' WHERE actor_id='.$this->dbObj->Param('actor_id').
						' OR owner_id='.$this->dbObj->Param('owner_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id, $user_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);
			}
	}
//<<<<<-------------------- Class CronDeleteUsersFormHandler Ends ------------------------//
//------------------------- Code Begins ---------------------------------->>>>>//
$crondeleteusers = new CronDeleteUsersFormHandler();
callMultipleCronCheck();
$crondeleteusers->module_class_arr = $module_class_arr;
$crondeleteusers->module_obj = $module_obj;
$crondeleteusers->scope_module_obj = $scope_module_obj;
$crondeleteusers->module = $module;

foreach($module as $key=>$value)
	{
		if(chkAllowedModule(array($value)))
			{
				$$module_obj[$key] = new $module_class_arr[$key];
				$crondeleteusers->setHandlerObject($scope_module_obj[$key], $$module_obj[$key]);
			}
	}

$deleted = $crondeleteusers->getDeletedUsers();
if ($deleted)
    {
			$crondeleteusers->deleteTheseUserRelatedEntriesFromSite($deleted);
    }
else
	{
		print 'No More Deleted Users';
	}
//require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');
?>