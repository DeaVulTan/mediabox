<?php
class photoSearchList extends photoHandler
{
    public $slideShowUrl;
    public $advanceSearch;
    public $album_name;
    /**
     * photoSearchList::getPageTitle()
     *
     * @return
     */
    public function getPageTitle()
    {
	    $pg_title = $this->LANG['photolist_photonew_title'];
		//If default value is Yes then reset the pg value as null.
	    if($this->getFormField('default')== 'Yes' && $this->fields_arr['pg'] == 'photonew')
			$this->fields_arr['pg'] = '';

		$categoryTitle = '';
		$tagsTitle     = '';

        switch ($this->fields_arr['pg'])
		{

            case 'myphotos':
                $pg_title = $this->LANG['photolist_myphotos_title'];
                break;
            case 'myfavoritephotos':
                $pg_title = $this->LANG['photolist_myfavoritephotos_title'];
                break;
            case 'featuredphotolist':
                $pg_title = $this->LANG['photolist_featuredphotolist_title'];
                break;
            case 'phototoprated':
                $pg_title = $this->LANG['photolist_phototoprated_title'];
                break;
            case 'photorecommended':
                $pg_title = $this->LANG['photolist_photorecommended_title'];
                break;
            case 'photomostviewed':
                $pg_title = $this->LANG['photolist_photomostviewed_title'];
                break;
            case 'photomostdiscussed':
                $pg_title = $this->LANG['photolist_photomostdiscussed_title'];
                break;
            case 'photomostfavorite':
                $pg_title = $this->LANG['photolist_photomostfavorite_title'];
                break;
            case 'subscribedphotolist':
            	if (isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule())
                	$pg_title = $this->LANG['common_subscribed_photo'];
                else
                	$pg_title = $this->LANG['photolist_photonew_title'];
                break;
            case 'userphotolist':
                $pg_title = $this->LANG['photolist_userphotolist_title'];
                $fields_list = array('user_name', 'first_name', 'last_name');
                if (!isset($this->UserDetails[$this->fields_arr['user_id']]))
                    $this->getUserDetail('user_id', $this->fields_arr['user_id'], 'user_name');
                $name = $this->getUserDetail('user_id', $this->fields_arr['user_id'], 'user_name');
                $pg_title = str_replace('{user_name}', $name, $pg_title);
                break;
            /*case 'albumphotolist':
                $pg_title = $this->LANG['photolist_albumphotolist_title'];
                $name = $this->getAlbumName();
                $pg_title = str_replace('{album_name}', $name, $pg_title);
                break;*/
            default:

				if ($this->fields_arr['pg'] == 'photorecent')
					$pg_title = $this->LANG['header_nav_photo_photo_new'];
				else
					$pg_title = $this->LANG['photolist_photonew_title'];

                break;
    	}

	  	//change the page title if other user photo is selected
		if($this->fields_arr['pg'] != 'userphotolist' && $this->fields_arr['user_id'] != 0)
		{
			  $members_title = $this->LANG['photolist_userphotolist_title'];
	          $fields_list = array('user_name', 'first_name', 'last_name');
	          if (!isset($this->UserDetails[$this->fields_arr['user_id']]))
	            $this->getUserDetail('user_id', $this->fields_arr['user_id'], 'user_name');
	          $name = $this->getUserDetail('user_id', $this->fields_arr['user_id'], 'user_name');
		      $members_title = str_replace('{user_name}', $name, $members_title);
	          if($this->fields_arr['pg'] == 'photonew' || $this->fields_arr['pg'] == '')
	          	$pg_title = $members_title;
	          else
			  	$pg_title = $pg_title.' '.$this->LANG['in'].' '.$members_title;
	    }

		 //change the page title if my photo is selected
		 if ($this->fields_arr['myphoto'] == 'Yes' && $this->fields_arr['pg'] != 'myphotos')
		 {
		 	$pg_title = $pg_title.' '.$this->LANG['in'].' '.$this->LANG['photolist_myphotos_title'];
		 	if($this->fields_arr['pg'] == 'photonew' || $this->fields_arr['pg'] == '')
		 		$pg_title = $this->LANG['photolist_myphotos_title'];
		 }

		 //change the page title if my favorite is selected
		 if ($this->fields_arr['myfavoritephoto'] == 'Yes' && $this->fields_arr['pg'] != 'myfavoritephotos')
		 {
		 	$pg_title = $pg_title.' '.$this->LANG['in'].' '.$this->LANG['photolist_myfavoritephotos_title'];
		 	if($this->fields_arr['pg'] == 'photonew' || $this->fields_arr['pg'] == '')
		 		$pg_title = $this->LANG['photolist_myfavoritephotos_title'];
		 }

		//change the page title if recored display via category, tags or artist.
		if ($this->fields_arr['cid'] || $this->fields_arr['sid'] )
		{
	        $categoryTitle = $this->LANG['photolist_categoryphoto_title'];
	        if (!$this->category_name)
	            $name = $this->getCategoryName();
	        else
	            $name = $this->category_name;
	        $categoryTitle = str_replace('{category_name}', $name, $categoryTitle);
	    }
		if(($this->fields_arr['pg'] || $this->getFormField('default')== 'Yes') && ($this->fields_arr['cid'] || $this->fields_arr['sid']))
		{
			if($this->fields_arr['pg'] == '' && $this->fields_arr['cid'] == '')
				$pg_title = $categoryTitle;
			else
				$pg_title = $pg_title.' '.$this->LANG['in'].' '.$categoryTitle;
		}

		if ($this->fields_arr['album_id'])
		{
		    $albumTitle = $this->LANG['photolist_album_title'];
		    if (!$this->album_name)
		        $name = $this->getAlbumName();
		    else
		        $name = $this->album_name;
		   $albumTitle = str_replace('{album_name}', $name, $albumTitle);
		}

		if(($this->fields_arr['pg'] || $this->getFormField('default')== 'Yes') && $this->fields_arr['album_id'])
		{
			if($this->fields_arr['pg'] == '')
				$pg_title = $albumTitle;
			else
				$pg_title = $pg_title.' '.$this->LANG['in'].' '.$albumTitle;
		}

		if ($this->fields_arr['tags'])
		{
	        $tagsTitle = $this->LANG['photolist_tagsphoto_title'];
	        $name = $this->fields_arr['tags'];
	        $tagsTitle = str_replace('{tags_name}', $name, $tagsTitle);
	    }
		if(($this->fields_arr['pg'] || $this->getFormField('default')== 'Yes')&& $this->fields_arr['tags'])
		{
			if($this->fields_arr['pg'] == '')
				$pg_title = $tagsTitle;
			else
				$pg_title = $pg_title.' '.$tagsTitle;
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
		if ($this->fields_arr['action'] == 'today' && $this->fields_arr['pg']=='phototoprated')
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
			$search_condition .= ' AND v.photo_category_id = \''.addslashes($this->fields_arr['srch_categories']).'\'';
		}
		if ($this->fields_arr['action'] == 'thisyear')
		{
			$search_condition .= ' AND v.photo_featured = \''.addslashes($this->fields_arr['srch_feature']).'\'';
		}
	 	return $search_condition;
    }

	public function populateRatingDetails($rating)
	{
		$rating = round($rating,0);
		return $rating;
	}
    /**
     * photoSearchList::showThumbDetailsLinks()
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
		$return['url'] = $html_url;
		$return['query_string'] = $query_str;
		return $return;
	}
    /**
     * photoSearchList::showPhotoList()
     *
     * @return
     */
    public function showPhotoList()
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
        //IC: the value is the same even if we are viewing the myphoto pages, no difference
        $this->CFG['admin']['photos']['num_photos_thumb_view_per_rows'] = ($this->fields_arr['pg'] == 'myphotos')?$this->CFG['admin']['photos']['num_photos_thumb_view_per_rows']:$this->CFG['admin']['photos']['num_photos_thumb_view_per_rows'];
        $count = 0;
        $found = false;
        $photos_folder = 'files/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
		$cssImage_folder = $this->CFG['site']['url'].'/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/';
        $fields_list = array('user_name', 'first_name', 'last_name');
        $photoTags = array();
        $return['search_photo_tags'] = $this->LANG['common_tag_title'] . $separator;
        $allow_quick_mixs = (isLoggedIn() and $this->CFG['admin']['photos']['allow_quick_mixs'])?true:false;
        $allow_movie_queue = (isLoggedIn() and $this->CFG['admin']['photos']['movie_maker'])?true:false;
        $this->player_photo_id = array();
        $this->photo_id_arr = array();
        while ($row = $this->fetchResultRecord())
	    {
	    	//print_r($row);
        	$result_arr[$inc]['record']=$row;
        	$result_arr[$inc]['add_quickmix'] = false;
            if ($allow_quick_mixs)
			{
                $result_arr[$inc]['add_quickmix'] = true;
                $result_arr[$inc]['is_quickmix_added'] = false;
                if (rayzzPhotoQuickMix($row['photo_id']))
                    $result_arr[$inc]['is_quickmix_added'] = true;
            }

            $result_arr[$inc]['add_photo_movie_queue'] = false;
            if ($allow_movie_queue)
			{
                $result_arr[$inc]['add_photo_movie_queue'] = true;
                $result_arr[$inc]['is_moviequeue_added'] = false;
                if (checkPhotoInMovieQueue($row['photo_id']))
                    $result_arr[$inc]['is_moviequeue_added'] = true;
            }

		     //IC: we now no longer provide this menu as photonewmale and photonewfemale
	        $need_profile_icon_arr = array('photonewmale', 'photonewfemale');
	        if (in_array($this->fields_arr['pg'], $need_profile_icon_arr))
			{
	            $this->UserDetails[$row['user_id']]['first_name'] = $row['first_name'];
	            $this->UserDetails[$row['user_id']]['last_name'] = $row['last_name'];
	            $this->UserDetails[$row['user_id']]['user_name'] = $row['user_name'];

	            if (!$this->getphotoDetails(array('photo_id', 'date_added', 'NOW() as date_current', 'user_id', '(rating_total/rating_count) as rating', 'total_views','location_recorded', 'photo_server_url', 'photo_ext', 'photo_title', 'photo_tags'), $row['icon_id']))
				{
	                $this->isResultsFound = false;
	                continue;
	            }
				else
				{
	                $this->isResultsFound = true;
	            }
	            $row = array_merge($row, $this->photo_details);
	        }
			$result_arr[$inc]['photo_id'] = $row['photo_id'];
			$result_arr[$inc]['photo_category_id'] = $row['photo_category_id'];
			$result_arr[$inc]['photo_tags'] = $row['photo_tags'];
			$result_arr[$inc]['photo_caption'] = $row['photo_caption'];
	        //$result_arr[$inc]['photo_tags'] = $this->getphotoTags($row['photo_tags']);
	        if(!isset($row['view_date']))
	        $row['view_date']='';
	         if(!isset($row['sum_total_views']))
	        $row['sum_total_views']='';
	        if(!isset($row['sum_total_comments']))
	        $row['sum_total_comments']='';
	        if(!isset($row['sum_total_favorite']))
	        $row['sum_total_favorite']='';
	        $result_arr[$inc]['total_favorite']='';
	        $result_arr[$inc]['sum_total_views'] = $row['sum_total_views'];
	        $result_arr[$inc]['sum_total_comments'] = $row['sum_total_comments'];
	        $result_arr[$inc]['sum_total_favorite'] = $row['sum_total_favorite'];
	        //$result_arr[$inc]['date_added'] = ($row['date_added'] != '') ? getTimeDiffernceFormat($row['date_added']) : '';
	        if(($row['date_added'] != '') && ($row['date_current'] != ''))
	        	$result_arr[$inc]['date_added'] = ($row['date_added'] != '') ? getTimeDiffernceFormat($this->getDateTimeDiff($row['date_added'],$row['date_current'])):'';
	        $result_arr[$inc]['view_date'] = ($row['view_date'] != '') ? getTimeDiffernceFormat($row['view_date']) : '';
	        $result_arr[$inc]['user_id'] = $row['user_id'];
	        $result_arr[$inc]['photo_status'] =$row['photo_status'];
	        $photo_name = getphotoName($row['photo_id']);
	        if($row['photo_status'] == 'Ok' && $row['photo_ext']!='')
	        {
	        	$result_arr[$inc]['img_src'] = $row['photo_server_url'] . $photos_folder .$photo_name.'T.'.$row['photo_ext'];
	        	$result_arr[$inc]['slideshow_img_src'] = $row['photo_server_url'] . $photos_folder .$photo_name.'L.'.$row['photo_ext'];
	        }
	        else
	        {
	        	$result_arr[$inc]['img_src'] = $this->CFG['site']['url'].'photo/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.
									$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_photo_T.jpg';
	        	$result_arr[$inc]['slideshow_img_src'] = $this->CFG['site']['url'].'photo/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.
									$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_photo_T.jpg';
			}
	        $zoom_icon = false;
	        if($row['l_width'] > $this->CFG['admin']['photos']['thumb_width'])
	        	$zoom_icon = true;
	        $result_arr[$inc]['zoom_icon'] = $zoom_icon;
	        if (!in_array($row['user_id'], $userid_arr))
	            $userid_arr[] = $row['user_id'];
	        $view_photo_page_arr = array('myphotos', 'userphotolist');
	        if ($this->fields_arr['pg'] == 'myalbumphotolist')
			{
	            $result_arr[$inc]['photo_album_id'] = $row['photo_album_id'];
	            $result_arr[$inc]['view_photo_link'] = getUrl('viewphoto', '?photo_id=' . $row['photo_id'] . '&title=' . $this->changeTitle($row['photo_title']) . '&album_id=' . $row['photo_album_id'], $row['photo_id'] . '/' . $this->changeTitle($row['photo_title']) . '/?album_id=' . $row['photo_album_id'], '', 'photo');
	        }
			else if (in_array($this->fields_arr['pg'], $view_photo_page_arr))
	            $result_arr[$inc]['view_photo_link'] = getUrl('viewphoto', '?photo_id=' . $row['photo_id'] . '&title=' . $this->changeTitle($row['photo_title']), $row['photo_id'] . '/' . $this->changeTitle($row['photo_title']) . '/', '', 'photo');
			    $this->recordsFound = true;
			$result_arr[$inc]['location_url'] = $this->CFG['site']['photo_url'].'photoList.php?type=add_location&photo_id='.$row['photo_id'];
	        $result_arr[$inc]['anchor'] = 'dAlt_' . $row['photo_id'];
			$result_arr[$inc]['anchor_id'] = 'dAlt_' . $row['photo_id'];
			//$result_arr[$inc]['delete_photo_title']=$row['photo_title'];
			$deletephotoTagsTitle = $this->LANG['photolist_delete_msg_confirmation'];
			$deletephotoName = $row['photo_title'];
			$deletephotoTagsTitle = str_replace('{photo_name}', $deletephotoName, $deletephotoTagsTitle);
			$result_arr[$inc]['delete_photo_title'] = $deletephotoTagsTitle;
	        //$return['photosPerRow'] = $photosPerRow;
	        $return['count'] = $count;
	        // # Assigning Variable in array
	        if ((is_array($this->fields_arr['photo_ids'])) && (in_array($row['photo_id'], $this->fields_arr['photo_ids'])))
	            $result_arr[$inc]['checked'] = 'checked';
	        else
	            $result_arr[$inc]['checked'] = '';

			$result_arr[$inc]['photoupload_url'] = getUrl('photouploadpopup', '?photo_id=' . $row['photo_id'], $row['photo_id'] . '/', '', 'photo');
	        $result_arr[$inc]['callAjaxGetCode_url'] = $this->CFG['site']['photo_url'] . '' . 'viewPhoto.php?photo_id=' . $row['photo_id'] . '&ajax_page=true&page=getcode';
	        if ($this->fields_arr['pg'] == 'myalbumphotolist')
	            $result_arr[$inc]['setProfileImageUrl'] = $this->CFG['site']['photo_url'] . '' . 'photoList.php?photo_id=' . $row['photo_id'] . '&album_id=' . $row['photo_album_id'] . '&ajax_page=true&act=set_album_thumb';
	        if ($this->fields_arr['pg'] == 'myplylist')
	            $result_arr[$inc]['deletePlaylistUrl'] = $this->CFG['site']['photo_url'] . '' . 'listenphoto.php?photo_id=' . $row['photo_id'] . '&playlist_id=' . $this->fields_arr['playlist_id'] . '&ajax_page=true&page=removePlaylistphoto';
	        $tags = '';
	        if ($this->fields_arr['pg'] != 'albumlist')
			{
	            $result_arr[$inc]['view_photo_link'] = getUrl('viewphoto', '?photo_id=' . $row['photo_id'] . '&title=' . $this->changeTitle($row['photo_title']), $row['photo_id'] . '/' . $this->changeTitle($row['photo_title']) . '/', '', 'photo');
	            $result_arr[$inc]['photo_title'] = $row['photo_title'];
	            $result_arr[$inc]['total_views'] = $row['total_views'];

	            $search_word= '';
	            if($this->fields_arr['photo_title']!='' && $this->fields_arr['photo_title']!=$this->LANG['photolist_title_field'])
					$search_word=$this->fields_arr['photo_title'];
				elseif($this->fields_arr['tags']!='' && $this->fields_arr['tags']!=$this->LANG['photolist_tags'])
					$search_word=$this->fields_arr['tags'];
				if($row['location_recorded'])
					$result_arr[$inc]['location_recorded_url'] = $this->CFG['site']['photo_url'].'photoList.php?type=view_location_photos&photo_location_recorded='.$row['location_recorded'];
				$result_arr[$inc]['location_recorded_word_wrap'] =highlightWords($row['location_recorded'], $this->fields_arr['location']);
				$result_arr[$inc]['photo_location_lat'] =$row['google_map_latitude'];
				$result_arr[$inc]['photo_location_lan'] =$row['google_map_longtitude'];
				$result_arr[$inc]['photo_title_word_wrap_not_highlight'] = $row['photo_title'];
	            $result_arr[$inc]['photo_title_word_wrap'] = highlightWords($row['photo_title'],$search_word);
	           	$result_arr[$inc]['viewphoto_url'] = getUrl('viewphoto', '?photo_id='.$row['photo_id'].'&title='.$this->changeTitle($row['photo_title']), $row['photo_id'].'/'.$this->changeTitle($row['photo_title']).'/', '', 'photo');
				$result_arr[$inc]['photo_category_link'] = getUrl('photolist', '?pg=photonew&cid=' . $row['photo_category_id'], 'photonew/?cid=' . $row['photo_category_id'], '', 'photo');
				$result_arr[$inc]['photo_category_name_word_wrap'] = $row['photo_category_name'];
				$result_arr[$inc]['photo_description_word_wrap'] = highlightWords($row['photo_caption'],$search_word);
				$result_arr[$inc]['photo_description_word_wrap_js'] = addslashes($row['photo_title']);
				$this->photo_id_arr[$inc]=$row['photo_id'];
				$tags = $this->_parse_tags($row['photo_tags']);
	            $result_arr[$inc]['rating'] = round($row['rating']);
	            $result_arr[$inc]['total_rating'] = $row['rating_count'];



	        }

	        switch ($this->fields_arr['pg'])
			{
	            case 'photomostdiscussed':
	                $result_arr[$inc]['total_comments'] = $row['total_comments'];
	                break;
	            case 'photomostfavorite':
	                $result_arr[$inc]['sum_total_favorite'] = $row['sum_total_favorite'];
	                break;
	            case 'featuredphotolist':
	                $result_arr[$inc]['total_featured'] = $row['total_featured'];
	                break;
	        }

	        if ($tags)
			 {
	            $i = 0;
	            foreach($tags as $key => $value)
				 {
	                if ($this->CFG['admin']['photos']['tags_count_list_page'] == $i)
	                    break;
	                $value = strtolower($value);
	                if (!in_array($value, $tag) AND !in_array($value, $relatedTags))
	                    $relatedTags[] = $value;
	                if (!in_array($value, $photoTags))
	                    $photoTags[] = $value;
	                $result_arr[$inc]['tag'][$value] = getUrl('photolist', '?pg=photonew&tags=' . $value, 'photonew/?tags=' . $value, '', 'photo');
	                $i++;
	            }
	        }
			else
			{
		    	$result_arr[$inc]['tag'][] = '';
	        }
			$result_arr[$inc]['viewphoto_rating_member_url'] = getUrl('viewphoto', '?photo_id=' . $row['photo_id'] . '&title=' . $this->changeTitle($row['photo_title']), $row['photo_id'] . '/' . $this->changeTitle($row['photo_title']) . '/', 'members', 'photo');
	        $inc++;
	    }

