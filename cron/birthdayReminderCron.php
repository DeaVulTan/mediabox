<?php
set_time_limit(0);
$called_from_cron = true;
require_once(dirname(dirname(__FILE__)).'/common/configs/config.inc.php');
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include various types of files
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
/**
 * birthdayReminderCron
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class birthdayReminderCron extends FormHandler
	{
		/**
		 * birthdayReminderCron::addNewBirthDayList()
		 *
		 * @return
		 */
		public function addNewBirthDayList()
			{
				if(!$this->CFG['birthday_reminder']['days'])
					{
						return;
					}
				$condition = '(';
				foreach($this->CFG['birthday_reminder']['days'] AS $value)
					{
						$condition .= ' (DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL '.$value.' day), \'%m-%d\')=DATE_FORMAT(dob, \'%m-%d\')) OR';
					}
				$condition = substr($condition, 0, strrpos($condition, 'OR'));
				$condition .= ')';

				$sub_query = ' SELECT user_id, NOW() FROM '.$this->CFG['db']['tbl']['users'].' WHERE usr_status = \'Ok\' AND'.$condition;
				$sql = ' INSERT INTO '.$this->CFG['db']['tbl']['birthday_reminder'].' (user_id, date_added) '.$sub_query;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array());
				if (!$rs)
					trigger_db_error($this->dbObj);

				echo 'Successfully added';
			}
	}
//<<<<<-------------- Class LoginFormHandler begins ---------------//
//-------------------- Code begins -------------->>>>>//
$birthdayReminderCron = new birthdayReminderCron();
callMultipleCronCheck();
$birthdayReminderCron->addNewBirthDayList();
//require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');
?>