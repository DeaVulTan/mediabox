<?php
/**
 * settings for $CFG['admin']['photo']
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
 * @version		SVN: $Id: config_photo.inc.php 2895 2006-12-07 11:53:08Z selvaraj_35ag05 $
 * @since 		2006-05-04
 * @filesource
 **/
$CFG['admin']['photos']['folder'] = 'photos';
$CFG['admin']['photos']['photo_folder'] = 'photos';
$CFG['admin']['photos']['temp_folder'] = 'temp_photos';
$CFG['admin']['photos']['original_photo_folder'] = 'original_photos';
$CFG['admin']['photos']['watermark_folder'] = 'watermark';

//tumb_name, small_name, large_name, medium_name are only S, T, L
$CFG['admin']['photos']['small_width'] = 106;
$CFG['admin']['photos']['small_height'] = 79;
$CFG['admin']['photos']['small_name'] = 'S';

$CFG['admin']['photos']['thumb_width'] = 142;
$CFG['admin']['photos']['thumb_height'] = 108;
$CFG['admin']['photos']['thumb_name'] = 'T';

$CFG['admin']['photos']['large_width'] = 591;
$CFG['admin']['photos']['large_height'] = 444;
$CFG['admin']['photos']['large_name'] = 'L';

//Not image generated, only for size
$CFG['admin']['photos']['medium_width'] = 470;
$CFG['admin']['photos']['medium_height'] = 392;
$CFG['admin']['photos']['medium_name'] = 'M';

$CFG['admin']['photos']['large_view_width'] = 650;
$CFG['admin']['photos']['large_view_height'] = 500;


/**
 * @#var				boolean Allow Embedable
 * @#cfg_label 		Allow Embedable
 * @#cfg_key 		embedable
 */
$CFG['admin']['photos']['embedable'] = true;
/**
 * @#var			array available_upload_photo_types
 * @#cfg_label 		Available Upload Photo types
 * @#cfg_key 		available_upload_photo_types
 */
$CFG['admin']['photos']['available_upload_photo_types'] = array('MultiUpload', 'NormalUpload', 'ExternalUpload', 'Capture');
/**
 * @#var				string Default Upload Type
 * @#cfg_label 		Default Upload Type ('MultiUpload', 'NormalUpload', 'ExternalUpload', 'CapturePhoto') - Make sure the given Upload type is turned on
 * @#cfg_key 		default_upload_type
 */
$CFG['admin']['photos']['default_upload_type'] = 'MultiUpload';
/**
 * @#var				string Photo Upload File limit
 * @#cfg_label 		MultiUpload Files Limit
 * @#cfg_key 		multi_upload_files_limit
 */
$CFG['admin']['photos']['multi_upload_files_limit'] = '10';
/**
 * @#var				array Allowed Photo Formats
 * @#cfg_label 		Allowed Photo Formats in lower case
 * @#cfg_key 		format_arr
 * @#cfg_arr_type 	key
 * @#cfg_arr_key 	string
 */
$CFG['admin']['photos']['format_arr'] = array('jpg', 'jpeg', 'png');
//photo google map related variables.
/**
 * @#var				string Default latitude
 * @#cfg_label 		Set the latitude in which the marker has to be shown by default
 * @#cfg_key 		default_latitude
 */
$CFG['admin']['photos']['default_latitude'] = '34';
// default chennai lat
/**
 * @#var				string Default latitude
 * @#cfg_label 		Set the longitude in which the marker has to be shown by default
 * @#cfg_key 		default_longitude
 */
$CFG['admin']['photos']['default_longitude'] = '0';
// default chennai lan

/**
 * @#var			boolean Photo Sub-category
 * @#cfg_label 		Photo Sub-category
 * @#cfg_key 		sub_category
 * @#cfg_arr_type 	key
 * @#cfg_arr_key 	string
 * @#cfg_section 	miscellaneous
 */
$CFG['admin']['photos']['sub_category'] = true;

