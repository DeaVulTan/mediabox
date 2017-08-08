<?php
/**
 * File to allow the users to show the member block
 *
 * Provides an interface to show the member block
 *
 *
 * @category	Rayzz
 * @package		Index
 */
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/members/memberBlock.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------- Class MemberBlockFormHandler begins --------------->>>>>//
/**
 * This class is used to show member block
 *
 * @category	Rayzz
 * @package		Index
 */
class MemberBlockFormHandler extends ListRecordsHandler
	{
		public $user_details;

		/**
		 * To check the user_id is valid
		 *
		 * @access public
		 * @return void
		 **/
		public function chkIsValidUserId($user_id_field_name='', $err_tip='')
			{
				$blockUserId = $this->getCurrentUserIdToBlock();
				$loggedUserId = $this->getLoggedInUserId();
				if ($blockUserId == $loggedUserId)
					{
						$this->setCommonErrorMsg($this->LANG['memberblock_err_tip_same_user']);
						return FALSE;
				    }
				$sql = 'SELECT user_name, first_name, last_name, email'.
						' FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_id = '.$this->dbObj->Param($blockUserId);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($blockUserId));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$valid = false;
				if ($rs->PO_RecordCount())
					{
			         	$this->user_details = $rs->FetchRow();
						$valid = true;
					}
				else
					{
						$this->setCommonErrorMsg($err_tip);
					}
				return $valid;
			}

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function alreadyBlocked()
			{
				$blockUserId = $this->getCurrentUserIdToBlock();
				$loggedUserId = $this->getLoggedInUserId();
				$sql = 'SELECT COUNT(id) AS count'.
						' FROM '.$this->CFG['db']['tbl']['block_members'].
						' WHERE user_id = '.$this->dbObj->Param($loggedUserId).
						' AND block_id='.$this->dbObj->Param($blockUserId);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($loggedUserId, $blockUserId));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $row['count'];
			}

		/**
		 * MemberBlockFormHandler::getCurrentUserIdToBlock()
		 *
		 * @return
		 */
		public function getCurrentUserIdToBlock()
			{
				return $this->fields_arr['block_id'];
			}

		/**
		 * MemberBlockFormHandler::getLoggedInUserId()
		 *
		 * @return
		 */
		public function getLoggedInUserId()
			{
				return $this->CFG['user']['user_id'];
			}

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function blockUser()
			{
				$this->unblockUser();
				$blockUserId = $this->getCurrentUserIdToBlock();
				$loggedUserId = $this->getLoggedInUserId();
				$sql = 	'INSERT INTO '.$this->CFG['db']['tbl']['block_members'].
						' SET user_id ='.$this->dbObj->Param($loggedUserId).
						', block_id='.$this->dbObj->Param($blockUserId).
						', date_added = NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($loggedUserId, $blockUserId));
				if (!$rs)
				    trigger_db_error($this->dbObj);

				return TRUE;
			}

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function unblockUser()
			{
				$blockUserId = $this->getCurrentUserIdToBlock();
				$loggedUserId = $this->getLoggedInUserId();

				$sql = 	'DELETE FROM ' . $this->CFG['db']['tbl']['block_members'].
						' WHERE user_id ='.$this->dbObj->Param($loggedUserId).
						' AND block_id='.$this->dbObj->Param($blockUserId);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($loggedUserId, $blockUserId));
				if (!$rs)
				    trigger_db_error($this->dbObj);
			}

		/**
		 * set the condition
		 *
		 * @access public
		 * @return void
		 **/
		public function buildConditionQuery()
			{
				$loggedUserId = $this->getLoggedInUserId();
				$condition = 'b.block_id = u.user_id AND b.user_id = \''.addslashes($loggedUserId).'\'';
				$this->sql_condition = $condition;
			}

		/**
		 * To sort the query
		 *
		 * @access public
		 * @return void
		 **/
		public function checkSortQuery($field, $sort='asc')
			{
				if(!($this->sql_sort))
					{
						$this->sql_sort = $field . ' ' . $sort;
					}
			}

		/**
		 * To display the forums titles
		 *
		 * @access public
		 * @return void
		 **/
		public function showBlockList()
			{
				$showBlockList_arr = array();
				//$i += $this->fields_arr['start'];
				$inc = 0;
				$showBlockList_arr['row'] = array();
				while($row = $this->fetchResultRecord())
					{
						$showBlockList_arr['row'][$inc]['record'] = $row;
						$showBlockList_arr['row'][$inc]['chk'] = '';
						if((is_array($this->fields_arr['block_ids'])) && (in_array($row['id'], $this->fields_arr['block_ids'])))
							$showBlockList_arr['row'][$inc]['chk'] = 'CHECKED';
						$showBlockList_arr['row'][$inc]['icon'] = getMemberAvatarDetails($row['block_id']);
						$showBlockList_arr['row'][$inc]['getMemberProfileUrl'] = getMemberProfileUrl($row['block_id'], $row['user_name']);
						$showBlockList_arr['row'][$inc]['name'] = getUserDisplayName($row);
						$inc++;
					}
				return $showBlockList_arr;
			}

		/**
		 * MemberBlockFormHandler::unblockMember()
		 *
		 * @return
		 */
		public function unblockMember()
			{
				$block_ids = $this->fields_arr['block_ids'];
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['block_members'].
						' WHERE id IN ('.$block_ids.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				    trigger_db_error($this->dbObj);

				return $this->dbObj->Affected_Rows();
			}
	}
