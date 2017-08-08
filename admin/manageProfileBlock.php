<?php
/**
 * This file hadling the profile page blocks
 *
 * There are admin can control the add, edit and delte the blocks from profile page
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/common/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/help.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/admin/manageProfileBlock.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';;
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//--------------class manageProfileBlockHandler--------------->>>//
/**
 * This class hadling the profile page blocks
 *
 * @category	Rayzz
 * @package		Admin
 */
class manageProfileBlockHandler extends ListRecordsHandler
	{
		public $profileblock_details_arr;
		public $profileblock_id;

		/**
		 * manageProfileBlockHandler::buildConditionQuery()
		 * set the condition
		 *
		 * @param string $condition sql condition to display the block list
		 * @return void
		 * @access 	public
		 */
		public function buildConditionQuery($condition='')
			{
				$this->sql_condition = $condition;
			}

		/**
		 * manageProfileBlockHandler::checkSortQuery()
		 * To sort the query
		 *
		 * @param mixed $field which field to sort
		 * @param string $sort how is it sort
		 * @return void
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
		 * manageProfileBlockHandler::isValidProfileBlockId()
		 * To check the profile block id is valid or not
		 *
		 * @param Integer $profileblock_id
		 * @param string $err_tip
		 * @return boolean
		 * @access 	public
		 */
		public function isValidProfileBlockId($profileblock_id, $err_tip='')
			{
				$sql = 'SELECT profile_block_id, module_name , block_name, block_description, order_no, position, display'.
						' FROM '.$this->CFG['db']['tbl']['profile_block'].
						' WHERE profile_block_id = '.$this->dbObj->Param($this->fields_arr[$profileblock_id]);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr[$profileblock_id]));
				if (!$rs)
			        trigger_db_error($this->dbObj);

				if ($this->profileblock_details_arr = $rs->FetchRow())
					{
						if(chkAllowedModule(array(strtolower($this->profileblock_details_arr['module_name']))) or $this->profileblock_details_arr['module_name']=='default')
							{
								return true;
							}
						else
							{
								$this->setCommonErrorMsg($err_tip);
								return false;
							}

				    }

				$this->setCommonErrorMsg($err_tip);
				return false;
			}

		/**
		 * manageProfileBlockHandler::deleteSelectedProfileBlock()
		 * To delete the given selected profile blocks
		 *
		 * @return boolean
		 * @access 	public
		 */
		public function deleteSelectedProfileBlock()
			{
				$profileblock_ids = $this->fields_arr['profile_block_ids'];

				$sql = 'SELECT block_name FROM '.$this->CFG['db']['tbl']['profile_block'].' '.
						'WHERE profile_block_id IN ('.$profileblock_ids.') ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				    trigger_db_error($this->dbObj);
				$block_names_arr=array();
				$inc=0;
				if($rs->PO_RecordCount())
					{
					while($row = $rs->FetchRow())
						{
						 $block_names_arr[$inc]=$row['block_name'];
						 $inc++;
						}
					 $block_names=implode('\',\'',$block_names_arr);
					 $sql = 'DELETE FROM '.$this->CFG['db']['tbl']['users_profile_block'].' '.
						'WHERE block_name IN (\''.$block_names.'\') ';

				     $stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
						    trigger_db_error($this->dbObj);

					}
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['profile_block'].' '.
						'WHERE profile_block_id IN ('.$profileblock_ids.') ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				    trigger_db_error($this->dbObj);

			}

		/**
		 * manageProfileBlockHandler::chkBlockNameExits()
		 * To check block name exist or not
		 *
		 * @param string $profileblock block name to check
		 * @param string $err_tip error message
		 * @return boolean
		 * @access 	public
		 */
		public function chkBlockNameExits($profileblock, $err_tip='')
			{
				$sql = 'SELECT COUNT(block_name) AS count FROM '.$this->CFG['db']['tbl']['profile_block'].' '.
						'WHERE UCASE(block_name) = UCASE('.$this->dbObj->Param($this->fields_arr[$profileblock]).') ';
				$fields_value_arr[] = $this->fields_arr[$profileblock];
				if ($this->fields_arr['profile_block_id'])
					{
						$sql .= ' AND profile_block_id != '.$this->dbObj->Param($this->fields_arr['profile_block_id']);
						$fields_value_arr[] = $this->fields_arr['profile_block_id'];
				    }
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($fields_value_arr));
				if (!$rs)
			        trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if(!$row['count'])
					{
						return false;
					}
				$this->fields_err_tip_arr['block_name'] = $err_tip;
				$this->setCommonErrorMsg($err_tip);
				return false;
			}

		/**
		 * manageProfileBlockHandler::createProfileBlock()
		 * To create/update profile block
		 *
		 * @param string $profileblock_table profile block table name
		 * @return boolean
		 * @access 	public
		 */
		public function createProfileBlock($profileblock_table)
			{
				if ($this->fields_arr['profile_block_id'])
					{
					    $sql = 'SELECT block_name FROM '.$profileblock_table.' '.
						'WHERE profile_block_id = '.$this->dbObj->Param('profile_block_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt,array($this->fields_arr['profile_block_id']));
						if (!$rs)
							trigger_db_error($this->dbObj);

						$block_name_old='';
						if($row = $rs->FetchRow())
						  $block_name_old=$row['block_name'];

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_profile_block'].' SET '.
						       'block_name = '.$this->dbObj->Param('block_name_new').' '.
						       'WHERE block_name = '.$this->dbObj->Param('block_name_old');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt,array($this->fields_arr['block_name'],$block_name_old));
						if (!$rs)
							trigger_db_error($this->dbObj);


						$sql = 'UPDATE '.$profileblock_table.' SET '.
								'module_name = '.$this->dbObj->Param('module_name').', '.
								'block_name = '.$this->dbObj->Param('block_name').', '.
								'block_description = '.$this->dbObj->Param('block_description').', '.
								'position = '.$this->dbObj->Param('position').', '.
								'display = '.$this->dbObj->Param('display').' '.
								'WHERE profile_block_id = '.$this->dbObj->Param('profile_block_id');

						$fields_value_arr = array($this->fields_arr['module_name'],
												$this->fields_arr['block_name'],
												$this->fields_arr['block_description'],
												$this->fields_arr['position'],
												$this->fields_arr['display'],
												$this->fields_arr['profile_block_id']);

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
						if (!$rs)
					        trigger_db_error($this->dbObj);

						$this->profile_block_id = $this->fields_arr['profile_block_id'];
						return true;
				    }
				else
					{
						$sql = 'INSERT INTO '.$profileblock_table.' SET '.
						   	   	'user_id = '.$this->dbObj->Param('user_id').', '.
								'module_name = '.$this->dbObj->Param('module_name').', '.
								'block_name = '.$this->dbObj->Param('block_name').', '.
								'block_description = '.$this->dbObj->Param('block_description').', '.
								'position = '.$this->dbObj->Param('position').', '.
								'display = '.$this->dbObj->Param('display').', '.
								'date_added = now()';

						$fields_value_arr = array($this->CFG['user']['user_id'],$this->fields_arr['module_name'],$this->fields_arr['block_name'],
						   	   	   	   	  	   	  $this->fields_arr['block_description'],$this->fields_arr['position'],$this->fields_arr['display']);

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
						if (!$rs)
					        trigger_db_error($this->dbObj);

						$this->profile_block_id = $this->dbObj->Insert_ID();

						$this->UpdateOrderNo($this->profile_block_id);
						return true;
					}
			}

		/**
		 * manageProfileBlockHandler::UpdateOrderNo()
		 * to update the display order no
		 *
		 * @param mixed $profileId profile block id
		 * @return
		 * @access 	public
		 */
		public function UpdateOrderNo($profileId)
			{

			  $order_no=$this->getOrderNO($profileId);
			  $sql='UPDATE '.$this->CFG['db']['tbl']['profile_block'].' SET order_no='.$order_no.'+1 WHERE profile_block_id='.$this->dbObj->Param('profile_block_id');
			  $stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt, array($profileId));
							if (!$rs)
						        trigger_db_error($this->dbObj);

			}

		/**
		 * manageProfileBlockHandler::getOrderNO()
		 *
		 * @param mixed $profileId profile block id to get the display order no
		 * @return int
		 * @access 	public
		 */
		public function getOrderNO($profileId)
			{
			  $sql='SELECT position FROM '.$this->CFG['db']['tbl']['profile_block'].' WHERE profile_block_id='.$this->dbObj->Param('profile_block_id');
			  $stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt, array($profileId));
							if (!$rs)
						        trigger_db_error($this->dbObj);
			  if($row = $rs->FetchRow())
					$position=$row['position'];


			  $sql='SELECT MAX( order_no ) as max_order FROM '.$this->CFG['db']['tbl']['profile_block'].' WHERE position='.$this->dbObj->Param('position');
			  $stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt, array($position));
							if (!$rs)
						        trigger_db_error($this->dbObj);
			  if($row = $rs->FetchRow())
					return $order_no=$row['max_order'];

			}
		/**
		 * manageProfileBlockHandler::showProfileBlock()
		 * To display the profile block list
		 *
		 * @return void
		 * @access 	public
		 */
		public function showProfileBlock()
			{
				global $smartyObj;
				$showProfileBlock_arr = array();
				$inc = 0;
				while($row = $this->fetchResultRecord())
					{
						if(chkAllowedModule(array(strtolower($row['module_name']))) or $row['module_name']=='default')
							{
								$showProfileBlock_arr[$inc]['record']['module_name'] = $row['module_name'];
								$showProfileBlock_arr[$inc]['record']['block_name'] = $row['block_name'];
								$showProfileBlock_arr[$inc]['record']['block_description'] = $row['block_description'];
								$showProfileBlock_arr[$inc]['record']['display'] = $row['display'];
								$showProfileBlock_arr[$inc]['record']['date_added'] = $row['date_added'];
								$showProfileBlock_arr[$inc]['record']['position'] = $row['position'];
								$showProfileBlock_arr[$inc]['record']['profile_block_id'] = $row['profile_block_id'];
								$showProfileBlock_arr[$inc]['checked'] = '';
								if((is_array($this->fields_arr['profile_block_ids'])) && (in_array($row['profile_block_id'], $this->fields_arr['profile_block_ids'])))
									$showProfileBlock_arr[$inc]['checked'] = "CHECKED";
								$inc++;
							}
					}
				$smartyObj->assign('showProfileBlock_arr', $showProfileBlock_arr);
			}

		/**
		 * manageProfileBlockHandler::resetFieldsArray()
		 * to initialize the form fields
		 *
		 * @return
		 * @access 	public
		 */
		public function resetFieldsArray()
			{
				$this->setFormField('module_name', '');
				$this->setFormField('block_name', '');
				$this->setFormField('block_description', '');
				$this->setFormField('position', 'left');
				$this->setFormField('order_no', '');
				$this->setFormField('display', 'Yes');
				$this->setFormField('profile_block_id', '');
				$this->setFormField('profile_block_ids', array());
				$this->setFormField('action', '');
				$this->setFormField('opt', '');
			}

		/**
		 * manageProfileBlockHandler::chkIsEditMode()
		 * To check the page is edit mode or not
		 *
		 * @return boolean
		 * @access 	public
		 */
		public function chkIsEditMode()
			{
				if($this->fields_arr['profile_block_id'])
					return true;
				return false;
			}

		/**
		 * manageProfileBlockHandler::changeStatus()
		 * To change the status
		 *
		 * @param string $status
		 * @return boolean
		 * @access 	public
		 */
		public function changeStatus($status)
			{
				$profileblock_ids = $this->fields_arr['profile_block_ids'];
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['profile_block'].' SET'.
						' display='.$this->dbObj->Param('display').
						' WHERE profile_block_id IN('.$profileblock_ids.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($status));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				return true;
			}

	}
