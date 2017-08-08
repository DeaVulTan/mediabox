<?php
/**
 * File handling list the blog tags
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Index
 * @author 		edwin_048at09
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2006-09-19
 */


require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/blog/blogTags.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_BlogHandler.lib.php';
$CFG['html']['header'] = 'blog/general/html_header_for_post.php';
$CFG['html']['footer'] = 'blog/general/html_footer_for_post.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['db']['is_use_db'] = true;
$CFG['site']['is_module_page']='blog';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/blogTags.php');
?>