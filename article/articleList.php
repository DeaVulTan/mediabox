<?php
/**
 * This file is to display the article list
 *
 * This file is having ArticleList class to list the articles
 *
 *
 * @category	Rayzz
 * @package		Index
 */
require_once('../common/configs/config.inc.php');
$CFG['site']['is_module_page'] = 'article';
$CFG['lang']['include_files'][] = 'languages/%s/article/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/articleList.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ArticleHandler.lib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
//Condition added to access specified pages only  by logged in members
$memberArticleListAccessPages = array('myarticles','publishedarticle', 'toactivate', 'notapproved', 'draftarticle', 'infuturearticle', 'myfavoritearticles');
if (isset($_REQUEST['pg']) AND in_array($_REQUEST['pg'],$memberArticleListAccessPages))
{
	$CFG['auth']['is_authenticate'] = 'members';
}
require($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/articleList.php');
?>