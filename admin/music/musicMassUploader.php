<?php
/**
* This file is to musicMassUploader
*
* This file is having musicManage class to manage the musics
*
*
* @category	Rayzz
* @package		Admin
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
*
**/
require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/admin/musicMassUploader.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['site']['is_module_page']='music';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
/**
*
* @category	rayzz
* @package		Admin Music
**/
class MassUploader extends MediaHandler
{
	public $csv_delimiter = '~';
	public $csv_file_path = '../../files/music_mass_upload/csv_files/';
	public $insert_fields_array = array();
	public $ignore_first_row = true;

	public function chkValidCSVFileType($field_name, $err_tip = '')
	{
		$format_arr = array('csv');
		$extern = strtolower(substr($this->getFormField($field_name),
		strrpos($this->getFormField($field_name), '.')+1));
		if (!in_array($extern, $format_arr))
		{
			$this->fields_err_tip_arr[$field_name] = $err_tip;
			return false;
		}
		return true;
	}
	/**
	* MassUploader::isFileExists()
	*
	*
	* @return void
	*/
	public function isFileCSVExists ($field_name,$err_tip)
	{
		$file_path = $this->csv_file_path.$this->getFormField($field_name);
		if (!file_exists($file_path))
		{
			$this->fields_err_tip_arr[$field_name] = $err_tip;
			return false;
		}
		return true;
	}
	/**
	* MassUploader::setTableAndColumns()
	*
	* @return
	*/
	public function setTableAndColumns()
	{
		$this->setTableNames(array($this->CFG['db']['tbl']['music_mass_uploader_file_details'].' as mu'));
		$this->setReturnColumns(array('mu.music_mass_upload_title','mu.total_songs_moved','mu.status','mu.music_mass_uploader_file_id','mu.date_added',
		                             'mu.status','mu.total_songs','mu.file_name'));
		$this->sql_condition = 'mu.status=\'Active\'';
		$this->sql_sort = 'mu.music_mass_uploader_file_id DESC';
	}
	public function getCsvDetails($field_name)
	{

		$sql = 'INSERT INTO  '.
			   $this->CFG['db']['tbl']['music_mass_uploader_file_details'].' '.
			   	' SET added_by ='.$this->dbObj->Param('added_by').','.
				' music_mass_upload_title='.$this->dbObj->Param('upload_title').','.
				' file_name='.$this->dbObj->Param('csv_file_path').','.
				' status='.$this->dbObj->Param('form_upload_status').','.
				' date_added=NOW()';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['added_by'],
												 $this->fields_arr['upload_title'],
												 $this->fields_arr['csv_file_path'],
												 $this->fields_arr['form_upload_status']));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		$mass_uploader_file_id  = $this->dbObj->Insert_ID();
		$this->insertCSVRecords($mass_uploader_file_id);
	}
	public function setTableFormFields()
	{
		$this->mass_upload_fields_array = array(
				'music_title',
				'album_name',
				'artist_names',
				'music_year_released',
				'category_id',
				'subcategory_id',
				'language',
				'image_path',
				'music_file_path',
				'music_tags',
				'field_1',
				'field_2',
				'field_3',
				'field_4'
		);

		foreach ($this->mass_upload_fields_array as $key)
		{
			$this->insert_fields_arr[$key] = '';
		}
	}
	public function insertCSVRecords($mass_uploader_file_id)
	{
		$file_path = $this->csv_file_path.$this->fields_arr['csv_file_path'];
		$file = fopen($file_path, 'r');
		$row = 1;
		while (($line = fgetcsv($file,"10000", $this->csv_delimiter)) !== FALSE)
		{
			if ($row == 1 AND $this->ignore_first_row)
			{
				$row ++;
				continue; //skip the first row if it contains the header
			}
			$no_of_columns = count($line);
			$this->setTableFormFields();
			for ($col = 0; $col < $no_of_columns; $col ++)
			{
				$this->insert_fields_arr[$this->mass_upload_fields_array[$col]] = $line[$col];
			}
			$this->insertCSVValues($mass_uploader_file_id);

		}
	}
	/**
	* MassUploader::insertCSVValues()
	*
	*
	* @return void
	*/
	public function insertCSVValues($mass_uploader_file_id)
	{
		$sql = 'INSERT INTO '. $this->CFG['db']['tbl']['music_mass_uploader_record_details'].
			   ' SET music_mass_uploader_file_id = '.$mass_uploader_file_id . ', ';

		foreach ($this->insert_fields_arr as $field_name=>$field_value)
		{
			$sql .=  $field_name .' = '.$this->dbObj->Param($field_name).', ';
		}

		$sql = substr($sql, 0, strrpos($sql, ','));
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array_values($this->insert_fields_arr));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_mass_uploader_file_details'].' SET'.
								' total_songs = total_songs+1 WHERE '.
								' music_mass_uploader_file_id='.$this->dbObj->Param('music_mass_uploader_file_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($mass_uploader_file_id));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
	}
	/**
	* MassUploader::getUserId()
	*
	*
	* @return void
	*/
	public function getUserId($added_by, $err_tip)
	{
		$user_id = 0;
		$sql = 'SELECT user_id FROM '.$this->CFG['db']['tbl']['users'].
				' WHERE user_name= '.$this->dbObj->Param('user_name');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr[$added_by]));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		if($row = $rs->FetchRow())
			$user_id = $row['user_id'];
		if (!$user_id)
		{
			$this->fields_err_tip_arr[$added_by] = $err_tip;
		}
		return $user_id;
	}
	/**
	* MassUploader::showMassUploaderList()
	* To display the categories
	*
	* @return void
	*/
	public function showMassUploaderList()
	{
		global $smartyObj;
		$showUploaderList_arr = array();
		$inc = 0;
		while($row = $this->fetchResultRecord())
		{
			$row['music_mass_upload_title'] =  wordWrap_mb_ManualWithSpace($row['music_mass_upload_title'], 20,30, 0);
			$row['total_songs_moved'] = $row['total_songs_moved'];
			$row['total_songs'] = $row['total_songs'];
			$row['status'] =$row['status'];
			$row['file_name'] =$row['file_name'];
			$row['music_mass_uploader_file_id'] = $row['music_mass_uploader_file_id'];
			$showUploaderList_arr[$inc]['record'] = $row;
			$showUploaderList_arr[$inc]['checked'] = '';
			$inc++;
		}
		$smartyObj->assign('showUploaderList_arr', $showUploaderList_arr);
	}
	public function showMassEditUploaderList($file_id)
	{

		$sql = 'SELECT music_mass_upload_title,file_name,status,music_mass_uploader_file_id,added_by FROM '.$this->CFG['db']['tbl']['music_mass_uploader_file_details'].
				' WHERE music_mass_uploader_file_id= '.$this->dbObj->Param('music_mass_uploader_file_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($file_id));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
        global $smartyObj;
        $showUploaderEditList_arr = array();
		$inc = 0;
		while($row = $rs->FetchRow())
		{
		    $row['music_mass_upload_title'] =$row['music_mass_upload_title'];
            $row['file_name'] =$row['file_name'];
			$row['status'] =$row['status'];
			$row['added_by'] =$row['added_by'];
			$row['music_mass_uploader_file_id'] =$row['music_mass_uploader_file_id'];
			$showUploaderEditList_arr[$inc]['record'] = $row;
			$showUploaderEditList_arr[$inc]['checked'] = '';
			$inc++;
		}
		$smartyObj->assign('showUploaderEditList_arr', $showUploaderEditList_arr);
		}
	/**
	* MassUploader::getTotalCountMusics()
	* To display the categories
	*
	* @return void
	*/
	public function getTotalCountMusics($id)
	{

		$sql = 'SELECT count(music_mass_uploader_file_id)as total_count FROM '.$this->CFG['db']['tbl']['music_mass_uploader_record_details'].
				' WHERE music_mass_uploader_file_id= '.$this->dbObj->Param('id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($id));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($row = $rs->FetchRow())
			$count = $row['total_count'];

		return $count;


	}
	/**
	* MassUploader::resetFieldsArray()
	*
	* @return void
	*/
	public function resetFieldsArray()
		{
			$this->setFormField('upload_title', '');
			$this->setFormField('added_by', '');
			$this->setFormField('csv_file_path', '');
			$this->setFormField('category_id', '');
			$this->setFormField('form_upload_status', '');
			$this->setFormField('upload_file_ids', array());
			$this->setFormField('action', '');
		}

	public function chkIsDuplicateForUpload($err_tip = '')
		{
			$sql = 'SELECT music_mass_upload_title FROM '.$this->CFG['db']['tbl']['music_mass_uploader_file_details'].
			' WHERE music_mass_upload_title='.$this->dbObj->Param('upload_title');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['upload_title']));
			if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			if($rs->PO_RecordCount())
				{
					$this->fields_err_tip_arr['upload_title'] = $err_tip;
					return false;
				}
			return true;
		}
	public function changeStatus($status)
		{

			$upload_file_ids = $this->fields_arr['upload_file_ids'];
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_mass_uploader_file_details'].' SET'.
			' status='.$this->dbObj->Param('status').
			' WHERE music_mass_uploader_file_id IN('.$upload_file_ids.')';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($status));
			if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			return true;
		}
	public function updateEditValues($edit_csv_file_path,$edit_upload_title,$edit_path)
		{		 			
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_mass_uploader_file_details'].' SET'.
				' file_name='.$this->dbObj->Param('edit_csv_file_path').','.
				' music_mass_upload_title='.$this->dbObj->Param('music_mass_upload_title').','.
				' added_by='.$this->dbObj->Param('added_by').','.
				' status='.$this->dbObj->Param('status').
				' WHERE music_mass_uploader_file_id= '.$this->dbObj->Param('music_mass_uploader_file_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($edit_csv_file_path,$edit_upload_title,$this->fields_arr['edit_added_by'],
														 $this->fields_arr['edit_form_upload_status'],$this->fields_arr['edit_path']));
				if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);			
						
		}
		public function cheackEditStatus($edit_path)
		{
		 
		  $sql = 'SELECT status FROM '.$this->CFG['db']['tbl']['music_mass_uploader_file_details'].
			' WHERE music_mass_uploader_file_id='.$this->dbObj->Param('music_mass_uploader_file_id');			
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['edit_path']));
			if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);			
			if($row = $rs->FetchRow())
			$status = $row['status'];
			if($status=='Completed')	
			{
			   return false;			
			}
			else
			{
				return true;			
			}				
		}
		
}
//<<<<<-------------- Class obj begins ---------------//
//-------------------- Code begins -------------->>>>>//
$massUploader = new MassUploader();
$massUploader->setPageBlockNames(array('form_search','uploader_list_form','edit_path_block'));
$massUploader->upload_status_arr = array('Activate','Deactivate');
$massUploader->hidden_arr = array('list');
/************ page Navigation stop *************/
$massUploader->setAllPageBlocksHide();
$massUploader->setPageBlockShow('form_search');
$massUploader->setPageBlockShow('uploader_list_form');
$massUploader->setFormField('edit_path', '');
$massUploader->setFormField('upload_title', '');
$massUploader->setFormField('added_by', '');
$massUploader->setFormField('csv_file_path', '');
$massUploader->setFormField('form_upload_status', '');
$massUploader->setFormField('start','0');
$massUploader->setFormField('upload_file_ids', array());
$massUploader->setFormField('action', '');
$massUploader->setFormField('file_name', '');
$massUploader->setFormField('edit_upload_title', '');
$massUploader->setFormField('edit_csv_file_path', '');
$massUploader->setFormField('music_mass_upload_title', '');
$massUploader->setFormField('edit_added_by', '');
$massUploader->setFormField('edit_form_upload_status', '');
$massUploader->sanitizeFormInputs($_REQUEST);
$condition = '';
//Set tables and fields to return
if($massUploader->isFormPOSTed($_POST, 'upload_submit'))
{
	if($CFG['admin']['is_demo_site'])
	{
		$massUploader->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
		$massUploader->setPageBlockShow('block_msg_form_success');
	}
	else
	{
		$massUploader->chkIsNotEmpty('upload_title', $LANG['common_music_err_tip_required']);
		if($massUploader->getFormField('added_by')!='')
		{
			$massUploader->getUserID('added_by', $LANG['music_mass_uploader_err_tip_invalid_username']);
		}
		$massUploader->chkValidCSVFileType('csv_file_path', $LANG['common_music_err_tip_invalid_file_type']);
		$massUploader->isFileCSVExists('csv_file_path', $LANG['musicMassUploader_invalid_path']);
		$massUploader->chkIsNotEmpty('form_upload_status', $LANG['common_music_err_tip_required']);
		$massUploader->isValidFormInputs() and $massUploader->chkIsDuplicateForUpload($LANG['musicMassUploader_already_exists']);
		$filename=$massUploader->getFormField('csv_file_path');
		if ($massUploader->isValidFormInputs())
			{
				if($filename)
				{
					if ($massUploader->isValidFormInputs())
					{
						$massUploader->getCsvDetails($massUploader->getFormField('csv_file_path'),$massUploader->getFormField('upload_title'),$massUploader->getFormField('form_upload_status'));
						$massUploader->resetFieldsArray();
					}
				}
			}
	}
}
if($massUploader->isFormPOSTed($_POST, 'edit_upload_submit'))
{

	if($CFG['admin']['is_demo_site'])
	{
		$massUploader->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
		$massUploader->setPageBlockShow('block_msg_form_success');
	}
	else
	{
		$massUploader->chkIsNotEmpty('edit_upload_title', $LANG['common_music_err_tip_required']);
		$massUploader->sanitizeFormInputs($_REQUEST);
		$massUploader->chkValidCSVFileType('edit_csv_file_path', $LANG['musicMassUploader_invalid_path']);
		$massUploader->isFileCSVExists('edit_csv_file_path', $LANG['musicMassUploader_invalid_path']);
		if($massUploader->getFormField('edit_added_by')!='')
		{
			$massUploader->getUserID('edit_added_by', $LANG['music_mass_uploader_err_tip_invalid_username']);
		}
		$massUploader->chkIsNotEmpty('edit_form_upload_status', $LANG['common_music_err_tip_required']);
		$filename=$massUploader->getFormField('edit_csv_file_path');
		if ($massUploader->isValidFormInputs())
			{
				if($filename)
				{
					if ($massUploader->isValidFormInputs())
					{
						if($massUploader->cheackEditStatus($massUploader->getFormField('edit_path')))
						{
							$massUploader->updateEditValues($massUploader->getFormField('edit_csv_file_path'),$massUploader->getFormField('edit_upload_title'),$massUploader->getFormField('edit_path'));
							$massUploader->setCommonSuccessMsg($LANG['musicMassUploader_success_message']);
							$massUploader->setPageBlockShow('block_msg_form_success');
						}
						else
						{
							$massUploader->setCommonSuccessMsg($LANG['massUploadManage_file_status_not_change_label']);
							$massUploader->setPageBlockShow('block_msg_form_success');					
						}
						
					}
				}
			}
   }
}
if ($massUploader->isShowPageBlock('uploader_list_form'))
	{
		$massUploader->setTableAndColumns();
		$massUploader->buildSelectQuery();
		$massUploader->buildConditionQuery($condition);
		$massUploader->buildSortQuery();
		$massUploader->buildQuery();
		$massUploader->executeQuery();
		if($massUploader->isResultsFound())
		{
			$massUploader->showMassUploaderList();
			$massUploader->selFormUploadList['hidden_arr'] = array('start');
			$smartyObj->assign('smarty_paging_list', $massUploader->populatePageLinksPOST($massUploader->getFormField('start'), 'selFormUploadList'));
		}
	}

