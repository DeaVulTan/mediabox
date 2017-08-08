<?php /* Smarty version 2.6.18, created on 2011-10-17 14:58:20
         compiled from left_discussions_navigation_links.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'left_discussions_navigation_links.tpl', 48, false),)), $this); ?>
<?php if ($this->_tpl_vars['CFG']['site']['is_module_page'] == 'discussions'): ?>
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "left_navigation_deactive_common_links.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php $_from = $this->_tpl_vars['CFG']['site']['modules_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module']):
?>
		<?php if (chkAllowedModule ( array ( $this->_tpl_vars['module'] ) )): ?><!-- IF video module enable -->
        	<?php if ($this->_tpl_vars['module'] == 'discussions'): ?>
            	<div class="clsModuleSeperator">
                    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/','discussions'); ?>

                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "left_discussions_navigation_heading.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    <h3 class="clsInActiveSideHeading" id="discussionsMain_head" ><span  onclick="adminMenuLeftNavigationPage('discussionsMain')"><?php echo $this->_tpl_vars['LANG']['header_discussions_general']; ?>
</span></h3>
                    <div id="discussionsMain" style="display:none">
                        <ul>
                            <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_discussions'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/discussions/discussions.php"><?php echo $this->_tpl_vars['LANG']['header_admin_manage_discussions']; ?>
</a></li>
                            <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_addDiscussionTitle'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/discussions/addDiscussionTitle.php"><?php echo $this->_tpl_vars['LANG']['header_admin_add_discussions']; ?>
</a></li>
                            <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_discussions_search'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/discussions/discussions.php?mode=search"><?php echo $this->_tpl_vars['LANG']['header_admin_search_discussions']; ?>
</a></li>
                           <?php if ($this->_tpl_vars['myobj']->_currentPage == 'managesolutions' || $this->_tpl_vars['myobj']->_currentPage == 'viewsolutions'): ?>
                              <li class="<?php if ($this->_tpl_vars['myobj']->_currentPage == 'managesolutions'): ?><?php echo $this->_tpl_vars['header']->getNavClass('left_managesolutions'); ?>
<?php else: ?><?php echo $this->_tpl_vars['header']->getNavClass('left_viewsolutions'); ?>
<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/discussions/manageSolutions.php?did=<?php echo $this->_tpl_vars['myobj']->getFormField('did'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_admin_manage_solution']; ?>
</a></li>
                              <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_managesolutions_search'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/discussions/manageSolutions.php?did=<?php echo $this->_tpl_vars['myobj']->getFormField('did'); ?>
&mode=search"><?php echo $this->_tpl_vars['LANG']['header_admin_search_solution']; ?>
</a></li>
                              <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_managesolutions_add'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/discussions/manageSolutions.php?did=<?php echo $this->_tpl_vars['myobj']->getFormField('did'); ?>
&mode=add"><?php echo $this->_tpl_vars['LANG']['header_admin_add_solution']; ?>
</a></li>
                               <?php endif; ?>
                            <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_discussioncategory'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/discussions/discussionCategory.php"><?php echo $this->_tpl_vars['LANG']['header_admin_board_category']; ?>
</a></li>
                            <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_discussioncategory_add'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/discussions/discussionCategory.php?mode=add"><?php echo $this->_tpl_vars['LANG']['header_admin_subtitle_add_category']; ?>
</a></li>
                             <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_commonwords'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/discussions/commonwords.php"><?php echo $this->_tpl_vars['LANG']['discuzz_commonwords_title']; ?>
</a></li>
                        </ul>
                    </div>
                 <h3 class="clsInActiveSideHeading" id="discussionsSetting_head"><span onclick="adminMenuLeftNavigationPage('discussionsSetting')"><?php echo $this->_tpl_vars['LANG']['header_discussions_setting']; ?>
</span></h3>
                    <div id="discussionsSetting" style="display:none">
                       
                       <ul>
                       <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_editconfigdata_discussions'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/editConfigData.php?module=discussions&div=discussionsSetting">Discussion Settings</a> </li>
                       </ul>
                                           </div>
				</div>
			<?php else: ?><!-- Deactive all other module -->
            		<div class="clsModuleSeperator">
                        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/',$this->_tpl_vars['module']); ?>

                        <?php $this->assign('module_heading_tpl', ((is_array($_tmp=((is_array($_tmp='left_')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['module']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['module'])))) ? $this->_run_mod_handler('cat', true, $_tmp, '_navigation_heading.tpl') : smarty_modifier_cat($_tmp, '_navigation_heading.tpl'))); ?>
                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['module_heading_tpl'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					</div>
            <?php endif; ?>
		<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>
<?php endif; ?> 