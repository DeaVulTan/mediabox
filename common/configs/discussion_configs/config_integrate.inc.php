<?php
/**
 * integrate config settings
 * ..
 *
 * PHP version 5.0
 *
 * @category	..
 * @package		..
 * @author 		anandaraj_088at09
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2008-12-19
 * @filesource
 **/
// Modify the user table name
$CFG['db']['tbl']['users_info'] = 'users';
// Modify the users table field names
$CFG['users_info']['img_path'] = '';
$CFG['users_info']['m_height'] = 'mini_height';
$CFG['users_info']['m_width'] = 'mini_width';
$CFG['users_info']['t_height'] = 'thumb_height';
$CFG['users_info']['t_width'] = 'thumb_width';
$CFG['users_info']['s_height'] = 'small_height';
$CFG['users_info']['s_width'] = 'small_width';
$CFG['users_info']['photo_server_url'] = 'image_server_url';
$CFG['users_info']['photo_ext'] = 'image_ext';
$CFG['users_info']['gender'] = 'sex';
$CFG['users_info']['bio'] = '';
$CFG['users_info']['online_hours'] = '';
$CFG['users_info']['featured'] = 'featured';
$CFG['users_info']['is_logged_in'] = 'logged_in';
$CFG['users_info']['last_logged'] = 'last_logged';
$CFG['users_info']['last_active'] = 'last_active';
$CFG['users_info']['last_updated'] = '';
$CFG['users_info']['update_seconds'] = '';
$CFG['users_info']['online_hours'] = '';
$CFG['users_info']['num_visits'] = 'num_visits';
$CFG['users_info']['session'] = 'session';
$CFG['users_info']['ip'] = 'ip';
$CFG['users_info']['visible_to'] = 'show_profile';
$CFG['users_info']['time_zone'] = 'time_zone';

//for data thumb purbose only -- no use
$CFG['admin']['ans_photos']['folder'] = 'files/user_profile_avatar/';
$CFG['admin']['ans_photos']['temp_folder'] = 'files/temp_files/temp_user_avatar/';

//Invitation url change
$CFG['page_url']['invitation']['normal'] = 'membersInvite.php';
$CFG['page_url']['invitation']['htaccess'] = 'invitation/send/';

function getImageName($text)
	{
		//$text = md5($text);
		//return substr($text, 0, 15);
		return $text;
	}
?>