$CFG['admin']['photos']['caption_length_share_photo'] = 90;
$CFG['admin']['photos']['description_total_char_share_photo'] = 200;
$CFG['admin']['photos']['photo_upload_album_name_compulsory'] = false;
$CFG['admin']['photos']['external_photo_download'] = true;
$CFG['admin']['photos']['related_photo_default_content'] = 'User';

$CFG['admin']['photos']['recommendedphoto_total_record'] = 6;
$CFG['admin']['photos']['topratedphoto_total_record'] = 6;
$CFG['admin']['photos']['mostfavorite_total_record'] = 6;
$CFG['admin']['photos']['recentlyaddedphoto_total_record'] = 6;
/**
 * @#var				int Total no of row record to display
 * @#cfg_label 		Total no of rows to display per tab
 * @#cfg_key 		photo_block_total_row_record
 */
//$CFG['admin']['photos']['photo_block_total_row_record'] = 2;
$CFG['admin']['photos']['profile_page_total_photo'] = 4;
$CFG['admin']['photos']['profile_page_total_photo_album'] = 4;
$CFG['admin']['photos']['photo_channel_total_record'] = 3;
//used to limit the no of slidelists shown in the index page carousel
$CFG['admin']['photos']['photo_slidelist_total_record'] = 3;
//photo common variables
$CFG['admin']['photos']['total_comments']           = 10;
$CFG['admin']['photos']['title_length']             = 50;
$CFG['admin']['photos']['get_code_max_size']        = 400;
$CFG['admin']['photos']['comment_edit_allowed_time']= 120;
$CFG['photo_tbl']['numpg']                          = 15;
$CFG['admin']['photos']['rss_count']                = 20;
$CFG['admin']['photos']['tags_count_list_page']     = 4;
$CFG['admin']['photos']['list_title_length']        = 15;
$CFG['admin']['photos']['list_title_total_length']  = 16;
$CFG['admin']['photos']['allow_self_ratings']       = true;
$CFG['admin']['photos']['photo_auto_activate_time'] = 0;

//photo error log
$CFG['admin']['photos']['log_upload_error']         = true;

//photo meta data details
$CFG['admin']['photos']['photo_meta_data']          = true;
$CFG['admin']['photos']['photo_meta_data_array']    = array('FileSize','flashUsed','make','model','xResolution','yResolution','fileModifiedDate','exposureTime','fnumber','exposure','DateTime','jpegQuality','whiteBalance','focalLength','flashpixVersion','Width','Height','screenCaptureType','contrast','saturation','sharpness','resolution','orientation','color','copyright','software',     'brightness','zoomRatio','make','model','artist');

//for post comment
$CFG['admin']['photos']['disallowed_tag']         = array('script','select','title','textarea');
$CFG['admin']['photos']['disallowed_empty_tag']   = array('pre','meta','!DOCTYPE','link','form','input','head','html','body','title');
$CFG['admin']['photos']['disallowed_style_class'] = array('body');
$CFG['admin']['photos']['disallowed_attributes']  = array('onclick','onload','onmouseover','ondblclick','onmouseout','onkeypress','onkeydown','onkeyup');


//photo list
$CFG['admin']['photos']['photo_list_page_title']                 =45;
$CFG['admin']['photos']['photo_list_page_title_total_length']    =47;
$CFG['admin']['photos']['photo_list_photo_title']                =20;
$CFG['admin']['photos']['photo_list_photo_title_total_length']   =25;
$CFG['admin']['photos']['photo_list_album_title']                =20;
$CFG['admin']['photos']['photo_list_album_title_total_length']   =30;
$CFG['admin']['photos']['photo_list_category_title']             =20;
$CFG['admin']['photos']['photo_list_category_title_total_length']=30;
$CFG['admin']['photos']['photo_list_description_title']          =25;
$CFG['admin']['photos']['photo_list_description_title_total_length']=58;
$CFG['admin']['photos']['num_photos_thumb_view_per_rows']        =4;

