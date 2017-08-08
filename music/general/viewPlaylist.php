<?php
//--------------class viewPlaylist--------------->>>//
/**
 * This class is used to viewPlaylist i,e (Playlist information, Update playlist viewed table, Playlist song list)
 *
 * @category	Rayzz
 * @package		manage music viewPlaylist
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 */
class viewPlaylist extends MusicHandler
	{
		public $playlist_owner_id = '';
		public $captchaText = '';
		public $page_title = '';
		public $featured_msg = '';
		public $favorite_msg = '';
		//public $commentUrl = '';

		/**
		 * viewPlaylist::isValidMusicPlayListID()
		 *
		 * @return
		 */
		public function isValidMusicPlayListID()
			{
				global $smartyObj;
				$sql = 'SELECT sum(mpl.total_visits) AS total_palys, pl.playlist_id, pl.user_id, TIMEDIFF(NOW(), pl.last_viewed_date) AS last_viewed_date, pl.playlist_name, (pl.rating_total/pl.rating_count) as rating, pl.total_favorites, pl.total_featured, pl.rating_count, pl.allow_embed,
						DATE_FORMAT(pl.date_added,\''.$this->CFG['format']['date'].'\') as date_added, pl.allow_ratings, pl.allow_comments, pl.total_comments, pl.total_tracks,pl.featured, pl.total_views, pl.playlist_description, pl.playlist_tags, pl.thumb_ext,pl.thumb_music_id, u.user_name
						FROM '.$this->CFG['db']['tbl']['music_playlist'].' AS pl LEFT JOIN '.$this->CFG['db']['tbl']['music_playlist_listened'].' AS mpl ON mpl.playlist_id=pl.playlist_id, '.$this->CFG['db']['tbl']['users'].' AS u '.
						'WHERE u.user_id =pl.user_id AND u.usr_status = \'Ok\' AND pl.playlist_status = \'Yes\' AND pl.playlist_id='.$this->dbObj->Param('playlist_id').' GROUP BY mpl.playlist_id';

				$value_arr = array($this->fields_arr['playlist_id']);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $value_arr);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$playListDetail = $rs->FetchRow();
				if(isset($playListDetail['playlist_id']))
					{
						$this->fields_arr['playlist_name'] = $playListDetail['playlist_name'];
						$this->fields_arr['allow_comments'] = $playListDetail['allow_comments'];
						$this->fields_arr['user_id'] = $playListDetail['user_id'];
						$this->fields_arr['rating_count'] = $playListDetail['rating_count'];
						$this->page_title = $playListDetail['playlist_name'];
						$this->playlist_owner_id = $playListDetail['user_id'];
						$playListDetail['private_song'] = $playListDetail['total_tracks'] - $this->getPlaylistTotalSong($playListDetail['playlist_id']);
						$playListDetail['total_palys'] = ($playListDetail['total_palys']=='')? 0: $playListDetail['total_palys'];
						$playListDetail['last_viewed_date'] = getTimeDiffernceFormat($playListDetail['last_viewed_date']);
						$playListDetail['music_path'] = '';
						$playListDetail['viewplaylist_url'] = getUrl('viewplaylist', '?playlist_id='.$playListDetail['playlist_id'].'&title='.$this->changeTitle($playListDetail['playlist_name']), $playListDetail['playlist_id'].'/'.$this->changeTitle($playListDetail['playlist_name']).'/', '','music');
						$playListDetail['playlist_owner_url'] = getMemberProfileUrl($playListDetail['user_id'], $playListDetail['user_name']);
						$playListDetail['playlist_description'] =	nl2br($playListDetail['playlist_description']);

						//Embeded Code
						$this->embeded_code=htmlentities('<script type="text/javascript" src="'.$this->CFG['site']['music_url'].'embedplaylist/?playlist_id='.$this->getFormField('playlist_id').'"></script>');

						$playlistId=mvFileRayzz($this->fields_arr['playlist_id']);
						$flv_player_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['playlist_player']['player_path'].
						$this->CFG['admin']['musics']['playlist_player']['swf_name'].'.swf';
						$configXmlcode_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['playlist_player']['config_name'].'.php?';
						$playlistXmlcode_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['playlist_player']['playlist_name'].'.php?';
						$addsXmlCode_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['playlist_player']['ad_name'].'.php';
						$themesXml_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['playlist_player']['theme_path'].
											$this->CFG['admin']['musics']['playlist_player']['xml_theme'];
						$configXmlcode_url .= 'pg=music_'.$this->fields_arr['playlist_id'].'_0_0_extsite';
						$playlistXmlcode_url .= 'pg=music_'.$this->fields_arr['playlist_id'];
						if(isset($this->CFG['admin']['musics']['embed_method']) and $this->CFG['admin']['musics']['embed_method']=='html')
							$this->embeded_code = htmlentities('<embed src="'.$this->CFG['site']['music_url'].'embedPlaylistPlayer.php?playlist_id='.$this->fields_arr['playlist_id'].'_'.$playlistId.'" FlashVars="configXmlPath='.$configXmlcode_url.'&playListXmlPath='.$playlistXmlcode_url.'&themesXmlPath='.$themesXml_url.'" quality="high" bgcolor="#000000" width="'.$this->CFG['admin']['musics']['playlist_player']['width'].'" height="'.$this->CFG['admin']['musics']['playlist_player']['height'].'" name="flvplayer" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" allowFullScreen="true" />');
						//Image..
						$playListDetail['getPlaylistImageDetail'] = $this->getPlaylistImageDetail($playListDetail['playlist_id']);// This function return playlist image detail array..//
						/*echo '<pre>';
						print_r($playListDetail);
						echo '</pre>';*/
						$playListDetail['rankUsersRayzz'] = false;
						$playListDetail['rating'] = '';
						if(rankUsersRayzz($this->CFG['admin']['musics']['playlist_allow_self_rating'], $this->CFG['user']['user_id']))
						{
							$playListDetail['rankUsersRayzz'] = true;
							$playListDetail['rating'] = $this->getRating($this->CFG['user']['user_id']);
						}
						$this->playlist_image_array = $this->getPlaylistImageName($playListDetail['playlist_id']);
						$smartyObj->assign('playlistInformation', $playListDetail);
						return true;
					}
				else
					{
						return false;
					}
			}

		/**
		 * viewPlaylist::updatePlaylistViewedTable()
		 *
		 * @return
		 */
		public function updatePlaylistViewedTable()
			{
				//IS NOT A MEMBER user_id =0;//
				$viewed_user_id = 0;
				if(isset($this->CFG['user']['user_id']))
					$viewed_user_id = $this->CFG['user']['user_id'];
				//CHECK USER ALREADY VIEW THIS PLAYLIST//
				$sql = 'SELECT playlist_viewed_id FROM '.$this->CFG['db']['tbl']['music_playlist_viewed'].
						' WHERE playlist_id ='.$this->dbObj->Param('playlist_id').' AND user_id='.$this->dbObj->Param('user_id').
						' AND DATE_FORMAT(last_viewed, \'%Y-%m-%d\') = CURDATE()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist_id'], $this->CFG['user']['user_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$value_array = array();
				$sql = '';
				if($rs->PO_RecordCount())
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist_viewed'].' '.
								'SET total_views  = total_views + 1 '.',  last_viewed=NOW()'.' '.
								'WHERE playlist_id = '.$this->dbObj->Param('playlist_id').' AND user_id='.$this->dbObj->Param('user_id');
						$value_array = array($this->fields_arr['playlist_id'], $viewed_user_id);
					}
				else
					{
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_playlist_viewed'].
								' SET playlist_id='.$this->dbObj->Param('playlist_id').', user_id='.$this->dbObj->Param('user_id').' '.
								', playlist_owner_id='.$this->dbObj->Param('playlist_owner_id').' '.
								', total_views=1, date_added=NOW()';
						$value_array = array($this->fields_arr['playlist_id'], $viewed_user_id, $this->playlist_owner_id);
					}
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $value_array);
				if (!$rs)
					trigger_db_error($this->dbObj);

				// UPDATE PLAYLIST TABLE //
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist'].' '.
								'SET total_views  = total_views + 1 '.',  last_viewed_date=NOW()'.' '.
								'WHERE playlist_id = '.$this->dbObj->Param('playlist_id');

				$value_array = array($this->fields_arr['playlist_id']);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $value_array);
				if (!$rs)
					trigger_db_error($this->dbObj);

				return true;
			}

		/**
		  * viewPlaylist::setTableAndColumns()
		  *
		  * @return
		  */
		 public function setTableAndColumns()
		 	{
				$this->setTableNames(array($this->CFG['db']['tbl']['music_in_playlist'] . ' as mpl LEFT JOIN ' . $this->CFG['db']['tbl']['music'] . ' as m ON mpl.music_id=m.music_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u, '.$this->CFG['db']['tbl']['music_album'].' AS ma'));
				$this->setReturnColumns(array('mpl.music_id', 'mpl.music_in_playlist_id', 'ma.music_album_id', 'ma.album_title', 'm.total_views', 'm.total_plays', 'm.music_title', 'm.music_tags', 'm.music_artist', 'm.music_ext', 'm.thumb_width', 'm.thumb_height', 'm.user_id', 'u.user_name', '(m.rating_total/m.rating_count) as rating'));
				$this->sql_condition = 'ma.music_album_id = m.music_album_id AND u.user_id = m.user_id AND m.music_status = \'Ok\' AND u.usr_status = \'Ok\' AND mpl.playlist_id = '.$this->fields_arr['playlist_id'];
				$this->sql_sort = 'mpl.order_id ASC';
			}

		/**
		 * viewPlaylist::displayPlaylistSong()
		 *
		 * @return
		 */
		public function displayPlaylistSong($count)
			{
				global $smartyObj;
				$displayPlaylistSong_arr = array();
				$start = $this->fields_arr['start'];
				$sql = 'SELECT  mc.music_category_id, mc.music_category_name, m.music_caption, m.music_server_url, m.music_thumb_ext, mfs.file_name, m.thumb_width, m.thumb_height, mpl.music_id, mpl.music_in_playlist_id, ma.music_album_id, ma.album_title,ma.album_access_type, ma.album_price, ma.album_for_sale, m.total_views, m.total_plays, m.music_title, m.music_tags, m.music_artist,m.music_price, m.music_ext, m.thumb_width, m.thumb_height, m.user_id, u.user_name, (m.rating_total/m.rating_count) as rating, m.rating_total, m.rating_count,  m.music_thumb_ext, TIMEDIFF(NOW(), m.date_added) as date_added, m.music_thumb_ext, m.total_comments, m.total_favorites,m.playing_time,m.for_sale '.
				 		'FROM '.$this->CFG['db']['tbl']['music_in_playlist'].' as mpl JOIN '.$this->CFG['db']['tbl']['music'].' as m ON mpl.music_id=m.music_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u, '.$this->CFG['db']['tbl']['music_album'].' AS ma, '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs, '.$this->CFG['db']['tbl']['music_category'].' AS mc '.
						'WHERE mc.music_category_id=m.music_category_id AND mc.parent_category_id=\'0\' AND mfs.music_file_id = m.thumb_name_id AND ma.music_album_id = m.music_album_id AND u.user_id = m.user_id AND m.music_status = \'Ok\' AND u.usr_status = \'Ok\' AND mpl.playlist_id = '.$this->fields_arr['playlist_id'].' '.$this->getAdultQuery('m.', 'music').' AND (m.user_id = '.$this->CFG['user']['user_id'].' OR'.
						' m.music_access_type = \'Public\''.$this->getAdditionalQuery().') ORDER BY mpl.order_id ASC ';
				if($count)
					$sql .= 'LIMIT '.$this->fields_arr['start'].' , '.$this->CFG['admin']['musics']['music_in_playlist_limit'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

					$this->total_records = $rs->PO_RecordCount();
				if(!$count)
					return $this->total_records;

				$this->player_music_id = array();
				$displayPlaylistSong_arr['record_count'] = 0;
				$displayPlaylistSong_arr['row'] = array();
				$inc = 0;
				if($this->total_records)
					{
						$this->activeClsNext = 'clsNextDisable';
						$this->activeClsPrevious = 'clsPreviousDisable';
						$this->isNextButton = false;
						$this->isPreviousButton = false;
						// PAGING //
						$total = $this->displayPlaylistSong(false);
						if($total > ($start+$this->CFG['admin']['musics']['music_in_playlist_limit']))
							{
								$this->activeClsNext = 'clsNext';
								$this->isNextButton = true;
							}
						if($start > 0)
							{
								$this->activeClsPrevious = 'clsPrevious';
								$this->isPreviousButton = true;
							}
						$musics_thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.
														$this->CFG['admin']['musics']['thumbnail_folder'].'/';

						$this->allow_quick_mixs = (isLoggedIn() and $this->CFG['admin']['musics']['allow_quick_mixs'])?true:false;
						while($songDetail = $rs->FetchRow())
							{
								$this->player_music_id[$inc] = $songDetail['music_id'];
								$displayPlaylistSong_arr['record_count'] = 1;
								$displayPlaylistSong_arr['row'][$inc]['add_quickmix'] = false;
					            if ($this->allow_quick_mixs)
									 {
						                $displayPlaylistSong_arr['row'][$inc]['add_quickmix'] = true;
						                $displayPlaylistSong_arr['row'][$inc]['is_quickmix_added'] = false;
						                if (rayzzMusicQuickMix($songDetail['music_id']))
						                    $displayPlaylistSong_arr['row'][$inc]['is_quickmix_added'] = true;
						            }

								$songDetail['date_added'] = ($songDetail['date_added'] != '') ? getTimeDiffernceFormat($songDetail['date_added']) : '';
								$displayPlaylistSong_arr['row'][$inc]['record'] = $songDetail;
								$displayPlaylistSong_arr['row'][$inc]['music_album_id'] = $songDetail['music_album_id'];
								$displayPlaylistSong_arr['row'][$inc]['for_sale'] = 'No';
								$displayPlaylistSong_arr['row'][$inc]['album_for_sale'] = 'No';
								if($songDetail['album_access_type']=='Private'
									and $songDetail['album_for_sale']=='Yes'
									and $songDetail['album_price']>0)
								{
									$displayPlaylistSong_arr['row'][$inc]['album_for_sale'] = 'Yes';
									   $album_price = strstr($songDetail['album_price'], '.');
			                       		if(!$album_price)
			                       		{
			                          	 $songDetail['album_price']=$songDetail['album_price'].'.00';
								   		}
									$displayPlaylistSong_arr['row'][$inc]['price'] = $this->LANG['common_album_price'].' <span>'.$this->CFG['currency'].$songDetail['album_price'].'</span>';
								}
								else if($songDetail['for_sale']=='Yes')
								{
									$displayPlaylistSong_arr['row'][$inc]['for_sale'] = $songDetail['for_sale'];
									    $music_price = strstr($songDetail['album_price'], '.');
			                       		if(!$music_price)
			                       		{
			                          	   $songDetail['music_price']=$songDetail['music_price'].'.00';
								   		}
									$displayPlaylistSong_arr['row'][$inc]['price'] = $this->LANG['common_music_price'].' <span>'.$this->CFG['currency'].$songDetail['music_price'].'</span>';
								}


								$displayPlaylistSong_arr['row'][$inc]['viewprofile_url'] = getMemberProfileUrl($songDetail['user_id'], $songDetail['user_name']);
								$displayPlaylistSong_arr['row'][$inc]['viewmusic_url'] = getUrl('viewmusic', '?music_id='.$songDetail['music_id'].'&amp;title='.$this->changeTitle($songDetail['music_title']), $songDetail['music_id'].'/'.$this->changeTitle($songDetail['music_title']).'/', '', 'music');
								$displayPlaylistSong_arr['row'][$inc]['musiclistalbum_url'] = getUrl('musiclist', '?pg=musicnew&album_id='.$songDetail['music_album_id'], 'musicnew/?album_id='.$songDetail['music_album_id'], '', 'music');
								$displayPlaylistSong_arr['row'][$inc]['musiccategorylist_url'] = getUrl('musiclist', '?pg=musicnew&cid='.$songDetail['music_category_id'], 'musicnew/?cid='.$songDetail['music_category_id'], '', 'music');
								$displayPlaylistSong_arr['row'][$inc]['playing_time'] = $this->fmtMusicPlayingTime($songDetail['playing_time']);
								if($songDetail['music_thumb_ext'])
									{
										$displayPlaylistSong_arr['row'][$inc]['music_image_src'] = $songDetail['music_server_url'].$musics_thumbnail_folder.getMusicImageName($songDetail['music_id'], $songDetail['file_name']).$this->CFG['admin']['musics']['thumb_name'].'.'.$songDetail['music_thumb_ext'];
									}
								else
									{
										$displayPlaylistSong_arr['row'][$inc]['music_image_src'] = '';
									}
								$inc++;
							}
					}
				else
					{
						$this->activeClsNext = 'clsNextDisable';
						$this->activeClsPrevious = 'clsPreviousDisable';
					}
				$smartyObj->assign('displayPlaylistSong_arr', $displayPlaylistSong_arr);
				setTemplateFolder('general/', 'music');
				$smartyObj->display('ajaxSonglist.tpl');
			}

		/**
		 * viewPlaylist::chkPlaylistFeatured()
		 *
		 * @return
		 */
		public function chkPlaylistFeatured()
			{
				$sql = 'SELECT music_playlist_featured_id  FROM '.$this->CFG['db']['tbl']['music_playlist_featured'].
						' WHERE playlist_id ='.$this->dbObj->Param('playlist_id').' AND user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist_id'], $this->CFG['user']['user_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if($row['music_playlist_featured_id'])
					return true;
				else
					return false;
			}

		/**
		 * viewPlaylist::chkPlaylistFavorite()
		 *
		 * @return
		 */
		public function chkPlaylistFavorite()
			{
				$sql = 'SELECT music_playlist_favorite_id  FROM '.$this->CFG['db']['tbl']['music_playlist_favorite'].
						' WHERE playlist_id ='.$this->dbObj->Param('playlist_id').' AND user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist_id'], $this->CFG['user']['user_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if($row['music_playlist_favorite_id'])
					return true;
				else
					return false;
			}



		/**
		 * viewPlaylist::addFeatured()
		 *
		 * @return
		 */
		public function addFeatured()
			{
				if($this->fields_arr['featured'] == 1)
					{
						//REMOVED OLD FEATURED PLAYLIST//
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_playlist_featured'].' '.
								'WHERE user_id='.$this->CFG['user']['user_id'];

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_db_error($this->dbObj);

						if($this->dbObj->Affected_Rows())
							{
								//UPDATE PLAYLIST TABLE//
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist'].' '.
										'SET total_featured  = total_featured - 1 '.' '.
										'WHERE playlist_id = '.$this->fields_arr['playlist_id'].' AND user_id='.$this->CFG['user']['user_id'];

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);
							}

						//INERT NEW ONE//
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_playlist_featured'].' '.
								'SET playlist_id = \''.$this->fields_arr['playlist_id'].'\', user_id=\''.$this->CFG['user']['user_id'].'\', '.
								'date_added=NOW()';

						$this->fields_arr['playlist_id'];
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_db_error($this->dbObj);

						if($this->dbObj->Insert_ID())
							{
								$featured = $this->dbObj->Insert_ID();
								//UPDATE PLAYLIST TABLE//
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist'].' '.
										'SET total_featured  = total_featured + 1 '.' '.
										'WHERE playlist_id = '.$this->fields_arr['playlist_id'].' AND user_id='.$this->CFG['user']['user_id'];

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$this->featured_msg = $this->LANG['viewplaylist_added_feature_msg'];

								//Start playlist featured Music playlist activity..
								$sql = 'SELECT mfe.music_playlist_featured_id, mfe.playlist_id, mfe.user_id as featured_user_id, u.user_name, v.playlist_name, v.user_id '.
										'FROM '.$this->CFG['db']['tbl']['music_playlist_featured'].' as mfe, '.$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['music_playlist'].' as v '.
										'WHERE u.user_id = mfe.user_id AND mfe.playlist_id =v.playlist_id AND mfe.music_playlist_featured_id = \''.$this->dbObj->Param('music_playlist_featured_id').'\'';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($featured));
								if (!$rs)
									trigger_db_error($this->dbObj);

								$row = $rs->FetchRow();
								$activity_arr = $row;
								$activity_arr['action_key']	= 'playlist_featured';
								if(empty($this->playlist_image_array))
									{
										$activity_arr['music_id'] = '';
										$activity_arr['music_server_url'] = '';
										$activity_arr['music_thumb_ext'] = '';
									}
								else
									{
										$activity_arr['music_id'] = $this->playlist_image_array['music_id'];
										$activity_arr['music_server_url'] = $this->playlist_image_array['music_server_url'];
										$activity_arr['music_thumb_ext'] = $this->playlist_image_array['music_thumb_ext'];
									}
								$playlistActivityObj = new MusicActivityHandler();
								$playlistActivityObj->addActivity($activity_arr);
								//end
							}
					}
				else
					{
						//Srart delete playlist featured playlist activity..
						$sql = 'SELECT mpf.music_playlist_featured_id, mpf.user_id as featured_user_id, pl.user_id '.
								' FROM '.$this->CFG['db']['tbl']['music_playlist_featured'].' as mpf, '.$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['music_playlist'].' as pl '.
								' WHERE u.user_id = mpf.user_id AND mpf.playlist_id = pl.playlist_id AND mpf.user_id = '.$this->dbObj->Param('user_id').' AND mpf.playlist_id = '.$this->dbObj->Param('playlist_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['playlist_id']));
						if (!$rs)
							trigger_db_error($this->dbObj);

						$row = $rs->FetchRow();
						if(!empty($row))
							{
								$activity_arr = $row;
								$activity_arr['action_key']	= 'delete_playlist_featured';
								$playlistActivityObj = new MusicActivityHandler();
								$playlistActivityObj->addActivity($activity_arr);
							}
						//end
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_playlist_featured'].' '.
								'WHERE playlist_id=\''.$this->fields_arr['playlist_id'].'\' AND user_id='.$this->CFG['user']['user_id'];

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_db_error($this->dbObj);

						//UPDATE PLAYLIST TABLE//
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist'].' '.
								'SET total_featured  = total_featured - 1 '.' '.
								'WHERE playlist_id = '.$this->fields_arr['playlist_id'].' AND user_id='.$this->CFG['user']['user_id'];

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_db_error($this->dbObj);

						$this->featured_msg = $this->LANG['viewplaylist_removed_feature_msg'];
					}

				return true;
			}

		/**
		 * viewPlaylist::addFavorite()
		 *
		 * @return
		 */
		public function addFavorite()
			{
				if($this->fields_arr['favorite'] == 1)
					{
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_playlist_favorite'].' '.
								'SET playlist_id = \''.$this->fields_arr['playlist_id'].'\', user_id=\''.$this->CFG['user']['user_id'].'\', '.
								'date_added=NOW()';

						$this->fields_arr['playlist_id'];
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_db_error($this->dbObj);

						if($this->dbObj->Insert_ID())
							{
								$favorite_id = $this->dbObj->Insert_ID();
								//UPDATE PLAYLIST TABLE//
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist'].' '.
										'SET total_favorites  = total_favorites + 1 '.' '.
										'WHERE playlist_id = '.$this->fields_arr['playlist_id'].' AND user_id='.$this->CFG['user']['user_id'];

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);

								//Srart Post playlist favorite playlist activity	..
								$sql = 'SELECT mpf.music_playlist_favorite_id, mpf.playlist_id, mpf.user_id as favorite_user_id, u.user_name, pl.playlist_name, pl.user_id'.
										' FROM '.$this->CFG['db']['tbl']['music_playlist_favorite'].' as mpf, '.$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['music_playlist'].' as pl '.
										' WHERE u.user_id = mpf.user_id AND mpf.playlist_id = pl.playlist_id AND mpf.music_playlist_favorite_id = \''.$this->dbObj->Param('favorite_id').'\'';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($favorite_id));
								if (!$rs)
									trigger_db_error($this->dbObj);

								$row = $rs->FetchRow();
								$activity_arr = $row;
								$activity_arr['action_key']	= 'playlist_favorite';
								if(empty($this->playlist_image_array))
									{
										$activity_arr['music_id'] = '';
										$activity_arr['music_server_url'] = '';
										$activity_arr['music_thumb_ext'] = '';
									}
								else
									{
										$activity_arr['music_id'] = $this->playlist_image_array['music_id'];
										$activity_arr['music_server_url'] = $this->playlist_image_array['music_server_url'];
										$activity_arr['music_thumb_ext'] = $this->playlist_image_array['music_thumb_ext'];
									}
								$playlistActivityObj = new MusicActivityHandler();
								$playlistActivityObj->addActivity($activity_arr);
								//end
						}
						$this->favorite_msg = $this->LANG['viewplaylist_added_favorite_msg'];
					}
				else
					{
						//Srart delete playlist favorite playlist activity..
						$sql = 'SELECT mpf.music_playlist_favorite_id, mpf.user_id as favorite_user_id, pl.user_id '.
								' FROM '.$this->CFG['db']['tbl']['music_playlist_favorite'].' as mpf, '.$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['music_playlist'].' as pl '.
								' WHERE u.user_id = mpf.user_id AND mpf.playlist_id = pl.playlist_id AND mpf.user_id = '.$this->dbObj->Param('user_id').' AND mpf.playlist_id = '.$this->dbObj->Param('playlist_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['playlist_id']));
						if (!$rs)
							trigger_db_error($this->dbObj);

						$row = $rs->FetchRow();
						$activity_arr = $row;
						$activity_arr['action_key']	= 'delete_playlist_favorite';
						$playlistActivityObj = new MusicActivityHandler();
						$playlistActivityObj->addActivity($activity_arr);
						//end

						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_playlist_favorite'].' '.
								'WHERE playlist_id=\''.$this->fields_arr['playlist_id'].'\' AND user_id='.$this->CFG['user']['user_id'];

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_db_error($this->dbObj);

						//UPDATE PLAYLIST TABLE//
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist'].' '.
								'SET total_favorites  = total_favorites - 1 '.' '.
								'WHERE playlist_id = '.$this->fields_arr['playlist_id'].' AND user_id='.$this->CFG['user']['user_id'];

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_db_error($this->dbObj);

						$this->favorite_msg = $this->LANG['viewplaylist_removed_favorite_msg'];
					}

				return true;
			}

		/**
		 * viewPlaylist::getPlaylistSongTotal()
		 *
		 * @return
		 */
		public function getPlaylistSongTotal()
			{
				$sql = 'SELECT count(music_in_playlist_id) as total '.
				 		'FROM '.$this->CFG['db']['tbl']['music_in_playlist'].' as mpl LEFT JOIN '.$this->CFG['db']['tbl']['music'].' as m ON mpl.music_id=m.music_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u, '.$this->CFG['db']['tbl']['music_album'].' AS ma '.
						'WHERE ma.music_album_id = m.music_album_id AND u.user_id = m.user_id AND m.music_status = \'Ok\' AND u.usr_status = \'Ok\' AND mpl.playlist_id = '.$this->fields_arr['playlist_id'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);
				 $row = $rs->FetchRow();
				return $row['total'];
			}
				//-----  RATING --//
		/**
		 * viewPlaylist::populateRatingImagesForAjax()
		 * purpose to populate images for rating
		 * @param $rating
		 * @return
		 **/
		public function populateRatingImagesForAjax($rating, $imagePrefix='')
			{
				$rating_total = $this->CFG['admin']['total_rating'];
				for($i=1;$i<=$rating;$i++)
					{
						?>
						<a onclick="return callAjaxRate('<?php echo $this->CFG['site']['music_url'].'viewPlaylist.php?ajax_page=true&page=rare&playlist_id='.$this->fields_arr['playlist_id'].'&'.'rate='.$i;?>&show=<?php echo $this->fields_arr['show'];?>', 'selRatingPlaylist')" onmouseover="ratingMusicMouseOver(<?php echo $i;?>, 'player')" onmouseout="ratingMusicMouseOut(<?php echo $i;?>)"><img id="img<?php echo $i;?>" src="<?php echo $this->CFG['site']['music_url'].'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-audioratehover1.gif'; ?>" alt="<?php echo $i;?>" title="<?php echo $i;?>" /></a>
						<?php
					}
				for($i=$rating;$i<$rating_total;$i++)
					{
						?>
						<a onclick="return callAjaxRate('<?php echo $this->CFG['site']['music_url'].'viewPlaylist.php?ajax_page=true&page=rare&playlist_id='.$this->fields_arr['playlist_id'].'&'.'rate='.($i+1);?>&amp;amp;show=<?php echo $this->fields_arr['show'];?>', 'selRatingPlaylist')" onmouseover="ratingMusicMouseOver(<?php echo ($i+1);?>, 'player')" onmouseout="ratingMusicMouseOut(<?php echo ($i+1);?>)"><img id="img<?php echo ($i+1);?>" src="<?php echo $this->CFG['site']['music_url'].'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-audiorate1.gif'; ?>" alt="<?php echo ($i+1);?>" title="<?php echo ($i+1);?>" /></a>
						 <?php
					}
			}

		/**
		 * viewPlaylist::getRating()
		 * purpose to getRating details of the particular user
		 * param $user_id
		 * @return
		 **/
		public function getRating($user_id)
			{
				$sql = 'SELECT rate FROM '.$this->CFG['db']['tbl']['music_playlist_rating'].
						' WHERE user_id='.$this->dbObj->Param('user_id').' AND'.
						' playlist_id='.$this->dbObj->Param('playlist_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id, $this->fields_arr['playlist_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						return $row['rate'];
					}
				return 0;
			}

		/**
		 * viewPlaylist::insertRating()
		 * purpose to insert the rating of user to table
		 * @return
		 **/
		public function insertRating()
			{
				if($this->fields_arr['rate'])
					{
						$rate_old = $this->chkAlreadyRated();
						$rate_new = $this->fields_arr['rate'];
						if($rate_new==1 && $rate_old==1)
						return true;

						if($rate_old > 0)
							{
								$rating_id = '';
								$diff = $rate_new - $rate_old;
								if($diff==0)
									return true;
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist_rating'].' SET'.
										' rate='.$this->dbObj->Param('rate').','.
										' date_added=NOW() '.
										' WHERE playlist_id='.$this->dbObj->Param('playlist_id').' AND '.
										' user_id='.$this->dbObj->Param('user_id');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['rate'], $this->fields_arr['playlist_id'], $this->CFG['user']['user_id']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);

								if($diff > 0)
									{
										$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist'].' SET'.
												' rating_total=rating_total+'.$diff.' '.
												' WHERE playlist_id='.$this->dbObj->Param('playlist_id');
									}
								else
									{
										$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist'].' SET'.
												' rating_total=rating_total'.$diff.' '.
												' WHERE playlist_id='.$this->dbObj->Param('playlist_id');
									}

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist_id']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);

								//Find rating for rating music playlist activity..
								$sql = 'SELECT rating_id '.
										'FROM '.$this->CFG['db']['tbl']['music_playlist_rating'].' '.
										' WHERE playlist_id='.$this->dbObj->Param('playlist_id').' AND '.
										' user_id='.$this->dbObj->Param('user_id');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist_id'],  $this->CFG['user']['user_id']));
								if (!$rs)
									trigger_db_error($this->dbObj);

								$row = $rs->FetchRow();
								$rating_id = $row['rating_id'];
							}
						else
							{
								$sql =  ' INSERT INTO '.$this->CFG['db']['tbl']['music_playlist_rating'].
										' (playlist_id, user_id, rate, date_added ) '.
										' VALUES ( '.
										$this->dbObj->Param('playlist_id').','.$this->dbObj->Param('user_id').','.$this->dbObj->Param('rate').',NOW()'.
										' ) ';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist_id'], $this->CFG['user']['user_id'], $this->fields_arr['rate']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);

								$rating_id = $this->dbObj->Insert_ID();

								$sql =  ' UPDATE '.$this->CFG['db']['tbl']['music_playlist'].' SET'.
										' rating_total=rating_total+'.$this->fields_arr['rate'].','.
										' rating_count=rating_count+1'.
										' WHERE playlist_id='.$this->dbObj->Param('playlist_id');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist_id']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);
							}

						//Srart Post music playlist rating playlist activity	..
						$sql = 'SELECT vr.rating_id, vr.playlist_id, vr.user_id as rating_user_id, vr.rate, u.user_name, v.playlist_name, v.user_id '.
								'FROM '.$this->CFG['db']['tbl']['music_playlist_rating'].' as vr, '.$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['music_playlist'].' as v '.
								' WHERE u.user_id = vr.user_id AND vr.playlist_id =v.playlist_id AND vr.rating_id = '.$this->dbObj->Param('rating_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($rating_id));
						if (!$rs)
							trigger_db_error($this->dbObj);

						$row = $rs->FetchRow();
						$activity_arr = $row;
						$activity_arr['action_key']	= 'playlist_rated';
						if(empty($this->playlist_image_array))
							{
								$activity_arr['music_id'] = '';
								$activity_arr['music_server_url'] = '';
								$activity_arr['music_thumb_ext'] = '';
							}
						else
							{
								$activity_arr['music_id'] = $this->playlist_image_array['music_id'];
								$activity_arr['music_server_url'] = $this->playlist_image_array['music_server_url'];
								$activity_arr['music_thumb_ext'] = $this->playlist_image_array['music_thumb_ext'];
							}
						$playlistActivityObj = new MusicActivityHandler();
						$playlistActivityObj->addActivity($activity_arr);
						//end
					}
			}

		/**
		 * viewPlaylist::getTotalRatingImage()
		 * purpose to populate rating images based on the rating of the viewPlaylist
		 * @return
		 **/
		public function getTotalRatingImage()
			{
				if($this->populatePlaylistDetails())
					{
						//$rating = round($this->fields_arr['rating_total']/$this->fields_arr['rating_count'],0);
						$this->populateRatingImagesForAjax($this->fields_arr['rate']);
						echo '<span>('.$this->fields_arr['rating_count'].' '.$this->LANG['viewplaylist_rating'].')</span>';
					}
			}
		/**
		 * viewPlaylist::populatePlaylistDetails()
		 * purpose to populate viewPlaylist list details
		 * @return
		 **/
		public function populatePlaylistDetails()
			{
				$sql = 'SELECT rating_total, rating_count FROM '.$this->CFG['db']['tbl']['music_playlist'].
						' WHERE playlist_id='.$this->dbObj->Param('playlist_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->fields_arr['rating_total'] = $row['rating_total'];
						$this->fields_arr['rating_count'] = $row['rating_count'];
						return true;
					}
				return false;
			}

		/**
		 * viewPlaylist::chkAlreadyRated()
		 * purpose to check the playlist is already rated or not
		 * @return
		 **/
		public function chkAlreadyRated()
			{
				$sql = 'SELECT rate FROM '.$this->CFG['db']['tbl']['music_playlist_rating'].
						' WHERE user_id='.$this->dbObj->Param('user_id').' AND'.
						' playlist_id='.$this->dbObj->Param('playlist_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['playlist_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					return $row['rate'];
				return false;
			}
		//COMMENT//

		/**
		 * viewPlaylist::getEditCommentBlock()
		 *
		 * @return
		 */
		public function getEditCommentBlock()
			{

				global $smartyObj;
				$replyBlock['comment_id']=$this->fields_arr['comment_id'];
				$replyBlock['name']='addEdit_';
				$replyBlock['sumbitFunction']='addToEdit';
				$replyBlock['cancelFunction']='discardEdit';
				$replyBlock['editReplyUrl']=$this->CFG['site']['music_url'].'viewPlaylist.php?ajax_page=true&amp;page=update_comment&amp;playlist_id='.$this->fields_arr['playlist_id'].'&vpkey='.$this->fields_arr['vpkey'].'&show='.$this->fields_arr['show'];
				$smartyObj->assign('commentEditReply', $replyBlock);
				setTemplateFolder('general/','music');
				$smartyObj->display('commentEditReplyBlock.tpl');

			}

		/**
		 * viewPlaylist::deleteComment()
		 * purpose to delete the Comment of the playlist
		 * @return
		 */
		public function deleteComment()
			{
				$sql = 'SELECT playlist_id,playlist_comment_main_id FROM '.$this->CFG['db']['tbl']['music_playlist_comments'].' WHERE'.
						' playlist_comment_id='.$this->dbObj->Param('playlist_comment_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_playlist_comments'].
						' WHERE playlist_comment_id='.$this->dbObj->Param('playlist_comment_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				// DELETE REPLAY //
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_playlist_comments'].
						' WHERE playlist_comment_main_id='.$this->dbObj->Param('playlist_comment_main_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row['playlist_comment_main_id']==0)
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist'].' SET total_comments = total_comments-1'.
								' WHERE playlist_id='.$this->dbObj->Param('playlist_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($row['playlist_id']));
						    if (!$rs)
							    trigger_db_error($this->dbObj);

					}
				$this->populateCommentOptionsPlaylist();
				$this->populateCommentOfThisPlaylist($menu_coded_manually=true);
			}

		/**
		 * viewPlaylist::populateReply()
		 *
		 * @param mixed $comment_id
		 * @return
		 */
		public function populateReply($comment_id)
			{
				$populateReply_arr = array();
				$sql = 'SELECT playlist_comment_id, comment_user_id,'.
						' comment, TIMEDIFF(NOW(), date_added) as pc_date_added,'.
						' TIME_TO_SEC(TIMEDIFF(NOW(), date_added)) AS date_edit'.
						' FROM '.$this->CFG['db']['tbl']['music_playlist_comments'].
						' WHERE comment_status= \'Yes\' AND playlist_id='.$this->dbObj->Param('playlist_id').' AND'.
						' playlist_comment_main_id='.$this->dbObj->Param('playlist_comment_main_id').
						' ORDER BY playlist_comment_id DESC';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist_id'], $comment_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$populateReply_arr['row'] = array();
				$populateReply_arr['rs_PO_RecordCount'] = $rs->PO_RecordCount();
				if($rs->PO_RecordCount())
					{
						$inc = 0;
						while($row = $rs->FetchRow())
							{
								$user_name = $this->getUserDetail('user_id', $row['comment_user_id'], 'user_name');
								$populateReply_arr['s_attribute'] = isset($icondetail['icon']['s_attribute'])?$icondetail['icon']['s_attribute']:'';
								$populateReply_arr['row'][$inc]['name'] = $user_name;
								$populateReply_arr['row'][$inc]['icon'] = getMemberAvatarDetails($row['comment_user_id']);
								$populateReply_arr['row'][$inc]['memberProfileUrl'] = getMemberProfileUrl($row['comment_user_id'], $user_name);

								$row['pc_date_added'] = getTimeDiffernceFormat($row['pc_date_added']);
								$row['comment'] = $row['comment'];
								$populateReply_arr['row'][$inc]['record'] = $row;

								$populateReply_arr['row'][$inc]['class'] = 'clsNotEditable';
								if($row['comment_user_id']==$this->CFG['user']['user_id'])
									{
										$time = $this->CFG['admin']['musics']['comment_edit_allowed_time'] - $row['date_edit'];
										if($time>2)
											{
												$populateReply_arr['row'][$inc]['class'] = 'clsEditable';
											}
									}

								$populateReply_arr['row'][$inc]['comment_memberProfileUrl'] = getMemberProfileUrl($row['comment_user_id'], $user_name);
								$temp_reply = nl2br(makeClickableLinks($row['comment']));
								$populateReply_arr['row'][$inc]['comment_makeClickableLinks'] = $temp_reply;


								if(isMember() AND $row['comment_user_id'] == $this->CFG['user']['user_id'])
									{
										$populateReply_arr['row'][$inc]['time'] = $this->CFG['admin']['musics']['comment_edit_allowed_time']-$row['date_edit'];
										if($populateReply_arr['row'][$inc]['time'] > 2)
											{
												$this->enabled_edit_fields[$row['playlist_comment_id']] = $populateReply_arr['row'][$inc]['time'];
											}
									}
								$inc++;
							}
					}
				return $populateReply_arr;
			}

		/**
		 * viewPlaylist::getCaptchaText()
		 * purpose to getcaptcha text
		 * @return
		 */
		public function getCaptchaText()
			{
				$captcha_length = 5;
				$this->captchaText = rand(pow(10, $captcha_length-1), pow(10, $captcha_length)-1);
				return $this->captchaText;
			}

		/**
		 * viewPlaylist::getCommentsBlock()
		 *
		 * @return
		 */
		public function getCommentsBlock()
			{

				global $smartyObj;
				$getCommentsBlock_arr = array();
				if($this->CFG['admin']['musics']['captcha'] and $this->CFG['admin']['musics']['captcha_method']=='image')
					{
						$getCommentsBlock_arr['captcha_comment_url'] = $this->CFG['site']['url'].'captchaComment.php?captcha_key=playlistcomment&amp;captcha_value='.$this->getCaptchaText();
					}
				$smartyObj->assign('getCommentsBlock_arr', $getCommentsBlock_arr);
				setTemplateFolder('general/', 'music');
				$smartyObj->display('getCommentsBlock.tpl');
			}

		/**
		 * viewPlaylist::getTotalComments()
		 * purpose to get Total Comments og this playlisr
		 * @return
		 */
		public function getTotalComments()
			{
				$sql = 'SELECT total_comments FROM '.$this->CFG['db']['tbl']['music_playlist'].
						' WHERE playlist_id='.$this->dbObj->Param('playlist_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $this->fields_arr['total_comments'] = $row['total_comments']?$row['total_comments']:0;
			}

		/**
		 * viewPlaylist::populateCommentOptionsPlaylist()
		 * purpose to populate Comment options for the Playlist
		 * purpose to populate Comment options for the Playlist
		 * @return
		 */
		public function populateCommentOptionsPlaylist()
			{
				$this->CFG['admin']['musics']['playlisttotal_comments']=$this->fields_arr['show']=='all'?'100000':$this->CFG['admin']['musics']['playlisttotal_comments'];
				$sql = 'SELECT vc.playlist_comment_id, vc.comment_user_id,'.
						' vc.comment, TIMEDIFF(NOW(), vc.date_added) as pc_date_added,'.
						' TIME_TO_SEC(TIMEDIFF(NOW(), vc.date_added)) AS date_edit'.
						' FROM '.$this->CFG['db']['tbl']['music_playlist_comments'].' AS vc'.
						' WHERE vc.playlist_id='.$this->dbObj->Param('playlist_id').' AND'.
						' vc.playlist_comment_main_id=0 AND'.
						' vc.comment_status=\'Yes\' ORDER BY vc.playlist_comment_id DESC LIMIT '.$this->CFG['admin']['musics']['playlisttotal_comments'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$total_comments = $rs->PO_RecordCount();
				$this->fields_arr['total_comments'] = $this->getTotalComments();
				$this->comment_approval = 0;
				if(isMember())
					{
						$this->commentUrl = $this->CFG['site']['music_url'].'viewPlaylist.php?type=add_comment&playlist_id='.$this->getFormField('playlist_id');
					}
				else
					{
						$this->commentUrl =getUrl('viewplaylist', '?mem_auth=true&playlist_id='.$this->fields_arr['playlist_id'].'&title='.$this->changeTitle($this->fields_arr['playlist_name']), $this->fields_arr['playlist_id'].'/'.$this->changeTitle($this->fields_arr['playlist_name']).'/?mem_auth=true', 'members', 'music');
					}
				if($this->getFormField('allow_comments')=='Kinda')
					{
						$this->comment_approval = 0;
						if($this->fields_arr['user_id'] == $this->CFG['user']['user_id'])
							$this->comment_approval = 1;
					}
				else if($this->getFormField('allow_comments')=='Yes')
					{
						$this->comment_approval = 1;
					}
				else if($this->getFormField('allow_comments')=='No')
					{
						$this->setPageBlockHide('playlist_comments_block');
					}
		}


		/**
		 * viewPlaylist::populateCommentOfThisPlaylist()
		 *
		 * @return
		 */
		public function populateCommentOfThisPlaylist()
			{
				global $smartyObj;
				$populateCommentOfThisPlaylist_arr = array();


				$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist_comments'].' AS vc', $this->CFG['db']['tbl']['users'].' AS u'));
                $this->setReturnColumns(array('vc.playlist_comment_id', 'vc.comment_user_id', 'vc.comment', 'TIMEDIFF(NOW(), vc.date_added) as pc_date_added', 'TIME_TO_SEC(TIMEDIFF(NOW(), vc.date_added)) AS date_edit'));
                $this->sql_condition = 'vc.playlist_id=\''.$this->fields_arr['playlist_id'].'\' AND vc.playlist_comment_main_id=0 AND u.user_id=vc.comment_user_id AND u.usr_status=\'Ok\' AND vc.comment_status=\'Yes\'';
                $this->sql_sort = 'vc.playlist_comment_id DESC';

			    /**
			     * ***** navigtion continue********
			     */
			    $this->buildSelectQuery();
			    $this->buildQuery();
			    $this->executeQuery();
			    /**
			     * ****** Navigation End *******
			     */
				$paging_arr = array();
			    $smartyObj->assign('paging_arr', $paging_arr);


				$populateCommentOfThisPlaylist_arr['comment_approval'] = 0;
				if($this->getFormField('allow_comments')=='Kinda')
					{
						$populateCommentOfThisPlaylist_arr['comment_approval'] = 0;
						if(!isMember())
							{
								$populateCommentOfThisPlaylist_arr['approval_url'] = getUrl('viewplaylist', '?playlist_id='.$this->fields_arr['playlist_id'].'&amp;title='.$this->changeTitle($this->fields_arr['playlist_name']), $this->fields_arr['playlist_name'].'/'.$this->changeTitle($this->fields_arr['playlist_name']).'/', 'members', 'music');
							}
					}
				else if($this->getFormField('allow_comments')=='Yes')
					{
						$populateCommentOfThisPlaylist_arr['comment_approval'] = 1;
						if(!isMember())
							{
								$populateCommentOfThisPlaylist_arr['post_comment_url'] = getUrl('viewplaylist', '?playlist_id='.$this->fields_arr['playlist_id'].'&amp;title='.$this->changeTitle($this->fields_arr['playlist_name']), $this->fields_arr['playlist_id'].'/'.$this->changeTitle($this->fields_arr['playlist_name']).'/', 'members', 'music');
							}
					}

				$populateCommentOfThisPlaylist_arr['row'] = array();
				if($this->isResultsFound())
					{
						$this->fields_arr['ajaxpaging'] = 1;
						$populateCommentOfThisPlaylist_arr['hidden_arr'] = array('start', 'ajaxpaging');
						$smartyObj->assign('smarty_paging_list', $this->populatePageLinksPOSTViaAjax($this->getFormField('start'), 'frmMusicComments', 'selCommentBlock'));
						$this->fields_arr['total_comments'] = (isset($this->fields_arr['total_comments']) and $this->fields_arr['total_comments'])?$this->fields_arr['total_comments']:$this->getTotalComments();


						$inc = 0;
						while($row = $this->fetchResultRecord())
							{
								$user_name = $this->getUserDetail('user_id', $row['comment_user_id'], 'user_name');
								$populateCommentOfThisPlaylist_arr['row'][$inc]['name'] = $user_name;
								$populateCommentOfThisPlaylist_arr['row'][$inc]['icon'] = getMemberAvatarDetails($row['comment_user_id']);
								$populateCommentOfThisPlaylist_arr['row'][$inc]['memberProfileUrl'] = getMemberProfileUrl($row['comment_user_id'], $user_name);

								$row['pc_date_added'] = getTimeDiffernceFormat($row['pc_date_added']);

								$populateCommentOfThisPlaylist_arr['row'][$inc]['class'] = 'clsNotEditable';
								if($row['comment_user_id']==$this->CFG['user']['user_id'])
									{
										$time = $this->CFG['admin']['musics']['comment_edit_allowed_time']-$row['date_edit'];
										if($time>2)
											{
												$populateCommentOfThisPlaylist_arr['row'][$inc]['class'] = "clsEditable";
											}
									}
								$row['comment'] = $row['comment'];
								$populateCommentOfThisPlaylist_arr['row'][$inc]['record'] = $row;
								$populateCommentOfThisPlaylist_arr['row'][$inc]['reply_url']= $this->CFG['site']['music_url'].'viewPlaylist.php?playlist_id='.$this->getFormField('playlist_id').'&vpkey='.$this->getFormField('vpkey').'&show='.$this->getFormField('show').'&comment_id='.$row['playlist_comment_id'].'&type=comment_reply';

								$populateCommentOfThisPlaylist_arr['row'][$inc]['comment_member_profile_url'] = getMemberProfileUrl($row['comment_user_id'], $user_name);
								$temp_comment = nl2br(makeClickableLinks($row['comment']));
								$populateCommentOfThisPlaylist_arr['row'][$inc]['makeClickableLinks'] = $temp_comment;
								if(isMember() and $row['comment_user_id']==$this->CFG['user']['user_id'])
									{
										$populateCommentOfThisPlaylist_arr['row'][$inc]['time'] = $this->CFG['admin']['musics']['comment_edit_allowed_time']-$row['date_edit'];
										if($populateCommentOfThisPlaylist_arr['row'][$inc]['time'] > 2)
											{
												$this->enabled_edit_fields[$row['playlist_comment_id']] = $populateCommentOfThisPlaylist_arr['row'][$inc]['time'];
											}
									}
								else
									{
										if(!isMember())
											{
												$populateCommentOfThisPlaylist_arr['row'][$inc]['comment_reply_url'] = getUrl('viewplaylist', '?playlist_id='.$this->fields_arr['playlist_id'].'&amp;title='.$this->changeTitle($this->fields_arr['playlist_name']), $this->fields_arr['playlist_id'].'/'.$this->changeTitle($this->fields_arr['playlist_name']).'/', 'members', 'music');
											}
									}
								$populateCommentOfThisPlaylist_arr['row'][$inc]['populateReply_arr'] = $this->populateReply($row['playlist_comment_id']);
								$inc++;
							} //while

						if($this->fields_arr['total_comments']>$this->CFG['admin']['musics']['playlisttotal_comments'])
							{
						  		$populateCommentOfThisPlaylist_arr['view_all_comments_url'] = getUrl('viewplaylist', '?playlist_id='.$this->fields_arr['playlist_id'].'&amp;title='.$this->changeTitle($this->fields_arr['playlist_name']).'&amp;vpkey='.$this->fields_arr['vpkey'].'&amp;show=all', $this->fields_arr['playlist_id'].'/'.$this->changeTitle($this->fields_arr['playlist_name']).'/?vpkey='.$this->fields_arr['vpkey'].'&amp;show=all', '', 'music');
								$populateCommentOfThisPlaylist_arr['view_all_comments'] = sprintf($this->LANG['view_all_comments'],'<span id="total_comments2">'.$this->fields_arr['total_comments'].'</span>');

						  	}
					}
				$smartyObj->assign('populateCommentOfThisPlaylist_arr', $populateCommentOfThisPlaylist_arr);
				setTemplateFolder('general/', 'music');
				$smartyObj->display('populateCommentOfThisPlaylist.tpl');
			}

		/**
		 * viewPlaylist::insertCommentAndPlaylistTable()
		 *
		 * @return
		 **/
		public function insertCommentAndPlaylistTable()
			{
				$sql = 'SELECT allow_comments FROM '.$this->CFG['db']['tbl']['music_playlist'].
						' WHERE playlist_id='.$this->dbObj->Param('playlist_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$this->fields_arr['allow_comments'] = $row['allow_comments'];
				$comment_status = 'Yes';
				//IF PLAYLIST OWNER POST COMMENT THEN WE DISPLAY COMMENTS WITHOUT APPROVAL//
				if($row['allow_comments']=='Kinda' and $this->CFG['user']['user_id']!=$this->fields_arr['user_id'])
					$comment_status = 'No';

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_playlist_comments'].' SET'.
						' playlist_id='.$this->dbObj->Param('playlist_id').','.
						' playlist_comment_main_id='.$this->dbObj->Param('playlist_comment_main_id').','.
						' comment_user_id='.$this->dbObj->Param('comment_user_id').','.
						' comment='.$this->dbObj->Param('comment').','.
						' comment_status='.$this->dbObj->Param('comment_status').','.
						' date_added=NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist_id'], $this->fields_arr['comment_id'], $this->CFG['user']['user_id'], $this->fields_arr['f'], $comment_status));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$next_id = $this->dbObj->Insert_ID();
				if($next_id and $comment_status=='Yes' and (!$this->fields_arr['comment_id']))
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist'].' SET total_comments = total_comments+1'.
								' WHERE playlist_id='.$this->dbObj->Param('playlist_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist_id']));
						    if (!$rs)
							    trigger_db_error($this->dbObj);
					}

				//Start playlist comment activity..
				$sql = 'SELECT plc.playlist_comment_id, plc.playlist_id, plc.comment_user_id, u.user_name, pl.playlist_name, pl.user_id '.
						'FROM '.$this->CFG['db']['tbl']['music_playlist_comments'].' as plc, '.$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['music_playlist'].' as pl '.
						' WHERE u.user_id = plc.comment_user_id AND pl.playlist_id =plc.playlist_id AND plc.playlist_comment_id = \''.$this->dbObj->Param('next_id').'\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($next_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$activity_arr = $row;
				$activity_arr['action_key']	= 'playlist_comment';
				if(empty($this->playlist_image_array))
					{
						$activity_arr['music_id'] = '';
						$activity_arr['music_server_url'] = '';
						$activity_arr['music_thumb_ext'] = '';
					}
				else
					{
						$activity_arr['music_id'] = $this->playlist_image_array['music_id'];
						$activity_arr['music_server_url'] = $this->playlist_image_array['music_server_url'];
						$activity_arr['music_thumb_ext'] = $this->playlist_image_array['music_thumb_ext'];
					}
				$playlistActivityObj = new MusicActivityHandler();
				$playlistActivityObj->addActivity($activity_arr);
				//end

				//echo $next_id;
				//echo '***--***!!!';
				$this->populateCommentOptionsPlaylist();
				$this->populateCommentOfThisPlaylist($menu_coded_manually=true);
				//echo '***--***!!!';
				echo $this->captchaText;
			}

		/**
		 * viewPlaylist::updateCommentAndPlaylistTable()
		 *
		 * @return
		 **/
		public function updateCommentAndPlaylistTable()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist_comments'].' SET'.
						' comment='.$this->dbObj->Param('comment').
						' WHERE playlist_comment_id='.$this->dbObj->Param('playlist_comment_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['f'], $this->fields_arr['comment_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				return true;
			}

		/**
		 * viewPlaylist::getComment()
		 *
		 * @return
		 **/
		public function getComment()
			{
				$sql = 'SELECT comment FROM '.$this->CFG['db']['tbl']['music_playlist_comments'].' WHERE'.
						' playlist_comment_id='.$this->dbObj->Param('playlist_comment_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						return $row['comment'];
					}
			}

		/**
		 * viewPlaylist::getFeaturedStatus()
		 *
		 * @return
		 */
		public function getFeaturedStatus()
			{
				$sql = 'SELECT music_playlist_featured_id FROM '.$this->CFG['db']['tbl']['music_playlist_featured'].' WHERE'.
						' user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					return true;
				return false;
			}

		/**
		 * viewPlaylist::chkCaptcha()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkCaptcha($field_name, $err_tip='')
			{
				if ($this->fields_arr["recaptcha_response_field"])
					{
		        		$resp = recaptcha_check_answer ($this->CFG['captcha']['private_key'],
					 					$_SERVER["REMOTE_ADDR"],
					 					$this->fields_arr["recaptcha_challenge_field"],
										$this->fields_arr["recaptcha_response_field"]);

			        	if ($resp->is_valid)
						 	{
	                			return true;
			                }
						else
							{
							    echo 'ERR~'.$err_tip;
								exit;
							}
					}

			}

		/**
		 * viewPlaylist::chkIsNotEmpty()
		 *
		 * @param mixed $field_name
		 * @param string $err_tip
		 * @return
		 */
		public function chkIsCaptchaNotEmpty($field_name, $err_tip='')
			{
				$is_ok = (is_string($this->fields_arr[$field_name])) ?
								($this->fields_arr[$field_name]!='') : (!empty($this->fields_arr[$field_name]));
				if (!$is_ok)
					{
						echo 'ERR~'.$err_tip;
						exit;
					}
				return $is_ok;
			}

		/**
		 * viewPlaylist::checkSameUserInComment()
		 *
		 * @param srting $err_msg
		 * @param boolean $chk_playlist_owner
		 *
		 * @return boolean
		 */
		public function checkSameUserInComment($err_msg, $chk_playlist_owner = false)
		{
			if($chk_playlist_owner)
			{
				$playlist_owner_status = ($this->fields_arr['user_id'] == $this->CFG['user']['user_id'])?1:0;
				if($playlist_owner_status)
				{
					return $playlist_owner_status;
				}
			}

			$sql = 'SELECT playlist_comment_id FROM '.$this->CFG['db']['tbl']['music_playlist_comments'].
					' WHERE playlist_id = '.$this->dbObj->Param('playlist_id').
					' AND comment_user_id = '.$this->dbObj->Param('comment_user_id').
					' AND playlist_comment_id = '.$this->dbObj->Param('playlist_comment_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist_id'], $this->CFG['user']['user_id'], $this->fields_arr['comment_id']));
			if (!$rs)
				trigger_db_error($this->dbObj);

			$row = $rs->FetchRow();

			if($row['playlist_comment_id'] != '')
			{
				return true;
			}
			else
			{
				echo $err_msg;
				echo 'ERR~';
				exit;
			}
		}

		/**
		 * viewPlaylist::populatePlaylist()
		 * playlist details will be passed to tpl
		 *
		 * @return void
		 */
		public function populatePlaylist()
		{
			global $smartyObj;
			$playlist_info = array();
			$playlist_info['playlistUrl']=$this->CFG['site']['music_url'].'viewPlaylist.php?ajax_page=true&page=playlist';
			$this->playlist_name_notes = str_replace('VAR_MIN', $this->CFG['fieldsize']['music_playlist_name']['min'], $this->LANG['playlist_name_notes']);
			$this->playlist_name_notes = str_replace('VAR_MAX', $this->CFG['fieldsize']['music_playlist_name']['max'], $this->playlist_name_notes);
			$this->playlist_tags_notes = str_replace('VAR_MIN', $this->CFG['fieldsize']['music_playlist_tags']['min'], $this->LANG['playlist_tags_notes']);
			$this->playlist_tags_notes = str_replace('VAR_MAX', $this->CFG['fieldsize']['music_playlist_tags']['max'], $this->playlist_tags_notes);
			$this->getPlaylistIdInMusic($this->getFormField('song_id'));
			$this->displayCreatePlaylistInterface();
			$smartyObj->assign('playlist_info', $playlist_info);
			$smartyObj->assign('playlist_option', 'playlist');
			setTemplateFolder('general/','music');
			$smartyObj->display('getPlaylist.tpl');
		}


	}
