<?php
/**
 * This file is to display the blog list
 *
 * This file is having BlogList class to list the blogs
 *
 *
 * @category	Rayzz
 * @package		Index
 */
require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_blog.inc.php');
$CFG['site']['is_module_page'] = 'blog';
$CFG['lang']['include_files'][] = 'languages/%s/blog/blogList.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_BlogHandler.lib.php';
if (isset($_REQUEST['showtab'])) {
		$CFG['html']['header'] = 'general/html_header_no_header.php';
		$CFG['html']['footer'] = 'general/html_footer_no_footer.php';
		$CFG['admin']['light_window_page'] = true;
		//To show session expired content inside lightwindow if session got expired
		$CFG['admin']['session_redirect_light_window_page'] = true;
	}
else
	{
		$CFG['html']['header'] = 'general/html_header.php';
		$CFG['html']['footer'] = 'general/html_footer.php';
	}
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/blogSearchList.php');
?>