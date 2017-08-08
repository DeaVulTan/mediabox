<?php
/**
 * To edit the config_profile file
 *
 * TO show the config_profile variables from the file and edit
 *
 * PHP version 5.0
 *
 * @category	###Anove###
 * @package		###Edit Config Index###
 * @author 		senthil_52ag05
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id:
 * @since 		2007-12-22
 */
/**
 * Including the config file
 */
require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/'.$CFG['admin']['index']['home_module'].'/admin/editConfigIndex.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Parser.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['site']['is_module_page']='discussions';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class ConfigProfileEditFormHandler begins -------------------->>>>>//
class ConfigProfileEditFormHandler extends FormHandler
	{

		/**
		 * Setting boolean option array
		 *
		 * @param		array $boolean_option_array boolean option array
		 * @return 		void
		 * @access		public
		*/
		public function setBooleanOption($boolean_option_array)
			{
				$this->boolean_option_array = $boolean_option_array;
			}

		/**
		 * Populating the boolean option array
		 *
		 * @param		int|boolean $option_to_highlight option to highlight
		 * @return 		void
		 * @access		public
		*/
		public function populateBooleanOption($option_to_highlight)
			{
				if ($option_to_highlight == 'true')
						$option_to_highlight = 1;
					else if ($option_to_highlight == 'false')
						$option_to_highlight = 0;
				foreach($this->boolean_option_array as $key => $value)
					{
?>
	<option value="<?php echo $key;?>" <?php echo ($option_to_highlight == $key) ? 'selected="selected"' : '';?>><?php echo $value;?></option>
<?php
					}
			}

		/**
		 * Getting the file content in a string
		 *
		 * @param		string $file_path file path to get
		 * @return 		void
		 * @access		public
		*/
		public function getFileContent($file_path)
			{
				$this->fields_arr['file_content'] = file_get_contents($file_path);
			}

		/**
		 * setting the filter option array
		 *
		 * @param		array $filter_option_array filter option array
		 * @return 		void
		 * @access		public
		*/
		public function setFilterOptionArray($filter_option_array, $first_option_array)
			{
				$this->filter_option_array = $first_option_array + $filter_option_array;
			}

		/**
		 * populating the config section filter options
		 *
		 * @param		string $option_to_highlight option value to highlight
		 * @return 		void
		 * @access		public
		*/
		public function populateConfigFilterOption($option_to_highlight)
			{
				foreach($this->filter_option_array as $key => $value)
					{
?>
	<option value="<?php echo $key;?>" <?php echo ($option_to_highlight == $key) ? 'selected="selected"' : '';?>><?php echo $value;?></option>
<?php
					}

			}

		/**
		 * render a td with label
		 *
		 * @param		string $label_for form field for which this label is associted
		 * @param		string $label label to be displayed
		 * @return 		void
		 * @access		public
		*/
		public function renderLabelTableCell($label_for, $label)
			{
?>
<label for="<?php echo $label_for; ?>"><?php echo $label;?></label>
<?php
			}

		/**
		 * render a text form field
		 *
		 * @param		string $input_type text/password
		 * @param		string $name text field name used for id also
		 * @param		string $value value of the field
		 * @param		string $tab_index
		 * @return 		void
		 * @access		public
		*/
		public function renderTextField($input_type, $name, $value, $tab_index)
			{
?>
<input type="<?php echo $input_type?>" name="<?php echo $name?>" id="<?php echo $name?>" value="<?php echo $value?>" tabindex="<?php echo $tab_index?>" />
<?php
			}

		/**
		 * render a text area
		 *
		 * @param		string $name text area name used for id also
		 * @param		string $rows no of rows
		 * @param		string $cols no of cols
		 * @param		string $content content of the textarea
		 * @param		string $tab_index
		 * @return 		void
		 * @access		public
		*/
		public function renderTextArea($name, $rows, $cols, $tab_index, $content)
			{
?>
<textarea name="<?php echo $name?>" id="<?php echo $name?>" rows="<?php echo $rows?>" cols="<?php echo $cols?>" tabindex="<?php echo $tab_index?>"><?php echo $content; ?></textarea>
<?php
			}

		/**
		 * render a check box
		 *
		 * @param		string $name name used for id also
		 * @param		string $tab_index
		 * @param		string $highlight item to be checked when loading
		 * @return 		void
		 * @access		public
		*/
		public function renderCheckBox($name, $tab_index, $highlight_item)
			{
				$checked = ($highlight_item == '1' or $highlight_item == 'true') ? 'checked' : '';
?>
<input type="checkbox" class="clsCheckRadio" name="<?php echo $name?>" id="<?php echo $name?>" tabindex="<?php echo $tab_index?>" <?php echo $checked;?> />
<?php
			}

		/**
		 * ConfigProfileEditFormHandler::isCheckedRadio()
		 *
		 * @param $value
		 * @return
		 **/
		public function isCheckedRadio($current_field_value, $current_value)
			{
				//$current_value = ($current_value=='true')?1:($current_value=='false')?0:$current_value;
				$checked = ($current_value == $current_field_value)? ' checked':'';
				return $checked;
			}

		/**
		 * PlayerSettings::populateArray()
		 *
		 * @param $list
		 * @param string $highlight_value
		 * @return
		 **/
		public function populateArray($list, $highlight_value='')
			{
				foreach($list as $key=>$value)
					{
						$selected = $highlight_value == $key?' selected':'';
?>
						<option value="<?php echo $key;?>"<?php echo $selected;?>><?php echo $value;?></option>
<?php
					}
			}

		/**
		 * PlayerSettings::populateSettings()
		 *
		 * @return
		 **/
		public function populateSettings()
			{
				$sql = 'SELECT variable_name, value FROM '.$this->CFG['db']['tbl']['player_settings'];
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				        trigger_db_error($this->dbObj);
				while($row = $rs->FetchRow())
				    {
					 	$this->fields_arr[$row['variable_name']] = $row['value'];
				    }
			}
	}
