<?php
$CFG['site']['is_module_page']='video';
require_once($CFG['site']['project_path'].'languages/'.$CFG['lang']['default'].'/video/indexVideoBlock.php');
require_once($CFG['site']['project_path'].'common/configs/config_video.inc.php');
require_once($CFG['site']['project_path'].'common/classes/class_VideoHandler.lib.php');
require_once($CFG['site']['project_path'].'common/configs/config_video_player.inc.php');
/**
 * IndexPageVideoHandler
 *
 * @package
 * @author edwin_90ag08
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id$
 * @access public
 */
class IndexPageVideoHandler extends VideoHandler
	{
		public $chk_for_video_first_block = false;

		/**
		* IndexPageVideoHandler::isWatchedVideo()
		*
		* @return
		*/
		public function isWatchedVideo()
			{

				$add_field = '';
				$add_con = ' AND vc.video_category_id=v.video_category_id ';
				$add_order = ' ORDER BY last_view_date  DESC ';
				$sql_condition = '(u.user_id = v.user_id'.
								 ' AND u.usr_status=\'Ok\')'.
								 ' AND v.video_status=\'Ok\' '.
								 ' AND (v.user_id = '.$this->CFG['user']['user_id'].
								 ' OR v.video_access_type = \'Public\''.$this->getAdditionalQuery('v.').')'.$add_con;

				$sql = 'SELECT count(v.video_id) count FROM '.$this->CFG['db']['tbl']['video'].' AS v, '.
						$this->CFG['db']['tbl']['video_category'].' AS vc, '.
						$this->CFG['db']['tbl']['users'].' AS u WHERE '.
						$sql_condition.$add_order;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$video_ids_arr=array();
				$row = $rs->FetchRow();
				if($row['count']>=$this->CFG['admin']['videos']['recent_videos_play_list_counts'])
					return true;
				return false;
			}

		public function getRandVideo()
			{
				$userId = $this->CFG['user']['user_id'];

				$condition = ' p.video_status=\'Ok\'' . $this->getAdultQuery('p.').
							 ' AND u.usr_status=\'Ok\' AND (p.user_id = '.$userId.
							 ' OR p.video_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ') AND p.featured=\'Yes\' ';

				$default_fields = 'p.user_id, p.video_id, p.video_title, p.video_caption, p.total_views, p.video_server_url,p.total_comments,p.is_external_embed_video,p.video_external_embed_code, '.
								   ' p.t_width, p.t_height,(p.rating_total/p.rating_count) as rating,'.
								   ' TIME_FORMAT(p.playing_time,\'%H:%i:%s\') as playing_time, TIMEDIFF(NOW(), p.date_added) as video_date_added,'.
								   ' TIMEDIFF(NOW(), p.last_view_date) as video_last_view_date, p.video_tags,file_name';

				$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' as p JOIN '.
						$this->CFG['db']['tbl']['users'].' as u ON p.user_id = u.user_id'.
						' JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' as vfs ON video_file_id = thumb_name_id'.
						' WHERE '.$condition.' ORDER BY RAND() LIMIT 0,3';

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
				while($row = $rs->FetchRow())
					{
						$video_list_arr[$inc]['video_date_added'] = getTimeDiffernceFormat($row['video_date_added']);
						$video_list_arr[$inc]['video_last_view_date'] = getTimeDiffernceFormat($row['video_last_view_date']);
						$video_list_arr[$inc]['playing_time'] = $row['playing_time']?$row['playing_time']:'00:00';

						$video_list_arr[$inc]['rating']=round($row['rating']);
						$video_list_arr[$inc]['user_name']=$this->getUserDetail('user_id',$row['user_id'], 'user_name');
						$this->UserDetails = $this->getUserDetail('user_id', $row['user_id'], 'user_name');

						$video_list_arr[$inc]['member_profile_url'] = getMemberProfileUrl($row['user_id'], $this->UserDetails);
						$video_list_arr[$inc]['total_views']=$row['total_views'];
						$video_list_arr[$inc]['total_comments']=$row['total_comments'];
						$video_list_arr[$inc]['video_id']=$row['video_id'];
						$video_list_arr[$inc]['is_external_embed_video'] = $row['is_external_embed_video'];
						$video_list_arr[$inc]['video_external_embed_code'] = stripslashes($row['video_external_embed_code']);
						$video_list_arr[$inc]['video_external_embed_code']= str_replace('<embed','<embed wmode="transparent"',$row['video_external_embed_code']);
						$video_list_arr[$inc]['video_external_embed_code']= str_replace('&lt;embed','&lt;embed wmode=&quot;transparent&quot;',$row['video_external_embed_code']);

						$video_list_arr[$inc]['video_url'] = getUrl('viewvideo','?video_id='.$row['video_id'].
																'&title='.$this->changeTitle($row['video_title']),
																	$row['video_id'].'/'.$this->changeTitle($row['video_title']).'/','','video');

						//$video_list_arr[$inc]['rating_image'] =$this->populateRatingImages($row['rating'], 'video', '', '', 'video');

						//$video_list_arr[$inc]['rating_image'] =$row['rating'];

  						if($row['video_caption']!='')
						$video_list_arr[$inc]['video_caption']=  $row['video_caption'];
						else
						$video_list_arr[$inc]['video_caption']=  $this->LANG['index_page_featured_video_caption_err_msg'];

						$video_list_arr[$inc]['image_url'] = $row['video_server_url'].$thumbnail_folder.
																getVideoImageName($row['video_id'], $row['file_name']).
																	$this->CFG['admin']['videos']['thumb_name'].'.'.
																		$this->CFG['video']['image']['extensions'];

						$video_list_arr[$inc]['video_title'] = $row['video_title'];
						$video_list_arr[$inc]['video_title_full'] = $row['video_title'];
						$video_list_arr[$inc]['video_more_url'] =$this->getUrl('viewvideo','?video_id='.$row['video_id'].'&amp;title='.$this->changeTitle($row['video_title']), $row['video_id'].'/'.$this->changeTitle($row['video_title']).'/','','video');
						$video_list_arr[$inc]['record'] = $row;

						$inc++;
					}
				return $video_list_arr;
			}

		public function getPlayer($video_id)
			{
			 	   	$videos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/';
			 	   	$this->populateFlashPlayerConfiguration();
					$this->arguments_play = 'pg=video_'.$video_id.'_no_'.getRefererForAffiliate().'_false_true_false';
					$this->CFG['admin']['videos']['playList']=false;
					?>
					<script type="text/javascript">
		                var so1 = new SWFObject("<?php echo $this->flv_player_url;?>", "flvplayer", "300", "250", "7",  null, true);
		                so1.addParam("allowFullScreen", "true");
		                so1.addParam("wmode", "transparent");
		                so1.addParam("autoplay", "false");
		                so1.addParam("allowSciptAccess", "always");
		                so1.addVariable("config", "<?php echo $this->configXmlcode_url.$this->arguments_play;?>");
		                so1.write("flashcontent2");
	                </script>
					<?php
			}

	  /**
	   * IndexPageVideoHandler::getTotalVideo()
	   *
	   * @param mixed $video_block
	   * @return
	   */
	  public function getTotalVideo($video_block)
			{

				$default_cond = 'u.usr_status=\'Ok\',  v.video_status=\'Ok\''.$this->getAdultQuery('v.').
								' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
								' video_access_type = \'Public\''.$this->getAdditionalQuery().')';

				$default_fields = ' COUNT(1) count ';
				switch($video_block)
					{
						case 'recommendedvideo':
							$limit = $this->CFG['admin']['videos']['recommendedvideo_total_record'];
							$condition = 'v.featured=\'Yes\' AND '.$default_cond;
							$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
									' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON v.user_id=u.user_id'.
					   				' WHERE '.$condition.' ORDER BY video_id DESC ';
							$all_video_url = getUrl('videolist','?pg=videorecommended', 'videorecommended/','','video');
							break;

						case 'topratedvideo':
							$limit = $this->CFG['admin']['videos']['topratedvideo_total_record'];
							$condition = 'rating_total>0 AND allow_ratings=\'Yes\' AND '.$default_cond;
							$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
									' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON v.user_id=u.user_id'.
					   				' WHERE '.$condition.' ORDER BY rating_total DESC ';
							$all_video_url = getUrl('videolist','?pg=videotoprated', 'videotoprated/','','video');
							break;

						case 'newvideo':
							$limit = $this->CFG['admin']['videos']['newvideo_total_record'];
							$condition = $default_cond;
							$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
									' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON v.user_id=u.user_id'.
					   				' WHERE '.$condition.' ORDER BY video_id DESC ';
							$all_video_url = getUrl('videolist','?pg=videonew', 'videonew/','','video');
							break;

						case 'recentlyviewedvideo':
							$limit = $this->CFG['admin']['videos']['recentlyviewedvideo_total_record'];
							$condition = $default_cond;
							$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
									' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON v.user_id=u.user_id'.
					   				' WHERE '.$condition.' ORDER BY last_view_date DESC ';
							$all_video_url = getUrl('videolist','?pg=videomostrecentlyviewed', 'videomostrecentlyviewed/','','video');
							break;
					}

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $row['count'];

			}
	  /**
	   * IndexPageVideoHandler::getVideoIndexBlock()
	   *
	   * @param mixed $video_block
	   * @param integer $totalVideoCount
	   * @param integer $start
	   * @return
	   */
	  public function getVideoIndexBlock($video_block, $all = false)
			{
			   	global $smartyObj;
				$this->setFormField('block', $video_block);
				$totalVideoCount = $this->getFormField('total_video_count');
				$start = $this->getFormField('start');

				$default_cond = 'u.usr_status=\'Ok\' AND v.video_status=\'Ok\''.$this->getAdultQuery('v.').
								' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
								' v.video_access_type = \'Public\''.$this->getAdditionalQuery().')';

				$default_fields = 'v.user_id, v.video_id, v.video_title, v.video_caption, v.total_views, v.video_server_url,'.
								   ' v.t_width, v.t_height,(v.rating_total/v.rating_count) as rating,'.
								   ' TIME_FORMAT(v.playing_time,\'%H:%i:%s\') as playing_time, TIMEDIFF(NOW(), v.date_added) as video_date_added,'.
								   ' TIMEDIFF(NOW(), v.last_view_date) as video_last_view_date, v.video_tags, v.is_external_embed_video, v.embed_video_image_ext,file_name';
				$list_lang='';
				$link_text='';
				$this->video_block=$video_block;
				$order_by = '';
				$userid_arr = array();
				$fields_list = array('user_name', 'first_name', 'last_name');

				switch($video_block)
					{
						case 'recommendedvideo':
						   	$total_row = $this->CFG['admin']['videos']['total_no_of_row_record'];
						   	$record_per_row = $this->CFG['admin']['videos']['recommendedvideo_total_record'];
							$limit = $total_row * $record_per_row;
							$condition = 'v.featured=\'Yes\' AND '.$default_cond;
							$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
									' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON v.user_id=u.user_id'. ' LEFT JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'.
					   				' WHERE '.$condition;
							$all_video_url = getUrl('videolist','?pg=videorecommended', 'videorecommended/','','video');
							$list_lang=$this->LANG['index_title_recommended_videos'];
							$order_by = 'video_id DESC';
							break;

						case 'topratedvideo':
						   	$total_row = $this->CFG['admin']['videos']['total_no_of_row_record'];
						   	$record_per_row = $this->CFG['admin']['videos']['topratedvideo_total_record'];
							$limit = $total_row * $record_per_row;
							$condition = 'v.rating_total>0 AND v.allow_ratings=\'Yes\' AND '.$default_cond;
							$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
									' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON v.user_id=u.user_id'. ' LEFT JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'.
					   				' WHERE '.$condition;
							$all_video_url = getUrl('videolist','?pg=videotoprated', 'videotoprated/','','video');
							$list_lang=$this->LANG['index_title_top_rated_videos'];
							$order_by = 'rating DESC';
							break;

						case 'newvideo':
						   	$total_row = $this->CFG['admin']['videos']['total_no_of_row_record'];
						   	$record_per_row = $this->CFG['admin']['videos']['newvideo_total_record'];
							$limit = $total_row * $record_per_row;
							$condition = $default_cond;
							$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'. ' LEFT JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'.
									' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON v.user_id=u.user_id'.
					   				' WHERE '.$condition;
							$all_video_url = getUrl('videolist','?pg=videonew', 'videonew/','','video');
							$list_lang = $this->LANG['index_title_new_videos'];
							$order_by = 'video_id DESC';
							break;

						case 'recentlyviewedvideo':

						   	$total_row=$this->CFG['admin']['videos']['total_no_of_row_record'];
						   	$record_per_row = $this->CFG['admin']['videos']['recentlyviewedvideo_total_record'];
							$limit = $total_row * $record_per_row;
							$condition = $default_cond;
							$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
									' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON v.user_id=u.user_id'. ' LEFT JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'.
					   				' WHERE '.$condition;

							$all_video_url = getUrl('videolist','?pg=videomostrecentlyviewed', 'videomostrecentlyviewed/','','video');
							$list_lang=$this->LANG['index_title_recoentlyviewed_videos'];
							$order_by = 'last_view_date DESC';
							break;
					}
				if(!$all)
					{
						$sql .= ' ORDER BY '.$order_by.' LIMIT '.$start.','.$limit;
					}

				//echo $sql.' TOTOAL VIDEOS: '.$totalVideoCount;
				//echo $sql;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$record_count = $rs->PO_RecordCount();
				if($all)
					{
						return $record_count;
					}

				$this->videos_per_page=$limit;
				$videosPerRow = isset($this->CFG['admin']['videos'][$video_block.'_total_record'])?$this->CFG['admin']['videos'][$video_block.'_total_record']:$this->CFG['site']['index_rec_per_row_count'];
				$count = 0;
				$found = false;
				$this->no_of_row=1;
				$link_text=str_replace('{list}',$list_lang,$this->LANG['index_see_more_videos']);
				$allow_quick_links=(isLoggedIn() and $this->CFG['admin']['videos']['allow_quick_links'])?true:false;
				$this->allow_quick_links=$allow_quick_links;
				if ($record_count)
				    {
						$found = true;
						$this->all_video_url=$all_video_url;
						$this->link_text=$link_text;
						$thumbnail_folder = $this->CFG['media']['folder'].'/'.
											$this->CFG['admin']['videos']['folder'].'/'.
											$this->CFG['admin']['videos']['thumbnail_folder'].'/';

						$separator = ':&nbsp;';
						$tag = array();
						$relatedTags = array();
						$videoTags = array();
						$video_list_arr = array();
						$inc = 0;

						while($row = $rs->FetchRow())
						    {
								if(!isset($this->UserDetails[$row['user_id']]))
								      $this->getUserDetail('user_id',$row['user_id'], 'user_name');
								$user_name=$this->getUserDetail('user_id',$row['user_id'], 'user_name');

								if($user_name != '')
									{
										$name = $this->getUserDetail('user_id',$row['user_id'], 'user_name');

										$video_list_arr[$inc]['video_date_added'] = getTimeDiffernceFormat($row['video_date_added']);
										$video_list_arr[$inc]['video_last_view_date'] = getTimeDiffernceFormat($row['video_last_view_date']);
										$video_list_arr[$inc]['playing_time'] = $row['playing_time']?$row['playing_time']:'00:00';
										$video_list_arr[$inc]['open_tr']=false;
										if ($count%$videosPerRow==0)
										    {
											 $video_list_arr[$inc]['open_tr']=true;
											 $this->no_of_row++;
										    }
										$this->allow_quick_links=$allow_quick_links;
										$smartyObj->assign('allow_quick_links', $allow_quick_links);
										$video_list_arr[$inc]['video_url']=getUrl('viewvideo','?video_id='.$row['video_id'].'&title='.$this->changeTitle($row['video_title']), $row['video_id'].'/'.$this->changeTitle($row['video_title']).'/','','video');
									    $video_list_arr[$inc]['t_width'] = $row['t_width'];
										$video_list_arr[$inc]['t_height'] = $row['t_height'];
										if($row['video_id'])
										{

											$video_list_arr[$inc]['image_url'] = $row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id'],$row['file_name']).$this->CFG['admin']['videos']['thumb_name'].'.'.$this->CFG['video']['image']['extensions'];
											$video_list_arr[$inc]['video_disp'] = DISP_IMAGE($this->CFG['admin']['videos']['thumb_width'], $this->CFG['admin']['videos']['thumb_width']);
										}
										else
										{
											$video_list_arr[$inc]['image_url'] = '';
											$video_list_arr[$inc]['video_disp'] = '';
										}

										$video_list_arr[$inc]['video_title']=$row['video_title'];
										$row['video_caption']=$row['video_caption'];
										$video_list_arr[$inc]['record']=$row;
									    if (!in_array($row['user_id'], $userid_arr))
										$userid_arr[] = $row['user_id'];

										$tags= $this->_parse_tags($row['video_tags']);
										$video_list_arr[$inc]['tags']='';
										if ($tags)
										    {
										        $i = 0;
										        $tags_arr=array();
												foreach($tags as $key=>$value)
													{
														if($this->CFG['admin']['videos']['tags_count_list_page']==$i)
															break;
														$value = strtolower($value);

														if (!in_array($value, $tag) AND !in_array($value, $relatedTags))
															$relatedTags[] = $value;

														if (!in_array($value, $videoTags))
													        $videoTags[] = $value;

													    $tags_arr[$i]['tag_name']=$value;
													    $tags_arr[$i]['tag_url']=getUrl('videolist','?pg=videonew&tags='.$value, 'videonew/?tags='.$value);
														$i++;
													}
												$video_list_arr[$inc]['tags']=$tags_arr;

											 }

										$count++;
										$video_list_arr[$inc]['end_tr']=false;
										if ($count%$videosPerRow==0)
										    {
												$count = 0;
												$video_list_arr[$inc]['end_tr']=true;
										    }
									  $inc++;
									}
				    		}//while
				    	$this->videoblock_last_tr_close = false;
						if ($found and $count and $count<$videosPerRow)
						    {
					    		$this->videoblock_last_tr_close  = true;
				  	    		$this->video_per_row=$videosPerRow-$count;
					    	}
							$videoblock_next_css=(($totalVideoCount-1) > $start)?'clsNextActive next':'next';
							$videoblock_prev_css=(($start > 0))?'clsPreviousActive previous':'previous';
							$this->videoblock_next_css =$videoblock_next_css;
							$this->videoblock_prev_css =$videoblock_prev_css;
							$this->videoblock_next_link=0;
							$this->videoblock_prev_link=0;
							$this->video_block=$video_block;
							if(($totalVideoCount-1) > $start)
							{
							$this->videoblock_next_link=1;
							}
							if($start > 0)
							{
							$this->videoblock_prev_link=1;
							}
							 $this->no_of_row--;
					}
				else
					{
					   $video_list_arr=0;
					}
					if(!isAjaxPage())
					{
					?>
					<?php
						}
					$user_ids = implode(',', $userid_arr);
					$this->getMultiUserDetails($user_ids, $fields_list);

					//return $video_list_arr;
					$smartyObj->assign('LANG', $this->LANG);
					$smartyObj->assign('CFG', $this->CFG);
					$smartyObj->assign('myobj', $this);
					$smartyObj->assign('link_text', $link_text);
					$smartyObj->assign('start', $start);
					$smartyObj->assign('all_video_url', $all_video_url);
					$smartyObj->assign('video_list_arr', $video_list_arr);
					setTemplateFolder('general/','video');
					$smartyObj->display('videoListIndexBlock.tpl');
			}

		public function setClassForList()
			{
				if(!isAjaxPage() and chkAllowedModule(array('video')))
					{
						$pag_arr = array('newvideo', 'topratedvideo');
						foreach($pag_arr as $video_block)
							{
								if(!$this->chk_for_video_first_block)
									{
										$this->chk_for_video_first_block = $video_block;
									}
								$li = $video_block.'_li_class';
								$span = $video_block.'_span_class';
								$this->$li = ($this->chk_for_video_first_block==$video_block)?'clsActiveFirstLink':'';
								$this->$span = ($this->chk_for_video_first_block==$video_block)?'clsActiveVideoLinkRight':'';
								$this->chk_for_video_block_display = ($this->chk_for_video_first_block==$video_block)?'':'display:none;';
							}
					}
			}

		/**
		 * IndexPageVideoHandler::isThisRequestFromMe()
		 *
		 * @return
		 */
		public function isThisRequestFromMe()
			{
				return true;
				$equalReferer =  (isset($_SERVER['HTTP_REFERER']) AND strstr($_SERVER['HTTP_REFERER'], $_SERVER['PHP_SELF']));
				$matchedPort = (isset($_SERVER['REMOTE_ADDR']) AND isset($_SERVER['SERVER_ADDR']) AND ($_SERVER['REMOTE_ADDR']==$_SERVER['SERVER_ADDR']));
				return ($equalReferer OR $matchedPort);
			}
		/**
		 * IndexPageVideoHandler::getTotalChannel()
		 *
		 * @return
		 */
		public function getTotalChannel()
			{
				$sql = 'SELECT vc.video_category_id, vc.video_category_name '.
						'FROM '.$this->CFG['db']['tbl']['video_category'].' as vc, '.$this->CFG['db']['tbl']['video'].' as v '.
						'WHERE vc.video_category_id = v.video_category_id AND vc.parent_category_id=0 AND vc.video_category_status = \'Yes\' '.
						'GROUP BY vc.video_category_name '.
						'ORDER BY vc'.$this->fields_arr['order_by'].' ASC' ;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				    trigger_db_error($this->dbObj);
				return $rs->PO_RecordCount();
	       }


	/**
	 * IndexPageVideoHandler::getVideoDetail()
	 *
	 * @param mixed $video_category_id
	 * @return
	 */
	public function getVideoDetail($video_category_id)
		{
		   	 $default_cond = 'video_status=\'Ok\''.$this->getAdultQuery('v.').' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
							' video_access_type = \'Public\''.$this->getAdditionalQuery().')';

		   	$sql = 'SELECT v.user_id, video_id, video_title, video_caption, total_views, video_server_url, '.
						't_width, t_height,(rating_total/rating_count) as rating, '.
						'TIME_FORMAT(playing_time,\'%H:%i:%s\') as playing_time, TIMEDIFF(NOW(), v.date_added) as video_date_added, '.
						'TIMEDIFF(NOW(), last_view_date) as video_last_view_date, video_tags,is_external_embed_video,embed_video_image_ext,file_name '.
						'FROM '.$this->CFG['db']['tbl']['video'].' AS v JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id '.
						' , '.$this->CFG['db']['tbl']['users'].' AS u  '.
						' WHERE v.user_id = u.user_id AND u.usr_status = \'Ok\' AND video_category_id='.$this->dbObj->Param('video_category_id').' AND '.$default_cond.
						'ORDER BY video_id DESC LIMIT 1';

			 $stmt = $this->dbObj->Prepare($sql);
			 $rs = $this->dbObj->Execute($stmt,array($video_category_id));
				if (!$rs)
					trigger_db_error($this->dbObj);
			 $video_list_arr = array();
			 $fields_list = array('user_name', 'first_name', 'last_name');
			 $thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
			 $separator = ':&nbsp;';
			 $tag = array();
			 $relatedTags = array();
			 $videoTags = array();
			 if($row = $rs->FetchRow())
			   {
			   	  if(!isset($this->UserDetails[$row['user_id']]))
						$this->getUserDetail('user_id',$row['user_id'], 'user_name');

					$user_name=$this->getUserDetail('user_id',$row['user_id'], 'user_name');

					if($user_name != '')
						{
							$name = $this->getUserDetail('user_id',$row['user_id'], 'user_name');

							$video_list_arr['video_date_added'] = getTimeDiffernceFormat($row['video_date_added']);
							$video_list_arr['video_last_view_date'] = getTimeDiffernceFormat($row['video_last_view_date']);
							$video_list_arr['playing_time'] = $row['playing_time']?$row['playing_time']:'00:00';

							$video_list_arr['video_url']=getUrl('viewvideo','?video_id='.$row['video_id'].'&title='.$this->changeTitle($row['video_title']), $row['video_id'].'/'.$this->changeTitle($row['video_title']).'/','','video');
							$video_list_arr['image_url']=$row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id'],$row['file_name']).$this->CFG['admin']['videos']['thumb_name'].'.'.$this->CFG['video']['image']['extensions'];
							if (($row['is_external_embed_video'] == 'Yes' && $row['embed_video_image_ext'] == ''))
								{
			                    	$video_list_arr['image_url'] = $this->CFG['site']['url'].'video/design/templates/'.
																		$this->CFG['html']['template']['default'].'/root/images/'.
																			$this->CFG['html']['stylesheet']['screen']['default'].
																			'/no_image/noImageVideo_T.jpg';
			                    }
							$video_list_arr['video_title']=$row['video_title'];
							$video_list_arr['record']=$row;
							$video_list_arr['MemberProfileUrl']=getMemberProfileUrl($row['user_id'], $user_name);
							$video_list_arr['UserDetails_Name']=$user_name;
							$tags= $this->_parse_tags($row['video_tags']);
							$video_list_arr['tags']='';
							if ($tags)
							    {
							        $i = 0;
							        $tags_arr=array();
									foreach($tags as $key=>$value)
										{
											if($this->CFG['admin']['videos']['tags_count_list_page']==$i)
												break;
											$value = strtolower($value);

											if (!in_array($value, $tag) AND !in_array($value, $relatedTags))
												$relatedTags[] = $value;

											if (!in_array($value, $videoTags))
										        $videoTags[] = $value;

										    $tags_arr[$i]['tag_name']=$value;
										    $tags_arr[$i]['tag_url']=getUrl('videolist','?pg=videonew&tags='.$value, 'videonew/?tags='.$value);
											$i++;
										}
									$video_list_arr['tags']=$tags_arr;

								 }
						return $video_list_arr;
					}
			   }
			return false;
		}

	   /**
		 * IndexPageVideoHandler::getTotalVideoListPages()
		 * Function to get the total no of pages for the video carousel
		 *
		 * @param string $block_name
		 * @param int $limit no of records to be shown per page in the carousel,
		 * 				value can be varied / passed from tpl
		 * @return int total pages
		 */
		public function getTotalVideoListPages($block_name, $limit)
		{

            global $smartyObj;
			$default_cond = ' u.usr_status=\'Ok\' AND v.video_status=\'Ok\''.$this->getAdultQuery('v.').
							' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
							' v.video_access_type = \'Public\''.$this->getAdditionalQuery().')';

			$default_fields = ' COUNT(*) as total_video ';
			$list_lang='';
			$condition='';
			$link_text='';
			$this->video_block=$block_name;
			$order_by = '';
			$userid_arr = array();
			$fields_list = array('user_name', 'first_name', 'last_name');
			$global_limit=100;
			switch($block_name)
			{
				case 'recommendedvideo':
				$total_row = $this->CFG['admin']['videos']['total_no_of_row_record'];
				$record_per_row = $this->CFG['admin']['videos']['recommendedvideo_total_record'];
				//$limit = $total_row * $record_per_row;
				$condition = 'v.featured=\'Yes\' AND '.$default_cond;
				$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
					   ' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON v.user_id=u.user_id'. ' LEFT JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'.
					   ' WHERE '.$condition;
				$all_video_url = getUrl('videolist','?pg=videorecommended', 'videorecommended/','','video');
				$list_lang=$this->LANG['index_title_recommended_videos'];
				$order_by = 'video_id DESC';
				break;

				case 'topratedvideo':
				$total_row = $this->CFG['admin']['videos']['total_no_of_row_record'];
				$record_per_row = $this->CFG['admin']['videos']['topratedvideo_total_record'];
				//$limit = $total_row * $record_per_row;
				$condition = 'v.rating_total>0 AND v.allow_ratings=\'Yes\' AND '.$default_cond;
				$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
					   ' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON v.user_id=u.user_id'. ' LEFT JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'.
					   ' WHERE '.$condition;
				$all_video_url = getUrl('videolist','?pg=videotoprated', 'videotoprated/','','video');
				$list_lang=$this->LANG['index_title_top_rated_videos'];
				$order_by = 'rating DESC';
				break;

				case 'newvideo':
				$total_row = $this->CFG['admin']['videos']['total_no_of_row_record'];
				$record_per_row = $this->CFG['admin']['videos']['newvideo_total_record'];
				//$limit = $total_row * $record_per_row;
				$condition = $default_cond;
				$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'. ' LEFT JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'.
					   ' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON v.user_id=u.user_id'.
					   ' WHERE '.$condition;
				$all_video_url = getUrl('videolist','?pg=videonew', 'videonew/','','video');
				$list_lang = $this->LANG['index_title_new_videos'];
				$order_by = 'video_id DESC';
				break;

				case 'recentlyviewedvideo':

				$total_row=$this->CFG['admin']['videos']['total_no_of_row_record'];
				$record_per_row = $this->CFG['admin']['videos']['recentlyviewedvideo_total_record'];
				//$limit = $total_row * $record_per_row;
				$condition = $default_cond;
				$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
					   ' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON v.user_id=u.user_id'. ' LEFT JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'.
					   ' WHERE '.$condition;

				$all_video_url = getUrl('videolist','?pg=videomostrecentlyviewed', 'videomostrecentlyviewed/','','video');
				$list_lang=$this->LANG['index_title_recoentlyviewed_videos'];
				$order_by = 'last_view_date DESC';
				break;
			}

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
		public function populateCarousalVideoBlock($case, $page_no=1, $rec_per_page=4)
			{

				global $smartyObj;
				$populateCarousalVideoBlock_arr['row'] = array();
				$start = ($page_no -1) * $rec_per_page; // start = (pageno -1) * rec per page

				$default_cond = 'u.usr_status=\'Ok\' AND v.video_status=\'Ok\''.$this->getAdultQuery('v.').
								' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
								' v.video_access_type = \'Public\''.$this->getAdditionalQuery().')';

				$default_fields = 'v.user_id, v.video_id, v.video_title, v.video_caption, v.total_views, v.video_server_url,'.
								   ' v.t_width, v.t_height,v.s_width, v.s_height,(v.rating_total/v.rating_count) as rating,'.
								   ' TIME_FORMAT(v.playing_time,\'%H:%i:%s\') as playing_time, TIMEDIFF(NOW(), v.date_added) as video_date_added,'.
								   ' TIMEDIFF(NOW(), v.last_view_date) as video_last_view_date, v.video_tags, v.is_external_embed_video, v.embed_video_image_ext,file_name';

					switch($case)
					{
						case 'recommendedvideo':
						   	$total_row = $this->CFG['admin']['videos']['total_no_of_row_record'];
						   	$record_per_row = $this->CFG['admin']['videos']['recommendedvideo_total_record'];
							$limit = $total_row * $record_per_row;
							$condition = 'v.featured=\'Yes\' AND '.$default_cond;
							$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
									' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON v.user_id=u.user_id'. ' LEFT JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'.
					   				' WHERE '.$condition;
							$all_video_url = getUrl('videolist','?pg=videorecommended', 'videorecommended/','','video');
							$list_lang=$this->LANG['index_title_recommended_videos'];
							$order_by = 'video_id DESC';
							break;

						case 'topratedvideo':
						   	$total_row = $this->CFG['admin']['videos']['total_no_of_row_record'];
						   	$record_per_row = $this->CFG['admin']['videos']['topratedvideo_total_record'];
							$limit = $total_row * $record_per_row;
							$condition = 'v.rating_total>0 AND v.allow_ratings=\'Yes\' AND '.$default_cond;
							$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
									' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON v.user_id=u.user_id'. ' LEFT JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'.
					   				' WHERE '.$condition;
							$all_video_url = getUrl('videolist','?pg=videotoprated', 'videotoprated/','','video');
							$list_lang=$this->LANG['index_title_top_rated_videos'];
							$order_by = 'rating DESC';
							break;

						case 'newvideo':
						   	$total_row = $this->CFG['admin']['videos']['total_no_of_row_record'];
						   	$record_per_row = $this->CFG['admin']['videos']['newvideo_total_record'];
							$limit = $total_row * $record_per_row;
							$condition = $default_cond;
							$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'. ' LEFT JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'.
									' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON v.user_id=u.user_id'.
					   				' WHERE '.$condition;
							$all_video_url = getUrl('videolist','?pg=videonew', 'videonew/','','video');
							$list_lang = $this->LANG['index_title_new_videos'];
							$order_by = 'video_id DESC';
							break;

						case 'recentlyviewedvideo':

						   	$total_row=$this->CFG['admin']['videos']['total_no_of_row_record'];
						   	$record_per_row = $this->CFG['admin']['videos']['recentlyviewedvideo_total_record'];
							$limit = $total_row * $record_per_row;
							$condition = $default_cond;
							$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
									' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON v.user_id=u.user_id'. ' LEFT JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' ON video_file_id = thumb_name_id'.
					   				' WHERE '.$condition;

							$all_video_url = getUrl('videolist','?pg=videomostrecentlyviewed', 'videomostrecentlyviewed/','','video');
							$list_lang=$this->LANG['index_title_recoentlyviewed_videos'];
							$order_by = 'last_view_date DESC';
							break;
					}

				$sql .= ' ORDER BY '.$order_by.' LIMIT '.$start.', '.$rec_per_page;
				//echo $sql;

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

						if(!isset($this->UserDetails[$video_detail['user_id']]))
									$this->getUserDetail('user_id',$video_detail['user_id'], 'user_name');

						$user_name=$this->getUserDetail('user_id',$video_detail['user_id'], 'user_name');
						$populateCarousalVideoBlock_arr['row'][$inc]['user_url'] = getMemberProfileUrl($video_detail['user_id'], $user_name);
						$populateCarousalVideoBlock_arr['row'][$inc]['user_name']=$this->getUserDetail('user_id',$video_detail['user_id'], 'user_name');

					    $populateCarousalVideoBlock_arr['row'][$inc]['video_url'] = getUrl('viewvideo','?video_id='.$video_detail['video_id'].
																'&title='.$this->changeTitle($video_detail['video_title']),
																	$video_detail['video_id'].'/'.$this->changeTitle($video_detail['video_title']).'/','','video');

						$populateCarousalVideoBlock_arr['row'][$inc]['t_width'] = $video_detail['t_width'];
						$populateCarousalVideoBlock_arr['row'][$inc]['t_height'] = $video_detail['t_height'];
						$populateCarousalVideoBlock_arr['row'][$inc]['rating'] = $video_detail['rating'];
						if($video_detail['video_id'])
						{

							$populateCarousalVideoBlock_arr['row'][$inc]['image_url'] = $video_detail['video_server_url'].$thumbnail_folder.getVideoImageName($video_detail['video_id'],$video_detail['file_name']).$this->CFG['admin']['videos']['thumb_name'].'.'.$this->CFG['video']['image']['extensions'];
							$populateCarousalVideoBlock_arr['row'][$inc]['video_disp'] = DISP_IMAGE($this->CFG['admin']['videos']['thumb_width'], $this->CFG['admin']['videos']['thumb_width']);
						}
						else
						{
							$populateCarousalVideoBlock_arr['row'][$inc]['image_url'] = '';
							$populateCarousalVideoBlock_arr['row'][$inc]['video_disp'] = '';
						}
						$populateCarousalVideoBlock_arr['row'][$inc]['div_onmouseOverText'] = 'onmouseover="info_class=\'clsInfo\';showInfo(this)" onmouseout="hideInfo(this);"';
						$populateCarousalVideoBlock_arr['row'][$inc]['video_title']=$video_detail['video_title'];
						$populateCarousalVideoBlock_arr['row'][$inc]['total_views'] = $video_detail['total_views'];
						//$video_detail['video_date_added']=getTimeDiffernceFormat($video_detail['video_date_added']);
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
				$smartyObj->assign('CFG',$this->CFG);
				$smartyObj->assign('populateCarousalVideoBlock_arr', $populateCarousalVideoBlock_arr);
		    	$smartyObj->assign('video_block_record_count', $video_block_record_count);//is record found
		    	$smartyObj->assign('record_count', $start);
		    	$smartyObj->assign('block_type', $case);
				setTemplateFolder('general/','video');
				$smartyObj->display('videoListIndexBlock.tpl');
			}

		/**
		 * IndexPageVideoHandler::getTotalVideoChannelListCount()
		 * Function to get the total no of pages for the category carousel
		 *
		 * @return
		 * @access 	public
		 */
		public function getTotalVideoChannelListCount($block_name, $limit)
		{

			global $smartyObj;
			$start = $this->fields_arr['start'];
			$video_detail_arr = array();
			$total_row=$this->CFG['admin']['videos']['videochannel_total_row'];
			$record_per_row=$this->CFG['admin']['videos']['videochannel_total_record'];
			//$limit = $total_row * $record_per_row;
			$global_limit=100;

			$default_cond = '(u.user_id = v.user_id'.
						' AND u.usr_status=\'Ok\') AND '.
						' v.video_status=\'Ok\''.$this->getAdultQuery('v.').
						' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
						' video_access_type = \'Public\''
						.$this->getAdditionalQuery().')';


			$sql = 'SELECT count(*) as total_category_count FROM '.$this->CFG['db']['tbl']['video_category'].' as vc, '.
					$this->CFG['db']['tbl']['video'].' as v, '.
					$this->CFG['db']['tbl']['users'].' AS u'.
					' WHERE '.
					' vc.parent_category_id=0 AND vc.video_category_status = \'Yes\''.
					' AND '.$default_cond.' GROUP BY vc.video_category_name'. ' LIMIT ' . $global_limit;

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
			trigger_db_error($this->dbObj);
			if($row = $rs->FetchRow())
			{
				$record_count = $rs->PO_RecordCount();
				$total_pages = ceil($record_count/$limit);
				return $total_pages;
			}
			else
			{
				return 0;
			}
		}

		/**
		 * IndexPageVideoHandler::populateVideoChannelCarousal()
		 * Function To display category list
		 *
		 * @return
		 * @access 	public
		 */
		public function populateVideoChannelCarousal($case, $page_no=1, $rec_per_page=4)
		{

			global $smartyObj;
			$start = $this->fields_arr['start'];
			$video_detail_arr = array();
			$start = ($page_no -1) * $rec_per_page;
			$thumbnail_folder = $this->CFG['media']['folder'].'/'.
									$this->CFG['admin']['videos']['folder'].'/'.
									$this->CFG['admin']['videos']['thumbnail_folder'].'/';

			switch($case)
			{
				case 'video_category':
				$total_row=$this->CFG['admin']['videos']['videochannel_total_row'];
				$record_per_row=$this->CFG['admin']['videos']['videochannel_total_record'];
				$limit = $total_row * $record_per_row;

				$default_cond = '(u.user_id = v.user_id'.
								' AND u.usr_status=\'Ok\') AND '.
								' v.video_status=\'Ok\''.$this->getAdultQuery('v.').
								' AND ( '.
								' video_access_type = \'Public\''
								.')';

                if($this->CFG['admin']['videos']['video_category_list_priority'])
				$order_by =' ORDER BY priority ASC';
				else
				$order_by =' ORDER BY total_video ASC';

				$sql = 'SELECT vc.video_category_id, vc.video_category_name,v.video_id,v.video_server_url,priority,'.
						' TIME_FORMAT(v.playing_time,\'%H:%i:%s\') as playing_time, count( v.video_category_id ) AS total_video, '.
						' v.video_title,v.t_width,v.t_height FROM '.$this->CFG['db']['tbl']['video_category'].' as vc, '.
						$this->CFG['db']['tbl']['video'].' as v, '.
						$this->CFG['db']['tbl']['users'].' AS u'.
						' WHERE '.
						' vc.parent_category_id=0 AND vc.video_category_status = \'Yes\''.
						' AND '.$default_cond.'GROUP BY vc.video_category_name'.$order_by;

			}

			$sql .= ' LIMIT '.$start.', '.$rec_per_page;



			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
				trigger_db_error($this->dbObj);
			$record_count = $rs->PO_RecordCount();
			$video_detail_arr = array();
			$inc = 0;
			$videosPerRow = isset($this->CFG['admin']['videos']['videochannel_total_record'])?$this->CFG['admin']['videos']['videochannel_total_record']:$this->CFG['site']['index_rec_per_row_count'];
			$count = 0;
			$found = false;
			if ($rs->PO_RecordCount()> 0)
			{
				while($row = $rs->FetchRow())
				{

					$video_detail_arr[$inc]['channel_url'] = getUrl('videolist','?pg=videonew&cid='.$row['video_category_id'], 'videonew/?cid='.$row['video_category_id'],'','video');
					$video_detail_arr[$inc]['video_category_name']=$row['video_category_name'];
					$video_detail_arr[$inc]['total_video_count']=$this->getTotalCategoryCount($row['video_category_id']);
					$video_detail_arr[$inc]['playing_time']=$row['playing_time'];
					$video_detail_arr[$inc]['video_category_id']=$row['video_category_id'];
					/*if(!$video_detail_arr[$inc]['video_detail'] = $this->getVideoDetail($row['video_category_id']))
					{
						$video_detail_arr[$inc]['video_detail']['image_url'] = $this->CFG['site']['url'].'video/design/templates/'.
																	$this->CFG['html']['template']['default'].'/root/images/'.
																		$this->CFG['html']['stylesheet']['screen']['default'].
																			'/no_image/noImageVideo_T.jpg';

						$video_detail_arr[$inc]['video_detail']['video_title']='No Video';
						$video_detail_arr[$inc]['video_detail']['total_video']=0;
						$video_detail_arr[$inc]['video_detail']['video_url']='';
					}*/
					$count++;
					$inc++;
				}
				$smartyObj->assign('LANG', $this->LANG);
				$smartyObj->assign('CFG', $this->CFG);
				$video_detail_arr;
			}
			else
			{
				$video_detail_arr=0;
			}
			if($inc>1)
			$channel_block_record_count= $inc - 1;
			else
			$channel_block_record_count= $inc;
			$this->video_channels_category = $video_detail_arr;
			$smartyObj->assign('videoIndexObj_category',$this);
			$smartyObj->assign('channel_block_record_count', $channel_block_record_count);//is record found
			setTemplateFolder('general/','video');
			$smartyObj->display('populateVideoChannelCarousal.tpl');
		}

		public function getTotalCategoryCount($video_category_id)
		{


		 $default_cond = '(u.user_id = v.user_id'.
							 ' AND u.usr_status=\'Ok\') AND '.
							 ' v.video_status=\'Ok\''.$this->getAdultQuery('v.').
							 ' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
							 ' video_access_type = \'Public\''.$this->getAdditionalQuery().')';

			$sql = 'SELECT v.video_category_id, COUNT(v.video_id)'.
					' AS total_videos FROM '.$this->CFG['db']['tbl']['video'].
					' AS v, '.$this->CFG['db']['tbl']['users'].' AS u'.
					' WHERE v.video_status=\'Ok\' AND v.video_category_id='.$this->dbObj->Param('video_category_id').' AND '
					.$default_cond.
					' GROUP BY video_category_id HAVING total_videos>0';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt,array($video_category_id));
			if (!$rs)
		  		trigger_db_error($this->dbObj);

			if($row = $rs->FetchRow())
			{
				$record_count = $row['total_videos'];
				return $record_count;
			}
			else
			{
				return 0;
			}
		}
        /**
		 * IndexPageVideoHandler::populateCarouselCategoryVideo()
		 * Function To display video List for particular category id.
		 *
		 * @return
		 * @access 	public
		 */
		public function populateCarouselCategoryVideo($video_category_id)
		{
			global $smartyObj;
			$start = $this->getFormField('start');
			$video_detail_category_arr = array();
			$total_row=$this->CFG['admin']['videos']['videochannel_total_row'];
			$record_per_row=$this->CFG['admin']['videos']['videochannel_total_record'];
			$limit = $total_row * $record_per_row;
			$thumbnail_folder = $this->CFG['media']['folder'].'/'.
								$this->CFG['admin']['videos']['folder'].'/'.
								$this->CFG['admin']['videos']['thumbnail_folder'].'/';

			$sql = 'SELECT v.video_category_id, v.video_id, TIME_FORMAT(v.playing_time,\'%H:%i:%s\') as playing_time, '.
					' video_server_url,video_title,v.t_width,v.t_height FROM '.$this->CFG['db']['tbl']['video'].' as v '.
					' WHERE v.video_status=\'Ok\' AND v.video_category_id= '.$video_category_id;
			$sql .= ' LIMIT 0,'.$record_per_row;

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
				trigger_db_error($this->dbObj);
			$video_detail_category_arr = array();
			$inc = 0;
			$videosPerRow = isset($this->CFG['admin']['videos']['videochannel_total_record'])?$this->CFG['admin']['videos']['videochannel_total_record']:$this->CFG['site']['index_rec_per_row_count'];
			$count = 0;
			$found = false;

			if ($rs->PO_RecordCount()> 0)
			{
				while($row = $rs->FetchRow())
				{

					$video_detail_category_arr[$inc]['channel_url'] = getUrl('viewvideo','?video_id='.$row['video_id'].'&title='.$row['video_title'], $row['video_id'].'/'.$row['video_title'].'/', '', 'video');
					$video_detail_category_arr[$inc]['video_id']=$row['video_id'];
					$video_detail_category_arr[$inc]['video_title']=$row['video_title'];
					$video_detail_category_arr[$inc]['video_category_id']=$row['video_category_id'];
					$video_detail_category_arr[$inc]['video_total_count']=$row['video_category_id'];
                    $video_detail_category_arr[$inc]['playing_time']=$row['playing_time'];
                    $video_detail_category_arr[$inc]['t_width']=$row['t_width'];
                    $video_detail_category_arr[$inc]['t_height']=$row['t_height'];
					if($row['video_id'])
					{

						$video_detail_category_arr[$inc]['image_url'] = $row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id']).$this->CFG['admin']['videos']['thumb_name'].'.'.$this->CFG['video']['image']['extensions'];
						$video_detail_category_arr[$inc]['video_disp'] = DISP_IMAGE($this->CFG['admin']['videos']['thumb_width'], $this->CFG['admin']['videos']['thumb_width']);
					}
					else
					{
						$video_detail_category_arr[$inc]['image_url'] = '';
						$video_detail_category_arr[$inc]['video_disp'] = '';
					}
					if(!$video_detail_category_arr[$inc]['video_detail'] = $this->getVideoDetail($row['video_category_id']))
					{
						$video_detail_category_arr[$inc]['video_detail']['image_url'] = $this->CFG['site']['url'].'video/design/templates/'.
													$this->CFG['html']['template']['default'].'/root/images/'.
														$this->CFG['html']['stylesheet']['screen']['default'].
															'/no_image/noImageVideo_T.jpg';

						$video_detail_category_arr[$inc]['video_detail']['video_title']='No Video';
						$video_detail_category_arr[$inc]['video_detail']['total_video']=0;
						$video_detail_category_arr[$inc]['video_detail']['video_url']='';
					}

					$count++;
					$inc++;
				}
				$smartyObj->assign('LANG', $this->LANG);
				$smartyObj->assign('CFG', $this->CFG);
				$video_detail_category_arr;
			}
			else
			{
				$video_detail_category_arr=0;
			}
			$smartyObj->assign('video_detail_category_arr',$video_detail_category_arr);
			setTemplateFolder('general/','video');
			$smartyObj->display('indexVideoChannel.tpl');
		}
		public function checkEmbedPlayer($video_id)
		{

			$sql = 'SELECT is_external_embed_video FROM '
			       .$this->CFG['db']['tbl']['video'].
			       ' AS v WHERE v.video_id='
				   .$this->dbObj->Param('video_id');


			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt,array($video_id));
			if (!$rs)
		  		trigger_db_error($this->dbObj);
			if($row = $rs->FetchRow())
			{
                if($row['is_external_embed_video']=='Yes')
                return true;
			}
			else
			{
                return 0;
			}
		}
		public function displayEmbededVideo($embed_code)
		{
			$patterns_width = '/width=&quot;([0-9]+)&quot;/';
			$patterns_height = '/height=&quot;([0-9]+)&quot;/';
			$replacements_width= 'width=280';
			$replacements_height= 'height=240';
			$embed_code=preg_replace($patterns_width, $replacements_width, $embed_code);
			$embed_code=preg_replace($patterns_height, $replacements_height, $embed_code);
			echo html_entity_decode($embed_code);
		}
		public function populateFeaturedVideoPlayers($video_id)
		{
            global $smartyObj;
			$this->setFormField('video_id',$video_id);
			$smartyObj->assign('videoIndexObj', $this);
			setTemplateFolder('general/','video');
			$smartyObj->display('populateFeaturedVideoPlayers.tpl');
		}
}

