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
$CFG['db']['tbl']['users'] = 'users';
/**
 * @var				string user table fields
 * @cfg_sub_head 	Database field names
 * @cfg_label 		User table field - user_id
 * @cfg_key 		users_user_id
 */
$CFG['users']['user_id'] = 'user_id';
/**
 * @var				string user table fields
 * @cfg_label 		User table field - name
 * @cfg_key 		users_name
 */
$CFG['users']['name'] = 'user_name';
/**
 * @var				string user table fields
 * @cfg_label 		User table field - display_name
 * @cfg_key 		display_name
 */
$CFG['users']['display_name'] = 'user_name';
/**
 * @var				string user table fields
 * @cfg_label 		User table field - email
 * @cfg_key 		users_email
 */
$CFG['users']['email'] = 'email';
/**
 * @var				string user table fields
 * @cfg_label 		User table field - user_status
 * @cfg_key 		users_user_status
 */
$CFG['users']['user_status'] = 'usr_status';
/**
 * @var				string user table fields
 * @cfg_label 		User table field - password
 * @cfg_key 		users_password
 */
$CFG['users']['password'] = 'password';
/**
 * @var				string user table fields
 * @cfg_label 		User table field - user_access
 * @cfg_key 		users_user_access
 */
$CFG['users']['user_access'] = 'usr_access';
/**
 * @var				string user table fields
 * @cfg_label 		User table field - doj
 * @cfg_key 		users_doj
 */
$CFG['users']['doj'] = 'doj';
?>