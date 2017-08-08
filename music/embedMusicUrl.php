<?php
/**
 * This File embedMusicUrl
 *
 * @category	Rayzz
 * @package		embedMusicUrl
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/help.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = false;
$CFG['site']['is_module_page']='music';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/embedMusicUrl.php');

?>