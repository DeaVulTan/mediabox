<?php

/**
 * This file Lists all the members in our Rayzz
 *
 * PHP version 5.0
 *
 * @category	Rayzz
 * @package		Members
 * @author		vijayanand39ag05
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id:$
 * @since 		2006-05-01
 */

/**
 * To include config file
 */
require_once('../common/configs/config.inc.php');

$CFG['lang']['include_files'][] = 'languages/%s/music/fansList.php';

$CFG['lang']['include_files'][] = 'languages/%s/lists_array/countries_list_array.inc.php';
//Gender List
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/gender_list_array.inc.php';

$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['site']['is_module_page']='music';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/fansList.php');
?>