//<<<<<<<--------------class manageProfileBlockHandler---------------//

//--------------------Code begins-------------->>>>>//
$profileblock = new manageProfileBlockHandler();
$profileblock->setPageBlockNames(array('form_create_profile_block', 'form_create_sub_category', 'form_show_profile_block', 'form_show_sub_category', 'form_confirm'));

$profileblock->setAllPageBlocksHide();
//default form fields and values...
$profileblock->resetFieldsArray();

$profileblock->setFormField('prev_numpg',0);//To retain the last numpg
/***********set form field for navigation****/
$profileblock->setFormField('asc', 'profile_block_id');
$profileblock->setFormField('dsc', '');
/*************Start navigation******/
//fetch number of records show in the result--numpg
$condition = '';

//Set tables and fields to return
//$profileblock->setTableNames(array($CFG['db']['tbl']['users_profile_category'].' as gc'));
//$profileblock->setReturnColumns(array('gc.id, gc.title , gc.status,DATE_FORMAT(gc.date_added, \''.$CFG['format']['date'].'\') as date_added'));

$profileblock->setPageBlockShow('form_create_profile_block');

$profileblock->sanitizeFormInputs($_REQUEST);
$CFG['feature']['auto_hide_success_block'] = false;
/*************End navigation******/
if ($profileblock->isFormGETed($_GET, 'profile_block_id'))
	{
		$profileblock->chkIsNotEmpty('profile_block_id', $LANG['common_err_tip_required'])and
			$profileblock->chkIsNumeric('profile_block_id', $LANG['manageprofileblock_err_tip_invalid_profile_block_id'])and
				$profileblock->isValidProfileBlockId('profile_block_id', $LANG['manageprofileblock_err_tip_invalid_profile_block_id']);
		$profileblock->getFormField('start')and
			$profileblock->chkIsNumeric('start', $LANG['common_err_tip_required']);
		if ($profileblock->isValidFormInputs())
			{

				$profileblock->setAllPageBlocksHide();
				$profileblock->setPageBlockShow('form_create_profile_block');
				$profileblock->setPageBlockShow('form_show_profile_block');
				$profileblock->setFormField('profile_block_id', $profileblock->profileblock_details_arr['profile_block_id']);
				$profileblock->setFormField('module_name', stripslashes($profileblock->profileblock_details_arr['module_name']));
				$profileblock->setFormField('block_name', stripslashes($profileblock->profileblock_details_arr['block_name']));
				$profileblock->setFormField('block_description', stripslashes($profileblock->profileblock_details_arr['block_description']));
				$profileblock->setFormField('position', $profileblock->profileblock_details_arr['position']);
				$profileblock->setFormField('display', $profileblock->profileblock_details_arr['display']);

			}
		else
			{
				$profileblock->setAllPageBlocksHide();
				$profileblock->setFormField('start', 0);
				$profileblock->setPageBlockShow('block_msg_form_error');
				$profileblock->setCommonErrorMsg($LANG['common_msg_error_sorry']);
			}
	}
