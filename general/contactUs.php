<?php
//-------------- Class ContactUsHandler begins --------------->>>>>//
/**
 * ContactUsHandler
 * Class to handle the contact us page
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class ContactUsHandler extends FormHandler
    {
		public $publickey;
		public $privatekey;
		public $error = null;
		public $resp = null;

		/**
		 * To send mail to admin
		 *
		 * @param		string $to_mail receiver email address
		 * @return 		boolean
		 * @access		public
		**/
		public function sendEmailToAdmin($to_mail)
			{
				$this->buildEmailTemplate($this->fields_arr['subject'], $this->fields_arr['message'], false, true);
				$EasySwift = new EasySwift($this->getSwiftConnection());
				$EasySwift->flush();
				$EasySwift->addPart($this->getEmailContent(true), "text/html");
				return $EasySwift->send($to_mail, $this->fields_arr['useremail'], $this->getEmailSubject());
			}
    }
//<<<<<---------------- Class ContactUsHandler ends -------------//
//--------------------- Code begins -------------------->>>>>//
$contactus = new ContactUsHandler();
$contactus->setPageBlockNames(array('block_contactus'));
//set the form field
$contactus->setFormField('useremail', '');
$contactus->setFormField('subject', '');
$contactus->setFormField('message', '');
$contactus->setFormField('recaptcha_challenge_field', '');
$contactus->setFormField('recaptcha_response_field', '');
$contactus->setAllPageBlocksHide();
$contactus->setPageBlockShow('block_contactus');
$contactus->sanitizeFormInputs($_REQUEST);
$CFG['feature']['auto_hide_success_block'] = false;
if ($contactus->isFormPOSTed($_POST, 'submit_contactus'))
	{
		$contactus->chkIsNotEmpty('useremail', $contactus->LANG['common_err_tip_compulsory']) and
			 $contactus->chkIsValidEmail('useremail', $contactus->LANG['common_err_tip_invalid_email_format']);
		$contactus->chkIsNotEmpty('subject', $contactus->LANG['common_err_tip_compulsory']);
		$contactus->chkIsNotEmpty('message', $contactus->LANG['common_err_tip_compulsory']);

		if($CFG['mail']['captcha'])
			{
				if($CFG['mail']['mail_captcha_method'] == 'recaptcha'and $CFG['captcha']['public_key'] and $CFG['captcha']['private_key'])
					{
						$contactus->chkIsNotEmpty('recaptcha_response_field', $LANG['common_err_tip_compulsory']) and
							$contactus->chkCaptcha('recaptcha_response_field', $LANG['common_err_tip_invalid_captcha']);
					}
			}

		if ($contactus->isValidFormInputs())
			{
				if ($contactus->sendEmailToAdmin($contactus->CFG['site']['support_email']))
					{
						$contactus->setAllPageBlocksHide();
						$contactus->setCommonSuccessMsg($contactus->LANG['contactus_success']);
						$contactus->setPageBlockShow('block_msg_form_success');
					}
				else
					{
						$contactus->setAllPageBlocksHide();
						$contactus->setCommonSuccessMsg($contactus->LANG['contactus_failure']);
						$contactus->setPageBlockShow('block_msg_form_success');
					}
			}
		else
			{
				$contactus->setAllPageBlocksHide();
				$contactus->setCommonErrorMsg($contactus->LANG['common_msg_error_sorry']);
				$contactus->setPageBlockShow('block_msg_form_error');
				$contactus->setPageBlockShow('block_contactus');
			}
	}
//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//
//include the header file
$contactus->includeHeader();
//include the content of the page
setTemplateFolder('general/');
$smartyObj->display('contactUs.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
if ($CFG['feature']['jquery_validation']) {
?>
<script type="text/javascript">
	$Jq("#form_contactus_show").validate({
		rules: {
		    useremail: {
		    	required: true,
				isValidEmail: true
		    },
		    subject: {
		    	required: true
		    },
		    message: {
		    	required: true
		    }
		},
		messages: {
			useremail: {
				required: "<?php echo $contactus->LANG['common_err_tip_required'];?>",
				isValidEmail: "<?php echo $contactus->LANG['common_err_tip_email'];?>"
			},
			subject: {
				required: "<?php echo $contactus->LANG['common_err_tip_required'];?>"
			},
		    message: {
		    	required: "<?php echo $contactus->LANG['common_err_tip_required'];?>"
		    }
		}
	});
</script>
<?php
}
$contactus->includeFooter();
?>