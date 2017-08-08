<?php
/**
 * This file is to get xml code
 *
 * This file is having get xml code
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Index
 * @author 		selvaraj_35ag05
 * @copyright 	Copyright (c) 2006 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2006-05-02
 *
 **/
require_once('../common/configs/config.inc.php');

$CFG['lang']['include_files'][] = 'languages/%s/music/musicConfiguration.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['auth']['is_authenticate'] = false;
$CFG['site']['is_module_page'] = 'music';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
/**
 * XmlCode
 *
 * @package
 * @author selvaraj_35ag05
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: $
 * @access public
 **/
class XmlCode extends MusicHandler
	{
		public $populateMusicIdFromPlaylist_arr = array();

		/**
		 * XmlCode::getPlaylistOwnerId()
		 *
		 * @param mixed $playlist_id
		 * @return
		 */
		public function getPlaylistOwnerId($playlist_id)
		{
			$sql = 'SELECT user_id FROM '.$this->CFG['db']['tbl']['music_playlist'].' '.
					'WHERE playlist_id ='.$this->dbObj->Param('playlist_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($playlist_id));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if($row = $rs->FetchRow())
			{
				return $row['user_id'];
			}
			return false;

		}

		/**
		 * XmlCode::changeMusicPlaylistListened()
		 *
		 * @return
		 */
		public function changeMusicPlaylistListened()
		{
			$sql = 	' SELECT playlist_listened_id FROM '.$this->CFG['db']['tbl']['music_playlist_listened'].
					' WHERE playlist_id='.$this->dbObj->Param('playlist_id').' AND user_id='.$this->dbObj->Param('user_id').' AND'.
					' DATE_FORMAT(last_listened, \'%Y-%m-%d\') = CURDATE()';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist_id'], $this->CFG['user']['user_id']));

			$playlist_owner_id = $this->getPlaylistOwnerId($this->fields_arr['playlist_id']);

			if(!$playlist_owner_id)
				return false;

		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);
			if($rs->PO_RecordCount())
				{
					$row = $rs->FetchRow();//$rs->Free();
					$playlist_listened_id = $row['playlist_listened_id'];
					$sql =  ' UPDATE '.$this->CFG['db']['tbl']['music_playlist_listened'].' SET'.
 							' last_listened=NOW() ,'.
 							' total_visits=total_visits+1'.
							' WHERE playlist_listened_id='.$this->dbObj->Param('playlist_listened_id');

 					$stmt = $this->dbObj->Prepare($sql);
 					$rs = $this->dbObj->Execute($stmt, array($playlist_listened_id));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.
						 	$this->dbObj->ErrorMsg(), E_USER_ERROR);

				}
			else
				{
			 		$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_playlist_listened'].' SET'.
		 					' user_id='.$this->dbObj->Param('user_id').','.
		 					' playlist_owner_id='.$this->dbObj->Param('user_id').','.
							' playlist_id='.$this->dbObj->Param('playlist_id').','.
							' total_visits=1,'.
		 					' last_listened=NOW(),'.
 							' date_added=NOW() ';

 					$stmt = $this->dbObj->Prepare($sql);
 					$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $playlist_owner_id, $this->fields_arr['playlist_id']));
				    if (!$rs)
				    	trigger_db_error($this->dbObj);
			 }

		}
		/**
		 * XmlCode::populateMusicIdFromPlaylist()
		 *
		 * @return
		 **/
		public function populateMusicIdFromPlaylist()
			{
				$populateMusicIdFromPlaylist_arr = array();
				$public_condition = ' AND (m.user_id = '.$this->CFG['user']['user_id'].' OR m.music_access_type = \'Public\''.
										$this->getAdditionalQuery('m.').')'.
											$this->getAdultQuery('m.', 'music');

				$sql = 'SELECT m.music_id, m.music_title, ma.album_title, m.music_server_url,m.for_sale, '.
						'm.music_upload_type, m.music_tags, m.music_category_id, m.music_tags, m.music_thumb_ext, m.music_price, '.
						'm.playing_time, m.user_id, m.total_plays, u.user_name as artist_name, m.music_artist, ma.album_title,ma.music_album_id,ma.album_for_sale,ma.album_access_type, ma.album_price '.
				 		'FROM '.$this->CFG['db']['tbl']['music_in_playlist'].' as mpl LEFT JOIN '.$this->CFG['db']['tbl']['music'].
						' AS m ON mpl.music_id=m.music_id LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u '.
						' ON m.user_id = u.user_id LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr'.
						' ON  music_artist IN (music_artist_id) JOIN '.$this->CFG['db']['tbl']['music_files_settings'].
						' ON music_file_id = thumb_name_id JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma'.
						' ON ma.music_album_id =m.music_album_id JOIN '.$this->CFG['db']['tbl']['music_category'].' AS mc'.
						' ON mc.music_category_id =m.music_category_id  AND'.
						' mpl.playlist_id = '.$this->dbObj->Param('playlist_id').
						' WHERE u.usr_status=\'Ok\' AND m.music_status=\'Ok\''.$public_condition.
						' ORDER BY mpl.order_id ASC';


				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist_id']));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);


				$inc = 1;
				while($row = $rs->FetchRow())
					{
						$populateMusicIdFromPlaylist_arr[$inc]['music_id'] = $row['music_id'];
						$populateMusicIdFromPlaylist_arr[$inc]['music_server_url'] = $row['music_server_url'];
						$populateMusicIdFromPlaylist_arr[$inc]['music_creator_id'] = $row['user_id'];
						$populateMusicIdFromPlaylist_arr[$inc]['music_title'] = $row['music_title'];
						$populateMusicIdFromPlaylist_arr[$inc]['music_tags'] = $row['music_tags'];
						$populateMusicIdFromPlaylist_arr[$inc]['music_category_id'] = $row['music_category_id'];
						$populateMusicIdFromPlaylist_arr[$inc]['playing_time'] = $this->fmtMusicPlayingTime($row['playing_time'], true);
						$populateMusicIdFromPlaylist_arr[$inc]['music_tags'] = $row['music_tags'];
						$populateMusicIdFromPlaylist_arr[$inc]['music_upload_type'] = $row['music_upload_type'];
						$populateMusicIdFromPlaylist_arr[$inc]['user_id'] = $row['user_id'];
						$populateMusicIdFromPlaylist_arr[$inc]['music_thumb_ext'] = $row['music_thumb_ext'];
						$populateMusicIdFromPlaylist_arr[$inc]['music_artist'] = $row['artist_name'];
						$populateMusicIdFromPlaylist_arr[$inc]['music_artist_id'] = $row['music_artist'];
						$populateMusicIdFromPlaylist_arr[$inc]['music_album'] = $row['album_title'];
						$populateMusicIdFromPlaylist_arr[$inc]['music_album_id'] = $row['music_album_id'];
						$populateMusicIdFromPlaylist_arr[$inc]['total_plays'] = $row['total_plays'];

						//START O CHECK THE MUSIC/ALBUM IS FOR SALE. IF IT IS MARKED AS SALE THEN BUY LINK WILL BE AVAILABLE
						$populateMusicIdFromPlaylist_arr[$inc]['for_sale'] = $row['for_sale'];
						$populateMusicIdFromPlaylist_arr[$inc]['album_for_sale'] = 'No';
						$populateMusicIdFromPlaylist_arr[$inc]['buy_url'] = '';
						$populateMusicIdFromPlaylist_arr[$inc]['music_price'] = 'Free';
						if($this->CFG['admin']['musics']['allowed_usertypes_to_upload_for_sale']!='None')
							$populateMusicDetails_arr[$inc]['music_price'] = $this->LANG['Free'];
						else
							$populateMusicDetails_arr[$inc]['music_price'] = '';
						$populateMusicIdFromPlaylist_arr[$inc]['album_price'] = '';
						if($row['album_for_sale']=='Yes'
							and $row['album_access_type']=='Private'
							and $row['album_price']>0)
						{
							$populateMusicIdFromPlaylist_arr[$inc]['for_sale'] = 'No';
							$populateMusicIdFromPlaylist_arr[$inc]['album_for_sale'] = $row['album_for_sale'];
							$populateMusicIdFromPlaylist_arr[$inc]['music_price'] = $this->CFG['currency'].$row['album_price'];
							$populateMusicIdFromPlaylist_arr[$inc]['album_price'] = $this->CFG['currency'].$row['album_price'].'*';
							if(!isUserAlbumPurchased($row['music_album_id']) AND $row['user_id']!=$this->CFG['user']['user_id'])
								$populateMusicIdFromPlaylist_arr[$inc]['buy_url'] = $this->CFG['site']['url'].'music/musicUpdateAddToCart.php?album_id='.$row['music_album_id'].'&page=player';

						}
						else if($populateMusicIdFromPlaylist_arr[$inc]['for_sale']=='Yes')
						{
							$populateMusicIdFromPlaylist_arr[$inc]['music_price'] = $this->CFG['currency'].$row['music_price'];
							if(!isUserPurchased($row['music_id']) AND $row['user_id']!=$this->CFG['user']['user_id'])
								$populateMusicIdFromPlaylist_arr[$inc]['buy_url'] = $this->CFG['site']['url'].'music/musicUpdateAddToCart.php?music_id='.$row['music_id'].'&page=player';
						}
						//END O CHECK THE MUSIC/ALBUM IS FOR SALE. IF IT IS MARKED AS SALE THEN BUY LINK WILL BE AVAILABLE

						$inc++;
					}
				return $populateMusicIdFromPlaylist_arr;
			}

		/**
		 * XmlCode::getBestLyric()
		 *
		 * @param mixed $music_id
		 * @return
		 */
		public function getBestLyric($music_id)
		{
			$sql = 'SELECT music_lyric_id FROM '.$this->CFG['db']['tbl']['music_lyric'].
					' WHERE best_lyric = \'Yes\' AND lyric_status = \'Yes\''.
					' AND music_id='.$this->dbObj->Param('music_id');;

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($music_id));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);

			$music_lyric_id = '';
			if($row = $rs->FetchRow())
				{
					$music_lyric_id = $row['music_lyric_id'];
				}
			return $music_lyric_id;
		}

		/**
		 * XmlCode::populateMusicDetails()
		 *
		 * @return array
		 **/
		public function populateMusicDetails($status)
			{
				$populateMusicDetails_arr = array();
				$cond = $status?'music_status=\'Ok\'':'music_status!=\'Ok\'';
				$public_condition = ' AND (m.user_id = '.$this->CFG['user']['user_id'].' OR m.music_access_type = \'Public\''.
										$this->getAdditionalQuery('m.').')'.
											$this->getAdultQuery('m.', 'music');

				$inc = 1;
				$mid_arr = explode(',', $this->fields_arr['mid']);
				foreach($mid_arr as $music_id)
					{
						$sql = 'SELECT m.music_id, m.user_id, u.user_name, m.music_ext,m.for_sale, '.
								'm.music_title, m.music_server_url, m.thumb_width, '.
								'm.thumb_height, m.total_views, m.music_tags, m.music_upload_type,m.music_price, '.
								'(m.rating_total/m.rating_count) as rating, m.playing_time, '.
								'm.music_thumb_ext, ma.album_title,ma.music_album_id,ma.album_for_sale,ma.album_access_type, ma.album_price, m.music_category_id, '.
								'm.rating_count, m.total_plays, mc.music_category_name, u.user_name as artist_name, m.music_artist '.
								'FROM '.$this->CFG['db']['tbl']['music'].' as m JOIN '.$this->CFG['db']['tbl']['users'].' as u '.
								' on m.user_id = u.user_id LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr'.
								' ON  music_artist IN (music_artist_id) JOIN '.$this->CFG['db']['tbl']['music_files_settings'].
								' ON music_file_id = thumb_name_id JOIN '.$this->CFG['db']['tbl']['music_album'].' as ma'.
								' ON ma.music_album_id =m.music_album_id JOIN '.$this->CFG['db']['tbl']['music_category'].' as mc'.
								' ON mc.music_category_id =m.music_category_id '.
								' WHERE '.$cond.' AND music_id='.$this->dbObj->Param('music_id').$public_condition;


						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($music_id));
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.
								$this->dbObj->ErrorMsg(), E_USER_ERROR);

						if($row = $rs->FetchRow())
							{
								$populateMusicDetails_arr[$inc]['music_id'] = $music_id;
								$populateMusicDetails_arr[$inc]['music_server_url'] = $row['music_server_url'];
								$populateMusicDetails_arr[$inc]['music_creator_id'] = $row['user_id'];
								$populateMusicDetails_arr[$inc]['music_title'] = $row['music_title'];
								$populateMusicDetails_arr[$inc]['music_tags'] = $row['music_tags'];
								$populateMusicDetails_arr[$inc]['music_category_id'] = $row['music_category_id'];
								$populateMusicDetails_arr[$inc]['music_category_name'] = $row['music_category_name'];
								$populateMusicDetails_arr[$inc]['music_artist'] = $row['artist_name'];
								$populateMusicDetails_arr[$inc]['music_artist_id'] = $row['music_artist'];
								$populateMusicDetails_arr[$inc]['music_album'] = $row['album_title'];
								$populateMusicDetails_arr[$inc]['music_album_id'] = $row['music_album_id'];
								$populateMusicDetails_arr[$inc]['playing_time'] = $this->fmtMusicPlayingTime($row['playing_time'], true);
								$populateMusicDetails_arr[$inc]['total_plays'] = $row['total_plays'];
								$populateMusicDetails_arr[$inc]['music_tags'] = $row['music_tags'];
								$populateMusicDetails_arr[$inc]['music_upload_type'] = $row['music_upload_type'];
								$populateMusicDetails_arr[$inc]['user_id'] = $row['user_id'];
								$populateMusicDetails_arr[$inc]['music_thumb_ext'] = $row['music_thumb_ext'];

								//START O CHECK THE MUSIC/ALBUM IS FOR SALE. IF IT IS MARKED AS SALE THEN BUY LINK WILL BE AVAILABLE
								$populateMusicDetails_arr[$inc]['for_sale'] = $row['for_sale'];
								$populateMusicDetails_arr[$inc]['album_for_sale'] = 'No';
								$populateMusicDetails_arr[$inc]['buy_url'] = '';
								if($this->CFG['admin']['musics']['allowed_usertypes_to_upload_for_sale']!='None')
									$populateMusicDetails_arr[$inc]['music_price'] = $this->LANG['Free'];
								else
									$populateMusicDetails_arr[$inc]['music_price'] = '';
								$populateMusicDetails_arr[$inc]['album_price'] = '';
								if($row['album_for_sale']=='Yes'
									and $row['album_access_type']=='Private'
									and $row['album_price']>0)
								{
									$populateMusicDetails_arr[$inc]['for_sale'] = 'No';

									$populateMusicDetails_arr[$inc]['album_for_sale'] = $row['album_for_sale'];
									$populateMusicDetails_arr[$inc]['music_price'] = $this->CFG['currency'].$row['album_price'];
									$populateMusicDetails_arr[$inc]['album_price'] = $this->CFG['currency'].$row['album_price'].'*';
									if(!isUserAlbumPurchased($row['music_album_id']) AND $row['user_id']!=$this->CFG['user']['user_id'])
										$populateMusicDetails_arr[$inc]['buy_url'] = $this->CFG['site']['url'].'music/musicUpdateAddToCart.php?album_id='.$row['music_album_id'].'&page=player';

								}
								else if($populateMusicDetails_arr[$inc]['for_sale']=='Yes')
								{
									$populateMusicDetails_arr[$inc]['music_price'] = $this->CFG['currency'].$row['music_price'];
									if(!isUserPurchased($row['music_id']) AND $row['user_id']!=$this->CFG['user']['user_id'])
										$populateMusicDetails_arr[$inc]['buy_url'] = $this->CFG['site']['url'].'music/musicUpdateAddToCart.php?music_id='.$row['music_id'].'&page=player';
								}
								//END O CHECK THE MUSIC/ALBUM IS FOR SALE. IF IT IS MARKED AS SALE THEN BUY LINK WILL BE AVAILABLE

								$inc++;
							}
					}
				return $populateMusicDetails_arr;
			}

		/**
		 * XmlCode::populateMusicFeaturedDetails()
		 *
		 * @return array
		 **/
		public function populateMusicFeaturedDetails()
			{
				$populateMusicDetails_arr = array();
				$cond = 'music_status=\'Ok\'';
				$public_condition = ' AND (m.user_id = '.$this->CFG['user']['user_id'].' OR m.music_access_type = \'Public\''.
										$this->getAdditionalQuery('m.').')'.
											$this->getAdultQuery('m.', 'music');
				$inc = 1;
				/*$mid_arr = explode(',', $this->fields_arr['mid']);
				foreach($mid_arr as $music_id)
					{*/

					$sql = 'SELECT m.music_id, m.user_id, u.user_name, m.music_ext,m.for_sale,'.
								'm.music_title,m.music_price, m.music_server_url, m.thumb_width, '.
								'm.thumb_height, m.total_views, m.music_tags, m.music_upload_type, '.
								'(m.rating_total/m.rating_count) as rating, m.playing_time, '.
								'm.music_thumb_ext, ma.album_title,ma.music_album_id,ma.album_for_sale,ma.album_access_type,
								 ma.album_price, m.music_category_id, m.featured_music_order_id, '.
								'm.rating_count, m.total_plays, mc.music_category_name, u.user_name as artist_name, m.music_artist '.
								'FROM '.$this->CFG['db']['tbl']['music'].' as m JOIN '.$this->CFG['db']['tbl']['users'].' as u '.
								' on m.user_id = u.user_id LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr'.
								' ON  music_artist IN (music_artist_id) JOIN '.$this->CFG['db']['tbl']['music_files_settings'].
								' ON music_file_id = thumb_name_id JOIN '.$this->CFG['db']['tbl']['music_album'].' as ma'.
								' ON ma.music_album_id =m.music_album_id JOIN '.$this->CFG['db']['tbl']['music_category'].' as mc'.
								' ON mc.music_category_id =m.music_category_id '.
								' WHERE '.$cond.' AND music_featured= \'Yes\''.$public_condition.' ORDER BY m.featured_music_order_id ASC';


						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.
								$this->dbObj->ErrorMsg(), E_USER_ERROR);

						while($row = $rs->FetchRow())
							{
								$populateMusicDetails_arr[$inc]['music_id'] = $row['music_id'];
								$populateMusicDetails_arr[$inc]['music_server_url'] = $row['music_server_url'];
								$populateMusicDetails_arr[$inc]['music_creator_id'] = $row['user_id'];
								$populateMusicDetails_arr[$inc]['music_title'] = $row['music_title'];
								$populateMusicDetails_arr[$inc]['music_tags'] = $row['music_tags'];
								$populateMusicDetails_arr[$inc]['music_category_id'] = $row['music_category_id'];
								$populateMusicDetails_arr[$inc]['music_category_name'] = $row['music_category_name'];
								$populateMusicDetails_arr[$inc]['music_artist'] = $row['artist_name'];
								$populateMusicDetails_arr[$inc]['music_artist_id'] = $row['music_artist'];
								$populateMusicDetails_arr[$inc]['music_album'] = $row['album_title'];
								$populateMusicDetails_arr[$inc]['music_album_id'] = $row['music_album_id'];
								$populateMusicDetails_arr[$inc]['playing_time'] = $this->fmtMusicPlayingTime($row['playing_time'], true);
								$populateMusicDetails_arr[$inc]['total_plays'] = $row['total_plays'];
								$populateMusicDetails_arr[$inc]['music_tags'] = $row['music_tags'];
								$populateMusicDetails_arr[$inc]['music_upload_type'] = $row['music_upload_type'];
								$populateMusicDetails_arr[$inc]['user_id'] = $row['user_id'];
								$populateMusicDetails_arr[$inc]['music_thumb_ext'] = $row['music_thumb_ext'];

								//START TO CHECK THE MUSIC/ALBUM IS FOR SALE. IF IT IS MARKED AS SALE THEN BUY LINK WILL BE AVAILABLE
								$populateMusicDetails_arr[$inc]['for_sale'] = $row['for_sale'];
								$populateMusicDetails_arr[$inc]['album_for_sale'] = 'No';
								$populateMusicDetails_arr[$inc]['buy_url'] = '';
								$populateMusicDetails_arr[$inc]['music_price'] = $this->LANG['Free'];
								if($this->CFG['admin']['musics']['allowed_usertypes_to_upload_for_sale']!='None')
									$populateMusicDetails_arr[$inc]['music_price'] = $this->LANG['Free'];
								else
									$populateMusicDetails_arr[$inc]['music_price'] = '';
								$populateMusicDetails_arr[$inc]['album_price'] = '';
								if($row['album_for_sale']=='Yes'
									and $row['album_access_type']=='Private'
									and $row['album_price']>0)
								{
									$populateMusicDetails_arr[$inc]['for_sale'] = 'No';
									$populateMusicDetails_arr[$inc]['album_for_sale'] = $row['album_for_sale'];
									$populateMusicDetails_arr[$inc]['music_price'] = $this->CFG['currency'].$row['album_price'];
									$populateMusicDetails_arr[$inc]['album_price'] = $this->CFG['currency'].$row['album_price'].'*';
									if(!isUserAlbumPurchased($row['music_album_id']) AND $row['user_id']!=$this->CFG['user']['user_id'])
										$populateMusicDetails_arr[$inc]['buy_url'] = $this->CFG['site']['url'].'music/musicUpdateAddToCart.php?album_id='.$row['music_album_id'].'&page=player';

								}
								else if($populateMusicDetails_arr[$inc]['for_sale']=='Yes')
								{
									$populateMusicDetails_arr[$inc]['music_price'] = $this->CFG['currency'].$row['music_price'];
									if(!isUserPurchased($row['music_id']) AND $row['user_id']!=$this->CFG['user']['user_id'])
										$populateMusicDetails_arr[$inc]['buy_url'] = $this->CFG['site']['url'].'music/musicUpdateAddToCart.php?music_id='.$row['music_id'].'&page=player';
								}
								//END TO CHECK THE MUSIC/ALBUM IS FOR SALE. IF IT IS MARKED AS SALE THEN BUY LINK WILL BE AVAILABLE

								$inc++;
							}
					//}

				return $populateMusicDetails_arr;
			}

		/**
		 * XmlCode::populateMusicFeaturedDetails()
		 *
		 * @return array
		 **/
		public function populateMusicUserFeaturedDetails()
			{
				$populateMusicDetails_arr = array();
				$cond = 'music_status=\'Ok\'';
				$public_condition = ' AND (m.user_id = '.$this->CFG['user']['user_id'].' OR m.music_access_type = \'Public\''.
										$this->getAdditionalQuery('m.').')'.
											$this->getAdultQuery('m.', 'music');
				$inc = 1;
				/*$mid_arr = explode(',', $this->fields_arr['mid']);
				foreach($mid_arr as $music_id)
					{*/

				$condition = 'music_status=\'Ok\''.$this->getAdultQuery('v.', 'music').' AND vf.user_id=\''.$this->fields_arr['user_id'].'\''.
				' AND (v.user_id = '.$this->CFG['user']['user_id'].
				' OR music_access_type = \'Public\''.$this->getAdditionalQuery('v.').')';
				$sql = 'SELECT v.music_id,v.music_title,music_category_id, v.music_artist, v.music_album_id, music_ext, music_tags,v.medium_width, v.medium_height, v.thumb_width, v.thumb_height, music_server_url,music_title,'.
					' ma.album_access_type,u.user_id,v.total_plays, u.user_name as artist_name, ma.album_for_sale, ma.album_price, v.for_sale, v.music_price, v.featured_music_order_id, '.
					' ma.album_title, TIMEDIFF(NOW(), v.date_added) as date_added, TIME_FORMAT(playing_time,\'%H:%i:%s\') as playing_time, total_views,music_thumb_ext,mfs.file_name '.
					' FROM '.$this->CFG['db']['tbl']['music'].' AS v  JOIN '.
					$this->CFG['db']['tbl']['users'].' as u ON u.user_id=v.user_id JOIN '.
					$this->CFG['db']['tbl']['music_featured'].' as vf ON vf.music_id=v.music_id '.
					' LEFT JOIN '.$this->CFG['db']['tbl']['music_album'].
					' AS ma on ma.music_album_id=v.music_album_id JOIN '.
					$this->CFG['db']['tbl']['music_files_settings'].
					' AS mfs ON mfs.music_file_id = v.thumb_name_id WHERE '.$condition.' ORDER BY'.
					' v.featured_music_order_id ASC';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.
								$this->dbObj->ErrorMsg(), E_USER_ERROR);

						while($row = $rs->FetchRow())
							{
								$populateMusicDetails_arr[$inc]['music_id'] = $row['music_id'];
								$populateMusicDetails_arr[$inc]['music_server_url'] = $row['music_server_url'];
								$populateMusicDetails_arr[$inc]['music_creator_id'] = $row['user_id'];
								$populateMusicDetails_arr[$inc]['music_title'] = $row['music_title'];
								$populateMusicDetails_arr[$inc]['music_tags'] = $row['music_tags'];
								$populateMusicDetails_arr[$inc]['music_category_id'] = $row['music_category_id'];
								$populateMusicDetails_arr[$inc]['music_artist'] = $row['artist_name'];
								$populateMusicDetails_arr[$inc]['music_artist_id'] = $row['music_artist'];
								$populateMusicDetails_arr[$inc]['music_album'] = $row['album_title'];
								$populateMusicDetails_arr[$inc]['music_album_id'] = $row['music_album_id'];
								$populateMusicDetails_arr[$inc]['playing_time'] = $this->fmtMusicPlayingTime($row['playing_time'], true);
								$populateMusicDetails_arr[$inc]['total_plays'] = $row['total_plays'];
								$populateMusicDetails_arr[$inc]['music_tags'] = $row['music_tags'];
								$populateMusicDetails_arr[$inc]['user_id'] = $row['user_id'];
								$populateMusicDetails_arr[$inc]['music_thumb_ext'] = $row['music_thumb_ext'];

								//START TO CHECK THE MUSIC/ALBUM IS FOR SALE. IF IT IS MARKED AS SALE THEN BUY LINK WILL BE AVAILABLE
								$populateMusicDetails_arr[$inc]['for_sale'] = $row['for_sale'];
								$populateMusicDetails_arr[$inc]['album_for_sale'] = 'No';
								$populateMusicDetails_arr[$inc]['buy_url'] = '';
								$populateMusicDetails_arr[$inc]['music_price'] = $this->LANG['Free'];
								if($this->CFG['admin']['musics']['allowed_usertypes_to_upload_for_sale']!='None')
									$populateMusicDetails_arr[$inc]['music_price'] = $this->LANG['Free'];
								else
									$populateMusicDetails_arr[$inc]['music_price'] = '';
								$populateMusicDetails_arr[$inc]['album_price'] = '';
								if($row['album_for_sale']=='Yes'
									and $row['album_access_type']=='Private'
									and $row['album_price']>0)
								{
									$populateMusicDetails_arr[$inc]['for_sale'] = 'No';
									$populateMusicDetails_arr[$inc]['album_for_sale'] = $row['album_for_sale'];
									$populateMusicDetails_arr[$inc]['music_price'] = $this->CFG['currency'].$row['album_price'];
									$populateMusicDetails_arr[$inc]['album_price'] = $this->CFG['currency'].$row['album_price'].'*';
									if(!isUserAlbumPurchased($row['music_album_id']) AND $row['user_id']!=$this->CFG['user']['user_id'])
										$populateMusicDetails_arr[$inc]['buy_url'] = $this->CFG['site']['url'].'music/musicUpdateAddToCart.php?album_id='.$row['music_album_id'].'&page=player';

								}
								else if($populateMusicDetails_arr[$inc]['for_sale']=='Yes')
								{
									$populateMusicDetails_arr[$inc]['music_price'] = $this->CFG['currency'].$row['music_price'];
									if(!isUserPurchased($row['music_id']) AND $row['user_id']!=$this->CFG['user']['user_id'])
										$populateMusicDetails_arr[$inc]['buy_url'] = $this->CFG['site']['url'].'music/musicUpdateAddToCart.php?music_id='.$row['music_id'].'&page=player';
								}
								//END TO CHECK THE MUSIC/ALBUM IS FOR SALE. IF IT IS MARKED AS SALE THEN BUY LINK WILL BE AVAILABLE

								$inc++;
							}
					//}

				return $populateMusicDetails_arr;
			}

		/**
		 * XmlCode::selectMusicAddSettings()
		 *
		 * @return void
		 **/
		public function selectMusicAdSettings($musicFeatured = false)
			{
				$this->CFG['admin']['musics']['TailUrlUrl'] = $this->CFG['admin']['musics']['TailUrlTargetUrl'] =
					$this->CFG['admin']['musics']['TopUrlUrl'] = $this->CFG['admin']['musics']['TopUrlTargetUrl'] =
						$this->CFG['admin']['musics']['TopAudioUrl'] = $this->CFG['admin']['musics']['TailAudioUrl'] =
							$this->CFG['admin']['musics']['Topduration'] = $this->CFG['admin']['musics']['Tailduration'] =
								$this->CFG['admin']['musics']['TopImageUrl'] = $this->CFG['admin']['musics']['TailImageUrl'] = '';

				if($this->music_ad)
					return;
				if($musicFeatured)
					$musicDetails_arr = $this->populateMusicFeaturedDetails();
				elseif(!empty($this->fields_arr['mid']))
					$musicDetails_arr = $this->populateMusicDetails(true);
				else
					$musicDetails_arr = $this->populateMusicIdFromPlaylist();

				//$musicPlaylist = $this->populateMusicIdFromPlaylist();
				$categoryId = '';
				for($i=1; $i <= count($musicDetails_arr);$i++){
					$categoryId .= $musicDetails_arr[$i]['music_category_id'].',';
				}
				$categoryIds = explode(',',substr($categoryId,0,-1));

				$findinCondition = '';
				foreach($categoryIds as $categoryId){
					if(!empty($categoryId))
						$findinCondition .= '(FIND_IN_SET('.$categoryId.',advertisement_channel)) OR ';
				}

				$user_condn = ' 1 AND ';

				$add_fields = 'advertisement_id, advertisement_url, advertisement_duration, advertisement_channel, advertisement_image_ext,'.
						' advertisement_audio_ext, advertisement_show_at';

				$default_cond = ' advertisement_id!=\'\' AND advertisement_status=\'Activate\' AND (advertisement_audio_ext!=\'\' OR advertisement_image_ext!=\'\') AND '.
									' ('.$findinCondition.' (advertisement_channel=\'\')) AND ';


				$sql = 'SELECT '.$add_fields.' FROM '.$this->CFG['db']['tbl']['music_advertisement'].
						' WHERE'.$user_condn.$default_cond.' (advertisement_show_at=\'Begining\' OR advertisement_show_at=\'Both\')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$total_records = $rs->PO_RecordCount();
				if($total_records)
					{
						$selected = rand(1, $total_records);
						$i = 1;
						while($row = $rs->FetchRow())
							{
								if($i != $selected)
									{
										$i++;
										continue;
									}

								if($row['advertisement_audio_ext'] != '')
									$this->CFG['admin']['musics']['TopAudioUrl'] = $this->CFG['site']['url'].$this->CFG['admin']['musics']['advertisement_audio_folder'].$row['advertisement_id'].'.'.$row['advertisement_audio_ext'];

								if($row['advertisement_image_ext'] != '')
									$this->CFG['admin']['musics']['TopImageUrl'] = $this->CFG['site']['url'].$this->CFG['admin']['musics']['advertisement_image_folder'].$row['advertisement_id'].$this->CFG['admin']['musics']['advertisement_image_playlist_name'].'.'.$row['advertisement_image_ext'];
								elseif($row['advertisement_audio_ext'] != '' && $row['advertisement_image_ext'] == '')
									$this->CFG['admin']['musics']['TopImageUrl'] = $this->CFG['site']['url'].'music/design/templates/'.
																				     $this->CFG['html']['template']['default'].'/root/images/'.
																					    $this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_playlistPlayerAd.jpg';

								$this->CFG['admin']['musics']['TopUrlTargetUrl'] = $row['advertisement_url'];
								$this->CFG['admin']['musics']['Topduration']  = $row['advertisement_duration']!=0?$row['advertisement_duration']:2;

								break;
							}
					}

				$sql = 'SELECT '.$add_fields.' FROM '.$this->CFG['db']['tbl']['music_advertisement'].
						' WHERE'.$user_condn.$default_cond.' (advertisement_show_at=\'Ending\' OR advertisement_show_at=\'Both\')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$total_records = $rs->PO_RecordCount();
				if($total_records)
					{
						$selected = rand(1, $total_records);
						$i = 1;
						while($row = $rs->FetchRow())
							{
								if($i != $selected)
									{
										$i++;
										continue;
									}
								if($row['advertisement_audio_ext'] != '')
									$this->CFG['admin']['musics']['TailAudioUrl'] = $this->CFG['site']['url'].$this->CFG['admin']['musics']['advertisement_audio_folder'].$row['advertisement_id'].'.'.$row['advertisement_audio_ext'];

								if($row['advertisement_image_ext'] != '')
									$this->CFG['admin']['musics']['TailImageUrl'] = $this->CFG['site']['url'].$this->CFG['admin']['musics']['advertisement_image_folder'].$row['advertisement_id'].$this->CFG['admin']['musics']['advertisement_image_playlist_name'].'.'.$row['advertisement_image_ext'];
								elseif($row['advertisement_audio_ext'] != '' && $row['advertisement_image_ext'] == '')
									$this->CFG['admin']['musics']['TailImageUrl'] = $this->CFG['site']['url'].'music/design/templates/'.
																				     $this->CFG['html']['template']['default'].'/root/images/'.
																					    $this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_playlistPlayerAd.jpg';

								$this->CFG['admin']['musics']['Tailduration']  = $row['advertisement_duration']!=0?$row['advertisement_duration']:2;
								$this->CFG['admin']['musics']['TailUrlTargetUrl'] = $row['advertisement_url'];

								/*$this->CFG['admin']['musics']['TailUrlType'] = $$row['advertisement_ext'];
								if($row['advertisement_duration']>=10)
									$row['advertisement_duration'] = '00:00:'.$row['advertisement_duration'];
								else
									$row['advertisement_duration'] = '00:00:0'.$row['advertisement_duration'];
								$this->CFG['admin']['musics']['TailUrlDuration'] = $row['advertisement_duration'];*/
								break;
							}
					}
			}

		/**
		 * XmlCode::populateMusicDetails()
		 *
		 * @return void
		 **/
		public function getXmlCode()
			{
				$this->music_ad = false;
				$fields = explode('_', $this->fields_arr['pg']);
				$this->fields_arr['pg'] = $fields[0];
				$musicFeatured = false;
				if($this->fields_arr['pg'] == 'musicfeatured'){
					$this->fields_arr['pg'] = 'music';
					$musicFeatured = true;
				}
				if($this->fields_arr['pg'] == 'musichidden'){
					$this->fields_arr['pg'] = 'music';
					$this->music_ad = true;
				}

				if(isset($fields[1]))
					$this->fields_arr['playlist_id'] = $fields[1];

				if(isset($fields[2]))
					$this->fields_arr['mid'] = $fields[2];

				if(isset($fields[3]))
					$this->fields_arr['ref'] = $fields[3];

				if(isset($fields[4]))
					$this->fields_arr['user_id'] = $fields[4];

				if(!($this->fields_arr['pg']) and (!$this->fields_arr['playlist_id'] or !$this->fields_arr['mid']))
					{
						return;
					}

				$sharing_url = '';
				$configPlayListXmlcode_url = '';
				$end_list = $next_list = 0;
				//$this->selectMusicPlayerSettings();
				$thumbnail = '';

				switch($this->fields_arr['pg'])
					{
						case 'music':
							if($musicFeatured)
								$musicDetails_arr = $this->populateMusicFeaturedDetails();
							elseif(!empty($this->fields_arr['mid']))
								$musicDetails_arr = $this->populateMusicDetails(true);
							elseif(!empty($this->fields_arr['user_id']))
								$musicDetails_arr = $this->populateMusicUserFeaturedDetails(true);
							else
							{
								$musicDetails_arr = $this->populateMusicIdFromPlaylist();
								//ADDED THE RECORD FOR PLAYLIST LISTENED
								if($this->CFG['user']['user_id']!=0)
									$this->changeMusicPlaylistListened();
							}

							$musiclist_arr = array();
							$inc = 0;
							foreach($musicDetails_arr as $music_details_arr)
								{
									$music_details_arr['music_url'] = '';

									//POPULATE THE BEST LYRIC URL
									$music_details_arr['music_lyric_id'] = $this->getBestLyric($music_details_arr['music_id']);
									$musiclist_arr[$inc]['music_lyric_url'] = '';
									if($music_details_arr['music_lyric_id'])
									{
										$musiclist_arr[$inc]['music_lyric_url'] = getUrl('viewlyrics', '?music_id='.$music_details_arr['music_id'].'&amp;music_lyric_id='.$music_details_arr['music_lyric_id'].'&amp;page=player', '?music_id='.$music_details_arr['music_id'].'&amp;music_lyric_id='.$music_details_arr['music_lyric_id'].'&amp;page=player', '', 'music');
										$musiclist_arr[$inc]['music_lyric_url'] = "javascript:window.open('".$musiclist_arr[$inc]['music_lyric_url']."','popper1','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, copyhistory=no, resizable=yes,height=405,width=475,minHeight=405,minWidth=475');newWindow.focus(); void(0);";
									}

									$music_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['music_folder'].'/';
									$musiclist_arr[$inc]['albumPath'] = '';
									if(!empty($music_details_arr['music_album_id']))
										$musiclist_arr[$inc]['albumPath'] = getUrl('viewalbum','?album_id='.$music_details_arr['music_album_id'].'&title='.$this->changeTitle($music_details_arr['music_album']), $music_details_arr['music_album_id'].'/'.$this->changeTitle($music_details_arr['music_album']).'/', '','music');

									$musiclist_arr[$inc]['artistName'] =$music_details_arr['music_artist'];
									$musiclist_arr[$inc]['artistPath'] = '';
									if(!empty($music_details_arr['music_id']))
										$musiclist_arr[$inc]['musicTitlePath'] = getUrl('viewmusic', '?music_id='.$music_details_arr['music_id'].'&title='.$this->changeTitle($music_details_arr['music_title']), $music_details_arr['music_id'].'/'.$this->changeTitle($music_details_arr['music_title']).'/', '', 'music');
									//Modified the music_url value to music id to get the mp3 infor from another page
									$musiclist_arr[$inc]['music_url'] = $music_details_arr['music_id'];



										/*$sharing_url = getUrl('sharemusic','', '','','music');
										$sharing_args='music_id='.$this->fields_arr['mid'].'&amp;page=music';
										$full_screen_url = getUrl('viewmusicfull','?music_id='.$this->fields_arr['mid'].'&pg=music', $this->fields_arr['mid'].'/?pg=music', '','');*/

										if($music_details_arr['music_thumb_ext'] != '')
											{
												$musiclist_arr[$inc]['thumbnail'] = $music_details_arr['music_server_url'].$this->CFG['media']['folder'].'/'.
																						$this->CFG['admin']['musics']['folder'].'/'.
																							$this->CFG['admin']['musics']['thumbnail_folder'].'/'.
																								getMusicImageName($music_details_arr['music_id']).
																									$this->CFG['admin']['musics']['medium_name'].'.'.
																										$music_details_arr['music_thumb_ext'];
											}
										else
											{
												$musiclist_arr[$inc]['thumbnail'] = $this->CFG['site']['url'].'music/design/templates/'.
																						$this->CFG['html']['template']['default'].'/root/images/'.
																							$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_audio_PlaylistPlayer.jpg';
											}
										$inc++;
								}
							$this->selectMusicAdSettings($musicFeatured);
							break;
					}
if (count($musiclist_arr))
{
?>

<PATH>
	<SONGS>
<?php
	$inc = 1;
	foreach($musiclist_arr as $musics_arr)
		{
		?>
		<SONGSET>
			<PREROLL songUrl="<?php echo $this->CFG['admin']['musics']['TopAudioUrl'];?>" imageUrl = "<?php echo $this->CFG['admin']['musics']['TopImageUrl'];?>" imageTime="<?php echo $this->CFG['admin']['musics']['Topduration'];?>"  TargetUrl="<?php echo $this->CFG['admin']['musics']['TopUrlTargetUrl'];?>" TargetWindow="_blank"/>
			<SONG Path="" TokenNumber="<?php echo $musics_arr['music_url']; ?>" TokenId="true" Title="<?php echo $musicDetails_arr[$inc]['music_title']; ?>" Artist="<?php echo $musics_arr['artistName']; ?>" Album="<?php echo $musicDetails_arr[$inc]['music_album']; ?>" Plays="<?php echo $musicDetails_arr[$inc]['total_plays']; ?>" showPlays="true" BuyUrl="<?php echo $musicDetails_arr[$inc]['buy_url']; ?>" LyricsUrl="<?php echo $musics_arr['music_lyric_url']; ?>"  Rate="http://rateUrl.com" Comments="http://comments.h" ImageUrl="<?php echo $musics_arr['thumbnail']; ?>" TargetUrl = "<?php echo $musics_arr['musicTitlePath']; ?>" Target="_blank" downloadUrl="http://google.com" DownloadTarget="_blank" showDownload="<?php echo $this->CFG['admin']['musics']['download_option'];?>" songDuration="<?php echo $musicDetails_arr[$inc]['playing_time']; ?>" id="<?php echo $musicDetails_arr[$inc]['music_id']; ?>" addUrl="add url..11111....." checkUrl="<?php echo $this->CFG['site']['url'].'music/musicUpdateQuickMix.php?music_id='.$musicDetails_arr[$inc]['music_id'].'&add_id=1';?>" unCheckUrl="<?php echo $this->CFG['site']['url'].'music/musicUpdateQuickMix.php?music_id='.$musicDetails_arr[$inc]['music_id'].'&remove_it=1';?>" Type="mp3" getTitlePath="<?php echo $musics_arr['musicTitlePath']; ?>" getTitleTarget="_blank" getArtistPath="<?php echo $musics_arr['artistPath']; ?>" getArtistTarget="_blank" getAlbumPath="<?php echo $musics_arr['albumPath']; ?>" getAlbumTarget="_blank" triggerUrl="<?php echo $this->CFG['site']['music_url'].'triggerMusicStats.php';?>" checkedStatus="true" SongCost="<?php echo $musicDetails_arr[$inc]['music_price']; ?>" AlbumCost="<?php echo $musicDetails_arr[$inc]['album_price'];?>"/>
			<POSTROLL songUrl="<?php echo $this->CFG['admin']['musics']['TailAudioUrl'];?>" imageUrl = "<?php echo $this->CFG['admin']['musics']['TailImageUrl'];?>" imageTime="<?php echo $this->CFG['admin']['musics']['Tailduration'];?>"  TargetUrl="<?php echo $this->CFG['admin']['musics']['TailUrlTargetUrl'];?>" TargetWindow="_blank"/>
		</SONGSET>
		<?php
			$inc++;
		}
?>
	</SONGS>
</PATH>
<?php
} //end of if count
?>
<IMAGES>
     <IMAGE url = "<?php echo $this->CFG['site']['url'] ?>files/flash/music/bg-musicblock.gif" TargetUrl="<?php echo $this->CFG['site']['url'] ?>" TargetWindow="_parent"/>
</IMAGES>
<?php
			}


	}
