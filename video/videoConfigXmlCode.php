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
require_once('../common/configs/config_video.inc.php');
require_once('../common/configs/config_video_player.inc.php');

$CFG['site']['is_module_page']='video';

$CFG['lang']['include_files'][] = 'languages/%s/video/videoConfiguration.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ExternalVideoUrlHandler.lib.php';
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
		public function chkIsValidExternalUrl()
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

		/**
		 * XmlCode::populatePhotoDetails()
		 *
		 * @return
		 **/
		public function populateVideoDetails($status)
			{
				$cond = $status?'video_status=\'Ok\'':'video_status!=\'Ok\'';
				$sql = 'SELECT video_server_url, user_id, video_title, flv_upload_type, video_flv_url, video_tags, video_category_id, video_tags,external_site_video_url,form_upload_type,external_site_flv_path,playing_time,user_id FROM '.$this->CFG['db']['tbl']['video'].
						' WHERE '.$cond.' AND video_id='.$this->dbObj->Param('video_id').' LIMIT 0,1';

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
						$this->fields_arr['playing_time'] = $row['playing_time'];
						$this->fields_arr['video_tags'] = $row['video_tags'];
						$this->fields_arr['flv_upload_type'] = $row['flv_upload_type'];
						$this->fields_arr['form_upload_type'] = $row['form_upload_type'];
						$this->fields_arr['video_flv_url'] = $row['video_flv_url'];
						$this->fields_arr['user_id'] = $row['user_id'];
						$this->fields_arr['external_site_video_url'] = $row['external_site_video_url'];

						return true;
					}

				return false;
			}



		/**
		 * XmlCode::getTotalRelatedVideo()
		 *
		 * @return
		 **/
		public function getTotalRelatedVideo()
			{
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
							$add_order = ' ORDER BY '.getRandomFieldOfVideoTable();
							break;
					}
				$sql_condition = 'v.video_id!=\''.addslashes(trim($this->fields_arr['vid'])).'\' AND v.video_status=\'Ok\''.
									' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR v.video_access_type = \'Public\''.$this->getAdditionalQuery('v.').')'.$add_con;

				$sql = 'SELECT COUNT(*) AS count FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
							' WHERE '.$sql_condition.' LIMIT 20';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$row = $rs->FetchRow();
					return $row['count'];
			}

	public function increaseImpressions($aid)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_advertisement'].' SET'.
						' advertisement_current_impressions=advertisement_current_impressions+1 WHERE'.
						' advertisement_id='.$this->dbObj->Param('advertisement_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($aid));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}

		/**
		 * XmlCode::changeConfigBooleanValues()
		 *
		 * @return
		 **/
		public function changeConfigBooleanValues()
			{
				$array = array('AutoPlay', 'Header', 'TooltipEnabled', 'ShowShareButton', 'ShowMiniLogo',
				'Logo', 'TopUrl', 'TailUrl', 'ShowMiniShareButton', 'ShowReplyButton', 'FullScreenControls');

				foreach($array as $key=>$value)
					{
						if($this->CFG['admin']['videos'][$value])
							$this->CFG['admin']['videos'][$value] = 'true';
						else
							$this->CFG['admin']['videos'][$value] = 'false';
					}
				$this->CFG['admin']['videos']['SelectedSkin'] = $this->CFG['admin']['videos']['premium_player']['skin_name'].'.swf';
			}

		public function selectVideoPlayerSettings()
			{
				$sql = 'SELECT play_settings, title, skin, play_list_settings,'.
						' show_play_list_by, skin, share_link, repeat_link FROM '.$this->CFG['db']['tbl']['video_player_settings'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						$this->CFG['admin']['videos']['AutoPlay'] = $row['play_settings'];
						$this->CFG['admin']['videos']['Header'] = $row['title'];
						$this->CFG['admin']['videos']['SelectedThemes'] = $row['skin'].'.xml';
						$this->CFG['admin']['videos']['play_list_settings'] = $row['play_list_settings'];
						$this->CFG['admin']['videos']['show_play_list_by'] = $row['show_play_list_by'];
						$this->CFG['admin']['videos']['ShowShareButton'] = $row['share_link'];
						$this->CFG['admin']['videos']['ShowReplyButton'] = $row['repeat_link'];
					}
			}
		public function chkIsAdSetByUser()
			{
				$sql = 'SELECT advertisement_id FROM '.
						$this->CFG['db']['tbl']['video_advertisement'].
						' WHERE user_id = '.$this->dbObj->Param('user_id').
						' AND advertisement_status=\'Activate\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_creator_id']));
				if (!$rs)
				   trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				return $rs->PO_RecordCount();

			}
		public function chkIsAffiliateMembersVideo()
			{
				$sql = ' SELECT is_affiliate_type FROM '.
						$this->CFG['db']['tbl']['users'].
						' WHERE user_id = '.$this->dbObj->Param('user_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_creator_id']));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						if ($row['is_affiliate_type'] == 'Yes')
							 {
								//check if the user has any ad set
								return $this->chkIsAdSetByUser();
							}
						else
							return false;
					}
				else
						return false;
			}
		public function selectVideoAddSettings()
			{
				$user_condn = ' 1 AND ';
				if ($this->fields_arr['video_creator_id'])
					{
						if ($this->chkIsAffiliateMembersVideo())
							{
							$user_condn = ' user_id = '.$this->fields_arr['video_creator_id'].' AND ';
							}
					}

				$this->CFG['admin']['videos']['TopImpressionUrl'] = $this->CFG['site']['url'].'affiliate.php';
				$this->CFG['admin']['videos']['TopClickCountUrl'] = $this->CFG['site']['url'].'affiliate.php';
				$this->CFG['admin']['videos']['TailImpressionUrl'] = $this->CFG['site']['url'].'affiliate.php';
				$this->CFG['admin']['videos']['TailClickCountUrl'] = $this->CFG['site']['url'].'affiliate.php';

				$jpg = 'img';
				$flv = 'flv';
				$swf = 'img';

				$add_content_filter_cond = '';
				if(chkAllowedModule(array('content_filter')))
					{
						if(!isAdultUser())
							$add_content_filter_cond = 'add_type=\'General\' AND ';
						//else
							//$add_content_filter_cond = 'add_type=\'Porn\' AND ';
					}

				$add_fields = 'advertisement_id, advertisement_url, advertisement_duration, advertisement_channel, advertisement_image,'.
						' advertisement_ext, advertisement_show_at';

				$default_cond = ' advertisement_image!=\'\' AND advertisement_ext!=\'\''.
								' AND advertisement_status=\'Activate\' AND'.
								' (FIND_IN_SET(\''.$this->fields_arr['video_category_id'].'\', advertisement_channel)'.
								' OR (advertisement_channel=\'\'))'.' AND '.$add_content_filter_cond;

				$add_cond = '';
				if($this->CFG['admin']['video_advertisement_impressions'])
					{
						$add_cond = ' (((advertisement_impressions!=\'\' AND advertisement_impressions!=0) AND'.
									' advertisement_current_impressions<advertisement_impressions) OR ((advertisement_impressions=\'\''.
									' OR advertisement_impressions=0) AND (advertisement_expiry_date!=\'0000-00-00 00:00:00\''.
									' AND advertisement_expiry_date>NOW()))) AND ';
					}

				$sql = 'SELECT '.$add_fields.' FROM '.$this->CFG['db']['tbl']['video_advertisement'].
						' WHERE'.$user_condn.$add_cond.$default_cond.'(advertisement_show_at=\'Begining\' OR advertisement_show_at=\'Both\')';
//				echo $sql;

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
								if($this->CFG['admin']['video_advertisement_impressions'])
									{
										$this->increaseImpressions($row['advertisement_id']);
									}
								$this->CFG['admin']['videos']['TopImpressionUrl'] .= '?params='.$row['advertisement_id'].'_view_'.$this->fields_arr['ref'].'_'.$this->fields_arr['vid'];
								$this->CFG['admin']['videos']['TopClickCountUrl'] .= '?params='.$row['advertisement_id'].'_click_'.$this->fields_arr['ref'].'_'.$this->fields_arr['vid'];
								$this->CFG['admin']['videos']['TopUrlUrl'] = $this->CFG['site']['url'].$this->CFG['admin']['videos']['advertisement_folder'].$row['advertisement_image'].'.'.$row['advertisement_ext'];
								$this->CFG['admin']['videos']['TopUrlTargetUrl'] = $row['advertisement_url'];
								$this->CFG['admin']['videos']['TopUrl'] = true;
								$this->CFG['admin']['videos']['TopUrlType'] = isset($$row['advertisement_ext'])?$$row['advertisement_ext']:$row['advertisement_ext'];
								$this->CFG['admin']['videos']['TopUrlDuration'] = $row['advertisement_duration'];
								break;
							}
					}

				$sql = 'SELECT '.$add_fields.' FROM '.$this->CFG['db']['tbl']['video_advertisement'].
						' WHERE'.$user_condn.$add_cond.$default_cond.'(advertisement_show_at=\'Ending\' OR advertisement_show_at=\'Both\')';

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
								if($this->CFG['admin']['video_advertisement_impressions'])
									{
										$this->increaseImpressions($row['advertisement_id']);
									}
								$this->CFG['admin']['videos']['TailImpressionUrl'] .= '?params='.$row['advertisement_id'].'_view_'.$this->fields_arr['ref'].'_'.$this->fields_arr['vid'];
								$this->CFG['admin']['videos']['TailClickCountUrl'] .= '?params='.$row['advertisement_id'].'_click_'.$this->fields_arr['ref'].'_'.$this->fields_arr['vid'];
								$this->CFG['admin']['videos']['TailUrlUrl'] = $this->CFG['site']['url'].$this->CFG['admin']['videos']['advertisement_folder'].$row['advertisement_image'].'.'.$row['advertisement_ext'];
								$this->CFG['admin']['videos']['TailUrlTargetUrl'] = $row['advertisement_url'];
								$this->CFG['admin']['videos']['TailUrl'] = true;
								$this->CFG['admin']['videos']['TailUrlType'] = $$row['advertisement_ext'];
								$this->CFG['admin']['videos']['TailUrlDuration'] = $row['advertisement_duration'];
								break;
							}
					}
			}

		public function selectLogoSettings()
			{
				$this->CFG['admin']['videos']['LogoTransparency'] = 10;
				$this->CFG['admin']['videos']['LogoRollOverTransparency'] = 10;
				$this->CFG['admin']['videos']['LogoPosition'] = 'LB';
				$this->CFG['admin']['videos']['MiniLogoUrl'] = '';
				$this->CFG['admin']['videos']['InnerScripts'] = 'no';

				$sql = 'SELECT logo_url, main_logo, logo_position, logo_transparency, logo_rollover_transparency,'.
						' logo_image, logo_ext, mini_logo_image, mini_logo_ext, mini_logo, animated_logo'.
						' FROM '.$this->CFG['db']['tbl']['video_logo'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$logo_position_arr = array('Left_bottom' => 'LB', 'Left_top' => 'LT', 'Right_bottom' => 'RB', 'Right_top' => 'RT');
				if ($row = $rs->FetchRow())
				    {
				     	if($row['logo_image'] and $row['logo_ext'] and $row['main_logo']=='yes')
							{
								$this->CFG['admin']['videos']['Logo'] = true;
								$this->CFG['admin']['videos']['LogoUrl'] = $this->CFG['site']['url'].$this->CFG['admin']['videos']['logo_folder'].$row['logo_image'].'.'.$row['logo_ext'];;
								$this->CFG['admin']['videos']['LogoTargetUrl'] = $row['logo_url'];
								$this->CFG['admin']['videos']['LogoTransparency'] = $row['logo_transparency'];
								$this->CFG['admin']['videos']['LogoRollOverTransparency'] = $row['logo_rollover_transparency'];
								$this->CFG['admin']['videos']['LogoPosition'] = $logo_position_arr[$row['logo_position']];
								$this->CFG['admin']['videos']['InnerScripts'] = $row['animated_logo'];
							}
						if($row['mini_logo_image'] and $row['mini_logo_ext'])
							{
								$this->CFG['admin']['videos']['ShowMiniLogo'] = true;
								$this->CFG['admin']['videos']['MiniLogoUrl'] = $this->CFG['site']['url'].$this->CFG['admin']['videos']['logo_folder'].$row['mini_logo_image'].'.'.$row['mini_logo_ext'];

								if($row['mini_logo'])
									{
										$this->CFG['admin']['videos']['FullScreenControls'] = false;
										$this->CFG['admin']['videos']['ShowMiniShareButton'] = false;
									}
							}
				    }
			}
		public function getVideoTitle($video_id)
			{
				$sql = 'SELECT video_title FROM '.$this->CFG['db']['tbl']['video'].
						' WHERE video_id='.$this->dbObj->Param('video_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($video_id));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					return wordWrap_mb_Manual($row['video_title'], $this->CFG['admin']['videos']['video_title_word_wrap_length']);
				return;
			}
		public function getVideoServerURL($video_id)
			{
				$sql = 'SELECT video_server_url FROM '.$this->CFG['db']['tbl']['video'].' WHERE '.
						' video_id='.$this->dbObj->Param('video_id').' ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($video_id));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$count=0;
				if($row = $rs->FetchRow())
					return $row['video_server_url'];
			}
        public function getplayListNextUrl($order,$playlist_id)
	        {

	             $condition = ' 1 '.
									' AND v.video_status=\'Ok\''.$this->getAdultQuery('v.').
									' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
									' v.video_access_type = \'Public\''.$this->getAdditionalQuery('v.').')'.
									' AND c.order_id > \''.$order.'\' AND c.video_id=v.video_id AND c.playlist_id=\''.$playlist_id.'\' ';

				$sql = 'SELECT MIN(c.video_id) as video_id, c.order_id FROM '.$this->CFG['db']['tbl']['video'].' as v, '.$this->CFG['db']['tbl']['video_in_playlist'].' as c '.
				' WHERE '.$condition.' GROUP BY c.playlist_id ORDER BY c.order_id ASC LIMIT 0,1 ';

				$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt);
					if (!$rs)
						trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			        if($row = $rs->FetchRow())
						{
							$row['video_title'] = $this->getVideoTitle($row['video_id']);
							$link = getUrl('viewvideo','?video_id='.$row['video_id'].'&amp;title='.$this->changeTitle($row['video_title']).'&amp;vpkey=&amp;album_id=&amp;play_list=pl&amp;playlist_id='.$playlist_id.'&amp;order='.$row['order_id'],
							$row['video_id'].'/'.$this->changeTitle($row['video_title']).'/?vpkey=&amp;album_id=&amp;play_list=pl&amp;playlist_id='.$playlist_id.'&amp;order='.$row['order_id'], '', 'video');
							return $link;
						}
						return false;


			}
		public function getQuickLinkPlayListNextUrl($in_str)
			{
				if(!trim($in_str))
					return false;

				$condition = ' 1 '.
								' AND video_id IN('.$in_str.') AND v.video_status=\'Ok\''.$this->getAdultQuery('v.').
								' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
								' v.video_access_type = \'Public\''.$this->getAdditionalQuery('v.').')'.
								' AND v.video_id > \''.$this->fields_arr['vid'].'\' ';

				$sql = 'SELECT MIN(v.video_id) as video_id FROM '.$this->CFG['db']['tbl']['video'].' as v'.
						' WHERE '.$condition.' LIMIT 0,1';


				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow() and $row['video_id'])
					{
						$video_server_url=$this->getVideoServerURL($row['video_id']);
						$row['video_title'] = $this->getVideoTitle($row['video_id']);
						$link = getUrl('viewvideo','?video_id='.$row['video_id'].'&amp;title='.$this->changeTitle($row['video_title']).'&amp;vpkey=&amp;album_id&amp;play_list=ql',
						$row['video_id'].'/'.$this->changeTitle($row['video_title']).'/?vpkey=&amp;album_id=&amp;play_list=ql','','video');
						return $link;
					}
				return false;

			}
		public function getXmlCode()
			{

				$fields = explode('_', $this->fields_arr['pg']);
				$this->fields_arr['pg'] = $fields[0];
				$this->fields_arr['vid'] = $fields[1];
				$this->fields_arr['full'] = false;

				if(isset($fields[2]) and $fields[2]=='full')
					$this->fields_arr['full'] = true;

				if(isset($fields[3]))
					$this->fields_arr['ref'] = $fields[3];

				if(!($this->fields_arr['pg'] and $this->fields_arr['vid']))
					{
						return;
					}

				if(isset($fields[4]) and $fields[4]=='extsite')
					$this->external_site=true;

				if(isset($fields[4]) and $fields[4]=='false')
					$this->CFG['admin']['videos']['playList']=false;

				// added this lines for hide the FullScreenControls in index page player
				if(isset($fields[5]) and $fields[5]=='false')
					$this->CFG['admin']['videos']['FullScreenControls']=false;

                // added this lines for hide the FullScreenControls in index page player
				if(isset($fields[6]) and $fields[6]=='false')
					$this->CFG['admin']['videos']['ShowMiniShareButton']=false;

			    $next_url_link='';

				if(isset($fields[4]) and ($fields[4]=='pl' or $fields[4]=='ql'))
				  {
						if($fields[4]=='pl')
						$next_url_link = $this->getplayListNextUrl($fields[5],$fields[6]);
						else if($fields[4]=='ql')
						{
						$in_str = substr($_SESSION['user']['quick_links'], 0, strrpos($_SESSION['user']['quick_links'], ','));
						$next_url_link = $this->getQuickLinkPlayListNextUrl($in_str);
						if(!$next_url_link)
						  $next_url_link='';
						}

				  }


				$sharing_url = '';
				$full_screen_url = '';
				$configPlayListXmlcode_url = '';
				$end_list = $next_list = 0;
				$this->selectVideoPlayerSettings();
				$thumbnail = '';
				switch($this->fields_arr['pg'])
					{
						case 'video':
							$this->populateVideoDetails(true);

							$video_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['video_folder'].'/';

							$chkTrimedVideo=false;
							if($this->fields_arr['form_upload_type']=='Normal')
							{
								$video_url = $this->fields_arr['video_server_url'].$video_folder.getHotLinkProtectionString().getVideoName($this->fields_arr['vid']).'.flv';
								$chkTrimedVideo=true;

							}
							else
							{
									if(!$this->fields_arr['video_flv_url'])
									{
										$video_url = $this->fields_arr['video_server_url'].$video_folder.getHotLinkProtectionString().getVideoName($this->fields_arr['vid']).'.flv';
										$chkTrimedVideo=true;
									}
									else
									{

										$video_url = $this->chkIsValidExternalUrl();
									}

							}

							$displayMessage='';
							$showTrimmedheader='false';
							if(($chkTrimedVideo AND $this->CFG['user']['user_id']!=$this->fields_arr['user_id']) Or $this->external_site)
							{

								$isTrimmedVideo=false;

									$video_server_url=$this->fields_arr['video_server_url'];
									$host=$_SERVER["HTTP_HOST"];
									$pattern='/'.$host.'/';
									$localServerMatch=false;
									$oldServerUrl=$video_server_url;
									if(preg_match($pattern,$video_server_url))
									{
										$localServerMatch=true;
									}


								$displayTrimmedVideo =false;
								/* TRIMMED VIDEO WILL DISPLAYED FOR NOT LOGGED IN USERS */
								if($this->CFG['admin']['videos']['full_length_video']=='members' AND !isloggedIn())
								{
									$displayTrimmedVideo =true;
								}
								else if($this->CFG['admin']['videos']['full_length_video']=='paid_members' AND !isPaidMember())
								{
									$this->LANG['trimmed_member_message'] = $this->LANG['trimmed_paidmember_message'];
									$displayTrimmedVideo =true;
								}

								if($displayTrimmedVideo)
								{
									$trim_video_folder=$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['trimed_video_folder'].'/';

										if($localServerMatch)
										{
											$trim_url=$this->CFG['site']['project_path'].$trim_video_folder.getHotLinkProtectionString().getTrimVideoName($this->fields_arr['vid']).'.flv';
											if(file_exists($trim_url))
											{
												$video_url = $trim_url;
												$video_url=str_replace($this->CFG['site']['project_path'],$oldServerUrl,$video_url);
												$displayMessage = $this->LANG['trimmed_member_message'];
												$isTrimmedVideo=true;
											}
										}
										else
										{
											$trim_url=$this->fields_arr['video_server_url'].$trim_video_folder.getHotLinkProtectionString().getTrimVideoName($this->fields_arr['vid']).'.flv';
												if(getHeadersManual($trim_url))
												{
													$video_url = $trim_url;
													$displayMessage = $this->LANG['trimmed_member_message'];
													$isTrimmedVideo=true;
												}
										}
								}


								if($isTrimmedVideo)
								{

									## TRIM SEC TO HR : MIN : SEC Conversion
									$trimmedTime=Date('H:i:s',mktime(0,0,$this->CFG['admin']['videos']['trim_video_end_time'],date('m'),date('d'),date('Y')));
									$trimmedText=str_replace(
													array('{trimmed_time}','{actual_playing_time}','{display_message}'),
													array($trimmedTime,$this->fields_arr['playing_time'],$displayMessage),
													$this->LANG['trimmedVideoText']);
									$this->fields_arr['video_title'].='  '.$trimmedText;

									if($this->CFG['admin']['videos']['Header'])
										$showTrimmedheader='true';
								}

							}


							$sharing_url = getUrl('sharevideo','', '','','video');
							$sharing_args='video_id='.$this->fields_arr['vid'].'&amp;page=video';
							$full_screen_url = getUrl('viewvideofull','?video_id='.$this->fields_arr['vid'].'&pg=video', $this->fields_arr['vid'].'/?pg=video', '','');
							$thumbnail = $this->fields_arr['video_server_url'].$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/'.getVideoImageName($this->fields_arr['vid']).$this->CFG['admin']['videos']['large_name'].'.'.$this->CFG['video']['image']['extensions'];
							if($this->CFG['admin']['videos']['total_frame'])
								{
									if($this->CFG['admin']['videos']['play_list_settings'])
										{
											if($count = $this->getTotalRelatedVideo())
												{
													$configPlayListXmlcode_url = $this->CFG['site']['video_url'].'videoPlaylistXmlCode.php?pg=video_'.$this->fields_arr['vid'];
													$end_list = $next_list = $count>=3?3:$count;
												}
										}
								}
							$this->selectVideoAddSettings();
							$this->selectLogoSettings();
							break;

						case 'videoactivate':
							$this->populateVideoDetails(false);
							$showTrimmedheader='false';
							$sharing_args='video_id='.$this->fields_arr['vid'].'&amp;page=video';
							$video_folder = $this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin']['videos']['temp_folder'].'/';

							if($this->fields_arr['flv_upload_type']=='Normal')
								$video_url = $this->CFG['site']['url'].$video_folder.getHotLinkProtectionString().getVideoName($this->fields_arr['vid']).'.flv';
							else
								if($this->fields_arr['video_flv_url'])
									{
									$video_url = $this->chkIsValidExternalUrl($this->fields_arr['video_flv_url']);
									}
									else
									{
									$video_url = $this->CFG['site']['url'].$video_folder.getHotLinkProtectionString().getVideoName($this->fields_arr['vid']).'.flv';
									}

							$thumbnail = $this->CFG['site']['url'].$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.getVideoImageName($this->fields_arr['vid']).$this->CFG['admin']['videos']['large_name'].'.'.$this->CFG['video']['image']['extensions'];
							$this->selectLogoSettings();
								$this->selectVideoAddSettings();
							break;


					}

				$this->changeConfigBooleanValues();
				if($this->fields_arr['full'])
					{
						$full_screen_url = '';
					}
					$toolTipEnabled='false';
					if($this->CFG['admin']['videos']['toolTipEnabled'])
					{
						$toolTipEnabled='true';
					}
?>
<CONFIG>
	<SETTINGS>
		<PLAYER_SETTINGS Name="SelectedSkin" Value="<?php echo $this->CFG['site']['url'].$this->CFG['admin']['flv']['skin_path'].$this->CFG['admin']['videos']['SelectedSkin'];?>"/>
		<PLAYER_SETTINGS Name="SelectedLoader" Value="<?php echo $this->CFG['site']['url'].$this->CFG['admin']['flv']['skin_path'].$this->CFG['admin']['videos']['SelectedLoader'];?>"/>
		<PLAYER_SETTINGS Name="Protocol" Type="http" Value="pathwillcome" />
		<PLAYER_SETTINGS Name="FLVPath" Value="<?php echo $video_url;?>"/>
		<?php if($this->CFG['admin']['videos']['playList']){?>
		<PLAYER_SETTINGS Name="PlayList" Value="<?php echo $configPlayListXmlcode_url;?>" EndList="<?php echo $end_list;?>" NextList="<?php echo $next_list;?>" MaximumLists="2" />
		<?php }?>

		<PLAYER_SETTINGS Name="Themes" Value="<?php echo $this->CFG['site']['url'].$this->CFG['admin']['flv']['skin_path'].$this->CFG['admin']['videos']['SelectedThemes'];?>"/>
		<PLAYER_SETTINGS Name="LockAllControls" Value="<?php echo $this->CFG['admin']['videos']['LockAllControls'];?>"/>
		<PLAYER_SETTINGS Name="ShowShareButton" Value="<?php echo $this->CFG['admin']['videos']['ShowShareButton'];?>"/>
		<PLAYER_SETTINGS Name="ShowReplyButton" Value="<?php echo $this->CFG['admin']['videos']['ShowReplyButton'];?>"/>
		<PLAYER_SETTINGS Name="InitVolume" Value="<?php echo $this->CFG['admin']['videos']['InitVolume'];?>"/>
		<PLAYER_SETTINGS Name="AutoPlay" Value="<?php echo $this->CFG['admin']['videos']['AutoPlay'];?>"/>
		<PLAYER_SETTINGS Name="FirstFrameAs" Value="<?php echo $this->CFG['admin']['videos']['FirstFrameAsValue'];?>" FrameAt="<?php echo $this->CFG['admin']['videos']['FirstFrameAsFrameAt'];?>" Url="<?php echo $thumbnail;?>" Align="scale"/>
		<PLAYER_SETTINGS Name="FirstVidSize" Value="max" KeepAspectRatio="true"/>
		<PLAYER_SETTINGS Name="FullScreenControls" Value="<?php echo $this->CFG['admin']['videos']['FullScreenControls'];?>"/>
		<PLAYER_SETTINGS Name="ShowMiniShareButton" Value="<?php echo $this->CFG['admin']['videos']['ShowMiniShareButton'];?>"/>

		<PLAYER_SETTINGS Name="TriggerUrl" Url="<?php echo $this->CFG['site']['video_url'].'triggerVideoStats.php';?>" TriggerStats="<?php echo ($this->external_site)?'true':'false'; ?>" TriggerId="<?php echo ($this->external_site)?$this->getVideoRenderCode():''; ?>" vid="<?php echo $this->fields_arr['vid'];?>"/>

		<PLAYER_SETTINGS Name="ShareVidzLink" Value="<?php echo $sharing_url;?>" args="<?php echo $sharing_args;?>" />
		<!-- args will passed separately with & symbol to the given php file -->
		<PLAYER_SETTINGS Name="FullScreenLink" Function="" args="this"/>
		<PLAYER_SETTINGS Name="BufferTime" Value="4"/>
		<PLAYER_SETTINGS Name="Logo" Value="<?php echo $this->CFG['admin']['videos']['Logo'];?>" Url="<?php echo $this->CFG['admin']['videos']['LogoUrl'];?>" Transparency="<?php echo $this->CFG['admin']['videos']['LogoTransparency'];?>" RollOverTransparency="<?php echo $this->CFG['admin']['videos']['LogoRollOverTransparency'];?>" LogoPosition="<?php echo $this->CFG['admin']['videos']['LogoPosition'];?>" hspace="10" vspace="10" TargetUrl="<?php echo $this->CFG['admin']['videos']['LogoTargetUrl'];?>" Target="_blank" InnerScripts="<?php echo $this->CFG['admin']['videos']['InnerScripts'];?>"/>
		<PLAYER_SETTINGS Name="ShowMiniLogo" Value="<?php echo ($this->CFG['admin']['videos']['ShowMiniLogo'])?'true':'false'; ?>" Url="<?php echo $this->CFG['admin']['videos']['MiniLogoUrl']; ?>"/>
		<PLAYER_SETTINGS Name="External" Value="no" Url="http://macromedia.com"  Target="_blank" />

		<PLAYER_SETTINGS Name="TopUrl" Url="<?php echo $this->CFG['admin']['videos']['TopUrlUrl'];?>" TargetUrl="<?php echo $this->CFG['admin']['videos']['TopUrlTargetUrl'];?>" TargetWindow="_blank" Duration="<?php echo $this->CFG['admin']['videos']['TopUrlDuration'];?>" Value="<?php echo $this->CFG['admin']['videos']['TopUrl'];?>" Type="<?php echo $this->CFG['admin']['videos']['TopUrlType'];?>" ImpressionUrl="<?php echo $this->CFG['admin']['videos']['TopImpressionUrl'];?>" ClickCountUrl="<?php echo $this->CFG['admin']['videos']['TopClickCountUrl'];?>"/>
		<PLAYER_SETTINGS Name="TailUrl" Url="<?php echo $this->CFG['admin']['videos']['TailUrlUrl'];?>" TargetUrl="<?php echo $this->CFG['admin']['videos']['TailUrlTargetUrl'];?>" TargetWindow="_blank" Duration="<?php echo $this->CFG['admin']['videos']['TailUrlDuration'];?>" Value="<?php echo $this->CFG['admin']['videos']['TailUrl'];?>" Type="<?php echo $this->CFG['admin']['videos']['TailUrlType'];?>" ImpressionUrl="<?php echo $this->CFG['admin']['videos']['TailImpressionUrl'];?>" ClickCountUrl="<?php echo $this->CFG['admin']['videos']['TailClickCountUrl'];?>"/>
		<PLAYER_SETTINGS Name="TooltipEnabled" Value="<?echo $toolTipEnabled;?>"/>
<?php

		/*if(isset($_SESSION['video']['next_url']))
			{

				if(stristr($_SESSION['video']['next_url'],'viewvideo'))
				{
					$_GET['next_url']=$_SESSION['video']['next_url'];
					$_GET['play_list']=$_SESSION['video']['play_list'];
					if(isset($_SESSION['video']['playlist_id']))
					$_GET['playlist_id']=$_SESSION['video']['playlist_id'];
					//$_GET['next_url']=str_replace('&','&amp;',$_GET['next_url']);
				}

			}*/
		if($next_url_link!='')
		{
?>
		<PLAYER_SETTINGS Name="NextUrl" Url="<?php echo $next_url_link;?>" TargetWindow="_self" target="_self"  Value="<?php echo $next_url_link;?>" />
		<PLAYER_SETTINGS Name="AutoPlay" Value="true"/>
<?php
		}
		else
		{
			 if(isset($_GET['autoplay']) AND $_GET['autoplay'])
				{
					?><PLAYER_SETTINGS Name="AutoPlay" Value="true"/><?php
				}
				else
				{
					?>
							<PLAYER_SETTINGS Name="AutoPlay" Value="<?php echo $this->CFG['admin']['videos']['AutoPlay'];?>"/>
					<?php
				}


		}
?>
	</SETTINGS>
	<LABELS>
		<TEXT Name="Header" Value="<?php echo $this->fields_arr['video_title'];?>" Enable="<?php echo $showTrimmedheader;?>" ShowAlways="true" Url="" TargetWindow="" HeaderScroll="true" ScrollSpeed="1"/>
		<TEXT Name="Share" Value="<?php echo $this->LANG['ShareToolTip'];?>"/>
		<TEXT Name="Reply" Value="<?php echo $this->LANG['ReplyToolTip'];?>"/>
		<TEXT Name="Buffer" Value="<?php echo $this->LANG['BufferToolTip'];?>"/>
		<TEXT Name="Loading" Value="<?php echo $this->LANG['LoadingToolTip'];?>"/>
		<TEXT Name="NextText" Value="<?php echo $this->LANG['NextTextToolTip'];?>" Enable="false"/>
		<TEXT Name="ListAlign" Value="RTL" Enable="false"/>
		</LABELS>
	<TOOLTIP>
		<TOOL Name="PlayButton" Value="<?php echo $this->LANG['PlayButtonToolTip'];?>"/>
		<TOOL Name="PauseButton" Value="<?php echo $this->LANG['PauseButtonToolTip'];?>"/>
		<TOOL Name="VolumeButton" Value="<?php echo $this->LANG['VolumeButtonToolTip'];?>"/>
		<TOOL Name="ShareVidz" Value="<?php echo $this->LANG['ShareVidzToolTip'];?>"/>
		<TOOL Name="ReplyVideo" Value ="<?php echo $this->LANG['ReplyVideoToolTip'];?>"/>
		<TOOL Name="RewindButton" Value="<?php echo $this->LANG['RewindButtonToolTip'];?>"/>
		<TOOL Name="MuteButton" Value ="<?php echo $this->LANG['MuteButtonToolTip'];?>"/>
		<TOOL Name="FullScreen" Value="<?php echo $this->LANG['FullScreenToolTip'];?>"/>
		<TOOL Name="UnMuteButton" Value="<?php echo $this->LANG['UnMuteButtonToolTip'];?>"/>
		<TOOL Name="VideoSize" Value="<?php echo $this->LANG['VideoSizeToolTip'];?>"/>
	</TOOLTIP>
	<MSG>
	 <ERROR Name="SelectedSkin" Value="<?php echo $this->LANG['SelectedSkinErrorMsg'];?>"/>
	 <ERROR Name="PlayList" Value="<?php echo $this->LANG['PlayListErrorMsg'];?>"/>
	 <ERROR Name="FlvPath" Value="<?php echo $this->LANG['FlvPathErrorMsg'];?>"/>
	 <ERROR Name="FlvPathFile" Value="<?php echo $this->LANG['FlvPathFileErrorMsg'];?>"/>
	</MSG>
</CONFIG>
<?php
			}

		public function getVideoRenderCode()
			{
				$fields_arr['video_id']=isset($this->fields_arr['vid'])?$this->fields_arr['vid']:0;
				$fields_arr['ip_render']=$this->CFG['remote_client']['ip'];
				$fields_arr['referer_render']=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';

				return 0;

				$sql = ' INSERT INTO '.$this->CFG['db']['tbl']['video_render'].' SET ';
				foreach($fields_arr as $fieldname=>$value)
					$sql .= $fieldname.'=\''.addslashes($value).'\', ';
				$sql .= ' date_time_render=now(), video_owner_id=\''.$this->fields_arr['video_creator_id'].'\', clicked_video=\'no\' ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$return = $this->dbObj->Insert_ID();


		 		$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].
		 				' SET total_linked = total_linked + 1 '.
		 				' WHERE video_id = '.$this->dbObj->Param('videoid');
		 		$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['vid']));

				return $return;
			}

	}
//<<<<<-------------- Class XmlCode begins ---------------//
//-------------------- Code begins -------------->>>>>//
$XmlCode = new XmlCode();
setHeaderStart($check_login=false);
$XmlCode->setDBObject($db);
$CFG['user']['user_id'] = isset($_SESSION['user']['user_id'])?$_SESSION['user']['user_id']:'0';
$CFG['admin']['is_logged_in'] = isset($_SESSION['admin']['is_logged_in'])?$_SESSION['admin']['is_logged_in']:'0';

$XmlCode->makeGlobalize($CFG,$LANG);
$XmlCode->setPageBlockNames(array('get_code_form'));
//default form fields and values...
$XmlCode->setFormField('vid', '');
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