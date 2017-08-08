<?php
/**
 * settings for $CFG['admin']['video']
 *
 * ..
 *
 * PHP version 5.0
 *
 * @category	..
 * @package		..
 * @author 		sridharan_08ag04
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: config_photo.inc.php 937 2006-05-30 08:26:06Z selvaraj_35ag05 $
 * @since 		2006-05-04
 * @filesource
 **/
//for data thumb purbose only -- no use
$CFG['admin']['videos']['base_path'] = 'http://localhost/projects/rayzz';

$CFG['admin']['videos']['folder'] = 'videos';
$CFG['admin']['videos']['video_folder'] = 'videos';
$CFG['admin']['videos']['thumbnail_folder'] = 'thumbnails';
$CFG['admin']['videos']['temp_folder'] = 'temp_videos';
$CFG['admin']['videos']['original_video_folder'] = 'original_videos';
$CFG['admin']['videos']['other_videoformat_folder']='other_format_videos';
$CFG['admin']['videos']['trimed_video_folder']='trimed_videos';

#FODLER NAME FOR STORING VIEW VIDEO PAGE BACKGROUND IMAGE
$CFG['admin']['videos']['background_image_folder']='video_background';

//tumb_name, small_name, large_name, medium_name are only S, T, L
$CFG['admin']['videos']['small_width'] = 107;
$CFG['admin']['videos']['small_height'] = 80;
$CFG['admin']['videos']['small_name'] = 'S';

$CFG['admin']['videos']['thumb_width'] = 142;
$CFG['admin']['videos']['thumb_height'] = 108;
$CFG['admin']['videos']['thumb_name'] = 'T';

$CFG['admin']['videos']['large_width'] = 320;
$CFG['admin']['videos']['large_height'] = 240;
$CFG['admin']['videos']['large_name'] = 'L';

//Not image generated, only for size
$CFG['admin']['videos']['medium_width'] = 140;
$CFG['admin']['videos']['medium_height'] = 140;
$CFG['admin']['videos']['medium_name'] = 'M';

$CFG['admin']['videos']['frame_width'] = 107;
$CFG['admin']['videos']['frame_height'] = 80;

$CFG['admin']['videos']['total_comments'] = 10;
$CFG['admin']['videos']['title_max_length'] = 200;
$CFG['admin']['videos']['get_code_max_size'] = 400;
$CFG['admin']['videos']['comment_edit_allowed_time']= 120;

$CFG['admin']['videos']['category_height'] = 80;
$CFG['admin']['videos']['category_width'] = 107;
$CFG['admin']['videos']['category_image_max_size'] = 400;
$CFG['admin']['videos']['category_folder'] = 'files/video_category/';
$CFG['admin']['videos']['category_image_format_arr'] = array('jpg', 'jpeg', 'gif');

$CFG['playlist_tbl']['numpg']=50;
$CFG['admin']['playlists']['tags_count_list_page']=4;

$CFG['admin']['videos']['index_numpg'] = 4;
//if total frame is 0 no frame will be created, maximum 3 frames only allowed
$CFG['admin']['videos']['total_frame'] = 3;
$CFG['admin']['videos']['advanced_download'] = false;
$CFG['admin']['videos']['redirect_download'] = true;
$CFG['admin']['videos']['rss_count'] = 20;
$CFG['admin']['videos']['tags_count_list_page'] = 4;
$CFG['admin']['videos']['list_thumb_detail_view']=true;
//for post comment
$CFG['admin']['videos']['disallowed_tag'] = array('script','select','title','textarea');
$CFG['admin']['videos']['disallowed_empty_tag'] = array('meta','!DOCTYPE','link','form','input','head','html','body', 'title');
$CFG['admin']['videos']['disallowed_style_class'] = array('body');
$CFG['admin']['videos']['disallowed_attributes'] = array();


