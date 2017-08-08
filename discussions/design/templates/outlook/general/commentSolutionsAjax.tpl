{if $myobj->isShowPageBlock('show_option_to_comment')}
	{if  !isMember()}
		Session Expired. <a href="{$CFG.auth.login_url}'?r">Login to continue..!</a>
	{/if}
	<form name="formComment{$c_solution_id}" id="formComment{$c_solution_id}" method="post">
		<div class="clsClearFix clsClearLeft clsreplycomment">
			<div class="clsYourComment">{$LANG.comment_solutions}<span class="clsRequired">{$myobj->displayCompulsoryIcon()}</span></div>
			<div>
			  	<p id="validReply{$c_solution_id}" class="LV_validation_message LV_invalid"></p>
				<textarea name="user_comment" id="user_reply" class="clsCommentTextArea selInputLimiter" tabindex="{smartyTabIndex}" maxlength="{$CFG.admin.comment.limit}" maxlimit="{$CFG.admin.comment.limit}" rows="10" cols="100" ></textarea>{$myobj->getFormFieldElementErrorTip('user_comment')}
			</div>
		    <div>
				<input type="hidden" name="act" id="act" value="comment" />
				<input type="hidden" name="c_solution_id" id="c_solution_id" value="{$c_solution_id}" />
				<input type="hidden" name="start" id="start" value="{$myobj->getFormField('start')}" />
				<input type="hidden" name="c_seo_title" id="c_seo_title" value="{$myobj->getFormField('c_seo_title')}" />
				<input type="hidden" name="c_qid" id="c_qid" value="{$myobj->getFormField('c_qid')}" />
				<div id="selProcessingRequest"></div>
				<div id="commenHide_{$c_solution_id}">
				<p class="clsCommentBtnReplay">
		        <span>
					<input type="button" class="clsCommentSubmitButton" name="post_comment" id="post_valuess{$c_solution_id}" onclick="c = chkMessage('user_reply','formComment{$c_solution_id}');if(c == 0)processingRequestForComment('commenHide_{$c_solution_id}','cancel_comment', 'selProcessingRequest');ajaxDiscuzzSubmitForm('{$showOptionToComment_arr.submit.onclick}', 'formComment{$c_solution_id}', 'msg{$commentSpanIDId}', '{$c_solution_id}');hideAllBlocks(); return false;" value="{$LANG.discuzz_common_submit}" tabindex="{smartyTabIndex}" />
		            </span>
		            </p>
		        <p class="clsCommentBtnCancel">
		        <span>
					<input type="button" class="clsCommentCancelButton" name="cancel_comment" id="cancel_comment" onclick="ajaxUpdateDiv('{$showOptionToComment_arr.cancel.onclick}', '&ajax_page=true&cancelOptionToComment=1&c_solution_id={$c_solution_id}', '{$commentSpanIDId}'); return false;" value="{$LANG.common_cancel}" tabindex="{smartyTabIndex}" />
		             </span>
		            </p>
		        </div>

			</div>
		</div>
	</form>
	{literal}
		<script language="javascript" type="text/javascript">
		$Jq(document).ready(function(){
			$Jq('#user_comment', $Jq({/literal}'#{$commentSpanIDId}'{literal})).inputlimiter({
				limit: $Jq('#user_comment', $Jq({/literal}'#{$commentSpanIDId}'{literal})).attr('maxlimit'),
				remText: LANG_JS_common_remaining_char_count,
				remFullText: LANG_JS_common_stop_typing_after_reached_limit,
				limitText: LANG_JS_common_allowed_char_limit
			});
		});
		<script>
	{/literal}
{/if}