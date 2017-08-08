<?php
/**
 * List all boards
 *
 * PHP version 5.0
 *
 * @category	Discuzz
 * @package		solutions
 * @author 		shankar_76ag08
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id:  $
 * @since 		2008-12-19
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/'.$CFG['admin']['index']['home_module'].'/solutions.php';
$CFG['lang']['include_files'][] = 'languages/%s/'.$CFG['admin']['index']['home_module'].'/email_notify.inc.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_DiscussionHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_DiscussionsActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'tools/bbcode/nbbc.php';
$CFG['site']['is_module_page']='discussions';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['is']['ajax_page'] = false;
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
require('general/solutions.php');
?>