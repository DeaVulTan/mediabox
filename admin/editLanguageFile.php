<?php
/**
 * This file hadling the Edit language files
 *
 * Edit language files for root and members language files. Admin can see the language phrases for each language
 * variable and they can edit the language phrases and update their own new language phrases.
 * First available languages will be listed then the folder list will be there.
 * Admin can choose language option and directory. After submit the corresponding folder file list
 * would be listed. Admin can choose one of files and can submit.
 * After submit the corresponding file language variable and phrases would be listed.
 * Admin can edit the phrases but there should not be any ' symbol that may afect script.
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/editLanguageFile.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//------------------- Class EditLanguageHandler ------------------->>>>>//
/**
 * This class hadling the Edit language files
 *
 * @category	Rayzz
 * @package		Admin
 */
class EditLanguageHandler extends FormHandler
	{
		/**
		 * EditLanguageHandler::populateList()
		 * Populate given List
		 *
		 * @param		array $list_arr list array
		 * @param		string $highlight_value
		 * @return		void
		 * @access		public
		 */
		public function populateList($list_arr, $highlight_value='')
			{
				foreach($list_arr as $key => $value)
					{
?>
<option value="<?php echo $key; ?>"<?php echo ($highlight_value == $key) ? ' selected="selected"' : ''; ?>><?php echo $value;?></option>
<?php
					}
			}

		/**
		 * EditLanguageHandler::populateHiddenFormFields()
		 * Populate hidden form fields
		 *
		 * Populate hidden form fields for the array of fields
		 *
		 * @param		array $field_names_arr the array of fields
		 * @return		void
		 * @access		public
		 **/
		public function populateHiddenFormFields($field_names_arr=array())
			{
				foreach($field_names_arr as $field_name)
					{
						if (is_array($this->fields_arr[$field_name]))
							{
								foreach($this->fields_arr[$field_name] as $sub_field_value)
									{
?>
<input type="hidden" name="<?php echo $field_name;?>[]" value="<?php echo $sub_field_value;?>" />
<?php
									}
							}
						else
							{
?>
<input type="hidden" name="<?php echo $field_name;?>" value="<?php echo $this->fields_arr[$field_name];?>" />
<?php
							}
					}
			}

		/**
		 * EditLanguageHandler::setDirectoryPath()
		 * Sets directory path
		 *
		 * Sets directory path
		 *
		 * @param		array $dir_path_arr directory path list
		 * @return 		void
		 * @access		public
		 */
		public function setDirectoryPath($dir_path_arr)
			{
				$this->dir_path_arr = $dir_path_arr;
			}

		/**
		 * EditLanguageHandler::setDirectoryPath()
		 * Populate File names list
		 *
		 * Populate File names list for select folder
		 *
		 * @param		string $highlight_value highlight value
		 * @param		string $unwanted_files_list_arr unwanted fils list
		 * @return 		void
		 * @access		public
		 */
		public function populateFileNamesList($highlight_value, $unwanted_files_list_arr)
			{
				if ($handle = opendir($this->dir_path_arr[$this->fields_arr['directory']].$this->fields_arr['language'].'/'.$this->fields_arr['directory'].'/'))
					{
						   /* This is the correct way to loop over the directory. */
					   while (($file = readdir($handle)) !== false)
				   			{
				   				if (strpos($file, '.php') !== false and (array_search($file, $unwanted_files_list_arr) === false))
									{
?>
<option value="<?php echo $file; ?>"<?php echo ($file == $highlight_value) ? ' selected="selected"' : '';?>><?php echo $file; ?></option>
<?php
									}
							}
						closedir($handle);
					}
			}

		/**
		 * EditLanguageHandler::chkIsFromList()
		 *
		 * Check is from valid array value
		 *
		 * @param		array $option_arr
		 * @param		string $field_name field name
		 * @param		string $err_tip error tip
		 * @return 		boolean true/false
		 * @access		public
		 */
		public function chkIsFromList($option_arr, $field_name, $err_tip='')
			{
				$is_ok = isset($option_arr[$this->fields_arr[$field_name]]);
				if (!$is_ok)
					$this->fields_err_tip_arr[$field_name] = $err_tip;
				return $is_ok;
			}

		/**
		 * EditLanguageHandler::chkIsFileExist()
		 * Check is file exist to find valid file
		 *
		 * @param		string $file file field name
		 * @param		string $unwanted_files_list_arr unwanted fils list
		 * @param		string $err_tip error tip
		 * @param		string $read_err_tip read error tip
		 * @param		string $write_err_tip write error tip
		 * @return 		boolean true/false
		 * @access		public
		 */
		public function chkIsFileExist($file, $unwanted_files_list_arr, $err_tip, $read_err_tip, $write_err_tip)
			{
				// set file name with path
				$file_path = $this->dir_path_arr[$this->fields_arr['directory']].$this->fields_arr['language'].'/'.$this->fields_arr['directory'].'/'.$this->fields_arr[$file];
				//read file content
				$is_ok = ((array_search($this->fields_arr[$file], $unwanted_files_list_arr) === false) and file_exists($file_path));
				if (!$is_ok)
					$this->fields_err_tip_arr[$file] = $err_tip;
				else if (!is_readable($file_path))
					$this->fields_err_tip_arr[$file] = $read_err_tip;
				else if (!is_writable($file_path))
					$this->fields_err_tip_arr[$file] = $write_err_tip;
				return $is_ok;
			}

		/**
		 * EditLanguageHandler::updateFileContent()
		 * Update edited file content
		 *
		 * @param		array $post_arr post array
		 * @return 		void
		 * @access		public
		 * @todo		Need to check and improve find and replacement. Because some time the
		 * 				language file has special characters too.
		 */
		public function updateFileContent($post_arr)
			{
				// set file name with path
				$file_path = $this->dir_path_arr[$this->fields_arr['directory']].$this->fields_arr['language'].'/'.$this->fields_arr['directory'].'/'.$this->fields_arr['file'];
				//read file content
				$content = file_get_contents($file_path);
				//include the file as
				require($file_path);
				// checks whether file edited
				$is_file_edited = false;
				foreach($post_arr as $varname => $value)
					{
				       	// checks variable value has been changed
				    	if (isset($LANG[$varname]) and isset($post_arr[$varname]) and $LANG[$varname] != $post_arr[$varname])
							{
								$is_file_edited = true;
								// replace value of file content
								// vaiable start pos
						        $variable_start = strpos($content, $varname , 0);
					         	// vaiable end pos
					        	$end_of_variable = strpos($content, '=', $variable_start ) + 1;
						       	// get content before value
					        	$content_before_value = trim(substr($content, 0, $end_of_variable));
						       	// vaiable line end pos
					            $variable_end_pos = strpos($content, ';', $end_of_variable);
					            // get content after value
					            $content_after_value = trim(substr($content, $variable_end_pos));
						       	// new content+
					            $content = $content_before_value. ' \''.addslashes($post_arr[$varname]) .'\''.$content_after_value;
							}
				  	}
				if ($is_file_edited )
					{
						$fw = fopen($file_path, 'w');
						fwrite($fw, $content);
						fclose($fw);
					}
			}

		public function updateListArrayFileContent($post_arr)
			{
				// set file name with path
				$file_path = $this->dir_path_arr[$this->fields_arr['directory']].$this->fields_arr['language'].'/'.$this->fields_arr['directory'].'/'.$this->fields_arr['file'];
				//include the file as
				require($file_path);
				$temp_lang = $this->getCollabseKeyValuePair($LANG_LIST_ARR);
				if($temp_lang = $this->getExpandKeyValuePair($post_arr, $temp_lang))
					{
						$content = $this->getListArrayContentToWrite($temp_lang, "<?php \n\n \$LANG_LIST_ARR", true);
						$content = substr($content, 0, strrpos($content, ',')).";\n\n?>";
						$fw = fopen($file_path, 'w');
						fwrite($fw, $content);
						fclose($fw);
					}
			}

		/**
		 * EditLanguageHandler::stripslashesNew()
		 * To strip the slashes and some special charactes
		 *
		 * @param		string $value input value
		 * @return 		string
		 * @access		public
		 */
		public function stripslashesNew($value)
			{
				$value = str_replace('\\', '~*@', $value);
				$value = stripslashes($value);
				$value = str_replace('~*@', '\\', $value);
				$value = str_replace('\"', '"', $value);
				return $value;
			}

		/**
		 * EditLanguageHandler::getLanguagesList()
		 * To get the languages list
		 *
		 * @return 		array
		 * @access		public
		 */
		public function getLanguagesList()
			{
				return $this->CFG['lang']['available_languages'];
			}

		/**
		 * EditLanguageHandler::populateLanguageDetails()
		 * To populate the languages details
		 *
		 * @return 		array
		 * @access		public
		 */
		public function populateLanguageDetails()
			{
				return $this->CFG['lang']['available_languages'];
			}

		public function getCollabseKeyValuePair($arr, $key = '', $return = array())
			{
				if(is_array($arr))
					{
						foreach($arr as $key1=>$val1)
							{
								$return = $this->getCollabseKeyValuePair($val1, $key.'__'.$key1, $return);
							}
					}
				else{
						$key = substr($key, 2, strlen($key));
						$return[$key] = $arr;
					}
				return $return;
			}

		public function getExpandKeyValuePair($arr, $base_arr)
			{
				$return = array();
				foreach($arr as $key1=>$val1)
					{
						if(!isset($base_arr[$key1]))
							{
								continue;
							}
						$karr2 = explode('__', $key1);
						switch(sizeof($karr2))
							{
								case '1':
									$return[$karr2[0]] = $val1;
									break;

								case '2':
									$return[$karr2[0]][$karr2[1]] = $val1;
									break;

								case '3':
									$return[$karr2[0]][$karr2[1]][$karr2[2]] = $val1;
									break;
							}
					}
				return $return;
			}

		public function getListArrayContentToWrite($arr, $content = '', $square = false)
			{
				if(is_array($arr))
					{
						foreach($arr as $key1=>$val1)
							{
								if(is_array($val1))
									{
										if($square)
											{
												$content .= '[\''.addslashes($key1).'\'] = array(';
											}
										else
											{
												$content .= "\n\t\t'".addslashes($key1)."' => array(";
											}
										$content = $this->getListArrayContentToWrite($val1, $content);
										$content = substr($content, 0, strrpos($content, ','));
										$content .= '),';
									}
								else
									{
										$content .= "\n\t\t'".addslashes($key1)."'=>'".addslashes($val1)."',";
									}
							}
					}
				return $content;
			}
	}
