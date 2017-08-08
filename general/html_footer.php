<?php
$footer_module = '';
if(isset($CFG['site']['is_module_page']) and !empty($CFG['site']['is_module_page']))
	$footer_module = $CFG['site']['is_module_page'];

$html_footer_file = $CFG['site']['project_path'].$footer_module.'/design/templates/'.$CFG['html']['template']['default'].'/general/html_footer.tpl';
if(!is_file($html_footer_file))
	$footer_module = '';
//display the footer tpl file
setTemplateFolder('general/', $footer_module);
$smartyObj->display('html_footer.tpl');
?>