<?php
set_time_limit(0);
/**
 * File used to upload video
 *
 *
 * @package Rayzz
 * @category General
  **/

/**
 * VideoUpload
 *
 * @package
 * @author vijay_84ag08
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id$
 * @access public
 */

class VideoUpload extends VideoUploadLib
	{
		public $youtube_flv_url = '';
		public $fp = false;
		public $external_video_details_arr = array();

		/**
		 * VideoUpload::populateVideoAlbums()
		 * @purpose to populate videoAlbums in the select box
		 * @param string $err_tip
		 * @return
		 **/
		public function populateVideoAlbums($err_tip='')
			{
				$sql = 'SELECT album_title, video_album_id FROM '.$this->CFG['db']['tbl']['video_album'].
						' WHERE user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if(!$rs->PO_RecordCount())
					return;

				$names = array('album_title');
				$value = 'video_album_id';
				$highlight_value = $this->fields_arr['video_album_id'];

				while($row = $rs->FetchRow())
					{
						$out = '';
						$selected = $highlight_value == $row[$value]?' selected':'';
?>
						<option value="<?php echo $row[$value];?>"<?php echo $selected;?>>
<?php
						foreach($names as $name)
							$out .= $row[$name].' ';
							echo stripslashes($out);?></option>
<?php
					}
			}

		/**
		 * VideoUpload::populateVideoCatagory()
		 * @purpose to populate Video category in the select box
		 * @param string $err_tip
		 * @return
		 **/
		public function populateVideoCatagory($type = 'General', $err_tip='')
		{


				$sql = 'SELECT video_category_id, video_category_name FROM '.
					$this->CFG['db']['tbl']['video_category'].
						' WHERE parent_category_id=0 AND video_category_status=\'Yes\''.
						' AND video_category_type='.$this->dbObj->Param('video_category_type').' AND allow_post=\'Yes\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($type));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if(!$rs->PO_RecordCount())
					return;

				$names = array('video_category_name');
				$value = 'video_category_id';
				$highlight_value = $this->fields_arr['video_category_id'];

				$inc =0;
				while($row = $rs->FetchRow())
				{
						$out = '';
						foreach($names as $name)
						$out .= $row[$name];
						$selected = $highlight_value == $row[$value]?' selected':'';
						?><option value="<?php echo $row[$value];?>" <?php echo $selected;?>><?php echo $out;?></option><?php
				$inc++;
				}
			}
		/*
		 * VideoUpload::populateVideoSubCatagory()
		 * @purpose to populate Video sub category in the select box
		 * @param mixed $cid
		 * @return
		 */
		public function populateVideoSubCatagory($cid)
		{
				$sql = 'SELECT video_category_id, video_category_name FROM '.$this->CFG['db']['tbl']['video_category'].
						' WHERE parent_category_id='.$this->dbObj->Param('parent_category_id').
						' AND video_category_status=\'Yes\' AND allow_post=\'Yes\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cid));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$names = array('video_category_name');
				$value = 'video_category_id';
				$highlight_value = $this->fields_arr['video_sub_category_id'];
				?><select name="video_sub_category_id" id="video_sub_category_id">
					<option value=""><?php echo $this->LANG['common_select_option'];?></option>
				<?php

				while($row = $rs->FetchRow())
					{
						$out = '';
						$selected = $highlight_value == $row[$value]?' selected':'';
						foreach($names as $name)
							$out .= $row[$name].' ';
						?>
						<option value="<?php echo $row[$value];?>"<?if($this->fields_arr['video_sub_category_id']==$row[$value]){ echo " selected";}?>><?php echo $out;?></option>
						<?php
					}
					?></select><?php
			}

		/**
		 * VideoUpload::changeArrayToCommaSeparator()
		 * @purpose converting Array value to comma separator
		 * @param array $arry_value
		 * @return
		 **/
		public function changeArrayToCommaSeparator($arry_value = array())
			{
				return implode(',',$arry_value);
			}

		/**
		 * VideoUpload::insertVideoTable()
		 * @purpose To insert video related fields
		 * @param $fields_arr
		 * @param string $err_tip
		 * @return
		 **/
		public function insertVideoTable($fields_arr, $err_tip='')
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['video'].' SET ';
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
					trigger_db_error($this->dbObj);

				$video_id = $this->dbObj->Insert_ID();
				return $video_id;
			}

		/**
		 * VideoUpload::chkFileNameIsNotEmpty()
		 * @purpose to check whether the file is empty or not
		 * @param string $field_name
		 * @param string $err_tip
		 * @return
		 **/
		public function chkFileNameIsNotEmpty($field_name, $err_tip = '')
			{
				//ECHO 'ECHO FILE EMPTY';
				//PRINT_R($_FILES);
				if(!isset($_FILES[$field_name]['name']) or !$_FILES[$field_name]['name'])
					{
						$this->setFormFieldErrorTip($field_name,$err_tip);
						return false;
					}
				return true;
			}

		/**
		 * VideoUpload::chkValidVideoFileType()
		 * @purpose to check whether the upload video type matched with the admin config video types
		 * @param $field_name
		 * @param string $err_tip
		 * @return
		 **/
		public function chkValidVideoFileType($field_name, $err_tip = '')
			{
				return $this->chkValidFileType($field_name, $this->CFG['admin']['videos']['format_arr'], $err_tip);
			}

		/**
		 * VideoUpload::chkValidImageFileType()
		 * @purpose to check whether the external embeded image is valid file type
		 * @param $field_name
		 * @param string $err_tip
		 * @return
		 **/
		public function chkValidImageFileType($field_name, $err_tip = '')
			{
				$extern = strtolower(substr($_FILES[$field_name]['name'], strrpos($_FILES[$field_name]['name'], '.')+1));

				if (!in_array($extern, $this->CFG['admin']['videos']['image_format_arr']))
					{
						$this->fields_err_tip_arr[$field_name] = $err_tip;
						return false;
					}
				return true;
			}

		/**
		 * VideoUpload::chkValideVideoFileSize()
		 * @purpose to check the upload file is in valid file size
		 * @param $field_name
		 * @param string $err_tip
		 * @return
		 **/
		public function chkValideVideoFileSize($field_name, $err_tip='')
			{
				if($this->CFG['admin']['videos']['max_size'])
					{
						$max_size = $this->CFG['admin']['videos']['max_size']*1024*1024;
						if ($_FILES[$field_name]['size'] > $max_size)
							{
								$this->fields_err_tip_arr[$field_name] = $err_tip;
								return false;
							}
					}
				return true;
			}

		/**
		 * VideoUpload::chkValideImageFileSize()
		 * @purpose to check the upload file is in valid file size
		 * @param $field_name
		 * @param string $err_tip
		 * @return
		 **/
		public function chkValideImageFileSize($field_name, $err_tip='')
			{
				if($this->CFG['admin']['videos']['max_size'])
					{
						$max_size = $this->CFG['admin']['videos']['image_max_size']*1024*1024;
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
		 * @purpose to check whether there is an error in $_FILES[]['error']
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

		/**
		 * VideoUpload::storeVideosTempServer()
		 * @purpose to store video in the temp server
		 * @param $uploadUrl
		 * @param $file_name
		 * @return
		 **/
		public function storeVideosTempServer($uploadUrl)
			{
				//if php file upload
				if($this->isFormPOSTed($_POST, 'upload_video_normal'))
				{
					#MODIFED BELOW LINE TO CHECK WHETHER THE FILE IS UPLOADED OR NOT
					if(!move_uploaded_file($_FILES['video_file']['tmp_name'],$uploadUrl))
					{
						$this->video_uploaded_success=false;
						$log_str = "\r\n".'Video Not sored in the server File error is '.$_FILES['video_file']['error']."\r\n".'File type is '.$_FILES['video_file']['type']."\r\n"."\r\n";
						$this->writetoTempFile($log_str);

					}

				}elseif($this->getFormField('bulkUpload') == 'yes'){//if file upload throughmulti upload SWF
					#MODIFED BELOW LINE TO CHECK WHETHER THE FILE IS UPLOADED OR NOT
					if(!move_uploaded_file($_FILES['video_file']['tmp_name'],$uploadUrl))
					{
						$this->video_uploaded_success=false;
						$log_str = "\r\n".'Video Not sored in the server File error is '.$_FILES['video_file']['error']."\r\n".'File type is '.$_FILES['video_file']['type']."\r\n"."\r\n";
						$this->writetoTempFile($log_str);
					}
				}
				//if flash upload , the file is saved in the upload value name in temp file path
				else
				{
					$extern = $this->fields_arr['file_extern'];
					$temp_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin']['videos']['temp_folder'].'/';
					$temp_file = $temp_dir.$this->fields_arr['upload'].'.'.$extern;
					#MODIFED BELOW LINE TO CHECK WHETHER THE FILE IS UPLOADED OR NOT
					if(file_exists($temp_file))
					{
						copy($temp_file, $uploadUrl);
						unlink($temp_file);
					}
					else
					{
						$this->video_uploaded_success=false;
						$log_str = "\r\n".'Video Not sored in the server File error is '.$_FILES['video_file']['error']."\r\n".'File type is '.$_FILES['video_file']['type']."\r\n"."\r\n";
						$this->writetoTempFile($log_str);

					}
				}
					//added code for logging
				if($this->fp)
				{
					$log_str = ' Video stored in temp server : '.$uploadUrl."\r\n";
					$this->writetoTempFile($log_str);
				}
				//added code for logging
			}

		/**
		 * VideoUpload::getReferrerUrl()
		 * @purpose to set sesion gpukey in the url
		 * @return
		 **/
		 // @todo need to check if this method is needed
		public function getVideoReferrerUrl()
		{
			if(!$this->fields_arr['gpukey'])
			{
				if(isset($_SERVER['HTTP_REFERER']) and !strstr($_SERVER['HTTP_REFERER'],'videoUpload') and !strstr($_SERVER['HTTP_REFERER'],'videoCreateAlbum'))
				{
					$key = substr(md5(microtime()),0,10);
					$_SESSION['gpukey'][$key] = $_SERVER['HTTP_REFERER'];
					$this->fields_arr['gpukey'] = $key;
				}
				else
				{
					$key = substr(md5(microtime()),0,10);
				}
			}
		}

		/**
		 * VideoUpload::redirecturl()
		 *@purpose to rediect the page if the gpukey is not set
		 * @return
		 **/
		public function redirecturl()
			{
				if($this->fields_arr['gpukey'])
					{
						Redirect2URL($_SESSION['gpukey'][$this->fields_arr['gpukey']]);
					}
			}

		/**
		 * VideoUpload::changeVideoStatus()
		 * @purpose to set the video encode status to No for the uploaded videos
		 * @param $video_id
		 * @return
		 **/
		public function changeVideoStatus($video_id)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].' SET video_encoded_status=\'No\''.
						' WHERE video_id='.$this->dbObj->Param('video_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($video_id));
				    if (!$rs)
					   trigger_db_error($this->dbObj);
			}
		// @todo need to check if we are using the concept of albums for videos
		/**
		 * VideoUpload::chkVideoAlbumSelected()
		 * @purpose to check the set the video_album_id if it not present
		 * @return
		 */
		public function chkVideoAlbumSelected()
			{
				if(!$this->fields_arr['video_album_id'])
					{

						$sql = 'SELECT video_album_id FROM '.$this->CFG['db']['tbl']['video_album'].' WHERE'.
								' user_id='.$this->dbObj->Param('user_id').' AND'.
								' album_title='.$this->dbObj->Param('album_title').' LIMIT 0,1';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['video_access_type']));
						    if (!$rs)
							    trigger_db_error($this->dbObj);

						if($row = $rs->FetchRow())
							{
								$this->fields_arr['video_album_id'] = $row['video_album_id'];
							}
						else
							{
								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['video_album'].' SET '.
										' user_id='.$this->dbObj->Param('user_id').','.
										' album_title='.$this->dbObj->Param('album_title').','.
										' album_access_type='.$this->dbObj->Param('album_access_type').','.
										' date_added=NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['video_access_type'], $this->fields_arr['video_access_type']));
								    if (!$rs)
									    trigger_db_error($this->dbObj);

								$this->fields_arr['video_album_id'] = $this->dbObj->Insert_ID();
							}
					}
			}

		/**
		 * VideoUpload::postVideoResponse()
		 * @purpose to insert response video to the video_responses table
		 * @param string $video_resp_id
		 * @param string $video_id
		 * @return
		 */
		public function postVideoResponse($video_resp_id='', $video_id='')
			{
				$sql = ' INSERT INTO  '.$this->CFG['db']['tbl']['video_responses'].' SET  '.
						' video_responses_video_id=\''.$video_id.'\',  '.
						' video_id=\''.$video_resp_id.'\', '.
						' date_added=now() ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

		 		$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].
		 				' SET total_responded = total_responded + 1 '.
		 				' WHERE video_id = '.$this->dbObj->Param('videoid');
		 		$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($video_resp_id));

				return true;
			}

		/**
		 * VideoUpload::chkIsValidExternalViewVideoUrl()
		 * @purpose to check if the external view video url is a valid one and fetch the details needed to download the video from the site
		 * @param mixed $field_name
		 * @return
		 */
		public function chkIsValidExternalViewVideoUrl($field_name)
			{
				//function to check if the external view video url is a valid one and
				//
				$external_obj = new ExternalVideoUrlHandler();
				$full_detail=($this->CFG['admin']['videos']['auto_download_external_video'])?'full':'';
				$this->external_video_details_arr = $external_obj->chkIsValidExternalSite($this->fields_arr[$field_name],$full_detail,$this->CFG);
				if($this->external_video_details_arr['error_message'] != '')
				{
					$this->fields_err_tip_arr[$field_name] = $this->external_video_details_arr['error_message'];
					return false;
				}
				else
					return true;
			}

		/**
		 * VideoUpload::addNewExternalembedVideo()
		 * @purpose to add external Embeded video & to create the thumbnail from the uploaded image
		 * @return
		 */
		public function addNewExternalembedVideo()
			{

				$embed_video_thumb_image_ext ='';
				if($this->fields_arr['flv_upload_type']=='embedcode')
					{

						if($this->isFormPOSTed($_POST, 'upload_video_embed_code'))
							{
								$embed_video_thumb_image_ext = strtolower(substr($_FILES['embed_video_image']['name'], strrpos($_FILES['embed_video_image']['name'], '.')+1));
								$this->setFormField('embed_video_image_ext',$embed_video_thumb_image_ext);
							}
					}
				$this->setFormField('video_ext','');
				$this->setFormField('is_external_embed_video','Yes');
				$this->setFormField('user_id',$this->CFG['user']['user_id']);
				$this->setFormField('date_added','NOW()');
				$this->setFormField('video_encoded_status','Yes');
				$this->setFormField('thumb_name_id',getCurrentFileSettingId('Thumb'));
				$this->setFormField('video_file_name_id',getCurrentFileSettingId('Video'));
				$this->setFormField('trimed_video_name_id',getCurrentFileSettingId('Trimed'));
				$video_status = ($this->CFG['admin']['videos']['video_auto_activate'])?'Ok':'Locked';
				$this->setFormField('video_status',$video_status);
				//$this->setFormField('video_server_url',$this->CFG['site']['url']);
				$this->setFormField('playing_time',$this->fields_arr['embed_playing_time']);
				$this->fields_arr['video_flv_url'] = '';
				$this->setCommonFormFields();

				$this->fields_arr['video_sub_category_id'] = $this->fields_arr['video_sub_category_id']?$this->fields_arr['video_sub_category_id']:0;
				$this->VIDEO_ID=$video_id = $this->insertVideoTable(array('user_id', 'video_album_id','thumb_name_id','video_file_name_id','trimed_video_name_id', 'video_ext', 'video_category_id', 'video_sub_category_id', 'video_title', 'video_caption', 'video_tags', 'video_access_type', 'date_added', 'video_encoded_status', 'allow_comments', 'allow_ratings', 'date_recorded', 'location_recorded', 'country_recorded', 'zip_code_recorded', 'allow_embed', 'relation_id', 'flv_upload_type', 'video_flv_url', 'is_external_embed_video', 'video_external_embed_code', 'embed_video_image_ext', 'video_status', 'video_country', 'video_language', 'allow_response','playing_time','video_page_title','video_meta_keyword','video_meta_description'));

				//process the thumb image and move to server
				if($_FILES['embed_video_image']['tmp_name']!='')
				{

					$image_name = getVideoImageName($video_id);
					$imageObj = new ImageHandler($_FILES['embed_video_image']['tmp_name']);
					$this->setIHObject($imageObj);
					//$dest_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
					$dest_dir = $temp_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin']['videos']['temp_folder'].'/';
					$this->chkAndCreateFolder($dest_dir);
					$dest_file = $dest_dir.'/'.$image_name;
					$this->storeImagesTempServer($dest_file, $embed_video_thumb_image_ext);
				}
				if($video_id!='')
				{
					$this->video_uploaded_success = true;
				}else{
					$this->video_uploaded_success = false;
				}
				if($this->CFG['admin']['videos']['video_auto_activate'])
					{
						if($this->populateVideoDetails())
						{
							$this->activateExternalEmbededImage($video_id);
						}

					}

				return $video_id;
			}

		/**
		 * VideoUpload::addNewVideo()
		 * @purpose to process the uploaded video & calling inservideotable to store the video details
		 * @return
		 */
		public function addNewVideo()
			{
				//set the file type in the form field video_ext
				//if normal file upload, take it from the FILES array
				// if swf upload, it will be set in the hidden form field via javascript
				if($this->fields_arr['flv_upload_type']=='Normal')
					{
						if($this->isFormPOSTed($_POST, 'upload_video_normal'))
							{
								$extern = strtolower(substr($_FILES['video_file']['name'], strrpos($_FILES['video_file']['name'], '.')+1));
							}
						else
							{
								$extern = $this->fields_arr['file_extern'];
							}
						$this->setFormField('video_ext',$extern);
					}
				elseif($this->fields_arr['flv_upload_type'] == 'MultiUpload'){
					$extern = strtolower(substr($_FILES['video_file']['name'], strrpos($_FILES['video_file']['name'], '.')+1));
					$this->fields_arr['flv_upload_type'] = 'Normal';
					$this->fields_arr['file_extern']     = $extern;
					$expldeArr = explode($extern, $_FILES['video_file']['name']);
					$this->fields_arr['upload']          = substr($expldeArr[0],0,-1);
					$this->setFormField('video_ext',$extern);
				}
				else
					{
						$extern = 'flv';
						$this->setFormField('video_ext','flv');
					}

				$this->setFormField('user_id',$this->CFG['user']['user_id']);
				$this->setFormField('date_added','NOW()');
				$this->setFormField('video_encoded_status','Partial');
				$this->setFormField('thumb_name_id',getCurrentFileSettingId('Thumb'));
				$this->setFormField('video_file_name_id',getCurrentFileSettingId('Video'));
				$this->setFormField('trimed_video_name_id',getCurrentFileSettingId('Trimed'));

				$this->setCommonFormFields();

				$this->fields_arr['video_flv_url'] = '';
				$this->fields_arr['form_upload_type'] = 'Normal';
				//@todo Need to add a field in the video table to store the method used
				if($this->fields_arr['flv_upload_type']=='externalsitevideourl' )
					{
						//set this value only when the video is to be fetched from the external site
						//and played in ours
						//$this->fields_arr['video_flv_url'] = $this->external_video_details_arr['external_video_flv_path'];
						$this->fields_arr['external_site_flv_path'] = $this->external_video_details_arr['external_video_flv_path'];
						$this->fields_arr['form_upload_type'] = 'externalsitevideourl';
						$this->fields_arr['video_flv_url'] = $this->external_video_details_arr['video_flv_path'];
					}
				if($this->fields_arr['flv_upload_type']=='Capture')
					{
						//$capture_flv = true;
						//no need to set as Normal, let it be capture
						//$this->fields_arr['flv_upload_type']='Normal';
						$this->fields_arr['form_upload_type'] = 'capture';
					}
				$this->fields_arr['video_sub_category_id'] = $this->fields_arr['video_sub_category_id']?$this->fields_arr['video_sub_category_id']:0;
				//set the values for the newly added fields -- external_site_video_url, form_upload_type, external_site_flv_path
				$this->fields_arr['external_site_video_url'] = $this->fields_arr['externalsite_viewvideo_url'] ;

				$video_id = $this->insertVideoTable(array('user_id','video_album_id','thumb_name_id','video_file_name_id','trimed_video_name_id','video_ext','video_category_id', 'video_sub_category_id','video_title','video_caption','video_tags','video_access_type','date_added','video_encoded_status','allow_comments','allow_ratings','date_recorded','location_recorded','country_recorded','zip_code_recorded','allow_embed','relation_id', 'flv_upload_type', 'video_flv_url', 'external_site_video_url','form_upload_type','external_site_flv_path', 'video_country', 'video_language', 'allow_response','video_page_title','video_meta_keyword','video_meta_description'));
				//added code for logging
				if($this->fp)
					{
						$log_str = ' Video  Record created : '.$video_id."\r\n";
						$this->writetoTempFile($log_str);
					}
				//added code for logging
				if($this->fields_arr['use_vid'])
					$this->postVideoResponse($this->fields_arr['use_vid'], $video_id);

			/*	if(isset($capture_flv))
					{
						$this->fields_arr['flv_upload_type']='Capture';
					}*/

				if(!$this->CFG['admin']['tagcloud_based_search_count'])
					$this->changeTagTable();


				$video_name = getVideoName($video_id);
				$temp_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin']['videos']['temp_folder'].'/';
				$this->chkAndCreateFolder($temp_dir);
				dbDisconnect();
				$temp_file = $temp_dir.$video_name.'.'.$extern;

				if($this->fields_arr['flv_upload_type']=='Normal')
					{
						$this->storeVideosTempServer($temp_file);
					}
				else if($this->fields_arr['flv_upload_type']=='externalsitevideourl' && $this->CFG['admin']['videos']['auto_download_external_video'])
					{
						$log_str = ' GETING FILES FROM  : '.$this->external_video_details_arr['external_video_flv_path']."\r\n";

						$this->writetoTempFile($log_str);
						$page_source = fileGetContentsManual($this->external_video_details_arr['external_video_flv_path']);
						if($page_source)
						{
								$log_str = ' STORING TO  : '.$temp_file."\r\n";
								$this->writetoTempFile($log_str);
								$this->fileWrite($temp_file, $page_source);
						}
						else
						{
							$log_str = ' Could Not download flv FROM : '.$this->external_video_details_arr['external_video_flv_path']."\r\n";
							$this->writetoTempFile($log_str);
						}
					}
				else if($this->fields_arr['flv_upload_type']=='Capture')
					{
						$file_name = $this->CFG['admin']['video']['red5_flv_path'].$this->fields_arr['upload'].'.flv';
						if(preg_match('/http/',$file_name))
						{
							$source = fileGetContentsManual($file_name);
							$fp=fopen($temp_file,'W');
							if($fp)
							{
								fwrite($fp,$source);
								fclose($fp);
							}
						}
						else
						{
						copy($file_name, $temp_file);
						unlink($file_name);
						}
						$this->fields_arr['flv_upload_type']='Normal';
					}
				dbConnect();
				//video_encoded_status will be set to No
				$this->changeVideoStatus($video_id);

				if(($this->CFG['admin']['videos']['video_auto_encode'] AND $this->fields_arr['flv_upload_type']!='externalsitevideourl' )or (strtolower($extern)=='flv' AND $this->CFG['admin']['videos']['allow_watermark_in_video']) )
					{
						//added code for logging
						if($this->fp)
							{
								$log_str = ' Calling Video Encode \r\n';
								$this->writetoTempFile($log_str);
							}
						$this->videoEncode($video_id);
					}
					else if(($this->fields_arr['flv_upload_type']=='externalsitevideourl' && $this->CFG['admin']['videos']['auto_download_external_video']))
					{

							if($this->fp)
							{
								$log_str = ' Calling Video Encode \r\n';
								$this->writetoTempFile($log_str);
							}
							$this->videoEncode($video_id);
					}
			}

		/**
		 * VideoEdit::updateVideoTableForEdit()
		 * @purpose to update the Video table while editing the values
		 * @param $fields_arr
		 * @param string $err_tip
		 * @return
		 **/
		public function updateVideoTableForEdit($fields_arr, $err_tip='')
			{
				$this->setCommonFormFields();

				$add = '';
				if(!$this->CFG['admin']['is_logged_in'])
					$add =' AND user_id=\''.$this->CFG['user']['user_id'].'\'';

				 $sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].' SET ';
				$param_array = array();
				foreach($fields_arr as $fieldname)
					{
						if($this->fields_arr[$fieldname]!='NOW()')
							{
								$param_array[] = $this->fields_arr[$fieldname];
								$sql .= $fieldname.'='.$this->dbObj->Param($fieldname).', ';
							}
						else
							$sql .= $fieldname.'='.$this->fields_arr[$fieldname].', ';
					}
				$sql = substr($sql, 0, strrpos($sql, ','));
				$sql .= ' WHERE video_id='.$this->dbObj->Param('video_id').$add;
				$param_array[] = $this->fields_arr['video_id'];
				//echo $sql,'<br><br>';die();
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($param_array));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
			}

		/**
		 * VideoUpload::getVideoCategroyType()
		 * @purpose to get video category type
		 * @param mixed $video_category_id
		 * @return
		 */
		public function getVideoCategroyType($video_category_id)
			{
				$sql = 'SELECT video_category_type FROM '.$this->CFG['db']['tbl']['video_category'].
						' WHERE video_category_id='.$this->dbObj->Param('video_category_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($video_category_id));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->fields_arr['video_category_type'] = $row['video_category_type'];
					}
			}

		/**
		 * VideoUpload::populateVideoDetailsForResponse()
		 * @purpose to populate video details of the response Video
		 * @param mixed $video_id
		 * @return
		 */
		public function populateVideoDetailsForResponse($video_id)
			{
				$add = '';
				$sql = 'SELECT user_id, relation_id,video_album_id, video_title, video_ext, video_caption, video_tags, video_access_type,'.
						' video_server_url, t_width, t_height,video_category_id, video_sub_category_id, allow_comments, allow_ratings, date_recorded,'.
						' location_recorded,country_recorded,zip_code_recorded,allow_embed, video_country, video_language, allow_response'.
						' FROM '.$this->CFG['db']['tbl']['video'].' WHERE video_status=\'Ok\''.$add.
						' AND video_id='.$this->dbObj->Param('video_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($video_id));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->fields_arr['video_title'] = $row['video_title'];
						$this->fields_arr['video_caption'] = $row['video_caption'];
						$this->fields_arr['video_tags'] = $row['video_tags'];
						$this->fields_arr['video_access_type'] = $row['video_access_type'];

						if($row['relation_id'])
							$this->fields_arr['relation_id'] = explode(',',$row['relation_id']);

						$this->fields_arr['video_sub_category_id'] = $row['video_sub_category_id'];
						$this->fields_arr['video_category_id'] = $row['video_category_id'];
						$this->fields_arr['allow_comments'] = $row['allow_comments'];
						$this->fields_arr['allow_ratings'] = $row['allow_ratings'];
						if(chkAllowedModule(array('content_filter')))
							{
								$this->getVideoCategroyType($row['video_category_id']);
							}
						return true;
					}
				return false;
			}

		/**
		 * VideoEdit::populateVideoDetailsForEdit()
		 * @purpose to populate video details for the edit
		 * @return
		 **/
		public function populateVideoDetailsForEdit()
			{
				$add = '';
				if(!$this->CFG['admin']['is_logged_in'])
					$add =' AND user_id=\''.$this->CFG['user']['user_id'].'\'';

				$sql = 'SELECT user_id, relation_id,video_album_id, video_title, video_ext, video_caption, video_tags, video_access_type,'.
						' video_server_url, t_width, t_height,video_category_id, video_sub_category_id, allow_comments, allow_ratings, date_recorded,'.
						' location_recorded,country_recorded,zip_code_recorded,allow_embed,is_external_embed_video,embed_video_image_ext, video_country,'.
						' video_language, allow_response, video_page_title,video_meta_keyword ,video_meta_description'.
						' FROM '.$this->CFG['db']['tbl']['video'].' WHERE video_status=\'Ok\''.$add.
						' AND video_id='.$this->dbObj->Param('video_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->fields_arr['video_album_id'] = $row['video_album_id'];
						$this->fields_arr['video_ext'] = $row['video_ext'];
						$this->fields_arr['video_server_url'] = $row['video_server_url'];
						$this->fields_arr['t_width'] = $row['t_width'];
						$this->fields_arr['t_height'] = $row['t_height'];
						$this->fields_arr['video_title'] = $row['video_title'];
						$this->fields_arr['video_caption'] = $row['video_caption'];
						$this->fields_arr['video_tags'] = $row['video_tags'];
						$this->fields_arr['video_access_type'] = $row['video_access_type'];
						$this->fields_arr['video_country'] = $row['video_country'];
						$this->fields_arr['video_language'] = $row['video_language'];
						$this->fields_arr['allow_response'] = $row['allow_response'];

						## Added For Embeded Video
						$this->fields_arr['is_external_embed_video'] = $row['is_external_embed_video'];
						$this->fields_arr['embed_video_image_ext'] = $row['embed_video_image_ext'];
						if($row['relation_id'])
							$this->fields_arr['relation_id'] = explode(',',$row['relation_id']);

						$this->fields_arr['video_sub_category_id'] = $row['video_sub_category_id'];
						$this->fields_arr['video_category_id'] = $row['video_category_id'];
						$this->fields_arr['allow_comments'] = $row['allow_comments'];
						$this->fields_arr['allow_ratings'] = $row['allow_ratings'];
						$this->fields_arr['location'] = $row['location_recorded'];
						$this->fields_arr['country'] = $row['country_recorded'];
						$this->fields_arr['zip_code'] = $row['zip_code_recorded'];
						$this->fields_arr['allow_embed'] = $row['allow_embed'];

						$date_recorded = $row['date_recorded'];
						$date_recorded = explode('-',$date_recorded);
						$this->fields_arr['year'] = $date_recorded[0];
						$this->fields_arr['month'] = $date_recorded[1];
						$this->fields_arr['day'] = $date_recorded[2];
						$this->fields_arr['video_page_title'] = $row['video_page_title'];
						$this->fields_arr['video_meta_keyword'] = $row['video_meta_keyword'];
						$this->fields_arr['video_meta_description'] = $row['video_meta_description'];
						if(chkAllowedModule(array('content_filter')))
							{
								$this->getVideoCategroyType($row['video_category_id']);
							}
						if($this->CFG['admin']['is_logged_in'])
							$this->CFG['user']['user_id'] = $row['user_id'];
						return true;
					}
				return false;
			}

		/**
		 * VideoUpload::resetFieldsArray()
		 * @purpose to reset all the fields
		 * @return
		 */
		public function resetFieldsArray()
			{
				$this->setFormField('video_id', '');
				$this->setFormField('video_album_id', '');
				$this->setFormField('album_id', '');
				$this->setFormField('flv_upload_type', 'Normal');
				$this->setFormField('video_file', '');
				$this->setFormField('externalsite_viewvideo_url', '');
				$this->setFormField('video_other', '');
				$this->setFormField('animated_gif', '');
				$this->setFormField('video_category_id_general', '');
				$this->setFormField('video_category_id_porn', '');
				$this->setFormField('video_category_id', '');
				$this->setFormField('video_sub_category_id', '');
				$this->setFormField('video_title', '');
				$this->setFormField('video_caption', '');
				$this->setFormField('video_tags', '');
				$this->setFormField('gpukey', '');
				$this->setFormField('video_access_type', 'Public');
				$this->setFormField('month', '');
				$this->setFormField('day', '');
				$this->setFormField('year', '');
				$this->setFormField('location', '');
				$this->setFormField('country', '');
				$this->setFormField('zip_code', '');
				$this->setFormField('video_access_type', 'Public');
				$this->setFormField('allow_comments', 'Yes');
				$this->setFormField('allow_ratings', 'Yes');
				$this->setFormField('allow_embed', 'Yes');
				$this->setFormField('relation_id',array());
				$this->setFormField('upload', '');
				$this->setFormField('video_server_url', '');
				$this->setFormField('t_width', '');
				$this->setFormField('t_height', '');
				$this->setFormField('video_category_type', 'General');
				$this->setFormField('file_extern', '');
				$this->setFormField('cid', '');
				$this->setFormField('ajax_page','');
				$this->setFormField('use_vid','');
				$this->setFormField('external_site_flv_path','');
				$this->setFormField('form_upload_type','');
				$this->setFormField('upload_video_embed_code','');
				$this->setFormField('is_external_embed_video','No');
				$this->setFormField('embed_video_image_ext','');
				$this->setFormField('embed_video_image','');
				$this->setFormField('embed_playing_time','');
				$this->setFormField('video_external_embed_code','');
				$this->setFormField('video_country', '');
				$this->setFormField('video_language', '');
				$this->setFormField('allow_response', 'Yes');
				$this->setFormField('bulkUpload', '');
				$this->setFormField('video_page_title', '');
				$this->setFormField('video_meta_keyword', '');
				$this->setFormField('video_meta_description', '');
			}

		/**
		 * VideoUpload::validationFormFields1()
		 * @purpose to validate , Video category id, video title & video tags
		 * @return
		 */
		public function validationFormFields1()
			{
				$this->chkIsNotEmpty('video_category_id', $this->LANG['common_err_tip_compulsory']);
				$this->chkIsNotEmpty('video_title', $this->LANG['common_err_tip_compulsory']);
				$this->chkIsNotEmpty('video_tags', $this->LANG['common_err_tip_compulsory']) and
					$this->chkValidTagList('video_tags','tags',$this->LANG['common_err_tip_invalid_tag']);

				$video_page_title_status = $video_meta_keyword_status =
										$video_meta_description_status = true;

				if(!empty($this->fields_arr['video_page_title']))
					$video_page_title_status = $this->chkIsValidMaxSize('video_page_title',
														'video_page_title', $this->LANG['common_err_tip_invalid_max_character_size']);

				if(!empty($this->fields_arr['video_meta_keyword']))
					$video_meta_keyword_status = $this->chkIsValidMaxSize('video_meta_keyword',
														'video_meta_keyword', $this->LANG['common_err_tip_invalid_max_character_size']);

				if(!empty($this->fields_arr['video_meta_description']))
					$video_meta_description_status = $this->chkIsValidMaxSize('video_meta_description',
														'video_meta_description', $this->LANG['common_err_tip_invalid_max_character_size']);

				if(!$video_page_title_status or !$video_meta_keyword_status or !$video_meta_description_status)
					$this->other_upload_option_display = '';
			}

		/**
		 * VideoUpload::chkIsEditMode()
		 * @purpose to check whether this is Edit Video Page
		 * @return
		 */
		public function chkIsEditMode()
			{
				if($this->fields_arr['video_id'])
					return true;
				return false;
			}

		/**
		 * VideoUpload::setCommonFormFields()
		 * @purpose to set common fields
		 * @return
		 */
		public function setCommonFormFields()
			{
				$this->setFormField('location_recorded', $this->getFormField('location'));
				$this->setFormField('country_recorded', $this->getFormField('country'));
				$this->setFormField('zip_code_recorded', $this->getFormField('zip_code'));
				$this->setFormField('date_recorded', $this->getFormField('year').'-'.$this->getFormField('month').'-'.$this->getFormField('day'));

				if($this->getFormField('video_access_type')=='Private')
					{
						$relation_id = implode(',',$this->getFormField('relation_id'));
						$this->setFormField('relation_id',$relation_id);
					}
				else
					$this->setFormField('relation_id','');
			}

		/**
		 * VideoUpload::changeTagTable()
		 * @purpose to insert tag to video tag table
		 * @return
		 */
		public function changeTagTable()
			{
				$tag_arr = explode(' ', $this->fields_arr['video_tags']);
				$tag_arr = array_unique($tag_arr);
				if($key = array_search('', $tag_arr))
					unset($tag_arr[$key]);

				foreach($tag_arr as $key=>$value)
					{
						if((strlen($value)<$this->CFG['fieldsize']['tags']['min']) or (strlen($value)>$this->CFG['fieldsize']['tags']['max']))
							continue;

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['tags_video'].' SET result_count=result_count+1'.
								' WHERE tag_name=\''.addslashes($value).'\'';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						    if (!$rs)
							    trigger_db_error($this->dbObj);

						if(!$this->dbObj->Affected_Rows())
							{
								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['tags_video'].' SET'.
										' tag_name=\''.addslashes($value).'\', result_count=1';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								    if (!$rs)
									    trigger_db_error($this->dbObj);
							}
					}
			}


		/**
		 * VideoUpload::changeTagTableForEdit()
		 * @purpose to change
		 * @return
		 */
		public function changeTagTableForEdit()
			{
				$tag_arr = explode(' ', $this->fields_arr['video_tags']);
				$tag_arr = array_unique($tag_arr);
				if($key = array_search('', $tag_arr))
					unset($tag_arr[$key]);

				$oldtag_arr = explode(' ', $this->oldTags);

				foreach($oldtag_arr as $oldTag)
				{
					$sql ='SELECT video_id FROM '.$this->CFG['db']['tbl']['video'].' WHERE video_tags LIKE "% '.$oldTag.' %" AND video_status!=\'Deleted\'';
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array());

					if (!$rs)
						trigger_db_error($this->dbObj);

					if(!$rs->PO_RecordCount())
					{
						$sql_delete='DELETE FROM '.$this->CFG['db']['tbl']['tags_video'].' WHERE tag_name='.$this->dbObj->Param('tag_name');
						$stmt_delete = $this->dbObj->Prepare($sql_delete);
						$rs_delete = $this->dbObj->Execute($stmt_delete, array($oldTag));
						if (!$rs_delete)
							trigger_db_error($this->dbObj);
					}

				}
				foreach($tag_arr as $key=>$value)
					{
						if((strlen($value)<$this->CFG['fieldsize']['tags']['min']) or (strlen($value)>$this->CFG['fieldsize']['tags']['max']))
							continue;

						$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['tags_video'].
								' WHERE tag_name=\''.addslashes($value).'\'';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						    if (!$rs)
							    trigger_db_error($this->dbObj);

						if(!$rs->PO_RecordCount())
							{
								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['tags_video'].' SET'.
										' tag_name=\''.addslashes($value).'\', result_count=1';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								    if (!$rs)
									    trigger_db_error($this->dbObj);
							}
					}
			}



		/**
		 * VideoUpload::storeDatasInSession()
		 * @purpose to store video details in the session
		 * @return
		 */
		public function storeDatasInSession()
			{
				$key = microtime().'_'.$this->CFG['user']['user_id'];
				$key = substr(md5($key),0,10);
				//$key = 'selva';
				if($_POST['video_category_id_general'])
					$_POST['video_category_id']=$_POST['video_category_id_general'];
				else
				$_POST['video_category_id']=$_POST['video_category_id_porn'];
				$temp = $_POST;
				if(isset($temp['upload_video_external']))
					unset($temp['upload_video_external']);
				if(isset($temp['upload_video_external_google']))
					unset($temp['upload_video_external_google']);
				if(isset($temp['upload_video_capture']))
					unset($temp['upload_video_capture']);
				if(isset($temp['upload_video_file']))
					unset($temp['upload_video_file']);

				$_SESSION['video_details'][$key] = serialize($temp);

				return $key;
			}


		/**
		 * VideoUpload::retriveSessionDatas()
		 * @purpose to retrive video details from the session
		 * @return
		 */
		public function retriveSessionDatas()
			{
				if(isset($_SESSION['video_details'][$this->fields_arr['upload']]))
					{
						if(isset($_POST))
							$_POST = array_merge($_POST, unserialize($_SESSION['video_details'][$this->fields_arr['upload']]));
						else
							$_POST = unserialize($_SESSION['video_details'][$this->fields_arr['upload']]);
					}
				return $this->fields_arr['upload'];
			}


		/**
		 * VideoUpload::unsetSessionDatas()
		 * @purpose to unset session data
		 * @return
		 */
		public function unsetSessionDatas()
			{
				if(isset($_SESSION['video_details'][$this->fields_arr['upload']]))
					unset($_SESSION['video_details'][$this->fields_arr['upload']]);
				## unset the POST after the Success of Video Insert
				unset($_POST);
			}


		/**
		 * VideoUpload::chkIsValidCaptureFile()
		 * @purpose to check The captured video file is valid
		 * @return
		 */
		public function chkIsValidCaptureFile()
			{
				$file_name = $this->CFG['admin']['video']['red5_flv_path'].$this->fields_arr['upload'].'.flv';
				if(is_file($file_name))
					return true;
				return false;
			}


		/**
		 * VideoUpload::chkIsFile()
		 * @purpose to check the upload file is a valid file
		 * @param mixed $err_tip
		 * @return
		 */
		public function chkIsFile($err_tip)
			{
				if(isset($this->fields_arr['file_extern']))
					{
						$this->fields_arr['file_extern'] = strtolower($this->fields_arr['file_extern']);
						$extern = $this->fields_arr['file_extern'];
						$temp_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin']['videos']['temp_folder'].'/';
						$temp_file = $temp_dir.$this->fields_arr['upload'].'.'.$extern;

						if(is_file($temp_file))
							{
								return true;
							}
					}
				$this->setFormFieldErrorTip('video_file',$err_tip);
				return false;
			}

		/**
		 * AdvanceSearchHandler::setRayzzHandler()
		 *
		 * @param mixed $rayzz
		 * @return
		 */
		public function setVideoActivityHandler($rayzz = null)
			{
				$this->rayzzObj = $rayzz;
			}

		public function getOldVideoTags()
		{
			$sql ='SELECT video_tags FROM '.$this->CFG['db']['tbl']['video'].' WHERE video_id='.$this->dbObj->Param('video_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
			if (!$rs)
				trigger_db_error($this->dbObj);
			$row = $rs->FetchRow();
			$this->oldTags = $row['video_tags'];
		}

	public function loadFilesForSwfUpload(){
		global $CFG;
		$maxSize = $CFG['admin']['videos']['max_size'].' MB';
		$fileTypes = implode(';',$CFG['admin']['videos']['format_arr']);
		$fileTypes = '*.'.$fileTypes;
		$fileTypes = str_replace(";",";*.",$fileTypes);
		$uploadUrl = $CFG['site']['url'].'members/videoUploadPopUp.php?bulkUpload=yes';
		$videoFileName = 'video_file';
		$imgPath = $CFG['site']['url'] . 'design/templates/' . $CFG['html']['template']['default'] .'/images/';
?>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->CFG['site']['url'];?>css/uploader.css" />

		<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/SWFUpload/swfupload.js"></script>
		<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/SWFUpload/plugins/swfupload.swfobject.js"></script>
		<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/SWFUpload/others/fileprogress.js"></script>
		<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/SWFUpload/others/handlersVideoUpload.js"></script>
		<script type="text/javascript">
			var SITE_URL = "<?php echo $this->CFG['site']['url'];?>";
			var swfu;
			var postParamsVideo = new Array();
			var imgPath = "<?php echo $imgPath;?>";

			postParamsVideo['PHPSESSID'] 				 = "<?php echo isset($_COOKIE['PHPSESSID'])?$_COOKIE['PHPSESSID']:''; ?>";
			postParamsVideo['use_vid']   				 = "<?php echo isset($_POST['use_vid'])?$_POST['use_vid']:''; ?>";
			postParamsVideo['video_album_id']   		 = "<?php echo isset($_POST['video_album_id'])?$_POST['video_album_id']:''; ?>";
			postParamsVideo['video_title']  			 = "<?php echo isset($_POST['video_title'])?$_POST['video_title']:''; ?>";
			postParamsVideo['video_caption']   			 = "<?php echo isset($_POST['video_caption'])?$_POST['video_caption']:''; ?>";
			postParamsVideo['video_tags']   			 = "<?php echo isset($_POST['video_tags'])?$_POST['video_tags']:''; ?>";
			postParamsVideo['video_category_type']   	 = "<?php echo isset($_POST['video_category_type'])?$_POST['video_category_type']:''; ?>";
			postParamsVideo['video_category_id_general'] = "<?php echo isset($_POST['video_category_id_general'])?$_POST['video_category_id_general']:''; ?>";
			postParamsVideo['video_category_id_porn']    = "<?php echo isset($_POST['video_category_id_porn'])?$_POST['video_category_id_porn']:''; ?>";
			postParamsVideo['video_sub_category_id']     = "<?php echo isset($_POST['video_sub_category_id'])?$_POST['video_sub_category_id']:''; ?>";
			postParamsVideo['video_country']   			 = "<?php echo isset($_POST['video_country'])?$_POST['video_country']:''; ?>";
			postParamsVideo['video_language']   		 = "<?php echo isset($_POST['video_language'])?$_POST['video_language']:''; ?>";
			postParamsVideo['video_access_type']  		 = "<?php echo isset($_POST['video_access_type'])?$_POST['video_access_type']:''; ?>";
			postParamsVideo['allow_comments']   		 = "<?php echo isset($_POST['allow_comments'])?$_POST['allow_comments']:''; ?>";
			postParamsVideo['allow_ratings']   			 = "<?php echo isset($_POST['allow_ratings'])?$_POST['allow_ratings']:''; ?>";
			postParamsVideo['allow_embed']   			 = "<?php echo isset($_POST['allow_embed'])?$_POST['allow_embed']:''; ?>";
			postParamsVideo['allow_response']   		 = "<?php echo isset($_POST['allow_response'])?$_POST['allow_response']:''; ?>";
			postParamsVideo['upload_video_file']   		 = "<?php echo isset($_POST['upload_video_file'])?$_POST['upload_video_file']:''; ?>";
			postParamsVideo['flv_upload_type']   		 = "<?php echo isset($_POST['flv_upload_type'])?$_POST['flv_upload_type']:''; ?>";
			postParamsVideo['video_category_id']   		 = "<?php echo isset($_POST['video_category_id'])?$_POST['video_category_id']:''; ?>";
			postParamsVideo['video_page_title']   		 = "<?php echo isset($_POST['video_page_title'])?$_POST['video_page_title']:''; ?>";
			postParamsVideo['video_meta_keyword']   	 = "<?php echo isset($_POST['video_meta_keyword'])?$_POST['video_meta_keyword']:''; ?>";
			postParamsVideo['video_meta_description']	 = "<?php echo isset($_POST['video_meta_description'])?$_POST['video_meta_description']:''; ?>";


			window.onload = function () {
				getFlashUploader("<?php echo $uploadUrl;?>","<?php echo $videoFileName;?>","<?php echo $fileTypes;?>","<?php echo $maxSize;?>",postParamsVideo);
			};
		</script>
<?php
	}

	}
