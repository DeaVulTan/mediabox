<?php
/**
 * This file hadling the site configuration variables
 *
 * configuration variables used to control the entire site content
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php'); //configurations
$CFG['lang']['include_files'][] = 'languages/%s/admin/editConfigData.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
if(isset($_REQUEST['module']) && !empty($_REQUEST['module']) && $_REQUEST['module'] != 'general'){
	if(!chkAllowedModule(array($_REQUEST['module'])))
		Redirect2URL($CFG['site']['url'].'admin/index.php');
	if(isset($_REQUEST['div']))
		$CFG['site']['is_module_page'] = strtolower($_REQUEST['module']);
}
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');

//-------------- Class editConfigData begins --------------->>>>>//
/**
 * This class hadling the site configuration variables
 *
 * @category	Rayzz
 * @package		Admin
 */
class editConfigData extends FormHandler
	{
		/**
		 * editConfigData::populateConfig()
		 * To populate the config data to edit
		 *
		 * @param  boolean $populate_fileds_data whether Fields value populate or not in edit form
		 * @return 	array
		 * @access 	public
		 */
		public function populateConfig($populate_fileds_data = true)
			{
				$sql = ' SELECT * FROM '.$this->fields_arr['config_table_name'].' WHERE'.
						' config_category = '.$this->dbObj->Param('config_category'). ' AND'.
						' editable = \'Yes\''.
						' ORDER BY config_section_order, edit_order';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->getFormField('cname')));
				if (!$rs)
						trigger_db_error($this->dbObj);

				$populateConfig_arr = array();
				$this->fields_arr['watermark_start_time_id'] = $this->fields_arr['watermark_end_time_id'] = $this->fields_arr['watermark_text_id'] = 0;
				if($rs->PO_RecordCount())
					{
						$temp_section_arr = array();
						while($row = $rs->FetchRow())
							{
								$row['config_section'] = $row['config_section']?$row['config_section']:'General Settings';
								$row['config_section'] = ucfirst(str_replace('_', ' ', $row['config_section']));
								if(isset($temp_section_arr[$row['config_section']]))
									{
										$row['config_section'] = '';
									}
								else
									{
										$temp_section_arr[$row['config_section']] = '';
									}
								$row['label_id'] = 'cvalue_'.$row['config_data_id'];
								if(!$row['description'])
									{
										 $row['description'] = $row['dim1'].' '.$row['dim2'].' '.$row['dim3'].' '.$row['dim4'];
									}
								if($populate_fileds_data)
									{
										$this->fields_arr['cvalue_'.$row['config_data_id']] = $row['config_value'];
									}
								else
									{
										$this->fields_arr['cvalue_'.$row['config_data_id']] = '';
									}
								$populateConfig_arr[$row['config_data_id']] = $row;
								if($this->fields_arr['module'] == 'video')
									{
										$watermark_start_time_dims = array('admin',  'videos', 'watermark_start_time',  '');
										$watermark_end_time_dims = array('admin',  'videos', 'watermark_end_time',  '');
										$watermark_text_dims = array('admin',  'videos', 'watermark_text',  '');



										if(!$this->fields_arr['watermark_start_time_id'] AND $row['dim1'] == $watermark_start_time_dims[0]	AND
											$row['dim2'] == $watermark_start_time_dims[1] AND
											$row['dim3'] == $watermark_start_time_dims[2] AND
											$row['dim4'] == $watermark_start_time_dims[3])
										{
											 $this->fields_arr['watermark_start_time_id'] = $row['config_data_id'];
										}
										if(!$this->fields_arr['watermark_end_time_id'] AND $row['dim1'] = $watermark_end_time_dims[0]	AND
											$row['dim2'] == $watermark_end_time_dims[1] AND
											$row['dim3'] == $watermark_end_time_dims[2] AND
											$row['dim4'] == $watermark_end_time_dims[3])
										{
											 $this->fields_arr['watermark_end_time_id'] = $row['config_data_id'];
										}
										if(!$this->fields_arr['watermark_text_id'] AND $row['dim1'] = $watermark_text_dims[0]	AND
											$row['dim2'] == $watermark_text_dims[1] AND
											$row['dim3'] == $watermark_text_dims[2] AND
											$row['dim4'] == $watermark_text_dims[3])
										{
											 $this->fields_arr['watermark_text_id'] = $row['config_data_id'];
										}
									}

							}
					}
				return $populateConfig_arr;
			}

		/**
		 * editConfigData::resetFieldsArray()
		 * To inirtialize the form fields value
		 *
		 * @return
		 * @access 	public
		 */
		public function resetFieldsArray()
			{
				$this->setFormField('cname', '');
				$this->setFormField('act', '');
			}

		/**
		 * editConfigData::chkIsValidConfigValue()
		 * To validate all the config values
		 *
		 * @return
		 * @access 	public
		 */
		public function chkIsValidConfigValue()
			{
				foreach($this->block_config_edit['populateConfig'] as $key=>$value)
					{
						$label_id = 'cvalue_'.$value['config_data_id'];
						$cfg_value = $this->getFormField($label_id);

						if($cfg_value == '')
							{
								continue;
							}
						switch($value['config_type'])
							{
								case 'Boolean':
									if(!($cfg_value == 0 or $cfg_value == 1))
										{
											$this->setFormFieldErrorTip($label_id, $this->LANG['common_err_tip_compulsory']);
										}
									break;

								case 'Int':
									$this->chkIsNumeric($label_id, $this->LANG['common_err_tip_numeric']);
									break;

								case 'Intwithsymbol':
									$this->chkIsNumericWithSymbol($label_id, $this->LANG['common_err_tip_numeric']);
									break;

								case 'Real':
									$this->chkIsReal($label_id, $this->LANG['common_err_tip_numeric']);
									break;

								case 'Email':
									$this->chkIsValidEmail($label_id, $this->LANG['common_err_tip_invalid_email_format']);
									break;

								case 'Website':
									$this->chkIsValidURL($label_id, $this->LANG['common_err_tip_invalid_url_format']);
									break;
							}
					}
			}

		/**
		 * editConfigData::updateConfigData()
		 * To update the config data
		 *
		 * @return
		 * @access 	public
		 */
		public function updateConfigData()
			{
				$watermark_text = $watermark_end_time = $watermark_start_time = '';
				foreach($this->block_config_edit['populateConfig'] as $key=>$value)
					{
						$label_id = 'cvalue_'.$value['config_data_id'];
						$cfg_value = $this->getFormField($label_id);

						$sql = 'UPDATE '.$this->fields_arr['config_table_name'].' SET'.
								' config_value = '.$this->dbObj->Param('config_value').' WHERE'.
								' config_data_id = '.$this->dbObj->Param('config_data_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($cfg_value, $value['config_data_id']));
							if (!$rs)
								trigger_db_error($this->dbObj);
						if($this->fields_arr['module'] == 'video')
						{
							if($this->fields_arr['watermark_text_id'] == $value['config_data_id'])
							{
								$watermark_text = $cfg_value;
							}
							if($this->fields_arr['watermark_end_time_id'] == $value['config_data_id'])
							{
								$watermark_end_time = $cfg_value;
							}
							if($this->fields_arr['watermark_start_time_id'] == $value['config_data_id'])
							{
								$watermark_start_time = $cfg_value;
							}
						}
					}
				if($this->fields_arr['module'] == 'video' AND $watermark_text AND $watermark_end_time AND $watermark_start_time)
					{
						$this->updateWaterMark($watermark_start_time, $watermark_end_time, $watermark_text);
					}

			}
		public function updateWaterMark($watermark_start_time, $watermark_end_time, $watermark_text)
			{
				$path = $this->CFG['site']['project_path'].'files/watermark/wmark.srt';
				$waterMarkFileContent="1 \n".$watermark_start_time.',000'.' --> '.$watermark_end_time.',000'."\n".$watermark_text;
				$fp = fopen($path, 'w');
				fwrite($fp, $waterMarkFileContent);
				fclose($fp);
			}
	}

