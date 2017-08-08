<?php
/**
 * This file is to show the member home
 *
 *
 * @category	Rayzz
 * @package		Members
 */
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/members/myHome.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/countries_list_array.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ActivityHandler.lib.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------------------class IndexPageHandler ----------------------->>>
/**
 * IndexPageHandler
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class IndexPageHandler extends MediaHandler
	{
		/**
		 * @var array userDetails
		 */
		public $userDetails = array();

		public $friendsCount = 0;

		public $videoCount = 0;

		public $announcement_recordCount = 0;

		/**
		 * IndexPageHandler::displayMyFriends()
		 *
		 * @param integer $totalFriends
		 * @param integer $start
		 * @param integer $friendLimit
		 * @return
		 */
		public function displayMyFriends($totalFriends=0, $start=0, $friendLimit)
			{
				global $smartyObj;
				$displayMyFriends_arr = array();
				$user_id = $this->fields_arr['user_id'];
				$sql = 'SELECT u.user_id,u.user_name,u.icon_id,u.icon_type,u.image_ext,u.logged_in,u.sex,t.friend_id'.
						' FROM '.$this->CFG['db']['tbl']['top_friends'].' AS t LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u'.
						' ON u.user_id = t.friend_id'.
						' WHERE t.user_id='.$this->fields_arr['user_id'].
						' AND u.usr_status=\'Ok\''.
						' ORDER BY friend_order ASC'.
						' LIMIT '.$start.','.$friendLimit;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = array();
				$friends_list_arr = array();
				$usersPerRow = 3;
				$count = 0;
				$inc = 0;
				$displayMyFriends_arr['row'] = array();
				if ($rs->PO_RecordCount())
					{

						while($row = $rs->FetchRow())
							{
								$found = true;
								$displayMyFriends_arr['row'][$inc]['open_ul'] = false;
								if ($count%$usersPerRow == 0)
									{
										$displayMyFriends_arr['row'][$inc]['open_ul'] = true;
									}
								$userDetails = $this->getUserDetail('user_id', $row['user_id']);
								$friendName = isset($userDetails['user_name'])?$userDetails['user_name']:'';
								$icon = getMemberAvatarDetails($row['user_id']);
								$friendName = $userDetails['user_name'];
								if($this->CFG['admin']['display_first_last_name'])
									$friendName = $userDetails['first_name'].' '.$userDetails['last_name'];
								$displayMyFriends_arr['row'][$inc]['friendName']=$friendName;
								$displayMyFriends_arr['row'][$inc]['icon']=$icon;
								$displayMyFriends_arr['row'][$inc]['friend_id']=$row['friend_id'];
								$displayMyFriends_arr['row'][$inc]['memberProfileUrl']=getMemberProfileUrl($row['user_id'], $row['user_name']);
								$displayMyFriends_arr['row'][$inc]['anchor_id'] = 'MFa_'.$count;
								$displayMyFriends_arr['row'][$inc]['image_id'] = 'MFimg_'.$count;
								$count++;
								$displayMyFriends_arr['row'][$inc]['end_ul'] = false;
								if ($count%$usersPerRow==0)
									{
										$count = 0;
										$displayMyFriends_arr['row'][$inc]['end_ul'] = true;
									}
								if(!$friendName)
									continue;
								$inc++;
						    } // while
					}
				$friend_id_count =count($displayMyFriends_arr['row']);
				$friend_id_arr=array();
			    for($i=0;$i<$friend_id_count;$i++)
				    {
				    	$displayMyFriends_arr['row'][$i]['friend_id'];
				 		$friend_id_arr[]=($displayMyFriends_arr['row'][$i]['friend_id']!='')?$displayMyFriends_arr['row'][$i]['friend_id']:'';
					}
				$friend_ids=implode(',',$friend_id_arr);
				$endLimit=$friendLimit-$friend_id_count;
				$query_owner_str = '';
				$query_friend_str = '';

				if(!empty($friend_ids))
					{
						//$query_owner_str = "AND owner_id NOT IN ($friend_ids)  ";
						//$query_owner_str = ' AND NOT EXISTS (SELECT 1 FROM '.$this->CFG['db']['tbl']['top_friends'].' AS t LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u1 ON u1.user_id=t.friend_id WHERE t.user_id='.$this->fields_arr['user_id'].' AND u1.usr_status=\'Ok\' AND u1.user_id=fl.owner_id)';
						//$query_friend_str = "AND friend_id  NOT IN ($friend_ids)  ";
						$query_friend_str = ' AND NOT EXISTS (SELECT 1 FROM '.$this->CFG['db']['tbl']['top_friends'].' AS t LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u1 ON u1.user_id=t.friend_id WHERE t.user_id='.$this->dbObj->Param('friend_id').' AND u1.usr_status=\'Ok\' AND u1.user_id=fl.friend_id)';
						$field_values [] = $user_id;
					}
				if($friend_id_count<$friendLimit)
					{
						$sql = 'SELECT fl.friend_id as friend_id'.
								' FROM '.$this->CFG['db']['tbl']['friends_list'].' AS fl, '.$this->CFG['db']['tbl']['users'].' AS u'.
								' WHERE fl.friend_id = u.user_id AND usr_status = \'Ok\' AND fl.owner_id='.$this->dbObj->Param('user_id').$query_friend_str.
								' LIMIT '.$start.', '.$endLimit;
						$field_values [] = $user_id;

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $field_values);
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						if ($rs->PO_RecordCount() > 0)
							{
								while($row = $rs->FetchRow())
								    {
									   	$user = $this->getUserDetail('user_id', $row['friend_id']);
									   	$icon = getMemberAvatarDetails($row['friend_id']);
									   	if(!empty($user['user_id']))
											{
												$found = true;
												$displayMyFriends_arr['row'][$inc]['open_ul'] = false;
												if ($count%$usersPerRow == 0)
													{
															$displayMyFriends_arr['row'][$inc]['open_ul'] = true;
													}
												$friendName = $user['user_name'];
												if($this->CFG['admin']['display_first_last_name'])
													$friendName = $user['user']['first_name'].' '.$user['user']['last_name'];
												$displayMyFriends_arr['row'][$inc]['friendName'] = $friendName;
												$displayMyFriends_arr['row'][$inc]['icon'] = $icon;
												$displayMyFriends_arr['row'][$inc]['memberProfileUrl'] = getMemberProfileUrl($row['friend_id'], $friendName);
												$displayMyFriends_arr['row'][$inc]['friend_id']=$row['friend_id'];
												$displayMyFriends_arr['row'][$inc]['anchor_id'] = 'MFa_'.$count;
												$displayMyFriends_arr['row'][$inc]['image_id'] = 'MFimg_'.$count;

												$count++;
												$displayMyFriends_arr['row'][$inc]['end_ul'] = false;
												if ($count%$usersPerRow==0)
													{
														$count = 0;
														$displayMyFriends_arr['row'][$inc]['end_ul'] = true;
													}
												$inc++;
											}
									} // while
							}
					}
   				$displayMyFriends_arr['extra_end_ul'] = false;
				if (isset($found) and $count and $count<$usersPerRow)
					{
							$displayMyFriends_arr['extra_end_ul'] = true;
					}
				$smartyObj->assign('displayMyFriends_arr', $displayMyFriends_arr);
			}

		/**
		 * IndexPageHandler::populateFriendSuggestions()
		 *
		 * @return void
		 */
		public function populateFriendSuggestions()
			{
				global $smartyObj;
				$populateFriendSuggestions_arr = array();

				$sql = 'SELECT friend_id'.
						' FROM '.$this->CFG['db']['tbl']['friend_suggestion'].
						' WHERE user_id = '.$this->dbObj->Param('user_id').
						' AND status = \'Ok\''.
						' ORDER BY weight DESC, date_added DESC'.
						' LIMIT 0, '.$this->CFG['admin']['myhome']['total_friend_suggestions'];
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$populateFriendSuggestions_arr['row'] = array();
				if($rs->PO_RecordCount())
					{
						$inc = 0;
						while($row = $rs->FetchRow())
							{
								$fields_to_get = array('first_name', 'last_name');
								$user = $this->getUserDetail('user_id', $row['friend_id']);
								if(!empty($user))
									{
										$user_friend_username = $user['user_name'];
										$populateFriendSuggestions_arr['row'][$inc]['friend_id'] = $row['friend_id'];
										$populateFriendSuggestions_arr['row'][$inc]['user_friend_username'] = $user_friend_username;
										$populateFriendSuggestions_arr['row'][$inc]['user_friend_name'] = $user['user_name'];
										if($this->CFG['admin']['display_first_last_name'])
											{
												$populateFriendSuggestions_arr['row'][$inc]['user_friend_name'] = $user['first_name'].' '.
																													$user['last_name'];
											}
										$populateFriendSuggestions_arr['row'][$inc]['icon'] = getMemberAvatarDetails($row['friend_id']);
										$populateFriendSuggestions_arr['row'][$inc]['friend_add_url'] = getUrl('friendadd', '?friend='.$row['friend_id'], '?friend='.$row['friend_id'], 'members');
										$populateFriendSuggestions_arr['row'][$inc]['memberProfileUrl'] = getMemberProfileUrl($row['friend_id'], $user_friend_username);
										$populateFriendSuggestions_arr['row'][$inc]['anchor_id'] = 'Fa_'.$inc;
										$populateFriendSuggestions_arr['row'][$inc]['image_id'] = 'Fimg_'.$inc;

										$inc++;
									}
							}
					}
				$smartyObj->assign('populateFriendSuggestions_arr', $populateFriendSuggestions_arr);
			}

		/**
		 * IndexPageHandler::deleteFriendSuggestion()
		 *
		 * @return void
		 */
		public function deleteFriendSuggestion()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['friend_suggestion'].
						' SET status = \'Deleted\''.
						' WHERE user_id = '.$this->dbObj->Param('user_id').
						' AND friend_id = '.$this->dbObj->Param('friend_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['suggestion_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);
			}

		/**
		 * IndexPageHandler::getFriendSuggestion()
		 *  #To get friend suggestion by AJAX
		 *
		 * @return boolean
		 */
		public function getFriendSuggestion()
			{
				$friendSuggestions_arr = array();
				$start = $this->CFG['admin']['myhome']['total_friend_suggestions']-1;
				$sql = 'SELECT friend_id'.
						' FROM '.$this->CFG['db']['tbl']['friend_suggestion'].
						' WHERE user_id = '.$this->dbObj->Param('user_id').
						' AND status = \'Ok\''.
						' ORDER BY weight DESC, date_added DESC'.
						' LIMIT '.$start.', 1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));

			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						if($row = $rs->FetchRow())
							{
								$fields_to_get = array('first_name', 'last_name');
								$user = $this->getUserDetail('user_id', $row['friend_id']);
								if(!empty($user['user']))
									{
										$user_friend_username = $user['user']['user_name'];
										$friendSuggestions_arr['friend_id'] = $row['friend_id'];
										$friendSuggestions_arr['user_friend_name'] = $user_friend_username;
										$friendSuggestions_arr['user_friend_name'] = $user['user']['user_name'];
										if($this->CFG['admin']['display_first_last_name'])
											{
												$friendSuggestions_arr['user_friend_name'] = $user['user']['first_name'].' '.
																								$user['user']['last_name'];
											}
										$friendSuggestions_arr['icon'] = $user['icon'];
										$friendSuggestions_arr['friend_add_url'] = getUrl('friendadd', '?friend='.$row['friend_id'], '?friend='.$row['friend_id'], 'members');
										$friendSuggestions_arr['memberProfileUrl'] = getMemberProfileUrl($row['friend_id'], $user_friend_username);
										$friendSuggestions_arr['anchor_id'] = 'Fa_'.$start;
										$friendSuggestions_arr['image_id'] = 'Fimg_'.$start;

										global $smartyObj;
										$smartyObj->assign('friendSuggestions', $friendSuggestions_arr);
										setTemplateFolder('members/');
										$smartyObj->display('friendSuggestions.tpl');
										return true;
									}
							}
					}
				return false;
			}

		/**
		 * IndexPageHandler::updateUserDetailsInSession()
		 *
		 * @return void
		 */
		public function updateUserDetailsInSession()
			{
				global $smartyObj;
				$interval_by = strtolower($this->CFG['admin']['myhome']['profile_hits_interval_by']);

				$user_id = $this->CFG['user']['user_id'];
				$sql = 'SELECT first_name, last_name,
						(SELECT COUNT(DISTINCT(fl.friend_id)) '.
						' FROM '.$this->CFG['db']['tbl']['friends_list'].' AS fl, '.$this->CFG['db']['tbl']['users'].' AS u'.
						' WHERE fl.friend_id = u.user_id AND u.usr_status = \'Ok\'
						AND fl.owner_id='.$this->dbObj->Param('user_id'). ') AS total_friends_count,
						total_photos, total_videos, new_mails, new_requests, profile_hits, doj AS joined_date'.
						', DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL '.$this->CFG['admin']['myhome']['profile_hits_interval'].'
						'.$interval_by.'), \'%d %b, %Y\') AS since_date'.
						' FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_id='.$this->dbObj->Param('user_id');

	            $stmt = $this->dbObj->Prepare($sql);
	            $rs = $this->dbObj->Execute($stmt, array($user_id, $user_id));
                if (!$rs)
            	    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount()>0)
				    {
						$row = $rs->FetchRow();
						$_SESSION['user']['total_videos'] 	= $row['total_videos'];
						$_SESSION['user']['total_friends'] 	= $row['total_friends_count'];
						$this->userDetails['first_name'] 	= $row['first_name'];
						$this->userDetails['last_name'] 	= $row['last_name'];
						$this->userDetails['total_videos'] 	= $row['total_videos'];
						$this->userDetails['total_friends'] = $row['total_friends_count'];
						$this->userDetails['new_requests'] 	= $row['new_requests'];
						$this->userDetails['new_mails']		= $row['new_mails'];
						$this->userDetails['video_mails'] 	= false;
						if(chkAllowedModule(array('video')))
							$this->userDetails['video_mails'] = $this->countUnReadMailByType('Video');
						$this->userDetails['profile_hits']	= $row['profile_hits'];
						$this->userDetails['last_logged']	= ($_SESSION['user']['last_logged']!='')?$_SESSION['user']['last_logged']:$this->LANG['myhome_subtitle_first_login'];
						$this->userDetails['joined_date']	= $row['joined_date'];
						$this->userDetails['total_profile_comments'] = $this->getTotalComments();
						$profileCommentURL=getUrl('profilecomments','?user_id='.$user_id, '?user_id='.$user_id);
						$smartyObj->assign('profileCommentURL',$profileCommentURL);
						$this->userDetails['profile_since_date'] = $row['since_date'];
						$this->userDetails['profile_hits_count_by'] = $this->getProfileHitsCountBy();
				    }
			}

		/**
		 * IndexPageHandler::countUnReadMailByType()
		 *
		 * @param mixed $mail_type
		 * @return integer
		 */
		public function countUnReadMailByType($mail_type)
			{
				$sql = 'SELECT COUNT( mi.info_id ) AS count'.
						' FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['messages'].' AS ms, '.$this->CFG['db']['tbl']['messages_info'].' AS mi'.
						' WHERE mi.to_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
						' AND mi.from_id = u.user_id'.
						' AND mi.message_id = ms.message_id'.
						' AND mi.to_viewed = \'No\''.
						' AND mi.to_delete = \'No\''.
						' AND mi.to_stored = \'No\''.
						' AND mi.email_status = '.$this->dbObj->Param('mail_type');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $mail_type));
				if (!$rs)
				    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $row['count'];
			}

		/**
		 * IndexPageHandler::getProfileHitsCountBy()
		 *
		 * @return integer
		 */
		public function getProfileHitsCountBy()
			{
				$getProfileHitsCountBy_arr = array();

				$interval_by = strtolower($this->CFG['admin']['myhome']['profile_hits_interval_by']);

				$sql = 'SELECT SUM( total_views ) AS total_hits'.
						' FROM '.$this->CFG['db']['tbl']['users_views'].
						' WHERE user_id = '.$this->dbObj->Param('user_id').
						' AND DATE_FORMAT( last_viewed_date, \'%Y-%m-%d\' ) > DATE_SUB(CURDATE(), INTERVAL '.$this->CFG['admin']['myhome']['profile_hits_interval'].' '.$interval_by.')'.
						' GROUP BY user_id';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						if($row = $rs->FetchRow())
							{
								return $row['total_hits'];
							}
					}
				return 0;
			}

		/**
		 * IndexPageHandler::displayMyProfileVisitors()
		 *
		 * @return void
		 */
		public function displayMyProfileVisitors()
			{
				global $smartyObj;
				$displayMyProfileVisitors_arr = array();

				$interval_by = strtolower($this->CFG['admin']['myhome']['profile_hits_interval_by']);

				$sql = 'SELECT uv.viewed_user_id, u.user_name, u.first_name, u.last_name, u.icon_id, u.icon_type, u.image_ext, u.sex'.
						' FROM '.$this->CFG['db']['tbl']['users_views'].' as uv'.
						' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' as u'.
						' ON u.user_id= uv.viewed_user_id'.
						' WHERE uv.user_id='.$this->dbObj->Param('user_id').
						' AND u.usr_status = \'Ok\''.
						' AND  DATE_FORMAT( uv.last_viewed_date, \'%Y-%m-%d\' ) >'.
						' DATE_SUB(CURDATE(), INTERVAL '.$this->CFG['admin']['myhome']['profile_hits_interval'].' '.$interval_by.')'.
						' ORDER BY uv.last_viewed_date DESC';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$displayMyProfileVisitors_arr['row'] = array();
				$displayMyProfileVisitors_arr['total_records'] = $rs->PO_RecordCount();

				if ($rs->PO_RecordCount() > 0)
				    {
				    	$inc = 0;
						while($row = $rs->FetchRow())
						    {
								$displayMyProfileVisitors_arr['row'][$inc]['visitor_username'] = $row['user_name'];
								$displayMyProfileVisitors_arr['row'][$inc]['visitor_name'] = $row['user_name'];
								if($this->CFG['admin']['display_first_last_name'])
									{
										$displayMyProfileVisitors_arr['row'][$inc]['visitor_name'] = $row['first_name'].' '.
																										$row['last_name'];
									}
								$displayMyProfileVisitors_arr['row'][$inc]['icon'] = getMemberAvatarDetails($row['viewed_user_id']);
								$displayMyProfileVisitors_arr['row'][$inc]['memberProfileUrl'] = getMemberProfileUrl($row['viewed_user_id'], $row['user_name']);
								$displayMyProfileVisitors_arr['row'][$inc]['record'] = $row;
								$displayMyProfileVisitors_arr['row'][$inc]['anchor_id'] = 'RVa_'.$inc;
								$displayMyProfileVisitors_arr['row'][$inc]['image_id'] = 'RVimg_'.$inc;
								$inc++;
					   		}
				   	}
			   	$smartyObj->assign('displayMyProfileVisitors_arr', $displayMyProfileVisitors_arr);
			}

		/**
		 * IndexPageHandler::getTotalFriendsNew()
		 *
		 * @return integer
		 */
		public function getTotalFriendsNew()
			{
				return $this->userDetails['total_friends'];
			}

		/**
		 * IndexPageHandler::getTotalVideos()
		 *
		 * @return integer
		 */
		public function getTotalVideos()
			{
				return $this->userDetails['total_videos'];
			}

		/**
		 * IndexPageHandler::getTotalNewMails()
		 *
		 * @return integer
		 */
		public function getTotalNewMails()
			{
				return $this->userDetails['new_mails'];
			}

		/**
		 * IndexPageHandler::getTotalNewRequests()
		 *
		 * @return integer
		 */
		public function getTotalNewRequests()
			{
				return $this->userDetails['new_requests'];
			}

		/**
		 * IndexPageHandler::getProfileViewCounts()
		 *
		 * @return integer
		 */
		public function getProfileViewCounts()
			{
				return $this->userDetails['profile_hits'];
			}

		/**
		 * IndexPageHandler::getLastLoggedTime()
		 *
		 * @return string
		 */

		public function getLastLoggedTime()
			{
				return $this->userDetails['last_logged'];
			}

		/**
		 * IndexPageHandler::showUpgradeMembershipButton()
		 *
		 * @return
		 */
		public function showUpgradeMembershipButton()
			{
				return ($this->CFG['feature']['membership_payment'] AND !isPaidMember());
			}

		/**
		 * IndexPageHandler::showTotalMembersInUsersNetwork()
		 *
		 * @return integer
		 */
		public function showTotalMembersInUsersNetwork()
			{
				$count = 0;
				$sql = 'SELECT COUNT(user_id) AS cnt FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE usr_status=\'Ok\'';

	            $stmt = $this->dbObj->Prepare($sql);
	            $rs = $this->dbObj->Execute($stmt);
                if (!$rs)
            	    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
				    {
				        $row = $rs->FetchRow();
						$count = $row['cnt'];
				    }
		        //$count = $count - 1;
				$count = number_format($count);
				return $count;
			}

		/**
		 * IndexPageHandler::getTotalComments()
		 *
		 * @return integer
		 */
		public function getTotalComments()
			{
				$sql = 'SELECT COUNT(profile_user_id) AS cnt FROM '.$this->CFG['db']['tbl']['users_profile_comments'].
						' WHERE profile_user_id='.$this->dbObj->Param($this->CFG['user']['user_id']);
	            $stmt = $this->dbObj->Prepare($sql);
	            $rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
                if (!$rs)
            	    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
				    {
				        $row = $rs->FetchRow();
						$count = $row['cnt'];
				    }
				$count = number_format($count);
				return $count;
			}

		/**
		 * IndexPageHandler::upcomingBirthdayList()
		 * retrieves the list of the logged in users friends whose dob falls in the next 30 days
		 *
		 * @return void
		 */
		public function upcomingBirthdayList()
			{
				global $smartyObj;
				$upcomingBirthdayList_arr = array();
				//if the birthday is today or tomorrow, show in text as Today instead of the date ..
				$show_today_tomorrow = true;

				$user_id = $this->CFG['user']['user_id'];
				$dateCondition = 'DATEDIFF(DATE_FORMAT(dob, concat(year(curdate()), "-%m-%d")), curdate()) BETWEEN 0 AND 30 OR DATEDIFF(DATE_FORMAT(dob,concat((year(curdate()) + 1),"-%m-%d")), curdate()) BETWEEN 0 AND 30';

				$sqlCondition =  'users_tbl.usr_status= \'Ok\' AND friends_tbl.owner_id='.$user_id.' '.
								  'AND users_tbl.user_id = friends_tbl.friend_id AND '.$dateCondition;

				$returnFields = 'dob as dob, DATE_FORMAT(dob, "%d %m") as dob_comp, friends_tbl.id AS friendship_id, '.
								'friends_tbl.friend_id AS friend_id, users_tbl.user_id, users_tbl.user_name AS friend_name, '.
								'users_tbl.icon_id AS icon_id, users_tbl.icon_type AS icon_type,'.
								'users_tbl.image_ext AS image_ext, users_tbl.first_name, users_tbl.last_name, '.
								'(users_tbl.logged_in='.$user_id.' AND DATE_SUB(NOW(), INTERVAL 20 SECOND) < users_tbl.last_active) AS logged_in,'.
								'friends_tbl.id AS relation_id, users_tbl.sex AS sex';

				$sql = 'SELECT '.$returnFields.' FROM '.$this->CFG['db']['tbl']['friends_list'].' AS friends_tbl, '.$this->CFG['db']['tbl']['users'].' AS users_tbl'.
						' WHERE '.$sqlCondition.
						' ORDER BY DATE_FORMAT(dob,"%m-%d") ASC'.
						' LIMIT 0,'.$this->CFG['admin']['myhome']['total_upcoming_birthdays'];
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$upcomingBirthdayList_arr['row'] = array();
				$inc = 0;
				$today = date('d').' '.date('m');
				$tomorrow  = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
				$tomorrow = date('d', $tomorrow).' '.date('m', $tomorrow);
				if ($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$upcomingBirthdayList_arr['row'][$inc]['icon'] = getMemberAvatarDetails($row['user_id']);
								$upcomingBirthdayList_arr['row'][$inc]['display_name'] = $row['friend_name'];
								if($this->CFG['admin']['display_first_last_name'])
									$upcomingBirthdayList_arr['row'][$inc]['display_name'] = $row['first_name'].' '.$row['last_name'];
								if($show_today_tomorrow)
									{
										if($row['dob_comp'] == $today)
											$row['dob'] = $this->LANG['myhome_upcoming_birthdays_today'];
										elseif ($row['dob_comp'] == $tomorrow)
											$row['dob'] = $this->LANG['myhome_upcoming_birthdays_tomorrow'];
										else
											$row['dob_comp'] = '';
									}
								$upcomingBirthdayList_arr['row'][$inc]['online'] = ($row['logged_in'])? $this->CFG['admin']['members']['online_anchor_attributes']: $this->CFG['admin']['members']['offline_anchor_attributes'];
								$upcomingBirthdayList_arr['row'][$inc]['friendProfileUrl'] = getMemberProfileUrl($row['friend_id'], $row['friend_name']);
								$upcomingBirthdayList_arr['row'][$inc]['record'] = $row;
								$inc++;
							}
					}
				$smartyObj->assign('upcomingBirthdayList_arr', $upcomingBirthdayList_arr);
			}

		/**
		 * IndexPageHandler::myHomeActivity()
		 *
		 * @return void
		 */
		public function myHomeActivity($totRecords = 5)
			{
				global $smartyObj;
				setTemplateFolder('members/');
				$smartyObj->assign('activitiesView', $totRecords);
				$smartyObj->display('myHomeActivity.tpl');
			}

		/**
		 * IndexPageHandler::populateAnnouncement()
		 *
		 * @return void
		 */
		public function populateAnnouncement()
			{
				global $smartyObj;
				$populateAnnouncement_arr;

				$sql = 'SELECT description'.
						' FROM '.$this->CFG['db']['tbl']['announcement'].
						' WHERE status = \'Yes\''.
						' AND from_date <= NOW()'.
						' AND to_date >= NOW()'.
						' ORDER BY from_date DESC';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$populateAnnouncement_arr['row'] = array();
				$this->announcement_recordCount = $rs->PO_RecordCount();
				if($rs->PO_RecordCount())
					{
						$inc = 0;
						while($row = $rs->FetchRow())
							{
								$populateAnnouncement_arr['row'][$inc]['description'] = html_entity_decode($row['description']);
								$inc++;
							}
					}
				$smartyObj->assign('populateAnnouncement_arr', $populateAnnouncement_arr);
			}
	}
