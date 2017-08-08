<?php /* Smarty version 2.6.18, created on 2011-10-17 14:58:20
         compiled from left_music_navigation_links.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'left_music_navigation_links.tpl', 58, false),)), $this); ?>
<?php if ($this->_tpl_vars['CFG']['site']['is_module_page'] == 'music'): ?>
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "left_navigation_deactive_common_links.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php $_from = $this->_tpl_vars['CFG']['site']['modules_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module']):
?>
        <?php if (chkAllowedModule ( array ( $this->_tpl_vars['module'] ) )): ?><!-- IF music module enable -->
            <?php if ($this->_tpl_vars['module'] == 'music'): ?>
            <div class="clsModuleSeperator">
                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/','music'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "left_music_navigation_heading.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    <h3 class="clsInActiveSideHeading" id="musicMain_head" ><span  onclick="adminMenuLeftNavigationPage('musicMain')"><?php echo $this->_tpl_vars['LANG']['header_music_general']; ?>
</span></h3>
                    <div id="musicMain" style="display:none">
                        <ul>
                            <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_musicManage'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/musicManage.php"><?php echo $this->_tpl_vars['LANG']['header_musics_list']; ?>
</a></li>
                            <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_manageMusicCategory'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/manageMusicCategory.php"><?php echo $this->_tpl_vars['LANG']['header_music_category_links']; ?>
</a></li>
                            <?php if (isset ( $this->_tpl_vars['CFG']['admin']['musics']['music_artist_feature'] ) && $this->_tpl_vars['CFG']['admin']['musics']['music_artist_feature']): ?>
                                <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_manageMusicArtistCategory'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/manageMusicArtistCategory.php"><?php echo $this->_tpl_vars['LANG']['header_music_artist_category_links']; ?>
</a></li>
                            <?php endif; ?>
    <!--                            <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_musicUploadPopUp'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/musicUploadPopUp.php"><?php echo $this->_tpl_vars['LANG']['header_music_upload_links']; ?>
</a></li>-->
                            <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_musicplaylist'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/musicPlaylist.php"><?php echo $this->_tpl_vars['LANG']['header_music_manage_playlist']; ?>
</a></li>
                            <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_manageFlaggedMusic'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/manageFlaggedMusic.php"><?php echo $this->_tpl_vars['LANG']['header_music_flaggedmusic_links']; ?>
</a></li>
                            <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_musicActivate'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/musicActivate.php"><?php echo $this->_tpl_vars['LANG']['header_music_activate_links']; ?>
</a></li>
                            <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_musicAlbumManage'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/musicAlbumManage.php"><?php echo $this->_tpl_vars['LANG']['header_music_albums_list']; ?>
</a></li>
                            <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_editconfigdata_music'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/editConfigData.php?module=music&div=musicMain"><?php echo $this->_tpl_vars['LANG']['header_music_setting']; ?>
</a></li>
                            <!--li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_musicFileSettings'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/musicFileSettings.php"><?php echo $this->_tpl_vars['LANG']['header_music_filesetting_links']; ?>
</a></li-->
                            <!--li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_editconfig_config_encoder'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/editConfig.php?config_file_name=config_encoder&module=music&div=musicMain"><?php echo $this->_tpl_vars['LANG']['header_music_encoder_setting']; ?>
</a></li-->
                            <?php if (isset ( $this->_tpl_vars['CFG']['admin']['musics']['music_artist_feature'] ) && $this->_tpl_vars['CFG']['admin']['musics']['music_artist_feature']): ?>
                                <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_manageartistmembersphoto'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/manageArtistMembersPhoto.php"><?php echo $this->_tpl_vars['LANG']['header_music_manage_artist']; ?>
</a></li>
                            <?php else: ?>
                                <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_manageartistphoto'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/manageArtistPhoto.php"><?php echo $this->_tpl_vars['LANG']['header_music_manage_artist']; ?>
</a></li>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['CFG']['admin']['musics']['allowed_usertypes_to_upload_for_sale'] != 'None'): ?>
                                <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_managetransactiondetails'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/manageTransactionDetails.php"><?php echo $this->_tpl_vars['LANG']['header_music_manage_transaction_details']; ?>
</a></li>
                            <?php endif; ?>
                            <?php if (isset ( $this->_tpl_vars['CFG']['admin']['musics']['music_artist_feature'] ) && $this->_tpl_vars['CFG']['admin']['musics']['music_artist_feature']): ?>
                                <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_membertypemanage'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/memberTypeManage.php"><?php echo $this->_tpl_vars['LANG']['header_music_manage_member_type_details']; ?>
</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <h3 class="clsInActiveSideHeading" id="musicSetting_head"><span onclick="adminMenuLeftNavigationPage('musicSetting')"><?php echo $this->_tpl_vars['LANG']['header_music_player_setting']; ?>
</span></h3>
                    <div id="musicSetting" style="display:none">
                        <ul>
                            <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_musicPlayerSettings'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/musicPlayerSettings.php"><?php echo $this->_tpl_vars['LANG']['header_music_player_setting']; ?>
</a></li>
                            <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_musicadvertisement'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/musicAdvertisement.php"><?php echo $this->_tpl_vars['LANG']['header_music_advertisement_setting']; ?>
</a></li>
                        </ul>
                    </div>
				 <?php $_from = $this->_tpl_vars['admin_main_menu_arrays']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['main_menu']):
?>
					<?php if ($this->_tpl_vars['CFG']['site']['is_module_page'] == 'music' && $this->_tpl_vars['CFG']['html']['current_script_name'] == $this->_tpl_vars['main_menu']['menu_id']): ?>
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
                <!-- added for plugin menu -->
                     <h3 class="clsInActiveSideHeading" id="musicPlugin_head">
                        <span onclick="adminMenuLeftNavigationPage('musicPlugin')"><?php echo $this->_tpl_vars['LANG']['header_nav_plugin_music']; ?>
</span>
                    </h3>
                     <div id="musicPlugin" style="display:none">
                    <ul>
                        <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_pluginconfig_music'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/pluginConfig.php?action=music"><?php echo $this->_tpl_vars['LANG']['header_nav_plugin_music']; ?>
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