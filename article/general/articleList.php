<?php
/**
 * This file is to manage articles list
 *
 * Provides an interface to view list of article in various views
 * My Articles, My Favourite articles.
 * In My Articles view user can edit, delete articles.
 * In My Favourite Articles view user's favourite articles will be
 * displayed. Article can be removed from favourite list and user
 * can get the code to embed to website.
 *
 * @category	Rayzz
 * @package		General
 */
class ArticleList extends ArticleHandler
{
	public $UserDetails = array();
	public $advanceSearch;

	/**
	 * ArticleList::getMostViewedExtraQuery()
	 *
	 * @return string
	 */
	public function getMostViewedExtraQuery()
	{
		$extra_query = '';
		switch($this->fields_arr['action'])
		{
			case 1:
				$extra_query = ' AND DATE_FORMAT(vp.view_date,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
				break;

			case 2:
				$extra_query = ' AND DATE_FORMAT(vp.view_date,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
				break;

			case 3:
				$extra_query = ' AND DATE_FORMAT(vp.view_date,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
				break;

			case 4:
				$extra_query = ' AND DATE_FORMAT(vp.view_date,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
				break;

			case 5:
				$extra_query = ' AND DATE_FORMAT(vp.view_date,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
				break;
		}
		return $extra_query;
	}

	/**
	 * ArticleList::getMostDiscussedExtraQuery()
	 *
	 * @return string
	 */
	public function getMostDiscussedExtraQuery()
	{
		$extra_query = '';
		switch($this->fields_arr['action'])
		{
			case 1:
				$extra_query = ' AND DATE_FORMAT(pc.date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
				break;

			case 2:
				$extra_query = ' AND DATE_FORMAT(pc.date_added,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
				break;

			case 3:
				$extra_query = ' AND DATE_FORMAT(pc.date_added,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
				break;

			case 4:
				$extra_query = ' AND DATE_FORMAT(pc.date_added,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
				break;

			case 5:
				$extra_query = ' AND DATE_FORMAT(pc.date_added,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
				break;
		}
		return $extra_query;
	}

	/**
	 * ArticleList::getMostFavoriteExtraQuery()
	 *
	 * @return string
	 */
	public function getMostFavoriteExtraQuery()
	{
		$extra_query = '';
		switch($this->fields_arr['action'])
		{
			case 1:
				$extra_query = ' AND DATE_FORMAT(pf.date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
				break;

			case 2:
				$extra_query = ' AND DATE_FORMAT(pf.date_added,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
				break;

			case 3:
				$extra_query = ' AND DATE_FORMAT(pf.date_added,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
				break;

			case 4:
				$extra_query = ' AND DATE_FORMAT(pf.date_added,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
				break;

			case 5:
				$extra_query = ' AND DATE_FORMAT(pf.date_added,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
				break;
		}
		return $extra_query;
	}

