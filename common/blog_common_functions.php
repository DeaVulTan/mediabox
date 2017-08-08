<?php
	function getBlogRelatedStats()
	{
		global $CFG;
		global $db;
		$sql =' SELECT SUM(total_views) AS total_blog_viewed FROM '.
				  $CFG['db']['tbl']['blog_viewed'];

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		    if (!$rs)
			    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);

		if($row = $rs->FetchRow())
		{
		if($row['total_blog_viewed'])
	  	   return $row['total_blog_viewed'];
	  	else
	       return 0;
		}
	}
	function populateAdminBlogLeftNavigation($header)
	{
	   	 global $smartyObj;

		 setTemplateFolder('admin/','blog');
		 $smartyObj->display('left_blog_navigation_links.tpl');
	 ?>
	   	 <script language="javascript" type="text/javascript">
	   	   var inc = divArray.length;
	   	   var temp_blog_menu_array = new Array('blogMain', 'blogSetting');
	   	   for(jnc=0;jnc<temp_blog_menu_array.length;jnc++)
				divArray[inc++] = temp_blog_menu_array[jnc];
	   	 </script>
	<?php
	}
	function getTotalPosts($blog_id)
	{
		global $CFG;
		global $db;
		$sql ='SELECT COUNT(blog_post_id) AS total_post FROM '.$CFG['db']['tbl']['blog_posts'].
		       ' WHERE status=\'Ok\' AND blog_id='.$blog_id;

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		    if (!$rs)
			    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);

		if($row = $rs->FetchRow())
		 return $row['total_post'];
	   return 0;
	}
	function getTotalUsersPosts($user_id,$with_link=0)
	{
			global $CFG;
			global $db;
			global $LANG;
			$sql =	'SELECT total_posts'.
					' FROM '.$CFG['db']['tbl']['users'].' WHERE user_id='.$user_id.' AND usr_status=\'OK\'';
			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt);
			if (!$rs)
			trigger_error($db->ErrorNo().' '.
			$db->ErrorMsg(), E_USER_ERROR);
			if ($rs->PO_RecordCount())
			{
				if($row = $rs->FetchRow())
				{
					if ($row['total_posts']>0) {
				  	   	if($with_link)
							return $blog_list_url = $LANG['common_posts'].': <span><a href="'.getUrl('blogpostlist','?pg=userblogpostlist&user_id='.$user_id,'userblogpostlist/'.$user_id.'/','','blog').'">'.$row['total_posts'].'</a></span>';
						else
				  	   		return $LANG['common_posts'].': <span>'.$row['total_posts'].'</span>';
			  	   }
			  	   else
			  	   		return $LANG['common_posts'].': <span>'.$row['total_posts'].'</span>';

				}
			}
	   return 0;
	}
	function getPostIds($blog_id)
	{
		global $CFG;
		global $db;
		$sql ='SELECT blog_post_id FROM '.$CFG['db']['tbl']['blog_posts'].
		       ' WHERE blog_id='.$blog_id;

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		    if (!$rs)
			    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);
		$post_id_arr=array();
		while($row = $rs->FetchRow())
		{
			$post_id_arr[]=$row['blog_post_id'];
		}
		 return $post_id_arr;
	}

	function adminBlogStatistics()
	{
	    global $CFG;
		global $db;
		global $smartyObj;
        $blogStatistics_arr = array();
        //Total Active blog...
		$sql = 'SELECT count(blog_id) as total FROM '.$CFG['db']['tbl']['blogs'].
				' WHERE blog_status = \'Active\' ';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_db_error($db);

		$row = $rs->FetchRow();
		$blogStatistics_arr['total_active_blog'] = $row['total'];

		//Waiting for activation blogs
		$sql = 'SELECT count(blog_id) as total FROM '.$CFG['db']['tbl']['blogs'].
				' WHERE blog_status = \'Toactivate\' ';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_db_error($db);

		$row = $rs->FetchRow();
		$blogStatistics_arr['total_toactivate_blog'] = $row['total'];


		//Today
		$sql = 'SELECT count(blog_id) as total FROM '.$CFG['db']['tbl']['blogs'].
				' WHERE blog_status = \'Ok\'  AND DATE_FORMAT(date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_db_error($db);

		$row = $rs->FetchRow();
		$blogStatistics_arr['total_today_blog'] = $row['total'];

		//This week
		$sql = 'SELECT count(blog_id) as total FROM '.$CFG['db']['tbl']['blogs'].
				' WHERE blog_status = \'Active\'  AND DATE_SUB( CURDATE( ) , INTERVAL 7 DAY ) <= date_added';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_db_error($db);

		$row = $rs->FetchRow();
		$blogStatistics_arr['this_week_blog'] = $row['total'];

		//This month
		$sql = 'SELECT count(blog_id) as total FROM '.$CFG['db']['tbl']['blogs'].
				' WHERE blog_status = \'Active\'  AND DATE_SUB( CURDATE( ) , INTERVAL 30 DAY ) <= date_added';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_db_error($db);

		$row = $rs->FetchRow();
	    $blogStatistics_arr['this_month_blog'] = $row['total'];
		$smartyObj->assign('blogStatistics_arr', $blogStatistics_arr);

	}

	function getTotalBlogs($user_id='')
		{
		   	global $CFG;
			global $db;
			global $LANG;
			if($user_id=='')
				$user_id = $CFG['user']['user_id'];
			$sql =' SELECT  count(blog_id) as total FROM '.$CFG['db']['tbl']['blogs'].' WHERE user_id='.$user_id;

			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt);
		    if (!$rs)
			    trigger_db_error($db);
			$total_music = 0;
			if($row = $rs->FetchRow())
				{
			  	   $total_blogs =  $row['total'];
				}

			return $LANG['common_blogs'].': <span>'.$total_blogs.'</span>';
		}
		function getTotalUsersBlogs($user_id='',$with_link =0)
		{
		   	global $CFG;
			global $db;
			global $LANG;
			if($user_id=='')
				$user_id = $CFG['user']['user_id'];
			$sql =' SELECT  count(blog_id) as total FROM '.$CFG['db']['tbl']['blogs'].' WHERE user_id='.$user_id;

			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt);
		    if (!$rs)
			    trigger_db_error($db);
			$total_music = 0;
			if($row = $rs->FetchRow())
				{
			  	   if ($row['total']>0) {
				  	   	if($with_link)
							return $blog_list_url = $LANG['common_blogs'].': <span><a href="'.getUrl('bloglist', '?pg=userbloglist&amp;user_id='.$user_id, 'userbloglist/?user_id='.$user_id,'','blog').'">'.$row['total'].'</a></span>';
						else
				  	   		return $LANG['common_blogs'].': <span>'.$row['total'].'</span>';
			  	   }
			  	   else
			  	   		return $LANG['common_blogs'].': <span>'.$row['total'].'</span>';

				}

			return false;
		}

	function getTotalBlogsViews($user_id='')
		{
			global $CFG;
        	global $db;

    		if($user_id == '')
    			$user_id = $CFG['user']['user_id'];

    		$sql = 'SELECT SUM(total_views) AS cnt FROM '.$CFG['db']['tbl']['blog_posts'].' WHERE user_id=\''.$user_id.'\' ';

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
	function strip_selected_blog_tags($str, $tags = "", $stripContent = false)
	{
		$tags = "<script>";
		return strip_selected_tags($str,  $tags, $stripContent);
	}
?>