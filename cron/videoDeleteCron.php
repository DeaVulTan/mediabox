<?php
/**
 * This file is to manage deleted video
 *
 * This file is having ManageDeleted class to manage deleted video
 *
 * @category	rayzz
 * @package		Cron
 *
 **/
$called_from_cron = true;
require_once(dirname(dirname(__FILE__)).'/common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/email_notify.inc.php';

$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_CronHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_videoRelatedCron.lib.php';
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
/**
 * ManageDeleted
 *
 * @package
 * @author selvaraj_35ag05
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: $
 * @access public
 **/

set_time_limit(0);
class ManageDeleted extends CronDeleteVideoHandler
	{




		public function deleteVideos()
			{
				$sql = 'SELECT video_id, video_category_id FROM '.$this->CFG['db']['tbl']['video'].' WHERE'.
						' video_status=\'Deleted\' OR ( video_encoded_status!=\'Yes\' AND'.
						' date_added<=DATE_SUB(NOW(),INTERVAL 48 HOUR))';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$this->VIDEO_CATEGORY_ID = $row['video_category_id'];
								$this->fields_arr['video_id'] = $row['video_id'];

								//echo $row['video_id'],'<br>';
								$this->removeVideoRelatedEntries($row['video_id'],'video_id');
							}
					}
			}
	}
//<<<<<-------------- Class ManageDeleted begins ---------------//
//-------------------- Code begins -------------->>>>>//
$ManageDeleted = new ManageDeleted();
$ManageDeleted->setDBObject($db);
$ManageDeleted->makeGlobalize($CFG,$LANG);
$ManageDeleted->deleteVideos();
//require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');
?>