<?php /* Smarty version 2.6.18, created on 2011-10-18 17:31:08
         compiled from populateCommentOfThisMusic.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'populateCommentOfThisMusic.tpl', 41, false),)), $this); ?>
<form name="frmMusicComments" id="frmMusicComments" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
<?php if (isset ( $this->_tpl_vars['populateCommentOfThisMusic_arr']['hidden_arr'] ) && $this->_tpl_vars['populateCommentOfThisMusic_arr']['hidden_arr']): ?>
	<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['populateCommentOfThisMusic_arr']['hidden_arr']); ?>

<?php endif; ?>
<?php if (isset ( $this->_tpl_vars['populateCommentOfThisMusic_arr']['row'] ) && $this->_tpl_vars['populateCommentOfThisMusic_arr']['row']): ?>
	<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
	<div class="clsCommentsViewVideopaging">
		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

	    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</div>
	<?php endif; ?>
	<?php $_from = $this->_tpl_vars['populateCommentOfThisMusic_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cmKey'] => $this->_tpl_vars['cmValue']):
?>
		<div class="clsListContents" id="cmd<?php echo $this->_tpl_vars['cmValue']['record']['music_comment_id']; ?>
">
	        <div class="clsOverflow">
	            <div class="clsCommentThumb">
	                <div class="clsThumbImageLink">
	                    <a href="<?php echo $this->_tpl_vars['cmValue']['memberProfileUrl']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls45x45">
	                        <img src="<?php echo $this->_tpl_vars['cmValue']['icon']['s_url']; ?>
" title="<?php echo $this->_tpl_vars['cmValue']['name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['cmValue']['icon']['s_width'],$this->_tpl_vars['cmValue']['icon']['s_height']); ?>
/>
						</a>
	                </div>
	            </div>

	            <div class="clsCommentDetails">
					<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'comment_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	                <p class="clsCommentedBy"><a href="<?php echo $this->_tpl_vars['cmValue']['memberProfileUrl']; ?>
" title="<?php echo $this->_tpl_vars['cmValue']['name']; ?>
"><?php echo $this->_tpl_vars['cmValue']['name']; ?>
</a> <span class="clsLinkSeperator">|</span> <span><?php echo $this->_tpl_vars['cmValue']['record']['pc_date_added']; ?>
</span></p>
	                <p id="selEditCommentTxt_<?php echo $this->_tpl_vars['cmValue']['record']['music_comment_id']; ?>
" class="clsMusicCommentDisplay"><?php echo $this->_tpl_vars['cmValue']['makeClickableLinks']; ?>
</p>
	        		<div class="" id="selEditComments_<?php echo $this->_tpl_vars['cmValue']['record']['music_comment_id']; ?>
"></div>
					
			        	<?php if (isMember ( ) && $this->_tpl_vars['cmValue']['record']['comment_user_id'] == $this->_tpl_vars['CFG']['user']['user_id']): ?>
						<div class="clsButtonHolder">
			                <p class="clsEditButton" id="selViewEditComment_<?php echo $this->_tpl_vars['cmValue']['record']['music_comment_id']; ?>
" ><span><a href="javascript:void(0)" onclick="return callAjaxEdit('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/listenMusic.php?ajax_page=true&amp;page=comment_edit&amp;music_id=<?php echo $this->_tpl_vars['myobj']->getFormField('music_id'); ?>
&amp;vpkey=<?php echo $this->_tpl_vars['myobj']->getFormField('vpkey'); ?>
&amp;show=<?php echo $this->_tpl_vars['myobj']->getFormField('show'); ?>
','<?php echo $this->_tpl_vars['cmValue']['record']['music_comment_id']; ?>
')" title="<?php echo $this->_tpl_vars['LANG']['viewmusic_edit_label']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewmusic_edit_label']; ?>
</a></span></p>
			                <p class="clsDeleteButton" id="selViewDeleteComment_<?php echo $this->_tpl_vars['cmValue']['record']['music_comment_id']; ?>
"><span><a href="javascript:void(0)" onclick="return Confirmation('selMsgConfirmWindow', 'msgConfirmform', Array('comment_id', 'confirmationMsg', 'commentorreply'), Array('<?php echo $this->_tpl_vars['cmValue']['record']['music_comment_id']; ?>
', '<?php echo $this->_tpl_vars['LANG']['viewmusic_confirm_txt']; ?>
', 'deletecomment'), Array('value', 'html', 'value'))" title="<?php echo $this->_tpl_vars['LANG']['viewmusic_deleted_label']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewmusic_deleted_label']; ?>
</a></span></p>
							</div>
			        	<?php endif; ?>
						<?php if (isMember ( ) && $this->_tpl_vars['cmValue']['record']['comment_user_id'] != $this->_tpl_vars['CFG']['user']['user_id']): ?>
	                		<div id="selAddComments_<?php echo $this->_tpl_vars['cmValue']['record']['music_comment_id']; ?>
" style="display:none;" class="clsEditCommentTextArea clsReplyCommentTextArea">
								<textarea name="comment_<?php echo $this->_tpl_vars['cmValue']['record']['music_comment_id']; ?>
" id="comment_<?php echo $this->_tpl_vars['cmValue']['record']['music_comment_id']; ?>
" rows="5" cols="92"></textarea>
							<div class="clsButtonHolder">
               					<p class="clsEditButton"><span>
									<input type="button" onClick="return addToReply('<?php echo $this->_tpl_vars['cmValue']['record']['music_comment_id']; ?>
', '<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/listenMusic.php?ajax_page=true&page=post_comment&music_id=<?php echo $this->_tpl_vars['myobj']->getFormField('music_id'); ?>
&vpkey=<?php echo $this->_tpl_vars['myobj']->getFormField('vpkey'); ?>
&show=<?php echo $this->_tpl_vars['myobj']->getFormField('show'); ?>
')" name="post_comment" id="post_comment" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['postcomment_post_comment']; ?>
" /></span></p>
								 <p class="clsDeleteButton"><span>
								      <input type="button" onClick="return discardReply('selAddComments_<?php echo $this->_tpl_vars['cmValue']['record']['music_comment_id']; ?>
', '<?php echo $this->_tpl_vars['cmValue']['record']['music_comment_id']; ?>
')" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['postcomment_cancel']; ?>
" /></span></p></div>
							</div>
							<div class="clsButtonHolder">
								<p class="<?php if (( isMember ( ) && $this->_tpl_vars['cmValue']['record']['comment_user_id'] != $this->_tpl_vars['CFG']['user']['user_id'] ) && ( $this->_tpl_vars['myobj']->getFormField('user_id') == $this->_tpl_vars['CFG']['user']['user_id'] )): ?>  clsEditButton <?php else: ?> clsReplyButton <?php endif; ?>" id="selViewPostComment_<?php echo $this->_tpl_vars['cmValue']['record']['music_comment_id']; ?>
">
									<span>
										<a id="viewmusic_reply_comment_<?php echo $this->_tpl_vars['cmValue']['record']['music_comment_id']; ?>
" href="javascript:void(0)" onclick="showReplyToCommentsOption('selAddComments_<?php echo $this->_tpl_vars['cmValue']['record']['music_comment_id']; ?>
');" title="<?php echo $this->_tpl_vars['LANG']['viewmusic_reply_comment']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewmusic_reply_comment']; ?>
</a>
									</span>
								</p>
								<?php if (isMember ( ) && $this->_tpl_vars['cmValue']['record']['comment_user_id'] != $this->_tpl_vars['CFG']['user']['user_id']): ?>
								<?php if ($this->_tpl_vars['myobj']->getFormField('user_id') == $this->_tpl_vars['CFG']['user']['user_id']): ?>
									<p class="clsDeleteButton" id="selViewDeleteComment_<?php echo $this->_tpl_vars['cmValue']['record']['music_comment_id']; ?>
">
									<span>
										<a href="javascript:void(0)" onclick="return Confirmation('selMsgConfirmWindow', 'msgConfirmform', Array('comment_id', 'confirmationMsg', 'commentorreply'), Array('<?php echo $this->_tpl_vars['cmValue']['record']['music_comment_id']; ?>
', '<?php echo $this->_tpl_vars['LANG']['viewmusic_confirm_txt']; ?>
', 'deletecomment'), Array('value', 'html', 'value'))" title="<?php echo $this->_tpl_vars['LANG']['viewmusic_deleted_label']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewmusic_deleted_label']; ?>
</a>
									</span>
								   </p>
								<?php endif; ?>
								<?php endif; ?>
							</div>
						<?php endif; ?>
                        <div id="deleteCommentSuccessMsgBlock_<?php echo $this->_tpl_vars['cmValue']['record']['music_comment_id']; ?>
" style="display:none" class="clsSuccessMessage">                   
                        </div>
						<div id="selReplyForComments_<?php echo $this->_tpl_vars['cmValue']['record']['music_comment_id']; ?>
">                        	
							<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'populateReplyForCommentsOfThisMusic.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
						</div>
					<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

		     		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'comment_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	            </div>
	         </div>
	    </div>
	<?php endforeach; endif; unset($_from); ?>
	<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

	    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endif; ?>
<?php else: ?>
	<div class="clsNoRecordsFound">
		<p><?php echo $this->_tpl_vars['LANG']['no_comments_for_this_music']; ?>
</p>
 	</div>
<?php endif; ?>
</form>