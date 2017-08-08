<?php
/**
 * This file is to display the video list
 *
 * This file is having VideoList class to list the videos
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 * @author 		selvaraj_35ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: myVideos.php 2986 2006-12-29 05:25:10Z selvaraj_35ag05 $
 * @since 		2006-05-02
 *
 **/
require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_video.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/videoList.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/countries_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/language_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/video_playingtime_length_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/video_added_date_list_array.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoActivityHandler.lib.php';
$CFG['db']['is_use_db'] = true;
$CFG['site']['is_module_page']='video';
$memberVideoListCase = array('myvideos','myfavoritevideos','myrecentlyviewedvideo','myalbumvideolist','myplaylist');
if (isset($_REQUEST['pg']) AND in_array($_REQUEST['pg'], $memberVideoListCase))
	{
		$CFG['auth']['is_authenticate'] = 'members';
	}
if (isset($_REQUEST['showtab'])) {
		$CFG['html']['header'] = 'general/html_header_no_header.php';
		$CFG['html']['footer'] = 'general/html_footer_no_footer.php';
		$CFG['admin']['light_window_page'] = true;
		//To show session expired content inside lightwindow if session got expired
		$CFG['admin']['session_redirect_light_window_page'] = true;
	}


//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('./general/videoSearchList.php');
?>