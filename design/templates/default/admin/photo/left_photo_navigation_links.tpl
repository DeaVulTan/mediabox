{if $CFG.site.is_module_page == 'photo'}
    {$myobj->setTemplateFolder('admin/')}
    {include file="left_navigation_deactive_common_links.tpl"}
    {foreach item=module from=$CFG.site.modules_arr}
        {if chkAllowedModule(array($module))}<!-- IF photo module enable -->
            {if $module == 'photo'}
            	<div class="clsModuleSeperator">
                {$myobj->setTemplateFolder('admin/', 'photo')}
                {include file="left_photo_navigation_heading.tpl"}
                <h3 class="clsInActiveSideHeading" id="photoMain_head" ><span  onclick="adminMenuLeftNavigationPage('photoMain')">{$LANG.header_photo_general}</span></h3>
                    <div id="photoMain" style="display:none">
                        <ul>
                            <li class="{$header->getNavClass('left_photoManage')}"><a href="{$CFG.site.url}admin/photo/photoManage.php">{$LANG.header_photos_list}</a></li>
							<li class="{$header->getNavClass('left_photoActivate')}"><a href="{$CFG.site.url}admin/photo/photoActivate.php">{$LANG.header_photo_activate_links}</a></li>
						<!-- <li class="{$header->getNavClass('left_photoUploadPopUp')}"><a href="{$CFG.site.url}admin/photo/photoUploadPopUp.php">{$LANG.header_photo_upload_links}</a></li>-->
							<li class="{$header->getNavClass('left_manageFlaggedphoto')}"><a href="{$CFG.site.url}admin/photo/manageFlaggedPhoto.php">{$LANG.header_photo_flaggedphoto_links}</a></li>
							<li class="{$header->getNavClass('left_managephotoCategory')}"><a href="{$CFG.site.url}admin/photo/managePhotoCategory.php">{$LANG.header_photo_category_links}</a></li>
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

               	<!-- added for photo settings menu -->
                <h3 class="clsInActiveSideHeading" id="photoSetting_head" ><span  onclick="adminMenuLeftNavigationPage('photoSetting')">{$LANG.header_photo_setting}</span></h3>
                <div id="photoSetting" style="display:none">
                	<ul>
                    	<li class="{$header->getNavClass('left_editConfigphoto')}"><a href="{$CFG.site.url}admin/editConfigData.php?module=photo&div=photoSetting">{$LANG.header_photo_general_setting}</a></li>
                        {if $CFG.admin.photos.watermark_apply}
							<li class="{$header->getNavClass('left_waterMarkSetting')}"><a href="{$CFG.site.url}admin/photo/waterMarkSetting.php">{$LANG.header_photo_watermark_setting}</a></li>
						{/if}
                        <li class="{$header->getNavClass('left_flashlicense')}"><a href="{$CFG.site.url}admin/photo/flashLicense.php?action=install&prod_id=114">{$LANG.header_install_mugshot}</a> </li>
                        {if $CFG.admin.photos.movie_maker}
							<li class="{$header->getNavClass('left_editConfigMovieMaker')}"><a href="{$CFG.site.url}admin/photo/editConfigMovieMaker.php">{$LANG.header_photo_movie_maker_setting}</a></li>
                            <li class="{$header->getNavClass('left_uploadDefaultMovieBgm')}"><a href="{$CFG.site.url}admin/photo/uploadDefaultMovieBgm.php">{$LANG.header_photo_movie_maker_bgm_setting}</a></li>
						{/if}
                	</ul>
	            </div>

                <!-- added for plugin menu -->
                 <h3 class="clsInActiveSideHeading" id="photoPlugin_head">
                    <span onclick="adminMenuLeftNavigationPage('photoPlugin')">{$LANG.header_nav_plugin_photo}</span>
            	</h3>
            	<div id="photoPlugin" style="display:none">
                <ul>
                    <li class="{$header->getNavClass('left_pluginconfig_photo')}"><a href="{$CFG.site.url}admin/pluginConfig.php?action=photo">{$LANG.header_nav_plugin_photo}</a> </li>
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

 {/if} {* end of is_module_page == photo condition *}