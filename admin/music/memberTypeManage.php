<?php
/**
 * This file is use for admin manage user profile
 *
 * This file is having manage user profile
 *
 *
 * @category	Rayzz
 * @package		Admin
 *
 **/
require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/memberManage.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/countries_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/gender_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/months_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/search_list_array.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_GeneralActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['site']['is_module_page'] = 'music';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class AdvanceSearchHandler begins -------------------->>>>>//
/**
 *
 * @category	rayzz
 * @package		Admin
 **/
class AdvanceSearchHandler extends ListRecordsHandler
	{
		public $linkFieldsArray = array();
		public $isVideoModule = false;
		public $countriesListArr = array();
		public $module_array = array();

		/**
		 * AdvanceSearchHandler::isVideoModule()
		 *
		 * @return
		 */
		public function isVideoModule()
			{
				return $this->isVideoModule;
			}

		/**
		 * AdvanceSearchHandler::isGroupModule()
		 *
		 * @return
		 */
		public function isGroupModule()
			{
				return $this->isGroupModule;
			}

		/**
		 * AdvanceSearchHandler::displayThisMemberRecord()
		 *
		 * @param array $row
		 * @return
		 */
		public function displayThisMemberRecord($row = array())
			{
				$displayThisMemberRecord_arr = array();
				$displayThisMemberRecord_arr['record'] = $row;
				$displayThisMemberRecord_arr['user_id'] = $row['user_id'];
				$displayThisMemberRecord_arr['icon'] = getMemberAvatarDetails($row['icon_id'], $row['icon_type'],$row['user_id'],$row['image_ext']);
				$StatusToActivate =	$StatusOk = $StatusLocked = false;
				$displayThisMemberRecord_arr['status'] = $row['usr_status'];
				$displayThisMemberRecord_arr['accountStatus'] = $displayThisMemberRecord_arr['status'];
				$displayThisMemberRecord_arr['status_var'] = 'Status'.$displayThisMemberRecord_arr['status'];
				$displayThisMemberRecord_arr['status_var'] = $$displayThisMemberRecord_arr['status_var'] 		=	 true;
				$displayThisMemberRecord_arr['cssRowClass'] = $cssRowClass = $row['css_row_class'];
				$displayThisMemberRecord_arr['userClass'] = $userClass = 'UserClass'.$displayThisMemberRecord_arr['user_id'];
				$displayThisMemberRecord_arr['search'] = $search = $this->fields_arr['search'];
				$displayThisMemberRecord_arr['sessionSearchQueryString'] = $sessionSearchQueryString = '';
				$displayThisMemberRecord_arr['start'] = $this->fields_arr['start'];
				if ($displayThisMemberRecord_arr['search'])
					$displayThisMemberRecord_arr['sessionSearchQueryString'] = $sessionSearchQueryString = '&amp;search='.$displayThisMemberRecord_arr['search'];
				if ($displayThisMemberRecord_arr['start'])
					$displayThisMemberRecord_arr['sessionSearchQueryString'] = $sessionSearchQueryString = '&amp;start='.$displayThisMemberRecord_arr['start'];
				$displayThisMemberRecord_arr['memberProfileUrl'] = '../viewProfile.php?user_id='.$row['user_id'];
				$displayThisMemberRecord_arr['statusChangeLink'] = 'memberTypeManage.php?uid='.$displayThisMemberRecord_arr['user_id'].$sessionSearchQueryString.'&amp;action=';
				$displayThisMemberRecord_arr['country'] = $country = isset($this->countriesListArr[$row['country']])?$this->countriesListArr[$row['country']]:'';
				$displayThisMemberRecord_arr['anchor'] = 'uAnchor_'.$displayThisMemberRecord_arr['user_id'];
				$displayThisMemberRecord_arr['age'] = $row['age'];
				$displayThisMemberRecord_arr['age'] = (is_numeric($displayThisMemberRecord_arr['age']) and ($displayThisMemberRecord_arr['age'] > 0 ))?$displayThisMemberRecord_arr['age']:'';
				$row['age'] = $displayThisMemberRecord_arr['age'];
				$displayThisMemberRecord_arr['activateLink'] = $displayThisMemberRecord_arr['deActivateLink'] = $displayThisMemberRecord_arr['deleteLink'] = false;
				$displayThisMemberRecord_arr['accountStatus'] = '';
				if ($StatusToActivate || $StatusLocked)
					{
						$displayThisMemberRecord_arr['activateLink'] = $activateLink = true;
						if ($StatusToActivate)
							$displayThisMemberRecord_arr['accountStatus'] = '<span class="clsUserStatusInActive">'.$this->LANG['search_results_label_status_to_activate'].'</span>';
						else
								$displayThisMemberRecord_arr['accountStatus'] = '<span class="clsUserStatusLocked">'.$this->LANG['search_results_label_status_locked'].'</span>';
					}
				if ($StatusOk)
					{
						$displayThisMemberRecord_arr['deActivateLink'] = true;
						$displayThisMemberRecord_arr['accountStatus'] = '<span class="clsUserStatusActive">'.$this->LANG['search_results_label_status_ok'].'</span>';
					}
				return 	$displayThisMemberRecord_arr;
			}

	   /**
		* Displays all members with their profile icon
		*
		* @return void
		* @access public
		**/
	   public function displayMembers()
			{
				$displayMembers_arr = array();
				$displayMembers_arr['record_count'] = 0;
				$inc = 0;
				$jnc = 0;
				$displayMembers_arr['row'] = array();
				while($row = $this->fetchResultRecord())
					{
						$displayMembers_arr['record_count'] = 1;
						$row['css_row_class'] = $this->getCSSRowClass();
						$displayMembers_arr['row'][$inc] = $this->displayThisMemberRecord($row);
						//all module on/off Dynamic code..
						foreach($this->CFG['site']['modules_arr'] as $value)
							{
								$displayMembers_arr['row'][$inc]['modules_arr'][$jnc]['lang'] ='';
								$displayMembers_arr['row'][$inc]['modules_arr'][$jnc]['total_upload'] = '';
								if(chkAllowedModule(array(strtolower($value))))
									{
										$get_user_upload_total = 'getTotal'.ucfirst($value).'s';
										if(function_exists($get_user_upload_total))
											{
												$common_language = 'common_'.$value.'s';
												$displayMembers_arr['row'][$inc]['modules_arr'][$jnc]['lang']  = $this->LANG[$common_language];
												$displayMembers_arr['row'][$inc]['modules_arr'][$jnc]['total_upload']  = $get_user_upload_total($row['user_id']);
												$jnc++;
											}
									}
							}

						$inc++;
					} // while
				/*echo '<pre>';
				print_r($displayMembers_arr);
				echo '</pre>';*/
				return $displayMembers_arr;
			}

		/**
		 * AdvanceSearchHandler::isEmpty()
		 *
		 * @param mixed $value
		 * @return
		 */
		public function isEmpty($value)
			{
				$is_not_empty = is_string($value)?trim($value)=='':empty($value);
				return $is_not_empty;
			}

		/**
		 * AdvanceSearchHandler::buildSortQuery()
		 *
		 * @return
		 */
		public function buildSortQuery()
			{
				$this->sql_sort = '';
				$sort = $this->fields_arr['sort_field'];
				$orderBy = $this->fields_arr['sort_field_order_by'];
				if ($sort AND $orderBy)
					{
						$this->sql_sort = ' '.$sort.' '.$orderBy;
					}
			}

		/**
		 * AdvanceSearchHandler::buildConditionQuery()
		 *
		 * @return
		 */
		public function buildConditionQuery()
			{
				$this->sql_condition = ' usr_status!=\'Deleted\' ';
				if (!$this->isEmpty($this->fields_arr['uname']))
					{
						$this->sql_condition .= ' AND user_name LIKE \'%'.addslashes($this->fields_arr['uname']).'%\' ';
		//					$this->linkFieldsArray[] = 'uname';
					}
				if (!$this->isEmpty($this->fields_arr['email']))
					{
						$this->sql_condition .= ' AND email LIKE \'%'.addslashes($this->fields_arr['email']).'%\' ';
		//					$this->linkFieldsArray[] = 'email';
					}
				if (!$this->isEmpty($this->fields_arr['fname']))
					{
						$this->sql_condition .= ' AND first_name LIKE \'%'.addslashes($this->fields_arr['fname']).'%\' ';
		//					$this->linkFieldsArray[] = 'fname';
					}
				if (!$this->isEmpty($this->fields_arr['tagz']) AND $this->canSearchWithTag())
					{
						$this->sql_condition .= ' AND '.getSearchRegularExpressionQueryModified($this->fields_arr['tagz'], 'profile_tags', '');
						$this->sql_sort = 'user_id DESC ';
		//					$this->linkFieldsArray[] = 'tagz';
					}
				if (!$this->isEmpty($this->fields_arr['sex']))
					{
						$this->sql_condition .= ' AND sex=\''.addslashes($this->fields_arr['sex']).'\' ';
		//					$this->linkFieldsArray[] = 'sex';
					}

				if (!$this->isEmpty($this->fields_arr['country']))
					{
						$this->sql_condition .= ' AND country=\''.addslashes($this->fields_arr['country']).'\' ';
		//					$this->linkFieldsArray[] = 'country';
					}

				if (!$this->isEmpty($this->fields_arr['hasFriends']))
					{
						$this->sql_condition .= ' AND total_friends > 0';
		//					$this->linkFieldsArray[] = 'hasFriends';
					}
				if (!$this->isEmpty($this->fields_arr['doj_start']))
					{
						$dojStart  = $this->fields_arr['doj_start'];
						$this->sql_condition .= ' AND doj >= \''.addslashes($dojStart).'\'';
					}

				if (!$this->isEmpty($this->fields_arr['doj_end']))
					{
						$dojEnd  = $this->fields_arr['doj_end'];
						$this->sql_condition .= ' AND doj <= \''.addslashes($dojEnd).'\'';
					}

				if (!$this->isEmpty($this->fields_arr['login_start']))
					{
						$loginStart  = $this->fields_arr['login_start'];
						$this->sql_condition .= ' AND last_logged >= \''.addslashes($loginStart).'\'';
					}
				if (!$this->isEmpty($this->fields_arr['login_end']))
				{
					$loginEnd  = $this->fields_arr['login_end'];
					$this->sql_condition .= ' AND last_logged <= \''.addslashes($loginEnd).'\'';
				}

				//Dynamic on/off module coding..
				foreach($this->module_array as $value)
					{
						$field_name  = $value['field_name'];
						$table_field_name  = $value['table_field_name'];
						if (!$this->isEmpty($this->fields_arr[$field_name]))
							{
								$this->sql_condition .= ' AND '.$table_field_name.' > 0';
							}
					}

				if (!$this->isEmpty($this->fields_arr['search']))
					{
						$this->linkFieldsArray[] = 'search';
					}
				if($this->fields_arr['user_type']!='')
					{
						$this->sql_condition .= ' AND is_paid_member = \''.$this->fields_arr['user_type'].'\'';
					}
				$statusOk = $this->fields_arr['user_status_Ok'];
				$statusDeActivate = $this->fields_arr['user_status_ToActivate'];
				$statusLocked = $this->fields_arr['user_status_Locked'];
				if ($statusOk OR $statusDeActivate OR $statusLocked)
					{
						$statusCondition = '( 0 ';
						$statusCondition .= $statusOk?' OR usr_status=\'Ok\'':'';
						$statusCondition .= $statusDeActivate?' OR usr_status=\'ToActivate\'':'';
						$statusCondition .= $statusLocked?' OR usr_status=\'Locked\'':'';
						$statusCondition .= ')';
						$this->sql_condition .= ' AND '.$statusCondition;
					}
			}

		/**
		 * AdvanceSearchHandler::canSearchWithTag()
		 *
		 * @return
		 */
		public function canSearchWithTag()
			{
				$tagz = $this->fields_arr['tagz'];
				$tagz = trim($tagz);
				$return  = false;
				if ($tagz)
					{
						$length = strlen($tagz);
						if ($length > 2)
							{
								$return = true;
							}
					}
				return $return;
			}

		/**
		 * AdvanceSearchHandler::getAllCountryNames()
		 *
		 * @param array $lang_list_country
		 * @return
		 */
		public function getAllCountryNames($lang_list_country = array())
			{
				$countriesList = array();
				$sql = 'SELECT DISTINCT country FROM '.$this->CFG['db']['tbl']['users'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$row = array();
				if ($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$countriesList[$row['country']] = isset($lang_list_country[$row['country']])?$lang_list_country[$row['country']]:$row['country'];
							} // while
					}
				return $countriesList;
			}

		/**
		 * AdvanceSearchHandler::checkDateFieldSets()
		 *
		 * @return
		 */
		public function checkDateFieldSets()
			{
				$doj_s_d = $this->fields_arr['doj_s_d'];
				$doj_s_m = $this->fields_arr['doj_s_m'];
				$doj_s_y = $this->fields_arr['doj_s_y'];

				$doj_e_d = $this->fields_arr['doj_e_d'];
				$doj_e_m = $this->fields_arr['doj_e_m'];
				$doj_e_y = $this->fields_arr['doj_e_y'];

				$login_s_d = $this->fields_arr['login_s_d'];
				$login_s_m = $this->fields_arr['login_s_m'];
				$login_s_y = $this->fields_arr['login_s_y'];

				$login_e_d = $this->fields_arr['login_e_d'];
				$login_e_m = $this->fields_arr['login_e_m'];
				$login_e_y = $this->fields_arr['login_e_y'];

				$dateFields = array();
				//$dateFields = array('doj_s_y', 'doj_s_m', 'doj_s_d', 'doj_e_y', 'doj_e_m', 'doj_e_d', 'login_s_y', 'login_s_m', 'login_s_d');
				if ($doj_s_d and $doj_s_m and $doj_s_y)
					{
						$doj_start = sprintf("%04d-%02d-%02d 00:00", $doj_s_y, $doj_s_m,$doj_s_d);
						$this->fields_arr['doj_start'] 	= $doj_start;
						$dateFields[] = 'doj_start';
						$dateFields[] = 'doj_s_y';
						$dateFields[] = 'doj_s_m';
						$dateFields[] = 'doj_s_d';
					}
				if ($doj_e_d and $doj_e_m and $doj_e_y)
					{
						$doj_end = sprintf("%04d-%02d-%02d 00:00", $doj_e_y, $doj_e_m,$doj_e_d);
						$this->fields_arr['doj_end'] 	= $doj_end;
						$dateFields[] = 'doj_end';
						$dateFields[] = 'doj_e_y';
						$dateFields[] = 'doj_e_m';
						$dateFields[] = 'doj_e_d';
					}
				if ($login_s_d and $login_s_m and $login_s_y)
					{
						$login_start = sprintf("%04d-%02d-%02d 00:00", $login_s_y, $login_s_m,$login_s_d);
						$this->fields_arr['login_start'] 	= $login_start;
						$dateFields[] = 'login_start';
						$dateFields[] = 'login_s_y';
						$dateFields[] = 'login_s_m';
						$dateFields[] = 'login_s_d';
					}
				if ($login_e_d and $login_e_m and $login_e_y)
					{
						$login_end = sprintf("%04d-%02d-%02d 00:00", $login_e_y, $login_e_m,$login_e_d);
						$this->fields_arr['login_end'] 	= $login_end;
						$dateFields[] = 'login_end';
						$dateFields[] = 'login_e_y';
						$dateFields[] = 'login_e_m';
						$dateFields[] = 'login_e_d';
					}
				return $dateFields;
			}

		/**
		 * AdvanceSearchHandler::storeSearchFieldsInSession()
		 *
		 * @return
		 */
		public function storeSearchFieldsInSession()
			{
				$dateFields = $this->checkDateFieldSets();
				$requiredFields = array('email', 'uname', 'fname', 'tagz', 'sex', 'country', 'hasVideos', 'sort_field', 'sort_field_order_by' , 'user_status_Ok', 'user_status_ToActivate', 'user_status_Locked', 'user_type','');
					//Dynamic on/off module coding..
				foreach($this->CFG['site']['modules_arr'] as $value)
					{
						if(chkAllowedModule(array(strtolower($value))))
							$requiredFields[]  = 'has'.ucfirst($value).'s';
					}
				$requiredFields = array_merge($requiredFields, $dateFields);
				$givenOptions  = array();
				foreach($requiredFields as $fieldName)
					{
						if ($fieldValue =  trim($this->fields_arr[$fieldName]))
							{
								$givenOptions[$fieldName] = $fieldValue;
							}
					}
				$sessionKey = 0;
				if ($givenOptions)
					{
						$sessionVar = serialize($givenOptions);
						$sessionKey = $this->generateSessionKeyToStoreOptions();
						$_SESSION['admin']['member_search'][$sessionKey] = $sessionVar;
						$this->setIndirectFormField('search', $sessionKey);
					}
				return $sessionKey;
			}

		/**
		 * AdvanceSearchHandler::generateSessionKeyToStoreOptions()
		 *
		 * @return
		 */
		public function generateSessionKeyToStoreOptions()
			{
				$searchKeysUsed = $_SESSION['admin']['member_search'];
				if (count($_SESSION['admin']['member_search']) > 10)
					{
						$_SESSION['admin']['member_search'] = array();
					}
				$usedKeys = 0;
				if ($searchKeysUsed)
					{
						$searchKeysUsed = array_flip($searchKeysUsed);
						$usedKeys = max($searchKeysUsed);
					}
				if (!$usedKeys)
					{
						$usedKeys = time();
					}
				$key = $usedKeys + 1;
				return $key;
			}

		/**
		 * AdvanceSearchHandler::getUserDetailsArrFromDB()
		 *
		 * @param mixed $table_name
		 * @param array $fields_arr
		 * @param array $alias_fields_arr
		 * @return
		 */
		public function getUserDetailsArrFromDB($table_name, $fields_arr=array(), $alias_fields_arr=array())
			{
				$sql = 'SELECT ';
				foreach($fields_arr as $field_name)
						$sql .= $field_name . ', ';
				$sql = substr($sql, 0, strrpos($sql, ','));
				$sql .= ' FROM '.$table_name.
						' WHERE user_id='.$this->dbObj->Param($this->fields_arr['user_id']);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id']));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$row = array();
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
					}
				$ret_fields_arr = array();
				$fields_arr = array_merge($fields_arr, $alias_fields_arr);
				foreach($fields_arr as $field_name)
					$ret_fields_arr[$field_name] = isset($row[$field_name]) ? $row[$field_name] : '';
				$rs->Free();
				return $ret_fields_arr;
			}

		public function changeUserStatus($field)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
						' SET '.$field.' = '.$this->dbObj->Param('ch_status').' WHERE user_id = '.$this->dbObj->Param('uid');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['ch_status'], $this->fields_arr['uid']));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}

		public function generateModuleFields()
			{
				global $CFG;
				//Dynamic on/off module coding..
				$inc = 0;
				foreach($CFG['site']['modules_arr'] as $value)
					{
						if(chkAllowedModule(array(strtolower($value))))
							{
								$field_name = 'has'.ucfirst($value).'s';
								$table_field_name = 'total_'.$value.'s';
								if(isset($this->LANG['membermanage_search_with_'.$value.'s']))
									{
										$this->module_array[$inc]['field_name'] = $field_name;
										$this->module_array[$inc]['table_field_name']  = $table_field_name;
										$this->module_array[$inc]['lang_value'] = $this->LANG['membermanage_search_with_'.$value.'s'];
										$this->module_array[$inc]['lang_value'] = '';
										$this->module_array[$inc]['lang_value'] = $this->LANG['membermanage_search_with_'.$value.'s'];
										$this->setFormField($field_name, '');
										$inc++;
									}
							}
					}
			}


		/**
		 * AdvanceSearchHandler::setGeneralActivityHandlerObject()
		 *
		 * @param string $obj
		 * @return
		 */
		public function setGeneralActivityHandlerObject($obj='')
		{
			$this->GeneralActivityObj = $obj;
		}


	}