//<<<<<--------------------- Class ConfigProfileEditFormHandler ends ------------------------//
//------------------ Code begins------------------>>>//
$editfilefrm = new ConfigProfileEditFormHandler();
$editfilefrm->left_navigation_div = 'discussionsSetting';
$CFG['config_file_path'] = '../../common/configs/discussion_configs/config_index.inc.php';
$editfilefrm->setBooleanOption(array(1 => 'Yes', 0 => 'No'));
$adult_content_view_arr = array('Yes'=>$LANG['allow_all'], 'No'=>$LANG['only_adult_user'], 'Confirmation'=>$LANG['confirmation_to_display']);
$editfilefrm->setPageBlockNames(array('show_config_variable'));
$editfilefrm->setDisplayVar('file_content', '');
$editfilefrm->setDisplayVar('variable_start_string', '$LANG');
$editfilefrm->setDisplayVar('config_section_to_show', '');
//Getting the file content in the form field using
//the config path declared in config file itself
$editfilefrm->setFormField('LogoUrl', '');
$editfilefrm->setFormField('TopUrlUrl', '');
$editfilefrm->getFileContent($CFG['config_file_path']);
$editfilefrm->setAllPageBlocksHide();
$editfilefrm->setAllPageBlocksHide();
if ($editfilefrm->isFormPOSTed($_POST, 'selected_configuration_submit'))
	{
		$editfilefrm->sanitizeFormInputs($_POST);
		if ($editfilefrm->getFormField('config_section_to_show') != 'all')
			{
				$temp_array = array();
				$temp_array = array($editfilefrm->getFormField('config_section_to_show') => $config_types[$editfilefrm->getFormField('config_section_to_show')]);
				$config_types = array();
				$config_types = $temp_array;
		    }
	}
