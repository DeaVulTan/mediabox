<?php
/**
 * This file is to manage deleted photo
 * This file is having ManageDeleted class to manage deleted photo
 * 1. IF $type is either photo_id or user_id(Delete user or photo)
 * 2.Photo file removePhotoFiles function (chkIsLocalServer or other server)
 * 		# REMOVE THUMBNAILS
 * 		# REMOVE ORIGINAL FILES
 * 3. clearPhotoCommented, clearPhotoFavorited, clearPhotoRated, clearPhotoViewed, resetRelatedPhotoDetails,
 * 	  removePlaylistRelatedEntries, clearPhotoAlbum, clearPhotoListened, deletePhotosTable, sendMailToUserForDelete.
 * 4. removePlaylistRelatedEntries - > clearPlaylistViewed, resetRelatedPlaylistDetails, deletePlaylistTable, clearPlaylistActivity.
 * Modification
 * 	photo activity
 *
 * CronDeletePhotoHandler
 *
 * @package
 * @author karthiselvam_045at09
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id$
 * @access public
 */
class CronDeletePhotoHandler extends CronHandler
{

	public $deletedPhotoIds;
	public $deletedPlaylistIds;
	public $userPhoto = array();
	public $userPlaylist = array();

	/**
	 * CronDeletePhotoHandler::removePhotoRelatedEntries()
	 *
	 * @param integer $id
	 * @param mixed $type
	 * @return
	 */
	public function removePhotoRelatedEntries($id = 0, $type)
	{

		$this->deletedPhotoIds='';
		//CLEAR PHOTO RELATED ENTRIES//
		if($type == 'user_id')//IF PHOTO OWNER//
		{
			$id_equal_to = ' user_id='.$this->dbObj->Param('id');
			$this->updateTable($this->CFG['db']['tbl']['photo'], 'photo_status=\'Deleted\'', $id_equal_to, array($id));
			$sql = 'SELECT photo_id FROM '.$this->CFG['db']['tbl']['photo'].' WHERE user_id='.$this->dbObj->Param('user_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($id));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			while($row = $rs->FetchRow())
			{
				$this->fields_arr['photo_id']=$row['photo_id'];
				//1. CLEAR PHOTO FILES //
				$this->removePhotoFiles($row['photo_id'],$type);
			}
		}
		elseif($type=='photo_id')
		{
			$this->fields_arr['photo_id'] = $id;
			//1. CLEAR PHOTO FILES //
			$this->removePhotoFiles($id,$type);
		}
		//2. CLEAR PHOTO COMMENT //
		$this->clearPhotoCommented($id, $type);
		//3. CLEAR PHOTO FAVORITED //
		$this->clearPhotoFavorited($id, $type);
		//4. CLEAR PHOTO RATED //
		$this->clearPhotoRated($id, $type);
		//5. CLEAR PHOTO VIEW //
		$this->clearPhotoViewed($id, $type);
		//6. RESET PHOTO RELATED //
		$this->resetRelatedPhotoDetails();
		//7. CLEAR PHOTO ALBUM //
		$this->clearPhotoAlbum();
		//8. CLEAR PLAYLIST RELATED TABEL //
		$this->removePlaylistRelatedEntries($id, $type);
		//10. PHOTO ACTIVITY TABEL //
		$this->clearPhotoActivity($id, $type);
		//10. CLEAR PHOTO TABEL //
		$this->deletePhotosTable();
		return true;
	}

	/**
	 * CronDeletePhotoHandler::removePhotoFiles()
	 *
	 * @param mixed $photo_id
	 * @param mixed $type
	 * @return
	 */
	public function removePhotoFiles($photo_id,$type)
	{
		$thumbnail_folder   = '../'.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
		$temp_photo_folder  = '../'.$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin']['photos']['temp_folder'].'/';
		$original_folder    = '../'.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['original_photo_folder'].'/';

		$original_filename = getPhotoName($photo_id);
		$thumb_filename    = $thumbnail_folder.getPhotoName($photo_id);

		if($this->getPhotoDetails())
		{
			$this->populatePhotoDetails();
			$extension = $this->PHOTO_EXT;
			$temp_filename = $temp_photo_folder.getPhotoName($photo_id);

			if($this->chkIsLocalServer())
			{
				# REMOVE THUMBNAILS
				if($this->CFG['admin']['photos']['large_name']=='L')
					$this->removeFiles($thumb_filename.'L.'.$extension);
				if($this->CFG['admin']['photos']['thumb_name']=='T')
					$this->removeFiles($thumb_filename.'T.'.$extension);
				if($this->CFG['admin']['photos']['small_name']=='S')
					$this->removeFiles($thumb_filename.'S.'.$extension);
				if($this->CFG['admin']['photos']['medium_name']=='M')
					$this->removeFiles($thumb_filename.'M.'.$extension);

				if($type=='photo_id')
					$this->sendMailToUserForDelete();
			}
			else
			{
				if($this->getServerDetails())
				{
					if($FtpObj = new FtpHandler($this->fields_arr['ftp_server'],$this->fields_arr['ftp_usrename'],$this->fields_arr['ftp_password']))
					{
						if($this->fields_arr['ftp_folder'])
							$FtpObj->changeDirectory($this->fields_arr['ftp_folder']);

						$thumb_filename = getPhotoName($photo_id);
						$dir_photo = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
						$original_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['original_photo_folder'].'/';

						# REMOVE THUMBNAILS
						if($this->CFG['admin']['photos']['large_name']=='L')
							$FtpObj->deleteFile($dir_photo.$thumb_filename.'L.'.$extension);
						if($this->CFG['admin']['photos']['thumb_name']=='T')
							$FtpObj->deleteFile($dir_photo.$thumb_filename.'T.'.$extension);
						if($this->CFG['admin']['photos']['small_name']=='S')
							$FtpObj->deleteFile($dir_photo.$thumb_filename.'S.'.$extension);
						if($this->CFG['admin']['photos']['medium_name']=='M')
							$this->deleteFile($dir_photo.'M.'.$extension);

						$FtpObj->ftpClose();
						if($type=='photo_id')
							$this->sendMailToUserForDelete();
					}
				}
			}
				$this->deletedPhotoIds.=$photo_id.',';
		}
		return true;
	}

	/**
	 * CronDeletePhotoHandler::getPhotoDetails()
	 *
	 * @return
	 */
	public function getPhotoDetails()
	{
		$sql = 'SELECT photo_ext, user_id, photo_server_url, photo_category_id FROM '.$this->CFG['db']['tbl']['photo'].
				' WHERE photo_id='.$this->dbObj->Param('photo_id').' LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($row = $rs->FetchRow())
		{
			$this->fields_arr['user_id'] 		  = $row['user_id'];
			$this->fields_arr['photo_server_url'] = $row['photo_server_url'];
			$this->PHOTO_EXT 					  = $row['photo_ext'];
			$this->PHOTO_CATEGORY_ID 			  = $row['photo_category_id'];
			return true;
		}
		return false;
	}

	/**
	 * CronDeletePhotoHandler::sendMailToUserForDelete()
	 *
	 * @return
	 */
	public function sendMailToUserForDelete()
	{
		if(isset($this->PHOTO_USER_EMAIL) and $this->PHOTO_USER_EMAIL)
		{
			$subject = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $this->LANG['photo_delete_subject']);
			$body = $this->LANG['photo_delete_content'];
			$body = str_replace('VAR_LINK', '<a href=\''.$this->CFG['site']['url'].'\'>'.$this->CFG['site']['url'].'</a>', $body);
			$body = str_replace('VAR_USER_NAME', $this->PHOTO_USER_NAME, $body);
			$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
			$body = str_replace('VAR_PHOTO_TITLE', $this->PHOTO_TITLE, $body);
			//echo $this->PHOTO_USER_EMAIL;
			$this->_sendMail($this->PHOTO_USER_EMAIL, $subject, nl2br($body), $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);
			return true;
		}
		else
			return true;
	}

