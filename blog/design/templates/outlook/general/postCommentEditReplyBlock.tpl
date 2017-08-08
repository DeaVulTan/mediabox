<div class="clsBlogEditTextAreaSection">
<form name="{$commentEditReply.name}{$commentEditReply.comment_id}" id="{$commentEditReply.name}_{$commentEditReply.comment_id}" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
<table class="clsTable100">
    <tr>
        <td>
		<textarea name="comment_{$commentEditReply.comment_id}" class="clsWidth99" id="comment_{$commentEditReply.comment_id}" rows="5" cols="80">{$myobj->getComment()}</textarea>		</td>
	</tr>
	<tr>
		<td>
            <div class="clsButtonHolder">
                  <p class="clsCommentsSectionReply" id="post_comment"><span><a href="javascript:;" class="clsCommentDiscard" onClick="return {$commentEditReply.sumbitFunction}({$commentEditReply.comment_id}, '{$commentEditReply.editReplyUrl}')" name="post_comment"  tabindex="{smartyTabIndex}">{$LANG.viewpost_edit_comment_save}</a></span></p>
                <p id="cancel"><span><a href="javascript:;" class="clsCommentDiscard" onClick="return {$commentEditReply.cancelFunction}({$commentEditReply.comment_id})" name="cancel"tabindex="{smartyTabIndex}">{$LANG.viewpost_edit_comment_cancel}</a></span></p>
            </div>
        </div>
		</td>
	</tr>
</table>
</form>
</div>