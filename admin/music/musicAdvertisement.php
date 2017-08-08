<?php

/**
 * This file is to upload the music advertisement
 * This file is having advertisement class to upload the advertisment image and audio file
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Admin
 * @author 		sathish_040at09
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @since 		2009-10-07
 *
 **/
require_once('../../common/configs/config.inc.php');
require_once('../../common/configs/config_music.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/admin/musicAdvertisement.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['site']['is_module_page']='music';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
/**
 * advertisement
 *
 * @package
 * @author selvaraj_35ag05
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: advertisement.php 2986 2006-12-29 05:25:10Z selvaraj_35ag05 $
 * @access public
 **/
class advertisement extends ListRecordsHandler
	{

		public function setIHObject($imObj)
			{
				$this->imageObj = $imObj;
			}


		/**
		 * advertisement::buildSortQuery()
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
				if (!in_array(strtolower($extern), $this->CFG['admin']['musics']['advertisement_format_arr']))
					{
						$this->fields_err_tip_arr[$field_name] = $err_tip;
						return false;
					}
				return true;
			}

		/**
		 * advertisement::chkValidAudioFileType()
		 *
		 * @param $field_name
		 * @param string $err_tip
		 * @return
		 **/
		public function chkValidAudioFileType($field_name, $err_tip = '')
			{
				$extern = strtolower(substr($_FILES[$field_name]['name'], strrpos($_FILES[$field_name]['name'], '.')+1));
				if (!in_array(strtolower($extern), $this->CFG['admin']['musics']['advertisement_audio_format_arr']))
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
				$max_size = $this->CFG['admin']['musics']['advertisement_max_size'] * 1024;
				if ($_FILES[$field_name]['size'] > $max_size)
					{
						$this->fields_err_tip_arr[$field_name] = $err_tip;
						return false;
					}
				return true;
			}

		/**
		 * advertisement::chkValideAudioFileSize()
		 *
		 * @param $field_name
		 * @param string $err_tip
		 * @return
		 **/
		public function chkValideAudioFileSize($field_name, $err_tip='')
			{
				$max_size = $this->CFG['admin']['musics']['advertisement_audio_max_size'] * 1024 * 1024;
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
				$this->setFormField('advertisement_file', '');
				$this->setFormField('advertisement_audio_file', '');
				$this->setFormField('advertisement_description', '');
				$this->setFormField('advertisement_url', '');
				$this->setFormField('advertisement_duration', '0');
				$this->setFormField('advertisement_channel', array());
				$this->setFormField('advertisement_show_at', 'Begining');
				$this->setFormField('advertisement_status', '');
				$this->setFormField('date_added', '');
				$this->setFormField('act', '');
				$this->setFormField('advertisement_audio_ext', '');
				$this->setFormField('advertisement_image_ext', '');
				$this->setFormField('remove_audio', '');
				$this->setFormField('remove_image', '');
			}

		/**
		 * advertisement::populateadvertisementDetails()
		 *
		 * @return
		 **/
		public function populateadvertisementDetails()
			{
				$sql = 'SELECT advertisement_id, advertisement_name, advertisement_description, advertisement_url,'.
						' advertisement_duration,advertisement_channel,advertisement_audio_ext, '.
						' advertisement_image_ext, advertisement_show_at, advertisement_status'.
						' FROM '.$this->CFG['db']['tbl']['music_advertisement'].' WHERE'.
						' advertisement_id='.$this->dbObj->Param('advertisement_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['aid']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->fields_arr['advertisement_name']        = $row['advertisement_name'];
						$this->fields_arr['advertisement_description'] = $row['advertisement_description'];
						$this->fields_arr['advertisement_url']         = $row['advertisement_url'];
						$this->fields_arr['advertisement_duration']    = $row['advertisement_duration'];
						$this->fields_arr['advertisement_image_ext']   = $row['advertisement_image_ext'];
						$this->fields_arr['advertisement_audio_ext']   = $row['advertisement_audio_ext'];
						$this->fields_arr['advertisement_show_at']     = $row['advertisement_show_at'];
						$this->fields_arr['advertisement_status']      = $row['advertisement_status'];
						$this->fields_arr['advertisement_channel']     = explode(',',$row['advertisement_channel']);
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
				switch($this->fields_arr['advertisement_image_ext'])
					{
						case 'jpg':
							$image_path = $this->CFG['site']['url'].$this->CFG['admin']['musics']['advertisement_image_folder'].$this->fields_arr['aid'].$this->CFG['admin']['musics']['advertisement_image_playlist_name'].'.'.$this->fields_arr['advertisement_image_ext'];
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
	<img src="<?php echo $image_path;?>" alt="<?php echo $this->LANG['advertisement'];?>" width="86px" height="66px" />
<?php
			}

		public function getadvertisementAudioImage(){
			$img_src = $this->CFG['site']['url'].'music/design/templates/'.
																$this->CFG['html']['template']['default'].'/root/images/'.
																	$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_audio_T.jpg';
?>
	<img src="<?php echo $img_src;?>" alt="<?php echo $this->LANG['advertisement'];?>" width="86px" height="66px" />
<?php
		}

		/**
		 * advertisement::removeFiles()
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
				$this->removeFiles($image_name.'.mp3');
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
				$channel = implode(',', $this->fields_arr['advertisement_channel']);
				$advertisement_id = $this->fields_arr['aid'];


				if($this->fields_arr['remove_audio'])
				{
					$emptyext = "''";
					$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_advertisement'].' SET'.
							' advertisement_audio_ext= '.$emptyext.' WHERE advertisement_id='.addslashes($this->fields_arr['aid']);
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt);
			    	if (!$rs)
				    	trigger_db_error($this->dbObj);
				    $image_name = $advertisement_id;
				    $dir = $this->CFG['site']['project_path'].$this->CFG['admin']['musics']['advertisement_audio_folder'];
						$this->deleteFiles($dir.$image_name);
				}

				if($this->fields_arr['remove_image'])
				{
					$emptyext = "''";
					$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_advertisement'].' SET'.
							' advertisement_image_ext= '.$emptyext.' WHERE advertisement_id='.addslashes($this->fields_arr['aid']);
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt);
			    	if (!$rs)
				    	trigger_db_error($this->dbObj);
				    $image_name = $advertisement_id;
				    $dir = $this->CFG['site']['project_path'].$this->CFG['admin']['musics']['advertisement_image_folder'];
						$this->deleteFiles($dir.$image_name.$this->CFG['admin']['musics']['advertisement_image_single_name']);
						$this->deleteFiles($dir.$image_name.$this->CFG['admin']['musics']['advertisement_image_playlist_name']);
				}

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_advertisement'].' SET'.
						' advertisement_name='.$this->dbObj->Param('advertisement_name').','.
						' advertisement_description='.$this->dbObj->Param('advertisement_description').','.
						' advertisement_url='.$this->dbObj->Param('advertisement_url').','.
						' advertisement_duration='.$this->dbObj->Param('advertisement_duration').','.
						' advertisement_channel='.$this->dbObj->Param('advertisement_channel').','.
						' advertisement_show_at='.$this->dbObj->Param('advertisement_show_at').','.
						' advertisement_status='.$this->dbObj->Param('advertisement_status').
						' WHERE advertisement_id=\''.addslashes($this->fields_arr['aid']).'\'';
				$array = array($this->fields_arr['advertisement_name'], $this->fields_arr['advertisement_description'],
								 $this->fields_arr['advertisement_url'], $this->fields_arr['advertisement_duration'],
								 $channel, $this->fields_arr['advertisement_show_at'],
								 $this->fields_arr['advertisement_status']
								 );

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $array);
			    if (!$rs)
				    trigger_db_error($this->dbObj);



				//if($this->advertisement){
					if(!empty($_FILES['advertisement_file']['name'])){
						$imageObj = new ImageHandler($_FILES['advertisement_file']['tmp_name']);
						$this->setIHObject($imageObj);
						$extern = strtolower(substr($_FILES['advertisement_file']['name'], strrpos($_FILES['advertisement_file']['name'], '.')+1));
						$image_name = $advertisement_id;
						$dir = $this->CFG['site']['project_path'].$this->CFG['admin']['musics']['advertisement_image_folder'];
						$this->chkAndCreateFolder($dir);
						$this->deleteFiles($dir.$image_name);
						$this->storeImagesTempServer($dir.$image_name, $extern);

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_advertisement'].' SET'.
									' advertisement_image_ext='.$this->dbObj->Param('advertisement_image_ext').' WHERE'.
									' advertisement_id='.$this->dbObj->Param('advertisement_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($extern, $advertisement_id));
					    if (!$rs)
						    trigger_db_error($this->dbObj);
					}

					if(!empty($_FILES['advertisement_audio_file']['name'])){
							$extern = strtolower(substr($_FILES['advertisement_audio_file']['name'], strrpos($_FILES['advertisement_audio_file']['name'], '.')+1));
							$image_name = $advertisement_id;
							$dir = $this->CFG['site']['project_path'].$this->CFG['admin']['musics']['advertisement_audio_folder'];
							$this->chkAndCreateFolder($dir);
							$this->deleteFiles($dir.$image_name);
							move_uploaded_file($_FILES['advertisement_audio_file']['tmp_name'],$dir.$image_name.'.'.strtolower($extern));

							$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_advertisement'].' SET'.
									' advertisement_audio_ext='.$this->dbObj->Param('advertisement_audio_ext').' WHERE'.
									' advertisement_id='.$this->dbObj->Param('advertisement_id');

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt, array($extern, $advertisement_id));
						    if (!$rs)
							    trigger_db_error($this->dbObj);
						}

				//}
			}

		public function storeImagesTempServer($uploadUrl, $extern)
			{
				//GET LARGE IMAGE
				@chmod($uploadUrl.$this->CFG['admin']['musics']['advertisement_image_single_name'].'.'.$extern, 0777);
				@chmod($uploadUrl.$this->CFG['admin']['musics']['advertisement_image_playlist_name'].'.'.$extern, 0777);
				if($this->CFG['admin']['musics']['advertisement_image_single_height'] or $this->CFG['admin']['musics']['advertisement_image_single_width']){
					$this->imageObj->resize($this->CFG['admin']['musics']['advertisement_image_single_width'], $this->CFG['admin']['musics']['advertisement_image_single_height'], '-');
					$this->imageObj->output_resized($uploadUrl.$this->CFG['admin']['musics']['advertisement_image_single_name'].'.'.$extern, strtoupper($extern));
					$filepathwithextern = $uploadUrl.$this->CFG['admin']['musics']['advertisement_image_single_name'].'.'.$extern;
					$image_info = getImageSize($filepathwithextern);
					$this->L_WIDTH = $image_info[0];
			        $this->L_HEIGHT = $image_info[1];
				}else{
					$this->imageObj->output_original($uploadUrl.'.'.$extern, strtoupper($extern));
					$image_info = getImageSize($uploadUrl.$this->CFG['admin']['musics']['advertisement_image_single_name'].'.'.$extern);
					$this->L_WIDTH = $image_info[0];
			        $this->L_HEIGHT = $image_info[1];
				}

				if($this->CFG['admin']['musics']['advertisement_image_playlist_height'] or $this->CFG['admin']['musics']['advertisement_image_playlist_width']){
					$this->imageObj->resize($this->CFG['admin']['musics']['advertisement_image_playlist_width'], $this->CFG['admin']['musics']['advertisement_image_playlist_height'], '-');
					$this->imageObj->output_resized($uploadUrl.$this->CFG['admin']['musics']['advertisement_image_playlist_name'].'.'.$extern, strtoupper($extern));
					$image_info = getImageSize($uploadUrl.$this->CFG['admin']['musics']['advertisement_image_playlist_name'].'.'.$extern);
					$this->L_WIDTH = $image_info[0];
			        $this->L_HEIGHT = $image_info[1];
				}else{
					$this->imageObj->output_original($uploadUrl.'.'.$extern, strtoupper($extern));
					$image_info = getImageSize($uploadUrl.$this->CFG['admin']['musics']['advertisement_image_playlist_name'].'.'.$extern);
					$this->L_WIDTH = $image_info[0];
			        $this->L_HEIGHT = $image_info[1];
				}
			}

		/**
		 * advertisement::insertAdvertisementTable()
		 *
		 * @return
		 */
		public function insertAdvertisementTable()
			{
				$newChannelArray = array();
				$i = 0;
				foreach ($this->fields_arr['advertisement_channel'] as $key => $value) {
				  if (!empty($value)) {
				    $newChannelArray[$i] = $value;
				    $i++;
				  }
				}
				$channel = implode(',', $newChannelArray);

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_advertisement'].' SET'.
						' advertisement_name='.$this->dbObj->Param('advertisement_name').','.
						' user_id='.$this->dbObj->Param('user_id').','.
						' advertisement_description='.$this->dbObj->Param('advertisement_description').','.
						' advertisement_url='.$this->dbObj->Param('advertisement_url').','.
						' advertisement_duration='.$this->dbObj->Param('advertisement_duration').','.
						' advertisement_channel='.$this->dbObj->Param('advertisement_channel').','.
						' advertisement_show_at='.$this->dbObj->Param('advertisement_show_at').','.
						' advertisement_status='.$this->dbObj->Param('advertisement_status').','.
						' date_added=NOW()';
				$array = array($this->fields_arr['advertisement_name'], $this->CFG['user']['user_id'], $this->fields_arr['advertisement_description'],
								 $this->fields_arr['advertisement_url'], $this->fields_arr['advertisement_duration'],
								 $channel, $this->fields_arr['advertisement_show_at'],
								 $this->fields_arr['advertisement_status']
								 );

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $array);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($advertisement_id = $this->dbObj->Insert_ID())
					{
						if(!empty($_FILES['advertisement_file']['name'])){
							$imageObj = new ImageHandler($_FILES['advertisement_file']['tmp_name']);
							$this->setIHObject($imageObj);
							$extern = strtolower(substr($_FILES['advertisement_file']['name'], strrpos($_FILES['advertisement_file']['name'], '.')+1));
							$image_name = $advertisement_id;
							$dir = '../../'.$this->CFG['admin']['musics']['advertisement_image_folder'];
							$this->chkAndCreateFolder($dir);
							$this->deleteFiles($dir.$image_name);
							$this->storeImagesTempServer($dir.$image_name, $extern);
							//move_uploaded_file($_FILES['advertisement_file']['tmp_name'],$dir.$image_name.'.'.strtolower($extern));

							$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_advertisement'].' SET'.
									' advertisement_image_ext='.$this->dbObj->Param('advertisement_image_ext').' WHERE'.
									' advertisement_id='.$this->dbObj->Param('advertisement_id');

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt, array($extern, $advertisement_id));
						    if (!$rs)
							    trigger_db_error($this->dbObj);
						}

						if(!empty($_FILES['advertisement_audio_file']['name'])){
							$extern = strtolower(substr($_FILES['advertisement_audio_file']['name'], strrpos($_FILES['advertisement_audio_file']['name'], '.')+1));
							$image_name = $advertisement_id;
							$dir = '../../'.$this->CFG['admin']['musics']['advertisement_audio_folder'];
							$this->chkAndCreateFolder($dir);
							$this->deleteFiles($dir.$image_name);
							move_uploaded_file($_FILES['advertisement_audio_file']['tmp_name'],$dir.$image_name.'.'.strtolower($extern));

							$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_advertisement'].' SET'.
									' advertisement_audio_ext='.$this->dbObj->Param('advertisement_audio_ext').' WHERE'.
									' advertisement_id='.$this->dbObj->Param('advertisement_id');

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt, array($extern, $advertisement_id));
						    if (!$rs)
							    trigger_db_error($this->dbObj);
						}
					}
			}

		/**
		 * advertisement::populateMusicCatagory()
		 *
		 * @param string $err_tip
		 * @return
		 **/
		public function populateMusicCatagory($err_tip='')
			{
				$sql = 'SELECT music_category_id, music_category_name FROM '.$this->CFG['db']['tbl']['music_category'].
						' WHERE  music_category_status=\'Yes\' AND parent_category_id =\'0\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if(!$rs->PO_RecordCount())
					return;

				$names = array('music_category_name');
				$value = 'music_category_id';
				$highlight_value = $this->fields_arr['advertisement_channel'];
				$coun = 0;
?>
				<table>
				<ul>
					<!--<li class="clsGroups"><input type="checkbox" class="clsCheckRadio" class="clsCheckBox" name="advertisement_channel[]" id="advertisement_channel_groups" tabindex="{smartyTabIndex}" value="groups"<?php echo $this->isCheckedCheckBoxArray('advertisement_channel', 'groups');?> /><label for="advertisement_channel_groups"><?php echo $this->LANG['groups'];?></label></li>-->
<?php
				$inc = 1;
				$recordCount = $rs->PO_RecordCount();
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
							<input type="checkbox" class="clsCheckRadio" class="clsCheckBox" name="advertisement_channel[]" id="advertisement_channel<?php echo $row[$value];?>" tabindex="{smartyTabIndex}" value="<?php echo $row[$value];?>"<?php echo $this->isCheckedCheckBoxArray('advertisement_channel', $row['music_category_id']);?> />

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
				if($recordCount > 2){
?>
				<li>
					<tr>
						<td>
							<input type="checkbox" class="clsCheckRadio" class="clsCheckBox" name="advertisement_channel[]" onclick="return selectVal('1')" id="advertisement_channel0" tabindex="{smartyTabIndex}" value="" />
							<label for="advertisement_channel0"><?php echo $this->LANG['advertisment_all'];?></label>
						</td>
					</tr>
				</li>
<?php
				}
?>

				</ul>
				</table>
<?php
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
				    trigger_db_error($this->dbObj);
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
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_advertisement'].' WHERE'.
						' advertisement_id IN('.$this->fields_arr['aid'].')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$dir = '../'.$this->CFG['admin']['musics']['advertisement_image_folder'];
				$dir_audio = '../'.$this->CFG['admin']['musics']['advertisement_audio_folder'];
				$array = explode(',', $this->fields_arr['aid']);
				foreach($array as $key=>$value)
					{
						$image_name = $value;
						$this->deleteFiles($dir.$image_name);
						$this->deleteFiles($dir_audio.$image_name);
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
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_advertisement'].' SET'.
						' advertisement_status='.$this->dbObj->Param('advertisement_status').' WHERE'.
						' advertisement_id IN('.$this->fields_arr['aid'].')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($status));
			    if (!$rs)
				    trigger_db_error($this->dbObj);
			}

		/**
		 * advertisement::defaultValidation()
		 *
		 * @return
		 */
		public function defaultValidation()
			{
				$this->getFormField('advertisement_duration') and
					$this->chkIsNumeric('advertisement_duration',$this->LANG['err_tip_numeric']);
			}
	}
//<<<<<-------------- Class advertisement begins ---------------//
//-------------------- Code begins -------------->>>>>//
/*echo '<pre>';
print_r($_REQUEST);
echo '</pre>'; */
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
$advertisement->setTableNames(array($CFG['db']['tbl']['music_advertisement']));
$advertisement->setReturnColumns(array('advertisement_id', 'user_id', 'advertisement_name', 'advertisement_description', 'advertisement_url', 'advertisement_duration', 'advertisement_channel', 'advertisement_audio_ext', 'advertisement_image_ext', 'advertisement_show_at', 'advertisement_status', 'DATE_FORMAT(date_added,\''.$CFG['format']['date'].'\') AS date_added'));
/************ page Navigation stop *************/
$audioFormat = implode(', ', $CFG['admin']['musics']['advertisement_audio_format_arr']);
$imageFormat = implode(', ', $CFG['admin']['musics']['advertisement_format_arr']);
$smartyObj->assign('audio_format', $audioFormat);
$smartyObj->assign('image_format', $imageFormat);
$advertisement->setAllPageBlocksHide();
$advertisement->sanitizeFormInputs($_REQUEST);
/*echo '<pre>';
print_r($_FILES);
echo '</pre>';*/
$advertisement->setPageBlockShow('advertisement_list');
$checkEmpty = 'N';
if($advertisement->getFormField('msg') == 'add')
	{
			$advertisement->setCommonSuccessMsg($LANG['msg_success_added']);
			$advertisement->setPageBlockShow('block_msg_form_success');
	}
	if($advertisement->isFormPOSTed($_POST, 'add')){
		//$checkEmpty = empty($_FILES['advertisement_audio_file']['name'])?(empty($_FILES['advertisement_file']['name'])?'Y':'N'):'N';

		if($CFG['admin']['is_demo_site'])
			{
				$advertisement->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
				$advertisement->setAllPageBlocksHide();
				$advertisement->setPageBlockShow('block_msg_form_success');
				$advertisement->setPageBlockShow('advertisement_upload_form');
			}
		else
			{

			if(!empty($_FILES['advertisement_audio_file']['name'])){
				$advertisement->chkFileNameIsNotEmpty('advertisement_audio_file', $LANG['err_tip_compulsory']) and
				$advertisement->chkValidAudioFileType('advertisement_audio_file',$LANG['err_tip_invalid_file_type']) and
				$advertisement->chkValideAudioFileSize('advertisement_audio_file',$LANG['err_tip_invalid_file_size']) and
				$advertisement->chkErrorInFile('advertisement_audio_file',$LANG['err_tip_invalid_file']);
			}elseif(!empty($_FILES['advertisement_file']['name'])){
				$advertisement->chkValidFileType('advertisement_file',$LANG['err_tip_invalid_file_type']) and
				$advertisement->chkValideFileSize('advertisement_file',$LANG['err_tip_invalid_file_size']) and
				$advertisement->chkErrorInFile('advertisement_file',$LANG['err_tip_invalid_file']);
			}else{
				$checkEmpty = 'Y';
				$advertisement->setCommonErrorMsg($LANG['err_tip_upload_compulsory']);
			}

			if($advertisement->getFormField('advertisement_url')){
				$advertisement->chkIsValidURL('advertisement_url', $LANG['music_advertisement_url_error_msg']);
			}
			$advertisement->defaultValidation();

			if($advertisement->isValidFormInputs())
				{
					$advertisement->insertAdvertisementTable();
					Redirect2URL($CFG['site']['url']."admin/music/musicAdvertisement.php?msg=add");
				}
			else
				{
					if($checkEmpty == 'Y')
						$advertisement->setCommonErrorMsg($LANG['err_tip_upload_compulsory']);
					else
						$advertisement->setCommonErrorMsg($LANG['common_msg_error_sorry']);
					$advertisement->setAllPageBlocksHide();
					$advertisement->setPageBlockShow('block_msg_form_error');
					$advertisement->setPageBlockShow('advertisement_upload_form');
				}
		}
	}
else if($advertisement->isFormPOSTed($_POST, 'update'))
	{
		if($CFG['admin']['is_demo_site'])
			{
				$advertisement->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
				$advertisement->setAllPageBlocksHide();
				$advertisement->setPageBlockShow('block_msg_form_success');
				$advertisement->setPageBlockShow('advertisement_upload_form');
			}
		else
			{

			if(!empty($_FILES['advertisement_audio_file']['name'])){
				$advertisement->chkFileNameIsNotEmpty('advertisement_audio_file', $LANG['err_tip_compulsory']) and
				$advertisement->chkValidAudioFileType('advertisement_audio_file',$LANG['err_tip_invalid_file_type']) and
				$advertisement->chkValideAudioFileSize('advertisement_audio_file',$LANG['err_tip_invalid_file_size']) and
				$advertisement->chkErrorInFile('advertisement_audio_file',$LANG['err_tip_invalid_file']);
			}elseif(!empty($_FILES['advertisement_file']['name'])){
				$advertisement->chkValidFileType('advertisement_file',$LANG['err_tip_invalid_file_type']) and
				$advertisement->chkValideFileSize('advertisement_file',$LANG['err_tip_invalid_file_size']) and
				$advertisement->chkErrorInFile('advertisement_file',$LANG['err_tip_invalid_file']);
			}
			$musicEmpty = 'N';
			$imageEmpty = 'N';
			$checkEmpty = 'N';
			if(empty($_FILES['advertisement_audio_file']['name']))
			{
				if($advertisement->getFormField('remove_audio'))
				{
					$musicEmpty = 'Y';
				}
				if($advertisement->getFormField('advertisement_audio_ext')=='')
				{
					$musicEmpty = 'Y';
				}
			}
			if(empty($_FILES['advertisement_file']['name']))
			{
				if($advertisement->getFormField('remove_image'))
				{
					$imageEmpty = 'Y';
				}
				if($advertisement->getFormField('advertisement_image_ext')=='')
				{
					$imageEmpty = 'Y';
				}
			}
			//echo 'music-->'.$musicEmpty;
			//echo '<br/>image-->'.$imageEmpty;
			if($musicEmpty == 'Y' && $imageEmpty == 'Y')
			{
				$checkEmpty = 'Y';
				$advertisement->setCommonErrorMsg($LANG['err_tip_upload_compulsory_update']);
			}


	/*
	$advertisement->advertisement = $advertisement->chkFileNameIsNotEmptyEdit('advertisement_file', $LANG['err_tip_compulsory']) and
				$advertisement->chkValidFileType('advertisement_file',$LANG['err_tip_invalid_file_type']) and
				$advertisement->chkValideFileSize('advertisement_file',$LANG['err_tip_invalid_file_size']) and
				$advertisement->chkErrorInFile('advertisement_file',$LANG['err_tip_invalid_file']);
	*/
				if($advertisement->getFormField('advertisement_url'))
					{
						$advertisement->chkIsValidURL('advertisement_url', $LANG['music_advertisement_url_error_msg']);
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
					if($checkEmpty == 'Y')
						$advertisement->setCommonErrorMsg($LANG['err_tip_upload_compulsory_update']);
					else
						$advertisement->setCommonErrorMsg($LANG['common_msg_error_sorry']);
					//$advertisement->setCommonErrorMsg($LANG['common_msg_error_sorry']);
					$advertisement->setAllPageBlocksHide();
					$advertisement->setPageBlockShow('block_msg_form_error');
					$advertisement->setPageBlockShow('advertisement_upload_form');
				}
		}
	}
else if($advertisement->isFormPOSTed($_POST, 'yes'))
	{

		if($CFG['admin']['is_demo_site'])
			{
				$advertisement->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
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
if($advertisement->isFormPOSTed($_POST, 'cancel'))
	{
		Redirect2URL($CFG['site']['url']."admin/music/musicAdvertisement.php");
	}
//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($advertisement->isShowPageBlock('advertisement_upload_form'))
	{
		$advertisement->advertisement_upload_form['implode_advertisement_format_arr'] = implode(', ', $CFG['admin']['musics']['advertisement_format_arr']);
		$advertisement->advertisement_upload_form['advertisement_status_array'] = $advertisement_status_array;
		if($advertisement->chkIsEditMode())
			$advertisement->advertisement_upload_form['populateHidden'] = array('advertisement_audio_ext', 'advertisement_image_ext', 'aid', 'start', 'act');
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
$advertisement->left_navigation_div = 'musicSetting';
//<<<<<-------------------- Page block templates ends -------------------//
//include the header file
$advertisement->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'music');
$smartyObj->display('musicAdvertisement.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgConfirm');

	function selectVal(val){
		var theForm = document.advertisement_upload_form;
		//alert(theForm.elements.length);
		for (i=0; i<theForm.elements.length; i++) {
			if(theForm.elements[i].name=='advertisement_channel[]' && document.getElementById('advertisement_channel0').checked)
				theForm.elements[i].checked = true;
			else
				theForm.elements[i].checked = false;
		}
	}

	/*function select(a) {
		alert(a);
    	/*var theForm = document.advertisement_upload_form;
	    for (i=0; i<theForm.elements.length; i++) {
	        if (theForm.elements[i].name=='advertisement_channel[]')
	            theForm.elements[i].checked = a;
	    }*
	}*/

</script>
<?php
$advertisement->includeFooter();
?>