$CFG['admin']['videos']['background_image_max_size']='2000';
$CFG['admin']['videos']['background_format_arr']=array('jpg', 'jpeg', 'gif','png');
$CFG['admin']['videos']['background_offset_size'] = 200;



/**
 * @#var				boolean auto_download_external_video
 * @#cfg_label 		Allow auto download of external video
 * @#cfg_key 		auto_download_external_video
 */
$CFG['admin']['videos']['auto_download_external_video'] = true;
/**
 * @#var				boolean Rotating Thumbnail JS Method
 * @#cfg_label 		Rotating Thumbnail JS Method
 * @#cfg_key 		rotating_thumbnail_js_method
 * @#cfg_sec_name 	Rotating Thumnail Feature
 * @#cfg_section 	rotating_thumbnail
 */
$CFG['admin']['videos']['rotating_thumbnail_js_method'] = false;
/**
 * @#var			boolean Gif Animation Backup Generation
 * @#cfg_label 	Gif Animation Backup Generation
 * @#cfg_key 	rotating_thumbnail_gif_backup
 */
$CFG['admin']['videos']['rotating_thumbnail_gif_backup'] = false;
/**
 * @#var			boolean show_available_thumbs
 * @#cfg_label 	Show available thumbnail in Video Page
 * @#cfg_key 	show_available_thumbs
 */
$CFG['admin']['videos']['show_available_thumbs'] = true;


/**
 * @var				string Watermark end time
 * @cfg_label 		Watermark end time
 * @cfg_key 		watermark_end_time
 */
$CFG['admin']['videos']['watermark_end_time'] = '00:01:20';

/**
 * @#var			boolean env_details_checking
 * @#cfg_label 		Checking for "video upload environment"(Like existing of mencoder, etc) when uploading video
 * @#cfg_key 		env_details_checking
 */
$CFG['admin']['videos']['env_details_checking'] = true;
/**
 * @#var				boolean env_details_list
 * @#cfg_label 		Giving environment details when "checking for video upload environment" is ON
 * @#cfg_key 		env_details_list
 */
$CFG['admin']['videos']['env_details_list'] = true;
$CFG['admin']['videos']['video_auto_activate_time'] = 0;


$CFG['admin']['videos']['logo_format_arr'] = array('jpg', 'png', 'swf');
$CFG['admin']['videos']['mini_logo_format_arr'] = array('jpg', 'swf');
$CFG['admin']['videos']['logo_max_size'] = 500;
$CFG['admin']['videos']['mini_logo_max_size'] = 500;
$CFG['admin']['videos']['logo_folder'] = 'files/video_logo/';
$CFG['admin']['videos']['logo_name'] = 'logo';
$CFG['admin']['videos']['mini_logo_name'] = 'mini_logo';

$CFG['admin']['videos']['advertisement_format_arr'] = array('jpg', 'swf', 'flv');
$CFG['admin']['videos']['advertisement_max_size'] = 500;
$CFG['admin']['videos']['advertisement_folder'] = 'files/video_advertisement/';
$CFG['admin']['videos']['video_caption_word_wrap_length']=40;
$CFG['admin']['videos']['video_caption_word_wrap_total_length']=100;
$CFG['admin']['videos']['video_comment_word_wrap_length']=40;
$CFG['admin']['videos']['video_title_word_wrap_length']=40;

/**
 * @#var				string Youtube download Format('5', '35','22')
 * @#cfg_label 		Youtube download Format
 * @#cfg_key 		youtube_download_format
 * @#cfg_arr_type 	key
 * @#cfg_arr_key 	string
 */
