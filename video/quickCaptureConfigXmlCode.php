<?php
/**
 * This file is to get xml code
 *
 * This file is having get xml code
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Index
 * @author 		selvaraj_35ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2006-05-02
 *
 **/
require_once('../common/configs/config.inc.php');

$CFG['site']['is_module_page']='video';

$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['auth']['is_authenticate'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
/**
 * XmlCode
 *
 * @package
 * @author selvaraj_35ag05
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
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
				$upload_path = getUrl('videouploadpopup', '?upload='.$this->fields_arr['file_name'],'?upload='.$this->fields_arr['file_name'],'members', 'video');
				$this->CFG['admin']['videos']['capture_second'] = $this->CFG['admin']['videos']['capture_second']==0?'':$this->CFG['admin']['videos']['capture_second'];
?>
<SETTINGS>
	<SERVER path="<?php echo $this->CFG['admin']['video']['red5_path'];?>" />
	<PHP uploadpath="<?php echo $upload_path;?>" deletepath="<?php echo $delete_path;?>" jscall="true"/>
	<STREAM name="<?php echo $this->fields_arr['file_name']; ?>" seconds="<?php echo $this->CFG['admin']['videos']['capture_second'];?>" />
	<!-- Best Settings are quality="100" width="160" height="120" framerate="15" bandwidth="0"/-->
	<!-- If you change Any of these may or maynot Cause Frame Loss of Quality Loss. width and height will be selected Native modes of ur webcam / -->
	<VIDEO quality="100" width="160" height="120" framerate="15" bandwidth="0"/>
	<SKIN url = "<?php echo $this->CFG['site']['url'].$this->CFG['admin']['recorder']['skin_path'].'skin.swf';?>"/>
	<PLAYERMODE value = "video"/>
	<TEXT_WAIT text="Connecting to Server... Please Wait. Recording Will begin soon"/>
	<TEXT_DISCNT text="Server disconnected. Please Reload the Application to connect"/>
	<TEXT_NOCAM text="No WebCam Installed in your Machine. Please Add a New WebCam to continue."/>
	<TEXT_RECFIN text="Your Audio / video has been Recorded Successfully"/>
	<TEXT_MIN text="Minimum recording Time should be more than 3 seconds" />
	<TEXT_BUFFER text="Connected to server Recording will begin soon"/>
	<STATUSTEST recording="recording" playing="playing" paused="paused" stopped="stopped"/>
<!--	<LABELS>
		<TEXT Name="RecordAnimation" Value="recording"/>
		<TEXT Name="NotRecording" Value="Replay"/>
		<TEXT Name="Cancel" Value="Cancel recording"/>
		<TEXT Name="Audio" Value="Audio"/>
		<TEXT Name="RecordFinish" Value="Please click on the Finish and Exit button to upload your recorded video"/>
		<TEXT Name="Wait" Value="Connecting to Server... Please Wait." />
		<TEXT Name="CamNotFound" Value="No WebCam Installed in your Machine. Please Add a New WebCam to continue." />
		<TEXT Name="Disconnected" Value="Server disconnected. Please Reload  the Application to connect" />
	</LABELS>-->
	<TOOLTIP>
        <TOOL Name="PlayButton" Value="Play"/>
		<TOOL Name="Stop" Value="Stop"/>
        <TOOL Name="PauseButton" Value="Pause"/>
        <TOOL Name="VolumeButton" Value="Volume"/>
        <TOOL Name="ReplyVideo" Value="Replay"/>
        <TOOL Name="Close" Value="Close"/>
        <TOOL Name="Save" Value="Save"/>
        <TOOL Name="SelectTools" Value="Select Tools"/>
        <TOOL Name="Record" Value="Record"/>
		<TOOL Name="RecordAgain" Value="Record Again"/>
	    <TOOL Name="Save" Value="Save"/>
	    <TOOL Name="Close" Value="Close"/>
    </TOOLTIP>
	<!--<TOOLTIP>
		<TOOL Name="PlayButton" Value="Play_gokul"/>
		<TOOL Name="RecordButton" Value="Record_gokul"/>
		<TOOL Name="StopButton" Value="Stop_gokul"/>
		<TOOL Name="ExitButton" Value="Please click on the Finish and Exit"/>
	</TOOLTIP>-->
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