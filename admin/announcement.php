<?php
/**
 * This file is use for manage announcement
 *
 * This file is having ManageAnnouncement class manage announcement
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/announcement.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['admin']['calendar_page'] = true;
require($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class ManageAnnouncement begins -------------------->>>>>//
/**
 * This class is use for manage announcement
 *
 * @category	Rayzz
 * @package		Admin
 */
class ManageAnnouncement extends ListRecordsHandler
	{
		/**
		 * ManageAnnouncement::storeAnnouncement()
		 * To add or update anouncement
		 *
		 * @return 	boolean
		 * @access 	public
		 */
		public function storeAnnouncement()
			{
				if($this->fields_arr['announcement_id'])
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['announcement'].
								' SET description = '.$this->dbObj->Param('description').', '.
								' from_date = '.$this->dbObj->Param('from_date').', '.
								' to_date = '.$this->dbObj->Param('to_date').' '.
								' WHERE announcement_id = '.$this->dbObj->Param('announcement_id');

						$value_array = array($this->fields_arr['description'], $this->fields_arr['from_date'],
												$this->fields_arr['to_date'], $this->fields_arr['announcement_id']);


						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $value_array);
						if (!$rs)
							trigger_db_error($this->dbObj);
					}
				else
					{
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['announcement'].
								' SET description = '.$this->dbObj->Param('description').
								' , from_date = '.$this->dbObj->Param('from_date').
								' , to_date = '.$this->dbObj->Param('to_date').

								', date_added = NOW()';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['description'],
																		$this->fields_arr['from_date'],
																		$this->fields_arr['to_date']));
						if (!$rs)
							trigger_db_error($this->dbObj);
					}
				return true;
			}

		/**
		 * ManageAnnouncement::announcementChangeStatus()
		 * To update the anouncement status
		 *
		 * @param string $status anouncement status to update
		 * @return 	boolean
		 * @access 	public
		 */
		public function announcementChangeStatus($status)
			{
				$announcement_ids = $this->fields_arr['announcement_ids'];
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['announcement'].' SET status = \''.$status.'\' '.
						'WHERE announcement_id IN ('.$announcement_ids.')' ;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				return true;
			}

		/**
		 * ManageAnnouncement::showAnnouncementList()
		 * To populate the anouncement list
		 *
		 * @return 	array
		 * @access 	public
		 */
		public function showAnnouncementList()
			{
				$showAnnouncementList_arr = array();
				$inc = 0;
				$showAnnouncementList_arr['record_count'] = 0;
				$showAnnouncementList_arr['row'] = array();
				$count = 1;
				while($row = $this->fetchResultRecord())
					{
						$showAnnouncementList_arr['record_count'] = 1;
						$row['description'] = html_entity_decode($row['description']);
						$showAnnouncementList_arr['row'][$inc]['record'] = $row;
						$showAnnouncementList_arr['row'][$inc]['edit_url'] = 'announcement.php?announcement_id='.$row['announcement_id'].'&amp;action=edit';
						$showAnnouncementList_arr['row'][$inc]['inc'] = $count++;
	   				    $inc++;
					}
				return $showAnnouncementList_arr;
			}

		/**
		 * ManageAnnouncement::selectAnnouncementDetail()
		 * To select anouncement details to edit
		 *
		 * @return 	boolean
		 * @access 	public
		 */
		public function selectAnnouncementDetail()
			{
				$sql = 'SELECT announcement_id, description, DATE_FORMAT(from_date, \'%Y-%m-%d\') AS from_date, DATE_FORMAT(to_date, \'%Y-%m-%d\') AS to_date, date_added FROM '.$this->CFG['db']['tbl']['announcement'].
						' WHERE announcement_id = '.$this->dbObj->Param('announcement_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['announcement_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if(!empty($row))
					{
						$this->setFormField('announcement_id', $row['announcement_id']);
						$this->setFormField('description', $row['description']);
						$this->setFormField('from_date', $row['from_date']);
						$this->setFormField('to_date', $row['to_date']);
						$this->setFormField('date_added', $row['date_added']);
						return true;
					}
				return false;
			}

		/**
		 * ManageAnnouncement::buildConditionQuery()
		 * To build the condition query
		 *
		 * @param string $condition condition sql query
		 * @return
		 * @access 	public
		 */
		public function buildConditionQuery($condition='')
			{
				$this->sql_condition = $condition;
			}

		/**
		 * ManageAnnouncement::buildConditionQuery()
		 * To set the sort query
		 *
		 * @param string $field sort column name
		 * @param string $sort sort option(asc / desc)
		 * @return
		 * @access 	public
		 */
		public function checkSortQuery($field, $sort='asc')
			{
				if(!($this->sql_sort))
					{
						$this->sql_sort = $field . ' ' . $sort;
					}
			}
	}
