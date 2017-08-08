<?php

/**
 *
 *
 * @version $Id$
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 */

class EncodeHandler extends FormHandler
{

	public $mencoder_command='';
	public $encode_via_cron='';
	public $video_id='';
	public $encode_id='';

	public function getEncodeCommand($video_id)
	{
		if($video_id)
		{
		$sql 	=	'SELECT video_server_url,video_ext FROM '.$this->CFG['db']['tbl']['video'].' WHERE video_id='.$this->dbObj->Param('video_id').' AND video_flv_url=\'\' AND video_status=\'Ok\'';
		$stmt 	= 	$this->dbObj->Prepare($sql);
		$rs		= 	$this->dbObj->Execute($stmt, array($video_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			if(!$rs->PO_RecordCount())
			{
				return false;
			}
		$row 	= $rs->FetchRow();
		$video_name		=	getVideoName($video_id);
		$video_folder 	= 	$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['video_folder'].'/';
		$input_video 	=	$row['video_server_url'].$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['original_video_folder'].'/'.$video_name.'.'.$row['video_ext'];
		$output_video	=	$this->media_relative_path.$video_folder.$video_name.'.flv';

		}
		else
		{
		$input_video	='';
		$output_video	='';
		}

		$strBframes		='';

		if($this->CFG['admin']['upload_video_use_b_frames'])
		{
			$strBframes	=' -lavfopts i_certify_that_my_video_stream_does_not_use_b_frames';
		}

		$audio_codec 	= ($this->CFG['admin']['video']['oac_lame']) ? ' -oac mp3lame ': ' -oac lavc ';

		$this->setFormField('mencoder_path', ('"'.$this->CFG['admin']['video']['mencoder_path'].'"'));
		$this->setFormField('input_video',$input_video);
		$this->setFormField('encode_hide_1','-o');
		$this->setFormField('output_video',$output_video);
		$this->setFormField('extra_command','');
		$this->setFormField('encode_hide_2','-of lavf -ovc lavc');
		$this->setFormField('audio_codec',$audio_codec);
		$this->setFormField('encode_hide_3','-lavcopts vcodec=flv:vbitrate=');
		$this->setFormField('vbitrate',$this->CFG['admin']['video']['vbitrate']);
		if($this->CFG['admin']['video']['vfscale'] != '')
			$this->setFormField('encode_hide_4',':autoaspect:mbd=2:mv0:trell:v4mv:cbp:last_pred=3:predia=2:dia=2:precmp=2:cmp=2:subcmp=2:preme=2:turbo:acodec=mp3:abitrate=56 -vf scale=');
		else
			$this->setFormField('encode_hide_4',':autoaspect:mbd=2:mv0:trell:v4mv:cbp:last_pred=3:predia=2:dia=2:precmp=2:cmp=2:subcmp=2:preme=2:turbo:acodec=mp3:abitrate=56');
		$this->setFormField('vfscale',$this->CFG['admin']['video']['vfscale']);
		$this->setFormField('encode_hide_5','-srate');
		$this->setFormField('srate',$this->CFG['admin']['video']['srate']);
		$this->setFormField('encode_hide_6','-af lavcresample=');
		$this->setFormField('lavcresample',$this->CFG['admin']['video']['lavcresample']);
		$this->setFormField('strBframes',$strBframes);
		$this->setFormField('add_to_cron','No');
		return true;
	}
	public function formEncodeCommand()
	{
		$mencoder_path		=stripslashes($this->fields_arr['mencoder_path']);
		$input_video		=$this->fields_arr['input_video'];
		$encode_hide_1		=$this->fields_arr['encode_hide_1'];
		$output_video		=$this->fields_arr['output_video'];
		$extra_command		=$this->fields_arr['extra_command'];
		$encode_hide_2		=$this->fields_arr['encode_hide_2'];
		$audio_codec		=$this->fields_arr['audio_codec'];
		$encode_hide_3		=$this->fields_arr['encode_hide_3'];
		$vbitrate			=$this->fields_arr['vbitrate'];
		$encode_hide_4		=$this->fields_arr['encode_hide_4'];
		$vfscale			=$this->fields_arr['vfscale'];
		$encode_hide_5		=$this->fields_arr['encode_hide_5'];
		$srate				=$this->fields_arr['srate'];
		$encode_hide_6		=$this->fields_arr['encode_hide_6'];
		$lavcresample		=$this->fields_arr['lavcresample'];
		$strBframes			=$this->fields_arr['strBframes'];

		$this->mencoder_command =$mencoder_path.' '.$input_video.' '.$encode_hide_1.' '.$output_video;
		if($extra_command)
		{
			$this->mencoder_command.=' '.$extra_command;
		}
		if ($this->CFG['admin']['videos']['allow_watermark_in_video'])
		{
				$path = $this->CFG['site']['project_path'].'files/watermark/wmark.srt';
				$path1 = $this->CFG['site']['project_path'].'common/gd_fonts/arial.ttf';
				$waterMarkFileContent="1 \n".$this->CFG['admin']['videos']['watermark_start_time'].',000'.' --> '.$this->CFG['admin']['videos']['watermark_end_time'].',000'."\n".$this->CFG['admin']['videos']['watermark_text'];

				$fp = fopen($path, 'w');
				fwrite($fp, $waterMarkFileContent);
				fclose($fp);
				$waterMarkCommand=" -sub $path -subpos 98 -font $path1";

				$this->mencoder_command .=$waterMarkCommand;
		}
		$this->mencoder_command.=' '.$encode_hide_2.' '.$audio_codec.' '.$encode_hide_3.$vbitrate.$encode_hide_4.$vfscale.' '.$encode_hide_5.' '.$srate.' '.$encode_hide_6.$lavcresample.' '.$strBframes;
	}

	public function selectEncodeCron($encode_id='',$video_id='')
	{

		if($video_id)
			$condition='video_id=\''.$video_id.'\'';
		else if($encode_id)
			$condition='video_id=\''.$encode_id.'\'';
		else
			$condition='encode_via_cron=\'Yes\' AND encode_status!=\'Yes\'';

		$sql='SELECT * FROM '.$this->CFG['db']['tbl']['reencode_video'].' WHERE '.$condition.' LIMIT 0,1';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array());
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		return $rs;

	}

	public function insertEncodeCron($video_id)
	{
		$encode_count=0;
		$add_query = '';
		if($video_id)
		{
			$rs = $this->selectEncodeCron('',$video_id);
			$encode_count=$rs->PO_RecordCount();
		}
		if($this->fields_arr['move'] && isset($this->fields_arr['move']))
			{
				$add_query =' ,move=\'Yes\'';

			}


		if(!$encode_count)
		{
			$sql_ins ='INSERT INTO '.$this->CFG['db']['tbl']['reencode_video'].' SET encode_command='.$this->dbObj->Param('encode_command').' ,video_id='.$this->dbObj->Param('video_id').',encode_via_cron='.$this->dbObj->Param('encode_via_cron').', encode_added_date=NOW(), encode_status=\'No\''.$add_query;
			$stmt = $this->dbObj->Prepare($sql_ins);
			$rs = $this->dbObj->Execute($stmt, array($this->mencoder_command,$video_id,$_POST['add_to_cron']));
			$this->encode_id=$this->dbObj->Insert_ID();
		}
		else
		{
			$row = $rs->FetchRow();
			$sql_ins ='UPDATE '.$this->CFG['db']['tbl']['reencode_video'].' SET encode_command='.$this->dbObj->Param('encode_command').' ,  	encode_added_date=NOW(), encode_status=\'No\',encode_via_cron='.$this->dbObj->Param('encode_via_cron').' WHERE encode_id='.$this->dbObj->Param('encode_id');
			$stmt = $this->dbObj->Prepare($sql_ins);
			$rs = $this->dbObj->Execute($stmt, array($this->mencoder_command,$_POST['add_to_cron'],$row['encode_id']));
		}

		if (!$rs)
		trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);


	}

