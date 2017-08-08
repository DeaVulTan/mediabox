<?php
//--------------class AlbumSortList--------------->>>//
/**
* This class is used to music album list and search page
*
* @category		Rayzz
* @package		Album Sort list
* @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
*/
class AlbumSortList extends MusicHandler
{
	public $page_heading = '';
	public $hidden_array = array();
	public $advanceSearch;
	public $player_music_id=array();
	public $sql_count = '';
	/**
	* albumSortList::buildQuery()
	*
	* @return void
	**/
	public function buildQuery()
	{
		//count query..
		$table_name=$this->CFG['db']['tbl']['music_album'];
		//$this->sql_condition=$this->albumlistAdvancedFilters();
		$this->sql_count = ' SELECT count(DISTINCT(SUBSTRING(UPPER(trim(album_title)),1,1))) AS count FROM  ';
		foreach($this->table_names_arr as $table_name)
		{
			if (isset($this->table_aliases_arr[$table_name]))
			{
				if (is_string($this->table_aliases_arr[$table_name]))
				$this->sql_count .= $table_name.' AS '.$this->table_aliases_arr[$table_name].', ';
				else if (is_array($this->table_aliases_arr[$table_name]))
				foreach($this->table_aliases_arr[$table_name] as $sub_alias)
				$this->sql_count .= $table_name.' AS '.$sub_alias .', ';
			}
			else
			$this->sql_count .= $table_name.', ';
		}
		$this->sql_count = substr($this->sql_count, 0, strrpos($this->sql_count, ','));
		if ($this->sql_condition)
			$this->sql_count .= ' WHERE '.$this->sql_condition;
		//main query...
		if ($this->sql_condition)
			$this->sql .= ' WHERE '.$this->sql_condition;
		if ($this->sql_sort)
			$this->sql .= ' ORDER BY '.$this->sql_sort;
		$this->sql .= ' LIMIT '.$this->results_start_num.','.$this->results_num_per_page;
	}
	/**
	* albumSortList::setTableAndColumns()
	*
	* @return
	*/
	public function setTableAndColumns()
	{
		$this->setTableNames(array($this->CFG['db']['tbl']['music_album'].' AS al'));
		$this->setReturnColumns(array( 'DISTINCT(SUBSTRING(UPPER(trim(album_title)),1,1)) as album_chr'));
		$this->sql_condition = '';
		$this->sql_sort = ' al.album_title ASC';
	}
	/**
	* albumSortList::getAlbumTotalSong()
	*
	* @return
	*/
	public function getAlbumTotalSong($album_id_arr, $condition=false)
	{
		$album_ids = implode(',', array_values($album_id_arr));
		$song_count_arr = $return_arr = array();
		if($album_ids != '')
		{
			$sql = ' SELECT ma.music_album_id, count(m.music_id) as song_count FROM '.$this->CFG['db']['tbl']['music_album'].' AS ma LEFT JOIN '
					.$this->CFG['db']['tbl']['music'].' AS m ON ma.music_album_id=m.music_album_id
					WHERE ma.music_album_id = m.music_album_id AND
					m.music_status = \'Ok\' AND FIND_IN_SET(ma.music_album_id,\''.$album_ids.'\') GROUP BY ma.music_album_id';
			if($condition)
				$sql .= ' m.music_access_type = \'Public\''.$this->getAdditionalQuery().') '.$this->getAdultQuery('m.', 'music');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
				trigger_db_error($this->dbObj);
			while($row = $rs->FetchRow())
			{
				$song_count_arr[$row['music_album_id']] = $row['song_count'];
			} // while

		}
		foreach($album_id_arr as $key => $value)
		{
			$return_arr[$key] = isset($song_count_arr[$value]) ?  $song_count_arr[$value] : 0;
		}
		return $return_arr;
	}
	/**
	* albumSortList::chkAdvanceResultFound()
	*
	* @return
	*/
	public function chkAdvanceResultFound()
	{
		if($this->advanceSearch)
		{
			return true;
		}
		return false;
	}
	/**
	* albumSortList::populateAlbumSortTitle()
	*
	* @return
	*/
	public function populateAlbumSortTitle($album_chr)
	{
		global $smartyObj;
		$displaySongList_arr = array();
		$usersPerRow=2;
		$sql = 'SELECT al.album_title as album_title_wrap,al.music_album_id FROM '.$this->CFG['db']['tbl']['music_album']
		.' AS al where al.album_title LIKE \''.$album_chr.'%\' LIMIT '
		.$this->CFG['admin']['musics']['album_sort_char_list'];
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_db_error($this->dbObj);
		$displaySongList_arr['record_count'] = 0;
		$result_arr = array();
		$displaySongList_arr = array();
		$inc = 1;
		$count=1;
		$total=$rs->PO_RecordCount();
		$displaySongList_arr['row'][$inc]['class']='';
		$displaySongList_arr['row'][$inc]['open_tr']='';
		$displaySongList_arr['row'][$inc]['close_tr']='';
		$displaySongList_arr['row'][$inc]['close_table']='';
		$displaySongList_arr['row'][$inc]['album_title_wrap']='';
		$i = 0;
		//array to hold the album ids for which we need to find the total no of songs ..
		$album_ids = array();
		while($row = $rs->FetchRow())
		{
			$displaySongList_arr['record_count'] = 1;
			$displaySongList_arr['row'][$inc]['total_count']=$total;
			$displaySongList_arr['row'][$inc]['count']=$count;
			$displaySongList_arr['row'][$inc]['open_tr']='';
			$displaySongList_arr['row'][$inc]['close_tr']='';
			$displaySongList_arr['row'][$inc]['close_table']='';
			$displaySongList_arr['row'][$inc]['music_album_id']=$row['music_album_id'];
			$displaySongList_arr['row'][$inc]['album_title_wrap']=$row['album_title_wrap'];
			$displaySongList_arr['row'][$inc]['album_url']=getUrl('viewalbum', '?album_id='.$row['music_album_id'].'&title='
			.$this->changeTitle($row['album_title_wrap']),$row['music_album_id'].'/'
			.$this->changeTitle($row['album_title_wrap']).'/', '', 'music');
			if($i % 2 == 0 && $i)
				$displaySongList_arr['row'][$inc]['open_tr']= '<tr>';
				$displaySongList_arr['row'][$inc]['album_title_wrap']='<td><a href="'.$displaySongList_arr['row'][$inc]['album_url'].'">'
				.$row['album_title_wrap']
				. '</a><span> (';


            //$this->getAlbumTotalSong($row['music_album_id'])
			$album_ids[$inc] = $row['music_album_id'];
			$displaySongList_arr['row'][$inc]['album_title_end'] = ')</span></td>';
			if(++$i % 2 == 0 && ($i != $total))
				$displaySongList_arr['row'][$inc]['close_tr'] = '</tr>';
			$count++;
			$inc++;
		}
		$song_count_arr = $this->getAlbumTotalSong($album_ids);
		foreach($song_count_arr as $key => $value)
		{
			$displaySongList_arr['row'][$key]['song_count'] = $value;
		}
		$smartyObj->assign('displaySongList_arr', $displaySongList_arr);
		$smartyObj->assign('lastDiv', $$inc=$inc-1);
	}
	/**
	* albumSortList::showAlbumSortlists()
	*
	* @return
	*/
	public function showAlbumSortlists()
	{
		global $smartyObj;
		$showAlbumlists_arr = array();
		$musics_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'
		.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
		$showAlbumlists_arr['row'] = array();
		$count=0;
		$inc=0;
		while($row = $this->fetchResultRecord())
		{
			$showAlbumlists_arr['row'][$inc]['album_chr_url']=getUrl('albumsortviewlist', '?album_chr='
			.$row['album_chr'], $row['album_chr']
			.'/', '', 'music');
			$showAlbumlists_arr['row'][$inc]['album_chr']=$row['album_chr'];
			$inc++;
		}
		$smartyObj->assign('showAlbumlists_arr', $showAlbumlists_arr);
	}

}
//<<<<<-------------- Class AlbumSortList end ---------------//
//-------------------- Code begins -------------->>>>>//
$albumSortList = new AlbumSortList();
if(!chkAllowedModule(array('music')))
Redirect2URL($CFG['redirect']['dsabled_module_url']);
$albumSortList->setPageBlockNames(array('search_albumlist_block',
										'list_albumlist_block',
										'songlist_block'
								));
