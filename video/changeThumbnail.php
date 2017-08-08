<?php
/**
 *
 *
 * @version $Id$
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 */

require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/changeThumbnail.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';

$CFG['db']['is_use_db'] = true;
$CFG['site']['is_module_page']='video';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;

require_once($CFG['site']['project_path'].'common/application_top.inc.php');


class Thumbnail extends VideoHandler
{
	public $videodetail = array();
	public $upload_temp_url;
	public $videoName;
	public $VIDEO_CATEGORY_ID;
	public function getVideoStatus($video_id)
	{
		$sql='SELECT * from '.$this->CFG['db']['tbl']['video'].' WHERE video_id='.$this->dbObj->Param('video_id').' AND video_status=\'Ok\' AND user_id='.$this->dbObj->Param('user_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($video_id,$this->CFG['user']['user_id']));
		if (!$rs)
			trigger_db_error($this->dbObj);

		if($rs->PO_RecordCount())
		{
			$row = $rs->FetchRow();
			$this->videodetail['video_server_url']=$row['video_server_url'];
			$this->videodetail['t_height']=$row['t_height'];
			$this->videodetail['t_width']=$row['t_width'];
			$this->videoName = getVideoImageName($this->getFormField('video_id'));
			$this->VIDEO_CATEGORY_ID=$row['video_category_id'];

			$temp_video_folder =$this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin']['videos']['temp_folder'].'/';

			$this->upload_temp_url=$temp_video_folder;
			return true;
		}
		else
		{
			return false;
		}
	}

	public function setIHObject($imObj)
	{
			$this->imageObj = $imObj;
	}

	public function generateThumb($video_id,$imageSelection)
	{


		$video_server_url=$this->videodetail['video_server_url'];

		$host=$_SERVER["HTTP_HOST"];
		$pattern='/'.$host.'/';
		$localServerMatch=false;
		$oldServerUrl=$video_server_url;
		$localserver=false;
		if(preg_match($pattern,$video_server_url))
		{
			$video_server_url = $this->media_relative_path;
			$localserver = true;
		}
		$video_folder =$video_server_url.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'];

		if(preg_match('/G_/',$imageSelection))
		{
			$image_file=str_replace('G_','',$imageSelection).'.'.$this->CFG['video']['image']['extensions'];
			$copyImage = $video_folder.'/'.$this->videoName.'_gif/'.$image_file;
		}
		else
		{
			$copyImage = $video_folder.'/'.$this->videoName.'_'.$imageSelection.'.'.$this->CFG['video']['image']['extensions'];

		}


		$storeImage = $this->upload_temp_url.$this->videoName;

		if($localserver)
		{
			@copy($copyImage,$storeImage.'.'.$this->CFG['video']['image']['extensions']);
			$return=$this->convertTumb($storeImage);
			return $return;
		}
		else
		{
			if($this->getServerDetails())
			{
				if($video_server_url != $this->FTP_SERVER_URL)
				{
					$this->setPageBlockShow('block_msg_form_error');
					$this->setCommonErrorMsg($this->LANG['msg_external_site_thumbnail']);
					return false;
				}

			}
			else
			{
				$this->setPageBlockShow('block_msg_form_error');
				$this->setCommonErrorMsg($this->LANG['msg_external_site_thumbnail']);
				return false;
			}

			$this->chkAndCreateFolder($this->upload_temp_url);
			$image=fileGetContentsManual($copyImage);
			$fp=fopen($storeImage.'.'.$this->CFG['video']['image']['extensions'],'w');
			if(fwrite($fp,$image))
			{
				fclose($fp);
				$return=$this->convertTumb($storeImage.'.'.$this->CFG['video']['image']['extensions']);
				return true;
			}
			fclose($fp);
			return false;
		}
		exit;
		return false;
	}


	public function convertTumb($storeImage)
	{
		$imageObj = new ImageHandler($storeImage.'.'.$this->CFG['video']['image']['extensions']);
		$this->setIHObject($imageObj);

		$this->imageObj->resize($this->CFG['admin']['videos']['thumb_width'], $this->CFG['admin']['videos']['thumb_height'], '-');
		$this->imageObj->output_resized($storeImage.$this->CFG['admin']['videos']['thumb_name'].'.'.$this->CFG['video']['image']['extensions'], strtoupper($this->CFG['video']['image']['extensions']));

		$imageObj = new ImageHandler($storeImage.'.'.$this->CFG['video']['image']['extensions']);
		$this->setIHObject($imageObj);

		$this->imageObj->resize($this->CFG['admin']['videos']['small_width'], $this->CFG['admin']['videos']['small_height'], '-');
		$this->imageObj->output_resized($storeImage.$this->CFG['admin']['videos']['small_name'].'.'.$this->CFG['video']['image']['extensions'], strtoupper($this->CFG['video']['image']['extensions']));

		$imageObj = new ImageHandler($storeImage.'.'.$this->CFG['video']['image']['extensions']);
		$this->setIHObject($imageObj);

		$this->imageObj->resize($this->CFG['admin']['videos']['large_width'], $this->CFG['admin']['videos']['large_height'], '-');
		$this->imageObj->output_resized($storeImage.$this->CFG['admin']['videos']['large_name'].'.'.$this->CFG['video']['image']['extensions'], strtoupper($this->CFG['video']['image']['extensions']));

		if($this->moveLoadedFiles())
			return true;

		return false;

	}


	public function uploadThumb($video_id,$field)
	{
		$extern = strtolower(substr($_FILES[$field]['name'], strrpos($_FILES[$field]['name'], '.')+1));
		$uploadPath=$this->upload_temp_url.$this->videoName.'.'.$extern;
		if(!move_uploaded_file($_FILES[$field]['tmp_name'],$uploadPath))
		{
			return false;
		}
		$return=$this->convertTumb($this->upload_temp_url.$this->videoName);
		return $return;
	}



	/**
		 * VideoUpload::chkFileNameIsNotEmpty()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return
		 **/
		public function chkFileNameIsNotEmpty($field_name, $err_tip = '')
		{

				if(!isset($_FILES[$field_name]['name']) or !$_FILES[$field_name]['name'])
					{
						$this->fields_err_tip_arr[$field_name] = $err_tip;
						$this->setFormFieldErrorTip($field_name,$err_tip);
					//	echo $err_tip;
						return false;
					}
				return true;
			}

		/**
		 * VideoUpload::chkValidVideoFileType()
		 *
		 * @param $field_name
		 * @param string $err_tip
		 * @return
		 **/
		public function chkValidVideoFileType($field_name, $err_tip = '')
			{
			    return $this->chkValidFileType($field_name, $this->CFG['admin']['videos']['image_format_arr'], $err_tip);
			}

		/**
		 * VideoUpload::chkValideVideoFileSize()
		 *
		 * @param $field_name
		 * @param string $err_tip
		 * @return
		 **/
		public function chkValideVideoFileSize($field_name, $err_tip='')
			{
				if($this->CFG['admin']['videos']['max_size'])
					{
						$max_size = $this->CFG['admin']['videos']['image_max_size']*1024;
						if ($_FILES[$field_name]['size'] > $max_size)
							{
								$this->fields_err_tip_arr[$field_name] = $err_tip;
								return false;
							}
					}
				return true;
			}

		/**
		 * VideoUpload::chkErrorInFile()
		 *
		 * @param $field_name
		 * @param string $err_tip
		 * @return
		 **/
		public function chkErrorInFile($field_name, $err_tip='')
			{
				if($_FILES[$field_name]['error'])
					{
						$this->fields_err_tip_arr[$field_name] = $err_tip;
						return false;
					}
				return true;
			}

			public function moveLoadedFiles()
			{
				$dir_thumb = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
				$dir_video = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['video_folder'].'/';


				$tempurl =  $this->upload_temp_url.$this->videoName;

				$local_upload = true;
				if($this->getServerDetails())
					{
						dbDisconnect();
						if($FtpObj = new FtpHandler($this->FTP_SERVER,$this->FTP_USERNAME,$this->FTP_PASSWORD))
							{
								if($this->FTP_FOLDER)
									$FtpObj->changeDirectory($this->FTP_FOLDER);

								$dir_thumb = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
								$dir_video = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['video_folder'].'/';

								$FtpObj->makeDirectory($dir_thumb);
								$FtpObj->makeDirectory($dir_video);

								if(is_file($tempurl.'T.'.$this->CFG['video']['image']['extensions']))
									{
										$FtpObj->moveTo($tempurl.'T.'.$this->CFG['video']['image']['extensions'], $dir_thumb.$this->videoName.'T.'.$this->CFG['video']['image']['extensions']);
										unlink($tempurl.'T.'.$this->CFG['video']['image']['extensions']);
									}
								if(is_file($tempurl.'S.'.$this->CFG['video']['image']['extensions']))
									{
										$FtpObj->moveTo($tempurl.'S.'.$this->CFG['video']['image']['extensions'], $dir_thumb.$this->videoName.'S.'.$this->CFG['video']['image']['extensions']);
										unlink($tempurl.'S.'.$this->CFG['video']['image']['extensions']);
									}
								if(is_file($tempurl.'L.'.$this->CFG['video']['image']['extensions']))
									{
										$FtpObj->moveTo($tempurl.'L.'.$this->CFG['video']['image']['extensions'], $dir_thumb.$this->videoName.'L.'.$this->CFG['video']['image']['extensions']);
										unlink($tempurl.'L.'.$this->CFG['video']['image']['extensions']);
									}
								$FtpObj->ftpClose();
								$SERVER_URL = $this->FTP_SERVER_URL;
								$local_upload = false;
							}
						dbConnect();
						return true;

					}
				if($local_upload)
					{
						dbDisconnect();
						$upload_dir_thumb = $dir_thumb;
						$upload_dir_video = $dir_video;

						$this->chkAndCreateFolder($upload_dir_thumb);
						$this->chkAndCreateFolder($upload_dir_video);

						$uploadUrlThumb = $upload_dir_thumb.$this->videoName;
						$uploadUrlVideo = $upload_dir_video.$this->videoName;

						if(is_file($tempurl.'S.'.$this->CFG['video']['image']['extensions']))
							{
								copy($tempurl.'S.'.$this->CFG['video']['image']['extensions'], $uploadUrlThumb.'S.'.$this->CFG['video']['image']['extensions']);
								unlink($tempurl.'S.'.$this->CFG['video']['image']['extensions']);
							}
						if(is_file($tempurl.'T.'.$this->CFG['video']['image']['extensions']))
							{
								copy($tempurl.'T.'.$this->CFG['video']['image']['extensions'], $uploadUrlThumb.'T.'.$this->CFG['video']['image']['extensions']);
								unlink($tempurl.'T.'.$this->CFG['video']['image']['extensions']);
							}
						if(is_file($tempurl.'L.'.$this->CFG['video']['image']['extensions']))
							{
								copy($tempurl.'L.'.$this->CFG['video']['image']['extensions'], $uploadUrlThumb.'L.'.$this->CFG['video']['image']['extensions']);
								unlink($tempurl.'L.'.$this->CFG['video']['image']['extensions']);
							}

						$SERVER_URL = $this->CFG['site']['url'];
						dbConnect();
						return true;
					}

				return false;
			}
				public function getServerDetails()
			{
				$cid = $this->VIDEO_CATEGORY_ID.',0';
				$sql = 'SELECT server_url, ftp_server, ftp_folder, category, ftp_usrename, ftp_password FROM'.
						' '.$this->CFG['db']['tbl']['server_settings'].
						' WHERE server_for=\'video\' AND category IN('.$cid.')'.
						' AND server_status=\'Yes\' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if(!$rs->PO_RecordCount())
					return false;

				while($row = $rs->FetchRow())
					{
						$this->FTP_SERVER = $row['ftp_server'];
						$this->FTP_FOLDER = $row['ftp_folder'];
						$this->FTP_USERNAME = html_entity_decode($row['ftp_usrename']);
						$this->FTP_PASSWORD = html_entity_decode($row['ftp_password']);
						$this->FTP_SERVER_URL = $row['server_url'];

						if($row['category']==$this->VIDEO_CATEGORY_ID)
							return true;
					}
				if(isset($this->FTP_SERVER) and $this->FTP_SERVER)
					return true;
				return false;
			}

}
$thumb = new Thumbnail();
$thumb->setDBObject($db);
$thumb->makeGlobalize($CFG,$LANG);
$thumb->setMediaPath('../');
$thumb->setPageBlockNames(array('display_image','block_msg_form_error', 'block_msg_form_success'));
$thumb->setCSSFormFieldErrorTipClass('clsFormFieldErrTip');
$thumb->setCSSFormLabelCellDefaultClass('clsFormLabelCellDefault');
$thumb->setCSSFormFieldCellDefaultClass('clsFormFieldCellDefault');
$thumb->setCSSFormLabelCellErrorClass('clsFormLabelCellError');
$thumb->setCSSFormFieldCellErrorClass('clsFormFieldCellError');
$thumb->setFormField('video_id','');
$thumb->setFormField('thumbfile','');
$thumb->setFormField('imageSel','');
$thumb->sanitizeFormInputs($_GET);
$thumb->setAllPageBlocksHide();
if($thumb->isFormGETed($_GET, 'video_id'))
{

	if($thumb->getVideoStatus($thumb->getFormField('video_id')))
		$thumb->setPageBlockShow('display_image');
	else
	{
		$thumb->setPageBlockShow('block_msg_form_error');
		$thumb->setCommonErrorMsg($LANG['msg_videoid_error']);
	}

	if($thumb->isFormGETed($_GET, 'imageSel'))
	{
		if($thumb->generateThumb($thumb->getFormField('video_id'),$thumb->getFormField('imageSel')))
		{
			$thumb->setPageBlockShow('block_msg_form_success');
			$thumb->setCommonSuccessMsg($LANG['msg_image_generation_success']);
		}
		else
		{
			$thumb->setCommonErrorMsg($LANG['msg_image_generation_error']);
		}
	}
		if($thumb->isFormPOSTed($_POST, 'upload'))
	{

		if($thumb->chkFileNameIsNotEmpty('thumbfile', $LANG['err_tip_compulsory']) and
												$thumb->chkValidVideoFileType('thumbfile',$LANG['err_tip_invalid_file_type']) and
													$thumb->chkValideVideoFileSize('thumbfile',$LANG['err_tip_invalid_file_size']) and
														$thumb->chkErrorInFile('thumbfile',$LANG['err_tip_invalid_file']))
		{

			if($thumb->uploadThumb($thumb->getFormField('video_id'),'thumbfile'))
			{
				$thumb->setPageBlockShow('block_msg_form_success');
				$thumb->setCommonSuccessMsg($LANG['msg_image_generation_success']);
			}
			else
			{
				$thumb->setPageBlockShow('block_msg_form_error');
				$thumb->setCommonErrorMsg($LANG['msg_image_generation_error']);
			}
		}
		else
		{

			$thumb->setPageBlockShow('block_msg_form_error');
			$thumb->setCommonErrorMsg($LANG['msg_image_generation_error']);
		}
	}

}
if ($thumb->isShowPageBlock('display_image'))
{


	$thumb->uploadThumbUrl=getUrl('changethumbnail','?video_id='.$thumb->getFormField('video_id'),'?video_id='.$thumb->getFormField('video_id'),'members','video');

	$video_name = getVideoImageName($thumb->getFormField('video_id'));

	$video_server_url=$thumb->videodetail['video_server_url'];
	$host=$_SERVER["HTTP_HOST"];
	$pattern='/'.$host.'/';
	$localServerMatch=false;
	$oldServerUrl=$video_server_url;
	if(preg_match($pattern,$video_server_url))
	{
		$video_server_url=$thumb->media_relative_path;
		$localServerMatch=true;
	}

	$video_folder =$video_server_url.$CFG['media']['folder'].'/'.$CFG['admin']['videos']['folder'].'/'.$CFG['admin']['videos']['thumbnail_folder'];
	$thumb->currentThumb=$video_folder.'/'.$video_name.$CFG['admin']['videos']['thumb_name'].'.'.$CFG['video']['image']['extensions'];

	## taking Images from gif animation folder
	$gif_animation_path = $video_folder.'/'.$video_name.'_gif/';


	$available_thumb = array();
	$inc=0;
	for($i=1; $i<=$CFG['admin']['videos']['total_frame'];$i++)
	{
			$path=$video_folder.'/'.$video_name.'_'.$i.'.'.$CFG['video']['image']['extensions'];
			if(!$localServerMatch)
				{
					if(getHeadersManual($path))
						{
							$available_thumb[$inc]['src'] =$path;
							$available_thumb[$inc]['id']=$i;
							$inc++;
						}
				}
			else
			{
				if(file_exists($path))
				{
					$available_thumb[$inc]['src'] =$path;
					$available_thumb[$inc]['id']=$i;
					$inc++;
				}
			}
	}

	$total_gif_frame=$CFG['admin']['videos']['rotating_thumbnail_max_frames'];
	for($i=1;$i<=$total_gif_frame;$i++)
	{
		$path=$gif_animation_path.$i.'.'.$CFG['video']['image']['extensions'];
		if(!$localServerMatch)
		{
				if(getHeadersManual($path))
					{
						$available_thumb[$inc]['src']=$path;
						$available_thumb[$inc]['id']='G_'.$i;
						$inc++;
					}
		}
		else
		{
			if(file_exists($path))
			{
				$available_thumb[$inc]['src'] =$path;
				$available_thumb[$inc]['id']='G_'.$i;
				$inc++;
			}
		}
	}
	$i=0;
	$available_thumb=array_filter($available_thumb);
	$count = sizeof($available_thumb);
	$maxRow=ceil($count/$CFG['admin']['videos']['show_thumbnail_per_row']);
	$increament=0;
	$thumb->image=array();
	foreach($available_thumb as $imageSrc)
	{
			if($imageSrc['src'])
			{
				$thumb->image[$increament]['opentr']='';
				if($i==0)
				{
				$inc=0;
				$thumb->image[$increament]['opentr']=true;
				}
				$i++;
				$count--;
				$thumb->image[$increament]['changeThumbUrl']=getUrl('changethumbnail','?video_id='.$thumb->getFormField('video_id').'&imageSel='.$imageSrc['id'],'?video_id='.$thumb->getFormField('video_id').'&imageSel='.$imageSrc['id'],'members','video');
				$thumb->image[$increament]['path']=$imageSrc['src'];
				$thumb->image[$increament]['width']=$thumb->videodetail['t_width'];
				$thumb->image[$increament]['height']=$thumb->videodetail['t_height'];

				if($maxRow==1 && !$count)
				{
					$remainingTdCount = $CFG['admin']['videos']['show_thumbnail_per_row']-$i;
					$thumb->image[$increament]['closetr']='';
					for($remainingTdCount;$remainingTdCount>0;$remainingTdCount--)
					{
						$increament++;
						$thumb->image[$increament]['opentr']='';
						$thumb->image[$increament]['path']='';
						$thumb->image[$increament]['closetr']='';
					}
					$thumb->image[$increament]['closetr']=true;
				}
				$thumb->image[$increament]['closetr']='';

				if($i==$CFG['admin']['videos']['show_thumbnail_per_row'])
				{

					$i=0;
					$maxRow--;
					$thumb->image[$increament]['closetr']=true;
				}

				$increament++;

			}
			else
			{
				$count--;
			}
	}

}
$thumb->editVideoUrl=getUrl('videouploadpopup','?video_id='.$thumb->getFormField('video_id'),$thumb->getFormField('video_id').'/','members','video');

$thumb->includeHeader();
//include the content of the page
setTemplateFolder('members/','video');
$smartyObj->display('changeThumbnail.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$thumb->includeFooter();

?>