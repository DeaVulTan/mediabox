<?php
/**
* This file is to manage the musics preview
*
* This file is having musicManage class to manage the musics
*
*
* @category	Rayzz
* @package		Admin
*
**/
require_once('../../common/configs/config.inc.php');
require_once('../../common/configs/config_music.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/admin/musicPreview.php';
require_once($CFG['site']['project_path'].'common/classes/class_FormHandler.lib.php');
require_once($CFG['site']['project_path'].'common/classes/class_MediaHandler.lib.php');
require_once($CFG['site']['project_path'].'common/classes/class_MusicHandler.lib.php');
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/help.inc.php';
$CFG['site']['is_module_page']='music';

//$CFG['html']['header'] = 'admin/html_header_popup.php';
$CFG['html']['header'] = 'admin/html_header_no_header.php';
//$CFG['html']['footer'] = 'admin/html_footer_popup.php';
$CFG['html']['footer'] = 'admin/html_footer_no_footer.php';

$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
/**
*
* @category	rayzz
* @package		Admin
**/
class MusicPreview extends MusicHandler
	{
		/**
		* MusicPreview::chkIsValidMusicId()
		*
		* @return
		**/
		public function chkIsValidMusicId()
			{
				$sql ='SELECT COUNT(DISTINCT p.music_id) AS music_id FROM'.' '.$this->CFG['db']['tbl']['music'].' as p'.						' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' as u'.
				' ON p.user_id=u.user_id'.' WHERE p.music_id='.$this->dbObj->Param($this->fields_arr['music_id']).' LIMIT 0,1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$row = $rs->FetchRow();
				if($row['music_id'])
					{
						return true;
					}
				return false;
			}
		/**
		* MusicPreview::populateMusicDetails()
		*
		* @return
		**/
		public function populateMusicDetails()
			{
				global $smartyObj;
				$sql = 'SELECT p.music_id,p.music_ext, p.rating_total, p.rating_count, p.user_id,'.' p.music_title, DATE_FORMAT(date_added,\''.$this->CFG['format']['date'].'\') as date_added,'.
				' p.music_server_url, p.large_width, p.large_height, u.user_name, u.first_name, u.last_name'.' FROM '.$this->CFG['db']['tbl']['music'].' as p'.
				' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' as u ON p.user_id=u.user_id'.' WHERE music_id='.$this->dbObj->Param($this->fields_arr['music_id']).' LIMIT 0,1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if($row = $rs->FetchRow())
					{

						$name = $this->CFG['format']['name'];
						$name = str_replace('$first_name', $row['first_name'],$name);
						$name = str_replace('$last_name', $row['last_name'],$name);
						$name = str_replace('$user_name', $row['user_name'],$name);
						$this->fields_arr['user_id'] = $row['user_id'];
						$this->fields_arr['music_id'] = $row['music_id'];
						$this->fields_arr['music_ext'] = $row['music_ext'];
						$this->fields_arr['music_server_url'] = $row['music_server_url'];
						$this->fields_arr['large_width'] = $row['large_width'];
						$this->fields_arr['large_height'] = $row['large_height'];
						$this->fields_arr['music_title'] = $row['music_title'];
						$this->fields_arr['date_added'] = $row['date_added'];
						$this->fields_arr['user_name'] = $name;
						$this->fields_arr['rating_total'] = $row['rating_total'];
						$this->fields_arr['rating_count'] = $row['rating_count'];
						return true;
					}

				return false;
			}
		/**
		* MusicPreview::checkIsExternalEmebedCode()
		*
		* @return
		*/
		public function checkIsExternalEmebedCode()
		{
		return false;
		}
	}
//<<<<<-------------- Class MusicPreview begins ---------------//
//-------------------- Code begins -------------->>>>>//
$MusicPreview = new MusicPreview();
$MusicPreview->setDBObject($db);
$MusicPreview->makeGlobalize($CFG,$LANG);
$MusicPreview->setPageBlockNames(array('msg_form_error', 'view_music_form'));
$MusicPreview->setCSSFormFieldErrorTipClass('clsFormFieldErrTip');
$MusicPreview->setCSSFormLabelCellDefaultClass('clsFormLabelCellDefault');
$MusicPreview->setCSSFormFieldCellDefaultClass('clsFormFieldCellDefault');
$MusicPreview->setCSSFormLabelCellErrorClass('clsFormLabelCellError');
$MusicPreview->setCSSFormFieldCellErrorClass('clsFormFieldCellError');
//default form fields and values...
$MusicPreview->setFormField('music_id', '');
$MusicPreview->setFormField('user_id', '');
$MusicPreview->setFormField('music_ext', '');
$MusicPreview->setFormField('user_name', '');
$MusicPreview->IS_USE_AJAX = true;

//START SINGLE PLAYER ARRAY FIELDS
$auto_play =  'false';
if($CFG['admin']['musics']['single_player']['AutoPlay'])
	$auto_play = 'true';

$music_fields = array(
	'music_player_id' => 'view_music_player',
	'height' => '',
	'width' => '',
	'auto_play' => $auto_play
);
$smartyObj->assign('music_fields', $music_fields);
//END SINGLE PLAYER ARRAY FIELDS

if($MusicPreview->isFormPOSTed($_REQUEST, 'music_id'))
	{
		$MusicPreview->sanitizeFormInputs($_REQUEST);
		if(!$MusicPreview->chkIsValidMusicId())
			{
				$MusicPreview->setAllPageBlocksHide();
				$MusicPreview->setCommonErrorMsg($LANG['msg_error_sorry']);
				$MusicPreview->setPageBlockShow('msg_form_error');
			}
		else
			{
				if($MusicPreview->populateMusicDetails())
					{
						$MusicPreview->setPageBlockShow('view_music_form');
					}
				else
					{
						$MusicPreview->setCommonErrorMsg($LANG['msg_error_sorry']);
						$MusicPreview->setPageBlockShow('msg_form_error');
					}
			}
	}
else
	{
		$MusicPreview->setAllPageBlocksHide();
		$MusicPreview->setCommonErrorMsg($LANG['msg_error_sorry']);
		$MusicPreview->setPageBlockShow('msg_form_error');
	}
//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($MusicPreview->isShowPageBlock('view_music_form'))
	{
		$MusicPreview->populateSinglePlayerConfiguration();
		$MusicPreview->configXmlcode_url .= 'pg=music_'.$MusicPreview->getFormField('music_id');
		$MusicPreview->playlistXmlcode_url .= 'pg=music_'.$MusicPreview->getFormField('music_id');
		$MusicPreview->preview_block['populateHidden'] = array('start','music_id');
	}
$MusicPreview->left_navigation_div = 'musicMain';
//include the header file
$MusicPreview->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'music');
$smartyObj->display('musicPreview.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
$MusicPreview->includeFooter();
?>
<script language="javascript" type="text/javascript">
setFullScreenBrowser();
</script>