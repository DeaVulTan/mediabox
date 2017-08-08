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
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2006-05-02
 *
 **/

require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_video.inc.php');
require_once('../common/configs/config_video_player.inc.php');
$CFG['site']['is_module_page']='video';
$CFG['lang']['include_files'][] = 'languages/%s/video/videoConfiguration.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['auth']['is_authenticate'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');

/**
 * XmlCode
 *
 * @package
 * @author selvaraj_35ag05
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: $
 * @access public
 **/
class XmlCode extends MediaHandler
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
		 * XmlCode::populatePhotoDetails()
		 *
		 * @return
		 **/
		public function populateVideoDetails()
			{
				$sql = 'SELECT video_server_url, video_title,  video_tags, video_category_id FROM '.$this->CFG['db']['tbl']['video'].
						' WHERE video_status=\'Ok\' AND video_id='.$this->dbObj->Param('this').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['vid']));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						$this->fields_arr['video_server_url'] = $row['video_server_url'];
						$this->fields_arr['video_title'] = $row['video_title'];
						$this->fields_arr['video_tags'] = $row['video_tags'];
						$this->fields_arr['video_category_id'] = $row['video_category_id'];
						return true;
					}
				return false;
			}

		public function populateVideoSelectQuery($recent_view_check=false)
			{
				$add_field = '';
				$add_con = ' AND vc.video_category_id=v.video_category_id ';
				$add_order = ' ORDER BY last_view_date DESC ';
				$sql_condition = ' v.video_status=\'Ok\''.
								 ' AND (v.user_id = '.$this->CFG['user']['user_id'].
								 ' OR v.video_access_type = \'Public\''.$this->getAdditionalQuery('v.').')'.$add_con;
				$minutes_seconds=($this->CFG['admin']['videos']['recent_view_videos_seconds'])?$this->CFG['admin']['videos']['recent_view_videos_seconds']:60;
				if($recent_view_check)
					$sql_condition .= ' AND  last_view_date >= DATE_SUB(now(), INTERVAL '.$minutes_seconds.' SECOND) ';
				 $sql = 'SELECT TIME_FORMAT(v.playing_time,\'%H:%i:%s\') as playing_time, v.video_id, vc.video_category_name, v.user_id, v.video_title, v.video_caption,'.
						' TIMEDIFF(NOW(), v.date_added) as date_added, v.rating_total, v.rating_count, v.total_comments,'.
						' v.video_server_url, '.$add_field.'v.total_views,'.
						' v.s_width, v.s_height, v.video_ext, v.video_tags,v.is_external_embed_video,embed_video_image_ext FROM '.$this->CFG['db']['tbl']['video'].' AS v, '.$this->CFG['db']['tbl']['video_category'].' AS vc WHERE '.$sql_condition.$add_order.' LIMIT 10';

				return $sql;
			}

		public function getXmlCode($LANG)
			{
				//echo print_r($LANG);
				//exit;
				$fields = explode('_', $this->fields_arr['pg']);
				$this->fields_arr['pg'] = $fields[0];
//				$this->fields_arr['vid'] = $fields[1];
				$all_video_url = getUrl('videolist','?pg=videomostrecentlyviewed', 'videomostrecentlyviewed/');
				$title_video=$LANG['index_page_videos_lastly_viewed_title'];
				$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
				$this->CFG['admin']['videos']['index_page_video_list_refresh_rates']=($this->CFG['admin']['videos']['index_page_video_list_refresh_rates'])?
						$this->CFG['admin']['videos']['index_page_video_list_refresh_rates']:10000;


				//being watched
				$sql = $this->populateVideoSelectQuery($recent_view_check=true);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($rs->PO_RecordCount() >= $this->CFG['admin']['videos']['recent_videos_play_list_counts'])
					$title_video=$LANG['index_page_videos_recent_viewed_title'];
					else
						{
							//recently watched
							$sql = $this->populateVideoSelectQuery($recent_view_check=false);
							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt);
						    if (!$rs)
							    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
						}

