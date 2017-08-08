<?php
/**
 * This file is to list the newsletter already sent
 *
 * Lists all the newsletters sent and provide options to activate or inativate the records
 * and a link to view the details of each newslettter
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/newsLetterArchive.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/months_list_array.inc.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['admin']['calendar_page'] = true;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class articleManage begins -------------------->>>>>//
/**
 * This class is to list the newsletter already sent
 *
 * @category	Rayzz
 * @package		Admin
 */
class newsLetterManager extends ListRecordsHandler
	{
		public $sql_condition = '';
		public $sql_sort = '';
		public $fields_arr = '';
		public $sql='';
		public $article_category_name = array();

		/**
		 * newsLetterManager::buildConditionQuery()
		 * To build condtion query for listing
		 *
		 * @return
		 * @access 	public
		 */
		public function buildConditionQuery()
			{
				$this->sql_condition = '';
			}

		/**
		 * newsLetterManager::buildSortQuery()
		 * To build sort query for listing
		 *
		 * @return
		 * @access 	public
		 */
		public function buildSortQuery()
			{
				$this->sql_sort = 'v.article_id DESC';
			}

		/**
		 * newsLetterManager::getSearchCondition()
		 * To get the search condition
		 *
		 * @return string
		 * @access 	public
		 */
		public function getSearchCondition()
		    {
				$search_condition = ' 1 ';
				if ($this->fields_arr['subject'])
					{
						$search_condition .= ' AND subject LIKE \'%'.addslashes($this->fields_arr['subject']).'%\'';
					}
				if ($this->fields_arr['status'])
					{
						$search_condition .= ' AND status LIKE \'%'.addslashes($this->fields_arr['status']).'%\'';
					}
				if ($this->fields_arr['srch_date'] and !$this->getFormFieldErrorTip('srch_date'))
					{
						$search_condition .= ' AND date_added >= \''.$this->getFormField('srch_date').' 00:00:00\'';
						$search_condition .= ' AND date_added <= DATE_ADD(\''.$this->getFormField('srch_date').' 00:00:00\', INTERVAL 1 DAY)';
					}
				return $search_condition;
		    }


		/**
		 * newsLetterManager::displayNewsletterList()
		 * To display the newsletter list
		 *
		 * @return
		 * @access 	public
		 */
		public function displayNewsletterList()
			{
				global $smartyObj;
				$newsarchiveList_arr = array();
				$fields_list = array('news_letter_id', 'subject', 'date_added', 'total_sent', 'status');
				$newsarchiveList_arr['row'] = array();
				$inc = 1;
				while($row = $this->fetchResultRecord())
					{
						$newsarchiveList_arr['row'][$inc]['record'] = $row;
						$inc++;
					}
				$smartyObj->assign('newsarchiveList_arr', $newsarchiveList_arr);
			}

		/**
		 * newsLetterManager::changeStatus()
		 * To update the newsletter status
		 *
		 * @return boolean
		 * @access 	public
		 */
		public function changeStatus()
			{
				$rec_details = $this->fields_arr['checkbox'];
				if($this->fields_arr['action']=='Finished' OR $this->fields_arr['action']=='Pending')
					{
						//$newsletter_id = $value;
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['news_letter'].
								' SET status=\''.$this->fields_arr['action'].'\''.
								' WHERE news_letter_id IN('.$rec_details.')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
						    trigger_db_error($this->dbObj);
					}
				return true;
			}

	}
//<<<<<-------------- Class obj begins ---------------//
//-------------------- Code begins -------------->>>>>//
$obj = new newsLetterManager();
$obj->setPageBlockNames(array('list_newsletter','form_search'));

//default form fields and values...
$obj->setReturnColumns(array());
$obj->setTableNames(array());

