<?php
/**
 * File to handle the config variables
 *
 * This file has various configuration variable required for the
 * entire project. Also using the special comment sytle for that
 * variable the admin can change the variable value from the
 * admin interface.
 *
 * PHP version 5.0
 *
 * @category	###Framework###
 * @package		###Common###
 * @author 		rajesh_04ag02
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		Release: @package_version@
 * @since 		2005-03-17
 */
// ==============================================================================
// 			Available special tags for editing configuration variable
// ==============================================================================
// @var <data type> <description>
// @cfg_sub_head <sub header label>
// @cfg_label <label of the config variable to display on editConfig page>
// @cfg_key <key name to edit config variable and it must be unique>
// @cfg_sec_name <config section label name to display in edit config page>
// @cfg_section <config section key name>
// @cfg_is_password <true/false>
// @cfg_arr_type <associative/key>
// Note : If the @cfg_arr_type is associative they the @cfg_arr_key and @cfg_arr_value are required.
//	   If the @cfg_arr_type is key then @cfg_arr_key is required.
// @cfg_arr_key <array key data type string/int>
// @cfg_arr_value <array value data type string/int>
// ==============================================================================
// error_reporting(0);
// ini_set('display_errors', 0);
$CFG['parse_time']['start'] = explode(' ', microtime());
//@todo improve time zone settings
if (function_exists('date_default_timezone_set')) //dirty hack for < 5.1.0
	date_default_timezone_set('Asia/Tashkent');
//@todo remove these lines.. it has to be present in loadconfig.inc.php or so
//if (! ini_get('safe_mode')) //safe mode has no effect
//		set_time_limit(300); //time limit on the execution of script...
//ignore_user_abort(true); //Don't allow user to stop

//site config
//$CFG['site']['url'] = 'http://localhost/framework/';
//or autodetect....


$CFG['site']['modules_arr'] = array('music', 'photo', 'blog', 'article', 'video', 'discussions');
$CFG['admin']['index']['home_module'] = 'discussions';
$folder_names_arr = array('common/', 'admin/', 'cron/', 'rss/','languages/', 'tools/OpenInviter/', 'dump_records/', 'tools/importer/');
$relative_modules_arr = array();
foreach($CFG['site']['modules_arr'] as $module)
{
	$relative_modules_arr[] = $module.'/';
}
$site_url_arr = array_merge($folder_names_arr , $relative_modules_arr);
$default_ports = array('https' => 443, 'http' => 80);
$prefix = (!empty($_SERVER['HTTPS']) ? 'https' : 'http');
$host = '';
if (isset($_SERVER['HTTP_HOST'])) //some says that this might not be set in IIS
		$host = $_SERVER['HTTP_HOST'];
	else if (isset($_SERVER['SERVER_NAME']))
		$host = $_SERVER['SERVER_NAME'];
$CFG['site']['host'] = $host;
 $CFG['site']['url'] = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://'
                       . $host
                       . str_replace(
					   			$site_url_arr,
					   			'',
								substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/')+1)
							);
$CFG['site']['url'] = strrpos($CFG['site']['url'], '/')==strlen($CFG['site']['url'])-1?$CFG['site']['url']:$CFG['site']['url'].'/';

foreach($CFG['site']['modules_arr'] as $module)
{
	$CFG['site'][$module.'_url']=$CFG['site']['url'].$module.'/';
}

$CFG['site']['relative_url'] = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://'
                       . $host
                       . substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/')+1);

$CFG['site']['itunes']['url'] = (!empty($_SERVER['HTTPS']) ? 'https' : 'itpc') . '://'
                       . $host
                       . str_replace(
					   			$site_url_arr,
					   			'',
								substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/')+1)
							);

$CFG['site']['current_url'] =  $prefix.
								(($_SERVER['SERVER_PORT']!=$default_ports[$prefix]) ?
								':'.$_SERVER['SERVER_PORT'] : '') . '://'
								.$host
								.$_SERVER['REQUEST_URI'];
//PATH_TRANSLATED is removed in SAPI version since PHP 5 or 4.3.2?? Don't use it for auto detection
//Important: Though DIRECTORY_SEPARATOR is always '\' under windows, $_SERVER variables are with '/' in some cases (in SAPI alone?). So fix it.
$slash = (stripos(php_sapi_name(), 'apache')!==false) ? '/' : DIRECTORY_SEPARATOR;
$CFG['site']['project_path'] = str_replace(
									array('\\') + $site_url_arr,
									array('/' ) + array_fill(0, count($folder_names_arr) + count($CFG['site']['modules_arr']), '' ),
								    substr($_SERVER['SCRIPT_FILENAME'], 0, strrpos($_SERVER['SCRIPT_FILENAME'], $slash)+1)
								);