	public function changeVideoStatus($video_id,$status,$encode_status)
	{
		$sql_upd ='UPDATE '.$this->CFG['db']['tbl']['video'].' SET video_status='.$this->dbObj->Param('video_status').' , video_encoded_status='.$this->dbObj->Param('video_encode_status').' WHERE video_id='.$this->dbObj->Param('video_id');
		$stmt = $this->dbObj->Prepare($sql_upd);
		$rs = $this->dbObj->Execute($stmt, array($status,$encode_status,$video_id));
		if (!$rs)
		trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
	}

	public function videoencode($encode_command,$output,$move=false)
	{
		$encode_command=str_replace('&quot;','"',$encode_command);

		$log_str = 'cALLING MENCODER FOR FLV CONVERSION:'."\r\n";
		$log_str .= $encode_command;

		$result=exec($encode_command, $p);

		if(count($p))
		{
			foreach($p as $key=>$val)
			$log_str .= $key.': '.$val."\n\r";
		}
		if ($this->CFG['admin']['log_video_upload_error'])
		{
			$this->createErrorLogFile();
			$this->writetoTempFile($log_str);
		}
		if(isset($this->video_id) && $this->video_id)
			{
				$this->fields_arr['video_id'] = $this->video_id;

			}
		if(isset($this->fields_arr['video_id']) && $this->fields_arr['video_id'])
		{
			$this->changeVideoStatus($this->fields_arr['video_id'],'Ok','Yes');

			if($move)
				{

					if($this->getServerDetails())
						{

							$video_exten =$this->getVideoExten($this->video_id);
							$video_name =getVideoName($this->video_id);
							$orig_video_name = $video_name.'.'.$video_exten;
							$video_name		=$video_name.'.flv';
							$destination_file = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['video_folder'].'/'.$video_name;
							$source_file 	  = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['video_folder'].'/'.$video_name;
							if($FtpObj = new FtpHandler($this->FTP_SERVER,$this->FTP_USERNAME,$this->FTP_PASSWORD))
							{
								if($this->FTP_FOLDER)
								{
									if($FtpObj->changeDirectory($this->FTP_FOLDER))
									{

									 	if($FtpObj->moveTo($source_file,$destination_file));
									 	{
									 		unlink($source_file);
										 }
									}
								}
							}
						}

				}
		}
		if($this->encode_via_cron)
				$this->changeEncodeStatus($this->encode_id,'Yes');
			else
				$this->changeEncodeStatus($this->encode_id);

		if($output)
		{
			return nl2br($log_str);

		}


	}
	public function createErrorLogFile()
	{
		$temp_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/temp_log'.'/';
		$this->chkAndCreateFolder($temp_dir);
		$temp_file_path = $temp_dir.$this->CFG['user']['user_id'].'encode_cron'.'.txt';
		$this->fp = fopen($temp_file_path, 'w');
		$this->writePHPSettings();
	}
	public function writePHPSettings()
		{
			$log_str  = date("F j, Y, g:i a")."\r\n";
			$log_str .= 'Memory Limit : '.(string)ini_get('memmory_limit')."\r\n";
			$log_str .= 'Max execution time : '.(string)ini_get('max_execution_time')."\r\n";
			$log_str .= 'max Input TIme : '.(string)ini_get('max_input_time')."\r\n";
			$log_str .= 'Post Max Size : '.(string)ini_get('post_max_size')."\r\n";
			$log_str .= 'Upload Max size : '.(string)ini_get('upload_max_filesize')."\r\n";
			$this->writetoTempFile($log_str);
		}
	public function writetoTempFile($video_upload_str)
		{
			if($this->fp)
				fwrite($this->fp, $video_upload_str);
		}
	public function closeErrorLogFile()
		{
			if ($this->fp)
			{
				fclose($this->fp);
			}
		}

