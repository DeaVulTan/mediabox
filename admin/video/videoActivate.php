<?php
set_time_limit(0);
ini_set('display_errors','1');
error_reporting(E_ALL);
/**
 * This file is to activate the videos
 *
 * This file is having VideoActivate class to activate the videos
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Admin
 * @author 		selvaraj_35ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2006-05-02
 *
 **/
require_once('../../common/configs/config.inc.php');
require_once('../../common/configs/config_video.inc.php');
require_once('../../common/configs/config_encoder_command.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/admin/videoActivate.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/help.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ExternalVideoUrlHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoUpload.lib.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoGifHandler.php';
//$CFG['mods']['include_files'][] = 'common/classes/class_FlixEngine.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';

$CFG['site']['is_module_page']='video';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class ConfigEdit begins -------------------->>>>>//
/**
 * VideoActivate
 *
 * @package
 * @author selvaraj_35ag05
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: videoUpload.php 892 2006-05-26 13:23:06Z selvaraj_35ag05 $
 * @access public
 **/
class VideoActivate extends VideoUploadLib
	{
		/**
		 * VideoActivate::buildConditionQuery()
		 *
		 * @return
		 **/
		public function buildConditionQuery()
			{
				$this->sql_condition = 'video_status=\'Locked\' AND video_encoded_status=\'Yes\'';
			}

		/**
		 * PhotoList::buildSortQuery()
		 *
		 * @return
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = 'video_id DESC';
			}

		/**
		 * VideoActivate::displayVideoList()
		 *
		 * @return
		 **/
		public function displayVideoList()
			{
				$displayVideoList_arr = array();
				$thumbnail_folder_temp = $this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].$this->CFG['admin']['videos']['temp_folder'].'/';
				$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
				$displayVideoList_arr['row'] = array();
				$inc = 0;
				while($row = $this->fetchResultRecord())
					{
						$row['video_title'] = wordWrap_mb_ManualWithSpace($row['video_title'], $this->CFG['admin']['videos']['admin_video_title_length']);
						$displayVideoList_arr['row'][$inc]['record'] = $row;

						//if($row['is_external_embed_video']=='No')
						$displayVideoList_arr['row'][$inc]['img_src'] = $this->media_relative_path.$thumbnail_folder_temp.getVideoImageName($row['video_id']).$this->CFG['admin']['videos']['small_name'].'.'.$this->CFG['video']['image']['extensions'];
						//else
						//$displayVideoList_arr['row'][$inc]['img_src'] = $row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id']).$this->CFG['admin']['videos']['small_name'].'.'.$this->CFG['video']['image']['extensions'];
						$displayVideoList_arr['row'][$inc]['file_path'] = $row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id']).$this->CFG['admin']['videos']['small_name'].'.'.$this->CFG['video']['image']['extensions'];
						$displayVideoList_arr['row'][$inc]['DISP_IMAGE'] = DISP_IMAGE($this->CFG['admin']['videos']['small_width'], $this->CFG['admin']['videos']['small_height'], $row['s_width'], $row['s_height']);
						$inc++;
					}
				return 	$displayVideoList_arr;
			}

		/**
		 * VideoActivate::deleteVideoFileAndTableEntry()
		 *
		 * @return
		 **/
		public function deleteVideoFileAndTableEntry()
			{
				$temp_file_path = '../../'.$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].
									'/'.$this->CFG['admin']['videos']['temp_folder'].'/';

				$temp_image_file=getVideoImageName($this->fields_arr['video_id']);
				$temp_video_file=getVideoName($this->fields_arr['video_id']);

				if(is_file($temp_file_path.$temp_image_file.'S.'.$this->CFG['video']['image']['extensions']))
					unlink($temp_file_path.$temp_image_file.'S.'.$this->CFG['video']['image']['extensions']);

				if(is_file($temp_file_path.$temp_image_file.'T.'.$this->CFG['video']['image']['extensions']))
					unlink($temp_file_path.$temp_image_file.'T.'.$this->CFG['video']['image']['extensions']);

				if(is_file($temp_file_path.$temp_image_file.'L.'.$this->CFG['video']['image']['extensions']))
					unlink($temp_file_path.$temp_image_file.'L.'.$this->CFG['video']['image']['extensions']);

				if(is_file($temp_file_path.$temp_image_file.'_1.'.$this->CFG['video']['image']['extensions']))
					unlink($temp_file_path.$temp_image_file.'_1.'.$this->CFG['video']['image']['extensions']);

				if(is_file($temp_file_path.$temp_image_file.'_2.'.$this->CFG['video']['image']['extensions']))
					unlink($temp_file_path.$temp_image_file.'_2.'.$this->CFG['video']['image']['extensions']);

				if(is_file($temp_file_path.$temp_image_file.'_3.'.$this->CFG['video']['image']['extensions']))
					unlink($temp_file_path.$temp_image_file.'_3.'.$this->CFG['video']['image']['extensions']);

				if(is_file($temp_file_path.$temp_video_file.'.flv'))
					unlink($temp_file_path.$temp_video_file.'.flv');

				if(is_file($temp_file_path.$temp_video_file.'.'.$this->VIDEO_EXT))
					unlink($temp_file_path.$temp_video_file.'.'.$this->VIDEO_EXT);
				//Unlink other format...
				if(isset($this->VIDEO_AVL_FORMAT) and $this->VIDEO_AVL_FORMAT !='')
					{
						$ext = explode(',', $this->VIDEO_AVL_FORMAT);
						for($inc=0;$inc<count($ext);$inc++)
							{
								$temp_file = $temp_video_file.'.'.$ext[$inc];
								if(is_file($temp_file_path.$temp_file))
									unlink($temp_file_path.$temp_file);
							}
					}

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['video'].' WHERE'.
						' video_id='.$this->dbObj->Param($this->fields_arr['video_id']);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
				if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$this->sendMailToUserForDelete();
			}

		/**
		 * VideoUpload::sendMailToUser()
		 *
		 * @return
		 **/
		public function sendMailToUserForDelete()
			{
				$subject = str_replace('VAR_SITE_NAME', $this->CFG['user']['name'], $this->LANG['video_invalid_upload_subject']);
				$body = $this->LANG['video_invalid_upload_content'];
				$body = str_replace('VAR_LINK', '<a href=\''.$this->CFG['site']['url'].'\'>'.$this->CFG['site']['url'].'</a>', $body);
				$body = str_replace('VAR_USER_NAME', $this->VIDEO_USER_NAME, $body);
				$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
				$body = str_replace('VAR_VIDEO_TITLE', $this->VIDEO_TITLE, $body);
				$this->buildEmailTemplate($subject,  nl2br($body), false, true);
				$EasySwift = new EasySwift($this->getSwiftConnection());
				$EasySwift->flush();
				$EasySwift->addPart($this->getEmailContent(), "text/html");
				$from_address = $this->CFG['site']['noreply_name'].'<'.$this->CFG['site']['noreply_email'].'>';
				return $EasySwift->send($this->VIDEO_USER_EMAIL, $from_address, $this->getEmailSubject());
			}

		public function checkIsExternalEmebedCode()
			{
				if($this->IS_EMBED_VIDEO=='Yes')
					{
						return true;
					}
					return false;
			}


		/**
		 * ViewVideo::displayEmbededVideo()
		 *
		 * @return
		 */
		public function displayEmbededVideo()
			{

				$this->VIDEO_EMBED_CODE = str_replace('<embed', '<embed wmode="transparent"', $this->VIDEO_EMBED_CODE);
				$this->VIDEO_EMBED_CODE = str_replace('&lt;embed', '&lt;embed wmode="transparent"', $this->VIDEO_EMBED_CODE);
				echo html_entity_decode($this->VIDEO_EMBED_CODE);

			}
		/**
		 * VideoUpload::selectVideoIdFromTable()
		 *
		 * @return
		 **/
		public function selectVideoIdFromTable($video_id)
			{
				$sql = 'SELECT user_id, video_id, video_ext, video_title,relation_id,video_caption FROM '.$this->CFG['db']['tbl']['video'].
						' WHERE video_encoded_status=\'Yes\' AND video_id='.$this->dbObj->Param('video_id').
						' ORDER BY video_id LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($video_id));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						$this->VIDEO_ID = $this->VIDEOID = $row['video_id'];
						$this->VIDEO_NAME = getVideoName($this->VIDEO_ID);
						$this->VIDEO_THUMB_NAME=getVideoImageName($this->VIDEO_ID);
						$this->VIDEO_EXT = $row['video_ext'];
						$this->VIDEO_TITLE = $row['video_title'];
						$this->VIDEO_RELATION_ID=$row['relation_id'];
						$this->VIDEO_DESCRIPTION = $row['video_caption'];
						$this->fields_arr['video_title']=$row['video_title'];

						$sql = 'SELECT user_name, email FROM '.$this->CFG['db']['tbl']['users'].
								' WHERE user_id='.$this->dbObj->Param('user_id').' LIMIT 0,1';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($row['user_id']));
						    if (!$rs)
							    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						if($row = $rs->FetchRow())
							{
								$this->VIDEO_USER_NAME = $row['user_name'];
								$this->VIDEO_USER_EMAIL = $row['email'];
							}
						return true;
					}
				return false;
			}


		public function UpdateVideoStatus()
		{
			$sql  = 'Update '.$this->CFG['db']['tbl']['video'].' SET video_status=\'Ok\' WHERE video_id='.$this->dbObj->Param($this->fields_arr['video_id']);
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->VIDEO_ID ));
			if (!$rs)
				trigger_db_error($this->dbObj);


			//Srart new video upload activity	..
			$sql = 'SELECT u.user_name as upload_user_name, v.video_id, v.user_id as upload_user_id, v.video_title, v.video_server_url, v.is_external_embed_video, v.embed_video_image_ext '.
					' FROM '.$this->CFG['db']['tbl']['video'].' as v, '.$this->CFG['db']['tbl']['users'].' as u WHERE u.user_id = v.user_id AND video_id = '.$this->dbObj->Param('video_id');
			//echo $this->VIDEO_ID;
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->VIDEO_ID));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			$row = $rs->FetchRow();
			$activity_arr = $row;
			$activity_arr['action_key']	= 'video_uploaded';
			$videoActivityObj = new VideoActivityHandler();
			$videoActivityObj->addActivity($activity_arr);
			//End..

			$this->increaseTotalVideosForUsers($row['upload_user_id']);
		}
		/**
		 * VideoActivate::selectedVideoActivate()
		 *
		 * @return
		 **/
		public function selectedVideoActivate()
			{

				$video_id = $this->fields_arr['video_id'];
				$video_id = explode(',', $video_id);
				foreach($video_id as $key=>$value)
					{
						$this->fields_arr['video_id'] = $value;
						$this->VIDEO_ID = $value;
						if($this->populateVideoDetails())
							{
								if($this->checkIsExternalEmebedCode())
								{

									$this->activateExternalEmbededImage($this->VIDEO_ID);
								}
								else
								{


									$this->createErrorLogFile('Activate');
									$this->selectVideoIdFromTable($this->VIDEO_ID);
									if($this->activateVideoFile())
									{
										//$this->sendMailToUserForActivate();
									}
								}
							}
					}
				$this->setCommonSuccessMsg($this->LANG['msg_success_activated']);
				$this->setPageBlockShow('block_msg_form_success');
			}

		/**
		 * VideoActivate::selectedVideoDelete()
		 *
		 * @return
		 **/
		public function selectedVideoDelete()
			{
				$video_id = $this->fields_arr['video_id'];
				$video_id = explode(',', $video_id);
				foreach($video_id as $key=>$value)
					{
						$this->fields_arr['video_id'] = $value;
						$this->VIDEO_ID = $value;
						if($this->populateVideoDetails())
							{
								$this->deleteVideoFileAndTableEntry();
							}

					}
				$this->setCommonSuccessMsg($this->LANG['msg_success_deleted']);
				$this->setPageBlockShow('block_msg_form_success');
			}
	}
