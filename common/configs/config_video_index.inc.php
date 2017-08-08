<?php
/**
 * settings for $CFG['admin']['index']
 *
 * PHP version 3.0
 *
 * @category	..
 * @package		..
 * @author 		palani_34ag07
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: config_photo.inc.php 937 2003-03-30 08:23:03Z selvaraj_33ag03 $
 * @since 		2007-08-07
 * @filesource
 **/
/**
 * @var				boolean Show Random Video
 * @cfg_label 		Show Random Video
 * @cfg_key 		randomvideo
 * @cfg_sec_name 	Index Page Video Settings
 * @cfg_section 	index_page_video_settings
 */
$CFG['admin']['videos']['randomvideo'] = true;
/**
 * @var				boolean Show Recommended Video
 * @cfg_label 		Show Recommended Video
 * @cfg_key 		recommendedvideo
 */
$CFG['admin']['videos']['recommendedvideo'] = true;
/**
 * @var				int Total No of Rows Display
 * @cfg_label 		Total No of Rows Display
 * @cfg_key 		total_no_of_row_record
 */
$CFG['admin']['videos']['total_no_of_row_record'] = 2;
/**
 * @var				int Total Recommended Video To  Display
 * @cfg_label 		Total Recommended Video To  Display
 * @cfg_key 		recommendedvideo_total_record
 */
$CFG['admin']['videos']['recommendedvideo_total_record'] = 4;
/**
 * @var				boolean Show Top Rated Video
 * @cfg_label 		Show Toprated Video
 * @cfg_key 		topratedvideo
 */
$CFG['admin']['videos']['topratedvideo'] = true;
/**
 * @var				int Total Toprated Video To  Display
 * @cfg_label 		Total Toprated Video To  Display
 * @cfg_key 		topratedvideo_total_record
 */
$CFG['admin']['videos']['topratedvideo_total_record'] = 4;
/**
 * @var				boolean Show New Video
 * @cfg_label 		Show New Video
 * @cfg_key 		newvideo
 */
$CFG['admin']['videos']['newvideo'] = true;
/**
 * @var				int Total New Video To  Display
 * @cfg_label 		Total New Video To  Display
 * @cfg_key 		newvideo_total_record
 */
$CFG['admin']['videos']['newvideo_total_record'] = 4;
/**
 * @var				boolean Show Recently Viewed Video
 * @cfg_label 		Show Recently Viewed Video
 * @cfg_key 		recentlyviewedvideo
 */
$CFG['admin']['videos']['recentlyviewedvideo'] = true;
/**
 * @var				int Total New Video To  Display
 * @cfg_label 		Total New Video To  Display
 * @cfg_key 		recentlyviewedvideo_total_record
 */
$CFG['admin']['videos']['recentlyviewedvideo_total_record'] = 4;
/**
 * @var				boolean Show Cool People
 * @cfg_label 		Show Cool People
 * @cfg_key 		cool_new_people
 * @cfg_sec_name 	Cool People Settings
 * @cfg_section 	Cool People Settings
 */
$CFG['admin']['member']['cool_new_people'] = true;
/**
 * @var				int Total Cool People To  Display
 * @cfg_label 		Total Cool People To  Display
 * @cfg_key 		cool_new_people_total_record
 */
$CFG['admin']['member']['cool_new_people_total_record'] = 25;
/**
 * @var				boolean Show External Link
 * @cfg_label 		Show External Link
 * @cfg_key 		external_link
 * @cfg_sec_name 	External Link Settings
 * @cfg_section 	External Link Settings
 */
$CFG['admin']['urls']['external_link'] = true;
/**
 * @var				int Total External Link To
 * @cfg_label 		Total External Link To  Display
 * @cfg_key 		external_link_total_record
 */
$CFG['admin']['urls']['external_link_total_record'] = 2;
/**
 * @var				int Total Video Channel To Display
 * @cfg_label 		Total Video Channel To Display
 * @cfg_key 		videochannel_total_record
 */
$CFG['admin']['videos']['videochannel_total_record'] = 4;
/**
 * @var				int Total Video Channel Row To Display
 * @cfg_label 		Total Video Channel Row To Display
 * @cfg_key 		videochannel_total_row
 */
$CFG['admin']['videos']['videochannel_total_row'] = 1;
/**
 * @var				int Total Video Channel Row To Display
 * @cfg_label 		Total Video Channel Row To Display
 * @cfg_key 		videochannel_total_row
 */
?>