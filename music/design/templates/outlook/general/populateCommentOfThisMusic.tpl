<form name="frmMusicComments" id="frmMusicComments" action="{$myobj->getCurrentUrl()}">
{if isset($populateCommentOfThisMusic_arr.hidden_arr) and $populateCommentOfThisMusic_arr.hidden_arr}
	{$myobj->populateHidden($populateCommentOfThisMusic_arr.hidden_arr)}
{/if}
{if isset($populateCommentOfThisMusic_arr.row) and $populateCommentOfThisMusic_arr.row}
	{if $CFG.admin.navigation.top}
	<div class="clsCommentsViewVideopaging">
		{$myobj->setTemplateFolder('general/','music')}
	    {include file='pagination.tpl'}
	</div>
	{/if}
	{foreach key=cmKey item=cmValue from=$populateCommentOfThisMusic_arr.row}
		<div class="clsListContents" id="cmd{$cmValue.record.music_comment_id}">
	        <div class="clsOverflow">
	            <div class="clsCommentThumb">
	                <div class="clsThumbImageLink">
	                    <a href="{$cmValue.memberProfileUrl}" class="ClsImageContainer ClsImageBorder1 Cls45x45">
	                        <img src="{$cmValue.icon.s_url}" title="{$cmValue.name}" {$myobj->DISP_IMAGE(45, 45, $cmValue.icon.s_width, $cmValue.icon.s_height)}/>
						</a>
	                </div>
	            </div>

	            <div class="clsCommentDetails">
					{$myobj->setTemplateFolder('general/', 'music')}
					{include file="box.tpl" opt="comment_top"}
	                <p class="clsCommentedBy"><a href="{$cmValue.memberProfileUrl}" title="{$cmValue.name}">{$cmValue.name}</a> <span class="clsLinkSeperator">|</span> <span>{$cmValue.record.pc_date_added}</span></p>
	                <p id="selEditCommentTxt_{$cmValue.record.music_comment_id}" class="clsMusicCommentDisplay">{$cmValue.makeClickableLinks}</p>
	        		<div class="" id="selEditComments_{$cmValue.record.music_comment_id}"></div>
					
			        	{if isMember() and $cmValue.record.comment_user_id == $CFG.user.user_id}
						<div class="clsButtonHolder">
			                <p class="clsEditButton" id="selViewEditComment_{$cmValue.record.music_comment_id}" ><span><a href="javascript:void(0)" onclick="return callAjaxEdit('{$CFG.site.url}music/listenMusic.php?ajax_page=true&amp;page=comment_edit&amp;music_id={$myobj->getFormField('music_id')}&amp;vpkey={$myobj->getFormField('vpkey')}&amp;show={$myobj->getFormField('show')}','{$cmValue.record.music_comment_id}')" title="{$LANG.viewmusic_edit_label}">{$LANG.viewmusic_edit_label}</a></span></p>
			                <p class="clsDeleteButton" id="selViewDeleteComment_{$cmValue.record.music_comment_id}"><span><a href="javascript:void(0)" onclick="return Confirmation('selMsgConfirmWindow', 'msgConfirmform', Array('comment_id', 'confirmationMsg', 'commentorreply'), Array('{$cmValue.record.music_comment_id}', '{$LANG.viewmusic_confirm_txt}', 'deletecomment'), Array('value', 'html', 'value'))" title="{$LANG.viewmusic_deleted_label}">{$LANG.viewmusic_deleted_label}</a></span></p>
							</div>
			        	{/if}
						{if isMember() and $cmValue.record.comment_user_id != $CFG.user.user_id}
	                		<div id="selAddComments_{$cmValue.record.music_comment_id}" style="display:none;" class="clsEditCommentTextArea clsReplyCommentTextArea">
								<textarea name="comment_{$cmValue.record.music_comment_id}" id="comment_{$cmValue.record.music_comment_id}" rows="5" cols="92"></textarea>
							<div class="clsButtonHolder">
               					<p class="clsEditButton"><span>
									<input type="button" onClick="return addToReply('{$cmValue.record.music_comment_id}', '{$CFG.site.url}music/listenMusic.php?ajax_page=true&page=post_comment&music_id={$myobj->getFormField('music_id')}&vpkey={$myobj->getFormField('vpkey')}&show={$myobj->getFormField('show')}')" name="post_comment" id="post_comment" tabindex="{smartyTabIndex}" value="{$LANG.postcomment_post_comment}" /></span></p>
								 <p class="clsDeleteButton"><span>
								      <input type="button" onClick="return discardReply('selAddComments_{$cmValue.record.music_comment_id}', '{$cmValue.record.music_comment_id}')" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.postcomment_cancel}" /></span></p></div>
							</div>
							<div class="clsButtonHolder">
								<p class="{if (isMember() and $cmValue.record.comment_user_id != $CFG.user.user_id)&&($myobj->getFormField('user_id') == $CFG.user.user_id)}  clsEditButton {else} clsReplyButton {/if}" id="selViewPostComment_{$cmValue.record.music_comment_id}">
									<span>
										<a id="viewmusic_reply_comment_{$cmValue.record.music_comment_id}" href="javascript:void(0)" onclick="showReplyToCommentsOption('selAddComments_{$cmValue.record.music_comment_id}');" title="{$LANG.viewmusic_reply_comment}">{$LANG.viewmusic_reply_comment}</a>
									</span>
								</p>
								{if isMember() and $cmValue.record.comment_user_id != $CFG.user.user_id}
								{if $myobj->getFormField('user_id') == $CFG.user.user_id}
									<p class="clsDeleteButton" id="selViewDeleteComment_{$cmValue.record.music_comment_id}">
									<span>
										<a href="javascript:void(0)" onclick="return Confirmation('selMsgConfirmWindow', 'msgConfirmform', Array('comment_id', 'confirmationMsg', 'commentorreply'), Array('{$cmValue.record.music_comment_id}', '{$LANG.viewmusic_confirm_txt}', 'deletecomment'), Array('value', 'html', 'value'))" title="{$LANG.viewmusic_deleted_label}">{$LANG.viewmusic_deleted_label}</a>
									</span>
								   </p>
								{/if}
								{/if}
							</div>
						{/if}
                        <div id="deleteCommentSuccessMsgBlock_{$cmValue.record.music_comment_id}" style="display:none" class="clsSuccessMessage">                   
                        </div>
						<div id="selReplyForComments_{$cmValue.record.music_comment_id}">                        	
							{include file='populateReplyForCommentsOfThisMusic.tpl'}
						</div>
					{$myobj->setTemplateFolder('general/', 'music')}
		     		{include file="box.tpl" opt="comment_bottom"}
	            </div>
	         </div>
	    </div>
	{/foreach}
	{if $CFG.admin.navigation.bottom}
		{$myobj->setTemplateFolder('general/','music')}
	    {include file='pagination.tpl'}
	{/if}
{else}
	<div class="clsNoRecordsFound">
		<p>{$LANG.no_comments_for_this_music}</p>
 	</div>
{/if}
</form>