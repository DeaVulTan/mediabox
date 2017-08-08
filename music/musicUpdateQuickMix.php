<?php
/**
 * This file is to increase the total view for musicids.
 *
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 * @author
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id:
 * @since 		2007-24-07
 *
 **/

require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/musicList.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['is_public_profile'] = false;
$CFG['auth']['is_authenticate'] = false;
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
$musicDetails = new MediaHandler();
$musicDetails->setFormField('music_id','');
$musicDetails->setFormField('remove_it','');
$musicDetails->setFormField('clear_quickmix_all','');
$musicDetails->setFormField('clear_on_view','');
$musicDetails->setFormField('clear_list','');
$musicDetails->sanitizeFormInputs($_REQUEST);
$musicid = $musicDetails->getFormField('music_id');
if($musicDetails->getFormField('clear_quickmix_all'))
	{

		if(isset($_SESSION['user']['music_quick_mixs']))
			$_SESSION['user']['music_quick_mixs']='';
		exit;
	}
if($musicDetails->getFormField('clear_on_view'))
	{
		if($_GET['clear_on_view'])
			$_SESSION['user']['music_quick_list_clear']=true;
			else
				$_SESSION['user']['music_quick_list_clear']=false;
		exit;
	}
if(isset($_GET['clear_list']))
	{
		if(isset($_SESSION['user']['music_quick_mixs']))
			$_SESSION['user']['music_quick_mixs']='';
		echo 'Cleared';
		exit;
	}

if($musicid and $musicDetails->getFormField('remove_it'))
	{

		if(!isset($_SESSION['user']['music_quick_mixs']))
			{
				echo 'Not Removed';
				exit;
			}
		rayzzRMQuickMix($musicid);
		echo 'Removed';
		exit;
	}

if ($musicid)
	{
		if(!isset($_SESSION['user']['music_quick_mixs']))
			$_SESSION['user']['music_quick_mixs']='';
		$need_to_add=true;
		if(trim($_SESSION['user']['music_quick_mixs']))

					{
				$avail_quick_mix_musicid_arr=explode(',',$_SESSION['user']['music_quick_mixs']);
				if(is_array($avail_quick_mix_musicid_arr))
					{

						if(in_array($musicid,$avail_quick_mix_musicid_arr))
							$need_to_add=false;

					}
			}
		$need_to_add=true;
		if($need_to_add)
		  {
		  	if($_SESSION['user']['music_quick_mixs'] == '')
		  		$_SESSION['user']['music_quick_mixs'] = $musicid;
		  	else
			    $_SESSION['user']['music_quick_mixs'] .= ','.$musicid;
		  }
		echo 'Added';
	}
	else
		echo 'Added';
?>