//<<<<<<<---------------------------class EditLanguageHandler--------------------//
//-------------------------------------Code begins-------------------------->>>>>//
$editLanguageObj = new EditLanguageHandler();
//set blocks
$editLanguageObj->setPageBlockNames(array('block_msg_form_success', 'block_msg_form_error', 'block_form_directory_list', 'block_form_files_list', 'block_form_edit_phrases', 'block_page_list_phrases'));
//set Form Fields
$editLanguageObj->setFormField('language', $CFG['lang']['default']);
$editLanguageObj->setFormField('directory', 'root');
$editLanguageObj->setFormField('file', '');
$editLanguageObj->setFormField('success_msg', '');
$editLanguageObj->setFormField('question', array());
$editLanguageObj->setFormField('answer', array());
$editLanguageObj->setFormField('action', '');
$CFG['lang']['available_languages'] = $editLanguageObj->getLanguagesList();
// folders languate
$lang_folders_arr = array( 'root' => $LANG['langedit_root'],
					       'members' => $LANG['langedit_members'],
						   'admin' => $LANG['langedit_admin'],
						   'general' => $LANG['langedit_general'],
						   'common' => $LANG['langedit_common'],
						   'lists_array' => $LANG['langedit_lists_array']
				       );
foreach($CFG['site']['modules_arr'] as $value)
	{
		if(chkAllowedModule(array(strtolower($value))))
		  	{
		   		$lang_folders_arr[strtolower($value)] = $LANG['langedit_'.strtolower($value)];
		    	$lang_folders_arr[strtolower($value).'/admin']= $LANG['langedit_'.strtolower($value).'_admin'];
		  	}
	}
