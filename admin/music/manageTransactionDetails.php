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
//$CFG['lang']['include_files'][] = 'common/configs/config_photo.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/admin/manageTransactionDetails.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/countries_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/gender_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/months_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/search_list_array.inc.php';
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
class TransactionHandler extends ListRecordsHandler
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
		$displayThisMemberRecord_arr['search'] = $search = $this->fields_arr['search'];
		$displayThisMemberRecord_arr['sessionSearchQueryString'] = $sessionSearchQueryString = '';
		$displayThisMemberRecord_arr['start'] = $this->fields_arr['start'];
		if ($displayThisMemberRecord_arr['search'])
			$displayThisMemberRecord_arr['sessionSearchQueryString'] = $sessionSearchQueryString = '&amp;search='.$displayThisMemberRecord_arr['search'];
		if ($displayThisMemberRecord_arr['start'])
			$displayThisMemberRecord_arr['sessionSearchQueryString'] = $sessionSearchQueryString = '&amp;start='.$displayThisMemberRecord_arr['start'];

		$displayThisMemberRecord_arr['memberProfileUrl'] = $this->CFG['site']['url'].'admin/viewProfile.php?user_id='.$row['user_id'];
		$displayThisMemberRecord_arr['anchor'] = 'uAnchor_'.$displayThisMemberRecord_arr['user_id'];
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
			$row['total_revenue'] = roundValue($row['total_revenue']);
			$row['pending_amount'] = roundValue($row['pending_amount']);
			$row['withdrawl_amount'] = roundValue($row['withdrawl_amount']);
			$row['threshold_amount'] = roundValue($row['threshold_amount']);
			$row['commission_amount'] = roundValue($row['commission_amount']);
			$displayMembers_arr['record_count'] = 1;
			$row['css_row_class'] = $this->getCSSRowClass();
			$displayMembers_arr['row'][$inc] = $this->displayThisMemberRecord($row);
			$displayMembers_arr['checked'] = '';
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
		$this->sql_sort = $this->fields_arr['orderby_field'].' '.$this->fields_arr['orderby'];

	}

	/**
	 * AdvanceSearchHandler::buildConditionQuery()
	 *
	 * @return
	 */
	public function buildConditionQuery()
	{
		$this->sql_condition = ' usr_status!=\'Deleted\' AND (mu.threshold_amount > 0 OR mu.total_revenue > 0) ';
		if($this->CFG['admin']['musics']['music_artist_feature'] and $this->CFG['admin']['musics']['allow_only_artist_to_upload'])
			$this->sql_condition .= ' AND music_user_type=\'Artist\' ';
		if (!$this->isEmpty($this->fields_arr['uname']))
		{
			$this->sql_condition .= ' AND user_name LIKE \'%'.addslashes($this->fields_arr['uname']).'%\' ';
//					$this->linkFieldsArray[] = 'uname';
		}
		if (!$this->isEmpty($this->fields_arr['paypal_id']))
		{
			$this->sql_condition .= ' AND mu.paypal_id LIKE \'%'.addslashes($this->fields_arr['paypal_id']).'%\' ';
//					$this->linkFieldsArray[] = 'email';
		}
		if (!$this->isEmpty($this->fields_arr['fname']))
		{
			$this->sql_condition .= ' AND first_name LIKE \'%'.addslashes($this->fields_arr['fname']).'%\' ';
//					$this->linkFieldsArray[] = 'fname';
		}
		if (!$this->isEmpty($this->fields_arr['srch_threshold']) and $this->fields_arr['srch_threshold']=='Yes')
		{
			$this->sql_condition .= ' AND pending_amount > threshold_amount ';
//					$this->linkFieldsArray[] = 'fname';
		}
		if (!$this->isEmpty($this->fields_arr['srch_threshold']) and $this->fields_arr['srch_threshold']=='No')
		{
			$this->sql_condition .= ' AND pending_amount < threshold_amount ';
//					$this->linkFieldsArray[] = 'fname';
		}
		if (!$this->isEmpty($this->fields_arr['tagz']) AND $this->canSearchWithTag())
		{
			$this->sql_condition .= ' AND '.getSearchRegularExpressionQueryModified($this->fields_arr['tagz'], 'profile_tags', '');
			$this->sql_sort = 'user_id DESC ';
//					$this->linkFieldsArray[] = 'tagz';
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

		if (!$this->isEmpty($this->fields_arr['search']))
		{
			$this->linkFieldsArray[] = 'search';
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
	 * AdvanceSearchHandler::storeSearchFieldsInSession()
	 *
	 * @return
	 */
	public function storeSearchFieldsInSession()
		{
			$requiredFields = array('paypal_id', 'uname', 'fname', 'tagz');

			//$requiredFields = array_merge($requiredFields, $dateFields);
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

	public function insertUserPayment()
	{
		$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['user_transaction_log'].
				' SET '.
				' user_id = '.$this->dbObj->Param('user_id').' , '.
				' disbursement_amount = '.$this->dbObj->Param('pending_amount').' , '.
				' currency = '.$this->dbObj->Param('currency').' , '.
				' date_added = NOW()';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id'], $this->fields_arr['pending_amount'], $this->fields_arr['currency']));
		if (!$rs)
		   trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
	}

	public function updateUserPaymentSettings()
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_user_payment_settings'].
				' SET '.
				' pending_amount=pending_amount-'.$this->fields_arr['pending_amount'].','.
				' withdrawl_amount=withdrawl_amount+'.$this->fields_arr['pending_amount'].
				' WHERE user_id='.$this->dbObj->Param('user_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id']));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
			$this->dbObj->ErrorMsg(), E_USER_ERROR);

	}

	public function getTitleHelpTip($field)
	{
		if($this->fields_arr['orderby_field']==$field)
		{
			if($this->fields_arr['orderby']=='desc')
			{
				return 'Ascending';
			}
			else
			{
				return 'Descending';
			}
		}
		else
		{
					return 'Sort';
		}
	}



}
//<<<<<---------------class AdvanceSearchHandler------///
//--------------------Code begins-------------->>>>>//
$transactiondetails = new TransactionHandler();
$transactiondetails->setPageBlockNames(array('msg_form_user_details_updated' , 'form_search','form_list_members', 'form_no_records_found', 'form_change_status'));
// To set the DB object
//$transactiondetails->setDBObject($db);
$transactiondetails->setAllPageBlocksHide();
$transactiondetails->setPageBlockShow('form_search');
/*$transactiondetails->makeGlobalize($CFG, $LANG);*/