//View page photo wardwrap..
$CFG['admin']['photos']['member_photo_title_length']            = 20;
$CFG['admin']['photos']['member_photo_title_total_length']      = 30;
$CFG['admin']['photos']['member_photoalbum_title_length']       = 20;
$CFG['admin']['photos']['member_photoalbum_title_total_length'] = 30;

//album List
$CFG['admin']['photos']['album_list_album_title']               = 20;
$CFG['admin']['photos']['album_list_photo_title_total_length']  = 50;
$CFG['admin']['photos']['album_list_in_playlist_limit']         = 3;

$CFG['admin']['photos']['albumlist_album_title_length']         = 25;
$CFG['admin']['photos']['albumlist_album_title_total_length']   = 25;

$CFG['admin']['photos']['albumlist_photo_title_length']         = 38;
$CFG['admin']['photos']['albumlist_photo_title_total_length']   = 38;


//photo Albums
$CFG['admin']['photos']['member_photo_albums_name_length']            =20;
$CFG['admin']['photos']['member_photo_albums_name_total_length']      =30;
$CFG['admin']['photos']['photo_channel_title_length']                 =50;
$CFG['admin']['photos']['rotating_thumbnail_max_frames']              =10;
$CFG['admin']['photos']['rotating_thumbnail_js_method_delay_seconds'] =500;
$CFG['admin']['photos']['photo_caption_word_wrap_length']             =40;
$CFG['admin']['photos']['photo_title_word_wrap_length']               =40;
$CFG['admin']['photos']['photo_channel_title_total_length']           =30;
$CFG['admin']['photos']['subcategory_list_per_row']                   =5;

//myprofile block
$CFG['admin']['photos']['profile_myphoto_block_photo_title']       =20;
$CFG['admin']['photos']['profile_myphoto_block_photo_total_length']=25;
$CFG['admin']['photos']['profile_myphoto_block_album_title']       =20;
$CFG['admin']['photos']['profile_myphoto_block_album_total_length']=25;
$CFG['admin']['photos']['featured_profile_photo_title_length']       =5;
$CFG['admin']['photos']['featured_profile_photo_title_total_length'] =10;
$CFG['admin']['photos']['view_profile_album_title_length']         =5;
$CFG['admin']['photos']['view_profile_album_title_total_length']   =10;


//sidebar
$CFG['admin']['photos']['sidebar_albumlist_title_length']         = 20;
$CFG['admin']['photos']['sidebar_albumlist_title_total_length']   = 28;
$CFG['admin']['photos']['sidebar_genres_num_record']              = 6;
$CFG['admin']['photos']['sidebar_genres_name_length']             = 15;
$CFG['admin']['photos']['sidebar_genres_name_total_length']       = 20;
$CFG['admin']['photos']['sidebar_top_contributors']               = 10;
$CFG['admin']['photos']['sidebar_top_contributors_num_record']    = 7;
$CFG['admin']['photos']['sidebar_memberlist_top_contributors']               = 8;
$CFG['admin']['photos']['sidebar_memberlist_top_contributors_num_record']    = 4;
$CFG['admin']['photos']['sidebar_featured_members']               = 1;
$CFG['admin']['photos']['sidebar_topchart_num_record']            = 5;
$CFG['admin']['photos']['sidebar_topchart_total_record']          = 25;
$CFG['admin']['photos']['sidebar_clouds_name_length']             = 15;
$CFG['admin']['photos']['sidebar_clouds_name_total_length']       = 20;
$CFG['admin']['photos']['sidebar_clouds_num_record']		  = 20;

//Index

$CFG['admin']['photos']['indexphotoblock_username_title_length']       = 12;
$CFG['admin']['photos']['indexphotoblock_username_title_total_length'] = 15;


$CFG['admin']['photos']['indexphotoblock_photo_title_length']       = 25;
$CFG['admin']['photos']['indexphotoblock_photo_title_total_length'] = 15;

