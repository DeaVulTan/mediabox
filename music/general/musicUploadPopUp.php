<?php
/**
 * MusicUpload
 *
 * @package		general
 * @author 		shankar_76ag05
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @access 		public
 **/
class MusicUpload extends MusicUploadLib
	{
		public $music_url = '';
		public $hidden_arr = array();
		public $multi_hidden_arr = array();
		public $fp = false;

		/**
		 * MusicUpload::validationFormFields1()
		 *
		 * @return void
		 */
		public function validationFormFields1()
			{
				$this->chkIsNotEmpty('music_category_id', $this->LANG['common_err_tip_required']);
				$this->chkIsNotEmpty('music_title', $this->LANG['common_err_tip_required']);
				$this->chkIsNotEmpty('music_tags', $this->LANG['common_err_tip_required']) and
					$this->chkValidTagList('music_tags',$this->LANG['common_err_tip_invalid_tag']);
				$this->checkValidDate($this->LANG['musicupload_err_tip_invalid_date']);
			}

		/**
		 * MusicUpload::chkIsEditMode()
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

		/*public function setCommonFormFields()
			{
				$this->setFormField('location_recorded', $this->getFormField('location'));
				$this->setFormField('country_recorded', $this->getFormField('country'));
				$this->setFormField('zip_code_recorded', $this->getFormField('zip_code'));
				$this->setFormField('date_recorded', $this->getFormField('year').'-'.$this->getFormField('month').'-'.$this->getFormField('day'));
				if($this->getFormField('music_access_type')=='Private')
					{
						$relation_id = implode(',',$this->getFormField('relation_id'));
						$this->setFormField('relation_id',$relation_id);
					}
				else
					$this->setFormField('relation_id','');
			}*/

		/**
		 * MusicUpload::chkFileIsNotEmpty()
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
		 * MusicUpload::chkFileNameIsNotEmpty()
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
		 * MusicUpload::chkValidMusicFileType()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 **/
		public function chkValidMusicFileType($field_name, $err_tip = '')
			{
				$this->chkValidFileType($field_name, $this->CFG['admin']['musics']['format_arr'], $err_tip = '');
			}

		/**
		 * MusicUpload::chkValidExternalFileType()
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
		 * MusicUpload::chkValidMusicFileSize()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 **/
		public function chkValidMusicFileSize($field_name, $err_tip='')
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
		 * MusicUpload::chkErrorInFile()
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
		 * MusicUpload::chkValidImageType()
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
		 * MusicUpload::chkValidImageSize()
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
		 * MusicUpload::chkIsFile()
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
						$temp_dir = $this->CFG['admin']['musics']['temp_folder'];
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
		 * MusicUpload::loadFilesForSwfUpload()
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
								upload_url: "musicBulkUpload.php",
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
								// button_image_url : "../js/SWFUpload/images/XPButtonUploadText_61x22.png",
								// button_placeholder_id : "spanButtonPlaceholder1",
								// button_width: 61,
								// button_height: 22,
								button_placeholder_id : "spanButtonPlaceholder1",
								button_width: 42,
								button_height: 22,
								button_text : '<span class="button"><?php echo $this->LANG['musicupload_browse_file']; ?></span>',
								button_text_style : '.button { font-family: Arial, sans-serif; font-size: 11px; font-weight: normal; padding:10px; color: #ffffff; height:30px; }',
								button_text_top_padding: 2,
								button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
								button_cursor: SWFUpload.CURSOR.HAND,

								// Flash Settings
								flash_url : "../js/SWFUpload/Flash/swfupload.swf",


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
		 * MusicUpload::isValidFormInputsMultiUpload()
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
		 * MusicUpload::populateAudioDetailsForUpload()
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
				$add =' user_id=\''.$this->CFG['user']['user_id'].'\' AND ';

			foreach($_SESSION['new_music_id'] as $key => $music_id)
			{
				$sql = 'SELECT music_title, playing_time, music_album_id, user_id, music_artist, music_status, '.
						' music_thumb_ext, music_ext, music_caption, music_tags, music_access_type,'.
						' music_server_url, allow_comments, allow_ratings, allow_embed, allow_lyrics,'.
						' allow_download, music_language, music_year_released, relation_id, '.
						' music_category_id, music_sub_category_id,  preview_start,preview_end,music_price,for_sale'.
						' FROM '.$this->CFG['db']['tbl']['music'].' WHERE'.
						$add.
						' music_id='.$this->dbObj->Param('music_id').' LIMIT 0,1'; //music_status=\'Ok\' AND'.

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($music_id));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

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

					//echo $row['music_thumb_ext'];
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
		 * MusicUpload::setStep2CommonFields()
		 *
		 * @return void
		 */
		public function setStep2CommonFields()
		{
			if(isset($_POST['music_category_id_general']))
				$_POST['music_category_id'] = $_POST['music_category_id_general'];
			else
				$_POST['music_category_id'] = isset($_POST['music_category_id_porn'])?$_POST['music_category_id_porn']:'';

			$this->update_table_fields_arr = array('music_title', 'music_album_id', 'music_artist',
												 'music_caption', 'music_year_released',
												 'music_category_id', 'music_sub_category_id', 'music_tags',
												 'music_language', 'music_access_type', 'relation_id',
												 'allow_comments', 'allow_ratings',
												 'allow_embed', 'allow_lyrics', 'step_status','for_sale',
												 'music_price','preview_start','preview_end');

			$this->multiple_fields_arr = array('music_title', 'music_artist', 'music_album_id',
												'music_year_released', 'music_thumb_ext','music_caption','for_sale',
												 'music_price','preview_start','preview_end');
			for($i=0;$i<$this->getFormField('total_musics');$i++)
			{
				$this->setFormField('music_id_'.$i, '');
				$this->setFormField('music_title_'.$i, '');
				$this->setFormField('music_album_'.$i, '');
				$this->setFormField('music_album_id_'.$i, '');
				$this->setFormField('album_id_'.$i, '');
				$this->setFormField('music_album_name_'.$i, '');
				$this->setFormField('album_access_type_'.$i, '');
				$this->setFormField('album_price_'.$i, '');
				$this->setFormField('music_artist_'.$i, '');
				$this->setFormField('music_old_artist_'.$i, '');
				$this->setFormField('music_thumb_ext_'.$i, '');
				$this->setFormField('music_year_released_'.$i, '');
				$this->setFormField('music_thumb_image_'.$i, '');
				$this->setFormField('music_thumb_folder_'.$i, '');
				$this->setFormField('music_status_'.$i, '');
				$this->setFormField('music_caption_'.$i, '');
				$this->setFormField('for_sale_'.$i, '');
				$this->setFormField('music_price_'.$i, '');
				$this->setFormField('preview_start_'.$i, '');
				$this->setFormField('preview_end_'.$i, '');
				$this->setFormField('playing_time_'.$i, '');
			}
			$this->setFormField('step_status', 'Ok');
		}

		/**
		 * MusicUpload::getExistingAlbumId()
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
				trigger_db_error($this->dbObj);
			if($row = $rs->FetchRow())
			{
				return $row['music_album_id'];
			}
			return true;
		}
		/**
		 * MusicUpload::checkAlbum()
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
				trigger_db_error($this->dbObj);
			if($row = $rs->FetchRow())
			{
				if($row['preview_start']!=$preview_start or $row['preview_end']!=$preview_end)
					return true;

				return false;
			}
		}

		/**
		 * MusicUpload::updateMusicDetailsForUpload()
		 *
		 * @return void
		 */
		public function updateMusicDetailsForUpload()
		{
			//Check Album exists else Insert Album
			$this->checkAlbum();
			for($i=0;$i<$this->getFormField('total_musics');$i++)
			{
				//if($this->fields_arr['preview_start'.$i]=='')
				if($this->fields_arr['music_year_released_'.$i] == '')
					$this->setFormField('music_year_released_'.$i, NULL);

				$music_id = $this->fields_arr['music_id_'.$i];
				$preview_start = $this->fields_arr['preview_start_'.$i];
				$preview_end = $this->fields_arr['preview_end_'.$i];
				$music_name = $this->getMusicName($music_id);
				$music_thumb_name = $this->getMusicImageName($music_id);

				$album_details = getMusicAlbumDetails($this->fields_arr['music_album_id_'.$i]);
				//Have modified the condition to check the album is set as sale/
				if($this->chkValueDiffers($music_id, $preview_start, $preview_end ))
				{
					if(($album_details['album_for_sale']=='Yes'
						AND $album_details['album_price']>0
						AND $album_details['album_access_type']=='Private')
						OR $this->fields_arr['for_sale_'.$i]=='Yes')
					{
						$this->trimMusic($music_id, $preview_start, $preview_end);
					}
				}

				if(($album_details['album_for_sale']=='No'
						OR $album_details['album_price']<0
						OR $album_details['album_access_type']=='Public')
						AND $this->fields_arr['for_sale_'.$i]=='No')
				{
					$music_preview_start_key = array_search('preview_start', $this->update_table_fields_arr);
					unset($this->update_table_fields_arr[$music_preview_start_key]);
					$music_preview_end_key = array_search('preview_end', $this->update_table_fields_arr);
					unset($this->update_table_fields_arr[$music_preview_end_key]);
				}


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

				$sql .= ' WHERE music_id='.$this->dbObj->Param('music_id_'.$i).
						' AND user_id='.$this->dbObj->Param('user_id');

				$param_value_arr[] = $this->fields_arr['music_id_'.$i];
				$param_value_arr[] = $this->CFG['user']['user_id'];


				//echo $sql.'<br><br>'; echo $this->fields_arr['music_id']; //die();
				//$this->music_id = $this->fields_arr['music_id'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $param_value_arr);

				if (!$rs)
				    trigger_db_error($this->dbObj);

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

		/**
		 * MusicUpload::populateMusicCatagory()
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
			    trigger_db_error($this->dbObj);

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
		 * MusicUpload::populateMusicSubCatagory()
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
			    trigger_db_error($this->dbObj);

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
		 * MusicUpload::validateBasicFields()
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
				$this->chkIsValidPreviewEnd('preview_start_'.$i, 'preview_end_'.$i, 'playing_time_'.$i,
										 $this->LANG['musicupload_msg_end_time_valid']);
				if(isset($this->fields_arr['music_year_released_'.$i]) && $this->fields_arr['music_year_released_'.$i] != '')
				{
					$this->chkIsNumeric('music_year_released_'.$i, $this->LANG['musicupload_year_invalid']);
					if(strlen($this->fields_arr['music_year_released_'.$i])<4)
						$this->setFormFieldErrorTip('music_year_released_'.$i, $this->LANG['musicupload_year_invalid']);
				}

				if(isset($_FILES['music_thumb_image_'.$i]) and !empty($_FILES['music_thumb_image_'.$i]['name']))
				{
					$this->chkFileNameIsNotEmpty('music_thumb_image_'.$i, $this->LANG['common_music_err_tip_required']) and
					$this->chkValidImageType('music_thumb_image_'.$i, $this->LANG['common_music_err_tip_invalid_image_type']) and
					$this->chkValidImageSize('music_thumb_image_'.$i, $this->LANG['common_music_err_tip_invalid_image_size']) and
					$this->chkErrorInFile('music_thumb_image_'.$i, $this->LANG['common_music_err_tip_invalid_file']);
				}

				if($this->fields_arr['album_access_type_'.$i] == 'Private' and empty($this->fields_arr['music_album_id_'.$i]))
					$this->setFormFieldErrorTip('music_album_id_'.$i, $this->LANG['common_music_err_tip_compulsory']);
			}
		}

		/**
		 * MusicUpload::validateCommonFormFields()
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
		 * MusicUpload::chkIsFileOk()
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
		 * MusicUpload::chkIsValidPath()
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
		 * MusicUpload::generateAudioRecorderSettings()
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
		 * MusicUpload::chkIsValidRecordedFile()
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
				$this->LANG['musicupload_music_duration'] = str_replace('VAR_DURATION', $duration, $this->LANG['musicupload_music_duration']);
				if($this->getFormField($preview_start)> $duration)
				{
					$this->fields_err_tip_arr[$preview_start] = $this->LANG['musicupload_msg_start_exceeds_time_valid'].$this->LANG['musicupload_music_duration'];
					return false;
				}
				if($this->getFormField($preview_end)> $duration)
				{
					$this->fields_err_tip_arr[$preview_end] = $this->LANG['musicupload_msg_end_exceeds_time_valid'].$this->LANG['musicupload_music_duration'];
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

	}

$MusicUpload = new MusicUpload();

if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

//CHECKED THE CONDITION IF ALLOWED THE MUSIC UPLOAD FOR FAN MEMBER
if(!isAllowedMusicUpload())
	Redirect2URL(getUrl('musiclist', '?pg=upload_music', 'upload_music/', '', 'music'));

$MusicUpload->setPageBlockNames(array('block_musicupload_step1', 'block_musicupload_step2', 'music_upload_form',
									'block_musicupload_normalupload_form', 'block_musicupload_multiupload_form',
									'block_musicupload_externalupload_form', 'block_musicupload_recordaudio_form'));

//Set media path
$MusicUpload->setMediaPath('../');
//$_SESSION['new_music_id'] = array();
$MusicUpload->music_uploaded_success = true;
//Default Upload tab
$MusicUpload->show_div = '';

if(strpos($CFG['site']['current_url'], '/admin/'))
	$MusicUpload->left_navigation_div = 'musicMain';
//default form fields and values...
$MusicUpload->resetFieldsArray();
$MusicUpload->setFormField('music_upload_type', 'Normal');

$MusicUpload->setAllPageBlocksHide();
$MusicUpload->setPageBlockShow('block_musicupload_step1');
$MusicUpload->hidden_arr = array('total_musics');

$MusicUpload->music_format =  implode(', ', $CFG['admin']['musics']['format_arr']);
$MusicUpload->music_image_format =  implode(', ', $CFG['admin']['musics']['image_format_arr']);

$LANG['music_common_err_tip_invalid_tag'] = str_replace('VAR_MIN', $CFG['fieldsize']['music_tags']['min'],
													$LANG['common_music_err_tip_invalid_tag']);
$LANG['music_common_err_tip_invalid_tag'] = str_replace('VAR_MAX', $CFG['fieldsize']['music_tags']['max'],
													$LANG['music_common_err_tip_invalid_tag']);

$MusicUpload->musicupload_artist_note_msg = str_replace('VAR_ARTIST_MIN_CHARS', $CFG['fieldsize']['music_artist']['min'],
													$LANG['musicupload_artist_note']);
$MusicUpload->musicupload_artist_note_msg = str_replace('VAR_ARTIST_MAX_CHARS', $CFG['fieldsize']['music_artist']['max'],
													$MusicUpload->musicupload_artist_note_msg);

$MusicUpload->musicupload_multi_upload_info = str_replace('VAR_FILES_MAX_LIMIT', $CFG['admin']['musics']['multi_upload_files_limit'],
													$LANG['musicupload_multi_upload_info']);

$MusicUpload->musicupload_msg_success_uploaded = ($CFG['admin']['musics']['music_auto_encode'] and $CFG['admin']['musics']['music_auto_activate'])?$LANG['musicupload_msg_success_uploaded_auto']:$LANG['musicupload_msg_success_uploaded_admin'];
//$LANG['musicupload_msg_upload_success']

$MusicUpload->edit_completed = false;
$CFG['feature']['auto_hide_success_block'] = false;

$MusicUpload->LANG_LANGUAGE_ARR = $LANG_LIST_ARR['language'];
$upload_type = $CFG['admin']['musics']['default_upload_type'];
$upload_type_div = 'upload_music_'.strtolower($upload_type);
$upload_block_name = 'block_musicupload_'.strtolower($upload_type).'_form';
if($CFG['admin']['musics'][$upload_type_div])
{
	$MusicUpload->show_div = 'sel'.$upload_type.'Content';
}
else
{
	foreach($CFG['admin']['musics']['available_upload_music_types'] as $available_upload_type)//$CFG['admin']['musics']['default_upload_type']
	{
		$upload_type_div = 'upload_music_'.strtolower($available_upload_type);
		$upload_block_name = 'block_musicupload_'.strtolower($available_upload_type).'_form';
		if($CFG['admin']['musics'][$upload_type_div])
		{
			$MusicUpload->show_div = 'sel'.$available_upload_type.'Content';
			break;
		}

	}
}
$MusicUpload->setPageBlockShow($upload_block_name);

$MusicUpload->sanitizeFormInputs($_REQUEST);
if(isAjaxPage())
{
	$MusicUpload->LANG['musicupload_step'] = $LANG['musicupload_step1'];
	$MusicUpload->LANG['musicupload_step_info'] = $LANG['musicupload_step1_info'];
	$MusicUpload->allowed_file_formats = implode(';*.', $CFG['admin']['musics']['format_arr']);
	if($MusicUpload->getFormField('pg') == 'multiupload')
	{
		$_SESSION['new_music_id'] = array();
		$MusicUpload->setPageBlockShow('block_musicupload_multiupload_form');
		$MusicUpload->includeAjaxHeader();
		$MusicUpload->loadFilesForSwfUpload();
		echo '#~~~#';
		setTemplateFolder('general/', 'music');
		$smartyObj->display('multiUpload.tpl');
		$MusicUpload->includeAjaxFooter();
		exit;
	}
	elseif($MusicUpload->getFormField('pg') == 'normal')
	{
		$_SESSION['new_music_id'] = array();
		$MusicUpload->setPageBlockShow('block_musicupload_normalupload_form');
		$MusicUpload->includeAjaxHeader();
		setTemplateFolder('general/', 'music');
		$smartyObj->display('normalUpload.tpl');
		$MusicUpload->includeAjaxFooter();
		exit;
	}
	elseif($MusicUpload->getFormField('pg') == 'external')
	{
		if(!$CFG['admin']['musics']['external_music_download'])
			{
				$MusicUpload->music_format = 'mp3';
			}

		$_SESSION['new_music_id'] = array();
		$MusicUpload->setPageBlockShow('block_musicupload_externalupload_form');
		$MusicUpload->includeAjaxHeader();
		setTemplateFolder('general/', 'music');
		$smartyObj->display('externalUpload.tpl');
		$MusicUpload->includeAjaxFooter();
		exit;
	}
	elseif($MusicUpload->getFormField('pg') == 'record')
	{
		$_SESSION['new_music_id'] = array();
		$MusicUpload->generateAudioRecorderSettings();
		$MusicUpload->setPageBlockShow('block_musicupload_recordaudio_form');
		$MusicUpload->includeAjaxHeader();
		setTemplateFolder('general/', 'music');
		$smartyObj->display('recordAudio.tpl');
		$MusicUpload->includeAjaxFooter();
		exit;
	}
	elseif($MusicUpload->isFormPOSTed($_POST, 'cid')) //Populate SubCategory
	{
		$MusicUpload->includeAjaxHeaderSessionCheck();
		$MusicUpload->populateMusicSubCatagory($MusicUpload->getFormField('cid'));
		$MusicUpload->includeAjaxFooter();
		exit;
	}
	elseif($MusicUpload->getFormField('pg') == 'get_albums')
	{
		$MusicUpload->includeAjaxHeader();
		$album_title = $MusicUpload->populateMusicAlbums($MusicUpload->getFormField('query'));
		if(!empty($album_title))
		{
			echo "{\nquery:".json_encode($MusicUpload->getFormField('query')).",\n";
			echo "suggestions:".json_encode($album_title).",\n";
			echo "data:".json_encode($album_title)."\n}";
		}
		else
		{
			echo "{\nquery:".json_encode($MusicUpload->getFormField('query')).",\n";
			echo "suggestions:[]".",\n";
			echo "data:[]"."\n}";
		}
		$MusicUpload->includeAjaxFooter();
		exit;
	}
	elseif($MusicUpload->getFormField('pg') == 'get_artists')
	{
		$MusicUpload->includeAjaxHeader();
		$artist_name = $MusicUpload->populateMusicArtists($MusicUpload->getFormField('query'));
		if(!empty($artist_name))
		{
			echo "{\nquery:".json_encode($MusicUpload->getFormField('query')).",\n";
			echo "suggestions:".json_encode($artist_name).",\n";
			echo "data:".json_encode($artist_name)."\n}";
		}
		else
		{
			echo "{\nquery:".json_encode($MusicUpload->getFormField('query')).",\n";
			echo "suggestions:[]".",\n";
			echo "data:[]"."\n}";
		}
		$MusicUpload->includeAjaxFooter();
		exit;
	}
}
else
{
	$MusicUpload->allowed_file_formats = implode(';*.', $CFG['admin']['musics']['format_arr']);
	//Music Edit Mode
	if($MusicUpload->isFormGETed($_GET, 'music_id'))
	{
		if($MusicUpload->chkIsEditMode())
		{
			$MusicUpload->hidden_arr[] = 'edit_mode';
			$MusicUpload->setFormField('edit_mode', 1);
			$MusicUpload->setAllPageBlocksHide();
			$MusicUpload->populateAudioDetailsForUpload();
			$MusicUpload->setPageBlockShow('block_musicupload_step2');
		}
		else
		{
			$MusicUpload->setCommonErrorMsg($LANG['common_music_msg_error_sorry']);
			$MusicUpload->setPageBlockShow('block_msg_form_error');
			$MusicUpload->setPageBlockShow('block_musicupload_step1');
		}
	}

	if($MusicUpload->isFormPOSTed($_POST, 'music_upload_type'))
	{
		$MusicUpload->setAllPageBlocksHide();

		if ($CFG['admin']['musics']['log_upload_error'])
			{
				$MusicUpload->createErrorLogFile('music');
			}

		$MusicUpload->sanitizeFormInputs($_POST);
		//Preventing Form submission when the User refreshes the page for Normal Upload (Single Upload)
		if(!empty($_SESSION['new_music_id']))
		{
			$MusicUpload->resetFieldsArray();
			$MusicUpload->populateAudioDetailsForUpload();
			$MusicUpload->setPageBlockShow('block_musicupload_step2');
		}
		elseif($MusicUpload->getFormField('music_upload_type') == 'Normal')
		{
			//when the user upload files using Normal file upload
			if($MusicUpload->isFormPOSTed($_POST, 'upload_music_normal'))
				{
					$MusicUpload->chkFileIsNotEmpty('music_file', $LANG['common_music_err_tip_no_file']) and
						$MusicUpload->chkFileNameIsNotEmpty('music_file', $LANG['common_music_err_tip_required']) and
							$MusicUpload->chkValidMusicFileType('music_file', $LANG['common_music_err_tip_invalid_file_type']) and
								$MusicUpload->chkValidMusicFileSize('music_file', $LANG['common_music_err_tip_invalid_file_size']) and
									$MusicUpload->chkErrorInFile('music_file', $LANG['common_music_err_tip_invalid_file']);

					$MusicUpload->show_div = 'selNormalUploadContent';
					$MusicUpload->setPageBlockShow('block_musicupload_normalupload_form');
				}
			else
				{
					$MusicUpload->chkIsFile($LANG['err_tip_compulsory']);
				}


			if($MusicUpload->isValidFormInputs())
			{
				//if($valid_music_upload_env = $MusicUpload->chkMusicUploadEnvironment())
					{
						//$MusicUpload->chkMusicAlbumSelected();
						//$MusicUpload->addNewMusic();
						/*if ($CFG['admin']['log_music_upload_error'])
							{
								$MusicUpload->closeErrorLogFile();
							}*/

						$MusicUpload->setAllPageBlocksHide();
						//$MusicUpload->addNewMusic();
						$MusicUpload->addNewMusic();

						if($MusicUpload->music_uploaded_success)
						{
							$MusicUpload->resetFieldsArray();
							$MusicUpload->populateAudioDetailsForUpload();
							$MusicUpload->setPageBlockShow('block_musicupload_step2');
							$MusicUpload->setCommonSuccessMsg($LANG['musicupload_msg_upload_success']);
							$MusicUpload->setPageBlockShow('block_msg_form_success');
						}
						else
						{
							$MusicUpload->setCommonErrorMsg($LANG['msg_failure_uploaded']);
							$MusicUpload->setPageBlockShow('block_musicupload_step1');
							$MusicUpload->setPageBlockShow('block_msg_form_error');
							$MusicUpload->setPageBlockShow('block_musicupload_normalupload_form');
						}
					}
				/*else
					{
						$MusicUpload->setCommonErrorMsg($LANG['musicupload_msg_error_sorry'].' '.$MusicUpload->MUSIC_UPLOAD_ENV_ERR);
						$MusicUpload->setPageBlockShow('block_msg_form_error');
						$MusicUpload->setPageBlockShow('music_upload_form_file');
					}*/
			}
			else
			{
				$MusicUpload->setCommonErrorMsg($LANG['musicupload_multiupload_msg_error']);
				$MusicUpload->setPageBlockShow('block_msg_form_error');
				$MusicUpload->setPageBlockShow('block_musicupload_step1');
				$MusicUpload->setPageBlockShow('block_musicupload_normalupload_form');
			}

		}
		elseif($MusicUpload->getFormField('music_upload_type') == 'MultiUpload')
		{
			if($MusicUpload->isValidFormInputsMultiUpload())
			{
				$MusicUpload->populateAudioDetailsForUpload();
				$MusicUpload->setPageBlockShow('block_musicupload_step2');
				$MusicUpload->setCommonSuccessMsg($LANG['musicupload_msg_upload_success']);
				$MusicUpload->setPageBlockShow('block_msg_form_success');
			}
			else
			{
				$MusicUpload->setCommonErrorMsg($LANG['musicupload_multiupload_msg_error']);
				$MusicUpload->setPageBlockShow('block_msg_form_error');
				$MusicUpload->setPageBlockShow('block_musicupload_step1');
				$MusicUpload->setPageBlockShow('block_musicupload_multiupload_form');
				$MusicUpload->show_div = 'selMultiUploadContent';
			}
		}
		elseif($MusicUpload->getFormField('music_upload_type') == 'External')
		{
			$MusicUpload->chkIsNotEmpty('music_external_file', $LANG['common_music_err_tip_required']) and
				$MusicUpload->chkIsValidURL('music_external_file', $LANG['common_music_err_tip_invalid_url']) and
					$MusicUpload->chkIsValidPath('music_external_file', $LANG['common_music_err_tip_invalid_url']) and
						$MusicUpload->chkValidExternalFileType('music_external_file', $LANG['common_music_err_tip_invalid_file_type']);

			if($MusicUpload->isValidFormInputs())
			{
				$MusicUpload->addNewMusic();
				if($MusicUpload->music_uploaded_success)
				{
					$MusicUpload->populateAudioDetailsForUpload();
					$MusicUpload->setPageBlockShow('block_musicupload_step2');
					$MusicUpload->setCommonSuccessMsg($LANG['musicupload_msg_upload_success']);
					$MusicUpload->setPageBlockShow('block_msg_form_success');
				}
			}
			else
			{
				$MusicUpload->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$MusicUpload->setPageBlockShow('block_msg_form_error');
				$MusicUpload->setPageBlockShow('block_musicupload_step1');
				$MusicUpload->setPageBlockShow('block_musicupload_externalupload_form');
				$MusicUpload->show_div = 'selExternalUploadContent';
			}
		}
		elseif($MusicUpload->getFormField('music_upload_type') == 'Record')
		{
			$_SESSION['new_music_id'] = array();
			$MusicUpload->setFormField('recorded_filename', $MusicUpload->getFormField('upload'));
			if($MusicUpload->chkIsValidRecordedFile())
			{
				$MusicUpload->addNewMusic();
				if($MusicUpload->music_uploaded_success)
				{
					$MusicUpload->populateAudioDetailsForUpload();
					$MusicUpload->setPageBlockShow('block_musicupload_step2');
					$MusicUpload->setCommonSuccessMsg($LANG['musicupload_msg_record_success']);
					$MusicUpload->setPageBlockShow('block_msg_form_success');
				}
			}
			else
			{
				$MusicUpload->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$MusicUpload->setPageBlockShow('block_msg_form_error');
				$MusicUpload->setPageBlockShow('block_musicupload_step1');
				$MusicUpload->setPageBlockShow('block_musicupload_recordaudio_form');
				$MusicUpload->show_div = 'selRecordAudioContent';
			}
		}
	}
	elseif($MusicUpload->isFormPOSTed($_POST, 'upload_music')) //To Update other fields when uploading #also for edit music updation
	{
		$MusicUpload->setAllPageBlocksHide();

		$MusicUpload->setStep2CommonFields();
		$MusicUpload->sanitizeFormInputs($_POST);
		$MusicUpload->validateBasicFields(); //To validate multiple fields (title, artist, album and others)
		$MusicUpload->validateCommonFormFields(); //To validate common fields

		if($MusicUpload->isValidFormInputs())
		{
			if($MusicUpload->getFormField('music_access_type')=='Private')
			{
				$relation_id = implode(',',$MusicUpload->getFormField('relation_id'));
				$MusicUpload->setFormField('relation_id', $relation_id);
			}
			else
				$MusicUpload->setFormField('relation_id','');

			$MusicUpload->updateMusicDetailsForUpload();
			if($MusicUpload->getFormField('edit_mode') == 1)
			{
				//$MusicUpload->edit_completed = true;
				$MusicUpload->view_music_url = getUrl('viewmusic', '?music_id='.$MusicUpload->getFormField('music_id').'&amp;title='.$MusicUpload->getFormField('music_title').'&msg=updated', $MusicUpload->getFormField('music_id').'/'.$MusicUpload->getFormField('music_title').'?msg=updated', '', 'music');
				Redirect2URL($MusicUpload->view_music_url);
				$MusicUpload->setCommonSuccessMsg($LANG['musicupload_msg_update_success']);
				$MusicUpload->setPageBlockShow('block_musicupload_step2');
			}
			else
			{
				$MusicUpload->setCommonSuccessMsg($MusicUpload->musicupload_msg_success_uploaded);
				$MusicUpload->setPageBlockShow('block_musicupload_step1');
				$MusicUpload->setPageBlockShow('block_musicupload_multiupload_form');
				$MusicUpload->show_div = 'selMultiUploadContent';
			}

			$MusicUpload->setPageBlockShow('block_msg_form_success');
		}
		else
		{
			for($inc=0;$inc<$MusicUpload->getFormField('total_musics');$inc++)
			{
				$MusicUpload->multi_hidden_arr[$inc] = 'music_id_'.$inc;
				$MusicUpload->multi_hidden_arr[$inc+$MusicUpload->getFormField('total_musics')] = 'playing_time_'.$inc;
			}
			//$MusicUpload->populateAudioDetailsForUpload();
			$MusicUpload->setCommonErrorMsg($LANG['common_music_msg_error_sorry']);
			$MusicUpload->setPageBlockShow('block_msg_form_error');
			$MusicUpload->setPageBlockShow('block_musicupload_step2');
		}
	}
	else
	{
		$_SESSION['new_music_id'] = array();
	}
}
if($MusicUpload->isShowPageBlock('block_musicupload_step1'))
{
	$MusicUpload->LANG['musicupload_step'] = $LANG['musicupload_step1'];
	$MusicUpload->LANG['musicupload_step_info'] = $LANG['musicupload_step1_info'];
}
if($MusicUpload->isShowPageBlock('block_musicupload_step2'))
{
	$MusicUpload->LANG['musicupload_step'] = $LANG['musicupload_step2'];
	$MusicUpload->LANG['musicupload_step_info'] = $LANG['musicupload_step2_info'];
    $MusicUpload->musicUpload_tags_msg = str_replace(array('VAR_TAG_MIN_CHARS','VAR_TAG_MAX_CHARS'),
											array($CFG['fieldsize']['music_tags']['min'],$CFG['fieldsize']['music_tags']['max']),
												$LANG['musicupload_tags_msg1']);

	$MusicUpload->content_filter = false;

	if($MusicUpload->chkAllowedModule(array('content_filter')) && isAdultUser('','music'))
	{
		$MusicUpload->content_filter = true;
		$MusicUpload->Porn = $MusicUpload->General = 'none';
		$music_category_type = $MusicUpload->getFormField('music_category_type');
		$$music_category_type = '';
	}
	else
	{
		$MusicUpload->Porn = $MusicUpload->General = '';
	}
	if($MusicUpload->getFormField('music_category_type') == 'General')
	{
		$MusicUpload->General ='';
	}
	else
	{
		$MusicUpload->Porn = '';
	}
}
$MusicUpload->includeHeader();
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
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/JSFCommunicator.js"></script>
<script type="text/javascript">
var redirect_url="<?php echo $MusicUpload->getUrl('musiclist', '?pg=musicnew', 'musicnew/', '', 'music'); ?>";
J_PHOTOBALLOONWIDTH = '200';
	function saveAudio()
		{
			$Jq('#music_upload_form_record').submit();
		}
	var lang_change_image = '<?php echo $LANG['musicupload_change_image']; ?>';
	var lang_keep_old_image = '<?php echo $LANG['musicupload_keep_old_image']; ?>';
