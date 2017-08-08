<?php
/**
 * This file is to show the userdetail
 *
 *
 * This file is having user detail
 *
 *
 * @category	Rayzz
 * @package		User detail
 **/
require_once('common/configs/config.inc.php');
if(isset($_REQUEST['ajax_page']) and $_REQUEST['ajax_page'])
	{
		$CFG['mods']['is_include_only']['non_html_header_files'] = true;
	}
else
	{
		$CFG['html']['header'] = 'general/html_header.php';
		$CFG['html']['footer'] = 'general/html_footer.php';
		$CFG['mods']['is_include_only']['html_header'] = false;
		$CFG['html']['is_use_header'] = false;
	}
require($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/userDetail.php');
?>