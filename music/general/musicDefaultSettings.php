<?php
/**
 * MusicDefaultSettings
 *
 * @package		general
 * @author 		mangalam_020at09
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @access 		public
 **/
class MusicDefault extends MusicUploadLib
	{
		public $music_url = '';
		public $hidden_arr = array();
		public $multi_hidden_arr = array();
		public $fp = false;

		/**
		 * MusicDefault::validationFormFields1()
		 *
		 * @return void
		 */
		public function validationFormFields1()
		{
			$this->chkIsNotEmpty('music_category_id', $this->LANG['common_err_tip_required']);
			$this->chkIsNotEmpty('music_title', $this->LANG['common_err_tip_required']);
			$this->chkIsNotEmpty('music_tags', $this->LANG['common_err_tip_required']) and
				$this->chkValidTagList('music_tags',$this->LANG['common_err_tip_invalid_tag']);
			$this->checkValidDate($this->LANG['musicupload_err_tip_invalid_date']);
		}

		/**
		 * MusicDefault::chkIsEditMode()
		 *
		 * @return boolean
		 */
		public function chkIsEditMode()
		{
			$sql = 'SELECT user_id FROM '.
					$this->CFG['db']['tbl']['music_user_default_settings'].
					' WHERE user_id='.$this->dbObj->Param('user_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if($row = $rs->FetchRow())
				return true;
			return false;
		}

		public function updateMusicDetailsForUpload($fields_arr = array())
		{
			$param_value_arr = array();
			if($this->chkIsEditMode())
				$sql = 'UPDATE '.
						$this->CFG['db']['tbl']['music_user_default_settings'].
						' SET ';
			else
				$sql = 'INSERT INTO '.
					   	$this->CFG['db']['tbl']['music_user_default_settings'].
					   	' SET ';
			foreach($fields_arr as $key => $fieldname)
			{
				$param_value_arr[] = $this->fields_arr[$fieldname];
				$sql .= $fieldname.'='.$this->dbObj->Param($fieldname).', ';
			}
			if($this->chkIsEditMode())
			{
				$sql = substr($sql, 0, strrpos($sql, ','));
				$sql .= ' WHERE user_id='.$this->dbObj->Param('user_id');
			}
			else
				$sql .= ' user_id='.$this->dbObj->Param('user_id');

			$param_value_arr[] = $this->CFG['user']['user_id'];
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, $param_value_arr);

			if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);
		}

		/**
		 * MusicDefault::populateMusicCatagory()
		 *
		 * @param string $type
		 * @param string $err_tip
		 * @return boolean
		 */
		public function populateMusicCatagory($type = 'General', $err_tip='')
		{
			$sql = 'SELECT music_category_id, music_category_name FROM '.
					$this->CFG['db']['tbl']['music_category'].
					' WHERE parent_category_id=0'.
					' AND music_category_status=\'Yes\''.
					' AND music_category_type='.$this->dbObj->Param('music_category_type').
					' AND allow_post=\'Yes\'';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($type));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if(!$rs->PO_RecordCount())
				return;

			$names = array('music_category_name');
			$value = 'music_category_id';
			$highlight_value = $this->fields_arr['music_category_id'];

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
		 * MusicDefault::populateMusicSubCatagory()
		 *
		 * @param integer $cid
		 * @return void
		 */
		public function populateMusicSubCatagory($cid)
		{
			$sql = 'SELECT music_category_id, music_category_name FROM '.
					$this->CFG['db']['tbl']['music_category'].
					' WHERE parent_category_id='.$this->dbObj->Param('parent_category_id').
					' AND music_category_status=\'Yes\' AND allow_post=\'Yes\'';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($cid));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);

			$names = array('music_category_name');
			$value = 'music_category_id';
			$highlight_value = $this->fields_arr['music_sub_category_id'];
			?><select name="music_sub_category_id" id="music_sub_category_id">
				<option value=""><?php echo $this->LANG['common_select_option'];?></option>
			<?php

			while($row = $rs->FetchRow())
				{
					$out = '';
					$selected = $highlight_value == $row[$value]?' selected':'';
					foreach($names as $name)
						$out .= $row[$name].' ';
					?>
					<option value="<?php echo $row[$value];?>"<?php if($this->fields_arr['music_sub_category_id']==$row[$value]){ echo " selected";}?>><?php echo $out;?></option>
					<?php
				}
			?></select><?php
		}


		/**
		 * MusicDefault::validateCommonFormFields()
		 *  To validate common Form fields
		 *
		 * @return void
		 */
		public function validateCommonFormFields()
		{
			$this->chkIsNotEmpty('music_category_id', $this->LANG['common_music_err_tip_compulsory']);
			$this->chkIsNotEmpty('music_tags', $this->LANG['common_music_err_tip_compulsory']) and
			$this->chkValidTagList('music_tags', 'music_tags', $this->LANG['common_music_err_tip_invalid_tag']);
			if($this->getFormField('for_sale')=='Yes')
			{
				$this->chkIsNotEmpty('music_price', $this->LANG['common_music_err_tip_compulsory']);
				if($this->getFormField('preview_start'))
					$this->chkIsNumeric('preview_start', $this->LANG['musicupload_msg_success_numbers_only']);
				if($this->getFormField('preview_end'))
					$this->chkIsNumeric('preview_end', $this->LANG['musicupload_msg_success_numbers_only']);
			}

		}

		public function chkIsValidPreviewEnd($err_tip = '')
		{
			if($this->getFormField('preview_start')> $this->getFormField('preview_end'))
			{
				$this->fields_err_tip_arr['preview_end'] = $err_tip;
				return false;
			}
			return true;
		}

	public function populatePaymentDetailsToEdit()
	{
		$sql = 'SELECT paypal_id, threshold_amount FROM '.
				$this->CFG['db']['tbl']['music_user_payment_settings'].
				' WHERE user_id = '.$this->dbObj->Param('user_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
			$this->dbObj->ErrorMsg(), E_USER_ERROR);
		if($row = $rs->FetchRow())
		{
			$this->fields_arr['paypal_id'] = $row['paypal_id'];
			$this->fields_arr['threshold_amount'] = $row['threshold_amount'];
		}
	}

	public function chkIsEditPaymentMode()
	{
		$sql = 'SELECT user_id FROM '.
				$this->CFG['db']['tbl']['music_user_payment_settings'].
				' WHERE user_id='.$this->dbObj->Param('user_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($row = $rs->FetchRow())
			return true;
		return false;
	}

	public function updateMusicPaymentDetails($fields_arr = array())
	{
		$param_value_arr = array();
		if($this->chkIsEditPaymentMode())
			$sql = 'UPDATE '.
					$this->CFG['db']['tbl']['music_user_payment_settings'].
					' SET ';
		else
			$sql = 'INSERT INTO '.
				   	$this->CFG['db']['tbl']['music_user_payment_settings'].
				   	' SET ';
		foreach($fields_arr as $key => $fieldname)
		{
			$param_value_arr[] = $this->fields_arr[$fieldname];
			$sql .= $fieldname.'='.$this->dbObj->Param($fieldname).', ';
		}
		if($this->chkIsEditPaymentMode())
		{
			$sql = substr($sql, 0, strrpos($sql, ','));
			$sql .= ' WHERE user_id='.$this->dbObj->Param('user_id');
		}
		else
			$sql .= ' user_id='.$this->dbObj->Param('user_id');

		$param_value_arr[] = $this->CFG['user']['user_id'];
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, $param_value_arr);

		if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);
	}

	public function validateFormFields1()
	{
		if($this->CFG['admin']['musics']['allowed_usertypes_to_upload_for_sale'] != 'None')
		{
			if($this->getFormField('paypal_id')!='')
				$this->chkIsValidEmail('paypal_id',$this->LANG['musicupdatepaymentsettings_err_msg_invalid']);
			$this->chkIsReal('threshold_amount',$this->LANG['musicupdatepaymentsettings_err_msg_invalid']);
			if($this->getFormField('threshold_amount')<$this->CFG['admin']['musics']['minimum_threshold_amount'])
				$this->fields_err_tip_arr['threshold_amount'] = $this->LANG['musicupdatepaymentsettings_err_msg_invalid_amount'];
		}

	}

	public function uploadArtistPromoPhotoFile()
	{
		$htmlstring = trim(urldecode($this->getFormField('artist_promo_caption')));
		$htmlstring = html_entity_decode(stripslashes($htmlstring));
		$this->setFormField('artist_promo_caption', $htmlstring);
		$file_ext = $this->fields_arr['image_ext'];
		if($this->chkFileNameIsNotEmpty('artist_promo_file', ''))
			$file_ext = strtolower(substr($_FILES['artist_promo_file']['name'], strrpos($_FILES['artist_promo_file']['name'], '.')+1));
		$sql = 'SELECT user_id, music_artist_promo_image_id FROM '.
				$this->CFG['db']['tbl']['music_artist_promo_image'].
				' WHERE user_id='.$this->dbObj->Param('user_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
			$this->dbObj->ErrorMsg(), E_USER_ERROR);
		if($row = $rs->FetchRow())
		{
			$value_array = array($this->CFG['user']['user_id'], $this->fields_arr['artist_promo_caption'], $file_ext, $this->CFG['user']['user_id']);
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_artist_promo_image'].
				' SET user_id = '.$this->dbObj->Param('user_id').
				' , artist_promo_caption = '.$this->dbObj->Param('artist_promo_caption').
				' , image_ext = '.$this->dbObj->Param('image_ext').
				' , date_added = NOW()'.
				' WHERE user_id='.$this->dbObj->Param('user_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, $value_array);
			if (!$rs)
				trigger_db_error($this->dbObj);

			//Get image name//
			$insert_id = $row['music_artist_promo_image_id'];

		}
		else
		{
		//insert music_artist_image table//
		$value_array = array($this->CFG['user']['user_id'], $this->fields_arr['artist_promo_caption'], $file_ext);
			$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_artist_promo_image'].
				' SET user_id = '.$this->dbObj->Param('user_id').
				' , artist_promo_caption = '.$this->dbObj->Param('artist_promo_caption').
				' , image_ext = '.$this->dbObj->Param('image_ext').
				' , date_added = NOW()';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, $value_array);
			if (!$rs)
				trigger_db_error($this->dbObj);

			//Get image name//
			$insert_id = $this->dbObj->Insert_ID();

		}

		//Get image extension//
		//Artist music list path [../files/musics/artist_images/]//
		if($this->chkFileNameIsNotEmpty('artist_promo_file', ''))
		{
			$artist_image_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['music_folder'].'/'.$this->CFG['admin']['musics']['artist_promo_image_folder'].'/';
			$this->chkAndCreateFolder($artist_image_dir);
			$extern = strtolower(substr($_FILES['artist_promo_file']['name'], strrpos($_FILES['artist_promo_file']['name'], '.')+1));
			$imageObj = new ImageHandler($_FILES['artist_promo_file']['tmp_name']);
			$this->setIHObject($imageObj);
			$upload_path = $artist_image_dir.$insert_id;

			//Resize the image..
			$this->storeArtistPromoImagesTempServer($upload_path, $file_ext);

			//Update artist image detail..
			$this->updateArtistPromoImageDetail($insert_id);
		}
	}

	public function updateArtistPromoImageDetail($insert_id)
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_artist_promo_image'].' SET '.
				'large_width='.$this->dbObj->Param('large_width').', large_height='.$this->dbObj->Param('large_height').', '.
				'thumb_width='.$this->dbObj->Param('thumb_width').', thumb_height='.$this->dbObj->Param('thumb_height').', '.
				'small_width='.$this->dbObj->Param('small_width').', small_height='.$this->dbObj->Param('small_height').', '.
				'medium_width='.$this->dbObj->Param('medium_width').', medium_height='.$this->dbObj->Param('medium_height').' '.
				'WHERE music_artist_promo_image_id = '.$this->dbObj->Param('music_artist_promo_image_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->L_WIDTH, $this->L_HEIGHT, $this->T_WIDTH, $this->T_HEIGHT, $this->S_WIDTH, $this->S_HEIGHT, $this->M_WIDTH, $this->M_HEIGHT, $insert_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		return true;
	}

	/**
		 * MusicDefault::chkFileNameIsNotEmpty()
		 *
		 * @param mixed $field_name
		 * @param string $err_tip
		 * @return
		 */
		public function chkFileNameIsNotEmpty($field_name, $err_tip = '')
		{
			if(!$_FILES[$field_name]['name'])
				{
					return false;
				}
			return true;
		}

		/**
		 * MusicDefault::chkValidMusicFileType()
		 *
		 * @param $field_name
		 * @param string $err_tip
		 * @return
		 **/
		public function chkValidMusicFileType($field_name, $err_tip = '')
		{
			$this->chkValidFileType($field_name, $this->CFG['admin']['musics']['artist_promo_allowed_image_type'], $err_tip = '');
		}

		/**
		 * MusicDefault::chkValideFileSize()
		 *
		 * @param $field_name
		 * @param string $err_tip
		 * @return
		 **/
		public function chkValideFileSize($field_name, $err_tip='')
		{
			$max_size = $this->CFG['admin']['musics']['artist_promo_image_size'] * 1024;
			if ($_FILES[$field_name]['size'] > $max_size)
				{

					$this->fields_err_tip_arr[$field_name] = $err_tip;
					return false;
				}
			return true;
		}

		/**
		 * MusicDefault::chkErrorInFile()
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

		/**
		 * MusicDefault::populateArtistInfoDetails()
		 *
		 * @return
		 */
		public function populateArtistInfoDetailsForEdit()
		{
			global $smartyObj;
			$sql = 'SELECT u.user_id,u.user_name,ma.artist_promo_caption, ma.image_ext, ma.medium_width, ma.medium_height,ma.music_artist_promo_image_id'.
					' FROM '.
					$this->CFG['db']['tbl']['users'].' as u LEFT JOIN '.$this->CFG['db']['tbl']['music_artist_promo_image'].
					' as ma ON u.user_id=ma.user_id '.
					' WHERE ma.user_id='.$this->dbObj->Param('user_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);
			if($row = $rs->FetchRow())
			{
				$artist_promo_image_path = $this->CFG['site']['url'].$this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['music_folder'].'/'.$this->CFG['admin']['musics']['artist_promo_image_folder'].'/';
				$this->fields_arr['artist_promo_caption'] = $row['artist_promo_caption'];
				$this->fields_arr['artist_promo_image'] = $artist_promo_image_path.$row['music_artist_promo_image_id'].$this->CFG['admin']['musics']['artist_promo_medium_name'].'.'.$row['image_ext'].'?'.time();
				$this->fields_arr['image_ext'] = $row['image_ext'];
			}
		}

	public function populateDefaultMusicDetails()
	{
		$sql = 'SELECT music_category_id, relation_id,music_language,music_sub_category_id,music_tags, music_access_type,allow_comments,'.
	  			' allow_ratings, allow_download, allow_embed, allow_lyrics,for_sale, music_price,preview_start,preview_end'.
	  			' FROM '.$this->CFG['db']['tbl']['music_user_default_settings'].
	  			' WHERE user_id='.$this->dbObj->Param('user_id');
	  	$stmt = $this->dbObj->Prepare($sql);
	  	$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
	  	if(!$rs)
	  		trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($row = $rs->FetchRow())
		{
			$this->fields_arr['music_tags'] = $row['music_tags'];
			$this->fields_arr['music_language'] = $row['music_language'];
			$this->fields_arr['music_category_id'] = $row['music_category_id'];
			$this->fields_arr['music_sub_category_id'] = $row['music_sub_category_id'];
			$this->fields_arr['allow_comments'] = $row['allow_comments'];
			$this->fields_arr['allow_ratings'] = $row['allow_ratings'];
			$this->fields_arr['allow_lyrics'] = $row['allow_lyrics'];
			$this->fields_arr['allow_embed'] = $row['allow_embed'];
			$this->fields_arr['music_access_type'] = $row['music_access_type'];
			$this->fields_arr['for_sale'] = $row['for_sale'];
			$this->fields_arr['music_price'] = $row['music_price'];

			if(isset($this->CFG['admin']['musics']['allow_members_to_choose_the_preview'])
				and $this->CFG['admin']['musics']['allow_members_to_choose_the_preview'])
			{
				$this->fields_arr['preview_start'] = $row['preview_start'];
				$this->fields_arr['preview_end'] = $row['preview_end'];
			}

			if($row['relation_id'] and $row['music_access_type']=='Private')
				$this->fields_arr['relation_id_default'] = $row['relation_id'];
		}
	}


}

