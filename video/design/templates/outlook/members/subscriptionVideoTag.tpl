<div class="clsOverflow"><p class="clsVideoTags">
{if $subscription_tag_list.resultFound}
      {foreach from=$subscription_tag_list.item item=tag}
            <span> 
            	<a id="video_tag_{$tag.name}" onmouseover="showDefaultSubscriptionOption('{$tag.name}', 'video', 'Tag', 'pos_{$tag.name}');" href="{$tag.url}">{$tag.name}</a>
                   
            	<span title="{$LANG.common_totalsubscriptions}">({$myobj->getTagSubscriptionCount($tag.name, 'video')})</span><span id="pos_{$tag.name}">&nbsp;</span>
            </span>
           {*SUBSCRIPTION UNSUBSCRIBE LINK STARTS HERE*}
                 <span id="subscription_{$tag.name}" style="display:none;">
                       <span id="unsubscribe_{$tag.name}"><a href="javascript:void(0);" id="anchor_subscribe_{$tag.name}" class="clsUnSubscribeIcon" onclick="subscription_sep_action('{$tag.name}', 'No', '{$CFG.site.is_module_page}', 'Tag');">{$LANG.common_unsubscribe}</a></span>
                       <span id="subscribe_{$tag.name}" style="display:none"><a href="javascript:void(0);" id="anchor_subscribe_{$tag.name}" class="clsSubscribeIcon" onclick="subscription_sep_action('{$tag.name}', 'Yes', '{$CFG.site.is_module_page}', 'Tag');">{$LANG.common_subscribe}</a></span>
                 </span>
           {*SUBSCRIPTION UNSUBSCRIBE LINK ENDS HERE*}
           
      {/foreach}
{else}
      <div id="selMsgAlert"><p>{$LANG.common_no_subscribed_tags_found}</p></div>
{/if}
</p></div>