<?php
/**
 * This file manage the profile category
 *
 * There are options to listing and status change options exist
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/common/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/help.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/admin/addProfileCategory.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';;
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//--------------class addProfileCategoryHandler--------------->>>//
/**
 * This class manage the profile category
 *
 * @category	Rayzz
 * @package		Admin
 */
class addProfileCategoryHandler extends ListRecordsHandler
	{
		public $category_details_arr;
		public $category_id;

		/**
		 * addProfileCategoryHandler::setIHObject()
		 * To set the object for image handler
		 *
		 * @param mixed $imObj object name
		 * @return void
		 * @access 	public
		 */
		public function setIHObject($imObj)
			{
				$this->imageObj = $imObj;
			}

		/**
		 * addProfileCategoryHandler::buildConditionQuery()
		 * to set the the condition
		 *
		 * @param string $condition
		 * @return void
		 * @access 	public
		 */
		public function buildConditionQuery($condition='')
			{
				$this->sql_condition = $condition;
			}

		/**
		 * addProfileCategoryHandler::checkSortQuery()
		 * To set the sort query
		 *
		 * @param mixed $field sort field
		 * @param string $sort sort by
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
		 * addProfileCategoryHandler::isValidCategoryId()
		 * To check the categroy id is valid or not
		 *
		 * @param Integer $category_id category id to validata
		 * @param string $err_tip error message
		 * @return boolean
		 * @access 	public
		 */
		public function isValidCategoryId($category_id, $err_tip='')
			{
				$sql = 'SELECT id, title, description, status, search_field_status, date_added'.
						' FROM '.$this->CFG['db']['tbl']['users_profile_category'].
						' WHERE id = '.$this->dbObj->Param($this->fields_arr[$category_id]);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr[$category_id]));
				if (!$rs)
			        trigger_db_error($this->dbObj);

				if ($this->category_details_arr = $rs->FetchRow())
					{
						return true;
				    }

				$this->setCommonErrorMsg($err_tip);
				return false;
			}

		/**
		 * addProfileCategoryHandler::deleteSelectedCategories()
		 * To delete the selected categories
		 *
		 * @return
		 * @access 	public
		 */
		public function deleteSelectedCategories()
			{
				$category_ids = $this->fields_arr['category_ids'];
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['users_profile_category'].' '.
						'WHERE id IN ('.$category_ids.') ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				    trigger_db_error($this->dbObj);

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['profile_block'].' '.
						'WHERE profile_category_id IN ('.$category_ids.') ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				    trigger_db_error($this->dbObj);

				$sql = 'SELECT id FROM '.$this->CFG['db']['tbl']['users_profile_question'].' '.
						'WHERE form_id IN ('.$category_ids.') ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				    trigger_db_error($this->dbObj);
				$question_id_arr=array();
				$inc=0;
				while($row = $rs->FetchRow())
				{
				  $question_id_arr[$inc]=$row['id'];
				}
				$question_ids=implode(',',$question_id_arr);
				if($question_ids)
					{
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['users_profile_info'].' '.
								'WHERE question_id IN ('.$question_ids.') ';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
						    trigger_db_error($this->dbObj);
					}
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['users_profile_question'].' '.
						'WHERE form_id IN ('.$category_ids.') ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				    trigger_db_error($this->dbObj);

			}

		/**
		 * addProfileCategoryHandler::chkCategoryExits()
		 * To check whether the category exists or not
		 *
		 * @param string $category category to check
		 * @param string $err_tip error message
		 * @return boolean
		 * @access 	public
		 */
		public function chkCategoryExits($category, $err_tip='')
			{
				$sql = 'SELECT COUNT(id) AS count FROM '.$this->CFG['db']['tbl']['users_profile_category'].' '.
						'WHERE UCASE(title) = UCASE('.$this->dbObj->Param($this->fields_arr[$category]).') ';
				$fields_value_arr[] = $this->fields_arr[$category];
				if ($this->fields_arr['category_id'])
					{
						$sql .= ' AND id != '.$this->dbObj->Param($this->fields_arr['category_id']);
						$fields_value_arr[] = $this->fields_arr['category_id'];
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
				$this->fields_err_tip_arr['category'] = $err_tip;
				$this->setCommonErrorMsg($err_tip);
				return false;
			}

		/**
		 * addProfileCategoryHandler::createCategory()
		 * To create/update category
		 *
		 * @param string $category_table category table name
		 * @return boolean
		 * @access 	public
		 */
		public function createCategory($category_table)
			{
				if ($this->fields_arr['category_id'])
					{
						$sql = 'UPDATE '.$category_table.' SET '.
								'title = '.$this->dbObj->Param('title').', '.
								'description = '.$this->dbObj->Param('description').', '.
								'search_field_status = '.$this->dbObj->Param('search_field_status').', '.
								'status = '.$this->dbObj->Param('status').' '.
								'WHERE id = '.$this->dbObj->Param('category_id');

						$fields_value_arr = array($this->fields_arr['category'],
												$this->fields_arr['description'],
												$this->fields_arr['search_field_status'],
												$this->fields_arr['status'],
												$this->fields_arr['category_id']);

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
						if (!$rs)
					        trigger_db_error($this->dbObj);

						$this->category_id = $this->fields_arr['category_id'];

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['profile_block'].' SET '.
								'display = '.$this->dbObj->Param('status').' '.
								'WHERE profile_category_id = '.$this->dbObj->Param('category_id');

						$fields_value_arr = array($this->fields_arr['status'],
												$this->fields_arr['category_id']);

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
						if (!$rs)
					        trigger_db_error($this->dbObj);

						return true;
				    }
				else
					{
						$sql = 'INSERT INTO '.$category_table.' SET '.
								'title = '.$this->dbObj->Param('category').', '.
								'description = '.$this->dbObj->Param('description').', '.
								'status = '.$this->dbObj->Param('status').', '.
								'search_field_status = '.$this->dbObj->Param('search_field_status').', '.
								'user_id = '.$this->dbObj->Param('user_id').', '.
								'submit_label = \'Submit\', mode = \'db\', theme = \'default\', lang = \'en\', date_added = now()';

						$fields_value_arr = array($this->fields_arr['category'],$this->fields_arr['description'],
													$this->fields_arr['status'],$this->fields_arr['search_field_status'],
													$this->CFG['user']['user_id']);

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
						if (!$rs)
					        trigger_db_error($this->dbObj);

						$this->category_id = $this->dbObj->Insert_ID();

						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['profile_block'].' (order_no, block_name, block_description, display, user_id, profile_category_id, position, module_name, date_added) SELECT(SELECT MAX(order_no)+1 FROM profile_block WHERE position =\'left\'),'.
								$this->dbObj->Param('category').', '.
								$this->dbObj->Param('description').', '.
								$this->dbObj->Param('status').', '.
								$this->dbObj->Param('user_id').', '.
								$this->dbObj->Param('category_id').', '.
								'\'left\', \'default\',now()';
						$fields_value_arr = array(str_replace(' ','',$this->fields_arr['category']),$this->fields_arr['description'],
													$this->fields_arr['status'],$this->CFG['user']['user_id'],
													$this->category_id);

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
						if (!$rs)
					        trigger_db_error($this->dbObj);

						return true;
					}
			}

		/**
		 * addProfileCategoryHandler::showCategories()
		 * To display the categories list
		 *
		 * @return void
		 * @access 	public
		 */
		public function showCategories()
			{
				global $smartyObj;
				$showCategories_arr = array();
				$inc = 0;
				while($row = $this->fetchResultRecord())
					{
						$showCategories_arr[$inc]['record'] = $row;

						$showCategories_arr[$inc]['checked'] = '';
						if((is_array($this->fields_arr['category_ids'])) && (in_array($row['id'], $this->fields_arr['category_ids'])))
							$showCategories_arr[$inc]['checked'] = 'checked="checked"';

						$inc++;
					}

				$smartyObj->assign('showCategories_arr', $showCategories_arr);
			}

		/**
		 * addProfileCategoryHandler::chkFileNmaeIsNotEmpty()
		 * To check file name is empty or not
		 *
		 * @param string $field_name field name to check
		 * @param string $err_tip error message
		 * @return boolean
		 * @access 	public
		 */
		public function chkFileNmaeIsNotEmpty($field_name, $err_tip = '')
			{
				if(!$_FILES[$field_name]['name'])
					{
						$this->setFormFieldErrorTip($field_name,$err_tip);
						return false;
					}
				return true;
			}

		/**
		 * addProfileCategoryHandler::resetFieldsArray()
		 * to initialize the form field values
		 *
		 * @return void
		 * @access 	public
		 */
		public function resetFieldsArray()
			{
				$this->setFormField('category', '');
				$this->setFormField('description', '');
				$this->setFormField('category_id', '');
				$this->setFormField('status', 'Yes');
				$this->setFormField('search_field_status', 'Yes');
				$this->setFormField('category_ids', array());
				$this->setFormField('action', '');
				$this->setFormField('opt', '');
			}

		/**
		 * addProfileCategoryHandler::chkIsEditMode()
		 * To check the file is edit mode or not
		 *
		 * @return boolean
		 * @access 	public
		 */
		public function chkIsEditMode()
			{
				if($this->fields_arr['category_id'])
					return true;
				return false;
			}

		/**
		 * addProfileCategoryHandler::changeStatus()
		 * To check ange profile category status
		 *
		 * @param string $status status to update
		 * @return boolean
		 * @access 	public
		 */
		public function changeStatus($status)
			{
				$category_ids = $this->fields_arr['category_ids'];

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_profile_category'].' SET'.
						' status='.$this->dbObj->Param('status').
						' WHERE id IN('.$category_ids.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($status));
			    if (!$rs)
				    trigger_db_error($this->dbObj);


				$sql = 'UPDATE '.$this->CFG['db']['tbl']['profile_block'].' SET'.
						' display ='.$this->dbObj->Param('status').
						' WHERE profile_category_id IN('.$category_ids.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($status));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				return true;
			}

	}
