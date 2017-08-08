{*SETTINGS FOR TOTAL TOP CONTRIBUTORS*}
{if $index_block_settings_arr.RandomVideo == 'mainblock'}
	{*TOP CONTRIBUTORS COMES IN SIDE BAR*}
	{assign var=total_top_contributors value=10}
{else}
	{*TOP CONTRIBUTORS COMES IN MAIN BLOCK*}
	{assign var=total_top_contributors value=4}
{/if}

{include file="box.tpl" opt="sidebar_top"}
	<p class="clsSideBarLeftTitle clsTitleTopContributor">{$LANG.index_top_contributors}</p>
<div class="clsSideBarLinks" >
	<div class="clsSideBar clsTopContributorsSideBar">
		<div class="clsSideBarRight">
	<div class="clsSideBarContent">
      {assign var=inc value=0}
       {foreach key=inc from=$contributor item=member}
    	  <div class="{if $inc !=0}clsTopContributors{else}clsTopContributorsNoBg{/if}">
        	<!--<div class="clsTopContributorsThumb"> -->
                <div  class="clsThumbImageLink clsPointer">
                    <a href="{$member.memberProfileUrl}" class="Cls30x30 ClsImageBorder1 ClsImageContainer">
                         <img src="{$member.icon.s_url}" border="0"  title="{$member.name|truncate:5}" alt="{$member.name|truncate:5}" {$myobj->DISP_IMAGE(30, 30, $member.icon.s_width, $member.icon.s_height)} />
                    </a>
            </div>
        </div>
         {assign var=inc value=$inc+1}
          {/foreach}
    </div>
</div>
	</div>
</div>
{$myobj->setTemplateFolder('general/','video')}
{include file="box.tpl" opt="sidebar_bottom"}

