<?php
//--------------class photoAlbumManage--------------->>>//
/**
 * This class is used to manage photo album
 *
 * @category	Rayzz
 * @package		manage photo album
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 */
class photoAlbumManage extends PhotoHandler
{
	/**
	 * photoAlbumManage::clearForm()
	 *
	 * @return
	 */
	public function clearHistory()
	{
		$this->fields_arr['photo_album_id'] = '';
		$this->fields_arr['photo_album_title'] = '';
		$this->fields_arr['album_access_type'] = 'Private';
	}

	/**
	 * photoAlbumManage::chkIsAlbumEditMode()
	 *
	 * @return boolean
	 */
	public function chkIsAlbumEditMode()
	{
		if($this->fields_arr['photo_album_id'])
			return true;
		return false;
	}

	/**
	 * photoAlbumManage::chkIsAlbumEditable()
	 *
	 * @param mixed $album_id
	 * @return boolean
	 */
	public function chkIsAlbumEditable($album_id)
	{
		$sql = 'SELECT pa.photo_album_id, p.user_id FROM '.
				$this->CFG['db']['tbl']['photo_album'].' as pa '.
				' LEFT JOIN '.$this->CFG['db']['tbl']['photo'].' as p '.
				' ON pa.photo_album_id=p.photo_album_id '.
				' WHERE pa.photo_album_id='.$this->dbObj->Param('photo_album_id').
				' AND pa.user_id='.$this->dbObj->Param('uer_id').
				' AND pa.user_id!=p.user_id';
		$stmt = $this->dbObj->Prepare($sql);
		 $rs = $this->dbObj->Execute($stmt, array($album_id, $this->CFG['user']['user_id']));
		 if (!$rs)
		 	trigger_db_error($this->dbObj);
		if($row = $rs->FetchRow())
		{
			return false;
		}
		return true;
	}

	/**
	 * photoAlbumManage::showAlbums()
	 *
	 * @return
	 */
	public function showAlbums()
	{
		$showAlbums_arr = array();
		//Image..

		$inc=0;
		while($row = $this->fetchResultRecord())
		{
			$showAlbums_arr[$inc]['anchor']            = 'dAlt_'.$row['photo_album_id'];
			$showAlbums_arr[$inc]['photo_album_id']    = $row['photo_album_id'];
			$showAlbums_arr[$inc]['album_wrap_title']  = nl2br(makeClickableLinks($row['photo_album_title']));
			$showAlbums_arr[$inc]['photo_album_title'] = $row['photo_album_title'];
			$showAlbums_arr[$inc]['album_access_type'] = $row['album_access_type'];
			//Playlist image
			//$showAlbums_arr[$inc]['getAlbumImageDetail'] = $this->getAlbumImageDetail($row['photo_album_id']);// This function return album image detail array..//
			$showAlbums_arr[$inc]['album_view_link'] = getUrl('photolist', '?pg=albumphotolist&album_id='.$row['photo_album_id'],
														'albumphotolist/?album_id=' . $row['photo_album_id'], '', 'photo');
			$showAlbums_arr[$inc]['album_edit_link'] = getUrl('photolist', '?pg=myalbum&photo_album_id='.$row['photo_album_id'],
														'myalbum/?photo_album_id='.$row['photo_album_id'], '', 'photo');
			$showAlbums_arr[$inc]['edit_link']		 = getUrl('photoalbummanage', '?photo_album_id='.$row['photo_album_id'],
														'?photo_album_id='.$row['photo_album_id'], '', 'photo');
			$showAlbums_arr[$inc]['record']=$row;
			$inc++;
		}
		return $showAlbums_arr;
	}

	/**
	 * MyAlbums::buildConditionQuery()
	 *
	 * @return
	 **/
	public function buildConditionQuery()
	{
		$this->sql_condition = 'pa.user_id=\''.$this->CFG['user']['user_id'].'\'';
	}

	/**
	 * MyAlbums::buildSortQuery()
	 *
	 * @return
	 **/
	public function buildSortQuery()
	{
		$this->sql_sort = $this->fields_arr['orderby_field'].' '.$this->fields_arr['orderby'];
	}

