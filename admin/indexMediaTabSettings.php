<?php
/**
 * Admin to manage index page content glider settings
 *
 *
 * PHP version 5.0
 *
 * @category	###Framework###
 * @package		###Admin###
 * @author 		naveenkumar_126at09
 * @copyright 	Copyright (c) 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version
 * @since 		2010-07-06
 */
/**
 * File having common configuration variables required for the entire project
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/indexMediaTabSettings.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/media_tab_type_list_array.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/help.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';

$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------- Class indexMediaTabSettings begins --------------->>>>>//
/**
 * This class hadling the site configuration variables
 *
 * @category	Rayzz
 * @package		Admin
 */
class indexMediaTabSettings extends FormHandler
	{
		/**
		 * indexMediaTabSettings::populateMediaTab()
		 * To populate the config data to edit
		 *
		 * @param  boolean $populate_fileds_data whether Fields value populate or not in edit form
		 * @return 	array
		 * @access 	public
		 */
		public function populateMediaTab($populate_fileds_data = true)
			{
				$sql = ' SELECT index_media_tab_id, media_type, media_tab_type FROM '.$this->CFG['db']['tbl']['index_media_tab_settings'].' WHERE'.
						' media_type = '.$this->dbObj->Param('media_type');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->getFormField('cname')));
					if (!$rs)
						trigger_db_error($this->dbObj);

				$populateMediaTab_arr = array();
				if($rs->PO_RecordCount())
					{
						$temp_section_arr = array();
						while($row = $rs->FetchRow())
							{
								$populateMediaTab_arr[$row['index_media_tab_id']] = $row;
							}
					}
				return $populateMediaTab_arr;
			}

		/**
		 * indexMediaTabSettings::resetFieldsArray()
		 * To inirtialize the form fields value
		 *
		 * @return
		 * @access 	public
		 */
		public function resetFieldsArray()
			{
				$this->setFormField('cname', '');
				$this->setFormField('act', '');
				$this->setFormField('index_media_tab_id', '');
				$this->setFormField('media_tab_type', '');
			}

		/**
		 * indexMediaTabSettings::chkIsValidConfigValue()
		 * To validate all the config values
		 *
		 * @return
		 * @access 	public
		 */
		public function chkIsValidConfigValue()
			{
				foreach($this->block_config_edit['populateMediaTab'] as $key=>$value)
					{
						$label_id = 'cvalue_'.$value['config_data_id'];
						$cfg_value = $this->getFormField($label_id);

						if($cfg_value == '')
							{
								continue;
							}
						switch($value['config_type'])
							{
								case 'Boolean':
									if(!($cfg_value == 0 or $cfg_value == 1))
										{
											$this->setFormFieldErrorTip($label_id, $this->LANG['common_err_tip_compulsory']);
										}
									break;

								case 'Int':
									$this->chkIsNumeric($label_id, $this->LANG['common_err_tip_numeric']);
									break;

								case 'Intwithsymbol':
									$this->chkIsNumericWithSymbol($label_id, $this->LANG['common_err_tip_numeric']);
									break;

								case 'Real':
									$this->chkIsReal($label_id, $this->LANG['common_err_tip_numeric']);
									break;

								case 'Email':
									$this->chkIsValidEmail($label_id, $this->LANG['common_err_tip_invalid_email_format']);
									break;

								case 'Website':
									$this->chkIsValidURL($label_id, $this->LANG['common_err_tip_invalid_url_format']);
									break;
							}
					}
			}

		/**
		 * indexMediaTabSettings::updateMediaTabData()
		 * To update the config data
		 *
		 * @return
		 * @access 	public
		 */
		public function updateMediaTabData()
			{
				foreach($this->block_config_edit['populateMediaTab'] as $key=>$value)
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['index_media_tab_settings'].' SET'.
								' media_tab_type = '.$this->dbObj->Param('media_tab_type').' WHERE'.
								' index_media_tab_id = '.$this->dbObj->Param('index_media_tab_id');
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->getFormField('media_tab_type'), $value['index_media_tab_id']));
							if (!$rs)
								trigger_db_error($this->dbObj);
					}
			}
	}

