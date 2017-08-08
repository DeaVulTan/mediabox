<?php
/**
* This File is used for embedMusicPlayer
*
* @category	Rayzz
* @package		embedMusicPlayer
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
*/

$ref = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
$music_id=(isset($_GET['mid']))?$_GET['mid']:'';
$config=(isset($_GET['embedded_config']))?$_GET['embedded_config']:'';
if($config)
	$config='&embedded_config='.$config;
$player= $CFG['site']['url'].$CFG['admin']['musics']['single_player']['player_path'].$CFG['admin']['musics']['single_player']['swf_name'].'.swf';

//Have checked the Encrypted text is valid
$fields_arr = explode('_',$music_id);
$mid = $fields_arr[0];
$midenc = $fields_arr[1];
$enc = mvFileRayzz($mid);
if($enc!=$midenc)
	$err_valid_music='normal';
elseif($music_details_arr=validMusicId($mid))
	{
		$music_url='';
		$music_folder = $CFG['media']['folder'].'/'.$CFG['admin']['musics']['folder'].'/'.$CFG['admin']['musics']['music_folder'].'/';
		//$err_valid_music=false;
		$music_url = $music_details_arr['music_server_url'].$music_folder.getHotLinkProtectionString().getMusicImageName($music_details_arr['music_id']).'.mp3';
		if(!$music_url)
			{
				if(!$valid_music=fileGetContentsManual($music_url, true))//For checking is valid URL for normal videos
								$err_valid_music='normal';
			}

			if($music_details_arr['allow_embed']=='Yes' && $CFG['admin']['musics']['embedable'])
			Redirect2URL($player.'?ref='.$ref.$config);
			elseif(!$ref or strpos($ref,$CFG['site']['music_url'])!==false)
			Redirect2URL($player.'?ref='.$ref.$config);
			else
				{
					Redirect2URL($CFG['site']['url'].'files/flash/music/bg-musicblock.gif');
				}

	}
if(!$music_details_arr)
	Redirect2URL($CFG['site']['music_url'].'musicNotValidImageGenerate.php?get_image='.$err_valid_music);
if($err_valid_music)
		Redirect2URL($CFG['site']['music_url'].'musicNotValidImageGenerate.php?get_image='.$err_valid_music);

?>
<p>
EMBED NOT ALLOWED
<script language="javascript">
alert('EMBED NOT ALLOWED');
</script>
</p>
<?php


?>