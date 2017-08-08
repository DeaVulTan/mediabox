<?php
/**
* File handling the music file settings
*
*
* PHP version 5.0
*
* @category	framework
* @package		Admin
* @author 		edwin_90ag08
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
* @license		http://www.mediabox.uz Uzdc Infoway Licence
* @version		SVN: $Id: musicFileSettings.php 197 2008-06-26 14:33:47Z edwin_90ag08 $
* @since 		2009-06-26
*/
/**
* File having common configuration variables required for the entire project
*/
require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/admin/musicFileSettings.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['site']['is_module_page']='music';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
* To include application top file
*/
require($CFG['site']['project_path'].'common/application_top.inc.php');

class manageMusicFileSettings extends FormHandler
	{
		public function updateFileSettings()
			{
				$field_arr=array('Thumb'=>'music_thumb_name','Music'=>'music_file_name','Trimed'=>'trimed_music_name');
				foreach($field_arr as $file_type =>$file_name)
					{
						$sql = 'SELECT file_name'.' FROM '.$this->CFG['db']['tbl']['music_files_settings'].' WHERE file_type=\''.$file_type.'\' AND file_name = \''.$this->fields_arr[$file_name].'\'';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
						if (!$rs->PO_RecordCount())
								{
									$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_files_settings'].' SET '.'status =\'No\''.' WHERE file_type=\''.$file_type.'\' AND file_name != \''.$this->fields_arr[$file_name].'\'';
									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt);
									if (!$rs)
										trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
									$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_files_settings'].' SET '.'file_name = '.$this->dbObj->Param('file_name').', '.
										'file_type = '.$this->dbObj->Param('file_type').', '.'status = \'Yes\', '.'date_added = now()';
									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt,array($this->fields_arr[$file_name],$file_type));
									if (!$rs)
										trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
								}
						else
								{					
									$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_files_settings'].' SET '.'status =\'Yes\''.' WHERE file_type=\''.$file_type.'\' AND file_name = \''.$this->fields_arr[$file_name].'\'';
									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt);
									if (!$rs)
										trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
									$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_files_settings'].' SET '.'status =\'No\''.' WHERE file_type=\''.$file_type.'\' AND file_name != \''.$this->fields_arr[$file_name].'\'';
									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt);
									if (!$rs)
										trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
								}
					}
			}
		public function populateSettingValue()
			{
				$sql = 'SELECT music_file_id,file_name,file_type'.' FROM '.$this->CFG['db']['tbl']['music_files_settings'].' WHERE status=\'Yes\' ORDER BY file_type ASC';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$html_field_arr=array('music_thumb_name','music_file_name','trimed_music_name');
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
$musicfilesettings = new manageMusicFileSettings();
$musicfilesettings->setFormField('music_thumb_name','');
$musicfilesettings->setFormField('music_file_name','');
$musicfilesettings->setFormField('trimed_music_name','');
$musicfilesettings->setPageBlockNames(array('block_music_file_settings','block_msg_form_error','block_msg_form_success'));
$musicfilesettings->setAllPageBlocksHide();
$musicfilesettings->setPageBlockShow('block_music_file_settings');
$musicfilesettings->left_navigation_div = 'musicMain';
$result_value_arr=$musicfilesettings->populateSettingValue();
if(count($result_value_arr)>0 && !isset($_POST['update_file_settings']))
	{
		$musicfilesettings->setFormField('music_thumb_name',$result_value_arr['music_thumb_name']);
		$musicfilesettings->setFormField('music_file_name',$result_value_arr['music_file_name']);
		$musicfilesettings->setFormField('trimed_music_name',$result_value_arr['trimed_music_name']);
	}
$musicfilesettings->sanitizeFormInputs($_REQUEST);
if ($musicfilesettings->isFormPOSTed($_POST, 'update_file_settings'))
	{
		if($musicfilesettings->getFormField('music_thumb_name'))
			$musicfilesettings->chkIsAlphaNumeric('music_thumb_name', $LANG['musicfile_setting_err_tip_thumb_name']);
		if($musicfilesettings->getFormField('music_file_name'))
			$musicfilesettings->chkIsAlphaNumeric('music_file_name', $LANG['musicfile_setting_err_tip_music_name']);
		if($musicfilesettings->getFormField('trimed_music_name'))
			$musicfilesettings->chkIsAlphaNumeric('trimed_music_name', $LANG['musicfile_setting_err_tip_trimed_music_name']);
		if ($musicfilesettings->isValidFormInputs())
			{
				$musicfilesettings->updateFileSettings();
				$musicfilesettings->setCommonSuccessMsg($LANG['musicfile_setting_success_mesage']);
				$musicfilesettings->setPageBlockShow('block_msg_form_success');
				$result_value_arr=$musicfilesettings->populateSettingValue();
				$musicfilesettings->setFormField('music_thumb_name',$result_value_arr['music_thumb_name']);
				$musicfilesettings->setFormField('music_file_name',$result_value_arr['music_file_name']);
				$musicfilesettings->setFormField('trimed_music_name',$result_value_arr['trimed_music_name']);
			}
		else
			{
				$musicfilesettings->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$musicfilesettings->setPageBlockShow('block_msg_form_error');
			}
		}

//<<<<<<--------------------Page block templates Begin--------------------//
$musicfilesettings->includeHeader();
setTemplateFolder('admin/','music');
$smartyObj->display('musicFileSettings.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$musicfilesettings->includeFooter();
?>