		$user_ids = implode(',', $userid_arr);
	    $this->getMultiUserDetails($user_ids, $fields_list);
	    if ($this->fields_arr['tags'])
	        $this->updatephotoTagDetails($photoTags);
		$smartyObj->assign('photo_list_result', $result_arr);
	    return $return;
    }

	public function myphotoCondition()
	{
		if($this->fields_arr['user_id'] != '0')
			$userCondition = ' p.user_id = '.$this->fields_arr['user_id'].' ';
		elseif($this->fields_arr['myphoto'] != 'No')
			$userCondition = ' p.user_id = '.$this->CFG['user']['user_id'].' ';
		else
			$userCondition = 'p.user_id = '.  $this->CFG['user']['user_id'] . ' OR p.photo_access_type = \'Public\'' . $this->getAdditionalQuery('p.');
		return $userCondition;
	}
    /**
     * photoSearchList::setTableAndColumns()
     *
     * @return
     */
    public function setTableAndColumns()
    {
        if (!isMember())
		{
            $not_allowed_arr = array('myphotos', 'myfavoritephotos', 'myrecentlyviewedphoto');
            if (in_array($this->fields_arr['pg'], $not_allowed_arr))
                $this->fields_arr['pg'] = 'photonew';
        }
		$search_condition = $this->getSearchCondition();

		if($this->fields_arr['advance_keyword'] && $this->fields_arr['advance_keyword']!=$this->LANG['photolist_keyword_field'])
		$this->fields_arr['tags']=$this->fields_arr['advance_keyword'];

       switch ($this->fields_arr['pg'])
	   {
			case 'pending':
				$this->setTableNames(array($this->CFG['db']['tbl']['photo'].' AS p JOIN ' . $this->CFG['db']['tbl']['users'] . ' AS u ON p.user_id = u.user_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON ( pa.photo_album_id =p.photo_album_id OR p.photo_album_id=0 ) '.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =p.photo_category_id'));
				$this->setReturnColumns(array('p.photo_id', 'p.photo_album_id', 'p.photo_ext','p.photo_title', 'p.photo_caption', 'p.photo_server_url', 'p.date_added', 'NOW() as date_current', 'p.user_id','u.user_name', 'p.photo_status', '(p.rating_total/p.rating_count) as rating', 'p.photo_tags','p.rating_count', 'p.total_views', 'p.location_recorded', 'p.google_map_latitude', 'p.google_map_longtitude','p.total_comments','p.total_favorites','mc.photo_category_name','pa.photo_album_title','p.photo_category_id', 'p.allow_ratings'));
				$this->sql_condition = 'p.user_id=\'' . $this->CFG['user']['user_id'] . '\' AND u.usr_status=\'Ok\' AND step_status=\'Step1\'';
				$this->sql_sort = 'p.photo_id DESC';
			break;
			case 'myphotos':
				$this->setTableNames(array($this->CFG['db']['tbl']['photo'].' AS p JOIN ' . $this->CFG['db']['tbl']['users'] . ' AS u ON p.user_id = u.user_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON ( pa.photo_album_id =p.photo_album_id OR p.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =p.photo_category_id'));
				$this->setReturnColumns(array('p.photo_id', 'p.photo_album_id', 'p.photo_ext', 'p.l_width', 'p.location_recorded', 'p.google_map_latitude', 'p.google_map_longtitude', 'p.google_map_latitude', 'p.google_map_longtitude', 'p.google_map_latitude', 'p.google_map_longtitude', 'p.photo_title', 'p.photo_caption', 'p.photo_server_url', 'p.date_added', 'NOW() as date_current', 'p.user_id','u.user_name', '(p.rating_total/p.rating_count) as rating', 'p.total_views', 'p.photo_tags', 'p.photo_status', 'TIMEDIFF(NOW(), p.last_view_date) as last_view_date', 'p.photo_tags','pa.photo_album_title','mc.photo_category_name','p.rating_count','p.total_comments','p.total_favorites','p.photo_category_id', 'p.allow_ratings'));
				$album_extra_query='';
				$tags_extra_query='';
				$this->sql_sort = 'p.date_added DESC';
				if ($this->fields_arr['album_id'])
				{
					$album_extra_query .= '(pa.photo_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
				}
				if ($this->fields_arr['tags'])
				{
				  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_caption', '').') AND ';
				}
				$this->sql_condition = $album_extra_query.$tags_extra_query. 'p.user_id=\'' . $this->CFG['user']['user_id'] . '\' AND ( p.photo_status=\'Ok\' OR p.photo_status=\'Locked\' ) AND u.usr_status=\'Ok\'' . $this->advancedFilters().$this->searchTitleFilters();
			break;
			case 'myfavoritephotos':
				$this->setTableNames(array($this->CFG['db']['tbl']['photo_favorite'] . ' AS f LEFT JOIN ' . $this->CFG['db']['tbl']['photo'] . ' AS p ON f.photo_id=p.photo_id'.' JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON ( pa.photo_album_id =p.photo_album_id OR p.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =p.photo_category_id'.', '.$this->CFG['db']['tbl']['users'] . ' AS u'));
				$this->setReturnColumns(array('p.photo_id', 'p.photo_album_id', 'p.location_recorded', 'p.google_map_latitude', 'p.google_map_longtitude','p.user_id','u.user_name' ,'p.photo_ext', 'p.l_width','p.photo_access_type', 'p.relation_id', 'p.photo_title', 'photo_caption', 'p.photo_server_url', 'p.date_added', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'photo_tags', 'photo_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date','p.photo_tags','pa.photo_album_title','mc.photo_category_name','p.rating_count','p.total_comments','p.total_favorites','p.photo_category_id', 'p.allow_ratings'));
				$album_extra_query='';
				$tags_extra_query='';
				$this->sql_sort = 'photo_favorite_id DESC';
				if ($this->fields_arr['album_id'])
				{
					$album_extra_query .= '(pa.photo_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
				}
				if ($this->fields_arr['tags'])
				{
				  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_caption', '').') AND ';
				}
				$this->sql_condition = $album_extra_query.$tags_extra_query. 'f.user_id=' . $this->CFG['user']['user_id'] . $this->getAdultQuery('p.', 'photo') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND p.photo_status=\'Ok\' ' . $this->advancedFilters().$this->searchTitleFilters();
			break;
			case 'myrecentlyviewedphoto':
				$this->setTableNames(array($this->CFG['db']['tbl']['photo_viewed'] . ' AS pv LEFT JOIN ' . $this->CFG['db']['tbl']['photo'] . ' AS p ON pv.photo_id=p.photo_id'.' JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON ( pa.photo_album_id =p.photo_album_id OR p.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =p.photo_category_id'.', '.$this->CFG['db']['tbl']['users'] . ' AS u '));
				$this->setReturnColumns(array('p.photo_id', 'p.photo_album_id', 'p.location_recorded', 'p.google_map_latitude', 'p.google_map_longtitude', 'p.l_width', 'p.user_id','u.user_name', 'p.photo_ext','p.photo_access_type', 'p.relation_id', 'p.photo_title', 'photo_caption', 'p.photo_server_url', 'p.date_added', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'photo_tags', 'photo_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date', 'p.photo_tags','pa.photo_album_title','mc.photo_category_name','p.rating_count','p.total_comments','p.total_favorites','p.photo_category_id', 'p.allow_ratings'));
				$album_extra_query='';
				$tags_extra_query='';
				$this->sql_sort = 'photo_viewed_id DESC';
				if ($this->fields_arr['album_id'])
				{
					$album_extra_query .= '(pa.photo_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
				}
				if ($this->fields_arr['tags'])
				{
				  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_caption', '').') AND ';
				}
				$this->sql_condition = $album_extra_query.$tags_extra_query. 'pv.user_id=' . $this->CFG['user']['user_id'] . $this->getAdultQuery('p.', 'photo') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND p.photo_status=\'Ok\' AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.photo_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ') ' . $this->advancedFilters() .$this->searchTitleFilters(). ' GROUP BY pv.photo_id';
			break;
			case 'featuredphotolist':
				if($this->fields_arr['myfavoritephoto'] == 'No')
					$this->setTableNames(array($this->CFG['db']['tbl']['photo_featured'] . ' AS f LEFT JOIN ' . $this->CFG['db']['tbl']['photo'] . ' AS p ON f.photo_id=p.photo_id'. ' JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON ( pa.photo_album_id =p.photo_album_id OR p.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =p.photo_category_id'.', '.$this->CFG['db']['tbl']['users'] . ' AS u '. ' , '.$this->CFG['db']['tbl']['photo_files_settings'].' AS vfs'));
				else
					$this->setTableNames(array($this->CFG['db']['tbl']['photo_featured'] . ' AS f LEFT JOIN ' . $this->CFG['db']['tbl']['photo'] . ' AS p ON f.photo_id=p.photo_id'. ' JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON ( pa.photo_album_id =p.photo_album_id OR p.photo_album_id=0 )'.' LEFT JOIN '.$this->CFG['db']['tbl']['photo_favorite'].' AS pf ON pf.photo_id=p.photo_id JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =p.photo_category_id'.', '.$this->CFG['db']['tbl']['users'] . ' AS u '. ' , '.$this->CFG['db']['tbl']['photo_files_settings'].' AS vfs'));

				$this->setReturnColumns(array('p.photo_id', 'p.photo_album_id', 'p.location_recorded', 'p.google_map_latitude', 'p.google_map_longtitude', 'p.l_width', 'p.user_id','u.user_name', 'p.photo_ext','p.photo_access_type', 'p.relation_id', 'p.photo_title', 'photo_caption', 'p.photo_server_url', 'p.t_width', 'p.t_height', 'p.date_added', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'photo_tags', 'photo_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date',  'count(photo_featured_id) as total_featured', 'p.photo_tags','file_name','pa.photo_album_title','mc.photo_category_name','p.rating_count','p.total_comments','p.total_favorites','p.photo_category_id', 'p.allow_ratings'));
				$album_extra_query='';
				$tags_extra_query='';
				$this->sql_sort = 'photo_featured_id DESC';
				if ($this->fields_arr['album_id'])
				{
					$album_extra_query .= '(pa.photo_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
				}
				if ($this->fields_arr['tags'])
				{
				 	$tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_caption', '').') AND ';
				}
				if($this->fields_arr['myfavoritephoto'] == 'No')
					$this->sql_condition =$album_extra_query.$tags_extra_query.  ' p.photo_status=\'Ok\' ' . $this->getAdultQuery('p.', 'photo') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND ( ' . $this->myphotoCondition() . ' ) ' . $this->advancedFilters() .$this->searchTitleFilters(). ' GROUP BY f.photo_id';
				else
					$this->sql_condition =$album_extra_query.$tags_extra_query.  ' pf.user_id=' . $this->CFG['user']['user_id'] .' AND p.photo_status=\'Ok\' ' . $this->getAdultQuery('p.', 'photo') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' ' . $this->advancedFilters() .$this->searchTitleFilters(). ' GROUP BY f.photo_id';
			break;
			case 'phototoprated':
				if($this->fields_arr['myfavoritephoto'] == 'No')
					$this->setTableNames(array($this->CFG['db']['tbl']['photo'].' AS p JOIN ' . $this->CFG['db']['tbl']['users'] . ' AS u ON p.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON ( pa.photo_album_id =p.photo_album_id OR p.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =p.photo_category_id'));
				else
					$this->setTableNames(array($this->CFG['db']['tbl']['photo_favorite'] . ' AS f LEFT JOIN ' .$this->CFG['db']['tbl']['photo'] . ' AS p ON f.photo_id=p.photo_id'.' JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON ( pa.photo_album_id =p.photo_album_id OR p.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =p.photo_category_id'.', '.$this->CFG['db']['tbl']['users'] . ' AS u '));

				$this->setReturnColumns(array('p.photo_id', 'p.photo_album_id', 'p.location_recorded', 'p.google_map_latitude', 'p.google_map_longtitude', 'p.l_width', 'p.user_id', 'u.user_name','p.photo_ext','p.photo_access_type', 'p.relation_id', 'p.photo_title', 'p.photo_caption', 'p.photo_server_url', 'p.t_width', 'p.t_height', 'p.date_added', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'p.photo_tags', 'p.photo_status', 'TIMEDIFF(NOW(), p.last_view_date) as last_view_date', 'p.photo_tags','pa.photo_album_title','mc.photo_category_name','p.rating_count','p.total_comments','p.total_favorites','p.photo_category_id', 'p.allow_ratings'));
				$additional_query = '';
				$album_extra_query='';
				$tags_extra_query='';
				if ($this->fields_arr['cid'])
				{
				$additional_query .= '(p.photo_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';
					if ($this->fields_arr['sid'])
						$additional_query .= '(p.photo_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
				}

				$this->sql_sort = 'rating DESC';
				if ($this->fields_arr['album_id'])
				{
					$album_extra_query .= '(pa.photo_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
				}
				if ($this->fields_arr['tags'])
				{
				  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_caption', '').') AND ';
				}
				if($this->fields_arr['myfavoritephoto'] == 'No')
					$this->sql_condition = $additional_query .$album_extra_query.$tags_extra_query.  'p.photo_status=\'Ok\'' . $this->getAdultQuery('p.', 'photo') . ' AND u.usr_status=\'Ok\' AND ( ' . $this->myphotoCondition() . ') AND p.rating_total>0 AND p.allow_ratings=\'Yes\'' . $this->advancedFilters().$search_condition.$this->searchTitleFilters();
				else
					$this->sql_condition = $additional_query .$album_extra_query.$tags_extra_query. 'f.user_id=' . $this->CFG['user']['user_id'] . $this->getAdultQuery('p.', 'photo') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND p.photo_status=\'Ok\' AND p.rating_total>0 AND p.allow_ratings=\'Yes\'' . $this->advancedFilters().$search_condition.$this->searchTitleFilters();
			break;
			case 'photomostviewed':
				if($this->fields_arr['myfavoritephoto'] == 'No')
					$this->setTableNames(array($this->CFG['db']['tbl']['photo_viewed'] . ' AS vp LEFT JOIN ' . $this->CFG['db']['tbl']['photo'] . ' AS p ON vp.photo_id=p.photo_id'.' JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON ( pa.photo_album_id =p.photo_album_id OR p.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =p.photo_category_id'.','.$this->CFG['db']['tbl']['users'] . ' AS u '. ','.$this->CFG['db']['tbl']['photo_files_settings'].' AS VFS'));
				else
					$this->setTableNames(array($this->CFG['db']['tbl']['photo_favorite'] . ' AS f LEFT JOIN ' .$this->CFG['db']['tbl']['photo'] . ' AS p ON f.photo_id=p.photo_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['photo_viewed'] . ' AS vp ON vp.photo_id=p.photo_id'.' JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON ( pa.photo_album_id =p.photo_album_id OR p.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =p.photo_category_id'. ' , '.$this->CFG['db']['tbl']['users'] . ' AS u '.','.$this->CFG['db']['tbl']['photo_files_settings'].' AS VFS'));

				$this->setReturnColumns(array('p.photo_id', 'p.photo_album_id', 'p.location_recorded', 'p.google_map_latitude', 'p.google_map_longtitude', 'p.l_width', 'p.user_id','u.user_name', 'p.photo_ext','p.photo_access_type', 'p.relation_id', 'p.photo_title', 'photo_caption', 'p.photo_server_url', 'p.date_added', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'photo_tags', 'photo_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date','TIMEDIFF(NOW(), view_date) as view_date', 'SUM(vp.total_views) as sum_total_views', 'vp.total_views as individual_total_views', 'p.photo_tags','pa.photo_album_title','mc.photo_category_name','p.rating_count','p.total_comments','p.total_favorites','p.photo_category_id', 'p.allow_ratings'));
				$additional_query = '';
				$album_extra_query='';
				$tags_extra_query='';
				if ($this->fields_arr['cid'])
				{
					$additional_query .= '(p.photo_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';
					if ($this->fields_arr['sid'])
						$additional_query .= '(p.photo_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
				}
				$this->sql_sort = 'sum_total_views DESC';
				if ($this->fields_arr['album_id'])
				{
					$album_extra_query .= '(pa.photo_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
				}
				if ($this->fields_arr['tags'])
				{
				  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_caption', '').') AND ';
				}
				if($this->fields_arr['myfavoritephoto'] == 'No')
					$this->sql_condition = $additional_query .$album_extra_query.$tags_extra_query.  'p.photo_status=\'Ok\' ' . $this->getAdultQuery('p.', 'photo') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND p.total_views>0 AND ( ' . $this->myphotoCondition() . ' )' . $this->getMostViewedExtraQuery() . '' . $this->advancedFilters() .$this->searchTitleFilters(). ' GROUP BY vp.photo_id';
				else
					$this->sql_condition = $additional_query .$album_extra_query.$tags_extra_query. 'f.user_id=' . $this->CFG['user']['user_id'] .$this->getAdultQuery('p.', 'photo') . ' AND p.photo_status=\'Ok\' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND p.total_views>0 ' . $this->getMostViewedExtraQuery() . '' . $this->advancedFilters() .$this->searchTitleFilters(). ' GROUP BY vp.photo_id';

			break;
			case 'photomostdiscussed':
				if($this->fields_arr['myfavoritephoto'] == 'No')
					$this->setTableNames(array($this->CFG['db']['tbl']['photo'] . ' AS p JOIN ' . $this->CFG['db']['tbl']['photo_comments'] . ' AS pc ON p.photo_id = pc.photo_id '. ' JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON ( pa.photo_album_id =p.photo_album_id OR p.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =p.photo_category_id'.', ' . $this->CFG['db']['tbl']['users'] . ' AS u '. ' , '.$this->CFG['db']['tbl']['photo_files_settings'].' AS vfs'));
				else
					$this->setTableNames(array($this->CFG['db']['tbl']['photo_favorite'] . ' AS f LEFT JOIN ' .$this->CFG['db']['tbl']['photo'] . ' AS p ON f.photo_id=p.photo_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['photo_comments'] . ' AS pc ON p.photo_id = pc.photo_id '. ' JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON ( pa.photo_album_id =p.photo_album_id OR p.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =p.photo_category_id'. ' , ' . $this->CFG['db']['tbl']['users'] . ' AS u '. ' , '.$this->CFG['db']['tbl']['photo_files_settings'].' AS VFS'));

				$this->setReturnColumns(array('p.photo_id', 'p.photo_album_id', 'p.location_recorded', 'p.google_map_latitude', 'p.google_map_longtitude', 'p.l_width', 'p.user_id','u.user_name', 'p.photo_ext','p.photo_access_type', 'p.relation_id', 'p.photo_title', 'photo_caption', 'p.photo_server_url', 'p.date_added', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'photo_tags', 'photo_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date', 'count( pc.photo_comment_id ) as sum_total_comments', 'p.photo_tags','pa.photo_album_title','mc.photo_category_name','p.rating_count','p.total_comments','p.total_favorites','p.photo_category_id', 'p.allow_ratings'));
				$additional_query = '';
				$album_extra_query='';
				$tags_extra_query='';
				if ($this->fields_arr['cid'])
				{
					$additional_query .= '(p.photo_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';
					if ($this->fields_arr['sid'])
						$additional_query .= '(p.photo_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
				}
				$this->sql_sort = ' sum_total_comments DESC, total_views DESC';
				if ($this->fields_arr['album_id'])
				{
					$album_extra_query .= '(pa.photo_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
				}
				if ($this->fields_arr['tags'])
				{
				  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_caption', '').') AND ';
				}
				if($this->fields_arr['myfavoritephoto'] == 'No')
					$this->sql_condition = $additional_query .$album_extra_query.$tags_extra_query.  'p.total_comments>0 AND photo_status = \'Ok\' ' . $this->getMostDiscussedExtraQuery() . $this->getAdultQuery('p.', 'photo') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND ( ' . $this->myphotoCondition() . ' ) AND comment_status=\'Yes\' ' . $this->advancedFilters() .$this->searchTitleFilters(). ' GROUP BY pc.photo_id';
				else
					$this->sql_condition = $additional_query .$album_extra_query.$tags_extra_query. 'p.total_comments>0 AND f.user_id=' . $this->CFG['user']['user_id'].$this->getMostDiscussedExtraQuery() . $this->getAdultQuery('p.', 'photo') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND p.photo_status=\'Ok\' AND comment_status=\'Yes\' ' . $this->advancedFilters() .$this->searchTitleFilters(). ' GROUP BY pc.photo_id';
			break;
			case 'photomostfavorite':
				if($this->fields_arr['myfavoritephoto'] == 'No')
					$this->setTableNames(array($this->CFG['db']['tbl']['photo'] . ' AS p JOIN ' . $this->CFG['db']['tbl']['photo_favorite'] . ' AS pf ON p.photo_id = pf.photo_id'. ' JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON ( pa.photo_album_id =p.photo_album_id OR p.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =p.photo_category_id'.', '.$this->CFG['db']['tbl']['users'] . ' AS u '. ' , '.$this->CFG['db']['tbl']['photo_files_settings'].' AS vfs'));
				else
					$this->setTableNames(array($this->CFG['db']['tbl']['photo_favorite'] . ' AS pf LEFT JOIN ' .$this->CFG['db']['tbl']['photo'] . ' AS p ON pf.photo_id=p.photo_id'. ' JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON ( pa.photo_album_id =p.photo_album_id OR p.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =p.photo_category_id'. ' , ' . $this->CFG['db']['tbl']['users'] . ' AS u '. ' , '.$this->CFG['db']['tbl']['photo_files_settings'].' AS vfs'));

				$this->setReturnColumns(array('p.photo_id', 'p.photo_album_id', 'p.location_recorded', 'p.google_map_latitude', 'p.google_map_longtitude', 'p.l_width', 'p.user_id','u.user_name', 'p.photo_ext','p.photo_access_type', 'p.relation_id', 'p.photo_title', 'photo_caption', 'p.photo_server_url', 'p.date_added', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'photo_tags', 'photo_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date', 'count( pf.photo_favorite_id ) as sum_total_favorite', 'p.photo_tags','pa.photo_album_title','mc.photo_category_name','p.rating_count','p.total_comments','p.total_favorites','p.photo_category_id', 'p.allow_ratings'));
				$additional_query = '';
				$album_extra_query='';
				$tags_extra_query='';
				if ($this->fields_arr['cid'])
				{
					$additional_query .= '(p.photo_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';
					if ($this->fields_arr['sid'])
					$additional_query .= '(p.photo_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
				}
				$this->sql_sort = ' sum_total_favorite DESC, total_views DESC';
				if ($this->fields_arr['album_id'])
				{
					$album_extra_query .= '(pa.photo_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
				}
				if ($this->fields_arr['tags'])
				{
				  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_caption', '').') AND ';
				}
				if($this->fields_arr['myfavoritephoto'] == 'No')
					$this->sql_condition = $additional_query .$album_extra_query.$tags_extra_query.  'photo_status = \'Ok\' ' . $this->getMostFavoriteExtraQuery() . $this->getAdultQuery('p.', 'photo') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND ( ' . $this->myphotoCondition() . ' )' . $this->advancedFilters() .$this->searchTitleFilters(). ' GROUP BY pf.photo_id';
				else
					$this->sql_condition = $additional_query .$album_extra_query.$tags_extra_query. ' pf.user_id=' . $this->CFG['user']['user_id']. ' AND p.photo_status = \'Ok\' ' . $this->getMostFavoriteExtraQuery() . $this->getAdultQuery('p.', 'photo') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' ' . $this->advancedFilters() .$this->searchTitleFilters(). ' GROUP BY pf.photo_id';
			break;
			case 'userphotolist':
				$this->setTableNames(array($this->CFG['db']['tbl']['photo'].' AS p JOIN ' . $this->CFG['db']['tbl']['users'] . ' AS u on p.user_id = u.user_id'. ' JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON ( pa.photo_album_id =p.photo_album_id OR p.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =p.photo_category_id'));
				$this->setReturnColumns(array('p.photo_id', 'p.photo_album_id', 'p.location_recorded', 'p.google_map_latitude', 'p.google_map_longtitude', 'p.l_width', 'p.user_id','u.user_name', 'p.photo_ext','p.photo_access_type', 'p.relation_id', 'p.photo_title', 'photo_caption', 'p.photo_server_url', 'p.date_added', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'photo_tags', 'photo_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date', 'p.photo_tags','pa.photo_album_title','mc.photo_category_name','p.rating_count','p.total_comments','p.total_favorites','p.photo_category_id', 'p.allow_ratings'));
				$album_extra_query='';
				$tags_extra_query='';
				$this->sql_sort = 'photo_id DESC';

				if ($this->fields_arr['album_id'])
				{
					$album_extra_query .= '(pa.photo_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
				}
				if ($this->fields_arr['tags']){
				  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_caption', '').') AND ';
				}
				$this->sql_condition =$album_extra_query.$tags_extra_query.  'p.user_id=\'' . addslashes($this->fields_arr['user_id']) . '\'' . $this->getAdultQuery('p.', 'photo') . ' AND u.usr_status=\'Ok\' AND p.photo_status=\'Ok\' ' . $this->advancedFilters().$this->searchTitleFilters();

			break;
			case 'photomostresponded':
				$this->setTableNames(array($this->CFG['db']['tbl']['photo'].' AS p JOIN ' . $this->CFG['db']['tbl']['users'] . ' AS u ON p.user_id = u.user_id'. ' JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON ( pa.photo_album_id =p.photo_album_id OR p.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =p.photo_category_id'));
				$this->setReturnColumns(array('p.photo_id', 'p.photo_album_id', 'p.location_recorded', 'p.google_map_latitude', 'p.google_map_longtitude', 'p.l_width', 'p.user_id','u.user_name', 'p.photo_ext','p.photo_access_type', 'p.relation_id', 'p.photo_title', 'photo_caption', 'p.photo_server_url', 'p.date_added', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'photo_tags', 'photo_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date',  'p.photo_tags','pa.photo_album_title','mc.photo_category_name','p.rating_count','p.total_comments','p.total_favorites','p.photo_category_id', 'p.allow_ratings'));
				$additional_query = '';
				$album_extra_query='';
				$tags_extra_query='';
				if ($this->fields_arr['cid'])
				{
					$additional_query .= '(p.photo_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';
					if ($this->fields_arr['sid'])
						$additional_query .= '(p.photo_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
				}
				$this->sql_sort = 'photo_tags ';
				if ($this->fields_arr['album_id'])
					{
						$album_extra_query .= '(pa.photo_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
					}
				if ($this->fields_arr['tags'])
					{
					  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_caption', '').') AND ';
					}
				$this->sql_condition = $additional_query .$album_extra_query.$tags_extra_query.  'p.photo_status=\'Ok\'' . $this->getAdultQuery('p.', 'photo') . ' AND u.usr_status=\'Ok\' AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.photo_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ') ' . $this->advancedFilters().$this->searchTitleFilters();
			break;
			case 'photorecommended':
				if($this->fields_arr['myfavoritephoto'] == 'No')
					$this->setTableNames(array($this->CFG['db']['tbl']['photo'].' AS p JOIN ' . $this->CFG['db']['tbl']['users'] . ' AS u on p.user_id = u.user_id'. ' JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON ( pa.photo_album_id =p.photo_album_id OR p.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =p.photo_category_id'));
				else
					$this->setTableNames(array($this->CFG['db']['tbl']['photo_favorite'] . ' AS f LEFT JOIN ' .$this->CFG['db']['tbl']['photo'] . ' AS p ON f.photo_id=p.photo_id'.' JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON ( pa.photo_album_id =p.photo_album_id OR p.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =p.photo_category_id'.', '.$this->CFG['db']['tbl']['users'] . ' AS u '));

				$this->setReturnColumns(array('p.photo_id', 'p.photo_album_id', 'p.location_recorded', 'p.google_map_latitude', 'p.google_map_longtitude', 'p.l_width', 'p.user_id','u.user_name', 'p.photo_ext','p.photo_access_type', 'p.relation_id', 'p.photo_title', 'photo_caption', 'p.photo_server_url', 'p.date_added', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'photo_tags', 'photo_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date', 'p.photo_tags','total_featured','pa.photo_album_title','mc.photo_category_name','p.rating_count','p.total_comments','p.total_favorites','p.photo_category_id', 'p.allow_ratings'));
				$additional_query = '';
				$album_extra_query='';
				$tags_extra_query='';
				if ($this->fields_arr['cid'])
				{
					$additional_query .= '(p.photo_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';
					if ($this->fields_arr['sid'])
						$additional_query .= '(p.photo_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
				}
				$this->sql_sort = 'rating DESC';

				if ($this->fields_arr['album_id'])
				{
						$album_extra_query .= '(pa.photo_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
				}
				if ($this->fields_arr['tags'])
				{
					  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_caption', '').') AND ';
				}
				if($this->fields_arr['myfavoritephoto'] == 'No')
					$this->sql_condition = $additional_query .$album_extra_query.$tags_extra_query. 'p.photo_status=\'Ok\'' . $this->getAdultQuery('p.', 'photo') . ' AND u.usr_status=\'Ok\' AND ( ' . $this->myphotoCondition() . ' ) AND p.photo_featured=\'Yes\'' . $this->advancedFilters().$this->searchTitleFilters();
				else
					$this->sql_condition = $additional_query .$album_extra_query.$tags_extra_query. 'f.user_id=' . $this->CFG['user']['user_id'] . $this->getAdultQuery('p.', 'photo') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND p.photo_status=\'Ok\' AND p.photo_featured=\'Yes\' ' . $this->advancedFilters().$this->searchTitleFilters();

			break;
			case 'albumphotolist':
				$this->setTableNames(array($this->CFG['db']['tbl']['photo'].' AS p JOIN ' . $this->CFG['db']['tbl']['users'] . ' AS u ON p.user_id = u.user_id'. ' JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON pa.photo_album_id =p.photo_album_id'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =p.photo_category_id'));
				$this->setReturnColumns(array('p.photo_id', 'p.photo_album_id', 'p.l_width','p.user_id','u.user_name', 'p.photo_ext','p.photo_access_type', 'p.relation_id', 'p.photo_title', 'p.location_recorded', 'p.google_map_latitude', 'p.google_map_longtitude', 'photo_caption', 'p.photo_server_url', 'pa.photo_album_id', 'p.date_added', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'photo_tags', 'photo_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date', 'p.photo_tags','pa.photo_album_title','mc.photo_category_name','p.rating_count','p.total_comments','p.total_favorites','p.photo_category_id', 'p.allow_ratings'));
				$artist_extra_query='';
				$album_extra_query='';
				$tags_extra_query='';
					if ($this->fields_arr['view'])
						{
							if($this->fields_arr['view']=='Album')
								$this->sql_sort='pa.photo_album_title ASC';
							else if($this->fields_arr['view']=='Title')
								$this->sql_sort='p.photo_title ASC ';
							else
								$this->sql_sort='p.photo_id ASC ';

						}
					else
						{
							$this->sql_sort = 'photo_id DESC';
						}
					if ($this->fields_arr['album_id'])
						{
							$album_extra_query .= '(pa.photo_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
						}
					if ($this->fields_arr['tags'])
						{
						  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_caption', '').') AND ';
						}
					$this->sql_condition =$artist_extra_query.$album_extra_query.$tags_extra_query.  'p.photo_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\'' . $this->getAdultQuery('p.', 'photo') . ' AND u.usr_status=\'Ok\' AND p.photo_status=\'Ok\' AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.photo_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ')' . $this->advancedFilters().$this->searchTitleFilters();

			break;
			case 'subscribedphotolist':
				$this->setTableNames(array($this->CFG['db']['tbl']['photo'] . ' AS p  JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON ( pa.photo_album_id =p.photo_album_id OR p.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =p.photo_category_id'.', '.$this->CFG['db']['tbl']['users'] . ' AS u '));
				$this->setReturnColumns(array('p.photo_id', 'p.photo_album_id', 'p.location_recorded', 'p.google_map_latitude', 'p.google_map_longtitude','p.user_id','u.user_name' ,'p.photo_ext', 'p.l_width','p.photo_access_type', 'p.relation_id', 'p.photo_title', 'photo_caption', 'p.photo_server_url', 'p.date_added', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'photo_tags', 'photo_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date','p.photo_tags','pa.photo_album_title','mc.photo_category_name','p.rating_count','p.total_comments','p.total_favorites','p.photo_category_id', 'p.allow_ratings'));
				$sub_extra_query='';
				$user_extra_query = '';
				$category_extra_query = '';
				$subscription_query = '';
				if (isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule())
				{
					$user_values = $this->getMySubscriptionUsers();
					if(!empty($user_values))
						$user_extra_query .= '  p.user_id IN ( '.$user_values.' ) ';
					$cat_values = $this->getMySubscriptionCategorys();
					if(!empty($cat_values))
						$category_extra_query .= ' p.photo_category_id IN ( '.$cat_values.' ) OR p.photo_sub_category_id IN(  '.$cat_values.' )';
					$sub_extra_query .= $user_extra_query;
					if(!empty($sub_extra_query) && !empty($category_extra_query))
						$sub_extra_query .= ' OR '.$category_extra_query;
					$con = '';
					if(!empty($sub_extra_query))
						$con = 'OR';
					$tag_value = $this->getMySubscriptionTags();
					$subscription_query = ' AND ( '.getSearchRegularExpressionQueryModified($tag_value, 'p.photo_tags', $con).$sub_extra_query.')';
				}
				$this->sql_sort = 'p.date_added DESC';
				$norecord_cond = '';
				if(empty($user_values) && empty($cat_values) && empty($tag_value))
					$norecord_cond = ' AND p.photo_id = \'no\'';
				$this->sql_condition = 'p.user_id=u.user_id '. $norecord_cond . $this->getAdultQuery('p.', 'photo') . ' AND u.usr_status=\'Ok\' AND p.photo_status=\'Ok\' '.$subscription_query. $this->advancedFilters().$this->searchTitleFilters();
			break;
			default:
				if($this->fields_arr['myfavoritephoto'] == 'No')
					$this->setTableNames(array($this->CFG['db']['tbl']['photo'].' AS p JOIN ' . $this->CFG['db']['tbl']['users'] . ' AS u ON p.user_id = u.user_id'. ' JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON (pa.photo_album_id =p.photo_album_id OR p.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =p.photo_category_id'));
				else
					$this->setTableNames(array($this->CFG['db']['tbl']['photo_favorite'] . ' AS f LEFT JOIN ' .$this->CFG['db']['tbl']['photo'] . ' AS p ON f.photo_id=p.photo_id'.' JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON ( pa.photo_album_id =p.photo_album_id OR p.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =p.photo_category_id'.', '.$this->CFG['db']['tbl']['users'] . ' AS u '));

				$this->setReturnColumns(array('p.photo_id', 'p.photo_album_id', 'p.location_recorded', 'p.google_map_latitude', 'p.google_map_longtitude', 'p.l_width', 'p.user_id','u.user_name', 'p.photo_ext', 'p.photo_tags','p.photo_title', 'photo_caption', 'p.photo_server_url', 'p.date_added', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'photo_tags', 'photo_status', 'TIMEDIFF(NOW(), last_view_date) as last_view_date','pa.photo_album_title','mc.photo_category_name','p.rating_count','p.total_comments','p.total_favorites','p.photo_category_id', 'p.allow_ratings'));
				$additional_query = '';
				$extraquery='';
				$album_extra_query='';
				$tags_extra_query='';
				if ($this->fields_arr['cid'])
				{
					$additional_query .= '(p.photo_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';
					if ($this->fields_arr['sid'])
						$additional_query .= '(p.photo_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
				}
				$this->sql_sort = 'p.date_added DESC';

                if ($this->fields_arr['tags'])
				{
				  $tags_extra_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.photo_caption', '').') AND ';
				}
				if ($this->fields_arr['album_id'])
				{
				  $album_extra_query .= '(pa.photo_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\') AND ';
				}

				if($this->fields_arr['myfavoritephoto'] == 'No')
					$this->sql_condition = $additional_query .$album_extra_query.$tags_extra_query. 'p.photo_status=\'Ok\'' . $this->getAdultQuery('p.', 'photo') . ' AND u.usr_status=\'Ok\' AND (' . $this->myphotoCondition() . ')' . $this->advancedFilters().$this->searchTitleFilters();
				else
					$this->sql_condition = $additional_query .$album_extra_query.$tags_extra_query. 'f.user_id=' . $this->CFG['user']['user_id'] . $this->getAdultQuery('p.', 'photo') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND p.photo_status=\'Ok\' AND p.photo_album_id!=\'\' ' . $this->advancedFilters().$this->searchTitleFilters();

			break;
			}
			if(!in_array($this->fields_arr['pg'],$this->group_query_arr))
				$this->sql_condition .= ' GROUP BY p.photo_id,p.photo_album_id';
    }

    /**
     * photoSearchList::getMySubscriptionTags()
     *
     * @return
     */
    public function getMySubscriptionTags()
    {
    	$tagsvalue = '';
		$sql = 'SELECT tag_name FROM ' . $this->CFG['db']['tbl']['subscription'] . ' WHERE status = \'Yes\' AND module=\'photo\' AND subscriber_id=' . $this->dbObj->Param('subsciber_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
		if (!$rs)
			trigger_db_error($this->dbObj);
		while($row = $rs->FetchRow())
		{
			if($tagsvalue=='')
				$tagsvalue .= $row['tag_name'];
			else
				$tagsvalue .= ' '.$row['tag_name'];
		}

		return $tagsvalue;
	}


	/**
	 * photoSearchList::getMySubscriptionUsers()
	 *
	 * @return
	 */
	public function getMySubscriptionUsers()
    {
    	$uservalue = '';
		$sql = 'SELECT owner_id FROM ' . $this->CFG['db']['tbl']['subscription'] . ' WHERE status = \'Yes\' AND module=\'photo\' AND owner_id!=0 AND subscriber_id=' . $this->dbObj->Param('subsciber_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
		if (!$rs)
			trigger_db_error($this->dbObj);
		while($row = $rs->FetchRow())
		{
			if($uservalue=='')
				$uservalue .= $row['owner_id'];
			else
				$uservalue .= ','.$row['owner_id'];
		}

		return $uservalue;
	}
	/**
	 * photoSearchList::getMySubscriptionCategorys()
	 *
	 * @return
	 */
	public function getMySubscriptionCategorys()
    {
    	$catvalue = '';
		$sql = 'SELECT category_id FROM ' . $this->CFG['db']['tbl']['subscription'] . ' WHERE status = \'Yes\' AND module=\'photo\' AND category_id !=0 AND subscriber_id=' . $this->dbObj->Param('subsciber_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
		if (!$rs)
			trigger_db_error($this->dbObj);
		while($row = $rs->FetchRow())
		{
			if($catvalue=='')
				$catvalue .= $row['category_id'];
			else
				$catvalue .= ','.$row['category_id'];
		}

		return $catvalue;
	}
    /**
     * photoSearchList::chkValidAlbumId()
     *
     * @return
     */
	public function chkValidAlbumId()
		{
			$condition = 'photo_album_id=' . $this->dbObj->Param('album_id') . ' AND' . ' (p.user_id = ' . $this->dbObj->Param('user_id') . $this->getAdditionalQuery('p.') . ')';
			$sql = 'SELECT p.photo_album_title, p.user_id FROM ' . $this->CFG['db']['tbl']['photo_album'] . ' AS p' . ' WHERE ' . $condition . ' LIMIT 0,1';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['album_id'], $this->CFG['user']['user_id']));
			if (!$rs)
				trigger_db_error($this->dbObj);
			if ($row = $rs->FetchRow())
			{
				$this->ALBUM_TITLE = $row['photo_album_title'];
				$this->ALBUM_USER_ID = $row['user_id'];
				return true;
			}
			return false;
		}

    /**
     * photoSearchList::updatephotoTagDetails()
     *
     * @param array $photoTags
     * @return
     */
    public function updatephotoTagDetails($photoTags = array())
	{
		$tags = $this->fields_arr['tags'];
		$tags = trim($tags);
		$tags = $this->_parse_tags($tags);
		$match = array_intersect($tags, $photoTags);
		$match = array_unique($match);
		if (empty($match))
			return;
		if (count($match) == 1)
		{
			$key= array_keys($match);
			$this->updateSearchCountAndResultForphotoTag($match[$key[0]]);
		}
		else
		{
			for($i = 0; $i < count($match); $i++)
			{
				$tag = $match[$i];
				$this->updateSearchCountForphotoTag($tag);
			}
		}
	}

    /**
     * photoSearchList::updateSearchCountAndResultForphotoTag()
     *
     * @param string $tag
     * @return
     */
    public function updateSearchCountAndResultForphotoTag($tag = '')
	{
		$sql = 'UPDATE ' . $this->CFG['db']['tbl']['photo_tags'] . ' SET search_count = search_count + 1,' . ' result_count = ' . $this->getResultsTotalNum() . ',' . ' last_searched = NOW()' . ' WHERE tag_name=' . $this->dbObj->Param('tag_name');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($tag));
		if (!$rs)
			trigger_db_error($this->dbObj);
		if ($this->dbObj->Affected_Rows() == 0)
		{
			$sql = 'INSERT INTO ' . $this->CFG['db']['tbl']['photo_tags'] . ' SET search_count = search_count + 1 ,' . ' result_count = ' . $this->getResultsTotalNum() . ',' . ' last_searched = NOW(),' . ' tag_name=' . $this->dbObj->Param('tag_name');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($tag));
			if (!$rs)
				trigger_db_error($this->dbObj);
		}
	}

    /**
     * photoSearchList::updateSearchCountForphotoTag()
     *
     * @param string $tag
     * @return
     */
    public function updateSearchCountForphotoTag($tag = '')
	{
		$sql = 'UPDATE ' . $this->CFG['db']['tbl']['photo_tags'] . ' SET search_count = search_count + 1,' . ' result_count = ' . $this->getResultsTotalNum() . ',' . ' last_searched = NOW()' . ' WHERE tag_name=' . $this->dbObj->Param('tag_name');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($tag));
		if (!$rs)
			trigger_db_error($this->dbObj);
		if ($this->dbObj->Affected_Rows() == 0)
		{
			$sql = 'INSERT INTO ' . $this->CFG['db']['tbl']['photo_tags'] . ' SET search_count = search_count + 1 ,' . ' result_count = ' . $this->getResultsTotalNum() . ',' . ' last_searched = NOW(),' . ' tag_name=' . $this->dbObj->Param('tag_name');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($tag));
			if (!$rs)
				trigger_db_error($this->dbObj);
		}
	}

	/**
     * photoSearchList::getAlbumName()
     *
     * @return
     */
	public function getAlbumName()
	{
		$sql = 'SELECT photo_album_title FROM ' . $this->CFG['db']['tbl']['photo_album'] . ' WHERE photo_album_id=' . $this->dbObj->Param('photo_album_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['album_id']));
		if (!$rs)
			trigger_db_error($this->dbObj);
		if ($row = $rs->FetchRow())
			return $row['photo_album_title'];
		return $this->LANG['photolist_unknown_album'];
	}

    /**
     * photoSearchList::getCategoryName()
     *
     * @return
     */
    public function getCategoryName()
    {
        if ($this->fields_arr['sid'])
            $categoryId = $this->fields_arr['sid'];
        else
            $categoryId = $this->fields_arr['cid'];
        $sql = 'SELECT photo_category_name FROM ' . $this->CFG['db']['tbl']['photo_category'] . ' WHERE photo_category_id=' . $this->dbObj->Param('photo_category_id');
        $stmt = $this->dbObj->Prepare($sql);
        $rs = $this->dbObj->Execute($stmt, array($categoryId));
        if (!$rs)
            trigger_db_error($this->dbObj);
        if ($row = $rs->FetchRow())
            return $row['photo_category_name'];
        return $this->LANG['unknown_category'];
    }

    /**
     * photoSearchList::getMostViewedExtraQuery()
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
                $extra_query = ' AND DATE_FORMAT(vp.view_date,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
                break;
            case 2:
                $extra_query = ' AND DATE_FORMAT(vp.view_date,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
                break;
            case 3:
                $extra_query = ' AND DATE_FORMAT(vp.view_date,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
                break;
            case 4:
                $extra_query = ' AND DATE_FORMAT(vp.view_date,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
                break;
            case 5:
                $extra_query = ' AND DATE_FORMAT(vp.view_date,\'%y\') = DATE_FORMAT(NOW(),\'%y\')';
                break;
            case 6:
                $extra_query = ' AND DATE_FORMAT(vp.view_date,\'%y\')<DATE_FORMAT(NOW(),\'%y\')';
                break;
          }
        return $extra_query;
    }

    /**
     * photoSearchList::getMostDiscussedExtraQuery()
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
            case 6:
                $extra_query = ' AND DATE_FORMAT(pc.date_added,\'%y\')<DATE_FORMAT(NOW(),\'%y\')';
                break;
        }
        return $extra_query;
    }

    /**
     * photoSearchList::getMostFavoriteExtraQuery()
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
            case 6:
                $extra_query = ' AND DATE_FORMAT(pf.date_added,\'%y\')<DATE_FORMAT(NOW(),\'%y\')';
                break;
        }
        return $extra_query;
    }

    /**
     * photoSearchList::getphotoCountForAlbum()
     *
     * @param mixed $album_id
     * @return
     */
    public function getphotoCountForAlbum($album_id)
    {
        $result_arr = array();
        global $smartyObj;
        $photos_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['photos']['folder'] . '/' . $this->CFG['admin']['photos']['thumbnail_folder'] . '/';
        $sql = 'SELECT COUNT(photo_id) AS total_photos,photo_id,photo_ext,small_width,small_height,photo_server_url,photo_album_id,file_name FROM ' . $this->CFG['db']['tbl']['photo'].' WHERE FIND_IN_SET(photo_album_id,' . $this->dbObj->Param('photo_album_id') . ')' . ' AND photo_status=\'Ok\' GROUP BY photo_album_id';
        $stmt = $this->dbObj->Prepare($sql);
        $rs = $this->dbObj->Execute($stmt, array($album_id));
        if (!$rs)
            trigger_db_error($this->dbObj);
        while ($row = $rs->FetchRow())
			 {
	            $result_arr[$row['photo_album_id']]['total_photos'] = $row['total_photos'];
	            $result_arr[$row['photo_album_id']]['img_src'] = $row['photo_server_url'] . $photos_folder . getphotoImageName($row['photo_id'],$row['file_name']) . $this->CFG['admin']['photos']['small_name'];
	            $result_arr[$row['photo_album_id']]['img_disp_image'] = DISP_IMAGE($this->CFG['admin']['photo']['small_width'], $this->CFG['admin']['photos']['small_height'], $row['small_width'], $row['small_height']);
	         }
        $smartyObj->assign('album_photo_count_list', $result_arr);
        return $result_arr;
    }

    /**
     * photoSearchList::populateSubCategories()
     *
     * @return
     */
    public function populateSubCategories()
    {
        global $smartyObj;
        $populateSubCategories_arr = array();
		//photo catagory List order by Priority on / off features
		if($this->CFG['admin']['photos']['photo_category_list_priority'])
			$order_by = 'priority';
		else
			$order_by = 'photo_category_name';
        $sql = 'SELECT photo_category_id, photo_category_name, photo_category_description,photo_category_ext ' . 'FROM ' . $this->CFG['db']['tbl']['photo_category'] . ' ' . 'WHERE photo_category_status = \'Yes\' ' . 'AND parent_category_id=' . $this->dbObj->Param('parent_category_id'). 'ORDER BY '.$order_by.' ASC ';

        $stmt = $this->dbObj->Prepare($sql);
        $rs = $this->dbObj->Execute($stmt, array($this->fields_arr['cid']));
        if (!$rs)
            trigger_db_error($this->dbObj);
        $usersPerRow = $this->CFG['admin']['photos']['subcategory_list_per_row'];
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
    		$imagePrefix ='nocategory';
    		if(is_file($this->CFG['site']['project_path'].$this->CFG['admin']['photos']['category_folder'] . $row['photo_category_id'] . '.' . $row['photo_category_ext']))
            	$populateSubCategories_arr['row'][$inc]['imageSrc'] = $this->CFG['site']['url'] . $this->CFG['admin']['photos']['category_folder'] . $row['photo_category_id'] . '.' . $row['photo_category_ext'];
            else
           		$populateSubCategories_arr['row'][$inc]['imageSrc'] = $this->CFG['site']['url'] .'photo/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/icon-nosubcategory.jpg';
            $row['photo_category_name'] = $row['photo_category_name'];
			$populateSubCategories_arr['row'][$inc]['record'] = $row;
			$this->fields_arr['pg'] = (empty($this->fields_arr['pg']))?'newphoto':$this->fields_arr['pg'];
	        $populateSubCategories_arr['row'][$inc]['photo_list_url'] = getUrl('photolist', '?pg=' . $this->fields_arr['pg'] . '&cid=' . $this->fields_arr['cid'] . '&sid=' . $row['photo_category_id'], $this->fields_arr['pg'] . '/?cid=' . $this->fields_arr['cid'] . '&sid=' . $row['photo_category_id'], '', 'photo');
            $populateSubCategories_arr['row'][$inc]['photo_category_name_manual'] = nl2br(stripslashes($row['photo_category_name']));
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
     * photoSearchList::advancedFilters()
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
			if ($this->getFormField('photo_album_name') != $this->LANG['photolist_album_name'] AND $this->getFormField('photo_album_name'))
			{
				$advanced_filters .= 'AND p.photo_album_id!=0  AND pa.photo_album_title LIKE \'%' . validFieldSpecialChr($this->getFormField('photo_album_name')) . '%\' ';
				$this->advanceSearch = true;
			}
			if ($this->getFormField('photo_keyword') != $this->LANG['photolist_keyword_field'] AND $this->getFormField('photo_keyword'))
			{
				//$advanced_filters .= ' AND photo_tags LIKE \'%' . validFieldSpecialChr($this->getFormField('photo_tags')) . '%\' ';
				$this->advanceSearch = true;
			}
			if ($this->fields_arr['photo_owner'] != $this->LANG['photolist_photo_created_by'] AND $this->fields_arr['photo_owner'])
			{
				$advanced_filters .= ' AND u.user_name LIKE \'%' .validFieldSpecialChr($this->fields_arr['photo_owner']). '%\' ';
				$this->advanceSearch = true;
			}
			if ($this->fields_arr['location'] != $this->LANG['photolist_photo_location'] AND $this->fields_arr['location'])
			{
				$advanced_filters .= ' AND location_recorded LIKE \'%' .validFieldSpecialChr($this->fields_arr['location']). '%\' ';
				$this->advanceSearch = true;
			}
			return $advanced_filters;
		}
    }
	/**
     * photoSearchList::searchTitleFilters()
     *
     * @return
     */
	public function searchTitleFilters()
	{
		$searchTitleFilters = '';
		$this->titleSearch = false;
		if ($this->isFormPOSTed($_REQUEST, 'titles') && !empty($this->fields_arr['titles']))
		{
			$title= $this->fields_arr['titles'];
			if($title == 'All')
				$searchTitleFilters .= ' AND photo_title != \'\' ';
			else
				$searchTitleFilters .= ' AND photo_title LIKE \'' .$title . '%\' ';
			$this->titleSearch = true;
		}
		return $searchTitleFilters;
	}
	/**
     * photoSearchList::searchViewFilters()
     *
     * @return
     */
	public function searchViewFilters()
	{
		$searchViewFilters = '';
		$this->viewSearch = false;
		if ($this->isFormPOSTed($_REQUEST, 'view'))
		{
			$view= $this->fields_arr['view'];
			if($_REQUEST['view']=='Album')
			{
				$searchViewFilters .= ' AND photo_title LIKE \'' .$view . '%\' ';
				$this->viewSearch = true;
			}
			else
			{
				$searchViewFilters .= ' AND photo_title LIKE \'' .$view . '%\' ';
				$this->viewSearch = true;
			}
		}
		return $searchViewFilters;
	}
	/**
     * photoSearchList::getphotoTags()
     * @param string $photo_tags
     * @return
     */
	public function getphotoTags($photo_tags)
	{
		$tags_arr = explode(' ', $photo_tags);
		$getphotoTags_arr = array();
		for($i=0;$i<count($tags_arr);$i++)
		{
			if($i<3)
			{
				if(strlen($tags_arr[$i]) > 5 and strlen($tags_arr[$i]) > 5+3)
					$getphotoTags_arr[$i]['tags_name'] = $tags_arr[$i];
				else
					$getphotoTags_arr[$i]['tags_name'] = $tags_arr[$i];
				$getphotoTags_arr[$i]['tags_url'] = getUrl('photolist', '?pg=photonew&tags='.$tags_arr[$i], 'photoew/?tags='.$tags_arr[$i], '', 'photo');
			}
		}
		return $getphotoTags_arr;
	}
	/**
     * photoSearchList::chkAdvanceResultFound()
     *
     * @return
     */
	public function chkAdvanceResultFound()
	{
		if($this->advanceSearch)
		{
			return true;
		}
		return false;
	}
	/**
     * photoSearchList::populateRatingImagesForAjax()
     *
     * @return
     */
	public function populateRatingImagesForAjax($rating, $imagePrefix='')
	{
		$rating_total = $this->CFG['admin']['total_rating'];
		for($i=1;$i<=$rating;$i++)
		{
			?>
			<a onClick="return callAjaxRate('<?php echo $this->CFG['site']['photo_url'].'photoList.php?pg=photonew'?>', 'selRatingPlaylist')" onMouseOver="ratingphotoMouseOver(<?php echo $i;?>)" onMouseOut="ratingphotoMouseOut(<?php echo $i;?>)"><img id="img<?php echo $i;?>" src="<?php echo $this->CFG['site']['photo_url'].'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-photoratehover.gif'; ?>"  title="<?php echo $i;?>" /></a>
			<?php
		}
		for($i=$rating;$i<$rating_total;$i++)
		{
			?>
			<a onClick="return callAjaxRate('<?php echo $this->CFG['site']['photo_url'].'photoList.php?pg=photonew'?>', 'selRatingPlaylist')" onMouseOver="ratingphotoMouseOver(<?php echo ($i+1);?>)" onMouseOut="ratingphotoMouseOut(<?php echo ($i+1);?>)"><img id="img<?php echo ($i+1);?>" src="<?php echo $this->CFG['site']['photo_url'].'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-photorate.gif'; ?>"  title="<?php echo ($i+1);?>" /></a>
			<?php
		}
	}
	/**
     * photoSearchList::getDescriptionForPhotoList()
     * @param: string $photo_description
     * @return
     */
    public function getDescriptionForPhotoList($photo_description)
	{
	    // change the function for display the caption with some more text
		global $smartyObj;
	    $getDescriptionLink_arr = array();
		$description_array = explode(' ', $photo_description);
		$search_word_description = '';
		if($this->fields_arr['tags']!='')
			$search_word_description=$this->fields_arr['tags'];
		for($i=0;$i<count($description_array);$i++)
		{
			if($i<15)
			{
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
     * photoSearchList::getPhotoLocation()
     *
     * @return
     */
	public function getPhotoLocation()
	{
		$sql = 'SELECT google_map_latitude,google_map_longtitude,location_recorded ' . 'FROM ' . $this->CFG['db']['tbl']['photo'] . ' WHERE photo_status = \'Ok\' AND photo_id= ' . $this->dbObj->Param('photo_id');
        $stmt = $this->dbObj->Prepare($sql);
        $rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
        if (!$rs)
        	trigger_db_error($this->dbObj);
        if($row = $rs->FetchRow())
        {
        	$this->fields_arr['latitude'] = $row['google_map_latitude'];
			$this->fields_arr['longitude'] = $row['google_map_longtitude'];
			$this->fields_arr['address'] = $row['location_recorded'];
		}
	}
	/**
     * photoSearchList::updatePhotoLocation()
     *
     * @return
     */
	public function updatePhotoLocation()
	{
		if(isset($_SESSION['new_photo_id']) AND !empty($_SESSION['new_photo_id']))
		{
			foreach($_SESSION['new_photo_id'] as $key => $photo_id)
			{
				$sql = 'UPDATE '. $this->CFG['db']['tbl']['photo'] .'  SET ';
				if(!empty($this->fields_arr['latitude'])&&!empty($this->fields_arr['longitude'])&&!empty($this->fields_arr['address']))
				{
					$sql_update = ' google_map_latitude = '.$this->dbObj->Param('latitude').
								  ', google_map_longtitude = '.$this->dbObj->Param('longitude').
								  ', location_recorded = '.$this->dbObj->Param('address');
					$inser_val_arr = array($this->fields_arr['latitude'],$this->fields_arr['longitude'],$this->fields_arr['address'],$photo_id);
				}
				elseif(!empty($this->fields_arr['location']))
				{
					$sql_update = ' google_map_latitude = '.$this->dbObj->Param('latitude').
								  ', google_map_longtitude = '.$this->dbObj->Param('longitude').
								  ', location_recorded = '.$this->dbObj->Param('address');
					$inser_val_arr = array(0,0,$this->fields_arr['location'],$photo_id);
				}
				$sql =$sql.$sql_update.' WHERE photo_status = \'Ok\' AND photo_id= '.$this->dbObj->Param('photo_id');
		        $stmt = $this->dbObj->Prepare($sql);
		        $rs = $this->dbObj->Execute($stmt, $inser_val_arr);
		        if (!$rs)
		        	trigger_db_error($this->dbObj);
			}
			return true;
		}
		elseif($this->fields_arr['photo_id'])
		{
			$sql = 'UPDATE '. $this->CFG['db']['tbl']['photo'] .'  SET ';
				if(!empty($this->fields_arr['latitude'])&&!empty($this->fields_arr['longitude'])&&!empty($this->fields_arr['address']))
				{
					$sql_update = ' google_map_latitude = '.$this->dbObj->Param('latitude').
								  ', google_map_longtitude = '.$this->dbObj->Param('longitude').
								  ', location_recorded = '.$this->dbObj->Param('address');
					$inser_val_arr = array($this->fields_arr['latitude'],$this->fields_arr['longitude'],$this->fields_arr['address'],$this->fields_arr['photo_id']);
				}
				elseif(!empty($this->fields_arr['location']))
				{
					$sql_update = ' google_map_latitude = '.$this->dbObj->Param('latitude').
								  ', google_map_longtitude = '.$this->dbObj->Param('longitude').
								  ', location_recorded = '.$this->dbObj->Param('address');
					$inser_val_arr = array(0,0,$this->fields_arr['location'],$this->fields_arr['photo_id']);
				}
			$sql =$sql.$sql_update.' WHERE photo_status = \'Ok\' AND photo_id= '.$this->dbObj->Param('photo_id');
	        $stmt = $this->dbObj->Prepare($sql);
	        $rs = $this->dbObj->Execute($stmt, $inser_val_arr);
	        if (!$rs)
	        	trigger_db_error($this->dbObj);
	        if ($this->dbObj->Affected_Rows() > 0)
			{
				return true;
			}
		}
		return false;
	}
	/**
     * photoSearchList::removePhotoLocation()
     *
     * @return
     */
	public function removePhotoLocation()
	{

		$sql = 'UPDATE '. $this->CFG['db']['tbl']['photo'] .'  SET '.
			 	' location_recorded = "" WHERE photo_status = \'Ok\' AND photo_id= '.$this->dbObj->Param('photo_id');
        $stmt = $this->dbObj->Prepare($sql);
        $rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
        if (!$rs)
        	trigger_db_error($this->dbObj);
        if ($this->dbObj->Affected_Rows() > 0)
		{
			return true;
		}
		return false;
	}
	/**
     * photoSearchList::getPhotoLocationFromDb()
     *
     * @return
     */
	public function getPhotoLocationFromDb()
	{
		$sql = 'SELECT location_recorded ' . 'FROM ' . $this->CFG['db']['tbl']['photo'].' as p' .
				' WHERE photo_status = \'Ok\' AND photo_access_type= \'Public\''.
				' AND location_recorded LIKE \'%' . validFieldSpecialChr($this->getFormField('location')) . '%\' '. $this->getAdultQuery('p.', 'photo').
				' GROUP BY location_recorded ';
        $stmt = $this->dbObj->Prepare($sql);
        $rs = $this->dbObj->Execute($stmt);
        if (!$rs)
        	trigger_db_error($this->dbObj);
        $location_div = '';
        $i=0;
        while($row = $rs->FetchRow())
        {
        	$location_div=$location_div.'<div onclick="setDbLocation('.$i.');" id="'.$i.'_place">'.$row['location_recorded'].'</div>';
        	$i++;
		}
		echo $location_div;
	}
	/**
     * photoSearchList::getPhotoLocation()
     *
     * @return
     */
	public function getLocationPhotosDetails()
	{
		$content_filter = '';
		$content_filter = $this->getAdultQuery('p.', 'photo');
		$public_condition = ' AND (p.user_id = '.$this->CFG['user']['user_id'].' OR p.photo_access_type = \'Public\''.
								$this->getAdditionalQuery('p.').')'.$content_filter;
		$sql = 'SELECT p.photo_id, p.photo_title,p.location_recorded, p.photo_server_url, p.photo_ext, u.user_name,p.photo_caption, '.
				' google_map_latitude, google_map_longtitude, p.total_views, p.total_comments, (p.rating_total/p.rating_count) as rating '.
				' FROM '.$this->CFG['db']['tbl']['photo']. ' AS p LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u '.
				' ON p.user_id = u.user_id WHERE p.location_recorded = '.$this->dbObj->Param('location_recorded'). ' AND u.usr_status=\'Ok\' AND p.photo_status=\'Ok\''.$public_condition.
				' ORDER BY p.photo_id ASC';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_location_recorded']));
		if (!$rs)
			trigger_db_error($this->dbObj);

		$photos_folder = 'files/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
		$cssImage_folder = $this->CFG['site']['url'].'/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/';
		$inc = 0;
		$result_arr = array();
		if($rs->PO_RecordCount())
		{
			while($row = $rs->FetchRow())
			{
				  $result_arr[$inc]['photo_title'] = $row['photo_title'];
				  $result_arr[$inc]['photo_caption'] = $row['photo_caption'];
				  $photo_name = getphotoName($row['photo_id']);
				  $result_arr[$inc]['thumb_img_src'] = $row['photo_server_url'] . $photos_folder.$photo_name.$this->CFG['admin']['photos']['thumb_name'].'.'.$row['photo_ext'];
				  $result_arr[$inc]['user_name'] = $row['user_name'];
				  $result_arr[$inc]['total_views'] = $row['total_views'];
				  $result_arr[$inc]['total_comments'] = $row['total_comments'];
				  $result_arr[$inc]['photos_lat'] = $row['google_map_latitude'];
				  $result_arr[$inc]['photos_lan'] = $row['google_map_longtitude'];
				  $result_arr[$inc]['rating'] = $row['rating'];
				  $inc++;
			}
			return $result_arr;
		 }
	}
}
// -------------------- Code begins -------------->>>>>//
//echo '<pre>'; print_r($_REQUEST); echo '</pre>';
//$_SESSION['user']['photo_quick_mixs'] = '';
$photoSearchList = new photoSearchList();
if (!chkAllowedModule(array('photo')))
    Redirect2URL($CFG['redirect']['dsabled_module_url']);
$photoSearchList->setPageBlockNames(array('my_photos_form', 'delete_confirm_form', 'featured_confirm_form',
									'block_get_location','check_all_item', 'form_show_sub_category',
									'photolist_msg_form_error','block_add_location','block_view_location_photos'
							  ));

$photoSearchList->CFG['admin']['photos']['individual_photo_play'] = true;

$photoSearchList->LANG_LANGUAGE_ARR = $LANG_LIST_ARR['language'];
$photoSearchList->ADDED_WITHIN_ARR = $LANG_LIST_ARR['added_within_arr'];
$photoSearchList->setFormField('photo_id', '');
$photoSearchList->setFormField('playlist_id', '');
$photoSearchList->setFormField('album_id', '');
$photoSearchList->setFormField('photo_ext', '');
$photoSearchList->setFormField('action', '');
$photoSearchList->setFormField('action_new', '');
$photoSearchList->setFormField('act', '');
$photoSearchList->setFormField('pg', '');
$photoSearchList->setFormField('default', 'Yes');
$photoSearchList->setFormField('cid', '');
$photoSearchList->setFormField('myphoto', 'No');
$photoSearchList->setFormField('myfavoritephoto', 'No');
$photoSearchList->setFormField('user_id', '0');
$photoSearchList->setFormField('ajax_page', '');

/**
 * ********** Page Navigation Start ********
 */
$photoSearchList->setFormField('start', '0');
$photoSearchList->setFormField('slno', '1');
$photoSearchList->setFormField('sid', '');
$photoSearchList->setFormField('photo_ids', array());
$photoSearchList->setFormField('numpg', $CFG['photo_tbl']['numpg']);
$condition = '';
$photoSearchList->setFormField('advanceFromSubmission', '');
$photoSearchList->setFormField('photo_category_name', '');
$photoSearchList->setFormField('added_within', '');
$photoSearchList->setFormField('photo_title', '');
$photoSearchList->setFormField('advan_photo_title', '');
$photoSearchList->setFormField('photo_owner', '');
$photoSearchList->setFormField('advan_photo_owner', '');
$photoSearchList->setFormField('photo_tags', '');
$photoSearchList->setFormField('photo_album_name', '');
$photoSearchList->setFormField('advan_photo_album_name', '');
$photoSearchList->setFormField('location', '');
$photoSearchList->setFormField('searchkey', '');
$photoSearchList->setFormField('titles', '');
$photoSearchList->setFormField('view', '');
$photoSearchList->setFormField('rating', '');
$photoSearchList->setFormField('album_id', '');
$photoSearchList->setFormField('tags', '');
$photoSearchList->setFormField('phototracker', '');
$photoSearchList->setFormField('type', '');
$photoSearchList->setFormField('latitude', '');
$photoSearchList->setFormField('longitude', '');
$photoSearchList->setFormField('address', '');
$photoSearchList->setFormField('photo_location_recorded', '');
$photoSearchList->setFormField('thumb', 'no');
$photoSearchList->setFormField('page', '');

$photoSearchList->setFormField('advance_keyword', '');
$photoSearchList->setFormField('advantage_photo_owner', '');
$photoSearchList->setFormField('advantage_photo_album_name', '');
$photoSearchList->setFormField('advantage_location', '');

if($photoSearchList->getFormField('pg')=='myplaylist')
{
	$photoSearchList->setFormField('playlist_id', '');
}
$photoSearchList->setFormField('checkbox', array());
$photoSearchList->recordsFound = false;
$photoSearchList->setMinRecordSelectLimit($CFG['data_tbl']['min_record_select_limit']);
$photoSearchList->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$photoSearchList->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$photoSearchList->setTableNames(array());
$photoSearchList->setReturnColumns(array());
/**
 * *********** page Navigation stop ************
 */
$photoSearchList->setAllPageBlocksHide();
$photoSearchList->setPageBlockShow('my_photos_form');
$photoSearchList->sanitizeFormInputs($_REQUEST);
/*echo '<pre>';
print_r($_POST);
echo '</pre>';*/
if($photoSearchList->getFormField('type')=='update_location')
{
	$photoSearchList->updatePhotoLocation();
}
if($photoSearchList->getFormField('type')=='add_location' || $photoSearchList->getFormField('type')=='update_location')
{
	$photoSearchList->setPageBlockShow('block_add_location');
}
if($photoSearchList->getFormField('type')=='view_location_photos')
{
	$photoSearchList->setPageBlockShow('block_view_location_photos');
}

if($photoSearchList->getFormField('type')=='remove_location')
{
	if($photoSearchList->removePhotoLocation())
	{
		echo '***--***!!!Yes';
	}
}


if(isset($_REQUEST['action']))
	$photoSearchList->setFormField('action_new', $_REQUEST['action']);
$action_new = $photoSearchList->getFormField('action_new');
$photoSearchList->setFormField('action', $action_new);
$photoSearchList->setFormField('advan_photo_album_name', $photoSearchList->getFormField('advantage_photo_album_name'));
$photoSearchList->setFormField('photo_album_name', $photoSearchList->getFormField('advan_photo_album_name'));
$photoSearchList->setFormField('advan_photo_owner', $photoSearchList->getFormField('advantage_photo_owner'));
$photoSearchList->setFormField('photo_owner', $photoSearchList->getFormField('advan_photo_owner'));
$photoSearchList->setFormField('location', $photoSearchList->getFormField('advantage_location'));
$photoSearchList->setFormField('photo_keyword', $photoSearchList->getFormField('advance_keyword'));
$photoIds='';
if($photoSearchList->getFormField('tags') && !isset($_POST['avd_search']))
{
$photoSearchList->setFormField('photo_keyword', $photoSearchList->getFormField('tags'));
$photoSearchList->setFormField('advance_keyword', $photoSearchList->getFormField('tags'));
}
elseif(isset($_POST['avd_search']) && $photoSearchList->getFormField('advance_keyword')!=$LANG['photolist_keyword_field'])
{
$photoSearchList->setFormField('tags', $photoSearchList->getFormField('advance_keyword'));
}
elseif(isset($_POST['avd_search']) && $photoSearchList->getFormField('advance_keyword')==$LANG['photolist_keyword_field'])
{
$photoSearchList->setFormField('tags', '');
}
if(isset($_GET['titles']))
{
	$photoSearchList->setFormField('titles', $_GET['titles']);
	$_REQUEST['titles'] = $_GET['titles'];
}
if($photoSearchList->getFormField('default')== 'Yes' && $photoSearchList->getFormField('pg')== 'photonew' && $photoSearchList->getFormField('tags') == '')
	$photoSearchList->setFormField('pg', '');
elseif($photoSearchList->getFormField('default')== 'No')
	$photoSearchList->setFormField('pg', (isset($_GET['pg']) && !empty($_GET['pg']))?$_GET['pg']:$_REQUEST['pg']);

if($photoSearchList->getFormField('pg')== 'myphotos')
	$photoSearchList->setFormField('myphoto', 'Yes');

if($photoSearchList->getFormField('pg')== 'myfavoritephotos')
	$photoSearchList->setFormField('myfavoritephoto', 'Yes');

if($photoSearchList->getFormField('pg')=='private_photo')
{
	$photoSearchList->setCommonSuccessMsg($LANG['photolist_private_photo']);
	$photoSearchList->setPageBlockShow('block_msg_form_success');
}
if($photoSearchList->getFormField('pg')=='invalid_photo_id')
{
	$photoSearchList->setCommonSuccessMsg($LANG['common_msg_invalid_photo_id']);
	$photoSearchList->setPageBlockShow('block_msg_form_success');
}

//ADDED THE ERROR MESSAGE IF NOT ALLOWED THE photo UPLOAD
if($photoSearchList->getFormField('pg')=='upload_photo')
{
	$photoSearchList->setCommonSuccessMsg($LANG['photolist_photo_upload_error_message']);
	$photoSearchList->setPageBlockShow('block_msg_form_success');
}
if(!isset($_GET['pg']) && $photoSearchList->getFormField('default')== 'No')
		$photoSearchList->setFormField('pg', '');

if(isset($_GET['view']) && !empty($_GET['view']))
	$photoSearchList->setFormField('view', $_GET['view']);

if(!isMember())
	$photoSearchList->savePlaylistUrl = $photoSearchList->is_not_member_url = getUrl('photolist','?pg=photonew','photonew/', '','photo');
else
	$photoSearchList->savePlaylistUrl = $CFG['site']['photo_url'].'createSlidelist.php?action=save_playlist&light_window=1';

$photoSearchList->photomyPlaylistUrl = $CFG['site']['photo_url'].'photolist.php?action=myphotodelete';
$myphoto_deletelist_arr['photo_list_url'] = getUrl('photolist', '?pg='.$photoSearchList->getFormField('pg'), $photoSearchList->getFormField('pg').'/?action=0', '', 'photo');
$pgValue = $photoSearchList->getFormField('pg');
$pgValue = !empty($pgValue)?$pgValue:'photonew';
$Navigation_arr['photo_list_url_0']      = getUrl('photolist', '?pg='.$pgValue.'&action='.$photoSearchList->getFormField('action').'&cid='.$photoSearchList->getFormField('cid').'&sid='.$photoSearchList->getFormField('sid'), $pgValue.'/?action='.$photoSearchList->getFormField('action').'&cid='.$photoSearchList->getFormField('cid').'&sid='.$photoSearchList->getFormField('sid'), '', 'photo');
$Navigation_list_arr['photo_list_url_0'] = getUrl('photolist', '?pg='.$pgValue, $pgValue.'/?', '', 'photo');
$smartyObj->assign('Navigation_arr', $Navigation_list_arr);
$photoActionNavigation_arr['photo_list_url_0'] = getUrl('photolist', '?pg='.$pgValue.'&action=0'.'&cid='.$photoSearchList->getFormField('cid').'&sid='.$photoSearchList->getFormField('sid'), $pgValue.'/?action=0'.'&cid='.$photoSearchList->getFormField('cid').'&sid='.$photoSearchList->getFormField('sid'), '', 'photo');
$photoActionNavigation_arr['photo_list_url_1'] = getUrl('photolist', '?pg='.$pgValue.'&action=1'.'&cid='.$photoSearchList->getFormField('cid').'&sid='.$photoSearchList->getFormField('sid'), $pgValue.'/?action=1'.'&cid='.$photoSearchList->getFormField('cid').'&sid='.$photoSearchList->getFormField('sid'), '', 'photo');
$photoActionNavigation_arr['photo_list_url_2'] = getUrl('photolist', '?pg='.$pgValue.'&action=2'.'&cid='.$photoSearchList->getFormField('cid').'&sid='.$photoSearchList->getFormField('sid'), $pgValue.'/?action=2'.'&cid='.$photoSearchList->getFormField('cid').'&sid='.$photoSearchList->getFormField('sid'), '', 'photo');
$photoActionNavigation_arr['photo_list_url_3'] = getUrl('photolist', '?pg='.$pgValue.'&action=3'.'&cid='.$photoSearchList->getFormField('cid').'&sid='.$photoSearchList->getFormField('sid'), $pgValue.'/?action=3'.'&cid='.$photoSearchList->getFormField('cid').'&sid='.$photoSearchList->getFormField('sid'), '', 'photo');
$photoActionNavigation_arr['photo_list_url_4'] = getUrl('photolist', '?pg='.$pgValue.'&action=4'.'&cid='.$photoSearchList->getFormField('cid').'&sid='.$photoSearchList->getFormField('sid'), $pgValue.'/?action=4'.'&cid='.$photoSearchList->getFormField('cid').'&sid='.$photoSearchList->getFormField('sid'), '', 'photo');
$photoActionNavigation_arr['photo_list_url_5'] = getUrl('photolist', '?pg='.$pgValue.'&action=5'.'&cid='.$photoSearchList->getFormField('cid').'&sid='.$photoSearchList->getFormField('sid'), $pgValue.'/?action=5'.'&cid='.$photoSearchList->getFormField('cid').'&sid='.$photoSearchList->getFormField('sid'), '', 'photo');
$photoActionNavigation_arr['photo_list_url_6'] = getUrl('photolist', '?pg='.$pgValue.'&action=6'.'&cid='.$photoSearchList->getFormField('cid').'&sid='.$photoSearchList->getFormField('sid'), $pgValue.'/?action=6'.'&cid='.$photoSearchList->getFormField('cid').'&sid='.$photoSearchList->getFormField('sid'), '', 'photo');
$photoActionNavigation_arr['photoMostViewed_0'] = $photoActionNavigation_arr['photoMostViewed_1'] = $photoActionNavigation_arr['photoMostViewed_2'] = $photoActionNavigation_arr['photoMostViewed_3'] = $photoActionNavigation_arr['photoMostViewed_4'] = $photoActionNavigation_arr['photoMostViewed_5'] = $photoActionNavigation_arr['photoMostViewed_6'] = '';
if($photoSearchList->getFormField('pg') == 'photomostviewed'
	OR $photoSearchList->getFormField('pg') == 'photomostdiscussed'
		OR $photoSearchList->getFormField('pg') == 'photomostfavorite')
	{
		if(!$photoSearchList->getFormField('action')) $photoSearchList->setFormField('action', '0');
		$sub_page = 'photoMostViewed_'.$photoSearchList->getFormField('action');
		$photoActionNavigation_arr[$sub_page] = ' class="clsActive"';
	}

$smartyObj->assign('photoActionNavigation_arr', $photoActionNavigation_arr);
if($photoSearchList->getFormField('searchkey'))
{
	$photoSearchList->setFormField('avd_search', '1');
}
$start = $photoSearchList->getFormField('start');
if ($photoSearchList->getFormField('cid') && !$photoSearchList->getFormField('sid') && $CFG['admin']['photos']['sub_category'])
{
    $photoSearchList->setPageBlockShow('form_show_sub_category');
}

$memberphotoSearchListCase = array('myphotos','myfavoritephotos');
if (in_array($photoSearchList->getFormField('pg'),$memberphotoSearchListCase) AND !isMember())
{
	Redirect2URL(getUrl('photolist','?pg='.$photoSearchList->getFormField('pg'),$photoSearchList->getFormField('pg').'/','members','photo'));
}
if ($photoSearchList->isFormPOSTed($_POST, 'avd_reset'))
{
	$photoSearchList->setFormField('photo_keyword', '');
	$photoSearchList->setFormField('photo_album_name', '');
	$photoSearchList->setFormField('photo_owner', '');
	$photoSearchList->setFormField('location', '');
}
if ($photoSearchList->isPageGETed($_GET, 'action'))
{
	$photoSearchList->sanitizeFormInputs($_GET);
}
if($photoSearchList->getFormField('act') == 'myphotodelete')
{
	$photos_arr = explode(',', $photoSearchList->getFormField('photo_id'));
	$photoSearchList->myPhotoListDelete($photos_arr, $CFG['user']['user_id']);
}
if($photoSearchList->getFormField('act') == 'myPlaylistphotoDelete')
{
	$photos_arr = explode(',', $photoSearchList->getFormField('photo_id'));
	//$photoSearchList->deleteMyPlaylistphoto($photos_arr, $CFG['user']['user_id']);
}
if($photoSearchList->getFormField('act') == 'myFavoritephotosDelete')
{
	$photos_arr = explode(',', $photoSearchList->getFormField('photo_id'));
	$photoSearchList->myPhotoListDelete($photos_arr, $CFG['user']['user_id']);
}

if ($photoSearchList->isFormPOSTed($_POST, 'yes'))
{
	if ($photoSearchList->getFormField('act') == 'delete')
	{
		$photos_arr = explode(',', $photoSearchList->getFormField('photo_id'));
		$photoSearchList->deletePhotos($photos_arr, $CFG['user']['user_id']);
		$photoSearchList->setCommonSuccessMsg($LANG['photolist_delete_succ_msg_confirmation']);
		$photoSearchList->setPageBlockShow('block_msg_form_success');

	}
	if ($photoSearchList->getFormField('act') == 'set_avatar')
	{
		$photoSearchList->setFeatureThisImage($photoSearchList->getFormField('photo_id'), $CFG['user']['user_id']);
		$photoSearchList->setPageBlockShow('msg_form_error');
		$photoSearchList->setCommonErrorMsg($LANG['photolist_msg_success_set_avatar']);
	}
	if ($photoSearchList->getFormField('act') == 'favorite_delete')
	{
		$photo_id_arr = explode(',', $photoSearchList->getFormField('photo_id'));
		foreach($photo_id_arr as $photo_id)
		{
			$photoSearchList->deleteFavoritePhoto($photo_id, $CFG['user']['user_id']);
		}
	}
	if ($photoSearchList->getFormField('act') == 'playlist_delete')
	{
		$photo_id_arr = explode(',', $photoSearchList->getFormField('photo_id'));
		foreach($photo_id_arr as $photo_id)
		{
			$photoSearchList->deletePlaylistPhoto($photo_id);
		}
	}
	if ($photoSearchList->getFormField('act') == 'set_playlist_thumb')
	{
		$photo_id = $photoSearchList->getFormField('photo_id');
		$photoSearchList->setPlaylistThumbnail($photo_id);
	}
	if ($photoSearchList->getFormField('act') == 'set_album_thumb')
	{
		$photo_id = $photoSearchList->getFormField('photo_id');
		$album_id = $photoSearchList->getFormField('album_id');
		$photoSearchList->updateAlbumProfileImage($photo_id, $album_id);
	}
}

$photoSearchList->category_name = '';
if ($photoSearchList->isShowPageBlock('form_show_sub_category'))
{
    $photoSearchList->populateSubCategories();
    $photoSearchList->category_name = $photoSearchList->getCategoryName();
    $photoSearchList->LANG['photolist_category_title'] = str_replace('{category}', $photoSearchList->category_name, $LANG['photolist_category_title']);
}
$photoSearchList->LANG['photolist_title'] = html_entity_decode($photoSearchList->getPageTitle());
// generation Detail & Thumb Link
if ($CFG['feature']['rewrite_mode'] != 'normal')
	$thum_details_arr = array('start','album_id', 'cid', 'tags', 'user_id', 'action','photo_album_name','photo_owner','photo_keyword','advan_photo_album_name','advan_photo_owner','location','added_within','advanceFromSubmission','view', 'photo_title', 'advan_photo_title', 'titles', 'myphoto', 'myfavoritephoto');
else
    $thum_details_arr = array('start','album_id', 'cid', 'tags', 'user_id', 'pg', 'action','photo_album_name','photo_owner','photo_keyword','advan_photo_album_name','advan_photo_owner','location','added_within','advanceFromSubmission','view', 'photo_title', 'advan_photo_title', 'titles', 'myphoto', 'myfavoritephoto');
$photoSearchList->showThumbDetailsLinks_arr = $photoSearchList->showThumbDetailsLinks($thum_details_arr);
if ($photoSearchList->isShowPageBlock('msg_form_error'))
{
    $photoSearchList->msg_form_error['common_error_msg'] = $photoSearchList->getCommonErrorMsg();
}
if ($photoSearchList->isShowPageBlock('msg_form_success'))
{
    $photoSearchList->msg_form_success['common_error_msg'] = $photoSearchList->getCommonErrorMsg();
}

if ($photoSearchList->isShowPageBlock('my_photos_form'))
{
    /**
     * ***** navigtion continue********
     */
    $photoSearchList->group_query_arr = array('myrecentlyviewedphoto','photomostfavorite','featuredphotolist','photomostviewed','photomostdiscussed','albumlist');
    $photoSearchList->setTableAndColumns();
    $photoSearchList->buildSelectQuery();
    //$photoSearchList->buildConditionQuery($condition);
    $photoSearchList->buildQuery();
    //$photoSearchList->printQuery();

	//if (in_array($photoSearchList->getFormField('pg'), $group_query_arr))
        $photoSearchList->homeExecuteQuery();
    //else
      //  $photoSearchList->executeQuery();
    /**
     * ****** Navigation End *******
     */
     if($photoSearchList->getFormField('tags'))
		{
			$photoSearchList->advanceSearch = true;
		}
    $photoSearchList->my_photos_form['anchor'] = 'anchor';
    $photoSearchList->isResultsFound = $photoSearchList->isResultsFound();
    if ($CFG['feature']['rewrite_mode'] != 'normal')
        $paging_arr = array('start','album_id', 'cid', 'tags', 'user_id', 'action','photo_album_name','photo_owner','photo_keyword','advan_photo_album_name','advan_photo_owner','location','added_within','advanceFromSubmission','view', 'photo_title', 'advan_photo_title', 'titles', 'myphoto', 'myfavoritephoto', 'thumb');
    else
        $paging_arr = array('start','album_id', 'cid', 'tags', 'user_id', 'pg', 'action','photo_album_name','photo_owner','photo_keyword','advan_photo_album_name','advan_photo_owner','location','added_within','advanceFromSubmission','view', 'photo_title', 'advan_photo_title', 'titles', 'myphoto', 'myfavoritephoto', 'thumb');
	$smartyObj->assign('paging_arr',$paging_arr);
    if ($photoSearchList->isResultsFound())
	{
        if ($CFG['feature']['rewrite_mode'] != 'normal')
            $paging_arr = array('start','album_id', 'cid', 'tags', 'user_id', 'action','photo_album_name','photo_owner','photo_keyword','advan_photo_album_name','advan_photo_owner','location','added_within','advanceFromSubmission','view', 'photo_title', 'advan_photo_title', 'titles', 'myphoto', 'myfavoritephoto', 'thumb');
        else
            $paging_arr = array('start','album_id', 'cid', 'tags', 'user_id', 'pg', 'action','photo_album_name','photo_owner','photo_keyword','advan_photo_album_name','advan_photo_owner','location','added_within','advanceFromSubmission','view', 'photo_title', 'advan_photo_title', 'titles', 'myphoto', 'myfavoritephoto', 'thumb');
 	    $smartyObj->assign('paging_arr',$paging_arr);
		$smartyObj->assign('smarty_paging_list', $photoSearchList->populatePageLinksPOST($photoSearchList->getFormField('start'), 'seachAdvancedFilter'));
        switch ($photoSearchList->getFormField('pg'))
		{
            case 'useralbumlist':
                if (!$photoSearchList->isMe($photoSearchList->ALBUM_USER_ID= $photoSearchList->chkValidAlbumId()))
                    break;
            case 'myphotos':
                $photoSearchList->setPageBlockShow('check_all_item');
                break;
            case 'myfavoritephotos':
                $photoSearchList->setPageBlockShow('check_all_item');
                break;
            case 'myplaylist':
                $photoSearchList->setPageBlockShow('check_all_item');
                break;
        }
        $photoSearchList->my_photos_form['showPhotoList'] = $photoSearchList->showPhotoList();
        $photoIds=implode('\',\'',$photoSearchList->photo_id_arr);
    }

if ($photoSearchList->isShowPageBlock('block_add_location'))
{
	$photoSearchList->includeHeader();
	if($photoSearchList->getFormField('photo_id'))
	{
		$photoSearchList->getPhotoLocation();
	}
    ?>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=<?php echo $CFG['admin']['photos']['google_map_key'];?>" type="text/javascript"></script>
    <script type="text/javascript">
        var pageName='<?php echo $photoSearchList->getFormField('page');?>';
		var googleMap
	 	var address
	 	var marker
	 	var geocoder;
	 	var center;
	 	var zoomlevel;
	 	var markerpin=0;
	 	var locationedit = 0;
	 	var oldaddress = '<?php echo $photoSearchList->getFormField('address');?>';
		//Initialize the google map api and also set defalt marker.
     	function initializegoogleMap()
		{
	  		$Jq('#results').html('');
      		if (GBrowserIsCompatible())
			{
        		googleMap = new GMap2(document.getElementById("map_canvas"));
        		<?php
					if($photoSearchList->getFormField('latitude') == 0 && $photoSearchList->getFormField('longitude') == 0)
					{
				?>
	        			center = new GLatLng(<?php echo $CFG['admin']['photos']['default_latitude'];?>,<?php echo $CFG['admin']['photos']['default_longitude'];?>);
	        			zoomlevel = 1;
	        			//center = new GLatLng(34,0);
	        	<?php
	        		}
	        		else
	        		{
	        	?>
						center = new GLatLng(<?php echo $photoSearchList->getFormField('latitude');?>,<?php echo $photoSearchList->getFormField('longitude');?>);
						zoomlevel = 13;
				<?php
					}
				?>

	        	geocoder = new GClientGeocoder();
				googleMap.setCenter(center, zoomlevel);
				googleMap.setUIToDefault();
				<?php
					if($photoSearchList->getFormField('address')!='' && $photoSearchList->getFormField('latitude')!=0 && $photoSearchList->getFormField('longitude')!=0)
					{
				?>
						$Jq('#selLocationTextBox').css('display', 'none');
						$Jq('#selSeletedArea').html('<?php echo $photoSearchList->getFormField('address');?>');
						$Jq('#selChange').css('display', 'block');
						$Jq('#selRemove').css('display', 'block');
						$Jq('#selInitialStep').css('display', 'none');
						locationedit = 1;
	        			setMarker(center);
	        	<?php
	        		}
	        		else
	        		{
	        			if($photoSearchList->getFormField('address')!='')
	        			{
				?>
							$Jq('#selLocationTextBox').css('display', 'none');
							$Jq('#selSeletedArea').html('<?php echo $photoSearchList->getFormField('address');?>');
							$Jq('#selPin').css('display', 'block');
							$Jq('#selChange').css('display', 'block');
							$Jq('#selRemove').css('display', 'block');
							$Jq('#selInitialStep').css('display', 'none');
							locationedit = 1;
	        		//	setMarker(center);
				<?php
	        			}
	        		}

	        	?>
      		}
    	}
    	/**
    	 *
    	 * @access public
    	 * @return void
    	 **/
    	function setSearch(){

    		if(markerpin!=1)
    		{
    			$Jq('#selSearchNote').css('display', 'block');
    			$Jq('#selPin').css('display', 'block');
    		}
    		else
    		{
    			$Jq('#selSearchNote2').css('display', 'block');
    		}
			$Jq('#selLocationTextBox').css('display', 'block');
			$Jq('#selCancel').css('display', 'block');
			$Jq('#selInitialStep').css('display', 'none');
			$Jq('#selRemove').css('display', 'none');
			if($Jq('#location').val()!='<?php echo $LANG['photo_location_city_name'];?>')
			{
				$Jq('#selUpdateButton').css('display', 'block');
			}else
			{
				$Jq('#selUpdateButton').css('display', 'none');
			}

	   	}
    	/**
    	 *
    	 * @access public
    	 * @return void
    	 **/
    	function setMarkerOnMap(){
    		setMarker(center);
    		markerpin = 1;
    		$Jq('#selPin').css('display', 'none');
    		$Jq('#selSearchNote').css('display', 'none');
    		if(locationedit!=1)
	        	$Jq('#selCancel').css('display', 'block');
	        $Jq('#selHelpNote').css('display', 'block');
    	}
    	/**
    	 *
    	 * @access public
    	 * @return void
    	 **/
    	function emptyTextBox(){
    		$Jq('#location').val('');
    	}
    	/**
    	 *
    	 * @access public
    	 * @return void
    	 **/
    	function refileValue(val){
    		if($Jq('#location').val() == '')
    			$Jq('#location').val(val);
    	}
		//set marker using lat and lan.
		function setMarker(center)
		{
			marker = new GMarker(center, {draggable: true});
			GEvent.addListener(marker, "dragstart", function() {
				googleMap.closeInfoWindow();
			});
			// add a drag listener to the map
			GEvent.addListener(marker, "dragend", function() {
				var point = marker.getPoint();
				googleMap.panTo(point);
				var latlng ='('+point.lat()+','+point.lng()+')';
				geocoder.getLocations(latlng, showAddress);
			});
			googleMap.addOverlay(marker);
		}
		// in change the marker place give the place address.
    	function showAddress(response)
		{
	    	googleMap.clearOverlays();
      		if (!response || response.Status.code != 200)
			{
        		alert("Status Code:" + response.Status.code);
      		}
			else
			{
				place = response.Placemark[0];
        		point = new GLatLng(place.Point.coordinates[1],
                place.Point.coordinates[0]);
                googleMap.setCenter(point, 13);
        		setMarker(point);
        		$Jq('#latitude').val(point.lat());
				$Jq('#longitude').val(point.lng());
	        	marker.openInfoWindowHtml('<b>Address:</b>' + place.address + '<br>');
	        	if(locationedit!=1)
	        	{
		        	markerpin = 1;
		        	$Jq('#selLocationTextBox').css('display', 'block');
		        	$Jq('#selSeletedArea').css('display', 'block');
		        	$Jq('#selSeletedArea').html(place.address);
		        	$Jq('#location').val(place.address);
		        	$Jq('#address').val(place.address);
		        	$Jq('#selChange').css('display', 'none');
		        	$Jq('#selPin').css('display', 'none');
		        	$Jq('#selCancel').css('display', 'block');
		        	$Jq('#selUpdateButton').css('display', 'block');
		        }
		        else
		        {
		        	markerpin = 1;
		        	$Jq('#selLocationTextBox').css('display', 'block');
		        	$Jq('#selSeletedArea').css('display', 'block');
		        	$Jq('#selSeletedArea').html(place.address);
		        	$Jq('#location').val(place.address);
		        	$Jq('#address').val(place.address);
		        	$Jq('#selChange').css('display', 'none');
		        	$Jq('#selPin').css('display', 'none');
		        	$Jq('#selRemove').css('display', 'none');
		        	$Jq('#selCancel').css('display', 'block');
		        	$Jq('#selUpdateButton').css('display', 'block');
		        }
      		}
    	}

		function getNewPosition(add)
		{
			var idval = add+'_place';
			var location = $Jq('#'+idval).html();
			showLocation(location);
			$Jq('#location').val(location);
			$Jq('#results').html('');
			$Jq('#results').css('display', 'none');
		}
		// geo code autocomplete.
		function sendcode()
		{
		    $Jq('#results').css('display', 'block');
		    $Jq('#selUpdateButton').css('display', 'block');
      		if (GBrowserIsCompatible())
			{
	   			var partial_location = $Jq('#location').val();
	   			/*if(partial_location.length >= 1)
	   				$('selUpdateButton').style.display = 'block';
	   			else
	   				$('selUpdateButton').style.display = 'none'; */
	   			var geocoder = new google.maps.Geocoder();
	   			geocoder.geocode({'address': partial_location}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK)
					{
						$Jq('#results').html('');
						for (var i = 0; i<results.length; i++)
						{
							showResult(results[i], i);
						}
					}
					else
					{
						$Jq('#results').html('');
					}
				});
			}
  		}
		// show the related address when we type the character in text box.
  		function showResult(result, i)
		{
			//$('results').style.display = 'block';
	    	document.getElementById('results').innerHTML += '<div onclick="getNewPosition('+i+');" id="'+i+'_place">' + result.formatted_address + '</div>';
		}
		// showLocation() is called when you click on the Search button
		// in the form.  It geocodes the address entered into the form
		// and adds a marker to the map at that location.
		function showLocation(address)
		{
		  	geocoder.getLocations(address, showAddress);
		}
		function changeLocation()
		{
			$Jq('#results').css('display', 'none');
			$Jq('#selLocationTextBox').css('display', 'block');
	        $Jq('#selSeletedArea').css('display', 'none');
	        $Jq('#selChange').css('display', 'none');
	        $Jq('#selCancel').css('display', 'block');
	        $Jq('#location').val('');
	        $Jq('#selUpdateButton').css('display', 'none');
	        $Jq('#selRemove').css('display', 'none');
	        $Jq('#selHelpNote').css('display', 'block');

		}
		function cancelChange()
		{
			if(locationedit!=1)
			{
				$Jq('#results').css('display', 'none');
				$Jq('#selSeletedArea').css('display', 'none');
				$Jq('#selLocationTextBox').css('display', 'none');
				$Jq('#selCancel').css('display', 'none');
				$Jq('#selInitialStep').css('display', 'block');
				$Jq('#selHelpNote').css('display', 'none');
				$Jq('#selUpdateButton').css('display', 'none');
				$Jq('#selSearchNote2').css('display', 'none');
				$Jq('#results').html('');
				$Jq('#results').css('display', 'none');
				$Jq('#selSearchNote').css('display', 'none');
	    			$Jq('#selPin').css('display', 'none');
	    	}
	    	else
	    	{
				$Jq('#selSeletedArea').css('display', 'block');
				$Jq('#selChange').css('display', 'block');
				$Jq('#selRemove').css('display', 'block');
				$Jq('#selCancel').css('display', 'none');
				$Jq('#selLocationTextBox').css('display', 'none');
				$Jq('#selUpdateButton').css('display', 'none');
				$Jq('#selHelpNote').css('display', 'none');
				$Jq('#selSeletedArea').html(oldaddress);
				$Jq('#results').html('');
				$Jq('#results').css('display', 'none');
	    	}

			//initializegoogleMap();
		}
		function removeLocation(url, div_id)
		{
			var div_value = $Jq('#'+div_id).html();
			result_div = div_id;
			div_value = $Jq.trim(div_value);
			pars = '';
			//added code to remove the location in the photoListing page
			photolist_div_id = 'photoLocation_'+$Jq('#photo_id_location').val();
			var photolist_obj = parent.document.getElementById(photolist_div_id);
			if(photolist_obj)
				photolist_obj.innerHTML = '';
			//end of code added to remove the location
			var myAjax = new jquery_ajax(url, pars, 'removeLocationDb');

		}
		function removeLocationDb(data)
		{
			data = unescape(data);
			data = data.split('***--***!!!');
			if(data[1]=='Yes')
			{
				$Jq('#'+result_div).get(0);
				$Jq('#'+result_div).css('display', 'block');
				$Jq('#'+result_div).html('<?php echo $LANG['common_successful_remove'];?>');
				$Jq('#location').val('<?php echo $LANG['photo_location_city_name'];?>');
				$Jq('#selInitialStep').css('display', 'block');
				$Jq('#selLocationTextBox').css('display', 'none');
	        	$Jq('#selSeletedArea').css('display', 'none');
				$Jq('#selUpdateButton').css('display', 'none');
				$Jq('#selCancel').css('display', 'none');
				$Jq('#selChange').css('display', 'none');
				$Jq('#selRemove').css('display', 'none');
				$Jq('#selHelpNote').css('display', 'none');
				$Jq('#selSearchNote').css('display', 'none');
				$Jq('#selSearchNote2').css('display', 'none');
				locationedit = 0;
			}
			 // for update google map in view photo page.(when page opened from view photo page)
    	    if(pageName =='viewphoto')
			   parent.removeLocation();
			else if(pageName =='upload')
			{
			   parent.document.getElementById('location_recorded').readOnly = false;
			   parent.document.getElementById('location_recorded').value = '';
			   parent.document.getElementById('location_recorded').readOnly = true;
			}
		}
		function updateLocation(url, div_id)
		{
			$Jq('#results').css('display', 'none');
			var div_value = $Jq('#'+div_id).html();
			result_div = div_id;
			div_value = $Jq.trim(div_value);
			pars = '';
			var frm = document.addLocation;
			for (var i=0;i<frm.elements.length;i++)
			{
				var e=frm.elements[i];
				//if(e.value!='')
				pars += '&'+e.name+'='+e.value;
			}
			var myAjax = new jquery_ajax(url, pars, 'insertLocation');

		}

		function insertLocation(data)
		{
			data = unescape(data);
			$Jq('#'+result_div).get(0);
			$Jq('#'+result_div).css('display', 'block');
			$Jq('#'+result_div).html('<?php echo $LANG['common_successful_update'];?>');
			locationedit = 1;
			$Jq('#selHelpNote').css('display', 'none');
			$Jq('#selSearchNote').css('display', 'none');
			$Jq('#selSearchNote2').css('display', 'none');
			$Jq('#selLocationTextBox').css('display', 'none');
        	$Jq('#selSeletedArea').css('display', 'block');
        	$Jq('#selSeletedArea').html($Jq('#location').val());
        	oldaddress = $Jq('#location').val();
			$Jq('#selUpdateButton').css('display', 'none');
			$Jq('#selCancel').css('display', 'none');
			$Jq('#selChange').css('display', 'block');
			$Jq('#selRemove').css('display', 'block');
			//added code to update the link and location in the photoListing page
			//to do provide the correct url and lang value for location
			photolist_div_id = 'photoLocation_'+$Jq('#photo_id_location').val();
			var photolist_obj = parent.document.getElementById(photolist_div_id);
			var hreflocation = '<?php echo $CFG['site']['photo_url'];?>photoList.php?type=view_location_photos&photo_location_recorded='+oldaddress;
			var location_str = '<p class="clsLeft">Location: </p><p class="clsRight clsLocationLink">'
			location_str += '<a href="'+hreflocation+'" id="link_location" >'+oldaddress+'</a>';
			if(photolist_obj)
				photolist_obj.innerHTML = location_str+'</p>';

			//end of code added to update the link and location in the photoListing page
		    // for update google map in view photo page.(when page opened from view photo page)
    	    if(pageName =='viewphoto')
			   parent.reInitialize($Jq('#latitude').val(),$Jq('#longitude').val(),$Jq('#location').val());
			else if(pageName =='upload')
			{
			   parent.document.getElementById('location_recorded').readOnly = false;
			   parent.document.getElementById('location_recorded').value = $Jq('#location').val();
			   parent.document.getElementById('location_recorded').readOnly = true;
			}
		}
	</script>
	<?php

		setTemplateFolder('general/', 'photo');
		$smartyObj->assign('photo_id', $photoSearchList->getFormField('photo_id'));
		$smartyObj->display('addPhotoLocation.tpl');
		//$photoSearchList->includeFooter();
		exit;
}

if($photoSearchList->isShowPageBlock('block_view_location_photos'))
{

	if($photoSearchList->getFormField('photo_location_recorded'))
	{
		$location_photo_details=$photoSearchList->getLocationPhotosDetails();
		$total_photos = count($location_photo_details);
$image_string ='<div id="loopedSlider"> <div class="clsLightBoxSlideContainer"><div class="slides">';
				for($i=0;$i<$total_photos;$i++)
			  	{
					$image_string .='<div class="cls191x144 clsImageHolder clsPointer clsUserThumbImageOuter"><img src="'.$location_photo_details[$i]['thumb_img_src'].'" alt="" /></div>';
				}
$image_string .='</div></div><a href="#" class="previous">previous</a><a href="#" class="next">next</a></div>';
			$photoSearchList->includeHeader();
		?>
		<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/lib/jquery.js"></script>
		<script type="text/javascript">
		var $Jq = jQuery.noConflict();
		</script>

		<script type="text/javascript" src="<?php echo $CFG['site']['photo_url'];?>js/google_slide.js"></script>
		<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $CFG['admin']['photos']['google_map_key'];?>&sensor=true" type="text/javascript"></script>
		<script type="text/javascript">
		function initializeViewPhoto() {
      		if (GBrowserIsCompatible()) {
        		var googleMap = new GMap2($Jq("#map_canvas").get(0));
        		googleMap.setCenter(new GLatLng(<?PHP echo $location_photo_details['0']['photos_lat']; ?>, <?PHP echo $location_photo_details['0']['photos_lan'];?>), 13);
				googleMap.setUIToDefault();
        		function createMarker(point) {
			  		var marker = new GMarker(point);
			  		GEvent.addListener(marker, "click", function() {
			  			myHtml = '<?php echo $image_string; ?>';
			    		googleMap.openInfoWindowHtml(point, myHtml);
			    		eval($Jq('#loopedSlider').get(0));

			  		});

					myHtml = '<?php echo $image_string; ?>';
		    		googleMap.openInfoWindowHtml(point, myHtml);
		    		eval($Jq('#loopedSlider').get(0));

			  		return marker;
				}
            	var point = new GLatLng(<?PHP echo $location_photo_details['0']['photos_lat'];?>,<?PHP echo $location_photo_details['0']['photos_lan'];?>);
		    	googleMap.addOverlay(createMarker(point));
      		}
    	}

		</script>
    	<?php
		//echo '<pre>'; print_r($location_photo_details); echo '</pre>';
	}
    ?>

	<?php
		setTemplateFolder('general/', 'photo');
		$smartyObj->display('viewLocationPhotos.tpl');
		//$photoSearchList->includeFooter();
		exit;
}
// include the header file
$photoSearchList->includeHeader();
?>
<script type="text/javascript" language="javascript">
total_photos_to_play = <?php echo count($photoSearchList->player_photo_id); ?>;
<?php
	if(count($photoSearchList->player_photo_id) != 0)
	{
		foreach($photoSearchList->player_photo_id as $photo_id_to_play)
		{
			echo 'total_photos_ids_play_arr.push('.$photo_id_to_play.');';
		}
	}
?>
</script>
<?php
}
// include the content of the page
setTemplateFolder('general/', 'photo');
$smartyObj->display('photoSearchList.tpl');
// includ the footer of the page
?>
<script type="text/javascript">
var photo_location_ids = Array('<?php echo $photoIds?>');
function getLocationFromDB(url,div_id)
{
	var partial_location = $Jq('#advantage_location').val();
	var div_value = $Jq('#'+div_id).html();
		result_div = div_id;
		div_value = $jq.trim(div_value);
		pars = '';
		pars += '&location='+partial_location;
		var myAjax = new jquery_ajax(url, pars, 'getLocation');

}
function getLocation(data)
{
	data = unescape(data);
	$Jq('#'+result_div).get(0);
	$jq('#'+result_div).css('display', 'block');
	$jq('#'+result_div).html(data);
}
function setDbLocation(add)
{
	var idval = add+'_place';
	var location = $Jq('#'+idval).html();
	$Jq('#advantage_location').val(location);
	$Jq('#selResult').html('');
}


