<?php
/**
 * VideoList
 *
 * @package
 * @author selvaraj_35ag05
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: videoList.php 2986 2006-12-29 05:25:10Z selvaraj_35ag05 $
 * @access public
 **/
class VideoList extends VideoHandler
	{
		public $UserDetails = array();
		public $ALBUM_USER_ID;
		public $ALBUM_TITLE;
		public $play_list_url_exists;

		/**
		 * VideoList::setTableAndColumnsVideos()
		 *
		 * @return
		 */
		public function setTableAndColumnsVideos()
			{
				$this->setTableNames(array($this->CFG['db']['tbl']['video'].' AS p, '.$this->CFG['db']['tbl']['video_in_playlist'].' AS c'));
				$this->setReturnColumns(array('p.video_id', 'p.video_category_id',  'p.user_id','p.video_ext', 'p.video_title', 'p.video_server_url', 'p.t_width', 'p.t_height', 'TIMEDIFF(NOW(), p.date_added) as date_added', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'video_tags', 'TIME_FORMAT(playing_time,\'%H:%i:%s\') as playing_time', 'video_encoded_status', 'video_status', 'TIMEDIFF(NOW(), last_view_date) as video_last_view_date'));
				$additional_query = '';
				if($this->fields_arr['tags'])
					{
						$additional_query .= '('.getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.video_tags', 'OR').' video_title LIKE\'%'.addslashes($this->fields_arr['tags']).'%\') AND ';
					}
				$this->sql_condition = $additional_query.'p.video_status=\'Ok\''.$this->getAdultQuery('p.').' AND (p.user_id = '.$this->CFG['user']['user_id'].' OR p.video_access_type = \'Public\''.$this->getAdditionalQuery('p.').')  AND p.video_id=c.video_id AND playlist_id=\''.$this->fields_arr['playlist_id'].'\' ';
				$this->sql_sort = ' c.order_id ASC ';
			}

		/**
		 * VideoList::showVideoList()
		 *
		 * @return
		 **/
		public function showVideoList()
			{
				$showVideoList_arr = array();
				//for tags
				$separator = ':&nbsp;';
				$tag = $this->_parse_tags(strtolower($this->fields_arr['tags']));
				$relatedTags = array();
				$videosPerRow = 1;
				$count = 0;
				$showVideoList_arr['found'] = false;
				$videos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
				$fields_list = array('user_name', 'first_name', 'last_name');
				$videoTags = array();
				$inc = 0;
				$showVideoList_arr['row'] = array();
				while($row = $this->fetchResultRecord())
				    {
						$row['date_added'] = ($row['date_added'] != '') ? getTimeDiffernceFormat($row['date_added']) : '';
						$row['video_last_view_date'] = ($row['video_last_view_date'] != '') ? getTimeDiffernceFormat($row['video_last_view_date']) : '';

						$showVideoList_arr['row'][$inc]['record'] = $row;
						$showVideoList_arr['row'][$inc]['need_profile_icon_arr'] = array('featuredvideolist', 'videonewmale', 'videonewfemale');
						if(in_array($this->fields_arr['pg'], $showVideoList_arr['row'][$inc]['need_profile_icon_arr']))
							{
								$this->UserDetails[$row['user_id']]['first_name'] = $row['first_name'];
								$this->UserDetails[$row['user_id']]['last_name'] = $row['last_name'];
								$this->UserDetails[$row['user_id']]['user_name'] = $row['user_name'];
								if(!$this->getVideoDetails(array('video_id', 'TIMEDIFF(NOW(), date_added) as date_added', 'user_id', '(rating_total/rating_count) as rating', 'total_views', 'video_server_url', 'video_ext', 'video_title', 't_width', 't_height', 'video_tags', 'playing_time', 'video_encoded_status', 'video_status', 'TIMEDIFF(NOW(), last_view_date) as video_last_view_date'), $row['icon_id']))
									continue;
								$row = array_merge($row, $this->video_details);
							}
						if(!isset($this->UserDetails[$row['user_id']]))
						   $this->getUserDetail('user_id',$row['user_id'], 'user_name');

						$user_name=$this->getUserDetail('user_id',$row['user_id'], 'user_name');
						$showVideoList_arr['row'][$inc]['name'] = $user_name;
						$showVideoList_arr['row'][$inc]['view_video_link'] = getUrl('viewvideo', '?video_id='.$row['video_id'].'&amp;title='.$this->changeTitle($row['video_title']), $row['video_id'].'/'.$this->changeTitle($row['video_title']).'/', '', 'video');
						$showVideoList_arr['row'][$inc]['view_video_page_arr'] = array('myvideos', 'uservideolist');
						if($this->fields_arr['pg']=='abumvideolist')
							$showVideoList_arr['row'][$inc]['view_video_link'] = getUrl('viewvideo', '?video_id='.$row['video_id'].'&amp;title='.$this->changeTitle($row['video_title']).'&amp;album_id='.$row['video_album_id'], $row['video_id'].'/'.$this->changeTitle($row['video_title']).'/?album_id='.$row['video_album_id'], '' , 'video');
						else if(in_array($this->fields_arr['pg'], $showVideoList_arr['row'][$inc]['view_video_page_arr']))
							$showVideoList_arr['row'][$inc]['view_video_link'] = getUrl('viewvideo', 'video_id='.$row['video_id'].'&amp;title='.$this->changeTitle($row['video_title']), 'viewvideo/'.$row['video_id'].'/'.$this->changeTitle($row['video_title']).'/', '' , 'video');
						$showVideoList_arr['found'] = true;
						$showVideoList_arr['row'][$inc]['anchor'] = 'dAlt_'.$row['video_id'];
						$showVideoList_arr['row'][$inc]['video_DISP_IMAGE'] = DISP_IMAGE($this->CFG['admin']['videos']['thumb_width'], $this->CFG['admin']['videos']['thumb_height'], $row['t_width'], $row['t_height']);
						$showVideoList_arr['row'][$inc]['video_img_path'] = $this->CFG['site']['url'].'images/notActivateVideo_T.jpg';
						$showVideoList_arr['row'][$inc]['wordWrap_video_title'] = $row['video_title'];
    					if($this->IS_EDIT)
							{
								$showVideoList_arr['row'][$inc]['checked'] = '';
								if((is_array($this->fields_arr['video_ids'])) && (in_array($row['video_id'], $this->fields_arr['video_ids'])))
									$showVideoList_arr['row'][$inc]['checked'] = 'checked';
  							}
						if($row['video_encoded_status']!='Yes')
							{
								$showVideoList_arr['row'][$inc]['wordWrap_video_title'] = $row['video_title'];
								$showVideoList_arr['row'][$inc]['video_DISP_IMAGE'] = DISP_IMAGE($this->CFG['admin']['videos']['thumb_width'], $this->CFG['admin']['videos']['thumb_height'], $row['t_width'], $row['t_height']);
								$showVideoList_arr['row'][$inc]['video_img_path'] = $this->CFG['site']['url'].'images/notActivateVideo_T.jpg';
							}
						else if($row['video_encoded_status']=='Yes' and $row['video_status']=='Locked')
							{
							}
						else
							{
								$showVideoList_arr['row'][$inc]['video_img_path'] = $row['video_server_url'].$videos_folder.getVideoImageName($row['video_id']).$this->CFG['admin']['videos']['thumb_name'].'.'.$this->CFG['video']['image']['extensions'];
								if($this->fields_arr['thumb']!='yes')
									{
										$showVideoList_arr['row'][$inc]['wordWrap_video_title'] = $row['video_title'];

                                        $user_name=$this->getUserDetail('user_id',$row['user_id'], 'user_name');

										$showVideoList_arr['row'][$inc]['getMemberProfileUrl'] = getMemberProfileUrl($row['user_id'], $user_name);
										//$showVideoList_arr['row'][$inc]['search_video_tags'] =  $this->LANG['search_video_tags'], $separator;
										$showVideoList_arr['row'][$inc]['tags'] =  $tags= $this->_parse_tags($row['video_tags']);
										if ($tags)
											{
												$i = 0;
												foreach($tags as $key=>$value)
													{
														if($this->CFG['admin']['videos']['tags_count_list_page']==$i)
															break;
														$showVideoList_arr['row'][$inc]['tag_value'] = strtolower($value);
														if (!in_array($value, $tag) AND !in_array($value, $relatedTags))
															$relatedTags[] = $value;
														if (!in_array($value, $videoTags))
															$videoTags[] = $value;
															$showVideoList_arr['row'][$inc]['videoList_tag_url'] =  getUrl('videolist', '?pg=videonew&amp;tags='.$value, 'videonew/?tags='.$value, '' ,'video');
														$i++;
													}
											 }
									}
							}
						$inc++;
					}
				//if($this->fields_arr['tags'] and $this->CFG['admin']['tagcloud_based_search_count'])
					//$this->updateVideoTagDetails($videoTags);
				return $showVideoList_arr;
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
				    {
				        return;
				    }
				if (count($match)==1)
				    {
				     	$this->updateSearchCountAndResultForVideoTag($match[0]);
				    }
				else
					{
						for($i=0; $i<count($match); $i++)
							{
								$tag = $match[$i];
								$this->updateSearchCountForVideoTag($tag);
							}
					}
			}

		/**
		 * VideoList::updateSearchCountForVideoTag()
		 *
		 * @param string $tag
		 * @return
		 */
		public function updateSearchCountForVideoTag($tag='')
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['tags_video'].
					   ' SET search_count = search_count + 1,'.
					   ' result_count = '.$this->getResultsTotalNum().','.
					   ' last_searched = NOW()'.
					   ' WHERE tag_name='.$this->dbObj->Param('tag_name');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($tag));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($this->dbObj->Affected_Rows()==0)
				    {
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['tags_video'].
							   ' SET search_count = search_count + 1 ,'.
							   ' result_count = '.$this->getResultsTotalNum().','.
							   ' last_searched = NOW(),'.
							   ' tag_name='.$this->dbObj->Param('tag_name');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($tag));
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				    }
			}

		/**
		 * VideoList::updateSearchCountAndResultForVideoTag()
		 *
		 * @param string $tag
		 * @return
		 */
		public function updateSearchCountAndResultForVideoTag($tag='')
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['tags_video'].
					   ' SET search_count = search_count + 1,'.
					   ' result_count = '.$this->getResultsTotalNum().','.
					   ' last_searched = NOW()'.
					   ' WHERE tag_name='.$this->dbObj->Param('tag_name');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($tag));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($this->dbObj->Affected_Rows()==0)
				    {
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['tags_video'].
							   ' SET search_count = search_count + 1 ,'.
							   ' result_count = '.$this->getResultsTotalNum().','.
							   ' last_searched = NOW(),'.
							   ' tag_name='.$this->dbObj->Param('tag_name');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($tag));
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				    }
			}

		/**
		 * VideoList::getPageTitleVideo()
		 *
		 * @return
		 */
		public function getPageTitleVideo()
			{
				$pg_title = $this->play_list_details_arr['play_list_name'].': '.$this->LANG['videolist_title'];
				if($this->fields_arr['tags'])
					{
						$pg_title = $this->LANG['tagsvideo_title'];
						$name = $this->fields_arr['tags'];
						$pg_title = str_replace('{tags_name}', $name, $pg_title);
					}
				return $pg_title;
			}

		/**
		 * VideoList::isValidPlayList()
		 *
		 * @return
		 */
		public function isValidPlayList()
			{
				$condition = ' playlist_id='.$this->dbObj->Param('playlist_id').' AND'.
							' (p.user_id = '.$this->dbObj->Param('user_id').' OR'.
							' p.playlist_access_type = \'Public\''.$this->getAdditionalQuery('p.').') AND u.user_id=p.user_id ';
				$sql = 'SELECT p.playlist_name as play_list_name, u.user_name, p.playlist_id,   p.user_id, p.playlist_description as play_list_description, p.playlist_tags as play_list_tags, p.total_videos, p.thumb_video_id as thumbs_video_id  FROM '.$this->CFG['db']['tbl']['video_playlist'].' as p'.', '.$this->CFG['db']['tbl']['users'].' u '.
						' WHERE '.$condition.' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist_id'], $this->CFG['user']['user_id']));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						if($row['user_id']==$this->CFG['user']['user_id'])
							$this->IS_EDIT=true;
						$this->play_list_details_arr=$row;
						return true;
					}
				return false;
			}

		/**
		 * VideoList::getNextPlayListLinks()
		 *
		 * @return
		 */
		public function getNextPlayListLinks()
			{
				$condition=' playlist_id=\''.$this->fields_arr['playlist_id'].'\' ';
				$sql = 'SELECT video_id as video_id, order_id FROM '.$this->CFG['db']['tbl']['video_in_playlist'].' as v'.
						' WHERE '.$condition.' ORDER BY order_id ASC LIMIT 0,2';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
				$count=1;
				$this->play_list_url_exists=false;
				while($row = $rs->FetchRow() and $row['video_id'])
					{
						$this->play_list_url_exists=true;
						$link = getUrl('viewvideo', '?video_id='.$row['video_id'].'&amp;vpkey='.$this->fields_arr['vpkey'].'&amp;play_list=pl&amp;playlist_id='.$this->fields_arr['playlist_id'].''.'&amp;order='.$row['order_id'], $row['video_id'].'/?vpkey='.$this->fields_arr['vpkey'].'&amp;play_list=pl&amp;playlist_id='.$this->fields_arr['playlist_id'].'&amp;order='.$row['order_id'], '', 'video');
						$this->play_list_next_url=$link;
						if($count==1)
							{
								$this->play_list_id=$row['video_id'];
?>
								<a class="clsPlayListEdit" href="<?php echo $link;?>"><?php echo $this->LANG['view_video_play_next_list']; ?></a>
<?php
							}
							else
								$this->play_list_next_url=$link;
						$count++;
					}
			}

		/**
		 * VideoList::getTagLinks()
		 *
		 * @param mixed $tags
		 * @return
		 */
		public function getTagLinks($tags)
			{
				$tag = $this->_parse_tags(strtolower($this->fields_arr['tags']));
				$tags= $this->_parse_tags($tags);
				$relatedTags = array();
				$playlistTags=array();
				if ($tags)
				    {
				        $i = 0;
						foreach($tags as $key=>$value)
							{
								if($this->CFG['admin']['playlists']['tags_count_list_page']==$i)
									break;
								$value = strtolower($value);

								if (!in_array($value, $tag) AND !in_array($value, $relatedTags))
									$relatedTags[] = $value;

								if (!in_array($value, $playlistTags))
							        $playlistTags[] = $value;
?>
										<a href="<?php echo getUrl('videoplaylist', '?pg=playlistnew&amp;tags='.$value, '?pg=playlistnew&tags='.$value, '', 'video');?>" ><?php echo $value;?></a>
<?php
										$i++;
							}
					 }
			}

		/**
		 * To get video count of the playlist
		 *
		 * @access public
		 * @return void
		 **/
		public function getVideoCount($playlist_id)
			{
				$sql = 'SELECT count(video_id) as cat_count'.
						' FROM '.$this->CFG['db']['tbl']['video_in_playlist'].
						' WHERE playlist_id = '.$this->dbObj->Param($playlist_id).
						' AND 1 ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($playlist_id));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$row = $rs->FetchRow();
				return $row['cat_count'];
			}


		/**
		 * VideoList::deleteVideosFrmPlayLists()
		 *
		 * @param mixed $video_arr
		 * @param mixed $user_id
		 * @return
		 */
		public function deleteVideosFrmPlayLists($video_arr, $user_id)
			{
				$video_arr=implode(',',$video_arr);
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['video_in_playlist'].' '.
						'WHERE video_id IN ('.$video_arr.') AND playlist_id=\''.$this->fields_arr['playlist_id'].'\' ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$this->setCommonErrorMsg($this->LANG['video_play_list_updated']);
				return true;
			}


		/**
		 * VideoList::listPlayListDetails()
		 *
		 * @return
		 */
		public function listPlayListDetails()
			{

				$listPlayListDetails_arr = array();
				if($this->play_list_details_arr)
					$listPlayListDetails_arr['play_list_details_arr'] = $this->play_list_details_arr;
				else
					$listPlayListDetails_arr['play_list_details_arr'] = array();
				$listPlayListDetails_arr['wordWrap_play_list_description'] = $this->play_list_details_arr['play_list_description'];
				$listPlayListDetails_arr['getMemberProfileUrl'] = getMemberProfileUrl($this->play_list_details_arr['user_id'], $this->play_list_details_arr['user_name']);
				//$listPlayListDetails_arr['getTagLinks'] = $this->getTagLinks($this->play_list_details_arr['play_list_tags']);
				$listPlayListDetails_arr['getVideoCount'] = $this->getVideoCount($this->play_list_details_arr['playlist_id']);
				$listPlayListDetails_arr['videoPlayList_url'] = getUrl('videoplaylist', '?pg=userplaylist&amp;user_id='.$this->play_list_details_arr['user_id'],'?pg=userplaylist&amp;user_id='.$this->play_list_details_arr['user_id'], '', 'video');
				//$listPlayListDetails_arr['getNextPlayListLinks'] = $this->getNextPlayListLinks();
				$videos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/';
				$flv_player_url = $this->CFG['site']['url'].'flvplayer.swf';
				$arguments_play = 'pg=video_'.$this->play_list_id.'_no_'.getRefererForAffiliate().'&next_url='.$this->play_list_next_url.'&play_list=pl&playlist_id='.$this->fields_arr['playlist_id'].'';
				$arguments_embed = 'pg=video_'.$this->play_list_id.'_no_0&ext_site='.'&next_url='.$this->play_list_next_url.'&play_list=pl&playlist_id='.$this->fields_arr['playlist_id'];
				$configXmlcode_url = $this->CFG['site']['video_url'].'videoConfigXmlCode.php?';
				$listPlayListDetails_arr['play_list_url_exists'] = $this->play_list_url_exists;
				if($this->play_list_url_exists)
						$listPlayListDetails_arr['viewVideoPlayList_url'] = getUrl('viewvideoplaylist', '?playlist_id='.$this->fields_arr['playlist_id'], '?playlist_id='.$this->fields_arr['playlist_id'], '', 'video');
				return $listPlayListDetails_arr;
			}
	}
