<?php
class DailymotionGrab
	{
		public $url;
		public $flv_path;
		public $error_message;
		public $file_content;
		public $video_id;

		public function getDailymotionVideoURL($url)
			{
				$this->url          = $url;
				$this->file_content = fileGetContentsManual($this->url);
				$strPosition = strpos($this->file_content, 'addVariable("video"');

				if(!empty($strPosition))
					{
						$this->file_content = explode('.addVariable("video", "', $this->file_content);

						$this->file_content = explode('%40%40spark%7C%7C', $this->file_content[1]);
						$this->flv_path     = "http://www.dailymotion.com".urldecode($this->file_content[0]);
						/*preg_match('/[f][l][v][\/][0-9]{1,20}[.][f][l][v]/',$this->flv_path,$match);
						if(isset($match[0]))
						{
							$this->video_id     = str_replace(array('flv/','.flv'), '', $match[0]);
						}
						else*/
						$this->video_id='';
					}
				else
					{

						$this->error_message = 'Not a valid Dailymotion video url';
					}
			}
	}
?>