if ($profileblock->isFormPOSTed($_POST, 'confirm_action'))
	{
		if($CFG['admin']['is_demo_site'])
			{
				$profileblock->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
				$profileblock->setPageBlockShow('block_msg_form_success');
				$profileblock->resetFieldsArray();
			}
		else
			{

				$profileblock->chkIsNotEmpty('profile_block_ids', $LANG['common_err_tip_required'])or
					$profileblock->setCommonErrorMsg($LANG['manageprofileblock_err_tip_select_profile_block']);

				if($profileblock->isValidFormInputs())
					{
						switch($profileblock->getFormField('action'))
							{
								case 'Delete':
									$profileblock->deleteSelectedProfileBlock();
									break;

								case 'Enable':
									$LANG['manageprofileblock_success_message'] = $LANG['manageprofileblock_success_enable_msg'];
									$profileblock->changeStatus('Yes');
									break;

								case 'Disable':
									$LANG['manageprofileblock_success_message'] = $LANG['manageprofileblock_success_disable_msg'];
									$profileblock->changeStatus('No');
									break;
							}
					}

				//$profileblock->setAllPageBlocksHide();
				if ($profileblock->isValidFormInputs())
					{
						$profileblock->setCommonSuccessMsg($LANG['manageprofileblock_success_message']);
						$profileblock->setPageBlockShow('block_msg_form_success');
						$profileblock->resetFieldsArray();
					}
				else
					{
						$profileblock->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$profileblock->setPageBlockShow('block_msg_form_error');
					}
			}
	}
