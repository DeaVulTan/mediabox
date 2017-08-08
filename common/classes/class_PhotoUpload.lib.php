<?php
/**
 * Class to handle the form fields
 *
 * This is having class MusicHandler to handle Photo Upload functionalities.
 * Which extends FormHandler and MediaHandler, ListRecordsHandler (If class exists)
 *
 *
 *
 * @category	###Rayzz###
 * @package		###Common/Classes###
 */
if(class_exists('PhotoHandler'))
{
	class PhotoUploadHandler extends PhotoHandler{}
}
elseif(class_exists('MediaHandler'))
{
	class PhotoUploadHandler extends MediaHandler{}
}
elseif(class_exists('ListRecordsHandler'))
{
	class PhotoUploadHandler extends ListRecordsHandler{}
}
elseif(class_exists('FormHandler'))
{
	class PhotoUploadHandler extends FormHandler{}
}

class PhotoUploadLib extends PhotoUploadHandler
{

	/**
	 * PhotoUploadLib::__construct()
	 *  Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		$this->MEDIA_TYPE = 'photo';
		$this->MEDIA_TYPE_CFG = 'photos';
	}

	/**
	 * PhotoUploadLib::setIHObject()
	 *
	 * @param object $imObj
	 * @return void
	 */
	public function setIHObject($imObj)
	{
		$this->imageObj = $imObj;
	}

	/**
	 * PhotoUploadLib::resetFieldsArray()
	 *
	 * @return void
	 */
	public function resetFieldsArray()
	{
		$this->setFormField('photo_id', '');
		$this->setFormField('photo_album', '');
		$this->setFormField('photo_album_id', '1');
		$this->setFormField('album_id', '1');
		$this->setFormField('album_id_public', '');
		$this->setFormField('photo_file', '');
		$this->setFormField('photo_external_file', '');
		$this->setFormField('photo_other', '');
		$this->setFormField('photo_upload_type', '');
		$this->setFormField('photo_category_type', 'General');
		$this->setFormField('photo_category_id', '1');
		$this->setFormField('photo_sub_category_id', '');
		$this->setFormField('photo_category_id_porn', '');
		$this->setFormField('photo_title', '');
		$this->setFormField('photo_caption', '');
		$this->setFormField('photo_tags', '');
		$this->setFormField('gpukey', '');
		$this->setFormField('photo_access_type', 'Public');
		$this->setFormField('location', '');
		$this->setFormField('location_recorded', '');
		$this->setFormField('google_map_latitude', 0);
		$this->setFormField('google_map_longtitude', 0);
		$this->setFormField('allow_comments', 'Yes');
		$this->setFormField('allow_ratings', 'Yes');
		$this->setFormField('allow_embed', 'Yes');
		$this->setFormField('allow_tags', 'Yes');
		$this->setFormField('relation_id',array());
		$this->setFormField('upload', '');
		$this->setFormField('photo_file_name','');
		$this->setFormField('photo_original_filename', '');
		$this->setFormField('photo_file_image','');
		$this->setFormField('photo_file_ext','');
		$this->setFormField('photo_server_url', '');
		$this->setFormField('file_extern', '');
		$this->setFormField('cid', '');
		$this->setFormField('ajax_page','');
		$this->setFormField('pg','');
		$this->setFormField('total_photos', '');
		$this->setFormField('edit_mode', 0);
		$this->setFormField('query', '');
		$this->setFormField('step_status', 'Step1');
		$this->setFormField('external_site_photo_path','');
		$this->setFormField('capturedPhoto','');
		$this->setFormField('photo_album_type','Public');
		$this->setFormField('external_photo_url','');
	}

