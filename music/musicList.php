<?php
/**
 * This file is to Music List Display
 * This file is having MusicUpload class to upload the musics
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 **/
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/musicList.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/viewPlaylist.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/countries_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/sort_alphabets_list_array.inc.php';
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
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
if(isset($_REQUEST['type']) and ($_REQUEST['type'] == 'add_comment'))
	{
		$CFG['admin']['light_window_page'] = true;
	}
$memberMusicListCase = array('mymusics','myfavoritemusics','myrecentlyviewedmusic','myalbummusiclist','myplaylist');
if((isset($_REQUEST['pg']) AND in_array($_REQUEST['pg'],$memberMusicListCase)) || (isset($_REQUEST['mem_auth']) && $_REQUEST['mem_auth'] == 'true'))
{
	$CFG['auth']['is_authenticate'] = 'members';
}
$LANG['meta_musiclist_keywords'] = 'musiclisting ';
$LANG['meta_musiclist_description'] = 'musiclisting search our huge volume database';
$LANG['meta_musiclist_title'] = 'musiclisting :: searchdb';

require_once($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/musicList.php');
?>