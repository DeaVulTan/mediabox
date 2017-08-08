<?php
/**
 * Solutions rating page.
 *
 * PHP version 5.0
 *
 * @category	###Discuzz###
 * @package		###Index###
 * @author 		shankar_76ag08
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id:
 * @since 		2008-10-31
 */
/**
 * File having common configuration variables required for the entire project
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/'.$CFG['admin']['index']['home_module'].'/solutions.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';

$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FriendsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_DiscussionsActivityHandler.lib.php';
$CFG['site']['is_module_page']='discussions';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['is']['ajax_page'] = true;
$CFG['auth']['is_authenticate'] = 'members';
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//FOR RAYZZ INTEGRATION
if(class_exists('DiscussionHandler'))
	{
		$discussionHandler = new DiscussionHandler();
		$smartyObj->assign_by_ref('discussion', $discussionHandler);
	}
//-------------- Class LoginFormHandler begins --------------->>>>>//
/**
 * SolutionRatingHandler
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class SolutionRatingHandler extends FormHandler
	{
		/**
		 * to add rating details
		 *
		 * @return 		string
		 * @access 		public
		 */
		public function updateFavoriteContent()
			{
				$updateFavoriteContent_arr = array();
				$table_name = $this->CFG['db']['tbl']['user_bookmarked'];
				switch($this->fields_arr['ctype'])
					{
						case 'Board':
							$add_text = $this->LANG['solutions_add_to_favorites'];
							$remove_text = $this->LANG['solutions_remove_favorites'];
							break;
						case 'User';
							$add_text = $this->LANG['discuzz_common_user_add_to_favorites'];
							$remove_text = $this->LANG['discuzz_common_user_remove_favorites'];
							break;
					}
				$sql = 'SELECT bookmark_id FROM '.$table_name.
						' WHERE content_id = '.$this->dbObj->Param('content_id') .' AND'.
						' content_type = '.$this->dbObj->Param('content_type').' AND'.
						' user_id = '.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$result = $this->dbObj->Execute($stmt, array($this->fields_arr['cid'], $this->fields_arr['ctype'], $this->CFG['user']['user_id']));
				if (!$result)
						trigger_db_error($this->dbObj);

				if ($result->PO_RecordCount())
					{
						$sql = 'DELETE FROM '.$table_name.
								' WHERE content_id='.$this->dbObj->Param('content_id').' AND'.
								' content_type = '.$this->dbObj->Param('content_type').' AND'.
						   		' user_id='.$this->dbObj->Param('uid');

						$field_values_arr = array($this->fields_arr['cid'], $this->fields_arr['ctype'], $this->CFG['user']['user_id']);
						$favorite_text = $add_text;

						//Add Activity
						if($this->CFG['admin']['index']['activity']['show'])
							{
								$activity_arr['action_key'] = 'unsubscribed';
								$activity_arr['owner_id'] = $this->fields_arr['cid'];
								$activity_arr['actor_id'] = $this->CFG['user']['user_id'];
								$activity_arr['content_id'] = $this->fields_arr['cid'];
								$this->generalActivityObj->addActivity($activity_arr);
							}
					}
				else
					{
						// generates query INSERT INTO users (user_name, email, password, first_name, last_name, phone, fax, address, city, state, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
						$sql = 'INSERT INTO '.$table_name.
								' SET date_added=NOW(), last_updated=NOW()'.
								', content_id='.$this->dbObj->Param('content_id').
								', content_type='.$this->dbObj->Param('content_type').
								', user_id='.$this->dbObj->Param('user_id');

						$field_values_arr = array($this->fields_arr['cid'], $this->fields_arr['ctype'], $this->CFG['user']['user_id']);
						$favorite_text = $remove_text;
						//Add Activity
						if($this->CFG['admin']['index']['activity']['show'])
							{
								$activity_arr['action_key'] = 'subscribed';
								$activity_arr['owner_id'] = $this->fields_arr['cid'];
								$activity_arr['actor_id'] = $this->CFG['user']['user_id'];
								$activity_arr['content_id'] = $this->fields_arr['cid'];
								$this->generalActivityObj->addActivity($activity_arr);
							}
					}
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $field_values_arr);
				if (!$rs)
					    trigger_db_error($this->dbObj);

				$updateFavoriteContent_arr['favorite_solutions']['title'] = $favorite_text;

				return $updateFavoriteContent_arr;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function updateIgnoreUser()
			{
				$updateIgnoreUser_arr = array();
				$uid = $this->CFG['user']['user_id'];
				$ignore_id = $this->fields_arr['block_id'];
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['block_members'].
						' WHERE user_id = '.$this->dbObj->Param($uid).
						' AND block_id = '.$this->dbObj->Param($ignore_id);
				$stmt = $this->dbObj->Prepare($sql);
				$result = $this->dbObj->Execute($stmt, array($uid, $ignore_id));
				if (!$result)
						trigger_db_error($this->dbObj);

				if ($result->PO_RecordCount())
					{
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['block_members'].
								' WHERE user_id = '.$this->dbObj->Param($uid).
								' AND block_id = '.$this->dbObj->Param($ignore_id);
						$field_values_arr = array($uid, $ignore_id);
						$favorite_text = $this->LANG['mysolutions_ignore_user'];
						$class = 'clsBlockUser';

						//Add Activity
						if($this->CFG['admin']['index']['activity']['show'])
							{
								$activity_arr['action_key'] = 'remove_blocked';
								$activity_arr['owner_id'] = $ignore_id;
								$activity_arr['blocker_id'] = $uid;
								$activity_arr['content_id'] = $ignore_id;
								$this->generalActivityObj->addActivity($activity_arr);
							}
					}
				else
					{
						$fri_sql = 'DELETE FROM '.$this->CFG['db']['tbl']['friends_requests'].
								' WHERE request_from IN('.$uid.','.$ignore_id.') AND'.
								' request_to IN('.$uid.','.$ignore_id.')';

						$fri_stmt = $this->dbObj->Prepare($fri_sql);
						$fri_rs = $this->dbObj->Execute($fri_stmt);
						if (!$fri_rs)
							    trigger_db_error($this->dbObj);

						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['block_members'].
								' SET user_id = '.$this->dbObj->Param($uid).
								', block_id = '.$this->dbObj->Param($ignore_id);
						$field_values_arr = array($uid, $ignore_id);
						$favorite_text = $this->LANG['mysolutions_unignore_user'];
						$class = 'clsUnblockUser';

						//Add Activity
						if($this->CFG['admin']['index']['activity']['show'])
							{
								$activity_arr['action_key'] = 'user_blocked';
								$activity_arr['owner_id'] = $ignore_id;
								$activity_arr['blocker_id'] = $uid;
								$activity_arr['content_id'] = $ignore_id;
								$this->generalActivityObj->addActivity($activity_arr);
							}
					}
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $field_values_arr);
				if (!$rs)
					    trigger_db_error($this->dbObj);

				$updateIgnoreUser_arr['favorite_solutions']['title'] = $favorite_text;
				$updateIgnoreUser_arr['favorite_solutions']['class'] = $class;
				return $updateIgnoreUser_arr;
			}

		/**
		 * SolutionRatingHandler::displayUserDetails()
		 *
		 * @return
		 */
		public function displayUserDetails()
		    {
				global $smartyObj;
				$this->fields_arr['uid'] = $this->fields_arr['block_id'];
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
				$this->displayUserDetails_arr['mysolutions_url']	= getMemberUrl($this->user_details['user_id'], $mcomp);
				$this->displayUserDetails_arr['email']	=	$this->user_details['email'];
				$this->displayUserDetails_arr['mysolutions_mem_url']	= getMemberUrl($this->user_details['user_id'], $mcomp, 'members');
				$this->displayUserDetails_arr['members_url']	=	getUrl('mailcompose', '?mcomp='.$mcomp, '?mcomp='.$mcomp, 'members');

				$this->displayUserDetails_arr['toggleFavorites']	=	'toggleFavorites(\''.getUrl('favoritesolutions','','','members',$this->CFG['admin']['index']['home_module']).'\', \'cid='.$this->fields_arr['uid'].'&amp;ctype=User\', \'selShowFavoriteText_User_'.$this->fields_arr['uid'].'\'); return false;';
				$this->displayUserDetails_arr['toggleFavorites1']	=	'ajaxUpdateDiv(\''.getUrl('favoritesolutions','','','members',$this->CFG['admin']['index']['home_module']).'\', \'block_id='.$this->fields_arr['uid'].'\', \'upDating\'); return false;';

				$this->displayUserDetails_arr['date']	=	date('M d, Y', strtotime($this->user_details['doj']));
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
										//die('hards....');
										$this->displayUserDetails_arr['isAmBlocked'] = true;
										if ($friHandler->isBlockedByMe($this->fields_arr['uid']))
											$this->LANG['friend_request_blocked'] = $this->LANG['friend_request_blocked_by_me'];
									}
							}

						if($this->user_details['gender'] == 'Male')
							$this->displayUserDetails_arr['about_txt'] = $this->LANG['about_him'];
						else
							$this->displayUserDetails_arr['about_txt'] = $this->LANG['about_her'];
					}

				return 	$this->displayUserDetails_arr;
	    }
	}
