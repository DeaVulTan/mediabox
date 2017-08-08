<?php
class MusicTracker extends MusicHandler
	{
		public $slideShowUrl;
		public $advanceSearch;
		/**
		* MusicTracker::getPageTitle()
		*
		* @return
		*/
		public function getPageTitle()
			{
				$pg_title = $this->LANG['musictracker_musicnew_title'];
				//If default value is Yes then reset the pg value as null.
				if($this->getFormField('default')== 'Yes' && $this->fields_arr['pg'] == 'musictracker')
				$this->fields_arr['pg'] = '';

				$categoryTitle = '';
				$tagsTitle     = '';
				$artistTitle   = '';
				if ($this->fields_arr['pg'])
				{
					$pg_title = $this->LANG['header_nav_music_music_new'];
				}

				return $pg_title;
			}
		public function populateRatingDetails($rating)
			{
				$rating = round($rating,0);
				return $rating;
			}
		/**
		* MusicTracker::showThumbDetailsLinks()
		*
		* @param array $field_names_arr
		* @return
		*/
		public function showThumbDetailsLinks($field_names_arr = array())
			{
				$return = array();
				$html_url = substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], '?'));
				$html_url = URL($html_url);
				$query_str = '';
				foreach($field_names_arr as $field_name)
					{
						if (is_array($this->fields_arr[$field_name]))
							{
								foreach($this->fields_arr[$field_name] as $sub_field_value)
								$query_str .= "&amp;" . $field_name . "[]=$sub_field_value";
							}
						else if ($this->fields_arr[$field_name] != '')
						$query_str .= "&amp;$field_name=" . $this->fields_arr[$field_name];
					}
				$return['class_thumb_yes'] = $this->fields_arr['thumb'] == 'yes'?'clsSearchActive':'';
				$return['class_thumb_no'] = $this->fields_arr['thumb'] != 'yes'?'clsSearchActive':'';
				$return['url'] = $html_url;
				$return['query_string'] = $query_str;
				return $return;
			}
		/**
		* MusicTracker::showMusicTrackerList()
		*
		* @return
		*/
		public function showMusicTrackerList()
			{
			global $smartyObj;
			$separator = ':&nbsp;';
			$tag = $this->_parse_tags(strtolower($this->fields_arr['tags']));
			$relatedTags = array();
			$return = array();
			$result_arr = array();
			$userid_arr = array();
			$inc = 0;
			$album_id = '';
			$user_ids = '';
			//IC: the value is the same even if we are viewing the mymusic pages, no difference
			$this->CFG['admin']['musics']['num_musics_thumb_view_per_rows'] = ($this->fields_arr['pg'] == 'mymusics')?$this->CFG['admin']['musics']['num_musics_thumb_view_per_rows']:$this->CFG['admin']['musics']['num_musics_thumb_view_per_rows'];
			//IC: this is used when we have detail view and thumb view for the listing page
			$musicsPerRow = ($this->fields_arr['thumb'] == 'yes')?$this->CFG['admin']['musics']['num_musics_thumb_view_per_rows']:$this->CFG['admin']['musics']['num_musics_detail_view_per_rows'];
			$count = 0;
			$found = false;
			$musics_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
			$cssImage_folder = $this->CFG['site']['url'].'/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/';
			$fields_list = array('user_name', 'first_name', 'last_name');
			$musicTags = array();
			//IC: this is no longer user need to check and remove it
			$return['clsMusicListLeft'] = ($this->fields_arr['thumb'] != 'yes')?'clsMusicListLeft':'';
			$return['clsMusicListRight'] = ($this->fields_arr['thumb'] != 'yes')?'clsMusicListRight':'';
			$return['clsMusicListCommon'] = ($this->fields_arr['thumb'] != 'yes')?'clsMusicListCommon':'';
			$return['search_music_tags'] = $this->LANG['common_tag_title'] . $separator;
			$this->player_music_id = array();
			while ($row = $this->fetchResultRecord())
				{
					$result_arr[$inc]['record']=$row;
					$result_arr[$inc]['album_for_sale'] = 'No';
					$result_arr[$inc]['for_sale'] = 'No';
					if($row['album_access_type']=='Private'
						and $row['album_for_sale']=='Yes'
						and $row['album_price']>0)
					{
						$result_arr[$inc]['album_for_sale'] = $row['album_for_sale'];
						 $music_price = strstr($row['album_price'], '.');
	                       if(!$music_price)
	                       {
	                          $row['album_price']=$row['album_price'].'.00';
						   }
						$result_arr[$inc]['music_price'] = $this->LANG['common_album_price'].' <span>'.$this->CFG['currency'].$row['album_price'].'</span>';
					}
					else if($row['for_sale'])
					{
						$result_arr[$inc]['for_sale'] = $row['for_sale'];
						 $music_price = strstr($row['music_price'], '.');
	                       if(!$music_price)
	                       {
	                          $row['music_price']=$row['music_price'].'.00';
						   }
						$result_arr[$inc]['music_price'] = $this->LANG['common_music_price'].' <span>'.$this->CFG['currency'].$row['music_price'].'</span>';
					}
					$result_arr[$inc]['music_id'] = $row['music_id'];
					$result_arr[$inc]['music_album_id'] = $row['music_album_id'];
					$result_arr[$inc]['music_listened_id'] = $row['music_listened_id'];
					$result_arr[$inc]['last_listened'] =  ($row['last_listened'] != '') ? getTimeDiffernceFormat($row['last_listened']) : '';
					$this->player_music_id[$inc] = $row['music_id'];
					$result_arr[$inc]['music_tags'] = $row['music_tags'];
					$result_arr[$inc]['playing_time'] = $this->fmtMusicPlayingTime($row['playing_time']);
					$result_arr[$inc]['music_tags'] = $this->getMusicTags($row['music_tags']);
					$result_arr[$inc]['date_added'] = ($row['date_added'] != '') ? getTimeDiffernceFormat($row['date_added']) : '';
					$result_arr[$inc]['user_id'] = $row['user_id'];
					if (!in_array($row['user_id'], $userid_arr))
					$userid_arr[] = $row['user_id'];
					$view_music_page_arr = array('mymusics', 'usermusiclist');
					if ($this->fields_arr['pg'] == 'myalbummusiclist')
						{
							$result_arr[$inc]['music_album_id'] = $row['music_album_id'];
							$result_arr[$inc]['view_music_link'] = getUrl('viewmusic', '?music_id=' . $row['music_id'] . '&title=' . $this->changeTitle($row['music_title']) . '&album_id=' . $row['music_album_id'], $row['music_id'] . '/' . $this->changeTitle($row['music_title']) . '/?album_id=' . $row['music_album_id'], '', 'music');
						}
					else if (in_array($this->fields_arr['pg'], $view_music_page_arr))
					$result_arr[$inc]['view_music_link'] = getUrl('viewmusic', '?music_id=' . $row['music_id'] . '&title=' . $this->changeTitle($row['music_title']), $row['music_id'] . '/' . $this->changeTitle($row['music_title']) . '/', '', 'music');
					$this->recordsFound = true;
					$result_arr[$inc]['anchor'] = 'dAlt_' . $row['music_id'];
					$return['musicsPerRow'] = $musicsPerRow;
					$return['count'] = $count;
					// # Assigning Variable in array
					if ((is_array($this->fields_arr['music_ids'])) && (in_array($row['music_id'], $this->fields_arr['music_ids'])))
					$result_arr[$inc]['checked'] = 'checked';
					else
					$result_arr[$inc]['checked'] = '';
					//set language value
					foreach($this->LANG_LANGUAGE_ARR as $key=>$value){
						if($row['music_language'] == $key){
							$result_arr[$inc]['music_language_val']	= $value;
							break;
						}else
							$result_arr[$inc]['music_language_val']	= '';
					}
					$result_arr[$inc]['musicupload_url'] = getUrl('musicuploadpopup', '?music_id=' . $row['music_id'], $row['music_id'] . '/', '', 'music');
					$result_arr[$inc]['callAjaxGetCode_url'] = $this->CFG['site']['music_url'] . 'listenMusic.php?music_id=' . $row['music_id'] . '&ajax_page=true&page=getcode';
					//$result_arr[$inc]['image_path_music'] = $this->CFG['site']['music_url'] . 'design/templates/' . $this->CFG['html']['template']['default'] . '/root/images/'. $this->CFG['html']['stylesheet']['screen']['default'] . '/icon-audio.gif';
					$tags = '';
					if ($this->fields_arr['pg'] != 'albumlist')
						{
							$result_arr[$inc]['img_src'] = $row['music_server_url'] . $musics_folder . getMusicImageName($row['music_id'],$row['file_name']) . $this->CFG['admin']['musics']['thumb_name'] . '.' .$row['music_thumb_ext'];
							if (($row['music_thumb_ext'] == ''))
								{
									$result_arr[$inc]['img_src'] = $this->CFG['site']['url'].'music/design/templates/'.
										$this->CFG['html']['template']['default'].'/root/images/'.
											$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_audio_T.jpg';
								}
							$result_arr[$inc]['view_music_link'] = getUrl('viewmusic', '?music_id=' . $row['music_id'] . '&title=' . $this->changeTitle($row['music_title']), $row['music_id'] . '/' . $this->changeTitle($row['music_title']) . '/', '', 'music');
							$result_arr[$inc]['viewmusic_url'] = getUrl('viewmusic', '?music_id='.$row['music_id'].'&title='.$this->changeTitle($row['music_title']), $row['music_id'].'/'.$this->changeTitle($row['music_title']).'/', '', 'music');
							$result_arr[$inc]['viewalbum_url'] = getUrl('viewalbum', '?album_id=' . $row['music_album_id'], $row['music_album_id'] . '/', '', 'music');
							$result_arr[$inc]['view_album_link'] = getUrl('viewalbum', '?album_id=' . $row['music_album_id'], $row['music_album_id'] . '/', '', 'music');
							$result_arr[$inc]['artist_link'] = getUrl('musiclist', '?artist_id=' . $row['music_artist_id'], $row['music_artist_id'] . '/', '', 'music');
							$result_arr[$inc]['category_link'] = getUrl('musiclist', '?cid=' . $row['music_category_id'], $row['music_category_id'] . '/', '', 'music');
							$tags = $this->_parse_tags($row['music_tags']);
							$result_arr[$inc]['rating'] = round($row['rating']);
							$result_arr[$inc]['total_rating'] = $row['rating_count'];
						}
					if ($tags)
						{
							$i = 0;
							foreach($tags as $key => $value)
								{
									if ($this->CFG['admin']['musics']['tags_count_list_page'] == $i)
									break;
									$value = strtolower($value);
									if (!in_array($value, $tag) AND !in_array($value, $relatedTags))
									$relatedTags[] = $value;
									if (!in_array($value, $musicTags))
									$musicTags[] = $value;
									$result_arr[$inc]['tag'][$value] = getUrl('mymusictracker', '?pg=musictracker&tags=' . $value, 'musictracker/?tags=' . $value, '', 'music');
									$i++;
								}
							}else
						{
							$result_arr[$inc]['tag'][] = '';
						}
					$inc++;
				}
			$user_ids = implode(',', $userid_arr);
			$this->getMultiUserDetails($user_ids, $fields_list);
			if ($this->fields_arr['tags'])
			$this->updateMusicTagDetails($musicTags);
			$smartyObj->assign('music_list_result', $result_arr);
			return $return;
			}
		/**
		* MusicTracker::setTableAndColumns()
		*
		* @return
		*/
		public function setTableAndColumns()
			{
				if (!isMember())
					{
						$not_allowed_arr = array('mymusics', 'myfavoritemusics', 'myrecentlyviewedmusic');
						if (in_array($this->fields_arr['pg'], $not_allowed_arr))
						$this->fields_arr['pg'] = 'musictracker';
					}

				$this->setTableNames(array($this->CFG['db']['tbl']['music'].' AS p LEFT JOIN '.$this->CFG['db']['tbl']['music_listened'].' AS ml ON p.music_id = ml.music_id JOIN ' . $this->CFG['db']['tbl']['users'] . ' AS u ON p.user_id = u.user_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'. ' JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = thumb_name_id'. ' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'));
				$this->setReturnColumns(array('p.music_id', 'p.music_album_id', 'p.user_id','u.user_name', 'p.music_ext', 'p.music_tags','p.music_title', 'music_caption', 'p.music_server_url', 'p.thumb_width', 'p.thumb_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'music_tags', 'playing_time', 'music_encoded_status', 'music_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date','music_thumb_ext','file_name','p.music_artist','ma.album_title','mc.music_category_name','p.rating_count','SUM(p.total_plays) as total_plays','p.total_comments','p.total_favorites','mr.artist_name', 'p.music_year_released', 'p.music_language','TIMEDIFF(NOW(), max(ml.last_listened)) AS last_listened','ml.music_owner_id','mr.music_artist_id','mc.music_category_id','ml.music_listened_id','SUM(ml.total_plays) as total_play_count','p.for_sale', 'ma.album_access_type', 'ma.album_for_sale', 'ma.album_price', 'p.music_price'));
				$additional_query = '';
				$extraquery='';
				$artist_extra_query='';
				$album_extra_query='';
				$tags_extra_query='';
				if ($this->fields_arr['musictracker'] && $this->fields_arr['user_id'])
					{
						$additional_query .= ' u.user_id = ml.music_owner_id  AND ml.user_id '.$this->CFG['user']['user_id'].' AND ';
					}
				$this->sql_sort = 'ml.last_listened DESC';
				$this->sql_condition = $additional_query .' u.user_id = ml.music_owner_id AND ml.user_id='.$this->CFG['user']['user_id'].'  AND p.music_status=\'Ok\'' . $this->getAdultQuery('p.', 'music') . ' AND ml.user_id = ' . $this->CFG['user']['user_id'].' AND u.usr_status=\'Ok\' AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.music_access_type = \'Public\'' . $this->getAdditionalQuery() . ')'.'GROUP BY ml.music_id';
			//total_count DESC
			}

		/**
		* MusicTracker::updateMusicTagDetails()
		*
		* @param array $musicTags
		* @return
		*/
		public function updateMusicTagDetails($musicTags = array())
			{
				$tags = $this->fields_arr['tags'];
				$tags = trim($tags);
				$tags = $this->_parse_tags($tags);
				$match = array_intersect($tags, $musicTags);
				$match = array_unique($match);
				if (empty($match))
				return;
				if (count($match) == 1)
					{
						$key= array_keys($match);
						$this->updateSearchCountAndResultForMusicTag($match[$key[0]]);
					}
				else
					{
					for($i = 0; $i < count($match); $i++)
						{
						$tag = $match[$i];
						$this->updateSearchCountForMusicTag($tag);
						}
						}
			}
		/**
		* MusicTracker::updateSearchCountAndResultForMusicTag()
		*
		* @param string $tag
		* @return
		*/
		public function updateSearchCountAndResultForMusicTag($tag = '')
			{
				$sql = 'UPDATE ' . $this->CFG['db']['tbl']['music_tags'] . ' SET search_count = search_count + 1,' . ' result_count = ' . $this->getResultsTotalNum() . ',' . ' last_searched = NOW()' . ' WHERE tag_name=' . $this->dbObj->Param('tag_name');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($tag));
				if (!$rs)
				trigger_db_error($this->dbObj);
				if ($this->dbObj->Affected_Rows() == 0)
					{
						$sql = 'INSERT INTO ' . $this->CFG['db']['tbl']['music_tags'] . ' SET search_count = search_count + 1 ,' . ' result_count = ' . $this->getResultsTotalNum() . ',' . ' last_searched = NOW(),' . ' tag_name=' . $this->dbObj->Param('tag_name');
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($tag));
						if (!$rs)
						trigger_db_error($this->dbObj);
					}
			}
		/**
		* MusicTracker::updateSearchCountForMusicTag()
		*
		* @param string $tag
		* @return
		*/
		public function updateSearchCountForMusicTag($tag = '')
			{
				$sql = 'UPDATE ' . $this->CFG['db']['tbl']['music_tags'] . ' SET search_count = search_count + 1,' . ' result_count = ' . $this->getResultsTotalNum() . ',' . ' last_searched = NOW()' . ' WHERE tag_name=' . $this->dbObj->Param('tag_name');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($tag));
				if (!$rs)
				trigger_db_error($this->dbObj);
				if ($this->dbObj->Affected_Rows() == 0)
					{
						$sql = 'INSERT INTO ' . $this->CFG['db']['tbl']['music_tags'] . ' SET search_count = search_count + 1 ,' . ' result_count = ' . $this->getResultsTotalNum() . ',' . ' last_searched = NOW(),' . ' tag_name=' . $this->dbObj->Param('tag_name');
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($tag));
						if (!$rs)
						trigger_db_error($this->dbObj);
					}
			}

		/**
		* MusicTracker::getCategoryName()
		*
		* @return
		*/
		public function getCategoryName()
			{
				if ($this->fields_arr['sid'])
				$categoryId = $this->fields_arr['sid'];
				else
				$categoryId = $this->fields_arr['cid'];
				$sql = 'SELECT music_category_name FROM ' . $this->CFG['db']['tbl']['music_category'] . ' WHERE music_category_id=' . $this->dbObj->Param('music_category_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($categoryId));
				if (!$rs)
				trigger_db_error($this->dbObj);
				if ($row = $rs->FetchRow())
					return $row['music_category_name'];
				return $this->LANG['unknown_category'];
			}
		/**
		* MusicTracker::getCategoryName()
		*
		* @return
		*/
		public function getArtistName()
			{
				if ($this->fields_arr['artist_id'])
				$artist_id = $this->fields_arr['artist_id'];
				$sql = 'SELECT artist_name FROM ' . $this->CFG['db']['tbl']['music_artist'] . ' WHERE  music_artist_id=' . $this->dbObj->Param('artist_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($artist_id));
				if (!$rs)
				trigger_db_error($this->dbObj);
				if ($row = $rs->FetchRow())
				return wordWrap_mb_Manual($row['artist_name'], $this->CFG['admin']['musics']['music_channel_title_length'], $this->CFG['admin']['musics']['music_channel_title_total_length']);
				return $this->LANG['unknown_category'];
			}

		/**
		* MusicTracker::populateSubCategories()
		*
		* @return
		*/
		public function populateSubCategories()
			{
				global $smartyObj;
				$populateSubCategories_arr = array();
				//Music catagory List order by Priority on / off features
				if($this->CFG['admin']['musics']['music_category_list_priority'])
				$order_by = 'priority';
				else
				$order_by = 'music_category_name';
				$sql = 'SELECT music_category_id, music_category_name, music_category_description,music_category_ext ' . 'FROM ' . $this->CFG['db']['tbl']['music_category'] . ' ' . 'WHERE music_category_status = \'Yes\' ' . 'AND parent_category_id=' . $this->dbObj->Param('parent_category_id'). 'ORDER BY '.$order_by.' ASC ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['cid']));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);
				$usersPerRow = $this->CFG['admin']['musics']['subcategory_list_per_row'];
				$count = 0;
				$found = false;
				$populateSubCategories_arr['row'] = array();
				$inc = 1;
				while ($row = $rs->FetchRow())
					{
						$found = true;
						$populateSubCategories_arr['row'][$inc]['open_tr'] = '';
						if ($count % $usersPerRow == 0)
							{
								$populateSubCategories_arr['row'][$inc]['open_tr'] = '<tr>';
							}
						$populateSubCategories_arr['row'][$inc]['imageSrc'] = $this->CFG['site']['url'] . $this->CFG['admin']['musics']['category_folder'] . $row['music_category_id'] . '.' . $row['music_category_ext'];
						$row['music_category_name'] = wordWrap_mb_Manual($row['music_category_name'], $this->CFG['admin']['musics']['music_channel_title_length'], $this->CFG['admin']['musics']['music_channel_title_total_length']);
						$populateSubCategories_arr['row'][$inc]['record'] = $row;
						$populateSubCategories_arr['row'][$inc]['music_tracker_url'] = getUrl('mymusictracker', '?pg=' . $this->fields_arr['pg'] . '&cid=' . $this->fields_arr['cid'] . '&sid=' . $row['music_category_id'], $this->fields_arr['pg'] . '/?cid=' . $this->fields_arr['cid'] . '&sid=' . $row['music_category_id'], '', 'music');
						$populateSubCategories_arr['row'][$inc]['music_category_name_manual'] = nl2br(stripslashes($row['music_category_name']));
						$count++;
						$populateSubCategories_arr['row'][$inc]['end_tr'] = '';
						if ($count % $usersPerRow == 0)
							{
								$count = 0;
								$populateSubCategories_arr['row'][$inc]['end_tr'] = '</tr>';
							}
						$inc++;
					}
				$smartyObj->assign('populateSubCategories_arr', $populateSubCategories_arr);
			}

		public function getMusicTags($music_tags)
			{
				$tags_arr = explode(' ', $music_tags);
				$getMusicTags_arr = array();
				for($i=0;$i<count($tags_arr);$i++)
					{
					if($i<3)
						{
							if(strlen($tags_arr[$i]) > 5 and strlen($tags_arr[$i]) > 5+3)
							$getMusicTags_arr[$i]['tags_name'] = wordWrap_mb_Manual($tags_arr[$i], 5,5,true);
							else
							$getMusicTags_arr[$i]['tags_name'] = $tags_arr[$i];
							$getMusicTags_arr[$i]['tags_url'] = getUrl('mymusictracker', '?pg=musictracker&tags='.$tags_arr[$i], 'musictracker/?tags='.$tags_arr[$i], '', 'music');
						}
					}
				return $getMusicTags_arr;
			}
		public function chkAdvanceResultFound()
			{
				if($this->advanceSearch)
					{
						return true;
					}
				return false;
			}
		public function populateRatingImagesForAjax($rating, $imagePrefix='')
			{
				$rating_total = $this->CFG['admin']['total_rating'];
				for($i=1;$i<=$rating;$i++)
					{
						?>
						<a onClick="return callAjaxRate('<?php echo $this->CFG['site']['music_url'].'myMusicTracker.php?pg=musictracker'?>', 'selRatingPlaylist')" onMouseOver="ratingMusicMouseOver(<?php echo $i;?>)" onMouseOut="ratingMusicMouseOut(<?php echo $i;?>)"><img id="img<?php echo $i;?>" src="<?php echo $this->CFG['site']['music_url'].'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-audioratehover.gif'; ?>"  title="<?php echo $i;?>" /></a>
						<?php
					}
				for($i=$rating;$i<$rating_total;$i++)
					{
						?>
						<a onClick="return callAjaxRate('<?php echo $this->CFG['site']['music_url'].'myMusicTracker.php?pg=musictracker'?>', 'selRatingPlaylist')" onMouseOver="ratingMusicMouseOver(<?php echo ($i+1);?>)" onMouseOut="ratingMusicMouseOut(<?php echo ($i+1);?>)"><img id="img<?php echo ($i+1);?>" src="<?php echo $this->CFG['site']['music_url'].'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-audiorate.gif'; ?>"  title="<?php echo ($i+1);?>" /></a>
						<?php
					}
			}

		public function getTagsForMusicTrackerList($music_tags)
			{
				// change the function for display the tags with some more...
				global $smartyObj;

				$tags_arr = explode(' ', $music_tags);

				$getMusicTags_arr = array();
				for($i=0;$i<count($tags_arr);$i++)
					{
						if($i<8)
							{
								if(strlen($tags_arr[$i]) > 5 and strlen($tags_arr[$i]) > 5+3)
								$getTagsLink_arr[$i]['title_tag_name'] = $getTagsLink_arr[$i]['wordWrap_mb_ManualWithSpace_tag_name'] = wordWrap_mb_Manual($tags_arr[$i], 5,5,true);
								else
								$getTagsLink_arr[$i]['title_tag_name'] = $getTagsLink_arr[$i]['wordWrap_mb_ManualWithSpace_tag_name'] = $tags_arr[$i];

								$getTagsLink_arr[$i]['tag_url'] = getUrl('musiclist', '?pg=musicnew&tags='.$tags_arr[$i], 'musiclist/?tags='.$tags_arr[$i], '', 'music');
							}
					}
				$smartyObj->assign('getTagsLink_arr', $getTagsLink_arr);
				setTemplateFolder('general/', 'music');
				$smartyObj->display('populateTagsLinks.tpl');
			}
		public function getDescriptionForMusicTrackerList($music_description)
			{
				// change the function for display the caption with some more text
				global $smartyObj;
				$getDescriptionLink_arr = array();
				$description_array = explode(' ', $music_description);

				for($i=0;$i<count($description_array);$i++)
					{
						if($i<15)
							{
								if(strlen($description_array[$i]) > 15 and strlen($description_array[$i]) > 15+3)
								$getDescriptionLink_arr[$i]['title_tag_name'] = $getDescriptionLink_arr[$i]['wordWrap_mb_ManualWithSpace_description_name'] = wordWrap_mb_Manual($description_array[$i], 15,15,true);
								else
								$getDescriptionLink_arr[$i]['title_tag_name'] = $getDescriptionLink_arr[$i]['wordWrap_mb_ManualWithSpace_description_name'] = $description_array[$i];
							}
					}
				$smartyObj->assign('getDescriptionLink_arr', $getDescriptionLink_arr);
			}
	}
// -------------------- Code begins -------------->>>>>//
$MusicTracker = new MusicTracker();
if (!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$MusicTracker->setPageBlockNames(array('my_musics_form', 'delete_confirm_form', 'featured_confirm_form',
									'check_all_item', 'form_show_sub_category', 'musiclist_msg_form_error'));
$MusicTracker->CFG['admin']['musics']['individual_song_play'] = true;
$MusicTracker->LANG_LANGUAGE_ARR = $LANG_LIST_ARR['language'];
$MusicTracker->setFormField('music_id', '');
$MusicTracker->setFormField('playlist_id', '');
$MusicTracker->setFormField('album_id', '');
$MusicTracker->setFormField('thumb', 'yes');
$MusicTracker->setFormField('music_ext', '');
$MusicTracker->setFormField('action', '');
$MusicTracker->setFormField('action_new', '');
$MusicTracker->setFormField('act', '');
$MusicTracker->setFormField('pg', '');
$MusicTracker->setFormField('default', 'Yes');
$MusicTracker->setFormField('cid', '');
$MusicTracker->setFormField('tags', '');
$MusicTracker->setFormField('user_id', '');
$MusicTracker->setFormField('musictracker', '');
$MusicTracker->setFormField('view', '');
/**
* ********** Page Navigation Start ********
*/
$MusicTracker->setFormField('start', '0');
$MusicTracker->setFormField('slno', '1');
$MusicTracker->setFormField('sid', '');
$MusicTracker->setFormField('music_ids', array());
$CFG['music_tbl']['numpg'] = 10;
$MusicTracker->setFormField('numpg', $CFG['music_tbl']['numpg']);
$condition = '';
$MusicTracker->setFormField('advanceFromSubmission', '');
$MusicTracker->setFormField('artist', '');
$MusicTracker->setFormField('music_title', '');
$MusicTracker->setFormField('music_tags', '');
$MusicTracker->setFormField('music_album_name', '');
$MusicTracker->setFormField('rating', '');
$MusicTracker->setFormField('artist_id', '');
$MusicTracker->setFormField('artist_name', '');
$MusicTracker->setFormField('album_id', '');
$MusicTracker->setFormField('tags', '');
$MusicTracker->setFormField('checkbox', array());
$MusicTracker->recordsFound = false;
$MusicTracker->setMinRecordSelectLimit($CFG['data_tbl']['min_record_select_limit']);
$MusicTracker->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$MusicTracker->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$MusicTracker->setTableNames(array());
$MusicTracker->setReturnColumns(array());
/**
* *********** page Navigation stop ************
*/
$MusicTracker->setAllPageBlocksHide();
$MusicTracker->setPageBlockShow('my_musics_form');
$MusicTracker->sanitizeFormInputs($_REQUEST);

//START TO GENERATE THE HIDDEN PLAYER ARRAY FIELDS
$music_fields = array(
	'div_id'               => 'view_playlist',
	'music_player_id'      => 'view_playlist_player',
	'width'  		       => 1,
	'height'               => 1,
	'auto_play'            => 'false',
	'hidden'               => true,
	'playlist_auto_play'   => false,
	'javascript_enabled'   => true,
	'player_ready_enabled' => true
);

$smartyObj->assign('music_fields',$music_fields);
//END TO GENERATE THE HIDDEN PLAYER ARRAY FIELDS

if(isset($_REQUEST['action']))
$MusicTracker->setFormField('action_new', $_REQUEST['action']);
$action_new = $MusicTracker->getFormField('action_new');
$MusicTracker->setFormField('action', $action_new);
if(isset($_GET['titles']))
	{
	$MusicTracker->setFormField('titles', $_GET['titles']);
	$_REQUEST['titles'] = $_GET['titles'];
	}
if($MusicTracker->getFormField('default')== 'Yes' && $MusicTracker->getFormField('pg')== 'musictracker' && $MusicTracker->getFormField('tags') == '' && $MusicTracker->getFormField('artist_id') == '')
	$MusicTracker->setFormField('pg', '');
elseif($MusicTracker->getFormField('default')== 'No')
	$MusicTracker->setFormField('pg', (isset($_GET['pg']) && !empty($_GET['pg']))?$_GET['pg']:$_REQUEST['pg']);
if(!isset($_GET['pg']) && $MusicTracker->getFormField('default')== 'No')
$MusicTracker->setFormField('pg', '');
if(!isMember())
	$MusicTracker->savePlaylistUrl = $MusicTracker->is_not_member_url = getUrl('mymusictracker','?pg=musictracker','musictracker/', 'members','music');
else
$MusicTracker->savePlaylistUrl = $CFG['site']['music_url'].'createPlaylist.php?action=save_playlist&light_window=1';
$MusicTracker->musicmyPlaylistUrl = $CFG['site']['music_url'].'myMusicTracker.php?pg=musictracker';
$mymusic_deletelist_arr['music_tracker_url'] = getUrl('mymusictracker', '?pg='.$MusicTracker->getFormField('pg'), $MusicTracker->getFormField('pg').'/?action=0', '', 'music');
$pgValue = $MusicTracker->getFormField('pg');
$pgValue = !empty($pgValue)?$pgValue:'musictracker';
$start = $MusicTracker->getFormField('start');
if ($MusicTracker->getFormField('act') == 'set_playlist_thumb')
	{
		$music_id = $MusicTracker->getFormField('music_id');
		$MusicTracker->setPlaylistThumbnail($music_id);
	}
if ($MusicTracker->getFormField('act') == 'set_album_thumb')
	{
		$music_id = $MusicTracker->getFormField('music_id');
		$album_id = $MusicTracker->getFormField('album_id');
		$MusicTracker->updateAlbumProfileImage($music_id, $album_id);
	}
$MusicTracker->category_name = '';
if ($MusicTracker->isShowPageBlock('form_show_sub_category'))
	{
		$MusicTracker->populateSubCategories();
		$MusicTracker->category_name = $MusicTracker->getCategoryName();
		$MusicTracker->LANG['musictracker_category_title'] = str_replace('VAR_CATEGORY', $MusicTracker->category_name, $LANG['musictracker_category_title']);
	}
$MusicTracker->LANG['musictracker_title'] = $MusicTracker->getPageTitle();
// generation Detail & Thumb Link
if ($CFG['feature']['rewrite_mode'] != 'normal')
$thum_details_arr = array('album_id', 'cid', 'tags', 'music_id', 'user_id', 'start', 'action');
else
$thum_details_arr = array('album_id', 'cid', 'tags', 'user_id', 'music_id', 'start', 'pg', 'action');
$MusicTracker->showThumbDetailsLinks_arr = $MusicTracker->showThumbDetailsLinks($thum_details_arr);
if ($MusicTracker->isShowPageBlock('msg_form_error'))
	{
		$MusicTracker->msg_form_error['common_error_msg'] = $MusicTracker->getCommonErrorMsg();
	}
if ($MusicTracker->isShowPageBlock('msg_form_success'))
	{
		$MusicTracker->msg_form_success['common_error_msg'] = $MusicTracker->getCommonErrorMsg();
	}
if ($MusicTracker->isShowPageBlock('my_musics_form'))
	{
		/**
		* ***** navigtion continue********
		*/
		$MusicTracker->setTableAndColumns();
		$MusicTracker->buildSelectQuery();
		// $MusicTracker->buildConditionQuery($condition);
		$MusicTracker->buildQuery();
		//$MusicTracker->printQuery();
		$group_query_arr = array('myrecentlyviewedmusic','musicmostviewed');
		if (in_array($MusicTracker->getFormField('pg'), $group_query_arr))
		$MusicTracker->homeExecuteQuery();
		else
		$MusicTracker->executeQuery();
		/**
		* ****** Navigation End *******
		*/
		$MusicTracker->my_musics_form['anchor'] = 'anchor';
		$MusicTracker->isResultsFound = $MusicTracker->isResultsFound();
		if ($CFG['feature']['rewrite_mode'] != 'normal')
		$paging_arr = array('start','album_id', 'cid', 'tags', 'user_id', 'action', 'thumb','artist','music_language','run_length','music_album_name','added_within','advanceFromSubmission','view', 'music_title', 'artist_id', 'titles');
		else
		$paging_arr = array('start','album_id', 'cid', 'tags', 'user_id', 'pg', 'action', 'thumb','artist','music_language','run_length','music_album_name','added_within','advanceFromSubmission','view', 'music_title', 'artist_id', 'titles');
		$smartyObj->assign('paging_arr',$paging_arr);
		if ($MusicTracker->isResultsFound())
			{
				if ($CFG['feature']['rewrite_mode'] != 'normal')
				$paging_arr = array('start','album_id', 'tags', 'user_id', 'thumb','artist','music_album_name','advanceFromSubmission','music_title', 'artist_id');
				else
				$paging_arr = array('start','album_id', 'tags', 'user_id', 'thumb','artist','music_album_name','advanceFromSubmission','music_title', 'artist_id');
				$smartyObj->assign('paging_arr',$paging_arr);
				$smartyObj->assign('smarty_paging_list', $MusicTracker->populatePageLinksPOST($MusicTracker->getFormField('start'), 'seachAdvancedFilter'));
				$MusicTracker->my_musics_form['showMusicTrackerList'] = $MusicTracker->showMusicTrackerList();
				//Initializing Playlist Player Configuaration
				$MusicTracker->populatePlayerWithPlaylistConfiguration();
				$MusicTracker->configXmlcode_url .= 'pg=music';
				$MusicTracker->playlistXmlcode_url .= 'pg=music_0_'.implode(',', $MusicTracker->player_music_id);
				}
	}
//$smartyObj->assign('ratingDetatils', $MusicTracker->populateRatingDetails())?$rating:0;
// include the header file
$MusicTracker->includeHeader();
?>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/JSFCommunicator.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
<script type="text/javascript" language="javascript">
total_musics_to_play = <?php echo count($MusicTracker->player_music_id); ?>;
<?php
foreach($MusicTracker->player_music_id as $music_id_to_play)
{
echo 'total_musics_ids_play_arr.push('.$music_id_to_play.');';
}
?>
</script>
<?php
// include the content of the page
setTemplateFolder('general/', 'music');
$smartyObj->display('myMusicTracker.tpl');
// includ the footer of the page
?>
<script type="text/javascript" language="javascript">
var form_name_array = new Array('seachAdvancedFilter');

function swapImage(id, str)
	{
		start_counter=0;
		start_js_animation=false;
		start_js_image=id.src=str;
	}
var start_js_animation=true;
var start_js_id='';
var start_js_music_id='';
var start_counter=0;
var start_js_image='';
function processImageRepeat()
{
start_counter++;
start_js_image = '<?php echo $CFG['site']['music_url'];

?>musicAnimatedGif.php?music_id='+start_js_music_id+'&start_counter='+start_counter;
if(start_counter > <?php echo $CFG['admin']['musics']['rotating_thumbnail_max_frames'];

?>)
	{
		start_counter=0;

	}
if(start_js_animation)
	{
		start_js_id.src=start_js_image;
		processImage(start_js_id,start_js_music_id);
	}
}
function processImage(id, music_id)
	{
		start_js_animation=true;
		start_js_id=id;
		start_js_music_id=music_id;
		setTimeout('processImageRepeat()', <?php echo ($CFG['admin']['musics']['rotating_thumbnail_js_method_delay_seconds']);

		?>);
		//tTimeout('processImageRepeat()', 200);
	}
function loadUrl(element)
	{
		//set the start value as 0 when click the order by field
		document.seachAdvancedFilter.start.value = '0';
		var defaultVal = "<?php echo getUrl('mymusictracker','pg=musictracker','musictracker/','','music');?>";
		//if(element.value != defaultVal)
		document.getElementById('default').value = 'No';
		document.seachAdvancedFilter.action=element.value;
		document.seachAdvancedFilter.submit();
	}
function popupWindow(url)
	{
		window.open (url, "","status=0,toolbar=0,resizable=1,scrollbars=1");
		return false;
	}
</script>
<?php
$MusicTracker->includeFooter();
?>