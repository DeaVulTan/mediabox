<?php
/**
 * PhotoUpload
 *
 * @package		general
 * @author 		shankar_76ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @access 		public
 **/
class PhotoUpload extends PhotoUploadLib
{
	public $photo_url = '';
	public $hidden_arr = array();
	public $multi_hidden_arr = array();
	public $fp = false;


	/**
	 * PhotoUpload::chkIsEditMode()
	 *
	 * @return boolean
	 */
	public function chkIsEditMode()
	{
		if($this->fields_arr['photo_id']
			and $this->checkIsValidPhoto($this->getFormField('photo_id')))
			{
				$_SESSION['new_photo_id'] = array();
				$_SESSION['new_photo_id'][] = $this->fields_arr['photo_id'];
				return true;
			}
		return false;
	}

	/**
	 * PhotoUpload::chkFileIsNotEmpty()
	 *
	 * @param string $field_name
	 * @param string $err_tip
	 * @return boolean
	 */
	public function chkFileIsNotEmpty($field_name, $err_tip = '')
	{
		if(!isset($_FILES[$field_name]))
			{
				$this->setFormFieldErrorTip($field_name, $err_tip);
				return false;
			}
		return true;
	}

	/**
	 * PhotoUpload::chkFileNameIsNotEmpty()
	 *
	 * @param string $field_name
	 * @param string $err_tip
	 * @return boolean
	 */
	public function chkFileNameIsNotEmpty($field_name, $err_tip = '')
	{
		if(!$_FILES[$field_name]['name'])
		{
			$this->setFormFieldErrorTip($field_name,$err_tip);
			return false;
		}
		return true;
	}

	/**
	 * PhotoUpload::chkValidExternalFileType()
	 *
	 * @param string $field_name
	 * @param string $err_tip
	 * @return boolean
	 */
	public function chkValidExternalFileType($field_name, $err_tip = '')
	{
		$format_arr = $this->CFG['admin']['photos']['format_arr'];
		if(!$this->CFG['admin']['photos']['external_photo_download'])
			$format_arr = $this->CFG['admin']['photos']['format_arr'];

		$extern = strtolower(substr($this->getFormField($field_name),
					strrpos($this->getFormField($field_name), '.')+1));

		if (!in_array($extern, $format_arr))
		{
			$this->fields_err_tip_arr[$field_name] = $err_tip;
			return false;
		}
		return true;
	}

	/**
	 * PhotoUpload::chkValidPhotoFileSize()
	 *
	 * @param string $field_name
	 * @param string $err_tip
	 * @return boolean
	 **/
	public function chkValidPhotoFileSize($field_name, $err_tip='')
	{
		if($this->CFG['admin']['photos']['max_size'])
		{
			$max_size = $this->CFG['admin']['photos']['max_size']*1024*1024;
			if ($_FILES[$field_name]['size'] > $max_size)
			{
				$this->fields_err_tip_arr[$field_name] = $err_tip;
				return false;
			}
		}
		return true;
	}

	/**
	* checkValideWatermarkFileSize
	*
	* @param string $field_name  filename with full path of original image
	* @param string $err_tip
	* @return boolean
	* @access public
	* @uses checkValideWatermarkFileSize()
	*/
	public function checkValideWatermarkFileSize($field_name, $err_tip='')
	{
		if($this->CFG['admin']['photos']['watermark_apply'])
		{
			$watermark_image = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['watermark_folder'].'/'.$this->CFG['admin']['watermark']['image_name'];
			if(is_file($watermark_image))
			{
				list($ori_width, $ori_height, $ori_type, $ori_attr) = getimagesize($_FILES[$field_name]['tmp_name']);
				list($water_width, $water_height, $water_type, $water_attr) = getimagesize($watermark_image);
				if(($water_width >= $ori_width || $water_height >= $ori_height))
				{
					$this->fields_err_tip_arr[$field_name] = $err_tip;
					return false;
				}
			}
			else
			{
				$err_tip = $this->LANG['potoupload_water_mark_image_empty'];
				$this->fields_err_tip_arr[$field_name] = $err_tip;
				return false;
			}
		}
		return true;
	}

	/**
	 * PhotoUpload::chkErrorInFile()
	 *
	 * @param string $field_name
	 * @param string $err_tip
	 * @return boolean
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
	 * PhotoUpload::chkValidImageSize()
	 *
	 * @param string $field_name
	 * @param string $err_tip
	 * @return boolean
	 */
	public function chkValidImageSize($field_name, $err_tip='')
	{
		if($this->CFG['admin']['photos']['image_max_size'])
		{
			$max_size = $this->CFG['admin']['photos']['image_max_size']*1024;
			if ($_FILES[$field_name]['size'] > $max_size)
			{
				$this->fields_err_tip_arr[$field_name] = $err_tip;
				return false;
			}
		}
		return true;
	}

	/**
	 * PhotoUpload::chkIsFile()
	 *
	 * @param string $err_tip
	 * @return boolean
	 */
	public function chkIsFile($err_tip)
	{
		if(isset($this->fields_arr['file_extern']))
		{
			$this->fields_arr['file_extern'] = strtolower($this->fields_arr['file_extern']);
			$extern = $this->fields_arr['file_extern'];
			$temp_dir = '../'.$this->CFG['admin']['photos']['temp_folder'];
			$temp_file = $temp_dir.$this->fields_arr['upload'].'.'.$extern;

			if(is_file($temp_file))
			{
				return true;
			}
		}
		$this->setFormFieldErrorTip('photo_file',$err_tip);
		return false;
	}



	/**
	 * PhotoUpload::loadFilesForSwfUpload()
	 *
	 * @return void
	 */
	public function loadFilesForSwfUpload()
	{
		global $CFG;
		$allowed_file_formats = implode(';*.', $CFG['admin']['photos']['format_arr']);
		$allowed_file_formats = '*.'.$allowed_file_formats;
		if(!isAjaxPage())
		{
		?>
			<script type="text/javascript">
		<?php
		}
		?>
			var multi_upload;
		<?php
			if(!isAjaxPage())
				{
		?>
			$Jq(document).ready(function(){
		<?php
				}
		?>
				multi_upload = new SWFUpload({
				// Backend Settings
				upload_url: "photoBulkUpload.php",
				post_params: {"PHPSESSID" : "<?php echo session_id(); ?>"},

				// File Upload Settings
				file_size_limit : "<?php echo $CFG['admin']['photos']['max_size']; ?> MB",	// MB
				//file_size_limit : "20 MB",	// MB
				file_types : "<?php echo $allowed_file_formats; ?>",
				<?php
				if($CFG['feature']['membership_payment'] && !isPaidMember())
				{
					if($this->chkNoOfFreeUploads())
					{
				?>
					file_upload_limit : "<?php
						if($CFG['admin']['photos']['no_of_free_uploads']!='')
						{
							$remaining_to_upload = $CFG['admin']['photos']['no_of_free_uploads'] - $this->TOTAL_PHOTO_UPLOADED;
							if($remaining_to_upload < $CFG['admin']['photos']['multi_upload_files_limit'])
								echo $remaining_to_upload;
							else
								echo $CFG['admin']['photos']['multi_upload_files_limit'];
						}
						else
						{
							echo $CFG['admin']['photos']['multi_upload_files_limit'];
						}
						 ?>",
				<?php
					}
				}
				else
				{
				?>
				file_upload_limit : "<?php echo $CFG['admin']['photos']['multi_upload_files_limit']; ?>",
				<?php
				}
				?>
				file_queue_limit : "0",

				// Event Handler Settings (all my handlers are in the Handler.js file)
				file_post_name : 'photo_file',
				file_dialog_start_handler : fileDialogStart,
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,

				// Button Settings
				// button_image_url : "../../js/SWFUpload/images/XPButtonUploadText_61x22.png",
				// button_placeholder_id : "spanButtonPlaceholder1",
				// button_width: 61,
				// button_height: 22,
				button_placeholder_id : "spanButtonPlaceholder1",
				button_width: 42,
				button_height: 22,
				button_text : '<span class="button"><?php echo $this->LANG['photoupload_browse_file']; ?></span>',
				button_text_style : '.button { font-family: Arial, sans-serif; font-size: 11px; font-weight: normal; padding:10px; color: #ffffff; height:30px; }',
				button_text_top_padding: 2,
				button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
				button_cursor: SWFUpload.CURSOR.HAND,

				// Flash Settings
				flash_url : "../js/SWFUpload/Flash/swfupload.swf",


				custom_settings : {
					progressTarget : "fsUploadProgress1",
					cancelButtonId : "btnCancel1",
					nextStepButtonId : "upload_photo_multiupload"
				},

				// Debug Settings
				debug: false
			});
		<?php
			if(!isAjaxPage())
				{
		?>
		     });
		</script>
		<?php
			}
	}

