<?php /* Smarty version 2.6.18, created on 2012-02-01 20:18:01
         compiled from populateCommentOfThisArticle.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'populateCommentOfThisArticle.tpl', 30, false),array('function', 'smartyTabIndex', 'populateCommentOfThisArticle.tpl', 50, false),)), $this); ?>

<form name="frmVideoComments" id="frmVideoComments" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">


<?php if (isset ( $this->_tpl_vars['populateCommentOfThisArticle_arr']['hidden_arr'] ) && $this->_tpl_vars['populateCommentOfThisArticle_arr']['hidden_arr']): ?>
	<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['populateCommentOfThisArticle_arr']['hidden_arr']); ?>

<?php endif; ?>


<?php if (isset ( $this->_tpl_vars['populateCommentOfThisArticle_arr']['row'] ) && $this->_tpl_vars['populateCommentOfThisArticle_arr']['row']): ?>
	<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
	<div class="clsCommentsViewVideopaging">
		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

	    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</div>
	<?php endif; ?>
	<table class="clsTable100" summary="<?php echo $this->_tpl_vars['LANG']['viewarticle_tbl_summary']; ?>
" id="selVideoCommentTable">
		<?php $_from = $this->_tpl_vars['populateCommentOfThisArticle_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cmKey'] => $this->_tpl_vars['cmValue']):
?>

            <tr class="<?php echo $this->_tpl_vars['cmValue']['class']; ?>
" id="cmd<?php echo $this->_tpl_vars['cmValue']['record']['article_comment_id']; ?>
">
	        	<td>
	            	<div class="clsCommentContainer">
	            	    
                        <div id="commentUserProfile_<?php echo $this->_tpl_vars['cmValue']['record']['article_comment_id']; ?>
" class="clsCoolMemberActive"  style="display:none;" ></div>

	                    <div class="clsCommentImage">
	                                                   <a href="<?php echo $this->_tpl_vars['cmValue']['memberProfileUrl']; ?>
" class="Cls45x45 ClsImageBorder1 ClsImageContainer">
					    		<img src="<?php echo $this->_tpl_vars['cmValue']['icon']['s_url']; ?>
" title="<?php echo $this->_tpl_vars['cmValue']['name']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['cmValue']['name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
"  <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['cmValue']['icon']['s_width'],$this->_tpl_vars['cmValue']['icon']['s_height']); ?>
 />
	                        </a>
	                    </div>
						<div class="clsCommentContent">
                            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

                            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'viewcommentsreply_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                <p class="clsMembersName"><a href="<?php echo $this->_tpl_vars['cmValue']['comment_member_profile_url']; ?>
"><?php echo $this->_tpl_vars['cmValue']['name']; ?>
</a> <span class="clsLinkSeperator">|</span> <span><?php echo $this->_tpl_vars['cmValue']['record']['pc_date_added']; ?>
</span></p>
                                <div  id="cmd<?php echo $this->_tpl_vars['cmValue']['record']['article_comment_id']; ?>
_1">
                                    <div class="clsCommentDiv">
                                        <p id="selEditCommentTxt_<?php echo $this->_tpl_vars['cmValue']['record']['article_comment_id']; ?>
" class="clsReplyValue"><?php echo $this->_tpl_vars['cmValue']['makeClickableLinks']; ?>
</p>
                                        <p class="clsEditCommentTextArea" id="selEditComments_<?php echo $this->_tpl_vars['cmValue']['record']['article_comment_id']; ?>
" style="display:none;"></p>
                                        <div class="clsOverflow">
                                        	<div id="selAddComments_<?php echo $this->_tpl_vars['cmValue']['record']['article_comment_id']; ?>
" style="display:none;" class="clsEditCommentTextArea clsButtonHolder">
                                                <table>
                                                    <tr>
                                                        <td class="clsReplyTextAreaWidth"><textarea name="comment_<?php echo $this->_tpl_vars['cmValue']['record']['article_comment_id']; ?>
" id="comment_<?php echo $this->_tpl_vars['cmValue']['record']['article_comment_id']; ?>
" rows="5" cols="90"></textarea></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="clsSaveBtn">
                                                            <p class="clsEditButton">
                                                               <span> <input type="button" onClick="return addToReply('<?php echo $this->_tpl_vars['cmValue']['record']['article_comment_id']; ?>
', '<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
article/viewArticle.php?ajax_page=true&article_id=<?php echo $this->_tpl_vars['myobj']->getFormField('article_id'); ?>
&vpkey=<?php echo $this->_tpl_vars['myobj']->getFormField('vpkey'); ?>
&show=<?php echo $this->_tpl_vars['myobj']->getFormField('show'); ?>
')" name="post_comment" id="post_comment" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['postcomment_post_comment']; ?>
" /></span>
                                                            </p>
                                                            <p class="clsDeleteButton">
                                                               <span> <input type="button" onClick="return discardReply('selAddComments_<?php echo $this->_tpl_vars['cmValue']['record']['article_comment_id']; ?>
', '<?php echo $this->_tpl_vars['cmValue']['record']['article_comment_id']; ?>
')" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['postcomment_cancel']; ?>
" /></span>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="clsButtonHolder">
                                                <?php if (isMember ( ) && $this->_tpl_vars['cmValue']['record']['comment_user_id'] == $this->_tpl_vars['CFG']['user']['user_id']): ?>
                                                    <p id="selViewEditComment_<?php echo $this->_tpl_vars['cmValue']['record']['article_comment_id']; ?>
" class="clsEditButton">
                                                        <span>
                                                            <a href="javascript:void(0)" onClick="return callAjaxEdit('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
article/viewArticle.php?ajax_page=true&amp;article_id=<?php echo $this->_tpl_vars['myobj']->getFormField('article_id'); ?>
&amp;vpkey=<?php echo $this->_tpl_vars['myobj']->getFormField('vpkey'); ?>
&amp;show=<?php echo $this->_tpl_vars['myobj']->getFormField('show'); ?>
','<?php echo $this->_tpl_vars['cmValue']['record']['article_comment_id']; ?>
')"><?php echo $this->_tpl_vars['LANG']['viewarticle_edit']; ?>
</a>
                                                        </span>
                                                    </p>
                                                    <p id="selViewDeleteComment_<?php echo $this->_tpl_vars['cmValue']['record']['article_comment_id']; ?>
" class="clsDeleteButton">
                                                        <span>
                                                            <a class="clsButton4" href="javascript:void(0)" onClick="return Confirmation('selMsgConfirmWindow', 'msgConfirmform', Array('comment_id', 'confirmationMsg', 'commentorreply'), Array('<?php echo $this->_tpl_vars['cmValue']['record']['article_comment_id']; ?>
', '<?php echo $this->_tpl_vars['LANG']['viewarticle_confirm_txt']; ?>
', 'deletecomment'), Array('value', 'html', 'value'))"><?php echo $this->_tpl_vars['LANG']['viewarticle_delete']; ?>
</a>
                                                        </span>
                                                    </p>
                                                <?php endif; ?>
                                                <?php if (isMember ( ) && $this->_tpl_vars['cmValue']['record']['comment_user_id'] != $this->_tpl_vars['CFG']['user']['user_id']): ?>
                                                    <p class="<?php if (( isMember ( ) && $this->_tpl_vars['cmValue']['record']['comment_user_id'] != $this->_tpl_vars['CFG']['user']['user_id'] ) && ( $this->_tpl_vars['myobj']->getFormField('user_id') == $this->_tpl_vars['CFG']['user']['user_id'] )): ?>  clsEditButton <?php else: ?> clsReplyButton <?php endif; ?>" id="selViewPostComment_<?php echo $this->_tpl_vars['cmValue']['record']['article_comment_id']; ?>
">
                                                        <span>
                                                            <a href="javascript:void(0)" onclick="showReplyToCommentsOption('selAddComments_<?php echo $this->_tpl_vars['cmValue']['record']['article_comment_id']; ?>
');" title="<?php echo $this->_tpl_vars['LANG']['viewarticle_reply_comment']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewarticle_reply_comment']; ?>

                                                            </a>
                                                        </span>
                                                    </p>
                                                <?php endif; ?>
                                                <?php if (isMember ( ) && $this->_tpl_vars['cmValue']['record']['comment_user_id'] != $this->_tpl_vars['CFG']['user']['user_id']): ?>
                                                    <?php if ($this->_tpl_vars['myobj']->getFormField('user_id') == $this->_tpl_vars['CFG']['user']['user_id']): ?>
                                                    <p id="selViewDeleteComment_<?php echo $this->_tpl_vars['cmValue']['record']['article_comment_id']; ?>
">
                                                        <span>
                                                            <a class="clsButton4" href="javascript:void(0)" onClick="return Confirmation('selMsgConfirmWindow', 'msgConfirmform', Array('comment_id', 'confirmationMsg', 'commentorreply'), Array('<?php echo $this->_tpl_vars['cmValue']['record']['article_comment_id']; ?>
', '<?php echo $this->_tpl_vars['LANG']['viewarticle_confirm_txt']; ?>
', 'deletecomment'), Array('value', 'html', 'value'))"><?php echo $this->_tpl_vars['LANG']['viewarticle_delete']; ?>
</a>
                                                        </span>
                                                    </p>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div id="selReplyForComments_<?php echo $this->_tpl_vars['cmValue']['record']['article_comment_id']; ?>
">
                                            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'populateReplyForCommentsOfThisArticle.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                        </div>
                                    </div>
                                </div>
                        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'viewcommentsreply_bottom')));
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
		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

	    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endif; ?>
<?php else: ?>
	<table class="clsTable100" summary="<?php echo $this->_tpl_vars['LANG']['viewarticle_tbl_summary']; ?>
" id="selVideoCommentTable">
        <tr>
        	<td>
            	<div class="clsCommentContainer clsNoArticlesFound">
            		<p><?php echo $this->_tpl_vars['LANG']['viewarticle_no_comments_found']; ?>
</p>
			 	</div>
            </td>
        </tr>
	</table>
<?php endif; ?>
</form>