//<<<<<<<--------------class addProfileCategoryHandler---------------//

//--------------------Code begins-------------->>>>>//
$category = new addProfileCategoryHandler();
$category->setPageBlockNames(array('form_create_category', 'form_create_sub_category', 'form_show_category', 'form_show_sub_category', 'form_confirm'));

$category->setAllPageBlocksHide();
//default form fields and values...
$category->resetFieldsArray();

$category->setFormField('prev_numpg',0);//To retain the last numpg
/***********set form field for navigation****/
$category->setFormField('asc', 'gc.title');
$category->setFormField('dsc', '');
/*************Start navigation******/
//fetch number of records show in the result--numpg
$condition = '';

//Set tables and fields to return
$category->setTableNames(array($CFG['db']['tbl']['users_profile_category'].' as gc'));
$category->setReturnColumns(array('gc.id, gc.title , gc.description , gc.status,date_added'));

$category->sanitizeFormInputs($_REQUEST);
/*************End navigation******/
if ($category->isFormGETed($_GET, 'category_id'))
	{

		$category->chkIsNotEmpty('category_id', $LANG['common_err_tip_required'])and
			$category->chkIsNumeric('category_id', $LANG['addprofilecategory_err_tip_invalid_category_id'])and
				$category->isValidCategoryId('category_id', $LANG['addprofilecategory_err_tip_invalid_category_id']);
		$category->getFormField('start')and
			$category->chkIsNumeric('start', $LANG['common_err_tip_required']);
		if ($category->isValidFormInputs())
			{

				$category->setAllPageBlocksHide();
				$category->setFormField('category_id', $category->category_details_arr['id']);
				$category->setFormField('category', stripslashes($category->category_details_arr['title']));
				$category->setFormField('description', stripslashes($category->category_details_arr['description']));
				$category->setFormField('status', $category->category_details_arr['status']);
				$category->setFormField('search_field_status', $category->category_details_arr['search_field_status']);
			}
		else
			{
				$category->setAllPageBlocksHide();
				$category->setFormField('start', 0);
				$category->setPageBlockShow('block_msg_form_error');
				$category->setCommonErrorMsg($LANG['common_msg_error_sorry']);
			}
	}
