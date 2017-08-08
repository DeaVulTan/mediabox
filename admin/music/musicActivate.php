<?php
/**
 * This file is to activate the music
 *
 * This file is having musicActivate class to activate the musics
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Admin
 * @author
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 **/
require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/admin/musicActivate.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/help.inc.php';
$CFG['lang']['include_files'][] = 'common/music_common_functions.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicUpload.lib.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['mods']['include_files'][] = 'music/musicCommand.inc.php';
$CFG['site']['is_module_page']='music';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');


class MusicActivate extends MusicUploadLib
	{
		/**
		 * MusicActivate::buildConditionQuery()
		 *
		 * @return
		 **/
		public function buildConditionQuery()
			{
				$this->sql_condition = 'music_status=\'Locked\' AND music_encoded_status=\'Yes\' ';
			}
		/**
		 * MusicActivate::buildSortQuery()
		 *
		 * @return
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = 'music_id DESC';
			}
		/**
		 * MusicActivate::displaymusicList()
		 *
		 * @return
		 **/
		public function displaymusicList()
			{

				global $smartyObj;
				$displayMusicList_arr = array();
				$thumbnail_folder_temp = $this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin']['musics']['temp_folder'].'/';
				$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
				$displayMusicList_arr['row'] = array();
				$inc = 0;
				while($row = $this->fetchResultRecord())
					{

						$row['music_title'] = wordWrap_mb_ManualWithSpace($row['music_title'], $this->CFG['admin']['musics']['admin_music_title_length']);
						$displayMusicList_arr['row'][$inc]['record'] = $row;
						$musics_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
						if($row['music_thumb_ext']=='')
						$displayMusicList_arr['row'][$inc]['img_src'] = $this->CFG['site']['url'].'design/templates/'.$this->CFG['html']['template']['default'].
																			'/admin/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_audio_S.jpg';
						else
						$displayMusicList_arr['row'][$inc]['img_src'] = $this->media_relative_path.$thumbnail_folder_temp.getMusicImageName($row['music_id']).
																		$this->CFG['admin']['musics']['small_name'].'.'.$row['music_thumb_ext'];

						$displayMusicList_arr['row'][$inc]['DISP_IMAGE'] = DISP_IMAGE($this->CFG['admin']['musics']['small_width'], $this->CFG['admin']['musics']['small_height'], $row['small_width'], $row['small_height']);
						$inc++;
					}
				$musics_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/';
				return 	$displayMusicList_arr;
			}
		/**
		 * MusicActivate::deleteMusicFileAndTableEntry()
		 *
		 * @return
		 **/
		public function deleteMusicFileAndTableEntry()
			{


				$dir_thumb = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
				$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['folder'].'/'.
				$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['thumbnail_folder'].'/';
				$dir_music = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
				$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['folder'].'/'.
				$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['music_folder'].'/';
				$temp_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
				$this->CFG['temp_media']['folder'].'/'.
				$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['temp_folder'].'/';
				$tempurl =  $temp_dir.$this->MUSIC_NAME;
				$imageTempUrl = $temp_dir.$this->MUSIC_THUMB_NAME;
				$dir_orginal_music = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
				$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['original_music_folder'].'/';
				$dir_trim_music = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
				$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['trimed_music_folder'];
				$trimMusicName = getTrimMusicName($this->MUSIC_ID);
				$temp_trim_file = $temp_dir.$trimMusicName;
				if($this->CFG['admin']['musics']['full_length_audio'] != 'All')
						{
							$source = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
							$this->CFG['temp_media']['folder'].'/'.
							$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['temp_folder'].'/';
							$m_source_filename = $source.$this->MUSIC_NAME.'.mp3';
							$store_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
							$this->CFG['temp_media']['folder'].'/'.
							$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['temp_folder'].'/';
							$m_output_trim_filename = $store_dir.getTrimMusicName($this->MUSIC_ID).'.wav';
							$l_source_trim_filename = $source.getTrimMusicName($this->MUSIC_ID).'.wav';
							$l_output_trim_filename = $store_dir.getTrimMusicName($this->MUSIC_ID).'.mp3';
							if(is_file($m_source_filename))
								{
									if(is_file($l_source_trim_filename))
										unlink($l_source_trim_filename);
								}
						}
					$local_upload = true;
					if($this->getServerDetails())
						{
							dbDisconnect();
							if($FtpObj = new FtpHandler($this->FTP_SERVER,$this->FTP_USERNAME,$this->FTP_PASSWORD))
							{
								if($this->FTP_FOLDER)
								{
									if($FtpObj->changeDirectory($this->FTP_FOLDER))
									{
										if(is_file($imageTempUrl.'S.'.$this->MUSIC_THUMB_EXT))
											{
											unlink($imageTempUrl.'S.'.$this->MUSIC_THUMB_EXT);
											}
										if(is_file($imageTempUrl.'M.'.$this->MUSIC_THUMB_EXT))
											{
												unlink($imageTempUrl.'M.'.$this->MUSIC_THUMB_EXT);
											}
										if(is_file($imageTempUrl.'T.'.$this->MUSIC_THUMB_EXT))
											{
												unlink($imageTempUrl.'T.'.$this->MUSIC_THUMB_EXT);
											}
										if(is_file($imageTempUrl.'L.'.$this->MUSIC_THUMB_EXT))
											{
												unlink($imageTempUrl.'L.'.$this->MUSIC_THUMB_EXT);
											}
										if($this->CFG['admin']['musics']['full_length_audio']!='All')
										{
											if(is_file($temp_trim_file.'.mp3'))
												{
													$FtpObj->moveTo($temp_trim_file.'.mp3', $dir_trim_music.'/'.$trimMusicName.'.mp3');
													unlink($temp_trim_file.'.mp3');
												}
										}
										if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['music_other_formats_enabled'])
										{
											foreach($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['music_available_formats'] as $index => $type)
												{
												if(is_file($tempurl.'.'.$type))
													{
														unlink($tempurl.'.'.$type);
													}
												}
										}
										if(is_file($tempurl.'.mp3'))
											{
												unlink($tempurl.'.mp3');
											}
										if(is_file($tempurl.'.'.$this->MUSIC_EXT))
											{
												if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['save_original_file_to_download'])
												unlink($tempurl.'.'.$this->MUSIC_EXT);
											}
										$FtpObj->ftpClose();
										$SERVER_URL = $this->FTP_SERVER_URL;
											}
									}
						}
						dbConnect();
						$local_upload = false;
						}
					if(is_file($imageTempUrl.'S.'.$this->MUSIC_THUMB_EXT))
						{
							unlink($imageTempUrl.'S.'.$this->MUSIC_THUMB_EXT);
						}
					if(is_file($imageTempUrl.'M.'.$this->MUSIC_THUMB_EXT))
						{
							unlink($imageTempUrl.'M.'.$this->MUSIC_THUMB_EXT);
						}
					if(is_file($imageTempUrl.'T.'.$this->MUSIC_THUMB_EXT))
						{
							unlink($imageTempUrl.'T.'.$this->MUSIC_THUMB_EXT);
						}
					if(is_file($imageTempUrl.'L.'.$this->MUSIC_THUMB_EXT))
						{
							unlink($imageTempUrl.'L.'.$this->MUSIC_THUMB_EXT);
						}
					if($this->CFG['admin']['musics']['full_length_audio'] != 'All')
						{
							if(is_file($temp_trim_file.'.mp3'))
								{
									unlink($temp_trim_file.'.mp3');
								}
						}
					if(is_file($tempurl.'.mp3'))
						{
							unlink($tempurl.'.mp3');
						}
					if(is_file($tempurl.'.'.$this->MUSIC_EXT))
						{
							if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['save_original_file_to_download'])
								unlink($tempurl.'.'.$this->MUSIC_EXT);
						}
					dbConnect();
					$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music'].' WHERE'.' music_id='.$this->dbObj->Param($this->fields_arr['music_id']);
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
					if (!$rs)
					trigger_db_error($this->dbObj);
					$this->sendMailToUserForDelete();
					return false;
			}


		/**
		 * MusicUpload::selectMusicIdFromTable()
		 *
		 * @return
		 **/
		public function selectMusicIdFromTable($music_id)
			{
				$sql = 'SELECT music_id, music_id, music_ext, music_title,relation_id,music_caption,user_id FROM '.$this->CFG['db']['tbl']['music'].
						' WHERE music_id='.$this->dbObj->Param('music_id').
						' ORDER BY music_id LIMIT 0,1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($music_id));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if($row = $rs->FetchRow())
					{
						$this->USER_ID = $this->MUSICID = $row['user_id'];
						$this->MUSIC_ID = $this->MUSICID = $row['music_id'];
						$this->MUSIC_NAME = getMusicName($this->MUSIC_ID);
						$this->MUSIC_THUMB_NAME=getMusicImageName($this->MUSIC_ID);
						$this->MUSIC_EXT = $row['music_ext'];
						$this->MUSIC_TITLE = $row['music_title'];
						$this->MUSIC_RELATION_ID=$row['relation_id'];
						$this->MUSIC_DESCRIPTION = $row['music_caption'];
						$this->fields_arr['music_title']=$row['music_title'];
					$sql = 'SELECT user_name, email FROM '.$this->CFG['db']['tbl']['users'].' WHERE user_id='.$this->dbObj->Param('user_id').' LIMIT 0,1';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($row['user_id']));
						    if (!$rs)
							    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
						if($row = $rs->FetchRow())
							{
								$this->MUSIC_USER_NAME = $row['user_name'];
								$this->MUSIC_USER_EMAIL = $row['email'];
							}
						return true;
					}
				return false;
			}
		public function UpdateMusicStatus($music_id)
			{

				$sql  = 'Update '.$this->CFG['db']['tbl']['music'].' SET music_status=\'Ok\' WHERE music_id='.$this->dbObj->Param($this->fields_arr['music_id']);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->MUSIC_ID ));
				if (!$rs)
					trigger_db_error($this->dbObj);
				$sql = 'SELECT u.user_name as upload_user_name, v.music_id, v.user_id as upload_user_id, v.music_title, v.music_server_url '.
						' FROM '.$this->CFG['db']['tbl']['music'].' as v, '.$this->CFG['db']['tbl']['users'].' as u WHERE u.user_id = v.user_id AND music_id = '.$this->dbObj->Param('music_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->MUSIC_ID));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$row = $rs->FetchRow();
			}
		/**
		 * MusicActivate::selectedMusicActivate()
		 *
		 * @return
		 **/
		public function selectedMusicActivate()
			{
				$music_id = $this->fields_arr['music_id'];
				$music_id = explode(',', $music_id);
				foreach($music_id as $key=>$value)
					{
						$this->fields_arr['music_id'] = $value;
						$this->MUSIC_ID = $value;
						$this->UpdateMusicStatus($this->MUSIC_ID);
						if($this->populateMusicDetails())
							{
									$this->createErrorLogFile('Activate');
									$this->selectMusicIdFromTable($this->MUSIC_ID);
									if($this->activateMusicFile())
										{
											$this->addMusicUploadActivity();
											$this->sendMailToUserForActivate();
											if($this->MUSIC_RELATION_ID)
												{
													$this->getEmailAddressOfRelation($this->MUSIC_RELATION_ID);
													$this->sendEmailToAll();
												}
										}

							}

					}
				$this->setCommonSuccessMsg($this->LANG['msg_success_activated']);
				$this->setPageBlockShow('block_msg_form_success');
			}
		/**
		 * MusicActivate::selectedMusicDelete()
		 *
		 * @return
		 **/
		public function selectedMusicDelete()
			{
				$music_id = $this->fields_arr['music_id'];
				$music_id = explode(',', $music_id);
				foreach($music_id as $key=>$value)
					{
						$this->fields_arr['music_id'] = $value;
						$this->MUSIC_ID = $value;
						if($this->populateMusicDetails())
							{
								$this->checkAndGetMusicDetails($this->fields_arr['music_id']);
								$this->deleteMusicFileAndTableEntry();
							}
					}
				$this->setCommonSuccessMsg($this->LANG['msg_success_deleted']);
				$this->setPageBlockShow('block_msg_form_success');
			}
	}
