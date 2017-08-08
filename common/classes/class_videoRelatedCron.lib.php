<?php

 class CronDeleteVideoHandler extends CronHandler
	{

		/*private $dbObj;

		private $CFG = array();

		private $LANG = array();

		public function __construct()
			{
				global $CFG, $LANG, $db;
				$this->dbObj 	= $db;
				$this->CFG 		= $CFG;
				$this->LANG 	= $LANG;
			}*/

		public $deletedVideoIds;
		public $userVideo = array();

		//Videos
		public function removeVideoRelatedEntries($id = 0, $type)
			{
				if($type == 'user_id')
					{
						$id_equal_to = ' user_id='.$this->dbObj->Param('id');

				//If Video owner
						$this->updateTable($this->CFG['db']['tbl']['video'], 'video_status=\'Deleted\'', $id_equal_to, array($id));

						//If Video Album owner
						$this->deleteFromTable($this->CFG['db']['tbl']['video_album'], $id_equal_to, array($id));
						return true;
					}
				$this->deletedVideoIds='';
				//Clear Video Related Entries
				if($type=='video_id')
					$this->removeVideoFiles($id,$type);
				else
				{
					$sql = 'SELECT video_id FROM '.$this->CFG['db']['tbl']['video'].' WHERE user_id='.$this->dbObj->Param('user_id');
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($id));
					if (!$rs)
					trigger_db_error($this->dbObj);

					while($row = $rs->FetchRow())
					{
						$this->fields_arr['video_id']=$row['video_id'];
						$this->removeVideoFiles($row['video_id'],$type);

					}

					$this->sendMailToUserForDelete($type);

				}

				$this->clearVideoCommented($id, $type);

				$this->clearVideoFavorited($id, $type);

				$this->clearVideoRated($id, $type);

				$this->clearVideoViewed($id, $type);

				$this->resetRelatedVideoDetails();
				$this->deleteVideosTable();
			}

		//Video Commented
		public function clearVideoCommented($id = 0, $type)
			{
				if($type == 'user_id')
					{
						$field = 'video_id';
						$condition = 'comment_user_id='.$this->dbObj->Param('id');
					}
				elseif($type == 'video_id')
					{
						$field = 'comment_user_id';
						$condition = 'video_id='.$this->dbObj->Param('id');
					}

				$sql = 'SELECT video_comment_id, '.$field.
						' FROM '.$this->CFG['db']['tbl']['video_comments'].
						' WHERE '.$condition;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($id));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
								$this->userVideo[($type=='video_id')?$id:$row['video_id']] = '1';
								$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['video_comments'], 'video_comment_id', $row['video_comment_id']);
						    } // while
					}
				return true;
			}

		//Video Viewed
		public function clearVideoViewed($id = 0, $type)
			{
				if($type == 'user_id')
					{
						$field = 'video_id';
						$condition = 'user_id='.$this->dbObj->Param('user_id').
										' OR video_owner_id='.$this->dbObj->Param('video_owner_id');
						$value_arr = array($id, $id);
					}
				elseif($type == 'video_id')
					{
						$field = 'user_id';
						$condition = 'video_id='.$this->dbObj->Param('video_id');
						$value_arr = array($id);
					}

				$sql = 'SELECT video_viewed_id, '.$field.
						' FROM '.$this->CFG['db']['tbl']['video_viewed'].
						' WHERE '.$condition;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $value_arr);

				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
								$this->userVideo[($type=='video_id')?$id:$row['video_id']] = '1';
								$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['video_viewed'], 'video_viewed_id', $row['video_viewed_id']);
						    } // while
					}
				return true;
			}

		//Video Rated
		public function clearVideoRated($id = 0, $type)
			{
				if($type == 'user_id')
					{
						$field = 'video_id';
						$condition = 'user_id='.$this->dbObj->Param('id');
					}
				elseif($type == 'video_id')
					{
						$field = 'user_id';
						$condition = 'video_id='.$this->dbObj->Param('id');
					}

				$sql = 'SELECT rating_id, '.$field.
						' FROM '.$this->CFG['db']['tbl']['video_rating'].
						' WHERE '.$condition;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($id));

				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
								$this->userVideo[($type=='video_id')?$id:$row['video_id']] = '1';
								$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['video_rating'], 'rating_id', $row['rating_id']);
						    } // while
					}
				return true;
			}

		//Video Favorited
		public function clearVideoFavorited($id = 0, $type)
			{
				if($type == 'user_id')
					{
						$field = 'video_id';
						$condition = 'user_id='.$this->dbObj->Param('id');
					}
				elseif($type == 'video_id')
					{
						$field = 'user_id';
						$condition = 'video_id='.$this->dbObj->Param('id');
					}

				$sql = 'SELECT video_favorite_id, '.$field.
						' FROM '.$this->CFG['db']['tbl']['video_favorite'].
						' WHERE '.$condition;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($id));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
								$this->userVideo[($type=='video_id')?$id:$row['video_id']] = '1';
								$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['video_favorite'], 'video_favorite_id', $row['video_favorite_id']);
						    } // while
					}
				return true;
			}

		//Resetting User accessed video's consolidate logs
		public function resetRelatedVideoDetails()
			{
				if ($this->userVideo)
				    {
						$userVideo = array_keys($this->userVideo);
						foreach($userVideo as $videoId)
							{
						        //total_comments
								$totalComments 	= $this->getNumRowsForThisSql($this->CFG['db']['tbl']['video_comments'], 'video_id='.$this->dbObj->Param($videoId), array($videoId));
								$totalFavorites = $this->getNumRowsForThisSql($this->CFG['db']['tbl']['video_favorite'], 'video_id='.$this->dbObj->Param($videoId), array($videoId));
								$totalViews	 	= $this->getNumRowsForThisSql($this->CFG['db']['tbl']['video_viewed'], 'video_id='.$this->dbObj->Param($videoId), array($videoId));
								$ratingCount 	= $this->getNumRowsForThisSql($this->CFG['db']['tbl']['video_rating'], 'video_id='.$this->dbObj->Param($videoId), array($videoId));
								$ratingTotal	= $this->getTotalRatingForThisVideo($videoId);
								$sql = 	'UPDATE '.$this->CFG['db']['tbl']['video'].
										' SET '.
										' total_comments='.$this->dbObj->Param($totalComments).','.
										' total_favorites='.$this->dbObj->Param($totalFavorites).','.
										' total_views='.$this->dbObj->Param($totalViews).','.
										' rating_count='.$this->dbObj->Param($ratingCount).','.
										' rating_total='.$this->dbObj->Param($ratingTotal).
										' WHERE video_id='.$this->dbObj->Param($videoId);

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($totalComments, $totalFavorites, $totalViews, $ratingCount, $ratingTotal, $videoId));
								if (!$rs)
								    trigger_error($this->dbObj->ErrorNo().' '.
										$this->dbObj->ErrorMsg(), E_USER_ERROR);
						    }
					}
			}

		//Total rating of a video
		public function getTotalRatingForThisVideo($video_id = 0)
			{
				$ratingTotal = 0;
				$sql = 'SELECT SUM(rate) AS rating_total '.
						'FROM '.$this->CFG['db']['tbl']['video_rating'].
						' WHERE video_id='.$this->dbObj->Param($video_id);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($video_id));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$ratingTotal = $row['rating_total'];
				    }
				return $ratingTotal?$ratingTotal:0;
			}


			/**
		 * ManageDeleted::deleteVideosTable()
		 *
		 * @return
		 **/
		public function deleteVideosTable()
			{

				$video_id = $this->deletedVideoIds;
				$videoId_arr = explode(',',$video_id);
				$videoId_arr = array_filter($videoId_arr);
				$video_id = implode(',',$videoId_arr);
				if($video_id)
					{
						$tablename_arr = array('video');
						for($i=0;$i<sizeof($tablename_arr);$i++)
							{
								$sql = 'DELETE FROM '.$this->CFG['db']['tbl'][$tablename_arr[$i]].
										' WHERE video_id IN ('.$video_id.')';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								    if (!$rs)
									    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
							}
					}
			}

		public function chkIsLocalServer()
			{
				$server_url = $this->fields_arr['video_server_url'];
				if(strstr($server_url,$this->CFG['site']['url']))
					{
						$server_url = str_replace($this->CFG['site']['url'],'',$server_url);
						if(trim($server_url)=='')
							{
								return true;
							}
					}
				return false;
			}

		/**
		 * ManageDeleted::getServerDetails()
		 *
		 * @return
		 **/
		public function getServerDetails()
			{
				$server_url = str_replace($this->CFG['admin']['videos']['folder'].'/','',$this->fields_arr['video_server_url']);
				$cid = $this->VIDEO_CATEGORY_ID.',0';

				$sql = 'SELECT ftp_server, ftp_folder, ftp_usrename, ftp_password, category FROM'.
						' '.$this->CFG['db']['tbl']['server_settings'].
						' WHERE server_for=\'video\' AND server_url='.$this->dbObj->Param('server_url').
						' AND category IN('.$cid.') LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($server_url));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if(!$rs->PO_RecordCount())
					return false;

				while($row = $rs->FetchRow())
					{
						$this->fields_arr['ftp_server'] = $row['ftp_server'];
						$this->fields_arr['ftp_folder'] = $row['ftp_folder'];
						$this->fields_arr['ftp_usrename'] = $row['ftp_usrename'];
						$this->fields_arr['ftp_password'] = $row['ftp_password'];

						if($row['category']==$this->VIDEO_CATEGORY_ID)
							return true;
					}
				if(isset($this->fields_arr['ftp_server']) and $this->fields_arr['ftp_server'])
					return true;
				return false;
			}



		/**
		 * ManageDeleted::removeFiles()
		 *
		 * @param $file
		 * @return
		 **/
		public function removeFiles($file)
			{
				if(is_file($file))
					{
						unlink($file);
						return true;
					}
				return false;
			}

		/**
		 * VideoUpload::sendMailToUser()
		 *
		 * @return
		 **/
		public function sendMailToUserForDelete()
			{
				if(isset($this->VIDEO_USER_EMAIL) and $this->VIDEO_USER_EMAIL)
					{
						$subject = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $this->LANG['video_delete_subject']);
						$body = $this->LANG['video_delete_content'];
						$body = str_replace('VAR_LINK', '<a href=\''.$this->CFG['site']['url'].'\'>'.$this->CFG['site']['url'].'</a>', $body);
						$body = str_replace('VAR_USER_NAME', $this->VIDEO_USER_NAME, $body);
						$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
						$body = str_replace('VAR_VIDEO_TITLE', $this->VIDEO_TITLE, $body);

						$this->VIDEO_USER_EMAIL;
						$this->_sendMail($this->VIDEO_USER_EMAIL, $subject, nl2br($body), $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);
						return true;
					}
				else
					return true;
			}


			/**
		 * ManageDeleted::deleteDeletedVideo()
		 *
		 * @return
		 **/
		public function removeVideoFiles($video_id,$type)
			{

				$thumbnail_folder = '../'.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
				$flv_folder = '../'.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['video_folder'].'/';
				$temp_video_folder = '../'.$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin']['videos']['temp_folder'].'/';
				$original_folder = '../'.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['original_video_folder'].'/';
				$otherformat_folder = '../'.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['other_videoformat_folder'].'/';
				$trimmed_folder = '../'.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['trimed_video_folder'].'/';
				$original_filename=getVideoName($video_id);
				$thumb_filename =$thumbnail_folder.getVideoImageName($video_id);
				$trim_filename = getTrimVideoName($video_id);
				if($this->getVideoDetails())
					{

						$this->populateVideoDetails();
						$extension = $this->CFG['video']['image']['extensions'];
						$temp_filename = $temp_video_folder.getVideoImageName($video_id);

						if($this->chkIsLocalServer())
							{
									$flv_filename = $flv_folder.getVideoName($video_id);

									$otherformat_filename=getVideoName($video_id);


								# Removing FLV FILES
								$this->removeFiles($flv_filename.'.flv');


								# Removing THUMBNAILS
								if($this->CFG['admin']['videos']['large_name']=='L')
									$this->removeFiles($thumb_filename.'L.'.$extension);
								if($this->CFG['admin']['videos']['thumb_name']=='T')
									$this->removeFiles($thumb_filename.'T.'.$extension);
								if($this->CFG['admin']['videos']['small_name']=='S')
									$this->removeFiles($thumb_filename.'S.'.$extension);

								if($this->CFG['admin']['videos']['total_frame']==3)
									{
										$this->removeFiles($thumb_filename.'_1.'.$extension);
										$this->removeFiles($thumb_filename.'_2.'.$extension);
										$this->removeFiles($thumb_filename.'_3.'.$extension);
									}
								else if($this->CFG['admin']['videos']['total_frame']==2)
									{
										$this->removeFiles($thumb_filename.'_1.'.$extension);
										$this->removeFiles($thumb_filename.'_2.'.$extension);
									}
								else if($this->CFG['admin']['videos']['total_frame']==1)
									{
										$this->removeFiles($thumb_filename.'_1.'.$extension);
									}
								# Removing GIF ANIMATION
								if($this->CFG['admin']['videos']['rotating_thumbnail_feature'] )
								{
									$frame_path = $thumb_filename.'_gif/';
									$res = removeDirectory($frame_path);

									$this->removeFiles($thumb_filename.'_G.'.'gif');
								}

								# Removing OTHER FORMAT FILES
								foreach($this->otherExt as $ext)
								{

									if(file_exists($otherformat_folder.$otherformat_filename.'.'.$ext))
									{

										unlink($otherformat_folder.$otherformat_filename.'.'.$ext);
									}
								}

								# Removing ORIGINAL FILES
								if(file_exists($original_folder.$original_filename.'.'.$this->VIDEO_EXT))
								{

									unlink($original_folder.$original_filename.'.'.$this->VIDEO_EXT);
								}

								# Removing TRIMEED VIDEO FILES
								if(file_exists($trimmed_folder.$trim_filename.'.flv'))
								{

									unlink($trimmed_folder.$trim_filename.'.flv');
								}



								if($type=='video_id')
									$this->sendMailToUserForDelete();

							}
						else
							{
								if($this->getServerDetails())
									{
										if($FtpObj = new FtpHandler($this->fields_arr['ftp_server'],$this->fields_arr['ftp_usrename'],$this->fields_arr['ftp_password']))
											{
												if($this->fields_arr['ftp_folder'])
													$FtpObj->changeDirectory($this->fields_arr['ftp_folder']);

												$thumb_filename = getVideoImageName($video_id);
												$otherformat_filename = $original_filename = $flvFilename = getVideoName($video_id);
												$dir_video = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['video_folder'].'/';
												$dir_thumb = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
												$original_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['original_video_folder'].'/';
												$otherformat_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['other_videoformat_folder'].'/';
												$trimmed_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['trimed_video_folder'].'/';
												$FtpObj->deleteFile($dir_video.$flvFilename.'.flv');

												if($this->CFG['admin']['videos']['large_name']=='L')
													$FtpObj->deleteFile($dir_thumb.$thumb_filename.'L.'.$extension);
												if($this->CFG['admin']['videos']['thumb_name']=='T')
													$FtpObj->deleteFile($dir_thumb.$thumb_filename.'T.'.$extension);
												if($this->CFG['admin']['videos']['small_name']=='S')
													$FtpObj->deleteFile($dir_thumb.$thumb_filename.'S.'.$extension);

												if($this->CFG['admin']['videos']['total_frame']==3)
													{
														$FtpObj->deleteFile($dir_thumb.$thumb_filename.'_1.'.$extension);
														$FtpObj->deleteFile($dir_thumb.$thumb_filename.'_2.'.$extension);
														$FtpObj->deleteFile($dir_thumb.$thumb_filename.'_3.'.$extension);
													}
												else if($this->CFG['admin']['videos']['total_frame']==2)
													{
														$FtpObj->deleteFile($dir_thumb.$thumb_filename.'_1.'.$extension);
														$FtpObj->deleteFile($dir_thumb.$thumb_filename.'_2.'.$extension);
													}
												else if($this->CFG['admin']['videos']['total_frame']==1)
													{
														$FtpObj->deleteFile($dir_thumb.$thumb_filename.'_1.'.$extension);
													}



											# Removing GIF ANIMATION
											if($this->CFG['admin']['videos']['rotating_thumbnail_feature'] )
											{
												$frame_path = $dir_thumb.$thumb_filename.'_gif/';
												$FtpObj->removeFolder($frame_path);
												$FtpObj->deleteFile($dir_thumb.$thumb_filename.'_G.'.'gif');
											}

											# Removing OTHER FORMAT FILES
											foreach($this->otherExt as $ext)
											{
												$FtpObj->deleteFile($otherformat_folder.$otherformat_filename.'.'.$ext);

											}

											# Removing ORIGINAL FILES
												$FtpObj->deleteFile($original_folder.$original_filename.'.'.$this->VIDEO_EXT);
											# Removing TRIMMED FILES
											$FtpObj->deleteFile($trimmed_folder.$trim_filename.'.flv');
											$FtpObj->ftpClose();



												if($type=='video_id')
												$this->sendMailToUserForDelete();

											}
									}
							}

							$this->deletedVideoIds.=$video_id.',';

					}
				//$this->sendMailToUserForDelete();
				return true;
			}

			/**
		 * ManageDeleted::getVideoDetails()
		 *
		 * @return
		 **/
		public function getVideoDetails()
			{
				//$this->fields_arr['video_id'];
				$sql = 'SELECT video_ext, user_id, video_server_url, video_category_id,video_available_formats FROM '.$this->CFG['db']['tbl']['video'].
						' WHERE video_id='.$this->dbObj->Param('video_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						$this->fields_arr['user_id'] = $row['user_id'];
						$this->fields_arr['video_server_url'] = $row['video_server_url'];
						$this->VIDEO_EXT = $row['video_ext'];
						$this->VIDEO_CATEGORY_ID = $row['video_category_id'];
						$this->otherExt=explode(',',$row['video_available_formats']);
						return true;
					}
				return false;
			}




		/**
		 * VideoUpload::populateVideoDetails()
		 *
		 * @return
		 **/
		public function populateVideoDetails()
			{
				$this->VIDEO_USER_NAME = '';
				$this->VIDEO_USER_EMAIL = '';
				$this->VIDEO_USER_ID = '';

				$sql = 'SELECT video_ext, video_title, video_category_id, user_id FROM'.
						' '.$this->CFG['db']['tbl']['video'].' WHERE'.
						' video_id='.$this->dbObj->Param('video_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if($row = $rs->FetchRow())
				{
					$this->VIDEO_TITLE = $row['video_title'];
					$this->VIDEO_EXT = $row['video_ext'];
					$this->VIDEO_CATEGORY_ID = $row['video_category_id'];

					$sql = 'SELECT user_name, email, user_id FROM '.$this->CFG['db']['tbl']['users'].' WHERE'.
							' user_id='.$this->dbObj->Param('user_id');

					$stmt = $this->dbObj->Prepare($sql);
					$rs1 = $this->dbObj->Execute($stmt, array($row['user_id']));
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

					if($row1 = $rs1->FetchRow())
						{
							$this->VIDEO_USER_NAME = $row1['user_name'];
							$this->VIDEO_USER_EMAIL = $row1['email'];
							$this->VIDEO_USER_ID = $row1['user_id'];
						}
					return true;
				}
				return false;
			}
		/**
		 * CronDeleteVideoHandler::clearVideoActivity()
		 *
		 * @param mixed $id
		 * @return
		 */
		public function clearVideoActivity($id)
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['video_activity'].
						' WHERE actor_id='.$this->dbObj->Param('actor_id').
						' OR owner_id='.$this->dbObj->Param('owner_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($id, $id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				return true;
			}

}

?>
