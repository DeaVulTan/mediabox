<?php
//--------------class photoAlbumList--------------->>>//
/**
* This class is used to photo album list and search page
*
* @category		Rayzz
* @package		manage photo albumlist
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
*/
class photoAlbumList extends photoHandler
{
	public $page_heading = '';
	public $hidden_array = array();
	public $advanceSearch;

	/**
	* photoAlbumList::showAlbumlists()
	*
	* @return
	*/
	public function showAlbumlists()
	{
		$showAlbumlists_arr = array();
		$photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
		$inc=0;
		$showAlbumlists_arr['row'] = array();
		while($row = $this->fetchResultRecord())
		{
			$showAlbumlists_arr[$inc]['light_window_url'] 			  = $this->CFG['site']['photo_url'].'albumList.php?photo_album_id='.$row['photo_album_id'].'&light_window=1';
			$showAlbumlists_arr['row'][$inc]['record'] 				  = $row;
			$showAlbumlists_arr['row'][$inc]['photo_id'] 			  = $row['photo_id'];
			$showAlbumlists_arr['row'][$inc]['user_id'] 			  = $row['user_id'];
			$showAlbumlists_arr['row'][$inc]['photo_title'] 		  = $this->getAlbumLastImageTitle($row['photo_album_id']);
			$showAlbumlists_arr['row'][$inc]['photo_album_id'] 		  = $row['photo_album_id'];
			$showAlbumlists_arr['row'][$inc]['word_wrap_album_title'] = highlightWords($row['photo_album_title'], $this->fields_arr['albumlist_title']);
			$showAlbumlists_arr['row'][$inc]['photo_path'] 			  = $showAlbumlists_arr[$inc]['photo_path'] = $this->CFG['site']['url'].'photo/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/no-playlist.gif';
			$showAlbumlists_arr['row'][$inc]['disp_image']			  = "";
			$showAlbumlists_arr['row'][$inc]['light_window_url'] 	  = $this->CFG['site']['photo_url'].'albumList.php?photo_album_id='.$row['photo_album_id'].'&light_window=1';
																		//getUrl('photolist', '?pg=photonew&cid=' . $row['photo_category_id'], 'photonew/?cid=' . $row['photo_category_id'], '', 'photo');
			$showAlbumlists_arr['row'][$inc]['getUrl_viewAlbum_url']  = getUrl('photolist', '?pg=albumphotolist&album_id='.$row['photo_album_id'], 'albumphotolist/?album_id=' . $row['photo_album_id'], '', 'photo');
			$showAlbumlists_arr['row'][$inc]['view_albumplaylisturl'] = getUrl('flashshow', '?slideshow=al&photo_album_id='.$row['photo_album_id'], 'al/'.$row['photo_album_id'].'/', '','photo');
			//$showAlbumlists_arr['row'][$inc]['getUrl_editAlbum_url']  = getUrl('photoalbummanage', '?photo_album_id='.$row['photo_album_id'], '?photo_album_id='.$row['photo_album_id'], 'members', 'photo');

			$album_image_name=$this->getAlbumImageName($row['photo_album_id'], 'thumb');

			if($row['photo_ext'])
			{
				 $showAlbumlists_arr['row'][$inc]['photo_image_src']  = $this->getAlbumLastImage($row['photo_album_id']);
				 $showAlbumlists_arr['row'][$inc]['photo_disp'] 	  = DISP_IMAGE($this->CFG['admin']['photos']['thumb_width'], $this->CFG['admin']['photos']['thumb_height'], $row['t_width'], $row['t_height']);
			}
			else
			{
				$showAlbumlists_arr['row'][$inc]['photo_image_src'] = '';
				$showAlbumlists_arr['row'][$inc]['photo_disp'] 		= '';
			}

			//get Album Multiple Image
			$showAlbumlists_arr['row'][$inc]['album_image']   = $this->getAlbumMutipleImage($row['photo_album_id']);
			$showAlbumlists_arr['row'][$inc]['total_photo']   = $total_photo  = $this->getAlbumTotalPhoto($row['photo_album_id']);
			$showAlbumlists_arr['row'][$inc]['public_photo']  = $public_photo = $this->getAlbumTotalPhoto($row['photo_album_id'], true);
			$showAlbumlists_arr['row'][$inc]['private_photo'] = $total_photo-$public_photo;
			$inc++;
		}
		return $showAlbumlists_arr;
	}

