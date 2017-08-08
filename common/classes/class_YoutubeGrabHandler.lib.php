<?php
ini_set('display_errors',0);
class YoutubeGrab
{
	/**
	 * _GetPage
	 * Returns $url content
	 *
	 * @param string $url
	 * @return
	 */
	public function _GetPage($url)
	{
	    $ch = curl_init($url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.2) Gecko/20070219 Firefox/2.0.0.2');
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $page = curl_exec($ch);
	    if (!curl_errno($ch))
	        curl_close($ch);
	      else
	        $page = false;
	    return $page;
	}

	/**
	 * YoutubeGrab::getYouTubeVideoId()
	 *
	 * @param mixed $url
	 * @return string //youtube video id
	 * @access public
	 */
	public function getYouTubeVideoId($url)
	{
		 $parse_value_arr = parse_url($url);
       	 parse_str($parse_value_arr['query'], $youtube_url_prop);
       	 $youtube_video_id = isset($youtube_url_prop['v']) ? $youtube_url_prop['v'] : '';
       	 return $youtube_video_id;
	}

	/**
	 * GrabYouTube()
	 *
	 * * Grabs $youtube_url
	 * * returns the title, description, tags, youtube_video_id, thumbnail_url and error on error
	 *
	 * @param string $youtube_url
	 * @param string $video_id
	 * @return
	 */
	public function GetYouTubeVideoURL($youtube_video_id)
		{
		    //$youtube_page = $this->_GetPage('http://youtube.com/watch?v='.$youtube_video_id);
		    $youtube_video_url = '';
		    parse_str(getContents("http://www.youtube.com/get_video_info?video_id=$youtube_video_id"));
		    //fix for the change done in july 2010 by youtube , get_video.php now shows 404 error
		    $video_url_array = array();
		    if(isset($fmt_stream_map))
		    {
		    	$fmt_arr = explode('||', $fmt_stream_map);
				/*
		    	Array
				(
				    [0] => 35|http://v22.lscache7.c.youtube.com/videoplayback?ip=0.0.0.0&sparams=id%2Cexpire%2Cip%2Cipbits%2Citag%2Calgorithm%2Cburst%2Cfactor%2Coc%3AU0dXRlROVl9FSkNNN19MSFpB&fexp=907112%2C906402&algorithm=throttle-factor&itag=35&ipbits=0&burst=40&sver=3&expire=1281438000&key=yt1&signature=D87C06539B8E7E45F3B23E67B18E71ABA7C40D3C.25E6FD5D5A287A8D12D3B529538B714C820C03C3&factor=1.25&id=bd383b3d449589d2
				    [1] => tc.v22.cache7.c.youtube.com,34|http://v9.lscache4.c.youtube.com/videoplayback?ip=0.0.0.0&sparams=id%2Cexpire%2Cip%2Cipbits%2Citag%2Calgorithm%2Cburst%2Cfactor%2Coc%3AU0dXRlROVl9FSkNNN19MSFpB&fexp=907112%2C906402&algorithm=throttle-factor&itag=34&ipbits=0&burst=40&sver=3&expire=1281438000&key=yt1&signature=7FB4BE69348EAB16E3F95DBBED18F6B24419A788.B6F98C705150CA3C8D69663F3FC9B72BEE9E86D8&factor=1.25&id=bd383b3d449589d2
				    [2] => tc.v9.cache4.c.youtube.com,5|http://v22.lscache6.c.youtube.com/videoplayback?ip=0.0.0.0&sparams=id%2Cexpire%2Cip%2Cipbits%2Citag%2Calgorithm%2Cburst%2Cfactor%2Coc%3AU0dXRlROVl9FSkNNN19MSFpB&fexp=907112%2C906402&algorithm=throttle-factor&itag=5&ipbits=0&burst=40&sver=3&expire=1281438000&key=yt1&signature=3484C904A33E8D1BA9CED9A5ABB6AC91A8FF6F43.5E91B7D7315439ED8E1BCEAEF600E5AAF3611E5F&factor=1.25&id=bd383b3d449589d2
				    [3] => tc.v22.cache6.c.youtube.com
				)

				*/

		    	if(count($fmt_arr))
		    	{
		    		foreach($fmt_arr as $fmt_url)
		    		{
		    			$url_arr = explode('|', $fmt_url);
		    			 if($coma_pos = strrpos($url_arr[0], ','))
		    			 {
		    			 	$video_format = substr($url_arr[0], $coma_pos+1);
						 }
						 else
						 {
						 	$video_format = $url_arr[0];
						 }
						 if($url_arr[1])
						 	$video_url_array[$video_format] = $url_arr[1];
					}


				}
			}
			if(isset($video_url_array[5]))
				$youtube_video_url = $video_url_array[5];
			else if(isset($video_url_array[34]))
				$youtube_video_url = $video_url_array[34];
			else if(isset($video_url_array[35]))
				$youtube_video_url = $video_url_array[35];


	        /*if ((empty($youtube_video_url)) AND isset($token))
		   	{
		   		$youtube_video_url = "http://www.youtube.com/get_video.php?video_id=$youtube_video_id&t=$token";
			}*/

			## If video embed status not allowed then, using the following code we get the video url ##
			## referSite:- http://www.longtailvideo.com/support/forum/General-Chat/19265/-Solution-Youtube-Get-Video-Part-2-
			if(empty($youtube_video_url))
			{
				/** Get information from server, for error reporting **/
				$host = $_SERVER['HTTP_HOST'];
				$user_ip = $_SERVER['REMOTE_ADDR'];

				/** Parameters **/
				parse_str(getContents("http://youtube.com/get_video_info?video_id={$youtube_video_id}"),$i);
				if($i['status'] != 'ok')
				{
					if($i['errorcode'] != '150')
						return $youtube_video_url = ''; //** #ERROR "This video is not available."
					else
					{
						//** Cache | Suggestion by @borkul
						parse_str(getContents("http://v.leefjedichter.nl/cache/?h={$host}"),$cache);
						if($cache['status'] == 'limit')
							return $youtube_video_url = ''; //** #ERROR "Please try again in a few seconds." @end Cache
						$matches = explode('\'SWF_ARGS\':', getContents("http://www.youtube.com/watch?v={$youtube_video_id}"));
							$match = explode('\'SWF_GAM_URL\'', $matches[1]);

						$matches = str_replace('", "','&',str_replace('": "','=',$match[0])); parse_str(str_replace(array('{','}'),'',$matches),$i);
					}
				}

				/** Video Format **/
				if(!isset($i['fmt_map']))
					return $youtube_video_url = ''; //** #ERROR "Video format not found."

				preg_match_all ("/(.*?),/is", $i['fmt_map'], $fmt_map);
				foreach($fmt_map[1] as $fmt_i => $fmt_value)
				{
					$fmt_value = explode('/',$fmt_value);
						if($fmt_value[0] == 34) {$fmt = 34;} else{$fmt = 6;}
				}

				/** Get Video **/
				$token = isset($i['token'])?$i['token']:'';
				$url = "http://www.youtube.com/get_video.php?video_id={$youtube_video_id}&vq=2&fmt={$fmt}&t={$token}";
				$headers = get_headers($url,1); //** Request the headers from get_video

				$HTTP = explode(' ',$headers[0]);
				parse_str(getContents("http://v.leefjedichter.nl/POST/?v={$youtube_video_id}&h={$host}&i={$user_ip}&c=".$HTTP[1]),$request); //** Post video data and youtube headers

				$video = $headers['Location'];

				if(!isset($video))  //If get headers failed
				{
					$fmt_url_map = explode(',',$i['fmt_url_map']);
					//** Get video from fmt_url_map
					$fmt_url_map = explode(',',$i['fmt_url_map']);
					foreach( $fmt_url_map as $fmt_i => $fmt_url)
					{
						$fmt_url = explode('|',$fmt_url);
						if($fmt_url[0] == 34 || $fmt_url[0] == 6) $video = $fmt_url[1]; break;
					}
					if(!isset($video))
					{
						$fmt_url = explode('|',$fmt_url_map[0]);
						$video = $fmt_url[1];//** Get the video if no formats are found.
					}
				}

				if(is_array($video)) $video = $video[0]; //** Check if the video is in an array | Suggestion by @Greg

				if(!isset($video))
					return $youtube_video_url = '';  //** #ERROR "This video is not available."

				$youtube_video_url = $video;
			}
		    return $youtube_video_url;
		}

