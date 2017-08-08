<?php
/**
 * This file is to create album
 *
 * This file is having CreateAlbum class to create album
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 **/
require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_video.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/createAlbum.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoHandler.lib.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/help.inc.php';
if(isset($_REQUEST['popup']) and $_REQUEST['popup'])
	{
		$CFG['html']['header'] = 'general/html_header_popup.php';
		$CFG['html']['footer'] = 'general/html_footer_popup.php';
	}
else
	{
		$CFG['html']['header'] = 'general/html_header.php';
		$CFG['html']['footer'] = 'general/html_footer.php';
		$CFG['mods']['is_include_only']['html_header'] = false;
		$CFG['html']['is_use_header'] = false;
	}
	$CFG['site']['is_module_page']='video';
require($CFG['site']['project_path'].'common/application_top.inc.php');

/**
 * Create the album
 *
 * @category	rayzz
 * @package		Members
 **/
class CreateAlbum extends VideoHandler
	{
		/**
		 * CreateAlbum::chkIsDuplicateTitle()
		 * check album title already exists or not
		 *
		 * @param  string $field_name
		 * @param  string $err_tip
		 * @return boolean
		 * @access public
		 **/
		public function chkIsDuplicateTitle($field_name, $err_tip = '')
			{
				$sql = 'SELECT count(1) as count FROM '.$this->CFG['db']['tbl'][$this->getFormField('table_name')].
						' WHERE user_id='.$this->dbObj->Param('user_id').' AND '.
						' album_title='.$this->dbObj->Param('album_title').' AND '.
						' video_album_id !='.$this->dbObj->Param('video_album_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr[$field_name], $this->fields_arr['video_album_id']));
			    if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if($row['count'])
					{
						$this->fields_err_tip_arr[$field_name] = $err_tip;
						return false;
					}
				return true;
			}

		/**
		 * CreateAlbum::insertVideoAlbumTable()
		 * insert the record into respect tables
		 *
		 * @param  array $fields_arr
		 * @param  string $err_tip
		 * @return void
		 * @access public
		 **/
		public function insertVideoAlbumTable($fields_arr, $err_tip='')
			{
				if($this->fields_arr['video_album_id'])
					{
						 $sql = 'UPDATE '.$this->CFG['db']['tbl']['video_album'].
							' SET album_title = '.$this->dbObj->Param('album_title').' '.
							' , album_description = '.$this->dbObj->Param('album_description').' '.
							' WHERE video_album_id = '.$this->dbObj->Param('video_album_id').' '.
							' AND user_id = '.$this->dbObj->Param($this->CFG['user']['user_id']);

						$value_arr = array($this->fields_arr['album_title'], $this->fields_arr['album_description'], $this->fields_arr['video_album_id'], $this->CFG['user']['user_id']);

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $value_arr);
						if (!$rs)
							trigger_db_error($this->dbObj);
					}
				else
					{
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl'][$this->getFormField('table_name')].' SET ';
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
					}
			}

		/**
		 * CreateAlbum::getModuleReferrerUrl()
		 *
		 * @return void
		 * @access public
		 **/
		public function getModuleReferrerUrl()
			{
				if(!$this->fields_arr['pcakey'])
					{
						if(isset($_SERVER['HTTP_REFERER']) and !strstr($_SERVER['HTTP_REFERER'],'createAlbum'))
							{
								$key = substr(md5(microtime()),0,10);
								if(!strstr($_SERVER['HTTP_REFERER'],'gpukey'))
									{
										if(!strstr($_SERVER['HTTP_REFERER'],'?'))
											$_SESSION['pcakey'][$key] = $_SERVER['HTTP_REFERER'].'?gpukey='.$this->fields_arr['gpukey'];
										else
											$_SESSION['pcakey'][$key] = $_SERVER['HTTP_REFERER'].'&gpukey='.$this->fields_arr['gpukey'];
									}
								else
									$_SESSION['pcakey'][$key] = $_SERVER['HTTP_REFERER'];
								$this->fields_arr['pcakey'] = $key;
							}
					}
				else
					{
						$key = substr(md5(microtime()),0,10);
						$_SESSION['gpukey'][$key] = getUrl('videouploadpopup','','','','video');
					}
			}

		/**
		 * CreateAlbum::redirecturl()
		 * redirect the url
		 *
		 * @return void
		 * @access public
		 **/
		public function redirecturl()
			{
				if($this->fields_arr['pcakey'])
				 Redirect2URL($_SESSION['pcakey'][$this->fields_arr['pcakey']]);
			}

		public function selectAlbum()
			{
				$sql = 'SELECT video_album_id, album_title, album_description FROM '.$this->CFG['db']['tbl'][$this->getFormField('table_name')].
						' WHERE user_id='.$this->dbObj->Param('user_id').' AND '.
						' video_album_id='.$this->dbObj->Param('video_album_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['video_album_id']));
			    if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if(empty($row))
					{
						return false;
					}
				else
					{
						$this->setFormField('video_album_id', $row['video_album_id']);
						$this->setFormField('album_title', $row['album_title']);
						$this->setFormField('album_description', $row['album_description']);
						return true;
					}
			}

	}

$CreateAlbum = new CreateAlbum();
$CreateAlbum->makeGlobalize($CFG,$LANG);
if(!chkAllowedModule(array('video')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$CreateAlbum->setPageBlockNames(array('create_album_form'));
$CreateAlbum->setFormField('album_title', '');
$CreateAlbum->setFormField('gpukey', '');
$CreateAlbum->setFormField('pcakey', '');
$CreateAlbum->setFormField('video_album_id', '');
$CreateAlbum->setFormField('album_description', '');
$CreateAlbum->setFormField('album_access_type', 'Public');
$CreateAlbum->setFormField('module', '');
$CreateAlbum->setFormField('table_name', '');
$CreateAlbum->setFormField('relation_id',array());
$CreateAlbum->setAllPageBlocksHide();
$CreateAlbum->setPageBlockShow('create_album_form');
$CreateAlbum->sanitizeFormInputs($_REQUEST);
$moduleName = $CreateAlbum->getFormField('module');
$CreateAlbum->setFormField('table_name', 'video_album');
$create_album_min_size=str_replace('{min}', $CFG['fieldsize']['album_name']['min'],$LANG['createalbum_err_tip_field_length']);
$CreateAlbum->LANG['help']['album_title']=str_replace('{max}', $CFG['fieldsize']['album_name']['max'],$create_album_min_size);
$create_album_lbl_min_size=str_replace('{min}', $CFG['fieldsize']['album_name']['min'],$LANG['createalbum_field_length_lbl']);
$CreateAlbum->LANG['createalbum_field_length_lbl']=str_replace('{max}', $CFG['fieldsize']['album_name']['max'],$create_album_lbl_min_size);

if($CreateAlbum->isFormPOSTed($_POST, 'cancel'))
	$CreateAlbum->redirecturl();
if ($CreateAlbum->getFormField('video_album_id'))
	{
		if(!$CreateAlbum->selectAlbum())
			{
				$CreateAlbum->setAllPageBlocksHide();
				$CreateAlbum->setPageBlockShow('block_msg_form_error');
				$CreateAlbum->setCommonErrorMsg($LANG['createalbum_invalid_album_id']);
				$CreateAlbum->form_album_create = array();
				$CreateAlbum->form_album_create['popup_value'] =0;
			}
	}
if($CreateAlbum->isFormPOSTed($_POST, 'create_album'))
	{
		$min = $CFG['fieldsize']['album_name']['min'];
		$max = $CFG['fieldsize']['album_name']['max'];

		$LANG['createalbum_err_tip_field_length']=str_replace(array('{min}','{max}'),array($min,$max),$LANG['createalbum_err_tip_field_length']);

		$CreateAlbum->sanitizeFormInputs($_REQUEST);
		$CreateAlbum->chkIsNotEmpty('album_title', $LANG['common_err_tip_required']) and
		$CreateAlbum->chkIsDuplicateTitle('album_title', $LANG['createalbum_err_tip_already_exist']);
		$CreateAlbum->chkIsValidSize('album_title', 'album_name',$LANG['createalbum_err_tip_field_length']);
		$CreateAlbum->chkIsNotEmpty('album_description', $LANG['common_err_tip_required']);
		if($CreateAlbum->isValidFormInputs())
			{

						$CreateAlbum->setFormField('user_id', $CFG['user']['user_id']);
				$CreateAlbum->setFormField('date_added', 'NOW()');
				if($CreateAlbum->getFormField('album_access_type')=='Private')
					$CreateAlbum->setFormField('relation_id',implode(',',$CreateAlbum->getFormField('relation_id')));
				else
					$CreateAlbum->setFormField('relation_id','');
				$CreateAlbum->insertVideoAlbumTable(array('user_id', 'album_title', 'album_description', 'album_access_type', 'date_added','relation_id'));
				$CreateAlbum->redirecturl();
				$CreateAlbum->setAllPageBlocksHide();
				$CreateAlbum->setPageBlockShow('block_msg_form_success');
				$CreateAlbum->setCommonErrorMsg($LANG['createalbum_msg_success_created']);
			}
		else
			{
				$CreateAlbum->setPageBlockShow('block_msg_form_error');
				$CreateAlbum->setCommonErrorMsg($LANG['common_msg_error_sorry']);
			}
	}
$CreateAlbum->getModuleReferrerUrl();
if($CreateAlbum->isShowPageBlock('create_album_form'))
	{
		$popup = (isset($_REQUEST['popup']) and $_REQUEST['popup'])?$_REQUEST['popup']:0;
		$CreateAlbum->form_album_create['form_action']       = getUrl('createalbum', '?popup='.$popup.'&module='.$moduleName, '?popup='.$popup.'&module='.$moduleName,'members','video');
		$CreateAlbum->form_album_create['popup_value']       = $popup;
		$CreateAlbum->form_album_create['form_hidden_value'] = array('pcakey');
	}
$CreateAlbum->includeHeader();
setTemplateFolder('members/','video');
$smartyObj->display('createalbum.tpl');
?>
<script type="text/javascript">
var myAlbumRedirectUrl='<?php echo $CreateAlbum->getUrl('myvideoalbums','','','members','video'); ?>';
function clearValue()
{
    window.location.href=myAlbumRedirectUrl;
}
</script>
<?php
/* Added code to validate mandataory fields in video defaut settings page */
if ($CFG['feature']['jquery_validation'])
{
?>
<script type="text/javascript">
$Jq("#create_album_form").validate({
	rules: {
	    album_title: {
	    	required: true,
	    	minlength: <?php echo $CFG['fieldsize']['album_name']['min']; ?>,
			maxlength: <?php echo $CFG['fieldsize']['album_name']['max']; ?>
		 },
		 album_description: {
	    	required: true
		 }
	},
	messages: {
		album_title: {
			required: "<?php echo $LANG['common_err_tip_required'];?>"
		},
		album_description: {
			required: "<?php echo $LANG['common_err_tip_required'];?>"
		}
	}
});
</script>
<?php
}
$CreateAlbum->includeFooter();
?>