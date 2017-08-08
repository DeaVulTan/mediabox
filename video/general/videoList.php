<?php
/**
 * VideoList
 *
 * @package
 * @author selvaraj_35ag05
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: videoList.php 2986 2006-12-29 05:25:10Z selvaraj_35ag05 $
 * @access public
 */

// <<<<<-------------- Class VideoUpload begins ---------------//
class VideoList extends VideoHandler {
    /**
     * VideoList::getPageTitle()
     * access :: Public
     *
     * @return $pg_title
     */
    public $slideShowUrl;
    public $advanceSearch;

    /**
     * VideoList::getPageTitle()
     *
     * @return
     */
    public function getPageTitle()
    {
        $pg_title = $this->LANG['videolist_videonew_title'];

		//If default value is Yes then reset the pg value as null.
	    /*if($this->getFormField('default')== 'Yes')
			$this->fields_arr['pg'] = 'videonew';*/

		$categoryTitle = '';
		$tagsTitle     = '';

        switch ($this->fields_arr['pg']) {
            case 'myvideos':
                $pg_title = $this->LANG['videolist_myvideos_title'];
                break;

            case 'myfavoritevideos':
                $pg_title = $this->LANG['videolist_myfavoritevideos_title'];
                break;

            case 'myrecentlyviewedvideo':
                $pg_title = $this->LANG['videolist_myrecentlyviewedvideo_title'];
                break;

            case 'featuredvideolist':
                $pg_title = $this->LANG['videolist_featuredvideolist_title'];
                break;

            case 'randomvideo':
            	$pg_title = $this->LANG['videolist_videorandom_title'];
                break;

            case 'videonewmale':
                $pg_title = $this->LANG['videolist_videonewmale_title'];
                break;

            case 'videonewfemale':
                $pg_title = $this->LANG['videolist_videonewfemale_title'];
                break;

            case 'videotoprated':
                $pg_title = $this->LANG['videolist_videotoprated_title'];
                break;

            case 'videorecommended':
                $pg_title = $this->LANG['videolist_videorecommended_title'];
                break;

            case 'videomostviewed':
                $pg_title = $this->LANG['videolist_videomostviewed_title'];
                break;

            case 'videomostdiscussed':
                $pg_title = $this->LANG['videolist_videomostdiscussed_title'];
                break;

            case 'videomostfavorite':
                $pg_title = $this->LANG['videolist_videomostfavorite_title'];
                break;

            case 'videomostrecentlyviewed':
                $pg_title = $this->LANG['videolist_videomostrecentlyviewed_title'];
                break;

            case 'uservideolist':
                $pg_title = $this->LANG['videolist_uservideolist_title'];
                $name = $this->getUserDetail('user_id', $this->fields_arr['user_id'], 'user_name');
				$name = '<a href="'.getUrl('viewprofile','?user='.$name, $name.'/').'">'.ucfirst($name).$this->LANG['videolist_uservideolist_s'].'</a>';
                $pg_title = str_replace('{user_name}', $name, $pg_title);
                break;

            case 'myalbumvideolist':
                $pg_title = $this->LANG['videolist_albumvideolist_title'];
                $name = $this->getAlbumName();
                $pg_title = str_replace('{album_name}', $name, $pg_title);

                break;

            case 'albumvideolist':
                $pg_title = $this->LANG['videolist_myalbumvideolist_title'];
                $name = $this->getAlbumName();
                $pg_title = ucfirst(str_replace('{album_name}', $name, $pg_title));

                break;

            case 'albumlist':
                $pg_title = ucfirst($this->LANG['videolist_albumlist_title']);
                break;
            case 'myplaylist':
                $pg_title = $this->LANG['videolist_playilst'];
                $name = $this->getPlaylistName();

                $pg_title = ucfirst(str_replace('{playlist_name}', $name, $pg_title));

                break;
            case 'videoresponseslist':
            	$this->video_details=$this->getVideoDetails(array('video_title'),$this->fields_arr['video_id']);
            	$title = $this->video_details['video_title'];
            	$title_wrapped = $this->video_details['video_title'];
            	$link=getUrl('viewvideo','?video_id='.$this->fields_arr['video_id'].'&video_title='.$this->changeTitle($title),$this->fields_arr['video_id'].'/'.$this->changeTitle($title).'/','','video');
            	$title_text='<a href="'.$link.'">'.$title_wrapped.'</a>';
            	$this->LANG['videolist_videoresponselist_title']=str_replace('{video_title}',$title_text,$this->LANG['videolist_videoresponselist_title']);
                $pg_title = $this->LANG['videolist_videoresponselist_title'];
                break;

            case 'videomostlinked':
                $pg_title = $this->LANG['videolist_videomostlinked_title'];
                break;
            case 'videomostresponded':
                $pg_title = $this->LANG['videolist_videomostresponded_title'];
                break;

            default:// videonew
                $pg_title = $this->LANG['videolist_videonew_title'];
                if ($this->fields_arr['cid'] || $this->fields_arr['sid']) {
                    $pg_title = $this->LANG['videolist_categoryvideo_title'];
                    if (!$this->category_name)
                        $name = $this->getCategoryVideoName();
                    else
                        $name = $this->category_name;
                    $pg_title = str_replace('{category_name}', $name, $pg_title);

                }
                if ($this->fields_arr['tags']) {
                    $pg_title = $this->LANG['videolist_tagsvideo_title'];
                    $name = $this->fields_arr['tags'];
                    $pg_title = str_replace('{tags_name}', $name, $pg_title);

                }
                if ($this->fields_arr['keyword']) {
                    $pg_title = $this->LANG['videolist_tagsvideo_title'];
                    $name = $this->fields_arr['keyword'];
                    $pg_title = str_replace('{tags_name}', $name, $pg_title);

                }
                break;
        }

		  //change the page title if other user video is selected
		  if($this->fields_arr['pg'] != 'uservideolist' && $this->fields_arr['user_id'] != 0) {
			  $members_title = $this->LANG['videolist_uservideolist_title'];
	          $name = $this->getUserDetail('user_id', $this->fields_arr['user_id'], 'user_name');
			  $name = '<a href="'.getUrl('viewprofile','?user='.$name, $name.'/').'">'.ucfirst($name).$this->LANG['videolist_uservideolist_s'].'</a>';
	          $members_title = str_replace('{user_name}', $name, $members_title);
	          if($this->fields_arr['pg'] == 'videonew')
	          	$pg_title = $members_title;
	          else
			  	$pg_title = $pg_title.' '.$this->LANG['videolist_in'].' '.$members_title;
          }

		 //change the page title if my video is selected
		 if ($this->fields_arr['myvideo'] == 'Yes' && $this->fields_arr['pg'] != 'myvideos') {
		 	$pg_title = $pg_title.' '.$this->LANG['videolist_in'].' '.$this->LANG['videolist_myvideos_title'];
		 	if($this->fields_arr['pg'] == 'videonew')
		 		$pg_title = $this->LANG['videolist_myvideos_title'];
		 }

		 //change the page title if my favorite is selected
		 if ($this->fields_arr['myfavoritevideo'] == 'Yes' && $this->fields_arr['pg'] != 'myfavoritevideos') {
		 	$pg_title = $pg_title.' '.$this->LANG['videolist_in'].' '.$this->LANG['videolist_myfavoritevideos_title'];
		 	if($this->fields_arr['pg'] == 'videonew')
		 		$pg_title = $this->LANG['videolist_myfavoritevideos_title'];
		 }

		//change the page title if recored display via category, tags
		if ($this->fields_arr['cid'] || $this->fields_arr['sid'] ){
            $categoryTitle = $this->LANG['videolist_categoryvideo_title2'];
			if($this->fields_arr['pg'] == 'videonew')
				$categoryTitle = $this->LANG['videolist_categoryvideo_title'];

            if (!$this->category_name)
                $name = $this->getVideoCategoryName();
            else
                $name = $this->category_name;
            $categoryTitle = str_replace('{category_name}', $name, $categoryTitle);
        }
		if(($this->fields_arr['pg'] || $this->getFormField('default')== 'Yes') && $this->fields_arr['cid']){
			if($this->fields_arr['pg'] == 'videonew')
				$pg_title = $categoryTitle;
			else
				$pg_title = $pg_title.' '.$this->LANG['videolist_in'].' '.$categoryTitle;

		}

		if ($this->fields_arr['tags']){
			$tagsTitle = $this->LANG['videolist_tagsvideo_title2'];
			if($this->fields_arr['pg'] == 'videonew')
				$tagsTitle = $this->LANG['videolist_tagsvideo_title'];
            $name = $this->fields_arr['tags'];
            $tagsTitle = str_replace('{tags_name}', $name, $tagsTitle);
        }
		if(($this->fields_arr['pg'] || $this->getFormField('default')== 'Yes')&& $this->fields_arr['tags']){
			if($this->fields_arr['pg'] == 'videonew')
				$pg_title = $tagsTitle;
			else
				$pg_title = $pg_title.' '.$tagsTitle;
		}

		$pg_title = truncateByCheckingHtmlTags($pg_title, $this->CFG['admin']['videos']['video_list_title_length'], '...', true, true);

        return $pg_title;
    }

