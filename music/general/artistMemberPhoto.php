<?php
//--------------class viewArtist--------------->>>//
/**
 * This class is used to manage music playlist
 *
 * @category	Rayzz
 * @package		manage music playlist
 * Copyright 	c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
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
				' , date_added = NOW()';

		//Get image extension//

		$file_ext = strtolower(substr($_FILES['artist_photo']['name'], strrpos($_FILES['artist_photo']['name'], '.')+1));
		$value_array = array($this->fields_arr['artist_id'], $this->CFG['user']['user_id'], $this->fields_arr['image_caption'], $file_ext);

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
	 * viewArtist::chkUserReachLimit()
	 *
	 * @return
	 */
	public function chkUserReachLimit()
	{
		$sql = 'SELECT count(music_artist_member_image) as total_image FROM '.$this->CFG['db']['tbl']['music_artist_member_image'].
				' WHERE status <> \'Deleted\' AND music_artist_member_id = '.$this->dbObj->Param('artist_id').' AND user_id='.$this->dbObj->Param('user_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['artist_id'], $this->CFG['user']['user_id']));
		if (!$rs)
			trigger_db_error($this->dbObj);

		$row = $rs->FetchRow();
		if($this->CFG['admin']['musics']['artist_number_of_photo_allowed'] < $row['total_image']+1)
			return false;
		else
			return true;
	}

	/**
	 * viewArtist::setTableAndColumns()
	 *
	 * @return
	 */
	public function setTableAndColumns()
	{
		$this->setTableNames(array($this->CFG['db']['tbl']['music_artist_member_image'] . ' AS mai JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON u.user_id = mai.music_artist_member_id'));
		$this->setReturnColumns(array('mai.music_artist_member_image', 'mai.music_artist_member_id', 'mai.user_id', 'mai.image_caption', 'mai.image_ext'));
		$this->sql_condition = 'u.usr_status = \'Ok\' AND mai.status=\'Yes\' AND u.user_id='.$this->fields_arr['artist_id'];
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
			$row['image_caption'] = $row['image_caption'];
			$showArtistImageList_arr[$inc]['record'] = $row;
			$showArtistImageList_arr[$inc]['artist_image'] = $artist_image_path.$row['music_artist_member_image'].$this->CFG['admin']['musics']['artist_thumb_name'].'.'.$row['image_ext'];
			$inc++;
		}
		return $showArtistImageList_arr;
	}

	/**
	 * viewArtist::deleteArtistImage()
	 *
	 * @return
	 */
	public function deleteArtistImage()
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_artist_member_image'].
				' SET status = '.$this->dbObj->Param('Deleted').
				' WHERE music_artist_member_image = '.$this->dbObj->Param('music_artist_member_image');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array('Deleted', $this->fields_arr['music_artist_member_image']));
		if (!$rs)
			trigger_db_error($this->dbObj);

		return true;
	}


}
//<<<<<-------------- Class musicArtistPhotoUpload end ---------------//
//-------------------- Code begins -------------->>>>>//
$viewartist = new viewArtist();
if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$viewartist->setPageBlockNames(array('upload_photo_block', 'list_photo_block'));
$viewartist->setAllPageBlocksHide();
$viewartist->setPageBlockShow('list_photo_block');
$viewartist->setFormField('start', 0);
$viewartist->setFormField('numpg', 20);
$viewartist->setFormField('artist_id', '');
$viewartist->setFormField('tags', '');
$viewartist->setFormField('artist_photo', '');
$viewartist->setFormField('image_caption', ' ');
$viewartist->setFormField('music_artist_member_image', '');
$viewartist->setFormField('action', '');
$viewartist->setMediaPath('../../');
$viewartist->sanitizeFormInputs($_REQUEST);
$viewartist->flag = 0;