//<<<<<---------------class IndexPageHandler------///
//--------------------Code begins-------------->>>>>//
$index = new IndexPageHandler();
$index->setFormField('activity_type', '');
$index->setFormField('action', '');
$index->setFormField('suggestion_id', '');

$index->updateUserDetailsInSession();
$index->setFormField('user_id', $CFG['user']['user_id']);
$index->isPaidMember=isPaidMember();
$limit = 10; // Set Total Activities
if(isAjaxPage())
	{
		$index->sanitizeFormInputs($_REQUEST);

		if($index->getFormField('action') == 'friend_suggestion' AND $index->getFormField('suggestion_id'))
			{
				$index->includeAjaxHeaderSessionCheck();
				$index->deleteFriendSuggestion($index->getFormField('suggestion_id'));
				$index->getFriendSuggestion();
				exit;
			}
		elseif($index->getFormField('activity_type'))
			{
				$activity_view_all_url = getUrl('activity', '?pg='.strtolower($index->getFormField('activity_type')), strtolower($index->getFormField('activity_type')).'/updates/', 'members');
				$smartyObj->assign('activity_view_all_url', $activity_view_all_url);
				switch($index->getFormField('activity_type'))
					{
						case 'my':
							$index->setCommonErrorMsg($LANG['myhome_my_recent_activities_no_records']);;
							break;
						default:
							$index->setCommonErrorMsg($LANG['myhome_recent_activities_no_records']);
						break;
					}
				$Activity = new ActivityHandler();
				$Activity->setActivityType($index->getFormField('activity_type'),'',$limit);
				$index->includeAjaxHeaderSessionCheck();
				$index->myHomeActivity($limit);
				exit;
			}
	}

