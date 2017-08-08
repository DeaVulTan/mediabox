<?php
//--------------class PhotoIndexPageHandler--------------->>>//
/**
 * This class is used to list photo insex page
 *
 * @category	Rayzz
 * @package		manage photo imdex
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 */
class PhotoIndexPageHandler extends PhotoHandler
{
	public $default_active_div = array();
	public $default_active_css_class = array();

	/**
	 * PhotoIndexPageHandler::topContributors()
	 *
	 * @return
	 */
	public function topContributors()
	{
		populatephotoTopContributors();
	}

	/**
	 * PhotoIndexPageHandler::featuredMember()
	 *
	 * @return
	 */
	public function featuredMember()
	{
		populatephotoFeaturedMembers();
	}


	/**
	 * PhotoIndexPageHandler::loadSetting()
	 *
	 * @return
	 */
	public function loadSetting()
	{
		$block_array = array('mostrecentphoto', 'recommendedphoto', 'mostfavoritephoto', 'topratedphoto');
		$flag = 1;
		foreach($block_array as $block_name)
		{
			if($this->CFG['admin']['photos'][$block_name])
			{
				if($flag)
				{
					$this->default_active_css_class[$block_name] = 'class="clsActive"';
					$this->default_active_div[$block_name] = '';
					$this->default_active_block_name = $block_name;
					$flag = 0;
				}
				else
				{
					$this->default_active_css_class[$block_name] = '';
					$this->default_active_div[$block_name] = 'display:none;';
				}
			}
		}
		/*echo '<pre>';
		print_r($this->default_active_div);
		echo '</pre>';*/
	}

	public function populateRatingDetails($rating)
	{
		$rating = round($rating,0);
		return $rating;
	}

