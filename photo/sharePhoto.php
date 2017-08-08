<?php
/**
 * This file is to share the photo
 *
 * This file is having SharePhoto class to share the photo
 *
 *
 * @category	rayzz
 * @package		Index
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 *
 **/

require_once('../common/configs/config.inc.php');

$CFG['lang']['include_files'][] = 'languages/%s/photo/sharePhoto.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['lang']['include_files'][] = 'common/classes/class_PhotoHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoActivityHandler.lib.php';

$CFG['site']['is_module_page'] = 'photo';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;

require_once($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/sharePhoto.php');
?>