// set directory path
$directory_path_arr = array('root' => '../languages/',
							'members' => '../languages/',
							'admin' => '../languages/',
							'general' => '../languages/',
							'common' => '../languages/',
							'lists_array' => '../languages/'
					       );

foreach($CFG['site']['modules_arr'] as $value)
	{
    	if(chkAllowedModule(array(strtolower($value))))
	      	{
	  	   		$directory_path_arr[strtolower($value)] = '../languages/';
	        	$directory_path_arr[strtolower($value).'/admin'] = '../languages/';
		  	}
 	}
// set directory path
$editLanguageObj->setDirectoryPath($directory_path_arr);
// set unwanted file list
$unwanted_files_list_arr = array('html_header.php', 'html_footer.php', 'accessibility.php', 'useTerms.php', 'privacyPolicy.php', 'mainMenu.php', 'dashboardShortcutsLinks.php', 'email_notify.inc.php', 'help.inc.php');
// Hide All Blocks and show default page
$editLanguageObj->setAllPageBlocksHide();
$editLanguageObj->setPageBlockShow('block_form_directory_list');

if ($editLanguageObj->isFormPOSTed($_POST, 'submit_cancel'))
	{
		Redirect2Url('index.php');
	}
if ($editLanguageObj->isFormPOSTed($_POST, 'submit_back_files'))
	{
		$editLanguageObj->sanitizeFormInputs($_POST);
		$editLanguageObj->setAllPageBlocksHide();
		$editLanguageObj->setPageBlockShow('block_form_directory_list');
	}
