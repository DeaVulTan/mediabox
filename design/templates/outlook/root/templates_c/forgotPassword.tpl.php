<?php /* Smarty version 2.6.18, created on 2012-01-21 06:51:44
         compiled from forgotPassword.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'forgotPassword.tpl', 24, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selForgotPassword" class="clsForgotPassword">
	<div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['LANG']['forgot_title']; ?>
</h2></div>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('msg_form_error')): ?>
        <div id="selMsgError">
            <form name="errorForm" id="errorForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getUrl('forgotpassword'); ?>
" autocomplete="off">
                <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->form_error['hidden_arr']); ?>

                <input type="hidden" name="code" id="code" value="true" />
                <p><?php echo $this->_tpl_vars['LANG']['common_msg_error_sorry']; ?>
 <?php echo $this->_tpl_vars['myobj']->getCommonErrorMsg(); ?>
</p>
            </form>
        </div>
    <?php endif; ?>
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_Forgotpassword')): ?>
		<div class="clsPadding10"><?php echo $this->_tpl_vars['LANG']['forgot_password_note']; ?>
</div>
		<form name="form_Forgotpassword" id="form_Forgotpassword"  method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
		<!-- clsFormSection - starts here -->
	    	<div class="clsDataTable">
				<table>
			    	<tr>
				    	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('email'); ?>
"><?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('email'); ?>
<label for="email"><?php echo $this->_tpl_vars['LANG']['forgot_email']; ?>
</label></td>
	         	      	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('email'); ?>
">
						   	<input type="text" class="clsTextBox" name="email" id="email" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('email'); ?>
" />
	         	      		<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('email'); ?>

			     			<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('forgot_password_email','email'); ?>

						</td>
				 	</tr>
				 	<tr>
		            	<td colspan="2">
					   		<div class="clsSubmitLeft">
								<div class="clsSubmitRight">
									<input type="submit" class="clsSubmitButton" name="forgot_submit" id="forgot_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['forgot_submit']; ?>
" />
								</div>
						 	</div>
				     	</td>
	             	</tr>
	            </table>
			</div>
	    <!-- clsFormSection - ends here -->
		</form>
	<?php endif; ?>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>