if ($category->isFormPOSTed($_POST, 'confirm_action'))
	{
		if($CFG['admin']['is_demo_site'])
			{
				$category->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
				$category->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				$category->chkIsNotEmpty('category_ids', $LANG['common_err_tip_required'])or
					$category->setCommonErrorMsg($LANG['addprofilecategory_err_tip_select_category']);

				if($category->isValidFormInputs())
					{
						switch($category->getFormField('action'))
							{
								case 'Delete':
									$category->deleteSelectedCategories();
									break;

								case 'Enable':
									$LANG['addprofilecategory_success_message'] = $LANG['addprofilecategory_success_enable_msg'];
									$category->changeStatus('Yes');
									break;

								case 'Disable':
									$LANG['addprofilecategory_success_message'] = $LANG['addprofilecategory_success_disable_msg'];
									$category->changeStatus('No');
									break;
							}
					}

				$category->setAllPageBlocksHide();
				if ($category->isValidFormInputs())
					{
						$category->setCommonSuccessMsg($LANG['addprofilecategory_success_message']);
						$category->setPageBlockShow('block_msg_form_success');
						$category->resetFieldsArray();
					}
				else
					{
						$category->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$category->setPageBlockShow('block_msg_form_error');
					}
			}
	}
else if ($category->isFormPOSTed($_POST, 'category_submit'))
	{
		$category->chkIsNotEmpty('category', $LANG['common_err_tip_required'])and
			$category->chkCategoryExits('category', $LANG['addprofilecategory_err_tip_alreay_exists']);
		$category->chkIsNotEmpty('description', $LANG['common_err_tip_required']);
		$category->chkIsNotEmpty('status', $LANG['common_err_tip_required']);

		$category->getFormField('category_id')and
			$category->chkIsNotEmpty('category_id', $LANG['common_err_tip_required'])and
				$category->chkIsNumeric('category_id', $LANG['addprofilecategory_err_tip_invalid_category_id'])and
					$category->isValidCategoryId('category_id', $LANG['addprofilecategory_err_tip_invalid_category_id']);

		$category->isValidFormInputs()and
			$category->createCategory($CFG['db']['tbl']['users_profile_category']);

		if ($category->isValidFormInputs())
			{
				if($category->getFormField('category_id'))
					$category->setCommonSuccessMsg($LANG['addprofilecategory_success_edit_message']);
				else
					$category->setCommonSuccessMsg($LANG['addprofilecategory_success_add_message']);

				$category->setPageBlockShow('block_msg_form_success');
				$category->resetFieldsArray();
			}
		else
			{
				$category->setAllPageBlocksHide();
				$category->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$category->setPageBlockShow('block_msg_form_error');
				$category->setFormField('category_id', $category->category_details_arr['id']);
			}
	}
