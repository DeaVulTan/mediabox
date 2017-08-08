<?php
/**
 * settings for $CFG['admin']['music']
 *
 * PHP version 5.0
 *
 * @category	..
 * @package		..
 * @author 		sridharan_08ag04
 * @copyright	Copyright (c) 2006 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: config_photo.inc.php 937 2006-05-30 08:26:06Z selvaraj_35ag05 $
 * @since 		2006-05-04
 * @filesource
 **/
$CFG['admin']['musics']['folder'] = 'musics';
$CFG['admin']['musics']['music_folder'] = 'musics';
$CFG['admin']['musics']['thumbnail_folder'] = 'thumbnails';
$CFG['admin']['musics']['temp_folder'] = 'temp_musics';
$CFG['admin']['musics']['original_music_folder'] = 'original_musics';
$CFG['admin']['musics']['other_musicformat_folder'] = 'other_format_musics';
$CFG['admin']['musics']['trimed_music_folder'] = 'trimed_musics';

#FODLER NAME FOR STORING MUSIC PAGE BACKGROUND IMAGE
$CFG['admin']['musics']['background_image_folder']='music_background';

$CFG['admin']['music']['list_per_line_total_articles'] = 4;

//thumb_name, small_name, large_name, medium_name are only S, T, M, L
//Small used only for Activities
$CFG['admin']['musics']['small_width'] = 65;
$CFG['admin']['musics']['small_height'] = 44;
$CFG['admin']['musics']['small_name'] = 'S';

$CFG['admin']['musics']['medium_width'] = 104;
$CFG['admin']['musics']['medium_height'] = 80;
$CFG['admin']['musics']['medium_name'] = 'M';

$CFG['admin']['musics']['thumb_width'] = 142;
$CFG['admin']['musics']['thumb_height'] = 108;
$CFG['admin']['musics']['thumb_name'] = 'T';

$CFG['admin']['musics']['large_width'] = 320;
$CFG['admin']['musics']['large_height'] = 240;
$CFG['admin']['musics']['large_name'] = 'L';

$CFG['admin']['musics']['total_comments'] = 10;
$CFG['admin']['musics']['title_length'] = 50;
$CFG['admin']['musics']['get_code_max_size'] = 400;
$CFG['admin']['musics']['comment_edit_allowed_time']= 120;

$CFG['admin']['musics']['category_height'] = 88;
$CFG['admin']['musics']['category_width'] = 132;
$CFG['admin']['musics']['category_image_max_size'] = 400;
$CFG['admin']['musics']['category_folder'] = 'files/music_category/';
$CFG['admin']['musics']['category_image_format_arr'] = array('jpg', 'jpeg', 'gif');

$CFG['admin']['musics']['artist_category_height'] = 88;
$CFG['admin']['musics']['artist_category_width'] = 132;
$CFG['admin']['musics']['artist_category_image_max_size'] = 400;
$CFG['admin']['musics']['artist_category_folder'] = 'files/music_artist_category/';
$CFG['admin']['musics']['artist_category_image_format_arr'] = array('jpg', 'jpeg', 'gif');

$CFG['admin']['musics']['index_numpg'] = 4;
//if total frame is 0 no frame will be created, maximum 3 frames only allowed
$CFG['admin']['musics']['advanced_download'] = false;
$CFG['admin']['musics']['redirect_download'] = true;
$CFG['admin']['musics']['rss_count'] = 20;
$CFG['admin']['musics']['tags_count_list_page'] = 4;

//for post comment
$CFG['admin']['musics']['disallowed_tag'] = array('script','select','title','textarea');
$CFG['admin']['musics']['disallowed_empty_tag'] = array('meta','!DOCTYPE','link','form','input','head','html','body', 'title');
$CFG['admin']['musics']['disallowed_style_class'] = array('body');
$CFG['admin']['musics']['disallowed_attributes'] = array();
/**
 * @#var			boolean Allow auto encode of musics
 * @#cfg_label 		Allow auto encode of musics
 * @#cfg_key 		music_auto_encode
 * @#cfg_sec_name 	General Music settings
 * @#cfg_section 	miscellaneous
 */
