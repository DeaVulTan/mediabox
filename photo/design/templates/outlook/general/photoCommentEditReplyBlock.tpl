<div class="clsEditCommentTextArea">
<form name="{$commentEditReply.name}{$commentEditReply.comment_id}" id="{$commentEditReply.name}_{$commentEditReply.comment_id}" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
			<table>
            <tr>
            <td class="clsTextareaWidth">
                <textarea name="comment_{$commentEditReply.comment_id}" id="comment_{$commentEditReply.comment_id}" rows="5" cols="91">{$myobj->getComment()}</textarea>
            </td>
           </tr>
           <tr>
        	<td colspan="2">
            <div class="clsButtonHolder clsPaddingLeft10">
                <p class="clsEditButton" id="post_comment"><span><a href="javascript:;" onClick="return {$commentEditReply.sumbitFunction}({$commentEditReply.comment_id}, '{$commentEditReply.editReplyUrl}')" name="post_comment"  tabindex="{smartyTabIndex}">{$LANG.viewphoto_edit_comment_save}</a></span></p>
                <p class="clsDeleteButton"  id="cancel"><span><a href="javascript:;" onClick="return {$commentEditReply.cancelFunction}({$commentEditReply.comment_id})" name="cancel"tabindex="{smartyTabIndex}">{$LANG.viewphoto_edit_comment_cancel}</a></span></p>
            </div>
            </td>
            </tr>
            </table>
</form>
</div>