//<<<<<---------------class ManageAnnouncement ends -------------///
//--------------------Code begins-------------->>>>>//
$announcement = new ManageAnnouncement();
$announcement->setPageBlockNames(array('announcement_form', 'announcement_list'));
$announcement->setAllPageBlocksHide();
$announcement->numpg = $CFG['data_tbl']['numpg'];
$announcement->setFormField('start', 0);
$announcement->setFormField('numpg', $CFG['data_tbl']['numpg']);
$announcement->setFormField('action','');
$announcement->setFormField('announcement_id', '');
$announcement->setFormField('description','');
$announcement->setFormField('from_date','');
$announcement->setFormField('to_date','');
$announcement->setFormField('announcement_ids','');
$announcement->sanitizeFormInputs($_REQUEST);
$condition = 'a.status <> \'Delete\'';
$announcement->setTableNames(array($CFG['db']['tbl']['announcement'].' as a'));
$announcement->setReturnColumns(array('a.announcement_id', 'a.description', 'a.from_date', 'a.to_date', 'a.date_added', 'a.status'));
$announcement->setPageBlockShow('announcement_list');
//If action is add
if($announcement->getFormField('action'))
	{
		if($CFG['admin']['is_demo_site'])
			{
				$announcement->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
				$announcement->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				$announcement->setAllPageBlocksHide();
				switch($announcement->getFormField('action'))
					{
						case 'add':
								$announcement->setPageBlockShow('announcement_form');
						break;

						case 'edit':
								if($announcement->selectAnnouncementDetail())
									{
										$announcement->setPageBlockShow('announcement_form');
									}
								else
									{
										$announcement->setPageBlockShow('announcement_list');
										$announcement->setCommonErrorMsg($LANG['announcement_invalid']);
										$announcement->setPageBlockShow('block_msg_form_error');
									}
						break;

						case 'Active':
							$announcement->announcementChangeStatus('Yes');
							$announcement->setPageBlockShow('announcement_list');
							$announcement->setCommonSuccessMsg($LANG['announcement_active_successfully']);
							$announcement->setPageBlockShow('block_msg_form_success');
						break;

						case 'Inactive':
							$announcement->announcementChangeStatus('No');
							$announcement->setPageBlockShow('announcement_list');
							$announcement->setCommonSuccessMsg($LANG['announcement_inactive_successfully']);
							$announcement->setPageBlockShow('block_msg_form_success');
						break;

						case 'Delete':
							$announcement->announcementChangeStatus('Delete');
							$announcement->setPageBlockShow('announcement_list');
							$announcement->setCommonSuccessMsg($LANG['announcement_delete_successfully']);
							$announcement->setPageBlockShow('block_msg_form_success');
						break;
					}
			}
	}

