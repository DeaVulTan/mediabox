<?php
/**
 *
 * ..
 *
 * PHP version 5.0
 *
 * @category	..
 * @package		..
 * @author 		selvaraj_47ag04
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2006-05-04
 * @filesource
 **/
//music encoder command details



/**
 * @var				boolean Use B Frames
 * @cfg_label 		Use B Frames
 * @cfg_key 		upload_video_use_b_frames
 */
//$CFG['admin']['upload_video_use_b_frames'] = true;
//$CFG['admin']['video']['lavfopts'] = true;
//$CFG['admin']['mencoder_command_flv'] = '{mencoder_path} {source_file} -o {output_file} -of lavf -ovc lavc -oac mp3lame -lavcopts vcodec=flv:vbitrate={vbrate}:autoaspect:mbd=2:mv0:trell:v4mv:cbp:last_pred=3:predia=2:dia=2:precmp=2:cmp=2:subcmp=2:preme=2:turbo:acodec=mp3:abitrate={abrate} {scale} -srate {srate} -af lavcresample={lavcresample}';

/**
 * @var				string mplayer convert command
 * @cfg_label 		Using Mplayer
 * @cfg_key			mplayer_convert_command
 */
$CFG['admin']['musics']['mplayer_convert_command'] = '{mplayer_path} {source_file} -ao pcm:file={output_file}';
/**
 * @var				string mplayer trim command
 * @cfg_label 		Using Mplayer trim
 * @cfg_key			mplayer_trim_command
 * @cfg_sec_name 	Trim File Generation
 * @cfg_section 	Trim File Generation
 */
$CFG['admin']['musics']['mplayer_trim_command'] = '{mplayer_path} -ss {start_pos} -endpos {end_pos} {source_file} -ao pcm:file={output_file}';
/**
 * @var				string mplayer dumpaudio command
 * @cfg_label 		Using Mplayer dumpaudio
 * @cfg_key			mplayer_dumpaudio_command
 */
$CFG['admin']['musics']['mplayer_dumpaudio_command'] = '{mplayer_path} -dumpaudio {source_file} -dumpfile {output_file}';
/**
 * @var				string lame trim command
 * @cfg_label 		Using Lame trim
 * @cfg_key			lame_trim_command
 */
$CFG['admin']['musics']['lame_command'] = '{lame_path} {source_file} -o {output_file}';
/**
 * @var				string flvrool2 command for recorded audio
 * @cfg_label 		Using flvrool2 for recorded audio
 * @cfg_key			flvtool2_command
 */
$CFG['admin']['musics']['flvtool2_command'] = '{flvtool2_path} -UP {source_file}';
/**
 * @var				string yamdi command for recorded audio
 * @cfg_label 		Using yamdi for recorded audio
 * @cfg_key			yamdi_command
 */
$CFG['admin']['musics']['yamdi_command'] = '{yamdi_path} -i {source_file} -o {output_file}';
?>