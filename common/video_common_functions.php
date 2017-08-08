<?php
	function getVideoRelatedStats()
		{
			global $CFG;
			global $db;
			$sql =' SELECT COUNT(DISTINCT(video_id)) AS total_video_viewed FROM '.
					  $CFG['db']['tbl']['video_viewed'];

			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt);
		    if (!$rs)
			    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);

			if($row = $rs->FetchRow())
			{
				if($row['total_video_viewed'])
				{
					$link_url = getUrl('videolist','?pg=videomostviewed', 'videomostviewed/','','video');
					$row['total_video_viewed'] = '<a href="'.$link_url.'">'.$row['total_video_viewed'].'</a>';
					return $row['total_video_viewed'];
				}
			}

			return 0;
		}

	//Used to get total videos in the site - used for Site Statistics
	function getTotalVideosInSite($user_id ='')
		{
			global $CFG;
			global $db;
			if ($user_id !='')
				$condition = ' AND user_id = '.$user_id;
			else
				$condition = '';

			$sql = ' SELECT COUNT(video_id) AS total'.
					' FROM '.$CFG['db']['tbl']['video'].
					' WHERE video_status =\'Ok\''.$condition;
			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt);
			if (!$rs)
				trigger_db_error($db);

			$row = $rs->FetchRow();

			if($row['total'])
			{
				$link_url = getUrl('videolist','?pg=videonew', 'videonew/','','video');
				$row['total'] = '<a href="'.$link_url.'">'.$row['total'].'</a>';
			}
			return $row['total'];
		}

	function getMyDashboardVideoLinks()
		{
			global $LANG;
			$videodash_arr=array();
			$videodash_arr['shortcuts'][0]['link_url'] = getUrl('videouploadpopup', '', '', 'members', 'video');
			$videodash_arr['shortcuts'][0]['link_name'] = $LANG['mydahsboard_uploadvideo_title'];

			$videodash_arr['shortcuts'][1]['link_url'] = getUrl('videolist', '?pg=myvideos', 'myvideos/', '', 'video');
			$videodash_arr['shortcuts'][1]['link_name'] = $LANG['mydahsboard_myvideo_title'];

			$videodash_arr['stats'][0]['link_url']=getUrl('videolist', '?pg=myvideos', 'myvideos/', '', 'video');
			$videodash_arr['stats'][0]['link_name']=$LANG['mydahsboard_video_stats_link_myvideos'];
			$getTotalVideos = getTotalVideos();
			if ($getTotalVideos) {
			$stats_value = explode(':', $getTotalVideos);
			$videodash_arr['stats'][0]['stats_value']=$stats_value[1];
			}


			$videodash_arr['stats'][1]['link_url']=getUrl('videolist', '?pg=myfavoritevideos', 'myfavoritevideos/', '', 'video');
			$videodash_arr['stats'][1]['link_name']=$LANG['mydahsboard_video_stats_link_myfavoritevideos'];
			$videodash_arr['stats'][1]['stats_value']=getTotalVideosFavourite();

			$videodash_arr['stats'][2]['link_url']=getUrl('videolist', '?pg=myvideos', 'myvideos/', '', 'video');
			$videodash_arr['stats'][2]['link_name']=$LANG['mydahsboard_video_stats_link_videoviews'];
			$videodash_arr['stats'][2]['stats_value']=getTotalVideosViews();

			return $videodash_arr;
		}

	function getTotalVideos($user_id = '', $with_link=0)
		{
		   	global $CFG;
			global $db;
			global $LANG;

			if($user_id == '')
				$user_id = $CFG['user']['user_id'];

			$sql = 'SELECT total_videos FROM '.$CFG['db']['tbl']['users'].' WHERE user_id='.$user_id;

			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt);
		    if (!$rs)
			    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);
			if($row = $rs->FetchRow())
				{
					if($with_link)
						return $video_list_url = '<a href="'.getUrl('videolist', '?pg=uservideolist&amp;user_id='.$user_id, 'uservideolist/?user_id='.$user_id,'','video').'">'.$row['total_videos'].'</a>';
					else
			  	   		return $LANG['common_videos'].': <span>'.$row['total_videos'].'</span>';
				}
			return false;
		}
		function getTotalUsersVideos($user_id = '', $with_link=0)
		{
		   	global $CFG;
			global $db;
			global $LANG;

			if($user_id == '')
				$user_id = $CFG['user']['user_id'];

			$sql = 'SELECT total_videos FROM '.$CFG['db']['tbl']['users'].' WHERE user_id='.$user_id;

			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt);
		    if (!$rs)
			    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);
			if($row = $rs->FetchRow())
				{
					if ($row['total_videos']>0) {
						if($with_link)
							return $video_list_url = $LANG['common_videos'].': <span><a href="'.getUrl('videolist', '?pg=uservideolist&amp;user_id='.$user_id, 'uservideolist/?user_id='.$user_id,'','video').'">'.$row['total_videos'].'</a></span>';
						else
				  	   		return $LANG['common_videos'].': <span>'.$row['total_videos'].'</span>';
			  	   	}
					else
			  	   		return $LANG['common_videos'].': <span>'.$row['total_videos'].'</span>';
				}
			return false;
		}

	function getTotalVideosFavourite()
	    {
       	    global $CFG;
	    	global $db;
			$sql = 'SELECT COUNT(DISTINCT video_id) AS cnt FROM '.$CFG['db']['tbl']['video_favorite'].
					' WHERE user_id=\''.$CFG['user']['user_id'].'\'';
            $stmt = $db->Prepare($sql);
            $rs = $db->Execute($stmt);
                if (!$rs)
            	    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);
			if ($rs->PO_RecordCount())
			    {
			        $row = $rs->FetchRow();
					$count = $row['cnt'];
			    }
			$count = number_format($count);
			return $count;
		}

	function getTotalVideosViews($userId = '')
		{
		   	global $CFG;
	    	global $db;
	    	if($userId == '')
	    		$userId = $CFG['user']['user_id'];

			$sql = 'SELECT SUM(total_views) AS cnt FROM '.$CFG['db']['tbl']['video'].
							' WHERE user_id=\''.$userId.'\' ';

			$stmt = $db->Prepare($sql);
            $rs = $db->Execute($stmt);
                if (!$rs)
            	    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);
			if ($rs->PO_RecordCount())
			    {
			        $row = $rs->FetchRow();
					$count = $row['cnt'];
			    }
			$count = number_format($count);
			return $count;
		}

	function getMyFooterVideoLinks()
		{
			global $LANG;
			$videofooter_arr=array();
			//links to be shown All Videos, My Videos, Video playlists, Favorite videos, RSS Videos


			$videofooter_arr[0]['link_url']=getUrl('videolist','?pg=videonew', 'videonew/','','video');
			$videofooter_arr[0]['link_name']=$LANG['footer_video_link_allvideoslist'];

			$videofooter_arr[1]['link_url']=getUrl('videolist', '?pg=myvideos', 'myvideos/', 'members', 'video');
			$videofooter_arr[1]['link_name']=$LANG['footer_video_link_videoslist'];

			$videofooter_arr[1]['link_url']=getUrl('videolist', '?pg=myvideos', 'myvideos/', 'members', 'video');
			$videofooter_arr[1]['link_name']=$LANG['footer_video_link_videoslist'];

			$videofooter_arr[2]['link_url']=getUrl('videoplaylist', '', '', 'members', 'video');
			$videofooter_arr[2]['link_name']=$LANG['footer_video_link_videoplaylist'];

			$videofooter_arr[3]['link_url']=getUrl('videolist', '?pg=myfavoritevideos', 'myfavoritevideos/', 'members', 'video');
			$videofooter_arr[3]['link_name']=$LANG['footer_video_link_videofavorites'];

			$videofooter_arr[4]['link_url'] = getUrl('rssvideo','','','','video');
			$videofooter_arr[4]['link_name'] = $LANG['footer_video_link_rss'];


			return $videofooter_arr;
		}

	function getMyHomeVideoShortcuts()
		{
			global $LANG;
			$myhomeshortcut_arr=array();

			$myhomeshortcut_arr['viewmy']['link_url'] = getUrl('videolist', '?pg=myvideos', 'myvideos/', '', 'video');
			$myhomeshortcut_arr['viewmy']['link_name'] = $LANG['myhome_shortcuts_link_videos'];

			$myhomeshortcut_arr['setting']['link_url'] = getUrl('videouploadpopup', '', '', 'members', 'video');
			$myhomeshortcut_arr['setting']['link_name'] = $LANG['myhome_shortcuts_link_uploadvideos'];

			return $myhomeshortcut_arr;
		}

	function populateAdminVideoLeftNavigation()
		{
		   	 global $smartyObj;
		     setTemplateFolder('admin/','video');
		     $smartyObj->assign('admin_main_menu_arrays', additionalAdminVideoMenuLink());
			 $smartyObj->display('left_video_navigation_links.tpl');
			 ?>
			<script language="javascript" type="text/javascript">
				var inc = divArray.length;
				var temp_video_menu_array = new Array('videoMain', 'videoSetting', 'videoPlayerSetting', 'videoPlugin');
				for(jnc=0;jnc<temp_video_menu_array.length;jnc++)
					divArray[inc++] = temp_video_menu_array[jnc];
			</script>
		   	 <?php
		}

	function additionalAdminVideoMenuLink(){
			global $CFG;
			global $db;
			global $smartyObj;

			$sql ='SELECT * FROM '.$CFG['db']['tbl']['additional_menu_links'].' WHERE module = \'video\' AND menu_type=\'main\' AND status =\'yes\' AND parent_id =0 ';
			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt);
		    if (!$rs)
			    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);

			$row = array();
			$rowValue = array();
			$admin_menu_arrays = array();
			$mainMenuId = '';
			$i = 0;
			if ($rs->PO_RecordCount()){
				while($row = $rs->FetchRow()){
					$admin_menu_arrays[$i]['menu_name'] = $row['menu_name'];
					$admin_menu_arrays[$i]['menu_id']   = str_replace('.php','',$row['link_file']);
					$admin_menu_arrays[$i]['link_file'] = $row['link_file'];
					$admin_menu_arrays[$i]['module']    = $row['module'];

					$subMenuSql  = 'SELECT * FROM '.$CFG['db']['tbl']['additional_menu_links'].' WHERE status =\'yes\' AND parent_id ='.$row['additional_menu_links_id'];
					$subMenustmt = $db->Prepare($subMenuSql);
					$subMenuRS   = $db->Execute($subMenustmt);
				    if (!$subMenuRS)
					    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);
					$j = 0;
					if ($subMenuRS->PO_RecordCount()){
						while($rowValue = $subMenuRS->FetchRow()){
							$admin_menu_arrays[$i]['subMenu'][$j]['menu_name'] = $rowValue['menu_name'];
							$admin_menu_arrays[$i]['subMenu'][$j]['menu_id']   = str_replace('.php','',$rowValue['link_file']);
							$admin_menu_arrays[$i]['subMenu'][$j]['link_file'] = $rowValue['link_file'];
							$admin_menu_arrays[$i]['subMenu'][$j]['module']    = $rowValue['module'];
							$editConfigFile = strpos($rowValue['link_file'],'editConfig');
							if($rowValue['module'] == ''){
								$admin_menu_arrays[$i]['subMenu'][$j]['url']     = $CFG['site']['url'].'admin/'.$rowValue['link_file'].'&module='.$admin_menu_arrays[$i]['module'].'&div='.$admin_menu_arrays[$i]['menu_id'];
								$listHighLight = explode('config_file_name=',$rowValue['link_file']);
								$admin_menu_arrays[$i]['subMenu'][$j]['menu_id'] = 'edit'.$listHighLight[1];
							}
							else
								$admin_menu_arrays[$i]['subMenu'][$j]['url']   = $CFG['site']['url'].'admin/'.$rowValue['module'].'/'.$rowValue['link_file'];
							$j++;
						}
					}
					$mainMenuId .= $admin_menu_arrays[$i]['menu_id'].',';

					$i++;
				}
				$mainMenuId = substr($mainMenuId,0,-1);
