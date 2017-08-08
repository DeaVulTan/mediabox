<?php
/**
 * This file is use for manage playlist
 *
 * This file is having musicPlaylist class manage Playlist
 *
 *
 * @category	Rayzz
 * @package		Admin
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 **/
require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/musicPlaylist.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/help.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['site']['is_module_page']='music';
if(isset($_REQUEST['light_window']))
	{
		$CFG['html']['header'] = 'general/html_header_no_header.php';
		$CFG['html']['footer'] = 'general/html_footer_no_footer.php';
		$CFG['mods']['is_include_only']['html_header'] = false;
		$CFG['html']['is_use_header'] = false;
		$CFG['admin']['light_window_page'] = true;
		//To show session expired content inside lightwindow if session got expired
		$CFG['admin']['session_redirect_light_window_page'] = true;
	}
else
	{
		$CFG['html']['header'] = 'admin/html_header.php';
		$CFG['html']['footer'] = 'admin/html_footer.php';
		$CFG['mods']['is_include_only']['html_header'] = false;
		$CFG['html']['is_use_header'] = false;
	}
require($CFG['site']['project_path'].'common/application_top.inc.php');
//--------------class musicPlaylist--------------->>>//
/**
 * This class is used to music playlist and search page
 *
 * @category	Rayzz
 * @package		manage music playlist
 */
