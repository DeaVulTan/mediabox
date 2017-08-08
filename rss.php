<?php
/**
 * File handling rss video
 * @category	Rayzz
 * @package		Index
 */
require_once('common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/root/rss.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/rss.php');
?>