$index->CFG['admin']['carousel'] = true;

if($CFG['admin']['show_recent_activities'])
	{
		$index->show_recent_activities['friends_url'] = getUrl('myhome', '?ajax_page=true&amp;activity_type=friends');
		$Activity = new ActivityHandler();
		if($CFG['admin']['myhome']['recent_activity_default_content'] == 'Friends')
			{
				if($index->userDetails['total_friends'])
					$Activity->setActivityType('friends','',$limit);
			}
		else
			$Activity->setActivityType(strtolower($CFG['admin']['myhome']['recent_activity_default_content']),'',$limit);

		$activity_view_all_url = getUrl('activity', '?pg='.strtolower($CFG['admin']['myhome']['recent_activity_default_content']), strtolower($CFG['admin']['myhome']['recent_activity_default_content']).'/updates/', 'members');
		$smartyObj->assign('activity_view_all_url', $activity_view_all_url);
	}

$totalVideoCount = $index->getTotalVideos();
$totalFriendsCount = $index->getTotalFriendsNew();

//<<<<--------------------Code Ends----------------------//
if($index->CFG['admin']['myhome']['show_profile_hi'])
	{
		$index->profile = $index->getUserDetail('user_id', $CFG['user']['user_id']);
		$index->icon = getMemberAvatarDetails($CFG['user']['user_id']);
		$index->myprofile_url = getUrl('myprofile');

		$index->site_name = str_replace('VAR_SITE_NAME', $CFG['site']['title'], $LANG['myhome_user_rayzz_url']);

	    $index->profile_url = $index->getAffiliateUrl($CFG['user']['rayzz_url']);
	    $index->profile_url_wbr = wordWrap_mb_ManualWithSpace($index->profile_url, 40);
	}

