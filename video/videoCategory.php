<?php
/**
 * View all video catagory created
 *
 * PHP version 5.0
 *
 * @category	Rayzz
 * @package		VideoCategoryFormHandler
 * @author 		selvaraj_35ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: videoCategory.php 1440 2006-06-23 03:35:23Z senthil_52ag05 $
 * @since 		2006-06-23
 **/
/**
 * configurations
*/
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/videoCategory.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/common.inc.php';
$CFG['html']['header'] = 'general/html_header.php';;
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoHandler.lib.php';
$CFG['lang']['include_files'][] = 'common/configs/config_video.inc.php';
$CFG['db']['is_use_db'] = true;
$CFG['site']['is_module_page']='video';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;

require_once($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/videoCategory.php');
?>