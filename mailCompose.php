<?php
/**
 * send mail to the selected user
 *
 *
 * @category	Rayzz
 * @package		###Members###
 **/
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/members/mailCompose.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/members/mailRightLinks.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MailHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/recaptchalib.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
require($CFG['site']['project_path'].'common/application_top.inc.php');
//--------------class MailComposeFormHandler--------------->>>//
/**
 * MailComposeFormHandler
 * mail compose form handler
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class MailComposeFormHandler extends MailHandler
	{
		//Session userid
		private $custid;
		//mail id
		public $message_id;
		//Ids to send mail
		public $send_ids;
		public $publickey;
		public $privatekey;
		public $error = null;
		public $resp = null;
		public $invalid_relation_array = array();
		public $invalid_user_array = array();
		public $invalid_blockedmember_array = array();
		public $wrong_format_array = array();

		/**
		 * To populate user id from mails_contacts table
		 *
		 * @param 		integer $users_table users table
		 * @param 		integer $contacts_table mails_contacts table
		 * @param 		integer $highlight_user_name Selecetd username
		 * @return 		void
		 * @access 		public
		 **/
		public function populateContacts($highlight_user_name)
			{
				$sql_sub = 'SELECT block_id FROM '.$this->CFG['db']['tbl']['block_members'].
							' WHERE user_id = '.$this->dbObj->Param($this->CFG['user']['user_id']);

				$sql = 'SELECT u.user_id, u.user_name, u.last_name, u.first_name'.
						' FROM '.$this->CFG['db']['tbl']['users'].' u, '.$this->CFG['db']['tbl']['messages_contacts'].' AS c'.
						' WHERE c.user_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
						' AND NOT EXISTS (SELECT 1 FROM '.$this->CFG['db']['tbl']['block_members'].' AS bm WHERE bm.user_id='.$this->dbObj->Param($this->CFG['user']['user_id']).' AND bm.block_id = c.contacts_id)'.
						' AND c.contacts_id = u.user_id'.
						' AND u.usr_status = \'Ok\''.
						' ORDER BY first_name, last_name';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->CFG['user']['user_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				if (!$rs->PO_RecordCount())
					{
						return false;
				    }
				$username = array();
				$user_id = array();

				while($row=$rs->FetchRow())
					{
						$user_id[] = $row['user_id'];
						$username['('.$row['user_name'].')']=getUserDisplayName($row);
					}
				$this->populateContacts['user_id'] = implode(',', $user_id);
				return $username;
			}

		 /**
		 * To populate friends name
		 *
		 * @param 		integer $users_table users table
		 * @param 		integer $friends_table friends_list table
		 * @param 		integer $highlight_user_name Selecetd username
		 * @access public
		 * @return void
		 **/
		 public function populateFriends($highlight_user_name)
			{
				$populate_contacts_condition = '';
				if(!empty($this->populateContacts['user_id']))
					$populate_contacts_condition = ' AND NOT EXISTS (SELECT 1 FROM '.$this->CFG['db']['tbl']['block_members'].' AS bm WHERE bm.user_id = '.$this->dbObj->Param('user_id').' AND bm.block_id = f.friend_id)';

				$sql = 'SELECT u.user_id, u.user_name, u.last_name, u.first_name'.
						' FROM '.$this->CFG['db']['tbl']['users']. ' AS u, '.$this->CFG['db']['tbl']['friends_list'].' AS f'.
						' WHERE f.owner_id = '.$this->dbObj->Param('user_id').
						' AND u.user_id = f.friend_id'.
						' AND u.usr_status = \'Ok\' '.$populate_contacts_condition.
						' ORDER BY first_name, last_name';

				$stmt = $this->dbObj->Prepare($sql);
				if(!empty($populate_contacts_condition))
					$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->CFG['user']['user_id']));
				else
					$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				if (!$rs->PO_RecordCount())
					{
						return false;
				    }
				$friendsname=array();
				while($row=$rs->FetchRow())
					{
						$friendsname['('.$row['user_name'].')'] = getUserDisplayName($row);
					}
				return $friendsname;
			}

		/**
		 * To populate the realtions names
		 *
		 * @param string $relations_table friends_relation_name
		 * @param string $highlight_user_name Selected username
		 * @access public
		 * @return void
		 **/
		public function populateRelations($highlight_user_name)
			{
				$sql = 'SELECT relation_id, relation_name'.
						' FROM '.$this->CFG['db']['tbl']['friends_relation_name'].
						' WHERE user_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
						' AND total_contacts > 0 '.
						' ORDER BY relation_name';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				if (!$rs)
				    trigger_db_error($this->dbObj);

				if (!$rs->PO_RecordCount())
					{
						return false;
				    }
				$relationname=array();
				while($row=$rs->FetchRow())
					{
						$row_rel_name='['.$row['relation_name'].']';
				 	 	$relationname[$row_rel_name]=$row['relation_name'];
					}

				return $relationname;
			}

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function getUserId($user_name)
			{
				$sql = 'SELECT u.user_id, u.email, u.user_name'.
						' FROM '.$this->CFG['db']['tbl']['users'].' AS u'.
						' WHERE u.user_name = '.$this->dbObj->Param($user_name).
						' AND u.usr_status = \'Ok\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_name));
				if (!$rs)
				    trigger_db_error($this->dbObj);

				if ($row = $rs->FetchRow())
					{
						$this->user_details[$row['user_id']]['email'] = $row['email'];
						$this->user_details[$row['user_id']]['user_name'] = $row['user_name'];
						if (in_array($row['user_id'], $this->blockArr))
							{
								$this->invalid_blockedmember_array[] = $user_name;
								return true;
							}
						else
							$this->send_ids[] = $row['user_id'];
						return true;
				    }
				$this->invalid_user_array[] = $user_name;
				return true;
			}

		/**
		 * To get all userids of given relation name
		 *
		 * @param string $relation_name
		 * @access public
		 * @return void
		 **/
		public function getUserIds($relation_name)
			{
				//Check if relation name is correct
				$sql = 'SELECT relation_id, total_contacts'.
						' FROM '.$this->CFG['db']['tbl']['friends_relation_name'].
						' WHERE relation_name = '.$this->dbObj->Param($relation_name).
						' AND user_id = '.$this->dbObj->Param($this->CFG['user']['user_id']);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($relation_name, $this->CFG['user']['user_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						//Get friendids in the give contacts
						$sql = 'SELECT l.friend_id AS friend_id'.
								' FROM '.$this->CFG['db']['tbl']['friends_list'].' AS l, '.$this->CFG['db']['tbl']['friends_relation'].' AS f'.
								' WHERE f.friendship_id = l.id'.
								' AND owner_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
								' AND f.relation_id  = '.$this->dbObj->Param($row['relation_id']);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $row['relation_id']));
						if (!$rs)
						        trigger_db_error($this->dbObj);
						if($rs->PO_RecordCount())
							{
								while($row = $rs->FetchRow()){
									if (!in_array($row['friend_id'], $this->blockArr))
										{
											$this->send_ids[] = $row['friend_id'];
										}
									else
										{
											$this->invalid_blockedmember_array[] = $relation_name;
										}
								} // while
								return true;
							}
						//$err_tip = str_replace('VAR_RELATION',$relation_name,$this->LANG['mailcompose_err_tip_relation_no_contacts']);
						//$this->common_error_message = $err_tip;
						//return true;
					}
				$this->invalid_relation_array[] = $relation_name;
				/*$err_tip = str_replace('VAR_RELATION',$relation_name,$this->LANG['mailcompose_err_tip_invalid_relation']);
				$this->common_error_message = $err_tip;*/
				return true;
			}

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function getBlockUsers()
			{
				$sql = 'SELECT GROUP_CONCAT( user_id ) AS user_ids'.
						' FROM '.$this->CFG['db']['tbl']['block_members'].
						' WHERE block_id = '.$this->dbObj->Param($this->CFG['user']['user_id']);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				if (!$rs)
				    trigger_db_error($this->dbObj);

				if ($row = $rs->FetchRow())
					{
						$this->blockArr = explode(',', $row['user_ids']);
				    }
				return true;
			}

		/**
		 * To store the mail details in mails and mails_info table
		 *
		 * @param 		integer $to_user_name
		 * @param 		string $subject
		 * @param 		string $message
		 * @param 		string $to_notify
		 * @param 		string $err_tip
		 * @access 		public
		 * @return 		void
		 **/
		public function sendMail($to_user_name, $subject, $message, $to_notify, $err_tip='')
			{
				$add_contact = true;
				$to_user_name = $this->fields_arr[$to_user_name];
				if(!strpos($to_user_name, ','))
					$to_user_name .= ',';
				$toArr = explode(',', $to_user_name);
				$this->getBlockUsers();
				foreach($toArr as $value)
					{
						$value = trim($value);
						if($value=='') continue;
						$value = ' '.$value;
						if(strpos($value,'[')==1)
							{
								if(strpos($value,']')==strlen($value)-1)
									{
										$value = str_replace('[','',$value);
										$value = str_replace(']','',$value);
										$value = trim($value);
										$this->getUserIds($value);
									}
								else
									{
										$this->wrong_format_array[] = $value;
									}
							}
						elseif(strpos($value,'(')==1)
							{
								if(strpos($value,')')==strlen($value)-1)
									{
										$value = str_replace('(','',$value);
										$value = str_replace(')','',$value);
										$value = trim($value);
										$this->getUserId($value);
									}
								else
									{
										$this->wrong_format_array[] = $value;
									}
							}
						else if($value!=' ')
							{
								$value = trim($value);
								$this->getUserId($value);
							}
					}
				if(!empty($this->invalid_relation_array) or !empty($this->invalid_user_array) or !empty($this->invalid_blockedmember_array) or !empty($this->wrong_format_array))
					{
						$this->setErrorMessage();
						return false;
					}
				$this->send_ids = array_unique($this->send_ids);
				if (!$this->send_ids) return false;

				$this->message_id = $this->insertMessages($subject, $message);
				if ($this->message_id)
					{
						foreach($this->send_ids as $to_id)
							{
								if (!$to_id) continue;
								$info_id=$this->insertMessagesInfoChild($to_id, $to_notify);
								$this->insertMessagesContact($to_id);
								$this->increaseNewMailCount($to_id);

								if(chkIsAllowedNotificationEmail('new_mail_inbox', $to_id))
									{
										$mail_link = '<a href="'.$mail_url.'">'.$mail_url.'</a>';
										$link = '<a href="'.$this->CFG['site']['url'].'">'.$this->CFG['site']['url'].'</a>';
										$subject = $this->LANG['new_mail_received_subject'];
										$subject = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $subject);
										$message = $this->LANG['new_mail_received_content'];
										$message = str_replace('VAR_RECEIVER_NAME', $this->user_details[$to_id]['user_name'], $message);
										$message = str_replace('VAR_SENDER_NAME', $this->CFG['user']['user_name'], $message);
										$message = str_replace('VAR_MAIL_LINK', $mail_link, $message);
										$message = str_replace('VAR_LINK', $link, $message);
										$message = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $message);
										$from = $this->CFG['user']['email'];
										$to = $this->user_details[$to_id]['email'];

										$this->_sendMail($to, $subject, $message, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);
									}
							}

						switch($this->fields_arr['action'])
							{
								case 'reply':
									$this->updateMessageStatus($this->fields_arr['message_id'], $this->fields_arr['answer_id'], 'Reply');
									break;
								case 'forward':
									$this->updateMessageStatus($this->fields_arr['message_id'], $this->fields_arr['answer_id'], 'Forward');
									break;
								case 'replyBulletin':
									$this->updateBulletinReplies($this->fields_arr['bulletin_id']);
									break;
							} // switch
						return true;
					}

				$this->setCommonErrorMsg($err_tip);
				return false;
			}

		/**
		 * MailComposeFormHandler::setErrorMessage()
		 *
		 * @return
		 */
		public function setErrorMessage()
			{
				$err_tip = '<br />';
				//INVALID RELATION//
				if(!empty($this->invalid_relation_array))
					{
						$error_msg = '';
						foreach($this->invalid_relation_array as $relation_value)
							{
								$error_msg .= '['.$relation_value.'], ';
							}
						$error_msg = substr($error_msg, 0, -2);
						$err_tip .= str_replace('VAR_RELATION',$error_msg,$this->LANG['mailcompose_err_tip_invalid_relation']);
						$err_tip .= '<br />';
					}
				//NOT MEMBER//
				if(!empty($this->invalid_user_array))
					{
						$error_msg = '';
						foreach($this->invalid_user_array as $member_value)
							{
								$error_msg .= '('.$member_value.'), ';
							}
						$error_msg = substr($error_msg, 0, -2);
						$err_tip .= str_replace('VAR_FRIEND',$error_msg,$this->LANG['mailcompose_err_tip_username_not_exceeds']);
						$err_tip .= '<br />';
					}
				//BLOCKED MEMBER//
				if(!empty($this->invalid_blockedmember_array))
					{
						$error_msg = '';
						foreach($this->invalid_blockedmember_array as $blockedmember_value)
							{
								$error_msg .= $blockedmember_value.', ';
							}
						$error_msg = substr($error_msg, 0, -2);
						$err_tip .= str_replace('VAR_FRIEND',$error_msg,$this->LANG['mailcompose_err_tip_username_blocked']);
						$err_tip .= '<br />';
					}
				//WRONG FORMAT//
				if(!empty($this->wrong_format_array))
					{
						$error_msg = '';
						foreach($this->wrong_format_array as $wrong_value)
							{
								$error_msg .= $wrong_value.', ';
							}
						$error_msg = substr($error_msg, 0, -2);
						$err_tip .= str_replace('VAR_RELATION',$error_msg,$this->LANG['mailcompose_err_tip_wrong_format']);
						$err_tip .= '<br />';
					}
				$this->common_error_message = $err_tip;
				return true;
			}

		/**
		 * To insert subject and mail in mails table and return messgage id
		 *
		 * @param 		string $subject
		 * @param 		string $message
		 * @access public
		 * @return integer $message_id
		 **/
		public function insertMessages($subject, $message)
			{
				($this->fields_arr[$subject] == '')? $this->fields_arr[$subject] = 'No subject' : '';
				$message = $this->fields_arr[$message];

				$original_message = '';
				if ($this->fields_arr['include_original_message'] == 'Yes')
					{
						switch($this->fields_arr['action']){
							case 'reply':
							case 'forward':
								$original_message = $this->getOriginalMessage($this->fields_arr['msgFolder'], $this->fields_arr['message_id']);
								break;
							case 'replyBulletin':
								$original_message = $this->getOriginalBulletin($this->fields_arr['bulletin_id']);
								break;
						} // switch
					}
				if ($original_message)
					{
						$message .= addslashes($original_message);
				    }

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['messages'].
						' SET subject = '.$this->dbObj->Param($this->fields_arr[$subject]).
						', message ='.$this->dbObj->Param($message).
						', mess_date = NOW()';
		        $stmt = $this->dbObj->Prepare($sql);
		        $rs = $this->dbObj->Execute($stmt, array($this->fields_arr[$subject], $message));
		        if (!$rs)
		            trigger_db_error($this->dbObj);

		        return $this->dbObj->Insert_ID();
			}

		/**
		 * To insert from_id, to_id, and mail status in mails_info table and return true in sucess
		 *
		 * @param 	integer $to_id
		 * @param 	string $to_notify
		 * @access public
		 * @return boolean
		 **/
		public function insertMessagesInfoChild($to_id, $to_notify)
			{
				if(!$this->fields_arr[$to_notify])
					{
						$this->fields_arr[$to_notify] = 'No';
					}
				$sql = 'INSERT INTO ' . $this->CFG['db']['tbl']['messages_info'].
						' SET message_id = '.$this->dbObj->Param($this->message_id).
						', from_id ='.$this->dbObj->Param($this->CFG['user']['user_id']).
						', to_id ='.$this->dbObj->Param($to_id).
						', to_notify ='.$this->dbObj->Param($this->fields_arr[$to_notify]);
				$fields_value_arr = array($this->message_id, $this->CFG['user']['user_id'], $to_id,
										  $this->fields_arr[$to_notify]);
		        $stmt = $this->dbObj->Prepare($sql);
		        $rs = $this->dbObj->Execute($stmt, $fields_value_arr);
		        if (!$rs)
		                trigger_db_error($this->dbObj);

				return $this->dbObj->Insert_ID();
			}

		/**
		 * To insert the contacts in mails_contacts table
		 *
		 * @access public
		 * @return boolean
		 **/
		public function insertMessagesContact($to_id)
			{
				$sql = 'REPLACE INTO '.$this->CFG['db']['tbl']['messages_contacts'].
						' SET user_id ='.$this->dbObj->Param($this->CFG['user']['user_id']).
						', contacts_id = '.$this->dbObj->Param($to_id);
		        $stmt = $this->dbObj->Prepare($sql);
		        $rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $to_id));
		        if (!$rs)
		                trigger_db_error($this->dbObj);
		        return true;
			}

		/**
		 * To update the new mail counts
		 *
		 * @param integer $user_id
		 * @access public
		 * @return void
		 **/
		public function increaseNewMailCount($user_id)
			{
				if ($this->fields_arr['video'])
					return true;

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
						' SET new_mails = new_mails + 1'.
						' WHERE user_id= '.$this->dbObj->Param($user_id);
		        $stmt = $this->dbObj->Prepare($sql);
		        $rs = $this->dbObj->Execute($stmt, array($user_id));
		        if (!$rs)
		        	trigger_db_error($this->dbObj);

		        return true;
			}

		/**
		 * To update the reply count in bulletin table
		 *
		 * @param integer $bulletin_id
		 * @access public
		 * @return void
		 **/
		public function updateBulletinReplies($bulletin_id)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['bulletin'].
						' SET total_replies = total_replies + 1'.
						' WHERE bulletin_id = '.$this->dbObj->Param($bulletin_id);
		        $stmt = $this->dbObj->Prepare($sql);
		        $rs = $this->dbObj->Execute($stmt, array($bulletin_id));
		        if (!$rs)
		                trigger_db_error($this->dbObj);

		        return true;
			}

		/**
		 * To update the answer status of original message
		 *
		 * @param integer $message_id
		 * @param string $value
		 * @access public
		 * @return void
		 **/
		public function updateMessageStatus($message_id, $answer_id, $value)
			{
				$answer_column = 'from_answer';
				if ($answer_id == $this->CFG['user']['user_id'])
					{
						$answer_column = 'to_answer';
				    }
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['messages_info'].
						' SET '.$answer_column.' = '.$this->dbObj->Param($value).
						' WHERE info_id = '.$this->dbObj->Param($message_id);
		        $stmt = $this->dbObj->Prepare($sql);
		        $rs = $this->dbObj->Execute($stmt, array($value, $message_id));
		        if (!$rs)
		                trigger_db_error($this->dbObj);

		        return true;
			}

		/**
		 * To get the message details from the given message folder
		 *
		 * @param string $msgFolder
		 * @param integer $message_id
		 * @access public
		 * @return void
		 **/
		public function getOriginalMessage($msgFolder, $message_id)
			{
				if (!$msgFolder && !$message_id)
					{
						return false;
				    }
				$sql = $this->getQuery($msgFolder, $message_id);
				if (!$sql)
					{
						return false;
				    }
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $this->sql_field_values);
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if ($row = $rs->FetchRow())
					{
						$name = getUserDisplayName($row);

						$itlalic_start_tag = '&lt;span style=\&quot;font-style: italic;\&quot;&gt;';
						$itlalic_end_tag = '&lt;/span&gt;';
						$newline = '&lt;br /&gt;';

						$original_message = $newline.$newline.$newline;
						$original_message .= $itlalic_start_tag.$this->LANG['mailcompose_original_message'].$itlalic_end_tag.$newline;
						$original_message .= $itlalic_start_tag.$this->LANG['mailcompose_from'].': '.$name.$itlalic_end_tag.$newline;
						$original_message .= $itlalic_start_tag.$this->LANG['mailcompose_sent'].': '.$row['mess_date'].$itlalic_end_tag.$newline;
						$original_message .= $itlalic_start_tag.$this->LANG['mailcompose_subject'].': '.$row['subject'].$itlalic_end_tag.$newline.$newline;
						$original_message .= $row['message'];

						return $original_message;
				    }
				return false;
			}

		/**
		 * To get the message details from the given message folder
		 *
		 * @param string $action
		 * @param string $msgFolder
		 * @param integer $message_id
		 * @access public
		 * @return void
		 **/
		public function getMessage($action, $msgFolder, $message_id)
			{
				if (!$action || !$msgFolder || !$message_id)
					{
						return false;
				    }
				$sql = $this->getQuery($msgFolder, $message_id);
				if (!$sql)
					{
						return false;
				    }

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $this->sql_field_values);
				if (!$rs)
				        trigger_db_error($this->dbObj);

				if ($row = $rs->FetchRow())
					{
						switch($msgFolder)
							{
								case 'inbox':
									$userDetails = $this->getUserDetail('user_id', $row['from_id']);
									break;
								case 'sent':
									$userDetails = $this->getUserDetail('user_id', $row['to_id']);
									break;
								case 'saved':
									$userDetails = $this->getUserDetail('user_id', $row['from_id']);
									break;
								case 'video':
									$userDetails = $this->getUserDetail('user_id', $row['from_id']);
									break;
							}
						$name = getUserDisplayName($userDetails);
						$original_message = $this->LANG['mailcompose_original_message'].'<br />'.'
											'.$this->LANG['mailcompose_from'].': '.$name.'<br />'.'
											'.$this->LANG['mailcompose_sent'].': '.$row['mess_date'].'<br />'.'
											'.$this->LANG['mailcompose_subject'].': '.$row['subject'].'<br /><br />'.'

											'.htmlentitydecode(stripslashes($row['message']));

						if ($action == 'reply')
							{
								$this->setFormField('username', $userDetails['user_name']);
								if(strpos($row['subject'], $this->LANG['mailcompose_reply_subject'])===0)
									$this->LANG['mailcompose_reply_subject'] = '';
								$this->setFormField('subject', $this->LANG['mailcompose_reply_subject'].stripslashes($row['subject']));
							}
						else
							{
								if(strpos($row['subject'], $this->LANG['mailcompose_forward_subject'])===0)
									$this->LANG['mailcompose_forward_subject'] = '';

								$this->setFormField('subject', $this->LANG['mailcompose_forward_subject'].stripslashes($row['subject']));
							}
						$this->setFormField('answer_id', $row['to_id']);
						$this->setFormField('message', $original_message);
						return true;
				    }
				return false;
			}

		/**
		 * To get the bulletin
		 *
		 * @param integer $bulletin_id
		 * @access public
		 * @return void
		 **/
		public function getOriginalBulletin($bulletin_id)
			{
				$sql = 'SELECT b.bulletin_id, b.user_id, b.subject, b.bulletin, b.access_status, b.total_views'.
						', b.total_replies, DATE_FORMAT( b.date_added, \''.$this->CFG['format']['date'].'\' ) AS date_added'.
						', u.first_name, u.last_name, u.user_name, u.allow_bulletin'.
						' FROM '.$this->CFG['db']['tbl']['bulletin'].' AS b'.
						' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON b.user_id = u.user_id'.
						' WHERE b.bulletin_id = '.$this->dbObj->Param($bulletin_id).
						' AND u.allow_bulletin = \'Yes\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($bulletin_id));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				if ($row = $rs->FetchRow())
					{
						$name = getUserDisplayName($row);

						$itlalic_start_tag = '&lt;span style=\&quot;font-style: italic;\&quot;&gt;';
						$itlalic_end_tag = '&lt;/span&gt;';
						$newline = '&lt;br /&gt;';

						$original_message = $newline.$newline;
						$original_message .= $itlalic_start_tag.$this->LANG['mailcompose_reply_bulletin'].$itlalic_end_tag.$newline;
						$original_message .= $itlalic_start_tag.$this->LANG['mailcompose_from'].': '.$name.$itlalic_end_tag.$newline;
						$original_message .= $itlalic_start_tag.$this->LANG['mailcompose_sent'].': '.$row['date_added'].$itlalic_end_tag.$newline;
						$original_message .= $itlalic_start_tag.$this->LANG['mailcompose_subject'].': '.$row['subject'].$itlalic_end_tag.$newline.$newline;
						$original_message .= $row['bulletin'];

						return $original_message;
				    }
				return false;
			}

		/**
		 * To get the bulletin
		 *
		 * @param integer $bulletin_id
		 * @access public
		 * @return void
		 **/
		public function getBulletin($bulletin_id)
			{
				$sql = 'SELECT b.bulletin_id, b.user_id, b.subject, b.bulletin, b.access_status, b.total_views'.
						', b.total_replies, DATE_FORMAT( b.date_added, \''.$this->CFG['format']['date'].'\' ) AS date_added'.
						', u.first_name, u.last_name, u.user_name, u.allow_bulletin'.
						' FROM '.$this->CFG['db']['tbl']['bulletin'].' AS b'.
						' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON b.user_id = u.user_id'.
						' WHERE b.bulletin_id = '.$this->dbObj->Param($bulletin_id).
						' AND u.allow_bulletin = \'Yes\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($bulletin_id));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				if ($row = $rs->FetchRow())
					{
						$name = getUserDisplayName($row);

						$bulletin_message = $this->LANG['mailcompose_reply_bulletin'].'
'.$this->LANG['mailcompose_from'].': '.$name.'
'.$this->LANG['mailcompose_sent'].': '.$row['date_added'].'
'.$this->LANG['mailcompose_subject'].': '.$row['subject'].'

'.html_entity_decode(stripslashes($row['bulletin']));

						$this->setFormField('username', $row['user_name']);
						$this->setFormField('subject', $this->LANG['mailcompose_reply_bulletin_subject'].stripslashes($row['subject']));
						$this->setFormField('include_original_message', 'Yes');
						$this->setFormField('original_message', $bulletin_message);
						return true;
				    }
				return false;
			}

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function getQuery($msgFolder, $message_id)
			{
				$sql = '';
				$this->sql_field_values = array();
				switch($msgFolder)
					{
						case 'inbox':
							$sql = 'SELECT mi.info_id, mi.message_id, u.user_id, u.user_name, u.icon_type, u.icon_id, u.last_name, u.first_name, u.sex,m.subject, m.message'.
									', DATE_FORMAT(m.mess_date, \''.$this->CFG['format']['date'].'\') as mess_date, mi.to_viewed, mi.to_answer'.
									', DATE_FORMAT(m.mess_date, \'%I:%i %p\') as mess_time, attachment, mi.to_id, mi.from_id, mi.to_notify, mi.email_status'.
									' FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['messages'].' AS m, '.$this->CFG['db']['tbl']['messages_info'].' AS mi'.
									' WHERE mi.to_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id'.
									' AND mi.message_id = m.message_id'.
									' AND mi.to_delete = \'No\''.
									' AND mi.to_stored = \'No\''.
									' AND mi.email_status != \'Video\''.
									' AND mi.info_id = '.$this->dbObj->Param($this->fields_arr['message_id']).
									' ORDER BY mi.info_id DESC';
							$fields_value_arr = array($this->CFG['user']['user_id'], $this->fields_arr['message_id']);
							break;
						case 'sent':
							$sql = 'SELECT mi.info_id, mi.message_id, u.user_id, u.last_name, u.first_name, u.sex, m.subject, m.message'.
									', DATE_FORMAT(m.mess_date, \''.$this->CFG['format']['date'].'\') as mess_date, mi.from_viewed, mi.from_answer'.
									', DATE_FORMAT(m.mess_date, \'%I:%i %p\') as mess_time, attachment, mi.to_id, mi.from_id, u.user_name, u.icon_type, u.icon_id'.
									' FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['messages'].' AS m, '.$this->CFG['db']['tbl']['messages_info'].' AS mi'.
									' WHERE mi.from_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.to_id = u.user_id'.
									' AND mi.message_id = m.message_id'.
									' AND mi.from_delete = \'No\''.
									' AND mi.from_stored = \'No\''.
									' AND mi.email_status = \'Normal\''.
									' AND mi.info_id = '.$this->dbObj->Param($this->fields_arr['message_id']).
									' ORDER BY mi.info_id DESC';
							$fields_value_arr = array($this->CFG['user']['user_id'], $this->fields_arr['message_id']);
							break;
						case 'saved':
							$sql = 'SELECT mi.info_id, mi.message_id, mi.to_id, mi.from_id, u.user_id, u.last_name, u.first_name, u.sex, m.subject, m.message'.
									', DATE_FORMAT( m.mess_date, \''.$this->CFG['format']['date'].'\' ) AS mess_date, mi.to_viewed, mi.to_notify, mi.to_answer, attachment'.
									', DATE_FORMAT(m.mess_date, \'%I:%i %p\') as mess_time, u.user_name, u.icon_type, u.icon_id'.
									' FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['messages'].' AS m, '.$this->CFG['db']['tbl']['messages_info'].' AS mi'.
									' WHERE ((mi.to_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id AND mi.to_stored = \'Yes\' AND mi.to_delete = \'No\''.
									' AND mi.info_id = '.$this->dbObj->Param($this->fields_arr['message_id']).')'.
									' OR (mi.from_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id AND mi.from_stored = \'Yes\' AND mi.from_delete = \'No\''.
									' AND mi.info_id = '.$this->dbObj->Param($this->fields_arr['message_id']).'))'.
									' AND mi.message_id = m.message_id'.
									' ORDER BY info_id DESC';
							$fields_value_arr = array($this->CFG['user']['user_id'], $this->fields_arr['message_id'],
													  $this->CFG['user']['user_id'], $this->fields_arr['message_id']);
							break;
						case 'trash':
							$sql = 'SELECT mi.info_id, mi.message_id, mi.to_id, mi.from_id, u.user_id, u.last_name, u.first_name, u.sex, m.subject, m.message'.
									', DATE_FORMAT( m.mess_date, \''.$this->CFG['format']['date'].'\' ) AS mess_date, mi.to_viewed, mi.to_notify, mi.to_answer, attachment'.
									', DATE_FORMAT(m.mess_date, \'%I:%i %p\') as mess_time, u.user_name, u.icon_type, u.icon_id'.
									' FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['messages'].' AS m, '.$this->CFG['db']['tbl']['messages_info'].' AS mi'.
									' WHERE ((mi.to_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id AND mi.to_delete = \'Yes\''.
									' AND mi.info_id = '.$this->dbObj->Param($this->fields_arr['message_id']).')'.
									' OR (mi.from_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
									' AND mi.from_id = u.user_id AND mi.from_delete = \'Yes\''.
									' AND mi.info_id = '.$this->dbObj->Param($this->fields_arr['message_id']).'))'.
									' AND mi.message_id = m.message_id'.
									' ORDER BY info_id DESC';
							$fields_value_arr = array($this->CFG['user']['user_id'], $this->fields_arr['message_id'],
													  $this->CFG['user']['user_id'], $this->fields_arr['message_id']);
							break;
						case 'request':
							$sql = 'SELECT mi.info_id, mi.message_id, u.user_id, u.last_name, u.first_name, u.sex, m.subject, m.message'.
									', DATE_FORMAT(m.mess_date, \''.$this->CFG['format']['date'].'\') as mess_date, mi.to_viewed, mi.to_answer'.
									', DATE_FORMAT(m.mess_date, \'%I:%i %p\') as mess_time, attachment, mi.to_id, mi.from_id, mi.email_status, mi.to_notify, u.user_name, u.icon_type, u.icon_id'.
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
							break;
						case 'video':
							$sql = 'SELECT mi.info_id, mi.message_id, u.user_id, u.last_name, u.first_name, m.subject, m.message'.
									', DATE_FORMAT(m.mess_date, \''.$this->CFG['format']['date'].'\') as mess_date, mi.to_viewed, mi.to_answer'.
									', DATE_FORMAT(m.mess_date, \'%I:%i %p\') as mess_time, attachment, mi.to_id, mi.from_id, mi.email_status, mi.to_notify, u.user_name, u.icon_type, u.icon_id'.
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
							break;
					} // switch
				$this->sql_field_values = $fields_value_arr;
				return $sql;
			}

		/**
		 * MailComposeFormHandler::displayMandatoryIcon()
		 * Display the mandatory icon
		 *
		 * @param  string $field_name
		 * @return string
		 * @access public
		 */
		public function displayMandatoryIcon($field_name='')
			{
				$mandatoryFields = array('username');
				if($field_name == '*' OR (in_array($field_name, $mandatoryFields)))
					{
						$this->displayCompulsoryIcon();
					}
			}

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function chkValidProfile($user_id)
			{
				$sql = 'SELECT user_id, user_name FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_id = '.$this->dbObj->Param($user_id).
						' AND usr_status = \'Ok\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				if ($row = $rs->FetchRow())
					{
					    return $row;
					}
				return false;
			}
	}
