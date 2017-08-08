<?php
/**
 * This file is use for photo album list
 *
 * This file is having create photo album list page. Here we manage album list and search option.
 *
 *
 * @category	Rayzz/Photo
 * @package		member
 *
 **/
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/photo/albumList.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/help.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoHandler.lib.php';

$CFG['site']['is_module_page']='photo';
if(isset($_REQUEST['light_window']))
{
	$CFG['html']['header'] = 'general/html_header_no_header.php';
	$CFG['html']['footer'] = 'general/html_footer_no_footer.php';
	$CFG['mods']['is_include_only']['html_header'] = false;
	$CFG['html']['is_use_header'] = false;
	$CFG['admin']['light_window_page'] = true;
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

//Condition added to access specified pages only  by logged in members
$memberAlbumListAccessPages = array('myalbums');
if (isset($_REQUEST['pg']) AND in_array($_REQUEST['pg'],$memberAlbumListAccessPages))
{
	$CFG['auth']['is_authenticate'] = 'members';
}

require($CFG['site']['project_path'].'common/application_top.inc.php');
$CFG['admin']['light_window_page'] = true;
require_once('general/albumList.php');
?>
