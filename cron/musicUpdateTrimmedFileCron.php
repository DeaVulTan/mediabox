<?php
/**
 * This file is to generate the trimmed music files for the records which has the
 * field has_trimmed_music as No and when the full length music play option is restricted
 * and generate trimmed music and play if it does not exist option is turned on.
 * Note: For versions till 1.1.5, the musicUpgradeTrimmedFieldCron.php must be run
 * before this.
 *
 *
 * @category	Rayzz
 * @copyright 	Copyright (c)2009-2010 {@link http://www.mediabox.uz Uzdc Infoway}
 */
set_time_limit(0);
$called_from_cron = true;
ini_set("display_errors",1);
error_reporting(E_ALL);
require_once(dirname(dirname(__FILE__)).'/common/configs/config.inc.php');
require_once(dirname(dirname(__FILE__)).'/common/configs/config_music.inc.php');
require_once(dirname(dirname(__FILE__)).'/common/configs/config_myhome.inc.php');
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['lang']['include_files'][] = 'common/music_common_functions.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/help.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_RayzzHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicUpload.lib.php';
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['auth']['is_authenticate'] = false;
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require($CFG['site']['project_path'].'common/application_top.inc.php');
class GenerateTrimmedFile extends MusicUploadLib
{

	/**
	 * GenerateTrimmedFile::getMusicDetails()
	 * selects the songs that doesn't have trimmed music and calls the function
	 * to trim that music and update it
	 *
	 * @return void
	 */
	public function getMusicTrimDetails()
	{
		$sql = 'SELECT trim_music_cron_id,upto_music_id, preview_start, preview_length FROM '.
				$this->CFG['db']['tbl']['trim_music_cron'].
				' WHERE status=\'Inactive\' OR status=\'Started\' ORDER BY trim_music_cron_id DESC LIMIT 0, 1';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array());
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
			$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($row = $rs->FetchRow())
		{
		   $sql = 'SELECT music_id, music_server_url FROM '. $this->CFG['db']['tbl']['music'].
				   ' WHERE music_status=\'Ok\' AND music_id > '.$row['upto_music_id'].' AND (preview_start!='.$row['preview_start'].' OR preview_end!='.$row['preview_length'].') LIMIT 0, 50 ' ;
			$stmt1 = $this->dbObj->Prepare($sql);
			$rs1 = $this->dbObj->Execute($stmt1);
			if (!$rs1)
			   trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			if(!$rs1->PO_RecordCount())
				$this->updateCronStatus('Completed', $row['trim_music_cron_id']);
			while($row1 = $rs1->FetchRow())
			{
				$this->updateCronStatus('Started', $row['trim_music_cron_id']);
				if(!checkMusicForSale($row1['music_id']))
				{
					$this->trimMusic($row1['music_id'], $row['preview_start'], $row['preview_length']);
					$this->updatePreviewTime($row1['music_id'],$row['preview_start'], $row['preview_length']);
					$this->updateUpToMusicId($row1['music_id']);
				}

			} // while

		}

	}

	public function updateCronStatus($status, $cron_id)
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['trim_music_cron'].
				' SET status='.$this->dbObj->Param('status').
				' WHERE trim_music_cron_id='.$this->dbObj->Param('cron_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($status, $cron_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
			$this->dbObj->ErrorMsg(), E_USER_ERROR);
	}

	public function updateUpToMusicId($music_id)
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['trim_music_cron'].
				' SET '.
				'upto_music_id='.$this->dbObj->Param('music_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($music_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
			$this->dbObj->ErrorMsg(), E_USER_ERROR);
	}

	public function updatePreviewTime($music_id, $preview_start, $preview_end)
	{
		$sql = 'UPDATE '.  $this->CFG['db']['tbl']['music'].' SET '.
				' preview_start = '.$this->dbObj->Param('preview_start').','.
				' preview_end = '.$this->dbObj->Param('preview_end').
				' WHERE music_id = '.$this->dbObj->Param('music_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($preview_start, $preview_end, $music_id));
		if (!$rs)
		   trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
	}

}

$updateTrimmedFile= new GenerateTrimmedFile();
$updateTrimmedFile->setMediaPath('../');
//todo : add condn to check if this processing has to be done
$updateTrimmedFile->getMusicTrimDetails();
?>