//<<<<<<<--------------class MailComposeFormHandler---------------//

//--------------------Code begins-------------->>>>>//
$mailcompose = new MailComposeFormHandler();

if(!$mailcompose->chkAllowedModule(array('mail')))
	Redirect2URL(getUrl($CFG['redirect']['dsabled_module_url']['file_name']));

$mailcompose->setPageBlockNames(array('form_error', 'form_success', 'form_compose'));
//default form fields and values...
$mailcompose->setFormField('username', '');
$mailcompose->setFormField('subject', '');
$mailcompose->setFormField('goto', 'compose');
$mailcompose->setFormField('message', '');
$mailcompose->setFormField('to_notify', '');
$mailcompose->setFormField('video', '');
$mailcompose->setFormField('mcomp', '');

$mailcompose->setFormField('answer_id', '');
$mailcompose->setFormField('action', '');
$mailcompose->setFormField('msgFolder', '');
$mailcompose->setFormField('message_id', '');
$mailcompose->setFormField('original_message', '');
$mailcompose->setFormField('include_original_message', '');
$mailcompose->setFormField('bulletin_id', '');
$mailcompose->setFormField('recaptcha_challenge_field', '');
$mailcompose->setFormField('recaptcha_response_field', '');

$mailcompose->setAllPageBlocksHide();
if ($CFG['user']['usr_access'] == 'Admin' OR checkUserPermission($CFG['user']['user_actions'], 'compose_mail') == 'Yes')
	{
		$mailcompose->setPageBlockShow('form_compose');
		$smartyObj->assign('populateContacts', $mailcompose->populateContacts($mailcompose->getFormField('username')));
		$smartyObj->assign('populateFriends', $mailcompose->populateFriends($mailcompose->getFormField('username')));
		$smartyObj->assign('populateRelations', $mailcompose->populateRelations($mailcompose->getFormField('username')));
		$smartyObj->assign('select_username_url',getUrl('selectusernames', '', '', 'members'));

		$mailcompose->sanitizeFormInputs($_REQUEST);
		//Patch Added for send message link;
		if ($mailcompose->isFormGETed($_GET, 'mcomp'))
			{
				$mailcompose->setFormField('username', $mailcompose->getFormField('mcomp'));
			}
		if ($mailcompose->isFormGETed($_GET, 'viewprofile'))
			{
				$mailcompose->setFormField('viewprofile', '');
				$mailcompose->sanitizeFormInputs($_GET);
				if ($user_details_arr = $mailcompose->chkValidProfile($mailcompose->getFormField('viewprofile')))
					{
						$profile_link = '<a href="'.getMemberProfileUrl($user_details_arr['user_id'], $user_details_arr['user_name']).'">'.getMemberProfileUrl($user_details_arr['user_id'], $user_details_arr['user_name']).' </a>';
						$profile_message = str_replace('VAR_PROFILE_LINK', $profile_link, $LANG['mailcompose_profile_message']);
						$mailcompose->setFormField('message', html_entity_decode($profile_message));
				    }
			}
		if ($mailcompose->isFormPOSTed($_POST, 'mailcompose_submit'))
			{
				$mailcompose->chkIsNotEmpty('username', $mailcompose->LANG['common_err_tip_compulsory']);
				$mailcompose->chkIsNotEmpty('message', $mailcompose->LANG['common_err_tip_compulsory']);
				if($CFG['mail']['captcha'])
					{
						if($CFG['mail']['mail_captcha_method'] == 'recaptcha' and $CFG['captcha']['public_key'] and $CFG['captcha']['private_key'])
							{
								$mailcompose->chkIsNotEmpty('recaptcha_response_field', $LANG['common_err_tip_compulsory']) and
									$mailcompose->chkCaptcha('recaptcha_response_field', $LANG['common_err_tip_invalid_captcha']);
							}
					}

				if ($mailcompose->isValidFormInputs())
					{
						$mailcompose->sendMail('username', 'subject', 'message', 'to_notify', $mailcompose->LANG['mailcompose_err_tip_mail_not_sent']);
						if ($mailcompose->isValidFormInputs())
							{
									$mailcompose->setAllPageBlocksHide();
									$mailcompose->setCommonSuccessMsg($mailcompose->LANG['mailcompose_success_mail']);
									$mailcompose->setPageBlockShow('form_success');
									$mailcompose->setPageBlockShow('form_compose');
									switch($mailcompose->getFormField('goto'))
										{
											case 'inbox':
												Redirect2URL(getUrl('mail', '?folder=inbox&msg=1', 'inbox/?msg=1', 'members'));
												break;
											case 'sent':
												Redirect2URL(getUrl('mail', '?folder=sent&msg=1', 'sent/?msg=1', 'members'));
												break;
											default:
												Redirect2URL(getUrl('mailcompose', '?msg=1', '?msg=1', 'members'));
										} // switch
							}
						else
							{
								$mailcompose->setAllPageBlocksHide();
								$mailcompose->setPageBlockShow('form_error');
								$mailcompose->setPageBlockShow('form_compose');
							}
					}
				else //error in form inputs
					{
						$mailcompose->setAllPageBlocksHide();
						$mailcompose->setPageBlockShow('form_error');
						$mailcompose->setPageBlockShow('form_compose');
					}
			}
		if ($mailcompose->getFormField('action'))
			{
				switch($mailcompose->getFormField('action'))
					{
						case 'reply':
						case 'forward':
							if ($mailcompose->getFormField('message_id') && $mailcompose->getFormField('msgFolder'))
								{
									if (!$mailcompose->getMessage($mailcompose->getFormField('action'), $mailcompose->getFormField('msgFolder'), $mailcompose->getFormField('message_id')))
										{
											$mailcompose->setFormField('action', '');
											$mailcompose->setFormField('msgFolder', '');
											$mailcompose->setFormField('message_id', '');
									    }
								}
							break;
						case 'replyBulletin':
							if ($mailcompose->getFormField('bulletin_id'))
								{
									if (!$mailcompose->getBulletin($mailcompose->getFormField('bulletin_id')))
										{
											$mailcompose->setFormField('action', '');
											$mailcompose->setFormField('bulletin_id', '');
									    }
								}
							break;
					} // switch
			}
		if ($mailcompose->isFormGETed($_GET, 'msg'))
			{
				$mailcompose->setAllPageBlocksHide();
				$mailcompose->setCommonSuccessMsg($mailcompose->LANG['mailcompose_success_mail']);
				$mailcompose->setPageBlockShow('form_success');
				$mailcompose->setPageBlockShow('form_compose');
			}

	}
