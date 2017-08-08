<?php
/**
 * PlaySlideShow
 *
 * @category	Rayzz
 * @package		General
 * @author 		shankar_044at09
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 */
class SlideShow extends PhotoHandler
{


}
$slideshow = new SlideShow();
$slideshow->setPageBlockNames(array('block_photo_slide_show','block_photo_add_quickmix'));
$slideshow->setFormField('slideshow', '');
$slideshow->setFormField('playlist', '');
$slideshow->setAllPageBlocksHide();
$photoDetais=array();
$slideshow->sanitizeFormInputs($_REQUEST);
if($slideshow->getFormField('slideshow')=='ql')
{
	if(isset($_SESSION['user']['photo_quick_mixs']) && !empty($_SESSION['user']['photo_quick_mixs']))
	{
		$slideshow->setPageBlockShow('block_photo_slide_show');
	}
	else
	{
		$slideshow->setPageBlockShow('block_photo_add_quickmix');
	}
}
else if($slideshow->getFormField('slideshow')=='pl')
{
	$slideshow->setPageBlockShow('block_photo_slide_show');
}
else if($slideshow->getFormField('slideshow')=='al')
{
	$slideshow->setPageBlockShow('block_photo_slide_show');
}
$slideshow->includeHeader();

if($slideshow->isShowPageBlock('block_photo_slide_show'))
{
	$referer = @$_SERVER["HTTP_REFERER"];
	$slideshow->configPath = $CFG['site']['url'].'files/flash/photo/';
	$slideshow->default_template = '';
	if($CFG['html']['template']['default']!='bluechill')
	{
		$slideshow->default_template = $CFG['html']['template']['default'].'_';
	}
	$slideshow->configxmlPath = $CFG['site']['photo_url'].'slideShowConfigXml.php?slideshow='.$slideshow->getFormField('slideshow').'_'.$slideshow->getFormField('playlist').'~~'.$referer;
}
setTemplateFolder('general/', $CFG['site']['is_module_page']);
$smartyObj->display('flashShow.tpl');
$slideshow->includeFooter();
?>