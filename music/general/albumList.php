<?php
//--------------class musicAlbumList--------------->>>//
/**
* This class is used to music album list and search page
*
* @category		Rayzz
* @package		manage music albumlist
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
*/
class musicAlbumList extends MusicHandler
	{
		public $page_heading = '';
		public $hidden_array = array();
		public $advanceSearch;
		public $player_music_id=array();
		/**
		* musicAlbumList::showAlbumlists()
		*
		* @return
		*/
		public function showAlbumlists()
		{
			global $smartyObj;
			$showAlbumlists_arr = array();
			$musics_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
			$inc=0;
			$showAlbumlists_arr['row'] = array();
			while($row = $this->fetchResultRecord())
				{

					$showAlbumlists_arr[$inc]['light_window_url'] = $this->CFG['site']['music_url'].'albumList.php?music_album_id='.$row['music_album_id'].'&light_window=1'.'&music_id='.$row['music_id'];
					$showAlbumlists_arr['row'][$inc]['record'] = $row;
					$showAlbumlists_arr['row'][$inc]['album_for_sale'] = $row['album_for_sale'];
					$showAlbumlists_arr['row'][$inc]['album_price'] = $row['album_price'];
					$album_price = strstr($row['album_price'], '.');
	                if(!$album_price)
	                {
	                  $showAlbumlists_arr['row'][$inc]['album_price']=$row['album_price'].'.00';
					}
					else
					{
                       $showAlbumlists_arr['row'][$inc]['album_price']=$row['album_price'];
					}
					$showAlbumlists_arr['row'][$inc]['music_id'] = $row['music_id'];
					$showAlbumlists_arr['row'][$inc]['user_id'] = $row['user_id'];
					$showAlbumlists_arr['row'][$inc]['music_title'] = $row['music_title'];
					$showAlbumlists_arr['row'][$inc]['music_album_id'] = $row['music_album_id'];
					$showAlbumlists_arr['row'][$inc]['word_wrap_album_title'] = highlightWords($row['album_title'],$this->fields_arr['albumlist_title']);
					$showAlbumlists_arr['row'][$inc]['music_path'] = $showAlbumlists_arr[$inc]['music_path'] = $this->CFG['site']['url'].'music/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/no-playlist.gif';
					$showAlbumlists_arr['row'][$inc]['disp_image']="";
					$showAlbumlists_arr['row'][$inc]['light_window_url'] = $this->CFG['site']['music_url'].'albumList.php?music_album_id='.$row['music_album_id'].'&light_window=1';
					$showAlbumlists_arr['row'][$inc]['getUrl_viewAlbum_url'] =getUrl('viewalbum', '?album_id='.$row['music_album_id'].'&title='.$this->changeTitle($row['album_title']),$row['music_album_id'].'/'.$this->changeTitle($row['album_title']).'/', '', 'music');
					$showAlbumlists_arr['row'][$inc]['album_editable'] = 0;
					if($this->chkIsAlbumEditable($row['music_album_id']))
					{
						$showAlbumlists_arr['row'][$inc]['album_editable'] = 1;
					}

					$showAlbumlists_arr['row'][$inc]['getUrl_editAlbum_url'] =getUrl('musicalbummanage', '?music_album_id='.$row['music_album_id'], '?music_album_id='.$row['music_album_id'], 'members', 'music');
					$album_image_name=$this->getAlbumImageName($row['music_album_id'], 'thumb');
					if($album_image_name['music_thumb_ext'])
						{
							 $showAlbumlists_arr['row'][$inc]['music_image_src']  = $album_image_name['music_server_url'] . $musics_folder . getMusicImageName($album_image_name['music_id'],$album_image_name['file_name']) . $this->CFG['admin']['musics']['thumb_name'] . '.' .$album_image_name['music_thumb_ext'];
						}
					else
						{
							$showAlbumlists_arr['row'][$inc]['music_image_src'] = '';
						}
					$showAlbumlists_arr['row'][$inc]['total_song'] = $total_song =	$this->getAlbumTotalSong($row['music_album_id']);
					$showAlbumlists_arr['row'][$inc]['public_song'] = $public_song =	$this->getAlbumTotalSong($row['music_album_id'], true);
					$showAlbumlists_arr['row'][$inc]['private_song'] = 	$total_song-$public_song;
					$inc++;
				}
				return $showAlbumlists_arr;
		}

		public function chkIsAlbumEditable($album_id)
		{
			$sql = 'SELECT ma.music_album_id, m.user_id FROM '.
					$this->CFG['db']['tbl']['music_album'].' as ma '.
					' LEFT JOIN '.$this->CFG['db']['tbl']['music'].' as m '.
					' ON ma.music_album_id=m.music_album_id '.
					' WHERE ma.music_album_id='.$this->dbObj->Param('music_album_id').
					' AND ma.user_id='.$this->dbObj->Param('uer_id').
					' AND ma.user_id!=m.user_id';
			$stmt = $this->dbObj->Prepare($sql);
			 $rs = $this->dbObj->Execute($stmt, array($album_id, $this->CFG['user']['user_id']));
			 if (!$rs)
			 	trigger_db_error($this->dbObj);
			if($row = $rs->FetchRow())
			{
				return false;
			}
			return true;
		}

		/**
		* musicAlbumList::setTableAndColumns()
		*
		* @return
		*/
		public function setTableAndColumns()
			{
			switch ($this->fields_arr['pg'])
				{
					case 'albummostlistened':
					//Heading
					$this->page_heading = $this->LANG['musicalbumList_heading_mostlistened'];
					//Query
					$this->setTableNames(array($this->CFG['db']['tbl']['music_album_listened'] . ' AS lal LEFT JOIN ' . $this->CFG['db']['tbl']['music_album'] . ' AS al ON lal.album_id=al.music_album_id, '.$this->CFG['db']['tbl']['music'].' AS m LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON mr.music_artist_id=m.music_artist'.', '.$this->CFG['db']['tbl']['users'] . ' AS u '));
					$this->setReturnColumns(array('al.music_album_id', 'al.album_title', 'al.date_added', 'al.thumb_music_id as music_id', 'count(m.music_id) as total_tracks', 'al.total_album_views as total_views', 'sum(m.total_plays) as total_plays', 'SUM(lal.total_plays) as sum_total_plays','m.music_server_url','count( m.music_id ) AS total_songs','m.music_title','m.thumb_width','m.thumb_height','al.album_for_sale','al.user_id','al.album_price'));
					$this->sql_condition = 'lal.total_plays>0 AND lal.user_id = u.user_id AND m.music_status = \'OK\' AND u.usr_status=\'Ok\''.$this->albumlistAdvancedFilters().$this->getMostListenedExtraQuery().' GROUP BY lal.album_id';
					$this->sql_sort = 'sum_total_plays DESC';
					break;

					case 'albummostviewed':
					//Heading
					$this->page_heading = $this->LANG['musicalbumList_heading_mostviewed'];
					//Query
					$this->setTableNames(array($this->CFG['db']['tbl']['music_album_viewed'] . ' AS val LEFT JOIN ' . $this->CFG['db']['tbl']['music_album'] . ' AS al ON val.album_id=al.music_album_id, '.$this->CFG['db']['tbl']['music'].' AS m LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON mr.music_artist_id=m.music_artist'.', '.$this->CFG['db']['tbl']['users'] . ' AS u '));
					$this->setReturnColumns(array('al.music_album_id', 'al.album_title', 'al.date_added', 'al.thumb_music_id as music_id', 'count(m.music_id) as total_tracks', 'al.total_album_views as total_views', 'sum(m.total_plays) as total_plays', 'SUM(val.total_views) as sum_total_views','m.music_server_url', 'count( m.music_id ) AS total_songs','m.music_title','m.thumb_width','m.thumb_height','al.album_for_sale','al.user_id','al.album_price'));
					$this->sql_condition = 'val.total_views>0 AND val.user_id = u.user_id AND m.music_status = \'OK\' AND u.usr_status=\'Ok\''.$this->albumlistAdvancedFilters().$this->getMostViewedExtraQuery().' GROUP BY val.album_id';
					$this->sql_sort = 'sum_total_views DESC';
					break;

					case 'albummostrecentlyviewed':
					//Heading
					$this->page_heading = $this->LANG['musicalbumList_heading_recently_viewed'];
					//Query
					$this->setTableNames(array($this->CFG['db']['tbl']['music_album'].' AS al LEFT JOIN '.$this->CFG['db']['tbl']['music'].' AS m ON al.music_album_id = m.music_album_id '.'LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON mr.music_artist_id=m.music_artist'.', '.$this->CFG['db']['tbl']['users'].' AS u '));
					$this->setReturnColumns(array('al.music_album_id', 'al.album_title', 'al.date_added', 'al.thumb_music_id as music_id', 'count(m.music_id) as total_tracks', 'al.total_album_views as total_views', 'sum(m.total_plays) as total_plays','m.music_server_url', 'count( m.music_id ) AS total_songs','m.music_title','m.thumb_width','m.thumb_height','al.album_for_sale','al.user_id','al.album_price'));
					$this->sql_condition = 'm.user_id = u.user_id AND m.music_status = \'OK\' AND u.usr_status=\'Ok\''.$this->albumlistAdvancedFilters().' GROUP BY al.music_album_id';
					$this->sql_sort = 'al.date_added DESC';
					break;

					case 'myalbums':
					//Heading
					$this->page_heading = $this->LANG['musicalbumList_heading_myalbums'];
					//Query
					$this->setTableNames(array($this->CFG['db']['tbl']['music_album'].' AS al ,'.$this->CFG['db']['tbl']['music'].' AS m LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON mr.music_artist_id=m.music_artist'.', '.$this->CFG['db']['tbl']['users'].' AS u '));
					$this->setReturnColumns(array('al.music_album_id', 'al.album_title', 'al.date_added', 'al.thumb_music_id as music_id', 'count(m.music_id) as total_tracks', 'al.total_album_views as total_views', 'sum(m.total_plays) as total_plays','m.music_title','m.music_id','m.music_server_url','count( m.music_id ) AS total_songs','m.music_title','mr.artist_name','m.thumb_width','m.thumb_height','al.album_for_sale','al.user_id','al.album_price'));
					$this->sql_condition = 'm.user_id = u.user_id AND al.user_id='.$this->CFG['user']['user_id'].' AND u.usr_status=\'Ok\''.$this->albumlistAdvancedFilters().' GROUP BY al.music_album_id';
					$this->sql_sort = 'al.music_album_id DESC';
					break;

					case 'useralbums':
					//Heading
					$pg_title = $this->LANG['musicalbumList_heading_useralbums'];
	                $name = $this->getUserDetail('user_id', $this->fields_arr['user_id'], 'user_name');
					$name = '<a href="'.getUrl('viewprofile','?user='.$name, $name.'/').'">'.ucfirst($name).'</a>';
	                $pg_title = str_replace('VAR_USER_NAME', $name, $pg_title);
					$this->page_heading = $pg_title;
					//Query
					$this->setTableNames(array($this->CFG['db']['tbl']['music_album'].' AS al LEFT JOIN '.$this->CFG['db']['tbl']['music'].' AS m ON al.music_album_id = m.music_album_id LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON mr.music_artist_id=m.music_artist'.', '.$this->CFG['db']['tbl']['users'].' AS u '));
					$this->setReturnColumns(array('al.music_album_id', 'al.album_title', 'al.date_added', 'al.thumb_music_id as music_id', 'count(m.music_id) as total_tracks', 'al.total_album_views as total_views', 'sum(m.total_plays) as total_plays','m.music_title','m.music_id','m.music_server_url','count( m.music_id ) AS total_songs','m.music_title','mr.artist_name','m.thumb_width','m.thumb_height','al.album_for_sale','al.user_id','al.album_price'));
					$this->sql_condition = 'm.user_id = u.user_id AND al.user_id='.$this->fields_arr['user_id'].' AND m.music_status = \'OK\' AND u.usr_status=\'Ok\''.$this->albumlistAdvancedFilters().' GROUP BY al.music_album_id';
					$this->sql_sort = 'al.music_album_id DESC';
					break;

					default:
					//Heading
					$this->page_heading = $this->LANG['musicalbumList_heading_albumListnew'];
					//Query
					$this->setTableNames(array($this->CFG['db']['tbl']['music_album'].' AS al LEFT JOIN '.$this->CFG['db']['tbl']['music'].' AS m ON al.music_album_id = m.music_album_id LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON mr.music_artist_id=m.music_artist'.', '.$this->CFG['db']['tbl']['users'].' AS u '));
					$this->setReturnColumns(array('al.music_album_id', 'al.album_title', 'al.date_added', 'al.thumb_music_id as music_id', 'count(m.music_id) as total_tracks', 'al.total_album_views as total_views', 'sum(m.total_plays) as total_plays','m.music_title','m.music_id','m.music_server_url','count( m.music_id ) AS total_songs','m.music_title','mr.artist_name','m.thumb_width','m.thumb_height','al.album_for_sale','al.user_id','al.album_price'));
					$this->sql_condition = 'm.user_id = u.user_id AND m.music_status = \'OK\' AND u.usr_status=\'Ok\''.$this->albumlistAdvancedFilters().' GROUP BY al.music_album_id';
					$this->sql_sort = 'al.music_album_id DESC';
					break;
				}
			}
		/**
		* musicAlbumList::albumlistAdvancedFilters()
		*
		* @return
		*/
		public function albumlistAdvancedFilters()
			{
				$albumlistAdvancedFilters = '';
				 $this->advanceSearch = false;
				if ($this->fields_arr['albumlist_title'] != $this->LANG['musicalbumList_albumList_title'] AND $this->fields_arr['albumlist_title'])
					{
						$this->hidden_array[] = 'albumlist_title';
						$albumlistAdvancedFilters .= ' AND al.album_title LIKE \'%' .validFieldSpecialChr($this->fields_arr['albumlist_title']). '%\' ';
						$this->advanceSearch = true;
					}
				if ($this->fields_arr['artist'] != $this->LANG['musicalbumList_no_of_artist'] AND $this->fields_arr['artist'])
					{
						$this->hidden_array[] = 'artist';
						$albumlistAdvancedFilters .= ' AND mr.artist_name LIKE \'%'  .validFieldSpecialChr($this->fields_arr['artist']). '%\' ';
						$this->advanceSearch = true;
					}
				if ($this->fields_arr['music_title'] != $this->LANG['musicalbumList_no_of_music_title'] AND $this->fields_arr['music_title'])
					{
						$this->hidden_array[] = 'music_title';
						$albumlistAdvancedFilters .= '  AND m.music_title LIKE \'%' .validFieldSpecialChr($this->fields_arr['music_title']). '%\' ';
						$this->advanceSearch = true;
					}

				return $albumlistAdvancedFilters;
			}

		/**
		* musicAlbumList::getMostListenedExtraQuery()
		*
		* @return
		*/
		public function getMostListenedExtraQuery()
			{
				$extra_query = '';
				switch ($this->fields_arr['action'])
					{
						case 1:
						$extra_query = ' AND DATE_FORMAT(lal.date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
						break;

						case 2:
						$extra_query = ' AND DATE_FORMAT(lal.date_added,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
						break;

						case 3:
						$extra_query = ' AND DATE_FORMAT(lal.date_added,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
						break;

						case 4:
						$extra_query = ' AND DATE_FORMAT(lal.date_added,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
						break;

						case 5:
						$extra_query = ' AND DATE_FORMAT(lal.date_added,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
						break;
					}
				return $extra_query;
			}

		/**
		* musicAlbumList::getMostListenedExtraQuery()
		*
		* @return
		*/
		public function getMostViewedExtraQuery()
			{
				$extra_query = '';
				switch ($this->fields_arr['action'])
					{
						case 1:
						$extra_query = ' AND DATE_FORMAT(val.date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
						break;

						case 2:
						$extra_query = ' AND DATE_FORMAT(val.date_added,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
						break;

						case 3:
						$extra_query = ' AND DATE_FORMAT(val.date_added,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
						break;

						case 4:
						$extra_query = ' AND DATE_FORMAT(val.date_added,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
						break;

						case 5:
						$extra_query = ' AND DATE_FORMAT(val.date_added,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
						break;
					}
				return $extra_query;
			}

		/**
		 * musicAlbumList::displayAlbumSongList()
		 *
		 * @param string $album_id
		 * @param mixed  $condition(IF $condition == true then we add additional query)
		 * @param string $limit(Number of song we need to show)
		 * @return
		 */
		public function displayAlbumSongList($album_id='', $condition=false, $limit='')
			{
				global $smartyObj;
				$displaySongList_arr = array();

				$sql = 'SELECT m.music_title,m.music_id,ma.album_title,ma.music_album_id,mr.artist_name,'.
						'm.music_access_type,mr.music_artist_id,ma.album_access_type, ma.album_price, ma.album_for_sale,'.
						' m.for_sale, m.music_price FROM '
						.$this->CFG['db']['tbl']['music_album'].' AS ma LEFT JOIN '.$this->CFG['db']['tbl']['music'].' AS m
						ON ma.music_album_id=m.music_album_id LEFT JOIN  '.$this->CFG['db']['tbl']['music_artist'].' '.
						'AS mr ON mr.music_artist_id=m.music_artist, '.$this->CFG['db']['tbl']['users'].' '.
						'AS u WHERE ma.music_album_id = m.music_album_id AND u.user_id = m.user_id AND m.music_status = \'Ok\'
						AND u.usr_status = \'Ok\' AND ma.music_album_id ='.$album_id;

				if($condition)
					$sql .= ' AND (m.user_id = '.$this->CFG['user']['user_id'].' OR m.music_access_type = \'Public\''.$this->getAdditionalQuery().') '.$this->getAdultQuery('m.', 'music');

				$sql .= ' ORDER BY ma.music_album_id ASC';

				if($limit!='')
					$sql .= ' LIMIT 0, '.$limit;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$displaySongList_arr['record_count'] = 0;
				$displaySongList_arr['row'] = array();
				$inc = 1;
				$this->player_music_id = array();
				while($songDetail = $rs->FetchRow())
					{
						$displaySongList_arr['record_count'] = 1;
						$displaySongList_arr['row'][$inc]['record'] = $songDetail;
						$displaySongList_arr['row'][$inc]['music_title'] = $songDetail['music_title'];
						$displaySongList_arr['row'][$inc]['music_album_id'] = $songDetail['music_album_id'];
						$displaySongList_arr['row'][$inc]['music_artist_id']=$songDetail['music_artist_id'];
						$displaySongList_arr['row'][$inc]['music_id'] = $songDetail['music_id'];
						$displaySongList_arr['row'][$inc]['artist_name'] = $songDetail['artist_name'];
						$displaySongList_arr['row'][$inc]['song_status'] = 1;
						$displaySongList_arr['row'][$inc]['album_access_type'] = $songDetail['album_access_type'];
						$displaySongList_arr['row'][$inc]['album_for_sale'] = $songDetail['album_for_sale'];
						$displaySongList_arr['row'][$inc]['album_price'] = $songDetail['album_price'];
						$displaySongList_arr['row'][$inc]['music_price'] = $songDetail['music_price'];
						$this->player_music_id[$inc] = $songDetail['music_id'];
						//$this->configXmlcode_url .= 'pg=music';
						//$this->playlistXmlcode_url .= 'pg=music_0_'.implode(',', $this->player_music_id);
						$songDetail['album_for_sale']=='No';
						if($songDetail['album_for_sale']=='Yes' and $songDetail['album_access_type']=='Private')
						{
							$displaySongList_arr['row'][$inc]['music_for_sale'] = 'No';
							$displaySongList_arr['row'][$inc]['album_for_sale'] = 'Yes';
						}
						else
							$displaySongList_arr['row'][$inc]['music_for_sale'] = $songDetail['for_sale'];

						if(!$condition)
							$displaySongList_arr['row'][$inc]['song_status'] = $this->chkPrivateSong($songDetail['music_id']);
						$displaySongList_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_music_title'] = highlightWords($songDetail['music_title'],$this->getFormField('music_title'));
						$displaySongList_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_artist_name'] = highlightWords($songDetail['artist_name'],$this->getFormField('artist'));
						$displaySongList_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_album_title'] = $songDetail['artist_name'];
						$displaySongList_arr['row'][$inc]['light_window_url'] = $this->CFG['site']['music_url'].'albumList.php?music_album_id='.$songDetail['music_album_id'].'&light_window=1';
						$displaySongList_arr['row'][$inc]['getUrl_viewMusic_url'] = getUrl('viewmusic', '?music_id='.$songDetail['music_id'].'&title='.$this->changeTitle($songDetail['music_title']), $songDetail['music_id'].'/'.$this->changeTitle($songDetail['music_title']).'/', '', 'music');
						$displaySongList_arr['row'][$inc]['get_artist_url'] = getUrl('musiclist', '?pg=musicnew&artist_id=' . $songDetail['music_artist_id'], 'musicnew/?artist_id=' . $songDetail['music_artist_id'], '', 'music');
						$this->populatePlayerWithPlaylistConfiguration();
						$inc++;
					}
				$smartyObj->assign('displaySongList_arr', $displaySongList_arr);
				$smartyObj->assign('lastDiv', $$inc=$inc-1);
				//	return true;
			}
	public function getAlbumTotalSong($album_id, $condition=false)
		{
			$sql = ' SELECT m.music_id FROM '.$this->CFG['db']['tbl']['music_album'].' AS ma LEFT JOIN '.$this->CFG['db']['tbl']['music'].' AS m
					ON ma.music_album_id=m.music_album_id LEFT JOIN  '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON mr.music_artist_id=m.music_artist, '.$this->CFG['db']['tbl']['users'].' AS u WHERE ma.music_album_id = m.music_album_id AND u.user_id = m.user_id AND m.music_status = \'Ok\'
					AND u.usr_status = \'Ok\' AND ma.music_album_id ='.$album_id;

			if($condition)
				$sql .= ' AND (m.user_id = '.$this->CFG['user']['user_id'].' OR m.music_access_type = \'Public\''.$this->getAdditionalQuery().') '.$this->getAdultQuery('m.', 'music');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
				trigger_db_error($this->dbObj);

			return $rs->PO_RecordCount();
		}
	public function chkAdvanceResultFound()
		{
			if($this->advanceSearch)
				{
					return true;
				}
			return false;
		}

}
//<<<<<-------------- Class musicAlbumListManage end ---------------//
//-------------------- Code begins -------------->>>>>//
$musicAlbumList = new musicAlbumList();
if(!chkAllowedModule(array('music')))
Redirect2URL($CFG['redirect']['dsabled_module_url']);
$musicAlbumList->setPageBlockNames(array('filter_select_block', 'search_albumlist_block', 'list_albumlist_block','songlist_block','displaysonglist_block'));
$musicAlbumList->setFormField('start', '0');
$musicAlbumList->setFormField('numpg', $CFG['music_tbl']['numpg']);
$musicAlbumList->setFormField('albumlist_title', '');
$musicAlbumList->setFormField('artist', '');
$musicAlbumList->setFormField('user_id', '');
$musicAlbumList->setFormField('music_id', '');
$musicAlbumList->setFormField('music_title', '');
$musicAlbumList->setFormField('pg', 'albumlistnew');
$musicAlbumList->setFormField('action', '');
$musicAlbumList->setFormField('light_window', '');
$musicAlbumList->setFormField('music_album_id', '');
$musicAlbumList->setFormField('default', 'Yes');
$musicAlbumList->setTableNames(array());
$musicAlbumList->setReturnColumns(array());
$musicAlbumList->sanitizeFormInputs($_REQUEST);
$musicAlbumList->setPageBlockShow('filter_select_block');
$musicAlbumList->setPageBlockShow('search_albumlist_block');
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
if($musicAlbumList->getFormField('light_window')!= '')
	{
		$musicAlbumList->setPageBlockShow('songlist_block');
	}
