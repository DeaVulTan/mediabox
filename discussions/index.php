<?php
/**
 * Sites index page
 *
 * File showing the index page of the site.
 *
 * PHP version 5.0
 *
 * @category	###Discuzz###
 * @package		###index###
 * @author 		karthiselvam_75ag04
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2008-12-22
 */
error_reporting(E_ALL);
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/'.$CFG['admin']['index']['home_module'].'/index.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ActivityHandler.lib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['is']['ajax_page'] = false;
if(isset($_REQUEST['ajax_page']) and $_REQUEST['ajax_page'])
	{
		$CFG['is']['ajax_page'] = true;
		$CFG['html']['is_use_header'] = false;
		$CFG['html']['is_use_footer'] = false;
	}
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_DiscussionHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_DiscussionsActivityHandler.lib.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['site']['is_module_page']='discussions';
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//FOR RAYZZ INTEGRATION
if(class_exists('DiscussionHandler'))
	{
		$discussionHandler = new DiscussionHandler();
		$smartyObj->assign_by_ref('discussion', $discussionHandler);
	}
require('general/index.php');
?>