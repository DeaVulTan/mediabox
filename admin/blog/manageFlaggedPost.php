<?php
/**
* This file is to manage the Flagged Posts
*
* Provides an interface to view the number of flags given to the
* post, and to view the flags given to the post and options to
* Flag, Unflag and to delete post.
*
*
* @category	    Rayzz Blogs
* @package		Admin
* @copyright 	Copyright (c) 2010 {@link http://www.mediabox.uz Uzdc Infoway}
* @license		http://www.mediabox.uz Uzdc Infoway Licence
**/


require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/blog/admin/manageFlaggedPost.php';
$CFG['lang']['include_files'][] = 'languages/%s/blog/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_BlogHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['site']['is_module_page'] = 'blog';
require_once($CFG['site']['project_path'] . 'common/application_top.inc.php');

class ManageFlaggedPost extends BlogHandler
{
   /**
	* ManageFlaggedPost::buildConditionQuery()
	*
	* @return void
	**/
	public function buildConditionQuery()
	{
		$this->sql_condition = 'F.status=\'Ok\' AND F.content_type=\'Blog\' AND BP.status=\'Ok\' AND BP.flagged_status<>\'Yes\' GROUP BY F.content_id ';
	}

	/**
	* ManageFlaggedPost::buildSortQuery()
	*
	* @return void
	**/
	public function buildSortQuery()
	{
		$this->sql_sort = 'total_requests DESC';
	}

   /**
	* ManageFlaggedPost::displayFlaggedList()
	*
	* @return void
	**/
	public function displayFlaggedList()
	{
		global $smartyObj;
		$displayFlaggedList_arr = array();
		$sql = 'SELECT F.flag, F.flag_comment, F.date_added, U.user_name, U.first_name, U.last_name FROM'.
				' '.$this->CFG['db']['tbl']['flagged_contents'].' AS F LEFT JOIN'.
				' '.$this->CFG['db']['tbl']['users'].' AS U ON U.user_id=F.reporter_id'.
				' WHERE F.content_id='.$this->dbObj->Param('content_id').
				' AND F.status=\'Ok\' ORDER BY F.date_added DESC';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
		if (!$rs)
		        trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$displayFlaggedList_arr['rs_PO_RecordCount'] = $rs->PO_RecordCount();
		if($rs->PO_RecordCount())
			{
				$displayFlaggedList_arr['row'] = array();
				$inc = 0;
				while($row = $rs->FetchRow())
					{
						$name = $this->CFG['format']['name'];
						$name = str_replace('$first_name', $row['first_name'],$name);
						$name = str_replace('$last_name', $row['last_name'],$name);
						$name = str_replace('$user_name', $row['user_name'],$name);

						$displayFlaggedList_arr['row'][$inc]['name'] = $name;
						$displayFlaggedList_arr['row'][$inc]['record'] = $row;
						$inc++;
					}
			}
		$smartyObj->assign('displayFlaggedList_arr', $displayFlaggedList_arr);
	}

   /**
	* ManageFlaggedPost::displayPostList()
	*
	* @return void
	**/
	public function displayPostList()
	{
		global $smartyObj;
		$displayPostList_arr = array();
		$inc = 0;
		while($row = $this->fetchResultRecord())
		{
			$displayPostList_arr[$inc]['checked'] = '';
			if((is_array($this->fields_arr['blog_post_ids'])) && (in_array($row['blog_post_id'], $this->fields_arr['blog_post_ids'])))
			$displayPostList_arr[$inc]['checked']    = "checked";
			$displayPostList_arr[$inc]['record'] 	  = $row;
			$inc++;
		}
		$smartyObj->assign('displayPostList_arr', $displayPostList_arr);
	}