//<<<<<---------------class AdvanceSearchHandler------///
//--------------------Code begins-------------->>>>>//
$searchfrm = new AdvanceSearchHandler();
$searchfrm->setPageBlockNames(array('msg_form_user_details_updated' , 'form_search','form_list_members', 'form_no_records_found', 'form_change_status'));
// To set the DB object
$searchfrm->setDBObject($db);
$searchfrm->setAllPageBlocksHide();
$searchfrm->setPageBlockShow('form_search');
/*$searchfrm->makeGlobalize($CFG, $LANG);*/

$searchfrm->setFormField('start', '0');
$searchfrm->isVideoModule = chkAllowedModule(array('video'));
//Search Form Fields
$searchfrm->setFormField('email', '');
$searchfrm->setFormField('uname', '');
$searchfrm->setFormField('fname', '');
$searchfrm->setFormField('tagz', '');
$searchfrm->setFormField('sex', '');
$searchfrm->setFormField('hasFriends', '');
$searchfrm->setFormField('hasGroups', '');
$searchfrm->setFormField('country', '');
$searchfrm->setFormField('withPhotoVideoFriends', '');
$searchfrm->setFormField('search' ,'');
$searchfrm->setFormField('uid' ,'');
$searchfrm->setFormField('action' ,'');
$searchfrm->setFormField('is_affiliate_type' ,'');
$searchfrm->setFormField('featured_description' ,'');
$searchfrm->setFormField('doj_start', '');
$searchfrm->setFormField('doj_s_d' ,'');
$searchfrm->setFormField('doj_s_m' ,'');
$searchfrm->setFormField('doj_s_y' ,'');
$searchfrm->setFormField('doj_end', '');
$searchfrm->setFormField('doj_e_d' ,'');
$searchfrm->setFormField('doj_e_m' ,'');
$searchfrm->setFormField('doj_e_y' ,'');
$searchfrm->setFormField('login_start', '');
$searchfrm->setFormField('login_end', '');
$searchfrm->setFormField('login_s_d' ,'');
$searchfrm->setFormField('login_s_m' ,'');
$searchfrm->setFormField('login_s_y' ,'');
$searchfrm->setFormField('login_e_d' ,'');
$searchfrm->setFormField('login_e_m' ,'');
$searchfrm->setFormField('login_e_y' ,'');
$searchfrm->setFormField('user_status_Ok', '');
$searchfrm->setFormField('user_status_ToActivate', '');
$searchfrm->setFormField('user_status_Locked', '');
$searchfrm->setFormField('sort_field', 'user_id');
$searchfrm->setFormField('sort_field_order_by', 'DESC');
$searchfrm->setFormField('act', '');
$searchfrm->setFormField('ch_status', '');
$searchfrm->setFormField('user_type', '');
$searchfrm->setFormField('numpg', $CFG['data_tbl']['numpg']);

