<?php
/**
 * settings for $CFG['admin']['video']
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
 * @version		SVN: $Id: config_photo.inc.php 937 2006-05-30 08:26:06Z selvaraj_35ag05 $
 * @since 		2006-05-04
 * @filesource
 **/
/**
 * @var				boolean video first clip
 * @cfg_label 		Video First Clip
 * @cfg_key 		VideoImage
 * @cfg_sec_name 	Player Settings
 * @cfg_arr_type 	key
 * @cfg_arr_key 	string
 */
$CFG['admin']['videos']['TopUrlUrl'] = true;
$CFG['admin']['videos']['TopUrlTargetUrl'] = '';
$CFG['admin']['videos']['TopUrl'] = false;
$CFG['admin']['videos']['TopUrlType'] = 'img';
$CFG['admin']['videos']['TopUrlDuration'] = 0;

$CFG['admin']['videos']['TailUrlUrl'] = '';
$CFG['admin']['videos']['TailUrlTargetUrl'] = '';
$CFG['admin']['videos']['TailUrl'] = false;
$CFG['admin']['videos']['TailUrlType'] = 'img';
$CFG['admin']['videos']['TailUrlDuration'] = 0;

$CFG['admin']['videos']['Logo'] = false;
$CFG['admin']['videos']['LogoUrl'] = '';
$CFG['admin']['videos']['LogoTargetUrl'] = '';
$CFG['admin']['videos']['LogoTransparency'] = 0;
$CFG['admin']['videos']['LogoRollOverTransparency'] = 0;
$CFG['admin']['videos']['LogoPosition'] = 0;

$CFG['admin']['videos']['SelectedLoader'] = 'loading.swf';
$CFG['admin']['videos']['Volume'] = 'low';
$CFG['admin']['videos']['TooltipEnabled'] = true;
$CFG['admin']['videos']['LockAllControls'] = 'false';
$CFG['admin']['videos']['InitVolume'] = 20;
//image/video
$CFG['admin']['videos']['FirstFrameAsValue'] = 'image';
$CFG['admin']['videos']['FirstFrameAsFrameAt'] = 2;
$CFG['admin']['videos']['ShowMiniShareButton'] = true;
$CFG['admin']['videos']['ShowShareButton'] = true;
$CFG['admin']['videos']['ShowReplyButton'] = true;
$CFG['admin']['videos']['FullScreenControls'] = true;
$CFG['admin']['videos']['ShowMiniLogo'] = false;

//you can use either 'elite' or 'premium' player
$CFG['admin']['videos']['SelectedPlayer'] = 'premium';
$CFG['admin']['videos']['playList'] = true;

//ELITE PLAYER CONFIG
$CFG['admin']['videos']['elite_player']['swf_name']='flvplayer_elite';
$CFG['admin']['videos']['elite_player']['config_name']='elite_videoConfigXmlCode';
$CFG['admin']['videos']['elite_player']['xml_theme']='skin.xml';
$CFG['admin']['videos']['elite_player']['skin_name']='elite_skin';


//PREMIUM PLAYER CONFIG
$CFG['admin']['videos']['premium_player']['swf_name']='flvplayer';
$CFG['admin']['videos']['premium_player']['config_name']='videoConfigXmlCode';
$CFG['admin']['videos']['premium_player']['xml_theme']='skin.xml';
$CFG['admin']['videos']['premium_player']['skin_name']='skin';

//MINI PLAYER CONFIG
$CFG['admin']['videos']['mini_player']['swf_name']='mini_flvplayer';
$CFG['admin']['videos']['mini_player']['config_name']='videoConfigXmlCode';
$CFG['admin']['videos']['mini_player']['xml_theme']='skin.xml';
$CFG['admin']['videos']['mini_player']['skin_name']='skin';

//others
$CFG['admin']['flv']['skin_path'] = 'files/flash/video/flvplayers/skins/';

$CFG['admin']['recorder']['skin_path']='files/flash/video/quickcapture/skins/';

?>