//<<<<<-------------- Class viewPlaylist end ---------------//
//-------------------- Code begins -------------->>>>>//
$viewPlaylist = new viewPlaylist();
if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$viewPlaylist->setPageBlockNames(array('playlist_information_block', 'share_playlist_block', 'playlist_features_block',
										'playlist_songlist_block', 'block_add_comments', 'playlist_comments_block',
										'add_reply', 'block_playlist_player'));
$viewPlaylist->setAllPageBlocksHide();
$viewPlaylist->setFormField('playlist_id', '');
$viewPlaylist->setFormField('action', '');
$viewPlaylist->setFormField('page', '');
$viewPlaylist->setFormField('allow_comments', 'Yes');
$viewPlaylist->setFormField('allow_ratings', 'Yes');
$viewPlaylist->setFormField('allow_embed', 'Yes');
$viewPlaylist->setFormField('song_id', '');
$viewPlaylist->setFormField('playlist_description', '');
$viewPlaylist->setFormField('playlist_tags', '');
$viewPlaylist->setFormField('playlist_name', '');
$viewPlaylist->setFormField('play_list', '');
$viewPlaylist->setFormField('playlist_access_type', 'Public');
$viewPlaylist->setFormField('playlist', '');
$viewPlaylist->setFormField('featured', '');
$viewPlaylist->setFormField('favorite', '');
$viewPlaylist->setFormField('email_to', '');
$viewPlaylist->setFormField('personal_msg', '');
$viewPlaylist->setFormField('start', 0);
$viewPlaylist->setFormField('numpg', 3);
$viewPlaylist->setFormField('show', 1);
$viewPlaylist->setFormField('rating_count', '');
$viewPlaylist->setFormField('rate', '');
$viewPlaylist->setFormField('type', '');
$viewPlaylist->setFormField('vpkey', '');
$viewPlaylist->setFormField('comment_id', '');
$viewPlaylist->setFormField('comment_id',0);
$viewPlaylist->setFormField('f',0);
$viewPlaylist->setFormField('user_id', '');
$viewPlaylist->setFormField('music_id', '');
$viewPlaylist->setFormField('recaptcha_challenge_field', '');
$viewPlaylist->setFormField('recaptcha_response_field', '');
$viewPlaylist->sanitizeFormInputs($_REQUEST);

