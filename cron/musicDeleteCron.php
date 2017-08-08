<?php
/**
 * This file is to manage deleted music
 *
 * This file is having ManageDeleted class to manage deleted music
 *
 * @category	rayzz
 * @package		Cron
 *
 **/
$called_from_cron = true;
require_once(dirname(dirname(__FILE__)).'/common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_CronHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_musicRelatedCron.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['auth']['is_authenticate'] = false;
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class ConfigEdit begins -------------------->>>>>//
set_time_limit(0);
/**
 * ManageDeleted
 *
 * @package
 * @author karthiselvam_045at09
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id$
 * @access public
 */
class ManageDeleted extends CronDeleteMusicHandler
	{
		public function deleteMusics()
			{
				echo $sql = 'SELECT music_id, music_category_id FROM '.$this->CFG['db']['tbl']['music'].' WHERE'.
						' music_status=\'Deleted\' OR ( music_encoded_status!=\'Yes\' AND'.
						' date_added<=DATE_SUB(NOW(),INTERVAL 48 HOUR))';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$this->MUSIC_CATEGORY_ID = $row['music_category_id'];
								$this->fields_arr['music_id'] = $row['music_id'];

								echo $row['music_id'],'<br>';
								$this->removeMusicRelatedEntries($row['music_id'], 'music_id');
							}
					}
			}
	}
//<<<<<-------------- Class ManageDeleted begins ---------------//
//-------------------- Code begins -------------->>>>>//
$ManageDeleted = new ManageDeleted();
$ManageDeleted->setDBObject($db);
$ManageDeleted->makeGlobalize($CFG,$LANG);
$ManageDeleted->deleteMusics();
//require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');
?>