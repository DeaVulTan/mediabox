{if isMember()}
	{if $myobj->isShowPageBlock('show_option_to_comment')}
		<table class="clsFormTbl">
			<tr class="clsFormRow">
				<td class="{$myobj->getCSSFormLabelCellClass('message')}">
					<label for="message">{$LANG.comment_solutions}{$myobj->displayCompulsoryIcon()}</label>
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('message')}">
				  	<p id="validReply{$comment_id}" class="LV_validation_message LV_invalid"></p>
					<textarea name="user_comment" id="user_reply" tabindex="{smartyTabIndex}" class="selInputLimiter" maxlength="{$CFG.admin.comment.limit}" maxlimit="{$CFG.admin.comment.limit}" rows="4" cols="45" >{$showOptionToComment_arr.comment.details}</textarea>{$myobj->getFormFieldElementErrorTip('user_comment')}
				</td>
			</tr>
			<tr class="clsFormRow">
				<td class="clsButtonAlignment {$myobj->getCSSFormFieldCellClass('default')}" colspan="2">
					<input type="hidden" name="act" id="act" value="comment" />
					<input type="hidden" name="comment_id" id="comment_id" value="{$comment_id}" />
					<input type="hidden" name="start" id="start" value="{$myobj->getFormField('start')}" />
					<input type="hidden" name="c_qid" id="c_qid" value="{$myobj->getFormField('c_qid')}" />
					<input type="button" class="clsSubmitButton" name="post_comment" id="post_valuess{$comment_id}" onclick="c = chkMessage('user_reply','selListAdvertisementForm');if(c == 0)processingRequestForComment('post_valuess{$comment_id}','cancel_comment', 'selProcessingRequest');ajaxSubmitForm('{$showOptionToComment_arr.submit.onclick}', 'selListAdvertisementForm', '{$commentSpanIDId}', '{$comment_id}');hideAllBlocks(); return false;" value="{$LANG.common_update}" tabindex="{smartyTabIndex}" />
					<input type="button" class="clsCancelButton" name="cancel_comment" id="cancel_comment" onclick="ajaxSubmitForm('{$showOptionToComment_arr.cancel.onclick}', 'selListAdvertisementForm', '{$commentSpanIDId}', '{$comment_id}');hideAllBlocks(); return false;" value="{$LANG.common_cancel}" tabindex="{smartyTabIndex}" /><div id="selProcessingRequest"></div>
				</td>
			</tr>
		</table>
	{/if}
	{if $myobj->isShowPageBlock('cancel_option_to_comment')}
	{/if}
	{if $myobj->isShowPageBlock('post_your_comment')}
	{/if}
{else}
	Session Expired. <a href="{$CFG.auth.login_url}?r">Login to continue..!</a>
{/if}
{literal}
	<script language="javascript" defer="defer" type="text/javascript">
		document.selListAdvertisementForm.user_reply.focus();
	</script>
{/literal}