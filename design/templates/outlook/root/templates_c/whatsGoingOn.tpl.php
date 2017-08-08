<?php /* Smarty version 2.6.18, created on 2011-10-17 14:52:37
         compiled from whatsGoingOn.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/',''); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_whatsgoing_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clsIndexWhatsGoingOnSection">
    <span class="clsWhatgoingHeading"><?php echo $this->_tpl_vars['LANG']['myhome_whats_going_on']; ?>
</span>
    <?php if ($this->_tpl_vars['CFG']['admin']['show_recent_activities']): ?>
        <?php echo $this->_tpl_vars['myobj']->myHomeActivity(4); ?>

    <?php endif; ?>
</div>          
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/',''); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_whatsgoing_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>