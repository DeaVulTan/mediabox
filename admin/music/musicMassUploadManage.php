<?php
/**
* This file is to musicMassmanage
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
$CFG['lang']['include_files'][] = 'languages/%s/music/admin/musicMassUploadManage.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['lang']['include_files'][] = 'common/music_common_functions.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/help.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['mods']['include_files'][] = 'common/classes/php_reader/getMetaData.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicUpload.lib.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/language_list_array.inc.php';
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
class UploadManage extends MusicUploadLib
{
	/**
	* set the condition
	* set the condition
	*
	* @access public
	* @return void
	**/
	public function buildConditionQuery()
	{
	$this->sql_condition = 'mr.music_mass_uploader_file_id=\''.addslashes($this->fields_arr['uid']).'\'';
	}
	/**
	* Comments::buildSortQuery()
	*
	* @return
	*/
	public function buildSortQuery()
	{
		$this->sql_sort = 'mr.music_mass_uploader_file_id';
	}

	public function setTableAndColumns()
	{
		$this->setTableNames(array($this->CFG['db']['tbl']['music_mass_uploader_file_details'].' as mu JOIN '.$this->CFG['db']['tbl']['music_mass_uploader_record_details'].' as mr ON mr.music_mass_uploader_file_id=mu.music_mass_uploader_file_id'));
		$this->setReturnColumns(array('mu.music_mass_upload_title','mu.total_songs_moved','mu.status','mu.date_added','mr.status',
		'mr.music_mass_uploader_file_id','mr.music_title','mr.album_name','mr.artist_names','mr.music_year_released','mr.music_tags','mr.music_mass_uploader_record_id','mr.error_log','mr.music_id'));
		$this->sql_condition = 'mu.status=\'Active\' AND mr.music_mass_uploader_file_id='.$this->fields_arr['uid'];
		$this->sql_sort = 'mu.music_mass_uploader_file_id DESC';
	}

	/**
	* MassUploader::showMassUploaderList()
	* To display the categories
	*
	* @return void
	*/
	public function showUploaderManageList()
	{
		global $smartyObj;
		$showUploaderList_arr = array();
		$inc = 0;
		while($row = $this->fetchResultRecord())
		{
			$row['music_title'] =  wordWrap_mb_ManualWithSpace($row['music_title'], 20,30, 0);
			$row['album_name'] = $row['album_name'];
			$row['artist_names'] =$row['artist_names'];
			$row['status'] =$row['status'];
			$row['music_year_released'] = $row['music_year_released'];
			$row['music_tags'] = $row['music_tags'];
			$row['error_log'] = $row['error_log'];
			$row['music_id'] = $row['music_id'];
			$row['music_mass_uploader_file_id'] = $row['music_mass_uploader_file_id'];
			$row['music_mass_uploader_record_id'] = $row['music_mass_uploader_record_id'];
			$showUploaderList_arr[$inc]['record'] = $row;
			$showUploaderList_arr[$inc]['checked'] = '';
			$inc++;
		}
		$smartyObj->assign('showUploaderList_arr', $showUploaderList_arr);
	}
	/**
	* MassUploader::showUploaderEditManage()
	*
	* @return void
	*/
	public function showUploaderEditManage()
	{
		global $smartyObj;
		$populateUpload_arr = array();
		$sql = 'SELECT music_title,album_name,artist_names,music_year_released,music_tags,music_mass_uploader_record_id,music_mass_uploader_file_id,
		music_file_path,image_path,field_1,field_2,field_3,field_4,error_log,music_id,category_id,subcategory_id'.
		' FROM '.$this->CFG['db']['tbl']['music_mass_uploader_record_details'].
		' WHERE music_mass_uploader_record_id='.$this->dbObj->Param('music_title_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_title_id']));
		if (!$rs)
		trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		$populateUpload_arr['rs_PO_RecordCount'] = $rs->PO_RecordCount();
		if($rs->PO_RecordCount())
		{
			$populateUpload_arr['row'] = array();
			$inc = 0;
			while($row = $rs->FetchRow())
			{
				$row['music_title'] = $row['music_title'];
				$row['album_name'] = $row['album_name'];
				$row['artist_names'] = $row['artist_names'];
				$row['music_year_released'] = $row['music_year_released'];
				$row['music_tags'] = $row['music_tags'];
				$row['music_mass_uploader_file_id'] = $row['music_mass_uploader_file_id'];
				$row['music_file_path'] = $row['music_file_path'];
				$row['image_path'] = $row['image_path'];
				$row['field_1'] = $row['field_1'];
				$row['field_2'] = $row['field_2'];
				$row['field_3'] = $row['field_3'];
				$row['field_4'] = $row['field_4'];
				$row['music_id'] = $row['music_id'];
				$row['error_log'] = $row['error_log'];
				$this->fields_arr['music_category_id']=$row['category_id'] = $row['category_id'];
				$this->fields_arr['music_sub_category_id']=$row['subcategory_id'] = $row['subcategory_id'];

				$populateUpload_arr['row'][$inc]['record'] = $row;
				$populateUpload_arr['row'][$inc]['checked'] = '';
				$inc++;
			}
		}
		$smartyObj->assign('populateUpload_arr', $populateUpload_arr);
	}
	/**
	* MassUploader::updateUploaderEditManage()
	*
	* @return void
	*/
	public function updateUploaderEditManage()
	{
		$sql = 'UPDATE  '.
		$this->CFG['db']['tbl']['music_mass_uploader_record_details'].' '.
		' SET music_title ='.$this->dbObj->Param('music_title_mng').','.
		' album_name='.$this->dbObj->Param('album_name_mng').','.
		' artist_names='.$this->dbObj->Param('artist_names_mng').','.
		' music_year_released='.$this->dbObj->Param('music_year_released_mng').','.
		' language='.$this->dbObj->Param('music_language').','.
		' music_tags='.$this->dbObj->Param('music_tags_mng').','.
		' category_id='.$this->dbObj->Param('music_category_id').','.
		' subcategory_id='.$this->dbObj->Param('music_sub_category_id').','.
		' field_1='.$this->dbObj->Param('field_1').','.
		' field_2='.$this->dbObj->Param('field_2').','.
		' field_3='.$this->dbObj->Param('field_3').','.
		' field_4='.$this->dbObj->Param('field_4').
		' WHERE music_mass_uploader_record_id=' . $this->dbObj->Param('music_title_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_title_mng'],
										 $this->fields_arr['album_name_mng'],
										 $this->fields_arr['artist_names_mng'],
										 $this->fields_arr['music_year_released_mng'],
										 $this->fields_arr['music_language'],
										 $this->fields_arr['music_tags_mng'],
										 $this->fields_arr['music_category_id'],
										 $this->fields_arr['music_sub_category_id'],
										 $this->fields_arr['field_1'],
										 $this->fields_arr['field_2'],
										 $this->fields_arr['field_3'],
										 $this->fields_arr['field_4'],
										 $this->fields_arr['music_title_id']
										 ));
		if (!$rs)
		trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
	}
	public function updateUploaderManageMusicTable()
	{

	$sql = 'SELECT music_id FROM '.$this->CFG['db']['tbl']['music_mass_uploader_record_details'].
				' WHERE music_mass_uploader_record_id=' . $this->dbObj->Param('music_title_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_title_id']));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($row = $rs->FetchRow())
			$music_id = $row['music_id'];

        $this->fields_arr['old_artist_names_for_mass_upload'] = '';
		$new_album_id = $this->chkAlbumName($this->fields_arr['album_name_mng']);
		if(empty($new_album_id) and !empty($this->fields_arr['album_name_mng']))
		{
			$this->fields_arr['music_album_id'] = $this->addAlbumName($this->fields_arr['album_name_mng']);
		}
		else
		$this->fields_arr['music_album_id'] = $new_album_id;
		if($this->fields_arr['music_album_id'] == '')
		$this->fields_arr['music_album_id'] = 1;

        $artist_new = explode(',', trim($this->fields_arr['artist_names_mng']));
		$artist_old = explode(',', $this->fields_arr['old_artist_names_for_mass_upload']);
		$artist_diff = array_diff($artist_new, $artist_old);
		$common_artists = array_intersect($artist_new, $artist_old);
		if(!empty($artist_diff))
		{
			$artist_diff = implode(',', $artist_diff);
			//$this->upadateArtistTable($this->fields_arr['music_artist_'.$i]);
			$this->upadateArtistTable($artist_diff);
			$common_artist_id = array();
			$inc = 0;
			foreach($common_artists as $common_artist_name)
				{
					$common_artist_id[$inc] = $this->getArtistIdFromName(trim($common_artist_name));
					$this->getArtistIdFromName($common_artist_name);
					$inc++;
				}

			$common_artist_id = implode(',', $common_artist_id);
			if(!empty($common_artist_id))
				$this->artist_id = $common_artist_id.','.$this->artist_id;
			$this->fields_arr['music_artist'] = $this->artist_id;

			$music_artist_key = array_search('music_artist', $this->fields_arr);
			if($music_artist_key == '')
				array_push($this->fields_arr, 'music_artist');
		}
		else
		{
			$music_artist_key = array_search('music_artist', $this->fields_arr);
			unset($this->fields_arr[$music_artist_key]);
		}
        $sql = 'UPDATE  '.
		$this->CFG['db']['tbl']['music'].' '.
		' SET music_title ='.$this->dbObj->Param('music_title_mng').','.
		' music_album_id='.$this->dbObj->Param('album_id').','.
		' music_artist='.$this->dbObj->Param('music_artist').','.
		' music_year_released='.$this->dbObj->Param('music_year_released_mng').','.
		' music_tags='.$this->dbObj->Param('music_tags').','.
		' music_language='.$this->dbObj->Param('music_language').','.
		' music_category_id='.$this->dbObj->Param('music_category_id').','.
		' music_sub_category_id='.$this->dbObj->Param('music_sub_category_id').' WHERE music_id=' . $this->dbObj->Param('music_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_title_mng'],
										 $this->fields_arr['music_album_id'],
										 $this->fields_arr['music_artist'],
										 $this->fields_arr['music_year_released_mng'],
										 $this->fields_arr['music_tags_mng'],
										 $this->fields_arr['music_language'],
										 $this->fields_arr['music_category_id'],
										 $this->fields_arr['music_sub_category_id'],
										 $music_id
										 ));

		if (!$rs)
		trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
	}
	public function populateMusicCatagory($type = 'General', $err_tip='')
		{
			$sql = 'SELECT music_category_id, music_category_name FROM '.
					$this->CFG['db']['tbl']['music_category'].
					' WHERE parent_category_id=0 AND music_category_status=\'Yes\''.
					' AND music_category_type='.$this->dbObj->Param('music_category_type').
					' AND allow_post=\'Yes\'';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($type));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if(!$rs->PO_RecordCount())
				return;

			$names = array('music_category_name');
			$value = 'music_category_id';
			$highlight_value = $this->fields_arr['music_category_id'];

			$inc = 0;

			while($row = $rs->FetchRow())
				{
					$out = '';
					foreach($names as $name)
						$out .= $row[$name];
					$selected = $highlight_value == $row[$value]?' selected':'';
					?><option value="<?php echo $row[$value];?>" <?php echo $selected;?>><?php echo $out;?></option><?php
					$inc++;
				}
		}
		public function populateMusicSubCatagory($cid)
		{

			$sql = 'SELECT music_category_id, music_category_name FROM '.
					$this->CFG['db']['tbl']['music_category'].
					' WHERE parent_category_id='.$this->dbObj->Param('music_category_id').
					' AND music_category_status=\'Yes\' AND allow_post=\'Yes\'';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['cid']));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);

			$names = array('music_category_name');
			$value = 'music_category_id';
			$highlight_value = $this->fields_arr['music_sub_category_id'];
			?><select name="music_sub_category_id" id="music_sub_category_id">
				<option value=""><?php echo $this->LANG['common_select_option'];?></option>
			<?php

			while($row = $rs->FetchRow())
				{
					$out = '';
					$selected = $highlight_value == $row[$value]?' selected':'';
					foreach($names as $name)
						$out .= $row[$name].' ';
					?>
					<option value="<?php echo $row[$value];?>" <?php  echo $selected;?>><?php echo $out;?></option>
					<?php
				}
			?></select><?php
		}

}
//<<<<<-------------- Class obj begins ---------------//
//-------------------- Code begins -------------->>>>>//
$uploadManage = new UploadManage();
$uploadManage->setPageBlockNames(array('mass_upload_manage_frm','mass_upload_edit_list','view_error_block'));
$uploadManage->hidden_arr = array('list');
/************ page Navigation stop *************/
$uploadManage->setAllPageBlocksHide();
$uploadManage->setFormField('uid', '');
$uploadManage->setFormField('music_category_id','');
$uploadManage->setFormField('music_title_id', '');
$uploadManage->setFormField('view_error','');
$uploadManage->sanitizeFormInputs($_REQUEST);
$uploadManage->selFormUploadList['hidden_arr'] = array('start','uid');
$uploadManage->sanitizeFormInputs($_GET);
$uid=$uploadManage->getFormField('uid');
$uploadManage->setFormField('music_title_mng','');
$uploadManage->setFormField('album_name_mng','');
$uploadManage->setFormField('artist_names_mng','');
$uploadManage->setFormField('music_year_released_mng','');
$uploadManage->setFormField('music_path_mng','');
$uploadManage->setFormField('music_image_path_mng','');
$uploadManage->setFormField('music_tags_mng','');
$uploadManage->setFormField('field_1','');
$uploadManage->setFormField('field_2','');
$uploadManage->setFormField('field_3','');
$uploadManage->setFormField('field_4','');
$uploadManage->setFormField('music_id','');
$uploadManage->setFormField('music_artist','');
$uploadManage->setFormField('music_sub_category_id','');
$uploadManage->setFormField('cid','');
$uploadManage->setFormField('music_language','');
$uploadManage->selFormUploadList['hidden_arr'] = array('start','uid');
$uploadManage->setFormField('numpg', 20);
$uploadManage->sanitizeFormInputs($_REQUEST);
$uploadManage->setTableAndColumns();
$uploadManage->buildSelectQuery();
$uploadManage->buildConditionQuery();
$uploadManage->buildSortQuery();
$uploadManage->buildQuery();
$uploadManage->executeQuery();
$uploadManage->LANG_LANGUAGE_ARR = $LANG_LIST_ARR['language'];

