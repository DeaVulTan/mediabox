<?php
/**
 * This file hadling the media server details
 *
 * Media server used for store the uploaded files into media server
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/serverSettings.php';

$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');

if(!(chkAllowedModule(array('media_server')) or chkAllowedModule(array('distributed_encoding'))))
	{
		Redirect2URL(getUrl($CFG['redirect']['dsabled_module_url']['file_name'],'','','root'));
		exit();
	}
//-------------- Class ServerSettingsHandlerFormHandler --------->>>
/**
 * This class hadling the media server details
 *
 * @category	Rayzz
 * @package		Admin
 */
class ServerSettingsHandler extends FormHandler
	{
		/**
		 * ServerSettingsHandler::listServerDetails()
		 * To listout media server details
		 *
		 * @return 	array
		 * @access 	public
		 */
		public function listServerDetails()
			{
				$sql = 'SELECT server_id, server_url, server_for, server_status, ftp_server, ftp_folder,'.
						' ftp_usrename, ftp_password FROM '.$this->CFG['db']['tbl']['server_settings'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$listServerDetails['record'] = array();
				if ($rs->PO_RecordCount())
					{
						$count = 0;
						while($row = $rs->FetchRow())
							{
								$count++;
								$listServerDetails['record'][$count]['row'] = $row;
								$listServerDetails['record'][$count]['onclick'] = 'return Confirmation(\'selMsgConfirm\', \'form_editprofile\', Array(\'selConfirmMsg\', \'action\', \'sid\'), Array(\''.$this->LANG['server_del_confirm_msg'].'\',\'delete\',\''.$row['server_id'].'\'), Array(\'innerHTML\',\'value\', \'value\'));';
								$listServerDetails['record'][$count]['edit'] = $this->getCurrentUrl(false).'?act=edit&sid='.$row['server_id'];
							}

					}
				return $listServerDetails;
			}

		/**
		 * ServerSettingsHandler::addServerDetail()
		 * To add new media server details
		 *
		 * @return 	int
		 * @access 	public
		 */
		public function addServerDetail()
			{
				$sql =  'INSERT INTO ' . $this->CFG['db']['tbl']['server_settings'] .
								' SET server_url = '.$this->dbObj->Param('server_url').
								', server_for = '.$this->dbObj->Param('server_for').
								', server_status = '.$this->dbObj->Param('server_status').
								', ftp_server = '.$this->dbObj->Param('ftp_server').
								', ftp_folder = '.$this->dbObj->Param('ftp_folder').
								', ftp_usrename = '.$this->dbObj->Param('ftp_usrename').
								', ftp_password = '.$this->dbObj->Param('ftp_password').
								', date_added = now()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->getFormField('server_url'), $this->getFormField('server_for'), $this->getFormField('server_status'), $this->getFormField('ftp_server'), $this->getFormField('ftp_folder'), $this->getFormField('ftp_usrename'), $this->getFormField('ftp_password')));
					if (!$rs)
					    trigger_db_error($this->dbObj);

				return $this->dbObj->Insert_ID();
			}

		/**
		 * ServerSettingsHandler::chkIsValidServerID()
		 * To check the whether server id is valid or not
		 *
		 * @param  int $server_id media server id to validate
		 * @return 	boolean
		 * @access 	public
		 */
		public function chkIsValidServerID($server_id)
			{
				if ($server_id == '')
					{
						$this->setCommonErrorMsg($this->LANG['server_err_msg_invalid_server_id']);
						return false;
					}
				$sql = 'SELECT COUNT(server_id) as cnt FROM '.$this->CFG['db']['tbl']['server_settings'].
						' WHERE server_id = \''.addslashes($server_id).'\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if ($row['cnt'] > 0)
					return true;

				$this->setCommonErrorMsg($this->LANG['server_err_msg_invalid_server_id']);
				return false;
			}

		/**
		 * ServerSettingsHandler::getServerDetailsFromDB()
		 * To populate the server details to edit
		 *
		 * @param  array $fields_arr data column list to populate
		 * @param  int $server_id media server id
		 * @return
		 * @access 	public
		 */
		public function getServerDetailsFromDB($fields_arr=array(), $server_id)
			{
				$sql = 'SELECT ';
				foreach($fields_arr as $field_name)
						$sql .= $field_name . ', ';
				$sql = substr($sql, 0, strrpos($sql, ','));
				$sql .= ' FROM '.$this->CFG['db']['tbl']['server_settings'].
						' WHERE server_id=\''.$server_id.'\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$row = array();
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						foreach($fields_arr as $field_name)
							$this->fields_arr[$field_name] = isset($row[$field_name]) ? $row[$field_name] : '';

						$this->fields_arr['sid'] = $server_id;
					}

			}

		/**
		 * ServerSettingsHandler::updateServerDetail()
		 * To update the server details
		 *
		 * @return
		 * @access 	public
		 */
		public function updateServerDetail()
			{
				$sql =  'UPDATE ' . $this->CFG['db']['tbl']['server_settings'] .
								' SET server_url = '.$this->dbObj->Param('server_url').
								', server_for = '.$this->dbObj->Param('server_for').
								', server_status = '.$this->dbObj->Param('server_status').
								', ftp_server = '.$this->dbObj->Param('ftp_server').
								', ftp_folder = '.$this->dbObj->Param('ftp_folder').
								', ftp_usrename = '.$this->dbObj->Param('ftp_usrename').
								', ftp_password = '.$this->dbObj->Param('ftp_password').
								' WHERE server_id = '.$this->dbObj->Param('server_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->getFormField('server_url'), $this->getFormField('server_for'), $this->getFormField('server_status'), $this->getFormField('ftp_server'), $this->getFormField('ftp_folder'), $this->getFormField('ftp_usrename'), $this->getFormField('ftp_password'), $this->getFormField('sid')));
					if (!$rs)
					    trigger_db_error($this->dbObj);
			}

		/**
		 * ServerSettingsHandler::deleteServerDetail()
		 * To delete the server details
		 *
		 * @return
		 * @access 	public
		 */
		public function deleteServerDetail()
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['server_settings'].'
							WHERE server_id = '.$this->dbObj->Param('server_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($this->getFormField('sid')));
					if (!$rs) {
						trigger_db_error($this->dbObj);
					}
			}

		/**
		 * ServerSettingsHandler::chkServerStatus()
		 * To check the server status
		 *
		 * @param  int $server_id media server id
		 * @return boolean
		 * @access 	public
		 */
		public function chkServerStatus($server_id = 0)
			{
				$sql = 'SELECT COUNT(server_id) as cnt FROM '.$this->CFG['db']['tbl']['server_settings'].' WHERE '.
						' server_for = \''.$this->fields_arr['server_for'].'\''.
						' AND server_status = \'Yes\'';
				if ($server_id != 0)
					$sql .= ' AND server_id != \''.$server_id.'\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if ($row['cnt'] == 0)
					return true;
				//$this->setCommonErrorMsg($this->LANG['server_for'].' \''.$this->fields_arr['server_for'].'\''.$this->LANG['server_err_msg_status'].'\''.$this->fields_arr['server_for'].'\'');
				return false;
			}

		/**
		 * ServerSettingsHandler::getActiveServer()
		 * To get the active server details
		 *
		 * @param  array $fields_arr fields to fetch
		 * @param  int $server_id Media server id
		 * @return array
		 * @access 	public
		 */
		public function getActiveServer($fields_arr, $server_id = 0)
			{
				$sql = 'SELECT ';
				foreach($fields_arr as $field_name)
						$sql .= $field_name . ', ';
				$sql = substr($sql, 0, strrpos($sql, ','));
				$sql .= ' FROM '.$this->CFG['db']['tbl']['server_settings'].' WHERE ';
				$sql .= ' server_for = \''.$this->fields_arr['server_for'].'\''.
						' AND server_status = \'Yes\'';
				if ($server_id != 0)
					$sql .= ' AND server_id != \''.$server_id.'\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if (!$rs->PO_RecordCount())
					{
						return false;
					}

				$row = array();
				$row = $rs->FetchRow();
				$ret_fields_arr = array();
				foreach($fields_arr as $field_name)
					$ret_fields_arr[$field_name] = isset($row[$field_name]) ? $row[$field_name] : '';
				return $ret_fields_arr;
			}

		/**
		 * ServerSettingsHandler::setAllServersStatusNO()
		 * To set all the media server status as no, if we add any new media server with 'yes' status for existing modules
		 *
		 * @param  int $server_id Media server id
		 * @param  string $server_for Module name
		 * @return
		 * @access 	public
		 */
		public function setAllServersStatusNO($server_id, $server_for)
			{
				if (!$this->chkIsValidServerID($server_id))
					return false;

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['server_settings'].' SET'.
						' server_status = \'No\' WHERE server_id != \''.$server_id.'\''.
						' AND server_for = \''.$server_for.'\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);
			}

		/**
		 * ServerSettingsHandler::chkIsStatusYes()
		 * To check the media server status
		 *
		 * @param  int $server_id Media server id
		 * @return boolean
		 * @access 	public
		 */
		public function chkIsStatusYes($server_id = 0)
			{
				$sql = 'SELECT COUNT(server_id) as cnt FROM '.$this->CFG['db']['tbl']['server_settings'].' WHERE '.
						' server_status = \'Yes\' AND server_id = \''.$server_id.'\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if ($row['cnt'] == 0)
					return true;
				$this->setCommonErrorMsg('You can\'t Delete the Active Server');
				return false;
			}

		/**
		 * ServerSettingsHandler::emptyTheFieldArray()
		 * To initialize the form fields values
		 *
		 * @return
		 * @access 	public
		 */
		public function emptyTheFieldArray()
			{
				$fields = array('server_id', 'server_url', 'server_status', 'ftp_server',
								'ftp_usrename', 'ftp_password', 'ftp_folder', 'sid');

				foreach($fields as $key=>$value)
					$this->fields_arr[$value] = '';
			}

		/**
		 * ServerSettingsHandler::chkIsValidUrlNew()
		 * To check whether the server url is valid or not
		 *
		 * @param  string $field server url field name
		 * @param  string $err_tip error tip to set if it is failure
		 * @return boolean
		 * @access 	public
		 */
		public function chkIsValidUrlNew($field, $err_tip = '')
			{
				if(!strstr($this->fields_arr[$field], '://'))
					$this->fields_arr[$field] = 'http://'.$this->fields_arr[$field];
				if(substr($this->fields_arr[$field], strlen($this->fields_arr[$field])-1)!='/')
					$this->fields_arr[$field] = $this->fields_arr[$field].'/';

				if (function_exists('curl_init'))
					{
						$ch = @curl_init();
						if ($ch)
						    {
								curl_setopt($ch, CURLOPT_URL, $this->getFormField($field));
								curl_setopt($ch, CURLOPT_HEADER, 0);
								curl_setopt($ch, CURLOPT_NOBODY, 1);
								curl_setopt($ch, CURLOPT_RANGE, "0-1");
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
								curl_setopt($ch, CURLOPT_TIMEOUT, 10);
								$result = curl_exec($ch);
								$errno = curl_errno($ch);
								curl_close($ch);
								if ($errno!=0)
									{
										$this->setFormFieldErrorTip($field, $err_tip);
										return false;
									}
						    }
					}
				return true;
			}

		/**
		 * ServerSettingsHandler::disableChanges()
		 * To disable the edit mode in demo server
		 *
		 * @return boolean
		 * @access 	public
		 */
		public function disableChanges()
			{
				if(strstr($this->CFG['site']['url'], 'Uzdc.in'))
					{
						$this->setCommonErrorMsg('Disabled the page only in development server for security purpose.');
					}
			}
	}
