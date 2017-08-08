<?php
/**
 * Class to handle the form fields
 *
 * This is having class FormHandler to handle the validation of form fields, to
 * set or get values for form fields, to handle page blocks, to handle CSS for
 * form fields and to populate the common static array file.
 *
 * PHP version 5.0
 *
 * @category	###Framework###
 * @package		###Common/Classes###
 * @author		rajesh_04ag02
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id : $
 * @since 		2005-22-05
 */
//Defining constants for form field validation at the time of setting the form field array
define('ISNOTEMPTY', 1<<0);
define('ISVALIDALPHA', 1<<1);
define('ISVALIDALPHANUMERIC', 1<<2);
define('ISNUMERIC', 1<<3);
define('ISREAL', 1<<4);
define('ISVALIDEMAIL', 1<<5);
define('ISVALIDPHONENO', 1<<6);
define('ISVALIDURL', 1<<7);
define('ISCUSTOMFUN', 1<<8);
//------------------- Class FormHandler begins ------------------->>>>>//
/**
 * FormHandler class for handling form fields
 *
 * <b>Class overview</b>
 *
 * FormHandler class is used to inherit various types of methods in other classes
 * such as css related methods validation methods form fileds storage error messages
 * genearting methods etc are developed here.
 *
 * <b>Methods overview</b>
 *
 * setFormField, getFormField type methods are used to store the form fields.
 * In array methods such as setCSSFormLabelCellDefaultClass are used to adpot
 * css styles to the cells chkIsValidEmail, chkIsAlphaNumeric etc are related
 * to the validation techniques.setCountriesListArr like methods are used set
 * the values given such as countries, days etc into arrays.
 *
 * <b>How to use this class</b>
 *
 * create object for one class. And inherit this class.call the methods
 * depending upon the situations like validation of the user inputs,
 * setting the values given to arrays.
 *
 * @category	###Framework###
 * @package		###Common/Classes###
 * @author 		###rajesh_04ag02###
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		Release: @package_version@
 * @since 		2004-12-03
 * @todo		1)Need to implement the $is_allow_dynamic_fields boolean variable in some methods
 * 				2)Have to find the better way to check the and & or condition for form field
 * 				validation at the time of setting form fields array.
 * 				3)Need to complete the coding to handle the custom validate function in setFormField function.
 * 				4)Need to complete the coding for validateFormFields method
 */
//To test this class in standalone mode with test cases
//found at the end of this class...
if (!isset($CFG['debug']['debug_standalone_modules']))
		$CFG['debug']['debug_standalone_modules'] = true;

class FormHandler
	{
		/**
		 * @var		string common error messsage
		 */
		protected $common_error_message = '';
		/**
		 * @var		string common success messsage
		 */
		protected $common_success_message = '';
		/**
		 * @var		string common alert messsage
		 */
		protected $common_alert_message = '';
		/**
		 * @var		array array of form fields
		 */
		protected $fields_arr = array();
		/**
		 * @var		array array of error tips for fields
		 */
		protected $fields_err_tip_arr = array();
		/**
		 * @var		array array of form block show status
		 */
		protected $page_block_show_stat_arr = array();	//Array of Page Block show status
		/**
		 * @var		array array of css class
		 */
		protected $css_class_arr = array();
		/**
		 * @var		array array of countries list
		 */
		protected $countries_list_arr;
		/**
		 * @var		array array of months list
		 */
		protected $months_list_arr;
		/**
		 * @var		array array of years list
		 */
		protected $years_list_config;
		/**
		 * @var 	boolean option to allow dynamic form fields
		 */
		protected $is_allow_dynamic_fields = false;
		/**
		 * @var		array array of email template value
		 */
		protected $email_template_value_arr = array();
		/**
		 * @var		string email subject
		 */
		protected $email_subject;
		/**
		 * @var		string email content
		 */
		protected $email_content;
		public $_currentPage;
		public $_navigationArr = array();
		public $_clsActiveLink = ' clsActiveLink';
		public $_clsInActiveLink = ' clsInActiveLink';
		/**
		 * @var		string jeditable content separator
		 */
		public $content_separator = '#~#';

	   /**
		* Constructor
		*
		* When object is initiated, constructor method is called immediately.
		*
		* @return 		void
		* @access 		public
		*/
		public function __construct()
			{
				global $CFG, $LANG, $LANG_LIST_ARR, $db;
				if (isset($CFG))
					{
						$this->CFG = $CFG;
					}
				if (isset($LANG))
					{
						$this->LANG = $LANG;
					}
				if (isset($LANG_LIST_ARR))
					{
						$this->LANG_LIST_ARR = $LANG_LIST_ARR;
					}
				if (isset($db))
					{
						$this->setDBObject($db);
						$this->chkBrowserForEditor();
					}
				if(isset($this->CFG['html']['current_script_name']))
					$this->_currentPage = strtolower($this->CFG['html']['current_script_name']);

				$this->setCSSFormFieldErrorTipClass('error');
				$this->setCSSFormLabelCellDefaultClass('ClsFormLabelCellDefault');
				$this->setCSSFormFieldCellDefaultClass('ClsFormFieldCellDefault');
				$this->setCSSFormLabelCellErrorClass('ClsFormLabelCellError');
				$this->setCSSFormFieldCellErrorClass('ClsFormFieldCellError');
				//Profile page Background var
				$this->profile_background = false;
			}

		/**
		 * FormHandler::getNavClass()
		 *
		 * @param mixed $identifier
		 * @return
		 */
		public function getNavClass($identifier)
			{
				$identifier = strtolower($identifier);
				return isset($this->_navigationArr[$identifier])?$this->_navigationArr[$identifier]:$this->_clsInActiveLink;
			}

		/**
		 * FormHandler::assignSmartyVariables()
		 *
		 * @return
		 */
		public function assignSmartyVariables()
			{
				global $smartyObj;
				$smartyObj->assign('CFG', $this->CFG);
				$smartyObj->assign('LANG', $this->LANG);
				$smartyObj->assign_by_ref('myobj', $this);
			}

	   /**
		* To set the form fields
		*
		* Before using form fields, set the form field using this method.
		* we can set the default value to the form fields
		*
		* @param 		string $field_name Form field name
		* @param 		string $field_value Form field value
		* @param		int $validation_scheme number having bits set for the required validation
		* @return 		void
		* @access 		public
		*/
		public function setFormField($field_name, $field_value, $validation_scheme = null, $custom_validation_fun_name = null)
			{
				global $smartyObj;
				$this->fields_arr[$field_name] = $field_value;
				$smartyObj->assign('field_value_'.$field_name, $field_value);
				if (isset($validation_scheme))
					{
						$this->validation_scheme_arr[$field_name] = $validation_scheme;
						$this->custom_validation_fun_name[$field_name] = $custom_validation_fun_name;
					}
			}

	   /**
		* To get the form field
		*
		* To get the form field value after setting the form field value
		*
		* @param 		string $field_name Form field name
		* @return 		string $this->fields_arr[$field_name] Form field value
		* @access 		public
		*/
		public function getFormField($field_name)
			{
				return $this->fields_arr[$field_name];
			}

	   /**
		* To set the common error message
		*
		* Use this method to set the common error message. After
		* submitting form, call this method to set the error message
		*
		* @param 		string $err_msg common error message
		* @return 		string
		* @access 		public
		*/
		public function setCommonErrorMsg($err_msg)
			{
				$this->common_error_message = $err_msg;
			}

	   /**
		* To get the common error message
		*
		* Use this method to get the common error message. Call this
		* method in error page block to show the common error message
		*
		* @return 		string $this->common_error_message
		* @access 		public
		*/
		public function getCommonErrorMsg()
			{
				return $this->common_error_message;
			}

		/**
		* To set the common success message
		*
		* Use this method to set the common success message. After
		* submitting form, call this method to set the success message
		*
		* @param 		string $success_msg common success message
		* @return 		string
		* @access 		public
		*/
		public function setCommonSuccessMsg($success_msg)
			{
				$this->common_success_message = $success_msg;
			}

	   /**
		* To get the common success message
		*
		* Use this method to get the common success message. Call this
		* method in success page block to show the common success message
		*
		* @return 		string $this->common_success_message
		* @access 		public
		*/
		public function getCommonSuccessMsg()
			{
				return $this->common_success_message;
			}

		/**
		* To set the common alert message
		*
		* Use this method to set the common alert message. After
		* submitting form, call this method to set the alert message
		*
		* @param 		string $alert_msg common alert message
		* @return 		string
		* @access 		public
		*/
		public function setCommonAlertMsg($alert_msg)
			{
				$this->common_alert_message = $alert_msg;
			}

	   /**
		* To get the common alert message
		*
		* Use this method to get the common alert message. Call this
		* method in alert page block to show the common alert message
		*
		* @return 		string $this->common_alert_message
		* @access 		public
		*/
		public function getCommonAlertMsg()
			{
				return $this->common_alert_message;
			}

	   /**
		* To set the email template value
		*
		* @param 		string template key
		* @param 		string template value
		* @return 		void
		* @access 		public
		*/
		public function setEmailTemplateValue($key, $value)
			{
				$this->email_template_value_arr[$key] = $value;
			}

	   /**
		* To get the email template value
		*
		* @param 		string template key
		* @return 		string
		* @access 		public
		*/
		public function getEmailTemplateValue($key)
			{
				return $this->email_template_value_arr[$key];
			}

	   /**
		* To build the email template
		*
		* @param 		string subject of the mail
		* @param 		string content of the mail
		* @param 		boolean htmal changes needed in subject
		* @param 		boolean htmal changes needed in content
		* @return 		string
		* @access 		public
		*/
		public function buildEmailTemplate($subject, $content, $html_subject = false, $html_content = true)
			{
				foreach($this->email_template_value_arr as $key=>$value)
					{
						$subject = str_replace('VAR_'.strtoupper($key), $value, $subject);
						$content = str_replace('VAR_'.strtoupper($key), $value, $content);
					}
				$subject = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $subject);
				$content = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $content);

				$subject = str_replace('VAR_SITE_URL', $this->CFG['site']['url'], $subject);
				$content = str_replace('VAR_SITE_URL', $this->CFG['site']['url'], $content);

				if(isset($this->CFG['site']['host']))
					{
						$subject = str_replace('VAR_SITE_HOST', $this->CFG['site']['host'], $subject);
						$content = str_replace('VAR_SITE_HOST', $this->CFG['site']['host'], $content);
					}
				if($html_subject)
					{
						$subject = makeClickableLinks($subject);
						$subject = nl2br($subject);
					}
				if($html_content)
					{
						$content = makeClickableLinks($content);
						$content = nl2br($content);
					}
				$this->email_subject = $subject;
				$this->email_content = $content;
			}

		/**
		 * To send email
		 *
		 * @param 		string $to_email to email id
		 * @param 		string $subject subject
		 * @param		string $body mail body
		 * @param 		string $sender_name sender name
		 * @param 		string $sender_email sender email
		 * @return 		void
		 * @access 		public
		 */
		public function _sendMail($to_email, $subject, $body, $sender_name, $sender_email)
			{
				$this->buildEmailTemplate($subject, $body, false, true);
				$EasySwift = new EasySwift($this->getSwiftConnection());
				$EasySwift->flush();
				$EasySwift->addPart($this->getEmailContent(true), "text/html");
				$from_address = $sender_name.'<'.$sender_email.'>';
				return $EasySwift->send($to_email, $from_address, $this->getEmailSubject());
			}

	   /**
		* To get the email subject
		*
		* @param
		* @return 		string
		* @access 		public
		*/
		public function getEmailSubject()
			{
				return $this->email_subject;
			}

		/**
	     * To get the email template
	     *
	     * @return string
	     * @access public
	     */
		public function getEmailTemplateBody()
			{
				$file_header = read_file($this->CFG['site']['project_path'].'design/templates/'.$this->CFG['html']['template']['default'].'/general/emailHeader.tpl');
				$file_footer = read_file($this->CFG['site']['project_path'].'design/templates/'.$this->CFG['html']['template']['default'].'/general/emailFooter.tpl');

				$replace_arr = array(
								'VAR_COPY_RIGHT_YEAR'=>$this->CFG['admin']['coppy_rights_year'],
								'VAR_POWERED_BY'=>$this->CFG['dev']['name'],
								'VAR_URL'=>$this->CFG['dev']['url'],
								'VAR_COMMON_ALL_RIGHT_RESERVED'=>$this->LANG['header_allrights_reserved'],
								'VAR_COMMON_POWERED_BY'=>$this->LANG['header_powered_by'],
								'VAR_SITE_IMAGE_LOGO_URL' => $this->CFG['site']['url'].'/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/email-logo.jpg',
								);

				$file_header = $this->buildDisplaytext($file_header, $replace_arr);
				$file_footer = $this->buildDisplaytext($file_footer, $replace_arr);

				return $file_header.$this->email_content.$file_footer;
			}

	   /**
		* To get the email content
		*
		* @param
		* @return 		string
		* @access 		public
		*/
		public function getEmailContent($template=false)
			{
				return ($template) ? ( ($this->CFG['admin']['module']['email_template']) ? $this->getEmailTemplateBody() : $this->email_content ) : $this->email_content ;
			}

