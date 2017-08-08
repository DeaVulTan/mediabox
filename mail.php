<?php
/**
 * View messages
 *
 * PHP version 5.0
 *
 * @category	###Rayzz###
 * @package		###Members###
 * @author 		selvaraj_47ag04
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: contactUs.php 170 2008-04-02 09:49:23Z vidhya_29ag04 $
 * @since 		2008-04-02
 **/
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/members/mail.php';
$CFG['lang']['include_files'][] = 'languages/%s/members/mailRightLinks.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MailHandler.lib.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//--------------class MailFormHandler--------------->>>//
/**
 * MailFormHandler
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class MailFormHandler extends MailHandler
	{
		/**
		 * To sort the query
		 *
		 * @access public
		 * @return void
		 **/
		public function checkSortQuery($field, $sort='asc')
			{
				$this->sql_sort = $this->fields_arr['orderby_field'].' '.$this->fields_arr['orderby'];
			}

		/**
		 *
		 * @access public
		 * @return void
		 **/

		public function buildMailQuery()
		    {
				switch($this->fields_arr['folder']){
					case 'inbox':
						$this->setTableNames(array($this->CFG['db']['tbl']['users'].' AS u', $this->CFG['db']['tbl']['messages'].' AS m', $this->CFG['db']['tbl']['messages_info'].' AS mi'));
						$this->setReturnColumns(array('mi.info_id, mi.message_id, mi.to_id, mi.from_id, mi.email_status, mi.to_stored, mi.from_stored, u.user_id, u.user_name, u.last_name, u.first_name, u.sex, m.subject, m.mess_date, mi.to_viewed, mi.to_answer, attachment, u.icon_type,u.image_ext, u.icon_id'));
						//Condition of the query
						$condition = 'mi.to_id = \''.$this->CFG['user']['user_id'].
										'\' AND mi.from_id = u.user_id AND mi.message_id = m.message_id'.
										' AND mi.to_delete = \'No\' AND mi.to_stored = \'No\'';

						//if(!chkAllowedModule(array('video')))
							$condition .= ' AND mi.email_status != \'Video\'';

						//sort details of the query
						$this->fields_arr['orderby_field'] = 'mi.info_id';
						$this->fields_arr['orderby'] = 'DESC';
						//page title
						//$this->mail_title = $this->LANG['mail_title_inbox'];
						$this->LANG['mail_page_title'] = $this->LANG['mail_title_inbox'];
						break;
					case 'sent':
						$this->setTableNames(array($this->CFG['db']['tbl']['users'].' AS u', $this->CFG['db']['tbl']['messages'].' AS m', $this->CFG['db']['tbl']['messages_info'].' AS mi'));
						$this->setReturnColumns(array('mi.info_id, mi.message_id, mi.to_id, mi.from_id, mi.email_status, mi.to_stored, mi.from_stored, u.user_id, u.last_name, u.first_name, u.sex, m.subject, m.mess_date, mi.from_viewed, mi.from_answer, attachment, u.user_name, u.icon_type,u.image_ext, u.icon_id'));
						//Condition of the query
						$condition = 'mi.from_id = \''. $this->CFG['user']['user_id'] .'\' AND mi.to_id = u.user_id AND mi.message_id = m.message_id AND mi.from_delete = \'No\' AND mi.from_stored = \'No\' AND mi.email_status != \'Request\'';//AND mi.email_status = \'Normal\'

						//if(!chkAllowedModule(array('video')))
							$condition .= ' AND mi.email_status != \'Video\'';

						//sort details of the query
						$this->fields_arr['orderby_field'] = 'mi.info_id';
						$this->fields_arr['orderby'] = 'DESC';
						//page title
						//$this->mail_title = $this->LANG['mail_title_sent'];
						$this->LANG['mail_page_title'] = $this->LANG['mail_title_sent'];
						break;
					case 'saved':
						$this->setTableNames(array($this->CFG['db']['tbl']['users'].' AS u', $this->CFG['db']['tbl']['messages'].' AS m', $this->CFG['db']['tbl']['messages_info'].' AS mi'));
						$this->setReturnColumns(array('mi.info_id, mi.message_id, mi.to_id, mi.from_id, mi.email_status, mi.to_stored, mi.from_stored, u.user_id, u.last_name, u.first_name, u.sex, m.subject, m.mess_date, mi.from_viewed, mi.to_viewed, mi.from_answer, mi.to_answer, attachment, u.user_name, u.icon_type,u.image_ext, u.icon_id'));
						//Condition of the query
						$condition = '(( mi.to_id = \''. $this->CFG['user']['user_id'] .'\' AND mi.from_id != \''. $this->CFG['user']['user_id'] .'\' AND mi.from_id = u.user_id AND mi.message_id = m.message_id AND mi.to_stored = \'Yes\' AND mi.to_delete = \'No\')';
						$condition .= ' OR (mi.from_id = \''. $this->CFG['user']['user_id'] .'\' AND mi.from_id = u.user_id AND mi.message_id = m.message_id AND mi.from_stored = \'Yes\' AND mi.from_delete = \'No\'))';
						$condition .= ' AND mi.message_id = m.message_id ';

						$condition .= ' AND mi.email_status != \'Video\'';

						//sort details of the query
						$this->fields_arr['orderby_field'] = 'mi.info_id';
						$this->fields_arr['orderby'] = 'DESC';
						//page title
						//$this->mail_title = $this->LANG['mail_title_saved'];
						$this->LANG['mail_page_title'] = $this->LANG['mail_title_saved'];
						break;
					case 'trash':
						$this->setTableNames(array($this->CFG['db']['tbl']['users'].' AS u', $this->CFG['db']['tbl']['messages'].' AS m', $this->CFG['db']['tbl']['messages_info'].' AS mi'));
						$this->setReturnColumns(array('mi.info_id, mi.message_id, mi.to_id, mi.from_id, mi.email_status, mi.to_stored, mi.from_stored, u.user_id, u.last_name, u.first_name, u.sex, m.subject, m.mess_date, mi.from_viewed, mi.to_viewed, mi.from_answer, mi.to_answer, attachment, u.user_name, u.icon_type,u.image_ext, u.icon_id'));
						//Condition of the query
						$condition = '((mi.to_id = \''. $this->CFG['user']['user_id'] .'\' AND mi.from_id != \''. $this->CFG['user']['user_id'] .'\' AND mi.from_id = u.user_id AND mi.message_id = m.message_id AND mi.to_delete = \'Yes\')';
						$condition .= ' OR (mi.from_id = \''. $this->CFG['user']['user_id'] .'\' AND mi.from_id = u.user_id AND mi.message_id = m.message_id AND mi.from_delete = \'Yes\'))';
						$condition .= ' AND mi.message_id = m.message_id ';

						//if(!chkAllowedModule(array('video')))
							$condition .= ' AND mi.email_status != \'Video\'';

						//sort details of the query
						$this->fields_arr['orderby_field'] = 'mi.info_id';
						$this->fields_arr['orderby'] = 'DESC';
						//page title
						//$this->mail_title = $this->LANG['mail_title_trash'];
						$this->LANG['mail_page_title'] = $this->LANG['mail_title_trash'];
						break;
					case 'request':
						$this->setTableNames(array($this->CFG['db']['tbl']['users'].' AS u', $this->CFG['db']['tbl']['messages'].' AS m', $this->CFG['db']['tbl']['messages_info'].' AS mi'));
						$this->setReturnColumns(array('mi.info_id, mi.message_id, mi.to_id, mi.from_id, mi.email_status, mi.to_stored, mi.from_stored, u.user_id, u.last_name, u.first_name, u.sex,m.subject, m.mess_date, mi.to_viewed, mi.to_answer, attachment, u.user_name, u.icon_type,u.image_ext, u.icon_id'));
						$condition = 'mi.to_id = \''. $this->CFG['user']['user_id'] .'\' AND mi.from_id = u.user_id AND mi.message_id = m.message_id AND mi.to_delete = \'No\' AND mi.to_stored = \'No\' AND mi.email_status = \'Request\'';
						//sort details of the query
						$this->fields_arr['orderby_field'] = 'mi.info_id';
						$this->fields_arr['orderby'] = 'DESC';
						//page title
						//$this->mail_title = $this->LANG['mail_title_request'];
						$this->LANG['mail_page_title'] = $this->LANG['mail_title_request'];
						break;
					/*case 'video':
						$this->setTableNames(array($this->CFG['db']['tbl']['users'].' AS u', $this->CFG['db']['tbl']['messages'].' AS m', $this->CFG['db']['tbl']['messages_info'].' AS mi'));
						$this->setReturnColumns(array('mi.info_id, mi.message_id, mi.to_id, mi.from_id, mi.email_status, mi.to_stored, mi.from_stored, u.user_id, u.last_name, u.first_name, u.sex, m.subject, m.mess_date, mi.to_viewed, mi.to_answer, attachment, u.user_name, u.icon_type,u.image_ext, u.icon_id'));
						$condition = 'mi.to_id = \''. $this->CFG['user']['user_id'] .'\' AND mi.from_id = u.user_id AND mi.message_id = m.message_id AND mi.to_delete = \'No\' AND mi.to_stored = \'No\' AND mi.email_status = \'Video\'';
						//sort details of the query
						$this->fields_arr['orderby_field'] = 'mi.info_id';
						$this->fields_arr['orderby'] = 'DESC';
						//page title
						//$this->mail_title = $this->LANG['mail_title_video'];
						$this->LANG['mail_page_title'] = $this->LANG['mail_title_video'];
						break;*/
				} // switch
				$this->sql_condition = $condition;
				$this->buildSelectQuery();
				$this->buildSortQuery();
		    }

		/**
		 * To sort the query
		 *
		 * @access public
		 * @return void
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = $this->fields_arr['orderby_field'].' '.$this->fields_arr['orderby'];
			}

		/**
		 * To populate the messages
		 *
		 * @access public
		 * @return void
		 **/

		 public function populateMessages($no_records)
			{
				global $smartyObj;
				switch($this->fields_arr['folder'])
					{
						case 'sent':
							$this->LANG['sender_name_title'] = $this->LANG['mail_to'];
							break;

						default:
							$this->LANG['sender_name_title'] = $this->LANG['mail_from'];
							break;
					}

				$data_arr = array();
				$inc = 0;

				if(!$this->isResultsFound())
					{
						$smartyObj->assign('selMsgAlert', $no_records);
					}

				while($row = $this->fetchResultRecord())
					{
						$data_arr[$inc] = $row;
						$data_arr[$inc]['subject'] = character_limiter($row['subject'], $this->CFG['admin']['mails']['subject_length'], $this->CFG['word_limiter']['end_character']);
						switch($this->fields_arr['folder'])
							{
								case 'sent':
									$data_arr[$inc]['answer'] = $row['from_answer'];
									$data_arr[$inc]['viewed'] = $row['from_viewed'];
									$userDetails = $this->getUserDetail('user_id', $row['to_id']);
									break;
								case 'saved':
								case 'trash':
									if($row['to_id'] == $this->CFG['user']['user_id'] and $row['to_stored'] == 'Yes')
										{
											$data_arr[$inc]['answer'] = $row['to_answer'];
											$data_arr[$inc]['viewed'] = $row['to_viewed'];
											$userDetails = $this->getUserDetail('user_id', $row['from_id']);
										}
									else
										{
											$data_arr[$inc]['answer'] = $row['from_answer'];
											$data_arr[$inc]['viewed'] = $row['from_viewed'];
											$userDetails = $this->getUserDetail('user_id', $row['to_id']);
										}
									break;
								default:
									$data_arr[$inc]['answer'] = $row['to_answer'];
									$data_arr[$inc]['viewed'] = $row['to_viewed'];
									$userDetails = $this->getUserDetail('user_id', $row['from_id']);
									break;
							}

						$data_arr[$inc] = array_merge($data_arr[$inc],$userDetails);
						//$data_arr[$inc]['display_user_name'] = getUserDisplayName($userDetails);

						$icon = getMemberAvatarDetails($row['user_id']);
						$data_arr[$inc]['user_profile_url']=getMemberProfileUrl($row['user_id'], $row['user_name']);

						$data_arr[$inc]['display_user_name'] = getUserDisplayName($row);
						$data_arr[$inc]['user_profiles_icon']=$icon;
						$data_arr[$inc]['user_profiles_link'] = getUrl('profile', '?uname='.$userDetails['user_name'], $userDetails['user_name'], 'root');

						if ($data_arr[$inc]['answer'] == 'Reply')
							{
								$data_arr[$inc]['row_css'] = 'selRepliedMail';
								$data_arr[$inc]['mail_status'] = $this->LANG['replied'];
							}
						else if ($data_arr[$inc]['answer'] == 'Forward')
							{
								$data_arr[$inc]['row_css'] = 'selForwardedMail';
								$data_arr[$inc]['mail_status'] = $this->LANG['forward'];
							}
						else if ($data_arr[$inc]['viewed'] == 'No')
							{
								$data_arr[$inc]['row_css'] = 'selNotReadMail';
								$data_arr[$inc]['mail_status'] = $this->LANG['new_mail'];
							}
						else
							{
								$data_arr[$inc]['row_css'] = 'selReadMail';
								$data_arr[$inc]['mail_status'] = $this->LANG['read'];
							}

						if($this->getFormField('folder') == 'saved')
							$mail_folder = 'saved';
						elseif($this->getFormField('folder') == 'sent')
							$mail_folder = 'sent';
						elseif($row['email_status'] == 'Video')
							$mail_folder = 'video';
						else
							$mail_folder = $this->getFormField('folder');

						$data_arr[$inc]['mail_read_link'] = getUrl('mailread', '?folder='.$mail_folder.'&amp;message_id='.$row['info_id'], $mail_folder.'/?message_id='.$row['info_id'], 'members');
						$inc++;
					}
				//print_r($data_arr);
				$smartyObj->assign('populateMessages_arr', $data_arr);
			}

		 /**
		 * To delete messages selected
		 *
		 * @param 	string $table_name messages
		 * @param 	array $message_ids selected message ids
		 * @access public
		 * @return boolean
		 **/
		public function deleteMessages($message_ids)
			{
				$message_ids_arr = explode(',', $message_ids);
				foreach($message_ids_arr as $combined_id)
					{
						$id_arr = explode('_', $combined_id);
						$from_id = $id_arr[0];
						$to_id = $id_arr[1];
						$message_id = $id_arr[2];
						if($this->fields_arr['folder']=='trash')
							{
								if ($to_id == $this->CFG['user']['user_id'])
		 							$this->updateMessageStatusTrash('to_delete', $message_id);
								if ($from_id == $this->CFG['user']['user_id'])
									$this->updateMessageStatusTrash('from_delete', $message_id);
							}
						else
							{
								if ($to_id == $this->CFG['user']['user_id'])
		 							$this->updateMessageStatusDelete('to_delete', $message_id);
								if ($from_id == $this->CFG['user']['user_id'])
									$this->updateMessageStatusDelete('from_delete', $message_id);
							}

					}
				if (in_array($this->fields_arr['folder'], $this->updateNewMailInFolder))
						$this->updateNewMailCount();
			}

		/**
		 * To save message selected
		 *
		 * @param 	string $table_name messages
		 * @param 	array $message_ids selected message ids
		 * @access public
		 * @return void
		 **/
		public function saveMessages($message_ids)
			{
				$message_ids_arr = explode(',', $message_ids);
				foreach($message_ids_arr as $combined_id)
					{
						$id_arr = explode('_', $combined_id);
						$from_id = $id_arr[0];
						$to_id = $id_arr[1];
						$message_id = $id_arr[2];
						if ($to_id == $this->CFG['user']['user_id'])
 							$this->updateMessageStatusSave('to_stored', 'to_delete', $message_id);
						if ($from_id == $this->CFG['user']['user_id'])
							$this->updateMessageStatusSave('from_stored', 'from_delete', $message_id);
					}
				if (in_array($this->fields_arr['folder'], $this->updateNewMailInFolder))
						$this->updateNewMailCount();
			}
	}
