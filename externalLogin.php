<?php
/**
 * File to allow the users to external login
 *
 * Provides an interface to get the username and password. If valid , logins the user
 * to the site.
 *
 * If not activated, activation mail will be sent again
 *
 * @category	Rayzz
 * @package		Index
 */
require_once('common/configs/config.inc.php');
require_once($CFG['site']['project_path'].'common/classes/class_openid/common.php');
require_once($CFG['site']['project_path'].'common/classes/class_openid/Auth/OpenID/Consumer.php');
require_once($CFG['site']['project_path'].'common/classes/class_openid/Auth/OpenID/FileStore.php');
require_once($CFG['site']['project_path'].'common/classes/class_openid/Auth/OpenID/SReg.php');
require_once($CFG['site']['project_path'].'common/classes/class_openid/Auth/OpenID/PAPE.php');
require_once($CFG['site']['project_path'].'common/classes/class_Browser.lib.php');
$CFG['mods']['include_files'][] = 'common/configs/config_facebook.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_SignupAndLoginHandler.lib.php';
$CFG['lang']['include_files'][] = 'languages/%s/root/externalLogin.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'root';
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------- Class LoginOpenidFormHandler begins --------------->>>>>//
/**
 * This class is used to authenticate the user
 *
 * @package
 * @author Siva
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id$
 * @access public
 */
