<?php /* Smarty version 2.6.18, created on 2012-01-21 07:56:49
         compiled from profilePassword.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'profilePassword.tpl', 18, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selEditPasswordProfile">
	<div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['LANG']['profile_password_title']; ?>
</h2></div>
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div id="selLeftNavigation">
		<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_change_password')): ?>
			<form name="selFormEditProfile" id="selFormEditProfile" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
            <p class="ClsMandatoryText"><?php echo $this->_tpl_vars['LANG']['common_mandatory_hint_1']; ?>
<span class="clsMandatoryFieldIconInText">*</span><?php echo $this->_tpl_vars['LANG']['common_mandatory_hint_2']; ?>
</p>
				<div class="clsDataTable">
				<table summary="<?php echo $this->_tpl_vars['LANG']['profile_password_tbl_summary']; ?>
" class="clsProfileEditTbl">
				    <tr>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('current_password'); ?>
"><?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('current_password'); ?>
<label for="current_password"><?php echo $this->_tpl_vars['LANG']['profile_password_current_password']; ?>
</label></td>
						<td class="<?php echo '<?php'; ?>
 echo $password->getCSSFormFieldCellClass('current_password');<?php echo '?>'; ?>
">
							<input type="password" class="clsTextBox" name="current_password" id="current_password" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('current_password'); ?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['fieldsize']['password']['max']; ?>
"/>
							<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('current_password'); ?>

		                	<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('current_password'); ?>

		                </td>
				    </tr>
				    <tr>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('password_new'); ?>
"><?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('password_new'); ?>
<label for="password_new"><?php echo $this->_tpl_vars['myobj']->form_change_password['password_label']; ?>
</label></td>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('password_new'); ?>
">
							<input type="password" class="clsTextBox" name="password_new" id="password_new" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('password_new'); ?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['fieldsize']['password']['max']; ?>
"/>
							<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('password_new'); ?>

		                	<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('password_new'); ?>

		                </td>
				    </tr>
				    <tr>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('confirm_password'); ?>
"><?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('confirm_password'); ?>
<label for="confirm_password"><?php echo $this->_tpl_vars['LANG']['profile_password_confirm_password']; ?>
</label></td>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('confirm_password'); ?>
">
							<input type="password" class="clsTextBox" name="confirm_password" id="confirm_password" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('confirm_password'); ?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['fieldsize']['password']['max']; ?>
"/>
							<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('confirm_password'); ?>

		                	<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('confirm_password'); ?>

		                </td>
				    </tr>
				    <tr>
						<td>&nbsp;</td>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
"><div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="password_submit" id="password_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['profile_password_submit']; ?>
" /></div></div></td>
				   </tr>
				</table>
		        </div>
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