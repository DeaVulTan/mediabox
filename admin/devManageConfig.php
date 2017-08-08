<?php
/**
 * File handling config data add, edit, delete and listing
 *
 *
 * PHP version 5.0
 *
 * @category	Admin
 * @package		devManageConfig
 * @author 		selvaraj_007at09
 * @copyright 	Copyright (c) 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2010-04-30
 */
/**
 * File having common configuration variables required for the entire project
 */
require_once('../common/configs/config.inc.php'); //configurations
$CFG['lang']['include_files'][] = 'languages/%s/admin/devManageConfig.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------- Class devManageConfig begins --------------->>>>>//
//$CFG['db']['tbl']['config_data'] = 'config_data_article';
class devManageConfig extends FormHandler
	{
		public $return_sql = '';

		public function populateConfig()
			{
				$sql = ' SELECT * FROM '. $this->CFG['db']['tbl']['config_data'] .' ORDER BY config_category, config_section_order, edit_order';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array());
					if (!$rs)
						trigger_db_error($this->dbObj);

				$populateConfig_arr = array();
				if($rs->PO_RecordCount())
					{
						$inc = 0;
						$temp_category_arr = array();
						while($row = $rs->FetchRow())
							{
								$row['display_config_category'] = $row['config_category']?$row['config_category']:'General Settings';
								$row['display_config_category'] = ucfirst(str_replace('_', ' ', $row['display_config_category']));
								if(isset($temp_category_arr[$row['config_category']]))
									{
										$row['display_config_category'] = '';
									}
								else
									{
										$temp_category_arr[$row['config_category']] = '';
									}
								$populateConfig_arr[$inc]['record'] = $row;

								$value = $row['config_value'];
								switch($row['config_type'])
									{
										case 'Array':
											$value = str_replace(', ', ',', $value);
											$value = explode(',', $value);
											if($value)
												{
													$value = 'array(\''.implode('\', \'', $value).'\')';
												}
											else
												{
													$value = 'array()';
												}
											break;

										default:
											$value = '\''.$value.'\'';
									}
								if($row['dim1']!='' and $row['dim2']!='' and $row['dim3']!='' and $row['dim4']!='')
									{
										$display_var = '$CFG[\''.$row['dim1'].'\'][\''.$row['dim2'].'\'][\''.$row['dim3'].'\'][\''.$row['dim4'].'\'] = '.$value.';';
									}
								else if($row['dim1']!='' and $row['dim2']!='' and $row['dim3']!='')
									{
										$display_var = '$CFG[\''.$row['dim1'].'\'][\''.$row['dim2'].'\'][\''.$row['dim3'].'\'] = '.$value.';';
									}
								else if($row['dim1']!='' and $row['dim2']!='')
									{
										$display_var = '$CFG[\''.$row['dim1'].'\'][\''.$row['dim2'].'\'] = '.$value.';';
									}
								else if($row['dim1']!='')
									{
										$display_var = '$CFG[\''.$row['dim1'].'\'] = '.$value.';';
									}
								$populateConfig_arr[$inc]['display_var'] = $display_var;
								$populateConfig_arr[$inc]['css_class'] = $inc%2==0?'clsTblRow1':'clsTblRow2';
								$populateConfig_arr[$inc]['edit_url'] = getCurrentUrl(false).'?act=edit&cid='.$row['config_data_id'];
								$populateConfig_arr[$inc]['delete_url'] = getCurrentUrl(false).'?act=del&cid='.$row['config_data_id'];
								$inc++;
							}
					}
				return $populateConfig_arr;
			}

		public function populateConditionQuery()
			{
				$condition = '';
				if($config_data_id = $this->getFormField('cid'))
					{
						$sql = ' SELECT * FROM '.$this->CFG['db']['tbl']['config_data'].' WHERE'.
								' config_data_id = '.$this->dbObj->Param('config_data_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($config_data_id));
							if (!$rs)
								trigger_db_error($this->dbObj);

						if($row = $rs->FetchRow())
							{
								$condition = ' WHERE dim1 = \''.$row['dim1'].'\' AND dim2 = \''.$row['dim2'].'\' AND dim3 = \''.$row['dim3'].'\' AND dim4 = \''.$row['dim4'].'\'';
							}
					}
				return $condition;
			}

		public function returnSql($rsql, $condition)
			{
				if($condition)
					{
						$rsql = substr($rsql, 0, strrpos($rsql, 'WHERE'));
						$rsql .= $condition;
					}
				$this->return_sql = $rsql;
			}

		public function resetFieldsArray()
			{
				$this->setFormField('cid', '');
				$this->setFormField('dim1', '');
				$this->setFormField('dim2', '');
				$this->setFormField('dim3', '');
				$this->setFormField('dim4', '');
				$this->setFormField('config_value', '');
				$this->setFormField('config_type', 'String');
				$this->setFormField('config_category', '');
				$this->setFormField('config_section', 'general_settings');
				$this->setFormField('config_section_order', '100');
				$this->setFormField('editable', 'No');
				$this->setFormField('edit_order', '999');
				$this->setFormField('description', '');
				$this->setFormField('help_text', '');
			}

		public function chkIsValidConfigValue($err_tip = '')
			{
				$cfg_value = $this->getFormField('config_value');
				if($cfg_value == '')
					{
						return true;
					}
				switch($this->getFormField('config_type'))
					{
						case 'Boolean':
							if(!($cfg_value == 0 or $cfg_value == 1))
								{
									$this->setFormFieldErrorTip('config_value', $err_tip);
								}
							break;

						case 'Int':
							$this->chkIsNumeric('config_value', $err_tip);
							break;

						case 'Intwithsymbol':
							$this->chkIsNumericWithSymbol('config_value', $err_tip);
							break;

						case 'Real':
							$this->chkIsReal('config_value', $err_tip);
							break;

						case 'Email':
							$this->chkIsValidEmail('config_value', $err_tip);
							break;

						case 'Website':
							$this->chkIsValidURL('config_value', $err_tip);
							break;
					}
				return true;
			}

		public function chkIsDuplicateConfigVariable($err_tip = '')
			{
				$data_arr[] =  $this->getFormField('cid');
				$data_arr[] =  $this->getFormField('dim1');

				$sql = 'SELECT config_data_id FROM '.$this->CFG['db']['tbl']['config_data'].' WHERE'.
						' config_data_id != '.$this->dbObj->Param('config_data_id').' AND'.
						' dim1 = '.$this->dbObj->Param('dim1');

				if($this->getFormField('dim2'))
					{
						$sql .= ' AND dim2 = '.$this->dbObj->Param('dim2');
						$data_arr[] =  $this->getFormField('dim2');
					}
				if($this->getFormField('dim3'))
					{
						$sql .= ' AND dim3 = '.$this->dbObj->Param('dim3');
						$data_arr[] =  $this->getFormField('dim3');
					}
				if($this->getFormField('dim4'))
					{
						$sql .= ' AND dim4 = '.$this->dbObj->Param('dim4');
						$data_arr[] =  $this->getFormField('dim4');
					}

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $data_arr);
					if (!$rs)
						trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						$this->setFormFieldErrorTip('dim1', $err_tip);
						return true;
					}
				return false;
			}

		public function updateConfigData()
			{
				$data_arr[] = $this->getFormField('dim1');
				$data_arr[] = $this->getFormField('dim2');
				$data_arr[] = $this->getFormField('dim3');
				$data_arr[] = $this->getFormField('dim4');
				$data_arr[] = $this->getFormField('config_value');
				$data_arr[] = $this->getFormField('config_type');
				$data_arr[] = $this->getFormField('config_category');
				$data_arr[] = $this->getFormField('config_section');
				$data_arr[] = $this->getFormField('config_section_order');
				$data_arr[] = $this->getFormField('editable');
				$data_arr[] = $this->getFormField('edit_order');
				$data_arr[] = $this->getFormField('description');
				$data_arr[] = $this->getFormField('help_text');

				if($this->getFormField('cid'))
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['config_data'].' SET';
					}
				else
					{
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['config_data'].' SET';
					}
				$sql .= ' dim1 = '.$this->dbObj->Param('dim1').','.
						' dim2 = '.$this->dbObj->Param('dim2').','.
						' dim3 = '.$this->dbObj->Param('dim3').','.
						' dim4 = '.$this->dbObj->Param('dim4').','.
						' config_value = '.$this->dbObj->Param('config_value').','.
						' config_type = '.$this->dbObj->Param('config_type').','.
						' config_category = '.$this->dbObj->Param('config_category').','.
						' config_section = '.$this->dbObj->Param('config_section').','.
						' config_section_order = '.$this->dbObj->Param('config_section_order').','.
						' editable = '.$this->dbObj->Param('editable').','.
						' edit_order = '.$this->dbObj->Param('edit_order').','.
						' description = '.$this->dbObj->Param('description').','.
						' help_text = '.$this->dbObj->Param('help_text');

				if($this->getFormField('cid'))
					{
						$data_arr[] = $this->getFormField('cid');
						$sql .= ' WHERE config_data_id = '.$this->dbObj->Param('config_data_id');
					}

				$condition = $this->populateConditionQuery();

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $data_arr);
					if (!$rs)
						trigger_db_error($this->dbObj);

				$this->returnSql($this->dbObj->sql, $condition);
			}

		public function deleteConfigData()
			{
				$data_arr[] = $this->getFormField('cid');

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['config_data'].
						' WHERE config_data_id = '.$this->dbObj->Param('config_data_id');

				$condition = $this->populateConditionQuery();

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $data_arr);
					if (!$rs)
						trigger_db_error($this->dbObj);

				$this->returnSql($this->dbObj->sql, $condition);
			}

		public function populateConfigData()
			{
				$data_arr[] = $this->getFormField('cid');

				$sql = 'SELECT * FROM '.$this->CFG['db']['tbl']['config_data'].
						' WHERE config_data_id = '.$this->dbObj->Param('config_data_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $data_arr);
					if (!$rs)
						trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->setFormField('dim1', $row['dim1']);
						$this->setFormField('dim2', $row['dim2']);
						$this->setFormField('dim3', $row['dim3']);
						$this->setFormField('dim4', $row['dim4']);
						$this->setFormField('config_value', $row['config_value']);
						$this->setFormField('config_type', $row['config_type']);
						$this->setFormField('config_category', $row['config_category']);
						$this->setFormField('config_section', $row['config_section']);
						$this->setFormField('config_section_order', $row['config_section_order']);
						$this->setFormField('editable', $row['editable']);
						$this->setFormField('edit_order', $row['edit_order']);
						$this->setFormField('description', $row['description']);
						$this->setFormField('help_text', $row['help_text']);

						return true;
					}
				return false;
			}

		public function populateMainCategories()
			{
				$sql = 'SELECT config_category FROM '.$this->CFG['db']['tbl']['config_data'].' GROUP BY config_category ORDER BY config_category';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array());
					if (!$rs)
						trigger_db_error($this->dbObj);

				$populateMainCategories_arr = array();
				while($row = $rs->FetchRow())
					{
						$populateMainCategories_arr[$row['config_category']] = $row['config_category'];
					}
				return $populateMainCategories_arr;
			}

		public function populateSectionList()
			{
				$sql = ' SELECT config_section FROM '.$this->CFG['db']['tbl']['config_data'].' WHERE'.
						' config_category = '.$this->dbObj->Param('config_category').' GROUP BY config_section ORDER BY config_section';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->getFormField('config_category')));
					if (!$rs)
						trigger_db_error($this->dbObj);

				$populateSectionList_arr = array();
				while($row = $rs->FetchRow())
					{
						$populateSectionList_arr[$row['config_section']] = $row['config_section'];
					}
				return $populateSectionList_arr;
			}
	}

