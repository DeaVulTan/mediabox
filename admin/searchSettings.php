<?php
/**
 * This file is used for manage Search Settings
 *
 * This file is having Manage set as default search module,status changes, priority change
 *
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 *
 **/
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/searchSettings.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class SearchSettingsHandler begins -------------------->>>>>//
/**
 * This class is used for manage Search Settings
 *
 * @category	Rayzz
 * @package		Admin
 */
class SearchSettingsHandler extends FormHandler
	{
		/**
		 * SearchSettingsHandler::resetFields()
		 * To initialize the form field values
		 *
		 * @return
		 * @access 	public
		 */
		public function resetFields()
			{
				foreach($this->fields_arr as $fields=>$value)
					{
						$this->fields_arr[$fields]='';
					}
			}

		/**
		 * SearchSettingsHandler::populateSearchSettings()
		 * To populate the search settings
		 *
		 * @return array
		 * @access 	public
		 */
		public function populateSearchSettings()
			{
				$populateSearchSettings_arr = array();
				$sql = 'SELECT * FROM '.$this->CFG['db']['tbl']['search_settings'].
						' ORDER BY priority ASC, default_search ASC';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array());
				if (!$rs)
					trigger_db_error($this->dbObj);

				$populateSearchSettings_arr['record_count'] = 0;
				$populateSearchSettings_arr['row'] = array();
				$inc=0;
				while($row = $rs->FetchRow())
					{
						if($row['module'] == 'general' or ((!empty($row['module']) and in_array($row['module'], $this->CFG['site']['modules_arr'])) and chkAllowedModule(array($row['module']))))
							{
								$populateSearchSettings_arr['record_count'] = 1;
								$populateSearchSettings_arr['row'][$inc]['record'] = $row;
								$inc++;
							}
					}

				return $populateSearchSettings_arr;
			}

		/**
		 * SearchSettingsHandler::updateOldPriority()
		 * To update the search priority
		 *
		 * @param  int $Oldpriority old priority
		 * @param  int $Newpriority old new priority
		 * @return
		 * @access 	public
		 */
		public function updateOldPriority($Oldpriority, $Newpriority)
			{
				$sql = 'SELECT id FROM '.$this->CFG['db']['tbl']['search_settings'].
						' WHERE priority = '.$Newpriority;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['search_settings'].' SET priority ='.$this->dbObj->Param('Oldpriority').
						' WHERE id = '.$this->dbObj->Param('id');
				$value_array = array($Oldpriority, $row['id']);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $value_array);
				if (!$rs)
					trigger_db_error($this->dbObj);
			}

		/**
		 * SearchSettingsHandler::changeSearchModulePriority()
		 * To change the search module priority
		 *
		 * @return boolean
		 * @access 	public
		 */
		public function changeSearchModulePriority()
			{
				$id = $this->fields_arr['id'];
				if($this->fields_arr['opt'] == 'up')
					{
						//sub priority..
						$priority = $this->fields_arr['priority']-1;
						if(1<=$priority)
							{
								$this->updateOldPriority($this->fields_arr['priority'], $priority);
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['search_settings'].' SET priority ='.$this->dbObj->Param('priority').
										' WHERE id = '.$this->dbObj->Param('id');
								$value_array = array($priority, $this->fields_arr['id']);

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $value_array);
								if (!$rs)
									trigger_db_error($this->dbObj);

								return true;
							}
						else
							{
								return false;
							}
					}
				elseif($this->fields_arr['opt'] == 'down')
					{
						//Add priority..
						$priority = $this->fields_arr['priority']+1;
						$total  = $this->getTotalPriority();
						if($total >= $priority)
							{
								$this->updateOldPriority($this->fields_arr['priority'], $priority);
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['search_settings'].' SET priority ='.$this->dbObj->Param('priority').
										' WHERE id = '.$this->dbObj->Param('id');

								$value_array = array($priority, $this->fields_arr['id']);
								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $value_array);
								if (!$rs)
									trigger_db_error($this->dbObj);

								return true;
							}
						else
							{
								return false;
							}
					}
			}

		/**
		 * SearchSettingsHandler::getTotalPriority()
		 * To get the total priority
		 *
		 * @return int
		 * @access 	public
		 */
		public function getTotalPriority()
			{
				$sql = 'SELECT COUNT(id) as total FROM '.$this->CFG['db']['tbl']['search_settings'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();

				return $row['total'];
			}

		/**
		 * SearchSettingsHandler::setDefaultSearchModule()
		 * To set default search module
		 *
		 * @return
		 * @access 	public
		 */
		public function setDefaultSearchModule()
			{
				// Set zero all module.
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['search_settings'].
						' SET default_search =0';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				//Set as default module
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['search_settings'].
						' SET default_search = 1'.
						' WHERE id = '.$this->dbObj->Param('id');

				$value_array = array($this->fields_arr['id']);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $value_array);
				if (!$rs)
					trigger_db_error($this->dbObj);
			}

		/**
		 * SearchSettingsHandler::searchSettingsChangeStatus()
		 * To update the search settings status
		 *
		 * @return boolean
		 * @access 	public
		 */
		public function searchSettingsChangeStatus()
			{
				$id = $this->fields_arr['id'];
				$status = $this->fields_arr['status'];
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['search_settings'].' SET status = \''.$status.'\' '.
						'WHERE id IN ('.$id.')' ;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				return true;
			}
	}