	/**
	 * PhotoIndexPageHandler::getTotalPhotoListPages()
	 * Function to get the total no of pages for the photo carousel
	 *
	 * @param string $block_name
	 * @param int $limit no of records to be shown per page in the carousel,
	 * 				value can be varied / passed from tpl
	 * @return int total pages
	 */
	public function getTotalPhotoListPages($block_name, $limit)
	{

		$default_cond = ' u.user_id=p.user_id AND u.usr_status=\'Ok\' AND p.photo_status=\'Ok\''.$this->getAdultQuery('p.', 'photo').
						 ' AND (p.user_id = '.$this->CFG['user']['user_id'].' OR'.
						 ' p.photo_access_type = \'Public\''.$this->getAdditionalQuery().')';
		$global_limit = 100; //to avoid overloading

		switch($block_name)
		{
			case 'mostrecentphoto':
					$condition = $default_cond;
					break;
			case 'recommendedphoto':
					$condition = 'p.total_featured>0  AND '.$default_cond;
					break;
			case 'mostfavoritephoto':
					$condition = 'p.total_favorites > 0  AND '.$default_cond;
					break;
			case 'topratedphoto':
					$condition = 'p.rating_total > 0 AND p.allow_ratings=\'Yes\' AND '.$default_cond;
					break;
		}

		$sql = 'SELECT COUNT(*) AS total_photo FROM '.$this->CFG['db']['tbl']['photo'].
				' AS p , '.$this->CFG['db']['tbl']['users'].' AS u '.
				'WHERE '.$condition.' LIMIT '. $global_limit;

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
	    if (!$rs)
			trigger_db_error($this->dbObj);

		if($row = $rs->FetchRow())
	    {
			$record_count = $row['total_photo'];
			$total_pages = ceil($record_count/$limit);
			return $total_pages;
	    }
	    else
	    {
			return 0;
		}
	}
		/**
	 * PhotoIndexPageHandler::getTotalPhotoListPages()
	 * Function to get the total no of pages for the photo carousel
	 *
	 * @param string $block_name
	 * @param int $limit no of records to be shown per page in the carousel,
	 * 				value can be varied / passed from tpl
	 * @return int total pages
	 */
	public function getTotalCategoryListPages($block_name, $limit)
	{
		global $smartyObj;
		$default_cond = ' u.user_id=p.user_id AND u.usr_status=\'Ok\' AND p.photo_status=\'Ok\''.
						  $this->getAdultQuery('p.', 'photo').' AND p.photo_category_id = pc.photo_category_id'.
						  ' AND pc.photo_category_status =\'Yes\' AND pc.parent_category_id=0 '.
					      ' AND (p.user_id = '.$this->CFG['user']['user_id'].' OR'.
						  ' p.photo_access_type = \'Public\''.$this->getAdditionalQuery().')';
		$groupby_cond = ' GROUP BY pc.photo_category_id';
		$global_limit = 25; //to avoid overloading

		switch($block_name)
		{
			case 'mostrecentphoto':
					$condition = $default_cond;
					break;
			case 'recommendedphoto':
					$condition = 'p.total_featured>0  AND '.$default_cond;
					break;
			case 'mostfavoritephoto':
					$condition = 'p.total_favorites > 0  AND '.$default_cond;
					break;
			case 'topratedphoto':
					$condition = 'p.rating_total > 0 AND p.allow_ratings=\'Yes\' AND '.$default_cond;
					break;
			default:
					$condition = $default_cond;
					break;
		}

		//add condition to exclude subcategories

		$sql = 'SELECT distinct(p.photo_category_id) as distinct_category_ids, photo_category_name, COUNT( p.photo_id ) AS photocount FROM '.$this->CFG['db']['tbl']['photo'].
				' AS p , '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['photo_category'].' AS pc '.
				'WHERE '.$condition;

		$sql .= $groupby_cond;

		//Added condition to display photo categories based on priority if  list priority setting is enabled in admin
		if(isset($this->CFG['admin']['photos']['photo_category_list_priority']) && $this->CFG['admin']['photos']['photo_category_list_priority'])
			$order_by = ' ORDER BY pc.priority ASC';
		else
			$order_by = ' ORDER BY photocount DESC';

		$sql .= $order_by.' LIMIT '. $global_limit;

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
	    if (!$rs)
			trigger_db_error($this->dbObj);
		$record_count =  $rs->PO_RecordCount();
		if($record_count)
		{
			$total_pages = ceil($record_count/$limit);
		}
		else
		{
			$total_pages = 0;
		}
		$this->photo_category_ids_arr = array();
		$this->photo_category_name_arr = array();
		$this->photo_channel_url_arr = array();
		//store the category ids in array
		while($row = $rs->FetchRow())
	    {
			$this->photo_category_ids_arr[] = $row['distinct_category_ids'];
			$this->photo_category_name_arr[$row['distinct_category_ids']] = $row['photo_category_name'];
			$this->photo_channel_url_arr[$row['distinct_category_ids']] = getUrl('photolist','?pg=photonew&cid='.$row['distinct_category_ids'], 'photonew/?cid='.$row['distinct_category_ids'],'','photo');
	    }
	    $smartyObj->assign('category_name_arr', $this->photo_category_name_arr);
	    $smartyObj->assign('photo_channel_url_arr', $this->photo_channel_url_arr);
		return $total_pages;
	}
		/**
	 * PhotoIndexPageHandler::populateCarousalphotoBlock()
	 *
	 * @return
	 */
	public function populateCarousalChannelPhotoBlock($case, $page_no=1, $rec_per_page=2, $rec_per_category=4)
	{
		global $smartyObj;
		//get the category ids for this page
		$this->getTotalCategoryListPages('mostrecentphoto', $rec_per_page);

		//category_ids are stored in the array $this->photo_category_ids_arr,
		$start = ($page_no -1) * $rec_per_page;
		$cid_arr = array();

	for($id = $start; $id < ($start + $rec_per_page); $id++)
	{
		$category_id = isset($this->photo_category_ids_arr[$id]) ? $this->photo_category_ids_arr[$id] : 0;
		if(!$category_id)
			break;

		$cid_arr[]  = $category_id;
		$populateCarousalphotoBlock_arr[$category_id]['row'] = array();


		//$populateCarousalphotoBlock_arr['row'] = array();
		//$start = ($page_no -1) * $rec_per_page; // start = (pageno -1) * rec per page
		$default_cond = ' p.photo_category_id = '.$category_id.' AND u.user_id=p.user_id AND u.usr_status=\'Ok\' AND p.photo_status=\'Ok\''.$this->getAdultQuery('p.', 'photo').
						 ' AND (p.user_id = '.$this->CFG['user']['user_id'].' OR'.
						 ' p.photo_access_type = \'Public\''.$this->getAdditionalQuery().')';

		$default_fields = ' p.photo_id, u.user_id, p.photo_title,p.photo_status, p.l_width, p.total_featured, p.total_favorites,TIMEDIFF(NOW(), p.date_added) as date_added, p.photo_ext, p.rating_count, (p.rating_total/p.rating_count) as rating ,p.t_width, p.t_height, p.photo_server_url,u.user_name ';
		$this->setFormField('block', $case);
		switch($case)
		{
			case 'mostrecentphoto':
				$order_by = 'p.date_added DESC';
				$condition = $default_cond;
				$sql = 'SELECT '.$default_fields.' '.
						'FROM '.
						$this->CFG['db']['tbl']['photo'].' AS p JOIN '.$this->CFG['db']['tbl']['users'].' AS u '.
						'WHERE '.$condition.' ORDER BY '.$order_by;
			break;

			case 'recommendedphoto':
				$order_by = 'total_featured DESC';
				$condition = 'p.total_featured>0  AND '.$default_cond;
				$sql = 'SELECT '.$default_fields.' '.
						'FROM '.$this->CFG['db']['tbl']['photo'].' AS p JOIN '.$this->CFG['db']['tbl']['users'].' AS u '.
						'WHERE '.$condition.' ORDER BY '.$order_by;
			break;

			case 'mostfavoritephoto'://NEW photo//
				$condition = 'p.total_favorites > 0  AND '.$default_cond;
				$order_by = ' p.total_favorites DESC, p.total_views DESC ';
				$sql = 'SELECT '.$default_fields.' '.
						'FROM '.$this->CFG['db']['tbl']['photo'].' AS p JOIN  '.$this->CFG['db']['tbl']['users'].' AS u '.
						'WHERE '.$condition.' ORDER BY '.$order_by;
			break;

			case 'topratedphoto':
				$order_by = 'rating DESC';
				$condition = 'p.rating_total > 0 AND p.allow_ratings=\'Yes\' AND '.$default_cond;
				$sql = 'SELECT '.$default_fields.' '.
						'FROM '.$this->CFG['db']['tbl']['photo'].' AS p JOIN '.$this->CFG['db']['tbl']['users'].' AS u '.
						'WHERE '.$condition.' ORDER BY '.$order_by;
			break;
		}
		//to do pass the rec per category too from the tpl
		$sql .= ' LIMIT 0,'.$rec_per_category;

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
	    if (!$rs)
			trigger_db_error($this->dbObj);

		$inc = 0;
		$count=0;
		$allow_quick_mixs = (isLoggedIn() and $this->CFG['admin']['photos']['allow_quick_mixs'])?true:false;
		$photos_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['photos']['folder'] . '/' . $this->CFG['admin']['photos']['folder'] . '/';
		while($photo_detail = $rs->FetchRow())
		{
			$populateCarousalphotoBlock_arr[$category_id]['row'][$inc]['record'] = $photo_detail;
			$populateCarousalphotoBlock_arr[$category_id]['row'][$inc]['total_featured'] = $photo_detail['total_featured'];
			$populateCarousalphotoBlock_arr[$category_id]['row'][$inc]['photo_status'] = $photo_detail['photo_status'];
			$populateCarousalphotoBlock_arr[$category_id]['row'][$inc]['photo_id'] = $photo_detail['photo_id'];
			$populateCarousalphotoBlock_arr[$category_id]['row'][$inc]['total_favorites'] = $photo_detail['total_favorites'];
			$populateCarousalphotoBlock_arr[$category_id]['row'][$inc]['username'] = $photo_detail['user_name'];
			$populateCarousalphotoBlock_arr[$category_id]['row'][$inc]['MemberProfileUrl'] = getMemberProfileUrl($photo_detail['user_id'], $photo_detail['user_name']);
			$populateCarousalphotoBlock_arr[$category_id]['row'][$inc]['date_added'] = ($photo_detail['date_added'] != '') ? getTimeDiffernceFormat($photo_detail['date_added']) : '';
			$populateCarousalphotoBlock_arr[$category_id]['row'][$inc]['wordWrap_mb_ManualWithSpace_photo_title'] = $photo_detail['photo_title'];
			$populateCarousalphotoBlock_arr[$category_id]['row'][$inc]['photo_title_js'] = addslashes($photo_detail['photo_title']);
			//$populateCarousalphotoBlock_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_album_title'] = wordWrap_mb_ManualWithSpace($photo_detail['photo_album_title'], $this->CFG['admin']['photos']['indexphotoblock_album_title_length'], $this->CFG['admin']['photos']['indexphotoblock_album_title_total_length']);
			$populateCarousalphotoBlock_arr[$category_id]['row'][$inc]['viewphoto_url'] = getUrl('viewphoto', '?photo_id='.$photo_detail['photo_id'].'&title='.$this->changeTitle($photo_detail['photo_title']), $photo_detail['photo_id'].'/'.$this->changeTitle($photo_detail['photo_title']).'/', '', 'photo');
			$populateCarousalphotoBlock_arr[$category_id]['row'][$inc]['add_quickmix'] = false;
            if ($allow_quick_mixs)
			{
                $populateCarousalphotoBlock_arr[$category_id]['row'][$inc]['add_quickmix'] = true;
                $populateCarousalphotoBlock_arr[$category_id]['row'][$inc]['is_quickmix_added'] = false;
                if (rayzzPhotoQuickMix($photo_detail['photo_id']))
                    $populateCarousalphotoBlock_arr[$category_id]['row'][$inc]['is_quickmix_added'] = true;
            }
			// IMAGE //
			if($photo_detail['photo_ext'])
			{
				$populateCarousalphotoBlock_arr[$category_id]['row'][$inc]['photo_large_image_src'] = $photo_detail['photo_server_url'].$photos_folder.getphotoName($photo_detail['photo_id']).$this->CFG['admin']['photos']['large_name'].'.'.$photo_detail['photo_ext'];
				$zoom_icon = false;
	        	if($photo_detail['l_width'] > $this->CFG['admin']['photos']['thumb_width'])
	        		$zoom_icon = true;
	        	$populateCarousalphotoBlock_arr[$category_id]['row'][$inc]['zoom_icon'] = $zoom_icon;
				$populateCarousalphotoBlock_arr[$category_id]['row'][$inc]['photo_image_src'] = $photo_detail['photo_server_url'].$photos_folder.getphotoName($photo_detail['photo_id']).$this->CFG['admin']['photos']['thumb_name'].'.'.$photo_detail['photo_ext'];
				$populateCarousalphotoBlock_arr[$category_id]['row'][$inc]['thumb_width'] = $photo_detail['t_width'];
				$populateCarousalphotoBlock_arr[$category_id]['row'][$inc]['thumb_height'] = $photo_detail['t_height'];
				$populateCarousalphotoBlock_arr[$category_id]['row'][$inc]['photo_disp'] = DISP_IMAGE($this->CFG['admin']['photos']['thumb_width'], $this->CFG['admin']['photos']['thumb_width']);
			}
			else
			{
				$populateCarousalphotoBlock_arr[$category_id]['row'][$inc]['photo_image_src'] = '';
				$populateCarousalphotoBlock_arr[$category_id]['row'][$inc]['photo_disp'] = '';
			}

			$inc++;
		}
	}

		$photo_block_category_record_count = count($cid_arr);
		$smartyObj->assign('populateCarousalphotoBlock_arr', $populateCarousalphotoBlock_arr);
		$smartyObj->assign('category_id_arr', $cid_arr);
    	$smartyObj->assign('photo_block_category_record_count', $photo_block_category_record_count);//is record found
    	$smartyObj->assign('case', $case);
		setTemplateFolder('general/', 'photo');
		$smartyObj->display('indexPhotoChannelBlockContent.tpl');
	}


