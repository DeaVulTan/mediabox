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
class BlogSearchList extends BlogHandler
{
	public $UserDetails = array();
	public $advanceSearch;

	/**
     * BlogSearchList::advancedFilters()
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
			if ($this->fields_arr['blog_name_keywords'] != $this->LANG['bloglist_keyword_field'] AND $this->fields_arr['blog_name_keywords'])
			{
				$advanced_filters .= ' AND b.blog_name LIKE \'%' .validFieldSpecialChr($this->fields_arr['blog_name_keywords']). '%\' ';
				$this->advanceSearch = true;
			}
			if ($this->fields_arr['post_owner'] != $this->LANG['bloglist_post_created_by'] AND $this->fields_arr['post_owner'])
			{
				$advanced_filters .= ' AND u.user_name LIKE \'%' .validFieldSpecialChr($this->fields_arr['post_owner']). '%\' ';
				$this->advanceSearch = true;
			}
			$this->advanceSearch = true;
			return $advanced_filters;
		}
    }

	/**
	 * BlogSearchList::setTableAndColumns()
	 *
	 * @return void
	 */
	public function setTableAndColumns()
	{
		$this->setTableNames(array($this->CFG['db']['tbl']['blogs'] . ' AS b JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON b.user_id = u.user_id'));
		$this->setReturnColumns(array('b.blog_id','b.blog_name','b.user_id','DATE_FORMAT(b.date_added, "%d %b %Y") as date_added','u.user_name'));
		$this->sql_condition ='b.blog_status=\'Active\' AND u.usr_status=\'Ok\''.$this->advancedFilters();
		$this->sql_sort = 'b.date_added DESC';

	}

	/**
	 * BlogSearchList::showBlogSearchList()
	 *
	 * @return void
	 */
	public function showBlogSearchList()
	{
		global $smartyObj;
		$showBlogSearchList_arr = array();
		//for tags
		$showBlogSearchList_arr['separator'] = ':&nbsp;';
		$relatedTags = array();

		$count = 0;
		$found = false;

		//$rayzz = new RayzzHandler($this->dbObj, $this->CFG);
		$fields_list = array('user_name', 'first_name', 'last_name');
		$blogPostTags = array();
		$showBlogSearchList_arr = array();
		$inc = 0;
		while($row = $this->fetchResultRecord())
	    {

	        $showBlogSearchList_arr[$inc]['user_id'] = $row['user_id'];
	        $showBlogSearchList_arr[$inc]['date_added'] = $row['date_added'];
			//To Display the number of days blog post added
			$row['date_added'] = ($row['date_added'] != '') ? getTimeDiffernceFormat($row['date_added']) : '';

			//To Display Blog Added Date in DD MMM YYYY (01 Jan 2009) Format
			$row['date_added'] = $row['date_added'];
			$showBlogSearchList_arr[$inc]['record'] = $row;

			if(!isset($this->UserDetails[$row['user_id']]))
				$this->getUserDetail('user_id',$row['user_id'], 'user_name');
            $showBlogSearchList_arr[$inc]['name'] = $this->getUserDetail('user_id',$row['user_id'], 'user_name');
			$showBlogSearchList_arr[$inc]['blog_name'] = $row['blog_name'];
			$showBlogSearchList_arr[$inc]['view_blog_link'] = getUrl('viewblog', '?blog_name='.$row['blog_name'], $row['blog_name'].'/', '', 'blog');
			$showBlogSearchList_arr[$inc]['member_profile_url'] =getMemberProfileUrl($row['user_id'], $row['user_name']);
			$showBlogSearchList_arr[$inc]['postList_arr'] = $this->populateRecentPost($row['blog_id']);
			$inc++;
		}

		   $smartyObj->assign('showBlogSearchList_arr', $showBlogSearchList_arr);
	}
	public function populateRecentPost($blog_id)
	 {
		$recentPost = array();
		$recentPost['record_count'] = false;

	    $userCondition = 'bp.user_id = '.  $this->CFG['user']['user_id'] . ' OR bp.blog_access_type = \'Public\'' . $this->getAdditionalQuery('bp.');

	   	$sql  = 'SELECT b.blog_id,b.blog_name, bp.message, bp.blog_post_id,bp.user_id, bp.blog_access_type,'.
		         'DATE_FORMAT(bp.date_of_publish, "%d %b %Y") as published_date,
				  bp.relation_id, bp.blog_post_name, bp.date_added, NOW() as date_current, bp.total_favorites,
				  DATE_FORMAT(bp.date_added, "%d %b %Y") as added_date, bp.total_views, (bp.rating_total/bp.rating_count) as rating,
				  blog_tags, status, TIMEDIFF(NOW(), last_view_date) as blog_last_view_date, total_comments,bc.blog_category_name '.
				 ' FROM '.$this->CFG['db']['tbl']['blogs'] . ' AS b '.
				 ' JOIN '.$this->CFG['db']['tbl']['blog_posts'].' AS bp ON b.blog_id = bp.blog_id'.
				 ' JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON bp.user_id = u.user_id'.
				 ' JOIN '.$this->CFG['db']['tbl']['blog_category'].' AS bc ON bc.blog_category_id =bp.blog_category_id'.'  '.
			     ' WHERE b.blog_id='.$blog_id.' AND bp.status=\'Ok\' AND b.blog_status=\'Active\' AND u.usr_status=\'Ok\''.
				 $this->getAdultQuery('bp.', 'blog').' AND ( ' . $userCondition . ' )'.
				 ' ORDER BY  bp.date_added DESC LIMIT 0,1' ;

		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt);
		if (!$rs)
				trigger_db_error($this->dbObj);
		$inc = 0;
		if($postDetail = $rs->FetchRow())
			{
				$recentPost['record_count'] = true;
				$postDetail['date_added'] = $this->getDateTimeDiff($postDetail['date_added'],$postDetail['date_current']);
				$postDetail['date_added'] = ($postDetail['date_added'] != '') ? getTimeDiffernceFormat($postDetail['date_added']) : '';
			    $recentPost['record'] = $postDetail;
			    $recentPost['message']=truncateByCheckingHtmlTags($postDetail['message'],$this->CFG['admin']['blog']['blog_post_list_message_total_length'],'...',true,true);
			    //$recentPost['message']=wordWrap_mb_Manual($postDetail['message'],$this->CFG['admin']['blog']['blog_post_list_message_length'],$this->CFG['admin']['blog']['blog_post_list_message_total_length']);
			    $recentPost['view_blog_post_link'] = getUrl('viewpost', '?blog_post_id='.$postDetail['blog_post_id'].'&amp;title='.$this->changeTitle($postDetail['blog_post_name']), $postDetail['blog_post_id'].'/'.$this->changeTitle($postDetail['blog_post_name']).'/', '', 'blog');
			    $recentPost['blog_category_name_manual'] = wordWrap_mb_Manual($postDetail['blog_category_name'], $this->CFG['admin']['blog']['blog_list_category_title'], $this->CFG['admin']['blog']['blog_list_category_title_total_length'], 0);
			}
		return $recentPost;
	 }
	 public function populateRatingDetails($rating)
	 {
		$rating = round($rating,0);
		return $rating;
	 }
	/**
	 * BlogSearchList::chkAdvanceResultFound()
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
$BlogSearchList = new BlogSearchList();

if(!chkAllowedModule(array('blog')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$BlogSearchList->setPageBlockNames(array('block_blog_list_form'));
//default form fields and values...
$BlogSearchList->setFormField('blog_id', '');
$BlogSearchList->setFormField('blog_post_id', '');
$BlogSearchList->setFormField('user_id', '0');
$BlogSearchList->setFormField('action', '');
$BlogSearchList->setFormField('blog_name_keywords', '');
$BlogSearchList->setFormField('post_owner', '');
$BlogSearchList->setFormField('advanceFromSubmission', '');
/*********** Page Navigation Start *********/
$BlogSearchList->setFormField('start', '0');
$BlogSearchList->setFormField('slno', '1');
$BlogSearchList->setFormField('msg', '');
$BlogSearchList->setFormField('numpg', $CFG['blog_tbl']['numpg']);


