<?php
/**
 * This file handles the Email this Board page
 *
 * PHP version 5.0
 *
 * @category	Discuzz
 * @package		ManageAbuseContentHandler
 * @author 		senthil_52ag05
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2009-02-20
 */
require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/'.$CFG['admin']['index']['home_module'].'/admin/manageAbuseContent.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';

if(isset($_REQUEST['ajax_page']) and $_REQUEST['ajax_page'])
	{
		$CFG['is']['ajax_page'] = true;
	}
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;

/**
 * To include application top file
 */
require_once($CFG['site']['project_path'].'common/application_top.inc.php');

//-------------- Class ManageAbuseContentHandler begins --------------->>>>>//
/**
 * <b>Class overview</b>
 *
 * <b>Methods overview</b>
 *
 * @category	Discuzz
 * @package		ManageAbuseContentHandler
 * @author 		senthil_52ag05
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id:
 * @since 		2008-12-22
 */
class ManageAbuseContentHandler extends FormHandler
    {
    	public $sent_email_arr=array();

		public function chkIsValidBoardId($err_msg = '')
			{
				if (!$this->fields_arr['bid'])
					{
						$this->setCommonErrorMsg($err_msg);
						return false;
					}
				$sql = 'SELECT q.board_id, q.total_solutions, q.abuse_count, q.best_solution_id, q.description, q.total_stars, q.board'.
						', TIMEDIFF(NOW(), board_added) as date_asked, '.getUserTableField('display_name').' AS asked_by'.
						', '.getUserTableField('name').' AS name, q.status, q.user_id, q.seo_title'.
						' FROM '.$this->CFG['db']['tbl']['boards'].' AS q, '.$this->CFG['db']['tbl']['users'].' AS u'.
						' WHERE q.user_id=u.'.getUserTableField('user_id').
						' AND q.board_id='.$this->dbObj->Param('bid');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid']));
				if (!$rs)
						trigger_db_error($this->dbObj);

				$numrows = $rs->PO_RecordCount();
				if ($numrows > 0 )
					{
						$this->board_details = $rs->FetchRow();
						return true;
					}

				$this->setCommonErrorMsg($err_msg);
				return false;
			}

		public function chkIsValidSolutionId($err_msg = '')
			{
				if (!$this->fields_arr['aid'])
					{
						$this->setCommonErrorMsg($err_msg);
						return false;
					}

				$sql = 'SELECT a.solution_id, a.solution, a.board_id, '.getUserTableField('display_name').' as asked_by'.
						', '.getUserTableField('name').' as name, a.user_id'.
						' FROM '.$this->CFG['db']['tbl']['solutions'].' AS a, '.$this->CFG['db']['tbl']['users'].' AS u'.
						' WHERE a.user_id=u.'.getUserTableField('user_id').
						' AND a.solution_id='.$this->dbObj->Param('aid');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['aid']));
				if (!$rs)
						trigger_db_error($this->dbObj);

				$numrows = $rs->PO_RecordCount();
				if ($numrows > 0 )
					{
						$this->solution_details = $rs->FetchRow();
						return true;
					}

				$this->setCommonErrorMsg($err_msg);
				return false;
			}

		public function showAbuseContent()
			{
				$sql = 'SELECT abuse_id, reported_by, reason, DATE_FORMAT(date_abused, \''.$this->CFG['format']['date'].'\') AS date_abused'.
						' FROM '.$this->CFG['db']['tbl']['abuse_boards'].
						' WHERE board_id='.$this->dbObj->Param('bid');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid']));
				if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$showAbuseContent_arr = array();
				if ($rs->PO_RecordCount())
					{
						$inc = 1;
						while($row = $rs->FetchRow()){
							$userDetails = $this->getUserDetailsFromUsersTable($this->CFG['db']['tbl']['users'], $row['reported_by']);
							$row['reporter'] = $userDetails['name'];
							$row['oddevenclass'] = ($inc%2)?'clsOddBoard':'clsEvenBoard';

							$row['onclick'] = 'ajaxUpdateDiv(\'manageAbuseContent.php\', \'delete=1&bid='.$this->fields_arr['bid'].'&abuse_id='.$row['abuse_id'].'\', \'selShowAbuseContent\')';
							$showAbuseContent_arr[$inc]['record'] = $row;
							$inc++;
						}
					}

				return $showAbuseContent_arr;
			}

		public function  showSolutionAbuseContent()
			{
				$sql = 'SELECT abuse_id, reported_by, reason, DATE_FORMAT(date_abused, \''.$this->CFG['format']['date'].'\') AS date_abused'.
						' FROM '.$this->CFG['db']['tbl']['abuse_solutions'].
						' WHERE board_id='.$this->dbObj->Param('bid').
						' AND solution_id='.$this->dbObj->Param('aid');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid'], $this->fields_arr['aid']));
				if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$showSolutionAbuseContent_arr = array();
				if ($rs->PO_RecordCount())
					{
						$inc = 1;
						while($row = $rs->FetchRow()){
							$userDetails = $this->getUserDetailsFromUsersTable($this->CFG['db']['tbl']['users'], $row['reported_by']);
							$row['reporter'] = $userDetails['name'];
							$row['oddevenclass'] = ($inc%2)?'clsOddBoard':'clsEvenBoard';

							$row['onclick'] = 'ajaxUpdateDiv(\'manageAbuseContent.php\', \'delete_ans=1&aid='.$this->fields_arr['aid'].'&bid='.$this->fields_arr['bid'].'&abuse_id='.$row['abuse_id'].'\', \'selShowAbuseContent\')';
							$showSolutionAbuseContent_arr[$inc]['record'] = $row;
							$inc++;
						}
					}

				return $showSolutionAbuseContent_arr;
			}

		public function  deleteAbuseContent()
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['abuse_boards'].
						' WHERE abuse_id='.$this->dbObj->Param('abuse_id').
						' AND board_id='.$this->dbObj->Param('bid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['abuse_id'], $this->fields_arr['bid']));
				if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($this->dbObj->Affected_Rows())
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['boards'].
								' SET abuse_count=abuse_count-1'.
								' WHERE board_id='.$this->dbObj->Param('bid').
								' AND abuse_count>0';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid']));
						if (!$rs)
							    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
					}

				return true;
			}

		public function  deleteSolutionAbuseContent()
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['abuse_solutions'].
						' WHERE abuse_id='.$this->dbObj->Param('abuse_id').
						' AND board_id='.$this->dbObj->Param('bid').
						' AND solution_id='.$this->dbObj->Param('aid');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['abuse_id'], $this->fields_arr['bid'], $this->fields_arr['aid']));
				if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($this->dbObj->Affected_Rows())
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['solutions'].
								' SET abuse_count=abuse_count-1'.
								' WHERE solution_id='.$this->dbObj->Param('aid').
								' AND abuse_count>0';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['aid']));
						if (!$rs)
							    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
					}

				return true;
			}
    }
