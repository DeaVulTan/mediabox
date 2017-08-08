<?php
/**
 * File handling the receive bugs
 *
 *
 * PHP version 5.0
 *
 * @category	###Oddbodd###
 * @package		###Index###
 * @author 		selvaraj_47ag04
 * @copyright	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2008-04-18
 */
/**
 * File having common configuration variables required for the entire project
 */
require_once('./common/configs/config.inc.php'); //configurations
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['auth']['is_authenticate'] = false;
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------- Class receiveBugs begins --------------->>>>>//

class receiveBugs extends FormHandler
	{
		public $parent_id = '';

		public function insertBugs()
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['bugs'].' SET'.
						' bug_content = '.$this->dbObj->Param('bug_content').','.
						' parent_id = '.$this->dbObj->Param('parent_id').','.
						' secret_key = ' . $this->dbObj->Param('secret_key') . ','.
						' reply_from = \'Developers\'' . ','.
						' date_added = NOW()';

				$data_ar = array(html_entity_decode($this->getFormField('bcontent')), $this->parent_id , $this->getFormField('skey'));

				$stmt = $this->dbObj->Prepare($sql);

				$rs = $this->dbObj->Execute($stmt, $data_ar);
				    if (!$rs)
					    trigger_db_error($this->dbObj);
			}

		public function chkIsValidInput()
			{
				if($this->getFormField('bsite') != $this->CFG['site']['url'])
					{
						return false;
					}
				$sql = 'SELECT parent_id FROM '.$this->CFG['db']['tbl']['bugs'].' WHERE'.
						' bug_id = '.$this->dbObj->Param('bug_id').' AND'.
						' secret_key = '.$this->dbObj->Param('secret_key');

				$stmt = $this->dbObj->Prepare($sql);

				$rs = $this->dbObj->Execute($stmt, array($this->getFormField('bid'), $this->getFormField('skey')));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();

						if($row['parent_id'] == 0)
							{
								$this->parent_id = $this->getFormField('bid');
							}
						else
							{
								$this->parent_id = $row['parent_id'];
							}
						return true;
					}
				return false;
			}
	}

//<<<<<-------------- Class receiveBugs begins ---------------//
//-------------------- Code begins -------------->>>>>//
$receiveBugs = new receiveBugs();
$receiveBugs->setPageBlockNames(array());
//default form fields and values...
$receiveBugs->setFormField('bid', '');
$receiveBugs->setFormField('bcontent', '');
$receiveBugs->setFormField('bsite', '');
$receiveBugs->setFormField('skey', '');

$receiveBugs->sanitizeFormInputs($_REQUEST);
//write_file('test.txt', serialize($_REQUEST));

//print_r($_REQUEST);

$receiveBugs->chkIsNotEmpty('bid', $receiveBugs->LANG['common_err_tip_compulsory']);
$receiveBugs->chkIsNotEmpty('bcontent', $receiveBugs->LANG['common_err_tip_compulsory']);
$receiveBugs->chkIsNotEmpty('bsite', $receiveBugs->LANG['common_err_tip_compulsory']);
$receiveBugs->chkIsNotEmpty('skey', $receiveBugs->LANG['common_err_tip_compulsory']);

if ($receiveBugs->isValidFormInputs() and $receiveBugs->chkIsValidInput())
	{
		$receiveBugs->insertBugs();
	}
?>