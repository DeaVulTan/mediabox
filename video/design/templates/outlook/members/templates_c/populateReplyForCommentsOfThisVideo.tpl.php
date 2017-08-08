<?php /* Smarty version 2.6.18, created on 2011-11-07 10:51:25
         compiled from populateReplyForCommentsOfThisVideo.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'populateReplyForCommentsOfThisVideo.tpl', 12, false),)), $this); ?>
<?php if ($this->_tpl_vars['cmValue']['populateReply_arr']): ?>
    <?php if ($this->_tpl_vars['cmValue']['populateReply_arr']['rs_PO_RecordCount']): ?>
            <p class="clsRepliedText">Replied:</p>
            <?php $_from = $this->_tpl_vars['cmValue']['populateReply_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['prKey'] => $this->_tpl_vars['prValue']):
?>
            <div class="clsOverflow">
                <div class="clsCommentReplySection" id="delcmd<?php echo $this->_tpl_vars['prValue']['record']['video_comment_id']; ?>
">
                    <div class="<?php echo $this->_tpl_vars['prValue']['class']; ?>
" id="cmd<?php echo $this->_tpl_vars['prValue']['record']['video_comment_id']; ?>
">
                        <div class="clsHomeDispContents clsCommentAuthor">
                            <div id="commentUserProfile_<?php echo $this->_tpl_vars['prValue']['record']['video_comment_id']; ?>
" class="clsCoolMemberActive"  style="display:none;"></div>
                            <div class="clsCommentImage">
                                <div class="clsPointer"  >
                                    <a href="<?php echo $this->_tpl_vars['prValue']['memberProfileUrl']; ?>
" class="Cls45x45 ClsImageBorder1 ClsImageContainer"><img src="<?php echo $this->_tpl_vars['prValue']['icon']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['prValue']['name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" border="0"  <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['prValue']['icon']['s_width'],$this->_tpl_vars['prValue']['icon']['s_height']); ?>
  /></a>
                                </div>
                            </div>
                            <div class="clsCommentContent">
                                <p class="clsMembersName"><a href="<?php echo $this->_tpl_vars['prValue']['comment_memberProfileUrl']; ?>
"><?php echo $this->_tpl_vars['prValue']['name']; ?>
</a><span class="clsLinkSeperator">|</span><span><?php echo $this->_tpl_vars['prValue']['record']['pc_date_added']; ?>
</span></p>
                                <div id="cmd<?php echo $this->_tpl_vars['prValue']['record']['video_comment_id']; ?>
_1">
                                    <div>
                                        <div class="clsCommentDiv">
                                            <p class="clsVideoCommentDisplay" id="selEditCommentTxt_<?php echo $this->_tpl_vars['prValue']['record']['video_comment_id']; ?>
"><?php echo $this->_tpl_vars['prValue']['comment_makeClickableLinks']; ?>
</p>
                                            <p id="selEditComments_<?php echo $this->_tpl_vars['prValue']['record']['video_comment_id']; ?>
"></p>
                                            <?php if (( isMember ( ) && $this->_tpl_vars['prValue']['record']['comment_user_id'] == $this->_tpl_vars['CFG']['user']['user_id'] ) || $this->_tpl_vars['myobj']->getFormField('user_id') == $this->_tpl_vars['CFG']['user']['user_id']): ?>
                                                <div>

                                                    <p class="clsCommentsReplySection clsCommentsSectionReply">
                                                        <span id="selViewEditComment_<?php echo $this->_tpl_vars['prValue']['record']['video_comment_id']; ?>
" class="clsViewPostComment">
                                                            <a href="javascript:void(0);" onClick="return callAjaxEdit('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
video/viewVideo.php?ajax_page=true&amp;video_id=<?php echo $this->_tpl_vars['myobj']->getFormField('video_id'); ?>
&amp;vpkey=<?php echo $this->_tpl_vars['myobj']->getFormField('vpkey'); ?>
&amp;show=<?php echo $this->_tpl_vars['myobj']->getFormField('show'); ?>
','<?php echo $this->_tpl_vars['prValue']['record']['video_comment_id']; ?>
')"><?php echo $this->_tpl_vars['LANG']['viewvideo_edit']; ?>
</a>
                                                        </span>
                                                    </p>
                                                    <p class="clsCommentsReplySection">
                                                        <span id="selViewDeleteComment_<?php echo $this->_tpl_vars['prValue']['record']['video_comment_id']; ?>
">
                                                            <a class="clsButton4" href="javascript:void(0);" onClick="return Confirmation('selMsgConfirmWindow', 'msgConfirmform', Array('comment_id', 'maincomment_id', 'confirmationMsg', 'commentorreply'), Array('<?php echo $this->_tpl_vars['prValue']['record']['video_comment_id']; ?>
', '<?php echo $this->_tpl_vars['prValue']['record']['video_comment_main_id']; ?>
', '<?php echo $this->_tpl_vars['LANG']['viewvideo_confirm_txt']; ?>
', 'deletereply'), Array('value', 'value', 'html', 'value'))"><?php echo $this->_tpl_vars['LANG']['viewvideo_delete']; ?>
</a>
                                                        </span>
                                                    </p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; endif; unset($_from); ?>
    <?php endif; ?>
<?php endif; ?>