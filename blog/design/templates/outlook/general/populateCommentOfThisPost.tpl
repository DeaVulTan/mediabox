<form name="frmVideoComments" id="frmVideoComments" action="{$myobj->getCurrentUrl()}">
{if isset($populateCommentOfThisPost_arr.hidden_arr) and $populateCommentOfThisPost_arr.hidden_arr}
	{$myobj->populateHidden($populateCommentOfThisPost_arr.hidden_arr)}
{/if}
{if isset($populateCommentOfThisPost_arr.row) and $populateCommentOfThisPost_arr.row} 
	{if $CFG.admin.navigation.top}
	<div class="clsCommentsViewVideopaging">
		{$myobj->setTemplateFolder('general/','blog')}
	    {include file='pagination.tpl'}
	</div>
	{/if}
	<table class="clsTable100" summary="{$LANG.viewpost_tbl_summary}" id="selVideoCommentTable">
		{foreach key=cmKey item=cmValue from=$populateCommentOfThisPost_arr.row}
	        <tr class="{$cmValue.class}" id="cmd{$cmValue.record.blog_comment_id}">
	        	<td>
	            	<div class="clsCommentContainer">
	            	    <div id="commentUserProfile_{$cmValue.record.blog_comment_id}" class="clsCoolMemberActive"  style="display:none;" onmouseover="showUserInfoPopup('{$myobj->getUrl('userdetail')}', '{$cmValue.record.comment_user_id}', 'commentUserProfile_{$cmValue.record.blog_comment_id}','L');" onmouseout="hideUserInfoPopup('commentUserProfile_{$cmValue.record.blog_comment_id}')"></div>
	                    <div class="clsCommentImage">
	                        <div class="" onclick="Redirect2URL('{$cmValue.memberProfileUrl}')" >
					    		<a href="#" class="Cls45x45 ClsImageBorder1 ClsImageContainer"><img border="0" src="{$cmValue.icon.m_url}" title="{$cmValue.name}"  {$myobj->DISP_IMAGE(45, 45, $cmValue.icon.s_width, $cmValue.icon.s_height)} /></a>
	                        </div>
	                    </div>
						<div class="clsCommentContent">
						{$myobj->setTemplateFolder('general/','blog')}
         				{include file='box.tpl' opt='blogcomments_top'}
	                        <p class="clsMembersName"><a href="{$cmValue.comment_member_profile_url}">{$cmValue.name}</a><span class="clsLinkSeperator">|</span><span>{$cmValue.record.pc_date_added}</span></p>
	                        <div  id="cmd{$cmValue.record.blog_comment_id}_1">
	                            <div class="clsCommentDiv">
	                    			<p id="selEditCommentTxt_{$cmValue.record.blog_comment_id}" class="clsBlogCommentDisplay">{$cmValue.makeClickableLinks}</p>
	                    			<p class="clsEditCommentTextArea" id="selEditComments_{$cmValue.record.blog_comment_id}"></p>
	                        		<div class="clsOverflow">
	                        			{if isMember() and $cmValue.record.comment_user_id == $CFG.user.user_id}
	                                		<div class="clsEditComment">
	                                        	<p class="clsCommentsReplySection clsCommentsSectionReply">
	                                            	<span id="selViewEditComment_{$cmValue.record.blog_comment_id}" class="">
	                                                	<a href="javascript:void(0)" onClick="return callAjaxEdit('{$CFG.site.url}blog/viewPost.php?ajax_page=true&amp;blog_id={$myobj->getFormField('blog_id')}&amp;vpkey={$myobj->getFormField('vpkey')}&amp;show={$myobj->getFormField('show')}','{$cmValue.record.blog_comment_id}')">{$LANG.viewpost_edit_label}</a>
	                                            	</span>
	                                        	</p>
	                                		</div>
											<div>
	                                    		<p class="clsCommentsReplySection">
	                                        		<span id="selViewDeleteComment_{$cmValue.record.blog_comment_id}"><a class="clsButton4" href="javascript:void(0)" onClick="return Confirmation('selMsgConfirmWindow', 'msgConfirmform', Array('comment_id', 'confirmationMsg', 'commentorreply'), Array('{$cmValue.record.blog_comment_id}', '{$LANG.viewpost_confirm_txt}', 'deletecomment'), Array('value', 'html', 'value'))">{$LANG.viewpost_deleted_label}</a>
	                                        		</span>
	                                    		</p>
	                                		</div>
	                           			{elseif isMember()}
	                                        <div>
												<div id="selAddComments_{$cmValue.record.blog_comment_id}" style="display:none;">
												<div class="clsBlogEditTextAreaSection">
													<table class="clsTable100">
														<tr>
													    	<td><textarea class="clsWidth99" name="comment_{$cmValue.record.blog_comment_id}" id="comment_{$cmValue.record.blog_comment_id}" rows="5" cols="80"></textarea></td>
													    </tr>
													    <tr>
													    	<td colspan="2">
																<div class="clsButtonHolder">
																	<p class="clsCommentsSectionReply">
																	<input class="clsCommentDiscard" type="button" onClick="return addToReply('{$cmValue.record.blog_comment_id}', '{$CFG.site.url}blog/viewPost.php?ajax_page=true&blog_id={$myobj->getFormField('blog_id')}&blog_post_id={$myobj->getFormField('blog_post_id')}&vpkey={$myobj->getFormField('vpkey')}&show={$myobj->getFormField('show')}')" name="post_comment" id="post_comment" tabindex="{smartyTabIndex}" value="{$LANG.postcomment_post_comment}" /></p>
																	<p>
																<input class="clsCommentDiscard" type="button" onClick="return discardReply('selAddComments_{$cmValue.record.blog_comment_id}', '{$cmValue.record.blog_comment_id}')" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.postcomment_cancel}" />
																</p>
																</div>
													    	</td>
													    </tr>
													</table>
													</div>
												</div>
												<div class="clsOverflow">
												<p class="clsCommentsReplySection">
		                                            <span id="selViewPostComment_{$cmValue.record.blog_comment_id}" class=""><a href="javascript:void(0)" onclick="showReplyToCommentsOption('selAddComments_{$cmValue.record.blog_comment_id}');" title="{$LANG.viewblog_reply_comment}">{$LANG.viewpost_reply_comment}</a>
		                                            </span>
		                                        </p>
												</div>
	                                    		
											</div>
		                          		{/if}
	                        			{if isMember() and $cmValue.record.comment_user_id != $CFG.user.user_id}
				                            {if $myobj->getFormField('user_id') == $CFG.user.user_id}
				                                <div>
				                                    <p class="clsCommentsReplySection">
				                                        <span id="selViewDeleteComment_{$cmValue.record.blog_comment_id}">
				                                            <a class="clsButton4" href="javascript:void(0)" onClick="return Confirmation('selMsgConfirmWindow', 'msgConfirmform', Array('comment_id', 'confirmationMsg', 'commentorreply'), Array('{$cmValue.record.blog_comment_id}', '{$LANG.viewpost_confirm_txt}', 'deletecomment'), Array('value', 'html', 'value'))">{$LANG.viewpost_deleted_label}</a>
				                                        </span>
				                                    </p>
				                                </div>
				                            {/if}
	                        			{/if}
	                        		</div>
	                        		<div id="selReplyForComments_{$cmValue.record.blog_comment_id}">
	                        			{include file='populateReplyForCommentsOfThisPost.tpl'}
	                    			</div>
	                    		</div>
	                    	</div>
					{$myobj->setTemplateFolder('general/','blog')}
         			{include file='box.tpl' opt='blogcomments_bottom'}
	             		</div>
				 	</div>
	            </td>
	        </tr>
	    {/foreach}
	</table>
	{if $CFG.admin.navigation.bottom}
		{$myobj->setTemplateFolder('general/','blog')}
	    {include file='pagination.tpl'}
	{/if}
{else}
	<table class="clsTable100" summary="{$LANG.viewpost_tbl_summary}" id="selVideoCommentTable">
        <tr>
        	<td>
            	<div class="clsCommentContainer">
            		<div id="selMsgAlert"><p>{$LANG.no_comments_for_this_post}</p></div>
			 	</div>
            </td>
        </tr>
	</table>
{/if}
</form>