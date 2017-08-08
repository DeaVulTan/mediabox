<?php
/**
 * This file is to manage deleted music
 * This file is having ManageDeleted class to manage deleted music
 * 1. IF $type is either music_id or user_id(Delete user or music)
 * 2.Music file removeMusicFiles function (chkIsLocalServer or other server)
 *		# REMOVE MP3 FILES
 * 		# REMOVE THUMBNAILS
 * 		# REMOVE OTHER FORMAT FILES
 * 		# REMOVE ORIGINAL FILES
 * 		# REMOVE TRIMMED MUSIC FILES
 * 3. clearMusicCommented, clearMusicFavorited, clearMusicRated, clearMusicViewed, resetRelatedMusicDetails,
 * 	  removePlaylistRelatedEntries, clearMusicAlbum, clearMusicListened, deleteMusicsTable, sendMailToUserForDelete, clearMusicLyrics.
 * 4. removePlaylistRelatedEntries - > clearPlaylistCommented, clearPlaylistFavorited, clearPlaylistRated,
 *    clearPlaylistViewed, resetRelatedPlaylistDetails, deletePlaylistTable, clearPlaylistListened, clearPlaylistActivity.
 * Modification
 * 	music activity
 *
 * CronDeleteMusicHandler
 *
 * @package
 * @author karthiselvam_045at09
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id$
 * @access public
 */