if($CFG['admin']['myhome']['show_shortcuts'])
	{
		$index->myshortcuts_arr['viewprofile_url'] = getUrl('myprofile', '', '', 'members');

		$shortcutmodule_arr = array();
		$inc=0;
		foreach($CFG['site']['modules_arr'] as $value)
			{
				if(chkAllowedModule(array(strtolower($value))))
					{
						$shortcutmodule_arr[$value] = $value.'_myhome_shortcuts_arr';
						$funtion_name = 'getMyHome'.ucfirst($value).'Shortcuts';
						$shortcutmodule_arr[$value]='';
						if(function_exists($funtion_name))
							$shortcutmodule_arr[$value] = $funtion_name();
						$inc++;
					}
			}
		$index->myshortcuts_arr['shortcut_module_arr'] = $shortcutmodule_arr;
		$index->myshortcuts_arr['is_shortcut_module'] = false;
		if($inc > 0)
			$index->myshortcuts_arr['is_shortcut_module'] = true;
	}

if($CFG['admin']['myhome']['show_stats'])
	{
		$index->show_stats_arr = array();
		$inc = 0;
        foreach ($CFG['site']['modules_arr'] as $key=>$value)
        	{
    			if($value != 'discussions' AND chkAllowedModule(array(strtolower($value))))
    				{
	                	$funtion_name='getTotal'.ucfirst($value).'s';
	                	if(function_exists($funtion_name))
	                		{
	                			$index->show_stats_arr[$inc]['module'] = $value.'s';
	                			$index->show_stats_arr[$inc]['stats_value'] = $funtion_name();
								$index->show_stats_arr[$inc]['lang_value'] = $LANG['myhome_total_'.$value.'s'];
			                	$index->show_stats_arr[$inc]['chkmodule'] = chkAllowedModule(array($index->show_stats_arr[$inc]['module']));
								$inc++;
							}
					}
        	}
	}

