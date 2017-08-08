<?php
/**
 * This file is to share the music
 *
 * This file is having ShareMusic class to share the music
 *
 *
 * @category	rayzz
 * @package		Index
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 *
 **/

require_once('../common/configs/config.inc.php');

$CFG['lang']['include_files'][] = 'languages/%s/music/createAlbum.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['lang']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['lang']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicActivityHandler.lib.php';

$CFG['site']['is_module_page'] = 'music';
$CFG['auth']['is_authenticate'] = 'members';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;

require_once($CFG['site']['project_path'].'common/application_top.inc.php');

class CreateAlbum extends MusicHandler
{
	public function validateFormFields1()
	{
		$this->chkIsNotEmpty('album_title', $this->LANG['common_js_required']);
		$this->chkIsAlredyExists($this->LANG['createalbum_err_msg_already_exists']);
		if($this->CFG['admin']['musics']['allowed_usertypes_to_upload_for_sale'] != 'None')
		{
			if($this->getFormField('album_for_sale')=='Yes')
			{
				$this->chkIsNotEmpty('album_price', $this->LANG['common_js_required']) and
				$this->chkIsReal('album_price',$this->LANG['createalbum_err_msg_numbers_only']);
			}
		}
	}

	public function chkIsAlredyExists($err_tip = '')
	{
		$sql = 'SELECT album_title FROM '.
				$this->CFG['db']['tbl']['music_album'].
				' WHERE album_title ='.$this->dbObj->Param('album_title').
				' AND album_access_type = \'Private\'';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->getFormField('album_title')));
		if (!$rs)
			trigger_db_error($this->dbObj);
		if($row = $rs->FetchRow())
		{
		//	echo 'inside';
			$this->fields_err_tip_arr['album_title'] = $err_tip;
			//return false;
		}
		return true;
	}

	public function addNewAlbum()
	{
		$param_arr = array($this->getFormField('album_title'),$this->getFormField('album_access_type'),
							$this->getFormField('album_price'), $this->getFormField('album_for_sale'),
							$this->CFG['user']['user_id']);
		$sql = 'INSERT INTO '.
				$this->CFG['db']['tbl']['music_album'].
				' SET '.
				' album_title ='.$this->dbObj->Param('album_title').','.
				' album_access_type ='.$this->dbObj->Param('album_access_type').','.
				' album_price ='.$this->dbObj->Param('album_price').','.
				' album_for_sale ='.$this->dbObj->Param('album_for_sale').','.
				' user_id ='.$this->dbObj->Param('user_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, $param_arr);
		if (!$rs)
			trigger_db_error($this->dbObj);
		return $this->dbObj->Insert_ID();
	}

	public function populateMusicAlbumPrice($album_id)
	{
		$sql = 'SELECT album_price FROM '.
				$this->CFG['db']['tbl']['music_album'].
				' WHERE music_album_id ='.$this->dbObj->Param('music_album_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($album_id));
		if (!$rs)
			trigger_db_error($this->dbObj);
		if($row = $rs->FetchRow())
		{
			return $row['album_price'];
		}
	}


}

//-------------------- Code begins -------------->>>>>//
$createalbum = new CreateAlbum();

if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$createalbum->setPageBlockNames(array('form_success', 'share_music_block',
										'form_create_album', 'block_album_selector'));

//default form fields and values...
$createalbum->setFormField('music_id', '');
$createalbum->setFormField('album_title', '');
$createalbum->setFormField('album_for_sale', 'Yes');
$createalbum->setFormField('album_price', '');
$createalbum->setFormField('album_access_type', '');
//for ajax
$createalbum->setFormField('ajax_page', '');
$createalbum->setFormField('page', '');
$createalbum->setFormField('id', '');

//Default page Block
$createalbum->setAllPageBlocksHide();
$createalbum->sanitizeFormInputs($_REQUEST);
$createalbum->setPageBlockShow('form_create_album');
if(!isAjaxpage())
{
	$createalbum->includeHeader();
	if($createalbum->getFormField('page') == 'music')
	{
?>
		<script type="text/javascript" src="<?php echo $CFG['site']['music_url'].'js/functions.js';?>">
		</script>
<?php
	}
	setTemplateFolder('members/', 'music');
	$smartyObj->display('createAlbum.tpl');
}
else
{
	$createalbum->includeAjaxHeader();
	if($createalbum->getFormField('ajax_page') and $createalbum->getFormField('page')=='save')
	{
		$createalbum->validateFormFields1();
		if($createalbum->isValidFormInputs())
		{
			$id = $createalbum->addNewAlbum();
			echo $id;
			//$createalbum->populateMusicAlbum('Private',$CFG['user']['user_id'], $id);
			exit;
		}
		else
		{
			echo '<<<Error>>>';
			$createalbum->setCommonErrorMsg($LANG['common_msg_error_sorry']);
			$createalbum->setAllPageBlocksHide();
			$createalbum->setPageBlockShow('block_msg_form_error');
			$createalbum->setPageBlockShow('form_create_album');
		}

	}
	else if($createalbum->getFormField('ajax_page') and $createalbum->getFormField('page')=='getdetails')
	{
		$createalbum->setAllPageBlocksHide();
?>
		<option value=""> <?php echo $LANG['common_select_option'];?></option>
<?php
		$createalbum->populateMusicAlbum('Private',$CFG['user']['user_id'], $createalbum->getFormField('id'));
		exit;
	}
	else if($createalbum->getFormField('ajax_page') and $createalbum->getFormField('page')=='getprice')
	{
		$createalbum->setAllPageBlocksHide();
		echo $createalbum->populateMusicAlbumPrice($createalbum->getFormField('id'));
		exit;
	}
	setTemplateFolder('members/', 'music');
	$smartyObj->display('createAlbum.tpl');
}



if(!isAjaxpage())
{
	$createalbum->includeFooter();
}
else
	$createalbum->includeAjaxFooter();
?>