class musicPlaylist extends MusicHandler
	{
		public $page_heading = '';
		public $hidden_array = array();

		/**
		 * musicPlaylist::showPlaylists()
		 *
		 * @return
		 */
		public function showPlaylists()
			{
				$showPlaylists_arr = array();
				$inc=0;
				$showPlaylists_arr['row'] = array();
				//Image..
				$playlist_thumbnail_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['musics']['folder'] . '/' . $this->CFG['admin']['musics']['thumbnail_folder'] . '/';
				while($row = $this->fetchResultRecord())
					{
						$row['playlist_name'] = wordWrap_mb_Manual($row['playlist_name'], $this->CFG['admin']['musics']['member_playlist_title_length'], '', 0);
						$showPlaylists_arr['row'][$inc]['record'] = $row;
						$showPlaylists_arr['row'][$inc]['getMemberProfileUrl'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
						//Playlist Image...

						$showPlaylists_arr['row'][$inc]['view_playlisturl'] = getUrl('viewplaylist','?playlist_id='.$row['playlist_id'].'&amp;title='.$this->changeTitle($row['playlist_name']), $row['playlist_id'].'/'.$this->changeTitle($row['playlist_name']).'/', 'root', 'music');
						$showPlaylists_arr['row'][$inc]['disp_image']="";
						$showPlaylists_arr['row'][$inc]['light_window_url']= 'musicPlaylist.php?playlist_id='.$row['playlist_id'].'&light_window=1';
						$showPlaylists_arr['row'][$inc]['private_song'] = $row['total_tracks'] - $this->getPlaylistTotalSong($row['playlist_id']);
						//Image..
						$showPlaylists_arr['row'][$inc]['getPlaylistImageDetail'] = $this->getPlaylistImageDetail($row['playlist_id']);// This function return playlist image detail array..//
						$inc++;
					}
				/*echo '<pre>';
				print_r($showPlaylists_arr);
				echo '</pre>';*/
				return $showPlaylists_arr;
			}

		 /**
		  * musicPlaylist::setTableAndColumns()
		  *
		  * @return
		  */
		 public function setTableAndColumns()
		 	{
				switch ($this->fields_arr['pg'])
					{
						case 'playlisttoprated':
							//Heading
							$this->page_heading = $this->LANG['musicplaylist_heading_toprated'];
							//Query
							$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist'].' as pl LEFT JOIN '.$this->CFG['db']['tbl']['users'].' as u ON pl.user_id=u.user_id' ));
							$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'pl.date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.total_favorites', 'pl.total_featured', 'pl.featured', 'u.user_name', 'u.user_id'));
						 	$this->sql_condition = 'pl.rating_total>0 AND pl.allow_ratings=\'Yes\' AND u.usr_status=\'Ok\''.$this->addtionalQuery().$this->playlistAdvancedFilters();
							$this->sql_sort = 'rating DESC';
							$this->page_heading = $this->LANG['musicplaylist_heading_toprated'];
						break;

						case 'playlistrecommended':
							//Heading
							$this->page_heading = $this->LANG['musicplaylist_heading_mostrecommended'];
							//Query
							$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist'].' as pl LEFT JOIN '.$this->CFG['db']['tbl']['users'].' as u ON pl.user_id=u.user_id' ));
							$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'pl.date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.total_favorites', 'pl.total_featured', 'pl.featured', 'u.user_name', 'u.user_id'));
						 	$this->sql_condition = 'pl.allow_ratings = \'Yes\' AND u.usr_status=\'Ok\''.$this->addtionalQuery().$this->playlistAdvancedFilters();
							$this->sql_sort = 'rating DESC';
						break;

						case 'playlistmostlistened':
							//Heading
							$this->page_heading = $this->LANG['musicplaylist_heading_mostlistened'];
							//Query
							$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist_listened'] . ' as vpl LEFT JOIN ' . $this->CFG['db']['tbl']['music_playlist'] . ' as pl ON pl.playlist_id=pl.playlist_id '.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
							$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'pl.date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.total_favorites', 'pl.total_featured', 'pl.featured', 'u.user_name', 'u.user_id', 'SUM(vpl.total_visits) as sum_total_visits'));
							$this->sql_condition = 'pl.user_id = u.user_id AND u.usr_status=\'Ok\' '.$this->addtionalQuery().$this->playlistAdvancedFilters().$this->getMostListenedExtraQuery().' GROUP BY vpl.playlist_id';
							$this->sql_sort = 'sum_total_visits DESC';
						break;

						case 'playlistmostviewed':
							//Heading
							$this->page_heading = $this->LANG['musicplaylist_heading_mostviewed'];
							//Query
							$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist_viewed'] . ' as vpl LEFT JOIN ' . $this->CFG['db']['tbl']['music_playlist'] . ' as pl ON vpl.playlist_id=pl.playlist_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
							$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'pl.date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.total_favorites', 'pl.total_featured', 'pl.featured', 'u.user_name', 'u.user_id', 'SUM(vpl.total_views) as sum_total_views'));
							$this->sql_condition = 'pl.total_views>0 AND pl.user_id = u.user_id AND u.usr_status=\'Ok\' '.$this->addtionalQuery().$this->playlistAdvancedFilters().$this->getMostViewedExtraQuery().' GROUP BY vpl.playlist_id';
							$this->sql_sort = 'sum_total_views DESC';
						break;

						case 'playlistmostdiscussed':
							//Heading
							$this->page_heading = $this->LANG['musicplaylist_heading_toprated'];
							//Query
							$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist'] . ' AS pl JOIN ' . $this->CFG['db']['tbl']['music_playlist_comments'] . ' AS pc ON pl.playlist_id = pc.playlist_id '.', ' . $this->CFG['db']['tbl']['users'] . ' as u '));
							$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'pl.date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.total_favorites', 'pl.total_featured', 'pl.featured', 'u.user_name', 'u.user_id', 'count( pc.playlist_comment_id ) AS total_comments'));
						 	$this->sql_condition = 'pl.allow_comments = \'Yes\' AND pl.user_id = u.user_id AND u.usr_status=\'Ok\''.$this->addtionalQuery().$this->playlistAdvancedFilters().$this->getMostDiscussedExtraQuery().' GROUP BY pc.playlist_id';
							$this->sql_sort = 'total_comments DESC';
							$this->page_heading = $this->LANG['musicplaylist_heading_mostdiscussed'];
						break;

						case 'playlistmostfavorite':
							//Heading
							$this->page_heading = $this->LANG['musicplaylist_heading_mostfavorite'];
							//Query
							$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist'] . ' AS pl JOIN ' . $this->CFG['db']['tbl']['music_playlist_favorite'] . ' AS pf ON pl.playlist_id = pf.playlist_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
							$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'pl.date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.total_favorites', 'pl.total_featured', 'pl.featured', 'u.user_name', 'u.user_id', 'pl.last_viewed_date', 'count( pf.music_playlist_favorite_id ) AS total_favorite'));
							$this->sql_condition = 'pl.user_id = u.user_id AND u.usr_status=\'Ok\''.$this->addtionalQuery().$this->playlistAdvancedFilters().$this->getMostFavoriteExtraQuery().' GROUP BY pf.playlist_id';
							$this->sql_sort = 'total_favorite, pl.total_views DESC';
						break;

						case 'featuredplaylistlist':
							//Heading
							$this->page_heading = $this->LANG['musicplaylist_heading_mostfeaturedmusiclist'];
							//Query
							$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist_featured'] . ' as fpl LEFT JOIN ' . $this->CFG['db']['tbl']['music_playlist'] . ' as pl ON fpl.playlist_id=pl.playlist_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
							$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'pl.date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.total_favorites', 'pl.total_featured', 'pl.featured', 'u.user_name', 'u.user_id', 'pl.last_viewed_date', 'count( fpl.music_playlist_featured_id ) AS total_featured'));
							$this->sql_condition = 'pl.user_id = u.user_id AND u.usr_status=\'Ok\''.$this->addtionalQuery().$this->playlistAdvancedFilters().' GROUP BY fpl.playlist_id';
							$this->sql_sort = 'total_featured, pl.total_views DESC';
						break;

						case 'playlistmostrecentlyviewed':
							//Heading
							$this->page_heading = $this->LANG['musicplaylist_heading_recentlyviewed'];
							//Query
							$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist'].' as pl LEFT JOIN '.$this->CFG['db']['tbl']['users'].' as u ON pl.user_id=u.user_id' ));
							$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'pl.date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.total_favorites', 'pl.total_featured', 'pl.featured', 'u.user_name', 'u.user_id', 'pl.last_viewed_date'));
							$this->sql_condition = 'u.usr_status=\'Ok\''.$this->addtionalQuery().$this->playlistAdvancedFilters();
							$this->sql_sort = 'pl.last_viewed_date DESC';
						break;

						case 'myplaylist':
							$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist'].' as pl LEFT JOIN '.$this->CFG['db']['tbl']['users'].' as u ON pl.user_id=u.user_id' ));
							$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'pl.date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.total_favorites', 'pl.total_featured', 'pl.featured', 'u.user_name', 'u.user_id'));
						 	$this->sql_condition = 'pl.user_id=\''.$this->CFG['user']['user_id'].'\' AND u.usr_status=\'Ok\''.$this->addtionalQuery().$this->playlistAdvancedFilters();
							$this->sql_sort = 'pl.playlist_id DESC';
							$this->page_heading = '';
						break;

						case 'myrecentlyviewedplaylist':
							//Heading
							$this->page_heading = $this->LANG['musicplaylist_heading_my_recently_viewed'];
							//Query
							$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist_viewed'] . ' as vpl LEFT JOIN ' . $this->CFG['db']['tbl']['music_playlist'] . ' as pl ON vpl.playlist_id=pl.playlist_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
							$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'pl.date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.total_favorites', 'pl.total_featured', 'pl.featured', 'u.user_name', 'u.user_id'));
							$this->sql_condition = 'pl.user_id = u.user_id AND u.usr_status=\'Ok\'  AND vpl.user_id=\''.$this->CFG['user']['user_id'].'\' '.$this->addtionalQuery().$this->playlistAdvancedFilters();
							$this->sql_sort = 'playlist_viewed_id DESC';

						break;

						case 'myfeaturedplaylist':
							//Heading
							$this->page_heading = $this->LANG['musicplaylist_heading_my_featured'];
							//Query
							$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist_featured'] . ' as fpl LEFT JOIN ' . $this->CFG['db']['tbl']['music_playlist'] . ' as pl ON fpl.playlist_id=pl.playlist_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
							$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'pl.date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.total_favorites', 'pl.total_featured', 'pl.featured', 'u.user_name', 'u.user_id', 'pl.last_viewed_date'));
							$this->sql_condition = 'pl.user_id = u.user_id AND u.usr_status=\'Ok\' AND fpl.user_id=\''.$this->CFG['user']['user_id'].'\' '.$this->addtionalQuery().$this->playlistAdvancedFilters();
							$this->sql_sort = 'fpl.music_playlist_featured_id DESC';
						break;

						case 'myfavoriteplaylist':
								//Heading
							$this->page_heading = $this->LANG['musicplaylist_heading_my_favorite'];
							//Query
							$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist'] . ' AS pl JOIN ' . $this->CFG['db']['tbl']['music_playlist_favorite'] . ' AS pf ON pl.playlist_id = pf.playlist_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
							$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'pl.date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.total_favorites', 'pl.total_featured', 'pl.featured', 'u.user_name', 'u.user_id', 'pl.last_viewed_date'));
							$this->sql_condition = ' pl.user_id = u.user_id AND u.usr_status=\'Ok\' AND pf.user_id=\''.$this->CFG['user']['user_id'].'\' '.$this->addtionalQuery().$this->playlistAdvancedFilters();
							$this->sql_sort = ' pf.music_playlist_favorite_id DESC';

						break;

						default:
							$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist'].' as pl LEFT JOIN '.$this->CFG['db']['tbl']['users'].' as u ON pl.user_id=u.user_id' ));
							$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'pl.date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.total_favorites', 'pl.total_featured', 'pl.featured', 'u.user_name', 'u.user_id'));
						 	$this->sql_condition = 'u.usr_status=\'Ok\''.$this->addtionalQuery().$this->playlistAdvancedFilters();
							$this->sql_sort = 'pl.playlist_id DESC';
							$this->page_heading = $this->LANG['musicplaylist_heading_playlistnew'];
						break;
					}
			}

		/**
		 * musicPlaylist::playlistAdvancedFilters()
		 *
		 * @return
		 */
		public function playlistAdvancedFilters()
			{
				$playlistAdvancedFilters = '';
				if ($this->fields_arr['playlist_title'] != $this->LANG['musicplaylist_playlist_title'] AND $this->fields_arr['playlist_title'])
					{
						$this->hidden_array[] = 'playlist_title';
						$playlistAdvancedFilters .= ' AND pl.playlist_name LIKE \'%' .$this->fields_arr['playlist_title']. '%\' ';
					}
				if ($this->fields_arr['createby'] != $this->LANG['musicplaylist_createby'] AND $this->fields_arr['createby'])
					{
						$this->hidden_array[] = 'createby';
						$playlistAdvancedFilters .= ' AND u.user_name LIKE \'%' .$this->fields_arr['createby']. '%\' ';
					}
				if ($this->fields_arr['tracks'] != $this->LANG['musicplaylist_no_of_tracks'] AND $this->fields_arr['tracks'])
					{
						$this->hidden_array[] = 'tracks';
						$playlistAdvancedFilters .= ' AND pl.total_tracks = \'' .$this->fields_arr['tracks']. '\' ';
					}
				if ($this->fields_arr['plays'] != $this->LANG['musicplaylist_no_of_plays'] AND $this->fields_arr['plays'])
					{
						$this->hidden_array[] = 'plays';
						$playlistAdvancedFilters .= ' AND pl.total_views = \'' .$this->fields_arr['plays']. '\' ';
					}
				return $playlistAdvancedFilters;
			}

		/**
		 * musicPlaylist::addtionalQuery()
		 *
		 * @return
		 */
		public function addtionalQuery()
			{
				$additional_query = '';
				if($this->fields_arr['tags'])
					{
						$this->hidden_array[] = 'tags';
						$additional_query = ' AND (' . getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'pl.playlist_tags').') ';
					}
				return $additional_query;
			}

		/**
		 * musicPlaylist::getMostViewedExtraQuery()
		 *
		 * @return
		 */
		public function getMostViewedExtraQuery()
		    {
		        /*action*/
		        // 1 = today
		        // 2 = yesterday
		        // 3 = this week
		        // 4 = this month
		        // 5 = this year
		        $extra_query = '';
		        switch ($this->fields_arr['action'])
					{
			            case 1:
			                $extra_query = ' AND DATE_FORMAT(vpl.date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
			            break;

			            case 2:
			                $extra_query = ' AND DATE_FORMAT(vpl.date_added,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
			            break;

			            case 3:
			                $extra_query = ' AND DATE_FORMAT(vpl.date_added,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
			            break;

			            case 4:
			                $extra_query = ' AND DATE_FORMAT(vpl.date_added,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
			            break;

			            case 5:
			                $extra_query = ' AND DATE_FORMAT(vpl.date_added,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
			            break;
			        }
		        return $extra_query;
		    }

		 /**
		  * musicPlaylist::getMostDiscussedExtraQuery()
		  *
		  * @return
		  */
		 public function getMostDiscussedExtraQuery()
		    {
		        $extra_query = '';
		        switch ($this->fields_arr['action'])
					{
			            case 1:
			                $extra_query = ' AND DATE_FORMAT(pc.date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
			            break;

			            case 2:
			                $extra_query = ' AND DATE_FORMAT(pc.date_added,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
			            break;

			            case 3:
			                $extra_query = ' AND DATE_FORMAT(pc.date_added,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
			            break;

			            case 4:
			                $extra_query = ' AND DATE_FORMAT(pc.date_added,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
			            break;

			            case 5:
			                $extra_query = ' AND DATE_FORMAT(pc.date_added,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
			            break;
			        }
		        return $extra_query;
		    }

		 /**
		  * musicPlaylist::getMostFavoriteExtraQuery()
		  *
		  * @return
		  */
		 public function getMostFavoriteExtraQuery()
		    {
		        $extra_query = '';
		        switch ($this->fields_arr['action']) {
		            case 1:
		                $extra_query = ' AND DATE_FORMAT(pf.date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
		            break;

		            case 2:
		                $extra_query = ' AND DATE_FORMAT(pf.date_added,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
		            break;

		            case 3:
		                $extra_query = ' AND DATE_FORMAT(pf.date_added,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
		            break;

		            case 4:
		                $extra_query = ' AND DATE_FORMAT(pf.date_added,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
		            break;

		            case 5:
		                $extra_query = ' AND DATE_FORMAT(pf.date_added,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
		            break;
		        }
		        return $extra_query;
		    }

		 /**
		  * musicPlaylist::getMostListenedExtraQuery()
		  *
		  * @return
		  */
		 public function getMostListenedExtraQuery()
		    {
		        $extra_query = '';
		        switch ($this->fields_arr['action']) {
		            case 1:
		                $extra_query = ' AND DATE_FORMAT(vpl.date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
		            break;

		            case 2:
		                $extra_query = ' AND DATE_FORMAT(vpl.date_added,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
		            break;

		            case 3:
		                $extra_query = ' AND DATE_FORMAT(vpl.date_added,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
		            break;

		            case 4:
		                $extra_query = ' AND DATE_FORMAT(vpl.date_added,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
		            break;

		            case 5:
		                $extra_query = ' AND DATE_FORMAT(vpl.date_added,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
		            break;
		        }
		        return $extra_query;
		    }

		/**
		 * musicPlaylist::getFeaturedPlaylistName()
		 *
		 * @return
		 */
		public function getFeaturedPlaylistName()
			{
				$sql = 'SELECT pl.playlist_name FROM '.$this->CFG['db']['tbl']['music_playlist'].' AS pl JOIN '.$this->CFG['db']['tbl']['users'].' AS u on u.user_id=pl.user_id '.
						'WHERE pl.featured = \'Yes\' AND pl.playlist_status = \'Ok\' AND u.usr_status=\'Ok\' ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$songDetail = $rs->FetchRow();
				return $songDetail['playlist_name'];
			}

		/**
		 * musicPlaylist::setFeaturedPlaylist()
		 *
		 * @return
		 */
		public function setFeaturedPlaylist()
			{
				$this->removeFeaturedPlaylist();
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist'].' SET featured = \'Yes\' '.
						'WHERE playlist_id = '.$this->fields_arr['playlist_id'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}

		/**
		 * musicPlaylist::removeFeaturedPlaylist()
		 *
		 * @return
		 */
		public function removeFeaturedPlaylist()
			{

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist'].' SET featured = \'No\' '.
							 'WHERE featured = \'Yes\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				return true;
			}

	}
