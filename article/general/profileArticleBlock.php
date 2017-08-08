<?php
/**
* profilePageArticleHandler
*
* @package
* @author
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
* @persion $Id$
* @access public
*/
global $CFG;
require_once($CFG['site']['project_path'].'common/classes/class_FormHandler.lib.php');
require_once($CFG['site']['project_path'].'common/classes/class_MediaHandler.lib.php');
require_once($CFG['site']['project_path'].'common/classes/class_ArticleHandler.lib.php');
require_once($CFG['site']['project_path'].'common/configs/config_article.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/article/profileArticleBlock.php';
class profilePageArticleHandler extends ArticleHandler
{
	public $isCurrentUser = false;
	public $showEditableLink = false;
	/**
	* profilePageArticleHandler::getMyArticleBlock()
	*
	* @param integer $start
	* @param integer $articleLimit
	* @return void
	*/
	public function getMyArticleBlock($start=0, $articleLimit=4)
	{
		global $smartyObj;
		$condition = 'a.article_status=\'Ok\''.$this->getAdultQuery('a.', 'article').' AND a.user_id=\''.$this->fields_arr['user_id'].'\''.
					 ' AND (a.user_id = '.$this->CFG['user']['user_id'].' OR a.article_access_type = \'Public\''.$this->getAdditionalQuery('a.').')';
		$sql = 'SELECT a.article_id, a.article_title, a.article_summary, a.article_server_url, (a.rating_total/a.rating_count) as rating, article_attachment, total_comments, total_views, total_favorites, total_downloads, TIMEDIFF(NOW(), a.date_added) as date_added, DATE_FORMAT(a.date_of_publish, "%d %b %Y") as published_date, a.total_views '.
				' FROM '.$this->CFG['db']['tbl']['article'].' AS a WHERE '.$condition.' ORDER BY'.
				' a.article_id DESC LIMIT '.$start.','.$articleLimit;
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_db_error($this->dbObj);
		$this->articleDisplayed = false;
		$article_list_arr = array();
		$inc = 0;
		if ($rs->PO_RecordCount())
		{
			$this->articleDisplayed = true;
			while($row = $rs->FetchRow())
			{
				$row['date_added'] = getTimeDiffernceFormat($row['date_added']);
				$article_list_arr[$inc]['articleUrl']=getUrl('viewarticle','?article_id='.$row['article_id'].'&title='.$this->changeTitle($row['article_title']), $row['article_id'].'/'.$this->changeTitle($row['article_title']).'/','','article');
				$article_list_arr[$inc]['date_added']=$row['date_added'];
				$article_list_arr[$inc]['total_views']=$row['total_views'];
				$article_list_arr[$inc]['wrap_article_title']= $row['article_title'];
				$article_list_arr[$inc]['wrap_article_summary']= $row['article_summary'];
				$article_list_arr[$inc]['total_comments'] = $row['total_comments'];
				$article_list_arr[$inc]['total_views'] = $row['total_views'];
				$article_list_arr[$inc]['total_favorites'] = $row['total_favorites'];
				$article_list_arr[$inc]['article_attachment'] = $row['article_attachment'];
				$article_list_arr[$inc]['total_downloads'] = $row['total_downloads'];
				$article_list_arr[$inc]['published_date'] = $row['published_date'];
				$inc++;
			} // while
		}
		else
		{
			$aritcle_list_arr=0;
		}
		$smartyObj->assign('articleDisplayed', $this->articleDisplayed);
		$smartyObj->assign('article_list_arr', $article_list_arr);
		$userarticlelistURL=getUrl('articlelist','?pg=userarticlelist&user_id='.$this->fields_arr['user_id'], 'userarticlelist/?user_id='.$this->fields_arr['user_id'],'','article');
		$smartyObj->assign('userarticlelistURL', $userarticlelistURL);
		$smartyObj->assign('myobj', $this);
	}

	/**
	* profilePageArticleHandler::setUserId()
	*
	* @return void
	*/
	public function setUserId()
	{
		$userName = $this->fields_arr['user'];
		$sql = 'SELECT user_id FROM '.$this->CFG['db']['tbl']['users'].' WHERE user_name='.$this->dbObj->Param($userName).' AND usr_status=\'Ok\' LIMIT 1';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($userName));
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

	public function checkUserId()
	{
		$user_id = $this->fields_arr['user_id'];
		$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['users'].' WHERE user_id='.$this->dbObj->Param($user_id);
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($user_id));
		if (!$rs)
			trigger_db_error($this->dbObj);
		$row = array();
		$this->isValidUser = ($rs->PO_RecordCount() > 0);
		$this->isCurrentUser = (strcmp($this->CFG['user']['user_id'], $user_id)==0);
		$edit = $this->fields_arr['edit'];
		$edit = (strcmp($edit, '1')==0);
		$this->showEditableLink = ($this->isCurrentUser and $edit);
	}
}
$articleBlock = new profilePageArticleHandler();
global $CFG, $smartyObj, $myobj;

$articleBlock->setFormField('user_id', 0);
$articleBlock->setFormField('user', 0);
$articleBlock->setFormField('edit', 0);
if ($articleBlock->isPageGETed($_GET, 'user_id'))
	{
		$articleBlock->sanitizeFormInputs($_GET);
		$articleBlock->checkUserId();
	}
if ($articleBlock->isPageGETed($_GET, 'user'))
	{
		$articleBlock->sanitizeFormInputs($_GET);
		$articleBlock->setUserId();
	}
if (isset($__myProfile)) //its declared in members/myProfile.php
	{
		$articleBlock->setIndirectFormField('user_id', $CFG['user']['user_id']);
		$articleBlock->setIndirectFormField('edit', '1');
		$articleBlock->checkUserId();
	}
$userId = $articleBlock->getFormField('user_id');
if (!is_numeric($userId))
	{
		$articleBlock->setIndirectFormField('user_id', intval($userId));
	}
$articleBlock->getMyArticleBlock(0,$CFG['admin']['articles']['profile_page_total_article']);
?>