if ($uploadManage->getFormField('uid'))
{
	if($uploadManage->isResultsFound())
	{
		$uploadManage->setPageBlockShow('mass_upload_manage_frm');
		$uploadManage->showUploaderManageList();
		$smartyObj->assign('smarty_paging_list', $uploadManage->populatePageLinksPOST($uploadManage->getFormField('start'), 'selFormUploadList'));
	}
}
if ($uploadManage->getFormField('music_title_id'))
{
	$uploadManage->setPageBlockShow('mass_upload_edit_list');
	$uploadManage->setPageBlockHide('mass_upload_manage_frm');
	$uploadManage->showUploaderEditManage();

}
if ($uploadManage->getFormField('view_error'))
{
	$uploadManage->setPageBlockShow('view_error_block');
}
if($uploadManage->isFormPOSTed($_POST, 'edit_submit'))
{
	if($CFG['admin']['is_demo_site'])
	{
		$uploadManage->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
		$uploadManage->setPageBlockShow('block_msg_form_success');
	}
	else
	{
		if ($uploadManage->isValidFormInputs())
		{
			$uploadManage->sanitizeFormInputs($_REQUEST);
			$uploadManage->updateUploaderEditManage();
			$uploadManage->updateUploaderManageMusicTable();
			$uploadManage->setCommonSuccessMsg($LANG['massUploadManage_success_message']);
			$uploadManage->setPageBlockShow('block_msg_form_success');
			$uploadManage->setPageBlockHide('edit_list');
			$uploadManage->setPageBlockHide('mass_upload_edit_list');
			$uploadManage->setPageBlockShow('mass_upload_manage_frm');
		}
	}
}
if($uploadManage->isFormPOSTed($_POST, 'cid')) //Populate SubCategory
{
	$uploadManage->includeAjaxHeaderSessionCheck();
	$uploadManage->getFormField('music_category_id');
 	$uploadManage->populateMusicSubCatagory($uploadManage->getFormField('cid'));
	$uploadManage->includeAjaxFooter();
	exit;
}

$uploadManage->left_navigation_div = 'musicMassUploader';
//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$uploadManage->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'music');
$smartyObj->display('musicMassUploadManage.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/script.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/JSFCommunicator.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url']; ?>js/lib/validation/validation.js"></script>
<script language="javascript" type="text/javascript">
var cfg_site_url = '<?php echo $CFG['site']['url'];?>';
function populateMusicSubCategory(cat)
	{
	    	var url = '<?php echo $CFG['site']['url'].'admin/music/musicMassUploadManage.php';?>';
			var pars = 'ajax_page=true&cid='+cat;
			<?php if($uploadManage->getFormField('music_sub_category_id')){?>
			pars = pars+'&music_sub_category_id=<?php echo $uploadManage->getFormField('music_sub_category_id');?>';
			<?php }?>

			var method_type = 'post';
			populateSubCategoryRequest(url, pars, method_type);
	}
<?php if($uploadManage->getFormField('music_category_id')){?>
	populateMusicSubCategory('<?php echo $uploadManage->getFormField('music_category_id'); ?>');
<?php }?>
</script>
<?php
//<<<<<-------------------- Page block templates ends -------------------//
$uploadManage->includeFooter();
?>
