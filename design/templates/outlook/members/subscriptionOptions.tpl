<div>
	<div class="clsOverflow">
	    <div class="clsSubscriptionTitle">
	        <h2>
	        <span>{$LANG.common_manage_subscriptions}</span></h2>
	    </div>
	    <div class="clsSubscriptionClose">
	    	<a href="javascript:void(0)" onclick="$Jq('#selAjaxWindow').dialog('close');" class="clsSubscribeClose">{$LANG.common_close}</a>
	    </div>
	</div>

	{include file='../general/information.tpl'}

	{if $subscription_details_arr}
		<div id="subscription_options" class="clsListTable clsFriendSearchTable">
	      <p class="clsNoteMessange"><span>{$LANG.common_note}:&nbsp;</span>{$LANG.common_subscription_note_member_manage_msg}</p>
	      <form name="subscription_options" id="subscription_options" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
				{foreach from=$subscription_details_arr item=sub_value key=inc}
	                  	<div>
	                        {if $sub_value.status == 'Yes'}
	                        	<span id="unsubscribe_{$sub_value.module}">
	                            	<input type="checkbox" id="sub_{$sub_value.module}" name="sub_{$sub_value.module}" value="{$sub_value.module}" class="clsHiddenCheck" checked="checked" onclick="toggleSubscriptionCheckBox('{$sub_value.module}')" />
	                            	<label title="{$LANG.common_subscribe}" id="sub_label_{$sub_value.module}" for="sub_{$sub_value.module}" class="clsSubscriptionChecked" >&nbsp;{$sub_value.sub_lang}</label>
	                            </span>
	                        {else}
	                              <span id="subscribe_{$sub_value.module}">
	                              	<input type="checkbox" id="sub_{$sub_value.module}" name="sub_{$sub_value.module}" value="{$sub_value.module}" class="clsHiddenCheck" onclick="toggleSubscriptionCheckBox('{$sub_value.module}')" />
	                              	<label title="{$LANG.common_unsubscribe}" id="sub_label_{$sub_value.module}" for="sub_{$sub_value.module}" class="clsSubscriptionUnChecked" >&nbsp;{$sub_value.sub_lang}</label>
	                              </span>
	                        {/if}
					</div>
	                  {/foreach}
	              <input type="button" class="clsSubmitButton" name="common_confirm_yes" id="common_confirm_yes" value="{$LANG.common_submit}" tabindex="{smartyTabIndex}" onclick="subscription_action({$myobj->getFormField('owner_id')});" /> &nbsp;
	              <input type="button" class="clsSubmitButton" name="common_confirm_no" id="common_confirm_no" value="{$LANG.common_cancel}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks()" />
	        </form>
		</div>
	{/if}
</div>