?>
<FLV_PLAYLIST Refresh="<?php echo $this->CFG['admin']['videos']['index_page_video_list_refresh_rates']; ?>"
SongTextColor="<?php echo $this->CFG['admin']['videos']['index_page_video_list_title_text_color']; ?>"
TitleTextBold="<?php echo ($this->CFG['admin']['videos']['index_page_video_list_title_text_bold'])?'true':'false'; ?>"
TitleTextItalic="<?php echo ($this->CFG['admin']['videos']['index_page_video_list_title_text_italic'])?'true':'false'; ?>"
TitleTextUnderline="<?php echo ($this->CFG['admin']['videos']['index_page_video_list_title_text_underline'])?'true':'false'; ?>"
TitleTextSize="<?php echo $this->CFG['admin']['videos']['index_page_video_list_title_text_size']; ?>"
TitleTextStyle="<?php echo $this->CFG['admin']['videos']['index_page_video_list_title_text_style']; ?>"
ThumbnailGap="<?php echo $this->CFG['admin']['videos']['index_page_video_list_thumbnail_gap']; ?>"
Sequence="order" Title="<?php //echo $title_video; ?>" viewallurl="<?php echo $all_video_url; ?>" viewalltarget="_self">
<?php
				if ($total_records = $rs->PO_RecordCount())
				    {
						$fields_list = array('user_name', 'first_name', 'last_name');
						while($row = $rs->FetchRow())
						    {
								if(!isset($this->UserDetails[$row['user_id']]))
									$this->getUserDetail('user_id',$row['user_id'], 'user_name');
								$name = $this->getUserDetail('user_id',$row['user_id'], 'user_name');;
								$duration = '000:00';
								if($row['playing_time'])
									{
										$playing_time = explode(':', $row['playing_time']);
										$temp = (intval($playing_time[0])*60)+intval($playing_time[1]);
										$duration =	 $row['playing_time'];
									}
								$url = getUrl('viewvideo', '?video_id=' . $row['video_id'] . '&title=' . $this->changeTitle($row['video_title']), $row['video_id'] . '/' . $this->changeTitle($row['video_title']) . '/', '', 'video');

								$thumbnail_url = '';
								$thumbnail_url = $row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id']).'T.'.$this->CFG['video']['image']['extensions'];

								if (($row['is_external_embed_video'] == 'Yes' && $row['embed_video_image_ext'] == ''))
								  {
				                    $thumbnail_url = $this->CFG['site']['video_url'].'design/templates/'.
														$this->CFG['html']['template']['default'].'/root/images/'.
															$this->CFG['html']['stylesheet']['screen']['default'].
															 '/no_image/noImageVideo_WatchedNow.jpg';
                                  }
								$rate=($row['rating_total'] and $row['rating_count'])?round($row['rating_total']/$row['rating_count']):0;
?>
	<VIDEO Name="<?php echo $row['video_title']; ?>" Duration="<?php echo $duration;?>" rate="<?php echo $rate;?>" category="<?php echo $row['video_category_name']; ?>" Thumbnails="<?php echo $thumbnail_url;?>" url="<?php echo $url;?>" target="_self"/>
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
<FLV_PLAYLIST Title="Video is Being Watched Now......"  TitleTextColor="0x00FF00" TitleTextBold="true" TitleTextItalic="true" TitleTextUnderline="false" TitleTextSize="10" TitleTextStyle="verdana" Refresh="2000" ThumbnailGap="35" Sequence="order" viewallurl="videoList.php?pg=videonew" InitGap="0" viewalltarget="_self" AnimationStyle="1" ShowRating="false" ShowPlayText="false" songTitleColor="0x00ff00" ThumbCounts="5" ShowPlayPanel="true">
	<VIDEO Name="Maine pyar kiya hai au" Duration="2:30" rate="1" category="Singing" Thumbnails="photo/1.jpg" url="someurl" target="_blank"/>
	<VIDEO Name="Maine pyar kiya hai au" Duration="3:40" rate="2" category="Singing" Thumbnails="photo/1.jpg" url="someurl2" target="_blank" />
	<VIDEO Name="Maine pyar kiya hai au" Duration="1:20" rate="3" category="Singing" Thumbnails="photo/1.jpg" url="someurl3" target="_blank" />
	<VIDEO Name="Maine pyar kiya hai au" Duration="2:30" rate="1" category="Singing" Thumbnails="photo/2.jpg" url="someurl" target="_blank"/>
	<VIDEO Name="Maine pyar kiya hai au" Duration="3:40" rate="2" category="Singing" Thumbnails="photo/2.jpg" url="someurl2" target="_self" />
	<VIDEO Name="Maine pyar kiya hai au" Duration="1:20" rate="3" category="Singing" Thumbnails="photo/2.jpg" url="someurl3" target="_self" />
	<VIDEO Name="Maine pyar kiya hai au"  Duration="1:40" rate="5" category="Singing" Thumbnails="photo/4.jpg" url="someurl4" target="_self"/>
	<VIDEO Name="Maine pyar kiya hai au" Duration="2:50" rate="4" category="Singing" Thumbnails="photo/3.jpg" url="someurl5" target="_self" />
</FLV_PLAYLIST>
<FLV_PLAYLIST Title="Video is Being Watched Now......" ThumbnailPerPage="5" AnimationStyle="youtube" SongTextColor="0xFF0000" TitleTextColor="0x000000" TitleTextBold="false" TitleTextItalic="true" TitleTextUnderline="true" TitleTextSize="14" TitleTextStyle="verdana" Refresh="10000" ThumbnailGap="20" Sequence="order" viewallurl="videoList.php?pg=videonew" viewalltarget="_self">
<?php
			}
	}
//<<<<<-------------- Class XmlCode begins ---------------//
//-------------------- Code begins -------------->>>>>//
$XmlCode = new XmlCode();
setHeaderStart();
$XmlCode->setDBObject($db);
$CFG['user']['user_id'] = isset($_SESSION['user']['user_id'])?$_SESSION['user']['user_id']:'0';
$XmlCode->makeGlobalize($CFG,$LANG);
$XmlCode->setPageBlockNames(array('get_code_form'));
//default form fields and values...
$XmlCode->setFormField('vid', '');
$XmlCode->setFormField('pg', '');
$XmlCode->setFormField('gurl', '');

//To set style according to template
$XmlCode->CFG['admin']['videos']['index_page_video_list_title_text_color'] = $CFG['admin'][$CFG['html']['template']['default']]
																				['videos']['index_page_video_list_title_text_color'];

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
//require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');
?>