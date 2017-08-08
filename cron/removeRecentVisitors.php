<?php
/**
 * This file to delete the Recent Visitors
 *
 *
 * @category	Rayzz
 */
$called_from_cron = true;
require_once(dirname(dirname(__FILE__)).'/common/configs/config.inc.php');
$CFG['mods']['is_include_only']['non_html_header_files'] = true;

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include various types of files
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
/**
 * ProfileVisitors
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class ProfileVisitors extends FormHandler
	{
		/**
		 * ProfileVisitors::removeProfileVisitors()
		 *
		 * @return
		 */
		public function removeProfileVisitors()
			{
				$interval_by = strtolower($this->CFG['admin']['myhome']['profile_hits_interval_by']);

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['users_views'].
						' WHERE DATE_FORMAT( last_viewed_date, \'%Y-%m-%d\' ) < '.
						' DATE_SUB(CURDATE(), INTERVAL '.$this->CFG['admin']['myhome']['profile_hits_interval'].' '.$interval_by.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

			}
	}
//<<<<<-------------------- Class User Ends ------------------------//
//------------------------- Code Begins ---------------------------------->>>>>//
$removeProfileVisitors = new ProfileVisitors();
callMultipleCronCheck();
$removeProfileVisitors->removeProfileVisitors();
//require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');
?>