//<<<<<-------------- Class ServerSettingsHandlerFormHandler --------//
//-------------------- Code begins -------------->>>>>//
$serversettings = new ServerSettingsHandler();
$serversettings->setPageBlockNames(array('form_details', 'form_addDetails','form_editDetails','form_delDetails',
										 'form_already_exist_add','form_already_exist_edit','form_already_exist_new','form_already_exist_old'));

$serversettings->setFormField('server_id','');
$serversettings->setFormField('server_url','');
$serversettings->setFormField('server_for','Photos');
$serversettings->setFormField('server_status','No');
$serversettings->setFormField('ftp_server','');
$serversettings->setFormField('ftp_folder','');
$serversettings->setFormField('ftp_usrename','');
$serversettings->setFormField('ftp_password','');
$serversettings->setFormField('action','');
$serversettings->setFormField('ajax_page','');

$serversettings->setFormField('act','');
$serversettings->setFormField('sid','');

$serversettings->setAllPageBlocksHide();
$serversettings->setPageBlockShow('form_details');
$serversettings->setPageBlockShow('form_addDetails');
$serversettings->sanitizeFormInputs($_REQUEST);

if(!isAjaxPage())
	{
		if ($serversettings->isPageGETed($_GET, 'act'))
		    {
				switch($serversettings->getFormField('act'))
					{
						case 'edit':
								if (!$serversettings->chkIsValidServerID($serversettings->getFormField('sid')))
									{
										$serversettings->setCommonErrorMsg($LANG['common_msg_error_sorry']);
										$serversettings->setPageBlockShow('block_msg_form_error');
										$serversettings->setPageBlockShow('form_details');
										break;
									}
								$serversettings->getServerDetailsFromDB(array('server_url', 'server_for', 'server_status', 'ftp_server', 'ftp_folder', 'ftp_usrename', 'ftp_password'),$serversettings->getFormField('sid'));
								$serversettings->setAllPageBlocksHide();
								$serversettings->setPageBlockShow('form_details');
								$serversettings->setPageBlockShow('form_editDetails');
								break;
					} // switch
		    }
		if ($serversettings->isFormPOSTed($_POST, 'add_submit'))
			{
				// Validations
				$serversettings->chkIsNotEmpty('server_url', $LANG['server_err_tip_compulsory']) and
					$serversettings->chkIsValidUrlNew('server_url', $LANG['server_err_tip_not_exist']);
				$serversettings->chkIsNotEmpty('ftp_server', $LANG['server_err_tip_compulsory']);
				$serversettings->chkIsNotEmpty('server_for', $LANG['server_err_tip_compulsory']);
				$serversettings->chkIsNotEmpty('ftp_usrename', $LANG['server_err_tip_compulsory']);
				//if ($serversettings->getFormField('server_status') == 'Yes')
					 //$serversettings->chkServerStatus();
				$serversettings->disableChanges();
				if ($serversettings->isValidFormInputs())
					{
						if (($serversettings->getFormField('server_status') == 'No') or (($serversettings->getFormField('server_status') == 'Yes') and $serversettings->chkServerStatus()))
							{
								if($CFG['admin']['is_demo_site'])
									{
										$serversettings->setCommonErrorMsg($LANG['general_config_not_allow_demo_site']);
										$serversettings->setPageBlockShow('block_msg_form_error');
										$serversettings->emptyTheFieldArray();
									}
								else
									{
										$serversettings->addServerDetail();
										$serversettings->setCommonSuccessMsg($LANG['server_success_msg_add']);
										$serversettings->setPageBlockShow('block_msg_form_success');
										$serversettings->emptyTheFieldArray();
									}

							}
						else
							{
								$serversettings->setCommonErrorMsg($LANG['server_msg_already_exist_add']);
								$serversettings->setAllPageBlocksHide();
								$serversettings->setPageBlockShow('block_msg_form_error');
								$serversettings->setPageBlockShow('form_already_exist_new');
								$serversettings->setPageBlockShow('form_already_exist_add');
								$serversettings->setPageBlockShow('form_already_exist_old');
							}
					}
				else //error in form inputs
					{
						$serversettings->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$serversettings->setPageBlockShow('block_msg_form_error');
					}
			}
		if ($serversettings->isFormPOSTed($_POST, 'add_yes_submit'))
			{
				// Validations
				$serversettings->chkIsNotEmpty('server_url', $LANG['server_err_tip_compulsory']) and
					$serversettings->chkIsValidUrlNew('server_url', $LANG['server_err_tip_not_exist']);
				$serversettings->chkIsNotEmpty('ftp_server', $LANG['server_err_tip_compulsory']);
				$serversettings->chkIsNotEmpty('server_for', $LANG['server_err_tip_compulsory']);
				$serversettings->chkIsNotEmpty('ftp_usrename', $LANG['server_err_tip_compulsory']);

				$serversettings->disableChanges();
				if ($serversettings->isValidFormInputs())
					{
						if($CFG['admin']['is_demo_site'])
							{
								$serversettings->setCommonErrorMsg($LANG['general_config_not_allow_demo_site']);
								$serversettings->setPageBlockShow('block_msg_form_error');
								$serversettings->emptyTheFieldArray();
							}
						else
							{
								$server_id = $serversettings->addServerDetail(array('server_url', 'server_for', 'server_status', 'ftp_server', 'ftp_folder', 'ftp_usrename', 'ftp_password'));
								$serversettings->setAllServersStatusNO($server_id, $serversettings->getFormField('server_for'));
								$serversettings->setCommonSuccessMsg($LANG['server_success_msg_add']);
								$serversettings->setPageBlockShow('block_msg_form_success');
								$serversettings->emptyTheFieldArray();
							}
					}
				else //error in form inputs
					{
						$serversettings->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$serversettings->setPageBlockShow('block_msg_form_error');
					}
			}
		if ($serversettings->isFormPOSTed($_POST, 'add_no_submit'))
			{
				// Validations
				$serversettings->chkIsNotEmpty('server_url', $LANG['server_err_tip_compulsory']) and
					$serversettings->chkIsValidUrlNew('server_url', $LANG['server_err_tip_not_exist']);
				$serversettings->chkIsNotEmpty('ftp_server', $LANG['server_err_tip_compulsory']);
				$serversettings->chkIsNotEmpty('server_for', $LANG['server_err_tip_compulsory']);
				$serversettings->chkIsNotEmpty('ftp_usrename', $LANG['server_err_tip_compulsory']);

				$serversettings->disableChanges();
				if ($serversettings->isValidFormInputs())
					{
						if($CFG['admin']['is_demo_site'])
							{
								$serversettings->setCommonErrorMsg($LANG['general_config_not_allow_demo_site']);
								$serversettings->setPageBlockShow('block_msg_form_error');
								$serversettings->emptyTheFieldArray();
							}
						else
							{
								$serversettings->setFormField('server_status', 'No');
								$serversettings->addServerDetail(array('server_url', 'server_for', 'server_status', 'ftp_server', 'ftp_folder', 'ftp_usrename', 'ftp_password'));
								$serversettings->setCommonSuccessMsg($LANG['server_success_msg_add']);
								$serversettings->setPageBlockShow('block_msg_form_success');
								$serversettings->emptyTheFieldArray();
							}
					}
				else //error in form inputs
					{
						$serversettings->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$serversettings->setPageBlockShow('block_msg_form_error');
					}
			}
		if ($serversettings->isFormPOSTed($_POST, 'edit_submit'))
			{
				// Validations
				$serversettings->chkIsNotEmpty('sid', $LANG['server_err_tip_compulsory']);
				$serversettings->chkIsNotEmpty('server_url', $LANG['server_err_tip_compulsory']) and
					$serversettings->chkIsValidUrlNew('server_url', $LANG['server_err_tip_not_exist']);
				$serversettings->chkIsNotEmpty('ftp_server', $LANG['server_err_tip_compulsory']);
				$serversettings->chkIsNotEmpty('server_for', $LANG['server_err_tip_compulsory']);
				$serversettings->chkIsNotEmpty('ftp_usrename', $LANG['server_err_tip_compulsory']);

				$serversettings->disableChanges();
				if ($serversettings->isValidFormInputs())
					{
						if (($serversettings->getFormField('server_status') == 'No') or (($serversettings->getFormField('server_status') == 'Yes') and $serversettings->chkServerStatus($serversettings->getFormField('sid'))))
						{
							if($CFG['admin']['is_demo_site'])
								{
									$serversettings->setCommonErrorMsg($LANG['general_config_not_allow_demo_site']);
									$serversettings->setPageBlockShow('block_msg_form_error');
									$serversettings->emptyTheFieldArray();
								}
							else
								{
									$serversettings->updateServerDetail();
									$serversettings->setCommonSuccessMsg($LANG['server_success_msg_edit']);
									$serversettings->setPageBlockShow('block_msg_form_success');
									$serversettings->emptyTheFieldArray();
								}
						}
						else
							{
								$serversettings->setAllPageBlocksHide();
								$serversettings->setCommonErrorMsg($LANG['server_msg_already_exist_edit']);
								$serversettings->setPageBlockShow('block_msg_form_error');
								$serversettings->setPageBlockShow('form_already_exist_new');
								$serversettings->setPageBlockShow('form_already_exist_edit');
								$serversettings->setPageBlockShow('form_already_exist_old');
							}
					}
				else //error in form inputs
					{
						$serversettings->setAllPageBlocksHide();
						$serversettings->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$serversettings->setPageBlockShow('block_msg_form_error');
						$serversettings->setPageBlockShow('form_editDetails');
						$serversettings->setPageBlockShow('form_details');
					}
			}
		if ($serversettings->isFormPOSTed($_POST, 'edit_yes_submit'))
			{
				// Validations
				$serversettings->chkIsNotEmpty('server_url', $LANG['server_err_tip_compulsory']) and
					$serversettings->chkIsValidUrlNew('server_url', $LANG['server_err_tip_not_exist']);
				$serversettings->chkIsNotEmpty('ftp_server', $LANG['server_err_tip_compulsory']);
				$serversettings->chkIsNotEmpty('server_for', $LANG['server_err_tip_compulsory']);
				$serversettings->chkIsNotEmpty('ftp_usrename', $LANG['server_err_tip_compulsory']);

				$serversettings->disableChanges();
				if ($serversettings->isValidFormInputs())
					{
						if($CFG['admin']['is_demo_site'])
							{
								$serversettings->setCommonErrorMsg($LANG['general_config_not_allow_demo_site']);
								$serversettings->setPageBlockShow('block_msg_form_error');
								$serversettings->emptyTheFieldArray();
							}
						else
							{
								$serversettings->updateServerDetail();
								$serversettings->setAllServersStatusNO($serversettings->getFormField('sid'), $serversettings->getFormField('server_for'));
								$serversettings->setCommonSuccessMsg($LANG['server_success_msg_edit']);
								$serversettings->setPageBlockShow('block_msg_form_success');
								$serversettings->emptyTheFieldArray();
							}
					}
				else //error in form inputs
					{
						$serversettings->setAllPageBlocksHide();
						$serversettings->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$serversettings->setPageBlockShow('block_msg_form_error');
						$serversettings->setPageBlockShow('form_addDetails');
						$serversettings->setPageBlockShow('form_details');
					}
			}
		if ($serversettings->isFormPOSTed($_POST, 'edit_no_submit'))
			{
				// Validations
				$serversettings->chkIsNotEmpty('server_url', $LANG['server_err_tip_compulsory']) and
					$serversettings->chkIsValidUrlNew('server_url', $LANG['server_err_tip_not_exist']);
				$serversettings->chkIsNotEmpty('ftp_server', $LANG['server_err_tip_compulsory']);
				$serversettings->chkIsNotEmpty('server_for', $LANG['server_err_tip_compulsory']);
				$serversettings->chkIsNotEmpty('ftp_usrename', $LANG['server_err_tip_compulsory']);

				$serversettings->disableChanges();
				if ($serversettings->isValidFormInputs())
					{
						if($CFG['admin']['is_demo_site'])
							{
								$serversettings->setCommonErrorMsg($LANG['general_config_not_allow_demo_site']);
								$serversettings->setPageBlockShow('block_msg_form_error');
								$serversettings->emptyTheFieldArray();
							}
						else
							{
								$serversettings->setFormField('server_status', 'No');
								$serversettings->updateServerDetail();
								$serversettings->setCommonSuccessMsg($LANG['server_success_msg_edit']);
								$serversettings->setPageBlockShow('block_msg_form_success');
								$serversettings->emptyTheFieldArray();
							}
					}
				else //error in form inputs
					{
						$serversettings->setAllPageBlocksHide();
						$serversettings->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$serversettings->setPageBlockShow('block_msg_form_error');
						$serversettings->setPageBlockShow('form_addDetails');
						$serversettings->setPageBlockShow('form_details');
					}
			}
		if ($serversettings->isFormPOSTed($_POST, 'act_submit'))
			{
				if($serversettings->getFormField('action')=='delete')
					{
						$serversettings->chkIsNotEmpty('sid', $LANG['server_err_tip_compulsory']);
						$serversettings->disableChanges();
						if ($serversettings->isValidFormInputs())
							{
								if($CFG['admin']['is_demo_site'])
									{
										$serversettings->setCommonErrorMsg($LANG['general_config_not_allow_demo_site']);
										$serversettings->setPageBlockShow('block_msg_form_error');
										$serversettings->emptyTheFieldArray();
									}
								else
									{
										$serversettings->deleteServerDetail();
										$serversettings->setCommonSuccessMsg($LANG['server_success_msg_delete']);
										$serversettings->setPageBlockShow('block_msg_form_success');
									}
							}
						else //error in form inputs
							$serversettings->setPageBlockShow('block_msg_form_error');
					}
			}
		if ($serversettings->isFormPOSTed($_POST, 'cancel'))
			{
				$serversettings->emptyTheFieldArray();
			}
	}
else
	{
		$serversettings->setHeaderStart();
		$serversettings->setHeaderEnd();
		exit;
	}
//<<<<--------------------Code Ends----------------------//
if ($serversettings->isShowPageBlock('form_details'))
	{
		$serversettings->form_details['listServerDetails'] = $serversettings->listServerDetails();
	}
if ($serversettings->isShowPageBlock('form_already_exist_old'))
	{
		$serversettings->form_already_exist_old['curr_active'] = $serversettings->getActiveServer(array('server_id','server_url', 'server_for', 'server_status', 'ftp_server', 'ftp_folder', 'ftp_usrename', 'ftp_password'));
	}
//--------------------Page block templates begins-------------------->>>>>//
$serversettings->modules_arr=array('video', 'music', 'photo');
/*foreach ($CFG['site']['media_server_for'] as $key=>$value)
	{
	   $serversettings->modules_arr[$value]=$value;
	}*/
$serversettings->left_navigation_div = 'generalSetting';
// Title of the page
$serversettings->includeHeader();
setTemplateFolder('admin');
?>
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgConfirm');
</script>

<?php
$smartyObj->display('serverSettings.tpl');
$serversettings->includeFooter();
?>