/**
		public function resetFormFieldsErrors()
			{
				$this->fields_err_tip_arr = array();
			}
//*/

	   /**
        * To set the page block names
        *
        * Before using any page block names set the name in this method
        *
		* @param 		array $block_names_arr Array of page block names
        * @return 		void
		* @access 		public
        */
		public function setPageBlockNames($block_names_arr=array())
			{
				$default_blocks = array('block_msg_form_error', 'block_msg_form_success', 'msg_form_error', 'msg_form_success', 'block_msg_form_alert');
				$block_names_arr = array_merge($default_blocks, $block_names_arr);
				$block_names_arr = array_unique($block_names_arr);
				//also reset stat
				foreach($block_names_arr as $block_name)
					{
						$this->page_block_show_stat_arr[$block_name] = false;	//hide all. reset.
					}
			}

	   /**
        * To show the page block
        *
		* @param 		string $block_name page block name
        * @return 		void
		* @access 		public
        */
		public function setPageBlockShow($block_name)
			{
				$this->page_block_show_stat_arr[$block_name] = true; //show
			}

	   /**
        * To hide the page block
        *
        *
		* @param 		string $block_name page block name
        * @return 		void
		* @access 		public
        */
		public function setPageBlockHide($block_name)
			{
				$this->page_block_show_stat_arr[$block_name] = false; //hide
			}

	   /**
        * To show all the page blocks
        *
        * @return 		void
		* @access 		public
        */
		public function setAllPageBlocksShow()
			{
				foreach($this->page_block_show_stat_arr as $block_name=>$is_show)
					{
						$this->page_block_show_stat_arr[$block_name] = true; //show
					}
			}

	   /**
        * To hide all the page blocks
        *
        * @return 		void
		* @access 		public
        */
		public function setAllPageBlocksHide()
			{
				foreach($this->page_block_show_stat_arr as $block_name=>$is_show)
					{
						$this->page_block_show_stat_arr[$block_name] = false; //hide
					}
			}

	   /**
        * To check whether the page block is show or not
        *
        * Before use the page block, set the page block name in setPageBlockShow()
        * method. It is checked in this methid. If it is set, this method return
		* true otherwise it return false
		*
        * @param 		string $block_name page block name
        * @return 		boolean true/false
		* @access 		public
        */
		public function isShowPageBlock($block_name)
			{
				return $this->page_block_show_stat_arr[$block_name];
			}

	   /**
        * To set the css class for error tip
        *
        * We can set the css error tip class for the form fields
        *
        * @param 		string $class_name Error tip class name
        * @return 		void
		* @access 		public
        */
		public function setCSSFormFieldErrorTipClass($class_name)
			{
				$this->css_class_arr['form_field_err_tip'] = $class_name;
			}

	   /**
        * To set the default css class for label
        *
        * @param 		string $class_name default label class
        * @return 		void
		* @access 		public
        */
		public function setCSSFormLabelCellDefaultClass($class_name)
			{
				$this->css_class_arr['form_label_cell_default'] = $class_name;
			}

	   /**
        * To set the css class for error label
        *
        * @param 		string $class_name error label class
        * @return 		void
		* @access 		public
        */
		public function setCSSFormLabelCellErrorClass($class_name)
			{
				$this->css_class_arr['form_label_cell_error'] = $class_name;
			}

	   /**
        * To set the default css class for form field
        *
        * @param 		string $class_name default form field class
        * @return 		void
		* @access 		public
        */
		public function setCSSFormFieldCellDefaultClass($class_name)
			{
				$this->css_class_arr['form_field_cell_default'] = $class_name;
			}

	   /**
        * To set css class for error form fields
        *
        * @param 		string $class_name error form field class
        * @return 		void
		* @access 		public
        */
		public function setCSSFormFieldCellErrorClass($class_name)
			{
				$this->css_class_arr['form_field_cell_error'] = $class_name;
			}

	   /**
        * To get the css label class
        *
        * @param 		string $field_name form field
        * @return 		string
		* @access 		public
        */
		public function getCSSFormLabelCellClass($field_name)
			{
				$class_name = isset($this->fields_err_tip_arr[$field_name]) ? 'form_label_cell_error' : 'form_label_cell_default';
				return $this->css_class_arr[$class_name];
			}

	   /**
        * To get the css form field class
        *
        * @param 		string $field_name form field name
        * @return 		string
		* @access 		public
        */
		public function getCSSFormFieldCellClass($field_name)
			{
				$class_name = isset($this->fields_err_tip_arr[$field_name]) ? 'form_field_cell_error' : 'form_field_cell_default';
				return $this->css_class_arr[$class_name];
			}

	   /**
        * To check whether the form is posted
        *
        * @param 		array $post_arr
		* @param 		string $form_submit_name submit field name
        * @return 		array Array posted variables
		* @access 		public
        */
		public function isFormPOSTed($post_arr, $form_submit_name='')
			{
				return $form_submit_name ? isset($post_arr[$form_submit_name]) : $post_arr;
			}

	   /**
        * To check whether the form is geted
        *
        * @param 		array $get_arr
		* @param 		string $form_submit_name
        * @return 		array
		* @access 		public
        */
		public function isFormGETed($get_arr, $form_submit_name='')
			{
				return $form_submit_name ? isset($get_arr[$form_submit_name]) : $get_arr;
			}

		/**
		 * To check the page is geted or not
		 *
		 * @param 		array $get_arr
		 * @param 		string $var_name variable name
		 * @return 		boolean true/false
		 */
		public function isPageGETed($get_arr, $var_name='')
			{
				return $this->isFormGETed($get_arr, $var_name);
			}

	    /**
        * To santize the form fields
        *
        * @param 		array $request_arr GET/ POST
        * @return 		void
		* @access 		public
        */
		public function sanitizeFormInputs($request_arr) //GET or POST
			{
				global $smartyObj;
				foreach($this->fields_arr as $field_name=>$default_value)
					{
						if (isset($request_arr[$field_name]))
							{
								if (is_string($request_arr[$field_name]))
									{
										$this->fields_arr[$field_name] =htmlspecialchars( urldecode(trim($request_arr[$field_name])));

										$smartyObj->assign('field_value_'.$field_name, $this->fields_arr[$field_name]);
									}
								  else if (is_array($request_arr[$field_name]))
									{
										foreach($request_arr[$field_name] as $sub_key=>$sub_value)
											{
												$this->fields_arr[$field_name][$sub_key] =htmlspecialchars( urldecode(trim($sub_value)));
												$smartyObj->assign('field_value_'.$field_name.'__'.$sub_key, $this->fields_arr[$field_name][$sub_key]);
											}
									}
								  else //unexpected as of now. if occurred, make a note so as to fix.
								  		trigger_error('Developer Notice: Unexpected field type ('.gettype($request_arr[$field_name]).'). FormHandler needs fix.', E_USER_ERROR);
							}
						  else
						  	{
								$this->fields_arr[$field_name] = $default_value;
								$smartyObj->assign('field_value_'.$field_name, $this->fields_arr[$field_name]);
							}
					}
			}

	   /**
        * Function to get the sanitized form field seperately
        *
        * @return 		string sanitized form field value
		* @access 		public
		* @todo			Need to implement the coding for this method
        */
		public function getSanitizedFormField($field_name)
			{
				return htmlspecialchars(trim($this->fields_arr[$field_name]));
			}

		/**
		 * FormHandler::chkFileIsNotEmpty()
		 *
		 * @param mixed $field_name
		 * @param string $err_tip
		 * @return
		 */
		public function chkFileIsNotEmpty($field_name, $err_tip = '')
			{
				if(!isset($_FILES[$field_name]['name']))
					{
						$this->setFormFieldErrorTip($field_name, $err_tip);
						return false;
					}
				return true;
			}

		/**
		 * FormHandler::chkErrorInFile()
		 *
		 * @param mixed $field_name
		 * @param string $err_tip
		 * @return
		 */
		public function chkErrorInFile($field_name, $err_tip = '')
			{
				if($_FILES[$field_name]['error'])
					{
						$this->setFormFieldErrorTip($field_name, $err_tip);
						return false;
					}
				return true;
			}

		/**
		 * VideoUploadLib::chkValidFileType()
		 * To check valid video file
		 * @param mixed $field_name
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkValidFileType($field_name, $format_arr, $err_tip = '')
			{
				$extern = strtolower(substr($_FILES[$field_name]['name'], strrpos($_FILES[$field_name]['name'], '.')+1));
				if (!in_array($extern, $format_arr))
					{
						$this->setFormFieldErrorTip($field_name, $err_tip);
						return false;
					}
				return true;
			}

		/**
		 * VideoUploadLib::chkValidFileSize()
		 * To check video file size
		 * @param mixed $field_name
		 * @param string $err_tip
		 * @return
		 */
		public function chkValidFileSize($field_name, $allowed_size, $err_tip='')
			{
				if($this->CFG['admin']['videos']['max_size'])
					{
						$max_size = $allowed_size*1024*1024;
						if ($_FILES[$field_name]['size'] > $max_size)
							{
								$this->setFormFieldErrorTip($field_name, $err_tip);
								return false;
							}
					}
				return true;
			}

	   /**
        * To check whether the form field value is empty or not
        *
        * By calling this method, we can check the form field value is empty.
        * if it is empty, the error tip will diplay near the form field
        * with the error tip class
        *
        * @param 		string $field_name Form field name
		* @param 		string $err_tip Error tip
        * @return 		boolean true/false
		* @access 		public
        */
		public function chkIsNotEmpty($field_name, $err_tip='')
			{
				$is_ok = (is_string($this->fields_arr[$field_name])) ?
								($this->fields_arr[$field_name]!='') : (!empty($this->fields_arr[$field_name]));
				if (!$is_ok)
					{
						$this->setFormFieldErrorTip($field_name, $err_tip);
					}
				return $is_ok;
			}

	   /**
        * To check whether the form field value is numeric
        *
        * If it is numeric, return true otherwise false (does not accept string or real numbers)
        * if it is false, the error tip will diplay near the form field
        * with the error tip class
        *
        * @param 		string $field_name
		* @param 		string $err_tip
        * @return 		boolean true/false
		* @access 		public
        */
		public function chkIsNumeric($field_name, $err_tip='')
			{
				$is_ok = ctype_digit($this->fields_arr[$field_name]);
				if (!$is_ok)
					{
						$this->setFormFieldErrorTip($field_name, $err_tip);
					}
				return $is_ok;
			}

		/**
        * To check whether the form field value is numeric
        *
        * If it is numeric, return true otherwise false (does not accept string or real numbers)
        * if it is false, the error tip will diplay near the form field
        * with the error tip class
        *
        * @param 		string $field_name
		* @param 		string $err_tip
        * @return 		boolean true/false
		* @access 		public
        */
		public function chkIsNumericWithSymbol($field_name, $err_tip='')
			{
				$val = abs($this->fields_arr[$field_name]).'';
				$is_ok = ctype_digit($val);
				if (!$is_ok)
					{
						$this->setFormFieldErrorTip($field_name, $err_tip);
					}
				return $is_ok;
			}

		/**
		 * To check whether the form field value is real or not
		 *
		 * If it is real, return true otherwise false (does not accept string)
		 * if it is false, the error tip will diplay near the form field
         * with the error tip class
		 *
		 * @param 		string $field_name Form field name
		 * @param 		string $err_tip Error tip
		 * @return 		boolean true/false
		 * @access 		public
		 */
		public function chkIsReal($field_name, $err_tip='')
			{
				$is_ok = is_numeric($this->fields_arr[$field_name]);
				if (!$is_ok)
					{
						$this->setFormFieldErrorTip($field_name, $err_tip);
					}
				return $is_ok;
			}

	   /**
        * To check whether the form field value is string
        *
        * If it is string, return true otherwise false (does not accept numbers)
        * if it is false, the error tip will diplay near the form field
        * with the error tip class
        *
        * @param 		string $field_name form field name
		* @param 		string $err_tip error tip
        * @return 		boolean true/false
		* @access 		public
        */
		public function chkIsAlpha($field_name, $err_tip='')
			{
				$is_ok = ctype_alpha($this->fields_arr[$field_name]);
				if (!$is_ok)
					{
						$this->setFormFieldErrorTip($field_name, $err_tip);
					}
				return $is_ok;
			}

	   /**
        * To check whether the form field value is string or numbers
        *
        * If it is string or numbers, return true otherwise false (does not accept real numbers)
        * if it is false, the error tip will diplay near the form field
        * with the error tip class
        *
        * @param 		string $field_name form field name
		* @param 		string $err_tip error tip
        * @return 		boolean true/false
		* @access 		public
        */
		public function chkIsAlphaNumeric($field_name, $err_tip='')
			{
				$is_ok = ctype_alnum($this->fields_arr[$field_name]);
				if (!$is_ok)
					{
						$this->setFormFieldErrorTip($field_name, $err_tip);
					}
				return $is_ok;
			}

		/**
		 * FormHandler::chkIsNotNegative()
		 *
		 * @param mixed $field_name
		 * @param string $err_tip
		 * @return
		 */
		public function chkIsNotNegative($field_name, $err_tip='')
			{
				$is_ok = $this->fields_arr[$field_name]>=0;
				if (!$is_ok)
					{
						$this->setFormFieldErrorTip($field_name, $err_tip);
					}
				return $is_ok;
			}

	   /**
        * To check the email is valid or not
        *
        * This method is checking the email format for the email field
        * returns true if it is a valid format otherwise returns false
        * if it is false, the error tip will diplay near the form field
        * with the error tip class
        *
        * @param 		string $field_name form field name
		* @param 		string $err_tip error tip
		* @param 		string $is_chk_mxrr
        * @return 		boolean true/false
		* @access 		public
		* @todo			check mxrr
        */
		public function chkIsValidEmail($field_name, $err_tip='', $is_chk_mxrr=false)
			{
			//	$is_ok = (preg_match("/^.+@.+\..+$/i", $this->fields_arr[$field_name]));
				//echo "<br>filedName--->".$this->fields_arr[$field_name];
				$is_ok = (preg_match("/^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$/i", $this->fields_arr[$field_name]));
				if (!$is_ok)
					{
						$this->setFormFieldErrorTip($field_name, $err_tip);
					}
				//echo "return value--->".$is_ok;
				return $is_ok;
			}

		/**
        * To check the valid date
        *
        * @param 		string $field_name form field name
		* @param 		string $err_tip error tip
        * @return 		boolean true/false
		* @access 		public
        */
		public function chkIsValidDate($field_name, $err_tip='')
			{
				$array = explode(' ', $this->fields_arr[$field_name]);
				$date_arr = explode('-', $array[0]);
				$time_arr = array();
				if(isset($array[1]))
					{
						$time_arr = explode(':', $array[1]);
					}
				$is_ok = false;
				if((sizeof($array)==2 or sizeof($array)==1) and sizeof($date_arr)==3 and (sizeof($time_arr)==3 or sizeof($time_arr)==0))
					{
						$is_ok = true;
					}
				if($is_ok)
					{
						if(is_numeric($date_arr[0]) and is_numeric($date_arr[1]) and is_numeric($date_arr[2]) and checkdate($date_arr[1], $date_arr[2], $date_arr[0]))
							$is_ok = true;
						else
							$is_ok = false;
					}
				if($is_ok and sizeof($time_arr)==3)
					{
						if(is_numeric($time_arr[0]) and is_numeric($time_arr[1]) and is_numeric($time_arr[2]) and $time_arr[0]<24 and $time_arr[1]<60 and $time_arr[2]<60)
							$is_ok = true;
						else
							$is_ok = false;
					}
				if(!$is_ok)
					{
						$this->setFormFieldErrorTip($field_name, $err_tip);
					}
				return $is_ok;
			}

		/**
		 * FormHandler::getFormatedDate()
		 *
		 * @param mixed $date_input
		 * @param mixed $format
		 * @return
		 */
		public function getFormatedDate($date_input, $format)
			{
				$sql = 'SELECT DATE_FORMAT(NOW() , \''.$format.'\') AS df';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array());
				if (!$rs)
			 		trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $row['df'];
			}

		/**
		 * FormHandler::chkIsDateGreaterThanNow()
		 *
		 * @param mixed $field_name
		 * @param string $err_tip
		 * @return
		 */
		public function chkIsDateGreaterThanNow($field_name, $err_tip = '')
			{
				$sql = 'SELECT IF(DATE_FORMAT(NOW() , \'%Y-%m-%d\')<\''.$this->getFormField($field_name).'\',\'false\',\'true\') AS d';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();

				if($row['d']=='false')
					{
						$this->setFormFieldErrorTip($field_name, $err_tip);
						return false;
					}
				return true;
			}

		/**
		 * FormHandler::chkIsDateLesserThanNow()
		 *
		 * @param mixed $field_name
		 * @param string $err_tip
		 * @return
		 */
		public function chkIsDateLesserThanNow($field_name, $err_tip = '')
			{
				$sql = 'SELECT IF(DATE_FORMAT(NOW() , \'%Y-%m-%d\')>\''.$this->getFormField($field_name).'\',\'false\',\'true\') AS d';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();

				if($row['d']=='false')
					{
						$this->setFormFieldErrorTip($field_name, $err_tip);
						return false;
					}
				return true;
			}

		/**
		 * FormHandler::chkIsFromDateGreaterThanToDate()
		 * To check from date is greater than to date
		 *
		 * @param mixed $field_name form field name to display the error msg
		 * @param mixed $form_Date from date
		 * @param mixed $todate to date
		 * @param string $err_tip error message
		 * @return 	boolean
		 * @access 	public
		 */
		public function chkIsFromDateGreaterThanToDate($field_name, $form_Date, $todate, $err_tip = '')
			{
				if(strtotime($form_Date) > strtotime($todate))
					{
						$this->setFormFieldErrorTip($field_name, $err_tip);
						return false;
					}
				else
					{
						return true;
					}
			}

		/**
		 * FormHandler::chkIsDateDiff()
		 *
		 * @param mixed $from_field_name
		 * @param mixed $to_field_name
		 * @param string $err_tip
		 * @return
		 */
		public function chkIsDateDiff($from_field_name, $to_field_name, $err_tip = '')
			{
				$sql = 'SELECT IF(\''.$this->getFormField($to_field_name).'\'<\''.$this->getFormField($from_field_name).'\',\'false\',\'true\') AS d';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();

				if($row['d']=='false')
					{
						$this->setFormFieldErrorTip($from_field_name, $err_tip);
						$this->setFormFieldErrorTip($to_field_name, $err_tip);
						return false;
					}
				return true;
			}

	   /**
        * To check the URL is valid or not
        *
        * This method is checking the URL format for the URL field
        * returns true if it is a valid format otherwise returns false
        * if it is false, the error tip will diplay near the form field
        * with the error tip class
        *
        * @param 		string $field_name form field name
		* @param 		string $err_tip error tip
		* @param 		string $is_chk_real
        * @return 		boolean true/false
		* @access 		public
		* @todo 		improve regex. Add optional param as isvalidemail (real check)
        */
		public function chkIsValidURL($field_name, $err_tip='', $is_chk_real=false)
			{
				if (preg_match("/^[^@]*@[^@]*\.[^@]*$/", $this->fields_arr[$field_name])) {
				        $this->setFormFieldErrorTip($field_name, $err_tip);
				        return false;
				    }
				$is_ok = (preg_match("/^http.+\..+$/i", $this->fields_arr[$field_name]));
				if (!$is_ok)
					{
						$this->setFormFieldErrorTip($field_name, $err_tip);
					}
				return $is_ok;
			}

		/**
		 * FormHandler::chkIsValidURLRevised()
		 *
		 * @param mixed $field_name
		 * @param string $err_tip
		 * @return
		 */
		public function chkIsValidURLRevised($field_name, $err_tip='')
			{
				$start_url = "(http(s)?\:\/\/)?"; // start URL#
				$punten = "([\w_-]{2,}\.)+"; // een of meer delen met een . aan het einde
				$laatste_deel = "([\w_-]{2,})"; // laatste deel bevat geen punt
				$user = "((\/)(\~)[\w_-]+)?((\/)[\w_-]+)*"; // evt subdirectories - evt met user ~
				$eind = "((\/)|(\/)[\w_-]+\.[\w]{2,})?"; // evt eindigend op een slash of slash+file+extensie
				$qstring1 = "((\?[\w_-]+\=([^\#]+)){0,1}"; // querystring - eerste argument (?a=b)
				$qstring2 = "(\&[\w_-]+\=([^\#]+))*)?"; // querystring - volgende argumenten (&c=d)
				$bkmrk = "(#[\w_-]+)?"; // bookmark
				$regEx = "/^".$start_url.$punten.$laatste_deel.$user.$eind.$qstring1.$qstring2.$bkmrk."$/i";
				$is_ok = (preg_match($regEx, $this->fields_arr[$field_name]));
				if (!$is_ok)
					{
						$this->setFormFieldErrorTip($field_name, $err_tip);
						return false;
					}
				return true;
			}

	   /**
        * To check the valid phone number
        *
        * @param 		string $field_name form field name
		* @param 		string $err_tip error tip
		* @param 		string $regex phone number format
        * @return 		boolean true/false
		* @access 		public
		* @todo 		improve regex
        */
		public function chkIsValidPhoneNumber($field_name, $err_tip='', $regex="")
			{
				$is_ok = (preg_match($regex, $this->fields_arr[$field_name]));
				if (!$is_ok)
					{
						$this->setFormFieldErrorTip($field_name, $err_tip);
					}
				return $is_ok;
			}

		/**
		 * FormHandler::getActivationCode()
		 * used for get Activation code
		 *
		 * @param  string $code_for code for (it may be 'Signup', 'Forgotpass')
		 * @param  $content_id content id (It may be user id)
		 * @return string
		 * @access public
		 */
		public function getActivationCode($code_for, $content_id)
			{
				$this->deleteActivationCode($code_for, $content_id);
				$text = microtime().$content_id.$code_for;
				$start = rand(0, 22);
				$code = substr(md5($text), $start, 10);

				$sql = ' INSERT INTO '.$this->CFG['db']['tbl']['activation_code'].' SET'.
						' code = '.$this->dbObj->Param('code').','.
						' code_for = '.$this->dbObj->Param('code_for').','.
						' content_id = '.$this->dbObj->Param('content_id').','.
						' date_added = NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($code, $code_for, $content_id));
					if (!$rs)
						trigger_db_error($this->dbObj);

				return $code;
			}

		public function generateBBAToken()
			{
				$text = microtime();
				$start = rand(0, 24);
				return substr(md5($text), $start, 8);
			}

		/**
		 * FormHandler::deleteActivationCode()
		 * To delete the activation code
		 *
		 * @param  string $code_for code for (it may be 'Signup', 'Forgotpass')
		 * @param  $content_id content id (It may be user id)
		 * @return
		 * @access public
		 */
		public function deleteActivationCode($code_for, $content_id)
			{
				$sql = ' DELETE FROM '.$this->CFG['db']['tbl']['activation_code'].' WHERE'.
						' content_id = '.$this->dbObj->Param('content_id').' AND'.
						' code_for = '.$this->dbObj->Param('code_for');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($content_id, $code_for));
					if (!$rs)
						trigger_db_error($this->dbObj);
			}

		/**
		 * FormHandler::chkIsValidActivationCode()
		 * To check the activation code valid or not
		 *
		 * @param  string $code activation code to check
		 * @param  string $code_for code for (it may be 'Signup', 'Forgotpass')
		 * @param  $content_id content id (It may be user id)
		 * @return boolean
		 * @access public
		 */
		public function chkIsValidActivationCode($code, $code_for, $content_id = 0)
			{
				$add_sql = '';
				$data_arr[] = $code;
				$data_arr[] = $code_for;

				if($content_id)
					{
						$data_arr[] = $content_id;
						$add_sql = ' AND content_id = '.$this->dbObj->Param('content_id');
					}
				$sql = ' SELECT content_id FROM '.$this->CFG['db']['tbl']['activation_code'].' WHERE'.
						' code = '.$this->dbObj->Param('code').' AND'.
						' code_for = '.$this->dbObj->Param('code_for').$add_sql;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $data_arr);
					if (!$rs)
						trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						return $row['content_id'];
					}
				return false;
			}

		/**
        * To check the valid size
        *
        * @param 		string $field_name form field name
		* @param 		string $min_size minimum size
		* @param 		string $max_size maximum size
		* @param 		string $err_tip error tip
        * @return 		boolean true/false
		* @access 		public
		* @todo 		improve regex
        */
		public function chkIsValidSize($field_name, $cfg_variable, $err_tip='')
			{
				if($field_name == 'password')
					$size = mb_strlen($this->fields_arr[$field_name], $this->CFG['site']['charset']);
				else
					$size =  mb_strlen($this->fields_arr[$field_name], $this->CFG['site']['charset']);
				if($size<$this->CFG['fieldsize'][$cfg_variable]['min'] or $size>$this->CFG['fieldsize'][$cfg_variable]['max'])
					{
						$err_tip = str_replace('VAR_MIN', $this->CFG['fieldsize'][$cfg_variable]['min'], $err_tip);
						$err_tip = str_replace('VAR_MAX', $this->CFG['fieldsize'][$cfg_variable]['max'], $err_tip);
						$this->setFormFieldErrorTip($field_name, $err_tip);
						return false;
					}
				return true;
			}

		/**
        * To check the max valid size
        *
        * @param 		string $field_name form field name
		* @param 		string $min_size minimum size
		* @param 		string $max_size maximum size
		* @param 		string $err_tip error tip
        * @return 		boolean true/false
		* @access 		public
		* @todo 		improve regex
        */
		public function chkIsValidMaxSize($field_name, $cfg_variable, $err_tip='')
			{
				$size = mb_strlen($this->fields_arr[$field_name], $this->CFG['site']['charset']);
				if($size > $this->CFG['fieldsize'][$cfg_variable]['max'])
					{
						$err_tip = str_replace('VAR_MAX', $this->CFG['fieldsize'][$cfg_variable]['max'], $err_tip);
						$this->setFormFieldErrorTip($field_name, $err_tip);
						return false;
					}
				return true;
			}

	   /**
	    * To check the valid format
		*
	    * To check if the field has valid format. Check using regular expression.
	    *
	    * @param 		string $field_name form field name
	    * @param 		string $err_tip Error tip
	    * @param 		string $regex format
        * @return 		boolean true/false
		* @access 		public
	    */
	   	public function chkIsValidFormat($field_name, $err_tip='', $regex="")
	   		{
				$is_ok = (preg_match($regex, $this->fields_arr[$field_name]));
				if (!$is_ok)
					{
						$this->setFormFieldErrorTip($field_name, $err_tip);
					}
				return $is_ok;
			}

		/**
        * To get the form field error tip
        *
        * @param 		string $field_name form field name
        * @return 		string
		* @access 		public
        */
		public function setFormFieldErrorTip($field_name, $err_tip = '')
			{
				$this->fields_err_tip_arr[$field_name] = $err_tip;
			}

	   /**
        * To get the form field error tip
        *
        * @param 		string $field_name form field name
        * @return 		string
		* @access 		public
        */
		public function getFormFieldErrorTip($field_name, $display_empty_label = false)
			{
				if ($display_empty_label)
					{
						return (isset($this->fields_err_tip_arr[$field_name]) and $this->fields_err_tip_arr[$field_name]) ? '<label for="'.$field_name.'" generated="true" class="'.$this->css_class_arr['form_field_err_tip'].'">'.$this->fields_err_tip_arr[$field_name].'</label>' : '<label for="'.$field_name.'" generated="true" class="'.$this->css_class_arr['form_field_err_tip'].'" style="display:none;"></label>';
					}
				else
					{
						return (isset($this->fields_err_tip_arr[$field_name]) and $this->fields_err_tip_arr[$field_name]) ? '<label for="'.$field_name.'" generated="true" class="'.$this->css_class_arr['form_field_err_tip'].'">'.$this->fields_err_tip_arr[$field_name].'</label>' : '';
					}
			}

	   /**
        * To check the form inputs are valid
        *
        * If the error tip and error message are not set, returns true
        * otherwise false
        *
        * @return 		boolean 0/1
		* @access 		public
        */
		public function isValidFormInputs()
			{
				return (!$this->fields_err_tip_arr && !$this->common_error_message); //or !count($this->fields_err_tip_arr) && !$this->common_error_message;
			}

       /**
        * To set the array of countries list
        *
        * @param 		array $country_list_arr array of countries
        * @param 		array $first_option_arr default selected value in select box
        * @return 		void
		* @link 		http://in2.php.net/operators.array
        */
		public function setCountriesListArr($countries_list_arr, $first_option_arr=array())
			{
				$this->countries_list_arr = $first_option_arr + $countries_list_arr;
			}

	   /**
        * To populate the countries list
        *
        * @param 		array $highlight_country selected country value
        * @return 		void
		* @access 		public
        */
		public function populateCountriesList($highlight_country)
			{
				foreach($this->countries_list_arr as $abbrev=>$country_name)
					{
?>
	<option value="<?php echo $abbrev;?>"<?php echo ($highlight_country==$abbrev)? ' selected="selected"' : '';?>><?php echo $country_name;?></option>
<?php
					}
			}

		/**
		 * FormHandler::populateUserCountriesList()
		 * To provide the drop down of countries list for searching with only
		 * the country names from the users table along with the no of users in
		 *
		 *
		 * @param string $highlight_country
		 * @return void prints the drop down with country name and no of users
		 */
		public function populateUserCountriesList($highlight_country)
			{
				$sql = 'SELECT count(user_id) as tot_count, country FROM '.
						 $this->CFG['db']['tbl']['users'].
					   ' WHERE usr_status = \'Ok\' GROUP BY country ORDER BY tot_count';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array());
				if (!$rs)
					trigger_db_error($this->dbObj);
