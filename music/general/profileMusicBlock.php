<?php
/**
* profilePageMusicHandler
*
* @package
* @author
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
* @version $Id$
* @access public
*/
global $CFG;
require_once($CFG['site']['project_path'].'common/classes/class_FormHandler.lib.php');
require_once($CFG['site']['project_path'].'common/classes/class_MediaHandler.lib.php');
require_once($CFG['site']['project_path'].'common/classes/class_MusicHandler.lib.php');
require_once($CFG['site']['project_path'].'common/configs/config_music.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/profileMusicBlock.php';

class profilePageMusicHandler extends MusicHandler
	{
		public $isCurrentUser = false;
		public $showEditableLink = false;
		/**
		* profilePageMusicHandler::getMyMusicBlock()
		*
		* @param integer $start
		* @param integer $musicLimit
		* @return void
		*/
		public function getMyMusicBlock($start=0, $musicLimit=3)
			{
				global $smartyObj;
				$condition = 'v.music_status=\'Ok\''.$this->getAdultQuery('v.', 'music').' AND v.user_id=\''.$this->fields_arr['user_id'].'\''.
				' AND (v.user_id = '.$this->CFG['user']['user_id'].
				' OR v.music_access_type = \'Public\''.$this->getAdditionalQuery('v.').')';
				$sql = 'SELECT ma.album_title,ma.music_album_id,v.music_id,v.music_title,v.music_ext, v.small_width, v.small_height, v.medium_width, v.medium_height, v.thumb_width, v.thumb_height, v.music_server_url,v.music_title, TIMEDIFF(NOW(), v.date_added) as date_added, TIME_FORMAT(v.playing_time,\'%H:%i:%s\') as playing_time, v.total_views,v.music_thumb_ext '.
				' FROM '.$this->CFG['db']['tbl']['music'].' AS v LEFT JOIN '.$this->CFG['db']['tbl']['music_album'] .' AS ma ON ma.music_album_id=v.music_album_id WHERE '.$condition.' ORDER BY'.
				' v.music_id DESC LIMIT '.$start.','.$musicLimit;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$this->musicDisplayed = false;
				$music_list_arr = array();
				$inc = 0;
				if ($rs->PO_RecordCount())
					{
						$this->musicDisplayed = true;
						$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
						while($row = $rs->FetchRow())
							{
								$music_path = $this->CFG['site']['url'].$thumbnail_folder.getMusicImageName($row['music_id']).
												$this->CFG['admin']['musics']['small_name'].'.'.$row['music_thumb_ext'];
								if ($row['music_thumb_ext'] == '')
									{
										$music_path = $this->CFG['site']['url'].'music/design/templates/'.$this->CFG['html']['template']['default'].
														'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_audio_S.jpg';
									}
								$widthHeightAttr = DISP_IMAGE($this->CFG['admin']['musics']['small_width'],
												$this->CFG['admin']['musics']['small_height'],
													$row['small_width'], $row['small_height']);
								$row['date_added'] = getTimeDiffernceFormat($row['date_added']);
								$row['playing_time'] = $row['playing_time']?$row['playing_time']:'00:00';
								$music_list_arr[$inc]['playing_time']=$row['playing_time'];
								$music_list_arr[$inc]['musicUrl']=getUrl('viewmusic','?music_id='.$row['music_id'].'&title='.$this->changeTitle($row['music_title']), $row['music_id'].'/'.$this->changeTitle($row['music_title']).'/','','music');
								$music_list_arr[$inc]['albumUrl']=getUrl('viewalbum','?album_id='.$row['music_album_id'].'&title='.$this->changeTitle($row['music_title']), $row['music_album_id'].'/'.$this->changeTitle($row['music_title']).'/','','music');
								$music_list_arr[$inc]['music_album_id']=$row['music_album_id'];
								$music_list_arr[$inc]['date_added']=$row['date_added'];
								$music_list_arr[$inc]['date_added']=$row['date_added'];
								$music_list_arr[$inc]['total_views']=$row['total_views'];
								$music_list_arr[$inc]['wrap_music_title']=$row['music_title'];
								$music_list_arr[$inc]['wrap_album_title']=$row['album_title'];
								$music_list_arr[$inc]['music_path']=$music_path;
								$music_list_arr[$inc]['widthHeightAttr']=$widthHeightAttr;
								$music_list_arr[$inc]['thumb_width']=$row['thumb_width'];
								$music_list_arr[$inc]['thumb_height']=$row['thumb_height'];
								$inc++;
							} // while
					}
				else
					{
						$music_list_arr=0;
					}
				$smartyObj->assign('musicDisplayed', $this->musicDisplayed);
				$smartyObj->assign('music_list_arr', $music_list_arr);
				$usermusiclistURL=getUrl('musiclist','?pg=usermusiclist&user_id='.$this->fields_arr['user_id'], 'usermusiclist/?user_id='.$this->fields_arr['user_id'],'','music');
				$smartyObj->assign('usermusiclistURL', $usermusiclistURL);
				$smartyObj->assign('myobj', $this);
			}
		/**
		* profilePageMusicHandler::setUserId()
		*
		* @return void
		*/
		public function setUserId()
			{
				$userName = $this->fields_arr['user'];
				$sql = 'SELECT user_id FROM '.$this->CFG['db']['tbl']['users'].' WHERE user_name='.$this->dbObj->Param($userName).' AND usr_status=\'Ok\' LIMIT 1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($userName));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$row = array();
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$this->fields_arr['user_id'] = $row['user_id'];
						$this->isValidUser = true;
						$this->isCurrentUser = (strcmp($this->CFG['user']['user_id'], $this->fields_arr['user_id'])==0);
						$edit = $this->fields_arr['edit'];
						$edit = (strcmp($edit, '1')==0);
						$this->showEditableLink = ($this->isCurrentUser and $edit);
					}
			}
		public function checkUserId()
			{
				$user_id = $this->fields_arr['user_id'];
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['users'].' WHERE user_id='.$this->dbObj->Param($user_id);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$row = array();
				$this->isValidUser = ($rs->PO_RecordCount() > 0);
				$this->isCurrentUser = (strcmp($this->CFG['user']['user_id'], $user_id)==0);
				$edit = $this->fields_arr['edit'];
				$edit = (strcmp($edit, '1')==0);
				$this->showEditableLink = ($this->isCurrentUser and $edit);
			}
		/**
		 * profilePageMusicHandler::populateSinglePlayerConfiguration()
		 *
		 * @return void
		 */
		public function populateSinglePlayerConfiguration()
		 	{
				$this->flv_player_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['index_single_player']['player_path'].
													$this->CFG['admin']['musics']['index_single_player']['swf_name'].'.swf';
				$this->configXmlcode_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['index_single_player']['config_name'].'.php?';
				$this->playlistXmlcode_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['index_single_player']['playlist_name'].'.php?';
				$this->addsXmlCode_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['index_single_player']['ad_name'].'.php';
				//END TO ADD THE CODING FOR GETTING THE THEME AS TEMPLATE BASED
				if(is_file($this->CFG['site']['project_path'].$this->CFG['admin']['musics']['index_single_player']['theme_path'].
				$this->CFG['html']['template']['default'].
				'_skin_'.str_replace('screen_','',$this->CFG['html']['stylesheet']['screen']['default']).'.xml'))
				{
					$this->CFG['admin']['musics']['index_single_player']['xml_theme'] =$this->CFG['html']['template']['default'].'_skin_'.
					str_replace('screen_','',$this->CFG['html']['stylesheet']['screen']['default']).'.xml';
				}
				//END TO ADD THE CODING FOR GETTING THE THEME AS TEMPLATE BASED
				$this->themesXml_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['index_single_player']['theme_path'].
														$this->CFG['admin']['musics']['index_single_player']['xml_theme'];

			}

		/**
		 * profilePageMusicHandler::populateSinglePlayer()
		 *
		 * @param string $div_id
		 * @param string $music_player_id
		 * @param integer $width
		 * @param integer $height
		 * @param string $auto_play
		 * @return void
		 */
		public function populateSinglePlayer($music_fields=array())
			{
			//$div_id='flashcontent', $music_player_id, $width, $height, $auto_play='false';
				if(!array_key_exists ('div_id', $music_fields))
					$music_fields['div_id'] = 'flashcontent';

				if($music_fields['width'] == '')
					$width = $this->CFG['admin']['musics']['index_single_player']['width'];

				if($music_fields['height'] == '')
					$height = $this->CFG['admin']['musics']['index_single_player']['height'];

				echo '<div id="'.$music_fields['div_id'].'"></div>';
				?>
				<script type="text/javascript">
					var music_player_id = '<?php echo $music_fields['music_player_id'];?>';
					var so1 = new SWFObject("<?php echo $this->flv_player_url; ?>", music_player_id, "<?php echo $width; ?>", "<?php echo $height; ?>", "7", "#000000");
					so1.addParam("wmode", "transparent");
					so1.addVariable("autoplay", "<?php echo $music_fields['auto_play']; ?>");
					so1.addVariable("configXmlPath", "<?php echo $this->configXmlcode_url; ?>");
					so1.addVariable("playListXmlPath", "<?php echo $this->playlistXmlcode_url; ?>");
					so1.addVariable("themes", "<?php echo $this->themesXml_url; ?>");
					so1.write("<?php echo $music_fields['div_id']; ?>");
				</script>
				<?php
			}
		/**
		* profilePageMusicHandler::getFeaturedMusicBlock()
		*
		* @return void
		*/
		public function getFeaturedMusicBlock()
			{
				global $smartyObj;
				$condition = 'music_status=\'Ok\''.$this->getAdultQuery('v.', 'music').' AND vf.user_id=\''.$this->fields_arr['user_id'].'\''.
				' AND (v.user_id = '.$this->CFG['user']['user_id'].
				' OR music_access_type = \'Public\''.$this->getAdditionalQuery('v.').')';
				$sql = 'SELECT v.music_id,v.music_title, u.user_name as music_artist, v.music_album_id, music_ext, v.medium_width, v.medium_height, v.thumb_width, v.thumb_height, music_server_url,music_title, ma.album_title, TIMEDIFF(NOW(), v.date_added) as date_added, TIME_FORMAT(playing_time,\'%H:%i:%s\') as playing_time, total_views,music_thumb_ext,mfs.file_name '.
				' FROM '.$this->CFG['db']['tbl']['music'].' AS v JOIN '.$this->CFG['db']['tbl']['music_featured'].' as vf ON vf.music_id=v.music_id '.' LEFT JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma on ma.music_album_id=v.music_album_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs ON mfs.music_file_id = v.thumb_name_id LEFT JOIN '.$this->CFG['db']['tbl']['users'].' as u ON v.user_id=u.user_id '.'WHERE '.$condition.' ORDER BY'.
				' music_id DESC';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$this->musicDisplayed = false;
				$this->isFeaturedmusic = false;
				$featured_music_list_arr = array();
				$featured_music_list_arr['isFeaturedmusic']='false';
				$this->setFormField('music_id',0);
				$featured_music_list_arr['music_id']=0;
				if ($rs->PO_RecordCount())
					{
						if($row = $rs->FetchRow())
							{
								$this->isFeaturedmusic = true;
								$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.
											$this->CFG['admin']['musics']['thumbnail_folder'].'/';
								$music_path = $this->CFG['site']['url'].$thumbnail_folder.getMusicImageName($row['music_id']).$this->CFG['admin']['musics']['thumb_name'].'.'.$row['music_thumb_ext'];

								if ($row['music_thumb_ext'] == '')
									{
										$music_path = $this->CFG['site']['url'].'music/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].
															'/no_image/noImage_audio_T.jpg';
									}
								$musics_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['musics']['folder'] . '/' . $this->CFG['admin']['musics']['thumbnail_folder'] . '/';
								$featured_music_list_arr['music_title']=$row['music_title'];
								$featured_music_list_arr['music_id']=$row['music_id'];
								$featured_music_list_arr['artist_name']=$row['music_artist'];
								$featured_music_list_arr['music_thumb_ext']=$row['music_thumb_ext'];
								$featured_music_list_arr['img_src'] = $row['music_server_url'] . $musics_folder . getMusicImageName($row['music_id'],$row['file_name']) . $this->CFG['admin']['musics']['small_name'] . '.' .$row['music_thumb_ext'];
								$featured_music_list_arr['album_title']=$row['album_title'];

								$featured_music_list_arr['music_external_embed_code']='';

								$this->setFormField('music_id',$row['music_id']);
								$row['date_added'] = getTimeDiffernceFormat($row['date_added']);
								$row['playing_time'] = $row['playing_time']?$row['playing_time']:'00:00';
								$featured_music_list_arr['playing_time']=$row['playing_time'];
								$featured_music_list_arr['musicUrl']=getUrl('viewmusic','?music_id='.$row['music_id'].'&title='.$this->changeTitle($row['music_title']), $row['music_id'].'/'.$this->changeTitle($row['music_title']).'/','','music');
								$featured_music_list_arr['date_added']=$row['date_added'];
								$featured_music_list_arr['total_views']=$row['total_views'];
								$featured_music_list_arr['album_view_url'] = getUrl('viewalbum', '?album_id='.$row['music_album_id'].'&title='.$this->changeTitle($featured_music_list_arr['album_title']), $row['music_album_id'].'/'.$this->changeTitle($featured_music_list_arr['album_title']).'/', '', 'music');
							}
					}
				$musics_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/';
				//Populate playlist player configuration
				$this->populateSinglePlayerConfiguration();
				$this->configXmlcode_url .= 'pg=music_'.$featured_music_list_arr['music_id'].'_ip';
				$this->playlistXmlcode_url .= 'pg=music_'.$featured_music_list_arr['music_id'];
				$smartyObj->assign('isFeaturedmusic', $this->isFeaturedmusic);
				$smartyObj->assign('featured_music_list_arr', $featured_music_list_arr);
				$smartyObj->assign('myobjFeaturedMusic', $this);
			}

		/**
		* profilePageMusicHandler::getFeaturedMusicBlock()
		*
		* @return void
		*/
		public function getFeaturedMusicPlaylistBlock()
		{
			global $smartyObj;
			$featured_music_list_arr = array();
			$this->isFeaturedmusic = false;
			global $smartyObj;
				$condition = 'music_status=\'Ok\''.$this->getAdultQuery('v.', 'music').' AND vf.user_id=\''.$this->fields_arr['user_id'].'\''.
				' AND (v.user_id = '.$this->CFG['user']['user_id'].
				' OR music_access_type = \'Public\''.$this->getAdditionalQuery('v.').')';
				$sql = 'SELECT v.music_id,v.music_title, v.music_artist, v.music_album_id, music_ext, medium_width, medium_height, thumb_width, thumb_height, music_server_url,music_title, ma.album_title, TIMEDIFF(NOW(), v.date_added) as date_added, TIME_FORMAT(playing_time,\'%H:%i:%s\') as playing_time, total_views,music_thumb_ext,mfs.file_name '.
				' FROM '.$this->CFG['db']['tbl']['music'].' AS v JOIN '.$this->CFG['db']['tbl']['music_featured'].' as vf ON vf.music_id=v.music_id '.' LEFT JOIN '.$this->CFG['db']['tbl']['music_album'].' AS ma on ma.music_album_id=v.music_album_id JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs ON mfs.music_file_id = v.thumb_name_id WHERE '.$condition.' ORDER BY'.
				' music_id DESC';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$this->musicDisplayed = false;
				$this->isFeaturedmusic = false;
				$featured_music_list_arr = array();
				$featured_music_list_arr['music_id'] = 0;
				if ($rs->PO_RecordCount())
				{
					if($row = $rs->FetchRow())
					{
						$this->isFeaturedmusic = true;
					}
				}
			//Populate playlist player configuration
			$this->populatePlayerWithPlaylistConfiguration();
			$this->configXmlcode_url .= 'pg=music_0_0_0_'.$this->fields_arr['user_id'];
			$this->playlistXmlcode_url .= 'pg=music_0_0_0_'.$this->fields_arr['user_id'];
			$smartyObj->assign('myobjFeaturedMusic', $this);
			$smartyObj->assign('isFeaturedmusic', $this->isFeaturedmusic);
			$smartyObj->assign('featured_music_list_arr', $featured_music_list_arr);
		}

		/**
		 * profilePageMusicHandler::getAlbumListBlock()
		 *
		 * @return
		 */
		public function getAlbumListBlock()
		{
			global $smartyObj;
			$sql = 'SELECT ma.music_album_id,m.music_title, ma.album_title,ma.user_id, ma.thumb_music_id,m.music_server_url, m.medium_width, m.medium_height, m.small_width, m.small_height , ma.total_album_views, m.music_id,'.
					' count(m.music_id) as total_songs, sum(m.total_plays) as total_plays, ma.album_access_type, ma.album_for_sale, ma.album_price FROM '.
					$this->CFG['db']['tbl']['music_album'].
					' as ma LEFT JOIN '.
					$this->CFG['db']['tbl']['music'].
					' as m ON ma.music_album_id=m.music_album_id '.
					' WHERE ma.user_id = '.$this->dbObj->Param('user_id').
					' AND m.music_status=\'Ok\''.
					' GROUP BY ma.music_album_id LIMIT '.$this->CFG['admin']['musics']['profile_album_shelf_limit'].'';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id']));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);
			$albumlist_arr = array();
			$inc = 1;
			$musics_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['musics']['folder'] . '/' .
									$this->CFG['admin']['musics']['thumbnail_folder'] . '/';
			$fields_list = array('user_name', 'first_name', 'last_name');
            if (!isset($this->UserDetails[$this->fields_arr['user_id']]))
                $return_arr = getMemberAvatarDetails($this->fields_arr['user_id']);

            $name = $this->getUserDetail('user_id', $this->fields_arr['user_id'], 'user_name');
            $this->albumDisplayed = false;
			while($row = $rs->FetchRow())
			{
				$this->albumDisplayed = true;
				$albumlist_arr[$inc]['record'] = $row;
				$albumlist_arr[$inc]['small_width'] = $row['small_width'];
				$albumlist_arr[$inc]['small_height'] = $row['small_height'];
				$albumlist_arr[$inc]['member_url'] = getUrl('viewprofile', '?user='.$name, $name.'/', 'members');
				$albumlist_arr[$inc]['music_album_id'] = $row['music_album_id'];
				$albumlist_arr[$inc]['album_title'] = $row['album_title'];
				$albumlist_arr[$inc]['total_album_views'] = $row['total_album_views'];
				$albumlist_arr[$inc]['user_id'] = $row['user_id'];
				$albumlist_arr[$inc]['music_id'] = $row['music_id'];
				$albumlist_arr[$inc]['total_songs'] = $row['total_songs'];
				$albumlist_arr[$inc]['total_plays'] = $row['total_plays'];
				$albumlist_arr[$inc]['music_title'] = $row['music_title'];
				$albumlist_arr[$inc]['viewalbum_url'] = getUrl('viewalbum', '?album_id='.$row['music_album_id'].'&title='.$this->changeTitle($row['album_title']),$row['music_album_id'].'/'.$this->changeTitle($row['album_title']).'/', '', 'music');
				$album_image_name=$this->getAlbumImageName($row['music_album_id']);
				$albumlist_arr[$inc]['album_for_sale'] = 'No';

				if($row['album_access_type']=='Private'
					and $row['album_price'] > 0
					and $row['album_for_sale']=='Yes')
				{
					$albumlist_arr[$inc]['album_for_sale'] = $row['album_for_sale'];
					$albumlist_arr[$inc]['album_price'] = $row['album_price'];
				}

				if($album_image_name['music_thumb_ext'])
				{
					 $albumlist_arr[$inc]['music_image_src']  = $album_image_name['music_server_url'] . $musics_folder . getMusicImageName($album_image_name['music_id'],$album_image_name['file_name']) . $this->CFG['admin']['musics']['medium_name'] . '.' .$album_image_name['music_thumb_ext'];
					 $albumlist_arr[$inc]['music_disp'] = DISP_IMAGE($this->CFG['admin']['musics']['medium_width'], $this->CFG['admin']['musics']['medium_width'], $row['medium_width'], $row['medium_height']);
				}
				else
				{
					$albumlist_arr[$inc]['music_image_src'] = '';
					$albumlist_arr[$inc]['music_disp'] = '';
				}
				$inc++;
			}
			$smartyObj->assign('albumlist_arr', $albumlist_arr);
			$smartyObj->assign('albumDisplayed', $this->albumDisplayed);

		}

		/**
		 * profilePageMusicHandler::getTotalFans()
		 *
		 * @return
		 */
		public function getTotalFans()
		{
			$sql = 'SELECT count(fan_id) as total_fans FROM '.
					$this->CFG['db']['tbl']['artist_fans_list'].
					' WHERE artist_id='.$this->dbObj->Param('artist_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id']));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);
			$total_fans = 0;
			if($row = $rs->FetchRow())
				$total_fans = $row['total_fans'];
			return $total_fans;

		}

		/**
		 * profilePageMusicHandler::populateArtistInfoDetails()
		 *
		 * @return
		 */
		public function populateArtistInfoDetails()
		{
			global $smartyObj;
			$sql = 'SELECT u.user_id,u.user_name,'.
					' sum(m.total_plays) as total_plays, count(m.music_id) as total_songs, u.music_artist_category_id,'.
					'u.music_artist_sub_category_id FROM '.
					$this->CFG['db']['tbl']['users'].' as u LEFT JOIN '.$this->CFG['db']['tbl']['music'].' as m '.
					' ON m.user_id=u.user_id '.
					' WHERE u.user_id='.$this->dbObj->Param('user_id').
					' GROUP BY m.user_id';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id']));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);
			$artist_info_arr = array();
			$this->artistInfoDisplayed = false;
			if($row = $rs->FetchRow())
			{
				$sql = 'SELECT ma.image_ext, ma.medium_width, ma.medium_height,ma.music_artist_promo_image_id FROM '.
						$this->CFG['db']['tbl']['music_artist_promo_image'].' as ma '.
						' WHERE user_id='.$this->dbObj->Param('user_id');
				$stmt1 = $this->dbObj->Prepare($sql);
				$res = $this->dbObj->Execute($stmt1, array($this->fields_arr['user_id']));
				if (!$res)
					trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$image_details = $res->FetchRow();
				$artist_promo_image_path = $this->CFG['site']['url'].$this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['music_folder'].'/'.$this->CFG['admin']['musics']['artist_promo_image_folder'].'/';
				$this->artistInfoDisplayed = true;
				$artist_info_arr['record'] = $row;
				if($row['total_plays']=='')
					$row['total_plays'] = 0;
				$artist_info_arr['total_plays'] = $row['total_plays'];
				$usermusiclistURL=getUrl('musiclist','?pg=usermusiclist&user_id='.$this->fields_arr['user_id'], 'usermusiclist/?user_id='.$this->fields_arr['user_id'],'','music');
				if($row['total_songs']>0)
					$artist_info_arr['total_songs'] = '<a href="'.$usermusiclistURL.'">'.$row['total_songs'].'</a>';
				else
					$artist_info_arr['total_songs'] = $row['total_songs'];
				$artist_info_arr['image_ext'] = $image_details['image_ext'];
				$artist_info_arr['music_artist_category'] = $this->getArtistCategoryName($row['music_artist_category_id']);
				$artist_info_arr['music_artist_sub_category'] = $this->getArtistCategoryName($row['music_artist_sub_category_id']);
				$artist_info_arr['medium_width'] = $image_details['medium_width'];
				$artist_info_arr['medium_height'] = $image_details['medium_height'];
				$artist_info_arr['user_name'] = $row['user_name'];
				$fans_url = getUrl('fanslist','?artist_id='.$this->fields_arr['user_id'],'?artist_id='.$this->fields_arr['user_id'],'','music');
				$artist_info_arr['member_url'] = getUrl('viewprofile', '?user='.$row['user_name'], $row['user_name'].'/', 'members');
				$artist_info_arr['member_feature_url'] = getUrl('viewprofile', '?user='.$row['user_name'].'&fanfeatured=yes&ajax_page=1', $row['user_name'].'/?fanfeatured=yes&ajax_page=1', 'members');
				$artist_info_arr['member_unfeature_url'] = getUrl('viewprofile', '?user='.$row['user_name'].'&fanunfeatured=yes&ajax_page=1', $row['user_name'].'/?fanunfeatured=yes&ajax_page=1', 'members');
				$artist_info_arr['memberProfileUrl'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
				if($this->getTotalFans()>0)
					$artist_info_arr['total_fans'] = '<a href="'.$fans_url.'">'.$this->getTotalFans().'</a>';
				else
					$artist_info_arr['total_fans'] = $this->getTotalFans();
				$artist_info_arr['fans_url'] = $fans_url;
				$artist_info_arr['already_fan'] = false;
				$artist_info_arr['fanbutton'] = true;
				if($this->CFG['user']['user_id']==$this->fields_arr['user_id'])
					$artist_info_arr['fanbutton'] = false;
				if($this->chkAlreadyFan())
				{
					$artist_info_arr['already_fan'] = true;
				}

				$artist_info_arr['artist_promo_image'] = $artist_promo_image_path.$image_details['music_artist_promo_image_id'].$this->CFG['admin']['musics']['artist_promo_medium_name'].'.'.$image_details['image_ext'];
			}
			$smartyObj->assign('artist_info_arr', $artist_info_arr);
			$smartyObj->assign('artistInfoDisplayed', $this->artistInfoDisplayed);
		}

		public function chkAlreadyFan()
		{
			$sql = 'SELECT fan_id FROM '.
					$this->CFG['db']['tbl']['artist_fans_list'].
					' WHERE fan_id='.$this->dbObj->Param('fan_id').
					' and artist_id='.$this->dbObj->Param('artist_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['user_id']));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);
			if($row = $rs->FetchRow())
				return true;
			return false;
		}

		/**
		 * profilePageMusicHandler::getArtistCategoryName()
		 *
		 * @param mixed $categoryId
		 * @return
		 */
		public function getArtistCategoryName($categoryId)
		{
			$sql = 'SELECT music_artist_category_name FROM ' . $this->CFG['db']['tbl']['music_artist_category'] . ' WHERE music_artist_category_id=' . $this->dbObj->Param('music_artist_category_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($categoryId));
			if (!$rs)
			trigger_db_error($this->dbObj);
			if ($row = $rs->FetchRow())
			return $row['music_artist_category_name'];
		}

		/**
		 * profilePageMusicHandler::getValueFromCountryArray()
		 *
		 * @param array $array
		 * @param string $index
		 * @param mixed $comma
		 * @return
		 */
		public function getValueFromCountryArray($array=array(), $index='', $comma=false)
		{
			$value = '';
			if($comma)
			{
				$index_arr = explode(',', $index);
				foreach($index_arr as $index_key=>$index_value)
				{
					$index_value = trim($index_value);
					if (is_array($array) and isset($array[$index_value]))
				    {
				        $value .= $array[$index_value].', ';
				    }
				}
				$value = substr($value, 0, strrpos($value, ','));
			}
			else
			{
				if (is_array($array) and isset($array[$index]))
			    {
			        $value = $array[$index];
			    }
			}
			return $value;
		}

		/**
		 * profilePageMusicHandler::populateFansDetails()
		 *
		 * @return
		 */
		public function populateFansDetails()
		{
			global $smartyObj;
			$limit = 9;
			$sql = 'SELECT user_id, user_name, icon_id,sex, icon_type, image_ext, country FROM '.
					$this->CFG['db']['tbl']['users'].' as u LEFT JOIN '
					.$this->CFG['db']['tbl']['artist_fans_list'].' as af'.
					' ON af.fan_id=u.user_id WHERE af.artist_id='.$this->dbObj->Param('artist_id').
					' and usr_status=\'Ok\' LIMIT 0,'.$limit;
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id']));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);

			$record_count = $rs->PO_RecordCount();
			$this->fans_per_page=$limit;
			$fansPerRow = 3;
			$count = 0;
			$found = false;
			$this->no_of_row=1;

			$fandetails_arr = array();
			$inc = 1;
			$fans_displayed = false;
			$fans_url = getUrl('fanslist','?artist_id='.$this->fields_arr['user_id'],'?artist_id='.$this->fields_arr['user_id'],'','music');
			if ($record_count)
			{
				$found = true;
				while($row = $rs->FetchRow())
				{
					$fandetails_arr[$inc]['addclass'] = 'clsMarginNoBorderPadding';
					if($record_count-$inc >= $fansPerRow)
						$fandetails_arr[$inc]['addclass']='clsBorderBtm';
					$fans_displayed = true;
					$fandetails_arr[$inc]['open_tr']=false;
					if ($count%$fansPerRow==0)
				    {
						 $fandetails_arr[$inc]['open_tr']=true;
						 $this->no_of_row++;
				    }
					$fandetails_arr[$inc]['record'] = $row;
					$fandetails_arr[$inc]['user_name'] = $row['user_name'];
					$fandetails_arr[$inc]['country'] = $this->getValueFromCountryArray($this->getFormField('countries'), $row['country']);
					$fandetails_arr[$inc]['profileIcon'] = getMemberAvatarDetails($row['user_id']);
					$fandetails_arr[$inc]['memberProfileUrl'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
					$count++;
					$fandetails_arr[$inc]['end_tr']=false;
					if ($count%$fansPerRow==0)
				    {
						$count = 0;
						$fandetails_arr[$inc]['end_tr']=true;
				    }
					$inc++;
				}
			}
			$smartyObj->assign('fandetails_arr', $fandetails_arr);
			$smartyObj->assign('fans_displayed', $fans_displayed);
			$smartyObj->assign('fans_url', $fans_url);
		}

		/**
		 * profilePageMusicHandler::populateArtistsDetails()
		 *
		 * @return
		 */
		public function populateArtistsDetails()
		{
			global $smartyObj;
			$limit = 9;
			$sql = 'SELECT user_id, user_name, icon_id,sex, icon_type, image_ext, country FROM '.
					$this->CFG['db']['tbl']['users'].' as u LEFT JOIN '
					.$this->CFG['db']['tbl']['artist_fans_list'].' as af'.
					' ON af.artist_id=u.user_id WHERE af.fan_id='.$this->dbObj->Param('artist_id').
					' and usr_status=\'Ok\' LIMIT 0, '.$limit;
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id']));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);

			$record_count = $rs->PO_RecordCount();
			$this->artists_per_page=$limit;
			$artistsPerRow = 3;
			$count = 0;
			$found = false;
			$this->no_of_row=1;

			$artistdetails_arr = array();
			$inc = 1;
			$artists_displayed = false;
			$artist_url = getUrl('artistmemberslist','?pg=artistfavorited&user_id='.$this->fields_arr['user_id'],'?pg=artistfavorited&user_id='.$this->fields_arr['user_id'],'','music');
			if ($record_count)
			{
				$found = true;
				while($row = $rs->FetchRow())
				{
					$artistdetails_arr[$inc]['addclass'] = 'clsMarginNoBorderPadding';
					if($record_count-$inc >= $artistsPerRow)
						$artistdetails_arr[$inc]['addclass']='clsBorderBtm';
					$artists_displayed = true;
					$artistdetails_arr[$inc]['open_tr']=false;
					if ($count%$artistsPerRow==0)
				    {
						 $artistdetails_arr[$inc]['open_tr']=true;
						 $this->no_of_row++;
				    }
					$artistdetails_arr[$inc]['record'] = $row;
					$artistdetails_arr[$inc]['user_name'] = $row['user_name'];
					$artistdetails_arr[$inc]['country'] = $this->getValueFromCountryArray($this->getFormField('countries'), $row['country']);
					$artistdetails_arr[$inc]['profileIcon'] = getMemberAvatarDetails($row['user_id']);
					$artistdetails_arr[$inc]['memberProfileUrl'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
					$count++;
					$artistdetails_arr[$inc]['end_tr']=false;
					if ($count%$artistsPerRow==0)
				    {
						$count = 0;
						$artistdetails_arr[$inc]['end_tr']=true;
				    }
					$inc++;
				}
			}
			$smartyObj->assign('artistdetails_arr', $artistdetails_arr);
			$smartyObj->assign('artists_displayed', $artists_displayed);
			$smartyObj->assign('artist_url', $artist_url);
		}

		public function insertFansDetails()
		{
			$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['artist_fans_list'].
					' SET artist_id='.$this->dbObj->Param('artist_id').','.
					' fan_id='.$this->dbObj->Param('fan_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id'], $this->CFG['user']['user_id']));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);
		}

		public function deleteFansDetails()
		{
			$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['artist_fans_list'].
					' WHERE artist_id='.$this->dbObj->Param('artist_id').
					' and fan_id='.$this->dbObj->Param('fan_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id'], $this->CFG['user']['user_id']));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);
		}

		public function populateArtistPromoDescriptionDetails()
		{
			global $smartyObj;
			$sql = 'SELECT artist_promo_caption FROM '.
					$this->CFG['db']['tbl']['music_artist_promo_image'].
					' WHERE user_id='.$this->dbObj->Param('user_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id']));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);
			$display_caption = false;
			$artist_promo_caption = '';
			if($row = $rs->FetchRow())
			{
				if($row['artist_promo_caption']!='')
					$display_caption = true;
				$artist_promo_caption = html_entity_decode($row['artist_promo_caption']);

			}
			$smartyObj->assign('display_caption', $display_caption);
			$smartyObj->assign('artist_promo_caption', $artist_promo_caption);
		}
	}

