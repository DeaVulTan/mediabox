<?php
/**
 * Class to handle the form fields
 *
 * This is having class MailHandler to handle the internal mails.
 *
 * PHP version 5.0
 *
 * @category	###Visual Answers###
 * @package		###Common/Classes###
 * @author		senthil_52ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id : $
 * @since 		2007-09-14
 */
if(class_exists('ListRecordsHandler'))
	{
		$parent_class = 2;
	}
elseif(class_exists('FormHandler'))
	{
		$parent_class = 1;
	}

switch($parent_class)
	{
		case 2:
			class Handler extends ListRecordsHandler{}
			break;
		case 1:
		default:
			class Handler extends FormHandler{}
			break;
	}

/**
 * MailHandler
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class MailHandler extends Handler
	{
		//Default folder array
		public $allowed_folder = array('inbox', 'sent', 'saved', 'trash', 'request', 'video');
		//Fodler to update new mail count
		public $updateNewMailInFolder = array('inbox', 'request', 'video');
		//To store message title
		public $mail_title = '';

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function chkIsValidFolder()
		    {
				$ok = true;
				if (!in_array($this->fields_arr['folder'], $this->allowed_folder))
					$ok = false;
				return $ok;
		    }

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function getMailReadNormalUrl()
		    {
				switch($this->fields_arr['folder']){
					case 'inbox':
						$normalUrl = $this->CFG['admin']['mail_urls']['read_inbox']['normal'];
						break;
					case 'sent':
						$normalUrl = $this->CFG['admin']['mail_urls']['read_sent']['normal'];
						break;
					case 'saved':
						$normalUrl = $this->CFG['admin']['mail_urls']['read_saved']['normal'];
						break;
					case 'trash':
						$normalUrl = $this->CFG['admin']['mail_urls']['read_trash']['normal'];
						break;
					case 'request':
						$normalUrl = $this->CFG['admin']['mail_urls']['read_request']['normal'];
						break;
					case 'video':
						$normalUrl = $this->CFG['admin']['mail_urls']['read_video']['normal'];
						break;
					default:
						$normalUrl = $this->CFG['admin']['mail_urls']['read_inbox']['normal'];
						break;
				} // switch
				return $normalUrl;
		    }

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function getMailReadHtaccessUrl()
		    {
			switch($this->fields_arr['folder']){
					case 'inbox':
						$htaccessUrl = $this->CFG['admin']['mail_urls']['read_inbox']['htaccess'];
						break;
					case 'sent':
						$htaccessUrl = $this->CFG['admin']['mail_urls']['read_sent']['htaccess'];
						break;
					case 'saved':
						$htaccessUrl = $this->CFG['admin']['mail_urls']['read_saved']['htaccess'];
						break;
					case 'trash':
						$htaccessUrl = $this->CFG['admin']['mail_urls']['read_trash']['htaccess'];
						break;
					case 'request':
						$htaccessUrl = $this->CFG['admin']['mail_urls']['read_request']['htaccess'];
						break;
					case 'video':
						$htaccessUrl = $this->CFG['admin']['mail_urls']['read_video']['htaccess'];
						break;
					default:
						$htaccessUrl = $this->CFG['admin']['mail_urls']['read_inbox']['htaccess'];
						break;
				} // switch
				return $htaccessUrl;
		    }

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function getMailListNormalUrl()
		    {
				switch($this->fields_arr['folder']){
					case 'inbox':
						$normalUrl = $this->CFG['admin']['mail_urls']['inbox']['normal'];
						break;
					case 'sent':
						$normalUrl = $this->CFG['admin']['mail_urls']['sent']['normal'];
						break;
					case 'saved':
						$normalUrl = $this->CFG['admin']['mail_urls']['sent']['normal'];
						break;
					case 'trash':
						$normalUrl = $this->CFG['admin']['mail_urls']['trash']['normal'];
						break;
					case 'request':
						$normalUrl = $this->CFG['admin']['mail_urls']['request']['normal'];
						break;
					case 'video':
						$normalUrl = $this->CFG['admin']['mail_urls']['video']['normal'];
						break;
					default:
						$normalUrl = $this->CFG['admin']['mail_urls']['inbox']['normal'];
						break;
				} // switch
				return $normalUrl;
		    }

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function getMailListHtaccessUrl()
		    {
				switch($this->fields_arr['folder']){
					case 'inbox':
						$htaccessUrl = $this->CFG['admin']['mail_urls']['inbox']['htaccess'];
						break;
					case 'sent':
						$htaccessUrl = $this->CFG['admin']['mail_urls']['sent']['htaccess'];
						break;
					case 'saved':
						$htaccessUrl = $this->CFG['admin']['mail_urls']['sent']['htaccess'];
						break;
					case 'trash':
						$htaccessUrl = $this->CFG['admin']['mail_urls']['trash']['htaccess'];
						break;
					case 'request':
						$htaccessUrl = $this->CFG['admin']['mail_urls']['request']['htaccess'];
						break;
					case 'video':
						$htaccessUrl = $this->CFG['admin']['mail_urls']['video']['htaccess'];
						break;
					default:
						$htaccessUrl = $this->CFG['admin']['mail_urls']['inbox']['htaccess'];
						break;
				} // switch
				return $htaccessUrl;
		    }

		/**
		 * To change the status of the message
		 *
		 * @access public
		 * @return void
		 **/
		public function updateMessageStatusDelete($column_name, $message_ids, $status = 'Yes')
			{
				$sql = ' UPDATE '.$this->CFG['db']['tbl']['messages_info'].
						' SET '.$column_name.' = \''.$status.'\' WHERE info_id IN ('.addslashes($message_ids).')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				        trigger_db_error($this->dbObj);

				return true;
			}

		/**
		 * To change the status of the message
		 *
		 * @access public
		 * @return void
		 **/
		public function updateMessageStatusTrash($column_name, $message_ids)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['messages_info'].
						' SET '.$column_name .' = \'Trash\' WHERE info_id IN ('.$message_ids.') ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				        trigger_db_error($this->dbObj);
				return true;
			}


		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function sendInternalMail($from_id, $to_id, $subject, $message)
			{
				$message_id = $this->insertMessages($subject, $message);
				$this->insertMessagesInfo($from_id, $to_id, $message_id);
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
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['messages'].
						' SET subject = '.$this->dbObj->Param($subject).
						', message = '.$this->dbObj->Param($message).
						', mess_date = NOW()';
		        $stmt = $this->dbObj->Prepare($sql);
		        $rs = $this->dbObj->Execute($stmt, array($subject, $message));
		        if (!$rs)
		                trigger_db_error($this->dbObj);
		        return $this->dbObj->Insert_ID();
			}

		/**
		 * To insert from_id, to_id, and mail status in mails_info table and return true in sucess
		 *
		 * @access public
		 * @return boolean
		 **/
		public function insertMessagesInfo($from_id, $to_id, $message_id)
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['messages_info'].
						' SET message_id = '.$this->dbObj->Param($message_id).
						', from_id = '.$this->dbObj->Param($from_id).
						', to_id = '.$this->dbObj->Param($to_id);
		        $stmt = $this->dbObj->Prepare($sql);
		        $rs = $this->dbObj->Execute($stmt, array($message_id, $from_id, $to_id));
		        if (!$rs)
		                trigger_db_error($this->dbObj);
		        return $this->dbObj->Insert_ID();
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
				$sql = 'UPDATE ' . $this->CFG['db']['tbl']['users'] . ' SET '.
						'new_mails = new_mails + 1 '.
						'WHERE user_id = '.$this->dbObj->Param($user_id);
		        $stmt = $this->dbObj->Prepare($sql);
		        $rs = $this->dbObj->Execute($stmt, array($user_id));
		        if (!$rs)
		                trigger_db_error($this->dbObj);
		        return true;
			}
		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function messageContentReplace($message, $keywords_arr)
			{
				foreach($keywords_arr as $key=>$value)
					{
						$message = str_replace('VAR_'.strtoupper($key), $value, $message);
					}
				return $message;
			}
		/**
		 * To update new_mails column in users table
		 *
		 * @access public
		 * @return void
		 **/
		public function updateNewMailCount()
			{
				$new_mails = $this->countUnReadMail();
				$new_requests = $this->countUnReadRequests();
				$sql = 'UPDATE '. $this->CFG['db']['tbl']['users'] .' SET  '.
						'new_mails = '.$this->dbObj->Param($new_mails).', '.
						'new_requests = '.$this->dbObj->Param($new_requests).' '.
						'WHERE user_id = '.$this->dbObj->Param($this->CFG['user']['user_id']);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($new_mails, $new_requests, $this->CFG['user']['user_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				return true;
			}
		/**
		 * To get unread mail
		 *
		 * @access public
		 * @return void
		 **/
		public function countUnReadRequests()
			{
				$sql = 'SELECT COUNT( mi.info_id ) AS count '.
						'FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['messages'].' AS ms, '.$this->CFG['db']['tbl']['messages_info'].' AS mi '.
						'WHERE mi.to_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).' '.
						'AND mi.from_id = u.user_id '.
						'AND mi.message_id = ms.message_id '.
						'AND mi.to_viewed = \'No\' '.
						'AND mi.to_delete = \'No\' '.
						'AND mi.to_stored = \'No\' '.
						'AND mi.email_status = \'Request\' ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				$row = $rs->FetchRow();
				return $row['count'];
			}

		/**
		 * To get unread mail in inbox
		 *
		 * @access public
		 * @return void
		 **/
		public function countUnReadMail()
			{
				$sql = 'SELECT COUNT( mi.info_id ) AS count '.
						'FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['messages'].' AS ms, '.$this->CFG['db']['tbl']['messages_info'].' AS mi '.
						'WHERE mi.to_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).' '.
						'AND mi.from_id = u.user_id '.
						'AND mi.message_id = ms.message_id '.
						'AND mi.to_viewed = \'No\' '.
						'AND mi.to_delete = \'No\' '.
						'AND mi.to_stored = \'No\' ';
						//'AND mi.email_status = \'Normal\' ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				$row = $rs->FetchRow();
				return $row['count'];
			}

		/**
		 * MailHandler::countUnReadMailByType()
		 *
		 * @param string $mail_type
		 * @return integer
		 */
		public function countUnReadMailByType($mail_type)
			{
				$sql = 'SELECT COUNT( mi.info_id ) AS count '.
						'FROM '.$this->CFG['db']['tbl']['users'].' AS u, '.
						$this->CFG['db']['tbl']['messages'].' AS ms, '.
						$this->CFG['db']['tbl']['messages_info'].' AS mi '.
						'WHERE mi.to_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).' '.
						'AND mi.from_id = u.user_id '.
						'AND mi.message_id = ms.message_id '.
						'AND mi.to_viewed = \'No\' '.
						'AND mi.to_delete = \'No\' '.
						'AND mi.to_stored = \'No\' '.
						'AND mi.email_status = '.$this->dbObj->Param('mail_type');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $mail_type));
				if (!$rs)
				    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $row['count'];
			}

		/**
		 * To change the status of the message
		 *
		 * @param string $table_name messages_info
		 * @param string $stored_column_name to_stored or from_stored
		 * @param string $delete_column_name to_delete or from_delete
		 * @param integer $message_id
		 * @access public
		 * @return void
		 **/
		public function updateMessageStatusSave($stored_column_name, $delete_column_name, $message_ids)
			{
				$sql = 'UPDATE '. $this->CFG['db']['tbl']['messages_info'] .
						' SET  '. $stored_column_name .' = \'Yes\', '. $delete_column_name .' = \'No\' '.
						'where info_id IN ('.$message_ids.') ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				        trigger_db_error($this->dbObj);
				return true;
			}
		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function populateMailNavigation()
			{

				$cssClassToHighlightSubLink = 'clsActiveMisNavLinks';

				$mail = $mailCompose = $mail_pg_inbox = $mail_pg_sent = $mail_pg_compose = '';
				$currentPage = $this->CFG['html']['current_script_name'];

				$$currentPage = $cssClassToHighlightSubLink;

				$pg = (isset($_REQUEST['folder']))?$_REQUEST['folder']:'';
				$pgRelatedPage = $currentPage.'_pg_'.$pg;
				$$pgRelatedPage = $cssClassToHighlightSubLink;
				if ($currentPage == 'mailRead' and $pg == 'inbox')
					$mail_pg_inbox = $cssClassToHighlightSubLink;
				if ($currentPage == 'mailRead' and $pg == 'sent')
					$mail_pg_sent = $cssClassToHighlightSubLink;

				$mail_arr['inbox']  = getUrl('mail', '?folder=inbox' , 'inbox/' , 'members')	;
				$mail_arr['inbox_class'] = $mail_pg_inbox;
				$mail_arr['sent']   = getUrl('mail', '?folder=sent' , 'sent/' , 'members')	;
				$mail_arr['sent_class'] = $mail_pg_sent;
				$mail_arr['compose']=getUrl('mailcompose', '', '' , 'members')	;
				$mail_arr['compose_class'] = $mailCompose;
				return $mail_arr;
			}
	}
?>
