<?php /* Smarty version 2.6.18, created on 2011-10-18 14:49:54
         compiled from populateMailRightNavigation.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clsSideBarLinks" id="selMails">
	<div class="clsSideBar"><div>
	<p class="clsSideBarLeftTitle"><?php echo $this->_tpl_vars['LANG']['header_nav_mail_mail']; ?>
</p>
</div>

<div class="clsSideBarRight">
<div class="clsSideBarContent">
 <ul>
  <li class="<?php echo $this->_tpl_vars['mail_pg_inbox_class']; ?>
"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('mail','?folder=inbox','inbox/'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_nav_mail_inbox']; ?>
 (<?php echo $this->_tpl_vars['myobj']->countUnReadMail(); ?>
)</a></li>
  <li class="<?php echo $this->_tpl_vars['mail_pg_sent_class']; ?>
"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('mail','?folder=sent','sent/'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_nav_mail_sent']; ?>
</a></li>
  <li class="<?php echo $this->_tpl_vars['mail_pg_saved_class']; ?>
"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('mail','?folder=saved','saved/'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_nav_mail_saved']; ?>
</a></li>
  <li class="<?php echo $this->_tpl_vars['mail_pg_request_class']; ?>
"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('mail','?folder=request','request/'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_nav_mail_requests']; ?>
 (<?php echo $this->_tpl_vars['myobj']->countUnReadMailByType('Request'); ?>
)</a></li>
  <li class="<?php echo $this->_tpl_vars['mail_pg_trash_class']; ?>
"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('mail','?folder=trash','trash/'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_nav_mail_trash']; ?>
</a></li>
   <?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'compose_mail') == 'Yes'): ?>
	<li class="<?php echo $this->_tpl_vars['mailCompose_class']; ?>
"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('mailcompose'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_nav_mail_compose']; ?>
</a></li>
   <?php endif; ?>
 </ul>
</div>
</div></div></div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>