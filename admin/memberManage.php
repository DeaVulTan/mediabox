<?php
/**
 * This file hadling the user details
 *
 * Admin can search the users with using some user data like user name, email...
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/memberManage.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/countries_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/gender_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/months_list_array.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_GeneralActivityHandler.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class AdvanceSearchHandler begins -------------------->>>>>//
/**
 * This class hadling the user details
 *
 * @category	Rayzz
 * @package		Admin
 */
class AdvanceSearchHandler extends ListRecordsHandler
	{
		public $linkFieldsArray = array();
		public $isVideoModule = false;
		public $countriesListArr = array();
		public $module_array = array();

		/**
		 * AdvanceSearchHandler::isVideoModule()
		 * To check whether video module exist or not
		 *
		 * @return 	boolean
		 * @access 	public
		 */
		public function isVideoModule()
			{
				return $this->isVideoModule;
			}

		/**
		 * AdvanceSearchHandler::isGroupModule()
		 * To check whether group module exist or not
		 *
		 * @return 	boolean
		 * @access 	public
		 */
		public function isGroupModule()
			{
				return $this->isGroupModule;
			}

		/**
		 * AdvanceSearchHandler::getUserTypeName()
		 *
		 * @param mixed $usr_type
		 * @return
		 */
		public function getUserTypeName($usr_type)
			{
				$sql = 'SELECT type_name FROM '.$this->CFG['db']['tbl']['user_type_settings'].
						' WHERE type_id = '.$this->dbObj->Param($usr_type);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($usr_type));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				$type_name = $this->LANG['member_manage_user_type_not_selected'];
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$type_name = $row['type_name'];
					}
				return $type_name;
			}

		/**
		 * AdvanceSearchHandler::displayThisMemberRecord()
		 * To populate the members list
		 *
		 * @param  array $row User data
		 * @return 	array
		 * @access 	public
		 */
		public function displayThisMemberRecord($row = array())
			{
				$displayThisMemberRecord_arr = array();
				$displayThisMemberRecord_arr['record'] = $row;
				$displayThisMemberRecord_arr['user_id'] = $row['user_id'];
				$displayThisMemberRecord_arr['icon'] = getMemberAvatarDetails($row['user_id']);
				$StatusToActivate =	$StatusOk = $StatusLocked = false;
				$displayThisMemberRecord_arr['status'] = $row['usr_status'];
				$displayThisMemberRecord_arr['usr_type'] = $this->getUserTypeName($row['usr_type']);
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
				$displayThisMemberRecord_arr['memberProfileUrl'] = 'viewProfile.php?user_id='.$row['user_id'];
				$displayThisMemberRecord_arr['statusChangeLink'] = 'memberManage.php?uid='.$displayThisMemberRecord_arr['user_id'].$sessionSearchQueryString.'&amp;action=';
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
		 * AdvanceSearchHandler::displayMembers()
		 * To display all the members with profile icon
		 *
		 * @return 	array
		 * @access 	public
		 */
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
						$displayMembers_arr['row'][$inc]['modules_arr'] = array();
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
		 * To check whether given values is empty or not
		 *
		 * @param  array $value input value to check
		 * @return 	boolean
		 * @access 	public
		 */
		public function isEmpty($value)
			{
				$is_not_empty = is_string($value)?trim($value)=='':empty($value);
				return $is_not_empty;
			}

		/**
		 * AdvanceSearchHandler::buildSortQuery()
		 * To build the sort query
		 *
		 * @return
		 * @access 	public
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
		 * To build the condition query
		 *
		 * @return
		 * @access 	public
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

				if (!$this->isEmpty($this->fields_arr['usr_type']))
					{
						$this->sql_condition .= ' AND usr_type = \''.addslashes($this->fields_arr['usr_type']).'\' ';
		//					$this->linkFieldsArray[] = 'hasFriends';
					}
				if (!$this->isEmpty($this->fields_arr['doj_start']))
					{
						$dojStart  = explode(' ', $this->fields_arr['doj_start']);
						$this->sql_condition .= ' AND DATE_FORMAT(doj, \'%Y-%m-%d\') >= \''.addslashes($dojStart[0]).'\'';
					}

				if (!$this->isEmpty($this->fields_arr['doj_end']))
					{
						$dojEnd  = explode(' ', $this->fields_arr['doj_end']);
						$this->sql_condition .= ' AND DATE_FORMAT(doj, \'%Y-%m-%d\') <= \''.addslashes($dojEnd[0]).'\'';
					}

				if (!$this->isEmpty($this->fields_arr['login_start']))
					{
						$loginStart  = explode(' ',$this->fields_arr['login_start']);
						$this->sql_condition .= ' AND DATE_FORMAT(last_logged, \'%Y-%m-%d\') >= \''.addslashes($loginStart[0]).'\'';
					}
				if (!$this->isEmpty($this->fields_arr['login_end']))
				{
					$loginEnd  = explode(' ', $this->fields_arr['login_end']);
					$this->sql_condition .= ' AND DATE_FORMAT(last_logged, \'%Y-%m-%d\') <= \''.addslashes($loginEnd[0]).'\'';
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
		 * To check whether searching with tag or not
		 *
		 * @return 	boolean
		 * @access 	public
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
		 * To populate all the country names
		 *
		 * @param  $lang_list_country country list array
		 * @return 	array
		 * @access 	public
		 */
		public function getAllCountryNames($lang_list_country = array())
			{
				$countriesList = array();
				$sql = 'SELECT DISTINCT country FROM '.$this->CFG['db']['tbl']['users'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

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
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function getUserTypes()
			{
				$sql = 'SELECT type_id, type_name FROM '.$this->CFG['db']['tbl']['user_type_settings']
						.' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					    trigger_db_error($this->dbObj);

				$user_types = array();
				if ($rs->PO_RecordCount())
					{
						while ($row = $rs->FetchRow())
							{
								$user_types[$row['type_id']] = $row['type_name'];
							}
					}
				return $user_types;
			}

		/**
		 * AdvanceSearchHandler::checkDateFieldSets()
		 * To check date field sets
		 *
		 * @return 	array
		 * @access 	public
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
		 * To store search fields in session variable
		 *
		 * @return 	string
		 * @access 	public
		 */
		public function storeSearchFieldsInSession()
			{
				$dateFields = $this->checkDateFieldSets();
				$requiredFields = array('email', 'uname', 'fname', 'tagz', 'sex', 'country', 'usr_type', 'hasVideos', 'sort_field', 'sort_field_order_by' , 'user_status_Ok', 'user_status_ToActivate', 'user_status_Locked', 'user_type','hasFriends');
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
						if (isset($this->fields_arr[$fieldName]) and ($fieldValue =  trim($this->fields_arr[$fieldName])))
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
						$this->setFormField('search', $sessionKey);
					}
				return $sessionKey;
			}

		/**
		 * AdvanceSearchHandler::generateSessionKeyToStoreOptions()
		 * To generate session key to store the search variables
		 *
		 * @return 	string
		 * @access 	public
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
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function isNeedToUpdateInActivity($uid)
			{
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_id='.$this->dbObj->Param($uid).
						' AND usr_status = \'ToActivate\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($uid));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
					return true;
				return false;
			}

		/**
		 * AdvanceSearchHandler::updateUserStatus()
		 * To update the users status
		 *
		 * @param  int $user_id user id
		 * @param  string $status New status to update
		 * @return 	int
		 * @access 	public
		 */
		public function updateUserStatus($user_id=0, $status='')
			{
				$status_value = $status;
				if($status == 'Deleted')
					$this->deleteOpenIdDetail($user_id);
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET usr_status='.$this->dbObj->Param($status).' WHERE user_id='.$this->dbObj->Param($user_id);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($status_value, $user_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				return $this->dbObj->Affected_Rows();
			}

		/**
		 * AdvanceSearchHandler::deleteOpenIdDetail()
		 * To delete open id detail of particular users
		 *
		 * @param  int $user_id user id
		 * @return 	mixed
		 * @access 	public
		 */
		public function deleteOpenIdDetail($user_id)
			{

				$sql = 'SELECT openid_type FROM '.$this->CFG['db']['tbl']['users'].' WHERE user_id='.$user_id;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if($row['openid_type'] == 'facebook')
					{
						//Delete Identity
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['facebook_identity'].' WHERE user_id='.$user_id;

						$stmt = $this->dbObj->Prepare($sql);
						$rs_facebook = $this->dbObj->Execute($stmt);
						if (!$rs_facebook)
							trigger_db_error($this->dbObj);

						//Delete user profile
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['facebook_profile'].' WHERE user_id='.$user_id;

						$stmt = $this->dbObj->Prepare($sql);
						$rs_facebook = $this->dbObj->Execute($stmt);
						if (!$rs_facebook)
							trigger_db_error($this->dbObj);
					}

				return true;
			}

		/**
		 * AdvanceSearchHandler::setFeatured()
		 * To set particular user as featured user
		 *
		 * @param  int $uid user id
		 * @return
		 * @access 	public
		 */
		public function setFeatured($uid)
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['users_featured'].
						' SET user_id='.$this->dbObj->Param('uid');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($uid));
				if (!$rs)
						trigger_db_error($this->dbObj);

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
						' SET featured=\'Yes\', featured_description='.$this->dbObj->Param('featured_description').
						' WHERE user_id='.$this->dbObj->Param('uid');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['featured_description'], $uid));
				if (!$rs)
					trigger_db_error($this->dbObj);
			}

		/**
		 * AdvanceSearchHandler::removeFeatured()
		 * To remove particular user from featured users list
		 *
		 * @param  int $uid user id
		 * @return
		 * @access 	public
		 */
		public function removeFeatured($uid)
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['users_featured'].
						' WHERE user_id='.$this->dbObj->Param('uid');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($uid));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
						' SET featured=\'No\' WHERE user_id='.$this->dbObj->Param('uid');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($uid));
				if (!$rs)
					trigger_db_error($this->dbObj);
			}

		/**
		 * AdvanceSearchHandler::setAffiliate()
		 * To update the affiliate type for particular user
		 *
		 * @param  int $uid user id
		 * @return
		 * @access 	public
		 */
		public function setAffiliate($uid)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
						' SET is_affiliate_type=\'Yes\' WHERE user_id='.$this->dbObj->Param('uid');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($uid));
				if (!$rs)
					trigger_db_error($this->dbObj);
			}

		/**
		 * AdvanceSearchHandler::removeAffiliate()
		 * To remove the affiliate type for particular user
		 *
		 * @param  int $uid user id
		 * @return
		 * @access 	public
		 */
		public function removeAffiliate($uid)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
						' SET is_affiliate_type=\'No\' WHERE user_id='.$this->dbObj->Param('uid');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($uid));
				if (!$rs)
					trigger_db_error($this->dbObj);
			}

		/**
		 * AdvanceSearchHandler::setArticle()
		 * To allow particular user for add new article
		 *
		 * @param  int $uid user id
		 * @return
		 * @access 	public
		 */
		public function setArticle($uid)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
						' SET allow_article=\'Yes\' WHERE user_id='.$this->dbObj->Param('uid');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($uid));
				if (!$rs)
					trigger_db_error($this->dbObj);
			}

		/**
		 * AdvanceSearchHandler::setArticle()
		 * To disallow particular user for add new article
		 *
		 * @param  int $uid user id
		 * @return
		 * @access 	public
		 */
		public function removeArticle($uid)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
						' SET allow_article=\'No\' WHERE user_id='.$this->dbObj->Param('uid');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($uid));
				if (!$rs)
					trigger_db_error($this->dbObj);
			}

		/**
		 * AdvanceSearchHandler::changeUserStatus()
		 * To change the user status
		 *
		 * @param  string $field user status field name
		 * @return
		 * @access 	public
		 */
		public function changeUserStatus($field)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
						' SET '.$field.' = '.$this->dbObj->Param('ch_status').' WHERE user_id = '.$this->dbObj->Param('uid');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['ch_status'], $this->fields_arr['uid']));
				if (!$rs)
					trigger_db_error($this->dbObj);
			}

		/**
		 * AdvanceSearchHandler::generateModuleFields()
		 * To modules fields list
		 *
		 * @return
		 * @access 	public
		 */
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
		 * verifyMailHandler::addWelcomeMessage()
		 * add welcome message to database
		 * @return void
		 * @access bublic
		 */
		public function addWelcomeMessage($uid, $user_name)
			{
				if($this->CFG['admin']['welcome_mail'])
					{
						$subject = $this->LANG['welcome_message_subject'];
						$content = $this->LANG['welcome_message_content'];

						$subject = str_replace('VAR_USER_NAME', $user_name, $subject);
						$subject = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $subject);

						$content = str_replace('VAR_USER_NAME', $user_name, $content);
						$content = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $content);

						$content = nl2br($content);
						$content = html_entity_decode($content);

						$admin_id = $this->CFG['user']['user_id'];

						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['messages'].
								' SET subject = '.$this->dbObj->Param('subject').
								', message ='.$this->dbObj->Param('message').
								', mess_date = NOW()';

				        $stmt = $this->dbObj->Prepare($sql);
				        $rs = $this->dbObj->Execute($stmt, array($subject, $content));
				        if (!$rs)
			                trigger_db_error($this->dbObj);

				        $msg_id = $this->dbObj->Insert_ID();

						$sql = 'INSERT INTO ' . $this->CFG['db']['tbl']['messages_info'] .
								' SET message_id = '.$this->dbObj->Param('message_id').
								', from_id ='.$this->dbObj->Param('from_id').
								', to_id ='.$this->dbObj->Param('to_id');

						$stmt = $this->dbObj->Prepare($sql);
				        $rs = $this->dbObj->Execute($stmt, array($msg_id, $admin_id, $uid));
				        if (!$rs)
			                trigger_db_error($this->dbObj);

						$update_fields = 'new_mails = new_mails + 1';

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
								' SET '.$update_fields.
								' WHERE user_id= '.$this->dbObj->Param('user_id');

				        $stmt = $this->dbObj->Prepare($sql);
				        $rs = $this->dbObj->Execute($stmt, array($uid));
				        if (!$rs)
				            trigger_db_error($this->dbObj);
					}
			}

		/**
		 * verifyMailHandler::addDefaultFriend()
		 * To set the deault friend to admin
		 * @return void
		 * @access public
		 */
		public function addDefaultFriend($uid, $user_name)
			{
				if($this->CFG['admin']['default_friend_name'] and ($friend_id = $this->CFG['user']['user_id']))
					{
						if(!($friend_id and $uid))
							return;

						if($this->CFG['admin']['default_friend_mail'])
							{
								$subject = $this->LANG['default_friend_joined_subject'];
								$content = $this->LANG['default_friend_joined_content'];

								$subject = str_replace('VAR_FRIEND_NAME', $this->CFG['admin']['default_friend_name'], $subject);
								$subject = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $subject);
								$subject = str_replace('VAR_USER_NAME', $user_name, $subject);

								$content = str_replace('VAR_FRIEND_NAME', $this->CFG['admin']['default_friend_name'], $content);
								$content = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $content);
								$content = str_replace('VAR_USER_NAME', $user_name, $content);
								$content = nl2br($content);
								$content = html_entity_decode($content);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['messages'].
										' SET subject = '.$this->dbObj->Param('subject').
										', message ='.$this->dbObj->Param('message').
										', mess_date = NOW()';

						        $stmt = $this->dbObj->Prepare($sql);
						        $rs = $this->dbObj->Execute($stmt, array($subject, $content));
						        if (!$rs)
					                trigger_db_error($this->dbObj);

						        $msg_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['messages_info'].
										' SET message_id = '.$this->dbObj->Param('message_id').
										', from_id ='.$this->dbObj->Param('from_id').
										', to_id ='.$this->dbObj->Param('to_id');

								$stmt = $this->dbObj->Prepare($sql);
						        $rs = $this->dbObj->Execute($stmt, array($msg_id, $friend_id, $uid));
						        if (!$rs)
					                trigger_db_error($this->dbObj);

								$update_fields = 'new_mails = new_mails + 1';

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
										' SET '.$update_fields.
										' WHERE user_id= '.$this->dbObj->Param('user_id');

						        $stmt = $this->dbObj->Prepare($sql);
						        $rs = $this->dbObj->Execute($stmt, array($uid));
						        if (!$rs)
					                trigger_db_error($this->dbObj);
							}

						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['friends_list'].
								' SET owner_id='.$this->dbObj->Param('owner_id').', friend_id='.$this->dbObj->Param('friend_id');
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($friend_id, $uid));
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['friends_list'].
								' SET owner_id='.$this->dbObj->Param('owner_id').', friend_id='.$this->dbObj->Param('friend_id');
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($uid, $friend_id));
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						$uids = $friend_id.','.$uid;
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
								' SET total_friends = total_friends + 1'.
								' WHERE user_id = '.$this->dbObj->Param($friend_id).
								' OR user_id = '.$this->dbObj->Param($uid);

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($friend_id, $uid));
					    if (!$rs)
						    trigger_db_error($this->dbObj);
					}
			}

	}