$CFG['admin']['musics']['music_auto_encode'] = true;
/**
 * @#var				boolean allow_members_to_set_price_for_album
 * @#cfg_label 		Allow members to set price for album
 * @#cfg_key 		allow_members_to_set_price_for_album
 * @#cfg_arr_type 	key
 * @#cfg_arr_key 	string
 */
$CFG['admin']['musics']['allow_members_to_set_price_for_album'] = true;
/**
 * @#var			array available_upload_music_types
 * @#cfg_label 		Available Upload Music types
 * @#cfg_key 		available_upload_music_types
 */
$CFG['admin']['musics']['available_upload_music_types'] = array('MultiUpload', 'NormalUpload', 'ExternalUpload', 'RecordAudio');
/**
 * @#var				boolean Allow downloading external music
 * @#cfg_label 		Allow downloading external music
 * @#cfg_key 		external_music_download
 */
$CFG['admin']['musics']['external_music_download'] = true;
/**
 * @#var				boolean env_details_checking
 * @#cfg_label 		Checking for "music upload environment"(Like existing of mencoder, etc) when uploading music
 * @#cfg_key 		env_details_checking
 */
$CFG['admin']['musics']['env_details_checking'] = true;
/**
 * @#var				boolean env_details_list
 * @#cfg_label 		Giving environment details when "checking for music upload environment" is ON
 * @#cfg_key 		env_details_list
 */
$CFG['admin']['musics']['env_details_list'] = true;
$CFG['admin']['musics']['playing_time_mp3info'] = false;
$CFG['admin']['musics']['log_upload_error'] = true;
$CFG['admin']['musics']['music_auto_activate_time'] = 0;
$CFG['admin']['musics']['rss_count'] = 10;
$CFG['admin']['musics']['image_compulsory'] = true;
$CFG['admin']['musics']['total_related_music'] = 4;
$CFG['music_tbl']['numpg'] = 16;



//Set 'image' / 'honeypot' / 'recaptcha';
/**
 * @#var				boolean Save Original File to download
 * @#cfg_label 		Save Original File to download
 * @#cfg_key 		save_original_file_to_download
 * @#cfg_sec_name 	Music Download
 * @#cfg_section 	music_download
 */
$CFG['admin']['musics']['save_original_file_to_download'] = true;
/**
 * @#var			boolean music_other_formats_enabled
 * @#cfg_label 	Save other format music File to download
 * @#cfg_key 	music_other_formats_enabled
 */
$CFG['admin']['musics']['music_other_formats_enabled'] = true;
/**
 * @#var			boolean allow_history_links
 * @#cfg_label 	Allow History
 * @#cfg_key 	allow_history_links
 */
$CFG['admin']['musics']['allow_history_links'] = true;
$CFG['admin']['musics']['allow_self_ratings'] = true;

$CFG['admin']['musics']['image_format_arr'] = array('jpeg', 'jpg', 'gif', 'png');
$CFG['admin']['musics']['image_max_size'] = 600;

$CFG['admin']['musics']['category_accept_max_length']=70;
$CFG['admin']['musics']['catergory_list_per_row']=4;

$CFG['admin']['musics']['wmode_value'] = 'window';
$CFG['admin']['musics']['player_tooltip'] = 'false';
//OTHER FORMATS
$CFG['admin']['musics']['music_available_formats'] = array();
$CFG['admin']['musics']['music_download_formats'] = array();
$CFG['admin']['musics']['title_max_length'] = 250;
$CFG['admin']['musics']['album_max_length'] = 50;
$CFG['admin']['musics']['artist_max_length'] = 100;

$CFG['admin']['musics']['indexmusicblock_music_title_length'] = 9;
$CFG['admin']['musics']['indexmusicblock_music_title_total_length'] = 15;
$CFG['admin']['musics']['indexmusicblock_caption_list_length']=25;
$CFG['admin']['musics']['indexmusicblock_caption_list_total_length']=60;
$CFG['admin']['musics']['profilemusicblock_music_title_length'] = 16;
$CFG['admin']['musics']['profilemusicblock_music_title_total_length'] = 11;
$CFG['admin']['members']['music_icon_title'] = '%s Musics';

$CFG['admin']['musics']['indexmusic_topchart_title_length'] = 15;
$CFG['admin']['musics']['indexmusic_topchart_title_total_length'] = 20;

