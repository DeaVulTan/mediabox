<form name="frmPhotoComments" id="frmPhotoComments" action="{$myobj->getCurrentUrl()}">
{if isset($populateCommentOfThisPhoto_arr.hidden_arr) and $populateCommentOfThisPhoto_arr.hidden_arr}
	{$myobj->populateHidden($populateCommentOfThisPhoto_arr.hidden_arr)}
{/if}
{if isset($populateCommentOfThisPhoto_arr.row) and $populateCommentOfThisPhoto_arr.row}
	{if $CFG.admin.navigation.top}
	<div class="clsCommentsViewVideopaging">
		{$myobj->setTemplateFolder('general/','photo')}
	    {include file='pagination.tpl'}
	</div>
	{/if}
	{foreach key=cmKey item=cmValue from=$populateCommentOfThisPhoto_arr.row}
		<div class="clsListContents" id="cmd{$cmValue.record.photo_comment_id}">
	        <div class="clsOverflow clsViewCommentList">
	            <div class="clsCommentThumb">
	                <div class="clsThumbImageLink">
	                    <a href="{$cmValue.memberProfileUrl}" class="Cls45x45 clsImageHolder clsUserThumbImageOuter clsPointer">
	                        <img src="{$cmValue.icon.s_url}" title="{$cmValue.name}" alt="{$cmValue.name|truncate:5}" {$myobj->DISP_IMAGE(45, 45, $cmValue.icon.s_width, $cmValue.icon.s_height)}/>
	                    </a>
	                </div>
	            </div>
	          <div class="clsCommentDetails">
	                {$myobj->setTemplateFolder('general/', 'photo')}
	                {include file="box.tpl" opt="viewcomments_top"}
	                          <div class="clsViewPhotoComment clsOverflow">
	                            <p class="clsCommentedBy"> <a href="{$cmValue.memberProfileUrl}" title="{$cmValue.name}">{$cmValue.name}</a><span class="clsLinkSeperator">|</span>
	                            {*----- {$LANG.viewphoto_commented_label} --------*}
	                            <span>{$cmValue.record.pc_date_added}</span>
	                            </p>
	                          </div>
	                   		 <p id="selEditCommentTxt_{$cmValue.record.photo_comment_id}" class="clsPhotoCommentDisplay">{$cmValue.makeClickableLinks}</p>
	             	        <div class="" id="selEditComments_{$cmValue.record.photo_comment_id}"></div>
	                            <div>
	                            {if isMember() and $cmValue.record.comment_user_id == $CFG.user.user_id}
	                                <div class="clsButtonHolder clsOverflow">
	                                    <p class="clsEditButton" id="selViewEditComment_{$cmValue.record.photo_comment_id}" ><span><a href="javascript:void(0)" onClick="return callAjaxEdit('{$CFG.site.url}photo/viewPhoto.php?ajax_page=true&amp;page=comment_edit&amp;photo_id={$myobj->getFormField('photo_id')}&amp;vpkey={$myobj->getFormField('vpkey')}&amp;show={$myobj->getFormField('show')}','{$cmValue.record.photo_comment_id}')" title="{$LANG.viewphoto_edit_label}">{$LANG.viewphoto_edit_label}</a></span></p>
	                                    <p class="clsDeleteButton" id="selViewDeleteComment_{$cmValue.record.photo_comment_id}"><span><a href="javascript:void(0)" onclick="return Confirmation('selMsgConfirmWindow', 'msgConfirmform', Array('comment_id', 'confirmationMsg', 'commentorreply'), Array('{$cmValue.record.photo_comment_id}', '{$LANG.viewphoto_comment_delete_confirmation}', 'deletecomment'), Array('value', 'html', 'value'))" title="{$LANG.viewphoto_deleted_label}">{$LANG.viewphoto_deleted_label}</a></span></p>
	                                </div>
	                            {/if}
	                            {if isMember() and $cmValue.record.comment_user_id != $CFG.user.user_id}
                                    <div id="selAddComments_{$cmValue.record.photo_comment_id}" style="display:none;" class="clsEditCommentTextArea clsReplyCommentTextArea">
                                        <textarea name="comment_{$cmValue.record.photo_comment_id}" id="comment_{$cmValue.record.photo_comment_id}" rows="5" cols="91"></textarea>
                                        <div class="clsButtonHolder clsPaddingLeft10">		    
                                            <p class="clsEditButton">
                                                <span>	
                                                    <input type="button" onClick="return addToReply('{$cmValue.record.photo_comment_id}', '{$CFG.site.url}photo/viewPhoto.php?ajax_page=true&page=post_comment&photo_id={$myobj->getFormField('photo_id')}&vpkey={$myobj->getFormField('vpkey')}&show={$myobj->getFormField('show')}')" name="post_comment" id="post_comment" tabindex="{smartyTabIndex}" value="{$LANG.postcomment_post_comment}" />
                                                </span>
                                            </p>
                                            <p class="clsDeleteButton">
                                                <span>
                                                <input type="button" onClick="return discardReply('selAddComments_{$cmValue.record.photo_comment_id}', '{$cmValue.record.photo_comment_id}')" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.postcomment_cancel}" />
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                <div class="clsButtonHolder">
                                    <p class="{if (isMember() and $cmValue.record.comment_user_id != $CFG.user.user_id)&&($myobj->getFormField('user_id') == $CFG.user.user_id)}  clsEditButton {else} clsReplyButton {/if}" id="selViewPostComment_{$cmValue.record.photo_comment_id}">
                                        <span><a href="javascript:void(0)" onclick="showReplyToCommentsOption('selAddComments_{$cmValue.record.photo_comment_id}');" title="{$LANG.viewphoto_reply_comment}">{$LANG.viewphoto_reply_comment}</a>  
                                        </span>
                                    </p>
                                    {if isMember() and $cmValue.record.comment_user_id != $CFG.user.user_id}
                                        {if $myobj->getFormField('user_id') == $CFG.user.user_id}
                                            <p class="clsDeleteButton" id="selViewDeleteComment_{$cmValue.record.photo_comment_id}">
                                                <span>
                                                <a href="javascript:;" onclick="return Confirmation('selMsgConfirmWindow', 'msgConfirmform', Array('comment_id', 'confirmationMsg', 'commentorreply'), Array('{$cmValue.record.photo_comment_id}', '{$LANG.viewphoto_comment_delete_confirmation}', 'deletecomment'), Array('value', 'html', 'value'))" title="{$LANG.viewphoto_deleted_label}">{$LANG.viewphoto_deleted_label}</a>
                                                </span>
                                            </p>
                                        {/if}
                                    {/if}
                                </div>
	                            {/if}
                                </div>
                                <div id="selReplyForComments_{$cmValue.record.photo_comment_id}">
                                    {include file='populateReplyForCommentsOfThisPhoto.tpl'}
                                </div>
	                {$myobj->setTemplateFolder('general/', 'photo')}
	               {include file="box.tpl" opt="viewcomments_bottom"}
	             </div>
	          </div>

	    </div>
	{/foreach}
	{if $CFG.admin.navigation.bottom}
		{$myobj->setTemplateFolder('general/','photo')}
	    {include file='pagination.tpl'}
	{/if}
{else}
	<div class="clsListContents">
		<p class="clsNoRecordsFound">{$LANG.no_comments_for_this_photo}</p>
 	</div>
{/if}
</form>