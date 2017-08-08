<?php
/**
 * This file is use for manage productnews
 *
 * This file is having ManageProductnews class manage productnews
 *
 *
 * @category	Rayzz
 * @package		Admin
 *
 **/
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/productNews.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class ManageProductnews begins -------------------->>>>>//
/**
 *
 * @category	rayzz
 * @package		Admin
 **/
class ManageProductnews extends ListRecordsHandler
	{
		/**
		 * ManageProductnews::storeProductnews()
		 *
		 * @return
		 */
		public function storeProductnews()
			{
				if($this->fields_arr['productnews_id'])
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['productnews'].
								' SET description = '.$this->dbObj->Param('description').' '.
								' WHERE productnews_id = '.$this->dbObj->Param('productnews_id');

						$value_array = array($this->fields_arr['description'], $this->fields_arr['productnews_id']);


						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $value_array);
						if (!$rs)
							trigger_db_error($this->dbObj);
					}
				else
					{
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['productnews'].
								' SET description = '.$this->dbObj->Param('description').
								', date_added = NOW()';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['description']));
						if (!$rs)
							trigger_db_error($this->dbObj);
					}
				return true;
			}

		/**
		 * ManageProductnews::productnewsChangeStatus()
		 *
		 * @param mixed $status
		 * @return
		 */
		public function productnewsChangeStatus($status)
			{
				$productnews_ids = $this->fields_arr['productnews_ids'];
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['productnews'].' SET status = \''.$status.'\' '.
						'WHERE productnews_id IN ('.$productnews_ids.')' ;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				return true;
			}

		/**
		 * ManageProductnews::showProductnewsList()
		 *
		 * @return
		 */
		public function showProductnewsList()
			{
				$showProductnewsList_arr = array();
				$inc = 0;
				$showProductnewsList_arr['record_count'] = 0;
				$showProductnewsList_arr['row'] = array();
				$count = 1;
				while($row = $this->fetchResultRecord())
					{
						$showProductnewsList_arr['record_count'] = 1;
						$row['description'] = html_entity_decode($row['description']);
						$showProductnewsList_arr['row'][$inc]['record'] = $row;
						$showProductnewsList_arr['row'][$inc]['edit_url'] = 'productNews.php?productnews_id='.$row['productnews_id'].'&amp;action=edit';
						$showProductnewsList_arr['row'][$inc]['inc'] = $count++;
	   				    $inc++;
					}
				return $showProductnewsList_arr;
			}

		/**
		 * ManageProductnews::selectProductnewsDetail()
		 *
		 * @return
		 */
		public function selectProductnewsDetail()
			{
				$sql = 'SELECT productnews_id, description, date_added FROM '.$this->CFG['db']['tbl']['productnews'].
						' WHERE productnews_id = '.$this->dbObj->Param('productnews_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['productnews_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if(!empty($row))
					{
						$this->setFormField('productnews_id', $row['productnews_id']);
						$this->setFormField('description', $row['description']);
						$this->setFormField('date_added', $row['date_added']);
						return true;
					}
				return false;
			}

		/**
		 * ManageProductnews::chkIsFromDateGreaterThanToDate()
		 *
		 * @param mixed $field_name
		 * @param mixed $form_Date
		 * @param mixed $todate
		 * @param string $err_tip
		 * @return
		 */
		public function chkIsFromDateGreaterThanToDate($field_name, $form_Date, $todate, $err_tip = '')
			{
				if(strtotime($form_Date) > strtotime($todate))
					{
						$this->setFormFieldErrorTip($field_name, $err_tip);
						return false;
					}
				else
					{
						return true;
					}
			}

		/**
		 * set the condition
		 *
		 * @access public
		 * @return void
		 **/
		public function buildConditionQuery($condition='')
			{
				$this->sql_condition = $condition;
			}

		/**
		 * To sort the query
		 *
		 * @access public
		 * @return void
		 **/
		public function checkSortQuery($field, $sort='asc')
			{
				if(!($this->sql_sort))
					{
						$this->sql_sort = $field . ' ' . $sort;
					}
			}
	}
