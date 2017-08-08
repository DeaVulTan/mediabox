<?php
//-------------- Class ContributorsFormHanlder begins --------------->>>>>//
/**
 *
 * @category	Discuzz
 * @package		TopContributorsFormHandler
 * @author 		senthil_52ag05
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id:  $
 * @since 		2008-12-19
 */
class ContributorsFormHanlder extends FriendsHandler
	{

		public $pagingArr;

		/**
		 * ContributorsFormHanlder::storeSearchFields()
		 *
		 * @return
		 */
		public function storeSearchFields()
			{
				$allowed_fields_arr = array(
										'search_member'=>$this->fields_arr['search_member'],
										'total_points'=>$this->fields_arr['total_points'],
										'maxtotal_points'=>$this->fields_arr['maxtotal_points'],
										'total_boards'=>$this->fields_arr['total_boards'],
										'maxtotal_boards'=>$this->fields_arr['maxtotal_boards'],
										'total_solutions'=>$this->fields_arr['total_solutions'],
										'maxtotal_solutions'=>$this->fields_arr['maxtotal_solutions']
										);

				$allowed_fields_arr = serialize($allowed_fields_arr);

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['advanced_search'].' SET'.
						' member = '.$this->dbObj->Param('member').' WHERE'.
						' user_id = '.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($allowed_fields_arr, $this->CFG['user']['user_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
			}

		/**
		 * ContributorsFormHanlder::populateSearchFields()
		 *
		 * @return
		 */
		public function populateSearchFields()
			{
				if($this->fields_arr['so']=='adv')
					{
						$sql = 'SELECT member FROM '.$this->CFG['db']['tbl']['advanced_search'].
								' WHERE user_id='.$this->dbObj->Param('user_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
						    if (!$rs)
							    trigger_db_error($this->dbObj);

						if($row = $rs->FetchRow())
							{
								if($row['member'])
									{
										$search_fields_arr = unserialize($row['member']);
										$this->fields_arr = array_merge($this->fields_arr, $search_fields_arr);
									}
							}
					}
			}

		public function addSlashForPercentageOnly($value)
			{
				//$value = 'demo % ';'%%%';'% %%';%demo%';
				$value_rep = addslashes($value);
				$search_value = trim($value_rep);
				$str_arr = str_split($search_value);
				$percentage_avail = false;
				$slashed_value = '';
				foreach($str_arr as $str_val)
					{
						if($str_val == '%')
							{
								$percentage_avail = true;
								$slashed_value .= '\\'.$str_val;
							}
						else
							$slashed_value .= $str_val;
					}

				if($percentage_avail)
					return $slashed_value;

				return $value_rep;
			}

		/**
		 * set the condition
		 *
		 * @access public
		 * @return void
		 **/
		public function buildConditionQuery()
			{
				$this->sql_condition = 'u.'.getUserTableField('user_id').'=ua.user_id AND u.'.getUserTableField('user_status').'=\'Ok\'';

				if($this->fields_arr['featured'])
					{
						$this->sql_condition .= ' AND EXISTS(SELECT 1 FROM '.$this->CFG['db']['tbl']['users_info'].' AS ui WHERE ui.user_id=ua.'.getUserTableField('user_id').
												' AND ui.featured=\'Yes\')';
						$this->pagingArr[] = 'featured';
					}
				if($this->fields_arr['week'])
					{
						$this->sql_condition .= ' AND u.'.getUserTableField('user_id').'=ua.user_id AND u.'.getUserTableField('user_id').'=T.user_id AND T.week_points>0';
						$this->pagingArr[] = 'week';
					}
				if($this->fields_arr['search_member'])
					{
						$search_value = $this->addSlashForPercentageOnly($this->fields_arr['search_member']);
						$this->sql_condition .= ' AND u.'.getUserTableField('display_name').' like \'%'.$search_value.'%\'';
						$this->pagingArr[] = 'search_member';
					}
				if($this->fields_arr['total_points'] AND $this->fields_arr['maxtotal_points'])
					{
						$total_points = $this->fields_arr['total_points'];
						$maxtotal_points = $this->fields_arr['maxtotal_points'];
						if ($maxtotal_points < $total_points)
							{
								$maxtotal_points = $this->fields_arr['total_points'];
								$total_points = $this->fields_arr['maxtotal_points'];
							}

						$this->sql_condition .= ' AND ua.total_points >= '.$total_points;
						$this->sql_condition .= ' AND ua.total_points <= '.$maxtotal_points;

						$this->pagingArr[] = 'total_points';
						$this->pagingArr[] = 'maxtotal_points';
					}
				if($this->fields_arr['total_boards'] AND $this->fields_arr['maxtotal_boards'])
					{
						$total_boards = $this->fields_arr['total_boards'];
						$maxtotal_boards = $this->fields_arr['maxtotal_boards'];
						if ($maxtotal_boards < $total_boards)
							{
								$maxtotal_boards = $this->fields_arr['total_boards'];
								$total_boards = $this->fields_arr['maxtotal_boards'];
							}

						$this->sql_condition .= ' AND ua.total_board >= '.$total_boards;
						$this->sql_condition .= ' AND ua.total_board <= '.$maxtotal_boards;

						$this->pagingArr[] = 'total_boards';
						$this->pagingArr[] = 'maxtotal_boards';
					}
				if($this->fields_arr['total_solutions'] AND $this->fields_arr['maxtotal_solutions'])
					{
						$total_solutions = $this->fields_arr['total_solutions'];
						$maxtotal_solutions = $this->fields_arr['maxtotal_solutions'];
						if ($maxtotal_solutions < $total_solutions)
							{
								$maxtotal_solutions = $this->fields_arr['total_solutions'];
								$total_solutions = $this->fields_arr['maxtotal_solutions'];
							}

						$this->sql_condition .= ' AND ua.total_solution >= '.$total_solutions;
						$this->sql_condition .= ' AND ua.total_solution <= '.$maxtotal_solutions;

						$this->pagingArr[] = 'total_solutions';
						$this->pagingArr[] = 'maxtotal_solutions';
					}
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
		 *
		 * @access public
		 * @return void
		 **/
		public function displayTopContributors()
			{
				$displayTopContributors_arr = array();
				$req_arr = array('img_path', 't_height', 't_width', 's_height', 's_width', 'photo_server_url', 'photo_ext', 'gender');
				$inc = 1;
				while($row = $this->fetchResultRecord())
					{
						$displayTopContributors_arr[$inc]['userLevelClass'] = '';
						if($this->CFG['admin']['user_levels']['allowed'])
							$displayTopContributors_arr[$inc]['userLevelClass'] = getUserLevelClass($row['total_points']);

						//getting user info..
						$user_info_details_arr = getUserInfoDetails($req_arr, 'user_id', $row['user_id']);
						$user_friends_details_arr = $this->getFriendDetails($row['user_id'], $this->CFG['user']['user_id']);

						$displayTopContributors_arr[$inc]['friend']['req'] = $displayTopContributors_arr[$inc]['friend']['rem'] = 'display:none;';
						$displayTopContributors_arr[$inc]['friend']['accept'] = $displayTopContributors_arr[$inc]['friend']['rej'] = $displayTopContributors_arr[$inc]['friend']['rem_req'] = 'display:none;';
						$displayTopContributors_arr[$inc]['friend']['msg'] = $this->LANG['friend_not_requested'];

						if($user_friends_details_arr['request_from'] == $this->CFG['user']['user_id'])
							{

									if ($user_friends_details_arr['req_status'] == 'Rejected')
										{
											$displayTopContributors_arr[$inc]['friend']['msg'] = $this->LANG['friend_request_rejected'];
											// can delete previous rejected req before request again..
											$displayTopContributors_arr[$inc]['friend']['req'] = '';
										}
									elseif ($user_friends_details_arr['req_status'] == 'Accepted')
										{
											$displayTopContributors_arr[$inc]['friend']['msg'] = $this->LANG['friend_alreadyfriend'];
											$displayTopContributors_arr[$inc]['friend']['rem'] = '';
										}
									elseif ($user_friends_details_arr['req_status'] == 'Pending')
										{
											$displayTopContributors_arr[$inc]['friend']['msg'] = $this->LANG['friend_requested'];
											$displayTopContributors_arr[$inc]['friend']['rem_req'] = '';
										}
							}
						else
							{
									if($user_friends_details_arr['req_status'] == '')
										{
											$displayTopContributors_arr[$inc]['friend']['req'] = '';
										}
									elseif ($user_friends_details_arr['req_status'] == 'Rejected')
										{
											$displayTopContributors_arr[$inc]['friend']['msg'] = $this->LANG['friend_rejected request'];
											// can delete previous rejected req before request again..
											$displayTopContributors_arr[$inc]['friend']['accept'] = '';
										}
									elseif ($user_friends_details_arr['req_status'] == 'Accepted')
										{
											$displayTopContributors_arr[$inc]['friend']['rem'] = '';
											$displayTopContributors_arr[$inc]['friend']['msg'] = $this->LANG['friend_alreadyfriend'];
										}
									elseif ($user_friends_details_arr['req_status'] == 'Pending')
										{
											$displayTopContributors_arr[$inc]['friend']['accept'] = '';
											$displayTopContributors_arr[$inc]['friend']['rej'] = '';
											$displayTopContributors_arr[$inc]['friend']['msg'] = '';
										}
							}


						$displayTopContributors_arr[$inc]['record'] = array_merge($row, $user_info_details_arr);

						$displayTopContributors_arr[$inc]['contributor']['url'] = getUrl('topcontributors', '', '', '', $this->CFG['admin']['index']['home_module']);
						$displayTopContributors_arr[$inc]['mysolutions']['url'] = getMemberUrl($row['user_id'], $row['name']);
						$displayTopContributors_arr[$inc]['mysolutions']['href_val'] = stripString($row['contributor_by'], $this->CFG['username']['short_length']);
						$displayTopContributors_arr[$inc]['boards']['url'] = getUrl('boards', '?view=search&amp;uname='.$row['name'].'&amp;opt=board', 'search/?uname='.$row['name'].'&amp;opt=board', '', $this->CFG['admin']['index']['home_module']);
						$displayTopContributors_arr[$inc]['boards_ans']['url'] = getUrl('boards', '?view=search&amp;uname='.$row['name'].'&amp;opt=sol', 'search/?uname='.$row['name'].'&amp;opt=sol', '', $this->CFG['admin']['index']['home_module']);
						$inc++;
					}
				return $displayTopContributors_arr;
			}

		public function displayUserDetails()
		    {
				global $smartyObj;
				$this->displayUserDetails_arr=array();
				$sql = 'SELECT total_board, total_solution, total_points, total_best_solution, DATE_FORMAT(date_updated,\'%D %b %Y\') as date_updated'.
						' FROM '.$this->CFG['db']['tbl']['users_board_log'].
						' WHERE user_id='.$this->dbObj->Param('uid');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['uid']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$this->user_ans_log = array('total_board'=>'', 'total_solution'=>'', 'total_points'=>'', 'date_updated'=>'');
				if ($rs->PO_RecordCount())
					$this->user_ans_log = $rs->FetchRow();

				$this->displayUserDetails_arr['user_details']	=	$this->user_details = $this->getUserDetailsFromUsersTable($this->CFG['db']['tbl']['users'], $this->fields_arr['uid']);
				$mcomp = $this->user_details['name'];
				$this->user_details['display_name'] = ucwords($this->user_details['display_name']);
				$display_username = $this->user_details['display_name'];

				$bio = $this->user_details['bio'];
				$this->displayUserDetails_arr['mysolutions_url']	=	getMemberUrl($this->user_details['user_id'], $mcomp);
				$this->displayUserDetails_arr['email']	=	$this->user_details['email'];
				$this->displayUserDetails_arr['mysolutions_mem_url']	=	getMemberUrl($this->user_details['user_id'], $mcomp, 'members');
				$this->displayUserDetails_arr['members_url']	=	getUrl('mailcompose', '?mcomp='.$mcomp, '?mcomp='.$mcomp, 'members');

				$this->displayUserDetails_arr['toggleFavorites']	=	'toggleFavorites(\''.getUrl('favoritesolutions','','','members',$this->CFG['admin']['index']['home_module']).'\', \'cid='.$this->fields_arr['uid'].'&amp;ctype=User\', \'selShowFavoriteText_User_'.$this->fields_arr['uid'].'\'); return false;';
				$this->displayUserDetails_arr['toggleFavorites1']	=	'ajaxUpdateDiv(\''.getUrl('favoritesolutions','','','members',$this->CFG['admin']['index']['home_module']).'\', \'block_id='.$this->fields_arr['uid'].'\', \'upDating\'); return false;';

				//$this->displayUserDetails_arr['date']	=	date('M d, Y', strtotime($this->fields_arr['doj']));
				$this->displayUserDetails_arr['nl2br_bio']	=	nl2br(wordWrapManual($bio, 45));
				$this->displayUserDetails_arr['about_txt'] = $this->LANG['about_me'];
				$this->displayUserDetails_arr['isAmBlocked'] = false;
				$this->displayUserDetails_arr['isMutualFriend'] = false;
				if($this->fields_arr['uid'] != $this->CFG['user']['user_id'])
					{
						if(isMember() and $this->CFG['admin']['friends']['allowed'])
							{
								$friHandler = new FriendsHandler();
								if(!$friHandler->isAmBlocked($this->fields_arr['uid']))
									{
										$profile_friends = $friHandler->getFriendDetails($this->fields_arr['uid'], $this->CFG['user']['user_id']);
										$this->displayUserDetails_arr['profile_friend']['url'] = getUrl('topcontributors', '', '', '', $this->CFG['admin']['index']['home_module']);
										$this->displayUserDetails_arr['profile_friend']['req'] = $this->displayUserDetails_arr['profile_friend']['rem'] = 'display:none;';
										$this->displayUserDetails_arr['profile_friend']['accept'] = $this->displayUserDetails_arr['profile_friend']['rej'] = $this->displayUserDetails_arr['profile_friend']['rem_req'] = 'display:none;';
										$this->displayUserDetails_arr['profile_friend']['msg'] = $this->LANG['friend_not_requested'];
										if($profile_friends['request_from'] == $this->CFG['user']['user_id'])
											{
													if ($profile_friends['req_status'] == 'Rejected')
														{
															$this->displayUserDetails_arr['profile_friend']['msg'] = $this->LANG['friend_request_rejected'];
															$this->displayUserDetails_arr['profile_friend']['req'] = '';
														}
													elseif ($profile_friends['req_status'] == 'Accepted')
														{
															$this->displayUserDetails_arr['profile_friend']['msg'] = $this->LANG['friend_alreadyfriend'];
															$this->displayUserDetails_arr['profile_friend']['rem'] = '';
															$this->displayUserDetails_arr['isMutualFriend'] = true;
														}
													elseif ($profile_friends['req_status'] == 'Pending')
														{
															$this->displayUserDetails_arr['profile_friend']['msg'] = $this->LANG['friend_requested'];
														$this->displayUserDetails_arr['profile_friend']['rem_req'] = '';
														}
											}
										else
											{
													if($profile_friends['req_status'] == '')
														{
															$this->displayUserDetails_arr['profile_friend']['req'] = '';
														}
													elseif ($profile_friends['req_status'] == 'Rejected')
														{
															$this->displayUserDetails_arr['profile_friend']['msg'] = $this->LANG['friend_rejected request'];
															$this->displayUserDetails_arr['profile_friend']['accept'] = '';
														}
													elseif ($profile_friends['req_status'] == 'Accepted')
														{
															$this->displayUserDetails_arr['profile_friend']['rem'] = '';
															$this->displayUserDetails_arr['profile_friend']['msg'] = $this->LANG['friend_alreadyfriend'];
															$this->displayUserDetails_arr['isMutualFriend'] = true;
														}
													elseif ($profile_friends['req_status'] == 'Pending')
														{
															$this->displayUserDetails_arr['profile_friend']['accept'] = '';
															$this->displayUserDetails_arr['profile_friend']['rej'] = '';
															$this->displayUserDetails_arr['profile_friend']['msg'] = '';
														}
											}


									}
								else
									{
										$this->displayUserDetails_arr['isAmBlocked'] = true;
									}
							}

					}

				$this->form_user_details['displayUserDetails'] = $this->displayUserDetails_arr;
				$this->includeAjaxHeader();
				setTemplateFolder('general/', $this->CFG['admin']['index']['home_module']);
				$smartyObj->display('topContributorsAjax.tpl');
				$this->includeAjaxFooter();
				die();
	    }

	}
//<<<<<-------------- Class ContributorsFormHanlder begins ---------------//
//-------------------- Code begins -------------->>>>>//
$contributors = new ContributorsFormHanlder();
$discussion = new DiscussionHandler();
if($CFG['admin']['index']['activity']['show'])
	{
		$GeneralActivity = new DiscussionsActivityHandler();
		$contributors->generalActivityObj = $GeneralActivity;
	}
$contributors->setPageBlockNames(array('form_search', 'form_contributors', 'form_featured_contributors', 'form_advanced_search', 'form_week_experts', 'form_search_heading', 'form_normal_heading'));

//default form fields and values...
$contributors->setFormField('search_board', '');

$pagename = $LANG['discuzz_common_top_contributor_title'];
$LANG['contributors_title'] = $LANG['discuzz_common_top_contributor_title'];
$cfg_title = $LANG['contributors_title'];

/*************Start navigation******/
//$contributors->numpg = $CFG['data_tbl']['numpg'];
$contributors->setFormField('start', 0);
$contributors->setFormField('numpg', $CFG['data_tbl']['numpg']);//

$contributors->setMinRecordSelectLimit($CFG['data_tbl']['min_record_select_limit']);
$contributors->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$contributors->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
//Set tables and fields to return
$contributors->setTableNames(array());
$contributors->setReturnColumns(array());
//orderby field and orderby
$contributors->setFormField('title', '');
$contributors->setFormField('week', '');
$contributors->setFormField('featured', '');
$contributors->setFormField('search_member', '');
$contributors->setFormField('maxtotal_points', '');
$contributors->setFormField('total_points', '');
$contributors->setFormField('maxtotal_boards', '');
$contributors->setFormField('total_boards', '');
$contributors->setFormField('maxtotal_solutions', '');
$contributors->setFormField('total_solutions', '');
$contributors->setFormField('adv_search', '');
$contributors->setFormField('request_from', '');
$contributors->setFormField('request_to', '');
$contributors->setFormField('uid', '');
$contributors->setFormField('so', 'min');
$contributors->setFormField('orderby_field', '');
$contributors->setFormField('orderby', '');
/*************End navigation******/
$contributors->sanitizeFormInputs($_REQUEST);
// Default page block
$contributors->setAllPageBlocksHide();
$contributors->setPageBlockShow('form_normal_heading');
$contributors->clsAllTime = $contributors->clsLastWeek = '';

if ($contributors->isFormPOSTed($_REQUEST, 'sendRequest'))
	{
		if (!isMember())
			{
				echo 'Session Expired. <a href="'.$CFG['auth']['login_url']['url'].'?r">Login to continue..!</a>';
				die();
			}
		ob_start();
		$from_id = $contributors->getFormField('request_from');
		$to_id = $contributors->getFormField('request_to');
		$contributors->deleteFriendRequest($from_id, $to_id, 'Rejected');
		if(!$contributors->ifRequestExists($to_id, $from_id) AND !$contributors->ifRequestExists($from_id, $to_id) AND !$contributors->isAmBlocked($to_id))
			$contributors->insertFriendRequest($from_id, $to_id);
		$contributors->displayUserDetails();
		die();
	}

if ($contributors->isFormPOSTed($_REQUEST, 'removeRequest'))
	{
		if (!isMember())
			{
				echo 'Session Expired. <a href="'.$CFG['auth']['login_url']['url'].'?r">Login to continue..!</a>';
				die();
			}
		ob_start();
		$from_id = $contributors->getFormField('request_from');
		$to_id = $contributors->getFormField('request_to');
		if($contributors->ifRequestExists($from_id, $to_id))
			$contributors->deleteFriendRequest($from_id, $to_id, 'Pending');
		$contributors->displayUserDetails();
		die();
	}

if ($contributors->isFormPOSTed($_REQUEST, 'removeFriend'))
	{
		if (!isMember())
			{
				echo 'Session Expired. <a href="'.$CFG['auth']['login_url']['url'].'?r">Login to continue..!</a>';
				die();
			}
		ob_start();
		$from_id = $contributors->getFormField('request_from');
		$to_id = $contributors->getFormField('request_to');
		$contributors->deleteFriendRequest($from_id, $to_id, 'Accepted');
		$contributors->displayUserDetails();
		die();
	}

if ($contributors->isFormPOSTed($_REQUEST, 'rejectRequest'))
	{
		if (!isMember())
			{
				echo 'Session Expired. <a href="'.$CFG['auth']['login_url']['url'].'?r">Login to continue..!</a>';
				die();
			}
		ob_start();
		$from_id = $contributors->getFormField('request_from');
		$to_id = $contributors->getFormField('request_to');
		if($contributors->ifRequestExists($from_id, $to_id) AND !$contributors->isAmBlocked($to_id))
			$contributors->updateFriendRequest($from_id, $to_id, 'Rejected');
		$contributors->displayUserDetails();
		die();
	}

if ($contributors->isFormPOSTed($_REQUEST, 'acceptRequest'))
	{
		if (!isMember())
			{
				echo 'Session Expired. <a href="'.$CFG['auth']['login_url']['url'].'?r">Login to continue..!</a>';
				die();
			}
		ob_start();
		$from_id = $contributors->getFormField('request_from');
		$to_id = $contributors->getFormField('request_to');
		if($contributors->ifRequestExists($from_id, $to_id) AND !$contributors->isAmBlocked($to_id))
			$contributors->updateFriendRequest($from_id, $to_id, 'Accepted');
		$contributors->displayUserDetails();
		die();
	}

if ($contributors->isFormPOSTed($_GET, 'week'))
	{
		$contributors->setPageBlockShow('form_week_experts');
		$contributors->LANG['contributors_lastweek_title'] = $LANG['contributors_this_week'];
		$contributors->LANG['contributors_alltime_title'] = '<a href="'.getUrl('topcontributors', '' ,'', '', $CFG['admin']['index']['home_module']).'">'.$LANG['contributors_all_time'].'</a>';
		$contributors->LANG['contributors_this_week_note'] = str_ireplace('VAR_REFRESH_TIME',$CFG['admin']['week_experts']['refresh'],$LANG['contributors_this_week_note']);

		$discussion->createWeekExperts();

		$contributors->setTableNames(array($CFG['db']['tbl']['users_board_log'].' as ua', $CFG['db']['tbl']['users'].' as u', $CFG['db']['tbl']['view_weekly_experts'].' as T'));
		$contributors->setReturnColumns(array('T.user_id','T.week_points','ua.user_id', 'total_board', 'total_solution', 'total_points', getUserTableField('display_name').' as contributor_by', getUserTableField('name').' as name', 'u.'.getUserTableField('user_id').' as img_user_id', 'TIMEDIFF(NOW(), date_updated) as date_updated'));
		$contributors->setFormField('orderby_field', 'T.week_points');
		$contributors->setFormField('orderby', 'DESC');
		$contributors->clsLastWeek = 'clsActive';
	}
elseif ($contributors->isFormPOSTed($_GET, 'featured'))
	{
		$contributors->setPageBlockShow('form_featured_contributors');
		$contributors->setPageBlockHide('form_normal_heading');
		$cfg_title = $LANG['discuzz_common_featured_contributor_title'];

		$contributors->setTableNames(array($CFG['db']['tbl']['users_board_log'].' as ua', $CFG['db']['tbl']['users'].' as u'));
		$contributors->setReturnColumns(array('ua.user_id', 'total_board', 'total_solution', 'total_points', getUserTableField('display_name').' as contributor_by', getUserTableField('name').' as name', 'u.'.getUserTableField('user_id').' as img_user_id', 'TIMEDIFF(NOW(), date_updated) as date_updated'));
		$contributors->setFormField('orderby_field', 'ua.total_points');
		$contributors->setFormField('orderby', 'DESC');
		$contributors->clsLastWeek = 'clsActive';
	}
else
	{
		$contributors->setPageBlockShow('form_contributors');
		$contributors->LANG['contributors_alltime_title'] = $LANG['contributors_all_time'];
		$contributors->LANG['contributors_lastweek_title'] = '<a href="'.getUrl('topcontributors', '?week=1', '?week=1', '', $CFG['admin']['index']['home_module']).'">'.$LANG['contributors_this_week'].'</a>';
		$contributors->LANG['contributors_this_week_note'] = str_ireplace('VAR_REFRESH_TIME',$CFG['admin']['week_experts']['refresh'],$LANG['contributors_this_week_note']);
		$contributors->setTableNames(array($CFG['db']['tbl']['users_board_log'].' as ua', $CFG['db']['tbl']['users'].' as u'));
		$contributors->setReturnColumns(array('ua.user_id', 'total_board', 'total_solution', 'total_points', getUserTableField('display_name').' as contributor_by', getUserTableField('name').' as name', 'u.'.getUserTableField('user_id').' as img_user_id', 'TIMEDIFF(NOW(), date_updated) as date_updated'));
		$contributors->setFormField('orderby_field', 'ua.total_points');
		$contributors->setFormField('orderby', 'DESC');
		$contributors->clsAllTime = 'clsActive';
	}

if($contributors->getFormField('so')=='adv' and !$contributors->isFormPOSTed($_REQUEST, 'adv_search'))
	{
		$contributors->populateSearchFields();
		$contributors->setPageBlockHide('form_contributors');
		$contributors->setPageBlockHide('form_week_experts');
		$contributors->setPageBlockHide('form_search_heading');
		$contributors->setPageBlockHide('form_normal_heading');
		$contributors->setPageBlockShow('form_advanced_search');
	}

if($contributors->isFormPOSTed($_POST, 'adv_search'))
	{
		$contributors->getFormField('total_points') AND
			$contributors->chkIsNumeric('total_points', $LANG['discuzz_common_err_tip_numeric']);

		if ($contributors->getFormField('maxtotal_points'))
			{
				if (!$contributors->chkIsNumeric('maxtotal_points', $LANG['discuzz_common_err_tip_numeric']))
					$contributors->setFormFieldErrorTip('total_points', $LANG['discuzz_common_err_tip_numeric']);
			}

		$contributors->getFormField('total_boards') AND
			$contributors->chkIsNumeric('total_boards', $LANG['discuzz_common_err_tip_numeric']);

		if ($contributors->getFormField('maxtotal_boards'))
			{
				if (!$contributors->chkIsNumeric('maxtotal_boards', $LANG['discuzz_common_err_tip_numeric']))
					$contributors->setFormFieldErrorTip('total_boards', $LANG['discuzz_common_err_tip_numeric']);
			}

		$contributors->getFormField('total_solutions') AND
			$contributors->chkIsNumeric('total_solutions', $LANG['discuzz_common_err_tip_numeric']);

		if ($contributors->getFormField('maxtotal_solutions'))
			{
				if (!$contributors->chkIsNumeric('maxtotal_solutions', $LANG['discuzz_common_err_tip_numeric']))
					$contributors->setFormFieldErrorTip('total_solutions', $LANG['discuzz_common_err_tip_numeric']);
			}

		if ($contributors->isValidFormInputs())
			{
				$contributors->storeSearchFields();
			}
		else
			{
				$contributors->setPageBlockHide('form_contributors');
				$contributors->setPageBlockHide('form_week_experts');
				$contributors->setPageBlockShow('form_advanced_search');
				$contributors->setPageBlockShow('block_msg_form_error');
				$contributors->setCommonErrorMsg($LANG['err_msg_invalid_search_option']);
			}
	}

if(($contributors->getFormField('adv_search')) OR $contributors->isFormPOSTed($_REQUEST, 'search_member'))
	{
		$contributors->LANG['contributors_home_title'] = '<a href="'.getUrl('topcontributors', '', '', '', $CFG['admin']['index']['home_module']).'">'.$LANG['discuzz_common_home'].'</a> > '.$LANG['search_results'];
		$contributors->setPageBlockHide('form_normal_heading');
		$contributors->setPageBlockShow('form_search_heading');
	}
if($contributors->isShowPageBlock('form_advanced_search'))
	{
		$contributors->LANG['contributors_home_title'] = '<a href="'.getUrl('topcontributors', '', '', '', $CFG['admin']['index']['home_module']).'">'.$LANG['discuzz_common_home'].'</a> > '.$LANG['advanced_search'];
		$contributors->form_advanced_search['form_action'] = getUrl('topcontributors', '?so=adv', '?so=adv', '', $CFG['admin']['index']['home_module']);
		$contributors->setPageBlockHide('form_normal_heading');
		$contributors->setPageBlockShow('form_search_heading');
	}

//<<<<--------------------Code Ends----------------------//
//--------------------Page block templates begins-------------------->>>>>//
$CFG['html']['page_id'] .= 'contributors';
$CFG['site']['title'] = $cfg_title.' - '.$CFG['site']['title'];

if ($contributors->isShowPageBlock('form_contributors') OR $contributors->isShowPageBlock('form_week_experts') OR $contributors->isShowPageBlock('form_featured_contributors'))
	{
		$contributors->buildSelectQuery();
		$contributors->buildConditionQuery();
		$contributors->buildSortQuery();
		$contributors->buildQuery();
		$contributors->executeQuery();
		//$contributors->printQuery();

		$contributors->pagingArr[] = 'orderby_field';
		$contributors->pagingArr[] = 'orderby';

		if ($contributors->isResultsFound())
			{
				$contributors->form_contributors['TopContributors'] = $contributors->displayTopContributors();
				$smartyObj->assign('smarty_paging_list', $contributors->populatePageLinksGET($contributors->getFormField('start'), $contributors->pagingArr));
			}
	}

//include the header file
$contributors->includeHeader();
//include the content of the page
setTemplateFolder('general/', $CFG['admin']['index']['home_module']);
$smartyObj->display('topContributors.tpl');
//include the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
?>
<script language="javascript" type="text/javascript">
	var popupPosition = -10;
</script>
<?php
$contributors->includeFooter();
?>