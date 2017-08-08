<?php
/**
 * This file Display the History of invitation sent to the friend.
 *
 * PHP version 5.0
 *
 * @category	Rayzz
 * @package		Members
 */
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'common/configs/config_members.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/members/invitationHistory.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FriendHandler.lib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
require($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------------------class InviteHistoryHandler-------------------->>>
/**
 * This class is used to display the invite friends
 *
 * @category	Rayzz
 * @package		Members
 */
class InviteHistoryHandler extends ListRecordsHandler
	{
		/**
		 * InviteHistoryHandler::buildConditionQuery()
		 * To set sql query condition
		 *
		 * @return string
		 * @access public
		 */
		public function buildConditionQuery()
			{
				$this->sql_condition = ' user_id='.$this->CFG['user']['user_id'];
			}

		/**
		 * InviteHistoryHandler::displayHistory()
		 * To set display values
		 *
		 * @return array
		 * @access public
		 */
		public function displayHistory()
			{
				$data_arr = array();
				$inc = 0;

				while($row = $this->fetchResultRecord())
					{
						$uDetails = $this->isMemberJoined($row['email']);
						$statusClass = '';
						$status = $this->LANG['invitation_history_email_status_not_joined'];
						if ($uDetails)
						    {
								$status = $this->LANG['invitation_history_email_status_joined'];
						    }

						$data_arr[$inc]['date_added']      = $row['date_added'];
						$data_arr[$inc]['attempts']        = $row['attempts'];
						$data_arr[$inc]['email']           = $row['email'];
						$data_arr[$inc]['class']           = ($uDetails)?'clsJoined':'clsNotJoined';;
						$data_arr[$inc]['status']          = $status;
						$data_arr[$inc]['remind_url']      = getUrl('invitationhistory', '?action=remind&id='.$row['invitation_id'].'&start='.$this->fields_arr['start'], '?action=remind&id='.$row['invitation_id'].'&start='.$this->fields_arr['start']);
						$data_arr[$inc]['delete_url']      = getUrl('invitationhistory', '?action=delete&id='.$row['invitation_id'].'&start'.$this->fields_arr['start'], '?action=delete&id='.$row['invitation_id'].'&start'.$this->fields_arr['start']);
						$data_arr[$inc]['check_box_value'] = $row['invitation_id'];
						$inc++;
					}
				return $data_arr;
			}

		/**
		 * InviteHistoryHandler::populateHiddenFormFields()
		 * To set the hidden form field values
		 *
		 * @param  array $form_fields
		 * @return array
		 * @access public
		 */
		public function populateHiddenFormFields($form_fields = array())
			{
				$hiddenFormFields = array();
				if (is_array($form_fields) and $form_fields)
				    {
				        $inc = 0;
						while($field = array_shift($form_fields))
				            {
				        	    if (isset($this->fields_arr[$field]))
				        	        {
										$hiddenFormFields[$inc]['field_name']  = $field;
										$hiddenFormFields[$inc]['field_value'] = $this->fields_arr[$field];
				        	        	$inc++;
									}
				            }
				        return $hiddenFormFields;
				    }
			}

		/**
		 * InviteHistoryHandler::removeInvitation()
		 * Remove the selected id values from the users invitation table
		 *
		 * @param  integer $id
		 * @return boolean
		 * @access public
		 */
		public function removeInvitation($id = 0)
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['users_invitation'].
						' WHERE invitation_id='.$this->dbObj->Param($id);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($id));
				if (!$rs)
				    trigger_db_error($this->dbObj);

				return ($this->dbObj->Affected_Rows());
			}

		 /**
		  * InviteHistoryHandler::remindTheseInvitations()
		  * To send the reminder mail to selected users
		  *
		  * @param array $invitation_ids
		  * @return boolean
		  * @access public
		  */
		 public function remindTheseInvitations($invitation_ids = array())
			{
				$friendHandler = new FriendHandler();
				$friendHandler->setDBObject($this->dbObj);
				$friendHandler->makeGlobalize($this->CFG, $this->LANG);
				if (is_array($invitation_ids) and $invitation_ids)
				    {
				        for($i=0; $i<sizeof($invitation_ids); $i++)
							{
								$id = $invitation_ids[$i];
								if (is_numeric($id))
								    {
								        $friendHandler->remindFriendInvitaion($id);
								    }
							}
				    }
				return true;
			}

		/**
		 * InviteHistoryHandler::isMemberJoined()
		 * To check whether the user joined or not
		 *
		 * @param  string $email
		 * @return array
		 * @access public
		 */
		public function isMemberJoined($email='')
			{
				$sql = 'SELECT user_name, first_name, last_name, user_id'.
						' FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE email='.$this->dbObj->Param($email).
						' AND usr_status=\'Ok\' LIMIT 1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($email));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$user_details = array();
				if ($rs->PO_RecordCount())
					{
						$user_details = $rs->FetchRow();
					}
				return $user_details;
			}
	}
