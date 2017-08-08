<?php
/**
 * View all blog category created
 *
 *
 * @category	Rayzz
 * @package		Index
 **/
require_once('../common/configs/config.inc.php');
$CFG['site']['is_module_page'] = 'blog';
$CFG['lang']['include_files'][] = 'languages/%s/blog/blogCategory.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_BlogHandler.lib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/blogCategory.php');
?>