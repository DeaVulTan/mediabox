<?php

/**
 *
 *
 * @version $Id$
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 */

/**
 * replaceCommandValue()
 *
 * @param mixed $command
 * @return
 */
function replaceCommandValue($command,$source_filename,$videoPath,$isFFMPEG=false){
global $CFG;


		if(!$CFG['admin']['video']['ffmpeg_encode'] AND !$isFFMPEG)
		{

			if($CFG['admin']['videos']['allow_watermark_in_video'])
			{
				$path = $CFG['site']['project_path'].$CFG['admin']['videos']['watermark_path'];
				$path1 = $CFG['site']['project_path'].$CFG['admin']['videos']['watermark_font_path'];
				$waterMarkCommand=" -sub $path -subpos 98 -font $path1";
			}


			#CHECKING WHETHER THE VIDEO RESIZE IS NEEDED AND CHECKING THE VIDEO SIZE OF UPLOAD VIDEO
			## IF UPLOAD VIDEO SIZE IS GREATER THAN  $CFG['admin']['video']['vfscale'] THEN WE ARE RESCALING
			## ELSE WE ARE NOT RESCALING DUE TO MAINTAIN THE QULAITY OF THE VIDEO
			//if($CFG['admin']['videos']['maintain_quality_video'])

			# removed maintain_quality_video to Apply this logic for all the video
				/*$dimension_arr=getVideoDimension($source_filename);
				$vfScale=explode(':',$CFG['admin']['video']['vfscale']);
				$actualWidth=$vfScale[0];
				if($dimension_arr['width']<=$actualWidth)
				{
					$scale = '';
				}
				else
				{
					$scale = '-vf scale='.$CFG['admin']['video']['vfscale'];
				}*/
			if($CFG['admin']['video']['vfscale'] == '')
			{
				$scale = '';
			}
			else
			{
				$scale = '-vf scale='.$CFG['admin']['video']['vfscale'];
			}

			if($CFG['admin']['mencoder_command_encoding_pass'])
			{
				$vpass='vpass=1:';
			}
			else
			{
			$vpass='';
			}

		}
		else{
			$vpass='';
			$scale='';
		}
		$oac_command_true = '-oac mp3lame';
		$oac_command_false = '-oac lavc';

		if($CFG['admin']['video']['oac_lame'])
			$oac_commad = $oac_command_true;
		else
			$oac_commad = $oac_command_false;

		$search_array	= array('{mencoder_path}',
							'{ffmpeg_path}',
							'{source_file}',
							'{output_file}',
							'{oac}',
							'{vpass}',
							'{vbrate}',
							'{abrate}',
							'{scale}',
							'{srate}',
							'{lavcresample}'
							);

		$replace_array	= array("\"".$CFG['admin']['video']['mencoder_path']."\"",
							"\"".$CFG['admin']['audio']['ffmpeg_path']."\"",
							$source_filename,
							$videoPath,
							$oac_commad,
							$vpass,
							$CFG['admin']['video']['vbitrate'],
							$CFG['admin']['video']['abitrate'],
							$scale,
							$CFG['admin']['video']['srate'],
							$CFG['admin']['video']['lavcresample']
						    );

		$command = str_replace($search_array,$replace_array,$command);

		if($CFG['admin']['videos']['allow_watermark_in_video'] AND !$isFFMPEG)
			$command.=$waterMarkCommand;


		if(!$CFG['admin']['video']['ffmpeg_encode'] AND !$isFFMPEG)
		{
			if($CFG['admin']['upload_video_use_b_frames'])
			{
				$command.=' -lavfopts i_certify_that_my_video_stream_does_not_use_b_frames';
			}
		}


		return $command;

}

/**
 * getNormalMencoderCommand()
 *
 * @return
 */
function getNormalMencoderCommand($source_filename,$videoPath){
global $CFG;

	$command = $CFG['admin']['mencoder_command_flv'];
	$command=replaceCommandValue($command,$source_filename,$videoPath);
	return $command;
}

/**
 * getMultiPassMencoderCommand()
 *
 * @param integer $level
 * @return
 */
function getMultiPassMencoderCommand($level=1,$source_filename,$videoPath){
global $CFG;

	if($level==3)
	{
		$command=$CFG['admin']['mencoder_command_flv_pass3'];
	}
	else
	{
		$command = $CFG['admin']['mencoder_command_flv'];
	}

	$command=replaceCommandValue($command,$source_filename,$videoPath);
	if($level==2)
	{
		$command = str_replace('vpass=1','vpass=2',$command);
	}
	return $command;
}

/**
 * getOtherFormatsMencoderCommand()
 *
 * @param mixed $video_extension
 * @return
 */
function getOtherFormatsMencoderCommand($video_extension,$source_filename,$videoPath){
global $CFG;

	if(isset($CFG['admin']['mencoder_command_'.$video_extension]))
		$command=$CFG['admin']['mencoder_command_'.$video_extension];
	else
		$command=$CFG['admin']['mencoder_command_otherformat'];

	$command=replaceCommandValue($command,$source_filename,$videoPath);
	return $command;
}

/**
 * getOtherFormatsFfmpegCommand()
 *
 * @param mixed $video_extension
 * @return
 */
function getOtherFormatsFfmpegCommand($video_extension,$source_filename,$videoPath){
global $CFG;

	if(isset($CFG['admin']['ffmpeg_command_'.$video_extension]))
		$command=$CFG['admin']['ffmpeg_command_'.$video_extension];
	else
		$command=$CFG['admin']['ffmpeg_command_otherformat'];

	$command=replaceCommandValue($command,$source_filename,$videoPath,true);
	return $command;
}

## FUNCTION TO get original Video width and height to check whether the need of resize in mencoder

/**
 * getVideoDimension()
 *
 * @param mixed $video_path
 * @return
 */
function getVideoDimension($video_path)
{
	global $CFG;
	exec($CFG['admin']['video']['mplayer_path'].' -vo null -ao null -frames 0 -identify '.$video_path, $p);

	$WIDTH='';
	$HEIGHT='';
	$return = array();
	while(list($k,$v)=each($p))
		{
			if($length=strstr($v,'ID_VIDEO_WIDTH='))
			{
				$WIDTH = explode("=",$length);
			}
			else if($length=strstr($v,'ID_VIDEO_HEIGHT='))
			{
				$HEIGHT=explode("=",$length);
			}

			if($WIDTH && $HEIGHT)
			{
				$return['width']=$WIDTH;
				$return['height']=$HEIGHT;
				break;
			}

	    }
}
?>