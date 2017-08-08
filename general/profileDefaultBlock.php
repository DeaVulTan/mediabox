<?php
/**
 * IndexPageNewPeopleHandler
 *
 * @package
 * @author edwin_90ag08
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id$
 * @access public
 */
class profilePageBlockHandler extends MediaHandler
	{
		public $isCurrentUser = false;
	    public $showEditableLink = false;
	    public $js_string_data = '';
	    public $block_show_htmlfields = array();

		/**
		 * profilePageBlockHandler::getMyScraps()
		 *
		 * @param mixed $currentAccount
		 * @return
		 */
		public function getMyScraps($currentAccount = false)
			{
			   	global $smartyObj;
				$limit = 4;
				$currentUserId = $this->getCurrentUserId();
				$sql = 'SELECT COUNT(users_profile_comment_id) AS cnt FROM '.$this->CFG['db']['tbl']['users_profile_comments'].' AS pc'.
						 ' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' u ON u.user_id = pc.comment_user_id'.
						 ' WHERE pc.profile_user_id='.$this->dbObj->Param($currentUserId).'  AND u.usr_status=\'Ok\'';
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($currentUserId));
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$totalResults = $row['cnt'];
				$comment_arr = array();
				$inc = 0;
				if ($totalResults > 0)
				    {
						$sql = 'SELECT users_profile_comment_id, comment, comment_user_id, u.icon_id, u.icon_type, u.image_ext'.
								', u.user_name, u.sex,TIMEDIFF(NOW(), pc.date_added) as display_date_added'.
								' FROM '.$this->CFG['db']['tbl']['users_profile_comments'].' AS pc'.
							   	' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' u ON u.user_id = pc.comment_user_id'.
							   	' WHERE pc.profile_user_id='.$this->dbObj->Param($currentUserId).' AND u.usr_status=\'Ok\''.
								' ORDER BY pc.users_profile_comment_id DESC'.
							   	' LIMIT 0,'.$limit;
						// prepare sql
						$stmt = $this->dbObj->Prepare($sql);
						// execute sql
						$rs = $this->dbObj->Execute($stmt, array($currentUserId));
						//raise user error... fatal
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
								$comment_arr[$inc]['profileIcon']=$profileIcon;
								$online = '';
								$comment_arr[$inc]['online']=$online;
								$commentorProfileUrl = getMemberProfileUrl($row['comment_user_id'], $row['user_name']);
								$comment_arr[$inc]['commentorProfileUrl']=$commentorProfileUrl;
								$comment_arr[$inc]['user_name']=$row['user_name'];
								$comment_arr[$inc]['display_date_added']=($row['display_date_added'] != '') ? getTimeDiffernceFormat($row['display_date_added']) : '';
								$comment_arr[$inc]['comment']=wordWrap_mb_ManualWithSpace($row['comment'],$this->CFG['profile']['scraps_total_length']);
								$inc++;
							} // while
					}
				else
					{
					   $comment_arr=0;
					}
				//return $totalResults;
				$smartyObj->assign('comment_arr',$comment_arr);
				$smartyObj->assign('totalResults',$totalResults);
				$profileCommentURL=getUrl('profilecomments','?user_id='.$this->fields_arr['user_id'], '?user_id='.$this->fields_arr['user_id']);
				$smartyObj->assign('profileCommentURL',$profileCommentURL);
				$smartyObj->assign('myobj', $this);
			}

		/**
		 * profilePageBlockHandler::chkBlockedUser()
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
				$rs = $this->dbObj->Execute($stmt, array($blocked_User_Id,$logged_User_Id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $row['count'];
			}

		/**
		 * profilePageBlockHandler::getMyFriends()
		 *
		 * @param integer $start
		 * @param integer $friendLimit
		 * @return
		 */
		public function getMyFriends($start=0, $friendLimit=4)
			{
			   	global $smartyObj;

				$sql = 'SELECT u.user_id,u.user_name,u.icon_id,u.icon_type,u.image_ext,u.logged_in,u.sex,t.friend_id'.
						' FROM '.$this->CFG['db']['tbl']['top_friends'].' as t LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u'.
						' ON u.user_id = t.friend_id'.
						' WHERE t.user_id='.$this->fields_arr['user_id'].
						' AND u.usr_status=\'Ok\''.
						' ORDER BY friend_order ASC LIMIT '.$start.','.$friendLimit;
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt);
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = array();
				$friends_list_arr = array();
				$inc = 0;
				if ($rs->PO_RecordCount())
					{
				    	 while($row = $rs->FetchRow())
							{
								$userDetails = $this->getUserDetail('user_id', $row['user_id']);
								$friendName = isset($userDetails['user_name'])?$userDetails['user_name']:'';
								$icon = getMemberAvatarDetails($row['user_id']);
								$friends_list_arr[$inc]['friendName'] = $friendName;
								$friends_list_arr[$inc]['friendicon'] = getMemberAvatarDetails($row['user_id']);
								$friends_list_arr[$inc]['record'] = $row;
								$friends_list_arr[$inc]['firiendProfileUrl'] = getMemberProfileUrl($row['user_id'], $row['user_name']);

								if(!$friendName)
									continue;
								$inc++;

						    } // while
			     	}
				$friend_id_count =count($friends_list_arr);
				$friend_id_arr=array();
			    for($i=0;$i<$friend_id_count;$i++)
				    {
				 	 	$friend_id_arr[]=$friends_list_arr[$i]['record']['friend_id'];
					}
				$friend_ids=implode('\',\'',$friend_id_arr);
				$endLimit=$friendLimit-$friend_id_count;
				if($friend_id_count<$friendLimit)
					{
						$sql = 'SELECT u.user_id,u.user_name,u.icon_id,u.icon_type,u.image_ext,u.logged_in,u.sex,f.friend_id'.
								' FROM '.$this->CFG['db']['tbl']['friends_list'].' as f LEFT JOIN '.$this->CFG['db']['tbl']['users'].' as u'.' ON (u.user_id = f.friend_id OR u.user_id = f.owner_id)'.
								' WHERE f.owner_id='.$this->dbObj->Param($this->fields_arr['user_id']).
								' AND (u.user_id !='.$this->dbObj->Param($this->fields_arr['user_id']).' AND usr_status = \'Ok\')'.
								' AND NOT EXISTS (SELECT 1 FROM '.$this->CFG['db']['tbl']['top_friends'].' AS t LEFT JOIN '.$this->CFG['db']['tbl']['users'].' as u1 ON u1.user_id = t.friend_id WHERE t.user_id='.$this->dbObj->Param($this->fields_arr['user_id']).' AND u1.usr_status=\'Ok\' AND u1.user_id = u.user_id)'.
								' LIMIT '.$start.','.$endLimit;
				    	$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id'], $this->fields_arr['user_id'], $this->fields_arr['user_id']));
						if (!$rs)
							trigger_db_error($this->dbObj);

				    	if ($rs->PO_RecordCount())
							{
						    	while($row = $rs->FetchRow())
									{
										$userDetails = $this->getUserDetail('user_id', $row['user_id']);
										$friendName = isset($userDetails['user_name'])?$userDetails['user_name']:'';
										$icon = getMemberAvatarDetails($row['user_id']);
										$friends_list_arr[$inc]['friendName'] = $friendName;
										$friends_list_arr[$inc]['friendicon'] = getMemberAvatarDetails($row['user_id']);
										$friends_list_arr[$inc]['record'] = $row;
										$friends_list_arr[$inc]['firiendProfileUrl'] = getMemberProfileUrl($row['user_id'], $row['user_name']);

										if(!$friendName)
											continue;
										$inc++;
							    	} // while
					    	}
					}
				$chk_friends =count($friends_list_arr);
				if($chk_friends==0)
					{
						$friends_list_arr=0;
					}
				$smartyObj->assign('friends_list_arr', $friends_list_arr);
        		$userfriendlistURL=getUrl('viewfriends','?user='.$this->getCurrentUser(), $this->getCurrentUser().'/');
        		$smartyObj->assign('userfriendlistURL', $userfriendlistURL);
			}

		/**
		 * profilePageBlockHandler::getCurrentUser()
		 *
		 * @return
		 */
		public function getCurrentUser()
			{
			   	$sql = 'SELECT user_name'.
						' FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					return $answer = $row['user_name'];
			}

		/**
		 * profilePageBlockHandler::getAllProfileInfo()
		 *
		 * @param mixed $currentAccount
		 * @return
		 */
		public function getAllProfileInfo($currentAccount = false)
			{
				global $smartyObj;

				$sql_cat = 'SELECT id AS cat_id, title FROM '.$this->CFG['db']['tbl']['users_profile_category'].
							' WHERE status = \'Yes\'';
				$stmt_cat = $this->dbObj->Prepare($sql_cat);
				$rs_cat = $this->dbObj->Execute($stmt_cat);
				if (!$rs_cat)
					    trigger_db_error($this->dbObj);
				$return_profile_info_arr = array();
				$cat_cnt = 0;
				while($row_cat = $rs_cat->FetchRow())
					{
						$sql = 'SELECT id,form_id,question,question_type,rows,order_no,width,instruction,options,answer_required,error_message,default_value,max_length,display '.
								' FROM '.$this->CFG['db']['tbl']['users_profile_question'].
								' WHERE form_id = '.$this->dbObj->Param('form_id').
								' ORDER BY order_no ASC ';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt,array($row_cat['cat_id']));
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						$profile_info_arr = array();
						$inc=0;
						$profile_info_count = 0;
						while($row = $rs->FetchRow())
							{
								$answer_arr=$this->populateAnswer($row['id']);
								if($this->getQuestionType($row['id'])=='checkbox')
									{
										$answer='';
									 	foreach($answer_arr as $value)
										   	{
												$answer.=$value.'/';
										   	}
									 	$answer=substr($answer, 0, strrpos($answer, '/'));
									}
								else
									{
										$answer=((count($answer_arr)>0)?$answer_arr[0]:'');
									}
								$ans=($answer==''?$row['default_value']:$answer);
								if($ans!='' && $ans!=$this->CFG['profile']['question_no_answer'])
									{
										$profile_info_count = 1;
										$profile_info_arr[$inc]['answer_result']=wordWrap_mb_Manual($ans,$this->CFG['profile']['scraps_total_length']);
										$profile_info_arr[$inc]['form_id'] = $row['form_id'];
										$profile_info_arr[$inc]['question'] = $row['question'];
										$profile_info_arr[$inc]['id'] = 'otherinfo'.$inc;
										$profile_info_arr[$inc]['content_id'] = 'otherinfocontent'.$inc;
										$profile_info_arr[$inc]['info_id'] = $row['id'];
										//default text area ..
										$profile_info_arr[$inc]['sel_id'] = 'seltext_'.$row['id'].'_'.$row['form_id'];
										$profile_info_arr[$inc]['class_name'] = 'editablearea_info';
										if($this->getQuestionType($row['id'])=='select' or $this->getQuestionType($row['id']) == 'checkbox' or $this->getQuestionType($row['id']) == 'radio')
											{
												$profile_info_arr[$inc]['class_name'] = ($this->getQuestionType($row['id'])=='select' or $this->getQuestionType($row['id']) == 'radio') ? 'editableselect_info' : 'editablecheck_info';
												$profile_info_arr[$inc]['sel_id'] = ($this->getQuestionType($row['id'])=='select' or $this->getQuestionType($row['id']) == 'radio') ? 'selselect_'.$row['id'].'_'.$row['form_id'] : 'selcheck_'.$row['id'].'_'.$row['form_id'];
												$this->PopulateSelectDataArray($row['id'], $row['options'], $ans);
											}
									}
								$inc++;
							}

			    		if($inc && $profile_info_count)
							{
								$return_profile_info_arr[$cat_cnt]['profile_info'] = $profile_info_arr;
								$return_profile_info_arr[$cat_cnt]['cat_id'] = $row_cat['cat_id'];
								$return_profile_info_arr[$cat_cnt]['title'] = $row_cat['title'];
								$return_profile_info_arr[$cat_cnt]['css_class_name'] = 'cls'.ucfirst($this->getProfileBlockName($row_cat['cat_id'])).'Table';
								$cat_cnt++;
							}

			    	}
				$smartyObj->assign('profile_info_arr', $return_profile_info_arr);
			}
		/**
		 * profilePageBlockHandler::getProfileBlockName()
		 *
		 * @return
		 */
		public function getProfileBlockName($cat_id)
			 {
			 	$sql = 'SELECT block_name FROM '.$this->CFG['db']['tbl']['profile_block'].
				 		' WHERE profile_category_id = '.$this->dbObj->Param('cat_id');
			 	$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($cat_id));
				if (!$rs)
				    trigger_db_error($this->dbObj);

			 	if($row = $rs->FetchRow())
					return $form_id = $row['block_name'];
				return 0;
			 }


		/**
		 * profilePageBlockHandler::PopulateSelectDataArray()
		 * for populating the data array to be used for edit in place ..
		 *
		 * @param mixed $id
		 * @param mixed $options_value
		 * @param mixed $ans
		 * @return
		 */
		public function PopulateSelectDataArray($id, $options_value, $ans)
			{
				$explode_arr = explode("\n", $options_value);
				$option_arr=array();
				foreach($explode_arr as $key=>$value)
					{
						if(strlen(trim($value)))
							{
							    $option_arr[$value]=trim($value);
							}
					}
				$option_arr['selected'] = $ans;
				$this->js_string_data .= 'var infoarray_'.$id. ' = '.json_encode($option_arr).";\r\n";
			}


		/**
		 * profilePageBlockHandler::populateAnswer()
		 *
		 * @param mixed $question_id
		 * @return
		 */
		public function populateAnswer($question_id)
			{
			  	$sql = 'SELECT answer'.
						' FROM '.$this->CFG['db']['tbl']['users_profile_info'].
						' WHERE user_id='.$this->dbObj->Param('user_id').
						' AND question_id='.$this->dbObj->Param('question_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($this->fields_arr['user_id'],$question_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$answer=array();
				$inc=0;
				while($row = $rs->FetchRow())
					{
						 $answer[$inc] = $row['answer'];
						 $inc++;
					}
				return $answer;
			}

		/**
		 * profilePageBlockHandler::getQuestionType()
		 *
		 * @param mixed $question_id
		 * @return
		 */
		public function getQuestionType($question_id)
			{
	          	$sql = 'SELECT question_type '.
						' FROM '.$this->CFG['db']['tbl']['users_profile_question'].
						' WHERE id='.$this->dbObj->Param('question_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($question_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					return $row['question_type'];
			}

		/**
		 * profilePageBlockHandler::setUserId()
		 *
		 * @return
		 */
		public function setUserId()
			{
				$userName = $this->fields_arr['user'];
				$sql = 'SELECT user_id FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_name='.$this->dbObj->Param($userName).' AND usr_status=\'Ok\' LIMIT 1';
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($userName));
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);
				$row = array();
				if ($rs->PO_RecordCount())
					{
				        $row = $rs->FetchRow();
						$this->fields_arr['user_id'] = $row['user_id'];
						$this->isValidUser = true;
						$this->isCurrentUser = (strcmp($this->CFG['user']['user_id'], $this->fields_arr['user_id'])==0);
						$edit = $this->fields_arr['edit'];
						$edit = (strcmp($edit, '1')==0);
						$this->showEditableLink = ($this->isCurrentUser and $edit);
					}
			}

		/**
		 * profilePageBlockHandler::checkUserId()
		 *
		 * @return
		 */
		public function checkUserId()
			{
				$user_id = $this->fields_arr['user_id'];
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_id='.$this->dbObj->Param($user_id);
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($user_id));
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = array();
				$this->isValidUser = ($rs->PO_RecordCount() > 0);
				$this->isCurrentUser = (strcmp($this->CFG['user']['user_id'], $user_id)==0);
				$edit = $this->fields_arr['edit'];
				$edit = (strcmp($edit, '1')==0);
				$this->showEditableLink = ($this->isCurrentUser and $edit);
			}

		/**
		 * profilePageBlockHandler::getCurrentUserId()
		 *
		 * @return
		 */
		public function getCurrentUserId()
			{
				return $this->fields_arr['user_id'];
			}

		/**
		 * profilePageBlockHandler::chkAllowComment()
		 *
		 * @return
		 */
		public function chkAllowComment()
			{
			  	$sql = 'SELECT allow_comment'.
						' FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($this->fields_arr['user_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					return $answer = $row['allow_comment'];
			}

		/**
		 * profilePageBlockHandler::displayProfileComments()
		 *
		 * @param mixed $currentAccount
		 * @return
		 */
		public function displayProfileComments($currentAccount = false)
			{
				$limit = 4;
				$currentUserId = $this->getCurrentUserId();
				$sql = 'SELECT COUNT(users_profile_comment_id) AS cnt FROM '.$this->CFG['db']['tbl']['users_profile_comments'].
						' WHERE profile_user_id='.$this->dbObj->Param($currentUserId);
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($currentUserId));
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$totalResults = $row['cnt'];

				return $totalResults;
			}

		/**
		 * profilePageBlockHandler::getAboutMe()
		 *
		 * @return
		 */
		public function getAboutMe()
			{
			 	global $smartyObj;
			 	$about_me='';
			 	$this->aboutme_tpl=false;

			  	$sql = 'SELECT about_me'.
						' FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($this->fields_arr['user_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					 {
					 	$about_me = wordWrap_mb_Manual($row['about_me'],$this->CFG['profile']['aboutme_total_length']);
					 	if (!trim($about_me) AND $this->CFG['user']['user_id'] == $this->fields_arr['user_id'])
					 		$about_me = $this->LANG['commmon_tell_about_yourself'];
					  	if($about_me)
					  		$this->aboutme_tpl = true;
					 }

			     $smartyObj->assign('about_me', $about_me);
			     $smartyObj->assign('about_me_class', 'editablearea_basic');
			     $smartyObj->assign('about_me_id', 'sel_aboutme');
			}

		/**
		 * profilePageBlockHandler::getMySubscribers()
		 *
		 * @param integer $start
		 * @param integer $limit
		 * @return
		 */
		public function getMySubscribers($start=0, $limit=4)
			{
			   	global $smartyObj;

				$sql = 'SELECT u.user_id, u.user_name, icon_id, icon_type, image_ext, sex FROM '.$this->CFG['db']['tbl']['subscription'].' as s '.
						' INNER JOIN '.$this->CFG['db']['tbl']['users'].' as u ON s.subscriber_id = u.user_id'.
						' WHERE u.usr_status=\'Ok\' AND s.owner_id='.$this->dbObj->Param($this->fields_arr['user_id']).
						' AND s.status=\'Yes\' LIMIT '.$start.','.$limit;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$member_subscription_arr = array();

				$inc = 0;
				if($rs->PO_RecordCount())
					{
						$found = true;
						while($row = $rs->FetchRow())
							{
								$member_subscription_arr[$inc]['memberProfileUrl'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
								$member_subscription_arr[$inc]['profileIcon']= getMemberAvatarDetails($row['user_id']);
								$member_subscription_arr[$inc]['record'] = $row;
								$inc++;
							}// while
					}
				$smartyObj->assign('subscribers_list_arr', $member_subscription_arr);
			}
	}
