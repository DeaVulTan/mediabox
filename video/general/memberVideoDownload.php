<?php
/**
 * VideoDownload
 *
 * @package
 * @author selvaraj_35ag05
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: $
 * @access public
 **/
class VideoDownload extends VideoHandler
	{
		/**
		 * VideoDownload::chkValidVideoId()
		 *
		 * @return
		 **/
		public function chkValidVideoId()
			{
				$this->sql_condition = 'v.video_status=\'Ok\' AND v.video_encoded_status=\'Yes\' AND v.video_id=\''.addslashes($this->fields_arr['video_id']).'\' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR v.video_access_type = \'Public\''.$this->getAdditionalQuery('v.').')';

				$sql = 'SELECT v.video_ext, v.video_server_url, v.video_title,video_flv_url, flv_upload_type,form_upload_type,external_site_video_url'.
						' FROM '.$this->CFG['db']['tbl']['video'].' as v'.
						' WHERE '.$this->sql_condition.' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->fields_arr['video_ext'] = $row['video_ext'];
						$this->fields_arr['video_server_url'] = $row['video_server_url'];
						$this->fields_arr['video_title'] = $row['video_title'];
						$this->fields_arr['video_flv_url'] = $row['video_flv_url'];
						$this->fields_arr['flv_upload_type'] = $row['flv_upload_type'];
						$this->fields_arr['form_upload_type'] = $row['form_upload_type'];

						if($row['form_upload_type']=='externalsitevideourl')
						{
							require_once($this->CFG['site']['project_path'].'common/classes/class_ExternalVideoUrlHandler.lib.php');
							$extHandler=new ExternalVideoUrlHandler();
							$checkUrl=$extHandler->chkIsValidExternalSite($row['external_site_video_url'],'',$this->CFG);
							if($checkUrl['external_site']=='youtube')
							{
								if(!$this->CFG['admin']['videos']['download_youtube_videos'])
									return false;
								else
									$this->fields_arr['flv_upload_type'] = 'Normal';
							}
							else if($checkUrl['external_site']=='google')
							{
								if(!$this->CFG['admin']['videos']['download_google_videos'])
									return false;
								else
									$this->fields_arr['flv_upload_type'] = 'Normal';
							}
							else if($checkUrl['external_site']=='dailymotion')
							{
								if(!$this->CFG['admin']['videos']['download_dailymotion_videos'])
									return false;
								else
									$this->fields_arr['flv_upload_type'] = 'Normal';
							}
							else if($checkUrl['external_site']=='myspace')
							{
								if(!$this->CFG['admin']['videos']['download_myspace_videos'])
									return false;
								else
									$this->fields_arr['flv_upload_type'] = 'Normal';
							}
							else if($checkUrl['external_site']=='flvpath')
							{
								if(!$this->CFG['admin']['videos']['download_flvpath_videos'])
									return false;
								else
									$this->fields_arr['flv_upload_type'] = 'Normal';

							}
						}
						return true;
					}
				return false;
			}

		public function url_exists($url)
			{
			    if ($ss = @fileGetContentsManual($url ,true))
					return true;
				return false;
			}

		/*public function chkIsValidYoutubeUrl($url)
			{
				if(!$this->CFG['admin']['upload_external_use_curl'])
					return $url;

				if(strpos($url, 'youtube.com/get_video') and strpos($url, 'video_id'))
					{
						$video_id = substr($url, strpos($url, 'video_id=')+9);
						$video_id = substr($video_id, 0, strpos($video_id, '&', 1));
						$video_id=trim($video_id)?$video_id:getYouTubeVideoIDFromUrl($url);
						$youtube_url = 'http://youtube.com/watch?v='.$video_id;
						$youtubeObj = new YoutubeGrab();
						if($youtube_details_arr = $youtubeObj->GrabYouTube($youtube_url))
							{
								if($url = $youtubeObj->GetYouTubeVideoURL($youtube_details_arr['youtube_video_id']))
									{
										return $url;
									}
							}
					}
				else
					{
						return $url;
					}
			}*/

		/**
		 * VideoDownload::downloadVideo()
		 *
		 * @param $file
		 * @param $name
		 * @return
		 **/
		public function downloadVideo()
			{
				unset($_SESSION['download_type']);
				$download_file_name = $this->changeTitle($this->fields_arr['video_title']);
					if($this->CFG['admin']['videos']['full_length_video']=='members' AND !isLoggedin() AND $this->fields_arr['video_type']=='flv' AND $this->fields_arr['user_id']!=$this->CFG['user']['user_id'])
				{
					$trim_video_folder=$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['trimed_video_folder'].'/';
					$video_url=$this->fields_arr['video_server_url'].$trim_video_folder.getTrimVideoName($this->fields_arr['vid']).'.flv';
				}
				else if($this->CFG['admin']['videos']['full_length_video']=='paid_members' AND !isPaidMember() AND $this->fields_arr['video_type']=='flv' AND $this->fields_arr['user_id']!=$this->CFG['user']['user_id'])
				{
					$trim_video_folder=$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['trimed_video_folder'].'/';
					$video_url=$this->fields_arr['video_server_url'].$trim_video_folder.getTrimVideoName($this->fields_arr['vid']).'.flv';
				}
				else
				{
					$video_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['video_folder'].'/';
					$video_url = $this->fields_arr['video_server_url'].$video_folder.getVideoName($this->fields_arr['video_id']);
				}
				$flv_filename = $video_url.'.flv';
				$otherFormat=false;

				if($this->fields_arr['video_type']!='flv' AND $this->fields_arr['user_id']!=$this->CFG['user']['user_id'])
				{
					if($this->CFG['admin']['videos']['full_length_video']=='members' AND !isLoggedin())
					{
						return false;
					}
					else if($this->CFG['admin']['videos']['full_length_video']=='paid_members' AND !isPaidMember())
					{
						return false;
					}

				}

				switch($this->fields_arr['video_type']){
					case 'flv':
							$filename = $flv_filename;
							$otherFormat=true;
						break;
					case 'original':

							$otherFormat=true;
							if($this->CFG['admin']['videos']['save_original_file_to_download'])
							{
								$orginal_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['original_video_folder'].'/';
								$orignal_url =$this->fields_arr['video_server_url'].$orginal_folder.getVideoName($this->fields_arr['video_id']);
								$filename = $orignal_url.'.'.$this->fields_arr['video_ext'];
								$this->fields_arr['video_type']=$this->fields_arr['video_ext'];
							}
							else
							{
								$filename = $flv_filename;
								$this->fields_arr['video_type']='flv';
							}
						break;
					default:
							if($this->CFG['admin']['videos']['video_other_formats_enabled'])
							{
								$other_format_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['other_videoformat_folder'].'/';
								$other_format_url =$this->fields_arr['video_server_url'].$other_format_folder.getVideoName($this->fields_arr['video_id']);
								$filename=$other_format_url.'.'.$this->fields_arr['video_type'];
								$otherFormat=true;
							}
							else
							{
								$filename = $flv_filename;
								$this->fields_arr['video_type']='flv';
							}
				} // switch
				if($this->fields_arr['flv_upload_type']=='Normal')
					{
						if($this->fields_arr['video_type']!='flv')
						{

							if(!$this->chkIsAvailVideoFormat($this->fields_arr['video_type'], $this->fields_arr['video_id']))
							{
								return false;
							}
						}

						if($this->url_exists($filename))
						{
							
							if($otherFormat)
							{
								$this->incrementOtherFormatTotalDownload($this->fields_arr['video_type'], $this->fields_arr['video_id']);
							    $this->incrementTotalDownload();
							}
							else
							{
								$this->incrementOtherFormatTotalDownload($this->fields_arr['video_type'], $this->fields_arr['video_id']);
							    $this->incrementTotalDownload();
							}
							Redirect2URL($filename);
							exit;
						}
						else
						{
							return false;
						}

					}
				/*else
					{

						if($this->url_exists($filename))
						{
							Redirect2URL($filename);
							exit;
						}
						else
						{
							if($this->fields_arr['video_flv_url'])
							{
								$url = $this->chkIsValidYoutubeUrl($this->fields_arr['video_flv_url']);
								$file = $url;
								header('location:'.$file);
								exit;

							}
						}

					}*/

				//return false;
			}

		/**
		 * VideoDownload::incrementTotalDownload()
		 *
		 * @return
		 **/
		public function incrementTotalDownload()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].' SET'.
						' total_downloads=total_downloads+1'.
						' WHERE video_id='.$this->dbObj->Param('video_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
				if (!$rs)
				    trigger_db_error($this->dbObj);
			}

		public function isMemberDownload()
		{

			if($this->CFG['admin']['videos']['download_previlages']=='members')
			{
				if(!isLoggedin())
				{

					$_SESSION['download_url']=getUrl('viewvideo','?video_id='.$this->fields_arr['video_id'].'&video_title='.$this->fields_arr['video_title'],$this->fields_arr['video_id'].'/'.$this->fields_arr['video_title'].'/','members','video');
					$_SESSION['download_type']=$this->getFormField('video_type');
					$url=getUrl('login','', '');
					Redirect2URL($url);
				}
				else
				{
					return true;
				}

			}
			else
			{
				return true;
			}
		}
	}