class LoginOpenidFormHandler extends SignupAndLoginHandler
	{
		/**
		 * LoginOpenidFormHandler::getOpenIDURL()
		 * To check openid url
		 * @return
		 */
		public function getOpenIDURL()
			{
				// Render a default page if we got a submission without an openid
				// value.
				if (empty($_POST['openid_identifier']))
					{
						$this->setPageBlockShow('block_msg_form_error');
						$this->setCommonErrorMsg($this->LANG['common_msg_error_sorry']);
					}
				 return $_POST['openid_identifier'];
			}

		/**
		 * LoginOpenidFormHandler::imapOpen()
		 *
		 * @return
		 */
		public function imapOpen()
			{
				$username = $this->fields_arr['imap_user_name'].'@'.$this->fields_arr['imap_server_name'];
				$password = $this->fields_arr['imap_password'];
				$imap_server =$this->CFG['admin']['imap']['format_arr'][$this->fields_arr['imap_server_name']];

				$mbox = false;
				$mbox = imap_open ($imap_server,$username,$password);
				if($mbox)
					{
						imap_close($mbox);
						$this->final_run($username,'imap');
					}
				else
					{
						$this->setFormField('imap_user_name', '');
						$this->setFormField('imap_password', '');
						$this->setFormField('imap_server_name', '');
						return false;
					}
			}

		/**
		 * LoginOpenidFormHandler::pop3Open()
		 *
		 * @return
		 */
		public function pop3Open()
			{
				$username = $this->fields_arr['pop3_user_name'].'@'.$this->fields_arr['pop3_server_name'];
				$password = $this->fields_arr['pop3_password'];
				$pop3_server =$this->CFG['admin']['pop3']['format_arr'][$this->fields_arr['pop3_server_name']];
				$mbox = false;
				 $mbox = @imap_open ($pop3_server, $username, $password);
				if($mbox)
					{
						imap_close($mbox);
						$this->final_run($username,'pop3');
					}
				else
					{
						$this->setFormField('pop3_user_name', '');
						$this->setFormField('pop3_password', '');
						$this->setFormField('pop3_server_name', '');
						return false;
					}
			}

		/**
		 * LoginOpenidFormHandler::run()
		 *
		 * @return
		 */
		public function final_run($username,$identity_from)
			{
				$this->hashcode = md5($username.$identity_from);
				$this->esc_identity = $username;

				$id = $this->chkAlreadySignedIn($this->esc_identity,'',$identity_from);
				$id1 = $this->chkAlreadySignedIn($this->esc_identity, 'ToActivate',$identity_from);
				$id2 = $this->chkAlreadySignedIn($this->esc_identity, 'InActive',$identity_from);
				if(($id == -1 && $id1 == -1) || ($id == -1 && $id1 != -1) || ($id == -1 && $id2 != -1))
					{
						if($id1 == -1)
							{
								$this->insertIntoUserIdentity(0,$identity_from);
							}
						$normal = 'id=' . $this->hashcode;
						$htaccess = $this->hashcode . '/openid/register/';
						$cnt = $this->chkIsNotDuplicateIdentity($this->CFG['db']['tbl']['user_identity'],$this->hashcode,$identity_from);
						if($cnt!=0)
							{
								$msg = $this->LANG['user_status_blocked'];
								Redirect2URL(getUrl('externallogin', '?msg='.$msg, '?msg='.$msg, 'root'));
							}
						else
							Redirect2URL(getUrl('signupexternal', '?id='.$this->hashcode, '?id='.$this->hashcode, 'root'));
					}
				if($this->user_details_arr = getUserDetail('user_id', $id))
					{
						if($this->user_details_arr['usr_status'] !='Ok')
							{
								Redirect2URL(getUrl('externallogin', '?user_id='.$this->user_details_arr['user_id'], '?user_id='.$this->user_details_arr['user_id'], 'root'));
							}
						// $this->setCookieValue();
						$this->updateUserLog($this->CFG['db']['tbl']['users'],
											$this->CFG['remote_client']['ip'],
											session_id());

						$this->saveUserVarsInSession($this->CFG['remote_client']['ip']);

						if ($this->chkIsFirstVisit())
						    {
						        Redirect2URL(getUrl('mail', '?folder=inbox', 'inbox/', 'members'));
						    }
						else
							{
								Redirect2URL(getUrl($this->CFG['auth']['members_url']['file_name'], '', '', 'members'));
							}
					}
				else
					die('invalid');
			}

		/**
		 * LoginOpenidFormHandler::run()
		 *
		 * @return
		 */
		public function run()
			{
				$openid = $this->getOpenIDURL();
				$consumer = getConsumer();
				// Begin the OpenID authentication process.
				$auth_request = $consumer->begin($openid);
				// No auth request means we can't begin OpenID.
				if (!$auth_request)
					{
						$this->setPageBlockShow('block_msg_form_error');
						$this->setCommonErrorMsg($this->LANG['authorization_failure']);
					}
				else
					{
						$sreg_request = Auth_OpenID_SRegRequest::build(
										// Required
										array('email'),
										// Optional
										array('fullname', 'nickname', 'gender', 'dob'));

						if ($sreg_request)
							{
								$auth_request->addExtension($sreg_request);
							}
						// Redirect the user to the OpenID server for authentication.
						// Store the token for this authentication so we can verify the
						// response.

						// For OpenID 1, send a redirect.  For OpenID 2, use a Javascript
						// form to send a POST request to the server.
						if ($auth_request->shouldSendRedirect())
							{
								 $redirect_url = $auth_request->redirectURL(getTrustRoot(),
												getReturnTo());

								// If the redirect URL can't be built, display an error
								// message.
								if (Auth_OpenID::isFailure($redirect_url))
									{
										$this->setPageBlockShow('block_msg_form_error');
										$this->setCommonErrorMsg($this->LANG['openid_unable_to_redirect']);
									}
								else
									{
										// Send redirect.
										header("Location: ".$redirect_url);
									}
							}
						else
							{
								// Generate form markup and render it.
								$form_id = 'openid_message';
								$form_html = $auth_request->formMarkup(getTrustRoot(), getReturnTo(),
																		false, array('id' => $form_id));


								// Display an error if the form markup couldn't be generated;
								// otherwise, render the HTML.
								if (Auth_OpenID::isFailure($form_html))
									{
										$this->setPageBlockShow('block_msg_form_error');
										$this->setCommonErrorMsg($this->LANG['openid_unable_to_redirect']);
									}
								else
									{
										$this->CFG['mods']['is_include_only']['html_header'] = false;
										$this->CFG['html']['is_use_header'] = false;
										$page_contents = array(
																"<html><head><title>",
																"OpenID transaction in progress",
																"</title></head>",
																"<body onload='document.getElementById(\"".$form_id."\").submit()'>",
																$form_html,
																"</body></html>"
															  );
										print implode("\n", $page_contents);
										exit;
									}
							}
					}
			}

		/**
		 * LoginOpenidFormHandler::chkIsValidLoginDetail()
		 * To check if the details provided are valid
		 * @param string $err_tip
		 * @return
		 */
		public function chkIsValidLoginDetail($err_tip='')
			{
				$column = 'user_id';
				$this->user_details_arr = array();
				if($user_detail = $this->getUserDetail($column, $this->fields_arr['user_id']))
					{
						$this->user_details_arr = $user_detail;
					}
				$is_ok = false;

				if($this->user_details_arr)
					{
						switch($this->user_details_arr['usr_status'])
							{
								case 'ToActivate':
									$click_here  = getUrl('externallogin');
									$click_here = '<a href="'.$click_here.'" onClick="document.errorForm.submit();return false;">'.$this->LANG['login_click_here'].'</a>';
									$this->setCommonErrorMsg(str_replace('VAR_CLICK_HERE', $click_here, $this->LANG['login_err_to_activate']));
									// $this->setAllPageBlocksHide();
									$is_ok = false;
									break;
								case 'Locked':
									$contact_us_link  = getUrl('externallogin');
									$contact_us_link = '<a href="'.$contact_us_link.'">'.$this->LANG['login_contact_us_link'].'</a>';
									$this->setCommonErrorMsg(str_replace('VAR_CONTACT_US_LINK', $contact_us_link, $this->LANG['login_err_to_locked']));
									$is_ok = false;
									break;
								case 'Ok':
									$is_ok = true;
									break;
							}
					}
				return $is_ok;
			}

		/**
		 * LoginFormHandler::sendActivationCode()
		 *
		 * @return	void
		 */
		public function sendActivationCode()
			{
				$code = urlencode($this->getActivationCode('Signup', $this->fields_arr['user_id']));
				$activation_link = getUrl('verify', '?code='.$code, '?code='.$code);
				$activation_link = $activation_link;

				$activation_subject = $this->LANG['reactivation_login_subject'];

				$link = $this->CFG['site']['url'];
				$activation_message = $this->LANG['reactivation_login_message'];

				$this->setEmailTemplateValue('link', $link);
				$this->setEmailTemplateValue('user_name', $this->fields_arr['username']);
				$this->setEmailTemplateValue('activation_link', $activation_link);

				$is_ok = $this->_sendMail($this->fields_arr['email'], $activation_subject, $activation_message, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);

				if($is_ok)
					{
						$this->setCommonSuccessMsg($this->LANG['login_activation_code_sent']);
					}
				else
					{
						$this->setCommonSuccessMsg($this->LANG['login_activation_code_not_sent']);
					}
			}

		/**
		 * LoginFormHandler::sendCode()
		 *
		 * @return	void
		 */
		public function sendCode()
			{
				$add = ' user_id='.$this->dbObj->Param('user_id');

				$sql = 'SELECT user_id,  email, user_name FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE'.$add.' AND usr_status=\'ToActivate\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->fields_arr['email'] = $row['email'];
						$this->fields_arr['username'] = $row['user_name'];
						$this->fields_arr['user_id'] = $row['user_id'];
						$this->sendActivationCode();
					}
			}
	}
