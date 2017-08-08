<?php /* Smarty version 2.6.18, created on 2011-12-23 02:14:50
         compiled from mailCompose.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'mailCompose.tpl', 32, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/css/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/jquery.fancybox.css" media="screen" title="<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
" />
<div id="selComposeMail">
	<div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['LANG']['mailcompose_title']; ?>
</h2></div>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <div id="selLeftNavigation">

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_error')): ?>
	<div id="selMsgError">
		 <p><?php echo $this->_tpl_vars['LANG']['common_msg_error_sorry']; ?>
&nbsp;<?php echo $this->_tpl_vars['myobj']->getCommonErrorMsg(); ?>
</p>
	</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_success')): ?>
	<div id="selMsgSuccess">
		<p><?php echo $this->_tpl_vars['LANG']['mailcompose_success_mail']; ?>
</p>
	</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_compose')): ?>
	<?php if ($this->_tpl_vars['CFG']['admin']['static_page_editor']): ?>
	<form name="form_compose" id="selFormCompose" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" autocomplete="off" onsubmit="return <?php if ($this->_tpl_vars['CFG']['feature']['html_editor'] == 'richtext'): ?>getHTMLSource('rte1', 'frmDocumentEditor', 'page_content');<?php else: ?>true<?php endif; ?>">
    <?php else: ?>
		<form name="selFormCompose" id="selFormCompose" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" >
	<?php endif; ?>
    <div>
		<table border="0" summary="<?php echo $this->_tpl_vars['LANG']['mailcompose_tbl_summary']; ?>
" class="clsRichTextTable">
		   <tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('username'); ?>
"><?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('username'); ?>
<label for="username"><?php echo $this->_tpl_vars['LANG']['mailcompose_to']; ?>
</label></td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('username'); ?>
">
					<p><textarea name="username" id="username" cols="40" rows="2" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('username'); ?>
</textarea></p>
					<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('username'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('messages_to','username'); ?>

					<p><a href="<?php echo $this->_tpl_vars['select_username_url']; ?>
" id="selComposeSelectUserDiv"><?php echo $this->_tpl_vars['LANG']['mailcompose_select']; ?>
</a>&nbsp;
					<select name="contacts" id="contacts" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onchange="setUserName(this.form);">
						<option value=""><?php echo $this->_tpl_vars['LANG']['mailcompose_select_contacts']; ?>
</option>
						<optgroup label="<?php echo $this->_tpl_vars['LANG']['mailcompose_recent_contacts']; ?>
"></optgroup>
                        <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['populateContacts'],$this->_tpl_vars['myobj']->getFormField('username')); ?>

						<optgroup label="<?php echo $this->_tpl_vars['LANG']['mailcompose_my_friends']; ?>
"></optgroup>
                        <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['populateFriends'],$this->_tpl_vars['myobj']->getFormField('username')); ?>

						<optgroup label="<?php echo $this->_tpl_vars['LANG']['mailcompose_my_relations']; ?>
"></optgroup>
                        <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['populateRelations'],$this->_tpl_vars['myobj']->getFormField('username')); ?>

					</select>
					</p>
				</td>
		   </tr>
		   <tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('subject'); ?>
"><label for="subject"><?php echo $this->_tpl_vars['LANG']['mailcompose_subject']; ?>
</label></td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('message'); ?>
">
					<input type="text" class="clsTextBox" name="subject" id="subject" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" maxlength="250"  value="<?php echo $this->_tpl_vars['myobj']->getFormField('subject'); ?>
" />
					<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('subject'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('messages_subject','subject'); ?>

				</td>
		   </tr>
		   		   <tr>
				<td colspan="2" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('message'); ?>
">
					<?php if ($this->_tpl_vars['CFG']['feature']['html_editor'] == 'tinymce'): ?>
                    	<?php echo $this->_tpl_vars['myobj']->populateHtmlEditor('message'); ?>

                    <?php else: ?>
				   		<textarea name="message" id="message" cols="82" rows="7"  tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('message'); ?>
</textarea>
					<?php endif; ?>
                	<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('message'); ?>

			   	</td>
			   </tr>
		   </tr>

		   		<?php if ($this->_tpl_vars['myobj']->getFormField('original_message')): ?>

						<tr>
					   		<td colspan="2" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('original_message'); ?>
">
								<textarea name="original_message" id="original_message" cols="82" rows="4" disabled readonly ><?php echo $this->_tpl_vars['myobj']->getFormField('original_message'); ?>
</textarea>
							</td>
					   	</tr>
					   <tr>
					   		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('include_original_message'); ?>
"><label for="include_original_message_yes"><?php echo $this->_tpl_vars['LANG']['mailcompose_include_message']; ?>
></label></td>
					        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('include_original_message'); ?>
">
								<input type="radio" class="clsCheckRadio" name="include_original_message" id="include_original_message_yes"  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="Yes" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('include_original_message','Yes'); ?>
/>
					          	<label for="include_original_message_yes"><?php echo $this->_tpl_vars['LANG']['mailcompose_include_message_yes']; ?>
></label>&nbsp;&nbsp;
			                  	<input type="radio" class="clsCheckRadio" name="include_original_message" id="include_original_message_no" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="No" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('include_original_message','No'); ?>
 />
			                  	<label for="include_original_message_no"><?php echo $this->_tpl_vars['LANG']['mailcompose_include_message_no']; ?>
</label>
                                <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('messages_include_original_message','username'); ?>

							</td>
					   </tr>
				<?php endif; ?>

           <?php if ($this->_tpl_vars['CFG']['admin']['mails']['redirect']): ?>

					   <tr>
					   		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('goto'); ?>
"><label for="gotocompose"><?php echo $this->_tpl_vars['LANG']['mailcompose_go_to']; ?>
</label>
                            </td>
                            <td>
								<input type="radio" class="clsCheckRadio" name="goto" id="gotocompose" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="compose" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('goto','compose'); ?>
 /> <label for="gotocompose"><?php echo $this->_tpl_vars['LANG']['mailcompose_goto_compose']; ?>
</label>&nbsp;&nbsp;
								<input type="radio" class="clsCheckRadio" name="goto" id="gotoinbox" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="inbox" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('goto','inbox'); ?>
 /> <label for="gotoinbox"><?php echo $this->_tpl_vars['LANG']['mailcompose_goto_inbox']; ?>
</label>&nbsp;&nbsp;
								<input type="radio" class="clsCheckRadio" name="goto" id="gotosent" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="sent" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('goto','sent'); ?>
 /> <label for="gotosent"><?php echo $this->_tpl_vars['LANG']['mailcompose_goto_sent']; ?>
</label>&nbsp;&nbsp;
							</td>
					   </tr>
		  <?php endif; ?>
		   <tr>
		   		<td></td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('to_notify'); ?>
">
					<input type="checkbox" class="clsCheckRadio" name="to_notify" id="to_notify" value="Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('to_notify','Yes'); ?>
/>
					<label for="to_notify"><?php echo $this->_tpl_vars['LANG']['mailcompose_notify']; ?>
</label>
				</td>
		   </tr>
        <?php if ($this->_tpl_vars['CFG']['mail']['captcha']): ?>
            <?php if ($this->_tpl_vars['CFG']['mail']['mail_captcha_method'] == 'recaptcha' && $this->_tpl_vars['CFG']['captcha']['public_key'] && $this->_tpl_vars['CFG']['captcha']['private_key']): ?>
                <tr>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('captcha'); ?>
">
                        <label for="recaptcha_response_field"><?php echo $this->_tpl_vars['LANG']['mailcompose_captcha']; ?>
</label>
                    </td>
                    <td class="clsOverwriteRecaptcha <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('captcha'); ?>
">
                        <?php echo $this->_tpl_vars['myobj']->recaptcha_get_html(); ?>

                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('recaptcha_response_field'); ?>

                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('captcha','recaptcha_response_field'); ?>

                    </td>
                </tr>
             <?php endif; ?>
         <?php endif; ?>
		   <tr>
				<td></td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
">
					<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" name="mailcompose_submit" id="mailcompose_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['mailcompose_send']; ?>
" /></div></div>
				</td>
		   </tr>
		</table>
    </div>
		<input type="hidden" name="action" value="<?php echo $this->_tpl_vars['myobj']->getFormField('action'); ?>
" />
		<input type="hidden" name="msgFolder" value="<?php echo $this->_tpl_vars['myobj']->getFormField('msgFolder'); ?>
" />
		<input type="hidden" name="message_id" value="<?php echo $this->_tpl_vars['myobj']->getFormField('message_id'); ?>
" />
		<input type="hidden" name="bulletin_id" value="<?php echo $this->_tpl_vars['myobj']->getFormField('bulletin_id'); ?>
" />
		<input type="hidden" name="answer_id" value="<?php echo $this->_tpl_vars['myobj']->getFormField('answer_id'); ?>
" />
	</form>
<?php endif; ?>
	</div>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>