//-------------------- Code begins -------------->>>>>//
$videoIndex = new IndexPageVideoHandler();
//Video catagory List order by Priority on / off features
if($CFG['admin']['videos']['video_category_list_priority'])
	$videoIndex->setFormField('order_by', 'priority');
else
	$videoIndex->setFormField('order_by', 'video_category_name');
$total_video_count = $CFG['admin']['videos']['videochannel_total_row']
						* $CFG['admin']['videos']['videochannel_total_record'];

$videoIndex->setFormField('start', 0);
$videoIndex->setFormField('total_video_count', $total_video_count);
$videoIndex->setFormField('block', 'newvideo');
$videoIndex->setFormField('play_list','0');

$videoIndex->setFormField('showtab', '');
$videoIndex->setFormField('limit', 0);

$videoIndex->setFormField('block_video', '');
$videoIndex->setFormField('video_limit', 0);
$videoIndex->setFormField('start_video', 0);
$videoIndex->setFormField('show_catgeroy', '');
$videoIndex->setFormField('reload_video_player', '');
$videoIndex->setFormField('video_id', '');

$videoIndex->video_detail_category_arr = array();
$smartyObj->assign('video_detail_category_arr', $videoIndex->video_detail_category_arr);


$LANG['add_to_quick_links'] = '<img src="'.$CFG['site']['video_url'].'design/templates/'.
							$CFG['html']['template']['default'].'/root/images/'.
							$CFG['html']['stylesheet']['screen']['default'].'/icon-addvideo_added.gif" />';
