<?php
/**
 * This file is use for report bugs to admin admin development team
 *
 *
 * This file is having report bugs
 *
 *
 * @category	Rayzz
 * @package		report bugs
 **/
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/general/reportBugs.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/bug_category_list_array.php';
$CFG['html']['header'] = 'general/html_header.php';;
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_SignupAndLoginHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/recaptchalib.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require($CFG['site']['project_path'].'common/application_top.inc.php');
require_once($CFG['site']['project_path'].'general/reportBugs.php');
?>