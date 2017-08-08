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
$CFG['lang']['include_files'][] = 'languages/%s/music/common.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['is_public_profile'] = false;
$CFG['auth']['is_authenticate'] = false;
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
$musicDetails = new MusicHandler();
$musicDetails->setFormField('music_id','');
$musicDetails->setFormField('album_id','');
$musicDetails->setFormField('remove_it','');
$musicDetails->setFormField('clear_cart_all','');
$musicDetails->setFormField('clear_list','');
$musicDetails->setFormField('page','');
$musicDetails->sanitizeFormInputs($_REQUEST);
$musicid = $musicDetails->getFormField('music_id');
$albumid = $musicDetails->getFormField('album_id');
$CFG['user']['user_id'] = $_SESSION['user']['user_id'];
if($musicDetails->getFormField('clear_cart_all'))
{
	if(isset($_SESSION['user']['add_cart']))
		$_SESSION['user']['add_cart']='';
	exit;
}
if(isset($_GET['clear_list']))
{
	if(isset($_SESSION['user']['add_cart']))
		unset($_SESSION['user']['add_cart']);
	echo 'Cleared';
	exit;
}

if($musicid and $musicDetails->getFormField('remove_it'))
{

	if(!isset($_SESSION['user']['add_cart']))
		{
			echo 'Not Removed';
			exit;
		}
	rayzzMusicRemoveCart($musicid);
	echo 'Successfully Removed from cart';
	exit;
}

if($albumid and $musicDetails->getFormField('remove_it'))
{

	if(!isset($_SESSION['user']['album_add_cart']))
		{
			echo 'Not Removed';
			exit;
		}
	rayzzAlbumRemoveCart($albumid);
	echo 'Successfully Removed from cart';
	exit;
}
$LANG['common_msg_add_to_cart_click'] = str_replace('{click_here}','<a href="#" onClick="hideAllBlocks();viewCart()">'.
  $LANG['common_click_here'].'</a>' ,$LANG['common_msg_add_to_cart_click']);
if ($musicid)
{
	if(!isset($_SESSION['user']['add_cart']))
		$_SESSION['user']['add_cart']='';
	if(isUserPurchased($musicid))
	{
		if($musicDetails->getFormField('page')=='player')
		{
			Redirect2Url(getUrl('viewmusiccart','?status=player&msg=purchased','?status=player&msg=purchased','members','music'));
		}
		echo $LANG['musiclist_purchased'];
		exit;
	}
	$need_to_add=true;
	if(trim($_SESSION['user']['add_cart']))

				{
			$avail_add_cart_musicid_arr=explode(',',$_SESSION['user']['add_cart']);
			if(is_array($avail_add_cart_musicid_arr))
				{
					if(in_array($musicid,$avail_add_cart_musicid_arr))
						$need_to_add=false;
				}
		}
	//$need_to_add=true;
	if($need_to_add)
	  {
	  	if($_SESSION['user']['add_cart'] == '')
	  		$_SESSION['user']['add_cart'] = $musicid;
	  	else
		    $_SESSION['user']['add_cart'] .= ','.$musicid;

		echo $LANG['common_msg_add_to_cart_success'];
	  }
	else
		echo $LANG['common_msg_add_to_cart_added'];

	echo $LANG['common_msg_add_to_cart_click'];

}

if ($albumid)
{
	if(!isset($_SESSION['user']['album_add_cart']))
		$_SESSION['user']['album_add_cart']='';
	$need_to_add=true;
	if(isUserAlbumPurchased($albumid))
	{
		if($musicDetails->getFormField('page')=='player')
		{
			Redirect2Url(getUrl('viewmusiccart','?status=player&msg=purchased','?status=player&msg=purchased','members','music'));
		}
		echo $LANG['musiclist_purchased'];
		exit;
	}
	if(trim($_SESSION['user']['album_add_cart']))

				{
			$avail_add_cart_albumid_arr=explode(',',$_SESSION['user']['album_add_cart']);
			if(is_array($avail_add_cart_albumid_arr))
				{
					if(in_array($albumid,$avail_add_cart_albumid_arr))
						$need_to_add=false;
				}
		}
	//$need_to_add=true;
	if($need_to_add)
	  {
	  	if($_SESSION['user']['album_add_cart'] == '')
	  		$_SESSION['user']['album_add_cart'] = $albumid;
	  	else
		    $_SESSION['user']['album_add_cart'] .= ','.$albumid;

		echo $LANG['common_msg_add_to_cart_success'];
	  }
	else
		echo $LANG['common_msg_add_to_cart_added'];
	echo $LANG['common_msg_add_to_cart_click'];
}
if($musicDetails->getFormField('page')=='player')
{
	Redirect2Url(getUrl('viewmusiccart','?status=player','?status=player','members','music'));
}
?>