	/**
	 * PhotoUploadLib::addNewPhoto()
	 *
	 * @return void
	 */
	public function addNewPhoto()
	{
		//set the file type in the form field photo_ext
		if($this->fields_arr['photo_upload_type']=='Normal' OR $this->fields_arr['photo_upload_type']=='MultiUpload')
		{
			if($this->isFormPOSTed($_POST, 'upload_photo_normal') OR $this->isFormPOSTed($_POST, 'Upload')) // Upload is for SWFupload
			{
				$extern = strtolower(substr($_FILES['photo_file']['name'],
										strrpos($_FILES['photo_file']['name'], '.')+1));
				$original_file_name = substr($_FILES['photo_file']['name'], 0,
										strrpos($_FILES['photo_file']['name'], '.'));
			}
			$this->setFormField('photo_server_url', $this->CFG['site']['url']);
			$this->setFormField('photo_ext', $extern);
			$this->setFormField('photo_original_filename', $original_file_name);
			$this->setFormField('photo_title', $original_file_name);
			$this->setFormField('photo_size',$_FILES['photo_file']['size']);
		}
		else if($this->fields_arr['photo_upload_type'] == 'External')
		{
			$photo_external_file = $this->getFormField('photo_external_file');
			$extern = strtolower(substr($this->getFormField('photo_external_file'),
						strrpos($this->getFormField('photo_external_file'), '.')+1));

			$original_file_name = substr($this->getFormField('photo_external_file'),
										strrpos($this->getFormField('photo_external_file'), '/')+1,
											strrpos($this->getFormField('photo_external_file'), '.'));

			if($this->CFG['admin']['photos']['external_photo_download'])
				$photo_server_url = substr($this->getFormField('photo_external_file'), 0,
										strrpos($this->getFormField('photo_external_file'), '/')+1);
			else
				$photo_server_url = $this->CFG['site']['url'];

			$this->setFormField('photo_server_url', $photo_server_url);
			$this->setFormField('external_photo_url',$this->getFormField('photo_external_file'));
			$this->setFormField('photo_ext',$extern);
			$this->setFormField('photo_original_filename', $original_file_name);
			$this->setFormField('photo_title', $original_file_name);
			$this->setFormField('photo_size', '');
		}
		else if($this->fields_arr['photo_upload_type'] == 'Capture')
		{
			$extern = 'jpg';
			$this->setFormField('photo_ext', 'jpg');
			//$this->setFormField('photo_status', 'Ok');
			$capture_file = $this->fields_arr['capturedPhoto'];
			$file_size = filesize($capture_file);
			$this->setFormField('photo_size', $file_size);
			$this->setFormField('photo_title', $this->LANG['common_recorded_photo']);
			$this->setFormField('photo_server_url', $this->CFG['site']['url']);
		}
		elseif ($this->fields_arr['photo_upload_type']=='MassUpload')
		{
			$extern = $this->fields_arr['extern'];
			$massuploaddirname = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->mass_uploader_folder.'/'.
								 $this->fields_arr['photo_folder_path'].'/'.$this->fields_arr['original_file_name'].'.'.$extern;
			$original_file_name = $this->fields_arr['original_file_name'];
			$this->setFormField('photo_server_url', $this->CFG['site']['url']);
			$this->setFormField('photo_ext', strtolower($extern));
			$this->setFormField('photo_original_filename', $original_file_name);
			$this->setFormField('photo_title', $original_file_name);
			$this->setFormField('photo_size',filesize($massuploaddirname));
		}
		$this->setFormField('photo_server_url', $this->CFG['site']['url']);
		$this->setFormField('user_id',$this->CFG['user']['user_id']);
		//$this->setFormField('photo_ext', $extern);
		$this->setFormField('photo_file_name_id', getCurrentPhotoFileSettingId('Photo'));
		$this->setFormField('date_added','NOW()');
		$this->populateDefaultPhotoDetails();
		$this->fields_arr['photo_album_id'] = $this->fields_arr['album_id'];
		$photo_id = $this->insertPhotoTable(array('user_id','photo_album_id','photo_ext', 'photo_size',
												'photo_title','photo_tags', 'photo_category_id',
												'photo_access_type','date_added','allow_comments','allow_ratings',
												'photo_upload_type', 'photo_server_url','allow_tags',
												'photo_original_filename','external_photo_url',
												'photo_file_name_id','photo_sub_category_id'
												)
											);

		$this->setFormField('photo_id', $photo_id);
		if($this->getFormField('photo_upload_type') != 'MultiUpload')
			$_SESSION['new_photo_id'][] = $photo_id;

		//added code for logging
		if($this->fp)
		{
			$log_str = 'Photo Record created : '.$photo_id."\r\n";
			$this->writetoTempFile($log_str);
		}
		$photo_name = getPhotoName($photo_id);
		$temp_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
						$this->CFG['temp_media']['folder'].'/'.
							$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['temp_folder'].'/';
		//$temp_dir.'<br />';
		$this->chkAndCreateFolder($temp_dir);
		$extern_img = $this->fields_arr['photo_file_ext'];
		$photo_temp_name = $this->fields_arr['photo_file_name'];
		$tempurl = $temp_dir.$photo_name;
		$temp_file = $temp_dir.$photo_name.'.'.$this->fields_arr['photo_ext'];
		if($this->fields_arr['photo_upload_type'] == 'Normal' OR $this->fields_arr['photo_upload_type'] == 'MultiUpload')
		{
			$this->storePhotosTempServer($temp_file);
		}
		else if($this->fields_arr['photo_upload_type'] == 'External' &&	$this->CFG['admin']['photos']['external_photo_download'])
		{
			$log_str = 'DOWNLOADING FILE FROM: '.$this->fields_arr['photo_external_file']."\r\n";
			$this->writetoTempFile($log_str);
			$external_photo = getContents($this->fields_arr['photo_external_file']);
			if($external_photo)
			{
				$log_str = 'STORING TO: '.$temp_file."\r\n";
				$this->writetoTempFile($log_str);
				//store the external file content to temp media folder
				$this->fileWrite($temp_file, $external_photo);
				$file_size = filesize($temp_file);
				$this->updatePhotoFileSize($file_size,$photo_id);
				$this->setFormField('photo_size', $file_size);
			}
			else
			{
				$log_str = 'Unable to download file from: '.$this->fields_arr['photo_external_file']."\r\n";
				$this->writetoTempFile($log_str);
			}
		}
		else if($this->fields_arr['photo_upload_type'] == 'Capture')
		{
			$log_str = 'DOWNLOADING FILE FROM buffer'."\r\n";
			$this->writetoTempFile($log_str);
			//store the capture file content to temp media folder
			rename($capture_file,$temp_file);
			$this->fields_arr['photo_upload_type'] = 'Normal';
		}
		else if($this->fields_arr['photo_upload_type'] == 'MassUpload')
		{
			$dirname = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->mass_uploader_folder.'/'.
									$this->fields_arr['photo_folder_path'].'/'.$this->fields_arr['original_file_name'].'.'.$this->fields_arr['extern'];
			copy($dirname, $temp_file);
		}

		dbConnect();
		//echo $capture_file;

		if($this->checkPhotoAndGetDetails($photo_id))
		{
			$temp_url = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
						$this->CFG['temp_media']['folder'].'/'.
							$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['temp_folder'].'/'.$this->PHOTO_NAME;

			if($this->CFG['admin']['photos']['photo_meta_data'] && empty($capture_file))
			{
				if(strtolower($this->PHOTO_EXT) == 'jpg' || strtolower($this->PHOTO_EXT) == 'jpeg')
					$this->addPhotoMetaData($temp_url.'.'.$this->PHOTO_EXT);
			}
			if($this->CFG['admin']['photos']['save_original_file_to_download'])
			{
				if($this->getServerDetails())
				{
					dbDisconnect();
					if($FtpObj = new FtpHandler($this->FTP_SERVER,$this->FTP_USERNAME,$this->FTP_PASSWORD))
					{
						if($this->FTP_FOLDER)
						{

							if($FtpObj->changeDirectory($this->FTP_FOLDER))
							{

								$dir_orginal_photo = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['original_photo_folder'].'/';;
								$uploadUrlOrginal = $upload_dir_orginal_photo.$this->PHOTO_NAME.$this->PHOTO_EXT;
								$FtpObj->makeDirectory($upload_dir_orginal_photo);
								$FtpObj->copyFrom($temp_url.'.'.$this->PHOTO_EXT, $uploadUrlOrginal);
							}
							$FtpObj->ftpClose();
						}
					}
					dbConnect();
				}
				else
				{
					$original_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
										$this->CFG['admin']['photos']['original_photo_folder'].'/';
					$this->chkAndCreateFolder($original_dir);
					$original_file = $original_dir.$this->PHOTO_NAME.'.'.$this->PHOTO_EXT;
					copy($temp_url.'.'.$this->PHOTO_EXT,$original_file);
				}
			}
			if($this->CFG['admin']['photos']['watermark_apply'])
			{
				$this->storeWaterMarkPhoto($temp_url.'.'.$this->PHOTO_EXT,$temp_url.'.'.$this->PHOTO_EXT);
			}
			if(is_file($temp_url.'.'.$this->PHOTO_EXT))
			{
				$imageObj = new ImageHandler($temp_url.'.'.$this->PHOTO_EXT);
				$this->setIHObject($imageObj);
				$this->storeImagesTempServer($temp_url, $this->PHOTO_EXT);
				//To update image sizes in music table
				$this->updatePhotoImageExt();
			}
			$this->writetoTempFile('BEFORE ACTIVATE CALL:'."\r\n");
			//check the photo activity status from config.
			if($this->CFG['admin']['photos']['photo_auto_activate'])
			{
				$this->writetoTempFile('IN ACTIVATE CALL CONDITION:'."\r\n");
				//added code for logging
				if($this->fp)
				{
					$log_str = ' Calling Photo Activate \r\n';
					$this->writetoTempFile($log_str);
				}

				if($this->populatePhotoDetails())
				{
					if($this->activatePhotoFile())
					{
						$this->addPhotoUploadActivity();
						//send a mail to photo uploader.
						$this->sendMailToUserForActivate();
						if($this->getFormField('photo_upload_type') == 'MultiUpload')
							$_SESSION['new_photo_id'][] = $this->getFormField('photo_id');
					}
				}

			}
			else
			{
				if($this->getFormField('photo_upload_type') == 'MultiUpload')
					$_SESSION['new_photo_id'][] = $this->getFormField('photo_id');
			}
		}
	}
	/**
	 * PhotoUploadLib::updatePhotoFileSize()
	 *
	 * @param int $size
	 * @param int $photo_id
	 * @return boolean
	 */
	public function updatePhotoFileSize($size,$photo_id)
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET'.
				' photo_size='.$this->dbObj->Param('photo_size').','.
				' photo_status=\'Ok\' WHERE'.
				' photo_id='.$this->dbObj->Param('photo_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($size, $photo_id));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
	}