else
	{
		$mailcompose->setAllPageBlocksHide();
		$mailcompose->setCommonErrorMsg($LANG['mailcompose_permission_not_available']);
		$mailcompose->setPageBlockShow('form_error');
	}

//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//
if ($mailcompose->isShowPageBlock('form_compose'))
	{
		$mailcompose->selFormCompose_hidden_arr = array('action', 'msgFolder', 'message_id', 'answer_id');
	}
//include the header file
$mailcompose->includeHeader();
?>
<script type="text/javascript" language="javascript">
	var palette_url = '<?php echo $mailcompose->CFG['site']['url'].'admin/palette.htm';?>';
	var block_arr= new Array('selMsgConfirm');
</script>
<?php
//include the content of the page
setTemplateFolder('members/');
$smartyObj->display('mailCompose.tpl');
?>
<script type="text/javascript" language="javascript">
	$Jq(document).ready(function() {

	$Jq('#selComposeSelectUserDiv').fancybox({
		'width'				: 865,
		'height'			: 336,
		'padding'			:  0,
		'autoScale'     	: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});

});
</script>
<?php
//<<<<<-------------------- Page block templates ends -------------------//
if ($mailcompose->isShowPageBlock('form_compose') and $CFG['feature']['jquery_validation']) {
?>
<script type="text/javascript">
	$Jq("#selFormCompose").validate({
		rules: {
		    username: {
		    	required: true
		    }/*,
		    message: {
		    	required: true
		    }*/
		},
		messages: {
			username: {
				required: "<?php echo $LANG['common_err_tip_required'];?>"
			}/*,
		    message: {
		    	required: "<?php echo $LANG['common_err_tip_required'];?>"
		    }*/
		}
	});
</script>
<?php
}
$mailcompose->includeFooter();
?>