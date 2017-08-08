<?php
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
			global $smartyObj;
			$showAlbumlists_arr = array();
			$musics_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
			$inc=0;
			$showAlbumlists_arr['row'] = array();
			$album_result_found = false;
			$total_album_price=0;
			while($row = $this->fetchResultRecord())
				{
					$album_result_found = true;

					$showAlbumlists_arr[$inc]['light_window_url'] = $this->CFG['site']['music_url'].'albumList.php?music_album_id='.$row['music_album_id'].'&light_window=1';
					$showAlbumlists_arr['row'][$inc]['record'] = $row;
					$showAlbumlists_arr['row'][$inc]['album_for_sale'] = $row['album_for_sale'];
					$showAlbumlists_arr['row'][$inc]['album_price'] = $row['album_price'];
					$showAlbumlists_arr['row'][$inc]['user_id'] = $row['user_id'];
					$showAlbumlists_arr['row'][$inc]['music_album_id'] = $row['music_album_id'];
					$showAlbumlists_arr['row'][$inc]['date_added'] = $row['date_added'];
					$showAlbumlists_arr['row'][$inc]['word_wrap_album_title'] = highlightWords($row['album_title'],$this->fields_arr['albumlist_title']);


					$showAlbumlists_arr['row'][$inc]['light_window_url'] = $this->CFG['site']['music_url'].'listenerTransactionList.php?music_album_id='.$row['music_album_id'].'&light_window=1';
					$showAlbumlists_arr['row'][$inc]['getUrl_viewAlbum_url'] =getUrl('viewalbum', '?album_id='.$row['music_album_id'].'&title='.$this->changeTitle($row['album_title']),$row['music_album_id'].'/'.$this->changeTitle($row['album_title']).'/', '', 'music');
					$showAlbumlists_arr['row'][$inc]['getUrl_editAlbum_url'] =getUrl('musicalbummanage', '?music_album_id='.$row['music_album_id'], '?music_album_id='.$row['music_album_id'], 'members', 'music');
					$album_image_name=$this->getAlbumImageName($row['music_album_id'], 'thumb');
					$total_album_price = $total_album_price+$row['album_price'];
					$inc++;
				}
			$smartyObj->assign('album_result_found', $album_result_found);
			return $showAlbumlists_arr;
		}

		public function showMusiclists()
		{
			global $smartyObj;
			$showMusiclists_arr = array();
			$musics_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
			$inc=0;
			$total_music_price=0;
			$showMusiclists_arr['row'] = array();
			while($row = $this->fetchResultRecord())
				{

					$showMusiclists_arr[$inc]['light_window_url'] = $this->CFG['site']['music_url'].'albumList.php?music_album_id='.$row['music_album_id'].'&light_window=1';
					$showMusiclists_arr['row'][$inc]['record'] = $row;
					$showMusiclists_arr['row'][$inc]['for_sale'] = $row['for_sale'];
					$showMusiclists_arr['row'][$inc]['music_price'] = $row['music_price'];
					$showMusiclists_arr['row'][$inc]['user_id'] = $row['user_id'];
					$showMusiclists_arr['row'][$inc]['music_album_id'] = $row['music_album_id'];
					$showMusiclists_arr['row'][$inc]['date_added'] = $row['date_added'];
					$showMusiclists_arr['row'][$inc]['total_purchases'] = $row['total_purchases'];
					$showMusiclists_arr['row'][$inc]['word_wrap_music_title'] = highlightWords(wordWrap_mb_ManualWithSpace($row['music_title'], $this->CFG['admin']['musics']['albumlist_album_title_length'], $this->CFG['admin']['musics']['albumlist_album_title_total_length'],0),$this->fields_arr['albumlist_title']);


					$showMusiclists_arr['row'][$inc]['light_window_url'] = $this->CFG['site']['music_url'].'listenerTransactionList.php?music_id='.$row['music_id'].'&light_window=1';
					$showMusiclists_arr['row'][$inc]['getUrl_viewMusic_url'] =getUrl('viewmusic', '?music_id='.$row['music_id'].'&title='.$this->changeTitle($row['music_title']),$row['music_id'].'/'.$this->changeTitle($row['music_title']).'/', '', 'music');
					$album_image_name=$this->getAlbumImageName($row['music_album_id'], 'thumb');
					$total_music_price = $total_music_price+$row['music_price'];
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
				$this->setTableNames(array($this->CFG['db']['tbl']['music_album'].' AS al LEFT JOIN '.$this->CFG['db']['tbl']['music_album_purchase_user_details'].' AS mp ON al.music_album_id = mp.album_id LEFT JOIN '.$this->CFG['db']['tbl']['music'].' as m ON al.music_album_id=m.music_album_id'));
				$this->setReturnColumns(array('al.music_album_id', 'al.album_title', 'al.total_purchases','DATE_FORMAT(mp.date_added,\''.$this->CFG['format']['date'].'\') as date_added', 'al.total_album_views as total_views', 'al.album_for_sale','al.user_id','mp.price as album_price'));
				$this->sql_condition = 'mp.user_id = '.$this->CFG['user']['user_id'].$this->albumlistAdvancedFilters().' GROUP BY al.music_album_id';
				$this->sql_sort = 'al.music_album_id DESC';
				break;

				case 'music':
				$this->setTableNames(array($this->CFG['db']['tbl']['music'].' AS m LEFT JOIN '.$this->CFG['db']['tbl']['music_purchase_user_details'].' as mp ON mp.music_id=m.music_id '));
				$this->setReturnColumns(array('m.music_id','m.music_title','m.music_album_id', 'mp.price as music_price', 'm.date_added', 'total_views','DATE_FORMAT(mp.date_added,\''.$this->CFG['format']['date'].'\') as date_added', 'for_sale','m.user_id','m.total_purchases'));
				$this->sql_condition = 'mp.user_id = '.$this->CFG['user']['user_id'].' AND music_status=\'Ok\' AND album_id=0 '.$this->albumlistAdvancedFilters().' GROUP BY m.music_id';
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
		$sql = 'SELECT sum(amount) as amount FROM '.
				$this->CFG['db']['tbl']['music_order'].
				' WHERE user_id ='.$this->dbObj->Param('user_id').
				' AND music_order_status=\'Yes\''.
				' GROUP BY user_id';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
			$this->dbObj->ErrorMsg(), E_USER_ERROR);
		$paymentList_arr['record_found'] = false;
		if($row = $rs->FetchRow())
		{
			$paymentList_arr['record_found'] = true;
			$paymentList_arr['total_purchased'] = $row['amount'];
		}
		$smartyObj->assign('paymentList_arr', $paymentList_arr);
		$album_price = 0;
		$sql = 'SELECT sum(al.album_price) as album_price FROM '.
				$this->CFG['db']['tbl']['music_album_purchase_user_details'].
				' as mp LEFT JOIN '.$this->CFG['db']['tbl']['music_album'].
				' as al ON mp.album_id=al.music_album_id WHERE mp.user_id='.$this->dbObj->Param('user_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
			$this->dbObj->ErrorMsg(), E_USER_ERROR);
		$row = $rs->FetchRow();
		if($row['album_price'])
			$album_price = $row['album_price'];
		$smartyObj->assign('total_album_price',$album_price);

		$music_price = 0;
		$sql = 'SELECT sum(m.music_price) as music_price FROM '.
				$this->CFG['db']['tbl']['music_purchase_user_details'].
				' as mp LEFT JOIN '.$this->CFG['db']['tbl']['music'].
				' as m ON mp.music_id=m.music_id WHERE mp.user_id='.$this->dbObj->Param('user_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
			$this->dbObj->ErrorMsg(), E_USER_ERROR);
		$row = $rs->FetchRow();
		if($row['music_price'])
			$music_price = $row['music_price'];
		$smartyObj->assign('total_music_price',$music_price );

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

$album_url = getUrl('listenertransactionlist','?transaction_type=album','?transaction_type=album','members','music');
$music_url = getUrl('listenertransactionlist','?transaction_type=music','?transaction_type=music','members','music');
$transactiondetails->album_purchase_url = str_replace('VAR_CLICK_HERE','<a href="'.$album_url.'">'.$LANG['transactionlist_click_here'].'</a>' ,$LANG['transactionlist_album_purchases'] );
$transactiondetails->music_purchase_url = str_replace('VAR_CLICK_HERE','<a href="'.$music_url.'">'.$LANG['transactionlist_click_here'].'</a>' ,$LANG['transactionlist_music_purchases'] );

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
	$group_query_arr = array('albumlistmostviewed','albummostrecentlyviewed','albummostlistened','albummostviewed','albumlistnew');
	if (in_array($transactiondetails->getFormField('pg'), $group_query_arr))
   		$transactiondetails->homeExecuteQuery();
	else
		$transactiondetails->executeQuery();
	$smartyObj->assign('album_class','clsActive');
	$smartyObj->assign('album_result_found', false);
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


//include the header file
$transactiondetails->includeHeader();
//include the content of the page
setTemplateFolder('general/','music');
$smartyObj->display('listenerTransactionList.tpl');
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
	$(id).value = '';
}
function setOldValue(id)
	{
		if (($(id).value=="") && (id == 'albumlist_title') )
		$(id).value = '<?php echo $LANG['musicalbumList_albumList_title']?>';
		else if (($(id).value=="") && (id == 'artist') )
		$(id).value = '<?php echo $LANG['musicalbumList_no_of_artist']?>';
		else if (($(id).value=="") && (id == 'music_title') )
		$(id).value = '<?php echo $LANG['musicalbumList_no_of_music_title']?>';
	}

</script>
<?php
$transactiondetails->includeFooter();
?>