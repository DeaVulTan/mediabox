<div class="clsOverflow"><div class="clsSubscribePhotoTags">
{if $subscription_tag_list.resultFound}
      {foreach from=$subscription_tag_list.item item=tag}
        <div class="clsFloatLeft">
	  		<div class="clsTagStyleOrange clsViewPhotoTagContent"><a id="photo_tag_{$tag.name}" href="{$tag.url}" onmouseover="showSubscriptionDetail('{$tag.add_slash_name}');" >{$tag.name}</a><span id="photoPopUp_"><!----></span></div>
			<div id="photoPopUp_{$tag.name}" style="visibility:hidden;" class="clsTagStyleIcon" onmouseover="showTagDetail('{$tag.add_slash_name}');" onmouseout="hideTagDetail('{$tag.add_slash_name}');">
				<span class="clsSubscribeIcon"></span>
          
			{* pop up info starts *}
			<div style="display:none" id="taglist_{$tag.name}"> 
			  <div class="clsPopSubcriptionPhotoTag">
				<div class="clsPopUpSubsDivContainer"> 
				{$myobj->setTemplateFolder('general/', 'photo')}
				{include file='box.tpl' opt='popinfotag_top'}
				   <div class="clsPopUpPaddingContent clsOverflow">
					<p class="clsPopUpSubsContent">
					  <span>{$LANG.common_totalsubscriptions}: </span>
					  <span id="total_tag_sub_{$tag.name}">({$myobj->getTagSubscriptionCount($tag.name, 'photo')})</span>							
					</p>
					<p class="clsSubscriptionBtn">
					 <span id="subscribe_{$tag.name}" style="display:none;"><a href="javascript:void(0);" id="anchor_subscribe"  onclick="subscription_sep_action('{$tag.add_slash_name}', 'Yes', 'photo', 'Tag');" title="{$LANG.common_subscribe}">{$LANG.common_subscribe}</a></span>
					 <span id="unsubscribe_{$tag.name}" style="display: block;"><a href="javascript:void(0);" id="anchor_subscribe"  onclick="subscription_sep_action('{$tag.add_slash_name}', 'No', 'photo', 'Tag');" title="{$LANG.common_unsubscribe}">{$LANG.common_unsubscribe}</a></span>                   
					</p>
				  </div>
				{$myobj->setTemplateFolder('general/', 'photo')}
				{include file='box.tpl' opt='popinfotag_bottom'}
			   </div>			
			 </div>
			</div>
			{* pop up info ends *}
           </div>
        </div>   
      {/foreach}
{else}
      <div id="selMsgAlert">{$LANG.common_no_subscribed_tags_found}</div>
{/if}
</div></div>