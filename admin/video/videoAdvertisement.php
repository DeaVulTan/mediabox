<?php
/**
 * This file is to upload the photos
 *
 * This file is having advertisement class to upload the photos
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 * @author 		selvaraj_35ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: advertisement.php 2986 2006-12-29 05:25:10Z selvaraj_35ag05 $
 * @since 		2006-05-02
 *
 **/
require_once('../../common/configs/config.inc.php');
require_once('../../common/configs/config_video.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/admin/videoAdvertisement.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['site']['is_module_page']='video';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
/**
 * advertisement
 *
 * @package
 * @author selvaraj_35ag05
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: advertisement.php 2986 2006-12-29 05:25:10Z selvaraj_35ag05 $
 * @access public
 **/
class advertisement extends ListRecordsHandler
	{
		/**
		 * ManageFolder::buildSortQuery()
		 *
		 * @return
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = $this->fields_arr['orderby_field'].' '.$this->fields_arr['orderby'];
			}

		/**
		 * advertisement::chkFileNameIsNotEmpty()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return
		 **/
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
		 * advertisement::chkFileNameIsNotEmpty()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return
		 **/
		public function chkFileNameIsNotEmptyEdit($field_name, $err_tip = '')
			{
				if(!$_FILES[$field_name]['name'])
					{
						//$this->setFormFieldErrorTip($field_name,$err_tip);
						return false;
					}
				return true;
			}

		/**
		 * advertisement::chkValidFileType()
		 *
		 * @param $field_name
		 * @param string $err_tip
		 * @return
		 **/
		public function chkValidFileType($field_name, $err_tip = '')
			{
				$extern = strtolower(substr($_FILES[$field_name]['name'], strrpos($_FILES[$field_name]['name'], '.')+1));
				if (!in_array(strtolower($extern), $this->CFG['admin']['videos']['advertisement_format_arr']))
					{
						$this->fields_err_tip_arr[$field_name] = $err_tip;
						return false;
					}
				return true;
			}

		/**
		 * advertisement::chkValideFileSize()
		 *
		 * @param $field_name
		 * @param string $err_tip
		 * @return
		 **/
		public function chkValideFileSize($field_name, $err_tip='')
			{
				$max_size = $this->CFG['admin']['videos']['advertisement_max_size'] * 1024;
				if ($_FILES[$field_name]['size'] > $max_size)
					{
						$this->fields_err_tip_arr[$field_name] = $err_tip;
						return false;
					}
				return true;
			}

		/**
		 * advertisement::chkErrorInFile()
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

		/**
		 * advertisement::resetFieldsArray()
		 *
		 * @return
		 */
		public function resetFieldsArray()
			{
				$this->setFormField('aid', '');
				$this->setFormField('advertisement_name', '');
				$this->setFormField('video_advertisement_file', '');
				$this->setFormField('advertisement_description', '');
				$this->setFormField('advertisement_url', '');
				$this->setFormField('advertisement_duration', '0');
				$this->setFormField('advertisement_expiry_date', '');
				$this->setFormField('advertisement_impressions', '0');
				$this->setFormField('advertisement_channel', array());
				$this->setFormField('advertisement_image', '');
				$this->setFormField('advertisement_ext', '');
				$this->setFormField('advertisement_show_at', 'Begining');
				$this->setFormField('add_type', 'General');
				$this->setFormField('advertisement_status', '');
				$this->setFormField('date_added', '');
				$this->setFormField('month', '');
				$this->setFormField('day', '');
				$this->setFormField('year', '');
				$this->setFormField('act', '');
				$this->setFormField('views_revenue', '');
				$this->setFormField('clicks_revenue', '');
			}

		/**
		 * PhotoEdit::populateadvertisementDetails()
		 *
		 * @return
		 **/
		public function populateadvertisementDetails()
			{
				$sql = 'SELECT advertisement_id, advertisement_name, advertisement_description, advertisement_url,'.
						' advertisement_duration, advertisement_expiry_date,'.
						' advertisement_impressions, advertisement_channel, advertisement_image,'.
						' advertisement_ext, advertisement_show_at, add_type, advertisement_status,'.
						' views_revenue, clicks_revenue'.
						' FROM '.$this->CFG['db']['tbl']['video_advertisement'].' WHERE'.
						' advertisement_id='.$this->dbObj->Param('advertisement_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['aid']));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						$this->fields_arr['advertisement_name'] = $row['advertisement_name'];
						$this->fields_arr['advertisement_description'] = $row['advertisement_description'];
						$this->fields_arr['advertisement_url'] = $row['advertisement_url'];
						$this->fields_arr['advertisement_duration'] = $row['advertisement_duration'];
						$this->fields_arr['advertisement_expiry_date'] = $row['advertisement_expiry_date'];
						$this->fields_arr['advertisement_impressions'] = $row['advertisement_impressions'];
						$this->fields_arr['advertisement_channel'] = $row['advertisement_channel'];
						$this->fields_arr['advertisement_image'] = $row['advertisement_image'];
						$this->fields_arr['advertisement_ext'] = $row['advertisement_ext'];
						$this->fields_arr['advertisement_show_at'] = $row['advertisement_show_at'];
						$this->fields_arr['add_type'] = $row['add_type'];
						$this->fields_arr['advertisement_status'] = $row['advertisement_status'];
						$this->fields_arr['views_revenue'] = $row['views_revenue'];
						$this->fields_arr['clicks_revenue'] = $row['clicks_revenue'];
						$advertisement_expiry_date = explode(' ', $row['advertisement_expiry_date']);
						$advertisement_expiry_date = explode('-', $advertisement_expiry_date[0]);
						$this->fields_arr['year'] = $advertisement_expiry_date[0];
						$this->fields_arr['month'] = $advertisement_expiry_date[1];
						$this->fields_arr['day'] = $advertisement_expiry_date[2];
						$this->fields_arr['advertisement_channel'] = explode(',',$row['advertisement_channel']);
						return true;
					}
				return false;
			}

		/**
		 * advertisement::getadvertisementImage()
		 *
		 * @return
		 */
		public function getadvertisementImage()
			{
				switch($this->fields_arr['advertisement_ext'])
					{
						case 'jpg':
							$image_path = $this->CFG['site']['url'].$this->CFG['admin']['videos']['advertisement_folder'].$this->fields_arr['advertisement_image'].'.'.$this->fields_arr['advertisement_ext'];
							break;

						case 'swf':
							$image_path = $this->CFG['site']['url'].'images/swflogo.jpg';
							break;

						case 'flv':
							$image_path = $this->CFG['site']['url'].'images/flvlogo.jpg';
							break;

						default:
							$image_path = $this->CFG['site']['url'].'images/nologo.jpg';
							break;
					}

?>
	<img src="<?php echo $image_path;?>" alt="<?php echo $this->LANG['advertisement'];?>" width="66px" height="66px" />
<?php
			}

		/**
		 * ManageDeleted::removeFiles()
		 *
		 * @param $file
		 * @return
		 **/
		public function removeFiles($file)
			{
				if(is_file($file))
					{
						unlink($file);
						return true;
					}
				return false;
			}

		/**
		 * advertisement::deleteFiles()
		 *
		 * @param mixed $image_name
		 * @return
		 */
		public function deleteFiles($image_name)
			{
				$this->removeFiles($image_name.'.flv');
				$this->removeFiles($image_name.'.jpg');
				$this->removeFiles($image_name.'.swf');
			}

		/**
		 * advertisement::updateAdvertisementTable()
		 *
		 * @return
		 */
		public function updateAdvertisementTable()
			{
				$add_arr = array();
				$add_field = '';
				$expiry_date = ($this->getFormField('year')) ? $this->getFormField('year').'-' : '0000-';
				$expiry_date .= ($this->getFormField('month')) ? $this->getFormField('month').'-' : '00-';
				$expiry_date .= ($this->getFormField('day')) ? $this->getFormField('day') : '00';
				$channel = implode(',', $this->fields_arr['advertisement_channel']);
				if($this->advertisement)
					{
						$extern = strtolower(substr($_FILES['video_advertisement_file']['name'], strrpos($_FILES['video_advertisement_file']['name'], '.')+1));
						$image_name = getVideoImageName($this->fields_arr['aid']);
						$dir = '../../'.$this->CFG['admin']['videos']['advertisement_folder'];
						$this->chkAndCreateFolder($dir);
						$this->deleteFiles($dir.$image_name);
						move_uploaded_file($_FILES['video_advertisement_file']['tmp_name'],$dir.$image_name.'.'.strtolower($extern));
						$add_arr = array($image_name, $extern);
						$add_field = ', advertisement_image='.$this->dbObj->Param('advertisement_image').','.
										' advertisement_ext='.$this->dbObj->Param('advertisement_ext');
					}
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_advertisement'].' SET'.
						' advertisement_name='.$this->dbObj->Param('advertisement_name').','.
						' advertisement_description='.$this->dbObj->Param('advertisement_description').','.
						' advertisement_url='.$this->dbObj->Param('advertisement_url').','.
						' advertisement_duration='.$this->dbObj->Param('advertisement_duration').','.
						' advertisement_expiry_date='.$this->dbObj->Param('advertisement_expiry_date').','.
						' advertisement_impressions='.$this->dbObj->Param('advertisement_impressions').','.
						' advertisement_channel='.$this->dbObj->Param('advertisement_channel').','.
						' advertisement_show_at='.$this->dbObj->Param('advertisement_show_at').','.
						' add_type='.$this->dbObj->Param('add_type').','.
						' advertisement_status='.$this->dbObj->Param('advertisement_status').','.
						' views_revenue='.$this->dbObj->Param('views_revenue').','.
						' clicks_revenue='.$this->dbObj->Param('clicks_revenue').$add_field.
						' WHERE advertisement_id=\''.addslashes($this->fields_arr['aid']).'\'';
				$array = array($this->fields_arr['advertisement_name'], $this->fields_arr['advertisement_description'],
								 $this->fields_arr['advertisement_url'], $this->fields_arr['advertisement_duration'],
								 $expiry_date, $this->fields_arr['advertisement_impressions'],
								 $channel, $this->fields_arr['advertisement_show_at'],
								 $this->fields_arr['add_type'], $this->fields_arr['advertisement_status'],
								 $this->fields_arr['views_revenue'],
								 $this->fields_arr['clicks_revenue']
								 );

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array_merge($array, $add_arr));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}

		/**
		 * advertisement::insertAdvertisementTable()
		 *
		 * @return
		 */
		public function insertAdvertisementTable()
			{
				$expiry_date = $this->getFormField('year').'-'.$this->getFormField('month').'-'.$this->getFormField('day');
				$channel = implode(',', $this->fields_arr['advertisement_channel']);
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['video_advertisement'].' SET'.
						' advertisement_name='.$this->dbObj->Param('advertisement_name').','.
						' user_id='.$this->dbObj->Param('user_id').','.
						' advertisement_description='.$this->dbObj->Param('advertisement_description').','.
						' advertisement_url='.$this->dbObj->Param('advertisement_url').','.
						' advertisement_duration='.$this->dbObj->Param('advertisement_duration').','.
						' advertisement_expiry_date='.$this->dbObj->Param('advertisement_expiry_date').','.
						' advertisement_impressions='.$this->dbObj->Param('advertisement_impressions').','.
						' advertisement_channel='.$this->dbObj->Param('advertisement_channel').','.
						' advertisement_show_at='.$this->dbObj->Param('advertisement_show_at').','.
						' add_type='.$this->dbObj->Param('add_type').','.
						' advertisement_status='.$this->dbObj->Param('advertisement_status').','.
						' views_revenue='.$this->dbObj->Param('views_revenue').','.
						' clicks_revenue='.$this->dbObj->Param('clicks_revenue').','.
						' date_added=NOW()';
				$array = array($this->fields_arr['advertisement_name'], $this->CFG['user']['user_id'], $this->fields_arr['advertisement_description'],
								 $this->fields_arr['advertisement_url'], $this->fields_arr['advertisement_duration'],
								 $expiry_date, $this->fields_arr['advertisement_impressions'],
								 $channel, $this->fields_arr['advertisement_show_at'],
								 $this->fields_arr['add_type'], $this->fields_arr['advertisement_status'],
								 $this->fields_arr['views_revenue'],
								 $this->fields_arr['clicks_revenue']

								 );

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $array);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($advertisement_id = $this->dbObj->Insert_ID())
					{
						$extern = strtolower(substr($_FILES['video_advertisement_file']['name'], strrpos($_FILES['video_advertisement_file']['name'], '.')+1));
						$image_name = getVideoImageName($advertisement_id);
						$dir = '../../'.$this->CFG['admin']['videos']['advertisement_folder'];
						$this->chkAndCreateFolder($dir);
						$this->deleteFiles($dir.$image_name);
						move_uploaded_file($_FILES['video_advertisement_file']['tmp_name'],$dir.$image_name.'.'.strtolower($extern));

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_advertisement'].' SET'.
								' advertisement_image='.$this->dbObj->Param('advertisement_image').','.
								' advertisement_ext='.$this->dbObj->Param('advertisement_ext').' WHERE'.
								' advertisement_id='.$this->dbObj->Param('advertisement_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($image_name, $extern, $advertisement_id));
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
					}
			}

		/**
		 * VideoUpload::populateVideoCatagory()
		 *
		 * @param string $err_tip
		 * @return
		 **/
		public function populateVideoCatagory($err_tip='')
			{
				$sql = 'SELECT video_category_id, video_category_name FROM '.$this->CFG['db']['tbl']['video_category'].
						' WHERE  video_category_status=\'Yes\' AND parent_category_id =\'0\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if(!$rs->PO_RecordCount())
					return;

				$names = array('video_category_name');
				$value = 'video_category_id';
				$highlight_value = $this->fields_arr['advertisement_channel'];
				$coun = 0;
?>
				<table>
				<ul>
					<!--<li class="clsGroups"><input type="checkbox" class="clsCheckRadio" class="clsCheckBox" name="advertisement_channel[]" id="advertisement_channel_groups" tabindex="{smartyTabIndex}" value="groups"<?php echo $this->isCheckedCheckBoxArray('advertisement_channel', 'groups');?> /><label for="advertisement_channel_groups"><?php echo $this->LANG['groups'];?></label></li>-->
<?php
				$inc = 1;
				while($row = $rs->FetchRow())
					{
						$out = '';
						if($coun==0)
							{
?>
						<li>
						<tr>
						<?php
							}
						?>
						<td>
							<input type="checkbox" class="clsCheckRadio" class="clsCheckBox" name="advertisement_channel[]" id="advertisement_channel<?php echo $row[$value];?>" tabindex="{smartyTabIndex}" value="<?php echo $row[$value];?>"<?php echo $this->isCheckedCheckBoxArray('advertisement_channel', $row['video_category_id']);?> />

<?php
						foreach($names as $name)
							$out .= $row[$name].' ';
?>
						<label for="advertisement_channel<?php echo $row[$value];?>"><?php echo $out;?></label></td>
						<?php
						$coun++;
						if($coun==4)
							{
								$coun=0;
						?>
						</li>
						</tr>
						<?php
							}


						?>

<?php
						$inc++;
					}
?>
				</ul>
				</table>
<?php
			}

		/**
		 * advertisement::checkValidDate()
		 *
		 * @param mixed $err_tip
		 * @return
		 */
		public function checkValidDate($err_tip)
			{
				if(!$this->fields_arr['month'] and !$this->fields_arr['day'] and !$this->fields_arr['year'])
					return true;
				if($this->fields_arr['month'] and $this->fields_arr['day'] and $this->fields_arr['year'])
					{
						if(checkdate($this->fields_arr['month'],$this->fields_arr['day'],$this->fields_arr['year']))
							return true;
					}
				$this->fields_err_tip_arr['month'] = $err_tip;
				return false;
			}

		/**
		 * advertisement::chkIsEditMode()
		 *
		 * @return
		 */
		public function chkIsEditMode()
			{
				if($this->fields_arr['aid'] and $this->fields_arr['act']=='edit')
					return true;
				return false;
			}

		/**
		 * advertisement::getUserName()
		 *
		 * @param mixed $user_id
		 * @return
		 */
		public function getUserName($user_id)
			{
				$sql = 'SELECT user_name FROM '.
						$this->CFG['db']['tbl']['users'].
						' WHERE user_id = '.$this->dbObj->Param('user_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));
				if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if ($row = $rs->FetchRow())
					{
						return $row['user_name'];
					}
				else
					return 'Admin';
			}

		/**
		 * advertisement::populateAdvertisementList()
		 *
		 * @return
		 */
		public function populateAdvertisementList()
			{
				$populateAdvertisementList_arr = array();
				$inc = 0;
				while($row = $this->fetchResultRecord())
					{
						$populateAdvertisementList_arr[$inc]['record'] = $row;
						if($row['advertisement_status'] == 'Activate')
							$populateAdvertisementList_arr[$inc]['lang_status'] = $this->LANG['videoadvertisement_active'];
						else
							$populateAdvertisementList_arr[$inc]['lang_status'] = $this->LANG['videoadvertisement_inactive'];

						$inc++;
					}
				return $populateAdvertisementList_arr;
			}

		/**
		 * advertisement::deleteAdvertisement()
		 *
		 * @return
		 */
		public function deleteAdvertisement()
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['video_advertisement'].' WHERE'.
						' advertisement_id IN('.$this->fields_arr['aid'].')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$dir = '../'.$this->CFG['admin']['videos']['advertisement_folder'];
				$array = explode(',', $this->fields_arr['aid']);
				foreach($array as $key=>$value)
					{
						$image_name = getVideoImageName($value);
						$this->deleteFiles($dir.$image_name);
					}
			}

		/**
		 * advertisement::changeStatusAdvertisement()
		 *
		 * @param mixed $status
		 * @return
		 */
		public function changeStatusAdvertisement($status)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_advertisement'].' SET'.
						' advertisement_status='.$this->dbObj->Param('advertisement_status').' WHERE'.
						' advertisement_id IN('.$this->fields_arr['aid'].')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($status));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}

		/**
		 * advertisement::defaultValidation()
		 *
		 * @return
		 */
		public function defaultValidation()
			{
				$this->checkValidDate($this->LANG['err_tip_invalid_date']);
				$this->getFormField('advertisement_impressions') and
					$this->chkIsNumeric('advertisement_impressions',$this->LANG['err_tip_numeric']);
				$this->getFormField('advertisement_duration') and
					$this->chkIsNumeric('advertisement_duration',$this->LANG['err_tip_numeric']);
				if(chkAllowedModule(array('affiliate')))
					{
						$this->chkIsNotEmpty('views_revenue', $this->LANG['err_tip_compulsory']) and
							$this->chkIsNotEmpty('views_revenue', $this->LANG['err_tip_number']);

						$this->chkIsNotEmpty('clicks_revenue', $this->LANG['err_tip_compulsory']) and
							$this->chkIsNotEmpty('clicks_revenue', $this->LANG['err_tip_number']);
					}
			}
	}