    /**
     * VideoList::showThumbDetailsLinks()
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
        foreach($field_names_arr as $field_name) {
            if (is_array($this->fields_arr[$field_name])) {
                foreach($this->fields_arr[$field_name] as $sub_field_value)
                $query_str .= "&amp;" . $field_name . "[]=$sub_field_value";
            } else if ($this->fields_arr[$field_name] != '')
                $query_str .= "&amp;$field_name=" . $this->fields_arr[$field_name];
        }
        $return['class_thumb_yes'] = $this->fields_arr['thumb'] == 'yes'?'clsSearchActive':'';
        $return['class_thumb_no'] = $this->fields_arr['thumb'] != 'yes'?'clsSearchActive':'';
        $return['url'] = $html_url;
        $return['query_string'] = $query_str;
        return $return;
    }
    /**
     * VideoList::showVideoList()
     *
     * @return
     */
    public function showVideoList()
    {
        global $smartyObj;
        // for tags
        $separator = ':&nbsp;';
        $tag = $this->_parse_tags(strtolower($this->fields_arr['tags']));
        $relatedTags = array();
        $return = array();
        $result_arr = array();
        $userid_arr = array();
        $inc = 0;
        $album_id = '';
        $user_ids = '';
        // $videosPerRow = 4;
        $this->CFG['admin']['videos']['num_videos_thumb_view_per_rows'] = ($this->fields_arr['pg'] == 'myvideos')?$this->CFG['admin']['videos']['num_videos_my_videos_thumb_view_per_rows']:$this->CFG['admin']['videos']['num_videos_thumb_view_per_rows'];
        $videosPerRow = ($this->fields_arr['thumb'] == 'yes')?$this->CFG['admin']['videos']['num_videos_thumb_view_per_rows']:$this->CFG['admin']['videos']['num_videos_detail_view_per_rows'];
        $count = 0;
        $found = false;
        $videos_folder = $this->CFG['media']['folder'].'/'.
							$this->CFG['admin']['videos']['folder'].'/'.
								$this->CFG['admin']['videos']['thumbnail_folder'].'/';

        $cssImage_folder = $this->CFG['site']['url'].'video/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/';
        // $rayzz = new RayzzHandler($this->dbObj, $this->CFG);
        $fields_list = array('user_name', 'first_name', 'last_name');
        $videoTags = array();
        $return['clsVideoListLeft'] = ($this->fields_arr['thumb'] != 'yes')?'clsVideoListLeft':'';
        $return['clsVideoListRight'] = ($this->fields_arr['thumb'] != 'yes')?'clsVideoListRight':'';
        $return['clsVideoListCommon'] = ($this->fields_arr['thumb'] != 'yes')?'clsVideoListCommon':'';
        $return['search_video_tags'] = $this->LANG['common_tag_title'] . $separator;
        $allow_quick_links = (isLoggedIn() and $this->CFG['admin']['videos']['allow_quick_links'])?true:false;
        while ($row = $this->fetchResultRecord()) {
        	$result_arr[$inc]['record']=$row;


			$result_arr[$inc]['add_quicklink'] = false;
            if ($allow_quick_links and $row['is_external_embed_video'] != 'Yes') {
                $result_arr[$inc]['add_quicklink'] = true;
                $result_arr[$inc]['is_quicklink_added'] = false;
                if (rayzzMvInKL($row['video_id']))
                    $result_arr[$inc]['is_quicklink_added'] = true;
            }
            $need_profile_icon_arr = array('videonewmale', 'videonewfemale');
            if (in_array($this->fields_arr['pg'], $need_profile_icon_arr)) {
                $this->UserDetails[$row['user_id']]['first_name'] = $row['first_name'];
                $this->UserDetails[$row['user_id']]['last_name'] = $row['last_name'];
                $this->UserDetails[$row['user_id']]['user_name'] = $row['user_name'];

                if (!$this->getVideoDetails(array('video_id', 'TIMEDIFF(NOW(), date_added) as date_added','date_added as date_created','NOW() as date_current', 'user_id', '(rating_total/rating_count) as rating', 'total_views', 'video_server_url', 'video_ext', 'video_title', 't_width', 't_height', 'video_tags'), $row['icon_id'])) {
                    $this->isResultsFound = false;
                    continue;
                } else {
                    $this->isResultsFound = true;
                }
                $row = array_merge($row, $this->video_details);
            }
            $result_arr[$inc]['video_id'] = $row['video_id'];
            $result_arr[$inc]['playing_time'] = $row['playing_time'];
			$result_arr[$inc]['video_tags'] = $this->getVideoTags($row['video_tags']);
            $result_arr[$inc]['date_added'] = ($row['date_created'] != '') ? getTimeDiffernceFormat(getDateTimeDiff($row['date_created'],$row['date_current'])) : '';
            // if(!isset($this->UserDetails[$row['user_id']]))
            // $this->getUserDetails($row['user_id'], $fields_list);
            // $result_arr[$inc]['name'] = $this->getUserName($row['user_id']);
            $result_arr[$inc]['user_id'] = $row['user_id'];
            if (!in_array($row['user_id'], $userid_arr))
                $userid_arr[] = $row['user_id'];
            $view_video_page_arr = array('myvideos', 'uservideolist');

            if ($this->fields_arr['pg'] == 'myalbumvideolist') {
                $result_arr[$inc]['video_album_id'] = $row['video_album_id'];
                $result_arr[$inc]['view_video_link'] = getUrl('viewvideo', '?video_id=' . $row['video_id'] . '&title=' . $this->changeTitle($row['video_title']) . '&album_id=' . $row['video_album_id'], $row['video_id'] . '/' . $this->changeTitle($row['video_title']) . '/?album_id=' . $row['video_album_id'], '', 'video');
            } else if (in_array($this->fields_arr['pg'], $view_video_page_arr))
                $result_arr[$inc]['view_video_link'] = getUrl('viewvideo', '?video_id=' . $row['video_id'] . '&title=' . $this->changeTitle($row['video_title']), $row['video_id'] . '/' . $this->changeTitle($row['video_title']) . '/', '', 'video');
            $this->recordsFound = true;
            $result_arr[$inc]['anchor'] = 'dAlt_' . $row['video_id'];
            $return['videosPerRow'] = $videosPerRow;
            $return['count'] = $count;
            // # Assigning Variable in array
            if ((is_array($this->fields_arr['video_ids'])) && (in_array($row['video_id'], $this->fields_arr['video_ids'])))
                $result_arr[$inc]['checked'] = 'checked';
            else
                $result_arr[$inc]['checked'] = '';
            $result_arr[$inc]['videoupload_url'] = getUrl('videouploadpopup', '?video_id=' . $row['video_id'], $row['video_id'] . '/', '', 'video');
            $result_arr[$inc]['callAjaxGetCode_url'] = $this->CFG['site']['video_url'].
														'viewVideo.php?video_id='.$row['video_id'].'&ajax_page=true&page=getcode';
            if ($this->fields_arr['pg'] == 'myalbumvideolist')
                $result_arr[$inc]['setProfileImageUrl'] = $this->CFG['site']['video_url'].
															'videoList.php?video_id='.$row['video_id'].'&album_id='.
																$row['video_album_id'].'&ajax_page=true&act=set_album_thumb';
            if ($this->fields_arr['pg'] == 'myplylist')
                $result_arr[$inc]['deletePlaylistUrl'] = $this->CFG['site']['video_url'].
															'viewVideo.php?video_id='.$row['video_id'].
																'&playlist_id=' . $this->fields_arr['playlist_id'].
																	'&ajax_page=true&page=removePlaylistVideo';
            $tags = '';
            if ($this->fields_arr['pg'] != 'albumlist') {
                $result_arr[$inc]['img_src'] = $row['video_server_url'].$videos_folder.
												getVideoImageName($row['video_id'],$row['file_name']).
													$this->CFG['admin']['videos']['thumb_name'].
														'.'.$this->CFG['video']['image']['extensions'];

                if (($row['is_external_embed_video'] == 'Yes' && $row['embed_video_image_ext'] == '')) {
                    $result_arr[$inc]['img_src'] = $this->CFG['site']['video_url'].'design/templates/'.
													$this->CFG['html']['template']['default'].'/root/images/'.
														$this->CFG['html']['stylesheet']['screen']['default'].
															'/no_image/noImageVideo_T.jpg';
					$result_arr[$inc]['image_onmouseOverText'] = '';
					$result_arr[$inc]['div_onmouseOverText'] = 'onmouseover="info_class=\'clsInfo\';showInfo(this)" onmouseout="hideInfo(this);"';
                } else {
                    $result_arr[$inc]['image_onmouseOverText'] = ($row['is_gif_animated'] == 'yes' and $this->CFG['admin']['videos']['rotating_thumbnail_feature'])?' onmouseover="swapImage(this, \'' . $row['video_server_url'] . $videos_folder . getVideoImageName($row['video_id'],$row['file_name']) . '_G.gif' . '\');"  onmouseout="swapImage(this,\'' . $row['video_server_url'] . $videos_folder . getVideoImageName($row['video_id'],$row['file_name']) . $this->CFG['admin']['videos']['thumb_name'] . '.' . $this->CFG['video']['image']['extensions'] . '\');" ':'';
					$result_arr[$inc]['div_onmouseOverText'] = 'onmouseover="info_class=\'clsInfo\';showInfo(this)" onmouseout="hideInfo(this);"';
                    if ($this->CFG['admin']['videos']['rotating_thumbnail_js_method']) {
                        $result_arr[$inc]['onmouseOverText'] = ($row['is_gif_animated'] == 'yes' and $this->CFG['admin']['videos']['rotating_thumbnail_feature'])?' onmouseover="showInfo(this);processImage(this, \'' . $row['video_id'] . '\');"  onmouseout="swapImage(this,\'' . $row['video_server_url'] . $videos_folder . getVideoImageName($row['video_id'],$row['file_name']) . $this->CFG['admin']['videos']['thumb_name'] . '.' . $this->CFG['video']['image']['extensions'] . '\');hideInfo(this)" ':'onmouseover="showInfo(this)" onmouseout="hideInfo(this);"';
                    }
                }
                $result_arr[$inc]['img_disp_image'] = DISP_IMAGE($this->CFG['admin']['videos']['thumb_width'], $this->CFG['admin']['videos']['thumb_height'], $row['t_width'], $row['t_height']);
                $result_arr[$inc]['view_video_link'] = getUrl('viewvideo', '?video_id=' . $row['video_id'] . '&title=' . $this->changeTitle($row['video_title']), $row['video_id'] . '/' . $this->changeTitle($row['video_title']) . '/', '', 'video');
                $result_arr[$inc]['video_title'] = $row['video_title'];
                $result_arr[$inc]['total_views'] = $row['total_views'];
                $result_arr[$inc]['video_title_word_wrap'] = $row['video_title'];
                $tags = $this->_parse_tags($row['video_tags']);
                $result_arr[$inc]['rating'] = $row['rating'];
                $result_arr[$inc]['total_rating'] = $this->CFG['admin']['total_rating'];
             	//if ($this->fields_arr['thumb'] !== 'yes')
                //$result_arr[$inc]['video_caption_word_wrap'] = wordWrap_mb_Manual($row['video_caption'], $this->CFG['admin']['list_description_length'], $this->CFG['admin']['list_description_total_length']);
                $result_arr[$inc]['video_caption']=$row['video_caption'];
            }
            if ($this->fields_arr['pg'] == 'albumlist') {
				$result_arr[$inc]['add_quicklink'] = false;
                $result_arr[$inc]['onmouseOverText'] = '';
                $result_arr[$inc]['video_album_id'] = $row['video_album_id'];
                $album_id .= $row['video_album_id'] . ',';
                if ($row['video_id']) {
                    $result_arr[$inc]['img_src'] = $row['video_server_url'] . $videos_folder . getVideoImageName($row['video_id'],$row['file_name']) . $this->CFG['admin']['videos']['small_name'] . '.' .$this->CFG['video']['image']['extensions'];
                    $result_arr[$inc]['img_disp_image'] = DISP_IMAGE($this->CFG['admin']['videos']['small_width'], $this->CFG['admin']['videos']['small_height'], $row['s_width'], $row['s_height']);
                } else {
                    $result_arr[$inc]['img_src'] = '';
                    $result_arr[$inc]['img_disp_image'] = '';

                }
                $result_arr[$inc]['video_title'] = $row['album_title'];
                $result_arr[$inc]['video_title_word_wrap'] =$row['album_title'];

                $result_arr[$inc]['view_video_link'] = getUrl('videolist', '?pg=albumvideolist&album_id=' . $row['video_album_id'], 'albumvideolist/?album_id=' . $row['video_album_id'], '', 'video');

            }

            switch ($this->fields_arr['pg']) {
                case 'myalbumvideolist':
                    if (!$this->isMe($this->ALBUM_USER_ID))
                        break;
                    break;
                case 'videomostdiscussed':
                    $result_arr[$inc]['total_comments'] = $row['total_comments'];
                    break;
                case 'videomostfavorite':
                    $result_arr[$inc]['total_favorite'] = $row['total_favorite'];
                    break;
                case 'featuredvideolist':
                    $result_arr[$inc]['total_featured'] = $row['total_featured'];
                    break;
            }

            if ($tags) {
                $i = 0;
                foreach($tags as $key => $value) {
                    if ($this->CFG['admin']['videos']['tags_count_list_page'] == $i)
                        break;
                    $value = strtolower($value);

                    if (!in_array($value, $tag) AND !in_array($value, $relatedTags))
                        $relatedTags[] = $value;
                    if (!in_array($value, $videoTags))
                        $videoTags[] = $value;

                    $result_arr[$inc]['tag'][$value] = getUrl('videolist', '?pg=videonew&tags=' . $value, 'videonew/?tags=' . $value, '', 'video');
                    $i++;
                }
            } else {
                $result_arr[$inc]['tag'][] = '';
            }
            $inc++;
        }
        if ($this->fields_arr['pg'] == 'albumlist') {
            $this->getVideoCountForAlbum($album_id);
        }

        $user_ids = implode(',', $userid_arr);
        $this->getMultiUserDetails($user_ids, $fields_list);


        if ($this->fields_arr['tags'])
            $this->updateVideoTagDetails($videoTags);
		$smartyObj->assign('video_list_result', $result_arr);

        return $return;
    }

