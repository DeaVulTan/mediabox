<?php
/**
 * File to handle the Blog module table config  variables
 *
 * This file has various configuration variable required for the
 * entire project. Also using the special comment sytle for that
 * variable the admin can change the variable value from the
 * admin interface.
 *
 * PHP version 5.0
 *
 * @category	###Framework###
 * @package		###Common###
 * @author 		edwin_048at09
 * @copyright	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		Release: @package_version@
 * @since 		2009-06-26
 */
// ==============================================================================
// 			Available special tags for editing configuration variable
// ==============================================================================
// @var <data type> <description>
// @cfg_sub_head <sub header label>
// @cfg_label <label of the config variable to display on editConfig page>
// @cfg_key <key name to edit config variable and it must be unique>
// @cfg_sec_name <config section label name to display in edit config page>
// @cfg_section <config section key name>
// @cfg_is_password <true/false>
// @cfg_arr_type <associative/key>
// Note : If the @cfg_arr_type is associative they the @cfg_arr_key and @cfg_arr_value are required.
//	   If the @cfg_arr_type is key then @cfg_arr_key is required.
// @cfg_arr_key <array key data type string/int>
// @cfg_arr_value <array value data type string/int>
// ==============================================================================
$CFG['db']['tbl']['blog_category'] = 'blog_category';
$CFG['db']['tbl']['blogs'] = 'blogs';
$CFG['db']['tbl']['blog_posts'] = 'blog_posts';
$CFG['db']['tbl']['blog_tags'] = 'blog_tags';
$CFG['db']['tbl']['blog_favorite'] = 'blog_favorite';
$CFG['db']['tbl']['blog_featured'] = 'blog_featured';
$CFG['db']['tbl']['blog_viewed'] = 'blog_viewed';
$CFG['db']['tbl']['blog_comments'] = 'blog_comments';
$CFG['db']['tbl']['blog_rating'] = 'blog_rating';
$CFG['db']['tbl']['blog_activity'] = 'blog_activity';
?>