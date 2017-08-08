<?php
/**
 * This file is to add commets for photos
 *
 * This file is having PostComment class to add commets for photos
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 * @author 		selvaraj_35ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: photoPostComment.php 1345 2006-06-21 01:41:52Z selvaraj_35ag05 $
 * @since 		2006-05-02
 *
 **/
require_once('./common/configs/config.inc.php');
$CFG['mods']['include_files'][] = 'common/configs/config_members_profile.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_GeneralActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/general/profileComments.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------------------class PostComment-------------------->>>
/**
 * PostComment
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class PostComment extends MediaHandler
	{
	  	/**
	  	 * PostComment::setGeneralActivityObject()
	  	 *
	  	 * @param mixed $generalActivityObj
	  	 * @return
	  	 */
	  	public function setGeneralActivityObject($generalActivityObj)
			{
				$this->generalActivityObj = $generalActivityObj;
			}

		/**
		 * PostComment::addUserComment()
		 *
		 * @return
		 */
		public function addUserComment()
			{
				$userId = $this->fields_arr['user_id'];
				$currentUserId = $this->CFG['user']['user_id'];
				$comment = $this->fields_arr['comment'];
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['users_profile_comments'].
					   ' SET profile_user_id='.$this->dbObj->Param($userId).
					   ', comment_user_id='.$this->dbObj->Param($currentUserId).
					   ', date_added = NOW(), comment='.$this->dbObj->Param($comment);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($userId, $currentUserId, $comment));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$profile_comment_id = $this->dbObj->Insert_ID();

				//SEND MAIL TO OWNER
				if($this->CFG['user']['user_id'] != $userId)
					{
						if(chkIsAllowedNotificationEmail('new_profile_scrap', $userId))
							{
								$this->sendMailToUserForProfileComment();
							}
					}

				//Add Activity
				if($this->CFG['admin']['show_recent_activities'])
					{
						$activity_arr['action_key'] = 'new_scrap';
						$activity_arr['owner_id'] = $userId;
						$activity_arr['actor_id'] = $this->CFG['user']['user_id'];
						$activity_arr['profile_comment_id'] = $profile_comment_id;

						$user_details = $this->getUserDetail('user_id', $userId);
						$activity_arr['user_name'] = $user_details['user_name'];
						$this->generalActivityObj->addActivity($activity_arr);
					}
			}

		/**
		 * PostComment::displayProfileComments()
		 *
		 * @return
		 */
		public function displayProfileComments()
			{
			   	global $smartyObj;
				$limit = 4;
				$userId = $this->fields_arr['user_id'];
				$sql = 'SELECT COUNT(users_profile_comment_id) AS cnt FROM '.$this->CFG['db']['tbl']['users_profile_comments'].' AS pc'.
				 		' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' u ON u.user_id = pc.comment_user_id'.
				 		' WHERE pc.profile_user_id='.$this->dbObj->Param($userId).' AND u.usr_status=\'Ok\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($userId));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$totalResults = $row['cnt'];
				$comment_arr=array();
				$inc=0;
				if ($totalResults > 0)
				    {
						$sql = 'SELECT users_profile_comment_id, comment, comment_user_id, u.icon_id, u.icon_type,u.image_ext'.
								', u.user_name, u.sex, date_added as display_date_added'.
							   	' FROM '.$this->CFG['db']['tbl']['users_profile_comments'].' AS pc'.
							   	' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' u ON u.user_id = pc.comment_user_id'.
							   	' WHERE pc.profile_user_id='.$this->dbObj->Param($userId).' AND u.usr_status=\'Ok\''.
								' ORDER BY pc.users_profile_comment_id DESC'.
							   	' LIMIT 0,'.$limit;
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($userId));
						if (!$rs)
							trigger_db_error($this->dbObj);

						$commentedUserIcon = array();
			    		while($row = $rs->FetchRow())
						    {
								if (!isset($commentedUserIcon[$row['comment_user_id']]))
								    {
								     	$commentedUserIcon[$row['comment_user_id']] = getMemberAvatarDetails($row['comment_user_id']);
								    }
								$profileIcon = $commentedUserIcon[$row['comment_user_id']];
								$comment_arr[$inc]['profileIcon'] = $profileIcon;
								$online = '';
								$comment_arr[$inc]['online']=$online;
								$commentorProfileUrl = getMemberProfileUrl($row['comment_user_id'], $row['user_name']);
								$comment_arr[$inc]['commentorProfileUrl'] = $commentorProfileUrl;
								$comment_arr[$inc]['user_name'] = $row['user_name'];
								$comment_arr[$inc]['display_date_added'] = $row['display_date_added'];
								$comment_arr[$inc]['comment'] = wordWrap_mb_ManualWithSpace($row['comment'], $this->CFG['profile']['scraps_total_length']);
								$inc++;
		           			} // while
				    }
				else
					{
					   $comment_arr=0;
					}
				$smartyObj->assign('profile_scrap_box_id',$this->CFG['profile_box_id']['scraps_list']);
				$smartyObj->assign('ajax_comment_arr',$comment_arr);
				$smartyObj->assign('totalResults',$totalResults);
				setTemplateFolder('general/');
				$smartyObj->display('profileMyscrapsResponse.tpl');
			}

		 /**
		  * PostComment::totalComments()
		  *
		  * @return
		  */
		 public function totalComments()
			{
				$userId = $this->fields_arr['user_id'];
				$sql = 'SELECT COUNT(users_profile_comment_id) AS cnt FROM '.$this->CFG['db']['tbl']['users_profile_comments'].
						' WHERE profile_user_id='.$this->dbObj->Param($userId);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($userId));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$totalResults = $row['cnt'];

				return $totalResults;
			}
		/**
		 * PostComment::getUserDetailsArrFromDB()
		 *
		 * To get the user details from the DB
		 *
		 * @param 		string $table_name table name
		 * @param 		array $fields_arr Array of fields
		 * @param 		integer $user_id user id
		 * @return 		array has array with field values
		 * @access 		public
		 */
		public function getUserDetailsArrFromDB($table_name, $fields_arr=array(), $alias_fields_arr=array())
		{
			$user_id = $this->fields_arr['user_id'];
			$sql = 'SELECT ';
			foreach($fields_arr as $field_name)
					$sql .= $field_name . ', ';
			$sql = substr($sql, 0, strrpos($sql, ','));
			$sql .= ' FROM '.$table_name.
					' WHERE user_id='.$this->dbObj->Param($user_id);
			// prepare sql
			$stmt = $this->dbObj->Prepare($sql);
			// execute sql
			$rs = $this->dbObj->Execute($stmt, array($user_id));
			//raise user error... fatal
			if (!$rs)
				trigger_db_error($this->dbObj);

			$row = array();
			if ($rs->PO_RecordCount())
				{
					$row = $rs->FetchRow();
				}
			$ret_fields_arr = array();
			$fields_arr = array_merge($fields_arr, $alias_fields_arr);
			foreach($fields_arr as $field_name)
				$ret_fields_arr[$field_name] = isset($row[$field_name]) ? $row[$field_name] : '';
			return $ret_fields_arr;
		}

		/**
		 * PostComment::haveRightToViewThisProfile()
		 *
		 * @return
		 */
		public function haveRightToViewThisProfile()
		{
			$current = $this->CFG['user']['user_id'];
			$friend  = $this->fields_arr['user_id'];
			$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['friends_list'].
					' WHERE (owner_id='.$current.' AND friend_id='.$friend.') LIMIT 1';
			// prepare sql
			$stmt = $this->dbObj->Prepare($sql);
			// execute sql
			$rs = $this->dbObj->Execute($stmt, array($current, $friend));
			//raise user error... fatal
			if (!$rs)
				trigger_db_error($this->dbObj);

			return $rs->PO_RecordCount();
		}
		/**
		 * PostComment::chkBlockedUser()
		 *
		 * @return
		 */
		public function chkBlockedUser()
		{
			$blocked_User_Id = $this->fields_arr['user_id'];
			$logged_User_Id = $this->CFG['user']['user_id'];
			$sql = 'SELECT COUNT(id) AS count'.
					' FROM '.$this->CFG['db']['tbl']['block_members'].
					' WHERE user_id = '.$this->dbObj->Param('user_id').
					' AND block_id='.$this->dbObj->Param('block_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($blocked_User_Id, $logged_User_Id));
			if (!$rs)
				trigger_db_error($this->dbObj);

			$row = $rs->FetchRow();
			return $row['count'];
		}
	}
