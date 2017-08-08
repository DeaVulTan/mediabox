<?php
/**
 * To edit the config file
 *
 * TO show the config variables from the file and edit
 *
 * PHP version 5.0
 *
 * @category	###Discuzz###
 * @package		###Edit Config###
 * @author 		selvaraj_47ag04
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id:
 * @since 		2008-12-22
 */
/**
 * Including the config file
 */
require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/editConfig.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Parser.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
if(isset($_REQUEST['module']) && !empty($_REQUEST['module'])){
	$CFG['site']['is_module_page'] = strtolower($_REQUEST['module']);
}else{
	$CFG['site']['is_module_page'] = '';
}

require($CFG['site']['project_path'].'common/application_top.inc.php');

if(isset($_REQUEST['module']) && !empty($_REQUEST['module'])){
	if(!chkAllowedModule(array($_REQUEST['module'])))
		Redirect2URL($CFG['site']['url'].'admin/index.php');
	}
//---------------------------- Class ConfigEdit begins -------------------->>>>>//
/**
 * Class to handle the edit config interface elements
 */
class ConfigEdit extends FormHandler
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
		 * render a td with label
		 *
		 * @param		string $label_for form field for which this label is associted
		 * @param		string $label label to be displayed
		 * @return 		void
		 * @access		public
		*/
		public function renderLabelTableCell($label_for, $label, $is_bool=false)
			{
				$qmark = '';
				if($is_bool)
					$qmark = '?';
?>
<label for="<?php echo $label_for; ?>"><?php echo $label.$qmark;?></label>
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
<input type="<?php echo $input_type?>" class="cls<?php echo $input_type?>" name="<?php echo $name?>" id="<?php echo $name?>" value="<?php echo $value?>" tabindex="<?php echo $tab_index?>" />
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
<input type="checkbox" class="clsCheckBox" name="<?php echo $name?>" id="<?php echo $name?>" tabindex="<?php echo $tab_index?>" <?php echo $checked;?> />
<?php
			}

		public function changeHeading()
     		{
                    echo '<h2>'.ucwords(str_ireplace('VAR_HEADING', $this->LANG['config_title'], $this->LANG['genearal_config_title'])).'</h2>';
	               if($this->LANG['genearal_config_title'] != $this->LANG['general_error_msg_file_not_found'])
                         echo '<p class="clsSettingInfo">'.$this->LANG['general_config_hint'].'</p>';
               }
	}
//<<<<<--------------------- Class ConfigEdit ends ------------------------//
//------------------ Code begins------------------>>>//
$editfilefrm = new ConfigEdit();
$editfilefrm->setBooleanOption(array(1 => 'Yes', 0 => 'No'));
$editfilefrm->setPageBlockNames(array('show_config_variable'));

$editfilefrm->setDisplayVar('file_content', '');
$editfilefrm->setDisplayVar('variable_start_string', '$LANG');
$editfilefrm->setDisplayVar('config_section_to_show', '');
$editfilefrm->setFormfield('folder', '');
$editfilefrm->setFormfield('config_file_name', 'config');
$config_success_title = 'config';

//Getting the file content in the form field using
$editfilefrm->sanitizeFormInputs(array_merge($_GET, $_POST));
//the config path declared in config file itself
if ($editfilefrm->isFormPOSTed($_POST, 'cancel_submit'))
	{
		Redirect2Url('index.php');
	}