$CFG['admin']['photos']['indexphotoblock_caption_list_length']      = 25;
$CFG['admin']['photos']['indexphotoblock_caption_list_total_length']= 60;
$CFG['admin']['photos']['profilephotoblock_photo_title_length']     = 16;
$CFG['admin']['photos']['profilephotoblock_photo_title_total_length']= 11;
$CFG['admin']['members']['photo_icon_title']                        = '%s photos';
$CFG['admin']['photos']['indexphoto_topchart_title_length']         = 20;
$CFG['admin']['photos']['indexphoto_topchart_title_total_length']   = 20;
$CFG['admin']['photos']['indexphotoblock_album_title_length']       = 20;
$CFG['admin']['photos']['indexphotoblock_album_title_total_length'] = 15;
$CFG['admin']['photos']['photo_index_featured_list']                = true;

$CFG['admin']['photos']['photo_index_featured_num_record']          = 30;
$CFG['admin']['photos']['photo_index_featured_title_length']        = 30;
$CFG['admin']['photos']['photo_index_featured_title_total_length'] = 35;
$CFG['admin']['photos']['photo_index_featured_caption_length']      = 300;
$CFG['admin']['photos']['photo_index_featured_caption_total_length'] = 310;

$CFG['admin']['photos']['indexphotoblock_photo_zoom_title_length']       = 40;
$CFG['admin']['photos']['indexphotoblock_photo_zoom_title_total_length'] = 45;

$CFG['admin']['photos']['indexphotoblock_photo_location_recorded_title_length'] = 25;
$CFG['admin']['photos']['indexphotoblock_photo_location_recorded_title_total_length'] = 30;

//Index Page
$CFG['admin']['photos']['photo_index_channel_list']		  = 3;
$CFG['admin']['photos']['photo_index_num_record']         = 6;
$CFG['admin']['photos']['photo_index_num_record_per_row'] = 3;
$CFG['admin']['photos']['photo_index_top_photos']		  = 4;

// My, Friends, All
$CFG['admin']['photos']['photo_activity_default_content']= 'My';

//user All Updates
$CFG['admin']['photos']['activity_title_length'] =15;
$CFG['admin']['photos']['activity_title_total_length'] =15;

//admin
$CFG['admin']['photos']['admin_photo_channel_title_length'] =35;
$CFG['admin']['photos']['photo_channel_title_length']       =35;

$CFG['admin']['photos']['admin_photo_title_length']       = 20;
$CFG['admin']['photos']['admin_photo_title_total_length'] = 30;

//banner
$CFG['admin']['photo_banner']['sidebanner1_250x250_not_allowed_pages'] = array();
$CFG['admin']['photo_banner']['sidebanner2_250x250_not_allowed_pages'] = array();

//photo category
$CFG['admin']['photos']['category_height']            = 146;
$CFG['admin']['photos']['category_width']             = 112;
$CFG['admin']['photos']['category_image_max_size']    = 400;
$CFG['admin']['photos']['category_folder']            = 'files/photo_category/';
$CFG['admin']['photos']['category_image_format_arr']  = array('jpg', 'jpeg', 'gif');
$CFG['admin']['photos']['photo_no_image']             ='no_image.jpg';
$CFG['admin']['photos']['admin_photo_category_name_length']=20;

$CFG['admin']['photos']['member_photo_category_name_length']              = 15;
$CFG['admin']['photos']['member_photo_category_name_total_length']        = 18;
$CFG['admin']['photos']['member_photo_category_description_length']       = 20;
$CFG['admin']['photos']['member_photo_category_description_total_length'] = 22;

$CFG['admin']['photos']['category_accept_max_length'] =70;
$CFG['admin']['photos']['catergory_list_per_row']     =3;


//view album
$CFG['admin']['photos']['photo_view_album_limit']					   = 3;
$CFG['admin']['photos']['view_album_title']                            = 15;
$CFG['admin']['photos']['view_album_title_total_length']			   = 30;
$CFG['admin']['photos']['view_album_photo_title_length']			   = 20;
$CFG['admin']['photos']['view_album_photo_title_total_length']		   = 35;
$CFG['admin']['photos']['view_album_category_name_length']			   = 20;
$CFG['admin']['photos']['view_album_category_name_total_length']	   = 40;
$CFG['admin']['photos']['view_album_description_name_length']          = 20;
$CFG['admin']['photos']['view_album_description_name_total_length']    = 90;

