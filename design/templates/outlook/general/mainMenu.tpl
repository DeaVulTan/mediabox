<div class="clsMainNavigation">
    <h3>{$myobj->LANG.header_top_menu_sub_navigation_links}</h3>
    <div id="selNav">
        <ul class="clsMenu">
            {section loop=$menu.main start=0 step=1 name=sec max=$mainMenuMax}
                {if $menu.main[sec].target_type =='popup'}
                    <li class="{$menu.main[sec].clsActive} {$menu.main[sec].class_name} clsMenuLiLink" id="{$menu.main[sec].id}"><a class="{$menu.main[sec].class_name} clsMenuALink" href="javascript:void(0)" onclick="openPopupWindow('{$menu.main[sec].url}')"><span class="clsMenuSpanLink">{$menu.main[sec].name}</span></a></li>
                {else}
                    <li class="{$menu.main[sec].clsActive} {$menu.main[sec].class_name} clsMenuLiLink" id="{$menu.main[sec].id}"><a class="{$menu.main[sec].class_name} clsMenuALink" href="{$menu.main[sec].url}" target="{$menu.main[sec].target_type}"><span class="clsMenuSpanLink">{$menu.main[sec].name}</span></a></li>
                {/if}
            {/section}
            
            {if $menu_channel and !$display_channel_in_row}
                <li id="channel_menu_anchor" class="selDropDownLink clsMainSubMenu">
                    <a class="clsMoreMenus"><span>{$LANG.common_channel}</span></a>
                    {if $menu_channel and !$display_channel_in_row}
                        <ul class="clsMoreMainMenu">
                            {section loop=$menu_channel start=0 step=1 max=$channelMenuMax name=channel_menu}
                                <li onmouseover="allowChannelHide=false" onmouseout="allowChannelHide=true"><a href="{$menu_channel[channel_menu].url}" >{$menu_channel[channel_menu].name}</a></li>
                            {/section}
                            {if $channelMore}
                                <li onmouseover="allowChannelHide=false" onmouseout="allowChannelHide=true"><a href="{$channel_more_link}" >{$LANG.common_more}</a></li>
                            {/if}
                        </ul>
                    {/if}   
                </li>
            {/if}
            {if $mainmenu_more}
                <li id="menu_more_anchor" class="selDropDownLink clsMainSubMenu">
                   <p class="">{$LANG.common_more}</p>
                    {if $mainmenu_more}
					   <ul class="clsMainSubMenuContainer" dropdownhide="musicselect,videoselect,articleselect,browse,photoselect,blogselect,comment_status,articlelistselect,musicplaylistselect,commentStatusForm">
                       <div>
                        {section loop=$menu.main start=$mainMenuMax step=1 name=sec}
                            {if $menu.main[sec].target_type =='popup'}
                                <li onmouseover="allowMenuMoreHide=false" onmouseout="allowMenuMoreHide=true"><a href="javascript:void(0)" onclick="openPopupWindow('{$menu.main[sec].url}')">{$menu.main[sec].name}</a></li>
                            {else}
                                <li onmouseover="allowMenuMoreHide=false" onmouseout="allowMenuMoreHide=true"><a href="{$menu.main[sec].url}" target="{$menu.main[sec].target_type}">{$menu.main[sec].name}</a></li>
                            {/if}
                        {/section}
                        </div>
                        </ul>
                    {/if}
                </li>
             {/if}
             
        </ul>
    </div>
</div>
{literal}
<script type="text/javascript">
$Jq(document).ready(function(){
	var menuLi=$Jq('.clsMenu li');
	menuLi.each(function (li)
	{
		$Jq(this).bind('mouseover', function()
		{
			$Jq(this).addClass('clsHoverMenu');
		});
		$Jq(this).bind('mouseout', function()
		{
			$Jq(this).removeClass('clsHoverMenu');
		});
	});
	{/literal}
	{section loop=$menu.main start=0 step=1 name=sec max=$mainMenuMax}
	{literal}
		$Jq({/literal}'#{$menu.main[sec].id}'{literal}).mouseover(function()
			{
			{/literal}
			{if $mainmenu_more}
				{literal}
				allowMenuMoreHide=true;
				hideMenuMore();
				{/literal}
			{/if}
			{if $menu_channel}
				{literal}
				allowChannelHide=true;
				hideChannel();
				{/literal}
			{/if}
			{literal}
			}
		);{/literal}
	{/section}
{literal}
});
function openPopupWindow(url){
	window.open (url, "","status=0,toolbar=0,resizable=1,scrollbars=1");
}
</script>
{/literal}