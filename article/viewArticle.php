<?php
/**
 * This file is to play the article
 *
 *
 * This file is having ViewArticle class to play the article
 *
 *
 * @category	Rayzz
 * @package		Index
 **/
require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_article.inc.php');

$CFG['lang']['include_files'][] = 'languages/%s/article/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/viewArticle.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/flag_list_array.inc.php';

$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ArticleHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ArticleActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/recaptchalib.php';



$CFG['db']['is_use_db'] = true;
$CFG['site']['is_module_page'] = 'article';

//compulsory
if(isset($_REQUEST['type']) and ($_REQUEST['type'] == 'add_comment' or $_REQUEST['type'] == 'comment_reply'))
{
	$CFG['html']['header'] = 'general/html_header_no_header.php';
	$CFG['html']['footer'] = 'general/html_footer_no_footer.php';
	$CFG['mods']['is_include_only']['html_header'] = false;
	$CFG['html']['is_use_header'] = false;
	$CFG['admin']['light_window_page'] = true;
	//To show session expired content inside lightwindow if session got expired
	$CFG['admin']['session_redirect_light_window_page'] = true;
}
else
{
	$CFG['html']['header'] = 'general/html_header.php';
	$CFG['html']['footer'] = 'general/html_footer.php';
	$CFG['mods']['is_include_only']['html_header'] = false;
	$CFG['html']['is_use_header'] = false;
}

if(isMember())
	$CFG['admin']['light_window_page'] = true;

//Condition added to access rating functionalty only  by logged in members
if (isset($_REQUEST['mem_auth']) AND $_REQUEST['mem_auth'])
{
	$CFG['auth']['is_authenticate'] = 'members';
}

require($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/viewArticle.php');
?>