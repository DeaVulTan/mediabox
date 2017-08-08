<?php
/**
 * This file is to play the music
 *
 * This file is having ViewVideo class to play the music
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 * @author
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: viewVideo.php 2986 2006-12-29 05:25:10Z selvaraj_35ag05 $
 * @since 		2006-05-02
 *
 **/
require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_music.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/myDashBoard.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/common.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/help.inc.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['site']['is_module_page']='music';
$CFG['auth']['is_authenticate'] = 'members';
$CFG['feature']['auto_hide_success_block']=false;
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/myDashBoard.php');

?>