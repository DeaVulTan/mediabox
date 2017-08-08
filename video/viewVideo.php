<?php
/**
 * This file is to play the video
 *
 * This file is having ViewVideo class to play the video
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 * @author 		selvaraj_35ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: viewVideo.php 2986 2006-12-29 05:25:10Z selvaraj_35ag05 $
 * @since 		2006-05-02
 *
 **/
require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_video.inc.php');
require_once('../common/configs/config_video_player.inc.php');
if(isset($_REQUEST['mem_auth']) && $_REQUEST['mem_auth'] == true)
{
	$CFG['auth']['is_authenticate'] = 'members';
}
$CFG['lang']['include_files'][] = 'languages/%s/video/viewVideo.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/flag_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/blogger/NgeblogAccess.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['mods']['include_files'][] = 'common/classes/recaptchalib.php';
$CFG['db']['is_use_db'] = true;
$CFG['site']['is_module_page']='video';
//compulsory
if(isset($_REQUEST['type']) and ($_REQUEST['type'] == 'add_comment' or $_REQUEST['type'] == 'comment_reply'))
	{
		$CFG['html']['header'] = 'general/html_header_no_header.php';
		$CFG['html']['footer'] = 'general/html_footer_no_footer.php';
		$CFG['mods']['is_include_only']['html_header'] = false;
		$CFG['html']['is_use_header'] = false;
		$CFG['admin']['light_window_page'] = true;
		//To show session expired content inside lightwindow if session got expired
		$CFG['admin']['session_redirect_light_window_page'] = true;
	}
else
	{
		$CFG['html']['header'] = 'general/html_header.php';
		$CFG['html']['footer'] = 'general/html_footer.php';
		$CFG['mods']['is_include_only']['html_header'] = false;
		$CFG['html']['is_use_header'] = false;
	}
require($CFG['site']['project_path'].'common/application_top.inc.php');
if(isMember())
	$CFG['admin']['light_window_page'] = true;
require_once('./general/viewVideo.php');
?>