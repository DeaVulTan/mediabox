<?php
/**
* This file is to list the photo active
*
* This file is having list the photo active
*
*
* @category	    Rayzz PhotoSharing
* @package		Admin
* @copyright 	Copyright (c) 2010 {@link http://www.mediabox.uz Uzdc Infoway}
* @license		http://www.mediabox.uz Uzdc Infoway Licence
**/

require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/photo/admin/photoActivate.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/help.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoUpload.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/months_list_array.inc.php';

if(isset($_REQUEST['type']) and ($_REQUEST['type'] == 'Preview'))
{
	$CFG['html']['header'] = 'general/html_header_no_header.php';
	$CFG['html']['footer'] = 'general/html_footer_no_footer.php';
	$CFG['mods']['is_include_only']['html_header'] = false;
	$CFG['html']['is_use_header'] = false;
	$CFG['admin']['light_window_page'] = true;
}
else
{
	$CFG['html']['header'] = 'admin/html_header.php';
	$CFG['html']['footer'] = 'admin/html_footer.php';
	$CFG['mods']['is_include_only']['html_header'] = false;
	$CFG['html']['is_use_header'] = false;
}

$CFG['site']['is_module_page'] = 'photo';
require_once($CFG['site']['project_path'] . 'common/application_top.inc.php');

class PhotoActivate extends PhotoUploadLib
{

	/**
	 * PhotoActivate::buildConditionQuery()
	 *
	 * @return
	 **/
	public function buildConditionQuery()
	{
		$this->sql_condition = 'photo_status=\'Locked\' ';
	}
	/**
	 * PhotoActivate::buildSortQuery()
	 *
	 * @return
	 **/
	public function buildSortQuery()
	{
		$this->sql_sort = 'photo_id DESC';
	}

	/**
	 * PhotoActivate::displayPhotoList()
	 *
	 * @return
	 **/
	public function displayPhotosList()
	{

		global $smartyObj;
		$displayPhotoList_arr 		 = array();
		$thumbnail_folder_temp 		 = $this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin']['photos']['temp_folder'].'/';
		$thumbnail_folder 			 = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
		$displayPhotoList_arr['row'] = array();
		$inc = 0;
		while($row = $this->fetchResultRecord())
		{

			$row['photo_title'] = wordWrap_mb_ManualWithSpace($row['photo_title'], $this->CFG['admin']['photos']['admin_photo_title_length']);
			$displayPhotoList_arr['row'][$inc]['record'] = $row;
			$photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
			if($row['photo_ext']=='')
			$displayPhotoList_arr['row'][$inc]['img_src'] = $this->CFG['site']['url'].'photo/design/templates/'.$this->CFG['html']['template']['default'].
																'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_photo_S.jpg';
			else
			$displayPhotoList_arr['row'][$inc]['img_src'] = $this->media_relative_path.$thumbnail_folder_temp.getPhotoName($row['photo_id']).
															$this->CFG['admin']['photos']['small_name'].'.'.$row['photo_ext'];

			$displayPhotoList_arr['row'][$inc]['DISP_IMAGE'] = DISP_IMAGE($this->CFG['admin']['photos']['small_width'], $this->CFG['admin']['photos']['small_height'], $row['s_width'], $row['s_height']);
			$displayPhotoList_arr['row'][$inc]['previewURL'] = $this->CFG['site']['url'].'admin/photo/photoActivate.php?ajax=true&photo_id='.$row['photo_id'].'&type=Preview';
			//$displayPhotoList_arr['row'][$inc]['previewURL'] = $this->getUrl('photoactivate','?photo_id='.$row['photo_id'].'&type=Preview', $row['photo_id'].'/?type=Preview','','photo');
			$inc++;
		}
		$photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/';
		return 	$displayPhotoList_arr;
	}

