<?php
/**
* This class is used to music artist List and search page
*
* @category	Rayzz
* @package		music artist List
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
*/
class musicArtistList extends MusicHandler
	{
		public $page_heading = '';
		public $hidden_array = array();
		public $advanceSearch;
		/**
		* musicArtistList::getArtistSongList()
		*
		* @param mixed $songlist_artistname
		* @param string $limit
		* @return
		*/
		public function getArtistSongList($songlist_artistname, $limit='')
			{
				global $smartyObj;
				$getArtistSongList_arr = array();
				$sql = 'SELECT m.music_id,m.music_title, ma.album_title  '.
				'FROM '.$this->CFG['db']['tbl']['music'].' as m , '.$this->CFG['db']['tbl']['users'] . ' as u, '.$this->CFG['db']['tbl']['music_album'].' AS ma '.
				'WHERE ma.music_album_id = m.music_album_id AND u.user_id = m.user_id AND m.music_status = \'Ok\' AND u.usr_status = \'Ok\' AND m.music_artist = \''.$songlist_artistname.'\'
				'.$this->getAdultQuery('m.', 'music').'	AND (m.user_id = '.$this->CFG['user']['user_id'].' OR m.music_access_type = \'Public\''.$this->getAdditionalQuery().') GROUP BY ma.music_album_id ORDER BY m.music_id ASC';
				if($limit!='')
					$sql .= ' LIMIT 0, '.$limit;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$getArtistSongList_arr['record_count'] = 0;
				$getArtistSongList_arr['row'] = array();
				$inc = 1;
				while($songDetail = $rs->FetchRow())
					{
						$getArtistSongList_arr['record_count'] = 1;
						$getArtistSongList_arr['row'][$inc]['record'] = $songDetail;
						$getArtistSongList_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_music_title'] = $songDetail['music_title'];
						$getArtistSongList_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_album_title'] = $songDetail['album_title'];
						$inc++;
					}
				$smartyObj->assign('getArtistSongList_arr', $getArtistSongList_arr);
				setTemplateFolder('general/', 'music');
				$smartyObj->display('artistSongList.tpl');
			}

		public function getTotalMusic($artistId = '0'){

		    $sql = 'SELECT count(music_id) as total_music FROM '.$this->CFG['db']['tbl']['music'].' WHERE music_artist IN ('.$artistId.') AND music_status = \'OK\'';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array());
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			$row = $rs->FetchRow();

			return $row['total_music'];
		}

		public function getTotalArtistPhotos($artist_id)
		{
			$sql = 'SELECT count(music_artist_member_id) as count FROM '.
					$this->CFG['db']['tbl']['music_artist_member_image'].
					' WHERE music_artist_member_id='.$this->dbObj->Param('music_artist_member_id').
					' AND status=\'Yes\'';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($artist_id));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);
			if($row = $rs->FetchRow())
				return $row['count'];
		}
		/**
		* musicArtistList::showArtistlists()
		*
		* @return
		*/
		public function showArtistlists()
			{
				$showArtistlists_arr = array();
				$artist_image_path = $this->CFG['site']['url'].$this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['music_folder'].'/'.$this->CFG['admin']['musics']['artist_image_folder'].'/';
				$inc=0;
				$showArtistlists_arr['row'] = array();
				while($row = $this->fetchResultRecord())
					{
						$showArtistlists_arr['row'][$inc]['wordWrap_mb_Manual_artist_name'] = highlightWords($row['artist_name'], $this->getFormField('artistlist_title'));
						//$showArtistlists_arr['row'][$inc]['totalMusic'] = $this->getTotalMusic($row['music_artist_id']);
						$showArtistlists_arr['row'][$inc]['record'] = $row;
						$showArtistlists_arr['row'][$inc]['music_artist_id'] =$row['music_artist_id'];
						$showArtistlists_arr['row'][$inc]['total_songs'] =$row['total_songs'];

						$showArtistlists_arr['row'][$inc]['music_id'] =$row['music_id'];
						$showArtistlists_arr['row'][$inc]['music_title'] =$row['music_title'];
						//Artistlist Image...

						$showArtistlists_arr['row'][$inc]['profileIcon'] = getMemberAvatarDetails($row['music_artist_id']);
						$showArtistlists_arr['row'][$inc]['memberProfileUrl'] = getMemberProfileUrl($row['music_artist_id'], $row['artist_name']);
						if(!empty($artist_image_detail))
							{
								$showArtistlists_arr['row'][$inc]['artist_image'] = $artist_image_path.$artist_image_detail['music_artist_image'].$this->CFG['admin']['musics']['artist_thumb_name'].'.'.$artist_image_detail['image_ext'];
								$showArtistlists_arr['row'][$inc]['disp_image'] = DISP_IMAGE($this->CFG['admin']['musics']['artist_thumb_width'], $this->CFG['admin']['musics']['artist_thumb_height'], $artist_image_detail['thumb_width'], $artist_image_detail['thumb_height']);
							}
						else
							{
								$showArtistlists_arr['row'][$inc]['artist_image'] = '';
								$showArtistlists_arr['row'][$inc]['disp_image'] = '';
							}
						$showArtistlists_arr['row'][$inc]['total_photos'] = $this->getTotalArtistPhotos($row['music_artist_id']);
						$showArtistlists_arr['row'][$inc]['getUrl_musiclist_url'] = getUrl('musiclist', '?pg=musicnew&user_id='.$row['music_artist_id'], 'musicnew/?user_id='.$row['music_artist_id'], '', 'music');
						$showArtistlists_arr['row'][$inc]['getUrl_viewartist_url'] = getUrl('artistmemberphoto', '?artist_id='.$row['music_artist_id'].'&name='.$this->changeTitle($row['artist_name']), $row['music_artist_id'].'/'.$this->changeTitle($row['artist_name']).'/', '', 'music');
						$inc++;
					}
				return $showArtistlists_arr;
			}

		/**
		* musicArtistList::setTableAndColumns()
		*
		* @return
		*/
		public function setTableAndColumns()
			{
			switch ($this->fields_arr['pg'])
				{
					case 'artistmostviewed':
					//Heading
					$this->page_heading = $this->LANG['musicArtistList_heading_mostviewed'];
					//Query
					$this->setTableNames(array($this->CFG['db']['tbl']['music_artist_viewed']. ' As mv LEFT JOIN ' . $this->CFG['db']['tbl']['music'] . ' as m ON mv.music_artist_viewed_id=m.music_id '.'LEFT JOIN '.$this->CFG['db']['tbl']['music_album'].'  as ma on ma.music_album_id=m.music_album_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr on mr.music_artist_id=mv.artist_id,'.$this->CFG['db']['tbl']['users'].'  as u'));
					$this->setReturnColumns(array('ma.music_album_id', 'ma.album_title', 'ma.date_added', 'ma.thumb_music_id as music_id', 'count(m.music_id) as total_tracks', 'sum(m.total_plays) as sum_plays','m.music_thumb_ext','mv.artist_id','mv.total_views','mr.artist_name','mr.music_artist_id','m.thumb_width','m.thumb_height', 'count( m.music_id ) AS total_songs','m.music_title','m.music_id'));
					$this->sql_condition = 'mv.total_views>0 AND mv.user_id = u.user_id  AND m.music_status = \'OK\' AND u.usr_status=\'Ok\''.$this->getMostViewedExtraQuery().$this->artistlistAdvancedFilters().' GROUP BY mv.music_artist_viewed_id';
					$this->sql_sort = 'mv.total_views DESC';
					break;

					case 'artistmostrecentlyviewed':
					//Heading
					$this->page_heading = $this->LANG['musicArtistList_heading_recently_viewed'];
					//Query
					$this->setTableNames(array($this->CFG['db']['tbl']['music_artist_viewed']. ' As mv LEFT JOIN ' . $this->CFG['db']['tbl']['music'] . ' as m ON mv.music_artist_viewed_id=m.music_id '.'LEFT JOIN '.$this->CFG['db']['tbl']['music_album'].'  as ma on ma.music_album_id=m.music_album_id'.' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr on mr.music_artist_id=mv.artist_id,'.$this->CFG['db']['tbl']['users'].'  as u'));
					$this->setReturnColumns(array('ma.music_album_id', 'ma.album_title', 'ma.date_added', 'ma.thumb_music_id as music_id', 'count(m.music_id) as total_tracks', 'sum(m.total_plays) as sum_plays','m.music_thumb_ext','mv.artist_id','mv.total_views','mr.artist_name','mr.music_artist_id','m.thumb_width','m.thumb_height', 'count( m.music_id ) AS total_songs','m.music_title','m.music_id'));
					$this->sql_condition = 'mv.total_views>0 AND mv.user_id = u.user_id  AND m.music_status = \'OK\' AND u.usr_status=\'Ok\''.$this->getMostViewedExtraQuery().$this->artistlistAdvancedFilters().' GROUP BY mv.music_artist_viewed_id';
					$this->sql_sort = 'm.date_added DESC';
					break;

					case 'artistfavorited':
					//Heading
					$pg_title = $this->LANG['musicArtistList_heading_artistListfavorites'];
	                $name = $this->getUserDetail('user_id', $this->fields_arr['user_id'], 'user_name');
	                $name = '<a href="'.getUrl('viewprofile','?user='.$name, $name.'/').'">'.ucfirst($name).'</a>';
	                $this->page_heading = str_replace('VAR_USER_NAME', $name, $pg_title);
					//Query
					$this->setTableNames(array($this->CFG['db']['tbl']['music'].' AS m LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON u.user_id=m.user_id LEFT JOIN '.$this->CFG['db']['tbl']['artist_fans_list'].' as af ON af.artist_id=u.user_id'));
					$this->setReturnColumns(array('u.user_name as artist_name','u.user_id as music_artist_id', 'sum(m.total_plays) AS sum_plays', 'count( m.music_id ) AS total_songs','m.music_title','m.music_id', 'u.icon_id', 'u.icon_type', 'u.image_ext', 'u.sex'));
					$this->sql_condition = 'm.music_status = \'Ok\' AND u.usr_status=\'Ok\' AND u.music_user_type=\'Artist\' AND af.fan_id='.$this->fields_arr['user_id'].$this->artistlistAdvancedFilters().' GROUP BY m.user_id';
					$this->sql_sort = 'u.user_name ASC ';
					break;

					default:
					//Heading
					$this->page_heading = $this->LANG['musicArtistList_heading_artistListnew'];
					//Query
					$this->setTableNames(array($this->CFG['db']['tbl']['music'].' AS m LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON u.user_id=m.user_id'));
					$this->setReturnColumns(array('u.user_name as artist_name', 'u.user_id as music_artist_id', 'sum(m.total_plays) AS sum_plays', 'count( m.music_id ) AS total_songs','m.music_title','m.music_id', 'u.icon_id', 'u.icon_type', 'u.image_ext', 'u.sex'));
					$this->sql_condition = 'm.music_status = \'Ok\' AND u.usr_status=\'Ok\' AND u.music_user_type=\'Artist\''.$this->artistlistAdvancedFilters().' GROUP BY m.user_id';
					$this->sql_sort = 'u.user_name ASC ';
					break;
				}
			}

		/**
		* musicArtistList::artistlistAdvancedFilters()
		*
		* @return
		*/
		public function artistlistAdvancedFilters()
			{
				$artistlistAdvancedFilters = '';
				 $this->advanceSearch = false;
				if ($this->fields_arr['artistlist_title'] != $this->LANG['musicArtistList_artistList_title'] AND $this->fields_arr['artistlist_title'])
					{
						$this->hidden_array[] = 'artistlist_title';
						$artistlistAdvancedFilters .= ' AND u.user_name LIKE "%'.validFieldSpecialChr($this->fields_arr['artistlist_title']).'%" ';
						$this->advanceSearch = true;
					}
				if ($this->fields_arr['tracks'] != $this->LANG['musicArtistList_no_of_tracks'] AND $this->fields_arr['tracks'])
					{
						$this->hidden_array[] = 'tracks';
						$artistlistAdvancedFilters .= ' AND m.total_tracks LIKE \'%' .validFieldSpecialChr($this->fields_arr['tracks']). '%\' ';
						$this->advanceSearch = true;
					}
				if ($this->fields_arr['plays'] != $this->LANG['musicArtistList_no_of_plays'] AND $this->fields_arr['plays'])
					{
						$this->hidden_array[] = 'plays';
						$artistlistAdvancedFilters .= ' AND m.total_views LIKE \'%' .validFieldSpecialChr($this->fields_arr['plays']). '%\' ';
						$this->advanceSearch = true;
					}
				if ($this->fields_arr['music_title'] != $this->LANG['musicArtistList_music_title'] AND $this->fields_arr['music_title'])
					{
						$this->hidden_array[] = 'music_title';
						$artistlistAdvancedFilters .= ' AND m.music_title LIKE \'%' .validFieldSpecialChr($this->fields_arr['music_title']). '%\' ';
						$this->advanceSearch = true;
					}
				if ($this->fields_arr['total_plays'] != $this->LANG['musicArtistList_total_plays'] AND $this->fields_arr['total_plays'])
					{
						$this->hidden_array[] = 'total_plays';
						$artistlistAdvancedFilters .= ' AND m.total_plays= \'' .$this->fields_arr['total_plays']. '\' ';
						$this->advanceSearch = true;
					}
				return $artistlistAdvancedFilters;
			}

		/**
		* musicArtistList::getMostListenedExtraQuery()
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
		* musicArtistList::getMostListenedExtraQuery()
		*
		* @return
		*/
		public function getMostViewedExtraQuery()
			{
				$extra_query = '';
				switch ($this->fields_arr['action'])
					{
					case 1:
					$extra_query = ' AND DATE_FORMAT(mv.view_date,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
					break;

					case 2:
					$extra_query = ' AND DATE_FORMAT(mv.view_date,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
					break;

					case 3:
					$extra_query = ' AND DATE_FORMAT(mv.view_date,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
					break;

					case 4:
					$extra_query = ' AND DATE_FORMAT(mv.view_date,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
					break;

					case 5:
					$extra_query = ' AND DATE_FORMAT(mv.view_date,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
					break;
					}
				return $extra_query;
			}

		/**
		* musicArtistList::displaySongList()
		*
		* @return
		*/
		public function displayArtistSongList($artist_id='', $limit='')
			{
				global $smartyObj;
				$displaySongList_arr = array();
				$sql = 'SELECT m.music_title,m.music_album_id, ma.album_title,m.music_id  '.
				'FROM '.$this->CFG['db']['tbl']['music'].' as m '.', '.$this->CFG['db']['tbl']['users'] . ' as u, '.$this->CFG['db']['tbl']['music_album'].' AS ma '.
				'WHERE ma.music_album_id = m.music_album_id AND u.user_id = m.user_id AND m.music_status = \'Ok\' AND u.usr_status = \'Ok\' AND u.user_id = '.$artist_id.' ORDER BY m.music_id ASC';
				if($limit!='')
					$sql .= ' LIMIT 0, '.$limit;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$displaySongList_arr['record_count'] = 0;
				$displaySongList_arr['row'] = array();
				$inc = 1;
				while($songDetail = $rs->FetchRow())
					{
						$displaySongList_arr['record_count'] = 1;
						$displaySongList_arr['row'][$inc]['record'] = $songDetail;
						$displaySongList_arr['row'][$inc]['music_id'] = $songDetail['music_id'];
						$displaySongList_arr['row'][$inc]['music_title'] = $songDetail['music_title'];
						$displaySongList_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_music_title'] = highlightWords($songDetail['music_title'], $this->getFormField('music_title'));
						$displaySongList_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_album_title'] = highlightWords($songDetail['album_title'],$this->getFormField('album_title'));
						$displaySongList_arr['row'][$inc]['get_album_url'] = getUrl('viewalbum', '?album_id='.$songDetail['music_album_id'].'&title='.$this->changeTitle($songDetail['album_title']),$songDetail['music_album_id'].'/'.$this->changeTitle($songDetail['album_title']).'/', '', 'music');
						$displaySongList_arr['row'][$inc]['getUrl_viewMusic_url'] = getUrl('viewmusic', '?music_id='.$songDetail['music_id'].'&title='.$this->changeTitle($songDetail['music_title']), $songDetail['music_id'].'/'.$this->changeTitle($songDetail['music_title']).'/', '', 'music');
						$inc++;
					}
				$smartyObj->assign('displaySongList_arr', $displaySongList_arr);
				$smartyObj->assign('lastDiv', $$inc=$inc-1);
				//	return true;
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
//<<<<<-------------- Class musicArtistListManage end ---------------//
//-------------------- Code begins -------------->>>>>//
$musicArtistList = new musicArtistList();
if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$musicArtistList->setPageBlockNames(array('filter_select_block', 'search_artistlist_block', 'list_artistlist_block', 'artistl_songlist_block','songlist_block'));
$musicArtistList->setFormField('start', '0');
$musicArtistList->setFormField('numpg', $CFG['music_tbl']['numpg']);
$musicArtistList->setFormField('artistlist_title', '');
$musicArtistList->setFormField('album_title', '');
$musicArtistList->setFormField('music_title', '');
$musicArtistList->setFormField('total_plays', '');
$musicArtistList->setFormField('tracks', '');
$musicArtistList->setFormField('user_id', '');
$musicArtistList->setFormField('plays', '');
$musicArtistList->setFormField('pg', 'artistnew');
$musicArtistList->setFormField('default', 'Yes');
$musicArtistList->setFormField('action', '');
$musicArtistList->setFormField('music_artist_id', '');
$musicArtistList->setMediaPath('../../');
$musicArtistList->setTableNames(array());
$musicArtistList->setReturnColumns(array());
//General Query..
$musicArtistList->sanitizeFormInputs($_REQUEST);
$musicArtistList->setPageBlockShow('filter_select_block');
$musicArtistList->setPageBlockShow('songlist_block');
$musicArtistList->setPageBlockShow('search_artistlist_block');
$musicArtistList->setPageBlockShow('list_artistlist_block');
if($musicArtistList->isFormPOSTed($_POST, 'search'))
	{
		$musicArtistList->artistlistAdvancedFilters();
	}
if($musicArtistList->isFormPOSTed($_POST, 'avd_reset'))
	{
		$musicArtistList->setFormField('artistlist_title', '');
		$musicArtistList->setFormField('album_title', '');
		$musicArtistList->setFormField('music_title', '');
		$musicArtistList->setFormField('total_plays', '');
		$musicArtistList->setFormField('tracks', '');
	}

//<<<<<-------------- Code end ----------------------------------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($musicArtistList->isShowPageBlock('list_artistlist_block'))
	{
		/****** navigtion continue*********/
		$musicArtistList->setTableAndColumns();
		$musicArtistList->buildSelectQuery();
		$musicArtistList->buildQuery();
		if($musicArtistList->getFormField('start'))
		$musicArtistList->homeExecuteQuery();
		$group_query_arr = array('artistnew','artistmostviewed','artistmostrecentlyviewed');
		if (in_array($musicArtistList->getFormField('pg'), $group_query_arr))
       		$musicArtistList->homeExecuteQuery();
    	else
			$musicArtistList->executeQuery();

		if($musicArtistList->isResultsFound())
			{
				$musicArtistList->list_artistlist_block['showArtistlists'] = $musicArtistList->showArtistlists();
				if($musicArtistList->getFormField('action'))
					$musicArtistList->hidden_array[] = 'action';
				$smartyObj->assign('smarty_paging_list', $musicArtistList->populatePageLinksGET($musicArtistList->getFormField('start'), $musicArtistList->hidden_array));
			}
		if ($musicArtistList->getFormField('pg') == 'artistmostlistened' or $musicArtistList->getFormField('pg') == 'artistmostviewed')
			{
				$musicActionNavigation_arr['music_list_url_0'] = getUrl('artistlist', '?pg='.$musicArtistList->getFormField('pg').'&action=0', $musicArtistList->getFormField('pg').'/?action=0', '', 'music');
				$musicActionNavigation_arr['music_list_url_1'] = getUrl('artistlist', '?pg='.$musicArtistList->getFormField('pg').'&action=1', $musicArtistList->getFormField('pg').'/?action=1', '', 'music');
				$musicActionNavigation_arr['music_list_url_2'] = getUrl('artistlist', '?pg='.$musicArtistList->getFormField('pg').'&action=2', $musicArtistList->getFormField('pg').'/?action=2', '', 'music');
				$musicActionNavigation_arr['music_list_url_3'] = getUrl('artistlist', '?pg='.$musicArtistList->getFormField('pg').'&action=3', $musicArtistList->getFormField('pg').'/?action=3', '', 'music');
				$musicActionNavigation_arr['music_list_url_4'] = getUrl('artistlist', '?pg='.$musicArtistList->getFormField('pg').'&action=4', $musicArtistList->getFormField('pg').'/?action=4', '', 'music');
				$musicActionNavigation_arr['music_list_url_5'] = getUrl('artistlist', '?pg='.$musicArtistList->getFormField('pg').'&action=5', $musicArtistList->getFormField('pg').'/?action=5', '', 'music');
				$musicActionNavigation_arr['cssli_0'] = $musicActionNavigation_arr['cssli_1'] = $musicActionNavigation_arr['cssli_2'] = $musicActionNavigation_arr['cssli_3'] = $musicActionNavigation_arr['cssli_4'] = $musicActionNavigation_arr['cssli_5'] = '';
				if(!$musicArtistList->getFormField('action')) $musicArtistList->setFormField('action', '0');
					$sub_page = 'cssli_'.$musicArtistList->getFormField('action');
				$musicActionNavigation_arr[$sub_page] = ' class="clsActiveTabNavigation"';
				$smartyObj->assign('musicActionNavigation_arr', $musicActionNavigation_arr);
			}
		}
//include the header file
$musicArtistList->includeHeader();
//include the content of the page
setTemplateFolder('general/','music');
$smartyObj->display('artistMembersList.tpl');

//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
?>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/functions.js"></script>
<script type="text/javascript" language="javascript">
var form_name_array = new Array('seachAdvancedFilter');
function loadUrl(element)
	{
		document.seachAdvancedFilter.action=element.value;
		document.seachAdvancedFilter.submit();
	}
function clearValue(id)
	{
		$(id).value = '';
	}
function setOldValue(id)
	{
		if (($(id).value=="") && (id == 'artistlist_title') )
			$(id).value = '<?php echo $LANG['musicArtistList_artistList_title']?>';
		else if (($(id).value=="") && (id == 'tracks') )
			$(id).value = '<?php echo $LANG['musicArtistList_no_of_tracks']?>';
		else if (($(id).value=="") && (id == 'plays') )
			$(id).value = '<?php echo $LANG['musicArtistList_no_of_plays']?>';
		else if (($(id).value=="") && (id == 'music_title') )
			$(id).value = '<?php echo $LANG['musicArtistList_music_title']?>';
		else if (($(id).value=="") && (id == 'album_title') )
			$(id).value = '<?php echo $LANG['musicArtistList_album_title']?>';
		else if (($(id).value=="") && (id == 'total_plays') )
			$(id).value = '<?php echo $LANG['musicArtistList_total_plays']?>';
	}
</script>
<?php
$musicArtistList->includeFooter();
?>