//<<<<<-------------- Class LoginOpenidFormHandler begins ---------------//
//-------------------- Code begins -------------->>>>>//
$loginfrm = new LoginOpenidFormHandler();
if(!$loginfrm->chkAllowedModule(array('external_login')))
 	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$loginfrm->setPageBlockNames(array('block_Openid','form_error'));
// Set the form fields
$loginfrm->setFormField('openid_identifier', '');
$loginfrm->setFormField('pop3_user_name', '');
$loginfrm->setFormField('pop3_password', '');
$loginfrm->setFormField('pop3_server_name', '');
$loginfrm->setFormField('imap_user_name', '');
$loginfrm->setFormField('imap_password', '');
$loginfrm->setFormField('imap_server_name', '');
$loginfrm->setFormField('msg', '');
$loginfrm->setFormField('user_id', '');
$loginfrm->setAllPageBlocksHide();
// default page block. show it. All others hidden
$loginfrm->setPageBlockShow('block_Openid');

$downloadType='';
if(isset($_SESSION['download_url']))
	{
		$_SESSION['url']=$_SESSION['download_url'];
		$downloadType=$_SESSION['download_type'];
	}
$loginfrm->setFormField('download_type',$downloadType);

if ($loginfrm->isFormPOSTed($_GET, 'msg'))
	{
		$loginfrm->sanitizeFormInputs($_GET);
		$loginfrm->setPageBlockShow('block_msg_form_error');
		$loginfrm->setCommonErrorMsg($loginfrm->getFormField('msg'));
	}