//<<<<<---------------class AdvanceSearchHandler------///
//--------------------Code begins-------------->>>>>//
$searchfrm = new AdvanceSearchHandler();
$searchfrm->setPageBlockNames(array('msg_form_user_details_updated' , 'form_search','form_list_members', 'form_no_records_found', 'form_change_status'));
// To set the DB object
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
$searchfrm->setFormField('usr_type', '');
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
$searchfrm->user_types = $searchfrm->getUserTypes();
$searchfrm->setCSSAlternativeRowClasses($CFG['data_tbl']['css_alternative_row_classes']);
$searchfrm->setMinRecordSelectLimit(2);
$searchfrm->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$searchfrm->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$searchfrm->setTableNames(array($CFG['db']['tbl']['users']));
$searchfrm->setReturnColumns(array('user_id', 'user_name', 'sex', 'first_name', 'allow_article', 'last_name', 'email' , 'age' , 'total_videos', 'total_friends', 'total_groups' , 'doj', 'last_logged' , 'profile_tags', 'tag_match', 'icon_id', 'icon_type', 'image_ext','usr_status', 'last_logged', 'city', 'postal_code', 'country', 'usr_type', 'featured', 'is_affiliate_type', 'is_upload_background_image', 'is_paid_member'));
$searchfrm->setPageBlockShow('form_list_members');

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
				case 'is_upload_background_image':
					$searchfrm->changeUserStatus('is_upload_background_image');
					break;
				case 'is_paid_member':
					$searchfrm->changeUserStatus('is_paid_member');
					break;
			}
		$searchfrm->setPageBlockShow('block_msg_form_success');
		$searchfrm->setCommonSuccessMsg($LANG['successful_update_message']);
	}