//profile
$CFG['profile_box_id']['mymusic'] = 'clsMusicShelfTable';
$CFG['profile_box_id']['featuredmusic'] = 'clsFeaturedMusicBlockTable';
$CFG['profile_box_id']['musics_list'] = 'selUserMusicListing';
$CFG['profile_box_id']['musics'] = 'selUserMusicShelf';
$CFG['profile_box_id']['artist'] = 'clsArtistShelfTable';
$CFG['profile_box_id']['artistinfo'] = 'clsArtistinfoShelfTable';
$CFG['profile_box_id']['artistpromo'] = 'clsArtistPromoShelfTable';
$CFG['profile_box_id']['fans'] = 'clsFansShelfTable';
$CFG['profile_box_id']['myalbum'] = 'clsMyAlbumShelfTable';
//Playlist
$CFG['admin']['musics']['member_playlist_title_length'] = 20;
$CFG['admin']['musics']['member_playlist_title_total_length'] = 30;
$CFG['admin']['musics']['member_music_playlist_comments_length'] = 20;
$CFG['admin']['musics']['member_music_playlist_comments_total_length'] = 30;

$CFG['admin']['musics']['member_playlist_description_length'] = 60;
$CFG['admin']['musics']['member_playlist_description_total_length'] = 70;
$CFG['admin']['musics']['music_in_playlist_limit'] = 10;
$CFG['admin']['musics']['playlist_allow_self_rating'] = true;
$CFG['admin']['musics']['playlisttotal_comments'] = 5;

//View music related configs starts here
$CFG['admin']['musics']['viewmusic_title_list_length'] = 55;
$CFG['admin']['musics']['viewmusic_title_list_total_length'] = 55;

$CFG['admin']['musics']['viewmusic_caption_list_length'] = 65;
$CFG['admin']['musics']['viewmusic_caption_list_total_length'] = 250;

//more content Related Config variable
$CFG['admin']['musics']['related_music_per_row'] = 3;
$CFG['admin']['musics']['relatedmusic_title_list_length'] = 35;
$CFG['admin']['musics']['relatedmusic_title_list_total_length'] = 40;

//People listened
$CFG['admin']['musics']['total_people_listened_music'] = 3;
$CFG['admin']['musics']['people_listenedmusic_title_list_length']=30;
$CFG['admin']['musics']['people_listenedmusic_title_list_total_length']=27;
$CFG['admin']['musics']['people_listenedalbum_title_list_length']=30;
$CFG['admin']['musics']['people_listenedalbum_title_list_total_length']=27;
//View music related configs ends here

//music Manage comments
$CFG['admin']['musics']['member_music_comments_length'] = 20;
$CFG['admin']['musics']['member_music_comments_total_length'] = 30;

$CFG['admin']['musics']['admin_music_title_length'] = 20;
$CFG['admin']['musics']['admin_music_title_total_length'] = 30;
$CFG['admin']['musics']['viewpage_music_title_length'] = 85;
//View page music wardwrap..
$CFG['admin']['musics']['member_music_title_length'] = 20;
$CFG['admin']['musics']['member_music_title_total_length'] = 30;
$CFG['admin']['musics']['member_musicalbum_title_length'] = 20;
$CFG['admin']['musics']['member_musicalbum_title_total_length'] = 30;
$CFG['admin']['musics']['member_music_category_name_length']=20;
$CFG['admin']['musics']['member_music_category_name_total_length']=30;
$CFG['admin']['musics']['member_music_category_description_length']=20;
$CFG['admin']['musics']['member_music_category_description_total_length']=30;
$CFG['admin']['musics']['member_music_artist_name_length']=15;
$CFG['admin']['musics']['member_music_artiat_name_total_length']=30;
$CFG['admin']['musics']['member_music_tags_name_length']=20;
$CFG['admin']['musics']['member_music_tags_name_total_length']=30;

//albumlist
$CFG['admin']['musics']['member_albumlist_title_length'] = 20;
$CFG['admin']['musics']['member_albumlist_title_total_length'] = 30;

//Artist Config start..
$CFG['admin']['musics']['artist_small_width'] = 66;
$CFG['admin']['musics']['artist_small_height'] = 66;
$CFG['admin']['musics']['artist_small_name'] = 'S';

