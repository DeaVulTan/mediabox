<?php
require_once('../common/configs/config.inc.php');
$CFG['site']['is_module_page']='article';
$CFG['lang']['include_files'][] = 'languages/%s/root/login.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/index.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ArticleHandler.lib.php';

$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;


/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
require_once($CFG['site']['project_path'].'article/general/index.php');
?>