<?php
/**
 * This file is to upload the photos
 * This file is having PhotoUpload class to upload the photos
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 **/
require_once('../common/configs/config.inc.php');
$CFG['site']['is_module_page'] = 'photo';
$CFG['lang']['include_files'][] = 'languages/%s/photo/photoUpload.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/help.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoUpload.lib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
$CFG['html']['is_use_header'] = false;
$CFG['admin']['light_window_page'] = true;
require($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('./general/photoDefaultSettings.php');
?>
