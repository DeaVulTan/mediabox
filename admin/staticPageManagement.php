<?php
/**
 * This file handling the static pages
 *
 * This file having the add, edit, delete and get code functionalities
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/staticPageManagement.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------- Class documentEditor --------->>>
/**
 * This class handling the static pages
 *
 * @category	Rayzz
 * @package		Admin
 */
class documentEditor extends ListRecordsHandler
	{
		/**
		 * documentEditor::buildSortQuery()
		 * To build the condition query
		 *
		 * @return
		 * @access 	public
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = $this->fields_arr['orderby_field'].' '.$this->fields_arr['orderby'];
			}

		/**
		 * documentEditor::writeDocument()
		 * To add / update the static pages
		 *
		 * @return
		 * @access 	public
		 **/
		public function writeDocument()
			{
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['static_pages'].' WHERE'.
						' page_name='.$this->dbObj->Param('page_name');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['page_name']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($this->fields_arr['status']=='Main')
					$this->unsetAllTheMainPages();

				if($rs->PO_RecordCount())
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['static_pages'].' SET'.
								' title='.$this->dbObj->Param('title').','.
								' content='.$this->dbObj->Param('content').','.
								' display_in='.$this->dbObj->Param('display_in').','.
								' status='.$this->dbObj->Param('status').' WHERE'.
								' page_name='.$this->dbObj->Param('page_name');

						$param_arr = array($this->fields_arr['title'],
											$this->fields_arr['page_content'],
											$this->fields_arr['display_in'], $this->fields_arr['status'],
											$this->fields_arr['page_name']);

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $param_arr);
						    if (!$rs)
							    trigger_db_error($this->dbObj);

						$this->setCommonSuccessMsg($this->LANG['success_file_updated']);
						return;
					}
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['static_pages'].' SET'.
						' content='.$this->dbObj->Param('content').','.
						' display_in='.$this->dbObj->Param('display_in').','.
						' status='.$this->dbObj->Param('status').','.
						' page_name='.$this->dbObj->Param('page_name').','.
						' title='.$this->dbObj->Param('title').','.
						' date_added=NOW()';

				$param_arr = array($this->fields_arr['page_content'],
									$this->fields_arr['display_in'], $this->fields_arr['status'],
									$this->fields_arr['page_name'], $this->fields_arr['title']);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $param_arr);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$this->setCommonSuccessMsg($this->LANG['success_new_file_added']);
				return;
			}

		/**
		 * documentEditor::read_content()
		 * To populate the content for editing
		 *
		 * @return
		 * @access 	public
		 **/
		public function read_content()
			{
				if(!$this->fields_arr['page_content'] and $this->fields_arr['page_name'])
					{
						$sql = 'SELECT content, status, display_in, title, main_page_content'.
								' FROM '.$this->CFG['db']['tbl']['static_pages'].' WHERE'.
								' page_name='.$this->dbObj->Param('page_name');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['page_name']));
						    if (!$rs)
							    trigger_db_error($this->dbObj);

						if ($row = $rs->FetchRow())
						    {
						     	$this->setFormField('page_content', $row['content']);
								$this->setFormField('main_page_content', $row['main_page_content']);
								$this->setFormField('status', $row['status']);
								$this->setFormField('display_in', $row['display_in']);
								$this->setFormField('title', $row['title']);
								return;
						    }
					}
				return;
			}

		/**
		 * documentEditor::populateStaticPagesList()
		 * To populate the static pages list
		 *
		 * @return
		 * @access 	public
		 **/
		public function populateStaticPagesList()
			{
				global $smartyObj;
				$data_arr = array();
				$inc = 0;
				while($row = $this->fetchResultRecord())
					{
						$data_arr[$inc] = $row;
						$data_arr[$inc]['edit_link'] = $this->CFG['site']['url'].'admin/staticPageManagement.php?act=edt&amp;page_name='.$row['page_name'].'&amp;start='.$this->getFormField('start');
						$inc++;
					}
				$smartyObj->assign('populateStaticPagesList_arr', $data_arr);
			}

		/**
		 * documentEditor::deleteSelectedPages()
		 * To delete the selected pages
		 *
		 * @return
		 * @access 	public
		 **/
		public function deleteSelectedPages()
			{
				$pages = addslashes($this->fields_arr['page_name']);
				$pages = explode(',', $pages);
				$pages = '\''.implode('\',\'', $pages).'\'';

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['static_pages'].' WHERE'.
						' page_name IN('.$pages.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);
			}

		/**
		 * documentEditor::updateStatusSelectedPages()
		 * To update the status for selected pages
		 *
		 * @param $status status to update
		 * @return
		 * @access 	public
		 **/
		public function updateStatusSelectedPages($status)
			{
				$pages = addslashes($this->fields_arr['page_name']);
				$pages = explode(',', $pages);
				$pages = '\''.implode('\',\'', $pages).'\'';

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['static_pages'].' SET'.
						' status=\''.$status.'\' WHERE'.
						' page_name IN('.$pages.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);
			}

		/**
		 * documentEditor::unsetAllTheMainPages()
		 * To unset all the main pages
		 *
		 * @return
		 * @access 	public
		 **/
		public function unsetAllTheMainPages()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['static_pages'].' SET status=\'Activate\''.
						' WHERE status=\'Main\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$this->fields_arr['display_in'] = 'Both';
			}

		/**
		 * documentEditor::setThisPageAsMainPage()
		 * To set a page as main page
		 *
		 * @return
		 * @access 	public
		 **/
		public function setThisPageAsMainPage()
			{
				$this->unsetAllTheMainPages();

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['static_pages'].' SET status=\'Main\''.
						' WHERE page_name='.$this->dbObj->Param('page_name');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['page_name']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
			}

		/**
		 * documentEditor::resetFieldsArray()
		 * To initialize the form fields
		 *
		 * @return
		 * @access 	public
		 **/
		public function resetFieldsArray()
			{
				$this->setFormField('page_content','');
				$this->setFormField('page_name','');
				$this->setFormField('display_in','Both');
				$this->setFormField('status','Toactivate');
				$this->setFormField('act','');
				$this->setFormField('title', '');
				$this->setFormField('main_page_content', '');
			}
	}

