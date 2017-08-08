<?php
//-------------------------class MemberListHandler-------------------->>>
/*
 *
 * @category	Rayzz
 * @package		Members
 * @author 		vijayanand39ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		Release: @package_version@
 * @since 		2006-05-01
 */
class MemberListHandler extends MediaHandler
	{
		private $showPageNavigationLinks = false;
		private $browseTitle = '';
		public $relatedTags  = array();
		public $currentPageUrl = '';

		/**
		 * MemberListHandler::makeGlobalize()
		 *
		 * @param array $cfg
		 * @param array $lang
		 * @return
		 */
		public function makeGlobalize($cfg=array(), $lang=array())
			{
				parent::makeGlobalize($cfg, $lang);
				$url = getUrl('memberslist');
				$this->tagListUrl = $url;
				$this->setPageUrl($url);
			}

		/**
		 * MemberListHandler::setPageUrl()
		 *
		 * @param mixed $url
		 * @return
		 */
		public function setPageUrl($url)
			{
				$this->currentPageUrl = $url;
			}

		/**
		 * MemberListHandler::getPageUrl()
		 *
		 * @return
		 */
		public function getPageUrl()
			{
				return $this->currentPageUrl;
			}

		/**
		 * MemberListHandler::getUserProfileTagSet()
		 *
		 * @param string $tags
		 * @param string $query_tag
		 * @return
		 */
		public function getUserProfileTagSet($tags = '', $query_tag='')
			{
				$url = $this->tagListUrl;
				if(empty($tags))
					{
						return false;
					}
				$tags_arr = array();
			    $inc = 0;
				if ($tags = $this->_parse_tags_member($tags))
				    {
				        foreach($tags as $key=>$value)
							{
								$value = strtolower($value);
								if (!in_array($value, $query_tag) AND !in_array($value, $this->relatedTags))
								    {
										$this->relatedTags[] = $value;
								    }

							  	$tags_arr[$inc]['tags']= $value;
							  	$inc++;
							}
				    }
				return $tags_arr;
			}

		/**
		 * MemberListHandler::getCurrentUserOnlineStatus()
		 *
		 * @param string $privacy
		 * @param string $status_msg_id
		 * @return
		 */
		public function getCurrentUserOnlineStatus($privacy='', $status_msg_id='')
			{
				$currentStatus = $this->LANG['members_list_online_status_default'];
				$Online = $Offline = $Custom = false;
				if ($privacy)
				    {
				        $$privacy = true;
				    }
				if ($Online)
				    {
						$currentStatus = $this->LANG['members_list_online_status_online'];
				    }
				elseif($Offline)
					{
						$currentStatus = $this->LANG['members_list_online_status_offline'];
					}
				elseif($Custom AND $status_msg_id)
					{
						$sql = 'SELECT message FROM '.$this->CFG['db']['tbl']['users_status_messages'].
								' WHERE status_msg_id='.$this->dbObj->Param($status_msg_id);

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($status_msg_id));
						if (!$rs)
							trigger_db_error($this->dbObj);

						if ($rs->PO_RecordCount())
							{
								$row = $rs->FetchRow();
								$currentStatus = $row['message'];
								$rs->Free();
						    }
					}
				return $currentStatus;
			}

        /**
        * Displays all members with their profile icon
        *
        * @return void
		* @access public
        **/
		public function displayMembers()
			{
			    global $LANG_LIST_ARR;
				$usersPerRow = $this->CFG['admin']['members_list']['cols'];
				$count = 0;
				$found = false;
				$browse = $this->getFormField('browse');
				$tagSearch = $this->getFormField('tags');
				$tagSearch = (!empty($tagSearch));
				$this->listDetails =  true;//((strcmp($browse, 'viewAllMembers')==0) OR $tagSearch);
				$this->friendsCount = true;//(strcmp($browse, 'maleMostFriends')==0 OR strcmp($browse, 'femaleMostFriends')==0);
				$this->profileHits  = (strcmp($browse, 'maleMostViewed')==0 OR strcmp($browse, 'femaleMostViewed')==0);
				$videoCount = chkAllowedModule(array('video'));

				$showVideoIcon = $this->CFG['admin']['members_listing']['video_icon'];
				$query_tag = $this->_parse_tags_member(strtolower($this->fields_arr['tags']));
				$showOnlineIcon = $this->CFG['admin']['members_listing']['online_icon'];
				$showOnlineStatus = $this->CFG['admin']['members_listing']['online_status'];
				$rank = $this->fields_arr['start']+1;

				$member_list_arr = array();
				$inc = 0;
				while($row = $this->fetchResultRecord())
				    {
						$found = true;
						if(isMember())
							{
								$member_list_arr[$inc]['friend'] = '';
								$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['friends_list'].
										' WHERE (friend_id='.$this->dbObj->Param('friend_id1').
										' AND owner_id='.$this->dbObj->Param('owner_id1').')';
								$fields_val_arr = array($row['user_id'], $this->CFG['user']['user_id']);

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $fields_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								if ($rs->PO_RecordCount())
									{
										$member_list_arr[$inc]['friend'] = 'yes';
								    }
							}
						$member_list_arr[$inc]['memberProfileUrl'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
						$joined = 0;
						$member_list_arr[$inc]['profileIcon']= getMemberAvatarDetails($row['user_id']);
						$member_list_arr[$inc]['online'] = $this->CFG['admin']['members']['offline_anchor_attributes'];
						$member_list_arr[$inc]['currentStatus'] = $this->LANG['members_list_offline_status_default'];
						$member_list_arr[$inc]['onlineStatusClass'] = 'memListUserStatusOffline';
						$member_list_arr[$inc]['open_tr'] = false;
						if ($showOnlineIcon AND $row['logged_in_currently'])
						    {
						        $member_list_arr[$inc]['currentStatus'] = $this->getCurrentUserOnlineStatus($row['privacy'], $row['status_msg_id']);
								$onlineAnchorAttr = $this->CFG['admin']['members']['online_anchor_attributes'];
								$member_list_arr[$inc]['online'] = str_replace('{online_status}', $member_list_arr[$inc]['currentStatus'], $onlineAnchorAttr);
								if($member_list_arr[$inc]['currentStatus']!='Offline')
									{
										$member_list_arr[$inc]['onlineStatusClass'] = 'memListUserStatusOnline';
									}
						    }

						if ($count%$usersPerRow==0)
						    {
						    	$member_list_arr[$inc]['open_tr'] = true;
						    }
						$member_list_arr[$inc]['userLink']= '';
						//To display stats in images
						foreach ($this->CFG['site']['modules_arr'] as $key=>$value)
					    	{
					    		$member_list_arr[$inc][$value.'ListUrl'] = '';
								if(chkAllowedModule(array(strtolower($value))))
									{
										$image_url1 = $this->CFG['site']['project_path'].'design/templates/'.$this->CFG['html']['template']['default'].'/images/'.$value.'_icon_mini.jpg';
										$image_url2 = $this->CFG['site']['project_path'].'design/templates/'.$this->CFG['html']['template']['default'].'/images/'.$value.'_no_icon_mini.jpg';
										$member_list_arr[$inc][$value.'_image1_exists'] = false;
										if(is_file($image_url1))
											$member_list_arr[$inc][$value.'_image1_exists'] = true;

										$member_list_arr[$inc][$value.'_image2_exists'] = false;
										if(is_file($image_url2))
											$member_list_arr[$inc][$value.'_image2_exists'] = true;
											if ($value == 'blog') {
												$function_name = 'getTotalUsersPosts';
											}
											else
												$function_name = 'getTotalUsers'.ucfirst($value).'s';
										if(function_exists($function_name))
											{
												$stats = $function_name($row['user_id'],1);
												$member_fulldetails_arr[$inc]['total_'.strtolower($value).'s'] = $stats;
												$member_list_arr[$inc]['total_'.strtolower($value).'s'] = $stats;
												$member_list_arr[$inc][$value.'_icon_title'] = sprintf($this->CFG['admin']['members'][$value.'_icon_title'], $stats);
												if ($value == 'discussions') {
													$member_list_arr[$inc][$value.'ListUrl'] = getUrl($value,'?pg=user'.$value.'list&user_id='.$row['user_id'], 'user'.$value.'list/?user_id='.$row['user_id'],'',$value);
												}
												else
													$member_list_arr[$inc][$value.'ListUrl'] = getUrl($value.'list','?pg=user'.$value.'list&user_id='.$row['user_id'], 'user'.$value.'list/?user_id='.$row['user_id'],'',$value);
											}
									}
							}
						$member_list_arr[$inc]['record'] = $row;
						//To display stats in text
						if($this->stats_display_as_text && $this->CFG['admin']['members_list']['stats_display_as_text'])
							{
								//uses home page setting variable
								$stats_module = $this->CFG['admin']['site_home_page'];
								$member_list_arr[$inc]['stats_text_val'] = false;
								if(chkAllowedModule(array($stats_module)))
									{
										$member_list_arr[$inc]['stats_text_val'] = true;
										$member_list_arr[$inc]['stats_text'] = array();
										$default_text_function_name = 'getTotal'.ucfirst($stats_module).'s';
										$total_stats = 0;
										if(function_exists($default_text_function_name))
											{
												$total_stats = $default_text_function_name($row['user_id']);
												$member_list_arr[$inc]['stats_text']['total_stats'] = $total_stats;
								              	$member_list_arr[$inc]['stats_text']['lang_list'] = $this->LANG['profile_list_'.$stats_module.'s'];
								              	$member_list_arr[$inc]['stats_text']['list_url'] = '';
								              	$member_list_arr[$inc]['stats_text']['icon_title'] = '';
								            }
										if ($total_stats > 0)
											{
												$member_list_arr[$inc]['stats_text']['icon_title'] = sprintf($this->CFG['admin']['members'][$stats_module.'_icon_title'], $total_stats);
						                     	if ($value == 'discussions')
						                     		$member_list_arr[$inc]['stats_text']['list_url'] = getUrl($stats_module,'?pg=user'.$stats_module.'list&user_id='.$row['user_id'], 'user'.$stats_module.'list/?user_id='.$row['user_id'], '' ,$stats_module);
												else
												 	$member_list_arr[$inc]['stats_text']['list_url'] = getUrl($stats_module.'list','?pg=user'.$stats_module.'list&user_id='.$row['user_id'], 'user'.$stats_module.'list/?user_id='.$row['user_id'], '' ,$stats_module);
											}

									}
							}

						$member_list_arr[$inc]['about_me'] = wordWrap_mb_ManualWithSpace(strip_tags($row['about_me']),
																$this->CFG['admin']['members_list']['about_me_length'],
																$this->CFG['admin']['members_list']['about_me_total_length']);
						$member_list_arr[$inc]['friend_icon_title'] = sprintf($this->CFG['admin']['members']['friend_icon_title'], $row['total_friends']);
						$member_list_arr[$inc]['viewfriendsUrl'] = getUrl('viewfriends','?user='.$row['user_name'], $row['user_name'].'/');
						$member_list_arr[$inc]['mailComposeUrl'] = getUrl('mailcompose','?mcomp='.$row['user_name'],'?mcomp='.$row['user_name'], 'members');
						$member_list_arr[$inc]['friendAddUrl'] = getUrl('friendadd','?friend='.$row['user_id'],'?friend='.$row['user_id'], 'members');
						$member_list_arr[$inc]['friendAddUrlLinkId'] = 'friendadd'.$row['user_id'];
						$member_list_arr[$inc]['mailComposeUrlLinkId'] = 'mailcompose'.$row['user_id'];
						$member_list_arr[$inc]['country'] = isset($LANG_LIST_ARR['countries'][$row['country']])?$LANG_LIST_ARR['countries'][$row['country']]:'';
						$member_list_arr[$inc]['last_logged'] =($row['last_logged']!='')?$row['last_logged']:$this->LANG['members_list_member_first_login'];

						$member_list_arr[$inc]['mostActiveUsers'] = false;
						if($this->fields_arr['browse']=='mostActiveUsers' and chkAllowedModule(array('video')))
							{
							   $member_list_arr[$inc]['mostActiveUsers'] = true;
							   $member_list_arr[$inc]['percentage']=round($row['percentage'], 2);
							   $member_list_arr[$inc]['rank']=$rank;
							   $rank++;
							}
						$member_list_arr[$inc]['viewedusers'] = false;
						if($this->fields_arr['browse']=='viewedusers')
							{
							   $member_list_arr[$inc]['viewedusers'] = true;
							   $member_list_arr[$inc]['total_viewed_str']=str_replace('VAR_TOTAL_VIEWS', $row['total_views'], $this->LANG['members_profile_hits_msg']);
							}
						$member_list_arr[$inc]['UserProfileTag_arr']=$this->getUserProfileTagSet($row['profile_tags'], $query_tag);
						$member_list_arr[$inc]['end_tr'] = false;
						$count++;
						if ($count%$usersPerRow==0)
						    {
								$count = 0;
								$member_list_arr[$inc]['end_tr'] = true;
						    }
						$inc++;
					}// while
				$this->last_tr_close = false;
				if ($found and $count and $count<$usersPerRow)
					{
					 	$this->last_tr_close  = true;
					 	$this->user_per_row=$usersPerRow-$count;
					}
				return $member_list_arr;
			}

		/**
		 * MemberListHandler::buildSortQuery()
		 *
		 * @return void
		 */
		public function buildSortQuery()
			{
				//$this->sql_sort .= ',doj DESC ';
			}

		/**
		 * MemberListHandler::membersRelRayzz()
		 *
		 * @param mixed $row
		 * @return void
		 */
		public function membersRelRayzz($row)
			{
				membersRelRayzz($row);
			}

		/**
		 * MemberListHandler::getMostViewedExtraQuery()
		 *
		 * @return string
		 */
		public function getMostViewedExtraQuery()
			{
				/*action*/
				//1 = today
				//2 = yesterday
				//3 = this week
				//4 = this month
				//5 = this year
				$extra_query = '';
				switch($this->fields_arr['action'])
					{
						case 1:
							$extra_query = ' AND DATE_FORMAT(vv.view_date,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
							break;

						case 2:
							$extra_query = ' AND DATE_FORMAT(vv.view_date,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
							break;

						case 3:
							$extra_query = ' AND DATE_FORMAT(vv.view_date,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
							break;

						case 4:
							$extra_query = ' AND DATE_FORMAT(vv.view_date,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
							break;

						case 5:
							$extra_query = ' AND DATE_FORMAT(vv.view_date,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
							break;
					}
				return $extra_query;
			}

		/**
		 * MemberListHandler::getTotalViews()
		 *
		 * @return
		 */
		public function getTotalViews()
			{
				//return 1000;
				$sql = 'SELECT COUNT(*) AS total_views FROM '.$this->CFG['db']['tbl']['video_viewed'].
						' AS vv WHERE 1'.$this->getMostViewedExtraQuery();

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					return $row['total_views'];

				return 0;
			}

		/**
		 * MemberListHandler::getTotalGuestViews()
		 *
		 * @return
		 */
		public function getTotalGuestViews()
			{
				//return 1000;
				$sql = 'SELECT total_views FROM '.$this->CFG['db']['tbl']['users_views'].
						' AS vv WHERE user_id = '.$this->dbObj->Param($this->fields_arr['user_id']).
						' AND viewed_user_id=\'0\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					return $row['total_views'];

				return 0;
			}

		/**
		 * MemberListHandler::buildConditionQuery()
		 *
		 * @return
		 */
		public function buildConditionQuery()
			{
				$this->sql_condition = 'usr_status=\'Ok\' ';
				$this->sql_sort = '';
				$browse  = $this->getFormField('browse');
				$browseOptions = array('maleMostFriends', 'femaleMostFriends', 'maleMostViewed', 'femaleMostViewed');

				if (strcmp($browse, 'maleMostFriends') == 0 )
					{
				        $this->sql_condition .= ' AND sex=\'male\' AND total_friends > 0';
						$this->sql_sort = '  total_friends DESC, doj DESC ';
						$this->browseTitle = $this->LANG['members_title_nav_male_most_friends'];
				    }
				else if (strcmp($browse, 'femaleMostFriends') == 0 )
			        {
				        $this->sql_condition .= ' AND sex=\'female\' AND total_friends > 0';
						$this->sql_sort .= ' total_friends DESC ';
						$this->browseTitle = $this->LANG['members_title_nav_female_most_friends'];
			        }
				else if (strcmp($browse, 'maleMostViewed') == 0 )
			        {
				        $this->sql_condition .= ' AND sex=\'male\' AND profile_hits > 0  ';
						$this->sql_sort = ' profile_hits DESC, doj DESC ';
						$this->browseTitle = $this->LANG['members_title_nav_male_most_viewed'];
			        }
				else if( strcmp($browse, 'femaleMostViewed') == 0 )
			        {
				        $this->sql_condition .= ' AND sex=\'female\' AND profile_hits > 0 ';
						$this->sql_sort = ' profile_hits DESC, doj DESC ';
						$this->browseTitle = $this->LANG['members_title_nav_female_most_viewed'];
			        }
				else if( strcmp($browse, 'recentMembers') == 0 )
			    	{
					  	//$this->sql_condition .= ' AND DATE_FORMAT(doj, \'%Y-%m-%d\') >= DATE_SUB(\''.gmdate("Y-m-d").'\', INTERVAL 7 DAY) ';
						$this->sql_condition .= '';
						$this->sql_sort = ' user_id DESC ';
						$this->browseTitle = $this->LANG['members_title_nav_recent_members'];
			        }
				else if( strcmp($browse, 'onlineMembers') == 0 )
			        {
					 	$this->sql_condition .= ' AND (logged_in=\'1\'  AND DATE_SUB(NOW(), INTERVAL 20 SECOND) < last_active) AND user_id !='.$this->CFG['user']['user_id'];
						$this->sql_sort = ' user_id DESC ';
						$this->browseTitle = $this->LANG['members_title_nav_online_members'];
						$this->showPageNavigationLinks = true;
			        }
				else if( strcmp($browse, 'mostActiveUsers') == 0 and chkAllowedModule(array('video')))
					{
						$total_views = $this->getTotalViews();
						$this->setTableNames(array($this->CFG['db']['tbl']['video_viewed'].' AS vv LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON u.user_id=vv.video_owner_id'));
						$this->setReturnColumns(array('u.user_id', 'u.user_name', 'u.about_me', 'total_videos', 'total_musics', 'total_photos', 'icon_id', 'icon_type', 'u.image_ext', 'doj', 'profile_hits', 'total_friends', 'logged_in', 'logged_in_currently', 'privacy', 'status_msg_id','sex', 'tag_match', 'profile_tags', 'COUNT(*) AS total_view', 'video_owner_id', 'COUNT(*)/'.$total_views.'*100 AS percentage'));
						$this->sql_condition = 'usr_status=\'Ok\''.$this->getMostViewedExtraQuery().' GROUP BY video_owner_id';
						$this->sql_sort = 'percentage DESC';
						$this->browseTitle = $this->LANG['members_title_most_active_users'];
						$this->showPageNavigationLinks = true;
					}
				else if( strcmp($browse, 'viewedusers') == 0 and $this->fields_arr['user_id'] and chkAllowedModule(array('video')))
					{
						$total_views = $this->getTotalViews();
						$this->setTableNames(array($this->CFG['db']['tbl']['users_views'].' AS vv LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON u.user_id=vv.viewed_user_id'));
						$this->setReturnColumns(array('u.user_id', 'u.user_name', 'u.about_me', 'u.total_videos', 'vv.total_views', 'vv.user_id curr_user_id', 'last_viewed_date', 'total_musics', 'total_photos', 'icon_id', 'icon_type', 'u.image_ext','doj', 'profile_hits', 'total_friends', 'logged_in', 'logged_in_currently', 'privacy', 'status_msg_id','sex', 'tag_match', 'profile_tags', 'COUNT(*) AS total_view', 'COUNT(*)/'.$total_views.'*100 AS percentage'));
						$this->sql_condition = 'usr_status=\'Ok\' AND vv.user_id=\''.$this->fields_arr['user_id'].'\' '.$this->getMostViewedExtraQuery().' GROUP BY vv.user_id ';
						$this->sql_sort = ' total_views DESC ';
						$this->browseTitle = str_replace('VAR_USER_NAME',$this->user_name,$this->LANG['members_profile_hits_list_members']);
						if($this->fields_arr['user_id']==$this->CFG['user']['user_id'])
							$this->browseTitle = str_replace('VAR_USER_NAME',$this->LANG['members_profile_hits_list_members_your_msg'],$this->LANG['members_profile_hits_list_members']);
						if($total_guest_views=$this->getTotalGuestViews())
							$this->browseTitle .= '<p>'.$total_guest_views.' '.$this->LANG['members_profile_hits_list_nt_logged_users'].'</p>';
						$this->showPageNavigationLinks = true;
					}
				else if( strcmp($browse, 'referrals') == 0  and $this->isMember())
					{
						$this->sql_condition .= ' AND referrer_id=\''.$this->CFG['user']['user_id'].'\'';
						$this->sql_sort = ' user_id DESC ';
						$this->browseTitle = $this->LANG['members_title_nav_referrals'];
					}
				else
					{
						$this->sql_condition .= '';
						$this->buildExtraConditionQuery();
						//$this->sql_sort .= ' doj DESC ';
						$this->browseTitle = $this->LANG['members_nav_list_members'];
						$this->showPageNavigationLinks = true;
						$this->setFormField('browse', 'viewAllMembers');
					}
			}

		/**
		* MemberListHandler::buildExtraConditionQuery()
		*
		* @return void
		*/
		public function buildExtraConditionQuery()
			{
				//$this->sql_condition = 'u.user_id<>'.$this->CFG['user']['user_id'].' AND u.usr_status=\'Ok\'';
				if (!$this->isEmpty($this->fields_arr['uname']) AND
						strcmp($this->fields_arr['uname'], $this->LANG['search_uname_tag']) != 0)
				    {
						$this->sql_condition .= 'AND (user_name LIKE \'%'.addslashes($this->fields_arr['uname']).'%\' OR '.getSearchRegularExpressionQueryModified($this->fields_arr['uname'], 'profile_tags', '').')';
						$this->linkFieldsArray[] = 'uname';
				    }
				if (!$this->isEmpty($this->fields_arr['ucity']) AND
						strcmp($this->fields_arr['ucity'], $this->LANG['search_ucity']) != 0)
				    {
						$this->sql_condition .= 'AND city LIKE \'%'.addslashes($this->fields_arr['ucity']).'%\' ';
						$this->linkFieldsArray[] = 'ucity';
				    }
				if (!$this->isEmpty($this->fields_arr['uhometown']) AND
						strcmp($this->fields_arr['uhometown'], $this->LANG['search_uhometown']) != 0)
				    {
						$this->sql_condition .= 'AND hometown LIKE \'%'.addslashes($this->fields_arr['uhometown']).'%\' ';
						$this->linkFieldsArray[] = 'uhometown';
				    }
				if (!$this->isEmpty($this->fields_arr['sex'] AND
						strcmp($this->fields_arr['sex'], $this->LANG['members_search_sex']) != 0))
				    {
						$this->sql_condition .= 'AND sex=\''.addslashes($this->fields_arr['sex']).'\' ';
						$this->linkFieldsArray[] = 'sex';
				    }

				if (!$this->isEmpty($this->fields_arr['country']))
				    {
						$this->sql_condition .= 'AND country=\''.addslashes($this->fields_arr['country']).'\' ';
						$this->linkFieldsArray[] = 'country';
				    }
			}

		/**
		 * MemberListHandler::getDurationSelectionOption()
		 *
		 * @return
		 */
		public function getDurationSelectionOption()
			{
  				$doj = '%s';
				$durOption = array('YEAR', 'MONTH', 'WEEK', 'DAY', 'HOUR', 'MINUTE', 'SECOND');
  				for ($i=0; $i<sizeof($durOption); $i++)
  					{
  						$option  = 'IF (TIMESTAMPDIFF('.$durOption[$i].',doj, NOW())>0,CONCAT( TIMESTAMPDIFF('.$durOption[$i].',doj, NOW())," '.$durOption[$i].'"),%s)';
  						$doj = sprintf($doj, $option);
  					}
  				$doj = sprintf($doj, 0);
				die($doj);				//Check it out..
			}

		/**
		 * MemberListHandler::getMyFriends()
		 *
		 * @return
		 */
		public function getMyFriends()
			{
				$currentUserId = $this->CFG['user']['user_id'];
				$friends = array();
				if ($currentUserId)
				    {
						$sql = 'SELECT friend_id as myFriend FROM '.$this->CFG['db']['tbl']['friends_list'].
								' WHERE owner_id='.$this->dbObj->Param($currentUserId);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($currentUserId));
						if (!$rs)
							trigger_db_error($this->dbObj);

						if ($rs->PO_RecordCount())
							{
								while($row = $rs->FetchRow())
								    {
										$friends[] = $row['myFriend'];
								    } // while
							}
				    }
				return $friends;
			}

		/**
		 * MemberListHandler::buildTagSearchQuery()
		 *
		 * @return
		 */
		public function buildTagSearchQuery()
			{
				$this->sql_condition = 'usr_status=\'Ok\'';
				$this->sql_sort = '';

				if (!$this->isEmpty($this->fields_arr['tags']))
				    {
						$this->sql_condition .= ' AND ('.getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'profile_tags', '').' OR (user_name LIKE \'%'.addslashes($this->fields_arr['tags']).'%\'))';
						$this->linkFieldsArray[] = 'tags';
				    }
				$this->browseTitle = str_replace('VAR_TAGS_NAME',$this->fields_arr['tags'],$this->LANG['members_title_tag_search']);
			}

		/**
		 * MemberListHandler::getPageTitle()
		 *
		 * @return
		 */
		public function getPageTitle()
			{
				return $this->browseTitle;
			}

		/**
		 * MemberListHandler::isAllowNavigationLinks()
		 *
		 * @return
		 */
		public function isAllowNavigationLinks()
			{
				return ($this->showPageNavigationLinks);
			}

		/**
		 * MemberListHandler::isEmpty()
		 *
		 * @param mixed $value
		 * @return
		 */
		public function isEmpty($value)
			{
				$is_not_empty = is_string($value)?trim($value)=='':empty($value);
				return $is_not_empty;
			}

		/**
		 * MemberListHandler::_parse_tags_member()
		 *
		 * _parse_tages_member name changed from _parse_tages.(Strict Standards error occures when
		 * not chenage this modification. this method name alredy used in parent class so that
		 * the strict error occurs)
		 *
		 * @param mixed $tag_string
		 * @return
		 */
		public function _parse_tags_member($tag_string)
			{
				$newwords = array();
				$tag_string = trim($tag_string);

				if ($tag_string == '') {
					// If the tag string is empty, return the empty set.
					return $newwords;
				}
				# Perform tag parsing
				$query = $tag_string;
				if(get_magic_quotes_gpc()) {
					$query = stripslashes($tag_string);
				}
				$words = preg_split('/(")/', $query,-1,PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);

				$delim = 0;
				foreach ($words as $key => $word)
					{
						if ($word == '"') {
							$delim++;
							continue;
						}

						if (($delim % 2 == 1) && $words[$key - 1] == '"') {
							if((strlen($word)<$this->CFG['admin']['tag_minimum_size']) or (strlen($word)>$this->CFG['admin']['tag_maximum_size']))
							    {
							        continue;
							    }
							$newwords[] = $word;
						} else {
							if((strlen($word)<$this->CFG['admin']['tag_minimum_size']) or (strlen($word)>$this->CFG['admin']['tag_maximum_size']))
							    {
							        continue;
							    }
							$newwords = array_merge($newwords, preg_split('/\s+/', $word, -1, PREG_SPLIT_NO_EMPTY));
						}
					}
				if ($newwords)
				    {
						$temp = array();
				        foreach($newwords as $key=>$value)
							{
								if (strlen($value)>3)
								    {
										$temp[] = $value;
								    }
							}
						$newwords = $temp;
				    }
				return $newwords;
			}

		/**
		 * MemberListHandler::showRelatedTags()
		 *
		 * @return
		 */
		public function showRelatedTags()
			{
				$relatedTags = $this->relatedTags;
				$url = $this->tagListUrl;
				$tags_arr = array();
				$inc = 0;

				if (is_array($relatedTags) and $relatedTags )
				    {
				        foreach($relatedTags as $key=>$value)
							{
								if((strlen($value)<$this->CFG['admin']['tag_minimum_size']) or (strlen($value)>$this->CFG['admin']['tag_maximum_size']))
								    {
								        continue;
								    }

							 	 $tags_arr[$inc]['tags']=$value;
							 	 $inc++;
							}
				    }
				 return $tags_arr;
			}

		/**
		 * MemberListHandler::chkIsValidUser()
		 *
		 * @param string $user_id
		 * @return
		 */
		public function chkIsValidUser($user_id='')
			{
				$sql = 'SELECT user_name FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_id='.$this->dbObj->Param($user_id).
						' AND usr_status=\'Ok\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = array();
				$this->isValidUser = ($rs->PO_RecordCount() > 0);
	    		if($row = $rs->FetchRow())
					$this->user_name=$row['user_name'];
				return $this->isValidUser;
			}

		/**
		 * MemberListHandler::populateMoreBrowseMembersLinks()
		 *
		 * @return
		 */
		public function populateMoreBrowseMembersLinks()
			{
				global $smartyObj;
				$populateMoreBrowseMembersLinks_arr = array();

				$populateMoreBrowseMembersLinks_arr['maleMostFriends'] = $this->LANG['header_nav_members_male_with_most_friends'];
				$populateMoreBrowseMembersLinks_arr['femaleMostFriends'] = $this->LANG['header_nav_members_female_with_most_friends'];
				$populateMoreBrowseMembersLinks_arr['maleMostViewed'] = $this->LANG['header_nav_members_most_viewed_male'];
				$populateMoreBrowseMembersLinks_arr['femaleMostViewed'] = $this->LANG['header_nav_members_most_viewed_female'];
				$populateMoreBrowseMembersLinks_arr['recentMembers'] = $this->LANG['header_nav_members_recent_members'];
				$populateMoreBrowseMembersLinks_arr['onlineMembers'] = $this->LANG['header_nav_members_who_is_online'];
				$populateMoreBrowseMembersLinks_arr['viewAllMembers'] = $this->LANG['header_nav_members_view_all_members'];
				$smartyObj->assign('populateMoreBrowseMembersLinks_arr', $populateMoreBrowseMembersLinks_arr);
			}
	}