if($CFG['admin']['myhome']['upcoming_birthdays'])
	{
		$index->upcomingBirthdayList();
	}

if($CFG['admin']['myhome']['show_profile_visitors'])
	{
		$index->displayMyProfileVisitors();
	}

if($CFG['admin']['myhome']['show_friend_suggestions'])
	{
		$index->populateFriendSuggestions();
	}
if($CFG['admin']['myhome']['show_announcement'])
	{
		$index->populateAnnouncement();
	}

//include the header file
$index->includeHeader();
//include the content of the page
?>
<script language="javascript" type="text/javascript">
	<?php if($CFG['admin']['show_recent_activities']) { ?>
		var show_div = 'selActivity<?php echo $CFG['admin']['myhome']['recent_activity_default_content']; ?>Content';
		var more_tabs_div = new Array('selActivityFriendsContent', 'selActivityMyContent', 'selActivityAllContent');
		var more_tabs_class = new Array('selHeaderActivityFriends', 'selHeaderActivityMy', 'selHeaderActivityAll');
		//var hide_ajax_tabs = new Array('flag_content_tab', 'favorite_content_tab', 'email_content_tab');
		var current_active_tab_class = 'clsActiveMoreVideosNavLink';

		$Jq(document).ready(function(){
			//To Show the default div and hide the other divs
			hideMoreTabsDivs(show_div); //To hide the more tabs div and set the class to empty
			showMoreTabsDivs(show_div); //To show the more tabs div and set the class to selected
		});
	<?php } ?>

	var loader = new Image;
	var empty = new Image;
	loader.src = '<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/images/loadingGraphic.gif';
	empty.src = '<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/images/pixel.gif';
	function gotolocation(url) {
		location=url;
	}
	var no_friendSuggestions_msg = '<li class="clsNoListDatas"><?php echo $LANG['myhome_friends_suggestion_no_records'];?></li>';
	var no_friendSuggestions_class = 'clsNoListDatas';
