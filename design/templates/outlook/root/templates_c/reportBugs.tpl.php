<?php /* Smarty version 2.6.18, created on 2011-12-26 18:13:08
         compiled from reportBugs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'reportBugs.tpl', 20, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selReportBugs"  class="clsCommonContent clsReportbugsMain">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'page_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['LANG']['reportbugs_title']; ?>
</h2></div>
   		<div class="clsCommonInsideContent">
  			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  			<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_reportbugs')): ?>
            <div class="clsDataTable">
  				<form name="form_reportbugs_show" id="form_reportbugs_show" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
                <p class="clsMandatoryText"><?php echo $this->_tpl_vars['LANG']['common_mandatory_hint_1']; ?>
<span class="clsMandatoryFieldIconInText">*</span><?php echo $this->_tpl_vars['LANG']['common_mandatory_hint_2']; ?>
</p>
        		<!-- clsFormSection - starts here -->
    			<div class="clsReportBugs">
	  	  			<table>
	      				<tr class="clsFormRow">
	        				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('username'); ?>
">
	          					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/box.tpl', 'smarty_include_vars' => array('opt' => 'compulsory_empty')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><label for="username"><?php echo $this->_tpl_vars['LANG']['reportbugs_username']; ?>
</label>
	        				</td>
	        				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('username'); ?>
">
	          					<input type="text" class="clsTextBox" name="username" id="username" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('username'); ?>
" />
	          					<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('username'); ?>

	        				</td>
	        			</tr>
		  				<tr class="clsFormRow">
	        				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('useremail'); ?>
">
	          					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/box.tpl', 'smarty_include_vars' => array('opt' => 'compulsory_empty')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><label for="useremail"><?php echo $this->_tpl_vars['LANG']['reportbugs_user_email']; ?>
</label>
	        				</td>
	        				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('useremail'); ?>
">
	          					<input type="text" class="clsTextBox" name="useremail" id="useremail" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('useremail'); ?>
" />
	          					<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('useremail'); ?>

	        				</td>
	        			</tr>
	      				<tr class="clsFormRow">
	        				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('subject'); ?>
">
	          					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/box.tpl', 'smarty_include_vars' => array('opt' => 'compulsory_empty')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><label for="subject"><?php echo $this->_tpl_vars['LANG']['reportbugs_subject']; ?>
</label>
	        				</td>
	        				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('subject'); ?>
">
	          					<select name="subject" id="subject" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
	          						<option value=""><?php echo $this->_tpl_vars['LANG']['reportbugs_select_option']; ?>
</option>
			  						<?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['LANG_LIST_ARR']['bug_category'],$this->_tpl_vars['myobj']->getFormField('subject')); ?>

			  					</select>
			  					<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('subject'); ?>

	        				</td>
	        			</tr>
	      				<tr class="clsFormRow">
	        				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('message'); ?>
">
	        					<?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>

	          					<label for="message"><?php echo $this->_tpl_vars['LANG']['reportbugs_message']; ?>
</label>
	        				</td>
	        				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('message'); ?>
">
	          					<textarea name="message" id="message" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" rows="4" cols="45" class="selInputLimiter" maxlimit="<?php echo $this->_tpl_vars['CFG']['fieldsize']['reportus']['description']; ?>
" ><?php echo $this->_tpl_vars['myobj']->getFormField('message'); ?>
</textarea>
	          					<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('message'); ?>

	        				</td>
	       				</tr>
	       				<?php if ($this->_tpl_vars['CFG']['reportbugs']['captcha']): ?>
	  						<?php if ($this->_tpl_vars['CFG']['reportbugs']['reportbugs_captcha_method'] == 'recaptcha' && $this->_tpl_vars['CFG']['captcha']['public_key'] && $this->_tpl_vars['CFG']['captcha']['private_key']): ?>
	    						<tr>
									<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('captcha'); ?>
">
										<label for="recaptcha_response_field"><?php echo $this->_tpl_vars['LANG']['reportbugs_captcha']; ?>
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
	        				<td class="clsButtonAlignment <?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('default'); ?>
"></td>
	        				<td>
								 <div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="submit_reportbugs" id="submit_reportbugs" value="<?php echo $this->_tpl_vars['LANG']['reportbugs_submit']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></div></div>
	          				</td>
	      				</tr>
	    			</table>
    			</div>
    			<!-- clsFormSection - ends here -->
  			</form>
            </div>
  		<?php endif; ?>
	</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'page_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>

<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>