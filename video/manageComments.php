<?php
/**
 * This file is to manage the comment of my videos
 *
 * This file is having ManageComments class to manage the comment of my videos
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 **/
require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_video.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/manageComments.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoHandler.lib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['site']['is_module_page']='video';
require($CFG['site']['project_path'].'common/application_top.inc.php');

/**
 * ManageComments for audio, video, photo, article and games. User can change the status and the delete the unwanted comments.
 *
 * @category	rayzz
 * @package		Members
 **/
class ManageComments extends VideoHandler
	{
		/**
		 * ManageComments::DefaultComments()
		 * Define the sql fields and their table names
		 *
		 * @access public
		 * @return void
		 */
		public function DefaultComments()
			{
				$this->MODULE_TABLE               = 'video';
				$this->COMMENT_MODULE_TABLE       = 'video_comments';
				$this->MODULE_TABLE_ALIAS         = 'm';
				$this->COMMENT_MODULE_TABLE_ALIAS = 'mc';
				$this->COMMENT_TABLE_WHERE_CLAUSE = 'video_comment_id';
				$this->COMMENT_TABLE_USER_CLAUSE  = 'comment_user_id';
				$this->COMMENT_TABLE_MAIN_ID	  = 'video_comment_main_id';
				$this->MODULE_TABLE_WHERE_CLAUSE  = 'video_id';
				$this->MODULE_RETURN_FIELD_TITLE  = 'video_title';
			}

		/**
		 * ManageComments::InitializeManageComments()
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
		public function InitializeManageComments($MODULE_TABLE='video',	$COMMENT_MODULE_TABLE='video_comments', $MODULE_TABLE_ALIAS='m',$COMMENT_MODULE_TABLE_ALIAS='mc', $COMMENT_TABLE_WHERE_CLAUSE='video_comment_id', $MODULE_TABLE_WHERE_CLAUSE='video_id', $MODULE_RETURN_FIELD_TITLE='video_title')
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
		 * ManageComments::buildConditionQuery()
		 * Build the sql condition for query.
		 *
		 * @param string $connebtStatus
		 * @return string
		 * @access public
		 **/
		public function buildConditionQuery($commentStatus = '')
			{
				if(!empty($commentStatus))
					$this->sql_condition = $this->MODULE_TABLE_ALIAS.'.user_id='.$this->CFG['user']['user_id'].
											' AND '.$this->COMMENT_MODULE_TABLE_ALIAS.'.comment_status="'.$commentStatus.'"'.
												' AND u.usr_status=\'Ok\'';
				else
					$this->sql_condition = $this->MODULE_TABLE_ALIAS.'.user_id='.$this->CFG['user']['user_id'].
											' AND u.usr_status=\'Ok\'';
			}

		/**
		 * ManageComments::buildSortQuery()
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
		 * ManageComments::displayCommentList()
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
				$this->video_comment_ids=array();

				$videos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.
									$this->CFG['admin']['videos']['thumbnail_folder'].'/';

				while($row = $this->fetchResultRecord())
				    {
						if(!isset($this->UserDetails[$row['comment_user_id']]))
							$this->getUserDetail('user_id',$row['comment_user_id'], 'user_name');

						$user_name=$this->getUserDetail('user_id',$row['comment_user_id'], 'user_name');
						$checked = ((is_array($this->fields_arr['comment_ids'])) && (in_array($row[$this->COMMENT_TABLE_WHERE_CLAUSE], $this->fields_arr['comment_ids'])))?"checked":'';
						$comment_list_arr[$inc]['tr_class']   = $this->getCSSRowClass();
						$comment_list_arr[$inc]['comment_status']   =  $row['comment_status'];
						$comment_list_arr[$inc]['comment_id']       = $row[$this->COMMENT_TABLE_WHERE_CLAUSE];
						$this->video_comment_ids[$inc]				= $row[$this->COMMENT_TABLE_WHERE_CLAUSE];
						$comment_list_arr[$inc]['comment_chk_value'] = $checked;
						$comment_list_arr[$inc]['comment_title'] = wordWrap_mb_ManualWithSpace($row[$this->MODULE_RETURN_FIELD_TITLE], $this->CFG['admin']['videos']['list_title_length'], $this->CFG['admin']['videos']['list_title_total_length']);
						$comment_list_arr[$inc]['module_view_link'] = getUrl('viewvideo', '?video_id='.$row[$this->MODULE_TABLE_WHERE_CLAUSE].'&title='.$this->changeTitle($row[$this->MODULE_RETURN_FIELD_TITLE]), $row[$this->MODULE_TABLE_WHERE_CLAUSE].'/'.$this->changeTitle($row[$this->MODULE_RETURN_FIELD_TITLE]).'/', '', 'video');
						$comment_list_arr[$inc]['member_profile_url'] = getMemberProfileUrl($row['comment_user_id'], $user_name);
						$comment_list_arr[$inc]['user_details']       = $user_name;
						$comment_list_arr[$inc]['date_added'] = $row['date_added'];
						$comment_list_arr[$inc]['comment']    = wordWrap_mb_ManualWithSpace($row['comment'], $this->CFG['admin']['videos']['member_video_comments_length'], $this->CFG['admin']['videos']['member_video_comments_total_length']);
						$comment_list_arr[$inc]['viewcomment_url'] = getUrl('viewcomments', '?comment_id='.$row['video_comment_id'], '?comment_id='.$row['video_comment_id'], '', 'video');

						$comment_list_arr[$inc]['respose_video_img_src'] =  $row['video_server_url'].$videos_folder.
																				getVideoImageName($row[$this->MODULE_TABLE_WHERE_CLAUSE]).
																					$this->CFG['admin']['videos']['small_name'].'.'.
																						$this->CFG['video']['image']['extensions'];

						$comment_list_arr[$inc]['disp_image']=DISP_IMAGE($this->CFG['admin']['videos']['small_width'], $this->CFG['admin']['videos']['small_height'], $row['s_width'], $row['s_height']);

						if ($row['is_external_embed_video'] == 'Yes' && $row['embed_video_image_ext'] == '')
							$comment_list_arr[$inc]['respose_video_img_src'] = $this->CFG['site']['video_url'].'design/templates/'.
																					$this->CFG['html']['template']['default'].'/root/images/'.
																						$this->CFG['html']['stylesheet']['screen']['default'].
																						'/no_image/noImageVideo_S.jpg';

						$inc++;
					}
				return $comment_list_arr;
			}

		/**
		 * ManageComments::deleteComments()
		 * To delete comments
		 *
		 * @return boolean
		 * @access public
		 */
		public function deleteComments()
			{
				$comment_id_arr = explode(',',$this->fields_arr['comment_id']);
				//Update total comments to Mod table
				$this->updateTotalCommentInModTable();
				foreach($comment_id_arr as $comment_id)
					{
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl'][$this->COMMENT_MODULE_TABLE].' WHERE '.
									$this->COMMENT_TABLE_WHERE_CLAUSE.' IN('.$this->dbObj->Param('comment_id').')';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($comment_id));
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.
								$this->dbObj->ErrorMsg(), E_USER_ERROR);
					}
			}


		/**
		 * ManageComments::activateComments()
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
						$sql = 'SELECT '.$this->MODULE_TABLE_WHERE_CLAUSE.','.
								$this->COMMENT_TABLE_MAIN_ID.', '.
								$this->COMMENT_TABLE_WHERE_CLAUSE.' FROM '.
								$this->CFG['db']['tbl'][$this->COMMENT_MODULE_TABLE].' WHERE '.
								$this->COMMENT_TABLE_WHERE_CLAUSE.' IN('.$this->dbObj->Param('comment_id').')';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($comment_id));
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.
								$this->dbObj->ErrorMsg(), E_USER_ERROR);

						while($row = $rs->FetchRow())
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl'][$this->COMMENT_MODULE_TABLE].' SET'.
										' comment_status=\'Yes\' WHERE '.$this->COMMENT_TABLE_WHERE_CLAUSE.' ='.
											$this->dbObj->Param($this->COMMENT_TABLE_WHERE_CLAUSE);

								$stmt = $this->dbObj->Prepare($sql);
								$rs1 = $this->dbObj->Execute($stmt, array($row[$this->COMMENT_TABLE_WHERE_CLAUSE]));
							    if (!$rs1)
								    trigger_error($this->dbObj->ErrorNo().' '.
										$this->dbObj->ErrorMsg(), E_USER_ERROR);

								if($this->dbObj->Affected_Rows() && $row[$this->COMMENT_TABLE_MAIN_ID] == 0)
									{
										$sql = 'UPDATE '.$this->CFG['db']['tbl'][$this->MODULE_TABLE ].
												' SET total_comments = total_comments+1'.
												' WHERE '.$this->MODULE_TABLE_WHERE_CLAUSE.'='.
												$this->dbObj->Param($this->MODULE_TABLE_WHERE_CLAUSE);

										$stmt = $this->dbObj->Prepare($sql);
										$rs2 = $this->dbObj->Execute($stmt, array($row[$this->MODULE_TABLE_WHERE_CLAUSE]));
									    if (!$rs2)
										    trigger_error($this->dbObj->ErrorNo().' '.
												$this->dbObj->ErrorMsg(), E_USER_ERROR);
									}
							}
					}
			}

		/**
		 * ManageComments::inActivateComments()
		 *  To Inactivate comments
		 *
		 * @return
		 */
		public function inActivateComments()
			{
				$comment_id_arr = explode(',',$this->fields_arr['comment_id']);
				foreach($comment_id_arr as $comment_id)
					{
						$sql = 'SELECT '.$this->MODULE_TABLE_WHERE_CLAUSE.','.
								$this->COMMENT_TABLE_MAIN_ID.', '.
								$this->COMMENT_TABLE_WHERE_CLAUSE.' FROM '.
								$this->CFG['db']['tbl'][$this->COMMENT_MODULE_TABLE].' WHERE '.
								$this->COMMENT_TABLE_WHERE_CLAUSE.' IN('.$this->dbObj->Param('comment_id').')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($comment_id));
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.
								$this->dbObj->ErrorMsg(), E_USER_ERROR);

						while($row = $rs->FetchRow())
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl'][$this->COMMENT_MODULE_TABLE].' SET'.
										' comment_status=\'No\' WHERE '.$this->COMMENT_TABLE_WHERE_CLAUSE.' ='.
										$this->dbObj->Param($this->COMMENT_TABLE_WHERE_CLAUSE);

								$stmt = $this->dbObj->Prepare($sql);
								$rs1 = $this->dbObj->Execute($stmt, array($row[$this->COMMENT_TABLE_WHERE_CLAUSE]));
							    if (!$rs1)
								    trigger_error($this->dbObj->ErrorNo().' '.
										$this->dbObj->ErrorMsg(), E_USER_ERROR);

								if($this->dbObj->Affected_Rows() && $row[$this->COMMENT_TABLE_MAIN_ID] == 0)
									{
										$sql = 'UPDATE '.$this->CFG['db']['tbl'][$this->MODULE_TABLE ].
												' SET total_comments = total_comments-1'.
												' WHERE '.$this->MODULE_TABLE_WHERE_CLAUSE.'='.
												$this->dbObj->Param($this->MODULE_TABLE_WHERE_CLAUSE);

										$stmt = $this->dbObj->Prepare($sql);
										$rs2 = $this->dbObj->Execute($stmt, array($row[$this->MODULE_TABLE_WHERE_CLAUSE]));
									    if (!$rs2)
										    trigger_error($this->dbObj->ErrorNo().' '.
												$this->dbObj->ErrorMsg(), E_USER_ERROR);
									}
							}
					}
			}
		/**
		 * ManageComments::updateTotalCommentInModTable()
		 *
		 * @return void
		 */
		public function updateTotalCommentInModTable()
			{
				$sql = 'SELECT count(*) as total_mod_comments, '.$this->MODULE_TABLE_WHERE_CLAUSE.','.
						$this->COMMENT_TABLE_MAIN_ID.', '.
						$this->COMMENT_TABLE_WHERE_CLAUSE.' FROM '.
						$this->CFG['db']['tbl'][$this->COMMENT_MODULE_TABLE].' WHERE '.
						$this->COMMENT_TABLE_WHERE_CLAUSE.' IN('.$this->fields_arr['comment_id'].')'.
						' AND '.$this->COMMENT_TABLE_MAIN_ID.'=\'0\''.
						' GROUP BY '.$this->MODULE_TABLE_WHERE_CLAUSE;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				while($row = $rs->FetchRow())
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl'][$this->MODULE_TABLE].
								' SET total_comments = total_comments - '.$row['total_mod_comments'].
								' WHERE '.$this->MODULE_TABLE_WHERE_CLAUSE.'='.
								$this->dbObj->Param('MODULE_TABLE_WHERE_CLAUSE');

						$stmt = $this->dbObj->Prepare($sql);
						$rs1 = $this->dbObj->Execute($stmt, array($row[$this->MODULE_TABLE_WHERE_CLAUSE]));
					    if (!$rs1)
						    trigger_error($this->dbObj->ErrorNo().' '.
								$this->dbObj->ErrorMsg(), E_USER_ERROR);
					}
			}
	}
