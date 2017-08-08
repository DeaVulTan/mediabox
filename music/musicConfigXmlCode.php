<?php
/**
 * This file is to get xml code
 *
 * This file is having get xml code
 *
 *
 * @category	rayzz
 * @package		Index
 * @author 		selvaraj_35ag05
 * @copyright 	Copyright (c) 2006 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
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
/**
 * XmlCode
 *
 * @package
 * @author selvaraj_35ag05
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: $
 * @access public
 **/
class XmlCode extends MusicHandler
	{
		/**
		 * XmlCode::populateMusicDetails()
		 *
		 * @return array
		 **/
		public function populateMusicDetails($status)
			{
				$populateMusicDetails_arr = array();
				$cond = $status?'music_status=\'Ok\'':'music_status!=\'Ok\'';
				$inc = 1;
				$mid_arr = explode(',', $this->fields_arr['mid']);

				$public_condition = ' AND (m.user_id = '.$this->CFG['user']['user_id'].' OR m.music_access_type = \'Public\''.
										$this->getAdditionalQuery('m.').')'.
											$this->getAdultQuery('m.', 'music');

				foreach($mid_arr as $music_id)
					{

						$sql = 'SELECT m.music_id, m.user_id, u.user_name, m.music_ext, '.
								'm.music_title, m.music_server_url, m.thumb_width, '.
								'm.thumb_height, m.total_views, m.music_tags, m.music_upload_type, '.
								'(m.rating_total/m.rating_count) as rating, m.playing_time, '.
								'm.music_thumb_ext, m.music_artist, ma.album_title, m.music_category_id, '.
								'm.rating_count, m.total_plays, mc.music_category_name, mr.artist_name '.
								'FROM '.$this->CFG['db']['tbl']['music'].' as m JOIN '.$this->CFG['db']['tbl']['users'].' as u '.
								' on m.user_id = u.user_id LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr'.
								' ON  music_artist IN (music_artist_id) JOIN '.$this->CFG['db']['tbl']['music_files_settings'].
								' ON music_file_id = thumb_name_id JOIN '.$this->CFG['db']['tbl']['music_album'].' as ma'.
								' ON ma.music_album_id =m.music_album_id JOIN '.$this->CFG['db']['tbl']['music_category'].' as mc'.
								' ON mc.music_category_id =m.music_category_id '.
								' WHERE '.$cond.' AND music_id='.$this->dbObj->Param('music_id').$public_condition;

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($music_id));
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.
								$this->dbObj->ErrorMsg(), E_USER_ERROR);

						if($row = $rs->FetchRow())
							{
								$populateMusicDetails_arr[$inc]['music_id'] = $music_id;
								$populateMusicDetails_arr[$inc]['music_server_url'] = $row['music_server_url'];
								$populateMusicDetails_arr[$inc]['music_creator_id'] = $row['user_id'];
								$populateMusicDetails_arr[$inc]['music_title'] = $row['music_title'];
								$populateMusicDetails_arr[$inc]['music_tags'] = $row['music_tags'];
								$populateMusicDetails_arr[$inc]['music_category_id'] = $row['music_category_id'];
								$populateMusicDetails_arr[$inc]['music_category_name'] = $row['music_category_name'];
								$populateMusicDetails_arr[$inc]['music_artist'] = $row['artist_name'];
								$populateMusicDetails_arr[$inc]['music_album'] = $row['album_title'];
								$populateMusicDetails_arr[$inc]['playing_time'] = $row['playing_time'];
								$populateMusicDetails_arr[$inc]['total_plays'] = $row['total_plays'];
								$populateMusicDetails_arr[$inc]['music_tags'] = $row['music_tags'];
								$populateMusicDetails_arr[$inc]['music_upload_type'] = $row['music_upload_type'];
								$populateMusicDetails_arr[$inc]['user_id'] = $row['user_id'];
								$populateMusicDetails_arr[$inc]['music_thumb_ext'] = $row['music_thumb_ext'];
								$inc++;
							}
					}
				return $populateMusicDetails_arr;
			}

		/**
		 * XmlCode::getXmlCode()
		 *
		 * @return void
		 */
		public function getXmlCode()
			{
				$fields = explode('_', $this->fields_arr['pg']);
				$this->fields_arr['pg'] = $fields[0];

				if(isset($fields[1]))
					$this->fields_arr['mid'] = $fields[1];

				$this->fields_arr['player_type'] = 'single';

				if(isset($fields[2]))
				{
					if($fields[2] == 'ip')
					 $this->fields_arr['player_type'] = 'indexplayer';
					else
					 $this->fields_arr['extsite'] = $fields[2];
				}

				if(!($this->fields_arr['pg'] and $this->fields_arr['mid']))
					{
						return;
					}

				$sharing_url = '';
				$configPlayListXmlcode_url = '';
				$end_list = $next_list = 0;
				//$this->selectMusicPlayerSettings();
				$thumbnail = '';
				switch($this->fields_arr['pg'])
					{
						case 'music':
							$musiclist_arr = array();
							$inc = 0;

							break;

						case 'musicactivate':
							/*$this->populateMusicDetails(false);*/
							/*$this->selectLogoSettings();
							$this->selectMusicAdSettings();*/
							break;
					}

				//$this->changeConfigBooleanValues();
				$toolTipEnabled = 'false';
				if($this->CFG['admin']['musics']['single_player']['TooltipEnabled'])
					{
						$toolTipEnabled = 'true';
					}
				$auto_play = 'false';
				if($this->CFG['admin']['musics']['single_player']['AutoPlay'])
				{
					$auto_play = 'true';
				}
				else if(isset($this->fields_arr['extsite']) and $this->CFG['admin']['musics']['playlist_player']['EmbedPlayerAutoPlay'])
						if ($this->fields_arr['extsite']=='extsite') {
							$auto_play = 'true';
						}


				//SKIN NAME GET BY TEMPLATE BASED IF FILE EXISTS
				if ($this->fields_arr['player_type'] == 'indexplayer')
					{
						if(is_file($this->CFG['site']['project_path'].
							$this->CFG['admin']['musics']['index_single_player']['skin_path'].$this->CFG['html']['template']['default'].'_skin_'.str_replace('screen_','',$this->CFG['html']['stylesheet']['screen']['default']).'.swf'))
							{
								$this->CFG['admin']['musics']['index_single_player']['skin_name'] = $this->CFG['html']['template']['default'].'_skin_'.str_replace('screen_','',$this->CFG['html']['stylesheet']['screen']['default']);
							}
					}
				else
					{
						if(is_file($this->CFG['site']['project_path'].
							$this->CFG['admin']['musics']['single_player']['skin_path'].$this->CFG['html']['template']['default'].'_skin_'.str_replace('screen_','',$this->CFG['html']['stylesheet']['screen']['default']).'.swf'))
							{
								$this->CFG['admin']['musics']['single_player']['skin_name'] = $this->CFG['html']['template']['default'].'_skin_'.str_replace('screen_','',$this->CFG['html']['stylesheet']['screen']['default']);
							}
					}

?>
<CONFIG>
	<SETTINGS>
		<PLAYER autoplay="<?php echo $auto_play; ?>" />
		<PLAYER toolTip="<?php echo $toolTipEnabled; ?>" />
	</SETTINGS>
	<SKINS>
		<?php if ($this->fields_arr['player_type'] == 'indexplayer')
					{ ?>
						<SKIN Name="<?php echo $this->CFG['admin']['musics']['index_single_player']['skin_name']; ?>" recorderPath="<?php echo $this->CFG['site']['url'].$this->CFG['admin']['musics']['index_single_player']['skin_path'].$this->CFG['admin']['musics']['index_single_player']['skin_name'].'.swf'; ?>"  enabled="true"/>
					<?php }
				else
					{ ?>
					 <SKIN Name="<?php echo $this->CFG['admin']['musics']['single_player']['skin_name']; ?>" recorderPath="<?php echo $this->CFG['site']['url'].$this->CFG['admin']['musics']['single_player']['skin_path'].$this->CFG['admin']['musics']['single_player']['skin_name'].'.swf'; ?>"  enabled="true"/>
			<?php	}
		?>
	</SKINS>
	<LOGO Name="logo" URL="<?php echo $this->CFG['admin']['musics']['single_player']['LogoUrl']; ?>" Target="_blank"/>
	<LYRICSTEXT Name = "LyricsText" Value="<?php echo $this->LANG['Lyrics']; ?>" />
	<BY Name="By" Value="<?php echo $this->LANG['MusicBy']; ?>"/>
	<BUYTEXT Name = "BuyText" Value="<?php echo $this->LANG['Buy']; ?>" />
    <ALBUM Name="onTheAlbum" Value="<?php echo $this->LANG['OnTheAlbum']; ?>"/>

    <DOWNLOAD Name="Download" Value="<?php echo $this->LANG['Download']; ?>"/>
	<PLAYS Name="Plays" Value="<?php echo $this->LANG['Plays']; ?>"/>
	<INTERFACE>

		<TEXT  Tooltip="Play" Label="<?php echo $this->LANG['PlayButtonToolTip']; ?>"/>
		<TEXT  Tooltip="Pause" Label="<?php echo $this->LANG['PauseButtonToolTip']; ?>"/>
		<TEXT  Tooltip="Repeat" Label="<?php echo $this->LANG['RepeatOnButtonToolTip']; ?>"/>
		<TEXT  Tooltip="RepeatOff" Label="<?php echo $this->LANG['RepeatOffButtonToolTip']; ?>"/>
		<TEXT  Tooltip="Mute" Label="<?php echo $this->LANG['MuteButtonToolTip']; ?>"/>
		<TEXT  Tooltip="UnMute" Label="<?php echo $this->LANG['UnMuteButtonToolTip']; ?>"/>
		<TEXT  Tooltip="Download" Label="<?php echo $this->LANG['DownloadButtonToolTip']; ?>"/>
		<TEXT  Tooltip="Current time" Label="<?php echo $this->LANG['CurrentTimeButtonToolTip']; ?>"/>
		<TEXT  Tooltip="SongArtist" Label="<?php echo $this->LANG['ArtistToolTip']; ?>"/>
		<TEXT  Tooltip="SongAlbum" Label="<?php echo $this->LANG['AlbumToolTip']; ?>"/>
		<TEXT  Tooltip="SongTitle"  Label="<?php echo $this->LANG['SongTitleToolTip']; ?>"/>
		<TEXT  Tooltip="SongLyrics"  Label="<?php echo $this->LANG['SongLyricsToolTip']; ?>"/>
		<TEXT  Tooltip="BuySong"  Label="<?php echo $this->LANG['BuySongToolTip']; ?>"/>
	</INTERFACE>
	<SECURITYISSUE>
		<PHP path="<?php echo $this->CFG['site']['music_url'];?>getMusicPath.php" />
	</SECURITYISSUE>
</CONFIG>
<?php
			}

	}
