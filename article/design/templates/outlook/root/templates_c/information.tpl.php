<?php /* Smarty version 2.6.18, created on 2012-02-01 23:56:28
         compiled from information.tpl */ ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_msg_form_error')): ?>
<div id="selMsgError">
	 <p><?php echo $this->_tpl_vars['myobj']->getCommonErrorMsg(); ?>
</p>
</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_msg_form_success')): ?>
<div id="selMsgSuccess">
	<p><?php echo $this->_tpl_vars['myobj']->getCommonSuccessMsg(); ?>
</p>
</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_msg_form_alert')): ?>
<div id="selMsgAlert">
	<p><?php echo $this->_tpl_vars['myobj']->getCommonAlertMsg(); ?>
</p>
</div>
<?php endif; ?>