//<<<<<---------------class MemberListHandler------///
//--------------------Code begins-------------->>>>>//
$memberList = new MemberListHandler();
$browseOptions = array('maleMostFriends', 'femaleMostFriends', 'maleMostViewed', 'femaleMostViewed', 'recentMembers', 'onlineMembers');
$memberList->setPageBlockNames(array('msg_form_info', 'form_list_members'));
// To set the DB object
$memberList->setDBObject($db);
$memberList->makeGlobalize($CFG, $LANG);
$memberList->setFormField('user_id', $CFG['user']['user_id']);

$memberList->setFormField('numpg', $CFG['admin']['members_list']['num_pg']);
$memberList->setFormField('start', '0');

$memberList->setMinRecordSelectLimit(2);
$memberList->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$memberList->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$memberList->setTableNames(array($CFG['db']['tbl']['users']));
$memberList->setReturnColumns(array('user_id', 'user_name', 'about_me', 'total_videos', 'total_musics', 'total_photos','total_games',
                              'total_articles', 'icon_id', 'icon_type', 'image_ext' , 'doj', 'profile_hits', 'total_friends', 'logged_in',
							   'logged_in_currently', 'privacy', 'status_msg_id','sex', 'tag_match', 'profile_tags','age','dob','country','last_logged'));
