<?php
/**
 * This file is to manage the photo comments
 *
 * This file is having ManagePhotoComments class to manage the comment of photo
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 **/
require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_photo.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/photo/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/managePhotoComments.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoHandler.lib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
$CFG['html']['is_use_header'] = false;
$CFG['site']['is_module_page']='photo';
$CFG['admin']['light_window_page'] = true;
require($CFG['site']['project_path'].'common/application_top.inc.php');


/**
 * ManagePhotoComments for photo. User can change the status and the delete the unwanted comments.
 *
 * @category	rayzz
 * @package		Members
 **/
class ManagePhotoComments extends PhotoHandler
	{

		/**
		 * ManagePhotoComments::DefaultComments()
		 * Define the sql fields and their table names
		 *
		 * @access public
		 * @return void
		 */
		public function DefaultComments()
			{
				$this->MODULE_TABLE               = 'photo';
				$this->COMMENT_MODULE_TABLE       = 'photo_comments';
				$this->MODULE_TABLE_ALIAS         = 'p';
				$this->COMMENT_MODULE_TABLE_ALIAS = 'pc';
				$this->COMMENT_TABLE_WHERE_CLAUSE = 'photo_comment_id';
				$this->MODULE_TABLE_WHERE_CLAUSE  = 'photo_id';
				$this->MODULE_RETURN_FIELD_TITLE  = 'photo_title';
				$this->MODULE_RETURN_FIELD_COMMENT_STATUS  = 'comment_status';
			}

		/**
		 * ManagePhotoComments::InitializeManagePhotoComments()
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
		public function InitializeManagePhotoComments($MODULE_TABLE='photo',	$COMMENT_MODULE_TABLE='photo_comments', $MODULE_TABLE_ALIAS='p',$COMMENT_MODULE_TABLE_ALIAS='pc', $COMMENT_TABLE_WHERE_CLAUSE='photo_comment_id', $MODULE_TABLE_WHERE_CLAUSE='photo_id', $MODULE_RETURN_FIELD_TITLE='photo_title')
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
		 * ManagePhotoComments::buildConditionQuery()
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
		 * ManagePhotoComments::buildSortQuery()
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
		 * ManagePhotoComments::displayCommentList()
		 * To dispaly the comments
		 *
		 * @return array
		 * @access public
		 */
		public function displayCommentList()
			{
				$comment_list_arr = array();
				$inc = 0;
				$this->photo_comment_ids=array();
				while($row = $this->fetchResultRecord())
				    {

						$this->UserDetails = $this->getUserDetail('user_id', $row['comment_user_id'], 'user_name');
						$checked = ((is_array($this->fields_arr['comment_ids'])) && (in_array($row[$this->COMMENT_TABLE_WHERE_CLAUSE], $this->fields_arr['comment_ids'])))?"checked":'';
						$comment_list_arr[$inc]['tr_class']   = $this->getCSSRowClass();
						$comment_list_arr[$inc]['comment_id']        = $row[$this->COMMENT_TABLE_WHERE_CLAUSE];
						$this->photo_comment_ids[$inc]=$row[$this->COMMENT_TABLE_WHERE_CLAUSE];
						$comment_list_arr[$inc]['comment_chk_value'] = $checked;
						$comment_list_arr[$inc]['comment_title'] = $row[$this->MODULE_RETURN_FIELD_TITLE];
						$comment_list_arr[$inc]['module_view_link'] = getUrl('viewphoto', '?photo_id='.$row[$this->MODULE_TABLE_WHERE_CLAUSE].'&title='.$this->changeTitle($row[$this->MODULE_RETURN_FIELD_TITLE]), $row[$this->MODULE_TABLE_WHERE_CLAUSE].'/'.$this->changeTitle($row[$this->MODULE_RETURN_FIELD_TITLE]).'/', '', 'photo');
						$comment_list_arr[$inc]['member_profile_url'] = getMemberProfileUrl($row['comment_user_id'], $this->UserDetails);
						$comment_list_arr[$inc]['user_details']       = $this->UserDetails;
						$comment_list_arr[$inc]['date_added'] = $row['date_added'];
						$comment_list_arr[$inc]['comment']    = $row['comment'];
						$comment_list_arr[$inc]['viewcomment_url'] = getUrl('viewphotocomments', '?comment_id='.$row['photo_comment_id'], '?comment_id='.$row['photo_comment_id'], '', 'photo');
						$comment_list_arr[$inc]['comment_status'] = $row['comment_status'];
						$inc++;
					}
				return $comment_list_arr;
			}

		/**
		 * ManagePhotoComments::activateComments()
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
		 * ManagePhotoComments::inactivateComments()
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
//<<<<<-------------- Class ManagePhotoComment begins ---------------//
//-------------------- Code begins -------------->>>>>//
$ManagePhotoComments = new ManagePhotoComments();
if(!chkAllowedModule(array('photo')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$ManagePhotoComments->setPageBlockNames(array('comments_form'));
$ManagePhotoComments->setFormField('comment_ids', array());
$ManagePhotoComments->setFormField('comment_id', '');
$ManagePhotoComments->setFormField('act', '');
$ManagePhotoComments->setFormField('module', '');
$ManagePhotoComments->setFormField('comment_status', '');
$ManagePhotoComments->setFormField('slno', '1');
$moduleName = 'photo';
$commentIds='';
$ManagePhotoComments->DefaultComments();
$ManagePhotoComments->InitializeManagePhotoComments('photo', 'photo_comments', 'p', 'pc', 'photo_comment_id', 'photo_id', 'photo_title');
$ManagePhotoComments->setTableNames(array($CFG['db']['tbl'][$ManagePhotoComments->COMMENT_MODULE_TABLE].' AS '.$ManagePhotoComments->COMMENT_MODULE_TABLE_ALIAS.' LEFT JOIN '.$CFG['db']['tbl'][$ManagePhotoComments->MODULE_TABLE].' AS '.$ManagePhotoComments->MODULE_TABLE_ALIAS.' ON '.$ManagePhotoComments->MODULE_TABLE_ALIAS.'.'.$ManagePhotoComments->MODULE_TABLE_WHERE_CLAUSE.'='.$ManagePhotoComments->COMMENT_MODULE_TABLE_ALIAS.'.'.$ManagePhotoComments->MODULE_TABLE_WHERE_CLAUSE, $CFG['db']['tbl']['users'].' as u'));
$ManagePhotoComments->setReturnColumns(array($ManagePhotoComments->COMMENT_MODULE_TABLE_ALIAS.'.'.$ManagePhotoComments->COMMENT_TABLE_WHERE_CLAUSE,$ManagePhotoComments->COMMENT_MODULE_TABLE_ALIAS.'.comment_user_id',$ManagePhotoComments->COMMENT_MODULE_TABLE_ALIAS.'.'.$ManagePhotoComments->MODULE_TABLE_WHERE_CLAUSE, $ManagePhotoComments->COMMENT_MODULE_TABLE_ALIAS.'.comment', $ManagePhotoComments->MODULE_TABLE_ALIAS.'.'.$ManagePhotoComments->MODULE_RETURN_FIELD_TITLE, 'DATE_FORMAT('.$ManagePhotoComments->COMMENT_MODULE_TABLE_ALIAS.'.date_added,\''.$CFG['format']['date'].'\') as date_added', $ManagePhotoComments->COMMENT_MODULE_TABLE_ALIAS.'.'.$ManagePhotoComments->MODULE_RETURN_FIELD_COMMENT_STATUS));
$ManagePhotoComments->sanitizeFormInputs($_REQUEST);
$ManagePhotoComments->setAllPageBlocksHide();
$ManagePhotoComments->setPageBlockShow('comments_form');
if($ManagePhotoComments->isFormPOSTed($_POST, 'yes'))
	{
		if($ManagePhotoComments->getFormField('act')=='delete')
			{
				$ManagePhotoComments->deletePhotoComments($ManagePhotoComments->getFormField('comment_id'));
				$ManagePhotoComments->setCommonSuccessMsg($LANG['managephotocomments_success_delete']);
				$ManagePhotoComments->setPageBlockShow('block_msg_form_success');
			}
		if($ManagePhotoComments->getFormField('act')=='activate')
			{
				$ManagePhotoComments->activateComments();
				$ManagePhotoComments->setCommonSuccessMsg($LANG['managephotocomments_success_activate']);
				$ManagePhotoComments->setPageBlockShow('block_msg_form_success');
			}
		if($ManagePhotoComments->getFormField('act')=='inactivate')
			{
				$ManagePhotoComments->inactivateComments();
				$ManagePhotoComments->setCommonSuccessMsg($LANG['managephotocomments_success_inactivate']);
				$ManagePhotoComments->setPageBlockShow('block_msg_form_success');
			}
	}
if ($ManagePhotoComments->isShowPageBlock('comments_form'))
    {
		$LANG['managephotocomments_title']       = str_replace('{module}',ucfirst($ManagePhotoComments->getFormField('module')),$LANG['managephotocomments_title']);
		$LANG['managephotocomments_module']      = str_replace('{module}',ucfirst($ManagePhotoComments->getFormField('module')),$LANG['managephotocomments_module']);
		$LANG['managephotocomments_tbl_summary'] = str_replace('{module}',ucfirst($ManagePhotoComments->getFormField('module')),$LANG['managephotocomments_tbl_summary']);
		$ManagePhotoComments->form_manage_comments['comments_title']       = $LANG['managephotocomments_title'];
		$ManagePhotoComments->form_manage_comments['comments_module']      = $LANG['managephotocomments_module'];
		$ManagePhotoComments->form_manage_comments['comments_tbl_summary'] = $LANG['managephotocomments_tbl_summary'];
		$ManagePhotoComments->buildSelectQuery();
		$ManagePhotoComments->buildConditionQuery($ManagePhotoComments->getFormField('comment_status'));
		$ManagePhotoComments->buildSortQuery();
		$ManagePhotoComments->buildQuery();
		//$ManagePhotoComments->printQuery();
		$ManagePhotoComments->executeQuery();
		$ManagePhotoComments->form_manage_comments['form_hidden_value'] = array('start');
		$ManagePhotoComments->form_manage_comments['record_found'] = FALSE;
		if($ManagePhotoComments->isResultsFound())
			{
				$paging_arr = array('module');
				$ManagePhotoComments->form_manage_comments['record_found'] = true;
				$smartyObj->assign('smarty_paging_list', $ManagePhotoComments->populatePageLinksGET($ManagePhotoComments->getFormField('start'), $paging_arr));
				$ManagePhotoComments->form_manage_comments['comments_list'] = $ManagePhotoComments->displayCommentList();
				$commentIds=implode('\',\'',$ManagePhotoComments->photo_comment_ids);
				if(empty($ManagePhotoComments->form_manage_comments['comments_list']))
					{
						$ManagePhotoComments->form_manage_comments['record_found'] = FALSE;
					}
			}
	}
$ManagePhotoComments->includeHeader();
setTemplateFolder('members/','photo');
$smartyObj->display('managePhotoComments.tpl');
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
$ManagePhotoComments->includeFooter();
//<<<<<-------------------- Code ends----------------------//
?>