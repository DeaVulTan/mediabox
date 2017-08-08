<?php
/**
 * Manage Group Category
 *
 *
 * @category	Rayzz
 * @package		admin
 **/
require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/common/help.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/admin/manageHomePageBlock.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';;
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['site']['is_module_page']='video';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//--------------class managehomePageBlockHandler--------------->>>//
/**
 * @category	Rayzz
 * @package		Admin
 **/
class managehomePageBlockHandler extends ListRecordsHandler
	{
		public $homepageblock_details_arr;
		public $homepage_block_id;

		/**
		 * managehomePageBlockHandler::buildConditionQuery()
		 * set the condition
		 *
		 * @param string $condition
		 * @return void
		 */
		public function buildConditionQuery($condition='')
			{
				$this->sql_condition = $condition;
			}

		/**
		 * managehomePageBlockHandler::checkSortQuery()
		 * To sort the query
		 *
		 * @param mixed $field
		 * @param string $sort
		 * @return void
		 */
		public function checkSortQuery($field, $sort='asc')
			{
				if(!($this->sql_sort))
					{
						$this->sql_sort = $field . ' ' . $sort;
					}
			}
		/**
		 * managehomePageBlockHandler::isValidHomePageBlockId()
		 * To check the article_categroy id is valid or not
		 *
		 * @param Integer $homepage_block_id
		 * @param string $err_tip
		 * @return boolean
		 */
		public function isValidHomePageBlockId($homepage_block_id, $err_tip='')
			{
				$sql = 'SELECT home_page_block_id, module_name , block_name, block_description, display'.
						' FROM '.$this->CFG['db']['tbl']['home_page_modules'].
						' WHERE home_page_block_id = '.$this->dbObj->Param($this->fields_arr[$homepage_block_id]);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr[$homepage_block_id]));
				if (!$rs)
			        trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($this->homepageblock_details_arr = $rs->FetchRow())
					{
						return true;
				    }

				$this->setCommonErrorMsg($err_tip);
				return false;
			}

		/**
		 * managehomePageBlockHandler::deleteSelectedHomePageBlock()
		 * To delete the given category id
		 *
		 * @return boolean
		 */
		public function deleteSelectedHomePageBlock()
			{
				$homepage_block_ids = $this->fields_arr['home_page_block_ids'];

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['home_page_modules'].' '.
						'WHERE home_page_block_id IN ('.$homepage_block_ids.') ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			}

		/**
		 * managehomePageBlockHandler::chkBlockNameExits()
		 * To check if the category exists already
		 *
		 * @param string $profileblock
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkBlockNameExits($profileblock, $err_tip='')
			{
				$sql = 'SELECT COUNT(block_name) AS count FROM '.$this->CFG['db']['tbl']['home_page_modules'].' '.
						'WHERE UCASE(block_name) = UCASE('.$this->dbObj->Param($this->fields_arr[$profileblock]).') ';
				$fields_value_arr[] = $this->fields_arr[$profileblock];
				if ($this->fields_arr['home_page_block_id'])
					{
						$sql .= ' AND home_page_block_id != '.$this->dbObj->Param($this->fields_arr['home_page_block_id']);
						$fields_value_arr[] = $this->fields_arr['home_page_block_id'];
				    }
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($fields_value_arr));
				if (!$rs)
			        trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

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
		 * managehomePageBlockHandler::createHomePageBlock()
		 * To create/update profile block
		 *
		 * @param string $profileblock_table
		 * @return boolean
		 */
		public function createHomePageBlock($profileblock_table)
			{
				if ($this->fields_arr['home_page_block_id'])
					{
						$sql = 'UPDATE '.$profileblock_table.' SET '.
								'module_name = '.$this->dbObj->Param('module_name').', '.
								'block_name = '.$this->dbObj->Param('block_name').', '.
								'block_description = '.$this->dbObj->Param('block_description').', '.
								'display = '.$this->dbObj->Param('display').' '.
								'WHERE home_page_block_id = '.$this->dbObj->Param('home_page_block_id');

						$fields_value_arr = array($this->fields_arr['module_name'],
												$this->fields_arr['block_name'],
												$this->fields_arr['block_description'],
												$this->fields_arr['display'],
												$this->fields_arr['home_page_block_id']);

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
						if (!$rs)
					        trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						$this->home_page_block_id = $this->fields_arr['home_page_block_id'];
						return true;
				    }
				else
					{
						$sql = 'INSERT INTO '.$profileblock_table.' SET '.
						   	   	'user_id = '.$this->dbObj->Param('user_id').', '.
								'module_name = '.$this->dbObj->Param('module_name').', '.
								'block_name = '.$this->dbObj->Param('block_name').', '.
								'block_description = '.$this->dbObj->Param('block_description').', '.
								'display = '.$this->dbObj->Param('display').', '.
								'date_added = now()';

						$fields_value_arr = array($this->CFG['user']['user_id'], $this->fields_arr['module_name'], $this->fields_arr['block_description'], $this->fields_arr['block_name'],
						   	   	   	   	  	   	  $this->fields_arr['display']);

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
						if (!$rs)
					        trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						$this->home_page_block_id = $this->dbObj->Insert_ID();
						$this->UpdateOrderNo($this->home_page_block_id);

						return true;
					}
			}
		/**
		 * managehomePageBlockHandler::UpdateOrderNo()
		 *
		 * @param mixed $homepage_id
		 * @return
		 */
		public function UpdateOrderNo($homepage_id)
			{

			  $order_no=$this->getOrderNO();
			  $sql='UPDATE '.$this->CFG['db']['tbl']['home_page_modules'].' SET order_no='.$order_no.'+1 WHERE home_page_block_id='.$this->dbObj->Param('home_page_block_id');
			  $stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt, array($homepage_id));
							if (!$rs)
						        trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			}
		/**
		 * managehomePageBlockHandler::getOrderNO()
		 *
		 * @return
		 */
		public function getOrderNO()
			{
			  $sql='SELECT MAX( order_no ) as max_order FROM '.$this->CFG['db']['tbl']['home_page_modules'];
			  $stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt);
							if (!$rs)
						        trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			  if($row = $rs->FetchRow())
					return $order_no=$row['max_order'];

			}
		/**
		 * managehomePageBlockHandler::showProfileBlock()
		 * To display the categories
		 *
		 * @return void
		 */
		public function showProfileBlock()
			{
				global $smartyObj;
				$showHomePageBlock_arr = array();
				$inc = 0;
				while($row = $this->fetchResultRecord())
					{
						$showHomePageBlock_arr[$inc]['record'] = $row;

						$showHomePageBlock_arr[$inc]['checked'] = '';
						if((is_array($this->fields_arr['home_page_block_ids'])) && (in_array($row['home_page_block_id'], $this->fields_arr['home_page_block_ids'])))
							$showHomePageBlock_arr[$inc]['checked'] = "CHECKED";

						$inc++;
					}

				$smartyObj->assign('showHomePageBlock_arr', $showHomePageBlock_arr);
			}

		/**
		 * managehomePageBlockHandler::resetFieldsArray()
		 *
		 * @return
		 */
		public function resetFieldsArray()
			{
				$this->setFormField('module_name', '');
				$this->setFormField('block_name', '');
				$this->setFormField('display', 'Yes');
				$this->setFormField('home_page_block_id', '');
				$this->setFormField('home_page_block_ids', array());
				$this->setFormField('action', '');
				$this->setFormField('opt', '');
				$this->setFormField('block_description', '');


			}

		/**
		 * managehomePageBlockHandler::chkIsEditMode()
		 *
		 * @return boolean
		 */
		public function chkIsEditMode()
			{
				if($this->fields_arr['home_page_block_id'])
					return true;
				return false;
			}
		public function changeStatus($status)
			{
				$homepage_block_ids = $this->fields_arr['home_page_block_ids'];
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['home_page_modules'].' SET'.
						' display='.$this->dbObj->Param('display').
						' WHERE home_page_block_id IN('.$homepage_block_ids.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($status));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				return true;
			}


	}