else if($category->isFormPOSTed($_POST, 'category_cancel'))
	{
		$category->resetFieldsArray();
	}

/*************Start navigation******/
if (!$category->isShowPageBlock('form_create_sub_category'))
	{
		$category->setTableNames(array($CFG['db']['tbl']['users_profile_category'].' as gc'));
		$category->setReturnColumns(array('gc.id, gc.title , gc.description, gc.status, gc.search_field_status, date_added'));
		//Condition of the query
		$condition = '';
		$category->buildSelectQuery();
		$category->buildConditionQuery($condition);
		$category->buildSortQuery();
		$category->checkSortQuery('gc.title', 'asc');
		$category->buildQuery();
		//$category->printQuery();
		$category->executeQuery();
		/*************End navigation******/
		$category->setPageBlockShow('form_create_category');//  temporary not allowed to create category
		$category->setPageBlockShow('form_show_category');
	}

//<<<<--------------------Code Ends----------------------//
$category->hidden_arr1 = array('start');
$category->hidden_arr2 = array('category_id', 'opt');
if ($category->isShowPageBlock('form_create_category'))
	{
		$category->form_create_category['hidden_arr'] = array('category_id', 'start');
	}
if ($category->isShowPageBlock('form_show_category'))
	{
		$category->form_show_category['hidden_arr'] = array('start');
		if($category->isResultsFound())
			{
				$category->showCategories();
				$smartyObj->assign('smarty_paging_list', $category->populatePageLinksPOST($category->getFormField('start'), 'selFormCategory'));
			}
	}
$category->left_navigation_div = 'generalList';
//include the header file
$category->includeHeader();
//--------------------Page block templates begins-------------------->>>>>//
//include the content of the page
setTemplateFolder('admin/' );
$smartyObj->display('addProfileCategory.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script language="javascript" type="text/javascript">
	var block_arr= new Array('selMsgConfirm', 'selMsgConfirmSub');
</script>
<?php
$category->includeFooter();
?>