<?php
/**
 * This file hadling the reply bugs
 *
 * Developer can post the reply for bugs
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/replyBugs.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------- Class ContactUsHandler begins --------------->>>>>//
/**
 * This class hadling the reply bugs
 *
 * @category	Rayzz
 * @package		Admin
 */
class BugHandler extends ListRecordsHandler
    {
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
		 * ServerSettingsHandler::buildConditionQuery()
		 * To build the condition query
		 *
		 * @return
		 * @access 	public
		 */
		public function buildConditionQuery()
			{
				$this->sql_condition = 'parent_id = 0';

				if($this->getFormField('order') == 'close')
					{
						$this->sql_condition .= ' AND status = \'Closed\'';
					}
				elseif($this->getFormField('order') == 'open')
					{
						$this->sql_condition .= ' AND status = \'Open\'';
					}
			}

		/**
		 * ServerSettingsHandler::restoreFormFields()
		 * To initialize the form field values
		 *
		 * @return
		 * @access 	public
		 */
		public function restoreFormFields()
			{
				$this->setFormField('message', '');
				$this->setFormField('bid', '');
				$this->setFormField('act', '');
				$this->setFormField('cbid', '');
				$this->setFormField('skey', '');
				$this->setFormField('bsite', '');
			}

		/**
		 * ServerSettingsHandler::replyBugs()
		 * To post the reply for bugs
		 *
		 * @return
		 * @access 	public
		 */
		public function replyBugs()
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['receive_bugs'].' SET'.
						' bug_content = '.$this->dbObj->Param('bug_content').','.
						' parent_id = '.$this->dbObj->Param('parent_id').','.
						' reply_from = \'Developers\'' . ',' .
						' date_added = NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->getFormField('message'), $this->getFormField('bid')));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$bug_id = $this->dbObj->Insert_ID();

				$post_value = 'bid='.$this->getFormField('cbid').'&bcontent='.urlencode($this->getFormField('message')).
								'&bsite='.urlencode($this->getFormField('bsite')).'&skey='.$this->getFormField('skey');

				postForm($this->getFormField('bsite').'receiveReply.php', $post_value);
			}

		/**
		 * ServerSettingsHandler::populateBugReplyList()
		 * To populate the bug reply list
		 *
		 * @param  int $bid bug id
		 * @param  int $c_id bug category id
		 * @param  string $bug_site bug site url
		 * @return array
		 * @access 	public
		 */
		public function populateBugReplyList($bid, $c_id, $bug_site)
			{
				$sql = 'SELECT bug_id, bug_content, date_added, reply_from, secret_key'.
						' FROM '.$this->CFG['db']['tbl']['receive_bugs'].' WHERE'.
						' parent_id = '.$this->dbObj->Param('parent_id').' OR'.
						' (parent_id = '.$this->dbObj->Param('parent_id').' AND'.
						' bug_site = '.$this->dbObj->Param('bug_site').')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($bid, $c_id, $bug_site));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$populateBugReplyList_arr = array();

				if($rs->PO_RecordCount())
					{
						$inc = 0;
						while($row = $rs->FetchRow())
							{
								$row['class_client_post'] = $row['secret_key']?'clsClientPost':'clsDevPost';
								$row['bug_content'] = nl2br(wordWrapManual($row['bug_content'], 200));
								$populateBugReplyList_arr[$inc]['record'] = $row;
								$inc++;
							}
					}
				return $populateBugReplyList_arr;
			}

		/**
		 * ServerSettingsHandler::populateBugsList()
		 * To populate the bugs list
		 *
		 * @return array
		 * @access 	public
		 */
		public function populateBugsList()
			{
				$populateBugsList_arr = array();
				$inc = 0;
				while($row = $this->fetchResultRecord())
					{
						$row['bug_content'] = nl2br(wordWrapManual(html_entity_decode($row['bug_content']), 200));
						$populateBugsList_arr[$inc]['record'] = $row;
						$populateBugsList_arr[$inc]['bug_content'] = $row['bug_content'];
						$populateBugsList_arr[$inc]['reply_url'] = $this->CFG['site']['url'].'admin/replyBugs.php?act=reply&bid='.$row['bug_id'];
						$populateBugsList_arr[$inc]['populateBugReplyList'] = $this->populateBugReplyList($row['bug_id'], $row['client_bug_id'], $row['bug_site']);
						$inc++;
					}
				return $populateBugsList_arr;
			}

		/**
		 * ServerSettingsHandler::chkIsValidBid()
		 * To check the bug is valid or not
		 *
		 * @return boolean
		 * @access 	public
		 */
		public function chkIsValidBid()
			{
				$sql = 'SELECT client_bug_id, secret_key, bug_site FROM '.$this->CFG['db']['tbl']['receive_bugs'].
						' WHERE bug_id = '.$this->dbObj->Param('bug_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->getFormField('bid')));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->setFormField('cbid', $row['client_bug_id']);
						$this->setFormField('skey', $row['secret_key']);
						$this->setFormField('bsite', $row['bug_site']);
						return true;
					}
				return false;
			}
    }
