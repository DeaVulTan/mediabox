{if $CFG.site.is_module_page == 'music'}
    {$myobj->setTemplateFolder('admin/')}
    {include file="left_navigation_deactive_common_links.tpl"}
    {foreach item=module from=$CFG.site.modules_arr}
        {if chkAllowedModule(array($module))}<!-- IF music module enable -->
            {if $module == 'music'}
            <div class="clsModuleSeperator">
                {$myobj->setTemplateFolder('admin/','music')}
                {include file="left_music_navigation_heading.tpl"}
                    <h3 class="clsInActiveSideHeading" id="musicMain_head" ><span  onclick="adminMenuLeftNavigationPage('musicMain')">{$LANG.header_music_general}</span></h3>
                    <div id="musicMain" style="display:none">
                        <ul>
                            <li class="{$header->getNavClass('left_musicManage')}"><a href="{$CFG.site.url}admin/music/musicManage.php">{$LANG.header_musics_list}</a></li>
                            <li class="{$header->getNavClass('left_manageMusicCategory')}"><a href="{$CFG.site.url}admin/music/manageMusicCategory.php">{$LANG.header_music_category_links}</a></li>
                            {if isset($CFG.admin.musics.music_artist_feature) and $CFG.admin.musics.music_artist_feature}
                                <li class="{$header->getNavClass('left_manageMusicArtistCategory')}"><a href="{$CFG.site.url}admin/music/manageMusicArtistCategory.php">{$LANG.header_music_artist_category_links}</a></li>
                            {/if}
    <!--                            <li class="{$header->getNavClass('left_musicUploadPopUp')}"><a href="{$CFG.site.url}admin/music/musicUploadPopUp.php">{$LANG.header_music_upload_links}</a></li>-->
                            <li class="{$header->getNavClass('left_musicplaylist')}"><a href="{$CFG.site.url}admin/music/musicPlaylist.php">{$LANG.header_music_manage_playlist}</a></li>
                            <li class="{$header->getNavClass('left_manageFlaggedMusic')}"><a href="{$CFG.site.url}admin/music/manageFlaggedMusic.php">{$LANG.header_music_flaggedmusic_links}</a></li>
                            <li class="{$header->getNavClass('left_musicActivate')}"><a href="{$CFG.site.url}admin/music/musicActivate.php">{$LANG.header_music_activate_links}</a></li>
                            <li class="{$header->getNavClass('left_musicAlbumManage')}"><a href="{$CFG.site.url}admin/music/musicAlbumManage.php">{$LANG.header_music_albums_list}</a></li>
                            <li class="{$header->getNavClass('left_editconfigdata_music')}"><a href="{$CFG.site.url}admin/editConfigData.php?module=music&div=musicMain">{$LANG.header_music_setting}</a></li>
                            <!--li class="{$header->getNavClass('left_musicFileSettings')}"><a href="{$CFG.site.url}admin/music/musicFileSettings.php">{$LANG.header_music_filesetting_links}</a></li-->
                            <!--li class="{$header->getNavClass('left_editconfig_config_encoder')}"><a href="{$CFG.site.url}admin/editConfig.php?config_file_name=config_encoder&module=music&div=musicMain">{$LANG.header_music_encoder_setting}</a></li-->
                            {if isset($CFG.admin.musics.music_artist_feature) and $CFG.admin.musics.music_artist_feature}
                                <li class="{$header->getNavClass('left_manageartistmembersphoto')}"><a href="{$CFG.site.url}admin/music/manageArtistMembersPhoto.php">{$LANG.header_music_manage_artist}</a></li>
                            {else}
                                <li class="{$header->getNavClass('left_manageartistphoto')}"><a href="{$CFG.site.url}admin/music/manageArtistPhoto.php">{$LANG.header_music_manage_artist}</a></li>
                            {/if}
                            {if $CFG.admin.musics.allowed_usertypes_to_upload_for_sale != 'None'}
                                <li class="{$header->getNavClass('left_managetransactiondetails')}"><a href="{$CFG.site.url}admin/music/manageTransactionDetails.php">{$LANG.header_music_manage_transaction_details}</a></li>
                            {/if}
                            {if isset($CFG.admin.musics.music_artist_feature) and $CFG.admin.musics.music_artist_feature}
                                <li class="{$header->getNavClass('left_membertypemanage')}"><a href="{$CFG.site.url}admin/music/memberTypeManage.php">{$LANG.header_music_manage_member_type_details}</a></li>
                            {/if}
                        </ul>
                    </div>
                    <h3 class="clsInActiveSideHeading" id="musicSetting_head"><span onclick="adminMenuLeftNavigationPage('musicSetting')">{$LANG.header_music_player_setting}</span></h3>
                    <div id="musicSetting" style="display:none">
                        <ul>
                            <li class="{$header->getNavClass('left_musicPlayerSettings')}"><a href="{$CFG.site.url}admin/music/musicPlayerSettings.php">{$LANG.header_music_player_setting}</a></li>
                            <li class="{$header->getNavClass('left_musicadvertisement')}"><a href="{$CFG.site.url}admin/music/musicAdvertisement.php">{$LANG.header_music_advertisement_setting}</a></li>
                        </ul>
                    </div>
				 {foreach item=main_menu from = $admin_main_menu_arrays}
					{if $CFG.site.is_module_page == 'music' && $CFG.html.current_script_name == $main_menu.menu_id}
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
                <!-- added for plugin menu -->
                     <h3 class="clsInActiveSideHeading" id="musicPlugin_head">
                        <span onclick="adminMenuLeftNavigationPage('musicPlugin')">{$LANG.header_nav_plugin_music}</span>
                    </h3>
                     <div id="musicPlugin" style="display:none">
                    <ul>
                        <li class="{$header->getNavClass('left_pluginconfig_music')}"><a href="{$CFG.site.url}admin/pluginConfig.php?action=music">{$LANG.header_nav_plugin_music}</a> </li>
                    </ul>
                    </div>
                </div>
            {else}<!-- Deactive all other module -->
                <div class="clsModuleSeperator">
                {$myobj->setTemplateFolder('admin/',$module)}
                {assign var=module_heading_tpl value='left_'|cat:$module|cat:'_navigation_heading.tpl'}
                {include file=$module_heading_tpl}
                </div>
            {/if}
        {/if}
    {/foreach}

 {/if} {* end of is_module_page == music condition *}