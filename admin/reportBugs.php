<?php
/**
 * This file hadling the bug report
 *
 * Customer can post the bugs to developers
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/reportBugs.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/bug_category_list_array.php';
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
 * This class hadling the bug report
 *
 * @category	Rayzz
 * @package		Admin
 */
class BugHandler extends ListRecordsHandler
    {
		/**
		 * BugHandler::buildSortQuery()
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
		 * BugHandler::buildConditionQuery()
		 * To build the condition query
		 *
		 * @return
		 * @access 	public
		 */
		public function buildConditionQuery()
			{
				if($this->getFormField('order') == 'all')
					$this->sql_condition = 'parent_id = 0';
				elseif($this->getFormField('order') == 'close')
					$this->sql_condition = 'parent_id = 0 AND status = \'Closed\'';
				elseif($this->getFormField('order') == 'open')
					$this->sql_condition = 'parent_id = 0 AND status = \'Open\'';
				else
					$this->sql_condition = 'parent_id = 0 AND status = \'Open\'';
			}

		/**
		 * BugHandler::restoreFormFields()
		 * To initialize the form fields
		 *
		 * @return
		 * @access 	public
		 */
		public function restoreFormFields()
			{
				$this->setFormField('subject', '');
				$this->setFormField('message', '');
			}

		/**
		 * BugHandler::storeBugs()
		 * To store the bugs in database
		 *
		 * @param  array $array_list bugs related data
		 * @return
		 * @access 	public
		 */
		public function storeBugs($array_list)
			{
				$secret_key = microtime();
				$secret_key = md5($secret_key);
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['bugs'].' SET'.
						' bug_subject = '.$this->dbObj->Param('bug_subject').','.
						' bug_content = '.$this->dbObj->Param('bug_content').','.
						' secret_key = '.$this->dbObj->Param('secret_key').','.
						' reply_from = ' . $this->dbObj->Param('site_name') . ',' .
						' date_added = NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($array_list[$this->getFormField('subject')], $this->getFormField('message'), $secret_key, $this->CFG['site']['name']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$bug_id = $this->dbObj->Insert_ID();

				$post_value = 'bid='.$bug_id.'&bsubject='.urlencode($array_list[$this->getFormField('subject')]).
							'&bcontent='.urlencode($this->getFormField('message')).
							'&sitename='.urlencode($this->CFG['site']['name']).'&bsite='.urlencode($this->CFG['site']['url']).'&skey='.$secret_key;

				postForm($this->CFG['members']['receivebugs'], $post_value);
			}

		/**
		 * BugHandler::populateBugReplyList()
		 * To populate the bug reply list
		 *
		 * @param  int $bid bug id
		 * @return array
		 * @access 	public
		 */
		public function populateBugReplyList($bid)
			{
				$sql = 'SELECT bug_id, bug_content, date_added, status, reply_from, parent_id '.
						' FROM '.$this->CFG['db']['tbl']['bugs'].' WHERE'.
						' parent_id = '.$this->dbObj->Param('parent_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($bid));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$populateBugReplyList_arr = array();

				if($rs->PO_RecordCount())
					{
						$inc = 0;
						while($row = $rs->FetchRow())
							{
								$row['bug_content'] = nl2br(wordWrapManual($row['bug_content'], 200));
								//$row['bug_content'] = html_entity_decode($row['bug_content'], ENT_QUOTES);
								$populateBugReplyList_arr[$inc]['record'] = $row;
								$populateBugReplyList_arr[$inc]['replySpanIDId'] = 'replySpanID_'.$row['bug_id'];
								if($row['status'] == 'Open')
									{
									$populateBugReplyList_arr[$inc]['replybugs_open']['url'] = $this->CFG['site']['url'].'admin/reportBugs.php';
									}
								$inc++;
							}
					}
				return $populateBugReplyList_arr;
			}

		/**
		 * BugHandler::populateBugsList()
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
						$row['bug_content'] = nl2br(wordWrapManual($row['bug_content'], 200));
						//$row['bug_content'] = html_entity_decode($row['bug_content'], ENT_QUOTES);
						$populateBugsList_arr[$inc]['record'] = $row;
						$populateBugsList_arr[$inc]['bug_id'] = $row['bug_id'];
						$populateBugsList_arr[$inc]['populateBugReplyList'] = $this->populateBugReplyList($row['bug_id']);
						$populateBugsList_arr[$inc]['replySpanIDId'] = 'replySpanID_'.$row['bug_id'];
						if($row['status'] == 'Open')
							{
								$populateBugsList_arr[$inc]['replybugs_open']['url'] = $this->CFG['site']['url'].'admin/reportBugs.php';
							}
						else
							{
								$populateBugsList_arr[$inc]['replybugs_open']['url'] = '';
							}
						$inc++;
					}
				return $populateBugsList_arr;
			}

		/**
		 * BugHandler::updateBugStatus()
		 * To update the bug status
		 *
		 * @param  string $table_name bug id
		 * @param  string $status status
		 * @return
		 * @access 	public
		 */
		public function updateBugStatus($table_name, $status)
		    {
				if(!$this->fields_arr['bug_ids'])
					return ;

				$id = $this->fields_arr['bug_ids'];
				$date_closed = '';
				if ($status == 'Closed')
					$date_closed = ', date_closed = NOW()';
				$sql = 'UPDATE '.$table_name.' SET status='.$this->dbObj->Param($status).$date_closed.' WHERE bug_id IN ('.$id.') OR parent_id IN ('.$id.')'.
					' AND status =\'Open\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($status));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				$post_value = 'bid='.$id.'&bsite='.urlencode($this->CFG['site']['url']).'&sitename='.urlencode($this->CFG['site']['name']).'&bstatus=Closed';
				postForm($this->CFG['members']['receivebugs'], $post_value);
		    }

		/**
		 * BugHandler::populateBugReplyListAjax()
		 * To populate bug reply list
		 *
		 * @param  string $bid bug id
		 * @return
		 * @access 	public
		 */
		public function populateBugReplyListAjax($bid)
			{
				global $smartyObj, $LANG,$CFG ;
				$sql = 'SELECT bug_id, bug_content, '.
						' date_added , status, parent_id, reply_from'.
						' FROM '.$this->CFG['db']['tbl']['bugs'].' WHERE'.
						' parent_id = '.$this->dbObj->Param('bug_id').'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($bid));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$populateBugReplyList_arr = array();
				if($rs->PO_RecordCount())
					{
						$inc = 0;
						while($row = $rs->FetchRow())
							{
								$row['bug_content'] = nl2br(wordWrapManual($row['bug_content'], 200));
								//$row['bug_content'] = html_entity_decode($row['bug_content'], ENT_QUOTES);
								$populateBugReplyList_arr[$inc]['record'] = $row;

								$populateBugReplyList_arr[$inc]['replySpanIDId'] = 'replySpanID_'.$row['bug_id'];
								if($row['status'] == 'Open')
									{
									$populateBugReplyList_arr[$inc]['replybugs_open']['url'] = $this->CFG['site']['url'].'admin/reportBugs.php';
									}
								$inc++;
							}
					}
			if($this->getFormField('success') == 'success')
				$smartyObj->assign('success','success');
			else
				$smartyObj->assign('success','');
			$smartyObj->assign('LANG',$LANG);
			$smartyObj->assign('sitename',$this->CFG['site']['name']);
			$smartyObj->assign('populateBugReplyList_arr',$populateBugReplyList_arr);
			setTemplateFolder('admin/');
			$smartyObj->display('replyBugsListAjax.tpl');
			}

		/**
		 * BugHandler::getParentBugDetails()
		 * To get main bug details
		 *
		 * @param  int $bug_id bug id
		 * @return array
		 * @access 	public
		 */
		public function getParentBugDetails($bug_id)
			{
				$sql = 'SELECT  bug_id, bug_content,secret_key '.
						' FROM '.$this->CFG['db']['tbl']['bugs'].' WHERE'.
						' bug_id = '.$this->dbObj->Param('bid');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($bug_id));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				if($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						return $row;
					}

			}

		/**
		 * BugHandler::getParentBugDetails()
		 * To post reply
		 *
		 * @param  int $bid bug id
		 * @param  int $parent_id parent id
		 * @param  string $parent_bug_content parent bug content
		 * @param  string $secret_key secret key
		 * @return
		 * @access 	public
		 */
		public function addReply($bid, $parent_id,$parent_bug_content,$secret_key)
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['bugs'].' SET'.
						' bug_content = '.$this->dbObj->Param('user_reply').','.
						' parent_id = '.$parent_id.','.
						' reply_from = '.$this->dbObj->Param('sitename').','.
						' secret_key = ' . $this->dbObj->Param('secret_key') . ','.
						' date_added = NOW()';
				$stmt = $this->dbObj->Prepare($sql);

				$rs = $this->dbObj->Execute($stmt, array($this->getFormField('message'), $this->CFG['site']['name'], $secret_key));
					if (!$rs)
						trigger_db_error($this->dbObj);

				$bug_id = $this->dbObj->Insert_ID();

				$post_value = 'bid='.$bug_id.'&bcontent='.urlencode($this->getFormField('message')).
							'&bsite='.urlencode($this->CFG['site']['url']).'&parent_id='.$parent_id.'&reply=reply&parent_bug_content='.urlencode($parent_bug_content).
							'&sitename='.urlencode($this->CFG['site']['name']).'&skey=' . $secret_key.'&parent_id=' . $parent_id;

				postForm($this->CFG['members']['receivebugs'], $post_value);

			}
    }