//START TO GENERATE THE PLAYLIST PLAYER ARRAY FIELDS
$auto_play =  'false';
if($CFG['admin']['musics']['playlist_player']['PlaylistPlayerAutoPlay'])
	$auto_play =  'true';

$playlist_auto_play =  false;
if($CFG['admin']['musics']['playlist_player']['PlaylistAutoPlay'])
	$playlist_auto_play =  true;

$music_fields = array(
	'div_id'               => 'view_playlist',
	'music_player_id'      => 'view_playlist_player',
	'width'  		       => '598',
	'height'               => '174',
	'auto_play'            => $auto_play,
	'hidden'               => false,
	'playlist_auto_play'   => $playlist_auto_play,
	'javascript_enabled'   => false,
	'informCSSWhenPlayerReady' => true
);

$smartyObj->assign('music_fields',$music_fields);
//END TO GENERATE THE PLAYLIST PLAYER ARRAY FIELDS

//CHECK isValidMusicPlayListID//
$viewPlaylist->is_not_member_url = getUrl('viewplaylist','?mem_auth=true&playlist_id='.$viewPlaylist->getFormField('playlist_id').'&amp;title='.$viewPlaylist->changeTitle($viewPlaylist->getFormField('playlist_name')), $viewPlaylist->getFormField('playlist_id').'/'.$viewPlaylist->changeTitle($viewPlaylist->getFormField('playlist_name')).'/?mem_auth=true', 'members','music');

