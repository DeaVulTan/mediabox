<?php
//--------------class musicPlaylist--------------->>>//
/**
 * This class is used to music playlist and search page
 *
 * @category	Rayzz
 * @package		manage music playlist
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 */
class musicPlaylist extends MusicHandler
	{
		public $page_heading = '';
		public $hidden_array = array('pg');
		public $player_music_id=array();


	/**
     * MusicList::getPageTitle()
     *
     * @return
     */
    public function getPageTitle()
	    {
		    $pg_title = $this->LANG['musicplaylist_heading_playlistnew'];

			//If default value is Yes then reset the pg value as null.
		    if($this->getFormField('default')== 'Yes' && $this->fields_arr['pg'] == 'playlistnew')
				$this->fields_arr['pg'] = '';

			$categoryTitle = '';
			$tagsTitle     = '';
			$artistTitle   = '';

	        switch ($this->fields_arr['pg'])
				 {
		            case 'myplaylist':
		                $pg_title = $this->LANG['musicplaylist_title'];
		                break;
		            case 'playlisttoprated':
		                $pg_title = $this->LANG['musicplaylist_heading_toprated'];
		                break;
		            case 'playlistrecommended':
		                $pg_title = $this->LANG['musicplaylist_heading_mostrecommended'];
		                break;
		            case 'playlistmostlistened':
		                $pg_title = $this->LANG['musicplaylist_heading_mostlistened'];
		                break;
		            case 'playlistmostviewed':
		            	$pg_title = $this->LANG['musicplaylist_heading_mostviewed'];
		                break;
		            case 'playlistmostdiscussed':
		                $pg_title = $this->LANG['musicplaylist_heading_mostdiscussed'];
		                break;
		            case 'playlistmostfavorite':
		                $pg_title = $this->LANG['musicplaylist_heading_mostfavorite'];
		                break;
		            case 'featuredplaylistlist':
		                $pg_title = $this->LANG['musicplaylist_heading_mostfeaturedmusiclist'];
		                break;
		            case 'playlistmostrecentlyviewed':
		                $pg_title = $this->LANG['musicplaylist_heading_recentlyviewed'];
		                break;
		            case 'myrecentlyviewedplaylist':
		                $pg_title = $this->LANG['musicplaylist_heading_my_recently_viewed'];
		                break;
		            case 'myfeaturedplaylist':
		                $pg_title = $this->LANG['musicplaylist_heading_my_featured'];
		                break;
		            case 'myfavoriteplaylist':
		                $pg_title = $this->LANG['musicplaylist_heading_my_favorite'];
		                break;
		            default:

						if ($this->fields_arr['pg'] == 'playlistrecent'){
							$pg_title = $this->LANG['header_nav_music_music_new'];
						}else
							$pg_title = $this->LANG['musicplaylist_heading_playlistnew'];
		                break;
		        }

		        //change the page title if my music is selected
 			    if ($this->fields_arr['myplaylist'] == 'Yes' && $this->fields_arr['pg'] != 'myplaylist') {
				 	$pg_title = $pg_title.' '.$this->LANG['in'].' '.$this->LANG['musicplaylist_title'];
				 	if($this->fields_arr['pg'] == 'playlistnew' || $this->fields_arr['pg'] == '')
				 		$pg_title = $this->LANG['musicplaylist_title'];
				}

				//change the page title if my favorite is selected
				if ($this->fields_arr['myfavoriteplaylist'] == 'Yes' && $this->fields_arr['pg'] != 'myfavoriteplaylist') {
				 	$pg_title = $pg_title.' '.$this->LANG['in'].' '.$this->LANG['musicplaylist_heading_my_favorite'];
				 	if($this->fields_arr['pg'] == 'playlistnew' || $this->fields_arr['pg'] == '')
				 		$pg_title = $this->LANG['musicplaylist_heading_my_favorite'];
				}

				//change the page title if recored display via tags.
				if ($this->fields_arr['tags']){
		            $tagsTitle = $this->LANG['musicplaylist_tagsmusic_title'];
		            $name = $this->fields_arr['tags'];
		            $tagsTitle = str_replace('VAR_TAGS_NAME', $name, $tagsTitle);
		        }
				if(($this->fields_arr['pg'] || $this->getFormField('default')== 'Yes')&& $this->fields_arr['tags']){
					if($this->fields_arr['pg'] == '')
						$pg_title = $tagsTitle;
					else
						$pg_title = $pg_title.' '.$tagsTitle;
				}
		       $this->page_heading = $pg_title;
		    }

		/**
		 * musicPlaylist::showPlaylists()
		 *
		 * @return
		 */
		public function showPlaylists()
			{
				$showPlaylists_arr = array();
				$playlist_thumbnail_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['musics']['folder'] . '/' . $this->CFG['admin']['musics']['thumbnail_folder'] . '/';
				$inc=0;
				$showPlaylists_arr['row'] = array();
				$this->player_music_id = array();
				while($row = $this->fetchResultRecord())
					{
						$row['playlist_name'] = $row['playlist_name'];
						$row['date_added'] = ($row['date_added'] != '') ? getTimeDiffernceFormat($row['date_added']) : '';
						$showPlaylists_arr['row'][$inc]['record'] = $row;
						$showPlaylists_arr['row'][$inc]['record']['user_name'] = highlightWords($row['user_name'],$this->fields_arr['createby']);
						$showPlaylists_arr['row'][$inc]['getMemberProfileUrl'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
						$showPlaylists_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_playlist_title'] = highlightWords($row['playlist_name'],$this->fields_arr['playlist_title']);
						$showPlaylists_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_playlist_description'] = $row['playlist_description'];
						$showPlaylists_arr['row'][$inc]['view_playlisturl'] = getUrl('viewplaylist', '?playlist_id='.$row['playlist_id'].'&amp;title='.$this->changeTitle($row['playlist_name']), $row['playlist_id'].'/'.$this->changeTitle($row['playlist_name']).'/', '','music');
						$showPlaylists_arr['row'][$inc]['light_window_url'] = $this->CFG['site']['music_url'].'musicPlaylist.php?playlist_id='.$row['playlist_id'].'&light_window=1';
						$showPlaylists_arr['row'][$inc]['private_song'] = $row['total_tracks'] - $this->getPlaylistTotalSong($row['playlist_id']);
						$showPlaylists_arr['row'][$inc]['getPlaylistImageDetail'] = $this->getPlaylistImageDetail($row['playlist_id']);// This function return playlist image detail array..//
						$inc++;
					}
				/*echo '<pre>';
				print_r($showPlaylists_arr);
				echo '</pre>';*/
				return $showPlaylists_arr;
			}

		/**
		 * musicPlaylist::setShortItem()
		 *
		 * @return
		 */
		public function setShortItem()
			{
				if($this->fields_arr['short_by_playlist'] == 'title')
						$this->sql_sort = 'pl.playlist_name ASC';
				else
					$this->sql_sort = 'pl.total_tracks DESC';
			}

		/**
		 * musicPlaylist::myMusicCondition()
		 *
		 * @return string
		 * @access public
		 */
		public function myMusicCondition(){
			$userCondition = '';
			if($this->fields_arr['myplaylist'] != 'No')
				$userCondition = ' pl.user_id = '.$this->CFG['user']['user_id'].' AND ';
			return $userCondition;
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
							//$this->page_heading = $this->LANG['musicplaylist_heading_toprated'];
							//Query
							if($this->fields_arr['myfavoriteplaylist'] == 'No'){
								$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist'].' as pl JOIN '.$this->CFG['db']['tbl']['users'].' as u ON pl.user_id=u.user_id' ));
								$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'TIMEDIFF(NOW(), pl.date_added) AS date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.rating_count', 'pl.total_favorites', 'pl.total_featured', 'pl.playlist_tags', 'pl.playlist_description', 'u.user_name', 'u.user_id', 'pl.allow_ratings'));
							 	$this->sql_condition = $this->myMusicCondition().'pl.playlist_status=\'Yes\' AND pl.rating_total>0 AND pl.allow_ratings=\'Yes\' AND u.usr_status=\'Ok\''.$this->addtionalQuery().$this->playlistAdvancedFilters();
							}else{
								$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist'] . ' AS pl JOIN ' . $this->CFG['db']['tbl']['music_playlist_favorite'] . ' AS pf ON pl.playlist_id = pf.playlist_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
								$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'TIMEDIFF(NOW(), pl.date_added) AS date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.rating_count', 'pl.total_favorites', 'pl.total_featured', 'pl.playlist_tags', 'pl.playlist_description', 'u.user_name', 'u.user_id', 'pl.allow_ratings'));
								$this->sql_condition = ' pl.user_id = u.user_id AND u.usr_status=\'Ok\' AND pl.playlist_status=\'Yes\' AND pf.user_id=\''.$this->CFG['user']['user_id'].'\' '.$this->addtionalQuery().$this->playlistAdvancedFilters();
							}
							if($this->sql_sort == '')
								$this->sql_sort = 'rating DESC';
							//$this->page_heading = $this->LANG['musicplaylist_heading_toprated'];
						break;

						case 'playlistrecommended':
							//Heading
							//$this->page_heading = $this->LANG['musicplaylist_heading_mostrecommended'];
							//Query
							if($this->fields_arr['myfavoriteplaylist'] == 'No'){
								$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist'].' as pl JOIN '.$this->CFG['db']['tbl']['users'].' as u ON pl.user_id=u.user_id' ));
								$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'TIMEDIFF(NOW(), pl.date_added) AS date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.rating_count', 'pl.total_favorites', 'pl.total_featured', 'pl.playlist_tags', 'pl.playlist_description', 'u.user_name', 'u.user_id', 'pl.allow_ratings'));
							 	$this->sql_condition = $this->myMusicCondition().'pl.playlist_status=\'Yes\' AND pl.allow_ratings = \'Yes\' AND u.usr_status=\'Ok\''.$this->addtionalQuery().$this->playlistAdvancedFilters();
						 	}else{
								$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist'] . ' AS pl JOIN ' . $this->CFG['db']['tbl']['music_playlist_favorite'] . ' AS pf ON pl.playlist_id = pf.playlist_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
								$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'TIMEDIFF(NOW(), pl.date_added) AS date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.rating_count', 'pl.total_favorites', 'pl.total_featured', 'pl.playlist_tags', 'pl.playlist_description', 'u.user_name', 'u.user_id', 'pl.last_viewed_date', 'pl.allow_ratings'));
								$this->sql_condition = ' pl.user_id = u.user_id AND u.usr_status=\'Ok\' AND pl.playlist_status=\'Yes\' AND pl.allow_ratings = \'Yes\' AND pf.user_id=\''.$this->CFG['user']['user_id'].'\' '.$this->addtionalQuery().$this->playlistAdvancedFilters();
							}
							if($this->sql_sort == '')
								$this->sql_sort = 'rating DESC';
						break;

						case 'playlistmostlistened':
							//Heading
							//$this->page_heading = $this->LANG['musicplaylist_heading_mostlistened'];
							//Query
							if($this->fields_arr['myfavoriteplaylist'] == 'No'){
								$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist_listened'] . ' as vpl LEFT JOIN ' . $this->CFG['db']['tbl']['music_playlist'] . ' as pl ON pl.playlist_id=vpl.playlist_id '.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
								$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'TIMEDIFF(NOW(), pl.date_added) AS date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.rating_count', 'pl.total_favorites', 'pl.total_featured', 'pl.playlist_tags', 'pl.playlist_description', 'u.user_name', 'u.user_id', 'SUM(vpl.total_visits) as sum_total_visits', 'pl.allow_ratings'));
								$this->sql_condition = $this->myMusicCondition().'pl.playlist_status=\'Yes\' AND vpl.total_visits>0 AND pl.user_id = u.user_id AND u.usr_status=\'Ok\' '.$this->addtionalQuery().$this->playlistAdvancedFilters().$this->getMostListenedExtraQuery().' GROUP BY vpl.playlist_id';
							}else{
								$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist_listened'] . ' as vpl LEFT JOIN ' . $this->CFG['db']['tbl']['music_playlist'] . ' as pl ON pl.playlist_id=vpl.playlist_id JOIN ' . $this->CFG['db']['tbl']['music_playlist_favorite'] . ' AS pf ON pl.playlist_id = pf.playlist_id '.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
								$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'TIMEDIFF(NOW(), pl.date_added) AS date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.rating_count', 'pl.total_favorites', 'pl.total_featured', 'pl.playlist_tags', 'pl.playlist_description', 'u.user_name', 'u.user_id', 'SUM(vpl.total_visits) as sum_total_visits', 'pl.last_viewed_date', 'pl.allow_ratings'));
								$this->sql_condition = ' pl.user_id = u.user_id AND u.usr_status=\'Ok\' AND pl.playlist_status=\'Yes\' AND vpl.total_visits>0 AND pf.user_id=\''.$this->CFG['user']['user_id'].'\' '.$this->addtionalQuery().$this->playlistAdvancedFilters().$this->getMostListenedExtraQuery().' GROUP BY vpl.playlist_id';
							}
							if($this->sql_sort == '')
								$this->sql_sort = 'sum_total_visits DESC';
						break;

						case 'playlistmostviewed':
							//Heading
							//$this->page_heading = $this->LANG['musicplaylist_heading_mostviewed'];
							//Query
							$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist_viewed'] . ' as vpl LEFT JOIN ' . $this->CFG['db']['tbl']['music_playlist'] . ' as pl ON pl.playlist_id=vpl.playlist_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
							$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'TIMEDIFF(NOW(), pl.date_added) AS date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.rating_count', 'pl.total_favorites', 'pl.total_featured', 'pl.playlist_tags', 'pl.playlist_description', 'u.user_name', 'u.user_id', 'SUM(vpl.total_views) as sum_total_views', 'pl.allow_ratings'));
							$this->sql_condition = 'pl.playlist_status=\'Yes\' AND pl.total_views>0 AND pl.user_id = u.user_id AND u.usr_status=\'Ok\' '.$this->addtionalQuery().$this->playlistAdvancedFilters().$this->getMostViewedExtraQuery().' GROUP BY vpl.playlist_id';
							if($this->sql_sort == '')
								$this->sql_sort = 'sum_total_views DESC';
						break;

						case 'playlistmostdiscussed':
							//Heading
							//$this->page_heading = $this->LANG['musicplaylist_heading_toprated'];
							//Query
							if($this->fields_arr['myfavoriteplaylist'] == 'No'){
								$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist'] . ' AS pl JOIN ' . $this->CFG['db']['tbl']['music_playlist_comments'] . ' AS pc ON pl.playlist_id = pc.playlist_id '.', ' . $this->CFG['db']['tbl']['users'] . ' as u '));
								$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'TIMEDIFF(NOW(), pl.date_added) AS date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.rating_count', 'pl.total_favorites', 'pl.total_featured', 'pl.playlist_tags', 'pl.playlist_description', 'u.user_name', 'u.user_id', 'count( pc.playlist_comment_id ) AS total_comments', 'pl.allow_ratings'));
							 	$this->sql_condition = $this->myMusicCondition().'pl.playlist_status=\'Yes\' AND pl.allow_comments = \'Yes\' AND pl.user_id = u.user_id AND u.usr_status=\'Ok\''.$this->addtionalQuery().$this->playlistAdvancedFilters().$this->getMostDiscussedExtraQuery().' GROUP BY pc.playlist_id';
						 	}else{
								$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist_comments'] . ' as pc LEFT JOIN ' . $this->CFG['db']['tbl']['music_playlist'] . ' as pl ON pl.playlist_id = pc.playlist_id JOIN ' . $this->CFG['db']['tbl']['music_playlist_favorite'] . ' AS pf ON pl.playlist_id = pf.playlist_id '.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
								$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'TIMEDIFF(NOW(), pl.date_added) AS date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.rating_count', 'pl.total_favorites', 'pl.total_featured', 'pl.playlist_tags', 'pl.playlist_description', 'u.user_name', 'u.user_id', 'count( pc.playlist_comment_id ) AS total_comments', 'pl.last_viewed_date', 'pl.allow_ratings'));
								$this->sql_condition = ' pl.user_id = u.user_id AND u.usr_status=\'Ok\' AND pl.playlist_status=\'Yes\' AND pl.allow_comments = \'Yes\' AND pf.user_id=\''.$this->CFG['user']['user_id'].'\' '.$this->addtionalQuery().$this->playlistAdvancedFilters().$this->getMostDiscussedExtraQuery().' GROUP BY pc.playlist_id';
							}
							if($this->sql_sort == '')
								$this->sql_sort = 'total_comments, total_views DESC';
							//$this->page_heading = $this->LANG['musicplaylist_heading_mostdiscussed'];
						break;

						case 'playlistmostfavorite':
							//Heading
							//$this->page_heading = $this->LANG['musicplaylist_heading_mostfavorite'];
							//Query
							$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist'] . ' AS pl JOIN ' . $this->CFG['db']['tbl']['music_playlist_favorite'] . ' AS pf ON pl.playlist_id = pf.playlist_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
							$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'TIMEDIFF(NOW(), pl.date_added) AS date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.rating_count', 'pl.total_favorites', 'pl.total_featured', 'pl.playlist_tags', 'pl.playlist_description', 'u.user_name', 'u.user_id', 'pl.last_viewed_date', 'count( pf.music_playlist_favorite_id ) AS total_favorite', 'pl.allow_ratings'));
							if($this->fields_arr['myfavoriteplaylist'] == 'No'){
								$this->sql_condition = $this->myMusicCondition().'pl.playlist_status=\'Yes\' AND pl.user_id = u.user_id AND u.usr_status=\'Ok\''.$this->addtionalQuery().$this->playlistAdvancedFilters().$this->getMostFavoriteExtraQuery().' GROUP BY pf.playlist_id';
							}else{
								$this->sql_condition = ' pl.user_id = u.user_id AND u.usr_status=\'Ok\' AND pl.playlist_status=\'Yes\' AND pf.user_id=\''.$this->CFG['user']['user_id'].'\' '.$this->addtionalQuery().$this->playlistAdvancedFilters().$this->getMostFavoriteExtraQuery().' GROUP BY pf.playlist_id';
							}

							if($this->sql_sort == '')
								$this->sql_sort = 'total_favorite, pl.total_views DESC';
						break;

						case 'featuredplaylistlist':
							//Heading
							//$this->page_heading = $this->LANG['musicplaylist_heading_mostfeaturedmusiclist'];
							//Query
							if($this->fields_arr['myfavoriteplaylist'] == 'No'){
								$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist_featured'] . ' as fpl LEFT JOIN ' . $this->CFG['db']['tbl']['music_playlist'] . ' as pl ON fpl.playlist_id=pl.playlist_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
								$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'TIMEDIFF(NOW(), pl.date_added) AS date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.rating_count', 'pl.total_favorites', 'pl.total_featured', 'pl.playlist_tags', 'pl.playlist_description', 'u.user_name', 'u.user_id', 'pl.last_viewed_date', 'count( fpl.music_playlist_featured_id ) AS total_featured', 'pl.allow_ratings'));
								$this->sql_condition = $this->myMusicCondition().'pl.playlist_status=\'Yes\' AND pl.user_id = u.user_id AND u.usr_status=\'Ok\''.$this->addtionalQuery().$this->playlistAdvancedFilters().' GROUP BY fpl.playlist_id';
							}else{
								$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist_featured'] . ' as fpl LEFT JOIN ' . $this->CFG['db']['tbl']['music_playlist'] . ' as pl ON pl.playlist_id = fpl.playlist_id JOIN ' . $this->CFG['db']['tbl']['music_playlist_favorite'] . ' AS pf ON pl.playlist_id = pf.playlist_id '.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
								$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'TIMEDIFF(NOW(), pl.date_added) AS date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.rating_count', 'pl.total_favorites', 'pl.total_featured', 'pl.playlist_tags', 'pl.playlist_description', 'u.user_name', 'u.user_id', 'pl.last_viewed_date', 'count( fpl.music_playlist_featured_id ) AS total_featured', 'pl.last_viewed_date', 'pl.allow_ratings'));
								$this->sql_condition = ' pl.user_id = u.user_id AND u.usr_status=\'Ok\' AND pl.playlist_status=\'Yes\' AND pl.allow_comments = \'Yes\' AND pf.user_id=\''.$this->CFG['user']['user_id'].'\' '.$this->addtionalQuery().$this->playlistAdvancedFilters().' GROUP BY fpl.playlist_id';
							}
							if($this->sql_sort == '')
								$this->sql_sort = 'total_featured, pl.total_views DESC';
						break;

						case 'playlistmostrecentlyviewed':
							//Heading
							//$this->page_heading = $this->LANG['musicplaylist_heading_recentlyviewed'];
							//Query
							if($this->fields_arr['myfavoriteplaylist'] == 'No'){
								$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist'].' as pl JOIN '.$this->CFG['db']['tbl']['users'].' as u ON pl.user_id=u.user_id' ));
								$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'TIMEDIFF(NOW(), pl.date_added) AS date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.rating_count', 'pl.total_favorites', 'pl.total_featured', 'pl.playlist_tags', 'pl.playlist_description', 'u.user_name', 'u.user_id', 'pl.last_viewed_date', 'pl.allow_ratings'));
								$this->sql_condition = $this->myMusicCondition().'pl.playlist_status=\'Yes\' AND u.usr_status=\'Ok\' '.$this->addtionalQuery().$this->playlistAdvancedFilters();
							}else{
								$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist'] . ' AS pl JOIN ' . $this->CFG['db']['tbl']['music_playlist_favorite'] . ' AS pf ON pl.playlist_id = pf.playlist_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
								$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'TIMEDIFF(NOW(), pl.date_added) AS date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.rating_count', 'pl.total_favorites', 'pl.total_featured', 'pl.playlist_tags', 'pl.playlist_description', 'u.user_name', 'u.user_id', 'pl.last_viewed_date', 'pl.allow_ratings'));
								$this->sql_condition = ' pl.user_id = u.user_id AND u.usr_status=\'Ok\' AND pl.playlist_status=\'Yes\' AND pf.user_id=\''.$this->CFG['user']['user_id'].'\' '.$this->addtionalQuery().$this->playlistAdvancedFilters();
							}
							if($this->sql_sort == '')
								$this->sql_sort = 'pl.last_viewed_date DESC';
						break;

						case 'myplaylist':
							$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist'].' as pl JOIN '.$this->CFG['db']['tbl']['users'].' as u ON pl.user_id=u.user_id' ));
							$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'TIMEDIFF(NOW(), pl.date_added) AS date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.rating_count', 'pl.total_favorites', 'pl.total_featured', 'pl.playlist_tags', 'pl.playlist_description', 'u.user_name', 'u.user_id', 'pl.allow_ratings'));
						 	$this->sql_condition = 'pl.user_id=\''.$this->CFG['user']['user_id'].'\' AND pl.playlist_status=\'Yes\' AND u.usr_status=\'Ok\''.$this->addtionalQuery().$this->playlistAdvancedFilters();
							if($this->sql_sort == '')
								$this->sql_sort = 'pl.playlist_id DESC';
							//$this->page_heading = '';
						break;

						case 'myrecentlyviewedplaylist':
							//Heading
							//$this->page_heading = $this->LANG['musicplaylist_heading_my_recently_viewed'];
							//Query
							$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist_viewed'] . ' as vpl LEFT JOIN ' . $this->CFG['db']['tbl']['music_playlist'] . ' as pl ON vpl.playlist_id=pl.playlist_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
							$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'TIMEDIFF(NOW(), pl.date_added) AS date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.rating_count', 'pl.total_favorites', 'pl.total_featured', 'pl.playlist_tags', 'pl.playlist_description', 'u.user_name', 'u.user_id', 'pl.allow_ratings'));
							$this->sql_condition = 'pl.user_id = u.user_id AND  u.usr_status=\'Ok\' AND pl.playlist_status=\'Yes\' AND vpl.user_id=\''.$this->CFG['user']['user_id'].'\' '.$this->addtionalQuery().$this->playlistAdvancedFilters();
							if($this->sql_sort == '')
								$this->sql_sort = 'playlist_viewed_id DESC';

						break;

						case 'myfeaturedplaylist':
							//Heading
							//$this->page_heading = $this->LANG['musicplaylist_heading_my_featured'];
							//Query
							$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist_featured'] . ' as fpl LEFT JOIN ' . $this->CFG['db']['tbl']['music_playlist'] . ' as pl ON fpl.playlist_id=pl.playlist_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
							$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'TIMEDIFF(NOW(), pl.date_added) AS date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.rating_count', 'pl.total_favorites', 'pl.total_featured', 'pl.playlist_tags', 'pl.playlist_description', 'u.user_name', 'u.user_id', 'pl.last_viewed_date', 'pl.allow_ratings'));
							$this->sql_condition = 'pl.user_id = u.user_id AND u.usr_status=\'Ok\' AND pl.playlist_status=\'Yes\' AND fpl.user_id=\''.$this->CFG['user']['user_id'].'\' '.$this->addtionalQuery().$this->playlistAdvancedFilters();
							if($this->sql_sort == '')
								$this->sql_sort = 'fpl.music_playlist_featured_id DESC';
						break;

						case 'myfavoriteplaylist':
								//Heading
							//$this->page_heading = $this->LANG['musicplaylist_heading_my_favorite'];
							//Query
							$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist'] . ' AS pl JOIN ' . $this->CFG['db']['tbl']['music_playlist_favorite'] . ' AS pf ON pl.playlist_id = pf.playlist_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
							$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'TIMEDIFF(NOW(), pl.date_added) AS date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.rating_count', 'pl.total_favorites', 'pl.total_featured', 'pl.playlist_tags', 'pl.playlist_description', 'u.user_name', 'u.user_id', 'pl.last_viewed_date', 'pl.allow_ratings'));
							$this->sql_condition = ' pl.user_id = u.user_id AND u.usr_status=\'Ok\' AND pl.playlist_status=\'Yes\' AND pf.user_id=\''.$this->CFG['user']['user_id'].'\' '.$this->addtionalQuery().$this->playlistAdvancedFilters();
							if($this->sql_sort == '')
								$this->sql_sort = ' pf.music_playlist_favorite_id DESC';

						break;

						default:
							if($this->fields_arr['myfavoriteplaylist'] == 'No'){
								$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist'].' as pl JOIN '.$this->CFG['db']['tbl']['users'].' as u ON pl.user_id=u.user_id' ));
								$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'TIMEDIFF(NOW(), pl.date_added) AS date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.rating_count', 'pl.total_favorites', 'pl.total_featured', 'pl.playlist_tags', 'pl.playlist_description', 'u.user_name', 'u.user_id', 'pl.allow_ratings'));
								$this->sql_condition = $this->myMusicCondition().'pl.playlist_status=\'Yes\' AND u.usr_status=\'Ok\''.$this->addtionalQuery().$this->playlistAdvancedFilters();
							}else{
								$this->setTableNames(array($this->CFG['db']['tbl']['music_playlist'] . ' AS pl JOIN ' . $this->CFG['db']['tbl']['music_playlist_favorite'] . ' AS pf ON pl.playlist_id = pf.playlist_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
								$this->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'TIMEDIFF(NOW(), pl.date_added) AS date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'pl.total_views', 'pl.total_comments', '(pl.rating_total/pl.rating_count) as rating', 'pl.rating_count', 'pl.total_favorites', 'pl.total_featured', 'pl.playlist_tags', 'pl.playlist_description', 'u.user_name', 'u.user_id', 'pl.last_viewed_date', 'pl.allow_ratings'));
								$this->sql_condition = ' pl.user_id = u.user_id AND u.usr_status=\'Ok\' AND pl.playlist_status=\'Yes\' AND pf.user_id=\''.$this->CFG['user']['user_id'].'\' '.$this->addtionalQuery().$this->playlistAdvancedFilters();
							}

							if($this->sql_sort == '')
								$this->sql_sort = 'pl.playlist_id DESC';
							//$this->page_heading = $this->LANG['musicplaylist_heading_playlistnew'];
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
				$this->advanceSearch = false;
				if ($this->fields_arr['playlist_title'] != $this->LANG['musicplaylist_playlist_title'] AND $this->fields_arr['playlist_title'])
					{
						$this->hidden_array[] = 'playlist_title';
						$playlistAdvancedFilters .= ' AND pl.playlist_name LIKE \'%' .validFieldSpecialChr($this->fields_arr['playlist_title']). '%\' ';
						$this->advanceSearch = true;
					}
				if ($this->fields_arr['createby'] != $this->LANG['musicplaylist_createby'] AND $this->fields_arr['createby'])
					{
						$this->hidden_array[] = 'createby';
						$playlistAdvancedFilters .= ' AND u.user_name LIKE \'%' .validFieldSpecialChr($this->fields_arr['createby']). '%\' ';
						$this->advanceSearch = true;
					}
				if ($this->fields_arr['tracks'] != $this->LANG['musicplaylist_no_of_tracks'] AND $this->fields_arr['tracks'])
					{
						$this->hidden_array[] = 'tracks';
						switch ($this->getFormField('tracks')){
							case 2:
								$playlistAdvancedFilters .= ' AND pl.total_tracks <10 AND pl.total_tracks >= 0';
								break;

							case 3:
								$playlistAdvancedFilters .= ' AND pl.total_tracks >=10 AND pl.total_tracks<20';
								break;

							case 4:
								$playlistAdvancedFilters .= ' AND pl.total_tracks >=20 AND pl.total_tracks<30';
								break;

							case 5:
								$playlistAdvancedFilters .= ' AND pl.total_tracks > 30 ';
								break;
						}
						//$playlistAdvancedFilters .= ' AND pl.total_tracks = \'' .$this->fields_arr['tracks']. '\' ';
						$this->advanceSearch = true;
					}
				if ($this->fields_arr['plays'] != $this->LANG['musicplaylist_no_of_plays'] AND $this->fields_arr['plays'])
					{
						$this->hidden_array[] = 'plays';
						switch ($this->getFormField('plays')){
							case 2:
								$playlistAdvancedFilters .= ' AND pl.total_views <10 AND pl.total_views >= 0';
								break;

							case 3:
								$playlistAdvancedFilters .= ' AND pl.total_views >=10 AND pl.total_views<20';
								break;

							case 4:
								$playlistAdvancedFilters .= ' AND pl.total_views >=20 AND pl.total_views<30';
								break;

							case 5:
								$playlistAdvancedFilters .= ' AND pl.total_views > 30 ';
								break;
						}
						//$playlistAdvancedFilters .= ' AND pl.total_views = \'' .$this->fields_arr['plays']. '\' ';
						$this->advanceSearch = true;
					}
				return $playlistAdvancedFilters;
			}

		public function chkAdvanceResultFound(){
			if($this->advanceSearch)
				return true;

			return false;
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
$musicPlaylist->LANG_SEARCH_TRACK_ARR = $LANG_SEARCH_ARR['searchtotaltracks'];
$musicPlaylist->LANG_SEARCH_PLAY_ARR = $LANG_SEARCH_ARR['searchtotalplays'];
$musicPlaylist->setFormField('start', '0');
$musicPlaylist->setFormField('numpg', $CFG['music_tbl']['numpg']);
$musicPlaylist->setFormField('playlist_title', '');
$musicPlaylist->setFormField('tags', '');
$musicPlaylist->setFormField('createby', '');
$musicPlaylist->setFormField('tracks', '');
$musicPlaylist->setFormField('plays', '');
$musicPlaylist->setFormField('pg', '');
$musicPlaylist->setFormField('action', '');
$musicPlaylist->setFormField('action_new', '');
$musicPlaylist->setFormField('light_window', '');
$musicPlaylist->setFormField('short_by_playlist', '');
$musicPlaylist->setFormField('playlist_id', '');
$musicPlaylist->setFormField('default', 'Yes');
$musicPlaylist->setFormField('myplaylist', 'No');
$musicPlaylist->setFormField('myfavoriteplaylist', 'No');
$musicPlaylist->setTableNames(array());
$musicPlaylist->setReturnColumns(array());
//General Query..
$musicPlaylist->sanitizeFormInputs($_REQUEST);

if($musicPlaylist->getFormField('default')== 'Yes' && $musicPlaylist->getFormField('pg')== 'musicnew' && $musicPlaylist->getFormField('tags') == '')
	$musicPlaylist->setFormField('pg', '');
elseif($musicPlaylist->getFormField('default')== 'No')
	$musicPlaylist->setFormField('pg', (isset($_GET['pg']) && !empty($_GET['pg']))?$_GET['pg']:$_REQUEST['pg']);

//START TO GENERATE THE HIDDEN PLAYER ARRAY FIELDS
$music_fields = array(
	'div_id'               => 'view_playlist',
	'music_player_id'      => 'view_playlist_player',
	'width'  		       => 1,
	'height'               => 1,
	'auto_play'            => 'false',
	'hidden'               => true,
	'playlist_auto_play'   => false,
	'javascript_enabled'   => true,
	'player_ready_enabled' => true
);

$smartyObj->assign('music_fields',$music_fields);
//END TO GENERATE THE HIDDEN PLAYER ARRAY FIELDS
if(isset($_REQUEST['action']))
	$musicPlaylist->setFormField('action_new', $_REQUEST['action']);

$action_new = $musicPlaylist->getFormField('action_new');
$musicPlaylist->setFormField('action', $action_new);


$musicPlaylist->setPageBlockShow('filter_select_block');
$musicPlaylist->setPageBlockShow('search_playlist_block');
$musicPlaylist->setPageBlockShow('list_playlist_block');
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
if($musicPlaylist->getFormField('light_window')!= '')
	{
		$musicPlaylist->setPageBlockShow('songlist_block');
	}
if($musicPlaylist->getFormField('short_by_playlist')!= '')
	{
		$musicPlaylist->setShortItem();
		$musicPlaylist->hidden_array[] = 'short_by_playlist';
	}
$musicPlaylist->getPageTitle();

if($musicPlaylist->getFormField('pg')== 'myplaylist')
	$musicPlaylist->setFormField('myplaylist', 'Yes');

if($musicPlaylist->getFormField('pg')== 'myfavoriteplaylist')
	$musicPlaylist->setFormField('myfavoriteplaylist', 'Yes');


//<<<<<-------------- Code end ----------------------------------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($musicPlaylist->isShowPageBlock('songlist_block'))
	{
		$musicPlaylist->includeHeader();
		$musicPlaylist->sanitizeFormInputs($_REQUEST);
		$musicPlaylist->populateMusicJsVars();
		$musicPlaylist->displaySongList($musicPlaylist->getFormField('playlist_id'));
		?>
		<script type="text/javascript" src="<?php echo $CFG['site']['music_url'].'js/functions.js';?>"></script>
		<script type="text/javascript" src="<?php echo $CFG['site']['url'].'js/lib/prototype.js';?>"></script>
		<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/JSFCommunicator.js"></script>
		<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
		<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/effects.js"></script>
		<script type="text/javascript" language="javascript">
		total_musics_to_play = <?php echo count($musicPlaylist->player_music_id); ?>;
		<?php
		//player configuratiosn
		//Initializing Playlist Player Configuaration
		$musicPlaylist->populatePlayerWithPlaylistConfiguration();
		$musicPlaylist->configXmlcode_url .= 'pg=music';
		$musicPlaylist->playlistXmlcode_url .= 'pg=music_0_'.implode(',', $musicPlaylist->player_music_id);
		foreach($musicPlaylist->player_music_id as $music_id_to_play)
		{
		       echo 'total_musics_ids_play_arr.push('.$music_id_to_play.');';
		}
		?>
		</script>
	   <?php
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
		//$musicPlaylist->printQuery();
		$group_query_arr = array('featuredplaylistlist', 'playlistmostfavorite', 'featuredplaylistlist', 'playlistmostdiscussed', 'playlistmostviewed');
		if (in_array($musicPlaylist->getFormField('pg'), $group_query_arr))
       		$musicPlaylist->homeExecuteQuery();
    	else
			$musicPlaylist->executeQuery();

		//$musicPlaylist->printQuery();
		if ($CFG['feature']['rewrite_mode'] != 'normal')
            $paging_arr = array('start','playlist_title','createby','tracks','plays','tags','short_by_playlist','action', 'myplaylist', 'myfavoriteplaylist');
        else
            $paging_arr = array('pg','start','playlist_title','createby','tracks','plays','tags','short_by_playlist','action', 'myplaylist', 'myfavoriteplaylist');
		$smartyObj->assign('paging_arr',$paging_arr);
		if($musicPlaylist->isResultsFound())
			{
				$musicPlaylist->list_playlist_block['showPlaylists'] = $musicPlaylist->showPlaylists();
				if($musicPlaylist->getFormField('action'))
					$musicPlaylist->hidden_array[] = 'action';
				//$musicPlaylist->hidden_array[] = 'pg';
				if ($CFG['feature']['rewrite_mode'] != 'normal')
		            $paging_arr = array('start','playlist_title','createby','tracks','plays','tags','short_by_playlist','action', 'myplaylist', 'myfavoriteplaylist');
		        else
		            $paging_arr = array('pg','start','playlist_title','createby','tracks','plays','tags','short_by_playlist','action', 'myplaylist', 'myfavoriteplaylist');
				$smartyObj->assign('paging_arr',$paging_arr);
				$smartyObj->assign('smarty_paging_list', $musicPlaylist->populatePageLinksPOST($musicPlaylist->getFormField('start'), 'seachAdvancedFilter'));
				//$smartyObj->assign('smarty_paging_list', $musicPlaylist->populatePageLinksGET($musicPlaylist->getFormField('start'), $musicPlaylist->hidden_array));
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
					$musicActionNavigation_arr[$sub_page] = ' class="clsActive"';
				$smartyObj->assign('musicActionNavigation_arr', $musicActionNavigation_arr);
			}
	}
//include the header file
$musicPlaylist->includeHeader();
//include the content of the page
setTemplateFolder('general/','music');
$smartyObj->display('musicPlaylist.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
?>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/functions.js"></script>
<script type="text/javascript" language="javascript">
var play_songs_playlist_player_url = '<?php echo $musicPlaylist->playSongsUrl; ?>';
</script>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'].'js/functions.js';?>"></script>
<script type="text/javascript" language="javascript">
var form_name_array = new Array('seachAdvancedFilter');
function loadUrl(element)
	{
		document.seachAdvancedFilter.start.value = '0';
		document.getElementById('default').value = 'No';
		document.seachAdvancedFilter.action=element.value;
		document.seachAdvancedFilter.submit();
	}
function clearValue(id)
	{
		if (($Jq('#' + id).val() =='<?php echo $LANG['musicplaylist_playlist_title']?>') && (id == 'playlist_title') )
			$Jq('#' + id).val('');
		else if (($Jq('#' + id).val() =='<?php echo $LANG['musicplaylist_createby']?>') && (id == 'createby') )
			$Jq('#' + id).val('');
	}
function setOldValue(id)
	{
		if (($Jq('#' + id).val() =="")  && (id == 'playlist_title') )
			$Jq('#' + id).val('<?php echo $LANG['musicplaylist_playlist_title']?>');
		else if (($Jq('#' + id).val() =="") && (id == 'createby') )
			$Jq('#' + id).val('<?php echo $LANG['musicplaylist_createby']?>');
	}
function shortOrder(short_value)
	{
		document.seachAdvancedFilter.start.value = '0';
		document.seachAdvancedFilter.short_by_playlist.value = short_value;
		document.seachAdvancedFilter.submit();
	}
</script>
<?php
$musicPlaylist->includeFooter();
?>
