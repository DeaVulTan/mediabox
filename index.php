<?php
/**
 * Sites index page
 *
 * File showing the home page of the site.
 *
 * PHP version 5.0
 *
 * @category	###Rayzz###
 * @package		###Index###
 * @author 		selvaraj_47ag04
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: index.php 736 2008-05-26 06:34:50Z selvaraj_47ag04 $
 * @since 		2008-04-02
 */
/**
 * File having common configuration variables required for the entire project
 */

require_once('./common/configs/config.inc.php'); //configurations

$CFG['lang']['include_files'][] = 'languages/%s/general/index.php';
$CFG['lang']['include_files'][] = 'languages/%s/members/myHome.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ActivityHandler.lib.php';

/**
 * To include application top file
 */
 require($CFG['site']['project_path'].'common/application_top.inc.php');
 require_once($CFG['site']['project_path'].'general/index.php');
?>