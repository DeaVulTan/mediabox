<?php
require_once('../../common/configs/config.inc.php');
include_once('includes/config.php');
include_once('includes/tbs_class.php');

$CFG['html']['header'] = 'general/html_header_no_header.php';
$CFG['html']['footer'] = 'general/html_footer_no_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;

$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = false;

require_once($CFG['site']['project_path'].'common/application_top.inc.php');

class index extends FormHandler
	{
	}

$index = new index();
//Show Login Form
////////////////////////////////

$show_login = 1;

//Hide it when results are loaded
if($show_result ==1 || $show == 1){
$show_login = NULL;
}

// GET NETWORK TO IMPORT FROM

if ($service != "") {//get service from processor e.g mygmail.php  $service = 'mygmail';

    $get = $service;

}
else {
    $get = $_GET["domain"];
}
if ($get =="") {

    $script = "myhotmail.php";

    $img = "myhotmail.gif";

}
else {

    $script = $get.'.php';

    $img = $get.'.gif';
}
//select template inner table [var.which] in TBS (email or cvs upload)
if ($table != "") {
    $which = $table;
}
else {
    $which = $_GET['tbl'];
	$poweredby_top = $footer; //powered by
}

//if loading index.php for first time
if ($which == "") {
    $which = 1;
	$poweredby_top = $footer; //powered by
}


//Set Intelogin
////////////////////////////////

/*if($template == 2){
$script = 'intelilogin.php';
	}*/

$vcopy_right_year = $CFG['admin']['coppy_rights_year'];
$vsite_name = $CFG['site']['name'];
$vsite_url = $CFG['site']['url'];
$vall_rights = $LANG['header_all_rights_reserved'];
$vdefault_template = $CFG['html']['template']['default'];
$vdefault_stylesheet = $CFG['html']['stylesheet']['screen']['default'];
$vpowered_by = $LANG['header_powered_by'];
$vdev_url = $CFG['dev']['url'];
$vdev_name = $CFG['dev']['name'];

$index->includePopUpHeader();


$TBS = new clsTinyButStrong;
$TBS->NoErr = true;// no more error message displayed.
$TBS->LoadTemplate('themes/'.$theme_selected.'/template.htm');
$TBS->MergeBlock('blk1',$display_array);


$TBS->Show();

$index->includePopUpFooter();
?>