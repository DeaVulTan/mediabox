{foreach item=generalValue from=$generalActivity_arr}
    {if $key == $generalValue.parent_id}
        {if $generalValue.action_key == 'be_friended'}
            <div>
                <div class="clsWhatsGoingUserDetails">
                    <div class="clsWhatsGoingBg clsOverflow">
                        <div class="clsFloatLeft">
                            <a href="{$generalValue.be_friended.user2.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                                <img border="0" src="{$generalValue.be_friended.user2.icon.s_url}" border="0" alt="{$generalValue.be_friended.user2.name|truncate:5}" title="{$generalValue.be_friended.user2.name}"   {$myobj->DISP_IMAGE(45, 45, $generalValue.be_friended.user1.icon.s_width, $generalValue.be_friended.user1.icon.s_height)}  />
                            </a>
                        </div>
                        <div class="clsUserDetailsFriends">
                            <div class="clsOverflow clsWhatsGoingUser">
                                <div class="clsFloatLeft">
                                   <a href="{$generalValue.be_friended.user2.url}">{$generalValue.be_friended.user2.name}</a> 
                                </div>	
                                <div class="clsFloatRight">
                                    <span></span>
                                </div>	
                            </div>
                            <div class="clsUserActivityWhtsgoing">
                                <img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-newlyjoined.gif" alt="" border="0" />
                                {$generalValue.be_friended.hasfriend} <a href="{$generalValue.be_friended.user1.url}">{$generalValue.be_friended.user1.name}</a>  
                              
                            </div>	
                        </div>	
                    </div>	
                </div>   
             </div>
        {elseif $generalValue.action_key == 'new_member'}
            <div>
            
                <div class="clsWhatsGoingUserDetails">
                    <div class="clsWhatsGoingBg clsOverflow">
                        <div class="clsFloatLeft">
                            <a href="{$generalValue.new_member.user_url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                                <img src="{$generalValue.new_member.icon.s_url}" alt="{$generalValue.new_member.name|truncate:5}" border="0" title="{$generalValue.new_member.name}" {$myobj->DISP_IMAGE(45, 45, $generalValue.new_member.icon.s_width, $generalValue.new_member.icon.s_height)}  />
                            </a>
                        </div>
                        <div class="clsUserDetailsFriends">
                            <div class="clsOverflow clsWhatsGoingUser">
                                <div class="clsFloatLeft">
                                    <a href="{$generalValue.new_member.user_url}">{$generalValue.new_member.name|ucwords}</a> 
                                </div>	
                                <div class="clsFloatRight">
                                    <span>{$generalValue.new_member.date_added}</span>
                                </div>	
                            </div>
                            <div class="clsUserActivityWhtsgoing">
                                <img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-newlyjoined.gif" alt="" border="0" />
                                {$generalValue.new_member.lang}
                                
                            </div>	
                        </div>	
                    </div>	
                </div>    
           </div>        
        {elseif $generalValue.action_key == 'new_member_by_admin'}
            <div>

                    <div class="clsWhatsGoingUserDetails">
                        <div class="clsWhatsGoingBg clsOverflow">
                            <div class="clsFloatLeft">
                                <a href="{$generalValue.new_member_by_admin.user_url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                                    <img border="0" src="{$generalValue.new_member_by_admin.user_icon.s_url}" alt="{$generalValue.new_member_by_admin.user_name|truncate:5}" title="{$generalValue.new_member_by_admin.user_name}"  {$myobj->DISP_IMAGE(45, 45, $generalValue.new_member_by_admin.user_icon.s_width, $generalValue.new_member_by_admin.user_icon.s_height)} border="0" />
                                </a>
                            </div>
                            <div class="clsUserDetailsFriends">
                                <div class="clsOverflow clsWhatsGoingUser">
                                    <div class="clsFloatLeft">
                                        <a href="{$generalValue.new_member_by_admin.user_url}">{$generalValue.new_member_by_admin.user_name|ucwords}</a> 
                                    </div>	
                                    <div class="clsFloatRight">
                                        <span>{$generalValue.new_member_by_admin.date_added}</span>
                                    </div>	
                                </div>
                                <div class="clsUserActivityWhtsgoing">
                                    <img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-newlyjoined.gif" alt="" border="0" />
                                    {$generalValue.new_member_by_admin.lang3}
                                    
                                </div>	
                            </div>	
                        </div>	
                    </div>    
           </div>                  
        {elseif $generalValue.action_key == 'new_scrap'}
            <div>

                 	<div class="clsWhatsGoingUserDetails">
                        <div class="clsWhatsGoingBg clsOverflow">
                            <div class="clsFloatLeft">
                                <a href="{$generalValue.new_scrap.user_url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                                    <img border="0" src="{$generalValue.new_scrap.icon.s_url}" alt="{$generalValue.new_scrap.name|truncate:5}" title="{$generalValue.new_scrap.name}" {$myobj->DISP_IMAGE(45, 45, $generalValue.new_scrap.icon.s_width, $generalValue.new_scrap.icon.s_height)} border="0" />
                                </a>
                            </div>
                            <div class="clsUserDetailsFriends">
                                <div class="clsOverflow clsWhatsGoingUser">
                                    <div class="clsFloatLeft">
                                        <a href="{$generalValue.new_scrap.user_url}">{$generalValue.new_scrap.name|ucwords}</a> 
                                    </div>	
                                    <div class="clsFloatRight">
                                        <span></span>
                                    </div>	
                                </div>
                                <div class="clsUserActivityWhtsgoing">
                                    <img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-recivescrap.gif" alt="" border="0" />
                                     {$generalValue.new_scrap.lang}
                                   
                                </div>	
                            </div>	
                        </div>	
                    </div> 
             </div> 
        {elseif $generalValue.action_key == 'subscribed'}
            <div>
            
                 	<div class="clsWhatsGoingUserDetails">
                        <div class="clsWhatsGoingBg clsOverflow">
                            <div class="clsFloatLeft">
                                <a href="{$generalValue.subscribed.user1.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                                    <img src="{$generalValue.subscribed.user1.icon.s_url}" alt="{$generalValue.subscribed.user1.name|truncate:5}" title="{$generalValue.subscribed.user1.name}" {$myobj->DISP_IMAGE(45, 45, $generalValue.subscribed.user1.icon.s_width, $generalValue.subscribed.user1.icon.s_height)} border="0" />
                                </a>
                            </div>
                            <div class="clsUserDetailsFriends">
                                <div class="clsOverflow clsWhatsGoingUser">
                                    <div class="clsFloatLeft"><a href="{$generalValue.subscribed.user1.url}">{$generalValue.subscribed.user1.name|ucwords}</a> 
                                    </div>	
                                    <div class="clsFloatRight">
                                        <span></span>
                                    </div>	
                                </div>
                                <div class="clsUserActivityWhtsgoing">
                                    <img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-newlyjoined.gif" alt="" border="0" />
                                     {$generalValue.subscribed.lang} <a href="{$generalValue.subscribed.user2.url}">{$generalValue.subscribed.user2.name|ucwords}</a>
                                  
                                </div>	
                            </div>	
                        </div>	
                    </div>
            </div>
        {/if}
	{/if}
{/foreach}