//<<<<<---------------class InviteHistoryHandler------///
//--------------------Code begins-------------->>>>>//
$invitefrm = new InviteHistoryHandler();
$invitefrm->setPageBlockNames(array('msg_form_alert' ,'form_invite_history', 'form_confirm_delete'));
$invitefrm->setAllPageBlocksHide();
$invitefrm->setPageBlockShow('form_invite_history');
$invitefrm->makeGlobalize($CFG, $LANG);
$invitefrm->setFormField('user_id', $CFG['user']['user_id']);
$invitefrm->setFormField('numpg', $CFG['data_tbl']['numpg']);
$invitefrm->setFormField('start', '0');
$invitefrm->setFormField('asc', array());
$invitefrm->setFormField('dsc', array());
$invitefrm->setFormField('action', '');
$invitefrm->setFormField('id', '');
$invitefrm->setFormField('email', '');
$invitefrm->setMinRecordSelectLimit(2);
$invitefrm->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$invitefrm->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$invitefrm->setTableNames(array($CFG['db']['tbl']['users_invitation']));
$invitefrm->setReturnColumns(array( 'invitation_id', 'email', 'attempts', 'date_added'));

if ($invitefrm->isPageGETed($_GET, 'start'))
    {
		$invitefrm->sanitizeFormInputs($_GET);
		$start = $invitefrm->getFormField('start');
		if (!is_numeric($start))
		    {
				$invitefrm->setFormField('start', 0);
		    }
		else{
				$invitefrm->setFormField('start', abs($start));
			}
    }

if ($invitefrm->isPageGETed($_REQUEST, 'action') AND $invitefrm->isPageGETed($_REQUEST, 'id'))
    {
     	$invitefrm->setFormField('action', '');
		$invitefrm->sanitizeFormInputs($_REQUEST);
		$action = $invitefrm->getFormField('action');
		$id = $invitefrm->getFormField('id');
		if ($action)
		    {
				if (strcmp($action ,'delete') ==0 )
				    {
						$id = $invitefrm->getFormField('id');
						$removed = $invitefrm->removeInvitation($id);
						if ($removed)
						    {
								$invitefrm->setPageBlockShow('block_msg_form_success');
						        $invitefrm->setCommonSuccessMsg($LANG['invitation_history_msg_invitation_deleted']);;
						    }
					}
				else if (strcmp($action, 'remind') ==0 )
			        {
						$invitefrm->remindTheseInvitations(array($id));
				        $invitefrm->setPageBlockShow('block_msg_form_success');
						$invitefrm->setCommonSuccessMsg($LANG['invitation_history_msg_inviataion_reminded']);
						$invitefrm->setPageBlockShow('form_invite_history');
			        }
				else
					{
						$invitefrm->setAllPageBlocksHide();
						$invitefrm->setPageBlockShow('form_invite_history');
					}
			}
    }

if ($invitefrm->isFormPOSTed($_POST, 'remind_submit'))
    {
		$invitefrm->setFormField('history_id', array());
        $invitefrm->sanitizeFormInputs($_POST);
		$history = $invitefrm->getFormField('history_id');
		if ($history)
		    {
		        $invitefrm->remindTheseInvitations($history);
				$invitefrm->setCommonSuccessMsg($LANG['invitation_history_msg_inviataion_reminded']);
				$invitefrm->setPageBlockShow('block_msg_form_success');
		    }
		else
			{
				$invitefrm->setCommonErrorMsg($LANG['invitation_history_err_tip_empty_reminds']);
				$invitefrm->setPageBlockShow('block_msg_form_error');
			}
    }

if ($invitefrm->isShowPageBlock('form_invite_history'))
	{
		$invitefrm->buildSelectQuery();
		$invitefrm->buildConditionQuery();
		$invitefrm->buildSortQuery();
		$invitefrm->buildQuery();
		$invitefrm->executeQuery();
		$start = $invitefrm->getFormField('start');
		$resultTotal = $invitefrm->getResultsTotalNum();
		if (!$resultTotal)
		    {
				$invitefrm->setPageBlockShow('block_msg_form_error');
				$invitefrm->setCommonErrorMsg($LANG['common_no_records_found']);
		     	$invitefrm->setPageBlockHide('form_invite_history');
		    }
		$invitefrm->form_invitaion_history['dateOrderByUrl']     = URL($invitefrm->getColumnHeaderAHref('date_added'));
		$invitefrm->form_invitaion_history['dateOrderByTitle']   = $invitefrm->getColumnHeaderATitle('date_added');
		$invitefrm->form_invitaion_history['pageActionUrl']      = getUrl('invitationhistory', '?start='.$invitefrm->getFormField('start'), '?start='.$invitefrm->getFormField('start'));
		$invitefrm->form_invitaion_history['startValue']         = $start;
		$invitefrm->form_invitaion_history['inviteHistory']      = $invitefrm->displayHistory();
		$invitefrm->form_invitaion_history['showPopulateHidden'] = $invitefrm->populateHiddenFormFields(array('start', 'id'));
		$smartyObj->assign('smarty_paging_list', $invitefrm->populatePageLinksGET($invitefrm->getFormField('start')));
	}

$invitefrm->includeHeader();
setTemplateFolder('members/');
$smartyObj->display('invitationHistory.tpl');
$invitefrm->includeFooter();
?>