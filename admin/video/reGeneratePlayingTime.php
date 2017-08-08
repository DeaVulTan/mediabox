<?php

require_once('../../common/configs/config.inc.php');
require_once('../../common/configs/config_video.inc.php');
$CFG['mods']['include_files'][] = 'common/classes/class_EncodeHandler.lib.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/admin/reGeneratePlayingTime.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['site']['is_module_page'] = 'video';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;

require_once($CFG['site']['project_path'].'common/application_top.inc.php');

class playingTime extends EncodeHandler
{
	public $result = array();
	public $error  = array();
	public function getVideoDetail()
	{
		if(!$this->video_from)
			$sql ='SELECT video_id,video_server_url FROM '.$this->CFG['db']['tbl']['video'].' WHERE video_id='.$this->dbObj->Param('vide_id') .' AND video_status=\'Ok\'';
		else
			$sql ='SELECT video_id,video_server_url FROM '.$this->CFG['db']['tbl']['video'].' WHERE video_id>='.$this->dbObj->Param('vide_id').' AND video_id<='.$this->dbObj->Param('video_id').' AND video_status=\'Ok\'';
		$stmt = $this->dbObj->Prepare($sql);
		if(!$this->video_from)
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
		else
				$rs = $this->dbObj->Execute($stmt, array($this->video_from,$this->video_to));
		if($rs->PO_RecordCount())
		{
			while($row = $rs->FetchRow())
			{
				$this->videoId_arr[]=$row['video_id'];
				$this->videoDetail[$row['video_id']]['video_server_url']=$row['video_server_url'];
			}
			return true;
		}
		else
		{
			return false;
		}
	}
	public function generatePlayingTime()
	{
		$video_folder 	= 	$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['video_folder'].'/';
		foreach($this->videoId_arr as $videoId)
		{
				## CHECKING THE FILE IS UPLOADED IN CURRENT SERVER OR IN DIFFERENT SERVER
				$unlink=false;
				$url = parse_url($this->videoDetail[$videoId]['video_server_url']);

				if($url['host']==$_SERVER['SERVER_NAME'])
				{
					$download_path=$this->media_relative_path.$video_folder.getVideoName($videoId).'.flv';
				}
				else
				{
					if($this->getServerDetails())
					{
							$video_name		=	getVideoName($videoId).'.flv';

							$ftp_path 	= 	'/'.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['video_folder'].'/'.$video_name;
							$download_path 	= 	$this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin']['videos']['temp_folder'].'/'.$video_name;
							$unlink=true;

							if($FtpObj = new FtpHandler($this->FTP_SERVER,$this->FTP_USERNAME,$this->FTP_PASSWORD))
								{
									if($this->FTP_FOLDER)
									{
										if($FtpObj->changeDirectory($this->FTP_FOLDER))
										{
										 if(!$FtpObj->ftpGet($this->FTP_FOLDER.$ftp_path,$download_path))
											{
												$download_path='';
												$this->error[]=$this->LANG['unable_to_download'].$ftp_path;
											}
										}
									}
								}
								else
								{
								$this->error[] = $this->LANG['no_ftp_connection'];
								return false;
								}

					}
					else
					{
						$this->error[] = $this->LANG['no_server_detail'];
						return false;
					}
				}
				if($download_path)
				{
					if(!file_exists($download_path))
					{
						$this->error[]=$this->LANG['no_flv_file'].$videoId;

					}
					else
					{
					//exec($this->CFG['admin']['video']['mplayer_path'].' -vo null -ao null -frames 0 -identify '.$vdoname, $p);
					exec("\"".$this->CFG['admin']['video']['flvtool2_path']."\" -UP ". $download_path,$p);
					while(list($k,$v)=each($p))
					{
					if($length=strstr($v,'duration: '))
					        break;
					    }

					$lx = explode(":",$length);
					$duration = $lx[1];
					$min = floor($duration/60);
					$sec = floor($duration-($min*60));
					$hr = "00";
					if($min >= 60)
						{
						  $hr =  floor($min/60);
						  $min = floor($min-($hr*60));
						}
					$hr = str_pad($hr, 2, '0', STR_PAD_LEFT);
					$min = str_pad($min, 2, '0', STR_PAD_LEFT);
					$sec = str_pad($sec, 2, '0', STR_PAD_LEFT);

					$playing_time = $hr.':'.$min.':'.$sec;
					$this->result[]="video id=>$videoId --- Playing time=>".$playing_time;
					$this->updatePlayingTime($playing_time,$videoId);
					if($unlink)
						@unlink($download_path);
					}
				}
		}

		return true;

	}

