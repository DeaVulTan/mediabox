<?php
/**
 * video player settings
 *
 *
 * @category	Rayzz
 * @package		admin
 **/
require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/admin/videoPlayerSettings.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/help.inc.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['site']['is_module_page'] = 'video';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//--------------class AddBookmark--------------->>>//
/**
 * @category	Rayzz
 * @package		Admin
 **/
class AddBookmark extends FormHandler
	{
		/**
		 * AddBookmark::resetFieldsArray()
		 *
		 * @return
		 */
		public function resetFieldsArray()
			{
				$this->setFormField('play_settings', 1);
				$this->setFormField('title', 1);
				$this->setFormField('share_link', 1);
				$this->setFormField('repeat_link', 1);
				$this->setFormField('skin', '');
				$this->setFormField('play_list_settings', 1);
				$this->setFormField('show_play_list_by', 'tags');
				$this->setFormField('title', 1);
			}

		/**
		 * AddBookmark::getSkinArray()
		 *
		 * @return
		 */
		public function getSkinArray()
			{
				if ($handle = opendir('../../'.$this->CFG['admin']['flv']['skin_path']))
					{
						$skin_array = array();
						while (false !== ($file = readdir($handle)))
							{
								if ($file != "." && $file != ".." && strstr($file, '.xml') && !strstr($file, 'config.xml'))
									{
										$file = str_replace('.xml', '', $file);
										$skin_array[$file] = $file;
									}
							}
						closedir($handle);
						//demo perpose only
						unset($skin_array);
						$skin_array['black_themes'] = 'black_themes';
						return $skin_array;
					}
			}

		/**
		 * AddBookmark::updateTable()
		 *
		 * @return
		 */
		public function updateTable()
			{
				$array = array($this->fields_arr['play_settings'], $this->fields_arr['title'],
							$this->fields_arr['share_link'], $this->fields_arr['repeat_link'],
							$this->fields_arr['skin'], $this->fields_arr['play_list_settings'],
							$this->fields_arr['show_play_list_by']);

				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['video_player_settings'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($rs->PO_RecordCount())
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_player_settings'].' SET'.
								' play_settings='.$this->dbObj->Param('play_settings').','.
								' title='.$this->dbObj->Param('title').','.
								' share_link='.$this->dbObj->Param('share_link').','.
								' repeat_link='.$this->dbObj->Param('repeat_link').','.
								' skin='.$this->dbObj->Param('skin').','.
								' play_list_settings='.$this->dbObj->Param('play_list_settings').','.
								' show_play_list_by='.$this->dbObj->Param('show_play_list_by').','.
								' date_added=NOW()';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $array);
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
					}
				else
					{
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['video_player_settings'].' SET'.
								' play_settings='.$this->dbObj->Param('play_settings').','.
								' title='.$this->dbObj->Param('title').','.
								' share_link='.$this->dbObj->Param('share_link').','.
								' repeat_link='.$this->dbObj->Param('repeat_link').','.
								' skin='.$this->dbObj->Param('skin').','.
								' play_list_settings='.$this->dbObj->Param('play_list_settings').','.
								' show_play_list_by='.$this->dbObj->Param('show_play_list_by').','.
								' date_added=NOW()';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $array);
						if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
					}
			}

		/**
		 * AddBookmark::populateSettings()
		 *
		 * @return
		 */
		public function populateSettings()
			{
				$sql = 'SELECT play_settings, title, share_link, repeat_link, skin, play_list_settings, show_play_list_by'.
						' FROM '.$this->CFG['db']['tbl']['video_player_settings'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						$this->fields_arr['play_settings'] = $row['play_settings'];
						$this->fields_arr['title'] = $row['title'];
						$this->fields_arr['share_link'] = $row['share_link'];
						$this->fields_arr['repeat_link'] = $row['repeat_link'];
						$this->fields_arr['skin'] = $row['skin'];
						$this->fields_arr['play_list_settings'] = $row['play_list_settings'];
						$this->fields_arr['show_play_list_by'] = $row['show_play_list_by'];
					}
			}
	}
//<<<<<-------------- Class AddBookmark begins ---------------//
//-------------------- Code begins -------------->>>>>//
$PlayerSettings = new AddBookmark();
$PlayerSettings->setDBObject($db);
$PlayerSettings->makeGlobalize($CFG,$LANG);
$PlayerSettings->setPageBlockNames(array('msg_form_error', 'msg_form_success', 'playerSettingsBlock'));

