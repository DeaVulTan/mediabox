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
$CFG['lang']['include_files'][] = 'languages/%s/video/videoConfiguration.php';
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

		public function selectVideoPlayerSettings()
			{
				$sql = 'SELECT show_play_list_by FROM '.$this->CFG['db']['tbl']['video_player_settings'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$this->CFG['admin']['videos']['show_play_list_by'] = 'groups';
				if($row = $rs->FetchRow())
					{
						$this->CFG['admin']['videos']['show_play_list_by'] = $row['show_play_list_by'];
					}
			}

		//$sql = 'SELECT '

		public function populateVideoSelectQuery()
			{
				$this->selectVideoPlayerSettings();
				$add_con = $add_order = $add_field = '';
				switch($this->CFG['admin']['videos']['show_play_list_by'])
					{
						case 'tags':
							$add_field = '';
							$add_con = ' AND '.getSearchRegularExpressionQueryModified($this->fields_arr['video_tags'], 'video_tags', '');
							$add_order = ' ORDER BY video_id DESC';
							break;

						case 'channel':
							$add_con = ' AND video_category_id=\''.$this->fields_arr['video_category_id'].'\'';
							$add_order = ' ORDER BY video_id DESC';
							break;

						case 'random':
							$add_con = '';
							$add_order = ' ORDER BY RAND()';
							break;
					}
				$sql_condition = 'v.video_id!=\''.addslashes(trim($this->fields_arr['vid'])).'\' AND v.video_status=\'Ok\''.
									' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR v.video_access_type = \'Public\''.$this->getAdditionalQuery('v.').')'.$add_con;

				return $sql = 'SELECT v.playing_time, v.video_id, v.user_id, v.video_title, v.video_caption,'.
						' TIMEDIFF(NOW(), date_added) as date_added, v.rating_total, v.rating_count, v.total_comments,'.
						' v.video_server_url, '.$add_field.'v.total_views,'.
						' v.s_width, v.s_height, v.video_ext, v.video_tags FROM '.$this->CFG['db']['tbl']['video'].' AS v WHERE '.$sql_condition.$add_order.' LIMIT 20';
			}

		/**
		 * XmlCode::populatePhotoDetails()
		 *
		 * @return
		 **/
		public function populateGroupVideoDetails()
			{
				$sql = 'SELECT group_video_server_url, group_video_title, group_id, group_video_tags FROM '.$this->CFG['db']['tbl']['group_video'].
						' WHERE group_video_status=\'Ok\' AND group_video_id='.$this->dbObj->Param('group_video_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['vid']));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						$this->fields_arr['video_server_url'] = $row['group_video_server_url'];
						$this->fields_arr['video_title'] = $row['group_video_title'];
						$this->fields_arr['group_id'] = $row['group_id'];
						$this->fields_arr['group_video_tags'] = $row['group_video_tags'];

						$sql = 'SELECT group_url FROM '.$this->CFG['db']['tbl']['groups'].' WHERE'.
								' group_id='.$this->dbObj->Param('group_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($row['group_id']));
						    if (!$rs)
							    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						if($row = $rs->FetchRow())
							{
								$this->fields_arr['gurl'] = $row['group_url'];
							}

						return true;
					}
				return false;
			}

		public function populateGroupVideoSelectQuery()
			{
				$this->selectVideoPlayerSettings();
				$add_con = $add_order = $add_field = '';
				switch($this->CFG['admin']['videos']['show_play_list_by'])
					{
						case 'tags':
							$add_field = '';
							$add_con = ' AND '.getSearchRegularExpressionQueryModified($this->fields_arr['group_video_tags'], 'group_video_tags', '');
							$add_order = ' ORDER BY group_video_id DESC';
							break;

						case 'channel':
							$add_con = ' AND v.group_id=\''.$this->fields_arr['group_id'].'\'';
							$add_order = ' ORDER BY group_video_id DESC';
							break;

						case 'random':
							$add_con = '';
							$add_order = ' ORDER BY RAND()';
							break;
					}
				$sql_condition = 'v.group_video_id!=\''.addslashes($this->fields_arr['vid']).'\' AND v.group_video_status=\'Ok\' AND g.group_status=\'Ok\''.$add_con;

				return $sql = 'SELECT v.playing_time, v.group_video_id AS video_id, v.user_id, v.group_video_title AS video_title, v.group_video_caption AS video_caption,'.
						' TIMEDIFF(NOW(), v.date_added) as date_added, v.rating_total, v.rating_count, v.total_comments,'.
						' v.group_video_server_url AS video_server_url, '.$add_field.'v.total_views,'.
						' v.s_width, v.s_height, v.group_video_ext AS video_ext FROM '.$this->CFG['db']['tbl']['group_video'].' AS v LEFT JOIN '.$this->CFG['db']['tbl']['groups'].' AS g'.
						' ON v.group_id = g.group_id'.
						' WHERE '.$sql_condition.$add_order.' LIMIT 20';
			}

		public function getXmlCode()
			{
				$fields = explode('_', $this->fields_arr['pg']);
				$this->fields_arr['pg'] = $fields[0];
				$this->fields_arr['vid'] = $fields[1];
				switch($this->fields_arr['pg'])
					{
						case 'groupvideo':
							$this->populateGroupVideoDetails();
							if(!$this->CFG['admin']['groups_video']['total_frame'])
								return;
							$sql = $this->populateGroupVideoSelectQuery();
							$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['groups_video']['folder'].'/'.$this->CFG['admin']['groups_video']['thumbnail_folder'].'/';
							$video_url = getUrl('groupviewvideo','?group_id='.$this->fields_arr['gurl'].'&video_id=', $this->fields_arr['gurl'].'/');
							break;

						case 'video':
							$this->populateVideoDetails();
							if(!$this->CFG['admin']['videos']['total_frame'])
								return;
							$sql = $this->populateVideoSelectQuery();
							$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
							break;
					}
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
?>
<FLV_PLAYLIST Refresh="15" Sequence="order">
	<DESCRITPTION Name="Name" Value="<?php echo $this->LANG['playlist_videotitle'];?>" />
	<DESCRITPTION Name="Rating" Value="<?php echo $this->LANG['playlist_rating'];?> " />
	<!--<DESCRITPTION Name="Comments" Value="<?php echo $this->LANG['playlist_comments'];?> " />-->
	<DESCRITPTION Name="Authour" Value="<?php echo $this->LANG['playlist_author'];?> " />
	<DESCRITPTION Name="Length" Value="<?php echo $this->LANG['playlist_length'];?> " />
<?php
				if ($total_records = $rs->PO_RecordCount())
				    {
						$fields_list = array('user_name', 'first_name', 'last_name');
						while($row = $rs->FetchRow())
						    {
								if(!isset($this->UserDetails[$row['user_id']]))
									$this->getUserDetail('user_id',$row['user_id'], 'user_name');
								$name = $this->getUserDetail('user_id',$row['user_id'], 'user_name');

								$row['playing_time'] = $row['playing_time']?$row['playing_time']:'00:00';
								switch($this->fields_arr['pg'])
									{
										case 'groupvideo':
											$url = getUrl($video_url.$row['video_id'], $video_url.$row['video_id'].'/', '','video');
											break;
										case 'video':
											$url = getUrl('viewvideo','?video_id='.$row['video_id'].'&title='.$this->changeTitle($row['video_title']),$row['video_id'].'/'.$this->changeTitle($row['video_title']).'/', '','video');
											break;
									}

								$url=str_replace('&','&amp;',$url);
								$thumbnail_url = '';
								// as default image
								$thumbnail_url=$row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id']).'S.'.$this->CFG['video']['image']['extensions'];
?>
	<VIDEO Name="<?php echo $row['video_title'];?>" Authour="<?php echo $name;?>" Length="<?php echo $row['playing_time'];?>" Comment="<?php echo $row['video_title'];?>" Rating="<?php echo $row['rating_total']?round($row['rating_total']/$row['rating_count']):0;?>" Comments="<?php echo $row['total_comments'];?>" Views="<?php echo $row['total_views'];?>" Thumbnails="<?php echo $thumbnail_url;?>" url="<?php echo $url;?>" target="_self"/>
<?php
							}
					}
?>
</FLV_PLAYLIST>
<?php
			}
	}
//<<<<<-------------- Class XmlCode begins ---------------//
//-------------------- Code begins -------------->>>>>//
$XmlCode = new XmlCode();
setHeaderStart($check_login=false, $xml_content_type=true);
$XmlCode->setDBObject($db);
$CFG['user']['user_id'] = isset($_SESSION['user']['user_id'])?$_SESSION['user']['user_id']:'0';
$XmlCode->makeGlobalize($CFG,$LANG);
$XmlCode->setPageBlockNames(array('get_code_form'));
//default form fields and values...
$XmlCode->setFormField('vid', '');
$XmlCode->setFormField('pg', '');
$XmlCode->setFormField('gurl', '');

$XmlCode->setPageBlockShow('get_code_form');
$XmlCode->sanitizeFormInputs($_GET);
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