$BlogSearchList->setMinRecordSelectLimit($CFG['data_tbl']['min_record_select_limit']);
$BlogSearchList->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$BlogSearchList->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$BlogSearchList->setTableNames(array());
$BlogSearchList->setReturnColumns(array());
$BlogSearchList->sanitizeFormInputs($_REQUEST);

/************ page Navigation stop *************/
$BlogSearchList->setAllPageBlocksHide();
$BlogSearchList->setPageBlockShow('block_blog_list_form');
if($BlogSearchList->getFormField('msg'))
{
$BlogSearchList->setCommonErrorMsg($LANG['bloglist_invalid_blog_id']);
$BlogSearchList->setPageBlockShow('block_msg_form_error');
}

$start = $BlogSearchList->getFormField('start');

if ($BlogSearchList->isPageGETed($_GET, 'action'))
{
	$BlogSearchList->sanitizeFormInputs($_GET);
}

//<<<<<-------------------- Code ends----------------------//
setPageTitle($BlogSearchList->LANG['bloglist_title']);
setMetaKeywords('Blog List');
setMetaDescription('Blog List');

if ($BlogSearchList->isShowPageBlock('block_blog_list_form'))
{
	/****** navigtion continue*********/
	$BlogSearchList->setTableAndColumns();
	$BlogSearchList->buildSelectQuery();
	$BlogSearchList->buildQuery();
	//$BlogSearchList->printQuery();
	$BlogSearchList->executeQuery();

	$BlogSearchList->anchor = 'anchor';
    $paging_arr = array('start','user_id','action','advanceFromSubmission');
	$smartyObj->assign('paging_arr',$paging_arr);
	if($BlogSearchList->isResultsFound())
	{
		$paging_arr = array('start', 'user_id', 'action', 'advanceFromSubmission');
		$smartyObj->assign('paging_arr',$paging_arr);
		$smartyObj->assign('smarty_paging_list', $BlogSearchList->populatePageLinksPOST($BlogSearchList->getFormField('start'), 'seachAdvancedFilter'));
		$BlogSearchList->my_posts_form['showBlogSearchList'] = $BlogSearchList->showBlogSearchList();
	}
	/******* Navigation End ********/
}

//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$BlogSearchList->includeHeader();
//include the content of the page
?>
<script type="text/javascript">
	var form_name_array = new Array('seachAdvancedFilter');
	function clearValue(id)
	{
		$Jq('#'+id).val('');
	}
	function setOldValue(id)
	{
		if (($Jq('#'+id).val()=="") && (id == 'post_owner') )
			$Jq('#'+id).val('<?php echo $LANG['bloglist_post_created_by']?>');
		if (($Jq('#'+id).val()=="") && (id == 'blog_name_keywords') )
			$Jq('#'+id).val('<?php echo $LANG['bloglist_keyword_field']?>');
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
$smartyObj->display('blogSearchList.tpl');
$BlogSearchList->includeFooter();
?>