//default form fields and values...
$PlayerSettings->setAllPageBlocksHide();
$PlayerSettings->left_navigation_div = 'videoPlayerSetting';
$PlayerSettings->setPageBlockShow('playerSettingsBlock');
$skin_array = $PlayerSettings->getSkinArray();
$PlayerSettings->resetFieldsArray();
$PlayerSettings->sanitizeFormInputs($_REQUEST);
if($PlayerSettings->isFormPOSTed($_POST, 'update'))
	{
		if($CFG['admin']['is_demo_site'])
			{
				$PlayerSettings->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
				$PlayerSettings->setPageBlockShow('msg_form_success');
			}
		else
			{
				$PlayerSettings->updateTable();
				$PlayerSettings->setCommonSuccessMsg($LANG['msg_success_updated']);
				$PlayerSettings->setPageBlockShow('msg_form_success');
			}
	}
else
	{
		$PlayerSettings->populateSettings();
	}
$PlayerSettings->includeHeader();
//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
?>
<div id="selGroupCreate">
  	<h2><span><?php echo $LANG['page_title'];?></span></h2>
<?php
if ($PlayerSettings->isShowPageBlock('msg_form_error'))
	{
?>
		  <div id="selMsgError">
		    <p><?php echo $PlayerSettings->getCommonErrorMsg();?></p>
		  </div>
<?php
	}
if ($PlayerSettings->isShowPageBlock('msg_form_success'))
    {
?>
		  <div id="selMsgSuccess">
		   	<p><?php echo $PlayerSettings->getCommonSuccessMsg();?></p>
		  </div>
<?php
    }
