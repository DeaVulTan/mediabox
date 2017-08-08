{include file="box.tpl" opt="sidebar_top"}
<div class="clsSideBarLinks" >
	<div class="clsSideBar clsTopContributorsSideBar">
        <div>
            <p class="clsSideBarLeftTitle">{$LANG.index_top_contributors}</p>
        </div>
		<div class="clsSideBarRight">
	<div class="clsSideBarContent">
	{foreach key=inc from=$contributor item=member}    
    	<div class="{if $inc !=0}clsTopContributors{else}clsTopContributorsNoBg{/if}">
        	<div class="clsTopContributorsThumb">
                <div onclick="Redirect2URL('{$member.memberProfileUrl}')"  class="clsThumbImageLink">
                	<div class="ClsImageContainer ClsImageBorder2 Cls32x32">
            			<img {$member.icon.s_attribute} src="{$member.icon.s_url}" onclick="Redirect2URL('{$member.memberProfileUrl}')" {$myobj->DISP_IMAGE(30, 30, $member.icon.s_width, $member.icon.s_height)} />
	                </div>
               </div>
            </div>
            <div class="clsTopContributorsThumbDetails">
            <p class="clsTopContributorsThumbDetailsTitle">
                <a href="{$member.memberProfileUrl}">{$member.name}</a>
            </p>
            <p>{$lang_total_contributors}{$member.total_stats}</p>
            </div>
        </div>
    {/foreach}
    </div>
</div>
	</div>
</div>
{include file="box.tpl" opt="sidebar_bottom"}