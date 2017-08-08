<?php
/**
 *
 *
 * @version $Id$
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 */
require_once('../../common/configs/config.inc.php');
require_once('../../common/configs/config_video.inc.php');
require_once('../../common/configs/config_encoder_command.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/admin/videoReEncode.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoUpload.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_EncodeHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['site']['is_module_page'] = 'video';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
Class reEncode extends EncodeHandler
	{
		/**
		 * reEncode::checkValidData()
		 *
		 * @return
		 */
		public function checkValidData()
			{
				$this->chkIsNotEmpty('input_video',$this->LANG['err_tip_compulsory']);
				$this->chkIsNotEmpty('output_video',$this->LANG['err_tip_compulsory']);
				$this->chkIsNotEmpty('audio_codec',$this->LANG['err_tip_compulsory']);
				$this->chkIsNotEmpty('vbitrate',$this->LANG['err_tip_compulsory']);
				$this->chkIsNotEmpty('srate',$this->LANG['err_tip_compulsory']);
				$this->chkIsNotEmpty('lavcresample',$this->LANG['err_tip_compulsory']);
				$this->chkHostName('output_video',$this->LANG['err_tip_no_external_host']);
				$this->chkHostName('input_video',$this->LANG['err_tip_no_external_host']);
				if(!file_exists($this->fields_arr['input_video']))
				{
					$this->fields_err_tip_arr['input_video'] = $this->LANG['err_tip_no_sourcefile'];
				}
				if(!$this->isValidFormInputs())
					{
							$this->setPageBlockShow('show_command');
							$this->setCommonErrorMsg($this->LANG['msg_error_sorry']);
							$this->setPageBlockShow('block_msg_form_error');
							return false;
					}
				return true;
			}

		/**
		 * reEncode::chkHostName()
		 *
		 * @param mixed $field_name
		 * @param mixed $err_tip
		 * @return
		 */
		public function chkHostName($field_name,$err_tip)
			{
				$url = parse_url($_POST[$field_name]);
				if(isset($url['host']))
					{
						$chkurl = $url['host'];
						$host=$_SERVER["HTTP_HOST"];

						if($chkurl == $host)
							{
								$this->fields_arr['move']=false;
								$this->fields_arr[$field_name] = str_replace($this->CFG['site']['url'],$this->media_relative_path,$this->fields_arr[$field_name]);
								return true;
							}
						else
							{

								if($this->getServerDetails())
									{
										$this->fields_arr['move']=false;
										$video_exten =$this->getVideoExten($this->video_id);
										$video_name		=	getVideoName($this->video_id);
										$ftp_path 	= 	'/'.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['original_video_folder'].'/'.$video_name.'.'.$video_exten;
										$download_path 	= 	$this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin']['videos']['temp_folder'].'/'.$video_name.'.'.$video_exten;
										if($FtpObj = new FtpHandler($this->FTP_SERVER,$this->FTP_USERNAME,$this->FTP_PASSWORD))
											{
												if($this->FTP_FOLDER)
													$FtpObj->changeDirectory($this->FTP_FOLDER);

												// if($FtpObj->copyFrom($download_path,$ftp_path))
												 if($FtpObj->ftpGet($this->FTP_FOLDER.$ftp_path,$download_path))
													{
														$this->fields_arr['input_video'] =$download_path;
														$this->fields_arr['move']=true;
														return true;
													}
												else
													{
														$this->fields_err_tip_arr[$field_name] = $err_tip;
														return false;
													}
											}
											$this->fields_err_tip_arr[$field_name] = $err_tip;
											return false;
									}
							}
					}
				return true;
			}

		/**
		 * reEncode::chkValidExternalUrl()
		 *
		 * @return
		 */
		public function chkValidExternalUrl($video_id)
			{
				$sql = 'SELECT form_upload_type, external_site_video_url FROM '.$this->CFG['db']['tbl']['video']. ' WHERE video_id =\''.$video_id.'\' AND is_external_embed_video = \'No\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$row = $rs->FetchRow();
				if($row['form_upload_type']=='externalsitevideourl')
					{
						require_once($this->CFG['site']['project_path'].'common/classes/class_ExternalVideoUrlHandler.lib.php');
						$extHandler=new ExternalVideoUrlHandler();
						$checkUrl=$extHandler->chkIsValidExternalSite($row['external_site_video_url'],'',$this->CFG);
						if($checkUrl['external_site']=='youtube')
							{
								if(!$this->CFG['admin']['videos']['download_youtube_videos'])
									return false;
							}
						else if($checkUrl['external_site']=='google')
							{
								if(!$this->CFG['admin']['videos']['download_google_videos'])
									return false;
							}
						else if($checkUrl['external_site']=='dailymotion')
							{
								if(!$this->CFG['admin']['videos']['download_dailymotion_videos'])
									return false;
							}
						else if($checkUrl['external_site']=='myspace')
							{
								if(!$this->CFG['admin']['videos']['download_myspace_videos'])
									return false;
							}
						else if($checkUrl['external_site']=='flvpath')
							{
								if(!$this->CFG['admin']['videos']['download_flvpath_videos'])
									return false;
							}
						return true;
					}
				return true;
			}

		/**
		 * reEncode::chkValidVideo()
		 *
		 * @param mixed $video_id
		 * @return
		 */
		public function chkValidVideo($video_id)
			{
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['video']. ' WHERE video_id =\''.$video_id.'\' AND is_external_embed_video = \'No\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$row = $rs->FetchRow();
				if( $row > 0)
					return true;
				else
					return false;
			}
	}
$obj = new reEncode();
$obj->video_id='';
if($obj->isFormGETed($_GET,'video_id'))
	{
		$obj->video_id=$_GET['video_id'];
	}

$obj->setPageBlockNames(array('show_output', 'show_command', 'msg_delete_success', 'msg_edit_success','list_video_form','set_flag'));

$obj->setAllPageBlocksHide();
$obj->setMediaPath('../../');
$obj->setFormField('move',false);
$obj->setPageBlockShow('show_command');
if(!$obj->getEncodeCommand($obj->video_id))
{
		$obj->setAllPageBlocksHide();
		$obj->setCommonErrorMsg($LANG['videoRencode_invalide_video_id']);
		$obj->setPageBlockShow('block_msg_form_error');
}
if($obj->isFormPOSTed($_POST,'submit'))
	{
		if($CFG['admin']['is_demo_site'])
			{
				$obj->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
				$obj->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				//$obj->setPageBlockHide('show_command');
				$obj->sanitizeFormInputs($_POST);
				$obj->video_id=$_POST['video_id'];
				if($obj->checkValidData())
					{
						$obj->formEncodeCommand();

						$obj->insertEncodeCron($_POST['video_id']);
						if($_POST['video_id'])
							{
								$obj->changeVideoStatus($_POST['video_id'],'Locked','No');
							}
						if($_POST['add_to_cron']=='Yes')
							{
								$obj->setPageBlockShow('show_command');
								$obj->setCommonSuccessMsg($LANG['msg_encode_cron_success']);
								$obj->setPageBlockShow('block_msg_form_success');
							}
						else
							{
								$obj->output=$obj->videoEncode($obj->mencoder_command,true,$obj->getFormField('move'));
								$obj->setPageBlockShow('show_output');
							}
					}
			}
	}
$obj->left_navigation_div = 'videoMain';
$obj->includeHeader();
if ($obj->isShowPageBlock('show_command'))
	{
?>
<script language="javascript" type="text/javascript" >
function showOut()
	{
		var menCoder_path	=	$Jq('#mencoder_path').val();
		var input_video 	=	$Jq('#input_video').val();
		var output_video 	=	$Jq('#output_video').val();
		var encode_hide_1 	=	$Jq('#encode_hide_1').val();
		var encode_hide_2 	=	$Jq('#encode_hide_2').val();
		var encode_hide_3 	=	$Jq('#encode_hide_3').val();
		var encode_hide_4 	=	$Jq('#encode_hide_4').val();
		var encode_hide_5 	=	$Jq('#encode_hide_5').val();
		var encode_hide_6 	=	$Jq('#encode_hide_6').val();
		var extra_command 	=	$Jq('#extra_command').val();
		var audio_codec 	=	$Jq('#audio_codec').val();
		var vbitrate 		=	$Jq('#vbitrate').val();
		var vfscale 		=	$Jq('#vfscale').val();
		var srate 			=	$Jq('#srate').val();
		var lavcresample 	=	$Jq('#lavcresample').val();
		var strBframes 	=	$Jq('#strBframes').val();
		var mencoder_command ="Mencoder Command <br><br>"+menCoder_path+' '+input_video+' '+encode_hide_1+' '+output_video;
		if(extra_command)
			{
				mencoder_command+=' '+extra_command;
			}
		mencoder_command+=' '+encode_hide_2+' '+audio_codec+' '+encode_hide_3+vbitrate+encode_hide_4;

		if(vfscale != '')
			{
				mencoder_command+= vfscale;
			}
		mencoder_command += ' '+encode_hide_5+' '+srate+' '+encode_hide_6+lavcresample+' '+strBframes;
		$Jq('#outdisplay').html(mencoder_command);
	}
</script>
<?php
	}
setTemplateFolder('admin/','video');
$smartyObj->display('videoReEncode.tpl');
?>
<?php
/* Added code to validate mandataory fields in video defaut settings page */
if ($CFG['feature']['jquery_validation'])
{
?>
<script type="text/javascript">
$Jq("#videoReEncodeFrm").validate({
	rules:
	{
		input_video: {
		required: true
		},
		output_video: {
		required: true
		}
	},
	messages:
	{
		input_video: {
		required: "<?php echo $LANG['common_err_tip_required'];?>"
		},
		output_video: {
		required: "<?php echo $LANG['common_err_tip_required'];?>"
		}
	}
});
</script>
<?php
}
$obj->includeFooter();
?>