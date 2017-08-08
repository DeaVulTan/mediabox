<?php
/**
 * This class is used to RSS Music
 *
 * @category	Rayzz
 * @package		RSS Music
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 */
require_once('../../common/configs/config.inc.php');
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/rssFeed.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['auth']['is_authenticate'] = false;
require($CFG['site']['project_path'].'common/application_top.inc.php');
/**
* This class handles rss music
*
* @category	RAYZZ
* @package		rss
*/
class MusicNew extends MediaHandler
	{
		/**
		* MusicNew::buildSortQuery()
		* To disply the query
		* @return void
		* @access bublic
		**/
		public function buildSortQuery()
			{
				$this->sql_sort = 'v.music_id DESC';
			}
		/**
		* MusicNew::populateKeywords()
		* To ppopulate keywords
		* @param $tags music tag
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
						<a href="<?php echo getUrl('musiclist','?pg=musicnew&tags='.$tags,'musicnew/?tags='.$tags, 'root', 'music');?>"><?php echo $tags;?></a>&nbsp;
						<?php
					}
			}
		/**
		* MusicNew::chkValidFile()
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
		* MusicNew::getRssResource()
		* To get the vido details as per condition
		* @return array
		* @access public
		**/
		public function getRssResource()
			{
				$fields_arr = array('playing_time','(v.rating_total/v.rating_count) as rating','v.music_id',
				'v.user_id', 'v.music_title', 'v.music_server_url', 'v.thumb_width', 'v.thumb_height','v.music_thumb_ext',
				'TIMEDIFF(NOW(), v.date_added) as date_added', 'v.total_views', 'v.music_tags','file_name');
				$sql = 'SELECT '.implode(',', $fields_arr).' FROM '.$this->CFG['db']['tbl']['music'].' AS v JOIN '.$this->CFG['db']['tbl']['users'].' as u on v.user_id = u.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON v.thumb_name_id = music_file_id ';
				switch($this->fields_arr['pg'])
					{
						case 'recentlyAdded':
						$sql .= 'WHERE v.music_access_type=\'Public\' AND v.music_status=\'Ok\' AND u.usr_status=\'Ok\' ORDER BY date_added ASC';
						break;
						case 'topFavorites':
						$sql .= 'WHERE v.music_access_type=\'Public\' AND v.music_status=\'Ok\' AND u.usr_status=\'Ok\' ORDER BY v.total_views DESC';
						break;
						case 'topRated':
						$sql .= 'WHERE v.music_access_type=\'Public\' AND v.music_status=\'Ok\' AND u.usr_status=\'Ok\' AND v.rating_total>0  ORDER BY rating DESC';
						break;
						case 'todayMostViewed':
						$sql = 'SELECT '.implode(',', $fields_arr).',SUM(vp.total_views) as sum_total_views, vp.total_views as individual_total_views FROM '.$this->CFG['db']['tbl']['music_viewed'].' as vp JOIN '.$this->CFG['db']['tbl']['music'].' as v On v.music_id = vp.music_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON music_file_id = thumb_name_id';
						$sql .= ' WHERE DATE_FORMAT(vp.last_viewed,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\') AND v.total_views>0 AND v.music_access_type=\'Public\' AND v.music_status=\'Ok\' AND u.usr_status=\'Ok\'  Group By vp.music_id ORDER BY sum_total_views DESC';
						break;
						case 'yesterdayMostViewed':
						$sql = 'SELECT '.implode(',', $fields_arr).',SUM(vp.total_views) as sum_total_views, vp.total_views as individual_total_views FROM '.$this->CFG['db']['tbl']['music_viewed'].' as vp JOIN '.$this->CFG['db']['tbl']['music'].' as v On v.music_id = vp.music_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON music_file_id = thumb_name_id';
						$sql .= ' WHERE DATE_FORMAT(last_viewed,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\') AND v.total_views>0 AND v.music_access_type=\'Public\' AND v.music_status=\'Ok\' AND u.usr_status=\'Ok\'  Group By vp.music_id ORDER BY sum_total_views DESC';							break;
						case 'thisWeekMostViewed':
						$sql = 'SELECT '.implode(',', $fields_arr).',SUM(vp.total_views) as sum_total_views, vp.total_views as individual_total_views FROM '.$this->CFG['db']['tbl']['music_viewed'].' as vp JOIN '.$this->CFG['db']['tbl']['music'].' as v On v.music_id = vp.music_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON music_file_id = thumb_name_id';
						$sql .= ' WHERE DATE_FORMAT(last_viewed,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\') AND v.total_views>0 AND v.music_access_type=\'Public\' AND v.music_status=\'Ok\' AND u.usr_status=\'Ok\'  Group By vp.music_id ORDER BY sum_total_views DESC';
						break;
						case 'thisMonthMostViewed':
						$sql = 'SELECT '.implode(',', $fields_arr).',SUM(vp.total_views) as sum_total_views, vp.total_views as individual_total_views FROM '.$this->CFG['db']['tbl']['music_viewed'].' as vp JOIN '.$this->CFG['db']['tbl']['music'].' as v On v.music_id = vp.music_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON music_file_id = thumb_name_id';
						$sql .= ' WHERE DATE_FORMAT(last_viewed,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\') AND v.total_views>0 AND v.music_access_type=\'Public\' AND v.music_status=\'Ok\' AND u.usr_status=\'Ok\' Group By vp.music_id ORDER BY sum_total_views DESC';
						break;
						case 'thisYearMostViewed':
						$sql = 'SELECT '.implode(',', $fields_arr).',SUM(vp.total_views) as sum_total_views, vp.total_views as individual_total_views FROM '.$this->CFG['db']['tbl']['music_viewed'].' as vp JOIN '.$this->CFG['db']['tbl']['music'].' as v On v.music_id = vp.music_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON music_file_id = thumb_name_id';
						$sql .= ' WHERE DATE_FORMAT(last_viewed,\'%y\')=DATE_FORMAT(NOW(),\'%y\') AND v.total_views>0 AND v.music_access_type=\'Public\' AND v.music_status=\'Ok\' AND u.usr_status=\'Ok\' Group By vp.music_id ORDER BY sum_total_views DESC';
						break;
						case 'mostViewed':
						$sql = 'SELECT '.implode(',', $fields_arr).',SUM(vp.total_views) as sum_total_views, vp.total_views as individual_total_views FROM '.$this->CFG['db']['tbl']['music_viewed'].' as vp JOIN '.$this->CFG['db']['tbl']['music'].' as v On v.music_id = vp.music_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON music_file_id = thumb_name_id';
						$sql .= ' WHERE v.total_views>0 AND v.music_access_type=\'Public\' AND v.music_status=\'Ok\' AND u.usr_status=\'Ok\' Group By vp.music_id ORDER BY sum_total_views DESC';
						break;
						case 'todayMostDiscussed':
						$sql = 'SELECT '.implode(',', $fields_arr).',SUM(1) as sum_total_comments FROM '.$this->CFG['db']['tbl']['music_comments'].' as vp JOIN '.$this->CFG['db']['tbl']['music'].' as v On v.music_id = vp.music_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON music_file_id = thumb_name_id';
						$sql .= ' WHERE DATE_FORMAT(vp.date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\') AND v.total_comments>0 AND v.music_access_type=\'Public\' AND v.music_status=\'Ok\' AND u.usr_status=\'Ok\' AND comment_status=\'Yes\' Group By vp.music_id ORDER BY sum_total_comments DESC , total_views DESC';
						break;
						case 'yesterdayMostDiscussed':
						$sql = 'SELECT '.implode(',', $fields_arr).',SUM(1) as sum_total_comments FROM '.$this->CFG['db']['tbl']['music_comments'].' as vp JOIN '.$this->CFG['db']['tbl']['music'].' as v On v.music_id = vp.music_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON music_file_id = thumb_name_id';
						$sql .= ' WHERE DATE_FORMAT(vp.date_added,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\') AND v.total_comments>0 AND v.music_access_type=\'Public\' AND v.music_status=\'Ok\' AND u.usr_status=\'Ok\' AND comment_status=\'Yes\' Group By vp.music_id ORDER BY sum_total_comments DESC , total_views DESC';
						break;
						case 'thisWeekMostDiscussed':
						$sql = 'SELECT '.implode(',', $fields_arr).',SUM(1) as sum_total_comments FROM '.$this->CFG['db']['tbl']['music_comments'].' as vp JOIN '.$this->CFG['db']['tbl']['music'].' as v On v.music_id = vp.music_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON music_file_id = thumb_name_id';
						$sql .= ' WHERE DATE_FORMAT(vp.date_added,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\') AND v.total_comments>0 AND v.music_access_type=\'Public\' AND v.music_status=\'Ok\' AND u.usr_status=\'Ok\' AND comment_status=\'Yes\'  Group By vp.music_id ORDER BY sum_total_comments DESC , total_views DESC';
						break;
						case 'thisMonthMostDiscussed':
						$sql = 'SELECT '.implode(',', $fields_arr).',SUM(1) as sum_total_comments FROM '.$this->CFG['db']['tbl']['music_comments'].' as vp JOIN '.$this->CFG['db']['tbl']['music'].' as v On v.music_id = vp.music_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON music_file_id = thumb_name_id';
						$sql .= ' WHERE DATE_FORMAT(vp.date_added,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\') AND v.total_comments>0 AND v.music_access_type=\'Public\' AND v.music_status=\'Ok\' AND u.usr_status=\'Ok\' AND comment_status=\'Yes\' Group By vp.music_id ORDER BY sum_total_comments DESC , total_views DESC';
						break;
						case 'thisYearMostDiscussed':
						$sql = 'SELECT '.implode(',', $fields_arr).',SUM(1) as sum_total_comments FROM '.$this->CFG['db']['tbl']['music_comments'].' as vp JOIN '.$this->CFG['db']['tbl']['music'].' as v On v.music_id = vp.music_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON music_file_id = thumb_name_id';
						$sql .= ' WHERE DATE_FORMAT(vp.date_added,\'%y\')=DATE_FORMAT(NOW(),\'%y\') AND v.total_comments>0 AND v.music_access_type=\'Public\' AND v.music_status=\'Ok\' AND u.usr_status=\'Ok\' AND comment_status=\'Yes\' Group By vp.music_id ORDER BY sum_total_comments DESC , total_views DESC';							break;
						case 'mostDiscussed':
						$sql = 'SELECT '.implode(',', $fields_arr).',SUM(1) as sum_total_comments FROM '.$this->CFG['db']['tbl']['music_comments'].' as vp JOIN '.$this->CFG['db']['tbl']['music'].' as v On v.music_id = vp.music_id JOIN '.$this->CFG['db']['tbl']['users'].' as u on u.user_id = v.user_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS VFS ON music_file_id = thumb_name_id';
						$sql .= ' WHERE v.total_comments>0 AND v.music_access_type=\'Public\' AND v.music_status=\'Ok\' AND u.usr_status=\'Ok\' AND comment_status=\'Yes\' Group By vp.music_id ORDER BY sum_total_comments DESC, total_views DESC';
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
		* To display the music as xml format
		* @return void
		* @access public
		**/
		public function showMusics()
			{
				$res = $this->getRssResource();
				$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
				$musics_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
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
						$name = $this->getUserDetail('user_id', $row['user_id'], 'user_name');
						?>
						<item>
						<author><?php echo $this->CFG['site']['noreply_email'];?> (<?php echo $name;?>)</author>
						<title>
						<?php echo htmlspecialchars($row['music_title']); ?>
						</title>
						<link>
						<?php echo getUrl('viewmusic', '?music_id='.$row['music_id'].'&amp;title='.$this->changeTitle($row['music_title']), $row['music_id'].'/'.$this->changeTitle($row['music_title']).'/', 'root', 'music');?>
						</link>
						<description>
						<![CDATA[
						<?php if($row['music_thumb_ext']=='') { ?>
						<img src="<?php echo $this->CFG['site']['url'].'music/design/templates/'.$this->CFG['html']['template']['default'] .' /root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_audio_T.jpg' ?>" align="right" border="0" width="120" height="90" vspace="4" hspace="4" />
						<?php } else {  ?> <img src="<?php echo $row['music_server_url'].$musics_folder.getMusicImageName($row['music_id'],$row['file_name']).$this->CFG['admin']['musics']['thumb_name'].'.'.$row['music_thumb_ext'];?>" align="right" border="0" width="120" height="90" vspace="4" hspace="4" />  <?php } ?>
						<p><?php echo $row['music_title']; ?></p>
						<p>
						<?php echo $this->LANG['author'];?> <a href="<?php echo getMemberProfileUrl($row['user_id'], $name);?>"><?php echo $name;?></a><br/>
						<?php echo $this->LANG['keywords'];?> <?php $this->populateKeywords($row['music_tags']);?><br/>
						<?php echo $this->LANG['added'];?> <?php echo $row['date_added'];?><br/>
						</p>
						]]>
						</description>
						<guid isPermaLink="true"><?php echo getUrl('viewmusic', '?music_id='.$row['music_id'].'&amp;title='.$this->changeTitle($row['music_title']), $row['music_id'].'/'.$this->changeTitle($row['music_title']).'/', 'root', 'music');?></guid>
						<pubDate><?php echo $row['date_added'];?></pubDate>
						<media:player url="<?php echo getUrl('viewmusic', '?music_id='.$row['music_id'].'&amp;title='.$this->changeTitle($row['music_title']), $row['music_id'].'/'.$this->changeTitle($row['music_title']).'/', 'root', 'music');?>" />
						<media:thumbnail url="<?php echo $row['music_server_url'].$thumbnail_folder.$row['music_id'].$this->CFG['admin']['musics']['thumb_name'].'.'.$row['music_thumb_ext'];?>" width="120" height="90" />
						<media:title type="html">
						<![CDATA[
						<?php echo htmlspecialchars($row['music_title']); ?>
						]]>
						</media:title>
						<media:category label="Tags">
						<![CDATA[
						<?php echo $row['music_tags']; ?>
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
		$MusicNew->includeAjaxHeader();
		$MusicNew->showMusics();
		$MusicNew->includeAjaxFooter();
	}
?>