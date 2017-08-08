<?php /* Smarty version 2.6.18, created on 2011-10-17 14:58:20
         compiled from ../admin/top_navigation_links.tpl */ ?>
<h2><?php echo $this->_tpl_vars['LANG']['header_admin_navigation_links']; ?>
</h2>
<div class="clsMenu"><ul>
  <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_index'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/index.php"><?php echo $this->_tpl_vars['LANG']['header_admin_index_links']; ?>
</a></li>
  <?php if (! $this->_tpl_vars['CFG']['admin']['module']['site_maintenance']): ?>
 	 <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_inactive'); ?>
"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('index','','','members'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_member_link']; ?>
</a></li>
  <?php endif; ?>
  <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_inactive'); ?>
">
  	<?php if ($this->_tpl_vars['myobj']->isFacebookUser()): ?>
  	<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('logout','','','root'); ?>
" onClick="return facebookLogout();"><?php echo $this->_tpl_vars['LANG']['header_logout_link']; ?>
</a>
	<?php else: ?>
	<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('logout','','','root'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_logout_link']; ?>
</a>
	<?php endif; ?></li>
</ul></div>