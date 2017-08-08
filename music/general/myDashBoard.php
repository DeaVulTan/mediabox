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
 * ViewMusic
 *
 * @package
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: listenMusic.php 2986 2006-12-29 05:25:10Z selvaraj_35ag05 $
 * @access public
 **/
class ViewMusic extends MusicHandler
	{
		public $enabled_edit_fields = array();
		public $captchaText = '';


		public function isCearQuickListChecked()
			{
				if(isset($_SESSION['user']['music_quick_list_clear']) and $_SESSION['user']['music_quick_list_clear']==true)
					return true;
				return false;
			}

		public function getNextPlayListQuickLinks($in_str=0, $getfirst_link=false)
			{
				$condition = ' 1 '.
								' AND music_id IN('.$in_str.') AND v.music_status=\'Ok\''.$this->getAdultQuery('v.', 'music').
								' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
								' v.music_access_type = \'Public\''.$this->getAdditionalQuery('v.').')'.
								' AND v.music_id > \''.$this->fields_arr['music_id'].'\' ';

				$sql = 'SELECT MIN(v.music_id) as music_id FROM '.$this->CFG['db']['tbl']['music'].' as v'.
						' WHERE '.$condition.' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
				if($row = $rs->FetchRow() and $row['music_id'] and !$getfirst_link)
					{
						$row['music_title'] = $this->getMusicTitle($row['music_id']);
						$link = getUrl('viewmusic','?music_id='.$row['music_id'].'&title='.$this->changeTitle($row['music_title']).'&vpkey='.$this->fields_arr['vpkey'].'&album_id='.$this->fields_arr['album_id'].'&play_list=ql',
						$row['music_id'].'/'.$this->changeTitle($row['music_title']).'/?vpkey='.$this->fields_arr['vpkey'].'&album_id='.$this->fields_arr['album_id'].'&play_list=ql','','music');
						$this->play_list_next_url=$link;
?>

<a href="<?php echo $link;?>"> <img width="50" src="<?php echo $row['music_server_url'].$thumbnail_folder.getMusicImageName($row['music_id']).$this->CFG['admin']['musics']['small_name'].'.'.$this->CFG['music']['image']['extensions'];?>" alt="<?php echo  $this->LANG['view_music_play_next_list']; ?>" <?php echo DISP_IMAGE($this->CFG['admin']['musics']['small_width'], $this->CFG['admin']['musics']['small_height'], 50, 50);?> /> </a> <a href="<?php echo $link;?>"> <?php echo  $this->LANG['view_music_play_next_list']; ?> </a>
<?php
						return;
					}
				else
					{
						$condition = ' 1 '.
								' AND music_id IN('.$in_str.') AND v.music_status=\'Ok\''.$this->getAdultQuery('v.', 'music').
								' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
								' v.music_access_type = \'Public\''.$this->getAdditionalQuery('v.').')'.
								' ';

						$sql2 = 'SELECT v.music_id as music_id FROM '.$this->CFG['db']['tbl']['music'].' as v'.
								' WHERE '.$condition.' LIMIT 0,1';
						//echo $sql2;
						$stmt = $this->dbObj->Prepare($sql2);
						$rs = $this->dbObj->Execute($stmt);
						    if (!$rs)
							    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						if($row = $rs->FetchRow() and $row['music_id'])
							{
								$row['music_title'] = $this->getMusicTitle($row['music_id']);
								$link = getUrl('viewmusic','?music_id='.$row['music_id'].'&title='.$this->changeTitle($row['music_title']).'&vpkey='.$this->fields_arr['vpkey'].'&album_id='.$this->fields_arr['album_id'].'&play_list=ql',
								$row['music_id'].'/'.$this->changeTitle($row['music_title']).'/?vpkey='.$this->fields_arr['vpkey'].'&album_id='.$this->fields_arr['album_id'].'&play_list=ql','','music');

								$this->play_list_next_url=$link;

?>
<a href="<?php echo $link;?>"><?php echo ($getfirst_link)?$this->LANG['view_music_play_this_list']:$this->LANG['view_music_play_next_list']; ?></a>
<?php
								return;
							}
?>
<span><?php echo  $this->LANG['view_music_play_no_list']; ?></span>
<?php
					}
			}

		public function getMusicTitle($music_id)
			{
				$sql = 'SELECT music_title FROM '.$this->CFG['db']['tbl']['music'].
						' WHERE music_id='.$this->dbObj->Param('music_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($music_id));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if($row = $rs->FetchRow())
					return $row['music_title'];
				return;
			}

	public function updateUserDetailsInSession()
		{
			$user_id = $this->CFG['user']['user_id'];
			$sql = 'SELECT total_friends, total_photos, total_musics, total_articles, total_games, total_musics, new_mails, new_requests, profile_hits,'.
					' DATE_FORMAT(last_logged, \'%d/%m/%Y\') AS last_logged'.
					' FROM '.$this->CFG['db']['tbl']['users'].' WHERE user_id='.$this->dbObj->Param('user_id');

            $stmt = $this->dbObj->Prepare($sql);
            $rs = $this->dbObj->Execute($stmt, array($user_id));
                if (!$rs)
            	    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if ($rs->PO_RecordCount()>0)
			    {
					$row = $rs->FetchRow();
					$_SESSION['user']['total_musics'] 	= $row['total_musics'];
					$_SESSION['user']['total_articles']	= $row['total_articles'];
					$_SESSION['user']['total_games'] 	= $row['total_games'];
					$_SESSION['user']['total_photos'] 	= $row['total_photos'];
					$_SESSION['user']['total_friends'] 	= $row['total_friends'];
					$this->userDetails['total_musics'] 	= $row['total_musics'];
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
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$row = $rs->FetchRow();
				return 	$row['count'];
			}

		public function populateQuickLinkMusics($limit=true, $music_id='')
			{

				echo $this->music_id=$music_id;
				$start=0;
				$return = array();
				$this->seeAllMusics=false;
				$this->clear_quick_checked='';
				$this->in_str=0;
				if(isset($_SESSION['user']['music_quick_mixs']) and trim($_SESSION['user']['music_quick_mixs'])
						and $avail_quick_link_music_arr=explode(',',$_SESSION['user']['music_quick_mixs'])
						and is_array($avail_quick_link_music_arr) and count($avail_quick_link_music_arr)> 1)
						{

						$this->in_str = substr($_SESSION['user']['music_quick_mixs'], 0, strrpos($_SESSION['user']['music_quick_mixs'], ','));


						$default_fields = 'TIME_FORMAT(v.playing_time,\'%H:%i:%s\') as playing_time, v.music_id, v.user_id, v.music_title, v.music_caption,'.
										  ' TIMEDIFF(NOW(), date_added) as date_added, v.music_server_url, v.total_views,'.
										  ' v.small_width, v.small_height, v.music_ext, v.music_tags';

						$add_fields = '';
						$order_by = 'v.music_id ';
						$allow_quick_links=isLoggedIn() and $this->CFG['admin']['musics']['allow_quick_mixs'];
						$sql_condition = ' 1 '.
										' AND music_id IN('.$this->in_str.') AND v.music_status=\'Ok\''.$this->getAdultQuery('v.', 'music').
										' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
										' v.music_access_type = \'Public\''.$this->getAdditionalQuery('v.').')';

						if($music_id)
							$sql_condition.=' AND v.music_id=\''.$music_id.'\'';


						$more_link = getUrl('musiclist','?pg=musictoprated', 'musictoprated/','','music');

						$sql_exising='SELECT count(1) count FROM '.$this->CFG['db']['tbl']['music'].' AS v'.
								' WHERE '.$sql_condition.' ';


						$existing_total_records=$this->getExistingRecords($sql_exising);

						$sql = 'SELECT '.$default_fields.$add_fields.' FROM '.$this->CFG['db']['tbl']['music'].' AS v'.
								' WHERE '.$sql_condition.' ORDER BY '.$order_by;
						if($limit)
							$sql.=' LIMIT '.$start.', '.$this->CFG['admin']['musics']['total_related_music'];

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						    if (!$rs)
							    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						$this->total_records = $rs->PO_RecordCount();
						$this->quickLinkTip=false;
						if ($this->total_records)
					    {
							$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
							$fields_list = array('user_name', 'first_name', 'last_name', 'icon_id', 'icon_type', 'sex');
							$music_count=0;
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
								$return[$inc]['className']			= ($this->fields_arr['music_id']==$row['music_id'])?'clsActiveQuickList':'';
								$return[$inc]['viewMusicUrl']		= getUrl('viewmusic','?music_id='.$row['music_id'].'&title='.$this->changeTitle($row['music_title']).'&vpkey='.$this->fields_arr['vpkey'].'&play_list=ql', $row['music_id'].'/'.$this->changeTitle($row['music_title']).'/?vpkey='.$this->fields_arr['vpkey'].'&play_list=ql','','music');
								$return[$inc]['imageSrc']			= $row['music_server_url'].$thumbnail_folder.getMusicImageName($row['music_id']).$this->CFG['admin']['musics']['small_name'].'.'.$this->CFG['music']['image']['extensions'];
								$return[$inc]['disp_image']			= DISP_IMAGE($this->CFG['admin']['musics']['small_width'], $this->CFG['admin']['musics']['small_height'], $row['small_width'], $row['small_height']);
								$return[$inc]['wrap_music_title']	= wordWrap_mb_Manual($row['music_title'], $this->CFG['admin']['title_length_list_view']);
								$inc++;
							}
							$userIds=implode(',',$userid_arr);
							$this->getMultiUserDetails($userIds, $fields_list);

							if($this->total_records==$this->CFG['admin']['musics']['total_related_music'] and !$music_id and $limit)
							{
								$this->seeAllMusics=true;
							}
							if(!$music_id)
							{
  								$this->clear_quick_checked=$this->isCearQuickListChecked()?'checked':'';
  								$this->musicManageplaylistUrl=getUrl('musicplaylistmanage','?use=ql','?use=ql','members','music');
  							}

						}

					}
					else
					{
						$this->quickLinkTip=true;
					}
					return $return;

			}

		public function getTotalMusics()
			{
				return $this->userDetails['total_musics'];
			}

		public function showTotalMembersInUsersNetwork()
			{
				$count = 0;
				$sql = 'SELECT COUNT(user_id) AS cnt FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE usr_status=\'Ok\'';

	            $stmt = $this->dbObj->Prepare($sql);
	            $rs = $this->dbObj->Execute($stmt);
	                if (!$rs)
	            	    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($rs->PO_RecordCount())
				    {
				        $row = $rs->FetchRow();
						$count = $row['cnt'];
				    }
		        //$count = $count - 1;
				$count = number_format($count);
				return $count;
			}

		public function getTotalMusicsWatched()
			{
				$sql = 'SELECT COUNT(DISTINCT music_id) AS cnt FROM '.$this->CFG['db']['tbl']['music_viewed'].
						' WHERE user_id=\''.$this->CFG['user']['user_id'].'\'';
	            $stmt = $this->dbObj->Prepare($sql);
	            $rs = $this->dbObj->Execute($stmt);
	                if (!$rs)
	            	    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if ($rs->PO_RecordCount())
				    {
				        $row = $rs->FetchRow();
						$count = $row['cnt'];
				    }
				$count = number_format($count);
				return $count;
			}

		public function getTotalMusicsFavourite()
			{
				$sql = 'SELECT COUNT(DISTINCT music_id) AS cnt FROM '.$this->CFG['db']['tbl']['music_favorite'].
						' WHERE user_id=\''.$this->CFG['user']['user_id'].'\'';
	            $stmt = $this->dbObj->Prepare($sql);
	            $rs = $this->dbObj->Execute($stmt);
	                if (!$rs)
	            	    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if ($rs->PO_RecordCount())
				    {
				        $row = $rs->FetchRow();
						$count = $row['cnt'];
				    }
				$count = number_format($count);
				return $count;
			}

		public function getTotalMusicsViews()
			{
				$sql = 'SELECT SUM(total_views) AS cnt FROM '.$this->CFG['db']['tbl']['music'].
						' WHERE user_id=\''.$this->CFG['user']['user_id'].'\' ';
	            $stmt = $this->dbObj->Prepare($sql);
	            $rs = $this->dbObj->Execute($stmt);
	                if (!$rs)
	            	    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if ($rs->PO_RecordCount())
				    {
				        $row = $rs->FetchRow();
						$count = $row['cnt'];
				    }
				$count = number_format($count);
				return $count;
			}

		public function getTotalComments()
			{
				$sql = 'SELECT COUNT(profile_user_id) AS cnt FROM '.$this->CFG['db']['tbl']['users_profile_comments'].
						' WHERE profile_user_id=\''.$this->CFG['user']['user_id'].'\' ';
	            $stmt = $this->dbObj->Prepare($sql);
	            $rs = $this->dbObj->Execute($stmt);
	                if (!$rs)
	            	    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if ($rs->PO_RecordCount())
				    {
				        $row = $rs->FetchRow();
						$count = $row['cnt'];
				    }
				$count = number_format($count);
				return $count;
			}
		public function getTotalFriendsNew()
			{
				return $this->userDetails['total_friends'];
			}

		public function populateQuickLinkHistoryMusics($limit=true, $music_id='')
			{
				$start=0;
				$this->seeAllHistoryMusics=false;
				$this->historyLinkTip=false;
				$this->music_id=$music_id;
				$return = array();
				if(isset($_SESSION['user']['music_quick_history']) and trim($_SESSION['user']['music_quick_history'])
						and $avail_quick_link_music_arr=explode(',',$_SESSION['user']['music_quick_history'])
						and is_array($avail_quick_link_music_arr) and count($avail_quick_link_music_arr)> 1)
					{
						$in_str = substr($_SESSION['user']['music_quick_history'], 0, strrpos($_SESSION['user']['music_quick_history'], ','));

						$default_fields = 'TIME_FORMAT(v.playing_time,\'%H:%i:%s\') as playing_time, v.music_id, v.user_id, v.music_title, v.music_caption,'.
										  ' TIMEDIFF(NOW(), date_added) as date_added, v.music_server_url, v.total_views,'.
										  ' v.small_width, v.small_height, v.music_ext, v.music_tags';

						$add_fields = '';
						$order_by = 'v.music_id ';
						$allow_quick_history=isLoggedIn() and $this->CFG['admin']['musics']['allow_history_links'];
						$sql_condition = ' 1 '.
										' AND music_id IN('.$in_str.') AND v.music_status=\'Ok\''.$this->getAdultQuery('v.', 'music').
										' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
										' v.music_access_type = \'Public\''.$this->getAdditionalQuery('v.').')';
						if($music_id)
							$sql_condition.=' AND v.music_id=\''.$music_id.'\'';



						$more_link = getUrl('musiclist','?pg=musictoprated', 'musictoprated/','','music');

						$sql_exising='SELECT count(1) count FROM '.$this->CFG['db']['tbl']['music'].' AS v'.
								' WHERE '.$sql_condition.' ';

						$existing_total_records=$this->getExistingRecords($sql_exising);

						$sql = 'SELECT '.$default_fields.$add_fields.' FROM '.$this->CFG['db']['tbl']['music'].' AS v'.
								' WHERE '.$sql_condition.' ORDER BY '.$order_by;
						if($limit)
							$sql.=' LIMIT '.$start.', '.$this->CFG['admin']['musics']['total_related_music'];

						//$nextSetAvailable = ($existing_total_records > ($process_start + $this->CFG['admin']['musics']['total_related_music']));

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						    if (!$rs)
							    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						$total_records = $rs->PO_RecordCount();

						if ($total_records)
						    {
								$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
								$fields_list = array('user_name', 'first_name', 'last_name', 'icon_id', 'icon_type', 'sex');
								$music_count=0;
								$inc=0;
								while($row = $rs->FetchRow())
									{
										$return[$inc]['record']			=$row;
										$return[$inc]['playing_time'] 	= $row['playing_time']?$row['playing_time']:'00:00';
										$return[$inc]['className']		=($this->fields_arr['music_id']==$row['music_id'])?'clsActiveQuickList':'';
										$return[$inc]['viewMusicUrl']	=getUrl('viewvideo','?music_id='.$row['music_id'].'&title='.$this->changeTitle($row['music_title']).'&vpkey='.$this->fields_arr['vpkey'].'&play_list=ql', $row['music_id'].'/'.$this->changeTitle($row['music_title']).'/?vpkey='.$this->fields_arr['vpkey'].'&play_list=ql','','video');
										$return[$inc]['imageSrc']		=$row['music_server_url'].$thumbnail_folder.getMusicImageName($row['music_id']).$this->CFG['admin']['musics']['small_name'].'.'.$this->CFG['music']['image']['extensions'];
										$return[$inc]['disp_image']		=DISP_IMAGE($this->CFG['admin']['musics']['small_width'], $this->CFG['admin']['musics']['small_height'], $row['small_width'], $row['small_height']);
										$return[$inc]['wrap_music_title']=wordWrap_mb_Manual($row['music_title'], $this->CFG['admin']['musics']['music_title_word_wrap_length']);
										$inc++;
									}
								if($total_records==$this->CFG['admin']['musics']['total_related_music'] and !$music_id and $limit)
									{
											$this->seeAllHistoryMusics=true;

									}
							}

					}
					else
						{

							$this->historyLinkTip=true;
						}

						return $return;
			}

		public function populateMyHotLinks()
			{

			$this->myFriends=$myFriends;
			$this->myFriendsUrl=getUrl($this->CFG['admin']['profile_urls']['my_friends']['normal'], $this->CFG['admin']['profile_urls']['my_friends']['htaccess']);

			$this->myProfile=$myProfile;
			$this->myProfileUrl=getUrl('myProfile.php', 'myprofile/');

			if(chkAllowedModule(array('music')))
			{
				$this->musicUploadPopUpUrl=getUrl('musicUploadPopUp.php', 'musicuploadpopup/');
				$this->myMusicUrl=getUrl('musiclist','?pg=mymusics', 'mymusics/', '', 'music');
				$this->musicUploadPopUp_Page=$musicUploadPopUp_Page;
				$this->musicList_pg_mymusics=$musicList_pg_mymusics;
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
				$activeblockcss='clsActive';
				$activeRightblockcss='clsActiveMusicLinkRight';
				if(chkAllowedModule(array('music')))
					{
							if($this->CFG['admin']['musics']['allow_quick_mixs'])
								{
									$this->activeblockcss_quickLinks=($this->fields_arr['block']=='ql')?$activeblockcss:'';
									$this->activeRightblockcss_quickLinks=($this->fields_arr['block']=='ql')?$activeRightblockcss:'';
								}
							if($this->CFG['admin']['musics']['allow_history_links'])
								{
									$this->activeblockcss_historyLinks=($this->fields_arr['block']=='hst')?$activeblockcss:'';
									$this->activeRightblockcss_historyLinks=($this->fields_arr['block']=='hst')?$activeRightblockcss:'';
								}
					}
			}


	}
//<<<<<-------------- Class ViewMusic begins ---------------//
$ViewMusic = new ViewMusic();
$ViewMusic->setDBObject($db);
$ViewMusic->makeGlobalize($CFG,$LANG);
if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$ViewMusic->setPageBlockNames(array('msg_form_error', 'musics_form', 'delete_confirm_form', 'get_code_form',
									'confirmation_flagged_form', 'add_comments', 'add_reply', 'edit_comment',
									'update_comment', 'rating_image_form', 'add_flag_list', 'add_fovorite_list',
									'confirmation_adult_form', 'musicMainBlock'));
$ViewMusic->setCSSFormFieldErrorTipClass('clsFormFieldErrTip');
$ViewMusic->setCSSFormLabelCellDefaultClass('clsFormLabelCellDefault');
$ViewMusic->setCSSFormFieldCellDefaultClass('clsFormFieldCellDefault');
$ViewMusic->setCSSFormLabelCellErrorClass('clsFormLabelCellError');
$ViewMusic->setCSSFormFieldCellErrorClass('clsFormFieldCellError');
//default form fields and values...
$ViewMusic->setFormField('music_id', '');
$ViewMusic->setFormField('total_downloads', '0');
$ViewMusic->setFormField('vpkey', '');
$ViewMusic->setFormField('action', '');
$ViewMusic->setFormField('comment_id', '');
$ViewMusic->setFormField('action', '');
$ViewMusic->setFormField('music_code', '');
$ViewMusic->setFormField('music_title', '');
$ViewMusic->setFormField('user_name', '');
$ViewMusic->setFormField('user_id', '');
$ViewMusic->setFormField('album_id', '');
//for ajax
$ViewMusic->setFormField('f',0);
$ViewMusic->setFormField('show','1');
$ViewMusic->setFormField('comment_id',0);
$ViewMusic->setFormField('type','');
$ViewMusic->setFormField('ajax_page','');
$ViewMusic->setFormField('paging','');
$ViewMusic->setFormField('rate', '');
$ViewMusic->setFormField('flag', '');
$ViewMusic->setFormField('page', '');
$ViewMusic->setFormField('favorite_id', '');
$ViewMusic->setFormField('music_tags', '');
$ViewMusic->setFormField('block', '');
$ViewMusic->setFormField('tags', '');
$ViewMusic->sanitizeFormInputs($_REQUEST);
$ViewMusic->setPageBlockShow('musicMainBlock');
$ViewMusic->play_list_next_url='';
$ViewMusic->is_logged_in=isLoggedIn() ;

if(isAjax())
	{
	$ViewMusic->includeAjaxHeaderSessionCheck();

		if ($ViewMusic->isPageGETed($_POST, 'show_qucik_link_text_id'))
		    {
				$ViewMusic->quickLinkMusic=$ViewMusic->populateQuickLinkMusics(true, $_POST['show_qucik_link_text_id']);

			}

		if ($ViewMusic->isPageGETed($_POST, 'show_complete_quick_list'))
		    {
				$ViewMusic->quickLinkMusic=$ViewMusic->populateQuickLinkMusics($limit=false);
			}
		if ($ViewMusic->isPageGETed($_POST, 'show_complete_history_list'))
		    {
				$ViewMusic->historyMusics=$ViewMusic->populateQuickLinkHistoryMusics($limit=false);
			}

setTemplateFolder('members/','music');
$smartyObj->display('myDashBoard.tpl');
$ViewMusic->includeAjaxFooter();

	}


//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//

$LANG['mydashboard_meta_keywords']=str_replace('VAR_DEFAULT_TAGS', $CFG['html']['meta']['keywords'], $LANG['mydashboard_meta_keywords']);
$LANG['mydashboard_meta_keywords']=str_replace('VAR_TAGS', $ViewMusic->getFormField('music_tags'), $LANG['mydashboard_meta_keywords']);
$LANG['mydashboard_meta_title']=str_replace('VAR_SITE_TITLE', $CFG['site']['title'], $LANG['mydashboard_meta_title']);
$LANG['mydashboard_meta_title']=str_replace('VAR_TITLE', $ViewMusic->getFormField('music_title'), $LANG['mydashboard_meta_title']);
$LANG['mydashboard_meta_title']=str_replace('VAR_MODULE', $LANG['window_title_music'], $LANG['mydashboard_meta_title']);
$LANG['mydashboard_meta_description']=str_replace('VAR_DEFAULT_TAGS', $CFG['html']['meta']['keywords'], $LANG['mydashboard_meta_description']);
$LANG['mydashboard_meta_description']=str_replace('VAR_TAGS', $ViewMusic->getFormField('music_tags'), $LANG['mydashboard_meta_description']);

setPageTitle($LANG['mydashboard_meta_title']);
setMetaKeywords($LANG['mydashboard_meta_keywords']);
setMetaDescription($LANG['mydashboard_meta_description']);

$LANG['mydash_board_title']=($ViewMusic->getFormField('block')=='hst')?$LANG['mydashboard_type_history_link']:$LANG['mydash_board_title'];

$field_names_arr=array('tags');
$ViewMusic->showSearchBlock($field_names_arr);
if($ViewMusic->getFormField('block')=='ql')
{
	if(isLoggedIn() and $ViewMusic->CFG['admin']['musics']['allow_quick_mixs'])
		$ViewMusic->quickLinkMusic=$ViewMusic->populateQuickLinkMusics();
}
else if ($ViewMusic->getFormField('block')=='hst' and isLoggedIn() and $CFG['admin']['musics']['allow_history_links'])
{
	$ViewMusic->historyMusics=$ViewMusic->populateQuickLinkHistoryMusics();
}
else
{
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
}

//include the header file
$ViewMusic->includeHeader();
//include the content of the page
setTemplateFolder('members/','music');
$smartyObj->display('myDashBoard.tpl');
?>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/functions.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/functions.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/AG_ajax_html.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/viewVideo.js"></script>
<script language="javascript">
var vLoader = 'loaderMusics';
var homeUrl = '<?php echo getUrl('mydashboard','?block=ql','?block=ql','','music');?>';
var disPrevButton = 'disabledPrevButton';
var disNextButton = 'disabledNextButton';
var pars= 'vLeft=&vFetch=';
var currUrl = '<?php echo getUrl('mydashboard','?block=hdt','?block=hst','','music');?>';

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
	function updateMusicsQuickLinksCount(music_id, pg)
		{
			var url = '<?php echo $CFG['site']['music_url'];?>musicUpdateQuickLinks.php';
			var pars = '?music_id='+music_id;
			var path=url+pars;
			curr_side_bar_pg=pg;
			curr_music_id=music_id;
			new prototype_ajax(path,'getQuickLinkCode');
			return false;
		}

	function getQuickLinkCode(data)
		{
			if(obj = document.getElementById('quick_mix_tag_'+curr_music_id))
				obj.innerHTML = '<?php echo $LANG['add_to_quick_mixs_added'] ?>';
			if(obj = document.getElementById('quick_mix_user_'+curr_music_id))
				obj.innerHTML = '<?php echo $LANG['add_to_quick_mixs_added'] ?>';
			if(obj = document.getElementById('quick_mix_top_'+curr_music_id))
				obj.innerHTML = '<?php echo $LANG['add_to_quick_mixs_added'] ?>';

			if($('selQuickList'))
				addBlocksForQuickLinks();
				else
					moreMusicsQuickList();
		}

	function deleteMusicQuickLinks(music_id)
		{
			var url = '<?php echo $CFG['site']['music_url']?>musicUpdateQuickLinks.php';
			var pars = '?music_id='+music_id+'&remove_it';
			var path=url+pars;
			curr_sel_music_id=music_id;
			new AG_ajax(path,'hideQuickMixCode');
		}

	function hideQuickMixCode(data)
		{
			hideDiv('quick_list_selected_'+curr_sel_music_id);
			removeElement('quick_list_selected_'+curr_sel_music_id);
		}

	function deleteMusicQuickHistoryLinks(music_id)
		{
			var url = '<?php echo $CFG['site']['url'].'music/';?>musicUpdateQuickHistoryLinks.php';
			var pars = '?music_id='+music_id+'&remove_it';
			var path=url+pars;
			curr_sel_music_id=music_id;
			new AG_ajax(path,'hideQuickLinkCode');
		}

	function removeElement(divNum)
		{
		  var d = document.getElementById('selQuickList');
		  var olddiv = document.getElementById(divNum);
		  d.removeChild(olddiv);
		}

	function addBlocksForQuickLinks()
		{
			new Ajax.Request(currUrl, {method:'post',parameters:'&ajax_page=1&show_qucik_link_text_id='+curr_music_id, onComplete:refreshQucikLinkBlockTag});
		}

	function refreshQucikLinkBlockTag(resp)
		{
			data = resp.responseText;
			if(data.indexOf(session_check)>=1)
				{
					data = data.replace(session_check_replace,'');
				}
			else
				{
					return;
				}
			$('selQuickList').innerHTML +=data;
		}

	function moreMusicsQuickList()
		{
			new Ajax.Request(currUrl, {method:'post',parameters:'&ajax_page=1&show_complete_quick_list=1', onComplete:refreshQucikLinkBlockTagAll});
		}


	function refreshQucikLinkBlockTagAll(resp)
		{
			data = resp.responseText;
			if(data.indexOf(session_check)>=1)
				{
					data = data.replace(session_check_replace,'');
				}
			else
				{
					return;
				}

			$('selMusicQuickLinks').innerHTML = data;
			new AG_ajax(path,'hideQuickLinkCode');
		}

	function moreMusicsQuickHistoryList()
		{
			new Ajax.Request(currUrl, {method:'post',parameters:'&ajax_page=1&show_complete_history_list=1', onComplete:refreshHistoryLinkBlockTagAll});
		}

	function refreshHistoryLinkBlockTagAll(resp)
		{
			data = resp.responseText;
			if(data.indexOf(session_check)>=1)
				{
					data = data.replace(session_check_replace,'');
				}
			else
				{
					return;
				}

			$('selMusicHistoryLinks').innerHTML = data;
			//new AG_ajax(path,'hideQuickLinkCode');
		}

	function toggleOnViewClearQuickList(obj)
		{

			var url = '<?php echo $CFG['site']['music_url'];?>musicUpdateQuickLinks.php';
			if(obj.checked)
				var pars = '?clear_on_view=1';
				else
					var pars = '?clear_on_view=0';
			var path=url+pars;
			new AG_ajax(path,'setToggleQuickList');
		}

	function clearQuickHistoryLinks()
		{
			var url = '<?php echo $CFG['site']['music_url'];?>musicUpdateQuickHistoryLinks.php';
			var pars = '?clear_list=1';
			var path=url+pars;
			//alert(path);
			new AG_ajax(path,'setQuickHistoryClearList');
		}

	function setQuickHistoryClearList(resp)
		{
			$('selMusicHistoryLinks').innerHTML='<div id="selMsgSuccess"><p><?php echo $LANG['histroyLinks_remove_msg'];?></p></div>';
		}

	function clearQuickMixs()
		{
			var url = '<?php echo $CFG['site']['music_url'];?>musicUpdateQuickLinks.php';
			var pars = '?clear_list=1';
			var path=url+pars;
			//alert(path);
			new prototype_ajax(path,'setQuickClearList');
		}

	function setQuickClearList(resp)
		{
			$('selVideoQuickLinks').innerHTML='';
			$('selMsg').style.display='block';

		}

	function setToggleQuickList(resp)
		{
			return true;
		}

</script>
<?php
$ViewMusic->includeFooter();
?>