$memberList->setFormField('browse', '');
$memberList->setFormField('user_id', '');
$memberList->setFormField('tags', '');
$memberList->setFormField('action', '');
$memberList->setFormField('uname', $LANG['search_uname_tag']);
$memberList->setFormField('sex', '');
$memberList->setFormField('ucity', $LANG['search_ucity']);
$memberList->setFormField('uhometown', $LANG['search_uhometown']);
$memberList->setFormField('country', '');
$memberList->setCountriesListArr($LANG_LIST_ARR['countries'],
									array('' => $LANG['search_country_choose'])
									);

$memberList->showRelatedTags = false;
$validuser = true;

$memberList->stats_display_as_text = true;
if(count($CFG['site']['modules_arr']) > 1)
	$memberList->stats_display_as_text = false;

$memberList->populateMoreBrowseMembersLinks();
$memberList->sanitizeFormInputs($_REQUEST);

$membersRightNavigation_arr['mostActiveUsers_0'] = $membersRightNavigation_arr['mostActiveUsers_1'] = $membersRightNavigation_arr['mostActiveUsers_2'] = $membersRightNavigation_arr['mostActiveUsers_3'] = $membersRightNavigation_arr['mostActiveUsers_4'] = $membersRightNavigation_arr['mostActiveUsers_5'] = '';

