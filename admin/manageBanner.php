<?php
/**
 * This file hadling the add manageBanners and manage the advertisment
 *
 * banner add, edit, delete, preview and get code functionality included in this file
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/manageBanner.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['admin']['calendar_page'] = true;
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
/**
 * This class hadling the add manageBanners and manage the advertisment
 *
 * @category	Rayzz
 * @package		Admin
 */
class Add extends ListRecordsHandler
	{
		public $edit_mode = false;
		/**
		 * ServerSettingsHandler::buildConditionQuery()
		 * To build the condition query
		 *
		 * @return
		 * @access 	public
		 */
		public function buildConditionQuery()
			{
				global $CFG;
				//TO override admin template settings
				include($CFG['site']['project_path'].'common/configs/config_styles.inc.php');

				$this->sql_condition = '';
				$banners = implode(',', $CFG['admin'][$this->fields_arr['template_name']]['banner']['default_banner_names']);
				if($this->fields_arr['user_name'])
					{
						$this->sql_condition .= 'user_id=\''.addslashes($this->getUserDetail('user_name', $this->fields_arr['user_name'], 'user_id')).'\' AND ';
					}
				if($this->fields_arr['block_search'])
					$this->sql_condition .= 'block=\''.addslashes($this->fields_arr['block_search']).'\' AND ';

				$this->sql_condition .= ' block IN ('.$banners.')';
				$this->sql_condition = substr($this->sql_condition, 0, strrpos($this->sql_condition, 'AND'));
			}

		/**
		 * ServerSettingsHandler::buildSortQuery()
		 * To build the sort query
		 *
		 * @return
		 * @access 	public
		 */
		public function buildSortQuery()
			{
				$this->sql_sort = $this->fields_arr['orderby_field'].' '.$this->fields_arr['orderby'];
			}

		/**
		 * ServerSettingsHandler::insertAdvertisementTable()
		 * To add new advertisement
		 *
		 * @return
		 * @access 	public
		 */
		public function insertAdvertisementTable()
			{
				$start_date = $this->fields_arr['start_date'];
				$end_date = $this->fields_arr['end_date'];
				$this->fields_arr['allowed_impressions'] = $this->fields_arr['allowed_impressions']?$this->fields_arr['allowed_impressions']:0;

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['advertisement'].' SET'.
						' user_id='.$this->CFG['user']['user_id'].','.
						' block='.$this->dbObj->Param('block').','.
						' about='.$this->dbObj->Param('about').','.
						' source='.$this->dbObj->Param('source').','.
						' start_date='.$this->dbObj->Param('start_date').','.
						' end_date='.$this->dbObj->Param('end_date').','.
						' status='.$this->dbObj->Param('status').','.
						' allowed_impressions='.$this->dbObj->Param('allowed_impressions').','.
						' date_added=NOW()';

				$array = array($this->fields_arr['block'], $this->fields_arr['about'],
								$this->fields_arr['source'], $start_date,
								$end_date, $this->fields_arr['status'],
								$this->fields_arr['allowed_impressions']);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $array);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$this->setDefaultValue();
			}

		/**
		 * ServerSettingsHandler::updateAdvertisementTable()
		 * To update the advertisement details
		 *
		 * @return boolean
		 * @access 	public
		 */
		public function updateAdvertisementTable()
			{
				$start_date = $this->fields_arr['start_date'];
				$end_date = $this->fields_arr['end_date'];
				$this->fields_arr['allowed_impressions'] = $this->fields_arr['allowed_impressions']?$this->fields_arr['allowed_impressions']:0;

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['advertisement'].' SET'.
						' block='.$this->dbObj->Param('block').','.
						' about='.$this->dbObj->Param('about').','.
						' source='.$this->dbObj->Param('source').','.
						' start_date='.$this->dbObj->Param('start_date').','.
						' end_date='.$this->dbObj->Param('end_date').','.
						' status='.$this->dbObj->Param('status').','.
						' allowed_impressions='.$this->dbObj->Param('allowed_impressions').
						' WHERE add_id='.$this->dbObj->Param('add_id');

				$array = array($this->fields_arr['block'], $this->fields_arr['about'],
								$this->fields_arr['source'], $start_date,
								$end_date, $this->fields_arr['status'],
								$this->fields_arr['allowed_impressions'], $this->fields_arr['aid']);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $array);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$this->setDefaultValue();
				if($this->dbObj->Affected_Rows())
					return true;
				return false;
			}

		/**
		 * ServerSettingsHandler::deleteAdvertisementTable()
		 * To delete the advertisements
		 *
		 * @return boolean
		 * @access 	public
		 */
		public function deleteAdvertisementTable()
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['advertisement'].' WHERE'.
						' add_id IN('.$this->fields_arr['aid'].')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($this->dbObj->Affected_Rows())
					{
						return true;
					}
				return false;
			}

		/**
		 * ServerSettingsHandler::updateStatusInAdvertisementTable()
		 * To update the advertisements status
		 *
		 * @param  string $status status to updated
		 * @return boolean
		 * @access 	public
		 */
		public function updateStatusInAdvertisementTable($status)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['advertisement'].' SET'.
						' status='.$this->dbObj->Param('status').' WHERE'.
						' add_id IN('.$this->fields_arr['aid'].')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($status));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($this->dbObj->Affected_Rows())
					{
						return true;
					}
				return false;
			}

		/**
		 * ServerSettingsHandler::setDefaultValue()
		 * To initialize the form fields
		 *
		 * @return
		 * @access 	public
		 */
		public function setDefaultValue()
			{
				$this->setFormField('block', '');
				$this->setFormField('about', '');
				$this->setFormField('source', '');
				$this->setFormField('start_date', '');
				$this->setFormField('end_date', '');
				$this->setFormField('status', 'toactivate');
			}

		/**
		 * ServerSettingsHandler::populateAdvertisementValues()
		 * To populate the advertisement details for edit
		 *
		 * @return boolean
		 * @access 	public
		 */
		public function populateAdvertisementValues()
			{
				$sql = 'SELECT block, about, source, start_date, end_date, status,'.
						' allowed_impressions FROM '.$this->CFG['db']['tbl']['advertisement'].' WHERE'.
						' add_id='.$this->dbObj->Param('add_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['aid']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if ($row = $rs->FetchRow())
				    {
				     	$this->setFormField('block', $row['block']);
						$this->setFormField('about', $row['about']);
						$this->setFormField('source', $row['source']);
						$this->setFormField('start_date', $row['start_date']);
						$this->setFormField('end_date', $row['end_date']);
						$this->setFormField('status', $row['status']);
						$this->setFormField('allowed_impressions', $row['allowed_impressions']);
						return true;
				    }
				return false;
			}

		/**
		 * ServerSettingsHandler::populateAdd()
		 * To list out the advertisments
		 *
		 * @return
		 * @access 	public
		 */
		public function populateAdd()
			{
				global $smartyObj;
				$data_arr = array();
				$inc = 0;
				$fields_list = array('name as user_name');
				while($row = $this->fetchResultRecord())
					{
						if(!($uname_arr = $this->getUserDetail('user_id', $row['user_id'])))
							{
								$uname_arr['first_name'] = 'Admin';
								$uname_arr['last_name'] = 'Admin';
								$uname_arr['user_name'] = 'Admin';
							}
						$row = $row+$uname_arr;

						$data_arr[$inc] = $row;
						//$data_arr[$inc]['name'] = getUserDisplayName($row);
						$data_arr[$inc]['name'] = $row['user_name'];
						$data_arr[$inc]['source'] = htmlentitydecode($row['source']);
						$data_arr[$inc]['profile_link']= getUrl('profile', '?uname='.$row['user_name'], $row['user_name'], 'root');
						$data_arr[$inc]['edit_link'] = $this->CFG['site']['url'].'admin/manageBanner.php?act=edt&amp;aid='.$row['add_id'].'&amp;start='.$this->getFormField('start').'&amp;block_search='.$this->getFormField('block_search').'&amp;user_name='.$this->getFormField('user_name');
						$data_arr[$inc]['preview_onclick'] = 'return Confirmation(\'selMsgPreviewWindow\', \'previewForm\', Array(\'selPreviewBanner\'), Array($Jq(\'#selPreview'.$row['add_id'].'\').html()), Array(\'html\'));';
						$inc++;
					}
				$smartyObj->assign('populateAdds_arr', $data_arr);
			}

		/**
		 * ServerSettingsHandler::populatePosition()
		 * To populate the banner position help tip
		 *
		 * @param  array $banner_position banner positions
		 * @return string
		 * @access 	public
		 */
		public function populatePosition($banner_position = array())
			{
				$banner_key = array_keys($banner_position);
				return implode(', ', $banner_key);
			}

		/**
		 * ServerSettingsHandler::sanitizeFormInputs()
		 * To overriding the method in formhandler since url decode is causing issue for ads
		 *
		 * @param  array $request_arr posted form fields list
		 * @return
		 * @access 	public
		 */
		public function sanitizeFormInputs($request_arr) //GET or POST
			{
				global $smartyObj;
				foreach($this->fields_arr as $field_name=>$default_value)
					{
						if (isset($request_arr[$field_name]))
							{
								if (is_string($request_arr[$field_name]))
									{
										$this->fields_arr[$field_name] =htmlspecialchars(trim($request_arr[$field_name]));

										$smartyObj->assign('field_value_'.$field_name, $this->fields_arr[$field_name]);
									}
								  else if (is_array($request_arr[$field_name]))
									{
										foreach($request_arr[$field_name] as $sub_key=>$sub_value)
											{
												$this->fields_arr[$field_name][$sub_key] =htmlspecialchars( urldecode(trim($sub_value)));
												$smartyObj->assign('field_value_'.$field_name.'__'.$sub_key, $this->fields_arr[$field_name][$sub_key]);
											}
									}
								  else //unexpected as of now. if occurred, make a note so as to fix.
								  		trigger_error('Developer Notice: Unexpected field type ('.gettype($request_arr[$field_name]).'). FormHandler needs fix.', E_USER_ERROR);
							}
						  else
						  	{
								$this->fields_arr[$field_name] = $default_value;
								$smartyObj->assign('field_value_'.$field_name, $this->fields_arr[$field_name]);
							}
					}
			}

		/**
		 * ServerSettingsHandler::bannerFormValidation()
		 * To banner edit form validation
		 *
		 * @return
		 * @access 	public
		 */
		public function bannerFormValidation()
			{
				$this->chkIsNotEmpty('block', $this->LANG['common_err_tip_compulsory']);
				$this->chkIsNotEmpty('source', $this->LANG['common_err_tip_compulsory']);
				$this->chkIsNotEmpty('about', $this->LANG['common_err_tip_compulsory']);

				if($this->CFG['admin']['banner']['impressions_date'])
					{
						$this->getFormField('allowed_impressions') and
							$this->chkIsNumeric('allowed_impressions', $this->LANG['common_err_tip_numeric']);

						$this->chkIsNotEmpty('start_date', $this->LANG['common_err_tip_required']) and
							$this->chkIsValidDate('start_date',$this->LANG['manage_banner_err_tip_invalid_date']) and
							($this->edit_mode OR $this->chkIsDateLesserThanNow('start_date', $this->LANG['common_err_tip_date_invalid']));

						$this->chkIsNotEmpty('end_date', $this->LANG['common_err_tip_required']) and
							$this->chkIsValidDate('end_date',$this->LANG['manage_banner_err_tip_invalid_date']) and
							($this->edit_mode OR $this->chkIsDateLesserThanNow('end_date', $this->LANG['common_err_tip_date_invalid']));

						$this->isValidFormInputs() and $this->chkIsFromDateGreaterThanToDate('start_date', $this->getFormField('start_date'), $this->getFormField('end_date'), $this->LANG['manage_banner_err_tip_invalid_date_diff']);
					}
			}
	}
