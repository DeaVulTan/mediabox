<?php
/**
 * This file is to  photo List Display
 * This file is having photoUpload class to upload the photos
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 **/
require_once('../common/configs/config.inc.php');
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoHandler.lib.php';
$CFG['db']['is_use_db'] = true;
$CFG['auth']['is_authenticate'] = false;
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');

$photodetail = new PhotoHandler();
$photodetail->setFormField('action','');
$photodetail->sanitizeFormInputs($_REQUEST);
$photodetail->memberLoginPhotoUrl = getUrl('login');
if($photodetail->getFormField('action')=='add' || $photodetail->getFormField('action')=='remove')
{
$photodetail->checkLoginStatusInAjax($photodetail->memberLoginPhotoUrl);
$photo_ids=$_REQUEST['photo_ids'];
$photo_ids=str_replace('[','',$photo_ids);
$photo_ids=str_replace(']','',$photo_ids);
$photo_ids=str_replace('"','',$photo_ids);
$photo_ids=str_replace('\\','',$photo_ids);
$photo_id_arr=explode(',',$photo_ids);
$photo_id=$photo_id_arr[count($photo_id_arr)-1];
if($photo_id)
$photo_url=getPhotoUrl(trim($photo_id));
else
$photo_url='';
?>
{"photo_ids":[<?php echo $photo_ids;?>],"url":"<?php echo str_replace('/','\/',$photo_url);?>"}
<?php
}
?>