if ($loginfrm->isFormPOSTed($_GET, 'user_id'))
	{
		$loginfrm->sanitizeFormInputs($_GET);
		$loginfrm->chkIsValidLoginDetail();
		$loginfrm->setPageBlockShow('form_error');
	}
if($loginfrm->isFormPOSTed($_POST, 'code'))
	{
		$loginfrm->sanitizeFormInputs($_POST);
		$loginfrm->sendCode();
		// $loginfrm->setAllPageBlocksHide();
		$loginfrm->setCommonSuccessMsg(($loginfrm->getCommonSuccessMsg()?$loginfrm->getCommonSuccessMsg():$loginfrm->getCommonErrorMsg()));
		$loginfrm->setPageBlockShow('block_msg_form_success');
	}
if ($loginfrm->isFormPOSTed($_POST, 'verify'))
	{
		$CFG['admin']['external_login_content'] = 'OpenId';
		$loginfrm->sanitizeFormInputs($_POST);
		$loginfrm->run();
	}
else if ($loginfrm->isFormPOSTed($_POST, 'imap_verify'))
	{
		$CFG['admin']['external_login_content'] = 'Imap';
		$loginfrm->sanitizeFormInputs($_POST);
		$loginfrm->chkIsNotEmpty('imap_user_name', $LANG['login_err_tip_compulsory']);
		$loginfrm->chkIsNotEmpty('imap_password', $LANG['login_err_tip_compulsory']);
		$loginfrm->chkIsNotEmpty('imap_server_name', $LANG['login_err_tip_compulsory']);
		if ($loginfrm->isValidFormInputs())
			{
				if(!$loginfrm->imapOpen())
					{
	    				$loginfrm->setCommonErrorMsg($LANG['authorization_failure']);
						$loginfrm->setPageBlockShow('block_msg_form_error');
					}
			}
		else
			{
	    		$loginfrm->setCommonErrorMsg($LANG['authorization_failure']);
				$loginfrm->setPageBlockShow('block_msg_form_error');
			}
	}
else if ($loginfrm->isFormPOSTed($_POST, 'pop3_verify'))
	{
		$CFG['admin']['external_login_content'] = 'Pop3';
		$loginfrm->sanitizeFormInputs($_POST);
		$loginfrm->chkIsNotEmpty('pop3_user_name', $LANG['login_err_tip_compulsory']);
		$loginfrm->chkIsNotEmpty('pop3_password', $LANG['login_err_tip_compulsory']);
		$loginfrm->chkIsNotEmpty('pop3_server_name', $LANG['login_err_tip_compulsory']);
		if ($loginfrm->isValidFormInputs())
			{
				if(!$loginfrm->pop3Open())
					{
	    				$loginfrm->setCommonErrorMsg($LANG['authorization_failure']);
						$loginfrm->setPageBlockShow('block_msg_form_error');
					}
			}
		else
			{
				$loginfrm->setCommonErrorMsg($LANG['authorization_failure']);
				$loginfrm->setPageBlockShow('block_msg_form_error');
			}
	}
if ($loginfrm->isShowPageBlock('form_error'))
	{
		$loginfrm->form_error['hidden_arr'] = array('user_id');
	}
//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//
//include the header file
$loginfrm->includeHeader();
if ($CFG['admin']['external_login']['openid'])
	{
?>
<script type="text/javascript" id="__openidselector" src="<?php echo $CFG['admin']['openid_script_url'];?>" charset="utf-8"></script>
<?php
	}