//<<<<<-------------- Class indexMediaTabSettings begins ---------------//
//-------------------- Code begins -------------->>>>>//
$indexMediaTabSettings = new indexMediaTabSettings();
$indexMediaTabSettings->setPageBlockNames(array('block_config_edit'));
//default form fields and values...
$indexMediaTabSettings->resetFieldsArray();
$indexMediaTabSettings->setFormField('cname', '');
$indexMediaTabSettings->setFormField('act', '');
$indexMediaTabSettings->setFormField('index_media_tab_id', '');
$indexMediaTabSettings->setFormField('media_tab_type', '');
$indexMediaTabSettings->setAllPageBlocksHide();
$indexMediaTabSettings->setPageBlockShow('block_config_edit'); //default page block. show it. All others hidden
$indexMediaTabSettings->sanitizeFormInputs($_REQUEST);
$indexMediaTabSettings->cname_array = array('video'=>1, 'music'=>2, 'photo'=>3);
$indexMediaTabSettings->media_tab_type_array['video'] = $LANG_LIST_ARR['media_tab_type_video'];
$indexMediaTabSettings->media_tab_type_array['music']= $LANG_LIST_ARR['media_tab_type_music'];
$indexMediaTabSettings->media_tab_type_array['photo'] = $LANG_LIST_ARR['media_tab_type_photo'];
$indexMediaTabSettings->media_tab_array['photo'] = $LANG['index_mediatabsetting_media_tab_type_title_photo'];
$indexMediaTabSettings->media_tab_array['music'] = $LANG['index_mediatabsetting_media_tab_type_title_music'];
$indexMediaTabSettings->media_tab_array['video'] = $LANG['index_mediatabsetting_media_tab_type_title_video'];

$indexMediaTabSettings->media_tab_reorder['photo'] = 'admin/photo/photoFeaturedReorder.php?type=photo';
$indexMediaTabSettings->media_tab_reorder['music'] = 'admin/music/musicFeaturedReorder.php?type=music';
$indexMediaTabSettings->media_tab_reorder['video'] = 'admin/video/videoFeaturedReorder.php?type=video';

if(isAjaxPage())
	{
		$indexMediaTabSettings->block_config_edit['populateMediaTab'] = $indexMediaTabSettings->populateMediaTab(true);
		if($indexMediaTabSettings->getFormField('act') == 'add_submit')
			{
				if($CFG['admin']['is_demo_site'])
					{
						$indexMediaTabSettings->setCommonErrorMsg($LANG['general_config_not_allow_demo_site']);
						$indexMediaTabSettings->setPageBlockShow('block_msg_form_error');
					}
				else
					{
						$indexMediaTabSettings->sanitizeFormInputs($_REQUEST);
						if($indexMediaTabSettings->isValidFormInputs())
							{
								$indexMediaTabSettings->updateMediaTabData();
								$indexMediaTabSettings->setPageBlockShow('block_msg_form_success');
								$indexMediaTabSettings->setCommonSuccessMsg($LANG['common_success_updated']);
							}
						else
							{
								$indexMediaTabSettings->setAllPageBlocksHide();
								$indexMediaTabSettings->setPageBlockShow('block_config_edit');
								$indexMediaTabSettings->setCommonErrorMsg($LANG['common_msg_error_sorry']);
								$indexMediaTabSettings->setPageBlockShow('block_msg_form_error');
							}
					}
			}
		if(!($indexMediaTabSettings->block_config_edit['populateMediaTab'] = $indexMediaTabSettings->populateMediaTab(true)))
			{
				$indexMediaTabSettings->setAllPageBlocksHide();
				$indexMediaTabSettings->setCommonErrorMsg($LANG['indexMediaTabSettings_no_data_to_edit']);
				$indexMediaTabSettings->setPageBlockShow('block_msg_form_error');
			}
	}
//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//
$indexMediaTabSettings->left_navigation_div = 'generalIndexSetting';
?>


<?php
if(!isAjaxPage())
	{
		$indexMediaTabSettings->includeHeader();
	}
else
	{
		$indexMediaTabSettings->LANG['index_mediatabsetting_title'] = $indexMediaTabSettings->buildDisplayText($indexMediaTabSettings->LANG['index_mediatabsetting_title'], array('VAR_category'=>$LANG['media_type_'.$indexMediaTabSettings->getFormField('cname')]));
		$indexMediaTabSettings->includeAjaxHeader();
	}
//include the content of the page
?>
	<script type="text/javascript">
					/**
					 * funFeatureReorderAction
					 * @access public
					 * @return void
					 **/
					function funFeatureReorderAction(actValue,media_tab_id){
						if (actValue == 'recommendedphoto' || actValue == 'recommendedmusic' || actValue == 'recommendedvideo'){
								document.getElementById('dvFeatureReorder_'+media_tab_id).style.display = "block";
								}
						else
						{
							//alert(actValue);
								document.getElementById('dvFeatureReorder_'+media_tab_id).style.display = "none";
								}
					}
				</script>
<?php
setTemplateFolder('admin/');
$smartyObj->display('indexMediaTabSettings.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
if(!isAjaxPage())
	{
		$indexMediaTabSettings->includeFooter();
	}
else
	{
		$indexMediaTabSettings->includeAjaxFooter();
	}

?>