//<<<<<-------------- Class GroupsFormHandler begins ---------------//
//-------------------- Code begins -------------->>>>>//
$Add = new Add();
$Add->setPageBlockNames(array('block_add_advertisement', 'block_list_advertisement', 'block_edit_advertisement', 'block_search'));
//TO override admin template settings
include($CFG['site']['project_path'].'common/configs/config_templates.inc.php');
include($CFG['site']['project_path'].'common/configs/config_styles.inc.php');
//default form fields and values...
$Add->setFormField('aid', '');
$Add->setFormField('act', '');
$Add->setFormField('block', '');
$Add->setFormField('about', '');
$Add->setFormField('source', '');
$Add->setFormField('start_date', '');
$Add->setFormField('end_date', '');
$Add->setFormField('status', 'toactivate');
$Add->setFormField('allowed_impressions', '0');
$Add->setFormField('user_name', '');
$Add->setFormField('block_search', '');

/*********** Page Navigation Start *********/
$Add->setFormField('orderby_field', 'add_id');
$Add->setFormField('orderby', 'DESC');
$Add->setFormField('template_name', $CFG['html']['template']['default']);

$Add->setTableNames(array($Add->CFG['db']['tbl']['advertisement']));
$Add->setReturnColumns(array('add_id', 'block', 'about', 'source',
						'start_date',
						'end_date',
						'IF (status=\'activate\', \'Active\', \'Inactive\') AS status',
						'date_added',
						'allowed_impressions', 'completed_impressions', 'user_id'));

