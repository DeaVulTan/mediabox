<?php
/**
 * This file is use for music album list
 *
 * This file is having create music album list page. Here we manage album list and search option.
 *
 *
 * @category	Rayzz/Music
 * @package		member
 *
 **/
require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_payment.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/transactionList.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/help.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['site']['is_module_page']='music';
$CFG['auth']['is_authenticate'] = 'members';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['admin']['calendar_page'] = true;
require($CFG['site']['project_path'].'common/application_top.inc.php');
if(isMember())
	$CFG['admin']['light_window_page'] = true;
require_once('general/listenerTransactionList.php');
?>