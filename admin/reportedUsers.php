<?php
/**
 * This file hadling reported user details
 *
 * Admin can view, delete and block the users list reported by users
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php');

$CFG['lang']['include_files'][] = 'languages/%s/admin/reportedUsers.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/report_user_list_array.inc.php';

$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';

$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');

//-------------- Class ManageFlaggedVideoMediaHandler ------------>>>
/**
 * This class hadling reported user details
 *
 * @category	Rayzz
 * @package		Admin
 */
class reportedUsers extends ListRecordsHandler
	{
		public $reportedUsers = array();
		public $flaggedContents = array();

		/**
		 * ManageFlagged::buildConditionQuery()
		 * To build condition query
		 *
		 * @return void
		 * access 	public
		 **/
		public function buildConditionQuery()
			{
				$this->sql_condition = 'u.usr_status=\'Ok\' GROUP BY ru.reported_user_id ';
			}

		/**
		 * reportedUsers::buildSortQuery()
		 * To build sort query
		 *
		 * @return void
		 * access 	public
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = 'total_requests DESC';
			}

		/**
		 * reportedUsers::getReportedUsersList()
		 * To get reported users list
		 *
		 * @return void
		 * access 	public
		 */
		public function getReportedUsersList()
			{
				while($row = $this->fetchResultRecord())
					{
						$row['user_details'] = $this->getUserDetail('user_id',$row['reported_user_id']);
						$row['icon'] = getMemberAvatarDetails($row['reported_user_id']);
						$row['memberProfileUrl'] = $this->CFG['site']['url'].'admin/viewProfile.php?user_id='.$row['reported_user_id'] ;
						$row['reports'] = $this->getCountOfRequests($row['reported_user_id']);
						$this->reportedUsers[] = $row;
					}
			}

		/**
		 * reportedUsers::getCountOfRequests()
		 * To get count of request
		 *
		 * @param mixed $report_id reporter id
		 * @return array
		 * access 	public
		 */
		public function getCountOfRequests($reported_user_id)
			{
				$sql = 'SELECT COUNT(1) as total_count, rui.flag FROM '.$this->CFG['db']['tbl']['reported_users'].' AS ru LEFT JOIN '.
						$this->CFG['db']['tbl']['reported_users_info'] . ' AS rui ON ru.report_id = rui.report_id WHERE'.
						' ru.reported_user_id='.$this->dbObj->Param('reported_user_id').
						' GROUP BY flag order by flag';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($reported_user_id));
				if (!$rs)
			        trigger_db_error($this->dbObj);

				$flagArr =  array();

				while($row = $rs->FetchRow())
					{
						if (trim($row['flag']))
							{
								$row['flag'] = $this->LANG_LIST_ARR['report_content'][$row['flag']];
								$flagArr[] = array('flag'=>$row['flag'],'count'=>$row['total_count']);
							}
					}
				return $flagArr;
			}

		/**
		 * reportedUsers::getReportDetails()
		 * To get report details
		 *
		 * @return
		 * access 	public
		 */
		public function getReportDetails()
			{
				global $smartyObj;

				$sql = 'SELECT custom_message, report_id, reporter_id, date_added, reported_user_id'.
						' FROM '.$this->CFG['db']['tbl']['reported_users'].
						' WHERE reported_user_id='.$this->dbObj->Param($this->fields_arr['rid']).
						' ORDER BY report_id DESC';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['rid']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				if( $rs->PO_RecordCount() )
					{
						while($row = $rs->FetchRow())
							{
								if($user_detail = getUserDetail('user_id', $row['reported_user_id']))
									{
										$user_detail['icon'] = getMemberAvatarDetails($row['reported_user_id']);
									}
								else
									{
										continue;
									}
								$reported_user_details = $this->getUserDetail('user_id',$this->fields_arr['rid']);
								$reported_user_details['icon'] = getMemberAvatarDetails($this->fields_arr['rid']);
								$smartyObj->assign('reported_user_details', $reported_user_details);
								$smartyObj->assign('reported_user_link', $this->CFG['site']['url'].'admin/viewProfile.php?user_id='.$this->fields_arr['rid']);

								$reporter_details = $this->getUserDetail('user_id',$row['reporter_id']);
								$reporter_details['icon'] = getMemberAvatarDetails($row['reporter_id']);
								$row['reporter_avatar'] = $reporter_details['icon']['t_url'];
								$row['reporter_avatar_width'] = $reporter_details['icon']['t_width'];
								$row['reporter_avatar_height'] = $reporter_details['icon']['t_height'];
								$row['reporter_name'] = $reporter_details['display_name'];
								$row['reporter_link'] = $this->CFG['site']['url'].'admin/viewProfile.php?user_id='.$row['reporter_id'];

								$row['flag'] = $this->getFlagsFromReportID($row['report_id']);
								$this->flaggedContents[] = $row;
							}
					}
				if ($this->flaggedContents)
					return true;
				return false;
			}

		/**
		 * reportedUsers::getFlagsFromReportID()
		 * To get flag with using report id
		 *
		 * @param  int $report_id report id
		 * @return
		 * access 	public
		 */
		public function getFlagsFromReportID($report_id)
			{
				$flag_array = array();

				$sql = 'SELECT flag FROM '. $this->CFG['db']['tbl']['reported_users_info'].
						' WHERE report_id='.$this->dbObj->Param($report_id);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($report_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				if( $rs->PO_RecordCount() )
					{
						while($row = $rs->FetchRow())
							{
								$row['flag'] = $this->LANG_LIST_ARR['report_content'][$row['flag']];
								$flag_array[] = $row;
							}
					}
				return $flag_array;
			}

		/**
		 * reportedUsers::activateReportedUsers()
		 * To activate reported users
		 *
		 * @return void
		 * access 	public
		 */
		public function activateReportedUsers()
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['reported_users'].' WHERE'.
						' content_id IN('.addslashes($this->fields_arr['reported_user_ids']).')'.
						' AND content_type=\'Video\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				        trigger_db_error($this->dbObj);
			}

		/**
		 * reportedUsers::blockReportedUsers()
		 * To block reported users
		 *
		 * @return void
		 * access 	public
		 */
		public function blockReportedUsers()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET usr_status=\'Locked\''.
						' WHERE user_id IN('.addslashes($this->fields_arr['reported_user_ids']).')';

				$stmt = $this->dbObj->Prepare($sql);

				//echo $stmt;exit;

				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				        trigger_db_error($this->dbObj);

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['reported_users'].' WHERE'.
						' reported_user_id IN('.addslashes($this->fields_arr['reported_user_ids']).')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				        trigger_db_error($this->dbObj);
			}

		/**
		 * reportedUsers::blockReportedUsers()
		 * To delete users
		 *
		 * @return void
		 * access 	public
		 */
		public function deleteUsers()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET usr_status=\'Deleted\''.
						' WHERE user_id IN('.addslashes($this->fields_arr['reported_user_ids']).')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				        trigger_db_error($this->dbObj);

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['reported_users'].' WHERE'.
						' reported_user_id IN('.addslashes($this->fields_arr['reported_user_ids']).')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				        trigger_db_error($this->dbObj);
			}

		/**
		 * reportedUsers::deleteReportedUsers()
		 * Tp delete repoted users
		 *
		 * @return
		 * access 	public
		 */
		public function deleteReportedUsers()
			{
				$sql = 'DELETE FROM ' . $this->CFG['db']['tbl']['reported_users']. ' WHERE reported_user_id IN ('.addslashes($this->fields_arr['reported_user_ids']).')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

			}
	}
