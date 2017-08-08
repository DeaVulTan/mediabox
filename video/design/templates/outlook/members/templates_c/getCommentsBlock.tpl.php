<?php /* Smarty version 2.6.18, created on 2011-10-19 10:52:53
         compiled from getCommentsBlock.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'getCommentsBlock.tpl', 13, false),)), $this); ?>
<script type="text/javascript"	src="<?php echo $this->_tpl_vars['CFG']['site']['video_url']; ?>
js/light_comment.js"></script>
<div class="clsOverflow">
    <form name="addComments" id="addComments" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off" onsubmit="return false">
        <div id="selMsgError" style="display:none;">
            <p id="commentSelMsgError"></p>
        </div><br />
        <?php if ($this->_tpl_vars['CFG']['admin']['videos']['captcha'] && $this->_tpl_vars['CFG']['admin']['videos']['captcha_method'] == 'honeypot'): ?>
            <?php echo $this->_tpl_vars['myobj']->hpSolutionsRayzz(); ?>

        <?php endif; ?>
            <table>
                <tr>
                    <td>
                        <textarea class="clsEmbedTextFields" name="comment" id="comment" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" rows="5" cols="60"></textarea>
                    </td>
                </tr>
        <?php if ($this->_tpl_vars['CFG']['admin']['videos']['captcha']): ?>
            <?php if ($this->_tpl_vars['CFG']['admin']['videos']['captcha_method'] == 'recaptcha' && $this->_tpl_vars['CFG']['captcha']['public_key'] && $this->_tpl_vars['CFG']['captcha']['private_key']): ?>
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
            <?php elseif ($this->_tpl_vars['CFG']['admin']['videos']['captcha_method'] == 'image'): ?>
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
                    <?php if ($this->_tpl_vars['CFG']['admin']['videos']['captcha']): ?>
                        <?php if ($this->_tpl_vars['CFG']['admin']['videos']['captcha_method'] == 'recaptcha'): ?>
                            <div class="clsGreyButtonLeft"><div class="clsGreyButtonRight"><input type="button" onClick="return light_addToCommentRecaptcha('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
video/viewVideo.php?ajax_page=true&amp;video_id=<?php echo $this->_tpl_vars['myobj']->getFormField('video_id'); ?>
&amp;vpkey=<?php echo $this->_tpl_vars['myobj']->getFormField('vpkey'); ?>
&amp;show=<?php echo $this->_tpl_vars['myobj']->getFormField('show'); ?>
');" name="post_comment" id="post_comment" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['viewvideo_submit']; ?>
" /></div></div>
                        <?php elseif ($this->_tpl_vars['CFG']['admin']['videos']['captcha_method'] == 'image'): ?>
                            <div class="clsGreyButtonLeft"><div class="clsGreyButtonRight"><input type="button" onClick="return light_addToComment('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
video/viewVideo.php?ajax_page=true&amp;video_id=<?php echo $this->_tpl_vars['myobj']->getFormField('video_id'); ?>
&amp;vpkey=<?php echo $this->_tpl_vars['myobj']->getFormField('vpkey'); ?>
&amp;show=<?php echo $this->_tpl_vars['myobj']->getFormField('show'); ?>
');" name="post_comment" id="post_comment" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['viewvideo_submit']; ?>
" /></div></div>
                        <?php elseif ($this->_tpl_vars['CFG']['admin']['videos']['captcha_method'] == 'honeypot'): ?>
                            <div class="clsGreyButtonLeft"><div class="clsGreyButtonRight"><input type="button" onClick="return light_addToCommentHoneyPot('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
video/viewVideo.php?ajax_page=true&amp;video_id=<?php echo $this->_tpl_vars['myobj']->getFormField('video_id'); ?>
&amp;vpkey=<?php echo $this->_tpl_vars['myobj']->getFormField('vpkey'); ?>
&amp;show=<?php echo $this->_tpl_vars['myobj']->getFormField('show'); ?>
', '<?php echo $this->_tpl_vars['myobj']->phFormulaRayzz(); ?>
')" name="post_comment" id="post_comment" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['viewvideo_submit']; ?>
" /></div></div>
                        <?php endif; ?>
                        <?php else: ?>
                            <div class="clsGreyButtonLeft"><div class="clsGreyButtonRight"><input type="button" onClick="return light_addToCommentNoCaptcha('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
video/viewVideo.php?ajax_page=true&amp;video_id=<?php echo $this->_tpl_vars['myobj']->getFormField('video_id'); ?>
&amp;vpkey=<?php echo $this->_tpl_vars['myobj']->getFormField('vpkey'); ?>
&amp;show=<?php echo $this->_tpl_vars['myobj']->getFormField('show'); ?>
')" name="post_comment" id="post_comment" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['viewvideo_submit']; ?>
" /></div></div>
                        <?php endif; ?>

                </td>
            </tr>
        </table>
    </form>
</div>