<?php
/**
 * settings for $CFG['admin']['blog']
 *
 * ..
 *
 * PHP version 5.0
 *
 * @category	..
 * @package		..
 * @author 		edwin_048at09
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: config_blog.inc.php 2895 2006-12-07 11:53:08Z edwin_048at09 $
 * @since 		2010-03-29
 * @filesource
 **/
$CFG['admin']['blog']['folder'] = 'blogs';
$CFG['admin']['blog']['blog_logo_folder'] = 'blog_logos';
$CFG['admin']['blog']['temp_folder'] = 'temp_blog_logos';
$CFG['admin']['blog']['blog_post_image_folder']		= 'files/blogs/temp_blog_post_image/';
$CFG['admin']['blog']['temp_blog_post_image_folder']  = 'files/temp_files/temp_blog_post_image/';

$CFG['admin']['blog']['logo_width'] = 1000;
$CFG['admin']['blog']['logo_height'] = 90;
$CFG['admin']['blog']['logo_max_size'] = 500;
$CFG['admin']['blog']['logo_image_format_arr'] = array('jpg', 'jpeg', 'gif', 'png');

$CFG['admin']['members']['blog_icon_title'] = '%s Blogs';

$CFG['admin']['blog']['post_auto_activate_time'] = 0;

$CFG['admin']['blog']['blog_post_title_length'] = 50;

// My, Friends, All
$CFG['admin']['blog']['blog_activity_default_content']= 'My';

//user All Updates
$CFG['admin']['blog']['activity_title_length'] =15;
$CFG['admin']['blog']['activity_title_total_length'] =15;
$CFG['admin']['blog']['list_per_line_total_blog_post'] = 1;
$CFG['admin']['blog']['title_length_list_view'] = 150;
$CFG['admin']['blog']['title_total_length_list_view'] = 80;
$CFG['admin']['blog']['blog_list_category_title'] = 20;
$CFG['admin']['blog']['blog_list_category_title_total_length'] = 30;
$CFG['admin']['blog']['tags_count_list_page'] = 4;
$CFG['admin']['blog']['member_blog_post_tags_name_length']               = 20;
$CFG['admin']['blog']['member_blog_post_tags_name_total_length']         = 13;
$CFG['admin']['blog']['member_blog_post_tags_keyword_total_length']      = 10;
$CFG['admin']['blog']['blog_list_category_page_title_length']        = 50;
$CFG['admin']['blog']['blog_list_category_page_title_total_length']  = 30;
$CFG['blog_tbl']['numpg'] = 10;

//view post
$CFG['admin']['blog']['total_comments'] = 10;
$CFG['admin']['blog']['blog_view_message_length'] = 55;
$CFG['admin']['blog']['comment_edit_allowed_time']= 120;

$CFG['admin']['blog']['total_related_post'] = 4;
$CFG['admin']['blog']['adult_minimum_age']= 18;
//Post Manage comments
$CFG['admin']['blog']['member_blog_comments_length'] = 20;
$CFG['admin']['blog']['member_blog_comments_total_length'] = 30;

$CFG['admin']['blog']['sidebar_category_num_record']=5;
$CFG['admin']['blog']['sidebar_category_name_length']=20;
$CFG['admin']['blog']['sidebar_category_name_total_length']=25;

//blog category
$CFG['admin']['blog']['category_height']            = 79;
$CFG['admin']['blog']['category_width']             = 106;
$CFG['admin']['blog']['category_image_max_size']    = 400;
$CFG['admin']['blog']['category_folder']            = 'files/blog_category/';
$CFG['admin']['blog']['category_image_format_arr']  = array('jpg', 'jpeg', 'gif');
$CFG['admin']['blog']['blog_no_image']             ='no_image.jpg';
$CFG['admin']['blog']['admin_blog_category_name_length']=20;

$CFG['admin']['blog']['catergory_list_per_row']     =3;
$CFG['admin']['blog']['member_blog_category_name_length']              = 15;
$CFG['admin']['blog']['member_blog_category_name_total_length']        = 18;
$CFG['admin']['blog']['member_blog_category_description_length']       = 20;
$CFG['admin']['blog']['member_blog_category_description_total_length'] = 22;

//Blog Manage comments
$CFG['admin']['blog']['member_blog_comments_length'] = 20;
$CFG['admin']['blog']['member_blog_comments_total_length'] = 30;

//admin
$CFG['admin']['blog']['admin_blog_category_title_length'] =35;
$CFG['admin']['blog']['blog_category_title_length']       =35;


$CFG['admin']['blog']['sidebar_clouds_num_record']=20;
$CFG['admin']['blog']['sidebar_clouds_name_length']             = 15;
$CFG['admin']['blog']['sidebar_clouds_name_total_length']       = 20;
$CFG['admin']['blog']['list_title_length']        = 15;
$CFG['admin']['blog']['list_title_total_length']  = 16;

//Assign Global Config Variable adult_content_view,adult_minimum_age to blogs variable respectively *Do not move this variable to db.
$CFG['admin']['blog']['adult_content_view'] = $CFG['admin']['site']['adult_content_view'];
$CFG['admin']['blog']['adult_minimum_age'] = $CFG['admin']['site']['adult_minimum_age'];

//banner
$CFG['admin']['blog_banner']['sidebanner1_250x250_not_allowed_pages'] = array('manageblog');
$CFG['admin']['blog_banner']['sidebanner2_250x250_not_allowed_pages'] = array();

$CFG['admin']['blog']['blog_name_min_length']        = 3;
$CFG['admin']['blog']['blog_name_max_length']        = 20;

require_once($CFG['site']['project_path'].'common/configs/config_blog_tables.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_blog_url.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_blog_fieldsize.inc.php');
?>