$CFG['admin']['videos']['youtube_download_format']='5';
# total records to list the videos in the video Response
$CFG['admin']['videos']['total_response_video'] = 5;
$CFG['admin']['videos']['total_related_video'] = 4;
$CFG['admin']['videos']['related_video_per_row'] = 2;
$CFG['video_tbl']['numpg'] = 20;
//Since youtube will block the site if the videos play from the youtube, So dont make it to false
$CFG['admin']['videos']['download_youtube_videos'] = true;
$CFG['admin']['videos']['download_google_videos'] = true;
//For dailymotion video is not playing in the player, So dont make it to false
$CFG['admin']['videos']['download_dailymotion_videos'] = false;
$CFG['admin']['videos']['download_myspace_videos'] = true;
$CFG['admin']['videos']['download_flvpath_videos'] = true;
/**
 * @#var				int Video description length
 * @#cfg_label 		Video description length
 * @#cfg_key 		caption_length_share_video
 * @#cfg_arr_type 	key
 * @#cfg_arr_key 	string
 * @#cfg_sub_head	Share Video
 */
$CFG['admin']['videos']['caption_length_share_video'] = 90;
/**
 * @#var				int Video description total char size
 * @#cfg_label 		Video description total character size
 * @#cfg_key 		description_total_char_share_video
 * @#cfg_arr_type 	key
 * @#cfg_arr_key 	string
 */
$CFG['admin']['videos']['description_total_char_share_video'] = 200;
/**
 * @#var			boolean Video Sub-category
 * @#cfg_label 		Video Sub-category
 * @#cfg_key 		sub_category
 * @#cfg_arr_type 	key
 * @#cfg_arr_key 	string
 */
$CFG['admin']['videos']['sub_category'] = true;


$CFG['admin']['log_video_upload_error'] = true;

#if its true backup of gif animation is also created, when the rotating_thumbnail Js method is On, So that at the middle of the stage we can switch off the Js method and Enable Gif method

## This confis is used to enable Js animation. If this is On & backup of gif generation is off then gif animation file will not be generated
//animated_gif_enable_js_animation is changed to rotating_thumbnail_js_method
# If Js method is Off & rotating_thumbnail_feature is ON gif Animation will be used for Rotating Thumbnail
## Changed to rotating_thumbnail_feature
//$CFG['admin']['videos']['animated_gif_enabled']=true;

## AS this Encoding is changed to videoToFrame , default start seconds will be used. This feature is no to be analysed
//$CFG['admin']['videos']['animated_gif_default_start_seconds']='00:00:02';

## AS Calulation for Skip step is used so below line is commented
//$CFG['admin']['videos']['animated_gif_default_sstep']=1;

## AS this Encoding is changed to videoToFrame , gif minmum seconds is replaced with minmum_video_length
//$CFG['admin']['videos']['animated_gif_minimum_seconds']=40;

##maximum no of frames for animation is to generated
#animated_gif_default_total_frames is changed to rotating_thumbnail_max_frames
//$CFG['admin']['videos']['animated_gif_default_total_frames']=10;
$CFG['admin']['videos']['rotating_thumbnail_max_frames']=10;

#Delay time for each frame while generating gif animation
#animated_gif_delay_time is changed to rotating_thumbnail_delay_time
$CFG['admin']['videos']['rotating_thumbnail_delay_time']=30;

##This is used for Delay seconds in Js Animation
#animated_gif_enable_js_animation_delay_seconds is changed to rotating_thumbnail_js_method_delay_seconds
$CFG['admin']['videos']['rotating_thumbnail_js_method_delay_seconds']=500;


#this variable is removed
//$CFG['admin']['upload_external_flv_type']='xml'; //set 'download' if need to download and encode (slower works only for youtube) . set 'xml' if need to get the video details through xml (faster works for both youtube and google).

$CFG['admin']['upload_external_use_curl']=false;


$CFG['admin']['videos']['list_title_length']=24;
$CFG['admin']['videos']['list_title_total_length']= 19;

//Featured Video title length
$CFG['admin']['videos']['index_featured_title_length']=20;
$CFG['admin']['videos']['index_featured_title_total_length']= 15;
$CFG['admin']['videos']['index_featured_full_title_length']=85;
$CFG['admin']['videos']['index_featured_full_title_total_length']=60;

