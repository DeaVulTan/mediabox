<?php
/**
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @author 		selvaraj_35ag05
 * @copyright 	Copyright (c) 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: viewVideo.php 2986 2006-12-29 05:25:10Z selvaraj_35ag05 $
 * @since 		2006-05-02
 *
 **/
require_once('./common/configs/config.inc.php');
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['auth']['is_authenticate'] = 'members';
require($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------------------class ChangeContentFilter-------------------->>>
/**
 * ChangeContentFilter
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class ChangeContentFilter extends MediaHandler
	{
		/**
		 * ChangeContentFilter::changeStatus()
		 *
		 * @return
		 */
		public function changeStatus()
			{
				if(isAdultUser('settings') || $this->CFG['admin']['is_logged_in'])
					{
						$this->changeMyContentFilterSettings($this->CFG['user']['user_id'], $this->fields_arr['status']);
						getContentFilterStatusLink($this->fields_arr['status']);
						$_SESSION['user']['content_filter'] = $this->fields_arr['status'];
					}
			}
	}
//<<<<<-------------- Class ChangeContentFilter begins ---------------//
$ChangeContentFilter = new ChangeContentFilter();
$ChangeContentFilter->setDBObject($db);
$ChangeContentFilter->makeGlobalize($CFG,$LANG);
$ChangeContentFilter->includeAjaxHeaderSessionCheck();
$ChangeContentFilter->setFormField('status', 'On');
$ChangeContentFilter->sanitizeFormInputs($_REQUEST);
$ChangeContentFilter->changeStatus();
$ChangeContentFilter->includeAjaxFooter();
?>