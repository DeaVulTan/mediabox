<?php
/**
 * * This file is to manage admin comments about article
 *
 * PHP version 5.0
 *
 * @category	Rayzz
 * @package		Admin
 **/
/**
 * configurations
*/
require_once('../../common/configs/config.inc.php');
$CFG['site']['is_module_page'] = 'article';
$CFG['lang']['include_files'][] = 'languages/%s/article/common.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/admin/articleAdminComment.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ArticleHandler.lib.php';
$CFG['html']['header'] = 'admin/html_header_popup.php';
$CFG['html']['footer'] = 'admin/html_footer_popup.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');

//--------------class Comments--------------->>>//
/**
 * @category	Rayzz
 * @package		Comments
 **/
class AdminComments extends ArticleHandler
	{

		/**
		 * AdminComments::chkIsValidArticleId()
		 *
		 * @return boolean
		 **/
		public function chkIsValidArticleId()
			{
				$sql ='SELECT COUNT(DISTINCT p.article_id) AS article_id FROM'.
						' '.$this->CFG['db']['tbl']['article'].' as p'.
						' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' as u'.
						' ON p.user_id=u.user_id'.
						' WHERE p.article_id='.$this->dbObj->Param('article_id').' LIMIT 0,1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				$row = $rs->FetchRow();
				if($row['article_id'])
					{
						return true;
					}
				return false;
			}

		/**
		 * AdminComments::populateArticleDetail()
		 *
		 * @return boolean
		 **/
		public function populateArticleDetail()
			{
				global $smartyObj;
				$populateArticle_arr = array();
				$fields_list = array('user_name', 'first_name', 'last_name', 'icon_id', 'icon_type','image_ext', 'sex');
				$this->UserDetails = array();

				$sql = 'SELECT p.rating_total, p.rating_count, p.user_id, p.article_title,'.
						' p.article_caption, article_admin_comments, DATE_FORMAT(date_added,\''.$this->CFG['format']['date'].'\') as date_added,'.
						' u.user_name, u.first_name, u.last_name, article_server_url'.
						' FROM '.$this->CFG['db']['tbl']['article'].' as p'.
						' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' as u ON p.user_id=u.user_id'.
						' WHERE article_id='.$this->dbObj->Param('article_id').' LIMIT 0,1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if($row = $rs->FetchRow())
					{
						if(!isset($this->UserDetails[$row['user_id']]))
							$this->UserDetails = getUserDetail('user_id', $row['user_id'], 'user_name');

						$profileIcon = getMemberAvatarDetails($row['user_id']);
						$populateArticle_arr['user_id'] = $this->fields_arr['user_id'] = $row['user_id'];
						$populateArticle_arr['article_title'] = $this->fields_arr['article_title'] = $row['article_title'];
						$populateArticle_arr['article_admin_comments'] = $this->fields_arr['article_admin_comments'] = $row['article_admin_comments'];
						$populateArticle_arr['date_added'] = $this->fields_arr['date_added'] = ($row['date_added'] != '') ? getTimeDiffernceFormat($row['date_added']) : '';
						$populateArticle_arr['UserDetails'] = $this->UserDetails;
						$populateArticle_arr['profileIcon'] = $profileIcon;
						$populateArticle_arr['articleOwnerProfileUrl'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
						$smartyObj->assign('populateArticle_arr', $populateArticle_arr);
						return true;
					}
				$smartyObj->assign('populateArticle_arr', $populateArticle_arr);
				return false;
			}

		/**
		 * AdminComments::updateArticleComments()
		 *
		 * @return boolean
		 **/
		public function updateArticleComments()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].
						' SET article_admin_comments='.$this->dbObj->Param('article_admin_comment').' WHERE'.
						' article_id='.$this->dbObj->Param('article_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_admin_comments'], $this->fields_arr['article_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				return true;
			}
	}
//<<<<<<<--------------class Comments---------------//

//--------------------Code begins-------------->>>>>//
$admincomments = new AdminComments();
$admincomments->setPageBlockNames(array('form_confirm', 'show_admin_comment'));

$admincomments->setAllPageBlocksHide();
$admincomments->setFormField('article_id', '');
$admincomments->setFormField('article_admin_comments', '');

$admincomments->setPageBlockShow('show_admin_comment');
$admincomments->sanitizeFormInputs($_REQUEST);

if($admincomments->isFormPOSTed($_POST, 'updateSubmit'))
	{
		$admincomments->chkIsNotEmpty('article_admin_comments', $admincomments->LANG['common_err_tip_required']);
		if($admincomments->isValidFormInputs())
			{
				$admincomments->updateArticleComments();
				$admincomments->setPageBlockShow('block_msg_form_success');
				$admincomments->setCommonSuccessMsg($LANG['msg_success_submit']);
			}
		else
			{
				$admincomments->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$admincomments->setPageBlockShow('block_msg_form_error');
			}
	}
else if($admincomments->isFormPOSTed($_POST, 'delete_add'))
	{
		if($admincomments->deleteSelectedComments())
			{
				$admincomments->setPageBlockShow('block_msg_form_success');
				$admincomments->setCommonSuccessMsg($LANG['msg_success_deleted']);
			}
	}

//<<<<--------------------Code Ends----------------------//

if ($admincomments->isShowPageBlock('show_admin_comment'))
	{

		if(!$admincomments->chkIsValidArticleId())
			{
				$admincomments->setAllPageBlocksHide();
				$admincomments->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$admincomments->setPageBlockShow('block_msg_form_error');
			}
		else
			{
				$admincomments->populateArticleDetail();

			}
	}

//include the header file
$admincomments->includeHeader();
//--------------------Page block templates begins-------------------->>>>>//
//include the content of the page
setTemplateFolder('admin/', 'article');
$smartyObj->display('articleAdminComment.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
$admincomments->includeFooter();
?>