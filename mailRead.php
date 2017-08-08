<?php
/**
 * To read inbox messages
 *
 * PHP version 5.0
 *
 * @category	###Rayzz###
 * @package		###Members###
 * @author 		selvaraj_47ag04
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: mailRead.php 170 2008-04-02 09:49:23Z selvaraj_47ag04 $
 * @since 		2008-04-02
 **/
/**
 * configurations
*/
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/members/mailRead.php';
$CFG['lang']['include_files'][] = 'languages/%s/members/mailRightLinks.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MailHandler.lib.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//--------------class MailReadFormHandler--------------->>>//
/**
 * MailReadFormHandler
 * mail read form handler
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class MailReadFormHandler extends MailHandler
	{
		//Variable to store message details
		public $mail_details_arr;

		/**
		 * To update the message status to read
		 *
		 * @access public
		 * @return void
		 **/
		public function updateMessageViews()
			{
				$viewed_column = '';
				if ($this->mail_details_arr['to_id'] == $this->CFG['user']['user_id'])
					{
						$viewed_column = 'to_viewed = \'Yes\'';
				    }
				if ($this->mail_details_arr['from_id'] == $this->CFG['user']['user_id'])
					{
						if ($viewed_column) $viewed_column .= ', ';
							{
								$viewed_column .= 'from_viewed = \'Yes\'';
							}
				    }
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['messages_info'].
						' SET '.$viewed_column.
						' WHERE info_id = '.$this->dbObj->Param($this->fields_arr['message_id']);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['message_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				return true;
			}

		/**
		 * MailReadFormHandler::decreaseNewMailCount()
		 *
		 * @param mixed $user_id
		 * @return
		 */
		public function decreaseNewMailCount($user_id)
			{
				if (!in_array($this->fields_arr['folder'], $this->updateNewMailInFolder) || $this->mail_details_arr['to_viewed'] == 'Yes')
					return ;
				$sql = 'UPDATE ' . $this->CFG['db']['tbl']['users'] .
						' SET  new_mails = new_mails - 1'.
						' WHERE user_id='.$this->dbObj->Param($user_id).
						' AND new_mails > 0';

		        $stmt = $this->dbObj->Prepare($sql);
		        $rs = $this->dbObj->Execute($stmt, array($user_id));
		        if (!$rs)
		            trigger_db_error($this->dbObj);

				if ($this->mail_details_arr['email_status'] == 'Request')
					{
						$sql = 'UPDATE ' . $this->CFG['db']['tbl']['users'] .
								' SET new_requests = new_requests - 1'.
								' WHERE user_id='.$this->dbObj->Param($user_id).
								' AND new_requests > 0';

				        $stmt = $this->dbObj->Prepare($sql);
				        $rs = $this->dbObj->Execute($stmt, array($user_id));
				        if (!$rs)
				            trigger_db_error($this->dbObj);
					}
				return true;
			}

		/**
		 * TO get the message_id of pervious message
		 *
		 * @param integer $message_id
		 * @access public
		 * @return void
		 **/
		public function showPrevious($message_id)
			{
				//Temporarily hided the video mails
				if($this->fields_arr['folder'] == 'video')
					$this->fields_arr['folder'] = 'inbox';
				switch($this->fields_arr['folder'])
					{
						case 'inbox':
							$sql = 'SELECT MIN(mi.info_id) as info_id'.
									' FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['messages'].' AS m, '.$this->CFG['db']['tbl']['messages_info'].' AS mi'.
									' WHERE mi.to_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id'.
									' AND mi.message_id = m.message_id'.
									' AND mi.to_delete = \'No\''.
									' AND mi.to_stored = \'No\''.
									' AND mi.email_status != \'Video\''.
									' AND mi.info_id > '.$this->dbObj->Param($message_id).
									' ORDER BY mi.info_id DESC';
							$fields_value_arr = array($this->CFG['user']['user_id'], $message_id);
							break;

						case 'sent':
							$sql = 'SELECT MIN(mi.info_id) as info_id'.
									' FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['messages'].' AS m, '.$this->CFG['db']['tbl']['messages_info'].' AS mi'.
									' WHERE mi.from_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.to_id = u.user_id'.
									' AND mi.message_id = m.message_id'.
									' AND mi.from_delete = \'No\''.
									' AND mi.from_stored = \'No\''.
									' AND mi.email_status = \'Normal\''.
									' AND mi.email_status != \'Request\''.
									' AND mi.info_id > '.$this->dbObj->Param($message_id).
									' ORDER BY mi.info_id DESC';
							$fields_value_arr = array($this->CFG['user']['user_id'], $message_id);
							break;
						case 'saved':
							$sql = 'SELECT MIN(mi.info_id) as info_id'.
									' FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['messages'].' AS m, '.$this->CFG['db']['tbl']['messages_info'].' AS mi '.
									' WHERE ((mi.to_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id AND mi.to_stored = \'Yes\' AND mi.to_delete = \'No\''.
									' AND mi.info_id > '.$this->dbObj->Param($message_id).')'.
									' OR (mi.from_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id AND mi.from_stored = \'Yes\' AND mi.from_delete = \'No\''.
									' AND mi.info_id > '.$this->dbObj->Param($message_id).'))'.
									' AND mi.message_id = m.message_id'.
									' ORDER BY info_id DESC';
							$fields_value_arr = array($this->CFG['user']['user_id'], $message_id,
												  		$this->CFG['user']['user_id'], $message_id);
							break;
						case 'trash':
								$sql = 'SELECT MIN(mi.info_id) as info_id'.
									' FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['messages'].' AS m, '.$this->CFG['db']['tbl']['messages_info'].' AS mi'.
									' WHERE ((mi.to_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id AND mi.to_delete = \'Yes\''.
									' AND mi.info_id > '.$this->dbObj->Param($message_id).')'.
									' OR (mi.from_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id AND mi.from_delete = \'Yes\''.
									' AND mi.info_id > '.$this->dbObj->Param($message_id).'))'.
									' AND mi.message_id = m.message_id'.
									' ORDER BY info_id DESC';
								$fields_value_arr = array($this->CFG['user']['user_id'], $message_id,
													  		$this->CFG['user']['user_id'], $message_id);
							break;
						case 'request':
							$sql = 'SELECT MIN(mi.info_id) as info_id'.
									' FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['messages'].' AS m, '.$this->CFG['db']['tbl']['messages_info'].' AS mi'.
									' WHERE mi.to_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id'.
									' AND mi.message_id = m.message_id'.
									' AND mi.to_delete = \'No\''.
									' AND mi.to_stored = \'No\''.
									' AND mi.email_status = \'Request\''.
									' AND mi.info_id > '.$this->dbObj->Param($message_id).
									' ORDER BY mi.info_id DESC';
							$fields_value_arr = array($this->CFG['user']['user_id'], $message_id);
							break;
						/* Commented Video mails
						case 'video':
							$sql = 'SELECT MIN(mi.info_id) as info_id'.
									' FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['messages'].' AS m, '.$this->CFG['db']['tbl']['messages_info'].' AS mi'.
									' WHERE mi.to_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id'.
									' AND mi.message_id = m.message_id'.
									' AND mi.to_delete = \'No\''.
									' AND mi.to_stored = \'No\''.
									' AND mi.email_status = \'Video\''.
									' AND mi.info_id > '.$this->dbObj->Param($message_id).
									' ORDER BY mi.info_id DESC';
							$fields_value_arr = array($this->CFG['user']['user_id'], $message_id);
							break;*/
						} // switch

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
				if (!$rs)
						trigger_db_error($this->dbObj);

				if ($row = $rs->FetchRow())
					{
						return $row['info_id'];
					}
				return 0;
			}

		/**
		 * To get the id of next bulletin id
		 *
		 * @param integer $message_id
		 * @access public
		 * @return void
		 **/
		public function showNext($message_id)
			{
				//Temporarily hided the video mails
				if($this->fields_arr['folder'] == 'video')
					$this->fields_arr['folder'] = 'inbox';
				switch($this->fields_arr['folder'])
					{
						case 'inbox':
							$sql = 'SELECT MAX(mi.info_id) as info_id'.
									' FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['messages'].' AS m, '.$this->CFG['db']['tbl']['messages_info'].' AS mi'.
									' WHERE mi.to_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id'.
									' AND mi.message_id = m.message_id'.
									' AND mi.to_delete = \'No\''.
									' AND mi.to_stored = \'No\''.
									' AND mi.email_status != \'Video\''.
									' AND mi.info_id < '.$this->dbObj->Param($message_id).
									' ORDER BY mi.info_id DESC';
							$fields_value_arr = array($this->CFG['user']['user_id'], $message_id);
							break;

						case 'sent':
							$sql = 'SELECT MAX(mi.info_id) as info_id '.
									' FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['messages'].' AS m, '.$this->CFG['db']['tbl']['messages_info'].' AS mi'.
									' WHERE mi.from_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.to_id = u.user_id'.
									' AND mi.message_id = m.message_id'.
									' AND mi.from_delete = \'No\''.
									' AND mi.from_stored = \'No\''.
									' AND mi.email_status = \'Normal\''.
									' AND mi.email_status != \'Request\''.
									' AND mi.info_id < '.$this->dbObj->Param($message_id).
									' ORDER BY mi.info_id DESC';
							$fields_value_arr = array($this->CFG['user']['user_id'], $message_id);
							break;
						case 'saved':
							$sql = 'SELECT MAX(mi.info_id) as info_id '.
									' FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['messages'].' AS m, '.$this->CFG['db']['tbl']['messages_info'].' AS mi'.
									' WHERE ((mi.to_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id AND mi.to_stored = \'Yes\' AND mi.to_delete = \'No\''.
									' AND mi.info_id < '.$this->dbObj->Param($message_id).')'.
									' OR (mi.from_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id AND mi.from_stored = \'Yes\' AND mi.from_delete = \'No\''.
									' AND mi.info_id < '.$this->dbObj->Param($message_id).'))'.
									' AND mi.message_id = m.message_id'.
									' ORDER BY info_id DESC';
							$fields_value_arr = array($this->CFG['user']['user_id'], $message_id,
											  			$this->CFG['user']['user_id'], $message_id);
							break;
						case 'trash':
							$sql = 'SELECT MAX(mi.info_id) as info_id '.
									' FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['messages'].' AS m, '.$this->CFG['db']['tbl']['messages_info'].' AS mi'.
									' WHERE ((mi.to_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id AND mi.to_delete = \'Yes\''.
									' AND mi.info_id < '.$this->dbObj->Param($message_id).')'.
									' OR (mi.from_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id AND mi.from_delete = \'Yes\''.
									' AND mi.info_id < '.$this->dbObj->Param($message_id).'))'.
									' AND mi.message_id = m.message_id'.
									' ORDER BY info_id DESC';
							$fields_value_arr = array($this->CFG['user']['user_id'], $message_id,
													  		$this->CFG['user']['user_id'], $message_id);
							break;
						case 'request':
							$sql = 'SELECT MAX(mi.info_id) as info_id '.
									' FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['messages'].' AS m, '.$this->CFG['db']['tbl']['messages_info'].' AS mi'.
									' WHERE mi.to_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id'.
									' AND mi.message_id = m.message_id'.
									' AND mi.to_delete = \'No\''.
									' AND mi.to_stored = \'No\''.
									' AND mi.email_status = \'Request\''.
									' AND mi.info_id < '.$this->dbObj->Param($message_id).
									' ORDER BY mi.info_id DESC';
							$fields_value_arr = array($this->CFG['user']['user_id'], $message_id);
							break;
						/*case 'video':
							$sql = 'SELECT MAX(mi.info_id) as info_id '.
									' FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['messages'].' AS m, '.$this->CFG['db']['tbl']['messages_info'].' AS mi '.
									' WHERE mi.to_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id'.
									' AND mi.message_id = m.message_id'.
									' AND mi.to_delete = \'No\''.
									' AND mi.to_stored = \'No\''.
									' AND mi.email_status = \'Video\''.
									' AND mi.info_id < '.$this->dbObj->Param($message_id).
									' ORDER BY mi.info_id DESC';
							$fields_value_arr = array($this->CFG['user']['user_id'], $message_id);
							break;*/
						} // switch

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
				if (!$rs)
						trigger_db_error($this->dbObj);

				if ($row = $rs->FetchRow())
					{
						return $row['info_id'];
					}
				return 0;
			}

		/**
		 * To check if the message_id is valid
		 *
		 * @param 	integer $message_id
		 * @param 	string $err_tip error tip
		 * @access public
		 * @return Boolean
		 **/
		public function isValidMessageId()
			{
				$this->chkIsNotEmpty('message_id', $this->LANG['common_err_tip_compulsory'])and
					$this->chkIsNumeric('message_id', $this->LANG['common_err_tip_compulsory']);

				if (!$this->isValidFormInputs() or $this->fields_arr['folder'] == 'video')
					{
						$this->setCommonErrorMsg($this->LANG['mailread_err_tip_invalid_mail_id']);
						$this->setPageBlockShow('block_msg_form_error');
						return false;
					}
				switch($this->fields_arr['folder'])
					{
						case 'inbox':
							$sql = 'SELECT mi.info_id, mi.message_id, u.user_id, u.user_name, u.icon_type,u.image_ext, u.icon_id, u.last_name, u.first_name, u.sex,m.subject, m.message'.
									', m.mess_date, mi.to_viewed, mi.to_answer, attachment, mi.to_id, mi.from_id, mi.to_notify, mi.email_status, mi.to_delete, mi.from_delete'.
									' FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['messages'].' AS m, '.$this->CFG['db']['tbl']['messages_info'].' AS mi'.
									' WHERE mi.to_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id'.
									' AND mi.message_id = m.message_id'.
									' AND mi.to_delete = \'No\''.
									' AND mi.to_stored = \'No\'';
							//if(!chkAllowedModule(array('video')))
								$sql .=	' AND mi.email_status != \'Video\'';
							$sql .=	' AND mi.info_id = '.$this->dbObj->Param($this->fields_arr['message_id']).
									' ORDER BY mi.info_id DESC ';

							$fields_value_arr = array($this->CFG['user']['user_id'], $this->fields_arr['message_id']);
							$this->LANG['mailread_page_title'] = $this->LANG['mail_title_inbox'];
							break;

						case 'sent':
							$sql = 'SELECT mi.info_id, mi.message_id, u.user_id, u.last_name, u.first_name, u.sex, m.subject, m.message'.
									', m.mess_date, mi.from_viewed, mi.from_answer, attachment, mi.to_id, mi.from_id, u.user_name, u.icon_type,u.image_ext, u.icon_id, mi.to_delete, mi.from_delete'.
									' FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['messages'].' AS m, '.$this->CFG['db']['tbl']['messages_info'].' AS mi'.
									' WHERE mi.from_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.to_id = u.user_id'.
									' AND mi.message_id = m.message_id'.
									' AND mi.from_delete = \'No\''.
									' AND mi.from_stored = \'No\''.
									' AND mi.email_status != \'Request\'';
									//' AND mi.email_status = \'Normal\''.

							//if(!chkAllowedModule(array('video')))
								$sql .=	' AND mi.email_status != \'Video\'';

							$sql .=	' AND mi.info_id = '.$this->dbObj->Param($this->fields_arr['message_id']).
									' ORDER BY mi.info_id DESC ';

							$fields_value_arr = array($this->CFG['user']['user_id'], $this->fields_arr['message_id']);
							$this->LANG['mailread_page_title'] = $this->LANG['mail_title_sent'];
							break;
						case 'saved':
							$sql = 'SELECT mi.info_id, mi.message_id, mi.to_id, mi.from_id, u.user_id, u.last_name, u.first_name, u.sex, m.subject, m.message'.
									', m.mess_date, mi.to_viewed, mi.to_notify, mi.to_answer, attachment, u.user_name, u.icon_type,u.image_ext, u.icon_id, mi.to_delete, mi.from_delete'.
									' FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['messages'].' AS m, '.$this->CFG['db']['tbl']['messages_info'].' AS mi'.
									' WHERE ((mi.to_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id AND mi.to_stored = \'Yes\' AND mi.to_delete = \'No\''.
									' AND mi.info_id = '.$this->dbObj->Param($this->fields_arr['message_id']).')'.
									' OR (mi.from_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id AND mi.from_stored = \'Yes\' AND mi.from_delete = \'No\'';

								//if(!chkAllowedModule(array('video')))
									$sql .=	'AND mi.email_status != \'Video\' ';

							$sql .=	' AND mi.info_id = '.$this->dbObj->Param($this->fields_arr['message_id']).'))'.
									' AND mi.message_id = m.message_id'.
									' ORDER BY info_id DESC ';
							$fields_value_arr = array($this->CFG['user']['user_id'], $this->fields_arr['message_id'],
													  $this->CFG['user']['user_id'], $this->fields_arr['message_id']);
							$this->LANG['mailread_page_title'] = $this->LANG['mail_title_saved'];
							break;
						case 'trash':
							$sql = 'SELECT mi.info_id, mi.message_id, mi.to_id, mi.from_id, u.user_id, u.last_name, u.first_name, u.sex, m.subject, m.message'.
									', m.mess_date, mi.to_viewed, mi.to_notify, mi.to_answer, attachment, u.user_name, u.icon_type,u.image_ext, u.icon_id, mi.to_delete, mi.from_delete'.
									' FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['messages'].' AS m, '.$this->CFG['db']['tbl']['messages_info'].' AS mi'.
									' WHERE ((mi.to_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id AND mi.to_delete = \'Yes\''.
									' AND mi.info_id = '.$this->dbObj->Param($this->fields_arr['message_id']).')'.
									' OR (mi.from_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id AND mi.from_delete = \'Yes\''.
									' AND mi.info_id = '.$this->dbObj->Param($this->fields_arr['message_id']).'))';

								//if(!chkAllowedModule(array('video')))
									$sql .=	' AND mi.email_status != \'Video\'';

								$sql .=	' AND mi.message_id = m.message_id'.
										' ORDER BY info_id DESC ';
							$fields_value_arr = array($this->CFG['user']['user_id'], $this->fields_arr['message_id'],
													  $this->CFG['user']['user_id'], $this->fields_arr['message_id']);
							$this->LANG['mailread_page_title'] = $this->LANG['mail_title_trash'];
							break;
						case 'request':
							$sql = 'SELECT mi.info_id, mi.message_id, mi.to_id, mi.from_id, u.user_id, u.last_name, u.first_name, u.sex, m.subject, m.message'.
									', m.mess_date, mi.to_viewed, mi.to_answer, attachment, mi.email_status, mi.to_notify, u.user_name, u.icon_type,u.image_ext, u.icon_id, mi.to_delete, mi.from_delete'.
									' FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['messages'].' AS m, '.$this->CFG['db']['tbl']['messages_info'].' AS mi'.
									' WHERE mi.to_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id'.
									' AND mi.message_id = m.message_id'.
									' AND mi.to_delete = \'No\''.
									' AND mi.to_stored = \'No\''.
									' AND mi.email_status = \'Request\''.
									' AND mi.info_id = '.$this->dbObj->Param($this->fields_arr['message_id']).
									' ORDER BY mi.info_id DESC';
							$fields_value_arr = array($this->CFG['user']['user_id'], $this->fields_arr['message_id']);
							$this->LANG['mailread_page_title'] = $this->LANG['mail_title_request'];
							break;
						/*case 'video':
							$sql = 'SELECT mi.info_id, mi.message_id, mi.to_id, mi.from_id, u.user_id, u.last_name, u.first_name, u.sex, m.subject, m.message'.
									', m.mess_date, mi.to_viewed, mi.to_answer, attachment, mi.email_status, mi.to_notify, u.user_name, u.icon_type,u.image_ext, u.icon_id, mi.to_delete, mi.from_delete'.
									' FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['messages'].' AS m, '.$this->CFG['db']['tbl']['messages_info'].' AS mi'.
									' WHERE mi.to_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id'.
									' AND mi.message_id = m.message_id'.
									' AND mi.to_delete = \'No\''.
									' AND mi.to_stored = \'No\''.
									' AND mi.email_status = \'Video\''.
									' AND mi.info_id = '.$this->dbObj->Param($this->fields_arr['message_id']).
									' ORDER BY mi.info_id DESC';
							$fields_value_arr = array($this->CFG['user']['user_id'], $this->fields_arr['message_id']);
							$this->LANG['mailread_page_title'] = $this->LANG['mail_title_video'];
							break;*/
					} // switch

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
				if (!$rs)
						trigger_db_error($this->dbObj);

				if (!$rs->PO_RecordCount())
					{
						$this->setCommonErrorMsg($this->LANG['mailread_err_tip_invalid_mail_id']);
						$this->setPageBlockShow('block_msg_form_error');
						return false;
					}
				$this->mail_details_arr = $rs->FetchRow();
				if ($this->fields_arr['folder'] != 'sent' && $this->mail_details_arr['to_notify'] == 'Yes' && $this->mail_details_arr['to_id'] == $this->CFG['user']['user_id'])
					{
						$this->notifySender();
						$this->updateNotifyStatus($this->fields_arr['message_id']);
				    }

				return true;
			}

		/**
		 * To notify the sender
		 *
		 * @access public
		 * @return void
		 **/
		public function notifySender()
			{
				$subject = $this->mail_details_arr['subject']?$this->LANG['mail_opened_notify_subject'].': '.$this->mail_details_arr['subject']:$this->LANG['mail_opened_notify_subject'];
				$message = $this->LANG['mail_opened_notify_message'];
				$message = str_replace('VAR_DATETIME', date('m.d.y \a\t\ g:i a'), $message);
				$message = str_replace('VAR_NAME', $this->CFG['user']['user_name'], $message);
				$message = str_replace('{new_line}', '&lt;br /&gt;', $message);

				$message_id = $this->insertMessages($subject, $message);
				if ($message_id)
					{
						$this->insertMessagesInfo($this->mail_details_arr['to_id'], $this->mail_details_arr['from_id'], $message_id);
						$this->increaseNewMailCount($this->mail_details_arr['from_id']);
						return true;
					}
			}

		/**
		 * To update the message notification
		 *
		 * @access public
		 * @return void
		 **/
		public function updateNotifyStatus($message_id)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['messages_info'].
						' SET to_notify = \'No\''.
						' WHERE info_id = '.$this->dbObj->Param($message_id);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($message_id));
				if (!$rs)
			        trigger_db_error($this->dbObj);

				return true;
			}

		/**
		 * To delete the give message_id if valid
		 *
		 * @access public
		 * @return void
		 **/
		public function deleteMessage()
			{
				$status = ($this->fields_arr['folder'] == 'trash')?'Trash':'Yes';
				if ($this->mail_details_arr['to_id'] == $this->CFG['user']['user_id'])
					{
						$this->updateMessageStatusDelete('to_delete', $this->fields_arr['message_id'], $status);
					}
				if ($this->mail_details_arr['from_id'] == $this->CFG['user']['user_id'])
					{
						$this->updateMessageStatusDelete('from_delete', $this->fields_arr['message_id'], $status);
					}
				return true;
			}

		/**
		 * To save the give message_id if valid
		 *
		 * @access public
		 * @return void
		 **/
		public function saveMessage()
			{
				if ($this->mail_details_arr['to_id'] == $this->CFG['user']['user_id'])
					{
						$this->updateMessageStatusSave('to_stored', 'to_delete', $this->fields_arr['message_id']);
					}
				if ($this->mail_details_arr['from_id'] == $this->CFG['user']['user_id'])
					{
						$this->updateMessageStatusSave('from_stored', 'from_delete', $this->fields_arr['message_id']);
					}
				return true;
			}

		/**
		 * To Display the message header
		 *
		 * @access public
		 * @return void
		 **/
		public function populateMessageHeader()
			{
				global $smartyObj;

				$header_link = array();
				$i = 0;

				$header_link[$i]['display_text'] = $this->LANG['mailread_reply'];
				$add_url = '?action=reply&amp;msgFolder='.$this->fields_arr['folder'].'&message_id='.$this->fields_arr['message_id'];
				$header_link[$i]['href'] = getUrl('mailcompose', $add_url, $add_url, 'members');
				$header_link[$i]['onclick'] = 'return true';
				$i++;

				$header_link[$i]['display_text'] = $this->LANG['mailread_forward'];
				$add_url = '?action=forward&msgFolder='.$this->fields_arr['folder'].'&message_id='.$this->fields_arr['message_id'];
				$header_link[$i]['href'] = getUrl('mailcompose', $add_url, $add_url, 'members');
				$header_link[$i]['onclick'] = 'return true';
				$i++;

				if($this->fields_arr['folder'] != 'saved')
					{
						$header_link[$i]['display_text'] = $this->LANG['mailread_save'];
						$header_link[$i]['href'] = $this->getCurrentUrl();
						$header_link[$i]['onclick'] = 'return Confirmation(\'selMsgConfirm\', \'msgConfirmform\', Array(\'action\', \'confirmMessage\'), Array(\'mail_save\', \''.addslashes($this->LANG['mailread_confirm_save_message']).'\'), Array(\'value\', \'innerHTML\'),-50,200,\'selPhotoGallery\')';
						$i++;
					}

				$header_link[$i]['display_text'] = $this->LANG['mailread_delete'];
				$header_link[$i]['href'] = $this->getCurrentUrl();
				$header_link[$i]['onclick'] = 'return Confirmation(\'selMsgConfirm\', \'msgConfirmform\', Array(\'action\', \'confirmMessage\'), Array(\'mail_delete\', \''.addslashes($this->LANG['mailread_confirm_delete_message']).'\'), Array(\'value\', \'innerHTML\'),-50,200,\'selPhotoGallery\')';
				$smartyObj->assign('mail_header_link', $header_link);

				$this->prev_id = 0;
				$mail_previous_link = false;
 				if($this->prev_id = $this->showPrevious($this->fields_arr['message_id']))
 					{
						$mail_previous_link = getUrl('mailread', '?folder='.$this->fields_arr['folder'].'&message_id='.$this->prev_id, $this->fields_arr['folder'].'/?message_id='.$this->prev_id);
					}
				$smartyObj->assign('mail_previous_link', $mail_previous_link);

				$this->next_id = 0;
				$mail_next_link = false;
 				if($this->next_id = $this->showNext($this->fields_arr['message_id']))
 					{
						$mail_next_link = getUrl('mailread', '?folder='.$this->fields_arr['folder'].'&message_id='.$this->next_id, $this->fields_arr['folder'].'/?message_id='.$this->next_id);
					}
				$smartyObj->assign('mail_next_link', $mail_next_link);
			}

		/**
		 * To display the forums titles
		 *
		 * @access public
		 * @return void
		 **/
		public function populateMessage()
			{
				global $smartyObj;
				if ($this->mail_details_arr)
					{
						$this->populateMessageHeader();
						if($this->getFormField('folder') != 'sent')
							{
								$userDetails = $this->getUserDetail('user_id', $this->mail_details_arr['from_id']);
							}
						else
							{
								$userDetails = $this->getUserDetail('user_id', $this->mail_details_arr['to_id']);
							}
						$icon = getMemberAvatarDetails($this->mail_details_arr['user_id']);
						$userDetails['user_profiles_icon']=$icon;
						$name = getUserDisplayName($this->mail_details_arr);
						$userDetails['display_user_name'] = $name;
						$userDetails['user_profiles_link'] = getUrl('viewprofile', '?user='.$userDetails['user_name'], $userDetails['user_name'].'/');
						$this->mail_details_arr['message'] = htmlentitydecode(stripslashes($this->mail_details_arr['message']));
						$smartyObj->assign('mail_details_arr', $this->mail_details_arr+$userDetails);
					}
			}
	}
