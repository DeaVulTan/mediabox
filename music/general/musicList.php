<?php
class MusicList extends MusicHandler
{
    public $slideShowUrl;
    public $advanceSearch;


    /**
     * MusicList::getPageTitle()
     *
     * @return
     */
    public function getPageTitle()
	    {
		    $pg_title = $this->LANG['musiclist_musicnew_title'];

			//If default value is Yes then reset the pg value as null.
		    if($this->getFormField('default')== 'Yes' && $this->fields_arr['pg'] == 'musicnew')
				$this->fields_arr['pg'] = '';

			$categoryTitle = '';
			$tagsTitle     = '';
			$artistTitle   = '';

	        switch ($this->fields_arr['pg'])
				 {
		            case 'mymusics':
		                $pg_title = $this->LANG['musiclist_mymusics_title'];
		                break;
		            case 'myfavoritemusics':
		                $pg_title = $this->LANG['musiclist_myfavoritemusics_title'];
		                break;
		            case 'myrecentlyviewedmusic':
		                $pg_title = $this->LANG['musiclist_myrecentlyviewedmusic_title'];
		                break;
		            case 'featuredmusiclist':
		                $pg_title = $this->LANG['musiclist_featuredmusiclist_title'];
		                break;
		            case 'randommusic':
		            	$pg_title = $this->LANG['musiclist_musicrandom_title'];
		                break;
		            case 'musicnewmale':
		                $pg_title = $this->LANG['musiclist_musicnewmale_title'];
		                break;
		            case 'musicnewfemale':
		                $pg_title = $this->LANG['musiclist_musicnewfemale_title'];
		                break;
		            case 'musictoprated':
		                $pg_title = $this->LANG['musiclist_musictoprated_title'];
		                break;
		            case 'musicrecommended':
		                $pg_title = $this->LANG['musiclist_musicrecommended_title'];
		                break;
		            case 'musicmostviewed':
		                $pg_title = $this->LANG['musiclist_musicmostviewed_title'];
		                break;
		            case 'musicmostdiscussed':
		                $pg_title = $this->LANG['musiclist_musicmostdiscussed_title'];
		                break;
		            case 'musicmostfavorite':
		                $pg_title = $this->LANG['musiclist_musicmostfavorite_title'];
		                break;
		            case 'musicmostrecentlyviewed':
		                $pg_title = $this->LANG['musiclist_musicmostrecentlyviewed_title'];
		                break;
		            case 'usermusiclist':
		                $pg_title = $this->LANG['musiclist_usermusiclist_title'];
		                $name = $this->getUserDetail('user_id', $this->fields_arr['user_id'], 'user_name');
						$name = '<a href="'.getUrl('viewprofile','?user='.$name, $name.'/').'">'.ucfirst($name).$this->LANG['musiclist_usermusiclist_s'].'</a>';
		                $pg_title = str_replace('VAR_USER_NAME', $name, $pg_title);
		                break;
		            case 'myalbummusiclist':
		                $pg_title = $this->LANG['musiclist_albummusiclist_title'];
		                $name = $this->getAlbumName();
		                $pg_title = str_replace('VAR_ALBUM_NAME', $name, $pg_title);
		                break;
		            case 'albummusiclist':
		                $pg_title = $this->LANG['musiclist_myalbummusiclist_title'];
		                $name = $this->getAlbumName();
		                $pg_title = ucfirst(str_replace('VAR_ALBUM_NAME', $name, $pg_title));
		                break;
		            case 'albumlist':
		                $pg_title = ucfirst($this->LANG['musiclist_albumlist_title']);
		                break;
		            case 'myplaylist':
		                $pg_title = $this->LANG['musiclist_playilst'];
		                $name = $this->getPlaylistName();
		                $pg_title = ucfirst(str_replace('VAR_PLAYLIST_NAME', $name, $pg_title));
		                break;
		            case 'musicresponseslist':
		            	$this->music_details=$this->getMusicDetails(array('music_title'),$this->fields_arr['music_id']);
		            	$title = $this->music_details['music_title'];
		            	$title_wrapped = $this->music_details['music_title'];
		            	$link=getUrl('viewmusic','?music_id='.$this->fields_arr['music_id'].'&music_title='.$this->changeTitle($title),$this->fields_arr['music_id'].'/'.$this->changeTitle($title).'/','','music');
		            	$title_text='<a href="'.$link.'">'.$title_wrapped.'</a>';
		            	$this->LANG['musiclist_musicresponselist_title']=str_replace('VAR_MUSIC_TITLE',$title_text,$this->LANG['musiclist_musicresponselist_title']);
		                $pg_title = $this->LANG['musiclist_musicresponselist_title'];
		                break;
		            case 'musicmostlinked':
		                $pg_title = $this->LANG['musiclist_musicmostlinked_title'];
		                break;
		            case 'musicmostresponded':
		                $pg_title = $this->LANG['musiclist_musicmostresponded_title'];
		                break;
				    case 'musictracker':
		                $pg_title = $this->LANG['musiclist_musictracker_title'];
		                break;
		            default:

						if ($this->fields_arr['pg'] == 'musicrecent')
							$pg_title = $this->LANG['header_nav_music_music_new'];
						else
							$pg_title = $this->LANG['musiclist_musicnew_title'];

		                break;
		        }

		  //change the page title if other user music is selected
		  if($this->fields_arr['pg'] != 'usermusiclist' && $this->fields_arr['user_id'] != 0) {
			  $members_title = $this->LANG['musiclist_usermusiclist_title'];
	          $name = $this->getUserDetail('user_id', $this->fields_arr['user_id'], 'user_name');
			  $name = '<a href="'.getUrl('viewprofile','?user='.$name, $name.'/').'">'.ucfirst($name).$this->LANG['musiclist_usermusiclist_s'].'</a>';
	          $members_title = str_replace('VAR_USER_NAME', $name, $members_title);
	          if($this->fields_arr['pg'] == 'musicnew' || $this->fields_arr['pg'] == '')
	          	$pg_title = $members_title;
	          else
			  	$pg_title = $pg_title.' '.$this->LANG['in'].' '.$members_title;
          }

		 //change the page title if my music is selected
		 if ($this->fields_arr['mymusic'] == 'Yes' && $this->fields_arr['pg'] != 'mymusics') {
		 	$pg_title = $pg_title.' '.$this->LANG['in'].' '.$this->LANG['musiclist_mymusics_title'];
		 	if($this->fields_arr['pg'] == 'musicnew' || $this->fields_arr['pg'] == '')
		 		$pg_title = $this->LANG['musiclist_mymusics_title'];
		 }

		 //change the page title if my favorite is selected
		 if ($this->fields_arr['myfavoritemusic'] == 'Yes' && $this->fields_arr['pg'] != 'myfavoritemusics') {
		 	$pg_title = $pg_title.' '.$this->LANG['in'].' '.$this->LANG['musiclist_myfavoritemusics_title'];
		 	if($this->fields_arr['pg'] == 'musicnew' || $this->fields_arr['pg'] == '')
		 		$pg_title = $this->LANG['musiclist_myfavoritemusics_title'];
		 }

		//change the page title if recored display via category, tags or artist.
		if ($this->fields_arr['cid'] || $this->fields_arr['sid'] ){
            $categoryTitle = $this->LANG['musiclist_categorymusic_title'];
            if (!$this->category_name)
                $name = $this->getCategoryName();
            else
                $name = $this->category_name;
            $categoryTitle = str_replace('VAR_CATEGORY_NAME', $name, $categoryTitle);
        }
		if(($this->fields_arr['pg'] || $this->getFormField('default')== 'Yes') && $this->fields_arr['cid']){
			if($this->fields_arr['pg'] == '')
				$pg_title = $categoryTitle;
			else
				$pg_title = $pg_title.' '.$this->LANG['in'].' '.$categoryTitle;
		}

		if ($this->fields_arr['album_id']){
            $albumTitle = $this->LANG['musiclist_album_title'];
            if (!isset($this->album_name))
                $name = $this->getAlbumName();
            else
                $name = $this->album_name;
            $albumTitle = str_replace('VAR_ALBUM_NAME', $name, $albumTitle);
        }
		if(($this->fields_arr['pg'] || $this->getFormField('default')== 'Yes') && $this->fields_arr['album_id']){
			if($this->fields_arr['pg'] == '')
				$pg_title = $albumTitle;
			else
				$pg_title = $pg_title.' '.$this->LANG['in'].' '.$albumTitle;
		}




		if ($this->fields_arr['tags']){
            $tagsTitle = $this->LANG['musiclist_tagsmusic_title'];
            $name = $this->fields_arr['tags'];
            $tagsTitle = str_replace('VAR_TAGS_NAME', $name, $tagsTitle);
        }
		if(($this->fields_arr['pg'] || $this->getFormField('default')== 'Yes')&& $this->fields_arr['tags']){
			if($this->fields_arr['pg'] == '')
				$pg_title = $tagsTitle;
			else
				$pg_title = $pg_title.' '.$tagsTitle;
		}

		if ($this->fields_arr['artist_id']){
            $artistTitle = $this->LANG['musiclist_artistmusic_title'];
			$name=$this->getArtistName();
			$this->fields_arr['artist'] = $name;
			$artistTitle = ucfirst($name).$artistTitle;
        }
        if(($this->fields_arr['pg'] || $this->getFormField('default')== 'Yes')&& $this->fields_arr['artist_id']){
			if($this->fields_arr['pg'] == '')
				$pg_title = $artistTitle;
			else
				$pg_title = $pg_title.' '.$this->LANG['in'].' '.$artistTitle;
		}

        return $pg_title;
    }
	public function getSearchCondition()
		    {

				$search_condition = '';
				if ($this->fields_arr['action'] == 'title')
					{
						$search_condition .= '';
					}
				if ($this->fields_arr['action'] == 'today' && $this->fields_arr['pg']=='musictoprated')
					{
					  	$search_condition .= ' AND DATE_FORMAT(vv.view_date,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
					}
				if ($this->fields_arr['action'] == 'yesterday')
					{
						$search_condition .= ' AND v.flagged_status != \'Yes\'';
					}
				if ($this->fields_arr['action'] == 'thisweek')
					{
						$search_condition .= ' AND v.flagged_status = \'Yes\'';
					}
				if ($this->fields_arr['action'] == 'thismonth')
					{
						$search_condition .= ' AND v.music_category_id = \''.addslashes($this->fields_arr['srch_categories']).'\'';
					}
				if ($this->fields_arr['action'] == 'thisyear')
					{
						$search_condition .= ' AND v.music_featured = \''.addslashes($this->fields_arr['srch_feature']).'\'';
					}
			 return $search_condition;
		    }