if ($CFG['admin']['external_login']['facebook'])
	{
?>
		<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>
		<script type="text/javascript">
			FB_RequireFeatures(["XFBML"], function(){
				FB.Facebook.init("<?php echo $CFG['facebook']['api_key'];?>", "<?php echo $CFG['site']['url'];?>facebook/xd_receiver.htm");
				//8e1eac6825a150fe4831b9b55163e0ab
			});

			function hideButton() {
				$Jq('#facebookLogin').css('display', 'none');
				$Jq('#facebookImage').css('display', 'block');
			}

			function facebook_onlogin_ready() {
				refresh_page();
			}

			/*
			 * Do a page refresh after login state changes.
			 * This is the easiest but not the only way to pick up changes.
			 * If you have a small amount of Facebook-specific content on a large page,
			 * then you could change it in Javascript without refresh.
			 */
			function refresh_page() {
			  	if ( opener && !opener.closed) {
					self.close();
				}

			  	var a = FB.Facebook.apiClient.get_session().uid;
			  	var site_url = '<?php echo $CFG['site']['url'];?>';
			  	window.location = '<?php echo $CFG['site']['url'];?>facebook_auth.php?hashcode='+a;
			}
		</script>
<?php
	}

//include the content of the page
setTemplateFolder('root/');
$smartyObj->assign('imap_format_arr', $CFG['admin']['imap']['format_arr']);
$smartyObj->assign('facebook_support_browser',true);
$browser = new Browser();
if( $browser->getBrowser() == Browser::BROWSER_OPERA)
	{
		$smartyObj->assign('facebook_support_browser',false);
	}
$smartyObj->display('externalLogin.tpl');
$more_tabs_div = 'var more_tabs_div = new Array(';
$more_tabs_class = 'var more_tabs_class = new Array(';
if ($CFG['admin']['external_login']['openid'])
	{
		$more_tabs_div .= "'selOpenIdContent'";
		$more_tabs_class .= "'selHeaderOpenId'";
		if ($CFG['admin']['external_login']['imap']
			OR $CFG['admin']['external_login']['pop3']
				OR $CFG['admin']['external_login']['facebook'])
			{
				$more_tabs_div .= ',';
				$more_tabs_class .= ',';
			}
	}
if ($CFG['admin']['external_login']['imap'])
	{
		$more_tabs_div .= "'selImapContent'";
		$more_tabs_class .= "'selHeaderImap'";
		if ($CFG['admin']['external_login']['pop3']
			OR ($CFG['admin']['external_login']['facebook'] AND ($browser->getBrowser() == Browser::BROWSER_OPERA)))
			{
				$more_tabs_div .= ',';
				$more_tabs_class .= ',';
			}
	}
if ($CFG['admin']['external_login']['pop3'])
	{
		$more_tabs_div .= "'selPop3Content'";
		$more_tabs_class .= "'selHeaderPop3'";
		if ($CFG['admin']['external_login']['facebook'] AND ($browser->getBrowser() == Browser::BROWSER_OPERA))
			{
				$more_tabs_div .= ',';
				$more_tabs_class .= ',';
			}
	}
if ($CFG['admin']['external_login']['facebook'] AND ($browser->getBrowser() == Browser::BROWSER_OPERA))
	{
		$more_tabs_div .= "'selFacebookContent'";
		$more_tabs_class .= "'selHeaderFacebook'";
	}
$more_tabs_div .= ');';
$more_tabs_class .= ');';
?>
<script language="javascript" type="text/javascript">
	var show_div = 'sel<?php echo $CFG['admin']['external_login_content']; ?>Content';
	<?php
		echo $more_tabs_div;
		echo $more_tabs_class;
	?>
	var current_active_tab_class = 'clsActiveMoreVideosNavLink';

	//Event.observe(window, 'load', function() {
	$Jq(document).ready(function(){
		//To Show the default div and hide the other divs
		hideMoreTabsDivs(show_div); //To hide the more tabs div and set the class to empty
		showMoreTabsDivs(show_div); //To show the more tabs div and set the class to selected
	});

	function getExLoginMoreContent(div_id, current_li_id) {
		//result_div = div_id;
		more_li_id = current_li_id;
		hideMoreTabsDivs(div_id);
		showMoreTabsDivs(div_id);
	}
</script>
<?php
//include the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$loginfrm->includeFooter();
?>