	/**
	 * CronDeletePhotoHandler::getServerDetails()
	 *
	 * @return
	 */
	public function getServerDetails()
	{
		$server_url = str_replace($this->CFG['admin']['photos']['folder'].'/','',$this->fields_arr['photo_server_url']);
		$cid = $this->PHOTO_CATEGORY_ID.',0';

		$sql = 'SELECT ftp_server, ftp_folder, ftp_usrename, ftp_password, category FROM'.
				' '.$this->CFG['db']['tbl']['server_settings'].
				' WHERE server_for=\'photo\' AND server_url='.$this->dbObj->Param('server_url').
				' AND category IN('.$cid.') LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($server_url));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if(!$rs->PO_RecordCount())
			return false;

		while($row = $rs->FetchRow())
		{
			$this->fields_arr['ftp_server']   = $row['ftp_server'];
			$this->fields_arr['ftp_folder']   = $row['ftp_folder'];
			$this->fields_arr['ftp_usrename'] = $row['ftp_usrename'];
			$this->fields_arr['ftp_password'] = $row['ftp_password'];

			if($row['category']==$this->PHOTO_CATEGORY_ID)
				return true;
		}
		if(isset($this->fields_arr['ftp_server']) and $this->fields_arr['ftp_server'])
			return true;
		return false;
	}

