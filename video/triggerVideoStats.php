<?php

/**
 * To get the advanced stats for the videos
 *
 * To get the advanced stats for the videos
 *
 * PHP version 5.0
 *
 * @category	Rayzz
 * @package		triggerVideoStats
 * @author		logamurugan41ag04
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: triggerVideoStats.php 2007-25-06 05:49:16Z logamurugan_41ag04 $
 * @since 		2007-28-06
 */
/**
 * This file is included for configuaration purpose
 */

require_once('../common/configs/config.inc.php');
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['db']['is_use_db'] = true;
$CFG['site']['is_module_page']='video';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['is_public_profile'] = false;
$CFG['auth']['is_authenticate'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');

class RateVideo	extends FormHandler
	{

		public function chkIsValidVideoID()
			{
				$sql = 'SELECT video_id FROM '.$this->CFG['db']['tbl']['video'].
						' WHERE video_id=\''.$this->fields_arr['video_id'].'\' AND video_status=\'Ok\' ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					return true;
				return false;
			}

		public function chkIsValidUID()
			{
				$sql = 'SELECT uid, video_id FROM '.$this->CFG['db']['tbl']['video_render'].
						' WHERE uid=\''.$this->fields_arr['uid'].'\' ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if($row = $rs->FetchRow())
					{
						return true;
					}
				return false;
			}

		public function updateCampaignRenderRefer($update)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_render'].' SET '.$update.
				' WHERE uid=\''.$this->fields_arr['uid'].'\' AND (referer_render=\'\' OR referer_render IS NULL)   ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
					if (!$rs)
						trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}
		public function updateCampaignRender($update)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_render'].' SET '.$update.
				' WHERE uid=\''.$this->fields_arr['uid'].'\' ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
					if (!$rs)
						trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}

		public function updateTotalViews()
			{
		 		$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].
		 				' SET total_linked = total_linked + 1 '.
		 				' WHERE video_id = '.$this->dbObj->Param('videoid');
		 		$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
			}
	}
$rateVideo = new RateVideo();
$rateVideo->setDBObject($db);
$rateVideo->makeGlobalize($CFG,$LANG);

$rateVideo->user_id=0;
$rateVideo->campaign_id=0;

$rateVideo->setFormField('video_id', '');
$rateVideo->setFormField('vid', '');
$rateVideo->setFormField('uid', '');
$rateVideo->setFormField('action', '');
$rateVideo->setFormField('clicked_area', '');
$rateVideo->setFormField('refer', '');

$site_used_trigger_my_video_page=false;

if($_POST)
	$_GET=$_POST;

	//-----------TEsting block---------
	//$_GET['vid']='16';
	//$_SERVER['HTTP_REFERER']='http://xucid.com/campaignPlayer.swf?ref=http://profile.myspace.com/index.cfm?fuseaction=user.viewprofile&friendid=190475252&MyToken=a3347022-24de-4f39-a90f-3a4437ed5066';
	//$_GET['uid']='1';
	//$_GET['TriggerId']='1';
	//$_GET['action']='embeded';
	//-----------TEsting block---------



if(isset($_GET['triggerid']) and $_GET['triggerid'])
		$_GET['uid']=$_GET['triggerid'];

if(isset($_GET['vid']))
	$_GET['video_id']=$_GET['vid'];

		//print_r($_GET);

if($rateVideo->isFormGETed($_GET, 'uid') and $rateVideo->isFormGETed($_GET, 'action'))
	{


		$rateVideo->sanitizeFormInputs($_GET);
		$rateVideo->setFormField('video_id', $rateVideo->getFormField('vid'));

		if($rateVideo->chkIsValidUID())
			{
				$refer = '';
				$referer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER'] : '';
				//$referer = 'http://xucid.com/campaignPlayer.swf?ref=http://profile.myspace.com/index.cfm?fuseaction=user.viewprofile&friendid=190475252&MyToken=a3347022-24de-4f39-a90f-3a4437ed5066';
				$referer=isset($_GET['ref'])?$_GET['ref']:'';
				//echo 'EEEEEEEEE'.$referer;
				/*if (trim($referer))
					$rateVideo->updateCampaignRender($update=' referer_render=\''.$referer.'\'');

				if($rateVideo->getFormField('action')=='embeded' and $referer)
					{
						$rateVideo->updateCampaignRender($update=' clicked_video=\'yes\' ');
						$rateVideo->updateTotalViews();
					}*/
			}
	}
