<?php

/**
 * This file is to get xml code
 *
 * This file is having get xml code
 *
 *
 * @category	rayzz
 * @package		Index
 * @author 		selvaraj_35ag05
 * @copyright 	Copyright (c) 2006 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
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

		/**
		 * XmlCode::populateMusicDetails()
		 *
		 * @return array
		 **/
		public function populateMusicDetails($status)
			{
				$populateMusicDetails_arr = array();
				$cond = $status?'music_status=\'Ok\'':'music_status!=\'Ok\'';
				$inc = 1;
				$mid_arr = explode(',', $this->fields_arr['mid']);

				$public_condition = ' AND (m.user_id = '.$this->CFG['user']['user_id'].' OR m.music_access_type = \'Public\''.
										$this->getAdditionalQuery('m.').')'.
											$this->getAdultQuery('m.', 'music');

				foreach($mid_arr as $music_id)
					{

						$sql = 'SELECT m.music_id, m.user_id, u.user_name, m.music_ext, '.
								'm.music_title, m.music_server_url, m.thumb_width, '.
								'm.thumb_height, m.total_views, m.music_tags, m.music_upload_type,m.music_price, '.
								'(m.rating_total/m.rating_count) as rating, m.playing_time, '.
								'm.music_thumb_ext, m.music_artist, ma.album_title,ma.album_for_sale,ma.album_access_type, ma.album_price, m.music_category_id, '.
								'm.rating_count, m.total_plays, mc.music_category_name, u.user_name as artist_name, mr.music_artist_id,'.
								' ma.music_album_id, m.music_url, m.for_sale '.
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

								$populateMusicDetails_arr[$inc]['music_url'] = $row['music_url'];
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
								$populateMusicDetails_arr[$inc]['music_price'] = '';
								if($row['album_for_sale']=='Yes'
									and $row['album_access_type']=='Private'
									and $row['album_price']>0)
								{
									$populateMusicDetails_arr[$inc]['for_sale'] = 'No';
									$populateMusicDetails_arr[$inc]['album_for_sale'] = $row['album_for_sale'];
									$populateMusicDetails_arr[$inc]['music_price'] = $this->CFG['currency'].$row['album_price'];
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
					}
				return $populateMusicDetails_arr;
			}

		/**
		 * XmlCode::selectMusicAdSettings()
		 *
		 * @return void
		 */
		public function selectMusicAdSettings()
			{
				$this->CFG['admin']['musics']['TailUrlUrl'] = $this->CFG['admin']['musics']['TailUrlTargetUrl'] =
					$this->CFG['admin']['musics']['TopUrlUrl'] = $this->CFG['admin']['musics']['TopUrlTargetUrl'] =
						$this->CFG['admin']['musics']['TopAudioUrl'] = $this->CFG['admin']['musics']['TailAudioUrl'] =
							$this->CFG['admin']['musics']['Topduration'] = $this->CFG['admin']['musics']['Tailduration'] =
								$this->CFG['admin']['musics']['TopImageUrl'] = $this->CFG['admin']['musics']['TailImageUrl'] = '';

				$this->CFG['admin']['musics']['TopUrl'] = $this->CFG['admin']['musics']['TailUrl'] = false;

				$user_condn = ' 1 AND ';

				$musicDetails_arr = $this->populateMusicDetails(true);

				$categoryId = '';

				for($i=1; $i <= count($musicDetails_arr);$i++){
					$categoryId .= $musicDetails_arr[$i]['music_category_id'].',';
				}
				$categoryIds = explode(',',substr($categoryId,0,-1));
				/*echo '<pre>';
				print_r($categoryIds);
				echo '</pre>';*/
				$findinCondition = '';
				foreach($categoryIds as $categoryId){
					if(!empty($categoryId))
						$findinCondition .= '(FIND_IN_SET('.$categoryId.',advertisement_channel)) OR ';
				}

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
									$this->CFG['admin']['musics']['TailImageUrl'] = $this->CFG['site']['url'].$this->CFG['admin']['musics']['advertisement_image_folder'].$row['advertisement_id'].$this->CFG['admin']['musics']['advertisement_image_single_name'].'.'.$row['advertisement_image_ext'];
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
		 * XmlCode::getXmlCode()
		 *
		 * @return void
		 */
		public function getXmlCode()
			{
				$fields = explode('_', $this->fields_arr['pg']);
				$this->fields_arr['pg'] = $fields[0];

				if(isset($fields[1]))
					$this->fields_arr['mid'] = $fields[1];

				/*if(isset($fields[2]))
					$this->fields_arr['ref'] = $fields[2];*/

				if(!($this->fields_arr['pg'] and $this->fields_arr['mid']))
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
							$musicDetails_arr = $this->populateMusicDetails(true);
							$musiclist_arr = array();
							$inc = 0;

							foreach($musicDetails_arr as $music_details_arr)
								{
									//POPULATE THE BEST LYRIC URL
									$music_details_arr['music_lyric_id'] = $this->getBestLyric($music_details_arr['music_id']);
									$musiclist_arr[$inc]['music_lyric_url'] = '';
									if($music_details_arr['music_lyric_id'])
										$musiclist_arr[$inc]['music_lyric_url'] = getUrl('viewlyrics', '?music_id='.$music_details_arr['music_id'].'&amp;music_lyric_id='.$music_details_arr['music_lyric_id'].'&amp;page=player', '?music_id='.$music_details_arr['music_id'].'&amp;music_lyric_id='.$music_details_arr['music_lyric_id'].'&amp;page=player', '', 'music');
									$music_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.
																			$this->CFG['admin']['musics']['music_folder'].'/';
									$chkTrimedMusic = false;
									$musiclist_arr[$inc]['albumPath'] = '';
									if(!empty($music_details_arr['music_album_id']))
										$musiclist_arr[$inc]['albumPath'] = getUrl('viewalbum','?album_id='.$music_details_arr['music_album_id'].'&title='.$this->changeTitle($music_details_arr['music_album']), $music_details_arr['music_album_id'].'/'.$this->changeTitle($music_details_arr['music_album']).'/', '','music');
									$musiclist_arr[$inc]['artistName'] = $music_details_arr['music_artist'];
									//$musiclist_arr[$inc]['artistName'] = $this->getArtistsNames($music_details_arr['music_artist_id']);
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
																							$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_audio_SinglePlayer.jpg';
											}
										$inc++;
								}

							$this->selectMusicAdSettings();
							break;

						case 'musicactivate':
							$musicDetails_arr = $this->populateMusicDetails(false);
							$showTrimmedheader='false';
							$sharing_args='music_id='.$this->fields_arr['mid'].'&amp;page=music';
							$musiclist_arr = array();
							$inc = 0;
							/*echo '<pre>';
							print_r($musicDetails_arr);
							echo '</pre>';*/
							foreach($musicDetails_arr as $music_details_arr){
								$music_folder = $this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin']['musics']['temp_folder'].'/';

								$musiclist_arr[$inc]['albumPath'] = '';

								if(!empty($music_details_arr['music_album_id']))
									$musiclist_arr[$inc]['albumPath'] = getUrl('viewalbum','?album_id='.$music_details_arr['music_album_id'].'&title='.$this->changeTitle($music_details_arr['music_album']), $music_details_arr['music_album_id'].'/'.$this->changeTitle($music_details_arr['music_album']).'/', '','music');


								$musiclist_arr[$inc]['artistName'] = $this->getArtistsNames($music_details_arr['music_artist_id']);
								$musiclist_arr[$inc]['artistPath'] = '';
								/*$musiclist_arr[$inc]['artistPath'] = '';
								if(!empty($music_details_arr['music_artist_id']))
									$musiclist_arr[$inc]['artistPath'] = getUrl('artistphoto', '?artist_id='.$music_details_arr['music_artist_id'].'&name='.$this->changeTitle($music_details_arr['music_artist']), $music_details_arr['music_artist_id'].'/'.$this->changeTitle($music_details_arr['music_artist']).'/', '', 'music');
								*/

								if(!empty($music_details_arr['music_id']))
									$musiclist_arr[$inc]['musicTitlePath'] = getUrl('viewmusic', '?music_id='.$music_details_arr['music_id'].'&title='.$this->changeTitle($music_details_arr['music_title']), $music_details_arr['music_id'].'/'.$this->changeTitle($music_details_arr['music_title']).'/', '', 'music');


								if($music_details_arr['music_upload_type']=='Normal')
									$musiclist_arr[$inc]['music_url'] = $music_details_arr['music_server_url'].$music_folder.getMusicName($music_details_arr['music_id']).'.mp3';
								else{
									if(!$music_details_arr['music_url']){
										$musiclist_arr[$inc]['music_url'] = $music_details_arr['music_server_url'].$music_folder.getMusicName($music_details_arr['music_id']).'.mp3';
									}
								}

								if($music_details_arr['music_thumb_ext'] != ''){
									$musiclist_arr[$inc]['thumbnail'] = $music_details_arr['music_server_url'].$this->CFG['media']['folder'].'/'.
																			$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin']['musics']['temp_folder'].'/'.
																				getMusicImageName($music_details_arr['music_id']).
																					$this->CFG['admin']['musics']['medium_name'].'.'.
																						$music_details_arr['music_thumb_ext'];
								}else{
									$musiclist_arr[$inc]['thumbnail'] = $this->CFG['site']['url'].'music/design/templates/'.
																			$this->CFG['html']['template']['default'].'/root/images/'.
																				$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_audio_SinglePlayer.jpg';
								}
								$inc++;
							}
							$this->selectMusicAdSettings();
							/*$this->selectLogoSettings();
							$this->selectMusicAdSettings();*/
							break;
					}

if (count($musiclist_arr))
{
?>
<PATH>
	<SONGS>
<?php
	$inc = 1;
	foreach($musiclist_arr as $musics_arr){
?>
		<PREROLL songUrl="<?php echo $this->CFG['admin']['musics']['TopAudioUrl'];?>" imageUrl = "<?php echo $this->CFG['admin']['musics']['TopImageUrl'];?>" imageTime="<?php echo $this->CFG['admin']['musics']['Topduration'];?>"  TargetUrl="<?php echo $this->CFG['admin']['musics']['TopUrlTargetUrl'];?>" TargetWindow="_blank"/>
		<SONG Path="" TokenNumber="<?php echo $musics_arr['music_url']; ?>" TokenId="true" Title="<?php echo $musicDetails_arr[$inc]['music_title']; ?>" Artist="<?php echo $musics_arr['artistName']; ?>" Album="<?php echo $musicDetails_arr[$inc]['music_album']; ?>" Plays="<?php echo $musicDetails_arr[$inc]['total_plays']; ?>" showPlays="true" BuyUrl="<?php echo $musicDetails_arr[$inc]['buy_url'];?>" LyricsUrl="<?php echo $musics_arr['music_lyric_url']; ?>"  Rate="http://rateUrl.com" Comments="http://comments.h" ImageUrl="<?php echo $musics_arr['thumbnail']; ?>" TargetUrl="<?php echo $musics_arr['musicTitlePath']; ?>" Target="_blank" downloadUrl="http://google.com" DownloadTarget="_blank" showDownload="<?php echo $this->CFG['admin']['musics']['download_option'];?>" songDuration="<?php echo $musicDetails_arr[$inc]['playing_time']; ?>" id="<?php echo $this->fields_arr['mid']; ?>" addUrl="add url..11111....." checkUrl="check url......1111" unCheckUrl="remove url.......1111........" Type="mp3" getTitlePath="<?php echo $musics_arr['musicTitlePath']; ?>" getTitleTarget="_blank" getArtistPath="<?php echo $musics_arr['artistPath']; ?>" getArtistTarget="_blank" getAlbumPath="<?php echo $musics_arr['albumPath']; ?>" getAlbumTarget="_blank" triggerUrl="<?php echo $this->CFG['site']['music_url'].'triggerMusicStats.php';?>" SongCost="<?php echo $musicDetails_arr[$inc]['music_price'];?>"/>
		<POSTROLL songUrl="<?php echo $this->CFG['admin']['musics']['TailAudioUrl'];?>" imageUrl = "<?php echo $this->CFG['admin']['musics']['TailImageUrl'];?>" imageTime="<?php echo $this->CFG['admin']['musics']['Tailduration'];?>"  TargetUrl="<?php echo $this->CFG['admin']['musics']['TailUrlTargetUrl'];?>" TargetWindow="_blank"/>
<?php
		$inc++;
	}
?>
	</SONGS>
</PATH><?php
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

$CFG['user']['user_id'] = isset($_SESSION['user']['user_id'])?$_SESSION['user']['user_id']:'0';
$CFG['admin']['is_logged_in'] = isset($_SESSION['admin']['is_logged_in'])?$_SESSION['admin']['is_logged_in']:'0';
$XmlCode->makeGlobalize($CFG,$LANG);
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
?>