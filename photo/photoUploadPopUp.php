<?php
/**
 * This file is to upload the photos
 * This file is having PhotoUpload class to upload the photos
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 **/
require_once('../common/configs/config.inc.php');

$CFG['benchmark']['is_expose_parse_time'] = false;
$CFG['benchmark']['query_time']['is_expose_query'] = false;
$CFG['benchmark']['query_time']['is_expose'] = false;
$CFG['site']['is_module_page'] = 'photo';
$CFG['lang']['include_files'][] = 'languages/%s/photo/capturePhoto.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/photoUpload.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/getPhotoMetaData.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/help.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoMetaData.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_CreateTextImage.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_WaterMark.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoUpload.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['auth']['is_authenticate'] = 'members';
if(isset($_REQUEST['type']) and ($_REQUEST['type'] == 'add_location'))
{
	$CFG['html']['header'] = 'general/html_header_no_header.php';
	$CFG['html']['footer'] = 'general/html_footer_no_footer.php';
	$CFG['admin']['light_window_page'] = true;
	//To show session expired content inside lightwindow if session got expired
	$CFG['admin']['session_redirect_light_window_page'] = true;
}
elseif(isset($_REQUEST['type']) and ($_REQUEST['type'] == 'view_location_photos'))
{
	$CFG['html']['header'] = 'general/html_header_no_header.php';
	$CFG['html']['footer'] = 'general/html_footer_no_footer.php';
	$CFG['admin']['light_window_page'] = true;
	//To show session expired content inside lightwindow if session got expired
	$CFG['admin']['session_redirect_light_window_page'] = true;
}
else
{
	$CFG['html']['header'] = 'general/html_header.php';
	$CFG['html']['footer'] = 'general/html_footer.php';
}
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['admin']['light_window_page'] = true;
require($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('./general/photoUploadPopUp.php');
?>