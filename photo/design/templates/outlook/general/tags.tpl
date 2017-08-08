<div class="clsOverflow">
{$myobj->setTemplateFolder('general/','photo')}
{include file="box.tpl" opt="photomain_top"}
<div id="selGroupCreate" class="clsOverflow">
  <div class="clsOverflow">
   <div class="clsHeadingLeft"><h2><span>{$LANG.page_playlist_title}</span></h2></div>
   <div class="clsPhotoListHeadingRight clsMyCategroySubscription">
	   {if isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule()}
		   {if $myobj->getFormField('action') == ''}
				<a href="{$myobj->my_subscription_url}" title="{$LANG.common_tag_my_subscriptions}">{$LANG.common_tag_my_subscriptions}</a>
		   {else}
		 		<a href="{$myobj->getUrl('tags', '?pg=photos', 'photos/', 'members', 'photo')}" title="{$LANG.common_tag_showall}">{$LANG.common_tag_showall}</a>
		   {/if}
	   {/if}
   </div>
  </div>
  <div class="clsTags clsOverflow">{if $myobj->tag_arr.resultFound}
		{foreach from=$myobj->tag_arr.item item=tag}
         <div class="clsFloatLeft clsMarginRight10">
		  <div class="{$tag.class}" >

				{if isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule()}
					{if $myobj->getFormField('action') == 'mysubscriptions'}
					  <a id="photo_tag_{$tag.name}" onmouseover="showDefaultSubscriptionOption('{$tag.add_slash_name}', '{$CFG.site.is_module_page}', 'Tag', 'pos_{$tag.change_title_name}');" href="{$tag.url}" {$tag.fontSizeClass} title="{$tag.name}">{$tag.name}</a>
					{else}
					  <a href="{$tag.url}" {$tag.fontSizeClass} {if isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule()} onmouseover="showSubscriptionDetail('{$tag.add_slash_name}');" {/if} title="{$tag.name}">{$tag.name}</a>
					 {/if}
				{else}
					<a href="{$tag.url}" {$tag.fontSizeClass} title="{$tag.name}">{$tag.name}</a>
				{/if}
				<span id="photoPopUp_"><!----></span>
			     <span id="pos_{$tag.change_title_name}"><!----></span>
			 </div>
          {if chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule()}
	      <div id="photoPopUp_{$tag.name}" style="visibility:hidden;" class="clsTagStyleIcon" {if isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule()} onmouseover="showTagDetail('{$tag.add_slash_name}');" onmouseout="hideTagDetail('{$tag.add_slash_name}');" {/if}>
			<span class="clsSubscribeIcon"></span>
        {* pop up info starts *}
        <div style="display:none" id="taglist_{$tag.name}">
          <div class="clsPopSubscriptionInfo">
            <div class="clsPopUpSubsDivContainerTags">
            {$myobj->setTemplateFolder('general/','photo')}
            {include file='box.tpl' opt='popinfotag_top'}
        	   <div class="clsPopUpPaddingContent clsOverflow">
        		<p class="clsPopUpSubsContent">
         		  <span>{$LANG.common_totalsubscriptions}: </span>
        		  <span id="total_tag_sub_{$tag.name}">({$myobj->getTagSubscriptionCount($tag.name, $CFG.site.is_module_page)})</span>
        		</p>
                <p class="clsSubscriptionBtn">
                 <span id="subscribe_{$tag.name}" style="display:{if !$tag.subscription} block; {else} none; {/if}"><a href="javascript:void(0);" id="anchor_subscribe"  onclick="subscription_sep_action('{$tag.add_slash_name}', 'Yes', 'photo', 'Tag');" title="{$LANG.common_subscribe}">{$LANG.common_subscribe}</a></span>
                 <span id="unsubscribe_{$tag.name}" style="display:{if $tag.subscription} block; {else} none; {/if}"><a href="javascript:void(0);" id="anchor_subscribe"  onclick="subscription_sep_action('{$tag.add_slash_name}', 'No', 'photo', 'Tag');" title="{$LANG.common_unsubscribe}">{$LANG.common_unsubscribe}</a></span>
                </p>
        	  </div>
            {$myobj->setTemplateFolder('general/','photo')}
            {include file='box.tpl' opt='popinfotag_bottom'}
           </div>
         </div>
        </div>
		{* pop up info ends *}
		</div>

        {/if}
        {if isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule()}
          {if $myobj->getFormField('action') == 'mysubscriptions'}
            <span id="subscription_{$tag.name}" style="display:none;">
              <span id="unsubscribe_{$tag.name}"><a href="javascript:void(0);" class="clsUnSubscribeIcon clsPhotoVideoEditLinks" id="anchor_subscribe_{$tag.name}" onclick="subscription_sep_action('{$tag.add_slash_name}', 'No', '{$CFG.site.is_module_page}', 'Tag');" title="{$LANG.common_unsubscribe}">{$LANG.common_unsubscribe}</a></span>
              <span id="subscribe_{$tag.name}" style="display:none"><a href="javascript:void(0);" class="clsSubscribeIcon clsPhotoVideoEditLinks" id="anchor_subscribe_{$tag.name}" onclick="subscription_sep_action('{$tag.add_slash_name}', 'Yes', '{$CFG.site.is_module_page}', 'Tag');" title="{$LANG.common_subscribe}">{$LANG.common_subscribe}</a></span>
           </span>
         {/if}
       {/if}

         </div>
		{/foreach}
     {else}
     	<div id="selMsgAlert">
		    {$LANG.no_tags_found}
        </div>
	{/if}
</div>
</div>
{$myobj->setTemplateFolder('general/','photo')}
{include file='box.tpl' opt='photomain_bottom'}
</div>
