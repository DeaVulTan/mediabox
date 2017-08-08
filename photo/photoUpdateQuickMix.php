<?php
/**
 * This file is to increase the total view for photoids.
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
$CFG['lang']['include_files'][] = 'languages/%s/photo/photoList.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['is_public_profile'] = false;
$CFG['auth']['is_authenticate'] = false;
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
$photodetails = new MediaHandler();
$photodetails->setFormField('photo_id','');
$photodetails->setFormField('remove_it','');
$photodetails->setFormField('clear_quickmix_all','');
$photodetails->setFormField('clear_on_view','');
$photodetails->setFormField('clear_list','');
$photodetails->sanitizeFormInputs($_REQUEST);
$photoid = $photodetails->getFormField('photo_id');
$photodetails->memberLoginPhotoUrl = getUrl('viewphoto','?mem_auth=true&photo_id='.$photoid, $photoid.'/?mem_auth=true','members', 'photo');
if($photodetails->getFormField('clear_quickmix_all'))
{
	if(isset($_SESSION['user']['photo_quick_mixs']))
		$_SESSION['user']['photo_quick_mixs']='';
	exit;
}
if($photodetails->getFormField('clear_on_view'))
{
	if($_GET['clear_on_view'])
		$_SESSION['user']['quick_list_clear']=true;
		else
			$_SESSION['user']['quick_list_clear']=false;
	exit;
}
if(isset($_GET['clear_list']))
{
	if(isset($_SESSION['user']['photo_quick_mixs']))
		$_SESSION['user']['photo_quick_mixs']='';
	echo 'Cleared';
	exit;
}

if($photoid and $photodetails->getFormField('remove_it'))
{

	$photodetails->checkLoginStatusInAjax($photodetails->memberLoginPhotoUrl);
	if(!isset($_SESSION['user']['photo_quick_mixs']))
	{
		echo 'Not Removed';
		exit;
	}
	//have changed the function name when integrate with volume.
	rayzzRMQuickMixPhoto($photoid);
	echo 'Removed';
	exit;
}

if ($photoid)
{
	$photodetails->checkLoginStatusInAjax($photodetails->memberLoginPhotoUrl);
	if(!isset($_SESSION['user']['photo_quick_mixs']))
		$_SESSION['user']['photo_quick_mixs']='';
	$photoid_arr = explode(',',$photoid);
	$total_new_photo = count($photoid_arr);
	for($i=0;$i<$total_new_photo;$i++)
	{
		$need_to_add=true;
		if(trim($_SESSION['user']['photo_quick_mixs']))
		{
			$avail_quick_mix_photoid_arr=explode(',',$_SESSION['user']['photo_quick_mixs']);
			if(is_array($avail_quick_mix_photoid_arr))
			{
				if(in_array($photoid_arr[$i],$avail_quick_mix_photoid_arr))
					$need_to_add=false;
			}
		}
		//$need_to_add=true;
		if($need_to_add)
		{
		  	if($_SESSION['user']['photo_quick_mixs'] == '')
		  		$_SESSION['user']['photo_quick_mixs'] = $photoid_arr[$i];
		  	else
			    $_SESSION['user']['photo_quick_mixs'] .= ','.$photoid_arr[$i];
		}
	}
	echo 'Added';
}
else
	echo 'Added';
?>