	/**
	 * PhotoIndexPageHandler::populateCarousalphotoBlock()
	 *
	 * @return
	 */
	public function populateCarousalphotoBlock($case, $page_no=1, $rec_per_page=4)
	{
		global $smartyObj;
		$populateCarousalphotoBlock_arr['row'] = array();
		$start = ($page_no -1) * $rec_per_page; // start = (pageno -1) * rec per page
		$default_cond = ' u.user_id=p.user_id AND u.usr_status=\'Ok\' AND p.photo_status=\'Ok\''.$this->getAdultQuery('p.', 'photo').
						 ' AND (p.user_id = '.$this->CFG['user']['user_id'].' OR'.
						 ' p.photo_access_type = \'Public\''.$this->getAdditionalQuery().')';

		$default_fields = 'distinct(p.photo_id),u.user_id, p.photo_title,p.photo_status, p.l_width, p.total_featured, p.total_favorites,TIMEDIFF(NOW(), p.date_added) as date_added, p.photo_ext, p.rating_count, (p.rating_total/p.rating_count) as rating ,p.t_width, p.t_height, p.photo_server_url,u.user_name ';
		$this->setFormField('block', $case);
		switch($case)
		{
			case 'mostrecentphoto':
				$order_by = 'p.date_added DESC';
				$condition = $default_cond;
				$sql = 'SELECT '.$default_fields.' '.
						'FROM '.$this->CFG['db']['tbl']['photo'].' AS p JOIN '.$this->CFG['db']['tbl']['users'].' AS u '.
						'WHERE '.$condition.' ORDER BY '.$order_by;
			break;

			case 'recommendedphoto':
				$order_by = 'total_featured DESC';
				$condition = 'p.total_featured>0  AND '.$default_cond;
				$sql = 'SELECT '.$default_fields.' '.
						'FROM '.$this->CFG['db']['tbl']['photo'].' AS p JOIN '.$this->CFG['db']['tbl']['users'].' AS u '.
						'WHERE '.$condition.' ORDER BY '.$order_by;
			break;

			case 'mostfavoritephoto'://NEW photo//
				$condition = 'p.total_favorites > 0  AND '.$default_cond;
				$order_by = ' p.total_favorites DESC, p.total_views DESC ';
				$sql = 'SELECT '.$default_fields.' '.
						'FROM '.$this->CFG['db']['tbl']['photo'].' AS p JOIN  '.$this->CFG['db']['tbl']['users'].' AS u '.
						'WHERE '.$condition.' ORDER BY '.$order_by;
			break;

			case 'topratedphoto':
				$order_by = 'rating DESC';
				$condition = 'p.rating_total > 0 AND p.allow_ratings=\'Yes\' AND '.$default_cond;
				$sql = 'SELECT '.$default_fields.' '.
						'FROM '.$this->CFG['db']['tbl']['photo'].' AS p JOIN '.$this->CFG['db']['tbl']['users'].' AS u '.
						'WHERE '.$condition.' ORDER BY '.$order_by;
			break;
		}

		$sql .= ' LIMIT '.$start.', '.$rec_per_page;
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
	    if (!$rs)
			trigger_db_error($this->dbObj);

		$inc = 1;
		$count=0;
		$allow_quick_mixs = (isLoggedIn() and $this->CFG['admin']['photos']['allow_quick_mixs'])?true:false;
		$photos_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['photos']['folder'] . '/' . $this->CFG['admin']['photos']['folder'] . '/';
		while($photo_detail = $rs->FetchRow())
		{
			$populateCarousalphotoBlock_arr['row'][$inc]['record'] = $photo_detail;
			$populateCarousalphotoBlock_arr['row'][$inc]['total_featured'] = $photo_detail['total_featured'];
			$populateCarousalphotoBlock_arr['row'][$inc]['photo_status'] = $photo_detail['photo_status'];
			$populateCarousalphotoBlock_arr['row'][$inc]['photo_id'] = $photo_detail['photo_id'];
			$populateCarousalphotoBlock_arr['row'][$inc]['total_favorites'] = $photo_detail['total_favorites'];
			$populateCarousalphotoBlock_arr['row'][$inc]['username'] = $photo_detail['user_name'];
			$populateCarousalphotoBlock_arr['row'][$inc]['MemberProfileUrl'] = getMemberProfileUrl($photo_detail['user_id'], $photo_detail['user_name']);
			$populateCarousalphotoBlock_arr['row'][$inc]['date_added'] = ($photo_detail['date_added'] != '') ? getTimeDiffernceFormat($photo_detail['date_added']) : '';
			$populateCarousalphotoBlock_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_photo_title'] = $photo_detail['photo_title'];
			$populateCarousalphotoBlock_arr['row'][$inc]['photo_title_js'] = addslashes($photo_detail['photo_title']);
			//$populateCarousalphotoBlock_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_album_title'] = wordWrap_mb_ManualWithSpace($photo_detail['photo_album_title'], $this->CFG['admin']['photos']['indexphotoblock_album_title_length'], $this->CFG['admin']['photos']['indexphotoblock_album_title_total_length']);
			$populateCarousalphotoBlock_arr['row'][$inc]['viewphoto_url'] = getUrl('viewphoto', '?photo_id='.$photo_detail['photo_id'].'&title='.$this->changeTitle($photo_detail['photo_title']), $photo_detail['photo_id'].'/'.$this->changeTitle($photo_detail['photo_title']).'/', '', 'photo');
			$populateCarousalphotoBlock_arr['row'][$inc]['add_quickmix'] = false;
            if ($allow_quick_mixs)
			{
                $populateCarousalphotoBlock_arr['row'][$inc]['add_quickmix'] = true;
                $populateCarousalphotoBlock_arr['row'][$inc]['is_quickmix_added'] = false;
                if (rayzzPhotoQuickMix($photo_detail['photo_id']))
                    $populateCarousalphotoBlock_arr['row'][$inc]['is_quickmix_added'] = true;
            }
			// IMAGE //
			if($photo_detail['photo_ext'])
			{
				$populateCarousalphotoBlock_arr['row'][$inc]['photo_large_image_src'] = $photo_detail['photo_server_url'].$photos_folder.getphotoName($photo_detail['photo_id']).$this->CFG['admin']['photos']['large_name'].'.'.$photo_detail['photo_ext'];
				$zoom_icon = false;
	        	if($photo_detail['l_width'] > $this->CFG['admin']['photos']['thumb_width'])
	        		$zoom_icon = true;
	        	$populateCarousalphotoBlock_arr['row'][$inc]['zoom_icon'] = $zoom_icon;
				$populateCarousalphotoBlock_arr['row'][$inc]['photo_image_src'] = $photo_detail['photo_server_url'].$photos_folder.getphotoName($photo_detail['photo_id']).$this->CFG['admin']['photos']['thumb_name'].'.'.$photo_detail['photo_ext'];
				$populateCarousalphotoBlock_arr['row'][$inc]['thumb_width'] = $photo_detail['t_width'];
				$populateCarousalphotoBlock_arr['row'][$inc]['thumb_height'] = $photo_detail['t_height'];
				$populateCarousalphotoBlock_arr['row'][$inc]['photo_disp'] = DISP_IMAGE($this->CFG['admin']['photos']['thumb_width'], $this->CFG['admin']['photos']['thumb_width']);
			}
			else
			{
				$populateCarousalphotoBlock_arr['row'][$inc]['photo_image_src'] = '';
				$populateCarousalphotoBlock_arr['row'][$inc]['photo_disp'] = '';
			}

			/* Added code to display photo upload days and rating while mouse over images on index photo block */
			if($case == 'mostrecentphoto')
			{
				$populateCarousalphotoBlock_arr['row'][$inc]['photo_additional_details'] = ($photo_detail['date_added'] != '') ? '- ' . getTimeDiffernceFormat($photo_detail['date_added']) : '';
			}
			else if($case == 'topratedphoto')
			{
				$populateCarousalphotoBlock_arr['row'][$inc]['photo_additional_details'] = '- ' . $this->LANG['common_photo_rating'] . ' ' . round($photo_detail['rating']);
			}
			else
			{
				$populateCarousalphotoBlock_arr['row'][$inc]['photo_additional_details'] = '';
			}

			$inc++;
		}
		$photo_block_record_count = $inc - 1;
		$smartyObj->assign('populateCarousalphotoBlock_arr', $populateCarousalphotoBlock_arr);
    	$smartyObj->assign('photo_block_record_count', $photo_block_record_count);//is record found
    	$smartyObj->assign('case', $case);
		setTemplateFolder('general/', 'photo');
		$smartyObj->display('indexPhotoBlockContent.tpl');
	}

