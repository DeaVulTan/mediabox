<?php

/**
 * This file is to download the video
 *
 * This file is having VideoDownload class to download the video
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 * @author 		selvaraj_35ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: videoDownload.php 113 2007-06-18 05:43:17Z vidhya_29ag04 $
 * @since 		2006-05-02
 *
 **/

require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_video.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/viewVideo.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
//$CFG['mods']['include_files'][] = 'common/classes/class_YoutubeGrabHandler.lib.php';

$CFG['db']['is_use_db'] = true;
$CFG['site']['is_module_page']='video';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;

require_once($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/videoDownload.php')
?>
