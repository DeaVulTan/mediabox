<?php
/**
 *
 * @category	rayzz
 * @package		Members
 **/
require_once('../common/configs/config.inc.php');

$CFG['site']['is_module_page'] = 'music';

if(isset($_REQUEST['mem_auth']) && $_REQUEST['mem_auth'] == true)
{
	$CFG['auth']['is_authenticate'] = 'members';
}

$CFG['lang']['include_files'][] = 'languages/%s/music/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/listenMusic.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/viewPlaylist.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/flag_list_array.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/blogger/NgeblogAccess.php';
$CFG['mods']['include_files'][] = 'common/classes/recaptchalib.php';

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
require($CFG['site']['project_path'].'common/application_top.inc.php');
if(isMember())
	$CFG['admin']['light_window_page'] = true;
require_once('general/listenMusic.php');
?>