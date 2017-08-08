<?php
/**
 * Class to handle the General Activities module
 *
 * This is having class GeneralActivity to handle
 *
 *
 * @category	Discuzz
 * @package		Common/Classes
 */
//------------------- Class DiscussionsActivityHandler begins ------------------->>>>>//
if(class_exists('ListRecordsHandler'))
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
			class ActivityHandlers extends ListRecordsHandler{}
			break;
		case 1:
			class ActivityHandlers extends FormHandler{}
			break;
	}
class DiscussionsActivityHandler extends ActivityHandlers
	{
		/**
		 * DiscussionsActivityHandler::addActivity()
		 *  To add general activities
		 *
		 * @param array $activity_arr
		 * @return void
		 */
		public function addActivity($activity_arr)
			{
				switch($activity_arr['action_key'])
					{
						case 'new_discussion':
						case 'publish_discussion':
								$activity_val_arr = array($activity_arr['owner_id'],
															$activity_arr['actor_id']);
								$action_value = $activity_arr['discussion_id'].'~'.
												$activity_arr['owner_id'];
								$discussion_activity_val_arr = array($activity_arr['discussion_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['actor_id'],
																$activity_arr['owner_id']);
							break;
						case 'new_board':
						case 'board_edited':
						case 'publish_board':
								$activity_val_arr = array($activity_arr['owner_id'],
															$activity_arr['actor_id']);
								$action_value = $activity_arr['board_id'].'~'.
												$activity_arr['actor_id'];
								$discussion_activity_val_arr = array($activity_arr['board_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['actor_id'],
																$activity_arr['owner_id']);
							break;
						case 'new_solution':
						case 'solution_edited':
						case 'publish_solution':
								$activity_val_arr = array($activity_arr['owner_id'],
															$activity_arr['actor_id']);
								$action_value = $activity_arr['solution_id'].'~'.
												$activity_arr['owner_id'];
								$discussion_activity_val_arr = array($activity_arr['solution_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['actor_id'],
																$activity_arr['owner_id']);
							break;
						case 'best_solution':
						case 'best_solution_changed':
						case 'remove_bestsolution':
								$activity_val_arr = array($activity_arr['owner_id'],
															$activity_arr['actor_id']);
								$action_value = $activity_arr['solution_id'].'~'.
												$activity_arr['actor_id'];
								$discussion_activity_val_arr = array($activity_arr['solution_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['actor_id'],
																$activity_arr['owner_id']);
							break;
						case 'friend_accepted':
						case 'friend_rejected':
						case 'request_added':
						case 'request_removed':
						case 'friend_removed':
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

								$discussion_activity_val_arr = array($activity_arr['content_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['friend_id'],
																$activity_arr['owner_id']);
							break;
						case 'user_blocked':
						case 'remove_blocked':
								/*	$activity_arr =>
										action_key
										owner_id
										blocker_id
										content_id (blocker id)
								*/
								$action_value = $activity_arr['owner_id'].'~'.
												$activity_arr['blocker_id'];

								$activity_val_arr = array($activity_arr['owner_id'],
															$activity_arr['blocker_id']);

								$discussion_activity_val_arr = array($activity_arr['content_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['blocker_id'],
																$activity_arr['owner_id']);
							break;
						case 'subscribed':
						case 'unsubscribed':
								/*	$activity_arr =>
										action_key
										owner_id
										actor_id
								*/
								$action_value = $activity_arr['owner_id'].'~'.
												$activity_arr['actor_id'];

								$activity_val_arr = array($activity_arr['owner_id'],
															$activity_arr['actor_id']);

								$discussion_activity_val_arr = array($activity_arr['owner_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['actor_id'],
																$activity_arr['owner_id']);
							break;
					}

					if($activity_arr['action_key'])
						{
							$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
									' SET module = \'discussions\','.
									' owner_id = '.$this->dbObj->Param('owner_id').','.
									' actor_id = '.$this->dbObj->Param('actor_id').','.
									' date_added = NOW()';

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
							if (!$rs)
								trigger_error($this->dbObj->ErrorNo().' '.
									$this->dbObj->ErrorMsg(), E_USER_ERROR);

							$parent_id = $this->dbObj->Insert_ID();

							$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['discussions_activity'].
									' SET parent_id = '.$parent_id.','.
									' content_id = '.$this->dbObj->Param('content_id').','.
									' action_key = '.$this->dbObj->Param('action_key').','.
									' action_value = '.$this->dbObj->Param('action_value').','.
									' actor_id = '.$this->dbObj->Param('actor_id').','.
									' owner_id = '.$this->dbObj->Param('owner_id').','.
									' date_added = NOW()';

							$stmt = $this->dbObj->Prepare($sql);

							$rs = $this->dbObj->Execute($stmt, $discussion_activity_val_arr);
							if (!$rs)
								trigger_error($this->dbObj->ErrorNo().' '.
									$this->dbObj->ErrorMsg(), E_USER_ERROR);

							$child_id = $this->dbObj->Insert_ID();

							$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
									' SET child_id = '.$child_id.
									' WHERE parent_id = '.$parent_id;

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt);
							if (!$rs)
								trigger_error($this->dbObj->ErrorNo().' '.
									$this->dbObj->ErrorMsg(), E_USER_ERROR);
						}
			}

		public function populateActivities($num_records=0, $module, $user_id = '')
			{
				global $smartyObj;
				$populateActivities_arr = array();
				$module_arr = array();

				$interval_by = 'day';

				$condition = 'AND DATE_FORMAT( date_added, \'%Y-%m-%d\' ) >'.
								' DATE_SUB(CURDATE(), INTERVAL '.
									$this->CFG['admin']['index']['activity']['show_days'].' '.
									$interval_by.') ';
				//$condition = '';
				if($user_id == 'all')
					{
						/*$condition = 'AND owner_id NOT IN ('.$this->CFG['user']['user_id'].')'.
										' AND actor_id NOT IN ('.$this->CFG['user']['user_id'].')';*/
					}
				elseif($user_id != '')
					$condition = 'AND actor_id IN ('.$user_id.')';

				if($module != '')
					$condition .= ' AND module=\''.$module.'\'';

				$discuzz = new DiscussionHandler;

				$sql_count = 'SELECT count(parent_id) as activity_count'.
						' FROM '.$this->CFG['db']['tbl']['activity'].
						' WHERE status=\'Yes\' '.$condition.
						' ORDER BY date_added DESC';

				$stmt_count = $this->dbObj->Prepare($sql_count);
				$rs_count = $this->dbObj->Execute($stmt_count);
			    if (!$rs_count)
				    trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$rs_row = $rs_count->FetchRow();

				$sql = 'SELECT module, parent_id, owner_id, actor_id, child_id'.
						' FROM '.$this->CFG['db']['tbl']['activity'].
						' WHERE status=\'Yes\' '.$condition.
						' ORDER BY date_added DESC';
				if($num_records > 0)
					$sql.=' LIMIT 0,'.$num_records;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$inc = 1;
				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
								$user1_details = $discuzz->getUserDetails($row['owner_id']);
								$user2_details = $discuzz->getUserDetails($row['actor_id']);
								if(!empty($user1_details['user_id']) AND !empty($user2_details['user_id']))
									{
										//$populateActivities_arr[$row['module']]['child_id'][] = $row['child_id'];
								    	if (chkAllowedModule(array($row['module']))
											AND in_array($row['module'], $this->CFG['site']['modules_arr'])
												OR $row['module'] == 'general')
											{
												$populateActivities_arr[$row['module']][] = $row['child_id'];
												$module_arr[$inc]['parent_id'] = $row['parent_id'];
												$module_arr[$inc]['module'] = $row['module'];
												$module_arr[$inc]['file_name'] = $row['module'].'Activity.tpl';
												$inc++;
											}
									}
	 					    }
	 					//if(!empty($populateActivities_arr))
						//	$this->getActivities($populateActivities_arr);
						//$smartyObj->assign('module_total_records', $inc-1);
						$this->getAllActivities($populateActivities_arr);
					}
				$smartyObj->assign('module_arr', $module_arr);
				$smartyObj->assign('activities_count', $rs_row['activity_count']);
			}

		public function getAllActivities($activities_arr)
			{
				global $smartyObj;
				$getActivities_arr = array();
				$inc = 0;

				foreach($activities_arr as $key=>$value)
					{
				    	if (chkAllowedModule(array($key))
							AND in_array($key, $this->CFG['site']['modules_arr'])
								OR $key == 'general')
				    		{
								$file_name = $this->CFG['site']['project_path'].'common/classes/class_'.ucfirst($key).'ActivityHandler.lib.php';

								if(file_exists($file_name))
									{
										require_once($file_name);
										$class = $key.'ActivityHandler';
										$obj = $key.'Activity';

										if(!isset($$obj))
											{
												$$obj = new $class();
											}
										$$obj->getDiscuzzActivities($value);
									}
							}
						$inc++;
					}
			}

		//FOR RAYZZ MYHOME
		public function getActivities($activityID_arr)
			{
				$getActivities_arr = array();
				$inc = 0;
				$activityIDs = implode(',', $activityID_arr);
				//foreach($activityID_arr as $key=>$value)
					{
						$sql = 'SELECT content_id, action_key, action_value, owner_id,'.
								' actor_id, parent_id, TIMEDIFF(NOW(), date_added) as date_added, TIMEDIFF(NOW(), date_added) as activity_added, date_added as date_created, NOW() as date_current  FROM '.$this->CFG['db']['tbl']['discussions_activity'].
								' WHERE status=\'Yes\' AND id IN ('.$activityIDs.')';


						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
					    if (!$rs)
						trigger_error($this->dbObj->ErrorNo().' '.
							$this->dbObj->ErrorMsg(), E_USER_ERROR);

						if ($rs->PO_RecordCount())
							{
								while($row = $rs->FetchRow()) //if($row = $rs->FetchRow())
								    {
										//echo $row['action_key'].'ac   '.$row['action_value'].' <br />';
										$getActivities_arr[] = $row;
			 					    }
			 					$inc++;
							}
					}
				//return $this->generateActivities($getActivities_arr);
				$this->generateActivities($getActivities_arr);
			}



		/**
		 * set the condition
		 *
		 * @access public
		 * @return void
		 **/
		public function buildConditionQuery()
			{
				$this->sql_condition = 'status=\'Yes\' AND id IN ('.$this->activity_ids.')';
			}

		/**
		 * To sort the query
		 *
		 * @access public
		 * @return void
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = $this->fields_arr['orderby_field'].' '.$this->fields_arr['orderby'];
			}

		/**
		 * DiscussionsActivityHandler::getActivities()
		 *  To get activity details from geral_activity table
		 *
		 * @param array $activityID_arr
		 * @return void
		 */
		public function getDiscuzzActivities($activityID_arr)
			{
				global $smartyObj;
				$getActivities_arr = array();
				$inc = 0;
				$activityIDs = implode(',', $activityID_arr);
				$this->activity_ids = $activityIDs;
				$this->numpg = $this->CFG['data_tbl']['numpg'];
				$this->setFormField('start', 0);
				$this->setFormField('numpg', $this->CFG['data_tbl']['numpg']);//$CFG['data_tbl']['numpg']
				$this->setMinRecordSelectLimit($this->CFG['data_tbl']['min_record_select_limit']);
				$this->setMaxRecordSelectLimit($this->CFG['data_tbl']['max_record_select_limit']);
				$this->setNumPerPageListArr($this->CFG['data_tbl']['numperpage_list_arr']);
				//Set tables and fields to return
				$this->setTableNames(array());
				$this->setReturnColumns(array());
				//orderby field and orderby
				$this->setFormField('orderby_field', '');
				$this->setFormField('orderby', '');
				$this->sanitizeFormInputs($_REQUEST);
				$this->setTableNames(array($this->CFG['db']['tbl']['discussions_activity']));
				$this->setReturnColumns(array('content_id', 'action_key', 'action_value', 'owner_id', 'TIMEDIFF(NOW(), date_added) as activity_added', 'date_added as date_created', 'NOW() as date_current', 'actor_id', 'parent_id'));
				$this->setFormField('orderby_field', 'id');
				$this->setFormField('orderby', 'DESC');

				$this->buildSelectQuery();
				$this->buildConditionQuery();
				$this->buildSortQuery();
				$this->buildQuery();
				//$this->printQuery();
				$this->executeQuery();
				$inc = 0;
				if ($this->isResultsFound())
					{

						while($row = $this->fetchResultRecord())
						    {
								$getActivities_arr[] = $row;
								$inc++;
	 					    }
					}
				$pagingArr[] = 'start';
				$pagingArr[] = 'orderby_field';
				$pagingArr[] = 'orderby';

				$smartyObj->assign('pagingArr', $pagingArr);
				$smartyObj->assign('smarty_paging_list', $this->populatePageLinksPOST($this->getFormField('start'), 'activitiesFrm'));
				$smartyObj->assign('module_total_records', $inc);
				$this->generateActivities($getActivities_arr);
			}

		/**
		 * DiscussionsActivityHandler::generateActivities()
		 *  To generate activities for different actions
		 *
		 * @param array $activity_arr
		 * @return void
		 */
		public function generateActivities($activity_arr)
			{
				global $smartyObj;
							require_once($this->CFG['site']['project_path'].'common/classes/class_DiscussionHandler.lib.php');
				$generateActivities_arr = array();

				$discuzz = new DiscussionHandler();
				require_once($this->CFG['site']['project_path'].'languages/'.$this->CFG['lang']['default'].'/'.$this->CFG['admin']['index']['home_module'].'/discussionsActivity.php');

				for($i=0;$i<count($activity_arr);$i++)
					{
						$content_validated = false;
						switch($activity_arr[$i]['action_key'])
							{
								case 'new_discussion':
									$value = explode('~', $activity_arr[$i]['action_value']);
									$display_string = $LANG['activity_new_discussion'];
									$user_details = $discuzz->getUserDetails($value[1]);
									$discussion_details = $discuzz->getDiscussionDetails($value[0]);
									if($user_details AND $discussion_details)
										{
											$content_validated = true;
											$generateActivities_arr[$i]['user_details_arr'] = $user_details;
											$generateActivities_arr[$i]['user_details_arr']['user_photo']['imgsrc'] = getMemberAvatarDetails($user_details['user_id']);
											$generateActivities_arr[$i]['user_details_arr']['user_link'] = getMemberUrl($user_details['user_id'], $user_details['name']);
											$generateActivities_arr[$i]['user_url'] = '<a href='.getMemberUrl($user_details['user_id'], $user_details['name']).'>'.$user_details['display_name'].'</a>';
											$display_string = str_ireplace('MEMBER_NAME', $generateActivities_arr[$i]['user_url'], $display_string);
											$generateActivities_arr[$i]['discussion_url'] = '<a href='.getUrl('boards', '?title='.$discussion_details['seo_title'], $discussion_details['seo_title'].'/', '', $this->CFG['admin']['index']['home_module']).' class="clsActivityTopic">'.$discussion_details['discussion_title'].'</a>';
											$display_string = str_ireplace('DISCUSSION_TITLE', $generateActivities_arr[$i]['discussion_url'], $display_string);
											$generateActivities_arr[$i]['content'] = $display_string;
											$generateActivities_arr[$i]['iconClassName'] = 'clsDiscussionsActivity';
											$generateActivities_arr[$i]['iconImageName'] = 'icon-new_discussion.gif';
										}
									break;
								case 'publish_discussion':
									$value = explode('~', $activity_arr[$i]['action_value']);
									$user_details = $discuzz->getUserDetails($value[1]);
									$actor_details = $discuzz->getUserDetails($activity_arr[$i]['actor_id']);
									$display_string = $LANG['activity_publish_discussion'];
									$discussion_details = $discuzz->getDiscussionDetails($value[0]);
									if($user_details AND $actor_details	AND $discussion_details)
										{
											$content_validated = true;
											$generateActivities_arr[$i]['user_details_arr'] = $user_details;
											$generateActivities_arr[$i]['user_details_arr']['user_photo']['imgsrc'] = getMemberAvatarDetails($user_details['user_id']);
											$generateActivities_arr[$i]['user_details_arr']['user_link'] = getMemberUrl($user_details['user_id'], $user_details['name']);
											$generateActivities_arr[$i]['user_url'] = '<a href='.getMemberUrl($user_details['user_id'], $user_details['name']).'>'.$user_details['display_name'].'</a>';
											$display_string = str_ireplace('POSTED_USER', $generateActivities_arr[$i]['user_url'], $display_string);
											$generateActivities_arr[$i]['discussion_url'] = '<a href='.getUrl('boards', '?title='.$discussion_details['seo_title'], $discussion_details['seo_title'].'/', '', $this->CFG['admin']['index']['home_module']).' class="clsActivityTopic">'.$discussion_details['discussion_title'].'</a>';
											$display_string = str_ireplace('DISCUSSION_TITLE', $generateActivities_arr[$i]['discussion_url'], $display_string);
											$generateActivities_arr[$i]['actor_url'] = '<a href='.getMemberUrl($actor_details['user_id'], $actor_details['name']).'>'.$actor_details['display_name'].'</a>';
											$display_string = str_ireplace('MEMBER_NAME', $generateActivities_arr[$i]['actor_url'], $display_string);
											$generateActivities_arr[$i]['content'] = $display_string;
											$generateActivities_arr[$i]['iconClassName'] = 'clsDiscussionsActivity';
											$generateActivities_arr[$i]['iconImageName'] = 'icon-publish_discussion.gif';
										}
									break;
								case 'new_board':
								case 'board_edited':
									$value = explode('~', $activity_arr[$i]['action_value']);
									$user_details = $discuzz->getUserDetails($value[1]);
									$board_details = $discuzz->getBoardDetails($value[0]);
									$display_string = $LANG['activity_'.$activity_arr[$i]['action_key']];
									if($user_details AND $board_details)
										{
											$content_validated = true;
											$generateActivities_arr[$i]['user_details_arr'] = $user_details;
											$generateActivities_arr[$i]['user_details_arr']['user_photo']['imgsrc'] = getMemberAvatarDetails($user_details['user_id']);
											$generateActivities_arr[$i]['user_details_arr']['user_link'] = getMemberUrl($user_details['user_id'], $user_details['name']);
											$generateActivities_arr[$i]['user_url'] = '<a href='.getMemberUrl($user_details['user_id'], $user_details['name']).'>'.$user_details['display_name'].'</a>';
											$display_string = str_ireplace('MEMBER_NAME', $generateActivities_arr[$i]['user_url'], $display_string);
											$board_details['board_link'] = '<a href="'.$board_details['qLink'].'" class="clsActivityTopic">'.stripstring($board_details['board']).'</a>';
											$display_string = str_ireplace('BOARD_TITLE', $board_details['board_link'], $display_string);
											$generateActivities_arr[$i]['content'] = $display_string;
											$generateActivities_arr[$i]['iconClassName'] = 'clsDiscussionsActivity';
											$generateActivities_arr[$i]['iconImageName'] = 'icon-new_discussion.gif';
										}
									break;
								case 'publish_board':
									$value = explode('~', $activity_arr[$i]['action_value']);
									$user_details = $discuzz->getUserDetails($activity_arr[$i]['owner_id']);
									$actor_details = $discuzz->getUserDetails($activity_arr[$i]['actor_id']);
									$display_string = $LANG['activity_publish_board'];
									$board_details = $discuzz->getBoardDetails($value[0]);
									if($user_details AND $actor_details	AND $board_details)
										{
											$content_validated = true;
											$generateActivities_arr[$i]['user_details_arr'] = $user_details;
											$generateActivities_arr[$i]['user_details_arr']['user_photo']['imgsrc'] = getMemberAvatarDetails($user_details['user_id']);
											$generateActivities_arr[$i]['user_details_arr']['user_link'] = getMemberUrl($user_details['user_id'], $user_details['name']);
											$generateActivities_arr[$i]['user_url'] = '<a href='.getMemberUrl($user_details['user_id'], $user_details['name']).'>'.$user_details['display_name'].'</a>';
											$display_string = str_ireplace('POSTED_USER', $generateActivities_arr[$i]['user_url'], $display_string);
											$generateActivities_arr[$i]['actor_url'] = '<a href='.getMemberUrl($actor_details['user_id'], $actor_details['name']).'>'.$actor_details['display_name'].'</a>';
											$display_string = str_ireplace('MEMBER_NAME', $generateActivities_arr[$i]['actor_url'], $display_string);
											$board_details['board_link'] = '<a href="'.$board_details['qLink'].'" class="clsActivityTopic">'.stripstring($board_details['board']).'</a>';
											$display_string = str_ireplace('BOARD_TITLE', $board_details['board_link'], $display_string);
											$generateActivities_arr[$i]['content'] = $display_string;
											$generateActivities_arr[$i]['iconClassName'] = 'clsDiscussionsActivity';
											$generateActivities_arr[$i]['iconImageName'] = 'icon-publish_discussion.gif';
										}
									break;
								case 'new_solution':
								case 'solution_edited':
									$value = explode('~', $activity_arr[$i]['action_value']);
									$user_details = $discuzz->getUserDetails($activity_arr[$i]['actor_id']);
									$display_string = $LANG['activity_'.$activity_arr[$i]['action_key']];
									$board_details = $discuzz->getSolutionActivityDetails($value[0]);
									if($user_details AND $board_details)
										{
											$content_validated = true;
											$generateActivities_arr[$i]['user_details_arr'] = $user_details;
											$generateActivities_arr[$i]['user_details_arr']['user_photo']['imgsrc'] = getMemberAvatarDetails($user_details['user_id']);
											$generateActivities_arr[$i]['user_details_arr']['user_link'] = getMemberUrl($user_details['user_id'], $user_details['name']);
											$generateActivities_arr[$i]['user_url'] = '<a href='.getMemberUrl($user_details['user_id'], $user_details['name']).'>'.$user_details['display_name'].'</a>';
											$display_string = str_ireplace('MEMBER_NAME', $generateActivities_arr[$i]['user_url'], $display_string);
											$display_string = str_ireplace('BOARD_TITLE', $board_details['board_link'], $display_string);
											$generateActivities_arr[$i]['content'] = $display_string;
											$generateActivities_arr[$i]['iconClassName'] = 'clsSolutionsActivity';
											$generateActivities_arr[$i]['iconImageName'] = 'icon-best_solution.gif';
										}
									break;
								case 'publish_solution':
									$value = explode('~', $activity_arr[$i]['action_value']);
									$user_details = $discuzz->getUserDetails($activity_arr[$i]['owner_id']);
									$actor_details = $discuzz->getUserDetails($activity_arr[$i]['actor_id']);
									if($activity_arr[$i]['owner_id'] == $activity_arr[$i]['actor_id'])
										$display_string = $LANG['activity_publish_solution2'];
									else
										$display_string = $LANG['activity_publish_solution'];
									$board_details = $discuzz->getSolutionActivityDetails($value[0]);
									if($user_details AND $actor_details	AND $board_details)
										{
											$content_validated = true;
											$generateActivities_arr[$i]['user_details_arr'] = $user_details;
											$generateActivities_arr[$i]['user_details_arr']['user_photo']['imgsrc'] = getMemberAvatarDetails($user_details['user_id']);
											$generateActivities_arr[$i]['user_details_arr']['user_link'] = getMemberUrl($user_details['user_id'], $user_details['name']);
											if($activity_arr[$i]['owner_id'] != $activity_arr[$i]['actor_id']){
												$generateActivities_arr[$i]['user_url'] = '<a href='.getMemberUrl($user_details['user_id'], $user_details['name']).'>'.$user_details['display_name'].'</a>';
												$display_string = str_ireplace('POSTED_USER', $generateActivities_arr[$i]['user_url'], $display_string);
											}
											$generateActivities_arr[$i]['actor_url'] = '<a href='.getMemberUrl($actor_details['user_id'], $actor_details['name']).'>'.$actor_details['display_name'].'</a>';
											$display_string = str_ireplace('MEMBER_NAME', $generateActivities_arr[$i]['actor_url'], $display_string);
											$display_string = str_ireplace('BOARD_TITLE', $board_details['board_link'], $display_string);
											$generateActivities_arr[$i]['content'] = $display_string;
											$generateActivities_arr[$i]['iconClassName'] = 'clsSolutionsActivity';
											$generateActivities_arr[$i]['iconImageName'] = 'icon-best_solution.gif';
										}
									break;
								case 'best_solution':
								case 'best_solution_changed':
								case 'remove_bestsolution':
									$value = explode('~', $activity_arr[$i]['action_value']);
									$user_details = $discuzz->getUserDetails($activity_arr[$i]['actor_id']);
									$display_string = $LANG['activity_'.$activity_arr[$i]['action_key']];
									$board_details = $discuzz->getSolutionActivityDetails($value[0]);
									if($user_details AND $board_details)
										{
											$content_validated = true;
											$generateActivities_arr[$i]['user_details_arr'] = $user_details;
											$generateActivities_arr[$i]['user_details_arr']['user_photo']['imgsrc'] = getMemberAvatarDetails($user_details['user_id']);
											$generateActivities_arr[$i]['user_details_arr']['user_link'] = getMemberUrl($user_details['user_id'], $user_details['name']);
											$generateActivities_arr[$i]['user_url'] = '<a href='.getMemberUrl($user_details['user_id'], $user_details['name']).'>'.$user_details['display_name'].'</a>';
											$display_string = str_ireplace('MEMBER_NAME', $generateActivities_arr[$i]['user_url'], $display_string);
											$display_string = str_ireplace('BOARD_TITLE', $board_details['board_link'], $display_string);
											$generateActivities_arr[$i]['content'] = $display_string;
											$generateActivities_arr[$i]['iconClassName'] = 'clsSolutionsActivity';
											$generateActivities_arr[$i]['iconImageName'] = 'icon-best_solution.gif';
										}
									break;
								case 'friend_accepted':
								case 'friend_rejected':
								case 'request_added':
								case 'request_removed':
								case 'friend_removed':
								case 'subscribed':
								case 'unsubscribed':
								case 'user_blocked':
								case 'remove_blocked':
									$value = explode('~', $activity_arr[$i]['action_value']);
									$user_details = $discuzz->getUserDetails($activity_arr[$i]['owner_id']);
									$actor_details = $discuzz->getUserDetails($activity_arr[$i]['actor_id']);
									if($user_details AND $actor_details)
										{
											$content_validated = true;
											$display_string = $LANG['activity_'.$activity_arr[$i]['action_key']];
											$generateActivities_arr[$i]['user_details_arr'] = $actor_details;
											$generateActivities_arr[$i]['user_details_arr']['user_photo']['imgsrc'] = getMemberAvatarDetails($actor_details['user_id']);
											$generateActivities_arr[$i]['user_details_arr']['user_link'] = getMemberUrl($actor_details['user_id'], $actor_details['name']);
											$generateActivities_arr[$i]['actor_url'] = '<a href='.getMemberUrl($actor_details['user_id'], $actor_details['name']).'>'.$actor_details['display_name'].'</a>';
											$display_string = str_ireplace('MEMBER_NAME', $generateActivities_arr[$i]['actor_url'], $display_string);
											$generateActivities_arr[$i]['user_url'] = '<a href='.getMemberUrl($user_details['user_id'], $user_details['name']).'>'.$user_details['display_name'].'</a>';
											$display_string = str_ireplace('OWNER_NAME', $generateActivities_arr[$i]['user_url'], $display_string);
											$generateActivities_arr[$i]['content'] = $display_string;
											$generateActivities_arr[$i]['iconClassName'] = 'clsFriendsActivity';
											$generateActivities_arr[$i]['iconImageName'] = 'bg-friendsicons.gif';
										}
									break;

							}
						if($content_validated){
							$generateActivities_arr[$i]['action_key'] = $activity_arr[$i]['action_key'];
							$generateActivities_arr[$i]['parent_id'] = $activity_arr[$i]['parent_id'];
							$generateActivities_arr[$i]['activity_added'] = getTimeDiffernceFormat(getDateTimeDiff($activity_arr[$i]['date_created'],$activity_arr[$i]['date_current']));
						}
					}
				$smartyObj->assign('discussionsActivity_arr', $generateActivities_arr);
			}

	}
?>