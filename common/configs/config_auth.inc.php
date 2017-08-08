<?php
/**
 * settings for $CFG['auth']
 *
 * ..
 *
 * PHP version 5.0
 *
 * @category	..
 * @package		..
 * @author 		selvaraj_47ag04
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: config_tables.inc.php 115 2008-03-26 11:42:35Z vidhya_29ag04 $
 * @since 		2008-04-02
 * @filesource
 **/
//Authentication settings
//no authenticate folders... strictly no to authentication. Warning: careful in changing this
//$CFG['auth']['no_authenticate_folders'] = '*';
$CFG['auth']['no_authenticate_folders'][] = $CFG['site']['project_path_relative'].'admin/';  //admin folder needs different authentication
//$CFG['auth']['protected_folders'] = '*';
$CFG['auth']['protected_folders'][] = $CFG['site']['project_path_relative'].'members/';
if(isset($CFG['site']['modules_arr']))
	{
		foreach($CFG['site']['modules_arr'] as $module)
		{
			$CFG['auth']['protected_folders'][] = $CFG['site']['project_path_relative'].$module.'/members/';
			$CFG['auth']['no_authenticate_folders'][] = $CFG['site']['project_path_relative'].'admin/'.$module.'/';
		}
	}
$CFG['auth']['ajax_url'] = $CFG['site']['url'].'ajaxUrl.php';
?>