if($memberList->getFormField('browse') == 'mostActiveUsers')
	{
		if(!$memberList->getFormField('action')) $memberList->setFormField('action', '0');
		$sub_page = 'mostActiveUsers_'.$memberList->getFormField('action');
		$membersRightNavigation_arr[$sub_page] = ' class="clsActiveTabNavigation"';
	}
$smartyObj->assign('membersRightNavigation_arr', $membersRightNavigation_arr);

if($memberList->getFormField('browse')=='viewedusers')
	 $validuser=$memberList->chkIsValidUser($memberList->getFormField('user_id'));

if($validuser)
	{
		$memberList->setReturnColumnsAliases(array(
			'logged_in_currently'		=> '(logged_in=\'1\'  AND DATE_SUB(NOW(), INTERVAL 20 SECOND) < last_active)',
			'age' => 'DATE_FORMAT(NOW(), \'%Y\') - DATE_FORMAT(dob, \'%Y\') - (DATE_FORMAT(NOW(), \'00-%m-%d\') < DATE_FORMAT(dob, \'00-%m-%d\'))',
			'tag_match' => '1'
			)
		);

		$tags = $memberList->getFormField('tags');
		$tags = trim($tags);
		if ($tags)
		    {
		        $memberList->buildTagSearchQuery();
				$memberList->setReturnColumnsAliases(array(
					'logged_in_currently'		=> '(logged_in=\'1\'  AND DATE_SUB(NOW(), INTERVAL 20 SECOND) < last_active)',
					'age' => 'DATE_FORMAT(NOW(), \'%Y\') - DATE_FORMAT(dob, \'%Y\') - (DATE_FORMAT(NOW(), \'00-%m-%d\') < DATE_FORMAT(dob, \'00-%m-%d\'))',
					'tag_match' => getSearchRegularExpressionQueryModified($memberList->getFormField('tags'), 'profile_tags', '')
					)
				);
				$memberList->showRelatedTags = true;
		    }
		else
			{
				$memberList->buildConditionQuery();
				$memberList->buildSortQuery();
			}

		$memberList->buildSelectQuery();
		$memberList->buildQuery();

		$group_array = array('mostActiveUsers');
		if(in_array($memberList->getFormField('browse'), $group_array))
			$memberList->groupByExecuteQuery();
		else
			$memberList->executeQuery();

		$memberList->totalResults = $memberList->getResultsTotalNum();
		$memberList->setPageBlockShow('form_list_members');

		$start = $memberList->getFormField('start');
		$resultTotal = $memberList->getResultsTotalNum();
		if (($start > $resultTotal) OR (!is_numeric($start)))
	        {
	            $memberList->setFormField('start', intval($resultTotal / $CFG['data_tbl']['numpg'])*$CFG['data_tbl']['numpg']);
				$memberList->buildSelectQuery();
				$memberList->buildConditionQuery();
				$memberList->buildSortQuery();
				$memberList->buildQuery();
				$memberList->executeQuery();
				//$memberList->printQuery();
	        }
	}