   /**
	* ManageFlaggedPost::getUserName()
	*
	* @param $user_id
	* @return void
	**/
	public function getUserName($user_id)
	{
		$sql = 'SELECT user_name, first_name, last_name FROM '.$this->CFG['db']['tbl']['users'].
		' WHERE user_id='.$this->dbObj->Param('user_id').' LIMIT 0,1';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($user_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		if($row = $rs->FetchRow())
		{
			$name = $this->CFG['format']['name'];
			$name = str_replace('$first_name', $row['first_name'],$name);
			$name = str_replace('$last_name', $row['last_name'],$name);
			$name = str_replace('$user_name', $row['user_name'],$name);
			return $name;
		}
	}

	/**
	* ManageFlaggedPost::getCountOfRequests()
	*
	* @param Integer $blog_post_id
	* @return void
	*/
	public function getCountOfRequests($blog_post_id)
	{
		global $smartyObj;
		$result = '';
		$displayCountRequestList_arr = array();
		$sql = 'SELECT COUNT(1) as total_count, flag FROM '.$this->CFG['db']['tbl']['flagged_contents'].' WHERE'.
		' content_type=\'Blog\' AND content_id='.$this->dbObj->Param('blog_post_id').' AND status=\'Ok\' GROUP BY flag order by flag';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($blog_post_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		while($row = $rs->FetchRow())
		{
			$result .= $row['flag'].' : '.$row['total_count'].' ';
		}
		if(!empty($result))
			return $result;
	}

   /**
	* ManageFlaggedPost::populateThisBlogPostDetails()
	*
	* @return boolean
	**/
	public function populateThisBlogPostDetails()
	{
		$sql = 'SELECT BP.blog_post_name, U.user_name, U.email, U.user_id FROM'.
				' '.$this->CFG['db']['tbl']['blog_posts'].' as BP LEFT JOIN '.$this->CFG['db']['tbl']['users'].
				' AS U ON BP.user_id=U.user_id WHERE'.
				' blog_post_id='.$this->dbObj->Param('blog_post_id').' LIMIT 0,1';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		if($row = $rs->FetchRow())
			{
				$this->BLOG_POST_NAME 		= $row['blog_post_name'];
				$this->BLOG_USER_NAME  = $row['user_name'];
				$this->BLOG_USER_EMAIL = $row['email'];
				$this->BLOG_USER_ID    = $row['user_id'];
				return true;
			}
		return false;
	}

   /**
	* ManageFlaggedPost::activateFlaggedPost()
	* To UnFlag a Flagged post (To disaprove flags)
	*
	* @return void
	**/
	public function activateFlaggedPost()
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['flagged_contents'].' '.
		' SET status=\'Deleted\' WHERE'.
		' content_id IN('.$this->fields_arr['blog_post_ids'].') AND content_type=\'Blog\'';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
	}

   /**
	* ManageFlaggedPost::flagFlaggedPost()
	* To Flag a Flagged post (To approve flag)
	*
	* @return void
	**/
	public function flagFlaggedPost()
	{
		$this->populateThisBlogPostDetails();
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET flagged_status=\'Yes\''.
				' WHERE blog_post_id IN('.$this->fields_arr['blog_post_ids'].')';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
	        trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$sql = 'UPDATE '.$this->CFG['db']['tbl']['flagged_contents'].' '.
				' SET status=\'Deleted\' WHERE'.
				' content_id IN('.$this->fields_arr['blog_post_ids'].') AND content_type=\'Blog\'';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
	}

   /**
	* ManageFlaggedPost::deleteFlaggedPost()
	* To delete flag, other post related contents and will apply 'Delete' Status to post
	*
	*
	* @return boolean
	**/
	public function deleteFlaggedPost()
	{
		$sql = 'SELECT user_id, blog_post_id FROM '.$this->CFG['db']['tbl']['blog_posts'].' WHERE blog_post_id IN('.$this->fields_arr['blog_post_ids'].')';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		while($row = $rs->FetchRow())
		    {
			    $user_details[$row['blog_post_id']] = $row['user_id'];
		    }
		$blog_post_id = explode(',',$this->fields_arr['blog_post_ids']);
		foreach($blog_post_id as $postkey=>$postvalue)
			{
				$this->deleteBlogPosts(array($postvalue), $user_details[$postvalue]);
			}
		return true;
    }
}
//<<<<<-------------- Class obj begins ---------------//
$manageflaggedpost = new ManageFlaggedPost();
$manageflaggedpost->setMediaPath('../../');
$manageflaggedpost->setPageBlockNames(array('confirmation_block', 'list_flagged_post_form', 'flagged_details_form', 'activate_confirmation_form', 'flag_confirmation_form', 'delete_confirmation_form'));
//default form fields and values...
$action_arr = array('delete'=>$LANG['manageflagged_delete'], 'flag'=>$LANG['manageflagged_flag'], 'activate'=>$LANG['manageflagged_activate']);
$action_arr = array('delete'=>$LANG['manageflagged_delete'], 'flag'=>$LANG['manageflagged_flag'], 'activate'=>$LANG['manageflagged_activate']);
$manageflaggedpost->setFormField('blog_post_id', '');
$manageflaggedpost->setFormField('action', '');
$manageflaggedpost->setFormField('action_select', '');
$manageflaggedpost->setFormField('blog_post_ids', array());
$manageflaggedpost->setFormField('type', '');
/*********** Page Navigation Start *********/
$manageflaggedpost->setFormField('slno', '1');
$manageflaggedpost->setTableNames(array($CFG['db']['tbl']['flagged_contents'].' AS F LEFT JOIN '.$CFG['db']['tbl']['blog_posts'].' as BP ON F.content_id=BP.blog_post_id'));
$manageflaggedpost->setReturnColumns(array('BP.blog_post_id', 'BP.user_id','BP.blog_post_name', 'BP.user_id', 'COUNT(F.content_id) AS total_requests'));
/************ page Navigation stop *************/
$manageflaggedpost->setAllPageBlocksHide();
$manageflaggedpost->setPageBlockShow('list_flagged_post_form');
$manageflaggedpost->sanitizeFormInputs($_REQUEST);

if($manageflaggedpost->isFormGETed($_GET, 'action'))
{
	if($manageflaggedpost->getFormField('action')=='detail')
	{
		$manageflaggedpost->setAllPageBlocksHide();
		$manageflaggedpost->setPageBlockShow('flagged_details_form');
	}
}
if($manageflaggedpost->isFormGETed($_POST, 'back_submit'))
{
	$manageflaggedpost->setAllPageBlocksHide();
	$manageflaggedpost->setPageBlockShow('list_flagged_post_form');
}
if($manageflaggedpost->isFormGETed($_POST, 'yes'))
{
	switch($manageflaggedpost->getFormField('action'))
		{
			case 'Unflag':
				$manageflaggedpost->activateFlaggedPost();
				$manageflaggedpost->setCommonSuccessMsg($LANG['manageflagged_msg_success_acivate']);
				$manageflaggedpost->setPageBlockShow('block_msg_form_success');
				break;

			case 'Flag':
				$manageflaggedpost->flagFlaggedPost();
				$manageflaggedpost->setCommonSuccessMsg($LANG['manageflagged_msg_success_flag']);
				$manageflaggedpost->setPageBlockShow('block_msg_form_success');
				break;

			case 'Delete':
				$manageflaggedpost->deleteFlaggedPost();
				$manageflaggedpost->setCommonSuccessMsg($LANG['manageflagged_msg_success_delete']);
				$manageflaggedpost->setPageBlockShow('block_msg_form_success');
				break;
		}
}

$manageflaggedpost->hidden_arr = array('start');
if ($manageflaggedpost->isShowPageBlock('flagged_details_form'))
{
	$manageflaggedpost->displayFlaggedList();
}
if ($manageflaggedpost->isShowPageBlock('list_flagged_post_form'))
{
	/****** navigtion continue*********/
	$manageflaggedpost->buildSelectQuery();
	$manageflaggedpost->buildConditionQuery();
	$manageflaggedpost->buildSortQuery();
	$manageflaggedpost->buildQuery();
	//$manageflaggedpost->printQuery();
	if($manageflaggedpost->isGroupByQuery())
		$manageflaggedpost->homeExecuteQuery();
	else
		$manageflaggedpost->executeQuery();
	/******* Navigation End ********/
	if($manageflaggedpost->isResultsFound())
	{
		$paging_arr = array();
		$manageflaggedpost->displayPostList();
		$smartyObj->assign('smarty_paging_list', $manageflaggedpost->populatePageLinksGET($manageflaggedpost->getFormField('start'), $paging_arr));
	}
}
$manageflaggedpost->left_navigation_div = 'blogMain';
//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$manageflaggedpost->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'blog');
$smartyObj->display('manageFlaggedPost.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script language="javascript" type="text/javascript">
var block_arr= new Array('selMsgConfirm');
function popupWindow(url)
{
window.open (url, "","status=0,toolbar=0,resizable=1,scrollbars=1");
return false;
}

</script>
<?php
$manageflaggedpost->includeFooter();
?>