if(!isMember())
	$viewPlaylist->savePlaylistUrl = $viewPlaylist->is_not_member_url;
else
	$viewPlaylist->savePlaylistUrl = $CFG['site']['music_url'].'createPlaylist.php?action=save_playlist&light_window=1';
if(!isAjaxPage())
	{
		if($viewPlaylist->getFormField('playlist_id')!='')
			{
				if($viewPlaylist->isValidMusicPlayListID())
					{
						$viewPlaylist->setPageBlockShow('playlist_information_block');
						$viewPlaylist->setPageBlockShow('playlist_features_block');
						$viewPlaylist->setPageBlockShow('playlist_songlist_block');
						$viewPlaylist->setPageBlockShow('share_playlist_block');
						$viewPlaylist->setPageBlockShow('playlist_comments_block');
						$viewPlaylist->setPageBlockShow('block_playlist_player');

						//Initializing Playlist Player Configuaration
						$viewPlaylist->populatePlayerWithPlaylistConfiguration();
						$viewPlaylist->configXmlcode_url .= 'pg=music_'.$viewPlaylist->getFormField('playlist_id');
						$viewPlaylist->playlistXmlcode_url .= 'pg=music_'.$viewPlaylist->getFormField('playlist_id');

						//UPDATE PLAYLIST VIEWED TABLE FOR MOST VIEWED PLAYLIST//
						$viewPlaylist->updatePlaylistViewedTable();
						$viewPlaylist->populateCommentOptionsPlaylist();
						//PLAYLIST COMMENT//
						if($viewPlaylist->getFormField('type')=='add_comment')
							{
								$viewPlaylist->setPageBlockShow('block_add_comments');
							}
						if($viewPlaylist->getFormField('type')=='comment_reply')
							{
								$viewPlaylist->setPageBlockShow('block_add_comments');
							}

						if(!isMember())
							$viewPlaylist->relatedUrl		= $CFG['site']['music_url'].'viewPlaylist.php';
						else
							$viewPlaylist->relatedUrl		= $CFG['site']['music_url'].'viewPlaylist.php';
					}
				else
					{
						$viewPlaylist->setAllPageBlocksHide();
						$viewPlaylist->setCommonErrorMsg($LANG['viewplaylist_invalid_id_err_tip']);
						$viewPlaylist->setPageBlockShow('block_msg_form_error');
					}
			}
		else
			{
				$viewPlaylist->setAllPageBlocksHide();
				$viewPlaylist->setCommonErrorMsg($LANG['viewplaylist_invalid_id_err_tip']);
				$viewPlaylist->setPageBlockShow('block_msg_form_error');
			}
		if($viewPlaylist->getFormField('action')!='')
		{
			switch($viewPlaylist->getFormField('action'))
			{
				case 'delete':
					if(!isMember())
					{
						$login_msg = '<a href="'.$viewPlaylist->is_not_member_url.'">'.$viewPlaylist->LANG['common_login_click_here'].'</a>';
						$login_err_msg = str_replace('VAR_CLICK_HERE', $login_msg, $viewPlaylist->LANG['common_login_err_msg']);
						$viewPlaylist->setCommonErrorMsg($login_err_msg);
						$viewPlaylist->setPageBlockShow('block_msg_form_error');
					}
					else if($viewPlaylist->getFormField('user_id') != $CFG['user']['user_id'])
					{
						$viewPlaylist->setCommonErrorMsg($LANG['viewplaylist_other_user_playlist_song_delete_err_msg']);
						$viewPlaylist->setPageBlockShow('block_msg_form_error');
					}
					else
					{
						$viewPlaylist->deleteSongFromPlaylist();
						$viewPlaylist->setCommonSuccessMsg($LANG['viewplaylist_delete_successfully']);
						$viewPlaylist->setPageBlockShow('block_msg_form_success');
					}
					break;
			}
		}
}
if(isAjax())
	{
		$viewPlaylist->isValidMusicPlayListID();
		$viewPlaylist->includeAjaxHeaderSessionCheck();
		$viewPlaylist->sanitizeFormInputs($_REQUEST);

		if ($viewPlaylist->getFormField('action')=='popplaylist')
	    {
	    	$viewPlaylist->checkLoginStatusInAjax($viewPlaylist->is_not_member_url);
			$viewPlaylist->populatePlaylist();
			die();
	    }


		if ($viewPlaylist->isPageGETed($_POST, 'ajaxpaging'))
	    {
			$viewPlaylist->populateCommentOfThisPlaylist();
			ob_end_flush();
			die();
	    }


		if($viewPlaylist->getFormField('page') != '')
			{
				switch ($viewPlaylist->getFormField('page'))
					{
						case 'featured':
							$viewPlaylist->checkLoginStatusInAjax($viewPlaylist->is_not_member_url);
							$viewPlaylist->addFeatured();
							echo $viewPlaylist->featured_msg;
							exit;
						break;

						case 'favorite':
							$viewPlaylist->checkLoginStatusInAjax($viewPlaylist->is_not_member_url);
							$viewPlaylist->addFavorite();
							echo $viewPlaylist->favorite_msg;
							exit;
						break;

						case 'pagenation':
							$viewPlaylist->setPageBlockShow('playlist_songlist_block');
							$viewPlaylist->displayPlaylistSong(true);
							exit;
						break;

						case 'rare':
							$viewPlaylist->checkLoginStatusInAjax($viewPlaylist->is_not_member_url);
							$viewPlaylist->insertRating();
							$viewPlaylist->getTotalRatingImage();
						break;

						case 'post_comment':
							$viewPlaylist->checkLoginStatusInAjax($viewPlaylist->is_not_member_url);
							if($CFG['admin']['musics']['captcha'] AND $CFG['admin']['musics']['captcha_method'] == 'recaptcha'
										AND $CFG['captcha']['public_key'] AND $CFG['captcha']['private_key'])
								{
									$viewPlaylist->chkIsCaptchaNotEmpty('recaptcha_response_field', $LANG['common_err_tip_compulsory']) AND
										$viewPlaylist->chkCaptcha('recaptcha_response_field', $LANG['common_err_tip_invalid_captcha']);
								}
							$viewPlaylist->setAllPageBlocksHide();
							$htmlstring = trim(urldecode($viewPlaylist->getFormField('f')));
							$htmlstring = strip_tags(html_entity_decode($htmlstring), '<br><br />');
							$viewPlaylist->setFormField('f',$htmlstring);
							$viewPlaylist->insertCommentAndPlaylistTable();
						break;

						case 'deletecomment':
							$viewPlaylist->checkLoginStatusInAjax($viewPlaylist->is_not_member_url);
							$viewPlaylist->checkSameUserInComment($LANG['common_login_other_user_comment_delete_err_msg'], true);
							$viewPlaylist->deleteComment();
						break;

						case 'comment_edit':
							echo $viewPlaylist->getFormField('comment_id');
							echo '***--***!!!';
							$viewPlaylist->checkLoginStatusInAjax($viewPlaylist->is_not_member_url);
							$viewPlaylist->checkSameUserInComment($LANG['common_login_other_user_comment_edit_err_msg']);
							$viewPlaylist->getEditCommentBlock();
						break;

						case 'update_comment':
							$viewPlaylist->checkLoginStatusInAjax($viewPlaylist->is_not_member_url);
							$viewPlaylist->checkSameUserInComment($LANG['common_login_other_user_comment_edit_err_msg']);
							$htmlstring = trim(urldecode($viewPlaylist->getFormField('f')));
							$htmlstring = strip_tags(html_entity_decode($htmlstring), '<br><br />');
							$viewPlaylist->setFormField('f',$htmlstring);
							$viewPlaylist->updateCommentAndPlaylistTable();
							echo $viewPlaylist->getFormField('comment_id');
							echo '***--***!!!';
							echo $viewPlaylist->getFormField('f');
						break;

						case 'playlist':
							$viewPlaylist->setAllPageBlocksHide();
							$viewPlaylist->checkLoginStatusInAjax($viewPlaylist->is_not_member_url);
							# Add music to playlist
							$flag = 1;
							if($viewPlaylist->getFormField('playlist_name')!= '')
							{
								# Check already exist
								if(!$viewPlaylist->chkPlaylistExits('playlist_name', $LANG['viewplaylist_tip_alreay_exists']))
								{
									$flag =0;
									echo $viewPlaylist->getFormFieldErrorTip('playlist_name');
								}
								$subject = str_replace('VAR_MIN', $CFG['fieldsize']['music_playlist_name']['min'], $LANG['viewplaylist_invalid_size']);
								$subject = str_replace('VAR_MAX', $CFG['fieldsize']['music_playlist_name']['max'], $subject);
								if(!$viewPlaylist->chkIsValidSize('playlist_name', 'music_playlist_name', $subject))
								{
									$flag =0;
									echo $viewPlaylist->getFormFieldErrorTip('playlist_name');
								}
							}
							if($viewPlaylist->getFormField('playlist_tags')!= '')
							{
								$subject = str_replace('VAR_MIN', $CFG['fieldsize']['music_playlist_tags']['min'], $LANG['viewplaylist_err_tip_invalid_tag']);
								$subject = str_replace('VAR_MAX', $CFG['fieldsize']['music_playlist_tags']['max'], $subject);
								if(!$viewPlaylist->chkValidTagList('playlist_tags', 'music_playlist_tags', $subject))
								{
									$flag =0;
									echo $viewPlaylist->getFormFieldErrorTip('playlist_tags');
								}
							}

							if($flag)
							{
								if($viewPlaylist->isFormGETed($_POST, 'playlist') && $viewPlaylist->chkIsNotEmpty('playlist',''))
								{
									$playlist_id = $viewPlaylist->getFormField('playlist');
									echo sprintf($LANG['viewplaylist_successfully_msg'],$viewPlaylist->getFormField('playlist_name'));
									echo '#$#'.$playlist_id;
								}
								else
								{
									# Create new playlist
									$playlist_id = $viewPlaylist->createPlaylist();
									$viewPlaylist->playlistCreateActivity($playlist_id);
									echo sprintf($LANG['viewplaylist_successfully_msg'],$viewPlaylist->getFormField('playlist_name'));
									echo '#$#'.$playlist_id;
								}
								# INSERT SONG TO PLAYLIST SONG
								$song_id = explode(',', $viewPlaylist->getFormField('music_id'));
								for($inc=0;$inc<count($song_id);$inc++)
									$viewPlaylist->insertSongtoPlaylist($playlist_id, $song_id[$inc]);
							}
						break;
					}
			}
		$viewPlaylist->includeAjaxFooter();
		exit;
	}
