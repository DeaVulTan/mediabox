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
$CFG['lang']['include_files'][] = 'languages/%s/video/viewVideo.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/myDashBoard.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/common.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoHandler.lib.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/help.inc.php';

$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['site']['is_module_page']='video';
$CFG['feature']['auto_hide_success_block']=false;
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include various types of files
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/myDashBoard.php');

?>