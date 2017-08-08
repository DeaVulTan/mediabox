<?php
/**
 * This file is use for photo playlist
 *
 * This file is having create photo playlist list page. Here we manage playlist list and search option.
 *
 *
 * @category	Rayzz/Photo
 * @package		member
 *
 **/
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/photo/photoSlidelist.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/help.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/searchtotalphoto_list_array.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoHandler.lib.php';
$CFG['site']['is_module_page']='photo';
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

//Condition added to access specified pages only  by logged in members
$memberSlideListAccessPages = array('myslidelist', 'myfavoriteslidelist');
if (isset($_REQUEST['pg']) AND in_array($_REQUEST['pg'],$memberSlideListAccessPages))
{
	$CFG['auth']['is_authenticate'] = 'members';
}

require($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/photoSlidelist.php');
?>