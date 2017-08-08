<?php
/**
 * File to handle the forget password
 *
 * Using this file if the user forget his password detail, by entering some
 * required information the user can get his password back to his mail.
 *
 *
 * @category	RAYZZ
 * @package		ROOT
 */
require_once('common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/root/forgotPassword.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'root';

require($CFG['site']['project_path'].'common/application_top.inc.php');
//--------------class ForgotpasswordFormHandler--------------->>>//
/**
 * ForgotpasswordFormHandler
 * This class handles the user forget password options
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class ForgotpasswordFormHandler extends FormHandler
	{
		/**
		  * ForgotpasswordFormHandler::chkIsValidUser()
          * To check valid user
          *
          * @param 		string $table_name  table name
          * @param 		string $email email of the users
          * @param 		string $user_name user name of the users
          * @access 	public
          * @return 	boolean
          **/
		public function chkIsValidUser($user_table, $email, $user_name)
			{
				$sql = 'SELECT user_id, user_name, usr_status ,openid_used FROM '.$user_table.
						' WHERE email= '.$this->dbObj->Param('email').' AND usr_status!=\'Deleted\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr[$email]));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$is_ok = false;
				if ($rs->PO_RecordCount())
					{
					    $row = $rs->FetchRow();
						$this->fields_arr['user_name'] = $row['user_name'];
						$this->fields_arr['user_id'] = $row['user_id'];
						$this->fields_arr['openid_used'] = $row['openid_used'];
						if($row['openid_used'] == 'Yes')
							{
								$this->setCommonErrorMsg($this->LANG['forgot_openid_error']);
								$is_ok = false;
							}
						else
							{
								switch($row['usr_status'])
									{
										case 'ToActivate':
											$click_here  = getUrl('login', '','');
											$click_here = '<a href="'.$click_here.'" onClick="document.errorForm.submit();return false;">'.$this->LANG['click_here'].'</a>';
											$this->setCommonErrorMsg(str_replace('VAR_CLICK_HERE', $click_here, $this->LANG['forgot_err_to_activate']));
											$this->setAllPageBlocksHide();
											$is_ok = false;
											break;
										case 'Locked':
											$contact_us_link  = getUrl('contactus', '','');
											$contact_us_link = '<a href="'.$contact_us_link.'">'.$this->LANG['contact_us_link'].'</a>';
											$this->setCommonErrorMsg(str_replace('VAR_CONTACT_US_LINK', $contact_us_link, $this->LANG['forgot_err_to_locked']));
											$is_ok = false;
											break;
										case 'Ok':
											$is_ok = true;
											break;
									}
							}
					}
				else
					{
						$this->setCommonErrorMsg($this->LANG['forgot_err_tip_data_not_exists']);
					}
				return $is_ok;
			}

		/**
		 * ForgotpasswordFormHandler::sendForgotActivationCode()
		 * To send the activation code
		 *
		 * @param 		string $field_user_id user id
		 * @param 		string $field_email email
		 * @param 		string $activation_subj mail subject
		 * @param 		string $activation_msg mail message content
		 * @param 		string $return_url return url
		 * @param 		string $sender_name sender name
		 * @param 		string $sender_email sender email
		 * @return 		boolean
		 * @access 		public
		 */
		public function sendForgotActivationCode()
			{
				$activation_link = getUrl('verifypasswordmail', '','').'?code='.urlencode($this->getActivationCode('Forgotpass', $this->fields_arr['user_id']));
				$this->setEmailTemplateValue('user_name', $this->fields_arr['user_name']);
				$this->setEmailTemplateValue('link', $this->CFG['site']['url']);
				$this->setEmailTemplateValue('activation_link', $activation_link);
				$is_ok = $this->_sendMail($this->fields_arr['email'],$this->LANG['forgot_subject'], $this->LANG['forgot_message'], $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);
				if($is_ok)
					$this->setCommonSuccessMsg($this->LANG['forgot_activation_code_sent']);
				else
					$this->setCommonSuccessMsg($this->LANG['forgot_activation_code_not_sent']);
			}

		/**
		 * ForgotpasswordFormHandler::sendActivationCode()
		 * To send activation code
		 * @return void
		 * @access public
		 */
		public function sendActivationCode()
			{
				$activation_link = getUrl('verify', '','').'?code='.urlencode($this->getActivationCode('Forgotpass', $this->fields_arr['user_id']));
				$this->setEmailTemplateValue('user_name', $this->fields_arr['user_name']);
				$this->setEmailTemplateValue('link', $this->CFG['site']['url']);
				$this->setEmailTemplateValue('activation_link', $activation_link);
				$is_ok = $this->_sendMail($this->fields_arr['email'], $this->LANG['reactivation_forgotpass_subject'], $this->LANG['reactivation_forgotpass_message'], $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);
				if($is_ok)
					$this->setCommonSuccessMsg($this->LANG['forgot_reactivation_code_sent']);
				else
					$this->setCommonSuccessMsg($this->LANG['forgot_reactivation_code_not_sent']);
			}

		/**
		 * ForgotpasswordFormHandler::sendCode()
		 *
		 * @return void
		 * @access public
		 */
		public function sendCode()
			{
				$sql = 'SELECT user_id,  email FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_name='.$this->dbObj->Param('user_name').
						' AND usr_status=\'ToActivate\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_name']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->fields_arr['email'] = $row['email'];
						$this->fields_arr['user_id'] = $row['user_id'];
						$this->sendActivationCode();
					}
			}

		/**
		 * ForgotpasswordFormHandler::displayMandatoryIcon()
		 * Display the mandatory icon
		 *
		 * @param  string $field_name
		 * @return string
		 * @access public
		 */
		public function displayMandatoryIcon($field_name='')
			{
				$mandatoryFields = array('email');
				if($field_name == '*' OR (in_array($field_name, $mandatoryFields)))
					{
						$this->displayCompulsoryIcon();
					}
			}
	}