$searchfrm->generateModuleFields();
$searchfrm->sanitizeFormInputs($_POST);
$searchfrm->countriesListArr = $LANG_LIST_ARR['countries'];
$searchfrm->setMonthsListArr($LANG_LIST_ARR['months']);
$searchfrm->setYearsListMinMax(date('Y')-1, date('Y'));
$searchfrm->setCountriesListArr($searchfrm->getAllCountryNames($LANG_LIST_ARR['countries']),
							array('' => $LANG['search_country_choose'])
							);

$searchfrm->setCSSAlternativeRowClasses($CFG['data_tbl']['css_alternative_row_classes']);
$searchfrm->setMinRecordSelectLimit(2);
$searchfrm->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$searchfrm->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$searchfrm->setTableNames(array($CFG['db']['tbl']['users']));
$searchfrm->setReturnColumns(array('user_id', 'user_name', 'sex', 'music_user_type','first_name', 'allow_article', 'last_name', 'email' , 'age' , 'total_videos', 'total_friends', 'total_groups' , 'doj', 'last_logged' , 'profile_tags', 'tag_match', 'icon_id', 'icon_type', 'image_ext','usr_status', 'last_logged', 'city', 'postal_code', 'country', 'featured', 'is_affiliate_type', 'is_upload_background_image', 'is_paid_member'));
$searchfrm->setPageBlockShow('form_list_members');