if ($PlayerSettings->isShowPageBlock('playerSettingsBlock'))
    {
?>
	<form name="advertisement_upload_form" id="advertisement_upload_form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" autocomplete="off" enctype="multipart/form-data">
		<div id="clsPlayerSettings">
          <table summary="" class="clsNoBorder">
		  	<tr>
              <td class="clsSmallWidth <?php echo $PlayerSettings->getCSSFormLabelCellClass('play_settings');?>">
                <label for="play_settings1"><?php echo $LANG['play_settings'];?></label> </td>
              <td class="<?php echo $PlayerSettings->getCSSFormFieldCellClass('play_settings');?>"><?php echo $PlayerSettings->getFormFieldErrorTip('play_settings');?>
                <input type="radio" class="clsCheckRadio" name="play_settings" id="play_settings1" tabindex="<?php echo smartyTabIndex('play_settings1');?>" value="1" <?php echo $PlayerSettings->isCheckedRadio('play_settings', '1');?> />&nbsp;<label for=""><?php echo $LANG['auto_play'];?></label>
				<input type="radio" class="clsCheckRadio" name="play_settings" id="play_settings2" tabindex="<?php echo smartyTabIndex('play_settings2');?>" value="0" <?php echo $PlayerSettings->isCheckedRadio('play_settings', '0');?> />&nbsp;<label for=""><?php echo $LANG['click_to_play'];?></label>
			  </td>
            </tr>
			<tr>
              <td class="<?php echo $PlayerSettings->getCSSFormLabelCellClass('title');?>">
                <label for="title1"><?php echo $LANG['title'];?></label> </td>
              <td class="<?php echo $PlayerSettings->getCSSFormFieldCellClass('title');?>"><?php echo $PlayerSettings->getFormFieldErrorTip('title');?>
                <input type="radio" class="clsCheckRadio" name="title" id="title1" tabindex="<?php echo smartyTabIndex('title1');?>" value="1" <?php echo $PlayerSettings->isCheckedRadio('title', '1');?> />&nbsp;<label for=""><?php echo $LANG['on'];?></label>
				<input type="radio" class="clsCheckRadio" name="title" id="title2" tabindex="<?php echo smartyTabIndex('title2');?>" value="0" <?php echo $PlayerSettings->isCheckedRadio('title', '0');?> />&nbsp;<label for=""><?php echo $LANG['off'];?></label>
			  </td>
            </tr>
			<tr>
              <td class="<?php echo $PlayerSettings->getCSSFormLabelCellClass('share_link');?>">
                <label for="share_link1"><?php echo $LANG['share_link'];?></label> </td>
              <td class="<?php echo $PlayerSettings->getCSSFormFieldCellClass('share_link');?>"><?php echo $PlayerSettings->getFormFieldErrorTip('share_link');?>
                <input type="radio" class="clsCheckRadio" name="share_link" id="share_link1" tabindex="<?php echo smartyTabIndex('share_link1');?>" value="1" <?php echo $PlayerSettings->isCheckedRadio('share_link', '1');?> />&nbsp;<label for=""><?php echo $LANG['on'];?></label>
				<input type="radio" class="clsCheckRadio" name="share_link" id="share_link2" tabindex="<?php echo smartyTabIndex('share_link2');?>" value="0" <?php echo $PlayerSettings->isCheckedRadio('share_link', '0');?> />&nbsp;<label for=""><?php echo $LANG['off'];?></label>
			  </td>
            </tr>
			<tr>
              <td class="<?php echo $PlayerSettings->getCSSFormLabelCellClass('repeat_link');?>">
                <label for="repeat_link1"><?php echo $LANG['repeat_link'];?></label> </td>
              <td class="<?php echo $PlayerSettings->getCSSFormFieldCellClass('repeat_link');?>"><?php echo $PlayerSettings->getFormFieldErrorTip('repeat_link');?>
                <input type="radio" class="clsCheckRadio" name="repeat_link" id="repeat_link1" tabindex="<?php echo smartyTabIndex('repeat_link1');?>" value="1" <?php echo $PlayerSettings->isCheckedRadio('repeat_link', '1');?> />&nbsp;<label for=""><?php echo $LANG['on'];?></label>
				<input type="radio" class="clsCheckRadio" name="repeat_link" id="repeat_link2" tabindex="<?php echo smartyTabIndex('repeat_link2');?>" value="0" <?php echo $PlayerSettings->isCheckedRadio('repeat_link', '0');?> />&nbsp;<label for=""><?php echo $LANG['off'];?></label>
			  </td>
            </tr>
			<tr>
              <td class="<?php echo $PlayerSettings->getCSSFormLabelCellClass('skin');?>">
                <label for="skin"><?php echo $LANG['skin'];?></label> </td>
              <td class="<?php echo $PlayerSettings->getCSSFormFieldCellClass('skin');?>"><?php echo $PlayerSettings->getFormFieldErrorTip('skin');?>
                <select name="skin" id="skin" tabindex="<?php echo smartyTabIndex('skin');?>">
					<?php $PlayerSettings->generalPopulateArray($skin_array, $PlayerSettings->getFormfield('skin'));?>
				</select>
			  </td>
            </tr>
			<tr>
              <td class="<?php echo $PlayerSettings->getCSSFormLabelCellClass('play_list_settings');?>">
                <label for="play_list_settings1"><?php echo $LANG['play_list_settings'];?></label> </td>
              <td class="<?php echo $PlayerSettings->getCSSFormFieldCellClass('play_list_settings');?>"><?php echo $PlayerSettings->getFormFieldErrorTip('play_list_settings');?>
                <input type="radio" class="clsCheckRadio" name="play_list_settings" id="play_list_settings1" tabindex="<?php echo smartyTabIndex('play_list_settings1');?>" value="1" <?php echo $PlayerSettings->isCheckedRadio('play_list_settings', '1');?> />&nbsp;<label for=""><?php echo $LANG['on'];?></label>
				<input type="radio" class="clsCheckRadio" name="play_list_settings" id="play_list_settings2" tabindex="<?php echo smartyTabIndex('play_list_settings2');?>" value="0" <?php echo $PlayerSettings->isCheckedRadio('play_list_settings', '0');?> />&nbsp;<label for=""><?php echo $LANG['off'];?></label>
			  </td>
            </tr>
			<tr>
              <td class="<?php echo $PlayerSettings->getCSSFormLabelCellClass('show_play_list_by');?>">
                <label for="show_play_list_by1"><?php echo $LANG['show_play_list_by'];?></label> </td>
              <td class="<?php echo $PlayerSettings->getCSSFormFieldCellClass('show_play_list_by');?>"><?php echo $PlayerSettings->getFormFieldErrorTip('show_play_list_by');?>
                <input type="radio" class="clsCheckRadio" name="show_play_list_by" id="show_play_list_by1" tabindex="<?php echo smartyTabIndex('show_play_list_by1');?>" value="tags" <?php echo $PlayerSettings->isCheckedRadio('show_play_list_by', 'tags');?> />&nbsp;<label for=""><?php echo $LANG['tags'];?></label>
				<input type="radio" class="clsCheckRadio" name="show_play_list_by" id="show_play_list_by2" tabindex="<?php echo smartyTabIndex('show_play_list_by2');?>" value="channel" <?php echo $PlayerSettings->isCheckedRadio('show_play_list_by', 'channel');?> />&nbsp;<label for=""><?php echo $LANG['channel'];?></label>
				<input type="radio" class="clsCheckRadio" name="show_play_list_by" id="show_play_list_by3" tabindex="<?php echo smartyTabIndex('show_play_list_by3');?>" value="random" <?php echo $PlayerSettings->isCheckedRadio('show_play_list_by', 'random');?> />&nbsp;<label for=""><?php echo $LANG['random'];?></label>
			  </td>
            </tr>
			<tr>
				<td colspan="2" class="clsFormFieldCellDefault">
					<input type="submit" class="clsSubmitButton" name="update" id="update" tabindex="<?php echo smartyTabIndex('update');?>" value="<?php echo $LANG['update'];?>" />
				</td>
			</tr>
		 </table>
	  </div>
 	</form>
<?php
	}
?>
</div>
<?php

$PlayerSettings->includeFooter();
?>