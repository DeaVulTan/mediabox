{include file="box.tpl" opt="sidebar_top"}
<div class="clsSideBarLinks" id="selFeaturedMembers">
	<div class="clsSideBar">
    	<div>
			<p class="clsSideBarLeftTitle">{$LANG.header_nav_featured_title}</p>
		</div>
		<div class="clsSideBarRight">
			<div class="clsFeaturedMemberLeft">
                   	<a href="{$featuredMember.profileUrl}" class="ClsImageContainer ClsImageBorder2 Cls90x90">
                       	<img src="{$featuredMember.icon.t_url}" alt="{$featuredMember.name|truncate:9}" title="{$featuredMember.name}" {$myobj->DISP_IMAGE(#image_thumb_width#, #image_thumb_height#, $featuredMember.icon.t_width, $featuredMember.icon.t_height)} />
                    </a>
				</div>
                <div class="clsFeaturedMemberRight">
                    	<div class="clsFeaturedMembersLinks"><a href="{$featuredMember.profileUrl}">{$featuredMember.name}</a> 
							<span>{$featuredMember.age} / {$featuredMember.sex}</span></div>
                		<div class="clsMembersLinks">
                          {assign var=break_count value=0}
                          <ul class="clsFloatLeft"> 
							<li class="clsMembersFriend">
                            {assign var=break_count value=$break_count+1}
								<span>{$LANG.header_nav_featured_total_friends}:</span><a href="{$featuredMember.viewFriendsUrl}"> {$featuredMember.total_friends}</a>
							</li>
            
                            {assign var=totcnt value= $CFG.site.modules_arr|@count}
                            {assign var=totcnt value=$totcnt-1}
                                {foreach from= $CFG.site.modules_arr key=inc item=module_value}
                                      {if chkAllowedModule(array($module_value))}
                                          {assign var=break_count value=$break_count+1}
                                            {assign var='total_stats_value' value='total_'|cat:$module_value|cat:'s'}
                                            <li class="clsMembers{$module_value}">{$featuredMember.$total_stats_value}</li>
                                          {if ($break_count > 3 && $totcnt neq $inc)}
                                                </ul>
                                                <ul class="clsFloatRight">
                                                {assign var=break_count value=0}
                                          {/if}
                                              
                                        {/if}
                                {/foreach}
                                </ul>
                        </div>
                </div>
           </div>
    </div>
</div>
{include file="box.tpl" opt="sidebar_bottom"}