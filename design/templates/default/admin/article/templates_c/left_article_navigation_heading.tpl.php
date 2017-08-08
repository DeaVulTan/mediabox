<?php /* Smarty version 2.6.18, created on 2011-10-17 14:58:20
         compiled from left_article_navigation_heading.tpl */ ?>
    <ul class="clsModuleHeading">
    	<li <?php if ($this->_tpl_vars['CFG']['site']['is_module_page'] == 'article'): ?>class="clsActiveModuleLink" <?php else: ?> class="clsInActiveModuleLink"<?php endif; ?>>
    		<a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/article/articleManage.php"><?php echo $this->_tpl_vars['LANG']['header_article_management_links']; ?>
</a>
   		 </li>
   </ul>