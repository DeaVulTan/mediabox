<?php
/**
 * config to include music template related styles
 *
 * ..
 *
 * PHP version 5.0
 *
 * @category	..
 * @package		..
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @filesource
 **/
$config_file_name = 'config_'.$CFG['html']['template']['default'].'_music_styles.inc.php';
if(file_exists($CFG['site']['project_path'].'common/configs/templates_configs/'.$config_file_name))
	require_once($CFG['site']['project_path'].'common/configs/templates_configs/'.$config_file_name);

?>