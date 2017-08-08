<?php
/**
 * FireForm is a web based form builder enpowed by jquery javascript library and PHP
 * We are specilized in Website Development, Online Survey Creation, Online Shopping Site Design,
 * Please contact me if you need any such web-based information system
 * my email address ccc19800408-phpletter(@)yahoo(dot)com(dot)cn
 * please replace (@) with @, (dot) with . when sending email to me
 * thanks.
 * @author logan cai
 * @package FireForm a Ajax Form Builder
 * @version 1.0
 *
 *
 */
 require_once(dirname(dirname(dirname(__FILE__))).'/common/configs/config_db.inc.php');
 $projectUrlExplode=explode('admin',$_SERVER['SCRIPT_NAME']);
 $projectUrl=$projectUrlExplode[0];
	// ~~~~~~~~~~~~~ db setting
	define('DB_HOST_FF', $CFG['db']['hostname']);
	define('DB_NAME_FF', $CFG['db']['name']);
	define('DB_USERNAME_FF', $CFG['db']['username']);
	define('DB_PASSWORD_FF', $CFG['db']['password']);
	define('DB_PORT_FF', '3306');
	define('DB_PREFIX_FF', 'users_profile_');
	define('DB_TYPE_FF', 'mysql');

	// email setting
	define('EMAIL_SERVER_TYPE', 'SendMail'); //smtp, SendMail,mail
	define('EMAIL_SERVER_HOST', '');
	define('EMAIL_SERVER_PORT', '25');
	define('EMAIL_SERVERY_AUTH_REQUIRED', false);
	define('EMAIL_SERVER_USERNAME', '');
	define('EMAIL_SERVER_PASSWORD', '');

	//url
	define('URL_SITE', 'http://' .  $_SERVER['HTTP_HOST'].$projectUrl.'tools/formbuilder/');
	define('URL_JS', URL_SITE . 'js/' );
	define('URL_THEME', URL_SITE . 'theme/');
	define('URL_ADMIN', URL_SITE . 'admin/');
	define('URL_ADMIN_CSS', URL_ADMIN . 'css/');
	define('URL_SITE_ADMIN_LOGIN', URL_ADMIN . 'login.php');
	define('URL_SITE_ADMIN_INDEX', URL_ADMIN . 'index.php');