//--------------------Code begins-------------->>>>>//
$documentEditor = new documentEditor();
//set blocks
$documentEditor->setPageBlockNames(array('block_document_editor', 'block_file_name', 'block_sel_page_list'));

/*********** Page Navigation Start *********/
$documentEditor->setFormField('orderby_field', 'date_added');
$documentEditor->setFormField('orderby', 'DESC');
$documentEditor->setTableNames(array($CFG['db']['tbl']['static_pages']));
$documentEditor->setReturnColumns(array('page_name', 'display_in', 'status', 'date_added', 'title'));
/************ page Navigation stop *************/

//set Form Fields
$documentEditor->resetFieldsArray();

//show default pages
$documentEditor->setPageBlockShow('block_document_editor');
$documentEditor->setPageBlockShow('block_sel_page_list');

$documentEditor->sanitizeFormInputs($_REQUEST);
if($documentEditor->isFormPOSTed($_POST,'document_submit'))
	{
		if($CFG['admin']['is_demo_site'])
			{
				$documentEditor->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
				$documentEditor->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				$documentEditor->chkIsNotEmpty('page_name', $LANG['common_err_tip_compulsory']) AND
					$documentEditor->chkIsAlphaNumeric('page_name', $LANG['err_tip_alphanumeric']);
				$documentEditor->chkIsNotEmpty('title', $LANG['common_err_tip_compulsory']);
				$documentEditor->chkIsNotEmpty('page_content', $LANG['common_err_tip_compulsory']);
				if($documentEditor->isValidFormInputs())
					{
						$documentEditor->setFormField('page_content', htmlentitydecode($documentEditor->getFormField('page_content')));
						$documentEditor->setFormField('page_content', stripSpecifiedTag($documentEditor->getFormField('page_content'), $CFG['admin']['html_editor']['strip_tags']));
						$documentEditor->writeDocument();
						$documentEditor->read_content();
						$documentEditor->setPageBlockShow('block_msg_form_success');
						$documentEditor->resetFieldsArray();
					}
				else
					{
						$documentEditor->read_content();
						$documentEditor->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$documentEditor->setPageBlockShow('block_msg_form_error');
					}
			}
	}
else if($documentEditor->isFormGETed($_GET, 'act'))
	{
		if($documentEditor->getFormField('act')=='edt')
			{
				$documentEditor->read_content();
			}
	}

if($documentEditor->isFormPOSTed($_POST, 'delete_add'))
	{
		if($CFG['admin']['is_demo_site'])
			{
				$documentEditor->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
				$documentEditor->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				if($documentEditor->getFormField('act')=='delete')
					{
						$documentEditor->deleteSelectedPages();
						$documentEditor->setCommonSuccessMsg($LANG['success_deleted']);
					}
				if($documentEditor->getFormField('act')=='activate')
					{
						$documentEditor->updateStatusSelectedPages('Activate');
						$documentEditor->setCommonSuccessMsg($LANG['success_activated']);
					}
				if($documentEditor->getFormField('act')=='toactivate')
					{
						$documentEditor->updateStatusSelectedPages('Toactivate');
						$documentEditor->setCommonSuccessMsg($LANG['success_deactivated']);
					}
				if($documentEditor->getFormField('act')=='main')
					{
						$documentEditor->setThisPageAsMainPage();
						$documentEditor->setCommonSuccessMsg($LANG['success_changed_as_main_page']);
					}
				$documentEditor->setPageBlockShow('block_msg_form_success');
				$documentEditor->resetFieldsArray();
				$documentEditor->setFormField('page_name','');
			}
	}

if($documentEditor->isFormPOSTed($_POST,'cancel'))
	{
		$documentEditor->setPageBlockShow('block_msg_form_success');
		$documentEditor->setCommonSuccessMsg($LANG['block_msg_form_success']);
		$documentEditor->resetFieldsArray();
	}
	$static_code = getUrl('static', '?pg={block}', '{block}/', 'root');
	$test =  '<?php echo getUrl(\'static\', \'?pg={block}\', \'{block}/\', \'root\');?>';
	$template_code =  '{php}global $CFG;echo getUrl(\'static\', \'?pg={block}\', \'{block}/\', \'root\');{/php}';

