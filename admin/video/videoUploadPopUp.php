<?php
/**
 * This file is to upload the videos
 *
 * This file is having VideoUpload class to upload the videos
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 **/

require_once('../../common/configs/config.inc.php');
require_once('../../common/configs/config_video.inc.php');
require_once('../../common/configs/config_encoder_command.inc.php');
//for fix the query display temporary solution
$CFG['benchmark']['is_expose_parse_time'] = false;
$CFG['benchmark']['query_time']['is_expose_query'] = false;
$CFG['benchmark']['query_time']['is_expose'] = false;
$CFG['debug']['is_db_debug_mode'] = false;
$CFG['lang']['include_files'][] = 'languages/%s/video/videoUpload.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/countries_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/language_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/months_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/help.inc.php';

$CFG['lang']['include_files'][] = 'languages/%s/video/videoUpload.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/countries_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/language_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/months_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/help.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ExternalVideoUrlHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoUpload.lib.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoGifHandler.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FlixEngine.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['site']['is_module_page'] = 'video';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('../../video/general/videoUploadPopUp.php');
?>