if ($editLanguageObj->isFormPOSTed($_POST, 'submit_back_phrases'))
	{
		$editLanguageObj->sanitizeFormInputs($_POST);
		$editLanguageObj->setAllPageBlocksHide();
		$editLanguageObj->setPageBlockShow('block_form_files_list');
	}
// Submit directory
if ($editLanguageObj->isFormPOSTed($_POST, 'submit_directory'))
	{
		// sanitize for inputs
		$editLanguageObj->sanitizeFormInputs($_POST);
		// validation
		$editLanguageObj->chkIsNotEmpty('language', $LANG['common_err_tip_compulsory']) and
			$editLanguageObj->chkIsFromList($CFG['lang']['available_languages'], 'language', $LANG['langedit_err_tip_invalid']);
		$editLanguageObj->chkIsNotEmpty('directory', $LANG['common_err_tip_compulsory']) and
			$editLanguageObj->chkIsFromList($lang_folders_arr, 'directory', $LANG['langedit_err_tip_invalid']);

		// check valid form inputs
		if ($editLanguageObj->isValidFormInputs())
			{
				// Hide All Blocks and show default page
				$editLanguageObj->setAllPageBlocksHide();
				$editLanguageObj->setPageBlockShow('block_form_files_list');
			}
		else
			{
				// Hide All Blocks and show default page
				$editLanguageObj->setAllPageBlocksHide();
				$editLanguageObj->setPageBlockShow('block_form_directory_list');
				$editLanguageObj->setPageBlockShow('block_msg_form_error');
			}
	}