//<<<<<-------------- Class editConfigData begins ---------------//
//-------------------- Code begins -------------->>>>>//
$editConfigData = new editConfigData();
$editConfigData->setPageBlockNames(array('block_config_edit'));
//default form fields and values...
$editConfigData->resetFieldsArray();
$editConfigData->setFormField('module', 'general');
$editConfigData->setFormField('config_table_name', 'general');
$editConfigData->setFormField('div', 'general');
$editConfigData->setAllPageBlocksHide();
$editConfigData->setPageBlockShow('block_config_edit'); //default page block. show it. All others hidden
$editConfigData->sanitizeFormInputs($_REQUEST);
$editConfigData->cname_array = array();
$editConfigData->module = $module = $editConfigData->getFormField('module');

$config_file = ($module == 'general') ? 'config_category_arr_'.$module.'.php' :
										$module.'/config_category_arr_'.$module.'.php';
//set category name_arr
if(file_exists($config_file))
	{
		$module = $editConfigData->getFormField('module');
		if($module == 'general')
		{
			$table_name = $CFG['db']['tbl']['config_data'];
			require_once($CFG['site']['project_path'].'admin/config_category_arr_'.$module.'.php');

		}
		else
		{
			$table_name = $CFG['db']['tbl']['config_data'].'_'.$module;
			require_once($CFG['site']['project_path'].'admin/'.$module.'/config_category_arr_'.$module.'.php');
		}
		$editConfigData->setFormField('config_table_name', $table_name);
		$editConfigData->cname_array = $config_category_name_arr[$module];
	}