//<<<<<-------------- Class devManageConfig begins ---------------//
//-------------------- Code begins -------------->>>>>//
$devManageConfig = new devManageConfig();
$devManageConfig->setPageBlockNames(array('block_config_list', 'block_config_add', 'block_config_edit', 'block_sql_display', 'block_config_section'));
//default form fields and values...
$devManageConfig->setFormField('act', '');
$devManageConfig->resetFieldsArray();

$devManageConfig->setAllPageBlocksHide();
$devManageConfig->setPageBlockShow('block_config_list'); //default page block. show it. All others hidden
$devManageConfig->sanitizeFormInputs($_REQUEST);

if($devManageConfig->isFormGETed($_REQUEST, 'act'))
	{
		switch($devManageConfig->getFormField('act'))
			{
				case 'add':
					$devManageConfig->setAllPageBlocksHide();
					$devManageConfig->setPageBlockShow('block_config_add');
					break;

				case 'edit':
					if($devManageConfig->populateConfigData())
						{
							$devManageConfig->setAllPageBlocksHide();
							$devManageConfig->setPageBlockShow('block_config_add');
							$devManageConfig->setPageBlockShow('block_config_edit');
						}
					break;

				case 'del':
					$devManageConfig->deleteConfigData();
					$devManageConfig->setCommonSuccessMsg($LANG['common_success_deleted']);
					$devManageConfig->setPageBlockShow('block_msg_form_success');
					break;

				case 'sectionlist':
					if(isAjaxPage() and $devManageConfig->getFormField('config_category'))
						{
							$devManageConfig->setPageBlockShow('block_config_section');
							$devManageConfig->block_config_section['populateSectionList'] = $devManageConfig->populateSectionList();
						}
					break;
			}
	}