// submit file
if ($editLanguageObj->isFormPOSTed($_POST, 'submit_files'))
	{
		// sanitize for inputs
		$editLanguageObj->sanitizeFormInputs($_POST);
		// validation
		$editLanguageObj->chkIsNotEmpty('language', $LANG['common_err_tip_compulsory']) and
			$editLanguageObj->chkIsFromList($CFG['lang']['available_languages'], 'language', $LANG['langedit_err_tip_invalid']);
		$editLanguageObj->chkIsNotEmpty('directory', $LANG['common_err_tip_compulsory']) and
			$editLanguageObj->chkIsFromList($lang_folders_arr, 'directory', $LANG['langedit_err_tip_invalid']);
		$editLanguageObj->chkIsNotEmpty('file', $LANG['common_err_tip_compulsory']) and
			$editLanguageObj->chkIsFileExist('file', $unwanted_files_list_arr, $LANG['langedit_err_tip_invalid'], $LANG['langedit_read_err_tip_invalid'], $LANG['langedit_write_err_tip_invalid']);
		if ($editLanguageObj->isValidFormInputs())
			{
				// Hide All Blocks and show default page
				$editLanguageObj->setAllPageBlocksHide();
				$editLanguageObj->setPageBlockShow('block_form_edit_phrases');
			}
		else
			{
				// Hide All Blocks and show default page
				$editLanguageObj->setAllPageBlocksHide();
				$editLanguageObj->setPageBlockShow('block_form_files_list');
				$editLanguageObj->setPageBlockShow('block_msg_form_error');
			}
	}
// submit file
if ($editLanguageObj->isFormPOSTed($_POST, 'submit_phrases'))
	{
		if($CFG['admin']['is_demo_site'])
			{
				$editLanguageObj->setFormField('success_msg', $LANG['general_config_not_allow_demo_site']);
				$editLanguageObj->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				// sanitize for inputs
				$editLanguageObj->sanitizeFormInputs($_POST);
				// validation
				$editLanguageObj->chkIsNotEmpty('language', $LANG['common_err_tip_compulsory']) and
					$editLanguageObj->chkIsFromList($CFG['lang']['available_languages'], 'language', $LANG['langedit_err_tip_invalid']);
				$editLanguageObj->chkIsNotEmpty('directory', $LANG['common_err_tip_compulsory']) and
					$editLanguageObj->chkIsFromList($lang_folders_arr, 'directory', $LANG['langedit_err_tip_invalid']);
				$editLanguageObj->chkIsNotEmpty('file', $LANG['common_err_tip_compulsory']) and
					$editLanguageObj->chkIsFileExist('file', $unwanted_files_list_arr, $LANG['langedit_err_tip_invalid'], $LANG['langedit_read_err_tip_invalid'], $LANG['langedit_write_err_tip_invalid']);
				// update file content
				if($editLanguageObj->getFormField('directory')=='lists_array')
					{
						$editLanguageObj->updateListArrayFileContent($_POST);
					}
				else
					{
						$editLanguageObj->updateFileContent($_POST);
					}
				// Hide All Blocks and show default page
				$editLanguageObj->setAllPageBlocksHide();
				$editLanguageObj->setPageBlockShow('block_form_directory_list');
				$editLanguageObj->setPageBlockShow('block_msg_form_success');
				$editLanguageObj->setPageBlockShow('block_page_list_phrases');
				$editLanguageObj->setFormField('success_msg', sprintf($LANG['langedit_msg_success'], $editLanguageObj->getFormField('file')));
			}
	}

// Submit directory
if ($editLanguageObj->isFormPOSTed($_GET, 'language') and $editLanguageObj->isFormPOSTed($_GET, 'directory'))
	{
		// sanitize for inputs
		$editLanguageObj->sanitizeFormInputs($_GET);
		// validation
		$editLanguageObj->chkIsNotEmpty('language', $LANG['common_err_tip_compulsory']) and
			$editLanguageObj->chkIsFromList($CFG['lang']['available_languages'], 'language', $LANG['langedit_err_tip_invalid']);
		$editLanguageObj->chkIsNotEmpty('directory', $LANG['common_err_tip_compulsory']) and
			$editLanguageObj->chkIsFromList($lang_folders_arr, 'directory', $LANG['langedit_err_tip_invalid']);
		// check valid form inputs
		if ($editLanguageObj->isValidFormInputs())
			{
				// Hide All Blocks and show default page
				$editLanguageObj->setAllPageBlocksHide();
				$editLanguageObj->setPageBlockShow('block_form_files_list');
			}
		else
			{
				// Hide All Blocks and show default page
				$editLanguageObj->setAllPageBlocksHide();
				$editLanguageObj->setPageBlockShow('block_form_directory_list');
				$editLanguageObj->setPageBlockShow('block_msg_form_error');
			}
	}
