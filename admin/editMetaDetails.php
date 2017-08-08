<?php
/**
 * This file hadling the meta details
 *
 * Meta details used to make the pages as searchengine friendly
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/editMetaDetails.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//------------------- Class EditMetaHandler begins ------------------->>>>>//
/**
 * This class hadling the meta details
 *
 * @category	Rayzz
 * @package		Admin
 */
class EditMetaHandler extends FormHandler
	{
		public $file_path = array(0 => '../languages/meta_details.php');

		/**
		 * EditMetaHandler::updateFileContent()
		 * To update the meta details
		 *
		 * @return 	array
		 * @access 	public
		 */
		public function updateFileContent($post_arr)
			{
				// set file name with path
				//$file_path = $this->file_path;
				//To update every modules meta_details
				foreach($this->file_path as $file_path)
					{
						if(!file_exists($file_path))
							return false;
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
			}

		/**
		 * EditMetaHandler::stripslashesNew()
		 * To strip the slashes and replace some special characters
		 *
		 * @return 	array
		 * @access 	public
		 */
		public function stripslashesNew($value)
			{
				$value = str_replace('\\', '~*@', $value);
				$value = stripslashes($value);
				$value = str_replace('~*@', '\\', $value);
				$value = str_replace('\"', '"', $value);
				return $value;
			}
	}
//<<<<<<<---------------------------class EditMetaHandler--------------------//
//-------------------------------------Code begins-------------------------->>>>>//
$editMetaObj = new EditMetaHandler();
//set blocks
$editMetaObj->setPageBlockNames(array('msg_form_success', 'msg_form_error', 'form_edit_phrases', 'form_faq_list'));
//set Form Fields
$editMetaObj->setFormField('success_msg', '');
$editMetaObj->sanitizeFormInputs($_POST);
// Hide All Blocks and show default page
$editMetaObj->setAllPageBlocksHide();
$editMetaObj->setPageBlockShow('form_edit_phrases');

//Add file path for Enabled modules
foreach($CFG['site']['modules_arr'] as $value)
	{
		if(chkAllowedModule(array(strtolower($value))))
			{
				$editMetaObj->file_path[] = '../languages/'.$value.'_meta_details.php';
			}
	}
// submit file
if ($editMetaObj->isFormPOSTed($_POST, 'cancel_submit'))
	{
		Redirect2Url('index.php');
	}
if ($editMetaObj->isFormPOSTed($_POST, 'submit_phrases'))
	{
		if($CFG['admin']['is_demo_site'])
			{
				$editMetaObj->setCommonErrorMsg($LANG['general_config_not_allow_demo_site']);
				$editMetaObj->setPageBlockShow('block_msg_form_error');
			}
		else
			{
				$editMetaObj->updateFileContent($_POST);
				// Hide All Blocks and show default page
				$editMetaObj->setAllPageBlocksHide();
				$editMetaObj->setPageBlockShow('block_msg_form_success');
				$editMetaObj->setCommonSuccessMsg($LANG['langedit_msg_success']);
				$editMetaObj->setPageBlockShow('form_edit_phrases');
			}
	}
else
	{
		$editMetaObj->setPageBlockShow('form_edit_phrases');
	}
//<<<<--------------------------------Code Ends-----------------------------//

//--------------------Page block templates begins-------------------->>>>>>>>>//
//include the header file
$editMetaObj->left_navigation_div = 'generalSetting';
$editMetaObj->includeHeader();
if ($editMetaObj->isShowPageBlock('form_edit_phrases'))
	{
		unset($LANG);
		// include the file
		foreach($editMetaObj->file_path as $meta_file_path)
			{
				if(file_exists($meta_file_path))//to check other module's meta detail file
					require($meta_file_path);
			}
		$editMetaObj->form_edit_phrases['LANG'] = $LANG;
	}
//include the content of the page
setTemplateFolder('admin/');
$smartyObj->display('editMetaDetails.tpl');
//<<<<<<--------------------Page block templates Ends--------------------//
$editMetaObj->includeFooter();
?>
