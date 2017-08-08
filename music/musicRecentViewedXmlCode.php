<?php
/**
 * This file is to get xml code
 *
 * This file is having get xml code
 *
 *
 * @category	rayzz
 * @package		Index
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
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
		 * XmlCode::setHeaderStart()
		 * clear cache and buffer start
		 *
		 * @return
		 **/
		public function setHeaderStart()
			{
				ob_start();
				header("Pragma: no-cache");
				header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
				header("Expires: 0"); // Date in the past
				header("Content-type: text/xml; charset=iso-8859-1");
			}

		/**
		 * XmlCode::populateMusicSelectQuery()
		 *
		 * @param boolean $recent_view_check
		 * @return string
		 */
		public function populateMusicSelectQuery($recent_view_check=false)
			{
				$add_field = '';
				$add_con = ' AND ma.music_album_id=m.music_album_id AND u.user_id = m.user_id AND u.usr_status=\'Ok\' ';
				$add_order = ' ORDER BY m.last_view_date DESC ';
				$sql_condition = ' m.music_status=\'Ok\''.
								 ' AND (m.user_id = '.$this->CFG['user']['user_id'].
								 ' OR m.music_access_type = \'Public\''.$this->getAdditionalQuery('m.').')'.$add_con.$this->getAdultQuery('m.', 'music');

				$minutes_seconds=($this->CFG['admin']['musics']['recent_view_musics_seconds'])?$this->CFG['admin']['musics']['recent_view_musics_seconds']:60;

				if($recent_view_check)
					$sql_condition .= ' AND  last_view_date >= DATE_SUB(now(), INTERVAL '.$minutes_seconds.' SECOND) ';


				$populateCurrentlyPlayingSongsDetail_arr['row'] = array();

				$sql = 'SELECT TIME_FORMAT(m.playing_time,\'%H:%i:%s\') as playing_time, m.music_id, mc.music_category_name, m.music_title, ma.album_title, m.user_id, '.
						'TIMEDIFF(NOW(), m.date_added) as date_added, m.rating_total, m.rating_count, m.total_comments, '.
						'm.total_views, m.music_tags , m.music_server_url, m.music_thumb_ext, mfs.file_name, m.medium_width, m.medium_height  FROM '.
						$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['music_files_settings'].
						' AS mfs ON mfs.music_file_id = m.thumb_name_id JOIN '.$this->CFG['db']['tbl']['music_category'].
						' as mc ON mc.music_category_id = m.music_category_id, '.
						$this->CFG['db']['tbl']['music_album'].' AS ma, '.$this->CFG['db']['tbl']['users'].
						' AS u WHERE '.$sql_condition.$add_order.' LIMIT 1,'.$this->CFG['admin']['musics']['index_page_music_list_query_limit'];

				return $sql;
			}

		/**
		 * XmlCode::getXmlCode()
		 *
		 * @param mixed $LANG
		 * @return
		 */
		public function getXmlCode($LANG)
			{

				$fields = explode('_', $this->fields_arr['pg']);
				$this->fields_arr['pg'] = $fields[0];
				$all_music_url = getUrl('musiclist','?pg=musicmostrecentlyviewed', 'musicmostrecentlyviewed/');
				$title_video = $LANG['index_page_musics_lastly_viewed_title'];
				$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].
										'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';

				$this->CFG['admin']['musics']['index_page_music_list_refresh_rates']=($this->CFG['admin']['musics']['index_page_music_list_refresh_rates'])?
						$this->CFG['admin']['musics']['index_page_music_list_refresh_rates']:10000;

				//being watched
				$sql = $this->populateMusicSelectQuery($recent_view_check=true);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
				    	$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($rs->PO_RecordCount() >= $this->CFG['admin']['musics']['index_page_music_list_total_thumbnail'])
					$title_music = $LANG['index_page_musics_recent_viewed_title'];
				else
					{
						//recently watched
						$sql = $this->populateMusicSelectQuery($recent_view_check=false);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.
								$this->dbObj->ErrorMsg(), E_USER_ERROR);
					}

