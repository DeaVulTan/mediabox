<?php /* Smarty version 2.6.18, created on 2011-10-19 22:18:21
         compiled from logout.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<script type="text/javascript" >
function closeCurrentWindow()
	{
		window.close();
	}
</script>
'; ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_success')): ?>
    <div id="selMsgSuccess">
        <p><?php echo $this->_tpl_vars['myobj']->getCommonSuccessMsg(); ?>
&nbsp;<a href="javascript:closeCurrentWindow()"><?php echo $this->_tpl_vars['LANG']['common_msg_click_here']; ?>
</a></p>
    </div>
<?php endif; ?>