	/**
	 * PhotoUpload::isValidFormInputsMultiUpload()
	 *  To check file is uploaded for MultiUpload
	 *
	 * @return boolean
	 */
	public function isValidFormInputsMultiUpload()
	{
		if(isset($_SESSION['new_photo_id']) AND !empty($_SESSION['new_photo_id']))
		{
			return true;
		}
		return false;
	}

	/**
	 * PhotoUpload::populatePhotoDetailsForUpload()
	 *
	 * @return void
	 */
	public function populatePhotoDetailsForUpload()
	{
		global $smartyObj;
		$populatePhotoDetailsForUpload_arr = array();
		$inc = 0;
		$add = '';
		if(!$this->CFG['admin']['is_logged_in'])
			$add =' user_id=\''.$this->CFG['user']['user_id'].'\' AND ';
	//	print_r($_SESSION['new_photo_id']);
		foreach($_SESSION['new_photo_id'] as $key => $photo_id)
		{
			$sql = 'SELECT photo_title, photo_album_id, user_id, photo_status, '.
					' photo_ext, photo_caption, photo_tags, photo_access_type,'.
					' photo_server_url, allow_comments, allow_ratings, allow_embed, '.
					' allow_tags, relation_id, photo_ext,location_recorded,'.
					' photo_category_id, photo_sub_category_id FROM '.$this->CFG['db']['tbl']['photo'].' WHERE'.
					$add.
					' photo_id='.$this->dbObj->Param('photo_id').' LIMIT 0,1'; //photo_status=\'Ok\' AND'.

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($photo_id));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if($row = $rs->FetchRow())
			{
				$this->setFormField('photo_title_'.$inc, $row['photo_title']);
				$this->setFormField('photo_status_'.$inc, $row['photo_status']);
				$this->setFormField('photo_album_'.$inc, getPhotoAlbumName($row['photo_album_id']));
				$this->setFormField('photo_id_'.$inc, $photo_id);
				$this->setFormField('photo_caption_'.$inc, $row['photo_caption']);
				$this->setFormField('photo_album_id_'.$inc, $row['photo_album_id']);
				$this->setFormField('photo_album_type_'.$inc, getPhotoAlbumType($row['photo_album_id']));
				$this->setFormField('album_id', $row['photo_album_id']);
				$photo_name = getPhotoName($photo_id);
				$photo_folder = $this->CFG['site']['url'].$this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
				$this->setFormField('small_img_src_'.$inc, $photo_folder.$photo_name.$this->CFG['admin']['photos']['small_name'].'.'.$row['photo_ext']);
				if($this->chkIsEditMode())
				{
					$this->setFormField('photo_caption', $row['photo_caption']);
					$this->setFormField('location_recorded', $row['location_recorded']);
					$this->setFormField('photo_tags', $row['photo_tags']);
					$this->setFormField('photo_category_id', $row['photo_category_id']);
					$this->setFormField('photo_sub_category_id', $row['photo_sub_category_id']);
					$this->setFormField('allow_comments', $row['allow_comments']);
					$this->setFormField('allow_ratings', $row['allow_ratings']);
					$this->setFormField('allow_tags', $row['allow_tags']);
					$this->setFormField('allow_embed', $row['allow_embed']);
					$this->setFormField('photo_access_type', $row['photo_access_type']);
				}
				if($row['relation_id'])
					$this->fields_arr['relation_id'] = explode(',',$row['relation_id']);

				$populatePhotoDetailsForUpload_arr[$inc]['small_img_src'] = $photo_folder.$photo_name.$this->CFG['admin']['photos']['small_name'].'.'.$row['photo_ext'];
				$populatePhotoDetailsForUpload_arr[$inc]['photo_title'] = $row['photo_title'];
				$populatePhotoDetailsForUpload_arr[$inc]['photo_album'] = getPhotoAlbumName($row['photo_album_id']);
				$populatePhotoDetailsForUpload_arr[$inc]['photo_album_id'] = $row['photo_album_id'];

				//photo_id for hidden fields
				$this->multi_hidden_arr[$inc] = 'photo_id_'.$inc;

				$inc++;
			}
		}
		$this->setFormField('total_photos', $inc);
		$smartyObj->assign('populatePhotoDetailsForUpload_arr', $populatePhotoDetailsForUpload_arr);
	}

	/**
	 * PhotoUpload::setStep2CommonFields()
	 *
	 * @return void
	 */
	public function setStep2CommonFields()
	{
		if(isset($_POST['photo_category_id']))
			$_POST['photo_category_id'] = $_POST['photo_category_id'];
		else
			$_POST['photo_category_id'] = isset($_POST['photo_category_id_porn'])?$_POST['photo_category_id_porn']:'';
		if($this->CFG['admin']['photos']['add_photo_location'])
		{
			$this->update_table_fields_arr = array('photo_title', 'photo_album_id',
											   'photo_caption','photo_category_id',
											   'photo_sub_category_id',
											   'photo_tags', 'photo_access_type',
											   'relation_id', 'allow_comments',
											   'allow_ratings',	 'allow_tags'
											   );
		}
		else
		{
			$this->update_table_fields_arr = array('photo_title', 'photo_album_id',
											   'photo_caption','photo_category_id',
											   'photo_sub_category_id', 'location_recorded',
											   'google_map_latitude','google_map_longtitude',
											   'photo_tags', 'photo_access_type',
											   'relation_id', 'allow_comments',
											   'allow_ratings',	 'allow_tags'
											   );
		}


		$this->multiple_fields_arr = array('photo_title', 'photo_album_id','photo_caption');
		for($i=0;$i<$this->getFormField('total_photos');$i++)
		{
			$this->setFormField('photo_id_'.$i, '');
			$this->setFormField('photo_title_'.$i, '');
			$this->setFormField('photo_album_'.$i, '');
			$this->setFormField('photo_album_id_'.$i, '');
			$this->setFormField('photo_album_name_'.$i, '');
			$this->setFormField('photo_status_'.$i, '');
			$this->setFormField('photo_caption_'.$i, '');
			$this->setFormField('photo_album_type_'.$i, '');
			$this->setFormField('album_id_'.$i, '');
			$this->setFormField('album_id_public_'.$i, '');
			$this->setFormField('small_img_src_'.$i, '');

		}
		$this->setFormField('step_status', 'Ok');
	}


	/**
	 * photoDefaultSettings::checkAlbumNameExist()
	 *
	 * @return boolean
	 */
	public function checkAlbumNameExist($album_type,$album_name,$serial_value)
	{
		$qurstr='';
		if($album_type == 'Private')
		{
			$qurstr = ' AND user_id = '.$this->CFG['user']['user_id'];
		}
		else
		{
			$qurstr = ' AND album_access_type = \'Public\' ';
		}
		$sql = 'SELECT photo_album_id FROM '.
				$this->CFG['db']['tbl']['photo_album'].
				' WHERE photo_album_title='.$this->dbObj->Param('photo_album').$qurstr;
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($album_name));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		if($row = $rs->FetchRow())
		{
			$this->fields_arr['photo_album_id_'.$serial_value] = $row['photo_album_id'];
			return true;
		}

		return false;
	}
	/**
	 * PhotoUpload::checkAlbum()
	 *
	 * @return void
	 */
	public function checkAlbum()
	{
		for($i=0;$i<$this->getFormField('total_photos');$i++)
		{
			$album_name = $this->fields_arr['photo_album_'.$i];
			$album_type_value = $this->fields_arr['photo_album_type_'.$i];
			$photo_id = $this->fields_arr['photo_id_'.$i];
			if($album_type_value=='Private' && $this->fields_arr['album_id_'.$i]!='new')
			{
				$album_type = 'Private';
				$album_id = $this->fields_arr['album_id_'.$i];
			}
			elseif($album_type_value=='Private' && $this->fields_arr['album_id_'.$i] == 'new')
			{
				$album_type = 'Private';
				$album_id = '';
			}
			else
			{
				$album_type = 'Public';
				if($this->fields_arr['album_id_'.$i] != 'new')
					$album_id = $this->fields_arr['album_id_public_'.$i];
				else
					$album_id = '';
			}
			if(!empty($album_name) && empty($album_id))
			{
				if(!$this->checkAlbumNameExist($album_type,$album_name,$i))
				{
					$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_album'].
						   	' SET photo_album_title ='.$this->dbObj->Param('photo_album').', '.
						   	' album_access_type ='.$this->dbObj->Param('album_type').', '.
						   	' thumb_photo_id ='.$this->dbObj->Param('photo_id').', '.
						   	' user_id ='.$this->dbObj->Param('user_id').', '.
						   	' date_added = now()';
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($album_name,$album_type,$photo_id,$this->CFG['user']['user_id']));
					if (!$rs)
				    	trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				    $this->fields_arr['photo_album_id_'.$i] = $this->dbObj->Insert_ID();
			    }
			}
			else
			{
				$this->fields_arr['photo_album_id_'.$i] = $album_id;
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_album'].
					   	' SET thumb_photo_id ='.$this->dbObj->Param('photo_id').
						' WHERE photo_album_id ='.$this->dbObj->Param('photo_album_id');;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($photo_id,$album_id));
				if (!$rs)
			    	trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			}
		}
	}
	/**
	 * PhotoUpload::updatePhotoDetailsForUpload()
	 *
	 * @return void
	 */
	public function updatePhotoDetailsForUpload()
	{
		//Check Album exists else Insert Album
		$this->checkAlbum();
		if($this->chkIsEditMode())
		{
			$this->getOldPhotoTags();
		}
		for($i=0;$i<$this->getFormField('total_photos');$i++)
		{
			if($this->fields_arr['photo_category_type']=='Porn')
			{
				$this->fields_arr['photo_category_id'] = $this->fields_arr['photo_category_id_porn'];
			}
			if($this->fields_arr['photo_album_id_'.$i] == 0)
				$this->fields_arr['photo_album_id_'.$i] = 1;
			$photo_id = $this->fields_arr['photo_id_'.$i];
			$photo_name = $this->getPhotoName($photo_id);
			//change photo title in photo activity table in second step.
			$this->changePhotoTitleInActivityTable($photo_id, $this->fields_arr['photo_title_'.$i]);

			$param_value_arr = array();
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET ';

			foreach($this->update_table_fields_arr as $key => $fieldname)
			{
				if($this->fields_arr[$fieldname] != 'NOW()')
				{
					if(in_array($fieldname, $this->multiple_fields_arr))
					{
						$param_value_arr[] = $this->fields_arr[$fieldname.'_'.$i];
					}
					else
					{
						$param_value_arr[] = $this->fields_arr[$fieldname];
					}

					$sql .= $fieldname.'='.$this->dbObj->Param($fieldname).', ';
				}
				else
					$sql .= $fieldname.'='.$this->fields_arr[$fieldname].', ';

			}

			$sql = substr($sql, 0, strrpos($sql, ','));

			$sql .= ' WHERE photo_id='.$this->dbObj->Param('photo_id_'.$i);
			$param_value_arr[] = $this->fields_arr['photo_id_'.$i];
			if(!isAdmin())
			{
				$sql .=  ' AND user_id='.$this->dbObj->Param('user_id');
				$param_value_arr[] = $this->CFG['user']['user_id'];
			}
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, $param_value_arr);
			if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			//after update the photo fields if relaion id exist send a photo details for mail.

			if($this->fields_arr['relation_id'] && !$this->chkIsEditMode())
			{
				$this->sharePhotoDetails($this->fields_arr['photo_id_'.$i]);
			}
			if(!$this->chkIsEditMode())
			{
				$this->changeTagValueInSubscriptionTable($photo_id);
			}

			if($this->getFormField('edit_mode') == 1)
			{
				$this->setFormField('photo_id', $photo_id);
			}

		}

		// insert photo tag value into photo_tags table
		if(!$this->CFG['admin']['tagcloud_based_search_count'])
		{
			if($this->chkIsEditMode())
			{
				$this->changeTagTableForEdit();
			}
			else
			{
				$this->changeTagTable();
			}
		}

		$_SESSION['new_photo_id'] = array();
	}

	/**
	 * PhotoUpload::populatePhotoCatagory()
	 *
	 * @param string $type
	 * @param string $err_tip
	 * @return boolean
	 */
	public function populatePhotoCatagory($type = 'General', $err_tip='')
	{
		$sql = 'SELECT photo_category_id, photo_category_name FROM '.
				$this->CFG['db']['tbl']['photo_category'].
				' WHERE parent_category_id=0 AND photo_category_status=\'Yes\''.
				' AND photo_category_type='.$this->dbObj->Param('photo_category_type').
				' AND allow_post=\'Yes\'';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($type));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if(!$rs->PO_RecordCount())
			return;

		$names = array('photo_category_name');
		$value = 'photo_category_id';
		$highlight_value = $this->fields_arr['photo_category_id'];

		$inc = 0;
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

	/**
	 * PhotoUpload::populatePhotoSubCatagoryUploadPage()
	 *
	 * @param integer $cid
	 * @return void
	 */
	public function populatePhotoSubCatagoryUploadPage($cid)
	{
		$sql = 'SELECT photo_category_id, photo_category_name FROM '.
				$this->CFG['db']['tbl']['photo_category'].
				' WHERE parent_category_id='.$this->dbObj->Param('parent_category_id').
				' AND parent_category_id != \'\' AND photo_category_status=\'Yes\' AND allow_post=\'Yes\'';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($cid));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$names = array('photo_category_name');
		$value = 'photo_category_id';
		$highlight_value = $this->fields_arr['photo_sub_category_id'];
		?><select class="clsSelectMidSmall" name="photo_sub_category_id" id="photo_sub_category_id" tabindex="1060" class="clsSelectMidSmall">
			<option value=""><?php echo $this->LANG['common_select_option'];?></option>
		<?php

		while($row = $rs->FetchRow())
		{
			$out = '';
			$selected = $highlight_value == $row[$value]?' selected':'';
			foreach($names as $name)
				$out .= $row[$name].' ';
			?>
			<option value="<?php echo $row[$value];?>"<?php if($this->fields_arr['photo_sub_category_id']==$row[$value]){ echo " selected";}?>><?php echo $out;?></option>
			<?php
		}
		?></select><?php
	}

	/**
	 * PhotoUpload::validateBasicFields()
	 *  To validate Basic Form fields
	 *
	 * @return void
	 */
	public function validateBasicFields()
	{
		for($i=0;$i<$this->getFormField('total_photos');$i++)
		{
			$this->chkIsNotEmpty('photo_title_'.$i, $this->LANG['common_photo_err_tip_compulsory']);

			if($this->CFG['admin']['photos']['photo_upload_album_name_compulsory'])
				$this->chkIsNotEmpty('photo_album_'.$i, $this->LANG['common_photo_err_tip_compulsory']);

		}
	}

	/**
	 * PhotoUpload::validateCommonFormFields()
	 *  To validate common Form fields
	 *
	 * @return void
	 */
	public function validateCommonFormFields()
	{
		$this->chkIsNotEmpty('photo_tags', $this->LANG['common_photo_err_tip_compulsory']) and
			$this->chkValidTagList('photo_tags', 'photo_tags', $this->LANG['common_photo_err_tip_invalid_tag']);
		if(isset($_POST['photo_category_type'])  && $_POST['photo_category_type']!='Porn')
		{
			if($_POST['photo_category_id']== '')
			{
				$this->chkIsNotEmpty('photo_category_id', $this->LANG['common_photo_err_tip_compulsory']);
			}
		}
		elseif(isset($_POST['photo_category_type']) && $_POST['photo_category_type']=='Porn')
		{
			if($_POST['photo_category_id_porn']== '')
			{

				$this->chkIsNotEmpty('photo_category_id_porn', $this->LANG['common_photo_err_tip_compulsory']);
			}
		}
		else
		{
			$this->chkIsNotEmpty('photo_category_id', $this->LANG['common_photo_err_tip_compulsory']);
		}

	}


	/**
	 * PhotoUpload::chkIsValidPath()
	 *
	 * @param string $field_name
	 * @param string $err_tip
	 * @return boolean
	 */
	public function chkIsValidPath($field_name, $err_tip = '')
	{
		if(!getHeadersManual($this->fields_arr[$field_name]))
		{
			$this->fields_err_tip_arr[$field_name] = $err_tip;
			return false;
		}
	}



	/**
	 * PhotoUpload::checkAlbumPrivateOrPublic()
	 *
	 *
	 */
	public function checkAlbumPrivateOrPublic()
	{
		$sql = 'SELECT photo_album_title,album_access_type FROM '.
				$this->CFG['db']['tbl']['photo_album'].
				' WHERE photo_album_id='.$this->dbObj->Param('album_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['album_id']));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		if($row = $rs->FetchRow())
		{
			if($row['album_access_type'] == 'Private')
			{
				$this->fields_arr['photo_album'] = '';
			}
			else
			{
				$this->fields_arr['photo_album'] = $row['photo_album_title'];
				//$this->fields_arr['album_id'] = '';
			}
			for($i=0;$i<$this->getFormField('total_photos');$i++)
			{
				$this->fields_arr['photo_album_type_'.$i] = $row['album_access_type'];
			}
		}
	}

	/**
	 * PhotoUpload::addWaterMarkImage()
	 *
	 * @param string $captured_image_source
	 * @param string $captured_image_designation
	 * @return boolean
	 */

	public function addWaterMarkImage($captured_image_source, $captured_image_designation)
	{
		$this->storeWaterMarkPhoto($captured_image_source,$captured_image_designation);
	}
	/**
	 * PhotoUpload::deleteUserCamProfilePhoto()
	 *
	 * @param string $imageID
	 * @param string $imageName
	 * @return boolean
	 *
	 * //not used this function now
	 */
	public function deleteUserCamProfilePhoto($imageID, $imageName)
	{
		$dir_photo = $this->media_relative_path.$this->CFG['media']['folder'].'/'.
						$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['folder'].'/'.
							$this->CFG['admin'][$this->MEDIA_TYPE_CFG]['photo_folder'].'/';
		$uploadedPhoto = $dir_photo.$imageName;
		$this->PHOTO_CATEGORY_ID =0;
#		$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['photo'].' WHERE photo_id = '.$imageID;
#		$stmt = $this->dbObj->Prepare($sql);
#		$rs = $this->dbObj->Execute($stmt);
#		if (!$rs)
#		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
#		$affected = $this->dbObj->Affected_Rows();
		$affected =1;
		if($affected>0)
		{
			if($this->getServerDetails())
			{

				if($FtpObj = new FtpHandler($this->FTP_SERVER,$this->FTP_USERNAME,$this->FTP_PASSWORD))
				{
					//echo $dir_photo.'c16a5320fa47553L.jpg';
					$FtpObj->deleteFile($dir_photo.'c16a5320fa47553L.jpg'); exit;
					//echo $uploadedPhoto.'fdfd';
					$FtpObj->deleteFile($uploadedPhoto.'L.jpg');
					$FtpObj->deleteFile($uploadedPhoto.'S.jpg');
					$FtpObj->deleteFile($uploadedPhoto.'T.jpg');
					$FtpObj->deleteFile($uploadedPhoto.'M.jpg');
				}
			}
			else
			{
				@unlink($this->CFG['site']['project_path'].$this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/'.$imageName.'L'.'.jpg');
				@unlink($this->CFG['site']['project_path'].$this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/'.$imageName.'T'.'.jpg');
				@unlink($this->CFG['site']['project_path'].$this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/'.$imageName.'S'.'.jpg');
				@unlink($this->CFG['site']['project_path'].$this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/'.$imageName.'M'.'.jpg');
			}
		}
	}
	/**
	 * PhotoUpload::chkNoOfFreeUploads()
	 *
	 * @return boolean
	 */
	public function chkNoOfFreeUploads()
	{
		$sql = 'SELECT count(photo_id) as total_photos FROM '.	$this->CFG['db']['tbl']['photo'].
				' WHERE user_id='.$this->dbObj->Param('user_id').
				' AND (photo_status= \'Ok\' OR photo_status= \'Locked\') ';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		if($row = $rs->FetchRow())
		{
			$total_photo_uploaded = $row['total_photos'];
			$this->TOTAL_PHOTO_UPLOADED =$total_photo_uploaded;
		}
		if($this->CFG['admin']['photos']['no_of_free_uploads']!='')
		{
			if($this->CFG['admin']['photos']['no_of_free_uploads']=='0')
			{
				return false;
			}
			if($total_photo_uploaded >= $this->CFG['admin']['photos']['no_of_free_uploads'])
			{
				return false;
			}
		}
		return true;
	}
	/**
	* checkValideWatermarkFileSize
	*
	* @param string $field_name
	* @param string $err_tip
	* @access public
	* @uses checkValideWatermarkFileSize()
	*/
	public function checkValideWatermarkFileCommon()
	{
		if($this->CFG['admin']['photos']['watermark_apply'])
		{
			$watermark_image = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['watermark_folder'].'/'.$this->CFG['admin']['watermark']['image_name'];
			if(is_file($watermark_image))
			{
				return true;
			}
	    }
		return false;
	}

	/**
	 * photoDefaultSettings::checkAlbumNameExist()
	 *
	 * @return boolean
	 */
	public function checkAlbumNameExistForPrivate($album_name)
	{
		$qurstr = ' AND album_access_type = \'Private\' AND user_id = '.$this->CFG['user']['user_id'];
		$sql = 'SELECT photo_album_id FROM '.
				$this->CFG['db']['tbl']['photo_album'].
				' WHERE photo_album_title='.$this->dbObj->Param('photo_album').$qurstr;
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($album_name));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		if($row = $rs->FetchRow())
		{
			return true;
		}

		return false;
	}
	/**
	 * PhotoUpload::addNewAlbum()
	 *
	 *
	 */
	public function addNewAlbum($album_name)
	{
		if(!$this->checkAlbumNameExistForPrivate($album_name))
		{
			$new_album_id=$this->addAlbumName($album_name,'Private');
			return $new_album_id;
		}
	}
}
//echo '<pre>'; print_r($_REQUEST); echo '</pre>';
//exit;
$photoupload = new PhotoUpload();
if(!chkAllowedModule(array('photo')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$photoupload->setPageBlockNames(array('block_photoupload_step1', 'block_photoupload_step2', 'photo_upload_form',
									'block_photoupload_normalupload_form', 'block_photoupload_multiupload_form',
									'block_photoupload_externalupload_form', 'block_photoupload_capture_form',
									'block_photoupload_paidmembership_upgrade_form'));

$photoupload->setCSSFormFieldErrorTipClass('clsFormFieldErrTip');
//Set media path
$photoupload->setMediaPath('../');
//$_SESSION['new_photo_id'] = array();
$photoupload->photo_uploaded_success = true;
//Default Upload tab
$photoupload->show_div = '';

if(strpos($CFG['site']['current_url'], '/admin/'))
	$photoupload->left_navigation_div = 'photoMain';
//default form fields and values...
$photoupload->resetFieldsArray();
$photoupload->setFormField('user_id', $CFG['user']['user_id']);
$photoupload->setFormField('action', '');
$photoupload->setFormField('image_ext', '');
$photoupload->setFormField('user_image', '');
$photoupload->setFormField('new_album_name', '');
$photoupload->setFormField('start', 0);
$photoupload->setFormField('total_captured_image_count', $CFG['mugshot']['total_captured_image_count']);
$photoupload->setFormField('block', 'capturedImages');
$photoupload->hidden_arr = array('total_photos');
$photoupload->photo_format =  implode(', ', $CFG['admin']['photos']['format_arr']);

$common_err_tip_invalid_tag_min = str_replace('VAR_MIN', $CFG['fieldsize']['photo_tags']['min'],
													$LANG['common_err_tip_invalid_tag']);
$LANG['common_err_tip_invalid_tag'] = str_replace('VAR_MAX', $CFG['fieldsize']['photo_tags']['max'],
													$common_err_tip_invalid_tag_min);

$photoupload->photoupload_msg_success_uploaded = $LANG['photoupload_msg_success_uploaded_auto'];
$photoupload->paidmembership_upgrade_form = 0;
if($CFG['feature']['membership_payment'] && !isPaidMember())
{

	if($photoupload->chkNoOfFreeUploads())
	{
		//Added condition to check remaining photos to be uploaded by logged in user if no of free uploads is set
		if($CFG['admin']['photos']['no_of_free_uploads']!='')
		{
			$remaining_to_upload = $CFG['admin']['photos']['no_of_free_uploads'] - $photoupload->TOTAL_PHOTO_UPLOADED;
			if($remaining_to_upload < $CFG['admin']['photos']['multi_upload_files_limit'])
				$photoupload->photoupload_multi_upload_info = str_replace('{files_max_limit}', $remaining_to_upload,
														$LANG['photoupload_multi_upload_info']);
			else
				$photoupload->photoupload_multi_upload_info = str_replace('{files_max_limit}', $CFG['admin']['photos']['multi_upload_files_limit'],
														$LANG['photoupload_multi_upload_info']);
		}
		else
		{
			$photoupload->photoupload_multi_upload_info = str_replace('{files_max_limit}', $CFG['admin']['photos']['multi_upload_files_limit'],	$LANG['photoupload_multi_upload_info']);

		}

		$photoupload->setAllPageBlocksHide();
		$photoupload->setPageBlockShow('block_photoupload_step1');
	}
	else
	{
		$photoupload->setAllPageBlocksHide();
		$upgrade_link = '<a href='.$photoupload->getUrl('upgrademembership').' alt='.$LANG['potoupload_upgrade_membership_link'].' title='.$LANG['potoupload_upgrade_membership_link'].'>'.$LANG['potoupload_upgrade_membership_link'].'</a>';
		$LANG['potoupload_upgrade_membership'] = str_replace('{value}', $CFG['admin']['photos']['no_of_free_uploads'],$LANG['potoupload_upgrade_membership']);
		$photoupload->potoupload_upgrade_membership = str_replace('{link}', $upgrade_link, $LANG['potoupload_upgrade_membership']);
		$photoupload->setPageBlockShow('block_photoupload_paidmembership_upgrade_form');
		$photoupload->paidmembership_upgrade_form = 1;
	}
}
else
{
	$photoupload->photoupload_multi_upload_info = str_replace('{files_max_limit}', $CFG['admin']['photos']['multi_upload_files_limit'],
													$LANG['photoupload_multi_upload_info']);
	$photoupload->setAllPageBlocksHide();
	$photoupload->setPageBlockShow('block_photoupload_step1');
}


$photoupload->edit_completed = false;
$photoupload->mugshot_licence_validation = false;
if(is_file($CFG['site']['project_path'].'admin/photo/license.xml'))
	$photoupload->mugshot_licence_validation = true;
$CFG['feature']['auto_hide_success_block'] = false;
$upload_type = $CFG['admin']['photos']['default_upload_type'];
$upload_type_div = 'upload_photo_'.strtolower($upload_type);
$upload_block_name = 'block_photoupload_'.strtolower($upload_type).'_form';
if($CFG['admin']['photos'][$upload_type_div])
{
	$photoupload->show_div = 'sel'.$upload_type.'Content';
}
else
{
	foreach($CFG['admin']['photos']['available_upload_photo_types'] as $available_upload_type)//$CFG['admin']['photos']['default_upload_type']
	{
		$upload_type_div = 'upload_photo_'.strtolower($available_upload_type);
		$upload_block_name = 'block_photoupload_'.strtolower($available_upload_type).'_form';
		if($CFG['admin']['photos'][$upload_type_div])
		{
			$photoupload->show_div = 'sel'.$available_upload_type.'Content';
			break;
		}

	}
}
$photoupload->setPageBlockShow($upload_block_name);
$photoupload->sanitizeFormInputs($_REQUEST);
if($photoupload->getFormField('pg') == 'ajax_capture')
{
	$LANG['profileavatar_upload_images']   = str_replace('{link}', $photoupload->getUrl('profileavatar'), $LANG['profileavatar_upload_images']);
    $LANG['profileavatar_note'] 			 = str_replace('{limit}', $CFG['mughsot']['captured_images_limit'], $LANG['profileavatar_note']);
    $photoupload->profileavatar_upload_images = $LANG['profileavatar_upload_images'];
    $photoupload->profileavatar_note			 = $LANG['profileavatar_note'];
    $photoupload->mugshotVersion              = $CFG['mugshot']['version'];
    if($CFG['mugshot']['version'] == 'mugshot_pro')
  		$photoupload->mugshotPath         		 = $CFG['site']['url'].'mugshot/pro/';
  	else
  		$photoupload->mugshotPath         		 = $CFG['site']['url'].'mugshot/lite/';
  	$photoupload->mugshotLicensePath        = $CFG['site']['url'].'admin/photo/';
}
$photoupload->location_url = $photoupload->CFG['site']['photo_url'].'photoList.php?type=add_location&page=upload&photo_id='.$photoupload->getFormField('photo_id');
/*
if(!$photoupload->checkValideWatermarkFileCommon())
{
	$LANG['potoupload_water_mark_image_empty'];
	$photoupload->setCommonErrorMsg($LANG['potoupload_water_mark_image_empty']);
	$photoupload->setAllPageBlocksHide();
	$photoupload->setPageBlockShow('block_msg_form_error');
}
*/
//upload photo using photo capture method.
if((isset($_POST['ajax']) && $_POST['ajax'] == '1') && (isset($_POST['capturedPhoto'])))
{
	$_SESSION['new_photo_id'] = array();
	$jpg       = base64_decode($_POST['capturedPhoto']);
	$imageName = rand().$CFG['user']['user_id'];
	$dir = '../'.$CFG['media']['folder'].'/'.
						$CFG['temp_media']['folder'].'/'.
							$CFG['admin']['photos']['temp_folder'].'/';
	$original_dir = '../'.$CFG['media']['folder'].'/'.
				$CFG['admin']['photos']['original_photo_folder'].'/';
	$original_file = $original_dir.$imageName.'.jpg';

	$photoupload->chkAndCreateFolder($dir);
	$photoupload->chkAndCreateFolder($original_dir);
	$profile_image_name = $imageName.'_'.time();
	$imageExtension     = '.jpg';
	$captured_image = $dir.$imageName.$imageExtension;
	$f                  = fopen($captured_image, 'w');
	fwrite($f, $jpg);
	fclose($f);
	$photoupload->setFormField('photo_upload_type','Capture');
	$photoupload->setFormField('capturedPhoto',$captured_image);
	$photoupload->addNewPhoto();
	$photo_name = getPhotoName($photoupload->PHOTO_ID);

	$copy = 'Y';
	$squte = "'";
	$src      = $photoupload->getUploadPhotoServerUrl($photoupload->PHOTO_ID).$CFG['media']['folder'].'/'.$CFG['admin']['photos']['folder'].'/'.$CFG['admin']['photos']['photo_folder'].'/'.$photoupload->PHOTO_NAME.'L'.$imageExtension.'?'.time();
	$userName = $CFG['user']['user_name'];
	// comment the currently stored image path (because we don't want display the captured photo and delete link.
#	$imgPath  = '<p> <a href="javascript:void(0);" onclick="deleteImage('.$squte.$photoupload->PHOTO_ID.$squte.','.$squte.$photoupload->PHOTO_NAME.$squte.');" title="Delete">Delete Photo</a></p>';
#	$imgPath .= '<div class="cls90PXthumbImage clsThumbImageOuter"><div class="clsrThumbImageMiddle"><div class="clsThumbImageInner">';
#	$imgPath .= '<img src="'.$src.'" alt="'.$userName.'" title="'.$userName.'" border="0">';
#	$imgPath .= '</div></div></div>';

	$copy .= '|'.$photoupload->PHOTO_ID;

	echo $copy;exit;
}
elseif((isset($_POST['ajax']) && $_POST['ajax'] == '1') && (isset($_POST['delImageId']))){
	$photoupload->deleteUserCamProfilePhoto($_POST['delImageId'], $_POST['ImageName']);
	echo 'Y';exit;
}
if(isAjaxPage())
{
	$photoupload->LANG['photoupload_step'] = $LANG['photoupload_step1'];
	$photoupload->LANG['photoupload_step_info'] = $LANG['photoupload_step1_info'];
	if($photoupload->getFormField('pg') == 'multiupload')
	{
		$_SESSION['new_photo_id'] = array();
		$photoupload->setPageBlockShow('block_photoupload_multiupload_form');
		$photoupload->includeAjaxHeader();
		$photoupload->loadFilesForSwfUpload();
		echo '#~~~#';
		setTemplateFolder('general/', 'photo');
		$smartyObj->display('multiUpload.tpl');
		$photoupload->includeAjaxFooter();
		exit;
	}
	elseif($photoupload->getFormField('pg') == 'normal')
	{
		$_SESSION['new_photo_id'] = array();
		$photoupload->setPageBlockShow('block_photoupload_normalupload_form');
		$photoupload->includeAjaxHeader();
		setTemplateFolder('general/', 'photo');
		$smartyObj->display('normalUpload.tpl');
		$photoupload->includeAjaxFooter();
		exit;
	}
	elseif($photoupload->getFormField('pg') == 'external')
	{
		$_SESSION['new_photo_id'] = array();
		$photoupload->setPageBlockShow('block_photoupload_externalupload_form');
		$photoupload->includeAjaxHeader();
		setTemplateFolder('general/', 'photo');
		$smartyObj->display('externalUpload.tpl');
		$photoupload->includeAjaxFooter();
		exit;
	}
	elseif($photoupload->getFormField('pg') == 'capture')
	{
		$_SESSION['new_photo_id'] = array();

		$LANG['profileavatar_upload_images']   = str_replace('{link}', $photoupload->getUrl('profileavatar'), $LANG['profileavatar_upload_images']);
	    $LANG['profileavatar_note'] 			 = str_replace('{limit}', $CFG['mugshot']['captured_images_limit'], $LANG['profileavatar_note']);
	    $photoupload->profileavatar_upload_images = $LANG['profileavatar_upload_images'];
	    $photoupload->profileavatar_note			 = $LANG['profileavatar_note'];
        $photoupload->mugshotVersion              = $CFG['mugshot']['version'];
        if($CFG['mugshot']['version'] == 'mugshot_pro')
      		$photoupload->mugshotPath         		 = $CFG['site']['url'].'mugshot/pro/';
      	else
      		$photoupload->mugshotPath         		 = $CFG['site']['url'].'mugshot/lite/';
      	$photoupload->mugshotLicensePath        = $CFG['site']['url'].'admin/photo/';
		$photoupload->setPageBlockShow('block_photoupload_capture_form');
		$photoupload->includeAjaxHeader();
		setTemplateFolder('general/', 'photo');
		$smartyObj->display('capturePhoto.tpl');
		$photoupload->includeAjaxFooter();
		exit;
	}
	elseif($photoupload->isFormPOSTed($_POST, 'cid')) //Populate SubCategory
	{
		$photoupload->includeAjaxHeaderSessionCheck();
		$photoupload->populatePhotoSubCatagoryUploadPage($photoupload->getFormField('cid'));
		$photoupload->includeAjaxFooter();
		exit;
	}
	elseif($photoupload->getFormField('new_album_name'))
	{
		$photoupload->setAllPageBlocksHide();
		$photoupload->includeAjaxHeader();
		$new_album_id=$photoupload->addNewAlbum($photoupload->getFormField('new_album_name'));
		echo $new_album_id.'|Sucess';
		$photoupload->includeAjaxFooter();
		exit();
	}
}
else
{
	//Photo Edit Mode
	if($photoupload->isFormGETed($_GET, 'photo_id'))
	{
		if($photoupload->chkIsEditMode())
		{
			$photoupload->hidden_arr[] = 'edit_mode';
			$photoupload->setFormField('edit_mode', 1);
			$photoupload->setAllPageBlocksHide();
			$photoupload->populatePhotoDetailsForUpload();
			$photoupload->getPhotoCategoryType();
			$photoupload->setPageBlockShow('block_photoupload_step2');
		}
		else
		{
			$photoupload->setCommonErrorMsg($LANG['common_photo_msg_error_sorry']);
			$photoupload->setPageBlockShow('block_msg_form_error');
			$photoupload->setPageBlockShow('block_photoupload_step1');
		}
	}

	if($photoupload->isFormPOSTed($_POST, 'photo_upload_type'))
	{
		$photoupload->setAllPageBlocksHide();

		if ($CFG['admin']['photos']['log_upload_error'])
		{
			$photoupload->createErrorLogFile('photo');
		}

		$photoupload->sanitizeFormInputs($_POST);
		//Preventing Form submission when the User refreshes the page for Normal Upload (Single Upload)
		if(!empty($_SESSION['new_photo_id']))
		{
			$photoupload->resetFieldsArray();
			$photoupload->populatePhotoDetailsForUpload();
			$photoupload->setPageBlockShow('block_photoupload_step2');
		}
		elseif($photoupload->getFormField('photo_upload_type') == 'Normal')
		{
			//when the user upload files using Normal file upload
			if($photoupload->isFormPOSTed($_POST, 'upload_photo_normal'))
			{
				$photoupload->chkFileIsNotEmpty('photo_file', $LANG['common_photo_err_tip_no_file']) and
					$photoupload->chkFileNameIsNotEmpty('photo_file', $LANG['common_photo_err_tip_required']) and
						$photoupload->chkValidFileType('photo_file', $CFG['admin']['photos']['format_arr'], $LANG['common_photo_err_tip_invalid_file_type']) and
							$photoupload->chkValidPhotoFileSize('photo_file', $LANG['common_photo_err_tip_invalid_file_size']) and
								//$photoupload->checkValideWatermarkFileSize('photo_file', $LANG['common_photo_err_tip_invalid_image_size']) and
									$photoupload->chkErrorInFile('photo_file', $LANG['common_photo_err_tip_invalid_file']);

				$photoupload->show_div = 'selNormalUploadContent';
				$photoupload->setPageBlockShow('block_photoupload_normalupload_form');
			}
			else
			{
				$photoupload->chkIsFile($LANG['err_tip_compulsory']);
			}


			if($photoupload->isValidFormInputs())
			{
				$photoupload->setAllPageBlocksHide();
				$photoupload->addNewPhoto();
				if($photoupload->photo_uploaded_success)
				{
					$photoupload->resetFieldsArray();
					$photoupload->populatePhotoDetailsForUpload();
					$photoupload->setPageBlockShow('block_photoupload_step2');
					$photoupload->setCommonSuccessMsg($LANG['photoupload_msg_upload_success']);
					$photoupload->setPageBlockShow('block_msg_form_success');
				}
				else
				{
					$photoupload->setCommonErrorMsg($LANG['msg_failure_uploaded']);
					$photoupload->setPageBlockShow('block_photoupload_step1');
					$photoupload->setPageBlockShow('block_msg_form_error');
					$photoupload->setPageBlockShow('block_photoupload_normalupload_form');
				}
			}
			else
			{
				$photoupload->setCommonErrorMsg($LANG['photoupload_multiupload_msg_error']);
				$photoupload->setPageBlockShow('block_msg_form_error');
				$photoupload->setPageBlockShow('block_photoupload_step1');
				$photoupload->setPageBlockShow('block_photoupload_normalupload_form');
			}

		}
		elseif($photoupload->getFormField('photo_upload_type') == 'MultiUpload')
		{
			if($photoupload->isValidFormInputsMultiUpload())
			{
				$photoupload->populatePhotoDetailsForUpload();
				$photoupload->setPageBlockShow('block_photoupload_step2');
				$photoupload->setCommonSuccessMsg($LANG['photoupload_msg_upload_success']);
				$photoupload->setPageBlockShow('block_msg_form_success');
			}
			else
			{
				$photoupload->setCommonErrorMsg($LANG['photoupload_multiupload_msg_error']);
				$photoupload->setPageBlockShow('block_msg_form_error');
				$photoupload->setPageBlockShow('block_photoupload_step1');
				$photoupload->setPageBlockShow('block_photoupload_multiupload_form');
				$photoupload->show_div = 'selMultiUploadContent';
			}
		}
		elseif($photoupload->getFormField('photo_upload_type') == 'External')
		{
			$photoupload->chkIsNotEmpty('photo_external_file', $LANG['common_photo_err_tip_required']) and
				$photoupload->chkIsValidURL('photo_external_file', $LANG['common_photo_err_tip_invalid_url']) and
					$photoupload->chkValidExternalFileType('photo_external_file', $LANG['common_photo_err_tip_invalid_file_type']) and
						$photoupload->chkIsValidPath('photo_external_file', $LANG['common_photo_err_tip_invalid_url']);
			if($photoupload->isValidFormInputs())
			{
				$photoupload->setAllPageBlocksHide();
				$photoupload->addNewPhoto();
				if($photoupload->photo_uploaded_success)
				{
					$photoupload->resetFieldsArray();
					$photoupload->populatePhotoDetailsForUpload();
					$photoupload->setPageBlockShow('block_photoupload_step2');
					$photoupload->setCommonSuccessMsg($LANG['photoupload_msg_upload_success']);
					$photoupload->setPageBlockShow('block_msg_form_success');
				}
			}
			else
			{
				$photoupload->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$photoupload->setPageBlockShow('block_msg_form_error');
				$photoupload->setPageBlockShow('block_photoupload_step1');
				$photoupload->setPageBlockShow('block_photoupload_externalupload_form');
				$photoupload->show_div = 'selExternalUploadContent';
			}
		}
		elseif($photoupload->getFormField('photo_upload_type') == 'Capture')
		{
			$_SESSION['new_photo_id'] = array();
			$photoupload->setFormField('recorded_filename', $photoupload->getFormField('upload'));
			if($photoupload->chkIsValidRecordedFile())
			{
				$photoupload->addNewPhoto();
				if($photoupload->photo_uploaded_success)
				{
					$photoupload->resetFieldsArray();
					$photoupload->populatePhotoDetailsForUpload();
					$photoupload->setPageBlockShow('block_photoupload_step2');
					$photoupload->setCommonSuccessMsg($LANG['photoupload_msg_record_success']);
					$photoupload->setPageBlockShow('block_msg_form_success');
				}
			}
			else
			{
				$photoupload->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$photoupload->setPageBlockShow('block_msg_form_error');
				$photoupload->setPageBlockShow('block_photoupload_step1');
				$photoupload->setPageBlockShow('block_photoupload_capture_form');
				$photoupload->show_div = 'selCaptureContent';
			}
		}
	}
	elseif($photoupload->isFormPOSTed($_POST, 'upload_photo')) //To Update other fields when uploading #also for edit photo updation
	{
		$photoupload->setAllPageBlocksHide();
		$photoupload->setStep2CommonFields();
		$photoupload->sanitizeFormInputs($_POST);
		$photoupload->validateBasicFields(); //To validate multiple fields (title, artist, album and others)
		$photoupload->validateCommonFormFields(); //To validate common fields
		if(isset($_POST['photo_category_id']))
			$photoupload->setFormField('photo_category_id', $_POST['photo_category_id']);
		else
			$photoupload->setFormField('photo_category_id', isset($_POST['photo_category_id_porn'])?$_POST['photo_category_id_porn']:'');
		if($photoupload->isValidFormInputs())
		{
			if($photoupload->getFormField('photo_access_type')=='Private')
			{
				$relation_id = implode(',',$photoupload->getFormField('relation_id'));
				$photoupload->setFormField('relation_id', $relation_id);
			}
			else
				$photoupload->setFormField('relation_id','');
			$photoupload->updatePhotoDetailsForUpload();
			if($photoupload->getFormField('edit_mode') == 1)
			{
				$photoupload->view_photo_url = getUrl('viewphoto', '?photo_id='.$photoupload->getFormField('photo_id').'&amp;title='.$photoupload->getFormField('photo_title').'&msg=updated', $photoupload->getFormField('photo_id').'/'.$photoupload->getFormField('photo_title').'?msg=updated', '', 'photo');
				Redirect2URL($photoupload->view_photo_url);
				$photoupload->setCommonSuccessMsg($LANG['photoupload_msg_update_success']);
				$photoupload->setPageBlockShow('block_photoupload_step2');
			}
			else
			{
				$photoupload->setCommonSuccessMsg($photoupload->photoupload_msg_success_uploaded);
				$photoupload->setPageBlockShow('block_photoupload_step1');
				$photoupload->setPageBlockShow('block_photoupload_multiupload_form');
				$photoupload->show_div = 'selMultiUploadContent';
			}

			$photoupload->setPageBlockShow('block_msg_form_success');
		}
		else
		{
			for($inc=0;$inc<$photoupload->getFormField('total_photos');$inc++)
				$photoupload->multi_hidden_arr[$inc] = 'photo_id_'.$inc;
			$photoupload->setCommonErrorMsg($LANG['common_photo_msg_error_sorry']);
			$photoupload->setPageBlockShow('block_msg_form_error');
			$photoupload->setPageBlockShow('block_photoupload_step2');
		}
	}
	else
	{
		$_SESSION['new_photo_id'] = array();
	}
}
if($photoupload->isShowPageBlock('block_photoupload_step1'))
{
	$photoupload->LANG['photoupload_step'] = $LANG['photoupload_step1'];
	$photoupload->LANG['photoupload_step_info'] = $LANG['photoupload_step1_info'];
}
if($photoupload->isShowPageBlock('block_photoupload_step2'))
{

	if(!$photoupload->chkIsEditMode())
	{
		$photoupload->populateDefaultPhotoDetails();
		$photoupload->getPhotoCategoryType();
	}
	if($photoupload->getFormField('album_id'))
	{
		$photoupload->checkAlbumPrivateOrPublic();
	}
	else
	{
		$photoupload->setFormField('photo_album_type_0','');
	}
	$photoupload->LANG['photoupload_step'] = $LANG['photoupload_step2'];
	$photoupload->LANG['photoupload_step_info'] = $LANG['photoupload_step2_info'];
    $photoupload->photoUpload_tags_msg = str_replace(array('{tag_min_chars}','{tag_max_chars}'),
											array($CFG['fieldsize']['photo_tags']['min'],$CFG['fieldsize']['photo_tags']['max']),
												$LANG['photoupload_tags_msg1']);


	$photoupload->content_filter = false;

	if($photoupload->chkAllowedModule(array('content_filter')) && isAdultUser('','photo'))
	{
		$photoupload->content_filter = true;
		$photoupload->Porn = $photoupload->General = 'none';
		$photo_category_type = $photoupload->getFormField('photo_category_type');
		$$photo_category_type = '';
	}
	else
	{
		$photoupload->Porn = $photoupload->General = '';
	}
	if($photoupload->getFormField('photo_category_type') == 'General')
	{
		$photoupload->General ='';
	}
	else
	{
		$photoupload->Porn = '';
	}

}

$photoupload->includeHeader();
if ($CFG['admin']['photos']['upload_photo_multiupload'])
	{
?>
<link href="<?php echo $CFG['site']['url'].'design/templates/'.$CFG['html']['template']['default'].'/root/css/'.$CFG['html']['stylesheet']['screen']['default'].'/swfupload/default.css'; ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $CFG['site']['url']; ?>js/SWFUpload/swfupload.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url']; ?>js/SWFUpload/plugins/swfupload.queue.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url']; ?>js/SWFUpload/others/fileprogress.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url']; ?>js/SWFUpload/others/handlers.js"></script>
<?php
	}
?>
<script type="text/javascript" src="<?php echo $CFG['site']['url']; ?>js/lib/validation/validation.js"></script>

<?php
if($photoupload->isShowPageBlock('block_photoupload_capture_form') || $CFG['admin']['photos']['upload_photo_capture'])
{
	$_SESSION['new_photo_id'] = array();

	$LANG['profileavatar_upload_images']   = str_replace('{link}', $photoupload->getUrl('profileavatar'), $LANG['profileavatar_upload_images']);
    $LANG['profileavatar_note'] 			 = str_replace('{limit}', $CFG['mugshot']['captured_images_limit'], $LANG['profileavatar_note']);
    $photoupload->profileavatar_upload_images = $LANG['profileavatar_upload_images'];
    $photoupload->profileavatar_note			 = $LANG['profileavatar_note'];
    $photoupload->mugshotVersion              = $CFG['mugshot']['version'];
    if($CFG['mugshot']['version'] == 'mugshot_pro')
  		$photoupload->mugshotPath         		 = $CFG['site']['url'].'mugshot/pro/';
  	else
  		$photoupload->mugshotPath         		 = $CFG['site']['url'].'mugshot/lite/';
  	$photoupload->mugshotLicensePath        = $CFG['site']['url'].'admin/photo/';
	$photoupload->setPageBlockShow('block_photoupload_capture_form');

}
if($photoupload->isShowPageBlock('block_photoupload_multiupload_form'))
{
	$photoupload->loadFilesForSwfUpload();
}
setTemplateFolder('general/', $CFG['site']['is_module_page']);
$smartyObj->display('photoUploadPopUp.tpl');
//set the div id name.
if($photoupload->isShowPageBlock('block_photoupload_step1'))
{
	$more_tabs_div = 'var more_tabs_div = new Array(';
	$more_tabs_class = 'var more_tabs_class = new Array(';
	if ($CFG['admin']['photos']['upload_photo_multiupload'])
	{
		$more_tabs_div .= "'selMultiUploadContent'";
		$more_tabs_class .= "'selHeaderMultiUpload'";
		if ($CFG['admin']['photos']['upload_photo_normalupload']
			OR $CFG['admin']['photos']['upload_photo_externalupload']
			 	OR ($CFG['admin']['photos']['upload_photo_capture'] && $photoupload->mugshot_licence_validation))
			{
				$more_tabs_div .= ',';
				$more_tabs_class .= ',';
			}
	}

	if ($CFG['admin']['photos']['upload_photo_normalupload'])
	{
		$more_tabs_div .= "'selNormalUploadContent'";
		$more_tabs_class .= "'selHeaderNormalUpload'";
		if ($CFG['admin']['photos']['upload_photo_externalupload']
			 OR ($CFG['admin']['photos']['upload_photo_capture'] && $photoupload->mugshot_licence_validation))
			{
				$more_tabs_div .= ',';
				$more_tabs_class .= ',';
			}
	}

	if ($CFG['admin']['photos']['upload_photo_externalupload'])
	{
		$more_tabs_div .= "'selExternalUploadContent'";
		$more_tabs_class .= "'selHeaderExternalUpload'";
		if ($CFG['admin']['photos']['upload_photo_capture'] && $photoupload->mugshot_licence_validation)
			{
				$more_tabs_div .= ',';
				$more_tabs_class .= ',';
			}
	}

	if ($CFG['admin']['photos']['upload_photo_capture'] && $photoupload->mugshot_licence_validation)
	{
		$more_tabs_div .= "'selCaptureContent'";
		$more_tabs_class .= "'selHeaderCapturePhoto'";
	}
	$more_tabs_div .= ');';
	$more_tabs_class .= ');';
?>
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/root/css/<?php echo $CFG['html']['stylesheet']['screen']['default'];?>/mugshot_avatar.css">
<script type="text/javascript">
var show_div = '<?php echo $photoupload->show_div; ?>';
<?php
	echo $more_tabs_div;
	echo $more_tabs_class;
?>
var current_active_tab_class = 'clsActive';

$Jq(document).ready(function(){
	hideMoreTabsDivs(show_div); //To hide the more tabs div and set the class to empty
	showMoreTabsDivs(show_div); //To show the more tabs div and set the class to selected
});

function loadUploadType(path, div_id, current_li_id)
{
	var pars ='';
	var div_value = $Jq('#'+div_id).html();
	result_div = div_id;
	more_li_id = current_li_id;
	div_value = $Jq.trim(div_value);

	if(div_value == '')
	{
		hideMoreTabsDivs(div_id);
		showMoreTabsDivs(div_id);
		$Jq('#'+div_id).html(photo_ajax_page_loading);
		new jquery_ajax(path, pars, 'insertUploadContent');
	}
	else
	{
		hideMoreTabsDivs(div_id);
		showMoreTabsDivs(div_id);
	}
}

function insertUploadContent(data)
{
	data = unescape(data);
	var script_data = '';
	var obj = $Jq('#'+result_div);
	obj.css('display', 'block');
	if(result_div == 'selMultiUploadContent')
	{
		if(data.indexOf('#~~~#')>=1)
		{
			data = data.split('#~~~#');
			script_data = data[0];
			data = data[1];
		}
	}
	obj.html(data);
	if(script_data != '')
		eval(script_data);
}

</script>

<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
<script type="text/javascript" language="javascript">

	function uploadCapturePhoto(rawData){
		var url    = '<?php echo $CFG['site']['photo_url'].'photoUploadPopUp.php';?>';
		var pars   = 'ajax=1&capturedPhoto='+rawData;
		var site_url = '<?php echo $CFG['site']['url'];?>';
		var template_default = '<?php echo $CFG['html']['template']['default']; ?>';
		var loadingImage = "<img src='"+site_url+"/design/templates/"+template_default+"/images/loader.gif"+"' alt='loading'\/>";

		$Jq.ajax({
			type: 'POST',
			url: url,
			data: pars,
			beforeSend:function(){
				$Jq('#displayLoderImage').css('display', 'block');
				$Jq('#displayLoderImage').html(loadingImage);
			},
			success:function (data){
				data = data.split("|");
				if(data[0] == 'Y'){
					$Jq('#displayLoderImage').html('<?php echo $LANG['profileavatar_success_update_message'];?>');
					document.selFormEditPersonalProfile.submit();
				}else{
					alert('<?php echo $LANG['common_msg_error_sorry'];?>');
				}
			}
		});
	}

</script>
<?php
}
?>
<script type="text/javascript">
var block_arr= new Array('selMsgConfirm');
/**
 *
 * @access public
 * @return void
 **/
function checkPublic(vali)
{
	var obj =document.getElementsByName('photo_album_type_'+vali);
	var rad_val = '';
	for (var i=0; i < obj.length; i++)
    {
   		if (obj[i].checked)
      	{
      		rad_val = obj[i].value;
      	}
   	}
  	if(rad_val == 'Private')
	{
		$Jq('#selAlbumId_'+vali).css('display', 'block');
		$Jq('#selAlbumName_'+vali).css('display', 'none');
		$Jq('#photo_album_'+vali).val('');

	}
	else
	{
		var txtvalue = eval('old_photo_album_name_'+vali);
		$Jq('#photo_album_'+vali).val(txtvalue);
		$Jq('#selAlbumId_'+vali).css('display', 'none');
		$Jq('#selAlbumName_'+vali).css('display', 'block');
	}

}
/**
 *
 * @access public
 * @return void
 **/
 function cancelCreateNewAlbum(vali)
 {
 	$Jq('#selAlbumId_'+vali).css('display', 'block');
 	$Jq('#album_id_'+vali).val('');
 	$Jq('#selAlbumName_'+vali).css('display', 'none');
	$Jq('#selAlbumOk_'+vali).css('display', 'none');
	$Jq('#selAlbumNewCancel_'+vali).css('display', 'none');
 }
/**
 *
 * @access public
 * @return void
 **/
var album_name = '';
var valueofi = '';
var totalphoto = '';
function savePublicAlbum(albumeval,vali,total_photo)
{
	if(albumeval=='')
	{
		alert('<?php echo $LANG['photoupload_photo_album_name_err'];?>');
		return false;
	}
	var obj =document.getElementsByName('photo_album_type_'+vali);
	var rad_val = '';
	for (var i=0; i < obj.length; i++)
    {
   		if (obj[i].checked)
      	{
      		rad_val = obj[i].value;
      	}
   	}
	if(rad_val == 'Private')
	{
		var url    = '<?php echo $CFG['site']['photo_url'].'photoUploadPopUp.php';?>';
		url  = url+'?ajax_page=true&new_album_name='+albumeval;
		var site_url = '<?php echo $CFG['site']['url'];?>';
		var template_default = '<?php echo $CFG['html']['template']['default']; ?>';
		var loadingImage = "<img src='"+site_url+"/design/templates/"+template_default+"/images/loader.gif"+"' alt='loading'\/>";
		$Jq('#selLoadImg_'+vali).css('display', 'block');
		$Jq('#selLoadImg_'+vali).html(loadingImage);
		album_name = albumeval;
		valueofi = vali;
		totalphoto = total_photo;
		var myAjaxNewAlbum = new jquery_ajax(url, '', 'storeAlbumValue');
	}
	else
	{
		$Jq('#selAlbumOk_'+vali).css('display', 'none');
		$Jq('#selAlbumNewCancel_'+vali).css('display', 'none');
	}
}
function storeAlbumValue(data)
{
	data = data.split("|");
	if(data[1] == 'Sucess')
	{
		$Jq('#selLoadImg_'+valueofi).css('display', 'none');
		$Jq('#selAlbumOk_'+valueofi).css('display', 'none');
		$Jq('#selAlbumNewCancel_'+valueofi).css('display', 'none');
		for (var i=0; i < totalphoto;++i)
		{
			//var select = document.getElementById('album_id_'+i);
			var select = $Jq('#album_id_'+i).get(0);
			select.options[select.options.length] = new Option(album_name, data[0]);
		}
	}
	else
	{
		$Jq('#selLoadImg_'+valueofi).css('display', 'none');
		alert('<?php echo $LANG['common_msg_error_sorry'];?>');

	}

}
function chkAlbumValue(slected_value,vali)
{
	if(slected_value == 'new')
	{
		var obj =document.getElementsByName('photo_album_type_'+vali);
		var rad_val = '';
		for (var i=0; i < obj.length; i++)
	    {
	   		if (obj[i].checked)
	      	{
	      		rad_val = obj[i].value;
	      	}
	   	}
		if(rad_val == 'Private')
		{
			$Jq('#selAlbumId_'+vali).css('display', 'none');
			$Jq('#selAlbumName_'+vali).css('display', 'block');
			$Jq('#selAlbumOk_'+vali).css('display', 'block');
			$Jq('#selAlbumNewCancel_'+vali).css('display', 'block');
			$Jq('#photo_album_'+vali).val('');
		}
		else
		{
			var txtvalue = eval('old_photo_album_name_'+vali);
			$Jq('#photo_album_'+vali).val(txtvalue);
			$Jq('#selAlbumId_'+vali).css('display', 'none');
			$Jq('#selAlbumName_'+vali).css('display', 'block');
			$Jq('#selPhotoAlbumTextBox_'+vali).css('display', 'block');
		}

	}
}
/**
 *
 * @access public
 * @return void
 **/
function loadCapturePhoto()
{
	$Jq('#selCaptureContent').css('display', 'block');
	$Jq('#selExternalUploadContent').css('display', 'none');
	$Jq('#selNormalUploadContent').css('display', 'none');
	$Jq('#selMultiUploadContent').css('display', 'none');
}
function populatePhotoSubCategory(cat)
{
	var url = '<?php echo $CFG['site']['photo_url'].'photoUploadPopUp.php';?>';
	var pars = 'ajax_page=true&cid='+cat;
	<?php if($photoupload->getFormField('photo_sub_category_id')){?>
		pars = pars+'&photo_sub_category_id=<?php echo $photoupload->getFormField('photo_sub_category_id');?>';
	<?php }?>
	var method_type = 'post';
	populateSubCategoryRequest(url, pars, method_type);
}
<?php if($photoupload->getFormField('photo_category_id')){?>
	populatePhotoSubCategory('<?php echo $photoupload->getFormField('photo_category_id'); ?>');
<?php }?>
</script>
<?php
if ($CFG['feature']['jquery_validation'])
{
	if ($photoupload->isShowPageBlock('block_photoupload_step2'))
	{
		$photo_title_arr_rules='';
		$photo_title_arr_messages='';
		//Code to validate photo title in multi upload and other photo upload options
		for($i=0;$i<$photoupload->getFormField('total_photos');$i++)
		{
			$photo_title_id = 'photo_title_'.$i;
			$photo_title_arr_rules .= '"'.$photo_title_id.'":{ required:true },';
			$photo_title_arr_messages .= '"'.$photo_title_id.'":{ required:"'.$LANG['common_err_tip_required'].'"},';
		}
?>
		<script type="text/javascript">
			var tag_min='<?php echo  $CFG['fieldsize']['photo_tags']['min']; ?>';
			var tag_max='<?php echo  $CFG['fieldsize']['photo_tags']['max']; ?>';
			$Jq("#photo_upload_form").validate({
				rules: {
					<?php echo $photo_title_arr_rules; ?>
				    photo_category_id: {
				    	required: true
				    },
				    photo_tags: {
						required: true,
						chkValidTags: Array(tag_min, tag_max)
				    },
				    photo_category_id: {
			            required: "div#selGeneralCategory:visible"
					 },
					photo_category_id_porn: {
			            required: "div#selPornCategory:visible"
					 }
				},
				messages: {
					<?php echo $photo_title_arr_messages; ?>
					photo_category_id: {
						required: "<?php echo $LANG['common_err_tip_required'];?>"
					},
					photo_tags: {
						required: "<?php echo $LANG['common_err_tip_required'];?>",
						chkValidTags: "<?php echo $LANG['common_err_tip_invalid_tag'];?>"
					},
					photo_category_id: {
						required: "<?php echo $LANG['common_err_tip_required'];?>"
					},
					photo_category_id_porn: {
						required: "<?php echo $LANG['common_err_tip_required'];?>"
					}
				}
			});
		</script>
<?php
	}
}
$photoupload->includeFooter();
?>
