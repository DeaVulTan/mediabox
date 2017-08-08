<?php
$HeaderHandler = new HeaderHandler();
$smartyObj->assign_by_ref('header', $HeaderHandler);

//assign for populate the language list in header
$HeaderHandler->populateLanguageDetails();
$HeaderHandler->populateTemplateDetails();

$smartyObj->assign('isMember', isMember());
$smartyObj->assign('isAdmin', isAdmin());
//display the header tpl file
setTemplateFolder('admin/');
$smartyObj->display('html_header_popup.tpl');
?>