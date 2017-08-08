<?php
/**
 * This file is to display the article
 *
 * Provides an interface to view articles .
 *
 *
 * @category	rayzz
 * @package		Admin
 *
 **/

require_once('../../common/configs/config.inc.php');
$CFG['site']['is_module_page'] = 'article';
$CFG['lang']['include_files'][] = 'languages/%s/article/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/admin/articlePreview.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ArticleHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
//$CFG['html']['header'] = 'admin/html_header_popup.php';
//$CFG['html']['footer'] = 'admin/html_footer_popup.php';
$CFG['html']['header'] = 'admin/html_header_no_header.php';
$CFG['html']['footer'] = 'admin/html_footer_no_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
/**
 * ViewArticle
 *
 * @category	rayzz
 * @package		Admin
 **/
class ArticlePreview extends ArticleHandler
	{
		/**
		 * ArticlePreview::chkIsValidArticleId()
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
		 * ArticlePreview::populateArticleDetail()
		 *
		 * @return boolean
		 **/
		public function populateArticleDetail()
			{
				$sql = 'SELECT p.rating_total, p.rating_count, p.user_id,'.
						' p.article_title, p.article_caption, DATE_FORMAT(date_added,\''.$this->CFG['format']['date'].'\') as date_added,'.
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
						$name = $this->CFG['format']['name'];
						$name = str_replace('$first_name', $row['first_name'],$name);
						$name = str_replace('$last_name', $row['last_name'],$name);
						$name = str_replace('$user_name', $row['user_name'],$name);

						$this->fields_arr['user_id'] = $row['user_id'];
						$this->fields_arr['article_server_url'] = $row['article_server_url'];
						$this->fields_arr['article_title'] = $row['article_title'];
						$this->fields_arr['article_caption'] = $row['article_caption'];
						$this->fields_arr['date_added'] = $row['date_added'];
						$this->fields_arr['user_name'] = $name;
						$this->fields_arr['rating_total'] = $row['rating_total'];
						$this->fields_arr['rating_count'] = $row['rating_count'];
						return true;
					}
				return false;
			}
	}
//<<<<<-------------- Class ArticlePreview begins ---------------//
//-------------------- Code begins -------------->>>>>//
$ArticlePreview = new ArticlePreview();

$ArticlePreview->setPageBlockNames(array('view_article_form'));

//default form fields and values...
$ArticlePreview->setFormField('article_id', '');
$ArticlePreview->setFormField('user_id', '');
$ArticlePreview->setFormField('user_name', '');
$ArticlePreview->IS_USE_AJAX = true;

if($ArticlePreview->isFormPOSTed($_REQUEST, 'article_id'))
	{
		$ArticlePreview->sanitizeFormInputs($_REQUEST);
		if(!$ArticlePreview->chkIsValidArticleId())
			{
				$ArticlePreview->setAllPageBlocksHide();
				$ArticlePreview->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$ArticlePreview->setPageBlockShow('block_msg_form_error');
			}
		else
			{
				if($ArticlePreview->populateArticleDetail())
					{
						$ArticlePreview->setPageBlockShow('view_article_form');
					}
				else
					{
						$ArticlePreview->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$ArticlePreview->setPageBlockShow('block_msg_form_error');
					}
			}
	}
else
	{
		$ArticlePreview->setAllPageBlocksHide();
		$ArticlePreview->setCommonErrorMsg($LANG['common_msg_error_sorry']);
		$ArticlePreview->setPageBlockShow('block_msg_form_error');
	}

//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$ArticlePreview->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'article');
$smartyObj->display('articlePreview.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script language="javascript" type="text/javascript">
	//setFullScreenBrowser();
</script>
<?php
$ArticlePreview->includeFooter();
?>