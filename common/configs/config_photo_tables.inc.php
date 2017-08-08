<?php
/**
 * File to handle the Music module table config  variables
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
 * @author 		vijay_84ag08
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
$CFG['db']['tbl']['photo_category'] = 'photo_category';
$CFG['db']['tbl']['photo'] = 'photo';
$CFG['db']['tbl']['photo_tags'] = 'photo_tags';
$CFG['db']['tbl']['photo_favorite'] = 'photo_favorite';
$CFG['db']['tbl']['photo_featured'] = 'photo_featured';
$CFG['db']['tbl']['photo_viewed'] = 'photo_viewed';
$CFG['db']['tbl']['photo_album'] = 'photo_album';
$CFG['db']['tbl']['photo_comments'] = 'photo_comments';
$CFG['db']['tbl']['photo_rating'] = 'photo_rating';
$CFG['db']['tbl']['photo_user_default_setting']='photo_user_default_setting';
$CFG['db']['tbl']['photo_files_settings'] = 'photo_files_settings';
$CFG['db']['tbl']['photo_activity'] = 'photo_activity';
$CFG['db']['tbl']['photo_meta_data'] = 'photo_meta_data';
$CFG['db']['tbl']['photo_mass_uploader_file_details'] = 'photo_mass_uploader_file_details';
$CFG['db']['tbl']['photo_mass_uploader_record_details'] = 'photo_mass_uploader_record_details';
$CFG['db']['tbl']['photo_mass_uploader_photo_details'] = 'photo_mass_uploader_photo_details';
$CFG['db']['tbl']['photo_people_tag'] = 'photo_people_tag';
$CFG['db']['tbl']['photo_playlist'] = 'photo_playlist';
$CFG['db']['tbl']['photo_in_playlist'] = 'photo_in_playlist';
$CFG['db']['tbl']['photo_playlist_viewed'] = 'photo_playlist_viewed';
?>