$editConfigData->makeGlobalize($CFG, $LANG);
if(isAjaxPage())
	{
		if(!($editConfigData->block_config_edit['populateConfig'] = $editConfigData->populateConfig(true)))
			{
				$editConfigData->setAllPageBlocksHide();
				$editConfigData->setCommonErrorMsg($LANG['editconfigdata_no_data_to_edit']);
				$editConfigData->setPageBlockShow('block_msg_form_error');
			}
		if($editConfigData->isFormPOSTed($_POST, 'act') and ($editConfigData->getFormField('act') == 'add_submit'))
			{
				if($CFG['admin']['is_demo_site'])
					{
						$editConfigData->setCommonErrorMsg($LANG['general_config_not_allow_demo_site']);
						$editConfigData->setPageBlockShow('block_msg_form_error');
					}
				else
					{
						$editConfigData->sanitizeFormInputs($_REQUEST);
						$editConfigData->chkIsValidConfigValue();

						if($editConfigData->isValidFormInputs())
							{
								$editConfigData->updateConfigData();
								$editConfigData->setPageBlockShow('block_msg_form_success');
								$editConfigData->setCommonSuccessMsg($LANG['common_success_updated']);
							}
						else
							{
								$editConfigData->setAllPageBlocksHide();
								$editConfigData->setPageBlockShow('block_config_edit');
								$editConfigData->setCommonErrorMsg($LANG['common_msg_error_sorry']);
								$editConfigData->setPageBlockShow('block_msg_form_error');
							}
					}
			}
	}
//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//
$editConfigData->left_navigation_div = 'generalSetting';
if($editConfigData->getFormField('div') && $editConfigData->getFormField('div') != 'general')
{
	$editConfigData->left_navigation_div = $editConfigData->getFormField('div');
}
//include the header file
if(!isAjaxPage())
	{
		$editConfigData->includeHeader();
	}
else
	{
		$editConfigData->LANG['editconfigdata_title'] = $editConfigData->buildDisplayText($editConfigData->LANG['editconfigdata_title'], array('VAR_category'=>ucfirst($module)));
		$editConfigData->includeAjaxHeader();
	}
//include the content of the page
setTemplateFolder('admin/');
$smartyObj->display('editConfigData.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
if(!isAjaxPage())
	{
		$editConfigData->includeFooter();
	}
else
	{
		$editConfigData->includeAjaxFooter();
	}
?>