$musicAlbumList->setPageBlockShow('list_albumlist_block');
$musicAlbumList->setPageBlockShow('my_musics_form');
if($musicAlbumList->isFormPOSTed($_POST, 'search'))
	{
		$musicAlbumList->albumlistAdvancedFilters();
	}
if($musicAlbumList->isFormPOSTed($_POST, 'avd_reset'))
	{
		$musicAlbumList->setFormField('albumlist_title', '');
		$musicAlbumList->setFormField('artist', '');
		$musicAlbumList->setFormField('music_title', '');
	}
if ($musicAlbumList->getFormField('pg'))
	{
		$musicAlbumList->setPageBlockShow('search_albumlist_block');
	}

//-------------------- Page block templates begins -------------------->>>>>//
if ($musicAlbumList->isShowPageBlock('songlist_block'))
	{

		$musicAlbumList->includeHeader();
		$musicAlbumList->sanitizeFormInputs($_REQUEST);
		$musicAlbumList->isShowPageBlock('displaysonglist_block');
		$musicAlbumList->populateMusicJsVars();
		$musicAlbumList->displayAlbumSongList($musicAlbumList->getFormField('music_album_id'));
		?>
		<script type="text/javascript" src="<?php echo $CFG['site']['music_url'].'js/functions.js';?>"></script>
		<script type="text/javascript" src="<?php echo $CFG['site']['url'].'js/lib/prototype.js';?>"></script>
		<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/JSFCommunicator.js"></script>
		<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
		<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/effects.js"></script>
		<script type="text/javascript" language="javascript">
		total_musics_to_play = <?php echo count($musicAlbumList->player_music_id); ?>;
		<?php
		foreach($musicAlbumList->player_music_id as $music_id_to_play)
		{
		echo 'total_musics_ids_play_arr.push('.$music_id_to_play.');';
		}

		?>
		</script>
	   <?php
	   	//player configuratiosn


		//Initializing Playlist Player Configuaration
		$musicAlbumList->populatePlayerWithPlaylistConfiguration();
		$musicAlbumList->configXmlcode_url .= 'pg=music';
		$musicAlbumList->playlistXmlcode_url .= 'pg=music_0_'.implode(',', $musicAlbumList->player_music_id);
		setTemplateFolder('general/', 'music');
		$smartyObj->display('albumSongList.tpl');
		$musicAlbumList->includeFooter();
		exit;
	}
