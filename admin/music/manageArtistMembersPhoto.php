<?php
/**
 * This file is use for manage announcement
 *
 * This file is having ManageAnnouncement class manage announcement
 *
 *
 * @category	Rayzz
 * @package		Admin
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 **/
require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/admin/manageArtistPhoto.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/help.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['site']['is_module_page']='music';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require($CFG['site']['project_path'].'common/application_top.inc.php');

//--------------class viewArtist--------------->>>//
/**
 * This class is used to manage music playlist
 *
 * @category	Rayzz
 * @package		manage music playlist
 */
class viewArtist extends MusicHandler
{
	/**
	 * manageBackground::chkFileNameIsNotEmpty()
	 *
	 * @param mixed $field_name
	 * @param string $err_tip
	 * @return
	 */
	public function chkFileNameIsNotEmpty($field_name, $err_tip = '')
	{
		if(!$_FILES[$field_name]['name'])
		{
			$this->setFormFieldErrorTip($field_name,$err_tip);
			return false;
		}
		return true;
	}

	/**
	 * viewArtist::chkValidFileType()
	 *
	 * @param $field_name
	 * @param string $err_tip
	 * @return
	 **/
	public function chkValidFileType($field_name, $err_tip = '')
	{
		$extern = strtolower(substr($_FILES[$field_name]['name'], strrpos($_FILES[$field_name]['name'], '.')+1));
		if (!in_array($extern, $this->CFG['admin']['musics']['artist_allowed_image_type']))
		{
			$this->fields_err_tip_arr[$field_name] = $err_tip;
			return false;
		}
		return true;
	}

	/**
	 * viewArtist::chkValideFileSize()
	 *
	 * @param $field_name
	 * @param string $err_tip
	 * @return
	 **/
	public function chkValideFileSize($field_name, $err_tip='')
	{
		$max_size = $this->CFG['admin']['musics']['artist_image_size'] * 1024;
		if ($_FILES[$field_name]['size'] > $max_size)
		{

			$this->fields_err_tip_arr[$field_name] = $err_tip;
			return false;
		}
		return true;
	}

	/**
	 * viewArtist::chkErrorInFile()
	 *
	 * @param $field_name
	 * @param string $err_tip
	 * @return
	 **/
	public function chkErrorInFile($field_name, $err_tip='')
	{
		if($_FILES[$field_name]['error'])
		{
			$this->fields_err_tip_arr[$field_name] = $err_tip;
			return false;
		}
		return true;
	}

	/**
	 * viewArtist::uploadArtistPhotoFile()
	 *
	 * @return
	 */
	public function uploadArtistPhotoFile()
	{
		$htmlstring = trim(urldecode($this->getFormField('image_caption')));
		$htmlstring = strip_tags(html_entity_decode($htmlstring), '<br><br />');
		$this->setFormField('image_caption', $htmlstring);

		//insert music_artist_member_image table//
		$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_artist_member_image'].
				' SET music_artist_member_id = '.$this->dbObj->Param('music_artist_member_id').
				' , user_id = '.$this->dbObj->Param('user_id').
				' , image_caption = '.$this->dbObj->Param('image_caption').
				' , image_ext = '.$this->dbObj->Param('image_ext').
				' , status = '.$this->dbObj->Param('status').
				' , date_added = NOW()';

		//Get image extension//
		$file_ext = strtolower(substr($_FILES['artist_photo']['name'], strrpos($_FILES['artist_photo']['name'], '.')+1));
		$value_array = array($this->fields_arr['artist_id'], $this->CFG['user']['user_id'], $this->fields_arr['image_caption'], $file_ext, 'Yes');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, $value_array);
		if (!$rs)
			trigger_db_error($this->dbObj);

