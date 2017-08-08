<?php /* Smarty version 2.6.18, created on 2013-07-30 10:28:03
         compiled from populateReplyForCommentsOfThisMusic.tpl */ ?>

<?php if ($this->_tpl_vars['cmValue']['populateReply_arr']): ?>
    <?php if ($this->_tpl_vars['cmValue']['populateReply_arr']['rs_PO_RecordCount']): ?>
	<p class="clsCommentReplyHead">Replied:</p>
        <?php $_from = $this->_tpl_vars['cmValue']['populateReply_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['prKey'] => $this->_tpl_vars['prValue']):
?>
			<div class="clsMoreInfoContent clsOverflow" id="delcmd<?php echo $this->_tpl_vars['prValue']['record']['music_comment_id']; ?>
">
            	<div class="clsMoreInfoComment">
 					<div class="clsOverflow">
                        <div class="clsCommentThumb">
                            <div class="clsThumbImageLink">
                                <a href="<?php echo $this->_tpl_vars['prValue']['memberProfileUrl']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls45x45">
                                    <img src="<?php echo $this->_tpl_vars['prValue']['icon']['s_url']; ?>
" title="<?php echo $this->_tpl_vars['prValue']['name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['prValue']['icon']['s_width'],$this->_tpl_vars['prValue']['icon']['s_height']); ?>
 />
                                </a>
                            </div>
                        </div>
                        <div class="clsCommentDetails">
                            <p class="clsCommentedBy"><a href="<?php echo $this->_tpl_vars['prValue']['memberProfileUrl']; ?>
" title="<?php echo $this->_tpl_vars['prValue']['name']; ?>
"><?php echo $this->_tpl_vars['prValue']['name']; ?>
</a><span class="clsLinkSeperator">|</span><span><?php echo $this->_tpl_vars['prValue']['record']['pc_date_added']; ?>
</span></p>
                            <p id="selEditCommentTxt_<?php echo $this->_tpl_vars['prValue']['record']['music_comment_id']; ?>
" class="clsMusicCommentDisplay"><?php echo $this->_tpl_vars['prValue']['comment_makeClickableLinks']; ?>
</p>
                            <div id="selEditComments_<?php echo $this->_tpl_vars['prValue']['record']['music_comment_id']; ?>
"></div>
                            <div id="selEditComments_<?php echo $this->_tpl_vars['prValue']['record']['music_comment_id']; ?>
"></div>
							<div class="clsButtonHolder">
					<?php if (( isMember ( ) && $this->_tpl_vars['prValue']['record']['comment_user_id'] == $this->_tpl_vars['CFG']['user']['user_id'] )): ?>
						<p class="clsEditButton" id="selViewEditComment_<?php echo $this->_tpl_vars['prValue']['record']['music_comment_id']; ?>
">
							<span>
								<a href="javascript:void(0);" onclick="return callAjaxEdit('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/listenMusic.php?ajax_page=true&amp;page=comment_edit&amp;music_id=<?php echo $this->_tpl_vars['myobj']->getFormField('music_id'); ?>
&amp;vpkey=<?php echo $this->_tpl_vars['myobj']->getFormField('vpkey'); ?>
&amp;show=<?php echo $this->_tpl_vars['myobj']->getFormField('show'); ?>
','<?php echo $this->_tpl_vars['prValue']['record']['music_comment_id']; ?>
')" title="<?php echo $this->_tpl_vars['LANG']['viewmusic_edit_label']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewmusic_edit_label']; ?>
</a>
							</span>
						</p>
					<?php endif; ?>
					<?php if (isMember ( ) && ( $this->_tpl_vars['prValue']['record']['comment_user_id'] == $this->_tpl_vars['CFG']['user']['user_id'] || $this->_tpl_vars['myobj']->getFormField('user_id') == $this->_tpl_vars['CFG']['user']['user_id'] )): ?>
							<p class="<?php if (( isMember ( ) && $this->_tpl_vars['prValue']['record']['comment_user_id'] == $this->_tpl_vars['CFG']['user']['user_id'] )): ?>  clsDeleteButton <?php else: ?> clsReplyButton<?php endif; ?>" id="selViewDeleteComment_<?php echo $this->_tpl_vars['prValue']['record']['music_comment_id']; ?>
">
								<span>
									<a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmWindow', 'msgConfirmform', Array('comment_id', 'maincomment_id', 'confirmationMsg', 'commentorreply'), Array('<?php echo $this->_tpl_vars['prValue']['record']['music_comment_id']; ?>
', '<?php echo $this->_tpl_vars['prValue']['record']['music_comment_main_id']; ?>
', '<?php echo $this->_tpl_vars['LANG']['viewmusic_confirm_txt']; ?>
', 'deletereply'), Array('value', 'value', 'html', 'value'))" title="<?php echo $this->_tpl_vars['LANG']['viewmusic_deleted_label']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewmusic_deleted_label']; ?>
</a>
								</span>
							</p>
					 <?php endif; ?>
                 </div>
                        </div>
                    </div>
                </div>
                 
            </div>
        <?php endforeach; endif; unset($_from); ?>
    <?php endif; ?>
<?php endif; ?>