$CFG['admin']['musics']['artist_thumb_width'] = 90;
$CFG['admin']['musics']['artist_thumb_height'] = 90;
$CFG['admin']['musics']['artist_thumb_name'] = 'T';

$CFG['admin']['musics']['artist_large_width'] = 0;
$CFG['admin']['musics']['artist_large_height'] = 0;
$CFG['admin']['musics']['artist_large_name'] = 'L';

$CFG['admin']['musics']['artist_mini_width'] = 45;
$CFG['admin']['musics']['artist_mini_height'] = 45;
$CFG['admin']['musics']['artist_mini_name'] = 'M';

$CFG['admin']['musics']['artist_number_of_photo_allowed'] = 100;
$CFG['admin']['musics']['artist_image_size'] = 500;
$CFG['admin']['musics']['artist_allowed_image_type'] = array('jpg', 'jpeg', 'gif');
$CFG['admin']['musics']['artist_image_folder'] = 'artist_images';

$CFG['admin']['musics']['artist_image_cols'] = 5;

$CFG['admin']['musics']['member_artist_caption_length'] = 10;
$CFG['admin']['musics']['member_artist_caption_total_length'] = 15;

$CFG['admin']['musics']['member_lyrics_length'] = 10;
$CFG['admin']['musics']['member_lyrics_total_length'] = 15;

//admin music genre
$CFG['admin']['musics']['admin_music_category_name_length']=20;
$CFG['admin']['musics']['admin_music_category_name_total_length']=40;
$CFG['admin']['musics']['admin_music_category_description_length']=30;
$CFG['admin']['musics']['admin_music_category_description_total_length']=40;


$CFG['admin']['musics']['admin_music_channel_title_length']=35;

$CFG['admin']['musics']['music_no_image']='no_image.jpg';
$CFG['music']['image']['extensions'] = 'jpg';

$CFG['admin']['musics']['list_title_length']=24;
$CFG['admin']['musics']['list_title_total_length']= 19;

$CFG['admin']['musics']['sidebar_albumlist_title_length'] = 15;
$CFG['admin']['musics']['sidebar_albumlist_title_total_length'] = 20;

$CFG['admin']['musics']['sidebar_audiotracker_title_length'] = 15;
$CFG['admin']['musics']['sidebar_audiotracker_title_total_length'] = 20;

$CFG['admin']['musics']['sidebar_genres_num_record'] = 6;
$CFG['admin']['musics']['sidebar_genres_name_length']=15;
$CFG['admin']['musics']['sidebar_genres_name_total_length']=20;
$CFG['admin']['musics']['sidebar_clouds_num_record']=20;
$CFG['admin']['musics']['sidebar_top_contributors']=4;
$CFG['admin']['musics']['sidebar_popularartist_num_record']=5;
$CFG['admin']['musics']['sidebar_non_member_popularartist_num_record']=7;
$CFG['admin']['musics']['sidebar_audiotracker_num_record']=5;
$CFG['admin']['musics']['sidebar_audiotabs_num_record_per_row']=3;
$CFG['admin']['musics']['sidebar_audiotabs_num_record']=6;
$CFG['admin']['musics']['sidebar_topchart_num_record']=5;
$CFG['admin']['musics']['sidebar_topchart_total_record']=25;
$CFG['admin']['musics']['sidebar_clouds_name_length']=12;
$CFG['admin']['musics']['sidebar_clouds_name_total_length']=20;
$CFG['admin']['musics']['sidebar_artist_name_length']=15;
$CFG['admin']['musics']['sidebar_artist_name_total_length']=20;
$CFG['admin']['musics']['sidebar_currentlyplayingmusic_num_record']=4;
//which one show first (songs, albums, downloads)
$CFG['admin']['musics']['sidebar_topchart_option']=array('songs', 'downloads', 'albums');
$CFG['admin']['musics']['sidebar_topchart_sales_option']=array('songs',  'albums', 'artists');
// My, Friends, All
$CFG['admin']['musics']['music_activity_default_content']= 'Friends';

$CFG['admin']['musics']['member_channel_length'] = 28;
$CFG['admin']['musics']['member_channel_total_length'] = 24;

