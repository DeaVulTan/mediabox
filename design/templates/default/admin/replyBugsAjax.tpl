{if isMember()}
    <div name="selListStaticForm{$bug_id}" id="msgreplySpanID_{$bug_id}">
        <table>
            <tr class="clsFormRow">
                <td class="{$myobj->getCSSFormLabelCellClass('message')}">
                    <label for="message">{$LANG.reportbugs_message}</label>
                    {include file='../general/box.tpl' opt='compulsory_icon'}
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('message')}">
                    <textarea name="user_reply_{$bug_id}" id="user_reply_{$bug_id}" tabindex="{smartyTabIndex}" rows="4" cols="45">{$myobj->getFormField('message')}</textarea>
                    {$myobj->getFormFieldErrorTip('message')}
                </td>
            </tr>
            <tr class="clsFormRow">
                <td class="clsButtonAlignment {$myobj->getCSSFormFieldCellClass('default')}"></td>
                <td>
                    <input type="hidden" name="bug_id" id="bug_id" value="{$bug_id}"  />
                    <input type="button" class="clsSubmitButton" name="reply_bugs" id="reply_bugs" value="{$LANG.reportbugs_submit}" tabindex="{smartyTabIndex}" onclick="postBugReply('{$myobj->getCurrentUrl()}','postYourReply=1&bug_id={$bug_id}','replySpanID_{$bug_id}','post','user_reply_{$bug_id}','{$bug_id}');" />
                </td>
            </tr>
        </table>
    </div>
{else}
	Session Expired. <a href="{$CFG.auth.login_url}?r">Login to continue..!</a>
{/if}	