//<<<<<-------------- Code end ----------------------------------------------//
//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$viewPlaylist->includeHeader();
if(!isAjax())
	{
		if ($viewPlaylist->isShowPageBlock('block_add_comments'))
		    {
		    	$viewPlaylist->includeHeader();
				setTemplateFolder('general/', 'music');
				$smartyObj->display('addComments.tpl');
			}
		$viewPlaylist->setPageBlockShow('block_add_comments');
		if($viewPlaylist->isShowPageBlock('add_reply') OR $viewPlaylist->isShowPageBlock('block_add_comments'))
			{
				$viewPlaylist->replyCommentId=$viewPlaylist->getFormField('comment_id');
					$viewPlaylist->replyUrl=$CFG['site']['music_url'].'viewPlaylist.php?ajax_page=true&playlist_id='.$viewPlaylist->getFormField('playlist_id').'&vpkey='.$viewPlaylist->getFormField('vpkey').'&show='.$viewPlaylist->getFormField('show');
				?>
				<script language="javascript" type="text/javascript">
				<?php if($CFG['admin']['musics']['captcha']
							AND $CFG['admin']['musics']['captcha_method'] == 'recaptcha'
								AND $CFG['captcha']['public_key'] AND $CFG['captcha']['private_key'])
						{
				?>
				var captcha_recaptcha = true;
				<?php
						}
						else
						{
				?>
				var captcha_recaptcha = false;
				<?php
						}
				?>
				</script>
				<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/light_comment.js"></script>
				<script language="javascript" type="text/javascript">
					var no_comment_error_msg = "<?php echo $LANG['common_noComment_errorMsg'];?>";
					var dontUse = 0;
					var replyUrl="<?php echo $viewPlaylist->replyUrl;?>";
					var owner="<?php echo $viewPlaylist->getFormField('user_id');;?>";
					var reply_comment_id="<?php echo $viewPlaylist->replyCommentId;?>";
					var reply_user_id="<?php echo $CFG['user']['user_id'];?>";
					$Jq('#comment').focus();
				</script>
				<?php
			}
	}
