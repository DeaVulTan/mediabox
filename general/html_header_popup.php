<?php
class HeaderFormHandler extends HeaderHandler
	{

	}

$HeaderHandler = new HeaderFormHandler();
$HeaderHandler->setPageBlockNames(array('headerBlock'));


$HeaderHandler->sanitizeFormInputs($_REQUEST);
$HeaderHandler->setAllPageBlocksHide();
$HeaderHandler->setPageBlockShow('headerBlock');


//assign for populate the language list in header
$HeaderHandler->populateLanguageDetails();
$HeaderHandler->populateTemplateDetails();
$smartyObj->assign('isMember', isMember());
$smartyObj->assign('isAdmin', isAdmin());

$header_popup_module = '';
if(isset($CFG['site']['is_module_page']) and !empty($CFG['site']['is_module_page']))
	$header_popup_module = $CFG['site']['is_module_page'];

$html_header_popup_file = $CFG['site']['project_path'].$header_popup_module.'/design/templates/'.$CFG['html']['template']['default'].'/general/html_header_popup.tpl';
if(!is_file($html_header_popup_file))
	$header_popup_module = '';

//Get site logo and favicon from corresponding directory
$dir = $CFG['site']['project_path'].'design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/header/';
$logodir = $dir.'logo/';
$favicondir = $dir.'favicon/';
$logo_extn = $HeaderHandler->getSiteLogoAndFavicon($logodir, 'logo');
$favicon_extn = $HeaderHandler->getSiteLogoAndFavicon($favicondir, 'favicon');
$image_path = $CFG['site']['url'].'design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/header/';
$HeaderHandler->logo_url = $image_path.'logo/logo.'.$logo_extn;
$HeaderHandler->favicon_url = $image_path.'favicon/favicon.'.$favicon_extn;


//display the header tpl file
setTemplateFolder('members/', $header_popup_module);
if($HeaderHandler->isShowPageBlock('headerBlock'))
	{
		$smartyObj->assign_by_ref('header', $HeaderHandler);
		$smartyObj->display('../general/html_header_popup.tpl');
	}
?>