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

	require_once(dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'config.base.php');
	//directory declaration
/*						foreach ($_POST as $k=>$v)
						{
							$info[$k . 'original']  = $v;
						}	*/

	require_once(DIR_INC_FF . 'function.form_edit.php');
	require_once(DIR_INC_FF . 'class.auth.php');
	$auth = new Auth($db, TBL_USER);

	
	//class
	define('CLASS_CONTENT_ADMIN', DIR_ADMIN_INC_FF . 'class.content.admin.php');
	
	
	//script
	
	//tab
	define('TAB_FORM', 'form');
	define('TAB_CONFIG', 'config');
	define('TAB_USER', 'user');
	define('TAB_INFO', 'info');
	define('TAB_LOG', 'log');
	//module
	define('MODULE_FORM', 'form');
	define('MODULE_LOG', 'log');
	define('MODULE_STATS', 'stats');
	define('MODULE_USER', 'user');
	define('MODULE_INFO', 'info');
	
	//action
	define('ACTION_EDIT', 'edit');
	define('ACTION_DELETE', 'delete');
	define('ACTION_LIST', 'list');
	define('ACTION_MANAGE', 'manage');
	define('ACTION_ADD', 'add');
	define('ACTION_SAVE', 'save');
	define('ACTION_REORDER', 'reorder');	
	//log type
	define('LOG_SURVEY_DELETE', 'survey_delete');
	define('LOG_SURVEY_UPDATE', 'survey_update');
	
	//URL to script

	//back-end system init
	if(!isset($_SESSION['fire_form_lang']))
	{
		$_SESSION['lang'] = CONFIG_LANG_FF;
	}
	include_once(DIR_LANG_FF . $_SESSION['lang'] . '.php');	

	include_once(DIR_ADMIN_INC_FF . 'function.admin.php');








	include_once(DIR_ADMIN_INC_FF . 'post.php');



	
	

	