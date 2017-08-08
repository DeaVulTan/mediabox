<?php /* Smarty version 2.6.18, created on 2011-10-17 14:58:20
         compiled from left_article_navigation_links.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'left_article_navigation_links.tpl', 42, false),)), $this); ?>
<?php if ($this->_tpl_vars['CFG']['site']['is_module_page'] == 'article'): ?>
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "left_navigation_deactive_common_links.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php $_from = $this->_tpl_vars['CFG']['site']['modules_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module']):
?>
        <?php if (chkAllowedModule ( array ( $this->_tpl_vars['module'] ) )): ?><!-- IF aricle module enable -->
            <?php if ($this->_tpl_vars['module'] == 'article'): ?>
                <div class="clsModuleSeperator">
                    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/','article'); ?>

                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "left_article_navigation_heading.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    <h3 class="clsInActiveSideHeading" id="articleMain_head" ><span  onclick="adminMenuLeftNavigationPage('articleMain')"><?php echo $this->_tpl_vars['LANG']['header_article_general']; ?>
</span></h3>
                    <div id="articleMain" style="display:none">
                            <ul>
                                <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_articleManage'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/article/articleManage.php"><?php echo $this->_tpl_vars['LANG']['header_article_list']; ?>
</a></li>
                                <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_articleActivate'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/article/articleActivate.php"><?php echo $this->_tpl_vars['LANG']['header_article_activate_links']; ?>
</a></li>
                            <!--<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_articleUploadPopUp'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/article/articleUploadPopUp.php"><?php echo $this->_tpl_vars['LANG']['header_article_upload_links']; ?>
</a></li>-->
                                <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_manageFlaggedarticle'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/article/manageFlaggedArticle.php"><?php echo $this->_tpl_vars['LANG']['header_article_flaggedarticle_links']; ?>
</a></li>
                                <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_managearticleCategory'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/article/manageArticleCategory.php"><?php echo $this->_tpl_vars['LANG']['header_article_category_links']; ?>
</a></li>
                            </ul>
                        </div>

                    <!-- added for article settings menu -->
                    <h3 class="clsInActiveSideHeading" id="articleSetting_head" ><span  onclick="adminMenuLeftNavigationPage('articleSetting')"><?php echo $this->_tpl_vars['LANG']['header_article_setting']; ?>
</span></h3>
                    <div id="articleSetting" style="display:none">
                        <ul>
                            <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_editConfigarticle'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/editConfigData.php?module=article&div=articleSetting"><?php echo $this->_tpl_vars['LANG']['header_article_general_setting']; ?>
</a></li>
                        </ul>
                    </div>

                    <!-- added for plugin menu -->
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