//<<<<<---------------- Class BugHandler ends -------------//
//--------------------- Code begins -------------------->>>>>//
$BugHandler = new BugHandler();
$BugHandler->setPageBlockNames(array('block_replyBugs', 'block_bugs_list'));
//set the form field
$BugHandler->restoreFormFields();
$BugHandler->setAllPageBlocksHide();
$BugHandler->setPageBlockShow('block_bugs_list');
$BugHandler->setFormField('order', 'open');

/*********** Page Navigation Start *********/
$BugHandler->setFormField('numpg', 100);
$BugHandler->setFormField('orderby_field', 'date_added');
$BugHandler->setFormField('orderby', 'DESC');
$BugHandler->setTableNames(array($CFG['db']['tbl']['receive_bugs']));
$BugHandler->setReturnColumns(array('bug_id', 'bug_subject', 'bug_content', 'bug_site', 'date_added', 'client_bug_id', 'reply_from', 'status'));
/************ page Navigation stop *************/
$BugHandler->sanitizeFormInputs($_REQUEST);

if ($BugHandler->isFormPOSTed($_POST, 'submit_cancel'))
	{
		$BugHandler->restoreFormFields();
	}

if($BugHandler->getFormField('act') == 'reply')
	{
		$BugHandler->chkIsNotEmpty('bid', $BugHandler->LANG['common_err_tip_compulsory']);
		if ($BugHandler->isValidFormInputs() and $BugHandler->chkIsValidBid())
			{
				$BugHandler->setPageBlockShow('block_replyBugs');
			}
	}
if ($BugHandler->isFormPOSTed($_POST, 'submit_replyBugs'))
	{
		$BugHandler->chkIsNotEmpty('message', $BugHandler->LANG['common_err_tip_compulsory']);
		$BugHandler->chkIsNotEmpty('bid', $BugHandler->LANG['common_err_tip_compulsory']);

		if ($BugHandler->isValidFormInputs() and $BugHandler->chkIsValidBid())
			{
				$BugHandler->replyBugs();
				$BugHandler->setCommonSuccessMsg($BugHandler->LANG['replybugs_success']);
				$BugHandler->setPageBlockShow('block_msg_form_success');
				$BugHandler->restoreFormFields();
			}
		else
			{
				$BugHandler->setCommonSuccessMsg($BugHandler->LANG['common_msg_error_sorry']);
				$BugHandler->setPageBlockShow('block_msg_form_success');
				$BugHandler->setPageBlockShow('block_replyBugs');
			}
	}
if($BugHandler->isShowPageBlock('block_bugs_list'))
	{
		/****** navigtion continue*********/
		$BugHandler->buildSelectQuery();
		$BugHandler->buildConditionQuery();
		$BugHandler->buildSortQuery();
		$BugHandler->buildQuery();
		$BugHandler->executeQuery();

		if(!$BugHandler->isResultsFound())
			{
				$BugHandler->setPageBlockHide('block_bugs_list');
				$BugHandler->setPageBlockShow('block_msg_form_alert');
				$BugHandler->setCommonAlertMsg($LANG['common_no_records_found']);
			}
	}
//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//

$BugHandler->block_replyBugs['hidden_arr'] = array('orderby','orderby_field','start');
$BugHandler->left_navigation_div = 'generalManageBugs';
if ($BugHandler->isShowPageBlock('block_bugs_list'))
	{
		$smartyObj->assign('smarty_paging_list', $BugHandler->populatePageLinksPOST($BugHandler->getFormField('start'), 'selListStaticForm'));
		$BugHandler->block_sel_page_list['hidden_arr'] = array('order', 'orderby','orderby_field','start');
		$BugHandler->block_sel_page_list['populateBugsList'] = $BugHandler->populateBugsList();
	}
setPageTitle($LANG['replybugs_title']);
//include the header file
$BugHandler->includeHeader();
//include the content of the page
setTemplateFolder('admin/');
$smartyObj->display('replyBugs.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$BugHandler->includeFooter();
?>