if ($searchfrm->isFormPOSTed($_POST, 'search_submit'))
    {
		$searchfrm->sanitizeFormInputs($_POST);
		$searchfrm->setFormField('search', '');
		$searchfrm->storeSearchFieldsInSession();
		$search = $searchfrm->getFormField('search');
		if ($search)
			Redirect2Url('memberManage.php?search='.$search);
	}
if ($searchfrm->isFormPOSTed($_POST, 'search_submit_reset'))
	{
		//$_SESSION['admin']['member_search'] = array();
		Redirect2Url('memberManage.php');
	}
if ($searchfrm->isFormPOSTed($_POST, 'submit_yes'))
    {
		$searchfrm->sanitizeFormInputs($_POST);
		$uid = $searchfrm->getFormField('uid');
		$status = $searchfrm->getFormField('action');
		$userStatus = array('Ok', 'ToActivate', 'Deleted', 'Locked');
		if (in_array($status, $userStatus))
			{
				if($CFG['admin']['is_demo_site'])
					{
						$searchfrm->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
						$searchfrm->setPageBlockShow('block_msg_form_success');
					}
				else
					{
						//Check the user is activating first time
						$first_time_activation = $searchfrm->isNeedToUpdateInActivity($uid);
						//Update user status
						$update = $searchfrm->updateUserStatus($uid, $status);

						if ($first_time_activation)
							{
								$user_detials = getUserDetail('user_id', $uid);
								$searchfrm->addWelcomeMessage($uid, isset($user_detials['user_name'])?$user_detials['user_name']:'');

								if($CFG['admin']['add_default_friend'])
									$searchfrm->addDefaultFriend($uid, isset($user_detials['user_name'])?$user_detials['user_name']:'');

								//Add Activity
								if ($CFG['admin']['show_recent_activities'])
									{
										$GeneralActivity = new GeneralActivityHandler();
										$GeneralActivity->activity_arr['action_key'] = 'new_member_by_admin';
										$GeneralActivity->activity_arr['admin_id'] = $CFG['user']['user_id'];
										$GeneralActivity->activity_arr['actor_id'] = $uid;
										$GeneralActivity->activity_arr['doj'] = date('Y-m-d H:i:s');
										$GeneralActivity->addActivity($GeneralActivity->activity_arr);
									}
							}

						if ($update)
							{
								$searchfrm->setPageBlockShow('msg_form_user_details_updated');
								$searchfrm->setCommonErrorMsg(($status == 'Deleted')?$LANG['successful_delete_message']:$LANG['successful_update_message']);
						   	}
					}
			}
		elseif ($status == 'SetFeatured' )
			{
				$searchfrm->setFeatured($uid);
		        $searchfrm->setPageBlockShow('msg_form_user_details_updated');
				$searchfrm->setCommonErrorMsg($LANG['successful_set_featured_message']);
			}
		elseif ($status == 'RemoveFeatured')
			{
				$searchfrm->removeFeatured($uid);
		        $searchfrm->setPageBlockShow('msg_form_user_details_updated');
				$searchfrm->setCommonErrorMsg($LANG['successful_remove_featured_message']);
			}
		elseif ($status == 'SetArticle' )
			{
				$searchfrm->setArticle($uid);
		        $searchfrm->setPageBlockShow('msg_form_user_details_updated');
				$searchfrm->setCommonErrorMsg($LANG['successful_set_article_message']);
			}
		elseif ($status == 'RemoveArticle')
			{
				$searchfrm->removeArticle($uid);
		        $searchfrm->setPageBlockShow('msg_form_user_details_updated');
				$searchfrm->setCommonErrorMsg($LANG['successful_remove_article_message']);
			}
		elseif ($status == 'SetAffiliate' )
			{
				$searchfrm->setAffiliate($uid);
		        $searchfrm->setPageBlockShow('msg_form_user_details_updated');
				$searchfrm->setCommonErrorMsg($LANG['successful_set_affiliate_message']);
			}
		elseif ($status == 'RemoveAffiliate')
			{
				$searchfrm->removeAffiliate($uid);
		        $searchfrm->setPageBlockShow('msg_form_user_details_updated');
				$searchfrm->setCommonErrorMsg($LANG['successful_remove_affiliate_message']);
			}
    }
