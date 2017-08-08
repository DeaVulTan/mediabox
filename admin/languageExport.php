<?php
/**
 * This file hadling the language export and import
 *
 * Its used to export all the language file into a xml file and import a xml file to language files.
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_translate.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/languageExport.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['include_files'][] = 'common/classes/class_TranslationHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_XmlParser.lib.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------- Class LanguageExportTranslationHandler begins --------------->>>>>//
/**
 * This class hadling the language export and import
 *
 * @category	Rayzz
 * @package		Admin
 */
class LanguageExport extends TranslationHandler
	{
		/**
		 * LanguageExport::downloadLanguage()
		 * To download language
		 *
		 * @return void
		 * @access 	public
		 */
		public function downloadLanguage()
			{
				$folder_path_arr = array();
				switch($this->getFormField('folder'))
					{
						case 'all':
							$folder_path_arr = $this->CFG['trans']['folder'];
							break;

						default:
							$folder_path_arr[] = $this->getFormField('folder');
					}
				$write_string = '<language_editor>';
				foreach($folder_path_arr as $folder_name=>$folder_path)
					{
						$path = $this->CFG['site']['project_path'].sprintf($folder_path, $this->getFormField('language'));
						if(is_dir($path))
							{
								$files_list = readDirectory($path);
							}
						else if(is_file($path))
							{
								$files_list = array($path);
							}
						foreach($files_list as $file_name)
							{
								if(in_array($file_name, $this->CFG['not_trans_files'][$folder_name]))
									{
										continue;
									}
								$r_file = $file_name;
								if(is_dir($path))
									{
										$r_file = $path.$file_name;
									}
								else
									{
										$spos = 0;
										if(strrpos($file_name, '\\'))
											{
												$spos = strrpos($file_name, '\\')+1;
											}
										elseif(strrpos($file_name, '/'))
											{
												$spos = strrpos($file_name, '/')+1;
											}
										$file_name = substr($file_name, $spos);
									}
								$write_string .= '<file name="'.$file_name.'" folder="'.$folder_name.'" language="'.$this->getFormField('language').'"><![CDATA[';
								$write_string .= read_file($r_file);
								$write_string .= ']]></file>';
							}
					}
				$write_string .= '</language_editor>';
				force_download('language_'.time().'.xml', $write_string);
				exit;
			}

		/**
		 * LanguageExport::writeLanguage()
		 * To write language
		 *
		 * @return boolean
		 * @access 	public
		 */
		public function writeLanguage()
			{
				$objXML = new XmlParser();
				$strYourXML = read_file($_FILES['file']['tmp_name']);
				if(!($arrOutput = $objXML->parse($strYourXML)))
					{
						$this->setCommonErrorMsg($this->LANG['language_error_msg_invalid_file_format']);
						$this->setPageBlockShow('block_msg_form_error');
						return false;
					}
				if (isset($arrOutput[0]['children']))
				    {
				    	$this->addNewLanguage($this->getFormField('language'), $this->getFormField('language_label'));
				     	$folder_path_arr = $this->CFG['trans']['folder'];
				     	foreach($folder_path_arr as $folder_name=>$folder_path)
				     		{
				     			$path = $this->CFG['site']['project_path'].sprintf($folder_path, $this->getFormField('language'));
								$folder_path_arr[$folder_name] = $path;
								if(isset($this->CFG['not_trans_files'][$folder_name]))
									{
										$from_path = $this->CFG['site']['project_path'].sprintf($this->CFG['trans']['folder'][$folder_name], $this->CFG['lang']['default']);
										foreach($this->CFG['not_trans_files'][$folder_name] as $exclude_file)
											{
												if(is_file($from_path.$exclude_file))
													{
														copy($from_path.$exclude_file, $path.$exclude_file);
													}
											}
									}
							}
						foreach($arrOutput[0]['children'] as $key=>$value)
							{
								if(!isset($arrOutput[0]['children'][$key]['attrs']['FOLDER']))
									{
										return false;
									}
								$folder_name = $arrOutput[0]['children'][$key]['attrs']['FOLDER'];

								if($folder_name!='')
									{
										$path = $folder_path_arr[$folder_name];
									}
								if(!isset($arrOutput[0]['children'][$key]['attrs']['NAME']))
									{
										return false;
									}
								if(is_dir($path))
									{
										$path .= $arrOutput[0]['children'][$key]['attrs']['NAME'];
									}
								write_file($path, $arrOutput[0]['children'][$key]['tagData']);
							}
						if ($this->checkIsFilesExist($this->CFG['trans'], $this->getFormField('language'), $this->CFG['site']['project_path']))
							{
								$this->addTranslatedLanguage($this->getFormField('language'));
							}
						$this->setFormField('language', '');
						$this->setFormField('language_label', '');
						$this->setCommonSuccessMsg($this->LANG['language_success_msg_import']);
						$this->setPageBlockShow('block_msg_form_success');
						return true;
				    }
				$this->setPageBlockShow('block_msg_form_error');
				$this->setCommonErrorMsg($this->LANG['language_error_msg_invalid_data']);
				return false;
			}

		/**
		 * LanguageExport::chkFileIsNotEmpty()
		 * To check the file is empty
		 *
		 * @param string $err_tip error message to display if file is empty
		 * @return boolean
		 * @access 	public
		 */
		public function chkFileIsNotEmpty($err_tip = '')
			{
				if(!$_FILES['file']['name'])
					{
						$this->setFormFieldErrorTip('file', $err_tip);
						return false;
					}
				return true;
			}

		/**
		 * LanguageExport::chkIsValidLanguageName()
		 * To check the valid language name
		 *
		 * @param string $err_tip error message to display if language name is invalid
		 * @return boolean
		 * @access 	public
		 */
		public function chkIsValidLanguageName($err_tip = '')
			{
				if(ereg('[^a-zA-Z0-9_]', $this->getFormField('language')))
					{
						$this->setFormFieldErrorTip('language', $err_tip);
						return false;
					}
				if(isset($this->CFG['lang']['available_languages'][$this->getFormField('language')]))
					{
						$this->setFormFieldErrorTip('language', $this->LANG['language_err_tip_code_already_used']);
						return false;
					}
				return true;
			}

		/**
		 * LanguageExport::chkIsValidLanguagelabelName()
		 * To check the valid language label name
		 *
		 * @param string $err_tip error message to display if language label name is invalid
		 * @return boolean
		 * @access 	public
		 */
		public function chkIsValidLanguagelabelName($err_tip = '')
			{
				if(in_array(strtolower($this->getFormField('language_label')), array_flip(array_change_key_case(array_flip($this->CFG['lang']['available_languages'])))))
					{
						$this->setFormFieldErrorTip('language_label', $this->LANG['language_err_tip_label_already_used']);
						return false;
					}
				return true;
			}
	}
