<?php /* Smarty version 2.6.18, created on 2011-12-26 18:12:47
         compiled from contactUs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'contactUs.tpl', 18, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selContactUs">
  <div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['LANG']['contactus_title']; ?>
</h2></div>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_contactus')): ?>
  <div class="clsDataTable">
  <form name="form_contactus_show" id="form_contactus_show" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
  <p class="clsMandatoryText"><?php echo $this->_tpl_vars['LANG']['common_mandatory_hint_1']; ?>
<span class="clsMandatoryFieldIconInText">*</span><?php echo $this->_tpl_vars['LANG']['common_mandatory_hint_2']; ?>
</p>
        <!-- clsFormSection - starts here -->
    <table>
      <tr>
        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('useremail'); ?>
">
          <?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>

          <label for="useremail"><?php echo $this->_tpl_vars['LANG']['contactus_user_email']; ?>
</label>
        </td>
        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('useremail'); ?>
">
         <input type="text" class="clsTextBox" name="useremail" id="useremail" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('useremail'); ?>
" />
         <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('useremail'); ?>

        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('contact_us_useremail','useremail'); ?>

        </td></tr>
      <tr>
        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('subject'); ?>
">
          <?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>

          <label for="subject"><?php echo $this->_tpl_vars['LANG']['contactus_subject']; ?>
 </label>
        </td>
        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('subject'); ?>
">
         <input type="text" class="clsTextBox" name="subject" id="subject" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('subject'); ?>
" />
         <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('subject'); ?>

        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('contact_us_subject','subject'); ?>

        </td></tr>
      <tr>
        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('message'); ?>
">
          <?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>

          <label for="message"><?php echo $this->_tpl_vars['LANG']['contactus_message']; ?>
</label>
        </td>
        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('message'); ?>
">
         <textarea name="message" id="message" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" rows="4" cols="45" class="selInputLimiter" maxlimit="<?php echo $this->_tpl_vars['CFG']['fieldsize']['contactus']['description']; ?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('message'); ?>
</textarea>
         <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('message'); ?>

        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('contact_us_message','message'); ?>

        </td>
      </tr>
    <?php if ($this->_tpl_vars['CFG']['mail']['captcha']): ?>
        <?php if ($this->_tpl_vars['CFG']['mail']['mail_captcha_method'] == 'recaptcha' && $this->_tpl_vars['CFG']['captcha']['public_key'] && $this->_tpl_vars['CFG']['captcha']['private_key']): ?>
            <tr>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('captcha'); ?>
">
                    <label for="recaptcha_response_field"><?php echo $this->_tpl_vars['LANG']['contactus_captcha']; ?>
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
        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('default'); ?>
">
          <div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="submit_contactus" id="submit_contactus" value="<?php echo $this->_tpl_vars['LANG']['contactus_submit']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></div></div>
        </td>
      </tr>
    </table>
    <!-- clsFormSection - ends here -->
  </form></div>
  <?php endif; ?> </div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>