	/**
	 * photoAlbumList::getAlbumMutipleImage()
	 *
	 * @param string $album_id
	 * @return string
	 */
	public function getAlbumLastImage($album_id = '')
	{
		$albumImagePath = '';
		$photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
		$sql  = 'SELECT photo_id, photo_server_url, photo_ext FROM '.$this->CFG['db']['tbl']['photo'].' AS p, users AS u WHERE photo_album_id = '.
				$this->dbObj->Param('photo_album_id').' AND photo_status= \'Ok\' AND u.user_id = p.user_id AND u.usr_status = \'Ok\' '.
				$this->getAdultQuery('p.', 'photo') .' AND (p.user_id = '.$this->CFG['user']['user_id'].
				' OR photo_access_type = \'Public\') ORDER BY photo_id DESC  LIMIT 0,1 ';
		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt,array($album_id));
		if (!$rs)
			trigger_db_error($this->dbObj);
		if($photoDetail = $rs->FetchRow())
		{
			if($photoDetail['photo_ext'])
				$albumImagePath = $photoDetail['photo_server_url'] . $photos_folder . getPhotoName($photoDetail['photo_id']) .
										$this->CFG['admin']['photos']['thumb_name'] . '.' .$photoDetail['photo_ext'];
		}

		return $albumImagePath;
	}

	/**
	 * photoAlbumList::getAlbumLastImageTitle()
	 *
	 * @param string $album_id
	 * @return string
	 */
	public function getAlbumLastImageTitle($album_id = '')
	{
		$imageTitle = '';
		$sql  = 'SELECT photo_id, photo_title FROM '.$this->CFG['db']['tbl']['photo'].' AS p, users AS u WHERE photo_album_id = '.
				$this->dbObj->Param('photo_album_id'). $this->getAdultQuery('p.', 'photo') .' AND photo_status= \'Ok\' AND u.user_id = p.user_id AND u.usr_status = \'Ok\' ORDER BY photo_id DESC '.
				' LIMIT 0,1 ';
		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt,array($album_id));
		if (!$rs)
			trigger_db_error($this->dbObj);
		if($photoDetail = $rs->FetchRow())
		{
			$imageTitle = $photoDetail['photo_title'];
		}

		return $imageTitle;
	}

	/**
	 * photoAlbumList::getAlbumMutipleImage()
	 *
	 * @param string $album_id
	 * @return string
	 */
	public function getAlbumMutipleImage($album_id = '')
	{
		$albumListImagePath = '';
		$photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
		$sql = 'SELECT count(*) AS total_images FROM '.$this->CFG['db']['tbl']['photo'].' AS p, users AS u WHERE photo_album_id = '.
				$this->dbObj->Param('photo_album_id').' AND photo_status= \'Ok\' AND u.user_id = p.user_id AND u.usr_status = \'Ok\''.
				' AND (p.user_id = '.$this->CFG['user']['user_id']. $this->getAdultQuery('p.', 'photo') .' OR photo_access_type = \'Public\') ORDER BY photo_id DESC ';

		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt,array($album_id));
		if (!$rs)
			trigger_db_error($this->dbObj);
		$count = 0;
		if($recordCount = $rs->FetchRow())
			$count = $recordCount['total_images'];

		$sql  = 'SELECT photo_id, photo_server_url, photo_ext,t_width FROM '.$this->CFG['db']['tbl']['photo'].' AS p, users AS u WHERE photo_album_id = '.
				$this->dbObj->Param('photo_album_id').' AND photo_status= \'Ok\' AND u.user_id = p.user_id AND u.usr_status = \'Ok\''.
				' AND (p.user_id = '.$this->CFG['user']['user_id']. $this->getAdultQuery('p.', 'photo') .' OR photo_access_type = \'Public\') ORDER BY photo_id DESC  LIMIT 0, '.$this->CFG['admin']['photos']['album_image_swap_total_record'];
		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt,array($album_id));
		if (!$rs)
			trigger_db_error($this->dbObj);
		while($photoDetail = $rs->FetchRow())
		{
			if($photoDetail['photo_ext'])
				$albumListImagePath .= $photoDetail['photo_server_url'] . $photos_folder . getPhotoName($photoDetail['photo_id']) .
										$this->CFG['admin']['photos']['thumb_name'] . '.' .$photoDetail['photo_ext'].',';
		}
		if(!empty($albumListImagePath) && ($count > $this->CFG['admin']['photos']['album_image_swap_total_record']))
			$albumListImagePath .= $this->CFG['site']['url'].'photo/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.
									$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/albumMoreImage.jpg'.',';
		$albumListImagePath = !empty($albumListImagePath)?substr($albumListImagePath,0,-1):$albumListImagePath;
		return $albumListImagePath;
	}

	/**
	* photoAlbumList::setTableAndColumns()
	*
	* @return
	*/
	public function setTableAndColumns()
		{
		switch ($this->fields_arr['pg'])
			{
				case 'albummostviewed':
					//Heading
					$this->page_heading = $this->LANG['photoalbumList_heading_mostviewed'];
					//Query
					$this->setTableNames(array($this->CFG['db']['tbl']['photo_album_viewed'] . ' AS val LEFT JOIN ' . $this->CFG['db']['tbl']['photo_album'] .
						   ' AS pa ON val.album_id=pa.photo_album_id, '.$this->CFG['db']['tbl']['photo'].' AS p, '.$this->CFG['db']['tbl']['users'] . ' AS u '));
					$this->setReturnColumns(array('pa.photo_album_id', 'pa.photo_album_title', 'pa.date_added', 'pa.thumb_photo_id as photo_id',
						   'count(p.photo_id) as total_tracks', 'pa.total_album_views as total_views', 'SUM(val.total_views) as sum_total_views',
						   'p.photo_server_url', 'count( p.photo_id ) AS total_photos','p.photo_title','p.t_width','p.t_height','pa.user_id', 'p.photo_ext'));
					$this->sql_condition = 'val.total_views>0 AND val.user_id = u.user_id AND p.photo_status = \'OK\' AND u.usr_status=\'Ok\''.$this->albumlistAdvancedFilters().$this->getMostViewedExtraQuery(). $this->getAdultQuery('p.', 'photo') .' GROUP BY val.photo_album_id';					$this->sql_sort = 'sum_total_views DESC';
				break;

				case 'albummostrecentlyviewed':
					//Heading
					$this->page_heading = $this->LANG['photoalbumList_heading_recently_viewed'];
					//Query
					/*$this->setTableNames(array($this->CFG['db']['tbl']['photo_album'].' AS pa LEFT JOIN '.$this->CFG['db']['tbl']['photo'].
							' AS p ON pa.photo_album_id = p.photo_album_id, '.$this->CFG['db']['tbl']['users'].' AS u '));*/
					$this->setTableNames(array($this->CFG['db']['tbl']['photo_album'].' AS pa,'.$this->CFG['db']['tbl']['photo'].
							' AS p, '.$this->CFG['db']['tbl']['users'].' AS u '));
					$this->setReturnColumns(array('pa.photo_album_id', 'pa.photo_album_title', 'pa.date_added', 'pa.thumb_photo_id as photo_id',
							'count(p.photo_id) as total_tracks', 'pa.total_album_views as total_views', 'p.photo_server_url', 'count( p.photo_id ) AS total_photos',
							'p.photo_title','p.t_width','p.t_height','pa.user_id', 'p.photo_ext'));
					$this->sql_condition = 'p.user_id = u.user_id AND p.photo_status = \'OK\' AND u.usr_status=\'Ok\''.$this->albumlistAdvancedFilters(). $this->getAdultQuery('p.', 'photo') .' GROUP BY pa.photo_album_id';
					$this->sql_sort = 'pa.date_added DESC';
				break;

				case 'myalbums':
				//Heading
				$this->page_heading = $this->LANG['photoalbumList_heading_myalbums'];
				//Query
				/*$this->setTableNames(array($this->CFG['db']['tbl']['photo_album'].' AS pa,'.$this->CFG['db']['tbl']['photo'].
							' AS p, '.$this->CFG['db']['tbl']['users'].' AS u '));*/

				/*$this->setTableNames(array($this->CFG['db']['tbl']['photo_album'].' AS pa LEFT JOIN '.$this->CFG['db']['tbl']['photo'].
							' AS p ON pa.photo_album_id = p.photo_album_id, '.$this->CFG['db']['tbl']['users'].' AS u '));*/
				$this->setTableNames(array($this->CFG['db']['tbl']['photo_album'].' AS pa, '.$this->CFG['db']['tbl']['photo'].
							' AS p, '.$this->CFG['db']['tbl']['users'].' AS u '));
				$this->setReturnColumns(array('pa.photo_album_id', 'pa.photo_album_title', 'pa.date_added', 'pa.thumb_photo_id as photo_id',
							'count(p.photo_id) as total_tracks', 'pa.total_album_views as total_views', 'p.photo_title','p.photo_id','p.photo_server_url',
							'count( p.photo_id ) AS total_photos','p.photo_title','p.t_width','p.t_height','pa.user_id', 'p.photo_ext'));
				$this->sql_condition = 'p.user_id = u.user_id AND pa.user_id='.$this->CFG['user']['user_id'].' AND p.photo_status = \'OK\' AND u.usr_status=\'Ok\''.
				                      $this->albumlistAdvancedFilters(). $this->getAdultQuery('p.', 'photo') .' GROUP BY pa.photo_album_id';
				$this->sql_sort = 'pa.photo_album_id DESC';
				break;

				case 'useralbums':
					//Heading
					$pg_title 	 = $this->LANG['photoalbumList_heading_useralbums'];
	                $fields_list = array('user_name', 'first_name', 'last_name');
	                if (!isset($this->UserDetails[$this->fields_arr['user_id']]))
	                    $this->getUserDetail('user_id', $this->fields_arr['user_id'], 'user_name');
	                $name 	  = getUserDetail('user_id', $this->fields_arr['user_id'], 'user_name');
					$name 	  = '<a href="'.getUrl('viewprofile','?user='.$name, $name.'/').'">'.ucfirst($name).'</a>';
	                $pg_title = str_replace('{user_name}', $name, $pg_title);
					$this->page_heading = $pg_title;
					//Query
					/*$this->setTableNames(array($this->CFG['db']['tbl']['photo_album'].' AS pa LEFT JOIN '.$this->CFG['db']['tbl']['photo'].
								' AS p ON pa.photo_album_id = p.photo_album_id, '.$this->CFG['db']['tbl']['users'].' AS u '));*/
					$this->setTableNames(array($this->CFG['db']['tbl']['photo_album'].' AS pa,'.$this->CFG['db']['tbl']['photo'].
								' AS p, '.$this->CFG['db']['tbl']['users'].' AS u '));
					$this->setReturnColumns(array('pa.photo_album_id', 'pa.photo_album_title', 'pa.date_added', 'pa.thumb_photo_id as photo_id',
								'count(p.photo_id) as total_tracks', 'pa.total_album_views as total_views', 'p.photo_title','p.photo_id','p.photo_server_url',
								'count(p.photo_id) AS total_photos','p.t_width','p.t_height','pa.user_id', 'p.photo_ext'));
					$this->sql_condition = 'p.user_id = u.user_id AND pa.user_id='.$this->fields_arr['user_id'].' AND p.photo_status = \'OK\' AND u.usr_status=\'Ok\''.
								$this->albumlistAdvancedFilters(). $this->getAdultQuery('p.', 'photo') .' GROUP BY pa.photo_album_id';
					$this->sql_sort = 'pa.photo_album_id DESC';
					break;

				default:
					//Heading
					$this->page_heading = $this->LANG['photoalbumList_heading_albumListnew'];
					//Query
					$this->setTableNames(array($this->CFG['db']['tbl']['photo_album'].' AS pa, '.$this->CFG['db']['tbl']['photo'].
							 ' AS p, '.$this->CFG['db']['tbl']['users'].' AS u '));

					/*$this->setTableNames(array($this->CFG['db']['tbl']['photo_album'].' AS pa LEFT JOIN '.$this->CFG['db']['tbl']['photo'].
							 ' AS p ON pa.photo_album_id = p.photo_album_id, '.$this->CFG['db']['tbl']['users'].' AS u '));*/

					$this->setReturnColumns(array('pa.photo_album_id', 'pa.photo_album_title', 'pa.date_added', 'pa.thumb_photo_id as photo_id', 'p.photo_ext',
						  	 'count(p.photo_id) as total_tracks', 'pa.total_album_views as total_views', 'p.photo_title','p.photo_id','p.photo_server_url','count( p.photo_id ) AS total_photos','p.photo_title','p.t_width','p.t_height','pa.user_id'));
					$this->sql_condition = ' p.user_id = u.user_id AND p.photo_status = \'OK\' AND u.usr_status=\'Ok\''.$this->albumlistAdvancedFilters(). $this->getAdultQuery('p.', 'photo') .' GROUP BY pa.photo_album_id';
					$this->sql_sort = 'pa.photo_album_id DESC';
				break;
			}
		}
	/**
	* photoAlbumList::albumlistAdvancedFilters()
	*
	* @return boolean
	*/
	public function albumlistAdvancedFilters()
	{
		$albumlistAdvancedFilters = '';
		$this->advanceSearch = false;
		if ($this->fields_arr['albumlist_title'] != $this->LANG['photoalbumList_albumList_title'] AND $this->fields_arr['albumlist_title'])
		{
			$this->hidden_array[] = 'albumlist_title';
			$albumlistAdvancedFilters .= ' AND pa.photo_album_title LIKE \'%' .validFieldSpecialChr($this->fields_arr['albumlist_title']). '%\' ';
			$this->advanceSearch = true;
		}
		if ($this->fields_arr['photo_title'] != $this->LANG['photoalbumList_no_of_photo_title'] AND $this->fields_arr['photo_title'])
		{
			$this->hidden_array[] = 'photo_title';
			$albumlistAdvancedFilters .= ' AND pa.photo_album_id = p.photo_album_id  AND p.photo_title LIKE \'%' .validFieldSpecialChr($this->fields_arr['photo_title']). '%\' ';
			$this->advanceSearch = true;
		}

		return $albumlistAdvancedFilters;
	}

	/**
	* photoAlbumList::getMostListenedExtraQuery()
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
	* photoAlbumList::getMostListenedExtraQuery()
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
	 * photoAlbumList::displayAlbumPhotoList()
	 *
	 * @param string $album_id
	 * @param mixed  $condition(IF $condition == true then we add additional query)
	 * @param string $limit(Number of photo we need to show)
	 * @return
	 */
	public function displayAlbumPhotoList($album_id='', $condition=false, $limit='')
		{
			global $smartyObj;
			$displayPhotoList_arr = array();

			$sql = 'SELECT p.photo_title,p.photo_id,pa.photo_album_title,pa.photo_album_id,'.
					'p.photo_access_type,pa.album_access_type FROM '.
					$this->CFG['db']['tbl']['photo_album'].' AS pa LEFT JOIN '.$this->CFG['db']['tbl']['photo'].' AS p
					ON pa.photo_album_id=p.photo_album_id, '.$this->CFG['db']['tbl']['users'].' '.
					'AS u WHERE pa.photo_album_id = p.photo_album_id AND u.user_id = p.user_id AND p.photo_status = \'Ok\'
					AND u.usr_status = \'Ok\' AND pa.photo_album_id ='.$album_id;

			if($condition)
				$sql .= ' AND (p.user_id = '.$this->CFG['user']['user_id'].' OR p.photo_access_type = \'Public\''.$this->getAdditionalQuery().') '.$this->getAdultQuery('p.', 'photo');

			$sql .= ' ORDER BY pa.photo_album_id ASC,p.photo_id DESC';

			if($limit!='')
				$sql .= ' LIMIT 0, '.$limit;

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
				trigger_db_error($this->dbObj);

			$displayPhotoList_arr['record_count'] = 0;
			$displayPhotoList_arr['row'] = array();
			$inc = 1;
			while($photoDetail = $rs->FetchRow())
				{
					$displayPhotoList_arr['record_count'] 					= 1;
					$displayPhotoList_arr['row'][$inc]['record'] 		 	= $photoDetail;
					$displayPhotoList_arr['row'][$inc]['photo_album_id'] 	= $photoDetail['photo_album_id'];
					$displayPhotoList_arr['row'][$inc]['photo_id'] 		 	= $photoDetail['photo_id'];
					$displayPhotoList_arr['row'][$inc]['photo_status'] 		= 1;
					$displayPhotoList_arr['row'][$inc]['album_access_type'] = $photoDetail['album_access_type'];

					if(!$condition)
						$displayPhotoList_arr['row'][$inc]['photo_status'] = $this->chkPrivatePhoto($photoDetail['photo_id']);

					$displayPhotoList_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_photo_title'] = highlightWords($photoDetail['photo_title'], $this->getFormField('photo_title'));
					$displayPhotoList_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_album_title'] = $photoDetail['photo_album_title'];
					$displayPhotoList_arr['row'][$inc]['light_window_url']     = $this->CFG['site']['photo_url'].'albumList.php?photo_album_id='.$photoDetail['photo_album_id'].'&light_window=1';
					$displayPhotoList_arr['row'][$inc]['getUrl_viewPhoto_url'] = getUrl('viewphoto', '?photo_id='.$photoDetail['photo_id'].'&title='.$this->changeTitle($photoDetail['photo_title']), $photoDetail['photo_id'].'/'.$this->changeTitle($photoDetail['photo_title']).'/', '', 'photo');
					$inc++;
				}
			$smartyObj->assign('displayPhotoList_arr', $displayPhotoList_arr);
			$smartyObj->assign('lastDiv', $$inc=$inc-1);
			//	return true;
		}

	/**
	 * photoAlbumList::getAlbumTotalPhoto()
	 *
	 * @param mixed $album_id
	 * @param mixed $condition
	 * @return boolean
	 */
	public function getAlbumTotalPhoto($album_id, $condition=false)
		{
			$sql = ' SELECT p.photo_id FROM '.$this->CFG['db']['tbl']['photo_album'].' AS pa LEFT JOIN '.$this->CFG['db']['tbl']['photo'].' AS p
					ON pa.photo_album_id=p.photo_album_id, '. $this->CFG['db']['tbl']['users'].' AS u WHERE pa.photo_album_id = p.photo_album_id AND
					u.user_id = p.user_id AND p.photo_status = \'Ok\'
					AND u.usr_status = \'Ok\' AND pa.photo_album_id ='.$album_id;

			if($condition)
				$sql .= ' AND (p.photo_access_type = \'Public\') '.$this->getAdultQuery('p.', 'photo');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
				trigger_db_error($this->dbObj);

			return $rs->PO_RecordCount();
		}

	/**
	 * photoAlbumList::chkAdvanceResultFound()
	 *
	 * @return boolean
	 */
	public function chkAdvanceResultFound()
		{
			if($this->advanceSearch)
				{
					return true;
				}
			return false;
		}

}
//<<<<<-------------- Class photoAlbumListManage end ---------------//
//-------------------- Code begins -------------->>>>>//
$photoalbumlist = new photoAlbumList();
if(!chkAllowedModule(array('photo')))
Redirect2URL($CFG['redirect']['dsabled_module_url']);
$photoalbumlist->setPageBlockNames(array('filter_select_block', 'search_albumlist_block', 'list_albumlist_block','photolist_block','displayphotolist_block'));
$photoalbumlist->setFormField('start', '0');
//$CFG['photo_tbl']['numpg'] = '2';
$photoalbumlist->setFormField('numpg', $CFG['photo_tbl']['numpg']);
$photoalbumlist->setFormField('albumlist_title', '');
$photoalbumlist->setFormField('user_id', '');
$photoalbumlist->setFormField('photo_title', '');
$photoalbumlist->setFormField('pg', 'albumlistnew');
$photoalbumlist->setFormField('action', '');
$photoalbumlist->setFormField('light_window', '');
$photoalbumlist->setFormField('photo_album_id', '');
$photoalbumlist->setFormField('default', 'Yes');
$photoalbumlist->setTableNames(array());
$photoalbumlist->setReturnColumns(array());
$photoalbumlist->sanitizeFormInputs($_REQUEST);

