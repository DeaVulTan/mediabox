<?php
set_time_limit(0);
$called_from_cron = true;
require_once(dirname(dirname(__FILE__)).'/common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include various types of files
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
/**
 * birthdayReminderSendCron
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class birthdayReminderSendCron extends FormHandler
	{
		public $total_mail_sent = 0;

		/**
		 * birthdayReminderSendCron::changeBirthdayReminderstatus()
		 *
		 * @param mixed $birthday_reminder_id
		 * @param mixed $status
		 * @return
		 */
		public function changeBirthdayReminderstatus($birthday_reminder_id, $status)
			{
				$sql = ' UPDATE '.$this->CFG['db']['tbl']['birthday_reminder'].' SET'.
						' process = '.$this->dbObj->Param('process').' WHERE'.
						' birthday_reminder_id = '.$this->dbObj->Param('birthday_reminder_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($status, $birthday_reminder_id));
				if (!$rs)
					trigger_db_error($this->dbObj);
			}

		/**
		 * birthdayReminderSendCron::deleteBirthDayReminder()
		 *
		 * @param mixed $birthday_reminder_id
		 * @return
		 */
		public function deleteBirthDayReminder($birthday_reminder_id)
			{
				$sql = ' DELETE FROM '.$this->CFG['db']['tbl']['birthday_reminder'].' WHERE'.
						' birthday_reminder_id = '.$this->dbObj->Param('birthday_reminder_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($birthday_reminder_id));
				if (!$rs)
					trigger_db_error($this->dbObj);
			}

		/**
		 * birthdayReminderSendCron::updateLastMailSentFriendsListId()
		 *
		 * @param mixed $birthday_reminder_id
		 * @param mixed $friends_list_id
		 * @return
		 */
		public function updateLastMailSentFriendsListId($birthday_reminder_id, $friends_list_id)
			{
				$sql = ' UPDATE '.$this->CFG['db']['tbl']['birthday_reminder'].' SET'.
						' mail_sent_upto_friends_list_id = '.$this->dbObj->Param('mail_sent_upto_friends_list_id').' WHERE'.
						' birthday_reminder_id = '.$this->dbObj->Param('birthday_reminder_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($friends_list_id, $birthday_reminder_id));
				if (!$rs)
					trigger_db_error($this->dbObj);
			}

		/**
		 * birthdayReminderSendCron::sendReminderEmail()
		 *
		 * @param mixed $birthday_user_details
		 * @param mixed $friend_user_details
		 * @return
		 */
		public function sendReminderEmail($birthday_user_details, $friend_user_details)
			{
				if(!chkIsAllowedNotificationEmail('friends_birthdays', $friend_user_details['user_id']))
					{
						return;
					}
				$this->setEmailTemplateValue('BIRTH_PERSION_NAME', $birthday_user_details['display_name']);
				$this->setEmailTemplateValue('FRIEND_USER_NAME', $friend_user_details['display_name']);
				$link = '<a href="'.getMemberProfileUrl($birthday_user_details['user_id'], $birthday_user_details['user_name']).'">'.$birthday_user_details['display_name'].'</a>';
				$this->setEmailTemplateValue('LINK_BIRTH_PERSION_NAME', $link);
				$this->setEmailTemplateValue('BIRTHDATE', $this->getFormatedDate($birthday_user_details['dob'], $this->CFG['birthday_reminder']['date_format']));

				$this->_sendMail($friend_user_details['email'], $this->LANG['friends_birthday_reminder_subject'], $this->LANG['friends_birthday_reminder_content'], $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);
			}

		/**
		 * birthdayReminderSendCron::sendBirthDayReminder()
		 *
		 * @return
		 */
		public function sendBirthDayReminder()
			{
				$sql = 'SELECT birthday_reminder_id, user_id, mail_sent_upto_friends_list_id'.
						' FROM '.$this->CFG['db']['tbl']['birthday_reminder'].
						' WHERE process = \'No\''.
						' ORDER BY birthday_reminder_id LIMIT 1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array());
				if (!$rs)
					trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->changeBirthdayReminderstatus($row['birthday_reminder_id'], 'Yes');
						$birthday_user_details = getUserDetail('user_id', $row['user_id']);

						$sql1 = 'SELECT id, friend_id AS friend_user_id'.
								' FROM '.$this->CFG['db']['tbl']['friends_list'].
								' WHERE id > '.$this->dbObj->Param('id').
								' AND owner_id = '.$this->dbObj->Param('owner_id');

						$stmt1 = $this->dbObj->Prepare($sql1);
						$rs1 = $this->dbObj->Execute($stmt1, array($row['mail_sent_upto_friends_list_id'], $row['user_id']));
						if (!$rs1)
							trigger_db_error($this->dbObj);

						if($total_friends = $rs1->PO_RecordCount())
							{
								$total_friends_sent = 0;
								while($row1 = $rs1->FetchRow())
									{
										$friend_user_details = getUserDetail('user_id', $row1['friend_user_id']);
										$this->sendReminderEmail($birthday_user_details, $friend_user_details);

										$total_friends_sent++;
										if($total_friends == $total_friends_sent)
											{
												$this->deleteBirthDayReminder($row['birthday_reminder_id']);
											}
										$this->total_mail_sent++;
										if($this->total_mail_sent == $this->CFG['birthday_reminder']['mail_send_limit_per_request'])
											{
												$this->updateLastMailSentFriendsListId($row['birthday_reminder_id'], $row1['id']);
												$this->changeBirthdayReminderstatus($row['birthday_reminder_id'], 'No');
												return;
											}
									}
								$this->sendBirthDayReminder();
							}
					}
			}
	}
//<<<<<-------------- Class LoginFormHandler begins ---------------//
//-------------------- Code begins -------------->>>>>//
$birthdayReminderSendCron = new birthdayReminderSendCron();
callMultipleCronCheck();
$birthdayReminderSendCron->sendBirthDayReminder();
echo '<br />Total Email Sent: '.$birthdayReminderSendCron->total_mail_sent;
//require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');
?>