//Side bar Featured title length
$CFG['admin']['videos']['index_featured_side_bar_title_length']=26;
$CFG['admin']['videos']['index_featured_side_bar_title_total_length']= 20;
$CFG['admin']['videos']['index_featured_side_bar_full_title_length']=9;
$CFG['admin']['videos']['index_featured_side_bar_full_title_total_length']=13;


$CFG['admin']['videos']['indexvideo_title_length']=20;
$CFG['admin']['videos']['indexvideo_title_total_length']=14;
$CFG['admin']['videos']['indexvideo_channel_title_length']=24;
$CFG['admin']['videos']['indexvideo_channel_title_total_length']=17;
$CFG['admin']['videos']['view_video_channel_title_length']=30;
$CFG['admin']['videos']['view_video_channel_title_total_length']=19;
$CFG['admin']['videos']['admin_video_channel_title_length']=35;
$CFG['admin']['videos']['admin_video_channel_title_total_length']=30;
$CFG['admin']['videos']['right_nav_video_channel_title_length']=35;
$CFG['admin']['videos']['right_nav_video_channel_title_total_length']=30;
$CFG['admin']['videos']['video_channel_title_length']=50;
$CFG['admin']['videos']['video_channel_title_total_length']=30;

$CFG['admin']['videos']['allow_self_ratings']=false;
$CFG['admin']['videos']['recent_view_videos_seconds']=60; // This value will be used by the recent videos FLASH XML genrating page.
$CFG['admin']['videos']['index_page_video_list_refresh_rates']=10000;
$CFG['admin']['videos']['index_page_video_list_title_text_color']='0x000000';
$CFG['admin']['videos']['index_page_video_list_title_text_bold']=true;
$CFG['admin']['videos']['index_page_video_list_title_text_italic']=false;
$CFG['admin']['videos']['index_page_video_list_title_text_underline']=false;
$CFG['admin']['videos']['index_page_video_list_title_text_style']='verdana'; //Font
$CFG['admin']['videos']['index_page_video_list_title_text_size']=12; //Font size

$CFG['admin']['videos']['index_page_video_list_thumbnail_gap']=30; //PX



$CFG['admin']['videos']['num_videos_detail_view_per_rows']=1;
$CFG['admin']['videos']['catergory_list_per_row']=4;
$CFG['admin']['videos']['num_videos_thumb_view_per_rows']=4;
$CFG['admin']['videos']['num_videos_my_videos_thumb_view_per_rows']=4;
$CFG['admin']['videos']['num_themes_per_rows'] = 3;

$CFG['admin']['videos']['playlist_folder']='files/video_playlist/';
$CFG['admin']['videos']['playlist_image_format_arr']=array('jpg','gif');
$CFG['admin']['videos']['playlist_height'] = '*';
$CFG['admin']['videos']['playlist_width'] = 60;
$CFG['admin']['videos']['playlist_image_max_size'] = 400;

$CFG['admin']['list_description_length']=20;
$CFG['admin']['list_description_total_length']=30;
$CFG['admin']['videos']['title_details_length_list_view']=40;

$CFG['admin']['videos']['recent_videos_play_list_counts']=5;
$CFG['admin']['videos']['playlist_desc_lengths']=40;
$CFG['admin']['videos']['image_format_arr'] = array('jpg', 'jpeg');
$CFG['admin']['videos']['image_max_size']=400;

//OTHER FORMATS
$CFG['admin']['videos']['video_available_formats']=array('3gp','wmv');
$CFG['admin']['videos']['video_download_formats']=array('3gp','wmv');

#maximum step for Skipping video frame while capturing image
$CFG['admin']['videos']['max_skip_step_frame']=5;

#minmum video Length is used in Video to Frame Conversion
#if the video is > 20 seconds and video is large enough to take frames with the set step
$CFG['admin']['videos']['minmum_video_length']=20;

