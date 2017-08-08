<?php /* Smarty version 2.6.18, created on 2011-10-17 14:58:20
         compiled from left_video_navigation_links.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'left_video_navigation_links.tpl', 55, false),)), $this); ?>
<?php if ($this->_tpl_vars['CFG']['site']['is_module_page'] == 'video'): ?>
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
        	<?php if ($this->_tpl_vars['module'] == 'video'): ?>
            	<div class="clsModuleSeperator">
                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/','video'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "left_video_navigation_heading.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <h3 class="clsInActiveSideHeading" id="videoMain_head" ><span  onclick="adminMenuLeftNavigationPage('videoMain')"><?php echo $this->_tpl_vars['LANG']['header_video_general']; ?>
</span></h3>
                <div id="videoMain" style="display:none">
                    <ul>
                        <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_videoManage'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/video/videoManage.php"><?php echo $this->_tpl_vars['LANG']['header_videos']; ?>
</a></li>
                        <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_videoActivate'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/video/videoActivate.php"><?php echo $this->_tpl_vars['LANG']['header_video_activate']; ?>
</a></li>
                        <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_manageFlaggedVideo'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/video/manageFlaggedVideo.php"><?php echo $this->_tpl_vars['LANG']['header_video_flagged_links']; ?>
</a></li>
                        <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_manageVideoCategory'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/video/manageVideoCategory.php"><?php echo $this->_tpl_vars['LANG']['header_video_category_links']; ?>
</a></li>
                	<!-- <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_reorderindexblock'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/video/reOrderIndexBlock.php"><?php echo $this->_tpl_vars['LANG']['header_home_page_reorder_links']; ?>
</a> </li>-->
					    <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_videoreencode'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/video/videoReEncode.php"><?php echo $this->_tpl_vars['LANG']['header_video_reencode']; ?>
</a></li>
                        <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_reGeneratePlayingTime'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/video/reGeneratePlayingTime.php"><?php echo $this->_tpl_vars['LANG']['header_lang_regenerate_playing_time']; ?>
</a></li>

                    </ul>
                </div>
                <h3 class="clsInActiveSideHeading" id="videoSetting_head" ><span onclick="adminMenuLeftNavigationPage('videoSetting')"><?php echo $this->_tpl_vars['LANG']['header_video_setting']; ?>
</span></h3>
                <div id="videoSetting" style="display:none">
                    <ul>
                        <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_editconfigdata_video'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/editConfigData.php?module=video&div=videoSetting"><?php echo $this->_tpl_vars['LANG']['header_video_setting']; ?>
</a></li>
                        <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_videofilesettings'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/video/videoFileSettings.php"><?php echo $this->_tpl_vars['LANG']['header_video_files_setting']; ?>
</a></li>
                        <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_editConfigEncoderCommand'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/video/editConfigEncoderCommand.php"><?php echo $this->_tpl_vars['LANG']['header_video_command_setting']; ?>
</a></li>

                    </ul>
                </div>

                <h3 class="clsInActiveSideHeading" id="videoPlayerSetting_head"><span onclick="adminMenuLeftNavigationPage('videoPlayerSetting')"><?php echo $this->_tpl_vars['LANG']['header_video_player_setting']; ?>
</span></h3>

                <div id="videoPlayerSetting" style="display:none">
                    <ul>
                        <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_videoplayersettings'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/video/videoPlayerSettings.php"><?php echo $this->_tpl_vars['LANG']['header_video_player_setting']; ?>
</a></li>
                        <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_videoadvertisement'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/video/videoAdvertisement.php"><?php echo $this->_tpl_vars['LANG']['header_video_advertisement_setting']; ?>
</a></li>
                        <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_videoLogo'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/video/videoLogo.php"><?php echo $this->_tpl_vars['LANG']['header_video_logo_setting']; ?>
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
             <h3 class="clsInActiveSideHeading" id="videoPlugin_head">
                    <span onclick="adminMenuLeftNavigationPage('videoPlugin')"><?php echo $this->_tpl_vars['LANG']['header_nav_plugin_video']; ?>
</span>
            </h3>
            <div id="videoPlugin" style="display:none">
                <ul>
                    <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_pluginconfig_video'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/pluginConfig.php?action=video"><?php echo $this->_tpl_vars['LANG']['header_nav_plugin_video']; ?>
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