$LANG['add_to_quick_links_added'] = '<a><img src="'.$CFG['site']['video_url'].'design/templates/'.
									$CFG['html']['template']['default'].'/root/images/'.
									$CFG['html']['stylesheet']['screen']['default'].'/icon-addvideo.gif" /></a>';
$smartyObj->assign('LANG',$LANG);
$smartyObj->assign('videoIndexObj',$videoIndex);
$videoIndex->sanitizeFormInputs($_REQUEST);
$smartyObj->assign('myobj',$videoIndex);
$videoIndex->setClassForList();

if(!isAjaxPage() && !$videoIndex->getFormField('showtab') && !$videoIndex->getFormField('show_catgeroy'))
	{
		if($index_block_settings_arr['RandomVideo'] == 'mainblock')
			{

				$videoIndex->getrandomVideo_arr=$videoIndex->getRandVideo();

				//print_r($videoIndex->getrandomVideo_arr);

				if(!$videoIndex->getrandomVideo_arr)
					{
						$videoIndex->randFirstTitle=$LANG['index_msg_no_top_rated_videos'];
						$randFirstId=0;
					}
				else
					{

						$randFirstId=$videoIndex->getrandomVideo_arr[0]['record']['video_id'];
						$videoIndex->randFirstTitle = stripslashes($videoIndex->getrandomVideo_arr[0]['video_title_full']);
						$videoIndex->randVideoAdded = stripslashes($videoIndex->getrandomVideo_arr[0]['video_last_view_date']);
						$videoIndex->randVideoRating = round($videoIndex->getrandomVideo_arr[0]['record']['rating']);
						$videoIndex->randVideoTotalViews = $videoIndex->getrandomVideo_arr[0]['record']['total_views'];
						$videoIndex->randVideoCaption = addslashes($videoIndex->getrandomVideo_arr[0]['record']['video_caption']);

						$videoIndex->randVideoTotalComments = $videoIndex->getrandomVideo_arr[0]['record']['total_comments'];
						$videoIndex->randUserName =$videoIndex->getUserDetail('user_id',$videoIndex->getrandomVideo_arr[0]['record']['user_id'], 'user_name');

						$videoIndex->randUserNameLink =	getMemberProfileUrl($videoIndex->getrandomVideo_arr[0]['record']['user_id'], $videoIndex->randUserName);


					//	videoIndex->randUserName Link=  getMemberProfileUrl($videoIndex->getrandomVideo_arr[0]['record']['user_id'], $videoIndex->randUserName);
					//	echo "videoIndex->randUserName Link", $videoIndex->randUserName Link;
						$videoIndex->video_external_embed_code =$videoIndex->getrandomVideo_arr[0]['record']['video_external_embed_code'];
						$videoIndex->main_player_video_id = $videoIndex->getrandomVideo_arr[0]['record']['video_id'];
						$videoIndex->videoUrl = getUrl('viewvideo','?video_id='.$videoIndex->getrandomVideo_arr[0]['record']['video_id'].'&amp;title='.$videoIndex->changeTitle($videoIndex->getrandomVideo_arr[0]['video_title_full']), $videoIndex->getrandomVideo_arr[0]['record']['video_id'].'/'.$videoIndex->changeTitle($videoIndex->getrandomVideo_arr[0]['video_title_full']).'/','','video');
					}
				$videoIndex->setFormField('video_id',$randFirstId);
			}
	}

