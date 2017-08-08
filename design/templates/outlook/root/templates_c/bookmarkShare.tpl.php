<?php /* Smarty version 2.6.18, created on 2011-10-18 17:56:33
         compiled from bookmarkShare.tpl */ ?>
<?php if (isset ( $this->_tpl_vars['CFG']['site']['bookmark']['addthis_enabled'] ) && $this->_tpl_vars['CFG']['site']['bookmark']['addthis_enabled']): ?>
<!-- ADDTHIS BUTTON BEGIN -->
<script type="text/javascript">
var addthis_pub             = "<?php echo $this->_tpl_vars['CFG']['site']['bookmark']['addthis_account']; ?>
";
var addthis_logo            = "<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/logo.jpg";
var addthis_logo_background = 'EFEFFF';
var addthis_logo_color      = '666699';
var addthis_brand           = "<?php echo $this->_tpl_vars['CFG']['site']['name']; ?>
";
var addthis_options         = "<?php echo $this->_tpl_vars['blogPost']['site_arr_str']; ?>
";
</script>
<a href="http://www.addthis.com/bookmark.php" onmouseover="return addthis_open(this, '', '<?php echo $this->_tpl_vars['blogPost']['url']; ?>
', '<?php echo $this->_tpl_vars['blogPost']['title']; ?>
')" onmouseout="addthis_close()" onclick="return addthis_sendto()">
<?php if ($this->_tpl_vars['blogPost']['title_link']): ?>
<img src="<?php echo $this->_tpl_vars['blogPost']['buttom_image']; ?>
" width="125" height="16" border="0" title="Share" /></a>
<?php else: ?>
	<img src="<?php echo $this->_tpl_vars['blogPost']['buttom_image']; ?>
" width="125" height="16" border="0" alt="" /></a>
<?php endif; ?>
<script type="text/javascript" src="http://s7.addthis.com/js/152/addthis_widget.js"></script>
<!-- ADDTHIS BUTTON END -->
<?php endif; ?>