$MusicDefault = new MusicDefault();

if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
//CHECKED THE CONDITION IF ALLOWED THE MUSIC UPLOAD FOR FAN MEMBER
if(!isAllowedMusicUpload())
	Redirect2URL(getUrl('musiclist', '?pg=upload_music', 'upload_music/', '', 'music'));
$MusicDefault->setPageBlockNames(array('block_music_default_form','block_music_artist_default_form'));

$MusicDefault->show_div = '';

if(strpos($CFG['site']['current_url'], '/admin/'))
	$MusicDefault->left_navigation_div = 'musicMain';
//default form fields and values...
$MusicDefault->resetFieldsArray();
$MusicDefault->setFormField('music_upload_type', 'Normal');
$MusicDefault->setFormField('paypal_id', '');
$MusicDefault->setFormField('page', '');
$MusicDefault->setFormField('artist_promo_caption', '');
$MusicDefault->setFormField('image_ext', '');
$MusicDefault->setFormField('artist_promo_image', '');
$MusicDefault->setFormField('threshold_amount', '');
$MusicDefault->setFormField('artist_promo_caption', '');
$MusicDefault->setMediaPath('../');
if($MusicDefault->chkIsEditMode())
	$MusicDefault->populateDefaultMusicDetails();

if($MusicDefault->chkIsEditPaymentMode())
	$MusicDefault->populatePaymentDetailsToEdit();

