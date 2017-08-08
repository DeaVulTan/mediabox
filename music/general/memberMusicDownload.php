<?php
/**
* MusicDownload
*
* @package
* @author
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
* @version $Id: $
* @access public
**/
class MusicDownload extends MusicHandler
	{
		/**
		* MusicDownload::chkValidMusicId()
		*
		* @return
		**/
		public function chkValidMusicId()
			{
				$this->sql_condition = 'm.music_status=\'Ok\' AND m.music_encoded_status=\'Yes\' AND m.music_id=\''.addslashes($this->fields_arr['music_id']).
				                       '\' AND (m.user_id = '.$this->CFG['user']['user_id'].' OR m.music_access_type = \'Public\''.$this->getAdditionalQuery('m.').')';
				$sql = 'SELECT m.music_ext, m.music_server_url, m.music_title,music_url,music_upload_type,m.user_id '.
				' FROM '.$this->CFG['db']['tbl']['music'].' as m'.
				' WHERE '.$this->sql_condition.' LIMIT 0,1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if($row = $rs->FetchRow())
					{
						$this->fields_arr['music_ext'] = $row['music_ext'];
						$this->fields_arr['user_id'] = $row['user_id'];
						$this->fields_arr['music_server_url'] = $row['music_server_url'];
						$this->fields_arr['music_title'] = $row['music_title'];
						$this->fields_arr['music_url'] = $row['music_url'];
						$this->fields_arr['music_upload_type'] = $row['music_upload_type'];
						return true;
					}
				return false;
			}
		public function url_exists($url)
			{
				//file get contents manual doesn't work correcly
				if ($ss =getHeadersManual($url))
					return true;
				return false;
			}

		/**
		* MusicDownload::downloadMusic()
		*
		* @param $file
		* @param $name
		* @return
		**/
		public function downloadMusic()
			{
				unset($_SESSION['download_type']);
				$download_file_name = $this->changeTitle($this->fields_arr['music_title']);
				if($this->CFG['admin']['musics']['full_length_audio']=='members' AND !isLoggedin() AND $this->fields_arr['music_type']=='mp3' AND $this->fields_arr['user_id']!=$this->CFG['user']['user_id'])
					{

						$trim_music_folder=$this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['trimed_music_folder'].'/';
						$music_url=$this->fields_arr['music_server_url'].$trim_music_folder.getTrimMusicName($this->fields_arr['music_id']);
						$trimMusic = true;
					}
				else if($this->CFG['admin']['musics']['full_length_audio']=='paid_members' AND !isPaidMember() AND $this->fields_arr['music_type']=='mp3')
					{

						$trim_music_folder=$this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['trimed_music_folder'].'/';
						$music_url=$this->fields_arr['music_server_url'].$trim_music_folder.getTrimMusicName($this->fields_arr['music_id']);
						$trimMusic = true;
					}
				else
					{

						$music_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['music_folder'].'/';
						$music_url = $this->fields_arr['music_server_url'].$music_folder.getMusicName($this->fields_arr['music_id']);
						$trimMusic = false;
					}
				if($trimMusic == true)
					{
						if($this->chkIsLocalServer())
							{

								$chkTrimMusic=str_replace($this->fields_arr['music_server_url'],$this->media_relative_path,$music_url).'.mp3';
								if(!file_exists($chkTrimMusic))
									{
										$music_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['music_folder'].'/';
										$music_url = $this->fields_arr['music_server_url'].$music_folder.getMusicName($this->fields_arr['music_id']);
										$trimMusic = false;
									}
							}
						else
						{
							if(!$this->url_exists($music_url.'.mp3'))
							{
								$music_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['music_folder'].'/';
								$music_url = $this->fields_arr['music_server_url'].$music_folder.getMusicName($this->fields_arr['music_id']);
								$trimMusic = false;
							}
						}

					}
				$music_filename = $music_url.'.mp3';
				$file_check=str_replace($this->fields_arr['music_server_url'],$this->media_relative_path,$music_filename);
				$otherFormat=false;
				if($this->fields_arr['music_type']!='mp3' AND $this->fields_arr['user_id']!=$this->CFG['user']['user_id'])
					{
						if($this->CFG['admin']['musics']['full_length_audio']=='members' AND !isLoggedin())
							{
								return false;
							}
						else if($this->CFG['admin']['musics']['full_length_audio']=='paid_members' AND !isPaidMember())
							{
								return false;
							}
					}

				switch($this->fields_arr['music_type'])
					{

						case 'mp3':
						$filename = $music_filename;
						break;
						case 'original':
						if($this->CFG['admin']['musics']['save_original_file_to_download'])
							{

								$orginal_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['original_music_folder'].'/';
								$orignal_url =$this->fields_arr['music_server_url'].$orginal_folder.getMusicName($this->fields_arr['music_id']);
								$filename = $orignal_url.'.'.$this->fields_arr['music_ext'];
								$this->fields_arr['music_type']=$this->fields_arr['music_ext'];
							}
						else
							{

								$filename = $music_filename;
								$this->fields_arr['music_type']='mp3';
							}
						break;
						default:
						if($this->CFG['admin']['musics']['music_other_formats_enabled'])
							{

								$other_format_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['other_musicformat_folder'].'/';
								$other_format_url =$this->fields_arr['music_server_url'].$other_format_folder.getMusicName($this->fields_arr['music_id']);
								$filename=$other_format_url.'.'.$this->fields_arr['music_type'];
								$otherFormat=true;
							}
						else
							{

								$filename = $music_filename;
								$this->fields_arr['music_type']='mp3';
							}
					} // switch
				if($this->fields_arr['music_upload_type']=='Normal')
					{
					if($this->url_exists($filename))
						{

							if($otherFormat)
								$this->incrementOtherFormatTotalDownload($this->fields_arr['music_type'], $this->fields_arr['music_id']);
							else
								$this->incrementTotalDownload();
							Redirect2URL($filename);
							exit;
						}
					else
						{
							return false;
						}
					}
					else
					{
						if(file_exists($file_check))
						{
							if(getHeadersManual($filename))
							{
								$this->incrementTotalDownload();
									Redirect2URL($filename);
								exit;
							}
						}
						else
						{
							return false;

						}
					}
			}
		/**
		* MusicDownload::incrementTotalDownload()
		*
		* @return
		**/
		public function incrementTotalDownload()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET'.' total_downloads=total_downloads+1'.
				' WHERE music_id='.$this->dbObj->Param('music_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}
		public function isMemberDownload()
			{
				if(strcasecmp($this->CFG['admin']['musics']['download_previlages'], 'members') == 0)
					{
						if(!isLoggedin())
							{
								$_SESSION['download_url']=getUrl('viewmusic','?music_id='.$this->fields_arr['music_id'].
								'&title='.$this->changeTitle($this->fields_arr['music_title']), $this->fields_arr['music_id'].'/'.
								$this->changeTitle($this->fields_arr['music_title']).'/', 'members', 'music');
								$_SESSION['download_type']=$this->getFormField('music_type');
								$url=getUrl('login','', '');
								Redirect2URL($url);
							}
						else
							{
								return true;
							}
					}
				else
					{
						return true;
					}
			}
		public function isPaidMemeberAlert()
			{
				$chkMember = false;

				if(strcasecmp($this->CFG['admin']['musics']['download_previlages'], 'paid_members') == 0 AND !isloggedIn())
					{
						$link = '<a href="'.getUrl('signup').'">'.$this->LANG['viewmusic_trimmed_click_here'].'</a>';
						$this->alertMessage = str_replace('VAR_LINK',$link,$this->LANG['viewmusic_download_paid_err_msg']);
						$chkMember =true;
					}
				else if($this->CFG['admin']['musics']['full_length_audio']=='paid_members' AND !isPaidMember())
					{
						$link = '<a href="'.getUrl('upgrademembership','','','members').'">'.$this->LANG['viewmusic_trimmed_click_here'].'</a>';
						$this->alertMessage = str_replace('VAR_LINK',$link,$this->LANG['viewmusic_download_paid_err_msg']);
						$chkMember =true;
					}
				else if($this->CFG['admin']['musics']['full_length_audio']=='paid_members' AND !isPaidMember())
					{
						$link = '<a href="'.getUrl('upgrademembership','','','members').'">'.$this->LANG['viewmusic_trimmed_click_here'].'</a>';
						$this->alertMessage = str_replace('VAR_LINK',$link,$this->LANG['viewmusic_download_paid_err_msg']);
						$chkMember =true;
					}
				else if((strcasecmp($this->CFG['admin']['musics']['download_previlages'], 'members') == 0) AND !isloggedIn())
					{
						$link = '<a href="'.getUrl('upgrademembership','','','members').'">'.$this->LANG['viewmusic_trimmed_click_here'].'</a>';
						$this->alertMessage = str_replace('VAR_LINK',$link,$this->LANG['viewmusic_download_paid_err_msg']);
						$chkMember =true;
					}

				return $chkMember;
			}
	}
//<<<<<-------------- Class MusicDownload begins ---------------//
//-------------------- Code begins -------------->>>>>//
$MusicDownload = new MusicDownload();
$MusicDownload->setDBObject($db);
$MusicDownload->makeGlobalize($CFG, $LANG);
if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
if(isMember())
	$MusicDownload->setMediaPath('../../');
else
$MusicDownload->setMediaPath('../');
$MusicDownload->setPageBlockNames(array('download_music_form','block_msg_form_error'));
$MusicDownload->setCSSFormFieldErrorTipClass('clsFormFieldErrTip');
$MusicDownload->setCSSFormLabelCellDefaultClass('clsFormLabelCellDefault');
$MusicDownload->setCSSFormFieldCellDefaultClass('clsFormFieldCellDefault');
$MusicDownload->setCSSFormLabelCellErrorClass('clsFormLabelCellError');
$MusicDownload->setCSSFormFieldCellErrorClass('clsFormFieldCellError');
//default form fields and values...
$MusicDownload->setFormField('music_id', '');
$MusicDownload->setFormField('music_type', 'mp3');
$MusicDownload->sanitizeFormInputs($_REQUEST);
if((strcasecmp($CFG['admin']['musics']['download_previlages'], 'paid_members') == 0) && ispaidmember())
{
	if($CFG['admin']['musics']['download_option'])
	{
		if($MusicDownload->isFormGETed($_GET,'music_id'))
		{
			if($MusicDownload->chkValidMusicId())
			{
				if($MusicDownload->isMemberDownload())
				{
					$MusicDownload->downloadMusic();
				}
			}
		}
	}
}
if((strcasecmp($CFG['admin']['musics']['download_previlages'], 'paid_members') == 0) && !ispaidmember())
{
	if($CFG['feature']['membership_payment']==true)
	{
		Redirect2Url(getUrl('upgrademembership', '?status=download_option', '?status=download_option', 'members'));
	}
	/*else
	{
		$MusicDownload->setCommonErrorMsg($LANG['viewmusic_download_paid_err_msg']);
		$MusicDownload->setPageBlockShow('block_msg_form_error');
	}*/
}
if(strcasecmp($CFG['admin']['musics']['download_previlages'], 'members') == 0)
{
	if($CFG['admin']['musics']['download_option'])
	{
		if($MusicDownload->isFormGETed($_GET,'music_id'))
		{
			if($MusicDownload->chkValidMusicId())
			{
				if($MusicDownload->isMemberDownload())
				{
					$MusicDownload->downloadMusic();
				}
			}
		}
	}
	$MusicDownload->setCommonErrorMsg($LANG['viewmusic_signup_err_msg']);
	$MusicDownload->setPageBlockShow('block_msg_form_error');

}
//<<<<<-------------------- Page block templates ends -------------------//
$MusicDownload->includeHeader();
setTemplateFolder('general/','music');
$smartyObj->display('musicDownload.tpl');
$MusicDownload->includeFooter();
?>
