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
$CFG['site']['is_module_page']='video';
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['auth']['is_authenticate'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
$CFG['mods']['include_files'][] = 'common/classes/class_ExternalVideoUrlHandler.lib.php';
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
				$sql = 'SELECT video_server_url, user_id, video_title, flv_upload_type, video_flv_url, video_tags, video_category_id, video_tags,external_site_video_url,form_upload_type FROM '.$this->CFG['db']['tbl']['video'].
						' WHERE video_status=\'Ok\' AND video_id='.$this->dbObj->Param('this').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['vid']));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
					$this->fields_arr['video_server_url'] = $row['video_server_url'];
						$this->fields_arr['video_creator_id'] = $row['user_id'];
						$this->fields_arr['video_title'] = $row['video_title'];
						$this->fields_arr['video_tags'] = $row['video_tags'];
						$this->fields_arr['video_category_id'] = $row['video_category_id'];
						$this->fields_arr['video_tags'] = $row['video_tags'];
						$this->fields_arr['flv_upload_type'] = $row['flv_upload_type'];
						$this->fields_arr['form_upload_type'] = $row['form_upload_type'];
						$this->fields_arr['video_flv_url'] = $row['video_flv_url'];
						$this->fields_arr['external_site_video_url'] = $row['external_site_video_url'];
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
		public function getFirstVideoToPlay()
			{
				$sql_condition_single = 'v.video_id=\''.addslashes(trim($this->fields_arr['vid'])).'\' AND v.video_status=\'Ok\''.
									' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR v.video_access_type = \'Public\')';
				$sql_single = 'SELECT v.playing_time, v.video_id, v.user_id,v.video_category_id, v.video_title, v.video_caption, v.flv_upload_type, v.video_flv_url, '.
						' TIMEDIFF(NOW(), date_added) as date_added, v.rating_total, v.rating_count, v.total_comments,'.
						' v.video_server_url, v.total_views,'.
						' v.s_width, v.s_height, v.video_ext, v.video_tags FROM '.$this->CFG['db']['tbl']['video'].' AS v WHERE '.$sql_condition_single;
				$stmt = $this->dbObj->Prepare($sql_single);
				$rsfirst = $this->dbObj->Execute($stmt);
				    if (!$rsfirst)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				return $rsfirst;

			}


		public function populateVideoSelectQuery()
			{
				$this->selectVideoPlayerSettings();
				$add_con = $add_order = $add_field = '';
				switch($this->CFG['admin']['videos']['show_play_list_by'])
					{
						case 'tags':
							$add_field = 'MATCH(v.video_tags) AGAINST (\''.addslashes($this->fields_arr['video_tags']).'\') AS tag_match, ';
							$add_con = ' AND MATCH(video_tags) AGAINST (\''.addslashes($this->fields_arr['video_tags']).'\' IN BOOLEAN MODE)';
							$add_order = ' ORDER BY tag_match DESC';
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

				return $sql = 'SELECT v.playing_time, v.video_category_id,v.video_id, v.user_id, v.video_title, v.video_caption, v.flv_upload_type, v.video_flv_url, '.
						' TIMEDIFF(NOW(), date_added) as date_added, v.rating_total, v.rating_count, v.total_comments,'.
						' v.video_server_url, '.$add_field.'v.total_views,'.
						' v.s_width, v.s_height, v.video_ext, v.video_tags FROM video AS v WHERE '.$sql_condition.$add_order.' LIMIT 20';
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
		public function chkIsValidExternalUrl($url)
			{

				if($this->fields_arr['external_site_video_url'])
				{
					$external_obj = new ExternalVideoUrlHandler();
					$this->external_video_details_arr = $external_obj->chkIsValidExternalSite($this->fields_arr['external_site_video_url'],'full',$this->CFG);
					if($this->external_video_details_arr['error_message'] != '')
					{
						$this->fields_err_tip_arr[$field_name] = $this->external_video_details_arr['error_message'];
						return false;
					}
					else
					{
						return str_replace('&','&amp;',$this->external_video_details_arr['external_video_flv_path']);
					}

				}


			}


		public function populateGroupVideoSelectQuery()
			{
				$this->selectVideoPlayerSettings();
				$add_con = $add_order = $add_field = '';
				switch($this->CFG['admin']['videos']['show_play_list_by'])
					{
						case 'tags':
							$add_field = 'MATCH(v.group_video_tags) AGAINST (\''.$this->fields_arr['group_video_tags'].'\') AS tag_match, ';
							$add_con = ' AND MATCH(group_video_tags) AGAINST (\''.$this->fields_arr['group_video_tags'].'\' IN BOOLEAN MODE)';
							$add_order = ' ORDER BY tag_match DESC';
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
				$sql_condition = 'v.group_video_id!=\''.addslashes($this->fields_arr['vid']).'\' AND v.group_video_status=\'Ok\''.$add_con;

				return $sql = 'SELECT v.playing_time, v.group_video_id AS video_id, v.user_id, v.group_video_title AS video_title, v.group_video_caption AS video_caption,'.
						' TIMEDIFF(NOW(), date_added) as date_added, v.rating_total, v.rating_count, v.total_comments,'.
						' v.group_video_server_url AS video_server_url, '.$add_field.'v.total_views,'.
						' v.s_width, v.s_height, v.group_video_ext AS video_ext FROM '.$this->CFG['db']['tbl']['group_video'].' AS v'.
						' WHERE '.$sql_condition.$add_order.' LIMIT 20';
			}

		public function getXmlCode()
			{
				$fields = explode('_', $this->fields_arr['pg']);
				$this->fields_arr['pg'] = $fields[0];
				$this->fields_arr['vid'] = $fields[1];
				$isgroupvideo = false;
				switch($this->fields_arr['pg'])
					{
						case 'groupvideo':
							$isgroupvideo = true;
							$this->populateGroupVideoDetails();
							if(!$this->CFG['admin']['groups_video']['total_frame'])
								return;
							$sql = $this->populateGroupVideoSelectQuery();
							$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['groups_video']['folder'].'/'.$this->CFG['admin']['groups_video']['thumbnail_folder'].'/';
							$video_url = getUrl('groupviewvideo','?group_id='.$this->fields_arr['gurl'].'&video_id=', 'groupviewvideo/'.$this->fields_arr['gurl'].'/','','video');
							break;

						case 'video':
							$this->populateVideoDetails();
							$video_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['video_folder'].'/';
							if(!$this->CFG['admin']['videos']['total_frame'])
								return;
							$sql = $this->populateVideoSelectQuery();
							$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
							$video_url = getUrl('viewvideo','?video_id=', 'viewvideo/','','video');
							break;
					}

				$stmt = $this->dbObj->Prepare($sql);
				$rsgroup = $this->dbObj->Execute($stmt);

				    if (!$rsgroup)
				    {
				    	    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
					}


?>
<VIDEOLIST>
<VIDEOS>
<?php
				$this->fields_arr['thumbnail_folder'] = $thumbnail_folder;
				$rsfirst = $this->getFirstVideoToPlay();
				$this->formVideoTagForXML($rsfirst,$stat='true',$isgroupvideo);
				$this->formVideoTagForXML($rsgroup,$stat='false',$isgroupvideo);
?>
</VIDEOS>
</VIDEOLIST>
<?php
			}
		public function formVideoTagForXML($recordset,$stat,$isgroupvideo)
			{
				$thumbnail_folder = $this->fields_arr['thumbnail_folder'];
				if ($total_records = $recordset->PO_RecordCount())
				    {
						$fields_list = array('user_name', 'first_name', 'last_name');
						while($row = $recordset->FetchRow())
						    {
								if(!isset($this->UserDetails[$row['user_id']]))
									$this->getUserDetail('user_id',$row['user_id'], 'user_name');
								$name = $this->getUserDetail('user_id',$row['user_id'], 'user_name');
								$video_category_id = $row['video_category_id'];

								$row['playing_time'] = $row['playing_time']?$row['playing_time']:'00:00';


								$thumbnail_url = '';
								$this->CFG['admin']['videos']['total_frame']=1;
								if($this->CFG['admin']['videos']['total_frame']==3)
									{
										$thumbnail_url = $row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id']).'_1.'.$this->CFG['video']['image']['extensions'].','.
														 $row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id']).'_2.'.$this->CFG['video']['image']['extensions'].','.
														 $row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id']).'_3.'.$this->CFG['video']['image']['extensions'];
									}
								else if($this->CFG['admin']['videos']['total_frame']==2)
									{
										$thumbnail_url = $row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id']).'_1.'.$this->CFG['video']['image']['extensions'].','.
												 		 $row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id']).'_2.'.$this->CFG['video']['image']['extensions'];
									}
								else
									{
										$thumbnail_url = $row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id']).'_1.'.$this->CFG['video']['image']['extensions'];
									}

								if ($stat=='true')
								{
								if($row['flv_upload_type']=='Normal' or $this->fields_arr['video_flv_url']=='')
								{
								$video_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['video_folder'].'/';
								$video_server_url = $row['video_server_url'].$video_folder.getVideoName($row['video_id']).'.flv';
								$video_title = $row['video_title'];

								}
								else
								{
								$video_server_url = $this->chkIsValidExternalUrl($row['video_flv_url']);
								$video_title = $row['video_title'];
								}
								}
								else if ($stat=='false')
								{
								$val=str_replace(" ","_",$row['video_title']);
								//$video_folder ='action/viewvideo/'.$row['video_id'].'/'.$val;
								//$video_server_url = $row['video_server_url'].$video_folder.'/';
								$video_title = $row['video_title'];
								$video_server_url=getUrl('viewvideo','?video_id='.$row['video_id'].'&amp;title='.$this->changeTitle($row['video_title']), $row['video_id'].'/'.$this->changeTitle($row['video_title']).'/','','video');
								}

								//$sql = 'SELECT * from video_advertisement order by rand() LIMIT 0,1';
								if($isgroupvideo)
								{
									$v_cat_id = 'groups';
								}else{
									$v_cat_id = $video_category_id;
								}
								//$add_channel_query = ' and find_in_set(\''.$v_cat_id.'\',advertisement_channel)';
								$sql = 'SELECT * from '.$this->CFG['db']['tbl']['video_advertisement'].' where advertisement_status=\'Activate\' and find_in_set(\''.$v_cat_id.'\',advertisement_channel) order by rand() LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				 $record_cnt = $rs->PO_RecordCount();

				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
					if($row = $rs->FetchRow())
							{

							$id=getVideoImageName($row['advertisement_id']);
							$ext= $row['advertisement_ext'];
							$ad_show_at = $row['advertisement_show_at'];
							$ad_category_id = $row['advertisement_channel'];
							if($ext=='flv')
							{
							$type='flv';
							}
							else
							$type='img';
							$ad_path=$this->CFG['site']['url'].'files'.'/video_advertisement/'.$id.'.'.$ext;
							$duration=$row['advertisement_duration'];
							$ad_url=$row['advertisement_url'];


							}
//in_array($videovideo_category_id)

if($record_cnt!=0)
{

	$ad_category_ids =explode(',',$ad_category_id);

	if(($ad_show_at=='Begining') || ($ad_show_at=='Both'))
	{
?>

<Add AdvertisementPath="<?php echo $ad_path; ?>" AdvertisementType="<?php echo $type; ?>" Advertismentclickurl="<?php echo $ad_url;?>" Duration="<?php echo $duration;?>" />
<?php
	}
?>
<!-- <MYTESTTAG videocatid='<?php echo $video_category_id ?>' adcatid='<?php echo $ad_category_id ?>' /> -->
<Video Path="<?php echo $video_server_url;?>" Thumbnail="<?php echo $thumbnail_url;?>" Description="<?php echo $video_title?>" />

<?php
	if(($ad_show_at=='Ending') || ($ad_show_at=='Both'))
	{
?>
<Add AdvertisementPath="<?php echo $ad_path; ?>" AdvertisementType="<?php echo $type; ?>" Advertismentclickurl="<?php echo $ad_url;?>" Duration="<?php echo $duration;?>" />
<?php
	}
}
else
{
?>
<Video Path="<?php echo $video_server_url;?>" Thumbnail="<?php echo $thumbnail_url;?>" Description="<?php echo $video_title?>" />
<?php
}



							}
					}
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