?>
<FLV_PLAYLIST  ThumbnailPerPage="<?php echo $this->CFG['admin']['musics']['index_page_music_list_total_thumbnail']; ?>"
SongTextColor="<?php echo $this->CFG['admin']['musics']['index_page_music_list_song_text_color']; ?>"
SongTextSize="<?php echo $this->CFG['admin']['musics']['index_page_music_list_song_text_size']; ?>"
SongTextStyle="<?php echo $this->CFG['admin']['musics']['index_page_music_list_song_text_style']; ?>"
SongTextBold="<?php echo ($this->CFG['admin']['musics']['index_page_music_list_song_text_bold'])?'true':'false'; ?>"
AlbumTextColor="<?php echo $this->CFG['admin']['musics']['index_page_music_list_album_text_color']; ?>"
AlbumTextSize="<?php echo $this->CFG['admin']['musics']['index_page_music_list_album_text_size']; ?>"
AlbumTextStyle="<?php echo $this->CFG['admin']['musics']['index_page_music_list_album_text_style']; ?>"
AlbumTextBold="<?php echo ($this->CFG['admin']['musics']['index_page_music_list_album_text_bold'])?'true':'false'; ?>"
Refresh="<?php echo $this->CFG['admin']['musics']['index_page_music_list_refresh_rates']; ?>"
ThumbnailGap="<?php echo $this->CFG['admin']['musics']['index_page_music_list_thumbnail_gap']; ?>"
Sequence="order"
viewallurl="<?php echo $all_music_url; ?>"
viewalltarget="_self">
<?php

				if ($total_records = $rs->PO_RecordCount())
				    {
						while($row = $rs->FetchRow())
						    {
								$name = $this->getUserDetail('user_id', $row['user_id'], "user_name");
								$duration = !empty($row['playing_time'])?$row['playing_time']:'00:00';
								//$duration = '00:00';

								/*if($row['playing_time'])
									{
										$playing_time = explode(':', $row['playing_time']);
										$temp = (intval($playing_time[0])*60)+intval($playing_time[1]);
										$duration =	$temp.':'.$playing_time[2];
									}*/
								$music_url = getUrl('viewmusic', '?music_id='.$row['music_id'].'&title='.$this->changeTitle($row['music_title']),
												$row['music_id'].'/'.$this->changeTitle($row['music_title']).'/', '', 'music');

								$album_url = getUrl('viewalbum', '?album_id='.$row['music_id'].'&title='.$this->changeTitle($row['music_title']),
												$row['music_id'].'/'.$this->changeTitle($row['music_title']).'/', '', 'music');

								if(!empty($row['music_thumb_ext']))
									$thumbnail_url = $row['music_server_url'].$thumbnail_folder.getMusicImageName($row['music_id']).'M.'.$row['music_thumb_ext'];
								else
									$thumbnail_url = $this->CFG['site']['url'].'music/design/templates/'.
									 				$this->CFG['html']['template']['default'].'/root/images/'.
													$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_audio_M.jpg';

								$rate=($row['rating_total'] and $row['rating_count'])?round($row['rating_total']/$row['rating_count']):0;
								$row['music_title'] = wordWrap_mb_Manual($row['music_title'], 10, 13, true);
								$row['album_title'] = wordWrap_mb_Manual($row['album_title'], 10, 13, true);


?>
	<VIDEO Name="<?php echo $row['music_title']; ?>" AlbumName="<?php echo $row['album_title']; ?>" Duration="<?php echo $duration; ?>" rate="<?php echo $rate;?>" category="<?php echo $row['music_category_name']; ?>" Thumbnails="<?php echo $thumbnail_url;?>" url="<?php echo $music_url; ?>" Albumurl="<?php echo $album_url; ?>" target="_self"/>
<?php
							}
					}
