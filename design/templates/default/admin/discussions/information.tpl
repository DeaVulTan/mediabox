{if $myobj->isShowPageBlock('block_msg_form_error') }
<div id="selMsgError">
	 <p>{$myobj->getCommonErrorMsg()}</p>
</div>
{/if}
{if $myobj->isShowPageBlock('block_msg_form_success') }
<div id="selMsgSuccess">
	<p>{$myobj->getCommonSuccessMsg()}</p>
</div>
{/if}
{ if $myobj->isShowPageBlock('block_msg_form_alert')}
<div id="selMsgAlert">
	<p>{$myobj->getCommonAlertMsg()}</p>
</div>
{/if}