class CronDeleteMusicHandler extends CronHandler
	{

		public $deletedMusicIds;
		public $deletedPlaylistIds;
		public $userMusic = array();
		public $userPlaylist = array();

		/**
		 * CronDeleteMusicHandler::removeMusicRelatedEntries()
		 *
		 * @param integer $id
		 * @param mixed $type
		 * @return
		 */
		public function removeMusicRelatedEntries($id = 0, $type)
			{

				$this->deletedMusicIds='';
				//CLEAR MUSIC RELATED ENTRIES//
				if($type == 'user_id')//IF MUSIC OWNER//
					{
						$id_equal_to = ' user_id='.$this->dbObj->Param('id');
						$this->updateTable($this->CFG['db']['tbl']['music'], 'music_status=\'Deleted\'', $id_equal_to, array($id));
						$sql = 'SELECT music_id FROM '.$this->CFG['db']['tbl']['music'].' WHERE user_id='.$this->dbObj->Param('user_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($id));
						if (!$rs)
							trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						while($row = $rs->FetchRow())
							{
								$this->fields_arr['music_id']=$row['music_id'];
								//1. CLEAR MUSIC FILES //
								$this->removeMusicFiles($row['music_id'],$type);
							}
					}
				elseif($type=='music_id')
					{
						$this->fields_arr['music_id'] = $id;
						//1. CLEAR MUSIC FILES //
						$this->removeMusicFiles($id,$type);
					}
				//2. CLEAR MUSIC COMMENT //
				$this->clearMusicCommented($id, $type);
				//3. CLEAR MUSIC FAVORITED //
				$this->clearMusicFavorited($id, $type);
				//4. CLEAR MUSIC RATED //
				$this->clearMusicRated($id, $type);
				//5. CLEAR MUSIC VIEW //
				$this->clearMusicViewed($id, $type);
				//6. CLEAR MUSIC LISTENED //
				$this->clearMusicListened($id, $type);
				//6. RESET MUSIC RELATED //
				$this->resetRelatedMusicDetails();
				//7. CLEAR MUSIC ALBUM //
				$this->clearMusicAlbum();
				//8. CLEAR MUSIC LYRICS //
				$this->clearMusicLyrics($id, $type);
				//9. CLEAR PLAYLIST RELATED TABEL //
				$this->removePlaylistRelatedEntries($id, $type);
				//10. MUSIC ACTIVITY TABEL //
				$this->clearMusicActivity($id, $type);
				//10. CLEAR MUSIC TABEL //
				$this->deleteMusicsTable();
				return true;
			}

		/**
		 * CronDeleteMusicHandler::removeMusicFiles()
		 *
		 * @param mixed $music_id
		 * @param mixed $type
		 * @return
		 */
		public function removeMusicFiles($music_id,$type)
			{
				$thumbnail_folder = '../'.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
				$mp3_folder = '../'.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['music_folder'].'/';
				$temp_music_folder = '../'.$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin']['musics']['temp_folder'].'/';
				$original_folder = '../'.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['original_music_folder'].'/';
				$otherformat_folder = '../'.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['other_musicformat_folder'].'/';
				$trimmed_folder = '../'.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['trimed_music_folder'].'/';
				$original_filename=getMusicName($music_id);
				$thumb_filename =$thumbnail_folder.getMusicImageName($music_id);
				$trim_filename = getTrimMusicName($music_id);
				if($this->getMusicDetails())
					{
						$this->populateMusicDetails();
						$extension = $this->MUSIC_THUMB_EXT;
						$temp_filename = $temp_music_folder.getMusicImageName($music_id);

						if($this->chkIsLocalServer())
							{
								$mp3_filename = $mp3_folder.getMusicName($music_id);
								$otherformat_filename=getMusicName($music_id);
								# REMOVE mp3 FILES
								$this->removeFiles($mp3_filename.'.mp3');
								# REMOVE THUMBNAILS
								if($this->CFG['admin']['musics']['large_name']=='L')
									$this->removeFiles($thumb_filename.'L.'.$extension);
								if($this->CFG['admin']['musics']['thumb_name']=='T')
									$this->removeFiles($thumb_filename.'T.'.$extension);
								if($this->CFG['admin']['musics']['small_name']=='S')
									$this->removeFiles($thumb_filename.'S.'.$extension);
								if($this->CFG['admin']['musics']['medium_name']=='M')
									$this->removeFiles($thumb_filename.'M.'.$extension);
								# REMOVE OTHER FORMAT FILES
								foreach($this->otherExt as $ext)
									{
										if(file_exists($otherformat_folder.$otherformat_filename.'.'.$ext))
											{
												unlink($otherformat_folder.$otherformat_filename.'.'.$ext);
											}
									}
								# REMOVE ORIGINAL FILES
								if(file_exists($original_folder.$original_filename.'.'.$this->MUSIC_EXT))
									{
										unlink($original_folder.$original_filename.'.'.$this->MUSIC_EXT);
									}
								# REMOVE TRIMMED MUSIC FILES
								if(file_exists($trimmed_folder.$trim_filename.'.mp3'))
									{
										unlink($trimmed_folder.$trim_filename.'.mp3');
									}
								if($type=='music_id')
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

												$thumb_filename = getMusicImageName($music_id);
												$otherformat_filename = $original_filename = $mp3Filename = getMusicName($music_id);
												$dir_music = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['music_folder'].'/';
												$dir_thumb = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
												$original_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['original_music_folder'].'/';
												$otherformat_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['other_musicformat_folder'].'/';
												$trimmed_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['trimed_music_folder'].'/';
												# REMOVE mp3 FILES
												$FtpObj->deleteFile($dir_music.$mp3Filename.'.mp3');
												# REMOVE THUMBNAILS
												if($this->CFG['admin']['musics']['large_name']=='L')
													$FtpObj->deleteFile($dir_thumb.$thumb_filename.'L.'.$extension);
												if($this->CFG['admin']['musics']['thumb_name']=='T')
													$FtpObj->deleteFile($dir_thumb.$thumb_filename.'T.'.$extension);
												if($this->CFG['admin']['musics']['small_name']=='S')
													$FtpObj->deleteFile($dir_thumb.$thumb_filename.'S.'.$extension);
												if($this->CFG['admin']['musics']['medium_name']=='M')
													$this->deleteFile($dir_thumb.'M.'.$extension);
												# REMOVE OTHER FORMAT FILES
												foreach($this->otherExt as $ext)
													{
														$FtpObj->deleteFile($otherformat_folder.$otherformat_filename.'.'.$ext);
													}
												# REMOVE ORIGINAL FILES
												$FtpObj->deleteFile($original_folder.$original_filename.'.'.$this->MUSIC_EXT);
												# REMOVE TRIMMED FILES
												$FtpObj->deleteFile($trimmed_folder.$trim_filename.'.mp3');
												$FtpObj->ftpClose();
												if($type=='music_id')
													$this->sendMailToUserForDelete();
											}
									}
							}
							$this->deletedMusicIds.=$music_id.',';
					}
				return true;
			}

		/**
		 * CronDeleteMusicHandler::getMusicDetails()
		 *
		 * @return
		 */
		public function getMusicDetails()
			{
				$sql = 'SELECT music_ext, music_thumb_ext, user_id, music_server_url, music_category_id, music_available_formats FROM '.$this->CFG['db']['tbl']['music'].
						' WHERE music_id='.$this->dbObj->Param('music_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						$this->fields_arr['user_id'] = $row['user_id'];
						$this->fields_arr['music_server_url'] = $row['music_server_url'];
						$this->MUSIC_EXT = $row['music_ext'];
						$this->MUSIC_THUMB_EXT = $row['music_thumb_ext'];
						$this->MUSIC_CATEGORY_ID = $row['music_category_id'];
						$this->otherExt=explode(',',$row['music_available_formats']);
						return true;
					}
				return false;
			}

		/**
		 * CronDeleteMusicHandler::sendMailToUserForDelete()
		 *
		 * @return
		 */
		public function sendMailToUserForDelete()
			{
				if(isset($this->MUSIC_USER_EMAIL) and $this->MUSIC_USER_EMAIL)
					{
						$subject = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $this->LANG['music_delete_subject']);
						$body = $this->LANG['music_delete_content'];
						$body = str_replace('VAR_LINK', '<a href=\''.$this->CFG['site']['url'].'\'>'.$this->CFG['site']['url'].'</a>', $body);
						$body = str_replace('VAR_USER_NAME', $this->MUSIC_USER_NAME, $body);
						$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
						$body = str_replace('VAR_MUSIC_TITLE', $this->MUSIC_TITLE, $body);
						echo $this->MUSIC_USER_EMAIL;
						$this->_sendMail($this->MUSIC_USER_EMAIL, $subject, nl2br($body), $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);
						return true;
					}
				else
					return true;
			}

		/**
		 * CronDeleteMusicHandler::getServerDetails()
		 *
		 * @return
		 */
		public function getServerDetails()
			{
				$server_url = str_replace($this->CFG['admin']['musics']['folder'].'/','',$this->fields_arr['music_server_url']);
				$cid = $this->MUSIC_CATEGORY_ID.',0';

				$sql = 'SELECT ftp_server, ftp_folder, ftp_usrename, ftp_password, category FROM'.
						' '.$this->CFG['db']['tbl']['server_settings'].
						' WHERE server_for=\'music\' AND server_url='.$this->dbObj->Param('server_url').
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

						if($row['category']==$this->MUSIC_CATEGORY_ID)
							return true;
					}
				if(isset($this->fields_arr['ftp_server']) and $this->fields_arr['ftp_server'])
					return true;
				return false;
			}

		/**
		 * CronDeleteMusicHandler::populateMusicDetails()
		 *
		 * @return
		 */
		public function populateMusicDetails()
			{
				$this->MUSIC_USER_NAME = '';
				$this->MUSIC_USER_EMAIL = '';
				$this->MUSIC_USER_ID = '';
				$sql = 'SELECT music_ext, music_title, music_category_id, user_id FROM'.
						' '.$this->CFG['db']['tbl']['music'].' WHERE'.
						' music_id='.$this->dbObj->Param('music_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						$this->MUSIC_TITLE = $row['music_title'];
						$this->MUSIC_EXT = $row['music_ext'];
						$this->MUSIC_CATEGORY_ID = $row['music_category_id'];
						$sql = 'SELECT user_name, email, user_id FROM '.$this->CFG['db']['tbl']['users'].' WHERE'.
								' user_id='.$this->dbObj->Param('user_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs1 = $this->dbObj->Execute($stmt, array($row['user_id']));
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						if($row1 = $rs1->FetchRow())
							{
								$this->MUSIC_USER_NAME = $row1['user_name'];
								$this->MUSIC_USER_EMAIL = $row1['email'];
								$this->MUSIC_USER_ID = $row1['user_id'];
							}
						return true;
					}
					return false;
			}

		/**
		 * CronDeleteMusicHandler::removeFiles()
		 *
		 * @param mixed $file
		 * @return
		 */
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
		 * CronDeleteMusicHandler::clearMusicCommented()
		 *
		 * @param integer $id
		 * @param mixed $type
		 * @return
		 */
		public function clearMusicCommented($id = 0, $type)
			{
				if($type == 'user_id')
					{
						$field = 'music_id';
						$condition = 'comment_user_id='.$this->dbObj->Param('id');
					}
				elseif($type == 'music_id')
					{
						$field = 'comment_user_id';
						$condition = 'music_id='.$this->dbObj->Param('id');
					}
				$sql = 'SELECT music_comment_id, '.$field.
						' FROM '.$this->CFG['db']['tbl']['music_comments'].
						' WHERE '.$condition;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($id));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
								$this->userMusic[($type=='music_id')?$id:$row['music_id']] = '1';
								$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['music_comments'], 'music_comment_id', $row['music_comment_id']);
						    }
					}
				return true;
			}

		/**
		 * CronDeleteMusicHandler::clearMusicFavorited()
		 *
		 * @param integer $id
		 * @param mixed $type
		 * @return
		 */
		public function clearMusicFavorited($id = 0, $type)
			{
				if($type == 'user_id')
					{
						$field = 'music_id';
						$condition = 'user_id='.$this->dbObj->Param('id');
					}
				elseif($type == 'music_id')
					{
						$field = 'user_id';
						$condition = 'music_id='.$this->dbObj->Param('id');
					}
				$sql = 'SELECT music_favorite_id, '.$field.
						' FROM '.$this->CFG['db']['tbl']['music_favorite'].
						' WHERE '.$condition;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($id));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
								$this->userMusic[($type=='music_id')?$id:$row['music_id']] = '1';
								$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['music_favorite'], 'music_favorite_id', $row['music_favorite_id']);
						    } // while
					}
				return true;
			}

		/**
		 * CronDeleteMusicHandler::clearMusicRated()
		 *
		 * @param integer $id
		 * @param mixed $type
		 * @return
		 */
		public function clearMusicRated($id = 0, $type)
			{
				if($type == 'user_id')
					{
						$field = 'music_id';
						$condition = 'user_id='.$this->dbObj->Param('id');
					}
				elseif($type == 'music_id')
					{
						$field = 'user_id';
						$condition = 'music_id='.$this->dbObj->Param('id');
					}
				$sql = 'SELECT rating_id, '.$field.
						' FROM '.$this->CFG['db']['tbl']['music_rating'].
						' WHERE '.$condition;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($id));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
								$this->userMusic[($type=='music_id')?$id:$row['music_id']] = '1';
								$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['music_rating'], 'rating_id', $row['rating_id']);
						    } // while
					}
				return true;
			}

		/**
		 * CronDeleteMusicHandler::clearMusicViewed()
		 *
		 * @param integer $id
		 * @param mixed $type
		 * @return
		 */
		public function clearMusicViewed($id = 0, $type)
			{
				if($type == 'user_id')
					{
						$field = 'music_id';
						$condition = 'user_id='.$this->dbObj->Param('user_id').
										' OR music_owner_id='.$this->dbObj->Param('music_owner_id');
						$value_arr = array($id, $id);
					}
				elseif($type == 'music_id')
					{
						$field = 'user_id';
						$condition = 'music_id='.$this->dbObj->Param('music_id');
						$value_arr = array($id);
					}
				$sql = 'SELECT music_viewed_id, '.$field.
						' FROM '.$this->CFG['db']['tbl']['music_viewed'].
						' WHERE '.$condition;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $value_arr);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
								$this->userMusic[($type=='music_id')?$id:$row['music_id']] = '1';
								$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['music_viewed'], 'music_viewed_id', $row['music_viewed_id']);
						    } // while
					}
				return true;
			}

		/**
		 * CronDeleteMusicHandler::clearMusicListened()
		 *
		 * @param integer $id
		 * @param mixed $type
		 * @return
		 */
		public function clearMusicListened($id = 0, $type)
			{
				if($type == 'user_id')
					{
						$field = 'music_id';
						$condition = 'user_id='.$this->dbObj->Param('user_id').
										' OR music_owner_id='.$this->dbObj->Param('music_owner_id');
						$value_arr = array($id, $id);
					}
				elseif($type == 'music_id')
					{
						$field = 'user_id';
						$condition = 'music_id='.$this->dbObj->Param('music_id');
						$value_arr = array($id);
					}

				$sql = 'SELECT music_listened_id, '.$field.
						' FROM '.$this->CFG['db']['tbl']['music_listened'].
						' WHERE '.$condition;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $value_arr);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
								$this->userMusic[($type=='music_id')?$id:$row['music_id']] = '1';
								$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['music_listened'], 'music_listened_id', $row['music_listened_id']);
						    } // while
					}
				return true;
			}

		/**
		 * CronDeleteMusicHandler::resetRelatedMusicDetails()
		 *
		 * @return
		 */
		public function resetRelatedMusicDetails()
			{
				if ($this->userMusic)
				    {
						$userMusic = array_keys($this->userMusic);
						foreach($userMusic as $musicId)
							{
								$totalComments 	= $this->getNumRowsForThisSql($this->CFG['db']['tbl']['music_comments'], 'music_id='.$this->dbObj->Param($musicId), array($musicId));
								$totalFavorites = $this->getNumRowsForThisSql($this->CFG['db']['tbl']['music_favorite'], 'music_id='.$this->dbObj->Param($musicId), array($musicId));
								$totalViews	 	= $this->getNumRowsForThisSql($this->CFG['db']['tbl']['music_viewed'], 'music_id='.$this->dbObj->Param($musicId), array($musicId));
								$ratingCount 	= $this->getNumRowsForThisSql($this->CFG['db']['tbl']['music_rating'], 'music_id='.$this->dbObj->Param($musicId), array($musicId));
								$ratingTotal	= $this->getTotalRatingForThisMusic($musicId);
								$sql = 	'UPDATE '.$this->CFG['db']['tbl']['music'].
										' SET '.
										' total_comments='.$this->dbObj->Param($totalComments).','.
										' total_favorites='.$this->dbObj->Param($totalFavorites).','.
										' total_views='.$this->dbObj->Param($totalViews).','.
										' rating_count='.$this->dbObj->Param($ratingCount).','.
										' rating_total='.$this->dbObj->Param($ratingTotal).
										' WHERE music_id='.$this->dbObj->Param($musicId);

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($totalComments, $totalFavorites, $totalViews, $ratingCount, $ratingTotal, $musicId));
								if (!$rs)
								    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
						    }
					}
			}

		/**
		 * CronDeleteMusicHandler::deleteMusicsTable()
		 *
		 * @return
		 */
		public function deleteMusicsTable()
			{
				$music_id = $this->deletedMusicIds;
				$musicId_arr = explode(',',$music_id);
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
		 * CronDeleteMusicHandler::getTotalRatingForThisMusic()
		 *
		 * @param integer $music_id
		 * @return
		 */
		public function getTotalRatingForThisMusic($music_id = 0)
			{
				$ratingTotal = 0;
				$sql = 'SELECT SUM(rate) AS rating_total '.
						'FROM '.$this->CFG['db']['tbl']['music_rating'].
						' WHERE music_id='.$this->dbObj->Param($music_id);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($music_id));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$ratingTotal = $row['rating_total'];
				    }
				return $ratingTotal?$ratingTotal:0;
			}

		/**
		 * CronDeleteMusicHandler::chkIsLocalServer()
		 *
		 * @return
		 */
		public function chkIsLocalServer()
			{
				$server_url = $this->fields_arr['music_server_url'];
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
		 * CronDeleteMusicHandler::removePlaylistRelatedEntries()
		 *
		 * @param mixed $id
		 * @param mixed $type
		 * @return
		 */
		public function removePlaylistRelatedEntries($id = 0, $type)
			{

				if($type == 'playlist_id')
					{
						//Later//
					}
				elseif($type == 'user_id')
					{
						$this->deletedPlaylistIds='';
						$condition = 'user_id='.$this->dbObj->Param('user_id');
						$sql = 'SELECT playlist_id '.
								'FROM '.$this->CFG['db']['tbl']['music_playlist'].' '.
								'WHERE '.$condition;

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($id));
						if (!$rs)
							trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						if ($rs->PO_RecordCount())
							{
								# DELETE COMMENT
								$this->clearPlaylistCommented($id, $type);
								# DELETE FAVORITE
								$this->clearPlaylistFavorited($id, $type);
								# DELETE RATING
								$this->clearPlaylistRated($id, $type);
								# DELETE VIEW
								$this->clearPlaylistViewed($id, $type);
								# DELETE LISTENED
								$this->clearMusicListened($id, $type);
								# UPDATE PLAYLIST RELATED TABEL
								$this->resetRelatedPlaylistDetails();
								# CLEAR PLAYLIST ACTIVITY
								$this->clearPlaylistActivity($id = 0, $type)
								while($row = $rs->FetchRow())
									{
										$this->deletedPlaylistIds.=$row['playlist_id'].',';
									}
								# DELETED PLAYLIST TABEL
								$this->deletePlaylistTable();
							}
					}
				elseif($type == 'music_id')
					{
						# UPDATE PLAYLIST TABEL
						$sql = 'SELECT music_in_playlist_id, playlist_id, order_id FROM '.$this->CFG['db']['tbl']['music_in_playlist'].' '.
								'WHERE music_id = '.$this->dbObj->Param('music_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($id));
						if (!$rs)
							trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						while($row = $rs->FetchRow())
							{
								# REORDER PLAYLIST MUSIC(LATER)
								$playlist_id = $row['playlist_id'];
								$set_fields = 'total_tracks = total_tracks - 1';
								$condition = 'playlist_id = '.$this->dbObj->Param('playlist_id');
								$this->updateTable($this->CFG['db']['tbl']['music_playlist'],$set_fields , $condition, array($playlist_id));
							}
						# DELETE MUSIC IN MUSIC PLAYLIST TABEL
						$condition = 'music_id = '.$this->dbObj->Param('music_id');
						$this->deleteFromTable($this->CFG['db']['tbl']['music_in_playlist'], $condition, array($id));
					}
				return true;
			}

		/**
		 * CronDeleteMusicHandler::clearPlaylistCommented()
		 *
		 * @param mixed $playlist_id
		 * @return
		 */
		public function clearPlaylistCommented($id = 0, $type)
			{
				if($type == 'user_id')
					{
						$field = 'playlist_id';
						$condition = 'comment_user_id='.$this->dbObj->Param('comment_user_id');
					}
				elseif($type == 'playlist_id')
					{
						$field = 'user_id';
						$condition = 'playlist_id='.$this->dbObj->Param('id');
					}
				$sql = 'SELECT playlist_comment_id '.
						'FROM '.$this->CFG['db']['tbl']['music_playlist_comments'].' '.
						'WHERE '.$condition;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($id));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
								$this->userPlaylist[($type=='playlist_id')?$id:$row['playlist_id']] = '1';
								$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['music_playlist_comments'], 'playlist_comment_id', $row['playlist_comment_id']);
						    }
					}
				return true;
			}

		/**
		 * CronDeleteMusicHandler::clearPlaylistFavorited()
		 *
		 * @param mixed $id
		 * @param mixed $type
		 * @return
		 */
		public function clearPlaylistFavorited($id = 0, $type)
			{
				if($type == 'user_id')
					{
						$field = 'playlist_id';
						$condition = 'user_id='.$this->dbObj->Param('id');
					}
				elseif($type == 'playlist_id')
					{
						$field = 'user_id';
						$condition = 'playlist_id='.$this->dbObj->Param('id');
					}
				$sql = 'SELECT music_playlist_favorite_id, '.$field.
						' FROM '.$this->CFG['db']['tbl']['music_playlist_favorite'].
						' WHERE '.$condition;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($id));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
								$this->userPlaylist[($type=='playlist_id')?$id:$row['playlist_id']] = '1';
								$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['music_playlist_favorite'], 'music_playlist_favorite_id', $row['music_playlist_favorite_id']);
						    } // while
					}
				return true;
			}

		/**
		 * CronDeleteMusicHandler::clearPlaylistRated()
		 *
		 * @param integer $id
		 * @param mixed $type
		 * @return
		 */
		public function clearPlaylistRated($id = 0, $type)
			{
				if($type == 'user_id')
					{
						$field = 'playlist_id';
						$condition = 'user_id='.$this->dbObj->Param('id');
					}
				elseif($type == 'playlist_id')
					{
						$field = 'user_id';
						$condition = 'playlist_id='.$this->dbObj->Param('id');
					}
				$sql = 'SELECT rating_id, '.$field.
						' FROM '.$this->CFG['db']['tbl']['music_playlist_rating'].
						' WHERE '.$condition;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($id));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
								$this->userPlaylist[($type=='playlist_id')?$id:$row['playlist_id']] = '1';
								$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['music_playlist_rating'], 'rating_id', $row['rating_id']);
						    } // while
					}
				return true;
			}

		/**
		 * CronDeleteMusicHandler::clearPlaylistViewed()
		 *
		 * @param integer $id
		 * @param mixed $type
		 * @return
		 */
		public function clearPlaylistViewed($id = 0, $type)
			{
				if($type == 'user_id')
					{
						$field = 'playlist_id';
						$condition = 'user_id='.$this->dbObj->Param('user_id').
										' OR playlist_owner_id='.$this->dbObj->Param('playlist_owner_id');
						$value_arr = array($id, $id);
					}
				elseif($type == 'music_id')
					{
						$field = 'user_id';
						$condition = 'playlist_id='.$this->dbObj->Param('playlist_id');
						$value_arr = array($id);
					}
				$sql = 'SELECT playlist_viewed_id, '.$field.
						' FROM '.$this->CFG['db']['tbl']['music_playlist_viewed'].
						' WHERE '.$condition;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $value_arr);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
								$this->userPlaylist[($type=='playlist_id')?$id:$row['playlist_id']] = '1';
								$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['music_playlist_viewed'], 'playlist_viewed_id', $row['playlist_viewed_id']);
						    } // while
					}
				return true;
			}

		/**
		 * CronDeleteMusicHandler::resetRelatedPlaylistDetails()
		 *
		 * @return
		 */
		public function resetRelatedPlaylistDetails()
			{
				if ($this->userPlaylist)
				    {
						$userPlaylist = array_keys($this->userPlaylist);
						foreach($userPlaylist as $playlistId)
							{
						       	$totalComments 	= $this->getNumRowsForThisSql($this->CFG['db']['tbl']['music_playlist_comments'], 'music_id='.$this->dbObj->Param($playlistId), array($playlistId));
								$totalFavorites = $this->getNumRowsForThisSql($this->CFG['db']['tbl']['music_playlist_favorite'], 'music_id='.$this->dbObj->Param($playlistId), array($playlistId));
								$totalViews	 	= $this->getNumRowsForThisSql($this->CFG['db']['tbl']['music_playlist_viewed'], 'music_id='.$this->dbObj->Param($playlistId), array($playlistId));
								$ratingCount 	= $this->getNumRowsForThisSql($this->CFG['db']['tbl']['music_playlist_rating'], 'music_id='.$this->dbObj->Param($playlistId), array($playlistId));
								$ratingTotal	= $this->getTotalRatingForThisMusic($musicId);
								$sql = 	'UPDATE '.$this->CFG['db']['tbl']['music'].
										' SET '.
										' total_comments='.$this->dbObj->Param($totalComments).','.
										' total_favorites='.$this->dbObj->Param($totalFavorites).','.
										' total_views='.$this->dbObj->Param($totalViews).','.
										' rating_count='.$this->dbObj->Param($ratingCount).','.
										' rating_total='.$this->dbObj->Param($ratingTotal).
										' WHERE music_id='.$this->dbObj->Param($musicId);

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($totalComments, $totalFavorites, $totalViews, $ratingCount, $ratingTotal, $musicId));
								if (!$rs)
								    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
						    }
					}
			}

		/**
		 * CronDeleteMusicHandler::deletePlaylistTable()
		 *
		 * @return
		 */
		public function deletePlaylistTable()
			{
				$playlist_id = $this->deletedPlaylistIds;
				$playlistId_arr = explode(',',$playlist_id);
				$playlistId_arr = array_filter($playlistId_arr);
				$playlist_id = implode(',',$playlistId_arr);
				if($playlist_id)
					{
						$tablename_arr = array('music_playlist');
						for($i=0;$i<sizeof($tablename_arr);$i++)
							{
								$sql = 'DELETE FROM '.$this->CFG['db']['tbl'][$tablename_arr[$i]].
										' WHERE playlist_id IN ('.$music_id.')';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
							    if (!$rs)
								    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
							}
					}
			}

		/**
		 * CronDeleteMusicHandler::clearMusicAlbum()
		 *
		 * @return
		 */
		public function clearMusicAlbum()
			{
				$sql = 'SELECT DISTINCT(ma.music_album_id) FROM music AS m JOIN music_album AS ma ON m.music_album_id = ma.music_album_id '.
						'WHERE music_status = \'Deleted\' AND ma.music_album_id !=1 AND ma.music_album_id NOT IN '.
						'(SELECT music_album_id FROM music WHERE music_status != \'Deleted\')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
								$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_album'].
										' WHERE music_album_id IN ('.music_album_id.')';

								$stmt = $this->dbObj->Prepare($sql);
								$resultSet = $this->dbObj->Execute($stmt, array($row['music_album_id']));
							    if (!$resultSet)
								    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
						    }
					}
			}

		/**
		 * CronDeletePlaylistHandler::clearPlaylistListened()
		 *
		 * @param integer $id
		 * @param mixed $type
		 * @return
		 */
		public function clearPlaylistListened($id = 0, $type)
			{
				if($type == 'user_id')
					{
						$field = 'playlist_id';
						$condition = 'user_id='.$this->dbObj->Param('user_id').
										' OR playlist_owner_id='.$this->dbObj->Param('playlist_owner_id');
						$value_arr = array($id, $id);
					}
				elseif($type == 'playlist_id')
					{
						$field = 'user_id';
						$condition = 'playlist_id='.$this->dbObj->Param('playlist_id');
						$value_arr = array($id);
					}
				$sql = 'SELECT playlist_listened_id, '.$field.
						' FROM '.$this->CFG['db']['tbl']['music_playlist_listened'].
						' WHERE '.$condition;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $value_arr);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
								$this->userMusic[($type=='playlist_id')?$id:$row['playlist_id']] = '1';
								$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['music_playlist_listened'], 'playlist_listened_id', $row['playlist_listened_id']);
						    } // while
					}
				return true;
			}

		/**
		 * CronDeleteMusicHandler::clearMusicActivity()
		 *
		 * @param integer $id
		 * @param mixed $type
		 * @return
		 */
		public function clearMusicActivity($id = 0, $type)
			{
				if($type == 'user_id')
					{
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_activity'].
								' WHERE actor_id='.$this->dbObj->Param('actor_id').
								' OR owner_id='.$this->dbObj->Param('owner_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($id, $id));
					    if (!$rs)
						    trigger_db_error($this->dbObj);
					}
				elseif($type == 'music_id')
					{
						$action_key = array('music_uploaded', 'music_comment', 'music_rated', 'music_favorite', 'music_featured', 'music_share');
						for($inc=0;$inc<count($action_key);$inc++)
							{
								$condition = ' SUBSTRING(action_value, 1, 1 ) IN ('.$playlist_ids.') AND action_key = \''.$action_key[$inc].'\'';
								$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_activity'].
										' WHERE '.$condition;

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($id, ));
							    if (!$rs)
								    trigger_db_error($this->dbObj);
							}
					}
				return true;
			}

		/**
		 * CronDeleteMusicHandler::clearMusicLyrics()
		 *
		 * @param integer $id
		 * @param mixed $type
		 * @return
		 */
		public function clearMusicLyrics($id = 0, $type)
			{
				if($type == 'user_id')
					{
						$field = 'music_id';
						$condition = 'user_id='.$this->dbObj->Param('user_id');
						$value_arr = array($id);
					}
				elseif($type == 'music_id')
					{
						$field = 'user_id';
						$condition = 'music_id='.$this->dbObj->Param('music_id');
						$value_arr = array($id);
					}
				$sql = 'SELECT music_lyric_id, '.$field.
						' FROM '.$this->CFG['db']['tbl']['music_lyric'].
						' WHERE '.$condition;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $value_arr);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
								$this->userMusic[($type=='music_id')?$id:$row['music_id']] = '1';
								$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['music_lyric'], 'music_lyric_id', $row['music_lyric_id']);
						    } // while
					}
				return true;
			}

		/**
		 * CronDeleteMusicHandler::clearPlaylistActivity()
		 *
		 * @param integer $id
		 * @param mixed $type
		 * @return
		 */
		public function clearPlaylistActivity($id = 0, $type)
			{
				if($type == 'user_id')
					{
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_activity'].
								' WHERE actor_id='.$this->dbObj->Param('actor_id').
								' OR owner_id='.$this->dbObj->Param('owner_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($id, $id));
					    if (!$rs)
						    trigger_db_error($this->dbObj);
					}
				return true;
			}
	}
?>