<?php
/**
 * This file is to upload the videos
 *
 * This file is having VideoActivate class to upload the videos
 *
 *
 * @category	rayzz
 * @package		Cron
 *
 **/
$called_from_cron = true;
require_once(dirname(dirname(__FILE__)).'/common/configs/config.inc.php');
require_once(dirname(dirname(__FILE__)).'/common/configs/config_encoder_command.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/videoUpload.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoGifHandler.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoUpload.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['auth']['is_authenticate'] = false;
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;

require_once($CFG['site']['project_path'].'common/application_top.inc.php');

set_time_limit(0);
class VideoActivate extends VideoUploadLib
	{
		public function populateVideoDetailsForEncode()
			{
				$sql = 'SELECT video_id FROM '.$this->CFG['db']['tbl']['video'].' WHERE video_encoded_status=\'No\' AND video_status!=\'Deleted\' ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
						    {
						    	if ($this->CFG['admin']['log_video_upload_error'])
								{
									if(method_exists($this, 'createErrorLogFile'))
										$this->createErrorLogFile('video');
									else
										echo "no method createErrorLogFile found";
								}
								$this->videoEncode($row['video_id']);
							}
					}
			}
	}
//<<<<<-------------- Class VideoActivate begins ---------------//
//-------------------- Code begins -------------->>>>>//
$VideoActivate = new VideoActivate();
$VideoActivate->setDBObject($db);
$VideoActivate->makeGlobalize($CFG, $LANG);
$VideoActivate->setMediaPath('../');
//default form fields and values...
if(!$CFG['admin']['videos']['video_auto_encode'])
	{
		$VideoActivate->populateVideoDetailsForEncode();
	}
//require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');
?>