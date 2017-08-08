<?php
/**
 *
 * @category	rayzz
 * @package		Members
 **/
require_once('../common/configs/config.inc.php');

$CFG['site']['is_module_page'] = 'music';
$CFG['lang']['include_files'][] = 'languages/%s/music/common.inc.php';

$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';

$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;

require($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/getMusicDetails.php');
?>