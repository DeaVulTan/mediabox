<?php
/**
 *
 *
 * @version $Id$
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 */
set_time_limit(0);
ini_set('dispay_errors',1);
error_reporting(E_ALL);
$called_from_cron = true;
require_once(dirname(dirname(__FILE__)).'/common/configs/config.inc.php');
require_once(dirname(dirname(__FILE__)).'/common/configs/config_encoder_command.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/videoUpload.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoGifHandler.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ExternalVideoUrlHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoUpload.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['auth']['is_authenticate'] = false;
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');

class ExternalVideoDownloader extends VideoUploadLib
{
	public $videoDetail='';
	public $flv_url_path='';
	public $error_message='';
	public $external_video_details_arr=array();
	public function populateVideoDetailsForDownload()
	{
	    $sql = 'SELECT video_id,external_site_video_url,external_site_flv_path FROM '.$this->CFG['db']['tbl']['video'].' WHERE form_upload_type =\'externalsitevideourl\' AND video_encoded_status=\'No\' Limit 1';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array());
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		if($rs->PO_RecordCount())
		{
			$this->videoDetail = $rs->FetchRow();
		}
		else
		{
			echo "completed";
			exit;
		}
	}

	/**
	 * ExternalVideoDownloader::getVideoFlvUrl()
	 *
	 * @return
	 */
	public function getVideoFlvUrl()
	{

		$externalObj = new ExternalVideoUrlHandler();
		$videoUrlDetail = $externalObj->chkIsValidExternalSite($this->videoDetail['external_site_video_url'],'full', $this->CFG);
		switch($videoUrlDetail['external_site']){
			case 'google':
				if(!$this->videoDetail['external_site_flv_path'])
				{
					$this->external_video_details_arr = $externalObj->chkIsValidExternalSite($this->videoDetail['external_site_video_url'],'full', $this->CFG);
					$this->flv_url_path=$this->external_video_details_arr['external_video_flv_path'];
					$this->error_message=$this->external_video_details_arr['error_message'];
				}
				else
				{
					$this->flv_url_path=$this->videoDetail['external_site_flv_path'];
					$this->error_message='';
				}
				break;
			case 'myspace':
				if(!$this->videoDetail['external_site_flv_path'])
				{
					$this->external_video_details_arr = $externalObj->chkIsValidExternalSite($this->videoDetail['external_site_video_url'],'full', $this->CFG);
					$this->flv_url_path=$this->external_video_details_arr['external_video_flv_path'];
					$this->error_message=$this->external_video_details_arr['error_message'];
				}
				else
				{
					$this->flv_url_path=$this->videoDetail['external_site_flv_path'];
					$this->error_message='';
				}
				break;
			default :
				$this->external_video_details_arr = $externalObj->chkIsValidExternalSite($this->videoDetail['external_site_video_url'],'full', $this->CFG);
				$this->flv_url_path=$this->external_video_details_arr['external_video_flv_path'];
				$this->error_message=$this->external_video_details_arr['error_message'];
				break;


		} // switch

	}

	/**
	 * ExternalVideoDownloader::downloadVideo()
	 *
	 * @return
	 */
	public function downloadVideo()
	{
		$video_name = getVideoName($this->videoDetail['video_id']);
		$temp_dir = '../'.$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin']['videos']['temp_folder'].'/';
		$temp_file = $temp_dir.$video_name.'.flv';

		$page_source =fileGetContentsManual($this->flv_url_path);
		if($page_source)
		{
			$this->fileWrite($temp_file, $page_source);
		}
		else
		{
			echo 'no page content';
			$this->VIDEO_ID=$this->videoDetail['video_id'];
			$this->changeEncodedStatus('Yes');

		}

		if ($this->CFG['admin']['log_video_upload_error'])
		{
			if(method_exists($this, 'createErrorLogFile'))
				$this->createErrorLogFile('video');
			else
				echo "no method createErrorLogFile found";
		}

		$this->videoEncode($this->videoDetail['video_id']);
		$this->changeEncodedStatus('Yes');
		$this->updateVideoDetail($this->videoDetail['video_id']);
		$log_str="\r\n\n". ' External Video Encode Status completed';
		$this->writetoTempFile($log_str);


	}

	/**
	 * ExternalVideoDownloader::updateVideoDetail()
	 *
	 * @param mixed $video_id
	 * @return
	 */
	public function updateVideoDetail($video_id)
	{
		$update_filed='external_site_flv_path='.$this->dbObj->Param('external_site_flv_path');
		$update_filed.=', video_flv_url='.$this->dbObj->Param('video_flv_path');

		$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].' SET '.$update_filed.
			   ' WHERE video_id='.$this->dbObj->Param('video_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->flv_url_path,$this->external_video_details_arr['video_flv_path'],$video_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
	}
}
$externalVideo = new ExternalVideoDownloader();
$externalVideo->setDBObject($db);
$externalVideo->makeGlobalize($CFG, $LANG);
$externalVideo->setMediaPath('../');
$externalVideo->setFormField('video_encoded_status','Partial');
if(!$CFG['admin']['videos']['auto_download_external_video'])
{
	$externalVideo->populateVideoDetailsForDownload();
	$externalVideo->getVideoFlvUrl();
	$externalVideo->downloadVideo();
}


?>