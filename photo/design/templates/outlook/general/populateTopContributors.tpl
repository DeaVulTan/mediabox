<div class="clsTopContributorsNoPadding">
{$myobj->setTemplateFolder('general/','photo')}
{include file="box.tpl" opt="sidebar_top"}
 <div class="clsOverflow"><h3 class="clsSideBarLeftTitle clsPaddingLeft5">{$LANG.sidebar_top_contributos_label}</h3></div>
<div class="clsSideBarContent clsTopContributorsSideBar">
    {if $record_count}
	    <table class="clsTopContributorsMain">
        {assign var=break_count value=1}
		{if $CFG.site.script_name == 'index.php'}
			{assign var=num_of_rec value=$CFG.admin.photos.sidebar_top_contributors_num_record}
		{else}
			{assign var=num_of_rec value=$CFG.admin.photos.sidebar_memberlist_top_contributors_num_record}
		{/if}
        {foreach key=inc from=$contributor item=member}
        {if $break_count == 1}
        	<tr>
        {/if}
             <td  {if $break_count == $num_of_rec} class="clsFinalData" {/if}>
        <div class="clsTopContributors">
            <div class="clsTopContributorsThumb">
                    <a href="{$member.memberProfileUrl}" class="Cls30x30 ClsImageBorder1 clsImageHolder clsPointer">
                                <img src="{$member.icon.s_url}"  title="{$member.name}" alt="{$member.name|truncate:5}" {$myobj->DISP_IMAGE(30, 30, $member.icon.s_width, $member.icon.s_height)} />
                    </a>
            </div>
            <!--<div class="clsTopContributorsThumbDetails">
                <p class="clsTopContributorsThumbDetailsTitle"><a href="{$member.memberProfileUrl}" title="{$member.name}">{$member.name}</a></p>
                <p>{$LANG.sidebar_posted_photo_label}<span><a href="{$member.user_photolist_url}">{$member.total_stats}</a></span></p>
            </div>-->
        </div>
        </td>
        {assign var=break_count value=$break_count+1}
        {if $break_count > $num_of_rec}
          </tr>
           {assign var=break_count value=1}
        {/if}
        {/foreach}
        </table>
     {else}
     	<div class="clsNoRecordsFound">{$LANG.sidebar_no_topcontributors_found_error_msg}</div>
     {/if}
</div>
{$myobj->setTemplateFolder('general/','photo')}
 {include file="box.tpl" opt="sidebar_bottom"}
</div>