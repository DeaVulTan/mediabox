<?php
/**
 * Edit Music Details
 *
 * @package		general
 * @author
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @access 		public
 **/


require_once('../../common/configs/config.inc.php');
$CFG['benchmark']['is_expose_parse_time'] = false;
$CFG['benchmark']['query_time']['is_expose_query'] = false;
$CFG['benchmark']['query_time']['is_expose'] = false;
$CFG['lang']['include_files'][] = 'languages/%s/music/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/admin/editMusicDetails.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/musicUpload.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/countries_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/language_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/help.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicUpload.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['mods']['include_files'][] = 'common/classes/php_reader/getMetaData.php';
$CFG['site']['is_module_page']='music';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');

class EditMusicDetails extends MusicUploadLib
	{

		public $music_url = '';
		public $hidden_arr = array();
		public $multi_hidden_arr = array();
		public $fp = false;

		/**
		 * EditMusicDetails::validationFormFields1()
		 *
		 * @return void
		 */
		public function validationFormFields1()
		{
			$this->chkIsNotEmpty('music_category_id', $this->LANG['common_err_tip_required']);
			$this->chkIsNotEmpty('music_title', $this->LANG['common_err_tip_required']);
			$this->chkIsNotEmpty('music_tags', $this->LANG['common_err_tip_required']) and
				$this->chkValidTagList('music_tags',$this->LANG['common_err_tip_invalid_tag']);
			$this->checkValidDate($this->LANG['editmusic_err_tip_invalid_date']);
		}

		/**
		 * EditMusicDetails::chkIsEditMode()
		 *
		 * @return boolean
		 */
		public function chkIsEditMode()
		{
			if($this->fields_arr['music_id']
				and $this->checkIsValidMusic($this->getFormField('music_id')))
				{
					$_SESSION['new_music_id'] = array();
					$_SESSION['new_music_id'][] = $this->fields_arr['music_id'];
					return true;
				}
			return false;
		}

		/**
		 * EditMusicDetails::chkFileIsNotEmpty()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkFileIsNotEmpty($field_name, $err_tip = '')
		{
			if(!isset($_FILES[$field_name]))
				{
					$this->setFormFieldErrorTip($field_name, $err_tip);
					return false;
				}
			return true;
		}

		/**
		 * EditMusicDetails::chkFileNameIsNotEmpty()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
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
		 * EditMusicDetails::chkValidFileType()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 **/
		public function chkValidFileType($field_name, $err_tip = '')
		{
			$extern = strtolower(substr($_FILES[$field_name]['name'], strrpos($_FILES[$field_name]['name'], '.')+1));
			if (!in_array($extern, $this->CFG['admin']['musics']['format_arr']))
				{
					$this->fields_err_tip_arr[$field_name] = $err_tip;
					return false;
				}
			return true;
		}

		/**
		 * EditMusicDetails::chkValidExternalFileType()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkValidExternalFileType($field_name, $err_tip = '')
		{
			$format_arr = $this->CFG['admin']['musics']['format_arr'];
			if(!$this->CFG['admin']['musics']['external_music_download'])
				$format_arr = array('mp3');

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
		 * EditMusicDetails::chkValidFileSize()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 **/
		public function chkValidFileSize($field_name, $err_tip='')
		{
			if($this->CFG['admin']['musics']['max_size'])
				{
					$max_size = $this->CFG['admin']['musics']['max_size']*1024*1024;
					if ($_FILES[$field_name]['size'] > $max_size)
						{
							$this->fields_err_tip_arr[$field_name] = $err_tip;
							return false;
						}
				}
			return true;
		}

		/**
		 * EditMusicDetails::chkErrorInFile()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
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
		 * EditMusicDetails::chkValidImageType()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkValidImageType($field_name, $err_tip = '')
		{
			$extern = strtolower(substr($_FILES[$field_name]['name'], strrpos($_FILES[$field_name]['name'], '.')+1));
			if (!in_array($extern, $this->CFG['admin']['musics']['image_format_arr']))
				{
					$this->fields_err_tip_arr[$field_name] = $err_tip;
					return false;
				}
			return true;
		}

		/**
		 * EditMusicDetails::chkValidImageSize()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkValidImageSize($field_name, $err_tip='')
		{
			if($this->CFG['admin']['musics']['image_max_size'])
				{
					$max_size = $this->CFG['admin']['musics']['image_max_size']*1024;
					if ($_FILES[$field_name]['size'] > $max_size)
						{
							$this->fields_err_tip_arr[$field_name] = $err_tip;
							return false;
						}
				}
			return true;
		}

		/**
		 * EditMusicDetails::chkIsFile()
		 *
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkIsFile($err_tip)
		{
			if(isset($this->fields_arr['file_extern']))
				{
					$this->fields_arr['file_extern'] = strtolower($this->fields_arr['file_extern']);
					$extern = $this->fields_arr['file_extern'];
					$temp_dir = '../'.$this->CFG['admin']['musics']['temp_folder'];
					$temp_file = $temp_dir.$this->fields_arr['upload'].'.'.$extern;

					if(is_file($temp_file))
						{
							return true;
						}
				}
			$this->setFormFieldErrorTip('music_file',$err_tip);
			return false;
		}

		/**
		 * EditMusicDetails::loadFilesForSwfUpload()
		 *
		 * @return void
		 */
		public function loadFilesForSwfUpload()
			{
				global $CFG;
				$allowed_file_formats = implode(';*.', $CFG['admin']['musics']['format_arr']);
				$allowed_file_formats = '*.'.$allowed_file_formats;
				if(!isAjaxPage())
					{
				?>
				<script type="text/javascript">
				<?php
					}
				?>
						var multi_upload;
					<?php
						if(!isAjaxPage())
							{
					?>
						$Jq(document).ready(function(){
					<?php
							}
					?>
							multi_upload = new SWFUpload({
								// Backend Settings
								upload_url: "../musicBulkUpload.php",
								post_params: {"PHPSESSID" : "<?php echo session_id(); ?>"},

								// File Upload Settings
								file_size_limit : "<?php echo $CFG['admin']['musics']['max_size']; ?> MB",	// MB
								//file_size_limit : "20 MB",	// MB
								file_types : "<?php echo $allowed_file_formats; ?>",
								//file_types_description : "All Files",
								file_upload_limit : "<?php echo $CFG['admin']['musics']['multi_upload_files_limit']; ?>",
								file_queue_limit : "0",

								// Event Handler Settings (all my handlers are in the Handler.js file)
								file_post_name : 'music_file',
								file_dialog_start_handler : fileDialogStart,
								file_queued_handler : fileQueued,
								file_queue_error_handler : fileQueueError,
								file_dialog_complete_handler : fileDialogComplete,
								upload_start_handler : uploadStart,
								upload_progress_handler : uploadProgress,
								upload_error_handler : uploadError,
								upload_success_handler : uploadSuccess,
								upload_complete_handler : uploadComplete,

								// Button Settings
								// button_image_url : "../../js/SWFUpload/images/XPButtonUploadText_61x22.png",
								// button_placeholder_id : "spanButtonPlaceholder1",
								// button_width: 61,
								// button_height: 22,
								button_placeholder_id : "spanButtonPlaceholder1",
								button_width: 42,
								button_height: 22,
								button_text : '<span class="button"><?php echo $this->LANG['editmusic_browse_file']; ?></span>',
								button_text_style : '.button { font-family: Arial, sans-serif; font-size: 11px; font-weight: normal; padding:10px; color: #ffffff; height:30px; }',
								button_text_top_padding: 2,
								button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
								button_cursor: SWFUpload.CURSOR.HAND,

								// Flash Settings
								flash_url : "../../js/SWFUpload/Flash/swfupload.swf",


								custom_settings : {
									progressTarget : "fsUploadProgress1",
									cancelButtonId : "btnCancel1",
									skipButtonId : "btnSkip",
									nextStepButtonId : "upload_music_multiupload"
								},

								// Debug Settings
								debug: false
							});
					<?php
						if(!isAjaxPage())
							{
					?>
					     });
					</script>
					<?php
						}
			}

		/**
		 * EditMusicDetails::isValidFormInputsMultiUpload()
		 *  To check file is uploaded for MultiUpload
		 *
		 * @return boolean
		 */
		public function isValidFormInputsMultiUpload()
		{
			if(isset($_SESSION['new_music_id']) AND !empty($_SESSION['new_music_id']))
				{
					return true;
				}
			return false;
		}

		/**
		 * EditMusicDetails::populateAudioDetailsForUpload()
		 *
		 * @return void
		 */
		public function populateAudioDetailsForUpload()
		{
			global $smartyObj;
			$populateAudioDetailsForUpload_arr = array();
			$inc = 0;
			$add = '';
			if(!$this->CFG['admin']['is_logged_in'])
				$add =' user_id=\''.$this->getFormField('user_id').'\' AND ';

			foreach($_SESSION['new_music_id'] as $key => $music_id)
			{
				$sql = 'SELECT music_title, playing_time, music_album_id, user_id, music_artist, music_status, '.
						' music_thumb_ext, music_ext, music_caption, music_tags, music_access_type,'.
						' music_server_url, allow_comments, allow_ratings, allow_embed, allow_lyrics,'.
						' allow_download, music_language, music_year_released, relation_id, '.
						' music_category_id, music_sub_category_id,  preview_start,preview_end,music_price,for_sale'.
						' FROM '.$this->CFG['db']['tbl']['music'].' WHERE'.
						' music_id='.$this->dbObj->Param('music_id').' LIMIT 0,1'; //music_status=\'Ok\' AND'.

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($music_id));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.
							$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
				{
					$this->setFormField('music_title_'.$inc, $row['music_title']);
					$this->setFormField('music_status_'.$inc, $row['music_status']);
					$this->setFormField('music_album_'.$inc, getMusicAlbumName($row['music_album_id']));
					$this->setFormField('music_id_'.$inc, $music_id);
					$this->setFormField('music_caption_'.$inc, $row['music_caption']);
					$this->setFormField('music_album_id_'.$inc, $row['music_album_id']);
					$this->setFormField('preview_start_'.$inc, $row['preview_start']);
					$this->setFormField('preview_end_'.$inc, $row['preview_end']);
					$this->setFormField('music_price_'.$inc, $row['music_price']);
					$this->setFormField('for_sale_'.$inc, $row['for_sale']);
					$this->setFormField('playing_time_'.$inc, $row['playing_time']);
					$artist_names = $this->getArtistsNames($row['music_artist']);
					$this->setFormField('music_artist_'.$inc, $artist_names);
					//Set the private album related variables
					$album_details = getMusicAlbumDetails($row['music_album_id']);
					$this->setFormField('album_access_type_'.$inc, $album_details['album_access_type']);
					$this->setFormField('album_for_sale_'.$inc, $album_details['album_for_sale']);
					$this->setFormField('album_price_'.$inc, $album_details['album_price']);
					$this->setFormField('music_caption', $row['music_caption']);
					$this->setFormField('user_id', $row['user_id']);
					$this->setFormField('music_tags', $row['music_tags']);
					$this->setFormField('music_language', $row['music_language']);
					$this->setFormField('music_category_id', $row['music_category_id']);
					$this->setFormField('music_sub_category_id', $row['music_sub_category_id']);
					$this->setFormField('allow_comments', $row['allow_comments']);
					$this->setFormField('allow_ratings', $row['allow_ratings']);
					$this->setFormField('allow_lyrics', $row['allow_lyrics']);
					$this->setFormField('allow_embed', $row['allow_embed']);
					$this->setFormField('allow_download', $row['allow_download']);
					$this->setFormField('music_access_type', $row['music_access_type']);
					if($row['relation_id'])
						$this->fields_arr['relation_id'] = explode(',',$row['relation_id']);
					if($row['music_status'] == 'Ok')
					{
						$image_thumb_folder = $this->CFG['site']['url'].$this->CFG['media']['folder'].'/'.
												$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['folder'].'/'.
													$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['thumbnail_folder'].'/';
					}
					else
					{
						$image_thumb_folder = $this->CFG['site']['url'].$this->CFG['media']['folder'].'/'.
												$this->CFG['temp_media']['folder'].'/'.
													$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['temp_folder'].'/';
					}

					$this->setFormField('music_thumb_folder_'.$inc, $image_thumb_folder);
					if(!empty($row['music_thumb_ext']))
					{
						$this->setFormField('music_thumb_ext_'.$inc, $row['music_thumb_ext']);
					}
					else
					{
						$this->setFormField('music_thumb_ext_'.$inc, '');
					}
					$this->setFormField('music_year_released_'.$inc, $row['music_year_released']);
					$populateAudioDetailsForUpload_arr[$inc]['music_title'] = $row['music_title'];
					$populateAudioDetailsForUpload_arr[$inc]['music_album'] = getMusicAlbumName($row['music_album_id']);
					$populateAudioDetailsForUpload_arr[$inc]['music_album_id'] = $row['music_album_id'];
					$populateAudioDetailsForUpload_arr[$inc]['music_artist'] = $row['music_artist'];
					$populateAudioDetailsForUpload_arr[$inc]['user_id'] = $row['user_id'];
					$populateAudioDetailsForUpload_arr[$inc]['music_year_released'] = $row['music_year_released'];
					//music_id for hidden fields
					$this->multi_hidden_arr[$inc] = 'music_id_'.$inc;
					$this->multi_hidden_arr[$inc+count($_SESSION['new_music_id'])] = 'playing_time_'.$inc;
					$inc++;
				}
			}
			$this->setFormField('total_musics', $inc);
			$smartyObj->assign('populateAudioDetailsForUpload_arr', $populateAudioDetailsForUpload_arr);
		}

		/**
		 * EditMusicDetails::setStep2CommonFields()
		 *
		 * @return void
		 */
		public function setStep2CommonFields()
		{
			if(isset($_POST['music_category_id_general']))
				$_POST['music_category_id'] = $_POST['music_category_id_general'];
			else
				$_POST['music_category_id'] = isset($_POST['music_category_id_porn'])?$_POST['music_category_id_porn']:'';

			$this->update_table_fields_arr = array('music_title','music_artist',
												 'music_caption', 'music_year_released',
												 'music_category_id', 'music_sub_category_id', 'music_tags',
												 'music_language', 'music_access_type', 'relation_id',
												 'allow_comments', 'allow_ratings',
												 'allow_embed', 'allow_lyrics', 'step_status');

			$this->multiple_fields_arr = array('music_title', 'music_artist',
												'music_year_released', 'music_thumb_ext','music_caption');

			for($i=0;$i<$this->getFormField('total_musics');$i++)
			{
				$this->setFormField('music_id_'.$i, '');
				$this->setFormField('music_title_'.$i, '');
				$this->setFormField('album_access_type_'.$i, '');
				$this->setFormField('music_artist_'.$i, '');
				$this->setFormField('music_old_artist_'.$i, '');
				$this->setFormField('music_thumb_ext_'.$i, '');
				$this->setFormField('music_year_released_'.$i, '');
				$this->setFormField('music_thumb_image_'.$i, '');
				$this->setFormField('music_thumb_folder_'.$i, '');
				$this->setFormField('music_status_'.$i, '');
				$this->setFormField('music_caption_'.$i, '');
			}
			$this->setFormField('step_status', 'Ok');
		}

		/**
		 * EditMusicDetails::getExistingAlbumId()
		 *
		 * @param mixed $music_id
		 * @return
		 */
		public function getExistingAlbumId($music_id)
		{
			$sql = 'SELECT music_album_id FROM '.
					$this->CFG['db']['tbl']['music'].
					' WHERE music_id='.$this->dbObj->Param('music_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($music_id));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);
			if($row = $rs->FetchRow())
			{
				return $row['music_album_id'];
			}
			return true;
		}
		/**
		 * EditMusicDetails::checkAlbum()
		 *
		 * @return void
		 */
		public function checkAlbum()
		{
			for($i=0;$i<$this->getFormField('total_musics');$i++)
			{
				$album_id = $this->fields_arr['music_album_id_'.$i];
				$album_name = $this->fields_arr['music_album_'.$i];
				$album_type = $this->fields_arr['album_access_type_'.$i];
				//Checked the Album is private, if so insert the record to already purchased users
				if($album_type=='Private')
				{
					$existing_id = $this->getExistingAlbumId($this->fields_arr['music_id_'.$i]);
					if($album_id!=$existing_id)
					{
						$this->chkAndAddMusicPurchases($album_id, $this->fields_arr['music_id_'.$i]);
					}
				}
				if($album_type!='Private')
					$new_album_id = $this->chkAlbumName($album_name);
				else
					$new_album_id = $this->fields_arr['music_album_id_'.$i];
				if(empty($new_album_id) and !empty($album_name) and $album_type!='Private')
					{
						$this->fields_arr['music_album_id_'.$i] = $this->addAlbumName($album_name, $album_type);
					}
				else
					$this->fields_arr['music_album_id_'.$i] = $new_album_id;
				if($this->fields_arr['music_album_id_'.$i])
					$this->fields_arr['music_album_id_'.$i] = $this->fields_arr['music_album_id_'.$i];
				if($this->fields_arr['music_album_id_'.$i] == '')
					$this->fields_arr['music_album_id_'.$i] = 1;
				/*echo $this->fields_arr['music_id_'.$i].'<br/>';
				echo $this->fields_arr['music_title_'.$i];*/
			}
		}

		public function chkValueDiffers($music_id, $preview_start, $preview_end)
		{
			$sql = 'SELECT preview_start, preview_end FROM '.
					$this->CFG['db']['tbl']['music'].
					' WHERE music_id='.$this->dbObj->Param('music_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($music_id));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);
			if($row = $rs->FetchRow())
			{
				if($row['preview_start']!=$preview_start or $row['preview_end']!=$preview_end)
					return true;

				return false;
			}
		}

		/**
		 * EditMusicDetails::updateMusicDetailsForUpload()
		 *
		 * @return void
		 */
		public function updateMusicDetailsForUpload()
		{
			for($i=0;$i<$this->getFormField('total_musics');$i++)
			{
				//if($this->fields_arr['preview_start'.$i]=='')
				if($this->fields_arr['music_year_released_'.$i] == '')
					$this->setFormField('music_year_released_'.$i, NULL);

				$music_id = $this->fields_arr['music_id_'.$i];
				$music_name = $this->getMusicName($music_id);
				$music_thumb_name = $this->getMusicImageName($music_id);

				//Update to music_artist table
				$artist_new = explode(',', trim($this->fields_arr['music_artist_'.$i]));
				$artist_old = explode(',', $this->fields_arr['music_old_artist_'.$i]);
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
					$this->fields_arr['music_artist_'.$i] = $this->artist_id;

					$music_artist_key = array_search('music_artist', $this->update_table_fields_arr);
					if($music_artist_key == '')
						array_push($this->update_table_fields_arr, 'music_artist');
				}
				else
				{
					$music_artist_key = array_search('music_artist', $this->update_table_fields_arr);
					unset($this->update_table_fields_arr[$music_artist_key]);
				}
				if($this->fields_arr['music_artist_'.$i] == '')
					$this->fields_arr['music_artist_'.$i] = 1;
				if($_FILES['music_thumb_image_'.$i]['tmp_name'])
				{
					$extern_img = strtolower(substr($_FILES['music_thumb_image_'.$i]['name'],
									strrpos($_FILES['music_thumb_image_'.$i]['name'], '.')+1));

					if($this->getFormField('music_status_'.$i) == 'Ok')
					{
						$upload_dir_thumb = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
												$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['folder'].'/'.
													$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['thumbnail_folder'].'/';
					}
					else
					{
						$upload_dir_thumb = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
												$this->CFG['temp_media']['folder'].'/'.
													$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['temp_folder'].'/';
					}

					$this->chkAndCreateFolder($upload_dir_thumb);
					$image_upload_url = $upload_dir_thumb.$music_thumb_name;


					//Upload new image and create images for the sizes
					if(move_uploaded_file($_FILES['music_thumb_image_'.$i]['tmp_name'], $image_upload_url.'L.'.$extern_img))
					{
						if($this->getFormField('music_thumb_ext_'.$i) != '')
						{
							//To remove old images
							/*$old_thumb_ext = $this->getFormField('music_thumb_ext_'.$i);
							$old_thumb_image = $upload_dir_thumb.$music_thumb_name;
							if(is_file($old_thumb_image.'T.'.$old_thumb_ext))
								unlink($old_thumb_image.'T.'.$old_thumb_ext);

							if(is_file($old_thumb_image.'M.'.$old_thumb_ext))
								unlink($old_thumb_image.'M.'.$old_thumb_ext);

							if(is_file($old_thumb_image.'S.'.$old_thumb_ext))
								unlink($old_thumb_image.'S.'.$old_thumb_ext);*/
						}
						$imageObj = new ImageHandler($image_upload_url.'L.'.$extern_img);
						$this->setIHObject($imageObj);
						$this->storeImagesTempServer($image_upload_url, $extern_img);
						$this->update_table_fields_arr[] = 'music_thumb_ext';
						$this->setFormField('music_id', $music_id);
						$this->setFormField('music_thumb_ext_'.$i, $extern_img);
						//To update image sizes in music table
						$this->updateMusicImageExt();
					}
				}

				$param_value_arr = array();
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET ';
				foreach($this->update_table_fields_arr as $key => $fieldname)
				{
					if($this->fields_arr[$fieldname] != 'NOW()')
					{
						if(in_array($fieldname, $this->multiple_fields_arr))
						{
							$param_value_arr[] = $this->fields_arr[$fieldname.'_'.$i];
						}
						else
						{
							$param_value_arr[] = $this->fields_arr[$fieldname];
						}

						$sql .= $fieldname.'='.$this->dbObj->Param($fieldname).', ';
					}
					else
						$sql .= $fieldname.'='.$this->fields_arr[$fieldname].', ';

				}

				$sql = substr($sql, 0, strrpos($sql, ','));

				$sql .= ' WHERE music_id='.$this->dbObj->Param('music_id_'.$i);

				$param_value_arr[] = $this->fields_arr['music_id_'.$i];


				//echo $sql.'<br><br>'; echo $this->fields_arr['music_id']; //die();
				//$this->music_id = $this->fields_arr['music_id'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $param_value_arr);

				if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($this->getFormField('edit_mode') == 1)
					{
						$this->setFormField('music_id', $music_id);
					}

			}

			// insert music tag value into music_tags table
			if(!$this->CFG['admin']['tagcloud_based_search_count'])
				$this->changeTagTable();

			$_SESSION['new_music_id'] = array();
		}
		public function showMusicUpdateAlbum($type='Public', $user_id='', $album_id)
		{

			$user_id=$this->getFormField('user_id');
			$sql = 'SELECT music_album_id, album_title,user_id FROM '.
					$this->CFG['db']['tbl']['music_album'].
					' WHERE  album_access_type='.$this->dbObj->Param('album_access_type').
					' AND user_id='.$this->dbObj->Param('user_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($type,$user_id));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if(!$rs->PO_RecordCount())
				return;

			$names = array('album_title');
			$value = $album_id;
			//$highlight_value = $this->fields_arr['music_album_id'];

			$inc = 0;
			while($row = $rs->FetchRow())
			{
				$out = '';
				foreach($names as $name)
					$out .= $row[$name];
				$selected = $row['music_album_id'] == $value?' selected':'';
				?><option value="<?php echo $row['music_album_id'];?>" <?php echo $selected;?>><?php echo $out;?></option><?php
				$inc++;
			}
		}

		/**
		 * EditMusicDetails::populateMusicCatagory()
		 *
		 * @param string $type
		 * @param string $err_tip
		 * @return boolean
		 */
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

		/**
		 * EditMusicDetails::populateMusicSubCatagory()
		 *
		 * @param integer $cid
		 * @return void
		 */
		public function populateMusicSubCatagory($cid)
		{
			$sql = 'SELECT music_category_id, music_category_name FROM '.
					$this->CFG['db']['tbl']['music_category'].
					' WHERE parent_category_id='.$this->dbObj->Param('parent_category_id').
					' AND music_category_status=\'Yes\' AND allow_post=\'Yes\'';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($cid));
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
					<option value="<?php echo $row[$value];?>"<?php if($this->fields_arr['music_sub_category_id']==$row[$value]){ echo " selected";}?>><?php echo $out;?></option>
					<?php
				}
			?></select><?php
		}

		/**
		 * EditMusicDetails::validateBasicFields()
		 *  To validate Basic Form fields
		 *
		 * @return void
		 */
		public function validateBasicFields()
		{
			for($i=0;$i<$this->getFormField('total_musics');$i++)
			{
				$this->chkIsNotEmpty('music_title_'.$i, $this->LANG['common_music_err_tip_compulsory']);

				if($this->CFG['admin']['musics']['music_upload_artist_name_compulsory'])
					$this->chkIsNotEmpty('music_artist_'.$i, $this->LANG['common_music_err_tip_compulsory']);

				if(isset($this->fields_arr['music_artist_'.$i]) && $this->fields_arr['music_artist_'.$i] != '')
					$this->chkValidArtistList('music_artist_'.$i, $this->LANG['common_music_err_tip_invalid_artist']);

				if($this->CFG['admin']['musics']['music_upload_album_name_compulsory'])
					$this->chkIsNotEmpty('music_album_'.$i, $this->LANG['common_music_err_tip_compulsory']);

				if($this->CFG['admin']['musics']['music_upload_release_year_compulsory'])
					$this->chkIsNotEmpty('music_year_released_'.$i, $this->LANG['common_music_err_tip_compulsory']);

				if(isset($this->fields_arr['music_year_released_'.$i]) && $this->fields_arr['music_year_released_'.$i] != '')
				{
					$this->chkIsNumeric('music_year_released_'.$i, $this->LANG['editmusic_year_invalid']);
					if(strlen($this->fields_arr['music_year_released_'.$i])<4)
						$this->setFormFieldErrorTip('music_year_released_'.$i, $this->LANG['editmusic_year_invalid']);
				}

				if(isset($_FILES['music_thumb_image_'.$i]) and !empty($_FILES['music_thumb_image_'.$i]['name']))
				{
					$this->chkFileNameIsNotEmpty('music_thumb_image_'.$i, $this->LANG['common_music_err_tip_required']) and
					$this->chkValidImageType('music_thumb_image_'.$i, $this->LANG['common_music_err_tip_invalid_image_type']) and
					$this->chkValidImageSize('music_thumb_image_'.$i, $this->LANG['common_music_err_tip_invalid_image_size']) and
					$this->chkErrorInFile('music_thumb_image_'.$i, $this->LANG['common_music_err_tip_invalid_file']);
				}

				if($this->fields_arr['album_access_type_'.$i] == 'Private' and empty($this->fields_arr['music_album_id_'.$i]))
					$this->fields_err_tip_arr['selAlbumId_'.$i] = 'Compulsory';
			}
		}

		/**
		 * EditMusicDetails::validateCommonFormFields()
		 *  To validate common Form fields
		 *
		 * @return void
		 */
		public function validateCommonFormFields()
		{
			$this->chkIsNotEmpty('music_category_id', $this->LANG['common_music_err_tip_compulsory']);
			$this->chkIsNotEmpty('music_tags', $this->LANG['common_music_err_tip_compulsory']) and
				$this->chkValidTagList('music_tags', 'music_tags', $this->LANG['common_music_err_tip_invalid_tag']);
		}

		/**
		 * EditMusicDetails::chkIsFileOk()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkIsFileOk($field_name, $err_tip = '')
		{
			$this->music_url = $this->fields_arr[$field_name];
			return true;
		}

		/**
		 * EditMusicDetails::chkIsValidPath()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkIsValidPath($field_name, $err_tip = '')
		{
			if(!getHeadersManual($this->fields_arr[$field_name]))
			{
				$this->fields_err_tip_arr[$field_name] = $err_tip;
				return false;
			}
			//Fixed the external upload validation. Since it is not returned chkValidExternalFileType method is not calling
			return true;
		}

		/**
		 * EditMusicDetails::generateAudioRecorderSettings()
		 *
		 * @return void
		 */
		public function generateAudioRecorderSettings()
		{
			$this->record_filename = substr(md5(microtime().'_'.$this->CFG['user']['user_id']), 0, 15);
			$config_path = $this->CFG['site']['url'].'music/audioCaptureConfigXmlCode.php?file_name='.$this->record_filename;
			$theme_path = $this->CFG['site']['url'].$this->CFG['media']['folder'].'/flash/music/AudioRecorder/xml/skin.xml';
			$this->audio_recorder_path = $this->CFG['site']['url'].$this->CFG['media']['folder'].
										   '/flash/music/AudioRecorder/AudioRecorder.swf?file_name=test&amp;settingspath='.
												  $config_path.'&amp;themePath='.$theme_path;
		}

		/**
		 * EditMusicDetails::chkIsValidRecordedFile()
		 *
		 * @return boolean
		 */
		public function chkIsValidRecordedFile()
		{
			$file_name = $this->CFG['admin']['video']['red5_flv_path'].$this->fields_arr['recorded_filename'].'.flv';
			//Checked the condition if file_name contains http
			if(preg_match('/http/', $file_name) and chkIsValidUrlUsingCurl($file_name))
				return true;
			elseif(is_file($file_name))
				return true;
			return false;
		}

		public function chkIsValidPreviewEnd($preview_start, $preview_end, $playing_time, $err_tip='')
		{
			if($this->getFormField($playing_time))
			{
				$playing = explode(':',$this->getFormField($playing_time));
				$duration = $playing[0]*60+$playing[1]*60+$playing[2];
				$this->LANG['editmusic_music_duration'] = str_replace('{duration}', $duration, $this->LANG['editmusic_music_duration']);
				if($this->getFormField($preview_start)> $duration)
				{
					$this->fields_err_tip_arr[$preview_start] = $this->LANG['editmusic_msg_start_exceeds_time_valid'].$this->LANG['editmusic_music_duration'];
					return false;
				}
				if($this->getFormField($preview_end)> $duration)
				{
					$this->fields_err_tip_arr[$preview_end] = $this->LANG['editmusic_msg_end_exceeds_time_valid'].$this->LANG['editmusic_music_duration'];
					return false;
				}
				if($this->getFormField($preview_start)> $this->getFormField($preview_end))
				{
					$this->fields_err_tip_arr[$preview_end] = $err_tip;
					return false;
				}
				return true;
			}
		}

	   public function populateEditUserForRelationList()
			{
				$return= array();
				global $smartyObj;
				$sql = 'SELECT relation_id, relation_name ,total_contacts '.
						' FROM '.$this->CFG['db']['tbl']['friends_relation_name'].
						' where user_id = '.$this->dbObj->Param('user_id').' AND total_contacts>0'.
						' ORDER BY relation_name ';
     			$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->getFormField('user_id')));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$inc=0;
				$this->relation_list_count=0;
				if($rs->PO_RecordCount())
					{
						$this->relation_list_count=$rs->PO_RecordCount();
						while($row = $rs->FetchRow())
						{
							$return[$inc]['record']=$row;
							$inc++;
						}
					}
				$smartyObj->assign('populateCheckBoxForRelationList', $return);
				setTemplateFolder('admin/', 'music');
				$smartyObj->display('populateMusicEditRelationList.tpl');

			}
	}