if ($searchfrm->isPageGETed($_REQUEST, 'search'))
    {
        $searchfrm->sanitizeFormInputs($_REQUEST);
		$search = $searchfrm->getFormField('search');
		if ($search AND isset($_SESSION['admin']['member_search'][$search]) AND $searchOptions=$_SESSION['admin']['member_search'][$search])
		    {
		        $searchOptions = unserialize($searchOptions);
				$searchfrm->sanitizeFormInputs($searchOptions);
		    }
    }
$tagMatchAlias = $searchfrm->canSearchWithTag()?getSearchRegularExpressionQueryModified($searchfrm->getFormField('tagz'), 'profile_tags', ''):'1';
$searchfrm->setReturnColumnsAliases(array(
			'doj'		=> 'doj',
			'last_logged'		=> 'last_logged',
			'total_groups' => '1',
			'last_logged'		=> 'last_logged',
			'tag_match' => $tagMatchAlias
			)
		);

if ($searchfrm->isShowPageBlock('form_search'))
    {
		$searchfrm->form_search['sortField'] = $searchfrm->getFormField('sort_field');
		$searchfrm->form_search['SORT_user_id'] = $searchfrm->form_search['SORT_user_name'] = $searchfrm->form_search['SORT_last_logged'] = '';
		$searchfrm->form_search['SORT_'.$searchfrm->form_search['sortField']] = ' selected = "selected" ';

		$searchfrm->form_search['sortFieldOrder'] = $searchfrm->getFormField('sort_field_order_by');
		$searchfrm->form_search['SORT_ORDER_ASC'] = $searchfrm->form_search['SORT_ORDER_DESC'] = '';
		$searchfrm->form_search['SORT_ORDER_'.$searchfrm->form_search['sortFieldOrder']] = ' selected = "selected" ';
		$searchfrm->form_search['LANG_LIST_ARR'] = $LANG_LIST_ARR['gender'];
    }


