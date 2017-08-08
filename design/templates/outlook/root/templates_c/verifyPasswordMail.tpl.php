<?php /* Smarty version 2.6.18, created on 2012-02-11 14:49:27
         compiled from verifyPasswordMail.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'verifyPasswordMail.tpl', 16, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selForgotPassword">
	<div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['LANG']['verifymail_title']; ?>
</h2></div>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_username')): ?>
		<div id="selUsername">
			<form name="form_verifymail" id="selFormVerifyMail" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" autocomplete="off">
                <p class="ClsMandatoryText"><?php echo $this->_tpl_vars['LANG']['common_mandatory_hint_1']; ?>
<span class="clsMandatoryFieldIconInText">*</span><?php echo $this->_tpl_vars['LANG']['common_mandatory_hint_2']; ?>
</p>
				<input type="hidden" name="code" id="code" value="<?php echo $this->_tpl_vars['myobj']->getFormField('code'); ?>
" />
				<div class="clsDataTable"><table summary="$LANG.verifymail_tbl_summary" class="clsTwoColumnTbl">
					<tr>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('username'); ?>
"><?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('username'); ?>
<label for="username"><?php echo $this->_tpl_vars['LANG']['common_username']; ?>
</label></td>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('username'); ?>
">
							<input type="text" class="clsTextBox" name="username" id="username" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('username'); ?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['fieldsize']['username']['max']; ?>
"/>
							<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('username'); ?>

							<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('username'); ?>

						</td>
					</tr>
					<tr>
                    	<td></td>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
"><div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="verifyUsername" id="verifyUsername" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['verifyUsername_submit']; ?>
"/></div></div></td>
					</tr>
				</table></div>
			</form>
		</div>
	 <?php endif; ?>

	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_verifymail')): ?>
	<form name="form_verifymail" id="selFormVerifyMail" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" autocomplete="off">
	<p class="ClsMandatoryText"><?php echo $this->_tpl_vars['LANG']['common_mandatory_hint_1']; ?>
<span class="clsMandatoryFieldIconInText">*</span><?php echo $this->_tpl_vars['LANG']['common_mandatory_hint_2']; ?>
</p>
		<table summary="<?php echo $this->_tpl_vars['LANG']['verifymail_tbl_summary']; ?>
" class="clsTwoColumnTbl">
			 <tr>
					<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('password'); ?>
"><?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('password'); ?>
<label for="password"><?php echo $this->_tpl_vars['LANG']['common_password']; ?>
</label></td>
					<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('password'); ?>
">
						<input type="password" class="clsTextBox" name="password" id="password" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('password'); ?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['fieldsize']['password']['max']; ?>
"/>
						<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('password'); ?>

						<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('password'); ?>

					</td>
			    </tr>
			    <tr>
					<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('confirm_password'); ?>
"><?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('confirm_password'); ?>
<label for="confirm_password"><?php echo $this->_tpl_vars['LANG']['verifymail_confirm_password']; ?>
</label></td>
					<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('confirm_password'); ?>
">
						<input type="password" class="clsTextBox" name="confirm_password" id="confirm_password" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('confirm_password'); ?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['fieldsize']['password']['max']; ?>
"/>
						<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('confirm_password'); ?>

						<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('confirmpassword','confirm_password'); ?>

					</td>
			    </tr>
		    <tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
" colspan="2">
					<input type="hidden" name="user_id" id="user_id" value="<?php echo $this->_tpl_vars['myobj']->getFormField('user_id'); ?>
" />
					<input type="hidden" name="username" value="<?php echo $this->_tpl_vars['myobj']->getFormField('username'); ?>
" />
					<input type="hidden" name="code" id="code" value="<?php echo $this->_tpl_vars['myobj']->getFormField('code'); ?>
" />
					<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="verifymail" id="verifymail" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['verifymail_submit']; ?>
" /></div></div>
				</td>
			</tr>
		</table>
	</form>
	 <?php endif; ?>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>