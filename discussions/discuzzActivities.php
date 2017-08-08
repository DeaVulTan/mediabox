<?php
/**
 * File to create discussion title
 *
 * Ther user can create a category
 *
 * PHP version 5.0
 *
 * @category	Discuzz
 * @package		DiscussionFormHandler
 * @author		shankar_76ag08
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2008-24-10
 */
/**
 * File having common configuration variables required for the entire project
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/'.$CFG['admin']['index']['home_module'].'/addDiscussionTitle.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';

$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_DiscussionHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_DiscussionsActivityHandler.lib.php';
$CFG['site']['is_module_page']='discussions';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//FOR RAYZZ INTEGRATION
if(class_exists('DiscussionHandler'))
	{
		$discussionHandler = new DiscussionHandler();
		$smartyObj->assign_by_ref('discussion', $discussionHandler);
	}
//-------------- Class DiscussionFormHandler begins --------------->>>>>//
class ActivityFormHandler extends DiscussionHandler
	{
	}
//<<<<<-------------- Class DiscussionFormHandler begins ---------------//
//-------------------- Code begins -------------->>>>>//
$discussionsActivity = new ActivityFormHandler();

if($CFG['admin']['index']['activity']['show'])
	{
		$discuzzActivities = new DiscussionsActivityHandler();
		$discuzzActivities->populateActivities('', 'discussions');
	}

$discussionsActivity->setPageBlockNames(array('form_create_discussion', 'sub_category_block'));

//default form fields and values...
$discussionsActivity->setFormField('discussion_id', '');
$discussionsActivity->setFormField('discussion_title', '');

$discussionsActivity->setAllPageBlocksHide();
$discussionsActivity->sanitizeFormInputs($_REQUEST);


//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//

//<<<<<-------------------- Page block templates ends -------------------//
//include the header file
$discussionsActivity->includeHeader();
//include the content of the page
setTemplateFolder('members/', $CFG['admin']['index']['home_module']);
$smartyObj->display('indexActivity.tpl');
//include the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//

$discussionsActivity->includeFooter();
?>
