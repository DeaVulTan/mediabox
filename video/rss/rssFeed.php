<?php
/**
 * This file is to display the rss video
 *
 * This file is having VideoNew class to display the all videos
 *
 * @category	RAYZZ
 * @package		rss
 */
require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/root/rssFeed.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['auth']['is_authenticate'] = false;
require($CFG['site']['project_path'].'common/application_top.inc.php');
/**
 * This class handles rss video
 *
 * @category	RAYZZ
 * @package		rss
 */
class VideoNew extends MediaHandler
	{

		/**
		 * VideoNew::buildSortQuery()
		 * To disply the query
		 * @return void
		 * @access bublic
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = 'v.video_id DESC';
			}

		/**
		 * VideoNew::populateKeywords()
		 * To ppopulate keywords
		 * @param $tags video tag
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
<a href="<?php echo getUrl('videolist','?pg=videonew&tags='.$tags,'videonew/?tags='.$tags, 'root', 'video');?>"><?php echo $tags;?></a>&nbsp;
<?php
					}
			}

		/**
		 * VideoNew::chkValidFile()
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
		 * VideoNew::getRssResource()
		 * To get the vido details as per condition
		 * @return array
		 * @access public
		 **/
		public function getRssResource()
			{
				$fields_arr = array('playing_time','(v.rating_total/v.rating_count) as rating','v.video_id',
									'v.user_id', 'v.video_title', 'v.video_server_url', 'v.t_width', 'v.t_height',
									'TIMEDIFF(NOW(), v.date_added) as date_added', 'v.total_views', 'v.video_tags','file_name');

				$default_condition = ' AND v.is_external_embed_video=\'No\' ';

				$sql = 'SELECT '.implode(',', $fields_arr).' FROM '.$this->CFG['db']['tbl']['video'].' AS v JOIN '.$this->CFG['db']['tbl']['users'].' as u on v.user_id = u.user_id JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' AS VFS ON v.thumb_name_id = video_file_id ';

				switch($this->fields_arr['pg'])
					{
						case 'recentlyAdded':
							$sql .= 'WHERE v.video_access_type=\'Public\' AND v.video_status=\'Ok\' AND u.usr_status=\'Ok\''.$default_condition.
									' ORDER BY v.video_id DESC';
							break;

						case 'topFavorites':
							$sql .= 'WHERE v.video_access_type=\'Public\' AND v.video_status=\'Ok\' AND u.usr_status=\'Ok\''.$default_condition.
									' ORDER BY v.total_favorites DESC,total_views DESC';
							break;

						case 'topRated':
							$sql .= 'WHERE v.video_access_type=\'Public\' AND v.video_status=\'Ok\' AND u.usr_status=\'Ok\' AND v.rating_total>0'.$default_condition.
									' ORDER BY rating DESC';
							break;

						case 'todayMostViewed':

							$sql = 'SELECT '.implode(',', $fields_arr).',SUM(vp.total_views) as sum_total_views, vp.total_views as individual_total_views FROM '.$this->CFG['db']['tbl']['video_viewed'].' as vp JOIN '.$this->CFG['db']['tbl']['video'].' as v On v.video_id = vp.video_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' AS VFS ON video_file_id = thumb_name_id';

							$sql .= ' WHERE DATE_FORMAT(vp.view_date,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\') AND v.total_views>0 AND v.video_access_type=\'Public\' AND v.video_status=\'Ok\' AND u.usr_status=\'Ok\''.$default_condition.' Group By vp.video_id ORDER BY sum_total_views DESC';
							break;

						case 'yesterdayMostViewed':
							$sql = 'SELECT '.implode(',', $fields_arr).',SUM(vp.total_views) as sum_total_views, vp.total_views as individual_total_views FROM '.$this->CFG['db']['tbl']['video_viewed'].' as vp JOIN '.$this->CFG['db']['tbl']['video'].' as v On v.video_id = vp.video_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' AS VFS ON video_file_id = thumb_name_id';

							$sql .= ' WHERE DATE_FORMAT(view_date,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\') AND v.total_views>0 AND v.video_access_type=\'Public\' AND v.video_status=\'Ok\' AND u.usr_status=\'Ok\''.$default_condition.' Group By vp.video_id ORDER BY sum_total_views DESC';

							break;

						case 'thisWeekMostViewed':

							$sql = 'SELECT '.implode(',', $fields_arr).',SUM(vp.total_views) as sum_total_views, vp.total_views as individual_total_views FROM '.$this->CFG['db']['tbl']['video_viewed'].' as vp JOIN '.$this->CFG['db']['tbl']['video'].' as v On v.video_id = vp.video_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' AS VFS ON video_file_id = thumb_name_id';

							$sql .= ' WHERE DATE_FORMAT(view_date,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\') AND v.total_views>0 AND v.video_access_type=\'Public\' AND v.video_status=\'Ok\' AND u.usr_status=\'Ok\''.$default_condition.' Group By vp.video_id\' ORDER BY sum_total_views DESC';
							break;

						case 'thisMonthMostViewed':

							$sql = 'SELECT '.implode(',', $fields_arr).',SUM(vp.total_views) as sum_total_views, vp.total_views as individual_total_views FROM '.$this->CFG['db']['tbl']['video_viewed'].' as vp JOIN '.$this->CFG['db']['tbl']['video'].' as v On v.video_id = vp.video_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' AS VFS ON video_file_id = thumb_name_id';

							$sql .= ' WHERE DATE_FORMAT(view_date,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\') AND v.total_views>0 AND v.video_access_type=\'Public\' AND v.video_status=\'Ok\' AND u.usr_status=\'Ok\''.$default_condition.' Group By vp.video_id ORDER BY sum_total_views DESC';
							break;

						case 'thisYearMostViewed':

							$sql = 'SELECT '.implode(',', $fields_arr).',SUM(vp.total_views) as sum_total_views, vp.total_views as individual_total_views FROM '.$this->CFG['db']['tbl']['video_viewed'].' as vp JOIN '.$this->CFG['db']['tbl']['video'].' as v On v.video_id = vp.video_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' AS VFS ON video_file_id = thumb_name_id';

							$sql .= ' WHERE DATE_FORMAT(view_date,\'%y\')=DATE_FORMAT(NOW(),\'%y\') AND v.total_views>0 AND v.video_access_type=\'Public\' AND v.video_status=\'Ok\' AND u.usr_status=\'Ok\''.$default_condition.' Group By vp.video_id ORDER BY sum_total_views DESC';


							break;

						case 'mostViewed':

							$sql = 'SELECT '.implode(',', $fields_arr).',SUM(vp.total_views) as sum_total_views, vp.total_views as individual_total_views FROM '.$this->CFG['db']['tbl']['video_viewed'].' as vp JOIN '.$this->CFG['db']['tbl']['video'].' as v On v.video_id = vp.video_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' AS VFS ON video_file_id = thumb_name_id';

							$sql .= ' WHERE v.total_views>0 AND v.video_access_type=\'Public\' AND v.video_status=\'Ok\' AND u.usr_status=\'Ok\''.$default_condition.' Group By vp.video_id ORDER BY sum_total_views DESC';

							break;

						case 'todayMostDiscussed':

							$sql = 'SELECT '.implode(',', $fields_arr).',SUM(1) as sum_total_comments FROM '.$this->CFG['db']['tbl']['video_comments'].' as vp JOIN '.$this->CFG['db']['tbl']['video'].' as v On v.video_id = vp.video_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' AS VFS ON video_file_id = thumb_name_id';

							$sql .= ' WHERE DATE_FORMAT(vp.date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\') AND v.total_comments>0 AND v.video_access_type=\'Public\' AND v.video_status=\'Ok\' AND u.usr_status=\'Ok\' AND comment_status=\'Yes\''.$default_condition.' Group By vp.video_id ORDER BY sum_total_comments DESC , total_views DESC';

							break;

						case 'yesterdayMostDiscussed':

							$sql = 'SELECT '.implode(',', $fields_arr).',SUM(1) as sum_total_comments FROM '.$this->CFG['db']['tbl']['video_comments'].' as vp JOIN '.$this->CFG['db']['tbl']['video'].' as v On v.video_id = vp.video_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' AS VFS ON video_file_id = thumb_name_id';

							$sql .= ' WHERE DATE_FORMAT(vp.date_added,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\') AND v.total_comments>0 AND v.video_access_type=\'Public\' AND v.video_status=\'Ok\' AND u.usr_status=\'Ok\' AND comment_status=\'Yes\''.$default_condition.' Group By vp.video_id ORDER BY sum_total_comments DESC , total_views DESC';

							break;

						case 'thisWeekMostDiscussed':
							$sql = 'SELECT '.implode(',', $fields_arr).',SUM(1) as sum_total_comments FROM '.$this->CFG['db']['tbl']['video_comments'].' as vp JOIN '.$this->CFG['db']['tbl']['video'].' as v On v.video_id = vp.video_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' AS VFS ON video_file_id = thumb_name_id';

							$sql .= ' WHERE DATE_FORMAT(vp.date_added,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\') AND v.total_comments>0 AND v.video_access_type=\'Public\' AND v.video_status=\'Ok\' AND u.usr_status=\'Ok\' AND comment_status=\'Yes\''.$default_condition.'  Group By vp.video_id ORDER BY sum_total_comments DESC , total_views DESC';

							break;

						case 'thisMonthMostDiscussed':

							$sql = 'SELECT '.implode(',', $fields_arr).',SUM(1) as sum_total_comments FROM '.$this->CFG['db']['tbl']['video_comments'].' as vp JOIN '.$this->CFG['db']['tbl']['video'].' as v On v.video_id = vp.video_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' AS VFS ON video_file_id = thumb_name_id';

							$sql .= ' WHERE DATE_FORMAT(vp.date_added,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\') AND v.total_comments>0 AND v.video_access_type=\'Public\' AND v.video_status=\'Ok\' AND u.usr_status=\'Ok\' AND comment_status=\'Yes\''.$default_condition.' Group By vp.video_id ORDER BY sum_total_comments DESC , total_views DESC';

							break;

						case 'thisYearMostDiscussed':

							$sql = 'SELECT '.implode(',', $fields_arr).',SUM(1) as sum_total_comments FROM '.$this->CFG['db']['tbl']['video_comments'].' as vp JOIN '.$this->CFG['db']['tbl']['video'].' as v On v.video_id = vp.video_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' AS VFS ON video_file_id = thumb_name_id';

							$sql .= ' WHERE DATE_FORMAT(vp.date_added,\'%y\')=DATE_FORMAT(NOW(),\'%y\') AND v.total_comments>0 AND v.video_access_type=\'Public\' AND v.video_status=\'Ok\' AND u.usr_status=\'Ok\' AND comment_status=\'Yes\''.$default_condition.' Group By vp.video_id ORDER BY sum_total_comments DESC , total_views DESC';

							break;

						case 'mostDiscussed':
							$sql = 'SELECT '.implode(',', $fields_arr).',SUM(1) as sum_total_comments FROM '.$this->CFG['db']['tbl']['video_comments'].' as vp JOIN '.$this->CFG['db']['tbl']['video'].' as v On v.video_id = vp.video_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' AS VFS ON video_file_id = thumb_name_id';

							$sql .= ' WHERE v.total_comments>0 AND v.video_access_type=\'Public\' AND v.video_status=\'Ok\' AND u.usr_status=\'Ok\' AND comment_status=\'Yes\''.$default_condition.' Group By vp.video_id ORDER BY sum_total_comments DESC, total_views DESC';

							break;
					}
			 	$sql .= ' LIMIT '.$this->CFG['admin']['videos']['rss_count'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				return $rs;
			}

		/**
		 * VideoNew::showVideos()
		 * To display the vido as xml format
		 * @return void
		 * @access public
		 **/
		public function showVideos()
			{
				$res = $this->getRssResource();

				$fields_list = array('user_name', 'first_name', 'last_name');
				$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
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
						$row['playing_time'] = $row['playing_time']?$row['playing_time']:'00:00';

						if(!isset($this->UserDetails[$row['user_id']]))
							$this->getUserDetail('user_id',$row['user_id'], 'user_name');

						$name = $this->getUserDetail('user_id',$row['user_id'], 'user_name');
?>
				<item>
					<author><?php echo $this->CFG['site']['noreply_email'];?> (<?php echo $name;?>)</author>
					<title>
							<?php echo htmlspecialchars($row['video_title']); ?>
					</title>
					<link>
							<?php echo getUrl('viewvideo', '?video_id='.$row['video_id'].'&amp;video_title='.$this->changeTitle($row['video_title']), $row['video_id'].'/'.$this->changeTitle($row['video_title']).'/', 'root', 'video');?>
					</link>
					<description>
						<![CDATA[
							<img src="<?php echo $row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id'],$row['file_name']).$this->CFG['admin']['videos']['thumb_name'].'.'.$this->CFG['video']['image']['extensions'];?>" align="right" border="0" width="120" height="90" vspace="4" hspace="4" <?php echo  $this->DISP_IMAGE(142, 108, $row['t_width'], $row['t_height']); ?> />
							<p><?php echo $row['video_title']; ?></p>
							<p>
								<?php echo $this->LANG['author'];?> <a href="<?php echo getMemberProfileUrl($row['user_id'], $name);?>"><?php echo $name;?></a><br/>
								<?php echo $this->LANG['keywords'];?> <?php $this->populateKeywords($row['video_tags']);?><br/>
								<?php echo $this->LANG['added'];?> <?php echo $row['date_added'];?><br/>
							</p>
						]]>
					</description>
					<guid isPermaLink="true"><?php echo getUrl('viewvideo', '?video_id='.$row['video_id'].'&amp;video_title='.$this->changeTitle($row['video_title']), $row['video_id'].'/'.$this->changeTitle($row['video_title']).'/', 'root', 'video');?></guid>
					<pubDate><?php echo $row['date_added'];?></pubDate>
					<media:player url="<?php echo getUrl('viewvideo', '?video_id='.$row['video_id'].'&amp;video_title='.$this->changeTitle($row['video_title']), $row['video_id'].'/'.$this->changeTitle($row['video_title']).'/', 'root', 'video');?>" />
					<media:thumbnail url="<?php echo $row['video_server_url'].$thumbnail_folder.$row['video_id'].$this->CFG['admin']['videos']['thumb_name'].'.'.$this->CFG['video']['image']['extensions'];?>" width="120" height="90" />
					<media:title type="html">
						<![CDATA[
							<?php echo htmlspecialchars($row['video_title']); ?>
						]]>
					</media:title>
					<media:category label="Tags">
						<![CDATA[
							<?php echo $row['video_tags']; ?>
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
//<<<<<-------------- Class VideoNew begins ---------------//
//-------------------- Code begins -------------->>>>>//
$VideoNew = new VideoNew();
$VideoNew->setDBObject($db);
$VideoNew->makeGlobalize($CFG,$LANG);

if(!chkAllowedModule(array('video')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$VideoNew->setFormField('pg', '');
$VideoNew->sanitizeFormInputs($_GET);

if($VideoNew->isFormGETed('pg') and $VideoNew->chkValidFile())
	{
		$VideoNew->includeAjaxHeader();
		$VideoNew->showVideos();
		$VideoNew->includeAjaxFooter();
	}
?>