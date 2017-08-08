<?php
/**
 * File to handle the logout
 *
 * By clicking the logout link by the logged in user this file will clear
 * the session and redirect the user to the login page with success message.
 *
 * PHP version 5.0
 *
 * @category	###Framework###
 * @package		###Index###
 * @author 		selvaraj_47ag04
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: logout.php 764 2008-06-23 08:04:22Z vijayanand_39ag05 $
 * @since 		2008-04-02
 */
/**
 * File having common configuration variables required for the entire project
 */
require_once('./common/configs/config.inc.php'); //configurations
session_start();
// Unset all of the session variables.
$_SESSION = array();
// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (isset($_COOKIE[session_name()]))
	{
	   setcookie(session_name(), '', time()-42000, '/');
	}
setcookie($CFG['cookie']['starting_text'].'_user_name', '', time()+60*60*24*365, '/');
setcookie($CFG['cookie']['starting_text'].'_token', '', time()+60*60*24*365, '/');
// Finally, destroy the session.
session_destroy();
session_write_close();
setcookie($CFG['cookie']['starting_text'].'_bba', '', time()-42000, '/');
//$CFG['html']['is_use_header'] = true;
$CFG['html']['header'] = 'general/html_header.php';
//$CFG['html']['is_use_footer'] = true;
$CFG['html']['footer'] = 'general/html_footer.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
$FormHandler = new FormHandler();
$server = $_SERVER['HTTP_USER_AGENT'];
//$pattern = "/AppleWebKit/";
$pattern1 = "/Opera/";
if(preg_match($pattern1,$server))// || preg_match($pattern1,$server))
	{
		$FormHandler->setPageBlockNames(array('form_success'));
		$CFG['feature']['auto_hide_success_block'] = false;
		$FormHandler->setCommonSuccessMsg($LANG['common_msg_logged_out']);
		$FormHandler->setPageBlockShow('form_success');
	}
else
	Redirect2Url(getUrl('login', '?logout', '?logout', 'root'));

//<<<<--------------------Code Ends----------------------//
$FormHandler->includeHeader();
setTemplateFolder('root/');
$smartyObj->display('logout.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$FormHandler->includeFooter();

//--------------------Page block templates begins-------------------->>>>>//
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
//require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');
?>