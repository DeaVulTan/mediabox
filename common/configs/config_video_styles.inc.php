<?php
/**
 * settings for $CFG['admin'][{template_name}]['videos']
 *
 * ..
 *
 * PHP version 5.0
 *
 * @category	..
 * @package		..
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @filesource
 **/
$config_file_name = 'config_'.$CFG['html']['template']['default'].'_video_styles.inc.php';
if(file_exists($CFG['site']['project_path'].'common/configs/templates_configs/'.$config_file_name))
	require_once($CFG['site']['project_path'].'common/configs/templates_configs/'.$config_file_name);

?>