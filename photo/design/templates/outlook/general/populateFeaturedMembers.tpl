{$myobj->setTemplateFolder('general/','photo')}
{include file="box.tpl" opt="featuredmember_top"}
<div class="clsOverflow"><h3 class="clsSideBarLeftTitle">{$LANG.sidebar_featured_members_label}</h3></div>
<div class="clsSideBarMargin">
<div class="clsSideBarContent clsTopContributorsSideBar">
    {if $record_count}
	    <table class="clsCarouselList">
        {foreach key=inc from=$contributor item=member}
        	<tr>
            <td >
                <div class="clsOverflow">
                    <div class="clsSidebarFeaturedMemberImage">
                        <div class="clsThumbImageLink">
                            <div class="cls90PXthumbImage clsThumbImageOuter clsPointer">
                                <div class="clsrThumbImageMiddle">
                                    <div class="clsThumbImageInner">
                                    	<a href="{$member.memberProfileUrl}"class="clsThumbImageInner">
                                        <img border="0" src="{$member.icon.t_url}"  title="{$member.name}" {$myobj->DISP_IMAGE(#image_small_width#, #image_small_height#, $member.icon.s_width, $member.icon.s_height)} /> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<!--div><p class="">{$member.city}</p></div-->
                    <div class="clsSidebarFeaturedMember">
                        <p class=""><a href="{$member.memberProfileUrl}" title="{$member.name}">{$member.name}</a></p>
                        <p>{$LANG.index_photo_label}<a href="{$member.user_photolist_url}">{$member.total_photos}</a></p>
						 <p>{$LANG.index_friends}<span>{$member.total_friends}</span></p>

                    </div>
                </div>
        	</td>
          </tr>
        {/foreach}
        </table>
     {else}
     	<div class="clsNoRecordsFound">{$LANG.sidebar_no_topcontributors_found_error_msg}</div>
     {/if}
</div>
</div>
{$myobj->setTemplateFolder('general/','photo')}
{include file="box.tpl" opt="featuredmember_bottom"}