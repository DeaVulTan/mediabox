<?php
/**
 * Play Songs in Playlist Player
 *
 * @category	Rayzz
 * @package
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
  **/
/**
 * configurations
*/
require_once('../common/configs/config.inc.php');
//$CFG['lang']['include_files'][] = 'languages/%s/music/musicCategory.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/common.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['site']['is_module_page']='music';
$CFG['html']['header'] = 'general/html_header_popup.php';;
$CFG['html']['footer'] = 'general/html_footer_popup.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;

require_once('../common/application_top.inc.php');
require_once('general/playSongsInPlaylist.php');
?>