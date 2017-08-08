<?php /* Smarty version 2.6.18, created on 2011-10-17 14:58:20
         compiled from left_photo_navigation_links.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'left_photo_navigation_links.tpl', 32, false),)), $this); ?>
<?php if ($this->_tpl_vars['CFG']['site']['is_module_page'] == 'photo'): ?>
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "left_navigation_deactive_common_links.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php $_from = $this->_tpl_vars['CFG']['site']['modules_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module']):
?>
        <?php if (chkAllowedModule ( array ( $this->_tpl_vars['module'] ) )): ?><!-- IF photo module enable -->
            <?php if ($this->_tpl_vars['module'] == 'photo'): ?>
            	<div class="clsModuleSeperator">
                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/','photo'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "left_photo_navigation_heading.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <h3 class="clsInActiveSideHeading" id="photoMain_head" ><span  onclick="adminMenuLeftNavigationPage('photoMain')"><?php echo $this->_tpl_vars['LANG']['header_photo_general']; ?>
</span></h3>
                    <div id="photoMain" style="display:none">
                        <ul>
                            <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_photoManage'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/photo/photoManage.php"><?php echo $this->_tpl_vars['LANG']['header_photos_list']; ?>
</a></li>
							<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_photoActivate'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/photo/photoActivate.php"><?php echo $this->_tpl_vars['LANG']['header_photo_activate_links']; ?>
</a></li>
						<!-- <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_photoUploadPopUp'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/photo/photoUploadPopUp.php"><?php echo $this->_tpl_vars['LANG']['header_photo_upload_links']; ?>
</a></li>-->
							<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_manageFlaggedphoto'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/photo/manageFlaggedPhoto.php"><?php echo $this->_tpl_vars['LANG']['header_photo_flaggedphoto_links']; ?>
</a></li>
							<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_managephotoCategory'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/photo/managePhotoCategory.php"><?php echo $this->_tpl_vars['LANG']['header_photo_category_links']; ?>
</a></li>
                        </ul>
                    </div>
					<?php $_from = $this->_tpl_vars['admin_main_menu_arrays']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['main_menu']):
?>
						<?php if ($this->_tpl_vars['CFG']['site']['is_module_page'] == 'video' && $this->_tpl_vars['CFG']['html']['current_script_name'] == $this->_tpl_vars['main_menu']['menu_id']): ?>
							<?php $this->assign('menuHeadingClass', 'class="clsActiveSideHeading"'); ?>
							<?php $this->assign('divDisplay', 'block'); ?>
						<?php else: ?>
							<?php $this->assign('menuHeadingClass', 'class="clsInActiveSideHeading"'); ?>
							<?php $this->assign('divDisplay', 'none'); ?>
						<?php endif; ?>
						<h3 id="<?php echo $this->_tpl_vars['main_menu']['menu_id']; ?>
_head" <?php echo $this->_tpl_vars['menuHeadingClass']; ?>
><span onclick="adminMenuLeftNavigationPage('<?php echo $this->_tpl_vars['main_menu']['menu_id']; ?>
')"><?php echo $this->_tpl_vars['main_menu']['menu_name']; ?>
</span></h3>
						<div id="<?php echo $this->_tpl_vars['main_menu']['menu_id']; ?>
" style="display:<?php echo $this->_tpl_vars['divDisplay']; ?>
">
							<ul>
							<?php $_from = $this->_tpl_vars['main_menu']['subMenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sub_menu']):
?>
							  <?php $this->assign('menuClassId', ((is_array($_tmp='left_')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['sub_menu']['menu_id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['sub_menu']['menu_id']))); ?>
							  <li class="<?php echo $this->_tpl_vars['header']->getNavClass($this->_tpl_vars['menuClassId']); ?>
"><a href="<?php echo $this->_tpl_vars['sub_menu']['url']; ?>
"><?php echo $this->_tpl_vars['sub_menu']['menu_name']; ?>
</a></li>
							<?php endforeach; endif; unset($_from); ?>
							</ul>
						</div>
					<?php endforeach; endif; unset($_from); ?>

               	<!-- added for photo settings menu -->
                <h3 class="clsInActiveSideHeading" id="photoSetting_head" ><span  onclick="adminMenuLeftNavigationPage('photoSetting')"><?php echo $this->_tpl_vars['LANG']['header_photo_setting']; ?>
</span></h3>
                <div id="photoSetting" style="display:none">
                	<ul>
                    	<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_editConfigphoto'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/editConfigData.php?module=photo&div=photoSetting"><?php echo $this->_tpl_vars['LANG']['header_photo_general_setting']; ?>
</a></li>
                        <?php if ($this->_tpl_vars['CFG']['admin']['photos']['watermark_apply']): ?>
							<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_waterMarkSetting'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/photo/waterMarkSetting.php"><?php echo $this->_tpl_vars['LANG']['header_photo_watermark_setting']; ?>
</a></li>
						<?php endif; ?>
                        <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_flashlicense'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/photo/flashLicense.php?action=install&prod_id=114"><?php echo $this->_tpl_vars['LANG']['header_install_mugshot']; ?>
</a> </li>
                        <?php if ($this->_tpl_vars['CFG']['admin']['photos']['movie_maker']): ?>
							<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_editConfigMovieMaker'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/photo/editConfigMovieMaker.php"><?php echo $this->_tpl_vars['LANG']['header_photo_movie_maker_setting']; ?>
</a></li>
                            <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_uploadDefaultMovieBgm'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/photo/uploadDefaultMovieBgm.php"><?php echo $this->_tpl_vars['LANG']['header_photo_movie_maker_bgm_setting']; ?>
</a></li>
						<?php endif; ?>
                	</ul>
	            </div>

                <!-- added for plugin menu -->
                 <h3 class="clsInActiveSideHeading" id="photoPlugin_head">
                    <span onclick="adminMenuLeftNavigationPage('photoPlugin')"><?php echo $this->_tpl_vars['LANG']['header_nav_plugin_photo']; ?>
</span>
            	</h3>
            	<div id="photoPlugin" style="display:none">
                <ul>
                    <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_pluginconfig_photo'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/pluginConfig.php?action=photo"><?php echo $this->_tpl_vars['LANG']['header_nav_plugin_photo']; ?>
</a> </li>
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