	/**
	 * photoAlbumManage::getPhotoAlbum()
	 *
	 * @return boolean
	 */
	public function getPhotoAlbum()
	{
		if(!$this->chkIsAlbumEditable($this->fields_arr['photo_album_id']))
			return false;
		$sql  = 'SELECT photo_album_title, album_access_type'.
				' FROM '.$this->CFG['db']['tbl']['photo_album'].
				' WHERE photo_album_id ='.$this->dbObj->Param('photo_album_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_album_id']));
		if (!$rs)
			trigger_db_error($this->dbObj);
		if($row = $rs->FetchRow())
		{
			$this->fields_arr['photo_album_title'] = $row['photo_album_title'];
			$this->fields_arr['album_access_type'] = $row['album_access_type'];
			return true;
		}
		return false;

	}

	/**
	 * photoAlbumManage::chkAlbumExists()
	 *
	 * @param mixed $fields_name
	 * @param string $err_tip
	 * @param string $album_type
	 * @return boolean
	 */
	public function chkAlbumExists($fields_name, $err_tip='', $album_type='Public')
	{
		$sql = 'SELECT photo_album_title FROM '.
				$this->CFG['db']['tbl']['photo_album'].
				' WHERE photo_album_title = '.$this->dbObj->Param('photo_album_title').
				' AND album_access_type = '.$this->dbObj->Param('album_access_type').
				' AND user_id = '.$this->dbObj->Param('user_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->getFormField('photo_album_title'), $album_type, $this->CFG['user']['user_id']));
		if (!$rs)
			trigger_db_error($this->dbObj);
		if($row = $rs->FetchRow())
		{
			$this->fields_err_tip_arr['photo_album_title'] = $err_tip;
			return false;
		}
		return true;
	}

	/**
	 * photoAlbumManage::createAlbum()
	 *
	 * @return void
	 */
	public function createAlbum()
	{
		 if(isset($this->fields_arr['photo_album_id']) and $this->fields_arr['photo_album_id'] != '')
		{
			$sql = 'UPDATE ';
		}
		else
			$sql = 'INSERT into ';
		$param_arr = array($this->fields_arr['photo_album_title'], $this->fields_arr['album_access_type'],$this->CFG['user']['user_id']);
		$sql .= $this->CFG['db']['tbl']['photo_album'].
				' SET '.
				'photo_album_title ='.$this->dbObj->Param('photo_album_title').','.
				'album_access_type ='.$this->dbObj->Param('album_access_type').','.
				'user_id ='.$this->dbObj->Param('user_id');
		if(isset($this->fields_arr['photo_album_id']) and $this->fields_arr['photo_album_id'] != '')
		{
			$param_arr[] = $this->fields_arr['photo_album_id'];
			$sql .= ' WHERE photo_album_id ='.$this->dbObj->Param('photo_album_id');
		}
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, $param_arr);
		if (!$rs)
			trigger_db_error($this->dbObj);
	}

	/**
	 * photoAlbumManage::deletePhotoAlbum()
	 *
	 * @return boolean
	 */
	public function deletePhotoAlbum()
	{
		$album_ids = $this->fields_arr['photo_album_ids'];
		if ($this->chkPhotoExists($album_ids))
			return false;
		$sql  = 'DELETE FROM '.$this->CFG['db']['tbl']['photo_album'].' '.'WHERE photo_album_id IN ('.$album_ids.') ';
		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_db_error($this->dbObj);
		return true;
	}

	/**
	 * photoAlbumManage::chkPhotoExists()
	 *
	 * @param mixed $album_ids
	 * @return boolean
	 */
	public function chkPhotoExists($album_ids)
	{
		$sql = 'SELECT count( p.photo_id ) AS photo_count, photo_album_id'.' FROM '.$this->CFG['db']['tbl']['photo'].' p'.
				' WHERE photo_album_id IN ( '.$album_ids.' )'.' AND photo_status!=\'Deleted\''.' GROUP BY photo_album_id';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
		trigger_db_error($this->dbObj);
		if ($rs->PO_RecordCount())
			return true;
		return false;
	}

	/**
	 * photoAlbumManage::getphotoCount()
	 *
	 * @param mixed $album_id
	 * @return string total number of photos
	 */
	public function getphotoCount($album_id)
	{
		$sql = 'SELECT count(p.photo_id) as photo_count '.
				'FROM '.$this->CFG['db']['tbl']['photo'].' as p '.
				'WHERE photo_status = \'Ok\' AND photo_album_id = '.$this->dbObj->Param('album_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($album_id));
		if (!$rs)
		trigger_db_error($this->dbObj);
		$row = $rs->FetchRow();
		return $row['photo_count'];
	}

}
//<<<<<-------------- Class photoAlbumManage end ---------------//
//-------------------- Code begins -------------->>>>>//
$photoalbummanage = new photoAlbumManage();
if(!chkAllowedModule(array('photo')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
/*echo '<pre>';
print_r($_REQUEST);
echo '</pre>';*/
$photoalbummanage->setPageBlockNames(array('create_album_block', 'list_album_block'));
$photoalbummanage->setFormField('photo_album_title', '');
$photoalbummanage->setFormField('album_access_type', 'Private');
$photoalbummanage->setFormField('photo_album_id', '');
$photoalbummanage->setFormField('total_tracks', '');

$photoalbummanage->setFormField('photo_album_ids', '');
$photoalbummanage->setFormField('start', '0');
$photoalbummanage->setFormField('action', '');
$photoalbummanage->setFormField('photo_album_ids', array());
$photoalbummanage->setFormField('numpg', $CFG['data_tbl']['numpg']);
$photoalbummanage->setMinRecordSelectLimit(2);
$photoalbummanage->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$photoalbummanage->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);

$photoalbummanage->setFormField('orderby_field', 'photo_album_title');
$photoalbummanage->setFormField('orderby', 'DESC');

$photoalbummanage->setTableNames(array($CFG['db']['tbl']['photo_album'].' as pa'));
//$photoalbummanage->setTableNames(array($CFG['db']['tbl']['photo_album'].' as pl LEFT JOIN '.$CFG['db']['tbl']['photo'].' as m ON pl.user_id=m.user_id'));
$photoalbummanage->setReturnColumns(array('pa.photo_album_id','pa.user_id','pa.album_access_type', 'pa.photo_album_title', 'pa.date_added'));
$photoalbummanage->setAllPageBlocksHide();
$photoalbummanage->setPageBlockShow('create_album_block');
$photoalbummanage->setPageBlockShow('list_album_block');
$photoalbummanage->sanitizeFormInputs($_REQUEST);
$photoalbummanage->createalbum_url = getUrl('photoalbummanage', '', '', '', 'photo');
if($photoalbummanage->isFormPOSTed($_POST, 'album_submit'))
	{
		$photoalbummanage->chkIsNotEmpty('photo_album_title', $LANG['photoalbum_tip_compulsory']);
		if(!$photoalbummanage->chkIsAlbumEditMode())
			$photoalbummanage->chkAlbumExists('photo_album_title', $LANG['photoalbum_err_tip_alreay_exists'], $photoalbummanage->getFormField('album_access_type'));

		$photoalbummanage->setPageBlockShow('create_album_block');
		if($photoalbummanage->isValidFormInputs())
			{
				$photoalbummanage->createAlbum();
				if($photoalbummanage->getFormField('photo_album_id'))
					{
						$photoalbummanage->setPageBlockShow('block_msg_form_success');
						$photoalbummanage->setCommonSuccessMsg($LANG['photoalbum_update_successfully']);
					}
				else
					{
						$photoalbummanage->setPageBlockShow('block_msg_form_success');
						$photoalbummanage->setCommonSuccessMsg($LANG['photoalbum_created_successfully']);
					}
				$photoalbummanage->clearHistory();
			}
		else
			{
				$photoalbummanage->setPageBlockShow('block_msg_form_error');
				$photoalbummanage->setCommonErrorMsg($LANG['photoalbum_create_failure']);
			}
	}
if($photoalbummanage->getFormField('photo_album_id'))
	{
		if($photoalbummanage->chkIsAlbumEditable($photoalbummanage->getFormField('photo_album_id')))
		{
			if(!$photoalbummanage->getPhotoAlbum())
			{
				$photoalbummanage->setPageBlockShow('block_msg_form_error');
				$photoalbummanage->setCommonErrorMsg($LANG['photoalbum_invalid_id']);
			}
		}
		else
		{
			$photoalbummanage->setPageBlockShow('block_msg_form_error');
			$photoalbummanage->setCommonErrorMsg($LANG['photoalbum_not_editable']);
		}
	}
if($photoalbummanage->getFormField('action'))
	{
		$photoalbummanage->setAllPageBlocksHide();
		$photoalbummanage->setPageBlockShow('create_album_block');
		$photoalbummanage->setPageBlockShow('list_album_block');
		switch($photoalbummanage->getFormField('action'))
			{
				case 'delete':
						if($photoalbummanage->deletePhotoAlbum())
						{
							$photoalbummanage->setCommonSuccessMsg($LANG['photoalbum_delete_successfully']);
							$photoalbummanage->setPageBlockShow('block_msg_form_success');
						}
						else
						{
							$photoalbummanage->setCommonErrorMsg($LANG['photoalbum_photo_exists']);
							$photoalbummanage->setPageBlockShow('block_msg_form_error');
						}

				break;
			}
	}
//<<<<<-------------- Code end ----------------------------------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($photoalbummanage->isShowPageBlock('list_album_block'))
	{
		/****** navigtion continue*********/
		$photoalbummanage->buildSelectQuery();
		$photoalbummanage->buildConditionQuery();
		$photoalbummanage->buildSortQuery();
		$photoalbummanage->buildQuery();
		$photoalbummanage->executeQuery();
		if($photoalbummanage->isResultsFound())
			{
				$photoalbummanage->hidden_arr = array('start', 'orderby','orderby_field');
				$photoalbummanage->list_album_block['showAlbums'] = $photoalbummanage->showAlbums();
				$smartyObj->assign('smarty_paging_list', $photoalbummanage->populatePageLinksGET($photoalbummanage->getFormField('start'),array()));
				$photoalbummanage->delePhotoForm_hidden_arr = array('orderby','orderby_field');
			}
	}
 /*if ($photoalbummanage->chkIsAdminSide())
	$photoalbummanage->left_navigation_div = 'photoMain';*/
//include the header file
$photoalbummanage->includeHeader();
//include the content of the page
setTemplateFolder('general/','photo');
$smartyObj->display('photoAlbumManage.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
?>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/JSFCommunicator.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/admin/css/reOrder.css">
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/admin/css/fonts-min.css">
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/yahoo-dom-event.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/animation-min.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/dragdrop-min.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/reOrder.js"></script>
<script language="javascript"   type="text/javascript">
	var block_arr= new Array('selMsgConfirm', 'selMsgConfirmSingle');
	var replace_url = '<?php echo $CFG['site']['url'];?>login.php';
	var please_select_action = '<?php echo $LANG['err_tip_select_action'];?>';
	var site_url = '<?php echo $CFG['site']['photo_url'];?>';
	var confirm_message = '';
	function getAction(act_value)
		{
			if(act_value)
				{
					switch (act_value)
						{
							case 'delete':
								confirm_message = '<?php echo $LANG['photoalbum_multi_delete_confirmation'];?>';
								break;
						}
					$Jq('#confirmMessage').html(confirm_message);
					document.msgConfirmform.action.value = act_value;
					Confirmation('selMsgConfirm', 'msgConfirmform', Array('photo_album_ids'), Array(multiCheckValue), Array('value'),'selFormForums');
				}
				else
					alert_manual(please_select_action);
		}
</script>
<?php
/* Added code to validate mandataory fields in photo defaut settings page */
if ($CFG['feature']['jquery_validation'] && $photoalbummanage->isShowPageBlock('create_album_block'))
{
?>
	<script type="text/javascript">
	$Jq("#photoAlbumManages").validate({
		rules: {
		    photo_album_title: {
		    	required: true
		    }
		},
		messages: {
			photo_album_title: {
				required: "<?php echo $LANG['common_err_tip_required'];?>"
			}
		}
	});
</script>
<?php
}
$photoalbummanage->includeFooter();
?>