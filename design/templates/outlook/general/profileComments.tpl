{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selPostProfileComment">
  	<div class="clsPageHeading"><h2>{if $myobj->isValidUserId()}<a href="{$myobj->profile_url}">{$myobj->page_title}</a>{/if}&nbsp;{$LANG.profile_post_comment_title}</h2></div>
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
			<input type="submit" class="clsSubmitButton" name="remove_comments" id="remove_comments" tabindex="{smartyTabIndex}" value="{$LANG.common_yes_option}" />&nbsp;
			<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_no_option}" onclick="return hideAllBlocks();" />
			<input type="hidden" name="comments" id="comments" />
			<input type="hidden" name="action" id="action" />
		</form>
	</div>
{include file='information.tpl'}
{if $myobj->isShowPageBlock('form_post_comment') }

			<div id="selCommentForm" class="clsDataTable">
			<form name="comment_form" id="comment_form" method="post" action="{$myobj->getCurrentUrl()}">
		    	<table summary="{$LANG.profile_post_comment_tbl_summary}" class="clsPostCommentTable">
					<tr>
		         		<td class="{$myobj->getCSSFormLabelCellClass('comment')}">
							<span class="clsMandatoryFieldIcon">{$LANG.profile_post_comment_important}</span><label for="comment">{$LANG.profile_post_comment_comment} </label>
						</td>
						<td class="{$myobj->getCSSFormFieldCellClass('comment')}">
							<textarea name="comment" id="comment" tabindex="{smartyTabIndex}" style="width:90%" rows="4" cols="50" class="selInputLimiter"  maxlimit="{$myobj->CFG.profile.scraps_total_length}">{$myobj->getFormField('comment')}</textarea>
                            {$myobj->getFormFieldErrorTip('comment')}
                            {$myobj->ShowHelpTip('comment')}
						</td>
					</tr>
					<tr>
                    	<td></td>
						<td class="clsFormFieldCellDefault">
							<input type="hidden" name="user_id" value="{$myobj->form_post_comment.user_id}" />
							<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="comment_submit" id="comment_submit" tabindex="{smartyTabIndex}" value="{$LANG.profile_post_comment_post_comment}" /></div></div><div class="clsCancelLeft"><div class="clsCancelRight">
							<input class="clsSubmitButton" onclick="location='{$myobj->form_post_comment.MemberProfileUrl}';" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.profile_post_comment_cancel}" type="button" /></div></div>
						</td>
					</tr>
				</table>
			</form>
			</div>
{/if}
{if $myobj->isShowPageBlock('form_view_comments') }
{if $myobj->isResultsFound()}
{assign var=count value=1}
  <p class="clsGoBackLink" id="goBack"><a href="{$myobj->form_post_comment.MemberProfileUrl}">{$LANG.profile_comment_link_user_profile}</a></p>
  <form name="formProfileComment" id="formProfileComment" method="post" action="{$myobj->getCurrentUrl()}">
			 {if $CFG.admin.navigation.top}
        		 {include file='pagination.tpl'}
    		 {/if}
    <div class="clsDataTable clsMembersDataTable">
    <table summary="{$LANG.profile_comment_listing}">
    	<tr>
        <th><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all"  onclick="CheckAll(document.formProfileComment.name, document.formProfileComment.check_all.name)" value="" /></th>
        <th>{$LANG.profile_post_comment_from}</th>
        <th>{$LANG.profile_post_comment_date}</th>
        <th>{$LANG.profile_comment}</th>
        </tr>

      {foreach key=item item=value from=$myobj->form_view_comments.display_comments}
      <tr class="{if $count % 2 == 0} clsAlternateRecord{/if}">
      	<td class="clsWidth20">
        	{if $value.editable}
      			<input type="checkbox" class="clsCheckRadio" name="comments[]" value="{$value.users_profile_comment_id}"  onclick="disableHeading('formProfileComment');"/>
             {/if}
        </td>
        <td class="clsWidth80">
			<div class="clsOverflow">
                <a href="{$value.MemberProfileUrl}" class="ClsImageContainer ClsImageBorder2 Cls66x66">
                    <img src="{$value.profileIcon.s_url}" alt="{$value.user_name|truncate:7}" title="{$value.user_name}" {$myobj->DISP_IMAGE(#image_small_width#, #image_small_height#, $value.profileIcon.s_width, $value.profileIcon.s_height)}/>
                </a>
            </div>
            <p  class="clsProfileThumbImg clsProfileComments">
            	<a href="{$value.MemberProfileUrl}">{$value.user_name}</a>
            </p>
        </td>
	    <td class="clsWidth90 clsMailDateWidth"><p>{$value.comment_date|date_format:#format_datetime#}</p></td>
	    <td>
	    	  <div class="clsImageReSize"><p>{$value.comment}</p></div>
		</td>
      </tr>
	  {assign var=count value=$count+1}
      {/foreach}
      {if $myobj->found}
      	<tr>
      		<td>&nbsp;</td>
        	<td colspan="3">
            	<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="button" class="clsSubmitButton" name="remove_submit" id="remove_submit" value="{$LANG.profile_comment_submit_delete}"  onclick="if(getMultiCheckBoxValue('formProfileComment', 'check_all', '{$LANG.profile_comment_err_tip_select_comment}', 'dAltMlti', -25, -290)) {literal} { {/literal} Confirmation('selMsgConfirm', 'msgConfirmform', Array('comments', 'action', 'confirmMessage'), Array(multiCheckValue, 'remove_submit', '{$LANG.profile_comment_confirm_message}'), Array('value', 'value', 'innerHTML'), -25, -290); {literal} } {/literal}" /></div></div>
			</td>
      	</tr>
      {/if}

    </table>
    </div>
  </form>
  {else}

  <div id="selMsgAlert">
    <p>{$LANG.msg_no_comments}</p>

            {if !$myobj->form_view_comments.currentAccount}

                <p class="clsUploadMsg"><a href="{$myobj->form_view_comments.viewUrl}">View '{$myobj->form_view_comments.userDetails.user_name}' now</a></p>
                <p class="clsUploadMsg"><a href="{$myobj->form_view_comments.postscrapUrl}">Post your Scrap now</a></p>
            {/if}
  </div>
	{/if} {* isResultsFound closed *}
{/if}{* showblock form_view_comments closed *}
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}