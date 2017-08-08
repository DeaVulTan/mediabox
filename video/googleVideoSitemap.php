<?php

require_once('common/configs/config.inc.php');
require_once('common/configs/config_video.inc.php');
require_once('common/configs/config_video_player.inc.php');
$CFG['db']['is_use_db'] = true;
$CFG['site']['is_module_page']='video';
//compulsory
$CFG['auth']['is_authenticate'] = false;
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;

require_once($CFG['site']['project_path'].'common/application_top.inc.php');

class googleVideoSitemap extends FormHandler
{
	public function populateVideoSitemap()
	{
		$sql='SELECT video_id,user_id,video_ext,playing_time,video_title,video_caption,video_tags,allow_embed,v.date_added,video_server_url,t_width,t_height,total_views,video_category_name,video_category_type,(rating_total/rating_count) as video_rating FROM '.
		$this->CFG['db']['tbl']['video'].' as v JOIN '.$this->CFG['db']['tbl']['video_category'].' as vc ON vc.video_category_id = v.video_category_id
		WHERE video_status=\'Ok\' AND flagged_status!=\'Yes\' AND is_external_embed_video!=\'Yes\' AND 	video_access_type=\'Public\'
		Order by video_id ASC LIMIT '.$this->fields_arr['pg'].','.$this->CFG['admin']['videos']['google_sitemap_videocount'];
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array());
		if (!$rs)
			trigger_db_error($this->dbObj);
		?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
		<?php
        $video_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['video_folder'].'/';
		while($row = $rs->FetchRow())
		{

			$viewVideoPageUrl=getUrl('viewvideo','?video_id='.$row['video_id'].'&video_title='.$row['video_title'],$row['video_id'].'/'.$row['video_title'].'/','','video');
			$contentLocation=$row['video_server_url'].$video_folder.getVideoImageName($row['video_id']);
			if($this->CFG['admin']['videos']['SelectedPlayer']=='elite')
			{
				$flv_player_url= $this->CFG['site']['url'].$this->CFG['media']['folder'].'flash/video/flvPlayer/flvplayer_elite.swf';
			}
			else
			{
				$flv_player_url = $this->CFG['site']['video_url'].'embedPlayer.php?vid='.mvFileRayzz($row['video_id']).'';
			}
			$arguments_play = 'pg=video_'.$row['video_id'].'_no_'.getRefererForAffiliate();

			if($this->CFG['admin']['videos']['SelectedPlayer']=='elite')
			{
				$flv_player_url_embed= $this->CFG['site']['url'].$this->CFG['media']['folder'].'flash/video/flvPlayer/flvplayer_elite.swf';
			}
			else
			{
				$flv_player_url_embed= $this->CFG['site']['video_url'].'embedPlayer.php?vid='.mvFileRayzz($row['video_id']).'';
			}
			if($this->CFG['admin']['videos']['SelectedPlayer']=='elite')
			{
				$configXmlcode_url = $this->CFG['site']['video_url'].'elite_videoConfigXmlCode.php?';
			}
			else
			{
				$configXmlcode_url = $this->CFG['site']['video_url'].'videoConfigXmlCode.php?';
			}
			//$arguments_embed = 'pg=video_'.$this->fields_arr['video_id'].'_no_0_extsite';
			$playerUrl=$flv_player_url.'?config='.$configXmlcode_url.$arguments_play;

			$thumb_folder 	= $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['videos']['folder'] . '/' . $this->CFG['admin']['videos']['thumbnail_folder'] . '/';
			$thumbnail		= $row['video_server_url'] . $thumb_folder . getVideoImageName($row['video_id']) . $this->CFG['admin']['videos']['thumb_name'] . '.' . $this->CFG['video']['image']['extensions'];
			$tag_arr		= explode(" ",$row['video_tags']);
			$play_time_arr	= explode(":",$row['playing_time']);

			if(sizeof($play_time_arr==2))
			{
				$hr=0;
				$min=$play_time_arr[0];
				$sec=$play_time_arr[1];

			}
			else if(sizeof($play_time_arr==3))
			{
				$hr=$play_time_arr[0];
				$min=$play_time_arr[1];
				$sec=$play_time_arr[2];
			}

			$hrToSec	= $hr*60*60;
			$minToSec	= $min*60;
			$sec		= $hrToSec+$minToSec+$sec;

			$family_friendly = ($row['video_category_type']=='General')?'Yes':'No';
			list($date,$time)=explode(' ',$row['date_added']);
			list($year,$month,$day)=explode("-",$date);
			list($hr,$min,$sec)=explode(':',$time);
			$addedDate=Date( 'c',mktime($hr,$min,$sec,$month,$day,$year));
			?><url>
 			<loc><?php echo $viewVideoPageUrl;?></loc>
    			<video:video>
    			<video:content_loc><?php echo $contentLocation;?></video:content_loc>
      			<video:player_loc allow_embed="<?php echo $row['allow_embed'];?>"><?echo $playerUrl;?></video:player_loc>
      			<video:thumbnail_loc><?php echo $thumbnail;?></video:thumbnail_loc>
      			<video:title><?php echo $row['video_title'];?><</video:title>
      			<video:description><?php echo $row['video_caption'];?></video:description>
      			<video:rating><?php echo $row['video_rating'];?></video:rating>
      			<video:view_count><?php echo $row['total_views'];?></video:view_count>
      			<video:publication_date><?php echo $addedDate;?>.</video:publication_date>
      			<?php
      			foreach($tag_arr as $tag)
      			{?><video:tag><?php echo $tag;?></video:tag><?php }?><video:category><?php echo $row['video_category_name'];?></video:category>
      			<video:family_friendly><?php echo $family_friendly;?></video:family_friendly>
      			<video:duration><?php echo $sec;?></video:duration>
    			</video:video>
		</url>
		<?php }?>

</urlset>
			<?php
		}

}
$sitemap= new googleVideoSitemap();
$sitemap->setDBObject($db);
$sitemap->makeGlobalize($CFG,$LANG);
$sitemap->setFormField('pg','0');
$sitemap->sanitizeFormInputs($_REQUEST);
if($sitemap->getFormField('pg')>0)
{
	$lowerLimit=$sitemap->getFormField*('pg') * $CFG['admin']['videos']['google_sitemap_videocount'];
	$sitemap->setFormField('pg',$lowerLimit);
}
$sitemap->populateVideoSitemap();
?>


