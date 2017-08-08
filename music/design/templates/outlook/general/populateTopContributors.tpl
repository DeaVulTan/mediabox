<div class="clsSideBarMargin">
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="sidebar_top"}
<div class="clsAudioIndex clsTopContributorsSideBar">
	<div><p class="clsSideBarLeftTitle">{$LANG.sidebar_top_contributos_label}</p></div>
    {if $record_count}
    <div class="clsOverflow">
    	{foreach key=inc from=$contributor item=member}    
    	<div class="clsTopContributors {$member.noBoderStyle}">
            <div class="clsTopContributorsThumb clsWidth55">
                <div class="clsThumbImageLink">
                    <a href="{$member.memberProfileUrl}" class="ClsImageContainer ClsImageBorder1 Cls32x32">
                    	<img border="0" src="{$member.profileIcon.s_url}" alt="{$member.name}" title="{$member.name}" {$myobj->DISP_IMAGE(30,30, $member.profileIcon.s_width, $member.profileIcon.s_height)}   />
                    </a>
                </div>
            </div>
        </div>     
		{/foreach}
     </div>     
     {else}
     <div class="clsNoRecordsFound">{$LANG.sidebar_no_topcontributors_found_error_msg}</div>
     {/if}
</div>
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="sidebar_bottom"}
</div>