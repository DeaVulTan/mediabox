<?php
/**
 * @#var				string Water Mark Image Name
 * @#cfg_label 		Water Mark Image Name
 * @#cfg_key 		image_name
 * @#cfg_arr_type 	key
 * @#cfg_arr_key 	string
 */
$CFG['admin']['watermark']['image_name']='watermark.jpg';
/**
 * @var				array Allowed Water Mark Image Formats
 * @cfg_label 		Allowed Water Mark Image Formats
 * @cfg_key 		water_mark_format_arr
 * @cfg_arr_type 	key
 * @cfg_arr_key 	string
 * @cfg_sec_name 	Watermark Image Settings
 * @cfg_section 	miscellaneous
 */
$CFG['admin']['watermark']['water_mark_format_arr'] = array('jpg', 'jpeg', 'png');
/**
 * @var				int Allowed Water Mark Image maximum size
 * @cfg_label 		Allowed Water Mark Image maximum size (In KB)
 * @cfg_key 		water_mark_max_size
 * @cfg_arr_type 	key
 * @cfg_arr_key 	string
 */
$CFG['admin']['watermark']['water_mark_max_size'] = 40000;
/**
 * @var				int Water Mark Text Image Width
 * @cfg_label 		Water Mark Text Image Width
 * @cfg_key 		water_mark_text_width
 * @cfg_arr_type 	key
 * @cfg_arr_key 	string
 */
$CFG['admin']['watermark']['water_mark_text_width']=100;
/**
 * @var				int Water Mark Text Image Height
 * @cfg_label 		Water Mark Text Image Height
 * @cfg_key 		water_mark_text_height
 * @cfg_arr_type 	key
 * @cfg_arr_key 	string
 */
$CFG['admin']['watermark']['water_mark_text_height']=50;
/**
 * @var				int Water Mark Text Image X position
 * @cfg_label 		Water Mark Text Image X position
 * @cfg_key 		water_mark_text_xposition
 * @cfg_arr_type 	key
 * @cfg_arr_key 	string
 */
$CFG['admin']['watermark']['water_mark_text_xposition']=0;
/**
 * @var				int Water Mark Text Image Y position
 * @cfg_label 		Water Mark Text Image Y position
 * @cfg_key 		water_mark_text_yposition
 * @cfg_arr_type 	key
 * @cfg_arr_key 	string
 */
$CFG['admin']['watermark']['water_mark_text_yposition']=0;
/**
 * @#var				string Water Mark Type
 * @#cfg_label 		Water Mark Type
 * @#cfg_key 		water_mark_type
 * @#cfg_arr_type 	key
 * @#cfg_arr_key 	string
 */
$CFG['admin']['watermark']['water_mark_type']='font';
/**
 * @#var				string Water Mark Text Image Back Ground Color
 * @#cfg_label 		Water Mark Text Image Back Ground Color
 * @#cfg_key 		water_mark_text_image_back_ground_color
 * @#cfg_arr_type 	key
 * @#cfg_arr_key 	string
 */
$CFG['admin']['watermark']['water_mark_text_image_back_ground_color']='black';
/**
 * @#var				string Water Mark Text Image Text Color
 * @#cfg_label 		Water Mark Text Image Text Color
 * @#cfg_key 		water_mark_text_image_text_color
 * @#cfg_arr_type 	key
 * @#cfg_arr_key 	string
 */
$CFG['admin']['watermark']['water_mark_text_image_text_color']='SkyBlue';
/**
 * @#var				int Water Mark Text Image Text Size
 * @#cfg_label 		Water Mark Text Image Text Size
 * @#cfg_key 		water_mark_text_image_text_size
 * @#cfg_arr_type 	key
 * @#cfg_arr_key 	string
 */
$CFG['admin']['watermark']['water_mark_text_image_text_size']=4;
/**
 * @#var				string Water Mark Text Image Text
 * @#cfg_label 		Water Mark Text Image Text
 * @#cfg_key 		water_mark_text_image_text
 * @#cfg_arr_type 	key
 * @#cfg_arr_key 	string
 */
$CFG['admin']['watermark']['water_mark_text_image_text']='Mediabox.Uz';

$CFG['admin']['watermark']['image_width']  = 200;
$CFG['admin']['watermark']['image_height'] = 100;
?>