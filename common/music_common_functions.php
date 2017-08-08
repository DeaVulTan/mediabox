<?php
	function getMusicRelatedStats()
	{
		global $CFG;
		global $db;
		$sql =' SELECT COUNT(DISTINCT(music_id)) AS total_music_viewed FROM '.
				  $CFG['db']['tbl']['music_listened'];

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
	    if (!$rs)
		    trigger_db_error($db);

		if($row = $rs->FetchRow())
		{
			if($row['total_music_viewed'])
			{
				$link_url = getUrl('musiclist','?pg=musicmostviewed','musicmostviewed/','','music');
				$row['total_music_viewed'] = '<a href="'.$link_url.'">'.$row['total_music_viewed'].'</a>';
		  	   	return $row['total_music_viewed'];
		  	}
		}

		return 0;
	}

	function getMyDashboardMusicLinks()
	{
		global $LANG;
		$musicdash_arr=array();
		if(isAllowedMusicUpload())
		{
		$musicdash_arr['shortcuts'][0]['link_url'] = getUrl('musicuploadpopup', '', '', 'members', 'music');
		$musicdash_arr['shortcuts'][0]['link_name'] = $LANG['mydahsboard_uploadmusic_title'];

		$musicdash_arr['shortcuts'][1]['link_url']=getUrl('musiclist', '?pg=mymusics', 'mymusics/', '', 'music');
		$musicdash_arr['shortcuts'][1]['link_name']=$LANG['mydahsboard_mymusic_title'];

		$musicdash_arr['stats'][0]['link_url']=getUrl('musiclist', '?pg=mymusics', 'mymusics/', '', 'music');
		$musicdash_arr['stats'][0]['link_name']=$LANG['mydahsboard_music_stats_link_mymusics'];
		$stats_value = explode(':', getTotalMusics());
		$musicdash_arr['stats'][0]['stats_value']=$stats_value[1];
		}
		else
		$musicdash_arr['shortcuts'] = false;
		$musicdash_arr['stats'][1]['link_url']=getUrl('musiclist', '?pg=myfavoritemusics', 'myfavoritemusics/', '', 'music');
		$musicdash_arr['stats'][1]['link_name']=$LANG['mydahsboard_music_stats_link_myfavoritemusics'];
		$musicdash_arr['stats'][1]['stats_value']=getTotalMusicsFavourite();

		$musicdash_arr['stats'][2]['link_url']=getUrl('mymusictracker', '', '', '', 'music');
		$musicdash_arr['stats'][2]['link_name']=$LANG['mydahsboard_music_stats_link_musictracker'];
		$musicdash_arr['stats'][2]['stats_value']='';

		return $musicdash_arr;
	}

	function getTotalMusics($user_id='', $with_link=0)
		{
		   	global $CFG;
			global $db;
			global $LANG;
			if($user_id=='')
				$user_id = $CFG['user']['user_id'];
			$sql =' SELECT total_musics FROM '.$CFG['db']['tbl']['users'].' WHERE user_id='.$user_id;

			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt);
		    if (!$rs)
			    trigger_db_error($db);
			$total_music = 0;
			if($row = $rs->FetchRow())
				{
			  	   $total_music =  $row['total_musics'];
				}
			if(isset($CFG['admin']['musics']['music_artist_feature'])
				and $CFG['admin']['musics']['music_artist_feature']
				and isset($CFG['admin']['musics']['allow_only_artist_to_upload'])
				and $CFG['admin']['musics']['allow_only_artist_to_upload']
				and getUserType($user_id)=='Listener')
			return false;
			else
			{
					if($with_link)
						return $video_list_url = '<a href="'.getUrl('musiclist', '?pg=usermusiclist&amp;user_id='.$user_id, 'usermusiclist/?user_id='.$user_id,'','music').'">'.$total_music.'</a>';
					else
			  	   		return $LANG['common_musics'].': <span>'.$total_music.'</span>';

			}
		}
		function getTotalUsersMusics($user_id='', $with_link=0)
		{
		   	global $CFG;
			global $db;
			global $LANG;
			if($user_id=='')
				$user_id = $CFG['user']['user_id'];
			$sql =' SELECT total_musics FROM '.$CFG['db']['tbl']['users'].' WHERE user_id='.$user_id;

			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt);
		    if (!$rs)
			    trigger_db_error($db);
			$total_music = 0;
			if($row = $rs->FetchRow())
				{
			  	   $total_music =  $row['total_musics'];
				}
			if(isset($CFG['admin']['musics']['music_artist_feature'])
				and $CFG['admin']['musics']['music_artist_feature']
				and isset($CFG['admin']['musics']['allow_only_artist_to_upload'])
				and $CFG['admin']['musics']['allow_only_artist_to_upload']
				and getUserType($user_id)=='Listener')
			return false;
			else
			{
				if ($total_music>0) {
					if($with_link)
						return $video_list_url = $LANG['common_musics'].': <span><a href="'.getUrl('musiclist', '?pg=usermusiclist&amp;user_id='.$user_id, 'usermusiclist/?user_id='.$user_id,'','music').'">'.$total_music.'</a></span>';
					else
			  	   		return $LANG['common_musics'].': <span>'.$total_music.'</span>';
				}
				else
				   	return $LANG['common_musics'].': <span>'.$total_music.'</span>';
			}
		}
	   function getTotalMusicsFavourite()
	    {
       	    global $CFG;
	    	global $db;
			$sql = 'SELECT COUNT(DISTINCT music_id) AS cnt FROM '.$CFG['db']['tbl']['music_favorite'].
					' WHERE user_id=\''.$CFG['user']['user_id'].'\'';
            $stmt = $db->Prepare($sql);
            $rs = $db->Execute($stmt);
                if (!$rs)
            	    trigger_db_error($db);
			$count = '';
			if ($rs->PO_RecordCount())
			    {
			        $row = $rs->FetchRow();
					$count = $row['cnt'];
			    }
			$count = number_format($count);
			return $count;
		}


	  function getTotalMusicsViews($user_id='')
    	{
    	   	global $CFG;
        	global $db;

    		if($user_id == '')
    			$user_id = $CFG['user']['user_id'];

    		$sql = 'SELECT SUM(total_views) AS cnt FROM '.$CFG['db']['tbl']['music'].' WHERE user_id=\''.$user_id.'\' ';

            $stmt = $db->Prepare($sql);
            $rs = $db->Execute($stmt);
    		if (!$rs)
    			trigger_db_error($db);
			$count = '';
    		if ($rs->PO_RecordCount())
    		    {
    		        $row = $rs->FetchRow();
    				$count = $row['cnt'];
    		    }
    		$count = number_format($count);
    		return $count;
    	}
	  function getMyFooterMusicLinks()
	{
		global $LANG;
		$musicfooter_arr=array();
		//links to be shown All Tracks, My tracks, My playlists, Favorite tracks, RSS Music

		$musicfooter_arr[0]['link_url']=getUrl('musiclist','?pg=musicnew', 'musicnew/','','music');
		$musicfooter_arr[0]['link_name']=$LANG['footer_music_link_allmusiclist'];


		$musicfooter_arr[1]['link_url']=getUrl('musiclist', '?pg=mymusics', 'mymusics/', '', 'music');
		$musicfooter_arr[1]['link_name']=$LANG['footer_music_link_musicslist'];

		$musicfooter_arr[2]['link_url']=getUrl('musicplaylist', '?pg=myplaylist', 'myplaylist/', '', 'music');
		$musicfooter_arr[2]['link_name']=$LANG['footer_music_link_musicplaylist'];

		$musicfooter_arr[3]['link_url']=getUrl('musiclist', '?pg=myfavoritemusics', 'myfavoritemusics/', '', 'music');
		$musicfooter_arr[3]['link_name']=$LANG['footer_music_link_musicfavorites'];

		$musicfooter_arr[4]['link_url'] = getUrl('rssmusic','','','','music');
		$musicfooter_arr[4]['link_name'] = $LANG['footer_music_link_rss'];


		return $musicfooter_arr;
	}
	function getMyHomeMusicShortcuts()
	{
		global $LANG;
		$myhomeshortcut_arr=array();
		if(isAllowedMusicUpload())
		{
			$myhomeshortcut_arr['viewmy']['link_url']=getUrl('musiclist', '?pg=mymusics', 'mymusics/', '', 'music');
			$myhomeshortcut_arr['viewmy']['link_name']=$LANG['myhome_shortcuts_link_musics'];

			$myhomeshortcut_arr['setting']['link_url']=getUrl('musicuploadpopup', '', '', 'members', 'music');
			$myhomeshortcut_arr['setting']['link_name']=$LANG['myhome_shortcuts_link_uploadmusics'];
		}
		return $myhomeshortcut_arr;
	}
	function populateAdminMusicLeftNavigation($header)
	{
	   	 global $smartyObj;
		 if($header->_currentPage=='musicplaylistmanage')
			$header->_navigationArr['left_musicplaylist'] = $header->_clsActiveLink;

		if($header->_currentPage=='managelyrics' or $header->_currentPage=='viewlyrics' or $header->_currentPage=='addlyrics'
		   or $header->_currentPage=='musicfeaturedreorder' or $header->_currentPage=='musiclyricsactivate' or $header->_currentPage=='editmusicdetails')
			$header->_navigationArr['left_musicmanage'] = $header->_clsActiveLink;
		if($header->_currentPage=='transactionlist' or $header->_currentPage=='transactionhistory')
			$header->_navigationArr['left_managetransactiondetails'] = $header->_clsActiveLink;
		 $smartyObj->assign('admin_main_menu_arrays', additionalAdminMenuLink());
		 setTemplateFolder('admin/','music');
		 $smartyObj->display('left_music_navigation_links.tpl');
		 ?>
	   	 <script language="javascript" type="text/javascript">
	   	   var inc = divArray.length;
	   	   var temp_music_menu_array = new Array('musicMain', 'musicSetting', 'musicPlugin');
	   	   for(jnc=0;jnc<temp_music_menu_array.length;jnc++)
				divArray[inc++] = temp_music_menu_array[jnc];
	   	 </script>
	   	 <?php
	}
	function additionalAdminMenuLink(){
			global $CFG;
			global $db;
			global $smartyObj;

			$sql ='SELECT * FROM '.$CFG['db']['tbl']['additional_menu_links'].' WHERE module = \'music\' AND menu_type=\'main\' AND status =\'yes\' AND parent_id =0 ';
			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt);
		    if (!$rs)
			    trigger_db_error($db);

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
					    trigger_db_error($db);
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
					var temp_music_menu_array  = new Array();
					temp_music_menu_array = temp_menu_array.split(',');
					for(jnc=0;jnc<temp_music_menu_array.length;jnc++){
						if((divArray.join().indexOf(temp_music_menu_array[jnc])>=0) == false)
							divArray[inc++] = temp_music_menu_array[jnc];
					}
				</script>