//<<<<--------------------------------Code Ends-----------------------------//

//--------------------Page block templates begins-------------------->>>>>>>>>//
//include the header file
$editLanguageObj->left_navigation_div = 'generalLanguage';
$editLanguageObj->includeHeader();
?>
<div id="selHelpLangEdit">
	<div id="selManageLaguageFile">
    	<h2><?php echo $LANG['langedit_lang_editing'];?></h2>
		<?php
if ($editLanguageObj->isShowPageBlock('block_msg_form_error'))
	{
?>
<div id="selMsgError">
    <p><?php echo $LANG['common_msg_error_sorry'].' '. $editLanguageObj->getCommonErrorMsg();?></p>
</div>
<?php
	}
if ($editLanguageObj->isShowPageBlock('block_msg_form_success'))
	{
?>
<div id="selMsgSuccess">
	<p><?php echo $editLanguageObj->getFormField('success_msg');?></p>
</div>
    <?php
}

if ($editLanguageObj->isShowPageBlock('block_form_directory_list'))
	{
?>
	<div id="selDirectoryList">
      	<form name="block_form_directory_list" id="block_form_directory_list" method="post" action="editLanguageFile.php">
        	<table class="clsFormSection clsNoBorder">
          		<tr>
	            	<td class="<?php echo $editLanguageObj->getCSSFormLabelCellClass('language');?>">
	              		<label for="selLanguage"><?php echo $LANG['langedit_language'];?></label>
	            	</td>
            		<td class="<?php echo $editLanguageObj->getCSSFormFieldCellClass('language');?>"><?php echo $editLanguageObj->getFormFieldErrorTip('language');?>
              			<select name="language" id="selLanguage" tabindex="1000">
		              		<?php
							foreach($editLanguageObj->populateLanguageDetails() as $key=>$value)
								{
							?>
		                    <option value="<?php echo $key;?>" <?php if($key == $editLanguageObj->getFormField('language')) {?> selected="selected"<?php }?>><?php echo $value;?></option>
		                	<?php
								}
							?>
		              	</select>
              			<?php ShowHelpTip('export_language', 'selLanguage');?>
            		</td>
          		</tr>
          		<tr>
            		<td class="clsWidthSmall <?php echo $editLanguageObj->getCSSFormLabelCellClass('directory');?>">
              			<label for="selDirectory"><?php echo $LANG['langedit_directory'];?></label>
            		</td>
            		<td class="<?php echo $editLanguageObj->getCSSFormFieldCellClass('directory');?>"><?php echo $editLanguageObj->getFormFieldErrorTip('directory');?>
              			<select name="directory" id="selDirectory" tabindex="1005">
                			<?php $editLanguageObj->populateList($lang_folders_arr, $editLanguageObj->getFormField('directory'));?>
              			</select>
               			<?php ShowHelpTip('choose_directory', 'selDirectory');?>
            		</td>
          		</tr>
          		<tr>
            		<td colspan="2" class="<?php echo $editLanguageObj->getCSSFormFieldCellClass('submit');?>">
              			<input type="submit" class="clsSubmitButton" name="submit_directory" id="submit_directory" value="<?php echo $LANG['langedit_submit'];?>" tabindex="1010" />
			  			<input type="submit" class="clsCancelButton" name="submit_cancel" id="submit_cancel" value="<?php echo $LANG['langedit_cancel'];?>" tabindex="1011" />
            		</td>
          		</tr>
        	</table>
      	</form>
	</div>
<?php
	}
