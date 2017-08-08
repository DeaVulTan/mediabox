<?php
/**
 * This file is use for manage user type
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/userType.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['admin']['calendar_page'] = true;
require($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class UserTypeHandler begins -------------------->>>>>//
/**
 * UserTypeHandler
 * This class is use for manage user type
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class UserTypeHandler extends ListRecordsHandler
	{
		/**
		 * UserTypeHandler::storeUserType()
		 * To add or update user type
		 *
		 * @return 	boolean
		 * @access 	public
		 */
		public function storeUserType()
			{
				$selected_user_actions = array();
				if ($this->user_actions)
					{
						foreach($this->user_actions as $action_key => $action){
							switch($action['action_type']){
								case 'checkbox':
									foreach($action['action_values'] as $action_value){
										$selected_user_actions[$action['action_name']][$action_value] = $this->fields_arr[$action['action_name'].'_'.$action_value];
									}
									break;
								case 'radio':
									$selected_user_actions[$action['action_name']] = $this->fields_arr[$action['action_name']];
									break;
								case 'textbox':
									//Need to do validation
									$selected_user_actions[$action['action_name']] = $this->fields_arr[$action['action_name']];
									break;
							} // switch
						}
					}
				//serialize $selected_user_actions array
				$serialize_user_actions = serialize($selected_user_actions);

				if($this->fields_arr['type_id'])
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['user_type_settings'].
								' SET type_name = '.$this->dbObj->Param('type_name').
								', type_actions = '.$this->dbObj->Param('type_actions').
								', type_status = '.$this->dbObj->Param('type_status').
								' WHERE type_id = '.$this->dbObj->Param('type_id');
						$field_values  = array($this->fields_arr['type_name'], $serialize_user_actions, $this->fields_arr['type_status'],
												$this->fields_arr['type_id']);
					}
				else
					{
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['user_type_settings'].
								' SET type_name = '.$this->dbObj->Param('type_name').
								', type_actions = '.$this->dbObj->Param('type_actions').
								', type_status = '.$this->dbObj->Param('type_status').
								', type_added_date = NOW()';
						$field_values  = array($this->fields_arr['type_name'], $serialize_user_actions, $this->fields_arr['type_status']);
					}
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $field_values);
				if (!$rs)
					trigger_db_error($this->dbObj);
				return true;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function checkUserTypeNotExists($field_name, $err_tip)
			{
				if($this->fields_arr['type_id'])
					{
						$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['user_type_settings'].
								' WHERE type_name = '.$this->dbObj->Param($this->fields_arr['type_name']).
								' AND type_id != '.$this->dbObj->Param($this->fields_arr['type_id']);
						$field_values = array($this->fields_arr['type_name'], $this->fields_arr['type_id']);
					}
				else
					{
						$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['user_type_settings'].
								' WHERE type_name = '.$this->dbObj->Param($this->fields_arr['type_name']);
						$field_values = array($this->fields_arr['type_name']);
					}
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $field_values);
				if (!$rs)
					    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
					{
						$this->fields_err_tip_arr[$field_name] = $err_tip;
						return false;
					}
				return true;
			}

		/**
		 * UserTypeHandler::userTypeChangeStatus()
		 * To update the user type status
		 *
		 * @param string $status user type status to update
		 * @return 	boolean
		 * @access 	public
		 */
		public function userTypeChangeStatus($status)
			{
				$type_ids = $this->fields_arr['type_ids'];
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['user_type_settings'].
						' SET type_status = '.$this->dbObj->Param($status).
						' WHERE type_id IN ('.$type_ids.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($status));
				if (!$rs)
					trigger_db_error($this->dbObj);
				return true;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function updateDefaultUserType()
			{
				$type_ids = $this->fields_arr['type_ids'];
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['user_type_settings'].
						' SET default_type = \'No\''.
						' WHERE type_id NOT IN ('.$type_ids.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['user_type_settings'].
						' SET default_type = \'Yes\''.
						' WHERE type_id IN ('.$type_ids.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);
				return true;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function checkUserTypeUsed()
			{
				$type_ids = $this->fields_arr['type_ids'];
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE usr_type IN ('.$type_ids.')';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					    trigger_db_error($this->dbObj);

				if (!$rs->PO_RecordCount())
					{
						return true;
					}
				return false;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function deleteUserType()
			{
				$type_ids = $this->fields_arr['type_ids'];
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['user_type_settings'].
						' WHERE type_id IN ('.$type_ids.')';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					    trigger_db_error($this->dbObj);
			}

		/**
		 * UserTypeHandler::showUserTypes()
		 * To populate the user type list
		 *
		 * @return 	array
		 * @access 	public
		 */
		public function showUserTypes()
			{
				$usertype_details = array();
				$inc = 0;
				$usertype_details['record_count'] = 0;
				$usertype_details['row'] = array();
				$count = 1;
				while($row = $this->fetchResultRecord())
					{
						$usertype_details['record_count'] = 1;
						$usertype_details['row'][$inc]['record'] = $row;
						$usertype_details['row'][$inc]['edit_url'] = 'userType.php?type_id='.$row['type_id'].'&amp;action=edit';
						$usertype_details['row'][$inc]['permission_url'] = 'userType.php?type_id='.$row['type_id'].'&amp;action=permission';
						$usertype_details['row'][$inc]['inc'] = $count++;
	   				    $inc++;
					}
				return $usertype_details;
			}

		/**
		 * UserTypeHandler::selectUserTypeDetail()
		 * To select user type details to edit
		 *
		 * @return 	boolean
		 * @access 	public
		 */
		public function selectUserTypeDetail()
			{
				$sql = 'SELECT type_id, type_name, type_actions, type_status, default_type, type_total_used'.
						' FROM '.$this->CFG['db']['tbl']['user_type_settings'].
						' WHERE type_id = '.$this->dbObj->Param('type_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['type_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if(!empty($row))
					{
						$this->setFormField('type_id', $row['type_id']);
						$this->setFormField('type_name', $row['type_name']);
						$this->setFormField('type_status', $row['type_status']);
						$this->setFormField('default_type', $row['default_type']);
						$this->setFormField('type_total_used', $row['type_total_used']);
						//Unserialize selected user actions
						$unserialize_user_actions = unserialize($row['type_actions']);
						if ($unserialize_user_actions)
							{
								//Set user actions in form fields
								foreach($unserialize_user_actions as $action => $value){
									if (is_array($value))
										{
											foreach($value as $sub_action => $sub_value){
												$this->fields_arr[$action.'_'.$sub_action] = $sub_value;
											}
										}
									else
										{
											$this->fields_arr[$action] = $value;
										}
								}
							}
						return true;
					}
				return false;
			}

		/**
		 * UserTypeHandler::buildConditionQuery()
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
		 * UserTypeHandler::buildConditionQuery()
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

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function getUsersAction()
			{
				$sql = 'SELECT action_id, action_name, action_type, action_values, action_default'.
						' FROM '.$this->CFG['db']['tbl']['user_actions'].
						' WHERE action_status = \'Active\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					    trigger_db_error($this->dbObj);

				$this->user_actions = array();
				if ($rs->PO_RecordCount())
					{
						while ($row = $rs->FetchRow())
							{
								if ($row['action_values'])
									$row['action_values'] = explode(', ', $row['action_values']);
								if (strpos($row['action_default'], ','))
									$row['action_default'] = explode(', ', $row['action_default']);

								$default_value = ($this->fields_arr['action'] == 'add')?true:false;

								switch($row['action_type']){
									case 'checkbox':
										$row['action_heading_lang'] = isset($this->LANG[$row['action_name']])?$this->LANG[$row['action_name']]:$row['action_name'];
										foreach($row['action_values'] as $action_value){
											$this->fields_arr[$row['action_name'].'_'.$action_value] = '';
											$row['element_id'][] = $row['action_name'].'_'.$action_value;
											$row['action_lang'][] = ($this->LANG[$row['action_name'].'_'.strtolower($action_value)])?$this->LANG[$row['action_name'].'_'.strtolower($action_value)]:$row['action_name'].' '.strtolower($action_value);
											if (in_array($action_value, $row['action_default']) AND $default_value)
												$this->fields_arr[$row['action_name'].'_'.$action_value] = $action_value;
										}
										break;
									case 'radio':
										$this->fields_arr[$row['action_name']] = ($default_value)?$row['action_default']:'';
										$row['action_heading_lang'] = isset($this->LANG[$row['action_name']])?$this->LANG[$row['action_name']]:$row['action_name'];
										foreach($row['action_values'] as $action_value){
											$row['element_id'][] = $row['action_name'].'_'.$action_value;
											$row['action_lang'][] = ($this->LANG[$row['action_name'].'_'.strtolower($action_value)])?$this->LANG[$row['action_name'].'_'.strtolower($action_value)]:$row['action_name'].' '.strtolower($action_value);
										}
										break;
									case 'textbox':
										$this->fields_arr[$row['action_name']] = ($default_value)?$row['action_default']:'';
										$row['element_id'] = $row['action_name'];
										$row['action_lang'] = isset($this->LANG[$row['action_name']])?$this->LANG[$row['action_name']]:$row['action_name'];
										break;
								} // switch

								$this->user_actions[] = $row;
							}
					}
			}

		/**
		 * UserTypeHandler::getUserTypeUsedCount()
		 *
		 * @param mixed $type_id
		 * @return
		 */
		public function getUserTypeUsedCount($type_id)
			{
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE usr_type = '.$this->dbObj->Param($type_id);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($type_id));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				return $rs->PO_RecordCount();
			}
	}
//<<<<<---------------class UserTypeHandler ends -------------///
//--------------------Code begins-------------->>>>>//
$usertype = new UserTypeHandler();
$usertype->setPageBlockNames(array('usertype_form', 'usertype_list'));
$usertype->setAllPageBlocksHide();

$usertype->numpg = $CFG['data_tbl']['numpg'];
$usertype->setFormField('start', 0);
$usertype->setFormField('numpg', $CFG['data_tbl']['numpg']);

$usertype->setFormField('action','');
$usertype->setFormField('type_id', '');
$usertype->setFormField('type_name','');
$usertype->setFormField('type_status', 'Active');
$usertype->setFormField('default_type', 'Yes');
$usertype->setFormField('type_added_date','');
$usertype->setFormField('type_total_used','');
$usertype->setFormField('type_ids','');

$usertype->sanitizeFormInputs($_REQUEST);
//Populate available user actions and setFormFields for user actions
if(in_array($usertype->getFormField('action'), array('add', 'edit')) OR $usertype->isFormPOSTed($_POST, 'usertype_submit'))
	{
		$usertype->getUsersAction();
	}
//Sanitize again to get the user actions fields
$usertype->sanitizeFormInputs($_REQUEST);

$condition = '';
$usertype->setTableNames(array($CFG['db']['tbl']['user_type_settings'].' as ut'));
$usertype->setReturnColumns(array('ut.type_id', 'ut.type_name', 'ut.type_added_date', 'ut.type_status', 'ut.default_type', 'ut.type_total_used'));
$usertype->setPageBlockShow('usertype_list');
//If action is add
if($usertype->getFormField('action'))
	{
		if($CFG['admin']['is_demo_site'])
			{
				$usertype->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
				$usertype->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				$usertype->setAllPageBlocksHide();
				switch($usertype->getFormField('action'))
					{
						case 'add':
							$usertype->setPageBlockShow('usertype_form');
							break;
						case 'edit':
							if($usertype->selectUserTypeDetail())
								{
									$usertype->setPageBlockShow('usertype_form');
								}
							else
								{
									$usertype->setPageBlockShow('usertype_list');
									$usertype->setCommonErrorMsg($LANG['usertype_invalid']);
									$usertype->setPageBlockShow('block_msg_form_error');
								}
							break;
						case 'Active':
							$usertype->userTypeChangeStatus('Active');
							$usertype->setPageBlockShow('usertype_list');
							$usertype->setCommonSuccessMsg($LANG['usertype_active_successfully']);
							$usertype->setPageBlockShow('block_msg_form_success');
							break;
						case 'Inactive':
							$usertype->userTypeChangeStatus('Inactive');
							$usertype->setPageBlockShow('usertype_list');
							$usertype->setCommonSuccessMsg($LANG['usertype_inactive_successfully']);
							$usertype->setPageBlockShow('block_msg_form_success');
							break;
						case 'Default':
							$usertype->updateDefaultUserType();
							$usertype->setPageBlockShow('usertype_list');
							$usertype->setCommonSuccessMsg($LANG['usertype_set_default_successfully']);
							$usertype->setPageBlockShow('block_msg_form_success');
							break;
						case 'Delete':
							if($usertype->checkUserTypeUsed())
								{
									$usertype->deleteUserType();
									$usertype->setCommonSuccessMsg($LANG['usertype_delete_successfully']);
									$usertype->setPageBlockShow('block_msg_form_success');
								}
							else
								{
									$usertype->setCommonErrorMsg($LANG['usertype_delete_error']);
									$usertype->setPageBlockShow('block_msg_form_error');
								}
							$usertype->setPageBlockShow('usertype_list');
							break;
					}
			}
	}

if ($usertype->isFormPOSTed($_POST, 'usertype_submit'))
	{
		if($CFG['admin']['is_demo_site'])
			{
				$usertype->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
				$usertype->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				$usertype->chkIsNotEmpty('type_name', $LANG['err_tip_compulsory']) AND
					$usertype->checkUserTypeNotExists('type_name', $LANG['usertype_err_tip_user_type_exists_already']);

				if ($usertype->isValidFormInputs())
					{
						$usertype->storeUserType();
						$usertype->setAllPageBlocksHide();
						$usertype->setPageBlockShow('usertype_list');
						if($usertype->getFormField('type_id'))
							$usertype->setCommonSuccessMsg($LANG['usertype_update_successfully']);
						else
							$usertype->setCommonSuccessMsg($LANG['usertype_addded_successfully']);
						$usertype->setPageBlockShow('block_msg_form_success');
					}
				else
					{
						$usertype->setAllPageBlocksHide();
						$usertype->setPageBlockShow('usertype_form');
						$usertype->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$usertype->setPageBlockShow('block_msg_form_error');
					}
			}
	}
if ($usertype->isFormPOSTed($_POST, 'usertype_cancel'))
	{
		Redirect2URL($CFG['site']['url']."admin/userType.php");
	}
$usertype->buildSelectQuery();
$usertype->buildConditionQuery($condition);
$usertype->buildSortQuery();
$usertype->checkSortQuery('ut.type_id', 'DESC');
$usertype->buildQuery();
$usertype->executeQuery();
if ($usertype->isShowPageBlock('usertype_list'))
	{
		$usertype->hidden_arr = array('start');
		$usertype->usertype_list['action_arr'] = array("Active" => $LANG['common_display_active'],
															"Inactive" => $LANG['common_display_inactive'],
															"Delete" => $LANG['common_delete']);
		$usertype->usertype_list['showUserTypes'] = $usertype->showUserTypes();
		$smartyObj->assign('smarty_paging_list', $usertype->populatePageLinksGET($usertype->getFormField('start')));
	}
$usertype->left_navigation_div = 'generalMember';
//<<<<--------------------Code Ends----------------------//
$usertype->includeHeader();
//--------------------Page block templates begins-------------------->>>>>//
//include the content of the page
setTemplateFolder('admin/');
$smartyObj->display('userType.tpl');
?>
<script language="javascript"   type="text/javascript">
	var block_arr= new Array('selMsgConfirm');
	var please_select_action = '<?php echo $LANG['err_tip_select_action'];?>';
	var confirm_message = '';
	var getAction = function()
		{
			if (arguments.length > 0){
				var act_value = arguments[0];
				multiCheckValue = arguments[1];
			} else {
				var act_value = document.selFormUserType.action_val.value;
			}

			if(act_value)
				{
					switch (act_value)
						{
							case 'Delete':
								confirm_message = '<?php echo $LANG['usertype_delete_confirm_message'];?>';
								break;
							case 'Active':
								confirm_message = '<?php echo $LANG['usertype_active_confirm_message'];?>';
								break;
							case 'Inactive':
								confirm_message = '<?php echo $LANG['usertype_inactive_confirm_message'];?>';
								break;
							case 'Default':
								confirm_message = '<?php echo $LANG['usertype_set_default_confirm_message'];?>';
								break;
						}
					$Jq('#confirmMessage').html(confirm_message);
					Confirmation('selMsgConfirm', 'msgConfirmform', Array('type_ids', 'action'), Array(multiCheckValue, act_value), Array('value', 'value'));
				}
			else
				{
					alert_manual(please_select_action);
				}
		}
</script>
<?php
//<<<<<-------------------- Page block templates ends -------------------//
$usertype->includeFooter();
?>