//myfeatured music
$CFG['admin']['musics']['featured_music_list_title_length']=16;
$CFG['admin']['musics']['featured_music_list_title_total_length']=11;
$CFG['profile']['featured_music_title_length'] = 50;
$CFG['profile']['featured_music_title_total_length'] = 45;
$CFG['admin']['musics']['view_profile_album_title_length']=10;
$CFG['admin']['musics']['view_profile_album_title_total_length']=20;

//musiclist
// we dont have detail view and thumbnail view for now
$CFG['admin']['musics']['num_musics_detail_view_per_rows']=1;
$CFG['admin']['musics']['num_musics_thumb_view_per_rows']=1;
$CFG['admin']['musics']['caption_list_length']=25;
$CFG['admin']['musics']['caption_list_total_length']=60;
$CFG['admin']['musics']['musiclist_response_title_length']=15;
$CFG['admin']['musics']['musiclist_response_title_totallength']=10;
//music Albums
$CFG['admin']['musics']['member_music_albums_name_length'] = 20;
$CFG['admin']['musics']['member_music_albums_name_total_length'] = 30;
$CFG['admin']['musics']['music_channel_title_length']=50;
$CFG['admin']['musics']['rotating_thumbnail_max_frames']=10;
$CFG['admin']['musics']['rotating_thumbnail_js_method_delay_seconds']=500;
$CFG['admin']['musics']['music_caption_word_wrap_length']=40;
$CFG['admin']['musics']['music_title_word_wrap_length']=40;
$CFG['admin']['musics']['music_channel_title_total_length']=30;
$CFG['admin']['musics']['subcategory_list_per_row']=5;
//Music List
$CFG['admin']['musics']['music_list_music_title']=20;
$CFG['admin']['musics']['music_list_music_title_total_length']=50;
$CFG['admin']['musics']['music_list_album_title']=20;
$CFG['admin']['musics']['music_list_album_title_total_length']=50;
$CFG['admin']['musics']['music_list_category_title']=20;
$CFG['admin']['musics']['music_list_category_title_total_length']=50;
$CFG['admin']['musics']['music_list_artist_title_length']=20;
$CFG['admin']['musics']['music_list_artist_title_length_total_length']=50;
$CFG['admin']['musics']['music_list_description_title']=25;
$CFG['admin']['musics']['music_list_description_title_total_length']=90;
//viewAlbum
$CFG['admin']['musics']['view_album_title']=15;
$CFG['admin']['musics']['view_album_title_total_length']=30;
$CFG['admin']['musics']['view_album_music_title_length']=20;
$CFG['admin']['musics']['view_album_music_title_total_length']=35;
$CFG['admin']['musics']['view_album_category_name_length']=20;
$CFG['admin']['musics']['view_album_category_name_total_length']=40;
$CFG['admin']['musics']['view_album_artist_title_length']=20;
$CFG['admin']['musics']['view_album_artist_title_length_total_length']=40;
$CFG['admin']['musics']['view_album_description_name_length']=20;
$CFG['admin']['musics']['view_album_description_name_total_length']=90;
//album List
$CFG['admin']['musics']['album_list_album_title']=20;
$CFG['admin']['musics']['album_list_music_title_total_length']=50;
$CFG['admin']['musics']['album_list_in_playlist_limit'] = 3;
//myprofile block
$CFG['admin']['musics']['profile_mymusic_block_music_title']=5;
$CFG['admin']['musics']['profile_mymusic_block_music_total_length']=10;
$CFG['admin']['musics']['profile_mymusic_block_album_title']=5;
$CFG['admin']['musics']['profile_mymusic_block_album_total_length']=10;
//artist List
$CFG['admin']['musics']['artist_list_artist_title']=20;
$CFG['admin']['musics']['artist_list_music_title_total_length']=50;
//Album shelf limit
$CFG['admin']['musics']['profile_album_shelf_limit']=5;
/**
 * @#var				int Music description length
 * @#cfg_label 		Music description length
 * @#cfg_key 		caption_length_share_music
 * @#cfg_arr_type 	key
 * @#cfg_arr_key 	string
 */
$CFG['admin']['musics']['caption_length_share_music'] = 90;
/**
 * @#var				int Music description total char size
 * @#cfg_label 		Music description total character size
 * @#cfg_key 		description_total_char_share_music
 * @#cfg_arr_type 	key
 * @#cfg_arr_key 	string
 */
