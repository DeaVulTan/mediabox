<?php
/**
 * This file is use for manage music playlist
 *
 * This file is having create music playlist. Here we manage playlist list, edit and delete.
 *
 *
 * @category	Rayzz/Music
 * @package		member
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 **/

require_once('../../common/configs/config.inc.php');
require_once('../../common/configs/config_music_fieldsize.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/musicPlaylistManage.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/help.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['site']['is_module_page']='music';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('../../music/general/musicPlaylistManage.php');
?>