$MusicDefault->setAllPageBlocksHide();
$MusicDefault->setPageBlockShow('block_music_default_form');

$MusicDefault->hidden_arr = array('total_musics');

$LANG['music_common_err_tip_invalid_tag'] = str_replace('VAR_MIN', $CFG['fieldsize']['music_tags']['min'],
													$LANG['common_music_err_tip_invalid_tag']);
$LANG['music_common_err_tip_invalid_tag'] = str_replace('VAR_MAX', $CFG['fieldsize']['music_tags']['max'],
													$LANG['common_music_err_tip_invalid_tag']);

//$LANG['musicupload_msg_upload_success']

$MusicDefault->edit_completed = false;
$CFG['feature']['auto_hide_success_block'] = false;
$smartyObj->assign('artist_class','');
$smartyObj->assign('default_class','clsActive');
$MusicDefault->LANG_LANGUAGE_ARR = $LANG_LIST_ARR['language'];
$MusicDefault->sanitizeFormInputs($_REQUEST);
$MusicDefault->image_format =  implode(', ', $CFG['admin']['musics']['artist_promo_allowed_image_type']);
if($MusicDefault->getFormField('page')=='artist')
{
	$MusicDefault->populateArtistInfoDetailsForEdit();
	$smartyObj->assign('artist_class','clsActive');
	$smartyObj->assign('default_class','');
	$MusicDefault->setAllPageBlocksHide();
	$MusicDefault->setPageBlockShow('block_music_artist_default_form');
}

