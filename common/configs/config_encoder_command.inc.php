<?php
/**
 * settings for $CFG['db']['hostname']
 *
 * ..
 *
 * PHP version 5.0
 *
 * @category	..
 * @package		..
 * @author 		selvaraj_47ag04
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2006-05-04
 * @filesource
 **/
//video encoder command details

###########################################################################################
#
#						#MENCODER - Video Conversion#
#note:http://wiki.quakeworld.nu/Mencoder_howto
#http://web.njit.edu/all_topics/Prog_Lang_Docs/html/mplayer/encoding.html
#
###########################################################################################

/**
 * @#var			boolean Mencoder Command
 * @#cfg_label 		Enable Encoding Pass <br>for Better Quality and Compression
 * @#cfg_key 		encoding_pass
 * @#cfg_sec_name 	Mencoder Command
 * @#cfg_section 	mencoder_command
 */
$CFG['admin']['mencoder_command_encoding_pass'] = false;
/**
 * @#var			string Mencoder Command
 * @#cfg_label 		Encoding Pass Level <br> 2 - Image Qulaity <br> or 3 - Both Image & Audio Quality
 * @#cfg_key 		pass_level
 */
$CFG['admin']['mencoder_command_pass_level'] = '2';
/**
 * @#var			textarea Mencoder Command
 * @#cfg_label 		FLV Command For 2 Passing
 * @#cfg_key 		mencoder_command_flv_pass3
 */
$CFG['admin']['mencoder_command_flv_pass3'] = '{mencoder_path} {source_file} -o {output_file} -of lavf -ovc lavc -oac mp3lame -lavcopts vcodec=flv:vbitrate={vbrate}:autoaspect:mbd=2:mv0:trell:v4mv:cbp:last_pred=3:predia=2:dia=2:precmp=2:cmp=2:subcmp=2:preme=2:turbo:acodec=mp3:abitrate={abrate} {scale} -srate {srate} -af lavcresample={lavcresample}';
#########################################################################################################
#
#										#FFMPEG - Video Conversion #
#	note:http://www.catswhocode.com/blog/19-ffmpeg-commands-for-all-needs
#
#
#########################################################################################################
/**
 * @#var				textarea ffmpeg Command
 * @#cfg_label 		FLV Command
 * @#cfg_key 		ffmpeg_command_flv
 * @#cfg_sec_name 	FFMPEG
 * @#cfg_section 	FFMPEG
 */
$CFG['admin']['ffmpeg_command_flv'] = '{ffmpeg_path} -i {source_file} {output_file}';
/**
 * #@var			textarea ffmpeg Command
 * @#cfg_label 		WMV Command
 * @#cfg_key 		ffmpeg_command_wmv
 */
$CFG['admin']['ffmpeg_command_wmv'] = '{ffmpeg_path} -i {source_file} -vcodec h263 -s 176x108 -b 300k -r 10 -padtop 18 -padbottom 18 -padcolor 000000 -acodec libamr_nb -ar 8000 -ab 12.2k -ac 1 -f 3gp -aspect 4:3 {output_file}';
/**
 * @#var			textarea ffmpeg Command
 * @#cfg_label 		3GP Command
 * @#cfg_key 		ffmpeg_command_3gp
 */
$CFG['admin']['ffmpeg_command_3gp'] = '{ffmpeg_path} -i {source_file} -vcodec h263 -s 176x108 -b 300k -r 10 -padtop 18 -padbottom 18 -padcolor 000000 -acodec libamr_nb -ar 8000 -ab 12.2k -ac 1 -f 3gp -aspect 4:3 {output_file}';
/**
 * @#var			textarea ffmpeg Command
 * @#cfg_label 		MP4 Command
 * @#cfg_key 		ffmpeg_command_mp4
 */
$CFG['admin']['ffmpeg_command_mp4'] = '{ffmpeg_path} -i {source_file} -acodec aac -ab 128kb -vcodec mpeg4 -b 1200kb -mbd 2 -flags +4mv+trell -aic 2 -cmp 2 -subcmp 2 -s 320x180 -title X {output_file}';

#########################################################################################################
#
#									# MENCODER - Thumbnail GENERATION #
#
#
#########################################################################################################
/**
 * @#var			textarea ffmpeg Command
 * @#cfg_label 		FFMPEG Thumnail Generation Command
 * @#cfg_key 		ffmpeg_thumbnail_command
 */
$CFG['admin']['ffmpeg_thumbnail_command']='{ffmpeg_path} -i {source_file} -r 0.05 -ss 2 -s {scale} -f image2 {output_file}/%08d.jpg';
### Video To frame command Taken From http://muzso.hu/2008/12/28/extracting-thumbnails-still-images-frames-from-a-video-with-ffmpeg
$CFG['admin']['video']['lavfopts'] = true;
?>