//<<<<<-------------- Class XmlCode begins ---------------//
//-------------------- Code begins -------------->>>>>//
$XmlCode = new XmlCode();
setHeaderStart($check_login=false);
$XmlCode->setDBObject($db);
$CFG['user']['user_id'] = isset($_SESSION['user']['user_id'])?$_SESSION['user']['user_id']:'0';
$XmlCode->makeGlobalize($CFG,$LANG);

$CFG['admin']['is_logged_in'] = isset($_SESSION['admin']['is_logged_in'])?$_SESSION['admin']['is_logged_in']:'0';

$XmlCode->setPageBlockNames(array('get_code_form'));
//default form fields and values...
$XmlCode->setFormField('mid', '');
$XmlCode->setFormField('pg', '');
$XmlCode->setFormField('gurl', '');
$XmlCode->setFormField('ref', '0');
$XmlCode->setFormField('next_url', '');
$XmlCode->setFormField('full', false);
$XmlCode->setPageBlockShow('get_code_form');
$XmlCode->sanitizeFormInputs($_GET);

$XmlCode->external_site = false;
if(isset($_GET['ext_site']))
	$XmlCode->external_site=true;
//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($XmlCode->isShowPageBlock('get_code_form'))
    {
		$XmlCode->getXmlCode();
	}
//<<<<<-------------------- Page block templates ends -------------------//
setHeaderEnd();
?>