if ($musicAlbumList->isShowPageBlock('list_albumlist_block'))
	{
		/****** navigtion continue*********/
		$musicAlbumList->setTableAndColumns();
		$musicAlbumList->buildSelectQuery();
		$musicAlbumList->buildQuery();
		if($musicAlbumList->getFormField('start'))
		$musicAlbumList->homeExecuteQuery();
		$group_query_arr = array('albumlistmostviewed','albummostrecentlyviewed','albummostlistened','albummostviewed','albumlistnew', 'myalbums');
		if (in_array($musicAlbumList->getFormField('pg'), $group_query_arr))
       		$musicAlbumList->homeExecuteQuery();
    	else
			$musicAlbumList->executeQuery();
		if($musicAlbumList->isResultsFound())
			{
				$musicAlbumList->list_albumlist_block['showAlbumlists'] = $musicAlbumList->showAlbumlists();
				if($musicAlbumList->getFormField('action'))
					$musicAlbumList->hidden_array[] = 'action';
					$musicAlbumList->hidden_array[] = 'pg';
				$smartyObj->assign('smarty_paging_list', $musicAlbumList->populatePageLinksGET($musicAlbumList->getFormField('start'), $musicAlbumList->hidden_array));
			}
		if ($musicAlbumList->getFormField('pg') == 'albummostlistened' or $musicAlbumList->getFormField('pg') == 'albummostviewed')
			{
				$musicActionNavigation_arr['music_list_url_0'] = getUrl('albumlist', '?pg='.$musicAlbumList->getFormField('pg').'&action=0', $musicAlbumList->getFormField('pg').'/?action=0', '', 'music');
				$musicActionNavigation_arr['music_list_url_1'] = getUrl('albumlist', '?pg='.$musicAlbumList->getFormField('pg').'&action=1', $musicAlbumList->getFormField('pg').'/?action=1', '', 'music');
				$musicActionNavigation_arr['music_list_url_2'] = getUrl('albumlist', '?pg='.$musicAlbumList->getFormField('pg').'&action=2', $musicAlbumList->getFormField('pg').'/?action=2', '', 'music');
				$musicActionNavigation_arr['music_list_url_3'] = getUrl('albumlist', '?pg='.$musicAlbumList->getFormField('pg').'&action=3', $musicAlbumList->getFormField('pg').'/?action=3', '', 'music');
				$musicActionNavigation_arr['music_list_url_4'] = getUrl('albumlist', '?pg='.$musicAlbumList->getFormField('pg').'&action=4', $musicAlbumList->getFormField('pg').'/?action=4', '', 'music');
				$musicActionNavigation_arr['music_list_url_5'] = getUrl('albumlist', '?pg='.$musicAlbumList->getFormField('pg').'&action=5', $musicAlbumList->getFormField('pg').'/?action=5', '', 'music');
				$musicActionNavigation_arr['cssli_0'] = $musicActionNavigation_arr['cssli_1'] = $musicActionNavigation_arr['cssli_2'] = $musicActionNavigation_arr['cssli_3'] = $musicActionNavigation_arr['cssli_4'] = $musicActionNavigation_arr['cssli_5'] = '';
				if(!$musicAlbumList->getFormField('action')) $musicAlbumList->setFormField('action', '0');
					$sub_page = 'cssli_'.$musicAlbumList->getFormField('action');
				$musicActionNavigation_arr[$sub_page] = ' class="clsActiveTabNavigation"';
				$smartyObj->assign('musicActionNavigation_arr', $musicActionNavigation_arr);
			}
	}