//<<<<<-------------- Class MemberBlockFormHandler begins ---------------//
//-------------------- Code begins -------------->>>>>//
$memberblock = new MemberBlockFormHandler();
$memberblock->setPageBlockNames(array('msg_form_success_block_unblock', 'msg_form_success_unblock' , 'form_block', 'form_block_listing'));
//default form fields and values...
$memberblock->setFormField('block_id', '');
$memberblock->setFormField('unblock_id', '');
$memberblock->setFormField('action', '');
$memberblock->setFormField('start', 0);
$memberblock->setFormField('numpg', $CFG['data_tbl']['numpg']);
//$memberblock->setFormField('numpg', 2);
$memberblock->setFormField('block_ids', array());
$memberblock->setReturnColumns(array());
$memberblock->sanitizeFormInputs($_REQUEST);
$memberblock->setAllPageBlocksHide();
if ($memberblock->isFormGETed($_GET, 'start'))
	{
        $memberblock->sanitizeFormInputs($_GET);
	}
if ($memberblock->isFormGETed($_GET, 'block_id'))
	{
        $memberblock->sanitizeFormInputs($_GET);
		$memberblock->chkIsNotEmpty('block_id', $LANG['memberblock_err_tip_compulsory']) AND
			$memberblock->chkIsValidUserId('block_id', $LANG['memberblock_err_tip_invalid_user_id']);
		$memberblock->setAllPageBlocksHide();
		if ($memberblock->isValidFormInputs())
			{
				if ($memberblock->alreadyBlocked())
					{
                        $memberblock->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$memberblock->setPageBlockShow('block_msg_form_error');
				    }
				else
					{
						$information = $LANG['memberblock_confirmation_block'];
						$memberblock->action = $LANG['memberblock_block'];
						$memberblock->setPageBlockShow('form_block');
					}
			}
		else
			{
				$memberblock->setPageBlockShow('block_msg_form_error');
			}
	}
if ($memberblock->isFormGETed($_GET, 'unblock_id'))
	{
	    $memberblock->setFormField('block_id', $memberblock->getFormField('unblock_id'));
        $memberblock->sanitizeFormInputs($_GET);
		$memberblock->chkIsNotEmpty('block_id', $LANG['memberblock_err_tip_compulsory']) AND
			$memberblock->chkIsValidUserId('block_id', $LANG['memberblock_err_tip_invalid_user_id']);
		$memberblock->setAllPageBlocksHide();
		if ($memberblock->isValidFormInputs())
			{
				if ($memberblock->alreadyBlocked())
					{
						$information = $LANG['memberblock_confirmation_unblock'];
						$memberblock->action = $LANG['memberblock_unblock'];
						$memberblock->setPageBlockShow('form_block');
				    }
				else
					{
					 	$memberblock->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$memberblock->setPageBlockShow('block_msg_form_error');
//						$information = $LANG['memberblock_confirmation_block'];
//						$memberblock->action = $LANG['memberblock_block'];
					}
			}
		else
			{
				$memberblock->setPageBlockShow('block_msg_form_error');
			}
	}

if ($memberblock->getFormField('action') == 'Block')
	{
		$memberblock->sanitizeFormInputs($_POST);
        $memberblock->chkIsNotEmpty('block_id', $LANG['memberblock_err_tip_compulsory']) AND
			$memberblock->chkIsValidUserId('block_id', $LANG['memberblock_err_tip_invalid_user_id']);

		$memberblock->isValidFormInputs() AND
			$memberblock->blockUser();

		if ($memberblock->isValidFormInputs())
			{
				$myobj->success_msg = $LANG['memberblock_block_success'];
				$memberblock->setCommonSuccessMsg($LANG['memberblock_block_success']);
				$memberblock->setPageBlockShow('block_msg_form_success');
				$memberblock->setPageBlockShow('msg_form_success_block_unblock');
			}
		else
			{
				$memberblock->setPageBlockShow('block_msg_form_error');
				$memberblock->setPageBlockShow('form_block');
			}
		$memberblock->setPageBlockShow('form_block_listing');
    }