	public function updatePlayingTime($playingTime,$video_id)
	{
		$sql='UPDATE '.$this->CFG['db']['tbl']['video'].' SET playing_time='.$this->dbObj->Param('playing_time').' WHERE video_id='.$this->dbObj->Param('video_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($playingTime,$video_id));
		if (!$rs)
			trigger_db_error($this->dbObj);

	}
}
$obj = new playingTime();
$obj->setDBObject($db);
$obj->makeGlobalize($CFG,$LANG);
$obj->setFormField('video_id','');
$obj->sanitizeFormInputs($_REQUEST);
$obj->setMediaPath('../../');
$obj->setPageBlockNames(array('block_msg_form_error', 'block_msg_form_success'));
if($obj->getFormField('video_id'))
{
	if($CFG['admin']['is_demo_site'])
			{
				$obj->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
				$obj->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				$video_range=explode('-',$obj->getFormField('video_id'));
				$obj->video_from='';
				$obj->video_to='';
				if(sizeof($video_range)>1)
					{
						$obj->video_from=$video_range[0];
						$obj->video_to=$video_range[1];
					}
				if($obj->getVideoDetail())
					{
						if($obj->generatePlayingTime())
							{
								$obj->setCommonSuccessMsg($LANG['playing_time_success']);
								$obj->setPageBlockShow('block_msg_form_success');
							}
						else
							{
								$obj->setCommonErrorMsg($LANG['playing_time_error']);
								$obj->setPageBlockShow('block_msg_form_error');
							}
					}
				else
					{
						$obj->setCommonErrorMsg($LANG['playing_time_error']);
							$obj->setPageBlockShow('block_msg_form_error');

					}
			}
}
$obj->left_navigation_div = 'videoMain';
$obj->includeHeader();
?>
<h2><?php echo $LANG['regenerate_title'];?></h2>
<?php
if($obj->isShowPageBlock('block_msg_form_success'))
{?>
	<div id="selMsgError">
	    <p><?php echo $obj->getCommonSuccessMsg();?></p>
	</div>
<?}
if($obj->isShowPageBlock('block_msg_form_error'))
{?>
<div id="selMsgError">
	    <p><?php echo $obj->getCommonErrorMsg();?></p>
	</div>
<?php }?>

<div>
<form id="reGeneratePlayingTimeFrm" name="reGeneratePlayingTimeFrm" action="<?php echo $obj->getCurrentUrl(false);?>" method="post">
<table class="clsNoBorder">
<tr>
	<td><label>Video Id</label>&nbsp;&nbsp;<input class="clsTextBox" type="text" name="video_id" value=""> &nbsp;&nbsp;&nbsp;&nbsp;( You can also enter the Video range eg: 1-10 )</td>
</tr>
<tr>
	<td>
		<input class="clsSubmitButton" type="submit" value="submit">
	</td>
</tr>
</table>
</form>
</div>

<?if($obj->result)
{
$display=implode('<br>',$obj->result);
echo "<h3>Output</h3>";
echo $display.'<br>';

}
if($obj->error)
{
$display=implode('<br>',$obj->error);
echo "<h3>error</h3>";
echo $display.'<br>';
}
?>


<?php
/* Added code to validate mandataory fields in video defaut settings page */
if ($CFG['feature']['jquery_validation'])
{
?>
<script type="text/javascript">
$Jq("#reGeneratePlayingTimeFrm").validate({
	rules: {
	    video_id: {
	    	number: true
		 }
	},
	messages: {
		video_id: {
			number: LANG_JS_NUMBER
		}
	}
});
</script>
<?php
}
$obj->includeFooter();
?>