/************ page Navigation stop *************/
$Add->setPageBlockShow('block_add_advertisement');
$Add->setPageBlockShow('block_list_advertisement');
$Add->setPageBlockShow('block_search');
$Add->sanitizeFormInputs($_REQUEST);


if(!isset($CFG['admin'][$Add->getFormField('template_name')]['banner']['default_banner_names']))
	$Add->setFormField('template_name', $CFG['html']['template']['default']);

$banner_details_arr = $CFG['admin'][$Add->getFormField('template_name')]['banner']['default_banner_names'];

if($Add->isFormPOSTed($_POST, 'add_submit'))
	{
		if($CFG['admin']['is_demo_site'])
			{
				$Add->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
				$Add->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				$Add->bannerFormValidation();
				if($Add->isValidFormInputs())
					{
						$Add->insertAdvertisementTable();
						$Add->setPageBlockShow('block_msg_form_success');
						$Add->setCommonSuccessMsg($Add->LANG['manage_banner_success_added']);
					}
				else
					{
						$Add->setPageBlockShow('block_msg_form_error');
						$Add->setCommonErrorMsg($Add->LANG['common_msg_error_sorry']);
					}
			}
	}
if($Add->isFormPOSTed($_POST, 'update_submit'))
	{
		$Add->edit_mode = true;
		if($CFG['admin']['is_demo_site'])
			{
				$Add->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
				$Add->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				$Add->bannerFormValidation();
				if($Add->isValidFormInputs())
					{

								if($Add->updateAdvertisementTable())
									{
										$Add->setPageBlockShow('block_msg_form_success');
										$Add->setCommonSuccessMsg($Add->LANG['manage_banner_success_updated']);
									}
								else
									{
										$Add->setPageBlockShow('block_msg_form_success');
										$Add->setCommonSuccessMsg($Add->LANG['manage_banner_no_changes']);
									}

					}
				else
					{
						$Add->setPageBlockShow('block_msg_form_error');
						$Add->setCommonErrorMsg($Add->LANG['common_msg_error_sorry']);
						$Add->setPageBlockShow('block_edit_advertisement');
					}
			}
	}
