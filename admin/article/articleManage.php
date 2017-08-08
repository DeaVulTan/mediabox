<?php
/**
 * This file is to manage the articles
 *
 * This file is having articleManage class to manage the articles
 *
 *
 * @category	Rayzz
 * @package		Admin
 *
 **/
require_once('../../common/configs/config.inc.php');
$CFG['site']['is_module_page'] = 'article';
$CFG['lang']['include_files'][] = 'languages/%s/article/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/admin/articleManage.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/months_list_array.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ArticleHandler.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class articleManage begins -------------------->>>>>//
/**
 *
 * @category	rayzz
 * @package		Admin
 **/
class articleManage extends ArticleHandler
	{
		public $sql_condition = '';
		public $sql_sort = '';
		public $fields_arr = '';
		public $sql='';
		public $article_category_name = array();

		/**
		 * articleManage::buildConditionQuery()
		 *
		 * @return void
		 **/
		public function buildConditionQuery()
			{
				$this->sql_condition = '';
			}

		/**
		 * articleManage::buildSortQuery()
		 *
		 * @return void
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = 'v.article_id DESC';
			}

		/**
		 * articleManage::getArticleCategory()
		 *
		 * @param integer $article_category_id
		 * @return array
		 */
		public function getArticleCategory($article_category_id)
			{
				if(isset($this->article_category_name[$article_category_id]))
					return $this->article_category_name[$article_category_id];

				if($article_category_id == 0)
					return;

				$this->article_category_name[$article_category_id] = '';

				$sql = 'SELECT article_category_name FROM '.$this->CFG['db']['tbl']['article_category'].
						' WHERE article_category_id='.$this->dbObj->Param('article_category_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($article_category_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->article_category_name[$article_category_id] = $row['article_category_name'];
					}
				return $this->article_category_name[$article_category_id];
			}


		/**
		 * articleManage::populateArticleCategory()
		 *
		 * @return void
		 */
		public function populateArticleCategory($srch_categories = false)
			{
				$populateArticleCategory = '';
				$sql = 'SELECT article_category_id, article_category_name FROM '.$this->CFG['db']['tbl']['article_category'].
						' WHERE parent_category_id=0 AND article_category_status=\'Yes\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$populateArticleCategory .= '<option value="'.$row['article_category_id'].'" class="selectArticleCategory"';

								if($srch_categories == $row['article_category_id'])
									$populateArticleCategory .= ' selected="selected"';

								$populateArticleCategory .= '>'.$row['article_category_name'].'</option>';
								/*if($this->CFG['admin']['articles']['sub_category'])
									{
										$populateArticleCategory .= $this->populateArticleSubCategory($row['article_category_id'], $srch_categories);
									}*/
							}
					}
				return $populateArticleCategory;
			}

		/**
		 * articleManage::populateArticleSubCategory()
		 *
		 * @return void
		 */
		public function populateArticleSubCategory($category_id, $srch_categories = false)
			{
				$populateArticleSubCategory = '';
				$sql = 'SELECT article_category_id, article_category_name FROM '.$this->CFG['db']['tbl']['article_category'].
						' WHERE parent_category_id='.$category_id.' AND article_category_status=\'Yes\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$populateArticleSubCategory .= '<option value="'.$row['article_category_id'].'" class="selectArticleSubCategory"';

								if($srch_categories == $row['article_category_id'])
									$populateArticleSubCategory .= ' selected="selected"';

								$populateArticleSubCategory .= '>'.$row['article_category_name'].'</option>';
							}
						return $populateArticleSubCategory;
					}
				return;
			}

		/**
		 * articleManage::displayArticleList()
		 * This method helps to display the list of articles
		 *
		 * @return void
		 **/
		public function displayarticleList()
			{
				global $smartyObj;
				$displayarticleList_arr = array();

				$fields_list = array('user_name', 'first_name', 'last_name');
				$articles_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['articles']['folder'].'/';
				$displayarticleList_arr['row'] = array();
				$inc = 1;
				while($row = $this->fetchResultRecord())
					{
						if(!isset($row['user_name']))
							{
								if(!isset($this->UserDetails[$row['user_id']]))
									getUserDetail('user_id', $row['user_id'], 'user_name');

								$displayarticleList_arr['row'][$inc]['name'] = getUserDetail('user_id', $row['user_id'], 'user_name');
							}
						else
							{
								$name = $this->CFG['format']['name'];
								$name = str_replace('$first_name', $row['first_name'],$name);
								$name = str_replace('$last_name', $row['last_name'],$name);
								$name = str_replace('$user_name', $row['user_name'],$name);
								$displayarticleList_arr['row'][$inc]['name'] = $name;
							}

						$row['flagged_status'] = $row['flagged_status']?$row['flagged_status']:'No';
						$row['featured'] = $row['featured']?$row['featured']:'No';
						$displayarticleList_arr['row'][$inc]['comments_text'] = str_replace('{total_comments}', $this->getTotalComments($row['article_id']), $this->LANG['article_comments']);

						$displayarticleList_arr['row'][$inc]['record'] = $row;
						$inc++;
					}

				$smartyObj->assign('displayarticleList_arr', $displayarticleList_arr);
			}

			/**
		 	* articleManage::getTotalComments()
		 	* @param string $article_id
		 	* @return int
		 	**/
			public function getTotalComments($article_id)
			{
				$sql = 'SELECT COUNT(article_comment_id) AS cnt FROM '.$this->CFG['db']['tbl']['article_comments'].
						' WHERE article_id='.$this->dbObj->Param('article_id');
	            $stmt = $this->dbObj->Prepare($sql);
	            $rs = $this->dbObj->Execute($stmt, array($article_id));
	                if (!$rs)
	            	    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
				    {
				        $row = $rs->FetchRow();
						$count = $row['cnt'];
				    }
				$count = number_format($count);
				return $count;
			}

		/**
		 * articleManage::getSearchCondition()
		 *
		 * @return string
		 */
		public function getSearchCondition()
		    {
				$search_condition = '';
				if ($this->fields_arr['srch_uname'])
					{
						$search_condition .= ' AND u.user_name LIKE \'%'.addslashes($this->fields_arr['srch_uname']).'%\'';
					}
				if ($this->fields_arr['srch_title'])
					{
						$search_condition .= ' AND v.article_title LIKE \'%'.addslashes($this->fields_arr['srch_title']).'%\'';
					}
				if ($this->fields_arr['srch_flag'] == 'No')
					{
						$search_condition .= ' AND v.flagged_status != \'Yes\'';
					}
				if ($this->fields_arr['srch_flag'] == 'Yes')
					{
						$search_condition .= ' AND v.flagged_status = \'Yes\'';
					}
				if ($this->fields_arr['srch_categories'])
					{
						$search_condition .= ' AND (v.article_category_id = \''.addslashes($this->fields_arr['srch_categories']).'\' OR v.article_sub_category_id = \''.addslashes($this->fields_arr['srch_categories']).'\')';
					}
				if ($this->fields_arr['srch_feature'])
					{
						$search_condition .= ' AND v.featured = \''.addslashes($this->fields_arr['srch_feature']).'\'';
					}
				if ($this->fields_arr['srch_date_added'])
					{
						$search_condition .= ' AND v.date_added >= \''.$this->getFormField('srch_date_added').' 00:00:00\'';
						$search_condition .= ' AND v.date_added <= DATE_ADD(\''.$this->getFormField('srch_date_added').' 00:00:00\', INTERVAL 1 DAY)';
					}
				return $search_condition;
		    }


		/**
		 * articleManage::switchCase()
		 * This function handles the switch case statement to extract the values according to the options selected by the admin in the
		 * drop down box.
		 * @param string $casename
		 * @param string $method
		 *
		 * @return void
		 **/
		public function switchCase($casename, $method)
			{
				$search_condition = $this->getSearchCondition();
				switch ($casename)
					{
						case 'articleListAll';
							$this->setTableNames(array($this->CFG['db']['tbl']['article'].' as v', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.featured', 't_width', 't_height', 'article_server_url','article_ext','flagged_status','v.article_id','v.user_id', 'v.article_title', 'DATE_FORMAT(v.date_added,\''.$this->CFG['format']['date'].'\') as date_added', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', '(rating_total/rating_count) as rating', 'article_category_id', 'article_sub_category_id'));

							$this->sql_condition = 'v.user_id=u.user_id AND v.article_status=\'Ok\'';
							$this->sql_condition .= $search_condition;
							$this->sql_sort = 'v.article_id DESC';
							break;

						case 'articleNew';
							$this->setTableNames(array($this->CFG['db']['tbl']['article'].' as v', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.featured', 't_width', 't_height', 'article_server_url','article_ext','flagged_status','v.article_id','v.user_id', 'v.article_title', 'DATE_FORMAT(v.date_added,\''.$this->CFG['format']['date'].'\') as date_added', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', '(rating_total/rating_count) as rating', 'article_category_id', 'article_sub_category_id'));

							$this->sql_condition = 'v.user_id=u.user_id AND v.article_status=\'Ok\'';
							$this->sql_condition .= $search_condition;
							$this->sql_sort = 'v.article_id DESC';
							break;

						case 'articleTopRated';
							$this->setTableNames(array($this->CFG['db']['tbl']['article'].' as v', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.featured', 't_width', 't_height', 'article_server_url','article_ext','flagged_status','v.article_id','v.user_id', 'v.article_title', 'DATE_FORMAT(v.date_added,\''.$this->CFG['format']['date'].'\') as date_added', '(v.rating_total/v.rating_count) as rating', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', 'article_category_id', 'article_sub_category_id'));

							$this->sql_condition = 'v.user_id=u.user_id AND v.article_status=\'Ok\' AND v.rating_total>0 AND v.allow_ratings=\'Yes\'';
							$this->sql_condition .= $search_condition;
							$this->sql_sort = 'rating DESC';
							break;

						case 'articleRecentlyViewed':
							$this->setTableNames(array($this->CFG['db']['tbl']['article'].' as v', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.featured', 't_width', 't_height', 'article_server_url','article_ext','flagged_status','v.article_id','v.user_id', 'v.article_title', 'DATE_FORMAT(v.date_added,\''.$this->CFG['format']['date'].'\') as date_added', '(v.rating_total/v.rating_count) as rating', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', 'v.last_view_date as max_view_date', 'article_category_id', 'article_sub_category_id'));

							$this->sql_condition = 'v.user_id=u.user_id AND v.article_status=\'Ok\'';
							$this->sql_condition .= $search_condition;
							$this->sql_sort = 'max_view_date DESC';
							break;

						case 'articleMostViewed';
						case 'articleMostViewed-1';
						case 'articleMostViewed-2';
						case 'articleMostViewed-3';
						case 'articleMostViewed-4';
						case 'articleMostViewed-5';
						case 'articleMostViewed-6';
							$this->setTableNames(array($this->CFG['db']['tbl']['article_viewed'].' as vv LEFT JOIN '.$this->CFG['db']['tbl']['article'].' as v ON vv.article_id=v.article_id', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.featured', 't_width', 't_height', 'article_server_url','article_ext','flagged_status','v.article_id','v.user_id', 'v.article_title', 'DATE_FORMAT(vv.view_date,\''.$this->CFG['format']['date'].'\') as date_added', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', '(rating_total/rating_count) as rating', 'article_category_id', 'article_sub_category_id'));

							$extra_query = '';
							if($casename == 'articleMostViewed-1' || $casename == 'articleMostViewed')
								{
									$extra_query = '';
								}
							if($casename == 'articleMostViewed-2')
								{
									$extra_query = ' AND DATE_FORMAT(vv.view_date,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
								}
							if($casename == 'articleMostViewed-3')
								{
									$extra_query = ' AND DATE_FORMAT(vv.view_date,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
								}
							if($casename == 'articleMostViewed-4')
								{
									$extra_query = ' AND DATE_FORMAT(vv.view_date,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
								}
							if($casename == 'articleMostViewed-5')
								{
									$extra_query = ' AND DATE_FORMAT(vv.view_date,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
								}
							if($casename == 'articleMostViewed-6')
								{
									$extra_query = ' AND DATE_FORMAT(vv.view_date,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
								}

							$this->sql_condition = 'v.user_id=u.user_id AND v.article_status=\'Ok\' AND v.total_views>0'.$extra_query;
							$this->sql_condition .= $search_condition;
							$this->sql_condition .= ' GROUP BY vv.article_id';
							$this->sql_sort = 'v.total_views DESC';
							break;

						case 'articleMostDiscussed';
						case 'articleMostDiscussed-1';
						case 'articleMostDiscussed-2';
						case 'articleMostDiscussed-3';
						case 'articleMostDiscussed-4';
						case 'articleMostDiscussed-5';
						case 'articleMostDiscussed-6';
							$this->setTableNames(array($this->CFG['db']['tbl']['article_comments'].' as vc LEFT JOIN '.$this->CFG['db']['tbl']['article'].' as v ON vc.article_id=v.article_id', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.featured', 't_width', 't_height', 'article_server_url','article_ext','flagged_status','article_title','v.article_id','v.user_id', 'DATE_FORMAT(vc.date_added,\''.$this->CFG['format']['date'].'\') as date_added', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', '(rating_total/rating_count) as rating', 'article_category_id', 'article_sub_category_id'));

							$extra_query = '';
							if($casename == 'articleMostDiscussed-1' || $casename == 'articleMostDiscussed')
								{
									$extra_query = '';
								}
							if($casename == 'articleMostDiscussed-2')
								{
									$extra_query = ' AND DATE_FORMAT(vc.date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
								}
							if($casename == 'articleMostDiscussed-3')
								{
									$extra_query = ' AND DATE_FORMAT(vc.date_added,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
								}
							if($casename == 'articleMostDiscussed-4')
								{
									$extra_query = ' AND DATE_FORMAT(vc.date_added,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
								}
							if($casename == 'articleMostDiscussed-5')
								{
									$extra_query = ' AND DATE_FORMAT(vc.date_added,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
								}
							if($casename == 'articleMostDiscussed-6')
								{
									$extra_query = ' AND DATE_FORMAT(vc.date_added,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
								}
							$this->sql_condition = 'v.user_id=u.user_id AND v.article_status=\'Ok\' AND v.total_comments>0'.$extra_query;
							$this->sql_condition .= $search_condition;
							$this->sql_condition .= ' GROUP BY vc.article_id';
							$this->sql_sort = 'v.total_comments';
							break;

						case 'articleTopFavorites';
						case 'articleTopFavorites-1';
						case 'articleTopFavorites-2';
						case 'articleTopFavorites-3';
						case 'articleTopFavorites-4';
						case 'articleTopFavorites-5';
						case 'articleTopFavorites-6';
							$this->setTableNames(array($this->CFG['db']['tbl']['article_favorite'].' as vf LEFT JOIN '.$this->CFG['db']['tbl']['article'].' as v ON vf.article_id=v.article_id', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.featured', 't_width', 't_height', 'article_server_url','article_ext','flagged_status','v.article_id','v.user_id', 'v.article_title', 'DATE_FORMAT(vf.date_added,\''.$this->CFG['format']['date'].'\') as date_added', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', '(rating_total/rating_count) as rating', 'article_category_id', 'article_sub_category_id'));

							$extra_query = '';
							if($casename == 'articleTopFavorites-1' || $casename == 'articleTopFavorites')
								{
									$extra_query = '';
								}
							if($casename == 'articleTopFavorites-2')
								{
									$extra_query = ' AND DATE_FORMAT(vf.date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
								}
							if($casename == 'articleTopFavorites-3')
								{
									$extra_query = ' AND DATE_FORMAT(vf.date_added,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
								}
							if($casename == 'articleTopFavorites-4')
								{
									$extra_query = ' AND DATE_FORMAT(vf.date_added,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
								}
							if($casename == 'articleTopFavorites-5')
								{
									$extra_query = ' AND DATE_FORMAT(vf.date_added,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
								}
							if($casename == 'articleTopFavorites-6')
								{
									$extra_query = ' AND DATE_FORMAT(vf.date_added,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
								}
						$this->sql_condition = 'v.user_id=u.user_id AND v.article_status=\'Ok\' AND v.total_favorites>0'.$extra_query;
						$this->sql_condition .= $search_condition;
						$this->sql_condition .= ' GROUP BY vf.article_id';
						$this->sql_sort = 'total_favorites DESC';
						break;
				}
			}

		/**
		 * articleManage::switchCase()
		 * This function is used to set the flag for the article.
		 *
		 * @return boolean
		 **/
		public function deleteArticle()
			{
				$article_details = explode(',', $this->fields_arr['checkbox']);
				if($this->fields_arr['action']=='Delete')
					{
						foreach($article_details as $article_key=>$article_value)
							{
								$article_arr = explode('-',$article_value);
								$article_id = $article_arr[0];
								$user_id = $article_arr[1];
								$this->deleteArticles(array($article_id), $user_id);
							}
					}
				else if($this->fields_arr['action']=='Flag')
					{
						foreach($article_details as $article_key=>$article_value)
							{
								$article_arr = explode('-',$article_value);
								$flag[] = $article_arr[0];
							}
						$article_list = implode(',',$flag);

						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['flagged_contents'].' WHERE'.
								' content_type=\'Article\' AND content_id IN('.$article_list.')';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
						    trigger_db_error($this->dbObj);

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].' SET flagged_status=\'Yes\''.
								' WHERE article_id IN('.$article_list.')';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
						    trigger_db_error($this->dbObj);

					}
				else if($this->fields_arr['action']=='UnFlag')
					{
						foreach($article_details as $article_key=>$article_value)
							{
								$article_arr = explode('-',$article_value);
								$flag[] = $article_arr[0];
							}
						$article_list = implode(',',$flag);

						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['flagged_contents'].' WHERE'.
								' content_type=\'Article\' AND content_id IN('.$article_list.')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
						    trigger_db_error($this->dbObj);

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].' SET flagged_status=\'No\''.
								' WHERE article_id IN('.$article_list.')';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
						    trigger_db_error($this->dbObj);
					}
				else if($this->fields_arr['action']=='Featured')
					{
						foreach($article_details as $article_key=>$article_value)
							{
								$article_arr = explode('-',$article_value);
								$flag[] = $article_arr[0];
							}
						$article_list = implode(',',$flag);

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].' SET featured=\'Yes\''.
								' WHERE article_id IN('.$article_list.')';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
						    trigger_db_error($this->dbObj);
					}
				else if($this->fields_arr['action']=='UnFeatured')
					{
						foreach($article_details as $article_key=>$article_value)
							{
								$article_arr = explode('-',$article_value);
								$flag[] = $article_arr[0];
							}
						$article_list = implode(',',$flag);

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].' SET featured=\'No\''.
								' WHERE article_id IN('.$article_list.')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
						    trigger_db_error($this->dbObj);
					}
				else if($this->fields_arr['action']=='Move')
					{
						foreach($article_details as $article_key=>$article_value)
							{
								$article_arr = explode('-',$article_value);
								$flag[] = $article_arr[0];
							}
						$article_list = implode(',',$flag);

						if($parent_id=$this->isParentExists($this->fields_arr['article_categories']))
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].' SET '.
										' article_category_id= \''.$parent_id.'\', '.
										' article_sub_category_id = \''.$this->fields_arr['article_categories'].'\' '.
										' WHERE article_id IN('.$article_list.')';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
								    trigger_db_error($this->dbObj);
							}
						else
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].' SET '.
										' article_sub_category_id=0, article_category_id='.$this->dbObj->Param('article_categories').
										' WHERE article_id IN('.$article_list.')';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_categories']));
								if (!$rs)
								    trigger_db_error($this->dbObj);
							}
					}
				return true;
			}

		/**
		 * articleManage::isParentExists()
		 *
		 * @param Integer $cid
		 * @return boolean
		 */
		public function isParentExists($cid)
			{
				$sql = 'SELECT parent_category_id FROM '.$this->CFG['db']['tbl']['article_category']. ' WHERE article_category_id =\''.$cid.'\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						return $row['parent_category_id'];
					}
				return false;
			}
	}
//<<<<<-------------- Class obj begins ---------------//
//-------------------- Code begins -------------->>>>>//
$obj = new articleManage();
$CFG['browsearticles'] = array('articleListAll'=>$LANG['nav_list_all_articles'],'articleNew'=>$LANG['nav_article_new'],'articleTopRated'=>$LANG['nav_top_rated'],'articleMostViewed'=>$LANG['nav_most_viewed'],'articleMostDiscussed'=>$LANG['nav_most_discussed'],'articleTopFavorites'=>$LANG['nav_most_favorite'],'articleRecentlyViewed'=>$LANG['nav_recently_viewed']);
$CFG['options'] = array('1'=>$LANG['all_time'],'2'=>$LANG['today'],'3'=>$LANG['yesterday'],'4'=>$LANG['this_week'],'5'=>$LANG['this_month'],'6'=>$LANG['this_year']);
$obj->setPageBlockNames(array('browse_articles', 'form_search', 'list_article_form', 'set_flag'));

//default form fields and values...
$obj->setReturnColumns(array());
$obj->setTableNames(array());
$obj->setFormField('list', '');
$obj->setFormField('article_id', '');
$obj->setFormField('submit', '');
$obj->setFormField('subcancel', '');

$obj->setFormField('action', '');
$obj->setFormField('delete', '');
$obj->setFormField('confirmdel', '');
$obj->setFormField('checkbox', array());

$obj->setFormField('srch_uname', '');
$obj->setFormField('srch_title', '');
$obj->setFormField('srch_flag', '');
$obj->setFormField('srch_feature', '');
$obj->setFormField('srch_date_added', '');
$obj->setFormField('srch_date', '');
$obj->setFormField('srch_month', '');
$obj->setFormField('srch_year', '');
$obj->setFormField('srch_categories', '');
$obj->setFormField('article_categories', '');
$obj->setMonthsListArr($LANG_LIST_ARR['months']);

$obj->setFormField('check_box', '');
$obj->setFormField('article_options', '');
/*********** Page Navigation Start *********/
$obj->setFormField('slno', '1');
//$obj->populateArticleCategory();
/************ page Navigation stop *************/
$obj->setAllPageBlocksHide();
$obj->setPageBlockShow('browse_articles');
/******************************************************/
$obj->setTableNames(array($obj->CFG['db']['tbl']['article'].' as v LEFT JOIN '.$obj->CFG['db']['tbl']['users'].' as u ON v.user_id=u.user_id AND u.usr_status=\'Ok\''));
$obj->setReturnColumns(array('v.article_id', 'article_server_url', 'v.user_id', 'v.article_title', 'DATE_FORMAT(v.date_added,\''.$obj->CFG['format']['date'].'\') as date_added', 'u.user_name', 'u.first_name', 'u.last_name', 'v.featured','v.flagged_status','v.article_status', 'article_category_id', 'v.total_comments', 'article_sub_category_id'));
$obj->sql_condition = 'v.article_status=\'Ok\'';
$obj->sql_sort = '';

$obj->left_navigation_div = 'articleMain';

//					$obj->setAllPageBlocksHide();
$obj->sanitizeFormInputs($_REQUEST);
$obj->setPageBlockShow('list_article_form');
$obj->setPageBlockShow('form_search');
/******************************************************/
if ($obj->getFormField('srch_date') || $obj->getFormField('srch_month') || $obj->getFormField('srch_year'))
	{
		$obj->chkIsCorrectDate($obj->getFormField('srch_date'), $obj->getFormField('srch_month'), $obj->getFormField('srch_year'), 'srch_date_added', $LANG['articleManage_err_tip_date_empty'], $LANG['articleManage_err_tip_date_invalid']);
    }
$srch_condition = $obj->getSearchCondition();
if ($srch_condition)
	$obj->sql_condition .= $srch_condition;

if($obj->isFormGETed($_POST,'submit'))
	{
		$casename = $_POST['list'];
		$obj->switchCase($casename, 'post');
	}

if($obj->isFormGETed($_POST,'search'))
	{
		$casename = $_POST['list'];
		$obj->switchCase($casename, 'post');
	}

if($obj->isFormGETed($_POST,'start'))
	{
		$casename = $_POST['list'];
		$obj->switchCase($casename, 'post');
	}

if($obj->isFormGETed($_GET,'list') && !$obj->isFormGETed($_GET,'action'))
	{
		$casename = $_GET['list'];
		$obj->switchCase($casename, 'get');
	}

if($obj->isFormGETed($_GET,'list') && $obj->isFormGETed($_GET,'action'))
	{
		$obj->setAllPageBlocksHide();
		$obj->setPageBlockShow('set_flag');
	}

if($obj->isFormGETed($_POST,'subcancel'))
	{
		$casename = $_POST['list'];
		$obj->switchCase($casename, 'post');
	}
if($obj->isFormGETed($_POST,'confirmdel'))
	{
		$casename = $_POST['list'];
		$obj->switchCase($casename, 'post');
		if($obj->deleteArticle())
			{
				$obj->setCommonSuccessMsg($LANG['articleManage_msg_success_delete']);
				$obj->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				$obj->setCommonErrorMsg($LANG['articleManage_msg_success_delete_fail']);
				$obj->setPageBlockShow('block_msg_form_error');
			}
	}
//<<<<<-------------------- Code ends----------------------//

$obj->hidden_arr = array('list', 'srch_uname', 'srch_categories', 'srch_title', 'srch_flag', 'srch_feature', 'srch_date', 'srch_month', 'srch_year', 'start');
$obj->current_year = date('Y');

if ($obj->isShowPageBlock('browse_articles'))
    {
    	$obj->browse_articles['list'] = '';
		foreach($CFG['browsearticles'] as $key=>$val)
			{
				if($key == $obj->getFormField('list'))
					{
						$selected = 'selected';
					}
				else
					{
						$selected = '';
					}

				$obj->browse_articles['list'] .= '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';

				if($key == 'articleMostViewed')
					{
						foreach($CFG['options'] as $optkey=>$optval)
							{
								if($key.'-'.$optkey == $obj->getFormField('list'))
									{
										$selected = 'selected';
									}
								else
									{
										$selected = '';
									}
								$obj->browse_articles['list'] .= '<option value="'.$key.'-'.$optkey.'" '.$selected.'>&nbsp;&nbsp;&nbsp;'.$optval.'</option>';
							}
					}
				if($key == 'articleMostDiscussed')
					{
						foreach($CFG['options'] as $optkey=>$optval)
							{
								if($key.'-'.$optkey == $obj->getFormField('list'))
									{
										$selected = 'selected';
									}
								else
									{
										$selected = '';
									}
								$obj->browse_articles['list'] .= '<option value="'.$key.'-'.$optkey.'" '.$selected.'>&nbsp;&nbsp;&nbsp;'.$optval.'</option>';
							}
					}
				if($key == 'articleTopFavorites')
					{
						foreach($CFG['options'] as $optkey=>$optval)
							{
								if($key.'-'.$optkey == $obj->getFormField('list'))
									{
										$selected = 'selected';
									}
								else
									{
										$selected = '';
									}
								$obj->browse_articles['list'] .= '<option value="'.$key.'-'.$optkey.'" '.$selected.'>&nbsp;&nbsp;&nbsp;'.$optval.'</option>';

							}
					}
			}
    }

if ($obj->isShowPageBlock('form_search'))
	{
		$obj->form_search['hidden_arr'] = array('list');
	}

if ($obj->isShowPageBlock('list_article_form'))
    {
		/****** navigtion continue*********/
		$obj->buildSelectQuery();
		$obj->buildQuery();
		//$obj->printQuery();
		if($obj->isGroupByQuery())
			$obj->homeExecuteQuery();
		else
			$obj->executeQuery();

		/******* Navigation End ********/
		if($obj->isResultsFound())
			{
				$obj->displayarticleList();
				$smartyObj->assign('smarty_paging_list', $obj->populatePageLinksPOST($obj->getFormField('start'), 'article_manage_form2'));
				$obj->list_article_form['hidden_arr'] = array('list', 'srch_uname', 'srch_categories', 'srch_title',  'srch_flag', 'srch_feature', 'srch_date', 'srch_month', 'srch_year', 'start');
			}
    }
//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$obj->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'article');
$smartyObj->display('articleManage.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script language="javascript" type="text/javascript" >
	var block_arr= new Array('selMsgConfirm');
	var replace_url = '<?php echo $CFG['site']['url'];?>login.php';
	var please_select_action = '<?php echo $LANG['articleManage_err_tip_select_action'];?>';
	var confirm_message = '';
	function getAction()
		{
			var act_value = document.article_manage_form2.article_options.value;
			if(act_value)
				{
					switch (act_value)
						{
							case 'Delete':
								confirm_message = '<?php echo $LANG['articleManage_delete'];?>';
								break;
							case 'Flag':
								confirm_message = '<?php echo $LANG['articleManage_status'];?>';
								break;
							case 'UnFlag':
								confirm_message = '<?php echo $LANG['articleManage_status'];?>';
								break;
							case 'Featured':
								confirm_message = '<?php echo $LANG['articleManage_featured'];?>';
								break;
							case 'UnFeatured':
								confirm_message = '<?php echo $LANG['articleManage_unfeatured'];?>';
								break;
						}
					$Jq('#confirmMessage').html(confirm_message);
					document.msgConfirmform.action.value = act_value;
					Confirmation('selMsgConfirm', 'msgConfirmform', Array('checkbox'), Array(multiCheckValue), Array('value'), -25, -290);
				}
			else
				alert_manual(please_select_action);
		}
	function popupWindow(url)
		{
			 window.open (url, "","status=0,toolbar=0,resizable=1,scrollbars=1");
			 return false;
		}
</script>
<?php
//<<<<<-------------------- Page block templates ends -------------------//
$obj->includeFooter();
?>