if ($viewPlaylist->isShowPageBlock('share_playlist_block'))
	{
		if(isMember())
			$viewPlaylist->shareUrl = $viewPlaylist->CFG['site']['music_url'].'sharePlaylist.php?playlist_id='.$viewPlaylist->getFormField('playlist_id').'&ajaxpage=true&page=shareplaylist';
		else
			$viewPlaylist->shareUrl = $viewPlaylist->CFG['site']['music_url'].'sharePlaylist.php?playlist_id='.$viewPlaylist->getFormField('playlist_id').'&ajaxpage=true&page=shareplaylist';
	}
?>
<script type="text/javascript">
var view_playlist_music_ajax_page_loading = '<img alt="<?php echo $LANG['common_music_loading']; ?>" src="<?php echo $CFG['site']['url'].'music/design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/loading-viewmusic.gif' ?>" \/>';
var view_playlist_scroll_loading='<div class="clsLoader">'+view_playlist_music_ajax_page_loading+'<\/div>';
var recalculate_scroll_view_playlist = true;
</script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/JSFCommunicator.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
<script type="text/javascript" type="javascript">
	var play_songs_playlist_player_url = '<?php echo $viewPlaylist->playSongsUrl; ?>';
</script>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/sharePlaylist.js"></script>
<?php
//include the content of the page
setTemplateFolder('general/', 'music');
$smartyObj->display('viewPlaylist.tpl');
?>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/AG_ajax_html.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/musicComment.js"></script>
<script type="text/javascript" language="javascript">
var play_songs_playlist_player_url = '<?php echo $viewPlaylist->playSongsUrl; ?>';
</script>
<script language="javascript" type="text/javascript">
var page_url = '<?php if(isMember()) {echo $CFG['site']['music_url'].'viewPlaylist.php';} else {echo $CFG['site']['music_url'].'viewPlaylist.php';}?>';
var member_login_url = '<?php echo $viewPlaylist->is_not_member_url; ?>';
var ajaxpageing_url = '<?php if(isMember()){echo $CFG['site']['music_url'].'viewPlaylist.php';} else{ echo $CFG['site']['music_url'].'viewPlaylist.php'; }?>';
playlist_arr = new Array('playlistContent', 'sharePlaylist')
var block_arr= new Array('selMsgConfirm', 'selMsgCartSuccess');
var pageing_limit = '<?php echo $CFG['admin']['musics']['music_in_playlist_limit']; ?>';
var song_total = '<?php echo $viewPlaylist->displayPlaylistSong(false);?>';
var deleteConfirmation = "<?php echo $LANG['delete_confirmation'];?>";
var comment_success_deleted_msg='<?php echo $LANG['success_deleted'];?>';
var kinda_comment_msg = "<?php echo $LANG['comment_approval']; ?>";
var music_site_url = "<?php echo $CFG['site']['music_url']; ?>";
var total_rating_images = "<?php echo  $CFG['admin']['total_rating'];?>";
var is_featured_already = '<?php echo $viewPlaylist->getFeaturedStatus(); ?>';
//PLAY LIST PROCESS START//
function playListShowHideDiv(div_id)
	{
		if($Jq('#' + div_id).css('display') == 'none')
			{
				$Jq('#' + div_id).show();
				document.getElementById('song_id').value = multiCheckValue;
			}
		else
			{
				document.getElementById('song_id').value = '';
				$Jq('#' + div_id).hide();
			}
	}