		//Get image name//
		$insert_id = $this->dbObj->Insert_ID();
		//Artist music list path [../../files/musics/artist_images/]//
		$artist_image_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['music_folder'].'/'.$this->CFG['admin']['musics']['artist_image_members_folder'].'/';
		$this->chkAndCreateFolder($artist_image_dir);
		$extern = strtolower(substr($_FILES['artist_photo']['name'], strrpos($_FILES['artist_photo']['name'], '.')+1));
		$imageObj = new ImageHandler($_FILES['artist_photo']['tmp_name']);
		$this->setIHObject($imageObj);
		$upload_path = $artist_image_dir.$insert_id;
		//Resize the image..
		$this->storeArtistImagesTempServer($upload_path, $file_ext);
		//Update artist image detail..
		$this->updateArtistImageDetail($insert_id);
	}

	 /**
	  * viewArtist::setIHObject()
	  *
	  * @param mixed $imObj
	  * @return
	  */
	 public function setIHObject($imObj)
	{
		$this->imageObj = $imObj;
	}

	/**
	 * viewArtist::clearHistory()
	 *
	 * @return
	 */
	public function clearHistory()
	{
		$this->fields_arr['artist_photo'] = '';
		$this->fields_arr['image_caption'] = '';
	}

	/**
	 * viewArtist::setTableAndColumns()
	 *
	 * @return
	 */
	public function setTableAndColumns()
	{
		$this->setTableNames(array($this->CFG['db']['tbl']['music_artist_member_image'] . ' AS mai JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON u.user_id = mai.music_artist_member_id'));
		$this->setReturnColumns(array('mai.music_artist_member_image', 'mai.music_artist_member_id', 'mai.user_id', 'mai.image_caption', 'mai.image_ext', 'mai.main_img', 'mai.status'));
		$this->sql_condition = 'u.usr_status <> \'Deleted\' AND mai.status<>\'Deleted\' AND music_artist_member_id='.$this->fields_arr['artist_id'];
		$this->sql_sort = 'mai.music_artist_member_image DESC';
	}
	/**
	 * viewArtist::showArtistImageList()
	 *
	 * @return
	 */
	public function showArtistImageList()
	{
		//Image path //
		$artist_image_path = $this->CFG['site']['url'].$this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['music_folder'].'/'.$this->CFG['admin']['musics']['artist_image_members_folder'].'/';
		$showArtistImageList_arr = array();
		$inc = 0;
		while($row = $this->fetchResultRecord())
			{
				$showArtistImageList_arr[$inc]['title_image_caption'] = $row['image_caption'];
				$row['image_caption'] = wordWrap_mb_ManualWithSpace($row['image_caption'], $this->CFG['admin']['musics']['member_artist_caption_length'], $this->CFG['admin']['musics']['member_artist_caption_total_length']);
				$showArtistImageList_arr[$inc]['record'] = $row;
				$showArtistImageList_arr[$inc]['artist_image'] = '';
				$showArtistImageList_arr[$inc]['disp_image'] = '';
				$showArtistImageList_arr[$inc]['artist_image_detail'] = $this->getArtistImageMemberDetail($row['music_artist_member_id']);
				if(!empty($showArtistImageList_arr[$inc]['artist_image_detail']))
					{
						$showArtistImageList_arr[$inc]['artist_image'] = $artist_image_path.$row['music_artist_member_image'].$this->CFG['admin']['musics']['artist_thumb_name'].'.'.$row['image_ext'];
						$showArtistImageList_arr[$inc]['disp_image'] = DISP_IMAGE($this->CFG['admin']['musics']['artist_thumb_width'], $this->CFG['admin']['musics']['artist_thumb_height'], $showArtistImageList_arr[$inc]['artist_image_detail']['thumb_width'], $showArtistImageList_arr[$inc]['artist_image_detail']['thumb_height']);
					}
				$inc++;
			}
		return $showArtistImageList_arr;
	}

	/**
	 * viewArtist::setMainArtistImage()
	 *
	 * @return
	 */
	public function setMainArtistImage()
	{
		//REMOVE ALL//
		$this->removeMainArtistImage();

		$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_artist_member_image'].
				' SET status = \'Yes\', main_img = '.$this->dbObj->Param('main_img').
				' WHERE music_artist_member_image = '.$this->dbObj->Param('music_artist_member_image').' AND music_artist_member_id = '.$this->dbObj->Param('artist_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array('1', $this->fields_arr['music_artist_member_image'], $this->fields_arr['artist_id']));
		if (!$rs)
			trigger_db_error($this->dbObj);

		return true;
	}

	/**
	 * viewArtist::removeMainArtistImage()
	 *
	 * @param
	 * @return
	 */
	public function removeMainArtistImage()
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_artist_member_image'].
				' SET main_img = '.$this->dbObj->Param('main_img').' WHERE music_artist_member_id = '.$this->dbObj->Param('artist_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array('0', $this->fields_arr['artist_id']));
		if (!$rs)
			trigger_db_error($this->dbObj);

		return true;
	}

	/**
	 * viewArtist::changeStatus()
	 *
	 * @param mixed $status
	 * @param mixed $condition
	 * @return
	 */
	public function changeStatus($status)
	{
		$music_artist_member_image = $this->fields_arr['music_artist_member_image'];
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_artist_member_image'].
				' SET status = '.$this->dbObj->Param('status').' '.
				'WHERE music_artist_member_image IN ('.$music_artist_member_image.')' ;


		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($status));
		if (!$rs)
			trigger_db_error($this->dbObj);

		return true;
	}

	/**
	 * viewArtist::showArtistlists()
	 *
	 * @return
	 */
	public function showArtistlists()
	{
		$showArtistlists_arr = array();
		$artist_image_path = $this->CFG['site']['url'].$this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['music_folder'].'/'.$this->CFG['admin']['musics']['artist_image_members_folder'].'/';
		$inc=0;
		$showArtistlists_arr['row'] = array();
		while($row = $this->fetchResultRecord())
		{
			//$row['artist_title'] = wordWrap_mb_Manual($row['artist_title'],$this->CFG['admin']['musics']['member_artistlist_title_length']);
			$showArtistlists_arr['row'][$inc]['record'] = $row;
			//Artistlist Image...
			$showArtistlists_arr['row'][$inc]['artist_path'] = '';
			$showArtistlists_arr['row'][$inc]['disp_image'] = '';
			$showArtistlists_arr['row'][$inc]['artist_image_detail'] = $this->getArtistImageDetail($row['user_id'], 'Yes');
			$showArtistlists_arr['row'][$inc]['profileIcon'] = getMemberAvatarDetails($row['icon_id'], $row['icon_type'],$row['user_id'],$row['image_ext'], $row['sex']);
			if(!empty($showArtistlists_arr['row'][$inc]['artist_image_detail']))
			{
				$music_artist_member_image = $showArtistlists_arr['row'][$inc]['artist_image_detail']['music_artist_member_image'];
				$showArtistlists_arr['row'][$inc]['artist_path'] = $artist_image_path.$music_artist_member_image.$this->CFG['admin']['musics']['artist_thumb_name'].'.'.$showArtistlists_arr['row'][$inc]['artist_image_detail']['image_ext'];
				$showArtistlists_arr['row'][$inc]['disp_image'] = DISP_IMAGE($this->CFG['admin']['musics']['artist_thumb_width'], $this->CFG['admin']['musics']['artist_thumb_height'], $showArtistlists_arr['row'][$inc]['artist_image_detail']['thumb_width'], $showArtistlists_arr['row'][$inc]['artist_image_detail']['thumb_height']);
			}
			$inc++;
		}
		return $showArtistlists_arr;
	}

	/**
	 * set the condition
	 *
	 * @access public
	 * @return void
	 **/
	public function buildConditionQuery($condition='')
	{
		$this->sql_condition = $condition;
	}


	/**
	 * To sort the query
	 *
	 * @access public
	 * @return void
	 **/
	public function checkSortQuery($field, $sort='asc')
	{
		if(!($this->sql_sort))
		{
			$this->sql_sort = $field . ' ' . $sort;
		}
	}

	/**
	 * viewArtist::getArtistPhotoStatusCount()
	 *
	 * @param mixed $status
	 * @return
	 */
	public function getArtistPhotoStatusCount($artist_id,$status)
	{
		$sql = 'SELECT count(music_artist_member_image) as total FROM '.$this->CFG['db']['tbl']['music_artist_member_image'].
				' WHERE status = '.$this->dbObj->Param('status').' AND music_artist_member_id = '.$this->dbObj->Param('music_artist_member_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($status, $artist_id));
		if (!$rs)
			trigger_db_error($this->dbObj);

		$record = $rs->FetchRow();
		return $record['total'];
	}
}
//<<<<<-------------- Class musicArtistPhotoUpload end ---------------//
//-------------------- Code begins -------------->>>>>//
$viewArtist = new viewArtist();
if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$viewArtist->setPageBlockNames(array('list_artistlist_block', 'upload_photo_block', 'list_photo_block'));
$viewArtist->setAllPageBlocksHide();
$viewArtist->setFormField('start', 0);
$viewArtist->setFormField('numpg', $CFG['data_tbl']['numpg']);
$viewArtist->setPageBlockShow('list_photo_block');
$viewArtist->setFormField('artist_id', '');
$viewArtist->setFormField('artist_photo', '');
$viewArtist->setFormField('image_caption', '');
$viewArtist->setFormField('music_artist_member_image', '');
$viewArtist->setFormField('action', '');
$viewArtist->setFormField('search', '');
$viewArtist->setFormField('name', '');
$viewArtist->setFormField('tags', '');
$viewArtist->setMediaPath('../../');
$viewArtist->sanitizeFormInputs($_REQUEST);
$viewArtist->flag = 0;
$condition = ' music_user_type=\'Artist\' ';
/*echo '<pre>';
print_r($_REQUEST);
echo '</pre>';*/
$viewArtist->page_title = '';
if($viewArtist->getFormField('artist_id'))
{
	$viewArtist->setPageBlockHide('list_artistlist_block');
	if($viewArtist->isValidArtistMemberID())
	{
		$viewArtist->setPageBlockShow('upload_photo_block');
		$viewArtist->page_title = str_replace('artist_name', $viewArtist->artist_name, $LANG['manageartistphoto_title'] );
		$viewArtist->photosize_detail = str_replace('{file_size}', $CFG['admin']['musics']['artist_image_size'],$LANG['managelyrics_filedsize_label']);
	}
	else
	{
		$viewArtist->setAllPageBlocksHide();
		$viewArtist->setCommonErrorMsg($LANG['manageartistphoto_invalide_id']);
		$viewArtist->setPageBlockShow('block_msg_form_error');
	}
}
else
{
	$viewArtist->setPageBlockShow('list_artistlist_block');
}
if ($viewArtist->isFormPOSTed($_POST, 'upload'))
{
	$viewArtist->flag = 1;
	$addtional_msg = str_replace('file_size', $CFG['admin']['musics']['artist_image_size'],$LANG['manageartistphoto_err_tip_file_size']);
	$viewArtist->chkFileNameIsNotEmpty('artist_photo', $LANG['common_err_tip_compulsory']) and
	$viewArtist->chkValidFileType('artist_photo', $LANG['manageartistphoto_err_tip_invalid_file_type']) and
	$viewArtist->chkValideFileSize('artist_photo', $LANG['manageartistphoto_err_tip_invalid_file_size'].' '.$addtional_msg) and
	$viewArtist->chkErrorInFile('artist_photo', $LANG['manageartistphoto_err_tip_invalid_file']);
	if($viewArtist->isValidFormInputs())
	{
		$viewArtist->uploadArtistPhotoFile();
		$viewArtist->clearHistory();
		$viewArtist->flag = 0;
		$viewArtist->setCommonSuccessMsg($LANG['manageartistphoto_successfull_upload']);
		$viewArtist->setPageBlockShow('block_msg_form_success');
	}
	else
	{
		$viewArtist->setCommonErrorMsg($LANG['common_msg_error_sorry']);
		$viewArtist->setPageBlockShow('block_msg_form_error');
	}
}
if($viewArtist->getFormField('action'))
{
	$viewArtist->setPageBlockShow('create_playlist_block');
	$viewArtist->setPageBlockShow('list_playlist_block');
	switch($viewArtist->getFormField('action'))
	{
		case 'Delete':
			$viewArtist->changeStatus('Deleted');
			$viewArtist->setCommonSuccessMsg($LANG['manageartistphoto_delete_successfully']);
			$viewArtist->setPageBlockShow('block_msg_form_success');
		break;

		case 'main_img':
			$viewArtist->setMainArtistImage();
			$viewArtist->setCommonSuccessMsg($LANG['manageartistphoto_update_successfully']);
			$viewArtist->setPageBlockShow('block_msg_form_success');
		break;

		case 'remove_main_img':
			$viewArtist->removeMainArtistImage();
			$viewArtist->setCommonSuccessMsg($LANG['manageartistphoto_update_successfully']);
			$viewArtist->setPageBlockShow('block_msg_form_success');
		break;

		case 'Approve':
			$viewArtist->changeStatus('Yes');
			$viewArtist->setCommonSuccessMsg($LANG['manageartistphoto_active_successfully']);
			$viewArtist->setPageBlockShow('block_msg_form_success');
		break;

		case 'Active':
			$viewArtist->changeStatus('Yes');
			$viewArtist->setCommonSuccessMsg($LANG['manageartistphoto_active_successfully']);
			$viewArtist->setPageBlockShow('block_msg_form_success');
		break;

		case 'Inactive':
			$viewArtist->changeStatus('No');
			$viewArtist->setCommonSuccessMsg($LANG['manageartistphoto_inactive_successfully']);
			$viewArtist->setPageBlockShow('block_msg_form_success');
		break;
	}
}
//<<<<<-------------- Code end ----------------------------------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($viewArtist->isShowPageBlock('list_artistlist_block'))
{
	$viewArtist->setPageBlockHide('upload_photo_block');
	$viewArtist->setPageBlockHide('list_photo_block');
	$viewArtist->setTableNames(array($CFG['db']['tbl']['users'].' AS mai '));
	$viewArtist->setReturnColumns(array('mai.user_id', 'mai.user_name', 'mai.icon_id', 'mai.icon_type', 'mai.image_ext', 'mai.sex'));
	$viewArtist->setPageBlockShow('list_artistlist_block');
	if ($viewArtist->isFormPOSTed($_POST, 'search'))
	{
		$condition .= ' and user_name  LIKE "%'.$viewArtist->getFormField('name').'%"';
	}
	$viewArtist->buildSelectQuery();
	$viewArtist->buildConditionQuery($condition);
	$viewArtist->checkSortQuery('mai.user_id', 'DESC');
	$viewArtist->buildQuery();
	$viewArtist->executeQuery();
	if($viewArtist->isResultsFound())
	{
		$viewArtist->list_artistlist_block['showArtistlists'] = $viewArtist->showArtistlists();
		$smartyObj->assign('smarty_paging_list', $viewArtist->populatePageLinksGET($viewArtist->getFormField('start')));
	}
}
if ($viewArtist->isShowPageBlock('list_photo_block'))
{
	$viewArtist->setTableAndColumns();
	$viewArtist->buildSelectQuery();
	$viewArtist->buildQuery();
	$viewArtist->executeQuery();
	//$viewArtist->printQuery();
	if($viewArtist->isResultsFound())
	{
		$viewArtist->hidden_arr = array('start', 'artist_id');
		$viewArtist->list_photo_block['showArtistImageList'] = $viewArtist->showArtistImageList();
		$smartyObj->assign('smarty_paging_list', $viewArtist->populatePageLinksGET($viewArtist->getFormField('start'), array('artist_id')));
		$viewArtist->list_photo_block['action_arr'] = array("Active" => $LANG['common_display_active'],
																"Inactive" => $LANG['common_display_inactive'],
																"Delete" => $LANG['common_delete']);
	}
}
//setMetaDescription($LANG['meta_manageartistphoto_description']);
$viewArtist->left_navigation_div = 'musicMain';
//include the header file
$viewArtist->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'music');
$smartyObj->display('manageArtistMembersPhoto.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
?>
<script language="javascript"   type="text/javascript">
var block_arr= new Array('selMsgConfirmSingle', 'selMsgConfirm');
var confirm_message = '';
var please_select_action = '<?php echo $LANG['err_tip_select_action'];?>';
function getAction()
{
	var act_value = document.selFormArtistPhoto.action_val.value;
	if(act_value)
	{
		switch (act_value)
		{
			case 'Delete':
				confirm_message = '<?php echo $LANG['manageartistphoto_delete_confirm_message'];?>';
				break;
			case 'Active':
				confirm_message = '<?php echo $LANG['manageartistphoto_active_confirm_message'];?>';
				break;
			case 'Inactive':
				confirm_message = '<?php echo $LANG['manageartistphoto_inactive_confirm_message'];?>';
				break;
		}
		$Jq('#confirmMessage').html(confirm_message);
		document.msgConfirmform.action.value = act_value;
		Confirmation('selMsgConfirm', 'msgConfirmform', Array('music_artist_member_image'), Array(multiCheckValue), Array('value'),'selFormForums');
	}
	else
		alert_manual(please_select_action);
}
</script>
<?php
$viewArtist->includeFooter();
?>