$EditMusicDetails = new EditMusicDetails();

if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$EditMusicDetails->setPageBlockNames(array('block_editmusic_step1', 'block_editmusic_step2', 'music_upload_form',
									'block_editmusic_normalupload_form', 'block_editmusic_multiupload_form',
									'block_editmusic_externalupload_form', 'block_editmusic_recordaudio_form','block_editmusic_step3'));

//Set media path
$EditMusicDetails->setMediaPath('../../');
//$_SESSION['new_music_id'] = array();
$EditMusicDetails->music_uploaded_success = true;
//Default Upload tab
$EditMusicDetails->show_div = '';
$EditMusicDetails->left_navigation_div = 'musicMain';
//default form fields and values...
$EditMusicDetails->resetFieldsArray();
$EditMusicDetails->setFormField('music_upload_type', 'Normal');
$EditMusicDetails->setFormField('msg', '');
$EditMusicDetails->setFormField('user_id', '');
$EditMusicDetails->setAllPageBlocksHide();
$EditMusicDetails->setPageBlockShow('block_editmusic_step1');
$EditMusicDetails->hidden_arr = array('total_musics');
if($EditMusicDetails->getFormField('msg')=='updated')
{
	$EditMusicDetails->setCommonErrorMsg($LANG['editmusic_msg_update_success']);
	$EditMusicDetails->setPageBlockShow('block_msg_form_error');
}
$EditMusicDetails->music_format =  implode(', ', $CFG['admin']['musics']['format_arr']);
$EditMusicDetails->music_image_format =  implode(', ', $CFG['admin']['musics']['image_format_arr']);
$LANG['music_common_err_tip_invalid_tag'] = str_replace('{min}', $CFG['fieldsize']['music_tags']['min'],
													$LANG['common_music_err_tip_invalid_tag']);
