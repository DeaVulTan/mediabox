<?php
/**
 * This file is to manage the comment of blog
 *
 * This file is having ManageComments class to manage the comment of blog
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 **/
require_once('../common/configs/config.inc.php');
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_BlogHandler.lib.php';
$CFG['html']['header'] = 'general/html_header_popup.php';
$CFG['html']['footer'] = 'general/html_footer_popup.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['site']['is_module_page']='blog';
require($CFG['site']['project_path'].'common/application_top.inc.php');
class viewComment extends BlogHandler
	{
		public function showComments()
			{
				$showComments_arr = array();
				$sql = 'SELECT bc.blog_comment_id, bc.comment, u.user_name, bp.blog_post_name, '.
						'DATE_FORMAT(bc.date_added,\''.$this->CFG['format']['date'].'\') as date_added, '.
						'bc.blog_post_id FROM '.$this->CFG['db']['tbl']['blog_comments']. ' as bc JOIN '.
						$this->CFG['db']['tbl']['users']. ' as u ON u.user_id = bc.comment_user_id JOIN '.
						$this->CFG['db']['tbl']['blog_posts'].' as bp ON bp.blog_post_id = bc.blog_post_id '.
						'WHERE blog_comment_id = '.$this->dbObj->Param('blog_comment_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$showComments_arr['blog_post_name'] = $row['blog_post_name'];
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
setTemplateFolder('members/','blog');
$smartyObj->display('viewPostComments.tpl');
$viewComment->includeFooter();
?>