//<<<<<-------------- Class MusicActivate begins ---------------//
//-------------------- Code begins -------------->>>>>//
$MusicActivate = new MusicActivate();
$MusicActivate->setMediaPath('../../');
$MusicActivate->setPageBlockNames(array('list_music_form', 'preview_block'));
$MusicActivate->setFormField('music_id', '');
$MusicActivate->setFormField('user_id', '');
$MusicActivate->setFormField('action', '');
/*********** Page Navigation Start *********/
$MusicActivate->setFormField('start', '0');
$MusicActivate->setFormField('playing_time', '0');
$MusicActivate->setFormField('slno', '1');
$MusicActivate->setFormField('numpg', $CFG['data_tbl']['numpg']);
$MusicActivate->setMinRecordSelectLimit(2);
$MusicActivate->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$MusicActivate->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$MusicActivate->setTableNames(array($CFG['db']['tbl']['music'].' as v LEFT JOIN '.$CFG['db']['tbl']['users'].' as u ON v.user_id=u.user_id'));
$MusicActivate->setReturnColumns(array('v.music_id','v.user_id','v.music_title', 'v.date_added', 'v.music_server_url', 'u.user_name', 'u.first_name', 'u.last_name','v.small_height','v.small_width','v.thumb_width','v.thumb_height','u.user_id','v.music_thumb_ext','v.music_encoded_status'));
/************ page Navigation stop *************/
$MusicActivate->setAllPageBlocksHide();
$MusicActivate->setPageBlockShow('list_music_form');
$MusicActivate->sanitizeFormInputs($_REQUEST);