$LANG['music_common_err_tip_invalid_tag'] = str_replace('{max}', $CFG['fieldsize']['music_tags']['max'],
													$LANG['common_music_err_tip_invalid_tag']);
$EditMusicDetails->editmusic_artist_note_msg = str_replace('{artist_min_chars}', $CFG['fieldsize']['music_artist']['min'],
													$LANG['editmusic_artist_note']);
$EditMusicDetails->editmusic_artist_note_msg = str_replace('{artist_max_chars}', $CFG['fieldsize']['music_artist']['max'],
													$EditMusicDetails->editmusic_artist_note_msg);
$EditMusicDetails->editmusic_multi_upload_info = str_replace('{files_max_limit}', $CFG['admin']['musics']['multi_upload_files_limit'],
													$LANG['editmusic_multi_upload_info']);
$EditMusicDetails->editmusic_msg_success_uploaded = ($CFG['admin']['musics']['music_auto_encode'] and $CFG['admin']['musics']['music_auto_activate'])?$LANG['editmusic_msg_success_uploaded_auto']:$LANG['editmusic_msg_success_uploaded_admin'];
//$LANG['editmusic_msg_upload_success']

$EditMusicDetails->edit_completed = false;
$CFG['feature']['auto_hide_success_block'] = false;

$EditMusicDetails->LANG_LANGUAGE_ARR = $LANG_LIST_ARR['language'];
$upload_type = $CFG['admin']['musics']['default_upload_type'];
$upload_type_div = 'upload_music_'.strtolower($upload_type);
$upload_block_name = 'block_editmusic_'.strtolower($upload_type).'_form';
if($CFG['admin']['musics'][$upload_type_div])
{
	$EditMusicDetails->show_div = 'sel'.$upload_type.'Content';
}
else
{
	foreach($CFG['admin']['musics']['available_upload_music_types'] as $available_upload_type)//$CFG['admin']['musics']['default_upload_type']
	{
		$upload_type_div = 'upload_music_'.strtolower($available_upload_type);
		$upload_block_name = 'block_editmusic_'.strtolower($available_upload_type).'_form';
		if($CFG['admin']['musics'][$upload_type_div])
		{
			$EditMusicDetails->show_div = 'sel'.$available_upload_type.'Content';
			break;
		}

	}
}
$EditMusicDetails->setPageBlockShow($upload_block_name);
$EditMusicDetails->sanitizeFormInputs($_REQUEST);
if(isAjaxPage())
{
	$EditMusicDetails->LANG['editmusic_step'] = $LANG['editmusic_step1'];
	$EditMusicDetails->LANG['editmusic_step_info'] = $LANG['editmusic_step1_info'];
}
else
{
	//Music Edit Mode
	if($EditMusicDetails->isFormGETed($_GET, 'music_id'))
	{
		if($EditMusicDetails->chkIsEditMode())
		{
			$EditMusicDetails->hidden_arr[] = 'edit_mode';
			$EditMusicDetails->setFormField('edit_mode', 1);
			$EditMusicDetails->setAllPageBlocksHide();
			$EditMusicDetails->populateAudioDetailsForUpload();
			$EditMusicDetails->setPageBlockShow('block_editmusic_step2');
		}
		else
		{
			$EditMusicDetails->setCommonErrorMsg($LANG['common_music_msg_error_sorry']);
			$EditMusicDetails->setPageBlockShow('block_msg_form_error');
			$EditMusicDetails->setPageBlockShow('block_editmusic_step1');
		}
	}

	if($EditMusicDetails->isFormPOSTed($_POST, 'music_upload_type'))
	{
		$EditMusicDetails->setAllPageBlocksHide();

		if ($CFG['admin']['musics']['log_upload_error'])
			{
				$EditMusicDetails->createErrorLogFile('music');
			}

		$EditMusicDetails->sanitizeFormInputs($_POST);
		//Preventing Form submission when the User refreshes the page for Normal Upload (Single Upload)
		if(!empty($_SESSION['new_music_id']))
		{
			$EditMusicDetails->resetFieldsArray();
			$EditMusicDetails->populateAudioDetailsForUpload();
			$EditMusicDetails->setPageBlockShow('block_editmusic_step2');
		}
	}
	elseif($EditMusicDetails->isFormPOSTed($_POST, 'upload_music')) //To Update other fields when uploading #also for edit music updation
	{
		$EditMusicDetails->setAllPageBlocksHide();
		$EditMusicDetails->setStep2CommonFields();
		$EditMusicDetails->sanitizeFormInputs($_POST);
		$EditMusicDetails->validateBasicFields(); //To validate multiple fields (title, artist, album and others)
		$EditMusicDetails->validateCommonFormFields(); //To validate common fields
		if($EditMusicDetails->isValidFormInputs())
		{
			if($EditMusicDetails->getFormField('music_access_type')=='Private')
			{
				$relation_id = implode(',',$EditMusicDetails->getFormField('relation_id'));
				$EditMusicDetails->setFormField('relation_id', $relation_id);
			}
			else
			$EditMusicDetails->setFormField('relation_id','');
			$EditMusicDetails->updateMusicDetailsForUpload();
			$EditMusicDetails->setCommonErrorMsg($LANG['editmusic_msg_update_success']);
			$EditMusicDetails->setPageBlockShow('block_editmusic_step3');

		}
		else
		{
			for($inc=0;$inc<$EditMusicDetails->getFormField('total_musics');$inc++)
			{
				$EditMusicDetails->multi_hidden_arr[$inc] = 'music_id_'.$inc;
				$EditMusicDetails->multi_hidden_arr[$inc+$EditMusicDetails->getFormField('total_musics')] = 'playing_time_'.$inc;
			}
			//$EditMusicDetails->populateAudioDetailsForUpload();
			$EditMusicDetails->setCommonErrorMsg($LANG['common_music_msg_error_sorry']);
			$EditMusicDetails->setPageBlockShow('block_msg_form_error');
			$EditMusicDetails->setPageBlockShow('block_editmusic_step2');
		}
	}
	else
	{
		$_SESSION['new_music_id'] = array();
	}
}
if($EditMusicDetails->isShowPageBlock('block_editmusic_step2'))
{
	$EditMusicDetails->LANG['editmusic_step'] = $LANG['editmusic_step2'];
	$EditMusicDetails->LANG['editmusic_step_info'] = $LANG['editmusic_step2_info'];
    $EditMusicDetails->editmusic_tags_msg = str_replace(array('{tag_min_chars}','{tag_max_chars}'),
											array($CFG['fieldsize']['music_tags']['min'],$CFG['fieldsize']['music_tags']['max']),
												$LANG['editmusic_tags_msg1']);

	$EditMusicDetails->content_filter = false;
	if($EditMusicDetails->chkAllowedModule(array('content_filter')) && isAdultUser('','music'))
	{
		$EditMusicDetails->content_filter = true;
		$EditMusicDetails->Porn = $EditMusicDetails->General = 'none';
		$music_category_type = $EditMusicDetails->getFormField('music_category_type');
		$$music_category_type = '';
	}
	else
	{
		$EditMusicDetails->Porn = $EditMusicDetails->General = '';
	}
	if($EditMusicDetails->getFormField('music_category_type') == 'General')
	{
		$EditMusicDetails->General ='';
	}
	else
	{
		$EditMusicDetails->Porn = '';
	}
}

