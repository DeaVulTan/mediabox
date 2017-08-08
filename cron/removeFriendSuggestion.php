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

class FriendSuggestions extends FormHandler
	{
		/**
		 * FriendSuggestions::removeFriendSuggestions()
		 *
		 * @return void
		 */
		public function removeFromFriendSuggestions()
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['friend_suggestion'].
						' WHERE status = \'Deleted\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);
			}
	}
//<<<<<-------------------- Class User Ends ------------------------//
//------------------------- Code Begins ---------------------------------->>>>>//
$FriendSuggestions = new FriendSuggestions();
callMultipleCronCheck();
$FriendSuggestions->removeFromFriendSuggestions();
//require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');
?>