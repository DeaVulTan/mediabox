{if $cmValue.populateReply_arr}
    {if $cmValue.populateReply_arr.rs_PO_RecordCount}
        {foreach key=prKey item=prValue from=$cmValue.populateReply_arr.row}
            <div class="clsOverflow">
                <div class="clsCommentReplySection" id="delcmd{$prValue.record.blog_comment_id}">
                    <div class="{$prValue.class}" id="cmd{$prValue.record.blog_comment_id}">
                        <div class="clsHomeDispContents clsCommentAuthor">
                            <div id="commentUserProfile_{$prValue.record.blog_comment_id}" class="clsCoolMemberActive"  style="display:none;" onmouseover="showUserInfoPopup('{$myobj->getUrl('userdetail')}', '{$prValue.record.comment_user_id}', 'commentUserProfile_{$prValue.record.blog_comment_id}','L');" onmouseout="hideUserInfoPopup('commentUserProfile_{$prValue.record.blog_comment_id}')"></div>
                            <div class="clsCommentImage">
                                <div class="clsPointer" onclick="Redirect2URL('{$prValue.memberProfileUrl}')" onmouseover="showUserInfoPopup('{$myobj->getUrl('userdetail')}', '{$prValue.record.comment_user_id}', 'commentUserProfile_{$prValue.record.blog_comment_id}','L');" onmouseout="hideUserInfoPopup('commentUserProfile_{$prValue.record.blog_comment_id}')">
                                    <a href="#" class="Cls45x45 ClsImageBorder1 ClsImageContainer"><img src="{$prValue.icon.s_url}" alt="{$prValue.name}"  {$myobj->DISP_IMAGE(45, 45, $prValue.icon.s_width, $prValue.icon.s_height)}  /></a>
                                </div>
                            </div>
                            <div class="clsCommentContent">
                                <p class="clsMembersName"><a href="{$prValue.comment_memberProfileUrl}">{$prValue.name}</a><span class="clsLinkSeperator">|</span><span>{$prValue.record.pc_date_added}</span></p>
                                <div id="cmd{$prValue.record.blog_comment_id}_1">
                                    <div>
                                        <div class="clsCommentDiv">
                                            <p id="selEditCommentTxt_{$prValue.record.blog_comment_id}" class="clsBlogCommentDisplay">{$prValue.comment_makeClickableLinks}</p>
                                            <p id="selEditComments_{$prValue.record.blog_comment_id}"></p>
                                            {if (isMember() and $prValue.record.comment_user_id == $CFG.user.user_id) || $myobj->getFormField('user_id') == $CFG.user.user_id}
                                                <div>
                                                    <p class="clsCommentsReplySection clsCommentsSectionReply">
                                                        <span id="selViewEditComment_{$prValue.record.blog_comment_id}" class="">
                                                            <a href="javascript:void(0);" onClick="return callAjaxEdit('{$CFG.site.url}blog/viewPost.php?ajax_page=true&amp;blog_id={$myobj->getFormField('blog_id')}&amp;vpkey={$myobj->getFormField('vpkey')}&amp;show={$myobj->getFormField('show')}','{$prValue.record.blog_comment_id}')">{$LANG.viewpost_edit_label}</a>
                                                        </span>
                                                    </p>                                                   
                                                    	<p class="clsCommentsReplySection">
                                                        <span id="selViewDeleteComment_{$prValue.record.blog_comment_id}">
                                                            <a class="clsButton4" href="javascript:void(0);" onClick="return Confirmation('selMsgConfirmWindow', 'msgConfirmform', Array('comment_id', 'maincomment_id', 'confirmationMsg', 'commentorreply'), Array('{$prValue.record.blog_comment_id}', '{$prValue.record.blog_comment_main_id}', '{$LANG.viewpost_confirm_txt}', 'deletereply'), Array('value', 'value', 'html', 'value'))">{$LANG.viewpost_deleted_label}</a>
                                                        </span>
                                                    </p>
                                                </div>
                                            {/if}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {/foreach}
    {/if}
{/if}              