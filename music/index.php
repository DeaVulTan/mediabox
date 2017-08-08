<?php
require_once('../common/configs/config.inc.php');
$CFG['site']['is_module_page']='music';
$CFG['lang']['include_files'][] = 'languages/%s/music/index.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ActivityHandler.lib.php';

$CFG['admin']['light_window_page'] = true;
if(isset($_REQUEST['act']) and $_REQUEST['act'] == 'vfcontent')
	{
		$CFG['html']['header'] = 'general/html_header_no_header.php';
		$CFG['html']['footer'] = 'general/html_footer_no_footer.php';
		$CFG['mods']['is_include_only']['html_header'] = false;
		$CFG['html']['is_use_header'] = false;
		//To show session expired content inside lightwindow if session got expired
		$CFG['admin']['session_redirect_light_window_page'] = false;
	}
else
	{
		$CFG['html']['header'] = 'general/html_header.php';
		$CFG['html']['footer'] = 'general/html_footer.php';
		$CFG['mods']['is_include_only']['html_header'] = false;
		$CFG['html']['is_use_header'] = false;
	}
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
require_once($CFG['site']['project_path'].'music/general/index.php');
?>