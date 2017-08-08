<div id="selVideoCategory">
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}

    <div class="clsOverflow">
    {*VIDEO LIST TITLE STARTS*}
        <div class="clsVideoListHeading">
            <h2><span>{$myobj->LANG.videocategory_page_title}</span></h2>
        </div>
        <div class="clsVideoListHeadingRight">
              <div class="clsMyCategroySubscription">
                   {if isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule()}
                    {if $myobj->getFormField('pg') == ''}
                        <a href="{$myobj->my_subscription_url}">{$LANG.common_category_my_subscriptions}</a>
                      {else}
                        <a href="{$myobj->getUrl('videocategory', '', '', 'members', 'video')}">{$LANG.common_category_showall}</a>
                      {/if}
                   {/if}
               </div>
        </div>
    </div>
     <div class="clsBackToCategory">
            {if $myobj->getFormField('category_id') != ''}
            <a href="{$myobj->getUrl('videocategory', '', '', 'members', 'video')}">{$LANG.videocategory_back_to_category}</a>
           {/if}
     </div>
    <div id="topLinks">
    {if $CFG.admin.navigation.top}
        {$myobj->setTemplateFolder('general/')}
        {include file=pagination.tpl}
    {/if}
    </div>
    <div class="clsLeftNavigation" id="selLeftNavigation">
	{if $myobj->isShowPageBlock('form_show_category')}
		<div id="selShowAllShoutouts" class="clsDataTable clsCategoryTable">
			<div id="">
	              <table summary="{$LANG.videocategory_tbl_summary}" id="selCategoryTable">
                    {if $myobj->isResultsFound()}
                        {assign var=inc value=0}
                        {foreach from=$myobj->form_show_category item=result key=count name=categorylist}
                              {if $result.open_tr}
                                    <tr>
                              {/if}

                              <td id="selVideoGallery" class="clsVideoCategoryCell clsChannelList">
                                   <div class="clsChannelListCont">
                                    <div id="selPhotCategoryImageDisp" class="clsOverflow">
                                          <div id="selImageBorder">
                                                <div class="clsThumbImageLink ">
                                                    <a href="{$result.video_link}" class="ClsImageContainer ClsImageBorder Cls107x80 clsPointer">
                                                      <img src="{$result.category_image}" border="0" alt="{$result.record.video_category_name}" title="{$result.record.video_category_name}" />
                                                     </a> 
                                                </div>
                                          </div>
                                    </div>
                                    <div id="selImageDet" class="clsChannelNameHd">
                                          <h3>
                                                <a href="{$result.video_link}" title="{$result.record.video_category_name}">
                                                      {$result.record.video_category_name}
                                                </a>
                                          </h3>
                                          <p>
                                                {$LANG.search_option_today}:
                                                <span class="clsChannelCount">{$result.today_category_count}</span>
                                                &nbsp;|&nbsp;
                                                {$LANG.videocategory_total}
                                                <span class="clsChannelCount">{$result.record.video_category_count}</span>
                                          </p>

                                    </div>

                                         <div class="clsSubCategory">
                                            <ul>{if $CFG.admin.videos.sub_category}
												   {if $myobj->getFormField('category_id') == ''}
														<li>
															<span class="clsSubCategoryIcon">{if $result.sub_category_count > 0}
															  <a href="{$result.sub_category_url}" title="{$LANG.videocategory_video_subcategory}">Sub categories</a>{/if}
															</span>

														</li>
													{/if}
												{/if}
												<li> {if $result.content_filter}
                                                <p class="clsCategoryType"> |  </li>{$result.record.video_category_type}</p>
                                      {/if}</li>
                                        	</ul>
                                        </div>


                                              {*SUBSCRIPTION LINK STARTS HERE*}
                                        <div class="clsSubscribeList">
                                        	<ul>
                                                 {if chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule()}
                                                    {if isMember()}
                                                          {if !$myobj->chkIsUserSubscribedToCategory($result.record.video_category_id, $CFG.site.is_module_page)}
                                                               <li id="subscribe_{$result.record.video_category_id}">
                                                                   <span><a href="javascript:void(0);" id="anchor_subscribe" onclick="subscription_sep_action({$result.record.video_category_id}, 'Yes', '{$CFG.site.is_module_page}', 'Category');" class="clsSubscribeIcon">{$LANG.common_subscribe}</a></span>
                                                                   &nbsp;
                                                                   ({$myobj->getCategorySubscriptionCount($result.record.video_category_id, $CFG.site.is_module_page)})
                                                               </li>
                                                                <li id="unsubscribe_{$result.record.video_category_id}" style="display:none">
                                                                    <span><a href="javascript:void(0);" id="anchor_subscribe" onclick="subscription_sep_action({$result.record.video_category_id}, 'No', '{$CFG.site.is_module_page}', 'Category');" class="clsUnSubscribeIcon">{$LANG.common_unsubscribe}</a></span>
                                                                     &nbsp;
                                                                   ({$myobj->getCategorySubscriptionCount($result.record.video_category_id, $CFG.site.is_module_page)})
                                                                </li>
                                                          {else}
                                                                <li id="unsubscribe_{$result.record.video_category_id}">
                                                                    <span><a href="javascript:void(0);" id="anchor_subscribe" onclick="subscription_sep_action({$result.record.video_category_id}, 'No', '{$CFG.site.is_module_page}', 'Category');" class="clsUnSubscribeIcon">{$LANG.common_unsubscribe}</a></span>
                                                                     &nbsp;
                                                                   ({$myobj->getCategorySubscriptionCount($result.record.video_category_id, $CFG.site.is_module_page)})
                                                               </li>
                                                                <li id="subscribe_{$result.record.video_category_id}" style="display:none">
                                                                    <span><a href="javascript:void(0);" id="anchor_subscribe" onclick="subscription_sep_action({$result.record.video_category_id}, 'Yes', '{$CFG.site.is_module_page}', 'Category');" class="clsSubscribeIcon">{$LANG.common_subscribe}</a></span>
                                                                     &nbsp;
                                                                   ({$myobj->getCategorySubscriptionCount($result.record.video_category_id, $CFG.site.is_module_page)})
                                                                </li>
                                                          {/if}
                                                    {else}
                                                      <li>
                                                          <span><a href="{$myobj->getUrl('videocategory', '', '', 'members', 'video')}" class="clsSubscribeIcon">{$LANG.common_subscriptions}</a></span>
                                                           &nbsp;
                                                           ({$myobj->getCategorySubscriptionCount($result.record.video_category_id, $CFG.site.is_module_page)})
                                                      </li>
                                                    {/if}

                                                 {/if}
                                              {*SUBSCRIPTION LINK ENDS HERE*}
                                            </ul>
                                        </div>
                                   </p>
                                   </div>
                              </td>
                        {if $result.end_tr}
                              </tr>
                        {/if}
                        {/foreach}
                        {if $myobj->category_list.extra_td_tr}
                              {section name=foo start=0 loop=$myobj->category_list.records_per_row step=1}
                                    <td>&nbsp;</td>
                              {/section}
                        {/if}
                     {else}
                      <tr>
                        <td>
                        	{if isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule() and $myobj->getFormField('pg') != ''}
                                    {$LANG.videocategory_no_subscriptions}
                              {else}
					   	{if $myobj->getFormField('category_id') != ''}
                              		{$LANG.videocategory_no_category}
                                    {else}
                                    	{$LANG.videocategory_no_sub_category}
                                    {/if}
                              {/if}
                        </td>
                       </tr>
                     {/if}
                  </table>
                   </div>
                <div id="bottomLinks">
                {if $CFG.admin.navigation.bottom}
                    {include file='pagination.tpl'}
                {/if}
                </div>
		</div>
    {/if}
	</div>

{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}
</div>
