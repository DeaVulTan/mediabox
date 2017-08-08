<?php
/**
 * PostComment
 *
 * @package
 * @author selvaraj_35ag05
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: photoPostComment.php 1345 2006-06-21 01:41:52Z selvaraj_35ag05 $
 * @access public
 **/
class PostComment extends MediaHandler
	{
		public $isValidUser = false;
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
		 * PostComment::checkUserId()
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
			}

		/**
		 * PostComment::isValidUserId()
		 *
		 * @return
		 */
		public function isValidUserId()
			{
				return $this->isValidUser;
			}

		/**
		 * PostComment::setUserId()
		 *
		 * @return
		 */
		public function setUserId()
			{
				$userName = $this->fields_arr['user'];
				$sql = 'SELECT user_id FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_name='.$this->dbObj->Param($userName).
						' LIMIT 1';
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
					}
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
					   ', date_added = NOW()'.
					   ', comment='.$this->dbObj->Param($comment);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($userId, $currentUserId, $comment));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$profile_comment_id = $this->dbObj->Insert_ID();

				//SEND MAIL TO OWNER
				if($this->CFG['user']['user_id'] != $userId)
					$this->sendMailToUserForProfileComment();

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
				$usersPerRow = 4;
				$count = 0;
				$found = false;
				$currentAccount = (strcmp($this->fields_arr['user_id'], $this->CFG['user']['user_id'])==0);
				$commentedUserIcon = array();
				$sno = $this->getResultsStartNum();
				$editCount = 0;
				$profile_comment_arr = array();
				$inc = 0;
				while($row = $this->fetchResultRecord())
				    {
						$found = true;
						$sno++;
						$online = ($row['logged_in'])?$this->CFG['admin']['members']['online_anchor_attributes']:$this->CFG['admin']['members']['offline_anchor_attributes'];
						$online = str_replace('{online_status}', $this->LANG['online_status'], $online);
						$profile_comment_arr[$inc]['online']=$online;
						if (!isset($commentedUserIcon[$row['user_id']]))
						    {
						     	$commentedUserIcon[$row['user_id']] = getMemberAvatarDetails($row['user_id']);
						    }
						$editable = (strcmp($this->CFG['user']['user_id'], $row['user_id'])==0);
						$profile_comment_arr[$inc]['online']=$editable;
						$profileIcon = $commentedUserIcon[$row['user_id']];
						$profile_comment_arr[$inc]['profileIcon']=$profileIcon;
						$profile_comment_arr[$inc]['sno']=$sno;
						$profile_comment_arr[$inc]['editable']=false;
						if ($editable OR $currentAccount)
						    {
								$editCount++;
								$profile_comment_arr[$inc]['editable']=true;
								$profile_comment_arr[$inc]['users_profile_comment_id']=$row['users_profile_comment_id'];
						    }
						$profile_comment_arr[$inc]['MemberProfileUrl']=getMemberProfileUrl($row['user_id'], $row['user_name']);
						$profile_comment_arr[$inc]['user_name']=$row['user_name'];
						$profile_comment_arr[$inc]['comment_date']=$row['comment_date'];

						//$profile_comment_arr[$inc]['comment']= wordWrap_mb_Manual(html_entity_decode($row['comment']),$this->CFG['profile']['scraps_total_length']);
						$profile_comment_arr[$inc]['comment']= wordWrap_mb_ManualWithSpace($row['comment'],$this->CFG['profile']['scraps_total_length']);
						$inc++;
				    } // while

				$this->found=false;
				if ($found AND $editCount)
				    {
						$this->found=true;
				    }
				return $profile_comment_arr;
			}

		/**
		 * PostComment::buildConditionQuery()
		 *
		 * @return
		 */
		public function buildConditionQuery()
			{
				$this->sql_condition = ' pc.profile_user_id=\''.addslashes($this->fields_arr['user_id']).'\' AND u.usr_status=\'Ok\'';
			}

		/**
		 * PostComment::buildSortQuery()
		 *
		 * @return
		 */
		public function buildSortQuery()
			{
				$this->sql_sort = 'users_profile_comment_id DESC';
			}

		/**
		 * PostComment::removeComments()
		 *
		 * @param string $comments
		 * @return
		 */
		public function removeComments($comments='')
			{
				$affected = 0;
				//$comments = implode(',', $comments);
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['users_profile_comments'].
						' WHERE users_profile_comment_id IN('.$comments.')';
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt);
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);
		        $affected = $this->dbObj->Affected_Rows();
				return $affected;
			}

		/**
		 * PostComment::getCurrentUser()
		 *
		 * @return
		 */
		public function getCurrentUser()
			{
			   $sql = 'SELECT user_name'.
						' FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($this->fields_arr['user_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					return $answer = $row['user_name'];
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
//<<<<<-------------- Class PostComment begins ---------------//
//-------------------- Code begins -------------->>>>>//
$postComment = new PostComment();
if($CFG['admin']['show_recent_activities'])
	{
		$GeneralActivity = new GeneralActivityHandler();
		$postComment->setGeneralActivityObject($GeneralActivity);
	}

$postComment->setPageBlockNames(array('msg_form_info', 'form_post_comment', 'form_view_comments'));

$postComment->setFormField('numpg', $CFG['data_tbl']['numpg']);
$postComment->setFormField('start', '0');

$postComment->setFormField('user_id', 0);
$postComment->setFormField('u', 0);
$postComment->setFormField('comments', array());
$postComment->setFormField('comment', '');
$postComment->setFormField('user', '');
$postComment->setFormField('action', '');

$postComment->setMinRecordSelectLimit(2);
$postComment->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$postComment->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$postComment->setReturnColumns(array());
if ($postComment->isPageGETed($_GET, 'user_id'))
    {
        $postComment->sanitizeFormInputs($_GET);
		$postComment->checkUserId();
		$postComment->profile_url = getMemberProfileUrl($postComment->getFormField('user_id'), $postComment->getCurrentUser());
    	$postComment->page_title = str_replace('VAR_USER_NAME', ucfirst($postComment->getCurrentUser()), $LANG['profile_post_comment_user_name']);
    }

if ($postComment->isPageGETed($_GET, 'user'))
    {
        $postComment->sanitizeFormInputs($_GET);
		$postComment->setUserId();
    }
$postComment->setAllPageBlocksHide();

if ($postComment->isValidUserId())
    {
		$user_details_arr = $postComment->getUserDetailsArrFromDB($CFG['db']['tbl']['users'],
															 array(	'user_id','user_name', 'usr_status','icon_type', 'icon_id', 'first_name','last_name', 'show_profile', 'allow_comment')
															);
		$postComment->setPageBlockShow('form_view_comments');

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
												$postComment->setPageBlockShow('form_post_comment');
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
else
	{
		$postComment->setPageBlockShow('block_msg_form_error');
		$postComment->setCommonErrorMsg($LANG['profile_post_comment_msg_invalid_user']);
	}

if ($postComment->isShowPageBlock('form_post_comment'))
    {
		if ($postComment->isFormPOSTed($_POST, 'user_id'))
		    {
		       	$postComment->sanitizeFormInputs($_POST);
				if ($postComment->isFormPOSTed($_POST, 'comment_submit'))
				    {
				      	$postComment->chkIsNotEmpty('comment', $LANG['err_tip_compulsory']);
						if($postComment->isValidFormInputs())
							{
								//$StripTags = new StripTags();
								$htmlstring = nl2br($postComment->getFormField('comment'));
								$htmlstring = html_entity_decode($htmlstring);
								//$htmlstring = $StripTags->StripTagsAndClass($htmlstring,'textarea',$CFG['admin']['photos']['disallowed_tag'],$CFG['admin']['photos']['disallowed_empty_tag'],$CFG['admin']['photos']['disallowed_style_class'],$CFG['admin']['photos']['disallowed_attributes']);
								$postComment->setFormField('comment',trim($htmlstring));
								$postComment->addUserComment();
								$postComment->setFormField('comment', '');
								$postComment->setPageBlockShow('block_msg_form_success');
								$postComment->setCommonSuccessMsg($LANG['profile_comment_post_comment_success_message']);
							}
				    }
			}
    }
if ($postComment->isFormPOSTed($_POST, 'remove_comments'))
    {
        $postComment->chkIsNotEmpty('comments', $LANG['common_err_tip_required'])or
	    $postComment->setCommonErrorMsg($LANG['profile_comment_err_tip_select_comment']);
        $postComment->sanitizeFormInputs($_POST);
		$comments = $postComment->getFormField('comments');
		if ($comments)
		    {
				$deleted = $postComment->removeComments($comments);
				if ($deleted)
				    {
						if($deleted>1)
							$postComment->setCommonSuccessMsg($deleted.' '.$LANG['profile_comment_msg_comments_deleted']);
						else
							$postComment->setCommonSuccessMsg($deleted.' '.$LANG['profile_comment_msg_comments_deleted_single']);

						$postComment->setPageBlockShow('block_msg_form_success');
					}
		    }
    }
//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($postComment->isShowPageBlock('form_post_comment'))
    {
		$postComment->form_post_comment['action_url']=getUrl('profilecomments','?user_id='.$postComment->getFormField('user_id'), '?user_id='.$postComment->getFormField('user_id'));
		$postComment->form_post_comment['user_id']=$user_details_arr['user_id'];
		$postComment->form_post_comment['date']=date('M d, Y');
	}
if ($postComment->isValidUserId())
	$postComment->form_post_comment['MemberProfileUrl']=getMemberProfileUrl($user_details_arr['user_id'], $user_details_arr['user_name']);
if ($postComment->isShowPageBlock('form_view_comments'))
    {
		$postComment->setTableNames(array($CFG['db']['tbl']['users_profile_comments'].' AS pc LEFT JOIN '.$CFG['db']['tbl']['users'].' AS u ON (u.user_id=pc.comment_user_id)'));
		$postComment->setReturnColumns(array('user_name', 'user_id', 'icon_id', 'icon_type', 'image_ext', 'users_profile_comment_id','comment', 'comment_date', 'logged_in', 'sex'));

		$postComment->setReturnColumnsAliases(array(
					'user_name' 	=> 'u.user_name',
					'user_id'		=> 'pc.comment_user_id',
					'icon_id'		=> 'u.icon_id',
					'icon_type'		=> 'u.icon_type',
					'sex'			=> 'u.sex',
					'logged_in'	=> '(logged_in=\'1\'  AND DATE_SUB(NOW(), INTERVAL 20 SECOND) < last_active)',
					'users_profile_comment_id' => 'pc.users_profile_comment_id',
					'comment'		=> 'pc.comment',
					'comment_date'	=> 'pc.date_added'
					)
				);

		$postComment->buildSelectQuery();
		$postComment->buildConditionQuery();
		$postComment->buildSortQuery();
		$postComment->buildQuery();
		$postComment->executeQuery();

		if ($postComment->isResultsFound())
		    {
				$postComment->form_view_comments['display_comments']=$postComment->displayProfileComments();
				$paging_arr = array('user_id');
				$smartyObj->assign('smarty_paging_list', $postComment->populatePageLinksGET($postComment->getFormField('start'), $paging_arr));
		    }
		else
			{
				$userDetails = $postComment->getUserDetail('user_id', $postComment->getFormField('user_id'));
				$postComment->form_view_comments['userDetails']= $userDetails;
				$postComment->form_view_comments['currentAccount'] = $currentAccount;

				if (!$currentAccount)
				    {
					    $postComment->form_view_comments['postscrapUrl']=getUrl('profilecomments','?user_id='.$postComment->getFormField('user_id'), '?user_id='.$postComment->getFormField('user_id'));
					    $postComment->form_view_comments['viewUrl']=getMemberProfileUrl($postComment->getFormField('user_id'), $userDetails['user_name']);
				    }
			}
	}
//include the header file
$postComment->includeHeader();
//include the content of the page
if ($postComment->isValidUserId())
	{
?>
<link rel="stylesheet" id="personalStyleLink" type="text/css" href="<?php echo $CFG['site']['url'];?>profileCss.php?user_id=<?php echo $user_details_arr['user_id'];?>&amp;d=<?php echo date('dmyhis');?>" />
<?php
	}
setTemplateFolder('general/');
$smartyObj->display('profileComments.tpl');

if ($postComment->isResultsFound())
    {
?>
	    <script language="javascript" type="text/javascript">
	       var block_arr= new Array('selMsgConfirm', 'selMsgConfirmSub');
			function checkAll(chkd){
			chks = document.formProfileComment.getElementsByTagName('input');
				for(i=0; i<chks.length; i++){
						if(chks[i].type=='checkbox' && chks[i].name.indexOf('comments')==0)
						chks[i].checked = chkd;
				}
			}
			function isCheckedAll(){
			chks = document.formProfileComment.getElementsByTagName('input');
			var tInput = 0;
			var tChkd = 0;
				for(i=0; i<chks.length; i++){
						if(chks[i].type=='checkbox'  && chks[i].name.indexOf('comments')==0){
							tInput += 1;
							tChkd  += chks[i].checked?1:0
						}
					}
			document.formProfileComment.commentAll.checked = (tInput==tChkd);
			}
		</script>
<?php
    }
if ($postComment->isShowPageBlock('form_post_comment') and $CFG['feature']['jquery_validation']) {
?>
<script type="text/javascript">
	$Jq("#comment_form").validate({
		rules: {
		    comment: {
		    	required: true
		    }
		},
		messages: {
			comment: {
				required: "<?php echo $LANG['common_err_tip_required'];?>"
			}
		}
	});
</script>
<?php
}
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$postComment->includeFooter();
?>