	/**
     * ArticleList::advancedFilters()
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
			if ($this->fields_arr['article_keyword'] != $this->LANG['articlelist_keyword_field'] AND $this->fields_arr['article_keyword'])
			{
				//$advanced_filters .= ' AND article_title LIKE \'%' . validFieldSpecialChr($this->fields_arr['article_keyword']) . '%\' ';
				$this->advanceSearch = true;
			}
			if ($this->fields_arr['article_owner'] != $this->LANG['articlelist_article_created_by'] AND $this->fields_arr['article_owner'])
			{
				$advanced_filters .= ' AND u.user_name LIKE \'%' .validFieldSpecialChr($this->fields_arr['article_owner']). '%\' ';
				$this->advanceSearch = true;
			}
			$this->advanceSearch = true;
			return $advanced_filters;
		}
    }

	/**
	 * ArticleList::setTableAndColumns()
	 *
	 * @return void
	 */
	public function setTableAndColumns()
	{
		if(!isMember())
		{
			$not_allowed_arr = array('myarticles', 'myfavoritearticles', 'myrecentlyviewedarticle');
			if(in_array($this->fields_arr['pg'], $not_allowed_arr))
				$this->fields_arr['pg'] = 'articlenew';
		}
		switch($this->fields_arr['pg'])
		{
			case 'myarticles':
				$this->setTableNames(array($this->CFG['db']['tbl']['article'].' AS a JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON a.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['article_category'].' AS mc ON mc.article_category_id =a.article_category_id'));
				$this->setReturnColumns(array('article_summary','article_caption', 'article_server_url', 'article_id', 'article_title', 'DATE_FORMAT(a.date_of_publish, "%d %b %Y") as published_date',
											  'a.date_added', 'NOW() as date_current', 'DATE_FORMAT(a.date_added, "%d %b %Y") as added_date', 'a.user_id',
											  '(rating_total/rating_count) as rating', 'rating_count', 'total_views', 'article_tags', 'article_status', 'article_admin_comments',
											  'TIMEDIFF(NOW(), last_view_date) as article_last_view_date', 'total_comments', 'total_favorites', 'article_attachment',
											  'total_downloads','mc.article_category_name'));
				$additional_query = '';
				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_summary', '').') AND ';

				//$this->sql_condition = $additional_query.'a.user_id=\''.$this->CFG['user']['user_id'].'\' AND article_status=\'Ok\''.$this->advancedFilters();
				$this->sql_condition = $additional_query.'a.user_id=\''.$this->CFG['user']['user_id'].'\' AND article_status IN (\'Ok\', \'Draft\', \'ToActivate\', \'Not Approved\', \'InFuture\')'.$this->advancedFilters();
				$this->sql_sort = 'article_id DESC';
				break;

			case 'myfavoritearticles':
				$this->setTableNames(array($this->CFG['db']['tbl']['article_favorite'].' as f LEFT JOIN '.$this->CFG['db']['tbl']['article'].' as p ON f.article_id=p.article_id'.' JOIN '.$this->CFG['db']['tbl']['article_category'].' AS mc ON mc.article_category_id =p.article_category_id'));
				$this->setReturnColumns(array('article_summary','article_caption', 'article_server_url', 'p.article_id','p.user_id', 'p.article_access_type', 'DATE_FORMAT(p.date_of_publish, "%d %b %Y") as published_date',
											  'p.relation_id', 'p.article_title', 'p.date_added', 'NOW() as date_current', 'p.total_favorites',
											  'DATE_FORMAT(p.date_added, "%d %b %Y") as added_date', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'p.rating_count',
											  'article_tags', 'article_status', 'TIMEDIFF(NOW(), last_view_date) as article_last_view_date', 'total_comments',
											  'article_attachment', 'total_downloads','mc.article_category_name'));
				$additional_query = '';
				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_summary', '').') AND ';
				$this->sql_condition = $additional_query.'f.user_id='.$this->CFG['user']['user_id'].' AND p.article_status=\'Ok\' AND (p.user_id = '.$this->CFG['user']['user_id'].
										' OR p.article_access_type = \'Public\''.$this->getAdditionalQuery('p.').')'.$this->advancedFilters();
				$this->sql_sort = 'article_favorite_id DESC';
				break;

			case 'publishedarticle':
				$this->setTableNames(array($this->CFG['db']['tbl']['article'].' AS a JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON a.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['article_category'].' AS mc ON mc.article_category_id =a.article_category_id'));
				$this->setReturnColumns(array('article_summary','article_caption', 'article_server_url', 'article_id', 'article_title', 'DATE_FORMAT(date_of_publish, "%d %b %Y") as published_date',
											  'a.date_added', 'NOW() as date_current', 'DATE_FORMAT(a.date_added, "%d %b %Y") as added_date', 'a.user_id',
											  '(rating_total/rating_count) as rating', 'rating_count', 'total_views', 'article_tags', 'article_status', 'article_admin_comments',
											  'TIMEDIFF(NOW(), last_view_date) as article_last_view_date', 'total_comments', 'total_favorites', 'article_attachment',
											  'total_downloads','mc.article_category_name'));
				$additional_query = '';
				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_summary', '').') AND ';

				$this->sql_condition = $additional_query.'a.user_id=\''.$this->CFG['user']['user_id'].'\' AND article_status=\'Ok\''.$this->advancedFilters();
				$this->sql_sort = 'article_id DESC';
				break;

			case 'toactivate':
				$this->setTableNames(array($this->CFG['db']['tbl']['article'].' AS a JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON a.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['article_category'].' AS mc ON mc.article_category_id =a.article_category_id'));
				$this->setReturnColumns(array('article_summary','article_caption', 'article_server_url', 'article_id', 'article_title', 'DATE_FORMAT(date_of_publish, "%d %b %Y") as published_date',
											  'a.date_added', 'NOW() as date_current', 'DATE_FORMAT(a.date_added, "%d %b %Y") as added_date', 'a.user_id',
											  '(rating_total/rating_count) as rating', 'rating_count', 'total_views', 'article_tags', 'article_status', 'total_favorites',
											  'TIMEDIFF(NOW(), last_view_date) as article_last_view_date', 'total_comments', 'article_attachment',
											  'total_downloads','mc.article_category_name'));
				$additional_query = '';
				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_summary', '').') AND ';
				$this->sql_condition = $additional_query.'a.user_id=\''.$this->CFG['user']['user_id'].'\' AND article_status=\'ToActivate\''.$this->advancedFilters();
				$this->sql_sort = 'article_id DESC';
				break;

			case 'notapproved':
				$this->setTableNames(array($this->CFG['db']['tbl']['article'].' AS a JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON a.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['article_category'].' AS mc ON mc.article_category_id =a.article_category_id'));
				$this->setReturnColumns(array('article_summary','article_caption', 'article_server_url', 'article_id', 'article_title', 'article_admin_comments', 'DATE_FORMAT(date_of_publish, "%d %b %Y") as published_date',
											  'a.date_added', 'NOW() as date_current', 'DATE_FORMAT(a.date_added, "%d %b %Y") as added_date', 'a.user_id',
											  '(rating_total/rating_count) as rating', 'rating_count', 'total_views', 'article_tags', 'article_status', 'total_favorites',
											  'TIMEDIFF(NOW(), last_view_date) as article_last_view_date', 'total_comments', 'article_attachment',
											  'total_downloads','mc.article_category_name'));

				$additional_query = '';
				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_summary', '').') AND ';
				$this->sql_condition = $additional_query.'a.user_id=\''.$this->CFG['user']['user_id'].'\' AND article_status=\'Not Approved\''.$this->advancedFilters();
				$this->sql_sort = 'article_id DESC';
				break;

			case 'draftarticle':
				$this->setTableNames(array($this->CFG['db']['tbl']['article'].' AS a JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON a.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['article_category'].' AS mc ON mc.article_category_id =a.article_category_id'));
				$this->setReturnColumns(array('article_summary','article_caption', 'article_server_url', 'article_id', 'article_title', 'DATE_FORMAT(date_of_publish, "%d %b %Y") as published_date',
											  'a.date_added', 'NOW() as date_current', 'DATE_FORMAT(a.date_added, "%d %b %Y") as added_date', 'a.user_id',
											  '(rating_total/rating_count) as rating', 'rating_count', 'total_views', 'article_tags', 'article_status', 'total_favorites',
											  'TIMEDIFF(NOW(), last_view_date) as article_last_view_date', 'total_comments', 'article_attachment',
											  'total_downloads','mc.article_category_name'));

				$additional_query = '';
				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_summary', '').') AND ';
				$this->sql_condition = $additional_query.'a.user_id=\''.$this->CFG['user']['user_id'].'\' AND article_status=\'Draft\''.$this->advancedFilters();
				$this->sql_sort = 'article_id DESC';
				break;

			case 'infuturearticle':
				$this->setTableNames(array($this->CFG['db']['tbl']['article'].' AS a JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON a.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['article_category'].' AS mc ON mc.article_category_id =a.article_category_id'));
				$this->setReturnColumns(array('article_summary','article_caption', 'article_server_url', 'article_id', 'article_title', 'DATE_FORMAT(date_of_publish, "%d %b %Y") as published_date',
											  'a.date_added', 'NOW() as date_current', 'DATE_FORMAT(a.date_added, "%d %b %Y") as added_date', 'a.user_id',
											  '(rating_total/rating_count) as rating', 'rating_count', 'total_views', 'article_tags', 'article_status', 'total_favorites',
											  'TIMEDIFF(NOW(), last_view_date) as article_last_view_date', 'total_comments', 'article_attachment',
											  'total_downloads','mc.article_category_name'));
				$additional_query = '';
				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_summary', '').') AND ';
				$this->sql_condition = $additional_query.'a.user_id=\''.$this->CFG['user']['user_id'].'\' AND article_status=\'InFuture\''.$this->advancedFilters();
				$this->sql_sort = 'article_id DESC';
				break;

			case 'articletoprated':
				$this->setTableNames(array($this->CFG['db']['tbl']['article'].' as p JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON p.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['article_category'].' AS mc ON mc.article_category_id =p.article_category_id'));
				$this->setReturnColumns(array('article_summary','article_caption', 'article_server_url', 'p.article_id','p.user_id', 'p.article_access_type', 'DATE_FORMAT(p.date_of_publish, "%d %b %Y") as published_date',
											  'p.relation_id', 'p.article_title', 'p.date_added', 'NOW() as date_current', 'p.total_favorites',
											  'DATE_FORMAT(p.date_added, "%d %b %Y") as added_date', 'p.total_views', '(p.rating_total/p.rating_count) as rating',
											  'article_tags', 'article_status', 'TIMEDIFF(NOW(), last_view_date) as article_last_view_date', 'total_comments', 'p.rating_count',
											  'article_attachment', 'total_downloads','mc.article_category_name'));

				$additional_query = '';
				if($this->fields_arr['cid'])
				{
					$additional_query .= '(p.article_category_id=\''.addslashes($this->fields_arr['cid']).'\') AND ';

					if($this->fields_arr['sid'])
						$additional_query .= '(p.article_sub_category_id=\''.addslashes($this->fields_arr['sid']).'\') AND ';
				}

				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_summary', '').') AND ';
				$this->sql_condition = $additional_query.'p.article_status=\'Ok\''.' AND u.usr_status=\'Ok\''.$this->getAdultQuery('p.', 'article').' AND ( ' . $this->myarticleCondition() . ' ) '.
										' AND p.rating_total>0 AND p.allow_ratings=\'Yes\''.$this->advancedFilters();
				$this->sql_sort = 'rating DESC';
				break;

			case 'articlemostviewed':
				$this->setTableNames(array($this->CFG['db']['tbl']['article_viewed'].' as vp LEFT JOIN '.$this->CFG['db']['tbl']['article'].' as p ON vp.article_id=p.article_id'.' JOIN '.$this->CFG['db']['tbl']['article_category'].' AS mc ON mc.article_category_id =p.article_category_id'.','.$this->CFG['db']['tbl']['users'] .' AS u '));
				$this->setReturnColumns(array('article_summary','article_caption', 'article_server_url', 'p.article_id','p.user_id', 'p.article_access_type', 'DATE_FORMAT(p.date_of_publish, "%d %b %Y") as published_date',
											  'p.relation_id', 'p.article_title', 'p.date_added', 'NOW() as date_current', 'p.total_favorites',
											  'DATE_FORMAT(p.date_added, "%d %b %Y") as added_date', 'p.total_views', '(p.rating_total/p.rating_count) as rating',
											  'article_tags', 'article_status', 'TIMEDIFF(NOW(), last_view_date) as article_last_view_date', 'total_comments', 'p.rating_count',
											  'article_attachment', 'total_downloads', 'SUM(vp.total_views) as sum_total_views',
											  'vp.total_views as individual_total_views','mc.article_category_name'));
				$this->sql_sort = 'sum_total_views DESC';

				$additional_query = '';
				if($this->fields_arr['cid'])
				{
					$additional_query .= '(p.article_category_id=\''.addslashes($this->fields_arr['cid']).'\') AND ';

					if($this->fields_arr['sid'])
						$additional_query .= '(p.article_sub_category_id=\''.addslashes($this->fields_arr['sid']).'\') AND ';
				}

				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_summary', '').') AND ';
				$this->sql_condition = $additional_query.'p.article_status=\'Ok\' AND p.total_views>0 AND u.usr_status=\'Ok\''.$this->getAdultQuery('p.', 'article').' AND ( ' . $this->myarticleCondition() . ' ) '.$this->getMostViewedExtraQuery().
										$this->advancedFilters().' GROUP BY vp.article_id';
				break;

			case 'articlemostdiscussed':
				$this->setTableNames(array($this->CFG['db']['tbl']['article_comments'].' as pc LEFT JOIN '.$this->CFG['db']['tbl']['article'].' as p ON pc.article_id=p.article_id'.' JOIN '.$this->CFG['db']['tbl']['article_category'].' AS mc ON mc.article_category_id =p.article_category_id'.','.$this->CFG['db']['tbl']['users'] .' AS u '));
				$this->setReturnColumns(array('article_summary','article_caption', 'article_server_url', 'p.article_id','p.user_id', 'p.article_access_type', 'DATE_FORMAT(p.date_of_publish, "%d %b %Y") as published_date',
											  'p.relation_id', 'p.article_title', 'p.date_added', 'NOW() as date_current', 'p.total_favorites',
											  'DATE_FORMAT(p.date_added, "%d %b %Y") as added_date', 'p.total_views', '(p.rating_total/p.rating_count) as rating',
											  'article_tags', 'article_status', 'TIMEDIFF(NOW(), last_view_date) as article_last_view_date', 'total_comments', 'p.rating_count',
											  'article_attachment', 'total_downloads', 'COUNT(pc.article_id) as sum_total_comments','mc.article_category_name'));

				$additional_query = '';
				if($this->fields_arr['cid'])
				{
					$additional_query .= '(p.article_category_id=\''.addslashes($this->fields_arr['cid']).'\') AND ';

					if($this->fields_arr['sid'])
						$additional_query .= '(p.article_sub_category_id=\''.addslashes($this->fields_arr['sid']).'\') AND ';
				}

				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_summary', '').') AND ';
				$this->sql_condition = $additional_query.'p.article_status=\'Ok\' AND pc.comment_status=\'Yes\' AND p.total_comments>0 AND u.usr_status=\'Ok\''.$this->getAdultQuery('p.', 'article').' AND ( ' . $this->myarticleCondition() . ' ) '.
										$this->advancedFilters().$this->getMostDiscussedExtraQuery().' GROUP BY pc.article_id';
				$this->sql_sort = 'sum_total_comments DESC, total_views DESC';
				break;

			case 'articlemostfavorite':
				$this->setTableNames(array($this->CFG['db']['tbl']['article_favorite'].' AS pf LEFT JOIN '.$this->CFG['db']['tbl']['article'].' AS p ON pf.article_id=p.article_id'.' JOIN '.$this->CFG['db']['tbl']['article_category'].' AS mc ON mc.article_category_id =p.article_category_id'.','.$this->CFG['db']['tbl']['users'] .' AS u '));
				$this->setReturnColumns(array('article_summary','article_caption', 'article_server_url', 'p.article_id','p.user_id', 'p.article_access_type', 'DATE_FORMAT(p.date_of_publish, "%d %b %Y") as published_date',
											  'p.relation_id', 'p.article_title', 'p.date_added', 'NOW() as date_current', 'p.total_favorites',
											  'DATE_FORMAT(p.date_added, "%d %b %Y") as added_date', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'p.rating_count',
											  'article_tags', 'article_status', 'TIMEDIFF(NOW(), last_view_date) as article_last_view_date', 'total_comments',
											  'article_attachment', 'total_downloads', 'COUNT(pf.article_id) as sum_total_favorites','mc.article_category_name'));

				$additional_query = '';
				if($this->fields_arr['cid'])
				{
					$additional_query .= '(p.article_category_id=\''.addslashes($this->fields_arr['cid']).'\') AND ';

					if($this->fields_arr['sid'])
						$additional_query .= '(p.article_sub_category_id=\''.addslashes($this->fields_arr['sid']).'\') AND ';
				}

				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_summary', '').') AND ';
				$this->sql_condition = $additional_query.'p.article_status=\'Ok\' AND p.total_favorites>0 AND u.usr_status=\'Ok\''.$this->getAdultQuery('p.', 'article').' AND ( ' . $this->myarticleCondition() . ' ) '.
										$this->getMostFavoriteExtraQuery().$this->advancedFilters().' GROUP BY pf.article_id';
				$this->sql_sort = 'sum_total_favorites DESC , total_views DESC';
				break;

			case 'userarticlelist':
				$this->setTableNames(array($this->CFG['db']['tbl']['article'].' as p JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON p.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['article_category'].' AS mc ON mc.article_category_id =p.article_category_id'));
				$this->setReturnColumns(array('article_summary','article_caption', 'article_server_url', 'p.article_id','p.user_id', 'p.article_access_type',
											  'p.relation_id', 'p.article_title', 'p.date_added', 'NOW() as date_current', 'DATE_FORMAT(p.date_of_publish, "%d %b %Y") as published_date',
											  'DATE_FORMAT(p.date_added, "%d %b %Y") as added_date', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'p.total_favorites',
											  'article_tags', 'article_status', 'TIMEDIFF(NOW(), last_view_date) as article_last_view_date', 'total_comments', 'p.rating_count',
											  'article_attachment', 'total_downloads','mc.article_category_name'));
				$additional_query = '';
				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'article_summary', '').') AND ';
				//$this->sql_condition = $additional_query.'p.user_id=\''.addslashes($this->fields_arr['user_id']).'\' AND p.article_status=\'Ok\' AND (p.user_id = '.$this->CFG['user']['user_id'].' OR p.article_access_type = \'Public\''.$this->getAdditionalQuery('p.').')'.$this->advancedFilters();
				$this->sql_condition = $additional_query.'p.user_id=\''.addslashes($this->fields_arr['user_id']).'\' AND u.usr_status=\'Ok\' AND p.article_status=\'Ok\''.$this->getAdultQuery('p.', 'article').$this->advancedFilters();
				$this->sql_sort = 'article_id DESC';
				break;

			default://articlenew
				$this->setTableNames(array($this->CFG['db']['tbl']['article'].' AS p JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON p.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['article_category'].' AS mc ON mc.article_category_id =p.article_category_id'));
				$this->setReturnColumns(array('article_summary','article_caption', 'article_server_url', 'p.article_id','p.user_id', 'p.article_access_type', 'DATE_FORMAT(p.date_of_publish, "%d %b %Y") as published_date',
											  'p.relation_id', 'p.article_title', 'p.date_added', 'NOW() as date_current', 'p.total_favorites',
											  'DATE_FORMAT(p.date_added, "%d %b %Y") as added_date', 'p.total_views', '(p.rating_total/p.rating_count) as rating', 'p.rating_count',
											  'article_tags', 'article_status', 'TIMEDIFF(NOW(), last_view_date) as article_last_view_date', 'total_comments',
											  'article_attachment', 'total_downloads','mc.article_category_name'));
				$additional_query = '';
				if($this->fields_arr['cid'])
				{
					$additional_query .= '(p.article_category_id=\''.addslashes($this->fields_arr['cid']).'\') AND ';

					if($this->fields_arr['sid'])
						$additional_query .= '(p.article_sub_category_id=\''.addslashes($this->fields_arr['sid']).'\') AND ';
				}
				if($this->fields_arr['tags'])
					$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.article_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.article_title', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.article_summary', '').') AND ';
					//$additional_query .= '('.getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.article_tags', 'OR').' article_title LIKE\'%'.addslashes($this->fields_arr['tags']).'%\') AND ';

				$this->sql_condition = $additional_query.'p.article_status=\'Ok\' AND u.usr_status=\'Ok\''.$this->getAdultQuery('p.', 'article').' AND ( ' . $this->myarticleCondition() . ' ) '.$this->advancedFilters();
				$this->sql_sort = 'p.date_added DESC';
				break;
		}
	}

	/**
	 * ArticleList::showArticleList()
	 *
	 * @return void
	 */
	public function showArticleList()
	{
		global $smartyObj;
		$showArticleList_arr = array();
		//for tags
		$showArticleList_arr['separator'] = ':&nbsp;';
		$tag = $this->_parse_tags(strtolower($this->fields_arr['tags']));
		$relatedTags = array();

		$articlesPerRow = $this->CFG['admin']['articles']['list_per_line_total_articles'];
		$count = 0;
		$found = false;

		$fields_list = array('user_name', 'first_name', 'last_name');
		$articleTags = array();
		$showArticleList_arr['row'] = array();
		$inc = 1;
		while($row = $this->fetchResultRecord())
	    {
			$need_profile_icon_arr = array('featuredarticlelist', 'articlenewmale', 'articlenewfemale');
			if(in_array($this->fields_arr['pg'], $need_profile_icon_arr))
			{
				$this->UserDetails[$row['user_id']]['first_name'] = $row['first_name'];
				$this->UserDetails[$row['user_id']]['last_name'] = $row['last_name'];
				$this->UserDetails[$row['user_id']]['user_name'] = $row['user_name'];

				if(!$this->getArticleDetails(array('article_summary','article_caption', 'article_server_url', 'article_id', 'TIMEDIFF(NOW(), date_added) as date_added', 'user_id', '(rating_total/rating_count) as rating', 'rating_count', 'total_views', 'article_title', 'article_status', 'TIMEDIFF(NOW(), last_view_date) as article_last_view_date'), $row['icon_id']))
					continue;
				$row = array_merge($row, $this->article_details);
			}

			if(($row['date_added'] != '') && ($row['date_current'] != ''))
			$row['date_added'] = $this->getDateTimeDiff($row['date_added'],$row['date_current']);

			$showArticleList_arr['row'][$inc]['individual_total_views'] = '';
			if(!isset($row['sum_total_views']))
	        $row['sum_total_views']='';
	        if(!isset($row['sum_total_comments']))
	        $row['sum_total_comments']='';
	        if(!isset($row['sum_total_favorites']))
	        $row['sum_total_favorites']='';
	        $showArticleList_arr['row'][$inc]['total_favorite']='';
	        $showArticleList_arr['row'][$inc]['sum_total_views'] = $row['sum_total_views'];
	        $showArticleList_arr['row'][$inc]['sum_total_comments'] = $row['sum_total_comments'];
	        $showArticleList_arr['row'][$inc]['sum_total_favorites'] = $row['sum_total_favorites'];
	        $showArticleList_arr['row'][$inc]['user_id'] = $row['user_id'];

			//To Display the number of days article added
			$row['date_added'] = ($row['date_added'] != '') ? getTimeDiffernceFormat($row['date_added']) : '';
			$row['article_last_view_date'] = ($row['article_last_view_date'] != '') ? getTimeDiffernceFormat($row['article_last_view_date']) : '';

			//To Display Article's Added Date in DD MMM YYYY (01 Jan 2009) Format
			$row['date_added'] = $row['added_date'];
			$row['date_published'] = $row['published_date'];
			$showArticleList_arr['row'][$inc]['record'] = $row;

			//if(!isset($this->UserDetails[$row['user_id']]))
			$this->UserDetails = getUserDetail('user_id', $row['user_id'], 'user_name');

			$showArticleList_arr['row'][$inc]['name'] = getUserDetail('user_id', $row['user_id'], 'user_name');
			$showArticleList_arr['row'][$inc]['view_article_link'] = getUrl('viewarticle', '?article_id='.$row['article_id'].'&amp;title='.$this->changeTitle($row['article_title']), $row['article_id'].'/'.$this->changeTitle($row['article_title']).'/', '', 'article');

			$view_article_page_arr = array('myarticles', 'userarticlelist');

			if($this->fields_arr['pg']=='abumarticlelist')
				$showArticleList_arr['row'][$inc]['view_article_link'] = getUrl('viewarticle', '?article_id='.$row['article_id'].'&amp;title='.$this->changeTitle($row['article_title']).'&amp;album_id='.$row['article_album_id'], $row['article_id'].'/'.$this->changeTitle($row['article_title']).'/?album_id='.$row['article_album_id'], '', 'article');
			else if(in_array($this->fields_arr['pg'], $view_article_page_arr))
				$showArticleList_arr['row'][$inc]['view_article_link'] = getUrl('viewarticle', '?article_id='.$row['article_id'].'&amp;title='.$this->changeTitle($row['article_title']), $row['article_id'].'/'.$this->changeTitle($row['article_title']).'/', '', 'article');

			$found = true;
			$showArticleList_arr['row'][$inc]['open_tr'] = false;
			if ($count%$articlesPerRow==0)
	    	{
				$showArticleList_arr['row'][$inc]['open_tr'] = false;
	    	}
			$showArticleList_arr['row'][$inc]['anchor'] = 'dAlt_'.$row['article_id'];

			if($row['article_status']=='Locked')
			{
				$showArticleList_arr['row'][$inc]['row_article_title_manual'] = $row['article_title'];
				//Commented previously - in HTML it is commented now
				$showArticleList_arr['row'][$inc]['row_article_caption_manual'] = $row['article_summary'];
			}
			else
			{
				//Condition to allow edit option only for the follwing pages specified in array
				//$editOptionPagesArray = array('myarticles', 'toactivate', 'notapproved', 'draftarticle',  'infuturearticle', 'publishedarticle', 'articlenew', 'articlerecent', 'articletoprated', 'articlemostviewed', 'articlemostdiscussed', 'articlemostfavorite', 'userarticlelist');
				//if(in_array($this->fields_arr['pg'], $editOptionPagesArray))
				//{
					$showArticleList_arr['row'][$inc]['article_ids_checked'] = '';
					if((is_array($this->fields_arr['article_ids'])) && (in_array($row['article_id'], $this->fields_arr['article_ids'])))
					  	$showArticleList_arr['row'][$inc]['article_ids_checked'] = "checked";
			        	$showArticleList_arr['row'][$inc]['article_writing_url_ok'] = getUrl('articlewriting', '?article_id='.$row['article_id'], $row['article_id'].'/', '', 'article');

				//}

				$search_word= '';
				if($this->fields_arr['article_title']!='' && $this->fields_arr['article_title']!=$this->LANG['articlelist_title_field'])
					$search_word=$this->fields_arr['article_title'];
				elseif($this->fields_arr['tags']!='' && $this->fields_arr['tags']!=$this->LANG['articlelist_search_article_tags'])
					$search_word=$this->fields_arr['tags'];

				$showArticleList_arr['row'][$inc]['row_article_title_manual'] = highlightWords($row['article_title'], $search_word);
				//Added below line to display article title in anchot tag to fix displayin html charactes while highlight search word
				$showArticleList_arr['row'][$inc]['row_article_title'] = $row['article_title'];
				//Commented previously - in HTML it is commented now
				$showArticleList_arr['row'][$inc]['row_article_caption_manual'] = highlightWords(strip_tags($row['article_summary']), $search_word);

				$showArticleList_arr['row'][$inc]['row_article_category_name_manual'] = $row['article_category_name'];
				$showArticleList_arr['row'][$inc]['userDetails'] = $this->UserDetails;
				$showArticleList_arr['row'][$inc]['member_profile_url'] = getMemberProfileUrl($row['user_id'], $this->UserDetails);
				$showArticleList_arr['row'][$inc]['member_image'] = getMemberAvatarDetails($row['user_id']);

				$tags= $this->_parse_tags($row['article_tags']);
				$showArticleList_arr['row'][$inc]['tags'] = $tags;

				if ($tags)
			    {
			    	$showArticleList_arr['row'][$inc]['tags_arr'] = array();
			        $i = 0;
					foreach($tags as $key=>$value)
					{
						if($this->CFG['admin']['articles']['tags_count_list_page']==$i)
							break;
						$value = strtolower($value);

						if (!in_array($value, $tag) AND !in_array($value, $relatedTags))
							$relatedTags[] = $value;

						if (!in_array($value, $articleTags))
					        $articleTags[] = $value;

						$showArticleList_arr['row'][$inc]['tags_arr'][$i]['url'] = getUrl('articlelist', '?pg=articlenew&amp;tags='.$value, 'articlenew/?tags='.$value, '', 'article');
						$showArticleList_arr['row'][$inc]['tags_arr'][$i]['value'] = highlightWords($value, $search_word);
						$i++;
					}
				 }
			}
			$count++;
			$showArticleList_arr['row'][$inc]['end_tr'] = false;
			if ($count%$articlesPerRow==0)
		    {
				$count = 0;
				$showArticleList_arr['row'][$inc]['end_tr'] = true;
	    	}
		    $inc++;
		}// end while

		$showArticleList_arr['extra_td_tr'] = '';
		if ($found and $count and $count<$articlesPerRow)
	    {
	    	$colspan = $articlesPerRow-$count;
			$showArticleList_arr['extra_td_tr'] = '<td colspan="'.$colspan.'">&nbsp;</td></tr>';
	    }
		if($this->fields_arr['tags'])
			$this->updateArticleTagDetails($articleTags);

		$smartyObj->assign('showArticleList_arr', $showArticleList_arr);
	}

	/**
	 * ArticleList::myarticleCondition()
	 *
	 * @param void
	 * @return string
	 */
	public function myarticleCondition()
	{
		if($this->fields_arr['user_id'] != '0')
			$userCondition = ' p.user_id = '.$this->fields_arr['user_id'].' ';
		else
			$userCondition = 'p.user_id = '.  $this->CFG['user']['user_id'] . ' OR p.article_access_type = \'Public\'' . $this->getAdditionalQuery('p.');
		return $userCondition;
	}

	/**
	 * ArticleList::updateArticleTagDetails()
	 *
	 * @param array $articleTags
	 * @return void
	 */
	public function updateArticleTagDetails($articleTags = array())
	{
		$tags = $this->fields_arr['tags'];
		$tags = trim($tags);
		$tags = $this->_parse_tags($tags);
		$match = array_intersect($tags, $articleTags);
		$match = array_unique($match);
		if (empty($match))
	        return;
		if (count($match)==1)
	     	$this->updateSearchCountAndResultForArticleTag($match[0]);
		else
		{
			for($i=0; $i<count($match); $i++)
			{
				$tag = $match[$i];
				$this->updateSearchCountForArticleTag($tag);
			}
		}
	}

	/**
	 * ArticleList::updateSearchCountForArticleTag()
	 *
	 * @param string $tag
	 * @return void
	 */
	public function updateSearchCountForArticleTag($tag='')
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['article_tags'].
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
			$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['article_tags'].
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
	 * ArticleList::updateSearchCountAndResultForArticleTag()
	 *
	 * @param string $tag
	 * @return void
	 */
	public function updateSearchCountAndResultForArticleTag($tag='')
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['article_tags'].
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
			$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['article_tags'].
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
	 * ArticleList::getCategoryName()
	 *
	 * @return string
	 */
	public function getCategoryName()
	{
		if ($this->fields_arr['sid'])
            $categoryId = $this->fields_arr['sid'];
        else
            $categoryId = $this->fields_arr['cid'];

		$sql = 'SELECT article_category_name FROM '.$this->CFG['db']['tbl']['article_category'].
				' WHERE article_category_id='.$this->dbObj->Param('article_category_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($categoryId));
		    if (!$rs)
			    trigger_db_error($this->dbObj);

		if($row = $rs->FetchRow())
			return $row['article_category_name'];
		return $this->LANG['unknown_category'];
	}

	/**
	 * ArticleList::getSubCategoryName()
	 *
	 * @return string
	 */
	public function getSubCategoryName()
	{
		$sql = 'SELECT article_category_name FROM '.$this->CFG['db']['tbl']['article_category'].
				' WHERE article_category_id='.$this->dbObj->Param('article_sub_category_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['sid']));
		    if (!$rs)
			    trigger_db_error($this->dbObj);

		if($row = $rs->FetchRow())
			return ' - '.$row['article_category_name'];
		return ' - '.$this->LANG['unknown_sub_category'];
	}

	/**
	 * ArticleList::getPageTitle()
	 *
	 * @return string
	 */
	public function getPageTitle()
	{
		$pg_title = $this->LANG['articlelist_title'];

		//If default value is Yes then reset the pg value as null.
	    if($this->getFormField('default')== 'Yes' && $this->fields_arr['pg'] == 'articlenew')
			$this->fields_arr['pg'] = '';

		$categoryTitle = '';
		$tagsTitle     = '';

		switch($this->fields_arr['pg'])
		{
			case 'myarticles':
				$pg_title = $this->LANG['myarticles_title'];
				break;

			case 'myfavoritearticles':
				$pg_title = $this->LANG['myfavoritearticles_title'];
				break;

			case 'toactivate':
				$pg_title = $this->LANG['mytoactivatearticles_title'];
				break;

			case 'notapproved':
				$pg_title = $this->LANG['mynotapprovedarticles_title'];
				break;

			case 'draftarticle':
				$pg_title = $this->LANG['mydraftarticles_title'];
				break;

			case 'infuturearticle':
				$pg_title = $this->LANG['myinfuturearticles_title'];
				break;

			case 'publishedarticle':
				$pg_title = $this->LANG['mypublishedarticles_title'];
				break;

			case 'articletoprated':
				$pg_title = $this->LANG['articletoprated_title'];
				break;

			case 'articlemostviewed':
				//$action_title = $this->getActionTitle(true);
				//$pg_title = $action_title.' '.$this->LANG['articlemostviewed_title'];
				$pg_title = $this->LANG['articlemostviewed_title'];
				break;

			case 'articlemostdiscussed':
				//$action_title = $this->getActionTitle(true);
				//$pg_title = $action_title.' '.$this->LANG['articlemostdiscussed_title'];
				$pg_title = $this->LANG['articlemostdiscussed_title'];
				break;

			case 'articlemostfavorite':
				//$action_title = $this->getActionTitle(true);
				//$pg_title = $action_title.' '.$this->LANG['articlemostfavorite_title'];
				$pg_title = $this->LANG['articlemostfavorite_title'];
				break;

			case 'userarticlelist':
                $pg_title = $this->LANG['articlelist_userarticlelist_title'];
                $fields_list = array('user_name', 'first_name', 'last_name');
                if (!isset($this->UserDetails[$this->fields_arr['user_id']]))
                    getUserDetail('user_id', $this->fields_arr['user_id'], 'user_name');
                $name = getUserDetail('user_id', $this->fields_arr['user_id'], 'user_name');
                $pg_title = str_replace('{user_name}', $name, $pg_title);
                $pg_title .= ' '.$this->LANG['articlelist_userarticlelist_article_title'];
                break;

			default://articlenew

				if ($this->fields_arr['pg'] == 'articlerecent')
					$pg_title = $this->LANG['articlerecent_title'];
				else
					$pg_title = $this->LANG['articlenew_title'];
				break;
		}


		//change the page title if other user article is selected
		if($this->fields_arr['pg'] != 'userarticlelist' && $this->fields_arr['user_id'] != 0)
		{
			  $members_title = $this->LANG['articlelist_userarticlelist_title'];
	          $fields_list = array('user_name', 'first_name', 'last_name');
	          if (!isset($this->UserDetails[$this->fields_arr['user_id']]))
	            getUserDetail('user_id', $this->fields_arr['user_id'], 'user_name');
	          $name = getUserDetail('user_id', $this->fields_arr['user_id'], 'user_name');
		      $members_title = str_replace('{user_name}', $name, $members_title);
	          if($this->fields_arr['pg'] == 'articlenew' || $this->fields_arr['pg'] == '')
	          	$pg_title = $members_title.' '.$this->LANG['articlelist_userarticlelist_article_title'];
	          else
	          	$pg_title = $members_title.' '.$pg_title;
			  	//$pg_title = $pg_title.' '.$this->LANG['in'].' '.$members_title;
	    }


		//change the page title if correspnding category or subcategory selected with dropdown list of options
		if ($this->fields_arr['cid'] || $this->fields_arr['sid'] )
		{
	        $categoryTitle = $this->LANG['articlelist_categoryarticle_title'];
	        $name = $this->getCategoryName();
	        /*if (!$this->category_name)
	            $name = $this->getCategoryName();
	        else
	            $name = $this->category_name;*/
	        $categoryTitle = str_replace('{category_name}', $name, $categoryTitle);
	    }
		if(($this->fields_arr['pg'] || $this->getFormField('default')== 'Yes') && ($this->fields_arr['cid'] || $this->fields_arr['sid']))
		{
			if($this->fields_arr['pg'] == '' && $this->fields_arr['cid'] == '')
				$pg_title = $categoryTitle;
			else
				$pg_title = $pg_title.' '.$this->LANG['in'].' '.$categoryTitle;
		}

		if ($this->fields_arr['tags'])
		{
	        $tagsTitle = $this->LANG['articlelist_tagsarticle_title'];
	        $name = $this->fields_arr['tags'];
	        $tagsTitle = str_replace('{tags_name}', $name, $tagsTitle);
	    }
		if(($this->fields_arr['pg'] || $this->getFormField('default')== 'Yes')&& $this->fields_arr['tags'])
		{
			if($this->fields_arr['pg'] == '')
				$pg_title = $tagsTitle;
			else
				$pg_title = $pg_title.' '.$tagsTitle;
		}

		return $pg_title;
	}


	/**
	 * ArticleList::getActionTitle()
	 *
	 * @return string
	 */
	public function getActionTitle($pg = false)
	{
		$action_title = $this->LANG['articlelist_title'];

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

			default://articlenew
				$action_title = $this->LANG['common_all_time'];
				break;
		}
		if($pg && $this->fields_arr['action']) $action_title .= $this->LANG['common_noun'];
		return $action_title;
	}


	/**
	 * ArticleList::deleteAttachments()
	 *
	 * @param array $articles_arr
	 * @return void
	 */
	public function deleteAttachments($articles_arr)
	{
		if(isLoggedIn())
		{
			foreach($articles_arr as $article_id)
			{
				$dir = '../../'.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['articles']['folder'].'/'.$article_id.'/';
				$sql = 'SELECT file_name FROM '.$this->CFG['db']['tbl']['article_attachments'].' '.
				'WHERE article_id='.$this->dbObj->Param('attachment_article_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($article_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				while($row = $rs->FetchRow())
				{
					unlink($dir.$row['file_name']);
				}
				if($rs->FetchRow())
					rmdir($dir);
			}
			$this->deleteArticles($articles_arr, $this->CFG['user']['user_id']);
			return true;
		}
		else
		{
			return false;
		}
	}


	/**
	 * ArticleList::showCategory()
	 *
	 * @return void
	 */
	public function populateSubCategories()
	{
		global $smartyObj;
		$populateSubCategories_arr = array();

		$sql = 'SELECT article_category_id, article_category_name, article_category_description '.
				'FROM '.$this->CFG['db']['tbl']['article_category'].' '.
				'WHERE article_category_status = \'Yes\' '.
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

			$populateSubCategories_arr['row'][$inc]['article_list_url'] = getUrl('articlelist', '?pg=articlenew&amp;'.$this->fields_arr['pg'].'&cid='.$this->fields_arr['cid'].'&sid='.$row['article_category_id'], $this->fields_arr['pg'].'articlenew/?cid='.$this->fields_arr['cid'].'&sid='.$row['article_category_id'], '', 'article');
			$populateSubCategories_arr['row'][$inc]['article_category_name_manual'] = nl2br(stripslashes($row['article_category_name']));


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

	public function populateMoreArticleLinks()
	{
		global $smartyObj;
		$populateMoreArticleLinks_arr = array();

		$populateMoreArticleLinks_arr['articlenew'] = $this->LANG['header_nav_article_article_new'];
		$populateMoreArticleLinks_arr['articlerandom'] = $this->LANG['header_nav_article_article_random'];
		$populateMoreArticleLinks_arr['articletoprated'] = $this->LANG['header_nav_article_top_rated'];
		$populateMoreArticleLinks_arr['articlerecommended'] = $this->LANG['header_nav_article_most_recommended'];
		$populateMoreArticleLinks_arr['articlemostviewed'] = $this->LANG['header_nav_article_most_viewed'];

		$smartyObj->assign('populateMoreArticleLinks_arr', $populateMoreArticleLinks_arr);

	}

	public function populateRatingDetails($rating)
	{
		$rating = round($rating,0);
		return $rating;
	}

	/**
	 * ArticleList::chkAdvanceResultFound()
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
//<<<<<-------------- Class ArticleUpload begins ---------------//
//-------------------- Code begins -------------->>>>>//
$ArticleList = new ArticleList();

if(!chkAllowedModule(array('article')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$ArticleList->setPageBlockNames(array('my_articles_form', 'delete_confirm_form', 'form_show_sub_category'));
//default form fields and values...
$ArticleList->setFormField('article_id', '');
$ArticleList->setFormField('album_id', '');
$ArticleList->setFormField('article_title', '');
$ArticleList->setFormField('article_tags', '');
$ArticleList->setFormField('article_ext', '');
$ArticleList->setFormField('action', '');
$ArticleList->setFormField('action_new', '');
$ArticleList->setFormField('act', '');
$ArticleList->setFormField('pg', '');
$ArticleList->setFormField('cid', '');
$ArticleList->setFormField('sid', '');
$ArticleList->setFormField('tags', '');
$ArticleList->setFormField('user_id', '0');
$ArticleList->setFormField('default', 'Yes');
$ArticleList->setFormField('article_keyword', '');
$ArticleList->setFormField('article_owner', '');
$ArticleList->setFormField('advanceFromSubmission', '');
$ArticleList->setFormField('msg', '');
/*********** Page Navigation Start *********/
$ArticleList->setFormField('start', '0');
$ArticleList->setFormField('slno', '1');
$ArticleList->setFormField('article_ids', array());
$ArticleList->setFormField('numpg', $CFG['article_tbl']['numpg']);


$ArticleList->setMinRecordSelectLimit($CFG['data_tbl']['min_record_select_limit']);
$ArticleList->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$ArticleList->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$ArticleList->setTableNames(array());
$ArticleList->setReturnColumns(array());
$ArticleList->sanitizeFormInputs($_REQUEST);
/************ page Navigation stop *************/
$ArticleList->setAllPageBlocksHide();
$ArticleList->populateMoreArticleLinks();

if($ArticleList->getFormField('cid') && !$ArticleList->getFormField('sid') && $CFG['admin']['articles']['sub_category'])
{
	$ArticleList->setPageBlockShow('form_show_sub_category');
}
$ArticleList->setPageBlockShow('my_articles_form');

//Reset the search form field values
if($ArticleList->isFormPOSTed($_POST, 'avd_reset'))
{
	$ArticleList->setFormField('article_keyword', '');
	$ArticleList->setFormField('article_owner', '');
	$ArticleList->setFormField('tags', '');
}
if(isset($_REQUEST['action']))
	$ArticleList->setFormField('action_new', $_REQUEST['action']);
$action_new = $ArticleList->getFormField('action_new');
$ArticleList->setFormField('action', $action_new);
$ArticleList->setFormField('article_owner', $ArticleList->getFormField('article_owner'));
$ArticleList->setFormField('article_keyword', $ArticleList->getFormField('article_keyword'));
if($ArticleList->getFormField('tags') && !isset($_POST['avd_search']))
{
	$ArticleList->setFormField('article_keyword', $ArticleList->getFormField('tags'));
}
elseif(isset($_POST['avd_search']) && $ArticleList->getFormField('article_keyword')!=$LANG['articlelist_keyword_field'])
{
	$ArticleList->setFormField('tags', $ArticleList->getFormField('article_keyword'));
}
elseif(isset($_POST['avd_search']) && $ArticleList->getFormField('article_keyword')==$LANG['articlelist_keyword_field'])
{
	$ArticleList->setFormField('tags', '');
}

if($ArticleList->getFormField('pg')=='invalid_article_id')
{
	$ArticleList->setCommonSuccessMsg($LANG['common_msg_invalid_article_id']);
	$ArticleList->setPageBlockShow('block_msg_form_success');
}

$pgValue = $ArticleList->getFormField('pg');
$pgValue = !empty($pgValue)?$pgValue:'articlenew';
//Filter option for Article most viewed, most disucssed and most favorited based on action set
$articleActionNavigation_arr['article_list_url_0'] = getUrl('articlelist', '?pg='.$pgValue.'&action=0'.'&cid='.$ArticleList->getFormField('cid').'&sid='.$ArticleList->getFormField('sid'), $pgValue.'/?action=0'.'&cid='.$ArticleList->getFormField('cid').'&sid='.$ArticleList->getFormField('sid'), '', 'article');
$articleActionNavigation_arr['article_list_url_1'] = getUrl('articlelist', '?pg='.$pgValue.'&action=1'.'&cid='.$ArticleList->getFormField('cid').'&sid='.$ArticleList->getFormField('sid'), $pgValue.'/?action=1'.'&cid='.$ArticleList->getFormField('cid').'&sid='.$ArticleList->getFormField('sid'), '', 'article');
$articleActionNavigation_arr['article_list_url_2'] = getUrl('articlelist', '?pg='.$pgValue.'&action=2'.'&cid='.$ArticleList->getFormField('cid').'&sid='.$ArticleList->getFormField('sid'), $pgValue.'/?action=2'.'&cid='.$ArticleList->getFormField('cid').'&sid='.$ArticleList->getFormField('sid'), '', 'article');
$articleActionNavigation_arr['article_list_url_3'] = getUrl('articlelist', '?pg='.$pgValue.'&action=3'.'&cid='.$ArticleList->getFormField('cid').'&sid='.$ArticleList->getFormField('sid'), $pgValue.'/?action=3'.'&cid='.$ArticleList->getFormField('cid').'&sid='.$ArticleList->getFormField('sid'), '', 'article');
$articleActionNavigation_arr['article_list_url_4'] = getUrl('articlelist', '?pg='.$pgValue.'&action=4'.'&cid='.$ArticleList->getFormField('cid').'&sid='.$ArticleList->getFormField('sid'), $pgValue.'/?action=4'.'&cid='.$ArticleList->getFormField('cid').'&sid='.$ArticleList->getFormField('sid'), '', 'article');
$articleActionNavigation_arr['article_list_url_5'] = getUrl('articlelist', '?pg='.$pgValue.'&action=5'.'&cid='.$ArticleList->getFormField('cid').'&sid='.$ArticleList->getFormField('sid'), $pgValue.'/?action=5'.'&cid='.$ArticleList->getFormField('cid').'&sid='.$ArticleList->getFormField('sid'), '', 'article');
$articleActionNavigation_arr['article_list_url_6'] = getUrl('articlelist', '?pg='.$pgValue.'&action=6'.'&cid='.$ArticleList->getFormField('cid').'&sid='.$ArticleList->getFormField('sid'), $pgValue.'/?action=6'.'&cid='.$ArticleList->getFormField('cid').'&sid='.$ArticleList->getFormField('sid'), '', 'article');
$articleActionNavigation_arr['articleMostViewed_0'] = $articleActionNavigation_arr['articleMostViewed_1'] =
	$articleActionNavigation_arr['articleMostViewed_2'] = $articleActionNavigation_arr['articleMostViewed_3'] =
		$articleActionNavigation_arr['articleMostViewed_4'] = $articleActionNavigation_arr['articleMostViewed_5'] =
			$articleActionNavigation_arr['articleMostViewed_6'] = '';
if($ArticleList->getFormField('pg') == 'articlemostviewed'
	OR $ArticleList->getFormField('pg') == 'articlemostdiscussed'
		OR $ArticleList->getFormField('pg') == 'articlemostfavorite')
	{
		if(!$ArticleList->getFormField('action')) $ArticleList->setFormField('action', '0');
		$sub_page = 'articleMostViewed_'.$ArticleList->getFormField('action');
		$articleActionNavigation_arr[$sub_page] = ' class="clsActive"';
	}

$smartyObj->assign('articleActionNavigation_arr', $articleActionNavigation_arr);
$start = $ArticleList->getFormField('start');

if($ArticleList->isFormPOSTed($_POST, 'yes'))
{
	if($ArticleList->getFormField('act')=='delete')
	{
		$articles_arr = explode(',',$ArticleList->getFormField('article_id'));
		if($ArticleList->deleteAttachments($articles_arr))
		{
			$ArticleList->setCommonSuccessMsg($LANG['articlelist_delete_success_msg_confirmation']);
			$ArticleList->setPageBlockShow('block_msg_form_success');
		}
		else
		{
			$ArticleList->setCommonErrorMsg($LANG['articlelist_delete_err_msg']);
			$ArticleList->setPageBlockShow('block_msg_form_error');
		}
	}
	if($ArticleList->getFormField('act')=='set_featured')
	{
		$ArticleList->setFeatureThisImage($ArticleList->getFormField('article_id'), $CFG['user']['user_id']);
		$ArticleList->setPageBlockShow('block_msg_form_error');
		$ArticleList->setCommonErrorMsg($LANG['articlelist_msg_success_set_featured']);
	}
	if($ArticleList->getFormField('act')=='favorite_delete')
	{
		$article_id_arr = explode(',',$ArticleList->getFormField('article_id'));
		foreach($article_id_arr as $article_id)
		{
			$ArticleList->deleteFavoriteArticle($article_id, $CFG['user']['user_id']);
		}
	}
}

if ($ArticleList->isPageGETed($_GET, 'action'))
{
	$ArticleList->sanitizeFormInputs($_GET);
}

$ArticleList->LANG['articlelist_title'] = $ArticleList->getPageTitle();
//<<<<<-------------------- Code ends----------------------//
setPageTitle($ArticleList->LANG['articlelist_title']);
setMetaKeywords('Article List');
setMetaDescription('Article List');

$ArticleList->category_name = '';
if ($ArticleList->isShowPageBlock('form_show_sub_category'))
{
	$ArticleList->populateSubCategories();
	$ArticleList->category_name = $ArticleList->getCategoryName();
	$ArticleList->LANG['articlelist_category_title'] = str_replace('{category}', $ArticleList->category_name, $LANG['articlelist_category_title']);
}
if ($ArticleList->isShowPageBlock('my_articles_form'))
{
	/****** navigtion continue*********/
	$ArticleList->setTableAndColumns();
	$ArticleList->buildSelectQuery();
	$ArticleList->buildQuery();
	//$ArticleList->printQuery();
	$group_query_arr = array('articlemostviewed', 'articlemostdiscussed', 'articlemostfavorite');
	if(in_array($ArticleList->getFormField('pg'), $group_query_arr))
		$ArticleList->homeExecuteQuery();
	else
		$ArticleList->executeQuery();

	$ArticleList->anchor = 'anchor';
	if($CFG['feature']['rewrite_mode'] == 'htaccess')
		$paging_arr = array('start', 'cid', 'sid', 'tags', 'user_id', 'action', 'start', 'advanceFromSubmission');
	else
		$paging_arr = array('start', 'cid', 'sid', 'tags', 'user_id', 'pg', 'action', 'start', 'advanceFromSubmission');
	$smartyObj->assign('paging_arr',$paging_arr);
	if($ArticleList->isResultsFound())
	{
		if($CFG['feature']['rewrite_mode'] == 'htaccess')
			$paging_arr = array('start', 'cid', 'sid', 'tags', 'user_id', 'action', 'advanceFromSubmission');
		else
			$paging_arr = array('start', 'cid', 'sid', 'tags', 'user_id', 'pg', 'action', 'advanceFromSubmission');
		$smartyObj->assign('paging_arr',$paging_arr);
		$smartyObj->assign('smarty_paging_list', $ArticleList->populatePageLinksPOST($ArticleList->getFormField('start'), 'seachAdvancedFilter'));
		$ArticleList->my_articles_form['showArticleList'] = $ArticleList->showArticleList();
	}
	/******* Navigation End ********/
}

//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$ArticleList->includeHeader();
//include the content of the page
?>
<script type="text/javascript">
	var form_name_array = new Array('seachAdvancedFilter');
	var block_arr= new Array('selMsgConfirm', 'selMsgConfirmMulti', 'selEditarticleComments');
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
		//$Jq('#'+id).val('');
		if (($Jq('#'+id).val()=='<?php echo $LANG['articlelist_keyword_field']?>') && (id == 'article_keyword') )
			$Jq('#'+id).val('');
		else if (($Jq('#'+id).val()=='<?php echo $LANG['articlelist_article_created_by']?>') && (id == 'article_owner') )
			$Jq('#'+id).val('');
	}
	function setOldValue(id)
	{
		if (($Jq('#'+id).val()=="") && (id == 'article_owner') )
			$Jq('#'+id).val('<?php echo $LANG['articlelist_article_created_by']?>');
		if (($Jq('#'+id).val()=="") && (id == 'article_keyword') )
			$Jq('#'+id).val('<?php echo $LANG['articlelist_keyword_field']?>');
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
setTemplateFolder('general/', 'article');
$smartyObj->display('articleList.tpl');
$ArticleList->includeFooter();
?>