//START SINGLE PLAYER ARRAY FIELDS
$auto_play =  'false';
if($CFG['admin']['musics']['single_player']['AutoPlay'])
	$auto_play = 'true';

$music_fields = array(
	'music_player_id' => 'view_music_player',
	'height' => '',
	'width' => '',
	'auto_play' => $auto_play
);
$smartyObj->assign('music_fields', $music_fields);
//END SINGLE PLAYER ARRAY FIELDS

if($MusicActivate->isFormPOSTed($_POST, 'action'))
		{
			if($MusicActivate->getFormField('action')=='activate')
				{
					$MusicActivate->selectedMusicActivate();
				}
			else if($MusicActivate->getFormField('action')=='delete')
				{
					$MusicActivate->selectedMusicDelete();
				}
		}
	else if($MusicActivate->isFormPOSTed($_GET, 'action') and $MusicActivate->getFormField('action')=='preview')
		{
			$MusicActivate->MUSIC_ID = $MusicActivate->getFormField('music_id');
			if($MusicActivate->populateMusicDetails())
				{
					$MusicActivate->setAllPageBlocksHide();
					$MusicActivate->setPageBlockShow('preview_block');
				}
			else
				{
					$MusicActivate->setCommonErrorMsg($LANG['msg_error_sorry']);
					$MusicActivate->setPageBlockShow('block_msg_form_error');
				}
		}
