<?php
/**
 * settings for $CFG['fieldsize'] (Music Module)
 *
 * ..
 *
 * PHP version 5.0
 *
 * @category	..
 * @package		..
 * @author 		shankar_76ag08
  * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @since 		2009-06-30
 * @filesource
 **/

$CFG['fieldsize']['music_playlist_name']['min'] = 2;
/**
 * @var				int Playlist name fieldsize for maximum charecter
 * @cfg_sec_name 	Edit music fieldsize
 * @cfg_label 		Playlist name maximum
 * @cfg_key 		max_playlist_name
 */
$CFG['fieldsize']['music_playlist_name']['max'] = 25;

$CFG['fieldsize']['music_tags']['min'] = 3;
$CFG['fieldsize']['music_tags']['max'] = 20;
$CFG['fieldsize']['music_artist']['min'] = 3;
$CFG['fieldsize']['music_artist']['max'] = 35;
$CFG['fieldsize']['music_album_name']['min'] = 3;
$CFG['fieldsize']['music_album_name']['max'] = 25;
$CFG['fieldsize']['music_playlist_tags']['min'] = 3;
$CFG['fieldsize']['music_playlist_tags']['max'] = 20;

?>