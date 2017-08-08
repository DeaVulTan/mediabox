{if $opt eq 'blog'}
<div class="clsTagsHeading clsOverflow">
			<div class="clsTagsLeftHead">
				<h3>Tag Clouds</h3>
			</div>
			<div class="clsTagsRightTab">

			</div>
		</div>
		{$myobj->setTemplateFolder('general/','blog')}
        {include file="box.tpl" opt="tags_top"}
       <!-- <p class="clsSideBarLeftTitle">
            {$LANG.common_sidebar_blog_clouds_heading_label}
        </p> -->
        <div class="clsSideBarContent">
            {if $populateCloudsBlock.resultFound}
				<div class="clsOverflow">
                <p class="clsPhotoTags">
                    {foreach from=$populateCloudsBlock.item item=tag}
                        <span class="{$tag.class}"><a style="font-size: 13px;" href="{$tag.url}" title="{$tag.name}">{$tag.wordWrap_mb_ManualWithSpace_tag}</a></span>
                    {/foreach}
                 </p>
				 </div>
                <div class="clsOverflow">
                 <div class="clsViewMoreLinks">
	             <p class="clsViewMore"><a href="{$moreclouds_url}">{$LANG.common_sidebar_more_label}</a></p>
                </div>
               </div>
            {else}
               <div><p class="clsNoRecordsFound">{$LANG.common_sidebar_no_blogclouds_found_error_msg}</p></div>
			{/if}
        </div>
	   {$myobj->setTemplateFolder('general/','blog')}
       {include file="box.tpl" opt="tags_bottom"}
{/if}