//<<<<<-------------- Class musicPlaylistManage end ---------------//
//-------------------- Code begins -------------->>>>>//
$musicPlaylist = new musicPlaylist();
if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
/*echo '<pre>';
print_r($_REQUEST);
echo '</pre>';*/
$musicPlaylist->setPageBlockNames(array('filter_select_block', 'search_playlist_block', 'list_playlist_block', 'songlist_block'));
$musicPlaylist->setFormField('start', '0');
$musicPlaylist->setFormField('numpg', $CFG['data_tbl']['numpg']);
$musicPlaylist->setFormField('playlist_title', '');
$musicPlaylist->setFormField('tags', '');
$musicPlaylist->setFormField('createby', '');
$musicPlaylist->setFormField('tracks', '');
$musicPlaylist->setFormField('plays', '');
$musicPlaylist->setFormField('pg', '');
$musicPlaylist->setFormField('action', '');
$musicPlaylist->setFormField('playlist_id', '');
$musicPlaylist->setFormField('featured', '');
$musicPlaylist->setFormField('confirm', '');
$musicPlaylist->setFormField('light_window', '');
$musicPlaylist->setTableNames(array());
$musicPlaylist->setReturnColumns(array());
//General Query..
$musicPlaylist->sanitizeFormInputs($_REQUEST);
$musicPlaylist->setPageBlockShow('filter_select_block');
$musicPlaylist->setPageBlockShow('search_playlist_block');
$musicPlaylist->setPageBlockShow('list_playlist_block');
if($musicPlaylist->getFormField('light_window')!= '')
	{
		$musicPlaylist->setPageBlockShow('songlist_block');
	}

