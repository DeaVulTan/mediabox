<?php /* Smarty version 2.6.18, created on 2011-10-17 14:58:20
         compiled from ../admin/left_navigation_links.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', '../admin/left_navigation_links.tpl', 197, false),)), $this); ?>
<?php if ($this->_tpl_vars['CFG']['site']['is_module_page'] == ''): ?>
	<!--<h3 class="clsActiveSideHeading">
    	<span><?php echo $this->_tpl_vars['LANG']['header_general']; ?>

    	</span>
    </h3>-->
    	<div class="clsModuleSeperator">
   		<ul class="clsModuleHeading">
        	<li class="clsActiveModuleLink"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/index.php"><?php echo $this->_tpl_vars['LANG']['header_lang_home']; ?>
</a> </li>
        </ul>
        <?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'settings')): ?>
	        <h3 class="clsInActiveSideHeading" id="generalSetting_head">
	    		<span onclick="adminMenuLeftNavigationPage('generalSetting')"><?php echo $this->_tpl_vars['LANG']['header_setting']; ?>
</span>
	        </h3>
	        <div id="generalSetting" style="display:none">
	            <ul>
	            	<?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'settings','General, Feature, Language, Payment, Mailer, Module, Myhome, Captcha, Fieldsize')): ?>
	                	<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_editconfigdata_general'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/editConfigData.php"><?php echo $this->_tpl_vars['LANG']['header_edit_config']; ?>
</a> </li>
	                <?php endif; ?>
     	            <?php  if(chkAllowedModule(array('video'))) { ?>
	                	<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_editconfigdata_video'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/editConfigData.php?module=video">Video Settings</a> </li>
	                <?php } ?>
 	                <?php  if(chkAllowedModule(array('music'))) { ?>
	                	<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_editconfigdata_music'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/editConfigData.php?module=music">Music Settings</a> </li>
	                <?php } ?>
	                <?php  if(chkAllowedModule(array('photo'))) { ?>
	                	<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_editconfigdata_photo'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/editConfigData.php?module=photo">Photo Settings</a> </li>
	                <?php } ?>
	                <?php  if(chkAllowedModule(array('blog'))) { ?>
	                	<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_editconfigdata_blog'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/editConfigData.php?module=blog">Blog Settings</a> </li>
	                <?php } ?>
	                <?php  if(chkAllowedModule(array('article'))) { ?>
	                	<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_editconfigdata_article'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/editConfigData.php?module=article">Article Settings</a> </li>
	                <?php } ?>
	                <?php  if(chkAllowedModule(array('discussions'))) { ?>
	                	<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_editconfigdata_discussions'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/editConfigData.php?module=discussions">Discussion Settings</a> </li>
	                <?php } ?>
	                <?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'settings','server')): ?>
						<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_serverSettings'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/serverSettings.php"><?php echo $this->_tpl_vars['LANG']['header_lang_server_setting']; ?>
</a></li>
	                <?php endif; ?>
	                <?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'settings','email_notifications')): ?>
						<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_notificationSettings'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/notificationSettings.php"><?php echo $this->_tpl_vars['LANG']['header_lang_notification_setting']; ?>
</a></li>
	                <?php endif; ?>
	                <?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'settings','template')): ?>
						<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_editTemplateSettings'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/editTemplateSettings.php"><?php echo $this->_tpl_vars['LANG']['header_nav_templatesetting']; ?>
</a> </li>
					<?php endif; ?>
					<?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'settings','search')): ?>
						<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_searchsettings'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/searchSettings.php"><?php echo $this->_tpl_vars['LANG']['header_nav_searchsetting']; ?>
</a> </li>
	                <?php endif; ?>
	                <?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'settings','meta')): ?>
						<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_editmetadetails'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/editMetaDetails.php"><?php echo $this->_tpl_vars['LANG']['header_admin_edit_meta_details_links']; ?>
</a></li>
	                <?php endif; ?>
	                <?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'settings','mugshot')): ?>
						<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_flashlicense'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/flashLicense.php?action=install&prod_id=114"><?php echo $this->_tpl_vars['LANG']['header_edit_mugshot']; ?>
</a></li>
	                <?php endif; ?>
	                <?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'settings','logo')): ?>
						<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_logoSettings'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/logoSettings.php"><?php echo $this->_tpl_vars['LANG']['header_edit_logosetting']; ?>
</a></li>
					<?php endif; ?>
	            </ul>
	        </div>
	    <?php endif; ?>

	    <?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin'): ?>
	        <h3 class="clsInActiveSideHeading" id="generalIndexSetting_head">
	    		<span onclick="adminMenuLeftNavigationPage('generalIndexSetting')"><?php echo $this->_tpl_vars['LANG']['header_index_page_setting']; ?>
</span>
	        </h3>
	        <div id="generalIndexSetting" style="display:none">
	            <ul>
	            	<?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin'): ?>
	                	<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_indexContentGliderSettings'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/indexContentGliderSettings.php"><?php echo $this->_tpl_vars['LANG']['header_content_glider_setting']; ?>
</a></li>
	                <?php endif; ?>
                    <?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin'): ?>
	                	<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_indexMediaTabSettings'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/indexMediaTabSettings.php"><?php echo $this->_tpl_vars['LANG']['header_media_tab_setting']; ?>
</a></li>
	                <?php endif; ?>
	            </ul>
	        </div>
	    <?php endif; ?>

	    <?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'user_manage')): ?>
	        <h3 class="clsInActiveSideHeading" id="generalMember_head">
	    		<span onclick="adminMenuLeftNavigationPage('generalMember')"><?php echo $this->_tpl_vars['LANG']['header_member']; ?>
</span>
	        </h3>
	        <div id="generalMember" style="display:none">
	        	<ul>
	        		<?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'user_manage','Activate, Inactivate, Delete, Edit, Featured, View')): ?>
	        	 		<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_memberManage'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/memberManage.php"><?php echo $this->_tpl_vars['LANG']['header_lang_member_manage']; ?>
</a></li>
	        	 	<?php endif; ?>
	        	 	<?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'user_manage','Add')): ?>
	        	 		<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_memberAdd'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/memberAdd.php"><?php echo $this->_tpl_vars['LANG']['header_add_newmember']; ?>
</a></li>
	        	 	<?php endif; ?>
	        	 	<?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'user_manage','Report')): ?>
	        	 		<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_reportedUsers'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/reportedUsers.php"><?php echo $this->_tpl_vars['LANG']['header_reported_users']; ?>
</a></li>
	        	 	<?php endif; ?>
	        	 		           	</ul>
	        </div>
	    <?php endif; ?>

		<?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'language')): ?>
	        <h3 class="clsInActiveSideHeading" id="generalLanguage_head">
	    		<span onclick="adminMenuLeftNavigationPage('generalLanguage')"><?php echo $this->_tpl_vars['LANG']['header_language']; ?>
</span>
	        </h3>
	        <div id="generalLanguage" style="display:none">
	            <ul>
	            	<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_editemailtemplates'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/editEmailTemplates.php"><?php echo $this->_tpl_vars['LANG']['header_edit_email_templates_links']; ?>
</a></li>
	                <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_editlanguagefile'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/editLanguageFile.php"><?php echo $this->_tpl_vars['LANG']['header_edit_languages_links']; ?>
</a></li>
	                <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_languageexport_export'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/languageExport.php?act=export"><?php echo $this->_tpl_vars['LANG']['header_language_export_links']; ?>
</a></li>
	                <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_languageexport_import'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/languageExport.php?act=import"><?php echo $this->_tpl_vars['LANG']['header_language_import_links']; ?>
</a></li>
	           </ul>
	        </div>
	    <?php endif; ?>

		<?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'menu')): ?>
	        <h3 class="clsInActiveSideHeading" id="generalMenu_head">
	    		<span onclick="adminMenuLeftNavigationPage('generalMenu')"><?php echo $this->_tpl_vars['LANG']['header_menu']; ?>
</span>
	        </h3>
	        <div id="generalMenu" style="display:none">
	        	<ul>
	            	<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_menumanagement'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/menuManagement.php"><?php echo $this->_tpl_vars['LANG']['header_lang_menu_setting']; ?>
</a></li>
	        		<?php if (! $this->_tpl_vars['CFG']['admin']['is_demo_site']): ?>
	               	<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_menumanagement_add'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/menuManagement.php?action=add"><?php echo $this->_tpl_vars['LANG']['header_lang_add_menu']; ?>
</a></li>
	                <?php endif; ?>
	            </ul>
	        </div>
	    <?php endif; ?>

	    <?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'announcement')): ?>
	        <h3 class="clsInActiveSideHeading" id="generalAnnouncement_head">
	    		<span onclick="adminMenuLeftNavigationPage('generalAnnouncement')"><?php echo $this->_tpl_vars['LANG']['header_announcement']; ?>
</span>
	        </h3>
	        <div id="generalAnnouncement" style="display:none">
	       		<ul>
	            	<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_announcement'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/announcement.php"><?php echo $this->_tpl_vars['LANG']['header_announcement']; ?>
</a></li>
	        		<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_announcement_add'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/announcement.php?action=add"><?php echo $this->_tpl_vars['LANG']['header_add_announcement']; ?>
</a></li>
	             </ul>
	        </div>
	    <?php endif; ?>

        <?php if ($this->_tpl_vars['CFG']['admin']['module']['external_login'] && ( $this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'external_login') )): ?>
            <h3 class="clsInActiveSideHeading" id="generalLogin_head">
                <span onclick="adminMenuLeftNavigationPage('generalLogin')"><?php echo $this->_tpl_vars['LANG']['header_login']; ?>
</span>
            </h3>
            <div id="generalLogin" style="display:none">
                <ul>
                     <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_editconfigexternal'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/editConfigExternal.php?config_file_name=config_external_login"><?php echo $this->_tpl_vars['LANG']['header_edit_config_external_links']; ?>
</a> </li>
                     <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_editconfig_config_facebook'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/editConfig.php?config_file_name=config_facebook"><?php echo $this->_tpl_vars['LANG']['header_edit_config_facebook_links']; ?>
</a> </li>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'general')): ?>
	        <h3 class="clsInActiveSideHeading" id="generalList_head">
	    		<span onclick="adminMenuLeftNavigationPage('generalList')"><?php echo $this->_tpl_vars['LANG']['header_general']; ?>
</span>
	        </h3>
	        <div id="generalList" style="display:none">
	            <ul>
	                <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_managebanner'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/manageBanner.php"><?php echo $this->_tpl_vars['LANG']['header_manage_banner_links']; ?>
</a></li>
	                <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_addnewsletter'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/addNewsLetter.php"><?php echo $this->_tpl_vars['LANG']['header_manage_news_letter_links']; ?>
</a></li>
	                <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_newsletterarchive'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/newsLetterArchive.php"><?php echo $this->_tpl_vars['LANG']['header_manage_news_letter_list_links']; ?>
</a></li>
	                <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_reorderprofileblock'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/reOrderProfileBlock.php"><?php echo $this->_tpl_vars['LANG']['header_manage_profile_block']; ?>
</a></li>
	                <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_addprofilecategory'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/addProfileCategory.php"><?php echo $this->_tpl_vars['LANG']['header_add_profile_category']; ?>
</a></li>
	                <li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_latestNews'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/latestNews.php"><?php echo $this->_tpl_vars['LANG']['header_edit_config_latest_news']; ?>
</a> </li>
	    			<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_staticpagemanagement'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/staticPageManagement.php"><?php echo $this->_tpl_vars['LANG']['header_manage_static_pages_links']; ?>
</a></li>
	            </ul>
	       	</div>
	    <?php endif; ?>

		<?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'bugs')): ?>
			<h3 class="clsInActiveSideHeading" id="generalManageBugs_head">
				<span onclick="adminMenuLeftNavigationPage('generalManageBugs')"><?php echo $this->_tpl_vars['LANG']['header_bugs_management']; ?>
</span>
			</h3>
			<div id="generalManageBugs" style="display:none">
				<ul>
					<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_replyBugs'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/replyBugs.php"><?php echo $this->_tpl_vars['LANG']['header_bugs_show_bug']; ?>
</a> </li>
					<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_reportBugs'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/reportBugs.php?mode=add"><?php echo $this->_tpl_vars['LANG']['header_bugs_post_bug']; ?>
</a> </li>
				</ul>
			</div>
		<?php endif; ?>

		<?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'general_menu')): ?>
			<?php additionalAdminGeneralMenuLinks() ?>
	        <?php $_from = $this->_tpl_vars['admin_main_menu_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['main_menu']):
?>
	            <?php if ($this->_tpl_vars['CFG']['site']['is_module_page'] == '' && $this->_tpl_vars['CFG']['html']['current_script_name'] == $this->_tpl_vars['main_menu']['menu_id']): ?>
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
	    <?php endif; ?>
        <?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'plugin')): ?>
	       	<h3 class="clsInActiveSideHeading" id="generalPlugin_head">
				<span onclick="adminMenuLeftNavigationPage('generalPlugin')"><?php echo $this->_tpl_vars['LANG']['header_nav_plugin']; ?>
</span>
			</h3>
			<div id="generalPlugin" style="display:none">
				<ul>
					<li class="<?php echo $this->_tpl_vars['header']->getNavClass('left_pluginconfig'); ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/pluginConfig.php"><?php echo $this->_tpl_vars['LANG']['header_nav_plugin']; ?>
</a> </li>
				</ul>
			</div>
		<?php endif; ?>
        </div>
 	<?php endif; ?>

 	<!-- Module heading hide -->
	<?php $_from = $this->_tpl_vars['CFG']['site']['modules_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module']):
?>
	  	<?php if (chkAllowedModule ( array ( $this->_tpl_vars['module'] ) ) && $this->_tpl_vars['CFG']['site']['is_module_page'] == '' && ( $this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],$this->_tpl_vars['module']) )): ?>
        	<?php if ($this->_tpl_vars['module_function_check_passed_arr'][$this->_tpl_vars['module']]): ?>
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