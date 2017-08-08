<?php
/**
 * musicHandler
 *
 * @package Music
 * @author karthiselvam_45at09
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version 3.0
 * @access public
 */
class MusicHandler extends MediaHandler
	{
		public $_navigationArr = array();
		public $_clsActiveLink = 'clsActive';
		public $_clsInActiveLink = 'clsInActive';
		public $_currentPage = '';
		public $artist_name  = '';
		public $artist_id = '';
		public $music_title = '';
		public $music_owner_name = '';
		public $music_owner_id = '';

		/**
		 * MusicHandler::__construct()
		 *
		 */
		public function __construct()
			{
				parent::__construct();
				if(isMember())
					{
						$this->quickMixUrl = $this->CFG['site']['music_url'].'getMusicDetails.php?ajax_page=true&action=quickmix';
						$this->saveVolumeUrl = $this->CFG['site']['music_url'].'getMusicDetails.php?ajax_page=true&action=save_volume';
						$this->playSongsUrl = $this->CFG['site']['music_url'].'playSongsInPlaylist.php';
						$this->createAlbumUrl = $this->CFG['site']['music_url'].'createAlbum.php';
					}
				else
					{
						$this->quickMixUrl = $this->CFG['site']['music_url'].'getMusicDetails.php?ajax_page=true&action=quickmix';
						$this->saveVolumeUrl = $this->CFG['site']['music_url'].'getMusicDetails.php?ajax_page=true&action=save_volume';
						$this->playSongsUrl = $this->CFG['site']['music_url'].'playSongsInPlaylist.php';
						$this->createAlbumUrl = $this->CFG['site']['music_url'].'createAlbum.php';

					}
				$this->playQuickMixUrl = getUrl('playquickmix', '', '', '', 'music');
				$this->viewCartUrl = getUrl('viewmusiccart', '', '', '', 'music');
				//Quick Mixed songs
				$this->quick_mix_id_arr = array();
				if(isset($_SESSION['user']['music_quick_mixs']))
					$this->quick_mix_id_arr = explode(',', $_SESSION['user']['music_quick_mixs']);
				//Quick Mix Popup Window name
				$this->quick_mix_window_name = '';
				if(isset($_SESSION['user']['quick_mix_window_name']))
					$this->quick_mix_window_name = $_SESSION['user']['quick_mix_window_name'];

				//SETTING GLOBAL VOLUME TO DEFAULT VALUE IF SESSION IS NOT INITIALIZED
				if(!isset($_SESSION['music_global_voulme']))
					$_SESSION['music_global_voulme'] = 100;
			}

		/**
		 * musicHandler::deleteSongFromPlaylist()
		 *
		 * @param mixed $playlist_id
		 * @return
		 */
		public function deleteSongFromPlaylist()
			{
				$song_id = $this->fields_arr['song_id'];

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_in_playlist'].' '.
								'WHERE music_id IN ('.$song_id.') AND playlist_id='.$this->fields_arr['playlist_id'] ;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$affected_count = $this->dbObj->Affected_Rows();
				$this->updatePlaylistTable($this->fields_arr['playlist_id'], $affected_count);
			}

		/**
		 * musicHandler::updatePlaylistTable()
		 *
		 * @param mixed $playlist_id
		 * @return
		 */
		public function updatePlaylistTable($playlist_id, $affected_count = 0)
			{
				if($affected_count)
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist'].
								' SET total_tracks=total_tracks - '.$affected_count.' WHERE  playlist_id='.$this->dbObj->Param('playlist_id').'';
					}
				else
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist'].
								' SET total_tracks=total_tracks+1 WHERE  playlist_id='.$this->dbObj->Param('playlist_id').'';
					}
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($playlist_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				return true;
			}
		/**
		 * musicHandler::insertSongtoPlaylist()
		 *
		 * @param mixed $playlist_id
		 * @param mixed $song_id
		 * @return
		 */
		public function insertSongtoPlaylist($playlist_id, $song_id)
			{
				if($song_id==0)
					return;

				//CHECK SONG IS ALREADY IN PLAYLIST //

				$sql = 'SELECT music_in_playlist_id FROM '.$this->CFG['db']['tbl']['music_in_playlist'].' '.
						'WHERE playlist_id ='.$this->dbObj->Param('playlist_id').' AND '.
						'music_id ='.$this->dbObj->Param('music_id').'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($playlist_id, $song_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if($row['music_in_playlist_id'] == '' or !isset($row['music_in_playlist_id']))
					{
						// FIND ORDER SONG IN PLAYLIST //

						$sql = 'SELECT order_id FROM '.$this->CFG['db']['tbl']['music_in_playlist'].' '.
								'WHERE playlist_id ='.$this->dbObj->Param('playlist_id');


						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($playlist_id));
						if (!$rs)
							trigger_db_error($this->dbObj);

						$row = $rs->FetchRow();
						$order_id = $row['order_id'] + 1;

						//INSERT SONG INTO PLAYLIST //

						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_in_playlist'].' '.
								'SET playlist_id='.$this->dbObj->Param('playlist_id').', music_id='.$this->dbObj->Param('music_id').', '.
								'order_id='.$this->dbObj->Param('order_id').', date_added=NOW()';

						$value_arr = array($playlist_id, $song_id, $order_id);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $value_arr);
					    if (!$rs)
							trigger_db_error($this->dbObj);
						//UPDATE PLAYLIST TABLE total_tracks
						$this->updatePlaylistTable($playlist_id);
					}
				return true;
			}

		/**
		 * musicHandler::createplaylist()
		 *
		 * @return
		 */
		public function createplaylist()
			{
				if(isset($this->fields_arr['playlist_id']) and $this->fields_arr['playlist_id'] != '')
					{
						$sql = 'SELECT playlist_tags FROM '.$this->CFG['db']['tbl']['music_playlist'].
								' WHERE playlist_id ='.$this->dbObj->Param('playlist_id').'';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist_id']));
						if (!$rs)
							trigger_db_error($this->dbObj);

						$row = $rs->FetchRow();
						//Update music_playlist detail
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist'].
								' SET playlist_name='.$this->dbObj->Param('playlist_name').', playlist_description='.$this->dbObj->Param('playlist_description').
								', playlist_tags='.$this->dbObj->Param('playlist_tags').' ';
						$sql .= ', allow_comments='.$this->dbObj->Param('allow_comments').', allow_ratings='.$this->dbObj->Param('allow_ratings').', allow_embed='.$this->dbObj->Param('allow_embed').'';
						$sql .= ' WHERE  playlist_id='.$this->dbObj->Param('playlist_id');
						$value_arr = array($this->fields_arr['playlist_name'], $this->fields_arr['playlist_description'], $this->fields_arr['playlist_tags'], $this->fields_arr['allow_comments'], $this->fields_arr['allow_ratings'], $this->fields_arr['allow_embed'], $this->fields_arr['playlist_id']);

						if (!$this->chkIsAdminSide())
							{
								$sql .= ' AND user_id='.$this->dbObj->Param('user_id');
								$value_arr[] = $this->CFG['user']['user_id'];
							}

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $value_arr);
					    if (!$rs)
							trigger_db_error($this->dbObj);

						$playlist_id = $this->fields_arr['playlist_id'];
						//Edit music playList tags
						$this->editMusicPlaylistTags($row['playlist_tags']);
					}
				else
					{
						//Create Playlis detail
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_playlist'].
								' SET user_id='.$this->dbObj->Param('user_id').', playlist_name='.$this->dbObj->Param('playlist_name').', playlist_description='.$this->dbObj->Param('playlist_description').
								', allow_comments='.$this->dbObj->Param('allow_comments').', allow_ratings='.$this->dbObj->Param('allow_ratings').', allow_embed='.$this->dbObj->Param('allow_embed').
								', playlist_tags='.$this->dbObj->Param('playlist_tags').', date_added=NOW()';

						$value_arr = array($this->CFG['user']['user_id'], $this->fields_arr['playlist_name'], $this->fields_arr['playlist_description'], $this->fields_arr['allow_comments'], $this->fields_arr['allow_ratings'], $this->fields_arr['allow_embed'], $this->fields_arr['playlist_tags']);

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $value_arr);
					    if (!$rs)
							trigger_db_error($this->dbObj);

					 	$playlist_id = $this->dbObj->Insert_ID();
						if($this->_currentPage != 'createplaylist')
							$this->playlistCreateActivity($playlist_id);
						//Create music playlist tags
						$this->addMusicPlaylistTag();
					}
				return $playlist_id;
			}

		/**
		 * musicHandler::deleteMusicPlaylist()
		 * Here we deleted playlist related table , activity & playlist table
		 * @return
		 */
		public function deleteMusicPlaylist()
			{
				$playlist_ids = $this->fields_arr['playlist_ids'];
				//DELETED PLAYLIST TAGS//
				$this->deleteMusicPlaylistTag($playlist_ids);
				// *********Delete records from PLAYLIST related tables start*****
				$tablename_arr = array('music_playlist_comments', 'music_playlist_favorite', 'music_playlist_listened', 'music_playlist_featured', 'music_playlist_viewed', 'music_playlist_rating');
				for($i=0;$i<sizeof($tablename_arr);$i++)
					{
						$sql  = 'DELETE FROM '.$this->CFG['db']['tbl'][$tablename_arr[$i]].' WHERE playlist_id IN(' . $playlist_ids . ')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs   = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_db_error($this->dbObj);
					}

				//DELETE PLAYLIST RELATED ACTIVITY //
				$action_key = array('playlist_create', 'playlist_comment', 'playlist_rated', 'playlist_featured', 'playlist_favorite', 'playlist_share');
				for($inc=0;$inc<count($action_key);$inc++)
					{
						$condition = '  SUBSTRING(action_value, 1, 1 ) IN ('.$playlist_ids.') AND action_key = \''.$action_key[$inc].'\'';
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_activity'].
						' WHERE '.$condition;

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_db_error($this->dbObj);

					}

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_playlist'].' '.
						'WHERE playlist_id IN ('.$playlist_ids.')' ;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				return true;
			}

			/**
			 * musicHandler::deleteMusicPlaylistTag()
			 *
			 * @param mixed $playlist_id
			 * @return
			 */
			public function deleteMusicPlaylistTag($playlist_id)
				{
					// DELETE TAGS
							$sql='SELECT playlist_tags FROM '.$this->CFG['db']['tbl']['music_playlist'].
								 ' WHERE playlist_id IN('.$playlist_id.')';

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt);
						    if (!$rs)
							    trigger_db_error($this->dbObj);

							while($tag_row = $rs->FetchRow())
						    	{
						    		$tag=explode(' ',$tag_row['playlist_tags']);
						    		for($i=0;$i<count($tag);$i++)
										{
											 $sql='SELECT playlist_id FROM '.$this->CFG['db']['tbl']['music_playlist'].
											 	   ' WHERE concat( \' \', playlist_tags, \' \' ) LIKE "% '.$tag[$i].' %" AND playlist_id NOT IN('.$playlist_id.')';

											 $stmt = $this->dbObj->Prepare($sql);
										     $rs_tag = $this->dbObj->Execute($stmt);
											 if (!$rs_tag)
												trigger_db_error($this->dbObj);
											 if(!$row = $rs_tag->FetchRow())
												 {
												 	$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_playlist_tags'].
															' WHERE tag_name=\''.$tag[$i].'\'';
													$stmt = $this->dbObj->Prepare($sql);
													$rs_delete = $this->dbObj->Execute($stmt);
													if (!$rs_delete)
														trigger_db_error($this->dbObj);
												 }
										 }
								}
					// DELETE TAG END
				}

		/**
		 * musicPlaylistManage::getMusicPlaylist()
		 *
		 * @return
		 */
		public function getMusicPlaylist()
			{
				$sql ='SELECT playlist_id, playlist_name, playlist_description, playlist_tags, allow_comments, allow_ratings, allow_embed FROM '.$this->CFG['db']['tbl']['music_playlist'].
						' WHERE playlist_id='.$this->dbObj->Param('playlist_id').' ';

				$value_arr = array($this->fields_arr['playlist_id']);
				 if (!$this->chkIsAdminSide())
				 	{
						$sql .= 'AND user_id='.$this->dbObj->Param('user_id');
						$value_arr[] = $this->CFG['user']['user_id'];
					}

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $value_arr);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if(isset($row['playlist_id']))
					{
						$this->fields_arr['playlist_name'] = $row['playlist_name'];
						$this->fields_arr['playlist_description'] = $row['playlist_description'];
						$this->fields_arr['playlist_tags'] = $row['playlist_tags'];
						$this->fields_arr['allow_comments'] = $row['allow_comments'];
						$this->fields_arr['allow_ratings'] = $row['allow_ratings'];
						$this->fields_arr['allow_embed'] = $row['allow_embed'];
					 	$this->playlist_tags = $row['playlist_tags'];
						return true;
					}
				else
					{
						return false;
					}

			}

		/**
		 * musicPlaylistManage::getPlaylistName()
		 *
		 * @param mixed $playlist
		 * @param string $err_tip
		 * @return
		 */
			public function getPlaylistName()
				{
					$sql ='SELECT playlist_name FROM '.$this->CFG['db']['tbl']['music_playlist'].' WHERE playlist_id='.$this->dbObj->Param('playlist_id');
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
					if (!$rs)
						trigger_db_error($this->dbObj);
					if($rs->PO_RecordCount())
						{
							$row = $rs->FetchRow();
							return $row['playlist_name'];
						}
				}

		/**
		 * musicPlaylistManage::chkplaylistExits()
		 *
		 * @param mixed $playlist
		 * @param string $err_tip
		 * @return
		 */
		public function chkPlaylistExits($playlist, $err_tip='')
			{
				$sql = 'SELECT COUNT(playlist_id) AS count FROM '.$this->CFG['db']['tbl']['music_playlist'].' '.
							'WHERE UCASE(playlist_name) = UCASE('.$this->dbObj->Param($this->fields_arr[$playlist]).') '.
							' AND user_id=\''.$this->CFG['user']['user_id'].'\' ';

				$fields_value_arr[] = $this->fields_arr[$playlist];

				if ($this->fields_arr['playlist_id'])
					{
						$sql .= ' AND playlist_id != '.$this->dbObj->Param($this->fields_arr['playlist_id']);
						$fields_value_arr[] = $this->fields_arr['playlist_id'];
				    }

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($fields_value_arr));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();

				if(!$row['count'])
					{
						return true;
					}
				$this->fields_err_tip_arr['playlist_name'] = $err_tip;
				return false;
			}

		/**
		 * musicHandler::addMusicPlaylistTag()
		 *
		 * @return
		 */
		public function addMusicPlaylistTag()
			{
				$tag_arr = explode(' ', $this->fields_arr['playlist_tags']);
				$tag_arr = array_unique($tag_arr);
				if($key = array_search('', $tag_arr))
					unset($tag_arr[$key]);

				foreach($tag_arr as $key=>$value)
					{
						if((strlen($value)<$this->CFG['fieldsize']['music_playlist_tags']['min'])
							or (strlen($value)>$this->CFG['fieldsize']['music_playlist_tags']['max']))
							continue;

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist_tags'].' SET result_count=result_count+1'.
								' WHERE tag_name='.$this->dbObj->Param('playlist_tags');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($value));
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						if(!$this->dbObj->Affected_Rows())
							{
								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_playlist_tags'].' SET'.
										' tag_name='.$this->dbObj->Param('playlist_tags').', result_count=1';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($value));
							    if (!$rs)
								    trigger_db_error($this->dbObj);
							}
					}
			}

		/**
		 * musicHandler::editMusicPlaylistTags()
		 *
		 * @return
		 */
		public function editMusicPlaylistTags($oldtag_arr)
			{
				$tag_arr = explode(' ', $this->fields_arr['playlist_tags']);
				$tag_arr = array_unique($tag_arr);
				if($key = array_search('', $tag_arr))
					unset($tag_arr[$key]);

				//Remove old tags
				$oldtag_arr = explode(' ', $oldtag_arr);
				foreach($oldtag_arr as $oldTag)
					{
						$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['music_playlist'].
								' WHERE playlist_tags = "%'.$oldTag.'%"';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_db_error($this->dbObj);

						if(!$rs->PO_RecordCount())
							{
								$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_playlist_tags'].
										' WHERE tag_name='.$this->dbObj->Param('tag_name');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($oldTag));
								if (!$rs)
									trigger_db_error($this->dbObj);
							}
					}
			// Add New Tag	`
				foreach($tag_arr as $key=>$value)
					{
						if((strlen($value) < $this->CFG['fieldsize']['music_playlist_tags']['min'])
							or (strlen($value)>$this->CFG['fieldsize']['music_playlist_tags']['max']))
							continue;

						$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['music_playlist_tags'].
								' WHERE tag_name = '.$this->dbObj->Param('tag');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($value));
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						if(!$rs->PO_RecordCount())
							{
								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_playlist_tags'].' SET'.
										' tag_name='.$this->dbObj->Param('music_tag').', result_count=1';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($value));
							    if (!$rs)
								    trigger_db_error($this->dbObj);
							}
					}

					$sql = 'SELECT tag_name FROM '.$this->CFG['db']['tbl']['music_playlist_tags'];

					$stmt = $this->dbObj->Prepare($sql);
					$tag_row = $this->dbObj->Execute($stmt);
					if (!$tag_row)
						trigger_db_error($this->dbObj);

					while($row = $tag_row->FetchRow())
						{
							$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist_tags'].
									' SET result_count = (select count(playlist_id) from '.$this->CFG['db']['tbl']['music_playlist'].
									' where playlist_tags=\''.$row['tag_name'].'\') where tag_name=\''.$row['tag_name'].'\'';

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt);
							if (!$rs)
								trigger_db_error($this->dbObj);
						}
				return true;
			}
		/**
		 * musicHandler::getAlbumDetails()
		 *
		 * @param mixed $music_album_id
		 * @return
		 */
		public function getAlbumDetails($music_album_id)
			{
				$sql = 'SELECT count(music_id) as total_tracks, sum(total_views) as total_views, sum(total_plays) as total_plays FROM '.$this->CFG['db']['tbl']['music'].' AS m LEFT JOIN '.$this->CFG['db']['tbl']['users'].
						' AS u ON m.user_id = u.user_id WHERE m.music_status = \'OK\' AND u.usr_status=\'Ok\' AND m.music_album_id = '.$this->dbObj->Param('music_album_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($music_album_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				return $row = $rs->FetchRow();
			}

		/**
		 * musicHandler::getMusicName()
		 *
		 * @param Integer $text
		 * @return void
		 */
		public function getMusicName($text)
			{
				return getMusicName($text);
			}

		/**
		 * musicHandler::getMusicImageName()
		 *
		 * @param Integer $text
		 * @return void
		 */
		public function getMusicImageName($text, $thumb_name='')
			{
				return getMusicImageName($text, $thumb_name);
			}

		/**
		 * musicHandler::isValidArtistID()
		 *
		 * @return
		 */
		public function isValidArtistID()
			{
				$sql = 'SELECT ma.music_artist_id, ma.artist_name FROM '.$this->CFG['db']['tbl']['music_artist'].' AS ma '.
						'WHERE ma.music_artist_id = '.$this->dbObj->Param('artist_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['artist_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if(empty($row))
					{
						return false;
					}
				else
					{
						$this->fields_arr['artist_id'] = $row['music_artist_id'];
						$this->artist_name = $row['artist_name'];
						$this->artist_id = $row['music_artist_id'];
						return true;
					}
			}

		/**
		 * MusicHandler::isValidArtistMemberID()
		 *
		 * @return
		 */
		public function isValidArtistMemberID()
		{
			$sql = 'SELECT user_id, user_name FROM '.
					$this->CFG['db']['tbl']['users'].
					' WHERE user_id='.$this->dbObj->Param('artist_id').
					' AND music_user_type=\'Artist\'';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['artist_id']));
			if (!$rs)
				trigger_db_error($this->dbObj);
			if($row = $rs->FetchRow())
			{
				$this->artist_name = $row['user_name'];
				$this->artist_id = $row['user_id'];
				return true;
			}
			return false;
		}

		/**
		 * musicHandler::getArtistImageDetail()
		 *
		 * @return array
		 */
		public function getArtistImageDetail($artist_id, $mainImage = '')
			{
				$imageCondition = '';
				if($mainImage == 'Yes')
					$imageCondition = 'main_img = \'1\' AND status = \'Yes\'  AND ';
				$sql = 'SELECT music_artist_image, image_ext, thumb_width, thumb_height  FROM '.$this->CFG['db']['tbl']['music_artist_image'].
						' WHERE '.$imageCondition.'  music_artist_id = '.$this->dbObj->Param('music_artist_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($artist_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $row;
			}

		/**
		 * MusicHandler::getArtistImageMemberDetail()
		 *
		 * @param mixed $artist_id
		 * @param string $mainImage
		 * @return
		 */
		public function getArtistImageMemberDetail($artist_id, $mainImage = '')
		{
			$imageCondition = '';
			if($mainImage == 'Yes')
				$imageCondition = 'main_img = \'1\' AND status = \'Yes\'  AND ';
			$sql = 'SELECT music_artist_member_image, image_ext, thumb_width, thumb_height  FROM '.$this->CFG['db']['tbl']['music_artist_member_image'].
					' WHERE '.$imageCondition.'  music_artist_member_id = '.$this->dbObj->Param('music_artist_member_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($artist_id));
			if (!$rs)
				trigger_db_error($this->dbObj);

			$row = $rs->FetchRow();
			return $row;
		}


		/**
		 * musicHandler::storeArtistImagesTempServer()
		 *
		 * @param mixed $uploadUrl
		 * @param mixed $extern
		 * @return
		 */
		public function storeArtistImagesTempServer($uploadUrl, $extern)
			{
				//GET LARGE IMAGE
				@chmod($uploadUrl.'.'.$extern, 0777);
				if($this->CFG['admin']['musics']['artist_large_name']=='L')
					{
						if($this->CFG['admin']['musics']['artist_large_height'] or $this->CFG['admin']['musics']['artist_large_width'])
							{
								$this->imageObj->resize($this->CFG['admin']['musics']['artist_large_width'], $this->CFG['admin']['musics']['artist_large_height'], '-');
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
				if($this->CFG['admin']['musics']['artist_thumb_name']=='T')
					{
						$this->imageObj->resize($this->CFG['admin']['musics']['artist_thumb_width'], $this->CFG['admin']['musics']['artist_thumb_height'], '-');
						$this->imageObj->output_resized($uploadUrl.'T.'.$extern, strtoupper($extern));
						$image_info = getImageSize($uploadUrl.'T.'.$extern);
						$this->T_WIDTH = $image_info[0];
						$this->T_HEIGHT = $image_info[1];
					}

				//GET SMALL IMAGE
				if($this->CFG['admin']['musics']['artist_small_name']=='S')
					{
						$this->imageObj->resize($this->CFG['admin']['musics']['artist_small_width'], $this->CFG['admin']['musics']['artist_small_height'], '-');
						$this->imageObj->output_resized($uploadUrl.'S.'.$extern, strtoupper($extern));
						$image_info = getImageSize($uploadUrl.'S.'.$extern);
						$this->S_WIDTH = $image_info[0];
						$this->S_HEIGHT = $image_info[1];
					}

				//GET MINI IMAGE
				if($this->CFG['admin']['musics']['artist_mini_name']=='M')
					{
						$this->imageObj->resize($this->CFG['admin']['musics']['artist_mini_width'], $this->CFG['admin']['musics']['artist_mini_height'], '-');
						$this->imageObj->output_resized($uploadUrl.'M.'.$extern, strtoupper($extern));
						$image_info = getImageSize($uploadUrl.'M.'.$extern);
						$this->M_WIDTH = $image_info[0];
						$this->M_HEIGHT = $image_info[1];
					}

				$wname = $this->CFG['admin']['musics']['artist_large_name'].'_WIDTH';
				$hname = $this->CFG['admin']['musics']['artist_large_name'].'_HEIGHT';
				$this->L_WIDTH = $this->$wname;
				$this->L_HEIGHT = $this->$hname;

				$wname = $this->CFG['admin']['musics']['artist_thumb_name'].'_WIDTH';
				$hname = $this->CFG['admin']['musics']['artist_thumb_name'].'_HEIGHT';
				$this->T_WIDTH = $this->$wname;
				$this->T_HEIGHT = $this->$hname;

				$wname = $this->CFG['admin']['musics']['artist_small_name'].'_WIDTH';
				$hname = $this->CFG['admin']['musics']['artist_small_name'].'_HEIGHT';
				$this->S_WIDTH = $this->$wname;
				$this->S_HEIGHT = $this->$hname;

				$wname = $this->CFG['admin']['musics']['artist_mini_name'].'_WIDTH';
				$hname = $this->CFG['admin']['musics']['artist_mini_name'].'_HEIGHT';
				$this->M_WIDTH = $this->$wname;
				$this->M_HEIGHT = $this->$hname;
			}

		/**
		 * musicHandler::storeArtistPromoImagesTempServer()
		 *
		 * @param mixed $uploadUrl
		 * @param mixed $extern
		 * @return
		 */
		public function storeArtistPromoImagesTempServer($uploadUrl, $extern)
		{
			//GET LARGE IMAGE
			@chmod($uploadUrl.'.'.$extern, 0777);
			if($this->CFG['admin']['musics']['artist_promo_large_name']=='L')
			{
				if($this->CFG['admin']['musics']['artist_promo_large_height'] or $this->CFG['admin']['musics']['artist_promo_large_width'])
				{
					$this->imageObj->resize($this->CFG['admin']['musics']['artist_promo_large_width'], $this->CFG['admin']['musics']['artist_promo_large_height'], '-');
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
			if($this->CFG['admin']['musics']['artist_promo_thumb_name']=='T')
			{
				$this->imageObj->resize($this->CFG['admin']['musics']['artist_promo_thumb_width'], $this->CFG['admin']['musics']['artist_promo_thumb_height'], '-');
				$this->imageObj->output_resized($uploadUrl.'T.'.$extern, strtoupper($extern));
				$image_info = getImageSize($uploadUrl.'T.'.$extern);
				$this->T_WIDTH = $image_info[0];
				$this->T_HEIGHT = $image_info[1];
			}

			//GET SMALL IMAGE
			if($this->CFG['admin']['musics']['artist_promo_small_name']=='S')
			{
				$this->imageObj->resize($this->CFG['admin']['musics']['artist_promo_small_width'], $this->CFG['admin']['musics']['artist_promo_small_height'], '-');
				$this->imageObj->output_resized($uploadUrl.'S.'.$extern, strtoupper($extern));
				$image_info = getImageSize($uploadUrl.'S.'.$extern);
				$this->S_WIDTH = $image_info[0];
				$this->S_HEIGHT = $image_info[1];
			}

			//GET MINI IMAGE
			if($this->CFG['admin']['musics']['artist_promo_medium_name']=='M')
			{
				$this->imageObj->resize($this->CFG['admin']['musics']['artist_promo_medium_width'], $this->CFG['admin']['musics']['artist_promo_medium_height'], '-');
				$this->imageObj->output_resized($uploadUrl.'M.'.$extern, strtoupper($extern));
				$image_info = getImageSize($uploadUrl.'M.'.$extern);
				$this->M_WIDTH = $image_info[0];
				$this->M_HEIGHT = $image_info[1];
			}

			$wname = $this->CFG['admin']['musics']['artist_promo_large_name'].'_WIDTH';
			$hname = $this->CFG['admin']['musics']['artist_promo_large_name'].'_HEIGHT';
			$this->L_WIDTH = $this->$wname;
			$this->L_HEIGHT = $this->$hname;

			$wname = $this->CFG['admin']['musics']['artist_promo_thumb_name'].'_WIDTH';
			$hname = $this->CFG['admin']['musics']['artist_promo_thumb_name'].'_HEIGHT';
			$this->T_WIDTH = $this->$wname;
			$this->T_HEIGHT = $this->$hname;

			$wname = $this->CFG['admin']['musics']['artist_promo_small_name'].'_WIDTH';
			$hname = $this->CFG['admin']['musics']['artist_promo_small_name'].'_HEIGHT';
			$this->S_WIDTH = $this->$wname;
			$this->S_HEIGHT = $this->$hname;

			$wname = $this->CFG['admin']['musics']['artist_promo_medium_name'].'_WIDTH';
			$hname = $this->CFG['admin']['musics']['artist_promo_medium_name'].'_HEIGHT';
			$this->M_WIDTH = $this->$wname;
			$this->M_HEIGHT = $this->$hname;
		}

		/**
		 * musicHandler::uploadArtistImageDetail()
		 *
		 * @param mixed $insert_id
		 * @return
		 */
		public function updateArtistImageDetail($insert_id)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_artist_image'].' SET '.
						'large_width='.$this->dbObj->Param('large_width').', large_height='.$this->dbObj->Param('large_height').', '.
						'thumb_width='.$this->dbObj->Param('thumb_width').', thumb_height='.$this->dbObj->Param('thumb_height').', '.
						'small_width='.$this->dbObj->Param('small_width').', small_height='.$this->dbObj->Param('small_height').', '.
						'mini_width='.$this->dbObj->Param('mini_width').', mini_height='.$this->dbObj->Param('mini_height').' '.
						'WHERE music_artist_image = '.$this->dbObj->Param('music_artist_image');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->L_WIDTH, $this->L_HEIGHT, $this->T_WIDTH, $this->T_HEIGHT, $this->S_WIDTH, $this->S_HEIGHT, $this->M_WIDTH, $this->M_HEIGHT, $insert_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				return true;
			}

		/**
		 * musicHandler::isValidMusicID()
		 *
		 * @param mixed $music_id
		 * @param string $page
		 * @return
		 */
		public function isValidMusicID($music_id, $page='')
			{
				$isValidMusicID_arr = array();
				global $smartyObj;

				if($page == 'addlyrics')
					{
						$sql = 'SELECT m.music_id, m.music_title, m.music_artist, m.music_thumb_ext, m.music_server_url, m.thumb_width, m.thumb_height, u.user_id, u.user_name, mfs.file_name FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['users'].' '.
								' AS u ON m.user_id=u.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs ON mfs.music_file_id = m.thumb_name_id WHERE m.music_status = \'Ok\' AND u.usr_status = \'Ok\' AND music_id = '.$this->dbObj->Param('music_id');
					}
				elseif($page == 'morelyrics')
					{
						$sql = 'SELECT m.music_id, m.music_title, m.music_artist, m.music_thumb_ext, m.music_server_url, m.thumb_width, m.thumb_height, u.user_id, u.user_name, mfs.file_name FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['users'].' '.
								' AS u ON m.user_id=u.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs ON mfs.music_file_id = m.thumb_name_id WHERE m.music_status = \'Ok\' AND u.usr_status = \'Ok\' AND music_id = '.$this->dbObj->Param('music_id');
					}
				elseif($page == 'admin')
					{
						$sql = 'SELECT m.music_id, m.music_title, m.music_artist, m.music_thumb_ext, m.music_server_url, m.thumb_width, m.thumb_height, u.user_id, u.user_name, mfs.file_name FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['users'].' '.
								' AS u ON m.user_id=u.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs ON mfs.music_file_id = m.thumb_name_id WHERE m.music_status = \'Ok\' AND u.usr_status = \'Ok\' AND music_id = '.$this->dbObj->Param('music_id');
					}
				elseif($page == 'viewlyrics')
					{
						$sql = 'SELECT m.music_id, m.music_title, m.music_artist, m.music_thumb_ext, m.music_server_url, m.thumb_width, m.thumb_height, u.user_id, u.user_name, mfs.file_name FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['users'].' '.
								' AS u ON m.user_id=u.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs ON mfs.music_file_id = m.thumb_name_id WHERE m.music_status = \'Ok\' AND u.usr_status = \'Ok\' AND music_id = '.$this->dbObj->Param('music_id');
					}
				else
					{
						$sql = 'SELECT m.music_id, m.music_title, m.music_artist, m.music_thumb_ext, m.music_server_url, m.thumb_width, m.thumb_height, u.user_id, u.user_name, mfs.file_name FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['users'].' '.
								' AS u ON m.user_id=u.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs ON mfs.music_file_id = m.thumb_name_id WHERE m.music_status = \'Ok\' AND u.usr_status = \'Ok\' AND m.user_id = \''.$this->CFG['user']['user_id'].'\' AND music_id = '.$this->dbObj->Param('music_id');
					}

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($music_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if(!empty($row))
					{
						$isValidMusicID_arr = $row;
						$this->music_title = $row['music_title'];
						$this->artist_name = $row['music_artist'];
						$this->music_owner_name = $row['user_name'];
						$this->music_owner_id = $row['user_id'];
						$musics_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['musics']['folder'] . '/' .$this->CFG['admin']['musics']['thumbnail_folder'] . '/';
						$isValidMusicID_arr['music_image_src'] = '';
						$isValidMusicID_arr['music_disp'] = '';
						if($isValidMusicID_arr['music_thumb_ext']!='')
							{
								$isValidMusicID_arr['music_image_src'] = $isValidMusicID_arr['music_server_url'].$musics_folder.getMusicImageName($isValidMusicID_arr['music_id'], $isValidMusicID_arr['file_name']).$this->CFG['admin']['musics']['thumb_name'].'.'.$isValidMusicID_arr['music_thumb_ext'];
								$isValidMusicID_arr['music_disp'] = DISP_IMAGE($this->CFG['admin']['musics']['medium_width'], $this->CFG['admin']['musics']['medium_width'], $isValidMusicID_arr['thumb_width'], $isValidMusicID_arr['thumb_height']);
							}
						$isValidMusicID_arr['music_image_path'] = '';
						if(!$this->chkIsAdminSide())
							$isValidMusicID_arr['music_owner_url'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
						else
							$isValidMusicID_arr['music_owner_url'] = $this->CFG['site']['url'].'admin/viewProfile.php?user_id='.$row['user_id'];
						$isValidMusicID_arr['music_title'] = wordWrap_mb_Manual($isValidMusicID_arr['music_title'], $this->CFG['admin']['musics']['viewpage_music_title_length'],strlen($isValidMusicID_arr['music_title']));
						$isValidMusicID_arr['viewmusic_url'] = getUrl('viewmusic', '?music_id='.$isValidMusicID_arr['music_id'].'&title='.$this->changeTitle($isValidMusicID_arr['music_title']), $isValidMusicID_arr['music_id'].'/'.$this->changeTitle($isValidMusicID_arr['music_title']).'/', 'root', 'music');
						$smartyObj->assign('musicInfo', $isValidMusicID_arr);
						return true;
					}
				else
					{
						return false;
					}
			}

		public function chkIsAdminSide()
			{
				$url_arr = explode('/', $_SERVER['REQUEST_URI']);
				if(in_array('admin', $url_arr))
					return true;
				else
					return false;
			}

		/**
		 * musicHandler::deleteLyrics()
		 *
		 * @return
		 */
		public function deleteLyrics()
			{
				$music_lyric_id = $this->fields_arr['music_lyric_id'];

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_lyric'].' '.
						'WHERE music_lyric_id IN ('.$music_lyric_id.')' ;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				return true;
			}

		/**
		 * musicHandler::changeStatusLyrics()
		 *
		 * @param mixed $status
		 * @return
		 */
		public function changeStatusLyrics($status)
			{
				$music_lyric_id = $this->fields_arr['music_lyric_id'];
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_lyric'].' '.
						' SET lyric_status = '.$this->dbObj->Param('lyric_status').' '.
						'WHERE music_lyric_id IN ('.$music_lyric_id.')' ;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($status));
				if (!$rs)
					trigger_db_error($this->dbObj);

				return true;
			}

		/**
		 * musicHandler::setAsBestLyrics()
		 *
		 * @param mixed $status
		 * @return
		 */
		public function setAsBestLyrics()
			{
				$music_lyric_id = $this->fields_arr['music_lyric_id'];
				//REMOVE ALL//
				$this->removeBestLyrics();

				// SET AS BEST LYRICS //
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_lyric'].' '.
						'SET lyric_status = \'Yes\', best_lyric = '.$this->dbObj->Param('lyric_status').' '.
						'WHERE music_id = '.$this->fields_arr['music_id'].' AND music_lyric_id IN ('.$music_lyric_id.')' ;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array('Yes'));
				if (!$rs)
					trigger_db_error($this->dbObj);

				return true;
			}

		/**
		 * musicHandler::removeBestLyrics()
		 *
		 * @param mixed $status
		 * @return
		 */
		public function removeBestLyrics()
			{
				//REMOVE ALL//
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_lyric'].' '.
						'SET best_lyric = '.$this->dbObj->Param('lyric_status').' '.
						'WHERE music_id = '.$this->fields_arr['music_id'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array('No'));
				if (!$rs)
					trigger_db_error($this->dbObj);

			}


		/**
		 * musicHandler::displayCreatePlaylistInterface()
		 *
		 * @param string $page
		 * @return
		 */
		public function displayCreatePlaylistInterface($page='')
			{
				global $smartyObj;
				$sql = 'SELECT playlist_name, playlist_id  FROM '.$this->CFG['db']['tbl']['music_playlist'].' '.
						'WHERE playlist_status = \'Yes\' AND  user_id = '.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$playlistUrl = $this->CFG['site']['music_url'].'viewPlaylist.php?ajax_page=true&amp;page=playlist';
				$smartyObj->assign('playlistUrl', $playlistUrl);
				$playlistInfo = array();
				while($row = $rs->FetchRow())
					{
						$playlistInfo[$row['playlist_id']] = $row['playlist_name'];
					}
				$smartyObj->assign('playlistInfo', $playlistInfo);
			}

		/**
		 * musicHandler::displaySongList()
		 * @param string $playlist_id
		 * @param mixed  $condition(IF $condition == true then we add additional query)
		 * @param string $limit(Number of song we need to show)
		 * @return
		 */
		public function displaySongList($playlist_id='', $condition=false, $limit='')
			{
				global $smartyObj;
				$displaySongList_arr = array();
				$sql = 'SELECT m.music_id, m.music_title, ma.album_title  '.
				 		'FROM '.$this->CFG['db']['tbl']['music_in_playlist'].' as mpl JOIN '.
						 $this->CFG['db']['tbl']['music'].' as m ON mpl.music_id=m.music_id'.', '.
						 $this->CFG['db']['tbl']['users'] . ' as u, '.
						 $this->CFG['db']['tbl']['music_album'].' AS ma '.
						'WHERE ma.music_album_id = m.music_album_id AND '.
						'u.user_id = m.user_id AND m.music_status = \'Ok\' '.
						'AND u.usr_status = \'Ok\' AND mpl.playlist_id = '.$playlist_id;

				if($condition)
					$sql .= ' AND (m.user_id = '.$this->CFG['user']['user_id'].
							' OR m.music_access_type = \'Public\''.
							$this->getAdditionalQuery().') '.$this->getAdultQuery('m.', 'music');

				$sql .= ' ORDER BY mpl.order_id ASC';

				if($limit!='')
					$sql .= ' LIMIT 0, '.$limit;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$displaySongList_arr['record_count'] = 0;
				$displaySongList_arr['row'] = array();
				$inc = 1;
				$this->player_music_id = array();
				while($songDetail = $rs->FetchRow())
					{
						$displaySongList_arr['record_count'] = 1;
						$displaySongList_arr['row'][$inc]['record'] = $songDetail;
						$displaySongList_arr['row'][$inc]['song_status'] = 1;
						if(!$condition and !$this->chkIsAdminSide())
							$displaySongList_arr['row'][$inc]['song_status'] = $this->chkPrivateSong($songDetail['music_id']);
						$displaySongList_arr['row'][$inc]['music_id']=$songDetail['music_id'];
						$this->player_music_id[$inc] = $songDetail['music_id'];
						$displaySongList_arr['row'][$inc]['viewmusic_url'] = getUrl('viewmusic', '?music_id='.$songDetail['music_id'].'&title='.$this->changeTitle($songDetail['music_title']), $songDetail['music_id'].'/'.$this->changeTitle($songDetail['music_title']).'/', '', 'music');
						$displaySongList_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_music_title'] = wordWrap_mb_ManualWithSpace($songDetail['music_title'], $this->CFG['admin']['musics']['member_music_title_length'], $this->CFG['admin']['musics']['member_music_title_total_length']);
						$displaySongList_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_album_title'] = wordWrap_mb_ManualWithSpace($songDetail['album_title'], $this->CFG['admin']['musics']['member_musicalbum_title_length'], $this->CFG['admin']['musics']['member_musicalbum_title_total_length']);
						$inc++;
					}
				$smartyObj->assign('displaySongList_arr', $displaySongList_arr);
				$smartyObj->assign('lastDiv', $$inc=$inc-1);
			//	return true;
			}

	public function deleteMusicActivity($music_id)
	{
		$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_activity'].
				' WHERE content_id='.$this->dbObj->Param('music_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($music_id));
		if (!$rs)
			trigger_db_error($this->dbObj);
	}

	public function deleteMusics($music_id_arr = array(), $user_id)
	{
		$music_id	= implode(',',$music_id_arr);
		$this->deleteMusicPlaylistTag($music_id);
		$this->deleteMusicTag($music_id);
		$this->deleteMusicArtist($music_id);
		$this->deleteMusicActivity($music_id);
		$this->deleteMusicTopChart($music_id);
		$sql        = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET music_status=\'Deleted\'' . ' WHERE music_id IN(' . $music_id . ')' ;
		$stmt     = $this->dbObj->Prepare($sql);
		$rs       = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_db_error($this->dbObj);
		if($affected_rows = $this->dbObj->Affected_Rows())
		 {
				$sql= 'SELECT count(music_encoded_status) AS count FROM  '.$this->CFG['db']['tbl']['music'].
				 ' WHERE music_id IN(' . $music_id  . ') AND music_encoded_status=\'Yes\'';
				$stmt   = $this->dbObj->Prepare($sql);
				$rs     = $this->dbObj->Execute($stmt);
				 if (!$rs)
								trigger_db_error($this->dbObj);
				if($row = $rs->FetchRow())
				 {
					$count = $row['count'];
				 }

				$sql= 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET'.
					' total_musics=total_musics-' . $count . ' WHERE user_id=' . $this->dbObj->Param('user_id').' AND total_musics>0';
				$stmt   = $this->dbObj->Prepare($sql);
				$rs     = $this->dbObj->Execute($stmt, array($user_id));
				 if (!$rs)
								trigger_db_error($this->dbObj);
				// *********Delete records from Music related tables start*****
				$tablename_arr = array('music_comments', 'music_favorite', 'music_viewed', 'music_rating', 'music_lyric');
				for($i=0;$i<sizeof($tablename_arr);$i++)
					{
						$sql  = 'DELETE FROM '.$this->CFG['db']['tbl'][$tablename_arr[$i]].
						' WHERE music_id IN(' . $music_id . ')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs   = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_db_error($this->dbObj);
					}
				// DELETE FLAGGED CONTENTS
				$sql = 'DELETE FROM ' . $this->CFG['db']['tbl']['flagged_contents'] . ' WHERE content_type=\'Music\' AND content_id IN(' . $music_id . ')';
				$stmt   = $this->dbObj->Prepare($sql);
				$rs     = $this->dbObj->Execute($stmt);
				 if (!$rs)
								trigger_db_error($this->dbObj);
				// **********End************
				if ($this->chkIsFeaturedMusic($music_id_arr, $user_id)) {
					$new_video= $this->getNewFeaturedVideo($user_id);
					 $this->setFeatureThisImage($new_video, $user_id);
				}
		}

		return true;

		}

		public function deleteMusicTopChart($music_id)
		{
			$sql = 'SELECT music_id, music_top_chart_id, top_chart_cron_id FROM '.$this->CFG['db']['tbl']['music_song_top_chart'].
				   ' WHERE music_id='.$this->dbObj->Param('music_id').
				   ' AND status=\'Active\'';

				   $stmt   = $this->dbObj->Prepare($sql);
				$rs     = $this->dbObj->Execute($stmt, array($music_id));
				 if (!$rs)
								trigger_db_error($this->dbObj);
				if($row = $rs->FetchRow())
				 {
				$top_chart_id = $row['music_top_chart_id'];
				$top_chart_cron_id = $row['top_chart_cron_id'];

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_song_top_chart'].
					   ' WHERE music_id='.$this->dbObj->Param('music_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($row['music_top_chart_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_song_top_chart'].
					' SET '.
					' current_position = current_position-1'.
					' WHERE music_top_chart_id > '.$row['music_top_chart_id'].
					' AND top_chart_cron_id = '.$row['top_chart_cron_id'].
					' AND status = \'Active\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array());
				if (!$rs)
					trigger_db_error($this->dbObj);
			}
			else
			return false;
		}

		/**
		 * musicHandler::deletePlaylistComments()
		 *
		 * @return
		 */
		public function deletePlaylistComments($ids)
			{
				$comment_id = explode(',', $ids);
				for($inc=0;$inc<count($comment_id);$inc++)
					{
						//FETCH RECORD FOR comment_status //
						$sql = 'SELECT comment_status, playlist_id FROM '.$this->CFG['db']['tbl']['music_playlist_comments'].' WHERE'.
								' playlist_comment_id ='.$comment_id[$inc];

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						$commentDetail = $rs->FetchRow();

						//DELETE COMMENTS//
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_playlist_comments'].' WHERE'.
								' playlist_comment_id ='.$comment_id[$inc];

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						//CONTROL: IF comment_status = yes THEN WE REDUCES THE  total_comments//
						if($commentDetail['comment_status'] == 'Yes')
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist'].' SET total_comments=total_comments- 1'.
										' WHERE playlist_id='.$this->dbObj->Param('playlist_id');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($commentDetail['playlist_id']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);
							}
					}
			}

		/**
		 * musicHandler::deleteMusicComments()
		 *
		 * @return
		 */
		public function deleteMusicComments($ids)
			{
				$comment_id = explode(',', $ids);
				for($inc=0;$inc<count($comment_id);$inc++)
					{
						//FETCH RECORD FOR comment_status //
						$sql = 'SELECT comment_status, music_id FROM '.$this->CFG['db']['tbl']['music_comments'].' WHERE'.
								' music_comment_id ='.$comment_id[$inc];

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						$commentDetail = $rs->FetchRow();

						//DELETE COMMENTS//
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_comments'].' WHERE'.
								' music_comment_id ='.$comment_id[$inc];

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						//CONTROL: IF comment_status = yes THEN WE REDUCES THE  total_comments//
						if($commentDetail['comment_status'] == 'Yes')
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET total_comments=total_comments-1'.
										' WHERE music_id='.$this->dbObj->Param('music_id');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($commentDetail['music_id']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);
							}
					}
			}


	public function chkIsFeaturedMusic($music_id_arr = array(), $user_id)
	 {
		$music_id = implode(',', $music_id_arr);
		$sql   = 'SELECT user_id FROM ' . $this->CFG['db']['tbl']['users'] . ' WHERE user_id=' . $this->dbObj->Param('user_id') . ' AND' . ' icon_type=\'Music\' AND icon_id IN(' . $music_id . ') LIMIT 0,1';
		$stmt  = $this->dbObj->Prepare($sql);
		$rs    = $this->dbObj->Execute($stmt, array($user_id));
		 if (!$rs)
						trigger_db_error($this->dbObj);
		if ($row     = $rs->FetchRow())
		 return true;
		return false;
	}
		 /**
		  * musicHandler::musicCount()
		  *
		  * @param integer $category
		  * @return $total
		  */
		 public function musicCount($category=0)
		 	{
				if($category)
					$condition = 'AND (music_category_id = '.$category.' OR music_sub_category_id = '.$category.') ';

				$sql = 'SELECT count(music_id) as total FROM '.$this->CFG['db']['tbl']['music'].
						' WHERE music_status = \'Ok\' '.$condition;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $row['total'];
			}

		/**
		  * musicHandler::populateSubGenres()
		  * //WE USE THIS FUNCTION INDEX, MUSIC LIST, PLAYLIST pages
		  * param $category_id
		  * @return
		  */
		 public function populateSubGenres($category_id)
			 {
			 	$populateSubGenres = array();
				$populateSubGenres['record_count'] = false;
				//SUBGENRES LIST priority vise or music_category_name//
				if($this->CFG['admin']['musics']['music_category_list_priority'])
					$short_by = 'priority';
				else
					$short_by = 'music_category_name';

				$sql = 'SELECT music_category_id, music_category_name FROM '.$this->CFG['db']['tbl']['music_category'].'  '.
						'WHERE parent_category_id = \''.$category_id.'\' AND music_category_status = \'Yes\' ORDER BY '.$short_by.' ASC LIMIT 0, '.$this->CFG['admin']['musics']['sidebar_genres_num_record'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$populateSubGenres['row'] = array();
				$inc = 0;
				While($genresDetail = $rs->FetchRow())
					{
						$populateSubGenres['record_count'] = true;
						$populateSubGenres['row'][$inc]['wordWrap_mb_ManualWithSpace_music_category_name'] = wordWrap_mb_ManualWithSpace($genresDetail['music_category_name'], $this->CFG['admin']['musics']['sidebar_genres_name_length'], $this->CFG['admin']['musics']['sidebar_genres_name_total_length']);
						$populateSubGenres['row'][$inc]['record'] = $genresDetail;
						$populateSubGenres['row'][$inc]['musicCount'] = $this->musicCount($genresDetail['music_category_id']);
						$populateSubGenres['row'][$inc]['musiclist_url'] = getUrl('musiclist', '?pg=musicnew&cid='.$category_id.'&sid='.$genresDetail['music_category_id'], 'musicnew/?cid='.$category_id.'&sid='.$genresDetail['music_category_id'], '', 'music');
						$inc++;
					}
				return $populateSubGenres;
			 }

		/**
		  * musicHandler::populateGenres()
		  * //WE USE THIS FUNCTION INDEX, MUSIC LIST, PLAYLIST pages
		  * @return
		  */
		 public function populateGenres()
			 {
			 	global $smartyObj;
				$populateGenres_arr = array();
				$populateGenres_arr['record_count'] = false;

				$allowed_pages_array = array('listenMusic.php', 'viewPlaylist.php');
				if(displayBlock($allowed_pages_array))
					return;

				//GENRES LIST priority vise or music_category_name//
				if($this->CFG['admin']['musics']['music_category_list_priority'])
					$short_by = 'priority';
				else
					$short_by = 'music_category_name';

				//$addtional_condition = 'music_category_type!=\'Porn\' AND ';
				$addtional_condition = '';

				$sql = 'SELECT music_category_id, music_category_name FROM '.$this->CFG['db']['tbl']['music_category'].'  '.
						'WHERE '.$addtional_condition.' parent_category_id = \'0\' AND music_category_status = \'Yes\' ORDER BY '.$short_by.' ASC LIMIT 0, '.$this->CFG['admin']['musics']['sidebar_genres_num_record'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$populateGenres_arr['row'] = array();
				$inc = 0;
				While($genresDetail = $rs->FetchRow())
					{
						$populateGenres_arr['record_count'] = true;
						$populateGenres_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_music_category_name'] = wordWrap_mb_ManualWithSpace($genresDetail['music_category_name'], $this->CFG['admin']['musics']['sidebar_genres_name_length'], $this->CFG['admin']['musics']['sidebar_genres_name_total_length']);
						$populateGenres_arr['row'][$inc]['record'] = $genresDetail;
						$populateGenres_arr['row'][$inc]['musicCount'] = $this->musicCount($genresDetail['music_category_id']);
						$populateGenres_arr['row'][$inc]['populateSubGenres'] = $this->populateSubGenres($genresDetail['music_category_id']);
						$populateGenres_arr['row'][$inc]['musiclist_url'] = getUrl('musiclist', '?pg=musicnew&cid='.$genresDetail['music_category_id'], 'musicnew/?cid='.$genresDetail['music_category_id'], '', 'music');
						$inc++;
					}
				$smartyObj->assign('moregenres_url', getUrl('musiccategory', '', '', '', 'music'));
				$smartyObj->assign('populateGenres_arr', $populateGenres_arr);
				setTemplateFolder('general/', 'music');
				$smartyObj->display('populateGenresBlock.tpl');
			 }

		public function setMusicFontSizeInsteadOfSearchCountSidebar($tag_array=array())
			{
				return $this->setFontSizeInsteadOfSearchCountSidebar($tag_array);
			}

		/**
		 * Tag::populateTags()
		 *
		 * @return
		 **/
		public function populateSidebarClouds($module, $tags_table,$limit =20,$returnValue = false)
			{
				global $smartyObj;
				static $tag_clouds_title_displayed = false;
				$return = array();
				$return['resultFound']=false;
				if($module=='artist')
					{
						$allowed_pages_array = array('listenMusic.php', 'viewPlaylist.php', 'myPlaylist.php', 'musicUploadPopUp.php');
						if(displayBlock($allowed_pages_array))
							return;
						if($this->CFG['admin']['tagcloud_based_search_count'])
							{
								$sql = 'SELECT music_artist_id, artist_name as tag_name, search_count FROM '.$this->CFG['db']['tbl'][$tags_table].
									    ' WHERE search_count>0 ORDER BY search_count DESC, result_count DESC, tag_name ASC'.
									    ' LIMIT 0, '.$limit;
							}
						else
							{
								$sql = 'SELECT music_artist_id, artist_name as tag_name, result_count AS search_count FROM'.
										' '.$this->CFG['db']['tbl'][$tags_table].
									    ' WHERE result_count>0 ORDER BY result_count DESC, tag_name ASC'.
									    ' LIMIT 0, '.$limit;
							}

						$moreclouds_url = getUrl('tagsartist', '', '', '', 'music');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						if ($rs->PO_RecordCount()>0)
						    {
						    	$return['resultFound']=true;
								$classes = array('clsAudioTagStyleGrey', 'clsAudioTagStyleGreen');
								$tagClassArray = array();
						        while($row = $rs->FetchRow())
							        {
											$tagArray[$row['tag_name']] = $row['search_count'];
											$tagUrlArray[$row['tag_name']] = $row['music_artist_id'];
											$class = $classes[rand(0, count($classes))%count($classes)];
											$tagClassArray[$row['tag_name']] = $class;
									}
								$tagArray = $this->setMusicFontSizeInsteadOfSearchCountSidebar($tagArray);
								ksort($tagArray);
								$inc=0;
								foreach($tagArray as $tag=>$fontSize)
									{
										$class 	= $tagClassArray[$tag];
										$fontSizeClass= 'style="font-size:'.$fontSize.'px"';
										$return['item'][$inc]['class']=$class;
										$return['item'][$inc]['fontSizeClass']=$fontSizeClass;
										//$return['item'][$inc]['wordWrap_mb_ManualWithSpace_tag']= wordWrap_mb_ManualWithSpace($tag, $this->CFG['admin']['musics']['sidebar_clouds_name_length'], $this->CFG['admin']['musics']['sidebar_clouds_name_total_length']);
										$return['item'][$inc]['name']=$tag;
										$return['item'][$inc]['url']= getUrl('musiclist', '?pg=musicnew&artist_id='.$tagUrlArray[$tag], 'musicnew/?artist_id='.$tagUrlArray[$tag], '', 'music');
										$inc++;
									}
						    }
					}
				elseif($module=='playlist')
					{
						$allowed_pages_array = array('albumSortList.php', 'albumList.php', 'artistPhoto.php', 'artistList.php', 'listenMusic.php', 'viewPlaylist.php', 'viewAlbum.php', 'musicList.php', 'musicUploadPopUp.php', 'myDashboard.php');
						if(displayBlock($allowed_pages_array))
							return;

						if($this->CFG['admin']['tagcloud_based_search_count'])
							{
								$sql = 'SELECT tag_name, search_count FROM '.$this->CFG['db']['tbl'][$tags_table].
									    ' WHERE search_count>0 ORDER BY search_count DESC, result_count DESC, tag_name ASC'.
									    ' LIMIT 0, '.$limit;
							}
						else
							{
								$sql = 'SELECT tag_name, result_count AS search_count FROM'.
										' '.$this->CFG['db']['tbl'][$tags_table].
									    ' WHERE result_count>0 ORDER BY result_count DESC, tag_name ASC'.
									    ' LIMIT 0, '.$limit;
							}

						$searchUrl = getUrl('musicplaylist', '?pg=playlistnew&tags=%s', 'playlistnew/?tags=%s', '', 'music');
						$moreclouds_url = getUrl('tagsplaylist', '', '', '', 'music');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						if ($rs->PO_RecordCount()>0)
						    {
						    	$return['resultFound']=true;
								$classes = array('clsAudioTagStyleGrey', 'clsAudioTagStyleGreen');
								$tagClassArray = array();
						        while($row = $rs->FetchRow())
							        {
											$tagArray[$row['tag_name']] = $row['search_count'];
											$class = $classes[rand(0, count($classes))%count($classes)];
											$tagClassArray[$row['tag_name']] = $class;
									}
								$tagArray = $this->setMusicFontSizeInsteadOfSearchCountSidebar($tagArray);
								ksort($tagArray);
								$inc=0;
								foreach($tagArray as $tag=>$fontSize)
									{
										$url 	= sprintf($searchUrl, $tag);
										$class 	= $tagClassArray[$tag];
										$fontSizeClass= 'style="font-size:'.$fontSize.'px"';
										$return['item'][$inc]['url']=$url;
										$return['item'][$inc]['class']=$class;
										$return['item'][$inc]['fontSizeClass']=$fontSizeClass;
										//$return['item'][$inc]['wordWrap_mb_ManualWithSpace_tag']= wordWrap_mb_ManualWithSpace($tag, $this->CFG['admin']['musics']['sidebar_clouds_name_length'], $this->CFG['admin']['musics']['sidebar_clouds_name_total_length']);
										$return['item'][$inc]['name']=$tag;
										$inc++;
									}
						    }
					}
				else
					{
						$allowed_pages_array = array('listenMusic.php', 'viewPlaylist.php', 'musicUploadPopUp.php');
						if(displayBlock($allowed_pages_array))
							return;

						if($this->CFG['admin']['tagcloud_based_search_count'])
							{
								$sql = 'SELECT tag_name, search_count FROM '.$this->CFG['db']['tbl'][$tags_table].
									    ' WHERE search_count>0 ORDER BY search_count DESC, result_count DESC, tag_name ASC'.
									    ' LIMIT 0, '.$limit;
							}
						else
							{
								$sql = 'SELECT tag_name, result_count AS search_count FROM'.
										' '.$this->CFG['db']['tbl'][$tags_table].
									    ' WHERE result_count>0 ORDER BY result_count DESC, tag_name ASC'.
									    ' LIMIT 0, '.$limit;
							}

						$searchUrl = getUrl('musiclist', '?pg=musicnew&tags=%s', 'musicnew/?tags=%s', '', 'music');
						$moreclouds_url = getUrl('tags', '?pg=music', 'music/', '', 'music');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						if ($rs->PO_RecordCount()>0)
						    {
						    	$return['resultFound']=true;
								$classes = array('clsAudioTagStyleGrey', 'clsAudioTagStyleGreen');
								$tagClassArray = array();
						        while($row = $rs->FetchRow())
							        {
											$tagArray[$row['tag_name']] = $row['search_count'];
											$class = $classes[rand(0, count($classes))%count($classes)];
											$tagClassArray[$row['tag_name']] = $class;
									}
								$tagArray = $this->setMusicFontSizeInsteadOfSearchCountSidebar($tagArray);
								ksort($tagArray);
								$inc=0;
								foreach($tagArray as $tag=>$fontSize)
									{
										$url 	= sprintf($searchUrl, $tag);
										$class 	= $tagClassArray[$tag];
										$fontSizeClass= 'style="font-size:'.$fontSize.'px"';
										$return['item'][$inc]['url']=$url;
										$return['item'][$inc]['class']=$class;
										$return['item'][$inc]['fontSizeClass']=$fontSizeClass;
										//$return['item'][$inc]['wordWrap_mb_ManualWithSpace_tag']= wordWrap_mb_ManualWithSpace($tag, $this->CFG['admin']['musics']['sidebar_clouds_name_length'], $this->CFG['admin']['musics']['sidebar_clouds_name_total_length']);
										$return['item'][$inc]['name']=$tag;
										$inc++;
									}
						    }
					}
				$smartyObj->assign('moreclouds_url', $moreclouds_url);
				$smartyObj->assign('opt', $module);
				$smartyObj->assign('tag_clouds_title_displayed', $tag_clouds_title_displayed);
				$smartyObj->assign('populateCloudsBlock', $return);
				if (!$returnValue) {
					setTemplateFolder('general/', 'music');
					$smartyObj->display('populateCloudsBlock.tpl');
					$tag_clouds_title_displayed = true;
					return true;
				}

			}

		/**
		 * musicHandler::getArtistImageName()
		 *
		 * @param integer $music_artist_id
		 * @return
		 */
		public function getArtistMiniImageName($music_artist_id = 0)
			{
				$sql = 'SELECT mai.mini_height, mai.mini_width, mai.image_ext, mai.music_artist_image FROM '.$this->CFG['db']['tbl']['music_artist_image'].' AS mai
						WHERE mai.main_img =\'1\'AND status = \'Yes\' AND mai.music_artist_id = '.$this->dbObj->Param('music_artist_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($music_artist_id));
			    if (!$rs)
					trigger_db_error($this->dbObj);

				$artist_image_result = $rs->FetchRow();

				return $artist_image_result;
			}

		/**
		 * musicHandler::populatePopularArtist()
		 *
		 * @param int $total_popular_artist - assigned in template file - can change the limit based on template design.
		 *
		 * @return
		 */
		public function populatePopularArtist($total_popular_artist = 0)
			{
				global $smartyObj;
				$populatePopularArtist_arr = array();
				$populatePopularArtist_arr['record_count'] = false;
				$populatePopularArtist_arr['row'] = array();

				if($total_popular_artist)
				{
					$limit = $total_popular_artist;
				}
				else
				{
					if(isMember())
					{
					 	$limit=$this->CFG['admin']['musics']['sidebar_popularartist_num_record'];
					}
					else
					{
					  $limit=$this->CFG['admin']['musics']['sidebar_non_member_popularartist_num_record'];
					}
				}
				//HERE WE REMOVE "AND music_access_type = \'Public\' for artist list" for private song total plays//
				$sql = 'SELECT ma.artist_name, ma.music_artist_id, count( m.music_id ) AS total_songs, sum( total_plays ) AS sum_plays '.
						'FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS ma ON FIND_IN_SET( ma.music_artist_id, m.music_artist ) '.
						', '.$this->CFG['db']['tbl']['users'].' AS u '.' WHERE u.user_id = m.user_id AND ma.music_artist_id != 1 '.
						'AND u.usr_status = \'Ok\' AND m.music_status = \'Ok\' GROUP BY ma.music_artist_id ORDER BY sum_plays DESC LIMIT 0, '.$limit;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
					trigger_db_error($this->dbObj);

				$inc = 0;
				$artist_image_path = $this->CFG['site']['url'].$this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['music_folder'].'/'.$this->CFG['admin']['musics']['artist_image_folder'].'/';
				while($popular_artist_detail = $rs->FetchRow())
		        	{
				    	$populatePopularArtist_arr['record_count'] = true;
				    	$populatePopularArtist_arr['row'][$inc]['record'] = $popular_artist_detail;
						$populatePopularArtist_arr['row'][$inc]['viewartist_url'] = getUrl('musiclist', '?pg=musicnew&artist_id='.$popular_artist_detail['music_artist_id'], 'musicnew/?artist_id='.$popular_artist_detail['music_artist_id'], '', 'music');
						$music_artist_image = $this->getArtistMiniImageName($popular_artist_detail['music_artist_id']);
						if($music_artist_image['music_artist_image'] != '')
							{
								$populatePopularArtist_arr['row'][$inc]['music_path'] = $artist_image_path.$music_artist_image['music_artist_image'].$this->CFG['admin']['musics']['artist_mini_name'].'.'.$music_artist_image['image_ext'];
								$populatePopularArtist_arr['row'][$inc]['mini_width'] = $music_artist_image['mini_width'];
								$populatePopularArtist_arr['row'][$inc]['mini_height'] = $music_artist_image['mini_height'];
							}
						else
							{
								$populatePopularArtist_arr['row'][$inc]['music_path'] = '';
							}
						$inc++;
				    }
				$smartyObj->assign('moreartist_url', getUrl('artistlist', '', '', '', 'music'));
				$smartyObj->assign('populatePopularArtist_arr', $populatePopularArtist_arr);
				setTemplateFolder('general/', 'music');
				$smartyObj->display('populatePopularArtist.tpl');
			}

		/**
		 * MusicHandler::populatePopularMemberArtist()
		 *
		 * @param int $total_popular_artist - assigned in template file - can change the limit based on template design.
		 *
		 * @return
		 */
		public function populatePopularMemberArtist($total_popular_artist = 0)
		{
			global $smartyObj;
			$populatePopularArtist_arr = array();
			$populatePopularArtist_arr['record_count'] = false;
			$populatePopularArtist_arr['row'] = array();

			if($total_popular_artist)
			{
				$limit = $total_popular_artist;
			}
			else
			{
				if(isMember())
				{
				 	$limit=$this->CFG['admin']['musics']['sidebar_popularartist_num_record'];
				}
				else
				{
				  $limit=$this->CFG['admin']['musics']['sidebar_non_member_popularartist_num_record'];
				}
			}
			//HERE WE REMOVE "AND music_access_type = \'Public\' for artist list" for private song total plays//
			$sql = ' SELECT u.user_name as artist_name, u.user_id as music_artist_id, count(m.music_id) as total_songs, sum( total_plays ) AS sum_plays, '.
					' u.sex, u.image_ext, u.icon_type, u.icon_id'.
					' FROM '.$this->CFG['db']['tbl']['music'].' as m LEFT JOIN '.$this->CFG['db']['tbl']['users'].' as u '.
					' ON u.user_id = m.user_id WHERE u.usr_status=\'Ok\' AND m.music_status = \'Ok\' AND u.music_user_type=\'Artist\''.
					' GROUP BY u.user_id ORDER BY sum_plays DESC LIMIT 0, '.$limit;
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
				trigger_db_error($this->dbObj);

			$inc = 0;
			$artist_image_path = $this->CFG['site']['url'].$this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['music_folder'].'/'.$this->CFG['admin']['musics']['artist_image_folder'].'/';
			while($popular_artist_detail = $rs->FetchRow())
	        	{
			    	$populatePopularArtist_arr['record_count'] = true;
			    	$populatePopularArtist_arr['row'][$inc]['record'] = $popular_artist_detail;
					$populatePopularArtist_arr['row'][$inc]['viewartist_url'] = getUrl('musiclist', '?pg=musicnew&user_id='.$popular_artist_detail['music_artist_id'], 'musicnew/?user_id='.$popular_artist_detail['music_artist_id'], '', 'music');
					$music_artist_image = getMemberAvatarDetails($popular_artist_detail['music_artist_id']);
					if($music_artist_image != '')
						{
							$populatePopularArtist_arr['row'][$inc]['music_path'] = $music_artist_image['s_url'];
							$populatePopularArtist_arr['row'][$inc]['mini_width'] = $music_artist_image['s_width'];
							$populatePopularArtist_arr['row'][$inc]['mini_height'] = $music_artist_image['s_height'];
						}
					else
						{
							$populatePopularArtist_arr['row'][$inc]['music_path'] = '';
						}
					$inc++;
			    }
			$smartyObj->assign('moreartist_url', getUrl('artistmemberslist', '', '', '', 'music'));
			$smartyObj->assign('populatePopularArtist_arr', $populatePopularArtist_arr);
			setTemplateFolder('general/', 'music');
			$smartyObj->display('populatePopularArtist.tpl');
		}
	/**
	 * musicHandler::populateAudioTracker()
	 *
	 * @return
	 */
	public function populateAudioTracker($return_only_music_id=false)
		{
			if(isMember())
				{
					global $smartyObj;
					$populateAudioTracker_arr = array();
					$populateAudioTracker_arr['record_count'] = false;
					$populateAudioTracker_arr['row'] = array();
					$sql = 'SELECT m.music_id, m.music_title,m.user_id, ma.album_title, TIMEDIFF(NOW(), max(ml.last_listened)) AS last_viewed, ma.music_album_id
							FROM '.$this->CFG['db']['tbl']['music'].' AS m, '.$this->CFG['db']['tbl']['music_album'].' AS ma, '.
							$this->CFG['db']['tbl']['music_listened'].' AS ml, '.$this->CFG['db']['tbl']['users'].' AS u '.
							'WHERE u.user_id = ml.music_owner_id AND u.usr_status = \'OK\' AND m.music_status = \'Ok\' AND
							m.music_album_id = ma.music_album_id	AND m.music_id = ml.music_id AND ml.user_id = '.
							$this->dbObj->Param('user_id').$this->getAdultQuery('m.', 'music').' AND (ml.music_owner_id = '.$this->CFG['user']['user_id'].'
							 OR '.'m.music_access_type = \'Public\''.$this->getAdditionalQuery().')GROUP BY ml.music_id ORDER BY last_viewed LIMIT 0 , '.
							 $this->CFG['admin']['musics']['sidebar_audiotracker_num_record'];
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				    if (!$rs)
						trigger_db_error($this->dbObj);

					$inc = 0;
					while($audio_tracker_detail = $rs->FetchRow())
				    	{
				    		if($return_only_music_id)
				    			{
									$this->player_music_id[$this->player_music_id_key] = $audio_tracker_detail['music_id'];
									$_SESSION['index_player_music_id'][$this->player_music_id_key] = $audio_tracker_detail['music_id'];
									$this->player_music_id_key++;
								}
							else
								{
						    		$populateAudioTracker_arr['record_count'] = true;
						    		$populateAudioTracker_arr['row'][$inc]['record'] = $audio_tracker_detail;
						    		$populateAudioTracker_arr['row'][$inc]['sale'] = false;
						    		if($pay_details = checkMusicForSale($audio_tracker_detail['music_id']))
						    		{
						    			$populateAudioTracker_arr['row'][$inc]['for_sale']= false;
						    			$populateAudioTracker_arr['row'][$inc]['album_for_sale']= false;
										$populateAudioTracker_arr['row'][$inc]['sale'] = true;
										if($pay_details['album_for_sale']=='Yes'
											AND $pay_details['album_access_type']=='Private'
											AND $pay_details['album_price']>0)
										{
										   $populateAudioTracker_arr['row'][$inc]['album_for_sale'] = true;
	                                       $music_price = strstr($pay_details['album_price'], '.');
	                                       if(!$music_price)
	                                       {
	                                          $pay_details['album_price']=$pay_details['album_price'].'.00';
										   }
										$populateAudioTracker_arr['row'][$inc]['music_price'] = ' <span>'.$this->CFG['currency'].$pay_details['album_price'];
										}
										else if($pay_details['for_sale']=='Yes' AND $pay_details['music_price']>0)
										{
										  $populateAudioTracker_arr['row'][$inc]['for_sale'] = true;
										  $music_price = strstr($pay_details['music_price'], '.');
	                                       if(!$music_price)
	                                       {
	                                          $pay_details['music_price']=$pay_details['music_price'].'.00';
										   }
											$populateAudioTracker_arr['row'][$inc]['music_price'] = ' <span>'.$this->CFG['currency'].$pay_details['music_price'];
										}
									}
						    		$populateAudioTracker_arr['row'][$inc]['getTimeDiffernceFormat_last_viewed'] = getTimeDiffernceFormat($audio_tracker_detail['last_viewed']);
						    		$populateAudioTracker_arr['row'][$inc]['viewmusic_url'] = getUrl('viewmusic', '?music_id='.$audio_tracker_detail['music_id'].'&title='.$this->changeTitle($audio_tracker_detail['music_title']), $audio_tracker_detail['music_id'].'/'.$this->changeTitle($audio_tracker_detail['music_title']).'/', '', 'music');
						    		$populateAudioTracker_arr['row'][$inc]['viewalbum_url'] = getUrl('viewalbum', '?album_id='.$audio_tracker_detail['music_album_id'].'&title='.$this->changeTitle($audio_tracker_detail['album_title']), $audio_tracker_detail['music_album_id'].'/'.$this->changeTitle($audio_tracker_detail['album_title']).'/', '', 'music');
						    		$populateAudioTracker_arr['row'][$inc]['player_music_id_key'] = $this->player_music_id_key;
								}
							$inc++;
						}
					if(!$return_only_music_id)
						{
							$smartyObj->assign('audiotracker_url', getUrl('mymusictracker', '', '', '', 'music'));
							$smartyObj->assign('populateAudioTracker_arr', $populateAudioTracker_arr);
							setTemplateFolder('general/', 'music');
							$smartyObj->display('populateAudioTracker.tpl');
						}
				}
		}

		/**
		 * musicHandler::populateMemberDetail()
		 * // IF THE FUNCTION RUN WE NEED TO INCLUDE class_RayzzHandler.lib.php FILE//
		 * @return
		 */
		public function populateMemberDetail($side_bar_option)
			{
				global $smartyObj;
				if($side_bar_option == 'music')
					$allowed_pages_array = array('listenMusic.php', 'viewPlaylist.php');
				elseif($side_bar_option == 'playlist')
					$allowed_pages_array = array('listenMusic.php', 'viewPlaylist.php', 'musicUploadPopUp.php');
				if(displayBlock($allowed_pages_array))
					return;

				$this->_currentPage = strtolower($this->CFG['html']['current_script_name']);
				$this->_navigationArr['left_'.$this->_currentPage] = $this->_clsActiveLink;
				$pg = (isset($_REQUEST['pg']))?$_REQUEST['pg']:'';
				$block = (isset($_REQUEST['block']))?$_REQUEST['block']:'';
				if($block != '')
					{
						$page = $this->_currentPage.'_'.strtolower($block);
						$this->_navigationArr['left_'.$page] = $this->_clsActiveLink;
					}
				$flag = false;
				if($pg != '')
					{
						$flag = true;
						$this->_navigationArr['left_'.$this->_currentPage] = $this->_clsInActiveLink;
						$page = $this->_currentPage.'_'.strtolower($pg);
						$this->_navigationArr['left_'.$page] = $this->_clsActiveLink;
					}

				$populateMemberDetail_arr = array();

				$populateMemberDetail_arr['memberProfileUrl'] = getMemberProfileUrl($this->CFG['user']['user_id'], $this->CFG['user']['user_name']);
				$populateMemberDetail_arr['artist_member_url'] = getUrl('manageartistphoto', '?artist_id='
					.$this->CFG['user']['user_id'].'&name='.$this->changeTitle($this->CFG['user']['user_name']), $this->CFG['user']['user_id'].'/'
					.$this->changeTitle($this->CFG['user']['user_name']).'/', 'members', 'music');
				$populateMemberDetail_arr['name'] = $this->CFG['user']['user_name'];
				$populateMemberDetail_arr['profileIcon'] = getMemberAvatarDetails($this->CFG['user']['user_id']);
				//TOTAL MUSIC //
				$sql = 'SELECT COUNT( m.music_id ) AS total_music '.
					'FROM '.$this->CFG['db']['tbl']['music'].' AS m '.
					'WHERE music_status=\'Ok\' AND user_id = '.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
			    if (!$rs)
					trigger_db_error($this->dbObj);

				$result_set = $rs->FetchRow();
				$populateMemberDetail_arr['total_muisic'] = $result_set['total_music'];
				$smartyObj->assign('populateMemberDetail_arr', $populateMemberDetail_arr);
				$smartyObj->assign('opt', $side_bar_option);
				$smartyObj->assign('flag', $flag);
				setTemplateFolder('general/', 'music');
				$smartyObj->display('populateMemberBlock.tpl');
			}

		/**
		 * musicHandler::populateCurrentlyPlayingSongsDetail()
		 *
		 * @return
		 */
		public function populateCurrentlyPlayingSongsDetail($recent_view_check=false)
			{
				$populateCurrentlyPlayingSongsDetail_arr =array();
				$add_field = '';
				$add_con = ' AND ma.music_album_id=m.music_album_id AND u.user_id = m.user_id AND u.usr_status=\'Ok\' ';
				$add_order = ' ORDER BY m.last_view_date DESC ';
				$sql_condition = ' m.music_status=\'Ok\''.
								 ' AND (m.user_id = '.$this->CFG['user']['user_id'].
								 ' OR m.music_access_type = \'Public\''.$this->getAdditionalQuery('m.', 'music').')'.$add_con.$this->getAdultQuery('m.', 'music');

				$minutes_seconds=($this->CFG['admin']['musics']['recent_view_musics_seconds'])?$this->CFG['admin']['musics']['recent_view_musics_seconds']:60;

				if($recent_view_check)
					$sql_condition .= ' AND  last_view_date >= DATE_SUB(now(), INTERVAL '.$minutes_seconds.' SECOND) ';

				$populateCurrentlyPlayingSongsDetail_arr['row'] = array();

				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['music'].
						' AS m JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs '.
						'ON mfs.music_file_id = m.thumb_name_id, '.
						$this->CFG['db']['tbl']['music_album'].' AS ma, '.
						$this->CFG['db']['tbl']['users'].' AS u WHERE '.
						$sql_condition.$add_order.' LIMIT 1, '.
						$this->CFG['admin']['musics']['index_page_music_list_total_thumbnail'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
					trigger_db_error($this->dbObj);

				//$populateCurrentlyPlayingSongsDetail_arr['record_count'] = false;
				//if($rs->PO_RecordCount() >= $this->CFG['admin']['musics']['recent_musics_play_list_counts'])
				$populateCurrentlyPlayingSongsDetail_arr['record_count'] = $rs->PO_RecordCount();

			    return $populateCurrentlyPlayingSongsDetail_arr;
			}

		/**
		 * musicHandler::getAlbumImageName()
		 * // GET ALBUM IMAGE FROM TOP RATED MUSIC \\
		 * @param mixed $album_id
		 * @return
		 */
		public function getAlbumImageName($album_id)
			{
				$sql = 'SELECT m.large_width, m.large_height, m.thumb_width, m.thumb_height, m.medium_width, m.medium_height, m.music_id, m.music_server_url, m.music_thumb_ext, mfs.file_name'.' '.
						'FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs ON mfs.music_file_id = m.thumb_name_id, '
						.$this->CFG['db']['tbl']['music_album'].' AS ma, '.$this->CFG['db']['tbl']['users'].' AS u '.
						'WHERE u.user_id = m.user_id AND m.music_album_id = ma.music_album_id AND u.usr_status = \'Ok\'
						AND m.music_status = \'Ok\' AND m.music_thumb_ext <> " " AND ma.music_album_id = \''.$album_id.'\''.$this->getAdultQuery('m.', 'music').' '.
						'AND (m.user_id = '.$this->CFG['user']['user_id'].' OR  m.music_access_type = \'Public\''.$this->getAdditionalQuery().') LIMIT 0 , 1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
					trigger_db_error($this->dbObj);

				$album_image = $rs->FetchRow();
				return $album_image;

			}

		/**
		 * musicHandler::populateMusicRatingImages()
		 * // GET Populate Rating images for Music List \\
		 * @param mixed
		 * @return
		 */
		public function populateMusicRatingImages($rating = 0,$imagePrefix='',$condition='',$url='')
			{

				$rating = round($rating,0);
				global $smartyObj;

				if($imagePrefix == 'player')
				{
					$added_image_name = '1';
				}
				else
				{
					$added_image_name = '';
				}

				$populateRatingImages_arr = array();
				$populateRatingImages_arr['rating'] = $rating;
				$populateRatingImages_arr['condition'] = $condition;
				$populateRatingImages_arr['url'] = $url;
				$populateRatingImages_arr['rating_total'] = $this->CFG['admin']['total_rating'];
				if($populateRatingImages_arr['rating']>$populateRatingImages_arr['rating_total'])
					$populateRatingImages_arr['rating'] = $populateRatingImages_arr['rating_total'];
				$populateRatingImages_arr['bulet_star'] = $this->CFG['site']['music_url'].'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-audioratehover' . $added_image_name . '.gif';
				$populateRatingImages_arr['bulet_star_empty'] = $this->CFG['site']['music_url'].'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-audiorate' . $added_image_name . '.gif';
				$smartyObj->assign('populateRatingImages_arr', $populateRatingImages_arr);
				setTemplateFolder('general/', 'music');
				$smartyObj->display('populateMusicRatingImages.tpl');
			}


		/**
		 * MusicHandler::getArtistLink()
		 *
		 * @param mixed $artist_ids
		 * @param mixed $echo_link
		 * @param integer $limit(It is used to number artisr name we display IF $limit=0 then display all artist name)
		 * @parm search_word(It is used to when we search the music are album list we are usinfg this parameter otherewise it is empty).
		 * @return
		 */
		public function getArtistLink($artist_ids, $echo_link=false, $limit=0, $search_word='')
			{
				$artist_id_array = explode(',', $artist_ids);
				$total_artist = count($artist_id_array);
				$inc = 1;
				$return_full_str = '';
				$jnc = 1;
				foreach($artist_id_array as $artist_id)
					{
						if(($limit>0 and $limit>=$jnc) or $limit==0)
							{
								$sql = 'SELECT artist_name '.
										' FROM '.$this->CFG['db']['tbl']['music_artist'].
										' WHERE music_artist_id = '.$this->dbObj->Param('artist_id');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($artist_id));
							    if (!$rs)
								    trigger_db_error($this->dbObj);

								if($rs->PO_RecordCount())
									{
										$row = $rs->FetchRow();
										$wordWrap_mb_ManualWithSpace_artist_name = wordWrap_mb_ManualWithSpace($row['artist_name'], $this->CFG['admin']['musics']['member_music_artist_name_length'], $this->CFG['admin']['musics']['member_music_artiat_name_total_length']);
										// The following code is used for highlight the search music artist. by yogaraja_090at09.
										if(!empty($search_word))
											$wordWrap_mb_ManualWithSpace_artist_name = highlightWords($wordWrap_mb_ManualWithSpace_artist_name, $search_word);
										$return_str = '<a href="'.getUrl('musiclist', '?pg=musicnew&artist_id='.trim($artist_id), 'musicnew/?artist_id='.trim($artist_id), 'root', 'music').'" title="'.$row['artist_name'].'" class="clsLink">'.$wordWrap_mb_ManualWithSpace_artist_name.'</a>';
										$return_full_str .= $return_str;
										if(!$echo_link)
											echo $return_str;
										$coma = '';
										if($limit>=1)
											{
												if($limit > $inc and $limit>1)
													$coma = ', ';
											}
										else
											{
												if($total_artist > $inc)
													$coma = ', ';
											}
										if(!$echo_link)
											echo $coma;
										$return_full_str .=	$coma;
										$inc++;
									}
						}$jnc++;
					}
				return $return_full_str;
			}

		/**
		 * musicHandler::getArtistsNames()
		 *
		 * @param string $artist_id comma separated
		 * @return string (comma separated artist names)
		 */
		public function getArtistsNames($artist_id)
			{
				$artist_id_arr = explode(',', $artist_id);
				$artist_name_arr = array();
				foreach($artist_id_arr as $artist_id)
					{
						$sql = 'SELECT artist_name '.
								' FROM '.$this->CFG['db']['tbl']['music_artist'].
								' WHERE music_artist_id = '.$this->dbObj->Param('artist_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($artist_id));
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						if(!$rs->PO_RecordCount())
							return false;

						if($row = $rs->FetchRow())
							{
								$artist_name_arr[] = $row['artist_name'];
							}
					}
				if(!empty($artist_name_arr))
					return implode(',', $artist_name_arr);
				return '';
			}


		/**
		 * MusicHandler::getMusicCategoryName()
		 *
		 * @param string $categoryId
		 * @access public
		 * @return string (return category name)
		 */
		public function getMusicCategoryName($categoryId = ''){
			$sql = 'SELECT music_category_name FROM '.$this->CFG['db']['tbl']['music_category'].' WHERE music_category_id = '.$this->dbObj->Param('music_category_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($categoryId));
		    if (!$rs)
			    trigger_db_error($this->dbObj);
			if($rs->PO_RecordCount()){
				if($row = $rs->FetchRow())
					return $row['music_category_name'];
			}
			return '';
		}

		/**
		 * musicHandler::getArtistIdFromName()
		 *
		 * @param string $artist_name
		 * @return string
		 */
		public function getArtistIdFromName($artist_name)
			{
				$sql = 'SELECT music_artist_id FROM '.$this->CFG['db']['tbl']['music_artist'].
						' WHERE artist_name='.$this->dbObj->Param('music_artist');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($artist_name));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						if($row = $rs->FetchRow())
							{
								return $row['music_artist_id'];
							}
					}
				return false;
			}

		/**
		 * musicHandler::getTagsLink()
		 *
		 * @param mixed $tag_srting, $tagoption
		 * @return
		 */
		public function getTagsLink($tag_srting, $tagoption='music')
			{
				global $smartyObj;
				$getTagsLink_arr = array();
				$tag_array = explode(' ', $tag_srting);
				$inc = 1;
				foreach($tag_array as $tag_name)
					{
						$getTagsLink_arr[$inc]['wordWrap_mb_ManualWithSpace_tag_name'] = wordWrap_mb_ManualWithSpace($tag_name, $this->CFG['admin']['musics']['member_music_tags_name_length'], $this->CFG['admin']['musics']['member_music_tags_name_total_length']);
						$getTagsLink_arr[$inc]['title_tag_name'] = $tag_name;
						if($tagoption == 'music')
							{
								$getTagsLink_arr[$inc]['tag_url'] = getUrl('musiclist', '?pg=musicnew&tags='.$tag_name, 'musicnew/?tags='.$tag_name, '', 'music');
							}
						elseif($tagoption == 'playlist')
							{
								$getTagsLink_arr[$inc]['tag_url'] = getUrl('musicplaylist', '?pg=playlistnew&tags='.$tag_name, 'playlistnew/?tags='.$tag_name, '', 'music');
							}
					}
				$smartyObj->assign('getTagsLink_arr', $getTagsLink_arr);
				setTemplateFolder('general/', 'music');
				$smartyObj->display('populateTagsLinks.tpl');
			}
				/**
		 * musicHandler::deletePlaylistMusics()
		 * // GET Populate Rating images for Music List \\
		 * @param mixed
		 * @return
		 */
		public function deletePlaylistMusic($music_id)
		{

			$sql ='SELECT playlist_id FROM '.$this->CFG['db']['tbl']['music_playlist'].' WHERE thumb_music_id='.$this->dbObj->Param('music_id').'AND playlist_id='.$this->dbObj->Param('playlist_id') ;
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($music_id, $this->fields_arr['playlist_id']));
			if (!$rs)
				trigger_db_error($this->dbObj);
			$row = $rs->FetchRow();
			$nofiy_msg = 1;
			if($row['playlist_id'])
				{
					$nofiy_msg = 2;
					$sql = 'SELECT v.music_id '.
							'FROM '.$this->CFG['db']['tbl']['music_in_playlist'].' as v, '.$this->CFG['db']['tbl']['music_playlist'].' as vp '.
							'WHERE v.music_id !='.$this->dbObj->Param('music_id').' '.
							'AND vp.playlist_id = v.playlist_id AND vp.playlist_id ='.$this->dbObj->Param('playlist_id').' '.
							'ORDER BY order_id DESC LIMIT 0 , 1';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($music_id, $this->fields_arr['playlist_id']));
					if (!$rs)
						trigger_db_error($this->dbObj);

					$rowSet = $rs->FetchRow();
					$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist'].' set thumb_music_id = '.$this->dbObj->Param('music_id').' WHERE playlist_id = '.$this->dbObj->Param('playlist_id').'';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($rowSet['music_id'], $this->fields_arr['playlist_id']));
					if (!$rs)
						trigger_db_error($this->dbObj);
				}

			$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_in_playlist'].' WHERE music_id='.$this->dbObj->Param('music_id').' AND playlist_id='.$this->dbObj->Param('playlist_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($music_id, $this->fields_arr['playlist_id']));
			if (!$rs)
				trigger_db_error($this->dbObj);

			if($this->dbObj->Affected_Rows())
				{
					$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist'].' SET total_tracks=total_tracks-1 WHERE playlist_id='.$this->dbObj->Param('playlist_id');

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist_id']));
					if (!$rs)
						trigger_db_error($this->dbObj);
				}
		}

		/**
		 * musicHandler::deleteMusicTag()
		 *
		 * @param mixed $music_id
		 * @acces public
		 */
		public function deleteMusicTag($music_id){
			// DELETE TAGS
			$sql='SELECT music_tags FROM '.$this->CFG['db']['tbl']['music'].' WHERE music_id IN('.$music_id.')';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
			    trigger_db_error($this->dbObj);

			while($tag_row = $rs->FetchRow()){
		    		$tag=explode(' ',$tag_row['music_tags']);
		    		for($i=0;$i<count($tag);$i++){
						 $sql='SELECT music_id FROM '.$this->CFG['db']['tbl']['music'].
								 	  ' WHERE concat( \' \', music_tags, \' \' ) LIKE "% '.$tag[$i].' %" AND music_id NOT IN('.$music_id.')'.' AND music_status!=\'Deleted\'';
						 $stmt = $this->dbObj->Prepare($sql);
					     $rs_tag = $this->dbObj->Execute($stmt);
						 if (!$rs_tag)
							    trigger_db_error($this->dbObj);
						 if(!$row = $rs_tag->FetchRow()){
						 	$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_tags'].
							' WHERE tag_name=\''.$tag[$i].'\'';
							$stmt = $this->dbObj->Prepare($sql);
							$rs_delete = $this->dbObj->Execute($stmt);
							    if (!$rs_delete)
								    trigger_db_error($this->dbObj);
						 }
					 }
				}
			// DELETE TAG END
		}

		/**
		 * musicHandler::deleteMusicArtist()
		 *
		 * @param mixed $music_id
		 * @acces public
		 */
		public function deleteMusicArtist($music_id){
			// DELETE Artist
			$sql='SELECT music_artist FROM '.$this->CFG['db']['tbl']['music'].' WHERE music_id IN('.$music_id.')';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
			    trigger_db_error($this->dbObj);

			while($artist_row = $rs->FetchRow()){
		    		$artist=explode(',',$artist_row['music_artist']);
		    		for($i=0;$i<count($artist);$i++){//DO NOT DELETE DEFAULT ARTIST ID (artist_id: 1 artist_name: NotSpecified)//
						 $sql='SELECT music_id FROM '.$this->CFG['db']['tbl']['music'].
							  ' WHERE  FIND_IN_SET('.$artist[$i].', music_artist) AND music_id NOT IN('.$music_id.')'.'  AND music_status!=\'Deleted\'';
						 $stmt = $this->dbObj->Prepare($sql);
					     $rs_artist = $this->dbObj->Execute($stmt);
						 if (!$rs_artist)
							    trigger_db_error($this->dbObj);
						 if(!$row = $rs_artist->FetchRow()){
						 	$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_artist'].
							' WHERE music_artist_id=\''.$artist[$i].'\' AND music_artist_id!=\'1\'';
							$stmt = $this->dbObj->Prepare($sql);
							$rs_delete = $this->dbObj->Execute($stmt);
							    if (!$rs_delete)
								    trigger_db_error($this->dbObj);
						 }
					 }
				}
			// DELETE Artist END
		}

	 	/**
	 	 * MusicHandler::myMusicListDelete()
	 	 *
	 	 * @param array $music_id_arr
	 	 * @param mixed $user_id
	 	 * @return
	 	 */
	 	public function myMusicListDelete($music_id_arr = array(), $user_id)
	         {
				$music_id	= implode(',',$music_id_arr);
				$this->deleteMusicPlaylistTag($music_id);
				$this->deleteMusicTag($music_id);
				$this->deleteMusicArtist($music_id);
				$sql        = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET music_status=\'Deleted\'' . ' WHERE music_id IN(' . $music_id . ')' ;
				$stmt     = $this->dbObj->Prepare($sql);
				$rs       = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);
				if($affected_rows = $this->dbObj->Affected_Rows())
				 {
						$sql= 'SELECT count(music_encoded_status) AS count FROM  '.$this->CFG['db']['tbl']['music'].
						 ' WHERE music_id IN(' . $music_id  . ') AND music_encoded_status=\'Yes\'';
						$stmt   = $this->dbObj->Prepare($sql);
						$rs     = $this->dbObj->Execute($stmt);
						 if (!$rs)
										trigger_db_error($this->dbObj);
						if($row = $rs->FetchRow())
						 {
							$count = $row['count'];
						 }

						$sql= 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET'.
							' total_musics=total_musics-' . $count . ' WHERE user_id=' . $this->dbObj->Param('user_id').' AND total_musics>0';
						$stmt   = $this->dbObj->Prepare($sql);
						$rs     = $this->dbObj->Execute($stmt, array($user_id));
						 if (!$rs)
										trigger_db_error($this->dbObj);
						$tablename_arr = array('music_comments', 'music_favorite', 'music_viewed', 'music_rating');
						for($i=0;$i<sizeof($tablename_arr);$i++)
						 {
										$sql  = 'DELETE FROM '.$this->CFG['db']['tbl'][$tablename_arr[$i]].
										 ' WHERE music_id IN(' . $music_id . ')';
										$stmt = $this->dbObj->Prepare($sql);
										$rs   = $this->dbObj->Execute($stmt);
										 if (!$rs)
											trigger_db_error($this->dbObj);
						}
						$sql = 'DELETE FROM ' . $this->CFG['db']['tbl']['flagged_contents'] . ' WHERE content_type=\'Music\' AND content_id IN(' . $music_id . ')';
						$stmt   = $this->dbObj->Prepare($sql);
						$rs     = $this->dbObj->Execute($stmt);
						 if (!$rs)
										trigger_db_error($this->dbObj);
						$sql = 'DELETE FROM ' . $this->CFG['db']['tbl']['music_listened'] . ' WHERE  music_id IN(' . $music_id . ')'.'AND user_id=' . $this->dbObj->Param('user_id');
						$stmt   = $this->dbObj->Prepare($sql);
						$rs     = $this->dbObj->Execute($stmt,array($user_id));
						 if (!$rs)
										trigger_db_error($this->dbObj);

						// **********End************
						/*if ($this->chkIsFeaturedMusic($music_id_arr, $user_id)) {
							$new_video= $this->getNewFeaturedVideo($user_id);
							 $this->setFeatureThisImage($new_video, $user_id);
						}*/
				}
		    	return true;
			}

		/**
		 * musicHandler::deleteFavoriteMusic()
		 *
		 * @param purpose $ To delete the selected favorite music of the particular user
		 * @param mixed $music_id
		 * @param mixed $user_id
		 * @return void
		 */
		public function deleteFavoriteMusic($music_id, $user_id)
			{
				$sql = 'SELECT mf.music_favorite_id, mf.user_id as favorite_user_id, m.user_id '.
						' FROM '.$this->CFG['db']['tbl']['music_favorite'].' as mf, '.
						$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['music'].' as m '.
						' WHERE u.user_id = mf.user_id AND mf.music_id = m.music_id AND mf.user_id = '.
						$this->dbObj->Param('user_id').' AND mf.music_id = '.$this->dbObj->Param('music_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id, $music_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
				{
					$activity_arr = $row;
					$activity_arr['action_key']	= 'delete_music_favorite';
					$activity_arr['favorite_user_id']	= $user_id;
					$musicActivityObj = new MusicActivityHandler();
					$musicActivityObj->addActivity($activity_arr);
				}

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_favorite'].' WHERE'.
						' user_id=' . $this->dbObj->Param('user_id') . ' AND' . ' music_id=' . $this->dbObj->Param('music_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id, $music_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				if ($this->dbObj->Affected_Rows())
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET total_favorites = total_favorites-1'.
					 			' WHERE music_id=' . $this->dbObj->Param('music_id');

						$stmt   = $this->dbObj->Prepare($sql);
						$rs     = $this->dbObj->Execute($stmt, array($music_id));
						if (!$rs)
							trigger_db_error($this->dbObj);
					}
			}

		/**
		 * musicHandler::getMusicDetails()
		 *
		 * @param purpose $ To get music details in music list
		 * @param mixed $music_id
		 * @param mixed $user_id
		 * @return
		 */
		public function getMusicDetails($music_field_arr = array(), $music_id, $user_id=0)
			{
				$music_field = implode(',', $music_field_arr);
				$additional = '';
				if ($user_id)
					{
						$additional = ' AND user_id='.$user_id;
					}
				$sql = 'SELECT '.$music_field.' FROM '.$this->CFG['db']['tbl']['music'].' WHERE music_id=' . $this->dbObj->Param('music_id') . ' AND' . ' music_status=\'Ok\'' . $additional . ' LIMIT 0,1';
				$stmt     = $this->dbObj->Prepare($sql);
				$rs       = $this->dbObj->Execute($stmt, array($music_id));
				if (!$rs)
					trigger_db_error($this->dbObj);
				if($row = $rs->FetchRow())
					{
						$this->music_details = $row;
						return $this->music_details;
					}
				return false;
			}

		/**
		 * musicHandler::populateMusicCategoryList()
		 *
		 * @param purpose $ To get music Category List in music list
		 * @param mixed $user_id
		 * @return
		 */
		public function populateMusicCategoryList($highlight_user_id)
			{
				$sql = 'SELECT music_category_name '.' FROM '.$this->CFG['db']['tbl']['music_category'];
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);
				$highlight_value = $this->fields_arr['music_category_name'];
				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$out = '';
								$selected = $highlight_value == $row['music_category_name']?' selected':'';
								?>
									<option value="<?php echo $row['music_category_name'];?>"<?php echo $selected;?>>
									<?php echo $row['music_category_name'];?>
									</option>
								<?php
							}
					}
			}

		/**
		 * MusicHandler::populateSinglePlayerConfiguration()
		 *
		 * @return void
		 */
		public function populateSinglePlayerConfiguration()
		 	{
				$this->flv_player_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['single_player']['player_path'].
													$this->CFG['admin']['musics']['single_player']['swf_name'].'.swf';
				$this->configXmlcode_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['single_player']['config_name'].'.php?';
				$this->playlistXmlcode_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['single_player']['playlist_name'].'.php?';
				$this->addsXmlCode_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['single_player']['ad_name'].'.php';
				//END TO ADD THE CODING FOR GETTING THE THEME AS TEMPLATE BASED
				if(is_file($this->CFG['site']['project_path'].$this->CFG['admin']['musics']['single_player']['theme_path'].
				$this->CFG['html']['template']['default'].
				'_skin_'.str_replace('screen_','',$this->CFG['html']['stylesheet']['screen']['default']).'.xml'))
				{
					$this->CFG['admin']['musics']['single_player']['xml_theme'] =$this->CFG['html']['template']['default'].'_skin_'.
					str_replace('screen_','',$this->CFG['html']['stylesheet']['screen']['default']).'.xml';
				}
				//END TO ADD THE CODING FOR GETTING THE THEME AS TEMPLATE BASED
				$this->themesXml_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['single_player']['theme_path'].
														$this->CFG['admin']['musics']['single_player']['xml_theme'];

			}

		/**
		 * MusicHandler::populateSinglePlayer()
		 *
		 * @param string $div_id
		 * @param string $music_player_id
		 * @param integer $width
		 * @param integer $height
		 * @param string $auto_play
		 * @return void
		 */
		public function populateSinglePlayer($music_fields=array())
			{
			//$div_id='flashcontent', $music_player_id, $width, $height, $auto_play='false';
				if(!array_key_exists ('div_id', $music_fields))
					$music_fields['div_id'] = 'flashcontent';

				if($music_fields['width'] == '')
					$music_fields['width'] = $this->CFG['admin']['musics']['single_player']['width'];

				if($music_fields['height'] == '')
					$music_fields['height'] = $this->CFG['admin']['musics']['single_player']['height'];

				echo '<div id="'.$music_fields['div_id'].'"></div>';
				?>
				<script type="text/javascript">
					var music_player_id = '<?php echo $music_fields['music_player_id'];?>';
					var so1 = new SWFObject("<?php echo $this->flv_player_url; ?>", music_player_id, "<?php echo $music_fields['width']; ?>", "<?php echo $music_fields['height']; ?>", "7", "#000000");
					so1.addParam("wmode", "transparent");
					so1.addVariable("autoplay", "<?php echo $music_fields['auto_play']; ?>");
					so1.addVariable("configXmlPath", "<?php echo $this->configXmlcode_url; ?>");
					so1.addVariable("playListXmlPath", "<?php echo $this->playlistXmlcode_url; ?>");
					so1.addVariable("themes", "<?php echo $this->themesXml_url; ?>");
					so1.write("<?php echo $music_fields['div_id']; ?>");
				</script>
				<?php
			}
		/**
		 * musicHandler::populatePlayerWithPlaylistConfiguration()
		 *
		 * @return void
		 */
		public function populatePlayerWithPlaylistConfiguration()
		 	{
				$this->flv_player_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['playlist_player']['player_path'].
													$this->CFG['admin']['musics']['playlist_player']['swf_name'].'.swf';
				$this->configXmlcode_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['playlist_player']['config_name'].'.php?';
				$this->playlistXmlcode_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['playlist_player']['playlist_name'].'.php?';
				$this->addsXmlCode_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['playlist_player']['ad_name'].'.php';
				//START TO ADD THE CODING FOR GETTING THE THEME AS TEMPLATE BASED
				if(is_file($this->CFG['site']['project_path'].$this->CFG['admin']['musics']['playlist_player']['theme_path'].
				$this->CFG['html']['template']['default'].
				'_skin_'.str_replace('screen_','',$this->CFG['html']['stylesheet']['screen']['default']).'.xml'))
				{
					$this->CFG['admin']['musics']['playlist_player']['xml_theme'] =$this->CFG['html']['template']['default'].'_skin_'.
					str_replace('screen_','',$this->CFG['html']['stylesheet']['screen']['default']).'.xml';
				}
				//END TO ADD THE CODING FOR GETTING THE THEME AS TEMPLATE BASED
				$this->themesXml_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['playlist_player']['theme_path'].
														$this->CFG['admin']['musics']['playlist_player']['xml_theme'];

			}

		/**
		 * musicHandler::populatePlayerWithPlaylist()
		 *
		 * @param string $div_id
		 * @param string $music_player_id
		 * @param integer $width
		 * @param integer $height
		 * @param string $auto_play
		 * @param boolean $hidden
		 * @param boolean $playlist_auto_play
	     * @param boolean $javascript_enabled
	     * @param boolean $player_ready_enabled
		 * @return void
		 */
		public function populatePlayerWithPlaylist($music_fields=array())
			{
				//$div_id='flashcontent', $music_player_id, $width, $height, $auto_play='false', $hidden=false, $playlist_auto_play = 'true', $javascript_enabled = false, $player_ready_enabled=false
				$default_array = array(
					'div_id'               => 'flashcontent',
					'auto_play'            => 'false',
					'playlist_auto_play'   => true,
					'javascript_enabled'   => false,
					'player_ready_enabled' => false,
					'hidden'               => false,
					'informCSSWhenPlayerReady' => true
				);

				foreach($default_array as $key => $value)
				{
					if(!array_key_exists ($key, $music_fields))
						$music_fields[$key] = $value;
				}

				echo '<div id="'.$music_fields['div_id'].'"';
				if($music_fields['hidden'])
					echo ' class="clsHiddenPlayer"';
				echo '><!----></div>';

				if($music_fields['playlist_auto_play'])
					$playlist_auto_play = 'true';
				else
					$playlist_auto_play = 'false';

				if($music_fields['javascript_enabled'])
					$javascript_enabled = 'true';
				else
					$javascript_enabled = 'false';
				if($music_fields['informCSSWhenPlayerReady'])
					$playerready_css_enabled = 'true';
				else
					$playerready_css_enabled = 'true';


				if($music_fields['player_ready_enabled'])
					$player_ready_enabled = 'true';
				else
					$player_ready_enabled = 'false';
				?>
				<script type="text/javascript">
					var music_player_id = '<?php echo $music_fields['music_player_id'];?>';
					var so1 = new SWFObject("<?php echo $this->flv_player_url; ?>", music_player_id, "<?php echo $music_fields['width']; ?>", "<?php echo $music_fields['height']; ?>", "7", "#000000");
					so1.addParam("wmode", "transparent");
					so1.addVariable("autoplay", "<?php echo $music_fields['auto_play']; ?>");
					so1.addVariable("configXmlPath", "<?php echo $this->configXmlcode_url; ?>");
					so1.addVariable("playListXmlPath", "<?php echo $this->playlistXmlcode_url; ?>");
					so1.addVariable("themesXmlPath", "<?php echo $this->themesXml_url; ?>");
					so1.addVariable("playListAutoPlay", "<?php echo $playlist_auto_play; ?>");
					so1.addVariable("javascriptEnabled", "<?php echo $javascript_enabled; ?>");
					so1.addVariable("callJSWhenPlayerReady", "true");
					so1.addVariable("informCSSWhenPlayerReady", "<?php echo $playerready_css_enabled; ?>");
					so1.write("<?php echo $music_fields['div_id']; ?>");
					createJSFCommunicatorObject(thisMovie(music_player_id));
				</script>
				<?php
			}

		/**
		 * musicHandler::populatePlayerWithPlaylistForAjax()
		 *	For AJAX pages (Note: player div have to be placed in tpl)
		 *
		 * @param string $div_id
		 * @param string $music_player_id
		 * @param integer $width
		 * @param integer $height
		 * @param string $auto_play
		 * @param boolean $hidden
		 * @param boolean $playlist_auto_play
	     * @param boolean $javascript_enabled
	     * @param boolean $player_ready_enabled
		 * @return void
		 */
		public function populatePlayerWithPlaylistForAjax($div_id='flashcontent', $music_player_id, $width, $height, $auto_play='false', $hidden=false, $playlist_auto_play = true, $javascript_enabled = false, $player_ready_enabled=false)
			{
				if($playlist_auto_play)
					$playlist_auto_play = 'true';
				else
					$playlist_auto_play = 'false';

				if($javascript_enabled)
					$javascript_enabled = 'true';
				else
					$javascript_enabled = 'false';

				if($player_ready_enabled)
					$player_ready_enabled = 'true';
				else
					$player_ready_enabled = 'false';

				?>
					var hidden_music_player_id = '<?php echo $music_player_id;?>';
					var so1 = new SWFObject("<?php echo $this->flv_player_url; ?>", hidden_music_player_id, "<?php echo $width; ?>", "<?php echo $height; ?>", "7", "#000000");
					so1.addParam("wmode", "transparent");
					so1.addVariable("autoplay", "<?php echo $auto_play; ?>");
					so1.addVariable("configXmlPath", "<?php echo $this->configXmlcode_url; ?>");
					so1.addVariable("playListXmlPath", "<?php echo $this->playlistXmlcode_url; ?>");
					so1.addVariable("themesXmlPath", "<?php echo $this->themesXml_url; ?>");
					so1.addVariable("playListAutoPlay", "<?php echo $playlist_auto_play; ?>");
					so1.addVariable("javascriptEnabled", "<?php echo $javascript_enabled; ?>");
					so1.addVariable("callJSWhenPlayerReady", "<?php echo $player_ready_enabled; ?>");
					so1.write("<?php echo $div_id; ?>");
					createJSFCommunicatorObject(thisMovie(hidden_music_player_id));
				<?php
			}

		/**
		 * MusicHandler::chkIsAllowedLeftMenu()
		 *
		 * @return
		 */
		public function chkIsAllowedLeftMenu()
			{
				global $HeaderHandler;
				$allowed_pages_array = array('index.php', 'viewPlaylist.php');
				$HeaderHandler->headerBlock['left_menu_display'] = displayBlock($allowed_pages_array, false, $append_default_pages=false);
				return $HeaderHandler->headerBlock['left_menu_display'];
			}

		/**
		 * MusicHandler::populateFeaturedPlaylist()
		 *
		 * @return void
		 */
		public function populateFeaturedPlaylist()
			{
				global $smartyObj;
				$sql = 'SELECT sum(mpl.total_visits) AS total_palys, pl.playlist_id, pl.user_id, TIMEDIFF(NOW(), pl.last_viewed_date) AS last_viewed_date, pl.playlist_name, (pl.rating_total/pl.rating_count) as rating, pl.total_favorites, pl.total_featured,rating_count,
						DATE_FORMAT(pl.date_added,\''.$this->CFG['format']['date'].'\') as date_added, pl.allow_ratings, pl.allow_comments, pl.total_comments, pl.total_tracks,pl.featured, pl.total_views, pl.playlist_description, pl.playlist_tags, pl.thumb_ext,pl.thumb_music_id, u.user_name
						FROM '.$this->CFG['db']['tbl']['music_playlist'].' AS pl LEFT JOIN '.$this->CFG['db']['tbl']['music_playlist_listened'].' AS mpl ON mpl.playlist_id=mpl.playlist_id, '.$this->CFG['db']['tbl']['users'].' AS u '.
						'WHERE u.user_id =pl.user_id AND u.usr_status = \'Ok\' AND pl.playlist_status = \'Yes\' AND pl.featured=\'Yes\' GROUP BY mpl.playlist_id';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$this->featured_playlist_arr = array();

				if($rs->PO_RecordCount())
					$this->featured_playlist_arr = $rs->FetchRow();
			}

		/**
		 * MusicHandler::getMusicNavClass()
		 *
		 * @param mixed $identifier
		 * @return boolean
		 */
		public function getMusicNavClass($identifier)
			{
				$identifier = strtolower($identifier);
				return isset($this->_navigationArr[$identifier])?$this->_navigationArr[$identifier]:$this->_clsInActiveLink;
			}

		/**
		 * musicHandler::getPlaylistImageDetail()
		 * @ get 4 image
		 * @param integer $playlist_id
		 * @param boolean $condition - to add accesstype and additional query, adult query
		 * @return array
		 */
		public function getPlaylistImageDetail($playlist_id, $condition=true)
			{
				$getPlaylistImageDetail_arr = array();
				$playlist_thumbnail_folder = $this->CFG['media']['folder'].'/'.
												$this->CFG['admin']['musics']['folder'].'/'.
													$this->CFG['admin']['musics']['thumbnail_folder'].'/';

				$sql = 'SELECT m.music_id, m.music_title, m.music_server_url, m.music_thumb_ext, mfs.file_name, '.
							' m.small_width, m.small_height, m.thumb_width, m.thumb_height FROM '.
							$this->CFG['db']['tbl']['music_in_playlist'].' AS mip JOIN '.
							$this->CFG['db']['tbl']['music'].' AS m ON m.music_id=mip.music_id  JOIN '.
							$this->CFG['db']['tbl']['music_files_settings'].' AS mfs '.
							'ON mfs.music_file_id = m.thumb_name_id, '.$this->CFG['db']['tbl']['users'].
							' AS u WHERE mip.playlist_id ='.$this->dbObj->Param('playlist_id').' '.
							' AND m.user_id=u.user_id AND u.usr_status = \'Ok\' AND m.music_status = \'Ok\' AND '.
							' m.music_thumb_ext!=" "';

				if($condition)
					$sql .= ' AND (m.user_id = '.$this->CFG['user']['user_id'].
							' OR m.music_access_type = \'Public\''.
							$this->getAdditionalQuery().') '.$this->getAdultQuery('m.', 'music');

				$sql .= ' ORDER BY m.music_id DESC LIMIT 0,4';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($playlist_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$getPlaylistImageDetail_arr['total_record'] = $total = $rs->PO_RecordCount();
				$getPlaylistImageDetail_arr['noimageCount'] = 0;
				if($total < 4)
					$getPlaylistImageDetail_arr['noimageCount'] = 4-$total;
				$getPlaylistImageDetail_arr['row'] = array();
				$inc = 1;
				while($row = $rs->FetchRow())
					{
						$getPlaylistImageDetail_arr['row'][$inc]['record'] = $row;
						$getPlaylistImageDetail_arr['row'][$inc]['playlist_thumb_path'] = $row['music_server_url'].$playlist_thumbnail_folder.getMusicImageName($row['music_id']).$this->CFG['admin']['musics']['thumb_name'].'.'.$row['music_thumb_ext'];
						/*$getPlaylistImageDetail_arr['row'][$inc]['disp_thumb_image']= DISP_IMAGE($this->CFG['admin']['musics']['thumb_width'], $this->CFG['admin']['musics']['thumb_height'], $row['thumb_width'], $row['thumb_height']);*/
						$getPlaylistImageDetail_arr['row'][$inc]['playlist_path'] = $row['music_server_url'].$playlist_thumbnail_folder.getMusicImageName($row['music_id']).$this->CFG['admin']['musics']['small_name'].'.'.$row['music_thumb_ext'];
						/*$getPlaylistImageDetail_arr['row'][$inc]['disp_image']= DISP_IMAGE($this->CFG['admin']['musics']['small_width'], $this->CFG['admin']['musics']['small_height'], $row['small_width'], $row['small_height']);*/
						$inc++;
					}

				return $getPlaylistImageDetail_arr;
			}

		/**
		 * MusicHandler::selectFeaturedMusic()
		 *
		 * @param string $condition
		 * @param array $value
		 * @param string $returnType
		 * @return mixed
		 */
		public function selectFeaturedMusic($condition, $value, $returnType='')
			{
				$sql = 'SELECT music_featured_id FROM '.$this->CFG['db']['tbl']['music_featured'].
							' WHERE '.$condition;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $value);
				if (!$rs)
					trigger_db_error($this->dbObj);

				if(!$returnType)
					return $rs->PO_RecordCount();
				else
					return $rs;
			}

		/**
		 * MusicHandler::deleteFromFeatured()
		 *
		 * @param mixed $displayMsg
		 * @return void
		 */
		public function deleteFromFeatured($displayMsg, $music_id)
			{
				//Start delete music featured Music activity..
				$sql = 'SELECT mf.music_featured_id, mf.user_id as featured_user_id, m.user_id '.
						' FROM '.$this->CFG['db']['tbl']['music_featured'].' as mf, '.
						$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['music'].' as m '.
						' WHERE u.user_id = mf.user_id AND mf.music_id = m.music_id AND mf.user_id = '.
						$this->dbObj->Param('user_id').' AND mf.music_id = '.$this->dbObj->Param('music_id');

				$fields_value_arr = array($this->CFG['user']['user_id'], $this->fields_arr['music_id']);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if(!empty($row))
					{
						$activity_arr = $row;
						$activity_arr['action_key']	= 'delete_music_featured';
						$musicActivityObj = new MusicActivityHandler();
						$musicActivityObj->addActivity($activity_arr);
					}
				//end
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_featured'].
						' WHERE user_id='.$this->dbObj->Param('user_id').
						' and music_id='.$this->dbObj->Param('music_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $music_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				if($this->dbObj->Affected_Rows())
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET total_featured = total_featured-1'.
								' WHERE music_id='.$this->dbObj->Param('music_id');
						$stmt = $this->dbObj->Prepare($sql);

						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
						if (!$rs)
							trigger_db_error($this->dbObj);

						if($displayMsg)
							echo $this->LANG['viewmusic_featured_deleted_successfully'];
					}
			}

		/**
		 * MusicHandler::chkMusicFeaturedAlreadyAdded()
		 *
		 * @return boolean
		 */
		public function chkMusicFeaturedAlreadyAdded()
			{
				$sql = 'SELECT * FROM '. $this->CFG['db']['tbl']['music_featured'].' WHERE user_id='.$this->dbObj->Param('user_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						return true;
					}
				return false;
			}


		/**
		 * MusicHandler::getPlaylistTotalSong()
		 *
		 * @param mixed $playlist_id
		 * @return
		 */
		public function getPlaylistTotalSong($playlist_id)
			{
				$sql = 'SELECT count(music_in_playlist_id) AS total '.
				 		'FROM '.$this->CFG['db']['tbl']['music_in_playlist'].' as mpl JOIN '.$this->CFG['db']['tbl']['music'].' as m ON mpl.music_id=m.music_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u '.
						'WHERE u.user_id = m.user_id AND m.music_status = \'Ok\' AND u.usr_status = \'Ok\' AND mpl.playlist_id = '.$playlist_id.' '.
						'AND (m.user_id = '.$this->CFG['user']['user_id'].' OR '.' m.music_access_type = \'Public\''.$this->getAdditionalQuery().') '.$this->getAdultQuery('m.', 'music').' ORDER BY mpl.order_id ASC';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $row['total'];
			}

		/**
		 * MusicHandler::populateMusicJsVars()
		 *
		 * @return void
		 */
		 
		public function populateMusicJsVars()
			{
				echo '<script type="text/javascript" language="javascript">';
				echo 'var play_songs_playlist_player_url = "'.$this->playSongsUrl.'";
					  var play_quickMix_url = "'.$this->playQuickMixUrl.'";
					  var create_album_url = "'.$this->createAlbumUrl.'";
					  var view_cart_url = "'.$this->viewCartUrl.'";
					  var qucikmix_added_already = "'.$this->LANG['common_music_quickmix_added_already'].'";
					  var hidden_player_not_loaded = "'.$this->LANG['common_msg_player_not_loaded'].'";
					  var volume_control_enabled_help_tip = "'.$this->LANG['common_volume_help_tip_enabled'].'";
					  var volume_control_disabled_help_tip = "'.$this->LANG['common_volume_help_tip_disabled'].'";
					  var quickMix_url = "'.$this->quickMixUrl.'";
					  var save_volume_url = "'.$this->saveVolumeUrl.'";
					  var LANG_VOLUME_MUTE = "'.$this->LANG['common_volume_mute'].'";
					  var LANG_VOLUME_UNMUTE = "'.$this->LANG['common_volume_unmute'].'";
					  //SETTING PLAYER VOLUME TO DEFAULT VALUE
					  playlist_player_volume = '.$_SESSION['music_global_voulme'].';
					  playlist_player_volume_mute_cur = '.$_SESSION['music_global_voulme'].';';

				/*if($_SESSION['music_global_voulme'] == 0)
					echo 'playlist_player_volume_mute_prev = 100;';*/
				//echo 'var volume_help_tip_top_pos = '.$this->CFG['admin'][$this->CFG['html']['template']['default']]['musics']['volume_helptip_info_top'].';';
				//echo 'var volume_help_tip_left_pos = '.$this->CFG['admin'][$this->CFG['html']['template']['default']]['musics']['volume_helptip_info_left'].';';
				//echo 'var volume_iframe_help_tip_top_pos = '.$this->CFG['admin'][$this->CFG['html']['template']['default']]['musics']['volume_iframe_helptip_info_top'].';';
				//echo 'var volume_iframe_help_tip_left_pos = '.$this->CFG['admin'][$this->CFG['html']['template']['default']]['musics']['volume_iframe_helptip_info_left'].';';


				echo '//Quick Mix JS ARRAY';
				foreach($this->quick_mix_id_arr as $quick_mix)
					{
						echo 'quick_mix_music_id_arr.push('.$quick_mix.');';
					}
					echo 'quickMixPopupWindow = eval('.$this->quick_mix_window_name.');';
				echo '</script>';
			}


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


	   public function getOtherFormatTotalDownload($music_type='mp3',$music_id=0)
			{
				$sql = ' SELECT count(music_id) count FROM '.$this->CFG['db']['tbl']['music_other_format_downloads'].' WHERE music_id=\''.$music_id.'\' AND music_type=\''.$music_type.'\' ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);
				$row = $rs->FetchRow();
				return $row['count'];
			}


		public function incrementOtherFormatTotalDownload($music_type='mp3',$music_id=0)
			{
				if($this->getOtherFormatTotalDownload($music_type,$music_id))
					$sql=' UPDATE '.$this->CFG['db']['tbl']['music_other_format_downloads'].' SET total_downloads=total_downloads+1 '.
					' WHERE music_id=\''.$music_id.'\' AND music_type=\''.$music_type.'\' ';
				else
					$sql=' INSERT INTO '.$this->CFG['db']['tbl']['music_other_format_downloads'].' SET total_downloads=1, music_id=\''.$music_id.'\', music_type=\''.$music_type.'\' ';
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);
			}

		/**
		 * MusicHandler::getMusicPlayingTime()
		 *
		 * @param mixed $text_arr
		 * @return time
		 */
		public function getMusicPlayingTime($text_arr)
			{
				$mname = $text_arr;
				$duration = false;

				if($this->CFG['admin']['musics']['playing_time_mp3info'])
					{
						$duration = exec($this->CFG['admin']['audio']['mp3info_path'].' -p "%S" '.$mname);
					}

				if(!$duration)
					{
						exec($this->CFG['admin']['video']['mplayer_path'].' -vo null -ao null -frames 0 -identify '.$mname, $p);
						while(list($k,$v)=each($p))
							{
								if($length = strstr($v,'ID_LENGTH='))
						        	break;
						    }
						if(isset($length))
							$lx = explode("=",$length);
						$duration = @$lx[1];
					}
				$hour = floor($duration/(60*60));
				$min = floor(($duration%(60*60))/60);
				$sec = floor(($duration%(60*60))%60);
				$hour = str_pad($hour, 2, '0', STR_PAD_LEFT);
				$min = str_pad($min, 2, '0', STR_PAD_LEFT);
				$sec = str_pad($sec, 2, '0', STR_PAD_LEFT);
				return $hour.':'.$min.':'.$sec;
				/*foreach($text_arr as $val)
					{
						if (substr(trim($val), 0, 13) != 'Video stream:')
							continue;
						$str = $val;
					}
				if(isset($str))
					{
						$str = substr($str, 0, strpos($str, 'secs'));
						$str = str_replace(' ', '&', trim($str));
						$str = round(substr(strrchr($str, "&"), 1));
						$min = floor($str/60);
						$min = str_pad($min, 2, '0', STR_PAD_LEFT);
						$sec = $str%60;
						$sec = strlen($sec)>2?substr($sec, 0,2):str_pad($sec, 2, '0', STR_PAD_LEFT);
						return $min.':'.$sec;
					}
				else
					return '00:00';*/
			}

		/**
		 * MusicHandler::fmtMusicPlayingTime()
		 *
		 * @param time $playing_time
		 * @param minutesFmt value as boolean
		 * @return time
		 */
		public function fmtMusicPlayingTime($playing_time, $minutesFmt = false)
			{
				if(empty($playing_time))
					return '';

				$playing_time_arr = explode(':', $playing_time);
				$formatted_playing_time = '';

				if($playing_time_arr[0] != 0 && $minutesFmt == false)
					$formatted_playing_time = $playing_time_arr[0].':';
				elseif($playing_time_arr[0] != 0 && $minutesFmt == true)
					$playing_time_arr[1] = $playing_time_arr[1]+($playing_time_arr[0]*60);

				$formatted_playing_time .= $playing_time_arr[1].':'.$playing_time_arr[2];
				return $formatted_playing_time;
			}
		/**
		 * MusicHandler::getEmailAddressOfRelation()
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
			    trigger_db_error($this->dbObj);

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
		 * MusicHandler::getMusicOwnerId()
		 *
		 * @param integer $music_id
		 * @return integer
		 */
		public function getMusicOwnerId($music_id)
			{
				$sql = 'SELECT user_id FROM '.$this->CFG['db']['tbl']['music'].' '.
						'WHERE music_id ='.$this->dbObj->Param('music_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($music_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						return $row['user_id'];
					}
				return false;

			}

						/**
	 * MusicHandler::chkIsAvailMusicFormat()
	 *
	 * @param string $music_type
	 * @param integer $music_id
	 * @return
	 */
	public function chkIsAvailMusicFormat($music_type='mp3',$music_id=0)
			{
				$this->sql_condition = 'm.music_status=\'Ok\' AND m.music_encoded_status=\'Yes\' AND m.music_id=\''.addslashes($this->fields_arr['music_id']).'\' AND (m.user_id = '.$this->CFG['user']['user_id'].' OR m.music_access_type = \'Public\''.$this->getAdditionalQuery('m.').')';

				$sql = 'SELECT m.music_thumb_ext, m.music_available_formats, m.music_server_url, m.music_title,music_flv_url, flv_upload_type'.
						' FROM '.$this->CFG['db']['tbl']['music'].' as m'.
						' WHERE '.$this->sql_condition.' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				if($row = $rs->FetchRow())
					{
						if($row['music_thumb_ext']==$music_type)
						{
							return true;
						}
						if($avail_arr=explode(',',$row['music_available_formats']) and
							in_array($music_type,$avail_arr) and $this->chkIsDownloadVideoFormat($music_type))
							return true;

					}
				return false;
			}

	public function chkIsDownloadMusicFormat($music_type='mp3')
			{
				if($this->CFG['admin']['musics']['music_other_formats_enabled'] and isset($this->CFG['admin']['musics']['music_download_formats']) and is_array($this->CFG['admin']['musics']['music_download_formats']) and
				in_array($music_type, $this->CFG['admin']['musics']['music_download_formats']))
					return true;

				return false;
			}

	public function chkPrivateSong($music_id)
		{
			$sql = 'SELECT m.music_id  FROM '.$this->CFG['db']['tbl']['music'].' as m'.
					' WHERE m.music_id= '.$this->dbObj->Param('music_id').' AND (m.user_id = '.
					$this->CFG['user']['user_id'].' OR m.music_access_type = \'Public\''.
					$this->getAdditionalQuery().') '.$this->getAdultQuery('m.', 'music');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($music_id));
			if (!$rs)
				trigger_db_error($this->dbObj);

			return $rs->PO_RecordCount();
		}

		/**
		 * MusicHandler::chkValidArtistList()
		 *
		 * @param mixed $field_name
		 * @param string $tag
		 * @param string $err_tip
		 * @return
		 */
		public function chkValidArtistList($field_name, $err_tip = '')
			{
				$artist_arr = explode(',', $this->fields_arr[$field_name]);
				$artist_arr = array_unique($artist_arr);
				$key = array_search('', $artist_arr);
				if($key)
					unset($artist_arr[$key]);

				$err_tip = str_replace('VAR_MIN', $this->CFG['fieldsize']['music_artist']['min'], $err_tip);
				$err_tip = str_replace('VAR_MAX', $this->CFG['fieldsize']['music_artist']['max'], $err_tip);

				foreach($artist_arr as $key=>$value)
					{
						$value = trim($value);
						if(function_exists('mb_strlen'))
							{
								//decoded first since this adds the length of the html entities too done while sanitizing
								$strLength = mb_strlen(htmlspecialchars_decode($value),'utf-8');
							}
						else
							{
								$strLength = strlen(htmlspecialchars_decode($value));
							}

						if(($strLength<$this->CFG['fieldsize']['music_artist']['min']) or ($strLength>$this->CFG['fieldsize']['music_artist']['max']))
							{
								$this->setFormFieldErrorTip($field_name,$err_tip);
								return false;
							}
					}
				$this->fields_arr[$field_name] = implode(',', $artist_arr);
				return true;
			}

		/**
		 * MusicHandler::populateMusicChannel()
		 * 	FOR LISTING CATEGORY IN MENU
		 * @param string $type
		 * @return
		 */
		public function populateMusicChannel($type = 'General')
			{
				//Music catagory List order by Priority on / off features
				if($this->CFG['admin']['musics']['music_category_list_priority'])
					$order_by = 'priority';
				else
					$order_by = 'music_category_name';

				$sql = 'SELECT music_category_id, music_category_name FROM '.
						$this->CFG['db']['tbl']['music_category'].
							' WHERE parent_category_id=0 AND music_category_status=\'Yes\''.
							' AND music_category_type='.$this->dbObj->Param('music_category_type').
							' AND allow_post=\'Yes\' ORDER BY '.$order_by.' ASC ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($type));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if(!$rs->PO_RecordCount())
					return;

				$names = array('music_category_name');
				$value = 'music_category_id';
				$inc =0;
				while($row = $rs->FetchRow())
					{
						$channel[$inc]['id'] = $row['music_category_id'];
						$channel[$inc]['name']= wordWrap_mb_Manual($row['music_category_name'], $this->CFG['admin']['musics']['member_channel_length'],
													$this->CFG['admin']['musics']['member_channel_total_length']);
						$inc++;
					}

				return $channel;
			}

		/**
		 * musicHandler::getPlaylistImageName()
		 *
		 * @param integer $playlist_id
		 * @return array
		 */
		public function getPlaylistImageName($playlist_id)
			{
				$sql = 'SELECT m.music_id, m.music_server_url, m.music_thumb_ext, mfs.file_name, m.thumb_width, m.thumb_height FROM '.$this->CFG['db']['tbl']['music_in_playlist'].' '.
						'AS mip JOIN '.$this->CFG['db']['tbl']['music'].' AS m ON m.music_id=mip.music_id  JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs '.
						'ON mfs.music_file_id = m.thumb_name_id, '.$this->CFG['db']['tbl']['users'].' AS u WHERE mip.playlist_id ='.$this->dbObj->Param('playlist_id').' '.
						' AND m.user_id=u.user_id AND u.usr_status = \'Ok\' AND m.music_status = \'Ok\''.$this->getAdultQuery('m.', 'music').' AND '.
						' m.music_access_type = \'Public\' AND m.music_thumb_ext!=" " LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($playlist_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $row;
			}

		/**
		 * MusicHandler::playlistCreateActivity()
		 *
		 * @param mixed $playlist_id
		 * @return
		 */
		public function playlistCreateActivity($playlist_id)
			{
				//Start playlist create Music playlist activity..
				$sql = 'SELECT pl.playlist_id, u.user_name, pl.playlist_name, pl.user_id '.
						'FROM '.$this->CFG['db']['tbl']['music_playlist'].' as pl, '.$this->CFG['db']['tbl']['users'].' as u '.
						'WHERE u.user_id = pl.user_id AND pl.playlist_id = \''.$this->dbObj->Param('playlist_id').'\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($playlist_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$activity_arr = $row;
				$activity_arr['action_key']	= 'playlist_create';
				$createplaylist_image_array = $this->getPlaylistImageName($playlist_id);
				if(empty($createplaylist_image_array))
					{
						$activity_arr['music_id'] = '';
						$activity_arr['music_server_url'] = '';
						$activity_arr['music_thumb_ext'] = '';
					}
				else
					{
						$activity_arr['music_id'] = $createplaylist_image_array['music_id'];;
						$activity_arr['music_server_url'] = $createplaylist_image_array['music_server_url'];
						$activity_arr['music_thumb_ext'] = $createplaylist_image_array['music_thumb_ext'];
					}
				$playlistActivityObj = new MusicActivityHandler();
				$playlistActivityObj->addActivity($activity_arr);
				//end
			}
		public function getTagsLinkForPlaylist($playlist_tags,$taglimit,$playlist_id,$tag_serach_word='')
			{
			// change the function for display the tags with some more...
			global $smartyObj;
			$tags_arr = explode(' ', $playlist_tags);
			if(count($tags_arr)>$taglimit)
			{
				$playlist_tag_size=$taglimit;
			}
			else
			{
				$playlist_tag_size=count($tags_arr);
			}
			for($i=0;$i<$playlist_tag_size;$i++)
			{
				if($i<8)
				{
					if(strlen($tags_arr[$i]) > 5 and strlen($tags_arr[$i]) > 5+3)
					$getTagsLink_arr[$i]['title_tag_name'] = $getTagsLink_arr[$i]['wordWrap_mb_ManualWithSpace_tag_name'] = wordWrap_mb_Manual($tags_arr[$i], 5,5,true);
					else
					$getTagsLink_arr[$i]['title_tag_name'] = $getTagsLink_arr[$i]['wordWrap_mb_ManualWithSpace_tag_name'] = $tags_arr[$i];
					if(!empty($tag_serach_word))
						$getTagsLink_arr[$i]['wordWrap_mb_ManualWithSpace_tag_name'] = highlightWords($getTagsLink_arr[$i]['wordWrap_mb_ManualWithSpace_tag_name'], $tag_serach_word);
 				    $getTagsLink_arr[$i]['tag_url'] =getUrl('musicplaylist', '?pg=playlistnew&tags='.$tags_arr[$i], 'playlistnew/?tags='.$tags_arr[$i], '', 'music');
					if($i%2==0)
					{
						$getTagsLink_arr[$i]['class']='clsTagsDefalult';
					}
					else
					{
						$getTagsLink_arr[$i]['class']='clsTagsAlternate';
					}
				}
			}
			$smartyObj->assign('getTagsLink_arr', $getTagsLink_arr);
			setTemplateFolder('general/', 'music');
			$smartyObj->display('populateTagsLinks.tpl');
			}
		/**
		 * MusicHandler::getMyFeaturedPlaylist()
		 *
		 * @param mixed $user_id
		 * @return
		 */
		public function getMyFeaturedPlaylist($user_id)
		{
			$sql = 'SELECT pl.playlist_id FROM '.
					$this->CFG['db']['tbl']['music_playlist_featured'].
					' as fpl LEFT JOIN '.
					$this->CFG['db']['tbl']['music_playlist'].
					' as pl ON fpl.playlist_id=pl.playlist_id, users as u '.
					' WHERE fpl.user_id = '.$this->dbObj->Param('user_id').
					' AND pl.playlist_status=\'Yes\' '.
					'AND u.usr_status=\'Ok\' LIMIT 0,1';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($user_id));
			if (!$rs)
			trigger_db_error($this->dbObj);
			$row = $rs->FetchRow();
			$playlist_id=$row['playlist_id'];
			if($playlist_id!='')
			{
				$getMyFeaturedPlaylistUrl= getUrl('viewplaylist', '?playlist_id='.$playlist_id.'&amp;title=', $playlist_id.'/', '','music');
				return $getMyFeaturedPlaylistUrl;
			}
			else
			{
				return '';
			}
		}
         /**
		 * MusicHandler::getTagsForMusicList()
		 * Display tags
		 * @param mixed $music_tags,$taglimit
		 * @param tag_serach_word is used for highlight the search_tag_word.
		 * @return
		 */
		public function getMusicTagsLinks($music_tags,$taglimit,$tag_serach_word='')
		{
			// change the function for display the tags with some more...
			global $smartyObj;
			$tags_arr = explode(' ', $music_tags);
			if(count($tags_arr)>$taglimit)
			{
				$music_tag_size=$taglimit;
			}
			else
			{
				$music_tag_size=count($tags_arr);
			}
			for($i=0;$i<$music_tag_size;$i++)
			{
				if($i<8)
				{
					if(strlen($tags_arr[$i]) > 5 and strlen($tags_arr[$i]) > 5+3)
					$getTagsLink_arr[$i]['title_tag_name'] = $getTagsLink_arr[$i]['wordWrap_mb_ManualWithSpace_tag_name'] = wordWrap_mb_Manual($tags_arr[$i], 5,5,true);
					else
					$getTagsLink_arr[$i]['title_tag_name'] = $getTagsLink_arr[$i]['wordWrap_mb_ManualWithSpace_tag_name'] = $tags_arr[$i];
					if(!empty($tag_serach_word))
						$getTagsLink_arr[$i]['wordWrap_mb_ManualWithSpace_tag_name'] = highlightWords($getTagsLink_arr[$i]['wordWrap_mb_ManualWithSpace_tag_name'], $tag_serach_word);
				    $getTagsLink_arr[$i]['tag_url'] = getUrl('musiclist', '?pg=musicnew&tags='.$tags_arr[$i], 'musicew/?tags='.$tags_arr[$i], '', 'music');
 					if($i%2==0)
					{
						$getTagsLink_arr[$i]['class']='clsTagsDefalult';
					}
					else
					{
						$getTagsLink_arr[$i]['class']='clsTagsAlternate';
					}
				}
			}
			$smartyObj->assign('getTagsLink_arr', $getTagsLink_arr);
			setTemplateFolder('general/', 'music');
			$smartyObj->display('populateTagsLinks.tpl');
		}

		public function generalPopulateArrayPlaylist($list, $highlight_value='', $playlist_id='')
		{
			foreach($list as $key=>$value)
			{
				$disabled = in_array($key,$playlist_id)?'disabled="disabled"':'';
				$selected = trim($highlight_value) == trim($key)?' selected="selected"':'';
?>
<option value="<?php echo $key;?>"<?php echo $selected;?><?php echo $disabled;?>><?php echo $value;?></option>
<?php
			}
		}

		/**
		 * musicHandler::getPlaylistIdInMusic()
		 *
		 * @param string $page
		 * @return
		 */
		public function getPlaylistIdInMusic($music_id)
		{
			if(strstr($music_id,','))
				return true;

			global $smartyObj;
			$sql = 'SELECT playlist_id FROM '.
                    $this->CFG['db']['tbl']['music_in_playlist'].
					' WHERE music_id = '.$this->dbObj->Param('music_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt,array($music_id));
			if (!$rs)
				trigger_db_error($this->dbObj);
			$playlist = array();
			while($row = $rs->FetchRow())
			{
				$playlist[$row['playlist_id']] = $row['playlist_id'];
			}
			$smartyObj->assign('playlist', $playlist);

		}

		public function populateMusicListHidden($hidden_field)
		{
			foreach($hidden_field as $hidden_name)
			{
				//when submit the form through javascript and if not submit in IE,then check hidden input with the name set as "action", obviously this confused IE.
				//refer http://bytes.com/topic/javascript/answers/92323-form-action-help-needed
				if($hidden_name == 'action')
					$hidden_name = 'action_new';

?>
				<input type="hidden" name="<?php echo $hidden_name;?>" value="<?php echo isset($this->fields_arr[$hidden_name])?$this->fields_arr[$hidden_name]:'';?>" />
<?php
			}
		}

		public function populateMusicAlbum($type='Public', $user_id='', $album_id)
		{
			$sql = 'SELECT music_album_id, album_title FROM '.
					$this->CFG['db']['tbl']['music_album'].
					' WHERE  album_access_type='.$this->dbObj->Param('album_access_type').
					' AND user_id='.$this->dbObj->Param('user_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($type,$user_id));
		    if (!$rs)
			    trigger_db_error($this->dbObj);

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
		 * MusicHandler::sendMailToUserForMusicComment()
		 * Display tags sending mail to music owner
		 * @return
		 */
		public function sendMailToUserForMusicComment()
		{
			$this->UserDetails[$this->fields_arr['user_id']] = $this->getUserDetail('user_id', $this->fields_arr['user_id']);
			$subject = $this->LANG['music_comment_received_subject'];
			$body = $this->LANG['music_comment_received_content'];
			$user_url = getMemberProfileUrl($this->CFG['user']['user_id'], $this->CFG['user']['user_name']);
			$musiclink = $this->getAffiliateUrl(getUrl('viewmusic', '?music_id='.$this->fields_arr['music_id'].'&title='
				.$this->changeTitle($this->fields_arr['music_title']),$this->fields_arr['music_id'].'/'
				.$this->changeTitle($this->fields_arr['music_title']).'/', '', 'music'));
			$this->setEmailTemplateValue('site_name', $this->CFG['site']['name']);
			$this->setEmailTemplateValue('music_title', $this->fields_arr['music_title']);
			$this->setEmailTemplateValue('user_name', $this->UserDetails[$this->fields_arr['user_id']]['user_name']);
			$this->setEmailTemplateValue('music_link', $musiclink);
			$this->setEmailTemplateValue('link', $this->getAffiliateUrl($this->CFG['site']['url']));
			$this->setEmailTemplateValue('user', '<a href="'.$user_url.'">'.$this->CFG['user']['user_name'].'</a>');
			$this->setEmailTemplateValue('comment', wordWrap_mb_Manual($this->fields_arr['f'], 100, 100, true));
					$this->_sendMail($this->UserDetails[$this->fields_arr['user_id']]['email'],
					$subject, $body, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);
		}

		/**
		 * MusicHandler::getTotalSongs()
		 *
		 * @return
		 */
		public function getTotalSongs()
			{

				$sql = ' SELECT count(music_id) as total'.
						' FROM '.$this->CFG['db']['tbl']['music'].
						' WHERE music_status =\'Ok\'';


				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $row['total'];
			}


		/**
		 * MusicHandler::getTotalPlaylists()
		 *
		 * @return
		 */
		public function getTotalPlaylists()
			{
				$sql = ' SELECT COUNT(DISTINCT(playlist_id)) as total'.
						' FROM '.$this->CFG['db']['tbl']['music_in_playlist'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $row['total'];

			}

		/**
		 * MusicHandler::totalSongsListened()
		 *
		 * @return
		 */
		public function totalSongsListened()
			{
				$sql = ' SELECT COUNT(DISTINCT(music_id)) as total'.
						' FROM '.$this->CFG['db']['tbl']['music_listened'];


				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if($row['total']== '')	return 0; else	return $row['total'];

			}

		/**
		 * MusicHandler::totalSongsDonwloads()
		 *
		 * @return
		 */
		public function totalSongsDonwloads()
			{
				$sql = ' SELECT COUNT(DISTINCT(music_id)) as total'.
						' FROM '.$this->CFG['db']['tbl']['music'].
						' WHERE total_downloads > 0';


				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					{
						trigger_db_error($this->dbObj);
					}


				$row = $rs->FetchRow();
				if($row['total']== '')	return 0; else	return $row['total'];

			}
	}


?>
