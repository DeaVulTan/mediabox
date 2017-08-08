<?php
/**
 * This file is to view article comment details based on article id
 *
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 **/
require_once('../common/configs/config.inc.php');$CFG['site']['is_module_page']='article';
require_once('../common/configs/config_article.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/article/common.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ArticleHandler.lib.php';
$CFG['html']['header'] = 'general/html_header_no_header.php';
$CFG['html']['footer'] = 'general/html_footer_no_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
require($CFG['site']['project_path'].'common/application_top.inc.php');
class viewComment extends ArticleHandler
	{
		public function showComments()
			{
				$showComments_arr = array();
				$sql = 'SELECT ac.article_comment_id, ac.comment, u.user_name,a.article_title, a.article_server_url, '.
						'DATE_FORMAT(ac.date_added,\''.$this->CFG['format']['date'].'\') as date_added, '.
						'ac.article_id FROM '.$this->CFG['db']['tbl']['article_comments']. ' as ac JOIN '.
						$this->CFG['db']['tbl']['users']. ' as u ON u.user_id = ac.comment_user_id JOIN '.
						$this->CFG['db']['tbl']['article'].' as a ON a.article_id = ac.article_id '.
						'WHERE article_comment_id = '.$this->dbObj->Param('comment_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$showComments_arr['article_title'] = $row['article_title'];
				$showComments_arr['comments_by'] = $row['user_name'];
				$showComments_arr['comment_date'] = $row['date_added'];
				$showComments_arr['comments'] = $row['comment'];
				return $showComments_arr;
			}
	}
$viewComment = new viewComment();
$viewComment->setPageBlockNames(array('block_view_commets'));
$viewComment->setFormField('comment_id', '');
$viewComment->sanitizeFormInputs($_REQUEST);
$viewComment->setPageBlockShow('block_view_commets');
if ($viewComment->isShowPageBlock('block_view_commets'))
	{
		$viewComment->block_view_commets['showComments'] = $viewComment->showComments();
	}
$viewComment->includeHeader();
setTemplateFolder('members/','article');
$smartyObj->display('viewArticleComments.tpl');
$viewComment->includeFooter();
?>