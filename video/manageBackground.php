<?php
/**
 * VideoList
 *
 * @package
 * @author vijaykarthick_84ag05
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: manageBackground.php $
 * @access member
 **/
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/manageBackground.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/help.inc.php';
$CFG['html']['header'] = 'general/html_header.php';;
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoHandler.lib.php';
$CFG['lang']['include_files'][] = 'common/configs/config_video.inc.php';
$CFG['db']['is_use_db'] = true;
$CFG['site']['is_module_page']='video';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;

require_once($CFG['site']['project_path'].'common/application_top.inc.php');


Class manageBackground extends VideoHandler
{
	public $background_ext;
	public $background_path;


	/**
	 * manageBackground::chkFileNameIsNotEmpty()
	 *
	 * @param mixed $field_name
	 * @param string $err_tip
	 * @return
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
	 * manageBackground::chkValidVideoFileType()
	 *
	 * @param $field_name
	 * @param string $err_tip
	 * @return
	 **/
	public function chkValidVideoFileType($field_name, $err_tip = '')
	{
		$this->chkValidFileType($field_name, $this->CFG['admin']['videos']['background_format_arr'], $err_tip = '');
	}

	/**
	 * manageBackground::chkValideVideoFileSize()
	 *
	 * @param $field_name
	 * @param string $err_tip
	 * @return
	 **/
	public function chkValideVideoFileSize($field_name, $err_tip='')
	{
		$max_size = $this->CFG['admin']['videos']['background_image_max_size'] * 1024;
		if ($_FILES[$field_name]['size'] > $max_size)
			{
				$this->fields_err_tip_arr[$field_name] = $err_tip;
				return false;
			}
		return true;
	}

	/**
	 * manageBackground::chkErrorInFile()
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

	public function chkOffsetSize($field_name, $err_tip)
		{
			if($this->fields_arr[$field_name] > $this->CFG['admin']['videos']['background_offset_size'])
				{
					$this->setFormFieldErrorTip($field_name, $err_tip);
					return false;
				}
			return true;
		}


	public function storeUploadFile()
	{
		$this->background_folder=$this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['background_image_folder'].'/';
		$this->chkAndCreateFolder($this->background_folder);
		$extern = substr($_FILES['background_image']['name'],strrpos($_FILES['background_image']['name'],'.')+1,strlen($_FILES['background_image']['name']));
		$image_storePath = $this->background_folder.getVideoImageName($this->CFG['user']['user_id']).'.'.$extern;
		if(isset($_FILES['background_image']) && $_FILES['background_image']['name'])
		{
			if(move_uploaded_file($_FILES['background_image']['tmp_name'],$image_storePath))
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
						' SET background_ext='.$this->dbObj->Param('background_ext').','.
						' background_offset='.$this->dbObj->Param('background_offset').
						' WHERE user_id='.$this->dbObj->Param('user_id');

				$value_arr = array($extern,
								$this->fields_arr['background_offset'],
								$this->CFG['user']['user_id']);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $value_arr);

				$this->setPageBlockShow('block_msg_form_success');
				$this->setCommonSuccessMsg($this->LANG['manageBackground_upload_success']);
			}
			else
			{
				$this->setPageBlockShow('block_msg_form_error');
				$this->setCommonErrorMsg($this->LANG['manageBackground_upload_failure']);
			}
		}
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
					' SET background_offset='.$this->dbObj->Param('background_offset').
					' WHERE user_id='.$this->dbObj->Param('user_id');

		$value_arr = array($this->fields_arr['background_offset'],
						$this->CFG['user']['user_id']);
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, $value_arr);
	}

	/**
	 * manageBackground::getBackgroundOffset()
	 *
	 * @param mixed $user_id
	 * @return
	 */
	public function getBackgroundOffset($user_id)
	{
		$sql ='SELECT background_offset FROM '.$this->CFG['db']['tbl']['users'].' WHERE user_id='.$this->dbObj->Param('user_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($user_id));
		if (!$rs)
		{
			trigger_db_error($this->dbObj);
		}
		$row = $rs->FetchRow();
		$this->setFormField('background_offset',$row['background_offset']);
	}

	public function removeFile()
	{
		$this->background_folder = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['background_image_folder'].'/';
		$this->background_path=$this->background_folder.getVideoImageName($this->CFG['user']['user_id']).'.'.$this->background_ext;
		@unlink($this->background_path);
	}
	public function updateStatus()
	{
		$sql ='UPDATE '.$this->CFG['db']['tbl']['users'].' SET background_ext=\'\' ,background_offset=\'0\' WHERE user_id='.$this->dbObj->Param('user_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
		if (!$rs)
			trigger_db_error($this->dbObj);

		$this->setPageBlockShow('block_msg_form_success');
		$this->setCommonSuccessMsg($this->LANG['manageBackground_deleted_success']);
	}

	/**
	 * manageBackground::__destruct()
	 *
	 */
	public function __destruct()
	{
		unset($this->background_ext);
		unset($this->background_path);
	}


}

$manageBackground = new manageBackground();
$manageBackground->setMediaPath('../');
$manageBackground->makeGlobalize($CFG,$LANG);

$manageBackground->setDBObject($db);
if(!chkAllowedModule(array('video')) OR !$manageBackground->chkIsUserHasRights($CFG['user']['user_id']))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);


$manageBackground->setPageBlockNames(array('block_image_display'));
$manageBackground->setFormField('background_image','');
$manageBackground->setFormField('background_offset','');
$manageBackground->setFormField('action','');

$manageBackground->setAllPageBlocksHide();

$manageBackground->imageFormat=implode(',',$CFG['admin']['videos']['background_format_arr']);
$manageBackground->sanitizeFormInputs($_REQUEST);
$manageBackground->LANG['help']['background_offset'] = str_replace('{size}', $CFG['admin']['videos']['background_offset_size'], $LANG['help']['background_offset']);
if($manageBackground->isPageGETed($_POST, 'uploadBackground'))
	{
		/*if(isset($_FILES['background_image']) && $_FILES['background_image']['name'])
			{
		*/
		$manageBackground->chkFileNameIsNotEmpty('background_image', $LANG['managebackground_err_tip_compulsory']) and
		$manageBackground->chkValidVideoFileType('background_image',$LANG['managebackground_err_tip_invalid_file_type']) and
		$manageBackground->chkValideVideoFileSize('background_image',$LANG['managebackground_err_tip_invalid_file_size']) and
		$manageBackground->chkErrorInFile('background_image',$LANG['managebackground_err_tip_invalid_file']);
			//}
		$manageBackground->chkIsNotEmpty('background_offset', $LANG['common_err_tip_compulsory']) AND
			$manageBackground->chkIsNumeric('background_offset', $LANG['managebackground_err_tip_invalid_offset']) AND
				$manageBackground->chkOffsetSize('background_offset', $LANG['managebackground_err_tip_invalid_offset_size']) ;
		if($manageBackground->isValidFormInputs())
			{
				$manageBackground->storeUploadFile();
			}
		else
			{
				$manageBackground->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$manageBackground->setPageBlockShow('block_msg_form_error');
			}

	}
if($manageBackground->getFormField('action')=='delete')
	{
		$manageBackground->removeFile();
		$manageBackground->updateStatus();
	}
$manageBackground->chkIsUserHasRights($CFG['user']['user_id']);
$manageBackground->getUploadedBackground($CFG['user']['user_id']);
$manageBackground->getBackgroundOffset($CFG['user']['user_id']);

//include the header file
$manageBackground->includeHeader();
//include the content of the page
setTemplateFolder('members/','video');
$smartyObj->display('manageBackground.tpl');
?>
<script type="text/javascript">
var block_arr= new Array('selMsgConfirm');
function showImageTip()
	{
		if($Jq('#imageTip').css('display') =='none')
			{
				$Jq('#imageTip').css('display', 'block');
			}
		else
			{
				$Jq('#imageTip').css('display', 'none');
			}
	}

</script>
<?php
/* Added code to validate mandataory fields in photo defaut settings page */
if ($CFG['feature']['jquery_validation'])
{
$allowed_image_formats = implode("|", $CFG['admin']['videos']['background_format_arr']);
?>
<script type="text/javascript">
$Jq("#manageBackgroundFrm").validate({
	rules: {
	    background_image: {
	    	required: true,
	    	isValidFileFormat: "<?php echo $allowed_image_formats; ?>"
		 },
		background_offset: {
		required: true,
		number: true
		}
	},
	messages: {
		background_image: {
			required: "<?php echo $LANG['common_err_tip_required'];?>",
			isValidFileFormat: "<?php echo $manageBackground->LANG['common_err_tip_invalid_image_format']; ?>"
		},
		background_offset: {
		required: "<?php echo $LANG['common_err_tip_required'];?>",
		number: LANG_JS_NUMBER
		}
	}
});
</script>
<?php
}
$manageBackground->includeFooter();
?>