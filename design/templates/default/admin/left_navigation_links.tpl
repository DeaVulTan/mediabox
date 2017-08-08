{if $CFG.site.is_module_page == ''}
	<!--<h3 class="clsActiveSideHeading">
    	<span>{$LANG.header_general}
    	</span>
    </h3>-->
    	<div class="clsModuleSeperator">
   		<ul class="clsModuleHeading">
        	<li class="clsActiveModuleLink"><a href="{$CFG.site.url}admin/index.php">{$LANG.header_lang_home}</a> </li>
        </ul>
        {if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'settings')}
	        <h3 class="clsInActiveSideHeading" id="generalSetting_head">
	    		<span onclick="adminMenuLeftNavigationPage('generalSetting')">{$LANG.header_setting}</span>
	        </h3>
	        <div id="generalSetting" style="display:none">
	            <ul>
	            	{if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'settings', 'General, Feature, Language, Payment, Mailer, Module, Myhome, Captcha, Fieldsize')}
	                	<li class="{$header->getNavClass('left_editconfigdata_general')}"><a href="{$CFG.site.url}admin/editConfigData.php">{$LANG.header_edit_config}</a> </li>
	                {/if}
     	            {php} if(chkAllowedModule(array('video'))) {{/php}
	                	<li class="{$header->getNavClass('left_editconfigdata_video')}"><a href="{$CFG.site.url}admin/editConfigData.php?module=video">Video Settings</a> </li>
	                {php}}{/php}
 	                {php} if(chkAllowedModule(array('music'))) {{/php}
	                	<li class="{$header->getNavClass('left_editconfigdata_music')}"><a href="{$CFG.site.url}admin/editConfigData.php?module=music">Music Settings</a> </li>
	                {php}}{/php}
	                {php} if(chkAllowedModule(array('photo'))) {{/php}
	                	<li class="{$header->getNavClass('left_editconfigdata_photo')}"><a href="{$CFG.site.url}admin/editConfigData.php?module=photo">Photo Settings</a> </li>
	                {php}}{/php}
	                {php} if(chkAllowedModule(array('blog'))) {{/php}
	                	<li class="{$header->getNavClass('left_editconfigdata_blog')}"><a href="{$CFG.site.url}admin/editConfigData.php?module=blog">Blog Settings</a> </li>
	                {php}}{/php}
	                {php} if(chkAllowedModule(array('article'))) {{/php}
	                	<li class="{$header->getNavClass('left_editconfigdata_article')}"><a href="{$CFG.site.url}admin/editConfigData.php?module=article">Article Settings</a> </li>
	                {php}}{/php}
	                {php} if(chkAllowedModule(array('discussions'))) {{/php}
	                	<li class="{$header->getNavClass('left_editconfigdata_discussions')}"><a href="{$CFG.site.url}admin/editConfigData.php?module=discussions">Discussion Settings</a> </li>
	                {php}}{/php}
	                {if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'settings', 'server')}
						<li class="{$header->getNavClass('left_serverSettings')}"><a href="{$CFG.site.url}admin/serverSettings.php">{$LANG.header_lang_server_setting}</a></li>
	                {/if}
	                {if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'settings', 'email_notifications')}
						<li class="{$header->getNavClass('left_notificationSettings')}"><a href="{$CFG.site.url}admin/notificationSettings.php">{$LANG.header_lang_notification_setting}</a></li>
	                {/if}
	                {if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'settings', 'template')}
						<li class="{$header->getNavClass('left_editTemplateSettings')}"><a href="{$CFG.site.url}admin/editTemplateSettings.php">{$LANG.header_nav_templatesetting}</a> </li>
					{/if}
					{if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'settings', 'search')}
						<li class="{$header->getNavClass('left_searchsettings')}"><a href="{$CFG.site.url}admin/searchSettings.php">{$LANG.header_nav_searchsetting}</a> </li>
	                {/if}
	                {if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'settings', 'meta')}
						<li class="{$header->getNavClass('left_editmetadetails')}"><a href="{$CFG.site.url}admin/editMetaDetails.php">{$LANG.header_admin_edit_meta_details_links}</a></li>
	                {/if}
	                {if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'settings', 'mugshot')}
						<li class="{$header->getNavClass('left_flashlicense')}"><a href="{$CFG.site.url}admin/flashLicense.php?action=install&prod_id=114">{$LANG.header_edit_mugshot}</a></li>
	                {/if}
	                {if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'settings', 'logo')}
						<li class="{$header->getNavClass('left_logoSettings')}"><a href="{$CFG.site.url}admin/logoSettings.php">{$LANG.header_edit_logosetting}</a></li>
					{/if}
	            </ul>
	        </div>
	    {/if}

	    {if $CFG.user.usr_access == 'Admin'}
	        <h3 class="clsInActiveSideHeading" id="generalIndexSetting_head">
	    		<span onclick="adminMenuLeftNavigationPage('generalIndexSetting')">{$LANG.header_index_page_setting}</span>
	        </h3>
	        <div id="generalIndexSetting" style="display:none">
	            <ul>
	            	{if $CFG.user.usr_access == 'Admin'}
	                	<li class="{$header->getNavClass('left_indexContentGliderSettings')}"><a href="{$CFG.site.url}admin/indexContentGliderSettings.php">{$LANG.header_content_glider_setting}</a></li>
	                {/if}
                    {if $CFG.user.usr_access == 'Admin'}
	                	<li class="{$header->getNavClass('left_indexMediaTabSettings')}"><a href="{$CFG.site.url}admin/indexMediaTabSettings.php">{$LANG.header_media_tab_setting}</a></li>
	                {/if}
	            </ul>
	        </div>
	    {/if}

	    {if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'user_manage')}
	        <h3 class="clsInActiveSideHeading" id="generalMember_head">
	    		<span onclick="adminMenuLeftNavigationPage('generalMember')">{$LANG.header_member}</span>
	        </h3>
	        <div id="generalMember" style="display:none">
	        	<ul>
	        		{if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'user_manage', 'Activate, Inactivate, Delete, Edit, Featured, View')}
	        	 		<li class="{$header->getNavClass('left_memberManage')}"><a href="{$CFG.site.url}admin/memberManage.php">{$LANG.header_lang_member_manage}</a></li>
	        	 	{/if}
	        	 	{if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'user_manage', 'Add')}
	        	 		<li class="{$header->getNavClass('left_memberAdd')}"><a href="{$CFG.site.url}admin/memberAdd.php">{$LANG.header_add_newmember}</a></li>
	        	 	{/if}
	        	 	{if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'user_manage', 'Report')}
	        	 		<li class="{$header->getNavClass('left_reportedUsers')}"><a href="{$CFG.site.url}admin/reportedUsers.php">{$LANG.header_reported_users}</a></li>
	        	 	{/if}
	        	 	{* Commented user type options temporarily will be used later
	        	 	{if $CFG.user.usr_access == 'Admin'}
	        	 		<li class="{$header->getNavClass('left_usertype')}"><a href="{$CFG.site.url}admin/userType.php">{$LANG.header_user_type}</a></li>
	    		 		<li class="{$header->getNavClass('left_usertype_add')}"><a href="{$CFG.site.url}admin/userType.php?action=add">{$LANG.header_add_user_type}</a></li>
	    		 	{/if}*}
	           	</ul>
	        </div>
	    {/if}

		{if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'language')}
	        <h3 class="clsInActiveSideHeading" id="generalLanguage_head">
	    		<span onclick="adminMenuLeftNavigationPage('generalLanguage')">{$LANG.header_language}</span>
	        </h3>
	        <div id="generalLanguage" style="display:none">
	            <ul>
	            	<li class="{$header->getNavClass('left_editemailtemplates')}"><a href="{$CFG.site.url}admin/editEmailTemplates.php">{$LANG.header_edit_email_templates_links}</a></li>
	                <li class="{$header->getNavClass('left_editlanguagefile')}"><a href="{$CFG.site.url}admin/editLanguageFile.php">{$LANG.header_edit_languages_links}</a></li>
	                <li class="{$header->getNavClass('left_languageexport_export')}"><a href="{$CFG.site.url}admin/languageExport.php?act=export">{$LANG.header_language_export_links}</a></li>
	                <li class="{$header->getNavClass('left_languageexport_import')}"><a href="{$CFG.site.url}admin/languageExport.php?act=import">{$LANG.header_language_import_links}</a></li>
	           </ul>
	        </div>
	    {/if}

		{if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'menu')}
	        <h3 class="clsInActiveSideHeading" id="generalMenu_head">
	    		<span onclick="adminMenuLeftNavigationPage('generalMenu')">{$LANG.header_menu}</span>
	        </h3>
	        <div id="generalMenu" style="display:none">
	        	<ul>
	            	<li class="{$header->getNavClass('left_menumanagement')}"><a href="{$CFG.site.url}admin/menuManagement.php">{$LANG.header_lang_menu_setting}</a></li>
	        		{if !$CFG.admin.is_demo_site}
	               	<li class="{$header->getNavClass('left_menumanagement_add')}"><a href="{$CFG.site.url}admin/menuManagement.php?action=add">{$LANG.header_lang_add_menu}</a></li>
	                {/if}
	            </ul>
	        </div>
	    {/if}

	    {if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'announcement')}
	        <h3 class="clsInActiveSideHeading" id="generalAnnouncement_head">
	    		<span onclick="adminMenuLeftNavigationPage('generalAnnouncement')">{$LANG.header_announcement}</span>
	        </h3>
	        <div id="generalAnnouncement" style="display:none">
	       		<ul>
	            	<li class="{$header->getNavClass('left_announcement')}"><a href="{$CFG.site.url}admin/announcement.php">{$LANG.header_announcement}</a></li>
	        		<li class="{$header->getNavClass('left_announcement_add')}"><a href="{$CFG.site.url}admin/announcement.php?action=add">{$LANG.header_add_announcement}</a></li>
	             </ul>
	        </div>
	    {/if}

        {if $CFG.admin.module.external_login AND ($CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'external_login'))}
            <h3 class="clsInActiveSideHeading" id="generalLogin_head">
                <span onclick="adminMenuLeftNavigationPage('generalLogin')">{$LANG.header_login}</span>
            </h3>
            <div id="generalLogin" style="display:none">
                <ul>
                     <li class="{$header->getNavClass('left_editconfigexternal')}"><a href="{$CFG.site.url}admin/editConfigExternal.php?config_file_name=config_external_login">{$LANG.header_edit_config_external_links}</a> </li>
                     <li class="{$header->getNavClass('left_editconfig_config_facebook')}"><a href="{$CFG.site.url}admin/editConfig.php?config_file_name=config_facebook">{$LANG.header_edit_config_facebook_links}</a> </li>
                </ul>
            </div>
        {/if}

        {if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'general')}
	        <h3 class="clsInActiveSideHeading" id="generalList_head">
	    		<span onclick="adminMenuLeftNavigationPage('generalList')">{$LANG.header_general}</span>
	        </h3>
	        <div id="generalList" style="display:none">
	            <ul>
	                <li class="{$header->getNavClass('left_managebanner')}"><a href="{$CFG.site.url}admin/manageBanner.php">{$LANG.header_manage_banner_links}</a></li>
	                <li class="{$header->getNavClass('left_addnewsletter')}"><a href="{$CFG.site.url}admin/addNewsLetter.php">{$LANG.header_manage_news_letter_links}</a></li>
	                <li class="{$header->getNavClass('left_newsletterarchive')}"><a href="{$CFG.site.url}admin/newsLetterArchive.php">{$LANG.header_manage_news_letter_list_links}</a></li>
	                <li class="{$header->getNavClass('left_reorderprofileblock')}"><a href="{$CFG.site.url}admin/reOrderProfileBlock.php">{$LANG.header_manage_profile_block}</a></li>
	                <li class="{$header->getNavClass('left_addprofilecategory')}"><a href="{$CFG.site.url}admin/addProfileCategory.php">{$LANG.header_add_profile_category}</a></li>
	                <li class="{$header->getNavClass('left_latestNews')}"><a href="{$CFG.site.url}admin/latestNews.php">{$LANG.header_edit_config_latest_news}</a> </li>
	    			<li class="{$header->getNavClass('left_staticpagemanagement')}"><a href="{$CFG.site.url}admin/staticPageManagement.php">{$LANG.header_manage_static_pages_links}</a></li>
	            </ul>
	       	</div>
	    {/if}

		{if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'bugs')}
			<h3 class="clsInActiveSideHeading" id="generalManageBugs_head">
				<span onclick="adminMenuLeftNavigationPage('generalManageBugs')">{$LANG.header_bugs_management}</span>
			</h3>
			<div id="generalManageBugs" style="display:none">
				<ul>
					<li class="{$header->getNavClass('left_replyBugs')}"><a href="{$CFG.site.url}admin/replyBugs.php">{$LANG.header_bugs_show_bug}</a> </li>
					<li class="{$header->getNavClass('left_reportBugs')}"><a href="{$CFG.site.url}admin/reportBugs.php?mode=add">{$LANG.header_bugs_post_bug}</a> </li>
				</ul>
			</div>
		{/if}

		{if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'general_menu')}
			{php}additionalAdminGeneralMenuLinks(){/php}
	        {foreach item=main_menu from = $admin_main_menu_arr}
	            {if $CFG.site.is_module_page == '' && $CFG.html.current_script_name == $main_menu.menu_id}
	                {assign var = menuHeadingClass value = 'class="clsActiveSideHeading"'}
	                {assign var = divDisplay value = 'block'}
	            {else}
	                {assign var = menuHeadingClass value = 'class="clsInActiveSideHeading"'}
	                {assign var = divDisplay value = 'none'}
	            {/if}
	            <h3 id="{$main_menu.menu_id}_head" {$menuHeadingClass}><span onclick="adminMenuLeftNavigationPage('{$main_menu.menu_id}')">{$main_menu.menu_name}</span></h3>
	            <div id="{$main_menu.menu_id}" style="display:{$divDisplay}">
	                <ul>
	                {foreach item = sub_menu from = $main_menu.subMenu}
	                  {assign var = menuClassId value = 'left_'|cat:$sub_menu.menu_id}
	                  <li class="{$header->getNavClass($menuClassId)}"><a href="{$sub_menu.url}">{$sub_menu.menu_name}</a></li>
	                {/foreach}
	                </ul>
	            </div>
	        {/foreach}
	    {/if}
        {if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'plugin')}
	       	<h3 class="clsInActiveSideHeading" id="generalPlugin_head">
				<span onclick="adminMenuLeftNavigationPage('generalPlugin')">{$LANG.header_nav_plugin}</span>
			</h3>
			<div id="generalPlugin" style="display:none">
				<ul>
					<li class="{$header->getNavClass('left_pluginconfig')}"><a href="{$CFG.site.url}admin/pluginConfig.php">{$LANG.header_nav_plugin}</a> </li>
				</ul>
			</div>
		{/if}
        </div>
 	{/if}

 	<!-- Module heading hide -->
	{foreach item=module from=$CFG.site.modules_arr}
	  	{if chkAllowedModule(array($module)) && $CFG.site.is_module_page == '' && ($CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, $module))}
        	{if $module_function_check_passed_arr.$module}
            <div class="clsModuleSeperator">
		   		{$myobj->setTemplateFolder('admin/',$module)}
		   	 	{assign var=module_heading_tpl value='left_'|cat:$module|cat:'_navigation_heading.tpl'}
		   		{include file=$module_heading_tpl}
             </div>
            {/if}
 	  	{/if}
 	{/foreach}