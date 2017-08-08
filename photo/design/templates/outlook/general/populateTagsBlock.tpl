<div class="clsSideBarMargin">
	{$myobj->setTemplateFolder('general/','photo')}
    {include file="box.tpl" opt="sidebar_top"}
        <div class="clsSideBarContent clsTopContributorsSideBar">
            <div><p class="clsSideBarLeftTitle">{$LANG.sidebar_photo_tags_heading_label}</p></div>
            {if $populateTagsBlock.resultFound}
                <p class="clsAudioTags">
                    {foreach from=$populateTagsBlock.item item=tag}
                        <span class="{$tag.class}"><a style="font-size: 13px;" href="{$tag.url}" title="{$tag.name}">{$tag.wordWrap_mb_ManualWithSpace_tag}</a></span>
                    {/foreach}
                 </p>
                <!--p class="clsViewMore"><a href="{$moretags_url}">{$LANG.sidebar_more_label}</a></p-->
            {else}           
               <div><p class="clsNoRecordsFound">{$LANG.sidebar_no_phototags_found_error_msg}</p></div>
            {/if}
        </div>
	{$myobj->setTemplateFolder('general/','photo')}
    {include file="box.tpl" opt="sidebar_bottom"}
</div>