//--------------------Page block templates begins-------------------->>>>>//
$memberList->form_list_members['page_title']=$memberList->getPageTitle();
if (isset($_SESSION['friend_request_message']) and !empty($_SESSION['friend_request_message']))
    {
        $memberList->setPageBlockShow('block_msg_form_success');
		$memberList->setCommonSuccessMsg($_SESSION['friend_request_message']);
		unset($GLOBALS['_SESSION']['friend_request_message']);
    }

if ($memberList->isShowPageBlock('form_list_members'))
	{
		$memberList->gender_arr = $LANG_LIST_ARR['gender'];
		$memberList->gender_arr = array_merge($memberList->gender_arr, array(''=>$LANG['search_sex_option_both']));

		$memberList->form_list_members['display_members'] = $memberList->displayMembers();
		$paging_arr=array('browse', 'user_id', 'action', 'uname', 'sex', 'ucity', 'uhometown', 'country');
		$smartyObj->assign('smarty_paging_list', $memberList->populatePageLinksGET($memberList->getFormField('start'), $paging_arr));

		if ($memberList->showRelatedTags)
		    {
		        $memberList->form_list_members['related_tags']=$memberList->showRelatedTags();
		    }
	}
if ($memberList->isFormPOSTed($_POST, 'search_reset'))
	{
		$memberList->setFormField('uname', $LANG['search_uname_tag']);
		$memberList->setFormField('sex', $LANG['members_search_sex']);
		$memberList->setFormField('ucity', $LANG['search_ucity']);
		$memberList->setFormField('uhometown', $LANG['search_uhometown']);
		$memberList->setFormField('country', '');
		Redirect2URL(getUrl('memberslist'));
	}

