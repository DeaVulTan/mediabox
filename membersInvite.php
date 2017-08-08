<?php
/**
 * This file Sends invitation to the invited persons.
 *
 * PHP version 5.0
 * @category Rayzz
 * @package	 Members
 */
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'common/configs/config_members.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/members/membersInvite.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FriendHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/recaptchalib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
require($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------------------class MembersInvitationHandler-------------------->>>
/* This class is used to invite friends
 *
 * @category	Rayzz
 * @package		Members
 */
class MembersInvitationHandler extends FriendHandler
	{
		private $invitationCode = array();
		public $invalid_email_arr = array();
		public $exist_user_email_arr = array();
		public $sent_email_arr = array();
		public $publickey;
		public $privatekey;
		public $error = null;
		public $resp = null;

		/**
		 * MembersInvitationHandler::chkIsValidEmail()
		 * To check the valid email format or not.
		 * And its averwrite for set the success mail list, exist user mail list and invalid mail list details.
		 *
		 * @param  mixed $field_name
		 * @param  string $err_tip
		 * @param  mixed $is_chk_mxrr
		 * @return boolean
		 * @access public
		 */
		public function chkIsValidEmail($field_name, $err_tip='', $is_chk_mxrr=false)
			{
				return $is_ok = (preg_match("/^\S+@\S+\.\S+$/i", $this->fields_arr[$field_name]));
			}

		/**
		 * MembersInvitationHandler::validateEmailInRayzz()
		 * To check valid email
		 *
		 * @param  mixed $email
		 * @return void
		 * @access public
		 */
		public function validateEmailInRayzz($email)
			{
				$this->fields_arr['email_temp'] = $email;

				if(!$this->chkIsValidEmail('email_temp'))
					{
						if(!empty($email))
							$this->invalid_email_arr['email'][] = $email;
						return;
					}
				if (strcmp(strtolower($email), strtolower($this->CFG['user']['email']))==0)
				    {
				        $this->exist_user_email_arr['email'][] = $email;
						$this->exist_user_email_arr['user_name'][] = $this->CFG['user']['user_name'];
						$this->exist_user_email_arr['user_id'][] = $this->CFG['user']['user_id'];
						return;
				    }
				if ($udetails = $this->isMemberJoined($email))
				    {
					 	$this->exist_user_email_arr['email'][] = $email;
						$this->exist_user_email_arr['user_name'][] = $udetails['user_name'];
						$this->exist_user_email_arr['user_id'][] = $udetails['user_id'];
						return;
					}

				$this->sent_email_arr['email'][] = $email;
			}

		/**
		 * MembersInvitationHandler::chkIsValidInputsProvided()
		 * To check whether the input is valid or not
		 *
		 * @return void
		 * @access public
		 */
		public function chkIsValidInputsProvided()
			{
				$email_arr = str_replace(' ','',$this->fields_arr['to_emails']);
				$email_arr = explode(',', $email_arr);
				$email_arr =array_unique($email_arr);

				foreach($email_arr as $key=>$value)
					{
						$this->validateEmailInRayzz($email_arr[$key]);
					}
			}

		/**
		 * MembersInvitationHandler::sendInvitationToFriends()
		 * To send the invitation to friends
		 *
		 * @return void
		 * @access public
		 */
		public function sendInvitationToFriends()
			{
				$emails = isset($this->sent_email_arr['email'])?$this->sent_email_arr['email']:array();
				$exist_user_email = isset($this->exist_user_email_arr['email'])?$this->exist_user_email_arr['email']:array();
				foreach ($emails as $key=>$value)
					{
						$this->sendFriendRequestToThisEmailId($value);
					}
				if(isset($this->fields_arr['send_copy']) && ($this->fields_arr['send_copy']) && (empty($exist_user_email)))
					{
						$this->sendMailCopytoMyEmailId($this->getFormField('from_email'));
					}
				return true;
			}

		/**
		 * MembersInvitationHandler::isMemberJoined()
		 * To check whether email is already member or not
		 *
		 * @param  string $email
		 * @return array
		 * @access public
		 */
		public function isMemberJoined($email='')
			{
				$sql = 'SELECT email, first_name, last_name, user_id, user_name'.
						' FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE email='.$this->dbObj->Param($email).
						' AND usr_status=\'Ok\''.
						' LIMIT 1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($email));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$user_details = '';
				if ($rs->PO_RecordCount())
					{
						$user_details = $rs->FetchRow();
				    }
				return $user_details;
			}

		/**
		 * MembersInvitationHandler::displaySuccessMessage()
		 * To display the success message
		 *
		 * @return
		 */
		public function displaySuccessMessage()
			{
				$display_success_message = array();

				if(isset($this->sent_email_arr['email']) and sizeOf($this->sent_email_arr['email']))
					{
						$display_success_message['sent_email']['title'] = $this->LANG['sent_email_addresses'];
						$inc = 0;
						foreach($this->sent_email_arr['email'] as $key=>$value)
							{
								$display_success_message['sent_email']['email'][$inc] = $value;
								$inc++;
							}
					}

				if(isset($this->exist_user_email_arr['email']) and sizeOf($this->exist_user_email_arr['email']))
					{
						$display_success_message['exist_email']['title'] = $this->LANG['existing_member_list'];
						$inc = 0;
						foreach($this->exist_user_email_arr['email'] as $key=>$value)
							{
								$display_success_message['exist_email']['email'][$inc]['value'] = $value;
								$memberProfileUrl = getMemberProfileUrl($this->exist_user_email_arr['user_id'][$key], $this->exist_user_email_arr['user_name'][$key]);
								$display_success_message['exist_email']['email'][$inc]['profile_url'] = $memberProfileUrl;
								$display_success_message['exist_email']['email'][$inc]['user_name']   = $this->exist_user_email_arr['user_name'][$key];
								$inc++;
							}
					}

				if(isset($this->invalid_email_arr['email']) and sizeOf($this->invalid_email_arr['email']))
					{
						$display_success_message['invalid_email']['title'] = $this->LANG['invalid_email_ids'];
						$inc = 0;
						foreach($this->invalid_email_arr['email'] as $key=>$value)
							{
								$display_success_message['invalid_email']['email'][$inc] = $value;
								$inc++;
							}
					}
				return $display_success_message;
			}
	}
//<<<<<---------------class MembersInvitationHandler------///
//--------------------Code begins-------------->>>>>//
$invitefrm = new MembersInvitationHandler();

$invitefrm->setPageBlockNames(array('form_invite', 'form_success_msg'));
$invitefrm->setAllPageBlocksHide();
$invitefrm->setPageBlockShow('form_invite');
$invitefrm->makeGlobalize($CFG, $LANG);
$invitefrm->setFormField('user_id', $CFG['user']['user_id']);
$invitefrm->setFormField('to_emails', '');
$invitefrm->setFormField('from_email', $CFG['user']['email']);
$invitefrm->setFormField('from_name', $CFG['user']['user_name']);
$invitefrm->setFormField('personal_message', '');
$invitefrm->setFormField('send_copy', '');
$invitefrm->setFormField('recaptcha_challenge_field', '');
$invitefrm->setFormField('recaptcha_response_field', '');

$invitefrm->sanitizeFormInputs($_REQUEST);

if ($invitefrm->isFormPOSTed($_POST, 'invite_submit'))
    {
		$invitefrm->setAllPageBlocksHide();

		$invitefrm->chkIsNotEmpty('from_email', $LANG['err_tip_compulsory']) and
				$invitefrm->chkIsValidEmail('from_email', $LANG['msg_err_tip_invalid_email']);

		$invitefrm->chkIsNotEmpty('to_emails', $LANG['err_tip_compulsory']) and
			$invitefrm->chkIsValidInputsProvided();

		if($CFG['mail']['captcha'])
			{
				if($CFG['mail']['mail_captcha_method'] == 'recaptcha'and $CFG['captcha']['public_key'] and $CFG['captcha']['private_key'])
					{
						$invitefrm->chkIsNotEmpty('recaptcha_response_field', $LANG['common_err_tip_compulsory']) and
							$invitefrm->chkCaptcha('recaptcha_response_field', $LANG['common_err_tip_invalid_captcha']);
					}
			}

		if ($invitefrm->isValidFormInputs())
		    {
				if ($invitefrm->sendInvitationToFriends())
				    {
						$invitefrm->setPageBlockShow('form_success_msg');
				    }
			}
		else
			{
				$invitefrm->setPageBlockShow('block_msg_form_error');
				$invitefrm->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$invitefrm->setPageBlockShow('form_invite');
			}
	}

if ($invitefrm->isPageGETed($_GET, 'success'))
    {
        $invitefrm->setPageBlockShow('form_success_msg');
    }
//<<<<--------------------Code Ends----------------------//
//--------------------Page block templates begins-------------------->>>>>//

if ($invitefrm->isShowPageBlock('form_success_msg'))
    {
    	$CFG['feature']['auto_hide_success_block'] = false;
        $invitefrm->form_success['display_success_message'] = $invitefrm->displaySuccessMessage();
    }
if ($invitefrm->isShowPageBlock('form_invite'))
    {
    	if($CFG['feature']['importcontact'] == 'Getmycontacts')
			$invitefrm->form_invite['importer_url'] = $CFG['site']['url'].'tools/importer/index.php';
		else if($CFG['feature']['importcontact'] == 'Openinviter')
			$invitefrm->form_invite['importer_url'] = $CFG['site']['url'].'tools/OpenInviter/openinviterIndex.php';
	}
$invitefrm->includeHeader();
setTemplateFolder('members/');
$smartyObj->display('memberInvite.tpl');
if ($invitefrm->isShowPageBlock('form_invite') and $CFG['feature']['jquery_validation']) {
?>
<script type="text/javascript">
	$Jq("#form_contactus_show").validate({
		rules: {
		    to_emails: {
		    	required: true,
				isValidMultiEmail: true
		    }
		},
		messages: {
			to_emails: {
				required: "<?php echo $invitefrm->LANG['common_err_tip_required'];?>",
				isValidMultiEmail: "<?php echo $invitefrm->LANG['common_err_tip_email'];?>"
			}
		}
	});
	$Jq(document).ready(function(){
		$Jq('#change_lang').fancybox({
			'width'				: 865,
			'height'			: 336,
			'autoScale'     	: false,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'type'				: 'iframe'
		});
	});
</script>
<?php
}
$invitefrm->includeFooter();
?>