//<<<<<-------------- Class advertisement begins ---------------//
//-------------------- Code begins -------------->>>>>//
$advertisement = new advertisement();
$advertisement_status_array = array('Activate'=>$LANG['activate'], 'Inactive'=>$LANG['inactivate']);
$advertisement->setPageBlockNames(array('advertisement_list', 'advertisement_upload_form'));
//default form fields and values...
$advertisement->resetFieldsArray();
/*********** Page Navigation Start *********/
$advertisement->setFormField('start', '0');
$advertisement->setFormField('orderby', 'DESC');
$advertisement->setFormField('msg', '');
$advertisement->setFormField('orderby_field', 'advertisement_id');
$advertisement->setFormField('numpg',$CFG['data_tbl']['numpg']);
$advertisement->setMinRecordSelectLimit(2);
$advertisement->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$advertisement->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$advertisement->setTableNames(array($CFG['db']['tbl']['video_advertisement']));
$advertisement->setReturnColumns(array('advertisement_id', 'user_id', 'advertisement_name', 'advertisement_description', 'advertisement_url', 'advertisement_duration', 'DATE_FORMAT(advertisement_expiry_date,\''.$CFG['format']['date'].'\') AS advertisement_expiry_date', 'advertisement_impressions', 'advertisement_channel', 'advertisement_image', 'advertisement_ext', 'advertisement_show_at', 'add_type', 'advertisement_status', 'DATE_FORMAT(date_added,\''.$CFG['format']['date'].'\') AS date_added', 'advertisement_current_impressions', 'views_revenue', 'clicks_revenue', 'site_earnings', 'members_earnings'));
/************ page Navigation stop *************/
$advertisement->setAllPageBlocksHide();
$advertisement->sanitizeFormInputs($_REQUEST);
$advertisement->setPageBlockShow('advertisement_list');
if($advertisement->getFormField('msg') == 'add')
	{
			$advertisement->setCommonSuccessMsg($LANG['msg_success_added']);
			$advertisement->setPageBlockShow('block_msg_form_success');
	}
