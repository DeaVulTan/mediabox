<?php
/**
 * Sites index page
 *
 * File showing the home page of the site.
 *
 * PHP version 5.0
 *
 * @category	###Rayzz###
 * @package		###Members###
 * @author 		selvaraj_47ag04
 * @copyright	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: index.php 736 2008-05-26 06:34:50Z selvaraj_47ag04 $
 * @since 		2008-04-02
 */
/**
 * File having common configuration variables required for the entire project
 */
require_once('../common/configs/config.inc.php'); //configurations
/*if (version_compare(PHP_VERSION,'5','>='))
	{
		require_once ('../facebook/client/facebook.php');
	}
else
	{
		require_once ('../facebook/php4client/facebook.php');
		require_once ('../facebook/php4client/facebookapi_php4_restlib.php');
	}*/
$CFG['site']['is_module_page']='video';	
$CFG['lang']['include_files'][] = 'languages/%s/video/index.php';
//$CFG['lang']['include_files'][] = 'languages/%s/members/addFacebookProfile.php';
$CFG['mods']['include_files'][] = 'common/configs/config_video_index.inc.php';
//$CFG['mods']['include_files'][] = 'common/configs/config_facebook.inc.php';
$CFG['mods']['include_files'][] = 'common/configs/config_video_player.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoHandler.lib.php';
//$CFG['mods']['include_files'][] = 'common/classes/class_RayzzHandler.lib.php';


if(isset($_GET['block']) AND isset($_GET['module']))
	{
		$CFG['mods']['is_include_only']['non_html_header_files'] = true;
	}
else
	{
		$CFG['html']['header'] = 'general/html_header.php';
		$CFG['html']['footer'] = 'general/html_footer.php';
		$CFG['mods']['is_include_only']['html_header'] = false;
		$CFG['html']['is_use_header'] = false;

	}
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
require_once($CFG['site']['project_path'].'video/general/indexVideoBlock.php');
?>