	/**
	 * PhotoIndexPageHandler::populateCarousalPhotoChannelBlock()
	 *
	 * @return
	 */
	public function populateCarousalPhotoChannelBlock($all = false)
	{
		global $smartyObj;
		$populateCarousalPhotoChannelBlock_arr = array();
		$populateCarousalPhotoChannelBlock_arr['row'] = array();
		$populateAllPhotoCategoryBlock_arr = array();
		$photo_block_category_record_count = false;
		$start = $this->getFormField('start');
		$limit = '';

		$default_cond = '(u.user_id = p.user_id'.' AND u.usr_status=\'Ok\') AND '.' p.photo_status=\'Ok\''.$this->getAdultQuery('p.', 'photo').
						 ' AND (p.user_id = '.$this->CFG['user']['user_id'].' OR'.' photo_access_type = \'Public\''.$this->getAdditionalQuery().')';

		$sql = 'SELECT pc.photo_category_id, pc.photo_category_name'.
				   ' FROM '.$this->CFG['db']['tbl']['photo_category'].' as pc, '.$this->CFG['db']['tbl']['photo'].' as p, '.
				   $this->CFG['db']['tbl']['users'].' AS u'.' WHERE pc.photo_category_id = p.photo_category_id  AND '.
				   ' pc.parent_category_id=0 AND pc.photo_category_status = \'Yes\''.' AND '.$default_cond.'GROUP BY pc.photo_category_name';

		$limit = isset($this->CFG['admin']['photos']['photo_channel_total_record'])?$this->CFG['admin']['photos']['photo_channel_total_record']:0;

		/* limit commented since we get all categories and displayed using jquery carousel */
		/*if(!$all)
			$sql .= ' LIMIT '.$start.', '.$limit;*/

		//echo $sql;
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
	    if (!$rs)
			trigger_db_error($this->dbObj);

		$record_count = $rs->PO_RecordCount();
		if($all)
			return $record_count;


		$inc = 1;
		$this->no_of_row=1;
		$count=0;
		$all_category_count = 0;
		$photos_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['photos']['folder'] . '/' . $this->CFG['admin']['photos']['folder'] . '/';

		while($photo_detail = $rs->FetchRow())
		{
			$photo_block_category_record_count = true;
			$populateCarousalPhotoChannelBlock_arr['record_count'] 			= true;
			$populateCarousalPhotoChannelBlock_arr['row'][$inc]['record']      = $photo_detail;
			$populateCarousalPhotoChannelBlock_arr['row'][$inc]['channel_url'] = getUrl('photolist','?pg=photonew&cid='.$photo_detail['photo_category_id'], 'photonew/?cid='.$photo_detail['photo_category_id'],'','photo');
			$populateCarousalPhotoChannelBlock_arr['row'][$inc]['photo_category_name'] = $photo_detail['photo_category_name'];
			$populateCarousalPhotoChannelBlock_arr['row'][$inc]['total_photo']       = $this->photoCount($photo_detail['photo_category_id']);
		   	$populateCarousalPhotoChannelBlock_arr['row'][$inc]['photo_category_id'] = $photo_detail['photo_category_id'];
			if(!$populateCarousalPhotoChannelBlock_arr['row'][$inc]['photo_detail'] = $this->getPhotoDetail($photo_detail['photo_category_id']))
	        {
				$populateCarousalPhotoChannelBlock_arr[$inc]['photo_detail']['image_url'] = $this->CFG['site']['url'].'photo/design/templates/'.
																		$this->CFG['html']['template']['default'].'/root/images/'.
																			$this->CFG['html']['stylesheet']['screen']['default'].
																				'/no_image/noImage_photo_T.jpg';

				$populateCarousalPhotoChannelBlock_arr[$inc]['photo_detail']['photo_title'] = 'No Photo';
				$populateCarousalPhotoChannelBlock_arr[$inc]['photo_detail']['photo_url']   = '';
		    }
			$populateAllPhotoCategoryBlock_arr[$all_category_count]['row'][] = $populateCarousalPhotoChannelBlock_arr['row'][$inc];
			$inc++;
			if($count%$this->CFG['admin']['photos']['photo_index_num_record_per_row'] == 0)
				{
					$this->no_of_row++;
				}
			$count++;
			if($count % $limit == 0)
			{
				$all_category_count ++;
			}
		}
    	$this->no_of_row--;

		$case = 'Channel';
    	if(!isAjaxPage())
		{
		?>
		<?php
		}
		$smartyObj->assign('populateAllPhotoCategoryBlock_arr', $populateAllPhotoCategoryBlock_arr);
		$smartyObj->assign('case', $case);
    	$smartyObj->assign('photo_block_category_record_count', $photo_block_category_record_count);
		setTemplateFolder('general/', $this->CFG['site']['is_module_page']);
		$smartyObj->display('indexPhotoChannelBlockContent.tpl');
	}