	public function myVideoCondition()
	{
		if($this->fields_arr['user_id'] != '0')
			$userCondition = ' p.user_id = '.$this->fields_arr['user_id'].' ';
		elseif($this->fields_arr['myvideo'] != 'No')
			$userCondition = ' p.user_id = '.$this->CFG['user']['user_id'].' ';
		else
			$userCondition = 'p.user_id = '.  $this->CFG['user']['user_id'] .
								' OR p.video_access_type = \'Public\'' . $this->getAdditionalQuery('p.');
		return $userCondition;
	}

    /**
     * VideoList::setTableAndColumns()
     *
     * @return
     */
    public function setTableAndColumns()
    {
        if (!isMember()) {
            $not_allowed_arr = array('myvideos', 'myfavoritevideos', 'myrecentlyviewedvideo');
            if (in_array($this->fields_arr['pg'], $not_allowed_arr))
                $this->fields_arr['pg'] = 'videonew';
        }
        switch ($this->fields_arr['pg']) {
            case 'myvideos':
                $this->setTableNames(array($this->CFG['db']['tbl']['video'].' as p JOIN ' . $this->CFG['db']['tbl']['users'] . ' as u on p.user_id = u.user_id'. ' JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'));
                $this->setReturnColumns(array('p.video_id', 'p.video_ext', 'p.is_gif_animated', 'p.video_title', 'p.video_caption', 'p.video_server_url', 'p.t_width', 'p.t_height', 'TIMEDIFF(NOW(), p.date_added) as date_added','NOW() as date_current','p.date_added as date_created', 'p.user_id', '(p.rating_total/p.rating_count) as rating', 'p.total_views', 'p.video_tags', 'p.video_encoded_status', 'p.video_status', 'TIMEDIFF(NOW(), p.last_view_date) as video_last_view_date', 'p.is_external_embed_video', 'p.video_external_embed_code', 'p.embed_video_image_ext', 'p.video_tags','file_name','TIME_FORMAT(playing_time,\'%H:%i:%s\') as playing_time'));
                $this->sql_condition = 'p.user_id=\'' . $this->CFG['user']['user_id'] . '\' AND p.video_status=\'Ok\' AND u.usr_status=\'Ok\'' . $this->advancedFilters();
                $this->sql_sort = 'p.video_id DESC';
                break;

            case 'myfavoritevideos':
                $this->setTableNames(array($this->CFG['db']['tbl']['video_favorite'] . ' as f LEFT JOIN ' . $this->CFG['db']['tbl']['video'] . ' as p ON f.video_id=p.video_id'. ' JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = p.thumb_name_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u'));
                $this->setReturnColumns(array('file_name','p.video_id', 'p.user_id', 'p.video_ext', 'is_gif_animated', 'p.video_access_type', 'p.relation_id', 'p.video_title', 'video_caption', 'p.video_server_url', 'p.t_width', 'p.t_height', 'TIMEDIFF(NOW(), p.date_added) as date_added','p.date_added as date_created', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'video_tags', 'TIME_FORMAT(playing_time,\'%H:%i:%s\') as playing_time', 'video_encoded_status', 'video_status', 'TIMEDIFF(NOW(), last_view_date) as video_last_view_date', 'is_external_embed_video', 'video_external_embed_code', 'embed_video_image_ext', 'p.video_tags'));
                $this->sql_condition = 'f.user_id=' . $this->CFG['user']['user_id'] . $this->getAdultQuery('p.', 'video') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND p.video_status=\'Ok\' AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.video_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ')' . $this->advancedFilters();
                $this->sql_sort = 'video_favorite_id DESC';
                break;

            case 'myrecentlyviewedvideo':
                $this->setTableNames(array($this->CFG['db']['tbl']['video_viewed'] . ' as pv LEFT JOIN ' . $this->CFG['db']['tbl']['video'] . ' as p ON pv.video_id=p.video_id'.' JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
                $this->setReturnColumns(array('p.video_id', 'p.user_id', 'p.video_ext', 'is_gif_animated', 'p.video_access_type', 'p.relation_id', 'p.video_title', 'video_caption', 'p.video_server_url', 'p.t_width', 'p.t_height', 'TIMEDIFF(NOW(), p.date_added) as date_added','p.date_added as date_created', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'video_tags', 'TIME_FORMAT(playing_time,\'%H:%i:%s\') as playing_time', 'video_encoded_status', 'video_status', 'TIMEDIFF(NOW(), last_view_date) as video_last_view_date', 'is_external_embed_video', 'video_external_embed_code', 'embed_video_image_ext', 'p.video_tags','file_name'));
                $this->sql_condition = 'pv.user_id=' . $this->CFG['user']['user_id'] . $this->getAdultQuery('p.', 'video') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND p.video_status=\'Ok\' AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.video_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ') ' . $this->advancedFilters() . ' GROUP BY pv.video_id';
                $this->sql_sort = 'video_viewed_id DESC';
                break;

            case 'featuredvideolist':
                $this->setTableNames(array($this->CFG['db']['tbl']['video_featured'] . ' as f LEFT JOIN ' . $this->CFG['db']['tbl']['video'] . ' as p ON f.video_id=p.video_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u '. ' , '.$this->CFG['db']['tbl']['video_files_settings'].' as vfs'));
                $this->setReturnColumns(array('p.video_id', 'p.user_id', 'p.video_ext', 'is_gif_animated', 'p.video_access_type', 'p.relation_id', 'p.video_title', 'video_caption', 'p.video_server_url', 'p.t_width', 'p.t_height', 'TIMEDIFF(NOW(), p.date_added) as date_added','p.date_added as date_created', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'video_tags', 'TIME_FORMAT(playing_time,\'%H:%i:%s\') as playing_time', 'video_encoded_status', 'video_status', 'TIMEDIFF(NOW(), last_view_date) as video_last_view_date', 'is_external_embed_video', 'video_external_embed_code', 'embed_video_image_ext', 'count(video_featured_id) as total_featured', 'p.video_tags','file_name'));

				if($this->fields_arr['myfavoritevideo'] == 'No')
					$this->sql_condition = 'p.video_status=\'Ok\' AND p.thumb_name_id = video_file_id ' . $this->getAdultQuery('p.', 'video') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND (' . $this->myVideoCondition() . ') ' . $this->advancedFilters() . ' GROUP BY f.video_id';
				else
					$this->sql_condition = 'p.video_status=\'Ok\' AND p.thumb_name_id = video_file_id ' . $this->getAdultQuery('p.', 'video') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.video_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ') ' . $this->advancedFilters() . ' GROUP BY f.video_id';

                $this->sql_sort = 'video_featured_id DESC';
                break;

            case 'randomvideo':
                $this->setTableNames(array($this->CFG['db']['tbl']['video'].' as p JOIN ' . $this->CFG['db']['tbl']['users'] . ' as u on p.user_id = u.user_id'. ' JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'));
                $this->setReturnColumns(array('p.video_id', 'p.user_id', 'p.video_ext', 'is_gif_animated', 'p.video_access_type', 'p.relation_id', 'p.video_title', 'video_caption', 'p.video_server_url', 'p.t_width', 'p.t_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.date_added as date_created', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'p.video_tags', 'TIME_FORMAT(playing_time,\'%H:%i:%s\') as playing_time', 'p.video_encoded_status', 'p.video_status', 'TIMEDIFF(NOW(), p.last_view_date) as video_last_view_date', 'p.is_external_embed_video', 'p.video_external_embed_code', 'p.embed_video_image_ext', 'p.video_tags','file_name'));
                $this->sql_condition = 'p.video_status=\'Ok\'' . $this->getAdultQuery('p.', 'video') . ' AND u.usr_status=\'Ok\'  AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.video_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ')' . $this->advancedFilters();
                $this->sql_sort = getRandomFieldOfVideoTable();
                break;
			## Not used
            /*case 'videonewmale':
                $this->setTableNames(array($this->CFG['db']['tbl']['video'] . ' as p JOIN ' . $this->CFG['db']['tbl']['users'] . ' as u on p.video_id=u.icon_id'. ' JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'));
                $this->setReturnColumns(array('DATE_FORMAT(doj,\'' . $this->CFG['format']['date'] . '\') as date_added', 'user_name', 'first_name', 'last_name', 'u.user_id', 'icon_id', 'icon_type', 'total_videos', 'sex', 'p.video_tags','file_name'));
                $this->sql_condition = 'u.sex=\'male\' AND u.usr_status=\'Ok\'' . $this->getAdultQuery('p.', 'video') . $this->advancedFilters();
                $this->sql_sort = 'user_id DESC';
                break;

            case 'videonewfemale':
                $this->setTableNames(array($this->CFG['db']['tbl']['video'] . ' as p JOIN ' . $this->CFG['db']['tbl']['users'] . ' as u on p.video_id=u.icon_id'. ' JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'));
                $this->setReturnColumns(array('DATE_FORMAT(doj,\'' . $this->CFG['format']['date'] . '\') as date_added', 'user_name', 'first_name', 'last_name', 'u.user_id', 'icon_id', 'icon_type', 'total_videos', 'sex', 'p.video_tags','file_name'));
                $this->sql_condition = 'u.sex=\'female\' AND u.usr_status=\'Ok\'' . $this->getAdultQuery('p.', 'video') . $this->advancedFilters();
                $this->sql_sort = 'user_id DESC';
                break;
*/
            case 'videotoprated':

                $this->setTableNames(array($this->CFG['db']['tbl']['video'].' as p JOIN ' . $this->CFG['db']['tbl']['users'] . ' as u on p.user_id = u.user_id'. ' JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'));
                $this->setReturnColumns(array('p.video_id', 'p.user_id', 'p.video_ext', 'p.is_gif_animated', 'p.video_access_type', 'p.relation_id', 'p.video_title', 'p.video_caption', 'p.video_server_url', 'p.t_width', 'p.t_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.date_added as date_created', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'p.video_tags', 'TIME_FORMAT(p.playing_time,\'%H:%i:%s\') as playing_time', 'p.video_encoded_status', 'p.video_status', 'TIMEDIFF(NOW(), p.last_view_date) as video_last_view_date', 'p.is_external_embed_video', 'p.video_external_embed_code', 'p.embed_video_image_ext', 'p.video_tags','file_name'));
                $additional_query = '';
                if ($this->fields_arr['cid']) {
                    $additional_query .= '(p.video_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';

                    if ($this->fields_arr['sid'])
                        $additional_query .= '(p.video_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
                }

                if ($this->fields_arr['tags'])
                    $additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_caption', '').') AND ';

