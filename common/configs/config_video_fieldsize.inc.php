<?php
/**
 * settings for $CFG['fieldsize'] (Video Module)
 *
 * ..
 *
 * @category	..
 * @package		..
 * @copyright	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: config_fieldsize.inc.php 546 2008-04-30 08:30:03Z madanagopal_25ag08 $
 * @since 		2008-04-02
 * @filesource
 **/

/**
 * @var				int Playlist name fieldsize for minimum charecter
 * @cfg_sec_name 	Edit video fieldsize
 * @cfg_label 		playlist name minimum
 * @cfg_key 		min_playlist_name
 */
$CFG['fieldsize']['playlist_name']['min'] = 2;
/**
 * @var				int Playlist name fieldsize for maximum charecter
 * @cfg_label 		Playlist name maximum
 * @cfg_key 		max_playlist_name
 */
$CFG['fieldsize']['playlist_name']['max'] = 25;
$CFG['fieldsize']['album_name']['min'] = 3;
$CFG['fieldsize']['album_name']['max'] = 25;

$CFG['fieldsize']['video_page_title']['max'] = 30;
$CFG['fieldsize']['video_meta_keyword']['max'] = 50;
$CFG['fieldsize']['video_meta_description']['max'] = 150;
?>