$CFG['admin']['musics']['description_total_char_share_music'] = 200;
//CURRENTLY PLAYING SETTINGS
$CFG['admin']['musics']['recent_view_musics_seconds'] = 30; // This value will be used by the recent videos FLASH XML genrating page.
$CFG['admin']['musics']['index_page_music_list_query_limit'] = 15;
$CFG['admin']['musics']['index_page_music_list_refresh_rates']=10000;
$CFG['admin']['musics']['index_page_music_list_song_text_color']='0xAAAAAA';
$CFG['admin']['musics']['index_page_music_list_song_text_bold']=true;
$CFG['admin']['musics']['index_page_music_list_song_text_style']='Tahoma'; //Font
$CFG['admin']['musics']['index_page_music_list_song_text_size']=12; //Font size
$CFG['admin']['musics']['index_page_music_list_album_text_color']='0x969696';
$CFG['admin']['musics']['index_page_music_list_album_text_bold']=false;
$CFG['admin']['musics']['index_page_music_list_album_text_style']='Tahoma'; //Font
$CFG['admin']['musics']['index_page_music_list_album_text_size']=12; //Font size
$CFG['admin']['musics']['index_page_music_list_thumbnail_gap']=5; //PX
$CFG['admin']['musics']['index_page_music_list_total_thumbnail']=4;

//MUSIC UPLOAD COMPULSORY FIELDS
/**
 * @#var				boolean Music Album Name Compulsory
 * @#cfg_label 		Album Name (Compulsory)
 * @#cfg_key 		music_upload_album_name_compulsory
 * @#cfg_sec_name 	Music Upload Compusory fields Settings
 * @#cfg_section 	Music Upload
 */
$CFG['admin']['musics']['music_upload_album_name_compulsory'] = false;
$CFG['admin']['musics']['music_upload_artist_name_compulsory'] = false;
$CFG['admin']['musics']['music_upload_release_year_compulsory'] = false;
//View Album Limit
$CFG['admin']['musics']['music_view_album_limit']=16;
$CFG['admin']['music_banner']['sidebanner1_250x250_not_allowed_pages'] = array('artistphoto');
$CFG['admin']['music_banner']['sidebanner2_250x250_not_allowed_pages'] = array('musicplaylist', 'managelyrics');
$CFG['admin']['musics']['albumlist_music_title_length']=38;
$CFG['admin']['musics']['albumlist_music_title_total_length']=38;
$CFG['admin']['musics']['albumlist_album_title_length']=25;
$CFG['admin']['musics']['albumlist_album_title_total_length']=25;
$CFG['admin']['musics']['albumlist_artist_title_length']=28;
$CFG['admin']['musics']['albumlist_artist_title_total_length']=28;
$CFG['admin']['musics']['viewalbum_album_name_length']=5;
$CFG['admin']['musics']['viewalbum_album_name_total_length']=10;
$CFG['admin']['musics']['viewalbum_length_limit']=2;

//user All Updates
$CFG['admin']['musics']['avtivity_title_length']=20;

//Music tracker
$CFG['admin']['musics']['music_tracker_music_title']=20;
$CFG['admin']['musics']['music_tracker_music_title_total_length']=50;
$CFG['admin']['musics']['music_tracker_album_title']=20;
$CFG['admin']['musics']['music_tracker_album_title_total_length']=50;
$CFG['admin']['musics']['music_tracker_category_title']=20;
$CFG['admin']['musics']['music_tracker_category_title_total_length']=50;
$CFG['admin']['musics']['music_tracker_artist_title_length']=20;
$CFG['admin']['musics']['music_tracker_artist_title_length_total_length']=50;
$CFG['admin']['musics']['music_tracker_description_title']=25;
$CFG['admin']['musics']['music_tracker_description_title_total_length']=90;

//index music
$CFG['admin']['musics']['indexmusicblock_album_title_length']=20;
$CFG['admin']['musics']['indexmusicblock_album_title_total_length']=15;

//CONFIG FOR INDIVIDUAL SONG PLAY - BY DEFAULT FALSE - HAVE TO SET TO TRUE ON THE PAGES USED (TO CONTROL VOLUME SLIDER)
$CFG['admin']['musics']['individual_song_play'] = false;

