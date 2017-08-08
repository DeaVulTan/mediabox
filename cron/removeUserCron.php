<?php
/**
 * This file to delete the user from the system
 *
 *
 * @category	Rayzz
 * @package		User
 */
/**
 * Including the config file to get the global data for site
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
//------------------- Class User Begins ------->>>>>//
/**
 * @category	cann
 * @package		User
 * @author 		selvaraj_47ag04
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		Release: @package_version@
 * @since 		2007-10-16
 */
 class User extends FormHandler
	{
		/**
		 * User::removeUsers()
		 *
		 * @return
		 **/
		public function removeUsers()
			{
				$sql = 'SELECT user_id FROM '.$this->CFG['db']['tbl']['users'].' WHERE usr_status=\'Deleted\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
						    {
								// do something in deleted users
						    }
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['users'].' WHERE usr_status=\'Deleted\'';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						    if (!$rs)
							    trigger_db_error($this->dbObj);
					}
			}

	}
//<<<<<-------------------- Class User Ends ------------------------//
//------------------------- Code Begins ---------------------------------->>>>>//
$cronemailfrm = new User();
callMultipleCronCheck();
$cronemailfrm->removeUsers();
//require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');
?>