	/**
	 * PhotoActivate::deletePhotoFileAndTableEntry()
	 *
	 * @return
	 **/
	public function deletePhotoFileAndTableEntry()
	{
		$temp_dir  = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.
					$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['temp_folder'].'/';

		$imageTempUrl      = $temp_dir.$this->PHOTO_NAME;
		$local_upload = true;
		if($this->getServerDetails())
		{
			dbDisconnect();
			if($FtpObj = new FtpHandler($this->FTP_SERVER,$this->FTP_USERNAME,$this->FTP_PASSWORD))
			{
				if($this->FTP_FOLDER)
				{
					if($FtpObj->changeDirectory($this->FTP_FOLDER))
					{
						if(is_file($imageTempUrl.'S.'.$this->PHOTO_EXT))
							unlink($imageTempUrl.'S.'.$this->PHOTO_EXT);
						if(is_file($imageTempUrl.'M.'.$this->PHOTO_EXT))
							unlink($imageTempUrl.'M.'.$this->PHOTO_EXT);
						if(is_file($imageTempUrl.'T.'.$this->PHOTO_EXT))
							unlink($imageTempUrl.'T.'.$this->PHOTO_EXT);
						if(is_file($imageTempUrl.'L.'.$this->PHOTO_EXT))
							unlink($imageTempUrl.'L.'.$this->PHOTO_EXT);

						$FtpObj->ftpClose();
						$SERVER_URL = $this->FTP_SERVER_URL;
					}
				}
			}
			dbConnect();
			$local_upload = false;
		}
		if(is_file($imageTempUrl.'S.'.$this->PHOTO_EXT))
			unlink($imageTempUrl.'S.'.$this->PHOTO_EXT);
		if(is_file($imageTempUrl.'M.'.$this->PHOTO_EXT))
			unlink($imageTempUrl.'M.'.$this->PHOTO_EXT);
		if(is_file($imageTempUrl.'T.'.$this->PHOTO_EXT))
			unlink($imageTempUrl.'T.'.$this->PHOTO_EXT);
		if(is_file($imageTempUrl.'L.'.$this->PHOTO_EXT))
			unlink($imageTempUrl.'L.'.$this->PHOTO_EXT);

		dbConnect();
		$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['photo'].' WHERE'.' photo_id='.$this->dbObj->Param($this->fields_arr['photo_id']);
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
		if (!$rs)
		trigger_db_error($this->dbObj);
		$this->sendMailToUserForDelete();
		return false;
	}

