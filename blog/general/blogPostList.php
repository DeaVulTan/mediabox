<?php
/**
 * This file is to manage blog post list
 *
 * Provides an interface to view list of blog posts in various views
 * My blog posts, My Favourite blog posts.
 * In My blog posts view user can edit, delete blog posts.
 * In My Favourite blog post view user's favourite blog post will be
 * displayed. Blog post can be removed from favourite list and user
 * can get the code to embed to website.
 *
 * @category	Rayzz
 * @package		General
 */
class BlogPostList extends BlogHandler
{
	public $UserDetails = array();
	public $advanceSearch;

	/**
	 * BlogPostList::getMostViewedExtraQuery()
	 *
	 * @return string
	 */
	public function getMostViewedExtraQuery()
	{
		$extra_query = '';
		switch($this->fields_arr['action'])
		{
			case 1:
				$extra_query = ' AND DATE_FORMAT(bv.view_date,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
				break;

			case 2:
				$extra_query = ' AND DATE_FORMAT(bv.view_date,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
				break;

			case 3:
				$extra_query = ' AND DATE_FORMAT(bv.view_date,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
				break;

			case 4:
				$extra_query = ' AND DATE_FORMAT(bv.view_date,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
				break;

			case 5:
				$extra_query = ' AND DATE_FORMAT(bv.view_date,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
				break;
		}
		return $extra_query;
	}

	/**
	 * BlogPostList::getMostDiscussedExtraQuery()
	 *
	 * @return string
	 */
	public function getMostDiscussedExtraQuery()
	{
		$extra_query = '';
		switch($this->fields_arr['action'])
		{
			case 1:
				$extra_query = ' AND DATE_FORMAT(bcmt.date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
				break;

			case 2:
				$extra_query = ' AND DATE_FORMAT(bcmt.date_added,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
				break;

			case 3:
				$extra_query = ' AND DATE_FORMAT(bcmt.date_added,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
				break;

			case 4:
				$extra_query = ' AND DATE_FORMAT(bcmt.date_added,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
				break;

			case 5:
				$extra_query = ' AND DATE_FORMAT(bcmt.date_added,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
				break;
		}
		return $extra_query;
	}

	/**
	 * BlogPostList::getMostFavoriteExtraQuery()
	 *
	 * @return string
	 */
	public function getMostFavoriteExtraQuery()
	{
		$extra_query = '';
		switch($this->fields_arr['action'])
		{
			case 1:
				$extra_query = ' AND DATE_FORMAT(bf.date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
				break;

			case 2:
				$extra_query = ' AND DATE_FORMAT(bf.date_added,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
				break;

			case 3:
				$extra_query = ' AND DATE_FORMAT(bf.date_added,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
				break;

			case 4:
				$extra_query = ' AND DATE_FORMAT(bf.date_added,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
				break;

			case 5:
				$extra_query = ' AND DATE_FORMAT(bf.date_added,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
				break;
		}
		return $extra_query;
	}

	/**
     * BlogPostList::advancedFilters()
     *
     * @return
     */
    public function advancedFilters()
    {
        // Advanced Filters (Keyword, User name, Country, Language, Playing time, Most viewed):
        $advanced_filters = '';
        $this->advanceSearch = false;
        if ($this->isFormPOSTed($_REQUEST, 'advanceFromSubmission') or $this->fields_arr['advanceFromSubmission']==1)
		{
			if ($this->fields_arr['blog_post_keywords'] != $this->LANG['blogpostlist_keyword_field'] AND $this->fields_arr['blog_post_keywords'])
			{
				$this->advanceSearch = true;
			}
			if ($this->fields_arr['post_owner'] != $this->LANG['blogpostlist_post_created_by'] AND $this->fields_arr['post_owner'])
			{
				$advanced_filters .= ' AND u.user_name LIKE \'%' .validFieldSpecialChr($this->fields_arr['post_owner']). '%\' ';
				$this->advanceSearch = true;
			}
			$this->advanceSearch = true;
			return $advanced_filters;
		}
    }

