{if $CFG.site.is_module_page == 'video'}
	{$myobj->setTemplateFolder('admin/')}
	{include file="left_navigation_deactive_common_links.tpl"}
	{foreach item=module from=$CFG.site.modules_arr}
		{if chkAllowedModule(array($module))}<!-- IF video module enable -->
        	{if $module == 'video'}
            	<div class="clsModuleSeperator">
                {$myobj->setTemplateFolder('admin/', 'video')}
                {include file="left_video_navigation_heading.tpl"}
                <h3 class="clsInActiveSideHeading" id="videoMain_head" ><span  onclick="adminMenuLeftNavigationPage('videoMain')">{$LANG.header_video_general}</span></h3>
                <div id="videoMain" style="display:none">
                    <ul>
                        <li class="{$header->getNavClass('left_videoManage')}"><a href="{$CFG.site.url}admin/video/videoManage.php">{$LANG.header_videos}</a></li>
                        <li class="{$header->getNavClass('left_videoActivate')}"><a href="{$CFG.site.url}admin/video/videoActivate.php">{$LANG.header_video_activate}</a></li>
                        <li class="{$header->getNavClass('left_manageFlaggedVideo')}"><a href="{$CFG.site.url}admin/video/manageFlaggedVideo.php">{$LANG.header_video_flagged_links}</a></li>
                        <li class="{$header->getNavClass('left_manageVideoCategory')}"><a href="{$CFG.site.url}admin/video/manageVideoCategory.php">{$LANG.header_video_category_links}</a></li>
                	<!-- <li class="{$header->getNavClass('left_reorderindexblock')}"><a href="{$CFG.site.url}admin/video/reOrderIndexBlock.php">{$LANG.header_home_page_reorder_links}</a> </li>-->
					    <li class="{$header->getNavClass('left_videoreencode')}"><a href="{$CFG.site.url}admin/video/videoReEncode.php">{$LANG.header_video_reencode}</a></li>
                        <li class="{$header->getNavClass('left_reGeneratePlayingTime')}"><a href="{$CFG.site.url}admin/video/reGeneratePlayingTime.php">{$LANG.header_lang_regenerate_playing_time}</a></li>

                    </ul>
                </div>
                <h3 class="clsInActiveSideHeading" id="videoSetting_head" ><span onclick="adminMenuLeftNavigationPage('videoSetting')">{$LANG.header_video_setting}</span></h3>
                <div id="videoSetting" style="display:none">
                    <ul>
                        <li class="{$header->getNavClass('left_editconfigdata_video')}"><a href="{$CFG.site.url}admin/editConfigData.php?module=video&div=videoSetting">{$LANG.header_video_setting}</a></li>
                        <li class="{$header->getNavClass('left_videofilesettings')}"><a href="{$CFG.site.url}admin/video/videoFileSettings.php">{$LANG.header_video_files_setting}</a></li>
                        <li class="{$header->getNavClass('left_editConfigEncoderCommand')}"><a href="{$CFG.site.url}admin/video/editConfigEncoderCommand.php">{$LANG.header_video_command_setting}</a></li>

                    </ul>
                </div>

                <h3 class="clsInActiveSideHeading" id="videoPlayerSetting_head"><span onclick="adminMenuLeftNavigationPage('videoPlayerSetting')">{$LANG.header_video_player_setting}</span></h3>

                <div id="videoPlayerSetting" style="display:none">
                    <ul>
                        <li class="{$header->getNavClass('left_videoplayersettings')}"><a href="{$CFG.site.url}admin/video/videoPlayerSettings.php">{$LANG.header_video_player_setting}</a></li>
                        <li class="{$header->getNavClass('left_videoadvertisement')}"><a href="{$CFG.site.url}admin/video/videoAdvertisement.php">{$LANG.header_video_advertisement_setting}</a></li>
                        <li class="{$header->getNavClass('left_videoLogo')}"><a href="{$CFG.site.url}admin/video/videoLogo.php">{$LANG.header_video_logo_setting}</a></li>
                    </ul>
                </div>

             {foreach item=main_menu from = $admin_main_menu_arrays}
                	{if $CFG.site.is_module_page == 'video' && $CFG.html.current_script_name == $main_menu.menu_id}
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
             <h3 class="clsInActiveSideHeading" id="videoPlugin_head">
                    <span onclick="adminMenuLeftNavigationPage('videoPlugin')">{$LANG.header_nav_plugin_video}</span>
            </h3>
            <div id="videoPlugin" style="display:none">
                <ul>
                    <li class="{$header->getNavClass('left_pluginconfig_video')}"><a href="{$CFG.site.url}admin/pluginConfig.php?action=video">{$LANG.header_nav_plugin_video}</a> </li>
                </ul>
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
{/if} {* end of is_module_page == video condition *}