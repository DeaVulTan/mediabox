<?php
/**
 * This file is to manage the response of my musics
 *
 * This file is having ManageResponses class to manage the response of my musics
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 **/
require_once('../common/configs/config.inc.php');
$CFG['site']['is_module_page'] = 'video';
$CFG['lang']['include_files'][] = 'languages/%s/video/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/manageVideoResponses.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoHandler.lib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require($CFG['site']['project_path'].'common/application_top.inc.php');

/**
 * ManageResponses for audio, video, photo, video and games. User can change the status and the delete the unwanted responses.
 *
 * @category	rayzz
 * @package		Members
 **/
class ManageResponses extends videoHandler
	{


		/**
		 * ManageResponses::buildConditionQuery()
		 * Build the sql condition for query.
		 *
		 * @param string $connebtStatus
		 * @return string
		 * @access public
		 **/
		public function buildConditionQuery()
			{
				$this->sql_condition = ' v.video_id = video_responses_video_id AND video_responses_video_id != vr.video_id AND u.user_id = vr.responder_id AND u.usr_status=\'Ok\' AND v.user_id='.$this->CFG['user']['user_id'];
				if($this->fields_arr['comment_status'])
				{
						$this->sql_condition .= ' AND video_responses_status=\''.$this->fields_arr['comment_status'].'\'';
				}
			}

		/**
		 * ManageResponses::buildSortQuery()
		 * Set the sort by field
		 *
		 * @return string
		 * @access public
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = 'v.date_added DESC';
			}

		/**
		 * ManageResponses::displayResponseList()
		 * To dispaly the responses
		 *
		 * @return array
		 * @access public
		 */
		public function displayResponseList()
			{

				$fields_list = array('user_name', 'sex', 'icon_id', 'icon_type');
				$response_list_arr = array();
				$inc = 0;
				$videos_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['videos']['folder'] . '/' . $this->CFG['admin']['videos']['thumbnail_folder'] . '/';
				while($row = $this->fetchResultRecord())
				    {
						$sql = 'SELECT v.s_width,v.s_height,v.video_id as org_video_id, v.video_title as org_video_title,'.
								' v.video_server_url as org_video_server_url, v.is_external_embed_video as org_is_external_embed_video,'.
								' v.embed_video_image_ext as org_embed_video_image_ext '.
								' FROM '.$this->CFG['db']['tbl']['video'].' AS v, '.$this->CFG['db']['tbl']['users'].' as u'.
								' WHERE u.user_id = v.user_id AND u.usr_status=\'Ok\' AND v.video_id = '.$row['video_id'];

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_db_error($this->dbObj);

						$rowSet = $rs->FetchRow();
						//Response Video detail..
						$response_list_arr[$inc]['respose_video_img_src'] =  $row['video_server_url'] . $videos_folder . getVideoImageName($row['video_responses_video_id']) . $this->CFG['admin']['videos']['small_name'] . '.' . $this->CFG['video']['image']['extensions'];
						if ($row['is_external_embed_video'] == 'Yes' && $row['embed_video_image_ext'] == '')
							$response_list_arr[$inc]['respose_video_img_src'] = $this->CFG['site']['video_url'].'design/templates/'.
																					$this->CFG['html']['template']['default'].'/root/images/'.
																						$this->CFG['html']['stylesheet']['screen']['default'].
																						'/no_image/noImageVideo_S.jpg';

						$response_list_arr[$inc]['respose_video_title'] = $row['video_title'];

						$response_list_arr[$inc]['s_width'] = $row['s_width'];
						$response_list_arr[$inc]['s_height'] = $row['s_height'];

						$response_list_arr[$inc]['respose_video_url'] = getUrl('viewvideo', '?video_id='.$row['video_responses_video_id'].'&amp;title='.$this->changeTitle($row['video_title']), $row['video_responses_video_id'].'/'.$this->changeTitle($row['video_title']).'/', '', 'video');

						//Original video detail..
						$response_list_arr[$inc]['original_video_img_src'] =  $rowSet['org_video_server_url'] . $videos_folder . getVideoImageName($rowSet['org_video_id']) . $this->CFG['admin']['videos']['small_name'] . '.' . $this->CFG['video']['image']['extensions'];
						if ($rowSet['org_is_external_embed_video'] == 'Yes' && $rowSet['org_embed_video_image_ext'] == '')
							$response_list_arr[$inc]['original_video_img_src'] = $this->CFG['site']['video_url'].'design/templates/'.
																					$this->CFG['html']['template']['default'].'/root/images/'.
																					 $this->CFG['html']['stylesheet']['screen']['default'].
																					  '/no_image/noImageVideo_S.jpg';

						$response_list_arr[$inc]['original_video_title'] = $rowSet['org_video_title'];
						$response_list_arr[$inc]['original_video_url'] = getUrl('viewvideo', '?video_id='.$rowSet['org_video_id'].'&amp;title='.$this->changeTitle($rowSet['org_video_title']), $rowSet['org_video_id'].'/'.$this->changeTitle($rowSet['org_video_title']).'/', '', 'video');

						//Response user detail..
						$response_list_arr[$inc]['response_user_name'] = $row['user_name'];
						$response_list_arr[$inc]['response_user_url'] = getMemberProfileUrl($row['responder_id'], $row['user_name']);

						$response_list_arr[$inc]['video_responses_status'] = $row['video_responses_status'];
						$response_list_arr[$inc]['response_id'] = $row['video_responses_id'];
						$response_list_arr[$inc]['response_date_added'] = $row['date_added'];
						$inc++;
					}
				return $response_list_arr;
			}

		/**
		 * ManageResponses::deleteResponses()
		 * To delete responses
		 *
		 * @return boolean
		 * @access public
		 */
		public function deleteResponses()
			{
				$response_ids = $this->fields_arr['response_ids'];
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['video_responses'].' WHERE video_responses_id IN('.$response_ids.')';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array());
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}

		/**
		 * ManageResponses::responseChangeStatus()
		 *
		 * @param mixed $status
		 * @return
		 */
		public function responseChangeStatus($status)
			{
				$response_ids = $this->fields_arr['response_ids'];
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_responses'].' SET video_responses_status = \''.$status.'\' '.
						'WHERE video_responses_id IN ('.$response_ids.')' ;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				return true;
			}


	}