//<<<<<-------------- Class videoUpload begins ---------------//
//-------------------- Code begins -------------->>>>>//
$ManageComments = new ManageComments();

if(!chkAllowedModule(array('video')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$ManageComments->setPageBlockNames(array('comments_form'));

$ManageComments->setFormField('comment_ids', array());
$ManageComments->setFormField('comment_id', '');
$ManageComments->setFormField('act', '');
$ManageComments->setFormField('module', '');
$ManageComments->setFormField('comment_status', '');
$ManageComments->setFormField('slno', '1');

$moduleName = 'video';
$commentIds='';
$ManageComments->DefaultComments();

$ManageComments->InitializeManageComments('video', 'video_comments', 'v', 'vc', 'video_comment_id', 'video_id', 'video_title');

$ManageComments->setTableNames(array($CFG['db']['tbl'][$ManageComments->COMMENT_MODULE_TABLE].' AS '.$ManageComments->COMMENT_MODULE_TABLE_ALIAS.' LEFT JOIN '.$CFG['db']['tbl'][$ManageComments->MODULE_TABLE].' AS '.$ManageComments->MODULE_TABLE_ALIAS.' ON '.$ManageComments->MODULE_TABLE_ALIAS.'.'.$ManageComments->MODULE_TABLE_WHERE_CLAUSE.'='.$ManageComments->COMMENT_MODULE_TABLE_ALIAS.'.'.$ManageComments->MODULE_TABLE_WHERE_CLAUSE.' JOIN '.$CFG['db']['tbl']['users'].' as u ON '.$ManageComments->COMMENT_MODULE_TABLE_ALIAS.'.'.$ManageComments->COMMENT_TABLE_USER_CLAUSE.'=u.user_id'));
$ManageComments->setReturnColumns(array($ManageComments->COMMENT_MODULE_TABLE_ALIAS.'.'.$ManageComments->COMMENT_TABLE_WHERE_CLAUSE,$ManageComments->COMMENT_MODULE_TABLE_ALIAS.'.comment_user_id',$ManageComments->COMMENT_MODULE_TABLE_ALIAS.'.'.$ManageComments->MODULE_TABLE_WHERE_CLAUSE, $ManageComments->COMMENT_MODULE_TABLE_ALIAS.'.comment', $ManageComments->MODULE_TABLE_ALIAS.'.'.$ManageComments->MODULE_RETURN_FIELD_TITLE, 'DATE_FORMAT('.$ManageComments->COMMENT_MODULE_TABLE_ALIAS.'.date_added,\''.$CFG['format']['date'].'\') as date_added', 'is_external_embed_video', 'embed_video_image_ext', 'video_server_url', 'comment_status','s_width','s_height'));

$ManageComments->sanitizeFormInputs($_REQUEST);

$ManageComments->setAllPageBlocksHide();
$ManageComments->setPageBlockShow('comments_form');

if($ManageComments->isFormPOSTed($_POST, 'yes'))
	{
		if($ManageComments->getFormField('act')=='delete')
			{
				$ManageComments->deleteComments();
				$ManageComments->setCommonErrorMsg($LANG['manage_comment_success_delete']);
				$ManageComments->setPageBlockShow('block_msg_form_error');
			}
		if($ManageComments->getFormField('act')=='activate')
			{
				$ManageComments->activateComments();
				$ManageComments->setCommonSuccessMsg($LANG['manage_comment_success_activate']);
				$ManageComments->setPageBlockShow('block_msg_form_success');
			}
		if($ManageComments->getFormField('act')=='inactivate')
			{
				$ManageComments->inActivateComments();
				$ManageComments->setCommonSuccessMsg($LANG['manage_comment_success_inactivate']);
				$ManageComments->setPageBlockShow('block_msg_form_success');
			}
	}

if ($ManageComments->isShowPageBlock('comments_form'))
    {
		$LANG['manage_comment_title']       = str_replace('{module}',ucfirst($ManageComments->getFormField('module')),$LANG['manage_comment_title']);
		$LANG['manage_comment_module']      = str_replace('{module}',ucfirst($ManageComments->getFormField('module')),$LANG['manage_comment_module']);
		$LANG['manage_comment_tbl_summary'] = str_replace('{module}',ucfirst($ManageComments->getFormField('module')),$LANG['manage_comment_tbl_summary']);
		$ManageComments->form_manage_comments['comments_title']       = $LANG['manage_comment_title'];
		$ManageComments->form_manage_comments['comments_module']      = $LANG['manage_comment_module'];
		$ManageComments->form_manage_comments['comments_tbl_summary'] = $LANG['manage_comment_tbl_summary'];
		$ManageComments->buildSelectQuery();
		$ManageComments->buildConditionQuery($ManageComments->getFormField('comment_status'));
		$ManageComments->buildSortQuery();
		$ManageComments->buildQuery();
		//$ManageComments->printQuery();
		$ManageComments->executeQuery();

		$ManageComments->form_manage_comments['form_hidden_value'] = array('start');
		$ManageComments->form_manage_comments['record_found'] = FALSE;
		if($ManageComments->isResultsFound())
			{
				$paging_arr = array('module');
				$ManageComments->form_manage_comments['record_found'] = true;
				$smartyObj->assign('smarty_paging_list', $ManageComments->populatePageLinksGET($ManageComments->getFormField('start'), $paging_arr));
				$ManageComments->form_manage_comments['comments_list'] = $ManageComments->displayCommentList();
				$commentIds=implode('\',\'',$ManageComments->video_comment_ids);
			}

	}
$ManageComments->includeHeader();
setTemplateFolder('members/','video');
$smartyObj->display('manageComments.tpl');
?>

<script language="javascript">
	var block_arr= new Array('selMsgConfirm');
	var replace_url = '<?php echo $CFG['site']['url'];?>login.php';
	var please_select_action = '<?php echo $LANG['err_tip_select_action'];?>';
	var confirm_message = '';
	function getAction()
		{
			var act_value = document.commendsForm.action.value;
			if(act_value)
				{
					switch (act_value)
						{
							case 'delete':
								confirm_message = '<?php echo $LANG['manage_comment_delete_confirmation'];?>';
								break;
							case 'activate':
								confirm_message = '<?php echo $LANG['manage_comment_activate_confirmation'];?>';
								break;
							case 'inactivate':
								confirm_message = '<?php echo $LANG['manage_comment_inactivate_confirm_message'];?>';
								break;
						}
					$Jq('#selConfirmMsg').html(confirm_message);
					Confirmation('selMsgConfirm', 'confirm_form', Array('comment_id', 'act'), Array(multiCheckValue, act_value), Array('value', 'value'),'selFormForums');
				}
				else
					alert_manual(please_select_action);
		}
</script>
<script language="javascript">
var manage_comment_ids = Array('<?php echo $commentIds?>');
function popupWindow(url)
		{
			 window.open (url, "","status=0,toolbar=0,resizable=1,scrollbars=1");
			 return false;
		}
</script>
<?php
$ManageComments->includeFooter();
//<<<<<-------------------- Code ends----------------------//
?>