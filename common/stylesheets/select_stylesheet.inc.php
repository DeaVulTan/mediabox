<?php
/**
 * ###Add file short description###
 *
 * ###Add file long description###
 *
 * PHP version 5.0
 *
 * @category	###Framework###
 * @package		###Common/Stylesheets###
 * @author 		manonmani_51ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		Release: @package_version@
 * @since 		2005-09-28
 * @todo optimize conditions
 */
//detect requested stylesheets
$requested_style = $CFG['html']['stylesheet']['screen']['default'];
$is_set_cookie_session = false;
if (!empty($_GET['style']))
		{
			$requested_style = $_GET['style'];
			$is_set_cookie_session = true;
		}
	else if (!empty($_POST['style']))
		{
			$requested_style = $_POST['style'];
			$is_set_cookie_session = true;
		}
	else if (!empty($_COOKIE['style']))
		$requested_style = $_COOKIE['style'];
	else if (!empty($_SESSION['user']['pref_style']))
		$requested_style = $_SESSION['user']['pref_style'];

if ($is_set_cookie_session or
		$requested_style!=$CFG['html']['stylesheet']['screen']['default'])
	{
	    if (isset($CFG['html']['stylesheet']['screen']['available_stylesheets'][$requested_style]))
			{
				$CFG['html']['stylesheet']['screen']['default'] = $requested_style;
				//set cookie and session...
				setcookie('style', $requested_style, time()+ 4320000, '/'); //expire in 50 days (50x24x60x60)
				$_SESSION['user']['pref_style'] = $requested_style;
			}
	}
?>