if($videoIndex->getFormField('showtab')!= '' && !$videoIndex->getFormField('show_catgeroy'))
{
	$videoIndex->total_video_list_pages = $videoIndex->getTotalVideoListPages($videoIndex->getFormField('showtab'), $videoIndex->getFormField('limit'));
	?>
	<script language="javascript">
	total_video_list_pages = '<?php echo $videoIndex->getTotalVideoListPages($videoIndex->getFormField('showtab'), $videoIndex->getFormField('limit')); ?>';
	</script>
	<?php
	$smartyObj->assign('total_video_list_pages', $videoIndex->total_video_list_pages);
	$smartyObj->assign('showtab', $videoIndex->getFormField('showtab'));
	setTemplateFolder('general/', 'video');
	$smartyObj->display('indexVideoCarouselTab.tpl');
	exit;
}

if($videoIndex->getFormField('block')!= '')
{
	$videoIndex->populateCarousalVideoBlock($videoIndex->getFormField('block'), $videoIndex->getFormField('start'), $videoIndex->getFormField('limit'));
}
if($videoIndex->getFormField('show_catgeroy')!= '')
{
	$videoIndex->total_channel_list_page = $videoIndex->getTotalVideoChannelListCount($videoIndex->getFormField('show_catgeroy'), $videoIndex->getFormField('video_limit'));
?>
<script language="javascript">
total_channel_list_page = '<?php echo $videoIndex->getTotalVideoChannelListCount($videoIndex->getFormField('showtab'), $videoIndex->getFormField('video_limit')); ?>';
if(total_channel_list_page==0)
{
	$Jq('#video_category_no_records').css('display', 'block');
}
</script>
<?php
	$smartyObj->assign('total_channel_list_page', $videoIndex->total_channel_list_page);
	$smartyObj->assign('show_catgeroy', $videoIndex->getFormField('show_catgeroy'));
	setTemplateFolder('general/', 'video');
	$smartyObj->display('indexVideoChannelCarouselTab.tpl');
	exit;
}
if($videoIndex->getFormField('block_video')!= '')
{
	$videoIndex->populateVideoChannelCarousal($videoIndex->getFormField('block_video'), $videoIndex->getFormField('start_video'), $videoIndex->getFormField('video_limit'));
}
/*if(isAjaxPage() or $videoIndex->isFormPOSTed($_POST, 'block'))
	{

       $videoIndex->includeAjaxHeaderSessionCheck();
		switch($videoIndex->getFormField('block'))
			{
				case 'videochannel';
					$videoIndex->getVideoChannel();
					break;

				default:
					//$videoIndex->getVideoIndexBlock($videoIndex->getFormField('block'));
			}
		$videoIndex->includeAjaxFooter();
		exit;
	}
*/
//Video
//<<<<--------------------Lastly Watched Videos block code start ----------------------------//
if(!isAjaxPage())
	{
?>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
<?php

	$videos_folder = $CFG['media']['folder'].'/'.$CFG['admin']['videos']['folder'].'/';
	$videoIndex->recentvideo_flv_player_url = $CFG['site']['url'].'files/flash/video/recentViewsPlayList.swf';
	$videoIndex->recentvideo_configXmlcode_url = $CFG['site']['video_url'].'videoRecentViewedXmlCode.php?';
	$video_list_show=($videoIndex->isWatchedVideo() and chkAllowedModule(array('video')));
	$videoIndex->video_list_show=$video_list_show;
	if($video_list_show)
		{
?>
	<script language="javascript">
		function showEffectsInnerVideos()
			{
<?php
				$duration=1.0;
				for($videos_count=1;$videos_count<=$CFG['admin']['videos']['recent_videos_play_list_counts']; $videos_count++)
					{
?>
				Effect.Grow('innnerVideoList_<?php echo $videos_count; ?>', {duration:<?php echo $duration ?>, direction: 'bottom-left'});
<?php
						$duration=$duration+.3;
					}

?>
			}
	</script>

<?php
		}
if($video_list_show)
	{
?>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/lib/scriptaculous.js?load=effects"></script>

<?php
    }
//<<<<--------------------Lastly Watched Videos block  code End --------------//
}

