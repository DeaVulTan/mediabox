<?php
/**
 * This file is use to view the blog
 *
 * @category	Rayzz
 * @package		General
 */
class ViewBlog extends BlogHandler
{
	/**
	 * ViewBlog::chkValidBlog()
	 *
	 * @return
	 */
	public function chkValidBlog()
	{
		    $sql = 'SELECT blog_id,blog_name,blog_title, blog_slogan, user_id,blog_logo_ext FROM '.$this->CFG['db']['tbl']['blogs'].
				' WHERE blog_name='.$this->dbObj->Param('blog_name').
				' AND blog_status=\'Active\'';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_name']));
			if (!$rs)
				trigger_db_error($this->dbObj);
			$blog_logo_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['blog']['folder'].'/'.$this->CFG['admin']['blog']['blog_logo_folder'].'/';
			$fields_list = array('user_name', 'first_name', 'last_name');
			if($row = $rs->FetchRow())
			    {
			    if(!isset($this->UserDetails[$row['user_id']]))
					$this->getUserDetail('user_id',$row['user_id'], 'user_name');

			     $this->fields_arr['blog_id']=$row['blog_id'];
			     $this->fields_arr['user_id']=$row['user_id'];
			     $this->fields_arr['blog_title']=$row['blog_title'];
			     $this->fields_arr['blog_slogan']=$row['blog_slogan'];
			     $this->fields_arr['blog_url']=getUrl('viewblog','?blog_name='.$row['blog_name'],$row['blog_name'].'/','root','blog');
			     $this->fields_arr['blog_rss_url']=getUrl('rssblog','?blog_name='.$row['blog_name'],$row['blog_name'].'/','root','blog');
			     $this->fields_arr['blog_logo_src']=$this->CFG['site']['blog_url'].'design/templates/'.$this->CFG['html']['template']['default'].
				 									'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/default-logo.jpg';
			     if($row['blog_logo_ext'])
			     $this->fields_arr['blog_logo_src'] = $this->CFG['site']['url'].$blog_logo_folder.$row['blog_id'].'.'.$row['blog_logo_ext'];
			   	 $this->validBlogId = true;
			  	 return true;
			  	}
			return false;
	}
	/**
	 * ViewBlog::setTableAndColumns()
	 *
	 * @return
	 */
	public function setTableAndColumns()
	{
		$this->setTableNames(array($this->CFG['db']['tbl']['blog_posts'].' AS bp JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON bp.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['blog_category'].' AS bc ON bc.blog_category_id =bp.blog_category_id'.' JOIN '.$this->CFG['db']['tbl']['blogs'].' AS b ON bp.blog_id =b.blog_id'));
		$this->setReturnColumns(array('bp.message', 'bp.blog_post_id','bp.user_id', 'bp.blog_access_type', 'DATE_FORMAT(bp.date_of_publish, "%d %b %Y") as published_date',
									  'bp.relation_id', 'bp.blog_post_name', 'bp.date_added', 'NOW() as date_current', 'bp.total_favorites',
									  'DATE_FORMAT(bp.date_added, "%d %b %Y") as added_date', 'bp.total_views', '(bp.rating_total/bp.rating_count) as rating',
									  'blog_tags', 'status', 'TIMEDIFF(NOW(), last_view_date) as blog_last_view_date', 'total_comments',
									  'bc.blog_category_name','b.width','b.height','bc.blog_category_id'));
		$additional_query = '';

		if($this->fields_arr['y'])
		{
			$additional_query .= ' YEAR(bp.date_added)=\''.addslashes($this->fields_arr['y']).'\' AND ';

			if($this->fields_arr['m'])
				$additional_query .= 'MONTHNAME(bp.date_added)=\''.addslashes($this->fields_arr['m']).'\' AND ';
		}

		if($this->fields_arr['cid'])
		{
			$additional_query .= '(bp.blog_category_id=\''.addslashes($this->fields_arr['cid']).'\') AND ';

			if($this->fields_arr['sid'])
				$additional_query .= '(bp.blog_sub_category_id=\''.addslashes($this->fields_arr['sid']).'\') AND ';
		}
		if($this->fields_arr['tags'])
			$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'bp.blog_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'bp.blog_post_name', '').') AND ';

    	if ($this->fields_arr['post_keyword'] != $this->LANG['common_search_text'] AND $this->fields_arr['post_keyword'])
		{
			//$advanced_filters .= ' AND u.user_name LIKE \'%' .validFieldSpecialChr($this->fields_arr['post_owner']). '%\' ';
			$additional_query .= '(' . getSearchRegularExpressionQueryModified($this->fields_arr['post_keyword'], 'bp.blog_tags', 'OR') . getSearchRegularExpressionQueryModified($this->fields_arr['post_keyword'], 'bp.blog_post_name', '').') AND ';
			//$this->advanceSearch = true;
		}
		$userCondition = 'bp.user_id = '.  $this->CFG['user']['user_id'] . ' OR bp.blog_access_type = \'Public\'' . $this->getAdditionalQuery('bp.');

		$this->sql_condition = $additional_query.'bp.blog_id='.$this->fields_arr['blog_id'].' AND bp.status=\'Ok\' AND u.usr_status=\'Ok\''.$this->getAdultQuery('bp.', 'blog').' AND ( ' . $userCondition. ' ) ';
		$this->sql_sort = 'bp.date_added DESC';

	}
	/**
	 * ViewBlog::showBlogDetails()
	 *
	 * @return
	 */
	public function showBlogDetails()
	{
		global $smartyObj;
		$showBlogDetail_arr = array();
		$relatedTags = array();
		$blogPostTags = array();
		$tag = $this->_parse_tags(strtolower($this->fields_arr['tags']));
		$inc=0;
		$fields_list = array('user_name', 'first_name', 'last_name');
		while($row = $this->fetchResultRecord())
		    {
		    	if(!isset($this->UserDetails[$row['user_id']]))
				$this->getUserDetail('user_id',$row['user_id'], 'user_name');

		    	$row['date_added'] = ($row['date_added'] != '') ? getTimeDiffernceFormat($row['date_added']) : '';
		    	$showBlogDetail_arr[$inc]['name'] = $this->getUserDetail('user_id',$row['user_id'], 'user_name');
		    	$row['date_added'] = $row['added_date'];
				$row['date_published'] = $row['published_date'];
				$showBlogDetail_arr[$inc]['record'] = $row;

				$date_arr=explode(' ',$row['date_added']);
				$showBlogDetail_arr[$inc]['date']=$date_arr[0];
				$showBlogDetail_arr[$inc]['month']=$date_arr[1];
				$showBlogDetail_arr[$inc]['year']=$date_arr[2];

		    	$search_word= '';
		    	if($this->fields_arr['tags']!='' && $this->fields_arr['tags']!=$this->LANG['viewblog_search_blogpost_tags'])
						$search_word=$this->fields_arr['tags'];
				elseif($this->fields_arr['post_keyword']!='' && $this->fields_arr['post_keyword']!=$this->LANG['common_search_text'])
					$search_word=$this->fields_arr['post_keyword'];

		    	$showBlogDetail_arr[$inc]['blog_post_name_manual'] = highlightWords($row['blog_post_name'], $search_word);
				$showBlogDetail_arr[$inc]['blog_category_name_manual'] = $row['blog_category_name'];
				$showBlogDetail_arr[$inc]['blog_category_id'] = $row['blog_category_id'];
				$showBlogDetail_arr[$inc]['blog_category_url']= getUrl('blogpostlist', '?pg=postnew&amp;cid='.$row['blog_category_id'], 'postnew/?cid='.$row['blog_category_id'], '', 'blog');
         		$user_name=$this->getUserDetail('user_id',$row['user_id'], 'user_name');
				$showBlogDetail_arr[$inc]['userDetails'] = $user_name;
				$showBlogDetail_arr[$inc]['view_blog_post_link'] = getUrl('viewpost', '?blog_post_id='.$row['blog_post_id'].'&amp;title='.$this->changeTitle($row['blog_post_name']), $row['blog_post_id'].'/'.$this->changeTitle($row['blog_post_name']).'/', '', 'blog');
				$showBlogDetail_arr[$inc]['member_profile_url'] = getMemberProfileUrl($row['user_id'], $user_name);
				$showBlogDetail_arr[$inc]['message']=strip_selected_blog_tags($row['message']);
				$showBlogDetail_arr[$inc]['profileIcon']=getMemberAvatarDetails($row['user_id']);
				$showBlogDetail_arr[$inc]['width'] = $row['width'];
				$showBlogDetail_arr[$inc]['height'] = $row['height'];
				$tags= $this->_parse_tags($row['blog_tags']);
				$showBlogDetail_arr[$inc]['tags'] = $tags;

				if ($tags)
			    {
			    	$showBlogDetail_arr[$inc]['tags_arr'] = array();
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

						$showBlogDetail_arr[$inc]['tags_arr'][$i]['url'] = getUrl('blogpostlist', '?pg=postnew&amp;tags='.$value, 'postnew/?tags='.$value, '', 'blog');
						$showBlogDetail_arr[$inc]['tags_arr'][$i]['value'] = highlightWords($value, $search_word);
						$i++;
					}
				  }
				 if($this->fields_arr['tags'] and $this->CFG['admin']['tagcloud_based_search_count'])
				      $this->updateBlogPostTagDetails($blogPostTags);

			    $smartyObj->assign('showBlogDetail_arr', $showBlogDetail_arr);
			    $inc++;//end
		    }
	}
	/**
	 * ViewBlog::populateRatingDetails()
	 *
	 * @param mixed $rating
	 * @return
	 */
	public function populateRatingDetails($rating)
	{
		$rating = round($rating,0);
		return $rating;
	}
	/**
	 * ViewBlog::updateBlogPostTagDetails()
	 *
	 * @param array $blogPostTags
	 * @return
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
	 * ViewBlog::updateSearchCountAndResultForBlogPostTag()
	 *
	 * @param string $tag
	 * @return
	 */
	public function updateSearchCountAndResultForBlogPostTag($tag='')
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_tags'].
			   ' SET search_count = search_count + 1,'.
			   ' result_count = '.$this->getResultsTotalNum().','.
			   ' last_searched = NOW()'.
			   ' WHERE tag_name='.$this->dbObj->Param('tag_name').' AND blog_id='.$this->dbObj->Param('blog_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($tag,$this->fields_arr['blog_id']));
		    if (!$rs)
			    trigger_db_error($this->dbObj);

		if ($this->dbObj->Affected_Rows()==0)
	    {
			$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['blog_tags'].
				   ' SET search_count = search_count + 1 ,'.
				   ' result_count = '.$this->getResultsTotalNum().','.
				   ' last_searched = NOW(),'.
				   ' tag_name='.$this->dbObj->Param('tag_name').',blog_id='.$this->dbObj->Param('blog_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($tag,$this->fields_arr['blog_id']));
			    if (!$rs)
				   trigger_db_error($this->dbObj);
	    }
	}
	/**
	 * ViewBlog::updateSearchCountForBlogPostTag()
	 *
	 * @param string $tag
	 * @return
	 */
	public function updateSearchCountForBlogPostTag($tag='')
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_tags'].
			   ' SET search_count = search_count + 1,'.
			   ' result_count = '.$this->getResultsTotalNum().','.
			   ' last_searched = NOW()'.
			   ' WHERE tag_name='.$this->dbObj->Param('tag_name').' AND blog_id='.$this->dbObj->Param('blog_id');


		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($tag,$this->fields_arr['blog_id']));
		    if (!$rs)
			    trigger_db_error($this->dbObj);

