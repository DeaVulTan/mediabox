<?php
/**
 * Class to handle the form fields
 *
 * This is having class MusicHandler to handle Music Upload functionalities.
 * Which extends FormHandler and MediaHandler, ListRecordsHandler (If class exists)
 *
 *
 *
 * @category	###Rayzz###
 * @package		###Common/Classes###
 */
if(class_exists('MusicHandler'))
	{
		class musicUploadHandler extends MusicHandler{}
	}
elseif(class_exists('MediaHandler'))
	{
		class musicUploadHandler extends MediaHandler{}
	}
elseif(class_exists('ListRecordsHandler'))
	{
		class musicUploadHandler extends ListRecordsHandler{}
	}
elseif(class_exists('FormHandler'))
	{
		class musicUploadHandler extends FormHandler{}
	}

class MusicUploadLib extends musicUploadHandler
	{

		/**
		 * MusicUploadLib::__construct()
		 *  Constructor
		 */
		public function __construct()
			{
				parent::__construct();
				$this->MEDIA_TYPE = 'music';
				$this->MEDIA_TYPE_CFG = 'musics';
			}

		/**
		 * MusicUploadLib::setIHObject()
		 *
		 * @param object $imObj
		 * @return void
		 */
		public function setIHObject($imObj)
			{
				$this->imageObj = $imObj;
			}

		/**
		 * MusicUploadLib::resetFieldsArray()
		 *
		 * @return void
		 */
		public function resetFieldsArray()
			{
				$this->setFormField('music_id', '');
				$this->setFormField('music_album', '');
				$this->setFormField('music_album_id', '1');
				$this->setFormField('music_artist', '1');
				$this->setFormField('album_id', '');
				$this->setFormField('album_access_type', '');
				$this->setFormField('music_file', '');
				$this->setFormField('music_external_file', '');
				$this->setFormField('music_other', '');
				//$this->setFormField('musicupload_type', 'Normal');
				$this->setFormField('animated_gif', '');
				$this->setFormField('music_category_type', 'General');
				$this->setFormField('music_category_id', '1');
				$this->setFormField('music_sub_category_id', '');
				$this->setFormField('music_title', '');
				$this->setFormField('music_caption', '');
				$this->setFormField('music_tags', '');
				$this->setFormField('gpukey', '');
				$this->setFormField('music_access_type', 'Public');
				$this->setFormField('year', '');
				$this->setFormField('month', '');
				$this->setFormField('day', '');
				$this->setFormField('music_year_released', '');
				$this->setFormField('location', '');
				$this->setFormField('country', '');
				$this->setFormField('music_language', '');
				$this->setFormField('zip_code', '');
				$this->setFormField('allow_comments', 'Yes');
				$this->setFormField('allow_ratings', 'Yes');
				$this->setFormField('allow_lyrics', 'Yes');
				$this->setFormField('allow_embed', 'Yes');
				$this->setFormField('relation_id',array());
				$this->setFormField('upload', '');
				$this->setFormField('music_file_name','');
				$this->setFormField('music_original_filename', '');
				$this->setFormField('music_file_image','');
				$this->setFormField('music_file_ext','');
				$this->setFormField('music_thumb_ext','');
				$this->setFormField('music_server_url', '');
				$this->setFormField('file_extern', '');
				$this->setFormField('cid', '');
				$this->setFormField('ajax_page','');
				$this->setFormField('pg','');
				$this->setFormField('use_mid','');
				$this->setFormField('rid', '');
				$this->setFormField('recorded_filename', '');
				$this->setFormField('upload', '');
				$this->setFormField('total_musics', '');
				$this->setFormField('edit_mode', 0);
				$this->setFormField('query', '');
				$this->setFormField('step_status', 'Step1');
				$this->setFormField('external_site_music_path','');
				$this->setFormField('for_sale','No');
				$this->setFormField('music_price','');
				$this->setFormField('preview_start','');
				$this->setFormField('preview_end','');
			}

		public function chkIsAllowedForSale()
		{
			$sql = 'SELECT music_user_type FROM '.$this->CFG['db']['tbl']['users'].
					' WHERE user_id='.$this->dbObj->Param('user_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
			if(!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);
			$row = $rs->FetchRow();
			if( isset($this->CFG['admin']['musics']['allowed_usertypes_to_upload_for_sale'])
				AND ($this->CFG['admin']['musics']['allowed_usertypes_to_upload_for_sale']==$row['music_user_type']
				OR $this->CFG['admin']['musics']['allowed_usertypes_to_upload_for_sale']=='All'))
				return true;
			return false;
		}

		public function chkIsPrivateAlbum($album_id)
		{
			$sql = 'SELECT album_access_type FROM '.
					$this->CFG['db']['tbl']['music_album'].
					' WHERE music_album_id ='.$this->dbObj->Param('music_album_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($album_id));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);
			if($row = $rs->FetchRow())
			{
				if($row['album_access_type']=='Private')
					return true;
			}
			return false;
		}

		public function populateDefaultMusicDetails()
		{
			$sql = 'SELECT music_category_id, relation_id,music_language,music_sub_category_id,music_tags, music_access_type,allow_comments,'.
		  			' allow_ratings, allow_download, allow_embed, allow_lyrics,for_sale, music_price,preview_start,preview_end'.
		  			' FROM '.$this->CFG['db']['tbl']['music_user_default_settings'].
		  			' WHERE user_id='.$this->dbObj->Param('user_id');
		  	$stmt = $this->dbObj->Prepare($sql);
		  	$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
		  	if(!$rs)
		  		trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if($row = $rs->FetchRow())
			{
				$this->fields_arr['music_tags'] = $row['music_tags'];
				$this->fields_arr['music_language'] = $row['music_language'];
				$this->fields_arr['music_category_id'] = $row['music_category_id'];
				$this->fields_arr['music_sub_category_id'] = $row['music_sub_category_id'];
				$this->fields_arr['allow_comments'] = $row['allow_comments'];
				$this->fields_arr['allow_ratings'] = $row['allow_ratings'];
				$this->fields_arr['allow_lyrics'] = $row['allow_lyrics'];
				$this->fields_arr['allow_embed'] = $row['allow_embed'];
				$this->fields_arr['music_access_type'] = $row['music_access_type'];
				if($this->chkIsPrivateAlbum($this->fields_arr['music_album_id']))
				{
					$this->fields_arr['for_sale'] = 'No';
				}
				else
					$this->fields_arr['for_sale'] = $row['for_sale'];
				$album_details = getMusicAlbumDetails($this->fields_arr['music_album_id']);
				if($this->fields_arr['for_sale']=='Yes' or $album_details['album_for_sale']=='Yes')
				{
					$this->fields_arr['music_price'] = $row['music_price'];
					if($album_details['album_for_sale']=='Yes')
						$this->fields_arr['music_price'] = $album_details['album_price'];
				}
				if(isset($this->CFG['admin']['musics']['allow_members_to_choose_the_preview'])
						and $this->CFG['admin']['musics']['allow_members_to_choose_the_preview'])
					{
						$this->fields_arr['preview_start'] = $row['preview_start'];
						$this->fields_arr['preview_end'] = $row['preview_end'];
					}
				$this->fields_arr['relation_id_default'] = '';
				if($row['relation_id'] and $row['music_access_type']=='Private')
					$this->fields_arr['relation_id_default'] = $row['relation_id'];
			}
			else
			{
			 $this->fields_arr['relation_id_default'] = '';
			}
		}

		/**
		 * MusicUploadLib::addNewMusic()
		 *
		 * @return void
		 */
		public function addNewMusic()
			{

				//set the file type in the form field music_ext
				if($this->fields_arr['music_upload_type']=='Normal'
					OR $this->fields_arr['music_upload_type']=='MultiUpload')
					{
						if($this->isFormPOSTed($_POST, 'upload_music_normal')
							OR $this->isFormPOSTed($_POST, 'Upload')) // Upload is for SWFupload
							{
								$extern = strtolower(substr($_FILES['music_file']['name'],
														strrpos($_FILES['music_file']['name'], '.')+1));
								$original_file_name = substr($_FILES['music_file']['name'], 0,
														strrpos($_FILES['music_file']['name'], '.'));
							}
						/*else
							{
								$extern = $this->fields_arr['file_extern'];
							}*/
						$this->setFormField('music_server_url', $this->CFG['site']['url']);
						$this->setFormField('music_ext', $extern);
						$this->setFormField('music_original_filename', $original_file_name);
						$this->setFormField('music_title', $original_file_name);
						//$this->setFormField('music_album_name', $original_file_name);
						$this->setFormField('music_encoded_status','Partial');
						$this->setFormField('music_size',$_FILES['music_file']['size']);
					}
				elseif ($this->fields_arr['music_upload_type']=='MassUpload')
					{
						$extern = $this->fields_arr['extern'];
						$original_file_name = $this->fields_arr['original_file_name'];
						$this->setFormField('music_server_url', $this->CFG['site']['url']);
						$this->setFormField('music_ext', $extern);
						$this->setFormField('music_original_filename', $original_file_name);
						$this->setFormField('music_title', $original_file_name);
						//$this->setFormField('music_album_name', $original_file_name);
						$this->setFormField('music_encoded_status','Partial');
						$this->setFormField('music_size','');
					}
				else if($this->fields_arr['music_upload_type'] == 'External')
					{
						$music_external_file = $this->getFormField('music_external_file');
						$extern = strtolower(substr($this->getFormField('music_external_file'),
									strrpos($this->getFormField('music_external_file'), '.')+1));

						$original_file_name = substr($this->getFormField('music_external_file'),
													strrpos($this->getFormField('music_external_file'), '/')+1,
														strrpos($this->getFormField('music_external_file'), '.'));

						if($this->CFG['admin']['musics']['external_music_download'])
							$music_server_url = substr($this->getFormField('music_external_file'), 0,
													strrpos($this->getFormField('music_external_file'), '/')+1);
						else
							$music_server_url = $this->CFG['site']['url'];

						$this->setFormField('music_server_url', $music_server_url);
						$this->setFormField('music_ext',$extern);
						$this->setFormField('music_original_filename', $original_file_name);
						$this->setFormField('music_title', $original_file_name);
						//$this->setFormField('music_album_name', $original_file_name);
						$this->setFormField('music_encoded_status','Partial');
						$this->setFormField('music_size', '');
					}
				else if($this->fields_arr['music_upload_type'] == 'Record')
					{
						$extern = 'flv';
						$this->setFormField('music_ext', 'flv');
						//$this->setFormField('music_status', 'Ok');
						$this->setFormField('music_encoded_status', 'Partial');
						$this->setFormField('music_size', '');
						$this->setFormField('music_title', $this->LANG['common_recorded_music']);
						$this->setFormField('music_server_url', $this->CFG['site']['url']);
					}
				else if($this->fields_arr['music_upload_type'] == 'music_importer')
					{
						$extern = 'mp3';
						$this->setFormField('music_ext', 'mp3');
						$this->setFormField('music_status', 'Ok');
						$this->setFormField('music_encoded_status', 'Partial');
						$this->setFormField('music_size', '');
						$original_file_name = $this->fields_arr['original_file_name'];
						$this->setFormField('music_server_url', $this->CFG['site']['url']);
						$music_id=$this->fields_arr['music_id'];
						$this->MUSIC_USER_ID = $this->CFG['user']['user_id'];
						$this->MUSIC_RELATION_ID =$this->fields_arr['relation_id'];
					}
				/*else
					{
						$extern = 'mp3';
						$this->setFormField('music_ext','mp3');
					}*/
				$this->setFormField('music_url', '');
				$this->setFormField('user_id',$this->CFG['user']['user_id']);
				$this->setFormField('music_ext', $extern);
				$this->setFormField('music_encoded_status','Partial');
				$this->setFormField('thumb_name_id', getCurrentMusicFileSettingId('Thumb'));
				$this->setFormField('music_file_name_id', getCurrentMusicFileSettingId('Music'));
				$this->setFormField('trimed_music_name_id', getCurrentMusicFileSettingId('Trimed'));
				$this->setFormField('date_added','NOW()');


				//$this->setCommonFormFields();

				//$this->fields_arr['music_url'] = '';
				//@todo Need to add a field in the music table to store the method used

				//$this->fields_arr['music_sub_category_id'] = $this->fields_arr['music_sub_category_id']?$this->fields_arr['music_sub_category_id']:0;
				//set the values for the newly added fields -- external_site_music_url, form_upload_type, external_site_music_path


				/*$music_id = $this->insertMusicTable(array('user_id','music_album_id',
														'music_ext', 'music_size',
														'music_category_id', 'music_sub_category_id',
														'music_title','music_caption','music_tags',
														'music_access_type','date_added','music_encoded_status',
														'allow_comments','allow_ratings','allow_embed',
														'music_upload_type', 'music_url',
														'music_server_url', 'music_original_filename',
														'thumb_name_id', 'music_file_name_id', 'trimed_music_name_id'));*/
                if($this->fields_arr['music_upload_type']!='music_importer')
                {
					$music_id = $this->insertMusicTable(array('user_id','music_album_id', 'music_artist',
														'music_ext', 'music_size',
														'music_title','music_tags', 'music_category_id',
														'music_access_type','date_added', 'music_encoded_status',
														'music_upload_type', 'music_url',
														'music_server_url', 'music_original_filename',
														'thumb_name_id', 'music_file_name_id', 'trimed_music_name_id'));
                }

				$this->setFormField('music_id', $music_id);
				if($this->getFormField('music_upload_type') != 'MultiUpload')
					$_SESSION['new_music_id'][] = $music_id;

/*
				$music_id = $this->insertMusicTable(array('user_id','music_album_id','music_ext','music_category_id', 'music_sub_category_id','music_title','music_caption','music_tags','music_access_type','date_added','music_encoded_status','allow_comments','allow_ratings','date_recorded','location_recorded','country_recorded','zip_code_recorded','allow_embed','relation_id', 'music_upload_type', 'music_url', 'music_server_url'));
*/
				//added code for logging
				if($this->fp)
					{
						$log_str = 'Music Record created : '.$music_id."\r\n";
						$this->writetoTempFile($log_str);
					}
				//added code for logging


				/*if(!$this->CFG['admin']['tagcloud_based_search_count'])
					$this->changeTagTable();*/

				$music_name = getMusicName($music_id);
				$music_thumb_name = getMusicImageName($music_id);

				$temp_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
								$this->CFG['temp_media']['folder'].'/'.
									$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['temp_folder'].'/';
				//echo $temp_dir.'<br />';
				$this->chkAndCreateFolder($temp_dir);

				$extern_img = $this->fields_arr['music_file_ext'];
				$music_temp_name = $this->fields_arr['music_file_name'];

				$upload_dir_thumb = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
										$this->CFG['temp_media']['folder'].'/'.
											$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['temp_folder'].'/';
				$this->chkAndCreateFolder($upload_dir_thumb);
				//image upload temp path
				$image_upload_url = $upload_dir_thumb.$music_thumb_name;

				$tempurl = $temp_dir.$music_temp_name;

				$temp_file = $temp_dir.$music_name.'.'.$extern;
				if($this->fields_arr['music_upload_type'] == 'Normal'
					OR $this->fields_arr['music_upload_type'] == 'MultiUpload')
					{
						$this->storeMusicsTempServer($temp_file);
					}
				elseif ($this->fields_arr['music_upload_type']=='MassUpload')
					{
						$dirname = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->mass_uploader_folder.'/'.$this->fields_arr['music_file_path'];
						copy($dirname, $temp_file);
						//unlink($dirname);
						echo 'here'.$dirname;
					}
				else if($this->fields_arr['music_upload_type'] == 'External' &&
						$this->CFG['admin']['musics']['external_music_download'])
					{
						$log_str = 'DOWNLOADING FILE FROM: '.$this->fields_arr['music_external_file']."\r\n";
						$this->writetoTempFile($log_str);
						$external_music = getContents($this->fields_arr['music_external_file']);
						if($external_music)
							{
								$log_str = 'STORING TO: '.$temp_file."\r\n";
								$this->writetoTempFile($log_str);
								$this->fileWrite($temp_file, $external_music);
								$file_size = filesize($temp_file);
								$this->setFormField('music_size', $file_size);
							}
						else
							{
								$log_str = 'Unable to download file from: '.$this->fields_arr['music_external_file']."\r\n";
								$this->writetoTempFile($log_str);
							}
					}
				else if($this->fields_arr['music_upload_type'] == 'Record')
					{
						$log_str = 'DOWNLOADING FILE FROM RED5 '."\r\n";
						$this->writetoTempFile($log_str);
						$file_name = $this->CFG['admin']['video']['red5_flv_path'].$this->fields_arr['recorded_filename'].'.'.$extern;
						if(preg_match('/http/', $file_name))
							{
								$recorded_music = getContents($file_name);
								if($recorded_music)
									{
										$log_str = ' STORING TO: '.$temp_file."\r\n";
										$this->writetoTempFile($log_str);
										$this->fileWrite($temp_file, $recorded_music);
										$file_size = filesize($temp_file);
										// IMP: Have to get the size after encoding
										//$this->setFormField('music_size', $file_size);
										$log_str = 'File downloaded from RED5 '."\r\n";
										$this->writetoTempFile($log_str);
									}
								else
									{
										$log_str = 'Unable to download file from RED5 '."\r\n";
										$this->writetoTempFile($log_str);
									}
							}
						elseif ($this->fields_arr['music_upload_type']=='music_importer')
						{
							$this->MUSIC_EXT='mp3';
						}
						else
							{
								$copied = copy($file_name, $temp_file);
								unlink($file_name);
								if($copied)
									{
										$log_str = 'File '.$file_name.' copied '."\r\n";
										$this->writetoTempFile($log_str);
									}
								else
									{
										$log_str = 'Unable to copy file: '.$file_name."\r\n";
										$this->writetoTempFile($log_str);
									}

							}
						$this->fields_arr['music_upload_type'] = 'Normal';
					}
				dbConnect();

				//Read ID3 data
				if(strstr($extern, 'mp3'))
					{
						$log_str = ' Calling ID3 Reader '.$temp_file.' \r\n';
						$this->writetoTempFile($log_str);
						$ReadId3 = new ReadID3Data();
						$id3_arr = @$ReadId3->getData($temp_file, $image_upload_url);
				}

				if(isset($id3_arr) and !empty($id3_arr))
					{
						if(isset($id3_arr['music_album_id']) && !empty($id3_arr['music_album_id']))
							{
								$id3_arr['music_album_id'] = trim($id3_arr['music_album_id']);
								$music_album_id = $this->chkAlbumName($id3_arr['music_album_id']);
								if(empty($music_album_id))
									{
										$music_album_id = $this->addAlbumName($id3_arr['music_album_id']);
									}
								$id3_arr['music_album_id'] = $music_album_id;
							}
						else
							$id3_arr['music_album_id'] = '1';

						if(isset($id3_arr['music_artist']) && !empty($id3_arr['music_artist']))
							{
								$id3_arr['music_artist'] = trim($id3_arr['music_artist']);
								$this->fields_arr['old_artist_names_for_mass_upload'] = $id3_arr['music_artist'];
								$this->upadateArtistTable($id3_arr['music_artist']);
								$id3_arr['music_artist'] = $this->artist_id;
							}
						else
							$id3_arr['music_artist'] = '1';

						if(isset($id3_arr['music_thumb_ext']) && !empty($id3_arr['music_thumb_ext']))
							{
								$extern_img = $id3_arr['music_thumb_ext'];
								if(is_file($image_upload_url.'L.'.$extern_img))
									{
										$imageObj = new ImageHandler($image_upload_url.'L.'.$extern_img);
										$this->setIHObject($imageObj);
										$this->storeImagesTempServer($image_upload_url, $extern_img);
										//To update image sizes in music table
										$this->updateMusicImageExt();
									}
							}

						//print_r($id3_arr);
						//if(!empty($id3_arr))
						//echo '<br />'.$id3_arr['music_title'];
						if(empty($id3_arr['music_title']))
							unset($id3_arr['music_title']);

						if($id3_arr['music_year_released'] == '0000'
							or $id3_arr['music_year_released'] == 0
								or strstr($id3_arr['music_year_released'], '0000'))
							unset($id3_arr['music_year_released']);

						$this->arrayToFields($id3_arr);
						//Update ID3 info to the records
						$this->updateMusicTable($id3_arr);
					}

					$this->populateDefaultMusicDetails();
					if(!$this->fields_arr['relation_id_default'])
					{
						$this->fields_arr['relation_id_default'] = '';
					}
					$param_field = array('music_tags' => $this->fields_arr['music_tags'],
											 'music_category_id' => $this->fields_arr['music_category_id'],
											 'music_sub_category_id' => $this->fields_arr['music_sub_category_id'],
											 'music_language' => $this->fields_arr['music_language'],
											 'allow_comments' => $this->fields_arr['allow_comments'],
											 'allow_ratings' => $this->fields_arr['allow_ratings'],
											 'allow_lyrics' => $this->fields_arr['allow_lyrics'],
											 'allow_embed' => $this->fields_arr['allow_embed'],
											 'music_price' => $this->fields_arr['music_price'],
											 'for_sale' => $this->fields_arr['for_sale'],
											 'preview_start' => $this->fields_arr['preview_start'],
											 'preview_end' => $this->fields_arr['preview_end'],
											 'music_access_type' => $this->fields_arr['music_access_type']
											 );
					if($this->fields_arr['music_access_type']=='Private')
					{
						$this->fields_arr['relation_id'] = $this->fields_arr['relation_id_default'];
						$relation_arr = array('relation_id' => $this->fields_arr['relation_id_default']);
						$param_field = array_merge($param_field, $relation_arr);
					}


				$this->updateMusicTable($param_field);


				//music_encoded_status will be set to No
				$this->changeMusicEncodeStatus($music_id);
				$this->writetoTempFile('BEFORE ENCODE CALL:'."\r\n");
				if($this->CFG['admin']['musics']['music_auto_encode']) //&& $this->fields_arr['music_upload_type'] != 'record'
					{
						$this->writetoTempFile('IN ENCODE CALL CONDITION:'."\r\n");
						//added code for logging
						if($this->fp)
							{
								$log_str = ' Calling Music Encode \r\n';
								$this->writetoTempFile($log_str);
							}
						## Added to check whether the flv upload type is external music & only allow the music encode if auto download is true
						//if(($this->fields_arr['music_upload_type']=='external' && $this->CFG['admin']['musics']['auto_download_external_music']) or $this->fields_arr['music_upload_type']!='external')
						//if($this->CFG['admin']['musics']['music_auto_encode'])

							if($this->musicEncode($music_id))
								$this->music_uploaded_success = true;
					}
				else
					{
						if($this->getFormField('music_upload_type') == 'MultiUpload')
							$_SESSION['new_music_id'][] = $this->getFormField('music_id');
					}
			}

		/**
		 * MusicUploadLib::storeMusicsTempServer()
		 *
		 * @param string $uploadUrl
		 * @return boolean
		 */
		public function storeMusicsTempServer($uploadUrl)
			{
				//if php file upload OR if Multi-Upload
				if($this->isFormPOSTed($_POST, 'upload_music_normal')
					OR $this->isFormPOSTed($_POST, 'Upload'))
					{
						if(!move_uploaded_file($_FILES['music_file']['tmp_name'], $uploadUrl))
							{
								$this->music_uploaded_success = false;
							}
					}
				//added code for logging
				if($this->fp)
					{
						$log_str = ' Music stored in temp server : '.$uploadUrl."\r\n";
						$this->writetoTempFile($log_str);
					}
			}

		/**
		 * MusicUploadLib::musicEncode()
		 *
		 * @param string $music_id
		 * @return void
		 */
		public function musicEncode($music_id)
			{
				if($this->checkMusicAndGetDetails($music_id))
					{
						$source = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
										$this->CFG['temp_media']['folder'].'/'.
											$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['temp_folder'].'/';

						$m_source_filename = $source.$this->MUSIC_NAME.'.'.$this->MUSIC_EXT;

						$store_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
										$this->CFG['temp_media']['folder'].'/'.
											$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['temp_folder'].'/';

						$m_output_filename = $store_dir.$this->MUSIC_NAME.'.wav';
						//STARTED TO ADDING THE CODING FOR CHECKING THE ID_AUDIO_FORMAT.
						$command = $this->CFG['admin']['video']['mplayer_path'].' -vo null -ao null -frames 0 -identify '.$m_source_filename;
						exec($command, $p);
						while(list($k,$v)=each($p)){
							if($length=strstr($v,'ID_AUDIO_FORMAT='))
					        	break;
					    }
					    if(isset($length))
							$lx = explode("=",$length);
						//ENDED TO ADDING THE CODING FOR CHECKING THE ID_AUDIO_FORMAT.
						$l_source_filename = $source.$this->MUSIC_NAME.'.wav';
						$l_output_filename = $store_dir.$this->MUSIC_NAME.'.mp3';
						require_once($this->CFG['site']['project_path'].'music/musicCommand.inc.php');
						//if(($this->MUSIC_UPLOAD_TYPE != 'Normal') OR (is_file($source_filename)))
						if((is_file($m_source_filename)))
							{
								//other than mp3 and flv. Added the OR condition if audio format is 80
								if((strtolower($this->MUSIC_EXT) != 'mp3' OR @$lx['1']==80) and strtolower($this->MUSIC_EXT) != 'flv' )
									{
										//CALLING MPLAYER
										$mplayer_command = getMplayerCommand($m_source_filename, $m_output_filename);
										$log_str = 'CALLING MPLAYER FOR CONVERSION TO WAV: '.$mplayer_command ."\r\n";
										$mplayer_result = exec($mplayer_command, $m_result);
										if(count($m_result))
											{
												foreach($m_result as $key=>$val)
													$log_str .= $key.': '.$val."\n\r";
											}
										$this->writetoTempFile($log_str);

										if(is_file($l_source_filename))
											{
												//CALLING LAME
												$lame_command = getLameCommand($l_source_filename, $l_output_filename);
												$log_str = 'CALLING LAME FOR CONVERSION TO MP3:'.$lame_command."\r\n";
												$lame_result = exec($lame_command, $l_result);
												if(count($l_result))
													{
														foreach($l_result as $key=>$val)
															$log_str .= $key.': '.$val."\n\r";
													}
											}
										else
											{
												$this->music_uploaded_success = false;
												if(is_file($m_source_filename))
													unlink($m_source_filename);
												$this->deleteMusicTable($_SESSION['new_music_id']);
												$this->sendMailToUserForDelete();
												return false;
											}

										if(is_file($l_source_filename))
											unlink($l_source_filename);

										$m_source_filename = $l_output_filename;

										if(method_exists($this, 'writetoTempFile'))
											$this->writetoTempFile($log_str);

										$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['music_available_formats'][] = $this->MUSIC_EXT;
										//$this->MUSIC_EXT = 'mp3';

									}
								else if(strtolower($this->MUSIC_EXT) == 'flv')
									{
										//CALLING FLVTOOL2
										$flvtool2_command = getFlvtool2Command($m_source_filename);
										$log_str = 'CALLING FLVTOOL2: '.$flvtool2_command ."\r\n";
										$flvtool2_result = exec($flvtool2_command, $f_result);
										if(count($f_result))
											{
												foreach($f_result as $key=>$val)
													$log_str .= $key.': '.$val."\n\r";
											}
										$this->writetoTempFile($log_str);

										/*if(is_file($m_source_filename))
											{
												//CALLING MPLAYER
												$mplayer_command = getMplayerDumpCommand($m_source_filename, $l_output_filename);
												$log_str = 'CALLING MPLAYER FOR CONVERSION TO MP3:'.$mplayer_command."\r\n";
												$mplayer_result = exec($mplayer_command, $m_result);
												if(count($m_result))
													{
														foreach($m_result as $key=>$val)
															$log_str .= $key.': '.$val."\n\r";
													}
											}*/
										//FFMPEG COMMAND TO CONVERT FLV TO WAV - MPLAYER DUMP COMMAND NOT WORKED SO USING FFMPEG
										$ffmpeg_command = $this->CFG['admin']['audio']['ffmpeg_path'].' -i '.$m_source_filename.' '.$l_source_filename;
										$log_str = 'CALLING FFMPEG FOR CONVERSION TO WAV:'.$ffmpeg_command."\r\n";
										$ffmpeg_result = exec($ffmpeg_command, $f_result);
										if(count($f_result))
											{
												foreach($f_result as $key=>$val)
													$log_str .= $key.': '.$val."\n\r";
											}

 										if(is_file($l_source_filename))
											{
												//CALLING LAME
												$lame_command = getLameCommand($l_source_filename, $l_output_filename);
												$log_str = 'CALLING LAME FOR CONVERSION TO MP3:'.$lame_command."\r\n";
												$lame_result = exec($lame_command, $l_result);
												if(count($l_result))
													{
														foreach($l_result as $key=>$val)
															$log_str .= $key.': '.$val."\n\r";
													}
											}

										if(is_file($m_source_filename))
											unlink($m_source_filename);

										if(is_file($l_source_filename))
											unlink($l_source_filename);

										if(method_exists($this, 'writetoTempFile'))
											$this->writetoTempFile($log_str);
										$this->MUSIC_EXT = 'mp3';
									}

								//Get Playing time
								$playing_time = $this->getMusicPlayingTime($l_output_filename);
								$this->setFormField('playing_time', $playing_time);

								//OTHER FORMATS
								if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['music_other_formats_enabled'])
									{
										/*# GENERATING MP4 format If ituens is set to true
										if($this->CFG['rss_display']['itunes'])
											{
												if(!in_array('mp4',	$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['music_available_formats']))
													$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['music_available_formats'][]='mp4';
											}*/

										$this->generateOtherFormatMusics($store_dir.$this->MUSIC_NAME.".".$this->MUSIC_EXT, $store_dir.$this->MUSIC_NAME);
									}
								else
									{
										/*# GENERATING MP4 format If ituens is set to true
										if($this->CFG['rss_display']['itunes'])
											{
												unset($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['music_available_formats']);
												$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['music_available_formats'][]='mp4';
												$this->generateOtherFormatVideos($store_dir.$this->VIDEO_NAME.".".$this->VIDEO_EXT, $store_dir.$this->VIDEO_NAME);
											}*/
									}

								//Update playing time
								$this->updateMusicPlayingTime();
								$this->changeEncodedStatus('Yes');
								if($this->CFG['admin']['musics']['music_auto_activate'])
									{
										if($this->populateMusicDetails())
											{
												if($this->activateMusicFile())
													{
														//Checked the condition for album is private andmarked for sale, then music will be inserted to already purchased users
														$this->chkAndAddMusicPurchases($this->fields_arr['music_album_id'], $this->fields_arr['music_id'] );
														$this->addMusicUploadActivity();
														$this->sendMailToUserForActivate();
														if($this->MUSIC_RELATION_ID)
															{
																$this->getEmailAddressOfRelation($this->MUSIC_RELATION_ID);
																$this->sendEmailToAll();
															}
														if($this->getFormField('music_upload_type') == 'MultiUpload')
															$_SESSION['new_music_id'][] = $this->getFormField('music_id');
													}
											}
									}
									else
									{
										if($this->getFormField('music_upload_type') == 'MultiUpload')
											$_SESSION['new_music_id'][] = $this->getFormField('music_id');
									}
							}
						else
							{
								$this->music_uploaded_success = false;
								if(is_file($m_source_filename))
									unlink($m_source_filename);
								$this->deleteMusicTable($_SESSION['new_music_id']);
								//$this->sendMailToUserForInvalidMusic();
								$this->sendMailToUserForDelete();
							}
					}
			}
		/**
		 * MusicUploadLib::deleteMusicTable()
		 *
		 * int $music_id
		 *
		 * @return
		 */
		public function deleteMusicTable($musicId_arr)
		{
			$_SESSION['new_music_id'] = array();
			$musicId_arr = array_filter($musicId_arr);
			$music_id = implode(',',$musicId_arr);
			if($music_id)
			{
				$tablename_arr = array('music');
				for($i=0;$i<sizeof($tablename_arr);$i++)
					{
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl'][$tablename_arr[$i]].
								' WHERE music_id IN ('.$music_id.')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
					}
			}
		}

		/**
		 * MusicUploadLib::checkMusicAndGetDetails()
		 *
		 * @param integer $music_id
		 * @return boolean
		 */
		public function checkMusicAndGetDetails($music_id)
			{
				$sql = 'SELECT user_id, music_id, music_album_id, music_ext, music_title, music_url, music_category_id,'.
						' music_thumb_ext, music_upload_type, relation_id, for_sale, preview_start, preview_end FROM '.$this->CFG['db']['tbl']['music'].
						' WHERE music_encoded_status=\'No\' AND music_id='.$this->dbObj->Param('music_id').
						' ORDER BY music_id LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($music_id));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						$this->MUSIC_ID = $row['music_id'];
						$this->MUSIC_NAME = getMusicName($this->MUSIC_ID);
						$this->MUSIC_THUMB_NAME = getMusicImageName($this->MUSIC_ID);
						$this->MUSIC_EXT = $row['music_ext'];
						$this->MUSIC_TITLE = $row['music_title'];
						$this->MUSIC_URL = $row['music_url'];
						$this->MUSIC_THUMB_EXT = $row['music_thumb_ext'];
						$this->MUSIC_UPLOAD_TYPE = $row['music_upload_type'];
						$this->MUSIC_CATEGORY_ID = $row['music_category_id'];
						$this->MUSIC_RELATION_ID = $row['relation_id'];
						$this->MUSIC_FOR_SALE = $row['for_sale'];
						$this->MUSIC_PREVIEW_START = $row['preview_start'];
						$this->MUSIC_PREVIEW_END = $row['preview_end'];
						$album = getMusicAlbumDetails($row['music_album_id']);
						$this->ALBUM_FOR_SALE = $album['album_for_sale'];
						$sql = 'SELECT user_name, email FROM '.$this->CFG['db']['tbl']['users'].
								' WHERE user_id='.$this->dbObj->Param('user_id').' LIMIT 0,1';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($row['user_id']));
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.
								$this->dbObj->ErrorMsg(), E_USER_ERROR);

						if($row = $rs->FetchRow())
							{
								$this->MUSIC_USER_NAME = $row['user_name'];
								$this->MUSIC_USER_EMAIL = $row['email'];
							}
						return true;
					}
				return false;
			}

		public function checkAndGetMusicDetails($music_id)
			{
				$sql = 'SELECT user_id, music_id,'.
						' for_sale,music_album_id, preview_start,music_category_id, preview_end FROM '.$this->CFG['db']['tbl']['music'].
						' WHERE music_id='.$this->dbObj->Param('music_id').
						' ORDER BY music_id LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($music_id));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						$this->MUSIC_ID = $row['music_id'];
						$this->MUSIC_NAME = getMusicName($this->MUSIC_ID);
						$this->MUSIC_THUMB_NAME = getMusicImageName($this->MUSIC_ID);
						$this->MUSIC_CATEGORY_ID = $row['music_category_id'];
						$this->MUSIC_FOR_SALE = $row['for_sale'];
						$album = getMusicAlbumDetails($row['music_album_id']);
						$this->ALBUM_FOR_SALE = $album['album_for_sale'];
						$this->MUSIC_PREVIEW_START = $row['preview_start'];
						$this->MUSIC_PREVIEW_END = $row['preview_end'];

						$sql = 'SELECT user_name, email FROM '.$this->CFG['db']['tbl']['users'].
								' WHERE user_id='.$this->dbObj->Param('user_id').' LIMIT 0,1';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($row['user_id']));
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.
								$this->dbObj->ErrorMsg(), E_USER_ERROR);

						if($row = $rs->FetchRow())
							{
								$this->MUSIC_USER_NAME = $row['user_name'];
								$this->MUSIC_USER_EMAIL = $row['email'];
							}
						return true;
					}
				return false;
			}


		/**
		 * MusicUploadLib::generateOtherFormatMusics()
		 *
		 * @param string $source_filename
		 * @param string $target_file_name
		 * @return void
		 */
		public function generateOtherFormatMusics($source_filename, $target_file_name)
			{
				$org_target_file_name = $target_file_name;
				foreach($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['music_available_formats'] as $index => $type)
					{
						#Condtion for not to generate uploaded music extension is available in music_available_formats
						if($type != $this->MUSIC_EXT)
							{
								$target_file_name = $org_target_file_name.'.'.$type;
								/*if($type == 'mp4')
									{
										$source_filename = substr($source_filename,0,strrpos($source_filename,'.')).'.flv';
									}*/

								$command = '';
								$log_str = 'Generating other music formats:--'.$type."\r\n";
								/*if($this->CFG['admin']['video']['ffmpeg_encode'] || $type=='mp4')
									{
										if(isset($this->CFG['admin']['audio']['ffmpeg_path']) and file_exists($this->CFG['admin']['audio']['ffmpeg_path']))
											{
												if(isset($this->CFG['admin']['ffmpeg_command_'.$type]))
													$command = $this->CFG['admin']['ffmpeg_command_'.$type];
												$command = replaceCommandValue($command,$source_filename,$target_file_name,true);
											}
										else
											{
												$log_str.= 'ffmpeg path is null'."\r\n";
												$command='';
											}
									}
								else*/
									{
										$command = getOtherFormatsCommand($type, $source_filename, $target_file_name);
									}

								if($command)
									{
										$result = exec($command,$p);
										$log_str .= $command."\r\n";
										if(count($p))
										{
											foreach($p as $key=>$val)
											$log_str .= $key.': '.$val."\n\r";
										}
									}
								else
									$log_str .= 'No Command Available'."\r\n";

								if(method_exists($this, 'writetoTempFile'))
									$this->writetoTempFile($log_str);

								if(file_exists($target_file_name))
									{
										dbConnect();

										$sql = 'UPDATE '.$this->CFG['db']['tbl'][$this->MEDIA_TYPE_TABLE].' SET'.
												' music_available_formats = CONCAT(music_available_formats, \''.$type.'\' , \',\') WHERE '.
												' music_id='.$this->dbObj->Param('music_id');

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt, array($this->MUSIC_ID));
									    if (!$rs)
										    trigger_error($this->dbObj->ErrorNo().' '.
												$this->dbObj->ErrorMsg(), E_USER_ERROR);
										dbDisconnect();
									}
							}
						else
							{
								$log_str = 'Music available format is same as uploaded format, so other music formats not generated:'."\r\n";
								if(method_exists($this, 'writetoTempFile'))
									$this->writetoTempFile($log_str);
							}
					}
			}

		/**
		 * MusicActivate::activateMusicFile()
		 *
		 * @return boolean
		 **/
		public function activateMusicFile()
			{

				require_once($this->CFG['site']['project_path'].'music/musicCommand.inc.php');

				$dir_thumb = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
								$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['folder'].'/'.
									$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['thumbnail_folder'].'/';

				$dir_music = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
								$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['folder'].'/'.
									$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['music_folder'].'/';

				$temp_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
								$this->CFG['temp_media']['folder'].'/'.
									$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['temp_folder'].'/';


				$tempurl =  $temp_dir.$this->MUSIC_NAME;
				$imageTempUrl = $temp_dir.$this->MUSIC_THUMB_NAME;

				$dir_orginal_music = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
										$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['original_music_folder'].'/';

				/*$dir_other_format_music = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
											$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['other_musicformat_folder'].'/';*/

				$dir_trim_music = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
									$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['trimed_music_folder'];

				$trimMusicName = getTrimMusicName($this->MUSIC_ID);
				$temp_trim_file = $temp_dir.$trimMusicName;


				//if($this->MUSIC_UPLOAD_TYPE=='Normal')
					{

						## Trimming Audios ##
								$source = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
												$this->CFG['temp_media']['folder'].'/'.
													$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['temp_folder'].'/';

								$m_source_filename = $source.$this->MUSIC_NAME.'.mp3';

								$store_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
												$this->CFG['temp_media']['folder'].'/'.
													$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['temp_folder'].'/';

								$m_output_trim_filename = $store_dir.getTrimMusicName($this->MUSIC_ID).'.wav';

								$l_source_trim_filename = $source.getTrimMusicName($this->MUSIC_ID).'.wav';
								$l_output_trim_filename = $store_dir.getTrimMusicName($this->MUSIC_ID).'.mp3';

								if(is_file($m_source_filename))
									{
										//CALLING MPLAYER
										$log_str = 'CREATING TRIMED AUDIO '."\r\n";
										$playing = explode(':',$this->getFormField('playing_time'));
										$duration = $playing[0]*60+$playing[1]*60+$playing[2];
										if($this->MUSIC_PREVIEW_START > $duration
											OR $this->MUSIC_PREVIEW_END > $duration)
										{
											$this->MUSIC_PREVIEW_START = $this->CFG['admin']['musics']['trim_music_start_position'];
											$this->MUSIC_PREVIEW_END = $this->CFG['admin']['musics']['trim_music_end_position'];
										}
										$mplayer_command = getMplayerTrimCommand($m_source_filename, $m_output_trim_filename,
															 $this->MUSIC_PREVIEW_START,$this->MUSIC_PREVIEW_END);
										$log_str .= 'TRIMED AUDIO - CALLING MPLAYER FOR CONVERSION TO WAV: '."\r\n";
										$mplayer_result = exec($mplayer_command, $m_result);
										$log_str .= $mplayer_command;
										if(count($m_result))
											{
												foreach($m_result as $key=>$val)
													$log_str .= $key.': '.$val."\n\r";
											}
										if(method_exists($this, 'writetoTempFile'))
											$this->writetoTempFile($log_str);

										if(is_file($l_source_trim_filename))
											{
												//CALLING LAME
												$lame_command = getLameCommand($l_source_trim_filename, $l_output_trim_filename);
												$log_str = 'TRIMED AUDIO - CALLING LAME FOR CONVERSION TO MP3:'.$lame_command."\r\n";
												$lame_result = exec($lame_command, $l_result);
												if(count($l_result))
													{
														foreach($l_result as $key=>$val)
															$log_str .= $key.': '.$val."\n\r";
													}
											}
									if(method_exists($this, 'writetoTempFile'))
									$this->writetoTempFile($log_str);
//										if(is_file($l_source_trim_filename))
//											unlink($l_source_trim_filename);

									}

						$local_upload = true;
						if($this->getServerDetails())
							{
								dbDisconnect();
								if($FtpObj = new FtpHandler($this->FTP_SERVER,$this->FTP_USERNAME,$this->FTP_PASSWORD))
									{

										if($this->FTP_FOLDER)
											{

												if($FtpObj->changeDirectory($this->FTP_FOLDER))
													{

														$dir_thumb = $this->CFG['media']['folder'].'/'.
																		$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['folder'].'/'.
																			$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['thumbnail_folder'].'/';


														$dir_music = $this->CFG['media']['folder'].'/'.
																		$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['folder'].'/'.
																			$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['music_folder'].'/';

														$dir_orginal_music = $this->CFG['media']['folder'].'/'.$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['original_music_folder'].'/';;
														//$dir_other_format_music = $this->CFG['media']['folder'].'/'.$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['other_videoformat_folder'].'/';
														$dir_trim_music= $this->CFG['media']['folder'].'/'.$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['trimed_music_folder'];


														$upload_dir_music = $dir_music;
														$upload_dir_thumb = $dir_thumb;
														$upload_dir_orginal_music = $dir_orginal_music;
														//$upload_dir_other_format_music = $dir_other_format_music;

														$FtpObj->makeDirectory($upload_dir_music);
														$FtpObj->makeDirectory($upload_dir_thumb);
														//$FtpObj->makeDirectory($upload_dir_other_format_music);

														$uploadUrlThumb = $upload_dir_thumb.$this->MUSIC_THUMB_NAME;
														$uploadUrlMusic = $upload_dir_music.$this->MUSIC_NAME;
														$uploadUrlOrginal = $upload_dir_orginal_music.$this->MUSIC_NAME;

														if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['save_original_file_to_download'])
															$FtpObj->makeDirectory($upload_dir_orginal_music);
														/*if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['music_other_formats_enabled'])
															$FtpObj->makeDirectory($upload_dir_other_format_music);*/

														if($this->CFG['admin']['musics']['full_length_audio'] != 'All')
															$FtpObj->makeDirectory($dir_trim_music);

														if(is_file($imageTempUrl.'S.'.$this->MUSIC_THUMB_EXT))
															{
																$FtpObj->moveTo($imageTempUrl.'S.'.$this->MUSIC_THUMB_EXT, $uploadUrlThumb.'S.'.$this->MUSIC_THUMB_EXT);
																unlink($imageTempUrl.'S.'.$this->MUSIC_THUMB_EXT);
															}
														if(is_file($imageTempUrl.'M.'.$this->MUSIC_THUMB_EXT))
															{
																$FtpObj->moveTo($imageTempUrl.'M.'.$this->MUSIC_THUMB_EXT, $uploadUrlThumb.'M.'.$this->MUSIC_THUMB_EXT);
																unlink($imageTempUrl.'M.'.$this->MUSIC_THUMB_EXT);
															}
														if(is_file($imageTempUrl.'T.'.$this->MUSIC_THUMB_EXT))
															{
																$FtpObj->moveTo($imageTempUrl.'T.'.$this->MUSIC_THUMB_EXT, $uploadUrlThumb.'T.'.$this->MUSIC_THUMB_EXT);
																unlink($imageTempUrl.'T.'.$this->MUSIC_THUMB_EXT);
															}
														if(is_file($imageTempUrl.'L.'.$this->MUSIC_THUMB_EXT))
															{
																$FtpObj->moveTo($imageTempUrl.'L.'.$this->MUSIC_THUMB_EXT, $uploadUrlThumb.'L.'.$this->MUSIC_THUMB_EXT);
																unlink($imageTempUrl.'L.'.$this->MUSIC_THUMB_EXT);
															}


														if(is_file($temp_trim_file.'.mp3'))
															{
																$FtpObj->moveTo($temp_trim_file.'.mp3', $dir_trim_music.'/'.$trimMusicName.'.mp3');
																unlink($temp_trim_file.'.mp3');
															}


														/*//OTHER FORMATS
														if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['music_other_formats_enabled'])
															{
																foreach($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['music_available_formats'] as $index => $type)
																	{
																		if(is_file($tempurl.'.'.$type))
																			{
																				copy($tempurl.'.'.$type, $uploadUrlOtherFormat.'.'.$type);
																				unlink($tempurl.'.'.$type);
																			}

																	}
															}*/

														if(is_file($tempurl.'.mp3'))
															{
																$FtpObj->moveTo($tempurl.'.mp3', $uploadUrlMusic.'.mp3');
																unlink($tempurl.'.mp3');
															}

														if(is_file($tempurl.'.'.$this->MUSIC_EXT))
															{
																if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['save_original_file_to_download'])
																	$FtpObj->moveTo($tempurl.'.'.$this->MUSIC_EXT, $uploadUrlOrginal.'.'.$this->MUSIC_EXT);

																unlink($tempurl.'.'.$this->MUSIC_EXT);
															}

														$FtpObj->ftpClose();
														$SERVER_URL = $this->FTP_SERVER_URL;
														//ADDED THE TRIMMED MUSIC SERVER URL
														$TRIMMED_SERVER_URL = $this->FTP_SERVER_URL;
													}
											}
									}
								dbConnect();
								$local_upload = false;
							}
						if($local_upload)
							{
								dbDisconnect();
								$upload_dir_music = $dir_music;
								$upload_dir_thumb = $dir_thumb;
								$upload_dir_orginal_music = $dir_orginal_music;
								//$upload_dir_other_format_music = $dir_other_format_music;
								$this->chkAndCreateFolder($upload_dir_music);
								$this->chkAndCreateFolder($upload_dir_thumb);

								if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['save_original_file_to_download'])
									$this->chkAndCreateFolder($upload_dir_orginal_music);
								/*if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['music_other_formats_enabled'])
									$this->chkAndCreateFolder($upload_dir_other_format_music);*/
								$this->chkAndCreateFolder($dir_trim_music);

								$uploadUrlThumb = $upload_dir_thumb.$this->MUSIC_THUMB_NAME;
								$uploadUrlMusic = $upload_dir_music.$this->MUSIC_NAME;
								$uploadUrlOrginal = $upload_dir_orginal_music.$this->MUSIC_NAME;
								//$uploadUrlOtherFormat = $upload_dir_other_format_music.$this->MUSIC_NAME;

								if(is_file($imageTempUrl.'S.'.$this->MUSIC_THUMB_EXT))
									{
										copy($imageTempUrl.'S.'.$this->MUSIC_THUMB_EXT, $uploadUrlThumb.'S.'.$this->MUSIC_THUMB_EXT);
										unlink($imageTempUrl.'S.'.$this->MUSIC_THUMB_EXT);
									}
								if(is_file($imageTempUrl.'M.'.$this->MUSIC_THUMB_EXT))
									{
										copy($imageTempUrl.'M.'.$this->MUSIC_THUMB_EXT, $uploadUrlThumb.'M.'.$this->MUSIC_THUMB_EXT);
										unlink($imageTempUrl.'M.'.$this->MUSIC_THUMB_EXT);
									}
								if(is_file($imageTempUrl.'T.'.$this->MUSIC_THUMB_EXT))
									{
										copy($imageTempUrl.'T.'.$this->MUSIC_THUMB_EXT, $uploadUrlThumb.'T.'.$this->MUSIC_THUMB_EXT);
										unlink($imageTempUrl.'T.'.$this->MUSIC_THUMB_EXT);
									}
								if(is_file($imageTempUrl.'L.'.$this->MUSIC_THUMB_EXT))
									{
										copy($imageTempUrl.'L.'.$this->MUSIC_THUMB_EXT, $uploadUrlThumb.'L.'.$this->MUSIC_THUMB_EXT);
										unlink($imageTempUrl.'L.'.$this->MUSIC_THUMB_EXT);
									}

								if(is_file($temp_trim_file.'.mp3'))
								{
									copy($temp_trim_file.'.mp3', $dir_trim_music.'/'.$trimMusicName.'.mp3');
									unlink($temp_trim_file.'.mp3');
								}


								/*//OTHER FORMATS
								if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['music_other_formats_enabled'])
									{
										foreach($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['music_available_formats'] as $index => $type)
											{
												if(is_file($tempurl.'.'.$type))
													{
														copy($tempurl.'.'.$type, $uploadUrlOtherFormat.'.'.$type);
														unlink($tempurl.'.'.$type);
													}

											}
									}*/
								if(is_file($tempurl.'.mp3'))
									{
										copy($tempurl.'.mp3', $uploadUrlMusic.'.mp3');
										unlink($tempurl.'.mp3');
									}

								if(is_file($tempurl.'.'.$this->MUSIC_EXT))
									{
										if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['save_original_file_to_download'])
											copy($tempurl.'.'.$this->MUSIC_EXT, $uploadUrlOrginal.'.'.$this->MUSIC_EXT);
										unlink($tempurl.'.'.$this->MUSIC_EXT);
									}

								$SERVER_URL = $this->CFG['site']['url'];
								$TRIMMED_SERVER_URL = $this->CFG['site']['url'];
								dbConnect();
							}
					}

				if(isset($SERVER_URL))
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET'.
								' music_server_url='.$this->dbObj->Param('music_server_url').','.
								' trimmed_music_server_url='.$this->dbObj->Param('trimmed_music_server_url').','.
								' music_status=\'Ok\' WHERE'.
								' music_id='.$this->dbObj->Param('music_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($SERVER_URL,$TRIMMED_SERVER_URL, $this->MUSIC_ID));
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.
								$this->dbObj->ErrorMsg(), E_USER_ERROR);

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET'.
								' total_musics=total_musics+1'.
								' WHERE user_id='.$this->dbObj->Param('user_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->MUSIC_USER_ID));
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.
								$this->dbObj->ErrorMsg(), E_USER_ERROR);

						return true;
					}
				return false;
			}

		/**
		 * MusicUploadLib::changeEncodedStatus()
		 *
		 * @param string $status
		 * @return void
		 */
		public function changeEncodedStatus($status)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET music_ext=\''.$this->MUSIC_EXT.'\','.
						' music_encoded_status='.$this->dbObj->Param('music_encoded_status').
						' WHERE music_id='.$this->dbObj->Param('music_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($status, $this->MUSIC_ID));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}

		/**
		 * MusicUploadLib::storeImagesTempServer()
		 *
		 * @param string $uploadUrl
		 * @param string $extern
		 * @return void
		 */
		public function storeImagesTempServer($uploadUrl, $extern)
			{
				//GET LARGE IMAGE
				if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['large_name']=='L')
					{
						if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['large_height'] or $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['large_width'])
							{
								$this->imageObj->resize($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['large_width'], $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['large_height'], '-');
								$this->imageObj->output_resized($uploadUrl.'L.'.$extern, strtoupper($extern));
								$image_info = getImageSize($uploadUrl.'L.'.$extern);
								$this->L_WIDTH = $image_info[0];
								$this->L_HEIGHT = $image_info[1];
							}
						else
							{
								$this->imageObj->output_original($uploadUrl.'L.'.$extern, strtoupper($extern));
								$image_info = getImageSize($uploadUrl.'L.'.$extern);
								$this->L_WIDTH = $image_info[0];
								$this->L_HEIGHT = $image_info[1];
							}
					}

				//GET THUMB IMAGE
				if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['thumb_name']=='T')
					{
						$this->imageObj->resize($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['thumb_width'], $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['thumb_height'], '-');
						$this->imageObj->output_resized($uploadUrl.'T.'.$extern, strtoupper($extern));
						$image_info = getImageSize($uploadUrl.'T.'.$extern);
						$this->T_WIDTH = $image_info[0];
						$this->T_HEIGHT = $image_info[1];
					}

				//GET MEDIUM IMAGE
				if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['medium_name']=='M')
					{
						$this->imageObj->resize($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['medium_width'], $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['medium_height'], '-');
						$this->imageObj->output_resized($uploadUrl.'M.'.$extern, strtoupper($extern));
						$image_info = getImageSize($uploadUrl.'M.'.$extern);
						$this->M_WIDTH = $image_info[0];
						$this->M_HEIGHT = $image_info[1];
					}

				//GET SMALL IMAGE
				if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['small_name']=='S')
					{
						$this->imageObj->resize($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['small_width'], $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['small_height'], '-');
						$this->imageObj->output_resized($uploadUrl.'S.'.$extern, strtoupper($extern));
						$image_info = getImageSize($uploadUrl.'S.'.$extern);
						$this->S_WIDTH = $image_info[0];
						$this->S_HEIGHT = $image_info[1];
					}

				$wname = $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['large_name'].'_WIDTH';
				$hname = $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['large_name'].'_HEIGHT';
				$this->L_WIDTH = $this->$wname;
				$this->L_HEIGHT = $this->$hname;

				$wname = $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['thumb_name'].'_WIDTH';
				$hname = $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['thumb_name'].'_HEIGHT';
				$this->T_WIDTH = $this->$wname;
				$this->T_HEIGHT = $this->$hname;

				$wname = $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['medium_name'].'_WIDTH';
				$hname = $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['medium_name'].'_HEIGHT';
				$this->M_WIDTH = $this->$wname;
				$this->M_HEIGHT = $this->$hname;

				$wname = $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['small_name'].'_WIDTH';
				$hname = $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['small_name'].'_HEIGHT';
				$this->S_WIDTH = $this->$wname;
				$this->S_HEIGHT = $this->$hname;
			}

		/**
		 * MusicUploadLib::insertMusicTable()
		 *
		 * @param array $fields_arr
		 * @param string $err_tip
		 * @return integer
		 */
		public function insertMusicTable($fields_arr, $err_tip='')
			{
				$music_upload_type = '';
				if($this->fields_arr['music_upload_type']=='MultiUpload'
					or $this->fields_arr['music_upload_type']=='MassUpload')
					{
						$music_upload_type = $this->fields_arr['music_upload_type'];
						$this->fields_arr['music_upload_type'] = 'Normal';
					}
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music'].' SET ';
				foreach($fields_arr as $fieldname)
					{
						if($this->fields_arr[$fieldname]!='NOW()')
							$sql .= $fieldname.'=\''.addslashes($this->fields_arr[$fieldname]).'\', ';
						else
							$sql .= $fieldname.'='.$this->fields_arr[$fieldname].', ';
					}
				$sql = substr($sql, 0, strrpos($sql, ','));

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($music_upload_type != '')
					{
						$this->fields_arr['music_upload_type'] = $music_upload_type;
					}

				$return = $this->dbObj->Insert_ID();
				return $return;
			}

		/**
		 * MusicUploadLib::updateMusicTable()
		 *
		 * @param array $fields_arr
		 * @return void
		 */
		public function updateMusicTable($fields_arr)
			{
				//$this->setCommonFormFields();
				$param_value_arr = array();
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET ';
				foreach($fields_arr as $fieldname => $value)
					{
						if($this->fields_arr[$fieldname] != 'NOW()')
							{
								$param_value_arr[] = $this->fields_arr[$fieldname];
								$sql .= $fieldname.'='.$this->dbObj->Param($fieldname).', ';
							}
						else
							$sql .= $fieldname.'='.$this->fields_arr[$fieldname].', ';
					}
				$sql = substr($sql, 0, strrpos($sql, ','));
				$sql .= ' WHERE music_id='.$this->dbObj->Param('music_id').
						' AND user_id='.$this->dbObj->Param('user_id');
				//echo $sql,'<br><br>'; echo $this->fields_arr['music_id']; //die();
				$this->music_id = $this->fields_arr['music_id'];
				$param_value_arr[] = $this->fields_arr['music_id'];
				$param_value_arr[] = $this->CFG['user']['user_id'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $param_value_arr);

				if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}

		/**
		 * MusicUploadLib::sendMailToUserForDelete()
		 *
		 * @return boolean
		 **/
		public function sendMailToUserForDelete()
			{
				$subject = $this->LANG['music_delete_subject'];
				$body = $this->LANG['music_delete_content'];
				$this->setEmailTemplateValue('link', '<a href=\''.$this->CFG['site']['url'].'\'>'.$this->CFG['site']['url'].'</a>');
				$this->setEmailTemplateValue('user_name', $this->MUSIC_USER_NAME);
				$this->setEmailTemplateValue('music_title', $this->MUSIC_TITLE);
				if($this->_sendMail($this->MUSIC_USER_EMAIL, $subject, $body, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']))
					return true;
				else
					return false;
			}

		/**
		 * MusicUploadLib::sendMailToUserForActivate()
		 *
		 * @return boolean
		 **/
		public function sendMailToUserForActivate()
			{
				$subject = $this->LANG['music_activate_subject'];
				$body = $this->LANG['music_activate_content'];
				$this->setEmailTemplateValue('link', '<a href=\''.$this->CFG['site']['url'].'\'>'.$this->CFG['site']['url'].'</a>');
				$this->setEmailTemplateValue('user_name', $this->MUSIC_USER_NAME);
				$this->setEmailTemplateValue('music_title', $this->MUSIC_TITLE);
				$audio_link = getUrl('viewmusic','?music_id='.$this->MUSIC_ID.'&title='.$this->changeTitle($this->MUSIC_TITLE), $this->MUSIC_ID.'/'.$this->changeTitle($this->MUSIC_TITLE).'/', 'root','music');
				$this->setEmailTemplateValue('music_link', '<a href=\''.$audio_link.'\'>'.$audio_link.'</a>');
				if($this->_sendMail($this->MUSIC_USER_EMAIL, $subject, $body, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']))
					return true;
				else
					return false;
			}

		/**
		 * MusicUploadLib::chkAlbumName()
		 *
		 * @param string $album_name
		 * @return Integer
		 */
		public function chkAlbumName($album_name)
			{
				$sql = 'SELECT music_album_id FROM '.$this->CFG['db']['tbl']['music_album'].
						' WHERE album_title ='.$this->dbObj->Param('music_album_title').
						' AND ( album_access_type = \'Public\''.
						' OR user_id = '.$this->dbObj->Param('user_id').
						')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($album_name, $this->CFG['user']['user_id']));

				if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						if($rs->PO_RecordCount())
							{
								return $row['music_album_id'];
							}
					}
				return false;
			}

		public function trimMusic($music_id, $preview_start, $preview_end )
		{

			if($this->checkAndGetMusicDetails($music_id))
			{
					require_once($this->CFG['site']['project_path'].'music/musicCommand.inc.php');
					$source = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
								$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['folder'].'/'.
									$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['music_folder'].'/';


					$m_source_filename = $source.$this->MUSIC_NAME.'.mp3';

					$store_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
									$this->CFG['temp_media']['folder'].'/'.
										$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['temp_folder'].'/';
					$dir_trim_music = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
									$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['trimed_music_folder'];

					$trimMusicName = getTrimMusicName($this->MUSIC_ID);
					$temp_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
								$this->CFG['temp_media']['folder'].'/'.
									$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['temp_folder'].'/';
					$temp_trim_file = $temp_dir.$trimMusicName;
					$m_output_trim_filename = $store_dir.getTrimMusicName($this->MUSIC_ID).'.wav';

					$l_source_trim_filename = $store_dir.getTrimMusicName($this->MUSIC_ID).'.wav';
					$l_output_trim_filename = $store_dir.getTrimMusicName($this->MUSIC_ID).'.mp3';
					if(is_file($m_source_filename))
						{
							//CALLING MPLAYER
							$log_str = 'CREATING TRIMED AUDIO '."\r\n";
							$mplayer_command = getMplayerTrimCommand($m_source_filename, $m_output_trim_filename,
												 $preview_start,$preview_end);
							$log_str .= 'TRIMED AUDIO - CALLING MPLAYER FOR CONVERSION TO WAV: '."\r\n";
							$mplayer_result = exec($mplayer_command, $m_result);
							$log_str .= $mplayer_command;
							if(count($m_result))
								{
									foreach($m_result as $key=>$val)
										$log_str .= $key.': '.$val."\n\r";
								}
							if(method_exists($this, 'writetoTempFile'))
								$this->writetoTempFile($log_str);
							if(is_file($l_source_trim_filename))
								{
									//CALLING LAME
									$lame_command = getLameCommand($l_source_trim_filename, $l_output_trim_filename);
									$log_str = 'TRIMED AUDIO - CALLING LAME FOR CONVERSION TO MP3:'.$lame_command."\r\n";
									$lame_result = exec($lame_command, $l_result);
									if(count($l_result))
										{
											foreach($l_result as $key=>$val)
												$log_str .= $key.': '.$val."\n\r";
										}
									if(method_exists($this, 'writetoTempFile'))
										$this->writetoTempFile($log_str);
								}

//										if(is_file($l_source_trim_filename))
//											unlink($l_source_trim_filename);

						}

				$local_upload = true;
					if($this->getServerDetails())
					{
						dbDisconnect();
						if($FtpObj = new FtpHandler($this->FTP_SERVER,$this->FTP_USERNAME,$this->FTP_PASSWORD))
						{
							if($this->FTP_FOLDER)
							{
								if($FtpObj->changeDirectory($this->FTP_FOLDER))
								{
									//ADDED THE TRIM DIR FOR EXTERNAL SERVER
									$dir_trim_music = $this->CFG['media']['folder'].'/'.
									$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['trimed_music_folder'];

									$FtpObj->makeDirectory($dir_trim_music);
									if(is_file($temp_trim_file.'.mp3'))
									{
										$FtpObj->moveTo($temp_trim_file.'.mp3', $dir_trim_music.'/'.$trimMusicName.'.mp3');
										unlink($temp_trim_file.'.mp3');
									}
									$FtpObj->ftpClose();
								//$SERVER_URL = $this->FTP_SERVER_URL;
								$TRIMMED_SERVER_URL = $this->FTP_SERVER_URL;

								}

							}
						}
						dbConnect();
						$local_upload = false;
					}
					if($local_upload)
					{
						dbDisconnect();
						$this->chkAndCreateFolder($dir_trim_music);
						if(is_file($temp_trim_file.'.mp3'))
						{
							copy($temp_trim_file.'.mp3', $dir_trim_music.'/'.$trimMusicName.'.mp3');
							unlink($temp_trim_file.'.mp3');
						}
						$TRIMMED_SERVER_URL = $this->CFG['site']['url'];
						dbConnect();
					}
					//UPDATED THE TRIMMED SERVER URL WHILE EDITING THE PREVIEW LENGTH
					if(isset($TRIMMED_SERVER_URL))
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET'.
								' trimmed_music_server_url='.$this->dbObj->Param('trimmed_music_server_url').','.
								' music_status=\'Ok\' WHERE'.
								' music_id='.$this->dbObj->Param('music_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($TRIMMED_SERVER_URL, $music_id));
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.
								$this->dbObj->ErrorMsg(), E_USER_ERROR);
						return true;
					}
			}

		}

		/**
		 * MusicUploadLib::addAlbumName()
		 *
		 * @param string $album_name
		 * @return Integer
		 */
		public function addAlbumName($album_name, $type = 'Public')
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_album'].
						' SET album_title ='.$this->dbObj->Param('music_album_title').','.
						' album_access_type ='.$this->dbObj->Param('album_access_type').','.
						' user_id ='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($album_name, $type, $this->CFG['user']['user_id']));

				if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$albumId = $this->dbObj->Insert_ID();
				return $albumId;
			}

		/**
		 * MusicUploadLib::chkCategoryName()
		 *
		 * @param string $category_name
		 * @return booleand
		 */
		public function chkCategoryName($category_name)
			{
				$sql = 'SELECT music_category_id FROM '.$this->CFG['db']['tbl']['music_category'].
						' WHERE music_category_name ='.$this->dbObj->Param('music_category_name');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($category_name));

				if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($rs->PO_RecordCount())
					{
						if($row = $rs->FetchRow())
							{
								return $row['music_category_id'];
							}

					}
				return false;
			}

		/**
		 * MusicUploadLib::addCategoryName()
		 *
		 * @param string $category_name
		 * @return Integer
		 */
		public function addCategoryName($category_name)
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_category'].
						' SET music_category_name ='.$this->dbObj->Param('music_category_name');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($category_name));

				if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$categoryId = $this->dbObj->Insert_ID();
				return $categoryId;
			}

		/**
		 * MusicUploadLib::arrayToFields()
		 *
		 * @param array $fields_arr
		 * @return void
		 */
		public function arrayToFields($fields_arr)
			{
				foreach($fields_arr as $key => $value)
					{
						$this->setFormField($key, $value);
					}
			}

		/**
		 * MusicUploadLib::upadateArtistTable()
		 *
		 * @param string $music_artist
		 * @return void
		 */
		public function upadateArtistTable($music_artist)
			{
				$artist_arr = explode(',', $music_artist);
				$artist_arr = array_unique($artist_arr);
				if($key = array_search('', $artist_arr))
					unset($artist_arr[$key]);

				$artist_id_arr = array();

				foreach($artist_arr as $key=>$value)
					{
						if((strlen($value)<$this->CFG['fieldsize']['music_artist']['min'])
							or (strlen($value)>$this->CFG['fieldsize']['music_artist']['max']))
							continue;

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_artist'].' SET'.
								' result_count=result_count+1'.
								' WHERE artist_name='.$this->dbObj->Param('music_artist');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($value));
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.
								$this->dbObj->ErrorMsg(), E_USER_ERROR);

						if($this->dbObj->Affected_Rows())
							{
								$artist_id = $this->getArtistIdFromName($value);
								if(!empty($artist_id))
									$artist_id_arr[] = $artist_id;
							}
						else
							{
								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_artist'].' SET'.
										' artist_name='.$this->dbObj->Param('music_artist').', result_count=1';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($value));
							    if (!$rs)
								    trigger_error($this->dbObj->ErrorNo().' '.
										$this->dbObj->ErrorMsg(), E_USER_ERROR);

								$artist_id_arr[] = $this->dbObj->Insert_ID();

							}
					}
				$this->artist_id = $this->getFormField('music_artist');
				if(!empty($artist_id_arr))
					$this->artist_id = implode(',', $artist_id_arr);
			}

		/**
		 * MusicUploadLib::changeTagTable()
		 *
		 * @return void
		 */
		public function changeTagTable()
			{
				$tag_arr = explode(' ', $this->fields_arr['music_tags']);
				$tag_arr = array_unique($tag_arr);
				if($key = array_search('', $tag_arr))
					unset($tag_arr[$key]);

				foreach($tag_arr as $key=>$value)
					{
						if((strlen($value)<$this->CFG['fieldsize']['music_tags']['min'])
							or (strlen($value)>$this->CFG['fieldsize']['music_tags']['max']))
							continue;

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_tags'].' SET result_count=result_count+1'.
								' WHERE tag_name='.$this->dbObj->Param('music_tags');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($value));
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.
								$this->dbObj->ErrorMsg(), E_USER_ERROR);

						if(!$this->dbObj->Affected_Rows())
							{
								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_tags'].' SET'.
										' tag_name='.$this->dbObj->Param('music_tags').', result_count=1';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($value));
							    if (!$rs)
								    trigger_error($this->dbObj->ErrorNo().' '.
										$this->dbObj->ErrorMsg(), E_USER_ERROR);
							}
					}
			}

		/**
		 * MusicActivate::populateMusicDetails()
		 *
		 * @return boolean
		 **/
		public function populateMusicDetails()
			{
				$sql = 'SELECT m.music_title, m.music_category_id, m.music_ext,'.
						'm.music_id, m.thumb_width, m.thumb_height, m.music_thumb_ext,'.
						'u.user_name, u.email, u.user_id, relation_id FROM '.
						$this->CFG['db']['tbl']['music'].' as m LEFT JOIN '.$this->CFG['db']['tbl']['users'].
						' as u ON m.user_id=u.user_id WHERE'.
						' music_id='.$this->dbObj->Param('music_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->MUSIC_ID));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						$this->MUSIC_TITLE = $row['music_title'];
						$this->MUSIC_CATEGORY_ID = $row['music_category_id'];
						$this->MUSIC_WIDTH = $row['thumb_width'];
						$this->MUSIC_HEIGHT = $row['thumb_height'];
						$this->MUSIC_ID = $row['music_id'];
						$this->MUSIC_USER_NAME = $row['user_name'];
						$this->MUSIC_USER_EMAIL = $row['email'];
						$this->MUSIC_USER_ID = $row['user_id'];
						$this->MUSIC_EXT = $row['music_ext'];
						$this->MUSIC_THUMB_EXT = $row['music_thumb_ext'];

						$this->fields_arr['relation_id'] = $row['relation_id'];

						return true;
					}
				return false;
			}

		/**
		 * MusicUploadLib::changeTagTableForEdit()
		 *
		 * @return void
		 */
		public function changeTagTableForEdit()
			{
				$tag_arr = explode(' ', $this->fields_arr['music_tags']);
				$tag_arr = array_unique($tag_arr);
				if($key = array_search('', $tag_arr))
					unset($tag_arr[$key]);

				$oldtag_arr = explode(' ', $this->oldTags);

				foreach($oldtag_arr as $oldTag)
					{
						$sql = 'SELECT music_id FROM '.$this->CFG['db']['tbl']['music'].
								' WHERE music_tags LIKE "% '.$oldTag.' %" AND music_status!=\'Deleted\'';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array());

						if (!$rs)
							trigger_error($this->dbObj->ErrorNo().' '.
									$this->dbObj->ErrorMsg(), E_USER_ERROR);

						if(!$rs->PO_RecordCount())
							{
								$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_tags'].
										' WHERE tag_name='.$this->dbObj->Param('tag_name');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($oldTag));
								if (!$rs)
									trigger_error($this->dbObj->ErrorNo().' '.
									$this->dbObj->ErrorMsg(), E_USER_ERROR);
							}
					}
				foreach($tag_arr as $key=>$value)
					{
						if((strlen($value) < $this->CFG['fieldsize']['music_tags']['min'])
							or (strlen($value)>$this->CFG['fieldsize']['music_tags']['max']))
							continue;

						$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['music_tags'].
								' WHERE tag_name = '.$this->dbObj->Param('tag');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($value));
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.
								$this->dbObj->ErrorMsg(), E_USER_ERROR);

						if(!$rs->PO_RecordCount())
							{
								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_tags'].' SET'.
										' tag_name='.$this->dbObj->Param('music_tag').', result_count=1';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($value));
							    if (!$rs)
								    trigger_error($this->dbObj->ErrorNo().' '.
										$this->dbObj->ErrorMsg(), E_USER_ERROR);
							}
					}
			}

		/**
		 * MusicUploadLib::changeMusicEncodeStatus()
		 *
		 * @param integer $music_id
		 * @return void
		 */
		public function changeMusicEncodeStatus($music_id)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].
						' SET music_encoded_status=\'No\''.
						' WHERE music_id='.$this->dbObj->Param('music_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($music_id));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}

		/**
		 * MusicUploadLib::updateMusicPlayingTime()
		 *
		 * @param integer $music_id
		 * @return void
		 */
		public function updateMusicPlayingTime()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].
						' SET playing_time='.$this->dbObj->Param('playing_time').
						' WHERE music_id='.$this->dbObj->Param('music_id');

				$fields_value_arr = array($this->fields_arr['playing_time'],
											$this->MUSIC_ID);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}


		/**
		 * MusicUploadLib::getServerDetails()
		 *
		 * @return boolean
		 */
		public function getServerDetails()
			{
				$cid = $this->MUSIC_CATEGORY_ID.',0';
				$sql = 'SELECT server_url, ftp_server, ftp_folder, category, '.
						' ftp_usrename, ftp_password FROM '.
						$this->CFG['db']['tbl']['server_settings'].
						' WHERE server_for=\'music\' AND category IN('.$cid.')'.
						' AND server_status=\'Yes\' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if(!$rs->PO_RecordCount())
					return false;

				while($row = $rs->FetchRow())
					{
						$this->FTP_SERVER = $row['ftp_server'];
						$this->FTP_FOLDER = $row['ftp_folder'];
						$this->FTP_USERNAME = html_entity_decode($row['ftp_usrename']);
						$this->FTP_PASSWORD = html_entity_decode($row['ftp_password']);
						$this->FTP_SERVER_URL = $row['server_url'];

						if($row['category'] == $this->MUSIC_CATEGORY_ID)
							return true;
					}

				if(isset($this->FTP_SERVER) and $this->FTP_SERVER)
					return true;
				return false;
			}

		/**
		 * MusicUploadLib::updateMusicImageExt()
		 *
		 * @return boolean
		 */
		public function updateMusicImageExt()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET '.
						'large_width='.$this->dbObj->Param('large_width').', large_height='.$this->dbObj->Param('large_height').', '.
						'thumb_width='.$this->dbObj->Param('thumb_width').', thumb_height='.$this->dbObj->Param('thumb_height').', '.
						'small_width='.$this->dbObj->Param('small_width').', small_height='.$this->dbObj->Param('small_height').', '.
						'medium_width='.$this->dbObj->Param('medium_width').', medium_height='.$this->dbObj->Param('medium_height').' '.
						'WHERE music_id = '.$this->dbObj->Param('music_id');

				$stmt = $this->dbObj->Prepare($sql);
				$fields_value_arr = array($this->L_WIDTH, $this->L_HEIGHT,
										$this->T_WIDTH, $this->T_HEIGHT, $this->S_WIDTH, $this->S_HEIGHT,
										$this->M_WIDTH, $this->M_HEIGHT, $this->getFormField('music_id'));

				$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
				if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				//$this->addMusicUploadActivity()
				return true;
			}

		/**
		 * MusicUploadLib::checkIsValidMusic()
		 *
		 * @param integer $music_id
		 * @return boolean
		 */
		public function checkIsValidMusic($music_id)
			{
				$sql = 'SELECT 1 '.
						' FROM '.$this->CFG['db']['tbl']['music'].
						' WHERE (music_status=\'Ok\' OR step_status=\'Step1\') AND music_id='.$this->dbObj->Param('music_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($music_id));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if(!$rs->PO_RecordCount())
					return false;

				if($row = $rs->FetchRow())
					{
						return true;
					}
			}

		/**
		 * MusicUploadLib::populateMusicAlbums()
		 *	To get list of albums for AutoComplete acc to Relevance
		 *
		 * @param string $album
		 * @return array
		 */
		public function populateMusicAlbums($album)
			{
				$sql = 'SELECT album_title, '.
						'(CASE WHEN `album_title` LIKE \''.$album.'%\' THEN 1 ELSE 0 END) AS relevance1, '.
						'(CASE WHEN `album_title` LIKE \'%'.$album.'%\' THEN 1 ELSE 0 END) AS relevance2 '.
						' FROM '.$this->CFG['db']['tbl']['music_album'].
						' WHERE album_title LIKE \'%'.$album.'%\''.
						' AND album_access_type = \'Public\''.
						' ORDER BY relevance1 DESC, relevance2 DESC';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array());
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if(!$rs->PO_RecordCount())
					return false;

				$album_title = array();
				while($row = $rs->FetchRow())
					{
						$album_title[] = $row['album_title'];
					}
				return $album_title;
			}

		/**
		 * MusicUploadLib::sendEmailToAll()
		 *
		 * @return boolean
		 */
		public function sendEmailToAll()
			{
				  $this->EMAIL_ADDRESS = array_unique($this->EMAIL_ADDRESS);
				  if($this->EMAIL_ADDRESS)
					  {
						foreach($this->EMAIL_ADDRESS as $email)
							{
								$mailSent = false;
								$thumbnail_folder = $this->CFG['media']['folder'].'/'.
														$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['folder'].'/'.
															$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['thumbnail_folder'].'/';

								if(!empty($this->MUSIC_THUMB_EXT))
									$thumbnail = $this->CFG['site']['url'].$thumbnail_folder.getMusicImageName($this->fields_arr['music_id']).
															$this->CFG['admin']['musics']['large_name'].$this->MUSIC_THUMB_EXT;
								else
									$thumbnail = $this->CFG['site']['url'].'music/design/templates/'.
																$this->CFG['html']['template']['default'].'/root/images/'.
																	$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_audio_T.jpg';

								$music_image = '<img border="0" src="'.$thumbnail.'" alt="'.$this->MUSIC_TITLE.'" title="'.$this->MUSIC_TITLE.'" />';

								$musiclink = getUrl('viewmusic','?music_id='.$this->fields_arr['music_id'].'&title='.$this->changeTitle($this->MUSIC_TITLE), $this->fields_arr['music_id'].'/'.$this->changeTitle($this->MUSIC_TITLE).'/','members', 'music');

								$subject = str_replace('VAR_USER_NAME', $this->CFG['user']['user_name'], $this->LANG['music_share_subject']);

								$body = str_replace('VAR_USER_NAME', $this->CFG['user']['user_name'], $this->LANG['music_share_content']);
								$body = str_replace('VAR_MUSIC_IMAGE', '<a href="'.$musiclink.'">'.$music_image.'</a>', $body);
								$body = str_replace('VAR_MUSIC_DESCRIPTION', $this->MUSIC_DESCRIPTION, $body);
								$body = str_replace('VAR_PERSONAL_MESSAGE', '', $body);
								$body = str_replace('VAR_LINK', '<a href=\''.$this->CFG['site']['url'].'\'>'.$this->CFG['site']['url'].'</a>', $body);
								$body = str_replace('VAR_USER_NAME', $this->CFG['user']['user_name'], $body);
								$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
								$body=nl2br($body);
								$is_ok = $this->_sendMail($email, $subject, $body, $this->CFG['user']['name'], $this->CFG['user']['email']);
						   }
						return true;
					}
			}

		/**
		 * MusicUploadLib::addMusicUploadActivity()
		 *
		 * @return void
		 */
		public function addMusicUploadActivity()
			{
				//Start new music upload activity
				$sql = 'SELECT u.user_name as upload_user_name, m.music_id, m.user_id as upload_user_id, '.
				        ' m.music_title, m.music_server_url, m.music_thumb_ext, m.music_ext FROM '.$this->CFG['db']['tbl']['music'].
						' as m, '.$this->CFG['db']['tbl']['users'].' as u '.
						' WHERE u.user_id = m.user_id AND m.music_id='.$this->dbObj->Param('music_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->MUSIC_ID));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$row = $rs->FetchRow();
				$activity_arr = $row;
				$activity_arr['action_key']	= 'music_uploaded';
				$musicActivityObj = new MusicActivityHandler();
				$musicActivityObj->addActivity($activity_arr);
				//End..
			}

		/**
		 * MusicUploadLib::populateMusicArtists()
		 *	To get list of artists for AutoComplete acc to Relevance
		 *
		 * @param string $artist
		 * @return array
		 */
		public function populateMusicArtists($artist)
			{
				$strtoarray = explode(',',$artist);
				$artist = array_pop($strtoarray);
				$sql = 'SELECT artist_name, '.
						'(CASE WHEN `artist_name` LIKE \''.$artist.'%\' THEN 1 ELSE 0 END) AS relevance1, '.
						'(CASE WHEN `artist_name` LIKE \'%'.$artist.'%\' THEN 1 ELSE 0 END) AS relevance2 '.
						' FROM '.$this->CFG['db']['tbl']['music_artist'].
						' WHERE artist_name LIKE \'%'.$artist.'%\''.
						' AND music_artist_id!=1'.
						' ORDER BY relevance1 DESC, relevance2 DESC';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array());
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if(!$rs->PO_RecordCount())
					return false;

				$artist_name = array();
				while($row = $rs->FetchRow())
					{
						$artist_name[] = trim($row['artist_name']);
					}
				return $artist_name;
			}

		/**
		 * MusicUploadLib::chkAndAddMusicPurchases()
		 *
		 * @param mixed $album_id
		 * @param mixed $music_id
		 * @return
		 */
		public function chkAndAddMusicPurchases($album_id, $music_id)
		{
			$album_details = getMusicAlbumDetails($album_id);
			if($album_details['album_access_type']=='Private'
				and $album_details['album_for_sale']=='Yes'
				and $album_details['album_price']>0)
			{
				$album_purchased_users = getPurchasedUserDetails($album_id);
				if($album_purchased_users)
				{
					foreach($album_purchased_users as $user_id)
					{
						$sql = 'INSERT INTO '.
								$this->CFG['db']['tbl']['music_purchase_user_details'].
								' SET '.
								' user_id='.$this->dbObj->Param('user_id').','.
								' music_id='.$this->dbObj->Param('music_id').','.
								' album_id='.$this->dbObj->Param('album_id').','.
								' date_added=now()';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($user_id, $music_id, $album_id));
						if (!$rs)
							trigger_error($this->dbObj->ErrorNo().' '.
							$this->dbObj->ErrorMsg(), E_USER_ERROR);
					}
				}
			}
		}

	}

?>