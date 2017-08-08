<?php
/**
 * Class to handle the Video Upload
 *
 * This is having class VideoUploadLib to handle the Video Upload
 * (includes encode, activate and other stuffs)
 *
 *
 * @category	###Framework###
 * @package		###Common/Classes###
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id : $
 * @since 		2005-22-05
 *
 */
/**
 * --------------------------------------
 *
 * When using this class for another module, the InitializeVideoUploadLib() needs to be called with the following params;
 *
 * $MEDIA_TYPE: This defines the module that you going to used.
 *
 * $MEDIA_TYPE_CFG: This defines the module name appears at CFG.
 * For example: If you using the module 'new_module' and the name
 * appears at $CFG as 'new_modules' like CFG['admin]['new_modules']['video_auto_activate'], then you need to give the name 'new_modules'
 *
 * $MEDIA_TYPE_TABLE: This defines the name of the module table. For example: new_module_video
 *
 * $MEDIA_INITIAL_PATH: This defines the initial path of the media folder.
 * For example: If your module name is 'new_module', the uploader page will be in folder 'root_path/modules/general/'
 * Now 'files' folder can be accessed using '../../../'. So this text ('../../../') need to be provided.
 *
 * $MEDIA_VIEW_VIDEO_PATH: This defines the view video URL for your new_module.
 * For example if your new_module video can be accessed using this link like this:
 * http://localhost/modules/new_module/viewNewModuleVideo?new_module_id=1&video_id=3
 * Then, you need to give this as video_id={video_id}, then the {video_id} will be replaced by the video_id
 * In case there is no video_id required means, you can ignore the {video_id}.
 *
 */
if(class_exists('VideoHandler'))
	{
		class VideoUploadHandler extends VideoHandler{}
	}
else if(class_exists('MediaHandler'))
	{
		class VideoUploadHandler extends MediaHandler{}
	}
else if(class_exists('ListRecordsHandler'))
	{
		class VideoUploadHandler extends ListRecordsHandler{}
	}
else if(class_exists('FormHandler'))
	{
		class VideoUploadHandler extends FormHandler{}
	}
else
	{
		class VideoUploadHandler{}
	}