$photoalbumlist->setPageBlockShow('filter_select_block');
$photoalbumlist->setPageBlockShow('search_albumlist_block');

if($photoalbumlist->getFormField('light_window')!= '')
	{
		$photoalbumlist->setPageBlockShow('photolist_block');
	}
$photoalbumlist->setPageBlockShow('list_albumlist_block');
$photoalbumlist->setPageBlockShow('my_photo_form');
if($photoalbumlist->isFormPOSTed($_POST, 'search'))
	{
		$photoalbumlist->albumlistAdvancedFilters();
	}
if($photoalbumlist->isFormPOSTed($_POST, 'avd_reset'))
	{
		$photoalbumlist->setFormField('albumlist_title', '');
		$photoalbumlist->setFormField('artist', '');
		$photoalbumlist->setFormField('photo_title', '');
	}
if ($photoalbumlist->getFormField('pg'))
	{
		$photoalbumlist->setPageBlockShow('search_albumlist_block');
	}
//-------------------- Page block templates begins -------------------->>>>>//
if ($photoalbumlist->isShowPageBlock('photolist_block'))
	{
		$photoalbumlist->includeHeader();
		$photoalbumlist->sanitizeFormInputs($_REQUEST);
		$photoalbumlist->isShowPageBlock('displayphotolist_block');
		$photoalbumlist->displayAlbumPhotoList($photoalbumlist->getFormField('photo_album_id'));
		setTemplateFolder('general/', 'photo');
		$smartyObj->display('albumPhotoList.tpl');
		$photoalbumlist->includeFooter();
		exit;
	}