$musicAlbumList->musicalbumList_no_records_found = $LANG['musicalbumList_no_records_found'];
if($musicAlbumList->getFormField('pg')=='myalbums')
{
	$link = '<a href="'.getUrl('musicalbummanage','','','members','music').'">'.$LANG['musicalbumList_click_here'].'</a>';
	$LANG['musicalbumList_no_my_records_found'] = str_replace('VAR_CLICK_HERE',$link , $LANG['musicalbumList_no_my_records_found']);
	$musicAlbumList->musicalbumList_no_records_found = $LANG['musicalbumList_no_my_records_found'];
}
//include the header file
$musicAlbumList->includeHeader();
//include the content of the page
setTemplateFolder('general/','music');
$smartyObj->display('albumList.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
?>

<script type="text/javascript" src="<?php echo $CFG['site']['music_url'].'js/functions.js';?>"></script>
<script type="text/javascript" language="javascript">
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
		if (($Jq('#' + id).val() =="") && (id == 'albumlist_title') )
		$Jq('#' + id).val('<?php echo $LANG['musicalbumList_albumList_title']?>');
		else if (($Jq('#' + id).val() =="") && (id == 'artist') )
		$Jq('#' + id).val('<?php echo $LANG['musicalbumList_no_of_artist']?>');
		else if (($Jq('#' + id).val() =="") && (id == 'music_title') )
		$Jq('#' + id).val('<?php echo $LANG['musicalbumList_no_of_music_title']?>');
	}
</script>
<?php
$musicAlbumList->includeFooter();
?>
