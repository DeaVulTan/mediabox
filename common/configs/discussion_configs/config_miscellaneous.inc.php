<?php
/**
 * settings for $CFG
 *
 * ..
 *
 * PHP version 5.0
 *
 * @category	..
 * @package		..
 * @author 		selvaraj_47ag04
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id:
 * @since 		2008-12-19
 * @filesource
 **/
//Miscellaneous
$CFG['user_details'] = array();
/**
 * @cfg_sec_name 	miscellaneous
 * @cfg_section 	miscellaneous_settings
 * @var				string php date format
 * @cfg_label 		Php Date format
 * @cfg_key 		php_format_date
 */
$CFG['php_format']['date'] = '%Y-%m-%d';
/**
 * @var				string php date time format
 * @cfg_label 		Php datetime format
 * @cfg_key 		php_format_date_time
 */
$CFG['php_format']['date_time'] = '%Y-%m-%d %H:%M:%S';
/**
 * @var				string mysql date format
 * @cfg_label 		Mysql Date format
 * @cfg_key 		date
 */
$CFG['mysql_format']['date'] = '%Y-%m-%d';
/**
 * @var				string mysql date time format
 * @cfg_label 		Mysql datetime format
 * @cfg_key 		date_time
 */
$CFG['mysql_format']['date_time'] = '%Y-%m-%d %H:%i:%s';
/**
 * @var				string mysql date format
 * @cfg_label 		New Mysql date format
 * @cfg_key 		new_date
 */
$CFG['mysql_format']['new_date'] = '%d-%b-%Y';
/**
 * @var				string mysql date time format
 * @cfg_label 		New Mysql datetime format with am/pm
 * @cfg_key 		new_date_time_meridian
 */
$CFG['mysql_format']['date_time_meridian'] = '%d-%b-%Y, %h:%m %p';
/**
 * @var				boolean impression date
 * @cfg_label 		Impressions date
 * @cfg_key 		impressions_date
 */
$CFG['admin']['banner']['impressions_date'] = true;
/**
 * @var				string starting text
 * @cfg_label 		Starting text
 * @cfg_key 		starting_text
 */
$CFG['cookie']['starting_text'] = preg_replace('/[^[:alpha:]+]/', '', $CFG['site']['name']);
/**
 * @var				int send count
 * @cfg_label 		Send count
 * @cfg_key 		send_count
 */
$CFG['news_letter']['send_count'] = 20;
/**
 * @var				int language cache time
 * @cfg_label 		Language cache time
 * @cfg_key 		language_cache_time
 */
$CFG['javascript']['language_cache_time'] = 600;//600 sec
/**
 * @var				string end character
 * @cfg_label 		End character
 * @cfg_key 		end_character
 */
$CFG['word_limiter']['end_character'] = '....';
/**
 * @var				string currency
 * @cfg_label 		End character
 * @cfg_key 		currency
 */
$CFG['admin']['light_window_pages'] = array('boards', 'solutions');
$CFG['admin']['is_online_allowed'] = true;
$CFG['admin']['dafault_order'] = '15,0,0,12,13,14,9,10,11,6,7,8,3,4,5,1,2,16';
//$CFG['site']['jserror_block'] = false;
/**
 * @var				boolean Is show/hide tab allowed
 * @cfg_label 		Is show/hide tab allowed
 * @cfg_key 		side_bar_show_hide
 */
$CFG['side_bar']['show_hide'] = true;
$CFG['comments']['expand_collapse'] = false;
$CFG['members']['discussion_xml'] = 'http://anova.tv/tickets/discussion.xml';
?>