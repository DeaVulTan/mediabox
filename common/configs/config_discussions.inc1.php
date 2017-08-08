<?php

/**
 * settings for $CFG['admin']['discussions']
 *
 * ..
 *
 * PHP version 5.0
 *
 * @category	..
 * @package		..
 * @author 		senthil_52ag05
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id:
 * @since 		2008-12-19
 * @filesource
 **/
//Assign Global Config Variable adult_content_view,adult_minimum_age to discussions variable respectively *Do not move this variable to db.
$CFG['admin']['discussions']['adult_content_view'] = $CFG['admin']['site']['adult_content_view'];
$CFG['admin']['discussions']['adult_minimum_age'] = $CFG['admin']['site']['adult_minimum_age'];
$CFG['admin']['members']['discussions_icon_title'] = '%s Discussions';
$CFG['admin']['index']['home_module'] = 'discussions';
$CFG['admin']['attachments']['format_arr'] = array('jpg', 'gif', 'png', 'bmp', 'pdf', 'doc', 'txt', 'zip');
require_once('discussion_configs/config_tables.inc.php');
require_once('discussion_configs/config_url.inc.php');
require_once('discussion_configs/config_users_table.inc.php');
require_once('discussion_configs/config_miscellaneous.inc.php');
require_once('discussion_configs/config_general.inc.php');
require_once('discussion_configs/config_friends.inc.php');
require_once('discussion_configs/config_users.inc.php');
require_once('discussion_configs/config_ans_photo.inc.php');
require_once('discussion_configs/config_user.inc.php');
require_once('discussion_configs/config_ver.inc.php');
require_once('discussion_configs/config_integrate.inc.php');
require_once($CFG['site']['project_path'].'languages/'.$CFG['lang']['default'].'/'.$CFG['admin']['index']['home_module'].'/help.inc.php');
?>