</script>
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
var start_js_photo_id='';
var start_counter=0;
var start_js_image='';
function processImageRepeat()
{

}

function processImage(id, photo_id)
{
	start_js_animation=true;
	start_js_id=id;
	start_js_photo_id=photo_id;

	//tTimeout('processImageRepeat()', 200);
}

function clearValue(id)
{
	$Jq('#'+id).val('');
}
function setOldValue(id)
{
	if (($Jq('#'+id).val()=="") && (id == 'advantage_photo_album_name') )
		$Jq('#'+id).val('<?php echo $LANG['photolist_album_name']?>');
	if (($Jq('#'+id).val()=="") && (id == 'advantage_photo_owner') )
		$Jq('#'+id).val('<?php echo $LANG['photolist_photo_created_by']?>');
	if (($Jq('#'+id).val()=="") && (id == 'advantage_location') )
		$Jq('#'+id).val('<?php echo $LANG['photolist_photo_location']?>');
	if (($Jq('#'+id).val()=="") && (id == 'advance_keyword') )
		$Jq('#'+id).val('<?php echo $LANG['photolist_keyword_field']?>');
}
function loadUrl(element)
{
	//set the start value as 0 when click the order by field
	document.seachAdvancedFilter.start.value = '0';
	//var defaultVal = "<?php echo getUrl('photolist','pg=photonew','photonew/','','photo');?>";
	//if(element.value != defaultVal)
	$Jq('#default').val('No');
	document.seachAdvancedFilter.action=element.value;
	document.seachAdvancedFilter.submit();
}
function jumpAndSubmitForms(path)
{
	//set the start value as 0 when click the alphabetical letters
	document.seachAdvancedFilter.start.value = '0';
	$path_url='<?php echo $Navigation_list_arr['photo_list_url_0']; ?>';
	var url=$path_url+'&titles='+path;
	document.seachAdvancedFilter.action=url;
	document.seachAdvancedFilter.submit();
}
function jumpAndFormsubmit(path)
{
	//set the start value as 0 when click the sort by field
	document.seachAdvancedFilter.start.value = '0';
	$path_url='<?php echo $Navigation_arr['photo_list_url_0']; ?>';
	url=$path_url+'&view='+path+'&titles=<?php echo $photoSearchList->getFormField("titles");?>';
	document.seachAdvancedFilter.action=url;
	document.seachAdvancedFilter.submit();
}

function popupWindow(url)
{
	 window.open (url, "","status=0,toolbar=0,resizable=1,scrollbars=1");
	 return false;
}
$Jq("#selHideSubcategory").click(function()
{
	$Jq("#selShowAllShoutouts").slideUp('slow');
	$Jq("#selHideSubcategory").css('display', 'none');
	$Jq("#selShowSubcategory").css('display', 'block');
})
$Jq("#selShowSubcategory").click(function()
{
	$Jq("#selShowAllShoutouts").slideDown('slow');
	$Jq("#selHideSubcategory").css('display', 'block');
	$Jq("#selShowSubcategory").css('display', 'none');
})

$Jq(document).ready(function(){
		$Jq('#link_location').fancybox({
			'width'				: 865,
			'height'			: 336,
			'autoScale'     	: false,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'type'				: 'iframe'
		});
	});

</script>

<?php
$photoSearchList->includeFooter();
?>