//<<<<<--------------- Class ForgotpasswordFormHandler ends -------------//
//-------------------- Code begins -------------->>>>>//
$forgotpasswordfrm = new ForgotpasswordFormHandler();

if(!$forgotpasswordfrm->chkAllowedModule(array('forgotpassword')))
	Redirect2URL(getUrl($CFG['redirect']['dsabled_module_url']['file_name']));

$forgotpasswordfrm->setPageBlockNames(array('block_Forgotpassword','msg_form_error'));
$forgotpasswordfrm->setFormField('email', '');
$forgotpasswordfrm->setFormField('user_id', '');
$forgotpasswordfrm->setFormField('user_name', '');
$forgotpasswordfrm->setAllPageBlocksHide();
$forgotpasswordfrm->setPageBlockShow('block_Forgotpassword');
if ($forgotpasswordfrm->isFormPOSTed($_POST, 'forgot_reset'))
	{
		$forgotpasswordfrm->setFormField('email', '');
	}
if ($forgotpasswordfrm->isFormPOSTed($_POST, 'forgot_submit'))
	{
		$forgotpasswordfrm->sanitizeFormInputs($_POST);
		$forgotpasswordfrm->chkIsNotEmpty('email', $LANG['forgot_err_tip_compulsory']) and
			$forgotpasswordfrm->chkIsValidEmail('email', $LANG['forgot_err_tip_invalid_email']);
		if ($forgotpasswordfrm->isValidFormInputs())
			{
				if ($forgotpasswordfrm->chkIsValidUser($CFG['db']['tbl']['users'], 'email', 'user_name'))
					{
						$forgotpasswordfrm->sendForgotActivationCode();
						$forgotpasswordfrm->setAllPageBlocksHide();
						$CFG['feature']['auto_hide_success_block'] = false;
						$forgotpasswordfrm->setPageBlockShow('block_msg_form_success');
						$forgotpasswordfrm->setCommonSuccessMsg($LANG['forgot_success']);
					}
				else
					{
						$forgotpasswordfrm->setPageBlockShow('block_msg_form_error');
						$forgotpasswordfrm->setCommonErrorMsg($LANG['forgot_err_tip_data_not_exists']);
					}
			}
		else
			{
				$forgotpasswordfrm->setPageBlockShow('block_msg_form_error');
				$forgotpasswordfrm->setCommonErrorMsg($LANG['forgot_err_tip_invalid_email']);
			}
	}
if($forgotpasswordfrm->isFormPOSTed($_POST, 'code'))
	{
		$forgotpasswordfrm->sanitizeFormInputs($_POST);
		$forgotpasswordfrm->sendCode();
		$forgotpasswordfrm->setAllPageBlocksHide();
		$CFG['feature']['auto_hide_success_block'] = false;
		$forgotpasswordfrm->setPageBlockShow('block_msg_form_success');
	}
//<<<<--------------------Code Ends----------------------//

if ($forgotpasswordfrm->isShowPageBlock('msg_form_error'))
	{
		$forgotpasswordfrm->form_error['hidden_arr'] = array('user_name');
	}
$forgotpasswordfrm->includeHeader();
setTemplateFolder('root/');
$smartyObj->display('forgotPassword.tpl');
if ($CFG['feature']['jquery_validation']) {
?>
<script type="text/javascript">
	$Jq("#form_Forgotpassword").validate({
		rules: {
		    email: {
		    	required: true,
				isValidEmail: true
		    }
		},
		messages: {
			email: {
				required: "<?php echo $forgotpasswordfrm->LANG['common_err_tip_required'];?>",
				isValidEmail: "<?php echo $forgotpasswordfrm->LANG['common_err_tip_email'];?>"
			}
		}
	});
</script>
<?php
}
$forgotpasswordfrm->includeFooter();
?>