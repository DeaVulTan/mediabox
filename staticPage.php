<?php
/**
 * File handling open static Pages WriteMode
 *
 * PHP version 5.0
 *
 * @category	###Framework###
 * @package		###Index###
 * @author 		selvaraj_47ag04
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: staticPage.php 736 2008-05-26 06:34:50Z selvaraj_47ag04 $
 * @since 		2008-04-02
 */
require_once('common/configs/config.inc.php');
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include various types of files
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
require($CFG['site']['project_path'].'general/staticPage.php');
?>