$EditMusicDetails->includeHeader();
if ($CFG['admin']['musics']['upload_music_multiupload'])
	{
?>
<link href="<?php echo $CFG['site']['url'].'music/design/templates/'.$CFG['html']['template']['default'].'/root/css/'.$CFG['html']['stylesheet']['screen']['default'].'/swfupload/default.css'; ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $CFG['site']['url']; ?>js/SWFUpload/swfupload.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url']; ?>js/SWFUpload/plugins/swfupload.queue.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url']; ?>js/SWFUpload/others/fileprogress.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url']; ?>js/SWFUpload/others/handlers.js"></script>
<?php
	}
?>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url']; ?>js/lib/validation/validation.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/lib/autocomplete.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/JSFCommunicator.js"></script>
<script type="text/javascript">
var redirect_url="<?php echo $EditMusicDetails->getUrl('musiclist', '?pg=musicnew', 'musicnew/', '', 'music'); ?>";
J_PHOTOBALLOONWIDTH = '200';
	function saveAudio()
		{
			$Jq('#music_upload_form_record').submit();
		}
	var lang_change_image = '<?php echo $LANG['editmusic_change_image']; ?>';
	var lang_keep_old_image = '<?php echo $LANG['editmusic_keep_old_image']; ?>';
</script>
<?php