if ($editfilefrm->isFormPOSTed($_POST, 'edit_submit'))
	{
		$obj = new Parser();
		$content = '';
		$new_content = '';
		//Getting file content
		$content = $editfilefrm->getDisplayVar('file_content');
		//Initializing start and end position of the comment
		$start_of_comment = $end_of_comment = 0;
		//Assigning the $content to $remaining for the file those does not have doc block
		$remaining = $content;
		$is_repeat = true;
		while($is_repeat)
			{
				//Finding the starting position of doc block
				$start_of_comment = strpos($content, "/**", 0);
				//Finding the ending position of doc block
				$end_of_comment = strpos($content, "*/", 0);
				if ($start_of_comment !== false and
						$end_of_comment !== false)
					{
						//Initializing the variables
						$var_name = '';
						$var_value = '';
						$remaining = '';
						$doc_block = '';
						$content_before_doc_block = '';
						//File content before the starting of the comment
						$content_before_doc_block = ($start_of_comment !== false and $end_of_comment !== false) ? substr($content, 0, strpos($content, "/**", 0)) : '';
						//Getting the doc block in to a string without /** and */
						$doc_block = trim(substr($content, $start_of_comment+3, ($end_of_comment-$start_of_comment)-2));
						//Get doc block with /** and */
						$doc_block_with_comment = trim(substr($content, $start_of_comment, ($end_of_comment-$start_of_comment)+2));
						//Extracting the doc block into $doc
						$doc = $obj->extractPhpdoc($doc_block);
						//Fetching the doc block tags in to an array
						$tags = $obj->getTags($doc);
						//check if the new value is different from the older value
						if (isset($tags['@cfg_key']) and
								//isset($_POST[$tags['@cfg_key']]) and -- commented this for changing the selection box to check box for boolean values
									isset($tags['@var']))
							{
								//Finding the starting position of equeal symbol
								$start_of_eq = strpos($content, "=", $end_of_comment);
								//Finding the ending position of ;
								$variable_line_end_pos = strpos($content, ';', $end_of_comment);
								//Getting the remaining file content except found doc block
								$remaining = trim(substr($content, $variable_line_end_pos+1));
								//New content initial values
								//$new_content = substr($content, 0, $start_of_comment);
								//Extracting the config variable name from the remaining content
								$var_name = trim(substr($content, strpos($content, '$CFG', $end_of_comment), (strpos($content, '=', $end_of_comment) - strpos($content, '$CFG', $end_of_comment))));
								//Extracting the config variable value
								$var_value = trim(substr($content, strpos($content, '=', $end_of_comment)+1, (strpos($content, ';', $end_of_comment) - strpos($content, '=', $end_of_comment))-1 ));
								//Removing \n \t \r from the posted values
								//$_POST[$tags['@cfg_key']] = trim($_POST[$tags['@cfg_key']]);
								$variable_data_type = '';
								//Extracting the variable datatype
								$variable_data_type = substr($tags['@var'], 0, strpos($tags['@var'], ' '));
								//echo $tags['@cfg_key'];exit;
								switch ($variable_data_type)
									{
										case 'array':
											$no_of_tabs = 0;
											//Added necessary tab
											$no_of_tabs = (strlen($var_name) / 5) + 6;
											$tab_string = "\n" . str_repeat("\t", $no_of_tabs);
											$comma_sep_arr_string = explode(',', trim($_POST[$tags['@cfg_key']]));
											$arr_new_value = 'array(';
											if ($tags['@cfg_arr_type'] == 'key')
												{
													//revove of array string in the value
													$remove_arr_string = stristr($var_value, '(');
													$original_value_str = substr($remove_arr_string, 1, strlen($remove_arr_string) -2);
													$original_value_arr = explode(',', $original_value_str);

													//Removing the tab,new line from the array element
													$comma_sep_arr_string = explode(',', trim($_POST[$tags['@cfg_key']]));
													//Adding the quote for string type of array element
													$add_key_quote = ($tags['@cfg_arr_key'] == 'string') ? '\'' : '';
													foreach($comma_sep_arr_string as $index => $arr_element)
														{
															if ($arr_element)
																{
																	//checking key is string or int
																	if ($tags['@cfg_arr_key'] == 'string')
																		{
																			$arr_new_value .= '\'' . trim($arr_element) . '\'' . ', ';
																		}
																	else if ($tags['@cfg_arr_key'] == 'int')
																		{
																			//check is valid integer otherwise store old value
																			if (ctype_digit(trim($arr_element)))
																				{
																					$arr_new_value .=  trim($arr_element)  . ', ';
																				}
																			else if (isset($original_value_arr[$index]))
																				{
																					$arr_new_value .=  trim($original_value_arr[$index])  . ', ';
																				}
																		}
																}
														}
												}
											else if ($tags['@cfg_arr_type'] == 'associative')
												{
													$add_key_quote = ($tags['@cfg_arr_key'] == 'string') ? '\'' : '';
													$add_value_quote = ($tags['@cfg_arr_value'] == 'string') ? '\'' : '';
													foreach($comma_sep_arr_string as $arr_element)
														{
															if ($arr_element)
																{
																	$arr_new_value .=  $add_key_quote .
																		trim(substr($arr_element, 0, strrpos($arr_element, '='))) .
																		$add_key_quote . ' => ' . $add_value_quote .
																		trim(substr($arr_element, strpos($arr_element, '=')+1)) .
																		$add_value_quote . ',' . $tab_string;
																}
														}
												}
											$arr_new_value = substr($arr_new_value, 0, strrpos($arr_new_value, ','));
											$arr_new_value .= ')';
											$var_value = ' = ' . $arr_new_value .';';
											break;
										case 'boolean':
											$bool_value = (isset($_POST[$tags['@cfg_key']]) and $_POST[$tags['@cfg_key']]=='true') ? 'true;' : 'false;';
											$var_value =  ' = ' . $bool_value;
											break;
										case 'string':
											$var_value = ' = \'' . trim($_POST[$tags['@cfg_key']]) . '\';';
											break;
										case 'int':
											//checking post value is integer otherwise place the old value
											if (ctype_digit(trim($_POST[$tags['@cfg_key']])))
												{
													$var_value = ' = ' . trim($_POST[$tags['@cfg_key']]) . ';';
												}
											else
												{
													$var_value = ' = ' .$var_value.';';
												}
											break;
									}
								$new_content .= $content_before_doc_block .
												$doc_block_with_comment . "\n" .
												$var_name .
												$var_value . "\n";
								$content = $remaining;
							}
							else
								{
									$remaining = trim(substr($content, $end_of_comment+2));
									$new_content .= $content_before_doc_block .
													$doc_block_with_comment . "\n";
									$content = $remaining;
								}
					}
					else
						{
							$new_content .= $remaining;
							$is_repeat = false;
							//Writing the file with new submitted values
							$fw = fopen($CFG['config_file_path'], 'w');
							fwrite($fw, $new_content);
							fclose($fw);
							$editfilefrm->setAllPageBlocksHide();
							$editfilefrm->setCommonSuccessMsg($editfilefrm->LANG['config_homepage_succ_msg']);
							$editfilefrm->setPageBlockShow('block_msg_form_success');
						}
			}
	}