if($advertisement->isFormPOSTed($_POST, 'add'))
	{
		if ($CFG['admin']['is_demo_site'])
			{
				$advertisement->setCommonSuccessMsg($advertisement->LANG['general_config_not_allow_demo_site']);
				$advertisement->setPageBlockShow('block_msg_form_success');
			}
		else
			{

				$advertisement->chkFileNameIsNotEmpty('video_advertisement_file', $LANG['err_tip_compulsory']) and
					$advertisement->chkValidFileType('video_advertisement_file',$LANG['err_tip_invalid_file_type']) and
					$advertisement->chkValideFileSize('video_advertisement_file',$LANG['err_tip_invalid_file_size']) and
					$advertisement->chkErrorInFile('video_advertisement_file',$LANG['err_tip_invalid_file']);
					if($advertisement->getFormField('advertisement_url'))
						{
							$advertisement->chkIsValidURL('advertisement_url', $LANG['video_advertisement_url_error_msg']);
						}
				$advertisement->defaultValidation();

				if($advertisement->isValidFormInputs())
					{
						$advertisement->insertAdvertisementTable();
						Redirect2URL($CFG['site']['url']."admin/video/videoAdvertisement.php?msg=add");
					}
				else
					{
						$advertisement->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$advertisement->setAllPageBlocksHide();
						$advertisement->setPageBlockShow('block_msg_form_error');
						$advertisement->setPageBlockShow('advertisement_upload_form');
					}
			}
	}
