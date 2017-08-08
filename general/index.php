<?php

class IndexPageHandler extends MediaHandler
	{

		public $default_music_block = 'newmusic';
		public $default_video_block = 'newvideo';
		public $default_photo_block = 'mostrecentphoto';

		/**
		 * IndexPageHandler::myHomeActivity()
		 *
		 * @return void
		 */
		public function myHomeActivity($totRecords = 5)
			{
				global $smartyObj;
				setTemplateFolder('members/');
				$smartyObj->assign('activitiesView', $totRecords);
				$smartyObj->display('myHomeActivity.tpl');
				setTemplateFolder('general/');
			}
		/**
		/**
		 * IndexPageHandler::populateFeaturedContent()
		 *
		 * @return
		 */
		public function populateFeaturedContent()
			{
				global $smartyObj;
				$inc	= 0;
				$featuredContentArr	= array();
				$sql = 'SELECT index_glider_id, media_type, media_id, is_use_default, glider_title'.
						', custom_image_ext, custom_image_target_url, rollover_text, sidebar_content'.
						' FROM '.$this->CFG['db']['tbl']['index_root_featured_glider_details'].
						' WHERE status=\'Active\''.
						' ORDER BY featured_order ASC';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				while($row = $rs->FetchRow())
				    {
				    	if ($row['media_type'] != 'custom' AND !chkAllowedModule(array($row['media_type'])))
				    		continue;
				    	$content = array();
						$content['glider_title'] = $row['glider_title'];
						$content['rollover_text'] = $row['rollover_text'];
						$content['selRollover'] = 'selRollover'.$inc;
						$content['selIndexGliderSidebarContent'] = 'selIndexGliderSidebarContent'.$inc;
						$content['target_url'] = $row['custom_image_target_url'];
						$content['media_id'] = $row['media_id'];
						$content['media_type'] = $row['media_type'];
						$content['image_src'] = '';
						if ($row['custom_image_ext'])
							{
								$this->CFG['admin']['glider']['custom_image_folder'] = 'files/index_glider_image/';
								$content['image_src'] = $this->CFG['site']['url'].$this->CFG['admin']['glider']['custom_image_folder'].$row['index_glider_id'].'.'.$row['custom_image_ext'];
								list($content['image_width'], $content['image_height']) = getimagesize($content['image_src']);
							}
						$content['sidebar_content'] = html_entity_decode($row['sidebar_content']);
						$content['clsRollover'] = '';
						if ($row['media_type'] != 'custom')
							{
								$content['clsRollover'] = '';
								switch($row['media_type']){
									case 'video':
										$content_details = $this->getVideoDetails($row['media_id']);
										$content['clsRollover'] = 'clsRolloverVideo';
										break;
									case 'music':
										$content_details = $this->getMusicDetails($row['media_id']);
										$content['clsRollover'] = 'clsRolloverMusic';
										break;
									case 'photo':
										$content_details = $this->getPhotoDetails($row['media_id']);
										$content['clsRollover'] = 'clsRolloverPhoto';
										break;
								} // switch
								if (!$content_details) continue;
								if ($row['is_use_default'] == 'Yes')
									{
										$content_details['description'] = $content_details['description'];
										$content['sidebar_content'] = $content_details;
										$content['rollover_text'] = $content_details['title'];
									}
								$content['target_url'] = $content_details['target_url'];
								$content['image_src'] = $content_details['image_src'];
								$content['image_width'] = $content_details['large_width'];
								$content['image_height'] = $content_details['large_height'];
							}
				    	$featuredContentArr[$inc] = $content;
						$inc++;
				    }
				$smartyObj->assign('featuredContentTotal', $inc);
				return $featuredContentArr;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function getVideoDetails($videoId)
			{
				$video_details = array();
		        $videos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
		        $cssImage_folder = $this->CFG['site']['url'].'video/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/';
				if (!$videoId)
				    {
				        return $video_details;
				    }

				$condition = 'p.video_status=\'Ok\' AND p.video_id='.$this->dbObj->Param($videoId).
							' AND p.video_access_type = \'Public\' AND usr_status=\'Ok\'';

				$sql = 'SELECT p.total_favorites, p.total_views, p.total_comments, p.video_album_id, p.total_downloads, p.video_ext, p.allow_comments'.
						', p.video_category_id, p.video_tags, p.allow_embed, p.video_sub_category_id, TIME_FORMAT(p.playing_time,\'%H:%i:%s\') as playing_time'.
						', p.total_views, p.allow_ratings, p.rating_total, p.rating_count, p.user_id, p.flagged_status, p.video_caption, p.video_title'.
						', p.video_available_formats, DATE_FORMAT(p.date_added,\''.$this->CFG['format']['date'].'\') as date_added, p.video_server_url'.
						', p.l_width, p.l_height, video_flv_url, flv_upload_type, external_site_video_url, p.is_external_embed_video, p.video_external_embed_code'.
						', form_upload_type, t_width, t_height, s_width, s_height, p.allow_response, p.embed_video_image_ext, file_name'.
						', (p.rating_total/p.rating_count) as rating, p.video_page_title, p.video_meta_keyword, p.video_meta_description'.
						' FROM '.$this->CFG['db']['tbl']['video'].' AS p JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'.
						', '.$this->CFG['db']['tbl']['users'].' AS u'.
						' WHERE '.$condition.' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($videoId));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->UserDetails = $this->getUserDetail('user_id', $row['user_id']);

						$this->fields_arr['video_ext'] = $row['video_ext'];
						$this->fields_arr['video_server_url'] = $row['video_server_url'];
						$this->fields_arr['video_flv_url'] = $row['video_flv_url'];

						$this->fields_arr['is_external_embed_video'] = $row['is_external_embed_video'];
						$this->fields_arr['video_external_embed_code'] = stripslashes($row['video_external_embed_code']);
						$this->fields_arr['video_external_embed_code']= str_replace('<embed','<embed wmode="transparent"',$this->getFormField('video_external_embed_code'));
						$this->fields_arr['video_external_embed_code']= str_replace('&lt;embed','&lt;embed wmode=&quot;transparent&quot;',$this->getFormField('video_external_embed_code'));

						$this->fields_arr['external_site_video_url'] = $row['external_site_video_url'];

                		$this->video_path = $row['video_server_url'].$videos_folder.getVideoImageName($videoId, $row['file_name']).
											$this->CFG['admin']['videos']['large_name'].'.'.$this->CFG['video']['image']['extensions'];

                		if (($row['is_external_embed_video'] == 'Yes' && $row['embed_video_image_ext'] == ''))
						{
							$this->video_path = $this->CFG['site']['video_url'].'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.
												$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_video_index.jpg';
            			}
						$video_seo_title = $this->changeTitle($row['video_title']);
						$video_details['title'] = $row['video_title'];
						$video_details['description'] = wordWrap_mb_Manual($row['video_caption'], $this->CFG['admin']['photos']['viewphoto_caption_list_length'], 75);
						$video_details['target_url'] = getUrl('viewvideo','?video_id='.$videoId.'&title='.$video_seo_title, $videoId.'/'.$video_seo_title.'/', '', 'video');
						$video_details['user_name'] = $this->UserDetails['user_name'];
						$video_details['user_url'] = getMemberProfileUrl($row['user_id'], $this->UserDetails['user_name']);
						$video_details['duration'] = $row['playing_time'];
						$video_details['image_src'] = $this->video_path;
						$video_details['large_width'] = $row['l_width'];
						$video_details['large_height'] = $row['l_height'];
						$video_details['total_views'] = $row['total_views'];
						$video_details['total_comments'] = $row['total_comments'];
						$video_details['total_ratings'] = round($row['rating']);
						$video_details['view_content_text'] = $this->LANG['common_view_video_text'];
						$video_details['ratings_text'] = ($video_details['total_ratings'] == 1)?$this->LANG['common_rating']:$this->LANG['common_ratings'];

						return $video_details;
					}
				return $video_details;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function getMusicDetails($musicId)
			{
				$music_details = array();
				$musics_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
				if (!$musicId)
				    {
				        return $music_details;
				    }

				$condition = 'm.music_status=\'Ok\' AND m.music_id='.$this->dbObj->Param($musicId).
							' AND m.music_access_type = \'Public\' AND usr_status=\'Ok\'';

				$sql = 'SELECT m.music_title, m.music_caption, music_artist, m.total_favorites, m.total_views, m.total_plays, m.total_comments, m.total_downloads'.
						', m.allow_comments, m.allow_embed, m.allow_ratings, m.allow_lyrics, m.music_ext, m.music_album_id, m.playing_time, m.music_category_id'.
						', m.music_tags, m.rating_total, m.rating_count, m.user_id, m.flagged_status, m.music_available_formats,m.music_price, m.for_sale'.
						', m.music_server_url, m.music_upload_type,m.music_url, DATE_FORMAT(m.date_added,\''.$this->CFG['format']['date'].'\') as date_added,'.
						' m.large_width, m.large_height, m.thumb_width, m.thumb_height, m.small_width, m.small_height, (m.rating_total/m.rating_count) as rating,'.
						' m.music_category_id, music_sub_category_id, file_name, m.music_thumb_ext'.
						' FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs ON mfs.music_file_id = m.thumb_name_id'.
						', '.$this->CFG['db']['tbl']['users'].' AS u'.
						' WHERE '.$condition.' LIMIT 0, 1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($musicId));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->UserDetails = $this->getUserDetail('user_id',$row['user_id']);
						$this->music_path = '';
						if($row['music_thumb_ext'])
						{
							$this->music_path = $row['music_server_url'].$musics_folder.getMusicImageName($musicId, $row['file_name']).$this->CFG['admin']['musics']['large_name'].'.'.$row['music_thumb_ext'];
						}
						else
						{
							$this->music_path = $this->CFG['site']['url'] . '/music/design/templates/'.
												$this->CFG['html']['template']['default'] . '/root/images/' .
												$this->CFG['html']['stylesheet']['screen']['default'] . '/no_image/noImage_audio_index.jpg';
						}

						$music_seo_title = $this->changeTitle($row['music_title']);
						$music_details['title'] = $row['music_title'];
						$music_details['description'] = wordWrap_mb_Manual(nl2br($row['music_caption']), $this->CFG['admin']['photos']['viewphoto_caption_list_length'], 75);
						$music_details['target_url'] = getUrl('viewmusic','?music_id='.$musicId.'&title='.$music_seo_title, $musicId.'/'.$music_seo_title.'/', '', 'music');
						$music_details['user_name'] = $this->UserDetails['user_name'];
						$music_details['user_url'] = getMemberProfileUrl($row['user_id'], $this->UserDetails['user_name']);
						$music_details['duration'] = $this->fmtMusicPlayingTime($row['playing_time']);
						$music_details['image_src'] = $this->music_path;
						$music_details['large_width'] = $row['large_width'];
						$music_details['large_height'] = $row['large_height'];
						$music_details['total_views'] = $row['total_views'];
						$music_details['total_comments'] = $row['total_comments'];
						$music_details['total_ratings'] = round($row['rating']);
						$music_details['view_content_text'] = $this->LANG['common_view_music_text'];
						$music_details['ratings_text'] = ($music_details['total_ratings'] == 1)?$this->LANG['common_rating']:$this->LANG['common_ratings'];

						return $music_details;
					}
				return $music_details;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function getPhotoDetails($photoId)
			{
				$photo_details = array();
				$photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
				$original_photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['original_photo_folder'].'/';

				if (!$photoId)
				    {
				        return $photo_details;
				    }

				$condition = 'p.photo_status=\'Ok\' AND p.photo_id='.$this->dbObj->Param($photoId).
								' AND p.photo_access_type = \'Public\' AND usr_status=\'Ok\'';
				$sql = 'SELECT p.photo_title, p.photo_caption, p.total_favorites, p.total_views, p.total_comments, p.allow_comments, p.allow_embed'.
						', p.allow_ratings, p.allow_tags, p.photo_ext, p.photo_album_id, p.photo_category_id, p.photo_tags, p.rating_total, p.rating_count'.
						', p.user_id, p.flagged_status, p.photo_server_url, p.photo_upload_type, p.total_downloads, p.location_recorded'.
						', DATE_FORMAT(p.date_added,\''.$this->CFG['format']['date'].'\') as date_added, p.photo_category_id, photo_sub_category_id'.
						', p.l_width, p.l_height, p.t_width, p.t_height, p.s_width, p.s_height, (p.rating_total/p.rating_count) as rating'.
						' FROM '.$this->CFG['db']['tbl']['photo'].' AS p, '.$this->CFG['db']['tbl']['users'].' AS u'.
						' WHERE '.$condition.' LIMIT 0, 1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($photoId));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->UserDetails = $this->getUserDetail('user_id', $row['user_id']);
						$this->photo_path = '';
						if($row['photo_ext'])
						{
							$this->photo_path = $row['photo_server_url'].$photos_folder.getPhotoName($photoId).$this->CFG['admin']['photos']['large_name'].'.'.$row['photo_ext'];
						}
						else
						{
							$this->photo_path = $this->CFG['site']['photo_url'].'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.
												$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_photo_index.jpg';
						}
						$photo_seo_title = $this->changeTitle($row['photo_title']);
						$photo_details['title'] = $row['photo_title'];
						$photo_details['description'] = wordWrap_mb_Manual($row['photo_caption'], $this->CFG['admin']['photos']['viewphoto_caption_list_length'], 75);
						$photo_details['target_url'] = getUrl('viewphoto','?photo_id='.$photoId.'&title='.$photo_seo_title, $photoId.'/'.$photo_seo_title.'/', '', 'photo');
						$photo_details['user_name'] = $this->UserDetails['user_name'];
						$photo_details['user_url'] = getMemberProfileUrl($row['user_id'], $this->UserDetails['user_name']);
						$photo_details['duration'] = '';
						$photo_details['image_src'] = $this->photo_path;
						$photo_details['large_width'] = $row['l_width'];
						$photo_details['large_height'] = $row['l_height'];
						$photo_details['total_views'] = $row['total_views'];
						$photo_details['total_comments'] = $row['total_comments'];
						$photo_details['total_ratings'] = round($row['rating']);
						$photo_details['view_content_text'] = $this->LANG['common_view_photo_text'];
						$photo_details['ratings_text'] = ($photo_details['total_ratings'] == 1)?$this->LANG['common_rating']:$this->LANG['common_ratings'];

						return $photo_details;
					}
				return $photo_details;
			}

		/**
		 * IndexPageHandler::chkAllowRating()
		 *
		 * @return void
		 */
		public function chkAllowRating($media_type, $media_id)
			{
				switch($media_type){
					case 'video':
						$table_name = $this->CFG['db']['tbl']['video'];
						$column_name = 'video_id';
						break;
					case 'music':
						$table_name = $this->CFG['db']['tbl']['music'];
						$column_name = 'music_id';
						break;
					case 'photo':
						$table_name = $this->CFG['db']['tbl']['photo'];
						$column_name = 'photo_id';
						break;
					default:
						return false;
				} // switch
				$sql = 'SELECT 1 FROM '.$table_name.
						' WHERE '.$column_name.' = '.$this->dbObj->Param($media_id).
						' AND allow_ratings=\'Yes\' LIMIT 0,1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($media_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					return true;
				return false;
			}

		/**
		 * IndexPageHandler::populateRatingImagesForAjax()
		 * purpose to populate images for rating
		 * @param $rating
		 * @return void
		 **/
		public function populateStaticRatingImages($rating, $media_type='video')
			{
				$rating_total = $this->CFG['admin']['total_rating'];
				?>
				<?php for($i=1; $i<=$rating; $i++) { ?>
					<img id="img<?php echo $i.$media_type;?>" src="<?php echo $this->CFG['site']['url'].'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-gliderratehover.gif'; ?>"  title="<?php echo $i;?>" />
				<?php } ?>
			    <?php for($i=$rating; $i<$rating_total; $i++) { ?>
					<img id="img<?php echo ($i+1).$media_type;?>" src="<?php echo $this->CFG['site']['url'].'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-gliderrate.gif';?>" title="<?php echo ($i+1);?>" />
				<?php } ?>
			    <?php
			}
		/**
		 * IndexPageHandler::fmtMusicPlayingTime()
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
		 * IndexPageHandler::featuredContentCommon()
		 *
		 * @return
		 */
		public function getFeaturedContent()
			{
				global $smartyObj;
				//START TO PREPARE FEATURED CONTENT GLIDER INFORMATION
				$featuredContent = $this->populateFeaturedContent();
				$smartyObj->assign('featuredContent', $featuredContent);
				//END TO PREPARE FEATURED CONTENT GLIDER INFORMATION
				if (count($featuredContent) == 0)
					{
						$promotional_content = $this->getPromotionalContent();
						$smartyObj->assign('promotional_content', $promotional_content);
						$smartyObj->display('indexPromotionalContent.tpl');
					}
				else
					{
						$smartyObj->display('indexLatestFeatured.tpl');
					}
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function getPromotionalContent()
			{
				$promotional_content = array();
				$promotional_content['glider_title'] = $this->LANG['promotional_glider_title'];
				$promotional_content['main_content'] = '<img src="'.$this->CFG['site']['url'].'files/index_glider_image/promotion_image.jpg" />';
				$promotional_content['rollover_content'] = '';
				$promotional_content['sidebar_content'] = $this->LANG['promotional_sidebar_content'];
				return $promotional_content;
			}

		public function setMainIndexMediaBlocks()
			{
				$sql = 'SELECT media_type, media_tab_type '.' FROM '.
						$this->CFG['db']['tbl']['index_media_tab_settings'];
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
					trigger_db_error($this->dbObj);
				$this->index_mediaB_blocks_arr= array();
				while($row = $rs->FetchRow())
				    {
				    	$this->index_media_blocks_arr[$row['media_type']]= $row['media_tab_type'];
				    }


			}

		/**
		 * IndexPageHandler::getTotalIndexVideoListPages()
		 * Function to get the total no of pages for the video carousel
		 *
		 * @param string $block_name todo block name comes from the DB
		 * @param int $limit no of records to be shown per page in the carousel,
		 * 				value can be varied / passed from tpl
		 * @return int total pages
		 */
		public function getTotalIndexVideoListPages($block_name, $limit)
		{
			$default_cond = 'u.usr_status=\'Ok\' AND v.video_status=\'Ok\''.$this->getAdultQuery('v.').
								' AND v.user_id = u.user_id AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
								' v.video_access_type = \'Public\''.$this->getAdditionalQuery().')';
			$global_limit = 50; //to avoid overloading

			switch($block_name)
			{
				case 'recommendedvideo':
					$this->LANG['mainIndex_video_heading'] = $this->LANG['mainIndex_video_recommended'];
					$condition = 'v.featured=\'Yes\' AND '.$default_cond;
					break;

				case 'topratedvideo':
					$this->LANG['mainIndex_video_heading'] = $this->LANG['mainIndex_video_top_rated'];
					$condition = 'v.rating_total>0 AND v.allow_ratings=\'Yes\' AND '.$default_cond;
					break;

				case 'newvideo':
					$this->LANG['mainIndex_video_heading'] = $this->LANG['mainIndex_video_new'];
					$condition = $default_cond;
					break;

				case 'recentlyviewedvideo':
					$this->LANG['mainIndex_video_heading'] = $this->LANG['mainIndex_video_recoentlyviewed'];
					$condition = $default_cond;
					break;
				default:
					$this->LANG['mainIndex_video_heading'] = $this->LANG['mainIndex_video_featured'];
					$condition = 'v.featured=\'Yes\' AND '.$default_cond;
					break;

			}

			$sql = 'SELECT COUNT(video_id) AS total_video FROM '.$this->CFG['db']['tbl']['video'].
					' AS v , '.$this->CFG['db']['tbl']['users'].' AS u '.
					'WHERE '.$condition . ' LIMIT ' . $global_limit;

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
				trigger_db_error($this->dbObj);

			if($row = $rs->FetchRow())
		    {
				$record_count = $row['total_video'];
				$total_pages = ceil($record_count/$limit);
				return $total_pages;
		    }
		    else
		    {
				return 0;
			}
		}
		/**
		 * IndexPageHandler::populateCarousalIndexVideoBlock()
		 *
		 * @param string $case block name
		 * @param integer $page_no page no for which the videos are to be fetched
		 * @param integer $rec_per_page Records per page
		 * @return
		 */
		public function populateCarousalIndexVideoBlock($case, $page_no=1, $rec_per_page=4)
			{
				global $smartyObj;
				$populateCarousalVideoBlock_arr['row'] = array();
				$start = ($page_no -1) * $rec_per_page; // start = (pageno -1) * rec per page

				$default_cond = 'u.usr_status=\'Ok\' AND v.video_status=\'Ok\''.$this->getAdultQuery('v.').
								' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
								' v.video_access_type = \'Public\''.$this->getAdditionalQuery().')';

				$default_fields = 'v.user_id, v.video_id, v.video_title, v.video_caption, v.total_views, v.video_server_url,'.
								   ' v.t_width, v.t_height,(v.rating_total/v.rating_count) as rating,'.
								   ' TIME_FORMAT(v.playing_time,\'%H:%i:%s\') as playing_time, TIMEDIFF(NOW(), v.date_added) as video_date_added,'.
								   ' TIMEDIFF(NOW(), v.last_view_date) as video_last_view_date, v.video_tags, v.is_external_embed_video, v.embed_video_image_ext,file_name';

					switch($case)
					{
						case 'recommendedvideo':
							$condition = 'v.featured=\'Yes\' AND '.$default_cond;
							$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
									' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON v.user_id=u.user_id'. ' LEFT JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'.
					   				' WHERE '.$condition;
							$all_video_url = getUrl('videolist','?pg=videorecommended', 'videorecommended/','','video');
							$order_by = 'featured_video_order_id DESC';
							break;

						case 'topratedvideo':
							$condition = 'v.rating_total>0 AND v.allow_ratings=\'Yes\' AND '.$default_cond;
							$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
									' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON v.user_id=u.user_id'. ' LEFT JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'.
					   				' WHERE '.$condition;
							$all_video_url = getUrl('videolist','?pg=videotoprated', 'videotoprated/','','video');
							$order_by = 'rating DESC';
							break;

						case 'newvideo':
							$condition = $default_cond;
							$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'. ' LEFT JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'.
									' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON v.user_id=u.user_id'.
					   				' WHERE '.$condition;
							$all_video_url = getUrl('videolist','?pg=videonew', 'videonew/','','video');
							$order_by = 'video_id DESC';
							break;

						case 'recentlyviewedvideo':
							$condition = $default_cond;
							$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
									' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON v.user_id=u.user_id'. ' LEFT JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'.
					   				' WHERE '.$condition;

							$all_video_url = getUrl('videolist','?pg=videomostrecentlyviewed', 'videomostrecentlyviewed/','','video');
							$order_by = 'last_view_date DESC';
							break;
					}

				$sql .= ' ORDER BY '.$order_by.' LIMIT '.$start.', '.$rec_per_page;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
					trigger_db_error($this->dbObj);

				$inc = 1;
				$this->is_not_member_url = getUrl('index','','','','video');
				$thumbnail_folder = $this->CFG['media']['folder'].'/'.
											$this->CFG['admin']['videos']['folder'].'/'.
											$this->CFG['admin']['videos']['thumbnail_folder'].'/';
				while($video_detail = $rs->FetchRow())
		    		{
						$populateCarousalVideoBlock_arr['row'][$inc]['record'] = $video_detail;
						$uploaded_by_user_name = $populateCarousalVideoBlock_arr['row'][$inc]['uploaded_by_user_name']= $this->getUserDetail('user_id',$video_detail['user_id'], 'user_name');
						$populateCarousalVideoBlock_arr['row'][$inc]['memberProfileUrl'] = getMemberProfileUrl($video_detail['user_id'], $uploaded_by_user_name);
					    $populateCarousalVideoBlock_arr['row'][$inc]['video_url'] = getUrl('viewvideo','?video_id='.$video_detail['video_id'].
																'&title='.$this->changeTitle($video_detail['video_title']),
																	$video_detail['video_id'].'/'.$this->changeTitle($video_detail['video_title']).'/','','video');
						$populateCarousalVideoBlock_arr['row'][$inc]['image_url'] = $video_detail['video_server_url'].$thumbnail_folder.
																getVideoImageName($video_detail['video_id'], $video_detail['file_name']).
																	$this->CFG['admin']['videos']['thumb_name'].'.'.
																		$this->CFG['video']['image']['extensions'];
						$populateCarousalVideoBlock_arr['row'][$inc]['video_title'] = $video_detail['video_title'];
						$populateCarousalVideoBlock_arr['row'][$inc]['total_views'] = $video_detail['total_views'];
						$video_detail['video_date_added']=getTimeDiffernceFormat($video_detail['video_date_added']);
						$populateCarousalVideoBlock_arr['row'][$inc]['video_date_added'] = getTimeDiffernceFormat($video_detail['video_date_added']);
						$populateCarousalVideoBlock_arr['row'][$inc]['video_last_view_date'] = getTimeDiffernceFormat($video_detail['video_last_view_date']);
						$populateCarousalVideoBlock_arr['row'][$inc]['playing_time'] = $video_detail['playing_time']?$video_detail['playing_time']:'00:00';
						if (($video_detail['is_external_embed_video'] == 'Yes' && $video_detail['embed_video_image_ext'] == ''))
						  {
							$populateCarousalVideoBlock_arr['row'][$inc]['image_url'] = $this->CFG['site']['url'].'video/design/templates/'.
																	$this->CFG['html']['template']['default'].
																		'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].
																			'/no_image/noImageVideo_T.jpg';
						  }
						$inc++;
		    		}
				$video_block_record_count = $inc - 1;
				$smartyObj->assign('populateCarousalVideoBlock_arr', $populateCarousalVideoBlock_arr);
		    	$smartyObj->assign('video_block_record_count', $video_block_record_count);//is record found
				setTemplateFolder('general/');
				$smartyObj->display('mainIndexVideoCarousel.tpl');
			}

		/**
		 * IndexPageHandler::getMainIndexPlayerVideo()
		 *
		 * @param integer $video_id
		 * @return
		 */
		public function getMainIndexPlayerVideo($video_id = 0)
			{
				$case = isset($this->index_media_blocks_arr['video']) ? $this->index_media_blocks_arr['video'] : $this->default_video_block;
				global $smartyObj;

				if($video_id)
				{
					$default_cond = 'v.video_id = '.$video_id;
				}
				else
				{
					$default_cond = 'u.usr_status=\'Ok\' AND v.video_status=\'Ok\''.$this->getAdultQuery('v.').
									' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
									' v.video_access_type = \'Public\''.$this->getAdditionalQuery().')';
				}

				$default_fields = 'v.video_id, v.video_title, (v.rating_total/v.rating_count) as rating, is_external_embed_video, video_external_embed_code ';
				switch($case)
				{
					case 'recommendedvideo':
						$condition = 'v.featured=\'Yes\' AND '.$default_cond;
						$sql = 'SELECT  '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
								' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON v.user_id=u.user_id'.
				   				' WHERE '.$condition;
						$all_video_url = getUrl('videolist','?pg=videorecommended', 'videorecommended/','','video');
						$order_by = 'featured_video_order_id DESC';
						break;

					case 'topratedvideo':
						$condition = 'v.rating_total>0 AND v.allow_ratings=\'Yes\' AND '.$default_cond;
						$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
								' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON v.user_id=u.user_id'.
				   				' WHERE '.$condition;
						$all_video_url = getUrl('videolist','?pg=videotoprated', 'videotoprated/','','video');
						$order_by = ' rating DESC';
						break;

					case 'newvideo':
						$condition = $default_cond;
						$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
								' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON v.user_id=u.user_id'.
				   				' WHERE '.$condition;
						$all_video_url = getUrl('videolist','?pg=videonew', 'videonew/','','video');
						$order_by = 'video_id DESC';
						break;

					case 'recentlyviewedvideo':
						$condition = $default_cond;
						$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
								' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON v.user_id=u.user_id'.
				   				' WHERE '.$condition;

						$all_video_url = getUrl('videolist','?pg=videomostrecentlyviewed', 'videomostrecentlyviewed/','','video');
						$order_by = 'last_view_date DESC';
						break;
				}
				$sql .=  ' ORDER BY '.$order_by.' LIMIT 0, 1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);

			    if (!$rs)
					trigger_db_error($this->dbObj);

				$video_list_arr = array();
				$inc = 0;
				$thumbnail_folder = $this->CFG['media']['folder'].'/'.
									$this->CFG['admin']['videos']['folder'].'/'.
									$this->CFG['admin']['videos']['thumbnail_folder'].'/';

				$separator = ':&nbsp;';
				if($row = $rs->FetchRow())
					{
						$video_list_arr[$inc]['video_url'] = getUrl('viewvideo','?video_id='.$row['video_id'].
																'&title='.$this->changeTitle($row['video_title']),
																	$row['video_id'].'/'.$this->changeTitle($row['video_title']).'/','','video');
						$video_list_arr[$inc]['video_title'] = $row['video_title'];
						$video_list_arr[$inc]['video_id'] = $row['video_id'];
						$video_list_arr[$inc]['is_external_embed_video'] = $row['is_external_embed_video'];
						$video_list_arr[$inc]['video_external_embed_code'] = $row['video_external_embed_code'];
						return $video_list_arr;
					}
				else
					{
						return false;
					}

			}
		public function getMainIndexVideoPlayer($video_id)
			{

					require_once($this->CFG['site']['project_path'].'common/classes/class_VideoHandler.lib.php');
					$video_handler  = new VideoHandler($this->dbObj, $this->CFG);
					$video_handler->setFormField('video_id', $video_id);
					$videos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/';
			 	   	$video_handler->populateSideBarFlashPlayerConfiguration($video_id);
					$this->arguments_play = 'pg=video_'.$video_id.'_no_'.getRefererForAffiliate().'_false_true_false';
					$this->CFG['admin']['videos']['playList']=false;
					?>
					<script type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/swfobject.js"></script>
					<script type="text/javascript">
		                var so1 = new SWFObject("<?php echo $video_handler->flv_player_url;?>", "flvplayer", "298", "251", "7",  null, true);
		                so1.addParam("allowFullScreen", "true");
		                so1.addParam("wmode", "transparent");
		                so1.addParam("autoplay", "false");
		                so1.addParam("allowSciptAccess", "always");
		                so1.addVariable("config", "<?php echo $video_handler->configXmlcode_url.$this->arguments_play;?>");
		                so1.write("flashcontent2");
	                </script>
					<?php
			}
		public function displayEmbededVideo($embed_code)
			{

				echo html_entity_decode($embed_code);

			}

		/**
		 * IndexPageHandler::getTotalMusicListPages()
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
					$condition = $default_cond;
					$this->LANG['mainIndex_music_heading'] = $this->LANG['mainIndex_music_recently_listened'];
					break;
				case 'newmusic':
					$condition = $default_cond;
					$this->LANG['mainIndex_music_heading'] = $this->LANG['mainIndex_music_new_musics'];
					break;
				case 'recommendedmusic':
					$condition = 'm.music_featured=\'Yes\' AND '.$default_cond;
					$this->LANG['mainIndex_music_heading'] = $this->LANG['mainIndex_music_recommended'];
					break;
				case 'topratedmusic':
					$condition = 'm.rating_total>0 AND m.allow_ratings=\'Yes\' AND '.$default_cond;
					$this->LANG['mainIndex_music_heading'] = $this->LANG['mainIndex_music_top_rated'];
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
		 * IndexPageHandler::populateCarousalIndexMusicBlock()
		 * sets the values in $populateCarousalMusicBlock_arr to be displayed from
		 * tpl.
		 *
		 *
		 * @param string $case
		 * @param int $page_no - page no starts with 1 passed in query string
		 * @param int $rec_per_page - rec per page in carousel passed in query string
		 * @return void
		 */
		public function populateCarousalIndexMusicBlock($case, $page_no=1, $rec_per_page=4)
			{
				global $smartyObj;
				$populateCarousalMusicBlock_arr['row'] = array();
				$start = ($page_no -1) * $rec_per_page; // start = (pageno -1) * rec per page

				$default_cond = ' u.user_id=m.user_id AND u.usr_status=\'Ok\' AND m.music_status=\'Ok\''.$this->getAdultQuery('m.', 'music').
								 ' AND (m.user_id = '.$this->CFG['user']['user_id'].' OR'.
								 ' m.music_access_type = \'Public\''.$this->getAdditionalQuery().')';

				$default_fields = 'u.user_name, m.music_id, m.user_id, m.music_title, m.total_plays, (m.rating_total/m.rating_count) as rating, m.music_server_url, m.music_thumb_ext, mfs.file_name, m.thumb_width, m.thumb_height, m.playing_time ';

				switch($case)
					{
						case 'recentlylistenedmusic':
							$order_by = 'last_view_date DESC';
							$condition = $default_cond;
							$sql = 'SELECT '.$default_fields.' '.
									'FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs ON mfs.music_file_id = m.thumb_name_id, '.$this->CFG['db']['tbl']['users'].' AS u '.
									'WHERE '.$condition.' ORDER BY '.$order_by;
						break;

						case 'recommendedmusic':
							$order_by = 'm.featured_music_order_id ASC';
							$condition = 'm.music_featured=\'Yes\' AND '.$default_cond;
							$sql = 'SELECT '.$default_fields.' '.
									' ,featured_music_order_id  FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs ON mfs.music_file_id = m.thumb_name_id, '.$this->CFG['db']['tbl']['users'].' AS u '.
									'WHERE '.$condition.' ORDER BY '.$order_by;
						break;

						case 'newmusic'://NEW MUSIC//
							$condition = $default_cond;
							$order_by = ' m.music_id DESC ';
							$sql = 'SELECT '.$default_fields.' '.
									'FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs ON mfs.music_file_id = m.thumb_name_id, '.$this->CFG['db']['tbl']['users'].' AS u '.
									'WHERE '.$condition.' ORDER BY '.$order_by;
						break;

						case 'topratedmusic':
							$order_by = 'rating DESC';
							$condition = 'm.rating_total>0 AND m.allow_ratings=\'Yes\' AND '.$default_cond;
							$sql = 'SELECT '.$default_fields.' '.
									'FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs ON mfs.music_file_id = m.thumb_name_id, '.$this->CFG['db']['tbl']['users'].' AS u '.
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
		    			$populateCarousalMusicBlock_arr['row'][$inc]['record'] = $music_detail;
		    			$populateCarousalMusicBlock_arr['row'][$inc]['memberprofile_url'] = getUrl('viewprofile','?user='.$music_detail['user_name'], $music_detail['user_name'].'/');
		    			$populateCarousalMusicBlock_arr['row'][$inc]['viewmusic_url'] = getUrl('viewmusic', '?music_id='.$music_detail['music_id'].'&title='.$this->changeTitle($music_detail['music_title']), $music_detail['music_id'].'/'.$this->changeTitle($music_detail['music_title']).'/', '', 'music');
						$populateCarousalMusicBlock_arr['row'][$inc]['playing_time'] =  $this->fmtMusicPlayingTime($music_detail['playing_time']);
						// IMAGE //
						if($music_detail['music_thumb_ext'])
							{
								$populateCarousalMusicBlock_arr['row'][$inc]['music_image_src'] = $music_detail['music_server_url'].$musics_folder.getMusicImageName($music_detail['music_id'], $music_detail['file_name']).$this->CFG['admin']['musics']['thumb_name'].'.'.$music_detail['music_thumb_ext'];
							}
						else
							{
								$populateCarousalMusicBlock_arr['row'][$inc]['music_image_src'] = '';
							}
						$inc++;
		    		}
				$music_block_record_count = $inc - 1;
				$smartyObj->assign('populateCarousalMusicBlock_arr', $populateCarousalMusicBlock_arr);
		    	$smartyObj->assign('music_block_record_count', $music_block_record_count);//is record found
				setTemplateFolder('general/');
				$smartyObj->display('mainIndexMusicCarousel.tpl');
			}
		/**
		 * IndexPageHandler::populateDiscussionRecentBoards()
		 *
		 * @return
		 */
		public function populateDiscussionRecentBoards()
			{
				global $smartyObj;
				require_once('common/classes/class_DiscussionHandler.lib.php');
				$discuzzRecentBoards = new DiscussionHandler();
				$discuzzRecent =  $discuzzRecentBoards->displayRecentBoards();
				$smartyObj->assign('recentDiscussionBoards',$discuzzRecent);
				setTemplateFolder('general/');
				$smartyObj->display('mainIndexOtherRecentBoard.tpl');
			}
		/**
		 * IndexPageHandler::populateArticleRecent()
		 *
		 * @return
		 */
		public function populateArticleRecent()
			{
				global $smartyObj;
				require_once('common/classes/class_ArticleHandler.lib.php');
				$articleRecentBoards = new ArticleHandler();
				$articleRecent =  $articleRecentBoards->populateCarousalarticleBlock('articlerecent'); //$smartyObj->assign('populateArticleRecentBlock_arr', $blogRecentBoards);
				setTemplateFolder('general/');
				$smartyObj->display('mainIndexOtherRecentArticle.tpl');
			}
		/**
		 * IndexPageHandler::populateBlogRecent()
		 *
		 * @return
		 */
		public function populateBlogRecent()
			{
				global $smartyObj;
				require_once('common/classes/class_BlogHandler.lib.php');
				$blogRecentBoards = new BlogHandler();
				$blogRecentBoards =  $blogRecentBoards->populateBlogRecentBlock('blogrecent');
				$smartyObj->assign('populateBlogRecentBlock_arr', $blogRecentBoards);
				setTemplateFolder('general/');
				$smartyObj->display('mainIndexOtherRecentBlog.tpl');
			}

		public function populateRecent($case='recentboard')
		{
				switch($case)
					{
						case 'recentboard':
								if (chkAllowedModule(array('discussions'))) {
									$this->populateDiscussionRecentBoards();
								}
						break;
						case 'recentblog':
								if (chkAllowedModule(array('blog'))) {
								$this->populateBlogRecent();
								}
						break;

						case 'recentarticle':
								if (chkAllowedModule(array('article'))) {
									$this->populateArticleRecent();
								}
						break;
					}
		}
		/**
		 * IndexPageHandler::populateVideoTag()
		 *
		 * @return
		 */
		public function populateVideoTag()
			{
				global $smartyObj;
				require_once('common/classes/class_VideoHandler.lib.php');
				$videoTags = new VideoHandler();
				$limit = 20;
				$cloudVideoTags =  $videoTags->populateSidebarClouds('video','tags_video',$limit,true);
				setTemplateFolder('general/');
				$smartyObj->display('populateCloudsBlock.tpl');
			}
		/**
		 * IndexPageHandler::populateMusicTag()
		 *
		 * @return
		 */
		public function populateMusicTag()
			{
				global $smartyObj;
				require_once('common/classes/class_MusicHandler.lib.php');
				$musicTags = new MusicHandler();
				$limit = 20;
				$cloudMusicTags =  $musicTags->populateSidebarClouds('music','music_tags',$limit,true);
				setTemplateFolder('general/');
				$smartyObj->display('populateCloudsBlock.tpl');
			}
		/**
		 * IndexPageHandler::populateBlogRecent()
		 *
		 * @return
		 */
		public function populatePhotoTag()
			{
				global $smartyObj;
				require_once('common/classes/class_PhotoHandler.lib.php');
				$photoTags = new PhotoHandler();
				$limit = 20;
				$cloudPhotoTags =  $photoTags->populateSidebarClouds('photo','photo_tags',$limit,true);
				setTemplateFolder('general/');
				$smartyObj->display('populateCloudsBlock.tpl');
			}

		public function populateTags($case='photo')
		{
				switch($case)
					{
						case 'photo':
								if(!chkAllowedModule(array('photo')))
									exit;
								$this->populatePhotoTag();
						break;

						case 'video':
								if(!chkAllowedModule(array('video')))
									exit;
								$this->populateVideoTag();
						break;

						case 'music':
								if(!chkAllowedModule(array('music')))
									exit;
								$this->populateMusicTag();
						break;
					}
		}
		/**
		 * IndexPageHandler::populateSinglePlayerConfiguration()
		 *
		 * @return void
		 */
		public function populateSinglePlayerConfiguration()
		 	{
				$this->flv_player_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['index_single_player']['player_path'].
													$this->CFG['admin']['musics']['index_single_player']['swf_name'].'.swf';
				$this->configXmlcode_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['index_single_player']['config_name'].'.php?';
				$this->playlistXmlcode_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['index_single_player']['playlist_name'].'.php?';
				$this->addsXmlCode_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['index_single_player']['ad_name'].'.php';
				//END TO ADD THE CODING FOR GETTING THE THEME AS TEMPLATE BASED
				if(is_file($this->CFG['site']['project_path'].$this->CFG['admin']['musics']['index_single_player']['theme_path'].
				$this->CFG['html']['template']['default'].
				'_skin_'.str_replace('screen_','',$this->CFG['html']['stylesheet']['screen']['default']).'.xml'))
				{
					$this->CFG['admin']['musics']['index_single_player']['xml_theme'] =$this->CFG['html']['template']['default'].'_skin_'.
					str_replace('screen_','',$this->CFG['html']['stylesheet']['screen']['default']).'.xml';
				}
				//END TO ADD THE CODING FOR GETTING THE THEME AS TEMPLATE BASED
				$this->themesXml_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['index_single_player']['theme_path'].
														$this->CFG['admin']['musics']['index_single_player']['xml_theme'];

			}

		/**
		 * IndexPageHandler::populateSinglePlayer()
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
					$music_fields['width'] = $this->CFG['admin']['musics']['index_single_player']['width'];

				if($music_fields['height'] == '')
					$music_fields['height'] = $this->CFG['admin']['musics']['index_single_player']['height'];

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
		 * IndexPageHandler::getMainIndexPlayerMusic()
		 *
		 * @param integer $music_id
		 * @return boolean
		 */
		public function getMainIndexPlayerMusic($music_id = 0)
			{
				global $smartyObj;
				$case = isset($this->index_media_blocks_arr['music']) ? $this->index_media_blocks_arr['music'] : $this->default_music_block;

				if($music_id)
				{
					$default_cond = 'm.music_id = '.$music_id;
				}
				else
				{
					$default_cond = ' u.user_id=m.user_id AND u.usr_status=\'Ok\' AND m.music_status=\'Ok\''.$this->getAdultQuery('m.', 'music').
								 ' AND (m.user_id = '.$this->CFG['user']['user_id'].' OR'.
								 ' m.music_access_type = \'Public\''.$this->getAdditionalQuery().')';
				}

				$default_fields = 'u.user_name, m.music_id, m.user_id, m.music_title, (m.rating_total/m.rating_count) as rating,  m.music_caption';

				switch($case)
					{
						case 'recentlylistenedmusic':
							$order_by = 'last_view_date DESC';
							$condition = $default_cond;
							$sql = 'SELECT '.$default_fields.' '.
									'FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs ON mfs.music_file_id = m.thumb_name_id, '.$this->CFG['db']['tbl']['users'].' AS u '.
									'WHERE '.$condition.' ORDER BY '.$order_by;
						break;

						case 'recommendedmusic':
							$order_by = 'm.featured_music_order_id ASC';
							$condition = 'm.music_featured=\'Yes\' AND '.$default_cond;
							$sql = 'SELECT '.$default_fields.' '.
									' ,featured_music_order_id  FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs ON mfs.music_file_id = m.thumb_name_id, '.$this->CFG['db']['tbl']['users'].' AS u '.
									'WHERE '.$condition.' ORDER BY '.$order_by;
						break;

						case 'newmusic'://NEW MUSIC//
							$condition = $default_cond;
							$order_by = ' m.music_id DESC ';
							$sql = 'SELECT '.$default_fields.' '.
									'FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs ON mfs.music_file_id = m.thumb_name_id, '.$this->CFG['db']['tbl']['users'].' AS u '.
									'WHERE '.$condition.' ORDER BY '.$order_by;
						break;

						case 'topratedmusic':
							$order_by = 'rating DESC';
							$condition = 'm.rating_total>0 AND m.allow_ratings=\'Yes\' AND '.$default_cond;
							$sql = 'SELECT '.$default_fields.' '.
									'FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs ON mfs.music_file_id = m.thumb_name_id, '.$this->CFG['db']['tbl']['users'].' AS u '.
									'WHERE '.$condition.' ORDER BY '.$order_by;
						break;
					}

				$sql .= ' LIMIT 0, 1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);

			    if (!$rs)
					trigger_db_error($this->dbObj);

				$inc = 0;
				$music_list_arr = array();
				$musics_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['musics']['folder'] . '/' . $this->CFG['admin']['musics']['thumbnail_folder'] . '/';
				if($music_detail = $rs->FetchRow())
	    		{
	    			$this->music_caption= wordWrap_mb_ManualWithSpace(nl2br(($music_detail['music_caption'])),
										$this->CFG['admin']['musics']['viewmusic_caption_list_length'],
											$this->CFG['admin']['musics']['viewmusic_caption_list_total_length']);

					$this->music_title = wordWrap_mb_ManualWithSpace(($music_detail['music_title']),
											$this->CFG['admin']['musics']['viewmusic_title_list_length'],
												$this->CFG['admin']['musics']['viewmusic_title_list_total_length']);


					//Populate single player configuration
					$this->populateSinglePlayerConfiguration();
					$this->configXmlcode_url .= 'pg=music_'.$music_detail['music_id'].'_ip';
					$this->playlistXmlcode_url .= 'pg=music_'.$music_detail['music_id'];
					$this->main_player_music_title = $music_detail['music_title'];
					return true;
	    		}
				else
				{
					return false;
				}

			}

	/**
	 * IndexPageHandler::getTotalPhotoListPages()
	 * Function to get the total no of pages for the photo carousel
	 *
	 * @param string $block_name
	 * @param int $limit no of records to be shown per page in the carousel,
	 * 				value can be varied / passed from tpl
	 * @return int total pages
	 */
	public function getTotalPhotoListPages($block_name, $limit)
	{

		$default_cond = ' u.user_id=p.user_id AND u.usr_status=\'Ok\' AND p.photo_status=\'Ok\''.$this->getAdultQuery('p.', 'photo').
						 ' AND (p.user_id = '.$this->CFG['user']['user_id'].' OR'.
						 ' p.photo_access_type = \'Public\''.$this->getAdditionalQuery().')';
		$global_limit = 100; //to avoid overloading

		switch($block_name)
		{
			case 'mostrecentphoto':
				$this->LANG['mainIndex_photo_heading'] = $this->LANG['mainIndex_photo_most_recent'];
				$condition = $default_cond;
				break;
			case 'recommendedphoto':
				$this->LANG['mainIndex_photo_heading'] = $this->LANG['mainIndex_photo_recommended'];
				$condition = 'p.total_featured>0  AND '.$default_cond;
				break;
			case 'mostfavoritephoto':
				$this->LANG['mainIndex_photo_heading'] = $this->LANG['mainIndex_photo_favorite'];
				$condition = 'p.total_favorites > 0  AND '.$default_cond;
				break;
			case 'topratedphoto':
				$this->LANG['mainIndex_photo_heading'] = $this->LANG['mainIndex_photo_top_rated'];
				$condition = 'p.rating_total > 0 AND p.allow_ratings=\'Yes\' AND '.$default_cond;
				break;
		}

		$sql = 'SELECT COUNT(*) AS total_photo FROM '.$this->CFG['db']['tbl']['photo'].
				' AS p , '.$this->CFG['db']['tbl']['users'].' AS u '.
				'WHERE '.$condition.' LIMIT '. $global_limit;

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
	    if (!$rs)
			trigger_db_error($this->dbObj);

		if($row = $rs->FetchRow())
	    {
			$record_count = $row['total_photo'];
			$total_pages = ceil($record_count/$limit);
			return $total_pages;
	    }
	    else
	    {
			return 0;
		}
	}


	/**
	 * IndexPageHandler::populateCarousalIndexPhotoBlock()
	 * sets the values in $populateCarousalphotoBlock_arr to be displayed from
	 * tpl.
	 *
	 *
	 * @param string $case
	 * @param int $page_no - page no starts with 1 passed in query string
	 * @param int $rec_per_page - rec per page in carousel passed in query string
	 * @return void
	 */
	public function populateCarousalIndexPhotoBlock($case, $page_no=1, $rec_per_page=4)
	{
		global $smartyObj;
		$populateCarousalphotoBlock_arr['row'] = array();
		$start = ($page_no -1) * $rec_per_page; // start = (pageno -1) * rec per page
		$default_cond = ' u.user_id=p.user_id AND u.usr_status=\'Ok\' AND p.photo_status=\'Ok\''.$this->getAdultQuery('p.', 'photo').
						 ' AND (p.user_id = '.$this->CFG['user']['user_id'].' OR'.
						 ' p.photo_access_type = \'Public\''.$this->getAdditionalQuery().')';

		$default_fields = 'distinct(p.photo_id),u.user_id, (p.rating_total/p.rating_count) as rating, p.photo_title,p.photo_status, p.l_width, p.total_views, p.photo_ext, p.t_width, p.t_height, p.photo_server_url,u.user_name ';

		switch($case)
		{
			case 'mostrecentphoto':
				$order_by = 'p.date_added DESC';
				$condition = $default_cond;
				$sql = 'SELECT '.$default_fields.' '.
						'FROM '.$this->CFG['db']['tbl']['photo'].' AS p JOIN '.$this->CFG['db']['tbl']['users'].' AS u '.
						'WHERE '.$condition.' ORDER BY '.$order_by;
			break;

			case 'recommendedphoto':
				$order_by = 'total_featured DESC';
				$condition = 'p.total_featured>0  AND '.$default_cond;
				$sql = 'SELECT '.$default_fields.' '.
						'FROM '.$this->CFG['db']['tbl']['photo'].' AS p JOIN '.$this->CFG['db']['tbl']['users'].' AS u '.
						'WHERE '.$condition.' ORDER BY '.$order_by;
			break;

			case 'mostfavoritephoto'://NEW photo//
				$condition = 'p.total_favorites > 0  AND '.$default_cond;
				$order_by = ' p.total_favorites DESC, p.total_views DESC ';
				$sql = 'SELECT '.$default_fields.' '.
						'FROM '.$this->CFG['db']['tbl']['photo'].' AS p JOIN  '.$this->CFG['db']['tbl']['users'].' AS u '.
						'WHERE '.$condition.' ORDER BY '.$order_by;
			break;

			case 'topratedphoto':
				$order_by = 'rating DESC';
				$condition = 'p.rating_total > 0 AND p.allow_ratings=\'Yes\' AND '.$default_cond;
				$sql = 'SELECT '.$default_fields.' '.
						'FROM '.$this->CFG['db']['tbl']['photo'].' AS p JOIN '.$this->CFG['db']['tbl']['users'].' AS u '.
						'WHERE '.$condition.' ORDER BY '.$order_by;
			break;
		}

		$sql .= ' LIMIT '.$start.', '.$rec_per_page;
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
	    if (!$rs)
			trigger_db_error($this->dbObj);

		$inc = 1;
		$allow_quick_mixs = (isLoggedIn() and $this->CFG['admin']['photos']['allow_quick_mixs'])?true:false;
		$photos_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['photos']['folder'] . '/' . $this->CFG['admin']['photos']['folder'] . '/';
		while($photo_detail = $rs->FetchRow())
		{
			$populateCarousalphotoBlock_arr['row'][$inc]['record'] = $photo_detail;
			$populateCarousalphotoBlock_arr['row'][$inc]['MemberProfileUrl'] = getMemberProfileUrl($photo_detail['user_id'], $photo_detail['user_name']);
			$populateCarousalphotoBlock_arr['row'][$inc]['photo_title_js'] = addslashes(wordWrap_mb_ManualWithSpace($photo_detail['photo_title'],
																				$this->CFG['admin']['photos']['indexphotoblock_photo_zoom_title_length'],
																				$this->CFG['admin']['photos']['indexphotoblock_photo_zoom_title_total_length']));
			$populateCarousalphotoBlock_arr['row'][$inc]['viewphoto_url'] = getUrl('viewphoto', '?photo_id='.$photo_detail['photo_id'].'&title='.$this->changeTitle($photo_detail['photo_title']), $photo_detail['photo_id'].'/'.$this->changeTitle($photo_detail['photo_title']).'/', '', 'photo');
			$populateCarousalphotoBlock_arr['row'][$inc]['add_quickmix'] = false;
            if ($allow_quick_mixs)
			{
                $populateCarousalphotoBlock_arr['row'][$inc]['add_quickmix'] = true;
                $populateCarousalphotoBlock_arr['row'][$inc]['is_quickmix_added'] = false;
                if (rayzzPhotoQuickMix($photo_detail['photo_id']))
                    $populateCarousalphotoBlock_arr['row'][$inc]['is_quickmix_added'] = true;
            }
			// IMAGE //
			if($photo_detail['photo_ext'])
			{
				$populateCarousalphotoBlock_arr['row'][$inc]['photo_large_image_src'] = $photo_detail['photo_server_url'].$photos_folder.getphotoName($photo_detail['photo_id']).$this->CFG['admin']['photos']['large_name'].'.'.$photo_detail['photo_ext'];
				$zoom_icon = false;
	        	if($photo_detail['l_width'] > $this->CFG['admin']['photos']['thumb_width'])
	        		$zoom_icon = true;
	        	$populateCarousalphotoBlock_arr['row'][$inc]['zoom_icon'] = $zoom_icon;
				$populateCarousalphotoBlock_arr['row'][$inc]['photo_image_src'] = $photo_detail['photo_server_url'].$photos_folder.getphotoName($photo_detail['photo_id']).$this->CFG['admin']['photos']['thumb_name'].'.'.$photo_detail['photo_ext'];
			}
			else
			{
				$populateCarousalphotoBlock_arr['row'][$inc]['photo_image_src'] = '';
			}

			$inc++;
		}
		$photo_block_record_count = $inc - 1;
		$smartyObj->assign('populateCarousalphotoBlock_arr', $populateCarousalphotoBlock_arr);
    	$smartyObj->assign('photo_block_record_count', $photo_block_record_count);//is record found
		setTemplateFolder('general/');
		$smartyObj->display('mainIndexPhotoCarousel.tpl');
	}

	/**
	* IndexPageHandler::getMainIndexPhotoBlock()
	* sets the values in $result_arr to be displayed from
	* tpl.
	*
	* @return void
	*/
	public function getMainIndexPhotoBlock()
	{
		global $smartyObj;
		$block_name = isset($this->index_media_blocks_arr['photo']) ? $this->index_media_blocks_arr['photo'] : $this->default_photo_block;

		$default_cond = ' u.user_id=p.user_id AND u.usr_status=\'Ok\' AND p.photo_status=\'Ok\''.$this->getAdultQuery('p.', 'photo').
						 ' AND (p.user_id = '.$this->CFG['user']['user_id'].' OR'.
						 ' p.photo_access_type = \'Public\''.$this->getAdditionalQuery().')';
		$default_fields = 'distinct(p.photo_id),u.user_id, p.photo_title,p.photo_status, (p.rating_total/p.rating_count) as rating, p.l_width, p.total_views, p.photo_ext, p.t_width, p.t_height, p.photo_server_url,u.user_name, TIMEDIFF(NOW(), p.date_added) as photo_date_added, p.l_width, p.l_height ';
		$global_limit = 15; //to avoid overloading

		switch($block_name)
		{
			case 'mostrecentphoto':
				$order_by = 'p.date_added DESC';
				$condition = $default_cond;
			break;

			case 'recommendedphoto':
				$order_by = 'total_featured DESC';
				$condition = 'p.total_featured>0  AND '.$default_cond;
			break;

			case 'mostfavoritephoto'://NEW photo//
				$condition = 'p.total_favorites > 0  AND '.$default_cond;
				$order_by = ' p.total_favorites DESC, p.total_views DESC ';
			break;

			case 'topratedphoto':
				$order_by = 'rating DESC';
				$condition = 'p.rating_total > 0 AND p.allow_ratings=\'Yes\' AND '.$default_cond;
			break;
		}

		$sql = 'SELECT '.$default_fields.' '.
				'FROM '.$this->CFG['db']['tbl']['photo'].' AS p JOIN '.$this->CFG['db']['tbl']['users'].' AS u '.
				'WHERE '.$condition.' ORDER BY '.$order_by . ' LIMIT ' . $global_limit;
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_db_error($this->dbObj);

		$this->photoDisplayed = false;
		$this->isFeaturedphoto = false;
		$result_arr = array();
		$featured_photo_list_arr['isFeaturedphoto']='false';
		$this->setFormField('photo_id',0);
		$featured_photo_list_arr['photo_id']=0;
		$photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';

		if ($rs->PO_RecordCount())
		{
			$this->isFeaturedphoto = true;
			$inc = 0;
			while($row = $rs->FetchRow())
			{
				  $result_arr[$inc]['photo_title'] = $row['photo_title'];
				  $result_arr[$inc]['thumb_width'] = $row['l_width'];
				  $result_arr[$inc]['thumb_height'] = $row['l_height'];
				  $result_arr[$inc]['user_name'] = $this->getUserDetail('user_id', $row['user_id'], 'user_name');
				  $result_arr[$inc]['MemberProfileUrl'] = getMemberProfileUrl($row['user_id'], $result_arr[$inc]['user_name']);
				  $result_arr[$inc]['date_added'] = ($row['photo_date_added'] != '') ? getTimeDiffernceFormat($row['photo_date_added']) : '';
				  $photo_name = getphotoName($row['photo_id']);
				  $result_arr[$inc]['thumb_img_src'] = $row['photo_server_url'] . $photos_folder.$photo_name.$this->CFG['admin']['photos']['thumb_name'].'.'.$row['photo_ext'];
				  $result_arr[$inc]['medium_img_src'] = $row['photo_server_url'] . $photos_folder.$photo_name.$this->CFG['admin']['photos']['medium_name'].'.'.$row['photo_ext'];
				  $result_arr[$inc]['view_photo_link'] = getUrl('viewphoto', '?photo_id=' . $row['photo_id'] . '&title=' . $this->changeTitle($row['photo_title']), $row['photo_id'] . '/' . $this->changeTitle($row['photo_title']) . '/', '', 'photo');
				  $inc++;
			}
		}
		//Populate playlist player configuration
		$smartyObj->assign('isFeaturedphoto', $this->isFeaturedphoto);
		$smartyObj->assign('featured_photo_list_arr', $result_arr);
		$smartyObj->assign('myobjFeaturedPhoto', $this);
	}


}
$index = new IndexPageHandler();
$index->setPageBlockNames(array('block_feartured_content_glider'));
$index->setFormField('block','');
$index->setFormField('mainvideoblock','');
$index->setFormField('mainmusicblock','');
$index->setFormField('mainphotoblock','');
$index->setFormField('module','');
$index->setFormField('reload_player','');
$index->setFormField('reload_music_player','');
$index->setFormField('video_id','');
$index->setFormField('music_id','');
$index->setFormField('showtab', '');
$index->setFormField('start','');
$index->setFormField('limit','');
$index->setFormField('cloud_tab','');
$index->sanitizeFormInputs($_REQUEST);
$smartyObj->assign('LANG',$LANG);
$smartyObj->assign('mainIndexObj',$index);
$smartyObj->assign('myobj',$index);


if(!isAjaxPage())
{
	if (chkAllowedModule(array('video')))//Check video module enable or disable
		{
			//set the blocks to be shown for each media block
			$index->setMainIndexMediaBlocks();
			//set the video to be loaded for the index player
			if($index->main_index_video_arr = $index->getMainIndexPlayerVideo())
			{
				$index->isMainVideoExternal = ($index->main_index_video_arr[0]['is_external_embed_video'] =='Yes') ? 1 : 0;
				$index->main_player_video_title = $index->main_index_video_arr[0]['video_title'];
				$index->main_player_embed_code = $index->main_index_video_arr[0]['video_external_embed_code'];
				$index->main_player_video_id = $index->main_index_video_arr[0]['video_id'];
			}


			//set the total pages for the video carousel block ..
			$index->default_video_block = isset($index->index_media_blocks_arr['video']) ? $index->index_media_blocks_arr['video'] : $index->default_video_block;
			$total_video_carousel_pages = $index->getTotalIndexVideoListPages($index->default_video_block, 4);
			$smartyObj->assign('total_video_carousel_pages', $total_video_carousel_pages);
		}

	if (chkAllowedModule(array('music')))//Check music module enable or disable
		{
			//START SINGLE MUSIC PLAYER ARRAY FIELDS
			$auto_play =  'false';
			if($CFG['admin']['musics']['single_player']['AutoPlay'])
				$auto_play = 'true';

			$music_fields = array(
				'div_id' => 'flashcontetnt',
				'music_player_id' => 'view_music_player',
				'height' => 246,
				'width' => 300,
				'auto_play' => $auto_play
			);
			$smartyObj->assign('music_fields', $music_fields);
			//END SINGLE MUSIC PLAYER ARRAY FIELDS
			//set the music to be loaded for the index player
			$index->valid_music_details = $index->getMainIndexPlayerMusic();

			//set the total pages for the music carousel block ..
			$index->default_music_block = isset($index->index_media_blocks_arr['music']) ? $index->index_media_blocks_arr['music'] : $index->default_music_block;
			$total_music_carousel_pages = $index->getTotalMusicListPages($index->default_music_block, 4);
			$smartyObj->assign('total_music_carousel_pages', $total_music_carousel_pages);
		}

	if (chkAllowedModule(array('photo'))) //Check photo module enable or disable
		{
			//get all photos to display in slide show
			$index->getMainIndexPhotoBlock();
			//set the total pages for the photo carousel block ..
			$index->default_photo_block = isset($index->index_media_blocks_arr['photo']) ? $index->index_media_blocks_arr['photo'] : $index->default_photo_block;
			$total_photo_carousel_pages = $index->getTotalPhotoListPages($index->default_photo_block, 4);
			$smartyObj->assign('total_photo_carousel_pages', $total_photo_carousel_pages);
		}
	// What Going on activities in index page
	if($CFG['admin']['show_recent_activities'])
		{
			$Activity = new ActivityHandler();
			$Activity->setActivityType(strtolower($CFG['admin']['myhome']['recent_activity_default_content']));
			$activity_view_all_url = getUrl('activity', '?pg='.strtolower($CFG['admin']['myhome']['recent_activity_default_content']), strtolower($CFG['admin']['myhome']['recent_activity_default_content']).'/updates/', 'members');
			$smartyObj->assign('activity_view_all_url', $activity_view_all_url);
		}
}
if(isAjaxPage())
{
	//ajax call from the carousel for the video block
	if($index->getFormField('mainvideoblock') != '')
		{
			$index->populateCarousalIndexVideoBlock($index->getFormField('mainvideoblock'), $index->getFormField('start'), $index->getFormField('limit'));
			exit;
		}

	//ajax call from the carousel for the music block
	if($index->getFormField('mainmusicblock') != '')
		{
			$index->populateCarousalIndexMusicBlock($index->getFormField('mainmusicblock'), $index->getFormField('start'), $index->getFormField('limit'));
			exit;
		}

	//ajax call from the carousel for the photo block
	if($index->getFormField('mainphotoblock') != '')
	{
		$index->populateCarousalIndexPhotoBlock($index->getFormField('mainphotoblock'), $index->getFormField('start'), $index->getFormField('limit'));
		exit;
	}

	if($index->getFormField('reload_player'))
		{
			$index->setMainIndexMediaBlocks();
			if($index->main_index_video_arr = $index->getMainIndexPlayerVideo($index->getFormField('video_id')))
				{
					$index->isMainVideoExternal = ($index->main_index_video_arr[0]['is_external_embed_video'] =='Yes') ? 1 : 0;
					$index->main_player_video_title = $index->main_index_video_arr[0]['video_title'];
					$index->main_player_embed_code = $index->main_index_video_arr[0]['video_external_embed_code'];
					$index->main_player_video_id = $index->main_index_video_arr[0]['video_id'];
				}
			setTemplateFolder('general/');
			$smartyObj->display('mainIndexVideoPlayer.tpl');
			exit;
		}
	if($index->getFormField('reload_music_player'))
	{
		$index->setMainIndexMediaBlocks();
		//START SINGLE PLAYER ARRAY FIELDS
		$auto_play =  'false';
		if($CFG['admin']['musics']['single_player']['AutoPlay'])
			$auto_play = 'true';

		$music_fields = array(
			'div_id' => 'flashcontetnt',
			'music_player_id' => 'view_music_player',
			'height' => 246,
			'width' => 300,
			'auto_play' => $auto_play
		);
		$smartyObj->assign('music_fields', $music_fields);
		//END SINGLE PLAYER ARRAY FIELDS
		$index->valid_music_details = $index->getMainIndexPlayerMusic($index->getFormField('music_id'));
		setTemplateFolder('general/');
		$smartyObj->display('mainIndexMusicPlayer.tpl');
		exit;
	}
				if($index->getFormField('showtab')!= '')
				{
					$index->populateRecent($index->getFormField('showtab'));
					exit;
				}
				if($index->getFormField('cloud_tab')!= '')
					{
						$index->populateTags($index->getFormField('cloud_tab'));
						exit;
					}
}
//if($index->index_module != '' && $index->index_page_link != $CFG['site']['current_url'])
//	Redirect2URL($index->index_page_link);
$index->setPageBlockShow('block_feartured_content_glider');

$index->setPageBlockShow('block_msg_form_error');
$index->setCommonErrorMsg($LANG['index_no_module']);
//<<<<--------------------video block javascript start ----------------------------//
?>
<?php
$index->includeHeader();
?>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/createPlaylist.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['photo_url'];?>js/functions.js"></script>
<script type="text/javascript">
/**
 *
 * @access public
 * @return void
 **/
function loadThisVideo(video_id)
{
		var url = '<?php echo $CFG['site']['url'].'index.php';?>';
		var path = '?ajax_page=true&video_id='+video_id+'&reload_player=1';
		jquery_ajax(path, '', 'loadIndexPlayer');
}
/**
 *
 * @access public
 * @return void
 **/
function loadThisMusic(music_id)
{
		var url = '<?php echo $CFG['site']['url'].'index.php';?>';
		var path = '?ajax_page=true&music_id='+music_id+'&reload_music_player=1';
		jquery_ajax(path, '', 'loadIndexMusicPlayer');
}
/**
 *
 * @access public
 * @return void
 **/
function loadIndexPlayer(data)
{
	//$Jq('#mainIndexVideoPlayer').html('');
	$Jq('#mainIndexVideoPlayer').html(data);

	/*if(!$Jq('#flashcontent2').find('object').attr('width')){
		alert(1);
	}*/
	setTimeout('chkExtenalEmbededHeightAndWidth()', 100);
	//chkExtenalEmbededHeightAndWidth();
}
/**
 *
 * @access public
 * @return void
 **/
function loadIndexMusicPlayer(data)
{
	$Jq('#clsIndexMusicBlockPlayer').html(data);
}
</script>
<?php
setTemplateFolder('general/');
$smartyObj->display('index.tpl');
$index->includeFooter();
?>