//<<<<<<<--------------class MailFormHandler---------------//

//--------------------Code begins-------------->>>>>//
$mail = new MailFormHandler();
$mail->mailcompose['populateMailNavigation'] =   $mail->populateMailNavigation();
$mail->mailcompose['countUnReadMail']	     =	$mail->countUnReadMail();
if(!$mail->chkAllowedModule(array('mail')))
	Redirect2URL(getUrl($CFG['redirect']['dsabled_module_url']['file_name']));

$mail->setPageBlockNames(array('block_form_mail', 'block_form_confirm','msg_form_error', 'msg_form_success','msg_form_success_delete', 'msg_form_success_saved'));
$mail->setAllPageBlocksHide();
//default form fields and values...
$mail->setFormField('folder', '');
$mail->setFormField('user_id', '');
$mail->setFormField('message_ids', array());
$mail->setFormField('action', '');

/*********** Page Navigation Start *********/
$mail->setFormField('orderby_field', '');
$mail->setFormField('orderby', '');
$mail->setTableNames(array());
$mail->setReturnColumns(array());
/************ page Navigation stop *************/
$mail->sanitizeFormInputs($_REQUEST);

if (!$mail->chkIsValidFolder())
	{
		$mail->setPageBlockShow('block_msg_form_error');
		$mail->setCommonErrorMsg($mail->LANG['mail_invalid_folder']);
	}
