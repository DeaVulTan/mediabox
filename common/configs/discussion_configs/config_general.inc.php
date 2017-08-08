<?php
/**
 * general config settings
 *
 * ..
 *
 * PHP version 5.0
 *
 * @category	..
 * @package		..
 * @author 		senthil_52ag05
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2008-12-19
 * @filesource
 **/
$CFG['admin']['bookmark_photos']['width'] = 17;
$CFG['admin']['bookmark_photos']['height'] = 17;
$CFG['admin']['bookmark_photos']['format_arr'] = array('image/jpg', 'image/pjpg', 'image/pjpeg', 'image/jpeg', 'image/gif');
$CFG['admin']['username_min_size'] = 3;
$CFG['admin']['username_max_size'] = 30;
$CFG['admin']['password_min_size'] = 4;
$CFG['admin']['password_max_size'] = 30;
$CFG['admin']['not_allowed_usernames'] = array('admin', 'members');
$CFG['admin']['display_name_min_size'] = 3;
$CFG['admin']['display_name_max_size'] = 30;
$CFG['redirect']['member'] = 'user';
$CFG['format']['date'] = '%D %b %y';
$CFG['news_letter']['send_count'] = 40;
$CFG['messages']['send_count'] = 10;
$CFG['admin']['tag_min_size'] = 3;
$CFG['admin']['tag_max_size'] = 10;
$CFG['admin']['bug_max_size'] = 500;
$CFG['admin']['use_profile_external_image'] = false;
$CFG['admin']['avatar_path'] = 'files/avatars/';
$CFG['admin']['bookmark_image_url'] = 'files/share/';
$CFG['admin']['logfile_path'] = '../files/log/';
$CFG['admin']['bookmark_temp_folder'] = 'files/share/temp_icons/';
$CFG['auth']['ajax_url'] = $CFG['site']['url'].'ajaxUrl.php';
$CFG['admin']['board']['tiny_length'] = 38;
$CFG['admin']['board']['line_length'] = 45;
$CFG['admin']['board']['short_length'] = 90;
$CFG['admin']['board']['inter_length'] = 100;
$CFG['admin']['board']['medium_length'] = 140;
$CFG['admin']['board']['index_line_length'] = 15;
$CFG['admin']['board']['index_short_length'] = 30;
$CFG['admin']['board']['total_length'] = 400;
$CFG['admin']['common']['line_length'] = 40;
$CFG['admin']['description']['line_length'] = 50;
$CFG['admin']['description']['short_length'] = 100;
$CFG['admin']['solution']['line_length'] = 50;
$CFG['admin']['solution_comment']['line_length'] = 30;
$CFG['admin']['comment']['limit'] = 500;
$CFG['username']['short_length'] = 10;
$CFG['username']['medium_length'] = 15;
$CFG['admin']['category']['line_length'] = 50;
$CFG['admin']['category']['short_length'] = 30;
$CFG['admin']['stats']['stats_line_length'] = 60;
$CFG['admin']['stats']['short_length'] = 30;
$CFG['admin']['latest_news']['line_length'] = 100;
//for editor
$CFG['fckeditor']['allowed_tags'] = array('b', 'i','span','font','img','sup','sub', 'hr', 'br', 'p', 'table','tr','td', 'div', 'strong', 'em', 'ul', 'h1', 'h2', 'h3', 'h4', 'h5', 'u', 'ol', 'li', 'dl', 'dd', 'dt', 'a');
$CFG['fckeditor']['allowed_attr'] = array('style','border', 'target','href', 'title', 'src', 'width', 'height','face','size','color', 'style');
//$CFG['admin']['banner']['impressions_date'] = true;
$CFG['admin']['index_scroll_time'] = 3;//in secs
$CFG['admin']['light_window_pages'] = array('boards', 'solutions');
$CFG['admin']['tooltip_pages'] = array('boards', 'editMembers', 'login', 'manageSettings', 'signup', 'verifyMail','addUser' );
$CFG['admin']['short_sidebar_pages'] = array('login', 'forgotpassword', 'signup', 'verifymail', 'invitations', 'reportbugs', 'rssfeeds', 'contactus', 'activateaccount', 'activatemailaccount', 'mail', 'mailcompose', 'mailread');
$CFG['admin']['short_sidebar_pages_1'] = array('login', 'forgotpassword', 'verifymail', 'invitations', 'reportbugs', 'rssfeeds', 'contactus', 'activateaccount', 'activatemailaccount', 'mail', 'mailcompose', 'mailread');
//transparent
$CFG['admin']['wmode_value'] = 'window';
//not allowed search array
$CFG['admin']['not_allowed_chars'] = array('?', '|', '{', '}', '^', '$', '(', ')', '[', ']', '#', '*', '+');
$CFG['admin']['suggest_records_allowed'] = 5;
$CFG['admin']['board']['suggest_line_length'] = 20;
$CFG['board']['send_count'] = 5;
/**
 * @var				int Number of records per pages
 * @cfg_sub_head 	General Settings
 * @cfg_label 		Number of records per pages (Minimum 2 and above recommended)
 * @cfg_key 		numpg
 * @cfg_sec_name
 * @cfg_section 	general_settings
 */
$CFG['data_tbl']['numpg'] = 10;
/**
 * @var				boolean is navigation top?
 * @cfg_label 		Is Navigation links displayed in top
 * @cfg_key 		top_navigation
 */
$CFG['admin']['navigation']['top'] = true;
/**
 * @var				boolean is navigation bottom?
 * @cfg_label 		Is Navigation links displayed in bottom
 * @cfg_key 		bottom_navigation
 */
$CFG['admin']['navigation']['bottom'] = true;
/**
 * @var				int Top contributors - past week data refresh
 * @cfg_label 		Refresh time for "Top contributors - Last week" (Give in minutes)
 * @cfg_key 		admin_week_experts_refresh
 * @cfg_sub_head	Top Contributor Settings
 */
$CFG['admin']['week_experts']['refresh'] = 10;
$CFG['admin']['default']['days'] = 30;
/**
 * @var				boolean Is appending meta details allowed
 * @cfg_sub_head 	Meta Details
 * @cfg_label 		Is meta details appending allowed
 * @cfg_key 		meta_appendable
 */
$CFG['html']['meta']['appendable'] = true;
/**
 * @var				int meta min characters
 * @cfg_label 		Minimum characters allowed to append
 * @cfg_key 		meta_min_characters_appendable
 */
$CFG['html']['meta']['min_characters_appendable'] = 0;
$CFG['admin']['attachments']['image_formats'] = array('jpg', 'gif', 'png', 'bmp', 'jpeg');
?>