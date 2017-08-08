<?php

/**
 * This file is to share the video
 *
 * This file is having ShareVideo class to share the video
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 * @author 		selvaraj_35ag05
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: shareVideo.php 6360 2007-04-24 11:44:28Z vidhya_29ag04 $
 * @since 		2006-05-02
 *
 **/

require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_video.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/shareVideo.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['lang']['include_files'][] = 'common/classes/class_VideoHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoActivityHandler.lib.php';

$CFG['db']['is_use_db'] = true;
$CFG['site']['is_module_page']='video';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
if(isset($_REQUEST['page']) and ($_REQUEST['page'] == 'video'))
	{
		$CFG['html']['header'] = 'general/html_header.php';
		$CFG['html']['footer'] = 'general/html_footer.php';
		$CFG['mods']['is_include_only']['html_header'] = false;
		$CFG['html']['is_use_header'] = false;
		$CFG['admin']['light_window_page'] = true;
	}
else
	{
		$CFG['html']['header'] = 'general/html_header_no_header.php';
		$CFG['html']['footer'] = 'general/html_footer_no_footer.php';
		$CFG['mods']['is_include_only']['html_header'] = false;
		$CFG['html']['is_use_header'] = false;
	}
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/shareVideo.php');
?>