<?php
//--------------class MusicIndexPageHandler--------------->>>//
/**
 * This class is used to list music insex page
 *
 * @category	Rayzz
 * @package		manage music imdex
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 */
class MusicIndexPageHandler extends MusicHandler
	{
		public $default_active_div = array();
		public $player_music_id = array();
		public $player_music_id_key = 1;

		/**
		 * MusicIndexPageHandler::topContributors()
		 *
		 * @return
		 */
		public function topContributors()
			{
				populateMusicTopContributors();
			}

		/**
		 * MusicIndexPageHandler::loadSetting()
		 *
		 * @return
		 */
		public function loadSetting()
			{
				$block_array = array('recentlylistenedmusic', 'recommendedmusic', 'newmusic', 'topratedmusic');
				$flag = 1;
				foreach($block_array as $block_name)
					{
						if($this->CFG['admin']['musics'][$block_name])
							{
								if($flag)
									{
										$this->default_active_div[$block_name] = '';
										$this->default_active_block_name = $block_name;
										$flag = 0;
									}
								else
									{
										$this->default_active_div[$block_name] = 'display:none;';
									}
							}
					}
			}

		/**
		 * MusicIndexPageHandler::getTotalMusicListPages()
		 * Function to get the total no of pages for the music carousel
		 *
		 * @param string $block_name
		 * @param int $limit no of records to be shown per page in the carousel,
		 * 				value can be varied / passed from tpl
		 * @return int total pages
		 */
		public function getTotalMusicListPages($block_name, $limit)
		{

			$default_cond = ' u.user_id=m.user_id AND u.usr_status=\'Ok\' AND m.music_status=\'Ok\''.$this->getAdultQuery('m.', 'music').
								 ' AND (m.user_id = '.$this->CFG['user']['user_id'].' OR'.
								 ' m.music_access_type = \'Public\''.$this->getAdditionalQuery().')';
			$global_limit = 100; //to avoid overloading

			switch($block_name)
			{
				case 'recentlylistenedmusic':
				case 'newmusic':
					$condition = $default_cond;
					break;
				case 'recommendedmusic':
					$condition = 'm.music_featured=\'Yes\' AND '.$default_cond;
					break;
				case 'topratedmusic':
					$condition = 'm.rating_total>0 AND m.allow_ratings=\'Yes\' AND '.$default_cond;
					break;
			}

			$sql = 'SELECT COUNT(*) AS total_music FROM '.$this->CFG['db']['tbl']['music'].
					' AS m , '.$this->CFG['db']['tbl']['users'].' AS u '.
					'WHERE '.$condition . ' LIMIT ' . $global_limit;

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
				trigger_db_error($this->dbObj);

			if($row = $rs->FetchRow())
		    {
				$record_count = $row['total_music'];
				$total_pages = ceil($record_count/$limit);
				return $total_pages;
		    }
		    else
		    {
				return 0;
			}
		}



		/**
		 * MusicIndexPageHandler::populateCarousalMusicBlock()
		 * sets the values in $populateCarousalMusicBlock_arr to be displayed from
		 * tpl.
		 *
		 *
		 * @param string $case
		 * @param int $page_no - page no starts with 1 passed in query string
		 * @param int $rec_per_page - rec per page in carousel passed in query string
		 * @return void
		 */
		public function populateCarousalMusicBlock($case, $page_no=1, $rec_per_page=4)
			{

				global $smartyObj;
				$populateCarousalMusicBlock_arr['row'] = array();
				$start = ($page_no -1) * $rec_per_page; // start = (pageno -1) * rec per page

				$default_cond = ' u.user_id=m.user_id AND m.music_album_id = ma.music_album_id AND u.usr_status=\'Ok\' AND m.music_status=\'Ok\''.$this->getAdultQuery('m.', 'music').
								 ' AND (m.user_id = '.$this->CFG['user']['user_id'].' OR'.
								 ' m.music_access_type = \'Public\''.$this->getAdditionalQuery().')';

				$default_fields = 'm.music_id,m.user_id, m.music_title, ma.album_title, (m.rating_total/m.rating_count) as rating , m.music_server_url, m.music_thumb_ext, mfs.file_name, m.thumb_width, m.thumb_height,ma.music_album_id,m.playing_time, TIMEDIFF(NOW(), m.date_added) AS date_added ';

				switch($case)
					{
						case 'recentlylistenedmusic':
							$order_by = 'last_view_date DESC';
							$condition = $default_cond;
							$sql = 'SELECT '.$default_fields.' '.
									'FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs ON mfs.music_file_id = m.thumb_name_id, '.$this->CFG['db']['tbl']['music_album'].' AS ma, '.$this->CFG['db']['tbl']['users'].' AS u '.
									'WHERE '.$condition.' ORDER BY '.$order_by;
						break;

						case 'recommendedmusic':
							$order_by = 'm.featured_music_order_id ASC';
							$condition = 'm.music_featured=\'Yes\' AND '.$default_cond;
							$sql = 'SELECT '.$default_fields.' '.
									' ,featured_music_order_id  FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs ON mfs.music_file_id = m.thumb_name_id, '.$this->CFG['db']['tbl']['music_album'].' AS ma, '.$this->CFG['db']['tbl']['users'].' AS u '.
									'WHERE '.$condition.' ORDER BY '.$order_by;
						break;

						case 'newmusic'://NEW MUSIC//
							$condition = $default_cond;
							$order_by = ' m.music_id DESC ';
							$sql = 'SELECT '.$default_fields.' '.
									'FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs ON mfs.music_file_id = m.thumb_name_id, '.$this->CFG['db']['tbl']['music_album'].' AS ma, '.$this->CFG['db']['tbl']['users'].' AS u '.
									'WHERE '.$condition.' ORDER BY '.$order_by;
						break;

						case 'topratedmusic':
							$order_by = 'rating DESC';
							$condition = 'm.rating_total>0 AND m.allow_ratings=\'Yes\' AND '.$default_cond;
							$sql = 'SELECT '.$default_fields.' '.
									'FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs ON mfs.music_file_id = m.thumb_name_id, '.$this->CFG['db']['tbl']['music_album'].' AS ma, '.$this->CFG['db']['tbl']['users'].' AS u '.
									'WHERE '.$condition.' ORDER BY '.$order_by;
						break;
					}

				$sql .= ' LIMIT '.$start.', '.$rec_per_page;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);

			    if (!$rs)
					trigger_db_error($this->dbObj);

				$inc = 1;
				$musics_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['musics']['folder'] . '/' . $this->CFG['admin']['musics']['thumbnail_folder'] . '/';
				$this->is_not_member_url = getUrl('index','','','','music');
				while($music_detail = $rs->FetchRow())
		    		{
		    			//not used in rayzz3 since we dont have the concept of sales taken from volume
		    			if($pay_details = checkMusicForSale($music_detail['music_id']))
			    		{
			    			$populateCarousalMusicBlock_arr['row'][$inc]['for_sale']= false;
			    			$populateCarousalMusicBlock_arr['row'][$inc]['album_for_sale']= false;
							$populateCarousalMusicBlock_arr['row'][$inc]['sale'] = true;
							if($pay_details['album_for_sale']=='Yes' AND $pay_details['album_price']>0)
							{
								$populateCarousalMusicBlock_arr['row'][$inc]['album_for_sale'] = true;
								$music_price = strstr($pay_details['album_price'], '.');
                                if(!$music_price)
                                {
                                  $pay_details['album_price']=$pay_details['album_price'].'.00';
							    }
								$populateCarousalMusicBlock_arr['row'][$inc]['music_price'] = $this->CFG['currency'].$pay_details['album_price'];
							}
							else if($pay_details['for_sale']=='Yes' AND $pay_details['music_price']>0)
							{
								$populateCarousalMusicBlock_arr['row'][$inc]['for_sale'] = true;
								$music_price = strstr($pay_details['music_price'], '.');
                                if(!$music_price)
                                {
                                  $pay_details['music_price']=$pay_details['music_price'].'.00';
							    }
								$populateCarousalMusicBlock_arr['row'][$inc]['music_price'] = $this->CFG['currency'].$pay_details['music_price'];
							}
						}
		    			$populateCarousalMusicBlock_arr['row'][$inc]['record'] = $music_detail;
		    			$populateCarousalMusicBlock_arr['row'][$inc]['music_title'] = $music_detail['music_title'];
		    			$populateCarousalMusicBlock_arr['row'][$inc]['album_title'] = $music_detail['album_title'];
		    			$populateCarousalMusicBlock_arr['row'][$inc]['viewmusic_url'] = getUrl('viewmusic', '?music_id='.$music_detail['music_id'].'&title='.$this->changeTitle($music_detail['music_title']), $music_detail['music_id'].'/'.$this->changeTitle($music_detail['music_title']).'/', '', 'music');
	    				$populateCarousalMusicBlock_arr['row'][$inc]['get_viewalbum_url'] = getUrl('viewalbum', '?album_id='.$music_detail['music_album_id'].'&title='.$this->changeTitle($music_detail['album_title']),$music_detail['music_album_id'].'/'.$this->changeTitle($music_detail['album_title']).'/', '', 'music');
						$populateCarousalMusicBlock_arr['row'][$inc]['playing_time'] =  $this->fmtMusicPlayingTime($music_detail['playing_time']);
						// IMAGE //
						if($music_detail['music_thumb_ext'])
							{
								$populateCarousalMusicBlock_arr['row'][$inc]['music_image_src'] = $music_detail['music_server_url'].$musics_folder.getMusicImageName($music_detail['music_id'], $music_detail['file_name']).$this->CFG['admin']['musics']['thumb_name'].'.'.$music_detail['music_thumb_ext'];
								$populateCarousalMusicBlock_arr['row'][$inc]['thumb_width'] = $music_detail['thumb_width'];
								$populateCarousalMusicBlock_arr['row'][$inc]['thumb_height'] = $music_detail['thumb_height'];
							}
						else
							{
								$populateCarousalMusicBlock_arr['row'][$inc]['music_image_src'] = '';
							}
						/* ADDED TO DISPLAY MUSIC DETAILS LIKE RATING / ADDED TIME ... WITH MUSIC TITLE */
						if($case == 'newmusic')
						{
							$populateCarousalMusicBlock_arr['row'][$inc]['extra_music_details'] = ($music_detail['date_added'] != '') ? '- ' . getTimeDiffernceFormat($music_detail['date_added']) : '';
						}
						else if($case == 'topratedmusic')
						{
							$populateCarousalMusicBlock_arr['row'][$inc]['extra_music_details'] = '- ' . $this->LANG['common_music_rating'] . ' ' . round($music_detail['rating']);
						}
						else
						{
							$populateCarousalMusicBlock_arr['row'][$inc]['extra_music_details'] = '';
						}
						$inc++;
		    		}
				$music_block_record_count = $inc - 1;
				$smartyObj->assign('populateCarousalMusicBlock_arr', $populateCarousalMusicBlock_arr);
		    	$smartyObj->assign('music_block_record_count', $music_block_record_count);//is record found
				setTemplateFolder('general/', 'music');
				$smartyObj->display('indexAudioBlockContent.tpl');
			}

		/**
		 * MusicIndexPageHandler::getTotalTopChartPages()
		 * Function to get the total no of pages for the top chart carousel
		 *
		 * @param string $case - selected top chart tab
		 * @param int $limit no of records to be shown per page in the top chart carousel,
		 * 				value can be varied / passed from tpl
		 * @return int total top chart pages
		 */
		public function getTotalTopChartPages($case, $limit)
		{
			$global_limit = 100; //to avoid overloading

			switch($case)
					{
						case 'topChartSongs':
							$from = 'FROM '.$this->CFG['db']['tbl']['music'].' AS m, '.$this->CFG['db']['tbl']['music_category'].
									' AS mc, '.$this->CFG['db']['tbl']['music_album'].' AS ma, '.
									$this->CFG['db']['tbl']['users'].' AS u ';
							$condition = 'WHERE u.user_id = m.user_id
												AND m.music_category_id = mc.music_category_id
												AND m.music_album_id = ma.music_album_id
												AND u.usr_status = \'Ok\'
												AND m.music_status = \'Ok\'
												AND m.total_plays > 0
												AND mc.music_category_status = \'Yes\' '.$this->getAdultQuery('m.', 'music').'
												AND (m.user_id = '.$this->CFG['user']['user_id'].' OR '.
								 				'm.music_access_type = \'Public\''.$this->getAdditionalQuery().')';
							$sql = 'SELECT COUNT(*) as total_music '.$from.$condition;
						break;

						case 'topChartDownloads':
							$from = 'FROM '.$this->CFG['db']['tbl']['music'].' AS m, '.$this->CFG['db']['tbl']['music_category'].
									' AS mc, '.$this->CFG['db']['tbl']['music_album'].' AS ma, '.$this->CFG['db']['tbl']['users'].' AS u ';
							$condition = 'WHERE u.user_id = m.user_id
												AND m.music_category_id = mc.music_category_id
												AND m.music_album_id = ma.music_album_id
												AND u.usr_status = \'Ok\'
												AND m.music_status = \'Ok\'
												AND mc.music_category_status = \'Yes\''.$this->getAdultQuery('m.', 'music').'
												AND (m.user_id = '.$this->CFG['user']['user_id'].' OR'.
								 				' m.music_access_type = \'Public\''.
												 $this->getAdditionalQuery().') AND m.total_downloads > 0 ';
							$sql = 'SELECT COUNT(DISTINCT (music_id)) as total_music '.$from.$condition;
						break;

						case 'topChartAlbums':
							$from = 'FROM '.$this->CFG['db']['tbl']['music'].' AS m , '.$this->CFG['db']['tbl']['music_album'].
									' AS ma, '.$this->CFG['db']['tbl']['users'].' AS u ';
							$condition = 'WHERE u.user_id = m.user_id
											AND m.music_album_id = ma.music_album_id
											AND u.usr_status = \'Ok\'
											AND m.music_status = \'Ok\' '.$this->getAdultQuery('m.', 'music').'
											AND (m.user_id = '.$this->CFG['user']['user_id'].' OR '.
								 			'm.music_access_type = \'Public\''.$this->getAdditionalQuery().')';
							$sql = 'SELECT COUNT(DISTINCT (ma.music_album_id) ) as total_music '.$from.$condition;
						break;
					}

			$sql = $sql . ' LIMIT ' . $global_limit;

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
				trigger_db_error($this->dbObj);

			if($row = $rs->FetchRow())
		    {
				$record_count = $row['total_music'];
				$total_pages = ceil($record_count/$limit);
				return $total_pages;
		    }
		    else
		    {
				return 0;
			}
		}


		/**
		 * MusicIndexPageHandler::populateCarousalTopChartBlock()
		 * sets the values in $populateCarousalTopChartBlock_arr to be displayed from
		 * tpl.
		 *
		 *
		 * @param string $case
		 * @param int $page_no - page no starts with 1 passed in query string
		 * @param int $rec_per_page - rec per page in carousel passed in query string
		 * @return void
		 */
		public function populateCarousalTopChartBlock($case, $page_no = 1, $rec_per_page = 4)
			{

				global $smartyObj;
				$populateCarousalTopChartBlock_arr = array();
				$populateCarousalTopChartBlock_arr['record_count'] = false;
				$populateCarousalTopChartBlock_arr['row'] = array();
				$sql = '';
				$start = ($page_no -1) * $rec_per_page; // start = (pageno -1) * rec per page
				$opt = '';
				$script_case = '';
				switch($case)
					{
						case 'topChartSongs':
							$default_fields = 'm.music_id, m.music_album_id, m.music_title, ma.album_title, '.
												'm.total_plays as total_count, m.music_server_url, m.music_thumb_ext, '.
												'mc.music_category_id, mc.music_category_name, mfs.file_name, '.
												'm.thumb_width, m.thumb_height,m.music_price,ma.album_price,m.for_sale,ma.album_for_sale,m.user_id ';

							$from = 'FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.
									$this->CFG['db']['tbl']['music_files_settings'].' AS mfs '.
									'ON mfs.music_file_id = m.thumb_name_id, '.$this->CFG['db']['tbl']['music_category'].
									' AS mc, '.$this->CFG['db']['tbl']['music_album'].' AS ma, '.
									$this->CFG['db']['tbl']['users'].' AS u ';
							$condition = 'WHERE u.user_id = m.user_id
												AND m.music_category_id = mc.music_category_id
												AND m.music_album_id = ma.music_album_id
												AND u.usr_status = \'Ok\'
												AND m.music_status = \'Ok\'
												AND m.total_plays > 0
												AND mc.music_category_status = \'Yes\' '.$this->getAdultQuery('m.', 'music').'
												AND (m.user_id = '.$this->CFG['user']['user_id'].' OR '.
								 				'm.music_access_type = \'Public\''.$this->getAdditionalQuery().')';
							$order_by = ' ORDER BY total_count DESC';
							$sql = 'SELECT '.$default_fields.$from.$condition.$order_by;
							$script_case = 'top_chart';
							$opt = 'normal';
							$smartyObj->assign('case', $case);
							$smartyObj->assign('topchartlabel', $this->LANG['sidebar_topchart_plays_label']);
						break;

						case 'topChartDownloads':
							$default_fields = 'm.music_id, m.music_album_id, m.music_title, ma.album_title,'.
												'm.total_downloads as total_count, mc.music_category_id, '.
												'mc.music_category_name, m.music_server_url, m.music_thumb_ext,'.
												' mfs.file_name, m.thumb_width, m.thumb_height, m.music_price, ma.album_price,m.for_sale,ma.album_for_sale,m.user_id ';

							$from = 'FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.
									$this->CFG['db']['tbl']['music_files_settings'].' AS mfs '.
									'ON mfs.music_file_id = m.thumb_name_id, '.$this->CFG['db']['tbl']['music_category'].
									' AS mc, '.$this->CFG['db']['tbl']['music_album'].' AS ma, '.$this->CFG['db']['tbl']['users'].' AS u ';
							$condition = 'WHERE u.user_id = m.user_id
												AND m.music_category_id = mc.music_category_id
												AND m.music_album_id = ma.music_album_id
												AND u.usr_status = \'Ok\'
												AND m.music_status = \'Ok\'
												AND mc.music_category_status = \'Yes\''.$this->getAdultQuery('m.', 'music').'
												AND (m.user_id = '.$this->CFG['user']['user_id'].' OR'.
								 				' m.music_access_type = \'Public\''.
												 $this->getAdditionalQuery().') GROUP BY music_id HAVING total_count > 0 ';

							$order_by = ' ORDER BY total_count DESC';
							$sql = 'SELECT '.$default_fields.$from.$condition.$order_by;
							$script_case = 'top_downloads';
							$opt = 'normal';
							$smartyObj->assign('topchartlabel', $this->LANG['sidebar_topchart_downloads_label']);
						break;

						case 'topChartAlbums':
							$default_fields = 'count( m.music_id ) AS total_song, sum( m.total_plays ) AS total_count,'.
												'ma.music_album_id, ma.album_title,ma.album_price,m.music_id,ma.album_for_sale,m.user_id ';

							$from = 'FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.
									$this->CFG['db']['tbl']['music_files_settings'].' AS mfs '.
									'ON mfs.music_file_id = m.thumb_name_id, '.$this->CFG['db']['tbl']['music_album'].
									' AS ma, '.$this->CFG['db']['tbl']['users'].' AS u ';
							$condition = 'WHERE u.user_id = m.user_id
											AND m.music_album_id = ma.music_album_id
											AND u.usr_status = \'Ok\'
											AND m.music_status = \'Ok\' '.$this->getAdultQuery('m.', 'music').'
											AND (m.user_id = '.$this->CFG['user']['user_id'].' OR '.
								 			'm.music_access_type = \'Public\''.$this->getAdditionalQuery().') GROUP BY ma.music_album_id HAVING total_count > 0';

							$order_by = ' ORDER BY total_count DESC';
							$sql = 'SELECT '.$default_fields.$from.$condition.$order_by;
							$opt = 'albums';
						break;
					}
				$smartyObj->assign('script_case', $script_case);
				$sql .= ' LIMIT '.$start.', '.$rec_per_page;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
					trigger_db_error($this->dbObj);

				$inc = 1;

				$this->no_of_row_topchart=1;
				$count=0;
				$smartyObj->assign('opt', $opt);
				$musics_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['musics']['folder'] . '/' .
									$this->CFG['admin']['musics']['thumbnail_folder'] . '/';
				while($top_chart_block = $rs->FetchRow())
					{
						$populateCarousalTopChartBlock_arr['record_count'] = true;
						$populateCarousalTopChartBlock_arr['row'][$inc]['record'] = $top_chart_block;
						if($opt == 'albums')
							{
								$populateCarousalTopChartBlock_arr['row'][$inc]['musiclistalbum_url'] = getUrl('musiclist', '?pg=musicnew&album_id='.$top_chart_block['music_album_id'], 'musicnew/?album_id='.$top_chart_block['music_album_id'], '', 'music');
								$album_image_name = $this->getAlbumImageName($top_chart_block['music_album_id']);

                                $populateCarousalTopChartBlock_arr['row'][$inc]['sale'] = false;
                                $populateCarousalTopChartBlock_arr['row'][$inc]['album_for_sale']=$top_chart_block['album_for_sale'];
                                $populateCarousalTopChartBlock_arr['row'][$inc]['user_id']=$top_chart_block['user_id'];
								if($pay_details = checkMusicForSale($top_chart_block['music_id']))
					    		{

									if($pay_details['album_for_sale']=='Yes' AND $pay_details['album_price']>0)
									{
										$populateCarousalTopChartBlock_arr['row'][$inc]['sale'] = true;
										$music_price = strstr($pay_details['album_price'], '.');
		                                if(!$music_price)
		                                {
		                                  $pay_details['album_price']=$pay_details['album_price'].'.00';
									    }
										$populateCarousalTopChartBlock_arr['row'][$inc]['music_price'] = $this->CFG['currency']
										.$pay_details['album_price'];
									}

					    		}
								$populateCarousalTopChartBlock_arr['row'][$inc]['viewalbum_url'] = getUrl('viewalbum', '?album_id='.$top_chart_block['music_album_id'].'&title='.$this->changeTitle($top_chart_block['album_title']),$top_chart_block['music_album_id'].'/'.$this->changeTitle($top_chart_block['album_title']).'/', '', 'music');
								if($album_image_name['music_thumb_ext'])
									{
										$populateCarousalTopChartBlock_arr['row'][$inc]['music_image_src'] = $album_image_name['music_server_url'].$musics_folder.getMusicImageName($album_image_name['music_id'], $album_image_name['file_name']).$this->CFG['admin']['musics']['thumb_name'].'.'.$album_image_name['music_thumb_ext'];
										$populateCarousalTopChartBlock_arr['row'][$inc]['thumb_width'] = $album_image_name['thumb_width'];
										$populateCarousalTopChartBlock_arr['row'][$inc]['thumb_height'] = $album_image_name['thumb_height'];
									}
								else
									{
										$populateCarousalTopChartBlock_arr['row'][$inc]['music_image_src'] = '';
									}
							}
						else if($opt == 'normal')
							{
							if($pay_details = checkMusicForSale($top_chart_block['music_id']))
								{
									$populateCarousalTopChartBlock_arr['row'][$inc]['for_sale']= false;
									$populateCarousalTopChartBlock_arr['row'][$inc]['album_for_sale']= false;
									$populateCarousalTopChartBlock_arr['row'][$inc]['sale'] = true;
									if($pay_details['album_for_sale']=='Yes' AND $pay_details['album_price']>0)
									{
										$populateCarousalTopChartBlock_arr['row'][$inc]['album_for_sale'] = true;
										$music_price = strstr($pay_details['album_price'], '.');
								        if(!$music_price)
								        {
								          $pay_details['album_price']=$pay_details['album_price'].'.00';
									    }
										$populateCarousalTopChartBlock_arr['row'][$inc]['music_price'] = $this->CFG['currency'].$pay_details['album_price'];
									}
									else if($pay_details['for_sale']=='Yes' AND $pay_details['music_price']>0)
									{
										$populateCarousalTopChartBlock_arr['row'][$inc]['for_sale'] = true;
										$music_price = strstr($pay_details['music_price'], '.');
								        if(!$music_price)
								        {
								          $pay_details['music_price']=$pay_details['music_price'].'.00';
									    }
										$populateCarousalTopChartBlock_arr['row'][$inc]['music_price'] = $this->CFG['currency'].$pay_details['music_price'];
									}

  								}

								$populateCarousalTopChartBlock_arr['row'][$inc]['title_url'] = getUrl('viewmusic', '?music_id='.$top_chart_block['music_id'].'&title='.$this->changeTitle($top_chart_block['music_title']), $top_chart_block['music_id'].'/'.$this->changeTitle($top_chart_block['music_title']).'/', '', 'music');
								$populateCarousalTopChartBlock_arr['row'][$inc]['musiccategory_url'] = getUrl('musiclist', '?pg=musicnew&cid='.$top_chart_block['music_category_id'], 'musicnew/?cid='.$top_chart_block['music_category_id'], '', 'music');
								$populateCarousalTopChartBlock_arr['row'][$inc]['viewalbum_url'] = getUrl('viewalbum', '?album_id='.$top_chart_block['music_album_id'].'&title='.$this->changeTitle($top_chart_block['album_title']),$top_chart_block['music_album_id'].'/'.$this->changeTitle($top_chart_block['album_title']).'/', '', 'music');
								// IMAGE //
								if($top_chart_block['music_thumb_ext'])
									{
										$populateCarousalTopChartBlock_arr['row'][$inc]['music_image_src'] = $top_chart_block['music_server_url'].$musics_folder.getMusicImageName($top_chart_block['music_id'], $top_chart_block['file_name']).$this->CFG['admin']['musics']['thumb_name'].'.'.$top_chart_block['music_thumb_ext'];
										$populateCarousalTopChartBlock_arr['row'][$inc]['thumb_width'] = $top_chart_block['thumb_width'];
										$populateCarousalTopChartBlock_arr['row'][$inc]['thumb_height'] = $top_chart_block['thumb_height'];
									}
								else
									{
										$populateCarousalTopChartBlock_arr['row'][$inc]['music_image_src'] = '';
									}
							}
						if($count%$this->CFG['admin']['musics']['sidebar_audiotabs_num_record_per_row'] == 0)
							{
								$this->no_of_row_topchart++;
							}
						$inc++;
		    			$count++;
					}
				$smartyObj->assign('populateCarousalTopChartBlock_arr', $populateCarousalTopChartBlock_arr);
				setTemplateFolder('general/', 'music');
				$smartyObj->display('indexTopChartContent.tpl');
			}


		public function populateCarousalTopChartSalesBlock($case, $all = false)
			{

				global $smartyObj;
				$populateCarousalTopChartBlock_arr = array();
				$populateCarousalTopChartBlock_arr['record_count'] = false;
				$populateCarousalTopChartBlock_arr['row'] = array();
				$sql = '';
				$start = 0;
				$start = $this->getFormField('start');
				$this->setFormField('topChart', $case);
				$opt = '';
				$script_case = '';
				switch($case)
					{
						case 'topChartSongs':
							$default_fields = 'm.music_id, m.music_album_id,m.user_id, m.music_title, ma.album_title, '.
												'm.total_plays as total_count, m.music_server_url, m.music_thumb_ext, '.
												'mc.music_category_id, mc.music_category_name, mfs.file_name, '.
												'm.medium_width, m.medium_height, msc.total_sales,msc.current_position, msc.old_position ';

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
							$script_case = 'top_chart';
							$opt = 'normal';
							$smartyObj->assign('case', $case);
							$smartyObj->assign('topchartlabel', $this->LANG['sidebar_topchart_plays_label']);
						break;

						case 'topChartArtists':
							//removed album title since it is not related to here and added the status for active
							$sql = ' SELECT u.user_name as artist_name,  u.user_id, count(m.music_id) as total_song, sum( total_plays ) AS total_count, '.
									' u.sex,mtc.current_position, mtc.old_position, u.image_ext, u.icon_type, u.icon_id'.
									' FROM '.$this->CFG['db']['tbl']['music_artist_top_chart'].' as mtc LEFT JOIN '.$this->CFG['db']['tbl']['users'].' as u '.
									' ON mtc.user_id = u.user_id LEFT JOIN '.
									$this->CFG['db']['tbl']['music'].' as m ON m.user_id=u.user_id '.
									' WHERE u.usr_status=\'Ok\' AND m.music_status = \'Ok\' AND mtc.status = \'Active\' AND u.music_user_type=\'Artist\''.
									' GROUP BY u.user_id ORDER BY current_position ';
//
//							$order_by = ' ORDER BY mtc.current_position';
//							$sql = 'SELECT '.$default_fields.$from.$condition.$order_by;
							$script_case = 'top_artists';
							$opt = 'artist';
							$smartyObj->assign('case', $case);
							//S$smartyObj->assign('topchartlabel', $this->LANG['sidebar_topchart_downloads_label']);
						break;

						case 'topChartAlbums':
							$default_fields = 'count( m.music_id ) AS total_song, sum( m.total_plays ) AS total_count,'.
												'ma.music_album_id,m.user_id,m.music_id, ma.album_title, mca.current_position, mca.old_position ';

							$from = 'FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.
									$this->CFG['db']['tbl']['music_album_top_chart'].' AS mca '.
									' ON mca.album_id=m.music_album_id JOIN '.
									$this->CFG['db']['tbl']['music_files_settings'].' AS mfs '.
									'ON mfs.music_file_id = m.thumb_name_id, '.$this->CFG['db']['tbl']['music_album'].
									' AS ma, '.$this->CFG['db']['tbl']['users'].' AS u ';
							$condition = 'WHERE u.user_id = m.user_id
											AND m.music_album_id = ma.music_album_id
											AND u.usr_status = \'Ok\'
											AND mca.status = \'Active\'
											AND m.music_status = \'Ok\' '.$this->getAdultQuery('m.', 'music').'
											AND (m.user_id = '.$this->CFG['user']['user_id'].' OR '.
								 			'm.music_access_type = \'Public\''.$this->getAdditionalQuery().') GROUP BY ma.music_album_id HAVING total_count > 0';

							$order_by = ' ORDER BY mca.current_position';
							$sql = 'SELECT '.$default_fields.$from.$condition.$order_by;
							$opt = 'albums';
						break;
					}
				$smartyObj->assign('script_case', $script_case);
				/* limit commented because we get all music and displayed using jquery carousel */
				/*if(!$all)
					$sql .= ' LIMIT '.$start.', '.$this->CFG['admin']['musics']['sidebar_topchart_num_record'];
				else
					$sql .= ' LIMIT '.$start.', '.$this->CFG['admin']['musics']['sidebar_topchart_total_record'];*/
				//echo $sql;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
					trigger_db_error($this->dbObj);

				$record_count = $rs->PO_RecordCount();
				if($all)
					return $record_count;

				$inc = 1;

				$this->no_of_row_topchart=1;
				$count=0;
				$smartyObj->assign('opt', $opt);
				$musics_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['musics']['folder'] . '/' .
									$this->CFG['admin']['musics']['thumbnail_folder'] . '/';
				$artist_image_path = $this->CFG['site']['url'].$this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['music_folder'].'/'.$this->CFG['admin']['musics']['artist_image_folder'].'/';
				while($top_chart_block = $rs->FetchRow())
					{
						$populateCarousalTopChartBlock_arr['record_count'] = true;
						$populateCarousalTopChartBlock_arr['row'][$inc]['record'] = $top_chart_block;
						$populateCarousalTopChartBlock_arr['row'][$inc]['sale'] = false;
						$populateCarousalTopChartBlock_arr['row'][$inc]['current_position'] =$top_chart_block['current_position'];
						$populateCarousalTopChartBlock_arr['row'][$inc]['tool_tip'] = '';
						if($top_chart_block['old_position']==0 )
						{
							$populateCarousalTopChartBlock_arr['row'][$inc]['position'] = '';
							$populateCarousalTopChartBlock_arr['row'][$inc]['tool_tip'] = $this->LANG['topchart_new_entry'];
							$populateCarousalTopChartBlock_arr['row'][$inc]['css'] = 'clsValueNoChange';
						}
						elseif($top_chart_block['current_position']==$top_chart_block['old_position'])
						{
							$populateCarousalTopChartBlock_arr['row'][$inc]['position'] = '';
							$populateCarousalTopChartBlock_arr['row'][$inc]['tool_tip'] = $this->LANG['topchart_no_change'];
							$populateCarousalTopChartBlock_arr['row'][$inc]['css'] = 'clsValueEqual';
						}
						elseif($top_chart_block['current_position']>$top_chart_block['old_position'])
						{
							$populateCarousalTopChartBlock_arr['row'][$inc]['position'] = $top_chart_block['old_position']-$top_chart_block['current_position'];
							$populateCarousalTopChartBlock_arr['row'][$inc]['css'] = 'clsValueBottom';
							$populateCarousalTopChartBlock_arr['row'][$inc]['tool_tip'] = $this->LANG['topchart_down_entry'];
						}
						elseif($top_chart_block['current_position']<$top_chart_block['old_position'])
						{
							$position = $top_chart_block['old_position']-$top_chart_block['current_position'];
							$populateCarousalTopChartBlock_arr['row'][$inc]['position'] = '+'.$position;
							$populateCarousalTopChartBlock_arr['row'][$inc]['css'] = 'clsValueTop';
							$populateCarousalTopChartBlock_arr['row'][$inc]['tool_tip'] = $this->LANG['topchart_up_entry'];
						}
						if($opt == 'albums')
							{
								if($pay_details = checkMusicForSale($top_chart_block['music_id']))
					    		{
					    			$populateCarousalTopChartBlock_arr['row'][$inc]['album_for_sale']= false;
									$populateCarousalTopChartBlock_arr['row'][$inc]['sale'] = true;
									if($pay_details['album_for_sale']=='Yes' AND $pay_details['album_price']>0)
									{
										$populateCarousalTopChartBlock_arr['row'][$inc]['album_for_sale'] = true;
										$music_price = strstr($pay_details['album_price'], '.');
		                                if(!$music_price)
		                                {
		                                  $pay_details['album_price']=$pay_details['album_price'].'.00';
									    }
										$populateCarousalTopChartBlock_arr['row'][$inc]['music_price'] = $this->CFG['currency'].$pay_details['album_price'];
									}
								}
								$populateCarousalTopChartBlock_arr['row'][$inc]['musiclistalbum_url'] = getUrl('musiclist', '?pg=musicnew&album_id='.$top_chart_block['music_album_id'], 'musicnew/?album_id='.$top_chart_block['music_album_id'], '', 'music');
								$album_image_name = $this->getAlbumImageName($top_chart_block['music_album_id']);
								$populateCarousalTopChartBlock_arr['row'][$inc]['viewalbum_url'] = getUrl('viewalbum', '?album_id='.$top_chart_block['music_album_id'].'&title='.$this->changeTitle($top_chart_block['album_title']),$top_chart_block['music_album_id'].'/'.$this->changeTitle($top_chart_block['album_title']).'/', '', 'music');
								if($album_image_name['music_thumb_ext'])
									{
										$populateCarousalTopChartBlock_arr['row'][$inc]['music_image_src'] = $album_image_name['music_server_url'].$musics_folder.getMusicImageName($album_image_name['music_id'], $album_image_name['file_name']).$this->CFG['admin']['musics']['medium_name'].'.'.$album_image_name['music_thumb_ext'];
										$populateCarousalTopChartBlock_arr['row'][$inc]['music_disp'] = DISP_IMAGE($this->CFG['admin']['musics']['medium_width'], $this->CFG['admin']['musics']['medium_width'], $album_image_name['medium_width'], $album_image_name['medium_height']);
									}
								else
									{
										$populateCarousalTopChartBlock_arr['row'][$inc]['music_image_src'] = '';
										$populateCarousalTopChartBlock_arr['row'][$inc]['music_disp'] = '';
									}
							}
						else if($opt == 'artist')
						{
							$populateCarousalTopChartBlock_arr['row'][$inc]['viewartist_url'] = getMemberProfileUrl($top_chart_block['user_id'], $top_chart_block['artist_name']);
							$music_artist_image = getMemberAvatarDetails($top_chart_block['user_id']);
							//$music_artist_image = $this->getArtistMiniImageName($popular_artist_detail['music_artist_id']);
							if($music_artist_image != '')
								{
									$populateCarousalTopChartBlock_arr['row'][$inc]['music_path'] = $music_artist_image['m_url'];
									$populateCarousalTopChartBlock_arr['row'][$inc]['disp_image'] = '';
								}
							else
								{
									$populateCarousalTopChartBlock_arr['row'][$inc]['music_path'] = '';
									$populateCarousalTopChartBlock_arr['row'][$inc]['disp_image'] = '';
								}
						}
						else if($opt == 'normal')
							{
								if($pay_details = checkMusicForSale($top_chart_block['music_id']))
					    		{
					    			$populateCarousalTopChartBlock_arr['row'][$inc]['for_sale']= false;
					    			$populateCarousalTopChartBlock_arr['row'][$inc]['album_for_sale']= false;
									$populateCarousalTopChartBlock_arr['row'][$inc]['sale'] = true;
									if($pay_details['for_sale']=='Yes' AND $pay_details['music_price']>0)
									{
										$populateCarousalTopChartBlock_arr['row'][$inc]['for_sale'] = true;
										$music_price = strstr($pay_details['music_price'], '.');
		                                if(!$music_price)
		                                {
		                                  $pay_details['music_price']=$pay_details['music_price'].'.00';
									    }
										$populateCarousalTopChartBlock_arr['row'][$inc]['music_price'] = $this->CFG['currency'].$pay_details['music_price'];
									}
								}
								$populateCarousalTopChartBlock_arr['row'][$inc]['title_url'] = getUrl('viewmusic', '?music_id='.$top_chart_block['music_id'].'&title='.$this->changeTitle($top_chart_block['music_title']), $top_chart_block['music_id'].'/'.$this->changeTitle($top_chart_block['music_title']).'/', '', 'music');
								$populateCarousalTopChartBlock_arr['row'][$inc]['musiccategory_url'] = getUrl('musiclist', '?pg=musicnew&cid='.$top_chart_block['music_category_id'], 'musicnew/?cid='.$top_chart_block['music_category_id'], '', 'music');
								$populateCarousalTopChartBlock_arr['row'][$inc]['viewalbum_url'] = getUrl('viewalbum', '?album_id='.$top_chart_block['music_album_id'].'&title='.$this->changeTitle($top_chart_block['album_title']),$top_chart_block['music_album_id'].'/'.$this->changeTitle($top_chart_block['album_title']).'/', '', 'music');
								// IMAGE //
								if($top_chart_block['music_thumb_ext'])
									{
										$populateCarousalTopChartBlock_arr['row'][$inc]['music_image_src'] = $top_chart_block['music_server_url'].$musics_folder.getMusicImageName($top_chart_block['music_id'], $top_chart_block['file_name']).$this->CFG['admin']['musics']['medium_name'].'.'.$top_chart_block['music_thumb_ext'];
										$populateCarousalTopChartBlock_arr['row'][$inc]['music_disp'] = DISP_IMAGE($this->CFG['admin']['musics']['medium_width'], $this->CFG['admin']['musics']['medium_width'], $top_chart_block['medium_width'], $top_chart_block['medium_height']);
									}
								else
									{
										$populateCarousalTopChartBlock_arr['row'][$inc]['music_image_src'] = '';
										$populateCarousalTopChartBlock_arr['row'][$inc]['music_disp'] = '';
									}
							}
						if($count%$this->CFG['admin']['musics']['sidebar_audiotabs_num_record_per_row'] == 0)
							{
								$this->no_of_row_topchart++;
							}
						$inc++;
		    			$count++;
					}
				$this->no_of_row_topchart--;
				if(!isAjaxPage())
					{
					?>
					<?php
						}
				$smartyObj->assign('populateCarousalTopChartBlock_arr', $populateCarousalTopChartBlock_arr);
				$smartyObj->assign('case', $case);
		    	$smartyObj->assign('start', $start);
				setTemplateFolder('general/', 'music');
				$smartyObj->display('indexTopChartSalesContent.tpl');
			}

		/**
		 * MusicIndexPageHandler::populateCarousalTopChartBlockMusicId()
		 *  To generate music_ids for hidden player
		 *
		 * @param string $case
		 * @param booelan $all
		 * @return array
		 */
		public function populateCarousalTopChartBlockMusicId($case, $all = false)
			{
				$populateCarousalTopChartBlock_arr = array();
				$populateCarousalTopChartBlock_arr['row'] = array();
				$sql = '';
				$start = 0;
				$opt = '';
				switch($case)
					{
						case 'topChartSongs':
							$default_fields = 'm.music_id, m.music_album_id, m.music_title, ma.album_title, '.
												'm.total_plays as total_count, m.music_server_url, m.music_thumb_ext,'.
												' mc.music_category_id, mc.music_category_name, mfs.file_name, '.
												' m.medium_width, m.medium_height ';

							$from = 'FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['music_files_settings'].
									' AS mfs ON mfs.music_file_id = m.thumb_name_id, '.$this->CFG['db']['tbl']['music_category'].' AS mc, '.
									$this->CFG['db']['tbl']['music_album'].' AS ma, '.$this->CFG['db']['tbl']['users'].' AS u ';
							$condition = 'WHERE u.user_id = m.user_id
												AND m.music_category_id = mc.music_category_id
												AND m.music_album_id = ma.music_album_id
												AND u.usr_status = \'Ok\'
												AND m.music_status = \'Ok\'
												AND m.total_plays > 0
												AND mc.music_category_status = \'Yes\' '.$this->getAdultQuery('m.', 'music').'
												AND (m.user_id = '.$this->CFG['user']['user_id'].' OR '.
								 				'm.music_access_type = \'Public\''.$this->getAdditionalQuery().')';
							$order_by = ' ORDER BY total_count DESC';
							$sql = 'SELECT '.$default_fields.$from.$condition.$order_by;
							$opt = 'normal';
						break;

						case 'topChartDownloads':
							$default_fields = 'm.music_id, m.music_album_id, m.music_title, ma.album_title, '.
												'm.total_downloads as total_count, mc.music_category_id, '.
												'mc.music_category_name, m.music_server_url, m.music_thumb_ext, '.
												'mfs.file_name, m.medium_width, m.medium_height ';

							$from = 'FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['music_files_settings'].
									' AS mfs ON mfs.music_file_id = m.thumb_name_id, '.$this->CFG['db']['tbl']['music_category'].' AS mc, '.
									$this->CFG['db']['tbl']['music_album'].' AS ma, '.$this->CFG['db']['tbl']['users'].' AS u ';
							$condition = 'WHERE u.user_id = m.user_id
												AND m.music_category_id = mc.music_category_id
												AND m.music_album_id = ma.music_album_id
												AND u.usr_status = \'Ok\'
												AND m.music_status = \'Ok\'
												AND mc.music_category_status = \'Yes\''.$this->getAdultQuery('m.', 'music').'
												AND (m.user_id = '.$this->CFG['user']['user_id'].' OR'.
								 				' m.music_access_type = \'Public\''.$this->getAdditionalQuery().') GROUP BY music_id HAVING total_count > 0 ';

							$order_by = ' ORDER BY total_count DESC';
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
					trigger_db_error($this->dbObj);

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
					trigger_db_error($this->dbObj);

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
		 * $musicIndex::myHomeActivity()
		 *
		 * @return void
		 */
		public function myHomeActivity()
			{
				global $smartyObj;
				setTemplateFolder('members/');
				$smartyObj->display('myHomeActivity.tpl');
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
					'div_id'               => 'index_flash_player',
					'music_player_id'      => 'index_hidden_player',
					'width'  		       => 1,
					'height'               => 1,
					'auto_play'            => 'false',
					'hidden'               => true,
					'playlist_auto_play'   => false,
					'javascript_enabled'   => true,
					'player_ready_enabled' => true,
					'informCSSWhenPlayerReady' => false
				);
				$this->populatePlayerWithPlaylist($music_array);

				echo '<input type="hidden" name="hidden_player_status" id="hidden_player_status" value="no"/>
					  <script language="javascript" type="text/javascript" >
						var total_musics_to_play = '.count($this->player_music_id).';
						var play_functionalities_arr = new Array(\'music_tracker\', \'top_chart\', \'top_downloads\');';

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
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if($row['total'] < $this->CFG['admin']['musics']['index_page_music_list_total_thumbnail'])
					return false;
				else
					return true;
			}

		/**
		 * MusicIndexPageHandler::populateFeaturedMusiclist()
		 *
		 * @return void
		 * @access public
		 */
		public function populateFeaturedMusiclist()
			{
				$add_order = ' ORDER BY m.music_id DESC ';
				$sql_condition = ' u.usr_status=\'Ok\' AND m.music_status=\'Ok\' AND m.music_featured=\'Yes\''.
								 ' AND (m.user_id = '.$this->CFG['user']['user_id'].
								 ' OR m.music_access_type = \'Public\''.$this->getAdditionalQuery().')'.$this->getAdultQuery('m.', 'music');

				$sql = 'SELECT count(music_id) as total FROM '.$this->CFG['db']['tbl']['music'].
						' AS m JOIN '.$this->CFG['db']['tbl']['users'].' AS u  '.
						'ON m.user_id = u.user_id  WHERE '.$sql_condition.$add_order;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();

				if($row['total'] < 1)
					return false;
				else
					return true;
			}
		/**
		 * MusicIndexPageHandler::populateFeaturedContent()
		 *
		 * @return void
		 * @access public
		 */
		public function populateFeaturedContent()
			{
				global $smartyObj;
				$inc	= 0;
				$featuredContentArr	= array();
				$sql = 'SELECT music_featured_content_id, title, description, start_date, end_date, is_active,image_ext,date_added FROM '.$this->CFG['db']['tbl']['music_featured_content'].' WHERE'.
						' is_active=\'yes\' AND end_date>=NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				while($row = $rs->FetchRow())
				    {
						$featuredContentArr[$inc]['title']		= ucfirst($row['title']);
						$replacedContent	= $this->replaceContent2Links(htmlentitydecode(stripslashes($row['description'])));
						//$this->replaceContent2Links(htmlspecialchars_decode($row['description']));
						$featuredContentArr[$inc]['start_date']	= $row['start_date'];
						$featuredContentArr[$inc]['end_date']	= $row['end_date'];
						$featuredContentArr[$inc]['date_added']	= $row['date_added'];
						$featuredContentArr[$inc]['music_featured_content_id']	= $row['music_featured_content_id'];
						if($row['image_ext']!='')
								$imagePath	= $this->CFG['site']['url'].'files/featured_content_images/'.$row['music_featured_content_id'].'T.'.$row['image_ext'];
						else
								$imagePath	= '';
						$featuredContentArr[$inc]['description']= $replacedContent;
						$featuredContentArr[$inc]['image_path']	= $imagePath;
						$featuredContentArr[$inc]['musicFeaturedCcontentViewUrl']	= getUrl('index', '?act=vfcontent&music_featured_cid='.$row['music_featured_content_id'],'?act=vfcontent&music_featured_cid='.$row['music_featured_content_id'], '', 'music');
						$inc++;

				    }
				$smartyObj->assign('featuredContentTotal', $inc);
				return $featuredContentArr;
			}//END populateFeaturedContent()

		/**
		 * MusicIndexPageHandler::replaceContent2Links()
		 *
		 * @return void
		 * @access public
		 */
		public function replaceContent2Links($contentDescription)
			{
				$str = $contentDescription;

				//replace music info with music url
				$do = preg_match("/&lt;vol:mid&gt;(.*)&lt;\/vol:mid&gt;/", $str, $matches);
				if ($do = true)
					{
						//echo '<pre>';
						//print_r($matches);
						//echo '</pre>';
						//echo htmlentities($matches['0']); // Matched something, show the matched string
						//echo '<br />' . $matches['1']; // Also how the text in between the tags
						if(is_array($matches) && !empty($matches) and count($matches)>1)
							{
								$musicInfo	= explode(':',$matches[1]);
								$musicUrl	= '<a href="'.$this->CFG['site']['url'].'music/listenMusic.php?music_id='.$musicInfo[0].'">'.$musicInfo[1].'</a>';
								$str	= preg_replace("/&lt;vol:mid&gt;(.*)&lt;\/vol:mid&gt;/",$musicUrl, $str);
							}
					}

				//replace artist info with artist url
				$do = preg_match("/&lt;vol:arid&gt;(.*)&lt;\/vol:arid&gt;/", $str, $matches);
				if ($do = true)
					{
						if(is_array($matches) && !empty($matches) and count($matches)>1)
							{
								$artistInfo	= explode(':',$matches[1]);
								$artistUrl	= '<a href="'.$this->CFG['site']['url'].'music/viewArtist.php?artist_id='.$artistInfo[0].'">'.$artistInfo[1].'</a>';
								$str		= preg_replace("/&lt;vol:arid&gt;(.*)&lt;\/vol:arid&gt;/",$artistUrl, $str);
							}
					}

				//replace album info with album url
				$do = preg_match("/&lt;vol:alid&gt;(.*)&lt;\/vol:alid&gt;/", $str, $matches);
				if ($do = true)
					{
						if(is_array($matches) && !empty($matches) and count($matches)>1)
							{
								$albumInfo	= explode(':',$matches[1]);
								$albumUrl	= '<a href="'.$this->CFG['site']['url'].'music/viewArtist.php?artist_id='.$albumInfo[0].'">'.$albumInfo[1].'</a>';
								$str		= preg_replace("/&lt;vol:alid&gt;(.*)&lt;\/vol:alid&gt;/",$albumUrl, $str);
							}
					}

				//replace user info with user url
				$do = preg_match("/&lt;vol:uid&gt;(.*)&lt;\/vol:uid&gt;/", $str, $matches);
				if ($do = true)
					{
						if(is_array($matches) && !empty($matches) and count($matches)>1)
							{
								$userInfo	= explode(':',$matches[1]);
								$userUrl	= '<a href="'.$this->CFG['site']['url'].'viewProfile.php?user='.$userInfo[0].'">'.$userInfo[1].'</a>';
								$str		= preg_replace("/&lt;vol:uid&gt;(.*)&lt;\/vol:uid&gt;/",$userUrl, $str);
							}
					}
				return $str;

			}//END replaceContent2Links()

		/**
		 * MusicIndexPageHandler::populateSingleFeaturedContent()
		 *
		 * @return
		 **/
		public function populateSingleFeaturedContent($musicFeaturedContentId)
			{
				global $smartyObj;
				$smartyObj->assign('imagePath','');
				$sql = 'SELECT music_featured_content_id, title, description, image_ext FROM '.$this->CFG['db']['tbl']['music_featured_content'].' WHERE'.
						' music_featured_content_id='.$this->dbObj->Param('music_featured_content_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($musicFeaturedContentId));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if ($row = $rs->FetchRow())
			    {
					if($row['image_ext']!='')
						$imagePath	= $this->CFG['site']['url'].'files/featured_content_images/'.$musicFeaturedContentId.'T.'.$row['image_ext'];
					else
						$imagePath	= '';

					$replacedContent	= $this->replaceContent2Links(htmlentitydecode(stripslashes($row['description'])));

					$smartyObj->assign('imagePath',$imagePath);
					$smartyObj->assign('featuredContentTitle',ucfirst($row['title']));
					$smartyObj->assign('featuredContentDescription',$replacedContent);
					return true;
			    }
				return false;
			}
		/**
		 * MusicIndexPageHandler::featuredContentCommon()
		 *
		 * @return
		 **/

		public function featuredContentCommon()
			{
				global $smartyObj;
				$smartyObj->assign('featured_content_module_enabled',true);
				if(isset($_REQUEST['act']) && $_REQUEST['act']=='vfcontent')
					{
						if($this->populateSingleFeaturedContent($_REQUEST['music_featured_cid']))
							{
								$this->includeHeader();
								setTemplateFolder('general/','music');
								$smartyObj->display('indexFeaturedContentFullView.tpl');
								exit;

							}
					}
				//START TO PREPARE FEATURED CONTENT GLIDER INFORMATION
				$musicFeaturedContent	= $this->populateFeaturedContent();
				$smartyObj->assign('musicFeaturedContent',$musicFeaturedContent);
				//END TO PREPARE FEATURED CONTENT GLIDER INFORMATION

				$this->setPageBlockShow('block_feartured_content_glider');

			}//END featuredContentCommon()



		/**
		 * MusicIndexPageHandler::getTotalPlaylistPages()
		 * Function to get the total no of pages for the playlist carousel
		 *
		 * @param string $block_name
		 * @param int $limit no of records to be shown per page in the carousel,
		 * 				value can be varied / passed from tpl
		 * @return int total pages
		 */
		public function getTotalPlaylistPages($block_name, $limit)
		{
			$global_limit = 100; //to avoid overloading

			switch($block_name)
			{
				case 'playlistmostviewed':
					$table_names = $this->CFG['db']['tbl']['music_playlist_viewed'] . ' as vpl LEFT JOIN ' . $this->CFG['db']['tbl']['music_playlist'] . ' as pl ON pl.playlist_id=vpl.playlist_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u ';
					$condition = 'pl.playlist_status=\'Yes\' AND pl.total_views>0 AND pl.user_id = u.user_id AND u.usr_status=\'Ok\'';
				break;
			}

			$sql = 'SELECT COUNT(DISTINCT (vpl.playlist_id)) AS total_music FROM '.$table_names.
					'WHERE '.$condition . ' LIMIT ' . $global_limit;

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
				trigger_db_error($this->dbObj);

			if($row = $rs->FetchRow())
		    {
				$record_count = $row['total_music'];
				$total_pages = ceil($record_count/$limit);
				return $total_pages;
		    }
		    else
		    {
				return 0;
			}
		}



		/**
		 * MusicIndexPageHandler::populateCarousalPlaylistBlock()
		 * sets the values in $showPlaylists_arr to be displayed from
		 * tpl.
		 *
		 *
		 * @param string $case
		 * @param int $page_no - page no starts with 1 passed in query string
		 * @param int $rec_per_page - rec per page in carousel passed in query string
		 * @return void
		 */
		public function populateCarousalPlaylistBlock($case, $page_no=1, $rec_per_page=4)
			{

				global $smartyObj;
				$start = ($page_no -1) * $rec_per_page; // start = (pageno -1) * rec per page

				switch($case)
				{
					case 'playlistmostviewed':
						$table_names = $this->CFG['db']['tbl']['music_playlist_viewed'] . ' as vpl LEFT JOIN ' . $this->CFG['db']['tbl']['music_playlist'] . ' as pl ON pl.playlist_id=vpl.playlist_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u ';
						$default_fields = "pl.playlist_id, pl.playlist_name, TIMEDIFF(NOW(), pl.date_added) AS date_added, pl.thumb_music_id as music_id, pl.thumb_ext as music_ext, pl.total_tracks, pl.total_views, pl.total_comments, (pl.rating_total/pl.rating_count) as rating, pl.rating_count, pl.total_favorites, pl.total_featured, pl.playlist_tags, pl.playlist_description, u.user_name, u.user_id, SUM(vpl.total_views) as sum_total_views, pl.allow_ratings";
						$condition = 'pl.playlist_status=\'Yes\' AND pl.total_views>0 AND pl.user_id = u.user_id AND u.usr_status=\'Ok\' GROUP BY vpl.playlist_id ';
						$order_by = 'sum_total_views DESC';
					break;
				}

				$sql = ' SELECT '.$default_fields.' FROM '.$table_names.
						' WHERE '.$condition.' ORDER BY '.$order_by;

				$sql .= ' LIMIT '.$start.', '.$rec_per_page;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);

			    if (!$rs)
					trigger_db_error($this->dbObj);

				$showPlaylists_arr = array();
				$playlist_thumbnail_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['musics']['folder'] . '/' . $this->CFG['admin']['musics']['thumbnail_folder'] . '/';
				$inc=0;
				$showPlaylists_arr['row'] = array();
				$this->player_music_id = array();
				while($row = $rs->FetchRow())
					{
						$row['date_added'] = ($row['date_added'] != '') ? getTimeDiffernceFormat($row['date_added']) : '';
						$showPlaylists_arr['row'][$inc]['record'] = $row;
						$showPlaylists_arr['row'][$inc]['view_playlisturl'] = getUrl('viewplaylist', '?playlist_id='.$row['playlist_id'].'&amp;title='.$this->changeTitle($row['playlist_name']), $row['playlist_id'].'/'.$this->changeTitle($row['playlist_name']).'/', '','music');
						$showPlaylists_arr['row'][$inc]['getPlaylistImageDetail'] = $this->getPlaylistImageDetail($row['playlist_id']);// This function return playlist image detail array..//
						$inc++;
					}
				$smartyObj->assign('showPlaylists_arr', $showPlaylists_arr);
		    	$smartyObj->assign('playlist_block_record_count', $inc);//is record found
				setTemplateFolder('general/', 'music');
				$smartyObj->display('indexPopularPlaylistContent.tpl');
			}


		/**
		 * MusicIndexPageHandler::getTotalAlbumsPages()
		 * Function to get the total no of pages for the albums carousel
		 *
		 * @param string $block_name
		 * @param int $limit no of records to be shown per page in the carousel,
		 * 				value can be varied / passed from tpl
		 * @return int total pages
		 */
		public function getTotalAlbumsPages($block_name, $limit)
		{
			$global_limit = 100; //to avoid overloading

			switch($block_name)
			{
				case 'featured':
					$table_names = $this->CFG['db']['tbl']['music_album'].' AS al LEFT JOIN '.$this->CFG['db']['tbl']['music'].' AS m ON al.music_album_id = m.music_album_id , '.$this->CFG['db']['tbl']['users'].' AS u ';
					$condition = 'm.user_id = u.user_id AND m.music_status = \'OK\' AND u.usr_status=\'Ok\' AND al.album_featured = \'Yes\'';
				break;
			}

			$sql = 'SELECT COUNT(DISTINCT (al.music_album_id) ) AS total_music FROM '.$table_names.
					'WHERE '.$condition . ' LIMIT ' . $global_limit;
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
				trigger_db_error($this->dbObj);

			if($row = $rs->FetchRow())
		    {
				$record_count = $row['total_music'];
				$total_pages = ceil($record_count/$limit);
				return $total_pages;
		    }
		    else
		    {
				return 0;
			}
		}



		/**
		 * MusicIndexPageHandler::populateCarousalAlbumsBlock()
		 * sets the values in $showAlbums_arr to be displayed from
		 * tpl.
		 *
		 *
		 * @param string $case
		 * @param int $page_no - page no starts with 1 passed in query string
		 * @param int $rec_per_page - rec per page in carousel passed in query string
		 * @return void
		 */
		public function populateCarousalAlbumsBlock($case, $page_no=1, $rec_per_page=4)
			{

				global $smartyObj;
				$start = ($page_no -1) * $rec_per_page; // start = (pageno -1) * rec per page

				switch($case)
				{
					case 'featured':
						$table_names = $this->CFG['db']['tbl']['music_album'].' AS al LEFT JOIN '.$this->CFG['db']['tbl']['music'].' AS m ON al.music_album_id = m.music_album_id , '.$this->CFG['db']['tbl']['users'].' AS u ';
						$default_fields = "al.music_album_id, al.album_title, al.date_added, al.thumb_music_id as music_id, count(m.music_id) as total_tracks, al.total_album_views as total_views, sum(m.total_plays) as total_plays,m.music_title,m.music_id,m.music_server_url,count( m.music_id ) AS total_songs,m.music_title, m.thumb_width,m.thumb_height,al.album_for_sale,al.user_id,al.album_price";
						$condition = 'm.user_id = u.user_id AND m.music_status = \'OK\' AND u.usr_status=\'Ok\' AND al.album_featured =\'Yes\' GROUP BY al.music_album_id ';
						$order_by = 'al.music_album_id DESC';
					break;
				}

				$sql = ' SELECT '.$default_fields.' FROM '.$table_names.
						' WHERE '.$condition.' ORDER BY '.$order_by;
				$sql .= ' LIMIT '.$start.', '.$rec_per_page;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);

			    if (!$rs)
					trigger_db_error($this->dbObj);

				$showAlbumlists_arr = array();
				$musics_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
				$inc=0;
				$showAlbumlists_arr['row'] = array();
				while($row = $rs->FetchRow())
				{
					$showAlbumlists_arr['row'][$inc]['record'] = $row;
					$showAlbumlists_arr['row'][$inc]['viewAlbum_url'] =getUrl('viewalbum', '?album_id='.$row['music_album_id'].'&title='.$this->changeTitle($row['album_title']),$row['music_album_id'].'/'.$this->changeTitle($row['album_title']).'/', '', 'music');
					$showAlbumlists_arr['row'][$inc]['getAlbumImageDetail'] = $this->getAlbumImageDetail($row['music_album_id']);
					$inc++;
				}
				$smartyObj->assign('showAlbumlists_arr', $showAlbumlists_arr);
		    	$smartyObj->assign('albums_block_record_count', $inc);//is record found
				setTemplateFolder('general/', 'music');
				$smartyObj->display('indexFeaturedAlbumsContent.tpl');
			}

		/**
		 * MusicIndexPageHandler::getAlbumImageDetail()
		 * @ get 4 image
		 * @param integer $album_id
		 * @param boolean $condition - to add accesstype and additional query, adult query
		 * @return array
		 */
		public function getAlbumImageDetail($album_id, $condition=true)
			{
				$getAlbumImageDetail_arr = array();
				$playlist_thumbnail_folder = $this->CFG['media']['folder'].'/'.
												$this->CFG['admin']['musics']['folder'].'/'.
													$this->CFG['admin']['musics']['thumbnail_folder'].'/';

				$sql = 'SELECT m.music_id, m.music_title, m.music_server_url, m.music_thumb_ext, mfs.file_name, '.
							' m.small_width, m.small_height, m.thumb_width, m.thumb_height FROM '.
							$this->CFG['db']['tbl']['music_album'].' AS ma JOIN '.
							$this->CFG['db']['tbl']['music'].' AS m ON m.music_album_id=ma.music_album_id  JOIN '.
							$this->CFG['db']['tbl']['music_files_settings'].' AS mfs '.
							'ON mfs.music_file_id = m.thumb_name_id, '.$this->CFG['db']['tbl']['users'].
							' AS u WHERE ma.music_album_id ='.$this->dbObj->Param('album_id').' '.
							' AND m.user_id=u.user_id AND u.usr_status = \'Ok\' AND m.music_status = \'Ok\' AND '.
							' m.music_thumb_ext!=" "';

				if($condition)
					$sql .= ' AND (m.user_id = '.$this->CFG['user']['user_id'].
							' OR m.music_access_type = \'Public\''.
							$this->getAdditionalQuery().') '.$this->getAdultQuery('m.', 'music');

				$sql .= ' ORDER BY m.music_id DESC LIMIT 0,4';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($album_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$getAlbumImageDetail_arr['total_record'] = $total = $rs->PO_RecordCount();
				$getAlbumImageDetail_arr['noimageCount'] = 0;
				if($total < 4)
					$getAlbumImageDetail_arr['noimageCount'] = 4-$total;
				$getAlbumImageDetail_arr['row'] = array();
				$inc = 1;
				while($row = $rs->FetchRow())
					{
						$getAlbumImageDetail_arr['row'][$inc]['record'] = $row;
						$getAlbumImageDetail_arr['row'][$inc]['album_thumb_path'] = $row['music_server_url'].$playlist_thumbnail_folder.getMusicImageName($row['music_id']).$this->CFG['admin']['musics']['thumb_name'].'.'.$row['music_thumb_ext'];
						$getAlbumImageDetail_arr['row'][$inc]['album_path'] = $row['music_server_url'].$playlist_thumbnail_folder.getMusicImageName($row['music_id']).$this->CFG['admin']['musics']['small_name'].'.'.$row['music_thumb_ext'];
						$inc++;
					}

				return $getAlbumImageDetail_arr;
			}

	}
$musicIndex = new MusicIndexPageHandler();
if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$musicIndex->setPageBlockNames(array('sidebar_topcontributors_block', 'sidebar_audio_block', 'sidebar_topchart_block',
										'sidebar_activity_block', 'sidebar_currently_playing_block', 'block_featured_playlist',
										'block_feartured_musiclist', 'block_popular_playlist', 'block_featured_albums'
									));

$musicIndex->CFG['admin']['musics']['individual_song_play'] = true;

$musicIndex->setAllPageBlocksHide();
$musicIndex->setMediaPath('../');
$musicIndex->setFormField('start', 0);
$musicIndex->setFormField('block', '');
$musicIndex->setFormField('playlist_block', '');
$musicIndex->setFormField('albums_block', '');
$musicIndex->setFormField('topChart', '');
$musicIndex->setFormField('activity_type', '');
$musicIndex->setFormField('player_mid_key', '');
$musicIndex->setFormField('player_mid', '');
$musicIndex->setFormField('showtab', '');
$musicIndex->setFormField('top_chart_tab', '');
$musicIndex->setFormField('playlist_tab', '');
$musicIndex->setFormField('albums_tab', '');
$musicIndex->setFormField('cloud_tab', '');
$musicIndex->setFormField('limit', 0);
//SHOW BLOCK//
$musicIndex->setPageBlockShow('sidebar_artistclouds_block');
$musicIndex->setPageBlockShow('sidebar_topcontributors_block');// TOP CONTRIBUTORS //
$musicIndex->setPageBlockShow('sidebar_topchart_block');
$musicIndex->setPageBlockShow('block_popular_playlist');
$musicIndex->setPageBlockShow('block_featured_albums');

/* set url for all music, playlist ... */
$musicIndex->view_all_playlist_url = getUrl('musicplaylist', '?pg=playlistnew', 'playlistnew/', '', 'music');
$musicIndex->view_all_music_url = getUrl('musiclist', '?pg=musicnew', 'musicew/', '', 'music');
$musicIndex->view_all_albums_url = getUrl('albumsortlist', '', '', '', 'music');;

if($musicIndex->currentlyPlayingChk())
	$musicIndex->setPageBlockShow('sidebar_currently_playing_block');
//$musicIndex->setPageBlockShow('block_featured_playlist');
$musicIndex->setPageBlockShow('block_feartured_musiclist');
if($CFG['admin']['musics']['recentlylistenedmusic'] or $CFG['admin']['musics']['recommendedmusic']
	or $CFG['admin']['musics']['newmusic'] or $CFG['admin']['musics']['topratedmusic'])
	$musicIndex->setPageBlockShow('sidebar_audio_block');

//For Featured Content Glider
$smartyObj->assign('featured_content_module_enabled',false);
if(isset($CFG['admin']['musics']['music_featured_content_glider']) && $CFG['admin']['musics']['music_featured_content_glider'])
	$musicIndex->featuredContentCommon();
//End Featured Content Glider

//START TO GENERATE THE FEATURE PLAYER ARRAY FIELDS
$auto_play =  'false';
if($CFG['admin']['musics']['playlist_player']['FutureListPlayerAutoPlay'])
	$auto_play =  'true';

$playlist_auto_play =  false;
if($CFG['admin']['musics']['playlist_player']['FuturePlayListPlayerAutoPlay'])
	$playlist_auto_play =  true;

$music_fields = array(
	'div_id'               => 'featured_playlist',
	'music_player_id'      => 'index_featured_playlist',
	'width'  		       => '598',
	'height'               => '174',
	'auto_play'            => $auto_play,
	'hidden'               => false,
	'playlist_auto_play'   => $playlist_auto_play,
	'javascript_enabled'   => false,
	'informCSSWhenPlayerReady' => true
);

$smartyObj->assign('music_fields',$music_fields);
//END TO GENERATE THE FEATURE PLAYER ARRAY FIELDS

if(!isAjaxPage())
	{
		$_SESSION['index_player_music_id'] = array();
		$musicIndex->setPageBlockShow('sidebar_activity_block');
		if ($musicIndex->isShowPageBlock('sidebar_audio_block'))// MEMBER BLOCK //
			{
				$musicIndex->loadSetting();
			}
		if ($musicIndex->isShowPageBlock('sidebar_topchart_block'))// TOP CHART //
			{
				$musicIndex->populateAudioTracker(true);
				if($CFG['admin']['musics']['music_top_chart_content']=='sales' AND $CFG['admin']['musics']['allowed_usertypes_to_upload_for_sale'] != 'None' )
				{
					//TO GENERATE MUSIC IDs FOR HIDDEN PLAYER
					$musicIndex->populateCarousalTopChartSalesBlockMusicId('topChartSongs', true);

					// DISPLAY ORDER FROM CONFIG VARIABLE //
					$musicIndex->sidebar_topchart_block['display_order'] = array();
					$inc = 1;
					$musicIndex->top_chart_default_div = array();
					$musicIndex->sidebar_topchart_block['count'] = count($CFG['admin']['musics']['sidebar_topchart_option']);
					foreach($CFG['admin']['musics']['sidebar_topchart_sales_option'] as $display_order)
						{
							$musicIndex->sidebar_topchart_block['display_order'][$inc]['divID'] = 'topChart'.ucwords($display_order);
							$musicIndex->sidebar_topchart_block['display_order'][$inc]['lang'] = $LANG['sidebar_topchart_'.$display_order.'_label'];
							$musicIndex->sidebar_topchart_block['display_order'][$inc]['view_all'] = getUrl('musictopchartsales','?pg=topChart'.ucwords($display_order), '?pg=topChart'.ucwords($display_order),'','music');
							$musicIndex->sidebar_topchart_block['display_order'][$inc]['view_all_lang'] = $LANG['sidebar_viewall_label'];
							$inc++;
						}
					$flag = 1;
					foreach($CFG['admin']['musics']['sidebar_topchart_sales_option'] as $key=>$value)
						{
							if($flag == 1)
								{
									$musicIndex->top_chart_default_div['topChart'.ucwords($value)] = '';
									$musicIndex->default_active_top_chart_block_name = 'topChart'.ucwords($value);
									$flag = 0;
								}
							else
								{
									$musicIndex->top_chart_default_div['topChart'.ucwords($value)] = 'display:none;';
								}
						}
				}
				else
				{
					//TO GENERATE MUSIC IDs FOR HIDDEN PLAYER
					$musicIndex->populateCarousalTopChartBlockMusicId('topChartSongs', true);
					$musicIndex->populateCarousalTopChartBlockMusicId('topChartDownloads', true);

					// DISPLAY ORDER FROM CONFIG VARIABLE //
					$musicIndex->sidebar_topchart_block['display_order'] = array();
					$inc = 1;
					$musicIndex->top_chart_default_div = array();
					$musicIndex->sidebar_topchart_block['count'] = count($CFG['admin']['musics']['sidebar_topchart_option']);
					foreach($CFG['admin']['musics']['sidebar_topchart_option'] as $display_order)
						{
							$musicIndex->sidebar_topchart_block['display_order'][$inc]['divID'] = 'topChart'.ucwords($display_order);
							$musicIndex->sidebar_topchart_block['display_order'][$inc]['lang'] = $LANG['sidebar_topchart_'.$display_order.'_label'];
							$inc++;
						}
					$flag = 1;
					foreach($CFG['admin']['musics']['sidebar_topchart_option'] as $key=>$value)
						{
							if($flag == 1)
								{
									$musicIndex->top_chart_default_div['topChart'.ucwords($value)] = '';
									$musicIndex->default_active_top_chart_block_name = 'topChart'.ucwords($value);
									$flag = 0;
								}
							else
								{
									$musicIndex->top_chart_default_div['topChart'.ucwords($value)] = 'display:none;';
								}
						}
				}
			}
		if ($musicIndex->isShowPageBlock('sidebar_currently_playing_block'))// CURRENTLY PLAYING SONG //
			{
				$musicIndex->sidebar_currently_playing_block['populateCurrentlyPlayingSongsDetail'] = $musicIndex->populateCurrentlyPlayingSongsDetail();
			}
		if ($musicIndex->isShowPageBlock('block_featured_playlist'))
			{
				$musicIndex->populateFeaturedPlaylist();
				if(!empty($musicIndex->featured_playlist_arr))
					{
						$smartyObj->assign('featured_list_title', $LANG['sidebar_featuredplaylist_label']);
						//Initializing Playlist Player Configuaration
						$musicIndex->populatePlayerWithPlaylistConfiguration();
						$musicIndex->configXmlcode_url .= 'pg=music_'.$musicIndex->featured_playlist_arr['playlist_id'];
						$musicIndex->playlistXmlcode_url .= 'pg=music_'.$musicIndex->featured_playlist_arr['playlist_id'];
					}
				else
					$musicIndex->setPageBlockHide('block_featured_playlist');
			}
		if ($musicIndex->isShowPageBlock('block_feartured_musiclist'))
			{
				if($musicIndex->populateFeaturedMusiclist())
					{
						$smartyObj->assign('featured_list_title', $LANG['sidebar_featuredmusiclist_label']);
						//Initializing Playlist Player Configuaration
						$musicIndex->populatePlayerWithPlaylistConfiguration();
						$musicIndex->configXmlcode_url .= 'pg=music';
						$musicIndex->playlistXmlcode_url .= 'pg=musicfeatured';
					}
				else
					$musicIndex->setPageBlockHide('block_feartured_musiclist');
			}
	}
else
	{
		$musicIndex->sanitizeFormInputs($_REQUEST);
		$musicIndex->includeAjaxHeaderSessionCheck();
		if($musicIndex->getFormField('activity_type')!= '')
			{
				if($musicIndex->getFormField('activity_type') == 'Friends' and !$musicIndex->getTotalFriends($CFG['user']['user_id']))
					{
						echo '<div class="clsNoRecordsFound">'.$LANG['index_activities_no_friends'].'</div>';
						exit;
					}
				$activity_view_all_url = getUrl('activity', '?pg='.strtolower($musicIndex->getFormField('activity_type')), strtolower($musicIndex->getFormField('activity_type')).'/updates/', 'members');
				$smartyObj->assign('activity_view_all_url', $activity_view_all_url);
				$Activity = new ActivityHandler();
				$Activity->setActivityType(strtolower($musicIndex->getFormField('activity_type')), 'music');
				$musicIndex->myHomeActivity();
			}
		else
			{
				if($musicIndex->getFormField('block')!= '')
					{
						$musicIndex->populateCarousalMusicBlock($musicIndex->getFormField('block'), $musicIndex->getFormField('start'), $musicIndex->getFormField('limit'));
					}

				if($musicIndex->getFormField('playlist_block')!= '')
					{
						$musicIndex->populateCarousalPlaylistBlock($musicIndex->getFormField('playlist_block'), $musicIndex->getFormField('start'), $musicIndex->getFormField('limit'));
					}

				if($musicIndex->getFormField('albums_block')!= '')
					{
						$musicIndex->populateCarousalAlbumsBlock($musicIndex->getFormField('albums_block'), $musicIndex->getFormField('start'), $musicIndex->getFormField('limit'));
					}

				elseif($musicIndex->getFormField('topChart') != '')
					{
						if($musicIndex->getFormField('topChart') != 'topChartAlbums' and $musicIndex->getFormField('topChart') != 'topChartArtists')
							//echo count($_SESSION['index_player_music_id']).'~###~';
						//Reassigning $musicIndex->player_music_id_key when called from AJAX
						$musicIndex->player_music_id_key = $musicIndex->getFormField('player_mid_key');

						if($CFG['admin']['musics']['music_top_chart_content']=='sales')
							$musicIndex->populateCarousalTopChartSalesBlock($musicIndex->getFormField('topChart'));
						else
							$musicIndex->populateCarousalTopChartBlock($musicIndex->getFormField('topChart'), $musicIndex->getFormField('start'), $musicIndex->getFormField('limit'));
					}

				if($musicIndex->getFormField('showtab')!= '')
				{
					$total_music_list_pages = $musicIndex->getTotalMusicListPages($musicIndex->getFormField('showtab'), $musicIndex->getFormField('limit'));
					$smartyObj->assign('total_music_list_pages', $total_music_list_pages);
					$smartyObj->assign('showtab', $musicIndex->getFormField('showtab'));
					setTemplateFolder('general/', 'music');
					$smartyObj->display('indexAudioCarouselTab.tpl');
					exit;
				}


				if($musicIndex->getFormField('top_chart_tab')!= '')
				{
					$total_top_chart_pages = $musicIndex->getTotalTopChartPages($musicIndex->getFormField('top_chart_tab'), $musicIndex->getFormField('limit'));
					$smartyObj->assign('total_top_chart_pages', $total_top_chart_pages);
					$smartyObj->assign('top_chart_tab', $musicIndex->getFormField('top_chart_tab'));
					setTemplateFolder('general/', 'music');
					$smartyObj->display('indexTopChartCarouselTab.tpl');
					exit;
				}

				if($musicIndex->getFormField('playlist_tab')!= '')
				{
					$total_popular_playlist_pages = $musicIndex->getTotalPlaylistPages($musicIndex->getFormField('playlist_tab'), $musicIndex->getFormField('limit'));
					$smartyObj->assign('total_popular_playlist_pages', $total_popular_playlist_pages);
					$smartyObj->assign('playlist_tab', $musicIndex->getFormField('playlist_tab'));
					setTemplateFolder('general/', 'music');
					$smartyObj->display('indexPopularPlaylistCarouselTab.tpl');
					exit;
				}

				if($musicIndex->getFormField('albums_tab')!= '')
				{
					$total_featured_albums_pages = $musicIndex->getTotalAlbumsPages($musicIndex->getFormField('albums_tab'), $musicIndex->getFormField('limit'));
					$smartyObj->assign('total_featured_albums_pages', $total_featured_albums_pages);
					$smartyObj->assign('albums_tab', $musicIndex->getFormField('albums_tab'));
					setTemplateFolder('general/', 'music');
					$smartyObj->display('indexFeaturedAlbumsCarouselTab.tpl');
					exit;
				}

				if($musicIndex->getFormField('cloud_tab')!= '')
					{
						if($musicIndex->getFormField('cloud_tab') == 'artist')
						{
							$tags_table = "music_artist";
						}
						else
						{
							$tags_table = "music_tags";
						}
						$limit = 20;
						$musicIndex->populateSidebarClouds($musicIndex->getFormField('cloud_tab'), $tags_table,$limit);
					}

			}
		$musicIndex->includeAjaxFooter();
		die();
	}
$musicIndex->includeHeader();
?>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/JSFCommunicator.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
<?php
$musicIndex->recentmusic_flv_player_url = $CFG['site']['url'].'files/flash/music/recentViewsMusic.swf';
$musicIndex->recentmusic_configXmlcode_url = $CFG['site']['url'].'music/musicRecentViewedXmlCode.php?';
	if(!isAjaxPage())
		{
?>
           	<style type="text/css">
				/* for carousel */
				.clsMusicListCount ul{
				  margin: 0;
				  padding:0;
				  width: 100000px;
				  position: relative;
				  top: 0;
				  left: 0;
				  height: 150px;
				}

				.clsMusicListCount li {
				  text-align: left;
				  float:left;
				  width:455px;
				}
				.clsCarouselList td{
					text-align:left;
					vertical-align:top;
					padding:0 11px 6px 0;
				}
				*html .clsCarouselList td{
					padding:0 9px 0 0;
				}
				.clsCarouselList td.clsFinalData{
					padding:0 0 7px 0;
				}
				.clsMusicListCount .clsNoContents ul{
				  height: 50px;
				}
			</style>
<?php
     }
setTemplateFolder('general/','music');
$smartyObj->display('index.tpl');
?>
<script language="javascript" type="text/javascript" >
//This is important for carosel//
var module_name_js = "music";
var music_activity_array = new Array('My', 'Friends', 'All');
var music_index_ajax_url = '<?php echo $CFG['site']['music_url'].'index.php';?>';
var topChart_array = new Array();
<?php
	if($CFG['admin']['musics']['music_top_chart_content']=='sales')
	{
		foreach($CFG['admin']['musics']['sidebar_topchart_sales_option'] as $key=>$value)
		{
			echo "topChart_array[$key] = 'topChart".ucwords($value)."'; ";
		}
	}
	else
	{
		foreach($CFG['admin']['musics']['sidebar_topchart_option'] as $key=>$value)
		{
			echo "topChart_array[$key] = 'topChart".ucwords($value)."'; ";
		}
	}
?>
showHideMusicTabs('<?php echo $musicIndex->default_active_top_chart_block_name;?>', 'topChartCarosel');
</script>

<script type="text/javascript">
   function flashToCSS_PlayerReady()
	{
		$Jq('#featured_playlist').addClass('clsfeaturedplaylist');
		$Jq('#indexMusicPlayerLoader').css('display', 'none');
		$Jq('#indexMusicPlayer').css('display', 'block');
	}
</script>
<?php
$musicIndex->includeFooter();
?>