if ($searchfrm->isShowPageBlock('form_list_members'))
    {
		//$searchfrm->isEmpty($searchfrm->getFormField('start')) and $searchfrm->setFormField('start', 0);
		$searchfrm->buildSelectQuery();
		$searchfrm->buildConditionQuery();
		$searchfrm->buildSortQuery();
		$searchfrm->buildQuery();
		$searchfrm->executeQuery();
		$searchfrm->form_list_members['populateHidden_arr'] = array('search');
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
$searchfrm->left_navigation_div = 'generalMember';
$searchfrm->includeHeader();
setTemplateFolder('admin/');
$smartyObj->display('memberManage.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgChangeStatus', 'selMsgConfirm');
	function activateMember(uid)
		{
			changeStatus(uid, 'Ok', '<?php echo $LANG['member_manage_confirm_activation'];?>', '<?php echo $LANG['member_manage_btn_activate'];?>');
			return false;
		}
	function deActivateMember(uid)
		{
			changeStatus(uid, 'Locked', '<?php echo $LANG['member_manage_confirm_de_activation'];?>', '<?php echo $LANG['member_manage_btn_de_activate'];?>');
			return false;
		}
	function deleteMember(uid)
		{
			changeStatus(uid, 'Deleted', '<?php echo $LANG['member_manage_confirm_delete'];?>', '<?php echo $LANG['member_manage_btn_delete'];?>');
			return false;
		}
	function setFeaturedMember(uid)
		{
			changeStatus(uid, 'SetFeatured', '<?php echo $LANG['member_manage_confirm_set_featured'];?>', '<?php echo $LANG['member_manage_btn_set_featured'];?>');
			return false;
		}
	function removeFeaturedMember(uid)
		{
			changeStatus(uid, 'RemoveFeatured', '<?php echo $LANG['member_manage_confirm_remove_featured'];?>', '<?php echo $LANG['member_manage_btn_remove_featured'];?>');
			return false;
		}
	function setArticleMember(uid)
		{
			changeStatus(uid, 'SetArticle', '<?php echo $LANG['member_manage_confirm_set_article'];?>', '<?php echo $LANG['member_manage_btn_set_article'];?>');
			return false;
		}
	function removeArticleMember(uid)
		{
			changeStatus(uid, 'RemoveArticle', '<?php echo $LANG['member_manage_confirm_remove_article'];?>', '<?php echo $LANG['member_manage_btn_remove_article'];?>');
			return false;
		}
	function setAffiliateMember(uid)
		{
			changeStatus(uid, 'SetAffiliate', '<?php echo $LANG['member_manage_confirm_set_affiliate'];?>', '<?php echo $LANG['member_manage_btn_set_affiliate'];?>');
			return false;
		}
	function removeAffiliateMember(uid)
		{
			changeStatus(uid, 'RemoveAffiliate', '<?php echo $LANG['member_manage_confirm_remove_affiliate'];?>', '<?php echo $LANG['member_manage_btn_remove_affiliate'];?>');
			return false;
		}
	function changeStatus(uid, status, msg, btnName)
		{
			anchors = 'uAnchor_' + uid;
			pIconSrc = $Jq('#imgProfileIcon_' + uid).html();
			if(status == 'SetFeatured')
				{
					//$('featured_description').style.display = '';
					Confirmation('selMsgChangeStatus', 'formChangeStatus', Array('uid','action','msgConfirmText', 'profileIcon', 'submit_yes'), Array(uid, status, msg, pIconSrc, btnName), Array('value', 'value', 'html', 'html', 'value'));
				}
			else
				{
					//$('featured_description').style.display = 'none';
					Confirmation('selMsgChangeStatus', 'formChangeStatus', Array('uid','action','msgConfirmText', 'profileIcon', 'submit_yes'), Array(uid, status, msg, pIconSrc, btnName), Array('value', 'value', 'html', 'html', 'value'));
				}
		}
	function viewProfile(profileUrl)
		{
			window.open (profileUrl);
		}
</script>
<?php
$searchfrm->includeFooter();
?>
