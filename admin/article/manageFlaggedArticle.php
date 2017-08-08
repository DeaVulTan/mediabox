<?php
/**
* This file is to manage the Flagged Article
*
* Provides an interface to view the number of flags given to the
* article, and to view the flags given to the article and options to
* Flag, Unflag and to delete article.
*
*
* @category	    Rayzz ArticleSharing
* @package		Admin
* @copyright 	Copyright (c) 2010 {@link http://www.mediabox.uz Uzdc Infoway}
* @license		http://www.mediabox.uz Uzdc Infoway Licence
**/


require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/article/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/admin/manageFlaggedArticle.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ArticleHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['site']['is_module_page'] = 'article';
require_once($CFG['site']['project_path'] . 'common/application_top.inc.php');

class ManageFlaggedArticle extends ArticleHandler
{
   /**
	* ManageFlaggedArticle::buildConditionQuery()
	*
	* @return void
	**/
	public function buildConditionQuery()
	{
		$this->sql_condition = 'F.status=\'Ok\' AND F.content_type=\'Article\' AND P.article_status=\'Ok\' AND P.flagged_status<>\'Yes\' GROUP BY F.content_id ';
	}

	/**
	* ManageFlaggedArticle::buildSortQuery()
	*
	* @return void
	**/
	public function buildSortQuery()
	{
		$this->sql_sort = 'total_requests DESC';
	}

   /**
	* ManageFlaggedArticle::displayFlaggedList()
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
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
		if (!$rs)
		        trigger_db_error($this->dbObj);

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
	* ManageFlaggedArticle::displayArticleList()
	*
	* @return void
	**/
	public function displayArticleList()
	{
		global $smartyObj;
		$displayArticleList_arr = array();
		$article_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['articles']['folder'].'/';
		$inc = 0;
		while($row = $this->fetchResultRecord())
		{
			$displayArticleList_arr[$inc]['checked'] = '';
			if((is_array($this->fields_arr['article_ids'])) && (in_array($row['article_id'], $this->fields_arr['article_ids'])))
			$displayArticleList_arr[$inc]['checked']    = "checked";
			$displayArticleList_arr[$inc]['record'] 	  = $row;
			$displayArticleList_arr[$inc]['view_article_link'] = getUrl('viewarticle', '?article_id='.$row['article_id'].'&amp;title='.$this->changeTitle($row['article_title']), $row['article_id'].'/'.$this->changeTitle($row['article_title']).'/', 'members', 'article');
			$inc++;
		}
		$smartyObj->assign('displayArticleList_arr', $displayArticleList_arr);
	}