//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
$MusicActivate->hidden = array('start');
if ($MusicActivate->isShowPageBlock('preview_block'))
    {
		$MusicActivate->preview_block['anchor'] = 'MultiDelte';
		//Populate single player configuration
				$MusicActivate->populateSinglePlayerConfiguration();
				$MusicActivate->configXmlcode_url .= 'pg=music_'.$MusicActivate->getFormField('music_id');
				$MusicActivate->playlistXmlcode_url .= 'pg=musicactivate_'.$MusicActivate->getFormField('music_id');
				$MusicActivate->preview_block['populateHidden'] = array('start','music_id');
    }
if ($MusicActivate->isShowPageBlock('list_music_form'))
    {
		/****** navigtion continue*********/
		$MusicActivate->buildSelectQuery();
		$MusicActivate->buildConditionQuery();
		$MusicActivate->buildSortQuery();
		$MusicActivate->buildQuery();
		$MusicActivate->executeQuery();
		/******* Navigation End ********/
	if($MusicActivate->isResultsFound())
		{
			$MusicActivate->list_music_form['anchor'] = 'MultiDelte';
			$smartyObj->assign('smarty_paging_list', $MusicActivate->populatePageLinksGET($MusicActivate->getFormField('start'), array()));
			$MusicActivate->list_music_form['displayMusicList'] = $MusicActivate->displayMusicList();
			$MusicActivate->list_music_form['onclick_activate'] = 'if(getMultiCheckBoxValue(\'musicListForm\', \'check_all\', \''.$LANG['check_atleast_one'].'\')){Confirmation(\'selMsgConfirmDelete\', \'confirmationForm\', Array(\'music_id\', \'action\', \'confirmMsg\'), Array(multiCheckValue, \'activate\', \''.$LANG['musicactivate_activate_confirmation'].'\'), Array(\'value\', \'value\', \'innerHTML\'), -100, -200);}return false;';
			$MusicActivate->list_music_form['onclick_delete'] = 'if(getMultiCheckBoxValue(\'musicListForm\', \'check_all\', \''.$LANG['check_atleast_one'].'\')){Confirmation(\'selMsgConfirmDelete\', \'confirmationForm\', Array(\'music_id\', \'action\', \'confirmMsg\'), Array(multiCheckValue, \'delete\', \''.$LANG['musicactivate_delete_confirmation'].'\'), Array(\'value\', \'value\', \'innerHTML\'), -100, -200);}return false;';
		}
    }
$MusicActivate->left_navigation_div = 'musicMain';
//include the header file
$MusicActivate->includeHeader();
//--------------------Page block templates begins-------------------->>>>>//
//include the content of the page
setTemplateFolder('admin/', 'music');
$smartyObj->display('musicActivate.tpl');
?>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/AG_ajax_html.js"></script>
 <script type="text/javascript" src="{$CFG.site.url}js/swfobject.js"></script>
<script language="javascript" type="text/javascript" >
	var block_arr= new Array('selMsgConfirmDelete');
</script>
<?php
//<<<<<-------------------- Page block templates ends -------------------//
$MusicActivate->includeFooter();
?>
