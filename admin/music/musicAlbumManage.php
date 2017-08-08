<?php
/**
 * This file is to manage the music albums
 *
 * This file is having musicAlbumManage class to manage the music albums
 *
 *
 * @category	Rayzz
 * @package		Admin
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 *
 **/
require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/admin/musicAlbumManage.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/months_list_array.inc.php';
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
class musicAlbumManage extends MediaHandler
{
	public $sql_condition = '';
	public $sql_sort = '';
	public $fields_arr = '';
	public $sql='';
	/**
	 * musicAlbumManage::buildSortQuery()
	 *
	 * @return void
	 **/
	public function buildSortQuery()
	{
		$this->sql_sort = 'ma.music_album_id DESC';
	}

	/**
	 * musicAlbumManage::displayAlbumList()
	 * This method helps to display the list of music albums
	 *
	 * @return void
	 **/
	public function displayAlbumList()
	{
		global $smartyObj;
		$displayalbumList_arr = array();
		$displayalbumList_arr['row'] = array();
		$inc = 1;
		while($row = $this->fetchResultRecord())
		{
			if(!isset($row['user_name']))
			{
				$displayalbumList_arr['row'][$inc]['name'] = $this->getUserDetail('user_id', $row['user_id'], 'user_name');
			}
			else
			{
				$name = $this->CFG['format']['name'];
				$name = str_replace('$first_name', $row['first_name'],$name);
				$name = str_replace('$last_name', $row['last_name'],$name);
				$name = str_replace('$user_name', $row['user_name'],$name);
				$displayalbumList_arr['row'][$inc]['name'] = $name;
			}
			$row['music_featured'] = $row['album_featured']?$row['album_featured']:'No';
			$row['total_music'] = $this->getmusicCount($row['music_album_id']);
			$displayalbumList_arr['row'][$inc]['record'] = $row;
			$inc++;
		}
		$smartyObj->assign('displayalbumList_arr', $displayalbumList_arr);
	}