var scroll_current_content;
var ajaxUpdatePlaylist = function()
{
	var query_string = arguments[0];
	var confirm_box = arguments[1];

	$Jq('#shareDiv').hide();

	if(is_featured_already && confirm_box == 'featured' && arguments[2] != 'conformed')
	{
		document.msgConfirmformMulti1.action = "javascript:ajaxUpdatePlaylist('" + query_string + "', '" + confirm_box + "', 'conformed');";
		if(!Confirmation('selMsgLoginConfirmMulti', 'msgConfirmformMulti1', Array('selAlertLoginMessage'), Array("<?php echo $LANG['viewplaylist_feature_confirm'];?>"), Array('innerHTML')))
		{
			return false;
		}
	}
	else
	{
		hideAllBlocks();
	}
	scroll_current_content = confirm_box;
	if(confirm_box == 'featured')
	{
		$Jq('#featured').hide();
		$Jq('#featured_saving').show();
	}
	else if(confirm_box == 'unfeatured')
	{
		$Jq('#unfeatured').hide();
		$Jq('#featured_saving').show();
	}
	else if(confirm_box == 'favorite')
	{
		$Jq('#favorite').hide();
		$Jq('#favorite_saving').show();
	}
	else if(confirm_box == 'unfavorite')
	{
		$Jq('#unfavorite').hide();
		$Jq('#favorite_saving').show();
	}
	url = page_url+query_string;

	$Jq.ajax({
				type	: 'GET',
				url		: url,
				data	: pars,
				success	: ajaxResultPlaylistData
			});
}
function ajaxResultPlaylistData(request)
	{
		data = request;

		if(data.indexOf('ERR~')>=1)
		{
			if(scroll_current_content == 'favorite')
			{
				$Jq('#favorite_saving').hide();
				$Jq('#favorite').show();
				msg = '<?php echo $LANG['playlist_login_favorite_err_msg'] ?>';
			}
			else if(scroll_current_content == 'unfavorite')
			{
				$Jq('#favorite_saving').hide();
				$Jq('#unfavorite').show();
				msg = '<?php echo $LANG['playlist_login_favorite_err_msg'] ?>';
			}
			else if(scroll_current_content == 'featured')
			{
				$Jq('#featured_saving').hide();
				$Jq('#featured').show();
				msg = '<?php echo $LANG['playlist_login_featured_err_msg'] ?>';
			}
			else if(scroll_current_content == 'unfeatured')
			{
				$Jq('#featured_saving').hide();
				$Jq('#unfeatured').show();
				msg = '<?php echo $LANG['playlist_login_featured_err_msg'] ?>';
			}
			memberBlockLoginConfirmation(msg,'<?php echo $viewPlaylist->is_not_member_url ?>');
			return false;
		}



		if(scroll_current_content == 'featured')
			{
				$Jq('#featured_saving').hide();
				$Jq('#unfeatured').show();
			}
		else if(scroll_current_content == 'unfeatured')
			{
				$Jq('#featured_saving').hide();
				$Jq('#featured').show();
			}
		else if(scroll_current_content == 'favorite')
			{
				$Jq('#favorite_saving').hide();
				$Jq('#unfavorite').show();
			}
		else if(scroll_current_content == 'unfavorite')
			{
				$Jq('#favorite_saving').hide();
				$Jq('#favorite').show();
			}
	}