$musicBlock = new profilePageMusicHandler();
global $CFG, $LANG_LIST_ARR;

$musicBlock->setFormField('user_id', 0);
$musicBlock->setFormField('user', 0);
$musicBlock->setFormField('edit', 0);
$musicBlock->setFormField('countries', $LANG_LIST_ARR['countries']);
if ($musicBlock->isPageGETed($_GET, 'user_id'))
	{
		$musicBlock->sanitizeFormInputs($_GET);
		$musicBlock->checkUserId();
	}
if ($musicBlock->isPageGETed($_GET, 'user'))
	{
		$musicBlock->sanitizeFormInputs($_GET);
		$musicBlock->setUserId();
	}
if(isAjax())
{
	if($musicBlock->isPageGETed($_GET, 'fanfeatured'))
	{
		$musicBlock->insertFansDetails();
		exit;
	}
	elseif($musicBlock->isPageGETed($_GET, 'fanunfeatured'))
	{
		$musicBlock->deleteFansDetails();
		exit;
	}
}

if (isset($__myProfile)) //its declared in members/myProfile.php
	{
		$musicBlock->setFormField('user_id', $CFG['user']['user_id']);
		$musicBlock->setFormField('edit', '1');
		$musicBlock->checkUserId();
	}
$userId = $musicBlock->getFormField('user_id');
//Added the View Album Url
$viewalbum_url = getUrl('albumlist','?pg=useralbums&user_id='.$musicBlock->getFormField('user_id'), 'useralbums/?user_id='.$musicBlock->getFormField('user_id'),'','music');
$smartyObj->assign('viewalbum_url',$viewalbum_url);
if (!is_numeric($userId))
	{
		$musicBlock->setFormField('user_id', intval($userId));
	}
