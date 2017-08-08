<?php
/**
* organizePlaylist Organize playlist list
*
* @category	Rayzz
* @package		General
* @author 		shankar_044at09
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
* @license		http://www.mediabox.uz Uzdc Infoway Licence
*/
class organizePlaylist extends MusicHandler
{
	public function getOrganizePlaylistList($playlist_id)
	{
		global $smartyObj;
		$getPlaylistImageDetail_arr = array();
		$condition='';
		$this->isResultsFound = false;
		$sql = 'SELECT mip.music_id, m.music_server_url, m.music_title, mfs.file_name,mip.order_id,mip.playlist_id, '.
		' m.small_width, m.small_height, m.thumb_width, m.thumb_height FROM '.
		$this->CFG['db']['tbl']['music_in_playlist'].' AS mip JOIN '.
		$this->CFG['db']['tbl']['music'].' AS m ON m.music_id=mip.music_id  JOIN '.
		$this->CFG['db']['tbl']['music_files_settings'].' AS mfs '.
		'ON mfs.music_file_id = m.thumb_name_id, '.$this->CFG['db']['tbl']['users'].
		' AS u WHERE mip.playlist_id ='.$this->dbObj->Param('playlist_id').' '.
		' AND m.user_id=u.user_id AND u.usr_status = \'Ok\' AND m.music_status = \'Ok\' ';
		if($condition)
		$sql .= ' AND (m.user_id = '.$this->CFG['user']['user_id'].
		' OR m.music_access_type = \'Public\''.
		$this->getAdditionalQuery().') '.$this->getAdultQuery('m.', 'music');
		$sql .= ' ORDER BY mip.order_id ASC LIMIT 0,25';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($playlist_id));
		if (!$rs)
		trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		$getPlaylistImageDetail_arr['total_record'] = $total = $rs->PO_RecordCount();
		$getPlaylistImageDetail_arr['row'] = array();
		$inc = 1;
		while($row = $rs->FetchRow())
			{
				$getPlaylistImageDetail_arr['row'][$inc]['record'] = $row;
				$this->isResultsFound = true;
				$getPlaylistImageDetail_arr['row'][$inc]['music_title'] = $row['music_title'];
				$getPlaylistImageDetail_arr['row'][$inc]['music_id'] = $row['music_id'];
				$getPlaylistImageDetail_arr['row'][$inc]['playlist_id'] = $row['playlist_id'];
				$getPlaylistImageDetail_arr['row'][$inc]['listenMusicUrl'] = $this->CFG['site']['music_url'] . 'listenMusic.php?music_id=' . $row['music_id'] . '&title=';
				$getPlaylistImageDetail_arr['row'][$inc]['redirectUrl'] = $this->CFG['site']['music_url'] . 'organizePlaylist.php?delete_all=1';
				$inc++;
			}
		$smartyObj->assign('getPlaylistImageDetail', $getPlaylistImageDetail_arr);
		return $getPlaylistImageDetail_arr;
	}
	public function updatePlaylistOrderId($order_id,$playlist_id)
	{
		$music_id_order = explode(',', $order_id);
		foreach($music_id_order as $key=>$value)
			{
			   list($music_id,$order_id)=explode('_',$value);
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_in_playlist'].
				' SET order_id= '.$order_id.' WHERE  playlist_id='.$this->dbObj->Param('playlist_id').' AND music_id='.$music_id;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($playlist_id));
				if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}
	}
	public function deletePlaylistIdInPlayer($playlist_id,$music_id)
	{
		$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_in_playlist'].' '.
		'WHERE music_id ='.$music_id.' AND playlist_id='.$playlist_id;
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
		trigger_db_error($this->dbObj);
		$affected_count = $this->dbObj->Affected_Rows();
		if($affected_count)
		{
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist'].
			' SET total_tracks=total_tracks - '.$affected_count.' WHERE  playlist_id='.$this->dbObj->Param('playlist_id').'';
		}
		else
		{
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist'].
			' SET total_tracks=total_tracks+1 WHERE  playlist_id='.$this->dbObj->Param('playlist_id').'';
		}
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($playlist_id));
		if (!$rs)
		trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
	}
	public function deletePlaylistAll($playlist_id)
	{
		$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_in_playlist'].' '.
		'WHERE playlist_id='.$playlist_id;
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
		trigger_db_error($this->dbObj);
		$affected_count = $this->dbObj->Affected_Rows();
		if($affected_count)
		{
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist'].
			' SET total_tracks=total_tracks - '.$affected_count.' WHERE  playlist_id='.$this->dbObj->Param('playlist_id').'';
			}
		else
		{
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist'].
			' SET total_tracks=total_tracks+1 WHERE  playlist_id='.$this->dbObj->Param('playlist_id').'';
		}
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($playlist_id));
		if (!$rs)
		trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
	}

	/**
	 * organizePlaylist::checkSameUserInLogin()
	 *
	 * @param srting $err_msg
	 * @param string $delete_songs_option
	 *
	 * @return boolean
	 */
	public function checkSameUserInLogin($err_msg, $delete_songs_option = 'playlist')
	{

		if($delete_songs_option == 'single')
		{
			$playlist_id = $this->fields_arr['delete_playlist_id'];
		}
		else if($delete_songs_option == 'all')
		{
			$playlist_id = $this->fields_arr['delete_all'];
		}
		else
		{
			$playlist_id = $this->fields_arr['playlist_id'];
		}

		$sql = 'SELECT playlist_id FROM '.$this->CFG['db']['tbl']['music_playlist'].
				' WHERE playlist_id = '.$this->dbObj->Param('playlist_id').
				' AND user_id = '.$this->dbObj->Param('comment_user_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($playlist_id, $this->CFG['user']['user_id']));
		if (!$rs)
			trigger_db_error($this->dbObj);

		$row = $rs->FetchRow();

		if($row['playlist_id'] != '')
		{
			return true;
		}
		else
		{
			echo $err_msg;
			echo 'ERR~';
			exit;
		}
	}


}
$organizePlaylist = new organizePlaylist();
$organizePlaylist->setPageBlockNames(array('list_playlist_block','deleted_msg','block_playlist_player'));
$organizePlaylist->setFormField('music_id', '');
$organizePlaylist->setFormField('playlist_id', '');
$organizePlaylist->setFormField('order_id', '');
$organizePlaylist->setFormField('delete_playlist_id', '');
$organizePlaylist->setFormField('delete_all', '');
$organizePlaylist->setFormField('playlist_clear_all', '');
$organizePlaylist->setFormField('left', '');
$organizePlaylist->setFormField('right', '');
$organizePlaylist->sanitizeFormInputs($_REQUEST);
$organizePlaylist->setPageBlockShow('block_playlist_player');
$organizePlaylist->isResultsFound = false;
if($organizePlaylist->getFormField('playlist_id')!= '')
{
   $organizePlaylist->list_playlist_block['getOrganizePlaylistList'] = $organizePlaylist->getOrganizePlaylistList($organizePlaylist->getFormField('playlist_id'));
}
if($organizePlaylist->getFormField('order_id')!= '')
{
	$organizePlaylist->memberLoginUrl = $CFG['site']['music_url'] . 'organizePlaylist.php?playlist_id=' . $organizePlaylist->getFormField('playlist_id') . '&mem_auth=true';
	$organizePlaylist->checkLoginStatusInAjax($organizePlaylist->memberLoginUrl);
	$organizePlaylist->checkSameUserInLogin($LANG['common_login_other_user_playlist_reorder_err_msg']);
	$organizePlaylist->updatePlaylistOrderId($organizePlaylist->getFormField('order_id'),$organizePlaylist->getFormField('playlist_id'));
	echo $LANG['common_msg_music_reorder_playlist'];
	exit;
}
if($organizePlaylist->getFormField('delete_playlist_id')!= '')
{
	$organizePlaylist->memberLoginUrl = $CFG['site']['music_url'] . 'organizePlaylist.php?playlist_id=' . $organizePlaylist->getFormField('delete_playlist_id') . '&mem_auth=true';
	$organizePlaylist->setCommonSuccessMsg($LANG['common_msg_music_playlist_remove_all']);
	$organizePlaylist->setPageBlockShow('block_playlist_player');
	$organizePlaylist->setPageBlockShow('block_msg_form_success');
	$organizePlaylist->checkLoginStatusInAjax($organizePlaylist->memberLoginUrl);
	$organizePlaylist->checkSameUserInLogin($LANG['common_login_other_user_playlist_song_delete_err_msg'], 'single');
	$organizePlaylist->deletePlaylistIdInPlayer($organizePlaylist->getFormField('delete_playlist_id'),$organizePlaylist->getFormField('music_id'));
	echo $LANG['common_msg_music_playlist_remove_all'];
	exit;
}
if($organizePlaylist->getFormField('delete_all')!= '')
{
	$organizePlaylist->memberLoginUrl = $CFG['site']['music_url'] . 'organizePlaylist.php?playlist_id=' . $organizePlaylist->getFormField('delete_all') . '&mem_auth=true';
	$organizePlaylist->checkLoginStatusInAjax($organizePlaylist->memberLoginUrl);
	$organizePlaylist->checkSameUserInLogin($LANG['common_login_other_user_playlist_song_delete_err_msg'], 'all');
	$organizePlaylist->deletePlaylistAll($organizePlaylist->getFormField('delete_all'));
	$organizePlaylist->setAllPageBlocksHide();
	$organizePlaylist->setPageBlockHide('block_playlist_player');
	$organizePlaylist->setCommonSuccessMsg($LANG['common_msg_playlist_remove_all']);
	$organizePlaylist->setPageBlockShow('block_msg_form_success');
}
$organizePlaylist->savePlaylistUrl = $CFG['site']['music_url'].'createPlaylist.php?action=save_playlist&light_window=1';
$organizePlaylist->includeHeader();
?>
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/admin/css/reOrder.css">
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/admin/css/fonts-min.css">
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/yahoo-dom-event.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/animation-min.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/dragdrop-min.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/organizeList.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/JSFCommunicator.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
<script type="text/javascript" language="javascript">
var site_url = '<?php echo $CFG['site']['music_url'];?>';
var savePlaylistUrl='<?php echo $CFG['site']['music_url'].'createPlaylist.php?action=save_playlist&light_window=1'; ?>';
var common_playlist='<?php echo $LANG['common_create_playlist']; ?>';
var organize_playlist_ajax_page_loading = '<img alt="<?php echo $LANG['common_music_loading']; ?>" src="<?php echo $CFG['site']['url'].'music/design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/loading-viewmusic.gif' ?>" \/>';
</script>
<script type="text/javascript">
var reorder_section_count = 1;
//var modules=Array();
</script>
<style type="text/css">
.draggable
{
	border: 2px solid #0090DF;
    background-color: #68BFEF;
    width: 640px;
    height: 360px;
    margin: 10px;
}
ul.draglist_alt {
    position: relative;
    width: 200px;
    list-style: none;
    margin:0;
    padding:0;
    /*
       The bottom padding provides the cushion that makes the empty
       list targetable.  Alternatively, we could leave the padding
       off by default, adding it when we detect that the list is empty.
    */
    padding-bottom:20px;
}

ul.draglist_alt li {
    margin: 1px;
    cursor: move;
}
</style>

<?php
setTemplateFolder('general/', 'music');
$smartyObj->display('organizePlaylist.tpl');
$organizePlaylist->includeFooter();
?>