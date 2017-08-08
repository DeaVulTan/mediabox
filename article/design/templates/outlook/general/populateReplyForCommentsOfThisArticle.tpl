{if $cmValue.populateReply_arr}
    {*{if $cmValue.populateReply_arr.rs_PO_RecordCount}*}
        {foreach key=prKey item=prValue from=$cmValue.populateReply_arr.row}
                <div class="clsCommentReplySection clsOverflow" id="delcmd{$prValue.record.article_comment_id}">
                    <div class="{$prValue.class}" id="cmd{$prValue.record.article_comment_id}">
                        <div class="clsHomeDispContents clsCommentAuthor">

                         {*   <div id="commentUserProfile_{$prValue.record.article_comment_id}" class="clsCoolMemberActive"  style="display:none;" onMouseOver="showUserInfoPopup('{$myobj->getUrl('userdetail')}', '{$prValue.record.comment_user_id}', 'commentUserProfile_{$prValue.record.article_comment_id}','L');" onMouseOut="hideUserInfoPopup('commentUserProfile_{$prValue.record.article_comment_id}')"></div> *}
                             <div id="commentUserProfile_{$prValue.record.article_comment_id}" class="clsCoolMemberActive"  style="display:none;" ></div>
                             <div class="clsRepliedComment">
                                <p class="clsCommentReplyHead">{$LANG.viewarticle_replied}</p>
                                <div class="clsCommentThumb">
    
                                {*       <div class="clsPointer" onClick="Redirect2URL('{$prValue.memberProfileUrl}')" onMouseOver="showUserInfoPopup('{$myobj->getUrl('userdetail')}', '{$prValue.record.comment_user_id}','commentUserProfile_{$prValue.record.article_comment_id}','L');" onMouseOut="hideUserInfoPopup('commentUserProfile_{$prValue.record.article_comment_id}')">*}
    
    
                                     <a href="{$prValue.memberProfileUrl}" class="clsPointer Cls45x45 ClsImageBorder1 ClsImageContainer">
                                        <img src="{$prValue.icon.s_url}" alt="{$prValue.name}"  {$myobj->DISP_IMAGE(45, 45, $prValue.icon.s_width, $prValue.icon.s_height)}  />
                                    </a>
                                </div>
                                <div class="clsCommentDetails">
                                    <p class="clsMembersName"><a href="{$prValue.comment_memberProfileUrl}">{$prValue.name}</a>  <span class="clsLinkSeperator">|</span> <span>{$prValue.record.pc_date_added}</span></p>
                                    <div id="cmd{$prValue.record.article_comment_id}_1">
                                            <div class="clsCommentDiv">
                                                <p id="selEditCommentTxt_{$prValue.record.article_comment_id}">{$prValue.comment_makeClickableLinks}</p>
                                                <p id="selEditComments_{$prValue.record.article_comment_id}"></p>
                                                    <div class="clsButtonHolder">
                                                    {if (isMember() and $prValue.record.comment_user_id == $CFG.user.user_id)}
                                                        <p id="selViewEditComment_{$prValue.record.article_comment_id}" class="clsEditButton">
                                                           <span> <a href="javascript:void(0);" onClick="return callAjaxEdit('{$CFG.site.url}article/viewArticle.php?ajax_page=true&amp;article_id={$myobj->getFormField('article_id')}&amp;vpkey={$myobj->getFormField('vpkey')}&amp;show={$myobj->getFormField('show')}','{$prValue.record.article_comment_id}')">{$LANG.viewarticle_edit}</a></span>
                                                        </p>
                                                    {/if}
                                                    {if (isMember() and $prValue.record.comment_user_id != '') || $myobj->getFormField('user_id') != ''}
                                                        {if (isMember())}
                                                            <p id="selViewDeleteComment_{$prValue.record.article_comment_id}" class="clsDeleteButton">
                                                               <span> <a class="clsButton4" href="javascript:void(0);" onClick="return Confirmation('selMsgConfirmWindow', 'msgConfirmform', Array('comment_id', 'maincomment_id', 'confirmationMsg', 'commentorreply'), Array('{$prValue.record.article_comment_id}', '{$prValue.record.article_comment_main_id}', '{$LANG.viewarticle_confirm_txt}', 'deletereply'), Array('value', 'value', 'html', 'value'))">{$LANG.viewarticle_delete}</a></span>
                                                            </p>
                                                         {/if}
                                                    {/if}
                                               </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>
                   		 </div>
               		 </div>
                </div>
        {/foreach}
    {*{/if}*}
{/if}