//----------------------------- Code begins ------------------>>>>>//
$solutionRating = new SolutionRatingHandler();
if($CFG['admin']['index']['activity']['show'])
	{
		$GeneralActivity = new DiscussionsActivityHandler();
		$solutionRating->generalActivityObj = $GeneralActivity;
	}
$solutionRating->setPageBlockNames(array('favorite_content', 'ignore_user'));

$solutionRating->setFormField('cid', '');
$solutionRating->setFormField('block_id', '');
$solutionRating->setFormField('ctype', '');
$solutionRating->setFormField('uid', '');

$solutionRating->favorite_solutions_url = getUrl('favoritesolutions','','','',$CFG['admin']['index']['home_module']);

$solutionRating->sanitizeFormInputs($_REQUEST);
if ($solutionRating->isFormGETed($_REQUEST, 'cid'))
	{
		$solutionRating->favorite_content_arr = array();
		$solutionRating->favorite_content_arr = $solutionRating->updateFavoriteContent();
		$solutionRating->setPageBlockShow('favorite_content');
	}
elseif ($solutionRating->isFormGETed($_GET, 'block_id'))
	{
		if (!isMember())
			{
				echo 'Session Expired. <a href="'.$CFG['auth']['login_url']['url'].'?r">Login to continue..!</a>';
				die();
			}
		ob_start();
		$solutionRating->updateIgnoreUser();
		$solutionRating->form_user_details['displayUserDetails'] = $solutionRating->displayUserDetails();
		$solutionRating->includeAjaxHeader();
		setTemplateFolder('general/', $CFG['admin']['index']['home_module']);
		$smartyObj->display('topContributorsAjax.tpl');
		$solutionRating->includeAjaxFooter();
		die();
	}
//<<<<<------------------------- Code ends ----------------------------------//
//include the header file
$solutionRating->includeAjaxHeader();
//include the content of the page
setTemplateFolder('members/', $CFG['admin']['index']['home_module']);
$smartyObj->display('favoriteSolutions.tpl');
//<<<<<<--------------------Page block templates Ends--------------------//
//include the footer of the page
$solutionRating->includeAjaxFooter();
?>