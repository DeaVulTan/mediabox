<?php
/**
 * settings for $CFG['admin']['article']
 *
 *
 * PHP version 5.0
 *
 * @package		###Common###
 * @author 		sathish_040at09
 * @copyright 	Copyright (c) 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 **/
$CFG['admin']['articles']['folder']						= 'articles';
$CFG['admin']['articles']['temp_folder']				= 'temp_articles';
$CFG['admin']['articles']['article_image_folder']		= 'files/article_image/';
$CFG['admin']['articles']['temp_article_image_folder']  = 'files/temp_files/temp_article_image/';

$CFG['admin']['articles']['sub_category'] = true;
/**
 * @#var			boolean Article Self Rating
 * @#cfg_label 		Article Self Ratings
 * @#cfg_key 		allow_self_ratings
 * @#cfg_arr_type 	key
 * @#cfg_arr_key 	string
 */
$CFG['admin']['articles']['allow_self_ratings'] = true;
/**
 * @#var			boolean Article attachment compulsory
 * @#cfg_label 		Article attachment compulsory
 * @#cfg_key 		article_attachment_compulsory
 * @#cfg_arr_type 	key
 * @#cfg_arr_key 	string
 */
$CFG['admin']['articles']['article_attachment_compulsory'] = false;
/**
 * @#var			array Allowed Article Formats
 * @#cfg_label 		Allowed Article Image Formats
 * @#cfg_key 		format_arr
 * @#cfg_arr_type 	key
 * @#cfg_arr_key 	string
 */
$CFG['admin']['articles']['articles_format_arr'] = array('jpg', 'jpeg', 'gif', 'png');
/**
 * @#var				boolean Allow edit article description after activate
 * @#cfg_label 		Allow edit article description after activate
 * @#cfg_key 		allow_edit_article_description
 */
$CFG['admin']['articles']['allow_edit_article_description'] = true;
/**
 * @#var				boolean Show Most Viewied Articles
 * @#cfg_label 		Show Recommended Viewed
 * @#cfg_key 		mostviewedarticle
 * @#cfg_sec_name 	Index Page Settings
 * @#cfg_section 	index_page_articles_settings
 */
$CFG['admin']['articles']['mostviewedarticle'] = true;
$CFG['admin']['articles']['mostviewedarticle_total_record'] = 4;
/**
 * @#var				boolean Show Toprated article
 * @#cfg_label 		Show Toprated article
 * @#cfg_key 		topratedarticle
 */
$CFG['admin']['articles']['topratedarticle'] = true;
$CFG['admin']['articles']['topratedarticle_total_record'] = 4;
/**
 * @#var				boolean Most Favorite Article
 * @#cfg_label 		Show Most Favorite Article
 * @#cfg_key 		mostfavoritearticle
 */
$CFG['admin']['articles']['mostfavoritearticle'] = true;
$CFG['admin']['articles']['mostfavorite_total_record'] = 4;
/**
 * @#var				boolean Most Discussed Article
 * @#cfg_label 		Show Most Discussed Article
 * @#cfg_key 		mostdiscussedarticle
 */
$CFG['admin']['articles']['mostdiscussedarticle'] = true;
$CFG['admin']['articles']['mostdiscussed_total_record'] = 4;
/**
 * @#var				boolean Show added Listened article
 * @#cfg_label 		Show Recently added article
 * @#cfg_key 		mostrecentarticle
 */
$CFG['admin']['articles']['mostrecentarticle'] = true;
$CFG['admin']['articles']['recentlyaddedarticle_total_record'] = 4;

//Article Auto activation time
$CFG['admin']['articles']['article_auto_activate_time'] = 0;

//Article common variables
$CFG['admin']['articles']['image_max_size'] = 250;
$CFG['admin']['articles']['title_length'] = 150;
$CFG['admin']['articles']['summary_length'] = 250;
$CFG['admin']['members']['article_icon_title']  =  '%s Articles';

//Article index page
$CFG['admin']['articles']['sidebar_top_contributors'] = 4;

// My, Friends, All
$CFG['admin']['articles']['article_activity_default_content']= 'My';

//view Article
$CFG['admin']['articles']['comment_edit_allowed_time']= 120;

//Profile Block
$CFG['admin']['articles']['profile_page_total_article'] = 4;
$CFG['profile_box_id']['myarticles_list'] = 'selUserMyArticle';

//banner
$CFG['admin']['article_banner']['sidebanner1_250x250_not_allowed_pages'] = array('articlelist');
$CFG['admin']['article_banner']['sidebanner2_250x250_not_allowed_pages'] = array();

//Article Manage comments
$CFG['admin']['articles']['member_article_comments_length'] = 20;
$CFG['admin']['articles']['member_article_comments_total_length'] = 30;

//Article tags
$CFG['fieldsize']['article_tags']['min'] = $CFG['fieldsize']['tags']['min'];
$CFG['fieldsize']['article_tags']['max'] = $CFG['fieldsize']['tags']['max'];

//Article category
$CFG['admin']['articles']['category_height']            = 101;
$CFG['admin']['articles']['category_width']             = 132;
$CFG['admin']['articles']['category_image_max_size']    = 400;
$CFG['admin']['articles']['category_folder']            = 'files/article_category/';
$CFG['admin']['articles']['category_image_format_arr']  = array('jpg', 'jpeg', 'gif');
$CFG['admin']['articles']['article_no_image']           ='no_image.jpg';
$CFG['admin']['articles']['category_accept_max_length'] = 70;

//Assign Global Config Variable adult_content_view,adult_minimum_age to articles variable respectively *Do not move this variable to db.
$CFG['admin']['articles']['adult_content_view'] = $CFG['admin']['site']['adult_content_view'];
$CFG['admin']['articles']['adult_minimum_age'] = $CFG['admin']['site']['adult_minimum_age'];

require_once($CFG['site']['project_path'].'common/configs/config_article_url.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_article_tables.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_article_display_length.inc.php');
?>