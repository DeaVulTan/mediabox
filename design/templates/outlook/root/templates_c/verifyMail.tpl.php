<?php /* Smarty version 2.6.18, created on 2012-01-21 02:13:01
         compiled from verifyMail.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'verifyMail.tpl', 12, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selVerifyMail">
	<div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['LANG']['verifymail_title']; ?>
</h2></div>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_verifymail') && $this->_tpl_vars['CFG']['admin']['ask_password_to_activation']): ?>
	<form name="form_verifymail" id="selFormVerifyMail" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
		<input type="hidden" name="code" id="code" value="<?php echo $this->_tpl_vars['myobj']->getFormField('code'); ?>
" />
		<div class="clsDataTable"><table summary="<?php echo $this->_tpl_vars['LANG']['verifymail_tbl_summary']; ?>
" class="clsTwoColumnTbl">
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('password'); ?>
"><label for="password"><?php echo $this->_tpl_vars['LANG']['common_password']; ?>
</label></td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('password'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('password'); ?>
<input type="password" class="clsTextBox" name="password" id="password" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('password'); ?>
" /><?php echo $this->_tpl_vars['myobj']->ShowHelpTip('password'); ?>
</td>
		    </tr>
		    <tr>
            	<td></td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
"><div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="verifymail" id="verifymail" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['verifymail_submit']; ?>
" /></div></div></td>
			</tr>
		</table></div>
	</form>
<?php endif; ?>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>