	/**
	 * BlogPostList::setTableAndColumns()
	 *
	 * @return void
	 */
	public function setTableAndColumns()
	{
		if(!isMember())
		{
			$not_allowed_arr = array('myposts', 'myfavoriteposts', 'myrecentlyviewedposts');
			if(in_array($this->fields_arr['pg'], $not_allowed_arr))
				$this->fields_arr['pg'] = 'postnew';
		}
		switch($this->fields_arr['pg'])
		{
			case 'myposts':
			    $this->setTableNames(array($this->CFG['db']['tbl']['blogs'] . ' AS b '.' JOIN '.$this->CFG['db']['tbl']['blog_posts'].' AS bp ON b.blog_id = bp.blog_id JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON bp.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['blog_category'].' AS bc ON bc.blog_category_id =bp.blog_category_id'));
				$this->setReturnColumns(array('b.blog_id,b.blog_name, bp.message', 'bp.blog_post_id', 'bp.blog_category_id','bp.blog_admin_comments','bp.user_id', 'bp.blog_access_type', 'DATE_FORMAT(bp.date_of_publish, "%d %b %Y") as published_date',
											  'bp.relation_id', 'bp.blog_post_name', 'bp.date_added', 'NOW() as date_current', 'bp.total_favorites',
											  'DATE_FORMAT(bp.date_added, "%d %b %Y") as added_date', 'bp.total_views', '(bp.rating_total/bp.rating_count) as rating',
											  'blog_tags', 'status', 'TIMEDIFF(NOW(), last_view_date) as blog_last_view_date', 'total_comments',
											  'bc.blog_category_name','b.width','b.height'));

				$additional_query = '';
				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'blog_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'blog_post_name', '').') AND ';

				$this->sql_condition = $additional_query.'bp.user_id=\''.$this->CFG['user']['user_id'].'\' AND b.blog_status=\'Active\' AND status IN (\'Ok\', \'Draft\', \'ToActivate\', \'Not Approved\', \'InFuture\')'.$this->advancedFilters();
				$this->sql_sort = 'blog_post_id DESC';
				break;

			case 'publishedposts':
		    	$this->setTableNames(array($this->CFG['db']['tbl']['blogs'] . ' AS b '.' JOIN '.$this->CFG['db']['tbl']['blog_posts'].' AS bp ON b.blog_id = bp.blog_id JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON bp.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['blog_category'].' AS bc ON bc.blog_category_id =bp.blog_category_id'));
				$this->setReturnColumns(array('b.blog_id,b.blog_name, bp.message', 'bp.blog_post_id','bp.blog_admin_comments','bp.user_id', 'bp.blog_access_type', 'DATE_FORMAT(bp.date_of_publish, "%d %b %Y") as published_date','bp.blog_category_id',
											  'bp.relation_id', 'bp.blog_post_name', 'bp.date_added', 'NOW() as date_current', 'bp.total_favorites',
											  'DATE_FORMAT(bp.date_added, "%d %b %Y") as added_date', 'bp.total_views', '(bp.rating_total/bp.rating_count) as rating',
											  'blog_tags', 'status', 'TIMEDIFF(NOW(), last_view_date) as blog_last_view_date', 'total_comments',
											  'bc.blog_category_name','b.width','b.height'));

				$additional_query = '';
				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'blog_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'blog_post_name', '').') AND ';

				$this->sql_condition = $additional_query.'bp.user_id=\''.$this->CFG['user']['user_id'].'\' AND b.blog_status=\'Active\' AND status=\'Ok\''.$this->advancedFilters();
				$this->sql_sort = 'blog_post_id DESC';
				break;

			case 'toactivate':
			    $this->setTableNames(array($this->CFG['db']['tbl']['blogs'] . ' AS b '.' JOIN '.$this->CFG['db']['tbl']['blog_posts'].' AS bp ON b.blog_id = bp.blog_id JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON bp.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['blog_category'].' AS bc ON bc.blog_category_id =bp.blog_category_id'));
				$this->setReturnColumns(array('b.blog_id,b.blog_name, bp.message', 'bp.blog_post_id','bp.blog_admin_comments','bp.user_id', 'bp.blog_access_type', 'DATE_FORMAT(bp.date_of_publish, "%d %b %Y") as published_date','bp.blog_category_id',
											  'bp.relation_id', 'bp.blog_post_name', 'bp.date_added', 'NOW() as date_current', 'bp.total_favorites',
											  'DATE_FORMAT(bp.date_added, "%d %b %Y") as added_date', 'bp.total_views', '(bp.rating_total/bp.rating_count) as rating',
											  'blog_tags', 'status', 'TIMEDIFF(NOW(), last_view_date) as blog_last_view_date', 'total_comments',
											  'bc.blog_category_name','b.width','b.height'));

				$additional_query = '';
				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'blog_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'blog_post_name', '').') AND ';
				$this->sql_condition = $additional_query.'bp.user_id=\''.$this->CFG['user']['user_id'].'\' AND b.blog_status=\'Active\' AND status=\'ToActivate\''.$this->advancedFilters();
				$this->sql_sort = 'blog_post_id DESC';
				break;

			case 'notapproved':
				$this->setTableNames(array($this->CFG['db']['tbl']['blogs'] . ' AS b '.' JOIN '.$this->CFG['db']['tbl']['blog_posts'].' AS bp ON b.blog_id = bp.blog_id JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON bp.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['blog_category'].' AS bc ON bc.blog_category_id =bp.blog_category_id'));
				$this->setReturnColumns(array('b.blog_id,b.blog_name, bp.message', 'bp.blog_post_id','bp.blog_admin_comments','bp.user_id', 'bp.blog_access_type', 'DATE_FORMAT(bp.date_of_publish, "%d %b %Y") as published_date','bp.blog_category_id',
											  'bp.relation_id', 'bp.blog_post_name', 'bp.date_added', 'NOW() as date_current', 'bp.total_favorites',
											  'DATE_FORMAT(bp.date_added, "%d %b %Y") as added_date', 'bp.total_views', '(bp.rating_total/bp.rating_count) as rating',
											  'blog_tags', 'status', 'TIMEDIFF(NOW(), last_view_date) as blog_last_view_date', 'total_comments',
											  'bc.blog_category_name','b.width','b.height'));

				$additional_query = '';
				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'blog_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'blog_post_name', '') .') AND ';
				$this->sql_condition = $additional_query.'bp.user_id=\''.$this->CFG['user']['user_id'].'\' AND b.blog_status=\'Active\' AND status=\'Not Approved\''.$this->advancedFilters();
				$this->sql_sort = 'blog_post_id DESC';
				break;

			case 'draftposts':
				$this->setTableNames(array($this->CFG['db']['tbl']['blogs'] . ' AS b '.' JOIN '.$this->CFG['db']['tbl']['blog_posts'].' AS bp ON b.blog_id = bp.blog_id JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON bp.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['blog_category'].' AS bc ON bc.blog_category_id =bp.blog_category_id'));
				$this->setReturnColumns(array('b.blog_id,b.blog_name, bp.message', 'bp.blog_post_id','bp.user_id', 'bp.blog_access_type', 'DATE_FORMAT(bp.date_of_publish, "%d %b %Y") as published_date', 'bp.blog_category_id',
											  'bp.relation_id', 'bp.blog_post_name', 'bp.date_added', 'NOW() as date_current', 'bp.total_favorites',
											  'DATE_FORMAT(bp.date_added, "%d %b %Y") as added_date', 'bp.total_views', '(bp.rating_total/bp.rating_count) as rating',
											  'blog_tags', 'status', 'TIMEDIFF(NOW(), last_view_date) as blog_last_view_date', 'total_comments',
											  'bc.blog_category_name','b.width','b.height'));

				$additional_query = '';
				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'blog_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'blog_post_name', '').') AND ';
				$this->sql_condition = $additional_query.'bp.user_id=\''.$this->CFG['user']['user_id'].'\' AND b.blog_status=\'Active\' AND status=\'Draft\''.$this->advancedFilters();
				$this->sql_sort = 'blog_post_id DESC';
				break;

			case 'infutureposts':
				$this->setTableNames(array($this->CFG['db']['tbl']['blogs'] . ' AS b '.' JOIN '.$this->CFG['db']['tbl']['blog_posts'].' AS bp ON b.blog_id = bp.blog_id JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON bp.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['blog_category'].' AS bc ON bc.blog_category_id =bp.blog_category_id'));
				$this->setReturnColumns(array('b.blog_id,b.blog_name, bp.message', 'bp.blog_post_id','bp.user_id', 'bp.blog_access_type', 'DATE_FORMAT(bp.date_of_publish, "%d %b %Y") as published_date','bp.blog_category_id',
											  'bp.relation_id', 'bp.blog_post_name', 'bp.date_added', 'NOW() as date_current', 'bp.total_favorites',
											  'DATE_FORMAT(bp.date_added, "%d %b %Y") as added_date', 'bp.total_views', '(bp.rating_total/bp.rating_count) as rating',
											  'blog_tags', 'status', 'TIMEDIFF(NOW(), last_view_date) as blog_last_view_date', 'total_comments',
											  'bc.blog_category_name','b.width','b.height'));

				$additional_query = '';
				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'blog_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'blog_post_name', '').') AND ';
				$this->sql_condition = $additional_query.'bp.user_id=\''.$this->CFG['user']['user_id'].'\' AND b.blog_status=\'Active\' AND status=\'InFuture\''.$this->advancedFilters();
				$this->sql_sort = 'blog_post_id DESC';
				break;

			case 'myfavoriteposts':
				$this->setTableNames(array($this->CFG['db']['tbl']['blogs'] . ' AS b '.' JOIN '.$this->CFG['db']['tbl']['blog_favorite'].' as bf ON b.blog_id=bf.blog_id LEFT JOIN '.$this->CFG['db']['tbl']['blog_posts'].' AS bp ON b.blog_id = bp.blog_id JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON bp.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['blog_category'].' AS bc ON bc.blog_category_id =bp.blog_category_id'));
				$this->setReturnColumns(array('b.blog_id,b.blog_name, bp.message', 'bp.blog_post_id','bp.user_id', 'bp.blog_access_type', 'DATE_FORMAT(bp.date_of_publish, "%d %b %Y") as published_date', 'bp.blog_category_id',
											  'bp.relation_id', 'bp.blog_post_name', 'bp.date_added', 'NOW() as date_current', 'bp.total_favorites',
											  'DATE_FORMAT(bp.date_added, "%d %b %Y") as added_date', 'bp.total_views', '(bp.rating_total/bp.rating_count) as rating',
											  'blog_tags', 'status', 'TIMEDIFF(NOW(), last_view_date) as blog_last_view_date', 'total_comments',
											  'bc.blog_category_name','b.width','b.height'));

				$additional_query = '';
				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'blog_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'blog_post_name', '').') AND ';
				$this->sql_condition = $additional_query.'bf.user_id='.$this->CFG['user']['user_id'].' AND b.blog_status=\'Active\' AND bp.status=\'Ok\' AND (bp.user_id = '.$this->CFG['user']['user_id'].
										' OR bp.blog_access_type = \'Public\''.$this->getAdditionalQuery('bp.').')'.$this->advancedFilters();
				$this->sql_sort = 'blog_favorite_id DESC';
				break;

			case 'posttoprated':
				$this->setTableNames(array($this->CFG['db']['tbl']['blogs'] . ' AS b '.' JOIN '.$this->CFG['db']['tbl']['blog_posts'].' AS bp ON b.blog_id = bp.blog_id JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON bp.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['blog_category'].' AS bc ON bc.blog_category_id =bp.blog_category_id'));
				$this->setReturnColumns(array('b.blog_id,b.blog_name, bp.message', 'bp.blog_post_id','bp.user_id', 'bp.blog_access_type', 'DATE_FORMAT(bp.date_of_publish, "%d %b %Y") as published_date', 'bp.blog_category_id',
											  'bp.relation_id', 'bp.blog_post_name', 'bp.date_added', 'NOW() as date_current', 'bp.total_favorites',
											  'DATE_FORMAT(bp.date_added, "%d %b %Y") as added_date', 'bp.total_views', '(bp.rating_total/bp.rating_count) as rating',
											  'blog_tags', 'status', 'TIMEDIFF(NOW(), last_view_date) as blog_last_view_date', 'total_comments',
											  'bc.blog_category_name','b.width','b.height'));

				$additional_query = '';
				if($this->fields_arr['cid'])
				{
					$additional_query .= '(bp.blog_category_id=\''.addslashes($this->fields_arr['cid']).'\') AND ';

					if($this->fields_arr['sid'])
						$additional_query .= '(bp.blog_sub_category_id=\''.addslashes($this->fields_arr['sid']).'\') AND ';
				}

				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'blog_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'blog_post_name', '').') AND ';
				$this->sql_condition = $additional_query.'bp.status=\'Ok\''.' AND b.blog_status=\'Active\' AND u.usr_status=\'Ok\''.$this->getAdultQuery('bp.', 'blog').' AND ( ' . $this->myblogpostCondition() . ' ) '.
										' AND bp.rating_total>0 AND bp.allow_ratings=\'Yes\''.$this->advancedFilters();
				$this->sql_sort = 'rating DESC';
				break;

			case 'postmostviewed':
				$this->setTableNames(array($this->CFG['db']['tbl']['blogs'] . ' AS b '.' JOIN '.$this->CFG['db']['tbl']['blog_viewed'].' as bv ON b.blog_id=bv.blog_id LEFT JOIN '.$this->CFG['db']['tbl']['blog_posts'].' AS bp ON bv.blog_post_id = bp.blog_post_id JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON bp.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['blog_category'].' AS bc ON bc.blog_category_id =bp.blog_category_id'));
				$this->setReturnColumns(array('b.blog_id,b.blog_name, bp.message', 'bp.blog_post_id','bp.user_id', 'bp.blog_access_type', 'DATE_FORMAT(bp.date_of_publish, "%d %b %Y") as published_date', 'bp.blog_category_id',
											  'bp.relation_id', 'bp.blog_post_name', 'bp.date_added', 'NOW() as date_current', 'bp.total_favorites',
											  'DATE_FORMAT(bp.date_added, "%d %b %Y") as added_date', 'bp.total_views', '(bp.rating_total/bp.rating_count) as rating',
											  'blog_tags', 'status', 'TIMEDIFF(NOW(), last_view_date) as blog_last_view_date', 'total_comments',
											  'SUM(bv.total_views) as sum_total_views','bv.total_views as individual_total_views','bc.blog_category_name','b.width','b.height'));

				$this->sql_sort = 'sum_total_views DESC';

				$additional_query = '';
				if($this->fields_arr['cid'])
				{
					$additional_query .= '(bp.blog_category_id=\''.addslashes($this->fields_arr['cid']).'\') AND ';

					if($this->fields_arr['sid'])
						$additional_query .= '(bp.blog_sub_category_id=\''.addslashes($this->fields_arr['sid']).'\') AND ';
				}

				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'blog_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'blog_post_name', '').') AND ';
				$this->sql_condition = $additional_query.'bp.status=\'Ok\' AND b.blog_status=\'Active\' AND bp.total_views>0 AND u.usr_status=\'Ok\''.$this->getAdultQuery('bp.', 'blog').' AND ( ' . $this->myblogpostCondition() . ' ) '.$this->getMostViewedExtraQuery().
										$this->advancedFilters().' GROUP BY bp.blog_post_id';
				break;

			case 'postmostdiscussed':
			    $this->setTableNames(array($this->CFG['db']['tbl']['blogs'] . ' AS b '.' JOIN '.$this->CFG['db']['tbl']['blog_comments'].' as bcmt ON b.blog_id=bcmt.blog_id LEFT JOIN '.$this->CFG['db']['tbl']['blog_posts'].' AS bp ON b.blog_id = bp.blog_id JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON bp.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['blog_category'].' AS bc ON bc.blog_category_id =bp.blog_category_id'));
				$this->setReturnColumns(array('b.blog_id,b.blog_name, bp.message', 'bp.blog_post_id','bp.user_id', 'bp.blog_access_type', 'DATE_FORMAT(bp.date_of_publish, "%d %b %Y") as published_date', 'bp.blog_category_id',
											  'bp.relation_id', 'bp.blog_post_name', 'bp.date_added', 'NOW() as date_current', 'bp.total_favorites',
											  'DATE_FORMAT(bp.date_added, "%d %b %Y") as added_date', 'bp.total_views', '(bp.rating_total/bp.rating_count) as rating',
											  'blog_tags', 'status', 'TIMEDIFF(NOW(), last_view_date) as blog_last_view_date', 'total_comments',
											  'COUNT(bcmt.blog_post_id) as sum_total_comments','bc.blog_category_name','b.width','b.height'));
				$additional_query = '';
				if($this->fields_arr['cid'])
				{
					$additional_query .= '(bp.blog_category_id=\''.addslashes($this->fields_arr['cid']).'\') AND ';

					if($this->fields_arr['sid'])
						$additional_query .= '(bp.blog_sub_category_id=\''.addslashes($this->fields_arr['sid']).'\') AND ';
				}

				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'blog_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'blog_post_name', '').') AND ';
				$this->sql_condition = $additional_query.'bp.status=\'Ok\' AND b.blog_status=\'Active\' AND bcmt.comment_status=\'Yes\' AND bp.total_comments>0 AND u.usr_status=\'Ok\''.$this->getAdultQuery('bp.', 'blog').' AND ( ' . $this->myblogpostCondition() . ' ) '.
										$this->advancedFilters().$this->getMostDiscussedExtraQuery().' GROUP BY b.blog_id';
				$this->sql_sort = 'sum_total_comments DESC, total_views DESC';
				break;

			case 'postmostfavorite':

				$this->setTableNames(array($this->CFG['db']['tbl']['blogs'] . ' AS b '.' JOIN '.$this->CFG['db']['tbl']['blog_favorite'].' as bf ON b.blog_id=bf.blog_id LEFT JOIN '.$this->CFG['db']['tbl']['blog_posts'].' AS bp ON b.blog_id = bp.blog_id JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON bp.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['blog_category'].' AS bc ON bc.blog_category_id =bp.blog_category_id'));
				$this->setReturnColumns(array('b.blog_id,b.blog_name, bp.message', 'bp.blog_post_id','bp.user_id', 'bp.blog_access_type', 'DATE_FORMAT(bp.date_of_publish, "%d %b %Y") as published_date', 'bp.blog_category_id',
											  'bp.relation_id', 'bp.blog_post_name', 'bp.date_added', 'NOW() as date_current', 'bp.total_favorites',
											  'DATE_FORMAT(bp.date_added, "%d %b %Y") as added_date', 'bp.total_views', '(bp.rating_total/bp.rating_count) as rating',
											  'blog_tags', 'status', 'TIMEDIFF(NOW(), last_view_date) as blog_last_view_date', 'total_comments',
											  'COUNT(bf.blog_post_id) as sum_total_favorites','bc.blog_category_name','b.width','b.height'));

				$additional_query = '';
				if($this->fields_arr['cid'])
				{
					$additional_query .= '(bp.blog_category_id=\''.addslashes($this->fields_arr['cid']).'\') AND ';

					if($this->fields_arr['sid'])
						$additional_query .= '(bp.blog_sub_category_id=\''.addslashes($this->fields_arr['sid']).'\') AND ';
				}

				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'blog_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'blog_post_name','').') AND ';
				$this->sql_condition = $additional_query.'bp.status=\'Ok\' AND b.blog_status=\'Active\' AND bp.total_favorites>0 AND u.usr_status=\'Ok\''.$this->getAdultQuery('bp.', 'blog').' AND ( ' . $this->myblogpostCondition() . ' ) '.
										$this->getMostFavoriteExtraQuery().$this->advancedFilters().' GROUP BY bf.blog_post_id';
				$this->sql_sort = 'sum_total_favorites DESC , total_views DESC';
				break;

			case 'userblogpostlist':
			    $this->setTableNames(array($this->CFG['db']['tbl']['blogs'] . ' AS b '.' JOIN '.$this->CFG['db']['tbl']['blog_posts'].' AS bp ON b.blog_id = bp.blog_id JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON bp.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['blog_category'].' AS bc ON bc.blog_category_id =bp.blog_category_id'));
				$this->setReturnColumns(array('b.blog_id,b.blog_name, bp.message', 'bp.blog_post_id','bp.user_id', 'bp.blog_access_type', 'DATE_FORMAT(bp.date_of_publish, "%d %b %Y") as published_date', 'bp.blog_category_id',
											  'bp.relation_id', 'bp.blog_post_name', 'bp.date_added', 'NOW() as date_current', 'bp.total_favorites',
											  'DATE_FORMAT(bp.date_added, "%d %b %Y") as added_date', 'bp.total_views', '(bp.rating_total/bp.rating_count) as rating',
											  'blog_tags', 'status', 'TIMEDIFF(NOW(), last_view_date) as blog_last_view_date', 'total_comments',
											  'bc.blog_category_name','b.width','b.height'));
				$additional_query = '';
				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'blog_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'blog_post_name', '') .') AND ';
				$this->sql_condition = $additional_query.'bp.user_id=\''.addslashes($this->fields_arr['user_id']).'\' AND b.blog_status=\'Active\' AND u.usr_status=\'Ok\' AND bp.status=\'Ok\''.$this->getAdultQuery('bp.', 'blog').$this->advancedFilters();
				$this->sql_sort = 'blog_post_id DESC';
				break;

			default://postnew
				$this->setTableNames(array($this->CFG['db']['tbl']['blogs'] . ' AS b '.' JOIN '.$this->CFG['db']['tbl']['blog_posts'].' AS bp ON b.blog_id = bp.blog_id JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON bp.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['blog_category'].' AS bc ON bc.blog_category_id =bp.blog_category_id'));
				$this->setReturnColumns(array('b.blog_id,b.blog_name, bp.message', 'bp.blog_post_id','bp.user_id', 'bp.blog_access_type', 'DATE_FORMAT(bp.date_of_publish, "%d %b %Y") as published_date', 'bp.blog_category_id',
											  'bp.relation_id', 'bp.blog_post_name', 'bp.date_added', 'NOW() as date_current', 'bp.total_favorites',
											  'DATE_FORMAT(bp.date_added, "%d %b %Y") as added_date', 'bp.total_views', '(bp.rating_total/bp.rating_count) as rating',
											  'blog_tags', 'status', 'TIMEDIFF(NOW(), last_view_date) as blog_last_view_date', 'total_comments',
											  'bc.blog_category_name','b.width','b.height'));
				$additional_query = '';
				if($this->fields_arr['cid'])
				{
					$additional_query .= '(bp.blog_category_id=\''.addslashes($this->fields_arr['cid']).'\') AND ';

					if($this->fields_arr['sid'])
						$additional_query .= '(bp.blog_sub_category_id=\''.addslashes($this->fields_arr['sid']).'\') AND ';
				}
				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'bp.blog_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'bp.blog_post_name', '').') AND ';

				$this->sql_condition = $additional_query.'bp.status=\'Ok\' AND b.blog_status=\'Active\' AND u.usr_status=\'Ok\''.$this->getAdultQuery('bp.', 'blog').' AND ( ' . $this->myblogpostCondition() . ' ) '.$this->advancedFilters();
				$this->sql_sort = 'bp.date_added DESC';
				break;
		}
	}

	/**
	 * BlogPostList::showBlogPostList()
	 *
	 * @return void
	 */
	public function showBlogPostList()
	{
		global $smartyObj;
		$showBlogPostList_arr = array();
		//for tags
		$showBlogPostList_arr['separator'] = ':&nbsp;';
		$tag = $this->_parse_tags(strtolower($this->fields_arr['tags']));
		$relatedTags = array();

		$blogPerRow = $this->CFG['admin']['blog']['list_per_line_total_blog_post'];

		$count = 0;
		$found = false;

		$fields_list = array('user_name', 'first_name', 'last_name');
		$blogPostTags = array();
		$showBlogPostList_arr['row'] = array();
		$inc = 1;
		while($row = $this->fetchResultRecord())
	    {

			$need_profile_icon_arr = array('featuredblogpostlist', 'postnewmale', 'postnewfemale');
			if(in_array($this->fields_arr['pg'], $need_profile_icon_arr))
			{
				$this->UserDetails[$row['user_id']]['first_name'] = $row['first_name'];
				$this->UserDetails[$row['user_id']]['last_name'] = $row['last_name'];
				$this->UserDetails[$row['user_id']]['user_name'] = $row['user_name'];

				if(!$this->getBlogPostDetails(array('message', 'blog_post_id', 'TIMEDIFF(NOW(), date_added) as date_added', 'user_id', '(rating_total/rating_count) as rating', 'total_views', 'blog_post_name', 'status', 'TIMEDIFF(NOW(), last_view_date) as blog_last_view_date'), $row['icon_id']))
					continue;
				$row = array_merge($row, $this->blog_post_details);
			}

			if(($row['date_added'] != '') && ($row['date_current'] != ''))
			$row['date_added'] = getDateTimeDiff($row['date_added'],$row['date_current']);

			$showBlogPostList_arr['row'][$inc]['individual_total_views'] = '';
			if(!isset($row['sum_total_views']))
	        $row['sum_total_views']='';
	        if(!isset($row['sum_total_comments']))
	        $row['sum_total_comments']='';
	        if(!isset($row['sum_total_favorites']))
	        $row['sum_total_favorites']='';
	        $showBlogPostList_arr['row'][$inc]['total_favorite']='';
	        $showBlogPostList_arr['row'][$inc]['sum_total_views'] = $row['sum_total_views'];
	        $showBlogPostList_arr['row'][$inc]['sum_total_comments'] = $row['sum_total_comments'];
	        $showBlogPostList_arr['row'][$inc]['sum_total_favorites'] = $row['sum_total_favorites'];
	        $showBlogPostList_arr['row'][$inc]['user_id'] = $row['user_id'];
	       	$showBlogPostList_arr['row'][$inc]['view_blog_link'] = getUrl('viewblog', '?blog_name='.$row['blog_name'], $row['blog_name'].'/', '', 'blog');
			//To Display the number of days blog post added
			$row['date_added'] = ($row['date_added'] != '') ? getTimeDiffernceFormat($row['date_added']) : '';
			$row['blog_last_view_date'] = ($row['blog_last_view_date'] != '') ? getTimeDiffernceFormat($row['blog_last_view_date']) : '';

			//To Display Blog Post's Added Date in DD MMM YYYY (01 Jan 2009) Format
			$row['date_added'] = $row['added_date'];
			$row['date_published'] = $row['published_date'];
			$showBlogPostList_arr['row'][$inc]['record'] = $row;

			if(!isset($this->UserDetails[$row['user_id']]))
				$this->getUserDetail('user_id',$row['user_id'], 'user_name');

			$showBlogPostList_arr['row'][$inc]['name'] = $this->getUserDetail('user_id',$row['user_id'], 'user_name');
			$showBlogPostList_arr['row'][$inc]['view_blog_post_link'] = getUrl('viewpost', '?blog_post_id='.$row['blog_post_id'].'&amp;title='.$this->changeTitle($row['blog_post_name']), $row['blog_post_id'].'/'.$this->changeTitle($row['blog_post_name']).'/', '', 'blog');

			$view_blog_post_page_arr = array('myblogpost', 'userblogpostlist');

			if(in_array($this->fields_arr['pg'], $view_blog_post_page_arr))
				$showBlogPostList_arr['row'][$inc]['view_blog_post_link'] = getUrl('viewpost', '?blog_post_id='.$row['blog_post_id'].'&amp;title='.$this->changeTitle($row['blog_post_name']), $row['blog_post_id'].'/'.$this->changeTitle($row['blog_post_name']).'/', '', 'blog');

			$found = true;
			$showBlogPostList_arr['row'][$inc]['open_tr'] = false;
			if ($count%$blogPerRow==0)
	    	{
				$showBlogPostList_arr['row'][$inc]['open_tr'] = false;
	    	}
			$showBlogPostList_arr['row'][$inc]['anchor'] = 'dAlt_'.$row['blog_post_id'];

			if($row['status']=='Locked')
			{
				$showBlogPostList_arr['row'][$inc]['row_blog_post_name_manual'] = $row['blog_post_name'];

				$showBlogPostList_arr['row'][$inc]['blog_post_ids_checked'] = '';
			}
			else
			{
				//Condition to allow edit option only for the follwing pages specified in array
				$editOptionPagesArray = array('myposts', 'toactivate', 'notapproved', 'draftposts',  'infutureposts', 'publishedposts', 'postnew', 'postrecent', 'posttoprated', 'postmostviewed', 'postmostdiscussed', 'postmostfavorite', 'userblogpostlist','invalid_blog_post_id','private_post');
				$showBlogPostList_arr['row'][$inc]['blog_post_ids_checked'] = '';
				if(in_array($this->fields_arr['pg'], $editOptionPagesArray))
				{
					$showBlogPostList_arr['row'][$inc]['blog_post_ids_checked'] = '';
					if((is_array($this->fields_arr['blog_post_ids'])) && (in_array($row['blog_post_id'], $this->fields_arr['blog_post_ids'])))
					  	$showBlogPostList_arr['row'][$inc]['blog_post_ids_checked'] = "checked";
			        	$showBlogPostList_arr['row'][$inc]['blog_post_posting_url_ok'] = getUrl('manageblogpost', '?blog_post_id='.$row['blog_post_id'], $row['blog_post_id'].'/', '', 'blog');

				}

				$search_word= '';
				if($this->fields_arr['blog_post_name']!='' && $this->fields_arr['blog_post_name']!=$this->LANG['blogpostlist_title_field'])
					$search_word=$this->fields_arr['blog_post_name'];
				elseif($this->fields_arr['tags']!='' && $this->fields_arr['tags']!=$this->LANG['blogpostlist_search_blogpost_tags'])
					$search_word=$this->fields_arr['tags'];

				$showBlogPostList_arr['row'][$inc]['row_blog_post_name_manual'] = highlightWords($row['blog_post_name'], $search_word);

				$showBlogPostList_arr['row'][$inc]['row_blog_category_name_manual'] = $row['blog_category_name'];
				$showBlogPostList_arr['row'][$inc]['blog_category_id'] = $row['blog_category_id'];
				$showBlogPostList_arr['row'][$inc]['blog_category_id_link']= getUrl('blogpostlist','?pg=postnew&cid='.$row['blog_category_id'], 'postnew/?cid='.$row['blog_category_id'],'','blog');

				$username=$this->getUserDetail('user_id',$row['user_id'], 'user_name');
				$showBlogPostList_arr['row'][$inc]['userDetails'] = $username;
				$showBlogPostList_arr['row'][$inc]['member_profile_url'] = getMemberProfileUrl($row['user_id'], $username);
				//$showBlogPostList_arr['row'][$inc]['message']=wordWrap_mb_Manual($row['message'],$this->CFG['admin']['blog']['blog_post_list_message_length'],$this->CFG['admin']['blog']['blog_post_list_message_total_length']);
				$showBlogPostList_arr['row'][$inc]['message']=strip_selected_blog_tags(truncateByCheckingHtmlTags($row['message'],$this->CFG['admin']['blog']['blog_post_list_message_total_length'],'...',true,true));
                $showBlogPostList_arr['row'][$inc]['profileIcon']=getMemberAvatarDetails($row['user_id']);
				$showBlogPostList_arr['row'][$inc]['width'] = $row['width'];
				$showBlogPostList_arr['row'][$inc]['height'] = $row['height'];
				$showBlogPostList_arr['row'][$inc]['status'] = $row['status'];
				$tags= $this->_parse_tags($row['blog_tags']);
				$showBlogPostList_arr['row'][$inc]['tags'] = $tags;

				if ($tags)
			    {
			    	$showBlogPostList_arr['row'][$inc]['tags_arr'] = array();
			        $i = 0;
					foreach($tags as $key=>$value)
					{
						if($this->CFG['admin']['blog']['tags_count_list_page']==$i)
							break;
						$value = strtolower($value);

						if (!in_array($value, $tag) AND !in_array($value, $relatedTags))
							$relatedTags[] = $value;

						if (!in_array($value, $blogPostTags))
					        $blogPostTags[] = $value;

						$showBlogPostList_arr['row'][$inc]['tags_arr'][$i]['url'] = getUrl('blogpostlist', '?pg=postnew&amp;tags='.$value, 'postnew/?tags='.$value, '', 'blog');
						$showBlogPostList_arr['row'][$inc]['tags_arr'][$i]['value'] = highlightWords($value, $search_word);
						$i++;
					}
				 }
			}
			$count++;
			$showBlogPostList_arr['row'][$inc]['end_tr'] = false;
			if ($count%$blogPerRow==0)
		    {
				$count = 0;
				$showBlogPostList_arr['row'][$inc]['end_tr'] = true;
	    	}
		    $inc++;
		}// end while

		$showBlogPostList_arr['extra_td_tr'] = '';
		if ($found and $count and $count<$blogPerRow)
	    {
	    	$colspan = $blogPerRow-$count;
			$showBlogPostList_arr['extra_td_tr'] = '<td colspan="'.$colspan.'">&nbsp;</td></tr>';
	    }
		if($this->fields_arr['tags'] and $this->CFG['admin']['tagcloud_based_search_count'])
			$this->updateBlogPostTagDetails($blogPostTags);

		$smartyObj->assign('showBlogPostList_arr', $showBlogPostList_arr);
	}

	/**
	 * BlogPostList::myblogpostCondition()
	 *
	 * @param void
	 * @return string
	 */
	public function myblogpostCondition()
	{
		if($this->fields_arr['user_id'] != '0')
			$userCondition = ' bp.user_id = '.$this->fields_arr['user_id'].' ';
		else
			$userCondition = 'bp.user_id = '.  $this->CFG['user']['user_id'] . ' OR bp.blog_access_type = \'Public\'' . $this->getAdditionalQuery('bp.');
		return $userCondition;
	}

	/**
	 * BlogPostList::updateBlogPostTagDetails()
	 *
	 * @param array $blogPostTags
	 * @return void
	 */
	public function updateBlogPostTagDetails($blogPostTags = array())
	{
		$tags = $this->fields_arr['tags'];
		$tags = trim($tags);
		$tags = $this->_parse_tags($tags);
		$match = array_intersect($tags, $blogPostTags);
		$match = array_unique($match);
		if (empty($match))
	        return;
		if (count($match)==1)
	     	$this->updateSearchCountAndResultForBlogPostTag($match[0]);
		else
		{
			for($i=0; $i<count($match); $i++)
			{
				$tag = $match[$i];
				$this->updateSearchCountForBlogPostTag($tag);
			}
		}
	}

	/**
	 * BlogPostList::updateSearchCountForBlogPostTag()
	 *
	 * @param string $tag
	 * @return void
	 */
	public function updateSearchCountForBlogPostTag($tag='')
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_tags'].
			   ' SET search_count = search_count + 1,'.
			   ' result_count = '.$this->getResultsTotalNum().','.
			   ' last_searched = NOW()'.
			   ' WHERE tag_name='.$this->dbObj->Param('tag_name');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($tag));
		    if (!$rs)
			    trigger_db_error($this->dbObj);

		if ($this->dbObj->Affected_Rows()==0)
	    {
			$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['blog_tags'].
				   ' SET search_count = search_count + 1 ,'.
				   ' result_count = '.$this->getResultsTotalNum().','.
				   ' last_searched = NOW(),'.
				   ' tag_name='.$this->dbObj->Param('tag_name');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($tag));
			    if (!$rs)
				    trigger_db_error($this->dbObj);
	    }
	}

	/**
	 * BlogPostList::updateSearchCountAndResultForBlogPostTag()
	 *
	 * @param string $tag
	 * @return void
	 */
	public function updateSearchCountAndResultForBlogPostTag($tag='')
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_tags'].
			   ' SET search_count = search_count + 1,'.
			   ' result_count = '.$this->getResultsTotalNum().','.
			   ' last_searched = NOW()'.
			   ' WHERE tag_name='.$this->dbObj->Param('tag_name');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($tag));
		    if (!$rs)
			    trigger_db_error($this->dbObj);

		if ($this->dbObj->Affected_Rows()==0)
	    {
			$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['blog_tags'].
				   ' SET search_count = search_count + 1 ,'.
				   ' result_count = '.$this->getResultsTotalNum().','.
				   ' last_searched = NOW(),'.
				   ' tag_name='.$this->dbObj->Param('tag_name');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($tag));
			    if (!$rs)
				    trigger_db_error($this->dbObj);
	    }
	}

	/**
	 * BlogPostList::getCategoryName()
	 *
	 * @return string
	 */
	public function getCategoryName()
	{
		if ($this->fields_arr['sid'])
            $categoryId = $this->fields_arr['sid'];
        else
            $categoryId = $this->fields_arr['cid'];

		$sql = 'SELECT blog_category_name FROM '.$this->CFG['db']['tbl']['blog_category'].
				' WHERE blog_category_id='.$this->dbObj->Param('blog_category_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($categoryId));
		    if (!$rs)
			    trigger_db_error($this->dbObj);

		if($row = $rs->FetchRow())
			return $row['blog_category_name'];
		return $this->LANG['blogpostlist_unknown_category'];
	}

	/**
	 * BlogPostList::getSubCategoryName()
	 *
	 * @return string
	 */
	public function getSubCategoryName()
	{
		$sql = 'SELECT blog_category_name FROM '.$this->CFG['db']['tbl']['blog_category'].
				' WHERE blog_category_id='.$this->dbObj->Param('blog_sub_category_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['sid']));
		    if (!$rs)
			    trigger_db_error($this->dbObj);

		if($row = $rs->FetchRow())
			return ' - '.$row['blog_category_name'];
		return ' - '.$this->LANG['blogpostlist_unknown_sub_category'];
	}

	/**
	 * BlogPostList::getPageTitle()
	 *
	 * @return string
	 */
	public function getPageTitle()
	{
		$pg_title = $this->LANG['blogpostlist_title'];

		switch($this->fields_arr['pg'])
		{
			case 'myposts':
				$pg_title = $this->LANG['blogpostlist_myposts_title'];
				break;

			case 'toactivate':
				$pg_title = $this->LANG['blogpostlist_toactivate_posts_title'];
				break;

			case 'notapproved':
				$pg_title = $this->LANG['blogpostlist_notapproved_post_title'];
				break;

			case 'draftposts':
				$pg_title = $this->LANG['blogpostlist_draft_post_title'];
				break;

			case 'infutureposts':
				$pg_title = $this->LANG['blogpostlist_infuture_posts_title'];
				break;

			case 'publishedposts':
				$pg_title = $this->LANG['blogpostlist_published_posts_title'];
				break;

			case 'posttoprated':
				$pg_title = $this->LANG['blogpostlist_posts_toprated_title'];
				break;

			case 'postmostviewed':
				$pg_title = $this->LANG['blogpostlist_posts_mostviewed_title'];
				break;

			case 'postmostdiscussed':
				$pg_title = $this->LANG['blogpostlist_posts_mostdiscussed_title'];
				break;

			case 'postmostfavorite':
				$pg_title = $this->LANG['blogpostlist_posts_mostfavorite_title'];
				break;

		    case 'myfavoriteposts':
				$pg_title = $this->LANG['blogpostlist_posts_myfavoriteposts_title'];
				break;

			case 'userblogpostlist':
                $pg_title = $this->LANG['blogpostlist_userblogpostlist_title'];
                $fields_list = array('user_name', 'first_name', 'last_name');
                if (!isset($this->UserDetails[$this->fields_arr['user_id']]))
                   $this->getUserDetail('user_id',$this->fields_arr['user_id'], 'user_name');
                $name = getUserDetail('user_id',$this->fields_arr['user_id'],'user_name');
                $pg_title = str_replace('{user_name}', $name, $pg_title);
                $pg_title .= ' '.$this->LANG['blogpostlist_userblogpostlist_blog_post_name'];
                break;

			default://postnew

				if ($this->fields_arr['pg'] == 'postrecent')
					$pg_title = $this->LANG['blogpostlist_postrecent_title'];
				else
					$pg_title = $this->LANG['blogpostlist_postnew_title'];
				break;
		}


		//change the page title if other user blog post is selected
		if($this->fields_arr['pg'] != 'userblogpostlist' && $this->fields_arr['user_id'] != 0)
		{
			  $members_title = $this->LANG['blogpostlist_userblogpostlist_title'];
	          $fields_list = array('user_name', 'first_name', 'last_name');
	          if (!isset($this->UserDetails[$this->fields_arr['user_id']]))
	          	$this->getUserDetail('user_id',$this->fields_arr['user_id'], 'user_name');
	          $name = getUserDetail('user_id',$this->fields_arr['user_id'],'user_name');
		      $members_title = str_replace('{user_name}', $name, $members_title);
	          if($this->fields_arr['pg'] == 'postnew' || $this->fields_arr['pg'] == '')
	          	$pg_title = $members_title.' '.$this->LANG['blogpostlist_userblogpostlist_blog_post_name'];
	          else
	          	$pg_title = $members_title.' '.$pg_title;

	    }

		//change the page title if correspnding category or subcategory selected with dropdown list of options
		if ($this->fields_arr['cid'] || $this->fields_arr['sid'] )
		{
	        $categoryTitle = $this->LANG['blogpostlist_category_blog_post_title'];
	        $name = $this->getCategoryName();
	        $categoryTitle = str_replace('{category_name}',$name, $categoryTitle);
	    }
		if(($this->fields_arr['pg'] || $this->getFormField('default')== 'Yes') && ($this->fields_arr['cid'] || $this->fields_arr['sid']))
		{
			if($this->fields_arr['pg'] == '' && $this->fields_arr['cid'] == '')
				$pg_title = $categoryTitle;
			else
				$pg_title = $pg_title.' '.$this->LANG['common_in'].' '.$categoryTitle;
		}

		if ($this->fields_arr['tags'])
		{
	        $tagsTitle = $this->LANG['blogpostlist_tags_blog_post_name'];
	        $name = $this->fields_arr['tags'];
	        $tagsTitle = str_replace('{tags_name}', $name, $tagsTitle);
	    }
		if(($this->fields_arr['pg'] || $this->getFormField('default')== 'Yes')&& $this->fields_arr['tags'])
		{
			$pg_title = $pg_title.' '.$tagsTitle;
		}

		return $pg_title;
	}


	/**
	 * BlogPostList::getActionTitle()
	 *
	 * @return string
	 */
	public function getActionTitle($pg = false)
	{
		$action_title = $this->LANG['blogpostlist_title'];

		switch($this->fields_arr['action'])
		{
			case '1':
				$action_title = $this->LANG['common_today'];
				break;

			case '2':
				$action_title = $this->LANG['common_yesterday'];
				break;

			case '3':
				$action_title = $this->LANG['common_this_week'];
				break;

			case '4':
				$action_title = $this->LANG['common_this_month'];
				break;

			case '5':
				$action_title = $this->LANG['common_this_year'];
				break;

			default://postnew
				$action_title = $this->LANG['common_all_time'];
				break;
		}
		if($pg && $this->fields_arr['action']) $action_title .= $this->LANG['common_noun'];
		return $action_title;
	}
	/**
	 * BlogPostList::populateSubCategories()
	 *
	 * @return void
	 */
	public function populateSubCategories()
	{
		global $smartyObj;
		$populateSubCategories_arr = array();

		$sql = 'SELECT blog_category_id, blog_category_name, blog_category_description '.
				'FROM '.$this->CFG['db']['tbl']['blog_category'].' '.
				'WHERE blog_category_status = \'Yes\' '.
				'AND parent_category_id='.$this->dbObj->Param('parent_category_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['cid']));
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		$usersPerRow = 3;
		$count = 0;
		$found = false;
		$populateSubCategories_arr['row'] = array();
		$inc = 1;
		while($row = $rs->FetchRow())
		{
			$found = true;
			$populateSubCategories_arr['row'][$inc]['open_tr'] = '';
			if ($count%$usersPerRow==0)
	   		{
				$populateSubCategories_arr['row'][$inc]['open_tr'] = '<tr>';
		    }

			$populateSubCategories_arr['row'][$inc]['record'] = $row;

			$populateSubCategories_arr['row'][$inc]['blog_post_list_url'] = getUrl('blogpostlist', '?pg='.$this->fields_arr['pg'].'&cid='.$this->fields_arr['cid'].'&sid='.$row['blog_category_id'], $this->fields_arr['pg'].'/?cid='.$this->fields_arr['cid'].'&sid='.$row['blog_category_id'], '', 'blog');
			$populateSubCategories_arr['row'][$inc]['blog_category_name_manual'] = nl2br(stripslashes($row['blog_category_name']));


			$count++;
			$populateSubCategories_arr['row'][$inc]['end_tr'] = '';
			if ($count%$usersPerRow==0)
		    {
				$count = 0;
				$populateSubCategories_arr['row'][$inc]['end_tr'] = '</tr>';
    		}

			$inc++;
		}
		$smartyObj->assign('populateSubCategories_arr', $populateSubCategories_arr);
	}

	public function populateMorePostsLinks()
	{
		global $smartyObj;
		$populateMorePostsLinks_arr = array();

		$populateMorePostsLinks_arr['postnew'] = $this->LANG['common_header_nav_blog_new'];
		$populateMorePostsLinks_arr['postrandom'] = $this->LANG['common_header_nav_blog_random'];
		$populateMorePostsLinks_arr['posttoprated'] = $this->LANG['common_header_nav_blog_top_rated'];
		$populateMorePostsLinks_arr['postrecommended'] = $this->LANG['common_header_nav_blog_most_recommended'];
		$populateMorePostsLinks_arr['postmostviewed'] = $this->LANG['common_header_nav_blog_most_viewed'];

		$smartyObj->assign('populateMorePostsLinks_arr', $populateMorePostsLinks_arr);

	}

	public function populateRatingDetails($rating)
	{
		$rating = round($rating,0);
		return $rating;
	}

	/**
	 * BlogPostList::chkAdvanceResultFound()
	 *
	 * @return boolean
	 */
	public function chkAdvanceResultFound()
	{
		if($this->advanceSearch)
		{
			return true;
		}
		return false;
	}
}
//-------------------- Code begins -------------->>>>>//
$BlogPostList = new BlogPostList();

if(!chkAllowedModule(array('blog')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$BlogPostList->setPageBlockNames(array('my_posts_form', 'delete_confirm_form', 'form_show_sub_category'));
//default form fields and values...
$BlogPostList->setFormField('blog_post_id', '');
$BlogPostList->setFormField('album_id', '');
$BlogPostList->setFormField('blog_post_name', '');
$BlogPostList->setFormField('blog_tags', '');
$BlogPostList->setFormField('action', '');
$BlogPostList->setFormField('action_new', '');
$BlogPostList->setFormField('act', '');
$BlogPostList->setFormField('pg', '');
$BlogPostList->setFormField('cid', '');
$BlogPostList->setFormField('sid', '');
$BlogPostList->setFormField('tags', '');
$BlogPostList->setFormField('user_id', '0');
$BlogPostList->setFormField('default', 'Yes');
$BlogPostList->setFormField('blog_post_keywords', '');
$BlogPostList->setFormField('post_owner', '');
$BlogPostList->setFormField('advanceFromSubmission', '');
$BlogPostList->setFormField('msg', '');
/*********** Page Navigation Start *********/
$BlogPostList->setFormField('start', '0');
$BlogPostList->setFormField('slno', '1');
$BlogPostList->setFormField('blog_post_ids', array());
$BlogPostList->setFormField('numpg', $CFG['blog_tbl']['numpg']);

if(!isMember() && $_GET['pg']=='myposts')
{
	Redirect2URL($BlogPostList->getUrl('login','',''));
}
$BlogPostList->setMinRecordSelectLimit($CFG['data_tbl']['min_record_select_limit']);
$BlogPostList->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$BlogPostList->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$BlogPostList->setTableNames(array());
$BlogPostList->setReturnColumns(array());
$BlogPostList->sanitizeFormInputs($_REQUEST);
/************ page Navigation stop *************/
$BlogPostList->setAllPageBlocksHide();
$BlogPostList->populateMorePostsLinks();

if($BlogPostList->getFormField('cid') && !$BlogPostList->getFormField('sid') && $CFG['admin']['blog']['sub_category'])
{
	$BlogPostList->setPageBlockShow('form_show_sub_category');
}
$BlogPostList->setPageBlockShow('my_posts_form');

//Reset the search form field values
if($BlogPostList->isFormPOSTed($_POST, 'avd_reset'))
{
	$BlogPostList->setFormField('blog_post_keywords', '');
	$BlogPostList->setFormField('post_owner', '');
	$BlogPostList->setFormField('tags', '');
}
if(isset($_REQUEST['action']))
	$BlogPostList->setFormField('action_new', $_REQUEST['action']);
$action_new = $BlogPostList->getFormField('action_new');
$BlogPostList->setFormField('action', $action_new);
$BlogPostList->setFormField('post_owner', $BlogPostList->getFormField('post_owner'));
$BlogPostList->setFormField('blog_post_keywords', $BlogPostList->getFormField('blog_post_keywords'));
if($BlogPostList->getFormField('tags') && !isset($_POST['avd_search']))
{
	$BlogPostList->setFormField('blog_post_keywords', $BlogPostList->getFormField('tags'));
}
elseif(isset($_POST['avd_search']) && $BlogPostList->getFormField('blog_post_keywords')!=$LANG['blogpostlist_keyword_field'])
{
	$BlogPostList->setFormField('tags', $BlogPostList->getFormField('blog_post_keywords'));
}
elseif(isset($_POST['avd_search']) && $BlogPostList->getFormField('blog_post_keywords')==$LANG['blogpostlist_keyword_field'])
{
	$BlogPostList->setFormField('tags', '');
}

if($BlogPostList->getFormField('pg')=='invalid_blog_post_id')
{
	$BlogPostList->setCommonSuccessMsg($LANG['common_msg_invalid_post_id']);
	$BlogPostList->setPageBlockShow('block_msg_form_success');
}
if($BlogPostList->getFormField('pg')=='private_post')
{
	$BlogPostList->setCommonSuccessMsg($LANG['blogpostlist_private_post']);
	$BlogPostList->setPageBlockShow('block_msg_form_success');
}
$pgValue = $BlogPostList->getFormField('pg');
$pgValue = !empty($pgValue)?$pgValue:'postnew';
//Filter option for Blog post most viewed, most disucssed and most favorited based on action set
$blogPostActionNavigation_arr['blog_post_list_url_0'] = getUrl('blogpostlist', '?pg='.$pgValue.'&action=0'.'&cid='.$BlogPostList->getFormField('cid').'&sid='.$BlogPostList->getFormField('sid'), $pgValue.'/?action=0'.'&cid='.$BlogPostList->getFormField('cid').'&sid='.$BlogPostList->getFormField('sid'), '', 'blog');
$blogpostActionNavigation_arr['blog_post_list_url_1'] = getUrl('blogpostlist', '?pg='.$pgValue.'&action=1'.'&cid='.$BlogPostList->getFormField('cid').'&sid='.$BlogPostList->getFormField('sid'), $pgValue.'/?action=1'.'&cid='.$BlogPostList->getFormField('cid').'&sid='.$BlogPostList->getFormField('sid'), '', 'blog');
$blogpostActionNavigation_arr['blog_post_list_url_2'] = getUrl('blogpostlist', '?pg='.$pgValue.'&action=2'.'&cid='.$BlogPostList->getFormField('cid').'&sid='.$BlogPostList->getFormField('sid'), $pgValue.'/?action=2'.'&cid='.$BlogPostList->getFormField('cid').'&sid='.$BlogPostList->getFormField('sid'), '', 'blog');
$blogpostActionNavigation_arr['blog_post_list_url_3'] = getUrl('blogpostlist', '?pg='.$pgValue.'&action=3'.'&cid='.$BlogPostList->getFormField('cid').'&sid='.$BlogPostList->getFormField('sid'), $pgValue.'/?action=3'.'&cid='.$BlogPostList->getFormField('cid').'&sid='.$BlogPostList->getFormField('sid'), '', 'blog');
$blogpostActionNavigation_arr['blog_post_list_url_4'] = getUrl('blogpostlist', '?pg='.$pgValue.'&action=4'.'&cid='.$BlogPostList->getFormField('cid').'&sid='.$BlogPostList->getFormField('sid'), $pgValue.'/?action=4'.'&cid='.$BlogPostList->getFormField('cid').'&sid='.$BlogPostList->getFormField('sid'), '', 'blog');
$blogpostActionNavigation_arr['blog_post_list_url_5'] = getUrl('blogpostlist', '?pg='.$pgValue.'&action=5'.'&cid='.$BlogPostList->getFormField('cid').'&sid='.$BlogPostList->getFormField('sid'), $pgValue.'/?action=5'.'&cid='.$BlogPostList->getFormField('cid').'&sid='.$BlogPostList->getFormField('sid'), '', 'blog');
$blogpostActionNavigation_arr['blog_post_list_url_6'] = getUrl('blogpostlist', '?pg='.$pgValue.'&action=6'.'&cid='.$BlogPostList->getFormField('cid').'&sid='.$BlogPostList->getFormField('sid'), $pgValue.'/?action=6'.'&cid='.$BlogPostList->getFormField('cid').'&sid='.$BlogPostList->getFormField('sid'), '', 'blog');
$blogpostActionNavigation_arr['postMostViewed_0'] = $blogpostActionNavigation_arr['postMostViewed_1'] =
	$blogpostActionNavigation_arr['postMostViewed_2'] = $blogpostActionNavigation_arr['postMostViewed_3'] =
		$blogpostActionNavigation_arr['postMostViewed_4'] = $blogpostActionNavigation_arr['postMostViewed_5'] =
			$blogpostActionNavigation_arr['postMostViewed_6'] = '';
if($BlogPostList->getFormField('pg') == 'postmostviewed'
	OR $BlogPostList->getFormField('pg') == 'postmostdiscussed'
		OR $BlogPostList->getFormField('pg') == 'postmostfavorite')
	{
		if(!$BlogPostList->getFormField('action')) $BlogPostList->setFormField('action', '0');
		$sub_page = 'postMostViewed_'.$BlogPostList->getFormField('action');
		$blogpostActionNavigation_arr[$sub_page] = ' class="clsActive"';
	}

$smartyObj->assign('blogpostActionNavigation_arr', $blogpostActionNavigation_arr);
$start = $BlogPostList->getFormField('start');

if($BlogPostList->isFormPOSTed($_POST, 'yes'))
{
	if($BlogPostList->getFormField('act')=='delete')
	{
		$blog_posts_arr = explode(',',$BlogPostList->getFormField('blog_post_id'));
		$BlogPostList->deleteBlogPosts($blog_posts_arr, $CFG['user']['user_id']);
		$BlogPostList->setCommonSuccessMsg($LANG['blogpostlist_delete_success_msg_confirmation']);
		$BlogPostList->setPageBlockShow('block_msg_form_success');
	}
	if($BlogPostList->getFormField('act')=='set_featured')
	{
		$BlogPostList->setFeatureThisImage($BlogPostList->getFormField('blog_post_id'), $CFG['user']['user_id']);
		$BlogPostList->setPageBlockShow('block_msg_form_error');
		$BlogPostList->setCommonErrorMsg($LANG['blogpostlist_msg_success_set_featured']);
	}
	if($BlogPostList->getFormField('act')=='favorite_delete')
	{
		$blog_post_id_arr = explode(',',$BlogPostList->getFormField('blog_post_id'));
		foreach($blog_post_id_arr as $blog_post_id)
		{
			$BlogPostList->deleteFavoriteBlogPost($blog_post_id, $CFG['user']['user_id']);
		}
	}
}

if ($BlogPostList->isPageGETed($_GET, 'action'))
{
	$BlogPostList->sanitizeFormInputs($_GET);
}

$BlogPostList->LANG['blogpostlist_title'] = $BlogPostList->getPageTitle();
//<<<<<-------------------- Code ends----------------------//
setPageTitle($BlogPostList->LANG['blogpostlist_title']);
setMetaKeywords('Blog Post List');
setMetaDescription('Blog Post List');

$BlogPostList->category_name = '';
if ($BlogPostList->isShowPageBlock('form_show_sub_category'))
{
	$BlogPostList->populateSubCategories();
	$BlogPostList->category_name = $BlogPostList->getCategoryName();
	$BlogPostList->LANG['blogpostlist_category_title'] = str_replace('{category}', $BlogPostList->category_name, $LANG['blogpostlist_category_title']);
}
if ($BlogPostList->isShowPageBlock('my_posts_form'))
{
	/****** navigtion continue*********/
	$BlogPostList->setTableAndColumns();
	$BlogPostList->buildSelectQuery();
	$BlogPostList->buildQuery();
	//$BlogPostList->printQuery();
	$group_query_arr = array('postmostviewed', 'postmostdiscussed', 'postmostfavorite');
	if(in_array($BlogPostList->getFormField('pg'), $group_query_arr))
		$BlogPostList->homeExecuteQuery();
	else
		$BlogPostList->executeQuery();

	$BlogPostList->anchor = 'anchor';
	if($CFG['feature']['rewrite_mode'] == 'htaccess')
		$paging_arr = array('start', 'cid', 'sid', 'tags', 'user_id', 'action', 'start', 'advanceFromSubmission');
	else
		$paging_arr = array('start', 'cid', 'sid', 'tags', 'user_id', 'pg', 'action', 'start', 'advanceFromSubmission');
	$smartyObj->assign('paging_arr',$paging_arr);
	if($BlogPostList->isResultsFound())
	{
		if($CFG['feature']['rewrite_mode'] == 'htaccess')
			$paging_arr = array('start', 'cid', 'sid', 'tags', 'user_id', 'action', 'advanceFromSubmission');
		else
			$paging_arr = array('start', 'cid', 'sid', 'tags', 'user_id', 'pg', 'action', 'advanceFromSubmission');
		$smartyObj->assign('paging_arr',$paging_arr);
		$smartyObj->assign('smarty_paging_list', $BlogPostList->populatePageLinksPOST($BlogPostList->getFormField('start'), 'seachAdvancedFilter'));
		$BlogPostList->my_posts_form['showBlogPostList'] = $BlogPostList->showBlogPostList();
	}
	/******* Navigation End ********/
}

//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$BlogPostList->includeHeader();
//include the content of the page
?>
<script type="text/javascript">
	var form_name_array = new Array('seachAdvancedFilter');
	var block_arr= new Array('selMsgConfirm', 'selMsgConfirmMulti', 'selEditPostComments');
	function loadUrl(element)
	{
		//set the start value as 0 when click the order by field
		document.seachAdvancedFilter.start.value = '0';
		document.getElementById('default').value = 'No';
		document.seachAdvancedFilter.action=element.value;
		document.seachAdvancedFilter.submit();
	}
	function clearValue(id)
	{
	   $Jq('#'+id).val('');
	}
	function setOldValue(id)
	{
		if (($Jq('#'+id).val()=="") && (id == 'post_owner') )
			$Jq('#'+id).val('<?php echo $LANG['blogpostlist_post_created_by']?>');
		if (($Jq('#'+id).val()=="") && (id == 'blog_post_keywords') )
			$Jq('#'+id).val('<?php echo $LANG['blogpostlist_keyword_field']?>');
	}
	function popupWindow(url)
	{
		 window.open (url, "","status=0,toolbar=0,resizable=1,scrollbars=1");
		 return false;
	}
</script>
<?php
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
setTemplateFolder('general/', 'blog');
$smartyObj->display('blogPostList.tpl');
$BlogPostList->includeFooter();
?>