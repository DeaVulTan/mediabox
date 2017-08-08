<?php
/**
 * This class is used to RSS Photo
 *
 * @category	Rayzz
 * @package		RSS Photo
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 */
require_once('../../common/configs/config.inc.php');
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/rssFeed.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['auth']['is_authenticate'] = false;
require($CFG['site']['project_path'].'common/application_top.inc.php');
/**
* This class handles rss photo
*
* @category	RAYZZ
* @package		rss
*/
class PhotoNew extends MediaHandler
{
	/**
	* PhotoNew::buildSortQuery()
	* To disply the query
	* @return void
	* @access bublic
	**/
	public function buildSortQuery()
	{
		$this->sql_sort = 'v.photo_id DESC';
	}
	/**
	* PhotoNew::populateKeywords()
	* To ppopulate keywords
	* @param $tags photo tag
	* @return void
	* @access public
	**/
	public function populateKeywords($tags)
	{
		$tags_arr = explode(' ',$tags);
		$length = sizeof($tags_arr);
		$i = 1;
		foreach($tags_arr as $tags)
		{
			?>
			<a href="<?php echo getUrl('photolist','?pg=photonew&tags='.$tags,'photonew/?tags='.$tags, 'root', 'photo');?>"><?php echo $tags;?></a>&nbsp;
			<?php
		}
	}
	/**
	* PhotoNew::chkValidFile()
	* To check valid input
	* @return boolean
	* @access public
	**/
	public function chkValidFile()
	{
		$valid_arr = array('recentlyAdded', 'topFavorites', 'topRated', 'todayMostViewed', 'yesterdayMostViewed', 'thisWeekMostViewed',
		'thisMonthMostViewed', 'thisYearMostViewed', 'mostViewed', 'todayMostDiscussed', 'yesterdayMostDiscussed',
		'thisWeekMostDiscussed', 'thisMonthMostDiscussed', 'thisYearMostDiscussed',
		'mostDiscussed',);
		if(in_array($this->fields_arr['pg'], $valid_arr))
		return true;
		return false;
	}
	/**
	* PhotoNew::getRssResource()
	* To get the vido details as per condition
	* @return array
	* @access public
	**/
	public function getRssResource()
	{
		$fields_arr = array('(v.rating_total/v.rating_count) as rating','v.photo_id','v.user_id', 'v.photo_title', 'v.photo_server_url','v.photo_ext',
								'TIMEDIFF(NOW(), v.date_added) as date_added', 'v.total_views', 'v.photo_tags');
		//$sql = 'SELECT '.implode(',', $fields_arr).' FROM '.$this->CFG['db']['tbl']['photo'].' AS v JOIN '.$this->CFG['db']['tbl']['users'].' as u on v.user_id = u.user_id  JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON (pa.photo_album_id =v.photo_album_id OR v.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =v.photo_category_id ';
		switch($this->fields_arr['pg'])
		{
			case 'recentlyAdded':
				$sql = 'SELECT '.implode(',', $fields_arr).' FROM '.$this->CFG['db']['tbl']['photo'].' AS v JOIN '.$this->CFG['db']['tbl']['users'].' as u on v.user_id = u.user_id  JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON (pa.photo_album_id =v.photo_album_id OR v.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =v.photo_category_id ';
				$sql .= 'WHERE (v.photo_access_type=\'Public\' OR v.user_id = '.$this->CFG['user']['user_id'] .' ) AND v.photo_status=\'Ok\' AND u.usr_status=\'Ok\' ' . $this->getAdultQuery('v.', 'photo'). ' GROUP BY v.photo_id ORDER BY v.date_added DESC';
			break;
			case 'topFavorites':
				$sql = 'SELECT '.implode(',', $fields_arr).' FROM '.$this->CFG['db']['tbl']['photo'].' AS v JOIN photo_favorite AS pf ON v.photo_id = pf.photo_id  JOIN '.$this->CFG['db']['tbl']['users'].' as u on v.user_id = u.user_id  JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON (pa.photo_album_id =v.photo_album_id OR v.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =v.photo_category_id ';
				$sql .= 'WHERE v.photo_access_type=\'Public\' AND v.photo_status=\'Ok\' AND u.usr_status=\'Ok\' ' . $this->getAdultQuery('v.', 'photo'). ' GROUP BY pf.photo_id ORDER BY v.total_views DESC';
			break;
			case 'topRated':
				$sql = 'SELECT '.implode(',', $fields_arr).' FROM '.$this->CFG['db']['tbl']['photo'].' AS v JOIN '.$this->CFG['db']['tbl']['users'].' as u on v.user_id = u.user_id  JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON (pa.photo_album_id =v.photo_album_id OR v.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =v.photo_category_id ';
				$sql .= 'WHERE (v.photo_access_type=\'Public\' OR v.user_id = '.$this->CFG['user']['user_id'] .' ) AND v.photo_status=\'Ok\' AND u.usr_status=\'Ok\' ' . $this->getAdultQuery('v.', 'photo'). ' AND v.rating_total>0 GROUP BY v.photo_id ORDER BY rating DESC';
			break;
			case 'todayMostViewed':
				$sql = 'SELECT '.implode(',', $fields_arr).',SUM(vp.total_views) as sum_total_views, vp.total_views as individual_total_views FROM '.$this->CFG['db']['tbl']['photo_viewed'].' as vp JOIN '.$this->CFG['db']['tbl']['photo'].' as v On v.photo_id = vp.photo_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON (pa.photo_album_id =v.photo_album_id OR v.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =v.photo_category_id ' ;
				$sql .= ' WHERE DATE_FORMAT(vp.view_date,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\') AND v.total_views>0 AND v.photo_access_type=\'Public\' AND v.photo_status=\'Ok\' ' . $this->getAdultQuery('v.', 'photo'). ' AND u.usr_status=\'Ok\'  Group By vp.photo_id ORDER BY sum_total_views DESC';
			break;
			case 'yesterdayMostViewed':
				$sql = 'SELECT '.implode(',', $fields_arr).',SUM(vp.total_views) as sum_total_views, vp.total_views as individual_total_views FROM '.$this->CFG['db']['tbl']['photo_viewed'].' as vp JOIN '.$this->CFG['db']['tbl']['photo'].' as v On v.photo_id = vp.photo_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON (pa.photo_album_id =v.photo_album_id OR v.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =v.photo_category_id ';
				$sql .= ' WHERE DATE_FORMAT(view_date,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\') AND v.total_views>0 AND v.photo_access_type=\'Public\' AND v.photo_status=\'Ok\'' . $this->getAdultQuery('v.', 'photo'). ' AND u.usr_status=\'Ok\'  Group By vp.photo_id ORDER BY sum_total_views DESC';
			break;
			case 'thisWeekMostViewed':
				$sql = 'SELECT '.implode(',', $fields_arr).',SUM(vp.total_views) as sum_total_views, vp.total_views as individual_total_views FROM '.$this->CFG['db']['tbl']['photo_viewed'].' as vp JOIN '.$this->CFG['db']['tbl']['photo'].' as v On v.photo_id = vp.photo_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON (pa.photo_album_id =v.photo_album_id OR v.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =v.photo_category_id ';
				$sql .= ' WHERE DATE_FORMAT(view_date,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\') AND v.total_views>0 AND v.photo_access_type=\'Public\' AND v.photo_status=\'Ok\' ' . $this->getAdultQuery('v.', 'photo'). ' AND u.usr_status=\'Ok\'  Group By vp.photo_id ORDER BY sum_total_views DESC';
			break;
			case 'thisMonthMostViewed':
				$sql = 'SELECT '.implode(',', $fields_arr).',SUM(vp.total_views) as sum_total_views, vp.total_views as individual_total_views FROM '.$this->CFG['db']['tbl']['photo_viewed'].' as vp JOIN '.$this->CFG['db']['tbl']['photo'].' as v On v.photo_id = vp.photo_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON (pa.photo_album_id =v.photo_album_id OR v.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =v.photo_category_id ';
				$sql .= ' WHERE DATE_FORMAT(view_date,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\') AND v.total_views>0 AND v.photo_access_type=\'Public\' AND v.photo_status=\'Ok\' ' . $this->getAdultQuery('v.', 'photo'). ' AND u.usr_status=\'Ok\' Group By vp.photo_id ORDER BY sum_total_views DESC';
			break;
			case 'thisYearMostViewed':
				$sql = 'SELECT '.implode(',', $fields_arr).',SUM(vp.total_views) as sum_total_views, vp.total_views as individual_total_views FROM '.$this->CFG['db']['tbl']['photo_viewed'].' as vp JOIN '.$this->CFG['db']['tbl']['photo'].' as v On v.photo_id = vp.photo_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON (pa.photo_album_id =v.photo_album_id OR v.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =v.photo_category_id ';
				$sql .= ' WHERE DATE_FORMAT(view_date,\'%y\')=DATE_FORMAT(NOW(),\'%y\') AND v.total_views>0 AND v.photo_access_type=\'Public\' AND v.photo_status=\'Ok\' ' . $this->getAdultQuery('v.', 'photo'). ' AND u.usr_status=\'Ok\' Group By vp.photo_id ORDER BY sum_total_views DESC';
			break;
			case 'mostViewed':
				$sql = 'SELECT '.implode(',', $fields_arr).',SUM(vp.total_views) as sum_total_views, vp.total_views as individual_total_views FROM '.$this->CFG['db']['tbl']['photo_viewed'].' as vp JOIN '.$this->CFG['db']['tbl']['photo'].' as v On v.photo_id = vp.photo_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON (pa.photo_album_id =v.photo_album_id OR v.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =v.photo_category_id ';
				$sql .= ' WHERE v.total_views>0 AND v.photo_access_type=\'Public\' AND v.photo_status=\'Ok\' ' . $this->getAdultQuery('v.', 'photo'). ' AND u.usr_status=\'Ok\' Group By vp.photo_id ORDER BY sum_total_views DESC';
			break;
			case 'todayMostDiscussed':
				$sql = 'SELECT '.implode(',', $fields_arr).',SUM(1) as sum_total_comments FROM '.$this->CFG['db']['tbl']['photo_comments'].' as vp JOIN '.$this->CFG['db']['tbl']['photo'].' as v On v.photo_id = vp.photo_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON (pa.photo_album_id =v.photo_album_id OR v.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =v.photo_category_id ';
				$sql .= ' WHERE DATE_FORMAT(vp.date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\') AND v.total_comments>0 AND v.photo_access_type=\'Public\' AND v.photo_status=\'Ok\' ' . $this->getAdultQuery('v.', 'photo'). ' AND u.usr_status=\'Ok\' AND comment_status=\'Yes\' Group By vp.photo_id ORDER BY sum_total_comments DESC , total_views DESC';
			break;
			case 'yesterdayMostDiscussed':
				$sql = 'SELECT '.implode(',', $fields_arr).',SUM(1) as sum_total_comments FROM '.$this->CFG['db']['tbl']['photo_comments'].' as vp JOIN '.$this->CFG['db']['tbl']['photo'].' as v On v.photo_id = vp.photo_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON (pa.photo_album_id =v.photo_album_id OR v.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =v.photo_category_id ';
				$sql .= ' WHERE DATE_FORMAT(vp.date_added,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\') AND v.total_comments>0 AND v.photo_access_type=\'Public\' AND v.photo_status=\'Ok\' ' . $this->getAdultQuery('v.', 'photo'). ' AND u.usr_status=\'Ok\' AND comment_status=\'Yes\' Group By vp.photo_id ORDER BY sum_total_comments DESC , total_views DESC';
			break;
			case 'thisWeekMostDiscussed':
				$sql = 'SELECT '.implode(',', $fields_arr).',SUM(1) as sum_total_comments FROM '.$this->CFG['db']['tbl']['photo_comments'].' as vp JOIN '.$this->CFG['db']['tbl']['photo'].' as v On v.photo_id = vp.photo_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON (pa.photo_album_id =v.photo_album_id OR v.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =v.photo_category_id ';
				$sql .= ' WHERE DATE_FORMAT(vp.date_added,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\') AND v.total_comments>0 AND v.photo_access_type=\'Public\' AND v.photo_status=\'Ok\' ' . $this->getAdultQuery('v.', 'photo'). ' AND u.usr_status=\'Ok\' AND comment_status=\'Yes\'  Group By vp.photo_id ORDER BY sum_total_comments DESC , total_views DESC';
			break;
			case 'thisMonthMostDiscussed':
				$sql = 'SELECT '.implode(',', $fields_arr).',SUM(1) as sum_total_comments FROM '.$this->CFG['db']['tbl']['photo_comments'].' as vp JOIN '.$this->CFG['db']['tbl']['photo'].' as v On v.photo_id = vp.photo_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON (pa.photo_album_id =v.photo_album_id OR v.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =v.photo_category_id ';
				$sql .= ' WHERE DATE_FORMAT(vp.date_added,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\') AND v.total_comments>0 AND v.photo_access_type=\'Public\' AND v.photo_status=\'Ok\' ' . $this->getAdultQuery('v.', 'photo'). ' AND u.usr_status=\'Ok\' AND comment_status=\'Yes\' Group By vp.photo_id ORDER BY sum_total_comments DESC , total_views DESC';
			break;
			case 'thisYearMostDiscussed':
				$sql = 'SELECT '.implode(',', $fields_arr).',SUM(1) as sum_total_comments FROM '.$this->CFG['db']['tbl']['photo_comments'].' as vp JOIN '.$this->CFG['db']['tbl']['photo'].' as v On v.photo_id = vp.photo_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON (pa.photo_album_id =v.photo_album_id OR v.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =v.photo_category_id ';
				$sql .= ' WHERE DATE_FORMAT(vp.date_added,\'%y\')=DATE_FORMAT(NOW(),\'%y\') AND v.total_comments>0 AND v.photo_access_type=\'Public\' AND v.photo_status=\'Ok\' ' . $this->getAdultQuery('v.', 'photo'). ' AND u.usr_status=\'Ok\' AND comment_status=\'Yes\' Group By vp.photo_id ORDER BY sum_total_comments DESC , total_views DESC';
			break;
			case 'mostDiscussed':
				$sql = 'SELECT '.implode(',', $fields_arr).',SUM(1) as sum_total_comments FROM '.$this->CFG['db']['tbl']['photo_comments'].' as vp JOIN '.$this->CFG['db']['tbl']['photo'].' as v On v.photo_id = vp.photo_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa ON (pa.photo_album_id =v.photo_album_id OR v.photo_album_id=0 )'.' JOIN '.$this->CFG['db']['tbl']['photo_category'].' AS mc ON mc.photo_category_id =v.photo_category_id ';
				$sql .= ' WHERE v.total_comments>0 AND v.photo_access_type=\'Public\' AND v.photo_status=\'Ok\' ' . $this->getAdultQuery('v.', 'photo'). ' AND u.usr_status=\'Ok\' AND comment_status=\'Yes\' Group By vp.photo_id ORDER BY sum_total_comments DESC, total_views DESC';
			break;
		}
		$sql .= ' LIMIT 0,'.$this->CFG['admin']['photos']['rss_count'];
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
		trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		return $rs;
	}
	/**
	* PhotoNew::showPhotos()
	* To display the photo as xml format
	* @return void
	* @access public
	**/
	public function showPhotos()
	{
		$res = $this->getRssResource();
		$fields_list = array('user_name', 'first_name', 'last_name');
		$photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
		echo '<?xml version="1.0" encoding="UTF-8" ?>';
		?>
		<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/">
		<channel>
		<title><?php echo $this->CFG['site']['title'];?> :: <?php echo $this->LANG[$this->fields_arr['pg']];?></title>
		<link><?php echo $this->CFG['site']['url'].'rss/'.$this->fields_arr['pg'].'.rss';?></link>
		<description><?php echo $this->LANG[$this->fields_arr['pg'].'_title'];?></description>
		<?php
		while($row = $res->FetchRow())
		{
			//Rss Fix
			foreach($row as $key => &$eachRow)
			{
				$row[$key] = htmlentities($eachRow, ENT_QUOTES, "UTF-8");
			}
			//Rss Fix Ends here
			$row['date_added'] = ($row['date_added'] != '') ? getTimeDiffernceFormat($row['date_added']) : '';
			if(!isset($this->UserDetails[$row['user_id']]))
			$this->getUserDetails($row['user_id'], $fields_list);
			$name = $this->getUserName($row['user_id']);
			?>
			<item>
			<author><?php echo $this->CFG['site']['noreply_email'];?> (<?php echo $name;?>)</author>
			<title>
			<?php echo htmlspecialchars($row['photo_title']); ?>
			</title>
			<link>
			<?php echo getUrl('viewphoto', '?photo_id='.$row['photo_id'].'&amp;title='.$this->changeTitle($row['photo_title']), $row['photo_id'].'/'.$this->changeTitle($row['photo_title']).'/', 'root', 'photo');?>
			</link>
			<description>
			<![CDATA[
			<?php if($row['photo_ext']=='') { ?>
			<img src="<?php echo $this->CFG['site']['url'].'photo/design/templates/'.$this->CFG['html']['template']['default'] .' /root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_audio_T.jpg' ?>" align="right" border="0" width="120" height="90" vspace="4" hspace="4" />
			<?php } else {  ?> <img src="<?php echo $row['photo_server_url'].$photos_folder.getPhotoImageName($row['photo_id']).$this->CFG['admin']['photos']['thumb_name'].'.'.$row['photo_ext'];?>" align="right" border="0" width="120" height="90" vspace="4" hspace="4" />  <?php } ?>
			<p><?php echo $row['photo_title']; ?></p>
			<p>
			<?php echo $this->LANG['author'];?> <a href="<?php echo getMemberProfileUrl($row['user_id'], $name);?>"><?php echo $name;?></a><br/>
			<?php echo $this->LANG['keywords'];?> <?php $this->populateKeywords($row['photo_tags']);?><br/>
			<?php echo $this->LANG['added'];?> <?php echo $row['date_added'];?><br/>
			</p>
			]]>
			</description>
			<guid isPermaLink="true"><?php echo getUrl('viewphoto', '?photo_id='.$row['photo_id'].'&amp;title='.$this->changeTitle($row['photo_title']), $row['photo_id'].'/'.$this->changeTitle($row['photo_title']).'/', 'root', 'photo');?></guid>
			<pubDate><?php echo $row['date_added'];?></pubDate>
			<media:player url="<?php echo getUrl('viewphoto', '?photo_id='.$row['photo_id'].'&amp;title='.$this->changeTitle($row['photo_title']), $row['photo_id'].'/'.$this->changeTitle($row['photo_title']).'/', 'root', 'photo');?>" />
			<media:thumbnail url="<?php echo $row['photo_server_url'].$photos_folder.$row['photo_id'].$this->CFG['admin']['photos']['thumb_name'].'.'.$row['photo_ext'];?>" width="120" height="90" />
			<media:title type="html">
			<![CDATA[
			<?php echo htmlspecialchars($row['photo_title']); ?>
			]]>
			</media:title>
			<media:category label="Tags">
			<![CDATA[
			<?php echo $row['photo_tags']; ?>
			]]>
			</media:category>
			<media:credit><?php echo $name;?></media:credit>
			</item>
			<?php
		}
	?>
	</channel>
	</rss>
	<?php
	}
}
//<<<<<-------------- Class PhotoNew begins ---------------//
//-------------------- Code begins -------------->>>>>//
$PhotoNew = new PhotoNew();
$PhotoNew->setDBObject($db);
$PhotoNew->makeGlobalize($CFG,$LANG);
if(!chkAllowedModule(array('photo')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$PhotoNew->setFormField('pg', '');
$PhotoNew->sanitizeFormInputs($_GET);
if($PhotoNew->isFormGETed('pg') and $PhotoNew->chkValidFile())
{
	$PhotoNew->includeAjaxHeader();
	$PhotoNew->showPhotos();
	$PhotoNew->includeAjaxFooter();
}
?>