<?php
/**
 * This file hadling the template settings
 *
 * template settings used to enabe or disable template switch and what are the templated allowed to display in members section to switch
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/editTemplateSettings.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Parser.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class EditTemplateSettings begins -------------------->>>>>//
/**
 * This class hadling the template settings
 *
 * @category	Rayzz
 * @package		Admin
 */
class EditTemplateSettings extends FormHandler
	{
		/**
		 * EditTemplateSettings::populateTemplateCssDetails()
		 * To populate template and css details to default option field
		 *
		 * @return 	array
		 * @access 	public
		 */
		public function populateTemplateCssDetails()
			{
				$dir_array = readDirectory($this->CFG['site']['project_path']. 'design/templates/', 'dir');
				$template_arr = array();
				foreach($dir_array as $template)
					{
						$template_arr[$template] = readDirectory($this->CFG['site']['project_path']. 'design/templates/'.$template.'/root/css/', 'dir');
					}
				return $template_arr;
			}

		/**
		 * EditTemplateSettings::populateTemplates()
		 * To populate the templates list
		 *
		 * @return 	array
		 * @access 	public
		 */
		public function populateTemplates()
			{
				$dir_array = readDirectory($this->CFG['site']['project_path']. 'design/templates/', 'dir');
				$template_arr = array();
				foreach($dir_array as $template)
					{
						$template_arr[] = $template;
					}
				return $template_arr;
			}


		/**
		 * EditTemplateSettings::populateCssDetails()
		 * To populate the css list under the given template
		 *
		 * @param  string $template template name
		 * @return 	array
		 * @access 	public
		 */
		public function populateCssDetails($template)
			{
				if(is_dir($this->CFG['site']['project_path']. 'design/templates/'.$template.'/root/css/'))
				{
					$css_array = readDirectory($this->CFG['site']['project_path']. 'design/templates/'.$template.'/root/css/', 'dir');
					foreach($css_array as $css)
						{
							$css_files_array[] = $css.'.css';
						}
	                return $css_files_array;
				}

			}

		/**
		 * EditTemplateSettings::chkIsValidTemplate()
		 * To check the valid templates
		 *
		 * @return 	boolean
		 * @access 	public
		 */
		public function chkIsValidTemplate()
     		{
             	$temp_ok = false;
                if(!isset($this->fields_arr['temp_arr']))
                	{
                    	return false;
                    }
                $template_array = $this->fields_arr['temp_arr'];
                $template_count = count($template_array);

				foreach($template_array as $templ)
                	{
                		if(!isset($this->fields_arr['css_arr']))
                			{
                        		return false;
                        	}
                        $temp_ok = false;
                        $css_array = $this->populateCssDetails($templ);
                        $css_exist = false;
						foreach($this->fields_arr['css_arr'] as $cssfile)
                        	{
                            	if($temp_ok)
                            		{
                                		break;
                                	}
                                $cssfile = explode('__', $cssfile);
                                if(in_array($cssfile[1],$css_array) and $templ == $cssfile[0])
                                    {
										$temp_ok = true;
                                    	$css_exist =true;
                                    }
                            }
                        if(!$css_exist)
                            {
                        		$this->setCommonErrorMsg($this->LANG['error_msg_no_allowed_css']);
								return false;
							}
                    }
                return $temp_ok;
            }

    	/**
		 * EditTemplateSettings::isValidCss()
		 * To check the valid css
		 *
		 * @return 	boolean
		 * @access 	public
		 */
		public function isValidCss()
       		{
			   if(!isset($this->fields_arr['css_arr']))
			   		{
                    	return false;
                    }
                if(!isset($this->fields_arr['temp_arr']))
                	{
                    	return false;
                    }
                $temp_array = $this->fields_arr['temp_arr'];
                $css_array = $this->fields_arr['css_arr'];

                foreach($css_array as $cssfile)
                	{
                    	$template_name = explode('__', $cssfile);
                        if(!in_array($template_name[0], $this->fields_arr['temp_arr']))
                        	{
								$this->setCommonErrorMsg($this->LANG['error_msg_template_not_selected']);
                                return false;
                            }
                    }
                return true;
            }

	  	/**
		 * EditTemplateSettings::resetFieldValues()
		 * To initialize the form field values
		 *
		 * @return
		 * @access 	public
		 */
		public function resetFieldValues()
           {
			    $this->setFormField('is_template_change', $this->CFG['html']['template']['is_template_support']);
                $this->setFormField('default_screen', $this->CFG['html']['template']['default'].'__'.$this->CFG['html']['stylesheet']['screen']['default']);
                $this->setFormField('temp_arr', $this->CFG['html']['template']['allowed']);
                $this->setFormField('css_arr', $this->CFG['html']['stylesheet']['allowed']);
           }

    	/**
		 * EditTemplateSettings::writeTemplateConfig()
		 * To write the config data into config template file
		 *
		 * @return
		 * @access 	public
		 */
		public function writeTemplateConfig()
            {
            	$is_support = $this->getFormField('is_template_change');
                $screen = $this->getFormField('default_screen');
                $templ_arr = $this->getFormField('temp_arr');
                $style_arr = $this->getFormField('css_arr');

                $style_arr = implode("','",$style_arr);
                $templ_arr = implode("','",$templ_arr);

                $style_arr_form = 'array(\''.$style_arr.'\')';
                $templ_arr_form = 'array(\''.$templ_arr.'\')';

                //$default_templ = $this->getTemplateName($screen);
                $scr_temp = explode('__',$screen);
				$default_templ = $scr_temp[0];
				$screen_new = $scr_temp[1];
				$this->CFG['html']['template']['temp_default'] = $default_templ;
				$this->CFG['html']['stylesheet']['screen']['temp_default'] = $screen_new;

				if (is_writable('../common/configs/config_templates.inc.php'))
  					{
  						if ($handle = fopen('../common/configs/config_templates.inc.php', 'w'))
  							{
$str = <<<CONT
<?php
\$CFG['html']['template']['is_template_support'] = {$is_support};
\$CFG['html']['template']['default'] = '{$default_templ}';
\$CFG['html']['stylesheet']['screen']['default'] = '{$screen_new}';
\$CFG['html']['template']['allowed']= {$templ_arr_form};
\$CFG['html']['stylesheet']['allowed'] = {$style_arr_form};
\$CFG['html']['stylesheet']['screen']['admindefault'] = '{$screen_new}';
?>
CONT;
			  					fwrite($handle, $str);
			  					fclose($handle);
			  				}
  					}
            }

        /**
		 * EditTemplateSettings::chkIsValidDefaultTemplate()
		 * To check whether the selected default template is valid or not
		 *
		 * @return 	boolean
		 * @access 	public
		 */
		public function chkIsValidDefaultTemplate()
    		{
				if(!in_array($this->getFormField('default_screen').'.css', $this->getFormField('css_arr')))
            		{
            			$this->setCommonErrorMsg($this->LANG['error_msg_default_template']);
                        return false;
					}
			}

		/**
		 * EditTemplateSettings::chkIsNotEmpty()
		 * To check whether the given form field value is empty or not
		 *
		 * @return 	boolean
		 * @access 	public
		 */
		public function chkIsNotEmpty($field_name, $err_tip='')
			{
				$is_ok = (is_string($this->fields_arr[$field_name])) ?
								($this->fields_arr[$field_name]!='') : (!empty($this->fields_arr[$field_name]));
				if (!$is_ok)
					{
						$this->setCommonErrorMsg($err_tip);
					}
				return $is_ok;
			}
	}
