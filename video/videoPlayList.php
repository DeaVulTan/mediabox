<?php
/**
 * File to allow the users view video play list
 *
 * Provides an interface to video play list
 *
 *
 * @category	Rayzz
 * @package		Forums
 */

require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/videoList.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/common.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoHandler.lib.php';
$CFG['site']['is_module_page']='video';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require($CFG['site']['project_path'].'common/application_top.inc.php');
require('general/videoPlayList.php');
?>