function populateMyPlayList(url, opt, music_id)
{
	playlist_opt = opt;
	return openAjaxWindow('false', 'ajaxupdate', 'jquery_ajax', url, 'action=popplaylist&mem_auth=true&song_id=' + music_id, 'populateMyPlayListResponse');
}
function populateMyPlayListResponse(html)
{
	data = unescape(html);
	if(data.indexOf('ERR~')>=1)
	{
		data = data.replace('ERR~','');
		$Jq('#clsMsgDisplay_playlist_success').html(data);
		$Jq('#clsMsgDisplay_playlist_success').show();
		return false;
	}

	if(data.indexOf('selLogin') > 0)
	{
		$Jq('#loginDiv').html(html);
		Confirmation('loginDiv', 'selFormLogin', Array(), Array(), Array());
	}
	else
	{
		$Jq('#selMyPlayListOpt').html(html);
		if(playlist_opt == 'create')
		{
			jQuery("select#playlist option[selected]").removeAttr("selected");
			jQuery("select#playlist option[value='#new#']").attr("selected", "selected");
			$Jq('#createNewPlaylist').show();
		}
		else
		{
			$Jq('#createNewPlaylist').hide();
		}
		Confirmation('playlistDiv', 'playlistfrm', Array(), Array(), Array());
	}
}
function flashToCSS_PlayerReady()
{
	$Jq('#view_playlist').addClass('clsfeaturedplaylist');
}
</script>
<?php
$viewPlaylist->includeFooter();
?>