if($CFG['admin']['show_recent_activities'])
{
	$GeneralActivity = new GeneralActivityHandler();
	$searchfrm->setGeneralActivityHandlerObject($GeneralActivity);
}

if (!isset($_SESSION['admin']['member_search']))
    {
        $_SESSION['admin']['member_search'] = array();
    }
if ($searchfrm->isPageGETed($_GET, 'start'))
    {
		$searchfrm->sanitizeFormInputs($_GET);
    }

if ($searchfrm->isFormPOSTed($_POST, 'act'))
    {

		$searchfrm->sanitizeFormInputs($_POST);
		switch($searchfrm->getFormField('act'))
			{
				case 'music_user_type':
						$searchfrm->changeUserStatus('music_user_type');
				break;
			}
		$searchfrm->setPageBlockShow('block_msg_form_success');
		$searchfrm->setCommonSuccessMsg($LANG['successful_update_message']);
	}
if ($searchfrm->isFormPOSTed($_POST, 'search_submit'))
    {
		$searchfrm->sanitizeFormInputs($_POST);
		$searchfrm->setIndirectFormField('search', '');
		$searchfrm->storeSearchFieldsInSession();
		$search = $searchfrm->getFormField('search');
		if ($search)
			Redirect2Url('memberTypeManage.php?search='.$search);
	}
