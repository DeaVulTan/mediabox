<?php
/**
 * File to allow the users to login
 *
 * Provides an interface to get the username and password. If valid , logins the user
 * to the site. If email is to be got instead of username,
 * set this value $CFG['admin']['email_using_to_login'] to true.
 *
 * If not activated, activation mail will be sent again
 *
 * @category	Rayzz
 * @package		Index
 */
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/root/maintenance.php';
$CFG['html']['header'] = 'general/html_header_popup.php';
$CFG['html']['footer'] = 'general/html_footer_popup.php';
$CFG['mods']['include_files'][] = 'common/classes/class_SignupAndLoginHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/recaptchalib.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'root';
require($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------- Class SiteMaintenance begins --------------->>>>>//
/**
 * This class is used to authenticate the user
 *
 * @category	Rayzz
 * @package		Index
 */
class SiteMaintenance extends signupAndLoginHandler
	{
		public $user_details_arr = array();

		/**
		 * LoginFormHandler::chkIsBrowserAcceptsCookies()
		 *
		 * To check whether the browser accepts cookies
		 *
		 * @return 		boolean true/false
		 * @access 		public
		 */
		public function chkIsBrowserAcceptsCookies()
			{
				return count($_COOKIE);
			}

		/**
		 * LoginFormHandler::chkIsNoFormErrors()
		 *
		 * To check the form inputs alias for clarity
		 *
		 * @return 		boolean true/false
		 * @access 		public
		 */
		public function chkIsNoFormErrors()
			{
				return $this->isValidFormInputs();
			}

		/**
		 * LoginFormHandler::chkIsValidLoginDetail()
		 *
		 * To check if the details provided are valid
		 *
		 * @param 		string $err_tip
		 * @return 		boolean $is_ok valid login
		 * @access 		public
		 */
		public function chkIsValidLoginDetail($err_tip='')
			{
				$column = 'user_name';
				if($this->CFG['admin']['email_using_to_login'])
					$column = 'email';

				if($user_detail = $this->getUserDetail($column, $this->fields_arr['user_name']))
					{
						$this->user_details_arr = $user_detail;
					}

				$is_ok = false;
				if($this->user_details_arr AND $user_detail['password'] == $this->fields_arr['password'] AND $user_detail['usr_access']=='Admin')
					{
						$is_ok = true;
					}
				else
					{
						$is_ok = false;
						$this->setFormFieldErrorTip('user_name', $err_tip);
						$this->setFormFieldErrorTip('password', $err_tip);
						$this->setCommonErrorMsg($this->LANG['maintenancefrm_error']);
					}
				return $is_ok;
			}

		/**
		 * LoginFormHandler::displayMandatoryIcon()
		 * Display the mandatory icon if the form field is listed in mandatory fields array
		 *
		 * @param  string $field_name
		 * @return string
		 * @access public
		 */
		public function displayMandatoryIcon($field_name='')
			{
				$mandatoryFields = array('user_name', 'password');
				if($field_name == '*' OR (in_array($field_name, $mandatoryFields)))
					{
						$this->displayCompulsoryIcon();
					}
			}
	}

$maintenancefrm = new SiteMaintenance();
$LANG['maintenancefrm_user_name_errormsg'] = $maintenancefrm->buildDisplayText($LANG['common_err_tip_invalid_character_size'], array('VAR_MIN'=>$CFG['fieldsize']['username']['min'], 'VAR_MAX'=>$CFG['fieldsize']['username']['max']));
$LANG['maintenancefrm_password_errormsg'] = $maintenancefrm->buildDisplayText($LANG['common_err_tip_invalid_character_size'], array('VAR_MIN'=>$CFG['fieldsize']['password']['min'], 'VAR_MAX'=>$CFG['fieldsize']['password']['max']));
$maintenancefrm->setDBObject($db);
$maintenancefrm->makeGlobalize($CFG,$LANG);
$maintenancefrm->setPageBlockNames(array('form_login', 'form_error', 'form_maintenance'));
$maintenancefrm->setFormField('user_name', '');
$maintenancefrm->setFormField('password', '');
$maintenancefrm->setFormField('remember', '');
$maintenancefrm->setAllPageBlocksHide();
$maintenancefrm->setPageBlockShow('form_maintenance');
//$maintenancefrm->setPageBlockShow('form_login');
$maintenancefrm->setFormField('pg', '');
$maintenancefrm->sanitizeFormInputs($_REQUEST);
$maintenancefrm->setFormField('url',$CFG['site']['url']);
$CFG['feature']['auto_hide_success_block'] = false;

$maintenancefrm_field = 'username';
if($CFG['admin']['email_using_to_login'])
	$maintenancefrm_field = 'email';

if($maintenancefrm->getFormField('pg') == 'login')
	{
		$maintenancefrm->setPageBlockHide('form_maintenance');
		$maintenancefrm->setPageBlockShow('form_login');
	}
if ($maintenancefrm->isFormPOSTed($_POST, 'maintenancefrm_submit'))
	{
		$maintenancefrm->chkIsNotEmpty('user_name', $LANG['maintenancefrm_err_tip_compulsory']);
		$maintenancefrm->chkIsNotEmpty('password', $LANG['maintenancefrm_err_tip_compulsory']);
		$maintenancefrm->chkIsBrowserAcceptsCookies() or
			$maintenancefrm->setCommonErrorMsg($LANG['maintenancefrm_err_cookies_not_set']);
		$maintenancefrm->chkIsNoFormErrors() and
			$maintenancefrm->chkIsValidLoginDetail($LANG['maintenancefrm_err_tip_invalid']);

		if ($maintenancefrm->isValidFormInputs())
			{
				$maintenancefrm->setCookieValue();
				$maintenancefrm->updateUserLog($CFG['db']['tbl']['users'], $CFG['remote_client']['ip'], session_id());
				$maintenancefrm->saveUserVarsInSession($CFG['remote_client']['ip']);
				$admin_url = $CFG['site']['url'].'admin/index.php';
				Redirect2URL($admin_url);
				exit;
			}
		else
			{
				$remember = $maintenancefrm->getFormField('remember');
				$maintenancefrm->setFormField('remember', '');
				$maintenancefrm->setCookieValue();
				$maintenancefrm->setPageBlockShow('form_error');
				$maintenancefrm->setPageBlockShow('form_login');
				$maintenancefrm->setPageBlockHide('form_maintenance');
				$maintenancefrm->setFormField('remember', $remember);
			}
		$maintenancefrm->setFormField('password', '');
	}
if ($maintenancefrm->isShowPageBlock('form_error'))
	{
		$maintenancefrm->form_error['hidden_arr'] = array('user_name');
	}
if($maintenancefrm->isShowPageBlock('form_login'))
	{
		$maintenancefrm->form_login['maintenancefrm_field'] = $maintenancefrm_field;
		$maintenancefrm->form_login['maintenancefrm_field_label'] = $LANG['maintenancefrm_'.$maintenancefrm_field];
	}
//include the header file
$maintenancefrm->includeHeader();
//include the content of the page
setTemplateFolder('root/');
$smartyObj->display('maintenance.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
if ($maintenancefrm->isShowPageBlock('form_login') and $CFG['feature']['jquery_validation'])
	{
?>
<script type="text/javascript">
	$Jq("#form_login").validate({
		rules: {
			user_name: {
				required: true,
				minlength: <?php echo $CFG['fieldsize']['username']['min']; ?>,
				maxlength: <?php echo $CFG['fieldsize']['username']['max']; ?>
		    },
		    password: {
		    	required: true,
		    	minlength: <?php echo $CFG['fieldsize']['password']['min']; ?>,
				maxlength: <?php echo $CFG['fieldsize']['password']['max']; ?>
		    }
		},
		messages: {
			user_name: {
				required: "<?php echo $maintenancefrm->LANG['maintenancefrm_user_name_errormsg'];?>",
				minlength: jQuery.format("{0} <?php echo $maintenancefrm->LANG['common_err_tip_min_characters'];?>"),
				maxlength: jQuery.format("<?php echo $maintenancefrm->LANG['common_err_tip_max_characters'];?> {0}")
			},
			password: {
				required: "<?php echo $maintenancefrm->LANG['maintenancefrm_password_errormsg'];?>",
				minlength: jQuery.format("{0} <?php echo $maintenancefrm->LANG['common_err_tip_min_characters'];?>"),
				maxlength: jQuery.format("<?php echo $maintenancefrm->LANG['common_err_tip_max_characters'];?> {0}")
			}
		}
	});
</script>
<?php
	}
$maintenancefrm->includeFooter();
?>