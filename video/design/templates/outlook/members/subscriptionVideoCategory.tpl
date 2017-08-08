<div class="clsLeftNavigation" id="selLeftNavigation">
      <div id="selShowAllShoutouts" class="clsDataTable clsCategoryTable">
   	 {if $categories_list_subscription_arr|@count > 0}
            <div>            
              <table id="selCategoryTable">
                  {assign var=inc value=0}
                  {foreach from=$categories_list_subscription_arr item=result key=count name=categorylist}
                        {if $result.open_tr}
                              <tr>
                        {/if}
      
                        <td id="selVideoGallery" class="clsVideoCategoryCell clsChannelList">
                             <div class="clsChannelListCont">
                              <div id="selPhotCategoryImageDisp" class="clsOverflow">
                                    <div id="selImageBorder">
                                          <div class="clsThumbImageLink ">
                                              <div class="ClsImageContainer ClsImageBorder Cls107x80 clsPointer">
                                                      <img src="{$result.category_image}" alt="{$result.category_name}" />
                                              </div>
                                          </div>
                                    </div>
                              </div>
                              <div id="selImageDet" class="clsChannelNameHd">
                                    <h3>
                                          <a href="{$result.video_link}">
                                                {$result.category_name}
                                          </a>
                                    </h3>
                              </div>
                              
                                    {*SUBSCRIPTION LINK STARTS HERE*}
                                                <ul class="clsSubscribeList">
{if !$myobj->chkIsUserSubscribedToCategory($result.video_category_id, 'video')}
                                                     <li> <span id="subscribe_{$result.video_category_id}"><a href="javascript:void(0);" id="anchor_subscribe" onclick="subscription_sep_action({$result.video_category_id}, 'Yes', 'video', 'Category');" class="clsSubscribeIcon">{$LANG.common_subscribe}</a></span></li>
                                                     <li> <span id="unsubscribe_{$result.video_category_id}" style="display:none"><a href="javascript:void(0);" id="anchor_subscribe" onclick="subscription_sep_action({$result.video_category_id}, 'No', 'video', 'Category');" class="clsUnSubscribeIcon">{$LANG.common_unsubscribe}</a></span></li>                                              
                                                {else}
                                                      <li><span id="unsubscribe_{$result.video_category_id}"><a href="javascript:void(0);" id="anchor_subscribe" onclick="subscription_sep_action({$result.video_category_id}, 'No', 'video', 'Category');" class="clsUnSubscribeIcon">{$LANG.common_unsubscribe}</a></span></li>
                                                     <li> <span id="subscribe_{$result.video_category_id}" style="display:none"><a href="javascript:void(0);" id="anchor_subscribe" onclick="subscription_sep_action({$result.video_category_id}, 'Yes', 'video', 'Category');" class="clsSubscribeIcon">{$LANG.common_subscribe}</a></span></li>

                                          &nbsp;&nbsp;&nbsp;({$myobj->getCategorySubscriptionCount($result.video_category_id, 'video')})
                                       {/if}
</ul>
                                    {*SUBSCRIPTION LINK ENDS HERE*}                                
      
                             </p>
                             </div>						
                        </td>                                                         
                  {if $result.end_tr}
                        </tr>
                  {/if}
                  {/foreach}                  
                  {if $subscription_category_list.extra_td_tr}
                        {section name=foo start=0 loop=$subscription_category_list.records_per_row step=1}
                              <td>&nbsp;</td>
                        {/section}
                  {/if}
            </table>
             </div>
       {else}
	      <div id="selMsgAlert"><p>{$LANG.common_no_subscribed_categories_found}</p></div>        
       {/if}
      </div>
</div>