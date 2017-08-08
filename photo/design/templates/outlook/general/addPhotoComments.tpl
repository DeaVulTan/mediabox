<div id="photo_comment_add_block" class="clsPhotoCommentsSection" style="display:none">
    <form name="addComments" id="addComments" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off" onsubmit="return false">
        <div id="selMsgError" class="clsInvalidCaptcha" style="display:none;">
            <p id="commentSelMsgError"></p>
        </div>
        {if $CFG.admin.photos.captcha AND $CFG.admin.photos.captcha_method =='honeypot'}
            {$myobj->hpSolutionsRayzz()}
        {/if}
            <table>
                <tr>
                    <td>
                        <textarea class="clsEmbedTextFields clsPhotoCommentsBlock" name="comment" id="comment" tabindex="{smartyTabIndex}" rows="5" cols="100"></textarea>
                    </td>
                </tr>
        {if $CFG.admin.photos.captcha}
            {if $CFG.admin.photos.captcha_method =='recaptcha' and $CFG.captcha.public_key and $CFG.captcha.private_key}
              <tr>
               <td class="clsOverwriteRecaptcha {$myobj->getCSSFormLabelCellClass('captcha')}">
                    <div id="recaptcha_div"></div>
                    <script type="text/javascript" src="http://api.recaptcha.net/js/recaptcha_ajax.js"></script>
                    <script type="text/javascript">
						{literal}
						Recaptcha.create("{/literal}{$CFG.captcha.public_key}{literal}",
						"recaptcha_div", {
						   theme: "blackglass",
						   callback: Recaptcha.focus_response_field,
						   tabindex: {/literal}{smartyTabIndex}{literal},
						   custom_translations : { visual_challenge : "{/literal}{$LANG.common_recaptcha_visual_challenge}{literal}", audio_challenge : "{/literal}{$LANG.common_recaptcha_audio_challenge}{literal}", refresh_btn : "{/literal}{$LANG.common_recaptcha_refresh_btn}{literal}", instructions_visual : "{/literal}{$LANG.common_recaptcha_instructions_visual}{literal}:", instructions_audio : "{/literal}{$LANG.common_recaptcha_instructions_audio}{literal}:", help_btn : "{/literal}{$LANG.common_recaptcha_help_btn}{literal}", play_again : "{/literal}{$LANG.common_recaptcha_play_again}{literal}", cant_hear_this : "{/literal}{$LANG.common_recaptcha_cant_hear_this}{literal}", incorrect_try_again : "{/literal}{$LANG.common_recaptcha_incorrect_try_again}{literal}" }
						});
						{/literal}
                    </script>

                 </td>
                    </tr>
            {elseif $CFG.admin.photos.captcha_method =='image'}
                    <tr>
                        <td>
                            <img src="{$getCommentsBlock_arr.captcha_comment_url}" />
                            <input type="text" class="clsTextBox" name="captcha_value" id="captcha_value" tabindex="{smartyTabIndex}" maxlength="15" value="" />
                        </td>
                    </tr>
            {/if}
        {/if}
                <tr>
                    <td>
                    {if $CFG.admin.photos.captcha}
                        {if $CFG.admin.photos.captcha_method =='recaptcha'}
                            <p class="clsPostCommentButton-l clsMarginTopBottom5"><span class="clsPostCommentButton-r"><input type="button" onClick="return light_addToCommentRecaptcha('{$CFG.site.url}photo/members/viewPhoto.php?ajax_page=true&amp;user_id={$myobj->getFormField('user_id')}&amp;photo_id={$myobj->getFormField('photo_id')}&amp;vpkey={$myobj->getFormField('vpkey')}&amp;show={$myobj->getFormField('show')}');" name="post_comment" id="post_comment" tabindex="{smartyTabIndex}" value="{$LANG.viewphoto_comment_submit}" /></span></p>
                        {elseif $CFG.admin.photos.captcha_method =='image'}
                            <p class="clsPostCommentButton-l clsMarginTopBottom5"><span class="clsPostCommentButton-r"><input type="button" onClick="return light_addToComment('{$CFG.site.url}photo/members/viewPhoto.php?ajax_page=true&amp;user_id={$myobj->getFormField('user_id')}&amp;photo_id={$myobj->getFormField('photo_id')}&amp;vpkey={$myobj->getFormField('vpkey')}&amp;show={$myobj->getFormField('show')}');" name="post_comment" id="post_comment" tabindex="{smartyTabIndex}" value="{$LANG.viewphoto_comment_submit}" /></span></p>
                        {elseif $CFG.admin.photos.captcha_method =='honeypot'}
                            <p class="clsPostCommentButton-l clsMarginTopBottom5"><span class="clsPostCommentButton-r"><input type="button" onClick="return light_addToCommentHoneyPot('{$CFG.site.url}photo/members/viewPhoto.php?ajax_page=true&amp;user_id={$myobj->getFormField('user_id')}&amp;photo_id={$myobj->getFormField('photo_id')}&amp;vpkey={$myobj->getFormField('vpkey')}&amp;show={$myobj->getFormField('show')}', '{$myobj->phFormulaRayzz()}')" name="post_comment" id="post_comment" tabindex="{smartyTabIndex}" value="{$LANG.viewphoto_comment_submit}" /></span></p>
                        {/if}
                        {else}
                            <p class="clsPostCommentButton-l clsMarginTopBottom5"><span class="clsPostCommentButton-r"><input type="button" onClick="return light_addToCommentNoCaptcha('{$CFG.site.url}photo/members/viewPhoto.php?ajax_page=true&amp;user_id={$myobj->getFormField('user_id')}&amp;photo_id={$myobj->getFormField('photo_id')}&amp;vpkey={$myobj->getFormField('vpkey')}&amp;show={$myobj->getFormField('show')}')" name="post_comment" id="post_comment" tabindex="{smartyTabIndex}" value="{$LANG.viewphoto_comment_submit}" /></span></p>
                        {/if}
    	           </td>
            </tr>
        </table>
    </form>
</div>