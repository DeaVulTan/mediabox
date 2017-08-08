<?php /* Smarty version 2.6.18, created on 2011-10-18 17:56:33
         compiled from populateCommentOfThisVideo.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'populateCommentOfThisVideo.tpl', 20, false),array('function', 'smartyTabIndex', 'populateCommentOfThisVideo.tpl', 59, false),)), $this); ?>
<form name="frmVideoComments" id="frmVideoComments" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
<?php if (isset ( $this->_tpl_vars['populateCommentOfThisVideo_arr']['hidden_arr'] ) && $this->_tpl_vars['populateCommentOfThisVideo_arr']['hidden_arr']): ?>
	<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['populateCommentOfThisVideo_arr']['hidden_arr']); ?>

<?php endif; ?>
<?php if (isset ( $this->_tpl_vars['populateCommentOfThisVideo_arr']['row'] ) && $this->_tpl_vars['populateCommentOfThisVideo_arr']['row']): ?>
	<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
	<div class="clsCommentsViewVideopaging">
		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

	    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</div>
	<?php endif; ?>
	<table class="clsTable100" summary="<?php echo $this->_tpl_vars['LANG']['viewvideo_tbl_summary']; ?>
" id="selVideoCommentTable">
		<?php $_from = $this->_tpl_vars['populateCommentOfThisVideo_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cmKey'] => $this->_tpl_vars['cmValue']):
?>
	        <tr class="<?php echo $this->_tpl_vars['cmValue']['class']; ?>
" id="cmd<?php echo $this->_tpl_vars['cmValue']['record']['video_comment_id']; ?>
">
	        	<td>
	            	<div class="clsCommentContainer">
	            	    <div id="commentUserProfile_<?php echo $this->_tpl_vars['cmValue']['record']['video_comment_id']; ?>
" class="clsCoolMemberActive"  style="display:none;" ></div>
	                    <div class="clsCommentImage">
	                        <div class=""  >
					    		<a href="<?php echo $this->_tpl_vars['cmValue']['memberProfileUrl']; ?>
" class="Cls45x45 ClsImageBorder1 ClsImageContainer"><img src="<?php echo $this->_tpl_vars['cmValue']['icon']['s_url']; ?>
" border="0" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['cmValue']['name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
"  <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['cmValue']['icon']['s_width'],$this->_tpl_vars['cmValue']['icon']['s_height']); ?>
 /></a>
	                        </div>
	                    </div>
						<div class="clsCommentContent">
						<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

         				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'viewvideocomments_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	                        <p class="clsMembersName"><a href="<?php echo $this->_tpl_vars['cmValue']['comment_member_profile_url']; ?>
"><?php echo $this->_tpl_vars['cmValue']['name']; ?>
</a><span class="clsLinkSeperator">|</span><span><?php echo $this->_tpl_vars['cmValue']['record']['pc_date_added']; ?>
</span></p>
	                        <div  id="cmd<?php echo $this->_tpl_vars['cmValue']['record']['video_comment_id']; ?>
_1">
	                            <div class="clsCommentDiv">
	                    			<p id="selEditCommentTxt_<?php echo $this->_tpl_vars['cmValue']['record']['video_comment_id']; ?>
" class="clsVideoCommentDisplay"><?php echo $this->_tpl_vars['cmValue']['makeClickableLinks']; ?>
</p>
	                    			<p id="selEditComments_<?php echo $this->_tpl_vars['cmValue']['record']['video_comment_id']; ?>
"></p>
	                        		<div class="clsOverflow">
	                        			<?php if (isMember ( ) && $this->_tpl_vars['cmValue']['record']['comment_user_id'] == $this->_tpl_vars['CFG']['user']['user_id']): ?>
	                                		<div class="clsEditComment">
	                                        	<p class="clsCommentsReplySection clsCommentsSectionReply">
	                                            	<span id="selViewEditComment_<?php echo $this->_tpl_vars['cmValue']['record']['video_comment_id']; ?>
" class="clsViewPostComment">
	                                                	<a href="javascript:void(0)" onClick="return callAjaxEdit('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
video/viewVideo.php?ajax_page=true&amp;video_id=<?php echo $this->_tpl_vars['myobj']->getFormField('video_id'); ?>
&amp;vpkey=<?php echo $this->_tpl_vars['myobj']->getFormField('vpkey'); ?>
&amp;show=<?php echo $this->_tpl_vars['myobj']->getFormField('show'); ?>
','<?php echo $this->_tpl_vars['cmValue']['record']['video_comment_id']; ?>
')"><?php echo $this->_tpl_vars['LANG']['viewvideo_edit']; ?>
</a>
	                                            	</span>
	                                        	</p>
	                                		</div>
											<div>
	                                    		<p class="clsCommentsReplySection">
	                                        		<span id="selViewDeleteComment_<?php echo $this->_tpl_vars['cmValue']['record']['video_comment_id']; ?>
">
	                                            		<a class="clsButton4" href="javascript:void(0)" onClick="return Confirmation('selMsgConfirmWindow', 'msgConfirmform', Array('comment_id', 'confirmationMsg', 'commentorreply'), Array('<?php echo $this->_tpl_vars['cmValue']['record']['video_comment_id']; ?>
', '<?php echo $this->_tpl_vars['LANG']['viewvideo_confirm_txt']; ?>
', 'deletecomment'), Array('value', 'html', 'value'))"><?php echo $this->_tpl_vars['LANG']['viewvideo_delete']; ?>
</a>
	                                        		</span>
	                                    		</p>
	                                		</div>
	                           			<?php elseif (isMember ( )): ?>
	                                        <div>
											<div id="selAddComments_<?php echo $this->_tpl_vars['cmValue']['record']['video_comment_id']; ?>
" style="display:none;">
													<div class="clsEditCommentTextAreaComment">
													<table class="clsTable100">
														<tr>
													    	<td><textarea class="clsWidth99" name="comment_<?php echo $this->_tpl_vars['cmValue']['record']['video_comment_id']; ?>
" id="comment_<?php echo $this->_tpl_vars['cmValue']['record']['video_comment_id']; ?>
" rows="5" cols="80"></textarea></td>
													    </tr>
													    <tr>
													    	<td colspan="2">
																<div class="clsButtonHolder">
																	<p class="clsCommentsSectionReply">
																		<input class="clsCommentDiscard" type="button" onClick="return addToReply('<?php echo $this->_tpl_vars['cmValue']['record']['video_comment_id']; ?>
', '<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
video/viewVideo.php?ajax_page=true&video_id=<?php echo $this->_tpl_vars['myobj']->getFormField('video_id'); ?>
&vpkey=<?php echo $this->_tpl_vars['myobj']->getFormField('vpkey'); ?>
&show=<?php echo $this->_tpl_vars['myobj']->getFormField('show'); ?>
')" name="post_comment" id="post_comment" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['postcomment_post_comment']; ?>
" /></p><p><input class="clsCommentDiscard" type="button" onClick="return discardReply('selAddComments_<?php echo $this->_tpl_vars['cmValue']['record']['video_comment_id']; ?>
', '<?php echo $this->_tpl_vars['cmValue']['record']['video_comment_id']; ?>
')" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['postcomment_cancel']; ?>
" /></p></div>
													    	</td>
													    </tr>
													</table>
													</div>
												</div>
												<div class="clsOverflow">
												<p class="clsCommentsReplySection">
		                                            <span id="selViewPostComment_<?php echo $this->_tpl_vars['cmValue']['record']['video_comment_id']; ?>
" class="clsViewPostComment">
		                                                <a href="javascript:void(0)" onclick="showReplyToCommentsOption('selAddComments_<?php echo $this->_tpl_vars['cmValue']['record']['video_comment_id']; ?>
');" title="<?php echo $this->_tpl_vars['LANG']['viewvideo_reply_comment']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewvideo_reply_comment']; ?>
</a>
		                                            </span>
		                                        </p>
												</div>

											</div>
		                          		<?php endif; ?>
	                        			<?php if (isMember ( ) && $this->_tpl_vars['cmValue']['record']['comment_user_id'] != $this->_tpl_vars['CFG']['user']['user_id']): ?>
				                            <?php if ($this->_tpl_vars['myobj']->getFormField('user_id') == $this->_tpl_vars['CFG']['user']['user_id']): ?>
				                                <div>
				                                    <p class="clsCommentsReplySection">
				                                        <span id="selViewDeleteComment_<?php echo $this->_tpl_vars['cmValue']['record']['video_comment_id']; ?>
">
				                                            <a class="clsButton4" href="javascript:void(0)" onClick="return Confirmation('selMsgConfirmWindow', 'msgConfirmform', Array('comment_id', 'confirmationMsg', 'commentorreply'), Array('<?php echo $this->_tpl_vars['cmValue']['record']['video_comment_id']; ?>
', '<?php echo $this->_tpl_vars['LANG']['viewvideo_confirm_txt']; ?>
', 'deletecomment'), Array('value', 'html', 'value'))"><?php echo $this->_tpl_vars['LANG']['viewvideo_delete']; ?>
</a>
				                                        </span>
				                                    </p>
				                                </div>
				                            <?php endif; ?>
	                        			<?php endif; ?>
	                        		</div>
	                        		<div id="selReplyForComments_<?php echo $this->_tpl_vars['cmValue']['record']['video_comment_id']; ?>
">
	                        			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'populateReplyForCommentsOfThisVideo.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	                    			</div>
	                    		</div>
	                    	</div>
					<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

         			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'viewvideocomments_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	             		</div>
				 	</div>
	            </td>
	        </tr>
	    <?php endforeach; endif; unset($_from); ?>
	</table>
	<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

	    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endif; ?>
<?php else: ?>
	<table class="clsTable100" summary="<?php echo $this->_tpl_vars['LANG']['viewvideo_tbl_summary']; ?>
" id="selVideoCommentTable">
        <tr>
        	<td>
            	<div class="clsCommentContainer clsNoRecordsFound">
            		<p><?php echo $this->_tpl_vars['LANG']['no_comments_for_this_video']; ?>
</p>
			 	</div>
            </td>
        </tr>
	</table>
<?php endif; ?>
</form>