else if($Add->isFormPOSTed($_POST, 'cancel_submit'))
	{
		$Add->setDefaultValue();
	}
if ($Add->isFormGETed($_GET, 'act'))
    {
     	if($Add->getFormField('act')=='edt')
			{
				if($Add->populateAdvertisementValues())
					$Add->setPageBlockShow('block_edit_advertisement');
			}
    }
if($Add->isFormPOSTed($_POST, 'act'))
	{
		if($CFG['admin']['is_demo_site'])
			{
				$Add->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
				$Add->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				if($Add->getFormField('act')=='delete')
					{
						if($Add->deleteAdvertisementTable())
							{
								$Add->setPageBlockShow('block_msg_form_success');
								$Add->setCommonSuccessMsg($Add->LANG['manage_banner_success_deleted']);
							}
						else
							{
								$Add->setPageBlockShow('block_msg_form_success');
								$Add->setCommonSuccessMsg($Add->LANG['manage_banner_no_changes']);
							}
					}
				else if($Add->getFormField('act')=='activate')
					{
						if($Add->updateStatusInAdvertisementTable('activate'))
							{
								$Add->setPageBlockShow('block_msg_form_success');
								$Add->setCommonSuccessMsg($Add->LANG['manage_banner_success_activated']);
							}
						else
							{
								$Add->setPageBlockShow('block_msg_form_success');
								$Add->setCommonSuccessMsg($Add->LANG['manage_banner_no_changes']);
							}
					}
				if($Add->getFormField('act')=='toactivate')
					{
						if($Add->updateStatusInAdvertisementTable('toactivate'))
							{
								$Add->setPageBlockShow('block_msg_form_success');
								$Add->setCommonSuccessMsg($Add->LANG['manage_banner_success_toactivated']);
							}
						else
							{
								$Add->setPageBlockShow('block_msg_form_success');
								$Add->setCommonSuccessMsg($Add->LANG['manage_banner_no_changes']);
							}
					}
			}
	}
if($Add->isShowPageBlock('block_list_advertisement'))
	{
		/****** navigtion continue*********/
		$Add->buildSelectQuery();
		$Add->buildConditionQuery();
		$Add->buildSortQuery();
		$Add->buildQuery();
		$Add->executeQuery();

		if(!$Add->isResultsFound())
			{
				$Add->setPageBlockShow('block_msg_form_alert');
				$Add->setPageBlockHide('block_list_advertisement');
				$Add->setCommonAlertMsg($LANG['common_no_records_found']);
			}
	}