//<<<<<-------------- Class VideoActivate begins ---------------//
//-------------------- Code begins -------------->>>>>//
$VideoActivate = new VideoActivate();
$VideoActivate->setDBObject($db);
$VideoActivate->makeGlobalize($CFG,$LANG);
$VideoActivate->setMediaPath('../../');
$VideoActivate->setPageBlockNames(array('list_videos_form', 'preview_block'));

//default form fields and values...
$VideoActivate->setFormField('video_id', '');
$VideoActivate->setFormField('action', '');
/*********** Page Navigation Start *********/
$VideoActivate->setFormField('start', '0');
$VideoActivate->setFormField('playing_time', '0');
$VideoActivate->setFormField('slno', '1');
$VideoActivate->setFormField('numpg', $CFG['data_tbl']['numpg']);
$VideoActivate->setMinRecordSelectLimit(2);
$VideoActivate->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$VideoActivate->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);

$VideoActivate->setTableNames(array($CFG['db']['tbl']['video'].' as v LEFT JOIN '.$CFG['db']['tbl']['users'].' as u ON v.user_id=u.user_id'));
$VideoActivate->setReturnColumns(array('v.video_id','v.video_encoded_status','v.user_id','v.video_title', 'DATE_FORMAT(v.date_added,\''.$CFG['format']['date'].'\') as date_added', 'v.s_width', 'v.s_height', 'v.is_external_embed_video', 'v.video_external_embed_code', 'v.video_server_url', 'u.user_name', 'u.first_name', 'u.last_name'));