/*********** Page Navigation Start *********/
$obj->setFormField('slno', '1');
$obj->setFormField('start', '0');
$obj->setFormField('subject', '');
$obj->setFormField('srch_date', '');
$obj->setFormField('status', '');
$obj->setFormField('action', '');
$obj->setFormField('checkbox', '');
/************ page Navigation stop *************/
$obj->setAllPageBlocksHide();
$obj->setPageBlockShow('list_newsletter');
/******************************************************/
$obj->setTableNames(array($obj->CFG['db']['tbl']['news_letter']));
$obj->setReturnColumns(array('news_letter_id', 'subject', 'date_added', 'total_sent', 'status'));
$obj->sql_sort = '';
$obj->sanitizeFormInputs($_REQUEST);
$obj->setPageBlockShow('list_newsletter');
$obj->setPageBlockShow('form_search');
$obj->hidden_arr = array('subject', 'srch_date', 'srch_month', 'srch_year', 'start', 'status');
$obj->current_year = date('Y');
$obj->setMonthsListArr($LANG_LIST_ARR['months']);

//<<<<<-------------------- Code ends----------------------//

$obj->getFormField('srch_date') and
	$obj->chkIsValidDate('srch_date',$obj->LANG['common_err_tip_date_invalid']) and
	$obj->chkIsDateGreaterThanNow('srch_date', $obj->LANG['manage_banner_err_tip_lesser_date']);

$srch_condition = $obj->getSearchCondition();
if ($srch_condition)
	$obj->sql_condition .= $srch_condition;
if($obj->isFormGETed($_POST,'confirmdel'))
	{
		if($CFG['admin']['is_demo_site'])
			{
				$obj->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
				$obj->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				if($obj->changeStatus())
					{
						$obj->setCommonSuccessMsg($LANG['newsletterarchive_msg_success_delete']);
						$obj->setPageBlockShow('block_msg_form_success');
					}
				else
					{
						$obj->setCommonErrorMsg($LANG['newsletterarchive_msg_delete_fail']);
						$obj->setPageBlockShow('block_msg_form_error');
					}
			}
	}

if ($obj->isShowPageBlock('list_newsletter'))
    {
		/****** navigtion continue*********/
		$obj->buildSelectQuery();
		$obj->buildQuery();
		$obj->executeQuery();

		/******* Navigation End ********/
		if($obj->isResultsFound())
			{
				$obj->displayNewsletterList();
				$smartyObj->assign('smarty_paging_list', $obj->populatePageLinksPOST($obj->getFormField('start'), 'archivelist_form'));
				$obj->list_newsletter_form['hidden_arr'] = array( 'start');
			}
    }
//-------------------- Page block templates begins -------------------->>>>>//
$obj->left_navigation_div = 'generalList';
$calendar_options_arr = array('minDate' => '-10Y -0M -0D',
							  'maxDate'	=> '+0Y'
							 );
$smartyObj->assign('calendar_opts_arr', $calendar_options_arr);
//include the header file
$obj->includeHeader();
//include the content of the page
setTemplateFolder('admin/');
$smartyObj->display('newsLetterArchive.tpl');
?>
<script language="javascript" type="text/javascript" >
	var block_arr= new Array('selMsgConfirm');
	var please_select_action = '<?php echo $LANG['newsletterarchive_err_tip_select_action'];?>';
	var confirm_message = '';
	function getAction()
		{
			var act_value = document.archivelist_form.newsletter_options.value;
			if(act_value)
				{
					switch (act_value)
						{
							case 'Finished':
								confirm_message = '<?php echo $LANG['newsletterarchive_confirm_inactivate'];?>';
								break;
							case 'Pending':
								confirm_message = '<?php echo $LANG['newsletterarchive_confirm_activate'];?>';
								break;
						}
					$Jq('#confirmMessage').html(confirm_message);
					document.msgConfirmform.action.value = act_value;
					Confirmation('selMsgConfirm', 'msgConfirmform', Array('checkbox'), Array(multiCheckValue), Array('value'));
				}
			else
				alert_manual('<?php echo $LANG['newsletterarchive_err_tip_select_action'];?>');
		}
	function popupWindow(url)
		{
			 window.open (url, "","status=0,toolbar=0,resizable=1,scrollbars=1");
			 return false;
		}
</script>

<?php
//<<<<<-------------------- Page block templates ends -------------------//
$obj->includeFooter();
?>