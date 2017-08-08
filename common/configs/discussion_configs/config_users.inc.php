<?php
/**
 * general config settings
 * ..
 *
 * PHP version 5.0
 *
 * @category	..
 * @package		..
 * @author 		karthiselvam_75ag08
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2008-12-19
 * @filesource
 **/
/**
 * @var				boolean Display Profile Image
 * @cfg_sub_head 	General User settings
 * @cfg_label 		Display Profile Image
 * @cfg_key 		admin_profile_image_allowed
 * @cfg_sec_name
 * @cfg_section 	users_setting
 */
$CFG['admin']['profile_image']['allowed'] = true;
/**
 * @var				boolean Is allowed to block user
 * @cfg_label 		Is allowed to block user
 * @cfg_key 		admin_block_user
 */
$CFG['admin']['block_user'] = true;
/**
 * @var				boolean Is email to friends allowed
 * @cfg_label 		Is email to friends allowed
 * @cfg_key 		admin_email_to_friend_allowed
 */
$CFG['admin']['email_to_friend']['allowed'] = true;
/**
 * @var				boolean Is add to user subscribe allowed
 * @cfg_label 		Is user subscription allowed
 * @cfg_key 		admin_subscribe_users
 */
$CFG['admin']['subscribe']['users'] = true;

/**
 * @var				string allowed_tags
 * @cfg_label 		Allowed html tags for the users bio field
 * @cfg_key 		allowed_tags
 */
$CFG['html']['allowed_tags'] = '<a><b><i>';
/**
 * @var				int signup_bio_count
 * @cfg_label 		No. of characters allowed in Bio field
 * @cfg_key 		admin_bio_count
 */
$CFG['admin']['bio_count'] = 500;
/**
 * @var				int Days
 * @cfg_label 		No. of days to delete inactive Users
 * @cfg_key 		admin_days
 */
$CFG['admin']['days'] = 10;
/**
 * @var				boolean Is points for viewing site once per day
 * @cfg_sub_head 	Points settings
 * @cfg_label 		Is Points allowed for viewing site once per day
 * @cfg_key 		view_solutions_allowed
 */
$CFG['admin']['view_solutions']['allowed'] = true;
/**
 * @var				boolean Is points for registering
 * @cfg_label 		Is Points allowed for register in this site
 * @cfg_key 		register_points_allowed
 */
$CFG['admin']['register_points']['allowed'] = true;
$CFG['admin']['subscribe']['tags'] = false;
?>