$CFG['admin']['photos']['member_photo_tags_name_length']               = 20;
$CFG['admin']['photos']['member_photo_tags_name_total_length']         = 30;
$CFG['admin']['photos']['member_photo_tags_keyword_total_length']      = 10;

$CFG['admin']['photos']['caption_list_length']		                   = 25;
$CFG['admin']['photos']['caption_list_total_length']                   = 60;


//View Photo
$CFG['admin']['photos']['viewphoto_caption_list_length']               = 85;
$CFG['admin']['photos']['viewphoto_caption_list_total_length']         = 60;

$CFG['admin']['photos']['viewphoto_title_list_length']                  = 48;
$CFG['admin']['photos']['viewphoto_title_list_total_length']            = 42;

//Slide List
$CFG['admin']['photos']['member_playlist_title_length']		              = 20;
$CFG['admin']['photos']['member_playlist_title_total_length']             = 30;
//slidelist name for index page:
$CFG['admin']['photos']['index_playlist_title_length']		              = 15;
$CFG['admin']['photos']['index_playlist_title_total_length']		      = 20;



$CFG['admin']['photos']['member_photo_playlist_description_length']		  = 25;
$CFG['admin']['photos']['member_photo_playlist_description_total_length'] = 60;

//Photo Manage comments
$CFG['admin']['photos']['member_photo_comments_length'] = 20;
$CFG['admin']['photos']['member_photo_comments_total_length'] = 30;

//related photo
$CFG['admin']['photos']['total_related_photo'] = 10;
$CFG['admin']['photos']['related_photo_per_row'] = 3;
$CFG['admin']['photos']['relatedphoto_title_list_length'] = 10;
$CFG['admin']['photos']['relatedphoto_title_list_total_length'] = 15;

$CFG['admin']['photos']['canvas_tag_width'] = 45;
$CFG['admin']['photos']['canvas_tag_height'] = 45;

//canvas allwoed width and height
$CFG['admin']['photos']['canvas_add_tag_allowed_width']  = 100;
$CFG['admin']['photos']['canvas_add_tag_allowed_height'] = 100;

//photo upload
$CFG['admin']['photos']['title_max_length']  = 200;
$CFG['admin']['photos']['album_max_length']  = 100;

//people on photo tag
$CFG['admin']['photos']['peopleon_photo_list_page_title']                 =65;
$CFG['admin']['photos']['peopleon_photo_list_page_title_total_length']    =70;

$CFG['profile_box_id']['myphoto'] = 'clsPhotoShelfTable';
$CFG['profile_box_id']['myphotoalbum'] = 'clsPhotoAlbumShelfTable';
$CFG['profile_box_id']['myfeaturedphoto'] = 'clsFeaturedShelfTable';

$CFG['profile_box_id']['myphotos_list'] = 'selUserMyPhoto';
$CFG['profile_box_id']['myphotoalbum_list'] = 'selUserMyphotoalbum';

//Assign Global Config Variable adult_content_view,adult_minimum_age to photos variable respectively *Do not move this variable to db.
$CFG['admin']['photos']['adult_content_view'] = $CFG['admin']['site']['adult_content_view'];
$CFG['admin']['photos']['adult_minimum_age'] = $CFG['admin']['site']['adult_minimum_age'];

//organize_slidelist
$CFG['admin']['photos']['organize_slidelist_photo_title_length']  =9;
$CFG['admin']['photos']['organize_slidelist_photo_title_total_length']    =14;

$CFG['admin']['photos']['movie_maker']    =false;
if(file_exists($CFG['site']['project_path'].'common/configs/config_photo_movie_maker.inc.php'))
require_once($CFG['site']['project_path'].'common/configs/config_photo_movie_maker.inc.php');

require_once($CFG['site']['project_path'].'common/configs/config_photo_tables.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_photo_url.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_photo_fieldsize.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_photo_water_mark.inc.php');


?>
