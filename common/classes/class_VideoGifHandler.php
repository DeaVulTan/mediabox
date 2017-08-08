<?php
require_once("class_imageconverter.lib.php");
require_once("class_GIFEncoder.lib.php");
define('ERR00','');
define('ERR01','');
define('ERR02','');
define('ERR03','');
define('ERR04','');
class imagesAnimate extends VideoHandler
	{
		public $GENERATED_GIF_FILE_PATHS=array();
		public $GENERATED_GIF_FILE_NAMES='';
		public $MEDIA_TYPE_CFG='videos';
		public $VIDEO_EXT='flv';
		public $CFG;

		public function intitializeImagesAnimate($delay_time=5, $temp_dir, $tempurl, $VIDEO_NAME,$VIDEO_THUMB_NAME, $CFG, $playing_time='', $video_type='', $save_external_gif_path='', $width='', $height='')
			{
				$this->JPG_PATH=$temp_dir.$VIDEO_THUMB_NAME.'_frames/';
				$this->VIDEO_EXT=$video_type;
				$this->CFG=$CFG;
				$this->GIF_PATH_TO_GENERATE=$temp_dir.$VIDEO_THUMB_NAME.'_gifs/';
				$this->GIF_FILE_NAME=$temp_dir.$VIDEO_THUMB_NAME.'_G.gif';
				$this->err_msgs=array();
				if($this->convertImagesGIF($tempurl.'.'.$this->VIDEO_EXT, $playing_time, $video_type, $width, $height))
				{
					if(!$CFG['admin']['videos']['rotating_thumbnail_js_method'] || $CFG['admin']['videos']['rotating_thumbnail_gif_backup'])
					{
						if($this->animageImages($delay_time, $save_external_gif_path))
							return true;
					}
					else
					{
						return true;
					}
				}
				return false;
			}

		public function convertImagesGIF($video_file='', $playing_time, $video_type, $width='', $height='')
			{
				$video_type=strtolower($video_type);

				$total_frames = $this->CFG['admin']['videos']['rotating_thumbnail_max_frames'];

				$this->chkAndCreateFolder($this->JPG_PATH);

				$execute_str=$this->videoToFrame($video_file, $this->JPG_PATH, $total_frames, $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['frame_width'].':'.$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['frame_height'],true);

				//echo $execute_str.'<br />';

				$frames=array();
				if ($dh = @opendir ($this->JPG_PATH))
					{


						while ( false !== ( $dat = readdir ( $dh ) ) )
							{
							if ( $dat != "." && $dat != ".." )
								{
									$file_name="$this->JPG_PATH/$dat";

									$imageObj = new ImageHandler($file_name);

									### Removing Black image in animation
									/*if($imageObj->chkIsNotBlackImage($file_name))
									{
										$fileinfo= pathinfo($file_name);
										echo "<br>in<br>";
									}
									else
									{
										$fileinfo["extension"]='';
										unlink($file_name);
									}*/
									$fileinfo= pathinfo($file_name);
									if($fileinfo["extension"]=='jpg')
										{

											$width=($width)?$width:$this->CFG['admin']['videos']['thumb_width'];
											$height=($height)?$height:$this->CFG['admin']['videos']['thumb_height'];

											$imageObj->resize($width, $height, '-');
											$imageObj->output_resized($file_name, 'JPG');
											unset($imageObj);
											$file_name_val=intval($fileinfo['basename']);
											$frames [$file_name_val] = $file_name;
										}
								}
							}
						closedir ( $dh );
					}
					else
						$this->err_msgs[]='CANNOT OPEN DIR '.$this->GIF_PATH_TO_GENERATE;


				if(!file_exists($this->GIF_PATH_TO_GENERATE))
					$this->chkAndCreateFolder($this->GIF_PATH_TO_GENERATE);

//				echo '------------<br>';
//				print_r($this->err_msgs);
//				print_r($frames);
//				echo '<br>------------';

				if($frames)
					{
						$file_name_gif=1;
						ksort($frames);

						foreach($frames as $index=>$file_name)
							{
								$this->GENERATED_GIF_FILE_PATHS[$file_name_gif]=$file_name;
								$this->GENERATED_GIF_FILE_NAMES.=$file_name_gif.',';
								$fileinfo  		= pathinfo($file_name);
								$imtype 		= $fileinfo["extension"];
								//$file_name_gif 	= basename($fileinfo["basename"],".gif");
								$imageConvertor=new ImageConverter($file_name, "gif", false, $this->GIF_PATH_TO_GENERATE.$file_name_gif);
								$file_name_gif++;
							}
						$this->GENERATED_GIF_FILE_NAMES=rtrim($this->GENERATED_GIF_FILE_NAMES,',');
					}
					else
						{
							$this->err_msgs[]='NO FILES EXISTS @ '.$this->JPG_PATH;
							return false;
						}

					return true;
			}

		public function animageImages($delay_time=50,$save_external_gif_path='', $Animationloops=0, $Disposal=2, $red=0, $green=0, $blue=0)
		{

				/*
					Build a frames array from sources...
				*/
				if ($dh = @opendir ($this->GIF_PATH_TO_GENERATE))
				{
					$file_count=1;
					while ( false !== ( $dat = readdir ( $dh ) ) )
					{
						if ( $dat != "." && $dat != ".." )
							{
								$file_name="$this->GIF_PATH_TO_GENERATE/$dat";
								$fileinfo= pathinfo($file_name);
								if($fileinfo["extension"]=='gif')
									{
										$file_name_val=intval($fileinfo['basename']);
										$file_name_val=$file_name_val-1;
										$frames [$file_name_val] = $file_name;
										$file_count++;
										$framed [$file_name_val]=$delay_time;
									}
							}
					}
					closedir ( $dh );
				}
				else
					$this->err_msgs[]='CANNOT OPEN DIR '.$this->GIF_PATH_TO_GENERATE;

				if(!$frames)
					$this->err_msgs[]='NO FILES EXISTS @ '.$this->GIF_PATH_TO_GENERATE;

				if($this->err_msgs)
					return false;

				ksort($frames);
				/*
						GIFEncoder constructor:
				        =======================

						image_stream = new GIFEncoder	(
											URL or Binary data	'Sources'
											int					'Delay times'
											int					'Animation loops'
											int					'Disposal'
											int					'Transparent red, green, blue colors'
											int					'Source type'
										);
				*/
				$gif = new GIFEncoder	(
											$frames,
											$framed,
											$Animationloops,
											$Disposal,
											$red, $green, $blue,
											"url"
						);
				if($gif_image=$gif->GetAnimation())
				{
					$gif_file_name=$this->GIF_FILE_NAME;
					if($save_external_gif_path)
						$gif_file_name=$save_external_gif_path;
						$file_handler=fopen($gif_file_name, "w");
						@fwrite($file_handler,$gif_image);
						@fclose($file_handler);
						$return=true;
				}

				return $return;
			}

	}

//$imageAnimate=new imagesAnimate();
/*$imageAnimate->JPG_PATH='frames/';
$imageAnimate->GIF_PATH_TO_GENERATE='gifs/';
$imageAnimate->GIF_FILE_NAME='generated_gif.gif';
$imageAnimate->err_msgs=array();
$imageAnimate->convertImagesGIF($delay_time=100);
$imageAnimate->animageImages();
*/
//$imageAnimate->intitializeImagesAnimate(5,'../files/temp_files/temp_videos/','','0353ab4cbed5bea',$CFG,20,'.flv','','');

?>
