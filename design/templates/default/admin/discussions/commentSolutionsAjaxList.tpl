{if $success eq 'success'}
	<div id="selMsgSuccess1">
		<p>{$LANG.solutions_comment_edited_successfully}</p>
	</div>
{/if}
{foreach key=farlkey item=farlvalue from=$populateAjaxCommentList_arr}
	<p>
	   <span>
	   		<p><span>{$LANG.common_comment_posted_by}</span> :  <a href="{$farlvalue.mysolutions.url}">{$farlvalue.user_details.display_name}</a>
			<p><span>{$LANG.common_date_added}</span> : {$farlvalue.record.date_added|date_format}</p>
			<p>{$farlvalue.record.comment}</p>
	 </span>
	</p>	
{/foreach}

{literal}
	<script defer="defer" language="javascript" type="text/javascript">
		hideAnimateBlock('selMsgSuccess1');
	</script>
{/literal}
