<?php /* Smarty version 2.6.18, created on 2011-10-18 14:06:04
         compiled from login.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'login.tpl', 38, false),)), $this); ?>
<?php if (! isset ( $this->_tpl_vars['opt'] )): ?>
	<?php if (! isAjaxPage ( )): ?>
		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endif; ?>
	<div id="selLogin">
		<div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['LANG']['login_title']; ?>
</h2></div>
	  	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_error')): ?>
	        <div id="selMsgError">
	            <form name="errorForm" id="errorForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getUrl('login'); ?>
">
	                <input type="hidden" name="user_name" value="<?php echo $this->_tpl_vars['myobj']->getFormField('user_name'); ?>
" />
	                <input type="hidden" name="code" id="code" value="true" />
	                <p><?php echo $this->_tpl_vars['myobj']->getCommonErrorMsg(); ?>
</p>
	            </form>
	        </div>
	    <?php endif; ?>
 <?php else: ?>
 	<div class="clsPopUpLogin">
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popuplogin_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
  	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_login')): ?>
  		<form name="selFormLogin" id="selFormLogin" method="post" action="<?php echo $this->_tpl_vars['myobj']->getUrl('login'); ?>
">
			<input type="hidden" name="url" id="url" value="<?php echo $this->_tpl_vars['myobj']->getFormField('url'); ?>
" />
			<div class="clsOverflow">
            <p class="clsMandatoryText"><?php echo $this->_tpl_vars['LANG']['common_mandatory_hint_1']; ?>
<span class="clsMandatoryFieldIconInText">*</span><?php echo $this->_tpl_vars['LANG']['common_mandatory_hint_2']; ?>
</p>
            <?php if (isset ( $this->_tpl_vars['opt'] )): ?>
            	<div class="clsClosePopUpLogin" onclick="showLoginPopup()"><!--close--></div>
             <?php endif; ?>
             </div>
             <div class="clsLoginFormTable">
            	<table class="clsTwoColumnTbl">
					<tr>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('user_name'); ?>
"><span class="clsMandatoryFieldIcon"><?php echo $this->_tpl_vars['LANG']['common_mandatory_field_icon']; ?>
</span><label for="user_name"><?php echo $this->_tpl_vars['myobj']->form_login['login_field_label']; ?>
</label></td>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('user_name'); ?>
">
							<?php if (! isset ( $this->_tpl_vars['opt'] )): ?>
								<input type="text" class="clsTextBox" name="user_name" id="user_name" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('user_name'); ?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['fieldsize']['username']['max']; ?>
" />
							<?php else: ?>
								<input type="text" class="clsTextBox" name="user_name" id="user_name" tabindex="800" value="<?php echo $this->_tpl_vars['myobj']->getFormField('user_name'); ?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['fieldsize']['username']['max']; ?>
" />
							<?php endif; ?>
							<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('user_name'); ?>

                    		<?php echo $this->_tpl_vars['myobj']->ShowHelpTip($this->_tpl_vars['myobj']->form_login['login_field'],'user_name'); ?>

                    	</td>
			    	</tr>
					<tr>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('password'); ?>
"><span class="clsMandatoryFieldIcon"><?php echo $this->_tpl_vars['LANG']['common_mandatory_field_icon']; ?>
</span><label for="password"><?php echo $this->_tpl_vars['LANG']['common_password']; ?>
</label></td>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('password'); ?>
">
							<?php if (! isset ( $this->_tpl_vars['opt'] )): ?>
								<input type="password" class="clsTextBox" name="password" id="password" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('password'); ?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['fieldsize']['password']['max']; ?>
" />
							<?php else: ?>
								<input type="password" class="clsTextBox" name="password" id="password" tabindex="805" value="<?php echo $this->_tpl_vars['myobj']->getFormField('password'); ?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['fieldsize']['password']['max']; ?>
" />
							<?php endif; ?>
							<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('password'); ?>

                    		<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('password'); ?>

                    	</td>
			    	</tr>
			    	<?php if ($this->_tpl_vars['CFG']['login']['captcha']): ?>
			    		<?php if ($this->_tpl_vars['CFG']['login']['login_captcha_method'] == 'recaptcha' && $this->_tpl_vars['CFG']['captcha']['public_key'] && $this->_tpl_vars['CFG']['captcha']['private_key']): ?>
					    	<tr>
								<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('captcha'); ?>
">
									<label for="recaptcha_response_field"><?php echo $this->_tpl_vars['LANG']['login_captcha']; ?>
</label>
								</td>
								<td class="clsOverwriteRecaptcha <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('captcha'); ?>
">
									<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('recaptcha_response_field'); ?>

									<?php echo $this->_tpl_vars['myobj']->recaptcha_get_html(); ?>

                                	<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('captcha','recaptcha_response_field'); ?>

								</td>
					    	</tr>
                     	<?php endif; ?>
                 	<?php endif; ?>
                 	<?php if (! isset ( $this->_tpl_vars['opt'] )): ?>
						<tr>
	                		<td></td>
							<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('remember'); ?>
"><p><span class="clsCheckBox"><input type="checkbox" class="clsCheckRadio" name="remember" id="remember1" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="1"<?php echo $this->_tpl_vars['myobj']->isCheckedCheckBox('remember'); ?>
 /></span><label for="remember1">&nbsp;&nbsp;<?php echo $this->_tpl_vars['LANG']['login_remember_login']; ?>
</label></p></td>
				    	</tr>
				    	<tr>
	                		<td></td>
							<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
"><div class="clsSubmitLeft"><div class="clsSubmitRight">
								<?php if (isAjaxPage ( )): ?>
									<input type="button" class="clsSubmitButton" name="login_submit" id="login_submit" onclick="return doAjaxLogin('selFormLogin')" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['login_submit']; ?>
" />
								<?php else: ?>
									<input type="submit" class="clsSubmitButton" name="login_submit" id="login_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['login_submit']; ?>
" />
								<?php endif; ?>
							</div></div></td>
			   	  		</tr>
				    	<tr>
	                		<td></td>
							<td>
	                       		<div class="clsOverflow">
				                	<ul class="clsLoginLinks">
					                	<?php if ($this->_tpl_vars['myobj']->chkAllowedModule ( array ( 'forgotpassword' ) )): ?>
					                    	<li class="clsForgotLink"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('forgotpassword'); ?>
"><?php echo $this->_tpl_vars['LANG']['login_forgotpassword']; ?>
</a></li>
					                	<?php endif; ?>
					                	<?php if ($this->_tpl_vars['myobj']->chkAllowedModule ( array ( 'signup' ) )): ?>
					                    	<li class="clsNewUser"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('signup'); ?>
"><?php echo $this->_tpl_vars['LANG']['login_register']; ?>
</a></li>
					                	<?php endif; ?>
					                	<?php if ($this->_tpl_vars['myobj']->chkAllowedModule ( array ( 'external_login' ) )): ?>
					                    	<li class="clsExternalLogin"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('externallogin'); ?>
"><?php echo $this->_tpl_vars['LANG']['login_externallogin']; ?>
</a></li>
					                	<?php endif; ?>
				            		</ul>
				            	</div>
	             			</td>
			   	  		</tr>
			   	  	<?php else: ?>
						<tr>
							<td colspan="2" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('remember'); ?>
"><p><span class="clsCheckBox"><input type="checkbox" class="clsCheckRadio" name="remember" id="remember1" tabindex="810" value="1"<?php echo $this->_tpl_vars['myobj']->isCheckedCheckBox('remember'); ?>
 /></span><label for="remember1">&nbsp;&nbsp;<?php echo $this->_tpl_vars['LANG']['login_remember_login']; ?>
</label></p></td>
				    	</tr>
				    	<tr>
							<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
">
                            <div class="clsLoginSubmitRight">
                                <div class="clsLoginSubmitLeft">
	                                <input type="submit" class="" name="login_submit" id="login_submit" tabindex="815" value="<?php echo $this->_tpl_vars['LANG']['login_submit']; ?>
" />
                                </div>
                            </div>
                            </td>
							<td>
	                       		<div class="clsOverflow">
				                	<ul class="clsLoginLinks">
					                	<?php if ($this->_tpl_vars['myobj']->chkAllowedModule ( array ( 'forgotpassword' ) )): ?>
					                    	<li class="clsForgotLink"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('forgotpassword'); ?>
"><?php echo $this->_tpl_vars['LANG']['login_forgotpassword']; ?>
</a></li>
					                	<?php endif; ?>
				            		</ul>
				            	</div>
	             			</td>
			   	  		</tr>
			   	  	<?php endif; ?>
				</table>
        	</div>
		</form>
	<?php endif; ?>
<?php if (! isset ( $this->_tpl_vars['opt'] )): ?>
	</div>
	<?php if (! isAjaxPage ( )): ?>
		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endif; ?>
<?php else: ?>
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popuplogin_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['CFG']['feature']['jquery_validation']): ?>
	<?php echo '
		<script language="javascript" type="text/javascript">
			$Jq("#selFormLogin").validate({
				rules: {
					user_name: {
						required: true
				    },
				    password: {
				    	required: true
				    }
				},
				messages: {
					user_name: {
						required: LANG_JS_REQUIRED
					},
					password: {
						required: LANG_JS_REQUIRED
					}
				}
			});
		</script>
	'; ?>

<?php endif; ?>