	/**
		 * PhotoIndexPageHandler::getTotalSlidelistPages()
		 * Function to get the total no of pages for the slidelist carousel
		 *
		 * @param string $block_name
		 * @param int $limit no of records to be shown per page in the carousel,
		 * 				value can be varied / passed from tpl
		 * @return int total pages
		 */
		public function getTotalSlidelistPages($block_name, $limit)
		{
			$global_limit = 100; //to avoid overloading

			switch($block_name)
			{
				case 'slidelistmostviewed':
					$condition = ' pl.photo_playlist_status=\'Yes\' AND pl.total_photos > 0 AND u.usr_status=\'Ok\'';
				break;
			}

			$sql = 'SELECT COUNT(*) AS total_photo FROM '.$this->CFG['db']['tbl']['photo_playlist'].' AS pl JOIN '.$this->CFG['db']['tbl']['users'].' as u ON pl.created_by_user_id=u.user_id '.
					' WHERE '.$condition . ' LIMIT ' . $global_limit;
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
				trigger_db_error($this->dbObj);

			if($row = $rs->FetchRow())
		    {
				$record_count = $row['total_photo'];
				$total_pages = ceil($record_count/$limit);
				return $total_pages;
		    }
		    else
		    {
				return 0;
			}
		}

	//function to show the slide lists on the basis of total views
	public function populateCarousalPhotoSlidelistBlock($case, $page_no=1, $rec_per_page=4)
	{
		global $smartyObj;
		$start = ($page_no -1) * $rec_per_page; // start = (pageno -1) * rec per page

		$populateCarousalPhotoSlidelistBlock_arr = array();

		if($case == 'slidelistmostviewed')
		{
			$sql = 'SELECT pl.photo_playlist_id, pl.photo_playlist_name, pl.total_photos, pl.total_views, u.user_name, u.user_id'.
					   ' FROM '.$this->CFG['db']['tbl']['photo_playlist'].' as pl JOIN '.$this->CFG['db']['tbl']['users'].' as u ON pl.created_by_user_id=u.user_id '.
					   ' WHERE pl.photo_playlist_status=\'Yes\' AND pl.total_photos > 0 AND u.usr_status=\'Ok\''.
					   ' ORDER BY pl.total_views DESC ';
		}

		$sql .= ' LIMIT '.$start.', '.$rec_per_page;

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
	    if (!$rs)
			trigger_db_error($this->dbObj);

		$record_count = $rs->PO_RecordCount();
		$inc = 1;
		$this->no_of_row=1;
		$count=0;
		$all_slide_count = 0;

		while($row = $rs->FetchRow())
		{
			$photo_detail = $row;
			$populateCarousalPhotoSlidelistBlock_arr['record_count'] 			= true;
			$populateCarousalPhotoSlidelistBlock_arr['row'][$inc]['record']      = $photo_detail;
			$populateCarousalPhotoSlidelistBlock_arr['row'][$inc]['photo_playlist_id']      = $row['photo_playlist_id'];
			$populateCarousalPhotoSlidelistBlock_arr['row'][$inc]['view_playlisturl'] = getUrl('flashshow', '?slideshow=pl&playlist='.$row['photo_playlist_id'], 'pl/'.$row['photo_playlist_id'].'/', '','photo');
			$populateCarousalPhotoSlidelistBlock_arr['row'][$inc]['photo_playlist_name'] = $row['photo_playlist_name'];
			$populateCarousalPhotoSlidelistBlock_arr['row'][$inc]['total_photos']       = $row['total_photos'];
			$populateCarousalPhotoSlidelistBlock_arr['row'][$inc]['private_photo'] = $row['total_photos'] - $this->getPlaylistTotalPhotos($row['photo_playlist_id']);
			$inc++;
		}

		$smartyObj->assign('populateCarousalPhotoSlidelistBlock_arr', $populateCarousalPhotoSlidelistBlock_arr);
		$smartyObj->assign('case', $case);
    	$smartyObj->assign('photo_block_slide_record_count', $inc);
		setTemplateFolder('general/', 'photo');
		$smartyObj->display('indexPhotoSlidelistBlockContent.tpl');
	}