   /**
	* ManageFlaggedArticle::getUserName()
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
			trigger_db_error($this->dbObj);
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
	* ManageFlaggedArticle::getCountOfRequests()
	*
	* @param Integer $article_id
	* @return void
	*/
	public function getCountOfRequests($article_id)
	{
		global $smartyObj;
		$result = '';
		$displayCountRequestList_arr = array();
		$sql = 'SELECT COUNT(1) as total_count, flag FROM '.$this->CFG['db']['tbl']['flagged_contents'].' WHERE'.
		' content_type=\'Article\' AND content_id='.$this->dbObj->Param('article_id').' AND status=\'Ok\' GROUP BY flag order by flag';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($article_id));
		if (!$rs)
			trigger_db_error($this->dbObj);
		while($row = $rs->FetchRow())
		{
			$result .= $row['flag'].' : '.$row['total_count'].' ';
		}
		if(!empty($result))
			return $result;
	}

   /**
	* ManageFlaggedArticle::populateArticleDetail()
	*
	* @return boolean
	**/
	public function populateArticleDetail()
	{
		$sql = 'SELECT P.article_title, U.user_name, U.email, U.user_id FROM'.
				' '.$this->CFG['db']['tbl']['article'].' as P LEFT JOIN '.$this->CFG['db']['tbl']['users'].
				' AS U ON P.user_id=U.user_id WHERE'.
				' article_id='.$this->dbObj->Param('article_id').' LIMIT 0,1';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
		if (!$rs)
			trigger_db_error($this->dbObj);
		if($row = $rs->FetchRow())
			{
				$this->ARTICLE_TITLE 		= $row['article_title'];
				$this->ARTICLE_USER_NAME  = $row['user_name'];
				$this->ARTICLE_USER_EMAIL = $row['email'];
				$this->ARTICLE_USER_ID    = $row['user_id'];
				return true;
			}
		return false;
	}

   /**
	* ManageFlaggedArticle::activateFlaggedArticle()
	* To UnFlag a Flagged article (To disaprove flags)
	*
	* @return void
	**/
	public function activateFlaggedArticle()
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['flagged_contents'].' '.
		' SET status=\'Deleted\' WHERE'.
		' content_id IN('.$this->fields_arr['article_ids'].') AND content_type=\'Article\'';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_db_error($this->dbObj);
	}

   /**
	* ManageFlaggedArticle::flagFlaggedArticle()
	* To Flag a Flagged article (To approve flag)
	*
	* @return void
	**/
	public function flagFlaggedArticle()
	{
		$this->populateArticleDetail();
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].' SET flagged_status=\'Yes\''.
				' WHERE article_id IN('.$this->fields_arr['article_ids'].')';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
	        trigger_db_error($this->dbObj);

		$sql = 'UPDATE '.$this->CFG['db']['tbl']['flagged_contents'].' '.
				' SET status=\'Deleted\' WHERE'.
				' content_id IN('.$this->fields_arr['article_ids'].') AND content_type=\'Article\'';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
		    trigger_db_error($this->dbObj);
	}

   /**
	* ManageFlaggedArticle::deleteFlaggedArticle()
	* To delete flag, other article related contents and will apply 'Delete' Status to article
	*
	*
	* @return boolean
	**/
	public function deleteFlaggedArticle()
	{
		$sql = 'SELECT user_id, article_id FROM '.$this->CFG['db']['tbl']['article'].' WHERE article_id IN('.$this->fields_arr['article_ids'].')';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		while($row = $rs->FetchRow())
		    {
			    $user_details[$row['article_id']] = $row['user_id'];
		    }
		$article_id = explode(',',$this->fields_arr['article_ids']);
		foreach($article_id as $articlekey=>$articlevalue)
			{
				$this->deleteArticles(array($articlevalue), $user_details[$articlevalue]);
			}
		return true;
    }
}
//<<<<<-------------- Class obj begins ---------------//
$manageflaggedarticle = new ManageFlaggedArticle();
$manageflaggedarticle->setMediaPath('../../');
$manageflaggedarticle->setPageBlockNames(array('confirmation_block', 'list_flagged_article_form', 'flagged_details_form', 'activate_confirmation_form', 'flag_confirmation_form', 'delete_confirmation_form'));
//default form fields and values...
$action_arr = array('delete'=>$LANG['manageflagged_delete'], 'flag'=>$LANG['manageflagged_flag'], 'activate'=>$LANG['manageflagged_activate']);
$action_arr = array('delete'=>$LANG['manageflagged_delete'], 'flag'=>$LANG['manageflagged_flag'], 'activate'=>$LANG['manageflagged_activate']);
$manageflaggedarticle->setFormField('article_id', '');
$manageflaggedarticle->setFormField('action', '');
$manageflaggedarticle->setFormField('action_select', '');
$manageflaggedarticle->setFormField('article_ids', array());
$manageflaggedarticle->setFormField('type', '');
/*********** Page Navigation Start *********/
$manageflaggedarticle->setFormField('slno', '1');
$manageflaggedarticle->setTableNames(array($CFG['db']['tbl']['flagged_contents'].' AS F LEFT JOIN '.$CFG['db']['tbl']['article'].' as P ON F.content_id=P.article_id'));
$manageflaggedarticle->setReturnColumns(array('P.article_id', 'P.article_server_url', 'P.user_id','P.article_title', 'P.user_id', 'COUNT(F.content_id) AS total_requests'));
/************ page Navigation stop *************/
$manageflaggedarticle->setAllPageBlocksHide();
$manageflaggedarticle->setPageBlockShow('list_flagged_article_form');
$manageflaggedarticle->sanitizeFormInputs($_REQUEST);