</script>
<?php
if($MusicUpload->isShowPageBlock('block_musicupload_recordaudio_form'))
	{
		$MusicUpload->generateAudioRecorderSettings();
	}
if($MusicUpload->isShowPageBlock('block_musicupload_multiupload_form'))
	{
		$MusicUpload->loadFilesForSwfUpload();
	}
setTemplateFolder('general/', 'music');
$smartyObj->display('musicUploadPopUp.tpl');

if($MusicUpload->isShowPageBlock('block_musicupload_step1'))
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
	var show_div = '<?php echo $MusicUpload->show_div; ?>';
	/*var more_tabs_div = new Array('selMultiUploadContent', 'selNormalUploadContent', 'selExternalUploadContent', 'selRecordAudioContent');
	var more_tabs_class = new Array('selHeaderMultiUpload', 'selHeaderNormalUpload', 'selHeaderExternalUpload', 'selHeaderRecordAudio');*/
	<?php
		echo $more_tabs_div;
		echo $more_tabs_class;
	?>
	var current_active_tab_class = 'clsActive';

	$Jq(window).load(function(){
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
			var div_value = $Jq('#'+div_id).html();
			result_div = div_id;
			more_li_id = current_li_id;
			div_value = $Jq.trim(div_value);
			if(div_value == '')
				{
					hideMoreTabsDivs(div_id);
					showMoreTabsDivs(div_id);
					$Jq('#'+div_id).html(music_ajax_page_loading);
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
			var obj = $Jq('#'+result_div);
			obj.css('display','block');
			if(result_div == 'selMultiUploadContent')
				{
					if(data.indexOf('#~~~#')>=1)
						{
							data = data.split('#~~~#');
							script_data = data[0];
							data = data[1];
						}
				}
			/*if(data.indexOf(session_check)>=1)
				{
					data = data.replace(session_check_replace,'');
				}
			else
				{
					return;
				}*/
			obj.html(data);
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
var lang_album_price = '<?php echo $LANG['musicupload_album_price'];?>';
var lang_music_price = '<?php echo $LANG['musicupload_music_price'];?>';
function checkIsPublic(id)
{
	if($Jq('#album_access_type_'+id).attr('checked') == true)
	{
		$Jq('#selAlbumId_'+id).css('display', 'block');
		$Jq('#selAlbumName_'+id).css('display', 'none');
		$Jq('music_album_id_'+id).val('');
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
		$Jq('#for_sale_'+id+'_2').attr('checked', 'true');
		enabledFormFields(Array('for_sale_'+id+'_1', 'for_sale_'+id+'_2'))
		disabledFormFields(Array('music_price_'+id));
		$Jq('#selPriceDetails').html('<?php echo $LANG['musicupload_music_price'].'('.$CFG['currency'].')';?>');

	}

}


function setRequiredClass(div_id)
{
	var obj = $Jq('#'+div_id);
	obj.setAttribute("class", "clsTextField clsYearField required")
}

function setNotRequiredClass(div_id)
{
	var obj = $Jq('#'+div_id);
	obj.setAttribute("class", "clsTextField clsYearField")
	obj.val('');
}
function populateMusicSubCategory(cat)
	{
		var url = '<?php echo $CFG['site']['music_url'].'musicUploadPopUp.php';?>';
			var pars = 'ajax_page=true&cid='+cat;
			<?php if($MusicUpload->getFormField('music_sub_category_id')){?>
			pars = pars+'&music_sub_category_id=<?php echo $MusicUpload->getFormField('music_sub_category_id');?>';
			<?php }?>
			var method_type = 'post';
			populateSubCategoryRequest(url, pars, method_type);
	}
<?php if($MusicUpload->getFormField('music_category_id')){?>
	populateMusicSubCategory('<?php echo $MusicUpload->getFormField('music_category_id'); ?>');
<?php }?>
</script>
<?php
if ($CFG['feature']['jquery_validation'])
{
	if ($MusicUpload->isShowPageBlock('block_musicupload_step2'))
	{
		$music_upload_rules_arr['title'] = $music_upload_messages_arr['title'] =
		$music_upload_rules_arr['album_id'] = $music_upload_messages_arr['album_id'] =
		$music_upload_rules_arr['album_name'] = $music_upload_messages_arr['album_name'] =
		$music_upload_rules_arr['artist'] = $music_upload_messages_arr['artist'] =
		$music_upload_rules_arr['release_year'] = $music_upload_messages_arr['release_year'] = '';
		for($i=0;$i<$MusicUpload->getFormField('total_musics');$i++)
		{
			$music_title_id = 'music_title_'.$i;
			$music_upload_rules_arr['title'] .= '"'.$music_title_id.'":{ required:true },';
			$music_upload_messages_arr['title'] .= '"'.$music_title_id.'":{ required:"'.$LANG['common_err_tip_required'].'"},';


			if($CFG['admin']['musics']['music_upload_album_name_compulsory'])
			{
				$music_album_name_id = 'music_album_'.$i;
				$music_upload_rules_arr['album_name'] .= '"'.$music_album_name_id.'":{ required:true },';
				$music_upload_messages_arr['album_name'] .= '"'.$music_album_name_id.'":{ required:"'.$LANG['common_err_tip_required'].'"},';
			}

			$music_album_id = 'music_album_id_'.$i;
			$music_upload_rules_arr['album_id'] .= '"'.$music_album_id.'":{required: function(value){sel_private_type = $Jq("#album_access_type_" + "'.$i.'").attr("checked");if(sel_private_type){true}else{return false}}},';
			$music_upload_messages_arr['album_id'] .= '"'.$music_album_id.'":{ required:"'.$LANG['common_err_tip_required'].'"},';

			if($CFG['admin']['musics']['music_upload_artist_name_compulsory'])
			{
				$music_artist_id = 'music_artist_id_'.$i;
				$music_upload_rules_arr['artist'] .= '"'.$music_artist_id.'":{ required:true },';
				$music_upload_messages_arr['artist'] .= '"'.$music_artist_id.'":{ required:"'.$LANG['common_err_tip_required'].'"},';
			}

			if($CFG['admin']['musics']['music_upload_release_year_compulsory'])
			{
				$music_release_year_id = 'music_year_released_'.$i;
				$music_upload_rules_arr['release_year'] .= '"'.$music_release_year_id.'":{ required:true },';
				$music_upload_messages_arr['release_year'] .= '"'.$music_release_year_id.'":{ required:"'.$LANG['common_err_tip_required'].'"},';
			}
		}
?>
<script type="text/javascript">
	$Jq("#music_upload_form").validate({
		rules: {
			<?php
				echo $music_upload_rules_arr['title'];
				echo $music_upload_rules_arr['album_name'];
				echo $music_upload_rules_arr['album_id'];
				echo $music_upload_rules_arr['artist'];
				echo $music_upload_rules_arr['release_year'];
			?>
		    music_category_id_general: {
		    	required: true
		    },
		    music_tags: {
				required: true,
				chkValidTags: Array(<?php echo  $CFG['fieldsize']['music_tags']['min']; ?>, <?php echo  $CFG['fieldsize']['music_tags']['max']; ?>)
		    }
		},
		messages: {
			<?php
				echo $music_upload_messages_arr['title'];
				echo $music_upload_messages_arr['album_name'];
				echo $music_upload_messages_arr['album_id'];
				echo $music_upload_messages_arr['artist'];
				echo $music_upload_messages_arr['release_year'];
			?>
			music_category_id_general: {
				required: "<?php echo $LANG['common_err_tip_required'];?>"
			},
			music_tags: {
				required: "<?php echo $LANG['common_err_tip_required'];?>",
				chkValidTags: "<?php echo $LANG['music_common_err_tip_invalid_tag'];?>"
			}
		}
	});
</script>
<?php
}
}
$MusicUpload->includeFooter();
?>