	/**
	 * PhotoActivate::UpdatePhotoStatus()
	 *
	 * @param mixed $photo_id
	 * @return
	 */
	public function UpdatePhotoStatus($photo_id)
	{
		$sql  = 'Update '.$this->CFG['db']['tbl']['photo'].' SET photo_status=\'Ok\' WHERE photo_id='.$this->dbObj->Param($this->fields_arr['photo_id']);
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->PHOTO_ID ));
		if (!$rs)
			trigger_db_error($this->dbObj);
		$sql = 'SELECT u.user_name as upload_user_name, p.photo_id, p.user_id as upload_user_id, p.photo_title, p.photo_server_url '.
				' FROM '.$this->CFG['db']['tbl']['photo'].' as p, '.$this->CFG['db']['tbl']['users'].' as u WHERE u.user_id = p.user_id AND photo_id = '.$this->dbObj->Param('photo_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->PHOTO_ID));
		if (!$rs)
			trigger_db_error($this->dbObj);
		$row = $rs->FetchRow();
	}

	/**
	 * PhotoActivate::selectPhotoIdFromTable()
	 *
	 * @return
	 **/
	public function selectPhotoIdFromTable($photo_id)
	{
		$sql = 'SELECT photo_id, photo_ext, photo_title,relation_id,photo_caption,user_id FROM '.$this->CFG['db']['tbl']['photo'].
				' WHERE photo_id='.$this->dbObj->Param('photo_id').
				' ORDER BY photo_id LIMIT 0,1';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($photo_id));
		    if (!$rs)
			    trigger_db_error($this->dbObj);
		if($row = $rs->FetchRow())
		{
			$this->USER_ID    				 = $row['user_id'];
			$this->PHOTO_ID         		 = $row['photo_id'];
			$this->PHOTO_NAME       		 = getPhotoName($this->PHOTO_ID);
			//$this->PHOTO_THUMB_NAME 		 = getPhotoImageName($this->PHOTO_ID);
			$this->PHOTO_EXT 				 = $row['photo_ext'];
			$this->PHOTO_TITLE 				 = $row['photo_title'];
			$this->PHOTO_RELATION_ID 		 = $row['relation_id'];
			$this->PHOTO_DESCRIPTION 	 	 = $row['photo_caption'];
			$this->fields_arr['photo_title'] = $row['photo_title'];
			$sql  = 'SELECT user_name, email FROM '.$this->CFG['db']['tbl']['users'].' WHERE user_id='.$this->dbObj->Param('user_id').' LIMIT 0,1';
			$stmt = $this->dbObj->Prepare($sql);
			$rs   = $this->dbObj->Execute($stmt, array($row['user_id']));
		    if (!$rs)
			    trigger_db_error($this->dbObj);
			if($row = $rs->FetchRow())
			{
				$this->PHOTO_USER_NAME = $row['user_name'];
				$this->PHOTO_USER_EMAIL = $row['email'];
			}
			return true;
		}
		return false;
	}

	/**
	 * PhotoActivate::selectedPhotoActivate()
	 *
	 * @return
	 **/
	public function selectedPhotoActivate()
	{
		$photo_id = $this->fields_arr['photo_id'];
		$photo_id = explode(',', $photo_id);
		foreach($photo_id as $key=>$value)
		{
			$this->fields_arr['photo_id'] = $value;
			$this->PHOTO_ID = $value;
			$this->UpdatePhotoStatus($this->PHOTO_ID);
			if($this->populatePhotoDetails())
			{
				$this->createErrorLogFile('Activate');
				$this->selectPhotoIdFromTable($this->PHOTO_ID);
				if($this->activatePhotoFile())
				{
					$this->addPhotoUploadActivity();
					$this->sendMailToUserForActivate();
					if($this->PHOTO_RELATION_ID)
					{
						$this->getEmailAddressOfRelation($this->PHOTO_RELATION_ID);
						$this->sendEmailToAll();
					}
				}
			}
		}
		$this->setCommonSuccessMsg($this->LANG['msg_success_activated']);
		$this->setPageBlockShow('block_msg_form_success');
	}

	/**
	 * PhotoActivate::selectedPhotoDelete()
	 *
	 * @return
	 **/
	public function selectedPhotoDelete()
	{
		$photo_id = $this->fields_arr['photo_id'];
		$photo_id = explode(',', $photo_id);
		foreach($photo_id as $key=>$value)
		{
			$this->fields_arr['photo_id'] = $value;
			$this->PHOTO_ID = $value;
			if($this->populatePhotoDetails())
			{
				$this->checkPhotoAndGetDetails($this->fields_arr['photo_id']);
				$this->deletePhotoFileAndTableEntry();
			}
		}
		$this->setCommonSuccessMsg($this->LANG['msg_success_deleted']);
		$this->setPageBlockShow('block_msg_form_success');
	}

	/**
	 * PhotoActivate::displayPhoto()
	 *
	 * @param string $photoId
	 * @return string
	 */
	public function displayPhoto($photoId = '')
	{
		$sql  = 'SELECT photo_id, photo_server_url, photo_ext, l_width, l_height FROM '.$this->CFG['db']['tbl']['photo'].' WHERE photo_id = '.$this->dbObj->Param('photo_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt, array($photoId));
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		$thumbnail_folder_temp 	= $this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin']['photos']['temp_folder'].'/';
		$imgSrc = '';
		if($row = $rs->FetchRow())
		{
			$imgSrc = $this->media_relative_path.$thumbnail_folder_temp.getPhotoName($row['photo_id']).
															$this->CFG['admin']['photos']['large_name'].'.'.$row['photo_ext'].'?'.time();
?>
			<img src="<?php echo $imgSrc;?>" width="<?php echo $row['l_width'];?>" height="<?php echo $row['l_height'];?>" />

<?php
		}
	}
}
//<<<<<-------------- Class obj begins ---------------//
$photoactivate = new PhotoActivate();
$photoactivate->setMediaPath('../../');
$photoactivate->setPageBlockNames(array('list_photo_form'));
$photoactivate->setFormField('photo_id', '');
$photoactivate->setFormField('user_id', '');
$photoactivate->setFormField('type', '');
$photoactivate->setFormField('action', '');
/*********** Page Navigation Start *********/
$photoactivate->setFormField('start', '0');
$photoactivate->setFormField('slno', '1');
$photoactivate->setFormField('numpg', $CFG['data_tbl']['numpg']);
$photoactivate->setMinRecordSelectLimit(2);
$photoactivate->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$photoactivate->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$photoactivate->setTableNames(array($CFG['db']['tbl']['photo'].' as p LEFT JOIN '.$CFG['db']['tbl']['users'].' as u ON p.user_id=u.user_id'));
$photoactivate->setReturnColumns(array('p.photo_id','p.user_id','p.photo_title', 'p.date_added', 'p.photo_server_url', 'u.user_name', 'u.first_name', 'u.last_name','p.s_height','p.s_width','p.t_width','p.t_height','u.user_id','p.photo_ext'));
/************ page Navigation stop *************/
$photoactivate->setAllPageBlocksHide();
$photoactivate->setPageBlockShow('list_photo_form');
$photoactivate->sanitizeFormInputs($_REQUEST);
$block = $photoactivate->getFormField('type');

