<?php
/**
 * This file is to share the article
 *
 * This file is having ShareArticle class to share the article
 *
 * @category	Rayzz
 * @package		Index
 *
 **/

require_once('../common/configs/config.inc.php');

$CFG['lang']['include_files'][] = 'languages/%s/article/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/help.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/shareArticle.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['lang']['include_files'][] = 'common/classes/class_ArticleHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ArticleActivityHandler.lib.php';

$CFG['site']['is_module_page'] = 'article';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;

if(isset($_REQUEST['page']) and ($_REQUEST['page'] == 'article'))
	{
		$CFG['html']['header'] = 'general/html_header.php';
		$CFG['html']['footer'] = 'general/html_footer.php';
		$CFG['mods']['is_include_only']['html_header'] = false;
		$CFG['html']['is_use_header'] = false;
		$CFG['admin']['light_window_page'] = true;
	}
else
	{
		$CFG['html']['header'] = 'general/html_header_no_header.php';
		$CFG['html']['footer'] = 'general/html_footer_no_footer.php';
		$CFG['mods']['is_include_only']['html_header'] = false;
		$CFG['html']['is_use_header'] = false;
	}

require_once($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/shareArticle.php');
?>