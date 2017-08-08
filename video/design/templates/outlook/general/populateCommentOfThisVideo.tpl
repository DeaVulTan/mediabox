<form name="frmVideoComments" id="frmVideoComments" action="{$myobj->getCurrentUrl()}">
{if isset($populateCommentOfThisVideo_arr.hidden_arr) and $populateCommentOfThisVideo_arr.hidden_arr}
	{$myobj->populateHidden($populateCommentOfThisVideo_arr.hidden_arr)}
{/if}
{if isset($populateCommentOfThisVideo_arr.row) and $populateCommentOfThisVideo_arr.row}
	{if $CFG.admin.navigation.top}
	<div class="clsCommentsViewVideopaging">
		{$myobj->setTemplateFolder('general/','video')}
	    {include file='pagination.tpl'}
	</div>
	{/if}
	<table class="clsTable100" summary="{$LANG.viewvideo_tbl_summary}" id="selVideoCommentTable">
		{foreach key=cmKey item=cmValue from=$populateCommentOfThisVideo_arr.row}
	        <tr class="{$cmValue.class}" id="cmd{$cmValue.record.video_comment_id}">
	        	<td>
	            	<div class="clsCommentContainer">
	            	    <div id="commentUserProfile_{$cmValue.record.video_comment_id}" class="clsCoolMemberActive"  style="display:none;" ></div>
	                    <div class="clsCommentImage">
	                        <div class=""  >
					    		<a href="{$cmValue.memberProfileUrl}" class="Cls45x45 ClsImageBorder1 ClsImageContainer"><img src="{$cmValue.icon.s_url}" border="0" title="{$cmValue.name|truncate:5}"  {$myobj->DISP_IMAGE(45, 45, $cmValue.icon.s_width, $cmValue.icon.s_height)} /></a>
	                        </div>
	                    </div>
						<div class="clsCommentContent">
						{$myobj->setTemplateFolder('general/','video')}
         				{include file='box.tpl' opt='viewvideocomments_top'}
	                        <p class="clsMembersName"><a href="{$cmValue.comment_member_profile_url}">{$cmValue.name}</a><span class="clsLinkSeperator">|</span><span>{$cmValue.record.pc_date_added}</span></p>
	                        <div  id="cmd{$cmValue.record.video_comment_id}_1">
	                            <div class="clsCommentDiv">
	                    			<p id="selEditCommentTxt_{$cmValue.record.video_comment_id}" class="clsVideoCommentDisplay">{$cmValue.makeClickableLinks}</p>
	                    			<p id="selEditComments_{$cmValue.record.video_comment_id}"></p>
	                        		<div class="clsOverflow">
	                        			{if isMember() and $cmValue.record.comment_user_id == $CFG.user.user_id}
	                                		<div class="clsEditComment">
	                                        	<p class="clsCommentsReplySection clsCommentsSectionReply">
	                                            	<span id="selViewEditComment_{$cmValue.record.video_comment_id}" class="clsViewPostComment">
	                                                	<a href="javascript:void(0)" onClick="return callAjaxEdit('{$CFG.site.url}video/viewVideo.php?ajax_page=true&amp;video_id={$myobj->getFormField('video_id')}&amp;vpkey={$myobj->getFormField('vpkey')}&amp;show={$myobj->getFormField('show')}','{$cmValue.record.video_comment_id}')">{$LANG.viewvideo_edit}</a>
	                                            	</span>
	                                        	</p>
	                                		</div>
											<div>
	                                    		<p class="clsCommentsReplySection">
	                                        		<span id="selViewDeleteComment_{$cmValue.record.video_comment_id}">
	                                            		<a class="clsButton4" href="javascript:void(0)" onClick="return Confirmation('selMsgConfirmWindow', 'msgConfirmform', Array('comment_id', 'confirmationMsg', 'commentorreply'), Array('{$cmValue.record.video_comment_id}', '{$LANG.viewvideo_confirm_txt}', 'deletecomment'), Array('value', 'html', 'value'))">{$LANG.viewvideo_delete}</a>
	                                        		</span>
	                                    		</p>
	                                		</div>
	                           			{elseif isMember()}
	                                        <div>
											<div id="selAddComments_{$cmValue.record.video_comment_id}" style="display:none;">
													<div class="clsEditCommentTextAreaComment">
													<table class="clsTable100">
														<tr>
													    	<td><textarea class="clsWidth99" name="comment_{$cmValue.record.video_comment_id}" id="comment_{$cmValue.record.video_comment_id}" rows="5" cols="80"></textarea></td>
													    </tr>
													    <tr>
													    	<td colspan="2">
																<div class="clsButtonHolder">
																	<p class="clsCommentsSectionReply">
																		<input class="clsCommentDiscard" type="button" onClick="return addToReply('{$cmValue.record.video_comment_id}', '{$CFG.site.url}video/viewVideo.php?ajax_page=true&video_id={$myobj->getFormField('video_id')}&vpkey={$myobj->getFormField('vpkey')}&show={$myobj->getFormField('show')}')" name="post_comment" id="post_comment" tabindex="{smartyTabIndex}" value="{$LANG.postcomment_post_comment}" /></p><p><input class="clsCommentDiscard" type="button" onClick="return discardReply('selAddComments_{$cmValue.record.video_comment_id}', '{$cmValue.record.video_comment_id}')" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.postcomment_cancel}" /></p></div>
													    	</td>
													    </tr>
													</table>
													</div>
												</div>
												<div class="clsOverflow">
												<p class="clsCommentsReplySection">
		                                            <span id="selViewPostComment_{$cmValue.record.video_comment_id}" class="clsViewPostComment">
		                                                <a href="javascript:void(0)" onclick="showReplyToCommentsOption('selAddComments_{$cmValue.record.video_comment_id}');" title="{$LANG.viewvideo_reply_comment}">{$LANG.viewvideo_reply_comment}</a>
		                                            </span>
		                                        </p>
												</div>

											</div>
		                          		{/if}
	                        			{if isMember() and $cmValue.record.comment_user_id != $CFG.user.user_id}
				                            {if $myobj->getFormField('user_id') == $CFG.user.user_id}
				                                <div>
				                                    <p class="clsCommentsReplySection">
				                                        <span id="selViewDeleteComment_{$cmValue.record.video_comment_id}">
				                                            <a class="clsButton4" href="javascript:void(0)" onClick="return Confirmation('selMsgConfirmWindow', 'msgConfirmform', Array('comment_id', 'confirmationMsg', 'commentorreply'), Array('{$cmValue.record.video_comment_id}', '{$LANG.viewvideo_confirm_txt}', 'deletecomment'), Array('value', 'html', 'value'))">{$LANG.viewvideo_delete}</a>
				                                        </span>
				                                    </p>
				                                </div>
				                            {/if}
	                        			{/if}
	                        		</div>
	                        		<div id="selReplyForComments_{$cmValue.record.video_comment_id}">
	                        			{include file='populateReplyForCommentsOfThisVideo.tpl'}
	                    			</div>
	                    		</div>
	                    	</div>
					{$myobj->setTemplateFolder('general/','video')}
         			{include file='box.tpl' opt='viewvideocomments_bottom'}
	             		</div>
				 	</div>
	            </td>
	        </tr>
	    {/foreach}
	</table>
	{if $CFG.admin.navigation.bottom}
		{$myobj->setTemplateFolder('general/','video')}
	    {include file='pagination.tpl'}
	{/if}
{else}
	<table class="clsTable100" summary="{$LANG.viewvideo_tbl_summary}" id="selVideoCommentTable">
        <tr>
        	<td>
            	<div class="clsCommentContainer clsNoRecordsFound">
            		<p>{$LANG.no_comments_for_this_video}</p>
			 	</div>
            </td>
        </tr>
	</table>
{/if}
</form>