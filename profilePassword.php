<?php
/**
 * This file is to Change Member's Password
 *
 *
 * @category	Rayzz
 * @package		Members
 */
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'common/configs/config_members.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/members/profilePassword.php';
$CFG['lang']['include_files'][] = 'languages/%s/members/profileTabText.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';

$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------------------class EditPasswordFormHandler-------------------->>>
/**
 * EditPasswordFormHandler
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class EditPasswordFormHandler extends FormHandler
	{
		 /**
		  * To update the form values into users table
		  *
		  * @param 		string $table_name Table name
		  * @param 		integer $user_id User id
		  * @param 		array $fields_to_update_arr Array of fields to update
		  * @return 	void
		  * @access 	public
		  */
		public function updateFormFieldsInUsersTable($table_name, $user_id, $fields_to_update_arr=array())
			{
				$sql = 'UPDATE '.$table_name.' SET ';
				foreach($fields_to_update_arr as $field_name)
					if (isset($this->fields_arr[$field_name]))
						{
							$sql .= $field_name.'='.$this->dbObj->Param($this->fields_arr[$field_name]).', ';
							$paramFields[] = $this->fields_arr[$field_name];
						}
				$sql = substr($sql, 0, strrpos($sql, ','));
				$sql .= ' WHERE user_id ='.$this->dbObj->Param($user_id);

				$paramFields[] = $user_id;
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, $paramFields);
				//raise user error... fatal
				if (!$rs)
				    trigger_db_error($this->dbObj);

				$updated = 	($this->dbObj->Affected_Rows()>0);

				return $updated;
			}

		/**
		 * EditPasswordFormHandler::chkIsValidSize()
		 *
		 * @param mixed $field_name
		 * @param mixed $min
		 * @param mixed $max
		 * @param string $err_tip
		 * @return
		 */
		public function chkIsValidSize($field_name, $min, $max, $err_tip = '')
			{
				if((mb_strlen($this->fields_arr[$field_name], $this->CFG['site']['charset'])<$min)
						or (mb_strlen($this->fields_arr[$field_name], $this->CFG['site']['charset'])>$max))
					{
						$this->fields_err_tip_arr[$field_name] = $err_tip;
						return false;
					}
				return true;
			}

		/**
		 * To check the confirmation of password and password are same
		 *
		 * @param 		string $field_name1 password Field name
		 * @param 		string $field_name2 confirmation password field name
		 * @param 		string $err_tip error tip message
		 * @return 		boolean $is_ok true/false
		 * @access 		public
		 */
		public function chkIsSamePasswords($field_name1, $field_name2, $err_tip='')
			{
				$is_ok = ($this->fields_arr[$field_name1]==$this->fields_arr[$field_name2]);
				if (!$is_ok)
					$this->fields_err_tip_arr[$field_name1] = $this->fields_err_tip_arr[$field_name2] = $err_tip;
				return $is_ok;
			}

		/**
		 * EditPasswordFormHandler::isValidCurrentPassword()
		 *
		 * @param string $err_tip
		 * @return
		 */
		public function isValidCurrentPassword($err_tip = '')
			{
				if ($user_detail = getUserDetail('user_id', $this->CFG['user']['user_id']))
					{
						$current_password = md5($this->fields_arr['current_password'].$user_detail['bba_token']);
					  	$password = $user_detail['password'];
					  	$valid = (strcmp($current_password, $password)==0);
						if ($valid)
						    {
						    	return true;
						    }
					}
				$this->fields_err_tip_arr['current_password'] = $err_tip;
				return false;
			}

		/**
		 * EditPasswordFormHandler::chkIsPasswordAndUserNameAreSame()
		 *
		 * @param string $err_tip
		 * @return
		 */
		public function chkIsPasswordAndUserNameAreSame($err_tip = '')
			{
				if($this->CFG['user']['user_name'] and $this->fields_arr['password_new'])
					{
						if($this->CFG['user']['user_name'] == $this->fields_arr['password_new'])
							{
								$this->fields_err_tip_arr['password_new'] = $err_tip;
								return false;
							}
					}
				return true;
			}

		/**
		 * EditPasswordFormHandler::displayMandatoryIcon()
		 * Display the mandatory icon if the form field is listed in mandatory fields array
		 *
		 * @param  string $field_name
		 * @return string
		 * @access public
		 */
		public function displayMandatoryIcon($field_name='')
			{
				$mandatoryFields = array('current_password', 'password_new', 'confirm_password');
				if($field_name == '*' OR (in_array($field_name, $mandatoryFields)))
					{
						$this->displayCompulsoryIcon();
					}
			}
	}
//<<<<<---------------class EditPasswordFormHandler------///

//--------------------Code begins-------------->>>>>//
$LANG['profile_password_password'] = str_replace('VAR_MIN_COUNT', $CFG['fieldsize']['password']['min'], $LANG['profile_password_password']);
$LANG['profile_password_password'] = str_replace('VAR_MAX_COUNT', $CFG['fieldsize']['password']['max'], $LANG['profile_password_password']);
$password = new EditPasswordFormHandler();
$password->setPageBlockNames(array('msg_form_error', 'msg_form_success', 'form_change_password'));
$password->setFormField('user_id', $CFG['user']['user_id']);
$password->setFormField('username', $CFG['user']['user_name']);
$password->setFormField('current_password', '');
$password->setFormField('password_new', '');
$password->setFormField('confirm_password', '');
$password->setFormField('password', '');
$password->setFormField('bba_token', $password->generateBBAToken());

