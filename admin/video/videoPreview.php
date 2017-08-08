<?php
/**
 * This file is to manage the videos
 *
 * This file is having videoManage class to manage the videos
 *
 *
 * @category	Rayzz
 * @package		Admin
 *
 **/
require_once('../../common/configs/config.inc.php');
require_once('../../common/configs/config_video.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/admin/videoPreview.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/help.inc.php';
$CFG['site']['is_module_page']='video';
//$CFG['html']['header'] = 'admin/includes/languages/%s/html_header_popup.php';
//$CFG['html']['footer'] = 'admin/includes/languages/%s/html_footer_popup.php';

//$CFG['html']['header'] = 'admin/html_header_popup.php';
$CFG['html']['header'] = 'admin/html_header_no_header.php';
//$CFG['html']['footer'] = 'admin/html_footer_popup.php';
$CFG['html']['footer'] = 'admin/html_footer_no_footer.php';


$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class VideoPreview begins -------------------->>>>>//
/**
 *
 * @category	rayzz
 * @package		Admin
 **/
class VideoPreview extends FormHandler
	{
		/**
		 * VideoPreview::chkIsValidVideoId()
		 *
		 * @return
		 **/
		public function chkIsValidVideoId()
			{
				$sql ='SELECT COUNT(DISTINCT p.video_id) AS video_id FROM'.
						' '.$this->CFG['db']['tbl']['video'].' as p'.
						' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' as u'.
						' ON p.user_id=u.user_id'.
						' WHERE p.video_id='.$this->dbObj->Param($this->fields_arr['video_id']).' LIMIT 0,1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
				if (!$rs)
				        trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$row = $rs->FetchRow();
				if($row['video_id'])
					{
						//echo $row['video_id'];
						return true;
					}
				return false;
			}

		/**
		 * VideoPreview::populateVideoDetails()
		 *
		 * @return
		 **/
		public function populateVideoDetails()
			{
				$sql = 'SELECT p.video_ext, p.rating_total, p.rating_count, p.user_id, p.is_external_embed_video, p.video_external_embed_code,'.
						' p.video_title, DATE_FORMAT(date_added,\''.$this->CFG['format']['date'].'\') as date_added,'.
						' p.video_server_url, p.l_width, p.l_height, u.user_name, u.first_name, u.last_name'.
						' FROM '.$this->CFG['db']['tbl']['video'].' as p'.
						' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' as u ON p.user_id=u.user_id'.
						' WHERE video_id='.$this->dbObj->Param($this->fields_arr['video_id']).' LIMIT 0,1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
				if (!$rs)
				        trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if($row = $rs->FetchRow())
					{
						$name = $this->CFG['format']['name'];
						$name = str_replace('$first_name', $row['first_name'],$name);
						$name = str_replace('$last_name', $row['last_name'],$name);
						$name = str_replace('$user_name', $row['user_name'],$name);

						$this->fields_arr['user_id'] = $row['user_id'];
						$this->fields_arr['video_ext'] = $row['video_ext'];
						$this->fields_arr['video_server_url'] = $row['video_server_url'];
						$this->fields_arr['l_width'] = $row['l_width'];
						$this->fields_arr['l_height'] = $row['l_height'];
						$this->fields_arr['video_title'] = $row['video_title'];
						$this->fields_arr['date_added'] = $row['date_added'];
						$this->fields_arr['user_name'] = $name;
						$this->fields_arr['rating_total'] = $row['rating_total'];
						$this->fields_arr['rating_count'] = $row['rating_count'];
						$this->fields_arr['is_external_embed_video'] = $row['is_external_embed_video'];
						$this->fields_arr['video_external_embed_code'] = $row['video_external_embed_code'];
						return true;
					}
				return false;
			}

		/**
		 * VideoPreview::checkIsExternalEmebedCode()
		 *
		 * @return
		 */
		public function checkIsExternalEmebedCode()
			{
				if($this->fields_arr['is_external_embed_video']=='Yes')
					{
						return true;
					}
					return false;
			}

		/**
		 * ViewVideo::displayEmbededVideo()
		 *
		 * @return
		 */
		public function displayEmbededVideo()
			{

				echo html_entity_decode($this->fields_arr['video_external_embed_code']);

			}
	}
//<<<<<-------------- Class VideoPreview begins ---------------//
//-------------------- Code begins -------------->>>>>//
$VideoPreview = new VideoPreview();
$VideoPreview->tab = 995;
$VideoPreview->setDBObject($db);
$VideoPreview->makeGlobalize($CFG,$LANG);
$VideoPreview->setPageBlockNames(array('msg_form_error', 'view_video_form'));
$VideoPreview->setCSSFormFieldErrorTipClass('clsFormFieldErrTip');
$VideoPreview->setCSSFormLabelCellDefaultClass('clsFormLabelCellDefault');
$VideoPreview->setCSSFormFieldCellDefaultClass('clsFormFieldCellDefault');
$VideoPreview->setCSSFormLabelCellErrorClass('clsFormLabelCellError');
$VideoPreview->setCSSFormFieldCellErrorClass('clsFormFieldCellError');
//default form fields and values...
$VideoPreview->setFormField('video_id', '');
$VideoPreview->setFormField('user_id', '');
$VideoPreview->setFormField('video_ext', '');
$VideoPreview->setFormField('user_name', '');
$VideoPreview->IS_USE_AJAX = true;

if($VideoPreview->isFormPOSTed($_REQUEST, 'video_id'))
	{
		$VideoPreview->sanitizeFormInputs($_REQUEST);
		if(!$VideoPreview->chkIsValidVideoId())
			{
				$VideoPreview->setAllPageBlocksHide();
				$VideoPreview->setCommonErrorMsg($LANG['msg_error_sorry']);
				$VideoPreview->setPageBlockShow('msg_form_error');
			}
		else
			{
				if($VideoPreview->populateVideoDetails())
					{
						$VideoPreview->setPageBlockShow('view_video_form');
					}
				else
					{
						$VideoPreview->setCommonErrorMsg($LANG['msg_error_sorry']);
						$VideoPreview->setPageBlockShow('msg_form_error');
					}
			}
	}
else
	{
		$VideoPreview->setAllPageBlocksHide();
		$VideoPreview->setCommonErrorMsg($LANG['msg_error_sorry']);
		$VideoPreview->setPageBlockShow('msg_form_error');
	}
//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($VideoPreview->isShowPageBlock('view_video_form'))
    {
		$VideoPreview->view_video_form['flv_player_url'] = $CFG['site']['url'].$CFG['media']['folder'].'/flash/video/flvplayers/flvplayer.swf';
		$VideoPreview->view_video_form['configXmlcode_url'] = $CFG['site']['url'].'video/videoConfigXmlCode.php?pg=video_'.$VideoPreview->getFormField('video_id');
	}
$VideoPreview->left_navigation_div = 'videoMain';
//include the header file
$VideoPreview->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'video');
$smartyObj->display('videoPreview.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
$VideoPreview->includeFooter();
?>
<script language="javascript" type="text/javascript">
setFullScreenBrowser();
</script>