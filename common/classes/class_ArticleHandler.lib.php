<?php
/**
 * articleHandler
 *
 * @package Article
 * @author sathish_040at09
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @access public
 */
class ArticleHandler extends MediaHandler
{
	/**
	 * ArticleHandler::__construct()
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * ArticleHandler::populateArticleJsVars()
	 *
	 * @return void
	 */
	public function populateArticleJsVars()
	{
		echo '<script type="text/javascript">';
		echo 'var article_articles_file_url = "files/'.$this->CFG['admin']['articles']['folder'].'/'.$this->CFG['admin']['articles']['temp_folder'].'/";';
		echo '</script>';
	}

	/**
	 * ArticleHandler::chkIsAllowedLeftMenu()
	 *
	 * @return
	 */
	public function chkIsAllowedLeftMenu()
	{
		global $HeaderHandler;
		//$allowed_pages_array = array('index.php');
		$allowed_pages_array = array();
		$HeaderHandler->headerBlock['left_menu_display'] = displayBlock($allowed_pages_array, false, $append_default_pages=false);
		return $HeaderHandler->headerBlock['left_menu_display'];
	}

	/**
	 * ArticleHandler::populateMemberDetail()
	 * // IF THE FUNCTION RUN WE NEED TO INCLUDE class_RayzzHandler.lib.php FILE//
	 * @return
	 */
	public function populateMemberDetail($side_bar_option)
	{
		global $smartyObj;
		if($side_bar_option == 'article')
			$allowed_pages_array = array('viewArticle.php');

		if(displayBlock($allowed_pages_array))
			return;

		$this->_currentPage = strtolower($this->CFG['html']['current_script_name']);
		$this->_navigationArr['left_'.$this->_currentPage] = $this->_clsActiveLink;
		$pg = (isset($_REQUEST['pg']))?$_REQUEST['pg']:'';
		$block = (isset($_REQUEST['block']))?$_REQUEST['block']:'';
		if($block != '')
			{
				$page = $this->_currentPage.'_'.strtolower($block);
				$this->_navigationArr['left_'.$page] = $this->_clsActiveLink;
			}
		$flag = false;
		if($pg != '')
		{
			$flag = true;
			$this->_navigationArr['left_'.$this->_currentPage] = $this->_clsInActiveLink;
			$page = $this->_currentPage.'_'.strtolower($pg);
			$this->_navigationArr['left_'.$page] = $this->_clsActiveLink;
		}

		$populateMemberDetail_arr = array();
		$populateMemberDetail_arr['memberProfileUrl'] = getMemberProfileUrl($this->CFG['user']['user_id'], $this->CFG['user']['user_name']);
		$populateMemberDetail_arr['name'] = $this->CFG['user']['user_name'];
		$populateMemberDetail_arr['icon'] = getMemberAvatarDetails($this->CFG['user']['user_id']);

		//TOTAL article //
		$sql = 'SELECT COUNT( a.article_id ) AS total_article '.
			'FROM '.$this->CFG['db']['tbl']['article'].' AS a '.
			'WHERE article_status=\'Ok\' AND user_id = '.$this->dbObj->Param('user_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
		if (!$rs)
			trigger_db_error($this->dbObj);

		$result_set = $rs->FetchRow();
		$populateMemberDetail_arr['total_article'] = $result_set['total_article'];
		$smartyObj->assign('populateMemberDetail_arr', $populateMemberDetail_arr);
		$smartyObj->assign('opt', $side_bar_option);
		$smartyObj->assign('flag', $flag);
		$smartyObj->assign('cid', isset($_GET['cid'])?$_GET['cid']:'0');
		setTemplateFolder('general/', 'article');
		$smartyObj->display('populateMemberBlock.tpl');
	}

	/**
	 * ArticleHandler::getArticleNavClass()
	 *
	 * @param mixed $identifier
	 * @return boolean
	 */
	public function getArticleNavClass($identifier)
	{
		$identifier = strtolower($identifier);
		return isset($this->_navigationArr[$identifier])?$this->_navigationArr[$identifier]:$this->_clsInActiveLink;
	}

   /**
    * ArticleHandler::populateGenres()
    * //WE USE THIS FUNCTION INDEX, Article LIST
    * @return
    */
	 public function populateGenres()
	 {
		global $smartyObj;
		$populateGenres_arr = array();
		$populateGenres_arr['record_count'] = false;

		$allowed_pages_array = array('viewArticle.php');
		if(displayBlock($allowed_pages_array))
			return;

		//GENRES LIST priority vise or article_category_name//
		if($this->CFG['admin']['articles']['article_category_list_priority'])
			$short_by = 'priority';
		else
			$short_by = 'article_category_name';

		$addtional_condition = '';

		$sql = 'SELECT article_category_id, article_category_name FROM '.$this->CFG['db']['tbl']['article_category'].'  '.
				'WHERE '.$addtional_condition.' parent_category_id = \'0\' AND article_category_status = \'Yes\' ORDER BY '.$short_by.
				' ASC LIMIT 0, '.$this->CFG['admin']['articles']['sidebar_genres_num_record'];

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_db_error($this->dbObj);

		$populateGenres_arr['row'] = array();
		$inc = 0;
		While($genresDetail = $rs->FetchRow())
		{
			$populateGenres_arr['record_count'] = true;
			$populateGenres_arr['row'][$inc]['article_category_name'] = $genresDetail['article_category_name'];
			$populateGenres_arr['row'][$inc]['record'] 				  = $genresDetail;
			$populateGenres_arr['row'][$inc]['articleCount'] 		  = $this->articleCount($genresDetail['article_category_id']);
			$populateGenres_arr['row'][$inc]['populateSubGenres'] 	  = $this->populateSubGenres($genresDetail['article_category_id']);
			$populateGenres_arr['row'][$inc]['articlelist_url'] 		  = getUrl('articlelist', '?pg=articlenew&amp;cid='.$genresDetail['article_category_id'],
																		'articlenew/?cid='.$genresDetail['article_category_id'], '', 'article');
			$inc++;
		}
		$smartyObj->assign('moregenres_url', getUrl('articlecategory', '', '', '', 'article'));
		$smartyObj->assign('populateGenres_arr', $populateGenres_arr);
		$smartyObj->assign('cid', isset($_GET['cid'])?$_GET['cid']:'0');
		$smartyObj->assign('sid', isset($_GET['sid'])?$_GET['sid']:'0');
		setTemplateFolder('general/', 'article');
		$smartyObj->display('populateGenresBlock.tpl');
	 }

	/**
	 * articleHandler::populateSubGenres()
	 * //WE USE THIS FUNCTION INDEX, article LIST, PLAYLIST pages
	 * param $category_id
	 * @return
	 */
	 public function populateSubGenres($category_id)
	 {
		$populateSubGenres = array();
		$populateSubGenres['record_count'] = false;
		//SUBGENRES LIST priority vise or article_category_name//
		if($this->CFG['admin']['articles']['article_category_list_priority'])
			$short_by = 'priority';
		else
			$short_by = 'article_category_name';

		$sql  = 'SELECT article_category_id, article_category_name FROM '.$this->CFG['db']['tbl']['article_category'].'  '.
			    'WHERE parent_category_id = \''.$category_id.'\' AND article_category_status = \'Yes\' ORDER BY '.$short_by.
			    ' ASC LIMIT 0, '.$this->CFG['admin']['articles']['sidebar_genres_num_record'];

		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_db_error($this->dbObj);

		$populateSubGenres['row'] = array();
		$inc = 0;
		While($genresDetail = $rs->FetchRow())
			{
				$populateSubGenres['record_count'] = true;
				$populateSubGenres['row'][$inc]['article_category_name'] = $genresDetail['article_category_name'];
				$populateSubGenres['row'][$inc]['record'] 				 = $genresDetail;
				$populateSubGenres['row'][$inc]['articleCount'] 		 = $this->articleCount($genresDetail['article_category_id']);
				$populateSubGenres['row'][$inc]['articlelist_url'] 		 = getUrl('articlelist', '?pg=articlenew&amp;cid='.$category_id.'&amp;sid='.$genresDetail['article_category_id'], 'articlenew/?cid='.$category_id.'&amp;sid='.$genresDetail['article_category_id'], '', 'article');
				$inc++;
			}
		return $populateSubGenres;
	 }

	/**
	 * articleHandler::articleCount()
	 *
	 * @param integer $category
	 * @return $total
	 */
	public function articleCount($category=0)
	{
		if($category)
			$condition = 'AND ( article_category_id = '.$category.' OR article_sub_category_id = '.$category.')';

		$sql = 'SELECT count(article_id) as total FROM '.$this->CFG['db']['tbl']['article'].
				' WHERE article_status = \'Ok\' AND ( user_id = ' . $this->CFG['user']['user_id']. ' OR article_access_type = \'Public\' ) '.$condition;

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_db_error($this->dbObj);

		$row = $rs->FetchRow();
		return $row['total'];
	}

	/**
	 * ArticleHandler::changeArrayToCommaSeparator()
	 *
	 * @param array $arry_value
	 * @return string
	 */
	public function changeArrayToCommaSeparator($arry_value = array())
	{
		return implode(',',$arry_value);
	}

	/**
	 * ArticleHandler::chkFileNameIsNotEmpty()
	 *
	 * @param string $field_name
	 * @param string $err_tip
	 * @return boolean
	 */
	public function chkFileNameIsNotEmpty($field_name, $err_tip = '')
	{
		if(!(isset($_FILES) and $_FILES[$field_name]['name']))
		{
			if($this->CFG['admin']['articles']['article_attachment_compulsory'])
				$this->setFormFieldErrorTip($field_name,$err_tip);
			return false;
		}
		return true;
	}

	/**
	 * ArticleHandler::chkValideFileSize()
	 *
	 * @param string $field_name
	 * @param string $err_tip
	 * @return boolean
	 */
	public function chkValideFileSize($field_name, $err_tip='')
	{
		$max_size = $this->CFG['admin']['articles']['attachment_max_size'] * 1024;
		if ($_FILES[$field_name]['size'] > $max_size)
		{
			$this->fields_err_tip_arr[$field_name] = $err_tip;
			return false;
		}
		return true;
	}

	/**
	 * ArticleHandler::chkFileUploaded()
	 *
	 * @return boolean
	 */
	public function chkFileUploaded()
	{
		if(!(isset($_FILES) AND $_FILES['article_file']['name']))
			return false;

		return true;
	}

	/**
	 * ArticleHandler::getServerDetails()
	 *
	 * @return boolean
	 */
	public function getServerDetails()
	{
		$this->ARTICLE_CATEGORY_ID = isset($this->ARTICLE_CATEGORY_ID)?$this->ARTICLE_CATEGORY_ID:$this->fields_arr['article_category_id'];

		$cid = $this->ARTICLE_CATEGORY_ID.',0';

		$sql = 'SELECT server_url, ftp_server, ftp_usrename, ftp_password, ftp_folder, category'.
				' FROM '.$this->CFG['db']['tbl']['server_settings'].
				' WHERE server_for=\'Articles\' AND server_status=\'Yes\''.
				' AND category IN('.$cid.') LIMIT 0,1';


		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		if(!$rs->PO_RecordCount())
			return false;

		while($row = $rs->FetchRow())
		{
			$this->fields_arr['ftp_server'] = $row['ftp_server'];
			$this->fields_arr['ftp_usrename'] = $row['ftp_usrename'];
			$this->fields_arr['ftp_password'] = $row['ftp_password'];
			$this->fields_arr['server_url'] = $row['server_url'];
			$this->fields_arr['ftp_folder'] = $row['ftp_folder'];

			if($row['category']==$this->ARTICLE_CATEGORY_ID)
				return true;
		}
		if(isset($this->fields_arr['ftp_server']) and $this->fields_arr['ftp_server'])
			return true;
		return false;
	}

	/**
	 * ArticleHandler::deleteArticles()
	 *
	 * @return boolean
	 */
	public function deleteArticles($article_id_arr = array(), $user_id)
	{
		$article_id = implode(',',$article_id_arr);

		$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].' SET article_status=\'Deleted\''.
				' WHERE article_id IN('.$article_id.')';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
			    trigger_db_error($this->dbObj);

		if($affected_rows = $this->dbObj->Affected_Rows())
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET'.
						' total_articles=total_articles-'.$affected_rows.
						' WHERE user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));
				    if (!$rs)
					    trigger_db_error($this->dbObj);


				//*********Delete records from Article related tables start*****
				$tablename_arr = array('article_comments', 'article_favorite', 'article_viewed', 'article_rating');
				for($i=0;$i<sizeof($tablename_arr);$i++)
					{
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl'][$tablename_arr[$i]].
								' WHERE article_id IN('.$article_id.')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						    if (!$rs)
							    trigger_db_error($this->dbObj);
					}

				//DELETE FLAGGED CONTENTS
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['flagged_contents'].
						' WHERE content_type=\'Article\' AND content_id IN('.$article_id.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				//**********End************

				//activity tables.
				$action_key = array('article_uploaded', 'article_comment', 'article_rated', 'article_favorite', 'article_featured');
				for($inc=0;$inc<count($action_key);$inc++)
				{
					//$condition = '  content_id IN ('.$article_id.') AND action_key = \''.$action_key[$inc].'\'';
					$condition = '  SUBSTRING_INDEX(action_value, \'~\', 1 ) IN ('.$article_id.') AND action_key = \''.$action_key[$inc].'\'';

					$sql='SELECT parent_id FROM '.$this->CFG['db']['tbl']['article_activity'].' WHERE '.$condition;
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt);
					if (!$rs)
						trigger_db_error($this->dbObj);

					if ($rs->PO_RecordCount()>0)
					{
						$parent_id ='';
						while($row = $rs->FetchRow())
						{
							if($parent_id=='')
							{
								$parent_id = $row['parent_id'];
							}
							else
							{
								$parent_id = $parent_id.','.$row['parent_id'];
							}
						}
					}
					$sql  = 'DELETE FROM '.$this->CFG['db']['tbl']['article_activity'].' WHERE '.$condition;
					$stmt = $this->dbObj->Prepare($sql);
					$rs   = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

					if(!empty($parent_id))
					{
						$condition_act = '  parent_id IN ('.$parent_id.') ';
						$sql  = 'DELETE FROM '.$this->CFG['db']['tbl']['activity'].' WHERE '.$condition_act;
						$stmt = $this->dbObj->Prepare($sql);
						$rs   = $this->dbObj->Execute($stmt);
				    	if (!$rs)
					    	trigger_db_error($this->dbObj);
					}
				}
			}

		return true;
	}

	/**
	 * ArticleHandler::deleteArticleComments()
	 * @param string $ids
	 * @return
	 */
	public function deleteArticleComments($ids)
	{
		$comment_id = explode(',', $ids);
		for($inc=0;$inc<count($comment_id);$inc++)
		{
			//FETCH RECORD FOR comment_status //
			$sql = 'SELECT comment_status, article_id FROM '.$this->CFG['db']['tbl']['article_comments'].' WHERE'.
					' article_comment_id ='.$comment_id[$inc];

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
			    trigger_db_error($this->dbObj);

			$commentDetail = $rs->FetchRow();

			//DELETE COMMENTS//
			$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['article_comments'].' WHERE'.
					' article_comment_id ='.$comment_id[$inc];

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
			    trigger_db_error($this->dbObj);

			//CONTROL: IF comment_status = yes THEN WE REDUCES THE  total_comments//
			if($commentDetail['comment_status'] == 'Yes')
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].' SET total_comments=total_comments-1'.
						' WHERE article_id='.$this->dbObj->Param('article_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($commentDetail['article_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);
			}
		}
	}

	/**
	 * ArticleHandler::populateArticleRatingImages()
	 * // GET Populate Rating images for Article List \\
	 * @param mixed
	 * @return
	 */
	public function populateArticleRatingImages($rating = 0,$imagePrefix='',$condition='',$url='')
	{

		$rating = round($rating,0);
		global $smartyObj;
		$populateRatingImages_arr = array();
		$populateRatingImages_arr['rating'] = $rating;
		$populateRatingImages_arr['condition'] = $condition;
		$populateRatingImages_arr['url'] = $url;
		$populateRatingImages_arr['rating_total'] = $this->CFG['admin']['total_rating'];
		if($populateRatingImages_arr['rating']>$populateRatingImages_arr['rating_total'])
			$populateRatingImages_arr['rating'] = $populateRatingImages_arr['rating_total'];
		$populateRatingImages_arr['bulet_star'] = $this->CFG['site']['article_url'].'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-'.$imagePrefix.'ratinghover.gif';
		$populateRatingImages_arr['bulet_star_empty'] = $this->CFG['site']['article_url'].'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-'.$imagePrefix.'rating.gif';
		$smartyObj->assign('populateRatingImages_arr', $populateRatingImages_arr);
		setTemplateFolder('general/', 'article');
		$smartyObj->display('populateArticleRatingImages.tpl');
	}

	/**
	 * ArticleHandler::populateDateYearValue()
	 * used to populate date,& year
	 *
	 * @param integer $start_no
	 * @param integer $end_no
	 * @param string $highlight_value
	 *
	 * @return void
	 * @access public
	 **/
	public function populateDateYearValue($start_no, $end_no, $highlight_value='')
	{
	   	       $showOption_arr = array();
		       $inc = 0;
				for($start_no;$start_no<=$end_no;$start_no++)
					{
					   	$showOption_arr[$inc]['values']=$start_no;
						$selected = trim($highlight_value) == trim($start_no)?' selected="selected"':'';
					    $showOption_arr[$inc]['selected']=$selected;
				 	   	$showOption_arr[$inc]['optionvalue']=$start_no;
				 	    $inc++;
				  }
				return $showOption_arr;
	}


	/**
	 * ActivityHandler::increaseTotalArticleCount()
	 *
	 * @return void
	 */
	public function increaseTotalArticleCount($article_user_id)
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET total_articles=total_articles+1'.
				' WHERE user_id='.$this->dbObj->Param('user_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($article_user_id));
		    if (!$rs)
			    trigger_db_error($this->dbObj);
	}

	/**
	 * ActivityHandler::addArticleUploadActivity()
	 *
	 * @return void
	 */
	public function addArticleUploadActivity($article_id)
	{
		//Start new article upload activity
		$sql = 'SELECT u.user_name as upload_user_name, a.article_id, a.user_id as upload_user_id, a.article_server_url, '.
		        ' a.article_title FROM '.$this->CFG['db']['tbl']['article'].
				' as a, '.$this->CFG['db']['tbl']['users'].' as u '.
				' WHERE u.user_id = a.user_id AND a.article_id='.$this->dbObj->Param('article_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($article_id));
		if (!$rs)
			trigger_db_error($this->dbObj);

		$row = $rs->FetchRow();
		$activity_arr = $row;
		$activity_arr['action_key']	= 'article_uploaded';
		$articleActivityObj = new ArticleActivityHandler();
		$articleActivityObj->addActivity($activity_arr);
		//End..
	}

	/**
	 * ActivityHandler::sendMailToUserForDelete()
	 *
	 * @return boolean
	 **/
	public function sendMailToUserForActivate($article_id)
	{
		$this->populateArticleDetails($article_id);
		$subject = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $this->LANG['article_activate_subject']);
		$body = $this->LANG['article_activate_content'];
		$article_link = getUrl('viewarticle','?article_id='.$this->ARTICLE_ID.$this->changeTitle($this->ARTICLE_TITLE),
						$this->ARTICLE_ID.'/'.$this->changeTitle($this->ARTICLE_TITLE).'/', 'root','article');
		$body = str_replace('VAR_LINK', '<a href=\''.$this->CFG['site']['url'].'\'>'.$this->CFG['site']['url'].'</a>', $body);
		$body = str_replace('VAR_USER_NAME', $this->ARTICLE_USER_NAME, $body);
		$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
		$body = str_replace('VAR_ARTICLE_TITLE', $this->ARTICLE_TITLE, $body);
		$body = str_replace('VAR_ARTICLE_LINK', '<a href=\''.$article_link.'\'>'.$article_link.'</a>', $body);
		$body=nl2br($body);

		if($this->_sendMail($this->ARTICLE_USER_EMAIL, $subject, $body, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']))
			return true;
		else
			return false;
	}

		/**
	 * ActivityHandler::populateArticleDetails()
	 *
	 * @return boolean
	 **/
	public function populateArticleDetails($article_id)
	{
		$sql = 'SELECT a.article_title, a.article_category_id, a.article_id, a.article_caption, '.
				'u.user_name, u.email, u.user_id, relation_id FROM '.
				$this->CFG['db']['tbl']['article'].' as a LEFT JOIN '.$this->CFG['db']['tbl']['users'].
				' as u ON a.user_id=u.user_id WHERE'.
				' article_id='.$this->dbObj->Param('article_id').' LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($article_id));
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		if($row = $rs->FetchRow())
		{
			$this->ARTICLE_TITLE 			 = $row['article_title'];
			$this->ARTICLE_CATEGORY_ID 		 = $row['article_category_id'];
			$this->ARTICLE_USER_NAME 		 = $row['user_name'];
			$this->ARTICLE_USER_EMAIL 		 = $row['email'];
			$this->ARTICLE_USER_ID 			 = $row['user_id'];
			$this->ARTICLE_RELATION_ID 		 = $row['relation_id'];
			$this->ARTICLE_DESCRIPTION       = $row['article_caption'];
			$this->fields_arr['relation_id'] = $row['relation_id'];

			return true;
		}
		return false;
	}

	/**
	 * ArticleHandler::getTagsForArticleList()
	 * Display tags
	 * @param mixed $article_tags,$taglimit
	 * @param tag_serach_word is used for highlight the search_tag_word.
	 * @return
	 */
	public function getArticleTagsLinks($article_tags,$taglimit,$tag_serach_word='')
	{
		// change the function for display the tags with some more...
		global $smartyObj;
		$tags_arr = explode(' ', $article_tags);
		//Condition commented to display all tags in photo list page(display values controlled through css)
		/*if(count($tags_arr)>$taglimit)
		{
			$article_tag_size=$taglimit;
		}
		else
		{
			$article_tag_size=count($tags_arr);
		}*/
		$article_tag_size=count($tags_arr);
		for($i=0;$i<$article_tag_size;$i++)
		{

			$getTagsLink_arr[$i]['title_tag_name'] = $getTagsLink_arr[$i]['wordWrap_mb_ManualWithSpace_tag_name'] = $tags_arr[$i];
			if(!empty($tag_serach_word))
				$getTagsLink_arr[$i]['wordWrap_mb_ManualWithSpace_tag_name'] = highlightWords($getTagsLink_arr[$i]['wordWrap_mb_ManualWithSpace_tag_name'], $tag_serach_word);
		    $getTagsLink_arr[$i]['tag_url'] = getUrl('articlelist', '?pg=articlenew&tags='.$tags_arr[$i], 'articlenew/?tags='.$tags_arr[$i], '', 'article');
			if($i%2==0)
			{
				$getTagsLink_arr[$i]['class']='clsTagsDefalult';
			}
			else
			{
				$getTagsLink_arr[$i]['class']='clsTagsAlternate';
			}
			if($i<($article_tag_size-1))
				$getTagsLink_arr[$i]['wordWrap_mb_ManualWithSpace_tag_name'].=',';


		}

		$smartyObj->assign('getTagsLink_arr', $getTagsLink_arr);
		setTemplateFolder('general/', 'article');
		$smartyObj->display('populateTagsLinks.tpl');
	}

	/**
	 * ArticleHandler::sendEmailToAll()
	 *
	 * @return boolean
	 */
	public function sendEmailToAll()
	{
		$this->EMAIL_ADDRESS = array_unique($this->EMAIL_ADDRESS);
		if($this->EMAIL_ADDRESS)
			{
				if($this->getArticleDetails())
					{
						foreach($this->EMAIL_ADDRESS as $email)
							{
								$mailSent = false;
								$subject = $this->LANG['article_share_subject'];
								$body = $this->LANG['article_share_content'];
								if(isMember())
									{
										$articlelink = $this->getAffiliateUrl(getUrl('viewarticle', '?article_id='.$this->fields_arr['article_id'], $this->fields_arr['article_id'].'/', 'root', 'article'));
										$this->setEmailTemplateValue('user_name', $this->CFG['user']['name']);
										$this->setEmailTemplateValue('site_name', $this->CFG['site']['name']);
									}
								else
									{
										$articlelink = $this->getAffiliateUrl(getUrl('viewarticle', '?article_id='.$this->fields_arr['article_id'], $this->fields_arr['article_id'].'/', 'root', 'article'));
										$this->setEmailTemplateValue('user_name', $this->fields_arr['first_name']);
										$this->setEmailTemplateValue('site_name', $this->CFG['site']['name']);
									}

								$this->setEmailTemplateValue('article_title', $this->ARTICLE_TITLE);
								$this->setEmailTemplateValue('article_description', $this->ARTICLE_DESCRIPTION);
								$this->setEmailTemplateValue('personal_message', $this->fields_arr['personal_message']);
								$this->setEmailTemplateValue('view_article', $this->view_article_link);
								$this->setEmailTemplateValue('link', $this->getAffiliateUrl($this->CFG['site']['url']));

								if(isMember())
									{
										$mail->FromName = $this->CFG['user']['name'];
										$mail->From = $mail->Sender = $this->CFG['user']['email'];
									}
								else
									{
										$mail->FromName = $this->fields_arr['first_name'];
										$mail->From = $mail->Sender = $this->CFG['site']['noreply_email'];
									}

								$this->_sendMail($email, $subject, $body, $mail->FromName, $mail->From);
							}
						return true;
					}
				return false;
			}
	}

	/**
	 * ArticleHandler::getEmailAddressOfRelation()
	 *
	 * @param mixed $value
	 * @return
	 */
	public function getEmailAddressOfRelation($value)
	{
	    $relation_id = $value?$value:0;
 	    $sql = 'SELECT u.email FROM '.$this->CFG['db']['tbl']['friends_relation'].' AS fr,'.
				' '.$this->CFG['db']['tbl']['friends_list'].' AS fl LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u'.
				' ON (u.user_id = IF(fl.owner_id='.$this->dbObj->Param('owner_id').',fl.friend_id, fl.owner_id)'.
				' AND u.usr_status=\'Ok\' ) WHERE (fr.relation_id IN('.$relation_id.') AND fl.id=fr.friendship_id)';

	    $stmt = $this->dbObj->Prepare($sql);
	    $rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
	    if (!$rs)
	    trigger_db_error($this->dbObj);

	    if($rs->PO_RecordCount())
	    {
			while($row = $rs->FetchRow())
			{
		  	  	$value = trim($row['email']);
			  	$this->EMAIL_ADDRESS[] = $value;
			}
	    }
	   return true;
 	}

 	 /**
	 * ArticleHandler::shareArticleDetails()
	 *
	 * @return void
	 */
	 public function shareArticleDetails($article_id)
	 {
	 	$this->ARTICLE_ID = $article_id;
	 	$this->populateArticleDetails($article_id);
		$this->getEmailAddressOfRelation($this->ARTICLE_RELATION_ID);
		$this->sendEmailToAll();
	 }


	/**
	 * ArticleHandler::getArticleDetails()
	 *
	 * @return boolean
	 */
	public function getArticleDetails()
	{
		$sql = 'SELECT article_title, article_caption'.
				' FROM '.$this->CFG['db']['tbl']['article'].
				' WHERE article_id='.$this->dbObj->Param('article_id').' LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
		    if (!$rs)
			    trigger_db_error($this->dbObj);

		if($row = $rs->FetchRow())
			{
				$this->ARTICLE_TITLE = $row['article_title'];
				$this->ARTICLE_DESCRIPTION = strip_tags($row['article_caption']);

				$this->view_article_link = getUrl('viewarticle', '?article_id='.$this->fields_arr['article_id'].'&amp;title='.$this->changeTitle($row['article_title']), $this->fields_arr['article_id'].'/'.$this->changeTitle($row['article_title']).'/', 'root', 'article');
				return true;
			}
		return false;
	}

	/**
	 * ArticleHandler::chkArticleExistInActivity()
	 *
	 * @return boolean
	 */
	public function chkArticleExistInActivity($article_id)
	{

		$action_key = 'article_uploaded';
		$condition = ' SUBSTRING_INDEX(action_value, \'~\', 1 ) IN ('.$article_id.') AND action_key = \''.$action_key.'\'';

		$sql = 'SELECT parent_id FROM '.$this->CFG['db']['tbl']['article_activity'].' WHERE '.$condition;
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_db_error($this->dbObj);

		if ($rs->PO_RecordCount()>0)
		{
			return true;
		}
		return false;
	}

	 /* ArticleHandler::setFontSizeInsteadOfSearchCountSidebar()
	 * @param array $tag_array
	 * @return array
	 **/
	public function setFontSizeInsteadOfSearchCountSidebar($tag_array=array())
	{
		$formattedArray = $tag_array;
		$max_qty = max(array_values($formattedArray));
		$min_qty = min(array_values($formattedArray));
		$max_font_size = 28;
		$min_font_size = 12;
		$spread = $max_qty - $min_qty;
		if (0 == $spread) { // Divide by zero
			$spread = 1;
		}
		$step = ($max_font_size - $min_font_size)/($spread);
			foreach ($tag_array as $catname => $count)
			{
				$size = $min_font_size + ($count - $min_qty) * $step;
				$formattedArray[$catname] = ceil($size);
			}
		return $formattedArray;
	}

	/**
	 * ArticleHandler::populateSidebarClouds()
	 *
	 * @return
	 **/
	public function populateSidebarClouds($module, $tags_table)
	{
		global $smartyObj;
		$return = array();
		$return['resultFound']=false;

		$allowed_pages_array = array('viewArticle.php', 'articleWriting.php');
		if(displayBlock($allowed_pages_array))
			return;

		if($this->CFG['admin']['tagcloud_based_search_count'])
		{
			$sql = 'SELECT tag_name, search_count FROM '.$this->CFG['db']['tbl'][$tags_table].
					' WHERE search_count>0 ORDER BY search_count DESC, result_count DESC, tag_name DESC'.
					' LIMIT 0, '.$this->CFG['admin']['articles']['sidebar_clouds_num_record'];
		}
		else
		{
			$sql = 'SELECT tag_name, result_count AS search_count FROM'.
					' '.$this->CFG['db']['tbl'][$tags_table].
					' WHERE result_count>0 ORDER BY result_count DESC, tag_name DESC'.
					' LIMIT 0, '.$this->CFG['admin']['articles']['sidebar_clouds_num_record'];
		}

		$searchUrl = getUrl('articlelist', '?pg=articlenew&tags=%s', 'articlenew/?tags=%s', '', 'article');
		$moreclouds_url = getUrl('tags', '?pg=article', 'article/', '', 'article');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if ($rs->PO_RecordCount()>0)
		{
			$return['resultFound']=true;
			$classes = array('clsArticleTagStyleGrey', 'clsArticleTagStyleGreen');
			$tagClassArray = array();
			while($row = $rs->FetchRow())
			{
					$tagArray[$row['tag_name']] = $row['search_count'];
					$class = $classes[rand(0, count($classes))%count($classes)];
					$tagClassArray[$row['tag_name']] = $class;
			}
			$tagArray = $this->setFontSizeInsteadOfSearchCountSidebar($tagArray);
			ksort($tagArray);
			$inc=0;
			foreach($tagArray as $tag=>$fontSize)
			{
				$url 	= sprintf($searchUrl, $tag);
				$class 	= $tagClassArray[$tag];
				$fontSizeClass= 'style="font-size:'.$fontSize.'px"';
				$return['item'][$inc]['url']=$url;
				$return['item'][$inc]['class']=$class;
				$return['item'][$inc]['fontSizeClass']=$fontSizeClass;
				$return['item'][$inc]['wordWrap_mb_ManualWithSpace_tag']= $tag;
				$return['item'][$inc]['name']=$tag;
				$inc++;
			}
		}
		$smartyObj->assign('moreclouds_url', $moreclouds_url);
		$smartyObj->assign('opt', $module);
		$smartyObj->assign('populateCloudsBlock', $return);
		setTemplateFolder('general/', 'article');
		$smartyObj->display('populateCloudsBlock.tpl');
	}
		/**
		 * ArticleHandler::populateCarousalarticleBlock()
		 *
		 * @return array
		 */
		public function populateCarousalarticleBlock($case, $start = 0, $all = false,$current_id ='')
		{

			global $smartyObj;
			if ($current_id != '') {
				$userArticleCondition = ' AND u. user_id ='.$current_id;
			}
			else
				$userArticleCondition = '';
			$UserDetails = array();
			$fields_list = array('user_name', 'first_name', 'last_name');
			$populateCarousalarticleBlock_arr = array();
			$populateCarousalarticleBlock_arr['record_count'] = false;
			$populateCarousalarticleBlock_arr['row'] = array();
			$limit = '';
			$default_cond = ' u.user_id=a.user_id AND u.usr_status=\'Ok\' AND a.article_status=\'Ok\''.$this->getAdultQuery('a.', 'article').
							 ' AND (a.user_id = '.$this->CFG['user']['user_id'].' OR'.
							 ' a.article_access_type = \'Public\''.$this->getAdditionalQuery().')'.$userArticleCondition;

			$default_fields = 'distinct(a.article_id),u.user_id, a.article_title, a.article_summary, a.article_status, a.total_favorites,TIMEDIFF(NOW(), a.date_added) as date_added, a.rating_count,a.rating_total, (a.rating_total/a.rating_count) as rating , a.article_server_url, u.user_name, DATE_FORMAT(a.date_of_publish, "%d %b %Y") as published_date, total_comments, total_views, total_favorites, article_attachment, total_downloads, article_tags';
			$limit = 0;
			$this->setFormField('block', $case);
			switch($case)
			{
				case 'articlerecent':
					$order_by = 'a.date_added DESC';
					$condition = $default_cond;
					$sql = 'SELECT '.$default_fields.' '.
							'FROM '.$this->CFG['db']['tbl']['article'].' AS a JOIN '.$this->CFG['db']['tbl']['users'].' AS u '.
							'WHERE '.$condition.' ORDER BY '.$order_by;
					$limit = $this->CFG['admin']['articles']['recentlyaddedarticle_total_record'];
				break;

				case 'articlemostfavorite'://NEW article//
					$condition = 'a.total_favorites > 0  AND '.$default_cond;
					$order_by = ' a.total_favorites DESC, a.total_views DESC ';
					$sql = 'SELECT '.$default_fields.' '.
							'FROM '.$this->CFG['db']['tbl']['article'].' AS a JOIN  '.$this->CFG['db']['tbl']['users'].' AS u '.
							'WHERE '.$condition.' ORDER BY '.$order_by;
					$limit = $this->CFG['admin']['articles']['mostfavorite_total_record'];
				break;

				case 'articletoprated':
					$order_by = 'rating DESC';
					$condition = 'a.rating_total > 0 AND a.allow_ratings=\'Yes\' AND '.$default_cond;
					$sql = 'SELECT '.$default_fields.' '.
							'FROM '.$this->CFG['db']['tbl']['article'].' AS a JOIN '.$this->CFG['db']['tbl']['users'].' AS u '.
							'WHERE '.$condition.' ORDER BY '.$order_by;
					$limit = $this->CFG['admin']['articles']['topratedarticle_total_record'];
				break;

				case 'articlemostviewed':
					$order_by = 'total_views DESC';
					$condition = 'a.total_views > 0 AND '.$default_cond;
					$sql = 'SELECT '.$default_fields.' '.
							'FROM '.$this->CFG['db']['tbl']['article'].' AS a JOIN '.$this->CFG['db']['tbl']['users'].' AS u '.
							'WHERE '.$condition.' ORDER BY '.$order_by;
					$limit = $this->CFG['admin']['articles']['topratedarticle_total_record'];
				break;

				case 'articlemostdiscussed':
					$order_by = 'total_comments DESC';
					$condition = 'a.total_comments > 0 AND '.$default_cond;
					$sql = 'SELECT '.$default_fields.' '.
							'FROM '.$this->CFG['db']['tbl']['article'].' AS a JOIN '.$this->CFG['db']['tbl']['users'].' AS u '.
							'WHERE '.$condition.' ORDER BY '.$order_by;
					$limit = $this->CFG['admin']['articles']['mostdiscussed_total_record'];

				break;
			}
			if(!$all)
				$sql .= ' LIMIT '.$start.', '.$limit;
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
				trigger_db_error($this->dbObj);

			$record_count = $rs->PO_RecordCount();
			if($all)
				{
					return $record_count;
				}
			$inc = 1;
			$this->no_of_row=1;
			$count=0;

			while($article_detail = $rs->FetchRow())
			{

				$this->UserDetails = $this->getUserDetail('user_id', $article_detail['user_id'], 'user_name');
				$populateCarousalarticleBlock_arr['record_count'] = true;
				$article_detail['date_published'] = $article_detail['published_date'];
				$populateCarousalarticleBlock_arr['row'][$inc]['member_icon'] =  getMemberAvatarDetails($article_detail['user_id']);
				$populateCarousalarticleBlock_arr['row'][$inc]['rating'] = $article_detail['rating_total'];
				$populateCarousalarticleBlock_arr['row'][$inc]['record'] = $article_detail;
				$populateCarousalarticleBlock_arr['row'][$inc]['article_status'] = $article_detail['article_status'];
				$populateCarousalarticleBlock_arr['row'][$inc]['article_id'] = $article_detail['article_id'];
				$populateCarousalarticleBlock_arr['row'][$inc]['total_favorites'] = $article_detail['total_favorites'];
				$populateCarousalarticleBlock_arr['row'][$inc]['username'] = $article_detail['user_name'];
				$populateCarousalarticleBlock_arr['row'][$inc]['MemberProfileUrl'] = getMemberProfileUrl($article_detail['user_id'], $article_detail['user_name']);
				$populateCarousalarticleBlock_arr['row'][$inc]['date_added'] = ($article_detail['date_added'] != '') ? getTimeDiffernceFormat($article_detail['date_added']) : '';
				$populateCarousalarticleBlock_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_article_title'] = $article_detail['article_title'];
				$populateCarousalarticleBlock_arr['row'][$inc]['viewarticle_url'] = getUrl('viewarticle', '?article_id='.$article_detail['article_id'].'&title='.$this->changeTitle($article_detail['article_title']), $article_detail['article_id'].'/'.$this->changeTitle($article_detail['article_title']).'/', '', 'article');
				$populateCarousalarticleBlock_arr['row'][$inc]['member_profile_url'] = getMemberProfileUrl($article_detail['user_id'], $this->UserDetails);
				$populateCarousalarticleBlock_arr['row'][$inc]['name'] = $this->getUserDetail('user_id', $article_detail['user_id'], 'user_name');
				$populateCarousalarticleBlock_arr['row'][$inc]['view_article_link'] = getUrl('viewarticle', '?article_id='.$article_detail['article_id'].'&amp;title='.$this->changeTitle($article_detail['article_title']), $article_detail['article_id'].'/'.$this->changeTitle($article_detail['article_title']).'/', '', 'article');
				$populateCarousalarticleBlock_arr['row'][$inc]['article_caption_manual'] = strip_tags($article_detail['article_summary']);
				$inc++;

			}

			if($case == 'articlerecent')
				$populateCarousalarticleBlock_arr['view_all_articles_link'] = getUrl('articlelist','?pg=articlerecent','articlerecent/','','article');
			elseif($case == 'articletoprated')
				$populateCarousalarticleBlock_arr['view_all_articles_link'] = getUrl('articlelist','?pg=articletoprated','articletoprated/','','article');
			elseif($case == 'articlemostviewed')
				$populateCarousalarticleBlock_arr['view_all_articles_link'] = getUrl('articlelist','?pg=articlemostviewed','articlemostviewed/','','article');
			elseif($case == 'articlemostdiscussed')
				$populateCarousalarticleBlock_arr['view_all_articles_link'] = getUrl('articlelist','?pg=articlemostdiscussed','articlemostdiscussed/','','article');
			elseif($case == 'articlemostfavorite')
				$populateCarousalarticleBlock_arr['view_all_articles_link'] = getUrl('articlelist','?pg=articlemostfavorite','articlemostfavorite/','','article');
			else
				$populateCarousalarticleBlock_arr['view_all_articles_link'] = getUrl('articlelist','?pg=articlerecent','articlerecent/','','article');
			$smartyObj->assign('populateCarousalarticleBlock_arr', $populateCarousalarticleBlock_arr);

		}
	/**
	 * ArticleHandler::populateArticleListHidden()
	 * @param array $hidden_field
	 * @return void
	 */
	public function populateArticleListHidden($hidden_field)
	{
		foreach($hidden_field as $hidden_name)
		{
			//when submit the form through javascript and if not submit in IE,then check hidden input with the name set as "action", obviously this confused IE.
			//refer http://bytes.com/topic/javascript/answers/92323-form-action-help-needed
			if($hidden_name == 'action')
				$hidden_name = 'action_new';
?>
			<input type="hidden" name="<?php echo $hidden_name;?>" value="<?php echo isset($this->fields_arr[$hidden_name])?$this->fields_arr[$hidden_name]:'';?>" />
<?php
		}
	}


	public function articleTotalCount()
	{

		$sql = 'SELECT count(article_id) as total FROM '.$this->CFG['db']['tbl']['article'].
				' WHERE article_status ="Ok"';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_db_error($this->dbObj);

		$row = $rs->FetchRow();
		return $row['total'];
	}
}
?>