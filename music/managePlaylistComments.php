<?php
/**
 * This file is to manage the comment of my musics playlist
 *
 * This file is having ManagePlaylistComments class to manage the comment of my musics
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 **/
require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_music.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/managePlaylistComments.php';
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
 * ManagePlaylistComments for audio, music, photo, article and games. User can change the status and the delete the unwanted comments.
 *
 * @category	rayzz
 * @package		Members
 **/
class ManagePlaylistComments extends MusicHandler
	{

		/**
		 * ManagePlaylistComments::DefaultComments()
		 * Define the sql fields and their table names
		 *
		 * @access public
		 * @return void
		 */
		public function DefaultComments()
			{
				$this->MODULE_TABLE               = 'music_playlist';
				$this->COMMENT_MODULE_TABLE       = 'music_playlist_comments';
				$this->MODULE_TABLE_ALIAS         = 'm';
				$this->COMMENT_MODULE_TABLE_ALIAS = 'mc';
				$this->COMMENT_TABLE_WHERE_CLAUSE = 'playlist_comment_id';
				$this->MODULE_TABLE_WHERE_CLAUSE  = 'playlist_id';
				$this->MODULE_RETURN_FIELD_TITLE  = 'playlist_name';
				$this->MODULE_RETURN_COMMENT_STATUS  = 'comment_status';
			}

		/**
		 * ManagePlaylistComments::InitializeManagePlaylistComments()
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
		public function InitializeManagePlaylistComments($MODULE_TABLE='music_playlist',	$COMMENT_MODULE_TABLE='music_playlist_comments', $MODULE_TABLE_ALIAS='m',$COMMENT_MODULE_TABLE_ALIAS='mc', $COMMENT_TABLE_WHERE_CLAUSE='playlist_comment_id', $MODULE_TABLE_WHERE_CLAUSE='playlist_id', $MODULE_RETURN_FIELD_TITLE='playlist_name')
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
		 * ManagePlaylistComments::buildConditionQuery()
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
		 * ManagePlaylistComments::buildSortQuery()
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
		 * ManagePlaylistComments::displayCommentList()
		 * To dispaly the comments
		 *
		 * @return array
		 * @access public
		 */
		public function displayCommentList()
			{
				$comment_list_arr = array();
				$inc = 0;
				$this->playlist_comment_ids=array();
				while($row = $this->fetchResultRecord())
				    {
				    	if(!isset($this->UserDetails[$row['comment_user_id']]))
							$this->UserDetails[$row['comment_user_id']] = $this->getUserDetail('user_id', $row['comment_user_id']);
						$checked = ((is_array($this->fields_arr['comment_ids'])) && (in_array($row[$this->COMMENT_TABLE_WHERE_CLAUSE], $this->fields_arr['comment_ids'])))?"checked":'';
						$comment_list_arr[$inc]['tr_class']   = $this->getCSSRowClass();
						$comment_list_arr[$inc]['comment_id']        = $row[$this->COMMENT_TABLE_WHERE_CLAUSE];
						$this->playlist_comment_ids[$inc]				= $row[$this->COMMENT_TABLE_WHERE_CLAUSE];

						$comment_list_arr[$inc]['comment_chk_value'] = $checked;
						$comment_list_arr[$inc]['comment_title'] = wordWrap_mb_ManualWithSpace($row[$this->MODULE_RETURN_FIELD_TITLE], $this->CFG['admin']['musics']['list_title_length'], $this->CFG['admin']['musics']['list_title_total_length']);
						$comment_list_arr[$inc]['module_view_link'] = getUrl('viewplaylist', '?playlist_id='.$row[$this->MODULE_TABLE_WHERE_CLAUSE].'&title='.$this->changeTitle($row[$this->MODULE_RETURN_FIELD_TITLE]), $row[$this->MODULE_TABLE_WHERE_CLAUSE].'/'.$this->changeTitle($row[$this->MODULE_RETURN_FIELD_TITLE]).'/', '', 'music');
						$comment_list_arr[$inc]['member_profile_url'] = getMemberProfileUrl($row['comment_user_id'], $this->UserDetails[$row['comment_user_id']]['user_name']);
						$comment_list_arr[$inc]['user_details']       = $this->UserDetails[$row['comment_user_id']]['user_name'];
						$comment_list_arr[$inc]['date_added'] = $row['date_added'];
						$comment_list_arr[$inc]['comment']    = wordWrap_mb_ManualWithSpace($row['comment'], $this->CFG['admin']['musics']['member_music_comments_length'], $this->CFG['admin']['musics']['member_music_comments_total_length']);
						$comment_list_arr[$inc]['viewcomment_url'] = getUrl('viewplaylistcomments', '?comment_id='.$row['playlist_comment_id'], '?comment_id='.$row['playlist_comment_id'], '', 'music');
						$comment_list_arr[$inc]['comment_status'] = $row['comment_status'];
						$inc++;
					}
				return $comment_list_arr;
			}

		/**
		 * ManagePlaylistComments::activateComments()
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
//<<<<<-------------- Class musicPlaylistcomment begins ---------------//
//-------------------- Code begins -------------->>>>>//
$ManagePlaylistComments = new ManagePlaylistComments();
if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$ManagePlaylistComments->setPageBlockNames(array('comments_form'));
$ManagePlaylistComments->setFormField('comment_ids', array());
$ManagePlaylistComments->setFormField('comment_id', '');
$ManagePlaylistComments->setFormField('act', '');
$ManagePlaylistComments->setFormField('module', '');
$ManagePlaylistComments->setFormField('comment_status', '');
$ManagePlaylistComments->setFormField('slno', '1');
$moduleName = 'music';
$commentIds = '';
$ManagePlaylistComments->DefaultComments();
$ManagePlaylistComments->InitializeManagePlaylistComments('music_playlist', 'music_playlist_comments', 'v', 'vc', 'playlist_comment_id', 'playlist_id', 'playlist_name');
$ManagePlaylistComments->setTableNames(array($CFG['db']['tbl'][$ManagePlaylistComments->COMMENT_MODULE_TABLE].' AS '.$ManagePlaylistComments->COMMENT_MODULE_TABLE_ALIAS.' LEFT JOIN '.$CFG['db']['tbl'][$ManagePlaylistComments->MODULE_TABLE].' AS '.$ManagePlaylistComments->MODULE_TABLE_ALIAS.' ON '.$ManagePlaylistComments->MODULE_TABLE_ALIAS.'.'.$ManagePlaylistComments->MODULE_TABLE_WHERE_CLAUSE.'='.$ManagePlaylistComments->COMMENT_MODULE_TABLE_ALIAS.'.'.$ManagePlaylistComments->MODULE_TABLE_WHERE_CLAUSE, $CFG['db']['tbl']['users'].' as u'));
$ManagePlaylistComments->setReturnColumns(array($ManagePlaylistComments->COMMENT_MODULE_TABLE_ALIAS.'.'.$ManagePlaylistComments->COMMENT_TABLE_WHERE_CLAUSE,$ManagePlaylistComments->COMMENT_MODULE_TABLE_ALIAS.'.comment_user_id',$ManagePlaylistComments->COMMENT_MODULE_TABLE_ALIAS.'.'.$ManagePlaylistComments->MODULE_TABLE_WHERE_CLAUSE, $ManagePlaylistComments->COMMENT_MODULE_TABLE_ALIAS.'.comment', $ManagePlaylistComments->MODULE_TABLE_ALIAS.'.'.$ManagePlaylistComments->MODULE_RETURN_FIELD_TITLE, 'DATE_FORMAT('.$ManagePlaylistComments->COMMENT_MODULE_TABLE_ALIAS.'.date_added,\''.$CFG['format']['date'].'\') as date_added', $ManagePlaylistComments->COMMENT_MODULE_TABLE_ALIAS.'.'.$ManagePlaylistComments->MODULE_RETURN_COMMENT_STATUS));
$ManagePlaylistComments->sanitizeFormInputs($_REQUEST);
$ManagePlaylistComments->setAllPageBlocksHide();
$ManagePlaylistComments->setPageBlockShow('comments_form');
if($ManagePlaylistComments->isFormPOSTed($_POST, 'yes'))
	{
		if($ManagePlaylistComments->getFormField('act')=='delete')
			{
				$ManagePlaylistComments->deletePlaylistComments($ManagePlaylistComments->getFormField('comment_id'));
				$ManagePlaylistComments->setCommonSuccessMsg($LANG['manageplaylistcomments_success_delete']);
				$ManagePlaylistComments->setPageBlockShow('block_msg_form_success');
			}
		if($ManagePlaylistComments->getFormField('act')=='activate')
			{
				$ManagePlaylistComments->activateComments();
				$ManagePlaylistComments->setCommonSuccessMsg($LANG['manageplaylistcomments_success_activate']);
				$ManagePlaylistComments->setPageBlockShow('block_msg_form_success');
			}
	}
if ($ManagePlaylistComments->isShowPageBlock('comments_form'))
    {
		$LANG['manageplaylistcomments_title']       = str_replace('{module}',ucfirst($ManagePlaylistComments->getFormField('module')),$LANG['manageplaylistcomments_title']);
		$LANG['manageplaylistcomments_module']      = str_replace('{module}',ucfirst($ManagePlaylistComments->getFormField('module')),$LANG['manageplaylistcomments_module']);
		$LANG['manageplaylistcomments_tbl_summary'] = str_replace('{module}',ucfirst($ManagePlaylistComments->getFormField('module')),$LANG['manageplaylistcomments_tbl_summary']);
		$ManagePlaylistComments->form_manage_comments['comments_title']       = $LANG['manageplaylistcomments_title'];
		$ManagePlaylistComments->form_manage_comments['comments_module']      = $LANG['manageplaylistcomments_module'];
		$ManagePlaylistComments->form_manage_comments['comments_tbl_summary'] = $LANG['manageplaylistcomments_tbl_summary'];
		$ManagePlaylistComments->buildSelectQuery();
		$ManagePlaylistComments->buildConditionQuery($ManagePlaylistComments->getFormField('comment_status'));
		$ManagePlaylistComments->buildSortQuery();
		$ManagePlaylistComments->buildQuery();
		//$ManagePlaylistComments->printQuery();
		$ManagePlaylistComments->executeQuery();
		$ManagePlaylistComments->form_manage_comments['form_hidden_value'] = array('start');
		$ManagePlaylistComments->form_manage_comments['record_found'] = FALSE;
		if($ManagePlaylistComments->isResultsFound())
			{
				$paging_arr = array('module');
				$ManagePlaylistComments->form_manage_comments['record_found'] = true;
				$smartyObj->assign('smarty_paging_list', $ManagePlaylistComments->populatePageLinksGET($ManagePlaylistComments->getFormField('start'), $paging_arr));
				$ManagePlaylistComments->form_manage_comments['comments_list'] = $ManagePlaylistComments->displayCommentList();
				$commentIds=implode('\',\'',$ManagePlaylistComments->playlist_comment_ids);
				if(empty($ManagePlaylistComments->form_manage_comments['comments_list']))
					{
						$ManagePlaylistComments->form_manage_comments['record_found'] = FALSE;
					}
			}
	}
$ManagePlaylistComments->includeHeader();
setTemplateFolder('members/','music');
$smartyObj->display('managePlaylistComments.tpl');
?>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/functions.js"></script>
<script language="javascript">
var manage_comment_ids = Array('<?php echo $commentIds?>');
function popupWindow(url)
		{
			 window.open (url, "","status=0,toolbar=0,resizable=1,scrollbars=1");
			 return false;
		}
</script>
<?php
$ManagePlaylistComments->includeFooter();
//<<<<<-------------------- Code ends----------------------//
?>