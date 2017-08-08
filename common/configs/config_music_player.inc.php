<?php
/**
 * settings for $CFG['admin']['musics']
 *
 * ..
 *
 * PHP version 5.0
 *
 * @category	..
 * @package		..
 * @author 		sridharan_08ag04
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @filesource
 **/
/**
  * @var				boolean play settings
 * @cfg_label 		Auto play for the player in the Listen Music page
 * @cfg_key 		AutoPlay
 * @cfg_sec_name 	Player Settings
 * @cfg_section 	Player Settings
 */
$CFG['admin']['musics']['single_player']['AutoPlay'] = false;
/**
 * @var				boolean play settings
 * @cfg_label 		Auto play  for the  Player with playlist
 * @cfg_key 		PlaylistPlayerAutoPlay
 */
$CFG['admin']['musics']['playlist_player']['PlaylistPlayerAutoPlay'] = true;
/**
 * @#var				boolean play settings
 * @#cfg_label 		Playlist Listing Play Settings
 * @#cfg_key 		PlaylistAutoPlay
 */
$CFG['admin']['musics']['playlist_player']['PlaylistAutoPlay'] = true;
/**
 * @var				boolean play settings
 * @cfg_label 		Auto play for the featured player in the Index page
 * @cfg_key 		FutureListPlayerAutoPlay
 */
$CFG['admin']['musics']['playlist_player']['FutureListPlayerAutoPlay'] = true;
/**
 * @#var				boolean play settings
 * @#cfg_label 		Index Playlist Play Settings
 * @#cfg_key 		FuturePlayListPlayerAutoPlay
 */
$CFG['admin']['musics']['playlist_player']['FuturePlayListPlayerAutoPlay'] = true;
/**
 * @var				boolean play settings
 * @cfg_label 		Auto play for the QuickMix player
 * @cfg_key 		QuickmixPlayerAutoPlay
 */
$CFG['admin']['musics']['playlist_player']['QuickmixPlayerAutoPlay'] = true;
/**
 * @#var				boolean play settings
 * @#cfg_label 		Quickmix Playlist Play Settings
 * @#cfg_key 		QuickmixPlaylistPlayerAutoPlay
 */
$CFG['admin']['musics']['playlist_player']['QuickmixPlaylistPlayerAutoPlay'] = true;
/**
 * @var				boolean play settings
 * @cfg_label 		Auto Play for the Embed Player
 * @cfg_key 		EmbedPlayerAutoPlay
 */
$CFG['admin']['musics']['playlist_player']['EmbedPlayerAutoPlay'] = false;
/**
 * @#var				boolean play settings
 * @#cfg_label 		Embed Playlist Play Settings
 * @#cfg_key 		EmbedPlaylistPlayerAutoPlay
 */
$CFG['admin']['musics']['playlist_player']['EmbedPlaylistPlayerAutoPlay'] = false;
$CFG['admin']['musics']['single_player']['Header'] = true;

$CFG['admin']['musics']['single_player']['TopUrlUrl'] = true;
$CFG['admin']['musics']['single_player']['TopUrlTargetUrl'] = '';
$CFG['admin']['musics']['single_player']['TopUrl'] = false;
$CFG['admin']['musics']['single_player']['TopUrlType'] = 'img';
$CFG['admin']['musics']['single_player']['TopUrlDuration'] = 0;

$CFG['admin']['musics']['single_player']['TailUrlUrl'] = '';
$CFG['admin']['musics']['single_player']['TailUrlTargetUrl'] = '';
$CFG['admin']['musics']['single_player']['TailUrl'] = false;
$CFG['admin']['musics']['single_player']['TailUrlType'] = 'img';
$CFG['admin']['musics']['single_player']['TailUrlDuration'] = 0;

//$CFG['admin']['musics']['single_player']['Logo'] = false;
$CFG['admin']['musics']['single_player']['LogoUrl'] = '';
/*$CFG['admin']['musics']['single_player']['LogoTargetUrl'] = '';
$CFG['admin']['musics']['single_player']['LogoTransparency'] = 0;
$CFG['admin']['musics']['single_player']['LogoRollOverTransparency'] = 0;
$CFG['admin']['musics']['single_player']['LogoPosition'] = 0;*/

$CFG['admin']['musics']['single_player']['SelectedLoader'] = 'loading.swf';
$CFG['admin']['musics']['single_player']['Volume'] = 'low';
$CFG['admin']['musics']['single_player']['TooltipEnabled'] = true;
$CFG['admin']['musics']['single_player']['LockAllControls'] = 'false';
$CFG['admin']['musics']['single_player']['InitVolume'] = 20;

$CFG['admin']['musics']['single_player']['ShowShareButton'] = true;
$CFG['admin']['musics']['single_player']['ShowMiniShareButton'] = true;
$CFG['admin']['musics']['single_player']['ShowShareButton'] = true;
$CFG['admin']['musics']['single_player']['ShowReplyButton'] = true;
$CFG['admin']['musics']['single_player']['ShowMiniLogo'] = false;
$CFG['admin']['musics']['single_player']['ShowDownloadButton'] = true;

//PLAYER WITH PLAYLIST
$CFG['admin']['musics']['playlist_player']['Header'] = true;

$CFG['admin']['musics']['playlist_player']['TopUrlUrl'] = true;
$CFG['admin']['musics']['playlist_player']['TopUrlTargetUrl'] = '';
$CFG['admin']['musics']['playlist_player']['TopUrl'] = false;
$CFG['admin']['musics']['playlist_player']['TopUrlType'] = 'img';
$CFG['admin']['musics']['playlist_player']['TopUrlDuration'] = 0;