	public function changeEncodeStatus($encode_id,$via_cron='')
	{
		if($via_cron)
		{
			$update_field=', encode_via_cron=\''.$via_cron.'\'';
		}
		else
			$update_field='';

		$sql ='UPDATE '.$this->CFG['db']['tbl']['reencode_video'].' SET encode_status=\'Yes\''.$update_field.' WHERE encode_id=\''.$encode_id.'\'';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array());
		if (!$rs)
		trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		//$row = $rs->FetchRow();
	}
		/**
		 * VideoUpload::getServerDetails()
		 *
		 * @return
		 **/
		public function getServerDetails()
			{
				// $cid = $this->VIDEO_CATEGORY_ID.',0';
				$sql = 'SELECT server_url, ftp_server, ftp_folder, category, ftp_usrename, ftp_password FROM'.
						' '.$this->CFG['db']['tbl']['server_settings'].
						' WHERE server_for=\'video\' '.
						' AND server_status=\'Yes\' LIMIT 0,1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if(!$rs->PO_RecordCount())
					return false;

				while($row = $rs->FetchRow())
					{
						$this->FTP_SERVER = $row['ftp_server'];
						$this->FTP_FOLDER = $row['ftp_folder'];
						$this->FTP_USERNAME = html_entity_decode($row['ftp_usrename']);
						$this->FTP_PASSWORD = html_entity_decode($row['ftp_password']);
						$this->FTP_SERVER_URL = $row['server_url'];


					}
				if(isset($this->FTP_SERVER) and $this->FTP_SERVER)
					return true;
				return false;
			}
	public function getVideoExten($video_id)
		{

			$sql 	=	'SELECT video_ext FROM '.$this->CFG['db']['tbl']['video'].' WHERE video_id='.$this->dbObj->Param('video_id');
			$stmt 	= 	$this->dbObj->Prepare($sql);
			$rs		= 	$this->dbObj->Execute($stmt, array($video_id));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			$row 	= $rs->FetchRow();
			return $row['video_ext'];
		}

	public function setMediaPath($path='../../')
			{
				$this->media_relative_path = $path;
			}
}
?>