//<<<<<<<--------------class MailReadFormHandler---------------//

//--------------------Code begins-------------->>>>>//
$mailread = new MailReadFormHandler();

if(!$mailread->chkAllowedModule(array('mail')))
	Redirect2URL(getUrl($CFG['redirect']['dsabled_module_url']['file_name']));

$mailread->setPageBlockNames(array('block_form_show_message', 'block_page_nav', 'block_form_confirm'));

//default form fields and values...
$mailread->setFormField('folder', '');
$mailread->setFormField('message_id', '');
$mailread->setFormField('action', '');
$mailread->setFormField('delete', '');
$mailread->setFormField('save', '');
$mailread->setFormField('msg', '');

$mailread->setAllPageBlocksHide();
$mailread->sanitizeFormInputs($_REQUEST);
if (!$mailread->chkIsValidFolder())
	{
		$mailread->setCommonErrorMsg($LANG['mail_invalid_folder']);
		$mailread->setPageBlockShow('common_msg_error_sorry');
	}
else
	{
		if ($mailread->isValidMessageId())
			{
				if ($mailread->isFormPOSTed($_POST, 'confirm'))
					{
						$mailread->chkIsNotEmpty('action', $LANG['common_err_tip_compulsory']) OR
							$mailread->setCommonErrorMsg($LANG['mailread_select_action']);

						$mailread->setAllPageBlocksHide();
						$mailread->setPageBlockShow('block_msg_form_success');
						if ($mailread->isValidFormInputs())
							{
								switch($mailread->getFormField('action'))
									{
										case 'mail_save':
											$mailread->saveMessage();
											break;
										case 'mail_delete':
											$mailread->deleteMessage();
											break;
									} // switch
								$next_id = $mailread->showNext($mailread->getFormField('message_id'));
								if ($next_id)
									{
										switch($mailread->getFormField('action'))
											{
												case 'mail_save':
													$redirectUrl = getUrl('mailread', '?folder='.$mailread->getFormField('folder').'&message_id='.$next_id.'&msg=1', $mailread->getFormField('folder').'/?message_id='.$next_id.'&msg=1', 'members');
													break;
												case 'mail_delete':
													$redirectUrl = getUrl('mailread', '?folder='.$mailread->getFormField('folder').'&message_id='.$next_id.'&msg=2', $mailread->getFormField('folder').'/?message_id='.$next_id.'&msg=2', 'members');
													break;
											} // switch
										Redirect2URL($redirectUrl);
								   	}
								else
									{
										Redirect2URL(getUrl('mail', '?folder='.$mailread->getFormField('folder').'&del=1', $mailread->getFormField('folder').'/?del=1'));
									}
							}
						else
							{
								$mailread->setPageBlockShow('block_msg_form_error');
							}
					}
			}
		if ($mailread->isValidFormInputs())
			{
				$mailread->setPageBlockShow('block_form_show_message'); //default page block. show it. All others hidden
				if ($mailread->getFormField('msg'))
					{
						$mailread->setPageBlockShow('block_msg_form_success');
				    }
			}
		else
			{
				$mailread->setPageBlockShow('block_msg_form_error');
			}
	}
//<<<<--------------------Code Ends----------------------//
//--------------------Page block templates begins-------------------->>>>>//
if ($mailread->isShowPageBlock('block_msg_form_success'))
	{
		switch($mailread->getFormField('msg'))
			{
				case 1 :
					$mailread->setCommonSuccessMsg($LANG['mailread_success_saved_message']);
					break;
				case 2 :
					$mailread->setCommonSuccessMsg($LANG['mailread_success_delete_message']);
					break;
				case 3 :
					$mailread->setCommonSuccessMsg($LANG['mailread_success_reply_message']);
					break;
				case 4 :
					$mailread->setCommonSuccessMsg($LANG['mailread_success_forward_message']);
					break;
			} // switch
	}

if ($mailread->isShowPageBlock('block_form_show_message'))
	{
		$mailread->populateMessage();
		$mailread->decreaseNewMailCount($CFG['user']['user_id']);
		$mailread->updateMessageViews();
	}
//include the header file
$mailread->includeHeader();
if($mailread->isShowPageBlock('block_form_show_message'))
	{
?>
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgConfirm');
</script>
<?php
	}
//include the content of the page
setTemplateFolder('members/');
$smartyObj->display('mailRead.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
$mailread->includeFooter();
?>