if ($announcement->isFormPOSTed($_POST, 'announcement_submit'))
	{
		if($CFG['admin']['is_demo_site'])
			{
				$announcement->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
				$announcement->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				$announcement->sanitizeFormInputs($_REQUEST);
				$announcement->chkIsNotEmpty('description', $LANG['err_tip_compulsory']);

				$announcement->chkIsNotEmpty('from_date', $LANG['common_err_tip_required']) and
					$announcement->chkIsValidDate('from_date',$LANG['common_err_tip_date_invalid']) and
					$announcement->chkIsDateLesserThanNow('from_date', $LANG['common_err_tip_date_invalid']);

				$announcement->chkIsNotEmpty('to_date', $LANG['common_err_tip_required']) and
					$announcement->chkIsValidDate('to_date',$LANG['common_err_tip_date_invalid']) and
					$announcement->chkIsDateLesserThanNow('to_date', $LANG['common_err_tip_date_invalid']);

				$announcement->isValidFormInputs() and $announcement->chkIsFromDateGreaterThanToDate('from_date', $announcement->getFormField('from_date'), $announcement->getFormField('to_date'), $LANG['announcement_invaliddate']);

				if ($announcement->isValidFormInputs())
					{
						$announcement->setFormField('description', stripSpecifiedTag($announcement->getFormField('description'), $CFG['admin']['html_editor']['strip_tags']));
						$announcement->storeAnnouncement();
						$announcement->setAllPageBlocksHide();
						$announcement->setPageBlockShow('announcement_list');
						if($announcement->getFormField('announcement_id'))
							$announcement->setCommonSuccessMsg($LANG['announcement_update_successfully']);
						else
							$announcement->setCommonSuccessMsg($LANG['announcement_addded_successfully']);
						$announcement->setPageBlockShow('block_msg_form_success');
					}
				else
					{
						$announcement->setAllPageBlocksHide();
						$announcement->setPageBlockShow('announcement_form');
						$announcement->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$announcement->setPageBlockShow('block_msg_form_error');
					}
			}
	}
if ($announcement->isFormPOSTed($_POST, 'announcement_cancel'))
	{
		Redirect2URL($CFG['site']['url']."admin/announcement.php");
	}
$announcement->buildSelectQuery();
$announcement->buildConditionQuery($condition);
$announcement->buildSortQuery();
$announcement->checkSortQuery('a.announcement_id', 'DESC');
$announcement->buildQuery();
$announcement->executeQuery();
if ($announcement->isShowPageBlock('announcement_list'))
	{
	//die('I am in list block');
		$announcement->hidden_arr = array('start');
		$announcement->announcement_list['action_arr'] = array("Active" => $LANG['common_display_active'],
															"Inactive" => $LANG['common_display_inactive'],
															"Delete" => $LANG['common_delete']);
		$announcement->announcement_list['showAnnouncementList'] = $announcement->showAnnouncementList();
		$smartyObj->assign('smarty_paging_list', $announcement->populatePageLinksGET($announcement->getFormField('start')));
	}
$announcement->left_navigation_div = 'generalAnnouncement';
//<<<<--------------------Code Ends----------------------//
$CFG['feature']['auto_hide_success_block'] = false;
$calendar_options_arr = array('minDate' => '-0Y -0M -0D',
							  'maxDate'	=> '+2Y'
							 );
$smartyObj->assign('calendar_opts_arr', $calendar_options_arr);
$announcement->includeHeader();
//--------------------Page block templates begins-------------------->>>>>//
//include the content of the page
setTemplateFolder('admin/');
$smartyObj->display('announcement.tpl');
?>
<script language="javascript"   type="text/javascript">
	var block_arr= new Array('selMsgConfirm');
	var please_select_action = '<?php echo $LANG['err_tip_select_action'];?>';
	var confirm_message = '';
	function getAction()
		{
			var act_value = document.selFormAnnouncement.action_val.value;
			if(act_value)
				{
					switch (act_value)
						{
							case 'Delete':
								confirm_message = '<?php echo $LANG['announcement_delete_confirm_message'];?>';
								break;
							case 'Active':
								confirm_message = '<?php echo $LANG['announcement_active_confirm_message'];?>';
								break;
							case 'Inactive':
								confirm_message = '<?php echo $LANG['announcement_inactive_confirm_message'];?>';
								break;
						}
					$Jq('#confirmMessage').html(confirm_message);
					document.msgConfirmform.action.value = act_value;
					Confirmation('selMsgConfirm', 'msgConfirmform', Array('announcement_ids'), Array(multiCheckValue), Array('value'),'selFormForums');
				}
				else
					alert_manual(please_select_action);
		}
</script>
<?php
//<<<<<-------------------- Page block templates ends -------------------//
$announcement->includeFooter();
?>