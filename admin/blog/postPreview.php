<?php
/**
 * This file is to display the posts
 *
 * Provides an interface to view post .
 *
 *
 * @category	rayzz
 * @package		Admin
 *
 **/

require_once('../../common/configs/config.inc.php');
$CFG['site']['is_module_page'] = 'blog';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_BlogHandler.lib.php';
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
class postPreview extends BlogHandler
	{
		/**
		 * postPreview::chkIsValidPostId()
		 *
		 * @return boolean
		 **/
		public function chkIsValidPostId()
			{
				$sql ='SELECT COUNT(DISTINCT bp.blog_post_id) AS blog_post_id FROM'.
						' '.$this->CFG['db']['tbl']['blog_posts'].' as bp'.
						' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' as u'.
						' ON bp.user_id=u.user_id'.
						' WHERE bp.blog_post_id='.$this->dbObj->Param('blog_post_id').' LIMIT 0,1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				$row = $rs->FetchRow();
				if($row['blog_post_id'])
					{
						return true;
					}
				return false;
			}

		/**
		 * postPreview::populatePostDetail()
		 *
		 * @return boolean
		 **/
		public function populatePostDetail()
			{
				$sql = 'SELECT bp.rating_total, bp.rating_count, bp.user_id,'.
						' bp.blog_post_name, bp.message, DATE_FORMAT(date_added,\''.$this->CFG['format']['date'].'\') as date_added,'.
						' u.user_name, u.first_name, u.last_name'.
						' FROM '.$this->CFG['db']['tbl']['blog_posts'].' as bp'.
						' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' as u ON bp.user_id=u.user_id'.
						' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id').' LIMIT 0,1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
				if (!$rs)
				        trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if($row = $rs->FetchRow())
					{
						$name = $this->CFG['format']['name'];
						$name = str_replace('$first_name', $row['first_name'],$name);
						$name = str_replace('$last_name', $row['last_name'],$name);
						$name = str_replace('$user_name', $row['user_name'],$name);

						$this->fields_arr['user_id'] = $row['user_id'];
						$this->fields_arr['blog_post_name'] = $row['blog_post_name'];
						$this->fields_arr['message'] = $row['message'];
						$this->fields_arr['date_added'] = $row['date_added'];
						$this->fields_arr['user_name'] = $name;
						$this->fields_arr['rating_total'] = $row['rating_total'];
						$this->fields_arr['rating_count'] = $row['rating_count'];
						return true;
					}
				return false;
			}
	}
//<<<<<-------------- Class postPreview begins ---------------//
//-------------------- Code begins -------------->>>>>//
$postPreview = new postPreview();

$postPreview->setPageBlockNames(array('view_post_form'));

//default form fields and values...
$postPreview->setFormField('blog_post_id', '');
$postPreview->setFormField('user_id', '');
$postPreview->setFormField('user_name', '');
$postPreview->IS_USE_AJAX = true;

if($postPreview->isFormPOSTed($_REQUEST, 'blog_post_id'))
	{
		$postPreview->sanitizeFormInputs($_REQUEST);
		if(!$postPreview->chkIsValidPostId())
			{
				$postPreview->setAllPageBlocksHide();
				$postPreview->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$postPreview->setPageBlockShow('block_msg_form_error');
			}
		else
			{
				if($postPreview->populatePostDetail())
					{
						$postPreview->setPageBlockShow('view_post_form');
					}
				else
					{
						$postPreview->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$postPreview->setPageBlockShow('block_msg_form_error');
					}
			}
	}
else
	{
		$postPreview->setAllPageBlocksHide();
		$postPreview->setCommonErrorMsg($LANG['common_msg_error_sorry']);
		$postPreview->setPageBlockShow('block_msg_form_error');
	}

//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$postPreview->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'blog');
$smartyObj->display('postPreview.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script language="javascript" type="text/javascript">
	//setFullScreenBrowser();
</script>
<?php
$postPreview->includeFooter();
?>