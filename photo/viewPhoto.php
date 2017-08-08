<?php
 /**
 * viewPhoto.php
 * This file is to view the photo
 *
 * PHP version 5.0
 *
 * @category	Framework
 * @package
 * @author 		edwin_048at09
 * @copyright	Copyright (c) 2009 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: viewPhoto.php 656 2010-01-20 edwin_048at09 $
 * @since 		2010-01-20
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/photo/viewPhoto.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/viewSlidelist.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/getPhotoMetaData.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/flag_list_array.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/recaptchalib.php';

$CFG['db']['is_use_db'] = true;
$CFG['site']['is_module_page']='photo';
//compulsory
if(isset($_REQUEST['type']) and ($_REQUEST['type'] == 'add_comment' or $_REQUEST['type'] == 'comment_reply'))
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
$CFG['admin']['light_window_page'] = true;

//Condition added to access rating functionalty only  by logged in members
if (isset($_REQUEST['mem_auth']) AND $_REQUEST['mem_auth'])
{
	$CFG['auth']['is_authenticate'] = 'members';
}
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/viewPhoto.php');
?>