//-------------------- Code begins -------------->>>>>//
$defaultBlock = new profilePageBlockHandler();
$defaultBlock->setPageBlockNames(array('msg_form_error', 'show_profile_block', 'msg_form_private_account','form_show_profile', 'form_preview_layout'));
global $db;
global $CFG;
$defaultBlock->setFormField('user_id', 0);
$defaultBlock->setFormField('user', 0);
$defaultBlock->setFormField('edit', 0);
$smartyObj->assign('defaulBlockObj', $defaultBlock);
if ($defaultBlock->isPageGETed($_GET, 'user_id'))
    {
        $defaultBlock->sanitizeFormInputs($_GET);
		$defaultBlock->checkUserId();
    }

if ($defaultBlock->isPageGETed($_GET, 'user'))
    {
        $defaultBlock->sanitizeFormInputs($_GET);
		$defaultBlock->setUserId();
    }
if (isset($__myProfile)) //its declared in members/myProfile.php
    {
        $defaultBlock->setFormField('user_id', $CFG['user']['user_id']);
		$defaultBlock->setFormField('edit', '1');
		$defaultBlock->checkUserId();
    }
$currentAccount = (strcmp($CFG['user']['user_id'], $defaultBlock->getFormField('user_id'))==0);
$total = $defaultBlock->displayProfileComments($currentAccount);
$allow_comment_check = $defaultBlock->chkAllowComment();
//scraps start
$defaultBlock->form_show_profile['addcomment'] = false;
$defaultBlock->form_show_profile['listcomment'] = false;
$allowedToAddScrap = false;
if (!(!isMember() OR $currentAccount OR strcmp($allow_comment_check, 'No')==0))
    {
		$allowedToAddScrap = true;
		$defaultBlock->form_show_profile['addcomment']=true;
		$max_limit = $CFG['profile']['scraps_total_length'];
		$common_allowed_char_limit = str_replace('%n', $max_limit, $defaultBlock->LANG['common_allowed_char_limit']);
		$defaultBlock->LANG['common_allowed_char_limit'] = str_replace('%s', ($max_limit >1)?'s':'', $common_allowed_char_limit);
	}
if ($total OR $allowedToAddScrap)
    {
        $defaultBlock->form_show_profile['listcomment']=true;
	}
$defaultBlock->form_show_profile['is_blocked_user'] = $defaultBlock->chkBlockedUser();
$defaultBlock->getAboutMe();
$defaultBlock->getMyScraps();
$defaultBlock->getAllProfileInfo();
$defaultBlock->getMyFriends(0,$CFG['profile']['total_list_my_friends']);
$defaultBlock->getMySubscribers(0,$CFG['profile']['total_list_my_subscribers']);
$aboutme_tpl=$defaultBlock->aboutme_tpl;
$js_string_data = $defaultBlock->js_string_data;
$this_profileurl_script = '<script type="text/javascript" language="javascript">
var thisProfileUrl = \''.getMemberProfileUrl($defaultBlock->getFormField('user_id'), $defaultBlock->getFormField('user')).'\';
</script>';
?>