	public function populateRatingDetails($rating)
		{
			$rating = round($rating,0);
			return $rating;
		}
    /**
     * MusicList::showThumbDetailsLinks()
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
     * MusicList::showMusicList()
     *
     * @return
     */
    public function showMusicList()
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
	        $this->allow_quick_mixs = (isLoggedIn() and $this->CFG['admin']['musics']['allow_quick_mixs'])?true:false;
	        $this->player_music_id = array();
	        while ($row = $this->fetchResultRecord())
			   {
		        	$result_arr[$inc]['record']=$row;
					$result_arr[$inc]['add_quickmix'] = false;
		            if ($this->allow_quick_mixs)
						 {
			                $result_arr[$inc]['add_quickmix'] = true;
			                $result_arr[$inc]['is_quickmix_added'] = false;
			                if (rayzzMusicQuickMix($row['music_id']))
			                    $result_arr[$inc]['is_quickmix_added'] = true;
			            }


			     //IC: we now no longer provide this menu as musicnewmale and musicnewfemale
	            $need_profile_icon_arr = array('musicnewmale', 'musicnewfemale');
	            if (in_array($this->fields_arr['pg'], $need_profile_icon_arr))
					{
		                $this->UserDetails[$row['user_id']]['first_name'] = $row['first_name'];
		                $this->UserDetails[$row['user_id']]['last_name'] = $row['last_name'];
		                $this->UserDetails[$row['user_id']]['user_name'] = $row['user_name'];

		                if (!$this->getMusicDetails(array('music_id', 'TIMEDIFF(NOW(), date_added) as date_added', 'user_id', '(rating_total/rating_count) as rating', 'total_views', 'music_server_url', 'music_ext', 'music_title', 'thumb_width', 'thumb_height', 'music_tags'), $row['icon_id'])) {
		                    $this->isResultsFound = false;
		                    continue;
		                } else {
		                    $this->isResultsFound = true;
		                }
		                $row = array_merge($row, $this->music_details);
		            }

				$result_arr[$inc]['album_for_sale'] = 'No';
				$result_arr[$inc]['album_access_type'] = $row['album_access_type'];
				$album_price = strstr($row['album_price'], '.');
               	if(!$album_price)
               	{
                  $result_arr[$inc]['album_price']=$row['album_price'].'.00';
			   	}
			   	else
			   	{
                  $result_arr[$inc]['album_price']=$row['album_price'];
				}
				if($result_arr[$inc]['album_access_type']=='Private' and $row['album_for_sale']=='Yes')
				{
					$result_arr[$inc]['for_sale'] = 'No';
					$result_arr[$inc]['album_for_sale'] = 'Yes';
				}
				else
					$result_arr[$inc]['for_sale'] = $row['for_sale'];

	            $result_arr[$inc]['music_id'] = $row['music_id'];
	            if($row['music_price']>0)
	            {
		            $music_price = strstr($row['music_price'], '.');
	               	if(!$music_price)
	               	{
	                  $result_arr[$inc]['music_price']=$row['music_price'].'.00';
				   	}
				   	else
				   	{
				   	 	$result_arr[$inc]['music_price']=$row['music_price'];
				   	}
			   	}
			   	else
			   	{
					$result_arr[$inc]['music_price']='';
				}
				$result_arr[$inc]['music_category_id'] = $row['music_category_id'];
	            $this->player_music_id[$inc] = $row['music_id'];
				$result_arr[$inc]['music_tags'] = $row['music_tags'];
	            $result_arr[$inc]['playing_time'] = $this->fmtMusicPlayingTime($row['playing_time']);
				$result_arr[$inc]['music_tags'] = $this->getMusicTags($row['music_tags']);
	            $result_arr[$inc]['date_added'] = ($row['date_added'] != '') ? getTimeDiffernceFormat($row['date_added']) : '';
	            $result_arr[$inc]['user_id'] = $row['user_id'];
	            $result_arr[$inc]['music_album_id'] = $row['music_album_id'];
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
				$result_arr[$inc]['anchor_id'] = 'dAlt_' . $row['music_id'];
				//$result_arr[$inc]['delete_music_title']=$row['music_title'];
				$deleteMusicTagsTitle = $this->LANG['musiclist_delete_msg_confirmation'];
				$deleteMusicName = $row['music_title'];
				$deleteMusicTagsTitle = str_replace('VAR_MUSIC_NAME', $deleteMusicName, $deleteMusicTagsTitle);
				$result_arr[$inc]['delete_music_title'] = $deleteMusicTagsTitle;
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
	            $result_arr[$inc]['manage_lyrics_url'] = getUrl('managelyrics', '?music_id='.$row['music_id'], $row['music_id'].'/', '', 'music');
				//$result_arr[$inc]['image_path_music'] = $this->CFG['site']['music_url'] . 'design/templates/' . $this->CFG['html']['template']['default'] . '/root/images/'. $this->CFG['html']['stylesheet']['screen']['default'] . '/icon-audio.gif';
	            if ($this->fields_arr['pg'] == 'myalbummusiclist')
	                $result_arr[$inc]['setProfileImageUrl'] = $this->CFG['site']['music_url'] . 'musicList.php?music_id=' . $row['music_id'] . '&album_id=' . $row['music_album_id'] . '&ajax_page=true&act=set_album_thumb';
	            if ($this->fields_arr['pg'] == 'myplylist')
	                $result_arr[$inc]['deletePlaylistUrl'] = $this->CFG['site']['music_url'] . 'listenMusic.php?music_id=' . $row['music_id'] . '&playlist_id=' . $this->fields_arr['playlist_id'] . '&ajax_page=true&page=removePlaylistMusic';
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
		                $result_arr[$inc]['music_title'] = $row['music_title'];
		                $result_arr[$inc]['total_views'] = $row['total_views'];
		                $search_word= '';
		                if($this->fields_arr['music_title']!='')
							$search_word=$this->fields_arr['music_title'];
						elseif($this->fields_arr['tags']!='')
							$search_word=$this->fields_arr['tags'];

						$result_arr[$inc]['album_title'] = $row['album_title'];
		                $result_arr[$inc]['music_title_word_wrap'] = highlightWords($row['music_title'],$search_word);
		               	$result_arr[$inc]['viewmusic_url'] = getUrl('viewmusic', '?music_id='.$row['music_id'].'&title='.$this->changeTitle($row['music_title']), $row['music_id'].'/'.$this->changeTitle($row['music_title']).'/', '', 'music');
						$result_arr[$inc]['viewalbum_url'] = getUrl('viewalbum', '?album_id=' . $row['music_album_id'], $row['music_album_id'] . '/', '', 'music');
					    $result_arr[$inc]['album_title_word_wrap'] = highlightWords($row['album_title'],$this->fields_arr['music_album_name']);
		                $result_arr[$inc]['view_album_link'] = getUrl('viewalbum', '?album_id='.$row['music_album_id'].'&title='.$this->changeTitle($row['album_title']),$row['music_album_id'].'/'.$this->changeTitle($row['album_title']).'/', '', 'music');
						$result_arr[$inc]['music_category_link'] = getUrl('musiclist', '?pg=musicnew&cid=' . $row['music_category_id'], 'musicnew/?cid=' . $row['music_category_id'], '', 'music');
						$result_arr[$inc]['music_category_name_word_wrap'] = $row['music_category_name'];
						$result_arr[$inc]['music_description_word_wrap']=$row['music_caption'];
						$tags = $this->_parse_tags($row['music_tags']);
		                $result_arr[$inc]['rating'] = round($row['rating']);
		                $result_arr[$inc]['total_rating'] = $row['rating_count'];



		            }
	            if ($this->fields_arr['pg'] == 'albumlist')
					{
						$result_arr[$inc]['add_quicklink'] = false;
		                $result_arr[$inc]['onmouseOverText'] = '';
		                $result_arr[$inc]['music_album_id'] = $row['music_album_id'];
		                $album_id .= $row['music_album_id'] . ',';
		                if ($row['music_id'])
							{
			                    $result_arr[$inc]['img_src'] = $row['music_server_url'] . $musics_folder . getMusicImageName($row['music_id'],$row['file_name']) . $this->CFG['admin']['musics']['thumb_name'] . '.' .$row['music_thumb_ext'];
			                }
							else
								{
				                    $result_arr[$inc]['img_src'] = '';
				                }
		                $result_arr[$inc]['music_title'] = $row['album_title'];
		                $result_arr[$inc]['music_title_word_wrap'] = $row['album_title'];
		                $result_arr[$inc]['view_music_link'] = getUrl('musiclist', '?pg=albummusiclist&album_id=' . $row['music_album_id'], 'albummusiclist/?album_id=' . $row['music_album_id'], '', 'music');



		            }
	            switch ($this->fields_arr['pg'])
					{
		                case 'myalbummusicist':
		                    if (!$this->isMe($this->ALBUM_USER_ID))
		                        break;
		                    break;
		                case 'musicmostdiscussed':
		                    $result_arr[$inc]['total_comments'] = $row['total_comments'];
		                    break;
		                case 'musicmostfavorite':
		                    $result_arr[$inc]['total_favorite'] = $row['total_favorite'];
		                    break;
		                case 'featuredmusiclist':
		                    $result_arr[$inc]['total_featured'] = $row['total_featured'];
		                    break;
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
			                    $result_arr[$inc]['tag'][$value] = getUrl('musiclist', '?pg=musicnew&tags=' . $value, 'musicnew/?tags=' . $value, '', 'music');
			                    $i++;
			                }
		            }else{
			            $result_arr[$inc]['tag'][] = '';
		            }
				$result_arr[$inc]['viewmusic_rating_member_url'] = getUrl('viewmusic', '?music_id=' . $row['music_id'] . '&title=' . $this->changeTitle($row['music_title']), $row['music_id'] . '/' . $this->changeTitle($row['music_title']) . '/', 'members', 'music');
	            $inc++;
	        }

	        if ($this->fields_arr['pg'] == 'albumlist')
				{
		            $this->getMusicCountForAlbum($album_id);
		        }
	        $user_ids = implode(',', $userid_arr);
	        $this->getMultiUserDetails($user_ids, $fields_list);
	        if ($this->fields_arr['tags'])
	            $this->updateMusicTagDetails($musicTags);
			$smartyObj->assign('music_list_result', $result_arr);
	        return $return;
	    }

	public function myMusicCondition(){

		if($this->fields_arr['user_id'] != '0')
			$userCondition = ' p.user_id = '.$this->fields_arr['user_id'].' ';
		elseif($this->fields_arr['mymusic'] != 'No')
			$userCondition = ' p.user_id = '.$this->CFG['user']['user_id'].' ';
		else
			$userCondition = 'p.user_id = '.  $this->CFG['user']['user_id'] . ' OR p.music_access_type = \'Public\'' . $this->getAdditionalQuery('p.');
		return $userCondition;

	}
    /**
     * MusicList::setTableAndColumns()
     *
     * @return
     */
    public function setTableAndColumns()
    {
        if (!isMember()){
            $not_allowed_arr = array('mymusics', 'myfavoritemusics', 'myrecentlyviewedmusic');
            if (in_array($this->fields_arr['pg'], $not_allowed_arr))
                $this->fields_arr['pg'] = 'musicnew';
        }
		$search_condition = $this->getSearchCondition();
       switch ($this->fields_arr['pg']){
			case 'pending':
				$this->setTableNames(array($this->CFG['db']['tbl']['music'].' AS p JOIN ' . $this->CFG['db']['tbl']['users'] . ' AS u ON p.user_id = u.user_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'. ' JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = thumb_name_id  JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'));
				$this->setReturnColumns(array('p.music_id', 'p.music_album_id', 'p.music_ext','p.music_title', 'p.music_caption', 'p.music_server_url', 'p.thumb_width', 'p.thumb_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.user_id','u.user_name', 'p.music_encoded_status', 'p.music_status', '(p.rating_total/p.rating_count) as rating', 'p.music_thumb_ext', 'p.music_tags','file_name','playing_time','p.music_artist','p.rating_count', 'p.total_views', 'p.total_plays','p.total_comments','p.total_favorites','mc.music_category_name','ma.album_title', 'p.music_year_released', 'p.music_language','p.music_category_id', 'p.allow_ratings', 'p.music_price', 'p.for_sale','ma.album_for_sale','ma.album_price','ma.album_access_type'));
				$this->sql_condition = 'p.user_id=\'' . $this->CFG['user']['user_id'] . '\' AND u.usr_status=\'Ok\' AND step_status=\'Step1\'';
				$this->sql_sort = 'p.music_id DESC';
			break;
			case 'mymusics':
				$this->setTableNames(array($this->CFG['db']['tbl']['music'].' AS p JOIN ' . $this->CFG['db']['tbl']['users'] . ' AS u ON p.user_id = u.user_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'. ' JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = thumb_name_id'. ' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'));
				$this->setReturnColumns(array('p.music_id', 'p.music_album_id', 'p.music_ext','p.music_title', 'p.music_caption', 'p.music_server_url', 'p.thumb_width', 'p.thumb_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.user_id','u.user_name', '(p.rating_total/p.rating_count) as rating', 'p.total_views', 'p.music_tags', 'p.music_encoded_status', 'p.music_status', 'TIMEDIFF(NOW(), p.last_view_date) as last_view_date', 'p.music_thumb_ext', 'p.music_tags','file_name','playing_time','p.music_artist','ma.album_title','mc.music_category_name','p.rating_count','p.total_plays','p.total_comments','p.total_favorites', 'p.music_year_released', 'p.music_language','p.music_category_id', 'p.allow_ratings', 'p.music_price', 'p.for_sale','ma.album_for_sale','ma.album_price','ma.album_access_type'));
				$artist_extra_query='';
				$album_extra_query='';
				$tags_extra_query='';
					if ($this->fields_arr['view']){
						if($this->fields_arr['view']=='Album')
							$this->sql_sort='ma.album_title ASC';
						else if($this->fields_arr['view']=='Artist')
							$this->sql_sort='mr.artist_name ASC ';
						else if($this->fields_arr['view']=='Title')
							$this->sql_sort='p.music_title ASC ';
						else
							$this->sql_sort='p.music_id ASC ';
				    }else
					  	$this->sql_sort = 'p.date_added DESC';
					if ($this->fields_arr['artist_id'])
						{
							$artist_extra_query .= '(FIND_IN_SET('.addslashes($this->fields_arr['artist_id']).',p.music_artist)) AND ';
						}
					if ($this->fields_arr['album_id'])
						{
							$album_extra_query .= '(ma.music_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
						}
					if ($this->fields_arr['tags'])
						{
						  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_caption', '').') AND ';
						}
					$this->sql_condition = $artist_extra_query.$album_extra_query.$tags_extra_query. 'p.user_id=\'' . $this->CFG['user']['user_id'] . '\' AND p.music_status=\'Ok\' AND u.usr_status=\'Ok\'' . $this->advancedFilters().$this->searchTitleFilters();
			break;
			case 'myfavoritemusics':
				$this->setTableNames(array($this->CFG['db']['tbl']['music_favorite'] . ' AS f LEFT JOIN ' . $this->CFG['db']['tbl']['music'] . ' AS p ON f.music_id=p.music_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'.' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'. ' JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = p.thumb_name_id'.', '.$this->CFG['db']['tbl']['users'] . ' AS u'));
				$this->setReturnColumns(array('file_name','p.music_id', 'p.music_album_id','p.user_id','u.user_name' ,'p.music_ext','p.music_access_type', 'p.relation_id', 'p.music_title', 'music_caption', 'p.music_server_url', 'p.thumb_width', 'p.thumb_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'music_tags', 'playing_time', 'music_encoded_status', 'music_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date','music_thumb_ext', 'p.music_tags','p.music_artist','ma.album_title','mc.music_category_name','p.rating_count','p.total_plays','p.total_comments','p.total_favorites', 'p.music_year_released', 'p.music_language','p.music_category_id', 'p.allow_ratings', 'p.music_price', 'p.for_sale','ma.album_for_sale','ma.album_price','ma.album_access_type'));
				$artist_extra_query='';
				$album_extra_query='';
				$tags_extra_query='';
					if ($this->fields_arr['view'])
						{
							if($this->fields_arr['view']=='Album')
								$this->sql_sort='ma.album_title ASC';
							else if($this->fields_arr['view']=='Artist')
								$this->sql_sort='mr.artist_name ASC ';
							else if($this->fields_arr['view']=='Title')
								$this->sql_sort='p.music_title ASC ';
							else
								$this->sql_sort='p.music_id ASC ';
						}
					else
						{
							$this->sql_sort = 'music_favorite_id DESC';
						}
					if ($this->fields_arr['artist_id'])
						{
							$artist_extra_query .= '(FIND_IN_SET('.addslashes($this->fields_arr['artist_id']).',p.music_artist)) AND ';
						}
					if ($this->fields_arr['album_id'])
						{
							$album_extra_query .= '(ma.music_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
						}
					if ($this->fields_arr['tags'])
						{
						  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_caption', '').') AND ';
						}
					$this->sql_condition = $artist_extra_query.$album_extra_query.$tags_extra_query. 'f.user_id=' . $this->CFG['user']['user_id'] . $this->getAdultQuery('p.', 'music') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND p.music_status=\'Ok\' ' . $this->advancedFilters().$this->searchTitleFilters();
			break;
			case 'myrecentlyviewedmusic':
				$this->setTableNames(array($this->CFG['db']['tbl']['music_viewed'] . ' AS pv LEFT JOIN ' . $this->CFG['db']['tbl']['music'] . ' AS p ON pv.music_id=p.music_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'.' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'.' JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = thumb_name_id'.', '.$this->CFG['db']['tbl']['users'] . ' AS u '));
				$this->setReturnColumns(array('p.music_id', 'p.music_album_id', 'p.user_id','u.user_name', 'p.music_ext','p.music_access_type', 'p.relation_id', 'p.music_title', 'music_caption', 'p.music_server_url', 'p.thumb_width', 'p.thumb_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'music_tags', 'playing_time', 'music_encoded_status', 'music_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date','music_thumb_ext', 'p.music_tags','file_name','p.music_artist','ma.album_title','mc.music_category_name','p.rating_count','p.total_plays','p.total_comments','p.total_favorites', 'p.music_year_released', 'p.music_language','p.music_category_id', 'p.allow_ratings', 'p.music_price', 'p.for_sale','ma.album_for_sale','ma.album_price','ma.album_access_type'));
				$artist_extra_query='';
				$album_extra_query='';
				$tags_extra_query='';
						if ($this->fields_arr['view'])
							{
								if($this->fields_arr['view']=='Album')
									$this->sql_sort='ma.album_title ASC';
								else if($this->fields_arr['view']=='Artist')
									$this->sql_sort='mr.artist_name ASC ';
								else if($this->fields_arr['view']=='Title')
									$this->sql_sort='p.music_title ASC ';
								else
									$this->sql_sort='p.music_id ASC ';
				            }
						else
							{
								$this->sql_sort = 'music_viewed_id DESC';
							}
						if ($this->fields_arr['artist_id'])
							{
								$artist_extra_query .= '(FIND_IN_SET('.addslashes($this->fields_arr['artist_id']).',p.music_artist)) AND ';
							}
						if ($this->fields_arr['album_id'])
							{
								$album_extra_query .= '(ma.music_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
							}
						if ($this->fields_arr['tags'])
							{
							  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_caption', '').') AND ';
							}
					$this->sql_condition = $artist_extra_query.$album_extra_query.$tags_extra_query. 'pv.user_id=' . $this->CFG['user']['user_id'] . $this->getAdultQuery('p.', 'music') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND p.music_status=\'Ok\' AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.music_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ') ' . $this->advancedFilters() .$this->searchTitleFilters(). ' GROUP BY pv.music_id';
			break;
			case 'featuredmusiclist':
				if($this->fields_arr['myfavoritemusic'] == 'No')
					$this->setTableNames(array($this->CFG['db']['tbl']['music_featured'] . ' AS f LEFT JOIN ' . $this->CFG['db']['tbl']['music'] . ' AS p ON f.music_id=p.music_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'. ' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'.', '.$this->CFG['db']['tbl']['users'] . ' AS u '. ' , '.$this->CFG['db']['tbl']['music_files_settings'].' AS vfs'));
				else
					$this->setTableNames(array($this->CFG['db']['tbl']['music_featured'] . ' AS f LEFT JOIN ' . $this->CFG['db']['tbl']['music'] . ' AS p ON f.music_id=p.music_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'. ' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_favorite'].' AS pf ON pf.music_id=p.music_id JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'.', '.$this->CFG['db']['tbl']['users'] . ' AS u '. ' , '.$this->CFG['db']['tbl']['music_files_settings'].' AS vfs'));

				$this->setReturnColumns(array('p.music_id', 'p.music_album_id', 'p.user_id','u.user_name', 'p.music_ext','p.music_access_type', 'p.relation_id', 'p.music_title', 'music_caption', 'p.music_server_url', 'p.thumb_width', 'p.thumb_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'music_tags', 'playing_time', 'music_encoded_status', 'music_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date',  'music_thumb_ext', 'count(music_featured_id) as total_featured', 'p.music_tags','file_name','p.music_artist','ma.album_title','mc.music_category_name','p.rating_count','p.total_plays','p.total_comments','p.total_favorites', 'p.music_year_released', 'p.music_language','p.music_category_id', 'p.allow_ratings', 'p.music_price', 'p.for_sale','ma.album_for_sale','ma.album_price','ma.album_access_type'));
				$artist_extra_query='';
				$album_extra_query='';
				$tags_extra_query='';
				if ($this->fields_arr['view']){
					if($this->fields_arr['view']=='Album')
						$this->sql_sort='ma.album_title ASC';
					else if($this->fields_arr['view']=='Artist')
						$this->sql_sort='mr.artist_name ASC ';
					else if($this->fields_arr['view']=='Title')
						$this->sql_sort='p.music_title ASC ';
					else
						$this->sql_sort='p.music_id ASC ';
				}else{
					$this->sql_sort = 'music_featured_id DESC';
				}
				if ($this->fields_arr['artist_id']){
					$artist_extra_query .= '(FIND_IN_SET('.addslashes($this->fields_arr['artist_id']).',p.music_artist)) AND ';
				}
				if ($this->fields_arr['album_id']){
					$album_extra_query .= '(ma.music_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
				}
				if ($this->fields_arr['tags']){
				 	$tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_caption', '').') AND ';
				}
				if($this->fields_arr['myfavoritemusic'] == 'No')
					$this->sql_condition =$artist_extra_query.$album_extra_query.$tags_extra_query.  ' p.music_status=\'Ok\' AND p.thumb_name_id = music_file_id ' . $this->getAdultQuery('p.', 'music') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND ( ' . $this->myMusicCondition() . ' ) ' . $this->advancedFilters() .$this->searchTitleFilters(). ' GROUP BY f.music_id';
				else
					$this->sql_condition =$artist_extra_query.$album_extra_query.$tags_extra_query.  ' pf.user_id=' . $this->CFG['user']['user_id'] .' AND p.music_status=\'Ok\' AND p.thumb_name_id = music_file_id ' . $this->getAdultQuery('p.', 'music') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' ' . $this->advancedFilters() .$this->searchTitleFilters(). ' GROUP BY f.music_id';
			break;
			case 'randommusic':
				$this->setTableNames(array($this->CFG['db']['tbl']['music'].' AS p JOIN ' . $this->CFG['db']['tbl']['users'] . ' AS u ON p.user_id = u.user_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'. ' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'. ' JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = thumb_name_id'));
				$this->setReturnColumns(array('p.music_id', 'p.music_album_id', 'p.user_id','u.user_name', 'p.music_ext','p.music_access_type', 'p.relation_id', 'p.music_title', 'music_caption', 'p.music_server_url', 'p.thumb_width', 'p.thumb_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'p.music_tags', 'playing_time', 'p.music_encoded_status', 'p.music_status', 'TIMEDIFF(NOW(), p.last_view_date) as last_view_date',  'p.music_thumb_ext', 'p.music_tags','file_name','p.music_artist','ma.album_title','mc.music_category_name','p.rating_count','p.total_plays','p.total_comments','p.total_favorites', 'p.music_year_released', 'p.music_language','p.music_category_id', 'p.allow_ratings', 'p.music_price', 'p.for_sale','ma.album_for_sale','ma.album_price','ma.album_access_type'));
				$artist_extra_query='';
				$album_extra_query='';
				$tags_extra_query='';
					if ($this->fields_arr['view'])
						{
							if($this->fields_arr['view']=='Album')
								$this->sql_sort='ma.album_title ASC';
							else if($this->fields_arr['view']=='Artist')
								$this->sql_sort='mr.artist_name ASC ';
							else if($this->fields_arr['view']=='Title')
								$this->sql_sort='p.music_title ASC ';
							else
								$this->sql_sort='p.music_id ASC ';
						}
					else
							{
								$this->sql_sort = getRandomFieldOfMusicTable();
							}
					if ($this->fields_arr['artist_id'])
						{
							$artist_extra_query .= '(FIND_IN_SET('.addslashes($this->fields_arr['artist_id']).',p.music_artist)) AND ';
						}
					if ($this->fields_arr['album_id'])
						{
							$album_extra_query .= '(ma.music_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
						}
					if ($this->fields_arr['tags'])
						{
						  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_caption', '').') AND ';
						}
					$this->sql_condition = $artist_extra_query.$album_extra_query.$tags_extra_query. 'p.music_status=\'Ok\'' . $this->getAdultQuery('p.', 'music') . ' AND u.usr_status=\'Ok\'  AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.music_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ')' . $this->advancedFilters().$this->searchTitleFilters();

			break;
			case 'musictoprated':
				if($this->fields_arr['myfavoritemusic'] == 'No')
					$this->setTableNames(array($this->CFG['db']['tbl']['music'].' AS p JOIN ' . $this->CFG['db']['tbl']['users'] . ' AS u ON p.user_id = u.user_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'. ' JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = thumb_name_id'. ' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'));
				else
					$this->setTableNames(array($this->CFG['db']['tbl']['music_favorite'] . ' AS f LEFT JOIN ' .$this->CFG['db']['tbl']['music'] . ' AS p ON f.music_id=p.music_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'.' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'. ' JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = p.thumb_name_id'.', '.$this->CFG['db']['tbl']['users'] . ' AS u '));

				$this->setReturnColumns(array('p.music_id', 'p.music_album_id', 'p.user_id', 'u.user_name','p.music_ext','p.music_access_type', 'p.relation_id', 'p.music_title', 'p.music_caption', 'p.music_server_url', 'p.thumb_width', 'p.thumb_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'p.music_tags', 'p.playing_time', 'p.music_encoded_status', 'p.music_status', 'TIMEDIFF(NOW(), p.last_view_date) as last_view_date', 'p.music_thumb_ext', 'p.music_tags','file_name','p.music_artist','ma.album_title','mc.music_category_name','p.rating_count','p.total_plays','p.total_comments','p.total_favorites', 'p.music_year_released', 'p.music_language','p.music_category_id', 'p.allow_ratings', 'p.music_price', 'p.for_sale','ma.album_for_sale','ma.album_price','ma.album_access_type'));
				$additional_query = '';
				$artist_extra_query='';
				$album_extra_query='';
				$tags_extra_query='';
				if ($this->fields_arr['cid'])
					{
					$additional_query .= '(p.music_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';
						if ($this->fields_arr['sid'])
							$additional_query .= '(p.music_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
					}

				if ($this->fields_arr['view'])
						{
							if($this->fields_arr['view']=='Album')
								$this->sql_sort='ma.album_title ASC';
							else if($this->fields_arr['view']=='Artist')
								$this->sql_sort='mr.artist_name ASC ';
							else if($this->fields_arr['view']=='Title')
								$this->sql_sort='p.music_title ASC ';
							else
								$this->sql_sort='p.music_id ASC ';
						}
				else
					{
						$this->sql_sort = 'rating DESC';
					}
				if ($this->fields_arr['artist_id'])
					{
						$artist_extra_query .= '(FIND_IN_SET('.addslashes($this->fields_arr['artist_id']).',p.music_artist)) AND ';
					}
				if ($this->fields_arr['album_id'])
					{
						$album_extra_query .= '(ma.music_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
					}
				if ($this->fields_arr['tags'])
					{
					  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_caption', '').') AND ';
					}
				if($this->fields_arr['myfavoritemusic'] == 'No')
					$this->sql_condition = $additional_query .$artist_extra_query.$album_extra_query.$tags_extra_query.  'p.music_status=\'Ok\'' . $this->getAdultQuery('p.', 'music') . ' AND u.usr_status=\'Ok\' AND ( ' . $this->myMusicCondition() . ') AND p.rating_total>0 AND p.allow_ratings=\'Yes\'' . $this->advancedFilters().$search_condition.$this->searchTitleFilters();
				else
					$this->sql_condition = $additional_query .$artist_extra_query.$album_extra_query.$tags_extra_query. 'f.user_id=' . $this->CFG['user']['user_id'] . $this->getAdultQuery('p.', 'music') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND p.music_status=\'Ok\' AND p.rating_total>0 AND p.allow_ratings=\'Yes\'' . $this->advancedFilters().$search_condition.$this->searchTitleFilters();
			break;
			case 'musicmostviewed':
				if($this->fields_arr['myfavoritemusic'] == 'No')
					$this->setTableNames(array($this->CFG['db']['tbl']['music_viewed'] . ' AS vp LEFT JOIN ' . $this->CFG['db']['tbl']['music'] . ' AS p ON vp.music_id=p.music_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'.' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'.','.$this->CFG['db']['tbl']['users'] . ' AS u '. ','.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS'));
				else
					$this->setTableNames(array($this->CFG['db']['tbl']['music_favorite'] . ' AS f LEFT JOIN ' .$this->CFG['db']['tbl']['music'] . ' AS p ON f.music_id=p.music_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_viewed'] . ' AS vp ON vp.music_id=p.music_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'.' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'. ' , '.$this->CFG['db']['tbl']['users'] . ' AS u '.','.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS'));

				$this->setReturnColumns(array('p.music_id', 'p.music_album_id', 'p.user_id','u.user_name', 'p.music_ext','p.music_access_type', 'p.relation_id', 'p.music_title', 'music_caption', 'p.music_server_url', 'p.thumb_width', 'p.thumb_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'music_tags', 'playing_time', 'music_encoded_status', 'music_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date', 'music_thumb_ext', 'SUM(vp.total_views) as sum_total_views', 'vp.total_views as individual_total_views', 'p.music_tags','file_name','p.music_artist','ma.album_title','mc.music_category_name','p.rating_count','p.total_plays','p.total_comments','p.total_favorites', 'p.music_year_released', 'p.music_language','p.music_category_id', 'p.allow_ratings', 'p.music_price', 'p.for_sale','ma.album_for_sale','ma.album_price','ma.album_access_type'));
				$additional_query = '';
				$artist_extra_query='';
				$album_extra_query='';
				$tags_extra_query='';
					if ($this->fields_arr['cid']){
						$additional_query .= '(p.music_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';
						if ($this->fields_arr['sid'])
							$additional_query .= '(p.music_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
					}

				if ($this->fields_arr['view']){
					if($this->fields_arr['view']=='Album')
						$this->sql_sort='ma.album_title ASC';
					else if($this->fields_arr['view']=='Artist')
						$this->sql_sort='mr.artist_name ASC ';
					else if($this->fields_arr['view']=='Title')
						$this->sql_sort='p.music_title ASC ';
					else
						$this->sql_sort='p.music_id ASC ';
				}else{
					$this->sql_sort = 'sum_total_views DESC';
				}

				if ($this->fields_arr['artist_id']){
					$artist_extra_query .= '(FIND_IN_SET('.addslashes($this->fields_arr['artist_id']).',p.music_artist)) AND ';
				}
				if ($this->fields_arr['album_id']){
					$album_extra_query .= '(ma.music_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
				}
				if ($this->fields_arr['tags']){
				  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_caption', '').') AND ';
				}
				if($this->fields_arr['myfavoritemusic'] == 'No')
					$this->sql_condition = $additional_query .$artist_extra_query.$album_extra_query.$tags_extra_query.  'p.music_status=\'Ok\' AND p.thumb_name_id = music_file_id ' . $this->getAdultQuery('p.', 'music') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND p.total_views>0 AND ( ' . $this->myMusicCondition() . ' )' . $this->getMostViewedExtraQuery() . '' . $this->advancedFilters() .$this->searchTitleFilters(). ' GROUP BY vp.music_id';
				else
					$this->sql_condition = $additional_query .$artist_extra_query.$album_extra_query.$tags_extra_query. 'f.user_id=' . $this->CFG['user']['user_id'] .' AND p.thumb_name_id = music_file_id ' . $this->getAdultQuery('p.', 'music') . ' AND p.music_status=\'Ok\' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND p.total_views>0 ' . $this->getMostViewedExtraQuery() . '' . $this->advancedFilters() .$this->searchTitleFilters(). ' GROUP BY vp.music_id';

			break;
			case 'musicmostdiscussed':
				if($this->fields_arr['myfavoritemusic'] == 'No')
					$this->setTableNames(array($this->CFG['db']['tbl']['music'] . ' AS p JOIN ' . $this->CFG['db']['tbl']['music_comments'] . ' AS pc ON p.music_id = pc.music_id '.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'. ' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'.', ' . $this->CFG['db']['tbl']['users'] . ' AS u '. ' , '.$this->CFG['db']['tbl']['music_files_settings'].' AS vfs'));
				else
					$this->setTableNames(array($this->CFG['db']['tbl']['music_favorite'] . ' AS f LEFT JOIN ' .$this->CFG['db']['tbl']['music'] . ' AS p ON f.music_id=p.music_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_comments'] . ' AS pc ON p.music_id = pc.music_id '.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'. ' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'. ' , ' . $this->CFG['db']['tbl']['users'] . ' AS u '. ' , '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS'));

				$this->setReturnColumns(array('p.music_id', 'p.music_album_id', 'p.user_id','u.user_name', 'p.music_ext','p.music_access_type', 'p.relation_id', 'p.music_title', 'music_caption', 'p.music_server_url', 'p.thumb_width', 'p.thumb_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'music_tags', 'playing_time', 'music_encoded_status', 'music_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date', 'music_thumb_ext', 'count( pc.music_comment_id ) as total_comments', 'p.music_tags','file_name','p.music_artist','ma.album_title','mc.music_category_name','p.rating_count','p.total_plays','p.total_comments','p.total_favorites', 'p.music_year_released', 'p.music_language','p.music_category_id', 'p.allow_ratings', 'p.music_price', 'p.for_sale','ma.album_for_sale','ma.album_price','ma.album_access_type'));
				$additional_query = '';
				$artist_extra_query='';
				$album_extra_query='';
				$tags_extra_query='';
					if ($this->fields_arr['cid'])
						{
							$additional_query .= '(p.music_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';
							if ($this->fields_arr['sid'])
								$additional_query .= '(p.music_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
						}
					if ($this->fields_arr['view']){
						if($this->fields_arr['view']=='Album')
							$this->sql_sort='ma.album_title ASC';
						else if($this->fields_arr['view']=='Artist')
							$this->sql_sort='mr.artist_name ASC ';
						else if($this->fields_arr['view']=='Title')
							$this->sql_sort='p.music_title ASC ';
						else
							$this->sql_sort='p.music_id ASC ';
					}else{
						$this->sql_sort = ' total_comments DESC, total_views DESC ';
					}
					if ($this->fields_arr['artist_id']){
						$artist_extra_query .= '(FIND_IN_SET('.addslashes($this->fields_arr['artist_id']).',p.music_artist)) AND ';
					}
					if ($this->fields_arr['album_id']){
						$album_extra_query .= '(ma.music_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
					}
					if ($this->fields_arr['tags']){
					  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_caption', '').') AND ';
					}
					if($this->fields_arr['myfavoritemusic'] == 'No')
						$this->sql_condition = $additional_query .$artist_extra_query.$album_extra_query.$tags_extra_query.  'music_status = \'Ok\' AND p.thumb_name_id = music_file_id ' . $this->getMostDiscussedExtraQuery() . $this->getAdultQuery('p.', 'music') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND ( ' . $this->myMusicCondition() . ' ) AND comment_status=\'Yes\' ' . $this->advancedFilters() .$this->searchTitleFilters(). ' GROUP BY pc.music_id';
					else
						$this->sql_condition = $additional_query .$artist_extra_query.$album_extra_query.$tags_extra_query. 'f.user_id=' . $this->CFG['user']['user_id'].' AND p.thumb_name_id = music_file_id ' . $this->getMostDiscussedExtraQuery() . $this->getAdultQuery('p.', 'music') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND p.music_status=\'Ok\' AND comment_status=\'Yes\' ' . $this->advancedFilters() .$this->searchTitleFilters(). ' GROUP BY pc.music_id';
			break;
			case 'musicmostfavorite':
				if($this->fields_arr['myfavoritemusic'] == 'No')
					$this->setTableNames(array($this->CFG['db']['tbl']['music'] . ' AS p JOIN ' . $this->CFG['db']['tbl']['music_favorite'] . ' AS pf ON p.music_id = pf.music_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'. ' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'.', '.$this->CFG['db']['tbl']['users'] . ' AS u '. ' , '.$this->CFG['db']['tbl']['music_files_settings'].' AS vfs'));
				else
					$this->setTableNames(array($this->CFG['db']['tbl']['music_favorite'] . ' AS pf LEFT JOIN ' .$this->CFG['db']['tbl']['music'] . ' AS p ON pf.music_id=p.music_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'. ' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'. ' , ' . $this->CFG['db']['tbl']['users'] . ' AS u '. ' , '.$this->CFG['db']['tbl']['music_files_settings'].' AS vfs'));

				$this->setReturnColumns(array('p.music_id', 'p.music_album_id', 'p.user_id','u.user_name', 'p.music_ext','p.music_access_type', 'p.relation_id', 'p.music_title', 'music_caption', 'p.music_server_url', 'p.thumb_width', 'p.thumb_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'music_tags', 'playing_time', 'music_encoded_status', 'music_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date', 'music_thumb_ext', 'count( pf.music_favorite_id ) as total_favorite', 'p.music_tags','file_name','p.music_artist','ma.album_title','mc.music_category_name','p.rating_count','p.total_plays','p.total_comments','p.total_favorites', 'p.music_year_released', 'p.music_language','p.music_category_id', 'p.allow_ratings', 'p.music_price', 'p.for_sale','ma.album_for_sale','ma.album_price','ma.album_access_type'));
				$additional_query = '';
				$artist_extra_query='';
				$album_extra_query='';
				$tags_extra_query='';
				if ($this->fields_arr['cid']){
					$additional_query .= '(p.music_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';
					if ($this->fields_arr['sid'])
					$additional_query .= '(p.music_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
				}
				if ($this->fields_arr['view']){
					if($this->fields_arr['view']=='Album')
						$this->sql_sort='ma.album_title ASC';
					else if($this->fields_arr['view']=='Artist')
						$this->sql_sort='mr.artist_name ASC ';
					else if($this->fields_arr['view']=='Title')
						$this->sql_sort='p.music_title ASC ';
					else
						$this->sql_sort='p.music_id ASC ';

				}else{
					$this->sql_sort = ' total_favorite DESC, total_views DESC ';
				}
				if ($this->fields_arr['artist_id']){
					$artist_extra_query .= '(FIND_IN_SET('.addslashes($this->fields_arr['artist_id']).',p.music_artist)) AND ';
				}
				if ($this->fields_arr['album_id']){
					$album_extra_query .= '(ma.music_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
				}
				if ($this->fields_arr['tags']){
				  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_caption', '').') AND ';
				}
				if($this->fields_arr['myfavoritemusic'] == 'No')
					$this->sql_condition = $additional_query .$artist_extra_query.$album_extra_query.$tags_extra_query.  'music_status = \'Ok\' AND p.thumb_name_id = music_file_id ' . $this->getMostFavoriteExtraQuery() . $this->getAdultQuery('p.', 'music') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND ( ' . $this->myMusicCondition() . ' )' . $this->advancedFilters() .$this->searchTitleFilters(). ' GROUP BY pf.music_id';
				else
					$this->sql_condition = $additional_query .$artist_extra_query.$album_extra_query.$tags_extra_query. ' pf.user_id=' . $this->CFG['user']['user_id']. ' AND p.music_status = \'Ok\' AND p.thumb_name_id = music_file_id ' . $this->getMostFavoriteExtraQuery() . $this->getAdultQuery('p.', 'music') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' ' . $this->advancedFilters() .$this->searchTitleFilters(). ' GROUP BY pf.music_id';
			break;
			case 'musicmostrecentlyviewed':
				if($this->fields_arr['myfavoritemusic'] == 'No')
					$this->setTableNames(array($this->CFG['db']['tbl']['music'].' AS p JOIN ' . $this->CFG['db']['tbl']['users'] . ' AS u ON p.user_id = u.user_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'. ' JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = thumb_name_id'. ' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'));
				else
					$this->setTableNames(array($this->CFG['db']['tbl']['music'].' AS p JOIN ' . $this->CFG['db']['tbl']['users'] . ' AS u ON p.user_id = u.user_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'. ' JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = thumb_name_id'. ' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id LEFT JOIN '.$this->CFG['db']['tbl']['music_favorite'].' AS pf ON pf.music_id=p.music_id'));

				$this->setReturnColumns(array('p.music_id', 'p.music_album_id', 'p.user_id','u.user_name', 'p.music_ext','p.music_access_type', 'p.relation_id', 'p.music_title', 'music_caption', 'p.music_server_url', 'p.thumb_width', 'p.thumb_height', 'p.last_view_date as max_view_date', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'music_tags', 'playing_time', 'music_encoded_status', 'music_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date', 'music_thumb_ext', 'p.music_tags','file_name','p.music_artist','ma.album_title','mc.music_category_name','p.rating_count','p.total_plays','p.total_comments','p.total_favorites', 'p.music_year_released', 'p.music_language','p.music_category_id', 'p.allow_ratings', 'p.allow_ratings', 'p.music_price', 'p.for_sale','ma.album_for_sale','ma.album_price','ma.album_access_type'));
				$additional_query = '';
				$artist_extra_query='';
				$album_extra_query='';
				$tags_extra_query='';
				if ($this->fields_arr['cid']){
					$additional_query .= '(p.music_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';
					if ($this->fields_arr['sid'])
					$additional_query .= '(p.music_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
				}
				if ($this->fields_arr['view']){
					if($this->fields_arr['view']=='Album')
						$this->sql_sort='ma.album_title ASC';
					else if($this->fields_arr['view']=='Artist')
						$this->sql_sort='mr.artist_name ASC ';
					else if($this->fields_arr['view']=='Title')
						$this->sql_sort='p.music_title ASC ';
					else
						$this->sql_sort='p.music_id ASC ';
				}else{
					$this->sql_sort = 'max_view_date DESC';
				}
				if ($this->fields_arr['artist_id']){
					$artist_extra_query .= '(FIND_IN_SET('.addslashes($this->fields_arr['artist_id']).',p.music_artist)) AND ';
				}
				if ($this->fields_arr['album_id']){
					$album_extra_query .= '(ma.music_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
				}
				if ($this->fields_arr['tags']){
				  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_caption', '').') AND ';
				}
				if($this->fields_arr['myfavoritemusic'] == 'No')
					$this->sql_condition = $additional_query .$artist_extra_query.$album_extra_query.$tags_extra_query.  'p.music_status=\'Ok\'' . $this->getAdultQuery('p.', 'music') . ' AND u.usr_status=\'Ok\' AND p.total_views>0 AND ( ' . $this->myMusicCondition() . ' )' . $this->advancedFilters().$this->searchTitleFilters();
				else
					$this->sql_condition = $additional_query .$artist_extra_query.$album_extra_query.$tags_extra_query. 'pf.user_id=' . $this->CFG['user']['user_id'] . $this->getAdultQuery('p.', 'music') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND p.music_status=\'Ok\' AND p.total_views>0 ' . $this->advancedFilters().$this->searchTitleFilters(). ' GROUP BY pf.music_id';
			break;
			case 'usermusiclist':
				$this->setTableNames(array($this->CFG['db']['tbl']['music'].' AS p JOIN ' . $this->CFG['db']['tbl']['users'] . ' AS u on p.user_id = u.user_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'. ' JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = thumb_name_id'. ' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'));
				$this->setReturnColumns(array('p.music_id', 'p.music_album_id', 'p.user_id','u.user_name', 'p.music_ext','p.music_access_type', 'p.relation_id', 'p.music_title', 'music_caption', 'p.music_server_url', 'p.thumb_width', 'p.thumb_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'music_tags', 'playing_time', 'music_encoded_status', 'music_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date', 'music_thumb_ext', 'p.music_tags','file_name','p.music_artist','ma.album_title','mc.music_category_name','p.rating_count','p.total_plays','p.total_comments','p.total_favorites', 'p.music_year_released', 'p.music_language','p.music_category_id', 'p.allow_ratings', 'p.music_price', 'p.for_sale','ma.album_for_sale','ma.album_price','ma.album_access_type'));
				$artist_extra_query='';
				$album_extra_query='';
				$tags_extra_query='';
					if ($this->fields_arr['view']){
						if($this->fields_arr['view']=='Album')
							$this->sql_sort='ma.album_title ASC';
						else if($this->fields_arr['view']=='Artist')
							$this->sql_sort='mr.artist_name ASC ';
						else if($this->fields_arr['view']=='Title')
							$this->sql_sort='p.music_title ASC ';
						else
							$this->sql_sort='p.music_id ASC ';
					}else{
						$this->sql_sort = 'music_id DESC';
					}

					if ($this->fields_arr['artist_id']){
						$artist_extra_query .= '(FIND_IN_SET('.addslashes($this->fields_arr['artist_id']).',p.music_artist)) AND ';
					}

					if ($this->fields_arr['album_id']){
						$album_extra_query .= '(ma.music_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
					}
					if ($this->fields_arr['tags']){
					  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_caption', '').') AND ';
					}
					$this->sql_condition =$artist_extra_query.$album_extra_query.$tags_extra_query.  'p.user_id=\'' . addslashes($this->fields_arr['user_id']) . '\'' . $this->getAdultQuery('p.', 'music') . ' AND u.usr_status=\'Ok\' AND p.music_status=\'Ok\' ' . $this->advancedFilters().$this->searchTitleFilters();

			break;
			case 'albumlist':
				$this->setTableNames(array($this->CFG['db']['tbl']['music_album'] . ' AS p LEFT JOIN '.$this->CFG['db']['tbl']['music'] .' AS ph On p.music_album_id=ph.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =ph.music_category_id'. ' JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = thumb_name_id'.', '.$this->CFG['db']['tbl']['users'] . ' AS u '));
				$this->setReturnColumns(array('p.music_album_id','p.album_title','count(p.music_album_id) as total_album_musics' ,'ph.thumb_music_id', 'p.user_id','u.user_name', 'ph.music_ext', 'ph.music_access_type', 'p.relation_id', 'ph.music_title', 'ph.music_caption', 'p.music_server_url', 'ph.thumb_width', 'ph.thumb_height', 'p.music_album_id', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'ph.total_views', '(ph.rating_total/ph.rating_count) as rating', 'ph.music_tags', 'ph.playing_time', 'ph.music_encoded_status', 'ph.music_status', 'TIMEDIFF(NOW(), ph.last_view_date) as last_view_date', 'ph.music_thumb_ext', 'ph.music_tags','file_name','p.small_width','p.small_height','p.music_artist','ma.album_title','mc.music_category_name','p.rating_count','p.total_plays','p.total_comments','p.total_favorites', 'p.music_year_released', 'p.music_language','p.music_category_id', 'ph.allow_ratings', 'ph.for_sale','ma.album_for_sale','ma.album_price','ma.album_access_type'));
				$artist_extra_query='';
				$album_extra_query='';
				$tags_extra_query='';
					if ($this->fields_arr['view'])
						{
							if($this->fields_arr['view']=='Album')
								$this->sql_sort='ma.album_title ASC';
							else if($this->fields_arr['view']=='Artist')
								$this->sql_sort='mr.artist_name ASC ';
							else if($this->fields_arr['view']=='Title')
								$this->sql_sort='p.music_title ASC ';
							else
								$this->sql_sort='p.music_id ASC ';

						}
					else
						{
							$this->sql_sort = 'p.music_album_id DESC';
						}
					if ($this->fields_arr['artist_id'])
						{
							$artist_extra_query .= '(FIND_IN_SET('.addslashes($this->fields_arr['artist_id']).',p.music_artist)) AND ';
						}
					if ($this->fields_arr['album_id'])
						{
							$album_extra_query .= '(ma.music_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
						}
					if ($this->fields_arr['tags'])
						{
						  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_caption', '').') AND ';
						}
					$this->sql_condition = $artist_extra_query.$album_extra_query.$tags_extra_query. 'ph.music_status=\'Ok\' AND ph.user_id = u.user_id AND u.usr_status=\'Ok\' AND p.user_id = ' . $this->CFG['user']['user_id']  . $this->getAdditionalQuery('p.') . ' group by p.music_album_id' . $this->advancedFilters().$this->searchTitleFilters();

			break;
			case 'albummusiclist':
				$this->setTableNames(array($this->CFG['db']['tbl']['music'].' AS p JOIN ' . $this->CFG['db']['tbl']['users'] . ' AS u ON p.user_id = u.user_id'. ' JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = thumb_name_id'. ' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'));
				$this->setReturnColumns(array('p.music_id', 'p.music_album_id','p.user_id','u.user_name', 'p.music_ext','p.music_access_type', 'p.relation_id', 'p.music_title', 'music_caption', 'p.music_server_url', 'p.thumb_width', 'p.thumb_height', 'music_album_id', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'music_tags', 'playing_time', 'music_encoded_status', 'music_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date', 'music_thumb_ext', 'p.music_tags','file_name','p.music_artist','ma.album_title','mc.music_category_name','p.rating_count','p.total_plays','p.total_comments','p.total_favorites', 'p.music_year_released', 'p.music_language','p.music_category_id', 'p.allow_ratings', 'p.music_price', 'p.for_sale','ma.album_for_sale','ma.album_price','ma.album_access_type'));
				$artist_extra_query='';
				$album_extra_query='';
				$tags_extra_query='';
					if ($this->fields_arr['view'])
						{
							if($this->fields_arr['view']=='Album')
								$this->sql_sort='ma.album_title ASC';
							else if($this->fields_arr['view']=='Artist')
								$this->sql_sort='mr.artist_name ASC ';
							else if($this->fields_arr['view']=='Title')
								$this->sql_sort='p.music_title ASC ';
							else
								$this->sql_sort='p.music_id ASC ';

						}
					else
						{
							$this->sql_sort = 'music_id DESC';
						}
					if ($this->fields_arr['artist_id'])
						{
							$artist_extra_query .= '(FIND_IN_SET('.addslashes($this->fields_arr['artist_id']).',p.music_artist)) AND ';
						}
					if ($this->fields_arr['album_id'])
						{
							$album_extra_query .= '(ma.music_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
						}
					if ($this->fields_arr['tags'])
						{
						  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_caption', '').') AND ';
						}
					$this->sql_condition =$artist_extra_query.$album_extra_query.$tags_extra_query.  'p.music_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\'' . $this->getAdultQuery('p.', 'music') . ' AND u.usr_status=\'Ok\' AND p.music_status=\'Ok\' AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.music_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ')' . $this->advancedFilters().$this->searchTitleFilters();

			break;
			case 'myalbummusiclist':
				$this->setTableNames(array($this->CFG['db']['tbl']['music'].' AS p JOIN ' . $this->CFG['db']['tbl']['users'] . ' AS u on p.user_id = u.user_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'. ' JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = thumb_name_id'. ' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'));
				$this->setReturnColumns(array('p.music_id', 'p.music_album_id', 'p.user_id','u.user_name', 'p.music_ext','p.music_access_type', 'p.relation_id', 'p.music_title', 'music_caption', 'p.music_server_url', 'p.thumb_width', 'p.thumb_height', 'music_album_id', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'music_tags', 'playing_time', 'music_encoded_status', 'music_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date', 'music_thumb_ext', 'p.music_tags','file_name','p.music_artist','ma.album_title','mc.music_category_name','p.rating_count','p.total_plays','p.total_comments','p.total_favorites', 'p.music_year_released', 'p.music_language','p.music_category_id', 'p.allow_ratings', 'p.music_price', 'p.for_sale','ma.album_for_sale','ma.album_price','ma.album_access_type'));
			    $artist_extra_query='';
				$album_extra_query='';
				$tags_extra_query='';
					if ($this->fields_arr['view'])
							{
								if($this->fields_arr['view']=='Album')
									$this->sql_sort='ma.album_title ASC';
								else if($this->fields_arr['view']=='Artist')
									$this->sql_sort='mr.artist_name ASC ';
								else if($this->fields_arr['view']=='Title')
									$this->sql_sort='p.music_title ASC ';
								else
									$this->sql_sort='p.music_id ASC ';

							}
					else
						{
							$this->sql_sort = 'music_id DESC';
						}
					if ($this->fields_arr['artist_id'])
						{
							$artist_extra_query .= '(FIND_IN_SET('.addslashes($this->fields_arr['artist_id']).',p.music_artist)) AND ';
						}
					if ($this->fields_arr['album_id'])
						{
							$album_extra_query .= '(ma.music_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
						}
					if ($this->fields_arr['tags'])
						{
						  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_caption', '').') AND ';
						}
					$this->sql_condition = $artist_extra_query.$album_extra_query.$tags_extra_query. 'p.music_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\' AND u.usr_status=\'Ok\' AND p.user_id=\'' . addslashes($this->CFG['user']['user_id']) . '\'' . $this->getAdultQuery('p.', 'music') . ' AND p.music_status=\'Ok\' AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.music_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ')' . $this->advancedFilters().$this->searchTitleFilters();

			break;
			case 'myplaylist':
				$this->setTableNames(array($this->CFG['db']['tbl']['music'] . ' AS p JOIN ' . $this->CFG['db']['tbl']['music_in_playlist'] . ' AS pl ON p.music_id=pl.music_id  ' .' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'.' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id JOIN '. $this->CFG['db']['tbl']['music_playlist'] . ' AS pp ON pl.playlist_id = pp.playlist_id'. ' JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = thumb_name_id'.', '.$this->CFG['db']['tbl']['users'] . ' AS u '));
				$this->setReturnColumns(array('p.music_id', 'p.music_album_id', 'p.user_id','u.user_name', 'p.music_ext','p.music_access_type', 'p.relation_id', 'p.music_title', 'music_caption', 'p.music_server_url', 'p.thumb_width', 'p.thumb_height', 'p.music_album_id', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'music_tags', 'playing_time', 'music_encoded_status', 'music_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date',  'music_thumb_ext', 'p.music_tags','file_name','p.music_artist','ma.album_title','mc.music_category_name','p.rating_count','p.total_plays','p.total_comments','p.total_favorites','pl.playlist_id', 'p.music_year_released', 'p.music_language','p.music_category_id', 'p.allow_ratings', 'p.music_price', 'p.for_sale','ma.album_for_sale','ma.album_price','ma.album_access_type'));
				$artist_extra_query='';
				$album_extra_query='';
				$tags_extra_query='';
					if ($this->fields_arr['view'])
						{
							if($this->fields_arr['view']=='Album')
								$this->sql_sort='ma.album_title ASC';
							else if($this->fields_arr['view']=='Artist')
								$this->sql_sort='mr.artist_name ASC ';
							else if($this->fields_arr['view']=='Title')
								$this->sql_sort='p.music_title ASC ';
							else
								$this->sql_sort='p.music_id ASC ';

						}
					else
						{
							$this->sql_sort = 'music_id DESC';
						}
					if ($this->fields_arr['artist_id'])
						{
							$artist_extra_query .= '(FIND_IN_SET('.addslashes($this->fields_arr['artist_id']).',p.music_artist)) AND ';
						}
					if ($this->fields_arr['album_id'])
						{
							$album_extra_query .= '(ma.music_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
						}
					if ($this->fields_arr['tags'])
						{
						  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_caption', '').') AND ';
						}
					$this->sql_condition = $artist_extra_query.$album_extra_query.$tags_extra_query. 'pp.user_id = ' . $this->CFG['user']['user_id'] .' AND music_status=\'Ok\' AND p.user_id = u.user_id AND u.usr_status=\'Ok\''. $this->advancedFilters().$this->searchTitleFilters();

			break;
			case 'musicmostresponded':
				$this->setTableNames(array($this->CFG['db']['tbl']['music'].' AS p JOIN ' . $this->CFG['db']['tbl']['users'] . ' AS u ON p.user_id = u.user_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'. ' JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = thumb_name_id'. ' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'));
				$this->setReturnColumns(array('p.music_id', 'p.music_album_id', 'p.user_id','u.user_name', 'p.music_ext','p.music_access_type', 'p.relation_id', 'p.music_title', 'music_caption', 'p.music_server_url', 'p.thumb_width', 'p.thumb_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'music_tags', 'playing_time', 'music_encoded_status', 'music_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date',  'music_thumb_ext', 'p.music_tags','file_name','p.music_artist','ma.album_title','mc.music_category_name','p.rating_count','p.total_plays','p.total_comments','p.total_favorites', 'p.music_year_released', 'p.music_language','p.music_category_id', 'p.allow_ratings', 'p.music_price', 'p.for_sale','ma.album_for_sale','ma.album_price','ma.album_access_type'));
				$additional_query = '';
				$artist_extra_query='';
				$album_extra_query='';
				$tags_extra_query='';
				if ($this->fields_arr['cid'])
					{
						$additional_query .= '(p.music_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';
						if ($this->fields_arr['sid'])
							$additional_query .= '(p.music_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
					}
					if ($this->fields_arr['view']){
						if($this->fields_arr['view']=='Album')
							$this->sql_sort='ma.album_title ASC';
						else if($this->fields_arr['view']=='Artist')
							$this->sql_sort='mr.artist_name ASC ';
						else if($this->fields_arr['view']=='Title')
							$this->sql_sort='p.music_title ASC ';
						else
							$this->sql_sort='p.music_id ASC ';
				    }else{
						$this->sql_sort = 'music_tags ';
					}
					if ($this->fields_arr['artist_id'])
						{
							$artist_extra_query .= '(FIND_IN_SET('.addslashes($this->fields_arr['artist_id']).',p.music_artist)) AND ';
						}
					if ($this->fields_arr['album_id'])
						{
							$album_extra_query .= '(ma.music_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
						}
					if ($this->fields_arr['tags'])
						{
						  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_caption', '').') AND ';
						}
				$this->sql_condition = $additional_query .$artist_extra_query.$album_extra_query.$tags_extra_query.  'p.music_status=\'Ok\'' . $this->getAdultQuery('p.', 'music') . ' AND u.usr_status=\'Ok\' AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.music_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ') ' . $this->advancedFilters().$this->searchTitleFilters();
			break;
			case 'musicmostlinked':
				$this->setTableNames(array($this->CFG['db']['tbl']['music'].' as p JOIN ' . $this->CFG['db']['tbl']['users'] . ' AS u on p.user_id = u.user_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'. ' JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = thumb_name_id'. ' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'));
				$this->setReturnColumns(array('p.music_id', 'p.music_album_id', 'p.user_id','u.user_name', 'p.music_ext','p.music_access_type', 'p.relation_id', 'p.music_title', 'music_caption', 'p.music_server_url', 'p.thumb_width', 'p.thumb_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'music_tags', 'playing_time', 'music_encoded_status', 'music_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date', 'music_thumb_ext', 'p.music_tags','file_name','p.music_artist','ma.album_title','mc.music_category_name','p.rating_count','p.total_plays','p.total_comments','p.total_favorites', 'p.music_year_released', 'p.music_language','p.music_category_id', 'p.allow_ratings', 'p.music_price', 'p.for_sale','ma.album_for_sale','ma.album_price','ma.album_access_type'));
				$additional_query = '';
				$artist_extra_query='';
				$album_extra_query='';
				$tags_extra_query='';
					if ($this->fields_arr['cid'])
						{
							$additional_query .= '(p.music_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';
							if ($this->fields_arr['sid'])
							$additional_query .= '(p.music_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
						}
					if ($this->fields_arr['view']){
						if($this->fields_arr['view']=='Album')
							$this->sql_sort='ma.album_title ASC';
						else if($this->fields_arr['view']=='Artist')
							$this->sql_sort='mr.artist_name ASC ';
						else if($this->fields_arr['view']=='Title')
							$this->sql_sort='p.music_title ASC ';
						else
							$this->sql_sort='p.music_id ASC ';
				        }
					else
						{
							$this->sql_sort = '';
						}
					if ($this->fields_arr['artist_id'])
						{
							$artist_extra_query .= '(FIND_IN_SET('.addslashes($this->fields_arr['artist_id']).',p.music_artist)) AND ';
						}
					if ($this->fields_arr['album_id'])
						{
							$album_extra_query .= '(ma.music_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
						}
					if ($this->fields_arr['tags'])
						{
						  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_caption', '').') AND ';
						}
				$this->sql_condition = $additional_query .$artist_extra_query.$album_extra_query.$tags_extra_query.  'p.music_status=\'Ok\'' . $this->getAdultQuery('p.', 'music') . ' AND u.usr_status=\'Ok\' AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.music_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ') AND p.allow_ratings=\'Yes\'' . $this->advancedFilters().$this->searchTitleFilters();
			break;
			case 'musicrecommended':
				if($this->fields_arr['myfavoritemusic'] == 'No')
					$this->setTableNames(array($this->CFG['db']['tbl']['music'].' AS p JOIN ' . $this->CFG['db']['tbl']['users'] . ' AS u on p.user_id = u.user_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'. ' JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = thumb_name_id'. ' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'));
				else
					$this->setTableNames(array($this->CFG['db']['tbl']['music_favorite'] . ' AS f LEFT JOIN ' .$this->CFG['db']['tbl']['music'] . ' AS p ON f.music_id=p.music_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'.' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'. ' JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = p.thumb_name_id'.', '.$this->CFG['db']['tbl']['users'] . ' AS u '));

				$this->setReturnColumns(array('p.music_id', 'p.music_album_id', 'p.user_id','u.user_name', 'p.music_ext','p.music_access_type', 'p.relation_id', 'p.music_title', 'music_caption', 'p.music_server_url', 'p.thumb_width', 'p.thumb_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'music_tags', 'playing_time', 'music_encoded_status', 'music_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date', 'music_thumb_ext', 'p.music_tags','file_name','total_featured','p.music_artist','ma.album_title','mc.music_category_name','p.rating_count','p.total_plays','p.total_comments','p.total_favorites', 'p.music_year_released', 'p.music_language','p.music_category_id', 'p.allow_ratings', 'p.music_price', 'p.for_sale','ma.album_for_sale','ma.album_price','ma.album_access_type'));
				$additional_query = '';
				$artist_extra_query='';
				$album_extra_query='';
				$tags_extra_query='';
					if ($this->fields_arr['cid'])
						{
						$additional_query .= '(p.music_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';
						if ($this->fields_arr['sid'])
							$additional_query .= '(p.music_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
						}
						if ($this->fields_arr['view']){
							if($this->fields_arr['view']=='Album')
							$this->sql_sort='ma.album_title ASC';
							else if($this->fields_arr['view']=='Artist')
								$this->sql_sort='mr.artist_name ASC ';
							else if($this->fields_arr['view']=='Title')
								$this->sql_sort='p.music_title ASC ';
							else
								$this->sql_sort='p.music_id ASC ';
						 }else
							$this->sql_sort = 'rating DESC';

						if ($this->fields_arr['artist_id']){
								$artist_extra_query .= '(FIND_IN_SET('.addslashes($this->fields_arr['artist_id']).',p.music_artist)) AND ';
							}
						if ($this->fields_arr['album_id']){
								$album_extra_query .= '(ma.music_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
							}
						if ($this->fields_arr['tags']){
							  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_caption', '').') AND ';
							}
				if($this->fields_arr['myfavoritemusic'] == 'No')
					$this->sql_condition = $additional_query .$artist_extra_query.$album_extra_query.$tags_extra_query. 'p.music_status=\'Ok\'' . $this->getAdultQuery('p.', 'music') . ' AND u.usr_status=\'Ok\' AND ( ' . $this->myMusicCondition() . ' ) AND p.music_featured=\'Yes\'' . $this->advancedFilters().$this->searchTitleFilters();
				else
					$this->sql_condition = $additional_query .$artist_extra_query.$album_extra_query.$tags_extra_query. 'f.user_id=' . $this->CFG['user']['user_id'] . $this->getAdultQuery('p.', 'music') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND p.music_status=\'Ok\' AND p.music_featured=\'Yes\' ' . $this->advancedFilters().$this->searchTitleFilters();

			break;
			/*case 'musictracker':
				$this->setTableNames(array($this->CFG['db']['tbl']['music'].'  AS p LEFT JOIN '.$this->CFG['db']['tbl']['music_listened'].' AS ml ON p.music_id = ml.music_id JOIN ' . $this->CFG['db']['tbl']['users'] . ' AS u ON p.user_id = u.user_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'. ' JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = thumb_name_id'. ' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'));
				$this->setReturnColumns(array('p.music_id', 'p.music_album_id', 'p.user_id','u.user_name', 'p.music_ext','p.music_access_type', 'p.relation_id', 'p.music_title', 'music_caption', 'p.music_server_url', 'p.thumb_width', 'p.thumb_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'music_tags', 'playing_time', 'music_encoded_status', 'music_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date',  'music_thumb_ext', 'p.music_tags','file_name','p.music_artist','ma.album_title','mc.music_category_name','p.rating_count','p.total_plays','p.total_comments','p.total_favorites', 'p.music_year_released', 'p.music_language','TIMEDIFF(NOW(), ml.last_listened) AS last_viewed', ', 'p.allow_ratings'));
				$additional_query = '';
				$artist_extra_query='';
				$album_extra_query='';
				$tags_extra_query='';
				$additional_query .= ' u.user_id = ml.music_owner_id AND ml.user_id ='. $this->CFG['user']['user_id'] .' AND ';

				if ($this->fields_arr['cid'])
					{
						$additional_query .= '(p.music_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';
						if ($this->fields_arr['sid'])
							$additional_query .= '(p.music_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
					}
					if ($this->fields_arr['view']){
						if($this->fields_arr['view']=='Album')
							$this->sql_sort='ma.album_title ASC';
						else if($this->fields_arr['view']=='Artist')
							$this->sql_sort='mr.artist_name ASC ';
						else if($this->fields_arr['view']=='Title')
							$this->sql_sort='p.music_title ASC ';
						else
							$this->sql_sort='p.music_id ASC ';
				    }else{
						$this->sql_sort = 'music_tags ';
					}
					if ($this->fields_arr['artist_id'])
						{
							$artist_extra_query .= '(FIND_IN_SET('.addslashes($this->fields_arr['artist_id']).',p.music_artist)) AND ';
						}
					if ($this->fields_arr['album_id'])
						{
							$album_extra_query .= '(ma.music_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
						}
					if ($this->fields_arr['tags'])
						{
						  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_caption', '').') AND ';
						}
				$this->sql_condition = $additional_query .$artist_extra_query.$album_extra_query.$tags_extra_query.  'p.music_status=\'Ok\'' . $this->getAdultQuery('p.') . ' AND u.usr_status=\'Ok\' AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.music_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ') ' . $this->advancedFilters().$this->searchTitleFilters();
			break;*/

			default:
				if($this->fields_arr['myfavoritemusic'] == 'No')
					$this->setTableNames(array($this->CFG['db']['tbl']['music'].' AS p JOIN ' . $this->CFG['db']['tbl']['users'] . ' AS u ON p.user_id = u.user_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'. ' JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = thumb_name_id'. ' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'));
				else
					$this->setTableNames(array($this->CFG['db']['tbl']['music_favorite'] . ' AS f LEFT JOIN ' .$this->CFG['db']['tbl']['music'] . ' AS p ON f.music_id=p.music_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'.' JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma ON ma.music_album_id =p.music_album_id'.' JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc ON mc.music_category_id =p.music_category_id'. ' JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = p.thumb_name_id'.', '.$this->CFG['db']['tbl']['users'] . ' AS u '));

				$this->setReturnColumns(array('p.music_id', 'p.music_album_id', 'p.user_id','u.user_name', 'p.music_ext', 'p.music_tags','p.music_title', 'music_caption', 'p.music_server_url', 'p.thumb_width', 'p.thumb_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'music_tags', 'playing_time', 'music_encoded_status', 'music_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date','music_thumb_ext','file_name','p.music_artist','ma.album_title','mc.music_category_name','p.rating_count','p.total_plays','p.total_comments','p.total_favorites','mr.artist_name', 'p.music_year_released', 'p.music_language','p.music_category_id', 'p.allow_ratings', 'p.music_price', 'p.for_sale','ma.album_for_sale','ma.album_price','ma.album_access_type'));
				$additional_query = '';
				$extraquery='';
				$artist_extra_query='';
				$album_extra_query='';
				$tags_extra_query='';

					if ($this->fields_arr['cid'])
						{
							$additional_query .= '(p.music_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';
								if ($this->fields_arr['sid'])
									$additional_query .= '(p.music_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
						}
					if ($this->fields_arr['view']){
						if($this->fields_arr['view']=='Album')
							$this->sql_sort='ma.album_title ASC';
						else if($this->fields_arr['view']=='Artist')
							$this->sql_sort='mr.artist_name ASC ';
						else if($this->fields_arr['view']=='Title')
							$this->sql_sort='p.music_title ASC ';
						else
							$this->sql_sort='p.music_id ASC ';
			          }else
					  	$this->sql_sort = 'p.date_added DESC';

                     if ($this->fields_arr['tags'])
						{
						  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.music_caption', '').') AND ';
						}
					if ($this->fields_arr['artist_id'])
						{
						  $artist_extra_query .= '(FIND_IN_SET('.addslashes($this->fields_arr['artist_id']).',p.music_artist)) AND ';
						}
					if ($this->fields_arr['album_id'])
						{
						  $album_extra_query .= '(ma.music_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
						}

				if($this->fields_arr['myfavoritemusic'] == 'No')
					$this->sql_condition = $additional_query .$artist_extra_query.$album_extra_query.$tags_extra_query. 'p.music_status=\'Ok\'' . $this->getAdultQuery('p.', 'music') . ' AND u.usr_status=\'Ok\' AND (' . $this->myMusicCondition() . ')' . $this->advancedFilters().$this->searchTitleFilters();
				else
					$this->sql_condition = $additional_query .$artist_extra_query.$album_extra_query.$tags_extra_query. 'f.user_id=' . $this->CFG['user']['user_id'] . $this->getAdultQuery('p.', 'music') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND p.music_status=\'Ok\' ' . $this->advancedFilters().$this->searchTitleFilters();
			break;
			}
    }

    /**
     * MusicList::chkValidAlbumId()
     *
     * @return
     */
	public function chkValidAlbumId()
		{
			$condition = 'music_album_id=' . $this->dbObj->Param('album_id') . ' AND' . ' (p.user_id = ' . $this->dbObj->Param('user_id') . $this->getAdditionalQuery('p.') . ')';
			$sql = 'SELECT p.album_title, p.user_id FROM ' . $this->CFG['db']['tbl']['music_album'] . ' AS p' . ' WHERE ' . $condition . ' LIMIT 0,1';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['album_id'], $this->CFG['user']['user_id']));
			if (!$rs)
				trigger_db_error($this->dbObj);
			if ($row = $rs->FetchRow())
				{
					$this->ALBUM_TITLE = $row['album_title'];
					$this->ALBUM_USER_ID = $row['user_id'];
					return true;
				}
			return false;
		}

    /**
     * MusicList::updateMusicTagDetails()
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
     * MusicList::updateSearchCountAndResultForMusicTag()
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
     * MusicList::updateSearchCountForMusicTag()
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
     * MusicList::getAlbumName()
     *
     * @return
     */
	public function getAlbumName()
		{
			$sql = 'SELECT album_title FROM ' . $this->CFG['db']['tbl']['music_album'] . ' WHERE music_album_id=' . $this->dbObj->Param('music_album_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['album_id']));
			if (!$rs)
				trigger_db_error($this->dbObj);
			if ($row = $rs->FetchRow())
				return $row['album_title'];
			return $this->LANG['musiclist_unknown_album'];
		}

    /**
     * MusicList::getCategoryName()
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
     * MusicList::getCategoryName()
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
	            return $row['artist_name'];
	        return $this->LANG['unknown_category'];
	    }

    /**
     * MusicList::getMostViewedExtraQuery()
     *
     * @return
     */
    public function getMostViewedExtraQuery()
	    {
	        /*action*/
	        // 1 = today
	        // 2 = yesterday
	        // 3 = this week
	        // 4 = this month
	        // 5 = this year
	        $extra_query = '';
	        switch ($this->fields_arr['action'])
				 {
		            case 1:
		                $extra_query = ' AND DATE_FORMAT(vp.last_viewed,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
		                break;
		            case 2:
		                $extra_query = ' AND DATE_FORMAT(vp.last_viewed,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
		                break;
		            case 3:
		                $extra_query = ' AND DATE_FORMAT(vp.last_viewed,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
		                break;
		            case 4:
		                $extra_query = ' AND DATE_FORMAT(vp.last_viewed,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
		                break;
		            case 5:
		                $extra_query = ' AND DATE_FORMAT(vp.last_viewed,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
		          }
	        return $extra_query;
	    }

    /**
     * MusicList::getMostDiscussedExtraQuery()
     *
     * @return
     */
    public function getMostDiscussedExtraQuery()
	    {
	        $extra_query = '';
	        switch ($this->fields_arr['action'])
				{
		            case 1:
		                $extra_query = ' AND DATE_FORMAT(pc.date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
		                break;

		            case 2:
		                $extra_query = ' AND DATE_FORMAT(pc.date_added,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
		                break;

		            case 3:
		                $extra_query = ' AND DATE_FORMAT(pc.date_added,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
		                break;

		            case 4:
		                $extra_query = ' AND DATE_FORMAT(pc.date_added,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
		                break;

		            case 5:
		                $extra_query = ' AND DATE_FORMAT(pc.date_added,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
		                break;
		        }
	        return $extra_query;
	    }

    /**
     * MusicList::getMostFavoriteExtraQuery()
     *
     * @return
     */
    public function getMostFavoriteExtraQuery()
	    {
	        $extra_query = '';
	        switch ($this->fields_arr['action'])
				 {
		            case 1:
		                $extra_query = ' AND DATE_FORMAT(pf.date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
		                break;

		            case 2:
		               $extra_query = ' AND DATE_FORMAT(pf.date_added,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
		                break;

		            case 3:
		                $extra_query = ' AND DATE_FORMAT(pf.date_added,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
		                break;

		            case 4:
		                $extra_query = ' AND DATE_FORMAT(pf.date_added,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
		                break;

		            case 5:
		                $extra_query = ' AND DATE_FORMAT(pf.date_added,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
		                break;
		        }
	        return $extra_query;
	    }

    /**
     * MusicList::getMusicCountForAlbum()
     *
     * @param mixed $album_id
     * @return
     */
    public function getMusicCountForAlbum($album_id)
	    {
	        $result_arr = array();
	        global $smartyObj;
	        $musics_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['musics']['folder'] . '/' . $this->CFG['admin']['musics']['thumbnail_folder'] . '/';
	        $sql = 'SELECT COUNT(music_id) AS total_musics,music_id,music_ext,thumb_width,thumb_height,music_server_url,music_album_id,file_name,music_thumb_ext FROM ' . $this->CFG['db']['tbl']['music'] . ' JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = thumb_name_id  WHERE FIND_IN_SET(music_album_id,' . $this->dbObj->Param('music_album_id') . ')' . ' AND music_status=\'Ok\' GROUP BY music_album_id';
	        $stmt = $this->dbObj->Prepare($sql);
	        $rs = $this->dbObj->Execute($stmt, array($album_id));
	        if (!$rs)
	            trigger_db_error($this->dbObj);
	        while ($row = $rs->FetchRow())
				 {
		            $result_arr[$row['music_album_id']]['total_musics'] = $row['total_musics'];
		            $result_arr[$row['music_album_id']]['thumb_width'] = $row['thumb_width'];
		            $result_arr[$row['music_album_id']]['thumb_height'] = $row['thumb_height'];
		            $result_arr[$row['music_album_id']]['img_src'] = $row['music_server_url'] . $musics_folder . getMusicImageName($row['music_id'],$row['file_name']) . $this->CFG['admin']['musics']['thumb_name'] . '.' . $row['music_thumb_ext'];
		         }
	        $smartyObj->assign('album_music_count_list', $result_arr);

	        return $result_arr;
    }

    /**
     * MusicList::populateSubCategories()
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
	            trigger_db_error($this->dbObj);
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
		            $row['music_category_name'] = $row['music_category_name'];
					$populateSubCategories_arr['row'][$inc]['record'] = $row;
					$this->fields_arr['pg'] = (empty($this->fields_arr['pg']))?'newmusic':$this->fields_arr['pg'];
			        $populateSubCategories_arr['row'][$inc]['music_list_url'] = getUrl('musiclist', '?pg=' . $this->fields_arr['pg'] . '&cid=' . $this->fields_arr['cid'] . '&sid=' . $row['music_category_id'], $this->fields_arr['pg'] . '/?cid=' . $this->fields_arr['cid'] . '&sid=' . $row['music_category_id'], '', 'music');
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
	/**
	 * MusicList::getRelatedArtistList()
	 *
	 * @param string $artist_name
	 * @return
	 */
	public function getRelatedArtistList($artist_name)
		{
			$sql ='SELECT music_artist_id FROM '.$this->CFG['db']['tbl']['music_artist'].
					' WHERE artist_name LIKE  \'%'. addslashes($artist_name) . '%\'';
        	$stmt = $this->dbObj->Prepare($sql);
        	$rs = $this->dbObj->Execute($stmt);
            if (!$rs)
        	    trigger_db_error($this->dbObj);

			$related_artist_arr = array();
			while($row = $rs->FetchRow())
			{
				$related_artist_arr[] = $row['music_artist_id'];
			}

			return $related_artist_arr;
		}
    /**
     * MusicList::advancedFilters()
     *
     * @return
     */
    public function advancedFilters()
	    {
	        // Advanced Filters (Keyword, User name, Country, Language, Playing time, Most viewed):
	        $advanced_filters = '';
	        $this->advanceSearch = false;
	        if ($this->isFormPOSTed($_REQUEST, 'advanceFromSubmission') or $this->getFormField('advanceFromSubmission')==1)
				{

					if($this->CFG['admin']['musics']['music_artist_feature'])
					{
						if ($this->getFormField('artist') != $this->LANG['musiclist_artist_cast'] AND $this->getFormField('artist'))
						{
							$advanced_filters .= ' AND mr.artist_name LIKE \'%' .validFieldSpecialChr($this->getFormField('artist')) . '%\' ';
							$this->advanceSearch = true;
						}
					}
					else
					{
                        if ($this->getFormField('advan_music_user_name') != $this->LANG['musiclist_user_name'] AND $this->getFormField('advan_music_user_name'))
						{
							$related_artist = $this->getRelatedArtistList(validFieldSpecialChr($this->getFormField('advan_music_user_name')));
							if($related_artist)
							{
								$advanced_filters .= ' AND ( ';
								foreach($related_artist as $key => $artist_id)
								{
									if($key)
										$advanced_filters .= ' OR ';
									$sel_artist_id = ',' . $artist_id . ',';
									$advanced_filters .= ' CONCAT(\',\', music_artist, \',\') LIKE \'%' . $sel_artist_id . '%\' ';
								}
								$advanced_filters .= ' ) ';
							}
							else
							{
								$advanced_filters .= ' AND 0 ';
							}
							$this->advanceSearch = true;
						}
					}
					if ($this->getFormField('music_album_name') != $this->LANG['musiclist_album_name'] AND $this->getFormField('music_album_name'))
						{
							$advanced_filters .= ' AND ma.album_title LIKE \'%' . validFieldSpecialChr($this->getFormField('music_album_name')) . '%\' ';
							$this->advanceSearch = true;
						}
					if ($this->getFormField('music_title') != $this->LANG['musiclist_title_field'] AND $this->getFormField('music_title'))
						{
							$advanced_filters .= ' AND music_title LIKE \'%' . validFieldSpecialChr($this->getFormField('music_title')) . '%\' ';
							$this->advanceSearch = true;
						}
					if ($this->getFormField('music_tags') != $this->LANG['musiclist_tags'] AND $this->getFormField('music_tags'))
						{
							$advanced_filters .= ' AND (music_tags LIKE \'%' . validFieldSpecialChr($this->getFormField('music_tags')) . '%\' OR music_title LIKE \'%' . validFieldSpecialChr($this->getFormField('music_tags')) . '%\' OR music_caption LIKE \'%' . validFieldSpecialChr($this->getFormField('music_tags')) . '%\')';
							$this->advanceSearch = true;
						}

					if ($this->getFormField('music_language') != '')
						{
							$advanced_filters .= ' AND music_language = \'' . $this->getFormField('music_language') . '\' ';
							$this->advanceSearch = true;
						}
					if (($this->getFormField('run_length') != '') and ($this->getFormField('run_length') != 1))
						{
							switch ($this->getFormField('run_length'))
								{
									case 2:
										$advanced_filters .= ' AND MINUTE(playing_time) <4 AND HOUR(playing_time) <= 0';
										break;

									case 3:
										$advanced_filters .= ' AND (MINUTE(playing_time) >=4 AND MINUTE(playing_time)<20) AND HOUR(playing_time) <= 0';
										break;

									case 4:
										$advanced_filters .= ' AND (MINUTE(playing_time) >=20 AND MINUTE(playing_time)<60) AND HOUR(playing_time) <= 0';
										break;

									case 5:
										$advanced_filters .= ' AND HOUR(playing_time) > 1 ';
										break;
								}
								$this->advanceSearch = true;
						}
					if ($this->getFormField('added_within') != '')
						{
							switch ($this->getFormField('added_within'))
								{
									case 1:
										$advanced_filters .= ' AND DATE_FORMAT(p.date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\') ';
										break;

									case 2:
										$advanced_filters .= ' AND DATE_FORMAT(p.date_added,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\') ';
										break;

									case 3:
										$advanced_filters .= ' AND DATE_FORMAT(p.date_added,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\') ';
										break;

									case 4:
										$advanced_filters .= ' AND DATE_FORMAT(p.date_added,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\') ';
										break;

									case 4:
										$advanced_filters .= ' AND DATE_FORMAT(p.date_added,\'%y\')=DATE_FORMAT(NOW(),\'%y\') ';
										break;
								}
								$this->advanceSearch = true;
						}
					return $advanced_filters;
				}
	    }

	public function searchTitleFilters()
		{
			$searchTitleFilters = '';
			$this->titleSearch = false;
			if ($this->isFormPOSTed($_REQUEST, 'titles') && !empty($this->fields_arr['titles']))
				{
					$title= $this->fields_arr['titles'];
					if($title == 'All')
						$searchTitleFilters .= ' AND music_title != \'\' ';
					else
					{
						$searchTitleFilters .= ' AND music_title LIKE \'' .$title . '%\' ';
						$this->titleSearch = true;
					}
				}
			return $searchTitleFilters;
		}

	public function searchViewFilters()
		{
			$searchViewFilters = '';
			$this->viewSearch = false;
			if ($this->isFormPOSTed($_REQUEST, 'view'))
			{
				$view= $this->fields_arr['view'];
				if($_REQUEST['view']=='Album')
					{
						$searchViewFilters .= ' AND music_title LIKE \'' .$view . '%\' ';
						$this->viewSearch = true;
					}
				elseif($_REQUEST['view']=='Artist')
					{
						$searchViewFilters .= ' AND music_title LIKE \'' .$view . '%\' ';
						$this->viewSearch = true;
					}
				else
					{
						$searchViewFilters .= ' AND music_title LIKE \'' .$view . '%\' ';
						$this->viewSearch = true;
					}
			}
			return $searchViewFilters;
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
								$getMusicTags_arr[$i]['tags_name'] = $tags_arr[$i];
							else
								$getMusicTags_arr[$i]['tags_name'] = $tags_arr[$i];
							$getMusicTags_arr[$i]['tags_url'] = getUrl('musiclist', '?pg=musicnew&tags='.$tags_arr[$i], 'musicew/?tags='.$tags_arr[$i], '', 'music');
						}
				}
			return $getMusicTags_arr;
		}
	public function chkAlphabeticalResultFound()
		{
			return $this->titleSearch;
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
					<a onclick="return callAjaxRate('<?php echo $this->CFG['site']['music_url'].'musicList.php?pg=musicnew'?>', 'selRatingPlaylist')" onmouseover="ratingMusicMouseOver(<?php echo $i;?>)" onmouseout="ratingMusicMouseOut(<?php echo $i;?>)"><img id="img<?php echo $i;?>" src="<?php echo $this->CFG['site']['music_url'].'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-audioratehover.gif'; ?>"  title="<?php echo $i;?>" alt="<?php echo $i;?>" /></a>
					<?php
				}
			for($i=$rating;$i<$rating_total;$i++)
				{
					?>
					<a onclick="return callAjaxRate('<?php echo $this->CFG['site']['music_url'].'musicList.php?pg=musicnew'?>', 'selRatingPlaylist')" onmouseover="ratingMusicMouseOver(<?php echo ($i+1);?>)" onmouseuut="ratingMusicMouseOut(<?php echo ($i+1);?>)"><img id="img<?php echo ($i+1);?>" src="<?php echo $this->CFG['site']['music_url'].'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-audiorate.gif'; ?>"  title="<?php echo ($i+1);?>" alt="<?php echo $i;?>" /></a>
					<?php
				}
		}
    public function getDescriptionForMusicList($music_description)
		{
			    // change the function for display the caption with some more text
				global $smartyObj;
			    $getDescriptionLink_arr = array();
				$description_array = explode(' ', $music_description);
				$search_word_description = '';
				if($this->fields_arr['tags']!='')
					$search_word_description=$this->fields_arr['tags'];
				for($i=0;$i<count($description_array);$i++){
					if($i<15){
						if(strlen($description_array[$i]) > 15 and strlen($description_array[$i]) > 15+3)
							$getDescriptionLink_arr[$i]['title_tag_name'] = $getDescriptionLink_arr[$i]['wordWrap_mb_ManualWithSpace_description_name'] = $description_array[$i];
						else
							$getDescriptionLink_arr[$i]['title_tag_name'] = $getDescriptionLink_arr[$i]['wordWrap_mb_ManualWithSpace_description_name'] = $description_array[$i];
						//code added for highlight the search description.
						$getDescriptionLink_arr[$i]['wordWrap_mb_ManualWithSpace_description_name']= highlightWords($getDescriptionLink_arr[$i]['wordWrap_mb_ManualWithSpace_description_name'],$search_word_description);
					}
				}

				$smartyObj->assign('getDescriptionLink_arr', $getDescriptionLink_arr);
		}
	  /**
		 * musicList::getTotalManageLyricCount()
		 *
		 * @param mixed $music_id
		 * @return
		 */
		public function getTotalManageLyricCount($music_id)
			{
				$sql = 'SELECT count(music_lyric_id) as total_lyrics  FROM '.$this->CFG['db']['tbl']['music_lyric'].' '.
						'WHERE music_id = '.$this->dbObj->Param('music_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($music_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $row['total_lyrics'];
			}
	/**
	 * musicList::getMusicOwnerCount()
	 *
	 * @param $sel_music_ids
	 *
	 * @return int $music_count
	 */
	public function getMusicOwnerCount($sel_music_ids)
	{
		if(!$sel_music_ids)
			return 0;

		$sql = 'SELECT count(DISTINCT(music_id)) AS music_count FROM '.$this->CFG['db']['tbl']['music'].
				' WHERE music_id IN ('.addslashes($sel_music_ids).') AND user_id = '.$this->dbObj->Param('user_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
		if (!$rs)
			trigger_db_error($this->dbObj);

		$row = $rs->FetchRow();
		return $row['music_count']?$row['music_count']:0;
	}


	/**
	 * musicList::populatePlaylist()
	 * playlist details will be passed to tpl
	 *
	 * @return void
	 */
	public function populatePlaylist()
	{
		global $smartyObj;
		$playlist_info = array();
		$playlist_info['playlistUrl']=$this->CFG['site']['music_url'].'musicList.php?ajax_page=true&page=playlist';
		$this->playlist_name_notes = str_replace('VAR_MIN', $this->CFG['fieldsize']['music_playlist_name']['min'], $this->LANG['playlist_name_notes']);
		$this->playlist_name_notes = str_replace('VAR_MAX', $this->CFG['fieldsize']['music_playlist_name']['max'], $this->playlist_name_notes);
		$this->playlist_tags_notes = str_replace('VAR_MIN', $this->CFG['fieldsize']['music_playlist_tags']['min'], $this->LANG['playlist_tags_notes']);
		$this->playlist_tags_notes = str_replace('VAR_MAX', $this->CFG['fieldsize']['music_playlist_tags']['max'], $this->playlist_tags_notes);
		$this->getPlaylistIdInMusic($this->getFormField('music_id'));
		$this->displayCreatePlaylistInterface();
		$smartyObj->assign('playlist_info', $playlist_info);
		$smartyObj->assign('playlist_option', 'music');
		setTemplateFolder('general/','music');
		$smartyObj->display('getPlaylist.tpl');
	}

}
// -------------------- Code begins -------------->>>>>//
$MusicList = new MusicList();
if (!chkAllowedModule(array('music')))
    Redirect2URL($CFG['redirect']['dsabled_module_url']);
$MusicList->setPageBlockNames(array('my_musics_form', 'delete_confirm_form', 'featured_confirm_form',
						'check_all_item', 'form_show_sub_category', 'musiclist_msg_form_error'));

$MusicList->CFG['admin']['musics']['individual_song_play'] = true;

$MusicList->LANG_COUNTRY_ARR = $LANG_LIST_ARR['countries'];
$MusicList->LANG_LANGUAGE_ARR = $LANG_LIST_ARR['language'];
$MusicList->LANG_ALPHABETS_ARR = $LANG_LIST_ARR['alphabets'];
$MusicList->MUSICRUN_LENGTH_ARR = $LANG_LIST_ARR['musicrunlength'];
$MusicList->ADDED_WITHIN_ARR = $LANG_LIST_ARR['added_within_arr'];
$MusicList->setFormField('music_id', '');
$MusicList->setFormField('playlist_id', '');
$MusicList->setFormField('album_id', '');
$MusicList->setFormField('thumb', 'yes');
$MusicList->setFormField('music_ext', '');
$MusicList->setFormField('action', '');
$MusicList->setFormField('action_new', '');
$MusicList->setFormField('act', '');
$MusicList->setFormField('pg', '');
$MusicList->setFormField('default', 'Yes');
$MusicList->setFormField('cid', '');
$MusicList->setFormField('tags', '');
$MusicList->setFormField('mymusic', 'No');
$MusicList->setFormField('myfavoritemusic', 'No');
$MusicList->setFormField('user_id', '0');

/**
 * ********** Page Navigation Start ********
 */
$MusicList->setFormField('start', '0');
$MusicList->setFormField('slno', '1');
$MusicList->setFormField('sid', '');
$MusicList->setFormField('music_ids', array());
$MusicList->setFormField('numpg', $CFG['music_tbl']['numpg']);
//$MusicList->setFormField('numpg', 2);
$condition = '';
$MusicList->setFormField('advanceFromSubmission', '');
$MusicList->setFormField('music_category_name', '');
$MusicList->setFormField('music_language', '');
$MusicList->setFormField('run_length', '');
$MusicList->setFormField('added_within', '');
$MusicList->setFormField('artist', '');
$MusicList->setFormField('advan_music_artist', '');
$MusicList->setFormField('music_title', '');
$MusicList->setFormField('advan_music_title', '');
$MusicList->setFormField('advan_music_user_name', '');
$MusicList->setFormField('music_tags', '');
$MusicList->setFormField('music_album_name', '');
$MusicList->setFormField('advan_music_album_name', '');
$MusicList->setFormField('searchkey', '');
$MusicList->setFormField('titles', '');
$MusicList->setFormField('view', '');
$MusicList->setFormField('rating', '');
$MusicList->setFormField('user_name', '');
$MusicList->setFormField('artist_id', '');
$MusicList->setFormField('artist_name', '');
$MusicList->setFormField('album_id', '');
$MusicList->setFormField('tags', '');
$MusicList->setFormField('musictracker', '');
$MusicList->setFormField('message', '');
$MusicList->setFormField('play_list', '');//  This can be "ql" / "pl". means that Quick List and Play List. When play_list. Need play list id
$MusicList->setFormField('playlist_description', '');
$MusicList->setFormField('playlist_tags', '');
$MusicList->setFormField('allow_comments', 'Yes');
$MusicList->setFormField('allow_embed', 'Yes');
$MusicList->setFormField('allow_ratings', 'Yes');
$MusicList->setFormField('playlist_access_type', 'Public');
$MusicList->setFormField('playlist', '');
$MusicList->setFormField('playlist_id', '');
$MusicList->setFormField('playlist_name', '');
$MusicList->setFormField('page', '');
if($MusicList->getFormField('pg')=='myplaylist')
	{
		$MusicList->setFormField('playlist_id', '');
	}
$MusicList->setFormField('checkbox', array());
$MusicList->recordsFound = false;
$MusicList->setMinRecordSelectLimit($CFG['data_tbl']['min_record_select_limit']);
$MusicList->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$MusicList->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$MusicList->setTableNames(array());
$MusicList->setReturnColumns(array());
/**
 * *********** page Navigation stop ************
 */
$MusicList->setAllPageBlocksHide();
$MusicList->setPageBlockShow('my_musics_form');
$MusicList->sanitizeFormInputs($_REQUEST);

//START TO GENERATE THE PLAYLIST PLAYER ARRAY FIELDS
$music_fields = array(
	'div_id'               => 'flashcontent',
	'music_player_id'      => 'music_list',
	'width'  		       => 1,
	'height'               => 1,
	'auto_play'            => 'false',
	'hidden'               => true,
	'playlist_auto_play'   => false,
	'javascript_enabled'   => true,
	'player_ready_enabled' => true
);

$smartyObj->assign('music_fields',$music_fields);
//END TO GENERATE THE PLAYLIST PLAYER ARRAY FIELDS

if(isset($_REQUEST['action']))
	$MusicList->setFormField('action_new', $_REQUEST['action']);
//unset($_SESSION['user']['add_cart']);
//echo $_SESSION['user']['add_cart'];
$action_new = $MusicList->getFormField('action_new');
$MusicList->setFormField('action', $action_new);
$MusicList->setFormField('artist', $MusicList->getFormField('advan_music_artist'));
$MusicList->setFormField('music_album_name', $MusicList->getFormField('advan_music_album_name'));
$MusicList->setFormField('music_title', $MusicList->getFormField('advan_music_title'));
$MusicList->setFormField('user_name', $MusicList->getFormField('advan_music_user_name'));

if(isset($_GET['titles'])){
	$MusicList->setFormField('titles', $_GET['titles']);
	$_REQUEST['titles'] = $_GET['titles'];
}

if($MusicList->getFormField('default')== 'Yes' && $MusicList->getFormField('pg')== 'musicnew' && $MusicList->getFormField('tags') == '' && $MusicList->getFormField('artist_id') == '')
	$MusicList->setFormField('pg', '');
elseif($MusicList->getFormField('default')== 'No')
	$MusicList->setFormField('pg', (isset($_GET['pg']) && !empty($_GET['pg']))?$_GET['pg']:$_REQUEST['pg']);

if($MusicList->getFormField('pg')== 'mymusics')
	$MusicList->setFormField('mymusic', 'Yes');

if($MusicList->getFormField('pg')== 'myfavoritemusics')
	$MusicList->setFormField('myfavoritemusic', 'Yes');
if($MusicList->getFormField('pg')=='private_music')
{
	$MusicList->setCommonSuccessMsg($LANG['musiclist_private_music']);
	$MusicList->setPageBlockShow('block_msg_form_success');
}
if($MusicList->getFormField('pg')=='invalid_music_id')
{
	$MusicList->setCommonSuccessMsg($LANG['common_msg_invalid_music_id']);
	$MusicList->setPageBlockShow('block_msg_form_success');
}

//ADDED THE ERROR MESSAGE IF NOT ALLOWED THE MUSIC UPLOAD
if($MusicList->getFormField('pg')=='upload_music')
{
	$MusicList->setCommonSuccessMsg($LANG['musiclist_music_upload_error_message']);
	$MusicList->setPageBlockShow('block_msg_form_success');
}
if(!isset($_GET['pg']) && $MusicList->getFormField('default')== 'No')
		$MusicList->setFormField('pg', '');

if(isset($_GET['view']) && !empty($_GET['view']))
	$MusicList->setFormField('view', $_GET['view']);

if(!isMember())
	$MusicList->savePlaylistUrl = $MusicList->is_not_member_url = getUrl('musiclist','?pg=musicnew','musicnew/', 'members','music');
else
	$MusicList->savePlaylistUrl = $CFG['site']['music_url'].'createPlaylist.php?action=save_playlist&light_window=1';

$MusicList->musicmyPlaylistUrl = $CFG['site']['music_url'].'musiclist.php?action=mymusicdelete';
$mymusic_deletelist_arr['music_list_url'] = getUrl('musiclist', '?pg='.$MusicList->getFormField('pg'), $MusicList->getFormField('pg').'/?action=0', '', 'music');
$pgValue = $MusicList->getFormField('pg');
$pgValue = !empty($pgValue)?$pgValue:'musicnew';
$Navigation_arr['music_list_url_0']      = getUrl('musiclist', '?pg='.$pgValue.'&action='.$MusicList->getFormField('action'), $pgValue.'/?action='.$MusicList->getFormField('action'), '', 'music');
$Navigation_list_arr['music_list_url_0'] = getUrl('musiclist', '?pg='.$pgValue, $pgValue.'/?', '', 'music');
$smartyObj->assign('Navigation_arr', $Navigation_list_arr);
$musicActionNavigation_arr['music_list_url_0'] = getUrl('musiclist', '?pg='.$pgValue.'&action=0', $pgValue.'/?action=0', '', 'music');
$musicActionNavigation_arr['music_list_url_1'] = getUrl('musiclist', '?pg='.$pgValue.'&action=1', $pgValue.'/?action=1', '', 'music');
$musicActionNavigation_arr['music_list_url_2'] = getUrl('musiclist', '?pg='.$pgValue.'&action=2', $pgValue.'/?action=2', '', 'music');
$musicActionNavigation_arr['music_list_url_3'] = getUrl('musiclist', '?pg='.$pgValue.'&action=3', $pgValue.'/?action=3', '', 'music');
$musicActionNavigation_arr['music_list_url_4'] = getUrl('musiclist', '?pg='.$pgValue.'&action=4', $pgValue.'/?action=4', '', 'music');
$musicActionNavigation_arr['music_list_url_5'] = getUrl('musiclist', '?pg='.$pgValue.'&action=5', $pgValue.'/?action=5', '', 'music');
$musicActionNavigation_arr['musicMostViewed_0'] = $musicActionNavigation_arr['musicMostViewed_1'] = $musicActionNavigation_arr['musicMostViewed_2'] = $musicActionNavigation_arr['musicMostViewed_3'] = $musicActionNavigation_arr['musicMostViewed_4'] = $musicActionNavigation_arr['musicMostViewed_5'] = '';
if($MusicList->getFormField('pg') == 'musicmostviewed'
	OR $MusicList->getFormField('pg') == 'musicmostdiscussed'
		OR $MusicList->getFormField('pg') == 'musicmostfavorite')
	{
		if(!$MusicList->getFormField('action')) $MusicList->setFormField('action', '0');
		$sub_page = 'musicMostViewed_'.$MusicList->getFormField('action');
		$musicActionNavigation_arr[$sub_page] = ' class="clsActive"';
	}

$smartyObj->assign('musicActionNavigation_arr', $musicActionNavigation_arr);
$musicViewNavigation_arr1=$musicViewNavigation_arr2=$musicViewNavigation_arr3='';

if($MusicList->getFormField('view'))
	{
	if($MusicList->getFormField('view')=='Title')
		{
		  $musicViewNavigation_arr1='clsActive';
		}
		else if($MusicList->getFormField('view')=='Album')
		{
		  $musicViewNavigation_arr2='clsActive';
		}
		else if($MusicList->getFormField('view')=='Artist')
		{
		  $musicViewNavigation_arr3='clsActive';
		}

	}

$smartyObj->assign('musicViewNavigation_arr1', $musicViewNavigation_arr1);
$smartyObj->assign('musicViewNavigation_arr2', $musicViewNavigation_arr2);
$smartyObj->assign('musicViewNavigation_arr3', $musicViewNavigation_arr3);
if($MusicList->getFormField('searchkey'))
	{
		$MusicList->setFormField('artist', $MusicList->getFormField('searchkey'));
		$MusicList->setFormField('avd_search', '1');
		$MusicList->getFormField('artist');
	}
$start = $MusicList->getFormField('start');
if ($MusicList->getFormField('cid') && !$MusicList->getFormField('sid') && $CFG['admin']['musics']['sub_category'])
	{
	    $MusicList->setPageBlockShow('form_show_sub_category');
	}

$memberMusicListCase = array('mymusics','myfavoritemusics','myrecentlyviewedmusic','myalbummusiclist','myplaylist');
if (in_array($MusicList->getFormField('pg'),$memberMusicListCase) AND !isMember())
	{
		Redirect2URL(getUrl('login'));
	}
if ($MusicList->isFormPOSTed($_POST, 'avd_reset'))
	{
		$MusicList->setFormField('artist', '');
		$MusicList->setFormField('music_title', '');
		$MusicList->setFormField('music_tags', '');
		$MusicList->setFormField('music_album_name', '');
		$MusicList->setFormField('music_category_name', '');
		$MusicList->setFormField('music_language', '');
		$MusicList->setFormField('run_length', '');
		$MusicList->setFormField('added_within', '');
		$MusicList->setFormField('advan_music_artist', '');
		$MusicList->setFormField('advan_music_user_name', '');
	}
if ($MusicList->isPageGETed($_GET, 'action'))
	{
		$MusicList->sanitizeFormInputs($_GET);
	}
if($MusicList->getFormField('message'))
{
	$MusicList->includeAjaxHeader();
	$MusicList->setCommonErrorMsg($MusicList->getFormField('message'));
	$MusicList->setPageBlockShow('block_msg_form_error');
	$MusicList->includeAjaxFooter();
}
if($MusicList->getFormField('act') == 'mymusicdelete')
{
	$musics_arr = explode(',', $MusicList->getFormField('music_id'));
	$music_count = $MusicList->getMusicOwnerCount($MusicList->getFormField('music_id'));
	if(!isMember())
	{
		Redirect2URL($MusicList->getCurrentUrl());
	}
	else if($music_count != count($musics_arr))
	{
		$MusicList->setCommonErrorMsg($LANG['musiclist_other_user_music_delete_err_msg']);
		$MusicList->setPageBlockShow('block_msg_form_error');
	}
	else
	{
		$MusicList->myMusicListDelete($musics_arr, $CFG['user']['user_id']);
		$MusicList->setCommonSuccessMsg($LANG['musiclist_delete_succ_msg_confirmation']);
		$MusicList->setPageBlockShow('block_msg_form_success');
	}
}
if($MusicList->getFormField('act') == 'myPlaylistMusicDelete')
	{
		$musics_arr = explode(',', $MusicList->getFormField('music_id'));
		//$MusicList->deleteMyPlaylistMusic($musics_arr, $CFG['user']['user_id']);
	}
if($MusicList->getFormField('act') == 'myFavoriteMusicsDelete')
	{
		$musics_arr = explode(',', $MusicList->getFormField('music_id'));
		$MusicList->myMusicListDelete($musics_arr, $CFG['user']['user_id']);
	}
if ($MusicList->isFormPOSTed($_POST, 'yes'))
{
	if ($MusicList->getFormField('act') == 'delete')
	{
		$musics_arr = explode(',', $MusicList->getFormField('music_id'));
		$music_count = $MusicList->getMusicOwnerCount($MusicList->getFormField('music_id'));
		if($music_count != count($musics_arr))
		{
			$MusicList->setCommonErrorMsg($LANG['musiclist_other_user_music_delete_err_msg']);
			$MusicList->setPageBlockShow('block_msg_form_error');
		}
		else
		{
			$MusicList->deleteMusics($musics_arr, $CFG['user']['user_id']);
			$MusicList->setCommonSuccessMsg($LANG['musiclist_delete_succ_msg_confirmation']);
			$MusicList->setPageBlockShow('block_msg_form_success');
		}
	}
	if ($MusicList->getFormField('act') == 'set_avatar')
		{
			$MusicList->setFeatureThisImage($MusicList->getFormField('music_id'), $CFG['user']['user_id']);
			$MusicList->setPageBlockShow('msg_form_error');
			$MusicList->setCommonErrorMsg($LANG['musiclist_msg_success_set_avatar']);
		}
	if ($MusicList->getFormField('act') == 'favorite_delete')
		{
		$music_id_arr = explode(',', $MusicList->getFormField('music_id'));
		foreach($music_id_arr as $music_id)
			{
				$MusicList->deleteFavoriteMusic($music_id, $CFG['user']['user_id']);
			}
		}
	if ($MusicList->getFormField('act') == 'playlist_delete')
	{
		$music_id_arr = explode(',', $MusicList->getFormField('music_id'));
		foreach($music_id_arr as $music_id)
			{
				$MusicList->deletePlaylistMusic($music_id);
			}
	}
	if ($MusicList->getFormField('act') == 'set_playlist_thumb')
		{
			$music_id = $MusicList->getFormField('music_id');
			$MusicList->setPlaylistThumbnail($music_id);
		}
	if ($MusicList->getFormField('act') == 'set_album_thumb')
		{
			$music_id = $MusicList->getFormField('music_id');
			$album_id = $MusicList->getFormField('album_id');
			$MusicList->updateAlbumProfileImage($music_id, $album_id);
		}
}

$MusicList->category_name = '';
if ($MusicList->isShowPageBlock('form_show_sub_category'))
	{
	    $MusicList->populateSubCategories();
	    $MusicList->category_name = $MusicList->getCategoryName();
	    $MusicList->LANG['musiclist_category_title'] = str_replace('VAR_CATEGORY', $MusicList->category_name, $LANG['musiclist_category_title']);
	}
$MusicList->LANG['musiclist_title'] = $MusicList->getPageTitle();
// generation Detail & Thumb Link
if ($CFG['feature']['rewrite_mode'] != 'normal')
    $thum_details_arr = array('album_id', 'cid', 'tags', 'music_id', 'user_id', 'start', 'action');
else
    $thum_details_arr = array('album_id', 'cid', 'tags', 'user_id', 'music_id', 'start', 'pg', 'action');
$MusicList->showThumbDetailsLinks_arr = $MusicList->showThumbDetailsLinks($thum_details_arr);
if ($MusicList->isShowPageBlock('msg_form_error'))
	{
	    $MusicList->msg_form_error['common_error_msg'] = $MusicList->getCommonErrorMsg();
	}
if ($MusicList->isShowPageBlock('msg_form_success'))
	{
	    $MusicList->msg_form_success['common_error_msg'] = $MusicList->getCommonErrorMsg();
	}

if ($MusicList->isShowPageBlock('my_musics_form'))
	{
	    /**
	     * ***** navigtion continue********
	     */
	    $MusicList->setTableAndColumns();
	    $MusicList->buildSelectQuery();
	    // $MusicList->buildConditionQuery($condition);
	    $MusicList->buildQuery();
	    //$MusicList->printQuery();
	    $group_query_arr = array('myrecentlyviewedmusic','musicmostfavorite','featuredmusiclist','musicmostviewed','musicmostdiscussed','albumlist');


		if (in_array($MusicList->getFormField('pg'), $group_query_arr))
	        $MusicList->homeExecuteQuery();
	    else
	        $MusicList->executeQuery();
	    /**
	     * ****** Navigation End *******
	     */
	    $MusicList->my_musics_form['anchor'] = 'anchor';
	    $MusicList->isResultsFound = $MusicList->isResultsFound();
	    if ($CFG['feature']['rewrite_mode'] != 'normal')
            $paging_arr = array('start','album_id', 'cid', 'tags', 'user_id', 'action', 'thumb','artist','music_language','run_length','music_album_name','added_within','advanceFromSubmission','view', 'music_title', 'artist_id', 'titles', 'mymusic', 'myfavoritemusic');
        else
            $paging_arr = array('start','album_id', 'cid', 'tags', 'user_id', 'pg', 'action', 'thumb','artist','music_language','run_length','music_album_name','added_within','advanceFromSubmission','view', 'music_title', 'artist_id', 'titles', 'mymusic', 'myfavoritemusic');
		$smartyObj->assign('paging_arr',$paging_arr);
	    if ($MusicList->isResultsFound())
			{
		        if ($CFG['feature']['rewrite_mode'] != 'normal')
		            $paging_arr = array('start','album_id', 'cid', 'tags', 'user_id', 'action', 'thumb','artist','music_language','run_length','music_album_name','added_within','advanceFromSubmission','view', 'music_title', 'artist_id', 'titles', 'mymusic', 'myfavoritemusic');
		        else
		            $paging_arr = array('start','album_id', 'cid', 'tags', 'user_id', 'pg', 'action', 'thumb','artist','music_language','run_length','music_album_name','added_within','advanceFromSubmission','view', 'music_title', 'artist_id', 'titles', 'mymusic', 'myfavoritemusic');
		 	    $smartyObj->assign('paging_arr',$paging_arr);
				$smartyObj->assign('smarty_paging_list', $MusicList->populatePageLinksPOST($MusicList->getFormField('start'), 'seachAdvancedFilter'));
		        switch ($MusicList->getFormField('pg'))
					{
			            case 'useralbumlist':
			                if (!$MusicList->isMe($MusicList->ALBUM_USER_ID= $MusicList->chkValidAlbumId()))
			                    break;
			            case 'mymusics':
			                $MusicList->setPageBlockShow('check_all_item');
			                break;
			            case 'myfavoritemusics':
			                $MusicList->setPageBlockShow('check_all_item');
			                break;
			            case 'myplaylist':
			                $MusicList->setPageBlockShow('check_all_item');
			                break;
			        }
		        $MusicList->my_musics_form['showMusicList'] = $MusicList->showMusicList();
				//Initializing Playlist Player Configuaration
				$MusicList->populatePlayerWithPlaylistConfiguration();
				$MusicList->configXmlcode_url .= 'pg=music';
				$MusicList->playlistXmlcode_url .= 'pg=music_0_'.implode(',', $MusicList->player_music_id);
		    }
	}

$MusicList->memberLoginMusicUrl = getUrl('musiclist','?mem_auth=true&pg=musicnew','musicnew/?mem_auth=true', 'members','music');
if(isAjaxPage())
{
	$MusicList->includeAjaxHeaderSessionCheck();
	if ($MusicList->getFormField('action')=='popplaylist')
    {
    	$MusicList->checkLoginStatusInAjax($MusicList->memberLoginMusicUrl);
		$MusicList->populatePlaylist();
		die();
    }
    if($MusicList->getFormField('page') != '')
	{
		if($MusicList->getFormField('page') == 'playlist')
		{
			$MusicList->setAllPageBlocksHide();
			$MusicList->checkLoginStatusInAjax($MusicList->memberLoginMusicUrl);
			# Add music to playlist
			$flag = 1;
			if($MusicList->getFormField('playlist_name')!= '')
			{
				# Check already exist
				if(!$MusicList->chkPlaylistExits('playlist_name', $LANG['viewplaylist_tip_alreay_exists']))
				{
					$flag =0;
					echo $MusicList->getFormFieldErrorTip('playlist_name');
				}
				$subject = str_replace('VAR_MIN', $CFG['fieldsize']['music_playlist_name']['min'], $LANG['viewplaylist_invalid_size']);
				$subject = str_replace('VAR_MAX', $CFG['fieldsize']['music_playlist_name']['max'], $subject);
				if(!$MusicList->chkIsValidSize('playlist_name', 'music_playlist_name', $subject))
				{
					$flag =0;
					echo $MusicList->getFormFieldErrorTip('playlist_name');
				}
			}
			if($MusicList->getFormField('playlist_tags')!= '')
			{
				$subject = str_replace('VAR_MIN', $CFG['fieldsize']['music_playlist_tags']['min'], $LANG['viewplaylist_err_tip_invalid_tag']);
				$subject = str_replace('VAR_MAX', $CFG['fieldsize']['music_playlist_tags']['max'], $subject);
				if(!$MusicList->chkValidTagList('playlist_tags', 'music_playlist_tags', $subject))
				{
					$flag =0;
					echo $MusicList->getFormFieldErrorTip('playlist_tags');
				}
			}

			if($flag)
			{
				if($MusicList->isFormGETed($_POST, 'playlist') && $MusicList->chkIsNotEmpty('playlist',''))
				{
					$playlist_id = $MusicList->getFormField('playlist');
					echo sprintf($LANG['viewplaylist_successfully_msg'],$MusicList->getFormField('playlist_name'));
					echo '#$#'.$playlist_id;
				}
				else
				{
					# Create new playlist
					$playlist_id = $MusicList->createPlaylist();
					$MusicList->playlistCreateActivity($playlist_id);
					echo sprintf($LANG['viewplaylist_successfully_msg'],$MusicList->getFormField('playlist_name'));
					echo '#$#'.$playlist_id;
				}
				# INSERT SONG TO PLAYLIST SONG
				$song_id = explode(',', $MusicList->getFormField('music_id'));
				for($inc=0;$inc<count($song_id);$inc++)
					$MusicList->insertSongtoPlaylist($playlist_id, $song_id[$inc]);
			}
		}
	}

    $MusicList->includeAjaxFooter();
	exit;
}


//$smartyObj->assign('ratingDetatils', $MusicList->populateRatingDetails())?$rating:0;
// include the header file
$MusicList->includeHeader();
?>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/JSFCommunicator.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
<?php
if($MusicList->isResultsFound()){
?>
<script type="text/javascript" language="javascript">
total_musics_to_play = <?php echo count($MusicList->player_music_id); ?>;
<?php
	if(count($MusicList->player_music_id) != 0){
		foreach($MusicList->player_music_id as $music_id_to_play){
			echo 'total_musics_ids_play_arr.push('.$music_id_to_play.');';
		}
	}
?>
</script>
<?php
}
// include the content of the page
setTemplateFolder('general/', 'music');
$smartyObj->display('musicList.tpl');
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

function clearValue(id, default_value)
	{
		//alert(id);
		if($Jq('#' + id).val() == default_value)
		{
			$Jq('#' + id).val('');
		}
	}
function setOldValue(id)
	{

		if (($Jq('#' + id).val() =="") && (id == 'advan_music_artist') )
			$Jq('#' + id).val('<?php echo $LANG['musiclist_artist_cast']?>');
		if (($Jq('#' + id).val() =="") && (id == 'advan_music_album_name') )
			$Jq('#' + id).val('<?php echo $LANG['musiclist_album_name']?>');
		if (($Jq('#' + id).val() =="") && (id == 'advan_music_title') )
			$Jq('#' + id).val('<?php echo $LANG['musiclist_title_field']?>');
		if (($Jq('#' + id).val() =="") && (id == 'music_tags') )
			$Jq('#' + id).val('<?php echo $LANG['musiclist_tags']?>');
		if (($Jq('#' + id).val() =="") && (id == 'advan_music_user_name') )
			$Jq('#' + id).val('<?php echo $LANG['musiclist_user_name']?>');
	}
function loadUrl(element)
	{
		//set the start value as 0 when click the order by field
		document.seachAdvancedFilter.start.value = '0';
		var defaultVal = "<?php echo getUrl('musiclist','pg=musicnew','musicnew/','','music');?>";
		//if(element.value != defaultVal)
			document.getElementById('default').value = 'No';
		document.seachAdvancedFilter.action=element.value;
		document.seachAdvancedFilter.submit();
	}
function jumpAndSubmitForms(path)
	{
		//set the start value as 0 when click the alphabetical letters
		document.seachAdvancedFilter.start.value = '0';
		$path_url='<?php echo $Navigation_list_arr['music_list_url_0']; ?>';
		var url=$path_url+'&titles='+path;
		document.seachAdvancedFilter.action=url;
		document.seachAdvancedFilter.submit();
	}
function jumpAndFormsubmit(path)
	{
		//set the start value as 0 when click the sort by field
		document.seachAdvancedFilter.start.value = '0';
		path_url='<?php echo $Navigation_arr['music_list_url_0']; ?>';
		url=path_url+'&view='+path+'&titles=<?php echo $MusicList->getFormField("titles");?>';
		document.seachAdvancedFilter.action=url;
		document.seachAdvancedFilter.submit();
	}

function popupWindow(url)
	{
			 window.open (url, "","status=0,toolbar=0,resizable=1,scrollbars=1");
			 return false;
	}
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
$MusicList->includeFooter();
?>