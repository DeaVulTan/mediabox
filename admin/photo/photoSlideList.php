<?php
/**
* This file is to manage the Photo Play List
*
* This file is having Photo Play List
*
*
* @category	    Rayzz PhotoSharing
* @package		Admin
* @copyright 	Copyright (c) 2010 {@link http://www.mediabox.uz Uzdc Infoway}
* @license		http://www.mediabox.uz Uzdc Infoway Licence
**/

require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/photo/admin/photoSlideList.php';
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

class PhotoPlayList extends MediaHandler{
}
//<<<<<-------------- Class obj begins ---------------//
$photoPlayList = new PhotoPlayList();
$photoPlayList->left_navigation_div = 'photoMain';
//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$photoPlayList->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'photo');
$smartyObj->display('photoSlideList.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
$photoPlayList->includeFooter();
?>