//<<<<<-------------- Class XmlCode begins ---------------//
//-------------------- Code begins -------------->>>>>//
$XmlCode = new XmlCode();
setHeaderStart($check_login=false);
$XmlCode->setDBObject($db);
$CFG['user']['user_id'] = isset($_SESSION['user']['user_id'])?$_SESSION['user']['user_id']:'0';
$XmlCode->makeGlobalize($CFG,$LANG);

$CFG['admin']['is_logged_in'] = isset($_SESSION['admin']['is_logged_in'])?$_SESSION['admin']['is_logged_in']:'0';

$XmlCode->setPageBlockNames(array('get_code_form'));
//default form fields and values...
$XmlCode->setFormField('playlist_id', '');
$XmlCode->setFormField('mid', ''); //Comma separated
$XmlCode->setFormField('pg', '');
$XmlCode->setFormField('gurl', '');
$XmlCode->setFormField('ref', '0');
$XmlCode->setFormField('next_url', '');
$XmlCode->setFormField('full', false);
$XmlCode->setPageBlockShow('get_code_form');
$XmlCode->sanitizeFormInputs($_GET);
$XmlCode->external_site=false;
if(isset($_GET['ext_site']))
	$XmlCode->external_site=true;
//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($XmlCode->isShowPageBlock('get_code_form'))
    {
		$XmlCode->getXmlCode();
	}
//<<<<<-------------------- Page block templates ends -------------------//
setHeaderEnd();
//require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');
?>