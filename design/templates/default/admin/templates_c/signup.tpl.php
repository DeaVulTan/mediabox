<?php /* Smarty version 2.6.18, created on 2011-12-23 01:48:03
         compiled from signup.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'hpSolutionsRayzz', 'signup.tpl', 51, false),array('function', 'smartyTabIndex', 'signup.tpl', 66, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selSignUp">
	<div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['LANG']['signup_title']; ?>
</h2></div>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('memberadd_form_success')): ?>
		<div id="selMsgSuccess" class="clsLineHeight22">
			<p><?php echo $this->_tpl_vars['LANG']['signup_memberadd_success']; ?>
</p>
			<p class="clsMsgAdditionalText"><?php echo $this->_tpl_vars['LANG']['signup_link_view_new_member']; ?>
</p>
			<p class="clsMsgAdditionalText"><a href="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
"><?php echo $this->_tpl_vars['LANG']['signup_link_add_member']; ?>
</a></p>
		</div>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('activation_mail_details_block')): ?>
		<?php if ($this->_tpl_vars['resend_activation_message_step'] == 'step1'): ?>
			<div id="selMsgSuccess" class="clsSignConfirmationMail">
			  <div class="clsSignUpSuccess">
	           	<p><?php echo $this->_tpl_vars['LANG']['signup_resend_code_message_mail_sent']; ?>
</p>
				    <?php echo $this->_tpl_vars['myobj']->getFormField('email'); ?>

	        	<p><?php echo $this->_tpl_vars['LANG']['signup_resend_code_message_mail_verify']; ?>
</p>
	        	<p><?php echo $this->_tpl_vars['LANG']['signup_resend_code_message_mail_change']; ?>
</p>

	            <form name="errorForm" id="errorForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
">
	                <input type="text" name="new_email" id="new_email" value="<?php echo $this->_tpl_vars['myobj']->getFormField('new_email'); ?>
" />
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('new_email'); ?>

	                <input type="hidden" name="code" id="code" value="true" />
   	                <input type="hidden" name="email" value="<?php echo $this->_tpl_vars['myobj']->getFormField('email'); ?>
" />
                    <input type="hidden" name="user_id" value="<?php echo $this->_tpl_vars['myobj']->getFormField('user_id'); ?>
" />
                    <input type="hidden" name="user_name" value="<?php echo $this->_tpl_vars['myobj']->getFormField('new_username'); ?>
" />
	                <p><?php echo $this->_tpl_vars['resend_activation_link']; ?>
</p>
	            </form>
	            <p class="clsBold"><?php echo $this->_tpl_vars['LANG']['signup_resend_code_message_spam']; ?>
</p>
              </div>
	         </div>
	     <?php endif; ?>
		 <?php if ($this->_tpl_vars['resend_activation_message_step'] == 'step2'): ?>
		  	<div id="selMsgError" class="clsSignConfirmationMail">
				<?php echo $this->_tpl_vars['resend_activation_message']; ?>

				<p><?php echo $this->_tpl_vars['LANG']['signup_resend_code_message_mail_verify']; ?>
</p>
				<p><?php echo $this->_tpl_vars['LANG']['signup_resend_code_message_spam']; ?>
</p>
		  	</div>
         <?php endif; ?>

    <?php endif; ?>
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_signup')): ?>
		    <!-- clsFormSection - starts here -->
    <form name="form_signup" id="form_signup" class="" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
">

    <?php if (! isAdmin ( )): ?>
		<?php if ($this->_tpl_vars['CFG']['signup']['captcha'] && $this->_tpl_vars['CFG']['signup']['captcha_method'] == 'honeypot'): ?>
	    	<?php echo hpSolutionsRayzz(array(), $this);?>

	    <?php endif; ?>
    <?php endif; ?>

    <p class="ClsMandatoryText"><?php echo $this->_tpl_vars['LANG']['common_mandatory_hint_1']; ?>
<span class="clsMandatoryFieldIconInText">*</span><?php echo $this->_tpl_vars['LANG']['common_mandatory_hint_2']; ?>
</p>
        <div class="ClsForm">
            <table summary="<?php echo $this->_tpl_vars['LANG']['signup_tbl_summary']; ?>
">
                <tr>
                    <td class="ClsSignUpLabel <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('user_name'); ?>
">
                    	<?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('user_name'); ?>
<label for="user_name"><?php echo $this->_tpl_vars['myobj']->form_signup['signup_user_name']; ?>
</label>
                    </td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('user_name'); ?>
">
                    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_edit_member')): ?>
                    	<?php echo $this->_tpl_vars['myobj']->getFormField('user_name'); ?>

                    <?php else: ?>
                        <input type="text" class="ClsTextBox" name="user_name" id="user_name" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('user_name'); ?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['fieldsize']['username']['max']; ?>
"/>
                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('user_name'); ?>

                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('signup_username','user_name'); ?>

                    <?php endif; ?>
                    </td>
                </tr>
                <tr>
                	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('password'); ?>
">
						<?php if (! $this->_tpl_vars['myobj']->isShowPageBlock('form_edit_member')): ?>
						<?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('password'); ?>

						<?php endif; ?>
						<label for="password"><?php echo $this->_tpl_vars['myobj']->form_signup['signup_password']; ?>
</label>
					</td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('password'); ?>
">
                        <input type="password" class="ClsTextBox" name="password" id="password" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('password'); ?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['fieldsize']['password']['max']; ?>
"/>
                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('password'); ?>

                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('signup_password','password'); ?>

                    </td>
                </tr>
                <tr>
                	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('confirm_password'); ?>
">
                        <?php if (! $this->_tpl_vars['myobj']->isShowPageBlock('form_edit_member')): ?>
						<?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('confirm_password'); ?>

						<?php endif; ?>
                        <label for="confirm_password"><?php echo $this->_tpl_vars['LANG']['signup_confirm_password']; ?>
</label>
                    </td>
               		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('confirm_password'); ?>
">
                        <input type="password" class="ClsTextBox" name="confirm_password" id="confirm_password" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('confirm_password'); ?>
"  maxlength="<?php echo $this->_tpl_vars['CFG']['fieldsize']['password']['max']; ?>
"/>
                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('confirm_password'); ?>

                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('confirmpassword','confirm_password'); ?>

                	</td>
                </tr>
                <tr>
                	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('email'); ?>
">
                        <?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('email'); ?>

                    	<label for="email"><?php echo $this->_tpl_vars['LANG']['signup_email']; ?>
</label>
                    </td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('email'); ?>
">
                        <input type="text" class="ClsTextBox" name="email" id="email" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('email'); ?>
" />
                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('email'); ?>

                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('signup_email','email'); ?>

                    </td>
                </tr>
				<?php if (isAdmin ( )): ?>
				<tr>
					<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('usr_type'); ?>
">
						<?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>

						<label for="usr_access"><?php echo $this->_tpl_vars['LANG']['signup_personal_usr_type']; ?>
</label>
					</td>
					<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('usr_type'); ?>
">
						<select name="usr_type" id="usr_type" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
							<option value=""><?php echo $this->_tpl_vars['LANG']['signup_choose']; ?>
</option>
							<?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->user_types,$this->_tpl_vars['myobj']->getFormField('usr_type')); ?>

						</select>
						<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('usr_type'); ?>

                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('usr_type'); ?>

					</td>
				</tr>
				<?php endif; ?>
                <tr>
                	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('first_name'); ?>
">
                    	<?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('first_name'); ?>

                    	<label for="first_name"><?php echo $this->_tpl_vars['LANG']['signup_first_name']; ?>
</label>
                    </td>
                	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('first_name'); ?>
">
                		<input type="text" class="ClsTextBox" name="first_name" id="first_name" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('first_name'); ?>
"  maxlength="<?php echo $this->_tpl_vars['CFG']['fieldsize']['first_name']['max']; ?>
"/>
                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('first_name'); ?>

                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('first_name'); ?>

                	</td>
                </tr>
                <tr>
                	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('last_name'); ?>
">
                    	<?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('last_name'); ?>

                    	<label for="last_name"><?php echo $this->_tpl_vars['LANG']['signup_last_name']; ?>
</label>
                    </td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('last_name'); ?>
">
                        <input type="text" class="ClsTextBox" name="last_name" id="last_name" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('last_name'); ?>
"  maxlength="<?php echo $this->_tpl_vars['CFG']['fieldsize']['last_name']['max']; ?>
"/>
                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('last_name'); ?>

                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('last_name'); ?>

                    </td>
                </tr>
                <tr>
                	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('sex'); ?>
">
                        <?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('sex'); ?>

                    	<label for="sex"><?php echo $this->_tpl_vars['LANG']['signup_sex']; ?>
</label>
                    </td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('sex'); ?>
">
                        <?php $_from = $this->_tpl_vars['myobj']->form_signup['showSexOptionButtons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ssokey'] => $this->_tpl_vars['ssovalue']):
?>
                        	<input type="radio" class="ClsCheckRadio" id="sex_opt_<?php echo $this->_tpl_vars['ssovalue']['value']; ?>
" name="sex" <?php echo $this->_tpl_vars['ssovalue']['checked']; ?>
 value="<?php echo $this->_tpl_vars['ssovalue']['value']; ?>
"  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />&nbsp;<label for="sex_opt_<?php echo $this->_tpl_vars['ssovalue']['value']; ?>
"><?php echo $this->_tpl_vars['ssovalue']['description']; ?>
</label>&nbsp;&nbsp;
                        <?php endforeach; endif; unset($_from); ?>
                    </td>
                </tr>

                <tr>
                	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('dob'); ?>
">
                    	<?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('dob'); ?>

                    	<label for="dob"><?php echo $this->_tpl_vars['LANG']['signup_dob']; ?>
</label>
                    </td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('dob'); ?>
">
                        <input type="text" class="ClsTextBox" name="dob" id="dob" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('dob'); ?>
" />
                        <?php echo $this->_tpl_vars['myobj']->populateDateCalendar('dob',$this->_tpl_vars['dob_calendar_opts_arr']); ?>

                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('dob',true); ?>

                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('dob'); ?>

                    </td>
                </tr>
                <tr>
                	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('country'); ?>
">
                        <?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('country'); ?>

                    	<label for="country"><?php echo $this->_tpl_vars['LANG']['signup_country']; ?>
</label>
                    </td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('country'); ?>
">
                        <select name="country" id="country" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" class="validate-selection">
                        <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['smarty_country_list'],$this->_tpl_vars['myobj']->getFormField('country')); ?>

                        </select>
                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('country'); ?>

                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('country'); ?>

                    </td>
                </tr>
                <tr>
                	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('postal_code'); ?>
">
                        <?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('postal_code'); ?>

                    	<label for="postal_code"><?php echo $this->_tpl_vars['LANG']['signup_postal_code']; ?>
</label>
                    </td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('postal_code'); ?>
">
                        <input type="text" class="ClsTextBox" name="postal_code" id="postal_code" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('postal_code'); ?>
" maxlength="9"/>
                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('postal_code'); ?>

                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('postal_code'); ?>

                    </td>
                </tr>
            <?php if (! isAdmin ( ) && $this->_tpl_vars['CFG']['signup']['captcha']): ?>
                <?php if ($this->_tpl_vars['CFG']['signup']['captcha_method'] == 'recaptcha' && $this->_tpl_vars['CFG']['captcha']['public_key'] && $this->_tpl_vars['CFG']['captcha']['private_key']): ?>
                    <tr>
                        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('captcha'); ?>
">
                            <?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('country'); ?>

                        	<label for="recaptcha_response_field"><?php echo $this->_tpl_vars['LANG']['signup_captcha']; ?>
</label>
                        </td>
                        <td class="clsOverwriteRecaptcha <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('captcha'); ?>
">
                            <?php echo $this->_tpl_vars['myobj']->recaptcha_get_html(); ?>

                            <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('recaptcha_response_field'); ?>

                            <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('captcha','recaptcha_response_field'); ?>

                        </td>
                    </tr>
                <?php elseif (! isAdmin ( ) && $this->_tpl_vars['CFG']['signup']['captcha_method'] == 'image'): ?>
                    <tr>
                    	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('captcha'); ?>
">
                            <?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('captcha'); ?>

                        	<label for="captcha"><?php echo $this->_tpl_vars['LANG']['signup_captcha']; ?>
</label>
                        </td>
                    	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('captcha'); ?>
">
                    		<input type="text" class="ClsTextBox required" name="captcha" id="captcha" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('captcha'); ?>
" /><br/><img id="captchaImage" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
captchaSignup.php" alt="<?php echo $this->_tpl_vars['LANG']['signup_captcha_alt']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['signup_captcha_title']; ?>
" />
                            <a href="javascript:void(0)" onClick="return changeCaptchaImage()"><?php echo $this->_tpl_vars['LANG']['new_code']; ?>
</a>
                            <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('captcha'); ?>

                            <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('captcha'); ?>

                    	</td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>
            	<?php if (! isAdmin ( )): ?>
		            <?php if ($this->_tpl_vars['myobj']->getFormField('agreement') == 1): ?>
		                <?php $this->assign('check', 'checked="checked"'); ?>
		            <?php else: ?>
		                <?php $this->assign('check', ''); ?>
		            <?php endif; ?>
                <tr>
                	<td></td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('agreement'); ?>
">
                        <input type="checkbox" class="ClsCheckRadio" name="agreement" <?php echo $this->_tpl_vars['check']; ?>
 id="agreement" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="1" />
                        <label for="agreement"><?php echo $this->_tpl_vars['myobj']->form_signup['signup_agreement']; ?>
</label>
                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('agreement'); ?>

                    </td>
                </tr>
            	<?php endif; ?>
                <tr>
                <td></td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
">
                    <div class="ClsSubmitLeft">
                        <div class="ClsSubmitRight">
                            <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_edit_member')): ?>
								<input type="submit" class="ClsSubmitButton" name="signup_update" id="signup_update" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_update']; ?>
" />
								<input type="hidden" name="user_id" value="<?php echo $this->_tpl_vars['myobj']->getFormField('user_id'); ?>
" />
							<?php else: ?>
								<input type="submit" class="ClsSubmitButton" name="signup_submit" id="signup_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['signup_submit']; ?>
" />
							<?php endif; ?>
                        </div>
                    </div>
                    <input type="hidden" name="invitation_id" value="<?php echo $this->_tpl_vars['myobj']->getFormField('invitation_id'); ?>
" />
                </td>
                </tr>
            </table>
        </div>
    </form>
        <?php echo '

        '; ?>


<?php endif; ?>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>