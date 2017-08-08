<?php
/**
 * This file is use for music playlist
 *
 * This file is having create music playlist list page. Here we manage playlist list and search option.
 *
 *
 * @category	Rayzz/Music
 * @package		member
 *
 **/
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/musicPlaylist.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/help.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/searchtotalmusic_list_array.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['site']['is_module_page']='music';
$CFG['admin']['light_window_page'] = true;
if(isset($_REQUEST['light_window']))
	{
		$CFG['html']['header'] = 'general/html_header_no_header.php';
		$CFG['html']['footer'] = 'general/html_footer_no_footer.php';
		$CFG['mods']['is_include_only']['html_header'] = false;
		$CFG['html']['is_use_header'] = false;
		//To show session expired content inside lightwindow if session got expired
		$CFG['admin']['session_redirect_light_window_page'] = true;
	}
else
	{
		$CFG['html']['header'] = 'general/html_header.php';
		$CFG['html']['footer'] = 'general/html_footer.php';
		$CFG['mods']['is_include_only']['html_header'] = false;
		$CFG['html']['is_use_header'] = false;
	}
$memberPlayListCase = array('myplaylist','myfavoriteplaylist','myrecentlyviewedplaylist','myfeaturedplaylist','myfavoriteplaylist');
if (isset($_REQUEST['pg']) AND in_array($_REQUEST['pg'],$memberPlayListCase))
	{
		$CFG['auth']['is_authenticate'] = 'members';
	}
require($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/musicPlaylist.php');
?>