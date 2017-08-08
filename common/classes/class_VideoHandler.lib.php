<?php

/**
 * videoHandler
 *
 * @package Video
 * @author vijay_84ag08
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version 3.0
 * @access public
 */
class VideoHandler extends MediaHandler {

	public $_navigationArr = array();
	public $_clsActiveLink = ' clsActive';
	public $_clsInActiveLink = ' clsInActive';
	public $_currentPage = '';



	/**
	 * videoHandler::chkIsFeaturedVideo()
	 *
	 * @param purpose $ Checking the given video Id is a featured video or not
	 * @param array $video_id_arr
	 * @param mixed $user_id
	 * @return true or false
	 */
	public function chkIsFeaturedVideo($video_id_arr = array(), $user_id)
	 {
		$video_id = implode(',', $video_id_arr);
		$sql   = 'SELECT user_id FROM ' . $this->CFG['db']['tbl']['users'] . ' WHERE user_id=' . $this->dbObj->Param('user_id') . ' AND' . ' icon_type=\'Video\' AND icon_id IN(' . $video_id . ') LIMIT 0,1';
		$stmt  = $this->dbObj->Prepare($sql);
		$rs    = $this->dbObj->Execute($stmt, array($user_id));
		 if (!$rs)
						trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);
		if ($row     = $rs->FetchRow())
		 return true;
		return false;
	}
	/**
	 * videoHandler::getNewFeaturedVideo()
	 *
	 * @param purpose $ getting New Featured Video
	 * @param mixed $user_id
	 * @return $row['video_id']
	 */
	// Commented this method due to This will not fetch the get new featured video
	/*public function getNewFeaturedVideo($user_id)
	{
		$sql = 'SELECT MAX(video_id) as video_id FROM '.$this->CFG['db']['tbl']['video'].
				' WHERE user_id='.$this->dbObj->Param('user_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($user_id));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($row = $rs->FetchRow())
			return $row['video_id'];
		return 0;
	}*/


	public function deleteVideoTag($video_id)
	{
		// DELETE TAGS
				$sql='SELECT video_tags FROM '.$this->CFG['db']['tbl']['video'].
					 ' WHERE video_id IN('.$video_id.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				while($tag_row = $rs->FetchRow())
		    	{

		    		$tag=explode(' ',$tag_row['video_tags']);
		    		for($i=0;$i<count($tag);$i++)
					{
						 $sql='SELECT video_id FROM '.$this->CFG['db']['tbl']['video'].
								 	  ' WHERE concat( \' \', video_tags, \' \' ) LIKE "% '.$tag[$i].' %" AND video_id NOT IN('.$video_id.')'.' AND video_status!=\'Deleted\'';
						 $stmt = $this->dbObj->Prepare($sql);
					     $rs_tag = $this->dbObj->Execute($stmt);
						 if (!$rs_tag)
							    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
						 if(!$row = $rs_tag->FetchRow())
						 {
						 	$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['tags_video'].
							' WHERE tag_name=\''.$tag[$i].'\'';
							$stmt = $this->dbObj->Prepare($sql);
							$rs_delete = $this->dbObj->Execute($stmt);
							    if (!$rs_delete)
								    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
						 }
					 }
				}
		// DELETE TAG END
	}
	/**
	 * videoHandler::deleteVideos()
	 *
	 * @param purpose $ To delete the selected videos
	 * @param array $video_id_arr
	 * @param mixed $user_id
	 * @return
	 */
	public function deleteVideos($video_id_arr = array(), $user_id)
	{

		$video_id	= implode(',',$video_id_arr);
		$this->deleteVideoTag($video_id);

		$sql        = 'UPDATE '.$this->CFG['db']['tbl']['video'].' SET video_status=\'Deleted\'' . ' WHERE video_id IN(' . $video_id . ')' ;
		$stmt     = $this->dbObj->Prepare($sql);
		$rs       = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);
		if($affected_rows = $this->dbObj->Affected_Rows())
		 {
				$sql= 'SELECT count(video_encoded_status) AS count FROM  '.$this->CFG['db']['tbl']['video'].
				 ' WHERE video_id IN(' . $video_id . ') AND video_encoded_status=\'Yes\'';
				$stmt   = $this->dbObj->Prepare($sql);
				$rs     = $this->dbObj->Execute($stmt);
				 if (!$rs)
								trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);
				if($row = $rs->FetchRow())
				 {
					$count = $row['count'];
				 }
				$sql= 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET'.
					' total_videos=total_videos-' . $count . ' WHERE user_id=' . $this->dbObj->Param('user_id').' AND total_videos>0';
				$stmt   = $this->dbObj->Prepare($sql);
				$rs     = $this->dbObj->Execute($stmt, array($user_id));
				 if (!$rs)
								trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);
				// *********Delete records from Video related tables start*****
				$tablename_arr = array('video_comments', 'video_favorite', 'video_viewed', 'video_rating');
				for($i=0;$i<sizeof($tablename_arr);$i++)
				 {
								$sql  = 'DELETE FROM '.$this->CFG['db']['tbl'][$tablename_arr[$i]].
								 ' WHERE video_id IN(' . $video_id . ')';
								$stmt = $this->dbObj->Prepare($sql);
								$rs   = $this->dbObj->Execute($stmt);
								 if (!$rs)
									trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);
				}
				// DELETE FLAGGED CONTENTS
				$sql = 'DELETE FROM ' . $this->CFG['db']['tbl']['flagged_contents'] . ' WHERE content_type=\'Video\' AND content_id IN(' . $video_id . ')';
				$stmt   = $this->dbObj->Prepare($sql);
				$rs     = $this->dbObj->Execute($stmt);
				 if (!$rs)
								trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);
				// **********End************
				if ($this->chkIsFeaturedVideo($video_id_arr, $user_id)) {
					$new_video= $this->getNewFeaturedVideo($user_id);
					 $this->setFeatureThisImage($new_video, $user_id);
				}
		}

		return true;
	}

	/**
	 * videoHandler::getVideoDetails()
	 *
	 * @param purpose $ To video details of the particular video. Supplied fields will selected & return.
	 * @param array $video_field_arr
	 * @param mixed $video_id
	 * @param integer $user_id
	 * @return
	 */
	public function getVideoDetails($video_field_arr = array(), $video_id, $user_id=0)
	 {
		$video_field = implode(',', $video_field_arr);
		$additional = '';
		 if ($user_id) {
						$additional = ' AND user_id='.$user_id;
						 }
		$sql = 'SELECT '.$video_field.' FROM '.$this->CFG['db']['tbl']['video'].
		 ' WHERE video_id=' . $this->dbObj->Param('video_id') . ' AND' . ' video_status=\'Ok\'' . $additional . ' LIMIT 0,1';
		$stmt     = $this->dbObj->Prepare($sql);
		$rs       = $this->dbObj->Execute($stmt, array($video_id));
		 if (!$rs)
			trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);
		if($row = $rs->FetchRow())
		 {
			$this->video_details = $row;
			 return $this->video_details;
		}
		return false;
	}

		/**
		 * videoHandler::deleteFavoriteVideo()
		 *
		 * @param purpose $ To delete the selected favorite video of the particular user
		 * @param mixed $video_id
		 * @param mixed $user_id
		 * @return
		 */
		public function deleteFavoriteVideo($video_id, $user_id)
			{
				//Srart delete video favorite Video activity..
				$sql = 'SELECT vf.video_favorite_id, vf.user_id as favorite_user_id, v.user_id '.
						' FROM '.$this->CFG['db']['tbl']['video_favorite'].' as vf, '.$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['video'].' as v '.
						' WHERE u.user_id = vf.user_id AND vf.video_id = v.video_id AND vf.user_id = '.$this->dbObj->Param('user_id').' AND vf.video_id = '.$this->dbObj->Param('video_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id, $video_id));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$row = $rs->FetchRow();
				$activity_arr = $row;
				$activity_arr['action_key']	= 'delete_video_favorite';
				$videoActivityObj = new VideoActivityHandler();
				$videoActivityObj->addActivity($activity_arr);
				//end

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['video_favorite'].' WHERE'.
						' user_id=' . $this->dbObj->Param('user_id') . ' AND' . ' video_id=' . $this->dbObj->Param('video_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id, $video_id));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($this->dbObj->Affected_Rows())
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].' SET total_favorites = total_favorites-1'.
					 			' WHERE video_id=' . $this->dbObj->Param('video_id');

						$stmt   = $this->dbObj->Prepare($sql);
						$rs     = $this->dbObj->Execute($stmt, array($video_id));
						if (!$rs)
							trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);
					}
			}

		/**
		 * videoHandler::populateVideo()
		 *
		 * @param purpose $ To populate the video thumbnail with title
		 * @param mixed $video_id
		 * @return
		 */
		public function populateVideo($video_id)
		{
			$thumbnail_folder  = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
			$return            =array();
			$sql = 'SELECT video_title, video_server_url, t_width, t_height' . ' FROM ' . $this->CFG['db']['tbl']['video'] .
			 ' WHERE' . ' video_id=' . $this->dbObj->Param('video_id') . ' AND video_status=\'Ok\' LIMIT 0,1';
			$stmt     = $this->dbObj->Prepare($sql);
			$rs       = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
			 if (!$rs)
							trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);
			if($row = $rs->FetchRow())
			 {
				$return['thumb_path']=$row['video_server_url'].$thumbnail_folder.getVideoImageName($this->fields_arr['video_id']).$this->CFG['admin']['videos']['thumb_name'].'.'.$this->CFG['video']['image']['extensions'];
				$return['video_title']=$row['video_title'];
				$return['disp_image']=DISP_IMAGE($this->CFG['admin']['videos']['thumb_width'], $this->CFG['admin']['videos']['thumb_height'], $row['t_width'], $row['t_height']);
				 return $return;
			}
			return false;
		}

		/**
		 * videoHandler::getTotalVideo()
		 *
		 * @param purpose $ To get total video of the particular user id
		 * @param mixed $user_id
		 * @return
		 */
		public function getTotalVideo($user_id)
		{
			$sql    = 'SELECT count(1) as count FROM '.$this->CFG['db']['tbl']['video'].
			 ' WHERE user_id=' . $this->dbObj->Param('user_id') . ' AND video_status=\'Ok\'';
			$stmt     = $this->dbObj->Prepare($sql);
			$rs      = $this->dbObj->Execute($stmt, array($user_id));
			 if (!$rs)
				trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);
			$row  = $rs->FetchRow();
			 return $row['count'];
		}

		public function getPlaylistName()
	{
		$sql ='SELECT playlist_name FROM '.$this->CFG['db']['tbl']['video_playlist'].' WHERE playlist_id='.$this->dbObj->Param('playlist_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
		if (!$rs)
		trigger_db_error($this->dbObj);
		if($rs->PO_RecordCount())
		{
			$row = $rs->FetchRow();
			return $row['playlist_name'];
		}
	}

	/**
	 * videoHandler::deletePlaylistVideo()
	 *
	 * @param mixed $video_id
	 * @return
	 */
	public function deletePlaylistVideo($video_id)
		{
			//Select delete video is the thumbnail of the play list or not..
			$sql ='SELECT playlist_id FROM '.$this->CFG['db']['tbl']['video_playlist'].' WHERE thumb_video_id='.$this->dbObj->Param('video_id').'AND playlist_id='.$this->dbObj->Param('playlist_id') ;

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($video_id, $this->fields_arr['playlist_id']));
			if (!$rs)
				trigger_db_error($this->dbObj);

			$row = $rs->FetchRow();
			$nofiy_msg = 1;
			if($row['playlist_id'])
				{
					$nofiy_msg = 2;
					//Select next maximum order of the video play list..
					$sql = 'SELECT v.video_id '.
							'FROM '.$this->CFG['db']['tbl']['video_in_playlist'].' as v, '.$this->CFG['db']['tbl']['video_playlist'].' as vp '.
							'WHERE v.video_id !='.$this->dbObj->Param('video_id').' '.
							'AND vp.playlist_id = v.playlist_id AND vp.playlist_id ='.$this->dbObj->Param('playlist_id').' '.
							'ORDER BY order_id DESC LIMIT 0 , 1';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($video_id, $this->fields_arr['playlist_id']));
					if (!$rs)
						trigger_db_error($this->dbObj);

					$rowSet = $rs->FetchRow();
					//Set new thumbnail image for playlist
					$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_playlist'].' set thumb_video_id = '.$this->dbObj->Param('video_id').' WHERE playlist_id = '.$this->dbObj->Param('playlist_id').'';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($rowSet['video_id'], $this->fields_arr['playlist_id']));
					if (!$rs)
						trigger_db_error($this->dbObj);
				}

			$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['video_in_playlist'].' WHERE video_id='.$this->dbObj->Param('video_id').' AND playlist_id='.$this->dbObj->Param('playlist_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($video_id, $this->fields_arr['playlist_id']));
			if (!$rs)
				trigger_db_error($this->dbObj);

			if($this->dbObj->Affected_Rows())
				{
					$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_playlist'].' SET total_videos=total_videos-1 WHERE playlist_id='.$this->dbObj->Param('playlist_id');

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist_id']));
					if (!$rs)
						trigger_db_error($this->dbObj);
				}
		}

	public function setPlaylistThumbnail($video_id)
		{
			if($this->fields_arr['playlist_id'])
				{
					$sql ='SELECT video_ext FROM '.$this->CFG['db']['tbl']['video'].' WHERE video_id='.$this->dbObj->Param('video_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($video_id));
						if (!$rs)
							trigger_db_error($this->dbObj);

					$row = $rs->FetchRow();
					$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_playlist'].' SET thumb_video_id='.$this->dbObj->Param('thumb_video_id').', thumb_ext='.$this->dbObj->Param('thumb_ext'). ' WHERE playlist_id='.$this->dbObj->Param('playlist_id');

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($video_id,$row['video_ext'],$this->fields_arr['playlist_id']));
					if (!$rs)
						trigger_db_error($this->dbObj);
				}

		}
	public function updateAlbumProfileImage($video_id,$ablum_id)
	{
		$sql ='SELECT s_width,s_height,video_server_url FROM '.$this->CFG['db']['tbl']['video'].' WHERE video_status=\'Ok\' AND video_id ='.$this->dbObj->Param('video_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($video_id));
		if($row = $rs->FetchRow())
		{

		$sql='Update '.$this->CFG['db']['tbl']['video_album'].' SET video_id='.$this->dbObj->Param('video_id').',s_width='.$this->dbObj->Param('s_width').',s_height='.$this->dbObj->Param('s_height').',video_server_url='.$this->dbObj->Param('video_server_url').' WHERE video_album_id='.$this->dbObj->Param('video_album_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($video_id,$row['s_width'],$row['s_height'],$row['video_server_url'],$ablum_id));
		if (!$rs)
		trigger_db_error($this->dbObj);
		}

	}
	public function selectFeatured($condition,$value,$returnType='')
	{
		$sql = 'SELECT video_featured_id FROM '.$this->CFG['db']['tbl']['video_featured'].
					' WHERE '.$condition;
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, $value);
		if (!$rs)
			trigger_db_error($this->dbObj);
		if(!$returnType)
			return $rs->PO_RecordCount();
		else
			return $rs;
	}



		public function deleteFromFeatured($displayMsg)
			{
				//Srart delete video featured Video activity..
				$sql = 'SELECT vf.video_featured_id, vf.user_id as featured_user_id, v.user_id '.
						' FROM '.$this->CFG['db']['tbl']['video_featured'].' as vf, '.$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['video'].' as v '.
						' WHERE u.user_id = vf.user_id AND vf.video_id = v.video_id AND vf.user_id = '.$this->dbObj->Param('user_id').' AND vf.video_id = '.$this->dbObj->Param('video_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['video_id']));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$row = $rs->FetchRow();
				if(!empty($row))
					{
						$activity_arr = $row;
						$activity_arr['action_key']	= 'delete_video_featured';
						$videoActivityObj = new VideoActivityHandler();
						$videoActivityObj->addActivity($activity_arr);
					}
				//end
				$sql ='DELETE FROM '.$this->CFG['db']['tbl']['video_featured'].' WHERE user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				if($this->dbObj->Affected_Rows())
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].' SET total_featured = total_featured-1'.
								' WHERE video_id='.$this->dbObj->Param('video_id');
						$stmt = $this->dbObj->Prepare($sql);

						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
						if (!$rs)
							trigger_db_error($this->dbObj);

						if($displayMsg)
						echo $this->LANG['viewvideo_featured_deleted_successfully'];
					}
			}

		public function chkVideoFeaturedAlreadyAdded()
		{
			$sql = 'SELECT * FROM '. $this->CFG['db']['tbl']['video_featured'].' WHERE user_id='.$this->dbObj->Param('user_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
			if (!$rs)
			trigger_db_error($this->dbObj);
			if($rs->PO_RecordCount())
			{
				return true;
			}
			return false;
		}

		public function getOtherFormatTotalDownload($video_type='flv',$video_id=0)
		{
			$sql = ' SELECT count(video_id) count FROM '.$this->CFG['db']['tbl']['video_other_format_downloads'].' WHERE video_id=\''.$video_id.'\' AND video_type=\''.$video_type.'\' ';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			$row = $rs->FetchRow();
			return $row['count'];
		}

		public function incrementOtherFormatTotalDownload($video_type,$video_id=0)
			{

				if($this->getOtherFormatTotalDownload($video_type,$video_id))
					$sql=' UPDATE '.$this->CFG['db']['tbl']['video_other_format_downloads'].' SET total_downloads=total_downloads+1 '.
						 ' WHERE video_id=\''.$video_id.'\' AND video_type=\''.$video_type.'\' ';
					else
						$sql=' INSERT INTO '.$this->CFG['db']['tbl']['video_other_format_downloads'].' SET total_downloads=1, video_id=\''.$video_id.'\', video_type=\''.$video_type.'\' ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}

	/**
	 * videoHandler::chkIsUserHasRights()
	 *
	 * @return
	 */


	public function chkIsUserHasRights($user_id)
	{
		$sql='SELECT background_ext, background_offset FROM '.
				$this->CFG['db']['tbl']['users'].
				' WHERE user_id='.$this->dbObj->Param('user_id').
				' AND is_upload_background_image=\'Yes\'';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($user_id));
		if (!$rs)
			trigger_db_error($this->dbObj);
		if($rs->PO_RecordCount())
		{
			$row = $rs->FetchRow();
			$this->background_ext=$row['background_ext'];
			$this->background_offset=$row['background_offset'];
			return true;
		}
		else
			return false;
	}


	/**
	 * videoHandler::getUploadedBackground()
	 *
	 * @return
	 */
	public function getUploadedBackground($user_id)
	{
		$this->image_width = '';
		$this->background_folder = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['background_image_folder'].'/';
		$this->background_path=$this->background_folder.getVideoImageName($user_id).'.'.$this->background_ext;
		if(file_exists($this->background_path))
		{
			//To Get width of the image
			$image_size = @getimagesize($this->background_path);
			if(isset($image_size[0]) && !empty($image_size[0]))
				$this->image_width = $image_size[0];
			$this->setPageBlockShow('block_image_display');
			$this->background_path.='?'.time();
		}
		else
		{
			$this->background_path='';
		}
	}


	/**
	 * VideoHandler::chkIsAvailVideoFormat()
	 *
	 * @param string $video_type
	 * @param integer $video_id
	 * @return
	 */
	public function chkIsAvailVideoFormat($video_type='flv',$video_id=0)
			{
				$this->sql_condition = 'v.video_status=\'Ok\' AND v.video_encoded_status=\'Yes\' AND v.video_id=\''.addslashes($this->fields_arr['video_id']).'\' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR v.video_access_type = \'Public\''.$this->getAdditionalQuery('v.').')';

				$sql = 'SELECT v.video_ext, v.video_available_formats, v.video_server_url, v.video_title,video_flv_url, flv_upload_type'.
						' FROM '.$this->CFG['db']['tbl']['video'].' as v'.
						' WHERE '.$this->sql_condition.' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if($row = $rs->FetchRow())
					{
						if($row['video_ext']==$video_type)
						{
							return true;
						}
						if($avail_arr=explode(',',$row['video_available_formats']) and
							in_array($video_type,$avail_arr) and $this->chkIsDownloadVideoFormat($video_type))
							return true;

					}
				return false;
			}




	public function chkIsDownloadVideoFormat($video_type='flv')
			{
				if($this->CFG['admin']['videos']['video_other_formats_enabled'] and isset($this->CFG['admin']['videos']['video_download_formats']) and is_array($this->CFG['admin']['videos']['video_download_formats']) and
				in_array($video_type, $this->CFG['admin']['videos']['video_download_formats']))
					return true;
				if($this->CFG['rss_display']['itunes'] && $video_type=='mp4')
				{
					return true;
				}
				return false;
			}


		public function populateVideoChannel($type = 'General')
			{
				//Video catagory List order by Priority on / off features
				if($this->CFG['admin']['videos']['video_category_list_priority'])
					$order_by = 'priority';
				else
					$order_by = 'video_category_name';

				$sql = 'SELECT video_category_id, video_category_name FROM '.
						$this->CFG['db']['tbl']['video_category'].
							' WHERE parent_category_id=0 AND video_category_status=\'Yes\''.
							' AND video_category_type='.$this->dbObj->Param('video_category_type').' AND allow_post=\'Yes\' ORDER BY '.$order_by.' ASC ';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($type));
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

					if(!$rs->PO_RecordCount())
						return;

					$names = array('video_category_name');
					$value = 'video_category_id';
					$inc =0;
					while($row = $rs->FetchRow())
					{
						$channel[$inc]['id']=$row['video_category_id'];
						$channel[$inc]['name']=$row['video_category_name'];
						$inc++;
					}

					return $channel;
			}

		/**
		 * VideoHandler::populateVideoChannelsRightNavigation()
		 *
		 * @return
		 */
		public function populateVideoChannelsRightNavigation()
		{
				global $smartyObj;
				if(!isMember())
					$_SESSION['user']['content_filter'] ='On';
				if($_SESSION['user']['content_filter'] =='On')
				  $_videoType=' AND video_category_type = \'General\'';
				else
				  $_videoType='';

				if(!chkAllowedModule(array('video')))
					return;

				//$allowed_pages_array = array('viewProfile.php');
				$allowed_pages_array = array('index.php', 'videoCategory.php', 'videoList.php', 'viewVideo.php', 'manageComments.php', 'myVideoAlbums.php', 'createAlbum.php', 'videoUpload.php', 'videoUploadPopUp.php', 'videoAdvertisement.php', 'tags.php');

				if(isset($_REQUEST['search_type']) and $_REQUEST['search_type']=='channel' and displayBlock(array('searchList.php')))
					$continue=1;
				elseif(basename($_SERVER['PHP_SELF']) == 'createAlbum.php')
					return;
				elseif(basename($_SERVER['PHP_SELF']) == 'manageComments.php')
					return;
				elseif(!displayBlock($allowed_pages_array))
					return;

				 $default_cond = '(u.user_id = v.user_id'.
								 ' AND u.usr_status=\'Ok\') AND '.
								 ' v.video_status=\'Ok\''.$this->getAdultQuery('v.').
								 ' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
								 ' video_access_type = \'Public\''.$this->getAdditionalQuery().')';

				$sql = 'SELECT v.video_category_id, COUNT(v.video_id)'.
						' AS total_videos FROM '.$this->CFG['db']['tbl']['video'].
						' AS v, '.$this->CFG['db']['tbl']['users'].' AS u'.
						' WHERE v.video_status=\'Ok\' AND '.$default_cond.
						' GROUP BY video_category_id HAVING total_videos>0';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.
							$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$category_count_arr = array();
				while($row = $rs->FetchRow())
					{
						$category_count_arr[$row['video_category_id']] = $row['total_videos'];
					}
				//Video catagory List order by Priority on / off features
				if($this->CFG['admin']['videos']['video_category_list_priority'])
					$order_by = 'priority';
				else
					$order_by = 'video_category_name';

				$sql = 'SELECT video_category_id, video_category_name, video_category_type, '.
						'video_category_description, video_category_status, video_category_ext, date_added '.
						'FROM '.$this->CFG['db']['tbl']['video_category'].' '.
						'WHERE parent_category_id=0 AND video_category_status = \'Yes\' '.$_videoType.
						'ORDER BY '.$order_by.' ASC LIMIT 0,'.$this->CFG['admin']['video']['left_video_channel_display_count'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$channel=array();
				$inc=0;
				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$total_videos = isset($category_count_arr[$row['video_category_id']])?$category_count_arr[$row['video_category_id']]:0;
								$channel[$inc]['videoListUrl']=getUrl('videolist', '?pg=videonew&cid='.$row['video_category_id'], 'videonew/?cid='.$row['video_category_id'],'','video');
								$channel[$inc]['video_category_name']=wordWrap_mb_Manual($row['video_category_name'], $this->CFG['admin']['videos']['right_nav_video_channel_title_length'],$this->CFG['admin']['videos']['right_nav_video_channel_title_total_length']);
								$channel[$inc]['total_videos']=$total_videos;
								$inc++;
							}

					}
					$viewChannelUrl = getUrl('videocategory','','','','video');
					$smartyObj->assign('videoChannel',$channel);
					$smartyObj->assign('viewChannelUrl',$viewChannelUrl);
					setTemplateFolder('general/','video');
					$smartyObj->display('videoChannelNavigation.tpl');

			}

		/**
		 * VideoHandler::populateVideoTagsRightNavigation()
		 *
		 * @return
		 */
		public function populateVideoTagsRightNavigation()
			{
				global $smartyObj;
				if(!chkAllowedModule(array('video')))
					return;

				//$allowed_pages_array = array('viewProfile.php');
				$allowed_pages_array = array('index.php','videoCategory.php', 'tags.php', 'videoList.php', 'viewVideo.php', 'manageComments.php', 'myVideoAlbums.php', 'createAlbum.php', 'videoUpload.php', 'videoUploadPopUp.php', 'videoAdvertisement.php');
				if(!displayBlock($allowed_pages_array))
					return;
				elseif(basename($_SERVER['PHP_SELF']) == 'createAlbum.php')
					return;
				elseif(basename($_SERVER['PHP_SELF']) == 'manageComments.php')
					return;
				if($this->CFG['admin']['tagcloud_based_search_count'])
					{
						$sql = 'SELECT tag_name, search_count FROM '.$this->CFG['db']['tbl']['tags_video'].
							   ' WHERE search_count>0 ORDER BY search_count DESC, result_count DESC, tag_name ASC'.
							   ' LIMIT '.$this->CFG['admin']['tags_count']['index_page'];
					}
				else
					{
						$sql = 'SELECT tag_name, result_count AS search_count FROM'.
								' '.$this->CFG['db']['tbl']['tags_video'].
							   ' WHERE result_count>0 ORDER BY result_count DESC, tag_name ASC'.
							   ' LIMIT '.$this->CFG['admin']['tags_count']['index_page'];
					}

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$searchUrl = getUrl('videolist', '?pg=videonew&amp;tags=%s', 'videonew/?tags=%s','','video');
				$videoTag=array();
				$inc=0;
				if ($rs->PO_RecordCount()>0)
				    {
						$classes = array('clsFontColorBlueBlod','clsFontColorBlueNormal','clsFontThinBlueBlod');
						$tagClassArray = array();
				        while($row = $rs->FetchRow())
			            {
							$tagArray[$row['tag_name']] = $row['search_count'];
							$class = $classes[rand(0, count($classes))%count($classes)];
							$tagClassArray[$row['tag_name']] = $class;
						}
						$tagArray = $this->setVideoFontSizeInsteadOfSearchCountSidebar($tagArray);
						ksort($tagArray);
						foreach($tagArray as $tag=>$fontSize)
							{
								$url 	= sprintf($searchUrl, $tag);
								$class 	= $tagClassArray[$tag];
								$fontSizeClass= 'style="font-size:'.$fontSize.'px"';
								$videoTag[$inc]['url']=$url;
								$videoTag[$inc]['class']=$class;
								$videoTag[$inc]['fontSizeClass']=$fontSizeClass;
								$videoTag[$inc]['name']=$tag;
								$inc++;
							}


				    }
				    $smartyObj->assign('tags',$videoTag);
				    $smartyObj->assign('viewTagUrl',getUrl('tags', '?pg=video', 'video/','','video'));
					setTemplateFolder('general/','video');
					$smartyObj->display('videoTagNavigation.tpl');
			}

		/**
		 * Tag::populateTags()
		 *
		 * @return
		 **/
		public function populateSidebarClouds($module, $tags_table,$limit=20,$returnValue=false)
			{
				global $smartyObj;
				$return = array();
				$return['resultFound']=false;

						$allowed_pages_array = array('index.php','videoCategory.php', 'tags.php', 'videoList.php', 'viewVideo.php', 'manageComments.php', 'myVideoAlbums.php', 'createAlbum.php', 'videoUpload.php', 'videoUploadPopUp.php', 'videoAdvertisement.php');
						if(!displayBlock($allowed_pages_array))
							return;
						elseif(basename($_SERVER['PHP_SELF']) == 'createAlbum.php')
							return;
						elseif(basename($_SERVER['PHP_SELF']) == 'manageComments.php')
							return;
						if($this->CFG['admin']['tagcloud_based_search_count'])
							{
								$sql = 'SELECT tag_name, search_count FROM '.$this->CFG['db']['tbl'][$tags_table].
									    ' WHERE search_count>0 ORDER BY search_count DESC, result_count DESC, tag_name ASC'.
									    ' LIMIT 0, '.$limit;
							}
						else
							{
								$sql = 'SELECT tag_name, result_count AS search_count FROM'.
										' '.$this->CFG['db']['tbl'][$tags_table].
									    ' WHERE result_count>0 ORDER BY result_count DESC, tag_name ASC'.
									    ' LIMIT 0, '.$limit;
							}

						$searchUrl = getUrl('videolist', '?pg=videonew&amp;tags=%s', 'videonew/?tags=%s','','video');
						$moreclouds_url = getUrl('tags', '?pg=video', 'video/', '', 'video');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						if ($rs->PO_RecordCount()>0)
						    {
						    	$return['resultFound']=true;
								$classes = array('clsVideoTagStyleGrey', 'clsVideoTagStyleGreen');
								$tagClassArray = array();
						        while($row = $rs->FetchRow())
							        {
											$tagArray[$row['tag_name']] = $row['search_count'];
											$class = $classes[rand(0, count($classes))%count($classes)];
											$tagClassArray[$row['tag_name']] = $class;
									}
								$tagArray = $this->setVideoFontSizeInsteadOfSearchCountSidebar($tagArray);
								ksort($tagArray);
								$inc=0;
								foreach($tagArray as $tag=>$fontSize)
									{
										$url 	= sprintf($searchUrl, $tag);
										$class 	= $tagClassArray[$tag];
										$fontSizeClass= 'style="font-size:'.$fontSize.'px"';
										$return['item'][$inc]['url']=$url;
										$return['item'][$inc]['class']=$class;
										$return['item'][$inc]['fontSizeClass']=$fontSizeClass;
										//$return['item'][$inc]['wordWrap_mb_ManualWithSpace_tag']= wordWrap_mb_ManualWithSpace($tag, $this->CFG['admin']['videos']['sidebar_clouds_name_length'], $this->CFG['admin']['videos']['sidebar_clouds_name_total_length']);
										$return['item'][$inc]['name']=$tag;
										$inc++;
									}
						    }
						$smartyObj->assign('moreclouds_url', $moreclouds_url);
						$smartyObj->assign('opt', $module);
						$smartyObj->assign('populateCloudsBlock', $return);
						if (!$returnValue) {
							setTemplateFolder('general/', 'photo');
							$smartyObj->display('populateCloudsBlock.tpl');
						}

			}

		/**
		 * VideoHandler::populateFlashPlayerConfiguration()
		 *
		 * @return
		 */
		public function populateFlashPlayerConfiguration($video_id = 0)
		 	{
				if($this->CFG['admin']['videos']['SelectedPlayer']=='elite')
				{
					$this->flv_player_url_embed=$this->flv_player_url= $this->CFG['site']['url'].$this->CFG['media']['folder'].'/flash/video/flvplayers/'.$this->CFG['admin']['videos']['elite_player']['swf_name'].'.swf';
					$this->configXmlcode_url = $this->CFG['site']['video_url'].$this->CFG['admin']['videos']['elite_player']['config_name'].'.php?';
				}
				else
				{
					$this->flv_player_url_embed=$this->flv_player_url = $this->CFG['site']['video_url'].'embedPlayer.php?vid='.mvFileRayzz($this->fields_arr['video_id']).'_'.$this->fields_arr['video_id'];
					$this->configXmlcode_url = $this->CFG['site']['video_url'].$this->CFG['admin']['videos']['premium_player']['config_name'].'.php?';
				}
				if(isset($this->fields_arr['play_list']) AND $this->fields_arr['play_list']=='pl')
				$this->arguments_play = 'pg=video_'.$this->fields_arr['video_id'].'_no_'.getRefererForAffiliate().'_'.$this->fields_arr['play_list'].'_'.$this->fields_arr['order'].'_'.$this->fields_arr['playlist_id'];
				else if(isset($this->fields_arr['play_list']) AND $this->fields_arr['play_list']=='ql')
				$this->arguments_play = 'pg=video_'.$this->fields_arr['video_id'].'_no_'.getRefererForAffiliate().'_'.$this->fields_arr['play_list'];
				else
				$this->arguments_play = 'pg=video_'.$this->fields_arr['video_id'].'_no_'.getRefererForAffiliate();
			}

		/**
		 * VideoHandler::getTagsOfThisVideo()
		 *
		 * @param string $tag
		 * @return
		 */
		public function getTagsOfThisVideo($tag='')
			{
				if(!$tag)
					$tag=$this->fields_arr['video_tags'];

				$tags_arr = explode(' ',$tag);
				$inc=0;
				foreach($tags_arr as $tags)
					{
						$return[$inc]['tag_url']=getUrl('videolist','?pg=videonew&amp;tags='.$tags, 'videonew/?tags='.$tags,'','video');
						$return[$inc]['tag']=$tags;
					}
				return $return;
			}

		/**
		 * VideoHandler::populateVideoMemberMenu()
		 *
		 * @return
		 */
		public function populateVideoMemberMenu()
		{

			global $smartyObj;
			$this->_currentPage = strtolower($this->CFG['html']['current_script_name']);
			$this->_navigationArr['left_'.$this->_currentPage] = $this->_clsActiveLink;

			if(@$this->getFormField('block'))
			{
				$page = $this->_currentPage.'_'.strtolower($this->getFormField('block'));
				$this->_navigationArr['left_'.$page] = $this->_clsActiveLink;
			}
			if(@$this->getFormField('pg'))
			{
				$page = $this->_currentPage.'_'.strtolower($this->getFormField('pg'));
				$this->_navigationArr['left_'.$page] = $this->_clsActiveLink;
			}



			setTemplateFolder('general/','video');
			$smartyObj->display('videoMemberMenu.tpl');
		}

		/**
		 * VideoHandler::getVideoNavClass()
		 *
		 * @param mixed $identifier
		 * @return
		 */
		public function getVideoNavClass($identifier)
		{
			$identifier = strtolower($identifier);
			return isset($this->_navigationArr[$identifier])?$this->_navigationArr[$identifier]:$this->_clsInActiveLink;
		}


		/**
		 * VideoHandler::selectPlaylist()
		 *
		 * @param mixed $condition
		 * @param mixed $value
		 * @param string $returnType
		 * @return
		 */
		public function selectPlaylist($condition,$value,$returnType='')
		{
			$sql ='SELECT * FROM '.$this->CFG['db']['tbl']['video_playlist'].' WHERE '.$condition;
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, $value);
			if (!$rs)
				trigger_db_error($this->dbObj);
			$numRows = $rs->PO_RecordCount();
			if(!$returnType)
				return $numRows;
			else
				return $rs;

		}

		/**
		 * VideoHandler::selectVideoInPlaylist()
		 *
		 * @param mixed $condition
		 * @param mixed $value
		 * @param string $returnType
		 * @return
		 */
		public function selectVideoInPlaylist($condition,$value,$returnType='')
		{
			$sql ='SELECT * FROM '.$this->CFG['db']['tbl']['video_in_playlist'].' WHERE '.$condition;
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, $value);
			if (!$rs)
				trigger_db_error($this->dbObj);
			$numRows = $rs->PO_RecordCount();
			if(!$returnType)
				return $numRows;
			else
				return $rs;

		}

		/**
		 * VideoHandler::createPlaylist()
		 *
		 * @return
		 */
		public function createPlaylist()
		{
			$selectCondition='playlist_name='.$this->dbObj->Param('playlist_name').' AND user_id ='.$this->dbObj->Param('user_id');;
			$selectValue=array($this->fields_arr['playlist_name'],$this->CFG['user']['user_id']);
			if(!$this->selectPlaylist($selectCondition,$selectValue))
			{
				$sql = "INSERT INTO ".$this->CFG['db']['tbl']['video_playlist'].
				' SET user_id='.$this->dbObj->Param('user_id').',playlist_name='.$this->dbObj->Param('playlist_name').',playlist_description='.$this->dbObj->Param('playlist_description').
				',playlist_tags='.$this->dbObj->Param('playlist_tags').',playlist_access_type='.$this->dbObj->Param('playlist_access_type').',date_added=now()';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'],$this->fields_arr['playlist_name'],$this->fields_arr['playlist_description'],$this->fields_arr['playlist_tags'],$this->fields_arr['playlist_access_type']));
				if (!$rs)
				trigger_db_error($this->dbObj);
				return ($this->dbObj->Insert_ID());
			}
			return false;

		}

		/**
		 * VideoHandler::updatePlaylist()
		 *
		 * @param mixed $id
		 * @return
		 */
		public function updatePlaylist($id)
		{
			$video_id = $this->fields_arr['video_id'];
			if($this->chkValidVideoId($video_id))
			{
				$selectCondition='video_id='.$this->dbObj->Param('video_id').' AND playlist_id='.$this->dbObj->Param('playlist_id') .' LIMIT 0,1';
				$selectValue=array($video_id,$id);
				if(!$this->selectVideoInPlaylist($selectCondition,$selectValue))
				{
					$sql ='SELECT max(order_id)+1 as max_order FROM '.$this->CFG['db']['tbl']['video_in_playlist'].' WHERE playlist_id='.$this->dbObj->Param('playlist_id').' GROUP By playlist_id limit 0,1';
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($id));
					if($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
					}
					else{
						$row['max_order']=1;
					}

					$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_playlist'].
					' SET total_videos=total_videos+1 , thumb_video_id='.$this->dbObj->Param('thumb_video_id').', thumb_ext='.$this->dbObj->Param('thumb_ext').' WHERE playlist_id='.$this->dbObj->Param('playlist_id');;
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($video_id,$this->fields_arr['video_ext'],$id));
					if (!$rs)
						trigger_db_error($this->dbObj);

					$sql ='INSERT INTO '.$this->CFG['db']['tbl']['video_in_playlist'].
					' SET playlist_id='.$this->dbObj->Param('playlist_id').' , video_id='.$this->dbObj->Param('video_id').', date_added=now(),order_id='.$this->dbObj->Param('order_id');
					$stmt = $this->dbObj->Prepare($sql);

					$rs = $this->dbObj->Execute($stmt, array($id,$video_id,$row['max_order']));
					if (!$rs)
						trigger_db_error($this->dbObj);
					echo sprintf($this->LANG['playlist_update_success'],$this->fields_arr['playlist_name']);
					echo '#$#'.$id;

				}
				else
					echo $this->LANG['playlist_content_already_added'];
			}
			else
				echo $this->LANG['viewvideo_no_video_id'];
		}
			public function chkIsLocalServer()
			{
				$server_url = $this->fields_arr['video_server_url'];
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

		public function chkIsPrivateVideo($video_id)
		{
			$sql = 'SELECT video_id FROM '.$this->CFG['db']['tbl']['video'].' WHERE video_access_type=\'Private\' AND video_status=\'Ok\' AND video_id='.$this->dbObj->Param('video_id');;
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($video_id));
			if (!$rs)
				trigger_db_error($this->dbObj);

			if($rs->PO_RecordCount())
			{
				return true;
			}
			return false;
		}
		public function chkIsAllowedLeftMenu()
		{
			global $HeaderHandler;
			$allowed_pages_array = array('viewVideo.php', 'index.php');
			$HeaderHandler->headerBlock['left_menu_display'] = displayBlock($allowed_pages_array, false, $append_default_pages=false);
			return $HeaderHandler->headerBlock['left_menu_display'];
		}

		/**
		 * VideoHandler::populateSideBarFlashPlayerConfiguration()
		 *   Flash player Config for Side bar (Index page)
		 *
		 * @return void
		 */
		public function populateSideBarFlashPlayerConfiguration()
		 	{
				$this->flv_player_url = $this->CFG['site']['url'].$this->CFG['media']['folder'].'/flash/video/flvplayers/mini_flvplayer.swf';
				$arguments_embed = 'pg=video_'.$this->fields_arr['video_id'].'_no_0&ext_site=';
				$this->configXmlcode_url = $this->CFG['site']['video_url'].'videoMiniPlayerConfigXmlCode.php?';
			}

		/**
		 * VideoHandler::getRandomVideoForSideBar()
		 *  To Generate Featured Videos for Side Bar - Will call the tpl from here
		 *
		 *
		 * @return void
		 */
		public function getRandomVideoForSideBar()
			{
				global $smartyObj;
				$userId = $this->CFG['user']['user_id'];

				$condition = 'p.video_status=\'Ok\'' . $this->getAdultQuery('p.').
							 ' AND u.usr_status=\'Ok\' AND (p.user_id = '.$userId.
							 ' OR p.video_access_type = \'Public\'' . $this->getAdditionalQuery('p.') . ') AND p.featured=\'Yes\'';

				$default_fields = 'p.user_id, p.video_id, p.video_title, p.video_caption, p.total_views, p.video_server_url,'.
								   ' p.t_width, p.t_height,(p.rating_total/p.rating_count) as rating,'.
								   ' TIME_FORMAT(p.playing_time,\'%H:%i:%s\') as playing_time, TIMEDIFF(NOW(), p.date_added) as video_date_added,'.
								   ' TIMEDIFF(NOW(), p.last_view_date) as video_last_view_date, p.video_tags,file_name';

				$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['video'].' as p JOIN '.
						$this->CFG['db']['tbl']['users'].' as u ON p.user_id = u.user_id'.
						' JOIN '.$this->CFG['db']['tbl']['video_files_settings'].' as vfs ON video_file_id = thumb_name_id'.
						' WHERE '.$condition.' ORDER BY RAND() LIMIT 0,3';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$video_list_arr = array();
				$inc = 0;
				$thumbnail_folder = $this->CFG['media']['folder'].'/'.
									$this->CFG['admin']['videos']['folder'].'/'.
									$this->CFG['admin']['videos']['thumbnail_folder'].'/';

				$separator = ':&nbsp;';
				while($row = $rs->FetchRow())
					{
						$video_list_arr[$inc]['video_date_added'] = getTimeDiffernceFormat($row['video_date_added']);
						$video_list_arr[$inc]['video_last_view_date'] = getTimeDiffernceFormat($row['video_last_view_date']);
						$video_list_arr[$inc]['playing_time'] = $row['playing_time']?$row['playing_time']:'00:00';

						$video_list_arr[$inc]['video_url'] = getUrl('viewvideo','?video_id='.$row['video_id'].'&title='.
																$this->changeTitle($row['video_title']), $row['video_id'].'/'.
																	$this->changeTitle($row['video_title']).'/','','video');
						$video_list_arr[$inc]['image_url'] = $row['video_server_url'].$thumbnail_folder.
																getVideoImageName($row['video_id'],$row['file_name']).
																	$this->CFG['admin']['videos']['thumb_name'].'.'.
																		$this->CFG['video']['image']['extensions'];
						$video_list_arr[$inc]['video_title'] = $row['video_title'];
						$video_list_arr[$inc]['video_title_full'] = addslashes($row['video_title']);
						$video_list_arr[$inc]['record'] = $row;
						$inc++;

					}

				$this->getrandomVideo_arr = $video_list_arr;

				if(!$video_list_arr)
					{
						$this->randFirstTitle = $this->LANG['index_msg_no_top_rated_videos'];
						$randFirstId=0;
					}
				else
					{
						$randFirstId = $video_list_arr[0]['record']['video_id'];
						$this->randFirstTitle = stripslashes($video_list_arr[0]['video_title_full']);
					}
				if(!empty($this->getrandomVideo_arr))
					{
						$this->setFormField('video_id', $randFirstId);
						setTemplateFolder('general/', 'video');
						$smartyObj->display('indexRandomVideoSidebar.tpl');
					}
			}

		/**
		 * VideoHandler::getSideBarFeaturedVideoPlayer()
		 *  To Generate Side Bar Featured Video Player (Index page)
		 *
		 * @param Integer $video_id
		 * @return void
		 */
		public function getSideBarFeaturedVideoPlayer($video_id)
			{
			 	   	$videos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/';
			 	   	$this->populateSideBarFlashPlayerConfiguration();
					$this->arguments_play = 'pg=smallvideo_'.$video_id.'_no_'.getRefererForAffiliate();
					$this->CFG['admin']['videos']['playList']=false;
					?>
					<script type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/swfobject.js"></script>
					<script type="text/javascript">
		                var so1 = new SWFObject("<?php echo $this->flv_player_url;?>", "flvplayer", "298", "251", "7",  null, true);
		                so1.addParam("allowFullScreen", "true");
		                so1.addParam("wmode", "transparent");
		                so1.addParam("autoplay", "false");
		                so1.addParam("allowSciptAccess", "always");
		                so1.addVariable("config", "<?php echo $this->configXmlcode_url.$this->arguments_play;?>");
		                so1.write("flashcontent2");
	                </script>
					<?php
			}

			public function trimVideo($video_id,$flvPath,$start=0,$end=0)
			{

				/*if($this->CFG['admin']['videos']['full_length_video']=='All')
					return true;*/
				$start=$start*1000;
				$end=$end*1000;
				$log_str='TRIMING VIDEO STARTED'."\r\n";
				$tempFolder = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
								$this->CFG['temp_media']['folder'].'/'.
									$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['temp_folder'].'/';

				$trimFilename = getTrimVideoName($video_id).'.flv';
				$trimPath = $tempFolder.$trimFilename;
				$tempPath = $tempFolder.getTrimVideoName($video_id).'_TEMP.flv';
				$command = "\"".$this->CFG['admin']['video']['flvtool2_path']."\"".' -C -i '.$start.' -o '.$end.' '.$flvPath.' '.$tempPath;
				$log_str .= $command."\r\n";
				$result = exec($command, $p);
				if(count($p))
				{
					foreach($p as $key=>$val)
						$log_str .= $key.': '.$val."\n\r";
				}
				$command = "\"".$this->CFG['admin']['video']['flvtool2_path']."\"".' -UP '.$tempPath.' '.$trimPath;
				$log_str .= $command."\r\n";
				$result = exec($command, $p);
				@unlink($tempPath);
				if(method_exists($this, 'writetoTempFile'))
					$this->writetoTempFile($log_str);
			}

		public function populateVideoListHidden($hidden_field)
		{
			foreach($hidden_field as $hidden_name)
			{
				//when submit the form through javascript and if not submit in IE,then check hidden input with the name set as "action", obviously this confused IE.
				//refer http://bytes.com/topic/javascript/answers/92323-form-action-help-needed
				if($hidden_name == 'action')
					$hidden_name = 'action_new';

?>
				<input type="hidden" name="<?php echo $hidden_name;?>" id="<?php echo $hidden_name;?>" value="<?php echo isset($this->fields_arr[$hidden_name])?$this->fields_arr[$hidden_name]:'';?>" />
<?php
			}
		}

	/**
	 * VideoHandler::sendMailToUserForVideoComment()
	 *
	 * @return
	 */
	public function sendMailToUserForVideoComment()
		{
			$fields_list = array('user_name', 'email', 'first_name', 'last_name');

			$this->UserDetail = $this->getUserDetail('user_id',$this->fields_arr['user_id']);

			$subject = $this->LANG['video_comment_received_subject'];
			$body = $this->LANG['video_comment_received_content'];

			$user_url = getMemberProfileUrl($this->CFG['user']['user_id'], $this->CFG['user']['user_name']);
			$videolink = $this->getAffiliateUrl(getUrl('viewvideo', '?video_id='.$this->fields_arr['video_id'].
							'&video_title='.$this->changeTitle($this->fields_arr['video_title']), $this->fields_arr['video_id'].'/'.
									$this->changeTitle($this->fields_arr['video_title']).'/', 'members', 'video'));

			$this->setEmailTemplateValue('VAR_SITE_NAME', $this->CFG['site']['name']);
			$this->setEmailTemplateValue('VAR_VIDEO_TITLE', $this->fields_arr['video_title']);
			$this->setEmailTemplateValue('VAR_USER_NAME', $this->UserDetail[$this->fields_arr['user_id']]['user_name']);
			$this->setEmailTemplateValue('VAR_VIDEO_LINK', $videolink);
			$this->setEmailTemplateValue('VAR_LINK', $this->getAffiliateUrl($this->CFG['site']['url']));
			$this->setEmailTemplateValue('VAR_USER', '<a href="'.$user_url.'">'.$this->CFG['user']['user_name'].'</a>');
			$this->setEmailTemplateValue('VAR_COMMENT', wordWrap_mb_Manual($this->fields_arr['f'], 100, 100, true));

			$this->_sendMail($this->UserDetail[$this->fields_arr['user_id']]['email'],
								$subject, $body, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);

		}

	/**
	 * VideoHandler::sendMailToUserForVideoResponse()
	 *
	 * @return
	 */
	public function sendMailToUserForVideoResponse($responded_video_arr)
		{
			$fields_list = array('user_name', 'email', 'first_name', 'last_name');

				$user_name=$this->getUserDetail('user_id',$this->fields_arr['user_id'], 'user_name');

			$subject = $this->LANG['video_response_received_subject'];
			$body = $this->LANG['video_response_received_content'];

			$videolink = $this->getAffiliateUrl(getUrl('viewvideo', '?video_id='.$this->fields_arr['video_id'].
							'&video_title='.$this->changeTitle($this->fields_arr['video_title']), $this->fields_arr['video_id'].'/'.
									$this->changeTitle($this->fields_arr['video_title']).'/', 'members', 'video'));

			$videos_folder =$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';

			$video_response_video_title = wordWrap_mb_ManualWithSpace($responded_video_arr['video_title'], 30);
			$video_response_user_url = getMemberProfileUrl($this->CFG['user']['user_id'], $this->CFG['user']['user_name']);
			$video_response_img = '<img border="0" src="'.$responded_video_arr['video_server_url'].$videos_folder.getVideoImageName($responded_video_arr['video_responses_video_id']).$this->CFG['admin']['videos']['thumb_name'].'.'.$this->CFG['video']['image']['extensions'].'" alt="'.$responded_video_arr['video_title'].'" title="'.$responded_video_arr['video_title'].'" />';
			$video_response_link = $this->getAffiliateUrl(getUrl('viewvideo', '?video_id='.$responded_video_arr['video_responses_video_id'].'&video_title='.$responded_video_arr['video_title'], $responded_video_arr['video_responses_video_id'].'/'.$responded_video_arr['video_title'].'/', 'root', 'video'));

			$this->setEmailTemplateValue('VAR_SITE_NAME', $this->CFG['site']['name']);
			$this->setEmailTemplateValue('VAR_VIDEO_TITLE', $this->fields_arr['video_title']);
			$this->setEmailTemplateValue('VAR_USER_NAME', $this->getUserDetail('user_id',$this->fields_arr['user_id'], 'user_name'));
			$this->setEmailTemplateValue('VAR_USER', '<a href="'.$video_response_user_url.'">'.$this->CFG['user']['user_name'].'</a>');

			$this->setEmailTemplateValue('RESPONDED_VIDEO_IMG', '<a href="'.$video_response_link.'">'.$video_response_img.'</a>');
			$this->setEmailTemplateValue('RESPONDED_VIDEO_TITLE', '<a href="'.$video_response_link.'">'.$video_response_video_title.'</a>');

			$this->setEmailTemplateValue('VAR_VIDEO_LINK', $videolink);
			$this->setEmailTemplateValue('VAR_LINK', $this->getAffiliateUrl($this->CFG['site']['url']));

		//	$this->_sendMail($this->UserDetails[$this->fields_arr['user_id']]['email'],
							//	$subject, $body, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);

		}

	/**
	 * VideoHandler::getCategoryName()
	 *
	 * @param mixed $category_id
	 * @return string
	 */
	public function getCategoryName($category_id)
		{
			$sql = 'SELECT video_category_name '.
						'FROM '.$this->CFG['db']['tbl']['video_category'].' '.
						'WHERE video_category_id = '.$this->dbObj->Param('video_category_id').
						' AND video_category_status=\'Yes\'';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($category_id));
		    if (!$rs)
			    trigger_db_error($this->dbObj);

			$row = $rs->FetchRow();
			return $row['video_category_name'];
		}

		/**
		 * VideoHandler::populateVideoCategoriesForSubscription()
		 *   Generate Categories for Subscription option
		 *
		 * @return array
		 */
		public function populateVideoCategoriesForSubscription()
			{
				if(!isMember())
					$_SESSION['user']['content_filter'] ='On';

				if($_SESSION['user']['content_filter'] =='On')
					$_videoType=' AND video_category_type = \'General\'';
				else
					$_videoType='';

				//Video catagory List order by Priority on / off features
				if($this->CFG['admin']['videos']['video_category_list_priority'])
					$order_by = 'priority';
				else
					$order_by = 'video_category_name';

				$sql = 'SELECT video_category_id, video_category_name '.
						'FROM '.$this->CFG['db']['tbl']['video_category'].' '.
						'WHERE parent_category_id=0 AND video_category_status = \'Yes\' '.$_videoType.
						'ORDER BY '.$order_by.' ASC';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$channel=array();
				$inc=0;
				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$channel[$inc]['id'] = $row['video_category_id'];
								$channel[$inc]['name'] = $row['video_category_name'];
								$inc++;
							}

					}
				return $channel;
			}

		/**
		 * VideoHandler::populateVideoSubCategoriesForSubscription()
		 *   Generate Categories for Subscription option
		 *
		 * @return array
		 */
		public function populateVideoSubCategoriesForSubscription($category_id)
			{
				if(!isMember())
					$_SESSION['user']['content_filter'] ='On';

				if($_SESSION['user']['content_filter'] =='On')
					$_videoType=' AND video_category_type = \'General\'';
				else
					$_videoType='';

				//Video catagory List order by Priority on / off features
				if($this->CFG['admin']['videos']['video_category_list_priority'])
					$order_by = 'priority';
				else
					$order_by = 'video_category_name';

				$sql = 'SELECT video_category_id, video_category_name '.
						'FROM '.$this->CFG['db']['tbl']['video_category'].' '.
						'WHERE parent_category_id='.$category_id.' AND video_category_status = \'Yes\' '.$_videoType.
						'ORDER BY '.$order_by.' ASC';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$channel=array();
				$inc=0;
				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$channel[$inc]['id'] = $row['video_category_id'];
								$channel[$inc]['name'] = wordWrap_mb_Manual($row['video_category_name'], $this->CFG['admin']['videos']['member_channel_length'], $this->CFG['admin']['videos']['member_channel_total_length']);
								$inc++;
							}

					}
				return $channel;
			}


		/**
		 * VideoHandler::populateVideoCategoriesListForSubscription()
		 *
		 *
		 * @return void
		 */
		public function populateVideoCategoriesListForSubscription()
			{
				global $CFG, $smartyObj;

				$catergoryPerRow = $this->CFG['admin']['videos']['catergory_list_per_row'];
				$rowInc=0;

				if(!isMember())
					$_SESSION['user']['content_filter'] ='On';

				if($_SESSION['user']['content_filter'] =='On')
					$_videoType=' AND video_category_type = \'General\'';
				else
					$_videoType='';

				//Video catagory List order by Priority on / off features
				if($this->CFG['admin']['videos']['video_category_list_priority'])
					$order_by = 'priority';
				else
					$order_by = 'video_category_name';

				$sql = 'SELECT gc.video_category_id, gc.video_category_name,'.
						'gc.video_category_type, video_category_description,'.
						'gc.video_category_status, gc.video_category_ext, gc.date_added FROM '.
						$CFG['db']['tbl']['video_category'].' as gc JOIN '.
						$CFG['db']['tbl']['subscription'].' as s ON gc.video_category_id = s.category_id '.
						' WHERE  video_category_status = \'Yes\' '.
						' AND s.module = \'video\' AND s.subscriber_id='.$this->CFG['user']['user_id'].
						' AND s.status=\'Yes\' '.$_videoType.
						' ORDER BY '.$order_by.' ASC';


				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$channel=array();
				$inc=0;
				$found = false;
				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$channel[$inc]['open_tr'] = false;
								$found = true;
								if ($rowInc%$catergoryPerRow==0)
							   		{
										$channel[$inc]['open_tr'] = true;
								    }

								if(chkAllowedModule(array('content_filter')))
									{
										$channel[$inc]['content_filter'] = true;
									}
								else
									{
										$channel[$inc]['content_filter'] = false;
									}

								$channel[$inc]['video_category_id'] = $row['video_category_id'];
								$channel[$inc]['category_name'] = $row['video_category_name'];
								if($row['video_category_ext'])
									{
										$channel[$inc]['category_image'] 	= $this->CFG['site']['project_path'].$this->CFG['admin']['videos']['category_folder'].$row['video_category_id'].'.'.$row['video_category_ext'];
									}
								if(!file_exists($channel[$inc]['category_image']))
									{
										$channel[$inc]['category_image'] =  $this->CFG['site']['video_url'].'design/templates/'.
																				$this->CFG['html']['template']['default'].'/root/images/'.
																					$this->CFG['html']['stylesheet']['screen']['default'].
																						'/no_image/noImageVideo_S.jpg';
									}
								else
									{
										$channel[$inc]['category_image']  = str_replace($this->CFG['site']['project_path'], $this->CFG['site']['url'],$channel[$inc]['category_image']);
									}
								$channel[$inc]['video_link'] = getUrl('videolist','?pg=videonew&cid='.$row['video_category_id'], 'videonew/?cid='.$row['video_category_id'],'','video');
								$rowInc++;
								$channel[$inc]['end_tr'] = false;
								if ($rowInc%$catergoryPerRow==0)
								    {
										$rowInc = 0;
										$channel[$inc]['end_tr'] = true;
						    		}
								$inc++;
							}

					}
				$subscription_category_list['extra_td_tr'] = false;
				if ($found and $rowInc and $rowInc<$catergoryPerRow)
				    {
						$subscription_category_list['extra_td_tr'] = true;
						$subscription_category_list['records_per_row'] = $catergoryPerRow - $rowInc;
					}

				$smartyObj->assign('categories_list_subscription_arr', $channel);
				$smartyObj->assign('subscription_category_list', $subscription_category_list);
				setTemplateFolder('members/', 'video');
				$smartyObj->display('subscriptionVideoCategory.tpl');
			}


		/**
		 * VideoHandler::populateVideoTagListForSubscription()
		 *
		 * @return void
		 */
		public function populateVideoTagListForSubscription()
			{
				global $CFG, $smartyObj;

				$subscription_tag_list['resultFound'] = false;
				$sql = 'SELECT s.tag_name FROM '.$this->CFG['db']['tbl']['subscription'].' as s '.
					    ' WHERE s.status=\'Yes\' AND s.module = \'video\''.
						' AND s.subscriber_id='.$this->CFG['user']['user_id'].
						' AND subscription_type=\'Tag\'';

				$searchUrl = getUrl('videolist', '?pg=videonew&tags=%s','videonew/?tags=%s','','video');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if ($rs->PO_RecordCount()>0)
				    {
				    	$subscription_tag_list['resultFound']=true;
						$classes = array('clsTagStyleOrange', 'clsTagStyleGrey');
						$tagClassArray = array();
				        while($row = $rs->FetchRow())
				        	{
								$tagArray[$row['tag_name']] = $row['tag_name'];
							}
						ksort($tagArray);
						$inc=0;
						foreach($tagArray as $tag)
							{
								$url 	= sprintf($searchUrl, $tag);
								$subscription_tag_list['item'][$inc]['url']=$url;
								$subscription_tag_list['item'][$inc]['name']=$tag;
								$inc++;
							}
				    }

				$smartyObj->assign('subscription_tag_list', $subscription_tag_list);
				setTemplateFolder('members/', 'video');
				$smartyObj->display('subscriptionVideoTag.tpl');
			}
		public function videoToFrame($source_filename, $temp_dir, $total_frames, $scale,$isRequestForGIFAnimation="")
			{
				if (substr($temp_dir,strlen($temp_dir)-1) == '/')
					$t_dir = substr($temp_dir, 0, strlen($temp_dir)-1);
				else
					$t_dir = $temp_dir;


				#if total_frames is Zero then we are increamenting the Value to One for Generating Thumbnail
				if($total_frames<4)
					$total_frames = 4;


				$playing_time_arr=explode(':',$this->getVideoPlayingTime($source_filename));
				$seconds=isset($playing_time_arr[1])?intval($playing_time_arr[1]):0;
				$seconds+=$playing_time_arr[0]*60;


				$config_step = $this->CFG['admin']['videos']['max_skip_step_frame'];//no of secs to skip between capturing each frame
				$max_no_of_capturable_frames = floor($seconds / $config_step);

				//exit;
				// if the video is > 20 seconds and video is large enough to take frames with the set step
				// total_time / (config_step + 1) > totalframes we can use the step value
				// else we need to find the step value
				if($seconds>=$this->CFG['admin']['videos']['minmum_video_length'] AND ($max_no_of_capturable_frames >$config_step) )
				{
					$step=$config_step;
				}
				else
				{
					if($seconds>=$total_frames)
					{
						$step=floor($seconds/$total_frames);
					}
					else
					{
						$step=1;
					}
				}

				if(!$this->CFG['admin']['video']['ffmpeg_image_encode'])
				{
					##need to check the use of -ss 00:00:02
					$idx=(strtolower($this->VIDEO_EXT)=='avi')? ' -idx ':'';
					$execute_str =$this->CFG['admin']['mencoder_thumbnail_command'];
				}
				else
				{
					$execute_str =$this->CFG['admin']['ffmpeg_thumbnail_command'];
					$idx='';
				}

				$search_array = array('{mplayer_path}',
									  '{ffmpeg_path}',
									  '{idx}',
									  '{sstep}',
									  '{total_frames}',
									  '{source_file}',
									  '{output_file}',
									  '{scale}'
									);
				$replace_array = array("\"".$this->CFG['admin']['video']['mplayer_path']."\"",
									  "\"".$this->CFG['admin']['audio']['ffmpeg_path']."\"",
									  $idx,
									  $step,
									  $total_frames,
									  $source_filename,
									  $t_dir,
									  $scale
									 );
				$execute_str=str_replace($search_array,$replace_array,$execute_str);

				//------Writing to the log file
				$log_str = 'Video to Frame Conversion:'."\r\n";
				$log_str .=  $execute_str;

				//------Writing to the log file
				exec($execute_str, $p);
				if(count($p))
				{
					foreach($p as $key=>$val)
					$log_str .= $key.': '.$val."\n\r";
				}
				if(method_exists($this,'writetoTempFile'))
					$this->writetoTempFile($log_str);

				## If the videoToFrame method is requested for the GIF Animation Only generation of jpg files is enough, so r
				if($isRequestForGIFAnimation)
				{
					return $execute_str;
				}

				//Start: Getting max size file
				//largest image is set as the thumb_gen file
				for($k=1;$k<=$total_frames;$k++)
				{
					$file_name = $temp_dir.str_pad($k, 8, '0', STR_PAD_LEFT).'.'.$this->CFG['video']['image']['extensions'];
					$file_size_arr[@filesize($file_name)]=$file_name;
				}
				krsort($file_size_arr, SORT_NUMERIC);
				if($file_size_arr and ($file_size_keys_arr=array_keys($file_size_arr)) and isset($file_size_arr[$file_size_keys_arr[0]]) and is_file($file_size_arr[$file_size_keys_arr[0]]))
					copy($file_size_arr[$file_size_keys_arr[0]],$temp_dir.'thumb_gen.'.$this->CFG['video']['image']['extensions']);
				//End: Getting max size file process

				for($k=1;$k<$total_frames;$k++)
					{
						$from = $temp_dir.str_pad($k+1, 8, '0', STR_PAD_LEFT).'.'.$this->CFG['video']['image']['extensions'];
						$to = $temp_dir.str_pad($k, 8, '0', STR_PAD_LEFT).'.'.$this->CFG['video']['image']['extensions'];
						if(is_file($from))
							{
								//------Writing to the log file
								$log_str = 'Video to Frame Conversion Success:'."\r\n";
								if(method_exists($this,'writetoTempFile'))
									$this->writetoTempFile($log_str);
								//------Writing to the log file
								if(is_file($to))
									unlink($to);
								copy($from, $to);
							}
						else
							{
								//------Writing to the log file
								$log_str = 'Video to Frame Conversion Failed:'."\r\n";
								if(method_exists($this,'writetoTempFile'))
									$this->writetoTempFile($log_str);
								//------Writing to the log file
							}

					}
				$file = $temp_dir.str_pad($total_frames, 8, '0', STR_PAD_LEFT).'.'.$this->CFG['video']['image']['extensions'];
				if(is_file($file))
					unlink($file);
			}
		/**
		 * VideoUpload::getVideoPlayingTime()
		 *
		 * @param $text
		 * @return
		 **/
		public function getVideoPlayingTime($text_arr)
			{
				$vdoname = $text_arr;
				exec($this->CFG['admin']['video']['mplayer_path'].' -vo null -ao null -frames 0 -identify '.$vdoname, $p);
				while(list($k,$v)=each($p))
					{
						if($length=strstr($v,'ID_LENGTH='))
				        	break;
				    }
				$lx = explode("=",$length);
				$duration = @$lx[1];
				$min = floor($duration/60);
				$sec = floor($duration-($min*60));
				$min = str_pad($min, 2, '0', STR_PAD_LEFT);
				$sec = str_pad($sec, 2, '0', STR_PAD_LEFT);
				return $min.':'.$sec;
				/*foreach($text_arr as $val)
					{
						if (substr(trim($val), 0, 13) != 'Video stream:')
							continue;
						$str = $val;
					}
				if(isset($str))
					{
						$str = substr($str, 0, strpos($str, 'secs'));
						$str = str_replace(' ', '&', trim($str));
						$str = round(substr(strrchr($str, "&"), 1));
						$min = floor($str/60);
						$min = str_pad($min, 2, '0', STR_PAD_LEFT);
						$sec = $str%60;
						$sec = strlen($sec)>2?substr($sec, 0,2):str_pad($sec, 2, '0', STR_PAD_LEFT);
						return $min.':'.$sec;
					}
				else
					return '00:00';*/
			}
		public function setVideoFontSizeInsteadOfSearchCountSidebar($tag_array=array())
			{
				return $this->setFontSizeInsteadOfSearchCountSidebar($tag_array);
			}
		public function populateVideoRatingImages($rating = 0,$imagePrefix='',$condition='',$url='', $module='video')
			{
				return $this->populateVideoRatingImages($rating, $imagePrefix, $condition, $url, $module);
			}
		/**
		* VideoUpload::indexPageTotalVideoWatched()
		* To get total count for video watched
		* @param mixed
		* @return
		*/
		public function indexPageTotalVideoWatched()
		{
			$sql = 'SELECT COUNT(DISTINCT video_id) AS video_watched_count FROM '
					.$this->CFG['db']['tbl']['video_viewed'];

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);

			if (!$rs)
			trigger_db_error($this->dbObj);
			if ($rs->PO_RecordCount())
			{
				if($row = $rs->FetchRow())
				{
					if($row['video_watched_count'])
					{
						$all_video_url = getUrl('videolist','?pg=videomostviewed','videomostviewed/','','video');
						$row['video_watched_link'] = '<a href="'.$all_video_url.'">'.$row['video_watched_count'].'</a>';
						return $row['video_watched_link'];
					}
				}
			}
			return 0;
		}
		/**
		* VideoUpload::indexPageTotalVideosInSite()
		* To get Total video count
		* @param mixed
		* @return
		*/
		public function indexPageTotalVideosInSite()
		{
			global $CFG;
			global $db;

			$sql =	'SELECT SUM(total_videos) AS total_videos'.
					' FROM '.$CFG['db']['tbl']['users'].' WHERE usr_status='
					.$this->dbObj->Param('usr_status');

			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt, array('OK'));
			if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
			$db->ErrorMsg(), E_USER_ERROR);
			if ($rs->PO_RecordCount())
			{
				if($row = $rs->FetchRow())
				{
					if($row['total_videos'])
					{
						$all_video_url = getUrl('videolist','?pg=videonew', 'videonew/','','video');
						return '<a href="'.$all_video_url.'">'.$row['total_videos'].'</a>';
					}
				}
			}
			return 0;
		}
		/**
		* VideoUpload::indexPageTotalPlayList()
		* To get Playlist Total count
		* @param
		* @return
		*/
		public function indexPageTotalPlayList()
		{
			$sql = 'SELECT COUNT(DISTINCT playlist_id) AS total_playlist_count FROM '
					.$this->CFG['db']['tbl']['video_playlist'].' WHERE playlist_status= '
					.$this->dbObj->Param('playlist_status');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt,array('Yes'));
			if (!$rs)
			trigger_db_error($this->dbObj);

			if ($rs->PO_RecordCount())
			{
				if($row = $rs->FetchRow())
				{
					if($row['total_playlist_count'])
					{
						$all_video_url = getUrl('videoplaylist', '', '', '', 'video');;
						return '<a href="'.$all_video_url.'">'.number_format($row['total_playlist_count']).'</a>';
					}
				}
			}
			return 0;
		}

		/**
		* VideoUpload::indexPageTotalVideoDownload()
		* To get video Download Total count
		* @param
		* @return
		*/
		public function indexPageTotalVideoDownload()
		{
			$sql = 'SELECT COUNT(DISTINCT(video_id)) AS total_video_download_count FROM '
					.$this->CFG['db']['tbl']['video'].
					' WHERE total_downloads > 0';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
			trigger_db_error($this->dbObj);
			if ($rs->PO_RecordCount())
			{
				if($row = $rs->FetchRow())
				{
					if($row['total_video_download_count'])
					{
						$all_video_url = getUrl('videolist','?pg=videonew', 'videonew/','','video');
						return $row['total_video_download_count'];
					}
				}
			}
			return 0;
		}
}
?>