if($musicPlaylist->isFormPOSTed($_POST, 'search'))
	{
		$musicPlaylist->playlistAdvancedFilters();
	}
if($musicPlaylist->isFormPOSTed($_POST, 'avd_reset'))
	{
		$musicPlaylist->setFormField('playlist_title', '');
		$musicPlaylist->setFormField('tracks', '');
		$musicPlaylist->setFormField('createby', '');
		$musicPlaylist->setFormField('plays', '');
	}
if($musicPlaylist->getFormField('confirm')!='')
	{
		switch($musicPlaylist->getFormField('confirm'))
			{
				case 'featured':
					if($musicPlaylist->getFormField('featured') == 'Yes')
						{
							$musicPlaylist->setFeaturedPlaylist();
							$musicPlaylist->setCommonSuccessMsg($LANG['musicplaylist_update_successfully']);
							$musicPlaylist->setPageBlockShow('block_msg_form_success');
						}
					else
						{
							$musicPlaylist->removeFeaturedPlaylist();
							$musicPlaylist->setCommonSuccessMsg($LANG['musicplaylist_delete_successfully']);
							$musicPlaylist->setPageBlockShow('block_msg_form_success');
						}
				break;
			}
	}
//<<<<<-------------- Code end ----------------------------------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($musicPlaylist->isShowPageBlock('songlist_block'))
	{
		$musicPlaylist->includeHeader();
		$musicPlaylist->displaySongList($musicPlaylist->getFormField('playlist_id'));
		setTemplateFolder('general/', 'music');
		$smartyObj->display('songList.tpl');
		$musicPlaylist->includeFooter();
		exit;
	}