//--------------------Page block templates begins-------------------->>>>>//
//include the header file
$memberList->includeHeader();
//include the content of the page
setTemplateFolder('general/');
$smartyObj->display('membersList.tpl');
?>
<script type="text/javascript" language="javascript">
var popup_info_left_position = '<?php echo $CFG['admin'][$CFG['html']['template']['default']]['members_list_popupinfo_left']; ?>';
var popup_info_top_position = '<?php echo $CFG['admin'][$CFG['html']['template']['default']]['members_list_popupinfo_top']; ?>';
var form_name_array = new Array('membersAdvancedFilters');
//new Autocompleter.SelectBox('browse', {submit: 'members_nav'});
function membersNav()
	{
		memberUrl = '<?php echo getUrl('memberslist', '', ''); ?>';
		memberUrl = memberUrl+'?browse='+$Jq('#browse').val();
		window.location = memberUrl;
	}
 <?php
if(($memberList->getFormField('uname') != '' AND strcmp($memberList->getFormField('uname'), $LANG['search_uname_tag']) != 0)
	OR (strcmp($memberList->getFormField('sex'), $LANG['members_search_sex']) != 0)
	OR ($memberList->getFormField('ucity') != '' AND strcmp($memberList->getFormField('ucity'), $LANG['search_ucity']) != 0)
	OR ($memberList->getFormField('uhometown') != '' AND strcmp($memberList->getFormField('uhometown'), $LANG['search_uhometown']) != 0)
	OR ($memberList->getFormField('country') != ''))
		{
			echo "divShowHide('advanced_search', 'show_link', 'hide_link');";
		}
$autocomplete_data_url = $CFG['site']['url'].'getAutoCompleteData.php?field=';
?>
$Jq().ready(function() {

	function formatFillItem(row){
		return row['name'] + " ( " + row['total_count'] + ")";
	}

	function formatFillResult(row){
		return row.name;
	}
	$Jq.getJSON('<?php echo $autocomplete_data_url; ?>userhometown',
		function(json){
    		var data = json;
    		$Jq("#uhometown").autocomplete(data, {
													matchContains: true,
													max: 100,
													minChars: 1,
													autoFill: false,
													formatItem: formatFillItem,
													formatResult: formatFillResult
										   });

    });

    $Jq.getJSON('<?php echo $autocomplete_data_url; ?>usercity',
		function(json){
    		var data = json;
    		$Jq("#ucity").autocomplete(data, {
												matchContains: true,
												max: 100,
												minChars: 1,
												autoFill: false,
												formatItem: formatFillItem,
												formatResult: formatFillResult
											});
    });

});
</script>
<?php
//include the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$memberList->includeFooter();
?>