if($EditMusicDetails->isShowPageBlock('block_editmusic_recordaudio_form'))
	{
		$EditMusicDetails->generateAudioRecorderSettings();
	}
if($EditMusicDetails->isShowPageBlock('block_editmusic_multiupload_form'))
	{
		$EditMusicDetails->loadFilesForSwfUpload();
	}
//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$EditMusicDetails->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'music');
$smartyObj->display('editMusicDetails.tpl');

if($EditMusicDetails->isShowPageBlock('block_editmusic_step1'))
	{
		$more_tabs_div = 'var more_tabs_div = new Array(';
		$more_tabs_class = 'var more_tabs_class = new Array(';
		if ($CFG['admin']['musics']['upload_music_multiupload'])
			{
				$more_tabs_div .= "'selMultiUploadContent'";
				$more_tabs_class .= "'selHeaderMultiUpload'";
				if ($CFG['admin']['musics']['upload_music_normalupload']
					OR $CFG['admin']['musics']['upload_music_externalupload']
					 	OR $CFG['admin']['musics']['upload_music_recordaudio'])
					{
						$more_tabs_div .= ',';
						$more_tabs_class .= ',';
					}
			}

		if ($CFG['admin']['musics']['upload_music_normalupload'])
			{
				$more_tabs_div .= "'selNormalUploadContent'";
				$more_tabs_class .= "'selHeaderNormalUpload'";
				if ($CFG['admin']['musics']['upload_music_externalupload']
					 OR $CFG['admin']['musics']['upload_music_recordaudio'])
					{
						$more_tabs_div .= ',';
						$more_tabs_class .= ',';
					}
			}

		if ($CFG['admin']['musics']['upload_music_externalupload'])
			{
				$more_tabs_div .= "'selExternalUploadContent'";
				$more_tabs_class .= "'selHeaderExternalUpload'";
				if ($CFG['admin']['musics']['upload_music_recordaudio'])
					{
						$more_tabs_div .= ',';
						$more_tabs_class .= ',';
					}
			}

		if ($CFG['admin']['musics']['upload_music_recordaudio'])
			{
				$more_tabs_div .= "'selRecordAudioContent'";
				$more_tabs_class .= "'selHeaderRecordAudio'";
			}
		$more_tabs_div .= ');';
		$more_tabs_class .= ');';
?>
<script type="text/javascript">
var show_div = '<?php echo $EditMusicDetails->show_div; ?>';
/*var more_tabs_div = new Array('selMultiUploadContent', 'selNormalUploadContent', 'selExternalUploadContent', 'selRecordAudioContent');
var more_tabs_class = new Array('selHeaderMultiUpload', 'selHeaderNormalUpload', 'selHeaderExternalUpload', 'selHeaderRecordAudio');*/
<?php
	echo $more_tabs_div;
	echo $more_tabs_class;
?>
var current_active_tab_class = 'clsActive';

$Jq(document).ready(function(){
	//To Show the default div and hide the other divs
	hideMoreTabsDivs(show_div); //To hide the more tabs div and set the class to empty
	showMoreTabsDivs(show_div); //To show the more tabs div and set the class to selected
});

function loadUploadType(path, div_id, current_li_id)
{
	//result_div = div_id;
	/*more_li_id = current_li_id;
	hideMoreTabsDivs(div_id);
	showMoreTabsDivs(div_id);*/
	var div_value = $(div_id).innerHTML;
	result_div = div_id;
	more_li_id = current_li_id;
	div_value = div_value.strip();
	if(div_value == '')
		{
			hideMoreTabsDivs(div_id);
			showMoreTabsDivs(div_id);
			$Jq('#' + div_id).html(music_ajax_page_loading);
			new jquery_ajax(path, '', 'insertUploadContent');
		}
	else
		{
			hideMoreTabsDivs(div_id);
			showMoreTabsDivs(div_id);
		}
}

function insertUploadContent(data)
{
	data = unescape(data);
	var script_data = '';
	var obj = document.getElementById(result_div);
	obj.style.display = 'block';
	if(result_div == 'selMultiUploadContent')
		{
			if(data.indexOf('#~~~#')>=1)
				{
					data = data.split('#~~~#');
					script_data = data[0];
					data = data[1];
				}
		}
	obj.innerHTML = data;
	if(script_data != '')
		eval(script_data);
	//$(obj).show();
	//setClass(more_li_id,'clsActiveMoreVideosNavLink');
}

</script>
<?php
	}
