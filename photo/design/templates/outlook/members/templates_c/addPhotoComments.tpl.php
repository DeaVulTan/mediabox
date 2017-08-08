<?php /* Smarty version 2.6.18, created on 2011-10-17 15:12:22
         compiled from addPhotoComments.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'addPhotoComments.tpl', 12, false),)), $this); ?>
<div id="photo_comment_add_block" class="clsPhotoCommentsSection" style="display:none">
    <form name="addComments" id="addComments" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off" onsubmit="return false">
        <div id="selMsgError" class="clsInvalidCaptcha" style="display:none;">
            <p id="commentSelMsgError"></p>
        </div>
        <?php if ($this->_tpl_vars['CFG']['admin']['photos']['captcha'] && $this->_tpl_vars['CFG']['admin']['photos']['captcha_method'] == 'honeypot'): ?>
            <?php echo $this->_tpl_vars['myobj']->hpSolutionsRayzz(); ?>

        <?php endif; ?>
            <table>
                <tr>
                    <td>
                        <textarea class="clsEmbedTextFields clsPhotoCommentsBlock" name="comment" id="comment" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" rows="5" cols="100"></textarea>
                    </td>
                </tr>
        <?php if ($this->_tpl_vars['CFG']['admin']['photos']['captcha']): ?>
            <?php if ($this->_tpl_vars['CFG']['admin']['photos']['captcha_method'] == 'recaptcha' && $this->_tpl_vars['CFG']['captcha']['public_key'] && $this->_tpl_vars['CFG']['captcha']['private_key']): ?>
              <tr>
               <td class="clsOverwriteRecaptcha <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('captcha'); ?>
">
                    <div id="recaptcha_div"></div>
                    <script type="text/javascript" src="http://api.recaptcha.net/js/recaptcha_ajax.js"></script>
                    <script type="text/javascript">
						<?php echo '
						Recaptcha.create("'; ?>
<?php echo $this->_tpl_vars['CFG']['captcha']['public_key']; ?>
<?php echo '",
						"recaptcha_div", {
						   theme: "blackglass",
						   callback: Recaptcha.focus_response_field,
						   tabindex: '; ?>
<?php echo smartyTabIndex(array(), $this);?>
<?php echo ',
						   custom_translations : { visual_challenge : "'; ?>
<?php echo $this->_tpl_vars['LANG']['common_recaptcha_visual_challenge']; ?>
<?php echo '", audio_challenge : "'; ?>
<?php echo $this->_tpl_vars['LANG']['common_recaptcha_audio_challenge']; ?>
<?php echo '", refresh_btn : "'; ?>
<?php echo $this->_tpl_vars['LANG']['common_recaptcha_refresh_btn']; ?>
<?php echo '", instructions_visual : "'; ?>
<?php echo $this->_tpl_vars['LANG']['common_recaptcha_instructions_visual']; ?>
<?php echo ':", instructions_audio : "'; ?>
<?php echo $this->_tpl_vars['LANG']['common_recaptcha_instructions_audio']; ?>
<?php echo ':", help_btn : "'; ?>
<?php echo $this->_tpl_vars['LANG']['common_recaptcha_help_btn']; ?>
<?php echo '", play_again : "'; ?>
<?php echo $this->_tpl_vars['LANG']['common_recaptcha_play_again']; ?>
<?php echo '", cant_hear_this : "'; ?>
<?php echo $this->_tpl_vars['LANG']['common_recaptcha_cant_hear_this']; ?>
<?php echo '", incorrect_try_again : "'; ?>
<?php echo $this->_tpl_vars['LANG']['common_recaptcha_incorrect_try_again']; ?>
<?php echo '" }
						});
						'; ?>

                    </script>

                 </td>
                    </tr>
            <?php elseif ($this->_tpl_vars['CFG']['admin']['photos']['captcha_method'] == 'image'): ?>
                    <tr>
                        <td>
                            <img src="<?php echo $this->_tpl_vars['getCommentsBlock_arr']['captcha_comment_url']; ?>
" />
                            <input type="text" class="clsTextBox" name="captcha_value" id="captcha_value" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" maxlength="15" value="" />
                        </td>
                    </tr>
            <?php endif; ?>
        <?php endif; ?>
                <tr>
                    <td>
                    <?php if ($this->_tpl_vars['CFG']['admin']['photos']['captcha']): ?>
                        <?php if ($this->_tpl_vars['CFG']['admin']['photos']['captcha_method'] == 'recaptcha'): ?>
                            <p class="clsPostCommentButton-l clsMarginTopBottom5"><span class="clsPostCommentButton-r"><input type="button" onClick="return light_addToCommentRecaptcha('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/members/viewPhoto.php?ajax_page=true&amp;user_id=<?php echo $this->_tpl_vars['myobj']->getFormField('user_id'); ?>
&amp;photo_id=<?php echo $this->_tpl_vars['myobj']->getFormField('photo_id'); ?>
&amp;vpkey=<?php echo $this->_tpl_vars['myobj']->getFormField('vpkey'); ?>
&amp;show=<?php echo $this->_tpl_vars['myobj']->getFormField('show'); ?>
');" name="post_comment" id="post_comment" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['viewphoto_comment_submit']; ?>
" /></span></p>
                        <?php elseif ($this->_tpl_vars['CFG']['admin']['photos']['captcha_method'] == 'image'): ?>
                            <p class="clsPostCommentButton-l clsMarginTopBottom5"><span class="clsPostCommentButton-r"><input type="button" onClick="return light_addToComment('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/members/viewPhoto.php?ajax_page=true&amp;user_id=<?php echo $this->_tpl_vars['myobj']->getFormField('user_id'); ?>
&amp;photo_id=<?php echo $this->_tpl_vars['myobj']->getFormField('photo_id'); ?>
&amp;vpkey=<?php echo $this->_tpl_vars['myobj']->getFormField('vpkey'); ?>
&amp;show=<?php echo $this->_tpl_vars['myobj']->getFormField('show'); ?>
');" name="post_comment" id="post_comment" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['viewphoto_comment_submit']; ?>
" /></span></p>
                        <?php elseif ($this->_tpl_vars['CFG']['admin']['photos']['captcha_method'] == 'honeypot'): ?>
                            <p class="clsPostCommentButton-l clsMarginTopBottom5"><span class="clsPostCommentButton-r"><input type="button" onClick="return light_addToCommentHoneyPot('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/members/viewPhoto.php?ajax_page=true&amp;user_id=<?php echo $this->_tpl_vars['myobj']->getFormField('user_id'); ?>
&amp;photo_id=<?php echo $this->_tpl_vars['myobj']->getFormField('photo_id'); ?>
&amp;vpkey=<?php echo $this->_tpl_vars['myobj']->getFormField('vpkey'); ?>
&amp;show=<?php echo $this->_tpl_vars['myobj']->getFormField('show'); ?>
', '<?php echo $this->_tpl_vars['myobj']->phFormulaRayzz(); ?>
')" name="post_comment" id="post_comment" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['viewphoto_comment_submit']; ?>
" /></span></p>
                        <?php endif; ?>
                        <?php else: ?>
                            <p class="clsPostCommentButton-l clsMarginTopBottom5"><span class="clsPostCommentButton-r"><input type="button" onClick="return light_addToCommentNoCaptcha('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/members/viewPhoto.php?ajax_page=true&amp;user_id=<?php echo $this->_tpl_vars['myobj']->getFormField('user_id'); ?>
&amp;photo_id=<?php echo $this->_tpl_vars['myobj']->getFormField('photo_id'); ?>
&amp;vpkey=<?php echo $this->_tpl_vars['myobj']->getFormField('vpkey'); ?>
&amp;show=<?php echo $this->_tpl_vars['myobj']->getFormField('show'); ?>
')" name="post_comment" id="post_comment" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['viewphoto_comment_submit']; ?>
" /></span></p>
                        <?php endif; ?>
    	           </td>
            </tr>
        </table>
    </form>
</div>