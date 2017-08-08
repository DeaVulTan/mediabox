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
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['is_public_profile'] = false;
$CFG['auth']['is_authenticate'] = false;
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['site']['is_module_page']='video';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
$videoid = isset($_GET['video_id'])? $_GET['video_id']:'';

if(isset($_GET['clear_on_view']))
	{
		if($_GET['clear_on_view'])
			$_SESSION['user']['quick_list_clear']=true;
			else
				$_SESSION['user']['quick_list_clear']=false;
		exit;
	}
if(isset($_GET['clear_list']))
	{
		if(isset($_SESSION['user']['quick_links']))
			$_SESSION['user']['quick_links']='';
		echo 'Cleared';
		exit;
	}

if($videoid and isset($_GET['remove_it']))
	{
		if(!isset($_SESSION['user']['quick_links']))
			{
				echo 'Not Removed';
				exit;
			}
		mvKLRmRayzz($videoid);
		echo 'Removed';
		exit;
	}

if ($videoid)
	{
		if(!isset($_SESSION['user']['quick_links']))
			$_SESSION['user']['quick_links']='';//intitilaize in case when not initialized

		$need_to_add=true;

		if(trim($_SESSION['user']['quick_links']))
			{
				$avail_quick_link_video_arr=explode(',',$_SESSION['user']['quick_links']);
				if(is_array($avail_quick_link_video_arr))
					{
						if(in_array($videoid,$avail_quick_link_video_arr))
							$need_to_add=false;
					}
			}
		$need_to_add=true;
		if($need_to_add)
			$_SESSION['user']['quick_links'].=$videoid.',';
		echo 'Added';
	}
	else
		echo 'Added';
?>
