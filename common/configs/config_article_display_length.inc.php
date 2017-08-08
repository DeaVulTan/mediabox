<?php
/**
 * settings for $CFG['admin']['article']
 *
 * This file is to manage display length for articles
 *
 * PHP version 5.0
 *
 * @package		###Common###
 * @author 		naveenkumar_126at09
 * @copyright 	Copyright (c) 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 **/

/**
 * @var				int Article summary length
 * @cfg_label 		Article summary length
 * @cfg_key 		caption_length_list_view
 * @cfg_arr_type 	key
 * @cfg_arr_key 	string
 * @cfg_sub_head	Article List
 */
$CFG['admin']['articles']['caption_length_list_view'] = 130;
/**
 * @var				int Article summary total char size
 * @cfg_label 		Article summary total character size
 * @cfg_key 		summary_total_char_list_view
 * @cfg_arr_type 	key
 * @cfg_arr_key 	string
 */
$CFG['admin']['articles']['summary_total_char_list_view'] = 300;
/**
 * @var				int Article description length
 * @cfg_label 		Article description length
 * @cfg_key 		caption_length_share_article
 * @cfg_arr_type 	key
 * @cfg_arr_key 	string
 * @cfg_sub_head	Share Article
 */
$CFG['admin']['articles']['caption_length_share_article'] = 90;
/**
 * @var				int Article description total char size
 * @cfg_label 		Article description total character size
 * @cfg_key 		description_total_char_share_article
 * @cfg_arr_type 	key
 * @cfg_arr_key 	string
 */
$CFG['admin']['articles']['description_total_char_share_article'] = 200;

//Article common variables
$CFG['admin']['articles']['list_title_length']        = 15;
$CFG['admin']['articles']['list_title_total_length']  = 20;

//article list
$CFG['admin']['articles']['list_per_line_total_articles'] = 1;
$CFG['admin']['articles']['total_related_article'] = 4;
$CFG['admin']['articles']['related_photo_per_row'] = 4;
$CFG['article_tbl']['numpg'] = 10;//16;
$CFG['admin']['articles']['title_length_list_view'] = 150;
$CFG['admin']['articles']['title_total_length_list_view'] = 80;
$CFG['admin']['articles']['tags_count_list_page'] = 4;
$CFG['admin']['articles']['article_list_category_title'] = 80;
$CFG['admin']['articles']['article_list_category_title_total_length'] = 85;
$CFG['admin']['articles']['catergory_list_per_row'] = 4;

//Article tags sidebar
$CFG['admin']['articles']['sidebar_clouds_name_length']        = 15;
$CFG['admin']['articles']['sidebar_clouds_name_total_length']  = 20;
$CFG['admin']['articles']['sidebar_clouds_num_record']		   = 20;

//List Article tags
$CFG['admin']['articles']['member_article_tags_name_length']               = 20;
$CFG['admin']['articles']['member_article_tags_name_total_length']         = 13;
$CFG['admin']['articles']['member_article_tags_keyword_total_length']      = 10;

//Article activity
$CFG['admin']['articles']['activity_title_length'] =15;
$CFG['admin']['articles']['activity_title_total_length'] =15;

//view Article
$CFG['admin']['articles']['total_comments'] = 10;
$CFG['admin']['articles']['article_view_caption_length'] = 55;

//View Article (More Articles)
$CFG['admin']['articles']['more_article_summary_length_list_view'] = 90;
$CFG['admin']['articles']['more_article_summary_total_length_list_view'] = 80;

//View Article (Table Of Contents)
$CFG['admin']['articles']['article_view_table_of_content_title_length'] = 25;
$CFG['admin']['articles']['article_view_table_of_content_total_length'] = 30;

//List Article page title for category
$CFG['admin']['articles']['article_list_category_page_title_length']        = 50;
$CFG['admin']['articles']['article_list_category_page_title_total_length']  = 30;

//sidebar
$CFG['admin']['articles']['sidebar_genres_num_record']		  = 6;
$CFG['admin']['articles']['sidebar_genres_name_length']       = 15;
$CFG['admin']['articles']['sidebar_genres_name_total_length'] = 20;

//Article Manage comments
$CFG['admin']['articles']['member_article_comments_length'] = 20;
$CFG['admin']['articles']['member_article_comments_total_length'] = 30;

//Article category
$CFG['admin']['articles']['admin_article_category_name_length']=20;
$CFG['admin']['articles']['member_article_category_name_length']              = 15;
$CFG['admin']['articles']['member_article_category_name_total_length']        = 18;
$CFG['admin']['articles']['member_article_category_description_length']       = 18;
$CFG['admin']['articles']['member_article_category_description_total_length'] = 20;

//Article index page
$CFG['admin']['articles']['indexarticleblock_username_title_length']       = 12;
$CFG['admin']['articles']['indexarticleblock_username_title_total_length'] = 15;

$CFG['admin']['articles']['indexarticleblock_article_title_length']       = 130;
$CFG['admin']['articles']['indexarticleblock_article_title_total_length'] = 60;

$CFG['admin']['articles']['indexarticleblock_caption_list_length']      = 210;
$CFG['admin']['articles']['indexarticleblock_caption_list_total_length']= 250;

//myprofile block
$CFG['admin']['articles']['profile_myarticle_block_article_title_length']        = 75;
$CFG['admin']['articles']['profile_myarticle_block_article_title_total_length'] = 50;

$CFG['admin']['articles']['profile_myarticle_block_article_summary_length']        = 75;
$CFG['admin']['articles']['profile_myarticle_block_article_summary_total_length'] = 60;
?>