if ($searchfrm->isFormPOSTed($_POST, 'search_submit_reset'))
	$_SESSION['admin']['member_search'] = array();
if ($searchfrm->isPageGETed($_GET, 'search'))
    {
        $searchfrm->sanitizeFormInputs($_GET);
		$search = $searchfrm->getFormField('search');
		if ($search AND isset($_SESSION['admin']['member_search'][$search]) AND $searchOptions=$_SESSION['admin']['member_search'][$search])
		    {
		        $searchOptions = unserialize($searchOptions);
				$searchfrm->sanitizeFormInputs($searchOptions);
		    }
    }
$tagMatchAlias = $searchfrm->canSearchWithTag()?getSearchRegularExpressionQueryModified($searchfrm->getFormField('tagz'), 'profile_tags', ''):'1';
$searchfrm->setReturnColumnsAliases(array(
			'doj'		=> 'DATE_FORMAT(doj, \''.$CFG['format']['date'].'\')',
			'last_logged'		=> 'DATE_FORMAT(last_logged, \''.$CFG['format']['date'].'\')',
			'total_groups' => '1',
			'last_logged'		=> 'DATE_FORMAT(last_logged, \''.$CFG['format']['date'].'\')',
			'tag_match' => $tagMatchAlias
			)
		);
if ($searchfrm->isShowPageBlock('form_list_members'))
    {
		//$searchfrm->isEmpty($searchfrm->getFormField('start')) and $searchfrm->setIndirectFormField('start', 0);
		$searchfrm->buildSelectQuery();
		$searchfrm->buildConditionQuery();
		$searchfrm->buildSortQuery();
		$searchfrm->buildQuery();
		$searchfrm->executeQuery();

		if ($searchfrm->isResultsFound())
		    {
				$searchfrm->form_list_members['populateHidden_arr'] = array('start', 'search');
				$searchfrm->form_list_members['displayMembers'] = $searchfrm->displayMembers();
				$searchfrm->hidden_arr = array();
				if($searchfrm->getFormField('search'))
					$searchfrm->hidden_arr = array('search');
				$smartyObj->assign('smarty_paging_list', $searchfrm->populatePageLinksGET($searchfrm->getFormField('start'), $searchfrm->hidden_arr));
		    }
		else
			{
				$searchfrm->setPageBlockShow('form_no_records_found');
				$searchfrm->setPageBlockShow('form_search');
				$searchfrm->setPageBlockHide('form_list_members');
			}
	}
