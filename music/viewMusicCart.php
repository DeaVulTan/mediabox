<?php
/**
 * This file is to  Music Cart Display
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 **/
require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_payment.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/viewMusicCart.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['admin']['light_window_page'] = false;
$CFG['db']['is_use_db'] = true;
$CFG['site']['is_module_page']='music';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['mods']['include_files'][] = 'common/classes/class_MusicPayPalIPN.lib.php';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/viewMusicCart.php');
?>