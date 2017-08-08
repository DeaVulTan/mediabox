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
//display the header tpl file
setTemplateFolder('admin/');
if($HeaderHandler->isShowPageBlock('headerBlock'))
	{
		$smartyObj->assign_by_ref('header', $HeaderHandler);
		$smartyObj->display('html_header_no_header.tpl');
	}
?>