if($editfilefrm->getFormField('config_file_name')!='config')
	{
		if($editfilefrm->getFormField('folder')=='discussion_configs')
			{
				$CFG['config_path'] = '../../common/configs/discussion_configs/'.$editfilefrm->getFormField('config_file_name').'.inc.php';
			}
		else
			{
				$CFG['config_path'] = '../../common/configs/'.$editfilefrm->getFormField('config_file_name').'.inc.php';
			}

		$config_title = explode('config_', $editfilefrm->getFormField('config_file_name'));
		$config_success_title = $editfilefrm->getFormField('config_file_name');
		$editfilefrm->LANG['config_title'] = $config_title[1];
		if ($config_title[1] == 'solutions')
			{
				$editfilefrm->LANG['config_title'] = $LANG['boards_and_solutions'];
			}
        if(!is_file($CFG['config_path']))
			{
				$editfilefrm->setCommonErrorMsg($editfilefrm->LANG['general_error_msg_file_not_found']);
				$editfilefrm->setPageBlockShow('block_msg_form_error');
				$editfilefrm->LANG['genearal_config_title'] = $LANG['general_error_msg_file_not_found'];
				$CFG['feature']['auto_hide_success_block'] = false;
			}

	}
if($editfilefrm->isValidFormInputs())
	{
		$editfilefrm->getFileContent($CFG['config_path']);
		$editfilefrm->setAllPageBlocksHide();
		$editfilefrm->setAllPageBlocksHide();
		if ($editfilefrm->isFormPOSTed($_POST, 'selected_configuration_submit'))
			{
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
																			if (!in_array(addslashes(trim($arr_element)), array('php', 'js')))
																					$arr_new_value .= $add_key_quote . addslashes(trim($arr_element)) . $add_key_quote . ', ';
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
													$arr_new_value = (trim($arr_new_value)==')')?'array()':$arr_new_value;
													$var_value = ' = ' . $arr_new_value .';';
													break;
												case 'boolean':
													$bool_value = (isset($_POST[$tags['@cfg_key']])) ? 'true;' : 'false;';
													$var_value =  ' = ' . $bool_value;
													break;
												case 'string':
													$var_value = ' = \'' . trim(addslashes($_POST[$tags['@cfg_key']])) . '\';';
													break;
												case 'int':
													//checking post value is integer otherwise place the old value
													if (is_numeric(trim($_POST[$tags['@cfg_key']])))
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
									$fw = fopen($CFG['config_path'], 'w');
									fwrite($fw, $new_content);
									fclose($fw);
									$editfilefrm->setAllPageBlocksHide();
									$editfilefrm->setCommonSuccessMsg($editfilefrm->LANG[$config_success_title]);
									$editfilefrm->setPageBlockShow('block_msg_form_success');
								}
					}
			}
		$editfilefrm->setPageBlockShow('show_config_variable');
	}
//<<<<<---------------------Code ends------------------//
//-----------------Page block template begins----------->>>>>//

if(isset($_REQUEST['div']) && !empty($_REQUEST['div'])){
	$editfilefrm->left_navigation_div = $_REQUEST['div'];
}else{
	$editfilefrm->left_navigation_div = 'discussionsSetting';
}

//include the header file
$editfilefrm->includeHeader();
?>
<div id="selGeneralConfiguration">
<?php
    $editfilefrm->changeHeading();

if ($editfilefrm->isShowPageBlock('block_msg_form_error'))
	{
?>
<div id="selMsgSuccess">
	<p><?php echo $editfilefrm->getCommonErrorMsg();?></p>
</div>
<?php
    }
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
		$config_content  = file_get_contents($CFG['config_path']);
		$ret_array = $parser_obj->getPhpdocParagraphs($config_content);
?>
<form name="form_config" id="form_config" method="post" action="<?php echo $editfilefrm->getCurrentUrl(true);?>">
		<table class="">
