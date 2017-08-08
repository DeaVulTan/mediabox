<?php

class MusicDetails extends MusicHandler
	{
		//public $commentUrl ='';
		public function chkValidMusicId()
			{
				$musicId = $this->fields_arr['music_id'];
				$musicId = is_numeric($musicId)?$musicId:0;
				if (!$musicId)
				    {
				        return false;
				    }
				$userId = $this->CFG['user']['user_id'];

				$condition = 'm.music_status=\'Ok\' AND m.music_id='.$this->dbObj->Param($musicId).
							' AND (m.user_id = '.$this->dbObj->Param($userId).' OR'.
							' m.music_access_type = \'Public\''.$this->getAdditionalQuery('m.').')';

				$sql = 'SELECT m.music_title, m.music_caption, music_artist,'.
						' m.total_favorites, m.total_views, m.total_comments, m.total_downloads,'.
						' m.allow_comments, m.allow_embed, m.allow_ratings, m.allow_lyrics, '.
						' m.music_ext, m.music_album_id, TIME_FORMAT(m.playing_time,\'%H:%i:%s\') as playing_time,'.
						' m.music_category_id, m.music_tags, m.rating_total, m.rating_count, m.user_id, m.flagged_status, '.
						' m.music_available_formats, m.music_server_url, m.music_upload_type, '.
						' m.for_sale, m.music_price, ma.album_for_sale, ma.album_access_type, ma.album_price, '.
						' DATE_FORMAT(m.date_added,\''.$this->CFG['format']['date'].'\') as date_added,'.
						' m.music_thumb_ext, ma.album_title, m.total_plays,'.
						' m.large_width, m.large_height, m.thumb_width, m.thumb_height, m.small_width, m.small_height, mr.music_artist_id '.
						' FROM '.$this->CFG['db']['tbl']['music'].' as m'.
						' JOIN ' . $this->CFG['db']['tbl']['users'] . ' as u on m.user_id = u.user_id'.
						' LEFT JOIN '.$this->CFG['db']['tbl']['music_artist'].' AS mr ON  music_artist IN (music_artist_id)'.
						' JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = thumb_name_id '.
						' JOIN '.$this->CFG['db']['tbl']['music_album'].' as ma ON ma.music_album_id = m.music_album_id'.
						' JOIN '.$this->CFG['db']['tbl']['music_category'].' as mc ON mc.music_category_id = m.music_category_id'.
						' WHERE '.$condition.' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($musicId, $userId));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						$name = $this->getUserDetail('user_id', $row['user_id'], 'user_name');
						$this->fields_arr['user_id'] = $row['user_id'];
						$this->fields_arr['music_ext'] = $row['music_ext'];
						$this->fields_arr['music_server_url'] = $row['music_server_url'];
						$this->fields_arr['music_title'] = $row['music_title'];
						$this->fields_arr['music_album'] = $row['album_title'];
						$this->fields_arr['music_caption'] = $row['music_caption'];
						$this->fields_arr['music_thumb_ext'] = $row['music_thumb_ext'];
						$this->fields_arr['date_added'] = $row['date_added'];
						$this->fields_arr['user_name'] = $name;
						$this->fields_arr['large_width'] = $row['large_width'];
						$this->fields_arr['large_height'] = $row['large_height'];
						$this->fields_arr['thumb_width'] = $row['thumb_width'];
						$this->fields_arr['thumb_height'] = $row['thumb_height'];
						$this->fields_arr['small_width'] = $row['small_width'];
						$this->fields_arr['small_height'] = $row['small_height'];
						$this->fields_arr['rating_total'] = $row['rating_total'];
						$this->fields_arr['rating_count'] = $row['rating_count'];
						$this->fields_arr['flagged_status'] = $row['flagged_status'];
						$this->fields_arr['comments'] = $row['total_comments']?$row['total_comments']:0;
						$this->fields_arr['music_album_id'] = $row['music_album_id'];
						$this->fields_arr['total_downloads'] = $row['total_downloads'];
						$this->fields_arr['cur_mid_play_time'] = $row['playing_time'];
						$this->fields_arr['playing_time'] = $this->fmtMusicPlayingTime($row['playing_time'], true);
						$this->fields_arr['cur_mid_total_views'] = $row['total_views'];
						$this->fields_arr['total_favorites'] = $row['total_favorites'];
						$this->fields_arr['total_views'] = $row['total_views'];
						$this->fields_arr['total_plays'] = $row['total_plays'];
						$this->fields_arr['total_comments'] = $row['total_comments'];
						$this->fields_arr['music_category_id'] = $row['music_category_id'];
						$this->fields_arr['music_tags'] = $row['music_tags'];
						$this->fields_arr['music_upload_type'] = $row['music_upload_type'];
						$this->fields_arr['music_category_type'] = $this->getCategoryType($row['music_category_id']);
						$this->fields_arr['music_artist'] = $this->getArtistsNames($row['music_artist']);
						$this->fields_arr['music_artist_id'] = $row['music_artist_id'];

						//START TO CHECK THE MUSIC?ALBUM IS FOR SALE
						$this->fields_arr['buy_url'] = '';
						$this->fields_arr['music_price'] = 'Free';
						$this->fields_arr['album_price'] = '';
						if($row['album_for_sale']=='Yes'
							and $row['album_access_type']=='Private'
							and $row['album_price']>0)
						{
							$this->fields_arr['music_price'] = $this->CFG['currency'].$row['album_price'];
							$this->fields_arr['album_price'] = $this->CFG['currency'].$row['album_price'].'*';
							if(!isUserAlbumPurchased($row['music_album_id']) AND $row['user_id']!=$this->CFG['user']['user_id'])
								$this->fields_arr['buy_url'] = $this->CFG['site']['url'].'music/musicUpdateAddToCart.php?album_id='.$row['music_album_id'].'&page=player';
						}
						elseif($row['for_sale']=='Yes')
						{
							$this->fields_arr['music_price'] = $this->CFG['currency'].$row['music_price'];
							if(!isUserPurchased($row['music_album_id']) AND $row['user_id']!=$this->CFG['user']['user_id'])
								$this->fields_arr['buy_url'] = $this->CFG['site']['url'].'music/musicUpdateAddToCart.php?music_id='.$musicId.'&page=player';
						}
						//END TO CHECK THE MUSIC?ALBUM FOR SALE
						return true;
					}
				return false;
			}

		public function getCategoryType($category_id)
			{
				$sql = 'SELECT music_category_type FROM '.$this->CFG['db']['tbl']['music_category'].
						' WHERE music_category_id='.$this->dbObj->Param('music_category_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($category_id));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$category_type = 'General';
				if($row = $rs->FetchRow())
					{
						$category_type = $row['music_category_type'];
					}
				return $category_type;
			}
		public function selectMusicAdSettings(){
				$this->CFG['admin']['musics']['TailUrlUrl'] = $this->CFG['admin']['musics']['TailUrlTargetUrl'] =
					$this->CFG['admin']['musics']['TopUrlUrl'] = $this->CFG['admin']['musics']['TopUrlTargetUrl'] =
						$this->CFG['admin']['musics']['TopAudioUrl'] = $this->CFG['admin']['musics']['TailAudioUrl'] =
							$this->CFG['admin']['musics']['Topduration'] = $this->CFG['admin']['musics']['Tailduration'] =
								$this->CFG['admin']['musics']['TopImageUrl'] = $this->CFG['admin']['musics']['TailImageUrl'] = '';

				$this->CFG['admin']['musics']['TopUrl'] = $this->CFG['admin']['musics']['TailUrl'] = false;

				$user_condn = ' 1 AND ';

				$musicDetails_arr = $this->chkValidMusicId();

				$categoryId = '';

				for($i=1; $i <= count($musicDetails_arr);$i++){
					$categoryId .= $musicDetails_arr[$i]['music_category_id'].',';
				}
				$categoryIds = explode(',',substr($categoryId,0,-1));
				/*echo '<pre>';
				print_r($categoryIds);
				echo '</pre>';*/
				$findinCondition = '(FIND_IN_SET('.$this->fields_arr['music_category_id'].',advertisement_channel)) OR ';
				/*$findinCondition = '';
				foreach($categoryIds as $categoryId){
					if(!empty($categoryId))
						$findinCondition .= '(FIND_IN_SET('.$categoryId.',advertisement_channel)) OR ';
				}*/

				$add_fields = 'advertisement_id, advertisement_url, advertisement_duration, advertisement_channel, advertisement_image_ext,'.
						' advertisement_audio_ext, advertisement_show_at';

				$default_cond = ' advertisement_id!=\'\' AND advertisement_status=\'Activate\' AND (advertisement_audio_ext!=\'\' OR advertisement_image_ext!=\'\') AND '.
									' ('.$findinCondition.' (advertisement_channel=\'\')) AND ';

				$sql = 'SELECT '.$add_fields.' FROM '.$this->CFG['db']['tbl']['music_advertisement'].
						' WHERE'.$user_condn.$default_cond.'(advertisement_show_at=\'Begining\' OR advertisement_show_at=\'Both\')';
				//echo $sql;

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
								if($i != $selected){
									$i++;
									continue;
								}
								/*if($this->CFG['admin']['music_advertisement_impressions'])
									{
										$this->increaseImpressions($row['advertisement_id']);
									}*/
								/*$this->CFG['admin']['musics']['TopImpressionUrl'] .= '?params='.$row['advertisement_id'].'_view_'.$this->fields_arr['ref'].'_'.$this->fields_arr['mid'];
								$this->CFG['admin']['musics']['TopClickCountUrl'] .= '?params='.$row['advertisement_id'].'_click_'.$this->fields_arr['ref'].'_'.$this->fields_arr['mid'];*/
								if($row['advertisement_audio_ext'] != '')
									$this->CFG['admin']['musics']['TopAudioUrl'] = $this->CFG['site']['url'].$this->CFG['admin']['musics']['advertisement_audio_folder'].$row['advertisement_id'].'.'.$row['advertisement_audio_ext'];

								if($row['advertisement_image_ext'] != '')
									$this->CFG['admin']['musics']['TopImageUrl'] = $this->CFG['site']['url'].$this->CFG['admin']['musics']['advertisement_image_folder'].$row['advertisement_id'].$this->CFG['admin']['musics']['advertisement_image_single_name'].'.'.$row['advertisement_image_ext'];
								elseif($row['advertisement_audio_ext'] != '' && $row['advertisement_image_ext'] == '')
									$this->CFG['admin']['musics']['TopImageUrl'] = $this->CFG['site']['url'].'music/design/templates/'.
																				     $this->CFG['html']['template']['default'].'/root/images/'.
																					    $this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_singlePlayerAd.jpg';


								$this->CFG['admin']['musics']['TopUrlTargetUrl'] = $row['advertisement_url'];
								$this->CFG['admin']['musics']['TopUrl'] = true;
								//Duration should not be 0
								$this->CFG['admin']['musics']['Topduration']  = $row['advertisement_duration']!=0?$row['advertisement_duration']:2;
								/*$this->CFG['admin']['musics']['TopUrlType'] = isset($$row['advertisement_ext'])?$$row['advertisement_ext']:$row['advertisement_ext'];
								$this->CFG['admin']['musics']['TopUrlDuration'] = $row['advertisement_duration'];*/
								break;
							}
					}

				$sql = 'SELECT '.$add_fields.' FROM '.$this->CFG['db']['tbl']['music_advertisement'].
						' WHERE'.$user_condn.$default_cond.'(advertisement_show_at=\'Ending\' OR advertisement_show_at=\'Both\')';

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
								/*if($this->CFG['admin']['music_advertisement_impressions'])
									{
										$this->increaseImpressions($row['advertisement_id']);
									}*/
								/*$this->CFG['admin']['musics']['TailImpressionUrl'] .= '?params='.$row['advertisement_id'].'_view_'.$this->fields_arr['ref'].'_'.$this->fields_arr['mid'];
								$this->CFG['admin']['musics']['TailClickCountUrl'] .= '?params='.$row['advertisement_id'].'_click_'.$this->fields_arr['ref'].'_'.$this->fields_arr['mid'];*/
								if($row['advertisement_audio_ext'] != '')
									$this->CFG['admin']['musics']['TailAudioUrl'] = $this->CFG['site']['url'].$this->CFG['admin']['musics']['advertisement_audio_folder'].$row['advertisement_id'].'.'.$row['advertisement_audio_ext'];

								if($row['advertisement_image_ext'] != '')
									$this->CFG['admin']['musics']['TailImageUrl'] = $this->CFG['site']['url'].$this->CFG['admin']['musics']['advertisement_image_folder'].$row['advertisement_id'].$this->CFG['admin']['musics']['advertisement_image_playlist_name'].'.'.$row['advertisement_image_ext'];
								elseif($row['advertisement_audio_ext'] != '' && $row['advertisement_image_ext'] == '')
									$this->CFG['admin']['musics']['TailImageUrl'] = $this->CFG['site']['url'].'music/design/templates/'.
																				     $this->CFG['html']['template']['default'].'/root/images/'.
																					    $this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_singlePlayerAd.jpg';

								$this->CFG['admin']['musics']['TailUrlTargetUrl'] = $row['advertisement_url'];
								$this->CFG['admin']['musics']['TailUrl'] = true;
								//Duration should not be 0
								$this->CFG['admin']['musics']['Tailduration']  = $row['advertisement_duration']!=0?$row['advertisement_duration']:2;
								/*$this->CFG['admin']['musics']['TailUrlType'] = $$row['advertisement_ext'];
								$this->CFG['admin']['musics']['TailUrlDuration'] = $row['advertisement_duration'];*/
								break;
							}
					}
		}

		public function getBestLyric()
		{
			$sql = 'SELECT music_lyric_id FROM '.$this->CFG['db']['tbl']['music_lyric'].
					' WHERE best_lyric = \'Yes\' AND lyric_status = \'Yes\''.
					' AND music_id='.$this->dbObj->Param('music_id');;

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
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

		public function generateMuiscDetailsForQuickMIX()
			{
				$music_lyric_id = $this->getBestLyric();
				$music_lyric_url = '';
				if($music_lyric_id)
					$music_lyric_url = getUrl('viewlyrics', '?music_id='.$this->fields_arr['music_id'].'&music_lyric_id='.$music_lyric_id.'&page=player', '?music_id='.$this->fields_arr['music_id'].'&music_lyric_id='.$music_lyric_id.'&page=player', '', 'music');
				$music_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.
																			$this->CFG['admin']['musics']['music_folder'].'/';
 				$music_path = $this->fields_arr['music_server_url'].
				 					$music_folder.getMusicName($this->fields_arr['music_id']).'.mp3';

				if($this->fields_arr['music_thumb_ext'] != ''){
						$thumbnail = $this->fields_arr['music_server_url'].$this->CFG['media']['folder'].'/'.
																$this->CFG['admin']['musics']['folder'].'/'.
																	$this->CFG['admin']['musics']['thumbnail_folder'].'/'.
																		getMusicImageName($this->fields_arr['music_id']).
																			$this->CFG['admin']['musics']['medium_name'].'.'.
																				$this->fields_arr['music_thumb_ext'];
				}else{
						$thumbnail = $this->CFG['site']['url'].'music/design/templates/'.
																$this->CFG['html']['template']['default'].'/root/images/'.
																	$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_audio_M.jpg';
				}

// 				$thumbnail = $this->CFG['site']['url'].$this->CFG['media']['folder'].'/'.
//										$this->CFG['temp_media']['folder'].'/'.getMusicImageName($this->fields_arr['music_id']).
//												$this->CFG['admin']['musics']['large_name'].'.'.$this->fields_arr['music_thumb_ext'];

				$albumPath = '';
				if(isset($this->fields_arr['music_album_id']) && !empty($this->fields_arr['music_album_id']))
					$albumPath = getUrl('viewalbum','?album_id='.$this->fields_arr['music_album_id'], $this->fields_arr['music_album_id'].'/','','music');

				$artistPath = '';
//				if(isset($this->fields_arr['music_artist_id']) && !empty($this->fields_arr['music_artist_id']))
//					$artistPath = getUrl('artistphoto', '?artist_id='.$this->fields_arr['music_artist_id'], $this->fields_arr['music_artist_id'].'/', '', 'music');

				$musicTitlePath = '';
				if(!empty($this->fields_arr['music_id']))
					$musicTitlePath = getUrl('viewmusic', '?music_id='.$this->fields_arr['music_id'], $this->fields_arr['music_id'].'/', '', 'music');
				$this->selectMusicAdSettings();
				//$artistPath = 'http://192.168.1.118/svn/rayzz/rayzz_3/branches/videos/music/artistPhoto.php?artist_id=24';
				echo 'Path='.$music_path.'#Title='.$this->fields_arr['music_title'].'#Artist='.$this->fields_arr['music_artist'].
							'#Album='.$this->fields_arr['music_album'].'#Plays='.$this->fields_arr['total_plays'].
								'#showPlays=true#BuyUrl='.$this->fields_arr['buy_url'].'#LyricsUrl='.$music_lyric_url.'#Rate=http://rateUrl.com#Comments=http://comments.h#'.
								'ImageUrl='.$thumbnail.'#'.
								'TargetUrl='.$musicTitlePath.'#Target=_blank#downloadUrl=http://google.com#DownloadTarget=_blank#showDownload=true#'.
								'songDuration='.$this->fields_arr['playing_time'].'#id=1#addUrl=add url..11111.....#'.
								'checkUrl='.$this->CFG['site']['url'].'music/musicUpdateQuickMix.php?music_id='.$this->fields_arr['music_id'].'#unCheckUrl='.$this->CFG['site']['url'].'music/musicUpdateQuickMix.php?music_id='.$this->fields_arr['music_id'].'&remove_it=1#'.
								'Type=mp3#getTitlePath='.$musicTitlePath.'#getTitleTarget=_blank#'.
								'getArtistPath='.$artistPath.'#getArtistTarget=_blank#getAlbumPath='.$albumPath.'#getAlbumTarget=_blank'.
								'#songUrl='.$this->CFG['admin']['musics']['TopAudioUrl'].'#imageUrl='.$this->CFG['admin']['musics']['TopImageUrl'].'#imageTime='.$this->CFG['admin']['musics']['Topduration'].'#TargetUrl='.$this->CFG['admin']['musics']['TopUrlTargetUrl'].'#TargetWindow=_blank#songUrl='.$this->CFG['admin']['musics']['TopAudioUrl'].'#imageUrl='.$this->CFG['admin']['musics']['TopImageUrl'].'#imageTime='.$this->CFG['admin']['musics']['Topduration'].'#TargetUrl='.$this->CFG['admin']['musics']['TopUrlTargetUrl'].'#TargetWindow=_blank#songUrl='.$this->CFG['admin']['musics']['TailAudioUrl'].'#imageUrl='.$this->CFG['admin']['musics']['TailImageUrl'].'#imageTime='.$this->CFG['admin']['musics']['Tailduration'].'#TargetUrl='.$this->CFG['admin']['musics']['TailUrlTargetUrl'].'#TargetWindow=_blank#triggerUrl='.$this->CFG['site']['music_url'].'triggerMusicStats.php'.'#checkedStatus=true#LyricsTarget=_blank#SongCost='.$this->fields_arr['music_price'].'#AlbumCost="'.$this->fields_arr['album_price'].'"';


					/*
						SAMPLE

						Path=songs/song1.mp3#Title=SONG 01&Artist=harrish - song three&Album=Jazz&Plays =631,605456789&showPlays=true& BuyUrl=http://url1.com&LyricsUrl =http://gmail1.com&Rate=http://rateUrl.com&Comments=http://comments.h&ImageUrl=images/images2.jpg&TargetUrl = http://google.com& Target=_blank&downloadUrl=http://google.com&DownloadTarget=_blank&showDownload=false&songDuration =05:30&id=17&addUrl=add url..11111.....&checkUrl=checkurl......1111&unCheckUrl=remove url.......1111........&Type=mp3&getTitlePath=http://mail.google.com&getTitleTarget=_blank& getArtistPath=http://yahoo.com&getArtistTarget=_blank&getAlbumPath=http://msn.com&getAlbumTarget=_blank&songUrl=midsongs/mid2.mp3&imageUrl=adImages/image8.jpg&imageTime=5& TargetUrl=http://www.yahoo.com&songUrl=midsongs/mid2.mp3&imageUrl=adImages/image8.jpg&imageTime=5&TargetUrl=http://www.yahoo.com&TargetWindow=_blank&TargetWindow=_blank&songUrl=midsongs/mid2.mp3&imageUrl=adImages/image8.jpg&imageTime=5&TargetUrl=http://www.yahoo.com&TargetWindow=_blank"
					*/

			}

		/**
		 * MusicDetails::storeVolumeInSession()
		 *  STORE GLOBAL VOLUME IN SESSION
		 * @return void
		 */
		public function storeVolumeInSession()
			{
				$_SESSION['music_global_voulme'] = $this->getFormField('volume');
			}

	}
