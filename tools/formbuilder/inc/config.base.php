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
	require_once(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'fire.form.setting.php');


	// ~~~~~~~~~~~~ directory declartion
	define('DIR_ROOT_FF', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
	define('DIR_INC_FF', DIR_ROOT_FF . 'inc' . DIRECTORY_SEPARATOR);
	define('DIR_LANG_FF', DIR_ROOT_FF . 'lang' . DIRECTORY_SEPARATOR);
	define('DIR_ROOT_Q_FF', DIR_ROOT_FF . 'questions' . DIRECTORY_SEPARATOR);
	define('DIR_PEAR', DIR_ROOT_FF . 'PEAR' . DIRECTORY_SEPARATOR);
	define('DIR_THEME_FF', DIR_ROOT_FF . 'theme' . DIRECTORY_SEPARATOR);
	define('DIR_QUESTION_FF', DIR_ROOT_FF . 'questions' . DIRECTORY_SEPARATOR);
	define('DIR_ADMIN_FF', DIR_ROOT_FF . 'admin' . DIRECTORY_SEPARATOR);
	define('DIR_ADMIN_INC_FF', DIR_ADMIN_FF . 'inc' . DIRECTORY_SEPARATOR);
	define('DIR_ADMIN_CONTENT_FF', DIR_ADMIN_FF . 'content' . DIRECTORY_SEPARATOR);

	/// ~~~~~~~~~~~ table declaration
	define('TBL_USER', DB_PREFIX_FF . 'user');
	define('TBL_CATEGORY', DB_PREFIX_FF . 'category');
	define('TBL_QUESTION', DB_PREFIX_FF . 'question');
	define('TBL_INFO', DB_PREFIX_FF . 'info');
	define('TBL_RESPONDENT', DB_PREFIX_FF . 'respondent');


	// class

	define('CLASS_USER', DIR_INC_FF . 'class.user.php');
	define('CLASS_QUESTION', DIR_QUESTION_FF . 'class.question.php');
	// ~~~~~~~~~~~~~ System Config
	define('CONFIG_LANG_FF', 'en');
	define('CONFIG_DB_DEBUG', true);


	function strip_slashes2(&$str)
	{
		if(is_array($str))
		{
			while(list($key, $val) = each($str))
			{
				$str[$key] = strip_slashes2($val);
			}
		}
		elseif(is_string($str))
		{
			$str = stripslashes($str);
		}
		return $str;
	}
	if(
            (  function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc()  )
             || (  ini_get('magic_quotes_sybase') && ( strtolower(ini_get('magic_quotes_sybase')) != "off" )  )
           )
	{
		strip_slashes2($_GET);
		strip_slashes2($_POST);
		strip_slashes2($_COOKIE);
		strip_slashes2($_SESSION);
	}
	set_magic_quotes_runtime(false);
	@session_start();




































 	// ~~~~~~~~~~~~~~~ system init
	require_once(DIR_LANG_FF . CONFIG_LANG_FF . '.php');
	require_once(DIR_INC_FF . 'function.base.php');

	$includePaths = explode(PATH_SEPARATOR, ini_get('include_path'));
	$toBeIncluded = array(DIR_PEAR, DIR_PEAR . 'MDB2', DIR_PEAR . 'Spreadsheet', DIR_PEAR . 'OLE', DIR_PEAR . 'Spreadsheet' . DIRECTORY_SEPARATOR .  'Excel' );
	foreach ($includePaths as $k=>$v)
	{
		if((trim($v)) != '')
			unset($includePaths[$k]);
	}
	foreach ($toBeIncluded as $v)
	{
		$includePaths[] = $v;
	}
	ini_set('include_path', implode(PATH_SEPARATOR, $includePaths));
	require_once('MDB2.php');
	$dsn = array(
    'phptype'  => DB_TYPE_FF,
    'username' => DB_USERNAME_FF,
    'password' => DB_PASSWORD_FF,
    'port'     => DB_PORT_FF,
    'database' => DB_NAME_FF,
    'hostspec' => DB_HOST_FF,
    'debug'=>9,
	);

	$options = array(

	    'portability' => MDB2_PORTABILITY_ALL,
	    'use_transactions' => true,
	);
	$db =& MDB2::connect($dsn, $options);
	if (PEAR::isError($db))
	{
	    die(ERR_DB_CONN_FAILED);
	}
	$db->loadModule('Extended', null, false);
	$db->setFetchMode(MDB2_FETCHMODE_ASSOC);
	if(!$db->supports('transactions'))
	{
		die(ERR_DB_TRAN_FAILED);
	}
	if(defined('CONFIG_DB_DEBUG') && CONFIG_DB_DEBUG)
	{
	    function handle_pear_error ($error_obj)
	    {
	    	global $db;
			echo 'Error Message: ' . $error_obj->getMessage() . '<br>';
			echo 'Error Details: ' . $error_obj->getUserinfo() . '<br>';

	    }

	    PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'handle_pear_error');
	}


	require_once(DIR_INC_FF . 'class.msg.php');
	$msg = new Msg();
	require_once(DIR_INC_FF . 'class.fireform.php');
	$fireForm = new FireForm();