//<<<<<--------------------- Class EditTemplateSettings ends ------------------------//
//------------------ Code begins------------------>>>//
$editfilefrm = new EditTemplateSettings();
$editfilefrm->setPageBlockNames(array('show_config_variable'));
$editfilefrm->setFormField('is_template_change', '');
$editfilefrm->setFormField('default_screen', '');
$editfilefrm->setFormField('temp_arr', array());
$editfilefrm->setFormField('css_arr', array());
$editfilefrm->setAllPageBlocksHide();

$editfilefrm->sanitizeFormInputs($_REQUEST);

if ($editfilefrm->isFormPOSTed($_POST, 'edit_submit'))
	{
		if($CFG['admin']['is_demo_site'])
			{
				$editfilefrm->setCommonErrorMsg($editfilefrm->LANG['general_config_not_allow_demo_site']);
				$editfilefrm->setPageBlockShow('block_msg_form_error');
				$editfilefrm->setPageBlockShow('block_config_form');
			}
		else
			{
				$editfilefrm->chkIsNotEmpty('temp_arr', $LANG['error_msg_no_allowed_templates']) and
		        	$editfilefrm->chkIsNotEmpty('css_arr', $LANG['error_msg_no_allowed_css']) and
		            $editfilefrm->chkIsValidTemplate() and
		            $editfilefrm->isValidCss() and
					$editfilefrm->chkIsValidDefaultTemplate();

		        if ($editfilefrm->isValidFormInputs())
		          	{
		            	$editfilefrm->writeTemplateConfig();
						$editfilefrm->setPageBlockShow('block_msg_form_success');
						$editfilefrm->setCommonSuccessMsg($LANG['general_config_success_msg']);
		          	}
		        else
		        	{
						$editfilefrm->setPageBlockShow('block_msg_form_error');
		            }
			}
	}
else
	{
		$editfilefrm->resetFieldValues();
    }
$editfilefrm->setPageBlockShow('show_config_variable');
//<<<<<---------------------Code ends------------------//
//-----------------Page block template begins----------->>>>>//
if ($editfilefrm->isShowPageBlock('show_config_variable'))
	{
		$smartyObj->assign('template_arr12', $editfilefrm->populateTemplateCssDetails());
		$smartyObj->assign('total_details', $editfilefrm->populateTemplates());
     }
$editfilefrm->left_navigation_div = 'generalSetting';
//<<<<<<--------------------Page block templates Ends--------------------//
$editfilefrm->includeHeader();
setTemplateFolder('admin/');
$smartyObj->display('editTemplateSettings.tpl');
$editfilefrm->includeFooter();
?>