<?php
/**
 * This file handles the contact us page
 *
 * In this file the user must enter his mail id, subject and contact message.
 * When clicking submit this information is posted to the admin.
 *
 *
 * @category	###Rayzz###
 * @package		###Index###
 */
/**
 * File having common configuration variables required for the entire project
 */
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/general/contactUs.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/recaptchalib.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
require_once($CFG['site']['project_path'].'general/contactUs.php');
?>