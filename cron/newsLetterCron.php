<?php
$called_from_cron = true;
require_once(dirname(dirname(__FILE__)).'/common/configs/config.inc.php');

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include various types of files
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
set_time_limit(0);
/**
 * newLetterCron
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class newLetterCron extends FormHandler
	{
		/**
		 * newLetterCron::getNewsLetter()
		 *
		 * @param mixed $table_name
		 * @param array $fields_arr
		 * @return
		 */
		public function getNewsLetter($table_name, $fields_arr=array())
			{
				$sql = 'SELECT ';
				foreach($fields_arr as $field_name)
						$sql .= $field_name . ', ';
				$sql = substr($sql, 0, strrpos($sql, ','));
				$sql .= ' FROM '.$table_name.
						' WHERE status != \'Finished\' ORDER BY news_letter_id limit 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$row = array();
				if (!$rs->PO_RecordCount())
					return $row;

				$row = $rs->FetchRow();
				$ret_fields_arr = array();
				foreach($fields_arr as $field_name)
					$ret_fields_arr[$field_name] = isset($row[$field_name]) ? $row[$field_name] : '';
				return $ret_fields_arr;
			}

		/**
		 * newLetterCron::getNewsLetterSetting()
		 *
		 * @param mixed $user_id
		 * @return
		 */
		public function getNewsLetterSetting($user_id)
			{
				$sql = 'SELECT news_letter FROM '.$this->CFG['db']['tbl']['users_ans_log'].
						' WHERE user_id = '.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					return $row['news_letter'];
			}

		/**
		 * newLetterCron::sendNewsLetter()
		 *
		 * @param mixed $table_name
		 * @param array $fields_arr
		 * @param mixed $new_letter_arr
		 * @param mixed $CFG
		 * @return
		 */
		public function sendNewsLetter($table_name, $fields_arr=array(), $new_letter_arr, $CFG)
			{
				$new_letter_arr['sql_condition'] = ($new_letter_arr['sql_condition'] == '') ? '1 ' : $new_letter_arr['sql_condition'];

				$sql = 'SELECT ';
				foreach($fields_arr as $field_name)
						$sql .= $field_name . ', ';
				$sql = substr($sql, 0, strrpos($sql, ','));
				//removed the condn usr_status = \'Ok\' AND usr_access = \'User\' as givenin july 2 feedback
				$sql .= " FROM ".$table_name.
						" WHERE user_id > ".$this->dbObj->Param('user_id').
						" AND ".htmlentitydecode (stripslashes($new_letter_arr['sql_condition'])).
						" ORDER BY user_id limit 0,".$CFG['news_letter']['send_count'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($new_letter_arr['upto_user_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$row = array();
				if ($count = $rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								if(chkIsAllowedNotificationEmail('newsletter', $row['user_id']))
									{
										$this->setEmailTemplateValue('username', $row['name']);
										$this->setEmailTemplateValue('email', $row['email']);
										$is_ok = $this->_sendMail($row['email'], $new_letter_arr['subject'], $new_letter_arr['body'], $CFG['site']['noreply_name'], $CFG['site']['noreply_email']);
									}
								$ret_arr = array('user_id'=>$row['user_id'],'total'=>$count);
							}
						return $ret_arr;
					}
				return false;
			}

		/**
		 * newLetterCron::updateNewsLetter()
		 *
		 * @param mixed $table_name
		 * @param mixed $new_letter_id
		 * @param mixed $status
		 * @param integer $upto
		 * @param integer $total
		 * @return
		 */
		public function updateNewsLetter($table_name, $new_letter_id, $status, $upto=0, $total = 0)
			{
				$val_arr = array();
				$val_arr[] = $status;

				$sql = 'UPDATE '.$table_name .
						' SET '.
						'status='.$this->dbObj->Param($status);

				if ($upto != 0)
					{
						$sql .= ', upto_user_id = '.$this->dbObj->Param($upto);
						$val_arr[] = $upto;
					}
				if ($total != 0)
					{
						$sql .= ', total_sent = total_sent + '.$this->dbObj->Param($total);
						$val_arr[] = $total;
					}
				$sql .= ' WHERE news_letter_id='.$this->dbObj->Param($new_letter_id);
				$val_arr[] = $new_letter_id;
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$result = $this->dbObj->Execute($stmt, $val_arr);
				//raise user error... fatal
				if (!$result)
						trigger_db_error($this->dbObj);
			}
	}
//<<<<<-------------- Class LoginFormHandler begins ---------------//
//-------------------- Code begins -------------->>>>>//
$newLetterCron = new newLetterCron();
callMultipleCronCheck();

$newLetterCron->setFormField('news_letter_id', '');
$newLetterCron->setFormField('subject', '');
$newLetterCron->setFormField('body', '');
$newLetterCron->setFormField('upto_user_id', '');

$new_letter_arr = $newLetterCron->getNewsLetter($CFG['db']['tbl']['news_letter'], array('news_letter_id','subject','body','upto_user_id', 'sql_condition'));
if (count($new_letter_arr))
	{
		if ($user_arr = $newLetterCron->sendNewsLetter($CFG['db']['tbl']['users'], array('user_id','user_name AS name','email'), $new_letter_arr, $CFG))
			$newLetterCron->updateNewsLetter($CFG['db']['tbl']['news_letter'], $new_letter_arr['news_letter_id'], 'Started', $user_arr['user_id'], $user_arr['total']);
		else
			$newLetterCron->updateNewsLetter($CFG['db']['tbl']['news_letter'], $new_letter_arr['news_letter_id'], 'Finished');
	}
//require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');
?>