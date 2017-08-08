{if $success eq 'success'}
	<div id="selMsgSuccess">
		<p>{$LANG.reportbugsreply_success}</p>
	</div>
{/if}
{foreach key=pbrlkey item=pbrlvalue from=$populateBugReplyList_arr}
	<p>
	   <span class="clsBubInfoTitle clsNoBorder" id="{$pbrlvalue.replySpanIDId}">
			<div class="clsBugReply">
            	<p class="clsReportBugTitle">{$pbrlvalue.record.bug_content}</p>
				<p><span class="">{$LANG.date_added}</span> : {$pbrlvalue.record.date_added|date_format}</p>
				<p><span class="">{$LANG.posted_by}</span>&nbsp;{$pbrlvalue.record.reply_from}</p>
				<p><span class="">{$LANG.common_status}</span>&nbsp;{$pbrlvalue.record.status}</p>
			</div>
	   </span>
	</p>	
{/foreach}
</div>
{literal}
	<script defer="defer" language="javascript" type="text/javascript">
		hideAnimateBlock('selMsgSuccess');
	</script>
{/literal}
