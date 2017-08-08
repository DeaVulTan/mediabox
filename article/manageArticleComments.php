<?php
/**
 * This file is to manage the article comments
 *
 * This file is having ManageArticleComments class to manage the comment of article
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 **/
require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_article.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/article/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/manageArticleComments.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ArticleHandler.lib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['site']['is_module_page']='article';
$CFG['auth']['is_authenticate'] = 'members';
$CFG['admin']['light_window_page'] = true;
require($CFG['site']['project_path'].'common/application_top.inc.php');

/**
 * ManageArticleComments for article. User can change the status and the delete the unwanted comments.
 *
 * @category	rayzz
 * @package		Members
 **/
class ManageArticleComments extends ArticleHandler
	{

		/**
		 * ManageArticleComments::DefaultComments()
		 * Define the sql fields and their table names
		 *
		 * @access public
		 * @return void
		 */
		public function DefaultComments()
			{
				$this->MODULE_TABLE               = 'article';
				$this->COMMENT_MODULE_TABLE       = 'article_comments';
				$this->MODULE_TABLE_ALIAS         = 'a';
				$this->COMMENT_MODULE_TABLE_ALIAS = 'ac';
				$this->COMMENT_TABLE_WHERE_CLAUSE = 'article_comment_id';
				$this->MODULE_TABLE_WHERE_CLAUSE  = 'article_id';
				$this->MODULE_RETURN_FIELD_TITLE  = 'article_title';
				$this->MODULE_RETURN_FIELD_COMMENT_STATUS  = 'comment_status';
			}

		/**
		 * ManageArticleComments::InitializeManageArticleComments()
		 * initialize the variable names depending on the module name
		 *
		 * @param string $MODULE_TABLE
		 * @param string $COMMENT_MODULE_TABLE
		 * @param string $MODULE_TABLE_ALIAS
		 * @param string $COMMENT_MODULE_TABLE_ALIAS
		 * @param string $COMMENT_TABLE_WHERE_CLAUSE
		 * @param string $MODULE_TABLE_WHERE_CLAUSE
		 * @param string $MODULE_RETURN_FIELD_TITLE
		 * @return void
		 * @access public
		 */
		public function InitializeManageArticleComments($MODULE_TABLE='article',	$COMMENT_MODULE_TABLE='article_comments', $MODULE_TABLE_ALIAS='a',$COMMENT_MODULE_TABLE_ALIAS='ac', $COMMENT_TABLE_WHERE_CLAUSE='article_comment_id', $MODULE_TABLE_WHERE_CLAUSE='article_id', $MODULE_RETURN_FIELD_TITLE='article_title')
			{
				$this->MODULE_TABLE               = $MODULE_TABLE;
				$this->COMMENT_MODULE_TABLE       = $COMMENT_MODULE_TABLE;
				$this->MODULE_TABLE_ALIAS         = $MODULE_TABLE_ALIAS;
				$this->COMMENT_MODULE_TABLE_ALIAS = $COMMENT_MODULE_TABLE_ALIAS;
				$this->COMMENT_TABLE_WHERE_CLAUSE = $COMMENT_TABLE_WHERE_CLAUSE;
				$this->MODULE_TABLE_WHERE_CLAUSE  = $MODULE_TABLE_WHERE_CLAUSE;
				$this->MODULE_RETURN_FIELD_TITLE  = $MODULE_RETURN_FIELD_TITLE;
			}

		/**
		 * ManageArticleComments::buildConditionQuery()
		 * Build the sql condition for query.
		 *
		 * @param string $connebtStatus
		 * @return string
		 * @access public
		 **/
		public function buildConditionQuery($commentStatus = '')
			{
				if(!empty($commentStatus))
					$this->sql_condition = $this->MODULE_TABLE_ALIAS.'.user_id='.$this->CFG['user']['user_id'].' AND '.$this->COMMENT_MODULE_TABLE_ALIAS.'.comment_status="'.$commentStatus.'"'.' AND u.user_id = '.$this->COMMENT_MODULE_TABLE_ALIAS.'.comment_user_id AND u.usr_status=\'Ok\' ';
				else
					$this->sql_condition = $this->MODULE_TABLE_ALIAS.'.user_id='.$this->CFG['user']['user_id'].' AND u.user_id = '.$this->COMMENT_MODULE_TABLE_ALIAS.'.comment_user_id AND u.usr_status=\'Ok\' ';
			}

		/**
		 * ManageArticleComments::buildSortQuery()
		 * Set the sort by field
		 *
		 * @return string
		 * @access public
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = $this->COMMENT_MODULE_TABLE_ALIAS.'.date_added DESC';
			}

		/**
		 * ManageArticleComments::displayCommentList()
		 * To dispaly the comments
		 *
		 * @return array
		 * @access public
		 */
		public function displayCommentList()
			{

				$fields_list = array('user_name', 'sex', 'icon_id', 'icon_type');
				$comment_list_arr = array();
				$inc = 0;
				$this->article_comment_ids=array();
				while($row = $this->fetchResultRecord())
				    {
						if(!isset($this->UserDetails[$row['comment_user_id']]))
							$this->UserDetails = getUserDetail('user_id', $row['comment_user_id'], 'user_name');

						$checked = ((is_array($this->fields_arr['comment_ids'])) && (in_array($row[$this->COMMENT_TABLE_WHERE_CLAUSE], $this->fields_arr['comment_ids'])))?"checked":'';
						$comment_list_arr[$inc]['tr_class']   = $this->getCSSRowClass();
						$comment_list_arr[$inc]['comment_id']  = $row[$this->COMMENT_TABLE_WHERE_CLAUSE];
						$this->article_comment_ids[$inc] = $row[$this->COMMENT_TABLE_WHERE_CLAUSE];
						$comment_list_arr[$inc]['comment_chk_value'] = $checked;
						$comment_list_arr[$inc]['comment_title'] = $row[$this->MODULE_RETURN_FIELD_TITLE];
						$comment_list_arr[$inc]['module_view_link'] = getUrl('viewarticle', '?article_id='.$row[$this->MODULE_TABLE_WHERE_CLAUSE].'&title='.$this->changeTitle($row[$this->MODULE_RETURN_FIELD_TITLE]), $row[$this->MODULE_TABLE_WHERE_CLAUSE].'/'.$this->changeTitle($row[$this->MODULE_RETURN_FIELD_TITLE]).'/', '', 'article');
						$comment_list_arr[$inc]['member_profile_url'] = getMemberProfileUrl($row['comment_user_id'], $this->UserDetails);
						$comment_list_arr[$inc]['user_details']       = $this->UserDetails;
						$comment_list_arr[$inc]['date_added'] = $row['date_added'];
						$comment_list_arr[$inc]['comment']    = $row['comment'];
						$comment_list_arr[$inc]['viewcomment_url'] = getUrl('viewarticlecomments', '?comment_id='.$row['article_comment_id'], '?comment_id='.$row['article_comment_id'], '', 'article');
						$comment_list_arr[$inc]['comment_status'] = $row['comment_status'];
						$inc++;
					}
				return $comment_list_arr;
			}

		/**
		 * ManageArticleComments::activateComments()
		 * To activate the comments
		 *
		 * @return boolean
		 * @access public
		 */
		public function activateComments()
			{
				$comment_id_arr = explode(',',$this->fields_arr['comment_id']);
			foreach($comment_id_arr as $comment_id)
				{
				$sql = 'SELECT '.$this->MODULE_TABLE_WHERE_CLAUSE.','.$this->COMMENT_TABLE_WHERE_CLAUSE.' FROM '.$this->CFG['db']['tbl'][$this->COMMENT_MODULE_TABLE].' WHERE '.
						$this->COMMENT_TABLE_WHERE_CLAUSE.' IN('.$this->dbObj->Param('comment_id').')';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($comment_id));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				while($row = $rs->FetchRow())
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl'][$this->COMMENT_MODULE_TABLE].' SET'.
								' comment_status=\'Yes\' WHERE '.$this->COMMENT_TABLE_WHERE_CLAUSE.' ='.$this->dbObj->Param($this->COMMENT_TABLE_WHERE_CLAUSE);
						$stmt = $this->dbObj->Prepare($sql);
						$rs1 = $this->dbObj->Execute($stmt, array($row[$this->COMMENT_TABLE_WHERE_CLAUSE]));
						    if (!$rs1)
							    trigger_db_error($this->dbObj);

						if($this->dbObj->Affected_Rows())
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl'][$this->MODULE_TABLE ].' SET total_comments = total_comments+1'.
										' WHERE '.$this->MODULE_TABLE_WHERE_CLAUSE.'='.$this->dbObj->Param($this->MODULE_TABLE_WHERE_CLAUSE);
								$stmt = $this->dbObj->Prepare($sql);
								$rs2 = $this->dbObj->Execute($stmt, array($row[$this->MODULE_TABLE_WHERE_CLAUSE]));
								    if (!$rs2)
									    trigger_db_error($this->dbObj);
							}
					}
				}
			}

		/**
		 * ManageArticleComments::inactivateComments()
		 * To inactivate the comments
		 *
		 * @return boolean
		 * @access public
		 */
		public function inactivateComments()
			{
				$comment_id_arr = explode(',',$this->fields_arr['comment_id']);
			foreach($comment_id_arr as $comment_id)
				{
				$sql = 'SELECT '.$this->MODULE_TABLE_WHERE_CLAUSE.','.$this->COMMENT_TABLE_WHERE_CLAUSE.' FROM '.$this->CFG['db']['tbl'][$this->COMMENT_MODULE_TABLE].' WHERE '.
						$this->COMMENT_TABLE_WHERE_CLAUSE.' IN('.$this->dbObj->Param('comment_id').')';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($comment_id));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				while($row = $rs->FetchRow())
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl'][$this->COMMENT_MODULE_TABLE].' SET'.
								' comment_status=\'No\' WHERE '.$this->COMMENT_TABLE_WHERE_CLAUSE.' ='.$this->dbObj->Param($this->COMMENT_TABLE_WHERE_CLAUSE);
						$stmt = $this->dbObj->Prepare($sql);
						$rs1 = $this->dbObj->Execute($stmt, array($row[$this->COMMENT_TABLE_WHERE_CLAUSE]));
						    if (!$rs1)
							    trigger_db_error($this->dbObj);

						if($this->dbObj->Affected_Rows())
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl'][$this->MODULE_TABLE ].' SET total_comments = total_comments-1'.
										' WHERE '.$this->MODULE_TABLE_WHERE_CLAUSE.'='.$this->dbObj->Param($this->MODULE_TABLE_WHERE_CLAUSE);
								$stmt = $this->dbObj->Prepare($sql);
								$rs2 = $this->dbObj->Execute($stmt, array($row[$this->MODULE_TABLE_WHERE_CLAUSE]));
								    if (!$rs2)
									    trigger_db_error($this->dbObj);
							}
					}
				}
			}
	}
