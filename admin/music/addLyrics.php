<?php
/**
 * This file is use for add lyrics
 *
 * This file is having add lyrics.
 *
 *
 * @category	Rayzz/Music
 * @package		member
 *
 **/
require_once('../../common/configs/config.inc.php');
require_once('../../common/configs/config_music_fieldsize.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/addLyrics.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/help.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['site']['is_module_page']='music';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$is_admin=true;
require($CFG['site']['project_path'].'common/application_top.inc.php');
require_once($CFG['site']['project_path'].'music/general/addLyrics.php');
?>