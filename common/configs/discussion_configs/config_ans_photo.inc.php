<?php
/**
 * settings for $CFG['admin']['ans_photo']
 *
 * ..
 *
 * PHP version 5.0
 *
 * @category	..
 * @package		..
 * @author 		sridharan_08ag04
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id:
 * @since 		2008-12-19
 * @filesource
 **/
//for data thumb purbose only -- no use
$CFG['admin']['ans_photos']['folder'] = 'files/ans_photos/';
$CFG['admin']['ans_photos']['temp_folder'] = 'files/temp_files/ans_temp_photos/';

$CFG['admin']['ans_photos']['large_width'] = 120;
$CFG['admin']['ans_photos']['large_height'] = 120;
$CFG['admin']['ans_photos']['large_name'] = 'T';

$CFG['admin']['ans_photos']['thumb_width'] = 90;
$CFG['admin']['ans_photos']['thumb_height'] = 90;
$CFG['admin']['ans_photos']['thumb_name'] = 'T';

$CFG['admin']['ans_photos']['medium_width'] = 66;
$CFG['admin']['ans_photos']['medium_height'] = 66;
$CFG['admin']['ans_photos']['medium_name'] = 'M';

$CFG['admin']['ans_photos']['small_width'] = 45;
$CFG['admin']['ans_photos']['small_height'] = 45;
$CFG['admin']['ans_photos']['small_name'] = 'S';

$CFG['admin']['ans_photos']['tiny_width'] = 30;
$CFG['admin']['ans_photos']['tiny_height'] = 30;
$CFG['admin']['ans_photos']['tiny_name'] = 'S';

$CFG['admin']['ans_pictures']['large_name'] = 'L';
$CFG['admin']['ans_pictures']['thumb_name'] = 'T';
$CFG['admin']['ans_pictures']['small_name'] = 'S';

$CFG['admin']['ans_pictures']['small_width'] = 30;
$CFG['admin']['ans_pictures']['small_height'] = 30;


$CFG['admin']['site_logo']['format_arr']    = array('image/jpg', 'image/jpeg');
$CFG['admin']['site_favicon']['format_arr']    = array('image/x-icon');

$CFG['admin']['site_logo']['width'] = 295;
$CFG['admin']['site_logo']['height'] = 90;
$CFG['admin']['site_logo']['name'] = 'SL';

$CFG['admin']['site_favicon']['width'] = 32;
$CFG['admin']['site_favicon']['height'] = 32;
$CFG['admin']['site_favicon']['name'] = 'SF';

$CFG['admin']['site_logo']['temp_folder'] =  'files/temp_files/site_logo/';




/**
 * @var				array Allowed Photo Formats
 * @cfg_label 		Allowed Photo Formats
 * @cfg_key 		format_arr
 * @cfg_arr_type 	key
 * @cfg_arr_key 	string
 */
 // for ie browsers jpg should as pjpeg or pjpg
$CFG['admin']['ans_photos']['format_arr'] = array('image/jpg', 'image/pjpg', 'image/pjpeg', 'image/jpeg', 'image/gif');
/**
 * @var				int Allowed photo maximum size
 * @cfg_label 		Allowed photo maximum size(KB)
 * @cfg_key 		max_size
 * @cfg_arr_type 	key
 * @cfg_arr_key 	string
 */
$CFG['admin']['ans_photos']['max_size'] = 5000;
?>