if($documentEditor->isShowPageBlock('block_sel_page_list'))
	{
		/****** navigtion continue*********/
		$documentEditor->buildSelectQuery();
		$documentEditor->buildConditionQuery();
		$documentEditor->buildSortQuery();
		$documentEditor->buildQuery();
		$documentEditor->executeQuery();

		if(!$documentEditor->isResultsFound())
			{
				$documentEditor->setPageBlockHide('block_sel_page_list');
				$documentEditor->setPageBlockShow('block_msg_form_alert');
				$documentEditor->setCommonAlertMsg($LANG['common_no_records_found']);
			}
	}
$documentEditor->left_navigation_div = 'generalList';
//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//
//include the header file
$documentEditor->includeHeader();
?>
<script type="text/javascript" language="javascript">
	var palette_url = '<?php echo $CFG['site']['url'].'admin/palette.htm';?>';
	var block_arr= new Array('selMsgConfirm', 'selCodeForm');
	function populateCode(block, titlecode){
		var codeDetail = "<a href=\"<?php echo $test;?>\">{title}</a>";
		var codeStaticDetail = "<a href=\"<?php echo $static_code;?>\">{title}</a>";
		var codeTemplateDetail = "<a href=\"<?php echo $template_code;?>\">{title}</a>";
		var codeTitle = "<?php echo $LANG['code_title'];?>";
		var cd = codeDetail.replace('VAR_BLOCK', block);
		var scd = codeStaticDetail.replace('VAR_BLOCK', block);
		var tcd = codeTemplateDetail.replace('VAR_BLOCK', block);
		cd = cd.replace('VAR_BLOCK', block);
		cd = cd.replace('VAR_TITLE', titlecode);
		cd = cd.replace('VAR_TITLE', titlecode);
		scd = scd.replace('VAR_BLOCK', block);
		scd = scd.replace('VAR_TITLE', titlecode);
		scd = scd.replace('VAR_TITLE', titlecode);
		tcd = tcd.replace('VAR_BLOCK', block);
		tcd = tcd.replace('VAR_TITLE', titlecode);
		tcd = tcd.replace('VAR_TITLE', titlecode);
		var ct = codeTitle.replace('VAR_BLOCK', titlecode);
		Confirmation('selCodeForm', 'codeForm', Array('codeTitle', 'addCode', 'addCodeStatic', 'addCodeTemplate'), Array(ct, cd, scd, tcd), Array('innerHTML', 'value', 'value', 'value'));
		return false;
	}
</script>
<?php
$documentEditor->frmDocumentEditor_hidden_arr = array('orderby','orderby_field','start');
if ($documentEditor->isShowPageBlock('block_sel_page_list'))
	{
		$documentEditor->deleteForm_hidden_arr = array('orderby','orderby_field','start', 'page_name', 'act');
	}
if ($documentEditor->isShowPageBlock('block_sel_page_list'))
	{
		$smartyObj->assign('smarty_paging_list', $documentEditor->populatePageLinksPOST($documentEditor->getFormField('start'), 'selListStaticForm'));
		$documentEditor->selListStaticForm_hidden_arr = array('orderby','orderby_field','start');
		$smartyObj->assign('delete_submit_onclick', 'if(getMultiCheckBoxValue(\'selListStaticForm\', \'check_all\', \''.$LANG['check_atleast_one'].'\')){Confirmation(\'selMsgConfirm\', \'deleteForm\', Array(\'page_name\', \'act\', \'confirmation_msg\'), Array(multiCheckValue, \'delete\', \''.nl2br($LANG['delete_confirmation']).'\'), Array(\'value\', \'value\', \'innerHTML\'));}');
		$smartyObj->assign('activate_submit_onclick', 'if(getMultiCheckBoxValue(\'selListStaticForm\', \'check_all\', \''.$LANG['check_atleast_one'].'\')){Confirmation(\'selMsgConfirm\', \'deleteForm\', Array(\'page_name\', \'act\', \'confirmation_msg\'), Array(multiCheckValue, \'activate\', \''.nl2br($LANG['activate_confirmation']).'\'), Array(\'value\', \'value\', \'innerHTML\'));}');
		$smartyObj->assign('inactivate_submit_onclick', 'if(getMultiCheckBoxValue(\'selListStaticForm\', \'check_all\', \''.$LANG['check_atleast_one'].'\')){Confirmation(\'selMsgConfirm\', \'deleteForm\', Array(\'page_name\', \'act\', \'confirmation_msg\'), Array(multiCheckValue, \'toactivate\', \''.nl2br($LANG['toactivate_confirmation']).'\'), Array(\'value\', \'value\', \'innerHTML\'));}');
		$documentEditor->populateStaticPagesList();
	}

//include the content of the page
setTemplateFolder('admin/');
$smartyObj->display('staticPageManagement.tpl');
//<<<<<<--------------------Page block templates Ends--------------------//
$documentEditor->includeFooter();
?>