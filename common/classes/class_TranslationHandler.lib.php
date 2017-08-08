<?php
/**
 * TranslationHandler
 *
 * @package
 * @author joseph_037at09
 * @copyright Copyright (c) 2009 - 2010
 * @version $Id$
 * @access public
 */
class TranslationHandler extends FormHandler
	{
		/**
		 * TranslationHandler::check_empty_folder()
		 * Find the numers fo files in separate folder
		 * @param mixed $folder
		 * @return int count
		 */
		public function check_empty_folder($folder)
			{
				$files = array ();
				if ($handle = opendir($folder)){
					while(false!==($file=readdir($handle))){
						if($file!= "." && $file != ".."){
							$files [] = $file;
						}
					}
					closedir ( $handle );
				}
				return ( count ( $files ) > 0 ) ? FALSE : TRUE;
			}

		/**
		 * TranslationHandler::checkIsFilesExist()
		 * To check given file is exist
		 * @param mixed $CFG_TRANS
		 * @param mixed $lang
		 * @param mixed $project_path
		 * @return boolean
		 */
		public function checkIsFilesExist($CFG_TRANS, $lang, $project_path)
			{
				foreach($CFG_TRANS['folder'] as $key => $val)
					{
						$path = $project_path.sprintf($val, $lang);
						if (!((is_dir($path)  and !$this->check_empty_folder($path)) or (is_file($path))))
							{
								return false;
							}
					}
				return true;
			}

		/**
		 * TranslationHandler::addNewLanguage()
		 * To add new language
		 * @param mixed $lang
		 * @param mixed $label
		 * @return
		 */
		public function addNewLanguage($lang, $label)
			{
				if(isset($this->CFG['lang']['available_languages'][$lang]))
					{
						return;
					}
				$this->CFG['lang']['available_languages'][$lang] = isset($this->CFG['trans_name'][$lang])?$this->CFG['trans_name'][$lang]:'';
				$file = '../common/configs/config_lang.inc.php';
				$data = read_file($file);
				$data = str_replace('?>', '', $data);
				$data .= '$CFG[\'lang\'][\'available_languages\'][\''.$lang.'\'] = \''.$label.'\';'."\n";
				$data .= '$CFG[\'published_languages\'][\''.$lang.'\'] = \'false\';'."\n";
				$data .= '?>';
				write_file('../common/configs/config_lang.inc.php', $data, 'w+');

				foreach($this->CFG['trans']['folder'] as $key=>$value)
					{
						$lang_path = $this->CFG['site']['project_path'].sprintf($value, $lang);
						if (!strstr($lang_path, '.php'))
							{
								@mkdir($lang_path, 0777, true);
							}
					}
			}

		/**
		 * TranslationHandler::publishOrUnpublishLanguage()
		 * To publish language
		 * @param mixed $newlg
		 * @param mixed $publish_status
		 * @return
		 */
		public function publishOrUnpublishLanguage($newlg, $publish_status)
			{
				$search_status = $publish_status === 'true'?'false':'true';
				$file = '../common/configs/config_lang.inc.php';
				$data = read_file($file);
				if(isset($this->CFG['published_languages'][$newlg]))
					{
						$search = '$CFG[\'published_languages\'][\''.$newlg.'\'] = \''.$search_status.'\';';
						$replace = '$CFG[\'published_languages\'][\''.$newlg.'\'] = \''.$publish_status.'\';';
						$data = str_replace($search, $replace, $data);
					}
				else
					{
						$data = str_replace('?>', '', $data);
						$data .= '$CFG[\'published_languages\'][\''.$newlg.'\'] = \''.$publish_status.'\';'."\n";
						$data .= '?>';
					}
				//echo $data;return;
				write_file('../common/configs/config_lang.inc.php', $data, 'w+');
			}

		/**
		 * TranslationHandler::addTranslatedLanguage()
		 * To add translated language
		 * @param mixed $newlg
		 * @param string $status
		 * @return
		 */
		public function addTranslatedLanguage($newlg, $status='true')
			{
				$file = '../common/configs/config_lang.inc.php';
				$data = read_file($file);
				if(isset($this->CFG['translated_lang'][$newlg]))
					{
						$search = '$CFG[\'translated_lang\'][\''.$newlg.'\'] = \'false\';';
						$replace = '$CFG[\'translated_lang\'][\''.$newlg.'\'] = \'true\';';
						if ($status == 'false')
							{
								$search = '$CFG[\'translated_lang\'][\''.$newlg.'\'] = \'true\';';
								$replace = '$CFG[\'translated_lang\'][\''.$newlg.'\'] = \'false\';';
							}
						$data = str_replace($search, $replace, $data);
					}
				else
					{
						$data = str_replace('?>', '', $data);
						$data .= '$CFG[\'translated_lang\'][\''.$newlg.'\'] = \''.$status.'\';'."\n";
						$data .= '?>';
					}
				//echo $data;return;
				write_file('../common/configs/config_lang.inc.php', $data, 'w+');
			}

		/**
		 * VerifyTranslation::verifyLanguage()
		 * To verify the language files
		 *
		 * @return
		 * @access 	public
		 */
		public function verifyLanguage($language_base, $language_to_verify)
			{
				global $LANG, $LANG_LIST_ARR, $CFG;

				$LANG_BACKUP = $LANG;
				$LANG_LIST_ARR_BACKUP = $LANG_LIST_ARR;
				$return = true;
				$folder_path_arr = $this->CFG['trans']['folder'];

				foreach($folder_path_arr as $folder_name=>$folder_path)
					{
						$base_path = $this->CFG['site']['project_path'].sprintf($folder_path, $language_base);
						$verify_path = $this->CFG['site']['project_path'].sprintf($folder_path, $language_to_verify);

						if(is_dir($base_path))
							{
								$files_list = readDirectory($base_path);
							}
						else if(is_file($base_path))
							{
								$files_list = array($base_path);
							}
						foreach($files_list as $file_name)
							{
								$LANG = array();
								$LANG_LIST_ARR = array();
								$display_var_text = '';
								$lang_base = array();
								$lang_to_verify = array();

								if(is_dir($verify_path))
									{
										$chk_file_name = $verify_path.$file_name;
										$base_file_name = $base_path.$file_name;
									}
								else
									{
										$chk_file_name = $verify_path;
										$base_file_name = $base_path;
									}
								if(!is_file($chk_file_name))
									{
										$return = false;
									}
								else
									{
										if(!in_array($file_name, $CFG['not_trans_files'][$folder_name]))
											{
												@require($base_file_name);
												if($LANG_LIST_ARR)
													{
														$lang_var_name = 'LANG_LIST_ARR';
													}
												else if($LANG)
													{
														$lang_var_name = 'LANG';
													}

												$lang_base = $$lang_var_name;
												$LANG = array();
												$LANG_LIST_ARR = array();
												@require($chk_file_name);
												$lang_to_verify = $$lang_var_name;

												foreach($lang_base AS $key=>$value)
													{
														if(is_array($value))
															{
																foreach($value AS $key1=>$value1)
																	{
																		if(is_array($value1))
																			{
																				foreach($value1 AS $key2=>$value2)
																					{
																						if(isset($lang_base[$key][$key1][$key2]) and !isset($lang_to_verify[$key][$key1][$key2]))
																							{
																								$display_var_text .= '$'.$lang_var_name.'[\''.$key.'\'][\''.$key1.'\'][\''.$key2.'\']<br>';
																							}
																					}

																			}
																		else
																			{
																				if(isset($lang_base[$key][$key1]) and !isset($lang_to_verify[$key][$key1]))
																					{
																						$display_var_text .= '$'.$lang_var_name.'[\''.$key.'\'][\''.$key1.'\']<br>';
																					}
																			}
																	}
															}
														else
															{
																if(isset($lang_base[$key]) and !isset($lang_to_verify[$key]))
																	{
																		$display_var_text .= '$'.$lang_var_name.'[\''.$key.'\']<br>';
																	}
															}
													}
												if($display_var_text)
													{
														$return = false;
													}
											}
									}
							}
					}
				$LANG = $LANG_BACKUP;
				$LANG_LIST_ARR = $LANG_LIST_ARR_BACKUP;
				return $return;
			}
	}
?>