if ($editLanguageObj->isShowPageBlock('block_form_files_list'))
	{
?>
	<div id="selFilesList">
      	<form name="block_form_files_list" id="block_form_files_list" method="post" action="editLanguageFile.php">
        	<table class="clsFormSection clsNoBorder">
	          	<tr>
		            <td class="<?php echo $editLanguageObj->getCSSFormLabelCellClass('language');?>">
		              	<label for="selLanguage"><?php echo $LANG['langedit_language'];?></label>
		            </td>
		            <td class="<?php echo $editLanguageObj->getCSSFormFieldCellClass('language');?>"><?php echo $CFG['lang']['available_languages'][$editLanguageObj->getFormField('language')];?></td>
	          	</tr>
	          	<tr>
	            	<td class="clsWidthSmall <?php echo $editLanguageObj->getCSSFormLabelCellClass('directory');?>">
	              		<label for="selDirectory"><?php echo $LANG['langedit_directory'];?></label>
	            	</td>
	            	<td class="<?php echo $editLanguageObj->getCSSFormFieldCellClass('directory');?>"><?php echo $lang_folders_arr[$editLanguageObj->getFormField('directory')];?></td>
	          	</tr>
	          	<tr>
	            	<td class="<?php echo $editLanguageObj->getCSSFormLabelCellClass('file');?>">
	              		<label for="selFile"><?php echo $LANG['langedit_file'];?></label>
	            	</td>
	            	<td class="<?php echo $editLanguageObj->getCSSFormFieldCellClass('file');?>"><?php echo $editLanguageObj->getFormFieldErrorTip('file');?>
	              		<select name="file" id="selFile" tabindex="1000">
	                		<?php $editLanguageObj->populateFileNamesList($editLanguageObj->getFormField('file'), $unwanted_files_list_arr);?>
	              		</select>
	                	<?php ShowHelpTip('choose_file', 'selFile');?>
	            	</td>
	          	</tr>
	          	<tr>
	            	<td colspan="2" class="<?php echo $editLanguageObj->getCSSFormFieldCellClass('submit');?>">
	              		<?php $editLanguageObj->populateHiddenFormFields(array('language', 'directory'));?>
	              		<input type="submit" class="clsSubmitButton" name="submit_files" id="selSubmitFiles" value="<?php echo $LANG['langedit_submit'];?>" tabindex="1005" />
				  		<input type="submit" class="clsSubmitButton" name="submit_back_files" id="submit_back_files" value="<?php echo $LANG['langedit_back'];?>" tabindex="1006" />
	            	</td>
	          	</tr>
        	</table>
      	</form>
    </div>
<?php
	}
