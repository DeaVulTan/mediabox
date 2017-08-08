<?php
/**
 * File handling set default language
 *
 * PHP version 5.0
 *
 * @category	###Framework###
 * @package		###Admin###
 * @author 		selvaraj_47ag04
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: manageBanner.php 211 2008-04-11 06:23:03Z selvaraj_47ag04 $
 * @since 		2008-04-02
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/setDefaultLanguage.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['include_files'][] = 'common/classes/class_XmlParser.lib.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
/**
 * Language Default
 */
class SetDefaultLanguage extends FormHandler
	{

	public function chkIsValidLanguageName($err_tip = '')
	{
		if(ereg('[^a-zA-Z0-9_]', $this->getFormField('language')))
		{
			$this->setFormFieldErrorTip('language', $err_tip);
			return false;
		}
		return true;
	}
	public function writeDefaultLanguage($lang_name)
	{
		global $CFG;
		$file = '../common/configs/config_lang.inc.php';
		$data = read_file($file);
		if(isset($this->CFG['translated_lang'][$lang_name]))
		{
			$search = '$CFG[\'lang\'][\'default\']';
			$lang_start = strpos($data, '$CFG[\'lang\'][\'default\']') ;
			$lang_end = strpos($data, '=') ;
			$lang_pos = substr($data, $lang_start, $lang_end) ;
			$search_lang=explode(';',$lang_pos);
			$search_language=$search_lang[0].';';
			$replace = '$CFG[\'lang\'][\'default\'] = \''.$lang_name.'\';';
			$data = str_replace($search_language, $replace, $data);
			$data=trim($data);
		}
		write_file('../common/configs/config_lang.inc.php', $data, 'w');
	}
}
//<<<<<-------------- Class Language Default begins ---------------//
//-------------------- Code begins -------------->>>>>//
$setDefaultLanguage = new SetDefaultLanguage();
$setDefaultLanguage->setPageBlockNames(array('block_language_default'));
//default form fields and values...
$setDefaultLanguage->setFormField('language', '');
$setDefaultLanguage->setFormField('file', '');
$setDefaultLanguage->setAllPageBlocksHide();
$setDefaultLanguage->sanitizeFormInputs($_REQUEST);
$setDefaultLanguage->setPageBlockShow('block_language_default');
$setDefaultLanguage->LANG['page_title'] = $setDefaultLanguage->LANG['set_default_language_title'];
if($setDefaultLanguage->isValidFormInputs())
{
	if($setDefaultLanguage->isFormPOSTed($_POST, 'add_submit'))
	{
		$setDefaultLanguage->chkIsNotEmpty('language', $setDefaultLanguage->LANG['common_err_tip_compulsory']) and
		$setDefaultLanguage->chkIsValidLanguageName($setDefaultLanguage->LANG['set_default_language_err_invalid_name']);
		if($setDefaultLanguage->isValidFormInputs())
		{
			$setDefaultLanguage->writeDefaultLanguage($setDefaultLanguage->getFormField('language'));
			$setDefaultLanguage->setCommonErrorMsg($setDefaultLanguage->LANG['set_default_language_succ_msg']);
			$setDefaultLanguage->setPageBlockShow('block_msg_form_error');
		}
		else
		{
			$setDefaultLanguage->setCommonErrorMsg($setDefaultLanguage->LANG['set_default_language_err_invalid_form_fields']);
			$setDefaultLanguage->setPageBlockShow('block_msg_form_error');
		}
	}
}
//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
$setDefaultLanguage->left_navigation_div = 'generalLanguage';
//include the header file
$setDefaultLanguage->includeHeader();
//include the content of the page
setTemplateFolder('admin/');
$smartyObj->display('setDefaultLanguage.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
$setDefaultLanguage->includeFooter();
?>