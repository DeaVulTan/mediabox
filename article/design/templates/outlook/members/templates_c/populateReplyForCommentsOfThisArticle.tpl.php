<?php /* Smarty version 2.6.18, created on 2012-02-02 01:54:52
         compiled from populateReplyForCommentsOfThisArticle.tpl */ ?>
<?php if ($this->_tpl_vars['cmValue']['populateReply_arr']): ?>
            <?php $_from = $this->_tpl_vars['cmValue']['populateReply_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['prKey'] => $this->_tpl_vars['prValue']):
?>
                <div class="clsCommentReplySection clsOverflow" id="delcmd<?php echo $this->_tpl_vars['prValue']['record']['article_comment_id']; ?>
">
                    <div class="<?php echo $this->_tpl_vars['prValue']['class']; ?>
" id="cmd<?php echo $this->_tpl_vars['prValue']['record']['article_comment_id']; ?>
">
                        <div class="clsHomeDispContents clsCommentAuthor">

                                                      <div id="commentUserProfile_<?php echo $this->_tpl_vars['prValue']['record']['article_comment_id']; ?>
" class="clsCoolMemberActive"  style="display:none;" ></div>
                             <div class="clsRepliedComment">
                                <p class="clsCommentReplyHead"><?php echo $this->_tpl_vars['LANG']['viewarticle_replied']; ?>
</p>
                                <div class="clsCommentThumb">
    
                                    
    
                                     <a href="<?php echo $this->_tpl_vars['prValue']['memberProfileUrl']; ?>
" class="clsPointer Cls45x45 ClsImageBorder1 ClsImageContainer">
                                        <img src="<?php echo $this->_tpl_vars['prValue']['icon']['s_url']; ?>
" alt="<?php echo $this->_tpl_vars['prValue']['name']; ?>
"  <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['prValue']['icon']['s_width'],$this->_tpl_vars['prValue']['icon']['s_height']); ?>
  />
                                    </a>
                                </div>
                                <div class="clsCommentDetails">
                                    <p class="clsMembersName"><a href="<?php echo $this->_tpl_vars['prValue']['comment_memberProfileUrl']; ?>
"><?php echo $this->_tpl_vars['prValue']['name']; ?>
</a>  <span class="clsLinkSeperator">|</span> <span><?php echo $this->_tpl_vars['prValue']['record']['pc_date_added']; ?>
</span></p>
                                    <div id="cmd<?php echo $this->_tpl_vars['prValue']['record']['article_comment_id']; ?>
_1">
                                            <div class="clsCommentDiv">
                                                <p id="selEditCommentTxt_<?php echo $this->_tpl_vars['prValue']['record']['article_comment_id']; ?>
"><?php echo $this->_tpl_vars['prValue']['comment_makeClickableLinks']; ?>
</p>
                                                <p id="selEditComments_<?php echo $this->_tpl_vars['prValue']['record']['article_comment_id']; ?>
"></p>
                                                    <div class="clsButtonHolder">
                                                    <?php if (( isMember ( ) && $this->_tpl_vars['prValue']['record']['comment_user_id'] == $this->_tpl_vars['CFG']['user']['user_id'] )): ?>
                                                        <p id="selViewEditComment_<?php echo $this->_tpl_vars['prValue']['record']['article_comment_id']; ?>
" class="clsEditButton">
                                                           <span> <a href="javascript:void(0);" onClick="return callAjaxEdit('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
article/viewArticle.php?ajax_page=true&amp;article_id=<?php echo $this->_tpl_vars['myobj']->getFormField('article_id'); ?>
&amp;vpkey=<?php echo $this->_tpl_vars['myobj']->getFormField('vpkey'); ?>
&amp;show=<?php echo $this->_tpl_vars['myobj']->getFormField('show'); ?>
','<?php echo $this->_tpl_vars['prValue']['record']['article_comment_id']; ?>
')"><?php echo $this->_tpl_vars['LANG']['viewarticle_edit']; ?>
</a></span>
                                                        </p>
                                                    <?php endif; ?>
                                                    <?php if (( isMember ( ) && $this->_tpl_vars['prValue']['record']['comment_user_id'] != '' ) || $this->_tpl_vars['myobj']->getFormField('user_id') != ''): ?>
                                                        <?php if (( isMember ( ) )): ?>
                                                            <p id="selViewDeleteComment_<?php echo $this->_tpl_vars['prValue']['record']['article_comment_id']; ?>
" class="clsDeleteButton">
                                                               <span> <a class="clsButton4" href="javascript:void(0);" onClick="return Confirmation('selMsgConfirmWindow', 'msgConfirmform', Array('comment_id', 'maincomment_id', 'confirmationMsg', 'commentorreply'), Array('<?php echo $this->_tpl_vars['prValue']['record']['article_comment_id']; ?>
', '<?php echo $this->_tpl_vars['prValue']['record']['article_comment_main_id']; ?>
', '<?php echo $this->_tpl_vars['LANG']['viewarticle_confirm_txt']; ?>
', 'deletereply'), Array('value', 'value', 'html', 'value'))"><?php echo $this->_tpl_vars['LANG']['viewarticle_delete']; ?>
</a></span>
                                                            </p>
                                                         <?php endif; ?>
                                                    <?php endif; ?>
                                               </div>
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