//<<<<<-------------- Class MusicUpload begins ---------------//
//-------------------- Code begins -------------->>>>>//
$ManageResponses = new ManageResponses();
if(!chkAllowedModule(array('video')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$ManageResponses->setPageBlockNames(array('responses_form'));
$ManageResponses->setFormField('response_id', '');
$ManageResponses->setFormField('action', '');
$ManageResponses->setFormField('comment_status', '');
$ManageResponses->setFormField('module', 'video');
$ManageResponses->setFormField('response_status', '');
$ManageResponses->setFormField('slno', '1');
$ManageResponses->setFormField('response_ids', '');
$moduleName = 'video';
$ManageResponses->setTableNames(array($CFG['db']['tbl']['video_responses'].' AS vr , '.$CFG['db']['tbl']['video'].' AS v  , '.$CFG['db']['tbl']['users'].' AS u '));
$ManageResponses->setReturnColumns(array('vr.video_responses_video_id', 'vr.video_responses_id', 'vr.video_id', 'vr.video_responses_status', 'vr.responder_id', 'DATE_FORMAT(vr.date_added,\''.$CFG['format']['date'].'\') as date_added', 'u.user_name', 'v.video_title', 'v.video_server_url', 'v.is_external_embed_video', 'v.embed_video_image_ext','v.s_width','v.s_height'));
$ManageResponses->sanitizeFormInputs($_REQUEST);
$ManageResponses->setAllPageBlocksHide();
$ManageResponses->setPageBlockShow('responses_form');
if($ManageResponses->isFormPOSTed($_POST, 'action'))
	{
		switch($ManageResponses->getFormField('action'))
			{
				case 'activate':
					$ManageResponses->responseChangeStatus('Yes');
					$ManageResponses->setCommonSuccessMsg($LANG['manage_response_success_activate']);
					$ManageResponses->setPageBlockShow('block_msg_form_success');
				break;

				case 'inactive':
					$ManageResponses->responseChangeStatus('No');
					$ManageResponses->setCommonSuccessMsg($LANG['manage_response_success_inactivate']);
					$ManageResponses->setPageBlockShow('block_msg_form_success');
				break;

				case 'delete':
					$ManageResponses->deleteResponses();
					$ManageResponses->setCommonErrorMsg($LANG['manage_response_success_delete']);
					$ManageResponses->setPageBlockShow('block_msg_form_error');
				break;
			}
	}
if ($ManageResponses->isShowPageBlock('responses_form'))
    {
		$LANG['manage_response_title']       = str_replace('{module}',ucfirst($ManageResponses->getFormField('module')),$LANG['manage_response_title']);
		$LANG['manage_response_module']      = str_replace('{module}',ucfirst($ManageResponses->getFormField('module')),$LANG['manage_response_module']);
		$LANG['manage_response_tbl_summary'] = str_replace('{module}',ucfirst($ManageResponses->getFormField('module')),$LANG['manage_response_tbl_summary']);
		$ManageResponses->form_manage_responses['responses_title']       = $LANG['manage_response_title'];
		$ManageResponses->form_manage_responses['responses_module']      = $LANG['manage_response_module'];
		$ManageResponses->form_manage_responses['responses_tbl_summary'] = $LANG['manage_response_tbl_summary'];
		$ManageResponses->buildSelectQuery();
		$ManageResponses->buildConditionQuery();
		$ManageResponses->buildSortQuery();
		$ManageResponses->buildQuery();
		//$ManageResponses->printQuery();
		$ManageResponses->executeQuery();
		$ManageResponses->form_manage_responses['form_hidden_value'] = array('start');
		$ManageResponses->form_manage_responses['record_found'] = FALSE;
		if($ManageResponses->isResultsFound())
			{
				$paging_arr = array('module');
				$ManageResponses->form_manage_responses['record_found'] = true;
				$smartyObj->assign('smarty_paging_list', $ManageResponses->populatePageLinksGET($ManageResponses->getFormField('start'), $paging_arr));
				$ManageResponses->form_manage_responses['responses_list'] = $ManageResponses->displayResponseList();
				$ManageResponses->hidden_arr = array('start');
				$smartyObj->assign('smarty_paging_list', $ManageResponses->populatePageLinksGET($ManageResponses->getFormField('start')));
			}
	}
$ManageResponses->includeHeader();
setTemplateFolder('members/', 'video');
$smartyObj->display('manageVideoResponses.tpl');
?>
<script language="javascript">
	var block_arr= new Array('selMsgConfirm');
	var replace_url = '<?php echo $CFG['site']['url'];?>login.php';
	var please_select_action = '<?php echo $LANG['err_tip_select_action'];?>';
	var confirm_message = '';
	function getAction()
		{
			var act_value = document.responsesForm.action.value;
			if(act_value)
				{
					switch (act_value)
						{
							case 'delete':
								confirm_message = '<?php echo $LANG['manage_response_delete_confirm_message'];?>';
								break;
							case 'activate':
								confirm_message = '<?php echo $LANG['manage_response_active_confirm_message'];?>';
								break;
							case 'inactive':
								confirm_message = '<?php echo $LANG['manage_response_inactive_confirm_message'];?>';
								break;
						}
					$Jq('#confirmMessage').html(confirm_message);
					document.msgConfirmform.action.value = act_value;
					Confirmation('selMsgConfirm', 'msgConfirmform', Array('response_ids'), Array(multiCheckValue), Array('value'),'selFormForums');
				}
				else
					alert_manual(please_select_action);
		}
</script>
<?php
$ManageResponses->includeFooter();
//<<<<<-------------------- Code ends----------------------//
?>