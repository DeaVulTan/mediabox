<?php
/**
 * This file to delete the Recent Activities
 *
 *
 * @category	Rayzz
 */
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
 * RecentActivities
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class RecentActivities extends FormHandler
	{
		/**
		 * RecentActivities::removeRecentActivities()
		 *
		 * @return void
		 */
		public function removeRecentActivities()
			{
				$interval_by = strtolower($this->CFG['admin']['myhome']['profile_hits_interval_by']);

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['activity'].
						' WHERE DATE_FORMAT( date_added, \'%Y-%m-%d\' ) < '.
						' DATE_SUB(CURDATE(), INTERVAL '.$this->CFG['admin']['myhome']['recent_activities_interval'].' '.$interval_by.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['general_activity'].
						' WHERE DATE_FORMAT( date_added, \'%Y-%m-%d\' ) < '.
						' DATE_SUB(CURDATE(), INTERVAL '.$this->CFG['admin']['myhome']['recent_activities_interval'].' '.$interval_by.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['video_activity'].
						' WHERE DATE_FORMAT( date_added, \'%Y-%m-%d\' ) < '.
						' DATE_SUB(CURDATE(), INTERVAL '.$this->CFG['admin']['myhome']['recent_activities_interval'].' '.$interval_by.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

			}
	}
//<<<<<-------------------- Class User Ends ------------------------//
//------------------------- Code Begins ---------------------------------->>>>>//
$RecentActivities = new RecentActivities();
callMultipleCronCheck();
$RecentActivities->removeRecentActivities();
//require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');
?>