if ($editLanguageObj->isShowPageBlock('block_form_edit_phrases'))
	{
?>
	<div id="selEditForm">
    	<h3><a href="editLanguageFile.php"><?php echo $CFG['lang']['available_languages'][$editLanguageObj->getFormField('language')]; ?></a> / <a href="<?php echo 'editLanguageFile.php?language='.$editLanguageObj->getFormField('language').'&amp;directory='.$editLanguageObj->getFormField('directory').'&amp;file='.$editLanguageObj->getFormField('file'); ?>"><?php echo $lang_folders_arr[$editLanguageObj->getFormField('directory')]; ?></a> <?php echo '/'.$editLanguageObj->getFormField('file'); ?></h3>
      	<form name="editFrm" id="editFrm" method="post" action="editLanguageFile.php">
        	<table class="clsFormSection clsNoBorder">
	          	<tr>
	            	<th class="clsFormLabelCellDefault clsFormTableTitle"><?php echo $LANG['langedit_variable_name'];?></th>
	            	<th class="clsFormFieldCellDefault clsFormTableTitle"><?php echo $LANG['langedit_new_value'];?></th>
	          	</tr>
          		<?php	$lang_update = $LANG['langedit_update'];
				unset($LANG);
				unset($LANG_LIST_ARR);
				// include the file
				require($directory_path_arr[$editLanguageObj->getFormField('directory')].$editLanguageObj->getFormField('language').'/'.$editLanguageObj->getFormField('directory').'/'.$editLanguageObj->getFormField('file'));
				// populate phrases
				$temp_lang = $editLanguageObj->getFormField('directory')=='lists_array'?$editLanguageObj->getCollabseKeyValuePair($LANG_LIST_ARR):$LANG;
				foreach($temp_lang as $key => $value)
					{
						$tdk = explode('__', $key);
						unset($tdk[0]);
						$tdk = implode('->', $tdk);
						$tdk = trim($tdk)==''?'default':$tdk;
?>
          		<tr>
	            	<td class="clsWidthSmall <?php echo $editLanguageObj->getCSSFormLabelCellClass('varable');?>">
	              		<label for="<?php echo $key;?>"><?php echo $tdk; ?></label>
	            	</td>
	            	<td class="<?php echo $editLanguageObj->getCSSFormFieldCellClass('phrase');?>">
	              		<textarea name="<?php echo $key; ?>" id="<?php echo $key;?>" tabindex="1000" rows="3" cols="50"><?php echo $editLanguageObj->stripslashesNew($value); ?></textarea>
	            	</td>
	          	</tr>
<?php
					}
?>
          		<tr>
            		<td colspan="2" class="<?php echo $editLanguageObj->getCSSFormFieldCellClass('submit');?>">
              			<?php $editLanguageObj->populateHiddenFormFields(array('language', 'directory', 'file'));?>
              			<input type="submit" class="clsSubmitButton" name="submit_phrases" id="selSubmitPhrases" value="<?php echo $lang_update;?>" tabindex="1005" />
			  			<input type="submit" class="clsSubmitButton" name="submit_back_phrases" id="submit_back_phrases" value="<?php echo $editLanguageObj->LANG['langedit_back'];?>" tabindex="1006" />
            		</td>
          		</tr>
        	</table>
    	</form>
    </div>
<?php
	}

if ($editLanguageObj->isShowPageBlock('block_page_list_phrases'))
	{
?>
	<div id="selPhrasesList">
      	<h3><?php echo $CFG['lang']['available_languages'][$editLanguageObj->getFormField('language')].'/'.$lang_folders_arr[$editLanguageObj->getFormField('directory')].'/'.$editLanguageObj->getFormField('file'); ?></h3>
      	<table class="clsFormSection clsNoBorder">
        	<tr>
          		<th class="clsWidthSmall clsFormLabelCellDefault"><?php echo $LANG['langedit_variable_name'];?></th>
          		<th class="clsFormFieldCellDefault"><?php echo $LANG['langedit_new_value'];?></th>
        	</tr>
        	<?php
			unset($LANG);
			unset($LANG_LIST_ARR);
			// include the file
			require($directory_path_arr[$editLanguageObj->getFormField('directory')].$editLanguageObj->getFormField('language').'/'.$editLanguageObj->getFormField('directory').'/'.$editLanguageObj->getFormField('file'));
			// populate phrases
			$temp_lang = $editLanguageObj->getFormField('directory')=='lists_array'?$editLanguageObj->getCollabseKeyValuePair($LANG_LIST_ARR):$LANG;
			foreach($temp_lang as $key => $value)
				{
					$tdk = explode('__', $key);
					unset($tdk[0]);
					$tdk = implode('->', $tdk);
					$tdk = trim($tdk)==''?'default':$tdk;
?>
        	<tr>
          		<td class="clsWidthSmall"><?php echo $tdk; ?></td>
          		<td><?php echo $editLanguageObj->stripslashesNew($value); ?></td>
        	</tr>
<?php
				}
?>
      	</table>
    </div>
<?php
	}
?>
  	</div>
</div>
<?php
//<<<<<<--------------------Page block templates Ends--------------------//
$editLanguageObj->includeFooter();
?>