	/**
	 * PhotoIndexPageHandler::getPhotoDetail()
	 *
	 * @param mixed $photo_category_id
	 * @return
	 */
	public function getPhotoDetail($photo_category_id)
	{
	   	 $default_cond = 'photo_status=\'Ok\''.$this->getAdultQuery('p.', 'photo').' AND (p.user_id = '.$this->CFG['user']['user_id'].' OR'.
						' photo_access_type = \'Public\''.$this->getAdditionalQuery().')';

	   	 $sql = 'SELECT p.user_id, photo_id, photo_title, photo_caption, total_views, photo_server_url, '.
					't_width, t_height, l_width, (rating_total/rating_count) as rating, '.
					'TIMEDIFF(NOW(), p.date_added) as photo_date_added, '.
					'TIMEDIFF(NOW(), last_view_date) as photo_last_view_date, photo_tags,photo_ext '.
					'FROM '.$this->CFG['db']['tbl']['photo'].' AS p '.
					' , '.$this->CFG['db']['tbl']['users'].' AS u  '.
					' WHERE p.user_id = u.user_id AND u.usr_status = \'Ok\' AND photo_category_id='.$this->dbObj->Param('photo_category_id').' AND '.$default_cond.
					'ORDER BY photo_id DESC LIMIT 1';

		 $stmt = $this->dbObj->Prepare($sql);
		 $rs   = $this->dbObj->Execute($stmt,array($photo_category_id));
		 if (!$rs)
			trigger_db_error($this->dbObj);
		 $photo_list_arr = array();
		 $fields_list    = array('user_name', 'first_name', 'last_name');
		 $photos_folder  = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['photos']['folder'] . '/' . $this->CFG['admin']['photos']['folder'] . '/';
		 $separator 	 = ':&nbsp;';
		 $tag 			 = array();
		 $relatedTags 	 = array();
		 $photoTags 	 = array();

		 if($row = $rs->FetchRow())
		 {

			$this->UserDetails = $this->getUserDetail('user_id', $row['user_id'], 'user_name');
			if($this->UserDetails != '')
			{
				$name = $this->getUserDetail('user_id', $row['user_id'], 'user_name');

				$photo_list_arr['photo_date_added'] = getTimeDiffernceFormat($row['photo_date_added']);
				$photo_list_arr['photo_last_view_date'] = getTimeDiffernceFormat($row['photo_last_view_date']);

				$photo_list_arr['photo_url']   = getUrl('viewphoto','?photo_id='.$row['photo_id'].'&title='.$this->changeTitle($row['photo_title']),
													$row['photo_id'].'/'.$this->changeTitle($row['photo_title']).'/','','photo');
				$photo_name = getPhotoName($row['photo_id']);
				$photo_list_arr['image_url']   = $row['photo_server_url'].$photos_folder.$photo_name.
												  $this->CFG['admin']['photos']['thumb_name'].'.'.$row['photo_ext'];
				$photo_list_arr['large_image_url'] = $row['photo_server_url'].$photos_folder.$photo_name.$this->CFG['admin']['photos']['large_name'].'.'.$row['photo_ext'];
				$zoom_icon = false;
	        	if($row['l_width'] > $this->CFG['admin']['photos']['thumb_width'])
	        		$zoom_icon = true;
	        	$photo_list_arr['zoom_icon'] = $zoom_icon;
				$photo_list_arr['photo_title'] = $row['photo_title'];
				$photo_list_arr['photo_title_js']= addslashes($row['photo_title']);
				$photo_list_arr['record']      = $row;
				$photo_list_arr['MemberProfileUrl'] = getMemberProfileUrl($row['user_id'], $this->UserDetails);
				$photo_list_arr['UserDetails_Name'] = $this->UserDetails;
				$photo_list_arr['tags']             = $row['photo_tags'];
				//$photo_list_arr['tags']             = $this->getTagsLink($row['photo_tags']);
				return $photo_list_arr;
			}
		 }
		return false;
	}


	/**
	 * $photoIndex::myHomeActivity()
	 *
	 * @return void
	 */
	public function myHomeActivity()
	{
		global $smartyObj;
		setTemplateFolder('members/');
		$smartyObj->display('myHomeActivity.tpl');
	}


	/**
	 * PhotoIndexPageHandler::populateFeaturedphotolist()
	 *
	 * @return void
	 * @access public
	 */
	public function populateFeaturedPhotolist()
	{
		global $smartyObj;
		$record_count = false;
		$populate_featured_photo_arr = array();
		$photos_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['photos']['folder'] . '/' . $this->CFG['admin']['photos']['folder'] . '/';
		$add_order = ' ORDER BY p.featured_photo_order_id ASC ';
		$sql_condition = ' u.usr_status=\'Ok\' AND p.photo_status=\'Ok\' AND p.featured=\'Yes\''.
						 ' AND (p.user_id = '.$this->CFG['user']['user_id'].
						 ' OR p.photo_access_type = \'Public\''.$this->getAdditionalQuery().')'.$this->getAdultQuery('p.', 'photo');

		$sql = 'SELECT p.photo_id, p.user_id, p.photo_caption, p.photo_title, p.photo_ext, TIMEDIFF(NOW(), p.date_added) AS p_date_added, p.total_views, p.total_comments, p.rating_total, p.rating_count, p.total_downloads, p.s_width, p.s_height,p.l_width,p.l_height, p.m_width, p.m_height,'.
	        	' p.photo_server_url FROM '.$this->CFG['db']['tbl']['photo'].
				' AS p JOIN '.$this->CFG['db']['tbl']['users'].' AS u  '.
				'ON p.user_id = u.user_id  WHERE '.$sql_condition.$add_order;
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
	    if (!$rs)
			trigger_db_error($this->dbObj);
		if ($rs->PO_RecordCount())
    	{
    		$record_count = true;
    		$inc=0;
			while($row = $rs->FetchRow())
			{
				$row['p_date_added'] = getTimeDiffernceFormat($row['p_date_added']);
				$row['rating'] = $row['rating_count']?(round($row['rating_total']/$row['rating_count'],0)):0;
				$populate_featured_photo_arr[$inc]['record'] = $row;
				$populate_featured_photo_arr[$inc]['user_details'] = getUserDetail('user_id', $row['user_id']);
				$populate_featured_photo_arr[$inc]['photoTitle'] = $row['photo_title'];
				$populate_featured_photo_arr[$inc]['photo_url']  = getUrl('viewphoto', '?photo_id=' . $row['photo_id'] . '&title=' . $this->changeTitle($row['photo_title']), $row['photo_id'] . '/' . $this->changeTitle($row['photo_title']) . '/', '', 'photo');
				//$populate_featured_photo_arr[$inc]['photo_slide_head'] = htmlspecialchars('<a href="'.$populate_featured_photo_arr[$inc]['user_details']['profile_url'].'">'.$populate_featured_photo_arr[$inc]['user_details']['display_name'].'</a> Picks - <span>'.$row['photo_title'].'</span>');
				$populate_featured_photo_arr[$inc]['photo_slide_head'] = htmlspecialchars($this->LANG['index_featuredphotolist_label'].' - <span><a href="'.$populate_featured_photo_arr[$inc]['photo_url'].'" title="'.$row['photo_title'].'">'.$row['photo_title'].'</a></span>');
				$populate_featured_photo_arr[$inc]['photoCaption'] = $row['photo_caption'];
				if($row['photo_ext'])
				{
					$photo_name =getPhotoName($row['photo_id']);
					$populate_featured_photo_arr[$inc]['photoName'] = $photo_name;
					$populate_featured_photo_arr[$inc]['photoExt'] = $row['photo_ext'];
					$populate_featured_photo_arr[$inc]['photo_image_src_medium'] = $row['photo_server_url'].$photos_folder.$photo_name.
															 $this->CFG['admin']['photos']['medium_name'].'.'.$row['photo_ext'];
					$populate_featured_photo_arr[$inc]['photo_image_src_small'] = $row['photo_server_url'].$photos_folder.$photo_name.
															 $this->CFG['admin']['photos']['small_name'].'.'.$row['photo_ext'];
					$populate_featured_photo_arr[$inc]['photo_disp'] 	   = DISP_IMAGE($this->CFG['admin']['photos']['small_width'], $this->CFG['admin']['photos']['small_width'],															 $row['s_width'], $row['s_height']);
					$inc++;
				}
			}
		}
		//print_r($populate_featured_photo_arr);
		$smartyObj->assign('featured_record_count', $record_count);
		$smartyObj->assign('photo_folder', $photos_folder);
		$smartyObj->assign('featured_list_title', $this->LANG['sidebar_featuredphotolist_label']);
		//$smartyObj->assign('lang_total_contributors', $LANG['sidebar_statistics_total_photo']);
		$smartyObj->assign('populate_featured_photo_arr',$populate_featured_photo_arr);
		setTemplateFolder('general/', 'photo');
		$smartyObj->display('populateFeaturedPhotoBlock.tpl');

	}