//<<<<<---------------- Class BugHandler ends -------------//
//--------------------- Code begins -------------------->>>>>//
$BugHandler = new BugHandler();
$BugHandler->setPageBlockNames(array('block_reportbugs', 'block_bugs_list','cancel_option_to_reply', 'show_option_to_reply', 'post_your_reply'));
//set the form field
$BugHandler->restoreFormFields();
$BugHandler->setAllPageBlocksHide();
$BugHandler->setPageBlockShow('block_reportbugs');
$BugHandler->setPageBlockShow('block_bugs_list');

$BugHandler->setFormField('order', 'open');
$BugHandler->setFormField('mode', '');
$BugHandler->setFormField('bug_ids', '');
$BugHandler->setFormField('action', '');
$BugHandler->setFormField('showOptionToReply', '');
$BugHandler->setFormField('reply', '');
$BugHandler->setFormField('bug_id', '');
$BugHandler->setFormField('parent_id', '');
$BugHandler->setFormField('bug_content', '');
$BugHandler->setFormField('message', '');
$BugHandler->setFormField('not_id', '');
$BugHandler->setFormField('success', '');
$BugHandler->setFormField('cancelOptionToReply', '');
$BugHandler->setFormField('bid', '');

/*********** Page Navigation Start *********/
$BugHandler->setFormField('numpg', 100);
$BugHandler->setFormField('orderby_field', 'date_added');
$BugHandler->setFormField('orderby', 'DESC');
$BugHandler->setTableNames(array($CFG['db']['tbl']['bugs']));
$BugHandler->setReturnColumns(array('bug_id', 'bug_subject', 'bug_content', 'date_added', 'status', 'reply_from', 'parent_id'));
/************ page Navigation stop *************/