	/**
	 * PhotoUploadLib::storePhotosTempServer()
	 *
	 * @param string $uploadUrl
	 * @return boolean
	 */
	public function storePhotosTempServer($uploadUrl)
	{
		//if php file upload OR if Multi-Upload
		if($this->isFormPOSTed($_POST, 'upload_photo_normal') OR $this->isFormPOSTed($_POST, 'Upload'))
		{
			if(!move_uploaded_file($_FILES['photo_file']['tmp_name'], $uploadUrl))
			{
				$this->photo_uploaded_success = false;
			}
		}
		//exit;
		//added code for logging
		if($this->fp)
		{
			$log_str = ' Photo stored in temp server : '.$uploadUrl."\r\n";
			$this->writetoTempFile($log_str);
		}
	}


	function storeWaterMarkPhoto($original_file_name,$uploadUrl)
	{
		$logo=$this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['watermark_folder'].'/'.$this->CFG['admin']['watermark']['image_name'];
		if(is_file($logo))
		{
			list($ori_width, $ori_height, $ori_type, $ori_attr) = getimagesize($original_file_name);
			list($water_width, $water_height, $water_type, $water_attr) = getimagesize($logo);
		}
		if(is_file($logo) && $water_width < $ori_width && $water_height < $ori_height)
		{
			$image=$original_file_name;
			$markedImage=$uploadUrl;

			//no compute new watermark on same image
			$WaterMark=new  watermarkClass();
			// open classe with logo
			$WaterMark->setLogoFile($logo);
			// set logo's position (optional)
			$WaterMark->setImagePosition($this->CFG['admin']['watermark']['watermark_image_position']);
			// create new image with logo
			if (!$WaterMark->markImageFile ( $image, $markedImage))
			{
				//echo "Error:".$WaterMark->getLastErrror()."\r\n" ;
				$this->photo_uploaded_success = false;
			}
			else
			{
				$log_str = ' Photo stored in temp server : '.$uploadUrl."\r\n";
				$this->writetoTempFile($log_str);
			}
		}
	}