if($devManageConfig->isFormPOSTed($_POST, 'add_submit'))
	{
		$devManageConfig->chkIsNotEmpty('dim1', $LANG['common_err_tip_required']);
		$devManageConfig->chkIsNotEmpty('config_type', $LANG['common_err_tip_required']) and
			$devManageConfig->chkIsValidConfigValue($LANG['devmanageconfig_err_tip_config_value']);
		$devManageConfig->chkIsNotEmpty('config_category', $LANG['common_err_tip_required']);
		$devManageConfig->chkIsNotEmpty('editable', $LANG['common_err_tip_required']);
		$devManageConfig->chkIsNotEmpty('edit_order', $LANG['common_err_tip_required']) and
			$devManageConfig->chkIsNumeric('edit_order', $LANG['common_err_tip_numeric']);
		$devManageConfig->chkIsNotEmpty('config_section', $LANG['common_err_tip_required']);
		$devManageConfig->chkIsNotEmpty('config_section_order', $LANG['common_err_tip_required']) and
			$devManageConfig->chkIsNumeric('config_section_order', $LANG['common_err_tip_numeric']);
		$devManageConfig->chkIsDuplicateConfigVariable($LANG['devmanageconfig_err_tip_duplicate_variable']);

		if($devManageConfig->isValidFormInputs())
			{
				$devManageConfig->updateConfigData();
				$devManageConfig->setPageBlockShow('block_msg_form_success');

				if($devManageConfig->getFormField('cid'))
					{
						$devManageConfig->setCommonSuccessMsg($LANG['common_success_updated']);
					}
				else
					{
						$devManageConfig->setCommonSuccessMsg($LANG['common_success_added']);
					}
			}
		else
			{
				$devManageConfig->setAllPageBlocksHide();
				$devManageConfig->setPageBlockShow('block_config_add');
				if($devManageConfig->getFormField('cid'))
					{
						$devManageConfig->setPageBlockShow('block_config_edit');
					}
				$devManageConfig->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$devManageConfig->setPageBlockShow('block_msg_form_error');
			}
	}