$BugHandler->sanitizeFormInputs($_REQUEST);

if(isAjaxPage())
	{
		if ($BugHandler->isFormPOSTed($_REQUEST, 'postYourReply'))
			{
				$BugHandler->sanitizeFormInputs($_REQUEST);
				if ($BugHandler->getFormField('bug_id'))
					{
						$smartyObj->assign('bug_id',$BugHandler->getFormField('bug_id'));
						$BugHandler->chkIsNotEmpty('message', $BugHandler->LANG['err_tip_compulsory']);

						if ($BugHandler->isValidFormInputs())
							{
								$parent_details = $BugHandler->getParentBugDetails($BugHandler->getFormField('bug_id'));
								$BugHandler->addReply($BugHandler->getFormField('bug_id'),$parent_details['bug_id'], $parent_details['bug_content'],$parent_details['secret_key'] );
								$BugHandler->setFormField('success', 'success');
								$BugHandler->setCommonSuccessMsg($LANG['reportbugsreply_success']);
								$BugHandler->setPageBlockShow('block_msg_form_success');
								echo 'success|';
								$BugHandler->populateBugReplyListAjax($BugHandler->getFormField('bug_id'));
								exit;
							}
						else
							{
								echo 'error|';
								$BugHandler->setCommonErrorMsg($LANG['common_msg_error_sorry']);
								$BugHandler->setPageBlockShow('block_msg_form_error');
								$BugHandler->includeAjaxHeader();
								setTemplateFolder('admin/');
								$smartyObj->display('replyBugsAjax.tpl');
								$BugHandler->includeAjaxFooter();
								exit;
							}
					}

			}
	}

