<div id="selGroupCreate">
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
	<div class="clsOverflow">
    	<div class="clsVideoListHeading">
        	<h2><span>{$myobj->LANG.page_video_title}</span></h2>
        </div>
       <div class="clsVideoListHeadingRight clsMyCategroySubscription">
           {if isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule()}
            {if $myobj->getFormField('action') == ''}
                <a href="{$myobj->my_subscription_url}">{$LANG.common_tag_my_subscriptions}</a>
              {else}
                <a href="{$myobj->getUrl('tags', '?pg=videos', 'videos/', 'members', 'video')}">{$LANG.common_tag_showall}</a>      
              {/if}
           {/if}   
       </div>   
   </div>
		<div class="clsVideoTags clsOverflow">
		  {if $myobj->tag_arr.resultFound}
			{foreach from=$myobj->tag_arr.item item=tag}
         <div class="clsFloatLeft clsMarginRight10">
				<div class="{$tag.class}">
						{if isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule()}
							  {if $myobj->getFormField('action') == 'mysubscriptions'}
								<a id="video_tag_{$tag.name}" onmouseover="showDefaultSubscriptionOption('{$tag.name}', '{$CFG.site.is_module_page}', 'Tag', 'pos_{$tag.name}');" href="{$tag.url}" {$tag.fontSizeClass}>{$tag.name}</a>
							  {else}
								<a id="video_tag_{$tag.name}" onmouseover="getSubscriptionOption('{$tag.name}', '{$CFG.site.is_module_page}', 'Tag', 'pos_{$tag.name}');" href="{$tag.url}" {$tag.fontSizeClass}>{$tag.name}</a>
							  {/if}
                                    {else}
                                    	<a href="{$tag.url}" {$tag.fontSizeClass}>{$tag.name}</a>
						{/if}
							 
					  {if chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule()}
						<span title="{$LANG.common_totalsubscriptions}">({$myobj->getTagSubscriptionCount($tag.name, $CFG.site.is_module_page)})</span>
					  {/if}
					  <span id="pos_{$tag.name}"><!----></span>
				</div>
					  {if isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule()}
							{if $myobj->getFormField('action') == 'mysubscriptions'}
								 <span id="subscription_{$tag.name}" style="display:none;">
									   <span id="unsubscribe_{$tag.name}"><a href="javascript:void(0);" class="clsUnSubscribeIcon" id="anchor_subscribe_{$tag.name}" onclick="subscription_sep_action('{$tag.name}', 'No', '{$CFG.site.is_module_page}', 'Tag');">{$LANG.common_unsubscribe}</a></span>
									   <span id="subscribe_{$tag.name}" style="display:none"><a href="javascript:void(0);" class="clsSubscribeIcon" id="anchor_subscribe_{$tag.name}" onclick="subscription_sep_action('{$tag.name}', 'Yes', '{$CFG.site.is_module_page}', 'Tag');">{$LANG.common_subscribe}</a></span>
								 </span>
						   {/if}
					  {/if}
		</div>
			{/foreach}
		 {else}
			{$LANG.no_tags_found}
		{/if}
		  </div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}
</div>