if($devManageConfig->return_sql)
	{
		$devManageConfig->setPageBlockShow('block_sql_display');
	}
if($devManageConfig->isFormPOSTed($_POST, 'cancel_submit'))
	{
		$devManageConfig->resetFieldsArray();
	}
//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//
$devManageConfig->left_navigation_div = 'generalList';

if($devManageConfig->isShowPageBlock('block_config_list'))
	{
		$devManageConfig->block_config_list['populateConfig'] = $devManageConfig->populateConfig();
		$devManageConfig->block_config_list['populateMainCategories'] = $devManageConfig->populateMainCategories();
	}
if($devManageConfig->isShowPageBlock('block_config_add') || $devManageConfig->isShowPageBlock('block_config_edit'))
	{
		$devManageConfig->block_config_add['config_type_arr'] = array('Int'=>'Int', 'Intwithsymbol'=>'Intwithsymbol', 'Real'=>'Real', 'String'=>'String', 'Boolean'=>'Boolean', 'Array'=>'Array', 'Email'=>'Email', 'Website'=>'Website');
		$devManageConfig->block_config_add['populateMainCategories'] = $devManageConfig->populateMainCategories();
	}
//include the header file
if(!isAjaxPage())
	{
		$devManageConfig->includeHeader();
?>
<script language="javascript">
	function changeConfigCategory(cat){
		$Jq('#config_category').val(cat);
		$Jq('#config_section').val('');
		loadConfigSection(cat);
		return false;
	}
	function changeConfigSection(sec){
		$Jq('#config_section').val(sec);
		return false;
	}
	function loadConfigSection(cat){
		var pars = 'act=sectionlist&config_category='+cat;
		var url = '<?php echo getCurrentUrl(false);?>'
		$Jq.ajax({
			type: "POST",
			url: url,
			data: pars,
			beforeSend:displayLoadingImage(),
			success: function(html){
				$Jq('#selConfigSectionList').html(html);
				hideLoadingImage();
			}
		 });
		return false;
	}
<?php
	if($devManageConfig->isShowPageBlock('block_config_add') || $devManageConfig->isShowPageBlock('block_config_edit'))
		{
?>
	$Jq(document).ready(function(){
		loadConfigSection('<?php echo $devManageConfig->getFormField('config_category');?>');
	});
<?php
		}
?>
</script>
<?php
	}
else
	{
		$devManageConfig->includeAjaxHeader();
	}
//include the content of the page
setTemplateFolder('admin/');
$smartyObj->display('devManageConfig.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
if(!isAjaxPage())
	{
		$devManageConfig->includeFooter();
	}
else
	{
		$devManageConfig->includeAjaxFooter();
	}
?>