$CFG['site']['project_path'] = strrpos($CFG['site']['project_path'], '/')==strlen($CFG['site']['project_path'])-1?$CFG['site']['project_path']:$CFG['site']['project_path'].'/';
$CFG['site']['project_path_relative'] = str_replace(
											array_merge(array('common/', 'admin/'), $relative_modules_arr),
											'',
											substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/')+1)
										);
$CFG['site']['project_path_relative'] = strrpos($CFG['site']['project_path_relative'], '/')==strlen($CFG['site']['project_path_relative'])-1?$CFG['site']['project_path_relative']:$CFG['site']['project_path_relative'].'/';
$CFG['site']['script_name'] = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], '/')+1);
//For div/page id, we need to form "adminfoofoofoo" when...
//$_SERVER['SCRIPT_NAME'] ~ /foo/project/admin/~foo.foo/foo.php
//$CFG['site']['project_path_relative'] ~ /foo/project/
$rel_file_pos = strlen($CFG['site']['project_path_relative']); //@todo optimize
$ext_pos = strrpos($_SERVER['SCRIPT_NAME'], '.php');

$page_id_with_ill_chars = substr($_SERVER['SCRIPT_NAME'], $rel_file_pos, $ext_pos-$rel_file_pos);
$page_id_with_ill_chars=str_replace($relative_modules_arr,'',$page_id_with_ill_chars);
$CFG['html']['page_id'] = str_replace( array('/', '.', '~'),  //remove chars that might affect CSS id
										'',
										$page_id_with_ill_chars);

$script_folder_arr=array('/', '.', '~', 'admin');
$script_folder_arr=array_merge($relative_modules_arr,$script_folder_arr);
$CFG['html']['current_script_name'] = str_replace( $script_folder_arr,  //remove chars that might affect CSS id
										'',
										$page_id_with_ill_chars);

$CFG['site']['query_string'] = substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME'])+strlen($_SERVER['SCRIPT_NAME'])+1);

$CFG['remote_client']['ip'] = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : ''; //@todo more work
$CFG['remote_client']['user_agent'] = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
$CFG['remote_client']['country_code'] = '';
$CFG['remote_client']['country_name'] = '';

//db connection
require_once($CFG['site']['project_path'].'common/configs/config_local.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_tables.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_db.inc.php');
require_once($CFG['site']['project_path'].'common/dbConnection.php');

//Config file path relative to admin folder used for parsing in editConfig.php
$CFG['config_path'] = '../common/configs/config_site.inc.php';
$CFG['feature']['payment_gateway'] = array('paypal'=>'Paypal');
//$CFG['ssl']['secure_pages'] = '*';
$CFG['ssl']['secure_pages'][] = $CFG['site']['project_path_relative'].'login.php';
$CFG['http_headers']['unmodified_pages'][] = '';
$CFG['redirect']['dsabled_module_url'] = $CFG['site']['url'];
$CFG['members_url'] = $CFG['site']['url'];
$CFG['main']['class_name'] = (isset($CFG['admin']['module']['members_banner']) and $CFG['admin']['module']['members_banner'])?'clsMain':'clsMain clsMainNoBanner';
$CFG['site']['set_default_charset_for_mysqlconnection'] = true;
$CFG['site']['default_charset_for_mysqlconnection'] = 'utf-8';


//----Test cases in standalone mode-----
//@todo Remove these lines for security reasons.
if (isset($CFG['debug']['debug_standalone_modules']) and $CFG['debug']['debug_standalone_modules'])
	{
		echo '<pre>'."\n";
		print_r($GLOBALS);
		//print_r($CFG);
		echo '</pre>'."\n";
	}

//$CFG['mods']['include_files'][] = ...
// include common config files
require_once($CFG['site']['project_path'].'common/configs/config_templates.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_site.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_lang.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_url.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_user.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_ver.inc.php');
//require_once($CFG['site']['project_path'].'common/configs/config_discussions.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_debugmode.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_redirecturl.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_auth.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_members.inc.php');
require_once($CFG['site']['project_path'].'common/classes/class_FormHandler.lib.php');
require_once($CFG['site']['project_path'].'common/classes/class_HeaderHandler.lib.php');
require_once($CFG['site']['project_path'].'common/license/config_license.inc.php');
require_once($CFG['site']['project_path'].'common/functions.php');

//When called from CRON file
if(isset($called_from_cron) AND $CFG['site']['cron_in_shell'])
{
	$CFG['site']['project_path'] = dirname(dirname(dirname(__FILE__))).'/';
	$CFG['site']['project_path_relative'] = dirname(dirname(dirname(__FILE__))).'/';
	$CFG['site']['url'] = $CFG['site']['cron_site_url'];
} 
?>