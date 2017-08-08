<?php
/**
 * This file is use for manage photo playlist list
 *
 * This file is having create photo playlist. Here we manage playlist list, edit and delete.
 *
 *
 * @category	Rayzz/Photo
 * @package		member
 *
 **/
require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_photo_fieldsize.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/photo/photoSlidelistManage.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/help.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoActivityHandler.lib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['site']['is_module_page']='photo';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
$CFG['html']['is_use_header'] = false;
$CFG['admin']['light_window_page'] = true;
require($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('./general/photoSlidelistManage.php');