<?php
/**
 * This file is to view the blog post
 *
 *
 * This file is having ViewPost class to view the blog post
 *
 *
 * @category	Rayzz
 * @package		Index
 **/
require_once('../common/configs/config.inc.php');
$CFG['site']['is_module_page'] = 'blog';
$CFG['lang']['include_files'][] = 'languages/%s/blog/viewPost.php';
$CFG['lang']['include_files'][] = 'languages/%s/blog/flag_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/blog/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';

$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_BlogHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_BlogActivityHandler.lib.php';

$CFG['html']['header'] = 'blog/general/html_header_for_post.php';
$CFG['html']['footer'] = 'blog/general/html_footer_for_post.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;

if (isset($_REQUEST['mem_auth']) AND $_REQUEST['mem_auth'])
{
	$CFG['auth']['is_authenticate'] = 'members';
}

if(isset($_REQUEST['type']) and ($_REQUEST['type'] == 'add_comment' or $_REQUEST['type'] == 'comment_reply'))
{
	$CFG['admin']['light_window_page'] = true;
}
require($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/viewPost.php');
?>