<?php
				return $admin_menu_arrays;
			}
		}

	function getMusicAlbumName($album_id)
	{
		global $CFG;
		global $db;
		$sql ='SELECT album_title FROM '.$CFG['db']['tbl']['music_album'].
		      ' WHERE music_album_id=\''.$album_id.'\' ';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		    if (!$rs)
			    trigger_db_error($db);
		if ($rs->PO_RecordCount())
		    {
		        $row = $rs->FetchRow();
				return $row['album_title'];
		    }
		 return false;
	}
	function adminMusicStatistics()
	{
	    global $CFG;
		global $db;
		global $smartyObj;
        $musicStatistics_arr = array();
        //Total Active music...
		$sql = 'SELECT count(music_id) as total FROM '.$CFG['db']['tbl']['music'].
				' WHERE music_status = \'Ok\' ';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_db_error($db);

		$row = $rs->FetchRow();
		$musicStatistics_arr['total_active_music'] = $row['total'];

		//Waiting for activation musics
		$sql = 'SELECT count(music_id) as total FROM '.$CFG['db']['tbl']['music'].
				' WHERE music_status = \'Locked\' ';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_db_error($db);

		$row = $rs->FetchRow();
		$musicStatistics_arr['total_toactivate_music'] = $row['total'];


		//Today
		$sql = 'SELECT count(music_id) as total FROM '.$CFG['db']['tbl']['music'].
				' WHERE music_status = \'Ok\'  AND DATE_FORMAT(date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_db_error($db);

		$row = $rs->FetchRow();
		$musicStatistics_arr['total_today_music'] = $row['total'];

		//This week
		$sql = 'SELECT count(music_id) as total FROM '.$CFG['db']['tbl']['music'].
				' WHERE music_status = \'Ok\'  AND DATE_SUB( CURDATE( ) , INTERVAL 7 DAY ) <= date_added';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_db_error($db);

		$row = $rs->FetchRow();
		$musicStatistics_arr['this_week_music'] = $row['total'];

		//This month
		$sql = 'SELECT count(music_id) as total FROM '.$CFG['db']['tbl']['music'].
				' WHERE music_status = \'Ok\'  AND DATE_SUB( CURDATE( ) , INTERVAL 30 DAY ) <= date_added';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_db_error($db);

		$row = $rs->FetchRow();
	    $musicStatistics_arr['this_month_music'] = $row['total'];
		$smartyObj->assign('musicStatistics_arr', $musicStatistics_arr);
	}

	function getMusicImageName($text, $thumb_name='')
	{
		global $CFG;
		if(!$thumb_name)
			$thumb_name=getMusicFileSettingName($text,'Thumb');

		$text = md5($thumb_name.$text);
		return substr($text, 0, 15);
	}

	function getMusicName($text)
	{
		$file_name = getMusicFileSettingName($text,'Music');
		$text = md5($file_name.$text);
		return substr($text, 0, 15);
	}

	function getTrimMusicName($text)
	{
		$file_name = getMusicFileSettingName($text,'Trimed');
		$text = md5($file_name.$text);
		return substr($text, 0, 15);
	}

	function getMusicFileSettingName($music_id, $file_type)
	{
		global $CFG;
		global $db;
		$music_file_id = getMusicFileSettingId($music_id, $file_type);
	   	if(!$music_file_id)
		   $music_file_id = getCurrentMusicFileSettingId($file_type);

		$sql = 'SELECT file_name FROM '.$CFG['db']['tbl']['music_files_settings'].
				' WHERE music_file_id=\''.$music_file_id.'\'';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
	    if (!$rs)
		    trigger_db_error($db);

		if($row = $rs->FetchRow())
			return $row['file_name'];
		return false;
	}

	function rayzzMusicQuickMix($music_id='')
	{
		global $db;
		global $CFG;
		if(!isset($_SESSION['user']['music_quick_mixs']))
			return false;
				elseif(!trim($_SESSION['user']['music_quick_mixs']))
					return false;
		$avail_quick_mix_music_arr=explode(',',$_SESSION['user']['music_quick_mixs']);
		if(!is_array($avail_quick_mix_music_arr))
			return false;
		$return=in_array($music_id,$avail_quick_mix_music_arr);
		if($return!==false)
			return true;
			return false;
	}

	function rayzzRMQuickMix($music_id)
	{
		if(isset($_SESSION['user']['music_quick_mixs']) and trim($_SESSION['user']['music_quick_mixs']))
		{
			$avail_quick_mix_music_arr=$to_result_arr=explode(',',$_SESSION['user']['music_quick_mixs']);
			if(is_array($avail_quick_mix_music_arr))
			{
				foreach($avail_quick_mix_music_arr as $index=>$value)
				if($value==$music_id)
				unset($to_result_arr[$index]);
			}
			$_SESSION['user']['music_quick_mixs']=implode(',',$to_result_arr);
		}
	}

	function getMusicFileSettingId($music_id, $file_type)
	{
		global $CFG;
		global $db;

		$field_name = 1;
		if($file_type == 'Thumb')
		  $field_name = 'thumb_name_id';
		else if($file_type == 'Music')
		  $field_name = 'music_file_name_id';
		else if($file_type == 'Trimed')
		  $field_name = 'trimed_music_name_id';

		$sql = 'SELECT '.$field_name.' FROM '.$CFG['db']['tbl']['music'].
				' WHERE music_id=\''.$music_id.'\'';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
	    if (!$rs)
		    trigger_db_error($db);

		if($row = $rs->FetchRow())
			return $row[$field_name];
		return false;
	}

	 function getCurrentMusicFileSettingId($file_type)
	{
		global $CFG;
		global $db;
		$sql = 'SELECT music_file_id FROM '.$CFG['db']['tbl']['music_files_settings'].
				' WHERE  status =\'Yes\' AND  file_type=\''.$file_type.'\'';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
	    if (!$rs)
			trigger_db_error($db);

		if($row = $rs->FetchRow())
			return  $row['music_file_id'];
		return false;
	}


	function displayMyMusics($start=0, $musicLimit=4, $userID)
	{
		global $CFG;
		global $db;
		global $smartyObj;

		$displayMyMusics_arr = array();
		$condition = 'music_status=\'Ok\' AND user_id=\''.$userID.'\'';

		$sql = 'SELECT music_id, music_ext, thumb_width, thumb_height, music_server_url, music_title, music_thumb_ext'.
				' FROM '.$CFG['db']['tbl']['music'].' WHERE '.$condition.' ORDER BY'.
				' music_id DESC LIMIT '.$start.','.$musicLimit;

	    $stmt = $db->Prepare($sql);
	    $rs = $db->Execute($stmt);
	    if (!$rs)
	    	trigger_db_error($db);

	    $row = array();
	   	$displayMyMusics_arr['record_count'] = 0;
		if ($rs->PO_RecordCount())
   		{
			$displayMyMusics_arr['record_count'] = 1;
			$displayMyMusics_arr['row'] = array();
			$inc = 0;
			$count = 0;
			$thumbnail_folder = $CFG['media']['folder'].'/'.$CFG['admin']['musics']['folder'].'/'.$CFG['admin']['musics']['thumbnail_folder'].'/';
    		while($row = $rs->FetchRow())
		    {
				$displayMyMusics_arr['row'][$inc]['record'] = $row;
				$count++;
				$displayMyMusics_arr['row'][$inc]['music_path'] = '';
				$displayMyMusics_arr['row'][$inc]['widthHeightAttr'] = '';
				if($row['music_thumb_ext'] != '')
				{
					$displayMyMusics_arr['row'][$inc]['music_path'] = $row['music_server_url'].$thumbnail_folder.getMusicImageName($row['music_id']).$CFG['admin']['musics']['thumb_name'].'.'.$row['music_thumb_ext'];
					$displayMyMusics_arr['row'][$inc]['widthHeightAttr'] = DISP_IMAGE($CFG['admin']['musics']['thumb_width'], $CFG['admin']['musics']['thumb_height'], $row['thumb_width'], $row['thumb_height']);
				}
				$inc++;
			} // while
	    }
		$smartyObj->assign('displayMyMusics_arr', $displayMyMusics_arr);
	}

	function populateMusicTopContributors()
	{
		global $smartyObj, $CFG, $db, $LANG;

		$sql = 'SELECT COUNT( m.music_id ) AS total_music, sum(m.total_plays) as total_plays, m.user_id '.
				'FROM '.$CFG['db']['tbl']['music'].' AS m '.
				'WHERE music_status=\'Ok\' GROUP BY user_id ORDER BY total_music DESC LIMIT 0,'.
				$CFG['admin']['musics']['sidebar_top_contributors'];

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
		    trigger_db_error($db);
			$record_count = false;
		if ($rs->PO_RecordCount())
	    {
	    	$record_count = true;
	    	$contributor_arr = array();
			$inc=0;
			$count=1;
			//Fix for not taking music's html_footer.tpl for common pages
			$module = '';
			if(!empty($CFG['site']['is_module_page']))
				$module = $CFG['site']['is_module_page'];
			else
			{
				$CFG['site']['is_module_page'] = 'music';
			}

	        while($row = $rs->FetchRow())
			{
				if(!isset($UserDetails[$row['user_id']]))
				    $icondetail = getMemberAvatarDetails($row['user_id']);
				if(!empty($icondetail))
				{
					$user_name = getUserDetail('user_id', $row['user_id'], 'user_name');
					$contributor_arr[$inc]['profileIcon'] = $icondetail;
					$contributor_arr[$inc]['memberProfileUrl'] = getMemberProfileUrl($row['user_id'], $user_name);
					$contributor_arr[$inc]['name']	= $user_name;
					$contributor_arr[$inc]['total_stats'] = $row['total_music'];
					$contributor_arr[$inc]['total_plays'] = $row['total_plays'];
					$contributor_arr[$inc]['total_list'] = $count;
					$contributor_arr[$inc]['noBoderStyle']='';
					if($count==$CFG['admin']['musics']['sidebar_top_contributors'])
					{
                         $contributor_arr[$inc]['noBoderStyle']='clsTopContributorsNoBorderPadding';
					}
					$contributor_arr[$inc]['user_musiclist_url'] = getUrl('musiclist', '?pg=usermusiclist&user_id='.$row['user_id'], 'usermusiclist/?user_id='.$row['user_id'], '', 'music');
					$inc++;
					$count++;
				}
			}
			$smartyObj->assign('record_count', $record_count);
			$smartyObj->assign('lang_total_contributors', $LANG['sidebar_statistics_total_music']);
			$smartyObj->assign('contributor',$contributor_arr);
			setTemplateFolder('general/', 'music');
			$smartyObj->display('populateTopContributors.tpl');
			//Fix for not taking music's html_footer.tpl for common pages
			if($module == '')
				$CFG['site']['is_module_page'] = '';
	    }
	}
		// Function for viewMusic Embed Player Id Check

	function validMusicId($music_id)
	{
		global $db;
		global $CFG;
		global $LANG;
		$condition = 'p.music_status=\'Ok\' AND p.music_id='.$db->Param($musicId);
		$sql = 'SELECT music_id, allow_embed, music_server_url FROM '.$CFG['db']['tbl']['music'].' as p'.
				' WHERE '.$condition.' LIMIT 0,1';
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($music_id));
		    if (!$rs)
			    trigger_db_error($db);
		if($row = $rs->FetchRow())
			return $row;
		return false;
	}
		// Function for playlist Embed Player Id Check

	function validPlayListId($playlist_id)
	{
		global $db;
		global $CFG;
		global $LANG;

		$condition = 'p.playlist_status=\'Yes\' AND p.playlist_id='.$db->Param($playlist_id);
		$sql = 'SELECT p.allow_embed FROM '.$CFG['db']['tbl']['music_playlist'].' as p '.
				' WHERE '.$condition.' LIMIT 0,1';
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($playlist_id));
		if (!$rs)
			    trigger_db_error($db);
		if($row = $rs->FetchRow())
			return $row;
		return false;
	}

	function getRandomFieldOfMusicTable()
	{
		$rand_fields_arr = array('music_id', 'user_id', 'album_id','rating_total', 'rating_count', 'total_views');
		srand((float) microtime() * 10000000);
		$rand_keys = array_rand($rand_fields_arr);
		return $rand_fields_arr[$rand_keys];
	}

	function isAllowedMusicUpload()
	{
		global $smartyObj, $CFG, $db, $LANG;
		//return true;
		if(!isMember())
			return true;
		if(empty($CFG['admin']['musics']['allow_only_artist_to_upload'])
			or empty($CFG['admin']['musics']['music_artist_feature']))
			return true;
		if(($CFG['admin']['musics']['music_artist_feature'] AND !$CFG['admin']['musics']['allow_only_artist_to_upload'])
		 	OR (!$CFG['admin']['musics']['music_artist_feature'] AND $CFG['admin']['musics']['allow_only_artist_to_upload']))
			return true;
		$sql = 'SELECT music_user_type FROM '.$CFG['db']['tbl']['users'].
				' WHERE user_id='.$db->Param('user_id').
				' AND music_user_type=\'Artist\'';
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($CFG['user']['user_id']));
		if (!$rs)
			    trigger_db_error($db);
		if($row = $rs->FetchRow())
			return true;
		return false;
	}

	function rayzzMusicAddCart($music_id='')
	{
		global $db;
		global $CFG;
		if(!isset($_SESSION['user']['add_cart']))
			return false;
				elseif(!trim($_SESSION['user']['add_cart']))
					return false;
		$avail_cart_music_arr=explode(',',$_SESSION['user']['add_cart']);
		if(!is_array($avail_cart_music_arr))
			return false;
		$return=in_array($music_id,$avail_cart_music_arr);
		if($return!==false)
			return true;
			return false;
	}

	function rayzzMusicRemoveCart($music_id)
	{
		if(isset($_SESSION['user']['add_cart']) and trim($_SESSION['user']['add_cart']))
		{
			$avail_cart_music_arr=$to_result_arr=explode(',',$_SESSION['user']['add_cart']);
			if(is_array($avail_cart_music_arr))
			{
				foreach($avail_cart_music_arr as $index=>$value)
				{
					if($value==$music_id)
					unset($to_result_arr[$index]);
				}
			}
			$_SESSION['user']['add_cart']=implode(',',$to_result_arr);
		}
	}

	function rayzzAlbumAddCart($album_id='')
	{
		global $db;
		global $CFG;
		if(!isset($_SESSION['user']['album_add_cart']))
			return false;
				elseif(!trim($_SESSION['user']['album_add_cart']))
					return false;
		$avail_cart_album_arr=explode(',',$_SESSION['user']['album_add_cart']);
		if(!is_array($avail_cart_album_arr))
			return false;
		$return=in_array($album_id,$avail_cart_album_arr);
		if($return!==false)
			return true;
			return false;
	}

	function rayzzAlbumRemoveCart($album_id)
	{
		if(isset($_SESSION['user']['album_add_cart']) and trim($_SESSION['user']['album_add_cart']))
		{
			$avail_cart_album_arr=$to_result_arr=explode(',',$_SESSION['user']['album_add_cart']);
			if(is_array($avail_cart_album_arr))
			{
				foreach($avail_cart_album_arr as $index=>$value)
				{
					if($value==$album_id)
					unset($to_result_arr[$index]);
				}
			}
			$_SESSION['user']['album_add_cart']=implode(',',$to_result_arr);
		}
	}

	function isUserPurchased($music_id)
	{
		global $smartyObj, $CFG, $db;
		//Returned as false if duplicate entry generate
		if($CFG['user']['user_id']==0)
			return false;
		$sql = 'SELECT music_id, user_id FROM '.
				$CFG['db']['tbl']['music_purchase_user_details'].
				' WHERE music_id = '.$db->Param('music_id').
				' AND user_id = '.$db->Param('user_id');
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($music_id, $CFG['user']['user_id']));
		if (!$rs)
			trigger_db_error($db);
		if($row = $rs->FetchRow())
			return true;

		return false;
	}

	function isUserAlbumPurchased($album_id)
	{
		global $smartyObj, $CFG, $db;
		//Returned as false if duplicate entry generate
		if($CFG['user']['user_id']==0)
			return false;
		$sql = 'SELECT album_id, user_id FROM '.
				$CFG['db']['tbl']['music_album_purchase_user_details'].
				' WHERE album_id = '.$db->Param('album_id').
				' AND user_id = '.$db->Param('user_id');
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($album_id, $CFG['user']['user_id']));
		if (!$rs)
			trigger_db_error($db);
		if($row = $rs->FetchRow())
			return true;

		return false;
	}

	function getMusicAlbumDetails($album_id)
	{
		global $CFG;
		global $db;
		$sql ='SELECT album_access_type, album_title, album_price, album_for_sale '.
				'  FROM '.
				$CFG['db']['tbl']['music_album'].
		      	' WHERE music_album_id=\''.$album_id.'\' ';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		    if (!$rs)
			    trigger_db_error($db);
		if ($rs->PO_RecordCount())
		    {
		        $row = $rs->FetchRow();
				return $row;
		    }
		 return false;
	}

	function getUserType($user_id)
	{
		global $CFG;
		global $db;
		$sql ='SELECT music_user_type '.
				'  FROM '.
				$CFG['db']['tbl']['users'].
		      	' WHERE user_id=\''.$user_id.'\' ';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		    if (!$rs)
			    trigger_db_error($db);
		if ($rs->PO_RecordCount())
		    {
		        $row = $rs->FetchRow();
				return $row['music_user_type'];
		    }
		 return false;
	}

	//Used to get total music in the site - used for Site Statistics
	function getTotalMusicsInSite($user_id ='')
	{
		global $CFG;
		global $db;
		if ($user_id !='')
			$condition = ' AND user_id = '.$user_id;
		else
			$condition = '';
		$sql = ' SELECT COUNT(music_id) AS total'.
				' FROM '.$CFG['db']['tbl']['music'].
				' WHERE music_status =\'Ok\''.$condition;


		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_db_error($db);

		$row = $rs->FetchRow();

		if($row['total'])
		{
			$link_url = getUrl('musiclist', '?pg=musicnew', 'musicnew/', '', 'music');
			$row['total'] = '<a href="'.$link_url.'">'.$row['total'].'</a>';
		}
		return $row['total'];
	}

	function getPurchasedUserDetails($album_id)
	{
		global $CFG;
		global $db;
		$user_id = '';
		$sql = 'SELECT GROUP_CONCAT( user_id )  as user_ids '.
				'FROM '.$CFG['db']['tbl']['music_album_purchase_user_details'].' '.
				'WHERE album_id = '.$db->Param('album_id');

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($album_id));
		    if (!$rs)
			    trigger_db_error($db);

		if ($row = $rs->FetchRow())
			{
				if($row['user_ids']!='')
					$user_id = explode(',', $row['user_ids']);
		    }
		//Returned the user_id by checking the empty
		return $user_id;
	}

	function insertUploadDefaultDetailsForMusic($user_id,$user_name)
	{
		global $smartyObj, $CFG, $db, $LANG;
		$sql = 'SELECT music_category_id FROM '.$CFG['db']['tbl']['music_category'].
				' WHERE parent_category_id='.$db->Param('parent_category_id').
				' AND music_category_status ='.$db->Param('music_category_status').
				' LIMIT 0,1';
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array(0,'Yes'));
	    if (!$rs)
		    trigger_db_error($db);
		if($row = $rs->FetchRow())
		{
			$music_category_id = $row['music_category_id'];
		}
		else
		{
			$music_category_id = 0;
		}

		$param_value_arr = array();
		$sql = 'INSERT INTO '.$CFG['db']['tbl']['music_user_default_settings'].' SET '.
				' preview_start = '.$db->Param('trim_music_start_position').', '.
				' preview_end = '.$db->Param('trim_music_duration').', '.
				' music_tags = '.$db->Param('user_name').', '.
				' music_category_id ='.$db->Param('music_category_id').', '.
				' user_id='.$db->Param('user_id');

		$param_value_arr = array($CFG['admin']['musics']['trim_music_start_position'],$CFG['admin']['musics']['trim_music_duration'],$user_name,$music_category_id,$user_id);
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, $param_value_arr);
		if (!$rs)
		    trigger_db_error($db);

		$sql = 'INSERT INTO '.$CFG['db']['tbl']['music_user_payment_settings'].' SET '.
				'threshold_amount='.$db->Param('threshold_amount').','.
				'user_id='.$db->Param('user_id');
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($CFG['admin']['musics']['minimum_threshold_amount'], $user_id));
		if (!$rs)
		    trigger_db_error($db);
	}

	function roundValue($round_val, $precision='')
	{
		if(is_numeric($precision))
			return round($round_val, $precision);
		else
			return round($round_val, 2);
	}
	function checkValidArtist()
	{
	    global $smartyObj, $CFG, $db, $LANG;
		$sql = 'SELECT music_user_type FROM '.$CFG['db']['tbl']['users'].
				' WHERE user_id='.$db->Param('user_id').
				' AND music_user_type=\'Artist\'';
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($CFG['user']['user_id']));
		if (!$rs)
			    trigger_db_error($db);
		if($row = $rs->FetchRow())
		{
			if($row['music_user_type']=='Artist')
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}

	function checkMusicForSale($music_id)
	{
		global $smartyObj, $CFG, $db, $LANG;
		$sql = 'SELECT music_id, m.for_sale, m.music_price, al.album_access_type, al.music_album_id, al.album_for_sale, al.album_price'.
				' FROM '.$CFG['db']['tbl']['music'].' as m LEFT JOIN '.$CFG['db']['tbl']['music_album'].' as al '.
				' ON m.music_album_id=al.music_album_id WHERE m.music_id='.$db->Param('music_id').
				' AND ((for_sale=\'Yes\' AND music_price > 0) OR (album_access_type=\'Private\' AND album_for_sale=\'Yes\' AND album_price > 0))';
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($music_id));
		if (!$rs)
			    trigger_db_error($db);
		if($row = $rs->FetchRow())
		{
			return $row;
		}
		else
			return false;
	}
?>
