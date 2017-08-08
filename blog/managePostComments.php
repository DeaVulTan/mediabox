<?php
/**
 * This file is to manage the blog comments
 *
 * This file is having ManagePostComments class to manage the comment of posts
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 **/
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/blog/managePostComments.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_BlogHandler.lib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['site']['is_module_page']='blog';
require($CFG['site']['project_path'].'common/application_top.inc.php');

/**
 * ManagePostComments for post. User can change the status and the delete the unwanted comments.
 *
 * @category	rayzz
 * @package		Members
 **/
class ManagePostComments extends BlogHandler
	{

		/**
		 * ManagePostComments::DefaultComments()
		 * Define the sql fields and their table names
		 *
		 * @access public
		 * @return void
		 */
		public function DefaultComments()
			{
				$this->MODULE_TABLE               = 'blog_posts';
				$this->COMMENT_MODULE_TABLE       = 'blog_comments';
				$this->MODULE_TABLE_ALIAS         = 'bp';
				$this->COMMENT_MODULE_TABLE_ALIAS = 'bc';
				$this->COMMENT_TABLE_WHERE_CLAUSE = 'blog_comment_id';
				$this->MODULE_TABLE_WHERE_CLAUSE  = 'blog_post_id';
				$this->MODULE_RETURN_FIELD_TITLE  = 'blog_post_name';
				$this->MODULE_RETURN_FIELD_COMMENT_STATUS  = 'comment_status';
			}

		/**
		 * ManagePostComments::InitializeManagePostComments()
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
		public function InitializeManagePostComments($MODULE_TABLE='blog_posts',	$COMMENT_MODULE_TABLE='blog_comments', $MODULE_TABLE_ALIAS='bp',$COMMENT_MODULE_TABLE_ALIAS='bc', $COMMENT_TABLE_WHERE_CLAUSE='blog_comment_id', $MODULE_TABLE_WHERE_CLAUSE='blog_post_id', $MODULE_RETURN_FIELD_TITLE='blog_post_name')
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
		 * ManagePostComments::buildConditionQuery()
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
		 * ManagePostComments::buildSortQuery()
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
		 * ManagePostComments::displayCommentList()
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
				while($row = $this->fetchResultRecord())
				    {
						if(!isset($this->UserDetails[$row['comment_user_id']]))
						    $this->getUserDetail('user_id',$row['comment_user_id'], 'user_name');
						$checked = ((is_array($this->fields_arr['comment_ids'])) && (in_array($row[$this->COMMENT_TABLE_WHERE_CLAUSE], $this->fields_arr['comment_ids'])))?"checked":'';
						$comment_list_arr[$inc]['tr_class']   = $this->getCSSRowClass();
						$comment_list_arr[$inc]['comment_id']        = $row[$this->COMMENT_TABLE_WHERE_CLAUSE];
						$comment_list_arr[$inc]['comment_chk_value'] = $checked;
						$comment_list_arr[$inc]['comment_title'] = $row[$this->MODULE_RETURN_FIELD_TITLE];
						$comment_list_arr[$inc]['module_view_link'] = getUrl('viewpost', '?blog_post_id='.$row[$this->MODULE_TABLE_WHERE_CLAUSE].'&title='.$this->changeTitle($row[$this->MODULE_RETURN_FIELD_TITLE]), $row[$this->MODULE_TABLE_WHERE_CLAUSE].'/'.$this->changeTitle($row[$this->MODULE_RETURN_FIELD_TITLE]).'/', '', 'blog');
						$user_name=$this->getUserDetail('user_id',$row['comment_user_id'], 'user_name');
						$comment_list_arr[$inc]['member_profile_url'] = getMemberProfileUrl($row['comment_user_id'], $user_name);
						$comment_list_arr[$inc]['user_details']       = $user_name;
						$comment_list_arr[$inc]['date_added'] = $row['date_added'];
						$comment_list_arr[$inc]['comment']    = $row['comment'];
						$comment_list_arr[$inc]['viewcomment_url'] = getUrl('viewpostcomments', '?comment_id='.$row['blog_comment_id'], '?comment_id='.$row['blog_comment_id'], '', 'blog');
						$comment_list_arr[$inc]['comment_status'] = $row['comment_status'];
						$inc++;
					}
				return $comment_list_arr;
			}

		/**
		 * ManagePostComments::activateComments()
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
		 * ManagePostComments::inactivateComments()
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
//<<<<<-------------- Class ManagePostComments begins ---------------//
//-------------------- Code begins -------------->>>>>//
$ManagePostComments = new ManagePostComments();
if(!chkAllowedModule(array('blog')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$ManagePostComments->setPageBlockNames(array('comments_form'));
$ManagePostComments->setFormField('comment_ids', array());
$ManagePostComments->setFormField('comment_id', '');
$ManagePostComments->setFormField('act', '');
$ManagePostComments->setFormField('module', '');
$ManagePostComments->setFormField('comment_status', '');
$ManagePostComments->setFormField('slno', '1');
$moduleName = 'blog';
$ManagePostComments->DefaultComments();
$ManagePostComments->InitializeManagePostComments('blog_posts', 'blog_comments', 'bp', 'bc', 'blog_comment_id', 'blog_post_id', 'blog_post_name');
$ManagePostComments->setTableNames(array($CFG['db']['tbl'][$ManagePostComments->COMMENT_MODULE_TABLE].' AS '.$ManagePostComments->COMMENT_MODULE_TABLE_ALIAS.' LEFT JOIN '.$CFG['db']['tbl'][$ManagePostComments->MODULE_TABLE].' AS '.$ManagePostComments->MODULE_TABLE_ALIAS.' ON '.$ManagePostComments->MODULE_TABLE_ALIAS.'.'.$ManagePostComments->MODULE_TABLE_WHERE_CLAUSE.'='.$ManagePostComments->COMMENT_MODULE_TABLE_ALIAS.'.'.$ManagePostComments->MODULE_TABLE_WHERE_CLAUSE, $CFG['db']['tbl']['users'].' as u'));
$ManagePostComments->setReturnColumns(array($ManagePostComments->COMMENT_MODULE_TABLE_ALIAS.'.'.$ManagePostComments->COMMENT_TABLE_WHERE_CLAUSE,$ManagePostComments->COMMENT_MODULE_TABLE_ALIAS.'.comment_user_id',$ManagePostComments->COMMENT_MODULE_TABLE_ALIAS.'.'.$ManagePostComments->MODULE_TABLE_WHERE_CLAUSE, $ManagePostComments->COMMENT_MODULE_TABLE_ALIAS.'.comment', $ManagePostComments->MODULE_TABLE_ALIAS.'.'.$ManagePostComments->MODULE_RETURN_FIELD_TITLE, 'DATE_FORMAT('.$ManagePostComments->COMMENT_MODULE_TABLE_ALIAS.'.date_added,\''.$CFG['format']['date'].'\') as date_added', $ManagePostComments->COMMENT_MODULE_TABLE_ALIAS.'.'.$ManagePostComments->MODULE_RETURN_FIELD_COMMENT_STATUS));
$ManagePostComments->sanitizeFormInputs($_REQUEST);
$ManagePostComments->setAllPageBlocksHide();
$ManagePostComments->setPageBlockShow('comments_form');
if($ManagePostComments->isFormPOSTed($_POST, 'yes'))
	{
		if($ManagePostComments->getFormField('act')=='delete')
			{
				$ManagePostComments->deletePostComments($ManagePostComments->getFormField('comment_id'));
				$ManagePostComments->setCommonSuccessMsg($LANG['managepostcomments_success_delete']);
				$ManagePostComments->setPageBlockShow('block_msg_form_success');
			}
		if($ManagePostComments->getFormField('act')=='activate')
			{
				$ManagePostComments->activateComments();
				$ManagePostComments->setCommonSuccessMsg($LANG['managepostcomments_success_activate']);
				$ManagePostComments->setPageBlockShow('block_msg_form_success');
			}
		if($ManagePostComments->getFormField('act')=='inactivate')
			{
				$ManagePostComments->inactivateComments();
				$ManagePostComments->setCommonSuccessMsg($LANG['managepostcomments_success_inactivate']);
				$ManagePostComments->setPageBlockShow('block_msg_form_success');
			}
	}
if ($ManagePostComments->isShowPageBlock('comments_form'))
    {
		$LANG['managepostcomments_title']       = str_replace('{module}',ucfirst($ManagePostComments->getFormField('module')),$LANG['managepostcomments_title']);
		$LANG['managepostcomments_module']      = str_replace('{module}',ucfirst($ManagePostComments->getFormField('module')),$LANG['managepostcomments_module']);
		$LANG['managepostcomments_tbl_summary'] = str_replace('{module}',ucfirst($ManagePostComments->getFormField('module')),$LANG['managepostcomments_tbl_summary']);
		$ManagePostComments->form_manage_comments['comments_title']       = $LANG['managepostcomments_title'];
		$ManagePostComments->form_manage_comments['comments_module']      = $LANG['managepostcomments_module'];
		$ManagePostComments->form_manage_comments['comments_tbl_summary'] = $LANG['managepostcomments_tbl_summary'];
		$ManagePostComments->buildSelectQuery();
		$ManagePostComments->buildConditionQuery($ManagePostComments->getFormField('comment_status'));
		$ManagePostComments->buildSortQuery();
		$ManagePostComments->buildQuery();
		//$ManagePostComments->printQuery();
		$ManagePostComments->executeQuery();
		$ManagePostComments->form_manage_comments['form_hidden_value'] = array('start');
		$ManagePostComments->form_manage_comments['record_found'] = FALSE;
		if($ManagePostComments->isResultsFound())
			{
				$paging_arr = array('module');
				$ManagePostComments->form_manage_comments['record_found'] = true;
				$smartyObj->assign('smarty_paging_list', $ManagePostComments->populatePageLinksGET($ManagePostComments->getFormField('start'), $paging_arr));
				$ManagePostComments->form_manage_comments['comments_list'] = $ManagePostComments->displayCommentList();
				if(empty($ManagePostComments->form_manage_comments['comments_list']))
					{
						$ManagePostComments->form_manage_comments['record_found'] = FALSE;
					}
			}
	}
$ManagePostComments->includeHeader();
setTemplateFolder('members/','blog');
$smartyObj->display('managePostComments.tpl');
?>
<script language="javascript">
function popupWindow(url)
		{
			 window.open (url, "","status=0,toolbar=0,resizable=1,scrollbars=1");
			 return false;
		}
</script>
<?php
$ManagePostComments->includeFooter();
//<<<<<-------------------- Code ends----------------------//
?>