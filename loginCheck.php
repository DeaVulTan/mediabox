<?php
/**
 * File to check the logged is users session
 *
 * @category	Rayzz
 * @package		Index
 */
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/root/login.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['include_files'][] = 'common/classes/class_SignupAndLoginHandler.lib.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------- Class LoginCheckHandler begins --------------->>>>>//
/**
 * This class is used to authenticate the user
 *
 * @category	Rayzz
 * @package		Index
 */
class LoginCheckHandler extends signupAndLoginHandler
	{
		/**
		 * LoginFormHandler::displayMandatoryIcon()
		 * Display the mandatory icon
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
						return $this->LANG['login_mandatory_field_icon'];
					}
			}
	}
//<<<<<-------------- Class LoginCheckHandler begins ---------------//
//-------------------- Code begins -------------->>>>>//
$loginfrm = new LoginCheckHandler();

$login_field = 'username';
if($CFG['admin']['email_using_to_login'])
	$login_field = 'email';

$LANG['login_err_invalid_login'] = $LANG['login_err_invalid_login_'.$login_field];
$LANG['login_err_tip_invalid'] = $LANG['login_err_tip_invalid_'.$login_field];

if(!chkAllowedModule(array('login')))
	Redirect2URL(getUrl('adminlogin', '', '', 'root'));

$loginfrm->setPageBlockNames(array('form_login', 'form_error'));
$loginfrm->setFormField('user_name', '');
$loginfrm->setFormField('password', '');
$loginfrm->setFormField('remember', '');
$loginfrm->setFormField('ajaxWindowLink', '');
$loginfrm->setFormField('isLoginRequired', '');
$loginfrm->setFormField('actionRequested', '');
$loginfrm->form_error['hidden_arr'] = array('ajaxWindowLink', 'isLoginRequired', 'actionRequested');
$downloadType='';
if(isset($_SESSION['download_url']))
	{
		$_SESSION['url']=$_SESSION['download_url'];
		$downloadType=$_SESSION['download_type'];
	}
$loginfrm->setFormField('download_type',$downloadType);
$loginfrm->setFormField('url', (isset($_SESSION['url']) ? $_SESSION['url'] : ''));
$loginfrm->setFormField('recaptcha_challenge_field', '');
$loginfrm->setFormField('recaptcha_response_field', '');

$loginfrm->setAllPageBlocksHide();
if (isMember())
	{
		$loginfrm->includeAjaxHeader();
		echo 'true';
		ob_end_flush();
		die();
	}
else
	{
		$loginfrm->includeAjaxHeader();
		echo 'false';
		ob_end_flush();
		die();
	}
$loginfrm->setPageBlockShow('form_login');
$loginfrm->sanitizeFormInputs($_REQUEST);

//--------------------Page block templates begins-------------------->>>>>//
if($loginfrm->isShowPageBlock('form_login'))
	{
		$loginfrm->form_login['login_field'] = $login_field;
		$loginfrm->form_login['login_field_label'] = $LANG['login_'.$login_field];
	}
//include the header file
if (isAjaxPage())
	{
		//include the header file
		$loginfrm->includeAjaxHeader();
		$smartyObj->assign('tabindex', 900);
	}
else
	{
		//include the header file
		$loginfrm->includeHeader();
	}
//include the content of the page
setTemplateFolder('root/');
$smartyObj->display('login.tpl');
//includ the footer of the page
if (isAjaxPage())
	{
		//include the footer file
		$loginfrm->includeAjaxFooter();
	}
else
	{
		//include the footer of the page
		$loginfrm->includeFooter();
	}
//<<<<<<--------------------Page block templates Ends--------------------//
?>