//<<<<<-------------- Class ManageArticleComment begins ---------------//
//-------------------- Code begins -------------->>>>>//
$ManageArticleComments = new ManageArticleComments();
if(!chkAllowedModule(array('article')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$ManageArticleComments->setPageBlockNames(array('comments_form'));
$ManageArticleComments->setFormField('comment_ids', array());
$ManageArticleComments->setFormField('comment_id', '');
$ManageArticleComments->setFormField('act', '');
$ManageArticleComments->setFormField('module', '');
$ManageArticleComments->setFormField('comment_status', '');
$ManageArticleComments->setFormField('slno', '1');
$moduleName = 'article';
$commentIds='';
$ManageArticleComments->DefaultComments();
$ManageArticleComments->InitializeManageArticleComments('article', 'article_comments', 'a', 'ac', 'article_comment_id', 'article_id', 'article_title');
$ManageArticleComments->setTableNames(array($CFG['db']['tbl'][$ManageArticleComments->COMMENT_MODULE_TABLE].' AS '.$ManageArticleComments->COMMENT_MODULE_TABLE_ALIAS.' LEFT JOIN '.$CFG['db']['tbl'][$ManageArticleComments->MODULE_TABLE].' AS '.$ManageArticleComments->MODULE_TABLE_ALIAS.' ON '.$ManageArticleComments->MODULE_TABLE_ALIAS.'.'.$ManageArticleComments->MODULE_TABLE_WHERE_CLAUSE.'='.$ManageArticleComments->COMMENT_MODULE_TABLE_ALIAS.'.'.$ManageArticleComments->MODULE_TABLE_WHERE_CLAUSE, $CFG['db']['tbl']['users'].' as u'));
$ManageArticleComments->setReturnColumns(array($ManageArticleComments->COMMENT_MODULE_TABLE_ALIAS.'.'.$ManageArticleComments->COMMENT_TABLE_WHERE_CLAUSE,$ManageArticleComments->COMMENT_MODULE_TABLE_ALIAS.'.comment_user_id',$ManageArticleComments->COMMENT_MODULE_TABLE_ALIAS.'.'.$ManageArticleComments->MODULE_TABLE_WHERE_CLAUSE, $ManageArticleComments->COMMENT_MODULE_TABLE_ALIAS.'.comment', $ManageArticleComments->MODULE_TABLE_ALIAS.'.'.$ManageArticleComments->MODULE_RETURN_FIELD_TITLE, 'DATE_FORMAT('.$ManageArticleComments->COMMENT_MODULE_TABLE_ALIAS.'.date_added,\''.$CFG['format']['date'].'\') as date_added', $ManageArticleComments->COMMENT_MODULE_TABLE_ALIAS.'.'.$ManageArticleComments->MODULE_RETURN_FIELD_COMMENT_STATUS));
$ManageArticleComments->sanitizeFormInputs($_REQUEST);
$ManageArticleComments->setAllPageBlocksHide();
$ManageArticleComments->setPageBlockShow('comments_form');
if($ManageArticleComments->isFormPOSTed($_POST, 'yes'))
	{
		if($ManageArticleComments->getFormField('act')=='delete')
			{
				$ManageArticleComments->deleteArticleComments($ManageArticleComments->getFormField('comment_id'));
				$ManageArticleComments->setCommonSuccessMsg($LANG['managearticlecomments_success_delete']);
				$ManageArticleComments->setPageBlockShow('block_msg_form_success');
			}
		if($ManageArticleComments->getFormField('act')=='activate')
			{
				$ManageArticleComments->activateComments();
				$ManageArticleComments->setCommonSuccessMsg($LANG['managearticlecomments_success_activate']);
				$ManageArticleComments->setPageBlockShow('block_msg_form_success');
			}
		if($ManageArticleComments->getFormField('act')=='inactivate')
			{
				$ManageArticleComments->inactivateComments();
				$ManageArticleComments->setCommonSuccessMsg($LANG['managearticlecomments_success_inactivate']);
				$ManageArticleComments->setPageBlockShow('block_msg_form_success');
			}
	}
if ($ManageArticleComments->isShowPageBlock('comments_form'))
    {
		$LANG['managearticlecomments_title']       = str_replace('{module}',ucfirst($ManageArticleComments->getFormField('module')),$LANG['managearticlecomments_title']);
		$LANG['managearticlecomments_module']      = str_replace('{module}',ucfirst($ManageArticleComments->getFormField('module')),$LANG['managearticlecomments_module']);
		$LANG['managearticlecomments_tbl_summary'] = str_replace('{module}',ucfirst($ManageArticleComments->getFormField('module')),$LANG['managearticlecomments_tbl_summary']);
		$ManageArticleComments->form_manage_comments['comments_title']       = $LANG['managearticlecomments_title'];
		$ManageArticleComments->form_manage_comments['comments_module']      = $LANG['managearticlecomments_module'];
		$ManageArticleComments->form_manage_comments['comments_tbl_summary'] = $LANG['managearticlecomments_tbl_summary'];
		$ManageArticleComments->buildSelectQuery();
		$ManageArticleComments->buildConditionQuery($ManageArticleComments->getFormField('comment_status'));
		$ManageArticleComments->buildSortQuery();
		$ManageArticleComments->buildQuery();
		//$ManageArticleComments->printQuery();
		$ManageArticleComments->executeQuery();
		$ManageArticleComments->form_manage_comments['form_hidden_value'] = array('start');
		$ManageArticleComments->form_manage_comments['record_found'] = FALSE;
		if($ManageArticleComments->isResultsFound())
			{
				$paging_arr = array('module');
				$ManageArticleComments->form_manage_comments['record_found'] = true;
				$smartyObj->assign('smarty_paging_list', $ManageArticleComments->populatePageLinksGET($ManageArticleComments->getFormField('start'), $paging_arr));
				$ManageArticleComments->form_manage_comments['comments_list'] = $ManageArticleComments->displayCommentList();
				$commentIds=implode('\',\'',$ManageArticleComments->article_comment_ids);
				if(empty($ManageArticleComments->form_manage_comments['comments_list']))
					{
						$ManageArticleComments->form_manage_comments['record_found'] = FALSE;
					}
			}
	}
$ManageArticleComments->includeHeader();
setTemplateFolder('members/','article');
$smartyObj->display('manageArticleComments.tpl');
?>
<script language="javascript">
var manage_comment_ids = Array('<?php echo $commentIds?>');
function popupWindow(url)
		{
			 window.open (url, "","status=0,toolbar=0,resizable=1,scrollbars=1");
			 return false;
		}
</script>
<?php
$ManageArticleComments->includeFooter();
//<<<<<-------------------- Code ends----------------------//
?>