
<form name="frmVideoComments" id="frmVideoComments" action="{$myobj->getCurrentUrl()}">


{if isset($populateCommentOfThisArticle_arr.hidden_arr) and $populateCommentOfThisArticle_arr.hidden_arr}
	{$myobj->populateHidden($populateCommentOfThisArticle_arr.hidden_arr)}
{/if}


{if isset($populateCommentOfThisArticle_arr.row) and $populateCommentOfThisArticle_arr.row}
	{if $CFG.admin.navigation.top}
	<div class="clsCommentsViewVideopaging">
		{$myobj->setTemplateFolder('general/','article')}
	    {include file='pagination.tpl'}
	</div>
	{/if}
	<table class="clsTable100" summary="{$LANG.viewarticle_tbl_summary}" id="selVideoCommentTable">
		{foreach key=cmKey item=cmValue from=$populateCommentOfThisArticle_arr.row}

            <tr class="{$cmValue.class}" id="cmd{$cmValue.record.article_comment_id}">
	        	<td>
	            	<div class="clsCommentContainer">
	            	    {*<div id="commentUserProfile_{$cmValue.record.article_comment_id}" class="clsCoolMemberActive"  style="display:none;" onmouseover="showUserInfoPopup('{$myobj->getUrl('userdetail')}', '{$cmValue.record.comment_user_id}', 'commentUserProfile_{$cmValue.record.article_comment_id}','L');" onmouseout="hideUserInfoPopup('commentUserProfile_{$cmValue.record.article_comment_id}')"></div>*}

                        <div id="commentUserProfile_{$cmValue.record.article_comment_id}" class="clsCoolMemberActive"  style="display:none;" ></div>

	                    <div class="clsCommentImage">
	                       {* <a href="{$cmValue.memberProfileUrl}" onmouseover="showUserInfoPopup('{$myobj->getUrl('userdetail')}', '{$cmValue.record.comment_user_id}', 'commentUserProfile_{$cmValue.record.article_comment_id}','L');" onmouseout="hideUserInfoPopup('commentUserProfile_{$cmValue.record.article_comment_id}')" class="Cls45x45 ClsImageBorder1 ClsImageContainer"> *}
                            <a href="{$cmValue.memberProfileUrl}" class="Cls45x45 ClsImageBorder1 ClsImageContainer">
					    		<img src="{$cmValue.icon.s_url}" title="{$cmValue.name}" alt="{$cmValue.name|truncate:5}"  {$myobj->DISP_IMAGE(45, 45, $cmValue.icon.s_width, $cmValue.icon.s_height)} />
	                        </a>
	                    </div>
						<div class="clsCommentContent">
                            {$myobj->setTemplateFolder('general/','article')}
                            {include file='box.tpl' opt='viewcommentsreply_top'}
                                <p class="clsMembersName"><a href="{$cmValue.comment_member_profile_url}">{$cmValue.name}</a> <span class="clsLinkSeperator">|</span> <span>{$cmValue.record.pc_date_added}</span></p>
                                <div  id="cmd{$cmValue.record.article_comment_id}_1">
                                    <div class="clsCommentDiv">
                                        <p id="selEditCommentTxt_{$cmValue.record.article_comment_id}" class="clsReplyValue">{$cmValue.makeClickableLinks}</p>
                                        <p class="clsEditCommentTextArea" id="selEditComments_{$cmValue.record.article_comment_id}" style="display:none;"></p>
                                        <div class="clsOverflow">
                                        	<div id="selAddComments_{$cmValue.record.article_comment_id}" style="display:none;" class="clsEditCommentTextArea clsButtonHolder">
                                                <table>
                                                    <tr>
                                                        <td class="clsReplyTextAreaWidth"><textarea name="comment_{$cmValue.record.article_comment_id}" id="comment_{$cmValue.record.article_comment_id}" rows="5" cols="90"></textarea></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="clsSaveBtn">
                                                            <p class="clsEditButton">
                                                               <span> <input type="button" onClick="return addToReply('{$cmValue.record.article_comment_id}', '{$CFG.site.url}article/viewArticle.php?ajax_page=true&article_id={$myobj->getFormField('article_id')}&vpkey={$myobj->getFormField('vpkey')}&show={$myobj->getFormField('show')}')" name="post_comment" id="post_comment" tabindex="{smartyTabIndex}" value="{$LANG.postcomment_post_comment}" /></span>
                                                            </p>
                                                            <p class="clsDeleteButton">
                                                               <span> <input type="button" onClick="return discardReply('selAddComments_{$cmValue.record.article_comment_id}', '{$cmValue.record.article_comment_id}')" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.postcomment_cancel}" /></span>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="clsButtonHolder">
                                                {if isMember() and $cmValue.record.comment_user_id == $CFG.user.user_id}
                                                    <p id="selViewEditComment_{$cmValue.record.article_comment_id}" class="clsEditButton">
                                                        <span>
                                                            <a href="javascript:void(0)" onClick="return callAjaxEdit('{$CFG.site.url}article/viewArticle.php?ajax_page=true&amp;article_id={$myobj->getFormField('article_id')}&amp;vpkey={$myobj->getFormField('vpkey')}&amp;show={$myobj->getFormField('show')}','{$cmValue.record.article_comment_id}')">{$LANG.viewarticle_edit}</a>
                                                        </span>
                                                    </p>
                                                    <p id="selViewDeleteComment_{$cmValue.record.article_comment_id}" class="clsDeleteButton">
                                                        <span>
                                                            <a class="clsButton4" href="javascript:void(0)" onClick="return Confirmation('selMsgConfirmWindow', 'msgConfirmform', Array('comment_id', 'confirmationMsg', 'commentorreply'), Array('{$cmValue.record.article_comment_id}', '{$LANG.viewarticle_confirm_txt}', 'deletecomment'), Array('value', 'html', 'value'))">{$LANG.viewarticle_delete}</a>
                                                        </span>
                                                    </p>
                                                {/if}
                                                {if isMember() and $cmValue.record.comment_user_id != $CFG.user.user_id}
                                                    <p class="{if (isMember() and $cmValue.record.comment_user_id != $CFG.user.user_id)&&($myobj->getFormField('user_id') == $CFG.user.user_id)}  clsEditButton {else} clsReplyButton {/if}" id="selViewPostComment_{$cmValue.record.article_comment_id}">
                                                        <span>
                                                            <a href="javascript:void(0)" onclick="showReplyToCommentsOption('selAddComments_{$cmValue.record.article_comment_id}');" title="{$LANG.viewarticle_reply_comment}">{$LANG.viewarticle_reply_comment}
                                                            </a>
                                                        </span>
                                                    </p>
                                                {/if}
                                                {if isMember() and $cmValue.record.comment_user_id != $CFG.user.user_id}
                                                    {if $myobj->getFormField('user_id') == $CFG.user.user_id}
                                                    <p id="selViewDeleteComment_{$cmValue.record.article_comment_id}">
                                                        <span>
                                                            <a class="clsButton4" href="javascript:void(0)" onClick="return Confirmation('selMsgConfirmWindow', 'msgConfirmform', Array('comment_id', 'confirmationMsg', 'commentorreply'), Array('{$cmValue.record.article_comment_id}', '{$LANG.viewarticle_confirm_txt}', 'deletecomment'), Array('value', 'html', 'value'))">{$LANG.viewarticle_delete}</a>
                                                        </span>
                                                    </p>
                                                    {/if}
                                                {/if}
                                            </div>
                                        </div>
                                        <div id="selReplyForComments_{$cmValue.record.article_comment_id}">
                                            {include file='populateReplyForCommentsOfThisArticle.tpl'}
                                        </div>
                                    </div>
                                </div>
                        {$myobj->setTemplateFolder('general/','article')}
                        {include file='box.tpl' opt='viewcommentsreply_bottom'}
	             		</div>
				 	</div>
	            </td>
	        </tr>
	    {/foreach}
	</table>
	{if $CFG.admin.navigation.bottom}
		{$myobj->setTemplateFolder('general/','article')}
	    {include file='pagination.tpl'}
	{/if}
{else}
	<table class="clsTable100" summary="{$LANG.viewarticle_tbl_summary}" id="selVideoCommentTable">
        <tr>
        	<td>
            	<div class="clsCommentContainer clsNoArticlesFound">
            		<p>{$LANG.viewarticle_no_comments_found}</p>
			 	</div>
            </td>
        </tr>
	</table>
{/if}
</form>