$editfilefrm->setPageBlockShow('show_config_variable');
//<<<<<---------------------Code ends------------------//
//-----------------Page block template begins----------->>>>>//
//include the header file
$editfilefrm->includeHeader();
?>
<div id="selGeneralConfiguration">
	<h2 class="clsIndexTitle"><?php echo $LANG['page_title'];?></h2>
<?php
if ($editfilefrm->isShowPageBlock('block_msg_form_success'))
	{
?>
<div id="selMsgSuccess">
	<p><?php echo $editfilefrm->getCommonSuccessMsg();?></p>
</div>
<?php
    }
if ($editfilefrm->isShowPageBlock('show_config_variable'))
	{
		$parser_obj = new Parser();
		$config_content = '';
		$ret_array = array();
		$config_content  = file_get_contents($CFG['config_file_path']);
		$ret_array = $parser_obj->getPhpdocParagraphs($config_content);
?>
<form name="form_config" id="form_config" method="post" action="<?php echo $CFG['site']['url'];?>admin/<?php echo $CFG['admin']['index']['home_module'];?>/editConfigIndex.php" >
<?php
	$tab_index = 1000;
	$prev_sec_name = '';
	foreach($ret_array as $config_type => $value)
		{
			$prev_sec_name = $ret_array[$config_type][0]['tags']['@cfg_sec_name'];
			//$prev_sec_name = (isset($ret_array[$config_type][0]['tags']['@cfg_section'])) ? $ret_array[$config_type][0]['tags']['@cfg_section'] : $prev_sec_name;
?>
	<div id="selConfigSection">
	<?php
	if($prev_sec_name)
	{
	?>
		<h3><?php echo $prev_sec_name;?></h3>
	<?php
	}
	?>
		<table class="clsCommonTable" summary="<?php echo $LANG['tbl_summary'];?>">
<?php
			foreach($ret_array[$config_type] as $key => $value)
				{
?>
<?php
					$input_type = '';
					$result = (isset($value['tags']['@cfg_coding'])) ? $value['tags']['@cfg_coding'] : '';
					print $result;
					$input_type = (isset($value['tags']['@cfg_is_password'])) ? 'password' : 'text';
					$variable_data_type = '';
					$variable_data_type = substr($value['tags']['@var'], 0, strpos($value['tags']['@var'], ' '));
					if (isset($value['tags']['@cfg_sub_head']))
						{
?>
					<tr>
						<th colspan="2"><?php echo $value['tags']['@cfg_sub_head']?></th>
					</tr>
<?php
						}
					switch ($variable_data_type)
						{
							case 'string':
								$value['value'] = str_replace('\'', '', $value['value']);
?>
		<tr>
			<td class="clsFormLabelCellDefault"><?php $editfilefrm->renderLabelTableCell($value['tags']['@cfg_key'], $value['tags']['@cfg_label']); ?></td>
			<td class="clsFormFieldCellDefault">
				<select name="<?php echo $value['tags']['@cfg_key'];?>" id="<?php echo $value['tags']['@cfg_key'];?>" tabindex="<?php echo $tab_index;?>">
					<?php $editfilefrm->populateArray(array('yes'=>'Yes', 'no'=>'No', 'compulsory'=>'Compulsory'), $value['value']);?>
				</select>
			</td>
		</tr>
<?php
								break;
							case 'int' :
								$value['value'] = str_replace('\'', '', $value['value']);
?>
		<tr>
			<td class="clsFormLabelCellDefault"><?php $editfilefrm->renderLabelTableCell($value['tags']['@cfg_key'], $value['tags']['@cfg_label']); ?></td>
			<td class="clsFormFieldCellDefault"><?php $editfilefrm->renderTextField('text', $value['tags']['@cfg_key'], $value['value'], $tab_index)?><?php eval($result);?></td>
		</tr>
<?php
								break;
							case 'array' :
								if ($value['tags']['@cfg_arr_type'])
									{
										$arr_value = '';
										//Finding the starting position of (
										$start_post = strpos($value['value'], '(')+1;
										//Finding the ending position of )
										$end_post = strpos($value['value'], ')') - $start_post;
										//Extracting the array elements
										$arr_value = substr($value['value'], $start_post, $end_post);
										//Removing the tab and new line and emtpy characters
										$arr_value = preg_replace("/[\t\r\n\' ]/", "", $arr_value);
										//Adding new line character
										$arr_value = str_replace(',', ",\n", $arr_value);
										//Replacing => by =
										$arr_value = str_replace('=>', "=", $arr_value);
										//Finding the number of rows for textarea
										$no_of_row = substr_count($arr_value, ',') + 1;
?>
		<tr>
			<td class="clsFormLabelCellDefault"><?php $editfilefrm->renderLabelTableCell($value['tags']['@cfg_key'], $value['tags']['@cfg_label']); ?></td>
			<td class="clsFormFieldCellDefault"><?php $editfilefrm->renderTextArea($value['tags']['@cfg_key'], $no_of_row, '15', $tab_index, $arr_value); ?><?php eval($result);?></td>
		</tr>
<?php
									}
								break;
							case 'boolean':
								switch($value['tags']['@cfg_key'])
									{
										case 'AutoPlay':
?>
		<tr>
			<td class="clsFormLabelCellDefault"><?php $editfilefrm->renderLabelTableCell($value['tags']['@cfg_key'], $value['tags']['@cfg_label']); ?></td>
			<td class="clsFormFieldCellDefault">
				<input  name="AutoPlay" id="AutoPlay1" tabindex="<?php echo $tab_index;?>" type="radio" class="clsCheckRadio" value="true" <?php echo $editfilefrm->isCheckedRadio('true', $value['value']);?> />
				<label for="AutoPlay1"><?php echo $LANG['auto_on'];?></label>
				<input  name="AutoPlay" id="AutoPlay2" tabindex="<?php echo $tab_index;?>" type="radio" class="clsCheckRadio" value="false" <?php echo $editfilefrm->isCheckedRadio('false', $value['value']);?> />
				<label for="AutoPlay2"><?php echo $LANG['auto_off'];?></label>
			</td>
		</tr>
<?php
											break;

										default:
?>
		<tr>
			<td class="clsFormLabelCellDefault"><?php $editfilefrm->renderLabelTableCell($value['tags']['@cfg_key'], $value['tags']['@cfg_label']); ?></td>
			<td class="">
				<input  name="<?php echo $value['tags']['@cfg_key'];?>" id="<?php echo $value['tags']['@cfg_key'];?>1" tabindex="<?php echo $tab_index;?>" type="radio" class="clsCheckRadio" value="true" <?php echo $editfilefrm->isCheckedRadio('true', $value['value']);?> />
				<label for="<?php echo $value['tags']['@cfg_key'];?>1"><?php echo $LANG['on'];?></label>
				<input  name="<?php echo $value['tags']['@cfg_key'];?>" id="<?php echo $value['tags']['@cfg_key'];?>2" tabindex="<?php echo $tab_index;?>" type="radio" class="clsCheckRadio" value="false" <?php echo $editfilefrm->isCheckedRadio('false', $value['value']);?> />
				<label for="<?php echo $value['tags']['@cfg_key'];?>2"><?php echo $LANG['off'];?></label>
			</td>
		</tr>
<?php
											break;
									} // switch

					    		break;
						}
					$tab_index += 5;
				}
?>
		<tr>
			<td></td>
			<td><input type="submit" class="clsSubmitButton" name="edit_submit" id="edit_submit" value="<?php echo $LANG['discuzz_common_update'];?>" tabindex="<?php echo $tab_index;?>" />&nbsp;
				<input type="reset" class="clsCancelButton" name="reset" id="reset" value="<?php echo $LANG['general_config_reset_submit'];?>" tabindex="<?php echo $tab_index;?>" />
            </td>
		</tr>
	</table>
</div>
<?php
		}
?>

		</form>
<?php
    }
?>
</div>
<?php
//<<<<<<--------------------Page block templates Ends--------------------//
$editfilefrm->includeFooter();
?>