if ($musicPlaylist->isShowPageBlock('list_playlist_block'))
	{
		/****** navigtion continue*********/
		$musicPlaylist->setTableAndColumns();
		$musicPlaylist->buildSelectQuery();
		$musicPlaylist->buildQuery();
		$group_query_arr = array('featuredplaylistlist', 'playlistmostfavorite', 'featuredvideolist', 'playlistmostdiscussed', 'playlistmostviewed');
		if (in_array($musicPlaylist->getFormField('pg'), $group_query_arr))
       		$musicPlaylist->homeExecuteQuery();
    	else
			$musicPlaylist->executeQuery();
		if($musicPlaylist->isResultsFound())
			{
				$musicPlaylist->list_playlist_block['showPlaylists'] = $musicPlaylist->showPlaylists();
				if($musicPlaylist->getFormField('action'))
					$musicPlaylist->hidden_array[] = 'action';
				$smartyObj->assign('smarty_paging_list', $musicPlaylist->populatePageLinksGET($musicPlaylist->getFormField('start'), $musicPlaylist->hidden_array));
			}
		if ($musicPlaylist->getFormField('pg') == 'playlistmostviewed' or $musicPlaylist->getFormField('pg') == 'playlistmostdiscussed' or $musicPlaylist->getFormField('pg') == 'playlistmostfavorite' or $musicPlaylist->getFormField('pg') == 'playlistmostlistened')
			{
				$musicActionNavigation_arr['music_list_url_0'] = getUrl('musicplaylist', '?pg='.$musicPlaylist->getFormField('pg').'&action=0', $musicPlaylist->getFormField('pg').'/?action=0', '', 'music');
				$musicActionNavigation_arr['music_list_url_1'] = getUrl('musicplaylist', '?pg='.$musicPlaylist->getFormField('pg').'&action=1', $musicPlaylist->getFormField('pg').'/?action=1', '', 'music');
				$musicActionNavigation_arr['music_list_url_2'] = getUrl('musicplaylist', '?pg='.$musicPlaylist->getFormField('pg').'&action=2', $musicPlaylist->getFormField('pg').'/?action=2', '', 'music');
				$musicActionNavigation_arr['music_list_url_3'] = getUrl('musicplaylist', '?pg='.$musicPlaylist->getFormField('pg').'&action=3', $musicPlaylist->getFormField('pg').'/?action=3', '', 'music');
				$musicActionNavigation_arr['music_list_url_4'] = getUrl('musicplaylist', '?pg='.$musicPlaylist->getFormField('pg').'&action=4', $musicPlaylist->getFormField('pg').'/?action=4', '', 'music');
				$musicActionNavigation_arr['music_list_url_5'] = getUrl('musicplaylist', '?pg='.$musicPlaylist->getFormField('pg').'&action=5', $musicPlaylist->getFormField('pg').'/?action=5', '', 'music');
				$musicActionNavigation_arr['cssli_0'] = $musicActionNavigation_arr['cssli_1'] = $musicActionNavigation_arr['cssli_2'] = $musicActionNavigation_arr['cssli_3'] = $musicActionNavigation_arr['cssli_4'] = $musicActionNavigation_arr['cssli_5'] = '';
				if(!$musicPlaylist->getFormField('action')) $musicPlaylist->setFormField('action', '0');
					$sub_page = 'cssli_'.$musicPlaylist->getFormField('action');
					$musicActionNavigation_arr[$sub_page] = ' class="clsActiveTabNavigation"';
				$smartyObj->assign('musicActionNavigation_arr', $musicActionNavigation_arr);
			}
	}
