<?php
/**
 * This file is to show the member profile
 *
 * This file is having MyProfileFormHandler class to display the members profile details
 *
 * PHP version 5.0
 *
 * @category	Rayzz
 * @package		Members
 * @author		vijayanand39ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: viewProfile.php 1868 2006-07-27 09:30:22Z vijayanand39ag05 $
 * @since 		2006-04-01
 */
/**
 * To include config file
 */
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/general/viewProfile.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/countries_list_array.inc.php';
$CFG['lang']['include_files'][] = 'common/configs/config_members_profile.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/gender_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/profile_list_array.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
foreach($CFG['site']['modules_arr'] as $value)
	{
		if(chkAllowedModule(array(strtolower($value))))
			{
				if(is_file($CFG['site']['project_path'].'languages/'.$CFG['lang']['default'].'/'.strtolower($value).'/profile'.ucfirst($value).'Block.php'))
					require_once($CFG['site']['project_path'].'languages/'.$CFG['lang']['default'].'/'.strtolower($value).'/profile'.ucfirst($value).'Block.php');
			}
     }
$__myProfile = true;
require_once($CFG['site']['project_path'].'general/viewProfile.php');
?>