if ($memberblock->getFormField('action') == 'Unblock')
	{
		$memberblock->sanitizeFormInputs($_POST);
        $memberblock->chkIsNotEmpty('block_id', $LANG['memberblock_err_tip_compulsory']) AND
			$memberblock->chkIsValidUserId('block_id', $LANG['memberblock_err_tip_invalid_user_id']);
		$memberblock->isValidFormInputs() AND
			$memberblock->unblockUser();
		if ($memberblock->isValidFormInputs())
			{
				$myobj->success_msg = $LANG['memberblock_unblock_success'];
				$memberblock->setCommonSuccessMsg($LANG['memberblock_unblock_success']);
				$memberblock->setPageBlockShow('block_msg_form_success');
				$memberblock->setPageBlockShow('msg_form_success_block_unblock');
			}
		else
			{
				$memberblock->setPageBlockShow('block_msg_form_error');
				$memberblock->setPageBlockShow('form_block');
			}

		$memberblock->setPageBlockShow('form_block_listing');
    }
if($memberblock->getFormField('action') == 'blocklist_unblock')
	{
		$memberblock->sanitizeFormInputs($_POST);
		$memberblock->chkIsNotEmpty('block_ids', $LANG['blocklist_err_tip_compulsory'])or
		$memberblock->setCommonErrorMsg($LANG['blocklist_select_message']);
		if ($memberblock->isValidFormInputs())
			{
				$unblocked = $memberblock->unblockMember();
				if ($unblocked)
				    {
						$memberblock->setPageBlockShow('msg_form_success_unblock');
						$memberblock->setFormField('block_ids', array());
				    }
			}
		else
			{
				$memberblock->setCommonErrorMsg($LANG['blocklist_invalid']);
				$memberblock->setPageBlockShow('block_msg_form_error');
			}
	}
if($memberblock->getFormField('block_id')=='' && $memberblock->getFormField('unblock_id')=='')
	{
		$memberblock->setPageBlockShow('form_block_listing');
	}
$memberblock->formDefaultAction = getUrl('memberblock','','','members');
//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($memberblock->isShowPageBlock('msg_form_success_block_unblock') AND isset($myobj->success_msg) AND $myobj->success_msg)
    {
		$user_id = $memberblock->getFormField('block_id');
		if (isset($memberblock->user_details['user_name']) AND $memberblock->user_details['user_name'])
		    {
		        $memberblock->chkIsValidUserId($user_id, '');
		    }
		$user_name = $memberblock->user_details['user_name'];
		$memberblock->msg_form_success_block_unblock['blockUserProfileUrl'] = getMemberProfileUrl($user_id, $user_name);
	}
if ($memberblock->isShowPageBlock('form_block'))
	{
		$memberblock->form_block['user_id'] =  $memberblock->getFormField('block_id');
		$memberblock->form_block['user_name'] = $memberblock->user_details['user_name'];
		$memberblock->form_block['blockUserProfileUrl'] =  $blockUserProfileUrl = getMemberProfileUrl($memberblock->form_block['user_id'], $memberblock->form_block['user_name']);
		$memberblock->form_block['user_name'] = '<a href="'.$blockUserProfileUrl.'">'.$memberblock->user_details['user_name'].'</a>';
		$memberblock->form_block['nl2br_user_name'] = nl2br(str_replace('VAR_USER_NAME', $memberblock->form_block['user_name'] , $information ));
	}
if ($memberblock->isShowPageBlock('form_block_listing'))
	{
		$memberblock->setMinRecordSelectLimit($CFG['data_tbl']['min_record_select_limit']);
		$memberblock->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
		$memberblock->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
		//Set tables and fields to return
		$memberblock->setTableNames(array($CFG['db']['tbl']['block_members'].' as b', $CFG['db']['tbl']['users'].' as u'));
		$memberblock->setReturnColumns(array('b.id, b.block_id, b.user_id, b.date_added AS date_added, u.first_name, u.last_name, u.sex, u.user_name, u.icon_type,u.image_ext, u.icon_id'));
		$memberblock->buildSelectQuery();
		$memberblock->buildConditionQuery();
		$memberblock->buildSortQuery();
		$memberblock->checkSortQuery('b.id', 'desc');
		$memberblock->buildQuery();
		$memberblock->executeQuery();
		$memberblock->paging_arr = array();
		if ($memberblock->isResultsFound())
		    {
				$memberblock->paging_arr = array();
				$smartyObj->assign('smarty_paging_list', $memberblock->populatePageLinksGET($memberblock->getFormField('start'), $memberblock->paging_arr));
		        $memberblock->form_block_listing['showBlockList'] =  $memberblock->showBlockList();
			}
	}
//include the header file
$memberblock->includeHeader();
//include the content of the page
setTemplateFolder('members/');
$smartyObj->display('memberBlock.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
?>
	<script language="javascript" type="text/javascript">
		var block_arr= new Array('selMsgConfirm');
		var please_select_action = '<?php echo $LANG['err_tip_select_action'];?>';
		var confirm_message = '';
		function getAction() {
			$Jq('#confirmMessage').html('<?php echo $LANG['memberblock_selectblock_confirm_message'];?>');
			document.msgConfirmform.action.value = 'Unblock';
			Confirmation('selMsgConfirm', 'msgConfirmform', Array('block_ids', 'action'), Array(multiCheckValue, 'blocklist_unblock'), Array('value', 'value'),'selFormForums');
		}
	</script>
<?php
$memberblock->includeFooter();
?>