$albumSortList->setFormField('start', '0');
$albumSortList->setFormField('numpg', $CFG['music_tbl']['numpg']);
$albumSortList->setFormField('album_chr', '');
$albumSortList->setFormField('action', '');
$albumSortList->setFormField('music_album_id', '');
$albumSortList->setTableNames(array());
$albumSortList->setReturnColumns(array());
$albumSortList->buildQuery();
$albumSortList->sanitizeFormInputs($_REQUEST);
$albumSortList->setPageBlockShow('songlist_block');
$albumSortList->setPageBlockShow('search_albumlist_block');
$albumSortList->setPageBlockShow('list_albumlist_block');
$albumSortList->setPageBlockShow('list_albumlist_block');
$albumSortList->CFG['fieldsize']['album_chr']['min']=1;
$albumSortList->CFG['fieldsize']['album_chr']['max']=1;
$albumSortList->CFG['admin']['musics']['album_sort_char_list'] = 6;
$albumSortList->CFG['admin']['musics']['album_sort_list_title'] = 30;
$albumSortList->CFG['admin']['musics']['album_sort_list_total_title'] = 35;
if ($albumSortList->isShowPageBlock('list_albumlist_block'))
{
	/****** navigtion continue*********/
	$albumSortList->setTableAndColumns();
	$albumSortList->buildSelectQuery();
	$albumSortList->buildQuery();
	$albumSortList->executeQuery();
	if($albumSortList->isResultsFound())
	{
		$albumSortList->list_albumlist_block['showAlbumlists'] = $albumSortList->showAlbumSortlists();
		if($albumSortList->getFormField('action'))
		$albumSortList->hidden_array[] = 'action';
		$smartyObj->assign('smarty_paging_list', $albumSortList->populatePageLinksGET($albumSortList->getFormField('start'),
		                   $albumSortList->hidden_array));
	}
}
$albumSortList->musicalbumList_no_records_found = $LANG['albumsort_no_records_found'];
if($albumSortList->isFormPOSTed($_POST, 'search'))
{

   if($albumSortList->chkIsValidSize('album_chr', 'album_chr', $LANG['albumsort_chr_err_msg']))
   {
       Redirect2URL($albumSortList->getUrl('albumsortviewlist', '?album_chr='.$albumSortList->getFormField('album_chr'),
	                $albumSortList->getFormField('album_chr').'/', '', 'music'));
   }

}
if($albumSortList->isFormPOSTed($_POST, 'avd_reset'))
{
	$albumSortList->setFormField('album_chr', '');
	Redirect2URL($albumSortList->getCurrentUrl());
}
//include the header file
$albumSortList->includeHeader();
//include the content of the page
setTemplateFolder('general/','music');
$smartyObj->display('albumSort.tpl');
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
function resetList(element)
{
	document.seachAdvancedFilter.submit();
	location.href='element';
}
function clearValue(id)
{
	$Jq('#' + id).val('');
    $Jq('#album_chr_Help').css('visibility', 'visible');
}
function setOldValue(id)
{
	if (($Jq('#' + id).val() =="") && (id == 'albumlist_title') )
	$Jq('#' + id).val('<?php echo $LANG['albumsort_albumList_title']?>');
	else if (($Jq('#' + id).val() =="") && (id == 'album_chr') )
	$Jq('#' + id).val('<?php echo $LANG['albumsort_no_of_title']?>');
}
function albumViewListRedirect(chr)
{
	location.href='<?php getUrl('albumsortviewlist', '?album_chr='.$albumSortList->getFormField('album_chr'),
	                $albumSortList->getFormField('album_chr').'/', '', 'music'); ?>';
}
</script>
<?php
$albumSortList->includeFooter();
?>