$Add->left_navigation_div = 'generalList';
//<<<<<-------------------- Code ends----------------------//

//-------------------- Page block templates begins -------------------->>>>>//
$smartyObj->assign('LANG_LIST_ARR', $LANG_LIST_ARR);

//Reassign Admin Template settings
$CFG['html']['template']['default'] = 'default';
$CFG['html']['stylesheet']['screen']['default'] = 'screen_grey';
$CFG['html']['stylesheet']['screen']['default_file'] = 'screen_grey';
$calendar_options_arr = array('minDate' => '-0Y -0M -0D',
							  'maxDate'	=> '+10Y'
							 );
$smartyObj->assign('calendar_opts_arr', $calendar_options_arr);
//include the header file
$Add->includeHeader();
?>
<script type="text/javascript" language="javascript">

	var block_arr= new Array('selMsgConfirmWindow', 'selCodeForm', 'selMsgPreviewWindow');
	function populateCode(block){
		var codeDetail = "<div>{php}getAdvertisement('"+block+"'){/php}</div>";//"
		var codeTitle = "<?php echo $Add->LANG['manage_banner_code_title'];?>";
		var cd = codeDetail.replace('VAR_BLOCK', block);
		var ct = codeTitle.replace('VAR_BLOCK', block);
		Confirmation('selCodeForm', 'codeForm', Array('codeTitle', 'addCode'), Array(ct, cd), Array('html', 'value'));
		return false;
	}
	var popupWindow = function(){
		var additional = '';
		if(arguments[1])
			additional += ',width='+arguments[1];

		if(arguments[2])
			additional += ',height='+arguments[2];

		window.open (arguments[0], "","status=0,toolbar=0,resizable=0,scrollbars=1"+additional);
		return false;
	}
</script>
<?php
$smartyObj->assign('strating_year', date('Y'));
$smartyObj->assign('ending_year', date('Y')+30);
$Add->deleteForm_hidden_arr = array('start', 'aid', 'act');
$Add->selAddAdvertisementForm_hidden_arr = array('start');
$Add->selAddAdvertisementForm_hidden_arr1 = array('aid', 'user_name', 'block_search');
$Add->confrimation_preview_onclick = 'return Confirmation(\'selMsgPreviewWindow\', \'previewForm\', Array(\'selPreviewBanner\'), Array($Jq(\'#source\').val()), Array(\'html\'));';
if ($Add->isShowPageBlock('block_list_advertisement'))
	{
		$Add->populateAdd();
		$smartyObj->assign('smarty_paging_list', $Add->populatePageLinksGET($Add->getFormField('start'), array('user_name', 'block_search')));
		$smartyObj->assign('delete_submit_onclick', 'if(getMultiCheckBoxValue(\'selListAdvertisementForm\', \'check_all\', \''.$LANG['manage_banner_check_atleast_one'].'\')){Confirmation(\'selMsgConfirmWindow\', \'deleteForm\', Array(\'aid\', \'act\', \'confirmation_msg\'), Array(multiCheckValue, \'delete\', \''.nl2br($LANG['manage_banner_delete_confirmation']).'\'), Array(\'value\', \'value\', \'html\'));}');
		$smartyObj->assign('activate_submit_onclick', 'if(getMultiCheckBoxValue(\'selListAdvertisementForm\', \'check_all\', \''.$LANG['manage_banner_check_atleast_one'].'\')){Confirmation(\'selMsgConfirmWindow\', \'deleteForm\', Array(\'aid\', \'act\', \'confirmation_msg\'), Array(multiCheckValue, \'activate\', \''.nl2br($LANG['manage_banner_activate_confirmation']).'\'), Array(\'value\', \'value\', \'html\'));}');
		$smartyObj->assign('inactivate_submit_onclick', 'if(getMultiCheckBoxValue(\'selListAdvertisementForm\', \'check_all\', \''.$LANG['manage_banner_check_atleast_one'].'\')){Confirmation(\'selMsgConfirmWindow\', \'deleteForm\', Array(\'aid\', \'act\', \'confirmation_msg\'), Array(multiCheckValue, \'toactivate\', \''.nl2br($LANG['manage_banner_toactivate_confirmation']).'\'), Array(\'value\', \'value\', \'html\'));}');
	}

//include the content of the page
setTemplateFolder('admin/');
$smartyObj->display('manageBanner.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
$Add->includeFooter();
?>