?>
</FLV_PLAYLIST>
<?php
			}


		public function getXmlCode1() //This is the real format. For ref use this
			{
?>
<FLV_PLAYLIST  ThumbnailPerPage="4"  SongTextColor="0xFFFFFF" AlbumTextColor="0x9F9F9F"   SongTextSize="12" SongTextStyle="Trebuchet MS" SongTextBold="true" AlbumTextSize="14" AlbumTextStyle="verdana" AlbumTextBold="false" Refresh="10000" ThumbnailGap="5" Sequence="order" viewallurl="videoList.php?pg=videonew" viewalltarget="_self">
	<VIDEO Name="Pardes" AlbumName="HindiAlbum" Duration="2:30" rate="1" category="Singing" Thumbnails="photo/1.jpg" url="http://rayzz.net/" Albumurl="http://www.mediabox.uz/" target="_self"/>
	<VIDEO Name="Hindustani " AlbumName="HindiAlbum" Duration="3:40" rate="2" category="Singing" Thumbnails="photo/2.jpg" url="http://rayzz.net/" Albumurl="http://www.mediabox.uz/"  target="_self" />
	<VIDEO Name="Roja " AlbumName="TamilAlbum" Duration="1:20" rate="3" category="Singing" Thumbnails="photo/3.jpg" url="http://rayzz.net/" Albumurl="http://www.mediabox.uz/" target="_self" />
	<VIDEO Name="I Just Call " AlbumName="EnglisAlbum" Duration="2:30" rate="1" category="Singing" Thumbnails="photo/10.jpg" url="http://rayzz.net/" Albumurl="http://www.mediabox.uz/" target="_self"/>
	<VIDEO Name="Dil Chata Hai "AlbumName="HindiAlbum"  Duration="3:40" rate="2" category="Singing" Thumbnails="photo/2.jpg" url="http://rayzz.net/" Albumurl="http://www.mediabox.uz/" target="_self" />
	<VIDEO Name="Endhiran " AlbumName="TamilAlbum" Duration="1:20" rate="3" category="Singing" Thumbnails="photo/3.jpg"url="http://rayzz.net/" Albumurl="http://www.mediabox.uz/" target="_self" />
	<VIDEO Name="Sweet Criminal" AlbumName="EnglishAlbum" Duration="1:40" rate="5" category="Singing" Thumbnails="photo/4.jpg" url="http://rayzz.net/" Albumurl=""http://www.mediabox.uz/" target="_self"/>
	<VIDEO Name="Rang De Bansti" AlbumName="HindiAlbum" Duration="2:50" rate="4" category="Singing" Thumbnails="photo/5.jpg" url="http://rayzz.net/" Albumurl="http://www.mediabox.uz/" target="_self" />
</FLV_PLAYLIST>
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

$XmlCode->setPageBlockNames(array('get_code_form'));
//default form fields and values...
$XmlCode->setFormField('mid', '');
$XmlCode->setFormField('pg', '');
$XmlCode->setFormField('gurl', '');

//To set style according to template
$XmlCode->CFG['admin']['musics']['index_page_music_list_song_text_color'] = $CFG['admin'][$CFG['html']['template']['default']]['musics']['index_page_music_list_title_text_color'];
$XmlCode->CFG['admin']['musics']['index_page_music_list_song_text_size'] = $CFG['admin'][$CFG['html']['template']['default']]['musics']['index_page_music_list_song_text_size'];
$XmlCode->CFG['admin']['musics']['index_page_music_list_song_text_style'] = $CFG['admin'][$CFG['html']['template']['default']]['musics']['index_page_music_list_song_text_style'];
$XmlCode->CFG['admin']['musics']['index_page_music_list_song_text_bold'] = $CFG['admin'][$CFG['html']['template']['default']]['musics']['index_page_music_list_song_text_bold'];
$XmlCode->CFG['admin']['musics']['index_page_music_list_album_text_color'] = $CFG['admin'][$CFG['html']['template']['default']]['musics']['index_page_music_list_album_text_color'];
$XmlCode->CFG['admin']['musics']['index_page_music_list_album_text_size'] = $CFG['admin'][$CFG['html']['template']['default']]['musics']['index_page_music_list_album_text_size'];
$XmlCode->CFG['admin']['musics']['index_page_music_list_album_text_style'] = $CFG['admin'][$CFG['html']['template']['default']]['musics']['index_page_music_list_album_text_style'];
$XmlCode->CFG['admin']['musics']['index_page_music_list_album_text_bold'] = $CFG['admin'][$CFG['html']['template']['default']]['musics']['index_page_music_list_album_text_bold'];

$XmlCode->setPageBlockShow('get_code_form');
$XmlCode->sanitizeFormInputs($_GET);
//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($XmlCode->isShowPageBlock('get_code_form'))
    {
		$XmlCode->getXmlCode($LANG);
		//$XmlCode->getXmlCode1();
	}
//<<<<<-------------------- Page block templates ends -------------------//
setHeaderEnd();
?>