		if ($this->dbObj->Affected_Rows()==0)
	    {
			$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['blog_tags'].
				   ' SET search_count = search_count + 1 ,'.
				   ' result_count = '.$this->getResultsTotalNum().','.
				   ' last_searched = NOW(),'.
				   ' tag_name='.$this->dbObj->Param('tag_name').',blog_id='.$this->dbObj->Param('blog_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($tag,$this->fields_arr['blog_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);
	    }
	}
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
		return $this->LANG['viewblog_unknown_category'];
	}
	public function getPageTitle()
	{
		$user_name = getUserDetail('user_id',$this->fields_arr['user_id'], 'user_name');
		$pg_title = str_replace('{user_name}',$user_name, $this->LANG['viewblog_title']);

		//change the page title if correspnding category or subcategory selected with dropdown list of options
		if ($this->fields_arr['cid'] || $this->fields_arr['sid'] )
		{
	        $categoryTitle = $this->LANG['viewblog_category_blog_post_title'];
	        $name = $this->getCategoryName();
	        $categoryTitle = str_replace('{category_name}',$name, $categoryTitle);
	    }
	    if($this->fields_arr['y'])
		{
	        $yearTitle = $this->LANG['viewblog_year_month_blog_post_title'];
	        $yearTitle = str_replace('{year}',$this->fields_arr['y'], $yearTitle);
	        $yearTitle = str_replace('{month}',$this->fields_arr['m'], $yearTitle);
	        $pg_title = $pg_title.' '.$yearTitle;
	    }
		if ($this->fields_arr['tags'])
		{
	        $tagsTitle = $this->LANG['viewblog_tags_blog_post_title'];
	        $name = $this->fields_arr['tags'];
	        $tagsTitle = str_replace('{tags_name}', $name, $tagsTitle);
	    }
	    if($this->fields_arr['cid'] || $this->fields_arr['sid'])
		{
				$pg_title = $pg_title.' '.$this->LANG['common_in'].' '.$categoryTitle;
		}
		if($this->fields_arr['tags'])
		{
			$pg_title = $pg_title.' '.$tagsTitle;
		}

		return $pg_title;
	}
	public function displayBlogRatingImage($blog_id)
	{

	    $sql = 'SELECT (bp.rating_total/bp.rating_count) as rating FROM '.
			   $this->CFG['db']['tbl']['blog_posts'].' AS bp '.
			   ' WHERE bp.status=\'Ok\' AND bp.blog_id='.$this->dbObj->Param('blog_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($blog_id));
		    if (!$rs)
			    trigger_db_error($this->dbObj);
	    $row = $rs->FetchRow();
		{
		   if($row['rating']!='')
		   {
				return $this->populateBlogRatingImages($row['rating'],'blog');
		   }
		   else
		   {
		   		return $this->populateBlogRatingImages(0,'blog');
		   }
		}
	}

}
//-------------------- Code begins -------------->>>>>//
$ViewBlog = new ViewBlog();