else if($advertisement->isFormPOSTed($_POST, 'update'))
	{
		if ($CFG['admin']['is_demo_site'])
			{
				$advertisement->setCommonSuccessMsg($advertisement->LANG['general_config_not_allow_demo_site']);
				$advertisement->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				$advertisement->advertisement = $advertisement->chkFileNameIsNotEmptyEdit('video_advertisement_file', $LANG['err_tip_compulsory']) and
					$advertisement->chkValidFileType('video_advertisement_file',$LANG['err_tip_invalid_file_type']) and
					$advertisement->chkValideFileSize('video_advertisement_file',$LANG['err_tip_invalid_file_size']) and
					$advertisement->chkErrorInFile('video_advertisement_file',$LANG['err_tip_invalid_file']);
					if($advertisement->getFormField('advertisement_url'))
						{
							$advertisement->chkIsValidURL('advertisement_url', $LANG['video_advertisement_url_error_msg']);
						}
				$advertisement->defaultValidation();

				if($advertisement->isValidFormInputs())
					{
						$advertisement->updateAdvertisementTable();
						$advertisement->setCommonSuccessMsg($LANG['msg_success_updated']);
						$advertisement->setPageBlockShow('block_msg_form_success');
					}
				else
					{
						$advertisement->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$advertisement->setAllPageBlocksHide();
						$advertisement->setPageBlockShow('block_msg_form_error');
						$advertisement->setPageBlockShow('advertisement_upload_form');
					}
			}
	}
