<?php
/**
 * This file is use for view Album
 *
 * This file is having view Album.
 *
 *
 * @category	Rayzz/Music
 * @package		member
 *
 **/
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/viewAlbum.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/viewPlaylist.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/help.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicActivityHandler.lib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['site']['is_module_page']='music';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['admin']['light_window_page'] = false;
if(isset($_REQUEST['album_id']))
	{
		$CFG['admin']['light_window_page'] = true;
	}
if(isset($_REQUEST['mem_auth']) && $_REQUEST['mem_auth'] == true)
{
	$CFG['auth']['is_authenticate'] = 'members';
}
require($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/viewAlbum.php');
?>