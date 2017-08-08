<?php
/**
 * File handling the add manageBanners and manage the advertisment
 *
 *
 * PHP version 5.0
 *
 * @category	###Anova###
 * @package		###Common words###
 * @author 		anandaraja_20ag09
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: manageBanner.php 766 2008-06-26 09:52:00Z selvaraj_47ag04 $
 * @since 		2008-12-23
 */
/**
 * File having common configuration variables required for the entire project
 */
require_once('../../common/configs/config.inc.php');

$CFG['lang']['include_files'][] = 'languages/%s/discussions/admin/commonWords.php';

$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['site']['is_module_page']='discussions';
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
/**
 * Add banner
 */
class commonWordsHandler extends ListRecordsHandler
	{
		/**
		* Gets the common words list
		*
		*/
		public function getCommonWordList()
			{
				$sql = 'SELECT words FROM '.$this->CFG['db']['tbl']['common_words'].' WHERE id = 1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);
				if($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						return $row['words'];
					}
			}
		/**
		* Updates the common word list
		*
		*/
		public function updateCommonWords()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['common_words'].
						' SET words='.$this->dbObj->Param('common_words').
						' WHERE id=1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['common_words']));
				if (!$rs)
					trigger_db_error($this->dbObj);

			}
	}
//<<<<<-------------- Class GroupsFormHandler begins ---------------//
//-------------------- Code begins -------------->>>>>//
$commonwords = new commonWordsHandler();
$commonwords->setPageBlockNames(array('form_commonwords'));
//default form fields and values...
$commonwords->setFormField('common_words', '');
/*********** Page Navigation Start *********/

/************ page Navigation stop *************/
$commonwords->setPageBlockShow('form_commonwords');
$commonwords->sanitizeFormInputs($_REQUEST);

if($commonwords->isFormPOSTed($_POST, 'words_submit'))
	{
		if($commonwords->isValidFormInputs())
			{
				$commonwords->updateCommonWords();
				$commonwords->setPageBlockShow('block_msg_form_success');
				$commonwords->setCommonSuccessMsg($commonwords->LANG['discuzz_commonwords_success_msg']);
			}
		else
			{
				$commonwords->setPageBlockShow('block_msg_form_error');
				$commonwords->setCommonErrorMsg($commonwords->LANG['discuzz_common_msg_error_sorry']);
			}
	}

//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
$commonwords->left_navigation_div = 'discussionsMain';
//include the header file
$commonwords->includeHeader();
//include the content of the page
setTemplateFolder('admin/', $CFG['admin']['index']['home_module']);
$smartyObj->display('commonwords.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
$commonwords->includeFooter();
?>