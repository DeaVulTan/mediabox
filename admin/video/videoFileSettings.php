<?php
/**
 * File handling the video file settings
 *
 *
 * PHP version 5.0
 *
 * @category	framework
 * @package		Admin
 * @author 		edwin_90ag08
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: videoFileSettings.php 197 2008-04-16 14:33:47Z edwin_90ag08 $
 * @since 		2009-05-23
 */
/**
 * File having common configuration variables required for the entire project
 */
require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/admin/videoFileSettings.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['site']['is_module_page']='video';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');

class manageVideoFileSettings extends FormHandler
{
	 public function updateFileSettings()
		 {
		   	  $field_arr=array('Thumb'=>'video_thumb_name','Video'=>'video_file_name','Trimed'=>'trimed_video_name');
		   	  foreach($field_arr as $file_type =>$file_name)
				 {

				 	$sql = 'SELECT file_name'.
						 ' FROM '.$this->CFG['db']['tbl']['video_files_settings'].
						 ' WHERE file_type=\''.$file_type.'\' AND file_name = \''.$this->fields_arr[$file_name].'\'';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt);
					if (!$rs)
				        trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				    if (!$rs->PO_RecordCount())
						{
						    $sql = 'UPDATE '.$this->CFG['db']['tbl']['video_files_settings'].' SET '.
												'status =\'No\''.' WHERE file_type=\''.$file_type.'\' AND file_name != \''.$this->fields_arr[$file_name].'\'';

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt);
							if (!$rs)
						        trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						   	$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['video_files_settings'].' SET '.
										'file_name = '.$this->dbObj->Param('file_name').', '.
										'file_type = '.$this->dbObj->Param('file_type').', '.
										'status = \'Yes\', '.
										'date_added = now()';
							 $stmt = $this->dbObj->Prepare($sql);
							 $rs = $this->dbObj->Execute($stmt,array($this->fields_arr[$file_name],$file_type));
							 if (!$rs)
						        trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
						}
					else
					   	{

					   	   	   $sql = 'UPDATE '.$this->CFG['db']['tbl']['video_files_settings'].' SET '.
												'status =\'Yes\''.' WHERE file_type=\''.$file_type.'\' AND file_name = \''.$this->fields_arr[$file_name].'\'';
						    	$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
							        trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

							    $sql = 'UPDATE '.$this->CFG['db']['tbl']['video_files_settings'].' SET '.
												'status =\'No\''.' WHERE file_type=\''.$file_type.'\' AND file_name != \''.$this->fields_arr[$file_name].'\'';
						    	$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
							        trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);



						}
				}
		 }
	public function populateSettingValue()
		{
		  	  $sql = 'SELECT video_file_id,file_name,file_type'.
						 ' FROM '.$this->CFG['db']['tbl']['video_files_settings'].
						 ' WHERE status=\'Yes\' ORDER BY file_type ASC';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt);
					if (!$rs)
				        trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				    $html_field_arr=array('video_thumb_name','video_file_name','trimed_video_name');
				    $inc=0;
				    $result_value=array();
				    while($row = $rs->FetchRow())
					    {
					   	   	$result_value[$html_field_arr[$inc]]=$row['file_name'];
					   	   	$inc++;
						}
					return $result_value;

		}

}
$videofilesettings = new manageVideoFileSettings();
$videofilesettings->setFormField('video_thumb_name','');
$videofilesettings->setFormField('video_file_name','');
$videofilesettings->setFormField('trimed_video_name','');
$videofilesettings->setPageBlockNames(array('block_video_file_settings','block_msg_form_error','block_msg_form_success'));
$videofilesettings->setAllPageBlocksHide();
$videofilesettings->setPageBlockShow('block_video_file_settings');
$videofilesettings->left_navigation_div = 'videoSetting';
$result_value_arr=$videofilesettings->populateSettingValue();
if(count($result_value_arr)>0 && !isset($_POST['update_file_settings']))
{
$videofilesettings->setFormField('video_thumb_name',$result_value_arr['video_thumb_name']);
$videofilesettings->setFormField('video_file_name',$result_value_arr['video_file_name']);
$videofilesettings->setFormField('trimed_video_name',$result_value_arr['trimed_video_name']);
}
$videofilesettings->sanitizeFormInputs($_REQUEST);
if ($videofilesettings->isFormPOSTed($_POST, 'update_file_settings'))
	{

		if ($CFG['admin']['is_demo_site'])
			{
				$videofilesettings->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
				$videofilesettings->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				  if($videofilesettings->getFormField('video_thumb_name'))
				  $videofilesettings->chkIsAlphaNumeric('video_thumb_name', $LANG['videofile_setting_err_tip_thumb_name']);

				  if($videofilesettings->getFormField('video_file_name'))
				  $videofilesettings->chkIsAlphaNumeric('video_file_name', $LANG['videofile_setting_err_tip_video_name']);

				  if($videofilesettings->getFormField('trimed_video_name'))
				  $videofilesettings->chkIsAlphaNumeric('trimed_video_name', $LANG['videofile_setting_err_tip_trimed_video_name']);

				  if ($videofilesettings->isValidFormInputs())
						{
						  $videofilesettings->updateFileSettings();
						  $videofilesettings->setCommonSuccessMsg($LANG['videofile_setting_success_mesage']);
						  $videofilesettings->setPageBlockShow('block_msg_form_success');
						  $result_value_arr=$videofilesettings->populateSettingValue();
						  $videofilesettings->setFormField('video_thumb_name',$result_value_arr['video_thumb_name']);
					      $videofilesettings->setFormField('video_file_name',$result_value_arr['video_file_name']);
						  $videofilesettings->setFormField('trimed_video_name',$result_value_arr['trimed_video_name']);
						}
					else
					{
					   $videofilesettings->setCommonErrorMsg($LANG['common_msg_error_sorry']);
					   $videofilesettings->setPageBlockShow('block_msg_form_error');
					}
			}
	}

//<<<<<<--------------------Page block templates Begin--------------------//
$videofilesettings->includeHeader();
setTemplateFolder('admin/','video');
$smartyObj->display('videoFileSettings.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$videofilesettings->includeFooter();
?>