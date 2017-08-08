<?php
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/manageBanner.php';
$CFG['html']['header'] = 'admin/html_header_popup.php';
$CFG['html']['footer'] = 'admin/html_footer_popup.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
$FormHandler = new FormHandler();
//TO override admin template settings
include($CFG['site']['project_path'].'common/configs/config_templates.inc.php');
include($CFG['site']['project_path'].'common/configs/config_styles.inc.php');

$FormHandler->setFormField('template_name', $CFG['html']['template']['default']);

$FormHandler->sanitizeFormInputs($_REQUEST);

if(!isset($CFG['admin'][$FormHandler->getFormField('template_name')]['banner']['default_banner_names']))
	$FormHandler->setFormField('template_name', $CFG['html']['template']['default']);

$banner_details_arr = $CFG['admin'][$FormHandler->getFormField('template_name')]['banner']['default_banner_names'];
?>
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/root/css/<?php echo $CFG['html']['stylesheet']['screen']['default'];?>/<?php echo $CFG['html']['stylesheet']['screen']['default_file'];?>.css">
<?php
//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//
// assign CFG and Config values
$FormHandler->assignSmartyVariables();
$smartyObj->assign('banner_details_arr', $banner_details_arr);

//Reassign Admin Template settings
$CFG['html']['template']['default'] = 'default';
$CFG['html']['stylesheet']['screen']['default'] = 'screen_grey';
$CFG['html']['stylesheet']['screen']['default_file'] = 'screen_grey';

$FormHandler->includeHeader();
//include the content of the page
setTemplateFolder('admin/');
$smartyObj->display('bannerDetails.tpl');
$FormHandler->includeFooter();
?>