//<<<<<-------------- Class ManageFlaggedVideoMediaHandler ---------------//
//-------------------- Code begins -------------->>>>>//
$reportedUsers = new reportedUsers();
$reportedUsers->setPageBlockNames(array('confirmation_block', 'list_reported_users',
											 'block_report_details', 'activate_confirmation_form',
											 'report_confirmation_form', 'delete_confirmation_form'));

//$reportedUsers->action_arr = array('delete'=>$LANG['reportedusers_delete'], 'flag'=>$LANG['reportedusers_flag'], 'activate'=>$LANG['reportedusers_activate']);

$reportedUsers->setFormField('rid', '');
$reportedUsers->setFormField('action', '');
$reportedUsers->setFormField('select_action', '');
$reportedUsers->setFormField('reported_user_ids', array());
/*********** Page Navigation Start *********/
$reportedUsers->setFormField('start', '0');
$reportedUsers->setFormField('numpg', $CFG['data_tbl']['numpg']);
$reportedUsers->setFormField('accessErrorMsg', '');

$reportedUsers->setTableNames(array($CFG['db']['tbl']['reported_users'].' AS ru LEFT JOIN '.$CFG['db']['tbl']['users'].' as u ON u.user_id=ru.reported_user_id'));
$reportedUsers->setReturnColumns(array('ru.report_id','ru.reported_user_id','ru.reporter_id', 'ru.custom_message', 'ru.date_added','COUNT(ru.reported_user_id) AS total_requests'));

