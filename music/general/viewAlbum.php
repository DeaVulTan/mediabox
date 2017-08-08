<?php
//--------------class viewAlbum--------------->>>//
/**
* This class is used to viewalbum
*
* @category	Rayzz
* @package		manage music viewAlbum
*/
class viewAlbum extends MusicHandler
	{
		public $album_owner_id ='';
		public $page_title = '';
		public $featured_msg = '';
		public $favorite_msg = '';
		/**
		* viewalbum::isValidMusicAlbumID()
		*
		* @return
		*/
		public function isValidMusicAlbumID()
			{
				global $smartyObj;
				$musics_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
				$sql = 'SELECT  mc.music_category_id, mc.music_category_name, m.music_server_url, m.music_thumb_ext, mfs.file_name, m.thumb_width, m.thumb_height,m.music_id, ma.music_album_id, ma.album_title, m.total_views, sum(m.total_plays) as total_plays, m.music_title, m.music_tags, m.music_artist, m.music_ext, m.thumb_width, m.thumb_height, m.user_id, u.user_name, (m.rating_total/m.rating_count) as rating, m.rating_total, m.rating_count,  m.music_thumb_ext, TIMEDIFF(NOW(), m.date_added) as date_added, m.music_thumb_ext, m.total_comments, m.total_favorites,m.music_caption,m.music_id,count( m.music_id ) AS total_songs, album_access_type, album_for_sale, album_price '.
				'FROM '.$this->CFG['db']['tbl']['music'].' as m '.', '.$this->CFG['db']['tbl']['users'] . ' as u, '.$this->CFG['db']['tbl']['music_album'].' AS ma, '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs, '.$this->CFG['db']['tbl']['music_category'].' AS mc '.
				'WHERE mc.music_category_id=m.music_category_id AND mc.parent_category_id=\'0\' AND mfs.music_file_id = m.thumb_name_id AND ma.music_album_id = m.music_album_id AND u.user_id = m.user_id AND m.music_status = \'Ok\' AND u.usr_status = \'Ok\' AND ma.music_album_id  = '.$this->dbObj->Param('album_id').' '.$this->getAdultQuery('m.', 'music').' AND (m.user_id = '.$this->CFG['user']['user_id'].' OR'.
				' m.music_access_type = \'Public\''.$this->getAdditionalQuery().') GROUP BY  m.music_id  ORDER BY ma.music_album_id ASC LIMIT '.$this->fields_arr['start'].' , 2';
				$value_arr = array($this->fields_arr['album_id']);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $value_arr);
				if (!$rs)
					trigger_db_error($this->dbObj);
				$viewAlbumDetail = $rs->FetchRow();
				if(isset($viewAlbumDetail['music_album_id']))
					{
						$this->album_owner_id = $viewAlbumDetail['user_id'];
						if($viewAlbumDetail['music_thumb_ext'])
									{
										$viewAlbumDetail['music_path'] = $viewAlbumDetail['music_server_url'].$musics_folder.getMusicImageName($viewAlbumDetail['music_id'], $viewAlbumDetail['file_name']).$this->CFG['admin']['musics']['thumb_name'].'.'.$viewAlbumDetail['music_thumb_ext'];
									}
								else
									{
										$viewAlbumDetail['music_path'] = '';
									}
						$this->fields_arr['user_id'] = $viewAlbumDetail['user_id'];
						$viewAlbumDetail['date_added'] = ($viewAlbumDetail['date_added'] != '') ? getTimeDiffernceFormat($viewAlbumDetail['date_added']) : '';
						$viewAlbumDetail['viewalbumlist_url'] = getUrl('viewalbum', '?album_id='.$viewAlbumDetail['music_album_id'].'&title='.$viewAlbumDetail['album_title'], $viewAlbumDetail['music_album_id'].'/'.$viewAlbumDetail['album_title'].'/', '','music');
						$viewAlbumDetail['album_title'] =$viewAlbumDetail['album_title'];
						$viewAlbumDetail['total_songs'] =$viewAlbumDetail['total_songs'];
						if($viewAlbumDetail['album_access_type']=='Private'
							and $viewAlbumDetail['album_for_sale']=='Yes'
							and $viewAlbumDetail['album_price']>0)
						{
							$viewAlbumDetail['album_access_type'] =$viewAlbumDetail['album_access_type'];
							$viewAlbumDetail['album_for_sale'] =$viewAlbumDetail['album_for_sale'];
							$album_price = strstr($viewAlbumDetail['album_price'], '.');
	                        if(!$album_price)
	                        {
	                          $viewAlbumDetail['album_price']=$viewAlbumDetail['album_price'].'.00';
						    }
						    else
						    {
							   $viewAlbumDetail['album_price'] =$viewAlbumDetail['album_price'];
							}
						}
						else
							$viewAlbumDetail['album_for_sale'] = 'No';
						$viewAlbumDetail['album_owner_url'] = getMemberProfileUrl($viewAlbumDetail['user_id'], $viewAlbumDetail['user_name']);
						$viewAlbumDetail['album_title'] =$viewAlbumDetail['album_title'];
						$viewAlbumDetail['rankUsersRayzz'] = false;
						$viewAlbumDetail['rating'] = '';
						$smartyObj->assign('viewAlbumInformation', $viewAlbumDetail);
						return true;
					}
				else
					{
						return false;
					}
			}

		/**
		 * viewAlbum::isValidAlbumId()
		 *
		 * @return
		 */
		public function isValidAlbumId()
		{
			$sql = 'SELECT music_album_id FROM '.
					$this->CFG['db']['tbl']['music_album'].
					' WHERE music_album_id='.$this->dbObj->Param('music_album_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['album_id']));
			if (!$rs)
				trigger_db_error($this->dbObj);
			if($row = $rs->FetchRow())
			{
				return true;
			}
			return false;
		}
		public function displayViewAlbum($album_id='')
			{
				global $smartyObj;
				$sql = 'SELECT  m.music_tags, m.music_artist,ma.music_album_id,m.music_id,sum( m.music_id ) AS total_songs '.
				'FROM '.$this->CFG['db']['tbl']['music'].' as m '.', '.$this->CFG['db']['tbl']['users'] . ' as u, '.$this->CFG['db']['tbl']['music_album'].' AS ma, '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs '.
				'WHERE mfs.music_file_id = m.thumb_name_id AND ma.music_album_id = m.music_album_id AND u.user_id = m.user_id AND m.music_status = \'Ok\' AND u.usr_status = \'Ok\' AND ma.music_album_id  = '.$album_id.' '.$this->getAdultQuery('m.', 'music').' AND (m.user_id = '.$this->CFG['user']['user_id'].' OR'.
				' m.music_access_type = \'Public\''.$this->getAdditionalQuery().') GROUP BY  m.music_id  ORDER BY ma.music_album_id ASC LIMIT '.$this->fields_arr['start'].' , 10';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);
				$displayViewAlbum['record_count'] = 0;
				$displayViewAlbum['row'] = array();
				$tags_arr = array();
				$artist_arr = array();
				$inc = 1;
				while($songDetail = $rs->FetchRow())
					{
						$displayViewAlbum['record_count'] = 1;
						$displayViewAlbum['row'][$inc]['record'] = $songDetail;
						if(!in_array($songDetail['music_tags'],$tags_arr))
						{
							$displayViewAlbum['row'][$inc]['music_tags'] = $songDetail['music_tags'];
							$tags_arr[] = $songDetail['music_tags'];
						}
						else
						{
							$displayViewAlbum['row'][$inc]['music_tags'] = '';
						}
						if(!in_array($songDetail['music_artist'],$artist_arr))
						{
							$displayViewAlbum['row'][$inc]['music_artist'] = $songDetail['music_artist'];
							$artist_arr[] = $songDetail['music_artist'];
						}
						else
						{
							$displayViewAlbum['row'][$inc]['music_artist'] = '';
						}
						$displayViewAlbum['row'][$inc]['music_id'] = $songDetail['music_id'];
						$inc++;
					}
				$smartyObj->assign('displayViewAlbum', $displayViewAlbum);
				$smartyObj->assign('lastData', $$inc=$inc-1);
			}
		/**
		* viewalbum::setTableAndColumns()
		*
		* @return
		*/
		public function setTableAndColumns()
			{
				$this->setTableNames(array($this->CFG['db']['tbl']['music_album'] . ' as ma LEFT JOIN ' . $this->CFG['db']['tbl']['music'] . ' as m ON ma.music_album_id = m.music_album_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
				$this->setReturnColumns(array('ma.music_album_id', 'ma.album_title', 'm.total_views', 'sum(m.total_plays) as total_plays', 'm.music_title', 'm.music_tags', 'm.music_artist', 'm.music_ext', 'm.thumb_width', 'm.thumb_height', 'm.user_id', 'u.user_name', '(m.rating_total/m.rating_count) as rating','SUM( m.music_id ) AS total_songs'));
				$this->sql_condition = 'ma.music_album_id = m.music_album_id AND u.user_id = m.user_id AND m.music_status = \'Ok\' AND u.usr_status = \'Ok\' AND ma.music_album_id = '.$this->fields_arr['album_id'];
				$this->sql_sort = 'ma.music_album_id order_id ASC';
			}
		/**
		* viewalbum::displayAlbumSong($count)
		*
		* @return
		*/
		public function displayAlbumSong($count)
			{
				global $smartyObj;
				$displayAlbumSong_arr = array();
				$musics_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
				$start = $this->fields_arr['start'];
				$sql = 'SELECT  mc.music_category_id, mc.music_category_name, m.music_server_url, m.music_thumb_ext, mfs.file_name, m.thumb_width,m.music_price, ma.album_access_type, ma.album_for_sale, ma.album_price, m.thumb_height,m.music_id, ma.music_album_id, ma.album_title, m.total_views, sum(m.total_plays) as total_plays, m.music_title, m.music_tags, m.music_artist, m.music_ext, m.thumb_width, m.thumb_height, m.user_id, u.user_name, (m.rating_total/m.rating_count) as rating, m.rating_total, m.rating_count,  m.music_thumb_ext, TIMEDIFF(NOW(), m.date_added) as date_added, m.music_thumb_ext, m.total_comments, m.total_favorites,m.music_caption,m.music_id,count( m.music_id ) AS total_songs,m.playing_time, m.for_sale '.
				'FROM '.$this->CFG['db']['tbl']['music'].' as m '.', '.$this->CFG['db']['tbl']['users'] . ' as u, '.$this->CFG['db']['tbl']['music_album'].' AS ma, '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs, '.$this->CFG['db']['tbl']['music_category'].' AS mc '.
				'WHERE mc.music_category_id=m.music_category_id AND mc.parent_category_id=\'0\' AND mfs.music_file_id = m.thumb_name_id AND ma.music_album_id = m.music_album_id AND u.user_id = m.user_id AND m.music_status = \'Ok\' AND u.usr_status = \'Ok\' AND ma.music_album_id  = '.$this->dbObj->Param('album_id').' '.$this->getAdultQuery('m.', 'music').' AND (m.user_id = '.$this->CFG['user']['user_id'].' OR'.
				' m.music_access_type = \'Public\''.$this->getAdditionalQuery().') GROUP BY  m.music_id  ORDER BY ma.music_album_id ASC ';
				if($count)
					$sql .= 'LIMIT '.$this->fields_arr['start'].', '.$this->CFG['admin']['musics']['music_view_album_limit'];
				$value_arr = array($this->fields_arr['album_id']);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,$value_arr);
				if (!$rs)
					trigger_db_error($this->dbObj);
				$this->total_records = $rs->PO_RecordCount();
				if(!$count)
					return $this->total_records;
				if($this->total_records)
					{
						$this->activeClsNext = 'clsNextDisable';
						$this->activeClsPrevious = 'clsPreviousDisable';
						$this->isNextButton = false;
						$this->isPreviousButton = false;
						// PAGING //
						$total = $this->displayAlbumSong(false);
						if($total > ($start+$this->CFG['admin']['musics']['music_view_album_limit']))
							{
								$this->activeClsNext = 'clsNext';
								$this->isNextButton = true;
							}
						if($start > 0)
							{
								$this->activeClsPrevious = 'clsPrevious';
								$this->isPreviousButton = true;
							}
						$displayAlbumSong_arr['record_count'] = 0;
						$displayAlbumSong_arr['row'] = array();
						$this->player_music_id = array();
						$inc = 0;
						$this->allow_quick_mixs = (isLoggedIn() and $this->CFG['admin']['musics']['allow_quick_mixs'])?true:false;
						while($songDetail = $rs->FetchRow())
							{
								$displayAlbumSong_arr['record_count'] = 1;
								$songDetail['date_added'] = ($songDetail['date_added'] != '') ? getTimeDiffernceFormat($songDetail['date_added']) : '';
								$displayAlbumSong_arr['row'][$inc]['add_quickmix'] = false;
					            if ($this->allow_quick_mixs)
									 {
						                $displayAlbumSong_arr['row'][$inc]['add_quickmix'] = true;
						                $displayAlbumSong_arr['row'][$inc]['is_quickmix_added'] = false;
						                if (rayzzMusicQuickMix($songDetail['music_id']))
						                    $displayAlbumSong_arr['row'][$inc]['is_quickmix_added'] = true;
						            }

								$displayAlbumSong_arr['row'][$inc]['record'] = $songDetail;
								$displayAlbumSong_arr['row'][$inc]['for_sale'] = $songDetail['for_sale'];
								$displayAlbumSong_arr['row'][$inc]['for_sale'] = 'No';
								if($songDetail['album_access_type']=='Private'
									and $songDetail['album_for_sale']=='Yes'
									and $songDetail['album_price']>0)
								{
									$displayAlbumSong_arr['row'][$inc]['album_for_sale'] = 'Yes';
									$displayAlbumSong_arr['row'][$inc]['price'] = $this->LANG['common_album_price'].' <span>'.$this->CFG['currency'].$songDetail['album_price'].'</span>';
								}
								else if($songDetail['for_sale']=='Yes')
								{
									$displayAlbumSong_arr['row'][$inc]['for_sale'] = $songDetail['for_sale'];
									$displayAlbumSong_arr['row'][$inc]['price'] = $this->LANG['common_music_price'].' <span>'.$this->CFG['currency'].$songDetail['music_price'].'</span>';
								}
								$displayAlbumSong_arr['row'][$inc]['viewprofile_url'] = getMemberProfileUrl($songDetail['user_id'], $songDetail['user_name']);
								$displayAlbumSong_arr['row'][$inc]['viewmusic_url'] = getUrl('viewmusic', '?music_id='.$songDetail['music_id'].'&title='.$this->changeTitle($songDetail['music_title']), $songDetail['music_id'].'/'.$this->changeTitle($songDetail['music_title']).'/', '', 'music');
								$displayAlbumSong_arr['row'][$inc]['musiclistalbum_url'] = getUrl('musiclist', '?pg=musicnew&album_id='.$songDetail['music_album_id'], 'musicnew/?album_id='.$songDetail['music_album_id'], '', 'music');
								$displayAlbumSong_arr['row'][$inc]['musiccategorylist_url'] = getUrl('musiclist', '?pg=musicnew&cid='.$songDetail['music_category_id'], 'musicnew/?cid='.$songDetail['music_category_id'], '', 'music');
								$displayAlbumSong_arr['row'][$inc]['playing_time']=$this->fmtMusicPlayingTime($songDetail['playing_time']);
								$this->player_music_id[$inc] = $songDetail['music_id'];
								if($songDetail['music_thumb_ext'])
									{
										$displayAlbumSong_arr['row'][$inc]['music_image_src'] = $songDetail['music_server_url'].$musics_folder.getMusicImageName($songDetail['music_id'], $songDetail['file_name']).$this->CFG['admin']['musics']['thumb_name'].'.'.$songDetail['music_thumb_ext'];
									}
								else
									{
										$displayAlbumSong_arr['row'][$inc]['music_image_src'] = '';
									}
								$displayAlbumSong_arr['row'][$inc]['add_quickmix'] = false;
								$allow_quick_links = (isLoggedIn() and $this->CFG['admin']['musics']['allow_quick_mixs'])?true:false;
								if ($allow_quick_links )
									{
										$displayAlbumSong_arr['row'][$inc]['add_quickmix'] = true;
										$displayAlbumSong_arr['row'][$inc]['is_quickmix_added'] = false;
										if (rayzzMusicQuickMix($songDetail['music_id']))
											{
												$displayAlbumSong_arr['row'][$inc]['is_quickmix_added'] = true;
											}
									}
								$inc++;
							}
						}
						else
							{
								$this->activeClsNext = 'clsNextDisable';
								$this->activeClsPrevious = 'clsPreviousDisable';
							}
						//player configuration
						$this->populatePlayerWithPlaylistConfiguration();
						$this->configXmlcode_url .= 'pg=music';
						$this->playlistXmlcode_url .= 'pg=music_0_'.implode(',', $this->player_music_id);
						$this->populatePlayerWithPlaylistForAjax('view_album_player_div', 'view_album_player', 1, 1, 'false', true, false, true, true);
						echo '~!###!~';
						echo count($this->player_music_id);
						echo '~!###!~';
						echo implode(',', $this->player_music_id);
						echo '~!###!~';
						echo '<input type="hidden" name="hidden_player_status" id="hidden_player_status" value="no" />';
						$smartyObj->assign('displayAlbumSong_arr', $displayAlbumSong_arr);
						setTemplateFolder('general/', 'music');
						$smartyObj->display('ajaxViewAlbum.tpl');
				}
		/**
		* viewalbum::getCaptchaText()
		* purpose to getcaptcha text
		* @return
		*/
		public function getCaptchaText()
			{
				$captcha_length = 5;
				$this->captchaText = rand(pow(10, $captcha_length-1), pow(10, $captcha_length)-1);
				return $this->captchaText;
			}

		public function getViewAlbumSongTotal()
			{
				$sql = 'SELECT count(music_id) as total '.'FROM '.$this->CFG['db']['tbl']['music'].' AS m WHERE m.music_album_id = '.$this->dbObj->Param('album_id') .' AND m.music_status = \'Ok\'';
				$value_arr = array($this->fields_arr['album_id']);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,$value_arr);
				if (!$rs)
					trigger_db_error($this->dbObj);
				 $row = $rs->FetchRow();
				return $row['total'];
			}
		public function getViewAlbumTotalViews($album_id)
			{

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_album'].
						' SET total_album_views  = total_album_views + 1 '.
						' WHERE music_album_id = '.$this->dbObj->Param('album_id');

				$value_array = array($album_id);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $value_array);

				if (!$rs)
					trigger_db_error($this->dbObj);
			}
		public function getViewAlbumPlaysTotal($play_album_id)
			{
				$sql = 'SELECT sum(m.total_plays) as play_total '.'FROM '.$this->CFG['db']['tbl']['music'].' AS m WHERE m.music_album_id = '.$this->dbObj->Param('album_id') .' AND m.music_status = \'Ok\'';
				$value_arr = array($play_album_id);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,$value_arr);
				if (!$rs)
					trigger_db_error($this->dbObj);
				 $row = $rs->FetchRow();
				return $row['play_total'];
			}

		/**
		 * viewalbum::populatePlaylist()
		 * playlist details will be passed to tpl
		 *
		 * @return void
		 */
		public function populatePlaylist()
		{
			global $smartyObj;
			$playlist_info = array();
			$playlist_info['playlistUrl']=$this->CFG['site']['music_url'].'viewAlbum.php?ajax_page=true&page=playlist';
			$this->playlist_name_notes = str_replace('VAR_MIN', $this->CFG['fieldsize']['music_playlist_name']['min'], $this->LANG['playlist_name_notes']);
			$this->playlist_name_notes = str_replace('VAR_MAX', $this->CFG['fieldsize']['music_playlist_name']['max'], $this->playlist_name_notes);
			$this->playlist_tags_notes = str_replace('VAR_MIN', $this->CFG['fieldsize']['music_playlist_tags']['min'], $this->LANG['playlist_tags_notes']);
			$this->playlist_tags_notes = str_replace('VAR_MAX', $this->CFG['fieldsize']['music_playlist_tags']['max'], $this->playlist_tags_notes);
			$this->getPlaylistIdInMusic($this->getFormField('music_id'));
			$this->displayCreatePlaylistInterface();
			$smartyObj->assign('playlist_info', $playlist_info);
			$smartyObj->assign('playlist_option', 'album');
			setTemplateFolder('general/','music');
			$smartyObj->display('getPlaylist.tpl');
		}

	}