<?php
	$tab_index = 1000;
	$prev_sec_name = '';
	foreach($ret_array as $config_type => $value)
		{
			$prev_sec_name = $ret_array[$config_type][0]['tags']['@cfg_sec_name'];
			//$prev_sec_name = (isset($ret_array[$config_type][0]['tags']['@cfg_section'])) ? $ret_array[$config_type][0]['tags']['@cfg_section'] : $prev_sec_name;
?>

	<?php if($prev_sec_name)
			{
	?>
		<h3><?php echo $prev_sec_name;?></h3>
		<?php
		}
		?>
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
					<tr class="clsFormRow">
						<th colspan="2"><?php echo $value['tags']['@cfg_sub_head']?></th>
					</tr>
<?php
						}
					switch ($variable_data_type)
						{
							case 'string':
								//Added by selva to fix the special char issues
								$value['value'] = stripslashes(substr($value['value'], 1, strlen($value['value'])-2));
								$value['value'] = htmlspecialchars($value['value']);
								//$value['value'] = str_replace('\'', '', $value['value']);
?>
		<tr class="clsFormRow">
			<td class="clsFormLabelCellDefault"><?php $editfilefrm->renderLabelTableCell($value['tags']['@cfg_key'], $value['tags']['@cfg_label']); ?></td>
			<td class="clsFormFieldCellDefault"><?php $editfilefrm->renderTextField($input_type, $value['tags']['@cfg_key'], $value['value'], $tab_index);?><?php eval($result);?></td>
		</tr>
<?php
								break;
							case 'int' :
								$value['value'] = str_replace('\'', '', $value['value']);
?>
		<tr class="clsFormRow">
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
										$end_post = strrpos($value['value'], ')') - $start_post;
										//Extracting the array elements
										$arr_value = substr($value['value'], $start_post, $end_post);
										//Added by selva to fix the special char issues
										$array = explode(',', $arr_value);
										$new_arr = array();
										foreach($array as $key1=>$val1)
											{
												$val1 = trim($val1);
												$val1 = stripslashes(substr($val1, 1, strlen($val1)-2));
												$val1 = htmlspecialchars($val1);
												$new_arr[] = $val1;
											}
										$arr_value = implode(',', $new_arr);
										//Removing the tab and new line and emtpy characters
										$arr_value = preg_replace("/[\t\r\n ]/", "", $arr_value);
										//Adding new line character
										$arr_value = str_replace(',', ",\n", $arr_value);
										//Replacing => by =
										$arr_value = str_replace('=>', "=", $arr_value);
										//Finding the number of rows for textarea
										$no_of_row = substr_count($arr_value, ',') + 1;
?>
		<tr class="clsFormRow">
			<td class="clsFormLabelCellDefault"><?php $editfilefrm->renderLabelTableCell($value['tags']['@cfg_key'], $value['tags']['@cfg_label']); ?></td>
			<td class="clsFormFieldCellDefault"><?php $editfilefrm->renderTextArea($value['tags']['@cfg_key'], $no_of_row, '15', $tab_index, $arr_value); ?><?php eval($result);?></td>
		</tr>
<?php
									}
								break;
							case 'boolean':
?>
		<tr class="clsFormRow">
			<td class="clsFormLabelCellDefault"><?php $editfilefrm->renderLabelTableCell($value['tags']['@cfg_key'], $value['tags']['@cfg_label'], true); ?></td>
			<td class="clsFormFieldCellDefault"><?php $editfilefrm->renderCheckBox($value['tags']['@cfg_key'], $tab_index, $value['value']);?><?php eval($result);?></td>
		</tr>
<?php
					    		break;
						}
					$tab_index += 5;
				}
?>

<?php
		}
?>
	<tr class="clsFormRow">
		<td></td>
		<td><p>
			<input type="submit" class="clsSubmitButton" name="edit_submit" id="edit_submit" value="<?php echo $LANG['discuzz_common_update'];?>" tabindex="<?php echo $tab_index;?>" />&nbsp;
			<input type="reset" class="clsCancelButton" name="cancel_submit" id="cancel_submit" value="<?php echo $LANG['discuzz_common_reset'];?>" tabindex="<?php echo $tab_index;?>" />
		</p></td>
	</tr>
	</table>
</form>
<?php
    }
?>
</div>
<?php
//<<<<<<--------------------Page block templates Ends--------------------//
$editfilefrm->includeFooter();
?>