if ($massUploader->isFormPOSTed($_POST, 'confirm_action'))
{
	$massUploader->error = 0;
	if(!$massUploader->chkIsNotEmpty('upload_file_ids', $LANG['common_err_tip_required']))
			{
				$massUploader->setCommonErrorMsg($LANG['musicMassUploader_err_tip_select_category']);
			}
	if($massUploader->isValidFormInputs())
		{
			switch($massUploader->getFormField('action'))
					{

							case 'Active':
							$LANG['managemusiccategory_success_message'] = $LANG['musicMassUploader_success_enable_msg'];
							$massUploader->changeStatus('Active');
							break;
							case 'Deactivated':
							$LANG['managemusiccategory_success_message'] = $LANG['musicMassUploader_success_disable_msg'];
							$massUploader->changeStatus('Deactivated');
							break;

					}
		}

	if ($massUploader->isValidFormInputs())
		{
			$massUploader->setCommonSuccessMsg($LANG['musicMassUploader_success_message']);
			$massUploader->setPageBlockShow('block_msg_form_success');
		}
	else
		{
			if(!$massUploader->error)
			$massUploader->setCommonErrorMsg($LANG['common_msg_error_sorry']);
			$massUploader->setPageBlockShow('block_msg_form_error');
		}

}
if ($massUploader->getFormField('edit_path'))
{
	$massUploader->setPageBlockShow('edit_path_block');
	$massUploader->showMassEditUploaderList($massUploader->getFormField('edit_path'));
	$massUploader->setPageBlockHide('form_search');
}
$massUploader->left_navigation_div = 'musicMassUploader';
//-------------------- Page block templates begins -------------------->>>>>//

//include the header file
$massUploader->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'music');
$smartyObj->display('musicMassUploader.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/script.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/JSFCommunicator.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url']; ?>js/lib/validation/validation.js"></script>
<script language="javascript" type="text/javascript">
var cfg_site_url = '<?php echo $CFG['site']['url'];?>';
function hideAllUploadListBlocks()
{
var obj;
if(obj = $Jq('#selAlertbox'))
	obj.css('display', 'none');
if(obj = $Jq('#selMsgConfirm'))
	obj.css('display', 'none');
for(var i=0;i<block_arr.length;i++){
		if(obj = $Jq('#' + block_arr[i]))
			obj.css('display', 'none');
	}
if(obj = $Jq('#hideScreen'))
	obj.css('display', 'none');
if(obj = $Jq('#selAjaxWindow'))
	obj.css('display', 'none');
if(obj = $Jq('#selAjaxWindowInnerDiv'))
	obj.html('');

return false;

}
</script>
<?php
//<<<<<-------------------- Page block templates ends -------------------//
$massUploader->includeFooter();
?>