$musicPlaylist->left_navigation_div = 'musicMain';
//include the header file
$musicPlaylist->includeHeader();
//include the content of the page
setTemplateFolder('admin/','music');
$smartyObj->display('musicPlaylist.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
?>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/functions.js"></script>
<script type="text/javascript" language="javascript">
var play_songs_playlist_player_url = '<?php echo $musicPlaylist->playSongsUrl; ?>';
</script>
<script type="text/javascript" language="javascript">
var block_arr= new Array('selMsgConfirmSingle');
var form_name_array = new Array('seachAdvancedFilter');
function loadUrl(element)
	{
		document.seachAdvancedFilter.action=element.value;
		document.seachAdvancedFilter.submit();
	}
function clearValue(id)
	{
		$Jq('#' + id).val('');
	}
function setOldValue(id)
	{
		if (($Jq('#' + id).val() =="") && (id == 'playlist_title') )
			$Jq('#' + id).val('<?php echo $LANG['musicplaylist_playlist_title']?>');
		else if (($Jq('#' + id).val() =="") && (id == 'createby') )
			$Jq('#' + id).val('<?php echo $LANG['musicplaylist_createby']?>');
		else if (($Jq('#' + id).val() =="") && (id == 'tracks') )
			$Jq('#' + id).val('<?php echo $LANG['musicplaylist_no_of_tracks']?>');
		else if (($Jq('#' + id).val() =="") && (id == 'plays') )
			$Jq('#' + id).val('<?php echo $LANG['musicplaylist_no_of_plays']?>');
	}
function popupWindow(url)
	{
		window.open (url, "","status=0,toolbar=0,resizable=1,scrollbars=1");
		return false;
	}
</script>
<?php
$musicPlaylist->includeFooter();
?>