if(isAjaxPage())
{
		if($videoIndex->getFormField('reload_video_player')== '1')
		{
			$videoIndex->getrandomVideo_arr=$videoIndex->getRandVideo();
			if(!$videoIndex->getrandomVideo_arr)
			{
				$videoIndex->randFirstTitle=$LANG['index_msg_no_top_rated_videos'];
				$randFirstId=0;
			}
			else
			{
				$randFirstId=$videoIndex->getrandomVideo_arr[0]['record']['video_id'];
				$videoIndex->randFirstTitle = stripslashes($videoIndex->getrandomVideo_arr[0]['video_title_full']);
				$videoIndex->randVideoAdded = stripslashes($videoIndex->getrandomVideo_arr[0]['video_last_view_date']);
				$videoIndex->randVideoRating = round($videoIndex->getrandomVideo_arr[0]['record']['rating']);
				$videoIndex->randVideoTotalViews = $videoIndex->getrandomVideo_arr[0]['record']['total_views'];
				$videoIndex->randVideoCaption = addslashes($videoIndex->getrandomVideo_arr[0]['record']['video_caption']);

				$videoIndex->randVideoTotalComments = $videoIndex->getrandomVideo_arr[0]['record']['total_comments'];
				$videoIndex->randUserName =$videoIndex->getUserDetail('user_id',$videoIndex->getrandomVideo_arr[0]['record']['user_id'], 'user_name');
				$videoIndex->video_external_embed_code =$videoIndex->getrandomVideo_arr[0]['record']['video_external_embed_code'];
				$videoIndex->main_player_video_id = $videoIndex->getrandomVideo_arr[0]['record']['video_id'];
			}
		        $videoIndex->populateFeaturedVideoPlayers($videoIndex->getFormField('video_id'));
		}
}