//<<<<<-------------- Class VideoUpload begins ---------------//
//-------------------- Code begins -------------->>>>>//
$VideoList = new VideoList();
if(!chkAllowedModule(array('video')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$VideoList->setPageBlockNames(array('msg_form_error', 'msg_form_success', 'my_videos_form', 'delete_confirm_form', 'featured_confirm_form'));
//default form fields and values...
$VideoList->setFormField('video_id', '');
$VideoList->setFormField('album_id', '');
$VideoList->setFormField('video_ext', '');
$VideoList->setFormField('action', '');
$VideoList->setFormField('act', '');
$VideoList->setFormField('pg', 'videonew');
$VideoList->setFormField('cid', '');
$VideoList->setFormField('sid', '');
$VideoList->setFormField('tags', '');
$VideoList->setFormField('vpkey', '');
$VideoList->setFormField('search_type', '');
$VideoList->setFormField('user_id', '0');
/*********** Page Navigation Start *********/
$VideoList->setFormField('start', '0');
$VideoList->setFormField('slno', '1');
$VideoList->setFormField('video_ids', array());
$VideoList->setFormField('thumb','no');
$VideoList->setFormField('numpg', $CFG['video_tbl']['numpg']);
$VideoList->setFormField('playlist_id', '');
$VideoList->IS_EDIT=false;
$VideoList->play_list_id='';
$VideoList->play_list_next_url='';
$VideoList->setMinRecordSelectLimit(2);
$VideoList->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$VideoList->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$VideoList->setTableNames(array());
$VideoList->setReturnColumns(array());
/************ page Navigation stop *************/
$VideoList->setAllPageBlocksHide();
$VideoList->setPageBlockShow('my_videos_form');
$VideoList->sanitizeFormInputs($_REQUEST);
if(!$VideoList->isValidPlayList())
	{
		Redirect2URL(getUrl('videoplaylist', '', '', '', 'video'));
	}
else
	{
		$LANG['videolist_title'] = $VideoList->getPageTitleVideo();
	}

if(!chkAllowedModule(array('video')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$VideoList->setPageBlockShow('my_videos_form');
/*if($VideoList->getFormField('pg')=='abumvideolist')
	{
		if(!$VideoList->chkValidAlbumId())
			{
				$VideoList->setAllPageBlocksHide();
				$VideoList->setPageBlockShow('msg_form_error');
				$VideoList->setCommonErrorMsg($LANG['msg_error_sorry'].' '.$LANG['invalid_album']);
			}
	}*/
if($VideoList->isFormPOSTed($_POST, 'yes'))
	{
		if($VideoList->getFormField('act')=='delete')
			{
				$videos_arr = explode(',',$VideoList->getFormField('video_id'));
				if($VideoList->deleteVideosFrmPlayLists($videos_arr, $CFG['user']['user_id']))
					$VideoList->setPageBlockShow('msg_form_success');
			}
	}
//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if($VideoList->getFormField('search_type')=='video')
	{
		if($CFG['feature']['rewrite_mode'] == 'htaccess')
			$paging_arr = array('tags', 'user_id', 'action','search_type','playlist_id');
		else
			$paging_arr = array('album_id', 'cid', 'tags', 'user_id', 'pg', 'action','search_type','playlist_id');
		if($CFG['admin']['videos']['list_thumb_detail_view'])
				$VideoList->showThumbDetailsLinks($paging_arr);
	}
if ($VideoList->isShowPageBlock('my_videos_form'))
    {
		/****** navigtion continue*********/
		$VideoList->setTableAndColumnsVideos();
		$VideoList->buildSelectQuery();
		$VideoList->buildQuery();
		//$VideoList->printQuery();
		$VideoList->executeQuery();
		$VideoList->my_videos_form['anchor'] = 'anchor';
		if($VideoList->isResultsFound())
			{
				$VideoList->my_videos_form['listPlayListDetails_arr'] = $VideoList->listPlayListDetails();
				$VideoList->my_videos_form['confirm_delete'] = 'if(getMultiCheckBoxValue(\'videoListForm\', \'check_all\', \''.$LANG['common_check_atleast_one'].'\')){Confirmation(\'selMsgConfirmMulti\', \'msgConfirmformMulti\', Array(\'video_id\', \'act\', \'msgConfirmTextMulti\'), Array(multiCheckValue, \'delete\', \''.$LANG['videolist_multi_delete_confirmation'].'\'), Array(\'value\', \'value\', \'innerHTML\'));}';
				if($CFG['feature']['rewrite_mode'] == 'htaccess')
					$VideoList->my_videos_form['paging_arr'] = array('tags', 'user_id', 'action','search_type','playlist_id');
				else
					$VideoList->my_videos_form['paging_arr'] = array('album_id', 'cid', 'tags', 'user_id', 'pg', 'action','search_type','playlist_id');
					$VideoList->my_videos_form['showVideoList_arr'] = $VideoList->showVideoList();
			}
	}
//<<<<<-------------------- Page block templates ends -------------------//
//include the header file
$VideoList->includeHeader();
//include the content of the page
setTemplateFolder('general/','video');
$smartyObj->display('viewVideoPlayList.tpl');
?>
<script type="text/javascript" language="javascript" src="<?php echo $CFG['site']['project_path_relative'];?>js/functions.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['project_path_relative'];?>js/AG_ajax_html.js"></script>
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgConfirm', 'selMsgConfirmMulti', 'selEditPhotoComments');
	var max_width_value = "<?php echo $CFG['admin']['videos']['get_code_max_size'];?>";
	var delLink_value;
	var curr_video_id='';
	function callAjaxGetCode(path, delLink)
		{
			delLink_value = delLink;
			new AG_ajax(path,'displayGetCode');
			return false;
		}
	function displayGetCode(data)
		{
			data = unescape(data);
			var obj = document.getElementById('selEditPhotoComments');

			if(data.indexOf(session_check)>=1)
				data = data.replace(session_check_replace,'');
			else
				return;

			obj.innerHTML = '<div id="selDisplayWidth">'+data+'</div>';
			Confirmation(delLink_value, 'selEditPhotoComments', 'msgConfirmform', Array('selEditPhotoComments'), Array('<div id="selDisplayWidth">'+data+'</div>'), Array('innerHTML'), -100, -500);
			return false;
		}
	function updateVideosQuickLinksCount(video_id)
		{
			var url = '<?php echo $CFG['site']['video_url'];?>video/videoUpdateQuickLinks.php';
			var pars = '?video_id='+video_id;
			var path=url+pars;
			curr_video_id=video_id;
			new AG_ajax(path,'getQuickLinkCode');
			return false;
		}
	function getQuickLinkCode(data)
		{
			var obj = document.getElementById('quick_link_'+curr_video_id);
			obj.innerHTML = '<?php echo $LANG['add_to_quick_links_added'] ?>';
		}
</script>
<?php
$VideoList->includeFooter();
?>