if(isAjaxPage())
{
	$photoactivate->includeAjaxHeader();
	$photoactivate->sanitizeFormInputs($_REQUEST);
	$block = $photoactivate->getFormField('type');

	if(isset($block) && $block == 'Preview')
	{
		$photoactivate->displayPhoto($photoactivate->getFormField('photo_id'));
	}
	$photoactivate->includeAjaxFooter();
}

if($photoactivate->isFormPOSTed($_POST, 'action'))
{
	if($photoactivate->getFormField('action')=='activate')
	{
		$photoactivate->selectedPhotoActivate();
	}
	else if($photoactivate->getFormField('action')=='delete')
	{
		$photoactivate->selectedPhotoDelete();
	}
}
$photoactivate->hidden = array('start');

if ($photoactivate->isShowPageBlock('list_photo_form'))
{
	/****** navigtion continue*********/
	$photoactivate->buildSelectQuery();
	$photoactivate->buildConditionQuery();
	$photoactivate->buildSortQuery();
	$photoactivate->buildQuery();
	$photoactivate->executeQuery();
	/******* Navigation End ********/
	if($photoactivate->isResultsFound())
	{
		$photoactivate->list_photo_form['anchor'] = 'MultiDelte';
		$smartyObj->assign('smarty_paging_list', $photoactivate->populatePageLinksGET($photoactivate->getFormField('start'), array()));
		$photoactivate->list_photo_form['displayPhotoList'] = $photoactivate->displayPhotosList();
		$photoactivate->list_photo_form['onclick_activate'] = 'if(getMultiCheckBoxValue(\'photoListForm\', \'check_all\', \''.$LANG['check_atleast_one'].'\')){Confirmation(\'selMsgConfirmDelete\', \'confirmationForm\', Array(\'photo_id\', \'action\', \'confirmMsg\'), Array(multiCheckValue, \'activate\', \''.$LANG['photoactivate_activate_confirmation'].'\'), Array(\'value\', \'value\', \'innerHTML\'), -100, -200);}return false;';
		$photoactivate->list_photo_form['onclick_delete'] = 'if(getMultiCheckBoxValue(\'photoListForm\', \'check_all\', \''.$LANG['check_atleast_one'].'\')){Confirmation(\'selMsgConfirmDelete\', \'confirmationForm\', Array(\'photo_id\', \'action\', \'confirmMsg\'), Array(multiCheckValue, \'delete\', \''.$LANG['photoactivate_delete_confirmation'].'\'), Array(\'value\', \'value\', \'innerHTML\'), -100, -200);}return false;';
	}
}

$photoactivate->left_navigation_div = 'photoMain';
//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$photoactivate->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'photo');
$smartyObj->display('photoActivate.tpl');
?>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/AG_ajax_html.js"></script>
<script type="text/javascript" src="{$CFG.site.url}js/swfobject.js"></script>
<script language="javascript" type="text/javascript" >
	var block_arr= new Array('selMsgConfirmDelete');
</script>
<?php
//<<<<<-------------------- Page block templates ends -------------------//
$photoactivate->includeFooter();
?>