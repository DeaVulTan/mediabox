<?php
/**
 * This file is use for music album list
 *
 * This file is having create music album list page. Here we manage album list and search option.
 *
 *
 * @category	Rayzz/Music
 * @package		member
 *
 **/
require_once('../../common/configs/config.inc.php');
require_once('../../common/configs/config_payment.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/transactionList.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/help.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['site']['is_module_page']='music';
if(isset($_REQUEST['light_window']))
	{
		$CFG['html']['header'] = 'admin/html_header_no_header.php';
		$CFG['html']['footer'] = 'admin/html_footer_no_footer.php';
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
$CFG['admin']['calendar_page'] = true;
require($CFG['site']['project_path'].'common/application_top.inc.php');
if(isMember())
	$CFG['admin']['light_window_page'] = true;

//--------------class musicAlbumList--------------->>>//
/**
* This class is used to music album list and search page
*
* @category		Rayzz
* @package		manage music albumlist
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
*/
class transactionDetails extends MusicHandler
	{
		public $page_heading = '';
		public $hidden_array = array();
		public $advanceSearch;
		/**
		* musicAlbumList::showAlbumlists()
		*
		* @return
		*/
		public function showAlbumlists()
		{
			$showAlbumlists_arr = array();
			$musics_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
			$inc=0;
			$showAlbumlists_arr['row'] = array();
			while($row = $this->fetchResultRecord())
				{

					$showAlbumlists_arr[$inc]['light_window_url'] = $this->CFG['site']['music_url'].'albumList.php?music_album_id='.$row['music_album_id'].'&light_window=1';
					$showAlbumlists_arr['row'][$inc]['record'] = $row;
					$showAlbumlists_arr['row'][$inc]['album_for_sale'] = $row['album_for_sale'];
					$showAlbumlists_arr['row'][$inc]['album_price'] = $row['album_price'];
					$showAlbumlists_arr['row'][$inc]['user_id'] = $row['user_id'];
					$showAlbumlists_arr['row'][$inc]['music_album_id'] = $row['music_album_id'];
					$showAlbumlists_arr['row'][$inc]['total_purchases'] = $row['total_purchases'];
					$showAlbumlists_arr['row'][$inc]['word_wrap_album_title'] = highlightWords(wordWrap_mb_ManualWithSpace($row['album_title'], $this->CFG['admin']['musics']['albumlist_album_title_length'], $this->CFG['admin']['musics']['albumlist_album_title_total_length'],0),$this->fields_arr['albumlist_title']);


					$showAlbumlists_arr['row'][$inc]['light_window_url'] = $this->CFG['site']['music_url'].'transactionList.php?music_album_id='.$row['music_album_id'].'&light_window=1';
					$showAlbumlists_arr['row'][$inc]['getUrl_viewAlbum_url'] =getUrl('viewalbum', '?album_id='.$row['music_album_id'].'&title='.$this->changeTitle($row['album_title']),$row['music_album_id'].'/'.$this->changeTitle($row['album_title']).'/', '', 'music');
					$showAlbumlists_arr['row'][$inc]['getUrl_editAlbum_url'] =getUrl('musicalbummanage', '?music_album_id='.$row['music_album_id'], '?music_album_id='.$row['music_album_id'], 'members', 'music');
					$album_image_name=$this->getAlbumImageName($row['music_album_id'], 'thumb');

					$inc++;
				}
			return $showAlbumlists_arr;
		}

		public function showMusiclists()
		{
			$showMusiclists_arr = array();
			$musics_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
			$inc=0;
			$showMusiclists_arr['row'] = array();
			while($row = $this->fetchResultRecord())
				{

					$showMusiclists_arr[$inc]['light_window_url'] = $this->CFG['site']['music_url'].'albumList.php?music_album_id='.$row['music_album_id'].'&light_window=1';
					$showMusiclists_arr['row'][$inc]['record'] = $row;
					$showMusiclists_arr['row'][$inc]['for_sale'] = $row['for_sale'];
					$showMusiclists_arr['row'][$inc]['music_price'] = $row['music_price'];
					$showMusiclists_arr['row'][$inc]['user_id'] = $row['user_id'];
					$showMusiclists_arr['row'][$inc]['music_album_id'] = $row['music_album_id'];
					$showMusiclists_arr['row'][$inc]['total_purchases'] = $row['total_purchases'];
					$showMusiclists_arr['row'][$inc]['word_wrap_music_title'] = highlightWords(wordWrap_mb_ManualWithSpace($row['music_title'], $this->CFG['admin']['musics']['albumlist_album_title_length'], $this->CFG['admin']['musics']['albumlist_album_title_total_length'],0),$this->fields_arr['albumlist_title']);


					$showMusiclists_arr['row'][$inc]['light_window_url'] = $this->CFG['site']['music_url'].'transactionList.php?music_id='.$row['music_id'].'&light_window=1';
					$showMusiclists_arr['row'][$inc]['getUrl_viewMusic_url'] =getUrl('viewmusic', '?music_id='.$row['music_id'].'&title='.$this->changeTitle($row['music_title']),$row['music_id'].'/'.$this->changeTitle($row['music_title']).'/', '', 'music');
					$album_image_name=$this->getAlbumImageName($row['music_album_id'], 'thumb');

					$inc++;
				}
			return $showMusiclists_arr;
		}

		/**
		* musicAlbumList::setTableAndColumns()
		*
		* @return
		*/
		public function setTableAndColumns()
		{
			//Heading
			$this->page_heading = $this->LANG['transactionlist_title'];
			//Query
			switch ($this->fields_arr['transaction_type'])
			{
				case 'album':
				$this->setTableNames(array($this->CFG['db']['tbl']['music_album'].
											' AS al LEFT JOIN '
											.$this->CFG['db']['tbl']['music_album_purchase_user_details'].
											' as mp ON mp.album_id=al.music_album_id'));
				$this->setReturnColumns(array('al.music_album_id', 'al.album_title', 'count(mp.album_id) as total_purchases', 'al.date_added', 'al.total_album_views as total_views', 'al.album_for_sale','al.user_id','al.album_price'));
				$this->sql_condition = 'mp.owner_id = '.$this->fields_arr['user_id'].$this->albumlistAdvancedFilters().' GROUP BY al.music_album_id';
				$this->sql_sort = 'al.music_album_id DESC';
				break;

				case 'music':
				$this->setTableNames(array($this->CFG['db']['tbl']['music_album'].' AS al LEFT JOIN '.$this->CFG['db']['tbl']['music'].' AS m ON al.music_album_id = m.music_album_id LEFT JOIN '.$this->CFG['db']['tbl']['music_purchase_user_details'].' as mp ON mp.music_id=m.music_id'));
				$this->setReturnColumns(array('al.music_album_id','m.music_id','m.music_title','count(mp.music_id) as total_purchases', 'm.music_price', 'm.date_added', 'total_views', 'for_sale','m.user_id'));
				$this->sql_condition = 'mp.owner_id = '.$this->fields_arr['user_id'].' AND price > 0 '.$this->albumlistAdvancedFilters().' GROUP BY m.music_id';
				$this->sql_sort = 'm.music_id DESC';
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
			if ($this->fields_arr['from_date'] != $this->LANG['transactionlist_from_date_select'] AND $this->fields_arr['from_date']!='')
			{
				$this->hidden_array[] = 'from_date';
				$albumlistAdvancedFilters .= ' AND DATE_FORMAT(mp.date_added, \'%Y-%m-%d\') >= \''.$this->fields_arr['from_date'].'\'';
				$this->advanceSearch = true;
			}
			if ($this->fields_arr['to_date'] != $this->LANG['transactionlist_to_date_select'] AND $this->fields_arr['to_date']!='')
			{
				$this->hidden_array[] = 'to_date';
				$albumlistAdvancedFilters .= ' AND DATE_FORMAT(mp.date_added, \'%Y-%m-%d\') <= \''.$this->fields_arr['to_date'].'\'';
				$this->advanceSearch = true;
			}

			return $albumlistAdvancedFilters;
		}

		public function displayAlbumDetailsList($album_id='')
		{
			global $smartyObj;
			$displayDetails_arr = array();
			 $sql = 'SELECT ma.album_title, ma.album_price, ma.total_purchases, ma.total_album_views, ma.total_album_views as total_views, sum(m.total_plays) as total_plays FROM '.
					$this->CFG['db']['tbl']['music_album'].
					' as ma LEFT JOIN '.$this->CFG['db']['tbl']['music'].' as m ON '.
					' ma.music_album_id=m.music_album_id WHERE m.music_status=\'Ok\''.
					' AND ma.music_album_id='.$this->dbObj->Param('music_album_id').
					' GROUP BY m.music_album_id';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($album_id));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);
			$displayDetails_arr['record_count'] = false;
			if($row = $rs->FetchRow())
			{
				$displayDetails_arr['record_count'] = true;
				$displayDetails_arr['title'] = $row['album_title'];
				$displayDetails_arr['price'] = $row['album_price'];
				$displayDetails_arr['total_purchases'] = $row['total_purchases'];
				$displayDetails_arr['total_views'] = $row['total_album_views'];
				$displayDetails_arr['total_plays'] = $row['total_plays'];
			}
			$this->displayAlbumPurchasedMembers($this->getFormField('music_album_id'));
			$smartyObj->assign('displayDetails_arr', $displayDetails_arr);

		}

		public function displayMusicDetailsList($music_id='')
		{
			global $smartyObj;
			$displayDetails_arr = array();
			$sql = 'SELECT m.music_title, m.music_price, m.total_purchases, m.total_views, m.total_plays FROM '.
					$this->CFG['db']['tbl']['music_album'].
					' as ma LEFT JOIN '.$this->CFG['db']['tbl']['music'].' as m ON '.
					' ma.music_album_id=m.music_album_id WHERE m.music_status=\'Ok\''.
					' AND m.music_id='.$this->dbObj->Param('music_id').
					' GROUP BY m.music_album_id';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($music_id));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);
			$displayDetails_arr['record_count'] = false;
			if($row = $rs->FetchRow())
			{
				$displayDetails_arr['record_count'] = true;
				$displayDetails_arr['title'] = $row['music_title'];
				$displayDetails_arr['price'] = $row['music_price'];
				$displayDetails_arr['total_purchases'] = $row['total_purchases'];
				$displayDetails_arr['total_views'] = $row['total_views'];
				$displayDetails_arr['total_plays'] = $row['total_plays'];
			}
			$this->displayMusicPurchasedMembers($music_id);
			$smartyObj->assign('displayDetails_arr', $displayDetails_arr);

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
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			$displaySongList_arr['record_count'] = 0;
			$displaySongList_arr['row'] = array();
			$inc = 1;
			while($songDetail = $rs->FetchRow())
				{
					$displaySongList_arr['record_count'] = 1;
					$displaySongList_arr['row'][$inc]['record'] = $songDetail;
					$displaySongList_arr['row'][$inc]['music_album_id'] = $songDetail['music_album_id'];
					$displaySongList_arr['row'][$inc]['music_artist_id']=$songDetail['music_artist_id'];
					$displaySongList_arr['row'][$inc]['music_id'] = $songDetail['music_id'];
					$displaySongList_arr['row'][$inc]['artist_name'] = $songDetail['artist_name'];
					$displaySongList_arr['row'][$inc]['song_status'] = 1;
					$displaySongList_arr['row'][$inc]['album_access_type'] = $songDetail['album_access_type'];
					$displaySongList_arr['row'][$inc]['album_for_sale'] = $songDetail['album_for_sale'];
					$displaySongList_arr['row'][$inc]['album_price'] = $songDetail['album_price'];
					$displaySongList_arr['row'][$inc]['music_price'] = $songDetail['music_price'];
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
					$displaySongList_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_music_title'] = highlightWords(wordWrap_mb_ManualWithSpace($songDetail['music_title'], $this->CFG['admin']['musics']['albumlist_music_title_length'], $this->CFG['admin']['musics']['albumlist_music_title_total_length']),$this->getFormField('music_title'));
					$displaySongList_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_artist_name'] = highlightWords(wordWrap_mb_ManualWithSpace($songDetail['artist_name'], $this->CFG['admin']['musics']['albumlist_artist_title_length'], $this->CFG['admin']['musics']['albumlist_artist_title_total_length']),$this->getFormField('artist'));
					$displaySongList_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_album_title'] = wordWrap_mb_ManualWithSpace($songDetail['artist_name'], $this->CFG['admin']['musics']['albumlist_album_title_length'], $this->CFG['admin']['musics']['albumlist_album_title_total_length']);
					$displaySongList_arr['row'][$inc]['light_window_url'] = $this->CFG['site']['music_url'].'transactionList.php?music_album_id='.$songDetail['music_album_id'].'&light_window=1';
					$displaySongList_arr['row'][$inc]['getUrl_viewMusic_url'] = getUrl('viewmusic', '?music_id='.$songDetail['music_id'].'&title='.$this->changeTitle($songDetail['music_title']), $songDetail['music_id'].'/'.$this->changeTitle($songDetail['music_title']).'/', '', 'music');
					$displaySongList_arr['row'][$inc]['get_artist_url'] = getUrl('musiclist', '?pg=musicnew&artist_id=' . $songDetail['music_artist_id'], 'musicnew/?artist_id=' . $songDetail['music_artist_id'], '', 'music');
					$inc++;
				}
			$smartyObj->assign('displaySongList_arr', $displaySongList_arr);
			$smartyObj->assign('lastDiv', $$inc=$inc-1);
			//	return true;
		}

		public function displayAlbumPurchasedMembers($album_id)
		{
			global $smartyObj;
			$displayMembersList_arr = array();
			$sql = 'SELECT mp.user_id, u.user_name FROM '.
					$this->CFG['db']['tbl']['music_album_purchase_user_details'].
					' as mp LEFT JOIN '.$this->CFG['db']['tbl']['users'].
					' as u ON mp.user_id=u.user_id '.
					' WHERE album_id='.$this->dbObj->Param('album_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($album_id));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);
			$displayMembersList_arr['record_count'] = 0;
			$inc = 1;
			while($row = $rs->FetchRow())
			{
				$displayMembersList_arr['record_count'] = 1;
				$displayMembersList_arr['row'][$inc]['record'] = $row;
				$displayMembersList_arr['row'][$inc]['user_name'] = $row['user_name'];
				$displayMembersList_arr['row'][$inc]['profile_url'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
				$inc++;
			}
			$smartyObj->assign('displayMembersList_arr', $displayMembersList_arr);
		}

		public function displayMusicPurchasedMembers($music_id)
		{
			global $smartyObj;
			$displayMembersList_arr = array();
			$sql = 'SELECT mp.user_id, u.user_name FROM '.
					$this->CFG['db']['tbl']['music_purchase_user_details'].
					' as mp LEFT JOIN '.$this->CFG['db']['tbl']['users'].
					' as u ON mp.user_id=u.user_id '.
					' WHERE music_id='.$this->dbObj->Param('music_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($music_id));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);
			$displayMembersList_arr['record_count'] = 0;
			$inc = 1;
			while($row = $rs->FetchRow())
			{
				$displayMembersList_arr['record_count'] = 1;
				$displayMembersList_arr['row'][$inc]['record'] = $row;
				$displayMembersList_arr['row'][$inc]['user_name'] = $row['user_name'];
				$displayMembersList_arr['row'][$inc]['profile_url'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
				$inc++;
			}
			$smartyObj->assign('displayMembersList_arr', $displayMembersList_arr);
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
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

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

	public function populatePaymentDetails()
	{
		global $smartyObj;
		$paymentList_arr = array();
		$sql = 'SELECT total_revenue,commission_amount, withdrawl_amount, pending_amount FROM '.
				$this->CFG['db']['tbl']['music_user_payment_settings'].
				' WHERE user_id ='.$this->dbObj->Param('user_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id']));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
			$this->dbObj->ErrorMsg(), E_USER_ERROR);
		$paymentList_arr['record_found'] = false;
		if($row = $rs->FetchRow())
		{
			$paymentList_arr['record_found'] = true;
			$paymentList_arr['total_revenue'] = roundValue($row['total_revenue']);
			$paymentList_arr['withdrawl_amount'] = roundValue($row['withdrawl_amount']);
			$paymentList_arr['commission_amount'] = roundValue($row['commission_amount']);
			$paymentList_arr['pending_amount'] = roundValue($row['pending_amount']);
		}
		$smartyObj->assign('paymentList_arr', $paymentList_arr);

	}

}
//<<<<<-------------- Class musicAlbumListManage end ---------------//
//-------------------- Code begins -------------->>>>>//
$transactiondetails = new transactionDetails();
if(!chkAllowedModule(array('music')))
Redirect2URL($CFG['redirect']['dsabled_module_url']);
$transactiondetails->setPageBlockNames(array('filter_select_block', 'search_albumlist_block', 'list_albumlist_block','songlist_block','displaysonglist_block', 'list_transactionlist_block', 'list_musiclist_block'));
$transactiondetails->setFormField('start', '0');
$transactiondetails->setFormField('numpg', $CFG['music_tbl']['numpg']);
$transactiondetails->setFormField('albumlist_title', '');
$transactiondetails->setFormField('artist', '');
$transactiondetails->setFormField('music_title', '');
$transactiondetails->setFormField('pg', 'albumlistnew');
$transactiondetails->setFormField('action', '');
$transactiondetails->setFormField('light_window', '');
$transactiondetails->setFormField('music_album_id', '');
$transactiondetails->setFormField('music_id', '');
$transactiondetails->setFormField('user_id', '');
$transactiondetails->setFormField('from_date', '');
$transactiondetails->setFormField('to_date', '');
$transactiondetails->setFormField('transaction_type', 'music');
$transactiondetails->setFormField('default', 'Yes');
$transactiondetails->setTableNames(array());
$transactiondetails->setReturnColumns(array());
$transactiondetails->sanitizeFormInputs($_REQUEST);
$transactiondetails->setPageBlockShow('filter_select_block');
$transactiondetails->setPageBlockShow('search_albumlist_block');
$transactiondetails->populatePaymentDetails();

$transactiondetails->album_purchase_url = str_replace('{click_here}','<a href="transactionList.php?transaction_type=album&user_id='.$transactiondetails->getFormField('user_id').'">'.$LANG['transactionlist_click_here'].'</a>' ,$LANG['transactionlist_album_purchases'] );
$transactiondetails->music_purchase_url = str_replace('{click_here}','<a href="transactionList.php?transaction_type=music&user_id='.$transactiondetails->getFormField('user_id').'">'.$LANG['transactionlist_click_here'].'</a>' ,$LANG['transactionlist_music_purchases'] );

if($transactiondetails->getFormField('light_window')!= '')
{
	$transactiondetails->setPageBlockShow('songlist_block');
}
//$transactiondetails->setPageBlockShow('list_albumlist_block');
$transactiondetails->setPageBlockShow('my_musics_form');
if($transactiondetails->isFormPOSTed($_POST, 'search'))
{
	$transactiondetails->albumlistAdvancedFilters();
}
if($transactiondetails->isFormPOSTed($_POST, 'avd_reset'))
{
	$transactiondetails->setFormField('albumlist_title', '');
	$transactiondetails->setFormField('artist', '');
	$transactiondetails->setFormField('music_title', '');
	$transactiondetails->setFormField('from_date', '');
	$transactiondetails->setFormField('to_date', '');
}
if ($transactiondetails->getFormField('pg'))
{
	$transactiondetails->setPageBlockShow('search_albumlist_block');
}
if ($transactiondetails->getFormField('transaction_type')=='album')
{
	$transactiondetails->setAllPageBlocksHide();
	$transactiondetails->setPageBlockShow('search_albumlist_block');
	$transactiondetails->setPageBlockShow('list_albumlist_block');
}
else
	$transactiondetails->setPageBlockShow('list_musiclist_block');
//-------------------- Page block templates begins -------------------->>>>>//
if ($transactiondetails->isShowPageBlock('songlist_block'))
{
	$transactiondetails->includeHeader();
	$transactiondetails->sanitizeFormInputs($_REQUEST);
	$transactiondetails->isShowPageBlock('displaysonglist_block');
	if($transactiondetails->getFormField('music_album_id'))
	{
		$transactiondetails->displayAlbumDetailsList($transactiondetails->getFormField('music_album_id'));
	}
	else if($transactiondetails->getFormField('music_id'))
	{
		$transactiondetails->displayMusicDetailsList($transactiondetails->getFormField('music_id'));
	}

	setTemplateFolder('admin/', 'music');
	$smartyObj->display('transactionDetailsList.tpl');
	$transactiondetails->includeFooter();
	exit;
}
$smartyObj->assign('album_class','');
$smartyObj->assign('music_class','');
if ($transactiondetails->isShowPageBlock('list_albumlist_block'))
{
	/****** navigtion continue*********/
	$transactiondetails->setTableAndColumns();
	$transactiondetails->buildSelectQuery();
	$transactiondetails->buildQuery();
	if($transactiondetails->getFormField('start'))
	$transactiondetails->homeExecuteQuery();
	//$transactiondetails->printQuery();
	$smartyObj->assign('album_class','clsActive');
	//$transactiondetails->printQuery();
	$group_query_arr = array('albumlistmostviewed','albummostrecentlyviewed','albummostlistened','albummostviewed','albumlistnew');
	if (in_array($transactiondetails->getFormField('pg'), $group_query_arr))
   		$transactiondetails->homeExecuteQuery();
	else
		$transactiondetails->executeQuery();
	if($transactiondetails->isResultsFound())
	{
		$transactiondetails->list_albumlist_block['showAlbumlists'] = $transactiondetails->showAlbumlists();
		if($transactiondetails->getFormField('action'))
			$transactiondetails->hidden_array[] = 'action';
		$smartyObj->assign('smarty_paging_list', $transactiondetails->populatePageLinksGET($transactiondetails->getFormField('start'), $transactiondetails->hidden_array));
	}
}

if ($transactiondetails->isShowPageBlock('list_musiclist_block'))
{
	/****** navigtion continue*********/
	$transactiondetails->setTableAndColumns();
	$transactiondetails->buildSelectQuery();
	$transactiondetails->buildQuery();
	if($transactiondetails->getFormField('start'))
	$transactiondetails->homeExecuteQuery();
	//$transactiondetails->printQuery();
	$transactiondetails->executeQuery();
	$smartyObj->assign('music_class','clsActive');
	if($transactiondetails->isResultsFound())
	{
		$transactiondetails->list_musiclist_block['showMusiclists'] = $transactiondetails->showMusiclists();
		if($transactiondetails->getFormField('action'))
			$transactiondetails->hidden_array[] = 'action';
		$smartyObj->assign('smarty_paging_list', $transactiondetails->populatePageLinksGET($transactiondetails->getFormField('start'), $transactiondetails->hidden_array));
	}
}

$transactiondetails->left_navigation_div = 'musicMain';
//include the header file
$transactiondetails->includeHeader();
//include the content of the page
setTemplateFolder('admin/','music');
$smartyObj->display('transactionList.tpl');
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
$transactiondetails->includeFooter();
?>