//<<<<<<<--------------class managehomePageBlockHandler---------------//

//--------------------Code begins-------------->>>>>//
$profileblock = new managehomePageBlockHandler();
if(!chkAllowedModule(array(strtolower('video'))))
	{
		Redirect2URL($CFG['site']['url']."admin/index.php");
		exit;
	}
$profileblock->setPageBlockNames(array('form_create_home_page_block', 'form_show_Home_page_block', 'form_confirm'));

$profileblock->setAllPageBlocksHide();
//default form fields and values...
$profileblock->resetFieldsArray();

$profileblock->setFormField('prev_numpg',0);//To retain the last numpg
/***********set form field for navigation****/
$profileblock->setFormField('asc', 'gc.title');
$profileblock->setFormField('dsc', '');
/*************Start navigation******/
//fetch number of records show in the result--numpg
$condition = '';

$profileblock->setPageBlockShow('form_create_home_page_block');

$profileblock->sanitizeFormInputs($_REQUEST);
/*************End navigation******/
if ($profileblock->isFormGETed($_GET, 'home_page_block_id'))
	{
		$profileblock->chkIsNotEmpty('home_page_block_id', $LANG['common_err_tip_required'])and
			$profileblock->chkIsNumeric('home_page_block_id', $LANG['homepageblock_err_tip_invalid_home_page_block_id'])and
				$profileblock->isValidHomePageBlockId('home_page_block_id', $LANG['homepageblock_err_tip_invalid_home_page_block_id']);
		$profileblock->getFormField('start')and
			$profileblock->chkIsNumeric('start', $LANG['common_err_tip_required']);
		if ($profileblock->isValidFormInputs())
			{

				$profileblock->setAllPageBlocksHide();
				$profileblock->setPageBlockShow('form_create_home_page_block');
				$profileblock->setPageBlockShow('form_show_Home_page_block');
				$profileblock->setFormField('home_page_block_id', $profileblock->homepageblock_details_arr['home_page_block_id']);
				$profileblock->setFormField('module_name', stripslashes($profileblock->homepageblock_details_arr['module_name']));
				$profileblock->setFormField('block_name', stripslashes($profileblock->homepageblock_details_arr['block_name']));
				$profileblock->setFormField('display', $profileblock->homepageblock_details_arr['display']);
				$profileblock->setFormField('block_description', $profileblock->homepageblock_details_arr['block_description']);

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
				$profileblock->chkIsNotEmpty('home_page_block_ids', $LANG['common_err_tip_required'])or
					$profileblock->setCommonErrorMsg($LANG['homepageblock_err_tip_select_profile_block']);

				if($profileblock->isValidFormInputs())
					{
						switch($profileblock->getFormField('action'))
							{
								case 'Delete':
									$profileblock->deleteSelectedHomePageBlock();
									break;

								case 'Enable':
									$LANG['homepageblock_success_message'] = $LANG['homepageblock_success_enable_msg'];
									$profileblock->changeStatus('Yes');
									break;

								case 'Disable':
									$LANG['homepageblock_success_message'] = $LANG['homepageblock_success_disable_msg'];
									$profileblock->changeStatus('No');
									break;
							}
					}

				//$profileblock->setAllPageBlocksHide();
				if ($profileblock->isValidFormInputs())
					{
						$profileblock->setCommonSuccessMsg($LANG['homepageblock_success_message']);
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
else if ($profileblock->isFormPOSTed($_POST, 'homepage_block_submit'))
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
					$profileblock->chkBlockNameExits('block_name', $LANG['homepageblock_err_tip_alreay_exists']);
				$profileblock->chkIsNotEmpty('display', $LANG['common_err_tip_required']);

				$profileblock->getFormField('home_page_block_id')and
					$profileblock->chkIsNotEmpty('home_page_block_id', $LANG['common_err_tip_required'])and
						$profileblock->chkIsNumeric('home_page_block_id', $LANG['homepageblock_err_tip_invalid_home_page_block_id'])and
							$profileblock->isValidHomePageBlockId('home_page_block_id', $LANG['homepageblock_err_tip_invalid_home_page_block_id']);

				$profileblock->isValidFormInputs()and
					$profileblock->createHomePageBlock($CFG['db']['tbl']['home_page_modules']);

				if ($profileblock->isValidFormInputs())
					{
						if($profileblock->getFormField('home_page_block_id'))
							$profileblock->setCommonSuccessMsg($LANG['homepageblock_success_edit_message']);
						else
							$profileblock->setCommonSuccessMsg($LANG['homepageblock_success_add_message']);

						$profileblock->setPageBlockShow('block_msg_form_success');
						$profileblock->resetFieldsArray();
					}
				else
					{
						$profileblock->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$profileblock->setPageBlockShow('block_msg_form_error');
						$profileblock->setFormField('home_page_block_id', $profileblock->homepageblock_details_arr['home_page_block_id']);
					}
			}
	}
else if($profileblock->isFormPOSTed($_POST, 'category_cancel'))
	{
		$profileblock->resetFieldsArray();
	}

/*************Start navigation******/
if ($profileblock->isShowPageBlock('form_create_home_page_block'))
	{
		$profileblock->setTableNames(array($CFG['db']['tbl']['home_page_modules']));
		$profileblock->setReturnColumns(array('home_page_block_id, module_name , block_name, block_description, display, DATE_FORMAT(date_added, \''.$CFG['format']['date'].'\') as date_added'));
		//Condition of the query
		$condition = '';
		$profileblock->buildSelectQuery();
		$profileblock->buildConditionQuery($condition);
		$profileblock->buildSortQuery();
		$profileblock->checkSortQuery('home_page_block_id', 'desc');
		$profileblock->buildQuery();
		$profileblock->executeQuery();
		/*************End navigation******/
		$profileblock->setPageBlockShow('form_show_Home_page_block');
	}

//<<<<--------------------Code Ends----------------------//
$profileblock->hidden_arr1 = array('start');
$profileblock->hidden_arr2 = array('home_page_block_id', 'opt');
if ($profileblock->isShowPageBlock('form_create_home_page_block'))
	{
		$profileblock->form_create_home_page_block['hidden_arr'] = array('home_page_block_id', 'start');
	}

if ($profileblock->isShowPageBlock('form_show_Home_page_block'))
	{
		$profileblock->form_show_Home_page_block['hidden_arr'] = array('start');
		if($profileblock->isResultsFound())
			{
			   	$profileblock->showProfileBlock();
				$smartyObj->assign('smarty_paging_list', $profileblock->populatePageLinksGET($profileblock->getFormField('start')));
			}
	}
$profileblock->left_navigation_div = 'videoMain';
//include the header file
$profileblock->includeHeader();
//--------------------Page block templates begins-------------------->>>>>//
//include the content of the page
setTemplateFolder('admin/', 'video');
$smartyObj->display('manageHomePageBlock.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script language="javascript" type="text/javascript">
	var block_arr= new Array('selMsgConfirm', 'selMsgConfirmSub');
	var replace_url = '<?php echo $CFG['site']['url'];?>login.php';
</script>
<?php
/* Added code to validate mandataory fields in video defaut settings page */
if ($CFG['feature']['jquery_validation'])
{
?>
<script type="text/javascript">
$Jq("#manageSelCreateCategory").validate({
	rules:
	{
		module_name: {
		required: true,
		checkSpecialChr: true
		},
		block_name: {
		required: true
		}
	},
	messages:
	{
		module_name: {
		required: "<?php echo $LANG['common_err_tip_required'];?>"
		},
		block_name: {
		required: "<?php echo $LANG['common_err_tip_required'];?>"
		}
	}
});
</script>
<?php
}
$profileblock->includeFooter();
?>