//<<<<<-------------- Class viewalbum end ---------------//
//-------------------- Code begins -------------->>>>>//
$viewalbum = new viewAlbum();
if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$viewalbum->setPageBlockNames(array('viewAlbum_information_block','viewalbum_block',
								'album_songlist_block', 'block_add_comments','viewAlbum_tags_block'));

$viewalbum->CFG['admin']['musics']['individual_song_play'] = true;

$viewalbum->setAllPageBlocksHide();
$viewalbum->setFormField('album_id', '');
$viewalbum->setFormField('action', '');
$viewalbum->setFormField('page', '');
$viewalbum->setFormField('allow_comments', 'Yes');
$viewalbum->setFormField('allow_ratings', 'Yes');
$viewalbum->setFormField('music_id', '');
$viewalbum->setFormField('featured', '');
$viewalbum->setFormField('favorite', '');
$viewalbum->setFormField('email_to', '');
$viewalbum->setFormField('personal_msg', '');
$viewalbum->setFormField('start', 0);
$viewalbum->setFormField('show', 1);
$viewalbum->setFormField('rating_count', '');
$viewalbum->setFormField('rate', '');
$viewalbum->setFormField('type', '');
$viewalbum->setFormField('vpkey', '');
$viewalbum->setFormField('comment_id', '');
$viewalbum->setFormField('comment_id',0);
$viewalbum->setFormField('f',0);
$viewalbum->setFormField('user_id', '');
$viewalbum->setFormField('album_title', '');
$viewalbum->setFormField('play_list', '');//  This can be "ql" / "pl". means that Quick List and Play List. When play_list. Need play list id
$viewalbum->setFormField('playlist_description', '');
$viewalbum->setFormField('playlist_tags', '');
$viewalbum->setFormField('allow_comments', 'Yes');
$viewalbum->setFormField('allow_embed', 'Yes');
$viewalbum->setFormField('allow_ratings', 'Yes');
$viewalbum->setFormField('playlist_access_type', 'Public');
$viewalbum->setFormField('playlist', '');
$viewalbum->setFormField('playlist_id', '');
$viewalbum->setFormField('playlist_name', '');
$viewalbum->sanitizeFormInputs($_REQUEST);
$viewalbum->sanitizeFormInputs($_POST);
if(!isMember())
	{
		$viewalbum->saveviewAlbumUrl = $viewalbum->is_not_member_url = getUrl('viewalbum','?mem_auth=true&album_id='.$viewalbum->getFormField('album_id').'&amp;title='.$viewalbum->changeTitle($viewalbum->getFormField('album_title')), $viewalbum->getFormField('album_id').'/'.$viewalbum->changeTitle($viewalbum->getFormField('album_title')).'/?mem_auth=true', 'members','music');
	}