/************ page Navigation stop *************/
$VideoActivate->setAllPageBlocksHide();
$VideoActivate->setPageBlockShow('list_videos_form');
$VideoActivate->sanitizeFormInputs($_REQUEST);

if($VideoActivate->isFormPOSTed($_POST, 'action'))
	{
		if($VideoActivate->getFormField('action')=='activate')
			{
				if($CFG['admin']['is_demo_site'])
					{
						$VideoActivate->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
						$VideoActivate->setPageBlockShow('block_msg_form_success');
					}
				else
					$VideoActivate->selectedVideoActivate();
			}

		else if($VideoActivate->getFormField('action')=='delete')
			{
				if($CFG['admin']['is_demo_site'])
					{
						$VideoActivate->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
						$VideoActivate->setPageBlockShow('block_msg_form_success');
					}
				else
					$VideoActivate->selectedVideoDelete();
			}
	}
else if($VideoActivate->isFormPOSTed($_GET, 'action') and $VideoActivate->getFormField('action')=='preview')
	{
		$VideoActivate->VIDEO_ID = $VideoActivate->getFormField('video_id');
		if($VideoActivate->populateVideoDetails())
			{
				$VideoActivate->setAllPageBlocksHide();
				$VideoActivate->setPageBlockShow('preview_block');
			}
		else
			{
				$VideoActivate->setCommonErrorMsg($LANG['msg_error_sorry']);
				$VideoActivate->setPageBlockShow('block_msg_form_error');
			}
	}

