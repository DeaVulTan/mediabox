<?php
/**
 * This file is to get xml code
 *
 * This file is having get xml code
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Index
 * @author 		selvaraj_35ag05
 * @copyright 	Copyright (c) 2006 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2006-05-02
 *
 **/
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/musicConfiguration.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
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
class XmlCode extends MediaHandler
	{

		/**
		 * XmlCode::populateMusicDetails()
		 *
		 * @return
		 **/
		public function populateMusicDetails($status)
			{
				$populateMusicDetails_arr = array();
				$cond = $status?'music_status=\'Ok\'':'music_status!=\'Ok\'';
				$inc = 0;
				$mid_arr = explode(',', $this->fields_arr['mid']);
				foreach($mid_arr as $music_id)
					{
						$sql = 'SELECT music_server_url, user_id, music_title, music_upload_type, '.
								' music_tags, music_category_id, music_tags, music_thumb_ext, '.
								' playing_time, user_id FROM '.$this->CFG['db']['tbl']['music'].
								' WHERE '.$cond.' AND music_id='.$this->dbObj->Param('music_id');

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
								$populateMusicDetails_arr[$inc]['playing_time'] = $row['playing_time'];
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
		 * @return
		 **/
		public function getXmlCode()
			{
				$fields = explode('_', $this->fields_arr['pg']);
				$this->fields_arr['pg'] = $fields[0];
				if(isset($fields[1]))
					$this->fields_arr['playlist_id'] = $fields[1];

				if(isset($fields[2]))
					$this->fields_arr['mid'] = $fields[2];

				if(isset($fields[3]))
					$this->fields_arr['ref'] = $fields[3];

				if(isset($fields[4]))
					$this->fields_arr['extsite'] = $fields[4];


				//if(!($this->fields_arr['pg'] and $this->fields_arr['mid']))
				if(!($this->fields_arr['pg']) and (!$this->fields_arr['playlist_id'] or !$this->fields_arr['mid']))
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

				}

				//$this->changeConfigBooleanValues();
				$toolTipEnabled = 'false';
				if($this->CFG['admin']['musics']['playlist_player']['TooltipEnabled'])
				{
					$toolTipEnabled = 'true';
				}
				$auto_play = 'false';
				if($this->CFG['admin']['musics']['playlist_player']['PlaylistAutoPlay'])
				{
					$auto_play = 'true';
				}
				elseif(isset($this->fields_arr['extsite'])
						and $this->fields_arr['extsite']=='extsite'
						and $this->CFG['admin']['musics']['playlist_player']['EmbedPlayerAutoPlay'])
					$auto_play = 'true';

				$playlist_auto_play = 'false';
				if($this->CFG['admin']['musics']['playlist_player']['PlaylistAutoPlay'])
				{
					$playlist_auto_play = 'true';
				}

				$javascript_enabled = 'false';
				if($this->CFG['admin']['musics']['playlist_player']['JavascriptEnabled'])
				{
					$javascript_enabled = 'true';
				}

				$player_ready_enabled = 'false';
				if($this->CFG['admin']['musics']['playlist_player']['PlayerReadyEnabled'])
				{
					$player_ready_enabled = 'true';
				}

				if(is_file($this->CFG['site']['project_path'].$this->CFG['admin']['musics']['playlist_player']['skin_path'].
				$this->CFG['html']['template']['default'].'_skin_'.str_replace('screen_','',$this->CFG['html']['stylesheet']['screen']['default']).'.swf'))
				{
					$this->CFG['admin']['musics']['playlist_player']['skin_name'] = $this->CFG['html']['template']['default'].'_skin_'.str_replace('screen_','',$this->CFG['html']['stylesheet']['screen']['default']);
				}
				//CHEKCED THE AUDIOS ALLOWED FOR SALE
				$music_for_sale = 'false';
				if($this->CFG['admin']['musics']['allowed_usertypes_to_upload_for_sale']!='None')
					$music_for_sale = 'true';

?>
<CONFIG>
	<SETTINGS>
		<PLAYER autoplay="<?php echo $auto_play; ?>" />
		<PLAYER playListAutoplay="<?php echo $playlist_auto_play; ?>" />
		<PLAYER javascriptEnabled="<?php echo $javascript_enabled; ?>" />
		<PLAYER callJSWhenPlayerReady="<?php echo $player_ready_enabled; ?>" />
		<PLAYER toolTip="<?php echo $toolTipEnabled; ?>" />
		<PLAYER musicForSale="<?php echo $music_for_sale; ?>" />
		<PLAYER inactiveInfoIconPath="<?php echo $this->CFG['site']['music_url'].'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/info.jpg'; ?>" />
		<PLAYER activeInfoIconPath="<?php echo $this->CFG['site']['music_url'].'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/infoactive.jpg'; ?>" />
		<PLAYER soundImagePath="<?php echo $this->CFG['site']['music_url'].'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/waves.png'; ?>" />
		<PLAYER AutoScrollforTitle="true" />
	</SETTINGS>
	<SKINS>
		<SKIN Name="<?php echo $this->CFG['admin']['musics']['playlist_player']['skin_name']; ?>" recorderPath="<?php echo $this->CFG['site']['url'].$this->CFG['admin']['musics']['playlist_player']['skin_path'].$this->CFG['admin']['musics']['playlist_player']['skin_name'].'.swf'; ?>"  enabled="true"/>
	</SKINS>
<?php
	if($this->CFG['admin']['musics']['playlist_player']['Logo'])
		{ ?>
	<LOGO Name="logo" URL="<?php echo $this->CFG['admin']['musics']['playlist_player']['LogoUrl']; ?>" Target="_blank"/>
		<?php
		}
		?>

	<CURRENCY Name = "dollar" Symbol="<?php echo $this->CFG['currency'];?>" />
	<BUYTEXT Name = "BuyText" Value="<?php echo $this->LANG['Buy']; ?>" />
	<LYRICSTEXT Name = "LyricsText" Value="<?php echo $this->LANG['Lyrics']; ?>" />
	<BY Name="By" Value="<?php echo $this->LANG['MusicBy']; ?>"/>
    <ALBUM Name="onTheAlbum" Value="<?php echo $this->LANG['OnTheAlbum']; ?>"/>
    <DOWNLOAD Name="Download" Value="<?php echo $this->LANG['Download']; ?>"/>
	<PLAYS Name="Plays" Value="<?php echo $this->LANG['Plays']; ?>"/>

	<SONGNUMBER Name="Number" Value="<?php echo $this->LANG['Number']; ?>"/>
	<SONGTITLE Name="Title" Value="<?php echo $this->LANG['Title']; ?>"/>
	<SONGARTIST Name="Price" Value="<?php echo $this->LANG['Price']; ?>"/>
	<SONGALBUM Name="Buy" Value="<?php echo $this->LANG['Buy']; ?>"/>
	<SONGLENGTH Name="Info" Value="<?php echo $this->LANG['Info']; ?>"/>

	<INTERFACE>
		<TEXT  Tooltip="Next" Label="<?php echo $this->LANG['NextTextToolTip']; ?>"/>
		<TEXT  Tooltip="Previous" Label="<?php echo $this->LANG['PreviousTextToolTip']; ?>"/>
		<TEXT  Tooltip="Play" Label="<?php echo $this->LANG['PlayButtonToolTip']; ?>"/>
		<TEXT  Tooltip="Pause" Label="<?php echo $this->LANG['PauseButtonToolTip']; ?>"/>
		<TEXT  Tooltip="Repeat" Label="<?php echo $this->LANG['RepeatOnButtonToolTip']; ?>"/>
		<TEXT  Tooltip="RepeatOff" Label="<?php echo $this->LANG['RepeatOffButtonToolTip']; ?>"/>
		<TEXT  Tooltip="Shuffle" Label="<?php echo $this->LANG['ShuffleOnButtonToolTip']; ?>"/>
		<TEXT  Tooltip="ShuffleOff" Label="<?php echo $this->LANG['ShuffleOffButtonToolTip']; ?>"/>
		<TEXT  Tooltip="Mute" Label="<?php echo $this->LANG['MuteButtonToolTip']; ?>"/>
		<TEXT  Tooltip="UnMute" Label="<?php echo $this->LANG['UnMuteButtonToolTip']; ?>"/>
        <TEXT  Tooltip="Checktrack" Label="<?php echo $this->LANG['ToggleCheckButtonToolTip']; ?>"/>
        <TEXT  Tooltip="Download" Label="<?php echo $this->LANG['DownloadButtonToolTip']; ?>"/>
		<TEXT  Tooltip="Current time" Label="<?php echo $this->LANG['CurrentTimeButtonToolTip']; ?>"/>
		<TEXT  Tooltip="SongArtist" Label="<?php echo $this->LANG['ArtistToolTip']; ?>"/>
		<TEXT  Tooltip="SongAlbum" Label="<?php echo $this->LANG['AlbumToolTip']; ?>"/>
		<TEXT  Tooltip="SongTitle"  Label="<?php echo $this->LANG['SongTitleToolTip']; ?>"/>
		<TEXT  Tooltip="SongLyrics"  Label="<?php echo $this->LANG['SongLyricsToolTip']; ?>"/>
		<TEXT  Tooltip="BuySong"  Label="<?php echo $this->LANG['BuySongToolTip']; ?>"/>
		<TEXT  Tooltip="SongInfo"  Label="<?php echo $this->LANG['SongInfoToolTip']; ?>"/>
		<TEXT  Tooltip="Close"  Label="<?php echo $this->LANG['CloseToolTip']; ?>"/>
		<TEXT  Tooltip="AlbumCost"  Label="<?php echo $this->LANG['AlbumCost']; ?>"/>
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
$XmlCode->setFormField('playlist_id', '');
$XmlCode->setFormField('mid', ''); //Comma separated
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
//require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');
?>