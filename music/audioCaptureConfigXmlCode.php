<?php
/**
 * This file is to get xml code
 *
 * This file is having get xml code
 *
 *
 * @category	rayzz
 * @package		Index
 * @author 		selvaraj_35ag05
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2006-05-02
 *
 **/
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/musicConfiguration.php';
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['auth']['is_authenticate'] = false;
$CFG['site']['is_module_page'] = 'music';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
/**
 * XmlCode
 *
 * @package
 * @author selvaraj_35ag05
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: $
 * @access public
 **/
class XmlCode extends FormHandler
	{
		/**
		 * XmlCode::setHeaderStart()
		 * clear cache and buffer start
		 *
		 * @return
		 **/
		public function getXmlCode()
			{
				$delete_path = $this->CFG['site']['url'].'deleteCapture.php?fname='.$this->fields_arr['file_name'];
				$upload_path = getUrl('musicuploadpopup', '?recorded_filename='.
										$this->fields_arr['file_name'],
										'?recorded_filename='.$this->fields_arr['file_name'], 'members', 'music');
$upload_path = $this->CFG['site']['url'].'music/musicUploadPopUp.php?recorded_filename='.$this->fields_arr['file_name'];
				$this->CFG['admin']['musics']['capture_second'] = $this->CFG['admin']['musics']['capture_second']==0
																	?'':$this->CFG['admin']['musics']['capture_second'];
?>
<SETTINGS>
	<SERVER path="<?php echo $this->CFG['admin']['video']['red5_path']; ?>"/>
	<PHP uploadpath="<?php echo $upload_path; ?>" deletepath="<?php echo $delete_path; ?>" jscall="true"/>
	<STREAM name="<?php echo $this->fields_arr['file_name']; ?>" seconds="<?php echo $this->CFG['admin']['musics']['capture_second']; ?>" />
 	<VIDEO quality="100" width="160" height="120" framerate="15" bandwidth="0"/>
	<SKIN url="<?php echo $this->CFG['site']['url'].$this->CFG['admin']['audio_recorder']['skin_path'].'skin.swf';?>"/>
	<PLAYERMODE value="audio"/>
	<TEXT_WAIT text="<?php echo $this->LANG['audiocaptureconfigxmlcode_please_wait_message'];?>"/>
	<TEXT_DISCNT text="<?php echo $this->LANG['audiocaptureconfigxmlcode_please_reload_message'];?>"/>
	<TEXT_NOCAM text="<?php $this->LANG['audiocaptureconfigxmlcode_no_webcam_message'];?>"/>
	<TEXT_RECFIN text="<?php echo $this->LANG['audiocaptureconfigxmlcode_recorded_successfully_message'];?>"/>
	<TEXT_MIN text="<?php echo $this->LANG['audiocaptureconfigxmlcode_recording_time_message'];?>" />
	<TEXT_BUFFER text="<?php echo $this->LANG['audiocaptureconfigxmlcode_recording_message'];?>"/>
	<STATUSTEST recording="recording" playing="playing" paused="paused" stopped="stopped"/>
	<TOOLTIP>
        <TOOL Name="PlayButton" Value="<?php echo $this->LANG['PlayButtonToolTip'];?>"/>
		<TOOL Name="Stop" Value="<?php echo $this->LANG['StopButtonToolTip'];?>"/>
        <TOOL Name="PauseButton" Value="<?php echo $this->LANG['PauseButtonToolTip'];?>"/>
        <TOOL Name="VolumeButton" Value="<?php echo $this->LANG['VolumeButtonToolTip'];?>"/>
        <TOOL Name="ReplyVideo" Value="<?php echo $this->LANG['ReplymusicToolTip'];?>"/>
        <TOOL Name="Close" Value="<?php echo $this->LANG['closebuttonTooltip'];?>"/>
        <TOOL Name="Save" Value="<?php echo $this->LANG['savebuttontooltip'];?>"/>
        <TOOL Name="SelectTools" Value="<?php echo $this->LANG['selecttoolsbuttontooltip'];?>"/>
        <TOOL Name="Record" Value="<?php echo $this->LANG['recordtoolsbuttontooltip'];?>"/>
		<TOOL Name="RecordAgain" Value="<?php echo $this->LANG['recordagaintoolsbuttontooltip']; ?>"/>
    </TOOLTIP>
</SETTINGS>
<?php
			}
	}
$XmlCode = new XmlCode();
setHeaderStart();
$XmlCode->setDBObject($db);
$XmlCode->makeGlobalize($CFG,$LANG);

$XmlCode->setFormField('file_name', '');

$XmlCode->setPageBlockShow('get_code_form');
$XmlCode->sanitizeFormInputs($_REQUEST);

//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($XmlCode->isShowPageBlock('get_code_form'))
    {
		$XmlCode->getXmlCode();
	}
//<<<<<-------------------- Page block templates ends -------------------//
setHeaderEnd();
//require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');
?>