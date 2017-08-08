<?php
//used to show the positions of the banners in the site , called from the admin panel
require_once('./common/configs/config.inc.php');
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
$FormHandler = new FormHandler();
$image_path = $CFG['site']['url'].'design/templates/'.$CFG['html']['template']['default'].'/images/banner_position.jpg';
//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//
// assign CFG and Config values
$FormHandler->assignSmartyVariables();
$smartyObj->assign('image_path', $image_path);

//include the content of the page
setTemplateFolder('general/');
$smartyObj->display('bannerPosition.tpl');
?>