if(!chkAllowedModule(array('blog')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$ViewBlog->setPageBlockNames(array('blog_view_blog'));
//default form fields and values...
$ViewBlog->setFormField('blog_name', '');
$ViewBlog->setFormField('blog_title', '');
$ViewBlog->setFormField('blog_slogan', '');
$ViewBlog->setFormField('blog_url', '');
$ViewBlog->setFormField('blog_rss_url', '');
$ViewBlog->setFormField('blog_id', '');
$ViewBlog->setFormField('user_id', '');
$ViewBlog->setFormField('blog_tags', '');
$ViewBlog->setFormField('tags', '');
$ViewBlog->setFormField('blog_post_id', '');
$ViewBlog->setFormField('post_keyword', '');
$ViewBlog->setFormField('cid', '');
$ViewBlog->setFormField('sid', '');
$ViewBlog->setFormField('y', '');
$ViewBlog->setFormField('m', '');
$ViewBlog->setFormField('blog_post_name', '');

$ViewBlog->setAllPageBlocksHide();

$ViewBlog->sanitizeFormInputs($_REQUEST);


$ViewBlog->checkBlogAdded = $ViewBlog->chkThisUserAllowedToPost();

if(!$ViewBlog->chkValidBlog())
  Redirect2URL(getUrl('bloglist','?msg=1','?msg=1','','blog'));

$ViewBlog->LANG['viewblog_title'] = $ViewBlog->getPageTitle();

$ViewBlog->getPreviousBlogLink($ViewBlog->getFormField('blog_id'));
$ViewBlog->getNextBlogLink($ViewBlog->getFormField('blog_id'));

$ViewBlog->setPageBlockShow('blog_view_blog');
if($ViewBlog->isShowPageBlock('blog_view_blog'))
{
	$ViewBlog->setTableAndColumns();
	$ViewBlog->buildSelectQuery();
	$ViewBlog->buildQuery();
	//$ViewBlog->printQuery();
	$ViewBlog->executeQuery();
	if($ViewBlog->isResultsFound())
		{
			if($CFG['feature']['rewrite_mode'] == 'htaccess')
				$paging_arr = array('start', 'tags', 'user_id', 'action', 'advanceFromSubmission');
			else
				$paging_arr = array('start', 'tags', 'user_id', 'pg', 'action', 'advanceFromSubmission');
			$smartyObj->assign('paging_arr',$paging_arr);
			$smartyObj->assign('smarty_paging_list', $ViewBlog->populatePageLinksPOST($ViewBlog->getFormField('start'), 'seachAdvancedFilter'));
			$ViewBlog->blog_view_blog['showBlogDetails'] = $ViewBlog->showBlogDetails();
		}
}

$LANG['meta_viewblog_keywords'] = str_replace('{default_tags}', $CFG['html']['meta']['keywords'], $LANG['meta_viewblog_keywords']);
$LANG['meta_viewblog_keywords'] = str_replace('{tags}', $ViewBlog->getFormField('blog_tags'), $LANG['meta_viewblog_keywords']);

$LANG['meta_viewblog_description'] = str_replace('{default_tags}', $CFG['html']['meta']['description'], $LANG['meta_viewblog_description']);
$LANG['meta_viewblog_description'] = str_replace('{tags}', $ViewBlog->getFormField('blog_slogan'), $LANG['meta_viewblog_description']);

$LANG['meta_viewblog_title'] = str_replace('{title}', $ViewBlog->getFormField('blog_title'), $LANG['meta_viewblog_title']);
$LANG['meta_viewblog_title'] = str_replace('{module}', $LANG['window_title_blog'], $LANG['meta_viewblog_title']);

setPageTitle($LANG['meta_viewblog_title']);
setMetaKeywords($LANG['meta_viewblog_keywords']);
setMetaDescription($LANG['meta_viewblog_description']);

//includ the header of the page
$ViewBlog->includeHeader();
?>
<script type="text/javascript">
	var form_name_array = new Array('postSearch');
	function clearValue(id)
	{
		$Jq('#'+id).val('');
	}
	function setOldValue(id)
	{
		if (($Jq('#'+id).val()=="") && (id == 'post_keyword') )
		$Jq('#'+id).val('<?php echo $LANG['common_search_text']?>');
	}
</script>
<?php
//include the content of the page
setTemplateFolder('general/', 'blog');
$smartyObj->display('viewBlog.tpl');
//includ the footer of the page
$ViewBlog->includeFooter();
?>