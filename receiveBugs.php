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
		public $parent_id = 0;

		public function sendBugEmail()
			{
				$subject = 'Reg - New bugs received in rayzz.net';
				$content = 'Hi,
				New bug posted from VAR_BUG_SITE

				Subject: VAR_BUG_SUBJECT

				VAR_BUG_CONTENT';

				$this->setEmailTemplateValue('bug_site', $this->getFormField('bsite'));
				$this->setEmailTemplateValue('bug_subject', $this->getFormField('bsubject')?$this->getFormField('bsubject'):'(No Subject)');
				$this->setEmailTemplateValue('bug_content', html_entity_decode($this->getFormField('bcontent')));
				$this->buildEmailTemplate($subject, $content, false, true);

				$EasySwift = new EasySwift($this->getSwiftConnection());
				$EasySwift->flush();
				$EasySwift->addPart($this->getEmailContent(true), "text/html");
				$from_email = $this->CFG['site']['noreply_email'];
				//$EasySwift->send('isocialdev@gmail.com', $from_email, $this->getEmailSubject());
				$EasySwift->send('m.selvaraj@Uzdc.in', $from_email, $this->getEmailSubject());
			}

		public function insertBugs()
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['receive_bugs'].' SET'.
						' client_bug_id = '.$this->dbObj->Param('client_bug_id').','.
						' bug_subject = '.$this->dbObj->Param('bug_subject').','.
						' bug_content = '.$this->dbObj->Param('bug_content').','.
						' bug_site = '.$this->dbObj->Param('bug_site').','.
						' secret_key = '.$this->dbObj->Param('secret_key').','.
						' parent_id = ' . $this->dbObj->Param('parent_id') . ',' .
						' reply_from = ' . $this->dbObj->Param('site_name') . ',' .
						' date_added = NOW()';

				$data_ar = array($this->getFormField('bid'), $this->getFormField('bsubject'),
								html_entity_decode($this->getFormField('bcontent')), $this->getFormField('bsite'),
								$this->getFormField('skey'), $this->getFormField('parent_id'), $this->getFormField('sitename'));

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $data_ar);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$this->sendBugEmail();
			}

		public function updateStatus()
			{
				$sql = ' SELECT bug_id FROM '.$this->CFG['db']['tbl']['receive_bugs'].' WHERE client_bug_id IN('.$this->getFormField('bid').') AND'.
						' bug_site='.$this->dbObj->Param('bug_site');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->getFormField('bsite')));
					if (!$rs)
						trigger_db_error($this->dbObj);

				if(!$rs->PO_RecordCount())
					{
						return;
					}

				$id = '';
				while($row = $rs->FetchRow())
					{
						$id .= $row['bug_id'].',';
					}
				$id = substr($id, 0, strrpos($id, ','));

				$status = $this->getFormField('bstatus');

				$date_closed = '';
				if ($status == 'Closed')
					$date_closed = ', date_closed = NOW()';

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['receive_bugs'].
						' SET status='.$this->dbObj->Param('status').$date_closed.
						' WHERE (bug_id IN ('.$id.') OR parent_id IN ('.$id.'))'.
						' AND bug_site = '.$this->dbObj->Param('bug_site');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($status, $this->getFormField('bsite')));
					if (!$rs)
						trigger_db_error($this->dbObj);
			}
	}

//<<<<<-------------- Class receiveBugs begins ---------------//
//-------------------- Code begins -------------->>>>>//
$receiveBugs = new receiveBugs();
$receiveBugs->setPageBlockNames(array());
//default form fields and values...
$receiveBugs->setFormField('bid', '');
$receiveBugs->setFormField('bsubject', '');
$receiveBugs->setFormField('bcontent', '');
$receiveBugs->setFormField('bsite', '');
$receiveBugs->setFormField('skey', '');
$receiveBugs->setFormField('parent_id', '');
$receiveBugs->setFormField('sitename', '');
$receiveBugs->setFormField('bstatus', '');

$receiveBugs->sanitizeFormInputs($_REQUEST);
//write_file('test.txt', serialize($_SERVER));

$receiveBugs->chkIsNotEmpty('bid', $receiveBugs->LANG['common_err_tip_compulsory']);
$receiveBugs->chkIsNotEmpty('bcontent', $receiveBugs->LANG['common_err_tip_compulsory']);
$receiveBugs->chkIsNotEmpty('bsite', $receiveBugs->LANG['common_err_tip_compulsory']);
$receiveBugs->chkIsNotEmpty('skey', $receiveBugs->LANG['common_err_tip_compulsory']);

if($receiveBugs->getFormField('bstatus') and $receiveBugs->getFormField('bid') and $receiveBugs->getFormField('bsite'))
	{
		$receiveBugs->updateStatus();
	}
else if ($receiveBugs->isValidFormInputs())
	{
		$receiveBugs->insertBugs();
	}
?>