	/**
	 * PhotoUploadLib::checkPhotoAndGetDetails()
	 *
	 * @param integer $photo_id
	 * @return boolean
	 */
	public function checkPhotoAndGetDetails($photo_id)
	{
		$sql = 'SELECT user_id, photo_id, photo_ext, photo_title, photo_server_url, photo_category_id, photo_sub_category_id, photo_tags, '.
				' photo_upload_type, relation_id FROM '.$this->CFG['db']['tbl']['photo'].
				' WHERE photo_id='.$this->dbObj->Param('photo_id').
				' ORDER BY photo_id LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($photo_id));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($row = $rs->FetchRow())
		{
			$this->PHOTO_ID = $row['photo_id'];
			$this->PHOTO_NAME = getPhotoName($this->PHOTO_ID);
			$this->PHOTO_EXT = $row['photo_ext'];
			$this->PHOTO_TITLE = $row['photo_title'];
			$this->PHOTO_SERVER_URL = $row['photo_server_url'];
			$this->PHOTO_UPLOAD_TYPE = $row['photo_upload_type'];
			$this->PHOTO_CATEGORY_ID = $row['photo_category_id'];
			$this->PHOTO_SUB_CATEGORY_ID = $row['photo_sub_category_id'];
			$this->PHOTO_TAGS = $row['photo_tags'];
			$this->PHOTO_RELATION_ID = $row['relation_id'];

			$sql = 'SELECT user_name, email FROM '.$this->CFG['db']['tbl']['users'].
					' WHERE user_id='.$this->dbObj->Param('user_id').' LIMIT 0,1';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($row['user_id']));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if($row = $rs->FetchRow())
				{
					$this->PHOTO_USER_NAME = $row['user_name'];
					$this->PHOTO_USER_EMAIL = $row['email'];
				}
			return true;
		}
		return false;
	}

	/**
	 * PhotoActivate::activatePhotoFile()
	 *
	 * @return boolean
	 **/
	public function activatePhotoFile()
	{

		$dir_photo = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
						$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['folder'].'/'.
							$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['photo_folder'].'/';

		$temp_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
						$this->CFG['temp_media']['folder'].'/'.
							$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['temp_folder'].'/';

		$tempurl =  $temp_dir.$this->PHOTO_NAME;

		$dir_orginal_photo = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
								$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['original_photo_folder'].'/';

		$local_upload = true;
		if($this->getServerDetails())
		{
			dbDisconnect();
			if($FtpObj = new FtpHandler($this->FTP_SERVER,$this->FTP_USERNAME,$this->FTP_PASSWORD))
			{

				if($this->FTP_FOLDER)
				{

					if($FtpObj->changeDirectory($this->FTP_FOLDER))
					{

						$dir_photo = $this->CFG['media']['folder'].'/'.
										$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['folder'].'/'.
											$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['photo_folder'].'/';
						$upload_dir_photo = $dir_photo;

						$FtpObj->makeDirectory($upload_dir_photo);
						$uploadUrlPhoto = $upload_dir_photo.$this->PHOTO_NAME;
						if(is_file($tempurl.'S.'.$this->PHOTO_EXT))
						{
							$FtpObj->moveTo($tempurl.'S.'.$this->PHOTO_EXT, $uploadUrlPhoto.'S.'.$this->PHOTO_EXT);
							unlink($tempurl.'S.'.$this->PHOTO_EXT);
						}
						if(is_file($tempurl.'M.'.$this->PHOTO_EXT))
						{
							$FtpObj->moveTo($tempurl.'M.'.$this->PHOTO_EXT, $uploadUrlPhoto.'M.'.$this->PHOTO_EXT);
							unlink($tempurl.'M.'.$this->PHOTO_EXT);
						}
						if(is_file($tempurl.'T.'.$this->PHOTO_EXT))
						{
							$FtpObj->moveTo($tempurl.'T.'.$this->PHOTO_EXT, $uploadUrlPhoto.'T.'.$this->PHOTO_EXT);
							unlink($tempurl.'T.'.$this->PHOTO_EXT);
						}
						if(is_file($tempurl.'L.'.$this->PHOTO_EXT))
						{
							$FtpObj->moveTo($tempurl.'L.'.$this->PHOTO_EXT, $uploadUrlPhoto.'L.'.$this->PHOTO_EXT);
							unlink($tempurl.'L.'.$this->PHOTO_EXT);
						}
						unlink($tempurl.'.'.$this->PHOTO_EXT);
						$FtpObj->ftpClose();
						$SERVER_URL = $this->FTP_SERVER_URL;
					}
				}
			}
			dbConnect();
			$local_upload = false;
		}
		if($local_upload)
		{
			dbDisconnect();
			$upload_dir_photo = $dir_photo;
			$upload_dir_orginal_photo = $dir_orginal_photo;
			$this->chkAndCreateFolder($upload_dir_photo);
			$uploadUrlPhoto = $upload_dir_photo.$this->PHOTO_NAME;
			if(is_file($tempurl.'S.'.$this->PHOTO_EXT))
			{
				copy($tempurl.'S.'.$this->PHOTO_EXT, $uploadUrlPhoto.'S.'.$this->PHOTO_EXT);
				unlink($tempurl.'S.'.$this->PHOTO_EXT);
			}
			if(is_file($tempurl.'M.'.$this->PHOTO_EXT))
			{
				copy($tempurl.'M.'.$this->PHOTO_EXT, $uploadUrlPhoto.'M.'.$this->PHOTO_EXT);
				unlink($tempurl.'M.'.$this->PHOTO_EXT);
			}
			if(is_file($tempurl.'T.'.$this->PHOTO_EXT))
			{
				copy($tempurl.'T.'.$this->PHOTO_EXT, $uploadUrlPhoto.'T.'.$this->PHOTO_EXT);
				unlink($tempurl.'T.'.$this->PHOTO_EXT);
			}
			if(is_file($tempurl.'L.'.$this->PHOTO_EXT))
			{
				copy($tempurl.'L.'.$this->PHOTO_EXT, $uploadUrlPhoto.'L.'.$this->PHOTO_EXT);
				unlink($tempurl.'L.'.$this->PHOTO_EXT);
			}
			unlink($tempurl.'.'.$this->PHOTO_EXT);
			$SERVER_URL = $this->CFG['site']['url'];
			dbConnect();
		}


		if(isset($SERVER_URL))
		{
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET'.
					' photo_server_url='.$this->dbObj->Param('photo_server_url').','.
					' photo_status=\'Ok\' WHERE'.
					' photo_id='.$this->dbObj->Param('photo_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($SERVER_URL, $this->PHOTO_ID));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET'.
					' total_photos=total_photos+1'.
					' WHERE user_id='.$this->dbObj->Param('user_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->PHOTO_USER_ID));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			return true;
		}
		return false;
	}

	/**
	 * PhotoUploadLib::storeImagesTempServer()
	 *
	 * @param string $uploadUrl
	 * @param string $extern
	 * @return void
	 */
	public function storeImagesTempServer($uploadUrl, $extern)
	{
		//GET LARGE IMAGE
		if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['large_name']=='L')
		{
			if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['large_height'] or $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['large_width'])
			{
				$this->imageObj->resize($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['large_width'], $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['large_height'], '-');
				$this->imageObj->output_resized($uploadUrl.'L.'.$extern, strtoupper($extern));
				$image_info = getImageSize($uploadUrl.'L.'.$extern);
				$this->L_WIDTH = $image_info[0];
				$this->L_HEIGHT = $image_info[1];
			}
			else
			{
				$this->imageObj->output_original($uploadUrl.'L.'.$extern, strtoupper($extern));
				$image_info = getImageSize($uploadUrl.'L.'.$extern);
				$this->L_WIDTH = $image_info[0];
				$this->L_HEIGHT = $image_info[1];
			}
		}

		//GET THUMB IMAGE
		if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['thumb_name']=='T')
		{
			$this->imageObj->resize($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['thumb_width'], $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['thumb_height'], '-');
			$this->imageObj->output_resized($uploadUrl.'T.'.$extern, strtoupper($extern));
			$image_info = getImageSize($uploadUrl.'T.'.$extern);
			$this->T_WIDTH = $image_info[0];
			$this->T_HEIGHT = $image_info[1];
		}

		//GET MEDIUM IMAGE
		if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['medium_name']=='M')
		{
			$this->imageObj->resize($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['medium_width'], $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['medium_height'], '-');
			$this->imageObj->output_resized($uploadUrl.'M.'.$extern, strtoupper($extern));
			$image_info = getImageSize($uploadUrl.'M.'.$extern);
			$this->M_WIDTH = $image_info[0];
			$this->M_HEIGHT = $image_info[1];
		}

		//GET SMALL IMAGE
		if($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['small_name']=='S')
		{
			$this->imageObj->resize($this->CFG['admin'][$this->MEDIA_TYPE_CFG]['small_width'], $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['small_height'], '-');
			$this->imageObj->output_resized($uploadUrl.'S.'.$extern, strtoupper($extern));
			$image_info = getImageSize($uploadUrl.'S.'.$extern);
			$this->S_WIDTH = $image_info[0];
			$this->S_HEIGHT = $image_info[1];
		}

		$wname = $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['large_name'].'_WIDTH';
		$hname = $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['large_name'].'_HEIGHT';
		$this->L_WIDTH = $this->$wname;
		$this->L_HEIGHT = $this->$hname;

		$wname = $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['thumb_name'].'_WIDTH';
		$hname = $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['thumb_name'].'_HEIGHT';
		$this->T_WIDTH = $this->$wname;
		$this->T_HEIGHT = $this->$hname;

		$wname = $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['medium_name'].'_WIDTH';
		$hname = $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['medium_name'].'_HEIGHT';
		$this->M_WIDTH = $this->$wname;
		$this->M_HEIGHT = $this->$hname;

		$wname = $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['small_name'].'_WIDTH';
		$hname = $this->CFG['admin'][$this->MEDIA_TYPE_CFG]['small_name'].'_HEIGHT';
		$this->S_WIDTH = $this->$wname;
		$this->S_HEIGHT = $this->$hname;
	}

	/**
	 * PhotoUploadLib::insertPhotoTable()
	 *
	 * @param array $fields_arr
	 * @param string $err_tip
	 * @return integer
	 */
	public function insertPhotoTable($fields_arr, $err_tip='')
	{
		$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo'].' SET ';
		foreach($fields_arr as $fieldname)
		{
			if($this->fields_arr[$fieldname]!='NOW()')
				$sql .= $fieldname.'=\''.addslashes($this->fields_arr[$fieldname]).'\', ';
			else
				$sql .= $fieldname.'='.$this->fields_arr[$fieldname].', ';
		}
		$sql = substr($sql, 0, strrpos($sql, ','));

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$return = $this->dbObj->Insert_ID();
		return $return;
	}

	/**
	 * PhotoUploadLib::updatePhotoTable()
	 *
	 * @param array $fields_arr
	 * @return void
	 */
	public function updatePhotoTable($fields_arr)
	{
		//$this->setCommonFormFields();
		$param_value_arr = array();
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET ';
		foreach($fields_arr as $fieldname => $value)
		{
			if($this->fields_arr[$fieldname] != 'NOW()')
			{
				$param_value_arr[] = $this->fields_arr[$fieldname];
				$sql .= $fieldname.'='.$this->dbObj->Param($fieldname).', ';
			}
			else
				$sql .= $fieldname.'='.$this->fields_arr[$fieldname].', ';
		}
		$sql = substr($sql, 0, strrpos($sql, ','));
		$sql .= ' WHERE photo_id='.$this->dbObj->Param('photo_id').
				' AND user_id='.$this->dbObj->Param('user_id');
		$this->photo_id = $this->fields_arr['photo_id'];
		$param_value_arr[] = $this->fields_arr['photo_id'];
		$param_value_arr[] = $this->CFG['user']['user_id'];

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, $param_value_arr);

		if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
	}

	/**
	 * PhotoUploadLib::sendMailToUserForDelete()
	 *
	 * @return boolean
	 **/
	public function sendMailToUserForDelete()
	{
		$subject = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $this->LANG['photo_delete_subject']);
		$body = $this->LANG['photo_delete_content'];
		$body = str_replace('VAR_LINK', '<a href=\''.$this->CFG['site']['url'].'\'>'.$this->CFG['site']['url'].'</a>', $body);
		$body = str_replace('VAR_USER_NAME', $this->PHOTO_USER_NAME, $body);
		$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
		$body = str_replace('VAR_PHOTO_TITLE', $this->PHOTO_TITLE, $body);
		$this->buildEmailTemplate($subject,  nl2br($body), false, true);
		$EasySwift = new EasySwift($this->getSwiftConnection());
		$EasySwift->flush();
		$EasySwift->addPart($this->getEmailContent(), "text/html");
		$from_address = $this->CFG['site']['noreply_name'].'<'.$this->CFG['site']['noreply_email'].'>';
		return $EasySwift->send($this->PHOTO_USER_EMAIL, $from_address, $this->getEmailSubject());
	}

	/**
	 * PhotoUploadLib::sendMailToUserForDelete()
	 *
	 * @return boolean
	 **/
	public function sendMailToUserForActivate()
	{
		$subject = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $this->LANG['photo_activate_subject']);
		$body = $this->LANG['photo_activate_content'];
		$photo_link = getUrl('viewphoto','?photo_id='.$this->PHOTO_ID.'&title='.$this->changeTitle($this->PHOTO_TITLE), $this->PHOTO_ID.'/'.$this->changeTitle($this->PHOTO_TITLE).'/', 'root','photo');
		$photo_folder = $this->CFG['site']['url'].$this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
		$photo_src = $photo_folder.$this->PHOTO_NAME.$this->CFG['admin']['photos']['small_name'].'.'.$this->PHOTO_EXT;
		$photo_image = '<a href="'.$photo_link.'"><img border="0" src="'.
													$photo_src.'" alt="'.$this->PHOTO_TITLE.'" title="'.$this->PHOTO_TITLE.'" /></a>';
		$body = str_replace('VAR_THUMB_IMAGE', $photo_image, $body);
		$body = str_replace('VAR_LINK', '<a href=\''.$this->CFG['site']['url'].'\'>'.$this->CFG['site']['url'].'</a>', $body);
		$body = str_replace('VAR_USER_NAME', $this->PHOTO_USER_NAME, $body);
		$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
		$body = str_replace('VAR_PHOTO_TITLE', $this->PHOTO_TITLE, $body);
		$body = str_replace('VAR_PHOTO_LINK', '<a href=\''.$photo_link.'\'>'.$photo_link.'</a>', $body);
		$body=nl2br($body);
		if($this->_sendMail($this->PHOTO_USER_EMAIL, $subject, $body, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']))
			return true;
		else
			return false;
	}

	/**
	 * PhotoUploadLib::chkAlbumName()
	 *
	 * @param string $album_name
	 * @return Integer
	 */
	public function chkAlbumName($album_name)
	{
		$sql = 'SELECT photo_album_id FROM '.$this->CFG['db']['tbl']['photo_album'].
				' WHERE photo_album_title ='.$this->dbObj->Param('photo_album_title');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($album_name));

		if(!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($row = $rs->FetchRow())
		{
			if($rs->PO_RecordCount())
			{
				return $row['photo_album_id'];
			}
		}
		return false;
	}

	/**
	 * PhotoUploadLib::addAlbumName()
	 *
	 * @param string $album_name
	 * @return Integer
	 */
	public function addAlbumName($album_name,$album_type)
	{
		$qurstr = '';
		$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_album'].
				' SET photo_album_title ='.$this->dbObj->Param('photo_album_title').', '.
				' user_id  ='.$this->dbObj->Param('user_id').', '.
				' album_access_type  ='.$this->dbObj->Param('album_access_type').$qurstr;

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($album_name, $this->CFG['user']['user_id'], $album_type));

		if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$albumId = $this->dbObj->Insert_ID();
		return $albumId;
	}

	/**
	 * PhotoUploadLib::chkCategoryName()
	 *
	 * @param string $category_name
	 * @return booleand
	 */
	public function chkCategoryName($category_name)
	{
		$sql = 'SELECT photo_category_id FROM '.$this->CFG['db']['tbl']['photo_category'].
				' WHERE photo_category_name ='.$this->dbObj->Param('photo_category_name');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($category_name));

		if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($rs->PO_RecordCount())
		{
			if($row = $rs->FetchRow())
			{
				return $row['photo_category_id'];
			}

		}
		return false;
	}

	/**
	 * PhotoUploadLib::addCategoryName()
	 *
	 * @param string $category_name
	 * @return Integer
	 */
	public function addCategoryName($category_name)
	{
		$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_category'].
				' SET photo_category_name ='.$this->dbObj->Param('photo_category_name');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($category_name));

		if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$categoryId = $this->dbObj->Insert_ID();
		return $categoryId;
	}

	/**
	 * PhotoUploadLib::arrayToFields()
	 *
	 * @param array $fields_arr
	 * @return void
	 */
	public function arrayToFields($fields_arr)
	{
		foreach($fields_arr as $key => $value)
		{
			$this->setFormField($key, $value);
		}
	}


	/**
	 * PhotoUploadLib::changeTagTable()
	 *
	 * @return void
	 */
	public function changeTagTable()
	{
		$tag_arr = explode(' ', $this->fields_arr['photo_tags']);
		$tag_arr = array_unique($tag_arr);
		if($key = array_search('', $tag_arr))
			unset($tag_arr[$key]);

		foreach($tag_arr as $key=>$value)
		{
			if((strlen($value)<$this->CFG['fieldsize']['photo_tags']['min'])
				or (strlen($value)>$this->CFG['fieldsize']['photo_tags']['max']))
				continue;

			$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_tags'].' SET result_count=result_count+1'.
					' WHERE tag_name='.$this->dbObj->Param('photo_tags');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($value));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if(!$this->dbObj->Affected_Rows())
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_tags'].' SET'.
						' tag_name='.$this->dbObj->Param('photo_tags').', result_count=1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($value));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}
		}
	}
	public function changeTagValueInSubscriptionTable($photo_id)
	{
		$tags = str_replace(' ', ',', $this->fields_arr['photo_tags']);
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['subscription_activity'].' SET tag_name='.$this->dbObj->Param('photo_tags').
					' WHERE content_id='.$this->dbObj->Param('photo_id').' AND module=\'photo\'';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($tags,$photo_id));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
	}

	/**
	 * PhotoActivate::populatePhotoDetails()
	 *
	 * @return boolean
	 **/
	public function populatePhotoDetails()
	{
		$sql = 'SELECT p.photo_title, p.photo_category_id, p.photo_ext,'.
				'p.photo_id, p.t_width, p.t_height,p.photo_caption, '.
				'u.user_name, u.email, u.user_id, relation_id FROM '.
				$this->CFG['db']['tbl']['photo'].' as p LEFT JOIN '.$this->CFG['db']['tbl']['users'].
				' as u ON p.user_id=u.user_id WHERE'.
				' photo_id='.$this->dbObj->Param('photo_id').' LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->PHOTO_ID));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($row = $rs->FetchRow())
		{
			$this->PHOTO_TITLE = $row['photo_title'];
			$this->PHOTO_CATEGORY_ID = $row['photo_category_id'];
			$this->PHOTO_WIDTH = $row['t_width'];
			$this->PHOTO_HEIGHT = $row['t_height'];
			$this->PHOTO_ID = $row['photo_id'];
			$this->PHOTO_USER_NAME = $row['user_name'];
			$this->PHOTO_USER_EMAIL = $row['email'];
			$this->PHOTO_USER_ID = $row['user_id'];
			$this->PHOTO_EXT = $row['photo_ext'];
			$this->PHOTO_RELATION_ID = $row['relation_id'];
			$this->PHOTO_DESCRIPTION =$row['photo_caption'];
			$this->fields_arr['relation_id'] = $row['relation_id'];

			return true;
		}
		return false;
	}
	/**
	 * PhotoUploadLib::getOldPhotoTags()
	 *
	 * @return boolean
	 **/
	public function getOldPhotoTags()
	{
		$sql ='SELECT photo_tags FROM '.$this->CFG['db']['tbl']['photo'].' WHERE photo_id='.$this->dbObj->Param('photo_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
		if (!$rs)
			trigger_db_error($this->dbObj);
		$row = $rs->FetchRow();
		$this->oldTags = $row['photo_tags'];
	}

	/**
	 * PhotoUploadLib::changeTagTableForEdit()
	 *
	 * @return void
	 */
	public function changeTagTableForEdit()
	{
		$tag_arr = explode(' ', $this->fields_arr['photo_tags']);
		$tag_arr = array_unique($tag_arr);
		if($key = array_search('', $tag_arr))
			unset($tag_arr[$key]);

		$oldtag_arr = explode(' ', $this->oldTags);

		foreach($oldtag_arr as $oldTag)
		{
			$sql = 'SELECT photo_id FROM '.$this->CFG['db']['tbl']['photo'].
					' WHERE photo_tags LIKE "% '.$oldTag.' %" AND photo_status!=\'Deleted\'';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array());

			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if(!$rs->PO_RecordCount())
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['photo_tags'].
						' WHERE tag_name='.$this->dbObj->Param('tag_name');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($oldTag));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}
		}
		foreach($tag_arr as $key=>$value)
		{
			if((strlen($value) < $this->CFG['fieldsize']['photo_tags']['min'])
				or (strlen($value)>$this->CFG['fieldsize']['photo_tags']['max']))
				continue;

			$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['photo_tags'].
					' WHERE tag_name = '.$this->dbObj->Param('tag');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($value));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if(!$rs->PO_RecordCount())
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_tags'].' SET'.
						' tag_name='.$this->dbObj->Param('photo_tag').', result_count=1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($value));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}
		}
	}

	/**
	 * PhotoUploadLib::getServerDetails()
	 *
	 * @return boolean
	 */
	public function getServerDetails()
	{
		$cid = $this->PHOTO_CATEGORY_ID.',0';
		$sql = 'SELECT server_url, ftp_server, ftp_folder, category, '.
				' ftp_usrename, ftp_password FROM '.
				$this->CFG['db']['tbl']['server_settings'].
				' WHERE server_for=\'photo\' AND category IN('.$cid.')'.
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

			if($row['category'] == $this->PHOTO_CATEGORY_ID)
				return true;
		}

		if(isset($this->FTP_SERVER) and $this->FTP_SERVER)
			return true;
		return false;
	}

	/**
	 * PhotoUploadLib::updatePhotoImageExt()
	 *
	 * @return boolean
	 */
	public function updatePhotoImageExt()
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET '.
				'l_width='.$this->dbObj->Param('l_width').', l_height='.$this->dbObj->Param('l_height').', '.
				't_width='.$this->dbObj->Param('t_width').', t_height='.$this->dbObj->Param('t_height').', '.
				's_width='.$this->dbObj->Param('s_width').', s_height='.$this->dbObj->Param('s_height').', '.
				'm_width='.$this->dbObj->Param('m_width').', m_height='.$this->dbObj->Param('m_height').' '.
				'WHERE photo_id = '.$this->dbObj->Param('photo_id');

		$stmt = $this->dbObj->Prepare($sql);
		$fields_value_arr = array($this->L_WIDTH, $this->L_HEIGHT,
								$this->T_WIDTH, $this->T_HEIGHT, $this->S_WIDTH, $this->S_HEIGHT,
								$this->M_WIDTH, $this->M_HEIGHT, $this->getFormField('photo_id'));

		$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
		if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		//$this->addPhotoUploadActivity()
		return true;
	}

	/**
	 * PhotoUploadLib::checkIsValidPhoto()
	 *
	 * @param integer $photo_id
	 * @return boolean
	 */
	public function checkIsValidPhoto($photo_id)
	{
		$sql = 'SELECT 1 '.
				' FROM '.$this->CFG['db']['tbl']['photo'].
				' WHERE photo_status=\'Ok\' AND photo_id='.$this->dbObj->Param('photo_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($photo_id));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if(!$rs->PO_RecordCount())
		{
			return false;
		}

		if($row = $rs->FetchRow())
		{
			return true;
		}
	}

	/**
	 * PhotoUploadLib::populatePhotoAlbums()
	 *	To get list of albums for AutoComplete acc to Relevance
	 *
	 * @param string $album
	 * @return array
	 */
	public function populatePhotoAlbums($album)
	{
		$sql = 'SELECT album_title, '.
				'(CASE WHEN `album_title` LIKE \''.$album.'%\' THEN 1 ELSE 0 END) AS relevance1, '.
				'(CASE WHEN `album_title` LIKE \'%'.$album.'%\' THEN 1 ELSE 0 END) AS relevance2 '.
				' FROM '.$this->CFG['db']['tbl']['photo_album'].
				' WHERE album_title LIKE \'%'.$album.'%\' ORDER BY relevance1 DESC, relevance2 DESC';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array());
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if(!$rs->PO_RecordCount())
			return false;

		$album_title = array();
		while($row = $rs->FetchRow())
			{
				$album_title[] = $row['album_title'];
			}
		return $album_title;
	}

	/**
	 * PhotoUploadLib::sendEmailToAll()
	 *
	 * @return boolean
	 */
	public function sendEmailToAll()
	{
		  $this->EMAIL_ADDRESS = array_unique($this->EMAIL_ADDRESS);
		  if($this->EMAIL_ADDRESS)
		  {
			foreach($this->EMAIL_ADDRESS as $email)
			{
				$mailSent = false;
				$photo_folder = $this->CFG['media']['folder'].'/'.
										$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['folder'].'/'.
											$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['photo_folder'].'/';

				if(!empty($this->PHOTO_EXT))
					$photo_url = $this->CFG['site']['url'].$photo_folder.getPhotoName($this->PHOTO_ID).
											$this->CFG['admin']['photos']['thumb_name'].'.'.$this->PHOTO_EXT;
				else
					$photo_url = $this->CFG['site']['url'].'photo/design/templates/'.
												$this->CFG['html']['template']['default'].'/root/images/'.
													$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_photo_T.jpg';
				$photo_image = '<img border="0" src="'.$photo_url.'" alt="'.$this->PHOTO_TITLE.'" title="'.$this->PHOTO_TITLE.'" />';

				$photolink = getUrl('viewphoto','?photo_id='.$this->PHOTO_ID.'&title='.$this->changeTitle($this->PHOTO_TITLE), $this->PHOTO_ID.'/'.$this->changeTitle($this->PHOTO_TITLE).'/','members', 'photo');

				$subject = str_replace('VAR_USER_NAME', $this->CFG['user']['user_name'], $this->LANG['photo_share_subject']);

				$body = str_replace('VAR_USER_NAME', $this->CFG['user']['user_name'], $this->LANG['photo_share_content']);
				$body = str_replace('VAR_PHOTO_IMAGE', '<a href="'.$photolink.'">'.$photo_image.'</a>', $body);
				$body = str_replace('VAR_PHOTO_DESCRIPTION', $this->PHOTO_DESCRIPTION, $body);
				$body = str_replace('VAR_PERSONAL_MESSAGE', '', $body);
				$body = str_replace('VAR_LINK', '<a href=\''.$this->CFG['site']['url'].'\'>'.$this->CFG['site']['url'].'</a>', $body);
				$body = str_replace('VAR_USER_NAME', $this->CFG['user']['user_name'], $body);
				$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
				$body=nl2br($body);
				$is_ok = $this->_sendMail($email, $subject, $body, $this->CFG['user']['name'], $this->CFG['user']['email']);
		   }
			return true;
		}
	}

	/**
	 * PhotoUploadLib::getUploadPhotoServerUrl()
	 *
	 * @return void
	 */
	 public function getUploadPhotoServerUrl($photo_id)
	 {
	 	$sql = 'SELECT photo_server_url FROM '.$this->CFG['db']['tbl']['photo'].
				' WHERE photo_id='.$this->dbObj->Param('photo_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($photo_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($row = $rs->FetchRow())
			return $row['photo_server_url'];
	 }
	 /**
	 * PhotoUploadLib::getUploadPhotoServerUrl()
	 *
	 * @return void
	 */
	 public function sharePhotoDetails($photo_id)
	 {
	 	$this->PHOTO_ID = $photo_id;
	 	$this->populatePhotoDetails();
		$this->getEmailAddressOfRelation($this->PHOTO_RELATION_ID);
		$this->sendEmailToAll();
	 }

	/**
	 * PhotoUploadLib::addPhotoUploadActivity()
	 *
	 * @return void
	 */
	public function addPhotoUploadActivity()
	{
		//Start new photo upload activity
		$sql = 'SELECT u.user_name as upload_user_name, m.photo_id, m.user_id as upload_user_id, '.
		        ' m.photo_title, m.photo_server_url, m.photo_ext FROM '.$this->CFG['db']['tbl']['photo'].
				' as m, '.$this->CFG['db']['tbl']['users'].' as u '.
				' WHERE u.user_id = m.user_id AND m.photo_id='.$this->dbObj->Param('photo_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->PHOTO_ID));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$row = $rs->FetchRow();
		$activity_arr = $row;
		$activity_arr['action_key']	= 'photo_uploaded';
		$photoActivityObj = new PhotoActivityHandler();
		$photoActivityObj->addActivity($activity_arr);

		$content = $activity_arr['upload_user_id'].'~'.
					$activity_arr['upload_user_name'].'~'.
					$activity_arr['photo_id'].'~'.
					$activity_arr['photo_title'].'~'.
					$activity_arr['photo_server_url'].'~'.
					$activity_arr['photo_ext'].'~';

		//Add recod for subscribtions
		$subscription_data_arr['owner_id'] = $this->CFG['user']['user_id'];
		$subscription_data_arr['content_id'] = $this->PHOTO_ID;
		$subscription_data_arr['category_id'] = $this->PHOTO_CATEGORY_ID;
		$subscription_data_arr['sub_category_id'] = $this->PHOTO_SUB_CATEGORY_ID;
		$tags = str_replace(' ', ',', $this->PHOTO_TAGS);
		$subscription_data_arr['tag_name'] = $tags;
		$subscription_data_arr['content'] = $content;
		$this->addSubscriptionData($subscription_data_arr);
		//End..
	}

	/**
	 * PhotoUploadLib::addPhotoMetaData()
	 *@param string $file_name
	 * @return void
	 */
	public function addPhotoMetaData($file_name)
	{
		//call photo medata class
		$metadataObj = new ImageMetaDataClass();
		if($file_name)
		{
			$metadataObj->setFile($file_name);
			$metadataObj->setPhotoMetaDataArray($this->CFG['admin']['photos']['photo_meta_data_array']);
			$meta_data_array=$metadataObj->getPhotoMetaData();
			$meta_data_value ='';
			foreach($meta_data_array as $key => $value)
			{
				if($meta_data_value=='')
					$meta_data_value = $key.'~#'.$value;
				else
					$meta_data_value = $meta_data_value.'#~'.$key.'~#'.$value;
			}
			if(!empty($meta_data_value))
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_meta_data'].
						' SET meta_data ='.$this->dbObj->Param('meta_data').', '.
						' photo_id='.$this->dbObj->Param('photo_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($meta_data_value,$this->PHOTO_ID));

				if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}
			if(!$this->CFG['admin']['photos']['save_original_file_to_download'])
			{
				@unlink($file_name);
			}

		}
		//exit;
		//End..
	}

	/**
	 * PhotoUploadLib::changePhotoTitleInActivityTable()
	 *
	 * @return void
	 */
	public function changePhotoTitleInActivityTable($photo_id, $photo_title)
	{
		$sql = 'SELECT  photo_title FROM '.$this->CFG['db']['tbl']['photo'].
				' WHERE photo_id='.$this->dbObj->Param('photo_id').' AND photo_title != '.$this->dbObj->Param('photo_title');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($photo_id,$photo_title));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		if ($rs->PO_RecordCount()>0)
		{
			$row = $rs->FetchRow();
			$old_photo_title = $row['photo_title'];

			$sql = 'SELECT action_value FROM '.$this->CFG['db']['tbl']['photo_activity'].
				' WHERE action_key = \'photo_uploaded\' AND content_id = '.$this->dbObj->Param('photo_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($photo_id));

			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			$result_set = $rs->FetchRow();
			//Code to replace photo title alone from photo activity action value column
			$old_action_value = array();
			$old_action_value = explode("~", $result_set['action_value']);
			$old_action_value[3] = $photo_title;
			$new_action_value = implode("~", $old_action_value);

			$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_activity'].' SET action_value = '.$this->dbObj->Param('new_action_value').
					' WHERE action_key = \'photo_uploaded\' AND content_id = '.$this->dbObj->Param('photo_id');

			/*$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_activity'].' SET action_value = REPLACE(action_value, '.$this->dbObj->Param('old_photo_title').','.$this->dbObj->Param('new_photo_title').') '.
					' WHERE action_key = \'photo_uploaded\' AND content_id = '.$this->dbObj->Param('photo_id');*/

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($new_action_value, $photo_id));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		}
	}
}
?>
