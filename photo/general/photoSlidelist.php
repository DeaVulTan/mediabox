<?php
//--------------class photoPlaylist--------------->>>//
/**
 * This class is used to photo playlist and search page
 *
 * @category	Rayzz
 * @package		manage photo playlist
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 */
class photoSlidelist extends PhotoHandler
{
	public $page_heading = '';
	public $hidden_array = array('pg');


	/**
	 * photoSlidelist::getPageTitle()
	 *
	 * @return
	 */
	public function getPageTitle()
	{
	    $pg_title = $this->LANG['photoslidelist_heading_slidelistnew'];

		//If default value is Yes then reset the pg value as null.
	    if($this->getFormField('default')== 'Yes' && $this->fields_arr['pg'] == 'playlistnew')
			$this->fields_arr['pg'] = '';

		$categoryTitle = '';
		$tagsTitle     = '';
		$artistTitle   = '';

	    switch ($this->fields_arr['pg'])
		 {
	        case 'myslidelist':
	            $pg_title = $this->LANG['photoslidelist_my_title'];
	            break;
	        default:
				if ($this->fields_arr['pg'] == 'slidelistrecent')
				{
					$pg_title = $this->LANG['header_nav_photo_photo_new'];
				}
				else
					$pg_title = $this->LANG['photoslidelist_heading_slidelistnew'];
	            break;
	    }

        //change the page title if my photo is selected
	    if ($this->fields_arr['myslidelist'] == 'Yes' && $this->fields_arr['pg'] != 'myslidelist') {
		 	$pg_title = $pg_title.' '.$this->LANG['in'].' '.$this->LANG['photoslidelist_title'];
		 	if($this->fields_arr['pg'] == 'playlistnew' || $this->fields_arr['pg'] == '')
		 		$pg_title = $this->LANG['photoslidelist_title'];
		}

		//change the page title if recored display via tags.
		if ($this->fields_arr['tags']){
            $tagsTitle = $this->LANG['photoslidelist_tagsphoto_title'];
            $name = $this->fields_arr['tags'];
            $tagsTitle = str_replace('{tags_name}', $name, $tagsTitle);
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
	 * photoSlidelist::showSlidelists()
	 *
	 * @return
	 */
	public function showSlidelists()
	{
		$showSlidelists_arr = array();
		$playlist_thumbnail_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['photos']['folder'] . '/' . $this->CFG['admin']['photos']['photo_folder'] . '/';
		$inc=0;
		$showSlidelists_arr['row'] = array();
		$fields_list   = array('user_name', 'first_name', 'last_name');
		while($row = $this->fetchResultRecord())
		{

			$this->UserDetails = $this->getUserDetail('user_id', $row['user_id'], 'user_name');
			if($this->UserDetails != '')
			{
				$showSlidelists_arr['row'][$inc]['memberProfileUrl'] = getMemberProfileUrl($row['user_id'], $this->UserDetails);
				$showSlidelists_arr['row'][$inc]['name']	= $this->UserDetails;
			}
			//echo '<pre>';print_r($row);echo '</pre>';
			$row['photo_playlist_name'] = $row['photo_playlist_name'];
			$row['date_added'] = ($row['date_added'] != '') ? getTimeDiffernceFormat($row['date_added']) : '';
			$showSlidelists_arr['row'][$inc]['record'] = $row;
			//since alt and title attribute shows highlight css code
			$showSlidelists_arr['row'][$inc]['record']['alt_user_name'] = $row['user_name'];
			$showSlidelists_arr['row'][$inc]['record']['user_name'] = highlightWords($row['user_name'],$this->fields_arr['createby']);
			$showSlidelists_arr['row'][$inc]['getMemberProfileUrl'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
			//Playlist Image...
			$showSlidelists_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_playlist_title'] = highlightWords($row['photo_playlist_name'], $this->fields_arr['playlist_title']);
			$showSlidelists_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_photo_playlist_description'] = $row['photo_playlist_description'];
			$showSlidelists_arr['row'][$inc]['view_playlisturl'] = getUrl('flashshow', '?slideshow=pl&playlist='.$row['photo_playlist_id'], 'pl/'.$row['photo_playlist_id'].'/', '','photo');
			$showSlidelists_arr['row'][$inc]['light_window_url'] = $this->CFG['site']['photo_url'].'photoSlidelist.php?photo_playlist_id='.$row['photo_playlist_id'].'&light_window=1';
			$showSlidelists_arr['row'][$inc]['private_photo'] = $row['total_photos'] - $this->getPlaylistTotalPhotos($row['photo_playlist_id']);
			$inc++;
		}
		/*echo '<pre>';
		print_r($showSlidelists_arr);
		echo '</pre>';*/
		return $showSlidelists_arr;
	}

	/**
	 * photoPlaylist::setShortItem()
	 *
	 * @return
	 */
	public function setShortItem()
	{
		if($this->fields_arr['short_by_playlist'] == 'title')
				$this->sql_sort = 'pl.photo_playlist_name ASC';
		else
			$this->sql_sort = 'pl.total_photos DESC';
	}

	/**
	 * photoPlaylist::myPhotoCondition()
	 *
	 * @return string
	 * @access public
	 */
	public function myPhotoCondition()
	{
		$userCondition = '';
		if($this->fields_arr['myslidelist'] != 'No')
			$userCondition = ' pl.created_by_user_id = '.$this->CFG['user']['user_id'].' AND ';
		return $userCondition;
	}


	 /**
	  * photoPlaylist::setTableAndColumns()
	  *
	  * @return
	  */
	public function setTableAndColumns()
 	{
		switch ($this->fields_arr['pg'])
		{

			case 'myslidelist':
				$this->setTableNames(array($this->CFG['db']['tbl']['photo_playlist'].' as pl JOIN '.$this->CFG['db']['tbl']['users'].' as u ON pl.created_by_user_id=u.user_id' ));
				$this->setReturnColumns(array('pl.photo_playlist_id', 'pl.photo_playlist_name', 'TIMEDIFF(NOW(), pl.date_added) AS date_added','pl.total_photos', 'pl.total_views', 'pl.photo_playlist_description', 'u.user_name', 'u.user_id'));
			 	$this->sql_condition = 'pl.created_by_user_id=\''.$this->CFG['user']['user_id'].'\' AND pl.photo_playlist_status=\'Yes\' AND u.usr_status=\'Ok\''.$this->addtionalQuery().$this->slidelistAdvancedFilters();
				if($this->sql_sort == '')
					$this->sql_sort = 'pl.photo_playlist_id DESC';
				//$this->page_heading = '';
			break;

			default:
				if($this->fields_arr['myfavoriteslidelist'] == 'No')
				{
					$this->setTableNames(array($this->CFG['db']['tbl']['photo_playlist'].' as pl JOIN '.$this->CFG['db']['tbl']['users'].' as u ON pl.created_by_user_id=u.user_id' ));
					$this->setReturnColumns(array('pl.photo_playlist_id', 'pl.photo_playlist_name', 'TIMEDIFF(NOW(), pl.date_added) AS date_added','pl.total_photos', 'pl.total_views', 'pl.photo_playlist_description', 'u.user_name', 'u.user_id'));
					$this->sql_condition = $this->myPhotoCondition().'pl.photo_playlist_status=\'Yes\' AND u.usr_status=\'Ok\''.$this->addtionalQuery().$this->slidelistAdvancedFilters();
				}
				else
				{
					$this->setTableNames(array($this->CFG['db']['tbl']['photo_playlist'] . ' AS pl JOIN ' . $this->CFG['db']['tbl']['photo_playlist_favorite'] . ' AS pf ON pl.photo_playlist_id = pf.photo_playlist_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u '));
					$this->setReturnColumns(array('pl.photo_playlist_id', 'pl.photo_playlist_name', 'TIMEDIFF(NOW(), pl.date_added) AS date_added','pl.total_photos', 'pl.total_views', 'pl.photo_playlist_description', 'u.user_name', 'u.user_id', 'pl.last_viewed_date'));
					$this->sql_condition = ' pl.created_by_user_id = u.user_id AND u.usr_status=\'Ok\' AND pl.photo_playlist_status=\'Yes\' AND pf.user_id=\''.$this->CFG['user']['user_id'].'\' '.$this->addtionalQuery().$this->slidelistAdvancedFilters();
				}

				if($this->sql_sort == '')
					$this->sql_sort = 'pl.photo_playlist_id DESC';
			break;
		}
	}

	/**
	 * photoPlaylist::slidelistAdvancedFilters()
	 *
	 * @return
	 */
	public function slidelistAdvancedFilters()
	{
		$slidelistAdvancedFilters = '';
		$this->advanceSearch = false;
		if ($this->fields_arr['playlist_title'] != $this->LANG['photoslidelist_slidelist_title'] AND $this->fields_arr['playlist_title'])
		{
			$this->hidden_array[] = 'playlist_title';
			$slidelistAdvancedFilters .= ' AND pl.photo_playlist_name LIKE \'%' .validFieldSpecialChr($this->fields_arr['playlist_title']). '%\' ';
			$this->advanceSearch = true;
		}
		if ($this->fields_arr['createby'] != $this->LANG['photoslidelist_createby'] AND $this->fields_arr['createby'])
		{
			$this->hidden_array[] = 'createby';
			$slidelistAdvancedFilters .= ' AND u.user_name LIKE \'%' .validFieldSpecialChr($this->fields_arr['createby']). '%\' ';
			$this->advanceSearch = true;
		}
		if ($this->fields_arr['photos'] != $this->LANG['photoslidelist_no_of_photos'] AND $this->fields_arr['photos'])
		{
			$this->hidden_array[] = 'photos';
			switch ($this->getFormField('photos'))
			{
				case 2:
					$slidelistAdvancedFilters .= ' AND pl.total_photos <10 AND pl.total_photos >= 0';
					break;

				case 3:
					$slidelistAdvancedFilters .= ' AND pl.total_photos >=10 AND pl.total_photos<20';
					break;

				case 4:
					$slidelistAdvancedFilters .= ' AND pl.total_photos >=20 AND pl.total_photos<30';
					break;

				case 5:
					$slidelistAdvancedFilters .= ' AND pl.total_photos > 30 ';
					break;
			}
			//$slidelistAdvancedFilters .= ' AND pl.total_photos = \'' .$this->fields_arr['photos']. '\' ';
			$this->advanceSearch = true;
		}
		if ($this->fields_arr['views'] != $this->LANG['photoslidelist_no_of_views'] AND $this->fields_arr['views'])
		{
			$this->hidden_array[] = 'views';
			switch ($this->getFormField('views'))
			{
				case 2:
					$slidelistAdvancedFilters .= ' AND pl.total_views <10 AND pl.total_views >= 0';
					break;

				case 3:
					$slidelistAdvancedFilters .= ' AND pl.total_views >=10 AND pl.total_views<20';
					break;

				case 4:
					$slidelistAdvancedFilters .= ' AND pl.total_views >=20 AND pl.total_views<30';
					break;

				case 5:
					$slidelistAdvancedFilters .= ' AND pl.total_views > 30 ';
					break;
			}
			//$slidelistAdvancedFilters .= ' AND pl.total_views = \'' .$this->fields_arr['views']. '\' ';
			$this->advanceSearch = true;
		}
		return $slidelistAdvancedFilters;
	}

	public function chkAdvanceResultFound()
	{
		if($this->advanceSearch)
			return true;

		return false;
	}

	/**
	 * photoPlaylist::addtionalQuery()
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
	  * photoPlaylist::getMostViewedExtraQuery()
	  *
	  * @return
	  */
	public function getMostViewedExtraQuery()
    {
        $extra_query = '';
        switch ($this->fields_arr['action']) {
            case 1:
                $extra_query = ' AND DATE_FORMAT(vpl.viewed_date,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
            break;

            case 2:
                $extra_query = ' AND DATE_FORMAT(vpl.viewed_date,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
            break;

            case 3:
                $extra_query = ' AND DATE_FORMAT(vpl.viewed_date,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
            break;

            case 4:
                $extra_query = ' AND DATE_FORMAT(vpl.viewed_date,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
            break;

            case 5:
                $extra_query = ' AND DATE_FORMAT(vpl.viewed_date,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
            break;
        }
        return $extra_query;
    }
}
//<<<<<-------------- Class photoPlaylistManage end ---------------//
//-------------------- Code begins -------------->>>>>//
$photoslidelist = new photoSlidelist();
if(!chkAllowedModule(array('photo')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
/*echo '<pre>';
print_r($_REQUEST);
echo '</pre>';*/
$photoslidelist->setPageBlockNames(array('filter_select_block', 'search_playlist_block', 'list_playlist_block', 'photolist_block'));
$photoslidelist->LANG_SEARCH_PHOTO_ARR = $LANG_SEARCH_ARR['searchtotalphotos'];
$photoslidelist->LANG_SEARCH_VIEW_ARR = $LANG_SEARCH_ARR['searchtotalviews'];
$photoslidelist->setFormField('start', '0');
$photoslidelist->setFormField('numpg', $CFG['photo_tbl']['numpg']);
$photoslidelist->setFormField('playlist_title', '');
$photoslidelist->setFormField('tags', '');
$photoslidelist->setFormField('createby', '');
$photoslidelist->setFormField('photos', '');
$photoslidelist->setFormField('views', '');
$photoslidelist->setFormField('pg', '');
$photoslidelist->setFormField('action', '');
$photoslidelist->setFormField('action_new', '');
$photoslidelist->setFormField('light_window', '');
$photoslidelist->setFormField('short_by_playlist', '');
$photoslidelist->setFormField('photo_playlist_id', '');
$photoslidelist->setFormField('default', 'Yes');
$photoslidelist->setFormField('myslidelist', 'No');
$photoslidelist->setFormField('myfavoriteslidelist', 'No');
$photoslidelist->setTableNames(array());
$photoslidelist->setReturnColumns(array());
//General Query..
$photoslidelist->sanitizeFormInputs($_REQUEST);

if($photoslidelist->getFormField('default')== 'Yes' && $photoslidelist->getFormField('pg')== 'photonew' && $photoslidelist->getFormField('tags') == '')
	$photoslidelist->setFormField('pg', '');
elseif($photoslidelist->getFormField('default')== 'No')
	$photoslidelist->setFormField('pg', (isset($_GET['pg']) && !empty($_GET['pg']))?$_GET['pg']:$_REQUEST['pg']);


if(isset($_REQUEST['action']))
	$photoslidelist->setFormField('action_new', $_REQUEST['action']);

$action_new = $photoslidelist->getFormField('action_new');
$photoslidelist->setFormField('action', $action_new);


$photoslidelist->setPageBlockShow('filter_select_block');
$photoslidelist->setPageBlockShow('search_playlist_block');
$photoslidelist->setPageBlockShow('list_playlist_block');
if($photoslidelist->isFormPOSTed($_POST, 'search'))
{
	$photoslidelist->slidelistAdvancedFilters();
}
if($photoslidelist->isFormPOSTed($_POST, 'avd_reset'))
{
	$photoslidelist->setFormField('playlist_title', '');
	$photoslidelist->setFormField('photos', '');
	$photoslidelist->setFormField('createby', '');
	$photoslidelist->setFormField('views', '');
}
if($photoslidelist->getFormField('light_window')!= '')
{
	$photoslidelist->setPageBlockShow('photolist_block');
}
if($photoslidelist->getFormField('short_by_playlist')!= '')
{
	$photoslidelist->setShortItem();
	$photoslidelist->hidden_array[] = 'short_by_playlist';
}
$photoslidelist->getPageTitle();

if($photoslidelist->getFormField('pg')== 'myslidelist')
	$photoslidelist->setFormField('myslidelist', 'Yes');

if($photoslidelist->getFormField('pg')== 'myfavoriteslidelist')
	$photoslidelist->setFormField('myfavoriteslidelist', 'Yes');


//<<<<<-------------- Code end ----------------------------------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($photoslidelist->isShowPageBlock('photolist_block'))
{
	$photoslidelist->includeHeader();
	$photoslidelist->displayPhotoList($photoslidelist->getFormField('photo_playlist_id'));
	setTemplateFolder('general/', 'photo');
	$smartyObj->display('photosInSlideList.tpl');
	$photoslidelist->includeFooter();
	exit;
}
if ($photoslidelist->isShowPageBlock('list_playlist_block'))
{
	/****** navigtion continue*********/
	$photoslidelist->setTableAndColumns();
	$photoslidelist->buildSelectQuery();
	$photoslidelist->buildQuery();
	//$photoslidelist->printQuery();
	$group_query_arr = array('featuredplaylistlist', 'playlistmostfavorite', 'featuredplaylistlist', 'playlistmostdiscussed', 'playlistmostviewed');
	if (in_array($photoslidelist->getFormField('pg'), $group_query_arr))
   		$photoslidelist->homeExecuteQuery();
	else
		$photoslidelist->executeQuery();

	//$photoslidelist->printQuery();
	if ($CFG['feature']['rewrite_mode'] != 'normal')
        $paging_arr = array('start','playlist_title','createby','photos','views','tags','short_by_playlist','action', 'myslidelist', 'myfavoriteslidelist');
    else
        $paging_arr = array('pg','start','playlist_title','createby','photos','views','tags','short_by_playlist','action', 'myslidelist', 'myfavoriteslidelist');
	$smartyObj->assign('paging_arr',$paging_arr);
	if($photoslidelist->isResultsFound())
	{
		$photoslidelist->list_playlist_block['showSlidelists'] = $photoslidelist->showSlidelists();
		if($photoslidelist->getFormField('action'))
			$photoslidelist->hidden_array[] = 'action';
		//$photoslidelist->hidden_array[] = 'pg';
		if ($CFG['feature']['rewrite_mode'] != 'normal')
            $paging_arr = array('start','playlist_title','createby','photos','views','tags','short_by_playlist','action', 'myslidelist', 'myfavoriteslidelist');
        else
            $paging_arr = array('pg','start','playlist_title','createby','photos','views','tags','short_by_playlist','action', 'myslidelist', 'myfavoriteslidelist');
		$smartyObj->assign('paging_arr',$paging_arr);
		$smartyObj->assign('smarty_paging_list', $photoslidelist->populatePageLinksPOST($photoslidelist->getFormField('start'), 'seachAdvancedFilter'));
		//$smartyObj->assign('smarty_paging_list', $photoslidelist->populatePageLinksGET($photoslidelist->getFormField('start'), $photoslidelist->hidden_array));
	}
	if ($photoslidelist->getFormField('pg') == 'playlistmostviewed' or $photoslidelist->getFormField('pg') == 'playlistmostdiscussed' or
		$photoslidelist->getFormField('pg') == 'playlistmostfavorite' or $photoslidelist->getFormField('pg') == 'slidelistmostviewed'
	   )
	{
		$photoActionNavigation_arr['photo_list_url_0'] = getUrl('photoslidelist', '?pg='.$photoslidelist->getFormField('pg').'&action=0', $photoslidelist->getFormField('pg').'/?action=0', '', 'photo');
		$photoActionNavigation_arr['photo_list_url_1'] = getUrl('photoslidelist', '?pg='.$photoslidelist->getFormField('pg').'&action=1', $photoslidelist->getFormField('pg').'/?action=1', '', 'photo');
		$photoActionNavigation_arr['photo_list_url_2'] = getUrl('photoslidelist', '?pg='.$photoslidelist->getFormField('pg').'&action=2', $photoslidelist->getFormField('pg').'/?action=2', '', 'photo');
		$photoActionNavigation_arr['photo_list_url_3'] = getUrl('photoslidelist', '?pg='.$photoslidelist->getFormField('pg').'&action=3', $photoslidelist->getFormField('pg').'/?action=3', '', 'photo');
		$photoActionNavigation_arr['photo_list_url_4'] = getUrl('photoslidelist', '?pg='.$photoslidelist->getFormField('pg').'&action=4', $photoslidelist->getFormField('pg').'/?action=4', '', 'photo');
		$photoActionNavigation_arr['photo_list_url_5'] = getUrl('photoslidelist', '?pg='.$photoslidelist->getFormField('pg').'&action=5', $photoslidelist->getFormField('pg').'/?action=5', '', 'photo');
		$photoActionNavigation_arr['cssli_0'] = $photoActionNavigation_arr['cssli_1'] = $photoActionNavigation_arr['cssli_2'] = $photoActionNavigation_arr['cssli_3'] = $photoActionNavigation_arr['cssli_4'] = $photoActionNavigation_arr['cssli_5'] = '';
		if(!$photoslidelist->getFormField('action')) $photoslidelist->setFormField('action', '0');
			$sub_page = 'cssli_'.$photoslidelist->getFormField('action');
			$photoActionNavigation_arr[$sub_page] = ' class="clsActive"';
		$smartyObj->assign('photoActionNavigation_arr', $photoActionNavigation_arr);
	}
}
//include the header file
$photoslidelist->includeHeader();
//include the content of the page
setTemplateFolder('general/','photo');
$smartyObj->display('photoSlidelist.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
?>
<script type="text/javascript" language="javascript">
var form_name_array = new Array('seachAdvancedFilter');
function loadUrl(element)
	{
		document.seachAdvancedFilter.start.value = '0';
		$Jq('#default').val('No');
		document.seachAdvancedFilter.action=element.value;
		document.seachAdvancedFilter.submit();
	}
function clearValue(id)
	{
		if (($Jq('#'+id).val()=='<?php echo $LANG['photoslidelist_slidelist_title']?>') && (id == 'playlist_title') )
			$Jq('#'+id).val('');
		else if (($Jq('#'+id).val()=='<?php echo $LANG['photoslidelist_createby']?>') && (id == 'createby') )
			$Jq('#'+id).val('');
	}
function setOldValue(id)
	{
		if (($Jq('#'+id).val()=="")  && (id == 'playlist_title') )
			$Jq('#'+id).val('<?php echo $LANG['photoslidelist_slidelist_title']?>');
		else if (($Jq('#'+id).val()=="") && (id == 'createby') )
			$Jq('#'+id).val('<?php echo $LANG['photoslidelist_createby']?>');
	}
function shortOrder(short_value)
	{
		document.seachAdvancedFilter.start.value = '0';
		document.seachAdvancedFilter.short_by_playlist.value = short_value;
		document.seachAdvancedFilter.submit();
	}

</script>
<?php
$photoslidelist->includeFooter();
?>
