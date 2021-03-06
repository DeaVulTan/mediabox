<?php
/**
 * Play QuickMIX Songs in Playlist Player
 *
 * @category	Rayzz
 * @package		Index
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
  **/
/**
 * configurations
*/
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/photo/common.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoHandler.lib.php';
$CFG['site']['is_module_page']='photo';
$CFG['html']['header'] = 'general/html_header_no_header.php';;
$CFG['html']['footer'] = 'general/html_footer_no_footer.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;

//$CFG['admin']['light_window_page'] = true;

require_once('../common/application_top.inc.php');
require_once('general/flashShow.php');
?>