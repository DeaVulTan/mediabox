<?php
/**
* This File is used for embedPlaylistPlayer
*
* @category	Rayzz
* @package		embedMusicPlaylistUrl
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
*/
$ref = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
$playlist_id=(isset($_GET['playlist_id']))?$_GET['playlist_id']:'';
$config=(isset($_GET['embedded_config']))?$_GET['embedded_config']:'';
if($config)
	$config='&embedded_config='.$config;
$player= $CFG['site']['url'].$CFG['admin']['musics']['playlist_player']['player_path'].$CFG['admin']['musics']['playlist_player']['swf_name'].'.swf';
//Have checked the Encrypted text is valid
$fields_arr = explode('_',$playlist_id);
$pid = $fields_arr[0];
$pidenc = $fields_arr[1];
$enc = mvFileRayzz($pid);
if($enc!=$pidenc)
	$err_valid_music='normal';
elseif($playlist_arr=validPlayListId($pid))
	{

		if($playlist_arr['allow_embed']=='Yes' && $CFG['admin']['musics']['embedable'])
			Redirect2URL($player.'?ref='.$ref.$config);
		elseif(!$ref or strpos($ref,$CFG['site']['music_url'])!==false)
			Redirect2URL($player.'?ref='.$ref.$config);
		else
			{
				Redirect2URL($CFG['site']['url'].'files/flash/music/bg-musicblock.gif');
			}
	}
if($playlist_arr=='')
	Redirect2URL($CFG['site']['music_url'].'musicNotValidImageGenerate.php?get_image='.$err_valid_music);
if($err_valid_music)
	Redirect2URL($CFG['site']['music_url'].'musicNotValidImageGenerate.php?get_image='.$err_valid_music);
?>