//<<<<<---------------class ManageProductnews ends -------------///
//--------------------Code begins-------------->>>>>//
$productnews = new ManageProductnews();
$productnews->setPageBlockNames(array('productnews_form', 'productnews_list'));
$productnews->setAllPageBlocksHide();
$productnews->numpg = $CFG['data_tbl']['numpg'];
$productnews->setFormField('start', 0);
$productnews->setFormField('numpg', $CFG['data_tbl']['numpg']);
$productnews->setFormField('action','');
$productnews->setFormField('productnews_id', '');
$productnews->setFormField('description','');
$productnews->setFormField('productnews_ids','');
$productnews->sanitizeFormInputs($_REQUEST);
$condition = 'a.status <> \'Delete\'';
$productnews->setTableNames(array($CFG['db']['tbl']['productnews'].' as a'));
$productnews->setReturnColumns(array('a.productnews_id', 'a.description', 'a.date_added', 'a.status'));
$productnews->setPageBlockShow('productnews_list');
//If action is add
if($productnews->getFormField('action'))
	{
		$productnews->setAllPageBlocksHide();
		switch($productnews->getFormField('action'))
			{
				case 'add':
						$productnews->setPageBlockShow('productnews_form');
				break;

				case 'edit':
						if($productnews->selectProductnewsDetail())
							{
								$productnews->setPageBlockShow('productnews_form');
							}
						else
							{
								$productnews->setPageBlockShow('productnews_list');
								$productnews->setCommonErrorMsg($LANG['productnews_invalid']);
								$productnews->setPageBlockShow('block_msg_form_error');
							}
				break;

				case 'Active':
					$productnews->productnewsChangeStatus('Yes');
					$productnews->setPageBlockShow('productnews_list');
					$productnews->setCommonSuccessMsg($LANG['productnews_active_successfully']);
					$productnews->setPageBlockShow('block_msg_form_success');
				break;

				case 'Inactive':
					$productnews->productnewsChangeStatus('No');
					$productnews->setPageBlockShow('productnews_list');
					$productnews->setCommonSuccessMsg($LANG['productnews_inactive_successfully']);
					$productnews->setPageBlockShow('block_msg_form_success');
				break;

				case 'Delete':
					$productnews->productnewsChangeStatus('Delete');
					$productnews->setPageBlockShow('productnews_list');
					$productnews->setCommonSuccessMsg($LANG['productnews_delete_successfully']);
					$productnews->setPageBlockShow('block_msg_form_success');
				break;
			}
	}

if ($productnews->isFormPOSTed($_POST, 'productnews_submit'))
	{
		$productnews->sanitizeFormInputs($_REQUEST);
		$productnews->chkIsNotEmpty('description', $LANG['err_tip_compulsory']);
		if ($productnews->isValidFormInputs())
			{
				$productnews->storeProductnews();
				$productnews->setAllPageBlocksHide();
				$productnews->setPageBlockShow('productnews_list');
				if($productnews->getFormField('productnews_id'))
					$productnews->setCommonSuccessMsg($LANG['productnews_update_successfully']);
				else
					$productnews->setCommonSuccessMsg($LANG['productnews_addded_successfully']);
				$productnews->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				$productnews->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$productnews->setPageBlockShow('block_msg_form_error');
			}
	}
if ($productnews->isFormPOSTed($_POST, 'productnews_cancel'))
	{
		Redirect2URL($CFG['site']['url']."admin/productNews.php");
	}
$productnews->buildSelectQuery();
$productnews->buildConditionQuery($condition);
$productnews->buildSortQuery();
$productnews->checkSortQuery('a.productnews_id', 'DESC');
$productnews->buildQuery();
$productnews->executeQuery();
if ($productnews->isShowPageBlock('productnews_list'))
	{
	//die('I am in list block');
		$productnews->hidden_arr = array('start');
		$productnews->productnews_list['action_arr'] = array("Active" => $LANG['common_display_active'],
															"Inactive" => $LANG['common_display_inactive'],
															"Delete" => $LANG['common_delete']);
		$productnews->productnews_list['showProductnewsList'] = $productnews->showProductnewsList();
		$smartyObj->assign('smarty_paging_list', $productnews->populatePageLinksGET($productnews->getFormField('start')));
	}
//<<<<--------------------Code Ends----------------------//
$productnews->includeHeader();
//--------------------Page block templates begins-------------------->>>>>//
//include the content of the page
setTemplateFolder('admin/');
$smartyObj->display('productNews.tpl');
?>
<script language="javascript" type="text/javascript">
	var block_arr= new Array('selMsgConfirm');
	var please_select_action = '<?php echo $LANG['err_tip_select_action'];?>';
	var confirm_message = '';
	function getAction()
		{
			var act_value = document.selFormProductnews.action.value;
			if(act_value)
				{
					switch (act_value)
						{
							case 'Delete':
								confirm_message = '<?php echo $LANG['productnews_delete_confirm_message'];?>';
								break;
							case 'Active':
								confirm_message = '<?php echo $LANG['productnews_active_confirm_message'];?>';
								break;
							case 'Inactive':
								confirm_message = '<?php echo $LANG['productnews_inactive_confirm_message'];?>';
								break;
						}
					$Jq('#confirmMessage').html(confirm_message);
					document.msgConfirmform.action.value = act_value;
					Confirmation('selMsgConfirm', 'msgConfirmform', Array('productnews_ids'), Array(multiCheckValue), Array('value'),'selFormForums');
				}
				else
					alert_manual(please_select_action);
		}
</script>
<?php
//<<<<<-------------------- Page block templates ends -------------------//
$productnews->includeFooter();
?>