$CFG['admin']['videos']['category_accept_max_length'] = 70;

#playlist Title total length
$CFG['admin']['videos']['playlist_title_total_length']=250;

#To set image count per row
$CFG['admin']['videos']['show_thumbnail_per_row']=4;

$CFG['admin']['videos']['video_random']=false;

## Count to Display video in google sitemap. Google will accept Less than 50000 videos per page & File size must not larger than 30 MB
$CFG['admin']['videos']['google_sitemap_videocount']=10000;

$CFG['admin']['videos']['subcategory_list_per_row']=5;

$CFG['admin']['videos']['video_screen_total_count']=8;
$CFG['admin']['videos']['video_screen_per_row']=4;
//time period in hours to clean up files captured and stored in red5 path
$CFG['admin']['videos']['clean_up_capture_files']=24;
$CFG['admin']['videos']['index_page_top_contributors']=10;
$CFG['admin']['videos']['profile_page_total_video']=4;

#WATERMARK FILE PATH
$CFG['admin']['videos']['watermark_path']='files/watermark/wmark.srt';
#WATERMARIL FONT PATH
$CFG['admin']['videos']['watermark_font_path']='common/gd_fonts/arial.ttf';

$CFG['admin']['videos']['toolTipEnabled']=true;


### MAXIMUM AND MINIMUM SIZE OF THE PALAYER

$CFG['admin']['videos']['maximum_player_width']=640;
$CFG['admin']['videos']['maximum_player_height']=505;
$CFG['admin']['videos']['minimum_player_width']=420;
$CFG['admin']['videos']['minimum_player_height']=340;

#### NEED TO RESIZE the VIDEO IF THE VIDEO SCALE IS GREATER THAN THE VF SCALE GIVEN IN VIDEO ENCODE COMMAND CONFIG
#### FOR LESSER SIZE VIDEO SCALE WILL NOT TAKE PLACE. IF IT SET TO FALE DEFAULT VFSCALE IS SETTED
$CFG['admin']['videos']['maintain_quality_video']=true;

#word count for video caption display in Video detail tooltip
$CFG['admin']['videos']['caption_list_length']=25;
$CFG['admin']['videos']['caption_list_total_length']=60;

$CFG['admin']['videos']['viewvideo_caption_list_length']=65;
$CFG['admin']['videos']['viewvideo_caption_list_total_length']=250;

$CFG['admin']['videos']['viewvideo_title_list_length']=42;
$CFG['admin']['videos']['viewvideo_title_list_total_length']=36;

$CFG['admin']['videos']['relatedvideo_title_list_length']=15;
$CFG['admin']['videos']['relatedvideo_title_list_total_length']=12;

$CFG['admin']['videos']['responsevideo_title_list_length']=11;
$CFG['admin']['videos']['responsevideo_title_list_totallength']=10;

$CFG['admin']['videos']['responsevideo_videoHeading_list_length']=60;
$CFG['admin']['videos']['responsevideo_videoHeading_list_totallength']=55;

$CFG['admin']['videos']['viewvideo_responsetitle_list_length']=20;
$CFG['admin']['videos']['viewvideo_responsetitle_list_totallength']=15;

$CFG['admin']['videos']['videoresponse_display_title_length']=40;
$CFG['admin']['videos']['videoresponse_display_title_totallength']=37;

$CFG['admin']['videos']['videolist_response_title_length']=15;
$CFG['admin']['videos']['videolist_response_title_totallength']=10;

$CFG['admin']['videos']['quicklinks_title_list_length']=30;
$CFG['admin']['videos']['quicklinks_title_list_total_length']=30;

$CFG['admin']['videos']['member_channel_length'] = 28;
$CFG['admin']['videos']['member_channel_total_length'] = 24;

$CFG['admin']['videos']['admin_video_category_name_length']=20;
$CFG['admin']['videos']['admin_video_category_description_length']=30;