// Default page block
$password->setAllPageBlocksHide();
$password->setPageBlockShow('form_change_password');
$password->form_change_password['password_label']=$LANG['profile_password_password'];

if ($password->isFormPOSTed($_POST, 'password_submit'))
	{
		$password->sanitizeFormInputs($_POST);
		// Validations
		$password->chkIsNotEmpty('current_password', $LANG['profile_password_err_tip_compulsory']);
		$password->chkIsPasswordAndUserNameAreSame($LANG['password_user_name']);
		$password->chkIsNotEmpty('password_new', $LANG['profile_password_err_tip_compulsory']) and
				$password->chkIsValidSize('password_new', $CFG['fieldsize']['password']['min'], $CFG['fieldsize']['password']['max'], $LANG['err_tip_invalid_size']);
		$password->chkIsNotEmpty('confirm_password', $LANG['profile_password_err_tip_compulsory']) and
			$password->chkIsSamePasswords('password_new', 'confirm_password', $LANG['profile_password_err_tip_same_password']);

		if ($password->isValidFormInputs())
			{
				$password->isValidCurrentPassword($LANG['profile_password_err_tip_invalid_current_password']);
			}

		if ($password->isValidFormInputs())
			{
				$password->setFormField('password',md5($password->getFormField('password_new').$password->getFormField('bba_token')));
				$password->updateFormFieldsInUsersTable($CFG['db']['tbl']['users'], $CFG['user']['user_id'], array('password', 'bba_token'));
				$password->setFormField('password',$password->getFormField('password_new'));
				$password->setAllPageBlocksHide();
				$password->setPageBlockShow('form_change_password');
				$password->setPageBlockShow('block_msg_form_success');
				$password->setCommonSuccessMsg($LANG['profile_password_success_message']);
				$password->setFormField('current_password', '');
				$password->setFormField('password_new', '');
				$password->setFormField('confirm_password', '');
				//Redirect2URl(getUrl($CFG['admin']['profile_urls']['password']['normal'], $CFG['admin']['profile_urls']['password']['htaccess']).'?success=1');
			}
		else //error in form inputs
			{
				$password->setAllPageBlocksHide();
				$password->setPageBlockShow('block_msg_form_error');
				$password->setPageBlockShow('form_change_password');
				$password->setCommonErrorMsg($LANG['common_msg_error_sorry']);
			}
	}
if ($password->isPageGETed($_GET, 'success'))
    {
		$password->setAllPageBlocksHide();
		$password->setPageBlockShow('form_change_password');
		$password->setPageBlockShow('block_msg_form_success');
		$password->setCommonSuccessMsg($LANG['profile_password_success_message']);
    }
if(isset($CFG['admin']['is_demo_site']) and $CFG['admin']['is_demo_site'])
	{
		$password->setAllPageBlocksHide();
		$password->setPageBlockShow('block_msg_form_error');
		$password->setCommonErrorMsg($LANG['profile_password_cannot_change']);
	}
$password->LANG['profile_password_errormsg'] = '';
if ($password->isShowPageBlock('form_change_password'))
	{
		$password->LANG['profile_password_errormsg'] = str_replace('VAR_MIN', $CFG['fieldsize']['password']['min'], $LANG['common_err_tip_invalid_password']);
		$password->LANG['profile_password_errormsg'] = str_replace('VAR_MAX', $CFG['fieldsize']['password']['max'], $password->LANG['profile_password_errormsg']);
	}
//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//
//include the header file
$password->includeHeader();
//include the content of the page
setTemplateFolder('members/');
$smartyObj->display('profilePassword.tpl');
//<<<<<<--------------------Page block templates Ends--------------------//
if ($CFG['feature']['jquery_validation']) {
?>
<script type="text/javascript">
	$Jq("#selFormEditProfile").validate({
		rules: {
		    current_password: {
		    	required: true,
		    	minlength: <?php echo $CFG['fieldsize']['password']['min']; ?>,
				maxlength: <?php echo $CFG['fieldsize']['password']['max']; ?>
		    },
		    password_new: {
		    	required: true,
		    	minlength: <?php echo $CFG['fieldsize']['password']['min']; ?>,
				maxlength: <?php echo $CFG['fieldsize']['password']['max']; ?>
		    },
		    confirm_password: {
		    	equalTo: "#password_new"
		    }
		},
		messages: {
			current_password: {
				required: "<?php echo $password->LANG['profile_password_errormsg'];?>"
			},
			password_new: {
				required: "<?php echo $password->LANG['profile_password_errormsg'];?>"
			},
			confirm_password: {
				equalTo: "<?php echo $password->LANG['profile_password_err_tip_same_password'];?>"
			}
		}
	});
</script>
<?php
}
//includ the footer of the page
$password->includeFooter();
?>