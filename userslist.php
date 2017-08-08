<?php
/**
 * Login of an existing user
 *
 * The login page will allow the existing user to have the further access by
 * getting the user name and password from the user. After proper login the
 * user are redirected to the members home page.
 *
 * PHP version 5.0
 *
 * @category	###Framework###
 * @package		###Index###
 * @author 		selvaraj_47ag04
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: userslist.php 736 2008-05-26 06:34:50Z selvaraj_47ag04 $
 * @since 		2008-04-02
 */
/**
 * File having common configuration variables required for the entire project
 */
require_once('./common/configs/config.inc.php');
$CFG['mods']['include_files'][] = 'common/classes/class_API.lib.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * File to include the header file, database access file, session management file, help file and necessary functions
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');

$FormHandler = new FormHandler();

if(!$FormHandler->chkAllowedModule(array('api')))
	Redirect2URL(getUrl($CFG['redirect']['dsabled_module_url']['file_name']));

$api = new API();
$api->format = 'json';
$api->table_names = $CFG['db']['tbl']['users'];
$api->return_columns = array('user_id', 'user_name', 'email', 'first_name', 'last_name', 'usr_status');
$api->sql_condition = 'usr_status=\'Ok\'';
$api->limit_start = 0;
$api->limit_end = 20;
$api->orderby_column = 'user_name';
$api->orderby = 'ASC';
$api->generateTablesAPI();
?>