	/**
	 * CronDeletePhotoHandler::populatePhotoDetails()
	 *
	 * @return
	 */
	public function populatePhotoDetails()
	{
		$this->PHOTO_USER_NAME = '';
		$this->PHOTO_USER_EMAIL = '';
		$this->PHOTO_USER_ID = '';
		$sql = 'SELECT photo_ext, photo_title, photo_category_id, user_id FROM'.
				' '.$this->CFG['db']['tbl']['photo'].' WHERE'.
				' photo_id='.$this->dbObj->Param('photo_id').' LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($row = $rs->FetchRow())
		{
			$this->PHOTO_TITLE       = $row['photo_title'];
			$this->PHOTO_EXT         = $row['photo_ext'];
			$this->PHOTO_CATEGORY_ID = $row['photo_category_id'];
			$sql = 'SELECT user_name, email, user_id FROM '.$this->CFG['db']['tbl']['users'].' WHERE'.
					' user_id='.$this->dbObj->Param('user_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs1 = $this->dbObj->Execute($stmt, array($row['user_id']));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if($row1 = $rs1->FetchRow())
			{
				$this->PHOTO_USER_NAME  = $row1['user_name'];
				$this->PHOTO_USER_EMAIL = $row1['email'];
				$this->PHOTO_USER_ID    = $row1['user_id'];
			}
			return true;
		}
		return false;
	}

	/**
	 * CronDeletePhotoHandler::removeFiles()
	 *
	 * @param mixed $file
	 * @return
	 */
	public function removeFiles($file)
	{
		if(is_file($file))
		{
			unlink($file);
			return true;
		}
		return false;
	}


	/**
	 * CronDeletePhotoHandler::clearPhotoCommented()
	 *
	 * @param integer $id
	 * @param mixed $type
	 * @return
	 */
	public function clearPhotoCommented($id = 0, $type)
	{
		if($type == 'user_id')
		{
			$field = 'photo_id';
			$condition = 'comment_user_id='.$this->dbObj->Param('id');
		}
		elseif($type == 'photo_id')
		{
			$field = 'comment_user_id';
			$condition = 'photo_id='.$this->dbObj->Param('id');
		}
		$sql = 'SELECT photo_comment_id, '.$field.' FROM '.$this->CFG['db']['tbl']['photo_comments'].' WHERE '.$condition;

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if ($rs->PO_RecordCount())
		{
    		while($row = $rs->FetchRow())
		    {
				$this->userPhoto[($type=='photo_id')?$id:$row['photo_id']] = '1';
				$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['photo_comments'], 'photo_comment_id', $row['photo_comment_id']);
		    }
		}
		return true;
	}