?>
			<option value='' <?php echo ($highlight_country=='')? ' selected="selected"' : '';?>><?php echo $this->LANG['search_country_choose']; ?></option>
<?php
				while($row = $rs->FetchRow())
					{
						if(isset($this->countries_list_arr[$row['country']]))
							{
								$abbrev  		= $row['country'];
								$country_name 	= $this->countries_list_arr[$row['country']].' ('.$row['tot_count'].')';
?>
			<option value="<?php echo $abbrev;?>"<?php echo ($highlight_country==$abbrev)? ' selected="selected"' : '';?>><?php echo $country_name;?></option>
<?php
							}
					}

			}


		/**
		 * To populate the days list
		 *
		 * @param 		integer $highlight_d high lighted date
		 * @return 		void
		 * @access 		public
		 */
		public function populateDaysList($highlight_d)
			{
				for($d=1; $d<=31; ++$d)
					{
?>
	<option value="<?php echo $d;?>"<?php echo($highlight_d==$d)? ' selected="selected"' : '';?>><?php echo $d;?></option>
<?php
					}
			}

		/**
		 * To set the array of months
		 *
		 * @param 		array $months_list_arr array of months
		 * @param 		array $first_option_arr default selected value
		 * @return 		void
		 * @access 		public
		 */
		public function setMonthsListArr($months_list_arr, $first_option_arr=array())
			{
				$this->months_list_arr = $first_option_arr + $months_list_arr;
			}

		/**
		 * To populate the array months list
		 *
		 * @param 		integer $highlight_m high lighted month
		 * @return 		void
		 * @access 		public
		 */
		public function populateMonthsList($highlight_m)
			{
				foreach($this->months_list_arr as $key=>$month_name)
					{
?>
	<option value="<?php echo $key;?>"<?php echo ($highlight_m==$key)? ' selected="selected"' : '';?>><?php echo $month_name;?></option>
<?php
					}
			}

		/**
		 * To set the minium and maximum year list
		 *
		 * @param 		integer $min_year minimum year
		 * @param 		integer $max_year maximum year
		 * @return		void
		 * @access 		public
		 */
		public function setYearsListMinMax($min_year, $max_year)
			{
				$this->years_list_config['min_year'] = $min_year;
				$this->years_list_config['max_year'] = $max_year;
			}

		/**
		 * To populate the year list
		 *
		 * @param 		integer $highlight_y high lighted year
		 * @return 		void
		 * @access 		public
		 */
		public function populateYearsList($highlight_y)
			{
				for($y=$this->years_list_config['min_year']; $y<=$this->years_list_config['max_year']; ++$y)
					{
?>
	<option value="<?php echo $y;?>"<?php echo($highlight_y==$y)? ' selected="selected"' : '';?>><?php echo $y;?></option>
<?php
					}
			}

		/**
		 * FormHandler::setDBObject()
		 * To connect database
		 *
		 * @param $dbObj
		 * @return
		 **/
		public function setDBObject($dbObj)
			{
				$this->dbObj = $dbObj;
			}

		/**
		 * FormHandler::includeHeader()
		 *
		 * @param mixed $assign_var
		 * @return
		 */
		public function includeHeader($assign_var = true)
			{
				global $CFG, $smartyObj;
				if($assign_var)
					{
						$this->assignSmartyVariables();
					}
				$CFG['mods']['is_include_only']['html_header'] = true;
				$CFG['html']['is_use_header'] = true;
				$url_arr = explode('/', $_SERVER['REQUEST_URI']);
				if(!in_array('admin', $url_arr))
				{
					setTemplateFolder('general/');
        			$smartyObj->display('config_include.tpl');
        		}
        		else
        		{
        			setTemplateFolder('admin/');
        			$smartyObj->display('config_include.tpl');
				}
				require($CFG['site']['project_path'].'common/application_top.inc.php');
			}


		/**
		 * FormHandler::includePopUpHeader()
		 *
		 * @return
		 */
		public function includePopUpHeader()
			{
				global $CFG, $smartyObj;
				$this->assignSmartyVariables();
				$CFG['mods']['is_include_only']['html_header'] = false;
				$CFG['html']['is_use_header'] = false;
				setTemplateFolder('general/');
        		$smartyObj->display('config_include.tpl');
			}

		/**
		 * FormHandler::includeAjaxHeader()
		 *
		 * @param mixed $assign_var
		 * @return
		 */
		public function includeAjaxHeader($assign_var = true)
			{
				global $CFG, $smartyObj;
				if($assign_var)
					{
						$this->assignSmartyVariables();
					}
				$url_arr = explode('/', $_SERVER['REQUEST_URI']);
				
				if(!in_array('admin', $url_arr))
				{
					setTemplateFolder('general/');
        			$smartyObj->display('config_include.tpl');
        		}
				else
				{	
					//setHeaderStart();
					setTemplateFolder('admin/');
        			$smartyObj->display('config_include.tpl');
				}
			}

		/**
		 * FormHandler::includeAjaxHeaderSessionCheck()
		 *
		 * @param mixed $assign_var
		 * @return
		 */
		public function includeAjaxHeaderSessionCheck($assign_var = true)
			{
				global $CFG, $smartyObj;
				if($assign_var)
					{
						$this->assignSmartyVariables();
					}
				setHeaderStart(true);
				setTemplateFolder('general/');
        		$smartyObj->display('config_include.tpl');
			}

		/**
		 * FormHandler::includeFooter()
		 *
		 * @return
		 */
		public function includeFooter()
			{
				global $CFG, $smartyObj, $DEBUG_TRACE, $SQL_QUERIES;
				require_once($this->CFG['site']['project_path'].'common/application_bottom.inc.php');
			}

		/**
		 * FormHandler::includeAjaxFooter()
		 *
		 * @return
		 */
		public function includeAjaxFooter()
			{
				setHeaderEnd();
				exit;
?>
				<script type="text/javascript">
					helpTipInitialize();
				</script>
<?php
			}

		/**
		 * FormHandler::includeRssHeader()
		 *
		 * @param mixed $assign_var
		 * @return
		 */
		public function includeRssHeader($assign_var = true)
			{
				global $CFG, $smartyObj;
				if($assign_var)
					{
						$this->assignSmartyVariables();
					}
			}

		/**
		 * FormHandler::includeRssFooter()
		 *
		 * @return
		 */
		public function includeRssFooter()
			{
				setHeaderEnd();
				exit;
			}

		/**
		 * FormHandler::includeIframeHeader()
		 *
		 * @return
		 */
		public function includeIframeHeader()
			{
				global $CFG, $smartyObj;
				ob_start();
				header("Pragma: no-cache");
				header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
				header("Expires: 0"); // Date in the past
				header("Content-type: text/html; charset=\"".$CFG['site']['charset']."\"");
			}

		/**
		 * FormHandler::includeIframeFooter()
		 *
		 * @return
		 */
		public function includeIframeFooter()
			{
				setHeaderEnd();
				exit;
			}
		/**
		 * FormHandler::setDBObject()
		 * contain all header and common functions
		 *
		 * @param $headerfrm
		 * @return
		 **/
		public function setHeaderObject($headerfrm)
			{
				$this->headerfrm = $headerfrm;
			}

		/**
		 * FormHandler::makeGlobalize()
		 * make globalize the $CFG and $LANG
		 *
		 * @param array $CFG
		 * @param array $LANG
		 * @return
		 **/
		public function makeGlobalize($CFG = array(), $LANG = array())
			{
				$this->CFG = $CFG;
				$this->LANG = $LANG;
			}

		/**
		 * FormHandler::displayTemplateSwitcher()
		 *
		 * @return
		 */
		public function displayTemplateSwitcher()
			{
				global $smartyObj;

				//Multi-language support
				if ($this->CFG['html']['template']['is_template_support'])
					{
						$this->displayTemplateSwitcher_arr['default_template_img'] = $this->CFG['site']['url'].'design/css/themes/'.$this->CFG['html']['template']['default'].'_'.$this->CFG['html']['stylesheet']['screen']['default'].'.jpg';
						setTemplateFolder('general/');
        				$smartyObj->display('displayTemplateSwitcher.tpl');
					}
			}

		/**
		 * FormHandler::getReferrerUrl()
		 *
		 * @return
		 **/
		public function getReferrerUrl($not_allowed_pages = array(), $alternate_back_url = '', $add_query_string = '')
			{
				if(!$this->fields_arr['backkey'])
					{
						$allowed = true;
						if(isset($_SERVER['HTTP_REFERER']))
							{
								$allowed = false;
								foreach($not_allowed_pages as $key=>$value)
									{
										if(strstr($_SERVER['HTTP_REFERER'],$value))
											{
												$allowed = true;
												break;
											}
									}
							}
						if($allowed)
							{
								$key = substr(md5(microtime()),0,10);
								$_SESSION['backkey'][$key] = $alternate_back_url;
								$this->fields_arr['backkey'] = $key;
								return;
							}
						else
							{
								$key = substr(md5(microtime()),0,10);
								if($add_query_string)
									{
										if(strstr($_SERVER['HTTP_REFERER'], '?'))
											$add_query_string = '&'.$add_query_string;
										else
											$add_query_string = '?'.$add_query_string;
									}
								$_SESSION['backkey'][$key] = $_SERVER['HTTP_REFERER'].$add_query_string;
								$this->fields_arr['backkey'] = $key;
							}
					}
			}

		/**
		 * FormHandler::chkIsReffererUrl()
		 *
		 * @return
		 */
		public function chkIsReffererUrl()
			{
				if($this->fields_arr['backkey'])
					{
						if($_SESSION['backkey'][$this->fields_arr['backkey']])
							return ($_SESSION['backkey'][$this->fields_arr['backkey']]);
					}
			}

		/**
		 * FormHandler::redirecturl()
		 *
		 * @return
		 **/
		public function redirectReferrerUrl()
			{
				if($this->fields_arr['backkey'])
					{
						if($_SESSION['backkey'][$this->fields_arr['backkey']])
							Redirect2URL($_SESSION['backkey'][$this->fields_arr['backkey']]);
					}
			}

		/**
		 * FormHandler::populateHidden()
		 *
		 * @param mixed $hidden_field
		 * @param mixed $id
		 * @return
		 */
		public function populateHidden($hidden_field, $id=true)
			{
				foreach($hidden_field as $hidden_name)
					{
?>
						<input type="hidden" <?php if($id){?>id="<?php echo $hidden_name;?>" <?php }?>name="<?php echo $hidden_name;?>" value="<?php echo isset($this->fields_arr[$hidden_name])?$this->fields_arr[$hidden_name]:'';?>" />
<?php
					}
			}

		/**
		 * FormHandler::generalPopulateArray()
		 *
		 * @param mixed $list
		 * @param string $highlight_value
		 * @return
		 */
		public function generalPopulateArray($list, $highlight_value='')
			{
				foreach($list as $key => $value)
					{
						$selected = trim($highlight_value) == trim($key)?' selected="selected"':'';
?>
<option value="<?php echo $key;?>"<?php echo $selected;?>><?php echo $value;?></option>
<?php
					}
			}

		/**
		 * FormHandler::populateBWNumbers()
		 *
		 * @param mixed $start_no
		 * @param mixed $end_no
		 * @param string $highlight_value
		 * @return
		 */
		public function populateBWNumbers($start_no, $end_no, $highlight_value='')
			{
				if ($start_no>$end_no)
					{
						for($start_no;$start_no>=$end_no;$start_no--)
							{
								$selected = $highlight_value == $start_no?' selected':'';
?>
<option value="<?php echo $start_no;?>"<?php echo $selected;?>><?php echo $start_no;?></option>
<?php
							}
				    }
				else
					{
						for($start_no;$start_no<=$end_no;$start_no++)
							{
								$selected = $highlight_value == $start_no?' selected':'';
?>
<option value="<?php echo $start_no;?>"<?php echo $selected;?>><?php echo $start_no;?></option>
<?php
							}
					}
			}

		/**
		 * FormHandler::isCheckedCheckBox()
		 *
		 * @param $field_name
		 * @return
		 **/
		public function isCheckedCheckBox($field_name)
			{
				if($this->fields_arr[$field_name])
					return ' checked="checked"';
			}

		/**
		 * FormHandler::isCheckedCheckBox()
		 *
		 * @param $field_name
		 * @return
		 **/
		public function isCheckedCheckBoxArray($field_name, $value)
			{
				if(in_array($value,$this->fields_arr[$field_name]))
					return ' checked="checked"';
			}

		/**
		 * FormHandler::isCheckedRadio()
		 *
		 * @param $field_name
		 * @param $value
		 * @return
		 **/
		public function isCheckedRadio($field_name, $value)
			{
				if($this->fields_arr[$field_name] == $value)
					return ' checked="checked"';
			}

		/**
		 * FormHandler::ShowHelpTip()
		 *
		 * @param $tip_key
		 * @param $tip_for
		 * @return
		 **/
		public function ShowHelpTip($tip_key = '', $tipfor = '')
			{
				$tipfor = $tipfor?$tipfor:$tip_key;
				$tip = isset($this->LANG['help'][$tip_key])?$this->LANG['help'][$tip_key]:$tip_key;
				$tip    = str_replace("\n", '&#13;', $tip);
				$tip    = $this->buildDisplaytext($tip);
?>
<div class="clsHelpText" id="<?php echo $tipfor;?>_Help" style="display:none"><?php echo $tip;?></div>
<?php
				//ShowHelpTip($tip_key, $tip_for);
			}

		/**
		 * FormHandler::buildDisplayText()
		 *
		 * @param mixed $text
		 * @param array $replace_arr
		 * @return
		 */
		public function buildDisplayText($text, $replace_arr = array())
			{
				//can add elements to tha array as needed..
				$seo_title_arr = array( 'VAR_SITE_NAME' => $this->CFG['site']['name'],
										'VAR_SITE_URL'  => $this->CFG['site']['url']
									  );
				$seo_title_arr = array_merge($seo_title_arr, $replace_arr);
				foreach($seo_title_arr as $search => $replace)
					{
						$text = str_replace($search, $replace, $text);
					}
				return $text;
			}

		/**
		 * FormHandler::chkBrowserForEditor()
		 *
		 * @return
		 */
		public function chkBrowserForEditor()
			{
				global $CFG;
				if($this->CFG['feature']['html_editor'] == 'textarea')
					{
						return;
					}
				if($this->CFG['feature']['html_editor'] == 'tinymce')
					{
						return;
					}
				if(!isset($_SERVER['HTTP_USER_AGENT']))
					{
						return;
					}
				$server = $_SERVER['HTTP_USER_AGENT'];
				$pattern = "/AppleWebKit/";
				$pattern1 = "/Opera/";
				if(preg_match($pattern, $server) || preg_match($pattern1,$server))
					{
						$CFG['feature']['html_editor'] = 'textarea';
						$this->CFG['feature']['html_editor'] = 'textarea';
					}
			}

		/**
		 * FormHandler::populateRichTextEdit()
		 *
		 * @param $field_name
		 * @param $value
		 * @param $useHtmlSpChars
		 * @return
		 **/
		public function populateHtmlEditor($field_name='', $advanced=false)
			{
				switch($this->CFG['feature']['html_editor'])
					{
						case 'richtext':
							populateRichTextEdit($field_name, $this->getFormField($field_name), $this->isValidFormInputs());
							break;

						case 'wysiwyg':
							populateWYSIWYGeditor($field_name, $this->getFormField($field_name));
							break;

						case 'tinymce':
								if($advanced)
									{
										populateTinyMceEditor($field_name, $this->getFormField($field_name));
									}
								else
									{
										populateSimpleTinyMceEditor($field_name, $this->getFormField($field_name));
									}

							break;
					}
			}

		/**
		 * FormHandler::getUrl()
		 *
		 * @param $file_name
		 * @param $normal
		 * @param $htaccess
		 * @param $change
		 * @return
		 **/
		public function getUrl($file_name, $normal = '', $htaccess = '', $change = '',$module='')
			{
				return getUrl($file_name, $normal, $htaccess, $change,$module);
			}

		/**
		 * FormHandler::getCurrentUrl()
		 *
		 * @param mixed $with_query_string
		 * @return
		 */
		public function getCurrentUrl($with_query_string = true)
			{
				return getCurrentUrl($with_query_string);
			}

		/**
		 * FormHandler::populateDateCalendar()
		 *
		 * @param mixed $textbox_id
		 * @param array $calendar_params_array
		 * @return
		 */
		public function populateDateCalendar($textbox_id, $calendar_params_array = array())
			{
				$init_params_array  =  array('dateFormat' => 'yy-mm-dd',
											 'showOn'     => 'button',
											 'buttonText' => '...',
											 'changeMonth'=> 'true',
											 'changeYear' => 'true',
											 'minDate'    => '',
											 'maxDate'    => '',
											 'yearRange'  => ''
											);
				//if the parameters  are not , set the default ones ..
				foreach($init_params_array as $key => $value)
				{
					if(!isset($calendar_params_array[$key]))
					{
						$calendar_params_array[$key] = $value;
					}
				}
				$date_res = '';
				if ($calendar_params_array['minDate'] != '')
				{
					$date_res = ','.'minDate: \''.$calendar_params_array['minDate'].'\'';
				}
				if ($calendar_params_array['maxDate'] != '')
				{
					$date_res .= ','.'maxDate: \''.$calendar_params_array['maxDate'].'\'';
				}
				if ($calendar_params_array['yearRange'] != '')
				{
					$date_res .= ','.'yearRange: \''.$calendar_params_array['yearRange'].'\'';
				}


?>
<script type="text/javascript">
   $Jq(function() {
		$Jq('#<?php echo $textbox_id?>').datepicker({
			closeText: lang_js_datapicker_arr['closeText'],
			prevText: lang_js_datapicker_arr['prevText'],
			nextText: lang_js_datapicker_arr['nextText'],
			monthNamesShort: monthNamesShort_arr,
			duration:'fast',
			dateFormat: '<?php echo $calendar_params_array['dateFormat']?>',
			showOn: '<?php echo $calendar_params_array['showOn']?>',
			buttonText: '<?php echo $calendar_params_array['buttonText']?>',
			changeMonth: <?php echo $calendar_params_array['changeMonth']?>,
			changeYear: <?php echo $calendar_params_array['changeYear']?>
			<?php echo $date_res; ?>
		});
	});
</script>
<?php
			}

		/**
		 * FormHandler::populateCalendar()
		 *
		 * @param mixed $textbox_id
		 * @param mixed $button_id
		 * @param mixed $show_time
		 * @return
		 */
		public function populateCalendar($textbox_id, $button_id, $show_time = false)
			{
				//empty method to be configured ...
			}

		/**
		 * FormHandler::fetchCached()
		 *
		 * @param $cache_id
		 * @param $life_time
		 * @return
		 **/
		public function fetchCached($cache_id, $life_time = 60)
			{
				if($this->CFG['feature']['data_cache']['mechanism'] == 'agcache')
					{
						$result = AgCache::fetch($cache_id, $life_time);
					}
				if($result)
					{
						if ($this->CFG['feature']['data_cache']['compress'] and isset($_SERVER['HTTP_ACCEPT_ENCODING']) and strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
							{
								$result = gzuncompress($result);
							}
						$result = unserialize($result);
					}
				return $result;
			}

		/**
		 * FormHandler::saveCached()
		 *
		 * @param $cache_id
		 * @param $content
		 * @return
		 **/
		public function saveCached($cache_id, $content)
			{
				$content = serialize($content);
				if ($this->CFG['feature']['data_cache']['compress'] and isset($_SERVER['HTTP_ACCEPT_ENCODING']) and strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
					{
						$content = gzcompress($content, $this->CFG['feature']['data_cache']['compress_level']);
					}
				if($this->CFG['feature']['data_cache']['mechanism'] == 'agcache')
					{
						AgCache::save($cache_id, $content);
					}
			}

		/**
		 * FormHandler::getSwiftConnection()
		 *
		 * @return
		 **/
		public function getSwiftConnection()
		 	{
				Swift_LogContainer::getLog()->setLogLevel(Swift_Log::LOG_EVERYTHING);
			    switch ($this->CFG['admin']['mailer']['mailer'])
				    {
				      case "smtp":
				        $enc = null;
				        $test_enc = $this->CFG['admin']['mailer']['smtp_encryption'];
				        if ($test_enc == "ssl") $enc = Swift_Connection_SMTP::ENC_SSL;
				        elseif ($test_enc == "tls") $enc = Swift_Connection_SMTP::ENC_TLS;
				        $conn = new Swift_Connection_SMTP($this->CFG['admin']['mailer']['host'], $this->CFG['admin']['mailer']['port'], $enc);
				        if ($user = $this->CFG['admin']['mailer']['username']) $conn->setUsername($user);
				        if ($pass = $this->CFG['admin']['mailer']['password']) $conn->setPassword($pass);
				        return $conn;
				      case "sendmail":
				        $conn = new Swift_Connection_Sendmail($this->CFG['admin']['mailer']['sendmail_path']);
				        return $conn;
				      case "nativemail":
				        $conn = new Swift_Connection_NativeMail();
				        return $conn;
				    }
		  	}

		/**
		 * FormHandler::getUserDetail()
		 *
		 * @param $user_unique_identifier
		 * @param $column_name
		 * @param $column_value
		 * @param $return_column_name
		 * @return
		 **/
		public function getUserDetail($column_name, $column_value, $return_column_name = '')
			{
				return getUserDetail($column_name, $column_value, $return_column_name);
			}

		/**
		 * FormHandler::checkUserPermission()
		 *
		 * @param mixed $user_actions
		 * @param mixed $action
		 * @param string $sub_action
		 * @return
		 */
		public function checkUserPermission($user_actions, $action, $sub_action = '')
			{
				return checkUserPermission($user_actions, $action, $sub_action);
			}

		/**
		 * FormHandler::getUserImagePath()
		 *
		 * @param mixed $user_detail
		 * @param string $size
		 * @return
		 */
		public function getUserImagePath($user_detail, $size = 'T')
			{
				$T = 'thumb';
				$L = 'large';
				$M = 'medium';
				$S = 'small';
				$size_name = $this->CFG['profile']['image_'.$$size.'_name'];
				if(isset($user_detail['image_name']) and $user_detail['image_name'])
					{
						return $this->CFG['site']['url'].$this->CFG['profile']['image_folder'].$user_detail['image_name'].$size_name.'.'.$user_detail['image_ext'];
					}
				return $this->CFG['site']['url'].'design/templates/'.$this->CFG['html']['template']['default'].'/images/noImage_'.$size_name.'.jpg';
			}

		/**
	     * FormHandler::DISP_IMAGE()
	     *
	     * @param integer $cfg_width
	     * @param integer $cfg_height
	     * @param integer $img_width
	     * @param integer $img_height
	     * @return
	     */
	    public function DISP_IMAGE($cfg_width = 0, $cfg_height = 0, $img_width = 0, $img_height = 0)
		    {
		        return DISP_IMAGE($cfg_width, $cfg_height, $img_width, $img_height);
		    }

		/**
		 * FormHandler::getTableData()
		 *
		 * @param mixed $text
		 * @return
		 */
		public function getTableData($text)
			{
				return ($text!='')?nl2br($text):'&nbsp;';
			}

		/**
		 * FormHandler::includeJSLanguageFile()
		 *
		 * @return
		 */
		public function includeJSLanguageFile()
			{
				$cache_file_name = 'jslanguage_'.$this->CFG['lang']['default'];
				$language = $this->fetchCached($cache_file_name, $this->CFG['javascript']['language_cache_time']);
				if(!$language)
					{
						require($this->CFG['site']['project_path'].'languages/'.$this->CFG['lang']['default'].'/general/js.php');
						$language .= 'var JS_LANG = new Array();';
						foreach($LANG['js'] as $key=>$value)
							{
								$language .= 'JS_LANG[\''.$key.'\'] = \''.addslashes($value).'\';';
							}
						$this->saveCached('$cache_file_name', $language);
					}
				echo '<script type="text/javascript">'.$language.'</script>';
			}

		/**
		 * FormHandler::chkAllowedModule()
		 *
		 * @param array $module
		 * @return
		 */
		public function chkAllowedModule($module = array())
			{
				if($this->CFG['feature']['phpgacl_module_control'])
					{
						foreach($module as $key=>$value)
							{
								if(!$this->aclCheck($value))
									{
										return false;
									}
							}
						return true;
					}
				return chkAllowedModule($module);
			}

		/**
		 * To get unread mail in inbox
		 *
		 * @access public
		 * @return void
		 **/
		public function countUnReadMail()
			{
				$sql = 'SELECT COUNT( mi.info_id ) AS mail_count'.
						' FROM '.$this->CFG['db']['tbl']['messages'].' AS ms,'.
						' '.$this->CFG['db']['tbl']['messages_info'].' AS mi'.
						' WHERE mi.to_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
						' AND mi.message_id = ms.message_id'.
						' AND mi.to_viewed = \'No\''.
						' AND mi.to_delete = \'No\''.
						' AND mi.to_stored = \'No\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();

				return $row['mail_count'];
			}

		/**
		 * FormHandler::displayCompulsoryIcon()
		 *
		 * @return
		 */
		public function displayCompulsoryIcon()
			{
?>
<span class="clsMandatoryFieldIcon">*</span>
<?php
			}

		/**
		 * FormHandler::searchJavaScriptCode()
		 *
		 * @return
		 */
		public function searchJavaScriptCode()
			{
				searchJavaScriptCode();
			}

		/**
		 * FormHandler::chkThisUserAllowedToPostArticle()
		 *
		 * @return void
		 */
		public function chkThisUserAllowedToPostArticle()
			{
				if(isset($this->_article_upload))
					return $this->_article_upload;

				if($this->CFG['admin']['is_logged_in'])
					return $this->_article_upload = true;

				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['users'].' WHERE allow_article=\'Yes\''.
						' AND user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					return $this->_article_upload = true;
				return $this->_article_upload = false;
			}

		/**
		 * FormHandler::chkIsValidHoneyPot()
		 *
		 * @param  string $field_name
		 * @return boolean
		 * @access public
		 */
		public function chkIsValidHoneyPot($field_name)
			{
				if(phFormulaRayzz() and isset($this->fields_arr[phFormulaRayzz()]) and (!$this->fields_arr[phFormulaRayzz()]))
					return true;
				else
					{
						$this->fields_err_tip_arr[$field_name] = 'Invalid';
						return false;
					}
			}

		/**
		 * EditProfileFormHandler::chkIsCorrectDate()
		 * Verifies the date value
		 *
		 * @param string $date date
		 * @param string $month month
		 * @param string $year year
		 * @param string $field form field for the date
		 * @param $err_tip error tip
		 * @return
		 **/
		public function chkIsCorrectDate($date=0, $month=0, $year=0, $console_date_field='', $err_tip_empty='', $err_tip_invalid='')
			{
				if (empty($date) or empty($month) or empty($year))
				    {
						$this->fields_err_tip_arr[$console_date_field] = $err_tip_empty;
						return false;
				    }
				if (checkdate(intval($month), intval($date), intval($year)))
				    {
					  $this->fields_arr[$console_date_field] = $year.'-'.$month.'-'.$date;
				       return true;
				    }
				else
					{
						$this->fields_err_tip_arr[$console_date_field] = $err_tip_invalid;
						return false;
					}
			}

		/**
		 * FormHandler::chkAndCreateFolder()
		 * if the parent directiory not there means surely not child directory for that only use the mode
		 * inorder to avoid to call the anothere function
		 *
		 * @param string $folderName
		 * @return void
		 * @access public
		 **/
		public function chkAndCreateFolder($folderName)
			{
				$folder_arr = explode('/', $folderName);
				$folderName = '';
				foreach($folder_arr as $key=>$value)
					{
						$folderName .= $value.'/';
						if($value == '..' or $value == '.')
							continue;
						if (!is_dir($folderName))
							{
								mkdir($folderName);
								@chmod($folderName, 0777);
							}
					}
			}

		/*
		Now we we are using the changeTitle that is below this function
		public function changeTitle($title)
			{
				return ereg_replace ('[^a-zA-Z0-9]', '_', $title);
			}
		*/

		/**
		 * FormHandler::changeTitle()
		 *
		 * @param mixed $title
		 * @return
		 */
		public function changeTitle($title)
			{
				return getSeoTitle($title);
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function checkAndRenameString($table_name, $primary_key_field, $to_field_name, $str)
			{
				$sql_sub_sub = 'SELECT COUNT('.$primary_key_field.') as cnt FROM '.$table_name.' WHERE
								'.$to_field_name.' = '.$this->dbObj->Param($str);

				$stmt_sub_sub = $this->dbObj->Prepare($sql_sub_sub);
				$rs_sub_sub = $this->dbObj->Execute($stmt_sub_sub, array($str));
				//raise user error... fatal
				if (!$rs_sub_sub)
						trigger_db_error($this->dbObj);
				$row_sub_sub = $rs_sub_sub->FetchRow();
				if ($row_sub_sub['cnt'] > 0)
					return true;
				return false;
			}

		/**
		 * FormHandler::populateBlogPost()
		 *
		 * @param $url
		 * @param $title
		 * @return
		 **/
		public function populateBlogPost($url, $title, $title_link='')
			{
				global $CFG;
				global $smartyObj;
				$return = array();
				$return['url']=$url;
				$return['title']=$title;
				//removed the else part since we have only provided option for addthis alone
				if(isset($CFG['site']['bookmark']['addthis_enabled'] ) and $CFG['site']['bookmark']['addthis_enabled'] )
					{
						$CFG['site']['bookmark']['addthis_account'] =(isset($CFG['site']['bookmark']['addthis_account'] ))?$CFG['site']['bookmark']['addthis_account'] :'webmaster';
						$return['site_arr_str']=(isset($CFG['site']['bookmark']['addthis_sites']) and is_array($CFG['site']['bookmark']['addthis_sites']))?implode(',',$CFG['site']['bookmark']['addthis_sites']):'favorites, digg, delicious, google, myspace, facebook, reddit, newsvine, live, more';
						$return['buttom_image']=(isset($CFG['site']['bookmark']['addthis_button_image'] ) and $CFG['site']['bookmark']['addthis_button_image'] )?$CFG['site']['bookmark']['addthis_button_image'] :'http://s9.addthis.com/button1-share.gif';
						$return['title_link']=$title_link;
						$smartyObj->assign('blogPost', $return);
						setTemplateFolder('general/');
						$smartyObj->display('bookmarkShare.tpl');
					}
			}

		/**
		 * FormHandler::hpSolutionsRayzz()
		 *
		 * @return
		 */
		public function hpSolutionsRayzz()
			{
				return hpSolutionsRayzz();
			}

		/**
		 * FormHandler::phFormulaRayzz()
		 *
		 * @return
		 */
		public function phFormulaRayzz()
			{
				return 	phFormulaRayzz();
			}

		/**
		 * FormHandler::getAffiliateUrl()
		 *
		 * @param string $url
		 * @return
		 */
		public function getAffiliateUrl($url = '')
			{
				if(isloggedIn())
					{
						if(strpos($url, '?'))
							return $url.'&'.$this->CFG['admin']['referrer_query_string'].'='.$this->CFG['user']['user_name'];
						else
							return $url.'?'.$this->CFG['admin']['referrer_query_string'].'='.$this->CFG['user']['user_name'];
					}
				return $url;
			}

		/**
		 * FormHandler::getDateTimeDiff()
		 *
		 * @param mixed $date
		 * @param mixed $today
		 * @return
		 */
		public function getDateTimeDiff($date,$today)
			{
				return getDateTimeDiff($date,$today);
			}

		/**
		 * FormHandler::isMe()
		 *
		 * @param mixed $user_id
		 * @return
		 */
		public function isMe($user_id)
			{
				if(!isMember())
					return false;

				if($user_id == $this->CFG['user']['user_id'])
					return true;
				return false;
			}

		/**
		 * FormHandler::setTemplateFolder()
		 *
		 * @param mixed $template
		 * @param string $module
		 * @return
		 */
		public function setTemplateFolder($template,$module='')
			{
				setTemplateFolder($template,$module);
			}

		/**
		 * FormHandler::getTpl()
		 *
		 * @param mixed $folder
		 * @param mixed $file
		 * @param string $module
		 * @return
		 */
		public function getTpl($folder,$file,$module='')
			{
				global $smartyObj;
				global $CFG;
				global $LANG;
				if($module)
					{
						$filePath=$this->CFG['site']['project_path'].$module.'/design/templates/'.$CFG['html']['template']['default'].'/'.$folder.'/'.$file;
						if(!file_exists($filePath))
							{
								$module='';
							}
					}
				setTemplateFolder($folder.'/',$module);
				$smartyObj->display($file);
			}

		/**
		 * FormHandler::getDefaultCssUrl()
		 *
		 * @param string $file
		 * @param string $module
		 * @return
		 */
		public function getDefaultCssUrl($file='',$module='')
			{
				global $smartyObj;
				global $CFG;

				if($file)
					{
						$CFG['html']['stylesheet']['screen']['default_file']=$file;
					}
				else
					{
						$file=$CFG['html']['stylesheet']['screen']['default_file'];
					}
				if($module)
					{
						$cssPath=$CFG['site']['project_path'].$module.'/design/templates/'.$CFG['html']['template']['default'].'/root/css/'.$CFG['html']['stylesheet']['screen']['default'].'/'.$file.'.css';
						//$memberCssPath=$CFG['site']['project_path'].$module.'/design/templates/'.$CFG['html']['template']['default'].'/members/css/'.$file.'.css';

						if(!file_exists($cssPath)) //|| !file_exists($memberCssPath))
							{
								$module='';
							}
					}
				setTemplateFolder('root/',$module);
				echo $smartyObj->css_defalut_path;
			}

		/**
		 * FormHandler::getTopMenu()
		 *
		 * @param mixed $folder
		 * @param mixed $file
		 * @param string $module
		 * @return
		 */
		public function getTopMenu($folder,$file,$module='')
			{
				global $smartyObj;
				global $CFG;
				global $mainmenu_channel, $mainmenu_more;

				$currentPage=strtolower(basename($_SERVER['SCRIPT_NAME'], ".php"));

				//Condition to highlight mail and friends menu for their corresponding pages
				if($currentPage == 'mailcompose' || $currentPage == 'mailread')
					$currentPage = 'mail';
				elseif($currentPage == 'membersinvite' || $currentPage == 'relationmanage' || $currentPage == 'relationview')
					$currentPage = 'myfriends';

				$smartyObj->assign('menu_channel','');
				$channelinc=0;
				$menu = array();

				$sql='SELECT * FROM '.$this->CFG['db']['tbl']['menu_settings'];
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array());
				if (!$rs)
					trigger_db_error($this->dbObj);

				if(!$rs->PO_RecordCount())
					{
						return false;
					}
				while($row = $rs->FetchRow())
					{
						//To check default module for displaying channel
						if($this->CFG['admin']['site_menu_default_channel']=='')
							{
								$$row['menu_key']= $row['menu_value'];
							}
						else if(in_array($this->CFG['admin']['site_menu_default_channel'], $this->CFG['site']['modules_arr']))
							{
								if(chkAllowedModule(array($this->CFG['admin']['site_menu_default_channel'])))
									{
										$$row['menu_key']= $row['menu_value'];
									}
							}
					}

				$condition='';
				if(!isLoggedin())
					{
						$condition=' AND is_member_menu=\'No\'';
					}
				else
					{
						$condition=' AND is_member_hide_menu=\'No\'';
					}

				$sql= 'SELECT * FROM '.$this->CFG['db']['tbl']['menu'].
						' WHERE menu_status=\'Ok\''.$condition.' ORDER BY menu_order';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array());
				if (!$rs)
					trigger_db_error($this->dbObj);

				$inc = 0;
				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								//Check whether module is empty or module is available in module_arr and module is enabled
								if((empty($row['module'])) or
									((!empty($row['module']) and in_array($row['module'], $this->CFG['site']['modules_arr']))
									  and chkAllowedModule(array($row['module']))))
									{
										$menuKey = str_replace(' ','_',$row['menu_name']);
										if(isset($this->LANG['mainMenu'][$menuKey]))
											$menu['main'][$inc]['name']=$this->LANG['mainMenu'][$menuKey];
										else
											$menu['main'][$inc]['name'] = $row['menu_name'];
										$menu['main'][$inc]['id'] = 'menu_'.strtolower($menuKey);
										$menu['main'][$inc]['class_name'] = $row['class_name'];

										$menu['main'][$inc]['clsActive']='';



										if($row['is_module_home_page']=='Yes' and $row['module']==$this->CFG['site']['is_module_page'])
											/*or ($this->CFG['html']['current_script_name'] == 'index' and
													$this->CFG['admin']['site_home_page']!=$this->CFG['site']['is_module_page']))*/
											{
													$menu['main'][$inc]['clsActive']='clsActiveMenu';
												//Fix for Active class not to get applied for more than one like video home page and video module link
												/*if((!$this->check_in_sub_array($menu['main'], 'clsActiveMenu'))
													and (!$this->check_in_sub_array($menu['main'], 'clsActiveFirstMenu')))
													{
														if($inc==0)
															$menu['main'][$inc]['clsActive']='clsActiveFirstMenu';
														else
															$menu['main'][$inc]['clsActive']='clsActiveMenu';
													}*/
											}


										if($currentPage==$row['file_name'] && $currentPage != 'index')
											{

												foreach($menu['main'] as $key =>$arr)
													{
														if(in_array('clsActiveMenu',$arr))
															{
																$menu['main'][$key]['clsActive']='';
															}
													}

												if($inc==0)
													$menu['main'][$inc]['clsActive']='clsActiveFirstMenu';
												else
													$menu['main'][$inc]['clsActive']='clsActiveMenu';
											}
										if(($currentPage=='membersbrowse' || $currentPage=='memberblock') && $row['file_name']=='memberslist')
										{
											$menu['main'][$inc]['clsActive']='clsActiveMenu';
										}
										//removed this since the logic doesn't look correct  ..
	//									if($this->CFG['html']['current_script_name'] == 'index')
	//										{
	//											if($row['menu_order'] != $this->getMenuOrder('index'))
	//												$menu['main'][$inc]['clsActive']='';
	//										}

										if($row['menu_page_type']=='static')
											{
												$menu['main'][$inc]['url']=getUrl('static','?pg='.$row['file_name'],$row['file_name'].'/','','');
												if(isset($_REQUEST['pg']) AND $_REQUEST['pg'] ==$row['file_name'])
													{
														foreach($menu['main'] as $key =>$arr)
															{
																if(in_array('clsActiveMenu',$arr))
																	{
																		$menu['main'][$key]['clsActive']='';
																	}
															}

														if($inc==0)
															$menu['main'][$inc]['clsActive']='clsActiveFirstMenu';
														else
															$menu['main'][$inc]['clsActive']='clsActiveMenu';
													}
											}
										else if($row['menu_page_type']=='external_link')
											{
												$url=parse_url($row['file_name']);
												if(!isset($url['host']))
													{
														$row['file_name']='http://'.$row['file_name'];
													}
												$menu['main'][$inc]['url']=$row['file_name'];
											}
										else if($row['menu_page_type']=='normal')
											{
												if($this->CFG['feature']['rewrite_mode']=='normal')
													$menu['main'][$inc]['url']=$this->CFG['site']['url'].$row['normal_querystring'];
												else
													$menu['main'][$inc]['url']=$this->CFG['site']['url'].$row['seo_querystring'];
											}

										if(!$row['link_target']) $row['link_target'] = '_self';

										$menu['main'][$inc]['target_type']=$row['link_target'];
										$inc++;
									}
							}
					}
				else
					{
						$menu['main'][]='';
					}

				$channelModule = $this->CFG['admin']['site_menu_default_channel'];
				if(isset($show_channel) and $show_channel=='true' and chkAllowedModule(array($channelModule)))
					{
						$className=ucfirst($channelModule).'Handler';
						require_once($this->CFG['site']['project_path'].'common/classes/class_MediaHandler.lib.php');
						require_once($this->CFG['site']['project_path'].'common/classes/class_'.$className.'.lib.php');
						$obj = new $className();
						$method='populate'.ucfirst($channelModule).'Channel';
						$channels = false;
						//Check whether method exists
						if(method_exists($obj, $method))
							$channels = $obj->$method();
						$smartyObj->assign('display_channel_in_row', false);
						if(isset($display_channel_in_row) and $display_channel_in_row == 'true')
							{
								$smartyObj->assign('display_channel_in_row', true);
								$channelinc=0;
							}
						if($channels)
							{
								foreach($channels as $channel)
									{
										if(isset($display_channel_in_row) and $display_channel_in_row == 'true')
											{
												$menuKey = str_replace(' ','_',$channel['name']);
												$menu['main'][$inc]['id'] = 'menu_'.strtolower($menuKey);
												$menu['main'][$inc]['clsActive'] = '';
												$menu['main'][$inc]['name'] = $channel['name'];
												$menu['main'][$inc]['url'] = getUrl($this->CFG['admin']['site_menu_default_channel'].'list',
																				'?pg='.$this->CFG['admin']['site_menu_default_channel'].'new&cid='.$channel['id'],
																				$this->CFG['admin']['site_menu_default_channel'].'new/?cid='.$channel['id'], '',
																				$this->CFG['admin']['site_menu_default_channel']);
												$menu['main'][$inc]['target_type']= '';
											}
										else
											{
												$menuChannel[$channelinc]['name']= $channel['name'];
												$menuChannel[$channelinc]['url'] = getUrl($this->CFG['admin']['site_menu_default_channel'].'list',
																					'?pg='.$this->CFG['admin']['site_menu_default_channel'].'new&cid='.$channel['id'],
																					$this->CFG['admin']['site_menu_default_channel'].'new/?cid='.$channel['id'], '',
																					$this->CFG['admin']['site_menu_default_channel']);
											}
										if(isset($display_channel_in_row) and $display_channel_in_row == 'true')
											$inc++;
										else
											$channelinc++;
									}
								}
						if(!isset($display_channel_in_row) or $display_channel_in_row != 'true')
							{
								$smartyObj->assign('menu_channel', $menuChannel);
								$mainmenu_channel = $menuChannel;
							}
						$smartyObj->assign('show_channel', true);
					}

				if(isset($visible_channel_count) and $visible_channel_count<$channelinc)
					{
						$channelMenuMax = $visible_channel_count;
						$channelMore = true;
						$channel_more_link = getUrl($this->CFG['admin']['site_menu_default_channel'].'category', '',
												'','',$this->CFG['admin']['site_menu_default_channel']);
						$smartyObj->assign('channel_more_link', $channel_more_link);
					}
				else
					{
						$channelMenuMax=$channelinc;
						$channelMore=false;
					}

				if(isset($visible_menu_count) and $visible_menu_count<$inc)
					{
						$mainMenuMax=$visible_menu_count;
						$more=true;
					}
				else
					{
						$mainMenuMax = $inc;
						$more = false;
					}
				$mainmenu_more = $more;

				$smartyObj->assign('mainmenu_more', $more);
				$smartyObj->assign('channelMore', $channelMore);
				$smartyObj->assign('mainMenuMax', $mainMenuMax);
				$smartyObj->assign('channelMenuMax', $channelMenuMax);
				$smartyObj->assign('menu', $menu);

				$this->getTpl($folder,$file,$module);
			}

		/**
		 * FormHandler::check_in_sub_array()
		 *
		 * @param mixed $check_arr
		 * @param mixed $check_value
		 * @return
		 */
		public function check_in_sub_array($check_arr, $check_value)
			{
				foreach($check_arr as $val_arr)
					{
						if(in_array($check_value, $val_arr))
							return true;
					}
			}

		/**
		 * FormHandler::populateTinyMceEditor()
		 *
		 * @param string $field_name
		 * @param string $value
		 * @return
		 */
		public function populateTinyMceEditor($field_name='', $value='')
			{
				return populateTinyMceEditor($field_name, $this->getFormField($field_name));
			}

		/**
		 * FormHandler::isFacebookUser()
		 *
		 * @return
		 */
		public function isFacebookUser()
			{
				if($this->CFG['user']['openid_type'] == 'facebook')
					{
						return true;
					}
				return false;
			}

		/**
		 * FormHandler::getFacebookProfileStatus()
		 *
		 * @return
		 */
		public function getFacebookProfileStatus()
			{
		 		$sql = ' SELECT * from  '.$this->CFG['db']['tbl']['facebook_profile'].''.
		                ' WHERE user_id = '.$this->CFG['user']['user_id'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
						trigger_db_error($this->dbObj);

				if ($row = $rs->FetchRow())
					{
						return $row;
					}
				return false;
			}

		/**
		 * FormHandler::setFacebookProfile()
		 *
		 * @return
		 */
		public function setFacebookProfile()
			{
				$main_profile_my_videos = '';
				$main_profile_my_profile = '';
				$main_profile_FBML = '';
				$profile_status = $this->getFacebookProfileStatus();

				if($profile_status['my_profile'] == 'Yes')
					{
						$main_profile_my_profile = $this->displayUserDetailsInFacebook();
						$main_profile_FBML =$main_profile_FBML. $main_profile_my_profile."<br>";
					}
				/*if($profile_status['my_videos'] == 'Yes')
					{
						$main_profile_my_videos = $this->displayMyVideosInFacebook($limit = 2 , $close = true);
						$main_profile_FBML =$main_profile_FBML. $main_profile_my_videos."<br>";
					}*/
				$facebook = new Facebook($this->CFG['facebook']['api_key'], $this->CFG['facebook']['appsecret']);
				$user_id = $facebook->require_login();
				$facebook->api_client->profile_setFBML(NULL, $user_id, $main_profile_FBML, NULL, '', $main_profile_FBML);
			}

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function displayUserDetailsInFacebook()
		    {
				global $smartyObj;

				$this->displayUserDetails_arr = array();
				$this->user_details = $this->getUserDetail('user_id', $this->CFG['user']['user_id']);
				$this->user_details['display_name'] = ucwords($this->user_details['display_name']);

				$this->displayUserDetails_arr['user_details'] = $this->user_details;
				$this->displayUserDetails_arr['date']	=	date('M d, Y', strtotime($this->user_details['doj']));
				$this->displayUserDetails_arr['nl2br_bio']	=	nl2br(wordWrapManual($this->user_details['about_me'], 45));

				setTemplateFolder('general/');
				$fbml_profile = $smartyObj->fetch('displayFacebookProfile.tpl');
				return 	$fbml_profile;
	    	}

		/**
		 * FormHandler::getBlogList()
		 *
		 * @return
		 */
		public function getBlogList()
			{
				$sql = 'SELECT blogger_id, blog_title FROM '.$this->CFG['db']['tbl']['blogger'].' WHERE'.
						' user_id = '.$this->dbObj->Param('user_id').' AND'.
						' status = \'Ok\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
			    if (!$rs)
			        trigger_db_error($this->dbObj);

				$return_arr = array();
				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$return_arr[$row['blogger_id']] = $row['blog_title'];
							}
					}
				return $return_arr;
			}

		/**
		 * Gets the challenge HTML (javascript and non-javascript version).
		 * This is called from the browser, and the resulting reCAPTCHA HTML widget
		 * is embedded within the HTML form it was called from.
		 * @return string - The HTML to be embedded in the user's form.
		 */
		public function recaptcha_get_html()
			{
				$tabindex = smartyTabIndex(array(), $this);
				?>
				<script type="text/javascript">
                    var RecaptchaOptions = {
                    	tabindex: <?php echo $tabindex; ?>,
						theme: 'blackglass',
						custom_translations : { visual_challenge : "<?php echo $this->LANG['common_recaptcha_visual_challenge']; ?>", audio_challenge : "<?php echo $this->LANG['common_recaptcha_audio_challenge']; ?>",
refresh_btn : "<?php echo $this->LANG['common_recaptcha_refresh_btn']; ?>", instructions_visual : "<?php echo $this->LANG['common_recaptcha_instructions_visual']; ?>:", instructions_audio : "<?php echo $this->LANG['common_recaptcha_instructions_audio']; ?>:", help_btn : "<?php echo $this->LANG['common_recaptcha_help_btn']; ?>", play_again : "<?php echo $this->LANG['common_recaptcha_play_again']; ?>", cant_hear_this : "<?php echo $this->LANG['common_recaptcha_cant_hear_this']; ?>", incorrect_try_again : "<?php echo $this->LANG['common_recaptcha_incorrect_try_again']; ?>" }
                    };
                </script>
				<?php
				return recaptcha_get_html($this->CFG['captcha']['public_key'], $this->error);
			}

		/**
		 * FormHandler::chkCaptcha()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return
		 */
		public function chkCaptcha($field_name, $err_tip='')
			{
				if ($this->fields_arr["recaptcha_response_field"])
					{
		        		$resp = recaptcha_check_answer ($this->CFG['captcha']['private_key'],
					 					$_SERVER["REMOTE_ADDR"],
					 					$this->fields_arr["recaptcha_challenge_field"],
										$this->fields_arr["recaptcha_response_field"]);

			        	if ($resp->is_valid)
						 	{
	                			return true;
			                }
					    $this->fields_err_tip_arr[$field_name] = $err_tip;
						return false;
					}

			}

		/**
		 * FormHandler::getProfileBlocks()
		 * To get available module's and enabled module's blocks
		 *
		 * @return
		 */
		public function getProfileBlocks()
			{
				$getProfileBlocks_arr = array();
				$sql = 'SELECT module_name, block_name,order_no FROM '.
						$this->CFG['db']['tbl']['profile_block'].
						' WHERE display=\'Yes\' AND IF(profile_category_id,FIND_IN_SET(profile_category_id,(SELECT GROUP_CONCAT(DISTINCT form_id ORDER BY form_id) FROM '.$this->CFG['db']['tbl']['users_profile_question'].')),1) GROUP BY block_name ORDER BY order_no ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
					{
						$inc = 0;
						while($row = $rs->FetchRow())
							{
								if(in_array($row['module_name'], $this->CFG['site']['modules_arr']))
									{
										if(chkAllowedModule(array($row['module_name'])))
											{
												$getProfileBlocks_arr['module_name'][$inc] = $row['module_name'];
												$getProfileBlocks_arr['block_name'][$inc] = $row['block_name'];
												$inc++;
											}
									}
								else if($row['module_name']=='default')
									{
										$getProfileBlocks_arr['module_name'][$inc] = $row['module_name'];
										$getProfileBlocks_arr['block_name'][$inc] = $row['block_name'];
										$inc++;
									}
							}
				    }
				return $getProfileBlocks_arr;
			}

		/**
		 * FormHandler::generateIndexPageLink()
		 *  Generate Default module's or Enabled module's Home/Index Page link
		 *
		 * @return
		 */
		public function generateIndexPageLink()
			{
				$this->index_page_link = getUrl('index');
				return false; //All Module header link redirect root index page
				$this->index_module = '';
				if(chkAllowedModule(array(strtolower($this->CFG['admin']['site_home_page']))))
					{
						$module = $this->CFG['admin']['site_home_page'];
					}
				elseif($this->CFG['site']['is_module_page'])
					{
						$module = $this->CFG['site']['is_module_page'];
					}
				else
					{
						foreach($this->CFG['site']['modules_arr'] as $value)
							{
								if(chkAllowedModule(array(strtolower($value))))
									{
										$module = $value;
										break;
									}
							}
					}
				if(!isset($module))
					return false;
				$this->index_module = $module;
				if($module == '')
					$this->index_page_link = getUrl('index');
				else
					$this->index_page_link = getUrl('index', '', '', '', $module);
			}

		/**
		 * FormHandler::generalPopulateAlphabetArray()
		 *
		 * @param array $list
		 * @param string $highlight_value
		 * @return void
		 */
		public function generalPopulateAlphabetArray($list, $highlight_value='')
			{
				$cls_alphabet_active_class = ' class="clsActive"';
				$cur_alphabet_highlight = '';
				foreach($list as $key=>$value)
					{
						$alphabet_highlight = 'alphabet_sort_'.$value;
						$$alphabet_highlight = '';
					}
				if(isset($_REQUEST['titles']) and !empty($_REQUEST['titles']))
					{
						$cur_alphabet_highlight = 'alphabet_sort_'.$_REQUEST['titles'];
						$$cur_alphabet_highlight = $cls_alphabet_active_class;
					}
				$lastValue = ' class="clsLastData"';
				$lastActiveValue = ' class="clsActive clsLastData"';
				foreach($list as $key=>$value)
					{
						$alphabet_highlight = 'alphabet_sort_'.$value;
						if($value=='All' && $cur_alphabet_highlight == 'alphabet_sort_All')
							$$alphabet_highlight = $lastActiveValue;
						else if($value=='All')
							$$alphabet_highlight = $lastValue;
						?>
					  	<li<?php  if($value=='All' && $alphabet_highlight != 'alphabet_sort_All'){ echo $lastValue; } ?><?php echo $$alphabet_highlight; ?>><a href="javascript:void(0)" onclick="jumpAndSubmitForms('<?php echo $value; ?>');return false;"><?php echo $value; ?></a></li>
					   <?php
				    }
			}

		/**
		 * FormHandler::getProductXmlFeedFilePath()
		 *
		 * @param mixed $option
		 * @return
		 */
		public function getProductXmlFeedFilePath($option)
			{
				$objXML = new XmlParser();
				$strYourXML = getContents($this->CFG['members']['xmlpath']);
				$arrOutput = $objXML->parse($strYourXML);
				if(isset($arrOutput[0]['children']) and $arrOutput[0]['children'])
					{
						foreach($arrOutput[0]['children'] as $key=>$value)
							{
								if(isset($arrOutput[0]['children'][$key]['attrs']['OPTION']) and $arrOutput[0]['children'][$key]['attrs']['OPTION'] == $option)
									return trim($arrOutput[0]['children'][$key]['tagData']);
							}
					}
			}

		/**
		 * FormHandler::getMenuOrder()
		 *
		 * @param mixed $file_name
		 * @return
		 */
		public function getMenuOrder($file_name)
			{
				$sql='SELECT menu_order FROM '.$this->CFG['db']['tbl']['menu']. ' WHERE file_name =\''.$file_name.'\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);
				$row = $rs->FetchRow();
				return $row['menu_order'];
			}

		/**
		 * FormHandler::sendMailToUserForProfileComment()
		 *
		 * @return
		 */
		public function sendMailToUserForProfileComment()
			{
				$fields_list = array('user_name', 'email', 'first_name', 'last_name');

				$user_details_arr = $this->getUserDetail('user_id', $this->fields_arr['user_id']);

				$subject = $this->LANG['profile_comment_received_subject'];
				$body = $this->LANG['profile_comment_received_content'];

				$user_url = getMemberProfileUrl($this->CFG['user']['user_id'], $this->CFG['user']['user_name']);
				$profile_link = $this->getAffiliateUrl(getMemberProfileUrl($this->fields_arr['user_id'],
									$user_details_arr['user_name']));

				$this->setEmailTemplateValue('site_name', $this->CFG['site']['name']);
				$this->setEmailTemplateValue('user_name', $user_details_arr['user_name']);
				$this->setEmailTemplateValue('scrap', wordWrap_mb_Manual($this->fields_arr['comment'], 100, 100, true));
				$this->setEmailTemplateValue('FROM_USER_NAME', '<a href="'.$user_url.'">'.$this->CFG['user']['user_name'].'</a>');
				$this->setEmailTemplateValue('profile_link', $profile_link);
				$this->setEmailTemplateValue('link', $this->getAffiliateUrl($this->CFG['site']['url']));

				$this->_sendMail($user_details_arr['email'],
									$subject, $body, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);

			}

		/**
		 * FormHandler::chkIsAdminSideIsViewed()
		 *
		 * @return boolean
		 */
		public function chkIsAdminSideIsViewed()
			{
				$url_arr = explode('/', $_SERVER['REQUEST_URI']);
				if(in_array('admin', $url_arr))
					return true;
				return false;
			}

		/**
		 * FormHandler::chkIsUserSubscribedToOwner()
		 *  Check whether logged in user is subscribed to the owner
		 *
		 * @param integer $owner_id
		 * @return boolean
		 */
		public function chkIsUserSubscribedToOwner($owner_id)
			{
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['subscription'].
						' WHERE owner_id='.$this->dbObj->Param('owner_id').
						' AND subscriber_id='.$this->dbObj->Param('subscriber_id').
						' AND status=\'Yes\'';

				$stmt = $this->dbObj->Prepare($sql);

				$rs = $this->dbObj->Execute($stmt, array($owner_id, $this->CFG['user']['user_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					return true;

				return false;
			}

		/**
		 * FormHandler::chkIsSubscriptionEnabled()
		 *
		 * @return boolean
		 */
		public function chkIsSubscriptionEnabled()
			{
				return chkIsSubscriptionEnabled();
			}

		/**
		 * FormHandler::chkSubscribers()
		 *
		 * @param integer $owner_id
		 * @return boolean
		 */
		public function chkSubscribers($owner_id)
			{
				$sql = 'SELECT subscriber_id FROM '.$this->CFG['db']['tbl']['subscription'].
						' WHERE owner_id='.$this->dbObj->Param('owner_id').
						' AND status=\'Yes\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($owner_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						return true;
					}
				return false;
			}

		/**
		 * FormHandler::addSubscriptionData()
		 *
		 * @param array $subscription_data_arr
		 * @return void
		 */
		public function addSubscriptionData($subscription_data_arr)
			{
				if(chkIsSubscriptionEnabledForModule())
					{
						if($this->chkSubscribers($subscription_data_arr['owner_id']))
							{
								$value_arr = array($subscription_data_arr['owner_id'],
													$subscription_data_arr['category_id'],
													$subscription_data_arr['sub_category_id'],
													$subscription_data_arr['tag_name'],
													$subscription_data_arr['content_id'],
													$this->CFG['site']['is_module_page']);


								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['subscription_activity'].
									   ' SET '.
									   ' owner_id = '.$this->dbObj->Param('owner_id').','.
									   ' category_id = '.$this->dbObj->Param('category_id').','.
									   ' sub_category_id = '.$this->dbObj->Param('sub_category_id').','.
									   ' tag_name = '.$this->dbObj->Param('tag_name').','.
									   ' content_id = '.$this->dbObj->Param('video_id').','.
									   ' module = '.$this->dbObj->Param('module').','.
									   ' date_activated=NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $value_arr);
								if (!$rs)
								    trigger_db_error($this->dbObj);
							}

					}
			}

		/**
		 * FormHandler::chkIsUserSubscribedToCategory()
		 *  Check whether logged in user is subscribed to module's category
		 *
		 * @param integer $category_id
		 * @param string $module
		 * @return boolean
		 */
		public function chkIsUserSubscribedToCategory($category_id, $module)
			{
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['subscription'].
						' WHERE category_id='.$this->dbObj->Param('category_id').
						' AND subscriber_id='.$this->dbObj->Param('subscriber_id').
						' AND module='.$this->dbObj->Param('module').
						' AND status=\'Yes\'';

				$stmt = $this->dbObj->Prepare($sql);

				$rs = $this->dbObj->Execute($stmt, array($category_id, $this->CFG['user']['user_id'], $module));
				if (!$rs)
					trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					return true;

				return false;
			}

		/**
		 * FormHandler::getCategorySubscriptionCount()
		 *
		 * @param Integer $category_id
		 * @param string $module
		 * @return Integer
		 */
		public function getCategorySubscriptionCount($category_id, $module)
			{
				$sql = 'SELECT count(*) as total FROM '.$this->CFG['db']['tbl']['subscription'].
						' WHERE category_id='.$this->dbObj->Param('category_id').
						' AND module='.$this->dbObj->Param('module').
						' AND status=\'Yes\'';

				$stmt = $this->dbObj->Prepare($sql);

				$rs = $this->dbObj->Execute($stmt, array($category_id, $module));
				if (!$rs)
					trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						return $row['total'];
					}

				return 0;
			}

		/**
		 * FormHandler::getTagSubscriptionCount()
		 *
		 * @param string $tag
		 * @param string $module
		 * @return
		 */
		public function getTagSubscriptionCount($tag, $module)
			{
				$sql = 'SELECT count(*) as total FROM '.$this->CFG['db']['tbl']['subscription'].
						' WHERE tag_name ='.$this->dbObj->Param('tag').
						' AND module='.$this->dbObj->Param('module').
						' AND status=\'Yes\'';

				$stmt = $this->dbObj->Prepare($sql);

				$rs = $this->dbObj->Execute($stmt, array($tag, $module));
				if (!$rs)
					trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						return $row['total'];
					}

				return 0;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function popupLoginWindow($isLoginRequired = 'true', $actionRequested = 'redirect', $linkID)
			{
				return popupLoginWindow($isLoginRequired, $actionRequested, $linkID);
			}

		/**
		 * FormHandler::chkValidTagList()
		 *
		 * @param mixed $field_name
		 * @param string $tag
		 * @param string $err_tip
		 * @return
		 */
		public function chkValidTagList($field_name,$tag='tags',$err_tip = '')
			{

				$tag_arr = explode(' ', $this->fields_arr[$field_name]);
				$tag_arr = array_unique($tag_arr);
				$key = array_search('', $tag_arr);
				if($key)
					unset($tag_arr[$key]);

				$err_tip = str_replace('VAR_MIN', $this->CFG['fieldsize'][$tag]['min'], $err_tip);
				$err_tip = str_replace('VAR_MAX', $this->CFG['fieldsize'][$tag]['max'], $err_tip);

				foreach($tag_arr as $key=>$value)
					{
						if(function_exists('mb_strlen'))
						{
							//decoded first since this adds the length of the html entities too done while sanitizing
							$strLength =mb_strlen(htmlspecialchars_decode($value),'utf-8');
						}
						else
						{
							$strLength = strlen(htmlspecialchars_decode($value));
						}

						if(($strLength<$this->CFG['fieldsize'][$tag]['min']) or ($strLength>$this->CFG['fieldsize'][$tag]['max']))
							{
								$this->setFormFieldErrorTip($field_name,$err_tip);
								return false;
							}
					}
				$this->fields_arr[$field_name] = implode(' ', $tag_arr);
				return true;
			}

	/**
	 * FormHandler::chkTemplateImagePathForModuleAndSwitch()
	 *    To load available template and screen for the module, used
	 *    while integrating products with different templates
	 * @param string $module
	 * @param string $template
	 * @param string $screen
	 * @return void
	 */
	public function chkTemplateImagePathForModuleAndSwitch($module, $template, $screen)
		{
			global $CFG;
			$css_template_arr['template'] = $template;
			$css_template_arr['screen'] = $screen;

			$template_dir_module = $CFG['site']['project_path'].$module.
										'/design/templates/'.$template.'/root/images/'.$screen.'/';

			if(!is_dir($template_dir_module))
				{
					foreach($CFG['html']['template']['allowed'] as $available_template)
						{
							$available_template_dir = $CFG['site']['project_path'].$module.
															'/design/templates/'.$available_template.'/root/images/';

							if(is_dir($available_template_dir))
								{
									foreach($CFG['html']['stylesheet'][$available_template]['allowed'] as $available_image)
										{
											$available_image_path  = $CFG['site']['project_path'].$module.
																		'/design/templates/'.$available_template.'/root/images/'.$available_image.'/';

											if(is_dir($available_image_path))
												{
													$css_template_arr['template'] = $available_template;
													$css_template_arr['screen'] = $available_image;
													break;
												}
										}
								}
						}
				}

				$this->CFG['html']['template']['default'] = $css_template_arr['template'];
				$this->CFG['html']['stylesheet']['screen']['default']  = $css_template_arr['screen'];

				$this->assignSmartyVariables();
		}
		/**
		* To set the form variables
		*
		* Alias of setFormField() method. But use this method only for
		* displaying the form fields.
		*
		* @param 		string $field_name Form field name
		* @param 		string $field_value Form field value
		* @return 		void
		* @access 		public
		*/
		public function setDisplayVar($field_name, $field_value)
			{
				$this->setFormField($field_name, $field_value);
			}


		/**
		 * FormHandler::checkLoginStausAjax()
		 * Added to display login message
		 *
		 * @param	string $login_check_url
		 * @return	void
		 */
		public function checkLoginStatusInAjax($login_check_url)
		{
			if(!isMember())
			{
				$login_msg = '<a href="'.$login_check_url.'">'.$this->LANG['common_login_click_here'].'</a>';
				$login_err_msg = str_replace('VAR_CLICK_HERE', $login_msg, $this->LANG['common_login_err_msg']);
				echo $login_err_msg;
				echo 'ERR~';
				exit;
			}

		}

	}
//<<<<<------------------ Class FormHandler ends --------------------//

/****************************************/
/*----Test cases in standalone mode-----*/
/****************************************/
if ($CFG['debug']['debug_standalone_modules'])
	{

	}
?>
