<?php /* Smarty version 2.6.18, created on 2011-10-17 14:58:20
         compiled from left_photo_navigation_heading.tpl */ ?>
    <ul class="clsModuleHeading">
    	<li <?php if ($this->_tpl_vars['CFG']['site']['is_module_page'] == 'photo'): ?>class="clsActiveModuleLink" <?php else: ?> class="clsInActiveModuleLink"<?php endif; ?>>
    		<a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/photo/photoManage.php"><?php echo $this->_tpl_vars['LANG']['header_photo_management_links']; ?>
</a>
   		 </li>
   </ul>