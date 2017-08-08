{include file='../general/information.tpl'}
{literal}
<script type="text/javascript" >
function closeCurrentWindow()
	{
		window.close();
	}
</script>
{/literal}
{if $myobj->isShowPageBlock('form_success')}
    <div id="selMsgSuccess">
        <p>{$myobj->getCommonSuccessMsg()}&nbsp;<a href="javascript:closeCurrentWindow()">{$LANG.common_msg_click_here}</a></p>
    </div>
{/if}