else
	{
		if ($mail->isFormGETed($_GET, 'msg'))
			{
				$mail->setAllPageBlocksHide();
				$mail->setPageBlockShow('msg_form_success');
				$mail->setCommonSuccessMsg($mail->LANG['mail_success_message']);
			}
		if ($mail->isFormGETed($_GET, 'del'))
			{
				$mail->setAllPageBlocksHide();
				$mail->setPageBlockShow('msg_form_success');
				$mail->setCommonSuccessMsg($mail->LANG['mail_success_delete_message']);
			}
		if ($mail->isFormPOSTed($_POST,'confirm'))
			{
				switch($mail->getFormField('action'))
					{
						case 'mail_save':
							$mail->saveMessages($mail->getFormField('message_ids'));
							$mail->setPageBlockShow('block_msg_form_success');
							$mail->setCommonSuccessMsg($LANG['mail_success_saved_message']);
							break;
						case 'mail_delete':
							$mail->deleteMessages($mail->getFormField('message_ids'));
							$mail->setPageBlockShow('block_msg_form_success');
							$mail->setCommonSuccessMsg($mail->LANG['mail_success_delete_message']);
							break;
					} // switch
				$mail->setAllPageBlocksHide();
				$mail->setPageBlockShow('block_msg_form_success');
			}
		if ($mail->isFormPOSTed($_POST, 'cancel'))
			{
				$mail->setAllPageBlocksHide();
				$mail->setFormField('message_ids', array());
				$mail->setFormField('action', '');
			}
		$mail->setPageBlockShow('block_form_mail');
	}
