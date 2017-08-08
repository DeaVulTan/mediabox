<?php

/**
 * This file is to download the music
 *
 * This file is having MusicDownload class to download the music
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 * @author
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: memberMusicDownload.php 113 2007-06-18 05:43:17Z
 * @since
 *
 **/


require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_music.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/listenMusic.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['db']['is_use_db'] = true;
$CFG['site']['is_module_page']='music';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;

require_once($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/memberMusicDownload.php');
?>