//<<<<<-------------- Class PostComment ends ---------------//
//-------------------- Code begins -------------->>>>>//
$postComment = new PostComment();
if($CFG['admin']['show_recent_activities'])
	{
		$GeneralActivity = new GeneralActivityHandler();
		$postComment->setGeneralActivityObject($GeneralActivity);
	}

$postComment->setPageBlockNames(array('msg_form_info', 'form_post_comment', 'form_view_comments'));
$postComment->setFormField('user_id', 0);
$postComment->setFormField('u', 0);
$postComment->setFormField('comment', '');

if ($postComment->isFormPOSTed($_POST, 'ajxComment'))
    {
        $postComment->sanitizeFormInputs($_POST);
		$postComment->setFormField('user_id', $postComment->getFormField('u'));
		$postComment->chkIsNotEmpty('comment', $LANG['err_tip_compulsory']);
		if($postComment->isValidFormInputs())
			{
				//$postComment->includeAjaxHeaderSessionCheck();
				// check whether the login user can post scrap for the selected profile
				$can_post_scrap = false;

				if(!isMember())
				{
					$postComment->setPageBlockShow('block_msg_form_error');
					$postComment->setCommonErrorMsg($LANG['common_login_msg']);
				}
				else
				{

					$user_details_arr = $postComment->getUserDetailsArrFromDB($CFG['db']['tbl']['users'],
																 array(	'user_id','user_name', 'usr_status','icon_type', 'icon_id', 'first_name','last_name', 'show_profile', 'allow_comment')
																);

					if (strcmp($user_details_arr['usr_status'], 'Ok')==0)
				    {
						$toAll = (strcmp($user_details_arr['show_profile'], 'All')==0);
						$toMembers = (strcmp($user_details_arr['show_profile'], 'Members')==0);
						$toFriends = (strcmp($user_details_arr['show_profile'], 'Friends')==0);
						$currentAccount = (strcmp($CFG['user']['user_id'], $postComment->getFormField('user_id'))==0);

						if ($currentAccount OR $toAll OR $toMembers OR ($toFriends AND $postComment->haveRightToViewThisProfile()))
					    {
							if ($currentAccount)
						    {
								$postComment->setPageBlockShow('block_msg_form_error');
						        $postComment->setCommonErrorMsg($LANG['profile_comment_msg_current_user']);
						    }
							else
							{
								if (strcmp($user_details_arr['allow_comment'], 'No')==0)
							    {
									$postComment->setPageBlockShow('block_msg_form_error');
									$postComment->setCommonErrorMsg($LANG['profile_comment_msg_comments_not_allowed']);
							    }
								else
								{
									if (isMember() && !$postComment->chkBlockedUser())
								    {
										$can_post_scrap = true;
								    }
									else
									{
										$postComment->setCommonErrorMsg($LANG['profile_comment_msg_blocked_user_comments_not_allowed']);
										$postComment->setPageBlockShow('block_msg_form_error');
									}
								}
							}
					    }
						else
						{
							$postComment->setPageBlockShow('block_msg_form_error');
							$postComment->setCommonErrorMsg($LANG['profile_comment_msg_private_account']);
						}
					}
					else
					{
						$postComment->setPageBlockShow('block_msg_form_error');
						$postComment->setCommonErrorMsg($LANG['profile_comment_inactive_user']);
					}
				}

				if($can_post_scrap)
				{
					$htmlstring = nl2br($postComment->getFormField('comment'));
					$htmlstring = html_entity_decode($htmlstring);
					$postComment->setFormField('comment',trim($htmlstring));
					$postComment->addUserComment();
					$postComment->setFormField('comment', '');
				}

				//include the header file
				$postComment->includeAjaxHeader();
				$postComment->displayProfileComments();
				//includ the footer of the page
				$postComment->includeAjaxFooter();
				die();
			}
    }
elseif ($postComment->isFormPOSTed($_POST, 'ajxUpdateCommentCount'))
	{
        $postComment->sanitizeFormInputs($_POST);
		$postComment->setFormField('user_id', $postComment->getFormField('u'));
		//include the header file
		$postComment->includeAjaxHeader();
		echo $postComment->totalComments();
		//includ the footer of the page
		$postComment->includeAjaxFooter();
		die();
	}
else
	{
		die();
	}
?>