$CFG['admin']['musics']['playlist_player']['TailUrlUrl'] = '';
$CFG['admin']['musics']['playlist_player']['TailUrlTargetUrl'] = '';
$CFG['admin']['musics']['playlist_player']['TailUrl'] = false;
$CFG['admin']['musics']['playlist_player']['TailUrlType'] = 'img';
$CFG['admin']['musics']['playlist_player']['TailUrlDuration'] = 0;

$CFG['admin']['musics']['playlist_player']['Logo'] = false;
$CFG['admin']['musics']['playlist_player']['LogoUrl'] = 'https://www.mediabox.uz/';
//$CFG['admin']['musics']['playlist_player']['LogoTargetUrl'] = '';
//$CFG['admin']['musics']['playlist_player']['LogoTransparency'] = 0;
//$CFG['admin']['musics']['playlist_player']['LogoRollOverTransparency'] = 0;
//$CFG['admin']['musics']['playlist_player']['LogoPosition'] = 0;

$CFG['admin']['musics']['playlist_player']['SelectedLoader'] = 'loading.swf';
$CFG['admin']['musics']['playlist_player']['Volume'] = 'low';
$CFG['admin']['musics']['playlist_player']['TooltipEnabled'] = true;
$CFG['admin']['musics']['playlist_player']['JavascriptEnabled'] = false;
$CFG['admin']['musics']['playlist_player']['PlayerReadyEnabled'] = false;
$CFG['admin']['musics']['playlist_player']['LockAllControls'] = 'false';
$CFG['admin']['musics']['playlist_player']['InitVolume'] = 20;

$CFG['admin']['musics']['playlist_player']['ShowShareButton'] = true;
$CFG['admin']['musics']['playlist_player']['ShowMiniShareButton'] = true;
$CFG['admin']['musics']['playlist_player']['ShowShareButton'] = true;
$CFG['admin']['musics']['playlist_player']['ShowReplyButton'] = true;
$CFG['admin']['musics']['playlist_player']['ShowMiniLogo'] = false;
$CFG['admin']['musics']['playlist_player']['ShowDownloadButton'] = true;

//PLAYER WITHOUT PLAYLIST CONFIG
$CFG['admin']['musics']['single_player']['swf_name'] = 'player';
$CFG['admin']['musics']['single_player']['config_name'] = 'music/musicConfigXmlCode';
$CFG['admin']['musics']['single_player']['playlist_name'] = 'music/musicPlaylistXmlCode';
$CFG['admin']['musics']['single_player']['ad_name'] = 'musicAdXmlCode';
$CFG['admin']['musics']['single_player']['xml_theme'] = 'outlook_skin_outlook.xml';
$CFG['admin']['musics']['single_player']['player_path'] = 'files/flash/music/MP3_player/player_without_playlist/';
$CFG['admin']['musics']['single_player']['theme_path'] = 'files/flash/music/MP3_player/player_without_playlist/xml/';
$CFG['admin']['musics']['single_player']['skin_path'] = 'files/flash/music/MP3_player/player_without_playlist/skins/';
$CFG['admin']['musics']['single_player']['skin_name'] = 'outlook_skin_outlook';
$CFG['admin']['musics']['single_player']['width'] = 597;
$CFG['admin']['musics']['single_player']['height'] = 173;

//PLAYER WITH PLAYLIST CONFIG
$CFG['admin']['musics']['playlist_player']['swf_name'] = 'player';
$CFG['admin']['musics']['playlist_player']['config_name'] = 'music/musicWithPlaylistConfigXmlCode';
$CFG['admin']['musics']['playlist_player']['playlist_name'] = 'music/musicWithPlaylistPlaylistXmlCode';
$CFG['admin']['musics']['playlist_player']['ad_name'] = 'musicWithPlaylistAdXmlCode';
$CFG['admin']['musics']['playlist_player']['xml_theme'] = 'outlook_skin_outlook.xml';
$CFG['admin']['musics']['playlist_player']['player_path'] = 'files/flash/music/MP3_player/player_with_playlist/source/';
$CFG['admin']['musics']['playlist_player']['theme_path'] = 'files/flash/music/MP3_player/player_with_playlist/source/xml/';
$CFG['admin']['musics']['playlist_player']['skin_path'] = 'files/flash/music/MP3_player/player_with_playlist/source/skins/';
$CFG['admin']['musics']['playlist_player']['skin_name'] = 'outlook_skin_outlook';
$CFG['admin']['musics']['playlist_player']['width'] = 598;
$CFG['admin']['musics']['playlist_player']['height'] = 174;

//Music Recorder Path - no need to display in user side
$CFG['admin']['audio_recorder']['skin_path']='files/flash/music/AudioRecorder/skins/';

//PLAYER WITHOUT PLAYLIST CONFIG
$CFG['admin']['musics']['index_single_player']['swf_name'] = 'player';
$CFG['admin']['musics']['index_single_player']['config_name'] = 'music/musicConfigXmlCode';
$CFG['admin']['musics']['index_single_player']['playlist_name'] = 'music/musicPlaylistXmlCode';
$CFG['admin']['musics']['index_single_player']['ad_name'] = 'musicAdXmlCode';
$CFG['admin']['musics']['index_single_player']['xml_theme'] = 'outlook_skin_outlook.xml';
$CFG['admin']['musics']['index_single_player']['player_path'] = 'files/flash/music/MP3_player/player_index/source/';
$CFG['admin']['musics']['index_single_player']['theme_path'] = 'files/flash/music/MP3_player/player_index/source/xml/';
$CFG['admin']['musics']['index_single_player']['skin_path'] = 'files/flash/music/MP3_player/player_index/source/skins/';
$CFG['admin']['musics']['index_single_player']['skin_name'] = 'outlook_skin_outlook';
$CFG['admin']['musics']['index_single_player']['width'] = 299;
$CFG['admin']['musics']['index_single_player']['height'] = 246;
?>