require_once($CFG['site']['project_path'].'common/configs/config_music_tables.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_music_url.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_music_fieldsize.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_music_encoder_command.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_music_player.inc.php');

//advertisment settings
$CFG['admin']['musics']['advertisement_format_arr'] = array('jpg', 'swf', 'flv');
$CFG['admin']['musics']['advertisement_audio_format_arr'] = array('mp3');
$CFG['admin']['musics']['advertisement_max_size'] = 500;//KB
$CFG['admin']['musics']['advertisement_audio_max_size'] = 5;//MB
$CFG['admin']['musics']['advertisement_image_folder'] = 'files/music_advertisement/advertisment_image/';
$CFG['admin']['musics']['advertisement_audio_folder'] = 'files/music_advertisement/advertisment_audio/';
$CFG['admin']['musics']['advertisement_image_height'] = '238';
$CFG['admin']['musics']['advertisement_image_width']  = '267';

$CFG['admin']['musics']['advertisement_image_single_width'] = 361;
$CFG['admin']['musics']['advertisement_image_single_height'] = 147;
$CFG['admin']['musics']['advertisement_image_single_name'] = 'S';

$CFG['admin']['musics']['advertisement_image_playlist_width'] = 267;
$CFG['admin']['musics']['advertisement_image_playlist_height'] = 238;
$CFG['admin']['musics']['advertisement_image_playlist_name'] = 'L';

//Music Player Settings
$CFG['profile']['featured_music_player_minimum_height'] = 163;
$CFG['profile']['featured_music_player_minimum_width'] = 382;
//ALBUM SHELF IN PROFILE
$CFG['profile']['featured_album_title_length'] = 20;
$CFG['profile']['featured_album_title_total_length'] = 25;

//Artist Promo Config start..
$CFG['admin']['musics']['artist_promo_small_width'] = 66;
$CFG['admin']['musics']['artist_promo_small_height'] = 66;
$CFG['admin']['musics']['artist_promo_small_name'] = 'S';

$CFG['admin']['musics']['artist_promo_thumb_width'] = 90;
$CFG['admin']['musics']['artist_promo_thumb_height'] = 90;
$CFG['admin']['musics']['artist_promo_thumb_name'] = 'T';

$CFG['admin']['musics']['artist_promo_large_width'] = 0;
$CFG['admin']['musics']['artist_promo_large_height'] = 0;
$CFG['admin']['musics']['artist_promo_large_name'] = 'L';

$CFG['admin']['musics']['artist_promo_medium_width'] = 450;
$CFG['admin']['musics']['artist_promo_medium_height'] = 300;
$CFG['admin']['musics']['artist_promo_medium_name'] = 'M';

$CFG['admin']['musics']['artist_promo_image_size'] = 500;
$CFG['admin']['musics']['artist_promo_allowed_image_type'] = array('jpg', 'jpeg', 'gif');
$CFG['admin']['musics']['artist_promo_image_folder'] = 'artist_promo_images';
$CFG['admin']['musics']['artist_image_members_folder'] = 'artist_member_images';

//music Lyrics Title  Config
$CFG['admin']['musics']['music_lyric_title_length'] = 60;
$CFG['admin']['musics']['music_lyric_title_total_length'] = 40;

//music featured content glider Config
$CFG['admin']['music']['featured_content_image_format_arr'] 	= array('jpg', 'jpeg', 'png');
$CFG['admin']['music']['featured_content_image_max_size'] 	= 500;
$CFG['admin']['music']['featured_content_image_folder']		='files/featured_content_images/';

$CFG['admin']['music']['featured_content_thumb_width'] = 240;
$CFG['admin']['music']['featured_content_thumb_height'] = 135;
$CFG['admin']['music']['featured_content_thumb_name'] = 'T';

//Assign Global Config Variable adult_content_view,adult_minimum_age to musics variable respectively *Do not move this variable to db.
$CFG['admin']['musics']['adult_content_view'] = $CFG['admin']['site']['adult_content_view'];
$CFG['admin']['musics']['adult_minimum_age'] = $CFG['admin']['site']['adult_minimum_age'];
?>