$transactiondetails->setFormField('start', '0');
$transactiondetails->isVideoModule = chkAllowedModule(array('video'));
//Search Form Fields
$transactiondetails->setFormField('orderby_field', 'threshold_amount');
$transactiondetails->setFormField('orderby', 'DESC');
$transactiondetails->setFormField('paypal_id', '');
$transactiondetails->setFormField('user_ids', array());
$transactiondetails->setFormField('uname', '');
$transactiondetails->setFormField('fname', '');
$transactiondetails->setFormField('tagz', '');
$transactiondetails->setFormField('user_id', '');
$transactiondetails->setFormField('threshold_amount', '');
$transactiondetails->setFormField('pending_amount', '');
$transactiondetails->setFormField('search', '');
$transactiondetails->setFormField('srch_threshold', '');
$transactiondetails->setFormField('doj_start', '');
$transactiondetails->setFormField('doj_end', '');
$transactiondetails->setFormField('uid' ,'');
$transactiondetails->setFormField('action' ,'');
$transactiondetails->setFormField('sort_field', 'user_id');
$transactiondetails->setFormField('sort_field_order_by', 'DESC');
$transactiondetails->setFormField('act', '');
$transactiondetails->setFormField('ch_status', '');
$transactiondetails->setFormField('currency', $CFG['payment']['paypal']['currency_code']);
$transactiondetails->setFormField('user_type', '');
$transactiondetails->setFormField('numpg', $CFG['data_tbl']['numpg']);
//Dynamic on/off module coding..
$inc = 0;
$transactiondetails->sanitizeFormInputs($_POST);
$transactiondetails->setCSSAlternativeRowClasses($CFG['data_tbl']['css_alternative_row_classes']);
$transactiondetails->setMinRecordSelectLimit(2);
$transactiondetails->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$transactiondetails->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$transactiondetails->setTableNames(array($CFG['db']['tbl']['users'].' as u LEFT JOIN '.
									$CFG['db']['tbl']['music_user_payment_settings'].
									' as mu ON mu.user_id=u.user_id'));
$transactiondetails->setReturnColumns(array('mu.user_id', 'user_name', 'mu.paypal_id',
											 'total_revenue', 'u.icon_id','u.icon_type',
											 'u.image_ext', 'pending_amount', 'withdrawl_amount',
											  'threshold_amount', 'commission_amount'));
$transactiondetails->setPageBlockShow('form_list_members');

if (!isset($_SESSION['admin']['member_search']))
{
    $_SESSION['admin']['member_search'] = array();
}
if ($transactiondetails->isPageGETed($_GET, 'start'))
{
	$transactiondetails->sanitizeFormInputs($_GET);
}
if ($transactiondetails->isFormPOSTed($_POST, 'set_paid'))
{
	$transactiondetails->sanitizeFormInputs($_POST);
	$transactiondetails->insertUserPayment();
	$transactiondetails->updateUserPaymentSettings();
	$transactiondetails->setPageBlockShow('block_msg_form_success');
	$transactiondetails->setCommonSuccessMsg($LANG['msg_success_updated']);

}

