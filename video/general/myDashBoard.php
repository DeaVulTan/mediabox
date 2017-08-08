<?php
/**
* >>> mature warning functionalites provided below
*	1. If admin set "Display adult content to members" as "No"
*		>>> adult user can view the content
*		>>> non adult user can not view the content
*		>>> adult user can turn off / turn on the mature warning
*
*	2. If admin set "Display adult content to members" as "Yes"
*		>>> adult user can view the content with confirmation
*		>>> non adult user can view the content
*		>>> adult and non adult user can turn off / turn on the mature warning
*
*	2. If admin set "Display adult content to members" as "Confirmation"
*		>>> adult user can view the content with confirmation
*		>>> non adult user can view the content with confirmation
*		>>> adult and non adult user can turn off / turn on the mature warning
**/
/**
 * ViewVideo
 *
 * @package
 * @author selvaraj_35ag05
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: viewVideo.php 2986 2006-12-29 05:25:10Z selvaraj_35ag05 $
 * @access public
 **/
class ViewVideo extends VideoHandler
	{
		public $enabled_edit_fields = array();
		public $captchaText = '';


		public function isCearQuickListChecked()
			{
				if(isset($_SESSION['user']['quick_list_clear']) and $_SESSION['user']['quick_list_clear']==true)
					return true;
				return false;
			}

		public function getNextPlayListQuickLinks($in_str=0, $getfirst_link=false)
			{
				$condition = ' 1 '.
								' AND video_id IN('.$in_str.') AND v.video_status=\'Ok\''.$this->getAdultQuery('v.').
								' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
								' v.video_access_type = \'Public\''.$this->getAdditionalQuery('v.').')'.
								' AND v.video_id > \''.$this->fields_arr['video_id'].'\' ';

				$sql = 'SELECT MIN(v.video_id) as video_id FROM '.$this->CFG['db']['tbl']['video'].' as v'.
						' WHERE '.$condition.' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
				if($row = $rs->FetchRow() and $row['video_id'] and !$getfirst_link)
					{
						$row['video_title'] = $this->getVideoTitle($row['video_id']);
						$link = getUrl('viewvideo','?video_id='.$row['video_id'].'&title='.$this->changeTitle($row['video_title']).'&vpkey='.$this->fields_arr['vpkey'].'&album_id='.$this->fields_arr['album_id'].'&play_list=ql',
						$row['video_id'].'/'.$this->changeTitle($row['video_title']).'/?vpkey='.$this->fields_arr['vpkey'].'&album_id='.$this->fields_arr['album_id'].'&play_list=ql','','video');
						$this->play_list_next_url=$link;
?>

<a href="<?php echo $link;?>"> <img width="50" src="<?php echo $row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id']).$this->CFG['admin']['videos']['small_name'].'.'.$this->CFG['video']['image']['extensions'];?>" alt="<?php echo  $this->LANG['view_video_play_next_list']; ?>" <?php echo DISP_IMAGE($this->CFG['admin']['videos']['small_width'], $this->CFG['admin']['videos']['small_height'], 50, 50);?> /> </a> <a href="<?php echo $link;?>"> <?php echo  $this->LANG['view_video_play_next_list']; ?> </a>
<?php
						return;
					}
				else
					{
						$condition = ' 1 '.
								' AND video_id IN('.$in_str.') AND v.video_status=\'Ok\''.$this->getAdultQuery('v.').
								' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
								' v.video_access_type = \'Public\''.$this->getAdditionalQuery('v.').')'.
								' ';

						$sql2 = 'SELECT v.video_id as video_id FROM '.$this->CFG['db']['tbl']['video'].' as v'.
								' WHERE '.$condition.' LIMIT 0,1';
						//echo $sql2;
						$stmt = $this->dbObj->Prepare($sql2);
						$rs = $this->dbObj->Execute($stmt);
						    if (!$rs)
							    trigger_db_error($this->dbObj);

						if($row = $rs->FetchRow() and $row['video_id'])
							{
								$row['video_title'] = $this->getVideoTitle($row['video_id']);
								$link = getUrl('viewvideo','?video_id='.$row['video_id'].'&title='.$this->changeTitle($row['video_title']).'&vpkey='.$this->fields_arr['vpkey'].'&album_id='.$this->fields_arr['album_id'].'&play_list=ql',
								$row['video_id'].'/'.$this->changeTitle($row['video_title']).'/?vpkey='.$this->fields_arr['vpkey'].'&album_id='.$this->fields_arr['album_id'].'&play_list=ql','','video');

								$this->play_list_next_url=$link;

?>
<a href="<?php echo $link;?>"><?php echo ($getfirst_link)?$this->LANG['view_video_play_this_list']:$this->LANG['view_video_play_next_list']; ?></a>
<?php
								return;
							}
?>
<span><?php echo  $this->LANG['view_video_play_no_list']; ?></span>
<?php
					}
			}

		public function getVideoTitle($video_id)
			{
				$sql = 'SELECT video_title FROM '.$this->CFG['db']['tbl']['video'].
						' WHERE video_id='.$this->dbObj->Param('video_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($video_id));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				if($row = $rs->FetchRow())
					return $row['video_title'];
				return;
			}

	public function updateUserDetailsInSession()
		{
			$user_id = $this->CFG['user']['user_id'];
			$sql = 'SELECT total_friends, total_photos, total_videos, total_articles, total_games, total_musics, new_mails, new_requests, profile_hits,'.
					' DATE_FORMAT(last_logged, \'%d/%m/%Y\') AS last_logged'.
					' FROM '.$this->CFG['db']['tbl']['users'].' WHERE user_id='.$this->dbObj->Param('user_id');

            $stmt = $this->dbObj->Prepare($sql);
            $rs = $this->dbObj->Execute($stmt, array($user_id));
                if (!$rs)
            	    trigger_db_error($this->dbObj);

			if ($rs->PO_RecordCount()>0)
			    {
					$row = $rs->FetchRow();
					$_SESSION['user']['total_videos'] 	= $row['total_videos'];
					$_SESSION['user']['total_articles']	= $row['total_articles'];
					$_SESSION['user']['total_games'] 	= $row['total_games'];
					$_SESSION['user']['total_photos'] 	= $row['total_photos'];
					$_SESSION['user']['total_friends'] 	= $row['total_friends'];
					$this->userDetails['total_videos'] 	= $row['total_videos'];
					$this->userDetails['total_articles']= $row['total_articles'];
					$this->userDetails['total_games'] 	= $row['total_games'];
					$this->userDetails['total_musics'] 	= $row['total_musics'];
					$this->userDetails['total_photos'] 	= $row['total_photos'];
					$this->userDetails['total_friends'] = $row['total_friends'];
					$this->userDetails['new_requests'] 	= $row['new_requests'];
					$this->userDetails['new_mails']		= $row['new_mails'];
					$this->userDetails['profile_hits']	= $row['profile_hits'];
					$this->userDetails['last_logged']	= $row['last_logged'];
			    }
		}


		public function getExistingRecords($sql)
			{
				$stmt = $this->dbObj->Prepare($sql);
				//echo $sql.'<br />';
				$rs = $this->dbObj->Execute($stmt);
				 if (!$rs)
				    trigger_db_error($this->dbObj);
				$row = $rs->FetchRow();
				return 	$row['count'];
			}

		public function populateQuickLinkVideos($limit=true, $video_id='')
			{
				$this->video_id=$video_id;
				$start=0;
				$return = array();
				$this->seeAllVideos=false;
				$this->clear_quick_checked='';
				$this->in_str=0;
				if(isset($_SESSION['user']['quick_links']) and trim($_SESSION['user']['quick_links'])
						and $avail_quick_link_video_arr=explode(',',$_SESSION['user']['quick_links'])
						and is_array($avail_quick_link_video_arr) and count($avail_quick_link_video_arr)> 1)
						{

						$this->in_str = substr($_SESSION['user']['quick_links'], 0, strrpos($_SESSION['user']['quick_links'], ','));

						$default_fields = 'TIME_FORMAT(v.playing_time,\'%H:%i:%s\') as playing_time, v.video_id, v.user_id, v.video_title, v.video_caption,'.
										  ' TIMEDIFF(NOW(), date_added) as date_added, v.video_server_url, v.total_views,'.
										  ' v.s_width, v.s_height, v.video_ext, v.video_tags';

						$add_fields = '';
						$order_by = 'v.video_id ';
						$allow_quick_links=isLoggedIn() and $this->CFG['admin']['videos']['allow_quick_links'];
						$sql_condition = ' 1 '.
										' AND video_id IN('.$this->in_str.') AND v.video_status=\'Ok\''.$this->getAdultQuery('v.').
										' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
										' v.video_access_type = \'Public\''.$this->getAdditionalQuery('v.').')';
						if($video_id)
							$sql_condition.=' AND v.video_id=\''.$video_id.'\'';

						$more_link = getUrl('videolist','?pg=videotoprated', 'videotoprated/','','video');

						$sql_exising='SELECT count(1) count FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
								' WHERE '.$sql_condition.' ';

						$existing_total_records=$this->getExistingRecords($sql_exising);

						$sql = 'SELECT '.$default_fields.$add_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
								' WHERE '.$sql_condition.' ORDER BY '.$order_by;
						if($limit)
							$sql.=' LIMIT '.$start.', '.$this->CFG['admin']['videos']['total_related_video'];

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						    if (!$rs)
							    trigger_db_error($this->dbObj);

						$this->total_records = $rs->PO_RecordCount();
						$this->quickLinkTip=false;
						if ($this->total_records)
					    {
							$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
							$fields_list = array('user_name', 'first_name', 'last_name', 'icon_id', 'icon_type', 'sex');
							$video_count=0;
							$userid_arr = array();
							$inc=0;
							while($row = $rs->FetchRow())
							{
								if(!in_array($row['user_id'],$userid_arr))
								{
									$userid_arr[]=$row['user_id'];
								}
								$return[$inc]['record']				= $row;
								$return[$inc]['playing_time'] 		= $row['playing_time']?$row['playing_time']:'00:00';
								$return[$inc]['className']			= ($this->fields_arr['video_id']==$row['video_id'])?'clsActiveQuickList':'';
								$return[$inc]['viewVideoUrl']		= getUrl('viewvideo','?video_id='.$row['video_id'].'&title='.$this->changeTitle($row['video_title']).'&vpkey='.$this->fields_arr['vpkey'].'&play_list=ql', $row['video_id'].'/'.$this->changeTitle($row['video_title']).'/?vpkey='.$this->fields_arr['vpkey'].'&play_list=ql','','video');
								$return[$inc]['imageSrc']			= $row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id']).$this->CFG['admin']['videos']['small_name'].'.'.$this->CFG['video']['image']['extensions'];
								$return[$inc]['disp_image']			= DISP_IMAGE($this->CFG['admin']['videos']['small_width'], $this->CFG['admin']['videos']['small_height'], $row['s_width'], $row['s_height']);
								$return[$inc]['wrap_video_title']	= wordWrap_mb_Manual($row['video_title'], $this->CFG['admin']['title_length_list_view']);
								$inc++;
							}
							$userIds=implode(',',$userid_arr);
							$this->getMultiUserDetails($userIds, $fields_list);

							if($this->total_records==$this->CFG['admin']['videos']['total_related_video'] and !$video_id and $limit)
							{
								$this->seeAllVideos=true;
							}
							if(!$video_id)
							{
  								$this->clear_quick_checked=$this->isCearQuickListChecked()?'checked':'';
  								$this->videoManageplaylistUrl=getUrl('videoplaylistmanage','?use=ql','?use=ql','members','video');
  							}

						}

					}
					else
					{
						$this->quickLinkTip=true;
					}
					return $return;
			}

		/**
		 * ViewVideo::getTotalVideos()
		 *
		 * @return
		 */
		public function getTotalVideos()
			{
				return $this->userDetails['total_videos'];
			}

		/**
		 * ViewVideo::showTotalMembersInUsersNetwork()
		 *
		 * @return
		 */
		public function showTotalMembersInUsersNetwork()
			{
				$count = 0;
				$sql = 'SELECT COUNT(user_id) AS cnt FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE usr_status=\'Ok\'';

	            $stmt = $this->dbObj->Prepare($sql);
	            $rs = $this->dbObj->Execute($stmt);
	                if (!$rs)
	            	    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
				    {
				        $row = $rs->FetchRow();
						$count = $row['cnt'];
				    }
		        //$count = $count - 1;
				$count = number_format($count);
				return $count;
			}

		/**
		 * ViewVideo::getTotalVideosWatched()
		 *
		 * @return
		 */
		public function getTotalVideosWatched()
			{
				$sql = 'SELECT COUNT(DISTINCT video_id) AS cnt FROM '.$this->CFG['db']['tbl']['video_viewed'].
						' WHERE user_id=\''.$this->CFG['user']['user_id'].'\'';
	            $stmt = $this->dbObj->Prepare($sql);
	            $rs = $this->dbObj->Execute($stmt);
	                if (!$rs)
	            	    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
				    {
				        $row = $rs->FetchRow();
						$count = $row['cnt'];
				    }
				$count = number_format($count);
				return $count;
			}

		/**
		 * ViewVideo::getTotalVideosFavourite()
		 *
		 * @return
		 */
		public function getTotalVideosFavourite()
			{
				$sql = 'SELECT COUNT(DISTINCT video_id) AS cnt FROM '.$this->CFG['db']['tbl']['video_favorite'].
						' WHERE user_id=\''.$this->CFG['user']['user_id'].'\'';
	            $stmt = $this->dbObj->Prepare($sql);
	            $rs = $this->dbObj->Execute($stmt);
	                if (!$rs)
	            	    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
				    {
				        $row = $rs->FetchRow();
						$count = $row['cnt'];
				    }
				$count = number_format($count);
				return $count;
			}

		/**
		 * ViewVideo::getTotalVideosViews()
		 *
		 * @return
		 */
		public function getTotalVideosViews()
			{
				$sql = 'SELECT SUM(total_views) AS cnt FROM '.$this->CFG['db']['tbl']['video'].
						' WHERE user_id=\''.$this->CFG['user']['user_id'].'\' ';
	            $stmt = $this->dbObj->Prepare($sql);
	            $rs = $this->dbObj->Execute($stmt);
	                if (!$rs)
	            	    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
				    {
				        $row = $rs->FetchRow();
						$count = $row['cnt'];
				    }
				$count = number_format($count);
				return $count;
			}

		/**
		 * ViewVideo::getTotalComments()
		 *
		 * @return
		 */
		public function getTotalComments()
			{
				$sql = 'SELECT COUNT(profile_user_id) AS cnt FROM '.$this->CFG['db']['tbl']['users_profile_comments'].
						' WHERE profile_user_id=\''.$this->CFG['user']['user_id'].'\' ';
	            $stmt = $this->dbObj->Prepare($sql);
	            $rs = $this->dbObj->Execute($stmt);
	                if (!$rs)
	            	    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
				    {
				        $row = $rs->FetchRow();
						$count = $row['cnt'];
				    }
				$count = number_format($count);
				return $count;
			}
		/**
		 * ViewVideo::getTotalFriendsNew()
		 *
		 * @return
		 */
		public function getTotalFriendsNew()
			{
				return $this->userDetails['total_friends'];
			}

		/**
		 * ViewVideo::populateQuickLinkHistoryVideos()
		 *
		 * @param mixed $limit
		 * @param string $video_id
		 * @return
		 */
		public function populateQuickLinkHistoryVideos($limit=true, $video_id='')
			{
				$start=0;
				$this->seeAllHistoryVideos=false;
				$this->historyLinkTip=false;
				$this->video_id=$video_id;
				$return = array();
				if(isset($_SESSION['user']['quick_history']) and trim($_SESSION['user']['quick_history'])
						and $avail_quick_link_video_arr=explode(',',$_SESSION['user']['quick_history'])
						and is_array($avail_quick_link_video_arr) and count($avail_quick_link_video_arr)> 1)
					{
						$in_str = substr($_SESSION['user']['quick_history'], 0, strrpos($_SESSION['user']['quick_history'], ','));

						$default_fields = 'TIME_FORMAT(v.playing_time,\'%H:%i:%s\') as playing_time, v.video_id, v.user_id, v.video_title, v.video_caption,'.
										  ' TIMEDIFF(NOW(), date_added) as date_added, v.video_server_url, v.total_views,'.
										  ' v.s_width, v.s_height, v.video_ext, v.video_tags';

						$add_fields = '';
						$order_by = 'v.video_id ';
						$allow_quick_history=isLoggedIn() and $this->CFG['admin']['videos']['allow_history_links'];
						$sql_condition = ' 1 '.
										' AND video_id IN('.$in_str.') AND v.video_status=\'Ok\''.$this->getAdultQuery('v.').
										' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
										' v.video_access_type = \'Public\''.$this->getAdditionalQuery('v.').')';
						if($video_id)
							$sql_condition.=' AND v.video_id=\''.$video_id.'\'';

						$more_link = getUrl('videolist','?pg=videotoprated', 'videotoprated/','','video');

						$sql_exising='SELECT count(1) count FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
								' WHERE '.$sql_condition.' ';

						$existing_total_records=$this->getExistingRecords($sql_exising);

						$sql = 'SELECT '.$default_fields.$add_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
								' WHERE '.$sql_condition.' ORDER BY '.$order_by;
						if($limit)
							$sql.=' LIMIT '.$start.', '.$this->CFG['admin']['videos']['total_related_video'];

						//$nextSetAvailable = ($existing_total_records > ($process_start + $this->CFG['admin']['videos']['total_related_video']));

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						    if (!$rs)
							   trigger_db_error($this->dbObj);

						$total_records = $rs->PO_RecordCount();

						if ($total_records)
						    {
								$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
								$fields_list = array('user_name', 'first_name', 'last_name', 'icon_id', 'icon_type', 'sex');
								$video_count=0;
								$inc=0;
								while($row = $rs->FetchRow())
									{
										$return[$inc]['record']			=$row;
										$return[$inc]['playing_time'] 	= $row['playing_time']?$row['playing_time']:'00:00';
										$return[$inc]['className']		=($this->fields_arr['video_id']==$row['video_id'])?'clsActiveQuickList':'';
										$return[$inc]['viewVideoUrl']	=getUrl('viewvideo','?video_id='.$row['video_id'].'&title='.$this->changeTitle($row['video_title']).'&vpkey='.$this->fields_arr['vpkey'].'&play_list=ql', $row['video_id'].'/'.$this->changeTitle($row['video_title']).'/?vpkey='.$this->fields_arr['vpkey'].'&play_list=ql','','video');
										$return[$inc]['imageSrc']		=$row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id']).$this->CFG['admin']['videos']['small_name'].'.'.$this->CFG['video']['image']['extensions'];
										$return[$inc]['disp_image']		=DISP_IMAGE($this->CFG['admin']['videos']['small_width'], $this->CFG['admin']['videos']['small_height'], $row['s_width'], $row['s_height']);
										$return[$inc]['wrap_video_title']=wordWrap_mb_Manual($row['video_title'], $this->CFG['admin']['videos']['video_title_word_wrap_length']);
										$inc++;
									}
								if($total_records==$this->CFG['admin']['videos']['total_related_video'] and !$video_id and $limit)
									{
											$this->seeAllHistoryVideos=true;

									}
							}

					}
					else
						{

							$this->historyLinkTip=true;
						}

						return $return;
			}

		/**
		 * ViewVideo::populateMyHotLinks()
		 *
		 * @return
		 */
		public function populateMyHotLinks()
			{
				$this->myFriends=$myFriends;
				$this->myFriendsUrl=getUrl($this->CFG['admin']['profile_urls']['my_friends']['normal'], $this->CFG['admin']['profile_urls']['my_friends']['htaccess']);

				$this->myProfile=$myProfile;
				$this->myProfileUrl=getUrl('myProfile.php', 'myprofile/');

				if(chkAllowedModule(array('video')))
				{
					$this->videoUploadPopUpUrl=getUrl('videoUploadPopUp.php', 'videouploadpopup/');
					$this->myVideoUrl=getUrl('videolist','?pg=myvideos', 'myvideos/', '', 'video');
					$this->videoUploadPopUp_Page=$videoUploadPopUp_Page;
					$this->videoList_pg_myvideos=$videoList_pg_myvideos;
				}
	    		if(chkAllowedModule(array('affiliate')))
				{
	    			$this->memberBlock=$memberBlock;
					$this->memberListUrl=getUrl($this->CFG['admin']['profile_urls']['members_list']['normal'], $this->CFG['admin']['profile_urls']['members_list']['htaccess']).'?browse=referrals';
	    		}
	    		if(chkAllowedModule(array('mail')))
				{
	    			$this->mail_pg_inbox=$mail_pg_inbox;
					$this->inboxUrl=getUrl($this->CFG['admin']['mail_urls']['inbox']['normal'], $this->CFG['admin']['mail_urls']['inbox']['htaccess']);
	    		}
				if(chkAllowedModule(array('members_banner', 'members_post_banner')))
				{
	    			$this->manageBanner=$manageBanner;
					$this->manageBannerUrl=getUrl('manageBanner.php', 'banner/');
	    		}
	    		if(chkAllowedModule(array('affiliate')))
				{
	    			$this->earnings=$earnings;
					$this->myEarningsUrl=getUrl('earnings.php', 'earnings/');
	    		}
	    		if(chkAllowedModule(array('affiliate')))
				{
	    			$this->List_pg_referrals=$List_pg_referrals;
					$this->pageRefferalUrl=getUrl($this->CFG['admin']['profile_urls']['members_list']['normal'], $this->CFG['admin']['profile_urls']['members_list']['htaccess']).'?browse=referrals';
				}
		}

		/**
		 * ViewVideo::showSearchBlock()
		 *
		 * @param array $field_names_arr
		 * @return
		 */
		public function showSearchBlock($field_names_arr=array())
			{
				$html_url = substr($_SERVER['REQUEST_URI'],0,strrpos($_SERVER['REQUEST_URI'], '?'));
				$html_url=URL($html_url);
				$this->query_str = '';
				$default_url=(isloggedIn())?$this->CFG['site']['url'].'members/searchList.php':$this->CFG['site']['url'].'/searchList.php';
				$this->html_url=(trim($html_url))?$html_url:$default_url;

				foreach($field_names_arr as $field_name)
					{
						if (is_array($this->fields_arr[$field_name]))
						{
							foreach($this->fields_arr[$field_name] as $sub_field_value)
								$this->query_str .= "&amp;".$field_name."[]=$sub_field_value";
						}
						else if($this->fields_arr[$field_name]!='')
							$this->query_str .= "&amp;$field_name=".$this->fields_arr[$field_name];
					}
				$activeblockcss='clsSearchActiveBlock';
				$activeRightblockcss='clsActiveVideoLinkRight';
				if(chkAllowedModule(array('video')))
					{
							if($this->CFG['admin']['videos']['allow_quick_links'])
								{
									$this->activeblockcss_quickLinks=($this->fields_arr['block']=='ql')?$activeblockcss:'';
									$this->activeRightblockcss_quickLinks=($this->fields_arr['block']=='ql')?$activeRightblockcss:'';
								}
							if($this->CFG['admin']['videos']['allow_history_links'])
								{
									$this->activeblockcss_historyLinks=($this->fields_arr['block']=='hst')?$activeblockcss:'';
									$this->activeRightblockcss_historyLinks=($this->fields_arr['block']=='hst')?$activeRightblockcss:'';
								}
					}
			}


	}
//<<<<<-------------- Class ViewVideo begins ---------------//
//-------------------- Code begins -------------->>>>>//
$ViewVideo = new ViewVideo();
$ViewVideo->setDBObject($db);
$ViewVideo->makeGlobalize($CFG,$LANG);

if(!chkAllowedModule(array('video')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

if(!isMember())
	Redirect2URL($ViewVideo->getUrl('login','',''));

$ViewVideo->setPageBlockNames(array('msg_form_error', 'videos_form', 'delete_confirm_form', 'get_code_form',
									'confirmation_flagged_form', 'add_comments', 'add_reply', 'edit_comment',
									'update_comment', 'rating_image_form', 'add_flag_list', 'add_fovorite_list',
									'confirmation_adult_form', 'videoMainBlock'));

$ViewVideo->setCSSFormFieldErrorTipClass('clsFormFieldErrTip');
$ViewVideo->setCSSFormLabelCellDefaultClass('clsFormLabelCellDefault');
$ViewVideo->setCSSFormFieldCellDefaultClass('clsFormFieldCellDefault');
$ViewVideo->setCSSFormLabelCellErrorClass('clsFormLabelCellError');
$ViewVideo->setCSSFormFieldCellErrorClass('clsFormFieldCellError');
//default form fields and values...
$ViewVideo->setFormField('video_id', '');
$ViewVideo->setFormField('total_downloads', '0');
$ViewVideo->setFormField('vpkey', '');
$ViewVideo->setFormField('action', '');
$ViewVideo->setFormField('comment_id', '');
$ViewVideo->setFormField('action', '');
$ViewVideo->setFormField('video_code', '');
$ViewVideo->setFormField('video_title', '');
$ViewVideo->setFormField('user_name', '');
$ViewVideo->setFormField('user_id', '');
$ViewVideo->setFormField('album_id', '');
//for ajax
$ViewVideo->setFormField('f',0);
$ViewVideo->setFormField('show','1');
$ViewVideo->setFormField('comment_id',0);
$ViewVideo->setFormField('type','');
$ViewVideo->setFormField('ajax_page','');
$ViewVideo->setFormField('paging','');
$ViewVideo->setFormField('rate', '');
$ViewVideo->setFormField('flag', '');
$ViewVideo->setFormField('page', '');
$ViewVideo->setFormField('favorite_id', '');
$ViewVideo->setFormField('video_tags', '');
$ViewVideo->setFormField('block', '');
$ViewVideo->setFormField('tags', '');

$ViewVideo->sanitizeFormInputs($_REQUEST);
$ViewVideo->setPageBlockShow('videoMainBlock');
$ViewVideo->play_list_next_url='';
$ViewVideo->is_logged_in=isLoggedIn() ;

if(isAjax())
	{
		$ViewVideo->includeAjaxHeaderSessionCheck();

		if($ViewVideo->isFormGETed($_GET, 'show_complete_quick_list') || $ViewVideo->isPageGETed($_POST, 'show_complete_quick_list'))
			{
						$ViewVideo->quickLinkVideo=$ViewVideo->populateQuickLinkVideos($limit=false);
			}

		if ($ViewVideo->isPageGETed($_POST, 'show_qucik_link_text_id'))
		    {
				$ViewVideo->quickLinkVideo=$ViewVideo->populateQuickLinkVideos(true, $_POST['show_qucik_link_text_id']);
			}

		if ($ViewVideo->isPageGETed($_POST, 'show_complete_history_list') || $ViewVideo->isPageGETed($_GET, 'show_complete_history_list'))
		    {
				$ViewVideo->historyVideos=$ViewVideo->populateQuickLinkHistoryVideos($limit=false);
			}
		setTemplateFolder('members/','video');
		$smartyObj->display('myDashBoard.tpl');
		$ViewVideo->includeAjaxFooter();
	}


//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//

$LANG['mydashboard_meta_keywords']=str_replace('{default_tags}', $CFG['html']['meta']['keywords'], $LANG['mydashboard_meta_keywords']);
$LANG['mydashboard_meta_keywords']=str_replace('{tags}', $ViewVideo->getFormField('video_tags'), $LANG['mydashboard_meta_keywords']);
$LANG['mydashboard_meta_title']=str_replace('{site_title}', $CFG['site']['title'], $LANG['mydashboard_meta_title']);
$LANG['mydashboard_meta_title']=str_replace('{title}', $ViewVideo->getFormField('video_title'), $LANG['mydashboard_meta_title']);
$LANG['mydashboard_meta_title']=str_replace('{module}', $LANG['window_title_video'], $LANG['mydashboard_meta_title']);
$LANG['mydashboard_meta_description']=str_replace('{default_tags}', $CFG['html']['meta']['keywords'], $LANG['mydashboard_meta_description']);
$LANG['mydashboard_meta_description']=str_replace('{tags}', $ViewVideo->getFormField('video_tags'), $LANG['mydashboard_meta_description']);

setPageTitle($LANG['mydashboard_meta_title']);
setMetaKeywords($LANG['mydashboard_meta_keywords']);
setMetaDescription($LANG['mydashboard_meta_description']);

$LANG['mydash_board_title']=($ViewVideo->getFormField('block')=='hst')?$LANG['mydashboard_type_history_link']:$LANG['mydash_board_title'];

$field_names_arr=array('tags');
$ViewVideo->showSearchBlock($field_names_arr);
if($ViewVideo->getFormField('block')=='ql')
{
	if(isLoggedIn() and $ViewVideo->CFG['admin']['videos']['allow_quick_links'])
		$ViewVideo->quickLinkVideo=$ViewVideo->populateQuickLinkVideos();
}
else if ($ViewVideo->getFormField('block')=='hst' and isLoggedIn() and $CFG['admin']['videos']['allow_history_links'])
{
	$ViewVideo->historyVideos=$ViewVideo->populateQuickLinkHistoryVideos();
}
else
{
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
}

//include the header file
$ViewVideo->includeHeader();
//include the content of the page
setTemplateFolder('members/','video');
$smartyObj->display('myDashBoard.tpl');
?>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/functions.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/AG_ajax_html.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['video_url'];?>js/viewVideo.js"></script>
<script language="javascript">
var vLoader = 'loaderVideos';
var homeUrl = '<?php echo getUrl('mydashboard','?block=ql','?block=ql','','video');?>';
var disPrevButton = 'disabledPrevButton';
var disNextButton = 'disabledNextButton';
var pars= 'vLeft=&vFetch=';
var currUrl = '<?php echo getUrl('mydashboard','?block=hdt','?block=hst','','video');?>';

function popupWindow(url){
		 window.open (url, "","status=0,toolbar=0,resizable=0,scrollbars=1");
		 return false;
	}
	function setClass(li_id, li_class){
		document.getElementById(li_id).setAttribute('className',li_class);
		document.getElementById(li_id).setAttribute('class',li_class);
	}
	function showDiv(element){
		if(obj = document.getElementById(element))
			obj.style.display = '';
	}
	function hideDiv(element){
		if(obj = document.getElementById(element))
			obj.style.display = 'none';
	}

	function updateVideosQuickLinksCount(video_id, pg)
		{
			var url = '<?php echo $CFG['site']['video_url'];?>videoUpdateQuickLinks.php';
			var pars = '?video_id='+video_id;
			var path=url+pars;
			curr_side_bar_pg=pg;
			curr_video_id=video_id;
			jquery_ajax(path, '', 'getQuickLinkCode');
			return false;
		}

	function getQuickLinkCode(data)
		{
			if(obj = document.getElementById('quick_link_tag_'+curr_video_id))
				obj.innerHTML = '<?php echo $LANG['add_to_quick_links_added'] ?>';
			if(obj = document.getElementById('quick_link_user_'+curr_video_id))
				obj.innerHTML = '<?php echo $LANG['add_to_quick_links_added'] ?>';
			if(obj = document.getElementById('quick_link_top_'+curr_video_id))
				obj.innerHTML = '<?php echo $LANG['add_to_quick_links_added'] ?>';

			if($Jq('#selQuickList'))
				addBlocksForQuickLinks();
				else
					moreVideosQuickList();
		}

	function deleteVideoQuickLinks(video_id)
		{
			var url = '<?php echo $CFG['site']['video_url']?>videoUpdateQuickLinks.php';
			var pars = '?video_id='+video_id+'&remove_it';
			var path=url+pars;
			curr_sel_video_id=video_id;
			jquery_ajax(path, '', 'hideQuickLinkCode');
		}

	function hideQuickLinkCode(data)
		{

			$Jq('#quick_list_selected_'+curr_sel_video_id).css('display', 'none');
			//hideDiv('quick_list_selected_'+curr_sel_video_id);
			removeElement($Jq('#quick_list_selected_'+curr_sel_video_id));
		}

	function deleteVideoQuickHistoryLinks(video_id)
		{
			var url = '<?php echo $CFG['site']['url'].'video/';?>videoUpdateQuickHistoryLinks.php';
			var pars = '?video_id='+video_id+'&remove_it';
			var path=url+pars;
			curr_sel_video_id=video_id;
			jquery_ajax(path, '','hideQuickLinkCode');
		}

	function removeElement(divNum)
		{
		  var d = document.getElementById('selQuickList');
		  var olddiv = document.getElementById(divNum);
		  d.removeChild(olddiv);
		}

	function addBlocksForQuickLinks()
		{
			$Jq.ajax({
			type: "GET",
			url: currUrl,
			data: '&ajax_page=1&show_qucik_link_text_id='+curr_video_id,
			success: refreshQucikLinkBlockTag
			 });
		}

	function refreshQucikLinkBlockTag(resp)
		{
			data  = unescape(data);
			$Jq('#selQuickList').html(data);
		}

	function moreVideosQuickList()
		{
			$Jq.ajax({
			type: "GET",
			url: homeUrl,
			data: '&ajax_page=1&show_complete_quick_list=1',
			success: refreshQucikLinkBlockTagAll
			 });
			 //alert(data);
		}


	function refreshQucikLinkBlockTagAll(resp)
		{
			data  = unescape(resp);
			//data  = unescape(data);
			$Jq('#selVideoQuickLinks').html(data);
			jquery_ajax(path, '','hideQuickLinkCode');
		}

	function moreVideosQuickHistoryList()
		{
			$Jq.ajax({
			type: "GET",
			url: currUrl,
			data: '&ajax_page=1&show_complete_history_list=1',
			success: refreshHistoryLinkBlockTagAll
			 });
		}

	function refreshHistoryLinkBlockTagAll(resp)
		{

			data  = unescape(resp);
			$Jq('#selVideoHistoryLinks').html(data);
			//new AG_ajax(path,'hideQuickLinkCode');
		}

	function toggleOnViewClearQuickList(obj)
		{
			var url = '<?php echo $CFG['site']['video_url'];?>videoUpdateQuickLinks.php';
			if(obj.checked)
				var pars = '?clear_on_view=1';
				else
					var pars = '?clear_on_view=0';
			var path=url+pars;
			jquery_ajax(path, '','setToggleQuickList');
		}

	function clearQuickHistoryLinks()
		{
			var url = '<?php echo $CFG['site']['video_url'];?>videoUpdateQuickHistoryLinks.php';
			var pars = '?clear_list=1';
			var path=url+pars;
			//alert(path);
			jquery_ajax(path, '','setQuickHistoryClearList');
		}

	function setQuickHistoryClearList(resp)
		{
			$Jq('#selVideoHistoryLinks').html('<div id="selMsgSuccess"><p><?php echo $LANG['histroyLinks_remove_msg'];?></p></div>');
		}

	function clearQuickLinks()
		{
			var url = '<?php echo $CFG['site']['video_url'];?>videoUpdateQuickLinks.php';
			var pars = '?clear_list=1';
			var path=url+pars;
			//alert(path);
			jquery_ajax(path, '','setQuickClearList');
		}

	function setQuickClearList(resp)
		{
			$Jq('#selVideoQuickLinks').html('');
			$Jq('#selMsg').css('display', 'block');

		}

	function setToggleQuickList(resp)
		{
			return true;
		}

</script>
<?php
$ViewVideo->includeFooter();
?>