if(isAjaxPage())
{
	if($MusicDefault->isFormPOSTed($_POST, 'cid')) //Populate SubCategory
	{
		$MusicDefault->includeAjaxHeaderSessionCheck();
		$MusicDefault->populateMusicSubCatagory($MusicDefault->getFormField('cid'));
		$MusicDefault->includeAjaxFooter();
		exit;
	}

}
else
{

	if($MusicDefault->isFormPOSTed($_POST, 'upload_music')) //To Update other fields when uploading #also for edit music updation
	{
		$MusicDefault->setAllPageBlocksHide();
		$MusicDefault->sanitizeFormInputs($_POST);
		$MusicDefault->validateFormFields1();

		//$MusicDefault->validateCommonFormFields(); //To validate common fields
		$MusicDefault->chkIsValidPreviewEnd($LANG['musicupload_msg_end_time_valid']); //To validate common fields

		if($MusicDefault->isValidFormInputs())
		{
			$relation_ori = '';
			if($MusicDefault->getFormField('music_access_type')=='Private')
			{
				$relation_ori = $MusicDefault->getFormField('relation_id');
				$relation_id = implode(',',$MusicDefault->getFormField('relation_id'));
				$MusicDefault->setFormField('relation_id', $relation_id);
			}
			else
				$MusicDefault->setFormField('relation_id','');

			$fields_arr = array('music_category_id','music_sub_category_id','music_tags','music_language',
						'music_access_type','relation_id','allow_comments','allow_ratings','allow_embed','allow_lyrics',
						'for_sale','music_price','preview_start','preview_end');
			$MusicDefault->updateMusicDetailsForUpload($fields_arr);
			$MusicDefault->setFormField('relation_id',$relation_ori);
			$payment_fields_arr = array('paypal_id','threshold_amount');
			$MusicDefault->updateMusicPaymentDetails($payment_fields_arr);
			$MusicDefault->setCommonSuccessMsg($LANG['musicupload_msg_success_default_settings']);
			$MusicDefault->setPageBlockShow('block_music_default_form');
			$MusicDefault->setPageBlockShow('block_msg_form_success');
		}
		else
		{
			//$MusicDefault->populateAudioDetailsForUpload();
			$MusicDefault->setCommonErrorMsg($LANG['common_music_msg_error_sorry']);
			$MusicDefault->setPageBlockShow('block_msg_form_error');
			$MusicDefault->setPageBlockShow('block_music_default_form');

		}
	}

	if($MusicDefault->isFormPOSTed($_POST, 'upload'))
	{
		$MusicDefault->setAllPageBlocksHide();
		$MusicDefault->sanitizeFormInputs($_POST);
		if($MusicDefault->chkFileNameIsNotEmpty('artist_promo_file', $LANG['common_err_tip_compulsory']))
		{
			$MusicDefault->chkValidMusicFileType('artist_promo_file', $LANG['common_music_err_tip_invalid_file_type']) and
			$MusicDefault->chkValideFileSize('artist_promo_file', $LANG['common_music_err_tip_invalid_file_size']) and
			$MusicDefault->chkErrorInFile('artist_promo_file', $LANG['common_music_err_tip_invalid_file']);
		}
		if($MusicDefault->isValidFormInputs())
		{
			$MusicDefault->uploadArtistPromoPhotoFile();
			$MusicDefault->setCommonSuccessMsg($LANG['musicupload_msg_success_default_settings']);
			$MusicDefault->setPageBlockShow('block_msg_form_success');
			$MusicDefault->setPageBlockShow('block_music_artist_default_form');
		}
		else
		{
			$MusicDefault->setCommonErrorMsg($LANG['common_msg_error_sorry']);
			$MusicDefault->setPageBlockShow('block_msg_form_error');
			$MusicDefault->setPageBlockShow('block_music_artist_default_form');
		}
	}

}

