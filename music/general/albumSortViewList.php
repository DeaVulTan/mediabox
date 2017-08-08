<?php
//--------------class AlbumSortViewList--------------->>>//
/**
* This class is used to music album sort view list and search page
*
* @category		Rayzz
* @package		manage music album sort view list
* @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
*/
class AlbumSortViewList extends MusicHandler
{
	public $page_heading = '';
	public $hidden_array = array();
	public $advanceSearch;
	public $player_music_id=array();
	public $sql_count = '';
	/**
	* albumSortViewList::buildQuery()
	*
	* @return void
	**/
	public function buildQuery()
	{
		//count query..
		$table_name=$this->CFG['db']['tbl']['music_album'];
		$this->sql_count = ' SELECT count(al.album_title) as count FROM ';
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
	* albumSortViewList::setTableAndColumns()
	*
	* @return
	*/
	public function setTableAndColumns()
	{
		$this->setTableNames(array($this->CFG['db']['tbl']['music_album'].' AS al'));
		$this->setReturnColumns(array( 'DISTINCT(SUBSTRING(UPPER(trim(album_title)),1,1)) as album_chr','al.album_title','al.music_album_id'));
		$this->sql_condition = ' al.album_title LIKE \''.addslashes($this->fields_arr['album_chr']).'%\'';
		$this->sql_sort = ' al.album_title ASC ';
	}
	/**
	* albumSortViewList::getAlbumTotalSong()
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
	* albumSortViewList::chkAdvanceResultFound()
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
	* albumSortViewList::populateAlbumSortTitle()
	*
	* @return
	*/
	public function populateAlbumSortTitle($album_chr)
	{
		global $smartyObj;
		$displaySongList_arr = array();
		$usersPerRow=2;
		$sql = 'SELECT al.album_title as album_title_wrap FROM music_album AS al where al.album_title LIKE \''.$album_chr.'%\'';
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
		$i = 0;
		while($row = $rs->FetchRow())
		{
			$displaySongList_arr['record_count'] = 1;
			$displaySongList_arr['row'][$inc]['total_count']=$total;
			$displaySongList_arr['row'][$inc]['count']=$count;
			$displaySongList_arr['row'][$inc]['album_title_wrap']=$row['album_title_wrap'];
			$displaySongList_arr['row'][$inc]['album_char_url']=getUrl('albumsortviewlist', '?album_chr='.$album_chr, $album_chr.'/', '', 'music');
			$displaySongList_arr['row'][$inc]['album_title_wrap']= $row['album_title_wrap'];
			$count++;
			$inc++;
		}
		$smartyObj->assign('displaySongList_arr', $displaySongList_arr);
		$smartyObj->assign('lastDiv', $$inc=$inc-1);
	}
	/**
	* albumSortViewList::showAlbumSortViewlists()
	*
	* @return
	*/
	public function showAlbumSortViewlists()
	{
		global $smartyObj;
		$showAlbumlists_arr = array();
		$musics_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'
		.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
		$showAlbumlists_arr['row'] = array();
		$count=0;
		$inc=0;
		//array to hold the album ids for which we need to find the total no of songs ..
		$album_ids = array();
		while($row = $this->fetchResultRecord())
		{
			$showAlbumlists_arr['row'][$inc]['album_chr']=$row['album_chr'];
			$showAlbumlists_arr['row'][$inc]['album_url']=getUrl('viewalbum', '?album_id='.$row['music_album_id'].'&title='
			.$this->changeTitle($row['album_title']),$row['music_album_id'].'/'
			.$this->changeTitle($row['album_title']).'/', '', 'music');
			$showAlbumlists_arr['row'][$inc]['album_title']='<a href='.$showAlbumlists_arr['row'][$inc]['album_url'].'>'
			.$row['album_title']
			. '</a><span> (' ;
			//$this->getAlbumTotalSong($row['music_album_id'])
			$album_ids[$inc] = $row['music_album_id'];
			$showAlbumlists_arr['row'][$inc]['album_title_end'] = ')</span>';
			$inc++;
		}
		$song_count_arr = $this->getAlbumTotalSong($album_ids);
		foreach($song_count_arr as $key => $value)
		{
			$showAlbumlists_arr['row'][$key]['song_count'] = $value;
		}
		$smartyObj->assign('showAlbumlists_arr', $showAlbumlists_arr);
	}
	public function getPageTitle()
	{
		$pg_title = $this->LANG['albumviewsort_title'];
		$tagsTitle     = '';
		if($this->fields_arr['pg'])
		{
			$pg_title = $this->LANG['albumviewsort_title'];
			$name = $this->fields_arr['album_chr'];
			$pg_title = ucfirst(str_replace('VAR_SRC_CHR', $name, $pg_title));
		}
	  return $pg_title;
	}
}
//<<<<<-------------- Class AlbumSortList end ---------------//
//-------------------- Code begins -------------->>>>>//
$albumSortViewList = new AlbumSortViewList();
if(!chkAllowedModule(array('music')))
Redirect2URL($CFG['redirect']['dsabled_module_url']);
$CFG['album_view_sort_list']['numpg'] = 30;
$albumSortViewList->setPageBlockNames(array('search_albumlist_block',
											'list_albumlist_block',
											'songlist_block'
									));
$albumSortViewList->setFormField('start', '0');
$albumSortViewList->setFormField('numpg', $CFG['album_view_sort_list']['numpg']);
$albumSortViewList->setFormField('album_chr', '');
$albumSortViewList->setFormField('album_src_chr', '');
$albumSortViewList->setFormField('music_id', '');
$albumSortViewList->setFormField('pg', 'albumlistnew');
$albumSortViewList->setFormField('action', '');
$albumSortViewList->setFormField('music_album_id', '');
$albumSortViewList->setTableNames(array());
$albumSortViewList->setReturnColumns(array());
$albumSortViewList->buildQuery();
$albumSortViewList->sanitizeFormInputs($_REQUEST);
$albumSortViewList->setPageBlockShow('search_albumlist_block');
$albumSortViewList->setPageBlockShow('list_albumlist_block');
$albumSortViewList->CFG['admin']['musics']['album_sort_view_list_title'] = 70;
$albumSortViewList->CFG['admin']['musics']['album_sort_view_list_total_title'] = 80;
$albumSortViewList->LANG['albumviewsort_title'] = $albumSortViewList->getPageTitle();
$albumSortViewList->CFG['fieldsize']['album_src_chr']['min']=1;
$albumSortViewList->CFG['fieldsize']['album_src_chr']['max']=1;
if($albumSortViewList->getFormField('album_src_chr'))
{
  $albumSortViewList->setPageBlockShow('list_albumlist_block');
}
if($albumSortViewList->isFormPOSTed($_POST, 'search'))
{

   if($albumSortViewList->chkIsValidSize('album_src_chr', 'album_src_chr', $LANG['albumviewsort_chr_err_msg']))
   {
       Redirect2URL($albumSortViewList->getUrl('albumsortviewlist', '?album_chr='.$albumSortViewList->getFormField('album_src_chr'),
	                $albumSortViewList->getFormField('album_src_chr').'/', '', 'music'));
   }

}
if($albumSortViewList->isFormPOSTed($_POST, 'avd_reset'))
{
	$albumSortViewList->setFormField('album_src_chr', '');
	//Redirect2URL($albumSortViewList->getCurrentUrl());
	Redirect2URL($albumSortViewList->getUrl('albumsortlist', '', '','','music'));

}
if ($albumSortViewList->isShowPageBlock('list_albumlist_block'))
{
	/****** navigtion continue*********/
	$albumSortViewList->setTableAndColumns();
	$albumSortViewList->buildSelectQuery();
	$albumSortViewList->buildQuery();
	$albumSortViewList->executeQuery();
	if($albumSortViewList->isResultsFound())
	{
		$albumSortViewList->list_albumlist_block['showAlbumlists'] = $albumSortViewList->showAlbumSortViewlists();
		if($albumSortViewList->getFormField('action'))
			$albumSortViewList->hidden_array[] = 'action';
		$albumSortViewList->hidden_array[] = 'album_chr';
		$smartyObj->assign('smarty_paging_list', $albumSortViewList->populatePageLinksGET($albumSortViewList->getFormField('start'),
		$albumSortViewList->hidden_array));
	}
}
$albumSortViewList->musicalbumList_no_records_found = $LANG['albumviewsort_no_records_found'];
//include the header file
$albumSortViewList->includeHeader();
//include the content of the page
setTemplateFolder('general/','music');
$smartyObj->display('albumSortViewList.tpl');
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
	$Jq('#album_src_chr_Help').css('visibility', 'visible');

}
function setOldValue(id)
{
    if (($Jq('#' + id).val() =="") && (id == 'album_src_chr') )
	$Jq('#' + id).val('<?php echo $LANG['albumviewsort_no_of_title']?>');
}
function albumViewListRedirect(chr)
{
	location.href='<?php getUrl('albumsortviewlist', '?album_chr='.$albumSortViewList->getFormField('album_src_chr'),
	                $albumSortViewList->getFormField('album_src_chr').'/', '', 'music'); ?>';
}
</script>
<?php
$albumSortViewList->includeFooter();
?>