//<<<<<---------------- Class ManageAbuseContentHandler ends -------------//
//--------------------- Code begins -------------------->>>>>//
$manageabusecontent = new ManageAbuseContentHandler();
$manageabusecontent->setPageBlockNames(array('form_abuse_content'));

//set the form field
$manageabusecontent->setFormField('bid', '');
$manageabusecontent->setFormField('aid', '');
$manageabusecontent->setFormField('abuse_id', '');
$manageabusecontent->board_title = $LANG['manageabusecontent_board_title'];

$manageabusecontent->sanitizeFormInputs($_REQUEST);
$manageabusecontent->showTitle = true;

if($manageabusecontent->isFormGETed($_REQUEST, 'aid') and $manageabusecontent->isFormGETed($_REQUEST, 'bid'))
	{

		$manageabusecontent->chkIsValidBoardId($LANG['err_tip_invalid_board_id']) and
			$manageabusecontent->chkIsValidSolutionId($LANG['err_tip_invalid_solution_id']);

		if ($manageabusecontent->isValidFormInputs())
			{
				$manageabusecontent->setAllPageBlocksHide();
				if ($manageabusecontent->isFormGETed($_REQUEST, 'delete_ans'))
					{
						$manageabusecontent->showTitle = false;
						$manageabusecontent->deleteSolutionAbuseContent();
						$manageabusecontent->setPageBlockShow('block_msg_form_success');
						$manageabusecontent->setCommonSuccessMsg($LANG['abused_content_deleted_succesfully']);
					}
				$manageabusecontent->setPageBlockShow('form_abuse_content');
				$manageabusecontent->board_title = wordWrapManual($manageabusecontent->solution_details['solution'], $CFG['admin']['board']['line_length'], $CFG['admin']['board']['total_length']);
				$manageabusecontent->form_abuse_content['showAbuseContent_arr'] = $manageabusecontent->showSolutionAbuseContent();
			}
			else
				{
					$manageabusecontent->setAllPageBlocksHide();
					$manageabusecontent->setPageBlockShow('block_msg_form_error');
				}
	}
elseif ($manageabusecontent->isFormGETed($_REQUEST, 'bid'))
	{
		$manageabusecontent->chkIsValidBoardId($LANG['err_tip_invalid_board_id']);
		if ($manageabusecontent->isValidFormInputs())
			{
				$manageabusecontent->setAllPageBlocksHide();
				if ($manageabusecontent->isFormGETed($_REQUEST, 'delete'))
					{
						$manageabusecontent->showTitle = false;
						$manageabusecontent->deleteAbuseContent();
						$manageabusecontent->setPageBlockShow('block_msg_form_success');
						$manageabusecontent->setCommonSuccessMsg($LANG['abused_content_deleted_succesfully']);
					}
				$manageabusecontent->setPageBlockShow('form_abuse_content');
				$manageabusecontent->board_title = wordWrapManual($manageabusecontent->board_details['board'], $CFG['admin']['board']['line_length'], $CFG['admin']['board']['total_length']);
				$manageabusecontent->form_abuse_content['showAbuseContent_arr'] = $manageabusecontent->showAbuseContent();
			}
			else
				{
					$manageabusecontent->setAllPageBlocksHide();
					$manageabusecontent->setPageBlockShow('block_msg_form_error');
				}
	}
//<<<<<----------------- Code ends -------------------//
//--------------- Page block templates begins ------------>>>>>//
//include the header file
$manageabusecontent->includeAjaxHeader();
//include the content of the page
setTemplateFolder('admin/', $CFG['admin']['index']['home_module']);
$smartyObj->display('manageAbuseContent.tpl');
//<<<<<<--------------------Page block templates Ends--------------------//
//include the footer of the page
$manageabusecontent->includeAjaxFooter();
?>