				if($this->fields_arr['myfavoritevideo'] == 'No')
					$this->sql_condition = $additional_query . 'p.video_status=\'Ok\'' . $this->getAdultQuery('p.', 'video') . ' AND u.usr_status=\'Ok\' AND (' . $this->myVideoCondition() . ') AND p.rating_total>0 AND p.allow_ratings=\'Yes\'' . $this->advancedFilters();
				else
					$this->sql_condition = $additional_query . 'p.video_status=\'Ok\'' . $this->getAdultQuery('p.', 'video') . ' AND u.usr_status=\'Ok\' AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.video_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ') AND p.rating_total>0 AND p.allow_ratings=\'Yes\'' . $this->advancedFilters();

                $this->sql_sort = 'rating DESC';
                break;

            case 'videomostviewed':
                $this->setTableNames(array($this->CFG['db']['tbl']['video_viewed'] . ' as vp LEFT JOIN ' . $this->CFG['db']['tbl']['video'] . ' as p ON vp.video_id=p.video_id'.','.$this->CFG['db']['tbl']['users'] . ' as u '. ','.$this->CFG['db']['tbl']['video_files_settings'].' AS VFS'));
                $this->setReturnColumns(array('p.video_id', 'p.user_id', 'p.video_ext', 'is_gif_animated', 'p.video_access_type', 'p.relation_id', 'p.video_title', 'video_caption', 'p.video_server_url', 'p.t_width', 'p.t_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.date_added as date_created', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'video_tags', 'TIME_FORMAT(playing_time,\'%H:%i:%s\') as playing_time', 'video_encoded_status', 'video_status', 'TIMEDIFF(NOW(), last_view_date) as video_last_view_date', 'is_external_embed_video', 'video_external_embed_code', 'embed_video_image_ext', 'SUM(vp.total_views) as sum_total_views', 'vp.total_views as individual_total_views', 'p.video_tags','file_name'));
                // $this->setReturnColumns(array('video_caption', 't_width', 't_height', 'video_server_url','video_ext', 'p.video_id','p.user_id', 'p.video_access_type', 'p.relation_id', 'p.video_title', 'p.date_added', 'NOW() as date_current', 'DATE_FORMAT(p.date_added, "%d %b %Y") as added_date', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'video_tags', 'video_status', 'TIMEDIFF(NOW(), last_view_date) as video_last_view_date', 'total_comments', 'SUM(vp.total_views) as sum_total_views', 'vp.total_views as individual_total_views','flagged_status'));
                $additional_query = '';
                if ($this->fields_arr['cid']) {
                    $additional_query .= '(p.video_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';

                    if ($this->fields_arr['sid'])
                        $additional_query .= '(p.video_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
                }

                if ($this->fields_arr['tags'])
                    $additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_caption', '').') AND ';

				if($this->fields_arr['myfavoritevideo'] == 'No')
					$this->sql_condition = $additional_query . 'p.video_status=\'Ok\' AND p.thumb_name_id = video_file_id ' . $this->getAdultQuery('p.', 'video') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND p.total_views>0 AND ( ' . $this->myVideoCondition() . ' )' . $this->getMostViewedExtraQuery() . '' . $this->advancedFilters() . ' GROUP BY vp.video_id';
				else
					$this->sql_condition = $additional_query . 'p.video_status=\'Ok\' AND p.thumb_name_id = video_file_id ' . $this->getAdultQuery('p.', 'video') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND p.total_views>0 AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.video_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ')' . $this->getMostViewedExtraQuery() . '' . $this->advancedFilters() . ' GROUP BY vp.video_id';

                $this->sql_sort = 'sum_total_views DESC';

                break;

            case 'videomostdiscussed':
                $this->setTableNames(array($this->CFG['db']['tbl']['video'] . ' AS p JOIN ' . $this->CFG['db']['tbl']['video_comments'] . ' AS pc ON p.video_id = pc.video_id '.', ' . $this->CFG['db']['tbl']['users'] . ' as u '. ' , '.$this->CFG['db']['tbl']['video_files_settings'].' as vfs'));
                $this->setReturnColumns(array('p.video_id', 'p.user_id', 'p.video_ext', 'is_gif_animated', 'p.video_access_type', 'p.relation_id', 'p.video_title', 'video_caption', 'p.video_server_url', 'p.t_width', 'p.t_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.date_added as date_created', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'video_tags', 'TIME_FORMAT(playing_time,\'%H:%i:%s\') as playing_time', 'video_encoded_status', 'video_status', 'TIMEDIFF(NOW(), last_view_date) as video_last_view_date', 'is_external_embed_video', 'video_external_embed_code', 'embed_video_image_ext', 'count( pc.video_comment_id ) as total_comments', 'p.video_tags','file_name'));

                $additional_query = '';
                if ($this->fields_arr['cid']) {
                    $additional_query .= '(p.video_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';

                    if ($this->fields_arr['sid'])
                        $additional_query .= '(p.video_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
                }

                if ($this->fields_arr['tags'])
                    $additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_caption', '').') AND ';

				if($this->fields_arr['myfavoritevideo'] == 'No')
					$this->sql_condition = $additional_query . 'video_status = \'Ok\' AND p.thumb_name_id = video_file_id ' . $this->getMostDiscussedExtraQuery() . $this->getAdultQuery('p.', 'video') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND ( '.$this->myVideoCondition(). ') AND comment_status=\'Yes\' ' . $this->advancedFilters() . ' GROUP BY pc.video_id';
				else
					$this->sql_condition = $additional_query . 'video_status = \'Ok\' AND p.thumb_name_id = video_file_id ' . $this->getMostDiscussedExtraQuery() . $this->getAdultQuery('p.', 'video') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.video_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ') AND comment_status=\'Yes\' ' . $this->advancedFilters() . ' GROUP BY pc.video_id';

                $this->sql_sort = ' total_comments DESC, total_views DESC ';
                break;


            case 'videomostfavorite':
                $this->setTableNames(array($this->CFG['db']['tbl']['video'] . ' AS p JOIN ' . $this->CFG['db']['tbl']['video_favorite'] . ' AS pf ON p.video_id = pf.video_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u '. ' , '.$this->CFG['db']['tbl']['video_files_settings'].' as vfs'));
                $this->setReturnColumns(array('p.video_id', 'p.user_id', 'p.video_ext', 'is_gif_animated', 'p.video_access_type', 'p.relation_id', 'p.video_title', 'video_caption', 'p.video_server_url', 'p.t_width', 'p.t_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.date_added as date_created', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'video_tags', 'TIME_FORMAT(playing_time,\'%H:%i:%s\') as playing_time', 'video_encoded_status', 'video_status', 'TIMEDIFF(NOW(), last_view_date) as video_last_view_date', 'is_external_embed_video', 'video_external_embed_code', 'embed_video_image_ext', 'count( pf.video_favorite_id ) as total_favorite', 'p.video_tags','file_name'));
                $additional_query = '';
                if ($this->fields_arr['cid']) {
                    $additional_query .= '(p.video_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';

                    if ($this->fields_arr['sid'])
                        $additional_query .= '(p.video_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
                }

                if ($this->fields_arr['tags'])
                    $additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_caption', '').') AND ';

				if($this->fields_arr['myfavoritevideo'] == 'No')
					$this->sql_condition = $additional_query . 'video_status = \'Ok\' AND p.thumb_name_id = video_file_id ' . $this->getMostFavoriteExtraQuery() . $this->getAdultQuery('p.', 'video') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND ('.$this->myVideoCondition().')'.$this->advancedFilters().' GROUP BY pf.video_id';
				else
					$this->sql_condition = $additional_query . 'video_status = \'Ok\' AND p.thumb_name_id = video_file_id ' . $this->getMostFavoriteExtraQuery() . $this->getAdultQuery('p.', 'video') . ' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.video_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ')' . $this->advancedFilters() . ' GROUP BY pf.video_id';

                $this->sql_sort = ' total_favorite DESC, total_views DESC ';
                break;

            case 'videomostrecentlyviewed':
                $this->setTableNames(array($this->CFG['db']['tbl']['video'].' as p JOIN ' . $this->CFG['db']['tbl']['users'] . ' as u on p.user_id = u.user_id'. ' JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'));
                $this->setReturnColumns(array('p.video_id', 'p.user_id', 'p.video_ext', 'is_gif_animated', 'p.video_access_type', 'p.relation_id', 'p.video_title', 'video_caption', 'p.video_server_url', 'p.t_width', 'p.t_height', 'p.last_view_date as max_view_date', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'NOW() as date_current', 'p.date_added as date_created', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'video_tags', 'TIME_FORMAT(playing_time,\'%H:%i:%s\') as playing_time', 'video_encoded_status', 'video_status', 'TIMEDIFF(NOW(), last_view_date) as video_last_view_date', 'is_external_embed_video', 'video_external_embed_code', 'embed_video_image_ext', 'p.video_tags','file_name'));
                $additional_query = '';
                if ($this->fields_arr['cid']) {
                    $additional_query .= '(p.video_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';

                    if ($this->fields_arr['sid'])
                        $additional_query .= '(p.video_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
                }

                if ($this->fields_arr['tags'])
                    $additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_caption', '').') AND ';

				if($this->fields_arr['myfavoritevideo'] == 'No')
					$this->sql_condition = $additional_query . 'p.video_status=\'Ok\'' . $this->getAdultQuery('p.', 'video') . ' AND u.usr_status=\'Ok\' AND p.total_views>0 AND ('.$this->myVideoCondition().')' . $this->advancedFilters();
				else
					$this->sql_condition = $additional_query . 'p.video_status=\'Ok\'' . $this->getAdultQuery('p.', 'video') . ' AND u.usr_status=\'Ok\' AND p.total_views>0 AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.video_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ')' . $this->advancedFilters();

                $this->sql_sort = 'max_view_date DESC';
                break;

            case 'uservideolist':
                $this->setTableNames(array($this->CFG['db']['tbl']['video'].' as p JOIN ' . $this->CFG['db']['tbl']['users'] . ' as u on p.user_id = u.user_id'. ' JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'));
                $this->setReturnColumns(array('p.video_id', 'p.user_id', 'p.video_ext', 'is_gif_animated', 'p.video_access_type', 'p.relation_id', 'p.video_title', 'video_caption', 'p.video_server_url', 'p.t_width', 'p.t_height', 'TIMEDIFF(NOW(), p.date_added) as date_added','p.date_added as date_created', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'video_tags', 'TIME_FORMAT(playing_time,\'%H:%i:%s\') as playing_time', 'video_encoded_status', 'video_status', 'TIMEDIFF(NOW(), last_view_date) as video_last_view_date', 'is_external_embed_video', 'video_external_embed_code', 'embed_video_image_ext', 'p.video_tags','file_name'));
                $this->sql_condition = 'p.user_id=\'' . addslashes($this->fields_arr['user_id']) . '\'' . $this->getAdultQuery('p.', 'video') . ' AND u.usr_status=\'Ok\' AND p.video_status=\'Ok\' AND (p.video_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ')' . $this->advancedFilters();
                $this->sql_sort = 'video_id DESC';
                break;

            case 'albumlist':
                $this->setTableNames(array($this->CFG['db']['tbl']['video_album'] . ' as p LEFT JOIN '.$this->CFG['db']['tbl']['video'] .' as ph On p.video_album_id=ph.video_album_id'. ' JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
                $this->setReturnColumns(array('p.video_album_id','p.album_title','count(p.video_album_id) as total_album_videos' ,'p.video_id', 'p.user_id', 'ph.video_ext', 'ph.is_gif_animated', 'ph.video_access_type', 'p.relation_id', 'ph.video_title', 'ph.video_caption', 'p.video_server_url', 'ph.t_width', 'ph.t_height', 'p.video_album_id', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.date_added as date_created', 'NOW() as date_current', 'ph.total_views', '(ph.rating_total/ph.rating_count) as rating', 'ph.video_tags', 'TIME_FORMAT(ph.playing_time,\'%H:%i:%s\') as playing_time', 'ph.video_encoded_status', 'ph.video_status', 'TIMEDIFF(NOW(), ph.last_view_date) as video_last_view_date', 'ph.is_external_embed_video', 'ph.video_external_embed_code', 'ph.embed_video_image_ext', 'ph.video_tags','file_name','p.s_width','p.s_height'));
                $this->sql_condition = 'ph.video_status=\'Ok\' AND ph.user_id = u.user_id AND u.usr_status=\'Ok\' AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.album_access_type = \'Public\')' . $this->getAdditionalQuery('p.') . ' group by p.video_album_id' . $this->advancedFilters();
                $this->sql_sort = 'p.video_album_id DESC';

                break;
            case 'albumvideolist':
                $this->setTableNames(array($this->CFG['db']['tbl']['video'].' as p JOIN ' . $this->CFG['db']['tbl']['users'] . ' as u on p.user_id = u.user_id'. ' JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'));
                $this->setReturnColumns(array('p.video_id', 'p.user_id', 'p.video_ext', 'is_gif_animated', 'p.video_access_type', 'p.relation_id', 'p.video_title', 'video_caption', 'p.video_server_url', 'p.t_width', 'p.t_height', 'video_album_id', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.date_added as date_created', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'video_tags', 'TIME_FORMAT(playing_time,\'%H:%i:%s\') as playing_time', 'video_encoded_status', 'video_status', 'TIMEDIFF(NOW(), last_view_date) as video_last_view_date', 'is_external_embed_video', 'video_external_embed_code', 'embed_video_image_ext', 'p.video_tags','file_name'));
                $this->sql_condition = 'p.video_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\'' . $this->getAdultQuery('p.', 'video') . ' AND u.usr_status=\'Ok\' AND p.video_status=\'Ok\' AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.video_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ')' . $this->advancedFilters();
                $this->sql_sort = 'video_id DESC';
                break;
            case 'myalbumvideolist':
                $this->setTableNames(array($this->CFG['db']['tbl']['video'].' as p JOIN ' . $this->CFG['db']['tbl']['users'] . ' as u on p.user_id = u.user_id'. ' JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'));
                $this->setReturnColumns(array('p.video_id', 'p.user_id', 'p.video_ext', 'is_gif_animated', 'p.video_access_type', 'p.relation_id', 'p.video_title', 'video_caption', 'p.video_server_url', 'p.t_width', 'p.t_height', 'video_album_id', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.date_added as date_created', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'video_tags', 'TIME_FORMAT(playing_time,\'%H:%i:%s\') as playing_time', 'video_encoded_status', 'video_status', 'TIMEDIFF(NOW(), last_view_date) as video_last_view_date', 'is_external_embed_video', 'video_external_embed_code', 'embed_video_image_ext', 'p.video_tags','file_name'));
                $this->sql_condition = 'p.video_album_id=\'' . addslashes($this->fields_arr['album_id']) . '\' AND u.usr_status=\'Ok\' AND p.user_id=\'' . addslashes($this->CFG['user']['user_id']) . '\'' . $this->getAdultQuery('p.', 'video') . ' AND p.video_status=\'Ok\' AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.video_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ')' . $this->advancedFilters();
                $this->sql_sort = 'video_id DESC';
                break;
            case 'myplaylist':
                $this->setTableNames(array($this->CFG['db']['tbl']['video'] . ' as p JOIN ' . $this->CFG['db']['tbl']['video_in_playlist'] . ' as pl ON p.video_id=pl.video_id JOIN ' . $this->CFG['db']['tbl']['video_playlist'] . ' as pp ON pl.playlist_id = pp.playlist_id'. ' JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
                $this->setReturnColumns(array('p.video_id', 'p.user_id', 'p.video_ext', 'is_gif_animated', 'p.video_access_type', 'p.relation_id', 'p.video_title', 'video_caption', 'p.video_server_url', 'p.t_width', 'p.t_height', 'video_album_id', 'TIMEDIFF(NOW(), p.date_added) as date_added','p.date_added as date_created', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'video_tags', 'TIME_FORMAT(playing_time,\'%H:%i:%s\') as playing_time', 'video_encoded_status', 'video_status', 'TIMEDIFF(NOW(), last_view_date) as video_last_view_date', 'is_external_embed_video', 'video_external_embed_code', 'embed_video_image_ext', 'p.video_tags','file_name'));
                $this->sql_condition = 'pp.user_id=\'' . $this->CFG['user']['user_id'] . '\' AND video_status=\'Ok\' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND pp.playlist_id=' . addslashes($this->fields_arr['playlist_id']) . $this->advancedFilters();
                $this->sql_sort = 'video_id DESC';
                break;

            case 'videomostresponded':
                $this->setTableNames(array($this->CFG['db']['tbl']['video'].' as p JOIN ' . $this->CFG['db']['tbl']['users'] . ' as u on p.user_id = u.user_id'. ' JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'));
                $this->setReturnColumns(array('p.video_id', 'p.user_id', 'p.video_ext', 'is_gif_animated', 'p.video_access_type', 'p.relation_id', 'p.video_title', 'video_caption', 'p.video_server_url', 'p.t_width', 'p.t_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.date_added as date_created', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'video_tags', 'TIME_FORMAT(playing_time,\'%H:%i:%s\') as playing_time', 'video_encoded_status', 'video_status', 'TIMEDIFF(NOW(), last_view_date) as video_last_view_date', 'is_external_embed_video', 'video_external_embed_code', 'embed_video_image_ext', 'p.video_tags','file_name','total_responded'));

                $additional_query = '';
                if ($this->fields_arr['cid']) {
                    $additional_query .= '(p.video_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';

                    if ($this->fields_arr['sid'])
                        $additional_query .= '(p.video_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
                }

                if ($this->fields_arr['tags'])
                    $additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_caption', '').') AND ';

				if($this->fields_arr['myfavoritevideo'] == 'No')
					$this->sql_condition = $additional_query . 'p.video_status=\'Ok\'' . $this->getAdultQuery('p.') . ' AND u.usr_status=\'Ok\' AND ('.$this->myVideoCondition().') AND p.total_responded>0 AND 1 '.$this->advancedFilters();
				else
					$this->sql_condition = $additional_query . 'p.video_status=\'Ok\'' . $this->getAdultQuery('p.') . ' AND u.usr_status=\'Ok\' AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.video_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ') AND p.total_responded>0 AND 1 ' . $this->advancedFilters();

                $this->sql_sort = ' total_responded DESC';
                break;

            case 'videomostlinked':
                $this->setTableNames(array($this->CFG['db']['tbl']['video'].' as p JOIN ' . $this->CFG['db']['tbl']['users'] . ' as u on p.user_id = u.user_id'. ' JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'));
                $this->setReturnColumns(array('p.video_id', 'p.user_id', 'p.video_ext', 'is_gif_animated', 'p.video_access_type', 'p.relation_id', 'p.video_title', 'video_caption', 'p.video_server_url', 'p.t_width', 'p.t_height', 'TIMEDIFF(NOW(), p.date_added) as date_added',  'p.date_added as date_created', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'video_tags', 'TIME_FORMAT(playing_time,\'%H:%i:%s\') as playing_time', 'video_encoded_status', 'video_status', 'TIMEDIFF(NOW(), last_view_date) as video_last_view_date', 'is_external_embed_video', 'video_external_embed_code', 'embed_video_image_ext', 'p.video_tags','file_name','total_linked'));

                $additional_query = '';
                if ($this->fields_arr['cid']) {
                    $additional_query .= '(p.video_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';

                    if ($this->fields_arr['sid'])
                        $additional_query .= '(p.video_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
                }

                if ($this->fields_arr['tags'])
                    $additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_caption', '').') AND ';

				if($this->fields_arr['myfavoritevideo'] == 'No')
					$this->sql_condition = $additional_query . 'p.video_status=\'Ok\'' . $this->getAdultQuery('p.') . ' AND u.usr_status=\'Ok\' AND ('.$this->myVideoCondition().') AND p.total_linked>0 AND p.allow_ratings=\'Yes\''.$this->advancedFilters();
				else
					$this->sql_condition = $additional_query . 'p.video_status=\'Ok\'' . $this->getAdultQuery('p.') . ' AND u.usr_status=\'Ok\' AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.video_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ') AND p.total_linked>0 AND p.allow_ratings=\'Yes\'' . $this->advancedFilters();

                $this->sql_sort = ' total_linked DESC';
                break;

            case 'videoresponseslist':
                $this->setTableNames(array($this->CFG['db']['tbl']['video'] .' AS p  JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id, ' . $this->CFG['db']['tbl']['video_responses'] . ' AS vr '.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
                $this->setReturnColumns(array('p.video_id', 'p.user_id', 'p.video_ext', 'is_gif_animated', 'p.video_access_type', 'p.relation_id', 'p.video_title', 'video_caption', 'p.video_server_url', 'p.t_width', 'p.t_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.date_added as date_created', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'video_tags', 'TIME_FORMAT(playing_time,\'%H:%i:%s\') as playing_time', 'video_encoded_status', 'video_status', 'TIMEDIFF(NOW(), last_view_date) as video_last_view_date', 'is_external_embed_video', 'video_external_embed_code', 'embed_video_image_ext', 'p.video_tags','file_name'));

				if($this->fields_arr['myfavoritevideo'] == 'No')
					$this->sql_condition = ' p.video_status=\'Ok\' AND ('.$this->myVideoCondition().') ' . ' AND vr.video_responses_video_id=p.video_id '.$this->getAdultQuery('p.');
				else
					$this->sql_condition = ' p.video_status=\'Ok\' AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.video_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ') ' . ' AND vr.video_responses_video_id=p.video_id '.$this->getAdultQuery('p.');

				$this->sql_condition .= ' AND video_responses_status=\'Yes\' AND p.video_id!=\'' . $this->fields_arr['video_id'] . '\' AND p.user_id = u.user_id AND u.usr_status=\'Ok\' AND vr.video_id=\'' . $this->fields_arr['video_id'] . '\'  ' . $this->advancedFilters();
                $this->sql_sort = ' p.video_id DESC ';
                break;
            case 'videorecommended':
                $this->setTableNames(array($this->CFG['db']['tbl']['video'].' as p JOIN ' . $this->CFG['db']['tbl']['users'] . ' as u on p.user_id = u.user_id'. ' JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'));
                $this->setReturnColumns(array('p.video_id', 'p.user_id', 'p.video_ext', 'is_gif_animated', 'p.video_access_type', 'p.relation_id', 'p.video_title', 'video_caption', 'p.video_server_url', 'p.t_width', 'p.t_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.date_added as date_created', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'video_tags', 'TIME_FORMAT(playing_time,\'%H:%i:%s\') as playing_time', 'video_encoded_status', 'video_status', 'TIMEDIFF(NOW(), last_view_date) as video_last_view_date', 'is_external_embed_video', 'video_external_embed_code', 'embed_video_image_ext', 'p.video_tags','file_name','total_featured'));

                $additional_query = '';
                if ($this->fields_arr['cid']) {
                    $additional_query .= '(p.video_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';

                    if ($this->fields_arr['sid'])
                        $additional_query .= '(p.video_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
                }

                if ($this->fields_arr['tags'])
                {

					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_caption', '').') AND ';

                   }
				if($this->fields_arr['myfavoritevideo'] == 'No')
					$this->sql_condition = $additional_query . 'p.video_status=\'Ok\'' . $this->getAdultQuery('p.') . ' AND u.usr_status=\'Ok\' AND ('.$this->myVideoCondition().') AND p.featured=\'Yes\''.$this->advancedFilters();
				else
					$this->sql_condition = $additional_query . 'p.video_status=\'Ok\'' . $this->getAdultQuery('p.') . ' AND u.usr_status=\'Ok\' AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.video_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ') AND p.featured=\'Yes\'' . $this->advancedFilters();

                $this->sql_sort = 'rating DESC';
                break;

            default:// videonew
                $this->setTableNames(array($this->CFG['db']['tbl']['video'].' as p JOIN ' . $this->CFG['db']['tbl']['users'] . ' as u on p.user_id = u.user_id'. ' JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'));
                $this->setReturnColumns(array('p.video_id', 'p.user_id', 'p.video_ext', 'p.video_tags', 'is_gif_animated', 'p.video_title', 'video_caption', 'p.video_server_url', 'p.t_width', 'p.t_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.date_added as date_created', 'NOW() as date_current', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'video_tags', 'TIME_FORMAT(playing_time,\'%H:%i:%s\') as playing_time', 'video_encoded_status', 'video_status', 'TIMEDIFF(NOW(), last_view_date) as video_last_view_date', 'is_external_embed_video', 'video_external_embed_code', 'embed_video_image_ext','file_name'));
                $additional_query = '';
                if ($this->fields_arr['cid']) {
                    $additional_query .= '(p.video_category_id=\'' . addslashes($this->fields_arr['cid']) . '\') AND ';

                    if ($this->fields_arr['sid'])
                        $additional_query .= '(p.video_sub_category_id=\'' . addslashes($this->fields_arr['sid']) . '\') AND ';
                }

                if ($this->fields_arr['tags']) {
                    $additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_caption', '').') AND ';
                }

				if($this->fields_arr['myfavoritevideo'] == 'No')
					$this->sql_condition = $additional_query . 'p.video_status=\'Ok\'' . $this->getAdultQuery('p.') . ' AND u.usr_status=\'Ok\' AND ('.$this->myVideoCondition().')' . $this->advancedFilters();
				else
					$this->sql_condition = $additional_query . 'p.video_status=\'Ok\'' . $this->getAdultQuery('p.') . ' AND u.usr_status=\'Ok\' AND (p.user_id = ' . $this->CFG['user']['user_id'] . ' OR p.video_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ')' . $this->advancedFilters();

                $this->sql_sort = 'p.video_id DESC';
                break;
        }
    }

    /**
     * VideoList::chkValidAlbumId()
     *
     * @return
     */
    public function chkValidAlbumId()
		{
			$condition = 'video_album_id=' . $this->dbObj->Param('album_id') . ' AND' . ' (p.user_id = ' . $this->dbObj->Param('user_id') . ' OR' . ' p.album_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ')';

			$sql = 'SELECT p.album_title, p.user_id FROM ' . $this->CFG['db']['tbl']['video_album'] . ' as p' . ' WHERE ' . $condition . ' LIMIT 0,1';

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
     * VideoList::updateVideoTagDetails()
     *
     * @param array $videoTags
     * @return
     */
    public function updateVideoTagDetails($videoTags = array())
		{
			$tags = $this->fields_arr['tags'];
			$tags = trim($tags);
			$tags = $this->_parse_tags($tags);
			$match = array_intersect($tags, $videoTags);
			$match = array_unique($match);


			if (empty($match))
				return;

			if (count($match) == 1)
				{
					$key= array_keys($match);
					$this->updateSearchCountAndResultForVideoTag($match[$key[0]]);
				}
			else
				{
					for($i = 0; $i < count($match); $i++)
					{
						$tag = $match[$i];
						$this->updateSearchCountForVideoTag($tag);
					}
				}
		}

    /**
     * VideoList::updateSearchCountAndResultForVideoTag()
     *
     * @param string $tag
     * @return
     */
    public function updateSearchCountAndResultForVideoTag($tag = '')
		{
			$sql = 'UPDATE ' . $this->CFG['db']['tbl']['tags_video'] . ' SET search_count = search_count + 1,' . ' result_count = ' . $this->getResultsTotalNum() . ',' . ' last_searched = NOW()' . ' WHERE tag_name=' . $this->dbObj->Param('tag_name');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($tag));
			if (!$rs)
				trigger_db_error($this->dbObj);

			if ($this->dbObj->Affected_Rows() == 0)
				{
					$sql = 'INSERT INTO ' . $this->CFG['db']['tbl']['tags_video'] . ' SET search_count = search_count + 1 ,' . ' result_count = ' . $this->getResultsTotalNum() . ',' . ' last_searched = NOW(),' . ' tag_name=' . $this->dbObj->Param('tag_name');

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($tag));
					if (!$rs)
						trigger_db_error($this->dbObj);
				}
		}

    /**
     * VideoList::updateSearchCountForVideoTag()
     *
     * @param string $tag
     * @return
     */
    public function updateSearchCountForVideoTag($tag = '')
		{
			$sql = 'UPDATE ' . $this->CFG['db']['tbl']['tags_video'] . ' SET search_count = search_count + 1,' . ' result_count = ' . $this->getResultsTotalNum() . ',' . ' last_searched = NOW()' . ' WHERE tag_name=' . $this->dbObj->Param('tag_name');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($tag));
			if (!$rs)
				trigger_db_error($this->dbObj);

			if ($this->dbObj->Affected_Rows() == 0)
				{
					$sql = 'INSERT INTO ' . $this->CFG['db']['tbl']['tags_video'] . ' SET search_count = search_count + 1 ,' . ' result_count = ' . $this->getResultsTotalNum() . ',' . ' last_searched = NOW(),' . ' tag_name=' . $this->dbObj->Param('tag_name');

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($tag));
					if (!$rs)
						trigger_db_error($this->dbObj);
				}
		}

    /**
     * VideoList::getAlbumName()
     *
     * @return
     */
    public function getAlbumName()
    {
        $sql = 'SELECT album_title FROM ' . $this->CFG['db']['tbl']['video_album'] . ' WHERE video_album_id=' . $this->dbObj->Param('video_album_id');

        $stmt = $this->dbObj->Prepare($sql);
        $rs = $this->dbObj->Execute($stmt, array($this->fields_arr['album_id']));
        if (!$rs)
            trigger_db_error($this->dbObj);

        if ($row = $rs->FetchRow())
            return $row['album_title'];
        return $this->LANG['videolist_unknown_album'];
    }

    /**
     * VideoList::getCategoryName()
     *
     * @return
     */
    public function getVideoCategoryName()
    {
        if ($this->fields_arr['sid'])
            $categoryId = $this->fields_arr['sid'];
        else
            $categoryId = $this->fields_arr['cid'];
        $sql = 'SELECT video_category_name FROM ' . $this->CFG['db']['tbl']['video_category'] . ' WHERE video_category_id=' . $this->dbObj->Param('video_category_id');

        $stmt = $this->dbObj->Prepare($sql);
        $rs = $this->dbObj->Execute($stmt, array($categoryId));
        if (!$rs)
            trigger_db_error($this->dbObj);

        if ($row = $rs->FetchRow())
            return $row['video_category_name'];
        return $this->LANG['unknown_category'];
    }

    /**
     * VideoList::getMostViewedExtraQuery()
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
        switch ($this->fields_arr['action']) {
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
                $extra_query = ' AND DATE_FORMAT(vp.view_date,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
                break;
        }
        return $extra_query;
    }

    /**
     * VideoList::getMostDiscussedExtraQuery()
     *
     * @return
     */
    public function getMostDiscussedExtraQuery()
    {
        $extra_query = '';
        switch ($this->fields_arr['action']) {
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
     * VideoList::getMostFavoriteExtraQuery()
     *
     * @return
     */
    public function getMostFavoriteExtraQuery()
    {
        $extra_query = '';
        switch ($this->fields_arr['action']) {
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
     * VideoList::getVideoCountForAlbum()
     *
     * @param mixed $album_id
     * @return
     */
    public function getVideoCountForAlbum($album_id)
    {
        $result_arr = array();
        global $smartyObj;
$videos_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['videos']['folder'] . '/' . $this->CFG['admin']['videos']['thumbnail_folder'] . '/';
        $sql = 'SELECT COUNT(video_id) AS total_videos,video_id,video_ext,s_width,s_height,video_server_url,video_album_id,file_name FROM ' . $this->CFG['db']['tbl']['video'] . ' JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id  WHERE FIND_IN_SET(video_album_id,' . $this->dbObj->Param('video_album_id') . ')' . ' AND video_status=\'Ok\' GROUP BY video_album_id';

        $stmt = $this->dbObj->Prepare($sql);
        $rs = $this->dbObj->Execute($stmt, array($album_id));
        if (!$rs)
            trigger_db_error($this->dbObj);
        // $this->total_videos = 0;
        while ($row = $rs->FetchRow()) {
            /*$this->video_id = $row['video_id'];
							$this->video_ext = $row['video_ext'];
							$this->s_width = $row['s_width'];
							$this->s_height = $row['s_height'];
							$this->video_server_url = $row['video_server_url'];
							$this->total_videos = $row['total_videos'];*/

            $result_arr[$row['video_album_id']]['total_videos'] = $row['total_videos'];

            $result_arr[$row['video_album_id']]['img_src'] = $row['video_server_url'] . $videos_folder . getVideoImageName($row['video_id'],$row['file_name']) . $this->CFG['admin']['videos']['small_name'] . '.' . $this->CFG['video']['image']['extensions'];
            $result_arr[$row['video_album_id']]['img_disp_image'] = DISP_IMAGE($this->CFG['admin']['videos']['small_width'], $this->CFG['admin']['videos']['small_height'], $row['s_width'], $row['s_height']);
        }
        $smartyObj->assign('album_video_count_list', $result_arr);

        return $result_arr;
    }

    /**
     * VideoList::populateSubCategories()
     *
     * @return
     */
    public function populateSubCategories()
    {
        global $smartyObj;
        $populateSubCategories_arr = array();

		//Video catagory List order by Priority on / off features
		if($this->CFG['admin']['videos']['video_category_list_priority'])
			$order_by = 'priority';
		else
			$order_by = 'video_category_name';

        $sql = 'SELECT video_category_id, video_category_name, video_category_description,video_category_ext ' . 'FROM ' . $this->CFG['db']['tbl']['video_category'] . ' ' . 'WHERE video_category_status = \'Yes\' ' . 'AND parent_category_id=' . $this->dbObj->Param('parent_category_id'). 'ORDER BY '.$order_by.' ASC ';

        $stmt = $this->dbObj->Prepare($sql);
        $rs = $this->dbObj->Execute($stmt, array($this->fields_arr['cid']));
        if (!$rs)
           trigger_db_error($this->dbObj);

        $usersPerRow = $this->CFG['admin']['videos']['subcategory_list_per_row'];
        $count = 0;
        $found = false;
        $populateSubCategories_arr['row'] = array();
        $inc = 1;
        while ($row = $rs->FetchRow()) {
            $found = true;
            $populateSubCategories_arr['row'][$inc]['open_tr'] = '';
            if ($count % $usersPerRow == 0) {
                $populateSubCategories_arr['row'][$inc]['open_tr'] = '<tr>';
            }
            $populateSubCategories_arr['row'][$inc]['imageSrc'] = $this->CFG['site']['url'] . $this->CFG['admin']['videos']['category_folder'] . $row['video_category_id'] . '.' . $row['video_category_ext'];
            $row['video_category_name'] = $row['video_category_name'];
			$populateSubCategories_arr['row'][$inc]['record'] = $row;

            $populateSubCategories_arr['row'][$inc]['video_list_url'] = getUrl('videolist', '?pg=' . $this->fields_arr['pg'] . '&cid=' . $this->fields_arr['cid'] . '&sid=' . $row['video_category_id'], $this->fields_arr['pg'] . '/?cid=' . $this->fields_arr['cid'] . '&sid=' . $row['video_category_id'], '', 'video');
            $populateSubCategories_arr['row'][$inc]['video_category_name_manual'] = nl2br(stripslashes($row['video_category_name']));

            $count++;
            $populateSubCategories_arr['row'][$inc]['end_tr'] = '';
            if ($count % $usersPerRow == 0) {
                $count = 0;
                $populateSubCategories_arr['row'][$inc]['end_tr'] = '</tr>';
            }
            $inc++;
        }
        $smartyObj->assign('populateSubCategories_arr', $populateSubCategories_arr);
    }

    /**
     * VideoList::advancedFilters()
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

					if ($this->getFormField('keyword') != $this->LANG['videolist_keyword'] AND $this->getFormField('keyword'))
						{

							//$advanced_filters .=' AND (('.getSearchStringModified('video_title',addslashes($this->getFormField('keyword'))).')';
							//$advanced_filters .=' OR ('.getSearchStringModified('video_caption',addslashes($this->getFormField('keyword'))).')';
							//$advanced_filters .=' OR ('.getSearchStringModified('video_tags',addslashes($this->getFormField('keyword'))).'))';
                            $advanced_filters .=' AND ('.getSearchRegularExpressionQueryModified($this->getFormField('keyword'),'p.video_title','OR');
							$advanced_filters .=getSearchRegularExpressionQueryModified($this->getFormField('keyword'),'p.video_tags','OR');
							$advanced_filters .=getSearchRegularExpressionQueryModified($this->getFormField('keyword'),'p.video_caption','').')';

							$this->advanceSearch = true;
						}
					if ($this->getFormField('video_owner') != $this->LANG['videolist_user_name'] AND $this->getFormField('video_owner'))
						{
							$advanced_filters .= ' AND u.user_name LIKE \'%' . $this->getFormField('video_owner') . '%\' ';
							$this->advanceSearch = true;
						}
					if ($this->getFormField('video_country') != '' )
						{
							$advanced_filters .= ' AND video_country = \'' . $this->getFormField('video_country') . '\' ';
							$this->advanceSearch = true;
						}
					if ($this->getFormField('video_language') != '')
						{
							$advanced_filters .= ' AND video_language = \'' . $this->getFormField('video_language') . '\' ';
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

	public function getVideoTags($video_tags)
		{
			$tags_arr = explode(' ', $video_tags);
			$getVideoTags_arr = array();
			for($i=0;$i<count($tags_arr);$i++)
				{
					if($i<3)
						{
							if(strlen($tags_arr[$i]) > 5 and strlen($tags_arr[$i]) > 5+3)
								$getVideoTags_arr[$i]['tags_name'] = $tags_arr[$i];
							else
								$getVideoTags_arr[$i]['tags_name'] = $tags_arr[$i];
							$getVideoTags_arr[$i]['tags_url'] = getUrl('videolist', '?pg=videonew&tags='.$tags_arr[$i], 'videonew/?tags='.$tags_arr[$i], '', 'video');
						}
				}
			return $getVideoTags_arr;
		}
	public function chkAdvanceResultFound()
	{
		if($this->advanceSearch)// && $this->isResultsFound())
		{
			return true;
		}
		return false;
	}

}
// <<<<<-------------- Class VideoUpload Ends ---------------//
// -------------------- Code begins -------------->>>>>//
//var_dump($_POST);
$VideoList = new VideoList();
if (!chkAllowedModule(array('video')))
    Redirect2URL($CFG['redirect']['dsabled_module_url']);

$VideoList->setDBObject($db);
$VideoList->makeGlobalize($CFG, $LANG);
$VideoList->setPageBlockNames(array('msg_form_error', 'msg_form_success',
									'my_videos_form', 'delete_confirm_form',
									'featured_confirm_form', 'check_all_item',
									'form_show_sub_category'));

$VideoList->LANG_COUNTRY_ARR = $LANG_LIST_ARR['countries'];
$VideoList->LANG_LANGUAGE_ARR = $LANG_LIST_ARR['language'];
$VideoList->VIDEORUN_LENGTH_ARR = $LANG_LIST_ARR['playing_time'];
$VideoList->ADDED_WITHIN_ARR = $LANG_LIST_ARR['added_within_arr'];

// default form fields and values...
$VideoList->setFormField('video_id', '');
$VideoList->setFormField('playlist_id', '');
$VideoList->setFormField('album_id', '');
$VideoList->setFormField('thumb', 'yes');
$VideoList->setFormField('video_ext', '');
$VideoList->setFormField('action', '');
$VideoList->setFormField('act', '');
$VideoList->setFormField('pg', 'videonew');
$VideoList->setFormField('cid', '');
$VideoList->setFormField('tags', '');
$VideoList->setFormField('user_id', '0');
/**
 * ********** Page Navigation Start ********
 */
$VideoList->setFormField('start', '0');
$VideoList->setFormField('slno', '1');
$VideoList->setFormField('sid', '');
$VideoList->setFormField('video_ids', array());
//$CFG['video_tbl']['numpg'] = 28;
$VideoList->setFormField('numpg', $CFG['video_tbl']['numpg']);
$condition = '';
$VideoList->setFormField('advanceFromSubmission', '');
$VideoList->setFormField('video_country', '');
$VideoList->setFormField('video_language', '');
$VideoList->setFormField('run_length', '');
$VideoList->setFormField('added_within', '');
$VideoList->setFormField('keyword', '');
$VideoList->setFormField('video_owner', '');
$VideoList->setFormField('searchkey', '');
$VideoList->setFormField('default', 'Yes');
$VideoList->setFormField('myvideo', 'No');
$VideoList->setFormField('myfavoritevideo', 'No');
$VideoList->setFormField('privatevideo', '');

$VideoList->recordsFound = false;

$VideoList->setMinRecordSelectLimit($CFG['data_tbl']['min_record_select_limit']);
$VideoList->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$VideoList->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$VideoList->setTableNames(array());
$VideoList->setReturnColumns(array());

$VideoList->default_url = getUrl('videolist','?pg=videonew','videonew/','','video');
/**
 * *********** page Navigation stop ************
 */
$VideoList->setAllPageBlocksHide();
$VideoList->setPageBlockShow('my_videos_form');

$VideoList->sanitizeFormInputs($_REQUEST);

if($VideoList->getFormField('default') == 'No')
	{
		$VideoList->setFormField('pg', (isset($_GET['pg']) && !empty($_GET['pg']))?$_GET['pg']:$_REQUEST['pg']);
	}
if($VideoList->getFormField('pg')== 'privatevideo')
{
	$VideoList->setPageBlockShow('msg_form_error');
	$VideoList->setCommonErrorMsg($LANG['videolist_msg_private_video']);
}
if($VideoList->getFormField('pg')== 'myvideo')
	$VideoList->setFormField('myvideo', 'Yes');

if($VideoList->getFormField('pg')== 'myfavoritevideos')
	$VideoList->setFormField('myfavoritevideo', 'Yes');

$videoActionNavigation_arr['video_list_url_0'] = getUrl('videolist', '?pg='.$VideoList->getFormField('pg').'&action=0', $VideoList->getFormField('pg').'/?action=0', '', 'video');
$videoActionNavigation_arr['video_list_url_1'] = getUrl('videolist', '?pg='.$VideoList->getFormField('pg').'&action=1', $VideoList->getFormField('pg').'/?action=1', '', 'video');
$videoActionNavigation_arr['video_list_url_2'] = getUrl('videolist', '?pg='.$VideoList->getFormField('pg').'&action=2', $VideoList->getFormField('pg').'/?action=2', '', 'video');
$videoActionNavigation_arr['video_list_url_3'] = getUrl('videolist', '?pg='.$VideoList->getFormField('pg').'&action=3', $VideoList->getFormField('pg').'/?action=3', '', 'video');
$videoActionNavigation_arr['video_list_url_4'] = getUrl('videolist', '?pg='.$VideoList->getFormField('pg').'&action=4', $VideoList->getFormField('pg').'/?action=4', '', 'video');
$videoActionNavigation_arr['video_list_url_5'] = getUrl('videolist', '?pg='.$VideoList->getFormField('pg').'&action=5', $VideoList->getFormField('pg').'/?action=5', '', 'video');

$videoActionNavigation_arr['videoMostViewed_0'] = $videoActionNavigation_arr['videoMostViewed_1'] = $videoActionNavigation_arr['videoMostViewed_2'] = $videoActionNavigation_arr['videoMostViewed_3'] = $videoActionNavigation_arr['videoMostViewed_4'] = $videoActionNavigation_arr['videoMostViewed_5'] = '';

if($VideoList->getFormField('pg') == 'videomostviewed'
	OR $VideoList->getFormField('pg') == 'videomostdiscussed'
		OR $VideoList->getFormField('pg') == 'videomostfavorite')
	{
		if(!$VideoList->getFormField('action')) $VideoList->setFormField('action', '0');
		$sub_page = 'videoMostViewed_'.$VideoList->getFormField('action');
		$videoActionNavigation_arr[$sub_page] = ' class="clsActiveTabNavigation"';
	}
$smartyObj->assign('videoActionNavigation_arr', $videoActionNavigation_arr);

if($VideoList->getFormField('searchkey'))
	{
		$VideoList->setFormField('keyword', $VideoList->getFormField('searchkey'));
		$VideoList->setFormField('avd_search', '1');
		$VideoList->getFormField('keyword');
	}

$start = $VideoList->getFormField('start');
if ($VideoList->getFormField('cid') && !$VideoList->getFormField('sid') && $CFG['admin']['videos']['sub_category'])
{
    $VideoList->setPageBlockShow('form_show_sub_category');
}
if ($VideoList->getFormField('pg') == 'myalbumvideolist')
{
    if (!$VideoList->chkValidAlbumId())
	{
        $VideoList->setAllPageBlocksHide();
        $VideoList->setPageBlockShow('videolist_msg_form_error');
        $VideoList->setCommonErrorMsg($LANG['videolist_msg_error_sorry'] . ' ' . $LANG['videolist_invalid_album']);
    }
}
//commented the following lines since this is moved to the root file and member authentication is set there
/*$memberVideoListCase = array('myvideos','myfavoritevideos','myrecentlyviewedvideo','myalbumvideolist','myplaylist');
if (in_array($VideoList->getFormField('pg'),$memberVideoListCase) AND !isMember())
{
	Redirect2URL(getUrl('videolist','?pg='.$VideoList->getFormField('pg'),$VideoList->getFormField('pg').'/','','video'));
}*/

if ($VideoList->isFormPOSTed($_POST, 'avd_reset'))
	{
		$VideoList->setFormField('keyword', '');
		$VideoList->setFormField('video_owner', '');
		$VideoList->setFormField('video_country', '');
		$VideoList->setFormField('video_language', '');
		$VideoList->setFormField('run_length', '');
		$VideoList->setFormField('added_within', '');
	}

if ($VideoList->isFormPOSTed($_POST, 'yes'))
{

    if ($VideoList->getFormField('act') == 'delete')
	{
        $videos_arr = explode(',', $VideoList->getFormField('video_id'));
        $VideoList->deleteVideos($videos_arr, $CFG['user']['user_id']);
    }
    if ($VideoList->getFormField('act') == 'set_avatar')
	{
        $VideoList->setFeatureThisImage($VideoList->getFormField('video_id'), $CFG['user']['user_id']);
        $VideoList->setPageBlockShow('msg_form_error');
        $VideoList->setCommonErrorMsg($LANG['videolist_msg_success_set_avatar']);
    }
    if ($VideoList->getFormField('act') == 'favorite_delete')
	{
        $video_id_arr = explode(',', $VideoList->getFormField('video_id'));
        foreach($video_id_arr as $video_id)
		{
               $VideoList->deleteFavoriteVideo($video_id, $CFG['user']['user_id']);
        }
    }
    if ($VideoList->getFormField('act') == 'playlist_delete')
	{
        $video_id_arr = explode(',', $VideoList->getFormField('video_id'));
        foreach($video_id_arr as $video_id)
		{
            $VideoList->deletePlaylistVideo($video_id);
        }
    }
    if ($VideoList->getFormField('act') == 'set_playlist_thumb')
	{
        $video_id = $VideoList->getFormField('video_id');
        $VideoList->setPlaylistThumbnail($video_id);
    }
    if ($VideoList->getFormField('act') == 'set_album_thumb')
	{
        $video_id = $VideoList->getFormField('video_id');
        $album_id = $VideoList->getFormField('album_id');
        $VideoList->updateAlbumProfileImage($video_id, $album_id);
    }
}

$VideoList->category_name = '';

if ($VideoList->isShowPageBlock('form_show_sub_category'))
{
    $VideoList->populateSubCategories();
    $VideoList->category_name = $VideoList->getVideoCategoryName();
    $VideoList->LANG['videolist_category_title'] = str_replace('{category}', $VideoList->category_name, $LANG['videolist_category_title']);
}
$VideoList->LANG['videolist_title'] = $VideoList->getPageTitle();
// generation Detail & Thumb Link
if ($CFG['feature']['rewrite_mode'] != 'normal')
    $thum_details_arr = array('album_id', 'cid', 'tags', 'video_id', 'user_id', 'start', 'action');
else
    $thum_details_arr = array('album_id', 'cid', 'tags', 'user_id', 'video_id', 'start', 'pg', 'action');

$VideoList->showThumbDetailsLinks_arr = $VideoList->showThumbDetailsLinks($thum_details_arr);
if ($VideoList->isShowPageBlock('msg_form_error'))
{
    $VideoList->msg_form_error['common_error_msg'] = $VideoList->getCommonErrorMsg();
}
if ($VideoList->isShowPageBlock('msg_form_success'))
{
    $VideoList->msg_form_success['common_error_msg'] = $VideoList->getCommonErrorMsg();
}
if ($VideoList->isShowPageBlock('my_videos_form'))
{
    /**
     * ***** navigtion continue********
     */
    $VideoList->setTableAndColumns();
    $VideoList->buildSelectQuery();
    // $VideoList->buildConditionQuery($condition);
    $VideoList->buildQuery();
    //$VideoList->printQuery();
    $group_query_arr = array('myrecentlyviewedvideo','videomostfavorite','featuredvideolist','videomostviewed','videomostdiscussed','albumlist');



    if (in_array($VideoList->getFormField('pg'), $group_query_arr))
        $VideoList->homeExecuteQuery();
    else
        $VideoList->executeQuery();
    /**
     * ****** Navigation End *******
     */
    $VideoList->my_videos_form['anchor'] = 'anchor';
    $VideoList->isResultsFound = $VideoList->isResultsFound();

    if ($CFG['feature']['rewrite_mode'] != 'normal')
        $paging_arr = array('album_id', 'cid', 'sid', 'tags', 'user_id', 'action',
							'thumb','keyword','video_language','run_length',
							'video_owner','video_country','added_within', 'start',
							'advanceFromSubmission', 'pg', 'video_title', 'myvideo', 'myfavoritevideo');
    else
        $paging_arr = array('album_id', 'cid', 'sid', 'tags', 'user_id', 'action',
							'thumb','keyword','video_language','run_length',
							'video_owner','video_country','added_within', 'start',
							'advanceFromSubmission', 'pg', 'video_title', 'myvideo', 'myfavoritevideo');

    $smartyObj->assign('paging_arr',$paging_arr);

    if ($VideoList->isResultsFound())
	{
		//$smartyObj->assign('smarty_paging_list', $VideoList->populatePageLinksGET($VideoList->getFormField('start'), $paging_arr));
		$smartyObj->assign('smarty_paging_list', $VideoList->populatePageLinksPOST($VideoList->getFormField('start'), 'seachAdvancedFilter'));
        switch ($VideoList->getFormField('pg'))
		{
            case 'useralbumlist':
                if (!$VideoList->isMe($VideoList->ALBUM_USER_ID))
                    break;
            case 'myvideos':
                $VideoList->setPageBlockShow('check_all_item');
                break;
            case 'myfavoritevideos':
                $VideoList->setPageBlockShow('check_all_item');
                break;
            case 'myplaylist':
                $VideoList->setPageBlockShow('check_all_item');
                break;
        }
        $VideoList->my_videos_form['showVideoList'] = $VideoList->showVideoList();
    }
}
// include the header file
$VideoList->includeHeader();
?>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['video_url'];?>js/thumbHover.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/AG_ajax_html.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['video_url'];?>js/viewVideo.js"></script>

<?php
// include the content of the page
setTemplateFolder('general/', 'video');
$smartyObj->display('videoList.tpl');
// includ the footer of the page
// <<<<<<--------------------Page block templates Ends--------------------//
?>
<script type="text/javascript">
var block_arr= new Array('selMsgConfirm', 'selMsgConfirmMulti', 'selEditVideoComments');
var max_width_value = "<?php echo $CFG['admin']['videos']['get_code_max_size']; ?>";
var delLink_value;
var popup_info_left_position = 640;
var popup_info_top_position = 510;
</script>
<script type="text/javascript" language="javascript">
var form_name_array = new Array('seachAdvancedFilter');
function updateVideosQuickLinksCount(video_id)
	{
		var url = '<?php echo $CFG['site']['video_url'];?>videoUpdateQuickLinks.php';
		var pars = '?video_id='+video_id;
		var path=url+pars;
		curr_video_id=video_id;
		new jquery_ajax(path, '','getQuickLinkCode');
		return false;
	}

function getQuickLinkCode(data)
	{
		var obj = document.getElementById('quick_link_'+curr_video_id);
		$Jq('#'+'qucik_link_add_'+curr_video_id).hide();
		$Jq('#'+'qucik_link_added_'+curr_video_id).show();
		$Jq('#'+'balloon').hide();
	}
function swapImage(id, str)
	{
		start_counter=0;
		start_js_animation=false;
		//str = '<?php echo $CFG['site']['url']; ?>videoAnimatedGif.php?video_id='+start_js_video_id+'&start_counter=initial';

		start_js_image=id.src=str;
	}
var start_js_animation=true;
var start_js_id='';
var start_js_video_id='';
var start_counter=0;
var start_js_image='';
function processImageRepeat()
	{
		start_counter++;
		start_js_image = '<?php echo $CFG['site']['video_url'];

?>videoAnimatedGif.php?video_id='+start_js_video_id+'&start_counter='+start_counter;
		//alert(start_counter);
		if(start_counter > <?php echo $CFG['admin']['videos']['rotating_thumbnail_max_frames'];

?>)
			{
				start_counter=0;
				//start_js_animation=false;
			}
		//new Ajax.Request(url, {method:'get',parameters:'&ajax_page=1', onComplete:setProcessImage});
		if(start_js_animation)
			{
				start_js_id.src=start_js_image;
				processImage(start_js_id,start_js_video_id);
			}
	}

function processImage(id, video_id)
	{
		start_js_animation=true;
		start_js_id=id;
		start_js_video_id=video_id;
		setTimeout('processImageRepeat()', <?php echo ($CFG['admin']['videos']['rotating_thumbnail_js_method_delay_seconds']);

?>);
		//tTimeout('processImageRepeat()', 200);
	}
function clearValue(id)
{
	$Jq('#'+id).val('');
}
function setOldValue(id)
{
	if (($Jq('#'+id).val()=="") && (id == 'keyword') )
		$Jq('#'+id).val('<?php echo $LANG['videolist_keyword']?>');
	if (($Jq('#'+id).val()=="") && (id == 'video_owner') )
		$Jq('#'+id).val('<?php echo $LANG['videolist_user_name']?>');
}
function loadUrl(element)
	{
		var default_url = "<?php echo $VideoList->default_url; ?>";
		if(element.value != default_url)
			document.getElementById('default').value = 'No';

		//document.getElementById('default').value

		document.seachAdvancedFilter.action=element.value;
		document.seachAdvancedFilter.submit();
	}
</script>
<?php
$VideoList->includeFooter();
?>