if ($BugHandler->isFormPOSTed($_POST, 'submit_reportbugs'))
	{
		$BugHandler->chkIsNotEmpty('subject', $BugHandler->LANG['common_err_tip_compulsory']);
		$BugHandler->chkIsNotEmpty('message', $BugHandler->LANG['common_err_tip_compulsory']);

		if ($BugHandler->isValidFormInputs())
			{
				$BugHandler->storeBugs($LANG_LIST_ARR['bug_category']);
				$BugHandler->setCommonSuccessMsg($BugHandler->LANG['reportbugs_success']);
				$BugHandler->setPageBlockShow('block_msg_form_success');
				$BugHandler->restoreFormFields();
			}
		else
			{
				$BugHandler->setCommonSuccessMsg($BugHandler->LANG['common_msg_error_sorry']);
				$BugHandler->setPageBlockShow('block_msg_form_success');
			}
	}
elseif($BugHandler->isFormPOSTed($_POST, 'action') and $BugHandler->getFormField('bug_ids'))
	{
		$BugHandler->updateBugStatus($CFG['db']['tbl']['bugs'], 'Closed');
		$BugHandler->setAllPageBlocksHide();
		$BugHandler->setFormField('start', '0');
		$BugHandler->setPageBlockShow('block_bugs_list');
		$BugHandler->setPageBlockShow('block_msg_form_success');
		$BugHandler->setCommonSuccessMsg($LANG['bug_status_updated_succesfully']);

	}

if($BugHandler->isShowPageBlock('block_bugs_list'))
	{
		$BugHandler->list_records_confirm_arr = array('start', 'numpg');
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
$smartyObj->assign('bug_list_array', $LANG_LIST_ARR['bug_category']);
//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//
if ($BugHandler->isShowPageBlock('block_bugs_list'))
	{
		$smartyObj->assign('smarty_paging_list', $BugHandler->populatePageLinksPOST($BugHandler->getFormField('start'), 'selListStaticForm'));
		$BugHandler->block_sel_page_list['hidden_arr'] = array('orderby','orderby_field','start', 'order');
		$BugHandler->block_sel_page_list['populateBugsList'] = $BugHandler->populateBugsList();
	}
setPageTitle($LANG['reportbugs_title']);
$BugHandler->left_navigation_div = 'generalManageBugs';
//include the header file
$BugHandler->includeHeader();
//include the content of the page
setTemplateFolder('admin/');
$smartyObj->display('reportBugs.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$BugHandler->includeFooter();
?>