if ($photoalbumlist->isShowPageBlock('list_albumlist_block'))
	{
		/****** navigtion continue*********/
		$photoalbumlist->setTableAndColumns();
		$photoalbumlist->buildSelectQuery();
		$photoalbumlist->buildQuery();
		if($photoalbumlist->getFormField('start'))
		$photoalbumlist->homeExecuteQuery();
		//$photoalbumlist->printQuery();
		$group_query_arr = array('albumlistmostviewed','albummostrecentlyviewed','albummostlistened','albummostviewed','albumlistnew', 'useralbums', 'myalbums');
		if (in_array($photoalbumlist->getFormField('pg'), $group_query_arr))
       		$photoalbumlist->homeExecuteQuery();
    	else
			$photoalbumlist->executeQuery();
	//$photoalbumlist->printQuery();
		if($photoalbumlist->isResultsFound())
			{
				$photoalbumlist->list_albumlist_block['showAlbumlists'] = $photoalbumlist->showAlbumlists();
				if($photoalbumlist->getFormField('action'))
					$photoalbumlist->hidden_array[] = 'action';
				if($photoalbumlist->getFormField('user_id'))
					$photoalbumlist->hidden_array[] = 'user_id';
				$smartyObj->assign('smarty_paging_list', $photoalbumlist->populatePageLinksGET($photoalbumlist->getFormField('start'), $photoalbumlist->hidden_array));
			}
		if ($photoalbumlist->getFormField('pg') == 'albummostlistened' or $photoalbumlist->getFormField('pg') == 'albummostviewed')
			{
				$photoActionNavigation_arr['photo_list_url_0'] = getUrl('albumlist', '?pg='.$photoalbumlist->getFormField('pg').'&action=0', $photoalbumlist->getFormField('pg').'/?action=0', '', 'photo');
				$photoActionNavigation_arr['photo_list_url_1'] = getUrl('albumlist', '?pg='.$photoalbumlist->getFormField('pg').'&action=1', $photoalbumlist->getFormField('pg').'/?action=1', '', 'photo');
				$photoActionNavigation_arr['photo_list_url_2'] = getUrl('albumlist', '?pg='.$photoalbumlist->getFormField('pg').'&action=2', $photoalbumlist->getFormField('pg').'/?action=2', '', 'photo');
				$photoActionNavigation_arr['photo_list_url_3'] = getUrl('albumlist', '?pg='.$photoalbumlist->getFormField('pg').'&action=3', $photoalbumlist->getFormField('pg').'/?action=3', '', 'photo');
				$photoActionNavigation_arr['photo_list_url_4'] = getUrl('albumlist', '?pg='.$photoalbumlist->getFormField('pg').'&action=4', $photoalbumlist->getFormField('pg').'/?action=4', '', 'photo');
				$photoActionNavigation_arr['photo_list_url_5'] = getUrl('albumlist', '?pg='.$photoalbumlist->getFormField('pg').'&action=5', $photoalbumlist->getFormField('pg').'/?action=5', '', 'photo');
				$photoActionNavigation_arr['cssli_0'] = $photoActionNavigation_arr['cssli_1'] = $photoActionNavigation_arr['cssli_2'] = $photoActionNavigation_arr['cssli_3'] = $photoActionNavigation_arr['cssli_4'] = $photoActionNavigation_arr['cssli_5'] = '';
				if(!$photoalbumlist->getFormField('action')) $photoalbumlist->setFormField('action', '0');
					$sub_page = 'cssli_'.$photoalbumlist->getFormField('action');
				$photoActionNavigation_arr[$sub_page] = ' class="clsActiveTabNavigation"';
				$smartyObj->assign('photoActionNavigation_arr', $photoActionNavigation_arr);
			}
	}


