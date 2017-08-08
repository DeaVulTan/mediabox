{$myobj->setTemplateFolder('general/','article')}
{include file="box.tpl" opt="sidebar_top"}
<div class="clsSideBar">
<p class="clsSideBarLeftTitle">{$LANG.sidebar_top_writters_label}</p></div>
<div class="clsOverflow clsTopWriters">
{if $record_count}
    {foreach key=inc from=$contributor item=member}
			<div class="clsArticleThumb">
		    	<a href="{$member.memberProfileUrl}" class="ClsImageContainer ClsImageBorder1 Cls30x30 clsPointer">
		             <img src="{$member.icon.s_url}"  title="{$member.name}" alt="{$member.name|truncate:3}" {$myobj->DISP_IMAGE(30, 30, $member.icon.s_width, $member.icon.s_height)} />
		        </a>
		    </div>
            {*
		    <div class="clsTopArticleDetails">
		    	<h4><a href="{$member.memberProfileUrl}" title="{$member.name}">{$member.name}</a></h4>
		        <p>{$LANG.sidebar_posted_article_label} - <span><a href="{$member.user_articlelist_url}">{$member.total_stats}</a></span></p>
		    </div>
            *}
	{/foreach}
{else}
	<div class="clsNoRecordsFound">{$LANG.sidebar_no_topwritters_found_error_msg}</div>
{/if}
</div>
{$myobj->setTemplateFolder('general/','article')}
{include file="box.tpl" opt="sidebar_bottom"}