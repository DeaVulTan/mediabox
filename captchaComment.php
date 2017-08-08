<?php
/**
 * To show the turing text in the signup file
 *
 * This file is used to display the turing text to the user in the signup page
 * and the user must type the text present in the image. This will improve the
 * security by verifying the presence of the user.
 *
 * PHP version 5.0
 *
 * @category	Rayzz
 * @package		Index
 */
/**
 * File having common configuration variables required for the entire project
 */
require_once('./common/configs/config.inc.php');
$CFG['html']['is_use_header'] = false;
//$CFG['html']['header'] = 'members/includes/languages/'.$CFG['lang']['default'].'/html_header.php';;
$CFG['html']['is_use_footer'] = false;
$CFG['http_headers']['is_cache'] = false;
$CFG['http_headers']['is_use_if_modified_since'] = false;

/**
 * File to include the header file, database access file, session management file, help file and necessary functions
 */
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//----------------------------- Code begins ------------------>>>>>//
$captcha_text = $_GET['captcha_value']; // if len is 2, 10 to 99
$_SESSION[$_GET['captcha_key']] = $captcha_text; //stuff to session

//configurations....
$arc_count        = 8;
$arc_deg_vary     = 30;
$arc_pad_max      = 20;
$arc_pad_min      = 5;
$color_bg_max     = 15;
$color_bg_min     = 10;
$color_fg_max     = 12;
$color_fg_min     = 11;
$font_angle_max   = 20;
$font_angle_min   = -20;
$font_padding     = 2;
$font_size_max    = 18;
$font_size_min    = 15;

$font_dir = $CFG['site']['project_path'].'common/gd_fonts/';

// This array contains the list of font names and the number the base font size should be multiplied by to make all the fonts appear about the same height.
$fonts = array(
    'arial.ttf'      	=> 1.5,
	'realpolitik.ttf' 	=> 1.5	//downloaded from http://www.webpagepublicity.com/free-fonts-r.html#FreeFonts
	);

//calculate the text measurements...
$image_width  = 0;
$image_height = 0;
$data         = array();

for ($i = 0; $i < strlen($captcha_text); $i++)
	{
	    $char = substr($captcha_text, $i, 1);

	    $font_name = array_rand($fonts);
	    $font      = $font_dir . $font_name;

	    $size  = mt_rand($font_size_min, $font_size_max) * $fonts[$font_name];
	    switch ($char)
			{
		        case 'Q':
		            // Keep Q's tail from being off the bottom of the image.
		            $angle = mt_rand(0, $font_angle_max);
		            break;
		        default:
		            $angle = mt_rand($font_angle_min, $font_angle_max);
		    }

	    $bbox   = imagettfbbox($size, $angle, $font, $char);
	    $width  = max($bbox[2], $bbox[4]) - min($bbox[0], $bbox[6]);
	    $height = max($bbox[1], $bbox[3]) - min($bbox[7], $bbox[5]);

	    $image_width += $width + $font_padding;
	    $image_height = max($image_height, $height);

	    $data[] = array(
	        'font'   => $font,
	        'char'   => $char,
	        'size'   => $size,
	        'angle'  => $angle,
	        'height' => $height,
	        'width'  => $width,
	    );
	}

$image_width -= $font_padding;

//base image...
$im = imagecreate($image_width, $image_height);

//Colors: 0 is the background color
//        1 through x are the foreground colors.
$colors = array(
    imagecolorallocate($im, 132, 178, 212),
    imagecolorallocate($im, 86, 157, 1),
    imagecolorallocate($im, 117, 112, 109),
	);
$color_max = count($colors) - 1;

//display text
$pos_x = 0;
$y_min = $image_height - 15;
$y_max = $image_height - 3;

foreach ($data as $d)
	{
	    $pos_y  = mt_rand($y_min, $y_max);
	    imagettftext($im, $d['size'], $d['angle'], $pos_x, $pos_y,
	                 $colors[mt_rand(1, $color_max)], $d['font'], $d['char']);
	    $pos_x += $d['width'] + $font_padding;
	}

//arcs
for ($i = 0; $i < $arc_count; $i++)
	{
	    // Start on left side, arc upward, then ending on the right side.
	    $start = mt_rand(180 - $arc_deg_vary, 180 + $arc_deg_vary);
	    $end   = mt_rand(0 - $arc_deg_vary, $arc_deg_vary);
	    if ($end < 0)
	        $end = 360 - $end;

	    $half_w   = $image_width / 2;
	    $center_x = mt_rand($half_w - $arc_pad_min, $half_w + $arc_pad_min);
	    $tmp_w    = ($half_w - abs($half_w - $center_x)) * 2;
	    $width    = mt_rand($tmp_w - $arc_pad_min, $tmp_w - $arc_pad_max);
	    $center_y = mt_rand($image_height / 2, $image_height - $arc_pad_min);
	    $height   = mt_rand(3, $center_y * 2 - $arc_pad_min);

	    if ($i % 2)
			{
		        // Flip arc to a downward one.
		        $tmp      = $end;
		        $end      = $start;
		        $start    = $tmp;
		        $center_y = $image_height - $center_y;
		    }

	    imagearc($im, $center_x, $center_y, $width, $height,
	             $start, $end, $colors[mt_rand(0, $color_max)]);
	}

//image output...
header('Content-type: image/jpeg');
imagejpeg($im, null, 100);
//<<<<<------------------------- Code ends ----------------------------------//
/**
 * File to include the footer file and show benchmarking for developer
 */
require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');
?>