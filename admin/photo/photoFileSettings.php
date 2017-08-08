<?php
/**
* This file for photo file settings
*
* This file is having photo file settings
*
*
* @category	    Rayzz PhotoSharing
* @package		Admin
* @copyright 	Copyright (c) 2010 {@link http://www.mediabox.uz Uzdc Infoway}
* @license		http://www.mediabox.uz Uzdc Infoway Licence
**/

require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/photo/admin/photoFileSettings.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/help.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/months_list_array.inc.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['site']['is_module_page'] = 'photo';
require_once($CFG['site']['project_path'] . 'common/application_top.inc.php');

class PhotoFileSettings extends MediaHandler{
}
//<<<<<-------------- Class obj begins ---------------//
$photoFileSettings = new PhotoFileSettings();
$photoFileSettings->left_navigation_div = 'photoMain';
//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$photoFileSettings->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'photo');
$smartyObj->display('photoFileSettings.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
$photoFileSettings->includeFooter();
?>