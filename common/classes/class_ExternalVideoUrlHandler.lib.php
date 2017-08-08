<?php
class ExternalVideoUrlHandler
{
	public $url;
	public $site_name;
	public $error_message = '';
	public $parsedUrl='';
	public $CFG='';
	public $allowed_external_sites=array();

	//@todo add another parameter to check if it is needed to fetch the full details
	public function chkIsValidExternalSite($url,$isNeedFullDetail='',$CFG)
	{
		$this->url = $url;
		$this->CFG = $CFG;
		$this->return_arr['external_site']='';
		$this->return_arr['video_id']='';
		$this->return_arr['external_video_flv_path']='';
		$this->return_arr['error_message']='';
		## This path is used to Store in video_flv_url If this has the value the Video played from external website
		$this->return_arr['video_flv_path']='';
		$valid_site = false;
		$this->parsedUrl=parse_url($url);
		$this->allowed_external_sites=array('youtube'=>array('check_url'=>'youtube.com','download_option'=>$CFG['admin']['videos']['download_youtube_videos']),
			  'google'=>array('check_url'=>'video.google.com','download_option'=>$CFG['admin']['videos']['download_google_videos']),
			  'dailymotion'=>array('check_url'=>'dailymotion.com','download_option'=>$CFG['admin']['videos']['download_dailymotion_videos']),
			  'myspace'=>array('check_url'=>'vids.myspace.com','download_option'=>$CFG['admin']['videos']['download_myspace_videos']),
			  'flvpath'=>array('check_url'=>'.flv','download_option'=>$CFG['admin']['videos']['download_flvpath_videos']));
		if(!isset($this->parsedUrl['host']))
		{
			$this->return_arr['error_message']='Invalid Url';
			return $this->return_arr;
		}
		if(preg_match('/\.flv/',$url))
		{
			$this->site_name='flvpath';
			$valid_site = true;
			$this->return_arr['external_video_flv_path']=$url;
			$isNeedFullDetail='';
		}
		else
		{
			foreach($this->allowed_external_sites as $site => $site_start)
			{
				$match_variable = $site_start['check_url'];
				$pattern='/'.$match_variable.'/';
				if(preg_match($pattern,$this->parsedUrl['host']))
				{
					$this->site_name=$site;
					$valid_site = true;
					break;
				}
			}
		}

		if($valid_site)
		{
			if($isNeedFullDetail)
			{
				$this->checkIsValidExternalVideoUrl();
			}
			#video_flv_path value is set if the download option is true
			if(!$this->allowed_external_sites[$this->site_name]['download_option'])
			{
				$this->return_arr['video_flv_path']=$this->return_arr['external_video_flv_path'];
			}
			else
			{
			$this->return_arr['video_flv_path']='';
			}
			$this->return_arr['external_site']=$this->site_name;
			return $this->return_arr;
		}
		else
		{
			$this->return_arr['error_message']= 'Not a valid External site';
			return $this->return_arr;
		}

	}

	public function checkIsValidExternalVideoUrl()
	{
		switch($this->site_name)
		{
			case 'youtube':
				require_once($this->CFG['site']['project_path'].'common/classes/class_YoutubeGrabHandler.lib.php');
				$youtubeObj = new YoutubeGrab();
				$video_id = $youtubeObj->getYouTubeVideoId($this->url);
				$video_flv_path='';
				if($video_id)
					$video_flv_path = $youtubeObj->GetYouTubeVideoURL($video_id);
				else
					$this->error_message = 'Not a valid Youtube video url';
				if(!$video_flv_path && $video_id)
				{
					$this->error_message = 'Not able to fetch the video file from Youtube';
				}
				$this->return_arr['external_site']=$this->site_name;
				$this->return_arr['video_id']=$video_id;
				$this->return_arr['external_video_flv_path']=$video_flv_path;
				$this->return_arr['error_message']=$this->error_message;

				break;

			case 'google':
				parse_str($this->parsedUrl['query']);
				require_once($this->CFG['site']['project_path'].'common/classes/class_GoogleHandler.lib.php');
				$googleObj = new GoogleGrab();
				$googleObj->getGoogleVideoDetail($docid);
				$this->return_arr['external_site']=$this->site_name;
				$this->return_arr['video_id']=$docid;
				$this->return_arr['external_video_flv_path'] =$googleObj->flv_path;
				$this->return_arr['error_message']=$googleObj->error_message;
				break;

			case 'dailymotion':
				require_once($this->CFG['site']['project_path'].'common/classes/class_DailymotionGrabHandler.lib.php');
				$dailymotionObj = new DailymotionGrab();
				$dailymotionObj->getDailymotionVideoURL($this->url);
				$this->return_arr['external_site']           = $this->site_name;
				$this->return_arr['video_id']                = $dailymotionObj->video_id;
				$this->return_arr['external_video_flv_path'] = $dailymotionObj->flv_path;
				if($this->return_arr['video_id'] && !$this->return_arr['external_video_flv_path'])
					$this->return_arr['error_message']       = 'Not able to fetch the video file from Dailymotion';
				else
					$this->return_arr['error_message']       = $dailymotionObj->error_message;
				break;

			case 'myspace':
				$VideoID    = '';
				require_once($this->CFG['site']['project_path'].'common/classes/class_MyspaceHandler.lib.php');
				$myspaceObj = new MyspaceGrab();
				if(preg_match("/vids.individual/",$this->url))
					{
						$explodeURL = explode("VideoID=", $this->url);
						if(isset($explodeURL['1']))
							$VideoID    = $explodeURL['1'];
						else
						{
							$explodeURL = explode("videoid=", $this->url);
							$VideoID    = $explodeURL['1'];
						}

						$myspaceObj->getMyspaceVideoDetail($VideoID);
						$this->return_arr['video_id']                = $VideoID;
						$this->return_arr['external_video_flv_path'] = $myspaceObj->flv_path;
						$this->return_arr['error_message']           = $myspaceObj->error_message;
					}
				$this->return_arr['external_site']           = $this->site_name;
				if(!$this->return_arr['video_id'])
					$this->return_arr['error_message']       = 'Not able to fetch the video file from Myspace';
				break;
	   }

	}


}
?>