$musicDetails = new MusicDetails();

if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

if(isMember())
	$musicDetails->setMediaPath('../../');
else
	$musicDetails->setMediaPath('../');


$musicDetails->setPageBlockNames(array('music_comments_block'));

//default form fields and values...
$musicDetails->setFormField('music_id', '');
$musicDetails->setFormField('action', '');
$musicDetails->setFormField('music_title', '');
$musicDetails->setFormField('user_name', '');
$musicDetails->setFormField('user_id', '');
$musicDetails->setFormField('type','');
$musicDetails->setFormField('ajax_page','');
$musicDetails->setFormField('volume','');

$musicDetails->sanitizeFormInputs($_REQUEST);

if(isAjaxPage())
	{

		if($musicDetails->chkValidMusicId())
			{
				if($musicDetails->getFormField('action') == 'quickmix')
					{
						$musicDetails->includeAjaxHeaderSessionCheck();
						$musicDetails->generateMuiscDetailsForQuickMIX();
						$musicDetails->includeAjaxFooter();
						exit;
					}
			}



		//STORE GLOBAL VOLUME IN SESSION
		if($musicDetails->getFormField('action') == 'save_volume')
			{
				$musicDetails->includeAjaxHeader();
				$musicDetails->storeVolumeInSession();
				$musicDetails->includeAjaxFooter();
				exit;
			}
	}
	//else{
//	echo '<br>test12';exit;
//	}
?>