else
	{
		$viewalbum->saveviewAlbumUrl = $CFG['site']['music_url'].'createPlaylist.php?action=save_playlist&light_window=1';
	}
$viewalbum->playSongsUrl = $CFG['site']['music_url'].'playSongsInPlaylist.php';
$viewalbum->memberLoginMusicUrl = getUrl('viewalbum','?mem_auth=true&album_id='.$viewalbum->getFormField('album_id').'&amp;title='.$viewalbum->changeTitle($viewalbum->getFormField('album_title')), $viewalbum->getFormField('album_id').'/'.$viewalbum->changeTitle($viewalbum->getFormField('album_title')).'/?mem_auth=true', 'members','music');
if(isAjaxPage())
{
	$viewalbum->isValidMusicAlbumID();
	$viewalbum->includeAjaxHeaderSessionCheck();
	$viewalbum->sanitizeFormInputs($_REQUEST);

	if ($viewalbum->getFormField('action')=='popplaylist')
    {
    	$viewalbum->checkLoginStatusInAjax($viewalbum->memberLoginMusicUrl);
		$viewalbum->populatePlaylist();
		die();
    }
    else if($viewalbum->getFormField('page') != '')
	{
		switch ($viewalbum->getFormField('page'))
		{
			case 'pagenation':
				$viewalbum->setPageBlockShow('album_songlist_block');
				$viewalbum->displayAlbumSong(true);
			break;

			case 'playlist':
				$viewalbum->setAllPageBlocksHide();
				$viewalbum->checkLoginStatusInAjax($viewalbum->memberLoginMusicUrl);
				# Add music to playlist
				$flag = 1;
				if($viewalbum->getFormField('playlist_name')!= '')
				{
					# Check already exist
					if(!$viewalbum->chkPlaylistExits('playlist_name', $LANG['viewplaylist_tip_alreay_exists']))
					{
						$flag =0;
						echo $viewalbum->getFormFieldErrorTip('playlist_name');
					}
					$subject = str_replace('VAR_MIN', $CFG['fieldsize']['music_playlist_name']['min'], $LANG['viewplaylist_invalid_size']);
					$subject = str_replace('VAR_MAX', $CFG['fieldsize']['music_playlist_name']['max'], $subject);
					if(!$viewalbum->chkIsValidSize('playlist_name', 'music_playlist_name', $subject))
					{
						$flag =0;
						echo $viewalbum->getFormFieldErrorTip('playlist_name');
					}
				}
				if($viewalbum->getFormField('playlist_tags')!= '')
				{
					$subject = str_replace('VAR_MIN', $CFG['fieldsize']['music_playlist_tags']['min'], $LANG['viewplaylist_err_tip_invalid_tag']);
					$subject = str_replace('VAR_MAX', $CFG['fieldsize']['music_playlist_tags']['max'], $subject);
					if(!$viewalbum->chkValidTagList('playlist_tags', 'music_playlist_tags', $subject))
					{
						$flag =0;
						echo $viewalbum->getFormFieldErrorTip('playlist_tags');
					}
				}

				if($flag)
				{
					if($viewalbum->isFormGETed($_POST, 'playlist') && $viewalbum->chkIsNotEmpty('playlist',''))
					{
						$playlist_id = $viewalbum->getFormField('playlist');
						echo sprintf($LANG['viewplaylist_successfully_msg'],$viewalbum->getFormField('playlist_name'));
						echo '#$#'.$playlist_id;
					}
					else
					{
						# Create new playlist
						$playlist_id = $viewalbum->createPlaylist();
						$viewalbum->playlistCreateActivity($playlist_id);
						echo sprintf($LANG['viewplaylist_successfully_msg'],$viewalbum->getFormField('playlist_name'));
						echo '#$#'.$playlist_id;
					}
					# INSERT SONG TO PLAYLIST SONG
					$song_id = explode(',', $viewalbum->getFormField('music_id'));
					for($inc=0;$inc<count($song_id);$inc++)
						$viewalbum->insertSongtoPlaylist($playlist_id, $song_id[$inc]);
				}
			break;
		}
	}
	$viewalbum->includeAjaxFooter();
	exit;
}
if($viewalbum->getFormField('album_id')!='')
	{
		//Checked the new method for valid album id. Modified the old method error tip as no records found
		if($viewalbum->isValidAlbumId())
		{
			if($viewalbum->isValidMusicAlbumID())
			{
				$viewalbum->setPageBlockShow('viewAlbum_information_block');
				$viewalbum->setPageBlockShow('viewAlbum_tags_block');
				if($viewalbum->isShowPageBlock('viewAlbum_tags_block'))
					{
						$viewalbum->displayViewAlbum($viewalbum->getFormField('album_id'));
					}
				$viewalbum->setPageBlockShow('viewalbum_block');
				$viewalbum->getViewAlbumTotalViews($viewalbum->getFormField('album_id'));
				$viewalbum->sanitizeFormInputs($_REQUEST);
				$viewalbum->sanitizeFormInputs($_POST);
				$viewalbum->setPageBlockShow('album_songlist_block');
				$viewalbum->configXmlcode_url .= 'pg=music';
				if(!isMember())
					$viewalbum->relatedUrl		= $CFG['site']['music_url'].'viewAlbum.php';
				else
					$viewalbum->relatedUrl		= $CFG['site']['music_url'].'viewAlbum.php';
			}
			else
			{
				$viewalbum->setAllPageBlocksHide();
				$viewalbum->setCommonErrorMsg($LANG['viewAlbum_no_music_found']);
				$viewalbum->setPageBlockShow('block_msg_form_error');
			}
		}
		else
		{
			$viewalbum->setAllPageBlocksHide();
			$viewalbum->setCommonErrorMsg($LANG['viewalbumlist_invalid_id_err_tip']);
			$viewalbum->setPageBlockShow('block_msg_form_error');
		}
	}