		public function GrabYouTube($youtube_url)
		{
		   $youtube_details_arr = array(
		        'youtube_video_id' => '',
		        'title' => '',
		        'description' => '',
		        'tags' => '',
		        'error' => '',
		        );
		   // http://youtube.com/watch?v=4JiacBPZA7Y
		   $parse_value_arr = parse_url($youtube_url);
	       parse_str($parse_value_arr['query'], $youtube_url_prop);
	       $youtube_video_id = isset($youtube_url_prop['v']) ? $youtube_url_prop['v'] : '';
	       if ($youtube_video_id)
		   {
		   		$youtube_details_arr['youtube_video_id'] = $youtube_video_id;
			    //Get details using YouTube API...
			    //$youtube_xml = $this->_GetPage('http://gdata.youtube.com/feeds/api/videos/'.$youtube_video_id);

				// set video data feed URL
				$feedURL = 'http://gdata.youtube.com/feeds/api/videos/' . $youtube_video_id;

			    // read feed into SimpleXML object
			    $entry = simplexml_load_file($feedURL);

			    // parse video entry
			    $video = $this->parseVideoEntry($entry);

			    $youtube_details_arr['title'] = $video->title;

			    $youtube_details_arr['description'] = $video->description;

			    $youtube_details_arr['tags'] = '';
			    $youtube_details_arr['length'] = $video->length;

			    $youtube_details_arr['thumbnail_url'] = $video->thumbnailURL;

		   }
		   else
		   		$youtube_details_arr['error'] = 'Couldn\'t find YouTube Video ID.';
		   return $youtube_details_arr;
		}

