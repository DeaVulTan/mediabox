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
  * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
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

$CFG['db']['tbl']['music'] = 'music';
$CFG['db']['tbl']['music_category'] = 'music_category';
$CFG['db']['tbl']['music_artist_category'] = 'music_artist_category';
$CFG['db']['tbl']['music_comments'] = 'music_comments';
$CFG['db']['tbl']['music_favorite'] = 'music_favorite';
$CFG['db']['tbl']['music_featured'] = 'music_featured';
$CFG['db']['tbl']['music_rating'] = 'music_rating';
$CFG['db']['tbl']['music_viewed'] = 'music_viewed';
$CFG['db']['tbl']['music_album'] = 'music_album';
$CFG['db']['tbl']['music_playlist'] = 'music_playlist';
$CFG['db']['tbl']['music_in_playlist'] = 'music_in_playlist';
$CFG['db']['tbl']['music_tags'] = 'music_tags';
$CFG['db']['tbl']['music_files_settings'] = 'music_files_settings';
$CFG['db']['tbl']['music_playlist'] = 'music_playlist';
$CFG['db']['tbl']['music_playlist_tags'] = 'music_playlist_tags';
$CFG['db']['tbl']['music_playlist_viewed'] = 'music_playlist_viewed';
$CFG['db']['tbl']['music_playlist_comments'] = 'music_playlist_comments';
$CFG['db']['tbl']['music_playlist_featured'] = 'music_playlist_featured';
$CFG['db']['tbl']['music_playlist_favorite'] = 'music_playlist_favorite';
$CFG['db']['tbl']['music_playlist_rating'] = 'music_playlist_rating';
$CFG['db']['tbl']['music_playlist_listened'] = 'music_playlist_listened';
$CFG['db']['tbl']['music_album_viewed'] = 'music_album_viewed';
$CFG['db']['tbl']['music_album_listened'] = 'music_album_listened';
$CFG['db']['tbl']['music_artist'] = 'music_artist';
$CFG['db']['tbl']['music_artist_image'] = 'music_artist_image';
$CFG['db']['tbl']['music_lyric'] = 'music_lyric';
$CFG['db']['tbl']['music_activity'] = 'music_activity';
$CFG['db']['tbl']['music_listened'] = 'music_listened';
$CFG['db']['tbl']['music_artist_viewed'] = 'music_artist_viewed';
$CFG['db']['tbl']['music_advertisement'] = 'music_advertisement';
$CFG['db']['tbl']['music_other_format_downloads'] = 'music_other_format_downloads';
$CFG['db']['tbl']['music_user_default_settings'] = 'music_user_default_settings';
$CFG['db']['tbl']['music_user_payment_settings'] = 'music_user_payment_settings';
$CFG['db']['tbl']['music_album_purchase_user_details'] = 'music_album_purchase_user_details';
$CFG['db']['tbl']['user_transaction_log'] = 'user_transaction_log';
$CFG['db']['tbl']['music_order'] = 'music_order';
$CFG['db']['tbl']['music_purchase_user_details'] = 'music_purchase_user_details';
$CFG['db']['tbl']['music_artist_promo_image'] = 'music_artist_promo_image';
$CFG['db']['tbl']['artist_fans_list'] = 'artist_fans_list';
$CFG['db']['tbl']['music_artist_member_image'] = 'music_artist_member_image';
$CFG['db']['tbl']['trim_music_cron'] = 'trim_music_cron';
$CFG['db']['tbl']['music_top_chart_cron'] = 'music_top_chart_cron';
$CFG['db']['tbl']['music_song_top_chart'] = 'music_song_top_chart';
$CFG['db']['tbl']['music_album_top_chart'] = 'music_album_top_chart';
$CFG['db']['tbl']['music_artist_top_chart'] = 'music_artist_top_chart';
$CFG['db']['tbl']['music_featured_content']	= 'music_featured_content';
$CFG['db']['tbl']['blog_post'] = 'blog_post';
?>