	/**
	 * CronDeletePhotoHandler::clearPhotoFavorited()
	 *
	 * @param integer $id
	 * @param mixed $type
	 * @return
	 */
	public function clearPhotoFavorited($id = 0, $type)
	{
		if($type == 'user_id')
		{
			$field = 'photo_id';
			$condition = 'user_id='.$this->dbObj->Param('id');
		}
		elseif($type == 'photo_id')
		{
			$field = 'user_id';
			$condition = 'photo_id='.$this->dbObj->Param('id');
		}
		$sql  = 'SELECT photo_favorite_id, '.$field.' FROM '.$this->CFG['db']['tbl']['photo_favorite'].' WHERE '.$condition;
		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt, array($id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if ($rs->PO_RecordCount())
		{
    		while($row = $rs->FetchRow())
		    {
				$this->userPhoto[($type=='photo_id')?$id:$row['photo_id']] = '1';
				$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['photo_favorite'], 'photo_favorite_id', $row['photo_favorite_id']);
		    } // while
		}
		return true;
	}

	/**
	 * CronDeletePhotoHandler::clearPhotoRated()
	 *
	 * @param integer $id
	 * @param mixed $type
	 * @return
	 */
	public function clearPhotoRated($id = 0, $type)
	{
		if($type == 'user_id')
		{
			$field = 'photo_id';
			$condition = 'user_id='.$this->dbObj->Param('id');
		}
		elseif($type == 'photo_id')
		{
			$field = 'user_id';
			$condition = 'photo_id='.$this->dbObj->Param('id');
		}
		$sql  = 'SELECT photo_id, photo_rating_id, '.$field.' FROM '.$this->CFG['db']['tbl']['photo_rating'].' WHERE '.$condition;
		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt, array($id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if ($rs->PO_RecordCount())
		{
    		while($row = $rs->FetchRow())
		    {
				$this->userPhoto[($type=='photo_id')?$id:$row['photo_id']] = '1';
				$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['photo_rating'], 'photo_rating_id', $row['photo_rating_id']);
		    } // while
		}
		return true;
	}

