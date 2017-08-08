{if $CFG.site.is_module_page == 'discussions'}
	{$myobj->setTemplateFolder('admin/')}
	{include file="left_navigation_deactive_common_links.tpl"}
	{foreach item=module from=$CFG.site.modules_arr}
		{if chkAllowedModule(array($module))}<!-- IF video module enable -->
        	{if $module == 'discussions'}
            	<div class="clsModuleSeperator">
                    {$myobj->setTemplateFolder('admin/', 'discussions')}
                    {include file="left_discussions_navigation_heading.tpl"}
                    <h3 class="clsInActiveSideHeading" id="discussionsMain_head" ><span  onclick="adminMenuLeftNavigationPage('discussionsMain')">{$LANG.header_discussions_general}</span></h3>
                    <div id="discussionsMain" style="display:none">
                        <ul>
                            <li class="{$header->getNavClass('left_discussions')}"><a href="{$CFG.site.url}admin/discussions/discussions.php">{$LANG.header_admin_manage_discussions}</a></li>
                            <li class="{$header->getNavClass('left_addDiscussionTitle')}"><a href="{$CFG.site.url}admin/discussions/addDiscussionTitle.php">{$LANG.header_admin_add_discussions}</a></li>
                            <li class="{$header->getNavClass('left_discussions_search')}"><a href="{$CFG.site.url}admin/discussions/discussions.php?mode=search">{$LANG.header_admin_search_discussions}</a></li>
                           {if $myobj->_currentPage=='managesolutions' || $myobj->_currentPage=='viewsolutions'}
                              <li class="{if $myobj->_currentPage=='managesolutions'}{$header->getNavClass('left_managesolutions')}{else}{$header->getNavClass('left_viewsolutions')}{/if}"><a href="{$CFG.site.url}admin/discussions/manageSolutions.php?did={$myobj->getFormField('did')}">{$LANG.header_admin_manage_solution}</a></li>
                              <li class="{$header->getNavClass('left_managesolutions_search')}"><a href="{$CFG.site.url}admin/discussions/manageSolutions.php?did={$myobj->getFormField('did')}&mode=search">{$LANG.header_admin_search_solution}</a></li>
                              <li class="{$header->getNavClass('left_managesolutions_add')}"><a href="{$CFG.site.url}admin/discussions/manageSolutions.php?did={$myobj->getFormField('did')}&mode=add">{$LANG.header_admin_add_solution}</a></li>
                               {/if}
                            <li class="{$header->getNavClass('left_discussioncategory')}"><a href="{$CFG.site.url}admin/discussions/discussionCategory.php">{$LANG.header_admin_board_category}</a></li>
                            <li class="{$header->getNavClass('left_discussioncategory_add')}"><a href="{$CFG.site.url}admin/discussions/discussionCategory.php?mode=add">{$LANG.header_admin_subtitle_add_category}</a></li>
                             <li class="{$header->getNavClass('left_commonwords')}"><a href="{$CFG.site.url}admin/discussions/commonwords.php">{$LANG.discuzz_commonwords_title}</a></li>
                        </ul>
                    </div>
                 <h3 class="clsInActiveSideHeading" id="discussionsSetting_head"><span onclick="adminMenuLeftNavigationPage('discussionsSetting')">{$LANG.header_discussions_setting}</span></h3>
                    <div id="discussionsSetting" style="display:none">
                       
                       <ul>
                       <li class="{$header->getNavClass('left_editconfigdata_discussions')}"><a href="{$CFG.site.url}admin/editConfigData.php?module=discussions&div=discussionsSetting">Discussion Settings</a> </li>
                       </ul>
                       {*
                        <ul>
                            <li class="{$header->getNavClass('left_editconfig_config_discussions')}"><a href="{$CFG.site.url}admin/editConfigData.php?module=discussions&div=discussionsSetting">{$LANG.header_edit_discussions_config}</a> </li>
                   <li class="{$header->getNavClass('left_editconfig_config_feature_discussion_configs')}"><a href="{$CFG.site.url}admin/{$CFG.admin.index.home_module}/editConfig.php?config_file_name=config_feature&folder=discussion_configs&amp;module=discussions&amp;div=discussionsSetting">{$LANG.header_edit_configuration_links_feature}</a> </li>
                   <li class="{$header->getNavClass('left_editconfig_config_solutions')}"><a href="{$CFG.site.url}admin/discussions/editConfig.php?config_file_name=config_solutions&amp;module=discussions&amp;div=discussionsSetting&folder=discussion_configs">{$LANG.boards_and_solutions}</a> </li>
                           <li class="{$header->getNavClass('left_editconfig_config_rewards')}"><a href="{$CFG.site.url}admin/discussions/editConfig.php?config_file_name=config_rewards&amp;module=discussions&amp;div=discussionsSetting&folder=discussion_configs">{$LANG.header_edit_configuration_links_rewards}</a> </li>
                           <li class="{$header->getNavClass('left_editSideBarConfig')}"><a href="{$CFG.site.url}admin/discussions/editSideBarConfig.php?folder=discussion_configs&amp;module=discussions&amp;div=discussionsSetting">{$LANG.header_edit_configuration_links_rightbar}</a> </li>
                   <li class="{$header->getNavClass('left_editconfigindex')}"><a href="{$CFG.site.url}admin/{$CFG.admin.index.home_module}/editConfigIndex.php?module=discussions&amp;div=discussionsSetting">{$LANG.header_edit_configuration_links_homepage}</a> </li>
                   <li class="{$header->getNavClass('left_editdiscussionemailtemplates')}"><a href="{$CFG.site.url}admin/{$CFG.admin.index.home_module}/editDiscussionEmailTemplates.php?module=discussions&amp;div=discussionsSetting">{$LANG.header_edit_email_templates_links}</a></li>
                        </ul>
                        *}
                    </div>
				</div>
			{else}<!-- Deactive all other module -->
            		<div class="clsModuleSeperator">
                        {$myobj->setTemplateFolder('admin/', $module)}
                        {assign var=module_heading_tpl value='left_'|cat:$module|cat:'_navigation_heading.tpl'}
                        {include file=$module_heading_tpl}
					</div>
            {/if}
		{/if}
	{/foreach}
{/if} {* end of is_module_page == discussions condition *}