$MusicDefault->musicUpload_tags_msg = str_replace(array('VAR_TAG_MIN_CHARS','VAR_TAG_MAX_CHARS'),
										array($CFG['fieldsize']['music_tags']['min'],$CFG['fieldsize']['music_tags']['max']),
											$LANG['musicupload_tags_msg1']);

$MusicDefault->content_filter = false;

if($MusicDefault->chkAllowedModule(array('content_filter')) && isAdultUser('','music'))
{
	$MusicDefault->content_filter = true;
	$MusicDefault->Porn = $MusicDefault->General = 'none';
	$music_category_type = $MusicDefault->getFormField('music_category_type');
	$$music_category_type = '';
}
else
{
	$MusicDefault->Porn = $MusicDefault->General = '';
}
if($MusicDefault->getFormField('music_category_type') == 'General')
{
	$MusicDefault->General ='';
}
else
{
	$MusicDefault->Porn = '';
}

$MusicDefault->includeHeader();
?>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url']; ?>js/lib/validation/validation.js"></script>

<?php
setTemplateFolder('general/', 'music');
$smartyObj->display('musicDefaultSettings.tpl');

?>
<script type="text/javascript">
var block_arr= new Array('selMsgConfirm');
function populateMusicSubCategory(cat)
	{
		var url = '<?php echo $CFG['site']['music_url'].'musicDefaultSettings.php';?>';
			var pars = 'ajax_page=true&cid='+cat;
			<?php if($MusicDefault->getFormField('music_sub_category_id')){?>
			pars = pars+'&music_sub_category_id=<?php echo $MusicDefault->getFormField('music_sub_category_id');?>';
			<?php }?>
			var method_type = 'post';
			populateSubCategoryRequest(url, pars, method_type);
	}
<?php if($MusicDefault->getFormField('music_category_id')){?>
	populateMusicSubCategory('<?php echo $MusicDefault->getFormField('music_category_id'); ?>');
<?php }?>
</script>
<?php
if ($MusicDefault->isShowPageBlock('block_music_default_form') and $CFG['feature']['jquery_validation'] and $CFG['admin']['musics']['allowed_usertypes_to_upload_for_sale'] != 'None')
{
	?>
	<script type="text/javascript">
		$Jq("#music_upload_form").validate({
			rules: {
				threshold_amount: {
					required: true
			    }
			},
			messages: {
				threshold_amount: {
					required: "<?php echo $MusicDefault->LANG['common_err_tip_compulsory'];?>"
				}
			}
		});
	</script>
	<?php
}
$MusicDefault->includeFooter();
?>