if($manageflaggedarticle->isFormGETed($_GET, 'action'))
{
	if($manageflaggedarticle->getFormField('action')=='detail')
	{
		$manageflaggedarticle->setAllPageBlocksHide();
		$manageflaggedarticle->setPageBlockShow('flagged_details_form');
	}
}
if($manageflaggedarticle->isFormGETed($_POST, 'article_submit'))
{
	$manageflaggedarticle->chkIsNotEmpty('article_ids', $LANG['err_tip_compulsory']);
	if($manageflaggedarticle->isValidFormInputs())
		{
			$article_ids = $manageflaggedarticle->getFormField('article_ids');
			$article_id = '';
			foreach($article_ids as $value)
				$article_id .= $value.',';
			$article_id = substr($article_id, 0, strrpos($article_id, ','));

			$manageflaggedarticle->setFormField('article_id', $article_id);
			$value = $manageflaggedarticle->getFormField('action_select').'_confirmation';
			$LANG['confirmation'] = $LANG[$value];
			$manageflaggedarticle->setPageBlockShow('confirmation_block');
		}
	else
		{
			$manageflaggedarticle->setCommonErrorMsg($LANG['err_tip_select_category']);
			$manageflaggedarticle->setPageBlockShow('block_msg_form_error');
		}
}
if($manageflaggedarticle->isFormGETed($_POST, 'back_submit'))
{
	$manageflaggedarticle->setAllPageBlocksHide();
	$manageflaggedarticle->setPageBlockShow('list_flagged_article_form');
}
if($manageflaggedarticle->isFormGETed($_POST, 'yes'))
{
	switch($manageflaggedarticle->getFormField('action'))
		{
			case 'Unflag':
				$manageflaggedarticle->activateFlaggedArticle();
				$manageflaggedarticle->setCommonSuccessMsg($LANG['msg_success_acivate']);
				$manageflaggedarticle->setPageBlockShow('block_msg_form_success');
				break;

			case 'Flag':
				$manageflaggedarticle->flagFlaggedArticle();
				$manageflaggedarticle->setCommonSuccessMsg($LANG['msg_success_flag']);
				$manageflaggedarticle->setPageBlockShow('block_msg_form_success');
				break;

			case 'Delete':
				$manageflaggedarticle->deleteFlaggedArticle();
				$manageflaggedarticle->setCommonSuccessMsg($LANG['msg_success_delete']);
				$manageflaggedarticle->setPageBlockShow('block_msg_form_success');
				break;
		}
}

$manageflaggedarticle->hidden_arr = array('start');
if ($manageflaggedarticle->isShowPageBlock('flagged_details_form'))
{
	$manageflaggedarticle->displayFlaggedList();
}
if ($manageflaggedarticle->isShowPageBlock('list_flagged_article_form'))
{
	/****** navigtion continue*********/
	$manageflaggedarticle->buildSelectQuery();
	$manageflaggedarticle->buildConditionQuery();
	$manageflaggedarticle->buildSortQuery();
	$manageflaggedarticle->buildQuery();
	//$manageflaggedarticle->printQuery();
	if($manageflaggedarticle->isGroupByQuery())
		$manageflaggedarticle->homeExecuteQuery();
	else
		$manageflaggedarticle->executeQuery();
	/******* Navigation End ********/
	if($manageflaggedarticle->isResultsFound())
	{
		$paging_arr = array();
		$manageflaggedarticle->displayArticleList();
		$smartyObj->assign('smarty_paging_list', $manageflaggedarticle->populatePageLinksGET($manageflaggedarticle->getFormField('start'), $paging_arr));
	}
}
$manageflaggedarticle->left_navigation_div = 'articleMain';
//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$manageflaggedarticle->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'article');
$smartyObj->display('manageFlaggedArticle.tpl');
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
$manageflaggedarticle->includeFooter();
?>