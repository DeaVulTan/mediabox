<?php
/**
 * To get the advanced stats for the musics
 *
 * To get the advanced stats for the musics
 *
 *
 * @category	Rayzz
 * @package		index
 * @author		logamurugan41ag04
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 */

require_once('../common/configs/config.inc.php');
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['db']['is_use_db'] = true;
$CFG['site']['is_module_page']='music';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['is_public_profile'] = false;
$CFG['auth']['is_authenticate'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');

class MusicStats extends MusicHandler
	{

		/**
		 * MusicStats::chkIsValidMusicID()
		 *
		 * @return boolean
		 */
		public function chkIsValidMusicID()
			{
				$sql = 'SELECT music_id FROM '.$this->CFG['db']['tbl']['music'].
						' WHERE music_id=\''.$this->fields_arr['music_id'].'\' AND music_status=\'Ok\' ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					return true;
				return false;
			}

		/**
		 * MusicStats::updateTotalViews()
		 *
		 * @return void
		 */
		public function updateTotalViews()
			{
		 		$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].
		 				' SET total_plays = total_plays + 1, '.
		 				' total_views = total_views+1, last_view_date=NOW()'.
		 				' WHERE music_id = '.$this->dbObj->Param('music_id');

		 		$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
			}


		/**
		 * MusicStats::changeMusicViewed()
		 *
		 * @return void
		 */
		public function changeMusicViewed()
			{
				$sql = 	' SELECT music_viewed_id FROM '.$this->CFG['db']['tbl']['music_viewed'].
						' WHERE music_id='.$this->dbObj->Param('music_id').' AND'.
						' DATE_FORMAT(last_viewed, \'%Y-%m-%d\') = CURDATE()';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));

			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();//$rs->Free();
						$music_viewed_id = $row['music_viewed_id'];
						$sql =  ' UPDATE '.$this->CFG['db']['tbl']['music_viewed'].' SET'.
	 							' last_viewed=NOW() ,'.
	 							' total_views=total_views+1'.
								' WHERE music_viewed_id='.$this->dbObj->Param('music_viewed_id');

	 					$stmt = $this->dbObj->Prepare($sql);
	 					$rs = $this->dbObj->Execute($stmt, array($music_viewed_id));
 					    if (!$rs)
 						    trigger_error($this->dbObj->ErrorNo().' '.
							 	$this->dbObj->ErrorMsg(), E_USER_ERROR);

 					}
 				else
 					{
				 		$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_viewed'].' SET'.
								' music_id='.$this->dbObj->Param('music_id').','.
								' total_views=1 ,'.
			 					' last_viewed=NOW(), '.
	 							' date_added=NOW()';

	 					$stmt = $this->dbObj->Prepare($sql);
	 					$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
 					    if (!$rs)
					    	trigger_db_error($this->dbObj);
				 }
			}

		/**
		 * MusicStats::changeMusicListened()
		 *
		 * @return void
		 */
		public function changeMusicListened()
			{
				$sql = 	' SELECT music_listened_id FROM '.$this->CFG['db']['tbl']['music_listened'].
						' WHERE music_id='.$this->dbObj->Param('music_id').' AND user_id='.$this->dbObj->Param('user_id').' AND'.
						' DATE_FORMAT(last_listened, \'%Y-%m-%d\') = CURDATE()';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id'], $this->fields_arr['user_id']));

				$music_owner_id = $this->getMusicOwnerId($this->fields_arr['music_id']);

				if(!$music_owner_id)
					return false;

			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();//$rs->Free();
						$music_listened_id = $row['music_listened_id'];
						$sql =  ' UPDATE '.$this->CFG['db']['tbl']['music_listened'].' SET'.
	 							' last_listened=NOW() ,'.
	 							' total_plays=total_plays+1'.
								' WHERE music_listened_id='.$this->dbObj->Param('music_listened_id');

	 					$stmt = $this->dbObj->Prepare($sql);
	 					$rs = $this->dbObj->Execute($stmt, array($music_listened_id));
 					    if (!$rs)
 						    trigger_error($this->dbObj->ErrorNo().' '.
							 	$this->dbObj->ErrorMsg(), E_USER_ERROR);

 					}
 				else
 					{
				 		$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_listened'].' SET'.
			 					' user_id='.$this->dbObj->Param('user_id').','.
			 					' music_owner_id='.$this->dbObj->Param('user_id').','.
								' music_id='.$this->dbObj->Param('music_id').','.
								' total_plays=1,'.
			 					' last_listened=NOW(),'.
	 							' date_added=NOW() ';

	 					$stmt = $this->dbObj->Prepare($sql);
	 					$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id'], $music_owner_id, $this->fields_arr['music_id']));
 					    if (!$rs)
					    	trigger_db_error($this->dbObj);
				 }

			}

	}
$musicStats = new MusicStats();

//$musicStats->user_id=0;
//$musicStats->campaign_id=0;
//currentSongId
$musicStats->setFormField('music_id', '');
$musicStats->setFormField('mid', '');
$musicStats->setFormField('user_id', 0);
/*$musicStats->setFormField('uid', '');
$musicStats->setFormField('action', '');
$musicStats->setFormField('clicked_area', '');*/
$musicStats->setFormField('refer', '');

$site_used_trigger_my_music_page=false;

if($_POST)
	$_GET=$_POST;

	//-----------TEsting block---------
	//$_GET['vid']='16';
	//$_SERVER['HTTP_REFERER']='http://xucid.com/campaignPlayer.swf?ref=http://profile.myspace.com/index.cfm?fuseaction=user.viewprofile&friendid=190475252&MyToken=a3347022-24de-4f39-a90f-3a4437ed5066';
	//$_GET['uid']='1';
	//$_GET['TriggerId']='1';
	//$_GET['action']='embeded';
	//-----------TEsting block---------



/*if(isset($_GET['triggerid']) and $_GET['triggerid'])
	$_GET['uid'] = $_GET['triggerid'];*/

if(isset($_GET['currentSongId']))
	$_GET['music_id'] = $_GET['currentSongId'];


//print_r($_GET);

if($musicStats->isFormGETed($_GET, 'music_id'))
	{
		$musicStats->sanitizeFormInputs($_GET);

		if($musicStats->chkIsValidMusicID())
			{
				/*$refer = '';
				$referer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER'] : '';
				//$referer = 'http://xucid.com/campaignPlayer.swf?ref=http://profile.myspace.com/index.cfm?fuseaction=user.viewprofile&friendid=190475252&MyToken=a3347022-24de-4f39-a90f-3a4437ed5066';
				$referer=isset($_GET['ref'])?$_GET['ref']:'';
				//echo 'EEEEEEEEE'.$referer;
				if (trim($referer))
					$musicStats->updateCampaignRender($update=' referer_render=\''.$referer.'\'');*/

				$musicStats->updateTotalViews();
				$musicStats->changeMusicViewed();
				if(isset($_SESSION['user']['user_id']) and !empty($_SESSION['user']['user_id']))
					$musicStats->setFormField('user_id', $_SESSION['user']['user_id']);

				if($musicStats->getFormField('user_id') != 0)
					$musicStats->changeMusicListened();
			}
	}
