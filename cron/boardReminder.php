<?php
/**
 * This file is for board reminder
 *
 * This file is having BoardReminderFormHandler class for board reminder
 *
 * PHP version 5.0
 *
 * @category	Discuzz
 * @package		Admin
 * @author 		sridhar_68ag07
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2008-12-26
 *
 **/
require_once('../common/configs/config.inc.php'); //configurations
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['lang']['include_files'][] =	'languages/%s/'.$CFG['admin']['index']['home_module'].'/email_notify.inc.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include various types of files
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');

set_time_limit(0);
class BoardReminderFormHandler extends FormHandler
	{
		 public function getCronMasterDetails($table_name, $cron_for)
			{
				$sql = 'SELECT upto_id FROM '.$table_name.
						' WHERE cron_for = '.$this->dbObj->Param($cron_for).' AND status = \'Started\' limit 0,1';
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($cron_for));
				//raise user error... fatal
				if (!$rs)
						trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						return $row;
					}

				return false;
			}

		public function updateCronMaster($table_name, $cron_for, $status, $new_old, $upto=0, $total = 0)
			{
				$val_arr = array();
				$val_arr[] = $status;

				$sql = 'UPDATE '.$table_name .
						' SET '.
						'status='.$this->dbObj->Param($status);

				$sql .= ', upto_id = '.$this->dbObj->Param($upto);
				$val_arr[] = $upto;

				if ($total == 0)
					$sql .= ', total = '.$this->dbObj->Param($total);
					else
						$sql .= ', total = total + '.$this->dbObj->Param($total);
				$val_arr[] = $total;

				if ($new_old == 'new')
					{
						$sql .= ', start_time = '.$this->dbObj->SQLDate('Y-m-d H:i:s');
						$sql .= ', tot_finished_crons = tot_finished_crons + 1';
					}
				$sql .= ' WHERE cron_for = '.$this->dbObj->Param($cron_for);
				$val_arr[] = $cron_for;
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$result = $this->dbObj->Execute($stmt, $val_arr);
				//raise user error... fatal
				if (!$result)
						trigger_db_error($this->dbObj);
			}

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function updateSubscribeTable($bookmark_id)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['user_bookmarked'].' SET last_updated=NOW()'.
						' WHERE bookmark_id='.$this->dbObj->Param('bookmark_id');
				#echo $sql;die('here');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($bookmark_id));
				if (!$rs)
					    trigger_db_error($this->dbObj);
			}

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function emailSubscriberDetails($upto_id, $check_count)
		    {
				$sql = 'SELECT bookmark_id, user_id, content_id, content_type, last_updated'.
						' FROM '.$this->CFG['db']['tbl']['user_bookmarked'].
						' WHERE bookmark_id > '.$this->dbObj->Param($upto_id).
						' AND content_type=\'User\''.
						' ORDER BY bookmark_id ASC limit 0, '.$this->dbObj->Param($check_count);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($upto_id, $check_count));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				if ($count = $rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow()){

							$ret_arr = array('bookmark_id'=>$row['bookmark_id'],'count'=>$count);

							$subscriber_id = $row['content_id'];
							$last_updated = $row['last_updated'];

							$sql = 'SELECT board_id, board, seo_title, best_solution_id'.
									' FROM '.$this->CFG['db']['tbl']['boards'].
									' WHERE user_id ='.$this->dbObj->Param('user_id').
									' AND board_added >'.$this->dbObj->Param($last_updated).
									' AND status=\'Active\' LIMIT 3';

							$stmt = $this->dbObj->Prepare($sql);
							$board_rs = $this->dbObj->Execute($stmt, array($subscriber_id, $last_updated));
							if (!$board_rs)
							        trigger_db_error($this->dbObj);
							if($board_count = $board_rs->PO_RecordCount())
								{
									$board_contents = '';
									while($board_row = $board_rs->FetchRow())
										{
											$qLink = getUrl('solutions', '?title='.$board_row['seo_title'], $board_row['seo_title'].'/', 'root', $this->CFG['admin']['index']['home_module']);
											$board_contents.= '<a href="'.$qLink.'">'.wordWrapManual($board_row['board'], $this->CFG['admin']['board']['line_length'], $this->CFG['admin']['board']['short_length']).'</a> <br />';
										}
								}

							$sql = 'SELECT b.board_id, b.board, b.seo_title, s.solution_id'.
									' FROM '.$this->CFG['db']['tbl']['boards'].' As b, '.$this->CFG['db']['tbl']['solutions'].' As s'.
									' WHERE b.board_id=s.board_id AND s.user_id ='.$this->dbObj->Param('user_id').
									' AND s.solution_added >'.$this->dbObj->Param($last_updated).
									' AND s.status=\'Active\' GROUP BY s.board_id LIMIT 3';

							$stmt = $this->dbObj->Prepare($sql);
							$solution_rs = $this->dbObj->Execute($stmt, array($subscriber_id, $last_updated));
							if (!$solution_rs)
							        trigger_db_error($this->dbObj);
							if($solution_count = $solution_rs->PO_RecordCount())
								{
									$solution_contents = '';
									while($solution_row = $solution_rs->FetchRow())
										{
											$qLink = getUrl('solutions', '?title='.$solution_row['seo_title'], $solution_row['seo_title'].'/', 'root', $this->CFG['admin']['index']['home_module']);
											$solution_contents.= '<a href="'.$qLink.'">'.wordWrapManual($solution_row['board'], $this->CFG['admin']['board']['line_length'], $this->CFG['admin']['board']['short_length']).'</a> <br />';
										}
								}

								if($board_count OR $solution_count)
									{
										$user_details = $this->getUserDetailsFromUsersTable($this->CFG['db']['tbl']['users'], $row['user_id']);
										$subscriber_details = $this->getUserDetailsFromUsersTable($this->CFG['db']['tbl']['users'], $subscriber_id);
										$users_url   = getMemberUrl($row['user_id'], $user_details['name'], 'root');
										$users_name  = '<a href="'.$users_url.'">'.$user_details['display_name'].'</a>';
										$reminder_subject = str_ireplace('VAR_USERNAME', $user_details['display_name'], $this->LANG['subscribed_users_subject']);
										$reminder_content = str_ireplace('VAR_USERNAME', $users_name, $this->LANG['subscribed_users_content']);
										$board_content = '';
										$solution_content = '';

										if($board_count > 0)
											{
												$board_content = str_ireplace('VAR_SITENAME', $this->CFG['site']['name'], $this->LANG['users_board_details_msg']);
												$subscriber_url   = getMemberUrl($subscriber_details['user_id'], $subscriber_details['name'], 'root');
												$subscriber_name  = '<a href="'.$subscriber_url.'">'.$subscriber_details['display_name'].'</a>';
												$board_content = str_ireplace('SUBSCRIBED_USER', $subscriber_name, $board_content);
												$board_content.='<br />'.$board_contents;
												$reminder_content = str_ireplace('VAR_BOARD_POSTED', $board_content, $reminder_content);
											}
										else
											{
												$reminder_content = str_ireplace('VAR_BOARD_POSTED', '', $reminder_content);
											}
										if($solution_count > 0)
											{
												$solution_content = str_ireplace('VAR_SITENAME', $this->CFG['site']['name'], $this->LANG['users_solution_details_msg']);
												$subscriber_url   = getMemberUrl($subscriber_details['user_id'], $subscriber_details['name'], 'root');
												$subscriber_name  = '<a href="'.$subscriber_url.'">'.$subscriber_details['display_name'].'</a>';
												$solution_content = str_ireplace('SUBSCRIBED_USER', $subscriber_name, $solution_content);
												$solution_content.='<br />'.$solution_contents;
												$reminder_content = str_ireplace('VAR_SOLUTION_POSTED', $solution_content, $reminder_content);
											}
										else
											{
												$reminder_content = str_ireplace('VAR_SOLUTION_POSTED', '', $reminder_content);
											}

										$reminder_content = str_ireplace('VAR_SITENAME', $this->CFG['site']['name'], $reminder_content);

										$this->_sendMail($user_details['email'],
															 $reminder_subject,
															 $reminder_content,
															 $this->CFG['site']['noreply_name'],
															 $this->CFG['site']['noreply_email']);
										$this->updateSubscribeTable($row['bookmark_id']);
									}
							} // while
						// if
						return $ret_arr;
					}
				return false;
		    }

		/**
		 * To send email
		 *
		 * @param 		string $to_email to email id
		 * @param 		string $subject subject
		 * @param		string $body mail body
		 * @param 		string $sender_name sender name
		 * @param 		string $sender_email sender email
		 * @return 		void
		 * @access 		private
		 */
		private function _sendMail($to_email, $subject, $body, $sender_name, $sender_email)			{

				$this->buildEmailTemplate($subject, $body, false, true);
				$EasySwift = new EasySwift($this->getSwiftConnection());
				$EasySwift->flush();
				$EasySwift->addPart($this->getEmailContent(), "text/html");
				$from_address = $sender_name.'<'.$sender_email.'>';
				return $EasySwift->send($to_email, $from_address, $this->getEmailSubject());
			}
		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function updateBoardTableEmailSentStatus($qid)
		    {
				#echo $qid;
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['boards'].' SET email_sent=\'Yes\''.
						' WHERE board_id='.$this->dbObj->Param('qid');
				#echo $sql;die('here');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($qid));
				if (!$rs)
					    trigger_db_error($this->dbObj);
		    }

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function isFavoriteBoard($uid, $qid)
		    {
				$sql = 'SELECT bookmark_id as fav_id FROM '.$this->CFG['db']['tbl']['user_bookmarked'].
						' WHERE content_id = '.$this->dbObj->Param('qid').
						' AND user_id = '.$this->dbObj->Param('uid').
						' AND content_type = \'Board\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($qid, $uid));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				$ok = false;
				if ($rs->PO_RecordCount())
					$ok = true;
				return $ok;
		    }

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function getAdminUserId($user_table)
		    {
				$sql = 'SELECT '.getUserTableField('user_id').' AS user_id FROM '.$user_table.' WHERE '.getUserTableField('user_access').' = \'Admin\' LIMIT 1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
						trigger_db_error($this->dbObj);
				$row = array('user_id'=> 1);
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
					}
				return	$row['user_id'];
		    }
	}
//<<<<<-------------- Class BoardReminderFormHandler begins ---------------//
//-------------------- Code begins -------------->>>>>//
$reminder = new BoardReminderFormHandler();
$reminder->member_url = $CFG['site']['url'].$CFG['redirect']['member'].'/';
if ($cron_arr = $reminder->getCronMasterDetails($CFG['db']['tbl']['cron_master'], 'Subscribe'))
{
	if ($autoindex_arr = $reminder->emailSubscriberDetails($cron_arr['upto_id'], $CFG['board']['send_count']))
		$reminder->updateCronMaster($CFG['db']['tbl']['cron_master'],'Subscribe', 'Started', 'old',  $autoindex_arr['bookmark_id'], $autoindex_arr['count']);
	else
		$reminder->updateCronMaster($CFG['db']['tbl']['cron_master'],'Subscribe', 'Started', 'new');}
else
	$reminder->updateCronMaster($CFG['db']['tbl']['cron_master'],'Subscribe', 'Started', 'new');
?>