?>
<script type="text/javascript">
var block_arr= new Array('selMsgConfirm', 'selAudioAlbumComments');
var lang_album_price = '<?php echo $LANG['editmusic_album_price'];?>';
var lang_music_price = '<?php echo $LANG['editmusic_music_price'];?>';
function checkIsPublic(id)
{
	if($Jq('#album_access_type_'+id).attr('checked') == true)
	{
		$Jq('#selAlbumId_'+id).css('display', 'block');
		$Jq('#selAlbumName_'+id).css('display', 'none');
		$Jq('#music_album_id_'+id).val('');
		disabledFormFields(Array('music_price_'+id));
		enabledFormFields(Array('preview_start_'+id, 'preview_end_'+id));
	}
	else
	{
		<?php
		if($CFG['admin']['musics']['allow_members_to_choose_the_preview'])
		{
		?>
			disabledFormFields(Array('preview_start_'+id, 'preview_end_'+id));
		<?php
		}
		?>
		$Jq('#music_price_'+id).val('0');
		$Jq('#selAlbumId_'+id).css('display', 'none');
		$Jq('#selAlbumName_'+id).css('display', 'block');
		$Jq('#music_album_id_'+id).val('');
		$Jq('#for_sale_'+id+'_2').attr('checked', true);
		enabledFormFields(Array('for_sale_'+id+'_1', 'for_sale_'+id+'_2'))
		disabledFormFields(Array('music_price_'+id));
		$Jq('#selPriceDetails').html('<?php echo $LANG['editmusic_music_price'].'('.$CFG['currency'].')';?>');
	}
}
function setRequiredClass(div_id)
{
	var obj = document.getElementById(div_id);
	obj.setAttribute("class", "clsTextField clsYearField required")
}
function setNotRequiredClass(div_id)
{
	var obj = document.getElementById(div_id);
	obj.setAttribute("class", "clsTextField clsYearField")
	obj.value='';
}
function redirectEdit()
{
  window.location.href='<?php echo $CFG['site']['url'].'admin/music/editMusic.php';?>';
}
function populateMusicSubCategory(cat)
{
	var url = '<?php echo $CFG['site']['music_url'].'musicUploadPopUp.php';?>';
		var pars = 'ajax_page=true&cid='+cat;
		<?php if($EditMusicDetails->getFormField('music_sub_category_id')){?>
		pars = pars+'&music_sub_category_id=<?php echo $EditMusicDetails->getFormField('music_sub_category_id');?>';
		<?php }?>
		var method_type = 'post';
		populateSubCategoryRequest(url, pars, method_type);
}
<?php if($EditMusicDetails->getFormField('music_category_id')){?>
	populateMusicSubCategory('<?php echo $EditMusicDetails->getFormField('music_category_id'); ?>');
<?php }?>
</script>
<?php
if ($CFG['feature']['jquery_validation'])
{
	$music_title_arr_rules='';
	$music_title_arr_messages='';
	$music_artist_arr_rules	= '';
	$music_artist_arr_messages = '';
	$music_year_released_arr_rules	= '';
	$music_year_released_arr_messages = '';
	for($i=0;$i<$EditMusicDetails->getFormField('total_musics');$i++)
	{
		$music_title_id = 'music_title_'.$i;
		$music_title_arr_rules .= '"'.$music_title_id.'":{ required:true },';
		$music_title_arr_messages .= '"'.$music_title_id.'":{ required:"'.$LANG['common_err_tip_required'].'"},';
		if($CFG['admin']['musics']['music_upload_artist_name_compulsory'])
		{
			$music_artist_id = 'music_artist_'.$i;
			$music_artist_arr_rules .= '"'.$music_artist_id.'":{ required:true },';
			$music_artist_arr_messages .= '"'.$music_artist_id.'":{ required:"'.$LANG['common_err_tip_required'].'"},';
		}
		if($CFG['admin']['musics']['music_upload_release_year_compulsory'])
		{
			$music_year_released_id = 'music_year_released_'.$i;
			$music_year_released_arr_rules .= '"'.$music_artist_id.'":{ required:true },';
			$music_year_released_arr_messages .= '"'.$music_artist_id.'":{ required:"'.$LANG['common_err_tip_required'].'"},';
		}
	}

	if($CFG['admin']['musics']['music_upload_artist_name_compulsory'])
	{
		$music_artist_rule	= "music_category_id_general: {
			    	required: true
			    }";
		$music_artist_message = "";
	}
	?>
	<script type="text/javascript">
		$Jq("#music_upload_form").validate({
			rules: {
				<?php
					echo $music_title_arr_rules;
					echo $music_artist_arr_rules;
					echo $music_year_released_arr_rules;
				?>
			    music_category_id_general: {
			    	required: true
			    },
			    music_tags: {
					required: true
			    }
			},
			messages: {
				<?php
					echo $music_title_arr_messages;
					echo $music_artist_arr_messages;
					echo $music_year_released_arr_messages;
				?>
				music_category_id_general: {
					required: "<?php echo $LANG['common_err_tip_required'];?>"
				},
				music_tags: {
					required: "<?php echo $LANG['common_err_tip_required'];?>"
				}
			}
		});
	</script>
<?php
}
$EditMusicDetails->includeFooter();
?>