class VideoUploadLib extends VideoUploadHandler
	{

		public function VideoUploadLib() //Constructor
			{
				parent::__construct();
				//This will be set as default
				$this->MEDIA_TYPE='video';
				$this->MEDIA_TYPE_CFG='videos';
				$this->MEDIA_TYPE_TABLE='video';
				$this->MEDIA_INITIAL_PATH='../';
				$this->MEDIA_VIEW_VIDEO_PATH=getUrl('viewvideo','?video_id={video_id}', 'viewvideo/{video_id}/', '','video');
			}

		public function InitializeVideoUploadLib($MEDIA_TYPE='video',$MEDIA_TYPE_CFG='videos', $MEDIA_TYPE_TABLE='video',  $MEDIA_INITIAL_PATH='../', $MEDIA_VIEW_VIDEO_PATH='')
			{
				$this->MEDIA_TYPE=$MEDIA_TYPE;
				$this->MEDIA_TYPE_CFG=$MEDIA_TYPE_CFG;
				$this->MEDIA_TYPE_TABLE=$MEDIA_TYPE_TABLE;
				$this->MEDIA_INITIAL_PATH=$MEDIA_INITIAL_PATH;
				$this->MEDIA_VIEW_VIDEO_PATH=$MEDIA_VIEW_VIDEO_PATH;

			}

		/**
		 * VideoUpload::setIHObject()
		 *
		 * @param $imObj
		 * @return
		 **/
		public function setIHObject($imObj)
			{
				$this->imageObj = $imObj;
			}

		/**
		 * VideoUpload::getServerDetails()
		 *
		 * @return
		 **/
		public function getServerDetails()
			{
				$cid = $this->VIDEO_CATEGORY_ID.',0';
				$sql = 'SELECT server_url, ftp_server, ftp_folder, category, ftp_usrename, ftp_password FROM'.
						' '.$this->CFG['db']['tbl']['server_settings'].
						' WHERE server_for=\'video\' AND category IN('.$cid.')'.
						' AND server_status=\'Yes\' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if(!$rs->PO_RecordCount())
					return false;

				while($row = $rs->FetchRow())
					{

						$this->FTP_SERVER = $row['ftp_server'];
						$this->FTP_FOLDER = $row['ftp_folder'];
						$this->FTP_USERNAME = html_entity_decode($row['ftp_usrename']);
						$this->FTP_PASSWORD = html_entity_decode($row['ftp_password']);
						$this->FTP_SERVER_URL = $row['server_url'];

						if($row['category']==$this->VIDEO_CATEGORY_ID)
							return true;
					}

				if(isset($this->FTP_SERVER) and $this->FTP_SERVER)
					return true;
				return false;
			}

		/**
		 * VideoActivate::activateVideoFile()
		 *
		 * @return
		 **/

		public function activateVideoFile()
			{
				$dir_thumb = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
								$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['folder'].'/'.
									$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['thumbnail_folder'].'/';
				$dir_video = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
								$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['folder'].'/'.
									$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['video_folder'].'/';

				$temp_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
								$this->CFG['temp_media']['folder'].'/'.
									$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['temp_folder'].'/';

				$tempurl =  $temp_dir.$this->VIDEO_NAME;
				$imageTempUrl=$temp_dir.$this->VIDEO_THUMB_NAME;
				## Orginal Video & Other format video are stored in Different Folder
				$dir_orginal_video = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
										$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['original_video_folder'].'/';
				$dir_other_format_video = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
											$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['other_videoformat_folder'].'/';
				$dir_trim_video = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
									$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['trimed_video_folder'];
				$trimVideoName = getTrimVideoName($this->VIDEOID);
				$temp_trim_file = $temp_dir.$trimVideoName;

				//@todo check if the config variable is set
				if(is_file($tempurl.'.flv') and $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['rotating_thumbnail_feature'])
					{
						$imageAnimate=new imagesAnimate();
						$imageAnimate->makeGlobalize($this->CFG,$this->LANG);

						$imageAnimate->MEDIA_TYPE_CFG=$this->MEDIA_TYPE_CFG;
						$imageAnimate->fp=$this->fp;
						$imageTempUrl=$temp_dir.$this->VIDEO_THUMB_NAME;

						if($imageAnimate->intitializeImagesAnimate($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['rotating_thumbnail_delay_time'],
							 $temp_dir, $tempurl, $this->VIDEO_NAME,$this->VIDEO_THUMB_NAME,
							 	$this->CFG, $this->getFormField('playing_time'),$this->VIDEO_EXT))
							{

								$sql = 'UPDATE '.$this->CFG['db']['tbl'][$this->MEDIA_TYPE_TABLE].' SET '.
										' is_gif_animated=\'yes\',animated_gif_file_names=\''.$imageAnimate->GENERATED_GIF_FILE_NAMES.'\' WHERE '.
										' video_id='.$this->dbObj->Param('video_id');
										$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->VIDEO_ID));
							    if (!$rs)
								    trigger_error($this->dbObj->ErrorNo().' '.
										$this->dbObj->ErrorMsg(), E_USER_ERROR);
							}
					}
				## Trimming Videos ##
				//if($this->CFG['admin']['videos']['full_length_video']!='All') -- Commented since to generate Trimmed video without checking condition (Always)
				{
					$this->trimVideo($this->VIDEOID,$tempurl.'.flv',$this->CFG['admin']['videos']['trim_video_start_time'],
										$this->CFG['admin']['videos']['trim_video_end_time']);
				}


				## Trimming Video Ends ##
				if($this->FLV_UPLOAD_TYPE=='externalsitevideourl')
				{
					if(!isset($this->external_video_details_arr))
					{
						$external_obj = new ExternalVideoUrlHandler();
						$this->external_video_details_arr = $external_obj->chkIsValidExternalSite($this->VIDEO_FLV_URL,'',$this->CFG);
					}
					if((!$this->CFG['admin']['videos']['download_youtube_videos'] && $this->external_video_details_arr['external_site']=='youtube') || (!$this->CFG['admin']['videos']['download_google_videos'] && $this->external_video_details_arr['external_site']=='google') || (!$this->CFG['admin']['videos']['download_dailymotion_videos'] && $this->external_video_details_arr['external_site']=='dailymotion')  || (!$this->CFG['admin']['videos']['download_myspace_videos'] && $this->external_video_details_arr['external_site']=='myspace') || (!$this->CFG['admin']['videos']['download_flvpath_videos'] && $this->external_video_details_arr['external_site']=='flvpath'))
					{
						unlink($tempurl.'.flv');
					}
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

								$dir_thumb = $this->CFG['media']['folder'].'/'.$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['folder'].'/'.$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['thumbnail_folder'].'/';
								$dir_video = $this->CFG['media']['folder'].'/'.$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['folder'].'/'.$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['video_folder'].'/';

								$dir_orginal_video = $this->CFG['media']['folder'].'/'.$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['original_video_folder'].'/';
								$dir_other_format_video = $this->CFG['media']['folder'].'/'.$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['other_videoformat_folder'].'/';
								$dir_trim_video= $this->CFG['media']['folder'].'/'.$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['trimed_video_folder'].'/';


								$FtpObj->makeDirectory($dir_video);
								$FtpObj->makeDirectory($dir_thumb);

								if(is_file($imageTempUrl.'T.'.$this->CFG['video']['image']['extensions']))
									{
										$FtpObj->moveTo($imageTempUrl.'T.'.$this->CFG['video']['image']['extensions'], $dir_thumb.$this->VIDEO_THUMB_NAME.'T.'.$this->CFG['video']['image']['extensions']);
										unlink($imageTempUrl.'T.'.$this->CFG['video']['image']['extensions']);
									}
								if(is_file($imageTempUrl.'S.'.$this->CFG['video']['image']['extensions']))
									{
										$FtpObj->moveTo($imageTempUrl.'S.'.$this->CFG['video']['image']['extensions'], $dir_thumb.$this->VIDEO_THUMB_NAME.'S.'.$this->CFG['video']['image']['extensions']);
										unlink($imageTempUrl.'S.'.$this->CFG['video']['image']['extensions']);
									}
								if(is_file($imageTempUrl.'L.'.$this->CFG['video']['image']['extensions']))
									{
										$FtpObj->moveTo($imageTempUrl.'L.'.$this->CFG['video']['image']['extensions'], $dir_thumb.$this->VIDEO_THUMB_NAME.'L.'.$this->CFG['video']['image']['extensions']);
										unlink($imageTempUrl.'L.'.$this->CFG['video']['image']['extensions']);
									}
								if(is_file($imageTempUrl.'_1.'.$this->CFG['video']['image']['extensions']))
									{
										$FtpObj->moveTo($imageTempUrl.'_1.'.$this->CFG['video']['image']['extensions'], $dir_thumb.$this->VIDEO_THUMB_NAME.'_1.'.$this->CFG['video']['image']['extensions']);
										unlink($imageTempUrl.'_1.'.$this->CFG['video']['image']['extensions']);
									}
								if(is_file($imageTempUrl.'_2.'.$this->CFG['video']['image']['extensions']))
									{
										$FtpObj->moveTo($imageTempUrl.'_2.'.$this->CFG['video']['image']['extensions'], $dir_thumb.$this->VIDEO_THUMB_NAME.'_2.'.$this->CFG['video']['image']['extensions']);
										unlink($imageTempUrl.'_2.'.$this->CFG['video']['image']['extensions']);
									}
								if(is_file($imageTempUrl.'_3.'.$this->CFG['video']['image']['extensions']))
									{
										$FtpObj->moveTo($imageTempUrl.'_3.'.$this->CFG['video']['image']['extensions'], $dir_thumb.$this->VIDEO_THUMB_NAME.'_3.'.$this->CFG['video']['image']['extensions']);
										unlink($imageTempUrl.'_3.'.$this->CFG['video']['image']['extensions']);
									}
								if(is_file($tempurl.'.flv'))
									{
										$FtpObj->moveTo($tempurl.'.flv', $dir_video.$this->VIDEO_NAME.'.flv');
										unlink($tempurl.'.flv');
									}




								/*
								* Moving gif animations to ftp
								* Creating animated gif directory
								*/
								if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['rotating_thumbnail_feature'])
								{
									$FtpObj->makeDirectory($dir_thumb.$this->VIDEO_THUMB_NAME.'_gif/');
		 							if(isset($imageAnimate->GENERATED_GIF_FILE_PATHS) and $imageAnimate->GENERATED_GIF_FILE_PATHS)
									{
										foreach($imageAnimate->GENERATED_GIF_FILE_PATHS as $index=>$file_name)
											{
													if(is_file($file_name))
					  									{
					  										$FtpObj->moveTo($file_name, $dir_thumb.$this->VIDEO_THUMB_NAME.'_gif/'.$index.'.jpg');
					  										unlink($file_name);
					  									}
											}
									}


								if(is_file($temp_dir.$this->VIDEO_THUMB_NAME.'_G.gif'))
  									{
										$FtpObj->moveTo($temp_dir.$this->VIDEO_THUMB_NAME.'_G.gif', $dir_thumb.$this->VIDEO_THUMB_NAME.'_G.gif');
										unlink($temp_dir.$this->VIDEO_THUMB_NAME.'_G.gif');
									}
								if(isset($imageAnimate->JPG_PATH) and $imageAnimate->JPG_PATH)
									$this->removeDirectory($imageAnimate->JPG_PATH);
								if(isset($imageAnimate->GIF_PATH_TO_GENERATE) and $imageAnimate->GIF_PATH_TO_GENERATE)
									$this->removeDirectory($imageAnimate->GIF_PATH_TO_GENERATE);
								}



								if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['save_original_file_to_download'])
									$FtpObj->makeDirectory($dir_orginal_video);
								if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['video_other_formats_enabled'])
									$FtpObj->makeDirectory($dir_other_format_video);
								//if($this->CFG['admin']['videos']['full_length_video']!='All')
									$FtpObj->makeDirectory($dir_trim_video);

								//if($this->CFG['admin']['videos']['full_length_video']!='All')
								{
									if(is_file($temp_trim_file.'.flv'))
									{
										$FtpObj->moveTo($temp_trim_file.'.flv', $dir_trim_video.$trimVideoName.'.flv');
										unlink($temp_trim_file.'.flv');
									}
								}


								//OTHER FORMATS
								if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['video_other_formats_enabled'])
								{
									foreach($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['video_available_formats'] as $index=>$type)
									{
										if(is_file($tempurl.'.'.$type))
											{
												$FtpObj->moveTo($tempurl.'.'.$type, $dir_other_format_video.$this->VIDEO_NAME.'.'.$type);
												unlink($tempurl.'.'.$type);
											}
											else
											{
											$log_str='Other Format Video is not Generated for this video'."\r\n";
												if(method_exists($this, 'writetoTempFile'))
												$this->writetoTempFile($log_str);
											}
									}
								}
								//OTHER FORMATS
								if(is_file($tempurl.'.'.$this->VIDEO_EXT))
									{
										if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['save_original_file_to_download'])
											$FtpObj->moveTo($tempurl.'.'.$this->VIDEO_EXT, $dir_orginal_video.$this->VIDEO_NAME.'.'.$this->VIDEO_EXT);
											//$FtpObj->moveTo($tempurl.'.'.$this->VIDEO_EXT, $dir_video.$this->VIDEO_NAME.'.'.$this->VIDEO_EXT);
										unlink($tempurl.'.'.$this->VIDEO_EXT);
									}
								$FtpObj->ftpClose();
								$SERVER_URL = $this->FTP_SERVER_URL;

								}
							}
						}
						dbConnect();
						$local_upload = false;
					}

				if($local_upload)
					{
						dbDisconnect();
						$upload_dir_thumb = $dir_thumb;
						$upload_dir_video = $dir_video;
						$upload_dir_orginal_video =$dir_orginal_video;
						$upload_dir_other_format_video =$dir_other_format_video;

						$this->chkAndCreateFolder($upload_dir_thumb);
						$this->chkAndCreateFolder($upload_dir_video);

						if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['save_original_file_to_download'])
							$this->chkAndCreateFolder($upload_dir_orginal_video);
						if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['video_other_formats_enabled'])
							$this->chkAndCreateFolder($upload_dir_other_format_video);
						//if($this->CFG['admin']['videos']['full_length_video']!='All')
							$this->chkAndCreateFolder($dir_trim_video);

						$uploadUrlThumb = $upload_dir_thumb.$this->VIDEO_THUMB_NAME;
						$uploadUrlVideo = $upload_dir_video.$this->VIDEO_NAME;
						$uploadUrlOrginal=$upload_dir_orginal_video.$this->VIDEO_NAME;
						$uploadUrlOtherFormat=$upload_dir_other_format_video.$this->VIDEO_NAME;

						if(is_file($imageTempUrl.'S.'.$this->CFG['video']['image']['extensions']))
							{
								copy($imageTempUrl.'S.'.$this->CFG['video']['image']['extensions'], $uploadUrlThumb.'S.'.$this->CFG['video']['image']['extensions']);
								unlink($imageTempUrl.'S.'.$this->CFG['video']['image']['extensions']);
							}
						if(is_file($imageTempUrl.'T.'.$this->CFG['video']['image']['extensions']))
							{
								copy($imageTempUrl.'T.'.$this->CFG['video']['image']['extensions'], $uploadUrlThumb.'T.'.$this->CFG['video']['image']['extensions']);
								unlink($imageTempUrl.'T.'.$this->CFG['video']['image']['extensions']);
							}
						if(is_file($imageTempUrl.'L.'.$this->CFG['video']['image']['extensions']))
							{
								copy($imageTempUrl.'L.'.$this->CFG['video']['image']['extensions'], $uploadUrlThumb.'L.'.$this->CFG['video']['image']['extensions']);
								unlink($imageTempUrl.'L.'.$this->CFG['video']['image']['extensions']);
							}
						if(is_file($imageTempUrl.'_1.'.$this->CFG['video']['image']['extensions']))
							{
								copy($imageTempUrl.'_1.'.$this->CFG['video']['image']['extensions'], $uploadUrlThumb.'_1.'.$this->CFG['video']['image']['extensions']);
								unlink($imageTempUrl.'_1.'.$this->CFG['video']['image']['extensions']);
							}
						if(is_file($imageTempUrl.'_2.'.$this->CFG['video']['image']['extensions']))
							{
								copy($imageTempUrl.'_2.'.$this->CFG['video']['image']['extensions'], $uploadUrlThumb.'_2.'.$this->CFG['video']['image']['extensions']);
								unlink($imageTempUrl.'_2.'.$this->CFG['video']['image']['extensions']);
							}
						if(is_file($imageTempUrl.'_3.'.$this->CFG['video']['image']['extensions']))
							{
								copy($imageTempUrl.'_3.'.$this->CFG['video']['image']['extensions'], $uploadUrlThumb.'_3.'.$this->CFG['video']['image']['extensions']);
								unlink($imageTempUrl.'_3.'.$this->CFG['video']['image']['extensions']);
							}
						$this->chkAndCreateFolder($upload_dir_thumb.$this->VIDEO_THUMB_NAME.'_gif/');

						//if($this->CFG['admin']['videos']['full_length_video']!='All')
								{
									if(is_file($temp_trim_file.'.flv'))
									{
										copy($temp_trim_file.'.flv', $dir_trim_video.'/'.$trimVideoName.'.flv');
										unlink($temp_trim_file.'.flv');
									}
								}

						if(isset($imageAnimate->GENERATED_GIF_FILE_PATHS) and $imageAnimate->GENERATED_GIF_FILE_PATHS)
 							{
 								foreach($imageAnimate->GENERATED_GIF_FILE_PATHS as $index=>$file_name)
 									{
 										if(is_file($file_name))
 			  								{

	 											copy($file_name, $upload_dir_thumb.$this->VIDEO_THUMB_NAME.'_gif/'.$index.'.jpg');
	 											unlink($file_name);
 			  								}
 									}
 							}
						if(is_file($temp_dir.$this->VIDEO_THUMB_NAME.'_G.gif'))
							{
								copy($temp_dir.$this->VIDEO_THUMB_NAME.'_G.gif', $uploadUrlThumb.'_G.gif');
								unlink($temp_dir.$this->VIDEO_THUMB_NAME.'_G.gif');
							}
						if(isset($imageAnimate->JPG_PATH) and $imageAnimate->JPG_PATH)
							$this->removeDirectory($imageAnimate->JPG_PATH);
						if(isset($imageAnimate->GIF_PATH_TO_GENERATE) and $imageAnimate->GIF_PATH_TO_GENERATE)
							$this->removeDirectory($imageAnimate->GIF_PATH_TO_GENERATE);
						if(is_file($tempurl.'.flv'))
							{
								copy($tempurl.'.flv', $uploadUrlVideo.'.flv');
								unlink($tempurl.'.flv');
							}
						if(is_file($tempurl.'.'.$this->VIDEO_EXT))
						{
								if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['save_original_file_to_download'])
									copy($tempurl.'.'.$this->VIDEO_EXT, $uploadUrlOrginal.'.'.$this->VIDEO_EXT);
									//copy($tempurl.'.'.$this->VIDEO_EXT, $uploadUrlVideo.'.'.$this->VIDEO_EXT);

						}
						//OTHER FORMATS
						if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['video_other_formats_enabled'])
						{
							foreach($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['video_available_formats'] as $index=>$type)
							{
								if(is_file($tempurl.'.'.$type))
									{
										copy($tempurl.'.'.$type, $uploadUrlOtherFormat.'.'.$type);
										unlink($tempurl.'.'.$type);
									}

							}
						}
						if(file_exists($tempurl.'.'.$this->VIDEO_EXT))
							unlink($tempurl.'.'.$this->VIDEO_EXT);
						//OTHER FORMATS
						$SERVER_URL = $this->CFG['site']['url'];
						dbConnect();
					}
				if(isset($SERVER_URL))
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl'][$this->MEDIA_TYPE_TABLE].' SET'.
								' video_server_url='.$this->dbObj->Param('video_server_url').', video_status=\'Ok\' WHERE'.
								' video_id='.$this->dbObj->Param('video_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($SERVER_URL, $this->VIDEO_ID));
						    if (!$rs)
							    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET'.
								' total_videos=total_videos+1'.
								' WHERE user_id='.$this->dbObj->Param('user_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->VIDEO_USER_ID));
						if (!$rs)
							trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						//Srart new video upload activity	..
						$sql = 'SELECT u.user_name as upload_user_name, v.video_id, v.user_id as upload_user_id, v.video_title, v.video_server_url, v.is_external_embed_video, v.embed_video_image_ext '.
								' FROM '.$this->CFG['db']['tbl']['video'].' as v, '.$this->CFG['db']['tbl']['users'].' as u WHERE u.user_id = v.user_id AND video_id = '.$this->dbObj->Param('video_id');
						//echo $this->VIDEO_ID;
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->VIDEO_ID));
						if (!$rs)
							trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						$row = $rs->FetchRow();
						$activity_arr = $row;
						$activity_arr['action_key']	= 'video_uploaded';
						$videoActivityObj = new VideoActivityHandler();
						$videoActivityObj->addActivity($activity_arr);
						//End..


						$this->sendMailToUserForActivate();
						if($this->VIDEO_RELATION_ID)
						{
							$this->getEmailAddressOfRelation($this->VIDEO_RELATION_ID);
							$this->sendEmailToAll();
						}
						$content = $activity_arr['upload_user_id'].'~'.
											$activity_arr['upload_user_name'].'~'.
											$activity_arr['video_id'].'~'.
											$activity_arr['video_title'].'~'.
											$activity_arr['video_server_url'].'~'.
											$activity_arr['is_external_embed_video'].'~'.
											$activity_arr['embed_video_image_ext'].'~';


						//Add recod for subscribtions
						$subscription_data_arr['owner_id'] = $this->VIDEO_USER_ID;
						$subscription_data_arr['content_id'] = $this->VIDEO_ID;
						$subscription_data_arr['category_id'] = $this->VIDEO_CATEGORY_ID;
						$subscription_data_arr['sub_category_id'] = $this->VIDEO_SUB_CATEGORY_ID;
						$tags = str_replace(' ', ',', $this->VIDEO_TAGS);
						$subscription_data_arr['tag_name'] = $tags;
						$subscription_data_arr['content'] = $content;
						$this->addSubscriptionData($subscription_data_arr);

						return true;
					}
				return false;
			}

		/**
		 * VideoActivate::populateVideoDetails()
		 *
		 * @return
		 **/
		public function populateVideoDetails()
			{
				$sql = 'SELECT v.video_title, v.video_category_id, v.video_sub_category_id, v.video_ext, v.t_width, v.t_height, v.video_id, v.video_tags, flv_upload_type, video_available_formats, is_external_embed_video, video_external_embed_code, video_flv_url,'.
						' u.user_name, u.email, u.user_id,relation_id FROM'.
						' '.$this->CFG['db']['tbl'][$this->MEDIA_TYPE_TABLE].' as v LEFT JOIN '.$this->CFG['db']['tbl']['users'].
						' as u ON v.user_id=u.user_id WHERE'.
						' video_id='.$this->dbObj->Param('video_id').' AND video_encoded_status=\'Yes\' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->VIDEO_ID));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						$this->VIDEO_TITLE = $row['video_title'];
						$this->VIDEO_CATEGORY_ID = $row['video_category_id'];
						$this->VIDEO_SUB_CATEGORY_ID = $row['video_sub_category_id'];
						$this->VIDEO_WIDTH = $row['t_width'];
						$this->VIDEO_HEIGHT = $row['t_height'];
						$this->VIDEO_ID = $row['video_id'];
						$this->VIDEO_TAGS = $row['video_tags'];
						$this->VIDEO_USER_NAME = $row['user_name'];
						$this->VIDEO_USER_EMAIL = $row['email'];
						$this->VIDEO_USER_ID = $row['user_id'];
						$this->VIDEO_EXT = $row['video_ext'];
						$this->FLV_UPLOAD_TYPE = $row['flv_upload_type'];
						$this->VIDEO_FLV_URL = $row['video_flv_url'];
						$this->VIDEO_AVL_FORMAT = $row['video_available_formats'];
						$this->IS_EMBED_VIDEO = $row['is_external_embed_video'];
						$this->VIDEO_EMBED_CODE = $row['video_external_embed_code'];
						$this->fields_arr['relation_id'] = $row['relation_id'];

						return true;
					}
				return false;

			}


		/**
		 * VideoUpload::sendMailToUserForActivate()
		 *
		 * @return
		 **/
		public function sendMailToUserForActivate()
			{
				$subject = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $this->LANG[''.$this->MEDIA_TYPE.'_activate_subject']);
				$body = $this->LANG[''.$this->MEDIA_TYPE.'_activate_content'];
				$body = str_replace('VAR_LINK', '<a href=\''.$this->CFG['site']['url'].'\'>'.$this->CFG['site']['url'].'</a>', $body);
				$body = str_replace('VAR_USER_NAME', $this->VIDEO_USER_NAME, $body);
				$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
				$body = str_replace('VAR_VIDEO_TITLE', $this->VIDEO_TITLE, $body);
				$video_link=getUrl('viewvideo','?video_id='.$this->VIDEO_ID.'&video_title='.$this->VIDEO_TITLE, $this->VIDEO_ID.'/'.$this->VIDEO_TITLE.'/', 'root','video');
				$body = str_replace('VAR_VIDEO_LINK', '<a href=\''.$video_link.'\'>'.$video_link.'</a>', $body);
				$body=nl2br($body);
				if($this->_sendMail($this->VIDEO_USER_EMAIL, $subject, $body, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']))
					return true;
				else
				return false;

			}

		/**
		 * VideoUpload::sendMailToUserForInvalidVideo()
		 *
		 * @return
		 **/
		public function sendMailToUserForInvalidVideo()
			{
				$subject = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $this->LANG[''.$this->MEDIA_TYPE.'_invalid_upload_subject']);
				$body = $this->LANG[''.$this->MEDIA_TYPE.'_invalid_upload_content'];
				$body = str_replace('VAR_LINK', '<a href=\''.$this->CFG['site']['url'].'\'>'.$this->CFG['site']['url'].'</a>', $body);
				$body = str_replace('VAR_USER_NAME', $this->VIDEO_USER_NAME, $body);
				$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
				$body = str_replace('VAR_VIDEO_TITLE', $this->VIDEO_TITLE, $body);
				$body=nl2br($body);
				if($this->_sendMail($this->VIDEO_USER_EMAIL, $subject, $body, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']))
					return true;
				else
				return false;
			}

		/**
		 * VideoUpload::storeImagesTempServer()
		 *
		 * @param $uploadUrl
		 * @param $extern
		 * @return
		 **/
		public function storeImagesTempServer($uploadUrl, $extern)
			{
				//GET LARGE IMAGE
				if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['large_name']=='L')
					{
						//NOTE: Commented resizing original image to large thumbnail config's size, to maintain the original size
						/*if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['large_height'] or $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['large_width'])
							{
								$this->imageObj->resize($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['large_width'], $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['large_height'], '-');
								$this->imageObj->output_resized($uploadUrl.'L.'.$extern, strtoupper($extern));
								$image_info = getImageSize($uploadUrl.'L.'.$extern);
								$this->L_WIDTH = $image_info[0];
								$this->L_HEIGHT = $image_info[1];
							}
						else*/
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

				$wname = $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['small_name'].'_WIDTH';
				$hname = $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['small_name'].'_HEIGHT';
				$this->S_WIDTH = $this->$wname;
				$this->S_HEIGHT = $this->$hname;
			}


		public function selectVideoIdFromTable($video_id)
			{
				$sql = 'SELECT user_id, video_id, video_ext, video_category_id, video_title, playing_time, flv_upload_type, video_flv_url,video_caption,relation_id FROM '.$this->CFG['db']['tbl'][$this->MEDIA_TYPE_TABLE].
						' WHERE video_encoded_status=\'No\' AND video_id='.$this->dbObj->Param('video_id').
						' ORDER BY video_id LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($video_id));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						$this->VIDEO_ID = $row['video_id'];
						$this->VIDEO_CATEGORY_ID = $row['video_category_id'];
						$this->VIDEO_DESCRIPTION=$row['video_caption'];
						$this->VIDEO_NAME = getVideoName($this->VIDEO_ID);
						$this->VIDEO_THUMB_NAME = getVideoImageName($this->VIDEO_ID);
						$this->VIDEO_EXT = $row['video_ext'];
						$this->VIDEO_TITLE = $row['video_title'];
						$this->FLV_UPLOAD_TYPE = $row['flv_upload_type'];
						$this->VIDEO_FLV_URL = $row['video_flv_url'];
						$this->VIDEO_RELATION_ID =$row['relation_id'];
						$this->PLAYING_TIME  = $row['playing_time'];

						$sql = 'SELECT user_name, email FROM '.$this->CFG['db']['tbl']['users'].
								' WHERE user_id='.$this->dbObj->Param('user_id').' LIMIT 0,1';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($row['user_id']));
						    if (!$rs)
							    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						if($row = $rs->FetchRow())
							{
								$this->VIDEO_USER_NAME = $row['user_name'];
								$this->VIDEO_USER_EMAIL = $row['email'];
							}
						return true;
					}
				return false;
			}

		/**
		 * VideoUpload::videoEncode()
		 *
		 * @param $video_id
		 * @return
		 **/
		public function videoEncode($video_id)
			{

				$this->VIDEOID=$video_id;
				if($this->selectVideoIdFromTable($video_id))
					{

						$source_filename = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['temp_folder'].'/'.$this->VIDEO_NAME.'.'.$this->VIDEO_EXT;
						$store_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['temp_folder'].'/';
						$log_str = 'Source file for encoding :'.$source_filename."\r\n";

						if(method_exists($this, 'writetoTempFile'))
							$this->writetoTempFile($log_str);

						if(is_file($source_filename))
							{
								$log_str = 'Source file for encoding exists:'."\r\n";
								if(method_exists($this, 'writetoTempFile'))
								$this->writetoTempFile($log_str);
								//$this->changeEncodedStatus('Partial');
								dbDisconnect();
								$temp_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['temp_folder'].'/'.$this->VIDEO_THUMB_NAME.'/';
								$this->chkAndCreateFolder($temp_dir);

								$temp_file = $temp_dir.'00000001.'.$this->CFG['video']['image']['extensions'];
								$final_name = $store_dir.$this->VIDEO_THUMB_NAME.'L.'.$this->CFG['video']['image']['extensions'];
								//------Writing to the log file
								$log_str = 'Calling Frame Conversion:'."\r\n";
								if(method_exists($this, 'writetoTempFile'))
									$this->writetoTempFile($log_str);
								//------Writing to the log file

								$this->videoToFrame($source_filename, $temp_dir, $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['total_frame'], $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['frame_width'].':'.$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['frame_height']);

								if(is_file($temp_dir.'thumb_gen.'.$this->CFG['video']['image']['extensions']))
									$temp_file=$temp_dir.'thumb_gen.'.$this->CFG['video']['image']['extensions'];


								if(is_file(sprintf($temp_file,1)))
									{
										copy($temp_file, $final_name);
										unlink($temp_file);
										if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['total_frame'])
											{

												if(is_file($temp_dir.'00000001.'.$this->CFG['video']['image']['extensions']))
													{
														copy($temp_dir.'00000001.'.$this->CFG['video']['image']['extensions'], $store_dir.$this->VIDEO_THUMB_NAME.'_1.'.$this->CFG['video']['image']['extensions']);
														unlink($temp_dir.'00000001.'.$this->CFG['video']['image']['extensions']);
													}
												if(is_file($temp_dir.'00000002.'.$this->CFG['video']['image']['extensions']))
													{
														copy($temp_dir.'00000002.'.$this->CFG['video']['image']['extensions'], $store_dir.$this->VIDEO_THUMB_NAME.'_2.'.$this->CFG['video']['image']['extensions']);
														unlink($temp_dir.'00000002.'.$this->CFG['video']['image']['extensions']);
													}
												if(is_file($temp_dir.'00000003.'.$this->CFG['video']['image']['extensions']))
													{
														copy($temp_dir.'00000003.'.$this->CFG['video']['image']['extensions'], $store_dir.$this->VIDEO_THUMB_NAME.'_3.'.$this->CFG['video']['image']['extensions']);
														unlink($temp_dir.'00000003.'.$this->CFG['video']['image']['extensions']);
													}
											}
										$this->removeDirectory($temp_dir);



										$videoPath=$store_dir.$this->VIDEO_NAME.".flv";
											//calling the mencoder only when the ext is not flv
										require_once($this->CFG['site']['project_path'].'video/videoCommand.inc.php');
										if(strtolower($this->VIDEO_EXT)!='flv')
											{


												## CHANGED WILL COME FROM config_encode_command.inc.php
												if($this->CFG['admin']['video']['ffmpeg_encode'])
												{
													$command = $this->CFG['admin']['ffmpeg_command_flv'];
													$log_str = 'CALLING FFMPEG FOR FLV CONVERSION:'."\r\n";
													$command=replaceCommandValue($command,$source_filename,$videoPath);
												}

												#for 3level Encoding
												if($this->CFG['admin']['mencoder_command_pass_level']==3 && $this->CFG['admin']['mencoder_command_encoding_pass'] && !$this->CFG['admin']['video']['ffmpeg_encode'])
												{
													$command_3=getMultiPassMencoderCommand(3,$source_filename,$videoPath);
													$log_str .= $command_3."\r\n";;
													$result=exec($command_3, $p);
													if(count($p))
													{
														foreach($p as $key=>$val)
														$log_str .= $key.': '.$val."\n\r";
													}

												}

												if($this->CFG['admin']['mencoder_command_encoding_pass'] )
												{
													$log_str = 'Mencoder Command pass level:'."\r\n";
													$log_str .= "\r\n"."Ist Level Encode"."\r\n";
													$command=getMultiPassMencoderCommand(1,$source_filename,$videoPath);
												}
												else
												{
														$log_str .= "\r\n"."Normal Mencoder Encode"."\r\n";
														$vpass='';
														$command=getNormalMencoderCommand($source_filename,$videoPath);
												}

												$log_str .= $command."\r\n";;
												$result=exec($command, $p);

												if(count($p))
													{

														foreach($p as $key=>$val)
															$log_str .= $key.': '.$val."\n\r";
													}

												#for 3level Encoding
												if(($this->CFG['admin']['mencoder_command_pass_level']==2 || $this->CFG['admin']['mencoder_command_pass_level']==3) && $this->CFG['admin']['mencoder_command_encoding_pass'] && !$this->CFG['admin']['video']['ffmpeg_encode'])
												{

													$command=getMultiPassMencoderCommand(2,$source_filename,$videoPath);
													$log_str .= "\r\n"."2 Level Passing Encode"."\r\n";
													$log_str .= $command."\r\n";;
													$result=exec($command, $p);
													if(count($p))
														{

															foreach($p as $key=>$val)
																$log_str .= $key.': '.$val."\n\r";
														}

												}
												if(method_exists($this, 'writetoTempFile'))
													$this->writetoTempFile($log_str);

												$result = exec("\"".$this->CFG['admin']['video']['flvtool2_path']."\" -UP ". $store_dir.$this->VIDEO_NAME.".flv");
												$this->setFormField('playing_time', $this->getVideoPlayingTime($source_filename));

												//OTHER FORMATS



												if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['video_other_formats_enabled'])
												{

												# GENERATING MP4 format If ituens is set to true
												if($this->CFG['rss_display']['itunes'])
												{
													if(!in_array('mp4',	$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['video_available_formats']))
														$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['video_available_formats'][]='mp4';
												}

												$this->generateOtherFormatVideos($store_dir.$this->VIDEO_NAME.".".$this->VIDEO_EXT, $store_dir.$this->VIDEO_NAME);
												}
												else
												{
													# GENERATING MP4 format If ituens is set to true
													if($this->CFG['rss_display']['itunes'])
													{
														unset($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['video_available_formats']);
														$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['video_available_formats'][]='mp4';
														$this->generateOtherFormatVideos($store_dir.$this->VIDEO_NAME.".".$this->VIDEO_EXT, $store_dir.$this->VIDEO_NAME);
													}
												}


												//OTHER FORMATS

											}
										else
											{

											# renaming the flv name
											$videoPath=str_replace('.flv','_TEMP.flv',$videoPath);

											if($this->CFG['admin']['videos']['allow_watermark_in_video'])
											{
												if($this->CFG['admin']['video']['ffmpeg_encode'])
												{
													$command = $this->CFG['admin']['ffmpeg_command_flv'];
													$log_str = 'CALLING FFMPEG FOR FLV CONVERSION:'."\r\n";
													$command=replaceCommandValue($command);
												}
												else
												{
													$log_str = 'CALLING Mencoder FOR FLV CONVERSION:'."\r\n";
													$command=getNormalMencoderCommand($source_filename,$videoPath);
												}

										//
													$log_str = "\r\n"."FLV CONVERSION FOR MENCODER"."\r\n";
													$log_str .= $command."\r\n";;
													$result=exec($command, $p);

													if(count($p))
														{

															foreach($p as $key=>$val)
																$log_str .= $key.': '.$val."\n\r";
														}
													if(method_exists($this, 'writetoTempFile'))
													$this->writetoTempFile($log_str);

													if(is_file($store_dir.$this->VIDEO_NAME."_TEMP.flv"))
														{
															if(is_file($store_dir.$this->VIDEO_NAME.".flv"))
																@unlink($store_dir.$this->VIDEO_NAME.".flv");
															@copy($store_dir.$this->VIDEO_NAME."_TEMP.flv", $store_dir.$this->VIDEO_NAME.".flv");
															@unlink($store_dir.$this->VIDEO_NAME."_TEMP.flv");
														}

												$source_filename=$store_dir.$this->VIDEO_NAME.".flv";

												}

												//if the video is not uploaded or via capture
												//@todo Need to make it compulsory to store the external videos
												// since playing the other flv files from youtube or google is illegal
												//Need to pass the flv files captured from red5 also to pass though flvtool
												//In some servers this issue is thrown
												//Need to provide separate option for providing the External flv file name

												$result = exec("\"".$this->CFG['admin']['video']['flvtool2_path']."\" -UP ". $source_filename);
												$this->setFormField('playing_time', $this->getVideoPlayingTime($source_filename));

												if($this->FLV_UPLOAD_TYPE=='externalsitevideourl')
													{

														if(($this->CFG['admin']['videos']['download_youtube_videos'] && $this->external_video_details_arr['external_site']=='youtube') || ($this->CFG['admin']['videos']['download_google_videos'] && $this->external_video_details_arr['external_site']=='google') || ($this->CFG['admin']['videos']['download_dailymotion_videos'] && $this->external_video_details_arr['external_site']=='dailymotion')  || ($this->CFG['admin']['videos']['download_myspace_videos'] && $this->external_video_details_arr['external_site']=='myspace') || ($this->CFG['admin']['videos']['download_dailymotion_videos'] && $this->external_video_details_arr['external_site']=='dailymotion')  || (!$this->CFG['admin']['videos']['download_myspace_videos'] && $this->external_video_details_arr['external_site']=='myspace') || (!$this->CFG['admin']['videos']['download_dailymotion_videos'] && $this->external_video_details_arr['external_site']=='dailymotion')  || (!$this->CFG['admin']['videos']['download_myspace_videos'] && $this->external_video_details_arr['external_site']=='myspace') || ($this->CFG['admin']['videos']['download_flvpath_videos'] && $this->external_video_details_arr['external_site']=='flvpath') || ($this->FLV_UPLOAD_TYPE!='externalsitevideourl') )
														{
														//OTHER FORMATS
														if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['video_other_formats_enabled'])
														{
																# GENERATING MP4 format If ituens is set to true
															if($this->CFG['rss_display']['itunes'])
															{
																if(!in_array('mp4',	$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['video_available_formats']))
																	$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['video_available_formats'][]='mp4';
															}

															$this->generateOtherFormatVideos($store_dir.$this->VIDEO_NAME.".".$this->VIDEO_EXT, $store_dir.$this->VIDEO_NAME);
														}
														else
														{
															# GENERATING MP4 format If ituens is set to true
															if($this->CFG['rss_display']['itunes'])
															{
																unset($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['video_available_formats']);
																$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['video_available_formats'][]='mp4';
																$this->generateOtherFormatVideos($store_dir.$this->VIDEO_NAME.".".$this->VIDEO_EXT, $store_dir.$this->VIDEO_NAME);
															}
														}
														}
													}
												else
													{
														//OTHER FORMATS
														if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['video_other_formats_enabled'])
														{
															# GENERATING MP4 format If ituens is set to true
															if($this->CFG['rss_display']['itunes'])
															{
																if(!in_array('mp4',	$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['video_available_formats']))
																	$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['video_available_formats'][]='mp4';
															}
															$this->generateOtherFormatVideos($store_dir.$this->VIDEO_NAME.".".$this->VIDEO_EXT, $store_dir.$this->VIDEO_NAME);
														}
														else
														{
															# GENERATING MP4 format If ituens is set to true
															if($this->CFG['rss_display']['itunes'])
															{
																unset($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['video_available_formats']);
																$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['video_available_formats'][]='mp4';
																$this->generateOtherFormatVideos($store_dir.$this->VIDEO_NAME.".".$this->VIDEO_EXT, $store_dir.$this->VIDEO_NAME);
															}
														}
													}
											}


										$temp_file = $store_dir.$this->VIDEO_NAME;
										$imageTemp_file=$store_dir.$this->VIDEO_THUMB_NAME;
										//resiz the image
										$imageObj = new ImageHandler($imageTemp_file.'L.'.$this->CFG['video']['image']['extensions']);
										$this->setIHObject($imageObj);
										$this->storeImagesTempServer($imageTemp_file, $this->CFG['video']['image']['extensions']);
										dbConnect();
										$this->updateVideoTable($this->VIDEO_ID);

										$this->changeEncodedStatus('Yes');
										if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['video_auto_activate'])
											{
												if($this->populateVideoDetails())
													{
														if($this->activateVideoFile())
															{

															}
													}
											}
										else
											{
												$this->sendRequestMailToAdminForActivate($video_id);
											}

									}
								else
									{
										$this->removeDirectory($temp_dir);
										$this->video_uploaded_success = false;
										if(is_file($source_filename))
											unlink($source_filename);
										dbConnect();
										$this->deleteVideoTable();
										$this->sendMailToUserForInvalidVideo();
								}
							}
					}

			}

		/**
		 * VideoUploadLib::sendEmailToAll()
		 *
		 * @return
		 */
		public function sendEmailToAll()
		{
			  $this->EMAIL_ADDRESS = array_unique($this->EMAIL_ADDRESS);
			  if($this->EMAIL_ADDRESS)
			  {
				foreach($this->EMAIL_ADDRESS as $email)
				{
				$mailSent = false;
				$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['folder'].'/'.$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['thumbnail_folder'].'/';

				$video_image = '<img border="0" src="'.$this->CFG['site']['url'].$thumbnail_folder.getVideoImageName($this->fields_arr['video_id']).$this->CFG['admin']['videos']['large_name'].'.jpg" alt="'.$this->VIDEO_TITLE.'" title="'.$this->VIDEO_TITLE.'" />';

				$videolink = getUrl('viewvideo','?video_id='.$this->fields_arr['video_id'].'&video_title='.$this->fields_arr['video_title'], $this->fields_arr['video_id'].'/'.$this->fields_arr['video_title'].'/','members','video');

				$subject = str_replace('VAR_USER_NAME', $this->CFG['user']['user_name'], $this->LANG['video_share_subject']);

				$body = str_replace('VAR_USER_NAME', $this->CFG['user']['user_name'], $this->LANG['video_share_content']);
				$body = str_replace('VAR_VIDEO_IMAGE', '<a href="'.$videolink.'">'.$video_image.'</a>', $body);
				$body = str_replace('VAR_VIDEO_DESCRIPTION', $this->VIDEO_DESCRIPTION, $body);
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
		 * VideoUploadLib::getEmailAddressOfRelation()
		 *
		 * @param mixed $value
		 * @return
		 */
		public function getEmailAddressOfRelation($value)
			{
			    $relation_id = $value?$value:0;
		 	    $sql = 'SELECT u.email FROM '.$this->CFG['db']['tbl']['friends_relation'].' AS fr,'.
						' '.$this->CFG['db']['tbl']['friends_list'].' AS fl LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u'.
								' ON (u.user_id = IF(fl.owner_id='.$this->dbObj->Param('owner_id').',fl.friend_id, fl.owner_id)'.
								' AND u.usr_status=\'Ok\' ) WHERE (fr.relation_id IN('.$relation_id.') AND fl.id=fr.friendship_id)';

			    $stmt = $this->dbObj->Prepare($sql);
			    $rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
			    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			    if($rs->PO_RecordCount())
			    {
				while($row = $rs->FetchRow())
				{
			  	   $value = trim($row['email']);
				  $this->EMAIL_ADDRESS[] = $value;
				}
			    }
			   return true;
		 	}


		/**
		 * VideoUploadLib::sendRequestMailToAdminForActivate()
		 *
		 * @param mixed $video_id
		 * @return
		 */
		public function sendRequestMailToAdminForActivate($video_id)
			{
				//User request mail to admin for video activity.
				$sql ='SELECT video_server_url, video_title, video_caption, video_id '.
						' FROM '.$this->CFG['db']['tbl']['video'].
						' WHERE video_id='.$this->dbObj->Param('video_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($video_id));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$row = $rs->FetchRow();


				$activate_subject = str_replace('VAR_USER_NAME', $this->CFG['user']['user_name'], $this->LANG['video_activate_request_subject']);
				$activate_subject = str_replace('VAR_VIDEO_TITLE', $row['video_title'], $activate_subject);
				//Content..
				//video title
				$activate_message = str_replace('VAR_VIDEO_TITLE', $row['video_title'], $this->LANG['video_activate_request_content']);
				//video description
				$video_description = wordWrap_mb_Manual(strip_tags($row['video_caption']), $this->CFG['admin']['videos']['caption_length_share_video'], $this->CFG['admin']['videos']['description_total_char_share_video']);
				$activate_message = str_replace('VAR_VIDEO_DESCRIPTION', $video_description, $activate_message);
				//flagged title, flagged content
				$admin_link = $this->CFG['site']['url'].'admin/video/videoActivate.php';
				$video_title_admin_link = '<a href="'.$admin_link.'">'.$this->LANG['videoupload_activate'].'</a>';
				$activate_message = str_replace('VAR_VIDEO_TITLE_ADMIN_LINK', $video_title_admin_link, $activate_message);
				//User name
				$activate_message = str_replace('VAR_USER_NAME', $this->CFG['user']['user_name'], $activate_message);
				//site name
				$activate_message = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $activate_message);
				$is_ok = $this->_sendMail($this->CFG['site']['webmaster_email'], $activate_subject, $activate_message, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);
			}

		/**
		 * Copy File from HTTPS/SSL location
		 *
		 * @param string $FromLocation
		 * @param string $ToLocation
		 * @return boolean
		 */
	    public function copySecureFile($FromLocation,$ToLocation,$VerifyPeer=false,$VerifyHost=true){
	     	  // Initialize CURL with providing full https URL of the file location
	         $Channel = curl_init($FromLocation);
	         // Open file handle at the location you want to copy the file: destination path at local drive
	         $File = fopen ($ToLocation, "w");
	         // Set CURL options
	         curl_setopt($Channel, CURLOPT_FILE, $File);

	         // We are not sending any headers
	         curl_setopt($Channel, CURLOPT_HEADER, 0);

	         // Disable PEER SSL Verification: If you are not running with SSL or if you don't have valid SSL
	         curl_setopt($Channel, CURLOPT_SSL_VERIFYPEER, $VerifyPeer);

	         // Disable HOST (the site you are sending request to) SSL Verification,
	         // if Host can have certificate which is nvalid / expired / not signed by authorized CA.
	         curl_setopt($Channel, CURLOPT_SSL_VERIFYHOST, $VerifyHost);

	         // Execute CURL command
	         curl_exec($Channel);

	         // Close the CURL channel
	         curl_close($Channel);

	         // Close file handle
	         fclose($File);

	         // return true if file download is successfull
	         return file_exists($ToLocation);
	      }

		public function videoExternalEncode_new($video_id,$source_filename)
			{
				$this->VIDEOID = $this->VIDEO_ID = $video_id;
				if($this->selectVideoIdFromTable($video_id)){
					$this->CFG['video']['image']['extensions']='jpg';
					$temp_dir = '../'.$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin']['videos']['temp_folder'].'/';
					$video_image_name = getVideoImageName($video_id);
					$this->VIDEO_NAME = $video_name = getVideoName($video_id);
					$extern='flv';
					//$temp_file = $temp_dir.$video_name.'.'.$extern;
					$flv='';

					$this->chkAndCreateFolder($temp_dir);

					$temp_file = $temp_dir.$video_image_name;

					$final_name_l = $temp_dir.$video_image_name.'L.'.$this->CFG['video']['image']['extensions'];
					$final_name_t = $temp_dir.$video_image_name.'T.'.$this->CFG['video']['image']['extensions'];
					$final_name_s = $temp_dir.$video_image_name.'S.'.$this->CFG['video']['image']['extensions'];

					$source_filename = htmlspecialchars_decode($source_filename);

					if(!@copy($source_filename, $final_name_s)){
					   $this->copySecureFile($source_filename, $final_name_s);
					}

					if(!@copy($source_filename, $final_name_t)){
					   $this->copySecureFile($source_filename, $final_name_t);
					}
					if(!@copy($source_filename, $final_name_l)){
					   $this->copySecureFile($source_filename, $final_name_l);
					}

					$imageObj = new ImageHandler($final_name_l);
					$this->setIHObject($imageObj);

					$this->storeImagesTempServer($temp_file, $this->CFG['video']['image']['extensions']);

					$this->fields_arr['playing_time'] = "0:00";

					$this->updateVideoTable($video_id);

					$sql  = 'UPDATE '.$this->CFG['db']['tbl'][$this->MEDIA_TYPE_TABLE].' SET'.
						    ' playing_time = "'.$this->PLAYING_TIME.'" , embed_video_image_ext=\''.$this->CFG['video']['image']['extensions'].'\' WHERE video_id='.$this->dbObj->Param('video_id');
					$stmt = $this->dbObj->Prepare($sql);
					$rs   = $this->dbObj->Execute($stmt, array($this->VIDEO_ID));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

					$this->changeEncodedStatus('Yes');
					if($this->CFG['admin']['videos']['video_auto_activate']){
						if($this->populateVideoDetails())
							if($this->activateVideoFile())
								$this->sendMailToUserForActivate();
					}
				}
			}

		/**
		 * VideoUploadLib::getFileContents()
		 *
		 * @param mixed $file
		 * @return
		 */
		public function getFileContents($file)
			{
				$buffer='';
				$file=html_entity_decode($file);
				if($handle = @fopen("$file", "r"))
					{
						while (!feof($handle))
					    	$buffer .= fgets($handle, 4096);
					}
				return $buffer;
			}


		/**
		 * VideoUpload::updateVideoTable()
		 *
		 * @param $video_id
		 * @return
		 **/
		public function updateVideoTable($video_id)
			{
				//Update video table

				### UPDATING PLAYING TIME FOR VIDEO IN HR:MIN:SEC
				$playingTime =  $this->fields_arr['playing_time'];
				list($min,$sec)=explode(":",$playingTime);
				$maxHour = floor($min/60);
				$hr = $maxHour;
				$min = ($min - ($maxHour*60));
				$playingTime = $hr.':'.$min.':'.$sec;

				$sql = 'UPDATE '.$this->CFG['db']['tbl'][$this->MEDIA_TYPE_TABLE].' SET'.
						' l_width='.$this->dbObj->Param('l_width').', l_height='.$this->dbObj->Param('l_height').','.
						' t_width='.$this->dbObj->Param('t_width').', t_height='.$this->dbObj->Param('t_height').','.
						' s_width='.$this->dbObj->Param('s_width').', s_height='.$this->dbObj->Param('s_height').','.
						' video_encoded_status=\'Yes\','.
						' playing_time='.$this->dbObj->Param('playing_time').
						' WHERE video_id='.$this->dbObj->Param('video_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->L_WIDTH, $this->L_HEIGHT, $this->T_WIDTH, $this->T_HEIGHT,$this->S_WIDTH, $this->S_HEIGHT, $playingTime, $this->VIDEO_ID));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}

		/**
		 * VideoUpload::changeEncodedStatus()
		 *
		 * @return
		 **/
		public function changeEncodedStatus($status)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl'][$this->MEDIA_TYPE_TABLE].' SET video_encoded_status='.$this->dbObj->Param('video_encoded_status').
						' WHERE video_id='.$this->dbObj->Param('video_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($status, $this->VIDEO_ID));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}

		/**
		 * VideoUpload::deleteVideoTable()
		 *
		 * @return
		 **/
		public function deleteVideoTable()
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl'][$this->MEDIA_TYPE_TABLE].' WHERE'.
						' video_id='.$this->dbObj->Param('video_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->VIDEO_ID));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}

		public function getFilePermisions($file_type, $file)
			{
				$env_file=($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['env_details_list'])?$file:$file_type;
				if(file_exists($file))
					{
						$err='';
						if((($perm=intval((substr(sprintf('%o', fileperms($file)), -3)))) < 755))
							{
								$err.= ' EXECUTE PERMISSION NOT PROVIDED FOR THE FILE: '.$env_file;
								$err.=($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['env_details_list'])?'. IT IS HAVING PERMISSION: '.$perm:'';
								$err.='<br />';
							}
					}
					else
						$err= $env_file.' NOT EXISTS.<br />';
				return $err;
			}

		public function chkVideoUploadEnvironment()
			{
				if(!$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['env_details_checking'])
					return true;

				$this->VIDEO_UPLOAD_ENV_ERR='';
				$video_encoder_arr=array('MENCODER'=>$this->CFG['admin']['video']['mencoder_path'],
										'FLVTOOL2'=>$this->CFG['admin']['video']['flvtool2_path'],
										'MPALYER'=>$this->CFG['admin']['video']['mplayer_path']
										);

				foreach($video_encoder_arr as $index=>$file)
					$this->VIDEO_UPLOAD_ENV_ERR.=$this->getFilePermisions($index,$file);
				return (!trim($this->VIDEO_UPLOAD_ENV_ERR));
			}
		//OTHER FORMATS
		public function generateOtherFormatVideos($source_filename, $target_file_name)
			{

				$org_target_file_name=$target_file_name;
				foreach($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['video_available_formats'] as $index=>$type)
					{
						#Added condtion for not to generate upload video extension is available in video_available_formats also

						if($type!=$this->VIDEO_EXT)
						{
						$target_file_name=$org_target_file_name.'.'.$type;
							if($type=='mp4')
							{
								$source_filename = substr($source_filename,0,strrpos($source_filename,'.')).'.flv';
							}

							$command='';
								$log_str = 'Generating Other video Formats:--'.$type."\r\n";
								if($this->CFG['admin']['video']['ffmpeg_encode'] || $type=='mp4')
								{
									if(isset($this->CFG['admin']['audio']['ffmpeg_path']) and file_exists($this->CFG['admin']['audio']['ffmpeg_path']))
									{
										if(isset($this->CFG['admin']['ffmpeg_command_'.$type]))
											$command=$this->CFG['admin']['ffmpeg_command_'.$type];
											$command=replaceCommandValue($command,$source_filename,$target_file_name,true);
									}
									else
									{
											$log_str.= 'ffmpeg path is null'."\r\n";
											$command='';
									}
								}
								else
								{
									$command = getOtherFormatsMencoderCommand($type,$source_filename,$target_file_name);
								}

								if($command)
								{
									$result = exec($command,$p);
									$log_str.=$command."\r\n";
									if(count($p))
									{
										foreach($p as $key=>$val)
										$log_str .= $key.': '.$val."\n\r";
									}
								}
								else
									$log_str.='No Command Available'."\r\n";
								if(method_exists($this, 'writetoTempFile'))
									$this->writetoTempFile($log_str);


						if(file_exists($target_file_name))
							{
								dbConnect();

								$sql = 'UPDATE '.$this->CFG['db']['tbl'][$this->MEDIA_TYPE_TABLE].' SET'.
										' video_available_formats = CONCAT(video_available_formats, \''.$type.'\' , \',\') WHERE '.
										' video_id='.$this->dbObj->Param('video_id');
								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->VIDEO_ID));
								    if (!$rs)
									    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
								dbDisconnect();
							}
					}
					else
					{
					$log_str = 'Video Available Format is same as Upload format!!! Other video Format Not Generated:'."\r\n";
					if(method_exists($this, 'writetoTempFile'))
					$this->writetoTempFile($log_str);

					}
					}
			}
		//OTHER FORMATS

		public function increaseTotalVideosForUsers($user_id)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET'.
						' total_videos=total_videos+1 WHERE user_id='.
						$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));

				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}

		public function activateExternalEmbededImage($video_id)
		{
				$this->VIDEO_THUMB_NAME=getVideoImageName($video_id);
				$temp_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['temp_folder'].'/';
				$imageTempUrl=$temp_dir.$this->VIDEO_THUMB_NAME;

				if($this->getServerDetails())
				{
					dbDisconnect();
					if($FtpObj = new FtpHandler($this->FTP_SERVER,$this->FTP_USERNAME,$this->FTP_PASSWORD))
						{
							if($this->FTP_FOLDER)
							{

								if($FtpObj->changeDirectory($this->FTP_FOLDER))
								{

									$dir_thumb = $this->CFG['media']['folder'].'/'.$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['folder'].'/'.$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['thumbnail_folder'].'/';

									$FtpObj->makeDirectory($dir_thumb);

									if(is_file($imageTempUrl.'T.'.$this->CFG['video']['image']['extensions']))
									{
										$FtpObj->moveTo($imageTempUrl.'T.'.$this->CFG['video']['image']['extensions'], $dir_thumb.$this->VIDEO_THUMB_NAME.'T.'.$this->CFG['video']['image']['extensions']);
										unlink($imageTempUrl.'T.'.$this->CFG['video']['image']['extensions']);
									}
									if(is_file($imageTempUrl.'S.'.$this->CFG['video']['image']['extensions']))
									{
										$FtpObj->moveTo($imageTempUrl.'S.'.$this->CFG['video']['image']['extensions'], $dir_thumb.$this->VIDEO_THUMB_NAME.'S.'.$this->CFG['video']['image']['extensions']);
										unlink($imageTempUrl.'S.'.$this->CFG['video']['image']['extensions']);
									}
									if(is_file($imageTempUrl.'L.'.$this->CFG['video']['image']['extensions']))
									{
										$FtpObj->moveTo($imageTempUrl.'L.'.$this->CFG['video']['image']['extensions'], $dir_thumb.$this->VIDEO_THUMB_NAME.'L.'.$this->CFG['video']['image']['extensions']);
										unlink($imageTempUrl.'L.'.$this->CFG['video']['image']['extensions']);
									}
								}
							}
						}
						$FtpObj->ftpClose();
						$SERVER_URL = $this->FTP_SERVER_URL;

					dbConnect();
				}
				else
					{
						dbDisconnect();
						$upload_dir_thumb = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['folder'].'/'.$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['thumbnail_folder'].'/';
						$this->chkAndCreateFolder($upload_dir_thumb);

						$uploadUrlThumb = $upload_dir_thumb.$this->VIDEO_THUMB_NAME;

						if(is_file($imageTempUrl.'S.'.$this->CFG['video']['image']['extensions']))
							{
								copy($imageTempUrl.'S.'.$this->CFG['video']['image']['extensions'], $uploadUrlThumb.'S.'.$this->CFG['video']['image']['extensions']);
								unlink($imageTempUrl.'S.'.$this->CFG['video']['image']['extensions']);
							}
						if(is_file($imageTempUrl.'T.'.$this->CFG['video']['image']['extensions']))
							{
								copy($imageTempUrl.'T.'.$this->CFG['video']['image']['extensions'], $uploadUrlThumb.'T.'.$this->CFG['video']['image']['extensions']);
								unlink($imageTempUrl.'T.'.$this->CFG['video']['image']['extensions']);
							}
						if(is_file($imageTempUrl.'L.'.$this->CFG['video']['image']['extensions']))
							{
								copy($imageTempUrl.'L.'.$this->CFG['video']['image']['extensions'], $uploadUrlThumb.'L.'.$this->CFG['video']['image']['extensions']);
								unlink($imageTempUrl.'L.'.$this->CFG['video']['image']['extensions']);
							}
						dbConnect();
						$SERVER_URL = $this->CFG['site']['url'];
					}
					$this->sendMailToUserForActivate();
					$sql = 'UPDATE '.$this->CFG['db']['tbl'][$this->MEDIA_TYPE_TABLE].' SET'.
								' video_server_url='.$this->dbObj->Param('video_server_url').', video_status=\'Ok\' WHERE'.
								' video_id='.$this->dbObj->Param('video_id');

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($SERVER_URL, $this->VIDEO_ID));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);


						//Srart new video upload activity	..
						$sql = 'SELECT u.user_name as upload_user_name, v.video_id, v.user_id as upload_user_id, v.video_title, v.video_server_url, v.is_external_embed_video, v.embed_video_image_ext '.
								' FROM '.$this->CFG['db']['tbl']['video'].' as v, '.$this->CFG['db']['tbl']['users'].' as u WHERE u.user_id = v.user_id AND video_id = '.$this->dbObj->Param('video_id');
						//echo $this->VIDEO_ID;
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($video_id));
						if (!$rs)
							trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						$row = $rs->FetchRow();
						$activity_arr = $row;
						$activity_arr['action_key']	= 'video_uploaded';
						$videoActivityObj = new VideoActivityHandler();
						$videoActivityObj->addActivity($activity_arr);
						//End..

						$this->increaseTotalVideosForUsers($row['upload_user_id']);

						$content = $activity_arr['upload_user_id'].'~'.
											$activity_arr['upload_user_name'].'~'.
											$activity_arr['video_id'].'~'.
											$activity_arr['video_title'].'~'.
											$activity_arr['video_server_url'].'~'.
											$activity_arr['is_external_embed_video'].'~'.
											$activity_arr['embed_video_image_ext'].'~';

						//Add recod for subscribtions
						$subscription_data_arr['owner_id'] = $this->VIDEO_USER_ID;
						$subscription_data_arr['content_id'] = $this->VIDEO_ID;
						$subscription_data_arr['category_id'] = $this->VIDEO_CATEGORY_ID;
						$subscription_data_arr['sub_category_id'] = $this->VIDEO_SUB_CATEGORY_ID;
						$tags = str_replace(' ', ',', $this->VIDEO_TAGS);
						$subscription_data_arr['tag_name'] = $tags;
						$subscription_data_arr['content'] = $content;
						$this->addSubscriptionData($subscription_data_arr);

		}

	}
?>
