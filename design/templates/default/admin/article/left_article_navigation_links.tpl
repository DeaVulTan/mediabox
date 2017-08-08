{if $CFG.site.is_module_page == 'article'}
    {$myobj->setTemplateFolder('admin/')}
    {include file="left_navigation_deactive_common_links.tpl"}
    {foreach item=module from=$CFG.site.modules_arr}
        {if chkAllowedModule(array($module))}<!-- IF aricle module enable -->
            {if $module == 'article'}
                <div class="clsModuleSeperator">
                    {$myobj->setTemplateFolder('admin/','article')}
                    {include file="left_article_navigation_heading.tpl"}
                    <h3 class="clsInActiveSideHeading" id="articleMain_head" ><span  onclick="adminMenuLeftNavigationPage('articleMain')">{$LANG.header_article_general}</span></h3>
                    <div id="articleMain" style="display:none">
                            <ul>
                                <li class="{$header->getNavClass('left_articleManage')}"><a href="{$CFG.site.url}admin/article/articleManage.php">{$LANG.header_article_list}</a></li>
                                <li class="{$header->getNavClass('left_articleActivate')}"><a href="{$CFG.site.url}admin/article/articleActivate.php">{$LANG.header_article_activate_links}</a></li>
                            <!--<li class="{$header->getNavClass('left_articleUploadPopUp')}"><a href="{$CFG.site.url}admin/article/articleUploadPopUp.php">{$LANG.header_article_upload_links}</a></li>-->
                                <li class="{$header->getNavClass('left_manageFlaggedarticle')}"><a href="{$CFG.site.url}admin/article/manageFlaggedArticle.php">{$LANG.header_article_flaggedarticle_links}</a></li>
                                <li class="{$header->getNavClass('left_managearticleCategory')}"><a href="{$CFG.site.url}admin/article/manageArticleCategory.php">{$LANG.header_article_category_links}</a></li>
                            </ul>
                        </div>

                    <!-- added for article settings menu -->
                    <h3 class="clsInActiveSideHeading" id="articleSetting_head" ><span  onclick="adminMenuLeftNavigationPage('articleSetting')">{$LANG.header_article_setting}</span></h3>
                    <div id="articleSetting" style="display:none">
                        <ul>
                            <li class="{$header->getNavClass('left_editConfigarticle')}"><a href="{$CFG.site.url}admin/editConfigData.php?module=article&div=articleSetting">{$LANG.header_article_general_setting}</a></li>
                        </ul>
                    </div>

                    <!-- added for plugin menu -->
                     {*<h3 class="clsInActiveSideHeading" id="articlePlugin_head">
                        <span onclick="adminMenuLeftNavigationPage('articlePlugin')">{$LANG.header_nav_plugin_article}</span>
                    </h3>
                    <div id="articlePlugin" style="display:none">
                    <ul>
                        <li class="{$header->getNavClass('left_pluginconfig_article')}"><a href="{$CFG.site.url}admin/pluginConfig.php?action=article">{$LANG.header_nav_plugin_article}</a> </li>
                    </ul>
                    </div>*}
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

 {/if} {* end of is_module_page == article condition *}