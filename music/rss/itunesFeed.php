<?php
/**
 * This class is used to itunesFeed Music Feed
 *
 * @category	Rayzz
 * @package		itunesFeed
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 */
require_once('../../common/configs/config.inc.php');
require_once('../../common/configs/config_music.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/rssFeed.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['auth']['is_authenticate'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
class MusicNew extends MediaHandler
	{

		/**
		 * MusicNew::buildSortQuery()
		 *
		 * @return
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = 'm.music_id DESC';
			}

		/**
		 * MusicNew::populateKeywords()
		 *
		 * @param $tags
		 * @return
		 **/
		public function populateKeywords($tags)
			{
				$tags_arr = explode(' ',$tags);
				$length = sizeof($tags_arr);
				$i = 1;
				foreach($tags_arr as $tags)
					{
?>
	<a href="<?php echo getUrl($this->CFG['site']['url'].'musicList.php?pg=musicnew&tags='.$tags, $this->CFG['site']['url'].'musiclist/musicnew/?tags='.$tags, false);?>"><?php echo $tags;?></a>&nbsp;
<?php
					}
			}
		/**
		 * MusicNew::chkValidFile()
		 *
		 * @return
		 **/
		public function chkValidFile()
			{
				$valid_arr = array('recentlyAdded', 'topFavorites', 'topRated', 'todayMostViewed', 'thisWeekMostViewed',
									'thisMonthMostViewed', 'thisYearMostViewed', 'mostViewed', 'todayMostDiscussed',
									'thisWeekMostDiscussed', 'thisMonthMostDiscussed', 'thisYearMostDiscussed',
									'mostDiscussed');
				if(in_array($this->fields_arr['pg'], $valid_arr))
					return true;
				return false;
			}
		/**
		 * MusicNew::getRssResource()
		 *
		 * @return
		 **/
		public function getRssResource()
			{
				$date_format = '%a, %e %b %Y %T';
				$fields_arr = array('music_caption','playing_time','(m.rating_total/m.rating_count) as rating','m.music_id',
									'm.user_id','m.music_title', 'm.music_server_url', 'm.t_width', 'm.t_height',
									'DATE_FORMAT(m.date_added,\''.$date_format.'\') as date_added', 'm.total_views', 'm.music_tags');
				$default_condition = '';
				$sql = 'SELECT '.implode(',', $fields_arr).' FROM '.$this->CFG['db']['tbl']['music'].' AS v JOIN '.$this->CFG['db']['tbl']['users'].' as u on m.user_id = u.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON m.thumb_name_id = music_file_id ';
				switch($this->fields_arr['pg'])
					{
						case 'recentlyAdded':
							$sql .= 'WHERE m.music_access_type=\'Public\' AND m.music_status=\'Ok\' AND u.usr_status=\'Ok\''.$default_condition.
									' ORDER BY m.music_id DESC';
							break;
						case 'topFavorites':
							$sql .= 'WHERE m.music_access_type=\'Public\' AND m.music_status=\'Ok\' AND u.usr_status=\'Ok\''.$default_condition.
									' ORDER BY m.total_favorites DESC,total_views DESC';
							break;
						case 'topRated':
							$sql .= 'WHERE m.music_access_type=\'Public\' AND m.music_status=\'Ok\' AND u.usr_status=\'Ok\' AND m.rating_total>0'.$default_condition.
									' ORDER BY rating DESC';
							break;
						case 'todayMostViewed':
							$sql = 'SELECT '.implode(',', $fields_arr).',SUM(vp.total_views) as sum_total_views, vp.total_views as individual_total_views FROM '.$this->CFG['db']['tbl']['music_viewed'].' as vp JOIN '.$this->CFG['db']['tbl']['music'].' as v On m.music_id = vp.music_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = m.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON music_file_id = thumb_name_id';
							$sql .= ' WHERE DATE_FORMAT(vp.last_viewed,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\') AND m.total_views>0 AND m.music_access_type=\'Public\' AND m.music_status=\'Ok\' AND u.usr_status=\'Ok\''.$default_condition.' Group By vp.music_id ORDER BY sum_total_views DESC';
							break;
						case 'yesterdayMostViewed':
							$sql = 'SELECT '.implode(',', $fields_arr).',SUM(vp.total_views) as sum_total_views, vp.total_views as individual_total_views FROM '.$this->CFG['db']['tbl']['music_viewed'].' as vp JOIN '.$this->CFG['db']['tbl']['music'].' as v On m.music_id = vp.music_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = m.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON music_file_id = thumb_name_id';
							$sql .= ' WHERE DATE_FORMAT(last_viewed,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\') AND m.total_views>0 AND m.music_access_type=\'Public\' AND m.music_status=\'Ok\' AND u.usr_status=\'Ok\''.$default_condition.' Group By vp.music_id ORDER BY sum_total_views DESC';

							break;
						case 'thisWeekMostViewed':

							$sql = 'SELECT '.implode(',', $fields_arr).',SUM(vp.total_views) as sum_total_views, vp.total_views as individual_total_views FROM '.$this->CFG['db']['tbl']['music_viewed'].' as vp JOIN '.$this->CFG['db']['tbl']['music'].' as v On m.music_id = vp.music_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = m.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON music_file_id = thumb_name_id';
							$sql .= ' WHERE DATE_FORMAT(last_viewed,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\') AND m.total_views>0 AND m.music_access_type=\'Public\' AND m.music_status=\'Ok\' AND u.usr_status=\'Ok\''.$default_condition.' Group By vp.music_id ORDER BY sum_total_views DESC';
							break;
						case 'thisMonthMostViewed':

							$sql = 'SELECT '.implode(',', $fields_arr).',SUM(vp.total_views) as sum_total_views, vp.total_views as individual_total_views FROM '.$this->CFG['db']['tbl']['music_viewed'].' as vp JOIN '.$this->CFG['db']['tbl']['music'].' as v On m.music_id = vp.music_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = m.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON music_file_id = thumb_name_id';
							$sql .= ' WHERE DATE_FORMAT(last_viewed,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\') AND m.total_views>0 AND m.music_access_type=\'Public\' AND m.music_status=\'Ok\' AND u.usr_status=\'Ok\''.$default_condition.' Group By vp.music_id ORDER BY sum_total_views DESC';
							break;
						case 'thisYearMostViewed':

							$sql = 'SELECT '.implode(',', $fields_arr).',SUM(vp.total_views) as sum_total_views, vp.total_views as individual_total_views FROM '.$this->CFG['db']['tbl']['music_viewed'].' as vp JOIN '.$this->CFG['db']['tbl']['music'].' as v On m.music_id = vp.music_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = m.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON music_file_id = thumb_name_id';
							$sql .= ' WHERE DATE_FORMAT(last_viewed,\'%y\')=DATE_FORMAT(NOW(),\'%y\') AND m.total_views>0 AND m.music_access_type=\'Public\' AND m.music_status=\'Ok\' AND u.usr_status=\'Ok\''.$default_condition.' Group By vp.music_id ORDER BY sum_total_views DESC';

							break;
						case 'mostViewed':

							$sql = 'SELECT '.implode(',', $fields_arr).',SUM(vp.total_views) as sum_total_views, vp.total_views as individual_total_views FROM '.$this->CFG['db']['tbl']['music_viewed'].' as vp JOIN '.$this->CFG['db']['tbl']['music'].' as v On m.music_id = vp.music_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = m.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON music_file_id = thumb_name_id';

							$sql .= ' WHERE m.total_views>0 AND m.music_access_type=\'Public\' AND m.music_status=\'Ok\' AND u.usr_status=\'Ok\''.$default_condition.' Group By vp.music_id ORDER BY sum_total_views DESC';

							break;
						case 'todayMostDiscussed':
							$sql = 'SELECT '.implode(',', $fields_arr).',SUM(1) as sum_total_comments FROM '.$this->CFG['db']['tbl']['music_comments'].' as vp JOIN '.$this->CFG['db']['tbl']['music'].' as v On m.music_id = vp.music_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = m.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON music_file_id = thumb_name_id';

							$sql .= ' WHERE DATE_FORMAT(vp.date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\') AND m.total_comments>0 AND m.music_access_type=\'Public\' AND m.music_status=\'Ok\' AND u.usr_status=\'Ok\' AND comment_status=\'Yes\''.$default_condition.' Group By vp.music_id ORDER BY sum_total_comments DESC , total_views DESC';

							break;
						case 'yesterdayMostDiscussed':
							$sql = 'SELECT '.implode(',', $fields_arr).',SUM(1) as sum_total_comments FROM '.$this->CFG['db']['tbl']['music_comments'].' as vp JOIN '.$this->CFG['db']['tbl']['music'].' as v On m.music_id = vp.music_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = m.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON music_file_id = thumb_name_id';

							$sql .= ' WHERE DATE_FORMAT(vp.date_added,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\') AND m.total_comments>0 AND m.music_access_type=\'Public\' AND m.music_status=\'Ok\' AND u.usr_status=\'Ok\' AND comment_status=\'Yes\''.$default_condition.' Group By vp.music_id ORDER BY sum_total_comments DESC , total_views DESC';

							break;
						case 'thisWeekMostDiscussed':
							$sql = 'SELECT '.implode(',', $fields_arr).',SUM(1) as sum_total_comments FROM '.$this->CFG['db']['tbl']['music_comments'].' as vp JOIN '.$this->CFG['db']['tbl']['music'].' as v On m.music_id = vp.music_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = m.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON music_file_id = thumb_name_id';

							$sql .= ' WHERE DATE_FORMAT(vp.date_added,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\') AND m.total_comments>0 AND m.music_access_type=\'Public\' AND m.music_status=\'Ok\' AND u.usr_status=\'Ok\' AND comment_status=\'Yes\''.$default_condition.'  Group By vp.music_id ORDER BY sum_total_comments DESC , total_views DESC';

							break;

						case 'thisMonthMostDiscussed':
							$sql = 'SELECT '.implode(',', $fields_arr).',SUM(1) as sum_total_comments FROM '.$this->CFG['db']['tbl']['music_comments'].' as vp JOIN '.$this->CFG['db']['tbl']['music'].' as v On m.music_id = vp.music_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = m.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON music_file_id = thumb_name_id';

							$sql .= ' WHERE DATE_FORMAT(vp.date_added,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\') AND m.total_comments>0 AND m.music_access_type=\'Public\' AND m.music_status=\'Ok\' AND u.usr_status=\'Ok\' AND comment_status=\'Yes\''.$default_condition.' Group By vp.music_id ORDER BY sum_total_comments DESC , total_views DESC';

							break;
						case 'thisYearMostDiscussed':
							$sql = 'SELECT '.implode(',', $fields_arr).',SUM(1) as sum_total_comments FROM '.$this->CFG['db']['tbl']['music_comments'].' as vp JOIN '.$this->CFG['db']['tbl']['music'].' as v On m.music_id = vp.music_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = m.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON music_file_id = thumb_name_id';

							$sql .= ' WHERE DATE_FORMAT(vp.date_added,\'%y\')=DATE_FORMAT(NOW(),\'%y\') AND m.total_comments>0 AND m.music_access_type=\'Public\' AND m.music_status=\'Ok\' AND u.usr_status=\'Ok\' AND comment_status=\'Yes\''.$default_condition.' Group By vp.music_id ORDER BY sum_total_comments DESC , total_views DESC';

							break;
						case 'mostDiscussed':
							$sql = 'SELECT '.implode(',', $fields_arr).',SUM(1) as sum_total_comments FROM '.$this->CFG['db']['tbl']['music_comments'].' as vp JOIN '.$this->CFG['db']['tbl']['music'].' as v On m.music_id = vp.music_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = m.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON music_file_id = thumb_name_id';

							$sql .= ' WHERE m.total_comments>0 AND m.music_access_type=\'Public\' AND m.music_status=\'Ok\' AND u.usr_status=\'Ok\' AND comment_status=\'Yes\''.$default_condition.' Group By vp.music_id ORDER BY sum_total_comments DESC, total_views DESC';

							break;
					}
			 	$sql .= ' LIMIT '.$this->CFG['admin']['musics']['rss_count'];
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				return $rs;
			}

		/**
		 * MusicNew::showMusics()
		 *
		 * @return
		 **/
		public function showMusics()
			{
				$res = $this->getRssResource();
				$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
				$music_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['other_musicformat_folder'].'/';
echo '<?xml version="1.0" encoding="utf-8"?>';?>
	<rss xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" version="2.0">
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
								$row[$key] = htmlentities($eachRow);
							}

						$row['playing_time'] = $row['playing_time']?$row['playing_time']:'00:00';
						$name = $this->getUserDetail('user_id', $row['user_id'], 'user_name');?>

				<itunes:explicit>No</itunes:explicit>
				<itunes:image href="http://www.podcast411.com/img/411_itunes.jpg"/>
				<itunes:category text="Technology">
				     <itunes:category text="Podcasting"/>
				</itunes:category>
				<item>
					<title><?php echo $row['music_title'];?></title>
					<link><?php echo getUrl('viewmusic','?music_id='.$row['music_id'].'&amp;title='.$row['music_title'],$row['music_id'].'/'.$row['music_title'].'/','music','music');?></link>
					<guid><?php echo getUrl('viewmusic','?music_id='.$row['music_id'].'&amp;title='.$row['music_title'],$row['music_id'].'/'.$row['music_title'].'/','music','music');?></guid>
					<!--<guid><?php echo $row['music_server_url'].$music_folder.getHotLinkProtectionString().getVideoName($row['music_id']).'.mp4';?></guid>-->
					<description><?php echo $row['music_caption']; ?></description>
					<enclosure url="<?php echo $row['music_server_url'].$music_folder.getHotLinkProtectionString().getVideoName($row['music_id']).'.mp4'; ?>" type="audio/mpeg"/>
					<category>Podcasts</category>
					<itunes:author><?php echo $name; ?></itunes:author>
					<itunes:explicit>No</itunes:explicit>
					<itunes:duration><?php echo $row['playing_time']; ?></itunes:duration>
					<pubDate><?php echo $row['date_added'].' -0000';?></pubDate>
					<itunes:keywords><?php echo $row['music_tags']; ?></itunes:keywords>
				</item>
<?php
				    }
?>
			</channel>
		</rss>
<?php
			}
	}
//<<<<<-------------- Class MusicNew begins ---------------//
//-------------------- Code begins -------------->>>>>//
$MusicNew = new MusicNew();
$MusicNew->setDBObject($db);
$MusicNew->makeGlobalize($CFG,$LANG);
if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$MusicNew->setFormField('pg', '');
$MusicNew->sanitizeFormInputs($_GET);
if($MusicNew->isFormGETed('pg') and $MusicNew->chkValidFile())
	{
		$MusicNew->includeRssHeader();
		$MusicNew->showMusics();
		$MusicNew->includeRssFooter();
	}
//<<<<<-------------------- Page block templates ends -------------------//
//require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');
?>