if ($transactiondetails->isFormPOSTed($_POST, 'search_submit'))
{
	$transactiondetails->sanitizeFormInputs($_POST);
	$transactiondetails->setIndirectFormField('search', '');
	$transactiondetails->storeSearchFieldsInSession();
	$search = $transactiondetails->getFormField('search');
	if ($search)
		Redirect2Url('manageTransactionDetails.php?search='.$search);
}
if ($transactiondetails->isFormPOSTed($_POST, 'search_submit_reset'))
	$_SESSION['admin']['member_search'] = array();

if ($transactiondetails->isPageGETed($_GET, 'search'))
{
    $transactiondetails->sanitizeFormInputs($_GET);
	$search = $transactiondetails->getFormField('search');
	if ($search AND isset($_SESSION['admin']['member_search'][$search]) AND $searchOptions=$_SESSION['admin']['member_search'][$search])
    {
        $searchOptions = unserialize($searchOptions);
		$transactiondetails->sanitizeFormInputs($searchOptions);
    }
}
$tagMatchAlias = $transactiondetails->canSearchWithTag()?getSearchRegularExpressionQueryModified($transactiondetails->getFormField('tagz'), 'profile_tags', ''):'1';
$transactiondetails->setReturnColumnsAliases(array(
			'doj'		=> 'DATE_FORMAT(doj, \''.$CFG['format']['date'].'\')',
			'last_logged'		=> 'DATE_FORMAT(last_logged, \''.$CFG['format']['date'].'\')',
			'total_groups' => '1',
			'last_logged'		=> 'DATE_FORMAT(last_logged, \''.$CFG['format']['date'].'\')',
			'tag_match' => $tagMatchAlias
			)
		);
if ($transactiondetails->isShowPageBlock('form_list_members'))
{
	//$transactiondetails->isEmpty($transactiondetails->getFormField('start')) and $transactiondetails->setIndirectFormField('start', 0);
	$transactiondetails->buildSelectQuery();
	$transactiondetails->buildConditionQuery();
	$transactiondetails->buildSortQuery();
	$transactiondetails->buildQuery();
	//$transactiondetails->printQuery();
	$transactiondetails->executeQuery();

	if ($transactiondetails->isResultsFound())
    {
		$transactiondetails->form_list_members['populateHidden_arr'] = array('start', 'search');
		$transactiondetails->form_list_members['displayMembers'] = $transactiondetails->displayMembers();
		$transactiondetails->hidden_arr = array();
		if($transactiondetails->getFormField('search'))
			$transactiondetails->hidden_arr = array('search');
		$transactiondetails->selTransantionForm_hidden_arr = array('orderby','orderby_field');
		$smartyObj->assign('smarty_paging_list', $transactiondetails->populatePageLinksGET($transactiondetails->getFormField('start'), $transactiondetails->hidden_arr));
    }
	else
	{
		$transactiondetails->setPageBlockShow('form_no_records_found');
		$transactiondetails->setPageBlockShow('form_search');
		$transactiondetails->setPageBlockHide('form_list_members');
	}
}
if ($transactiondetails->isPageGETed($_GET, 'uid') AND $transactiondetails->isPageGETed($_GET, 'action'))
{
	$transactiondetails->setPageBlockShow('form_change_status');
}
//<<<<--------------------Code Ends----------------------//
//--------------------Page block templates begins-------------------->>>>>//
if ($transactiondetails->isShowPageBlock('form_search'))
{
	$transactiondetails->form_search['sortField'] = $transactiondetails->getFormField('sort_field');
	$transactiondetails->form_search['SORT_user_id'] = $transactiondetails->form_search['SORT_user_name'] = $transactiondetails->form_search['SORT_last_logged'] = '';
	$transactiondetails->form_search['sortFieldVar'] = 'SORT_'.$transactiondetails->form_search['sortField'];
	$transactiondetails->form_search['sortFieldVar'] = ' SELECTED ';

	$transactiondetails->form_search['sortFieldOrder'] = $transactiondetails->getFormField('sort_field_order_by');
	$transactiondetails->form_search['SORT_ORDER_ASC'] = $SORT_ORDER_ASC = '';
	$transactiondetails->form_search['sortFieldOrderVar'] = $sortFieldOrderVar = 'SORT_ORDER_'.$transactiondetails->form_search['sortFieldOrder'];
	$transactiondetails->form_search['sortFieldOrderVar'] = $$sortFieldOrderVar = ' SELECTED ';
}
$transactiondetails->left_navigation_div = 'musicMain';
$transactiondetails->includeHeader();
setTemplateFolder('admin/', 'music');
$smartyObj->display('manageTransactionDetails.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>

<?php
$transactiondetails->includeFooter();
?>
<script language="javascript" type="text/javascript" >
function popupWindow(url)
	{
		 window.open (url, "","status=0,toolbar=0,resizable=1,scrollbars=1");
		 return false;
	}
</script>