	public function topPhotos()
	{
		global $smartyObj;
		$sql  = 'SELECT p.photo_id, p.user_id, p.photo_title, p.photo_ext, p.total_views, p.total_comments, p.s_width, p.s_height,'.
		        ' p.photo_server_url FROM  photo AS p LEFT JOIN users AS u ON u.user_id = p.user_id WHERE p.photo_status =  \'Ok\' AND p.total_views > 0 '.
			    ' ORDER BY total_views DESC LIMIT 0, '.$this->CFG['admin']['photos']['photo_index_top_photos'];
		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt);
	    if (!$rs)
			trigger_db_error($this->dbObj);

		$record_count 	 = false;
		$topPhoto_arr = array();
		if ($rs->PO_RecordCount())
	    {
	    	$record_count = true;
	    	$inc=0;
	    	$fields_list   = array('user_name', 'first_name', 'last_name');
			$photos_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['photos']['folder'] . '/' . $this->CFG['admin']['photos']['folder'] . '/';
	        while($row = $rs->FetchRow())
			{
				/*echo '<pre>';
				print_r($row);
				echo '</pre>';*/

				$this->UserDetails = $this->getUserDetail('user_id', $row['user_id'], 'user_name');

				/*echo '<pre>';
				print_r($this->UserDetails);
				echo '</pre>';*/

				$topPhoto_arr[$inc]['photoTitle'] = $row['photo_title'];
				$topPhoto_arr[$inc]['views'] 	  = $row['total_views'];
				$topPhoto_arr[$inc]['comments']  = $row['total_comments'];
				$topPhoto_arr[$inc]['photo_url']  = getUrl('viewphoto', '?photo_id=' . $row['photo_id'] . '&title=' . $this->changeTitle($row['photo_title']), $row['photo_id'] . '/' . $this->changeTitle($row['photo_title']) . '/', '', 'photo');
				if($row['photo_ext'])
				{
					$topPhoto_arr[$inc]['photo_image_src'] = $row['photo_server_url'].$photos_folder.getPhotoName($row['photo_id']).
															 $this->CFG['admin']['photos']['small_name'].'.'.$row['photo_ext'];
					$topPhoto_arr[$inc]['photo_disp'] 	   = DISP_IMAGE($this->CFG['admin']['photos']['small_width'], $this->CFG['admin']['photos']['small_width'],
															 $row['s_width'], $row['s_height']);
				}
				else
				{
					$topPhoto_arr[$inc]['photo_image_src'] = '';
					$topPhoto_arr[$inc]['photo_disp'] 	   = '';
				}

				if($this->UserDetails != '')
				{
					$topPhoto_arr[$inc]['memberProfileUrl'] = getMemberProfileUrl($row['user_id'], $this->UserDetails);
					$topPhoto_arr[$inc]['name']	= $this->UserDetails;
					$inc++;
				}
			}
	    }
		$smartyObj->assign('record_count', $record_count);
		//$smartyObj->assign('lang_total_contributors', $LANG['sidebar_statistics_total_photo']);
		$smartyObj->assign('topPhoto_arr',$topPhoto_arr);
		setTemplateFolder('general/', $this->CFG['site']['is_module_page']);
		$smartyObj->display('populateTopPhotos.tpl');
	}
}
$photoindex = new PhotoIndexPageHandler();

