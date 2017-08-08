<?php
$ref = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
if($CFG['admin']['videos']['SelectedPlayer']=='premium')
{
	$player=$CFG['site']['url'].$CFG['media']['folder'].'/flash/video/flvplayers/'.$CFG['admin']['videos']['premium_player']['swf_name'].'.swf';
}
else if ($CFG['admin']['videos']['SelectedPlayer']=='elite') {
	$player= $CFG['site']['url'].$CFG['media']['folder'].'/flash/video/flvplayers/'.$CFG['admin']['videos']['elite_player']['swf_name'].'.swf';

}
$video_id =(isset($_GET['vid']))?$_GET['vid']:'';
$video_id_arr = explode('_', $video_id);

$video_id_enc = $video_id_arr[0];
$video_id = $video_id_arr[1];

$config=(isset($_GET['embedded_config']))?$_GET['embedded_config']:'';
if($config)
$config='&embedded_config='.$config;

if(isset($_GET['player']) and $_GET['player'] and $_GET['player']=='miniplayer')
	$player=$CFG['site']['url'].$CFG['media']['folder'].'/flash/video/flvplayers/'.$CFG['admin']['videos']['mini_player']['swf_name'].'.swf';

class EmbedPlayer extends FormHandler
	{
		public function updateCampaignRender($embed_info_arr)
			{

				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['video_render'].
						' WHERE video_id='.$this->dbObj->Param('video_id').
						' AND referer_render='.$this->dbObj->Param('ref');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($embed_info_arr['video_id'],$embed_info_arr['ref']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if(!$rs->PO_RecordCount())
					{
						$sql2 = 'INSERT INTO '.$this->CFG['db']['tbl']['video_render'].
								' SET video_id='.$this->dbObj->Param('video_id2').','.
								' referer_render='.$this->dbObj->Param('ref2').','.
								' clicked_video=\'No\','.
								' date_time_render=Now()';

						$stmt2 = $this->dbObj->Prepare($sql2);
						$rs2 = $this->dbObj->Execute($stmt2, array($embed_info_arr['video_id'],$embed_info_arr['ref']));
						if (!$rs2)
					    	trigger_db_error($this->dbObj);
					}
			}
	}

if($video_details_arr=validVideoIdRevised($video_id) and mvFileRayzz($video_id)==$video_id_enc)
	{

		$embedPlayer = new EmbedPlayer();
		if(!empty($ref) and !strstr($ref, $CFG['site']['url']))
			{
				$embed_info_arr['ref'] = $ref;
				$embed_info_arr['video_id'] = $video_id;
				$embedPlayer->updateCampaignRender($embed_info_arr);
			}


//		$video_details_arr['flv_upload_type']='Youtube';
//		$video_details_arr['video_flv_url']='www.youtube.com/get_video?video_id=232323';
		if(isset($CFG['admin']['videos']['check_url_exists_for_videos_when_plays']) and $CFG['admin']['videos']['check_url_exists_for_videos_when_plays'])
			{
				$video_url='';
				$video_folder = $CFG['media']['folder'].'/'.$CFG['admin']['videos']['folder'].'/'.$CFG['admin']['videos']['video_folder'].'/';
				$err_valid_video=false;
				if($video_details_arr['flv_upload_type']!='Normal' and $video_details_arr['video_flv_url'])
				{
					if(strpos($video_details_arr['video_flv_url'], 'youtube.com/get_video') and strpos($video_details_arr['video_flv_url'], 'video_id'))
					{
						//Youtube video
						$video_id=@getYouTubeVideoIDFromUrl($video_details_arr['video_flv_url']);
						$youtube_url = 'http://youtube.com/watch?v='.$video_id;
						$youtubeObj = new YoutubeGrab();
						if($youtube_details_arr = $youtubeObj->GrabYouTube($youtube_url))
							if(!$url = $youtubeObj->GetYouTubeVideoURL($youtube_details_arr['youtube_video_id']))
								$err_valid_video='youtube';
					}
					elseif(strpos($video_details_arr['video_flv_url'], 'google.'))
						{
							//google
							$video_url=$video_details_arr['video_flv_url'];
							if(!fileGetContentsManual($video_url, true))//For checking is valid URL
								$err_valid_video='google';
						}
						else
							{
								$video_url=$video_details_arr['video_flv_url'];
								if(!fileGetContentsManual($video_url, true))//For checking is valid URL
									$err_valid_video='external';
							}
				}
				else
					{
						$video_url = $video_details_arr['video_server_url'].$video_folder.getHotLinkProtectionString().getVideoImageName($video_details_arr['video_id']).'.flv';
						if(!$valid_video=fileGetContentsManual($video_url, true))//For checking is valid URL for normal videos
								$err_valid_video='normal';
		//				echo '$valid_video'.$valid_video;
		//				exit;
					}

				if($err_valid_video)
					Redirect2URL($CFG['site']['url'].'videoNotValidImageGenerate.php?get_image='.$err_valid_video);
			}
		if($video_details_arr['allow_embed']=='Yes' and $CFG['admin']['videos']['embedable'])
			Redirect2URL($player.'?ref='.$ref.$config);
			elseif(!$ref or strpos($ref,$CFG['site']['url'])!==false)
				Redirect2URL($player.'?ref='.$ref.$config);
				else
					{
						Redirect2URL($CFG['site']['url'].'files/flash/video/bg-videoblock.gif');
?>
						<p>
						EMBED NOT ALLOWED
						<script language="javascript">
							alert('EMBED NOT ALLOWED');
						</script>
						</p>
<?php
					}
	}
else
	{
		Redirect2URL($CFG['site']['url'].'files/flash/video/bg-videodeleted.gif');
?>
						<p>
						Invalid video id
						<script language="javascript">
							alert('Video does not exist');
						</script>
						</p>
<?php
					}

?>