	/**
	 * musicAlbumManage::getmusicCount()
	 * This method is used for get music count of selected album
	 *
	 * @param int $album_id
	 *
	 * @return int music_count
	 **/
	public function getmusicCount($album_id)
	{
		$sql = 'SELECT count(g.music_id) as music_count '.
				'FROM '.$this->CFG['db']['tbl']['music'].' as g '.
				'WHERE music_album_id = '.$this->dbObj->Param('album_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($album_id));
		if (!$rs)
			trigger_db_error($this->dbObj);
		$row = $rs->FetchRow();
		return $row['music_count'];
	}

	/**
	 * musicAlbumManage::updateFeatureAlbumStatus()
	 * This method is used for update featured album status
	 *
	 * @return void
	 **/
	public function updateFeatureAlbumStatus($sel_album_status)
	{
		$album_details = explode(',', $this->fields_arr['checkbox']);
		foreach($album_details as $album_key=>$album_value)
		{
			$album_arr = explode('-',$album_value);
			$flag[] = $album_arr[0];
		}
		foreach($flag as $key=>$val)
		{
			$sql = ' UPDATE '.$this->CFG['db']['tbl']['music_album'].'
						SET album_featured='.$this->dbObj->Param('album_status').'
						WHERE music_album_id='.$val;
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($sel_album_status));
			if (!$rs)
				trigger_db_error($this->dbObj);

		}
	}
}
//<<<<<-------------- Class obj begins ---------------//
//-------------------- Code begins -------------->>>>>//
$musicAlbumManage = new musicAlbumManage();
$musicAlbumManage->setPageBlockNames(array('list_music_album_form', 'block_msg_form_success'));
$musicAlbumManage->setFormField('confirmdel', '');
$musicAlbumManage->setFormField('action', '');
$musicAlbumManage->setFormField('checkbox', array());
$musicAlbumManage->setTableNames(array($musicAlbumManage->CFG['db']['tbl']['music_album'].' as ma LEFT JOIN '.$musicAlbumManage->CFG['db']['tbl']['users'].' as u ON ma.user_id=u.user_id AND u.usr_status=\'Ok\''));
$musicAlbumManage->setReturnColumns(array('ma.music_album_id', 'ma.user_id', 'ma.album_title', 'u.user_name', 'u.first_name', 'u.last_name', 'ma.album_featured', 'ma.album_price', 'ma.album_access_type'));
$musicAlbumManage->sql_condition = '';
$musicAlbumManage->sql_sort = 'ma.music_album_id DESC';
$musicAlbumManage->sanitizeFormInputs($_REQUEST);
$musicAlbumManage->setPageBlockShow('list_music_album_form');
$musicAlbumManage->hidden_arr = array('start');
if($musicAlbumManage->isFormGETed($_POST,'confirmdel'))
{
	if($musicAlbumManage->getFormField('action')=='Featured' )
	{
		$musicAlbumManage->updateFeatureAlbumStatus('Yes');
		$musicAlbumManage->setCommonSuccessMsg($LANG['musicAlbumManage_msg_success']);
		$musicAlbumManage->setPageBlockShow('block_msg_form_success');
	}
	if($musicAlbumManage->getFormField('action')=='UnFeatured')
	{
		$musicAlbumManage->updateFeatureAlbumStatus('No');
		$musicAlbumManage->setCommonSuccessMsg($LANG['musicAlbumManage_msg_success']);
		$musicAlbumManage->setPageBlockShow('block_msg_form_success');
	}
}
if ($musicAlbumManage->isShowPageBlock('list_music_album_form'))
{
	/****** navigtion continue*********/
	$musicAlbumManage->buildSelectQuery();
	$musicAlbumManage->buildQuery();
	$musicAlbumManage->buildSortQuery();
	//$musicAlbumManage->printQuery();
	if($musicAlbumManage->isGroupByQuery())
		$musicAlbumManage->homeExecuteQuery();
	else
		$musicAlbumManage->executeQuery();
	//$musicAlbumManage->printQuery();
	/******* Navigation End ********/
	if($musicAlbumManage->isResultsFound())
	{
		$musicAlbumManage->displayAlbumList();
		$smartyObj->assign('smarty_paging_list', $musicAlbumManage->populatePageLinksPOST($musicAlbumManage->getFormField('start'), 'music_album_form'));
		$musicAlbumManage->list_music_form['hidden_arr'] = array('start');
	}
}
$musicAlbumManage->left_navigation_div = 'musicMain';
//include the header file
$musicAlbumManage->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'music');
$smartyObj->display('musicAlbumManage.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script language="javascript" type="text/javascript" >
	var block_arr= new Array('selMsgConfirm');
	var replace_url = '<?php echo $CFG['site']['url'];?>login.php';
	var please_select_action = '<?php echo $LANG['musicAlbumManage_err_tip_select_action'];?>';
	var confirm_message = '';
	function getAction()
		{
			var act_value = document.music_album_form.album_options.value;
			if(act_value)
				{
					switch (act_value)
						{
							case 'Delete':
								confirm_message = '<?php echo $LANG['musicAlbumManage_delete'];?>';
								break;
							case 'Flag':
								confirm_message = '<?php echo $LANG['musicAlbumManage_status'];?>';
								break;
							case 'UnFlag':
								confirm_message = '<?php echo $LANG['musicAlbumManage_status'];?>';
								break;
							case 'Featured':
								confirm_message = '<?php echo $LANG['musicAlbumManage_featured'];?>';
								break;
							case 'UnFeatured':
								confirm_message = '<?php echo $LANG['musicAlbumManage_unfeatured'];?>';
								break;
						}
					$Jq('#confirmMessage').html(confirm_message);
					document.msgConfirmform.action.value = act_value;
					Confirmation('selMsgConfirm', 'msgConfirmform', Array('checkbox'), Array(multiCheckValue), Array('value'), -25, -290);
				}
			else
				alert_manual(please_select_action);
		}
	function popupWindow(url)
		{
			 window.open (url, "","status=0,toolbar=0,resizable=1,scrollbars=1");
			 return false;
		}
</script>
<?php
//<<<<<-------------------- Page block templates ends -------------------//
$musicAlbumManage->includeFooter();
?>