//<<<<<-------------- Class LanguageExportTranslationHandler begins ---------------//
//-------------------- Code begins -------------->>>>>//
$LanguageExport = new LanguageExport();
if(!chkAllowedModule(array('translate')))
	{
		Redirect2URL(getUrl($CFG['redirect']['dsabled_module_url']['file_name'],'','','root'));
	}
$LanguageExport->makeGlobalize($CFG,$LANG);
$LanguageExport->setPageBlockNames(array('block_language_export', 'block_language_import', 'block_msg_form_error', 'msg_form_error', 'block_msg_form_success', 'msg_form_success'));
$LanguageExport->setCSSFormFieldErrorTipClass('clsFormFieldErrTip');
$LanguageExport->setCSSFormLabelCellDefaultClass('clsFormLabelCellDefault');
$LanguageExport->setCSSFormFieldCellDefaultClass('clsFormFieldCellDefault');
$LanguageExport->setCSSFormLabelCellErrorClass('clsFormLabelCellError');
$LanguageExport->setCSSFormFieldCellErrorClass('clsFormFieldCellError');

//default form fields and values...
$LanguageExport->setFormField('language', '');
$LanguageExport->setFormField('language_label', '');
$LanguageExport->setFormField('folder', '');
$LanguageExport->setFormField('file', '');
$LanguageExport->setFormField('act', '');

