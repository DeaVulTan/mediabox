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
				//insert music_artist_image table//
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_artist_image'].
						' SET music_artist_id = '.$this->dbObj->Param('music_artist_id').
						' , user_id = '.$this->dbObj->Param('user_id').
						' , image_caption = '.$this->dbObj->Param('image_caption').
						' , image_ext = '.$this->dbObj->Param('image_ext').
						' , date_added = NOW()';

				//Get image extension//

				$file_ext = explode('.',$_FILES['artist_photo']['name']);
				$value_array = array($this->fields_arr['artist_id'], $this->CFG['user']['user_id'], $this->fields_arr['image_caption'], $file_ext[1]);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $value_array);
				if (!$rs)
					trigger_db_error($this->dbObj);

				//Get image name//
				$insert_id = $this->dbObj->Insert_ID();

				//Artist music list path [../../files/musics/artist_images/]//
				$artist_image_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['music_folder'].'/'.$this->CFG['admin']['musics']['artist_image_folder'].'/';
				$this->chkAndCreateFolder($artist_image_dir);
				$extern = strtolower(substr($_FILES['artist_photo']['name'], strrpos($_FILES['artist_photo']['name'], '.')+1));
				$imageObj = new ImageHandler($_FILES['artist_photo']['tmp_name']);
				$this->setIHObject($imageObj);
				$upload_path = $artist_image_dir.$insert_id;

				//Resize the image..
				$this->storeArtistImagesTempServer($upload_path, $file_ext[1]);

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
				$sql = 'SELECT count(music_artist_image) as total_image FROM '.$this->CFG['db']['tbl']['music_artist_image'].
						' WHERE status <> \'Deleted\' AND music_artist_id = '.$this->dbObj->Param('artist_id').' AND user_id='.$this->dbObj->Param('user_id');

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
				$this->setTableNames(array($this->CFG['db']['tbl']['music_artist_image'] . ' AS mai JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON u.user_id = mai.user_id'));
				$this->setReturnColumns(array('mai.music_artist_image', 'mai.music_artist_id', 'mai.user_id', 'mai.image_caption', 'mai.image_ext'));
				$this->sql_condition = 'u.usr_status = \'Ok\' AND mai.status=\'Yes\' AND music_artist_id='.$this->fields_arr['artist_id'];
				$this->sql_sort = 'mai.music_artist_image DESC';
			}
		/**
		 * viewArtist::showArtistImageList()
		 *
		 * @return
		 */
		public function showArtistImageList()
			{
				//Image path //
				$artist_image_path = $this->CFG['site']['url'].$this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['music_folder'].'/'.$this->CFG['admin']['musics']['artist_image_folder'].'/';
				$showArtistImageList_arr = array();
				$inc = 0;
				while($row = $this->fetchResultRecord())
					{
						$showArtistImageList_arr[$inc]['title_image_caption'] = $row['image_caption'];
						$row['image_caption'] = $row['image_caption'];
						$showArtistImageList_arr[$inc]['record'] = $row;
						$showArtistImageList_arr[$inc]['artist_image'] = $artist_image_path.$row['music_artist_image'].$this->CFG['admin']['musics']['artist_thumb_name'].'.'.$row['image_ext'];
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
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_artist_image'].
						' SET status = '.$this->dbObj->Param('Deleted').
						' WHERE music_artist_image = '.$this->dbObj->Param('music_artist_image');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array('Deleted', $this->fields_arr['music_artist_image']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				return true;
			}
	}
//<<<<<-------------- Class musicArtistPhotoUpload end ---------------//
//-------------------- Code begins -------------->>>>>//
$viewArtist = new viewArtist();
if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$viewArtist->setPageBlockNames(array('upload_photo_block', 'list_photo_block'));
$viewArtist->setAllPageBlocksHide();
$viewArtist->setPageBlockShow('list_photo_block');
$viewArtist->setFormField('start', 0);
$viewArtist->setFormField('numpg', $CFG['data_tbl']['numpg']);
$viewArtist->setFormField('artist_id', '');
$viewArtist->setFormField('tags', '');
$viewArtist->setFormField('artist_photo', '');
$viewArtist->setFormField('image_caption', '');
$viewArtist->setFormField('music_artist_image', '');
$viewArtist->setFormField('action', '');
$viewArtist->setMediaPath('../../');
$viewArtist->sanitizeFormInputs($_REQUEST);
$viewArtist->flag = 0;
/*echo '<pre>';
print_r($_REQUEST);
echo '</pre>';*/
$viewArtist->page_title = '';
if($viewArtist->getFormField('tags'))
	{
		if($viewArtist->isValidArtistID())
			{
				if(isMember())
					$viewArtist->setPageBlockShow('upload_photo_block');
				$viewArtist->page_title = str_replace('artist_name', $viewArtist->artist_name, $LANG['viewartist_title'] );
			}
		else
			{
				$viewArtist->setAllPageBlocksHide();
				$viewArtist->setCommonErrorMsg($LANG['viewartist_invalide_id']);
				$viewArtist->setPageBlockShow('block_msg_form_error');
			}
	}
else
	{
		$viewArtist->setAllPageBlocksHide();
		$viewArtist->setCommonErrorMsg($LANG['viewartist_invalide_id']);
		$viewArtist->setPageBlockShow('block_msg_form_error');
	}
if ($viewArtist->isFormPOSTed($_POST, 'upload'))
	{
		$viewArtist->flag = 1;
		if($viewArtist->chkUserReachLimit())
			{
				$addtional_msg = str_replace('file_size', $CFG['admin']['musics']['artist_image_size'],$LANG['viewartist_err_tip_file_size']);
				$viewArtist->chkFileNameIsNotEmpty('artist_photo', $LANG['common_err_tip_compulsory']) and
				$viewArtist->chkValidFileType('artist_photo', $LANG['viewartist_err_tip_invalid_file_type']) and
				$viewArtist->chkValideFileSize('artist_photo', $LANG['viewartist_err_tip_invalid_file_size'].' '.$addtional_msg) and
				$viewArtist->chkErrorInFile('artist_photo', $LANG['viewartist_err_tip_invalid_file']);
				if($viewArtist->isValidFormInputs())
					{
						$viewArtist->uploadArtistPhotoFile();
						$viewArtist->clearHistory();
						$viewArtist->flag = 0;
						$viewArtist->setCommonSuccessMsg($LANG['viewartist_successfull_upload']);
						$viewArtist->setPageBlockShow('block_msg_form_success');
					}
				else
					{
						$viewArtist->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$viewArtist->setPageBlockShow('block_msg_form_error');
					}
			}
		else
			{
					$viewArtist->setCommonErrorMsg($LANG['viewartist_err_tip_photo_limit']);
					$viewArtist->setPageBlockShow('block_msg_form_error');
			}
	}
if($viewArtist->getFormField('action'))
	{
		$viewArtist->setPageBlockShow('create_playlist_block');
		$viewArtist->setPageBlockShow('list_playlist_block');
		switch($viewArtist->getFormField('action'))
			{
				case 'delete':
					$viewArtist->deleteArtistImage();
					$viewArtist->setCommonSuccessMsg($LANG['viewartist_delete_successfully']);
					$viewArtist->setPageBlockShow('block_msg_form_success');
				break;
			}
	}
//<<<<<-------------- Code end ----------------------------------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($viewArtist->isShowPageBlock('list_photo_block'))
	{
		$viewArtist->setTableAndColumns();
		$viewArtist->buildSelectQuery();
		$viewArtist->buildQuery();
		$viewArtist->executeQuery();
		if($viewArtist->isResultsFound())
			{
				$found = true;
				$viewArtist->hidden_arr = array('start');
				$viewArtist->list_photo_block['showArtistImageList'] = $viewArtist->showArtistImageList();
				$smartyObj->assign('smarty_paging_list', $viewArtist->populatePageLinksGET($viewArtist->getFormField('start'), array('artist_id')));
			}
	}
//setPageTitle($LANG['meta_viewartist_title']);
//setMetaKeywords($LANG['meta_viewartist_keywords']);
//setMetaDescription($LANG['meta_viewartist_description']);
//include the header file
$viewArtist->includeHeader();
//include the content of the page
setTemplateFolder('general/', 'music');
$smartyObj->display('viewArtist.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
?>
<script language="javascript"   type="text/javascript">
var block_arr= new Array('selMsgConfirmSingle');
</script>
<?php
$viewArtist->includeFooter();
?>