<?php
/**
* organizeSlidelist Organize Slidelist list
*
* @category	Rayzz
* @package		General
* @author 		shankar_044at09
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
* @license		http://www.mediabox.uz Uzdc Infoway Licence
*/
class organizeSlidelist extends PhotoHandler
{
	public function getOrganizeSlidelistList($slidelist_id)
	{
		global $smartyObj;
		$getSlidelistImageDetail_arr = array();
		$condition='';
		$this->isResultsFound = false;
		$sql = 'SELECT pip.photo_id, p.photo_server_url,p.photo_ext, p.photo_title, pfs.file_name,pip.order_id,pip.photo_playlist_id, '.
		' p.s_width, p.s_height, p.t_width, p.t_height FROM '.
		$this->CFG['db']['tbl']['photo_in_playlist'].' AS pip JOIN '.
		$this->CFG['db']['tbl']['photo'].' AS p ON p.photo_id=pip.photo_id  JOIN '.
		$this->CFG['db']['tbl']['photo_files_settings'].' AS pfs '.
		'ON pfs.photo_file_id = p.photo_file_name_id, '.$this->CFG['db']['tbl']['users'].
		' AS u WHERE pip.photo_playlist_id ='.$this->dbObj->Param('photo_playlist_id').' '.
		' AND p.user_id=u.user_id AND u.usr_status = \'Ok\' AND p.photo_status = \'Ok\' ';
		if($condition)
		$sql .= ' AND (p.user_id = '.$this->CFG['user']['user_id'].
		' OR p.photo_access_type = \'Public\''.
		$this->getAdditionalQuery().') '.$this->getAdultQuery('p.', 'photo');
		$sql .= ' ORDER BY pip.order_id ASC LIMIT 0,25';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($slidelist_id));
		if (!$rs)
		trigger_db_error($this->dbObj);
		$getSlidelistImageDetail_arr['total_record'] = $total = $rs->PO_RecordCount();
		$getSlidelistImageDetail_arr['row'] = array();
		$photos_folder = 'files/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
		$inc = 1;
		while($row = $rs->FetchRow())
			{
				$getSlidelistImageDetail_arr['row'][$inc]['record'] = $row;
				$this->isResultsFound = true;
				$getSlidelistImageDetail_arr['row'][$inc]['photo_title'] = $row['photo_title'];
				$getSlidelistImageDetail_arr['row'][$inc]['photo_wbr_title'] = $row['photo_title'];
				$getSlidelistImageDetail_arr['row'][$inc]['photo_id'] = $row['photo_id'];
				$photo_name = getphotoName($row['photo_id']);
				$getSlidelistImageDetail_arr['row'][$inc]['img_src'] = $row['photo_server_url'] . $photos_folder .$photo_name.'S.'.$row['photo_ext'];
				$getSlidelistImageDetail_arr['row'][$inc]['photo_playlist_id'] = $row['photo_playlist_id'];
				$getSlidelistImageDetail_arr['row'][$inc]['redirectUrl'] = $this->CFG['site']['photo_url'] . '' . 'organizeSlidelist.php?delete_all=1';
				$inc++;
			}
		return $getSlidelistImageDetail_arr;
	}
	public function updateSlidelistOrderId($photo_order_ids,$slidelist_id)
	{
		$photo_id_arr = explode(',', $photo_order_ids);
		$order_id=1;
		foreach($photo_id_arr as $photo_id)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_in_playlist'].
				' SET order_id= '.$order_id.' WHERE  photo_playlist_id='.$this->dbObj->Param('photo_playlist_id').' AND photo_id='.$photo_id;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($slidelist_id));
				if (!$rs)
				trigger_db_error($this->dbObj);
				$order_id++;
			}
	}
	public function deleteSlidelistIdInPlayer($slidelist_id,$photo_id)
	{
		$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['photo_in_playlist'].' '.
				'WHERE photo_id ='.$photo_id.' AND photo_playlist_id='.$slidelist_id;
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
		trigger_db_error($this->dbObj);
		$affected_count = $this->dbObj->Affected_Rows();
		if($affected_count)
		{
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_playlist'].
					' SET total_photos=total_photos - '.$affected_count.' WHERE  photo_playlist_id='.$this->dbObj->Param('photo_playlist_id').'';
		}
		else
		{
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_playlist'].
					' SET total_photos=total_photos+1 WHERE  photo_playlist_id='.$this->dbObj->Param('photo_playlist_id').'';
		}
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($slidelist_id));
		if (!$rs)
		trigger_db_error($this->dbObj);
	}
	public function deleteSlidelistAll($slidelist_id)
	{
		$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['photo_in_playlist'].' '.
		'WHERE photo_playlist_id='.$slidelist_id;
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
		trigger_db_error($this->dbObj);
		$affected_count = $this->dbObj->Affected_Rows();
		if($affected_count)
		{
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_playlist'].
			' SET total_photos=total_photos - '.$affected_count.' WHERE  photo_playlist_id='.$this->dbObj->Param('photo_playlist_id').'';
			}
		else
		{
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_playlist'].
			' SET total_photos=total_photos+1 WHERE  photo_playlist_id='.$this->dbObj->Param('photo_playlist_id').'';
		}
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($slidelist_id));
		if (!$rs)
		trigger_db_error($this->dbObj);

	}


}
$organizeSlidelist = new organizeSlidelist();
$organizeSlidelist->setPageBlockNames(array('list_slidelist_block','deleted_msg','block_slidelist_photos','block_msg_form_reorder_success'));
$organizeSlidelist->setFormField('photo_id', '');
$organizeSlidelist->setFormField('photo_slidelist_id', '');
$organizeSlidelist->setFormField('order_id', '');
$organizeSlidelist->setFormField('delete_photo_slidelist_id', '');
$organizeSlidelist->setFormField('delete_all', '');
$organizeSlidelist->setFormField('playlist_clear_all', '');
$organizeSlidelist->setFormField('photo_order_ids', '');
$organizeSlidelist->setFormField('ajax_page', '');
$organizeSlidelist->sanitizeFormInputs($_REQUEST);
$organizeSlidelist->setPageBlockShow('block_slidelist_photos');
if($organizeSlidelist->getFormField('ajax_page'))
{
	//since nothing is returned, commented this out to fix the error no element found
	$organizeSlidelist->includeAjaxHeader();
	if ($organizeSlidelist->isFormPOSTed($_POST, 'photo_id'))
		    {
		    	ob_start();
				$organizeSlidelist->deleteSlidelistIdInPlayer($organizeSlidelist->getFormField('photo_slidelist_id'),$organizeSlidelist->getFormField('photo_id'));
				die();
		    }
	//$organizeSlidelist->includeAjaxFooter();
}
else
{
	if($organizeSlidelist->getFormField('photo_order_ids')!= '')
	{
		$organizeSlidelist->updateSlidelistOrderId($organizeSlidelist->getFormField('photo_order_ids'),$organizeSlidelist->getFormField('photo_slidelist_id'));
		//$organizeSlidelist->setCommonSuccessMsg($LANG['common_msg_reorder_playlist']);
		$organizeSlidelist->setPageBlockShow('block_msg_form_reorder_success');
	}
	if($organizeSlidelist->getFormField('photo_slidelist_id')!= '')
	{
	   $organizeSlidelist->list_slidelist_block['getOrganizeSlidelistList'] = $organizeSlidelist->getOrganizeSlidelistList($organizeSlidelist->getFormField('photo_slidelist_id'));
	}
	if($organizeSlidelist->getFormField('delete_all')!= '')
	{
		$organizeSlidelist->deleteSlidelistAll($organizeSlidelist->getFormField('delete_all'));
		$organizeSlidelist->setAllPageBlocksHide();
		$organizeSlidelist->setPageBlockHide('block_playlist_player');
		$organizeSlidelist->setCommonSuccessMsg($LANG['common_msg_playlist_remove_all']);
		$organizeSlidelist->setPageBlockShow('block_msg_form_success');
	}
	$organizeSlidelist->savePlaylistUrl = $CFG['site']['photo_url'].'createPlaylist.php?action=save_playlist&light_window=1';
}
$organizeSlidelist->includeHeader();
?>
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['photo_url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/root/css/<?php echo $CFG['html']['stylesheet']['screen']['default'];?>/Photoalbum.css">
<script type="text/javascript">
var photo_slidelist_id='<?php echo $organizeSlidelist->getFormField('photo_slidelist_id');?>';
//<![CDATA[
var serverVars = {
	adminMode: true
};
//]]>
</script>
<script type="text/javascript" src="<?php echo $CFG['site']['photo_url'];?>js/photoalbum.js"></script>
<script type="text/javascript" language="javascript">
var block_arr = new Array('selOrganizeSlideMsgConfirm');
var photo_site_url = '<?php echo $CFG['site']['photo_url'];?>';
var cfg_site_name = '<?php echo $CFG['site']['name'];?>';
var savePlaylistUrl='<?php echo $CFG['site']['photo_url'];?>createPlaylist.php?action=save_playlist&light_window=1';
var common_playlist='<?php echo $LANG['common_create_playlist']; ?>';
</script>
<script type="text/javascript">
var reorder_section_count = 1;

//var modules=Array();
function saveDragDropNodes(slidelist_id)
{
	var items=$Jq(".photolistitem");
	var photo_reorder_ids_arr=[];
	for(var x=0;x<items.length;x++)
	{
		photo_reorder_ids_arr.push(items[x].id);
	}
	var reorder_photo_ids='';
	reorder_photo_ids=photo_reorder_ids_arr;
	$Jq('#photo_order_ids').val(reorder_photo_ids);
	document.dragDropContainer_frm.submit();
}
</script>
<?php
setTemplateFolder('general/', 'photo');
$smartyObj->display('organizeSlidelist.tpl');
?>
<script type="text/javascript">
   function closeDownload()
	{
		$Jq('#downloadFormat').css('display', 'none');
		hideAllBlocks();
	}
$Jq('#manageslide_scrollbar_content').jScrollPane({showArrows:true,scrollbarWidth:10, scrollbarMargin:10});
</script>
<?php
$organizeSlidelist->includeFooter();
?>