?>
				<script language="javascript" type="text/javascript">
					var inc = divArray.length;
					var temp_menu_array        = '<?php echo $mainMenuId;?>';
					var temp_video_menu_array  = new Array();
					temp_video_menu_array = temp_menu_array.split(',');
					for(jnc=0;jnc<temp_video_menu_array.length;jnc++){
						if((divArray.join().indexOf(temp_video_menu_array[jnc])>=0) == false)
							divArray[inc++] = temp_video_menu_array[jnc];
					}
				</script>
<?php
				return $admin_menu_arrays;
			}
		}
	function getVideoAlbumName($album_id)
		{
			global $CFG;
			global $db;
			$sql ='SELECT album_title FROM '.$CFG['db']['tbl']['video_album'].
			      ' WHERE video_album_id=\''.$album_id.'\' ';

			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt);
			    if (!$rs)
				    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);
			if ($rs->PO_RecordCount())
			    {
			        $row = $rs->FetchRow();
					return $row['album_title'];
			    }
			 return false;
		}
	function adminVideoStatistics()
		{
		    global $CFG;
			global $db;
			global $smartyObj;
	        $videoStatistics_arr = array();
	        //Total Active video...
			$sql = 'SELECT count(video_id) as total FROM '.$CFG['db']['tbl']['video'].
					' WHERE video_status = \'Ok\' ';

			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt);
			if (!$rs)
				trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);

			$row = $rs->FetchRow();
			$videoStatistics_arr['total_active_video'] = $row['total'];

			//Waiting for activation videos
			$sql = 'SELECT count(video_id) as total FROM '.$CFG['db']['tbl']['video'].
					' WHERE video_status = \'Locked\' ';

			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt);
			if (!$rs)
				trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);

			$row = $rs->FetchRow();
			$videoStatistics_arr['total_toactivate_video'] = $row['total'];


			//Today
			$sql = 'SELECT count(video_id) as total FROM '.$CFG['db']['tbl']['video'].
					' WHERE video_status = \'Ok\'  AND DATE_FORMAT(date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';

			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt);
			if (!$rs)
				trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);

			$row = $rs->FetchRow();
			$videoStatistics_arr['total_today_video'] = $row['total'];

			//This week
			$sql = 'SELECT count(video_id) as total FROM '.$CFG['db']['tbl']['video'].
					' WHERE video_status = \'Ok\'  AND DATE_SUB( CURDATE( ) , INTERVAL 7 DAY ) <= date_added';

			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt);
			if (!$rs)
				trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);

			$row = $rs->FetchRow();
			$videoStatistics_arr['this_week_video'] = $row['total'];

			//This month
			$sql = 'SELECT count(video_id) as total FROM '.$CFG['db']['tbl']['video'].
					' WHERE video_status = \'Ok\'  AND DATE_SUB( CURDATE( ) , INTERVAL 30 DAY ) <= date_added';

			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt);
			if (!$rs)
				trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);

			$row = $rs->FetchRow();
		    $videoStatistics_arr['this_month_video'] = $row['total'];
			$smartyObj->assign('videoStatistics_arr', $videoStatistics_arr);
		}

	function populateVideoTopContributors()
		{
			global $smartyObj, $CFG, $db, $LANG;
			$sql = 'SELECT COUNT( v.video_id ) AS total_video, v.user_id '.
					'FROM '.$CFG['db']['tbl']['video'].' AS v '.
					'WHERE video_status=\'Ok\' GROUP BY user_id ORDER BY total_video DESC LIMIT 0,'.
					$CFG['admin']['videos']['index_page_top_contributors'];

			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt);
			if (!$rs)
			    trigger_db_error($db);
				$record_count = false;
			//Fix for not taking video's html_footer.tpl for common pages
			$module = '';
			if(!empty($CFG['site']['is_module_page']))
				$module = $CFG['site']['is_module_page'];
			if ($rs->PO_RecordCount())
		    {
		    	$record_count = true;
		    	$contributor_arr = array();
				$inc=0;
				$CFG['site']['is_module_page'] = 'video';
		        while($row = $rs->FetchRow())
				{
					if(!isset($UserDetails[$row['user_id']]))
						$icondetail = getMemberAvatarDetails($row['user_id']);

					if(!empty($icondetail))
					{
						$user_name = getUserDetail('user_id', $row['user_id'], 'user_name');
						$contributor_arr[$inc]['memberProfileUrl'] = getMemberProfileUrl($row['user_id'], $user_name);
						$contributor_arr[$inc]['name']	= $user_name;
						$contributor_arr[$inc]['icon']	= $icondetail;
						$contributor_arr[$inc]['total_stats'] = getUrl('videolist', '?pg=uservideolist&amp;user_id='.$row['user_id'], 'uservideolist/?user_id='.$row['user_id'],'','video');
						$inc++;
					}
				}
				$smartyObj->assign('lang_total_contributors', $LANG['common_top_contributors_total_videos']);
				$smartyObj->assign('contributor',$contributor_arr);
				//To load video module's topContributors tpl
				if(file_exists($CFG['site']['project_path'].$module.'/design/templates/'.$CFG['html']['template']['default'].'/general/topContributors.tpl'))
					setTemplateFolder('general/', $module);
				else
					setTemplateFolder('general/');
				$smartyObj->display('topContributors.tpl');
				//Fix for not taking video's html_footer.tpl for common pages
				if($module == '')
					$CFG['site']['is_module_page'] = '';
			    }
		}

		/**
		 * To populate the uploaded videos by user -> mail compose
		 *
		 * @param integer $hightlight_video
		 * @access public
		 * @return void
		 **/
		function populateMyVideos($hightlight_video)
			{
				global $CFG, $db;
				$sql = 'SELECT v.video_id, v.video_title '.
						'FROM '. $CFG['db']['tbl']['video'] . ' AS v '.
						'WHERE v.user_id = '.$db->Param($CFG['user']['user_id']).' '.
						'AND v.video_status = \'Ok\' '.
						'AND v.video_encoded_status = \'Yes\' '.
						'ORDER BY v.video_title';

				$stmt = $db->Prepare($sql);
				$rs = $db->Execute($stmt, array($CFG['user']['user_id']));
				if (!$rs)
			        trigger_error($db->ErrorNo().' '.
						$db->ErrorMsg(), E_USER_ERROR);

				if (!$rs->PO_RecordCount())
					{
						return false;
				    }
				$video = array();
				while($row=$rs->FetchRow())
					{
						$video[$row['video_id']] = $row['video_title'];
					}
				return $video;
			}

		/**
		 * To populate favorite videos -> mail compose
		 *
		 * @param integer $hightlight_video
		 * @access public
		 * @return void
		 **/
		function populateMyFavorites($hightlight_video)
			{
				global $CFG, $db;

				$sql = 'SELECT v.video_id, v.video_title '.
						'FROM '. $CFG['db']['tbl']['video'] . ' AS v, '. $CFG['db']['tbl']['video_favorite'] . ' AS vf '.
						'WHERE v.video_id = vf.video_id '.
						'AND vf.user_id = '.$db->Param($CFG['user']['user_id']).' '.
						'AND v.video_status = \'Ok\' '.
						'AND v.video_encoded_status = \'Yes\' '.
						'ORDER BY v.video_title';

				$stmt = $db->Prepare($sql);
				$rs = $db->Execute($stmt, array($CFG['user']['user_id']));
				if (!$rs)
			        trigger_error($db->ErrorNo().' '.
						$db->ErrorMsg(), E_USER_ERROR);
				if (!$rs->PO_RecordCount())
					{
						return false;
				    }
				$video = array();
				while($row = $rs->FetchRow())
					{
						$video[$row['video_id']] = $row['video_title'];
					}
				return $video;
			}


	function displayMyVideos($start=0, $videoLimit=4, $userID)
		{
			global $CFG;
			global $db;
			global $smartyObj;

			$displayMyVideos_arr = array();
			$condition = 'video_status=\'Ok\' AND user_id=\''.$userID.'\'';

			$sql = 'SELECT video_id, video_ext, t_width, t_height, video_server_url,video_title'.
					' FROM '.$CFG['db']['tbl']['video'].' WHERE '.$condition.' ORDER BY'.
					' video_id DESC LIMIT '.$start.','.$videoLimit;

		    $stmt = $db->Prepare($sql);
		    $rs = $db->Execute($stmt);
		    if (!$rs)
		    	trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);

		    $row = array();
		   	$displayMyVideos_arr['record_count'] = 0;
			if ($rs->PO_RecordCount())
		   		{
					$displayMyVideos_arr['record_count'] = 1;
					$displayMyVideos_arr['row'] = array();
					$inc = 0;
					$count = 0;
					$thumbnail_folder = $CFG['media']['folder'].'/'.$CFG['admin']['videos']['folder'].'/'.$CFG['admin']['videos']['thumbnail_folder'].'/';
		    		while($row = $rs->FetchRow())
					    {
							$displayMyVideos_arr['row'][$inc]['record'] = $row;
							$count++;
							$displayMyVideos_arr['row'][$inc]['video_path'] = $row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id']).$CFG['admin']['videos']['thumb_name'].'.'.$CFG['video']['image']['extensions'];
							$displayMyVideos_arr['row'][$inc]['widthHeightAttr'] = DISP_IMAGE($CFG['admin']['videos']['thumb_width'], $CFG['admin']['videos']['thumb_height'], $row['t_width'], $row['t_height']);
				    		$inc++;
						} // while
			    }
			$smartyObj->assign('displayMyVideos_arr', $displayMyVideos_arr);
		}
	function getVideoImageName($text,$thumb_name='')
		{
			global $CFG;
			if(!$thumb_name)
				$thumb_name=getFileSettingName($text,'Thumb');

			$text = md5($thumb_name.$text);
			return substr($text, 0, 15);
		}
	function getVideoName($text)
		{
		    global $CFG;
			$file_name=getFileSettingName($text,'Video');
			$text = md5($file_name.$text);
			return substr($text, 0, 15);
		}
	function getTrimVideoName($text)
	{
			global $CFG;
			$file_name=getFileSettingName($text,'Trimed');
			$text = md5($file_name.$text);
			return substr($text, 0, 15);
	}
	function getFileSettingName($video_id,$file_type)
		{
		   	global $CFG;
			global $db;
			$video_file_id=getFileSettingId($video_id,$file_type);
		   	if(!$video_file_id)
			   $video_file_id=getCurrentFileSettingId($file_type);

			 $sql = 'SELECT file_name FROM '.$CFG['db']['tbl']['video_files_settings'].
					' WHERE video_file_id=\''.$video_file_id.'\'';

			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt);
			    if (!$rs)
				    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);

			if($row = $rs->FetchRow())
				return $row['file_name'];
			return false;
		}
	function getFileSettingId($video_id,$file_type)
		{
			global $CFG;
			global $db;
			$field_name=1;
			if($file_type=='Thumb')
			  $field_name='thumb_name_id';
			else if($file_type=='Video')
			  $field_name='video_file_name_id';
			else if($file_type=='Trimed')
			  $field_name='trimed_video_name_id';

			$sql = 'SELECT '.$field_name.' FROM '.$CFG['db']['tbl']['video'].
					' WHERE  video_id=\''.$video_id.'\'';
			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt);
			    if (!$rs)
				    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);

			if($row = $rs->FetchRow())
				return  $row[$field_name];
			return false;
		}
	function getCurrentFileSettingId($file_type)
		{
			global $CFG;
			global $db;
			$sql = 'SELECT video_file_id FROM '.$CFG['db']['tbl']['video_files_settings'].
					' WHERE  status =\'Yes\' AND  file_type=\''.$file_type.'\'';

			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt);
			    if (!$rs)
				    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);

			if($row = $rs->FetchRow())
				return  $row['video_file_id'];
			return false;
		}

	function getRandomFieldOfVideoTable()
		{
			$rand_fields_arr = array('video_id', 'user_id', 'video_album_id', 'video_category_id', 'rating_total', 'rating_count', 'total_views', 'total_comments', 'total_favorites', 'total_downloads');
			srand((float) microtime() * 10000000);
			$rand_keys = array_rand($rand_fields_arr);
			return $rand_fields_arr[$rand_keys];
		}

	/**
	 * ViewVideo::chkValidVideoId()
	 *
	 * @return
	 **/
	function validVideoIdRevised($video_id)
		{
			global $db;
			global $CFG;
			global $LANG;
			if (!$videoId=$video_id)
		        return false;
			$condition = 'p.video_status=\'Ok\' AND p.video_id='.$db->Param($videoId);
			$sql = 'SELECT video_id, allow_embed, flv_upload_type, video_flv_url, video_server_url FROM '.$CFG['db']['tbl']['video'].' as p'.
					' WHERE '.$condition.' LIMIT 0,1';
			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt, array($videoId));
			    if (!$rs)
				    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);
			if($row = $rs->FetchRow())
				return $row;
			return false;
		}

		function rayzzMvInKL($video_id='')
		{
			global $db;
			global $CFG;

			if(!isset($_SESSION['user']['quick_links']))
				return false;
			elseif(!trim($_SESSION['user']['quick_links']))
				return false;

			$avail_quick_link_video_arr=explode(',',$_SESSION['user']['quick_links']);
			if(!is_array($avail_quick_link_video_arr))
				return false;

			$return=in_array($video_id,$avail_quick_link_video_arr);
			if($return!==false)
				return true;
			return false;
		}

		function mvKLRmRayzz($video_id)
		{
			//str_replace($videoid.',','',$_SESSION['user']['quick_links']);
			if(isset($_SESSION['user']['quick_links']) and trim($_SESSION['user']['quick_links']))
				{
					$avail_quick_link_video_arr=$to_result_arr=explode(',',$_SESSION['user']['quick_links']);
					if(is_array($avail_quick_link_video_arr))
						{
							foreach($avail_quick_link_video_arr as $index=>$value)
								if($value==$video_id)
									unset($to_result_arr[$index]);
						}
					$_SESSION['user']['quick_links']=implode(',',$to_result_arr);
				}
		}

		function mvKLHRmRayzz($video_id)
		{
			if(isset($_SESSION['user']['quick_history']) and trim($_SESSION['user']['quick_history']))
				{
					$avail_quick_link_video_arr=$to_result_arr=explode(',',$_SESSION['user']['quick_history']);
					if(is_array($avail_quick_link_video_arr))
						{
							foreach($avail_quick_link_video_arr as $index=>$value)
								if($value==$video_id)
									unset($to_result_arr[$index]);
						}
					$_SESSION['user']['quick_history']=implode(',',$to_result_arr);

					//echo 'Removed';
				}
		}

		function mvInKLRayzz($video_id='')
		{
			global $db;
			global $CFG;

			if(!isset($_SESSION['user']['quick_links']))
				return false;
			elseif(!trim($_SESSION['user']['quick_links']))
				return false;

			$avail_quick_link_video_arr=explode(',',$_SESSION['user']['quick_links']);
			if(!is_array($avail_quick_link_video_arr))
				return false;

			$return=in_array($video_id,$avail_quick_link_video_arr);
			if($return!==false)
				return true;
			return false;
		}

?>