/*************End navigation******/
//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//
if ($mail->isShowPageBlock('block_form_mail'))
	{
		/****** navigtion continue*********/
		$mail->buildMailQuery();
		$mail->buildSortQuery();
		$mail->buildQuery();
		//$mail->printQuery();
		$mail->executeQuery();

		if(!$mail->isResultsFound())
			{
				$mail->setAllPageBlocksHide();
				$mail->setCommonAlertMsg($mail->LANG['common_no_records_found']);
				$mail->setPageBlockShow('block_msg_form_alert');
				$mail->setPageBlockHide('listAdvertisementBlock');
			}
		else
			{
				$mail->msg_confirm_form['msg_confirm_form_hidden_arr']=array('start', 'orderby_field', 'orderby');
				$mail->msg_confirm_form['selFormMail_hidden_arr']= array('start', 'orderby_field', 'orderby');
				$smartyObj->assign('smarty_paging_list', $mail->populatePageLinksGET($mail->getFormField('start'), array('folder')));

				if($mail->getFormField('folder') == 'saved')
					$mail->action_arr = array('mail_delete'=>$mail->LANG['mail_delete']);
				else
					$mail->action_arr = array('mail_save'=>$mail->LANG['mail_save'],'mail_delete'=>$mail->LANG['mail_delete']);

				$smartyObj->assign('action_arr', $mail->action_arr);
				$smartyObj->assign('mail_action_onclick', 'getMultiCheckBoxValue(\'selFormMail\', \'checkall\', \''.$mail->LANG['mail_select_message'].'\');if(multiCheckValue!=\'\'){getAction()}');
				$mail->populateMessages($LANG['no_records']);
			}
	}
//include the header file
$mail->includeHeader();
if ($mail->isShowPageBlock('block_form_mail'))
	{
?>
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgConfirm');
	var please_select_action = '<?php echo $mail->LANG['mail_select_action'];?>';
	var confirm_message = '';
	function getAction() {
		var act_value = document.selFormMail.action.value;
		if(act_value) {
			switch (act_value)
				{
					case 'mail_save':
						confirm_message = '<?php echo $LANG['mail_confirm_save_message'];?>';
						break;
					case 'mail_delete':
						confirm_message = '<?php echo $mail->LANG['mail_confirm_delete_message'];?>';
						break;
				}
			$Jq('#confirmMessage').html(confirm_message);
			document.msgConfirmform.action.value = act_value;
			Confirmation('selMsgConfirm', 'msgConfirmform', Array('message_ids'), Array(multiCheckValue), Array('value'));
		} else {
			alert_manual(please_select_action, 'dAltMlti');
		}
	}
</script>
<?php
	}
//include the content of the page
setTemplateFolder('members/');
$smartyObj->display('mail.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
$mail->includeFooter();
?>