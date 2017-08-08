<?php
/**
 * File to handle the language select option
 *
 * This file handle the language select option when the user select
 * one of the language selected in the available language list menu.
 *
 * PHP version 5.0
 *
 * @category	###Framework###
 * @package		###Common/Languages###
 * @author 		rajesh_04ag02
 * @copyright	Copyright (c) 2005 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		Release: @package_version@
 * @since 		2005-03-17
 */
//User agent language signatures
$CFG['lang']['temp_default'] = $CFG['lang']['default'];

$ua_lang_signatures = array(
	//'lang code' => regexp
        'en_us'	=>	'en([-_][[:alpha:]]{2})?|english'
    );

//detect requested language
$requested_lang = $CFG['lang']['default'];
$is_set_cookie_session = false;
if (!empty($_GET['lang']))
		{
		 	//<------set cookie and session
			$requested_lang = $_GET['lang'];
			$is_set_cookie_session = true;
		}
	else if (!empty($_POST['lang']))
		{
		  	//<------set cookie and session
			$requested_lang = $_POST['lang'];
			$is_set_cookie_session = true;
		}
	else if (!empty($_COOKIE['lang']))
		$requested_lang = $_COOKIE['lang'];
	else if (!empty($_SESSION['user']['pref_lang']))
		$requested_lang = $_SESSION['user']['pref_lang'];
	else if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE']))
		{
			foreach($ua_lang_signatures as $key=>$value)
				{
					if (preg_match('/^(' . $value . ')(;q=[0-9]\\.[0-9])?$/i', $_SERVER['HTTP_ACCEPT_LANGUAGE']))
						{
							$requested_lang = $key;
							break;
						}
				}
		}
	else if (!empty($_SERVER['HTTP_USER_AGENT']))
		{
			foreach($ua_lang_signatures as $key=>$value)
				{
					if (preg_match('/(\(|\[|;[[:space:]])(' . $value . ')(;|\]|\))/i', $_SERVER['HTTP_USER_AGENT']))
						{
							$requested_lang = $key;
							break;
						}
				}
		}

if ($is_set_cookie_session or $requested_lang!=$CFG['lang']['default'])
	{
	    if (isset($CFG['lang']['available_languages'][$requested_lang])
			&& ((is_string($CFG['lang']['enabled_languages']) && $CFG['lang']['enabled_languages']=='*')
				|| (is_array($CFG['lang']['enabled_languages']) && in_array($requested_lang, $CFG['lang']['enabled_languages']))))
			{
				if($CFG['published_languages'][$requested_lang] === 'true')
					{
						$CFG['lang']['default'] = $requested_lang;
						//set cookie and session...
						setcookie('lang', $requested_lang, time()+ 4320000, '/'); //expire in 50 days (50x24x60x60)
						$_SESSION['user']['pref_lang'] = $requested_lang;
					}
			}
	}
?>