/*echo '<pre>';
print_r($_REQUEST);
echo '</pre>';*/
$viewartist->page_title = '';
if($viewartist->getFormField('artist_id'))
	{
		if($viewartist->isValidArtistMemberID())
			{
				if(isMember())
					$viewartist->setPageBlockShow('upload_photo_block');
				$viewartist->page_title = str_replace('artist_name', $viewartist->artist_name, $LANG['viewartist_title'] );
				$viewartist->photosize_detail = str_replace('VAR_FILE_SIZE', $CFG['admin']['musics']['artist_image_size'],$LANG['viewartist_filedsize_label']);
			}
		else
			{
				$viewartist->setAllPageBlocksHide();
				$viewartist->setCommonErrorMsg($LANG['viewartist_invalide_id']);
				$viewartist->setPageBlockShow('block_msg_form_error');
			}
	}
else
	{
		$viewartist->setAllPageBlocksHide();
		$viewartist->setCommonErrorMsg($LANG['viewartist_invalide_id']);
		$viewartist->setPageBlockShow('block_msg_form_error');
	}
if ($viewartist->isFormPOSTed($_POST, 'upload'))
	{
		$viewartist->flag = 1;
		if($viewartist->chkUserReachLimit())
			{
				$addtional_msg = str_replace('file_size', $CFG['admin']['musics']['artist_image_size'],$LANG['viewartist_err_tip_file_size']);
				$viewartist->chkFileNameIsNotEmpty('artist_photo', $LANG['common_err_tip_compulsory']) and
				$viewartist->chkValidFileType('artist_photo', $LANG['viewartist_err_tip_invalid_file_type']) and
				$viewartist->chkValideFileSize('artist_photo', $LANG['viewartist_err_tip_invalid_file_size'].' '.$addtional_msg) and
				$viewartist->chkErrorInFile('artist_photo', $LANG['viewartist_err_tip_invalid_file']);
				if($viewartist->isValidFormInputs())
					{
						$viewartist->uploadArtistPhotoFile();
						$viewartist->clearHistory();
						$viewartist->flag = 0;
						$viewartist->setCommonSuccessMsg($LANG['viewartist_successfull_upload']);
						$viewartist->setPageBlockShow('block_msg_form_success');
					}
				else
					{
						$viewartist->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$viewartist->setPageBlockShow('block_msg_form_error');
					}
			}
		else
			{
					$viewartist->setCommonErrorMsg($LANG['viewartist_err_tip_photo_limit']);
					$viewartist->setPageBlockShow('block_msg_form_error');
			}
	}
if($viewartist->getFormField('action'))
	{
		$viewartist->setPageBlockShow('create_playlist_block');
		$viewartist->setPageBlockShow('list_playlist_block');
		switch($viewartist->getFormField('action'))
			{
				case 'delete':
					$viewartist->deleteArtistImage();
					$viewartist->setCommonSuccessMsg($LANG['viewartist_delete_successfully']);
					$viewartist->setPageBlockShow('block_msg_form_success');
				break;
			}
	}
//<<<<<-------------- Code end ----------------------------------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($viewartist->isShowPageBlock('list_photo_block'))
	{
		$viewartist->setTableAndColumns();
		$viewartist->buildSelectQuery();
		$viewartist->buildQuery();
		$viewartist->executeQuery();
		if($viewartist->isResultsFound())
			{
				$found = true;
				$viewartist->hidden_arr = array('start');
				$viewartist->list_photo_block['showArtistImageList'] = $viewartist->showArtistImageList();
				$smartyObj->assign('smarty_paging_list', $viewartist->populatePageLinksGET($viewartist->getFormField('start'), array('tags')));
			}
	}
//setPageTitle($LANG['meta_viewartist_title']);
//setMetaKeywords($LANG['meta_viewartist_keywords']);
//setMetaDescription($LANG['meta_viewartist_description']);
//include the header file
$viewartist->includeHeader();
?>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'].'js/functions.js';?>"></script>
<?php
//include the content of the page
setTemplateFolder('general/', 'music');
$smartyObj->display('artistPhoto.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
?>
<script language="javascript"   type="text/javascript">
var block_arr= new Array('selMsgConfirmSingle');
</script>
<?php
$viewartist->includeFooter();
?>