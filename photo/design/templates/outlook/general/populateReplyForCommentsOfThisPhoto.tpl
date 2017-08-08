{if $cmValue.populateReply_arr}
    {if $cmValue.populateReply_arr.rs_PO_RecordCount}
        {foreach key=prKey item=prValue from=$cmValue.populateReply_arr.row}
			<div class="clsMoreInfoPhotoContent clsOverflow" id="delcmd{$prValue.record.photo_comment_id}">
            	<div class="clsMoreInfoComment">
            	<p class="clsReplyedText">{$LANG.viewphoto_replied_label}:</p>
				<div class="clsOverflow">
                    <div class="clsCommentThumb">
                        <div class="clsThumbImageLink">
                           <a href="{$prValue.memberProfileUrl}" class="Cls45x45 clsImageHolder clsUserThumbImageOuter clsPointer">
                               <img src="{$prValue.icon.s_url}" title="{$prValue.name}"  alt="{$prValue.name|truncate:5}" {$myobj->DISP_IMAGE(45, 45, $prValue.icon.s_width, $prValue.icon.s_height)}/>
                            </a>
                        </div>
                    </div>
                    <div class="clsCommentDetails">
                            <p class="clsCommentedBy"><a href="{$prValue.memberProfileUrl}" title="{$prValue.name}">{$prValue.name}</a><span class="clsLinkSeperator">|</span> 
                            <span>{$prValue.record.pc_date_added}</span></p>
                        <p id="selEditCommentTxt_{$prValue.record.photo_comment_id}" class="clsPhotoCommentDisplay">{$prValue.comment_makeClickableLinks}</p>
                        <p id="selEditComments_{$prValue.record.photo_comment_id}"></p>
                        <div class="clsButtonHolder">
                            {if (isMember() and $prValue.record.comment_user_id == $CFG.user.user_id)}
                                <p class="clsEditButton" id="selViewEditComment_{$prValue.record.photo_comment_id}">
                                    <span>
                                        <a href="javascript:void(0);" onClick="return callAjaxEdit('{$CFG.site.url}photo/viewPhoto.php?ajax_page=true&amp;page=comment_edit&amp;photo_id={$myobj->getFormField('photo_id')}&amp;vpkey={$myobj->getFormField('vpkey')}&amp;show={$myobj->getFormField('show')}','{$prValue.record.photo_comment_id}')" title="{$LANG.viewphoto_edit_label}">{$LANG.viewphoto_edit_label}</a>
                                    </span>
                                </p>
                            {/if}
                            {if (isMember() and $prValue.record.comment_user_id != '') || $myobj->getFormField('user_id') != ''}
                                {if (isMember())}
                                    <p class="clsDeleteButton clsReplyDelete" id="selViewDeleteComment_{$prValue.record.photo_comment_id}">
                                        <span>
                                            <a href="javascript:void(0);" onClick="return Confirmation('selMsgConfirmWindow', 'msgConfirmform', Array('comment_id', 'maincomment_id', 'confirmationMsg', 'commentorreply'), Array('{$prValue.record.photo_comment_id}', '{$prValue.record.photo_comment_main_id}', '{$LANG.viewphoto_comment_delete_confirmation}', 'deletereply'), Array('value', 'value', 'html', 'value'))" title="{$LANG.viewphoto_deleted_label}">{$LANG.viewphoto_deleted_label}</a>
                                        </span>
                                    </p>
                                {/if}
                            {/if}
                    	</div>
                    </div>
            	</div>
                </div>
			</div>
        {/foreach}
    {/if}
{/if}