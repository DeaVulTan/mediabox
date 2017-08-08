<div id="selphotoCategory" class="clsOverflow">
{$myobj->setTemplateFolder('general/','photo')}
{include file='box.tpl' opt='photomain_top'}

    <div class="clsOverflow">
    {*photo LIST TITLE STARTS*}
        <div class="clsHeadingLeft">
            <h2><span>{$LANG.photocategory_page_title}</span></h2>
        </div>
		<div class="clsPhotoListHeadingRight clsMyCategroySubscription">
		   {if isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule()}
					<a href="{$myobj->getUrl('mysubscription', '?pg=category_subscription', 'category_subscription/', '')}" title="{$LANG.common_tag_my_subscriptions}">{$LANG.common_tag_my_subscriptions}</a>
		   {/if}
	   </div>
    </div>
    <div class="clsBackToCategory"> 
            {if $myobj->getFormField('category_id') != ''}
            <a href="{$myobj->getUrl('photocategory', '', '', 'members', 'photo')}">{$LANG.photocategory_back_to_category}</a>
           {/if}
     </div>
    <div id="topLinks">
      <div class="clsAudioPaging">
       {if $CFG.admin.navigation.top}
       {$myobj->setTemplateFolder('general/', 'photo')}
        {include file=pagination.tpl}
       {/if}
      </div>
    </div>
    <div class="clsLeftNavigation" id="selLeftNavigation">
	{if $myobj->isShowPageBlock('form_show_category')}
       <div class="clsOverflow">
     	  <div id="selShowAllShoutouts" class="clsDataTable clsCategoryNoPadding clsCategoryTable">
             <div summary="{$LANG.photocategory_tbl_summary}" id="selCategoryTable" class="cls5TdTable">
	        {if !$myobj->isResultsFound()}
    	    <div><p>{$LANG.photocategory_no_category}</p></div>
			{else}
            {assign var=countt value=1}
            {assign var=inc value=0}
            {assign var='count' value='0'}
            {foreach from=$myobj->form_show_category item=result key=count name=categorylist}
           	{$result.open_tr}
            	<div id="selphotoGallery" class="clsphotoCategoryCell">
                  <div class="clsNewAlbumList {if $countt % 3 == 0} clsThumbPhotoFinalRecord{/if}">
         			{$myobj->setTemplateFolder('general/','photo')}
        			{include file="box.tpl" opt="listimage_top"}
                	  <div class="clsChannelLeftContent">
                            <div class="clsLargeThumbImageBackground">
                              <div class="clsPhotoThumbImageOuter">
							  <div class="cls146x112 clsImageHolder clsImageBorderBg clsPointer">
                              	<a href="{$result.photo_link}" class="cls146x112 clsImageHolder clsImageBorderBg clsPointer">
                                     <img border="0" src="{$result.category_image}" alt="{$result.record.photo_category_name}" title="{$result.record.photo_category_name}" {$myobj->DISP_IMAGE(142, 108, $CFG.admin.photos.category_width, $CFG.admin.photos.category_height)}/></a>
									 </div>
                              </div>
                            </div>
                            </div>
					  <div id="selImageDet" class="clsPhotoCategoryList">
						<p class="clsHeading">
							<a href="{$result.photo_link}" title="{$result.record.photo_category_name}">
								{$result.record.photo_category_name}
							</a>
						</p>
					<p>{$LANG.search_option_today}: <span>{$result.today_category_count}</span>&nbsp;|&nbsp;{$LANG.photocategory_total}<span>{$result.record.photo_category_count}</span></p>
					{if $result.content_filter}
					  <div class="clsOverflow">
                        <div class="clsSubCategory">
                          <ul>
							<li>{if $myobj->getFormField('category_id')==''}<a href="{$result.record.photo_sub_url}"  class="clsSubCategoryIcon clsPhotoVideoEditLinks" title="{$LANG.photocategory_photo_subcategory}">{$LANG.photocategory_photo_subcategory}</a></li>
                            <li class="clsGenereType">|</li>{/if}
                            <li class="clsGenereType">{$LANG.genre_type}:</li>
                            <li class="clsCategoryType">{$result.record.photo_category_type}</li>
                           <!-- <li class="clsGenereType">|</li>-->
                          </ul>
                         </div>
							{*SUBSCRIPTION LINK STARTS HERE*}
                            {if chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule()}
                              <div class="clsSubscribeList">
                                <ul>
                                    {if isMember()}
                                          {if !$myobj->chkIsUserSubscribedToCategory($result.record.photo_category_id, $CFG.site.is_module_page)}
                                               <li id="subscribe_{$result.record.photo_category_id}">
                                                   <span><a href="javascript:void(0);" id="anchor_subscribe" onclick="subscription_sep_action({$result.record.photo_category_id}, 'Yes', '{$CFG.site.is_module_page}', 'Category');" class="clsSubscribeIcon clsPhotoVideoEditLinks" title="{$LANG.common_subscribe}">{$LANG.common_subscribe}</a></span>
                                               </li>
                                                <li id="unsubscribe_{$result.record.photo_category_id}" style="display:none">
                                                    <span><a href="javascript:void(0);" id="anchor_subscribe" onclick="subscription_sep_action({$result.record.photo_category_id}, 'No', '{$CFG.site.is_module_page}', 'Category');" class="clsUnSubscribeIcon clsPhotoVideoEditLinks" title="{$LANG.common_unsubscribe}">{$LANG.common_unsubscribe}</a></span>
                                                </li>
                                          {else}
                                                <li id="unsubscribe_{$result.record.photo_category_id}">
                                                    <span><a href="javascript:void(0);" id="anchor_subscribe" onclick="subscription_sep_action({$result.record.photo_category_id}, 'No', '{$CFG.site.is_module_page}', 'Category');" class="clsUnSubscribeIcon clsPhotoVideoEditLinks" title="{$LANG.common_unsubscribe}">{$LANG.common_unsubscribe}</a></span>
                                               </li>
                                                <li id="subscribe_{$result.record.photo_category_id}" style="display:none">
                                                    <span><a href="javascript:void(0);" id="anchor_subscribe" onclick="subscription_sep_action({$result.record.photo_category_id}, 'Yes', '{$CFG.site.is_module_page}', 'Category');" class="clsSubscribeIcon clsPhotoVideoEditLinks" title="{$LANG.common_subscribe}">{$LANG.common_subscribe}</a></span>
                                                </li>
                                          {/if}
                                    {else}
                                      <li>
                                          <span><a href="{$myobj->getUrl('photocategory', '', '', '', 'photo')}" class="clsSubscribeIcon clsPhotoVideoEditLinks" title="{$LANG.common_subscriptions}">{$LANG.common_subscriptions}</a></span>
                                      </li>
                                    {/if}
                                   </ul>
                                 </div>
                                 {/if}
                              {*SUBSCRIPTION LINK ENDS HERE*}
						</div>
					{/if}
					{if chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule()}
					   <p class="clsPhotoCategoryDesc">{$LANG.common_totalsubscriptions}: <span id="total_sub_{$result.record.photo_category_id}">{$myobj->getCategorySubscriptionCount($result.record.photo_category_id, $CFG.site.is_module_page)}</span></p>
					 {/if}
					</div>
                    {$myobj->setTemplateFolder('general/','photo')}
        			{include file="box.tpl" opt="listimage_bottom"}
                  </div>
				</div>

			{$result.end_tr}
            {counter  assign=count}
            {if $count%$CFG.admin.photos.catergory_list_per_row eq 0}
            	{counter start=0}
            {/if}
            {assign var=countt value=$countt+1}
            {/foreach}
            {assign var=cols  value=$CFG.admin.photos.catergory_list_per_row-$count}
           {if $count}
                {section name=foo start=0 loop=$cols step=1}
                    <p>&nbsp;</p>
                {/section}
            {/if}
			{/if}
         	</div>
          </div>
       </div>
                <div class="clsOverflow clsSlideBorder">
                  <div id="bottomLinks"><div class="clsAudioPaging">
                   {if $CFG.admin.navigation.bottom}
                    {$myobj->setTemplateFolder('general/', 'photo')}
                    {include file='pagination.tpl'}
                  {/if}
                  </div>
                </div>
           </div>
    {/if}
	</div>

{$myobj->setTemplateFolder('general/','photo')}
{include file='box.tpl' opt='photomain_bottom'}
</div>
