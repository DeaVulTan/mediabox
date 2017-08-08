<?php
/**
 * This file is to increase the total view for videos.
 *
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 * @author 		logamurugan_41ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: videoUpdateExrnlVideoCounts.php 62 2007-06-04 14:40:00Z Uzdc $
 * @since 		2007-24-07
 *
 **/

require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/videoList.php';

$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['is_public_profile'] = false;
$CFG['auth']['is_authenticate'] = false;
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
$videoid = isset($_GET['video_id'])? $_GET['video_id']:'';
echo 'Removed';
if(isset($_GET['clear_list']))
	{
		if(isset($_SESSION['user']['quick_history']))
			$_SESSION['user']['quick_history']='';
		echo 'Cleared';
		exit;
	}

if($videoid and isset($_GET['remove_it']))
	{
		if(!isset($_SESSION['user']['quick_history']))
			{
				echo 'Not Removed';
				exit;
			}
		mvKLHRmRayzz($videoid);
		exit;
	}

?>