/************ page Navigation stop *************/
$reportedUsers->setAllPageBlocksHide();
$reportedUsers->setPageBlockShow('list_reported_users');

$reportedUsers->sanitizeFormInputs($_REQUEST);

$reportedUsers->hiddenArr = array('start');

if($reportedUsers->isFormGETed($_GET, 'action'))
	{
		if($reportedUsers->getFormField('action')=='detail')
			{
				$reportedUsers->setAllPageBlocksHide();
				$reportedUsers->setPageBlockShow('block_report_details');
				$isValidReport = $reportedUsers->getReportDetails();
				if (!$isValidReport)
					{
						$reportedUsers->setCommonErrorMsg($LANG['invalid_report_user_id']);
						$reportedUsers->setPageBlockShow('block_msg_form_error');
					}
			}
	}
if( $reportedUsers->isFormGETed($_POST, 'confirm_action') )
	{
		if($CFG['admin']['is_demo_site'])
			{
				Redirect2URL('reportedUsers.php?accessErrorMsg=you_donthave_access');
				exit();
			}
		switch($reportedUsers->getFormField('select_action'))
			{
				case 'block_user':
					$reportedUsers->blockReportedUsers();
					$reportedUsers->setCommonSuccessMsg($LANG['msg_success_blocked']);
					$reportedUsers->setPageBlockShow('block_msg_form_success');
					break;

				case 'delete_report':
					$reportedUsers->deleteReportedUsers();
					$reportedUsers->setCommonSuccessMsg($LANG['msg_success_delete_report']);
					$reportedUsers->setPageBlockShow('block_msg_form_success');
					break;

				case 'delete_user':
					$reportedUsers->deleteUsers();
					$reportedUsers->setCommonSuccessMsg($LANG['msg_success_delete']);
					$reportedUsers->setPageBlockShow('block_msg_form_success');
					break;
			}
	}

if($reportedUsers->getFormField('accessErrorMsg'))
	{
		$reportedUsers->setPageBlockShow('block_msg_form_error');
		$msg = $reportedUsers->getFormField('accessErrorMsg');
		$reportedUsers->setCommonErrorMsg($LANG[$msg]);
	}

if( $reportedUsers->isShowPageBlock('list_reported_users') )
	{
		/****** navigtion continue*********/
		$reportedUsers->buildSelectQuery();
		$reportedUsers->buildConditionQuery();
		$reportedUsers->buildSortQuery();
		$reportedUsers->buildQuery();
		//$reportedUsers->printQuery();
		$reportedUsers->groupByExecuteQuery();

		if( $reportedUsers->isResultsFound())
			{
				$reportedUsers->getReportedUsersList();
				$smartyObj->assign('smarty_paging_list', $reportedUsers->populatePageLinksPOST($reportedUsers->getFormField('start'), 'reportedListForm'));
			}
		else
			{
				$reportedUsers->setPageBlockHide('list_reported_users');
				$reportedUsers->setPageBlockShow('block_msg_form_error');
				$reportedUsers->setCommonErrorMsg($LANG['reportedusers_no_records_found']);
			}
	}
$reportedUsers->left_navigation_div = 'generalMember';
$reportedUsers->includeHeader();
setTemplateFolder('admin');
$smartyObj->display('reportedUsers.tpl');
?>
	<script language="javascript" type="text/javascript">
		var block_arr= new Array('selMsgConfirm');

		function getAction()
			{
				var confirm_message = '';
				var act_value = document.reportedListForm.select_action.value;
				if(act_value)
					{
						switch (act_value)
							{
								case 'block_user':
									confirm_message = '<?php echo $LANG['confirmation_block_user']; ?>';
									break;
								case 'delete_report':
									confirm_message = '<?php echo $LANG['confirmation_delete_report']; ?>';
									break;
								case 'delete_user':
									confirm_message = '<?php echo $LANG['confirmation_delete_user']; ?>';
									break;
							}
						Confirmation('selMsgConfirm', 'msgConfirmform', Array('reported_user_ids', 'select_action', 'confirmMessage'), Array(multiCheckValue, act_value, confirm_message), Array('value','value','innerHTML'));
					}
				else
					{
						alert_manual('<?php echo $LANG['err_tip_select_action'];?>');
					}
			}
	</script>
<?php
$reportedUsers->includeFooter();
?>