$searchSettings = new SearchSettingsHandler();
$searchSettings->setPageBlockNames(array('list_search_settings_block'));
$searchSettings->setFormField('action', '');
$searchSettings->setFormField('opt', '');
$searchSettings->setFormField('priority', '');
$searchSettings->setFormField('id','');
$searchSettings->setFormField('status','');
$searchSettings->setAllPageBlocksHide();
$searchSettings->sanitizeFormInputs($_REQUEST);
$searchSettings->left_navigation_div = 'generalMenu';
$searchSettings->setPageBlockShow('list_search_settings_block');
if($searchSettings->getFormField('action'))
	{
		if($CFG['admin']['is_demo_site'])
			{
				$searchSettings->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
				$searchSettings->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				$searchSettings->setAllPageBlocksHide();
				$searchSettings->setPageBlockShow('list_search_settings_block');
				switch($searchSettings->getFormField('action'))
					{
						case 'priority':
							if($searchSettings->changeSearchModulePriority())
								{
									$searchSettings->setCommonSuccessMsg($LANG['searchsettings_update_successfully']);
									$searchSettings->setPageBlockShow('block_msg_form_success');
								}
							else
								{
									$searchSettings->setCommonErrorMsg($LANG['searchsettings_limit']);
									$searchSettings->setPageBlockShow('block_msg_form_error');
								}
						break;

						case 'default_search':
								$searchSettings->setDefaultSearchModule();
								$searchSettings->setCommonSuccessMsg($LANG['searchsettings_update_successfully']);
								$searchSettings->setPageBlockShow('block_msg_form_success');
						break;

						case 'status':
							$searchSettings->searchSettingsChangeStatus();
							if($searchSettings->getFormField('status') == 'Yes')
								$searchSettings->setCommonSuccessMsg($LANG['searchsettings_active_successfully']);
							else
								$searchSettings->setCommonSuccessMsg($LANG['searchsettings_inactive_successfully']);
							$searchSettings->setPageBlockShow('block_msg_form_success');
						break;
					}
			}
	}
if ($searchSettings->isShowPageBlock('list_search_settings_block'))
	{
		$searchSettings->hidden_arr = array('start', 'status');
		$searchSettings->list_search_settings_block['populateSearchSettings'] = $searchSettings->populateSearchSettings();
	}
$searchSettings->left_navigation_div = 'generalSetting';
$searchSettings->includeHeader();
setTemplateFolder('admin/');
$smartyObj->display('searchSettings.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
?>
<script language="javascript"   type="text/javascript">
	var block_arr= new Array('selMsgConfirm');
</script>
<?php
$searchSettings->includeFooter();
?>