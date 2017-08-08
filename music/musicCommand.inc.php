<?php

/**
 *
 *
 * @version $Id$
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 */

function getMplayerCommand($source_filename, $output_filename)
	{
		global $CFG;
		$command = $CFG['admin']['musics']['mplayer_convert_command'];
		$search_array	= array('{mplayer_path}',
								'{source_file}',
								'{output_file}',
							);

		$replace_array	= array("\"".$CFG['admin']['video']['mplayer_path']."\"",
								$source_filename,
								$output_filename,
						    );
		$command = str_replace($search_array, $replace_array, $command);
		return $command;
	}

function getMplayerTrimCommand($source_filename, $output_filename, $start_pos = '', $end_pos='')
	{
		global $CFG;
		$command = $CFG['admin']['musics']['mplayer_trim_command'];
		$search_array	= array('{mplayer_path}',
								'{start_pos}',
								'{end_pos}',
								'{source_file}',
								'{output_file}',
							);
		if(!$end_pos)
			$end_pos = $CFG['admin']['musics']['trim_music_start_position'] + $CFG['admin']['musics']['trim_music_duration'];
		if(!$start_pos)
			$start_pos = $CFG['admin']['musics']['trim_music_start_position'];
		$replace_array	= array("\"".$CFG['admin']['video']['mplayer_path']."\"",
								$start_pos,
								$end_pos,
								$source_filename,
								$output_filename,
						    );
		$command = str_replace($search_array, $replace_array, $command);
		return $command;
	}

function getLameCommand($source_filename, $output_filename)
	{
		global $CFG;
		$command = $CFG['admin']['musics']['lame_command'];
		$search_array	= array('{lame_path}',
								'{source_file}',
								'{output_file}',
							);

		$replace_array	= array("\"".$CFG['admin']['audio']['lame_path']."\"",
								$source_filename,
								$output_filename,
						    );
		$command = str_replace($search_array, $replace_array, $command);
		return $command;
	}

function getFlvtool2Command($source_filename)
	{
		global $CFG;
		$command = $CFG['admin']['musics']['flvtool2_command'];
		$search_array	= array('{flvtool2_path}',
								'{source_file}',
							);

		$replace_array	= array("\"".$CFG['admin']['video']['flvtool2_path']."\"",
								$source_filename,
						    );
		$command = str_replace($search_array, $replace_array, $command);
		return $command;
	}

function getYamdiCommand($source_filename)
	{
		global $CFG;
		$command = $CFG['admin']['musics']['yamdi_command'];
		$search_array	= array('{yamdi_path}',
								'{source_file}',
								'{output_file}',
							);

		$replace_array	= array("\"".$CFG['admin']['audio']['yamdi_path']."\"",
								$source_filename,
								$source_filename,
						    );
		$command = str_replace($search_array, $replace_array, $command);
		return $command;
	}

function getMplayerDumpCommand($source_filename, $output_filename)
	{
		global $CFG;
		$command = $CFG['admin']['musics']['mplayer_dumpaudio_command'];
		$search_array	= array('{mplayer_path}',
								'{source_file}',
								'{output_file}',
							);

		$replace_array	= array("\"".$CFG['admin']['video']['mplayer_path']."\"",
								$source_filename,
								$output_filename,
						    );
		$command = str_replace($search_array, $replace_array, $command);
		return $command;
	}

function replaceCommandValue($command, $source_filename, $musicPath)
	{
		global $CFG;
		$search_array	= array('{mencoder_path}',
							'{ffmpeg_path}',
							'{source_file}',
							'{output_file}',
							);

		$replace_array	= array("\"".$CFG['admin']['video']['mencoder_path']."\"",
							"\"".$CFG['admin']['audio']['ffmpeg_path']."\"",
							$source_filename,
							$musicPath
						    );

		$command = str_replace($search_array,$replace_array,$command);

		return $command;
	}

function getOtherFormatsCommand($music_extension, $source_filename, $musicPath)
	{
		global $CFG;
		if(isset($CFG['admin']['mencoder_command_'.$music_extension]))
			$command = $CFG['admin']['mencoder_command_'.$music_extension];
		else
			$command = $CFG['admin']['mencoder_command_otherformat'];

		$command = replaceCommandValue($command, $source_filename, $musicPath);
		return $command;
	}
?>