if(!isAjaxPage())
	{
//<<<<--------------------Random Videos block  code start --------------//

//$videoIndex->randomVideo_arr=$videoIndex->getRandVideo();
if(!isAjaxPage())
{
?>
<script type="text/javascript">
function getMoreInfoBlockList(video_caption, video_id)
{

	$Jq('#video_caption').html(video_caption);
	var url = '<?php echo $CFG['site']['video_url'].'indexVideoBlock.php';?>';
	jquery_ajax(url, 'reload_video_player=1&video_id='+video_id, 'populateVideoPlayer');
}
function populateVideoPlayer(data)
{
	//chkExtenalEmbededHeightAndWidth();
	$Jq('#clsVideoPlayer').html(data);
}
function playThisVideo(mem_URL, video_URL, video_id,video_title,date_added,rating,views,total_comments,user_name)
{

	var url = '<?php echo $CFG['site']['video_url'].'indexRandVideoXmlCode.php';?>';

	var rate_res = '';
	var rating_total = '<?php echo $CFG['admin']['total_rating']; ?>';
	if(rating == 0 || rating == '') rating =0;

	for(i=1;i<=rating;i++)
	{
		rate_res +='<img src="<?php echo $CFG['site']['url'].'video/design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/icon-viewvideoratehover.gif'; ?>"   />';
	}
	for(i=rating;i<rating_total;i++)
	{
		rate_res +='<img src="<?php echo $CFG['site']['url'].'video/design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/icon-videorate.gif'; ?>"   />';
	}


	var pars = '?ajax_page=true&video_id='+video_id;
	var path=url+pars;
	var method_type = 'post';
	video_URL='<a href='+video_URL+'>VIEW</a>';
	mem_URL = '<a href='+mem_URL+'>'+user_name+'</a>';
	$Jq('#video_url_link').html(video_URL);
	$Jq('#random_title').html(video_title);
	$Jq('#date_added').html(date_added);
	$Jq('#rating').html(rating);
	$Jq('#views').html(views);
	$Jq('#total_comments').html(total_comments);
	$Jq('#rating_image').html(rate_res);
	//$Jq('#user_name').html(user_name);
	$Jq('#user_name').html(mem_URL);
	populateRandVideoRequest(path, pars, method_type);
}
function populateRandVideoRequest(url, pars, method_type)
{
	$Jq.ajax({
		type: "GET",
		url: url,
		data: pars,
		success: populateRandVideoResponse
	 });
}
function populateRandVideoResponse(originalRequest)
{
	data = unescape(originalRequest);
}
function playThisSideBarVideo(video_id,video_title)
{

    var url = '<?php echo $CFG['site']['video_url'].'indexRandVideoXmlCode.php';?>';
	var pars = '?ajax_page=true&video_id='+video_id+'&small_video=yes';
	var path=url+pars;
	var method_type = 'post';
	$Jq('#random_title').html(video_title);
	populateSideBarRandVideoRequest(path, pars, method_type);
}

function populateSideBarRandVideoRequest(url, pars, method_type)
{

	$Jq.ajax({
		type: "GET",
		url: url,
		data: pars,
		success: populateSideBarRandVideoResponse
	 });
}
function populateSideBarRandVideoResponse(originalRequest)
{
	data = unescape(originalRequest);
}
</script>

<script type="text/javascript">
	var playerActualHeight =240;
	var playerActualWidth=280;
	function chkValidHeightAndWidth(ele)
		{

			var flash_content_div_width = $Jq('#flashcontent3').css('width');
			var flash_content_div_height = $Jq('#flashcontent3').css('height');

			height=parseInt($Jq(ele).css('height'));
			width=parseInt($Jq(ele).css('width'));
			if((height>playerActualHeight || width >playerActualWidth))
				{
					$Jq(ele).css('height', playerActualHeight);
					$Jq(ele).css('width', playerActualWidth);
				}
		}
	function chkExtenalEmbededHeightAndWidth()
	  {

		var embeded_ele=$Jq('#flashcontent3 embed').length;
		if(embeded_ele)
			{
				$Jq('#flashcontent3 embed').each(function(ele)
					{
					   	chkValidHeightAndWidth($Jq(this));
					});
			}


		object_ele=$Jq('#flashcontent3 object').length;
		if(object_ele)
			{

				$Jq('#flashcontent3 object').each(function(ele)
					{
					   	chkValidHeightAndWidth($Jq(this));
					});

			}
	  }

var user_agent = navigator.userAgent.toLowerCase();
if(user_agent.indexOf("msie") != -1)
	{
		// FIX for IE 6 since sometimes dom:loaded not working
		$Jq(window).load(function(){
			chkExtenalEmbededHeightAndWidth();
		});
	}
else
	{
		$Jq(document).ready( function(){
			chkExtenalEmbededHeightAndWidth();
		});
	}
</script>


<?php
}
//<<<<--------------------Random Videos block  code End --------------//
}
//<<<<--------------------video block javascript start ----------------------------//
?>
<script type="text/javascript">
var popup_info_left_position = 640;
var popup_info_top_position = 510;
var music_index_ajax_url = "<?php echo $CFG['site']['video_url'].'indexVideoBlock.php';?>";
</script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/lib/jQuery_plugins/galleriffic-2.0/jquery.galleriffic.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/lib/jQuery_plugins/galleriffic-2.0/jquery.opacityrollover.js"></script>

<script type="text/javascript" src="<?php echo $CFG['site']['video_url'];?>js/index.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo $CFG['site']['video_url'].'js/thumbHover.js'?>">
</script>
<?php
//<<<<--------------------video block javascript End ----------------------------//
//assign smarty object
?>