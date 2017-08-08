<?php
/**
 * This file is to display the blog
 *
 * This file is having viewBlog class to view the blog
 *
 *
 * @category	Rayzz
 * @package		Index
 */
require_once('../common/configs/config.inc.php');
$CFG['site']['is_module_page'] = 'blog';
$CFG['lang']['include_files'][] = 'languages/%s/blog/rssBlog.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_BlogHandler.lib.php';
$CFG['html']['header'] = 'blog/general/html_header_for_post.php';
$CFG['html']['footer'] = 'blog/general/html_footer_for_post.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = false;
require($CFG['site']['project_path'].'common/application_top.inc.php');

class ViewBlog extends BlogHandler
{
	public function chkValidBlog()
	{
		    $sql = 'SELECT blog_id,blog_name,blog_title, blog_slogan, user_id,blog_logo_ext FROM '.$this->CFG['db']['tbl']['blogs'].
				' WHERE blog_name='.$this->dbObj->Param('blog_name').
				' AND blog_status=\'Active\'';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_name']));
			if (!$rs)
				trigger_db_error($this->dbObj);
		     $fields_list = array('user_name', 'first_name', 'last_name');
			if($row = $rs->FetchRow())
			    {
			     if(!isset($this->UserDetails[$row['user_id']]))
					$this->getUserDetail('user_id',$row['user_id'], 'user_name');
				  $this->fields_arr['user_id']=$row['user_id'];
				  $this->fields_arr['blog_id']=$row['blog_id'];
				}
			  	 return true;
			return false;
	}
	public function setTableAndColumns()
	{
		$this->setTableNames(array($this->CFG['db']['tbl']['blog_posts'].' AS bp JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON bp.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['blog_category'].' AS bc ON bc.blog_category_id =bp.blog_category_id'));
		$this->setReturnColumns(array('bp.message', 'bp.blog_post_id','bp.user_id', 'bp.blog_access_type', 'DATE_FORMAT(bp.date_of_publish, "%d %b %Y") as published_date',
									  'bp.relation_id', 'bp.blog_post_name', 'bp.date_added', 'NOW() as date_current', 'bp.total_favorites',
									  'DATE_FORMAT(bp.date_added, "%d %b %Y") as added_date', 'bp.total_views', '(bp.rating_total/bp.rating_count) as rating',
									  'blog_tags', 'status', 'TIMEDIFF(NOW(), last_view_date) as blog_last_view_date', 'total_comments',
									  'bc.blog_category_name'));
		$additional_query = '';
		if(isset($_SESSION['user']['user_id'])!='')
		$userCondition = 'bp.user_id = '.  $_SESSION['user']['user_id'] . ' OR bp.blog_access_type = \'Public\'' . $this->getAdditionalQuery('bp.');
        else
        $userCondition = ' bp.blog_access_type = \'Public\'' . $this->getAdditionalQuery('bp.');

		$this->sql_condition = $additional_query.'bp.blog_id='.$this->fields_arr['blog_id'].' AND bp.status=\'Ok\' AND u.usr_status=\'Ok\''.$this->getAdultQuery('bp.', 'blog').' AND ( ' . $userCondition. ' ) ';
		$this->sql_sort = 'bp.date_added DESC';
	}
	public function showBlogDetails()
	{
		global $smartyObj;
		$showBlogDetail_arr = array();
		$relatedTags = array();
		$blogPostTags = array();
		//$tag = $this->_parse_tags(strtolower($this->fields_arr['tags']));
		$inc=0;
		$fields_list = array('user_name', 'first_name', 'last_name');
		$user_name=$this->getUserDetail('user_id',$this->fields_arr['user_id'], 'user_name');
		$pg_title = str_replace('{user_name}',$user_name, $this->LANG['rssblog_title']);
		echo '<?xml version="1.0" encoding="UTF-8" ?>';
		?>
		<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/">
		<channel>
		<title><?php echo $this->CFG['site']['title'];?> :: <?php echo $pg_title;?></title>
		<link><?php echo $this->CFG['site']['url'].'rss/'.$user_name.'.rss';?></link>
		<description><?php echo$pg_title;?></description>
		<?php
		while($row = $this->fetchResultRecord())
		    {

	    		//Rss Fix
				foreach($row as $key => &$eachRow)
				{
					//$row[$key] = htmlentities($eachRow, ENT_QUOTES, "UTF-8");
				}

		    	if(!isset($this->UserDetails[$row['user_id']]))
			    	$this->getUserDetail('user_id',$row['user_id'], 'user_name');

		    	$row['date_added'] = ($row['date_added'] != '') ? getTimeDiffernceFormat($row['date_added']) : '';
		    	$name = 	$this->getUserDetail('user_id',$row['user_id'], 'user_name');
		    	?>
				<item>
					<author><?php echo $this->CFG['site']['noreply_email'];?> (<?php echo $name;?>)</author>
					<title>
					<?php echo htmlspecialchars($row['blog_post_name']); ?>
					</title>
					<link>
			        <?php echo getUrl('viewpost', '?blog_post_id='.$row['blog_post_id'].'&amp;title='.$this->changeTitle($row['blog_post_name']), $row['blog_post_id'].'/'.$this->changeTitle($row['blog_post_name']).'/', '', 'blog');?>
			        </link>
			        <description>
					   <![CDATA[
					   <?php echo  $row['message'];
					   ?>
					    <p>
						<?php echo $this->LANG['rssblog_author'];?> <a href="<?php echo getMemberProfileUrl($row['user_id'], $name);?>"><?php echo $name;?></a><br/>
						<?php echo $this->LANG['rssblog_added'];?> <?php echo $row['date_added'];?><br/>
						</p>
					   ]]>
			        </description>
			        <guid isPermaLink="true"><?php echo getUrl('viewpost', '?blog_post_id='.$row['blog_post_id'].'&amp;title='.$this->changeTitle($row['blog_post_name']), $row['blog_post_id'].'/'.$this->changeTitle($row['blog_post_name']).'/', '', 'blog');?></guid>
			        <pubDate><?php echo $row['date_added'];?></pubDate>
			        <media:category label="Tags">
					<![CDATA[
					<?php echo $row['blog_tags']; ?>
					]]>
					</media:category>
					<media:credit><?php echo $name;?></media:credit>
				</item>
				<?php
			    $inc++;//end
		    }?>
</channel>
</rss>
<?php
	}
}
$ViewBlog = new ViewBlog();
if(!chkAllowedModule(array('blog')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$ViewBlog->setFormField('blog_name', '');
$ViewBlog->setFormField('blog_id', '');
$ViewBlog->setFormField('user_id', '');
$ViewBlog->sanitizeFormInputs($_REQUEST);

if(!$ViewBlog->chkValidBlog())
  Redirect2URL(getUrl('bloglist','?msg=1','?msg=1','','blog'));

$ViewBlog->setTableAndColumns();
$ViewBlog->buildSelectQuery();
$ViewBlog->buildQuery();
$ViewBlog->executeQuery();
$ViewBlog->showBlogDetails();
?>