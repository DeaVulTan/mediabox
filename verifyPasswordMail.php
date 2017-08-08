<?php
/**
 * Verifies the Confirmation link for password retrieval mechanism.
 *
 * This file is used to provide new password to the user when they apply for new password.
 * It Checks whether the confirmation URL was valid & accept the new password from user.
 * @category	RAYZZ
 * @package		ROOT
 */
require_once('common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/root/verifyPasswordMail.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'root';
require($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------- Class ForgotpasswordFormHandler begins ---------------->>>>>//
/**
 * verifyMailHandler
 * This class handles the user forget password options
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class verifyMailHandler extends FormHandler
	{
		/**
		 * verifyMailHandler::chkCorrectUsername()
		 *
		 * @param $err_tip
		 * @return
		 **/
		public function chkCorrectUsername($err_tip)
			{
				$user_id = $this->getUserId();
				if($this->chkIsValidActivationCode($this->fields_arr['code'], 'Forgotpass', $user_id) && $user_id)
					{
						$this->fields_arr['user_id'] = $user_id;
						return true;
					}
				else
					{
						$this->fields_err_tip_arr['username'] = $err_tip;
						return false;
					}
			}

		/**
		 * verifyMailHandler::getUserId()
		 * To fetch the user_id of given user_name
		 *
		 * @return
		 **/
		public function getUserId()
			{
				if($row = getUserDetail('user_name', $this->fields_arr['username']))
					return $row['user_id'];
			}

		/**
		 * Check Password Fields are Equal or Not
		 *
		 * @param $field1
		 * @param $field2
		 * @param $err_tip
		 * @return
		 **/
		public function chkIsEqualPassword($field1,$field2,$err_tip)
			{
				if($this->fields_arr[$field1]=='' or $this->fields_arr[$field2]=='')
					return;
				else
					{
						if($this->fields_arr[$field1] != $this->fields_arr[$field2])
							{
								$this->fields_err_tip_arr[$field2] = $err_tip;
								$this->fields_err_tip_arr[$field1] = $err_tip;
								$this->fields_arr[$field1] = '';
								$this->fields_arr[$field2] = '';
							}
					}
			}

		/**
		 * verifyMailHandler::updateNewPassword()
		 * To update password
		 *
		 * @return
		 **/
		public function updateNewPassword()
			{
				$sql = ' UPDATE '.$this->CFG['db']['tbl']['users'].' SET'.
						'  password = '.$this->dbObj->Param('password').','.
						'  bba_token = '.$this->dbObj->Param('bba_token').
						' WHERE user_id = '.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array(md5($this->fields_arr['password'].$this->fields_arr['bba_token']), $this->fields_arr['bba_token'], $this->fields_arr['user_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				return true;
			}

		/**
		 * verifyMailHandler::displayMandatoryIcon()
		 * Display the mandatory icon
		 *
		 * @param  string $field_name
		 * @return string
		 * @access public
		 */
		public function displayMandatoryIcon($field_name='')
			{
				$mandatoryFields = array('username', 'password', 'confirm_password');
				if($field_name == '*' OR (in_array($field_name, $mandatoryFields)))
					{
						$this->displayCompulsoryIcon();
					}
			}

		/**
		 * verifyMailHandler::chkIsPasswordAndUserNameAreSame()
		 * Checks whether username and password are same
		 *
		 * @param  string $err_tip
		 * @return boolean
		 * @access public
		 */
		public function chkIsPasswordAndUserNameAreSame($err_tip = '')
			{
				if($this->fields_arr['username'] and $this->fields_arr['password'])
					{
						if($this->fields_arr['username'] == $this->fields_arr['password'])
							{
								$this->fields_err_tip_arr['password'] = $err_tip;
								return false;
							}
					}
				return true;
			}
	}
//<<<<<--------------- Class ForgotpasswordFormHandler ends -------------//
//-------------------- Code begins -------------->>>>>//
$verifyfrm = new verifyMailHandler();

if(!$verifyfrm->chkAllowedModule(array('forgotpassword')))
	Redirect2URL(getUrl($CFG['redirect']['dsabled_module_url']['file_name']));
$verifyfrm->setPageBlockNames(array('form_verifymail', 'form_username'));
$verifyfrm->setFormField('code', '');
$verifyfrm->setFormField('user_id', '');
$verifyfrm->setFormField('password', '');
$verifyfrm->setFormField('confirm_password', '');
$verifyfrm->setFormField('password', '');
$verifyfrm->setFormField('username', '');
$verifyfrm->setFormField('bba_token', $verifyfrm->generateBBAToken());
$verifyfrm->setAllPageBlocksHide();
$verifyfrm->setPageBlockShow('form_username');
if ($verifyfrm->isFormGETed($_GET, 'code'))
	{
    	$verifyfrm->sanitizeFormInputs($_GET);
	}
if ($verifyfrm->isFormPOSTed($_POST, 'verifyUsername'))
	{
		$verifyfrm->sanitizeFormInputs($_POST);
		$verifyfrm->chkIsNotEmpty('username',$LANG['common_err_tip_required']);
		if($verifyfrm->isValidFormInputs())
			{
				$verifyfrm->chkCorrectUsername($LANG['err_tip_invalid']);
				if($verifyfrm->isValidFormInputs())
					{
						$verifyfrm->setAllPageBlocksHide();
						$verifyfrm->setPageBlockShow('form_verifymail');
					}
				else
					{
						$verifyfrm->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$verifyfrm->setPageBlockShow('block_msg_form_error');
					}
			}
		else
			{
				$verifyfrm->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$verifyfrm->setPageBlockShow('block_msg_form_error');

			}
	}
if ($verifyfrm->isFormPOSTed($_POST, 'verifymail'))
	{
		$verifyfrm->sanitizeFormInputs($_POST);
		if($verifyfrm->chkCorrectUsername($LANG['err_tip_invalid']))
			{
				$verifyfrm->chkIsNotEmpty('password', $LANG['common_err_tip_required']);
				$verifyfrm->chkIsNotEmpty('confirm_password', $LANG['common_err_tip_required']);
				$verifyfrm->chkIsPasswordAndUserNameAreSame($LANG['err_tip_password_user_name']);

				if($verifyfrm->isValidFormInputs())
					{
						$verifyfrm->chkIsEqualPassword('password','confirm_password',$LANG['err_tip_pasword_equal']);
						if($verifyfrm->isValidFormInputs())
							{
								$verifyfrm->updateNewPassword();
								$verifyfrm->deleteActivationCode('Forgotpass', $verifyfrm->getFormField('user_id'));
								$verifyfrm->setAllPageBlocksHide();
								$CFG['feature']['auto_hide_success_block'] = false;
								$verifyfrm->setCommonSuccessMsg($LANG['verified_successfully']);
								$verifyfrm->setPageBlockShow('block_msg_form_success');
							}
						else
							{
								$verifyfrm->setFormField('password','');
								$verifyfrm->setFormField('confirm_password','');
								$verifyfrm->setAllPageBlocksHide();
								$verifyfrm->setPageBlockShow('form_verifymail');
								$verifyfrm->setCommonErrorMsg($LANG['common_msg_error_sorry']);
								$verifyfrm->setPageBlockShow('block_msg_form_error');
							}
					}
				else
					{
						$verifyfrm->setAllPageBlocksHide();
						$verifyfrm->setPageBlockShow('form_verifymail');
						$verifyfrm->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$verifyfrm->setPageBlockShow('block_msg_form_error');
					}
			}
		else
			{
				$verifyfrm->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$verifyfrm->setPageBlockShow('block_msg_form_error');
			}
	}

if ($verifyfrm->isShowPageBlock('form_username'))
	{
		$verifyfrm->LANG['verifymail_user_name_errormsg'] = str_replace('VAR_MIN', $CFG['fieldsize']['username']['min'], $LANG['common_err_tip_invalid_character_size']);
		$verifyfrm->LANG['verifymail_user_name_errormsg'] = str_replace('VAR_MAX', $CFG['fieldsize']['username']['max'], $verifyfrm->LANG['verifymail_user_name_errormsg']);
	}
if ($verifyfrm->isShowPageBlock('form_verifymail'))
	{
		$verifyfrm->LANG['verifymail_password_errormsg'] = str_replace('VAR_MIN', $CFG['fieldsize']['password']['min'], $LANG['common_err_tip_invalid_password']);
		$verifyfrm->LANG['verifymail_password_errormsg'] = str_replace('VAR_MAX', $CFG['fieldsize']['password']['max'], $verifyfrm->LANG['verifymail_password_errormsg']);
	}
//<<<<<------------ Code ends --------------------------//
$verifyfrm->includeHeader();
setTemplateFolder('root/');
$smartyObj->display('verifyPasswordMail.tpl');
if ($CFG['feature']['jquery_validation']) {
	if ($verifyfrm->isShowPageBlock('form_username'))
		{
?>
<script type="text/javascript">
	$Jq("#selFormVerifyMail").validate({
		rules: {
			username: {
				required: true,
				minlength: <?php echo $CFG['fieldsize']['username']['min']; ?>,
				maxlength: <?php echo $CFG['fieldsize']['username']['max']; ?>
		    }
		},
		messages: {
			username: {
				required: "<?php echo $verifyfrm->LANG['verifymail_user_name_errormsg'];?>",
				minlength: jQuery.format("{0} <?php echo $verifyfrm->LANG['common_err_tip_min_characters'];?>"),
				maxlength: jQuery.format("<?php echo $verifyfrm->LANG['common_err_tip_max_characters'];?> {0}")
			}
		}
	});
</script>
<?php
		}
	if ($verifyfrm->isShowPageBlock('form_verifymail'))
		{
?>
<script type="text/javascript">
	$Jq("#selFormVerifyMail").validate({
		rules: {
		    password: {
		    	required: true,
		    	minlength: <?php echo $CFG['fieldsize']['password']['min']; ?>,
				maxlength: <?php echo $CFG['fieldsize']['password']['max']; ?>
		    },
		    confirm_password: {
		    	equalTo: "#password"
		    }
		},
		messages: {
			password: {
				required: "<?php echo $verifyfrm->LANG['verifymail_password_errormsg'];?>"
			},
			confirm_password: {
				equalTo: "<?php echo $verifyfrm->LANG['err_tip_pasword_equal'];?>"
			}
		}
	});
</script>
<?php
		}
	}
$verifyfrm->includeFooter();
?>