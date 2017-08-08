<?php
/**
 * This file is to display the newsletter details
 *
 * Provides an interface to view the details of newsletter of the record whose
 * value is passed in the query string as news_letter_id
 *
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 **/

require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/newsLetterView.php';
$CFG['html']['header'] = 'admin/html_header_popup.php';
$CFG['html']['footer'] = 'admin/html_footer_popup.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
/**
 * This class is to display the newsletter details
 *
 * @category	Rayzz
 * @package		Admin
 **/
class NewsLetterView extends FormHandler
	{

		/**
		 * NewsLetterView::populateDetails()
		 * To populate news letter details
		 *
		 * @return boolean
		 * @access 	public
		 **/
		public function populateDetails()
			{
				global $smartyObj;
				$sql = 'SELECT news_letter_id, subject, body, date_added, total_sent, status, upto_user_id, sql_condition '.
						' FROM '.$this->CFG['db']['tbl']['news_letter'].
						' WHERE news_letter_id='.$this->dbObj->Param('news_letter_id').' LIMIT 0,1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['news_letter_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if($row = $rs->FetchRow())
					{
						$newsarchiveList_arr['row'] = array();
						$inc =1;
						$newsarchiveList_arr['row'] = $row;
						$smartyObj->assign('displaynewsletter_arr', $newsarchiveList_arr);
						return true;
					}
				else
					return false;

			}
	}
//<<<<<-------------- Class ArticlePreview begins ---------------//
//-------------------- Code begins -------------->>>>>//
$obj = new NewsLetterView();

$obj->setPageBlockNames(array('view_newsletter_form'));
$obj->setFormField('news_letter_id', '');
$obj->IS_USE_AJAX = true;
if($obj->isFormPOSTed($_REQUEST, 'news_letter_id'))
	{
		$obj->sanitizeFormInputs($_REQUEST);
		if($obj->populateDetails())
			{
				$obj->setPageBlockShow('view_newsletter_form');
			}
		else
			{
				$obj->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$obj->setPageBlockShow('block_msg_form_error');
			}

	}
else
	{
		$obj->setAllPageBlocksHide();
		$obj->setCommonErrorMsg($LANG['common_msg_error_sorry']);
		$obj->setPageBlockShow('block_msg_form_error');
	}
$obj->left_navigation_div = 'generalList';

//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$obj->includeHeader();
//include the content of the page
setTemplateFolder('admin/');
$smartyObj->display('newsLetterView.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
$obj->includeFooter();
?>