</script>
<?php
//SET ANNOUNCMENT BLOCK HEIGHT
$index->announcment_height = 250;
setTemplateFolder('members/');
$smartyObj->display('myHome.tpl');
if($index->announcement_recordCount)
	{
?>
<script language="javascript" type="text/javascript">
	var announcement_height = <?php echo $index->announcment_height; ?>;
	var boxHeight = '';
	var repeatHeight = '';
	$Jq(document).ready(function(){
		boxHeight = $Jq('#announcement_content').height();
		repeatHeight = $Jq('#announcement_content')[0].scrollHeight; //get the current height so we know when to wrap

  	    //add a second copy so we can scroll down to the wrap point
		if(repeatHeight > announcement_height) {
			$Jq('#announcement_content').html($Jq('#announcement_content').html() + $Jq('#announcement_content').html());
			$Jq('#announcement_controls').show();
		}
	});
	var stopScroll = 0;
	var x;
	function scrollMe() {
		clearTimeout(x);
		if(stopScroll==1) {
			return;
		}
		$Jq('#announcement_content').scrollTop($Jq('#announcement_content').scrollTop()+1);
		if($Jq('#announcement_content').scrollTop()<=repeatHeight) {
			// keep on scrolin'
			x = setTimeout("scrollMe()",40);
		} else { //we have hit the wrap point
			$Jq('#announcement_content').scrollTop(0);
			x = setTimeout("scrollMe()",40);
		}
	}

	function scrollBack() {
		clearTimeout(x);
		if(stopScroll==1) {
			return;
		}
		$Jq('#announcement_content').scrollTop($Jq('#announcement_content').scrollTop() - 1);
		if($Jq('#announcement_content').scrollTop()<=repeatHeight) {
			// keep on scrolin'
			x = setTimeout("scrollBack()",40);
		} else { //we have hit the wrap point
			$Jq('#announcement_content').scrollTop(0);
			x = setTimeout("scrollBack()",40);
		}
	}
	$Jq(document).ready(function(){
		// start scrolling after one second
		x = setTimeout("scrollMe()",10000);
	});
</script>
<?php
	}
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$index->includeFooter();
?>