//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
$VideoActivate->hidden = array('start');
if ($VideoActivate->isShowPageBlock('preview_block'))
    {
		$VideoActivate->preview_block['anchor'] = 'MultiDelte';
		$VideoActivate->preview_block['videos_folder'] = $CFG['media']['folder'].'/'.$CFG['admin']['videos']['temp_folder'].'/';
		$VideoActivate->preview_block['flv_player_url'] = $CFG['site']['url'].$CFG['media']['folder'].'/flash/video/flvplayers/flvplayer.swf';
		$VideoActivate->preview_block['configXmlcode_url'] = $CFG['site']['url'].'video/videoConfigXmlCode.php?pg=videoactivate_'.$VideoActivate->getFormField('video_id');
		$VideoActivate->preview_block['populateHidden'] = array('start','video_id');
    }
if ($VideoActivate->isShowPageBlock('list_videos_form'))
    {
		/****** navigtion continue*********/
		$VideoActivate->buildSelectQuery();
		$VideoActivate->buildConditionQuery();
		$VideoActivate->buildSortQuery();
		$VideoActivate->buildQuery();
		$VideoActivate->executeQuery();
		/******* Navigation End ********/
	if($VideoActivate->isResultsFound())
		{
			$VideoActivate->list_videos_form['anchor'] = 'MultiDelte';
			$smartyObj->assign('smarty_paging_list', $VideoActivate->populatePageLinksGET($VideoActivate->getFormField('start'), array()));
			$VideoActivate->list_videos_form['displayVideoList'] = $VideoActivate->displayVideoList();
			$VideoActivate->list_videos_form['onclick_activate'] = 'if(getMultiCheckBoxValue(\'videoListForm\', \'check_all\', \''.$LANG['check_atleast_one'].'\')){Confirmation(\'selMsgConfirmDelete\', \'confirmationForm\', Array(\'video_id\', \'action\', \'confirmMsg\'), Array(multiCheckValue, \'activate\', \''.$LANG['videoactivate_activate_confirmation'].'\'), Array(\'value\', \'value\', \'innerHTML\'), -100, -200);}return false;';
			$VideoActivate->list_videos_form['onclick_delete'] = 'if(getMultiCheckBoxValue(\'videoListForm\', \'check_all\', \''.$LANG['check_atleast_one'].'\')){Confirmation(\'selMsgConfirmDelete\', \'confirmationForm\', Array(\'video_id\', \'action\', \'confirmMsg\'), Array(multiCheckValue, \'delete\', \''.$LANG['videoactivate_delete_confirmation'].'\'), Array(\'value\', \'value\', \'innerHTML\'), -100, -200);}return false;';
		}
    }
$VideoActivate->left_navigation_div = 'videoMain';
//include the header file
$VideoActivate->includeHeader();
//--------------------Page block templates begins-------------------->>>>>//
//include the content of the page
setTemplateFolder('admin/', 'video');
$smartyObj->display('videoActivate.tpl');
?>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/AG_ajax_html.js"></script>
<script language="javascript" type="text/javascript" >
	var block_arr= new Array('selMsgConfirmDelete');
</script>

<?php
//<<<<<-------------------- Page block templates ends -------------------//
$VideoActivate->includeFooter();
?>