else if ($profileblock->isFormPOSTed($_POST, 'profile_block_submit'))
	{
		if($CFG['admin']['is_demo_site'])
			{
				$profileblock->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
				$profileblock->setPageBlockShow('block_msg_form_success');
				$profileblock->resetFieldsArray();
			}
		else
			{

				$profileblock->chkIsNotEmpty('module_name', $LANG['common_err_tip_required']);
				$profileblock->chkIsNotEmpty('block_name', $LANG['common_err_tip_required'])and
					$profileblock->chkBlockNameExits('block_name', $LANG['manageprofileblock_err_tip_alreay_exists']);
				$profileblock->chkIsNotEmpty('position', $LANG['common_err_tip_required']);
				$profileblock->chkIsNotEmpty('display', $LANG['common_err_tip_required']);

				$profileblock->getFormField('profile_block_id')and
					$profileblock->chkIsNotEmpty('profile_block_id', $LANG['common_err_tip_required'])and
						$profileblock->chkIsNumeric('profile_block_id', $LANG['manageprofileblock_err_tip_invalid_profile_block_id'])and
							$profileblock->isValidProfileBlockId('profile_block_id', $LANG['manageprofileblock_err_tip_invalid_profile_block_id']);

				$profileblock->isValidFormInputs()and
					$profileblock->createProfileBlock($CFG['db']['tbl']['profile_block']);

				if ($profileblock->isValidFormInputs())
					{
						if($profileblock->getFormField('profile_block_id'))
							$profileblock->setCommonSuccessMsg($LANG['manageprofileblock_success_edit_message']);
						else
							$profileblock->setCommonSuccessMsg($LANG['manageprofileblock_success_add_message']);

						$profileblock->setPageBlockShow('block_msg_form_success');
						$profileblock->resetFieldsArray();
					}
				else
					{
						$profileblock->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$profileblock->setPageBlockShow('block_msg_form_error');
						$profileblock->setFormField('profile_block_id', $profileblock->profileblock_details_arr['profile_block_id']);
					}
			}
	}
