<?php
/**
 * This file is to  display the original image
 * This file is having photoUpload class to upload the photos
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 **/
require_once('../common/configs/config.inc.php');
$CFG['db']['is_use_db'] = true;
$CFG['auth']['is_authenticate'] = false;
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');

$photodetail = new FormHandler();
$photodetail->setFormField('photo_url','');
$photodetail->setFormField('title','');
$photodetail->sanitizeFormInputs($_REQUEST);
$photodetail->includeHeader();
setTemplateFolder('general/', 'photo');
$smartyObj->display('viewOriginalPhoto.tpl');
?>
