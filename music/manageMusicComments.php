<?php
/**
 * This file is to manage the comment of my music
 *
 * This file is having ManageMusicComments class to manage the comment of my music
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 **/
require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_music.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/manageMusicComments.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['site']['is_module_page']='music';
$CFG['auth']['is_authenticate'] = 'members';
require($CFG['site']['project_path'].'common/application_top.inc.php');

/**
 * ManageMusicComments for audio, music, photo, article and games. User can change the status and the delete the unwanted comments.
 *
 * @category	rayzz
 * @package		Members
 **/
class ManageMusicComments extends MusicHandler
	{

		/**
		 * ManageMusicComments::DefaultComments()
		 * Define the sql fields and their table names
		 *
		 * @access public
		 * @return void
		 */
		public function DefaultComments()
			{
				$this->MODULE_TABLE               = 'music';
				$this->COMMENT_MODULE_TABLE       = 'music_comments';
				$this->MODULE_TABLE_ALIAS         = 'm';
				$this->COMMENT_MODULE_TABLE_ALIAS = 'mc';
				$this->COMMENT_TABLE_WHERE_CLAUSE = 'music_comment_id';
				$this->MODULE_TABLE_WHERE_CLAUSE  = 'music_id';
				$this->MODULE_RETURN_FIELD_TITLE  = 'music_title';
				$this->MODULE_RETURN_FIELD_COMMENT_STATUS  = 'comment_status';
			}

		/**
		 * ManageMusicComments::InitializeManageMusicComments()
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
		public function InitializeManageMusicComments($MODULE_TABLE='music',	$COMMENT_MODULE_TABLE='music_comments', $MODULE_TABLE_ALIAS='m',$COMMENT_MODULE_TABLE_ALIAS='mc', $COMMENT_TABLE_WHERE_CLAUSE='music_comment_id', $MODULE_TABLE_WHERE_CLAUSE='music_id', $MODULE_RETURN_FIELD_TITLE='music_title')
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
		 * ManageMusicComments::buildConditionQuery()
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
		 * ManageMusicComments::buildSortQuery()
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
		 * ManageMusicComments::displayCommentList()
		 * To dispaly the comments
		 *
		 * @return array
		 * @access public
		 */
		public function displayCommentList()
			{
				$comment_list_arr = array();
				$inc = 0;
				$this->music_comment_ids=array();

				while($row = $this->fetchResultRecord())
				    {
						$user_name = $this->getUserDetail('user_id', $row['comment_user_id'], 'user_name');
						$checked = ((is_array($this->fields_arr['comment_ids'])) && (in_array($row[$this->COMMENT_TABLE_WHERE_CLAUSE], $this->fields_arr['comment_ids'])))?"checked":'';
						$comment_list_arr[$inc]['tr_class']   = $this->getCSSRowClass();
						$comment_list_arr[$inc]['comment_id']        = $row[$this->COMMENT_TABLE_WHERE_CLAUSE];
						$this->music_comment_ids[$inc]				= $row[$this->COMMENT_TABLE_WHERE_CLAUSE];

						$comment_list_arr[$inc]['comment_chk_value'] = $checked;
						$comment_list_arr[$inc]['comment_title'] = wordWrap_mb_ManualWithSpace($row[$this->MODULE_RETURN_FIELD_TITLE], $this->CFG['admin']['musics']['list_title_length'], $this->CFG['admin']['musics']['list_title_total_length']);
						$comment_list_arr[$inc]['module_view_link'] = getUrl('viewmusic', '?music_id='.$row[$this->MODULE_TABLE_WHERE_CLAUSE].'&title='.$this->changeTitle($row[$this->MODULE_RETURN_FIELD_TITLE]), $row[$this->MODULE_TABLE_WHERE_CLAUSE].'/'.$this->changeTitle($row[$this->MODULE_RETURN_FIELD_TITLE]).'/', '', 'music');
						$comment_list_arr[$inc]['member_profile_url'] = getMemberProfileUrl($row['comment_user_id'], $user_name);
						$comment_list_arr[$inc]['user_details']       = $user_name;
						$comment_list_arr[$inc]['date_added'] = $row['date_added'];
					//	$comment_list_arr[$inc]['comment']    = wordWrap_mb_ManualWithSpace($row['comment'], $this->CFG['admin']['musics']['member_music_comments_length'], $this->CFG['admin']['musics']['member_music_comments_total_length']);
						$comment_list_arr[$inc]['comment']    = $row['comment'];
						$comment_list_arr[$inc]['viewcomment_url'] = getUrl('viewmusiccomments', '?comment_id='.$row['music_comment_id'], '?comment_id='.$row['music_comment_id'], '', 'music');
						$comment_list_arr[$inc]['comment_status'] = $row['comment_status'];
						$inc++;
					}
				return $comment_list_arr;
			}

		/**
		 * ManageMusicComments::activateComments()
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
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				while($row = $rs->FetchRow())
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl'][$this->COMMENT_MODULE_TABLE].' SET'.
								' comment_status=\'Yes\' WHERE '.$this->COMMENT_TABLE_WHERE_CLAUSE.' ='.$this->dbObj->Param($this->COMMENT_TABLE_WHERE_CLAUSE);
						$stmt = $this->dbObj->Prepare($sql);
						$rs1 = $this->dbObj->Execute($stmt, array($row[$this->COMMENT_TABLE_WHERE_CLAUSE]));
						    if (!$rs1)
							    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						if($this->dbObj->Affected_Rows())
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl'][$this->MODULE_TABLE ].' SET total_comments = total_comments+1'.
										' WHERE '.$this->MODULE_TABLE_WHERE_CLAUSE.'='.$this->dbObj->Param($this->MODULE_TABLE_WHERE_CLAUSE);
								$stmt = $this->dbObj->Prepare($sql);
								$rs2 = $this->dbObj->Execute($stmt, array($row[$this->MODULE_TABLE_WHERE_CLAUSE]));
								    if (!$rs2)
									    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
							}
					}
				}
			}
	}
//<<<<<-------------- Class musicMusicComment begins ---------------//
//-------------------- Code begins -------------->>>>>//
$ManageMusicComments = new ManageMusicComments();
if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$ManageMusicComments->setPageBlockNames(array('comments_form'));
$ManageMusicComments->setFormField('comment_ids', array());
$ManageMusicComments->setFormField('comment_id', '');
$ManageMusicComments->setFormField('act', '');
$ManageMusicComments->setFormField('module', '');
$ManageMusicComments->setFormField('comment_status', '');
$ManageMusicComments->setFormField('slno', '1');
$moduleName = 'music';
$commentIds = '';

$ManageMusicComments->DefaultComments();
$ManageMusicComments->InitializeManageMusicComments('music', 'music_comments', 'v', 'vc', 'music_comment_id', 'music_id', 'music_title');
$ManageMusicComments->setTableNames(array($CFG['db']['tbl'][$ManageMusicComments->COMMENT_MODULE_TABLE].' AS '.$ManageMusicComments->COMMENT_MODULE_TABLE_ALIAS.' LEFT JOIN '.$CFG['db']['tbl'][$ManageMusicComments->MODULE_TABLE].' AS '.$ManageMusicComments->MODULE_TABLE_ALIAS.' ON '.$ManageMusicComments->MODULE_TABLE_ALIAS.'.'.$ManageMusicComments->MODULE_TABLE_WHERE_CLAUSE.'='.$ManageMusicComments->COMMENT_MODULE_TABLE_ALIAS.'.'.$ManageMusicComments->MODULE_TABLE_WHERE_CLAUSE, $CFG['db']['tbl']['users'].' as u'));
$ManageMusicComments->setReturnColumns(array($ManageMusicComments->COMMENT_MODULE_TABLE_ALIAS.'.'.$ManageMusicComments->COMMENT_TABLE_WHERE_CLAUSE,$ManageMusicComments->COMMENT_MODULE_TABLE_ALIAS.'.comment_user_id',$ManageMusicComments->COMMENT_MODULE_TABLE_ALIAS.'.'.$ManageMusicComments->MODULE_TABLE_WHERE_CLAUSE, $ManageMusicComments->COMMENT_MODULE_TABLE_ALIAS.'.comment', $ManageMusicComments->MODULE_TABLE_ALIAS.'.'.$ManageMusicComments->MODULE_RETURN_FIELD_TITLE, 'DATE_FORMAT('.$ManageMusicComments->COMMENT_MODULE_TABLE_ALIAS.'.date_added,\''.$CFG['format']['date'].'\') as date_added', $ManageMusicComments->COMMENT_MODULE_TABLE_ALIAS.'.'.$ManageMusicComments->MODULE_RETURN_FIELD_COMMENT_STATUS));
$ManageMusicComments->sanitizeFormInputs($_REQUEST);
$ManageMusicComments->setAllPageBlocksHide();
$ManageMusicComments->setPageBlockShow('comments_form');
if($ManageMusicComments->isFormPOSTed($_POST, 'yes'))
	{
		if($ManageMusicComments->getFormField('act')=='delete')
			{
				$ManageMusicComments->deleteMusicComments($ManageMusicComments->getFormField('comment_id'));
				$ManageMusicComments->setCommonSuccessMsg($LANG['managemusiccomments_success_delete']);
				$ManageMusicComments->setPageBlockShow('block_msg_form_success');
			}
		if($ManageMusicComments->getFormField('act')=='activate')
			{
				$ManageMusicComments->activateComments();
				$ManageMusicComments->setCommonSuccessMsg($LANG['managemusiccomments_success_activate']);
				$ManageMusicComments->setPageBlockShow('block_msg_form_success');
			}
	}
if ($ManageMusicComments->isShowPageBlock('comments_form'))
    {
		$LANG['managemusiccomments_title']       = str_replace('{module}',ucfirst($ManageMusicComments->getFormField('module')),$LANG['managemusiccomments_title']);
		$LANG['managemusiccomments_module']      = str_replace('{module}',ucfirst($ManageMusicComments->getFormField('module')),$LANG['managemusiccomments_module']);
		$LANG['managemusiccomments_tbl_summary'] = str_replace('{module}',ucfirst($ManageMusicComments->getFormField('module')),$LANG['managemusiccomments_tbl_summary']);
		$ManageMusicComments->form_manage_comments['comments_title']       = $LANG['managemusiccomments_title'];
		$ManageMusicComments->form_manage_comments['comments_module']      = $LANG['managemusiccomments_module'];
		$ManageMusicComments->form_manage_comments['comments_tbl_summary'] = $LANG['managemusiccomments_tbl_summary'];
		$ManageMusicComments->buildSelectQuery();
		$ManageMusicComments->buildConditionQuery($ManageMusicComments->getFormField('comment_status'));
		$ManageMusicComments->buildSortQuery();
		$ManageMusicComments->buildQuery();
		//$ManageMusicComments->printQuery();
		$ManageMusicComments->executeQuery();
		$ManageMusicComments->form_manage_comments['form_hidden_value'] = array('start');
		$ManageMusicComments->form_manage_comments['record_found'] = FALSE;
		if($ManageMusicComments->isResultsFound())
			{
				$paging_arr = array('module');
				$ManageMusicComments->form_manage_comments['record_found'] = true;
				$smartyObj->assign('smarty_paging_list', $ManageMusicComments->populatePageLinksGET($ManageMusicComments->getFormField('start'), $paging_arr));
				$ManageMusicComments->form_manage_comments['comments_list'] = $ManageMusicComments->displayCommentList();
				$commentIds=implode('\',\'',$ManageMusicComments->music_comment_ids);
				if(empty($ManageMusicComments->form_manage_comments['comments_list']))
					{
						$ManageMusicComments->form_manage_comments['record_found'] = FALSE;
					}
			}
	}
$ManageMusicComments->includeHeader();
?>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/functions.js"></script>
<?php
setTemplateFolder('members/','music');
$smartyObj->display('manageMusicComments.tpl');
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
$ManageMusicComments->includeFooter();
//<<<<<-------------------- Code ends----------------------//
?>