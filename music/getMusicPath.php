<?php
/**
 * This file is to validate the token passed from the flash for the song id
 * and return the mp3 url
 *
 *
 * @category	rayzz
 * @package		Music
 * @author 		mangalam_020at09
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2010-01-27
 *
 **/
require_once('../common/configs/config.inc.php');

$CFG['lang']['include_files'][] = 'languages/%s/music/musicConfiguration.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['auth']['is_authenticate'] = false;
$CFG['site']['is_module_page'] = 'music';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
$CFG['user']['user_id'] = 0;
if(isset($_SESSION['user']['user_id']))
	$CFG['user']['user_id'] = $_SESSION['user']['user_id'];
class ValidateMusicToken extends FormHandler
{
	public function validateToken()
	{
		$valid_token = md5($this->fields_arr['music_id'].'volume');
		if($this->fields_arr['token'] == $valid_token)
			$this->fields_arr['valid_token'] = true;
		else
			$this->fields_arr['valid_token'] = false;
	}

	public function getMusicPath()
	{
		if($this->fields_arr['valid_token'])
		{
			$music_id = $this->fields_arr['music_id'];
			$sql = 'SELECT m.music_id, m.user_id, u.user_name, m.music_ext, '.
					'm.music_server_url,m.trimmed_music_server_url, m.music_upload_type,m.music_price, '.
					'ma.album_title,ma.album_for_sale,ma.album_access_type, ma.album_price, '.
					' ma.music_album_id, m.music_url, m.for_sale '.
					'FROM '.$this->CFG['db']['tbl']['music'].' as m JOIN '.$this->CFG['db']['tbl']['users'].' as u '.
					' on m.user_id = u.user_id JOIN '.$this->CFG['db']['tbl']['music_album'].' as ma'.
					' ON ma.music_album_id =m.music_album_id AND music_status=\'Ok\''.
					' WHERE music_id='.$this->dbObj->Param('music_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);
			$row = $rs->FetchRow();
			$album_for_sale = 'No';
			$for_sale = 'No';
			if($row['album_for_sale']=='Yes'
				and $row['album_access_type']=='Private'
				and $row['album_price']>0)
			{
				$album_for_sale = $row['album_for_sale'];
			}
			else if($row['for_sale']=='Yes')
			{
				$for_sale = $row['for_sale'];
			}

			$music_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.
																			$this->CFG['admin']['musics']['music_folder'].'/';
			if($row['music_upload_type']=='Normal'){
			$music_url = $row['music_server_url'].$music_folder.getMusicName($music_id).'.mp3';
			$chkTrimedMusic = true;
			}else{
				if(!$row['music_url']){
					$music_url = $row['music_server_url'].$music_folder.getMusicName($music_id).'.mp3';
					$chkTrimedMusic = true;
				}
			}

			if(($chkTrimedMusic AND $this->CFG['user']['user_id']!=$row['user_id']) Or $this->external_site)
			{
				$music_server_url = $row['music_server_url'];
				$trimmed_music_server_url = $row['trimmed_music_server_url'];
				$host = $_SERVER["HTTP_HOST"];
				$pattern='/'.$host.'/';
				$localServerMatch = false;
				$oldServerUrl = $music_server_url;
				if(preg_match($pattern,$trimmed_music_server_url))
				{
					$localServerMatch = true;
				}
				$displayTrimmedMusic = false;
				if(($this->CFG['admin']['musics']['full_length_audio'] == 'members'
					AND !isloggedIn())
					OR (($for_sale=='Yes' AND !isUserPurchased($music_id))
					OR ($album_for_sale=='Yes'	AND !isUserPurchased($music_id)))){
					$displayTrimmedMusic =true;
				}
				else if(($this->CFG['admin']['musics']['full_length_audio'] == 'paid_members'
						AND !isPaidMember())
						OR (($for_sale=='Yes' AND !isUserPurchased($music_id))
						OR ($album_for_sale=='Yes'	AND !isUserPurchased($music_id)))){
					$displayTrimmedMusic =true;
				}
				if($displayTrimmedMusic OR $this->external_site)
				{
						$trim_music_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['trimed_music_folder'].'/';
						if($localServerMatch)
						{
							$trim_url=$this->CFG['site']['project_path'].$trim_music_folder.getTrimMusicName($row['music_id']).'.mp3';
							if(file_exists($trim_url))
							{
								$music_url = $trim_url;
								$music_url = str_replace($this->CFG['site']['project_path'],$oldServerUrl,$music_url);
							}
						}
						else
						{
							$trim_url=$row['trimmed_music_server_url'].$trim_music_folder.getTrimMusicName($music_id).'.mp3';
							if(getHeadersManual($trim_url))
							{
								$music_url = $trim_url;
							}
						}
				}
			}
			echo 'path='.$music_url.'' ;
		}
		else
			echo 'path=\' \'';

	}
}
$XmlCode = new ValidateMusicToken();
setHeaderStart();
$XmlCode->setDBObject($db);
$XmlCode->makeGlobalize($CFG,$LANG);
$XmlCode->setFormField('music_id', '');
$XmlCode->setFormField('token', '');
$XmlCode->external_site=false;
$XmlCode->sanitizeFormInputs($_REQUEST);
$XmlCode->validateToken();
$XmlCode->getMusicPath();
setHeaderEnd();
//require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');
?>