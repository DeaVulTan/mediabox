
{if $cmValue.populateReply_arr}
    {if $cmValue.populateReply_arr.rs_PO_RecordCount}
	<p class="clsCommentReplyHead">Replied:</p>
        {foreach key=prKey item=prValue from=$cmValue.populateReply_arr.row}
			<div class="clsMoreInfoContent clsOverflow" id="delcmd{$prValue.record.music_comment_id}">
            	<div class="clsMoreInfoComment">
 					<div class="clsOverflow">
                        <div class="clsCommentThumb">
                            <div class="clsThumbImageLink">
                                <a href="{$prValue.memberProfileUrl}" class="ClsImageContainer ClsImageBorder1 Cls45x45">
                                    <img src="{$prValue.icon.s_url}" title="{$prValue.name}" {$myobj->DISP_IMAGE(45, 45, $prValue.icon.s_width, $prValue.icon.s_height)} />
                                </a>
                            </div>
                        </div>
                        <div class="clsCommentDetails">
                            <p class="clsCommentedBy"><a href="{$prValue.memberProfileUrl}" title="{$prValue.name}">{$prValue.name}</a><span class="clsLinkSeperator">|</span><span>{$prValue.record.pc_date_added}</span></p>
                            <p id="selEditCommentTxt_{$prValue.record.music_comment_id}" class="clsMusicCommentDisplay">{$prValue.comment_makeClickableLinks}</p>
                            <div id="selEditComments_{$prValue.record.music_comment_id}"></div>
                            <div id="selEditComments_{$prValue.record.music_comment_id}"></div>
							<div class="clsButtonHolder">
					{if (isMember() and $prValue.record.comment_user_id == $CFG.user.user_id)}
						<p class="clsEditButton" id="selViewEditComment_{$prValue.record.music_comment_id}">
							<span>
								<a href="javascript:void(0);" onclick="return callAjaxEdit('{$CFG.site.url}music/listenMusic.php?ajax_page=true&amp;page=comment_edit&amp;music_id={$myobj->getFormField('music_id')}&amp;vpkey={$myobj->getFormField('vpkey')}&amp;show={$myobj->getFormField('show')}','{$prValue.record.music_comment_id}')" title="{$LANG.viewmusic_edit_label}">{$LANG.viewmusic_edit_label}</a>
							</span>
						</p>
					{/if}
					{if isMember() and ($prValue.record.comment_user_id == $CFG.user.user_id || $myobj->getFormField('user_id') == $CFG.user.user_id)}
							<p class="{if (isMember() and $prValue.record.comment_user_id == $CFG.user.user_id)}  clsDeleteButton {else} clsReplyButton{/if}" id="selViewDeleteComment_{$prValue.record.music_comment_id}">
								<span>
									<a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmWindow', 'msgConfirmform', Array('comment_id', 'maincomment_id', 'confirmationMsg', 'commentorreply'), Array('{$prValue.record.music_comment_id}', '{$prValue.record.music_comment_main_id}', '{$LANG.viewmusic_confirm_txt}', 'deletereply'), Array('value', 'value', 'html', 'value'))" title="{$LANG.viewmusic_deleted_label}">{$LANG.viewmusic_deleted_label}</a>
								</span>
							</p>
					 {/if}
                 </div>
                        </div>
                    </div>
                </div>
                 
            </div>
        {/foreach}
    {/if}
{/if}