$CFG['admin']['videos']['member_video_category_name_length']=20;
$CFG['admin']['videos']['member_video_category_name_total_length']=30;
$CFG['admin']['videos']['member_video_category_description_length']=20;
$CFG['admin']['videos']['member_video_category_description_total_length']=30;

// Video title..
$CFG['admin']['videos']['admin_video_title_length'] = 20;
$CFG['admin']['videos']['admin_video_title_totle_length'] = 30;

// Video LIst title..
$CFG['admin']['videos']['video_list_title_length'] = 43;
$CFG['admin']['videos']['video_list_title_total_length'] = 48;

//vidoe Manage comments
$CFG['admin']['videos']['member_video_comments_length'] = 20;
$CFG['admin']['videos']['member_video_comments_total_length'] = 30;


//video playlist description..
$CFG['admin']['videos']['member_video_playlist_description_length'] = 80;
$CFG['admin']['videos']['member_video_playlist_description_total_length'] = 30;

//video Albums
$CFG['admin']['videos']['member_video_albums_name_length'] = 20;
$CFG['admin']['videos']['member_video_albums_name_total_length'] = 30;

$CFG['admin']['videos']['avtivity_title_length']=20;

$CFG['admin']['video']['left_video_channel_display_count'] = 10;
$CFG['admin']['videos']['profile_video_list_title_length']=20;
$CFG['admin']['videos']['profile_video_list_title_total_length']=16;
$CFG['admin']['videos']['show_background_image_link_admin'] = true;
//To increase the player size for other templates when the player size is small by default
$CFG['admin']['videos']['increase_embedplayer_size_viewvideo'] = false;
//Profile Theme
$CFG['profile_box_id']['myvideo'] = 'clsVideoShelfTable';
$CFG['profile_box_id']['featuredvideo'] = 'clsFeaturedVideoBlockTable';
$CFG['profile_box_id']['videos_list'] = 'selUserVideoListing';
$CFG['profile_box_id']['featuredvideo_list'] = 'clsFeaturedVideoBlock';

/**
 * @#var				int Profile featured video player minimum height
 * @#cfg_label 		Profile featured video player minimum height
 * @#cfg_key 		featured_video_minimum_player_height
 */
$CFG['profile']['featured_video_player_minimum_height'] = 393;
/**
 * @#var				int Profile featured video player minimum width
 * @#cfg_label 		Profile featured video player minimum width
 * @#cfg_key 		featured_video_player_minimum_width
 */
$CFG['profile']['featured_video_player_minimum_width'] = 471;
/**
 * @#var				int Profile featured video title length
 * @#cfg_label 		Profile featured video title length
 * @#cfg_key 		featured_video_title_length
 */
$CFG['profile']['featured_video_title_length'] = 50;
/**
 * @#var				int Profile featured video title total length
 * @#cfg_label 		Profile featured video title total length
 * @#cfg_key 		featured_video_title_total_length
 */
$CFG['profile']['featured_video_title_total_length'] = 45;

//Assign Global Config Variable adult_content_view,adult_minimum_age to videos variable respectively *Do not move this variable to db.
$CFG['admin']['videos']['adult_content_view'] = $CFG['admin']['site']['adult_content_view'];
$CFG['admin']['videos']['adult_minimum_age'] = $CFG['admin']['site']['adult_minimum_age'];



$CFG['video']['image']['extensions'] = 'jpg';
//Have moved from config_general
//video player
//$CFG['admin']['embed_code']['additional_fields'] = 'allowFullScreen="true" wmode="transparent"';
$CFG['admin']['embed_code']['additional_fields'] = 'allowFullScreen="true"';
$CFG['admin']['embed_code_small']['additional_fields'] = 'allowFullScreen="true"';
$CFG['admin']['video_advertisement_impressions'] = false;

require_once($CFG['site']['project_path'].'common/configs/config_video_tables.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_video_url.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_video_fieldsize.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_video_player.inc.php');
?>
