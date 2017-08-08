<div class="clsEditCommentTextAreaComment">
<form name="{$commentEditReply.name}{$commentEditReply.comment_id}" id="{$commentEditReply.name}_{$commentEditReply.comment_id}" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
<table class="clsTable100">
    <tr>
        <td>
            <textarea class="clsWidth99" name="comment_{$commentEditReply.comment_id}" id="comment_{$commentEditReply.comment_id}" rows="5" cols="80">{$myobj->getComment()}</textarea>
        </td>
    </tr>
    <tr>
        <td colspan="2">
			<div class="clsButtonHolder">
            <p class="clsCommentsSectionReply"><input class="clsCommentDiscard" type="button" onClick="return {$commentEditReply.sumbitFunction}({$commentEditReply.comment_id}, '{$commentEditReply.editReplyUrl}')" name="post_comment" id="post_comment" tabindex="{smartyTabIndex}" value="{$LANG.postcomment_post_comment}" /></p>
			<p>
            <input class="clsCommentDiscard" type="button" onClick="return {$commentEditReply.cancelFunction}({$commentEditReply.comment_id})" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.postcomment_cancel}" /></p>
			</div>
        </td>
    </tr>
</table>
</form>
</div>
