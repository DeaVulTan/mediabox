<?php
/**
 * This file is to upload the articles
 *
 * This file is having ArticleWriting class to upload the articles
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		admin
 * @author 		selvaraj_35ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: articleWriting.php 892 2006-05-26 13:23:06Z selvaraj_35ag05 $
 * @since 		2006-05-02
 *
 **/
require_once('../common/configs/config.inc.php');
$CFG['feature']['rewrite_mode'] = 'normal';
$CFG['html']['header'] = 'admin/html_header.php';;
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
class ProfileQuestions extends FormHandler
{
}
$ProfileQuestions = new ProfileQuestions();
$ProfileQuestions->left_navigation_div = 'generalList';
$ProfileQuestions->includeHeader();
require_once('../tools/formbuilder/manageQuestions.php');
$ProfileQuestions->includeFooter();

?>