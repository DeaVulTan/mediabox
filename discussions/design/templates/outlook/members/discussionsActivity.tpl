{foreach item=discussionValue from=$discussionsActivity_arr}
    {if $key == $discussionValue.parent_id}
              <div class="clsWhatsGoingUserDetails">
                    <div class="clsWhatsGoingBg clsOverflow">
                        <div class="clsFloatLeft">
                            <a href="{$discussionValue.user_details_arr.user_link}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                                <img src="{$discussionValue.user_details_arr.user_photo.imgsrc.s_url}" alt="{$discussionValue.user_details_arr.name}" title="{$discussionValue.user_details_arr.name}" {$myobj->DISP_IMAGE(45, 45, $discussionValue.user_details_arr.user_photo.imgsrc.s_width, $discussionValue.user_details_arr.user_photo.imgsrc.s_height)} border="0" onclick="Redirect2URL('{$discussionValue.user_details_arr.user_link}')"/>
                            </a>
                        </div>
                        <div class="clsUserDetailsFriends">
                            <div class="clsOverflow clsWhatsGoingUser">
                                <div class="clsFloatLeft">
                                    <a href="{$discussionValue.user_details_arr.user_link}">{$discussionValue.user_details_arr.name|ucwords}</a> 
                                </div>	
                                <div class="clsFloatRight">
                                    <span>{$discussionValue.activity_added}</span>
                                </div>	
                            </div>
                            <div class="clsUserActivityWhtsgoing">
                                <img src="{$CFG.site.url}discussions/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/{$discussionValue.iconImageName}" alt="" border="0" />
                                {$discussionValue.content}
                            </div>	
                        </div>	
                    </div>	
                </div>        
   {/if}
{/foreach}