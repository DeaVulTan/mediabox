<?php
/**
 * File to allow the users to get Page Title and Table of content in Article description
 *
 * Provides an interface to get Page Title and Table of content alias
 * to display the article in number of pages given bu the user.
 *
 *
 * @category	Rayzz
 * @package		Members
 */
require_once('../common/configs/config.inc.php');
$CFG['site']['is_module_page'] = 'article';
$CFG['lang']['include_files'][] = 'languages/%s/article/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/help.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/pageBreakPopUp.php';
$CFG['auth']['is_authenticate'] = 'members';
if(isset($_REQUEST['ajax_page']) and $_REQUEST['ajax_page'])
	{
		$CFG['mods']['is_include_only']['non_html_header_files'] = true;
	}
else
	{
		$CFG['html']['header'] = 'general/html_header_no_header.php';
		$CFG['html']['footer'] = 'general/html_footer_no_footer.php';
		$CFG['mods']['is_include_only']['html_header'] = false;
		$CFG['html']['is_use_header'] = false;
	}
require($CFG['site']['project_path'].'common/application_top.inc.php');
$pageBreak = new FormHandler();
$pageBreak->setPageBlockNames(array('page_break_form'));
//-------------------- Page block templates begins -------------------->>>>>//

//include the header file
$pageBreak->includeHeader();
?>
<script type="text/javascript" src="<?php echo $CFG['site']['article_url']; ?>js/pagebreak.js"></script>
<?php
//include the content of the page
setTemplateFolder('members/', 'article');
$smartyObj->display('pageBreakPopUp.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$pageBreak->includeFooter();
?>