$musicBlock->getMyMusicBlock(0,$CFG['admin']['musics']['profile_page_total_music']);
$user_type = getUserType($musicBlock->getFormField('user_id'));
	$fanblock = true;
	$musicBlock->getFeaturedMusicBlock();
	$width = 299;
	$height = 246;
/*if($user_type=='Artist')
{
	$fanblock = true;
	$musicBlock->getFeaturedMusicPlaylistBlock();
	$width = 454;
	$height = 270;
}

else
{
	$musicBlock->getFeaturedMusicBlock();
	$width = 1;
	$height = 1;
	$fanblock = false;
}*/
if(!$CFG['admin']['musics']['music_artist_feature'] and !$CFG['admin']['musics']['allow_only_artist_to_upload'])
	$fanblock = true;

$smartyObj->assign('fanblock', $fanblock);
//START TO GENERATE THE QUICKMIX PLAYER ARRAY FIELDS
$music_fields = array(
	'div_id'               => 'music_flashcontent',
	'music_player_id'      => 'profile_music_player',
	'width'  		       => $width,
	'height'               => $height,
	'auto_play'            => 'false',
	'hidden'               => true,
	'playlist_auto_play'   => false,
	'javascript_enabled'   => true,
	'player_ready_enabled' => true
);

$smartyObj->assign('music_fields',$music_fields);

//END TO GENERATE THE QUICKMIX PLAYER ARRAY FIELDS
//Populate the Album Shelf Details
$musicBlock->getAlbumListBlock();
//Populte Artist Info Block Details
$musicBlock->populateArtistInfoDetails();
//Populte Fan Block Details
$musicBlock->populateFansDetails();
//Populte Artist Block Details
$musicBlock->populateArtistsDetails();
$musicBlock->populateArtistPromoDescriptionDetails();
?>
