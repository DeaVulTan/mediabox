<?php
//--------------class MusicIndexPageHandler--------------->>>//
/**
 * This class is used to list music insex page
 *
 * @category	Rayzz
 * @package		manage music imdex
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 */
class MusicChartPageHandler extends MusicHandler
	{
		public $default_active_div = array();
		public $default_active_css_class = array();
		public $player_music_id = array();
		public $player_music_id_key = 1;

		/**
		 * MusicIndexPageHandler::loadSetting()
		 *
		 * @return
		 */

		public function setTableAndColumns($type)
    	{
    		switch ($type)
			{
				case 'topChartSongs':
					$this->setTableNames(array($this->CFG['db']['tbl']['music'].' AS m JOIN '.
									$this->CFG['db']['tbl']['music_song_top_chart'].' AS msc ON msc.music_id=m.music_id JOIN '.
									$this->CFG['db']['tbl']['music_top_chart_cron'].' as tc ON msc.top_chart_cron_id=tc.top_chart_cron_id JOIN '.
									$this->CFG['db']['tbl']['music_files_settings'].' AS mfs '.
									'ON mfs.music_file_id = m.thumb_name_id, '.$this->CFG['db']['tbl']['music_category'].
									' AS mc, '.$this->CFG['db']['tbl']['music_album'].' AS ma, '.
									$this->CFG['db']['tbl']['users'].' AS u '));
					$this->setReturnColumns(array('m.music_id', 'm.music_album_id','m.user_id', 'm.music_title', 'ma.album_title',
												'm.total_plays as total_count', 'm.music_server_url', 'm.music_thumb_ext',
												 'mc.music_category_id', 'mc.music_category_name', 'mfs.file_name',
												 'DATE_FORMAT(tc.date_started, \'%d %M, %Y\') as date_ended',
												 'DATE_FORMAT(DATE_SUB(tc.date_started, INTERVAL '.$this->CFG['admin']['musics']['chart_between_days'].' DAY ), \'%d %M, %Y\') as date_started',
												'm.medium_width', 'm.medium_height', 'msc.total_sales','msc.current_position', 'msc.old_position'));
					$this->sql_condition = 'u.user_id = m.user_id
												AND m.music_category_id = mc.music_category_id
												AND m.music_album_id = ma.music_album_id
												AND u.usr_status = \'Ok\'
												AND m.music_status = \'Ok\'
												AND msc.status=\'Active\'
												AND mc.music_category_status = \'Yes\' '.$this->getAdultQuery('m.', 'music').'
												AND (m.user_id = '.$this->CFG['user']['user_id'].' OR '.
								 				'm.music_access_type = \'Public\''.$this->getAdditionalQuery().')';
					$this->sql_sort = 'msc.current_position';
					break;

				case 'topChartArtists':
					$this->setTableNames(array($this->CFG['db']['tbl']['music_artist_top_chart'].' as mtc LEFT JOIN '.
									$this->CFG['db']['tbl']['music_top_chart_cron'].' as  tc ON mtc.top_chart_cron_id=tc.top_chart_cron_id LEFT JOIN '.
									$this->CFG['db']['tbl']['users'].' as u '.
									' ON mtc.user_id = u.user_id LEFT JOIN '.
									$this->CFG['db']['tbl']['music'].' as m ON m.user_id=u.user_id LEFT JOIN '.
									$this->CFG['db']['tbl']['music_album'].' as ma ON m.music_album_id=ma.music_album_id'));
					$this->setReturnColumns(array('u.user_name as artist_name','ma.album_title', 'u.user_id', 'count(m.music_id) as total_song', 'sum( total_plays ) AS total_count',
												'DATE_FORMAT(tc.date_started, \'%d %M, %Y\') as date_ended',
												 'DATE_FORMAT(DATE_SUB(tc.date_started, INTERVAL '.$this->CFG['admin']['musics']['chart_between_days'].' DAY ), \'%d %M, %Y\') as date_started',
												'u.sex','mtc.current_position','mtc.old_position' ,'u.image_ext' , 'u.icon_type','u.icon_id'));
					$this->sql_condition = 'u.usr_status=\'Ok\' AND m.music_status = \'Ok\' AND u.music_user_type=\'Artist\' GROUP BY u.user_id';
					$this->sql_sort = 'current_position';
					break;

				case 'topChartAlbums':
					$this->setTableNames(array($this->CFG['db']['tbl']['music'].' AS m JOIN '.
									$this->CFG['db']['tbl']['music_album_top_chart'].' AS mca '.
									' ON mca.album_id=m.music_album_id JOIN '.
									$this->CFG['db']['tbl']['music_top_chart_cron'].' as tc ON mca.top_chart_cron_id=tc.top_chart_cron_id JOIN '.
									$this->CFG['db']['tbl']['music_files_settings'].' AS mfs '.
									'ON mfs.music_file_id = m.thumb_name_id, '.$this->CFG['db']['tbl']['music_album'].
									' AS ma, '.$this->CFG['db']['tbl']['users'].' AS u '));
					$this->setReturnColumns(array('count( m.music_id ) AS total_song', 'sum( m.total_plays ) AS total_count',
												'DATE_FORMAT(tc.date_started, \'%d %M, %Y\') as date_ended',
												 'DATE_FORMAT(DATE_SUB(tc.date_started, INTERVAL '.$this->CFG['admin']['musics']['chart_between_days'].' DAY ), \'%d %M, %Y\') as date_started',
												'ma.music_album_id','m.user_id','m.music_id','ma.album_title','mca.current_position','mca.old_position'));
					$this->sql_condition = 'u.user_id = m.user_id
											AND m.music_album_id = ma.music_album_id
											AND u.usr_status = \'Ok\'
											AND mca.status = \'Active\'
											AND m.music_status = \'Ok\' '.$this->getAdultQuery('m.', 'music').'
											AND (m.user_id = '.$this->CFG['user']['user_id'].' OR '.
								 			'm.music_access_type = \'Public\''.$this->getAdditionalQuery().') GROUP BY ma.music_album_id HAVING sum( m.total_plays ) > 0';
					$this->sql_sort = 'current_position';
					break;

			}
    	}

    	public function showMusics()
    	{
			global $smartyObj;
			$inc = 1;
			$smartyObj->assign('topchartlabel', $this->LANG['sidebar_topchart_plays_label']);
			$this->no_of_row_topchart=1;
			$count=0;
			$musics_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['musics']['folder'] . '/' .
								$this->CFG['admin']['musics']['thumbnail_folder'] . '/';
			$artist_image_path = $this->CFG['site']['url'].$this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['music_folder'].'/'.$this->CFG['admin']['musics']['artist_image_folder'].'/';
			while ($row = $this->fetchResultRecord())
			{
				$populateTopChartBlock_arr['record_count'] = true;
				$populateTopChartBlock_arr['row'][$inc]['record'] = $row;
				$populateTopChartBlock_arr['row'][$inc]['sale'] = false;
				$populateTopChartBlock_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_album_title'] = $row['album_title'];
				$populateTopChartBlock_arr['row'][$inc]['current_position'] =$row['current_position'];
				if($row['old_position']==0 OR $row['current_position']==$row['old_position'])
				{
					$populateTopChartBlock_arr['row'][$inc]['position'] = '';
					$populateTopChartBlock_arr['row'][$inc]['css'] = 'clsValueEqual';
					$populateTopChartBlock_arr['row'][$inc]['tool_tip'] = $this->LANG['topchart_new_entry'];
				}
				elseif($row['current_position']>$row['old_position'])
				{
					$populateTopChartBlock_arr['row'][$inc]['position'] = $row['old_position']-$row['current_position'];
					$populateTopChartBlock_arr['row'][$inc]['css'] = 'clsValueBottom';
					$populateTopChartBlock_arr['row'][$inc]['tool_tip'] = $this->LANG['topchart_down_entry'];
				}
				elseif($row['current_position']<$row['old_position'])
				{
					$position = $row['old_position']-$row['current_position'];
					$populateTopChartBlock_arr['row'][$inc]['position'] = '+'.$position;
					$populateTopChartBlock_arr['row'][$inc]['css'] = 'clsValueTop';
					$populateTopChartBlock_arr['row'][$inc]['tool_tip'] = $this->LANG['topchart_up_entry'];
				}

				if($pay_details = checkMusicForSale($row['music_id']))
	    		{
	    			$populateTopChartBlock_arr['row'][$inc]['for_sale']= false;
	    			$populateTopChartBlock_arr['row'][$inc]['album_for_sale']= false;
					$populateTopChartBlock_arr['row'][$inc]['sale'] = true;
					if($pay_details['for_sale']=='Yes' AND $pay_details['music_price']>0)
					{
						$populateTopChartBlock_arr['row'][$inc]['for_sale'] = true;
						 $music_price = strstr($pay_details['music_price'], '.');
                           if(!$music_price)
                           {
                              $pay_details['music_price']=$pay_details['music_price'].'.00';
						   }
						$populateTopChartBlock_arr['row'][$inc]['music_price'] = $this->CFG['currency'].$pay_details['music_price'];
					}
				}
				$populateTopChartBlock_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_music_title'] = $row['music_title'];
				$populateTopChartBlock_arr['row'][$inc]['title_url'] = getUrl('viewmusic', '?music_id='.$row['music_id'].'&title='.$this->changeTitle($row['music_title']), $row['music_id'].'/'.$this->changeTitle($row['music_title']).'/', '', 'music');
				$populateTopChartBlock_arr['row'][$inc]['musiccategory_url'] = getUrl('musiclist', '?pg=musicnew&cid='.$row['music_category_id'], 'musicnew/?cid='.$row['music_category_id'], '', 'music');
				$populateTopChartBlock_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_category_name'] = $row['music_category_name'];
				$populateTopChartBlock_arr['row'][$inc]['viewalbum_url'] = getUrl('viewalbum', '?album_id='.$row['music_album_id'].'&title='.$this->changeTitle($row['album_title']),$row['music_album_id'].'/'.$this->changeTitle($row['album_title']).'/', '', 'music');
				// IMAGE //
				if($row['music_thumb_ext'])
					{
						$populateTopChartBlock_arr['row'][$inc]['music_image_src'] = $row['music_server_url'].$musics_folder.getMusicImageName($row['music_id'], $row['file_name']).$this->CFG['admin']['musics']['medium_name'].'.'.$row['music_thumb_ext'];
						$populateTopChartBlock_arr['row'][$inc]['music_disp'] = DISP_IMAGE($this->CFG['admin']['musics']['medium_width'], $this->CFG['admin']['musics']['medium_width'], $row['medium_width'], $row['medium_height']);
					}
				else
					{
						$populateTopChartBlock_arr['row'][$inc]['music_image_src'] = '';
						$populateTopChartBlock_arr['row'][$inc]['music_disp'] = '';
					}
				$inc++;
		    	$count++;
		    	$date = $row['date_started'].' to '.$row['date_ended'];
		    	$smartyObj->assign('date_started', $date);
			}
			$smartyObj->assign('populateCarosulTopChartBlock_arr', $populateTopChartBlock_arr);

		}

		public function showAlbums()
    	{
			global $smartyObj;
			$inc = 1;
			$populateTopChartBlock_arr = array();
			$this->no_of_row_topchart=1;
			$count=0;
			$musics_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['musics']['folder'] . '/' .
								$this->CFG['admin']['musics']['thumbnail_folder'] . '/';
			$artist_image_path = $this->CFG['site']['url'].$this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['music_folder'].'/'.$this->CFG['admin']['musics']['artist_image_folder'].'/';
			while ($row = $this->fetchResultRecord())
			{
				$populateTopChartBlock_arr['record_count'] = true;
				$populateTopChartBlock_arr['row'][$inc]['record'] = $row;
				$populateTopChartBlock_arr['row'][$inc]['sale'] = false;
				$populateTopChartBlock_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_album_title'] = $row['album_title'];
				$populateTopChartBlock_arr['row'][$inc]['current_position'] =$row['current_position'];
				if($row['old_position']==0 OR $row['current_position']==$row['old_position'])
				{
					$populateTopChartBlock_arr['row'][$inc]['position'] = '';
					$populateTopChartBlock_arr['row'][$inc]['css'] = 'clsValueEqual';
					$populateTopChartBlock_arr['row'][$inc]['tool_tip'] = $this->LANG['topchart_new_entry'];
				}
				elseif($row['current_position']>$row['old_position'])
				{
					$populateTopChartBlock_arr['row'][$inc]['position'] = $row['old_position']-$row['current_position'];
					$populateTopChartBlock_arr['row'][$inc]['css'] = 'clsValueBottom';
					$populateTopChartBlock_arr['row'][$inc]['tool_tip'] = $this->LANG['topchart_down_entry'];
				}
				elseif($row['current_position']<$row['old_position'])
				{
					$position = $row['old_position']-$row['current_position'];
					$populateTopChartBlock_arr['row'][$inc]['position'] = '+'.$position;
					$populateTopChartBlock_arr['row'][$inc]['css'] = 'clsValueTop';
					$populateTopChartBlock_arr['row'][$inc]['tool_tip'] = $this->LANG['topchart_up_entry'];
				}


					if($pay_details = checkMusicForSale($row['music_id']))
		    		{
		    			$populateTopChartBlock_arr['row'][$inc]['album_for_sale']= false;
						$populateTopChartBlock_arr['row'][$inc]['sale'] = true;
						if($pay_details['album_for_sale']=='Yes' AND $pay_details['album_price']>0)
						{
							$populateTopChartBlock_arr['row'][$inc]['album_for_sale'] = true;
							 $music_price = strstr($pay_details['album_price'], '.');
                               if(!$music_price)
                               {
                                  $pay_details['album_price']=$pay_details['album_price'].'.00';
							   }
							$populateTopChartBlock_arr['row'][$inc]['music_price'] = $this->CFG['currency'].$pay_details['album_price'];
						}
					}
					$populateTopChartBlock_arr['row'][$inc]['musiclistalbum_url'] = getUrl('musiclist', '?pg=musicnew&album_id='.$row['music_album_id'], 'musicnew/?album_id='.$row['music_album_id'], '', 'music');
					$album_image_name = $this->getAlbumImageName($row['music_album_id']);
					$populateTopChartBlock_arr['row'][$inc]['viewalbum_url'] = getUrl('viewalbum', '?album_id='.$row['music_album_id'].'&title='.$this->changeTitle($row['album_title']),$row['music_album_id'].'/'.$this->changeTitle($row['album_title']).'/', '', 'music');
					/*echo '<pre>';
					print_r($album_image_name);
					echo '</pre>';*/
					if($album_image_name['music_thumb_ext'])
						{
							$populateTopChartBlock_arr['row'][$inc]['music_image_src'] = $album_image_name['music_server_url'].$musics_folder.getMusicImageName($album_image_name['music_id'], $album_image_name['file_name']).$this->CFG['admin']['musics']['medium_name'].'.'.$album_image_name['music_thumb_ext'];
							$populateTopChartBlock_arr['row'][$inc]['music_disp'] = DISP_IMAGE($this->CFG['admin']['musics']['medium_width'], $this->CFG['admin']['musics']['medium_width'], $album_image_name['medium_width'], $album_image_name['medium_height']);
						}
					else
						{
							$populateTopChartBlock_arr['row'][$inc]['music_image_src'] = '';
							$populateTopChartBlock_arr['row'][$inc]['music_disp'] = '';
						}
					$inc++;
		    		$count++;
		    		$date = $row['date_started'].' to '.$row['date_ended'];
		    		$smartyObj->assign('date_started', $date);

			}
			$smartyObj->assign('populateTopChartBlock_arr', $populateTopChartBlock_arr);

		}

		public function showArtists()
    	{
			global $smartyObj;
			$inc = 1;
			$populateArtistTopChartBlock_arr = array();
			$this->no_of_row_topchart=1;
			$count=0;
			$musics_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['musics']['folder'] . '/' .
								$this->CFG['admin']['musics']['thumbnail_folder'] . '/';
			$artist_image_path = $this->CFG['site']['url'].$this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['music_folder'].'/'.$this->CFG['admin']['musics']['artist_image_folder'].'/';
			while ($row = $this->fetchResultRecord())
			{
				$populateArtistTopChartBlock_arr['record_count'] = true;
				$populateArtistTopChartBlock_arr['row'][$inc]['record'] = $row;
				$populateArtistTopChartBlock_arr['row'][$inc]['sale'] = false;
				$populateArtistTopChartBlock_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_album_title'] = $row['album_title'];
				$populateArtistTopChartBlock_arr['row'][$inc]['current_position'] =$row['current_position'];
				if($row['old_position']==0 OR $row['current_position']==$row['old_position'])
				{
					$populateArtistTopChartBlock_arr['row'][$inc]['position'] = '';
					$populateArtistTopChartBlock_arr['row'][$inc]['css'] = 'clsValueEqual';
					$populateArtistTopChartBlock_arr['row'][$inc]['tool_tip'] = $this->LANG['topchart_new_entry'];
				}
				elseif($row['current_position']>$row['old_position'])
				{
					$populateArtistTopChartBlock_arr['row'][$inc]['position'] = $row['old_position']-$row['current_position'];
					$populateArtistTopChartBlock_arr['row'][$inc]['css'] = 'clsValueBottom';
					$populateArtistTopChartBlock_arr['row'][$inc]['tool_tip'] = $this->LANG['topchart_up_entry'];
				}
				elseif($row['current_position']<$row['old_position'])
				{
					$position = $row['old_position']-$row['current_position'];
					$populateArtistTopChartBlock_arr['row'][$inc]['position'] = '+'.$position;
					$populateArtistTopChartBlock_arr['row'][$inc]['css'] = 'clsValueTop';
					$populateArtistTopChartBlock_arr['row'][$inc]['tool_tip'] = $this->LANG['topchart_down_entry'];
				}


					$populateArtistTopChartBlock_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_artist_name'] = $row['artist_name'];

					$populateArtistTopChartBlock_arr['row'][$inc]['viewartist_url'] = getMemberProfileUrl($row['user_id'], $row['artist_name']);
					$music_artist_image = getMemberAvatarDetails($row['user_id']);
					//$music_artist_image = $this->getArtistMiniImageName($popular_artist_detail['music_artist_id']);
					if($music_artist_image != '')
						{
							$populateArtistTopChartBlock_arr['row'][$inc]['music_path'] = $music_artist_image['m_url'];
							$populateArtistTopChartBlock_arr['row'][$inc]['disp_image'] = '';
						}
					else
						{
							$populateArtistTopChartBlock_arr['row'][$inc]['music_path'] = '';
							$populateArtistTopChartBlock_arr['row'][$inc]['disp_image'] = '';
						}
					$inc++;
		    		$count++;
		    		$date = $row['date_started'].' to '.$row['date_ended'];
		    		$smartyObj->assign('date_started', $date);

			}
			$smartyObj->assign('populateArtistTopChartBlock_arr', $populateArtistTopChartBlock_arr);

		}

		public function populateCarousalTopChartSalesBlockMusicId($case, $all = false)
			{
				$populateCarousalTopChartBlock_arr = array();
				$populateCarousalTopChartBlock_arr['row'] = array();
				$sql = '';
				$start = 0;
				$opt = '';
				switch($case)
					{
						case 'topChartSongs':
							$default_fields = 'm.music_id, m.music_album_id,m.user_id, m.music_title, ma.album_title, '.
												'm.total_plays as total_count, m.music_server_url, m.music_thumb_ext, '.
												'mc.music_category_id, mc.music_category_name, mfs.file_name, '.
												'm.medium_width, m.medium_height ';

							$from = 'FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.
									$this->CFG['db']['tbl']['music_song_top_chart'].' AS msc ON msc.music_id=m.music_id JOIN '.
									$this->CFG['db']['tbl']['music_files_settings'].' AS mfs '.
									'ON mfs.music_file_id = m.thumb_name_id, '.$this->CFG['db']['tbl']['music_category'].
									' AS mc, '.$this->CFG['db']['tbl']['music_album'].' AS ma, '.
									$this->CFG['db']['tbl']['users'].' AS u ';
							$condition = 'WHERE u.user_id = m.user_id
												AND m.music_category_id = mc.music_category_id
												AND m.music_album_id = ma.music_album_id
												AND u.usr_status = \'Ok\'
												AND m.music_status = \'Ok\'
												AND msc.status=\'Active\'
												AND mc.music_category_status = \'Yes\' '.$this->getAdultQuery('m.', 'music').'
												AND (m.user_id = '.$this->CFG['user']['user_id'].' OR '.
								 				'm.music_access_type = \'Public\''.$this->getAdditionalQuery().')';
							$order_by = ' ORDER BY msc.current_position';
							$sql = 'SELECT '.$default_fields.$from.$condition.$order_by;
							$opt = 'normal';
						break;

					}
				if(!$all)
					$sql .= ' LIMIT '.$start.', '.$this->CFG['admin']['musics']['sidebar_topchart_num_record'];
				else
					$sql .= ' LIMIT '.$start.', '.$this->CFG['admin']['musics']['sidebar_topchart_total_record'];
				//echo $sql;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$inc = 1;
				while($top_chart_block = $rs->FetchRow())
					{
						$populateCarousalTopChartBlock_arr['row'][$inc]['player_music_id_key'] = $this->player_music_id_key;
						$this->player_music_id[$this->player_music_id_key] = $top_chart_block['music_id'];
						$_SESSION['index_player_music_id'][$this->player_music_id_key] = $top_chart_block['music_id'];
						$this->player_music_id_key++;
						$inc++;
					}
			}

		/**
		 * MusicIndexPageHandler::populateHiddenPlayer()
		 *  This method should be called from tpl only
		 *
		 * @return void
		 */
		public function populateHiddenPlayer()
			{
				//Initializing Playlist Player Configuaration
				$this->populatePlayerWithPlaylistConfiguration();
				$music_id_arr = array_unique($this->player_music_id);
				$this->configXmlcode_url .= 'pg=music';
				$this->playlistXmlcode_url .= 'pg=music_0_'.implode(',', $music_id_arr);
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
				$music_array = array(
					'div_id'               => 'chart_flash_player',
					'music_player_id'      => 'chart_hidden_player',
					'width'  		       => 1,
					'height'               => 1,
					'auto_play'            => 'false',
					'hidden'               => true,
					'playlist_auto_play'   => false,
					'javascript_enabled'   => true,
					'player_ready_enabled' => true
				);
				$this->populatePlayerWithPlaylist($music_array);

				echo '<input type="hidden" name="hidden_player_status" id="hidden_player_status" value="no"/>
					  <script language="javascript" type="text/javascript" >
						var total_musics_to_play = '.count($this->player_music_id).';
						var play_functionalities_arr = new Array(\'music_top_chart\');';

						if(!empty($this->player_music_id))
							{
								foreach($this->player_music_id as $music_id_to_play)
									{
										echo 'total_musics_ids_play_arr.push('.$music_id_to_play.');';
									}
							}
				echo '</script>';
			}

		/**
		 * MusicIndexPageHandler::currentlyPlayingChecking()
		 *
		 * @return
		 */
		public function currentlyPlayingChk()
			{
				$add_order = ' ORDER BY m.last_view_date DESC ';
				$sql_condition = ' u.usr_status=\'Ok\' AND m.music_status=\'Ok\''.
								 ' AND (m.user_id = '.$this->CFG['user']['user_id'].
								 ' OR m.music_access_type = \'Public\''.$this->getAdditionalQuery().')'.$this->getAdultQuery('m.', 'music');

				$sql = 'SELECT count(music_id) as total FROM '.$this->CFG['db']['tbl']['music'].
						' AS m JOIN '.$this->CFG['db']['tbl']['users'].' AS u  '.
						'ON m.user_id = u.user_id  WHERE '.$sql_condition.$add_order;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$row = $rs->FetchRow();
				if($row['total'] < $this->CFG['admin']['musics']['index_page_music_list_total_thumbnail'])
					return false;
				else
					return true;
			}

	}
$musicchart = new MusicChartPageHandler();
if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$musicchart->setPageBlockNames(array('sidebar_topcontributors_block', 'sidebar_audio_block',
								'sidebar_topchart_block', 'sidebar_activity_block', 'sidebar_currently_playing_block', 'block_featured_playlist', 'block_feartured_musiclist'));

$musicchart->CFG['admin']['musics']['individual_song_play'] = true;

$musicchart->setAllPageBlocksHide();
$musicchart->setMediaPath('../../');
$musicchart->setFormField('start', '0');
$musicchart->setFormField('block', '');
$musicchart->setFormField('pg', 'topChartSongs');
$musicchart->setFormField('topChart', '');
$musicchart->setFormField('ajax_page', '');
$musicchart->setFormField('activity_type', '');
$musicchart->setFormField('player_mid_key', '');
$musicchart->setFormField('player_mid', '');
$musicchart->setFormField('numpg', $CFG['admin']['musics']['sidebar_topchart_total_record']);

//SHOW BLOCK//
$musicchart->setPageBlockShow('sidebar_artistclouds_block');
$musicchart->setPageBlockShow('sidebar_topcontributors_block');// TOP CONTRIBUTORS //
$musicchart->setPageBlockShow('sidebar_topchart_block');
if($musicchart->currentlyPlayingChk())
	$musicchart->setPageBlockShow('sidebar_currently_playing_block');
//$musicchart->setPageBlockShow('block_featured_playlist');
$musicchart->setPageBlockShow('block_feartured_musiclist');
if($CFG['admin']['musics']['recentlylistenedmusic'] or $CFG['admin']['musics']['recommendedmusic']
	or $CFG['admin']['musics']['newmusic'] or $CFG['admin']['musics']['topratedmusic'])
	$musicchart->setPageBlockShow('sidebar_audio_block');


$musicchart->sanitizeFormInputs($_REQUEST);

if($musicchart->getFormField('pg')=='topChartSongs')
{
	$musicchart->show_div = 'selMusicListContent';
}
elseif($musicchart->getFormField('pg')=='topChartAlbums')
{
	$musicchart->show_div = 'selAlbumListContent';
}
elseif($musicchart->getFormField('pg')=='topChartArtists')
{
	$musicchart->show_div = 'selArtistListContent';
}
$smartyObj->assign('paging_arr',array('pg', 'start'));
$smartyObj->assign('smarty_paging_list', $musicchart->populatePageLinksPOST($musicchart->getFormField('start')));
$musicchart->populateCarousalTopChartSalesBlockMusicId('topChartSongs', true);
$musicchart->setTableAndColumns('topChartSongs');
$musicchart->buildSelectQuery();
$musicchart->buildQuery();
$musicchart->executeQuery();
$musicchart->showMusics();

$musicchart->setTableAndColumns('topChartAlbums');
$musicchart->buildSelectQuery();
$musicchart->buildQuery();
$musicchart->executeQuery();
$musicchart->showAlbums();

$musicchart->setTableAndColumns('topChartArtists');
$musicchart->buildSelectQuery();
$musicchart->buildQuery();
$musicchart->executeQuery();
$musicchart->showArtists();

$musicchart->includeHeader();
?>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/functions.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/JSFCommunicator.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
<script type="text/javascript">
	var show_div = '<?php echo $musicchart->show_div; ?>';
	var more_tabs_div = new Array('selMusicListContent', 'selAlbumListContent', 'selArtistListContent');
	var more_tabs_class = new Array('selHeaderMusicList', 'selHeaderAlbumList', 'selHeaderArtistList');

	var current_active_tab_class = 'clsActiveAudioContentLink';

	Event.observe(window, 'load', function() {
		//To Show the default div and hide the other divs
		hideMoreTabsDivs(show_div); //To hide the more tabs div and set the class to empty
		showMoreTabsDivs(show_div); //To show the more tabs div and set the class to selected
	});

	function loadChartType(path, div_id, current_li_id)
		{
			//result_div = div_id;
			/*more_li_id = current_li_id;
			hideMoreTabsDivs(div_id);
			showMoreTabsDivs(div_id);*/
			var div_value = $(div_id).innerHTML;
			more_li_id = current_li_id;
			div_value = div_value.strip();
			if(div_value == '')
				{
					hideMoreTabsDivs(div_id);
					showMoreTabsDivs(div_id);
					$(div_id).innerHTML = music_ajax_page_loading;
					new prototype_ajax(path, 'insertChartContent');
				}
			else
				{
					hideMoreTabsDivs(div_id);
					showMoreTabsDivs(div_id);
				}
		}

	function insertChartContent(data)
		{
			data = unescape(data.responseText);
			var script_data = '';
			var obj = document.getElementById(result_div);
			obj.style.display = 'block';
			obj.innerHTML = data;
			if(script_data != '')
				eval(script_data);
		}

</script>
<?php
setTemplateFolder('general/', 'music');
$smartyObj->display('musicTopChartSales.tpl');
$musicchart->includeFooter();
?>