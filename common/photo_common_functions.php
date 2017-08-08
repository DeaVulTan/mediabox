<?php
	function getPhotoRelatedStats()
	{
		global $CFG;
		global $db;
		$sql =' SELECT COUNT(DISTINCT(photo_id)) AS total_photo_viewed FROM '.
				  $CFG['db']['tbl']['photo_viewed'];

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
	    if (!$rs)
		    trigger_db_error($db);

		if($row = $rs->FetchRow())
		{
			if($row['total_photo_viewed'])
			{
				$link_url = getUrl('photolist', '?pg=photomostviewed', 'photomostviewed/', 'members', 'photo');
				$row['total_photo_viewed'] = '<a href="'.$link_url.'">'.$row['total_photo_viewed'].'</a>';
		  	   	return $row['total_photo_viewed'];
			}
		}
		return 0;
	}

	function getMyDashboardPhotoLinks()
	{
		global $LANG;
		$photodash_arr=array();

		$photodash_arr['shortcuts'][0]['link_url'] = getUrl('photouploadpopup', '', '', 'members', 'photo');
		$photodash_arr['shortcuts'][0]['link_name'] = $LANG['mydahsboard_uploadphoto_title'];

		$photodash_arr['shortcuts'][1]['link_url']=getUrl('photolist', '?pg=myphotos', 'myphotos/', '', 'photo');
		$photodash_arr['shortcuts'][1]['link_name']=$LANG['mydahsboard_myphoto_title'];

		$photodash_arr['stats'][0]['link_url']=getUrl('photolist', '?pg=myphotos', 'myphotos/', '', 'photo');
		$photodash_arr['stats'][0]['link_name']=$LANG['mydahsboard_photo_stats_link_myphotos'];
		$getTotalPhotos = getTotalPhotos();
		if ($getTotalPhotos)
			{
				$stats_value = explode(':', $getTotalPhotos);
				$photodash_arr['stats'][0]['stats_value']=$stats_value[1];
			}

		return $photodash_arr;
	}

	function getTotalPhotos($user_id='', $with_link=0)
		{
		   	global $CFG;
			global $db;
			global $LANG;
			if($user_id=='')
				$user_id = $CFG['user']['user_id'];
			$sql =' SELECT total_photos FROM '.$CFG['db']['tbl']['users'].' WHERE user_id='.$user_id;

			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt);
		    if (!$rs)
			    trigger_db_error($db);
			if($row = $rs->FetchRow())
				{
					if($with_link)
						return $photo_list_url = '<a href="'.getUrl('photolist', '?pg=userphotolist&amp;user_id='.$user_id, 'userphotolist/?user_id='.$user_id,'','photo').'">'.$row['total_photos'].'</a>';
					else
			  	   		return $LANG['common_photos'].': <span>'.$row['total_photos'].'</span>';
				}
			return false;
		}
		function getTotalUsersPhotos($user_id='', $with_link=0)
		{
		   	global $CFG;
			global $db;
			global $LANG;
			if($user_id=='')
				$user_id = $CFG['user']['user_id'];
			$sql =' SELECT total_photos FROM '.$CFG['db']['tbl']['users'].' WHERE user_id='.$user_id;

			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt);
		    if (!$rs)
			    trigger_db_error($db);
			if($row = $rs->FetchRow())
				{
					if ($row['total_photos']>0) {
						if($with_link)
							return $photo_list_url = $LANG['common_photos'].': <span><a href="'.getUrl('photolist', '?pg=userphotolist&amp;user_id='.$user_id, 'userphotolist/?user_id='.$user_id,'','photo').'">'.$row['total_photos'].'</a></span>';
						else
				  	   		return $LANG['common_photos'].': <span>'.$row['total_photos'].'</span>';
			  		}
			  		else
			  				return $LANG['common_photos'].': <span>'.$row['total_photos'].'</span>';
				}
			return false;
		}
	   function getTotalPhotosFavourite()
	    {
       	    global $CFG;
	    	global $db;
			$sql = 'SELECT COUNT(DISTINCT photo_id) AS cnt FROM '.$CFG['db']['tbl']['photo_favorite'].
					' WHERE user_id=\''.$CFG['user']['user_id'].'\'';
            $stmt = $db->Prepare($sql);
            $rs = $db->Execute($stmt);
                if (!$rs)
            	    trigger_db_error($db);
			if ($rs->PO_RecordCount())
			    {
			        $row = $rs->FetchRow();
					$count = $row['cnt'];
			    }
			$count = number_format($count);
			return $count;
		}
	  function getTotalPhotosViews($user_id='')
    	{
    	   	global $CFG;
        	global $db;

    		if($user_id == '')
    			$user_id = $CFG['user']['user_id'];

    		$sql = 'SELECT SUM(total_views) AS cnt FROM '.$CFG['db']['tbl']['photo'].' WHERE user_id=\''.$user_id.'\' ';

            $stmt = $db->Prepare($sql);
            $rs = $db->Execute($stmt);
    		if (!$rs)
    			trigger_db_error($db);

    		if ($rs->PO_RecordCount())
    		    {
    		        $row = $rs->FetchRow();
    				$count = $row['cnt'];
    		    }
    		$count = number_format($count);
    		return $count;
    	}
	  function getMyFooterPhotoLinks()
	{
		global $LANG;
		$photofooter_arr=array();

		//links to be shown All Photos, My Photos, My slidelists, Favorite photos, RSS Photos

		$photofooter_arr[0]['link_url']=getUrl('photolist','?pg=photonew', 'photonew/','','photo');
		$photofooter_arr[0]['link_name']=$LANG['footer_photo_link_allphotoslist'];

		$photofooter_arr[1]['link_url']=getUrl('photolist', '?pg=myphotos', 'myphotos/', '', 'photo');
		$photofooter_arr[1]['link_name']=$LANG['footer_photo_link_photoslist'];

		$photofooter_arr[2]['link_url']=getUrl('photoslidelist', '?pg=myslidelist', 'myslidelist/', 'members', 'photo');
		$photofooter_arr[2]['link_name']=$LANG['footer_photo_link_photoplaylist'];

		$photofooter_arr[3]['link_url']=getUrl('photolist', '?pg=myfavoritephotos', 'myfavoritephotos/', '', 'photo');
		$photofooter_arr[3]['link_name']=$LANG['footer_photo_link_photofavorites'];

		$photofooter_arr[4]['link_url'] = getUrl('rssphoto','','','','photo');
		$photofooter_arr[4]['link_name'] = $LANG['footer_photo_link_rss'];

		return $photofooter_arr;
	}
	function getMyHomePhotoShortcuts()
	{
		global $LANG;
		$myhomeshortcut_arr=array();
		$myhomeshortcut_arr['viewmy']['link_url']=getUrl('photolist', '?pg=myphotos', 'myphotos/', '', 'photo');
		$myhomeshortcut_arr['viewmy']['link_name']=$LANG['myhome_shortcuts_link_photos'];
		$myhomeshortcut_arr['setting']['link_url']=getUrl('photouploadpopup', '', '', 'members', 'photo');
		$myhomeshortcut_arr['setting']['link_name']=$LANG['myhome_shortcuts_link_uploadphotos'];
		return $myhomeshortcut_arr;
	}
	function populateAdminPhotoLeftNavigation($header)
	{
	   	 global $smartyObj;
		 if($header->_currentPage=='photoslidelistmanage')
			$header->_navigationArr['left_photoslidelist'] = $header->_clsActiveLink;

		 setTemplateFolder('admin/','photo');
		 $smartyObj->assign('admin_main_menu_arrays', additionalAdminPhotoMenuLink());
		 $smartyObj->display('left_photo_navigation_links.tpl');
	 ?>
	   	 <script language="javascript" type="text/javascript">
	   	   var inc = divArray.length;
	   	   var temp_photo_menu_array = new Array('photoMain', 'photoSetting', 'photoPlugin');
	   	   for(jnc=0;jnc<temp_photo_menu_array.length;jnc++)
				divArray[inc++] = temp_photo_menu_array[jnc];
	   	 </script>
	<?php
	}
	function getPhotoAlbumName($album_id)
	{
		global $CFG;
		global $db;
		$sql ='SELECT photo_album_title FROM '.$CFG['db']['tbl']['photo_album'].
		      ' WHERE photo_album_id=\''.$album_id.'\' ';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		    if (!$rs)
			    trigger_db_error($db);
		if ($rs->PO_RecordCount())
		    {
		        $row = $rs->FetchRow();
				return $row['photo_album_title'];
		    }
		 return false;
	}
	function getPhotoAlbumType($album_id)
	{
		global $CFG;
		global $db;
		$sql ='SELECT album_access_type FROM '.$CFG['db']['tbl']['photo_album'].
		      ' WHERE photo_album_id=\''.$album_id.'\' ';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		    if (!$rs)
			    trigger_db_error($db);
		if ($rs->PO_RecordCount())
		    {
		        $row = $rs->FetchRow();
				return $row['album_access_type'];
		    }
		 return false;
	}
	function additionalAdminPhotoMenuLink(){
			global $CFG;
			global $db;
			global $smartyObj;

			$sql ='SELECT * FROM '.$CFG['db']['tbl']['additional_menu_links'].' WHERE module = \'photo\' AND menu_type=\'main\' AND status =\'yes\' AND parent_id =0 ';
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
					var temp_photo_menu_array  = new Array();
					temp_photo_menu_array = temp_menu_array.split(',');
					for(jnc=0;jnc<temp_photo_menu_array.length;jnc++){
						if((divArray.join().indexOf(temp_photo_menu_array[jnc])>=0) == false)
							divArray[inc++] = temp_photo_menu_array[jnc];
					}
				</script>
<?php
				//echo '<pre>'; print_r($admin_menu_arrays); echo '</pre>';
				return $admin_menu_arrays;
			}
		}
	function adminPhotoStatistics()
	{
	    global $CFG;
		global $db;
		global $smartyObj;
        $photoStatistics_arr = array();
        //Total Active photo...
		$sql = 'SELECT count(photo_id) as total FROM '.$CFG['db']['tbl']['photo'].
				' WHERE photo_status = \'Ok\' ';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_db_error($db);

		$row = $rs->FetchRow();
		$photoStatistics_arr['total_active_photo'] = $row['total'];

		//Waiting for activation photos
		$sql = 'SELECT count(photo_id) as total FROM '.$CFG['db']['tbl']['photo'].
				' WHERE photo_status = \'Locked\' ';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_db_error($db);

		$row = $rs->FetchRow();
		$photoStatistics_arr['total_toactivate_photo'] = $row['total'];


		//Today
		$sql = 'SELECT count(photo_id) as total FROM '.$CFG['db']['tbl']['photo'].
				' WHERE photo_status = \'Ok\'  AND DATE_FORMAT(date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_db_error($db);

		$row = $rs->FetchRow();
		$photoStatistics_arr['total_today_photo'] = $row['total'];

		//This week
		$sql = 'SELECT count(photo_id) as total FROM '.$CFG['db']['tbl']['photo'].
				' WHERE photo_status = \'Ok\'  AND DATE_SUB( CURDATE( ) , INTERVAL 7 DAY ) <= date_added';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_db_error($db);

		$row = $rs->FetchRow();
		$photoStatistics_arr['this_week_photo'] = $row['total'];

		//This month
		$sql = 'SELECT count(photo_id) as total FROM '.$CFG['db']['tbl']['photo'].
				' WHERE photo_status = \'Ok\'  AND DATE_SUB( CURDATE( ) , INTERVAL 30 DAY ) <= date_added';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_db_error($db);

		$row = $rs->FetchRow();
	    $photoStatistics_arr['this_month_photo'] = $row['total'];
		$smartyObj->assign('photoStatistics_arr', $photoStatistics_arr);
	}

	function getPhotoName($text)
	{
		$file_name = getPhotoFileSettingName($text,'Photo');
		$text = md5($file_name.$text);
		return substr($text, 0, 15);
	}

	function getPhotoFileSettingName($photo_id, $file_type)
	{
		global $CFG;
		global $db;
		$photo_file_id = getPhotoFileSettingId($photo_id, $file_type);
	   	if(!$photo_file_id)
		   $photo_file_id = getCurrentPhotoFileSettingId($file_type);

		$sql = 'SELECT file_name FROM '.$CFG['db']['tbl']['photo_files_settings'].
				' WHERE photo_file_id=\''.$photo_file_id.'\'';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
	    if (!$rs)
		    trigger_db_error($db);

		if($row = $rs->FetchRow())
			return $row['file_name'];
		return false;
	}

	function getPhotoFileSettingId($photo_id, $file_type)
	{
		global $CFG;
		global $db;

		$field_name = 1;
		if($file_type == 'Photo')
		  $field_name = 'photo_file_name_id';
		$sql = 'SELECT '.$field_name.' FROM '.$CFG['db']['tbl']['photo'].
				' WHERE photo_id=\''.$photo_id.'\'';
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
	    if (!$rs)
		    trigger_db_error($db);

		if($row = $rs->FetchRow())
			return $row[$field_name];
		return false;
	}

	 function getCurrentPhotoFileSettingId($file_type)
	{
		global $CFG;
		global $db;
		$sql = 'SELECT photo_file_id FROM '.$CFG['db']['tbl']['photo_files_settings'].
				' WHERE  status =\'Yes\' AND  file_type=\''.$file_type.'\'';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
	    if (!$rs)
			trigger_db_error($db);

		if($row = $rs->FetchRow())
			return  $row['photo_file_id'];
		return false;
	}


	function displayMyPhotos($start=0, $photoLimit=4, $userID)
	{
		global $CFG;
		global $db;
		global $smartyObj;

		$displayMyPhotos_arr = array();
		$condition = 'photo_status=\'Ok\' AND user_id=\''.$userID.'\'';

		$sql = 'SELECT photo_id, photo_ext, t_width, t_height, photo_server_url, photo_title'.
				' FROM '.$CFG['db']['tbl']['photo'].' WHERE '.$condition.' ORDER BY'.
				' photo_id DESC LIMIT '.$start.','.$photoLimit;

	    $stmt = $db->Prepare($sql);
	    $rs = $db->Execute($stmt);
	    if (!$rs)
	    	trigger_db_error($db);

	    $row = array();
	   	$displayMyPhotos_arr['record_count'] = 0;
		if ($rs->PO_RecordCount())
   		{
			$displayMyPhotos_arr['record_count'] = 1;
			$displayMyPhotos_arr['row'] = array();
			$inc = 0;
			$count = 0;
			$thumbnail_folder = $CFG['media']['folder'].'/'.$CFG['admin']['photos']['folder'].'/'.$CFG['admin']['photos']['photo_folder'].'/';
    		while($row = $rs->FetchRow())
		    {
				$displayMyPhotos_arr['row'][$inc]['record'] = $row;
				$count++;
				$displayMyPhotos_arr['row'][$inc]['photo_path'] = '';
				$displayMyPhotos_arr['row'][$inc]['widthHeightAttr'] = '';
				if($row['photo_ext'] != '')
				{
					$displayMyPhotos_arr['row'][$inc]['photo_path'] = $row['photo_server_url'].$thumbnail_folder.getPhotoImageName($row['photo_id']).$CFG['admin']['photos']['thumb_name'].'.'.$row['photo_ext'];
					$displayMyPhotos_arr['row'][$inc]['widthHeightAttr'] = DISP_IMAGE($CFG['admin']['photos']['thumb_width'], $CFG['admin']['photos']['thumb_height'], $row['t_width'], $row['t_height']);
				}
				$inc++;
			} // while
	    }
		$smartyObj->assign('displayMyPhotos_arr', $displayMyPhotos_arr);
	}

	function populatePhotoTopContributors()
	{
		global $smartyObj, $CFG, $db, $LANG;
		if($CFG['site']['script_name'] == 'index.php')
			$limit = $CFG['admin']['photos']['sidebar_top_contributors'];
		else
		 	$limit = $CFG['admin']['photos']['sidebar_memberlist_top_contributors'];
		$sql = 'SELECT COUNT( m.photo_id ) AS total_photo, m.user_id '.
				'FROM '.$CFG['db']['tbl']['photo'].' AS m '.
				'WHERE photo_status=\'Ok\' GROUP BY user_id ORDER BY total_photo DESC LIMIT 0,'.$limit;

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
			$CFG['site']['is_module_page'] = 'photo';
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
					$contributor_arr[$inc]['total_stats'] = $row['total_photo'];
					$contributor_arr[$inc]['user_photolist_url'] = getUrl('photolist', '?pg=userphotolist&user_id='.$row['user_id'], 'userphotolist/?user_id='.$row['user_id'], '', 'photo');
					$inc++;
				}
			}
			$smartyObj->assign('record_count', $record_count);
			$smartyObj->assign('lang_total_contributors', $LANG['sidebar_statistics_total_photo']);
			$smartyObj->assign('contributor',$contributor_arr);
			setTemplateFolder('general/', 'photo');
			$smartyObj->display('populateTopContributors.tpl');
			$CFG['site']['is_module_page'] = '';
	    }
	}
		// Function for viewPhoto Embed Player Id Check

	function validPhotoId($photo_id)
	{
		global $db;
		global $CFG;
		global $LANG;
		if (!$photoId=$photo_id)
	        return false;
		$condition = 'p.photo_status=\'Ok\' AND SUBSTRING(MD5(p.photo_id), 1, 25)='.$db->Param($photoId);
		$sql = 'SELECT photo_id, allow_embed, photo_server_url FROM '.$CFG['db']['tbl']['photo'].' as p'.
				' WHERE '.$condition.' LIMIT 0,1';
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($photoId));
		    if (!$rs)
			    trigger_db_error($db);
		if($row = $rs->FetchRow())
			return $row;
		return false;
	}

	function getRandomFieldOfPhotoTable()
	{
		$rand_fields_arr = array('photo_id', 'user_id', 'album_id','rating_total', 'rating_count', 'total_views');
		srand((float) microtime() * 10000000);
		$rand_keys = array_rand($rand_fields_arr);
		return $rand_fields_arr[$rand_keys];
	}
	function isAllowedPhotoUpload()
	{
		global $smartyObj, $CFG, $db, $LANG;
		return true;
		if(!isMember())
			return true;
		if(empty($CFG['admin']['photos']['allow_only_artist_to_upload'])
			or empty($CFG['admin']['photos']['photo_artist_feature']))
			return true;
		if(($CFG['admin']['photos']['photo_artist_feature'] AND !$CFG['admin']['photos']['allow_only_artist_to_upload'])
		 	OR (!$CFG['admin']['photos']['photo_artist_feature'] AND $CFG['admin']['photos']['allow_only_artist_to_upload']))
			return true;
		$sql = 'SELECT photo_user_type FROM '.$CFG['db']['tbl']['users'].
				' WHERE user_id='.$db->Param('user_id').
				' AND photo_user_type=\'Artist\'';
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($CFG['user']['user_id']));
		if (!$rs)
			    trigger_db_error($db);
		if($row = $rs->FetchRow())
			return true;
		return false;
	}
	function insertUploadDefaultDetailsForPhoto($user_id,$user_name)
	{
		global $smartyObj, $CFG, $db, $LANG;
		$sql = 'SELECT photo_category_id FROM '.$CFG['db']['tbl']['photo_category'].
				' WHERE parent_category_id='.$db->Param('parent_category_id').
				' AND photo_category_status ='.$db->Param('photo_category_status').
				' LIMIT 0,1';
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array(0,'Yes'));
	    if (!$rs)
		    trigger_db_error($db);
		if($row = $rs->FetchRow())
		{
			$photo_category_id = $row['photo_category_id'];
		}
		else
		{
			$photo_category_id = 0;
		}
		$album_type = 'Private';
		$sql = 'INSERT INTO '.$CFG['db']['tbl']['photo_album'].
			   	' SET photo_album_title ='.$db->Param('photo_album').', '.
			   	' album_access_type ='.$db->Param('album_type').', '.
			   	' user_id ='.$db->Param('user_id').', '.
			   	' date_added = now()';
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($user_name,$album_type,$user_id));
		if (!$rs)
		   	trigger_db_error($db);
		$album_id = $db->Insert_ID();
		$param_value_arr = array();
		$sql = 'INSERT INTO '.$CFG['db']['tbl']['photo_user_default_setting'].' SET '.
				'album_id = '.$db->Param('album_id').', '.
				'photo_tags = '.$db->Param('user_name').', '.
							   	' photo_category_id ='.$db->Param('photo_category_id').', '.
				'user_id='.$db->Param('user_id');

		$param_value_arr = array($album_id,$user_name,$photo_category_id,$user_id);
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, $param_value_arr);
		if (!$rs)
		    trigger_db_error($db);
	}

	function rayzzPhotoQuickMix($photo_id='')
	{
		global $db;
		global $CFG;
		if(!isset($_SESSION['user']['photo_quick_mixs']))
			return false;
				elseif(!trim($_SESSION['user']['photo_quick_mixs']))
					return false;
		$avail_quick_mix_photo_arr=explode(',',$_SESSION['user']['photo_quick_mixs']);
		if(!is_array($avail_quick_mix_photo_arr))
			return false;
		$return=in_array($photo_id,$avail_quick_mix_photo_arr);
		if($return!==false)
			return true;
			return false;
	}
	//have changed the function name when integrate with volume.
	function rayzzRMQuickMixPhoto($photo_id)
	{
		if(isset($_SESSION['user']['photo_quick_mixs']) and trim($_SESSION['user']['photo_quick_mixs']))
		{
			$avail_quick_mix_photo_arr=$to_result_arr=explode(',',$_SESSION['user']['photo_quick_mixs']);
			if(is_array($avail_quick_mix_photo_arr))
			{
				foreach($avail_quick_mix_photo_arr as $index=>$value)
				if($value==$photo_id)
				unset($to_result_arr[$index]);
			}
			$_SESSION['user']['photo_quick_mixs']=implode(',',$to_result_arr);
		}
	}

	function populatephotoFeaturedMembers()
	{
		global $smartyObj, $CFG, $db, $LANG;
		$sql = 'SELECT u.user_id,u.total_photos,u.total_friends,u.featured_description,u.user_name,u.city '.'FROM '.$CFG['db']['tbl']['users'].' AS u '.
				'WHERE usr_status=\'Ok\' AND featured =\'Yes\' GROUP BY user_id ORDER BY rand() LIMIT 0,'.
				$CFG['admin']['photos']['sidebar_featured_members'];

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
			$CFG['site']['is_module_page'] = 'photo';
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
					$contributor_arr[$inc]['user_photolist_url'] = getUrl('photolist', '?pg=userphotolist&user_id='.$row['user_id'], 'userphotolist/?user_id='.$row['user_id'], '', 'photo');
					$contributor_arr[$inc]['city']	= $row['city'];
					$contributor_arr[$inc]['total_photos']	= $row['total_photos'];
					$contributor_arr[$inc]['total_friends']	= $row['total_friends'];
					$contributor_arr[$inc]['featured_description']	= $row['featured_description'];
					$inc++;
				}
			}
			$smartyObj->assign('record_count', $record_count);
			$smartyObj->assign('lang_total_contributors', $LANG['sidebar_statistics_total_photo']);
			$smartyObj->assign('contributor',$contributor_arr);
			setTemplateFolder('general/', 'photo');
			$smartyObj->display('populateFeaturedMembers.tpl');
	    }
	}
	//Used to get total photos in the site - used for Site Statistics
	function getTotalPhotosInSite($user_id ='')
	{
		global $CFG;
		global $db;
		if ($user_id !='')
			$condition = ' AND user_id = '.$user_id;
		else
			$condition = '';
		$sql = ' SELECT COUNT(photo_id) AS total'.
				' FROM '.$CFG['db']['tbl']['photo'].
				' WHERE photo_status =\'Ok\''.$condition;
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_db_error($db);

		$row = $rs->FetchRow();

		if($row['total'])
		{
			$link_url = getUrl('photolist','?pg=photonew', 'photonew/','','photo');
			$row['total'] = '<a href="'.$link_url.'">'.$row['total'].'</a>';
		}
		return $row['total'];
	}

	function getPhotoImageName($text, $thumb_name='')
	{
		global $CFG;
		if(!$thumb_name)
			$thumb_name=getPhotoFileSettingName($text,'Thumb');

		$text = md5($thumb_name.$text);
		return substr($text, 0, 15);
	}
   function updatePhotoTotalViews($photo_id)
	{
	    global $CFG;
		global $db;

 		$sql = 'UPDATE '.$CFG['db']['tbl']['photo'].
 				' SET  total_views = total_views+1, last_view_date=NOW()'.
 				' WHERE photo_id = '.$db->Param('photo_id');

 		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($photo_id));
		 if (!$rs)
			    trigger_db_error($db);
	}
    function changePhotoViewed($photo_id,$owner_id=0)
	{
	    global $CFG;
		global $db;

		$sql = 	'SELECT photo_viewed_id FROM '.$CFG['db']['tbl']['photo_viewed'].
				' WHERE photo_id='.$db->Param('photo_id').' AND '.
				' DATE_FORMAT(view_date, \'%Y-%m-%d\') = CURDATE()';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($photo_id));
		    if (!$rs)
			    trigger_db_error($db);

		if($rs->PO_RecordCount())
		{

		    $row = $rs->FetchRow();
		    $photo_viewed_id = $row['photo_viewed_id'];

			$sql = 'UPDATE '.$CFG['db']['tbl']['photo_viewed'].' SET '.
					'total_views=total_views+1, user_id='.$db->Param('user_id').', view_date=NOW() '.
					'WHERE photo_viewed_id='.$db->Param('photo_viewed_id');

			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt, array($CFG['user']['user_id'], $photo_viewed_id));
			    if (!$rs)
				    trigger_db_error($db);

		 }
		 else
		 {
			$sql = 'INSERT INTO '.$CFG['db']['tbl']['photo_viewed'].' SET'.
					' user_id='.$db->Param('user_id').','.
					' photo_id='.$db->Param('photo_id').','.
					' photo_owner_id='.$db->Param('photo_owner_id').','.
					' total_views=1,'.
					' view_date=NOW()';

			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt, array($CFG['user']['user_id'], $photo_id, $owner_id));
			    if (!$rs)
				    trigger_db_error($db);
		}

	}
	function getPhotoUrl($photo_id)
	{
		global $CFG;
		global $db;

		$sql = 'SELECT photo_server_url,photo_ext FROM '.$CFG['db']['tbl']['photo'].' '.
		       'WHERE photo_id = '.$db->Param('photo_id');

		$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt, array($photo_id));
			if (!$rs)
				trigger_db_error($db);
		$photo_path='';
		$photos_folder = $CFG['media']['folder'].'/'.$CFG['admin']['photos']['folder'].'/'.$CFG['admin']['photos']['photo_folder'].'/';
		 if($row = $rs->FetchRow())
		    {
		    $photo_path= $row['photo_server_url'].$photos_folder.getPhotoName($photo_id).$CFG['admin']['photos']['small_name'].'.'.$row['photo_ext'];
		    }
		return $photo_path;
	}
	function removeMovieQueuePhoto($photo_id)
	{
		if(isset($_SESSION['user']['movie_photo_queue']) and trim($_SESSION['user']['movie_photo_queue']))
		{
			$avail_movie_queue_photo_arr=$to_result_arr=explode(',',$_SESSION['user']['movie_photo_queue']);
			if(is_array($avail_movie_queue_photo_arr))
			{
				foreach($avail_movie_queue_photo_arr as $index=>$value)
				if($value==$photo_id)
				unset($to_result_arr[$index]);
			}
			$_SESSION['user']['movie_photo_queue']=implode(',',$to_result_arr);
		}
	}
	function checkPhotoInMovieQueue($photo_id='')
	{
		global $db;
		global $CFG;
		if(!isset($_SESSION['user']['movie_photo_queue']))
			return false;
				elseif(!trim($_SESSION['user']['movie_photo_queue']))
					return false;
		$avail_movie_queue_photo_arr=explode(',',$_SESSION['user']['movie_photo_queue']);
		if(!is_array($avail_movie_queue_photo_arr))
			return false;
		$return=in_array($photo_id,$avail_movie_queue_photo_arr);
		if($return!==false)
			return true;
			return false;
	}
	function getPhotoMovieName($text)
	{
		$text = md5($text);
		return substr($text, 0, 15);
	}
	function validMovieIdRevised($movie_id)
	{
		global $db;
		global $CFG;
		global $LANG;
		if (!$movie_id)
	        return false;
		$condition = 'pmm.movie_status=\'Ok\' AND pmm.photo_movie_id='.$db->Param($movie_id);
		$sql = 'SELECT photo_movie_id,movie_server_url,allow_embed FROM '.$CFG['db']['tbl']['photo_movie_maker'].' as pmm'.
				' WHERE '.$condition.' LIMIT 0,1';
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($movie_id));
		    if (!$rs)
			    trigger_db_error($db);
		if($row = $rs->FetchRow())
			return $row;
		return false;
	}

	//Used to get total slidelist in the site
	function getTotalPhotoSlidelistInSite()
	{
		global $CFG;
		global $db;
		$sql = 'SELECT COUNT(DISTINCT photo_playlist_id) AS total_playlist FROM '.
				$CFG['db']['tbl']['photo_playlist'].' WHERE photo_playlist_status=\'Yes\'';

		$paramFields = array();
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, $paramFields);
		if (!$rs)
			trigger_error($db->ErrorNo().' '.
				$db->ErrorMsg(), E_USER_ERROR);

		if ($rs->PO_RecordCount())
		{
			if($row = $rs->FetchRow())
			{
  				if($row['total_playlist'])
  				{
  					$all_slidelist_url = getUrl('photoslidelist', '?pg=slidelistnew', 'slidelistnew/', '', 'photo');
  					return '<a href="'.$all_slidelist_url.'">'.$row['total_playlist'].'</a>';
  				}
			}
		}
		return 0;
	}

?>