//<<<<<-------------- Class VideoUpload begins ---------------//
//-------------------- Code begins -------------->>>>>//

$VideoUpload = new VideoUpload();
$VideoUpload->setDBObject($db);
$VideoUpload->makeGlobalize($CFG,$LANG);
$VideoUpload->setMediaPath('../');
$VideoUpload->video_uploaded_success = true;
if(!chkAllowedModule(array('video')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$VideoUpload->videoupload_msg_success_uploaded = ($CFG['admin']['videos']['video_auto_encode']
													and $CFG['admin']['videos']['video_auto_activate'])?
														$LANG['videoupload_msg_success_uploaded_auto']:
														  $LANG['msg_success_uploaded_admin'];

$VideoUpload->LANG_COUNTRY_ARR = $LANG_LIST_ARR['countries'];
$VideoUpload->LANG_LANGUAGE_ARR = $LANG_LIST_ARR['language'];

$VideoUpload->setPageBlockNames(array('msg_form_error', 'msg_form_success', 'video_upload_form',
								'video_upload_form_file', 'video_upload_form_external', 'video_upload_form_capture',
								'video_upload_form_external_google','upload_video_embed_code_form','form_show_sub_category'));

$VideoUpload->other_upload_option_display = 'display:none;';
//default form fields and values...
$VideoUpload->resetFieldsArray();
$VideoUpload->setAllPageBlocksHide();
$VideoUpload->setPageBlockShow('video_upload_form');
$VideoUpload->sanitizeFormInputs($_REQUEST);
$VideoUpload->VideoUploadTitle=$LANG['videoupload_title'];
$VideoUpload->setFormField('video_external_embed_code',stripslashes($VideoUpload->getFormField('video_external_embed_code')));
$VideoUpload->embededcode_optimum_dimension = str_replace(array('{width}','{height}'),
												array($CFG['admin']['videos']['minimum_player_width'],
												  $CFG['admin']['videos']['minimum_player_height']),
												    $LANG['embededcode_optimum_dimension_description']);
$LANG['help']['video_page_title'] = str_replace('{max}',
											$CFG['fieldsize']['video_page_title']['max'],
											$LANG['help']['video_page_title']);

$LANG['help']['video_meta_keyword'] = str_replace('{max}',
											$CFG['fieldsize']['video_meta_keyword']['max'],
											$LANG['help']['video_meta_keyword']);

$LANG['help']['video_meta_description'] = str_replace('{max}',
											$CFG['fieldsize']['video_meta_description']['max'],
											$LANG['help']['video_meta_description']);

$VideoUpload->imageFormat=implode(',',$CFG['admin']['videos']['image_format_arr']);

/********** Bulk Upload Functionality Started *********/

if($VideoUpload->getFormField('bulkUpload') == 'yes'){
	$VideoUpload->includeAjaxHeader();
	$VideoUpload->setFormField('flv_upload_type' ,'MultiUpload');
	$upload_name = "video_file";
	$VideoUpload->chkFileNameIsNotEmpty($upload_name, $LANG['common_err_tip_compulsory']) and
	$VideoUpload->chkValidVideoFileType($upload_name, $LANG['common_err_tip_invalid_file_type']) and
	$VideoUpload->chkValideVideoFileSize($upload_name, $LANG['common_err_tip_invalid_file_size']) and
	$VideoUpload->chkErrorInFile($upload_name, $LANG['common_err_tip_invalid_file']);

	if ($CFG['admin']['log_video_upload_error'])
		$VideoUpload->createErrorLogFile('video');

	if($VideoUpload->isValidFormInputs())
		$VideoUpload->addNewVideo();

	if($VideoUpload->video_uploaded_success){
		echo '|||Y|||';exit;
	}else{
		echo '|||N|||';exit;
	}
	$VideoUpload->includeAjaxFooter();
}
//exit;
/********** Bulk Upload Functionality Ended *********/

if($VideoUpload->getFormField('video_category_type')=='Porn')
{
	$VideoUpload->setFormField('video_category_id',$VideoUpload->getFormField('video_category_id_porn'));
}
else
{
	$VideoUpload->setFormField('video_category_id',$VideoUpload->getFormField('video_category_id_general'));
}


	if($VideoUpload->isFormPOSTed($_POST, 'video_upload_submit'))
		{
			if($VideoUpload->getFormField('use_vid'))
				{
					$VideoUpload->populateVideoDetailsForResponse($VideoUpload->getFormField('use_vid'));
					$VideoUpload->setFormField('video_title', $LANG['videoupload_reg_msg'].' '.$VideoUpload->getFormField('video_title'));
					//$VideoUpload->setFormField('video_caption', $LANG['videoupload_direct_capture_msg']);
				}
		}
if(!isAjax())
	{
			if($VideoUpload->isFormPOSTed($_POST, 'cancel'))
				{
					$VideoUpload->redirecturl();
				}
			if(!$VideoUpload->chkIsEditMode() and $VideoUpload->isFormGETed($_GET, 'album_id'))
				{
					$VideoUpload->setFormField('video_album_id', $VideoUpload->getFormField('album_id'));
				}

			if($VideoUpload->isFormPOSTed($_POST, 'upload_video_file') or $VideoUpload->isFormPOSTed($_POST, 'switch_over'))
				{

					if($VideoUpload->isFormPOSTed($_POST, 'switch_over'))
					{
						$VideoUpload->session_variable = $VideoUpload->retriveSessionDatas();
						$VideoUpload->sanitizeFormInputs($_POST);
					}

					$VideoUpload->validationFormFields1();
					if($VideoUpload->isValidFormInputs())
						{

							$VideoUpload->setAllPageBlocksHide();

							## Changing the Flv upload type based on the Switch over button
							if($VideoUpload->isFormPOSTed($_POST, 'upload_video_file'))
								{
									$_POST['flv_upload_type'] = 'Normal';
									$VideoUpload->setPageBlockShow('video_upload_form_file');
								}
							else if($VideoUpload->isFormPOSTed($_POST, 'upload_video_external'))
								{
									$VideoUpload->LANG['videoupload_upload_video_file'] = $LANG['videoupload_upload_file'];
									$_POST['flv_upload_type'] = 'externalsitevideourl';
									$VideoUpload->VideoUploadTitle=$LANG['videoupload_externalvideourl'];
									$VideoUpload->setPageBlockShow('video_upload_form_external');
								}
							else if($VideoUpload->isFormPOSTed($_POST, 'upload_video_capture'))
								{
									$VideoUpload->LANG['videoupload_upload_video_file'] = $LANG['videoupload_upload_file'];
									$_POST['flv_upload_type'] = 'Capture';
									$VideoUpload->setPageBlockShow('video_upload_form_capture');
								}
							else if($VideoUpload->isFormPOSTed($_POST, 'upload_video_embed_code'))
								{
									$VideoUpload->LANG['videoupload_upload_video_file'] = $LANG['videoupload_upload_file'];
									$_POST['flv_upload_type'] = 'embedcode';
									$VideoUpload->setPageBlockShow('upload_video_embed_code_form');
								}
							$VideoUpload->session_variable=$VideoUpload->storeDatasInSession();

						}
					else
						{
							$VideoUpload->setCommonErrorMsg($LANG['common_msg_error_sorry']);
							$VideoUpload->setPageBlockShow('common_msg_form_error');
						}
				}
			//upload_video is a hidden field in the swf upload form , for normal file the GEt upload is used
			// For external site view video url, the button name is upload_video
			//@todoc Need to remove the condition of upload in Get after checking

			else if($VideoUpload->isFormPOSTed($_POST, 'upload_video') or $VideoUpload->isFormGETed($_GET, 'upload'))
				{
					$VideoUpload->session_variable = $VideoUpload->retriveSessionDatas();

					$VideoUpload->sanitizeFormInputs($_POST);

					$VideoUpload->validationFormFields1();
					$first_form = true;
					if ($CFG['admin']['log_video_upload_error'])
						{
							$VideoUpload->createErrorLogFile('video');
						}

					if($VideoUpload->isValidFormInputs())
						{
							//no error in the first form values
							$first_form = false;

							//flv_upload_type will be set as Normal from flash
							if($VideoUpload->getFormField('flv_upload_type')=='Normal')
								{

									$VideoUpload->setAllPageBlocksHide();

									//when the user has selected the Normal php file upload, this will be set
									//video_file
									if($VideoUpload->isFormPOSTed($_POST, 'upload_video_normal'))
										{

											$VideoUpload->chkFileNameIsNotEmpty('video_file', $LANG['common_err_tip_compulsory']) and
											$VideoUpload->chkValidVideoFileType('video_file',$LANG['common_err_tip_invalid_file_type']) and
												$VideoUpload->chkValideVideoFileSize('video_file',$LANG['common_err_tip_invalid_file_size']) and
													$VideoUpload->chkErrorInFile('video_file',$LANG['common_err_tip_invalid_file']);
										}
									else
										{
											$VideoUpload->chkIsFile($LANG['common_err_tip_compulsory']);
										}

									if($VideoUpload->isValidFormInputs())
										{

											if($valid_video_upload_env=$VideoUpload->chkVideoUploadEnvironment())
												{
											$VideoUpload->chkVideoAlbumSelected();
											$VideoUpload->addNewVideo();
											if ($CFG['admin']['log_video_upload_error'])
												{
													$VideoUpload->closeErrorLogFile();
												}

											$VideoUpload->setAllPageBlocksHide();

											if($VideoUpload->video_uploaded_success)
												{

													$VideoUpload->resetFieldsArray();
													$VideoUpload->setCommonErrorMsg($VideoUpload->videoupload_msg_success_uploaded);
													$VideoUpload->setPageBlockShow('msg_form_success');
													$VideoUpload->unsetSessionDatas();
												}
											else
												{
													$VideoUpload->setCommonErrorMsg($LANG['videoupload_msg_failure_uploaded']);
													$VideoUpload->setPageBlockShow('msg_form_error');
													$VideoUpload->setPageBlockShow('video_upload_form_file');
												}
												}
												else
													{
														$VideoUpload->setCommonErrorMsg($LANG['common_msg_error_sorry'].' '.$VideoUpload->VIDEO_UPLOAD_ENV_ERR);
														$VideoUpload->setPageBlockShow('msg_form_error');
														$VideoUpload->setPageBlockShow('video_upload_form_file');
													}
										}
									else
										{
											$VideoUpload->setCommonErrorMsg($LANG['common_msg_error_sorry']);
											$VideoUpload->setPageBlockShow('msg_form_error');
											$VideoUpload->setPageBlockShow('video_upload_form_file');
										}

								}
							//uploading by providing the view video url from the allowed sites
							//video_youtube field is changed to externalsite_viewvideo_url

							else if($VideoUpload->getFormField('flv_upload_type')=='externalsitevideourl')
								{
									$VideoUpload->VideoUploadTitle=$LANG['videoupload_externalvideourl'];
									$VideoUpload->setAllPageBlocksHide();

									$VideoUpload->chkIsNotEmpty('externalsite_viewvideo_url', $LANG['common_err_tip_compulsory']) and
										$VideoUpload->chkIsValidExternalViewVideoUrl('externalsite_viewvideo_url', $LANG['videoupload_err_tip_invalid_url']);

									if($VideoUpload->isValidFormInputs())
										{

											$VideoUpload->chkVideoAlbumSelected();
											$video_id = $VideoUpload->addNewVideo();
											$VideoUpload->setAllPageBlocksHide();

											if($VideoUpload->video_uploaded_success)
												{
													$VideoUpload->resetFieldsArray();
													$VideoUpload->setCommonErrorMsg($VideoUpload->videoupload_msg_success_uploaded);
													$VideoUpload->setPageBlockShow('msg_form_success');
													$VideoUpload->unsetSessionDatas();
												}
											else
												{
													$VideoUpload->setCommonErrorMsg($LANG['videoupload_msg_failure_uploaded']);
													$VideoUpload->setPageBlockShow('msg_form_error');
													$VideoUpload->setPageBlockShow('video_upload_form_external');
												}
										}
									else
										{
											$VideoUpload->setCommonErrorMsg($LANG['common_msg_error_sorry']);
											$VideoUpload->setPageBlockShow('msg_form_error');
											$VideoUpload->setPageBlockShow('video_upload_form_external');
										}
								}
								//<!-- *embed_video* -->//
								elseif($VideoUpload->getFormField('flv_upload_type')=='embedcode')
								{
									$VideoUpload->setAllPageBlocksHide();

									if($VideoUpload->isFormPOSTed($_POST, 'upload_video_embed_code'))
										{
											$VideoUpload->chkIsNotEmpty('video_external_embed_code', $LANG['common_err_tip_compulsory']);

											if($VideoUpload->chkFileNameIsNotEmpty('embed_video_image', $LANG['common_err_tip_compulsory']))
											{
												$VideoUpload->chkValidImageFileType('embed_video_image',$LANG['common_err_tip_invalid_file_type']) and
												$VideoUpload->chkValideImageFileSize('embed_video_image',$LANG['common_err_tip_invalid_file_size']) and
												$VideoUpload->chkErrorInFile('embed_video_image',$LANG['common_err_tip_invalid_file']);
											}
											if($VideoUpload->chkIsNotEmpty('embed_playing_time', $LANG['common_err_tip_compulsory']))
											{
												if($VideoUpload->chkIsValidFormat('embed_playing_time', $LANG['videoupload_playingtime_format_error'],'/^([0-9]{2}[:])?[0-9]{2}[:][0-9]{2}$/'))
												{
												$timeExplode = explode(":",$VideoUpload->getFormField('embed_playing_time'));
												if(sizeof($timeExplode)==3)
												{
													$hr = $timeExplode[0];
													$min = $timeExplode[1];
													$sec = $timeExplode[2];
												}
												else
												{
													$hr = 0;
													$min = $timeExplode[0];
													$sec = $timeExplode[1];
												}

												if($hr>24 || $min >=60 || $sec >=60)
												{
													$VideoUpload->setFormFieldErrorTip('embed_playing_time',$LANG['videoupload_playingtime_format_error']);
												}

											}
											}

									if($VideoUpload->isValidFormInputs())
										{

												$VideoUpload->chkVideoAlbumSelected();
												$video_id = $VideoUpload->addNewExternalembedVideo();

												$VideoUpload->setAllPageBlocksHide();
												if($VideoUpload->video_uploaded_success)
													{
														$VideoUpload->resetFieldsArray();
														$VideoUpload->setCommonErrorMsg($VideoUpload->videoupload_msg_success_uploaded);
														$VideoUpload->setPageBlockShow('msg_form_success');
														$VideoUpload->unsetSessionDatas();
													}
												else
													{

														$VideoUpload->setCommonErrorMsg($LANG['videoupload_msg_failure_uploaded']);
														$VideoUpload->setPageBlockShow('msg_form_error');
														$VideoUpload->setPageBlockShow('upload_video_embed_code_form');
													}

										}
									else
										{

											$VideoUpload->setCommonErrorMsg($LANG['common_msg_error_sorry']);
											$VideoUpload->setPageBlockShow('msg_form_error');
											$VideoUpload->setPageBlockShow('upload_video_embed_code_form');
										}

									}
									else
										{

											$VideoUpload->setCommonErrorMsg($LANG['common_msg_error_sorry']);
											$VideoUpload->setPageBlockShow('msg_form_error');
											$VideoUpload->setPageBlockShow('upload_video_embed_code_form');
										}
								}
								else if($VideoUpload->getFormField('flv_upload_type')=='Capture')
								{
									$VideoUpload->setAllPageBlocksHide();

									if($VideoUpload->chkIsValidCaptureFile())
										{
											$VideoUpload->chkVideoAlbumSelected();
											$VideoUpload->addNewVideo();
											$VideoUpload->setAllPageBlocksHide();

											if($VideoUpload->video_uploaded_success)
												{
													$VideoUpload->resetFieldsArray();
													$VideoUpload->setCommonErrorMsg($VideoUpload->videoupload_msg_success_uploaded);
													$VideoUpload->setPageBlockShow('msg_form_success');
													$VideoUpload->unsetSessionDatas();
												}
											else
												{
													$VideoUpload->setCommonErrorMsg($LANG['videoupload_msg_failure_uploaded']);
													$VideoUpload->setPageBlockShow('msg_form_error');
													$VideoUpload->setPageBlockShow('video_upload_form_capture');
												}
										}
									else
										{
											$VideoUpload->setCommonErrorMsg($LANG['common_msg_error_sorry']);
											$VideoUpload->setPageBlockShow('msg_form_error');
											$VideoUpload->setPageBlockShow('video_upload_form_capture');
										}
								}
							else
								{
									$first_form = true;
									$VideoUpload->unsetSessionDatas();
								}
						}
					if($first_form)
						{

							$VideoUpload->setCommonErrorMsg($LANG['common_msg_error_sorry']);
							$VideoUpload->setPageBlockShow('msg_form_error');
						}


				}
			else if($VideoUpload->isFormPOSTed($_POST, 'update'))
				{
					$VideoUpload->validationFormFields1();
					if($VideoUpload->isValidFormInputs())
						{
							$sub_cat_id =  $VideoUpload->getFormField('video_sub_category_id');
							$sub_cat_id = $sub_cat_id?$sub_cat_id:0;
							$VideoUpload->setFormField('video_sub_category_id', $sub_cat_id);
							$VideoUpload->getOldVideoTags();
							$VideoUpload->updateVideoTableForEdit(array('video_album_id', 'video_title', 'video_caption', 'video_tags', 'video_access_type', 'video_category_id', 'video_sub_category_id', 'allow_comments', 'allow_ratings', 'date_recorded', 'location_recorded', 'country_recorded', 'zip_code_recorded', 'allow_embed', 'relation_id', 'video_country', 'video_language', 'allow_response','video_page_title','video_meta_keyword','video_meta_description'));
							if(!$CFG['admin']['tagcloud_based_search_count'])
							$VideoUpload->changeTagTableForEdit();

							//$VideoUpload->setAllPageBlocksHide();

							$VideoUpload->redirecturl();
							$VideoUpload->setFormField('relation_id',explode(',',$VideoUpload->getFormField('relation_id')));
							$VideoUpload->populateVideoDetailsForEdit();
							$VideoUpload->setCommonErrorMsg($LANG['videoupload_msg_success_updated']);
							$VideoUpload->setPageBlockShow('msg_form_success');
						}
					else
						{
							$VideoUpload->setCommonErrorMsg($LANG['common_msg_error_sorry']);
							$VideoUpload->setPageBlockShow('msg_form_error');
						}
				}
			else if($VideoUpload->chkIsEditMode())
				{
					if(!$VideoUpload->populateVideoDetailsForEdit())
						{
							$VideoUpload->setAllPageBlocksHide();
							$VideoUpload->setCommonErrorMsg($LANG['common_msg_error_sorry']);
							$VideoUpload->setPageBlockShow('msg_form_error');
						}
				}
			$VideoUpload->getVideoReferrerUrl();
			if($VideoUpload->isShowPageBlock('video_upload_form'))
				{
					$LANG['videoupload_title'] = $LANG['videoupload_title'].' '.$LANG['videoupload_page1'];
				}
			else
				{
					$LANG['videoupload_title'] = $LANG['videoupload_title'].' '.$LANG['videoupload_page2'];
				}
	}
else
	{
		if($VideoUpload->isFormPOSTed($_POST, 'cid'))
			{
				$VideoUpload->includeAjaxHeaderSessionCheck();
				$VideoUpload->populateVideoSubCatagory($VideoUpload->getFormField('cid'));
				$VideoUpload->includeAjaxFooter();
			}
		exit;
	}

if($VideoUpload->getFormField('bulkUpload') == '1'){
	$VideoUpload->setAllPageBlocksHide();
	$VideoUpload->resetFieldsArray();
	$VideoUpload->setCommonErrorMsg($VideoUpload->videoupload_msg_success_uploaded);
	$VideoUpload->setPageBlockShow('msg_form_success');
	$VideoUpload->unsetSessionDatas();
}

//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
$VideoUpload->left_navigation_div = 'videoMain';
$temp_dir = $VideoUpload->media_relative_path.$CFG['media']['folder'].'/'.$CFG['temp_media']['folder'].'/'.$CFG['admin']['videos']['temp_folder'].'/';
$VideoUpload->chkAndCreateFolder($temp_dir);
$VideoUpload->includeHeader();
if(!isset($VideoUpload->session_variable))
{
	$VideoUpload->session_variable=$VideoUpload->retriveSessionDatas();
}
?>
<script language="javascript" type="text/javascript">

//function for SWFUPLOAD
function getFlashUploader()
	{
		var uploadUrl = arguments[0];
		var postName = arguments[1];
		var fileTypes = arguments[2];
		var maxSize = arguments[3]+" MB";
		var postParams = arguments[4];

		swfu = new SWFUpload({
			// Backend settings
			//upload_url: uploadUrl,
			upload_url: "./videoUploadPopUp.php?bulkUpload=yes",
			file_post_name: postName,
			post_params: postParams,

			// Flash file settings
			file_size_limit : maxSize,
			file_types : fileTypes,			// or you could use something like: "*.doc;*.wpd;*.pdf",
			file_types_description : "All Files",
			file_upload_limit : "0",
			file_queue_limit : "1",

			// Event handler settings
			swfupload_loaded_handler : swfUploadLoaded,

			file_dialog_start_handler: fileDialogStart,
			file_queued_handler : fileQueued,
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,

			//upload_start_handler : uploadStart,	// I could do some client/JavaScript validation here, but I don't need to.
			upload_progress_handler : uploadProgress,
			upload_error_handler : uploadError,
			upload_success_handler : uploadSuccess,
			upload_complete_handler : uploadComplete,

			// Button Settings
			//button_image_url : '../../js/SWFUpload/images/swfUploadButton.png',
			//button_placeholder_id : "spanButtonPlaceholder",
			//button_width: 61,
			//button_height: 22,
			button_placeholder_id : "spanButtonPlaceholder1",
			button_width: 42,
			button_height: 22,
			button_text : '<span class="button"><?php echo $LANG['videoupload_browse']; ?></span>',
			button_text_style : '.button { font-family: Arial, sans-serif; font-size: 11px; font-weight: normal; padding:10px; color: #ffffff; height:30px; }',
			button_text_top_padding: 2,
			button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,


			// Flash Settings
			flash_url : "../js/SWFUpload/Flash/swfupload.swf",
			//flash_url : SITE_URL+"swfupload.swf",

			custom_settings : {
				progress_target : "fsUploadProgress",
				upload_successful : false
			},

			// Debug settings
			debug: false
		});
	}
var min_tag_size = "<?php echo $CFG['fieldsize']['tags']['min'];?>";
var max_tag_size = "<?php echo $CFG['fieldsize']['tags']['max'];?>";
var uploading_file ="'<?php echo $LANG['videoupload_uploading_file']?>";
var upload_in_progress="<?php echo $LANG['videoupload_upload_in_progress'];?>";
var upload_multiple_times="<?php echo $LANG['videoupload_mulitiple_times'];?>";
var valid_format = "<?php echo implode(',', $CFG['admin']['videos']['format_arr']);?>";
var upload_err_msg="<?php echo $LANG['videoupload_err_javascript_msg'];?>";
var invlaid_tag ="<?php echo $LANG['common_err_tip_invalid_tag'];?>";
var invalid_file="<?php echo $LANG['videoupload_err_javascript_invalid_file'];?>";
var flv_upload_type = "<?php echo $VideoUpload->getFormField('flv_upload_type');?>";
var upload_from_file=false;
</script>
<script language="Javascript" src="<?php echo $CFG['site']['url'];?>js/JSFCommunicator.js" ></script>
<?php
$link = '<a href="'.getUrl('videouploadpopup','', '','members','video').'">'.$LANG['common_click_here'].'</a>';
$VideoUpload->uploadAnother= str_replace('{click_here}', $link, $LANG['videoupload_upload_another']);
$VideoUpload->video_format=implode(', ', $CFG['admin']['videos']['format_arr']);
if ($VideoUpload->isShowPageBlock('video_upload_form'))
    {

    	$VideoUpload->videoupload_tags_msg=str_replace(array('{tag_min_chars}','{tag_max_chars}'),array($CFG['fieldsize']['tags']['min'],$CFG['fieldsize']['tags']['max']),$LANG['videoupload_tags_msg']);
		if($VideoUpload->chkIsEditMode())
		{
				$VideoUpload->thumbnail_folder = $CFG['media']['folder'].'/'.$CFG['admin']['videos']['folder'].'/'.$CFG['admin']['videos']['thumbnail_folder'].'/';
				$site_url = $_SERVER['PHP_SELF'];
				$explode_value = explode('/',$site_url);
				if(in_array('members', $explode_value))
					$VideoUpload->editUrl = getUrl('videolist', '?pg=videonew', 'videonew/', 'members', 'video');
				else
					$VideoUpload->editUrl = $CFG['site']['url'].'admin/video/videoManage.php';
				$VideoUpload->disp_image=DISP_IMAGE($CFG['admin']['videos']['thumb_width'], $CFG['admin']['videos']['thumb_height'], $VideoUpload->getFormField('t_width'), $VideoUpload->getFormField('t_height'));
				$VideoUpload->imageSrc=$VideoUpload->getFormField('video_server_url').$VideoUpload->thumbnail_folder.getVideoImageName($VideoUpload->getFormField('video_id')).$CFG['admin']['videos']['thumb_name'].'.'.$CFG['video']['image']['extensions'].'?update='.time();
				$VideoUpload->changeThumbUrl=getUrl('changethumbnail','?video_id='.$VideoUpload->getFormField('video_id'),'?video_id='.$VideoUpload->getFormField('video_id'),'members','video');
		}
		$VideoUpload->createAlbumUrl=getUrl('createalbum','?module=video&gpukey='.$VideoUpload->getFormField('gpukey'),'?module=video&gpukey='.$VideoUpload->getFormField('gpukey'),'members','video');
		$LANG['videoupload_tags_msg']=nl2br($LANG['videoupload_tags_msg']);
		$LANG['videoupload_video_tags']=nl2br($LANG['videoupload_video_tags']);
		$VideoUpload->content_filter=false;

		if($VideoUpload->chkAllowedModule(array('content_filter')) && isAdultUser('video'))
		{
			$VideoUpload->content_filter=true;
			$VideoUpload->Porn = $VideoUpload->General = 'none';
			$video_category_type = $VideoUpload->getFormField('video_category_type');
			$$video_category_type = '';
		}
		else
		{
			$VideoUpload->Porn = $VideoUpload->General = '';
		}
		if($VideoUpload->getFormField('video_category_type')=='General')
		{
			$VideoUpload->General ='';
		}
		else
		{
			$VideoUpload->Porn = '';
		}

	}
#Hiding the button based on the Flv Upload type. If flv_upload_type is NULL Switch over form will be disabled
if(isset($_POST['flv_upload_type']))
{
	$VideoUpload->upload_video_type=$_POST['flv_upload_type'];
}
else
{
	$VideoUpload->upload_video_type='';
}

if ($VideoUpload->isShowPageBlock('video_upload_form_capture'))
{
	$settingspath = $CFG['site']['video_url'].'quickCaptureConfigXmlCode.php?file_name='.$VideoUpload->session_variable;
	$skinpath = $CFG['site']['url'].$CFG['media']['folder'].'/flash/video/quickcapture/skins/skin.xml';
	$VideoUpload->quick_recorder_path = $CFG['site']['url'].$CFG['media']['folder'].'/flash/video/quickcapture/QuickRecorder.swf?filename='.$VideoUpload->session_variable.'&settingspath='.$settingspath.'&themePath='.$skinpath;
}
if ($VideoUpload->isShowPageBlock('video_upload_form_file'))
{
	$VideoUpload->imageFormat=implode(', ',$CFG['admin']['videos']['format_arr']);
	$VideoUpload->config_path = $CFG['site']['video_url'].'fileUploadConfigXmlCode.php?file_name='.$VideoUpload->session_variable;
	$VideoUpload->swf_path = $CFG['site']['url'].$CFG['media']['folder'].'/flash/video/videoUploader/fileuploader.swf';

	$VideoUpload->selUploadFlash_display = '';
	$VideoUpload->selUploadNormal_display = 'none';
	if($VideoUpload->isFormPOSTed($_POST, 'upload_video_normal'))
	{
		$VideoUpload->selUploadFlash_display = 'none';
		$VideoUpload->selUploadNormal_display = '';
	}

	//load swf for new video files uploader
	$VideoUpload->loadFilesForSwfUpload();

?>

	<script language="javascript">
	var upload_from_file=true;

	</script>
	<?php

}
?>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['video_url'];?>js/videoUpload.js"></script>
<script language="javascript" type="text/javascript">
var saveVideo = function(){
$('video_upload_form').submit();
}
</script>

<?php if ($VideoUpload->isShowPageBlock('video_upload_form'))
    {?>
<script language="javascript" type="text/javascript">
function showOtherUploadOption()
{
$('otherUploadOption').toggleClassName('clsDisplayNone');
}
function populateSubCategory(cat){
			var url = '<?php echo $CFG['site']['video_url'].'videoUploadPopUp.php';?>';
			var pars = 'ajax_page=true&cid='+cat;
			<?php if($VideoUpload->getFormField('video_sub_category_id')){?>
			pars = pars+'&video_sub_category_id=<?php echo $VideoUpload->getFormField('video_sub_category_id');?>';
			<?php }?>
			var method_type = 'post';
			populateSubCategoryRequest(url, pars, method_type);
		}
<?php if($VideoUpload->getFormField('video_category_id')){?>
	populateSubCategory('<?php echo $VideoUpload->getFormField('video_category_id');?>');
<?php }?>

</script>
<?php
}
setTemplateFolder('members/','video');
$smartyObj->display('videoUploadPopUp.tpl');
?>

<?php
/* Added code to validate mandataory fields in video defaut settings page */
if ($CFG['feature']['jquery_validation'])
{
if(!$VideoUpload->isShowPageBlock('video_upload_form_external') && !$VideoUpload->isShowPageBlock('upload_video_embed_code_form'))
{
?>
<script type="text/javascript">
$Jq("#video_upload_form").validate({
	rules: {
	    video_title: {
	    	required: true
		 },
		 video_tags: {
	    	required: true
		 },
		video_category_id_general: {
            required: "div#selGeneralCategory:visible"
		 },
		video_category_id_porn: {
            required: "div#selPornCategory:visible"
		 }
	},
	messages: {
		video_title: {
			required: "<?php echo $LANG['common_err_tip_required'];?>"
		},
		video_tags: {
			required: "<?php echo $LANG['common_err_tip_required'];?>"
		},
		video_category_id_general: {
			required: "<?php echo $LANG['common_err_tip_required'];?>"
		},
		video_category_id_porn: {
			required: "<?php echo $LANG['common_err_tip_required'];?>"
		}
	}
});

</script>
<?php
}
else if($VideoUpload->isShowPageBlock('video_upload_form_external'))
{
?>
<script type="text/javascript">
$Jq("#video_upload_form").validate({
	rules: {
	    externalsite_viewvideo_url: {
	    	required: true
		 }

	},
	messages: {
		externalsite_viewvideo_url: {
			required: "<?php echo $LANG['common_err_tip_required'];?>"
		}
	}
});
</script>
<?php
}
else if($VideoUpload->isShowPageBlock('upload_video_embed_code_form'))
{
$allowed_image_formats = implode("|", $CFG['admin']['videos']['image_format_arr']);
?>
<script type="text/javascript">
$Jq("#video_upload_form").validate({
	rules: {
	    video_external_embed_code: {
	    	required: true
		 },
		 embed_video_image: {
		 	required: true,
	    	isValidFileFormat: "<?php echo $allowed_image_formats; ?>"
		 },
		 embed_playing_time: {
		 	required: true,
		 	chkValidTimeFormat: true
		 }

	},
	messages: {
		video_external_embed_code: {
			required: "<?php echo $LANG['common_err_tip_required'];?>"
		},
	embed_video_image: {
			required: "<?php echo $LANG['common_err_tip_required'];?>",
			isValidFileFormat: "<?php echo $VideoUpload->LANG['common_err_tip_invalid_image_format']; ?>"
		},
	embed_playing_time: {
			required: "<?php echo $LANG['common_err_tip_required'];?>"
		},
	}
});
</script>
<?php
}
}
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$VideoUpload->includeFooter();
?>