		// function to parse a video <entry>
    	public function parseVideoEntry($entry)
		{
	    	$obj= new stdClass;

		    // get author name and feed URL
		    $obj->author = $entry->author->name;
		    $obj->authorURL = $entry->author->uri;

		    // get nodes in media: namespace for media information
		    $media = $entry->children('http://search.yahoo.com/mrss/');
		    $obj->title = $media->group->title;
		    $obj->description = $media->group->description;

		    // get video player URL
		    $attrs = $media->group->player->attributes();
		    $obj->watchURL = $attrs['url'];

		    // get video thumbnail
		    $attrs = $media->group->thumbnail[0]->attributes();
		    $obj->thumbnailURL = $attrs['url'];

		    // get <yt:duration> node for video length
		    $yt = $media->children('http://gdata.youtube.com/schemas/2007');
		    $attrs = $yt->duration->attributes();
		    $obj->length = $attrs['seconds'];

		    // get <yt:stats> node for viewer statistics
		    $yt = $entry->children('http://gdata.youtube.com/schemas/2007');
		    $attrs = $yt->statistics->attributes();
		    $obj->viewCount = $attrs['viewCount'];

		    // get <gd:rating> node for video ratings
		    $gd = $entry->children('http://schemas.google.com/g/2005');
		    if ($gd->rating)
			{
		    	$attrs = $gd->rating->attributes();
		        $obj->rating = $attrs['average'];
		    }
			else
		        $obj->rating = 0;

		    // get <gd:comments> node for video comments
		    $gd = $entry->children('http://schemas.google.com/g/2005');
		    if ($gd->comments->feedLink)
			{
		    	$attrs = $gd->comments->feedLink->attributes();
		        $obj->commentsURL = $attrs['href'];
		        $obj->commentsCount = $attrs['countHint'];
		    }

		    // get feed URL for video responses
		    $entry->registerXPathNamespace('feed', 'http://www.w3.org/2005/Atom');
		    $nodeset = $entry->xpath("feed:link[@rel='http://gdata.youtube.com/schemas/2007#video.responses']");
		    if (count($nodeset) > 0)
		    	$obj->responsesURL = $nodeset[0]['href'];


		    // get feed URL for related videos
		    $entry->registerXPathNamespace('feed', 'http://www.w3.org/2005/Atom');
		    $nodeset = $entry->xpath("feed:link[@rel='http://gdata.youtube.com/schemas/2007#video.related']");
		    if (count($nodeset) > 0)
		    	$obj->relatedURL = $nodeset[0]['href'];

		      // return object to caller
		      return $obj;
    	}

	}
/*$obj = new YoutubeGrab();
$arr = $obj->GetYouTubeVideoURL('bcxec6nE6s0');
//$arr = $obj->GetYouTubeVideoURL('j8Uht3DnbOQ');

echo '<pre>';print_r($arr);echo '</pre>';*/
?>
