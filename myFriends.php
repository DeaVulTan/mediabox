<?php
/**
 * This file is lists friends of the member
 *
 * This file is having MyFriendsListHandler class to display the members profile details
 *
 *
 * @category	Rayzz
 * @package		Members
 */

/**
 * To include config file
 */
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/general/viewFriends.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';

/**
 * To include application top file
 */
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
$___myFriendsPage = true;
require_once($CFG['site']['project_path'].'general/viewFriends.php');
?>