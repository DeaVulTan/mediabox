<?php /* Smarty version 2.6.18, created on 2011-10-25 14:55:26
         compiled from populateReplyForCommentsOfThisPhoto.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'populateReplyForCommentsOfThisPhoto.tpl', 11, false),)), $this); ?>
<?php if ($this->_tpl_vars['cmValue']['populateReply_arr']): ?>
    <?php if ($this->_tpl_vars['cmValue']['populateReply_arr']['rs_PO_RecordCount']): ?>
        <?php $_from = $this->_tpl_vars['cmValue']['populateReply_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['prKey'] => $this->_tpl_vars['prValue']):
?>
			<div class="clsMoreInfoPhotoContent clsOverflow" id="delcmd<?php echo $this->_tpl_vars['prValue']['record']['photo_comment_id']; ?>
">
            	<div class="clsMoreInfoComment">
            	<p class="clsReplyedText"><?php echo $this->_tpl_vars['LANG']['viewphoto_replied_label']; ?>
:</p>
				<div class="clsOverflow">
                    <div class="clsCommentThumb">
                        <div class="clsThumbImageLink">
                           <a href="<?php echo $this->_tpl_vars['prValue']['memberProfileUrl']; ?>
" class="Cls45x45 clsImageHolder clsUserThumbImageOuter clsPointer">
                               <img src="<?php echo $this->_tpl_vars['prValue']['icon']['s_url']; ?>
" title="<?php echo $this->_tpl_vars['prValue']['name']; ?>
"  alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['prValue']['name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['prValue']['icon']['s_width'],$this->_tpl_vars['prValue']['icon']['s_height']); ?>
/>
                            </a>
                        </div>
                    </div>
                    <div class="clsCommentDetails">
                            <p class="clsCommentedBy"><a href="<?php echo $this->_tpl_vars['prValue']['memberProfileUrl']; ?>
" title="<?php echo $this->_tpl_vars['prValue']['name']; ?>
"><?php echo $this->_tpl_vars['prValue']['name']; ?>
</a><span class="clsLinkSeperator">|</span> 
                            <span><?php echo $this->_tpl_vars['prValue']['record']['pc_date_added']; ?>
</span></p>
                        <p id="selEditCommentTxt_<?php echo $this->_tpl_vars['prValue']['record']['photo_comment_id']; ?>
" class="clsPhotoCommentDisplay"><?php echo $this->_tpl_vars['prValue']['comment_makeClickableLinks']; ?>
</p>
                        <p id="selEditComments_<?php echo $this->_tpl_vars['prValue']['record']['photo_comment_id']; ?>
"></p>
                        <div class="clsButtonHolder">
                            <?php if (( isMember ( ) && $this->_tpl_vars['prValue']['record']['comment_user_id'] == $this->_tpl_vars['CFG']['user']['user_id'] )): ?>
                                <p class="clsEditButton" id="selViewEditComment_<?php echo $this->_tpl_vars['prValue']['record']['photo_comment_id']; ?>
">
                                    <span>
                                        <a href="javascript:void(0);" onClick="return callAjaxEdit('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/viewPhoto.php?ajax_page=true&amp;page=comment_edit&amp;photo_id=<?php echo $this->_tpl_vars['myobj']->getFormField('photo_id'); ?>
&amp;vpkey=<?php echo $this->_tpl_vars['myobj']->getFormField('vpkey'); ?>
&amp;show=<?php echo $this->_tpl_vars['myobj']->getFormField('show'); ?>
','<?php echo $this->_tpl_vars['prValue']['record']['photo_comment_id']; ?>
')" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_edit_label']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewphoto_edit_label']; ?>
</a>
                                    </span>
                                </p>
                            <?php endif; ?>
                            <?php if (( isMember ( ) && $this->_tpl_vars['prValue']['record']['comment_user_id'] != '' ) || $this->_tpl_vars['myobj']->getFormField('user_id') != ''): ?>
                                <?php if (( isMember ( ) )): ?>
                                    <p class="clsDeleteButton clsReplyDelete" id="selViewDeleteComment_<?php echo $this->_tpl_vars['prValue']['record']['photo_comment_id']; ?>
">
                                        <span>
                                            <a href="javascript:void(0);" onClick="return Confirmation('selMsgConfirmWindow', 'msgConfirmform', Array('comment_id', 'maincomment_id', 'confirmationMsg', 'commentorreply'), Array('<?php echo $this->_tpl_vars['prValue']['record']['photo_comment_id']; ?>
', '<?php echo $this->_tpl_vars['prValue']['record']['photo_comment_main_id']; ?>
', '<?php echo $this->_tpl_vars['LANG']['viewphoto_comment_delete_confirmation']; ?>
', 'deletereply'), Array('value', 'value', 'html', 'value'))" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_deleted_label']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewphoto_deleted_label']; ?>
</a>
                                        </span>
                                    </p>
                                <?php endif; ?>
                            <?php endif; ?>
                    	</div>
                    </div>
            	</div>
                </div>
			</div>
        <?php endforeach; endif; unset($_from); ?>
    <?php endif; ?>
<?php endif; ?>