else if($advertisement->isFormPOSTed($_POST, 'yes'))
	{
		if ($CFG['admin']['is_demo_site'])
			{
				$advertisement->setCommonSuccessMsg($advertisement->LANG['general_config_not_allow_demo_site']);
				$advertisement->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				switch($advertisement->getFormField('act'))
					{
						case 'Delete':
							$advertisement->deleteAdvertisement();
							$advertisement->setCommonSuccessMsg($LANG['msg_success_deleted']);
							$advertisement->setPageBlockShow('block_msg_form_success');
							break;

						case 'Activate':
							$advertisement->changeStatusAdvertisement('Activate');
							$advertisement->setCommonSuccessMsg($LANG['msg_success_activated']);
							$advertisement->setPageBlockShow('block_msg_form_success');
							break;

						case 'Inactivate':
							$advertisement->changeStatusAdvertisement('Inactive');
							$advertisement->setCommonSuccessMsg($LANG['msg_success_inactivated']);
							$advertisement->setPageBlockShow('block_msg_form_success');
							break;
					}
			}
	}
else if($advertisement->isFormPOSTed($_GET, 'act'))
	{
		if ($CFG['admin']['is_demo_site'])
			{
				$advertisement->setCommonSuccessMsg($advertisement->LANG['general_config_not_allow_demo_site']);
				$advertisement->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				switch($advertisement->getFormField('act'))
					{
						case 'add':
							$LANG['page_title'] = $LANG['page_add_title'];
							$advertisement->setAllPageBlocksHide();
							$advertisement->setPageBlockShow('advertisement_upload_form');
							break;

						case 'edit':
							if($advertisement->chkIsEditMode())
								{
									if($advertisement->populateadvertisementDetails())
										{
											$LANG['page_title'] = $LANG['page_edit_title'];
											$advertisement->setAllPageBlocksHide();
											$advertisement->setPageBlockShow('advertisement_upload_form');
										}
									else
										{
											$advertisement->setCommonErrorMsg($LANG['common_msg_error_sorry']);
											$advertisement->setPageBlockShow('block_msg_form_error');
										}
								}
							break;
					}
			}
	}
