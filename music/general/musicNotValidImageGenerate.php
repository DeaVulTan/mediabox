<?php
/**
 * This File is used for embedMusicPlayer
 *
 * @category	Rayzz
 * @package		embedMusicPlayer
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 */
 
function LoadGif($err_tip)
	{
		global $CFG;
        $im = imagecreatetruecolor ($CFG['admin']['musics']['large_width'], $CFG['admin']['musics']['large_height']); /* Create a blank image */
        $bgc = imagecolorallocate ($im, 0, 0, 0);
        $tc = imagecolorallocate ($im, 255, 3, 100);
        imagefilledrectangle ($im, 0, 0, 150, 30, $bgc);
        /* Output an errmsg */
        imagestring ($im, 1, 5, 5, "$err_tip", $tc);
	    return $im;
	}
header("Content-Type: image/gif");
$err_tip=(isset($_GET['get_image']) and isset($LANG['err_tip_'.$_GET['get_image']]))?$LANG['err_tip_'.$_GET['get_image']]:$LANG['err_tip_normal'];
$img = LoadGif($err_tip);
imagegif($img);

?>