<?php
/**
 * Class to handle the General Activities module
 *
 * This is having class GeneralActivity to handle
 *
 *
 * @category	Rayzz
 * @package		Common/Classes
 */
//------------------- Class GeneralActivityHandler begins ------------------->>>>>//
class GeneralActivityHandler
	{

		private $dbObj;

		private $CFG = array();

		private $LANG = array();

		public function __construct()
			{
				global $CFG, $LANG, $db;
				$this->dbObj 	= $db;
				$this->CFG 		= $CFG;
				$this->LANG 	= $LANG;
			}

		/**
		 * GeneralActivityHandler::addActivity()
		 *  To add general activities
		 *
		 * @param array $activity_arr
		 * @return void
		 */
		public function addActivity($activity_arr)
			{
				switch($activity_arr['action_key'])
					{
						case 'new_member':
								/*	$activity_arr =>
										action_key
										user_id
										username
										doj (date of joining)
								*/

								$action_value = $activity_arr['user_id'].'~'.
												$activity_arr['user_name'].'~'.
												$activity_arr['doj'];

								$activity_val_arr = array($activity_arr['user_id'],
															$activity_arr['user_id']);

								$general_activity_val_arr = array($activity_arr['user_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['user_id'],
																$activity_arr['user_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'general\','.
										' owner_id = '.$this->dbObj->Param('owner_id').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['general_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('owner_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);

								$rs = $this->dbObj->Execute($stmt, $general_activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$child_id = $this->dbObj->Insert_ID();

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
										' SET child_id = '.$child_id.
										' WHERE parent_id = '.$parent_id;

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);

							break;

						case 'new_member_by_admin':
								/*	$activity_arr =>
										action_key
										admin_id
										actor_id
										doj (date of activation)
								*/

								$action_value = $activity_arr['admin_id'].'~'.
												$activity_arr['actor_id'].'~'.
												$activity_arr['doj'];

								$activity_val_arr = array($activity_arr['admin_id'],
															$activity_arr['actor_id']);

								$general_activity_val_arr = array($activity_arr['admin_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['actor_id'],
																$activity_arr['admin_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'general\','.
										' owner_id = '.$this->dbObj->Param('admin_id').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['general_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('admin_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);

								$rs = $this->dbObj->Execute($stmt, $general_activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$child_id = $this->dbObj->Insert_ID();

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
										' SET child_id = '.$child_id.
										' WHERE parent_id = '.$parent_id;

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);

							break;

						case 'be_friended':
								/*	$activity_arr =>
										action_key
										owner_id
										friend_id
										content_id (friend_list id)
								*/

								$action_value = $activity_arr['owner_id'].'~'.
												$activity_arr['friend_id'];

								$activity_val_arr = array($activity_arr['owner_id'],
															$activity_arr['friend_id']);

								$general_activity_val_arr = array($activity_arr['content_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['owner_id'],
																$activity_arr['friend_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'general\','.
										' owner_id = '.$this->dbObj->Param('owner_id').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['general_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('owner_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);

								$rs = $this->dbObj->Execute($stmt, $general_activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$child_id = $this->dbObj->Insert_ID();

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
										' SET child_id = '.$child_id.
										' WHERE parent_id = '.$parent_id;

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);

							break;

						case 'new_scrap':
								/*	$activity_arr =>
										action_key
										owner_id
										actor_id
										profile_comment_id
										username
								*/

								$action_value = $activity_arr['owner_id'].'~'.
												$activity_arr['user_name'];

								$sql = 'SELECT parent_id, id'.
										' FROM '.$this->CFG['db']['tbl']['general_activity'].
										' WHERE owner_id = '.$this->dbObj->Param('owner_id').
										' AND actor_id = '.$this->dbObj->Param('actor_id').
										' AND action_key = '.$this->dbObj->Param('action_key');

								$stmt = $this->dbObj->Prepare($sql);

								$rs = $this->dbObj->Execute($stmt, array($activity_arr['owner_id'], $activity_arr['actor_id'],
															$activity_arr['action_key']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);

								if ($rs->PO_RecordCount())
									{
										$row = $rs->FetchRow();

										$activity_val_arr = array($row['parent_id'],
																$row['id'],
																$activity_arr['owner_id']);

										$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
												' SET date_added = NOW()'.
												' WHERE parent_id = '.$this->dbObj->Param('parent_id').
												' AND child_id = '.$this->dbObj->Param('child_id').
												' AND module=\'general\''.
												' AND owner_id = '.$this->dbObj->Param('owner_id');

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
										if (!$rs)
											trigger_db_error($this->dbObj);

										$parent_id = $this->dbObj->Insert_ID();

										$sql = 'UPDATE '.$this->CFG['db']['tbl']['general_activity'].
												' SET date_added = NOW()'.
												' WHERE parent_id = '.$this->dbObj->Param('parent_id').
												' AND id = '.$this->dbObj->Param('child_id').
												' AND owner_id = '.$this->dbObj->Param('owner_id');

										$stmt = $this->dbObj->Prepare($sql);

										$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
										if (!$rs)
											trigger_db_error($this->dbObj);
									}
								else
									{
										$activity_val_arr = array($activity_arr['owner_id'],
															$activity_arr['actor_id']);

										$general_activity_val_arr = array($activity_arr['profile_comment_id'],
																		$activity_arr['action_key'],
																		$action_value,
																		$activity_arr['actor_id'],
																		$activity_arr['owner_id']);

										$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
												' SET module = \'general\','.
												' owner_id = '.$this->dbObj->Param('owner_id').','.
												' actor_id = '.$this->dbObj->Param('actor_id').','.
												' date_added = NOW()';

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
										if (!$rs)
											trigger_db_error($this->dbObj);

										$parent_id = $this->dbObj->Insert_ID();

										$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['general_activity'].
												' SET parent_id = '.$parent_id.','.
												' content_id = '.$this->dbObj->Param('content_id').','.
												' action_key = '.$this->dbObj->Param('action_key').','.
												' action_value = '.$this->dbObj->Param('action_value').','.
												' actor_id = '.$this->dbObj->Param('actor_id').','.
												' owner_id = '.$this->dbObj->Param('owner_id').','.
												' date_added = NOW()';

										$stmt = $this->dbObj->Prepare($sql);

										$rs = $this->dbObj->Execute($stmt, $general_activity_val_arr);
										if (!$rs)
											trigger_db_error($this->dbObj);

										$child_id = $this->dbObj->Insert_ID();

										$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
												' SET child_id = '.$child_id.
												' WHERE parent_id = '.$parent_id;

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt);
										if (!$rs)
											trigger_db_error($this->dbObj);
									}

							break;

						case 'subscribed':
								/*	$activity_arr =>
										action_key
										owner_id
										subscriber_id
										content_id (friend_list id)
								*/

								$action_value = $activity_arr['subscriber_id'].'~'.
												$activity_arr['owner_id'];

								$activity_val_arr = array($activity_arr['owner_id'],
															$activity_arr['subscriber_id']);

								$general_activity_val_arr = array($activity_arr['content_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['owner_id'],
																$activity_arr['subscriber_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'general\','.
										' owner_id = '.$this->dbObj->Param('owner_id').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['general_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('owner_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);

								$rs = $this->dbObj->Execute($stmt, $general_activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$child_id = $this->dbObj->Insert_ID();

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
										' SET child_id = '.$child_id.
										' WHERE parent_id = '.$parent_id;

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);

							break;

						case 'unsubscribed':
								/*	$activity_arr =>
										action_key
										owner_id
										subscriber_id
										content_id (friend_list id)
								*/

								$sql = 'SELECT parent_id FROM '.$this->CFG['db']['tbl']['general_activity'].
										' WHERE action_key= \'subscribed\' AND actor_id= '.$activity_arr['owner_id'].' '.
										' AND owner_id= '.$activity_arr['subscriber_id'].' AND  content_id='.$activity_arr['content_id'];

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);

								if($row = $rs->FetchRow())
									{
										$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
												' SET status = \'Deleted\' '.
												' WHERE parent_id= '.$row['parent_id'];

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt);
										if (!$rs)
											trigger_db_error($this->dbObj);

										$sql = 'UPDATE '.$this->CFG['db']['tbl']['general_activity'].
												' SET status = \'Deleted\' '.
												' WHERE action_key= \'subscribed\' AND actor_id= '.
												$activity_arr['owner_id'].' '.
												' AND owner_id= '.$activity_arr['subscriber_id'].
												' AND  content_id= '.$activity_arr['content_id'];

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt);
										if (!$rs)
											trigger_db_error($this->dbObj);
									}
							break;
					}


			}

		/**
		 * GeneralActivityHandler::getActivities()
		 *  To get activity details from geral_activity table
		 *
		 * @param array $activityID_arr
		 * @return void
		 */
		public function getActivities($activityID_arr)
			{
				$getActivities_arr = array();
				$inc = 0;
				$activityIDs = implode(',', $activityID_arr);

				$sql = 'SELECT content_id, action_key, action_value, owner_id, NOW() as date_current,'.
						' actor_id, parent_id FROM '.$this->CFG['db']['tbl']['general_activity'].
						' WHERE status=\'Yes\' AND id IN ('.$activityIDs.')	AND (SELECT usr_status FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_id = owner_id) = \'Ok\' AND ( SELECT usr_status FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_id = actor_id) = \'Ok\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow()) //if($row = $rs->FetchRow())
						    {
								$getActivities_arr[] = $row;
	 					    }
	 					$inc++;
					}
				$this->generateActivities($getActivities_arr);
			}

		/**
		 * GeneralActivityHandler::generateActivities()
		 *  To generate activities for different actions
		 *
		 * @param array $activity_arr
		 * @return void
		 */
		public function generateActivities($activity_arr)
			{
				global $smartyObj;
				$generateActivities_arr = array();

				require_once('./languages/'.$this->CFG['lang']['default'].'/general/generalActivity.php');

				for($i=0;$i<count($activity_arr);$i++)
					{
						$generateActivities_arr[$i]['action_key'] = $activity_arr[$i]['action_key'];
						$generateActivities_arr[$i]['parent_id'] = $activity_arr[$i]['parent_id'];
						$generateActivities_arr[$i]['date_current'] = $date_current = $activity_arr[$i]['date_current'];
						switch($activity_arr[$i]['action_key'])
							{
								case 'be_friended':
									/*
										action_value => user_id1~user_id2
									*/
									$generateActivities_arr[$i]['be_friended'] = array();
									$value = explode('~', $activity_arr[$i]['action_value']);
									$user1_details = getUserDetail('user_id', $value[0]);
									$user2_details = getUserDetail('user_id', $value[1]);

									if(!empty($user1_details) AND !empty($user2_details))
										{
											$generateActivities_arr[$i]['be_friended']['user1']['icon'] = getMemberAvatarDetails($value[0]);
											$generateActivities_arr[$i]['be_friended']['user2']['icon'] = getMemberAvatarDetails($value[1]);
											if($this->CFG['admin']['display_first_last_name'])
												{
													$generateActivities_arr[$i]['be_friended']['user1']['name'] = $user1_details['first_name'].' '.$user1_details['last_name'];
													$generateActivities_arr[$i]['be_friended']['user2']['name'] = $user2_details['first_name'].' '.$user2_details['last_name'];
												}
											else
												{
													$generateActivities_arr[$i]['be_friended']['user1']['name'] = $user1_details['user_name'];
													$generateActivities_arr[$i]['be_friended']['user2']['name'] = $user2_details['user_name'];
												}
											$generateActivities_arr[$i]['be_friended']['user1']['url'] = getMemberProfileUrl($value[0], $user1_details['user_name']);
											$generateActivities_arr[$i]['be_friended']['user2']['url'] = getMemberProfileUrl($value[1], $user2_details['user_name']);
											$generateActivities_arr[$i]['be_friended']['lang'] = $LANG['generalactivity_be_friended'];
											$generateActivities_arr[$i]['be_friended']['hasfriend'] = $LANG['generalactivity_be_friend'];
										}
									break;

								case 'new_member':
									$generateActivities_arr[$i]['new_member'] = array();
									$value = explode('~', $activity_arr[$i]['action_value']);
									$generateActivities_arr[$i]['new_member']['user_url'] = getMemberProfileUrl($value[0], $value[1]);
									$user_details = getUserDetail('user_id', $value[0]);
									if(!empty($user_details))
										{
											$generateActivities_arr[$i]['new_member']['icon'] = getMemberAvatarDetails($value[0]);
											if($this->CFG['admin']['display_first_last_name'])
												{
													$generateActivities_arr[$i]['new_member']['name'] = $user_details['first_name'].' '.$user_details['last_name'];
												}
											else
												{
													$generateActivities_arr[$i]['new_member']['name'] = $user_details['user_name'];
												}
											$generateActivities_arr[$i]['new_member']['date'] = $value[2];
											$generateActivities_arr[$i]['new_member']['lang'] = $LANG['generalactivity_new_member'];
											$generateActivities_arr[$i]['new_member']['date_added'] = getTimeDiffernceFormat(getDateTimeDiff($value[2],$date_current));
										}
									break;

								case 'new_member_by_admin':
									$generateActivities_arr[$i]['new_member_by_admin'] = array();
									$value = explode('~', $activity_arr[$i]['action_value']);
									$user_details = getUserDetail('user_id', $value[0]);
									$user1_details = getUserDetail('user_id', $value[1]);
									$generateActivities_arr[$i]['new_member_by_admin']['admin_url'] = getMemberProfileUrl($value[0], $user_details['user_name']);
									$generateActivities_arr[$i]['new_member_by_admin']['user_url'] = getMemberProfileUrl($value[1], $user1_details['user_name']);
									if(!empty($user_details))
										{
											$generateActivities_arr[$i]['new_member_by_admin']['admin_icon'] = getMemberAvatarDetails($value[0]);
											$generateActivities_arr[$i]['new_member_by_admin']['user_icon'] = getMemberAvatarDetails($value[1]);
											if($this->CFG['admin']['display_first_last_name'])
												{
													$generateActivities_arr[$i]['new_member_by_admin']['admin_name'] = $user_details['first_name'].' '.$user_details['last_name'];
													$generateActivities_arr[$i]['new_member_by_admin']['user_name'] = $user1_details['first_name'].' '.$user1_details['last_name'];
												}
											else
												{
													$generateActivities_arr[$i]['new_member_by_admin']['admin_name'] = $user_details['user_name'];
													$generateActivities_arr[$i]['new_member_by_admin']['user_name'] = $user1_details['user_name'];
												}
											$generateActivities_arr[$i]['new_member_by_admin']['date'] = $user1_details['doj'];
											$generateActivities_arr[$i]['new_member_by_admin']['lang1'] = $LANG['generalactivity_new_member_by_admin'];
											$generateActivities_arr[$i]['new_member_by_admin']['lang2'] = $LANG['generalactivity_new_member_by_admin_account'];
											$generateActivities_arr[$i]['new_member_by_admin']['lang3'] = $LANG['generalactivity_new_member'];
											$generateActivities_arr[$i]['new_member_by_admin']['date_added'] = getTimeDiffernceFormat(getDateTimeDiff($user1_details['doj'],$date_current));
										}
									break;

								case 'new_scrap':
									$generateActivities_arr[$i]['new_scrap'] = array();
									$value = explode('~', $activity_arr[$i]['action_value']);
									$generateActivities_arr[$i]['new_scrap']['user_url'] = getMemberProfileUrl($value[0], $value[1]);
									$user_details = getUserDetail('user_id', $value[0]);
									$actor_details = getUserDetail('user_id', $activity_arr[$i]['actor_id']);
									if(!empty($user_details))
										{
											$generateActivities_arr[$i]['new_scrap']['icon'] = getMemberAvatarDetails($value[0]);
											if($this->CFG['admin']['display_first_last_name'])
												{
													$generateActivities_arr[$i]['new_scrap']['name'] = $user_details['first_name'].' '.$user_details['last_name'];
													$actor_name = $actor_details['first_name'].' '.$actor_details['last_name'];
												}
											else
												{
													$generateActivities_arr[$i]['new_scrap']['name'] = $user_details['user_name'];
													$actor_name = $actor_details['user_name'];
												}
											$actor_link = '<a href="'.getMemberProfileUrl($activity_arr[$i]['actor_id'], $actor_details['user_name']).'">'.$actor_name.'</a>';
											$generateActivities_arr[$i]['new_scrap']['lang'] = $LANG['generalactivity_new_scrap'];
											$generateActivities_arr[$i]['new_scrap']['lang'] = str_ireplace('VAR_OWNER', $actor_link, $generateActivities_arr[$i]['new_scrap']['lang']);
										}
									break;
								case 'subscribed':
									/*
										action_value => user_id1~user_id2
									*/
									$generateActivities_arr[$i]['subscribed'] = array();
									$value = explode('~', $activity_arr[$i]['action_value']);
									$user1_details = getUserDetail('user_id', $value[0]);
									$user2_details = getUserDetail('user_id', $value[1]);
									if(!empty($user1_details) AND !empty($user2_details))
										{
											$generateActivities_arr[$i]['subscribed']['user1']['icon'] = getMemberAvatarDetails($value[0]);
											$generateActivities_arr[$i]['subscribed']['user2']['icon'] = getMemberAvatarDetails($value[1]);
											if($this->CFG['admin']['display_first_last_name'])
												{
													$generateActivities_arr[$i]['subscribed']['user1']['name'] = $user1_details['first_name'].' '.$user1_details['last_name'];
													$generateActivities_arr[$i]['subscribed']['user2']['name'] = $user2_details['first_name'].' '.$user2_details['last_name'];
												}
											else
												{
													$generateActivities_arr[$i]['subscribed']['user1']['name'] = $user1_details['user_name'];
													$generateActivities_arr[$i]['subscribed']['user2']['name'] = $user2_details['user_name'];
												}
											$generateActivities_arr[$i]['subscribed']['user1']['url'] = getMemberProfileUrl($value[0], $user1_details['user_name']);
											$generateActivities_arr[$i]['subscribed']['user2']['url'] = getMemberProfileUrl($value[1], $user2_details['user_name']);
											$generateActivities_arr[$i]['subscribed']['lang'] = $LANG['generalactivity_subscribed'];
										}
									break;
							}

					}

				$smartyObj->assign('generalActivity_arr', $generateActivities_arr);
			}
	}
?>