else if($profileblock->isFormPOSTed($_POST, 'category_cancel'))
	{
		$profileblock->resetFieldsArray();
	}

/*************Start navigation******/
if ($profileblock->isShowPageBlock('form_create_profile_block'))
	{
		$profileblock->setTableNames(array($CFG['db']['tbl']['profile_block']));
		$profileblock->setReturnColumns(array('profile_block_id, module_name , block_name, block_description, order_no, position, display, date_added'));
		//Condition of the query
		$condition = '';
		$profileblock->buildSelectQuery();
		$profileblock->buildConditionQuery($condition);
		$profileblock->buildSortQuery();
		$profileblock->checkSortQuery('profile_block_id', 'desc');
		$profileblock->buildQuery();
		//$profileblock->printQuery();
		$profileblock->executeQuery();
		/*************End navigation******/
		$profileblock->setPageBlockShow('form_show_profile_block');
	}

//<<<<--------------------Code Ends----------------------//
$profileblock->hidden_arr1 = array('start');
$profileblock->hidden_arr2 = array('profile_block_id', 'opt');
if ($profileblock->isShowPageBlock('form_create_profile_block'))
	{
		$profileblock->form_create_profile_block['hidden_arr'] = array('profile_block_id', 'start');
	}

if ($profileblock->isShowPageBlock('form_show_profile_block'))
	{
		$profileblock->form_show_profile_block['hidden_arr'] = array('start');
		if($profileblock->isResultsFound())
			{
			   	$profileblock->showProfileBlock();
				$smartyObj->assign('smarty_paging_list', $profileblock->populatePageLinksGET($profileblock->getFormField('start')));
			}
	}
$profileblock->left_navigation_div = 'generalList';
//include the header file
$profileblock->includeHeader();
//--------------------Page block templates begins-------------------->>>>>//
//include the content of the page
setTemplateFolder('admin/' );
$smartyObj->display('manageProfileBlock.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script language="javascript" type="text/javascript">
	var block_arr= new Array('selMsgConfirm', 'selMsgConfirmSub');
</script>
<?php
$profileblock->includeFooter();
?>