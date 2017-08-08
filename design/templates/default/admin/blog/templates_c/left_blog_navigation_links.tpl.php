<?php /* Smarty version 2.6.18, created on 2011-10-17 14:58:20
         compiled from left_blog_navigation_links.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'left_blog_navigation_links.tpl', 33, false),)), $this); ?>
<?php if ($this->_tpl_vars['CFG']['site']['is_module_page'] == 'blog'): ?>
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "left_navigation_deactive_common_links.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php $_from = $this->_tpl_vars['CFG']['site']['modules_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module']):
?>
        <?php if (chkAllowedModule ( array ( $this->_tpl_vars['module'] ) )): ?><!-- IF blog module enable -->
            <?php if ($this->_tpl_vars['module'] == 'blog'): ?>
            	<div class="clsModuleSeperator">
                    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/','blog'); ?>

                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "left_blog_navigation_heading.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    <h3 class="clsInActiveSideHeading" id="blogMain_head" ><span  onclick="adminMenuLeftNavigationPage('blogMain')"><?php echo $this->_tpl_vars['LANG']['admin_header_blog_general']; ?>
</span></h3>
                    <div id="blogMain" style="display:none">
                            <ul>
                                <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_postmanage'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/blog/postManage.php"><?php echo $this->_tpl_vars['LANG']['admin_header_post_list']; ?>
</a></li>
                                <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_manageblog'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/blog/manageBlog.php"><?php echo $this->_tpl_vars['LANG']['admin_header_blog_list']; ?>
</a></li>
                                <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_postactivate'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/blog/postActivate.php"><?php echo $this->_tpl_vars['LANG']['admin_header_post_activate_links']; ?>
</a></li>						
                                <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_manageflaggedpost'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/blog/manageFlaggedPost.php"><?php echo $this->_tpl_vars['LANG']['admin_header_post_flaggedpost_links']; ?>
</a></li>
                                <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_manageblogcategory'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/blog/manageBlogCategory.php"><?php echo $this->_tpl_vars['LANG']['admin_header_blog_category_links']; ?>
</a></li>
                            </ul>
                        </div>
    
                    <!-- added for blog settings menu -->
                    <h3 class="clsInActiveSideHeading" id="blogSetting_head" ><span  onclick="adminMenuLeftNavigationPage('blogSetting')"><?php echo $this->_tpl_vars['LANG']['admin_header_blog_setting']; ?>
</span></h3>
                    <div id="blogSetting" style="display:none">
                        <ul>
                            <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_editconfigblog'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/editConfigData.php?module=blog&div=blogSetting"><?php echo $this->_tpl_vars['LANG']['admin_header_blog_general_setting']; ?>
</a></li>
                        
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