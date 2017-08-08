<?php
/**
 * Manage Group Category
 *
 * PHP version 5.0
 *
 * @category	Rayzz
 * @package		Admin
 **/
/**
 * configurations
*/
require_once('../../common/configs/config.inc.php');
$CFG['site']['is_module_page'] = 'music';
$CFG['lang']['include_files'][] = 'languages/%s/music/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/transactionList.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/admin/managePlaylistComments.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['admin']['calendar_page'] = true;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');

class transactionHistory extends MusicHandler
{
	public $hidden_array = array();

	public function showHistory()
	{
		global $smartyObj;
		$showHistory_arr = array();
		$inc=0;
		$showHistory_arr['row'] = array();
		while($row = $this->fetchResultRecord())
		{
			$showHistory_arr['row'][$inc]['record'] = $row;
			$showHistory_arr['row'][$inc]['paypal_id'] = $row['paypal_id'];
			$showHistory_arr['row'][$inc]['disbursement_amount'] = roundValue($row['disbursement_amount']);
			$showHistory_arr['row'][$inc]['paypal_transaction_id'] = $row['paypal_transaction_id'];
			if($row['payment_status']=='')
				$showHistory_arr['row'][$inc]['payment_status'] = $this->LANG['transactionlist_admin_set_as_paid'];
			else
				$showHistory_arr['row'][$inc]['payment_status'] = $row['payment_status'];
			$showHistory_arr['row'][$inc]['date_added'] = $row['date_added'];
			$showHistory_arr['row'][$inc]['txn_id'] = $row['txn_id'];
			$inc++;
		}
		$smartyObj->assign('showHistory_arr', $showHistory_arr);

	}

	public function buildConditionQuery()
	{
		$this->sql_condition = ' user_id=\''.$this->fields_arr['user_id'].'\'';
		if($this->fields_arr['from_date'] != $this->LANG['transactionlist_from_date_select'] AND $this->fields_arr['from_date']!='')
		{
			$this->sql_condition .= ' AND DATE_FORMAT(date_added, \'%Y-%m-%d\') >= \''.$this->fields_arr['from_date'].'\'';
			$this->hidden_array[] = 'from_date';
		}
		if($this->fields_arr['to_date'] != $this->LANG['transactionlist_to_date_select'] AND $this->fields_arr['to_date']!='')
		{
			$this->sql_condition .= ' AND DATE_FORMAT(date_added, \'%Y-%m-%d\') <= \''.$this->fields_arr['to_date'].'\'';
			$this->hidden_array[] = 'to_date';
		}
	}

	public function buildSortQuery()
	{
		$this->sql_sort = $this->fields_arr['orderby_field'].' '.$this->fields_arr['orderby'];
	}

}

$transactionhistory = new transactionHistory();
if(!chkAllowedModule(array('music')))
Redirect2URL($CFG['redirect']['dsabled_module_url']);

$transactionhistory->setFormField('light_window','');
$transactionhistory->setFormField('from_date','');
$transactionhistory->setFormField('to_date','');
$transactionhistory->setFormField('user_id','');
$transactionhistory->setFormField('start','0');
$transactionhistory->setFormField('orderby_field', 'date_added');
$transactionhistory->setFormField('orderby', 'DESC');
$transactionhistory->setTableNames(array($CFG['db']['tbl']['user_transaction_log']));
$transactionhistory->setReturnColumns(array('paypal_id', 'disbursement_amount', 'paypal_transaction_id', 'txn_id', 'payment_status', 'date_added'));
$transactionhistory->sanitizeFormInputs($_REQUEST);
$transactionhistory->buildSelectQuery();
$transactionhistory->buildConditionQuery();
$transactionhistory->buildSortQuery();
$transactionhistory->buildQuery();
$transactionhistory->executeQuery();

if($transactionhistory->isResultsFound())
{
	$transactionhistory->showHistory();
	$transactionhistory->hidden_array[] = 'user_id';
	$smartyObj->assign('smarty_paging_list', $transactionhistory->populatePageLinksGET($transactionhistory->getFormField('start'), $transactionhistory->hidden_array));
}
$transactionhistory->left_navigation_div = 'musicMain';

$transactionhistory->includeHeader();

setTemplateFolder('admin/', 'music');
$smartyObj->display('transactionHistory.tpl');
?>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'].'js/functions.js';?>"></script>
<?php
$transactionhistory->includeFooter();
?>