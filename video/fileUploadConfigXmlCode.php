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
require_once('../common/configs/config_video.inc.php');
require_once('../common/configs/config_video_player.inc.php');

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

		public function getXmlCode()
			{
				$upload_url = $this->CFG['site']['video_url'].'fileUpload.php?file_name='.$this->fields_arr['file_name'];
				$skin_url = $this->CFG['site']['url'].$this->CFG['media']['folder'].'/flash/videoUploader/skins/rayzz_skin.swf';
				$type = '*.'.implode(';*.', $this->CFG['admin']['videos']['format_arr']).';';
?>
<FILE_UPLOADER
TypeDesc="All Video files"
Type="<?php echo $type;?>"
UploadUrl="<?php echo $upload_url;?>"
EndFunction = "onUploadComplete" args=""
MaximumFileSize = "<?php echo $this->CFG['admin']['videos']['max_size'];?>">
<Settings>
	<Set Name="SelectedSkin" Value="<?php echo $skin_url;?>"/>
	<Set Name="Headings" Value="(<?php echo $this->CFG['admin']['videos']['max_size'];?> MB)(<?php echo implode(', ', $this->CFG['admin']['videos']['format_arr']);?>)"/>
	<Set Name="BrowseButtonText" Value="Browse File"/>
	<Set Name="ShowBitTransferRate" Value="true" Label="Transfer speed :"/>
	<Set Name="ShowEstimatedTime" Value="true" Format="remaining" Label="Estimated Time Left :"/>
	<Set Name="ShowLoadedBytes" Value="true" LoadedFormat="MB" TotalFormat="MB" Label="Bytes Loaded :"/>
</Settings>
<Themes>
	<Item Name="HeaderBg" Color="0xCCCCCC" Transparen="100"/>
	<Item Name="BaseBg" Color="0xCCCCCC" Transparen="100"/>
	<Item Name="BrowseButtonBg" Color="0x333333" Transparen="100"/>
	<Item Name="LoaderBg" Color="0xCCCCCC" Transparen="100"/>
	<Item Name="HeaderText" Color="0xff0000" Font="Verdana" Size="10" />
	<Item Name="InfoText" Color="0x000000" Font="Verdana" Size="10" />
	<Item Name="EstimatedTimeText" Color="0xfff000" Font="Verdana" Size="10" />
	<Item Name="TransferRateText" Color="0xfff000"  Font="Verdana" Size="10" />
	<Item Name="LoadedBytesText" Color="0xfff000"  Font="Verdana" Size="10" />
</Themes>
</FILE_UPLOADER>
<?php
			}
	}
$XmlCode = new XmlCode();
setHeaderStart(false);
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