//<<<<<-------------- Code end ----------------------------------------------//
//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$viewalbum->includeHeader();
?>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/functions.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/AG_ajax_html.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/JSFCommunicator.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
<script type="text/javascript" language="javascript">
total_musics_to_play = <?php echo count($viewalbum->getFormField('album_id')); ?>;
</script>
<?php
//include the content of the page
setTemplateFolder('general/', 'music');
$smartyObj->display('viewAlbum.tpl');
?>
<script language="javascript" type="text/javascript">
var page_url = '<?php echo $CFG['site']['music_url'].'viewAlbum.php';?>';
var ajaxpageing_url = '<?php if(isMember()){echo $CFG['site']['music_url'].'viewAlbum.php';} else{ echo $CFG['site']['music_url'].'viewAlbum.php'; }?>';
var block_arr= new Array('selMsgConfirm', 'selMsgCartSuccess');
var pageing_limit = '<?php echo $CFG['admin']['musics']['music_view_album_limit']; ?>';
var song_total = '<?php echo $viewalbum->displayAlbumSong(false);?>';
var deleteConfirmation = "<?php echo $LANG['delete_confirmation'];?>";
var kinda_comment_msg = "<?php echo $LANG['comment_approval']; ?>";
function populateMyPlayList(url, opt, music_id)
{
	playlist_opt = opt;
	return openAjaxWindow('false', 'ajaxupdate', 'jquery_ajax', url, 'action=popplaylist&mem_auth=true&music_id=' + music_id, 'populateMyPlayListResponse');
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
</script>
<?php
$viewalbum->includeFooter();
?>