if(!chkAllowedModule(array('photo')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$photoindex->setPageBlockNames(array('sidebar_topcontributors_block', 'sidebar_featuredmember_block',
						             'sidebar_photo_block', 'sidebar_photo_channel_block','sidebar_photo_slidelist_block',
								     'sidebar_photo_tags_block','sidebar_topphoto_block',
									 'sidebar_activity_block', 'sidebar_currently_playing_block',
								     'block_feartured_photolist','photolist_block',
									 ));

$photoindex->CFG['admin']['photos']['individual_photo_play'] = true;

$photoindex->setAllPageBlocksHide();
$photoindex->setMediaPath('../../');
$photoindex->setFormField('start', '0');
$photoindex->setFormField('block', '');
$photoindex->setFormField('topChart', '');
$photoindex->setFormField('photoChannel', '');
$photoindex->setFormField('photoSlidelist', '');
$photoindex->setFormField('slidelist', '');
$photoindex->setFormField('activity_type', '');
$photoindex->setFormField('slidelist_start', 0);
$photoindex->setFormField('showtab', '');
$photoindex->setFormField('limit', 0);
$photoindex->setFormField('photo_limit', 0);
$photoindex->setFormField('slidelist_block', '');
$photoindex->setFormField('slidelist_tab', '');
$photoindex->setFormField('slidelist_start', 0);
$photoindex->setFormField('slidelist_limit', 0);

//SHOW BLOCK//
$photoindex->setPageBlockShow('sidebar_topcontributors_block');// TOP CONTRIBUTORS //
$photoindex->setPageBlockShow('sidebar_topphoto_block');
$photoindex->setPageBlockShow('sidebar_photo_channel_block');
$photoindex->setPageBlockShow('sidebar_photo_slidelist_block');
$photoindex->setPageBlockShow('sidebar_photo_tags_block');
//$photoindex->setPageBlockShow('photolist_block');

if($CFG['admin']['photos']['index_show_featured_member'])
	$photoindex->setPageBlockShow('sidebar_featuredmember_block');
$photoindex->setPageBlockShow('block_feartured_photolist');

if($CFG['admin']['photos']['mostrecentphoto'] or $CFG['admin']['photos']['recommendedphoto']
	or $CFG['admin']['photos']['mostfavoritephoto'] or $CFG['admin']['photos']['topratedphoto'])
	$photoindex->setPageBlockShow('sidebar_photo_block');

$photoindex->sanitizeFormInputs($_REQUEST);

if(!isAjaxPage())
{
	$photoindex->setPageBlockShow('sidebar_activity_block');
	if ($photoindex->isShowPageBlock('sidebar_photo_block'))// MEMBER BLOCK //
	{
		$photoindex->loadSetting();
	}
}
else
{
	$photoindex->sanitizeFormInputs($_REQUEST);
	$photoindex->includeAjaxHeaderSessionCheck();
	if($photoindex->getFormField('activity_type')!= '')
	{
		if($photoindex->getFormField('activity_type') == 'Friends' and !$photoindex->getTotalFriends($CFG['user']['user_id']))
		{
			echo '<div class="clsNoRecordsFound">'.$LANG['index_activities_no_friends'].'</div>';
			exit;
		}
		$activity_view_all_url = getUrl('activity', '?pg='.strtolower($photoindex->getFormField('activity_type')), strtolower($photoindex->getFormField('activity_type')).'/updates/', '');
		$smartyObj->assign('activity_view_all_url', $activity_view_all_url);
		$Activity = new ActivityHandler();
		$Activity->setActivityType(strtolower($photoindex->getFormField('activity_type')), 'photo');
		$photoindex->myHomeActivity();
	}
	else
	{

		if($photoindex->getFormField('block')!= '')
		{
			$photoindex->populateCarousalphotoBlock($photoindex->getFormField('block'), $photoindex->getFormField('start'), $photoindex->getFormField('limit'));
		}
		elseif($photoindex->getFormField('photoChannel') != '')
		{
			$photoindex->populateCarousalChannelPhotoBlock($photoindex->getFormField('photoChannel'), $photoindex->getFormField('start'), $photoindex->getFormField('limit'), $photoindex->getFormField('photo_limit'));
		}

		if($photoindex->getFormField('slidelist_block')!= '')
		{
			$photoindex->populateCarousalPhotoSlidelistBlock($photoindex->getFormField('slidelist_block'), $photoindex->getFormField('slidelist_start'), $photoindex->getFormField('slidelist_limit'));
		}

	}

	if($photoindex->getFormField('showtab')!= '')
	{
		$total_photo_list_pages = $photoindex->getTotalPhotoListPages($photoindex->getFormField('showtab'), $photoindex->getFormField('limit'));
		$smartyObj->assign('total_photo_list_pages', $total_photo_list_pages);
		$smartyObj->assign('showtab', $photoindex->getFormField('showtab'));
		setTemplateFolder('general/', 'photo');
		$smartyObj->display('indexPhotoCarouselTab.tpl');
		exit;
	}

	if($photoindex->getFormField('slidelist_tab')!= '')
	{
		$total_popular_slidelist_pages = $photoindex->getTotalSlidelistPages($photoindex->getFormField('slidelist_tab'), $photoindex->getFormField('slidelist_limit'));
		$smartyObj->assign('total_popular_slidelist_pages', $total_popular_slidelist_pages);
		$smartyObj->assign('slidelist_tab', $photoindex->getFormField('slidelist_tab'));
		setTemplateFolder('general/', 'photo');
		$smartyObj->display('indexPopularSlidelistCarouselTab.tpl');
		exit;
	}

	$photoindex->includeAjaxFooter();
	die();
}
$photoindex->includeHeader();
?>
<script type="text/javascript">
	var Image_Url = "<?php echo $CFG['site']['photo_url'].'design/templates/'.$CFG['html']['template']['default'].'/root/images/'?>";
</script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/lib/jQuery_plugins/galleriffic-2.0/jquery.galleriffic.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/lib/jQuery_plugins/galleriffic-2.0/jquery.opacityrollover.js"></script>
<?php
setTemplateFolder('general/',$CFG['site']['is_module_page']);
$smartyObj->display('index.tpl');
?>
<script type="text/javascript">

	var slideShow = function($) {
		// We only want these styles applied when javascript is enabled
		$Jq('div.navigation').css({'width' : '300px', 'float' : 'left'});
		$Jq('div.content').css('display', 'block');

		// Initially set opacity on thumbs and add
		// additional styling for hover effect on thumbs
		var onMouseOutOpacity = 0.67;
		$Jq('#thumbs ul.thumbs li').opacityrollover({
			mouseOutOpacity:   onMouseOutOpacity,
			mouseOverOpacity:  1.0,
			fadeSpeed:         'fast',
			exemptionSelector: '.selected'
		});

		// Initialize Advanced Galleriffic Gallery
		var gallery = $Jq('#thumbs').galleriffic({
			delay:                     3000,
			numThumbs:                 15,
			preloadAhead:              10,
			enableTopPager:            false,
			enableBottomPager:         false,
			maxPagesToShow:            7,
			imageContainerSel:         '#slideshow',
			//controlsContainerSel:      '#controls',
			captionContainerSel:       '#caption',
			loadingContainerSel:       '#loading',
			renderSSControls:          true,
			renderNavControls:         true,
			playLinkText:              'Play Slideshow',
			pauseLinkText:             'Pause Slideshow',
			prevLinkText:              '&lsaquo; Previous Photo',
			nextLinkText:              'Next Photo &rsaquo;',
			nextPageLinkText:          'Next &rsaquo;',
			prevPageLinkText:          '&lsaquo; Prev',
			enableHistory:             false,
			autoStart:                 true,
			syncTransitions:           true,
			defaultTransitionDuration: 900,
			onSlideChange:             function(prevIndex, nextIndex) {
				$Jq('#selSlideHead').html(this.find('ul.thumbs').children().eq(nextIndex).children().children().attr('slidehead'));
				// 'this' refers to the gallery, which is an extension of $Jq('#thumbs')
				this.find('ul.thumbs').children()
					.eq(prevIndex).fadeTo('fast', onMouseOutOpacity).end()
					.eq(nextIndex).fadeTo('fast', 1.0);
				this.play();
				$Jq('#thumbs')[0].scrollTo('#thumbshash'+nextIndex);
			},
			onPageTransitionOut:       function(callback) {
				this.fadeTo('fast', 0.0, callback);
			},
			onPageTransitionIn:        function() {
				this.fadeTo('fast', 1.0);
			}
		});
	}
	slideShow();
</script>
<script type="text/javascript" >
//This is important for carosel//
var module_name_js = "photo";
var photo_activity_array = new Array('My', 'Friends', 'All');
var photo_index_ajax_url = '<?php echo $CFG['site']['photo_url'].'index.php';?>';
// photo ACTIVITY DEFAULT SETTING //
<?php
if(isMember())
{
?>
	loadActivitySetting('<?php echo $CFG['admin']['photos']['photo_activity_default_content'];?>');
<?php
}
?>
</script>
<?php
$photoindex->includeFooter();
?>