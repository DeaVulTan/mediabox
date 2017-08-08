<?php
/**
 * This file is to give video images
 *
 * This file is having VideoAnimatedImage class to manage deleted game
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Admin
 * @author 		logamurugan_41ag04
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2006-05-02
 *
 **/
require_once('../common/configs/config.inc.php');
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['auth']['is_authenticate'] = false;
/**
 * To include application top file
 */
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class ConfigEdit begins -------------------->>>>>//
/**
 * VideoAnimatedImage
 *
 * @package
 * @author logamurugan_41ag04
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: $
 * @access public
 **/

set_time_limit(0);
class VideoAnimatedImage extends FormHandler
	{
		/**
		 * VideoAnimatedImage::getGameDetails()
		 *
		 * @return
		 **/
		public function getVideoDetails()
			{
				//$this->fields_arr['game_id'];
				$sql = 'SELECT video_id, animated_gif_file_names, is_gif_animated, video_server_url '.
						' FROM '.$this->CFG['db']['tbl']['video'].
						' WHERE video_id='.$this->dbObj->Param('video_id').' LIMIT 0,1 ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
				$current_image='';
				if($row = $rs->FetchRow())
					{
						$this->video_server_url = $row['video_server_url'];
						if($this->chkIsLocalServer())
						{
							$thumbnail_url = '../'.$thumbnail_folder;
						}
						else
						{
							$thumbnail_url = $row['video_server_url'].$thumbnail_folder;
						}

						//print_r($row);
						$current_image=$thumbnail_url.getVideoImageName($row['video_id']).'T.'.$this->CFG['video']['image']['extensions'];
						if($row['is_gif_animated'] and $row['animated_gif_file_names'])
							{
								$files_arr=explode(',',$row['animated_gif_file_names']);

								if(isset($_SESSION['video_animated']) and $_SESSION['video_animated']==$row['video_id'])
									{
										if(isset($_SESSION['video_animated_counter']) and $_SESSION['video_animated_counter'])
											$_SESSION['video_animated_counter']++;
											else
												$_SESSION['video_animated_counter']=1;
										if(count($files_arr)<$_SESSION['video_animated_counter'])
											$_SESSION['video_animated_counter']=1;
									}
									else
										{
											$_SESSION['video_animated']=$row['video_id'];
											$_SESSION['video_animated_counter']=1;
										}
								$video_animated=getVideoImageName($_SESSION['video_animated']).'_gif/';

								$current_image=$thumbnail_url.$video_animated.$_SESSION['video_animated_counter'].'.jpg';

							}
					}

				//return $current_image;
				@ob_start();
				//header('Content-disposition: attachment; filename='.$current_image);
				header("Content-Type: image/gif");
				$img = $this->LoadGif($current_image);
				imagegif($img);
				exit;
			}

		public function chkIsLocalServer()
			{
				$server_url = $this->video_server_url;
				if(strstr($server_url,$this->CFG['site']['url']))
					{
						$server_url = str_replace($this->CFG['site']['url'],'',$server_url);
						if(trim($server_url)=='')
							{
								return true;
							}
					}
				return false;
			}

		public function LoadGif ($imgname)
			{
				if(strpos($imgname,'.gif'))
				    $im = @imagecreatefromgif ($imgname); /* Attempt to open */
					else
					    $im = @imagecreatefromjpeg($imgname); /* Attempt to open */
			    if (!$im) { /* See if it failed */

					$imgname='./images/no-video.jpg';
					$im = @imagecreatefromjpeg($imgname);
					if(!$im)
						{
					        $im = imagecreatetruecolor ($this->CFG['admin']['videos']['thumb_width'], $this->CFG['admin']['videos']['thumb_height']); /* Create a blank image */
					        $bgc = imagecolorallocate ($im, 0, 0, 0);
					        $tc = imagecolorallocate ($im, 0, 0, 0);
					        imagefilledrectangle ($im, 0, 0, 150, 30, $bgc);
					        /* Output an errmsg */
					        //imagestring ($im, 1, 5, 5, "Error loading $imgname", $tc);
						}
			    }
			    return $im;
			}
	}
//<<<<<-------------- Class VideoAnimatedImage begins ---------------//
//-------------------- Code begins -------------->>>>>//
$VideoAnimatedImage = new VideoAnimatedImage();
$VideoAnimatedImage->setDBObject($db);
$VideoAnimatedImage->setFormField('video_id','');
$VideoAnimatedImage->setFormField('start_counter','');
$VideoAnimatedImage->makeGlobalize($CFG,$LANG);
$VideoAnimatedImage->sanitizeFormInputs($_REQUEST);
echo $VideoAnimatedImage->getVideoDetails();
//require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');
?>