//include the header file
$photoalbumlist->includeHeader();
//include the content of the page
setTemplateFolder('general/','photo');
$smartyObj->display('albumList.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
?>
<script type="text/javascript" language="javascript">
var form_name_array = new Array('seachAdvancedFilter');
function loadUrl(element)
	{
		document.seachAdvancedFilter.action=element.value;
		document.seachAdvancedFilter.submit();
	}
function clearValue(id)
	{

 	if (($Jq('#'+id).val()=='<?php echo $LANG['photoalbumList_albumList_title']?>') && (id == 'albumlist_title') )
			$Jq('#'+id).val('');
		else if (($Jq('#'+id).val()=='<?php echo $LANG['photoalbumList_no_of_photo_title']?>') && (id == 'photo_title') )
			$Jq('#'+id).val('');


	}
function setOldValue(id)
	{
		if (($Jq('#'+id).val()=="") && (id == 'albumlist_title') )
			$Jq('#'+id).val('<?php echo $LANG['photoalbumList_albumList_title']?>');
		else if (($Jq('#'+id).val()=="") && (id == 'photo_title') )
			$Jq('#'+id).val('<?php echo $LANG['photoalbumList_no_of_photo_title']?>');
	}
</script>
<?php
$photoalbumlist->includeFooter();
?>