$LanguageExport->setAllPageBlocksHide();
$LanguageExport->sanitizeFormInputs($_REQUEST);
if($LanguageExport->getFormField('act')=='export')
	{
		$LanguageExport->setPageBlockShow('block_language_export');
		$LanguageExport->LANG['page_title'] = $LanguageExport->LANG['language_export_title'];
	}
else if($LanguageExport->getFormField('act')=='import')
	{
		$LanguageExport->setPageBlockShow('block_language_import');
		$LanguageExport->LANG['page_title'] = $LanguageExport->LANG['language_import_title'];
		$LanguageExport->LANG['language_name_like'] = str_replace('VAR_lang_name', 'en_us', $LanguageExport->LANG['language_name_like']);
		$LanguageExport->LANG['language_label_like'] = str_replace('VAR_language_label', 'English', $LanguageExport->LANG['language_label_like']);
	}
else
	{
		$LanguageExport->setCommonErrorMsg($LanguageExport->LANG['language_err_msg_no_action_found']);
		$LanguageExport->setPageBlockShow('block_msg_form_error');
		$LanguageExport->LANG['page_title'] = $LanguageExport->LANG['language_page_title_error'];
	}
if($LanguageExport->isValidFormInputs())
	{
		if($LanguageExport->isFormPOSTed($_POST, 'export_submit'))
			{
				if($CFG['admin']['is_demo_site'])
					{
						$LanguageExport->setCommonErrorMsg($LANG['general_config_not_allow_demo_site']);
						$LanguageExport->setPageBlockShow('block_msg_form_error');
					}
				else
					{
						$LanguageExport->downloadLanguage();
					}
			}
		if($LanguageExport->isFormPOSTed($_POST, 'import_submit'))
			{
				if($CFG['admin']['is_demo_site'])
					{
						$LanguageExport->setCommonErrorMsg($LANG['general_config_not_allow_demo_site']);
						$LanguageExport->setPageBlockShow('block_msg_form_error');
					}
				else
					{
						$LanguageExport->chkIsNotEmpty('language', $LanguageExport->LANG['err_tip_compulsory']) and
							$LanguageExport->chkIsValidLanguageName($LanguageExport->LANG['language_err_tip_invalid_name']);
						$LanguageExport->chkIsNotEmpty('language_label', $LanguageExport->LANG['err_tip_compulsory']) and
							$LanguageExport->chkIsValidLanguagelabelName();
						$LanguageExport->chkFileIsNotEmpty($LanguageExport->LANG['err_tip_compulsory']);

						if($LanguageExport->isValidFormInputs())
							{
								if(!$LanguageExport->writeLanguage())
									{
										$LanguageExport->setCommonErrorMsg($LanguageExport->LANG['language_error_msg_invalid_file_format']);
										$LanguageExport->setPageBlockShow('block_msg_form_error');
									}
							}
						else
							{
								$LanguageExport->setCommonErrorMsg($LanguageExport->LANG['language_error_msg_invalid_form_fields']);
								$LanguageExport->setPageBlockShow('block_msg_form_error');
							}
					}
			}
	}
//<<<<<-------------------- Code ends----------------------//

//-------------------- Page block templates begins -------------------->>>>>//
$LanguageExport->left_navigation_div = 'generalLanguage';
if ($LanguageExport->isShowPageBlock('block_language_export'))
    {
	}
//include the header file
$LanguageExport->includeHeader();
//include the content of the page
setTemplateFolder('admin');
$smartyObj->display('languageExport.tpl');
//includ the footer of the page
$LanguageExport->includeFooter();
?>