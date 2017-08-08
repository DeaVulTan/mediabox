<?php
/**
 * This file is use for view lyrics
 *
 * This file is having view lyrics.
 *
 *
 * @category	Rayzz/Music
 * @package		member
 *
 **/
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/viewLyrics.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/help.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
if(isset($_REQUEST['page']) and $_REQUEST['page']=='player')
{
	$CFG['html']['header'] = 'general/html_header_popup.php';
	$CFG['html']['footer'] = 'general/html_footer_popup.php';

}
else
{
	$CFG['html']['header'] = 'general/html_header.php';
	$CFG['html']['footer'] = 'general/html_footer.php';
}
$CFG['site']['is_module_page']='music';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/viewLyrics.php');
?>