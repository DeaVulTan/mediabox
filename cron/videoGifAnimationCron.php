<?php
/**
 * This file is to to animate thumbs for the videos
 *
 * This file is having VideoActivate class to animate thumbs for the videos
 *
 * @category	rayzz
 * @package		Cron
 *
 **/
$called_from_cron = true;
require_once(dirname(dirname(__FILE__)).'/common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoUpload.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoGifHandler.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['auth']['is_authenticate'] = false;
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;

require_once($CFG['site']['project_path'].'common/application_top.inc.php');

set_time_limit(0);
class VideoActivate extends VideoUploadLib
	{

		public function moveGeneratedGif($gif_path, $is_gif_animated_status='yes')
			{
				$dir_thumb = '../'.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
				$dir_video = '../'.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['video_folder'].'/';

				$temp_dir = '../'.$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin']['videos']['temp_folder'].'/';
				$tempurl =  $temp_dir.$this->VIDEO_NAME;

				$local_upload=true;

				if($is_gif_animated_status=='yes')
					{

						if($this->getServerDetails())
							{
								dbDisconnect();
								if($FtpObj = new FtpHandler($this->FTP_SERVER,$this->FTP_USERNAME,$this->FTP_PASSWORD))
									{
										if($this->FTP_FOLDER)
											$FtpObj->changeDirectory($this->FTP_FOLDER);

										$dir_thumb = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
										$dir_video = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['video_folder'].'/';

										$FtpObj->makeDirectory($dir_thumb);
										$FtpObj->makeDirectory($dir_video);

										if(is_file($temp_dir.$this->VIDEO_NAME.'_G.gif'))
											{
												$FtpObj->moveTo($gif_path, $dir_thumb.$this->VIDEO_NAME.'_G.gif');
												unlink($gif_path);
											}
										$local_upload = false;
									}
								dbConnect();
							}
						if($local_upload)
							{
								dbDisconnect();
								$upload_dir_thumb = $dir_thumb;
								$upload_dir_video = $dir_video;

								$this->chkAndCreateFolder($upload_dir_thumb);
								$this->chkAndCreateFolder($upload_dir_video);

								$uploadUrlThumb = $upload_dir_thumb.$this->VIDEO_NAME;
								$uploadUrlVideo = $upload_dir_video.$this->VIDEO_NAME;


								if(is_file($temp_dir.$this->VIDEO_NAME.'_G.gif'))
									{
										copy($gif_path, $uploadUrlThumb.'_G.gif');
										unlink($gif_path);
									}

								$SERVER_URL = $this->CFG['site']['url'];
								dbConnect();
							}
					}
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].' SET '.
						' is_gif_animated=\''.$is_gif_animated_status.'\' WHERE '.
						' video_id='.$this->dbObj->Param('video_id');
						$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->VIDEO_ID));
					if (!$rs)
						trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			}

		public function populateVideoDetailsForActivate()
			{
				$sql = 'SELECT v.video_title, v.video_ext, video_category_id,  v.t_width, v.t_height, video_server_url,  v.video_id, playing_time FROM '.$this->CFG['db']['tbl']['video'].
						' v  WHERE video_status=\'Ok\' AND video_encoded_status=\'Yes\' AND flv_upload_type=\'Normal\' AND is_gif_animated=\'no\' ORDER BY video_id LIMIT '.$this->LIMIT;

				//echo $sql;


				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$videos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['video_folder'].'/';

				$temp_dir = '../'.$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin']['videos']['temp_folder'].'/';

				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
						    {
								$this->VIDEO_TITLE = $row['video_title'];
								$this->VIDEO_WIDTH = $row['t_width'];
								$this->VIDEO_HEIGHT = $row['t_height'];
								$this->VIDEO_ID = $row['video_id'];
								$this->VIDEO_NAME = getVideoImageName($this->VIDEO_ID);
								$this->VIDEO_CATEGORY_ID=$row['video_category_id'];
								$this->VIDEO_EXT = $row['video_ext'];
								$this->PLAYING_TIME = $row['playing_time'];

//						$tempurl=$row['video_server_url'].$videos_folder.$this->VIDEO_NAME;

						$tempurl='../'.$videos_folder.$this->VIDEO_NAME;

						echo ' GOING TO ANIMATE video_id: '.$this->VIDEO_ID.' EXISTS AT '.$tempurl.'.flv  <br/>';
//						echo 'PARAMS: ';
//						echo $this->CFG['admin']['videos']['animated_gif_delay_time'],
//								$temp_dir, $tempurl, $this->VIDEO_NAME, $this->CFG,
//								$row['playing_time'],$this->VIDEO_EXT;
//						echo '<br />';


						$save_external_gif_path=$temp_dir.$this->VIDEO_NAME.'_G.gif';

						$imageAnimate=new imagesAnimate();
						if( file_exists($tempurl.'.flv') and $imageAnimate->intitializeImagesAnimate(
							$this->CFG['admin']['videos']['animated_gif_delay_time'],
								$temp_dir, $tempurl, $this->VIDEO_NAME, $this->CFG,
								$row['playing_time'],$this->VIDEO_EXT, $save_external_gif_path,
								$this->VIDEO_WIDTH, $this->VIDEO_HEIGHT))
							{
								$this->moveGeneratedGif($save_external_gif_path);
							}
							else
								$this->moveGeneratedGif($save_external_gif_path, $status='skip');

							}
					}
			}
	}
//<<<<<-------------- Class VideoActivate begins ---------------//
//-------------------- Code begins -------------->>>>>//
$VideoActivate = new VideoActivate();
$VideoActivate->setDBObject($db);
$VideoActivate->makeGlobalize($CFG, $LANG);
$VideoActivate->LIMIT=2;
//default form fields and values...
$VideoActivate->populateVideoDetailsForActivate();
//require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');
?>