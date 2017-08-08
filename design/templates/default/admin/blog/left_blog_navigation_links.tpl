{if $CFG.site.is_module_page == 'blog'}
    {$myobj->setTemplateFolder('admin/')}
    {include file="left_navigation_deactive_common_links.tpl"}
    {foreach item=module from=$CFG.site.modules_arr}
        {if chkAllowedModule(array($module))}<!-- IF blog module enable -->
            {if $module == 'blog'}
            	<div class="clsModuleSeperator">
                    {$myobj->setTemplateFolder('admin/','blog')}
                    {include file="left_blog_navigation_heading.tpl"}
                    <h3 class="clsInActiveSideHeading" id="blogMain_head" ><span  onclick="adminMenuLeftNavigationPage('blogMain')">{$LANG.admin_header_blog_general}</span></h3>
                    <div id="blogMain" style="display:none">
                            <ul>
                                <li class="{$header->getNavClass('left_postmanage')}"><a href="{$CFG.site.url}admin/blog/postManage.php">{$LANG.admin_header_post_list}</a></li>
                                <li class="{$header->getNavClass('left_manageblog')}"><a href="{$CFG.site.url}admin/blog/manageBlog.php">{$LANG.admin_header_blog_list}</a></li>
                                <li class="{$header->getNavClass('left_postactivate')}"><a href="{$CFG.site.url}admin/blog/postActivate.php">{$LANG.admin_header_post_activate_links}</a></li>						
                                <li class="{$header->getNavClass('left_manageflaggedpost')}"><a href="{$CFG.site.url}admin/blog/manageFlaggedPost.php">{$LANG.admin_header_post_flaggedpost_links}</a></li>
                                <li class="{$header->getNavClass('left_manageblogcategory')}"><a href="{$CFG.site.url}admin/blog/manageBlogCategory.php">{$LANG.admin_header_blog_category_links}</a></li>
                            </ul>
                        </div>
    
                    <!-- added for blog settings menu -->
                    <h3 class="clsInActiveSideHeading" id="blogSetting_head" ><span  onclick="adminMenuLeftNavigationPage('blogSetting')">{$LANG.admin_header_blog_setting}</span></h3>
                    <div id="blogSetting" style="display:none">
                        <ul>
                            <li class="{$header->getNavClass('left_editconfigblog')}"><a href="{$CFG.site.url}admin/editConfigData.php?module=blog&div=blogSetting">{$LANG.admin_header_blog_general_setting}</a></li>
                        
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

 {/if} {* end of is_module_page == blog condition *}