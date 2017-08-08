<div class="clsLeftNavigation" id="selLeftNavigation">
  <div id="selShowAllShoutouts" class="clsDataTable clsCategoryTable"> {if $categories_list_subscription_arr|@count > 0}
    <div>
      <table id="selCategoryTable">
        {assign var=inc value=0}
        {foreach from=$categories_list_subscription_arr item=result key=count name=categorylist}
        {if $result.open_tr}
        <tr> {/if}
          <td id="selPhotoGallery" class="clsPhotoCategoryCell clsChannelList"><div class="clsChannelListCont">
              <div id="selPhotCategoryImageDisp" class="clsOverflow">
                <div id="selImageBorder">
                  <div class="clsThumbImageLink ">
                    <div class="cls106x79 clsImageHolder clsImageBorderBgSidebar clsPointer">
						<img src="{$result.category_image}" alt="{$result.category_name}" /> </div>
                  </div>
                </div>
              </div>
              <div id="selImageDet" class="clsChannelNameHd">
                <h3> <a href="{$result.photo_link}"> {$result.category_name} </a> </h3>
              </div>
              {*SUBSCRIPTION LINK STARTS HERE*}
              <ul class="clsSubscribeList">
                {if !$myobj->chkIsUserSubscribedToCategory($result.photo_category_id, 'photo')}
                <li> <span id="subscribe_{$result.photo_category_id}"><a href="javascript:void(0);" id="anchor_subscribe" onclick="subscription_sep_action({$result.photo_category_id}, 'Yes', 'photo', 'Category');" class="clsSubscribeIcon clsPhotoVideoEditLinks" title="{$LANG.common_subscribe}">{$LANG.common_subscribe}</a></span></li>
                <li> <span id="unsubscribe_{$result.photo_category_id}" style="display:none"><a href="javascript:void(0);" id="anchor_subscribe" onclick="subscription_sep_action({$result.photo_category_id}, 'No', 'photo', 'Category');" class="clsUnSubscribeIcon clsPhotoVideoEditLinks" title="{$LANG.common_unsubscribe}">{$LANG.common_unsubscribe}</a></span></li>
                {else}
                <li><span id="unsubscribe_{$result.photo_category_id}"><a href="javascript:void(0);" id="anchor_subscribe" onclick="subscription_sep_action({$result.photo_category_id}, 'No', 'photo', 'Category');" class="clsUnSubscribeIcon clsPhotoVideoEditLinks" title="{$LANG.common_unsubscribe}">{$LANG.common_unsubscribe}</a></span></li>
                <li><span id="subscribe_{$result.photo_category_id}" style="display:none"><a href="javascript:void(0);" id="anchor_subscribe" onclick="subscription_sep_action({$result.photo_category_id}, 'Yes', 'photo', 'Category');" class="clsSubscribeIcon clsPhotoVideoEditLinks" title="{$LANG.common_subscribe}">{$LANG.common_subscribe}</a></span></li>
                {/if}
              </ul>
					   <p class="clsPhotoCategoryDesc">{$LANG.common_totalsubscriptions}: <span id="total_sub_{$result.photo_category_id}">{$myobj->getCategorySubscriptionCount($result.photo_category_id, 'photo')}</span></p>
              {*SUBSCRIPTION LINK ENDS HERE*} </div></td>
          {if $result.end_tr} </tr>
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
    <div id="selMsgAlert">
      <p>{$LANG.common_no_subscribed_categories_found}</p>
    </div>
    {/if} </div>
</div>
