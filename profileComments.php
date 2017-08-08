<?php
/**
 * This file is to add commets for photos
 *
 * This file is having PostComment class to add commets for photos
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 * @author 		selvaraj_35ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: photoPostComment.php 1345 2006-06-21 01:41:52Z selvaraj_35ag05 $
 * @since 		2006-05-02
 *
 **/
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/general/profileComments.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_GeneralActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_inputfilter_clean.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
require_once($CFG['site']['project_path'].'general/profileComments.php');
?>