if ($searchfrm->isPageGETed($_GET, 'uid') AND $searchfrm->isPageGETed($_GET, 'action'))
    {
		$searchfrm->setPageBlockShow('form_change_status');
    }
//<<<<--------------------Code Ends----------------------//
//--------------------Page block templates begins-------------------->>>>>//
if ($searchfrm->isShowPageBlock('form_search'))
    {
		$searchfrm->form_search['sortField'] = $searchfrm->getFormField('sort_field');
		$searchfrm->form_search['SORT_user_id'] = $searchfrm->form_search['SORT_user_name'] = $searchfrm->form_search['SORT_last_logged'] = '';
		$searchfrm->form_search['sortFieldVar'] = 'SORT_'.$searchfrm->form_search['sortField'];
		$searchfrm->form_search['sortFieldVar'] = ' SELECTED ';

		$searchfrm->form_search['sortFieldOrder'] = $searchfrm->getFormField('sort_field_order_by');
		$searchfrm->form_search['SORT_ORDER_ASC'] = $SORT_ORDER_ASC = '';
		$searchfrm->form_search['sortFieldOrderVar'] = $sortFieldOrderVar = 'SORT_ORDER_'.$searchfrm->form_search['sortFieldOrder'];
		$searchfrm->form_search['sortFieldOrderVar'] = $$sortFieldOrderVar = ' SELECTED ';
		$searchfrm->form_search['LANG_LIST_ARR'] = $LANG_LIST_ARR['gender'];
    }
$searchfrm->left_navigation_div = 'musicMain';
$searchfrm->includeHeader();
setTemplateFolder('admin/', 'music');
$smartyObj->display('memberTypeManage.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'].'js/functions.js';?>"></script>

<?php
$searchfrm->includeFooter();
?>