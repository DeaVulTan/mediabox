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
class indexPostList extends BlogHandler
{
	public $UserDetails = array();
	public $advanceSearch;

	/**
	 * indexPostList::setTableAndColumns()
	 *
	 * @return void
	 */
	public function setTableAndColumns()
	{

		$this->setTableNames(array($this->CFG['db']['tbl']['blogs'] . ' AS b '.' JOIN '.$this->CFG['db']['tbl']['blog_posts'].' AS bp ON b.blog_id = bp.blog_id JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON bp.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['blog_category'].' AS bc ON bc.blog_category_id =bp.blog_category_id'));
		$this->setReturnColumns(array('b.blog_id,b.blog_name, bp.message', 'bp.blog_post_id','bp.user_id', 'bp.blog_access_type', 'DATE_FORMAT(bp.date_of_publish, "%d %b %Y") as published_date',
									  'bp.relation_id', 'bp.blog_post_name', 'bp.date_added', 'NOW() as date_current', 'bp.total_favorites','b.width','b.height',
									  'DATE_FORMAT(bp.date_added, "%d %b %Y") as added_date', 'bp.total_views', '(bp.rating_total/bp.rating_count) as rating',
									  'blog_tags', 'status', 'TIMEDIFF(NOW(), last_view_date) as blog_last_view_date', 'total_comments',
									  'bc.blog_category_name'));

		$userCondition = 'bp.user_id = '.  $this->CFG['user']['user_id'] . ' OR bp.blog_access_type = \'Public\'' . $this->getAdditionalQuery('bp.');

		$this->sql_condition = 'bp.status=\'Ok\' AND b.blog_status=\'Active\' AND u.usr_status=\'Ok\''.$this->getAdultQuery('bp.', 'blog').' AND ( ' . $userCondition . ' ) ';
		$this->sql_sort = 'bp.date_added DESC';


	}

	/**
	 * indexPostList::showindexPostList()
	 *
	 * @return void
	 */
	public function showindexPostList()
	{
		global $smartyObj;
		$showindexPostList_arr = array();
		//for tags
		$showindexPostList_arr['separator'] = ':&nbsp;';
		$tag = $this->_parse_tags(strtolower($this->fields_arr['tags']));
		$relatedTags = array();

		$blogPerRow = $this->CFG['admin']['blog']['list_per_line_total_blog_post'];

		$count = 0;
		$found = false;

		$fields_list = array('user_name', 'first_name', 'last_name');
		$blogPostTags = array();
		$showindexPostList_arr['row'] = array();
		$inc = 1;
		while($row = $this->fetchResultRecord())
	    {
	        $showindexPostList_arr['row'][$inc]['user_id'] = $row['user_id'];

			//To Display the number of days blog post added
			$row['date_added'] = ($row['date_added'] != '') ? getTimeDiffernceFormat($row['date_added']) : '';
			$row['blog_last_view_date'] = ($row['blog_last_view_date'] != '') ? getTimeDiffernceFormat($row['blog_last_view_date']) : '';

			//To Display Blog Post's Added Date in DD MMM YYYY (01 Jan 2009) Format
			$row['date_added'] = $row['added_date'];
			$row['date_published'] = $row['published_date'];
			$showindexPostList_arr['row'][$inc]['record'] = $row;

			if(!isset($this->UserDetails[$row['user_id']]))
				$this->getUserDetail('user_id',$row['user_id'], 'user_name');

			$showindexPostList_arr['row'][$inc]['name'] = $this->getUserDetail('user_id',$row['user_id'], 'user_name');
			$showindexPostList_arr['row'][$inc]['view_blog_post_link'] = getUrl('viewpost', '?blog_post_id='.$row['blog_post_id'].'&amp;title='.$this->changeTitle($row['blog_post_name']), $row['blog_post_id'].'/'.$this->changeTitle($row['blog_post_name']).'/', '', 'blog');

			$view_blog_post_page_arr = array('myblogpost', 'userblogpostlist');

			if(in_array($this->fields_arr['pg'], $view_blog_post_page_arr))
				$showindexPostList_arr['row'][$inc]['view_blog_post_link'] = getUrl('viewpost', '?blog_post_id='.$row['blog_post_id'].'&amp;title='.$this->changeTitle($row['blog_post_name']), $row['blog_post_id'].'/'.$this->changeTitle($row['blog_post_name']).'/', '', 'blog');

			$found = true;
			$showindexPostList_arr['row'][$inc]['open_tr'] = false;
			if ($count%$blogPerRow==0)
	    	{
				$showindexPostList_arr['row'][$inc]['open_tr'] = false;
	    	}
			$showindexPostList_arr['row'][$inc]['anchor'] = 'dAlt_'.$row['blog_post_id'];

			if($row['status']=='Locked')
			{
				$showindexPostList_arr['row'][$inc]['row_blog_post_name_manual'] =$row['blog_post_name'];

				$showindexPostList_arr['row'][$inc]['blog_post_ids_checked'] = '';
			}
			else
			{
				$showindexPostList_arr['row'][$inc]['blog_post_posting_url_ok'] = getUrl('manageblogpost', '?blog_post_id='.$row['blog_post_id'], $row['blog_post_id'].'/', '', 'blog');

				$showindexPostList_arr['row'][$inc]['row_blog_post_name_manual'] = $row['blog_post_name'];

				$showindexPostList_arr['row'][$inc]['row_blog_category_name_manual'] = $row['blog_category_name'];
				$user_name=$this->getUserDetail('user_id',$row['user_id'], 'user_name');
				$showindexPostList_arr['row'][$inc]['userDetails'] = $user_name;
				$showindexPostList_arr['row'][$inc]['member_profile_url'] = getMemberProfileUrl($row['user_id'], $user_name);
				//$showindexPostList_arr['row'][$inc]['message']=wordWrap_mb_Manual($row['message'],$this->CFG['admin']['blog']['blog_post_list_message_length'],$this->CFG['admin']['blog']['blog_post_list_message_total_length']);
				$showindexPostList_arr['row'][$inc]['message']=strip_selected_blog_tags(truncateByCheckingHtmlTags($row['message'],$this->CFG['admin']['blog']['blog_post_list_message_total_length'],'...',true,true));
				$showindexPostList_arr['row'][$inc]['profileIcon']=getMemberAvatarDetails($row['user_id']);
				$showindexPostList_arr['row'][$inc]['width']=$row['width'];
				$showindexPostList_arr['row'][$inc]['height']=$row['height'];
				$showindexPostList_arr['row'][$inc]['view_blog_link']=getUrl('viewblog', '?blog_name='.$row['blog_name'], $row['blog_name'].'/', '', 'blog');
				$tags= $this->_parse_tags($row['blog_tags']);
				$showindexPostList_arr['row'][$inc]['tags'] = $tags;
				$search_word='';
				if ($tags)
			    {
			    	$showindexPostList_arr['row'][$inc]['tags_arr'] = array();
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

						$showindexPostList_arr['row'][$inc]['tags_arr'][$i]['url'] = getUrl('blogpostlist', '?pg=postnew&amp;tags='.$value, 'postnew/?tags='.$value, '', 'blog');
						$showindexPostList_arr['row'][$inc]['tags_arr'][$i]['value'] = highlightWords($value, $search_word);
						$i++;
					}
				 }
			}
			$count++;
			$showindexPostList_arr['row'][$inc]['end_tr'] = false;
			if ($count%$blogPerRow==0)
		    {
				$count = 0;
				$showindexPostList_arr['row'][$inc]['end_tr'] = true;
	    	}
		    $inc++;
		}// end while

		$showindexPostList_arr['extra_td_tr'] = '';
		if ($found and $count and $count<$blogPerRow)
	    {
	    	$colspan = $blogPerRow-$count;
			$showindexPostList_arr['extra_td_tr'] = '<td colspan="'.$colspan.'">&nbsp;</td></tr>';
	    }

		$smartyObj->assign('showindexPostList_arr', $showindexPostList_arr);
	}
	public function populateRatingDetails($rating)
	{
		$rating = round($rating,0);
		return $rating;
	}
	/**
	 * indexPostList::myHomeActivity()
	 *
	 * @return
	 */
	public function myHomeActivity()
	{
		global $smartyObj;
		setTemplateFolder('members/');
		$smartyObj->display('myHomeActivity.tpl');
	}
}
//-------------------- Code begins -------------->>>>>//
$indexPostList = new indexPostList();

if(!chkAllowedModule(array('blog')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$indexPostList->setPageBlockNames(array('my_posts_form', 'delete_confirm_form', 'form_show_sub_category','sidebar_activity_block'));
//default form fields and values...
$indexPostList->setFormField('blog_post_id', '');
$indexPostList->setFormField('blog_post_name', '');
$indexPostList->setFormField('blog_tags', '');
$indexPostList->setFormField('action', '');
$indexPostList->setFormField('action_new', '');
$indexPostList->setFormField('act', '');
$indexPostList->setFormField('pg', '');
$indexPostList->setFormField('cid', '');
$indexPostList->setFormField('sid', '');
$indexPostList->setFormField('tags', '');
$indexPostList->setFormField('user_id', '0');
$indexPostList->setFormField('default', 'Yes');
$indexPostList->setFormField('advanceFromSubmission', '');
$indexPostList->setFormField('msg', '');
/*********** Page Navigation Start *********/
$indexPostList->setFormField('start', '0');
$indexPostList->setFormField('slno', '1');
$indexPostList->setFormField('blog_post_ids', array());
$indexPostList->setFormField('numpg', $CFG['blog_tbl']['numpg']);
$indexPostList->setFormField('activity_type', '');


$indexPostList->setMinRecordSelectLimit($CFG['data_tbl']['min_record_select_limit']);
$indexPostList->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$indexPostList->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$indexPostList->setTableNames(array());
$indexPostList->setReturnColumns(array());
$indexPostList->sanitizeFormInputs($_REQUEST);
/************ page Navigation stop *************/
$indexPostList->setAllPageBlocksHide();
$indexPostList->setPageBlockShow('my_posts_form');


if($indexPostList->isFormPOSTed($_POST, 'yes'))
{
	if($indexPostList->getFormField('act')=='delete')
	{
		$blog_posts_arr = explode(',',$indexPostList->getFormField('blog_post_id'));
		$indexPostList->deleteBlogPosts($blog_posts_arr, $CFG['user']['user_id']);
		$indexPostList->setCommonSuccessMsg($LANG['index_delete_success_msg_confirmation']);
		$indexPostList->setPageBlockShow('block_msg_form_success');
	}
}


//<<<<<-------------------- Code ends----------------------//
setPageTitle($indexPostList->LANG['index_title']);
setMetaKeywords('Blog Post List');
setMetaDescription('Blog Post List');

$indexPostList->category_name = '';
if ($indexPostList->isShowPageBlock('my_posts_form'))
{
	/****** navigtion continue*********/
	$indexPostList->setTableAndColumns();
	$indexPostList->buildSelectQuery();
	$indexPostList->buildQuery();
	//$indexPostList->printQuery();
	$indexPostList->executeQuery();
	$indexPostList->anchor = 'anchor';
	$paging_arr = array('start');
	$smartyObj->assign('paging_arr',$paging_arr);
	if($indexPostList->isResultsFound())
	{

		$paging_arr = array('start');
		$smartyObj->assign('paging_arr',$paging_arr);
		$smartyObj->assign('smarty_paging_list', $indexPostList->populatePageLinksPOST($indexPostList->getFormField('start'), 'seachAdvancedFilter'));
		$indexPostList->my_posts_form['showindexPostList'] = $indexPostList->showindexPostList();
	}
	/******* Navigation End ********/
}


if(!isAjaxPage())
{
	if(isMember())
	{
		$indexPostList->setPageBlockShow('sidebar_activity_block');
	}
}
else
{
	$indexPostList->sanitizeFormInputs($_REQUEST);
	$indexPostList->includeAjaxHeaderSessionCheck();
	if($indexPostList->getFormField('activity_type')!= '')
	{
		if($indexPostList->getFormField('activity_type') == 'Friends' and !$indexPostList->getTotalFriends($CFG['user']['user_id']))
		{
			echo '<div class="clsNoRecordsFound">'.$LANG['index_activities_no_friends'].'</div>';
			exit;
		}
		$activity_view_all_url = getUrl('activity', '?pg='.strtolower($indexPostList->getFormField('activity_type')), strtolower($indexPostList->getFormField('activity_type')).'/updates/', '');
		$smartyObj->assign('activity_view_all_url', $activity_view_all_url);
		$Activity = new ActivityHandler();
		$Activity->setActivityType(strtolower($indexPostList->getFormField('activity_type')), 'blog');
		$indexPostList->myHomeActivity();
	}
	$indexPostList->includeAjaxFooter();
	die();
}
//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$indexPostList->includeHeader();
?>
<script type="text/javascript">
	var form_name_array = new Array('seachAdvancedFilter');
	var block_arr= new Array('selMsgConfirm','selEditPostComments');
</script>
<?php
//include the content of the page
setTemplateFolder('general/', 'blog');
$smartyObj->display('index.tpl');
?>
<script type="text/javascript" >
var blog_activity_array = new Array('My', 'Friends', 'All');
var blog_index_ajax_url = '<?php echo $CFG['site']['blog_url'].'index.php';?>';

// Blog Activity Default Setting
<?php
if(isMember())
{
?>
	loadActivitySetting('<?php echo $CFG['admin']['blog']['blog_activity_default_content'];?>');
<?php
}
?>
</script>
<?php
//includ the footer of the page
$indexPostList->includeFooter();
?>