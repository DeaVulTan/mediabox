<?php
	function isAllowedArticleUpload()
	{
		global $smartyObj, $CFG, $db, $LANG;
		return true;
		if(!isMember())
			return true;
		if(empty($CFG['admin']['article']['allow_only_artist_to_upload'])
			or empty($CFG['admin']['articles']['article_artist_feature']))
			return true;
		if(($CFG['admin']['articles']['article_artist_feature'] AND !$CFG['admin']['articles']['allow_only_artist_to_upload'])
		 	OR (!$CFG['admin']['articles']['article_artist_feature'] AND $CFG['admin']['articles']['allow_only_artist_to_upload']))
			return true;
		$sql = 'SELECT article_user_type FROM '.$CFG['db']['tbl']['users'].
				' WHERE user_id='.$db->Param('user_id').
				' AND article_user_type=\'Artist\'';
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($CFG['user']['user_id']));
		if (!$rs)
			    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);
		if($row = $rs->FetchRow())
			return true;
		return false;
	}

	function populateAdminArticleLeftNavigation($header)
	{
	   	 global $smartyObj;
		 /*if($header->_currentPage=='articleplaylistmanage')
			$header->_navigationArr['left_articleplaylist'] = $header->_clsActiveLink;

		if($header->_currentPage=='managelyrics' or $header->_currentPage=='viewlyrics' or $header->_currentPage=='addlyrics')
			$header->_navigationArr['left_articlemanage'] = $header->_clsActiveLink;*/

		 setTemplateFolder('admin/','article');
		 $smartyObj->display('left_article_navigation_links.tpl');
	 ?>
	   	 <script language="javascript" type="text/javascript">
	   	   var inc = divArray.length;
	   	   var temp_article_menu_array = new Array('articleMain', 'articleSetting', 'articlePlugin');
	   	   for(jnc=0;jnc<temp_article_menu_array.length;jnc++)
				divArray[inc++] = temp_article_menu_array[jnc];
	   	 </script>
	<?php
	}

	function populateArticleTopWritters()
	{
		global $smartyObj, $CFG, $db, $LANG;

		$sql = 'SELECT COUNT( a.article_id ) AS total_article, a.user_id '.
				'FROM '.$CFG['db']['tbl']['article'].' AS a '.
				'WHERE article_status=\'Ok\' GROUP BY user_id ORDER BY total_article DESC LIMIT 0,'.
				$CFG['admin']['articles']['sidebar_top_contributors'];

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
		    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);
			$record_count = false;
		if ($rs->PO_RecordCount())
	    {
	    	$record_count = true;
	    	$contributor_arr = array();
			$inc=0;
			$count=1;
			//Fix for not taking article's html_footer.tpl for common pages
			$module = '';
			if(!empty($CFG['site']['is_module_page']))
				$module = $CFG['site']['is_module_page'];
			else
			{
				$CFG['site']['is_module_page'] = 'article';
			}

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
					$contributor_arr[$inc]['total_stats'] = $row['total_article'];
					$contributor_arr[$inc]['total_list'] = $count;
					$contributor_arr[$inc]['noBoderStyle']='';
					if($count==$CFG['admin']['articles']['sidebar_top_contributors'])
					{
                         $contributor_arr[$inc]['noBoderStyle']='clsTopContributorsNoBorderPadding';
					}
					$contributor_arr[$inc]['user_articlelist_url'] = getUrl('articlelist', '?pg=userarticlelist&user_id='.$row['user_id'], 'userarticlelist/?user_id='.$row['user_id'], '', 'article');
					$inc++;
					$count++;
				}
			}
			$smartyObj->assign('record_count', $record_count);
			$smartyObj->assign('lang_total_contributors', $LANG['sidebar_statistics_total_article']);
			$smartyObj->assign('contributor',$contributor_arr);
			setTemplateFolder('general/', 'article');
			$smartyObj->display('populateTopContributors.tpl');
			//Fix for not taking article's html_footer.tpl for common pages
			if($module == '')
				$CFG['site']['is_module_page'] = '';
	    }
	}

	function getTotalArticles($user_id='')
		{
		   	global $CFG;
			global $db;
			global $LANG;

			if($user_id=='')
				$user_id = $CFG['user']['user_id'];
			$sql =' SELECT total_articles FROM '.$CFG['db']['tbl']['users'].' WHERE user_id='.$user_id;
			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt);
		    if (!$rs)
			    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);
			if($row = $rs->FetchRow())
				{
					return $LANG['common_article'].': <span>'.$row['total_articles'].'</span>';
			  	  // return $row['total_articles'];
				}
			return false;
		}
	function getTotalUsersArticles($user_id='',$with_link=0)
		{
		   	global $CFG;
			global $db;
			global $LANG;

			if($user_id=='')
				$user_id = $CFG['user']['user_id'];
			$sql =' SELECT total_articles FROM '.$CFG['db']['tbl']['users'].' WHERE user_id='.$user_id;
			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt);
		    if (!$rs)
			    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);
			if($row = $rs->FetchRow())
				{
	  	   			if ($row['total_articles']>0) {
		  	   			if($with_link)
							 return $article_list_url = $LANG['common_article'].': <span><a href="'.getUrl('articlelist', '?pg=userarticlelist&amp;user_id='.$user_id, 'userarticlelist/?user_id='.$user_id,'','article').'">'.$row['total_articles'].'</a></span>';
						else
				  	   		return $LANG['common_article'].': <span>'.$row['total_articles'].'</span>';
	  	   			}
	  	   			else
			  	   			return $LANG['common_article'].': <span>'.$row['total_articles'].'</span>';
				}
			return false;
		}

	//Used to get total articles in the site - used for Site Statistics
	function getTotalArticlesInSite()
	{
		global $CFG;
		global $db;
		$sql =	'SELECT SUM(total_articles) AS total_articles'.
	    		' FROM '.$CFG['db']['tbl']['users'].' WHERE usr_status=\'Ok\'';

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
  				if($row['total_articles'])
  				{
  					$all_article_url = getUrl('articlelist','?pg=articlenew', 'articlenew/','','article');
  					return '<a href="'.$all_article_url.'">'.$row['total_articles'].'</a>';
  				}
			}
		}
		return 0;
	}

	function adminArticleStatistics()
	{
	    global $CFG;
		global $db;
		global $smartyObj;
        $articleStatistics_arr = array();
        //Total Active article...
		$sql = 'SELECT count(article_id) as total FROM '.$CFG['db']['tbl']['article'].
				' WHERE article_status = \'Ok\' ';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_db_error($db);

		$row = $rs->FetchRow();
		$articleStatistics_arr['total_active_article'] = $row['total'];

		//Waiting for activation articles
		$sql = 'SELECT count(article_id) as total FROM '.$CFG['db']['tbl']['article'].
				' WHERE article_status = \'ToActivate\' ';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_db_error($db);

		$row = $rs->FetchRow();
		$articleStatistics_arr['total_toactivate_article'] = $row['total'];


		//Today
		$sql = 'SELECT count(article_id) as total FROM '.$CFG['db']['tbl']['article'].
				' WHERE article_status = \'Ok\'  AND DATE_FORMAT(date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_db_error($db);

		$row = $rs->FetchRow();
		$articleStatistics_arr['total_today_article'] = $row['total'];

		//This week
		$sql = 'SELECT count(article_id) as total FROM '.$CFG['db']['tbl']['article'].
				' WHERE article_status = \'Ok\'  AND DATE_SUB( CURDATE( ) , INTERVAL 7 DAY ) <= date_added';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_db_error($db);

		$row = $rs->FetchRow();
		$articleStatistics_arr['this_week_article'] = $row['total'];

		//This month
		$sql = 'SELECT count(article_id) as total FROM '.$CFG['db']['tbl']['article'].
				' WHERE article_status = \'Ok\'  AND DATE_SUB( CURDATE( ) , INTERVAL 30 DAY ) <= date_added';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_db_error($db);

		$row = $rs->FetchRow();
	    $articleStatistics_arr['this_month_article'] = $row['total'];
		$smartyObj->assign('articleStatistics_arr', $articleStatistics_arr);
	}

	function getTotalArticlesViews($user_id='')
	{
		global $CFG;
		global $db;

		if($user_id == '')
			$user_id = $CFG['user']['user_id'];

		$sql = 'SELECT SUM(total_views) AS cnt FROM '.$CFG['db']['tbl']['article'].' WHERE user_id=\''.$user_id.'\' ';

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

	//Function to strip specified tags in the given string
	function strip_selected_article_tags($str, $tags = "", $stripContent = false)
	{
		$tags = "<script>";
		return strip_selected_tags($str,  $tags, $stripContent);
	}


?>