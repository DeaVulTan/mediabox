{if $success eq 'success'}
	<div id="selMsgSuccess1">
		<p>{$LANG.solution_comments_success}</p>
	</div>
{/if}
<div class="clsBubInfoTitle">
{foreach key=farlkey item=farlvalue from=$populateAjaxCommentList_arr}
   <div class="clsSolutionCommentDetails clsCommentSolutionDisplay">
	  <div id="{$farlvalue.commentSpanIDId}" class="clsUserThumbDetails">
            <div class="clsUserDetails clsClearFix">
			<p class="clsSolutionPost">{$LANG.discuzz_common_comment_posted_by} :  <span class="clsUserName"><a href="{$farlvalue.mysolutions.url}">{$farlvalue.user_details.display_name}</a></span>
			<span>{$LANG.discuzz_common_date_added} : {$farlvalue.record.date_added}</span></p>
			<p class="clsCommentText"><span>{$farlvalue.record.comment}</span></p>
			{if $CFG.user.user_id == $farlvalue.record.user_id  && $CFG.admin.delete_comment.allowed}
				<p><span class="clsCommentDelete"><a href="{$solutionsurl}" onClick="doActionOnComment('deletecomment', '{$farlvalue.anchor}', '{$LANG.confirm_delete_message_comment}', '{$farlvalue.record.comment_id}'); return false;">{$LANG.discuzz_common_delete}</a></span></p>
			{/if}
            </div>
      </div>
	</div>
{/foreach}
</div>
{literal}
	<script defer="defer" language="javascript" type="text/javascript">
		hideAnimateBlock('selMsgSuccess1');
	</script>
{/literal}
