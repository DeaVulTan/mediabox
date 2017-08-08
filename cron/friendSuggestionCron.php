<?php
$called_from_cron = true;
require_once(dirname(dirname(__FILE__)).'/common/configs/config.inc.php');
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_CronHandler.lib.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include various types of files
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');

//set_time_limit(0);
class friendSuggestionCron extends FormHandler
	{
		/**
		 * friendSuggestionCron::getBeFriendedUsers()
		 *  To get Be Friended Users (users_ids)
		 *
		 * @return void
		 */
		public function getBeFriendedUsers()
			{
				$getBeFriendedUsers_arr = array();
				$sql = 'SELECT owner_id, friend_id, be_friended_id'.
						' FROM '.$this->CFG['db']['tbl']['be_friended_log'].
						' WHERE status = \'Yes\' ORDER BY date_added DESC';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
					{
						$inc = 0;
						while($row = $rs->FetchRow())
							{
								$this->populateUsersToUpdateFriendSuggestion($row['owner_id'], $row['friend_id']);
								//Update be_friended_log table
								$this->updateBeFriendedLog($row['be_friended_id']);
								$inc++;
							}
					}
			}

		/**
		 * friendSuggestionCron::populateUsersToUpdateFriendSuggestion()
		 * 	To populate friends (friend_ids) of owners (owner_id) and friends (friend_id)
		 *
		 * @param integer $owner_id
		 * @param integer $friend_id
		 * @return void
		 */
		public function populateUsersToUpdateFriendSuggestion($owner_id, $friend_id)
			{
				$usersToUpdateSuggestion_arr = array(0=>$owner_id, 1=>$friend_id);

				$sql = 'SELECT friend_id as user_friend_id'.
						' FROM '.$this->CFG['db']['tbl']['friends_list'].
						' WHERE owner_id = '.$this->dbObj->Param('owner_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($owner_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$usersToUpdateSuggestion_arr[] = $row['user_friend_id'];
							}
					}

				$sql = 'SELECT friend_id as user_friend_id'.
						' FROM '.$this->CFG['db']['tbl']['friends_list'].
						' WHERE owner_id = '.$this->dbObj->Param('owner_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($friend_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$usersToUpdateSuggestion_arr[] = $row['user_friend_id'];
							}
					}
				$usersToUpdateSuggestion_arr = array_unique($usersToUpdateSuggestion_arr);
				$this->checkFriendSuggestionLog($usersToUpdateSuggestion_arr);
			}

		/**
		 * friendSuggestionCron::checkFriendSuggestionLog()
		 *	To Check friend_suggestion_log table
		 * 	(i.e.) we are checking last_updated_date < TODAY
		 * 			for the user.
		 *
		 * @param array $usersToUpdateSuggestion_arr
		 * @return void
		 */
		public function checkFriendSuggestionLog($usersToUpdateSuggestion_arr)
			{
				foreach($usersToUpdateSuggestion_arr as $key=>$value)
					{
						$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['friend_suggestion_log'].
								' WHERE user_id ='.$this->dbObj->Param('user_id').
								' AND (last_updated_date < CURDATE() OR last_updated_date IS NULL)';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($value));
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						if ($rs->PO_RecordCount())
							{
								$this->generateFriendSuggestions($value);
							}
					}
			}


		/**
		 * friendSuggestionCron::generateFriendSuggestions()
		 *
		 * @param integer $user_id
		 * @return void
		 */
		public function generateFriendSuggestions($user_id)
			{
				$friendIds = array();
				//To get User's friends
				$sql = 'SELECT friend_id AS user_friend_id'.
						' FROM '.$this->CFG['db']['tbl']['friends_list'].
						' WHERE owner_id = '.$this->dbObj->Param('owner_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$friendIds[] = $row['user_friend_id'];
							}
					}
				$friendIdsStr = implode(',',$friendIds);

				$suggestionIds = array();
				//To get existing friend_suggestions for the user
				$sql = ' SELECT friend_id FROM '.
						$this->CFG['db']['tbl']['friend_suggestion'].
						' WHERE user_id = '.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$suggestionIds[] = $row['friend_id'];
							}
					}

				$suggestionIdsStr = implode(',',$suggestionIds);
				if($suggestionIdsStr != '') $suggestionIdsStr = ','.$suggestionIdsStr;

				if( $friendIdsStr)
					{
						$commonFriendsOfFriends_arr = array();
						//To get Common Friends of Friends
						$sql = ' SELECT IF(EXISTS (SELECT 1 FROM '.$this->CFG['db']['tbl']['friends_list'].' AS fl5 WHERE fl5.owner_id = '.$this->dbObj->Param('user_id').' AND fl5.friend_id = fl.friend_id)'.
								' OR EXISTS (SELECT 1 FROM '.$this->CFG['db']['tbl']['friends_list'].' AS fl6 WHERE fl6.friend_id = '.$this->dbObj->Param('user_id').' AND fl6.owner_id = fl.friend_id), fl.owner_id, fl.friend_id ) as user_friend_id, count(*) as total'.
								' FROM  '.$this->CFG['db']['tbl']['friends_list'].' AS fl'.
								' WHERE '.
								' EXISTS (SELECT 1 FROM '.$this->CFG['db']['tbl']['friends_list'].' AS fl3 WHERE fl3.owner_id = '.$this->dbObj->Param('user_id').' AND fl3.friend_id = fl.owner_id)'.
								' OR EXISTS (SELECT 1 FROM '.$this->CFG['db']['tbl']['friends_list'].' AS fl5 WHERE fl5.owner_id = '.$this->dbObj->Param('user_id').' AND fl5.friend_id = fl.friend_id)'.
								' GROUP BY user_friend_id '.
								' HAVING user_friend_id != '.$this->dbObj->Param($user_id).
								' AND NOT EXISTS (SELECT 1 FROM '.$this->CFG['db']['tbl']['friends_list'].' AS fl1 WHERE fl1.owner_id = '.$this->dbObj->Param('user_id').' AND fl1.friend_id = user_friend_id)'.
								' AND NOT EXISTS (SELECT 1 FROM '.$this->CFG['db']['tbl']['friends_list'].' AS fl2 WHERE fl2.friend_id = '.$this->dbObj->Param('user_id').' AND fl2.owner_id = user_friend_id)'.
								' AND NOT EXISTS (SELECT 1 FROM '.$this->CFG['db']['tbl']['friend_suggestion'].' AS fs WHERE fs.user_id = '.$this->dbObj->Param('user_id').' AND fs.friend_id = user_friend_id)'.
								' AND total > 1';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($user_id, $user_id, $user_id, $user_id, $user_id, $user_id, $user_id, $user_id));
					    if (!$rs)
						    trigger_db_error($this->dbObj);


						if($rs->PO_RecordCount())
							{
								$inc = 0;
								while($row = $rs->FetchRow())
									{
										$commonFriendsOfFriends_arr[$inc]['friend_id'] = $row['user_friend_id'];
										$commonFriendsOfFriends_arr[$inc]['total'] = $row['total'];
										$inc++;
									}
							}
						//Insert Friend Suggestions to friend_suggestion table
						$this->insertFriendSuggestions($user_id, $commonFriendsOfFriends_arr);
					}
			}

		/**
		 * friendSuggestionCron::insertFriendSuggestions()
		 *	To insert friend suggestions to friend_suggestion table
		 *
		 * @param integer $user_id
		 * @param array $commonFriendsOfFriends_arr
		 * @return void
		 */
		public function insertFriendSuggestions($user_id, $commonFriendsOfFriends_arr)
			{
				$suggestion_count = 0;
				$suggested_friends = array();
				foreach($commonFriendsOfFriends_arr as $key=>$value)
					{
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['friend_suggestion'].
								' SET user_id='.$this->dbObj->Param('user_id').','.
								' friend_id='.$this->dbObj->Param('friend_id').','.
								' weight='.$this->dbObj->Param('weight').','.
								' status = \'Ok\','.
								' date_added = NOW()';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($user_id, $value['friend_id'], $value['total']));
					    if (!$rs)
						    trigger_db_error($this->dbObj);
						$suggestion_count++;
						$suggested_friends[] = $value['friend_id'];
					}
				if ($suggested_friends AND chkIsAllowedNotificationEmail('friend_suggestion', $user_id))
					{
						$fields_to_get = array('first_name', 'last_name');
						$user_details = $this->getUserDetail('user_id', $user_id);
						$user_name = $user_details['user_name'];

						$suggested_friends_details = '<div style="">';
						foreach($suggested_friends as $friend_id){
							$fields_to_get = array('first_name', 'last_name');
							$friends_details = $this->getUserDetail('user_id', $friend_id);
							$friends_details['icon'] = getMemberAvatarDetails($friend_id);
							$friend_name = $friends_details['user_name'];
							$friend_profile_url_start = '<a href="'.getMemberProfileUrl($friend_id, $friend_name).'">';
							$friend_profile_url_end = '</a>';
							$suggested_friends_details .= '<div style="margin: 2px; padding: 2px; width:100px;">';
							$suggested_friends_details .= '<span>'.$friend_profile_url_start.'<img src="'.$friends_details['icon']['s_url'].'" alt="'.$friend_name.'" />'.$friend_profile_url_end.'</span>';
							$suggested_friends_details .= '<span>'.$friend_profile_url_start.$friend_name.$friend_profile_url_end.'<span>';
							$suggested_friends_details .= '</div>';
						}
						$suggested_friends_details .= '</div>';

						$site_link = '<a href="'.$this->CFG['site']['url'].'">'.$this->CFG['site']['name'].'</a>';

						$suggestion_subject = $this->LANG['friend_suggestion_subject'];
						$suggestion_subject = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $suggestion_subject);
						$suggestion_subject = str_replace('VAR_USER_NAME', $user_name, $suggestion_subject);

						$suggestion_content = $this->LANG['friend_suggestion_content'];
						$suggestion_content = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $suggestion_content);
						$suggestion_content = str_replace('VAR_SITE_LINK', $site_link, $suggestion_content);
						$suggestion_content = str_replace('VAR_USER_NAME', $user_name, $suggestion_content);
						$suggestion_content = str_replace('VAR_SUGGESTION_COUNT', $suggestion_count, $suggestion_content);
						$suggestion_content = str_replace('VAR_SUGGESTION_CONTENT', $suggested_friends_details, $suggestion_content);

						$this->_sendMail($user_details['email'], $suggestion_subject, $suggestion_content,
											$this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);

					}
				//Update friend_suggestion_log for the user
				$this->updateFriendSuggestionLog($user_id);
			}

		/**
		 * friendSuggestionCron::updateFriendSuggestionLog()
		 *	To update friend_suggestion_log for the user
		 *
		 * @param integer $user_id
		 * @return void
		 */
		public function updateFriendSuggestionLog($user_id)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['friend_suggestion_log'].
						' SET last_updated_date = CURDATE()'.
						' WHERE user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);
			}

		/**
		 * friendSuggestionCron::updateBeFriendedLog()
		 *	To update be_friended_log table
		 *
		 * @param integer $be_friended_id
		 * @return void
		 */
		public function updateBeFriendedLog($be_friended_id)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['be_friended_log'].
								' SET status = \'No\''.
								' WHERE be_friended_id='.$this->dbObj->Param('be_friended_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($be_friended_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);
			}
	}
//<<<<<-------------- Class LoginFormHandler begins ---------------//
//-------------------- Code begins -------------->>>>>//
$friendSuggestionCron = new friendSuggestionCron();
callMultipleCronCheck();
$friendSuggestionCron->getBeFriendedUsers();
//require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');
?>