if($advertisement->isFormPOSTed($_POST, 'cancel'))
	{
		Redirect2URL($CFG['site']['url']."admin/video/videoAdvertisement.php");
	}
//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($advertisement->isShowPageBlock('advertisement_upload_form'))
	{
		if($CFG['admin']['video_advertisement_impressions'])
			{
				$advertisement->advertisement_upload_form['datem'] = date('Y')-20;
				$advertisement->advertisement_upload_form['datep'] = date('Y')+20;
			}
		$advertisement->advertisement_upload_form['implode_advertisement_format_arr'] = implode(', ', $CFG['admin']['videos']['advertisement_format_arr']);
		$advertisement->advertisement_upload_form['advertisement_status_array'] = $advertisement_status_array;
		if($advertisement->chkIsEditMode())
			$advertisement->advertisement_upload_form['populateHidden'] = array('advertisement_image', 'advertisement_ext', 'aid', 'start', 'act');
	}
if ($advertisement->isShowPageBlock('advertisement_list'))
    {
		/****** navigtion continue*********/
		$advertisement->buildSelectQuery();
		$advertisement->buildConditionQuery();
		$advertisement->buildSortQuery();
		$advertisement->buildQuery();
		$advertisement->executeQuery();
		if($advertisement->isResultsFound())
			{
				$smartyObj->assign('smarty_paging_list', $advertisement->populatePageLinksGET($advertisement->getFormField('start')));
				$advertisement->advertisement_list['anchor'] = 'dAltMlti';
				$advertisement->advertisement_list['populateHidden'] = array('orderby','orderby_field','start');
				$advertisement->advertisement_list['populateAdvertisementList'] = $advertisement->populateAdvertisementList();
				$advertisement->advertisement_list['onClick_Delete'] = 'if(getMultiCheckBoxValue(\'listAddForm\', \'check_all\', \''.$LANG['check_atleast_one'].'\')){Confirmation(\'selMsgConfirm\', \'actionForm\', Array(\'aid\', \'act\', \'selMsgText\'), Array(multiCheckValue, \'Delete\', \''.$LANG['delete_confirmation'].'\'), Array(\'value\', \'value\', \'innerHTML\'));}';
				$advertisement->advertisement_list['onClick_Activate'] = 'if(getMultiCheckBoxValue(\'listAddForm\', \'check_all\', \''.$LANG['check_atleast_one'].'\')){Confirmation(\'selMsgConfirm\', \'actionForm\', Array(\'aid\', \'act\', \'selMsgText\'), Array(multiCheckValue, \'Activate\', \''.$LANG['activate_confirmation'].'\'), Array(\'value\', \'value\', \'innerHTML\'));}';
				$advertisement->advertisement_list['onClick_Inactivate'] = 'if(getMultiCheckBoxValue(\'listAddForm\', \'check_all\', \''.$LANG['check_atleast_one'].'\')){Confirmation(\'selMsgConfirm\', \'actionForm\', Array(\'aid\', \'act\', \'selMsgText\'), Array(multiCheckValue, \'Inactivate\', \''.$LANG['inactivate_confirmation'].'\'), Array(\'value\', \'value\', \'innerHTML\'));}';
			}
	}
$advertisement->left_navigation_div = 'videoPlayerSetting';
//<<<<<-------------------- Page block templates ends -------------------//
//include the header file
$advertisement->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'video');
$smartyObj->display('videoAdvertisement.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgConfirm');
</script>

<?php
/* Added code to validate mandataory fields in video defaut settings page */
if ($CFG['feature']['jquery_validation'])
{
$allowed_add_image_formats = implode("|", $CFG['admin']['videos']['advertisement_format_arr']);
?>
<script type="text/javascript">
$Jq("#video_advertisement_upload_form").validate({
	rules: {

		advertisement_duration: {
		number: true
		},
	    video_advertisement_file: {
	        required: true,
	    	isValidFileFormat: "<?php echo $allowed_add_image_formats; ?>"
		 }
	},
	messages: {

		advertisement_duration: {
		number: LANG_JS_NUMBER
		},
		video_advertisement_file: {
			required: "<?php echo $LANG['common_err_tip_required'];?>",
			isValidFileFormat: "<?php echo $advertisement->LANG['common_err_tip_invalid_image_format']; ?>"
		}
	}
});
</script>
<?php
}
$advertisement->includeFooter();
?>