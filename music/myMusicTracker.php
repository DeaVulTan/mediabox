<?php
/**
 * This file is to Mymusic Tracker List Display
 * This file is having MusicUpload class to upload the musics
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 **/
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/myMusicTracker.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/countries_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/language_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/playingtime_length_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/added_date_list_array.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicActivityHandler.lib.php';
$CFG['admin']['light_window_page'] = false;
$CFG['db']['is_use_db'] = true;
$CFG['site']['is_module_page']='music';
$CFG['auth']['is_authenticate'] = 'members';

$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
if(isset($_REQUEST['type']) and ($_REQUEST['type'] == 'add_comment'))
	{
		$CFG['admin']['light_window_page'] = true;
	}
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/myMusicTracker.php');
?>