//<<<<<-------------- Class VideoDownload begins ---------------//
//-------------------- Code begins -------------->>>>>//
$VideoDownload = new VideoDownload();
$VideoDownload->setDBObject($db);
$VideoDownload->makeGlobalize($CFG, $LANG);

if(!chkAllowedModule(array('video')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$VideoDownload->setPageBlockNames(array('download_video_form','block_msg_form_error'));
$VideoDownload->setCSSFormFieldErrorTipClass('clsFormFieldErrTip');
$VideoDownload->setCSSFormLabelCellDefaultClass('clsFormLabelCellDefault');
$VideoDownload->setCSSFormFieldCellDefaultClass('clsFormFieldCellDefault');
$VideoDownload->setCSSFormLabelCellErrorClass('clsFormLabelCellError');
$VideoDownload->setCSSFormFieldCellErrorClass('clsFormFieldCellError');
//default form fields and values...
$VideoDownload->setFormField('video_id', '');
$VideoDownload->setFormField('video_type', 'flv');
$VideoDownload->sanitizeFormInputs($_REQUEST);


if($CFG['admin']['videos']['download_option'])
	{
		if($VideoDownload->isFormGETed($_GET,'video_id'))
			{
				if($VideoDownload->chkValidVideoId())
					{
						if($VideoDownload->isMemberDownload())
						{
							$VideoDownload->downloadVideo();
						}
					}
			}
	}

$VideoDownload->setCommonErrorMsg($LANG['msg_error_sorry']);
$VideoDownload->setPageBlockShow('block_msg_form_error');

//<<<<<-------------------- Page block templates ends -------------------//
$VideoDownload->includeHeader();
setTemplateFolder('general/','video');
$smartyObj->display('videoDownload.tpl');
$VideoDownload->includeFooter();

?>
