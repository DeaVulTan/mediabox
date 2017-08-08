<?php
//-------------- Class ContactUsHandler begins --------------->>>>>//
/**
 * Class to handle the contact us page
 */
class BugHandler extends FormHandler
    {

    	public $error = null;

		/**
		 * To send mail to admin
		 *
		 * @param		string $to_mail receiver email address
		 * @return 		boolean
		 * @access		public
		**/
		public function sendEmailToAdmin($category)
			{
				$this->setEmailTemplateValue('REPORTER_NAME', $this->getFormField('username')?$this->getFormField('username'):$this->LANG['reportbugs_no_name']);
				$this->setEmailTemplateValue('REPORTER_EMAIL', $this->getFormField('useremail')?$this->getFormField('useremail'):$this->LANG['reportbugs_no_email']);
				$this->setEmailTemplateValue('SITE_IP', $this->CFG['remote_client']['ip']);
				$this->setEmailTemplateValue('CATEGORY',$category );
				$this->setEmailTemplateValue('CONTENT', $this->getFormField('message'));
				$this->buildEmailTemplate($this->LANG['report_bugs_email_subject'], $this->LANG['report_bugs_email_content'], false, true);
				$EasySwift = new EasySwift($this->getSwiftConnection());
				$EasySwift->flush();
				$EasySwift->addPart($this->getEmailContent(true), "text/html");
				$from_email = $this->getFormField('useremail')?$this->getFormField('useremail'):$this->CFG['site']['noreply_email'];
				$EasySwift->send($this->CFG['site']['support_email'], $from_email, $this->getEmailSubject());
				sendBugEmail($this);
				return true;
			}

		public function resetFieldsArr()
			{
				$this->setFormField('username', '');
				$this->setFormField('useremail', '');
				$this->setFormField('subject', '');
				$this->setFormField('message', '');
			}
    }
//<<<<<---------------- Class BugHandler ends -------------//
//--------------------- Code begins -------------------->>>>>//
$BugHandler = new BugHandler();
$BugHandler->setPageBlockNames(array('block_reportbugs'));
//set the form field
$BugHandler->resetFieldsArr();
$BugHandler->setAllPageBlocksHide();
$BugHandler->setPageBlockShow('block_reportbugs');
$BugHandler->setFormField('recaptcha_challenge_field', '');
$BugHandler->setFormField('recaptcha_response_field', '');
$BugHandler->sanitizeFormInputs($_REQUEST);

if ($BugHandler->isFormPOSTed($_POST, 'submit_reportbugs'))
	{
		$BugHandler->getFormField('useremail') and
			$BugHandler->chkIsValidEmail('useremail', $BugHandler->LANG['common_err_tip_invalid_email_format']);
		$BugHandler->chkIsNotEmpty('message', $BugHandler->LANG['common_err_tip_compulsory']);

		if($CFG['reportbugs']['captcha'])
			{
				if($CFG['reportbugs']['reportbugs_captcha_method'] == 'recaptcha' and $CFG['captcha']['public_key'] and $CFG['captcha']['private_key'])
					{
						$BugHandler->chkIsNotEmpty('recaptcha_response_field', $LANG['common_err_tip_compulsory']) and
						$BugHandler->chkCaptcha('recaptcha_response_field', $LANG['common_err_tip_invalid_captcha']);
					}
			}
		if ($BugHandler->isValidFormInputs())
			{
				if ($BugHandler->sendEmailToAdmin($LANG_LIST_ARR['bug_category'][$BugHandler->getFormField('subject')]))
					{
						$BugHandler->setAllPageBlocksHide();
						$BugHandler->setCommonSuccessMsg($BugHandler->LANG['reportbugs_success']);
						$BugHandler->setPageBlockShow('block_msg_form_success');
						$BugHandler->resetFieldsArr();
						$BugHandler->setPageBlockShow('block_reportbugs');
					}
				else
					{
						$BugHandler->setAllPageBlocksHide();
						$BugHandler->setCommonSuccessMsg($BugHandler->LANG['reportbugs_failure']);
						$BugHandler->setPageBlockShow('block_msg_form_success');
						$BugHandler->setPageBlockShow('block_reportbugs');
					}
			}
		else
			{
				$BugHandler->setAllPageBlocksHide();
				$BugHandler->setCommonErrorMsg($BugHandler->LANG['common_msg_error_sorry']);
				$BugHandler->setPageBlockShow('block_msg_form_error');
				$BugHandler->setPageBlockShow('block_reportbugs');
			}
	}
//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//
setPageTitle($LANG['reportbugs_title']);
$smartyObj->assign('LANG_LIST_ARR', $LANG_LIST_ARR);
//include the header file
$BugHandler->includeHeader();
//include the content of the page
setTemplateFolder('general/');
$smartyObj->display('reportBugs.tpl');
if ($BugHandler->isShowPageBlock('block_reportbugs') and $CFG['feature']['jquery_validation']) {
?>
<script type="text/javascript">
	$Jq("#form_reportbugs_show").validate({
		rules: {
			useremail: {
				isValidEmail: true
		    },
		    message: {
		    	required: true
		    }
		},
		messages: {
			useremail: {
				isValidEmail: "<?php echo $BugHandler->LANG['common_err_tip_invalid_email_format'];?>"
			},
			message: {
				required: "<?php echo $BugHandler->LANG['common_err_tip_compulsory'];?>"
			}
		}
	});
</script>
<?php
}
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$BugHandler->includeFooter();
?>