	/**
	 * CronDeletePhotoHandler::clearPhotoViewed()
	 *
	 * @param integer $id
	 * @param mixed $type
	 * @return
	 */
	public function clearPhotoViewed($id = 0, $type)
	{
		if($type == 'user_id')
		{
			$field = 'photo_id';
			$condition = 'user_id='.$this->dbObj->Param('user_id').
							' OR photo_owner_id='.$this->dbObj->Param('photo_owner_id');
			$value_arr = array($id, $id);
		}
		elseif($type == 'photo_id')
		{
			$field = 'user_id';
			$condition = 'photo_id='.$this->dbObj->Param('photo_id');
			$value_arr = array($id);
		}
		$sql  = 'SELECT photo_viewed_id, '.$field.' FROM '.$this->CFG['db']['tbl']['photo_viewed'].' WHERE '.$condition;
		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt, $value_arr);
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if ($rs->PO_RecordCount())
		{
    		while($row = $rs->FetchRow())
		    {
				$this->userPhoto[($type=='photo_id')?$id:$row['photo_id']] = '1';
				$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['photo_viewed'], 'photo_viewed_id', $row['photo_viewed_id']);
		    } // while
		}
		return true;
	}

	/**
	 * CronDeletePhotoHandler::resetRelatedPhotoDetails()
	 *
	 * @return
	 */
	public function resetRelatedPhotoDetails()
	{
		if ($this->userPhoto)
	    {
			$userPhoto = array_keys($this->userPhoto);
			foreach($userPhoto as $photoId)
			{
				$totalComments 	= $this->getNumRowsForThisSql($this->CFG['db']['tbl']['photo_comments'], 'photo_id='.$this->dbObj->Param($photoId), array($photoId));
				$totalFavorites = $this->getNumRowsForThisSql($this->CFG['db']['tbl']['photo_favorite'], 'photo_id='.$this->dbObj->Param($photoId), array($photoId));
				$totalViews	 	= $this->getNumRowsForThisSql($this->CFG['db']['tbl']['photo_viewed'], 'photo_id='.$this->dbObj->Param($photoId), array($photoId));
				$ratingCount 	= $this->getNumRowsForThisSql($this->CFG['db']['tbl']['photo_rating'], 'photo_id='.$this->dbObj->Param($photoId), array($photoId));
				$ratingTotal	= $this->getTotalRatingForThisPhoto($photoId);
				$sql  = 'UPDATE '.$this->CFG['db']['tbl']['photo'].
						' SET '.
						' total_comments='.$this->dbObj->Param($totalComments).','.
						' total_favorites='.$this->dbObj->Param($totalFavorites).','.
						' total_views='.$this->dbObj->Param($totalViews).','.
						' rating_count='.$this->dbObj->Param($ratingCount).','.
						' rating_total='.$this->dbObj->Param($ratingTotal).
						' WHERE photo_id='.$this->dbObj->Param($photoId);

				$stmt = $this->dbObj->Prepare($sql);
				$rs   = $this->dbObj->Execute($stmt, array($totalComments, $totalFavorites, $totalViews, $ratingCount, $ratingTotal, $photoId));
				if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		    }
		}
	}

	/**
	 * CronDeletePhotoHandler::clearPhotoAlbum()
	 *
	 * @return
	 */
	public function clearPhotoAlbum()
	{
		$sql  = 'SELECT DISTINCT(pa.photo_album_id) FROM photo AS p JOIN photo_album AS pa ON p.photo_album_id = pa.photo_album_id '.
				'WHERE photo_status = \'Deleted\' AND pa.photo_album_id !=1 AND pa.photo_album_id NOT IN '.
				'(SELECT photo_album_id FROM photo WHERE photo_status != \'Deleted\')';
		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt);
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if ($rs->PO_RecordCount())
		{
    		while($row = $rs->FetchRow())
		    {
				$sql       = 'DELETE FROM '.$this->CFG['db']['tbl']['photo_album'].' WHERE photo_album_id IN ('.photo_album_id.')';
				$stmt      = $this->dbObj->Prepare($sql);
				$resultSet = $this->dbObj->Execute($stmt, array($row['photo_album_id']));
			    if (!$resultSet)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		    }
		}
	}

	/**
	 * CronDeletePhotoHandler::deletePhotosTable()
	 *
	 * @return
	 */
	public function deletePhotosTable()
	{
		$photo_id = $this->deletedPhotoIds;
		$photoId_arr = explode(',',$photo_id);
		$photoId_arr = array_filter($photoId_arr);
		$photo_id = implode(',',$photoId_arr);
		if($photo_id)
		{
			$tablename_arr = array('photo');
			for($i=0;$i<sizeof($tablename_arr);$i++)
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl'][$tablename_arr[$i]].' WHERE photo_id IN ('.$photo_id.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}
		}
	}

	/**
	 * CronDeletePhotoHandler::getTotalRatingForThisPhoto()
	 *
	 * @param integer $photo_id
	 * @return
	 */
	public function getTotalRatingForThisPhoto($photo_id = 0)
	{
		$ratingTotal = 0;
		$sql = 'SELECT SUM(rate) AS rating_total '.
				'FROM '.$this->CFG['db']['tbl']['photo_rating'].
				' WHERE photo_id='.$this->dbObj->Param($photo_id);

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($photo_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if ($rs->PO_RecordCount())
		{
			$row = $rs->FetchRow();
			$ratingTotal = $row['rating_total'];
	    }
		return $ratingTotal?$ratingTotal:0;
	}

	/**
	 * CronDeletePhotoHandler::chkIsLocalServer()
	 *
	 * @return
	 */
	public function chkIsLocalServer()
	{
		$server_url = $this->fields_arr['photo_server_url'];
		if(strstr($server_url,$this->CFG['site']['url']))
		{
			$server_url = str_replace($this->CFG['site']['url'],'',$server_url);
			if(trim($server_url)=='')
			{
				return true;
			}
		}
		return false;
	}

	/**
	 * CronDeletePhotoHandler::removePlaylistRelatedEntries()
	 *
	 * @param mixed $id
	 * @param mixed $type
	 * @return
	 */
	public function removePlaylistRelatedEntries($id = 0, $type)
	{

		if($type == 'playlist_id')
		{
			//Later//
		}
		elseif($type == 'user_id')
		{
			$this->deletedPlaylistIds='';
			$condition = 'created_by_user_id='.$this->dbObj->Param('user_id');
			$sql  = 'SELECT photo_playlist_id '.'FROM '.$this->CFG['db']['tbl']['photo_playlist'].' '.'WHERE '.$condition;
			$stmt = $this->dbObj->Prepare($sql);
			$rs   = $this->dbObj->Execute($stmt, array($id));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if ($rs->PO_RecordCount())
			{
				# DELETE VIEW
				$this->clearPlaylistViewed($id, $type);
				# UPDATE PLAYLIST RELATED TABEL
				$this->resetRelatedPlaylistDetails();
				# CLEAR PLAYLIST ACTIVITY
				$this->clearPlaylistActivity($id = 0, $type);
				while($row = $rs->FetchRow())
				{
					$this->deletedPlaylistIds.=$row['playlist_id'].',';
				}
				# DELETED PLAYLIST TABEL
				$this->deletePlaylistTable();
			}
		}
		elseif($type == 'photo_id')
		{
			# UPDATE PLAYLIST TABEL
			$sql  = 'SELECT photo_in_playlist_id, photo_playlist_id, order_id FROM '.$this->CFG['db']['tbl']['photo_in_playlist'].' '.
					'WHERE photo_id = '.$this->dbObj->Param('photo_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs   = $this->dbObj->Execute($stmt, array($id));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			while($row = $rs->FetchRow())
			{
				# REORDER PLAYLIST PHOTO(LATER)
				$playlist_id = $row['photo_playlist_id'];
				$set_fields  = 'total_photos = total_photos - 1';
				$condition   = 'photo_playlist_id = '.$this->dbObj->Param('photo_playlist_id');
				$this->updateTable($this->CFG['db']['tbl']['photo_playlist'],$set_fields , $condition, array($playlist_id));
			}
			# DELETE PHOTO IN PHOTO PLAYLIST TABEL
			$condition = 'photo_id = '.$this->dbObj->Param('photo_id');
			$this->deleteFromTable($this->CFG['db']['tbl']['photo_in_playlist'], $condition, array($id));
		}
		return true;
	}

	/**
	 * CronDeletePhotoHandler::clearPlaylistViewed()
	 *
	 * @param integer $id
	 * @param mixed $type
	 * @return
	 */
	public function clearPlaylistViewed($id = 0, $type)
	{
		if($type == 'user_id')
		{
			$field 	   = 'photo_playlist_id';
			$condition = 'user_id='.$this->dbObj->Param('user_id').' OR playlist_owner_id='.$this->dbObj->Param('playlist_owner_id');
			$value_arr = array($id, $id);
		}
		elseif($type == 'photo_id')
		{
			$field 	   = 'user_id';
			$condition = 'photo_playlist_id='.$this->dbObj->Param('playlist_id');
			$value_arr = array($id);
		}
		$sql  = 'SELECT photo_playlist_viewed_id, '.$field.' FROM '.$this->CFG['db']['tbl']['photo_playlist_viewed'].
				' WHERE '.$condition;
		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt, $value_arr);
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if ($rs->PO_RecordCount())
		{
    		while($row = $rs->FetchRow())
		    {
				$this->userPlaylist[($type=='playlist_id')?$id:$row['photo_playlist_id']] = '1';
				$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['photo_playlist_viewed'], 'photo_playlist_viewed_id', $row['photo_playlist_viewed_id']);
		    } // while
		}
		return true;
	}

	/**
	 * CronDeletePhotoHandler::resetRelatedPlaylistDetails()
	 *
	 * @return
	 */
	public function resetRelatedPlaylistDetails()
	{
		if ($this->userPlaylist)
	    {
			$userPlaylist = array_keys($this->userPlaylist);
			foreach($userPlaylist as $playlistId)
			{
		       	$totalViews	 	= $this->getNumRowsForThisSql($this->CFG['db']['tbl']['photo_playlist_viewed'], 'photo_id='.$this->dbObj->Param($playlistId), array($playlistId));
				$sql  =	'UPDATE '.$this->CFG['db']['tbl']['photo_playlist_viewed'].
						' SET '.
						' total_views='.$this->dbObj->Param($totalViews).
						' WHERE photo_id='.$this->dbObj->Param($photoId);

				$stmt = $this->dbObj->Prepare($sql);
				$rs   = $this->dbObj->Execute($stmt, array($totalComments, $totalFavorites, $totalViews, $ratingCount, $ratingTotal, $photoId));
				if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		    }
		}
	}

	/**
	 * CronDeletePhotoHandler::clearPlaylistActivity()
	 *
	 * @param integer $id
	 * @param mixed $type
	 * @return
	 */
	public function clearPlaylistActivity($id = 0, $type)
	{
		if($type == 'user_id')
		{
			$sql  = 'DELETE FROM '.$this->CFG['db']['tbl']['photo_activity'].' WHERE actor_id='.$this->dbObj->Param('actor_id').
				    ' OR owner_id='.$this->dbObj->Param('owner_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs   = $this->dbObj->Execute($stmt, array($id, $id));
		    if (!$rs)
			    trigger_db_error($this->dbObj);
		}
		elseif($type == 'photo_id')
		{
			$action_key = array('playlist_create');
			$photoplaylistids = substr($this->deletedPlaylistIds,0,-1);
			for($inc=0;$inc<count($action_key);$inc++)
			{
				$condition = '  content_id IN ('.$photoplaylistids.') AND action_key = \''.$action_key[$inc].'\'';
				$sql  = 'DELETE FROM '.$this->CFG['db']['tbl']['photo_activity'].' WHERE '.$condition;
				$stmt = $this->dbObj->Prepare($sql);
				$rs   = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);
			}
		}
		return true;
	}

	/**
	 * CronDeletePhotoHandler::deletePlaylistTable()
	 *
	 * @return
	 */
	public function deletePlaylistTable()
	{
		$playlist_id    = $this->deletedPlaylistIds;
		$playlistId_arr = explode(',',$playlist_id);
		$playlistId_arr = array_filter($playlistId_arr);
		$playlist_id    = implode(',',$playlistId_arr);
		if($playlist_id)
		{
			$tablename_arr = array('photo_playlist');
			for($i=0;$i<sizeof($tablename_arr);$i++)
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl'][$tablename_arr[$i]].
						' WHERE playlist_id IN ('.$photo_id.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}
		}
	}

	/**
	 * CronDeletePhotoHandler::clearPhotoActivity()
	 *
	 * @param integer $id
	 * @param mixed $type
	 * @return
	 */
	public function clearPhotoActivity($id = 0, $type)
	{
		if($type == 'user_id')
		{
			$sql  = 'DELETE FROM '.$this->CFG['db']['tbl']['photo_activity'].' WHERE actor_id='.$this->dbObj->Param('actor_id').
					' OR owner_id='.$this->dbObj->Param('owner_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs   = $this->dbObj->Execute($stmt, array($id, $id));
		    if (!$rs)
			    trigger_db_error($this->dbObj);
		}
		elseif($type == 'photo_id')
		{
			$action_key = array('photo_uploaded', 'photo_comment', 'photo_rated', 'photo_favorite', 'photo_featured', 'photo_share');
			$photo_ids = substr($this->deletedPhotoIds,0,-1);
			for($inc=0;$inc<count($action_key);$inc++)
			{
				//$condition = ' SUBSTRING(action_value, 1, 1 ) IN ('.substr($this->deletedPhotoIds,0,-1).') AND action_key = \''.$action_key[$inc].'\'';
				$condition = '  content_id IN ('.$photo_ids.') AND action_key = \''.$action_key[$inc].'\'';
				$sql  = 'DELETE FROM '.$this->CFG['db']['tbl']['photo_activity'].' WHERE '.$condition;
				$stmt = $this->dbObj->Prepare($sql);
				$rs   = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);
			}
		}
		return true;
	}
}
?>