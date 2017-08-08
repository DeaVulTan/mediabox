<?php /* Smarty version 2.6.18, created on 2011-12-29 19:53:20
         compiled from profileComments.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'profileComments.tpl', 8, false),array('modifier', 'truncate', 'profileComments.tpl', 69, false),array('modifier', 'date_format', 'profileComments.tpl', 76, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selPostProfileComment">
  	<div class="clsPageHeading"><h2><?php if ($this->_tpl_vars['myobj']->isValidUserId()): ?><a href="<?php echo $this->_tpl_vars['myobj']->profile_url; ?>
"><?php echo $this->_tpl_vars['myobj']->page_title; ?>
</a><?php endif; ?>&nbsp;<?php echo $this->_tpl_vars['LANG']['profile_post_comment_title']; ?>
</h2></div>
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
			<input type="submit" class="clsSubmitButton" name="remove_comments" id="remove_comments" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" />&nbsp;
			<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" onclick="return hideAllBlocks();" />
			<input type="hidden" name="comments" id="comments" />
			<input type="hidden" name="action" id="action" />
		</form>
	</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_post_comment')): ?>

			<div id="selCommentForm" class="clsDataTable">
			<form name="comment_form" id="comment_form" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
		    	<table summary="<?php echo $this->_tpl_vars['LANG']['profile_post_comment_tbl_summary']; ?>
" class="clsPostCommentTable">
					<tr>
		         		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('comment'); ?>
">
							<span class="clsMandatoryFieldIcon"><?php echo $this->_tpl_vars['LANG']['profile_post_comment_important']; ?>
</span><label for="comment"><?php echo $this->_tpl_vars['LANG']['profile_post_comment_comment']; ?>
 </label>
						</td>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('comment'); ?>
">
							<textarea name="comment" id="comment" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" style="width:90%" rows="4" cols="50" class="selInputLimiter"  maxlimit="<?php echo $this->_tpl_vars['myobj']->CFG['profile']['scraps_total_length']; ?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('comment'); ?>
</textarea>
                            <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('comment'); ?>

                            <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('comment'); ?>

						</td>
					</tr>
					<tr>
                    	<td></td>
						<td class="clsFormFieldCellDefault">
							<input type="hidden" name="user_id" value="<?php echo $this->_tpl_vars['myobj']->form_post_comment['user_id']; ?>
" />
							<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="comment_submit" id="comment_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['profile_post_comment_post_comment']; ?>
" /></div></div><div class="clsCancelLeft"><div class="clsCancelRight">
							<input class="clsSubmitButton" onclick="location='<?php echo $this->_tpl_vars['myobj']->form_post_comment['MemberProfileUrl']; ?>
';" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['profile_post_comment_cancel']; ?>
" type="button" /></div></div>
						</td>
					</tr>
				</table>
			</form>
			</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_view_comments')): ?>
<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
<?php $this->assign('count', 1); ?>
  <p class="clsGoBackLink" id="goBack"><a href="<?php echo $this->_tpl_vars['myobj']->form_post_comment['MemberProfileUrl']; ?>
"><?php echo $this->_tpl_vars['LANG']['profile_comment_link_user_profile']; ?>
</a></p>
  <form name="formProfileComment" id="formProfileComment" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
			 <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
        		 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    		 <?php endif; ?>
    <div class="clsDataTable clsMembersDataTable">
    <table summary="<?php echo $this->_tpl_vars['LANG']['profile_comment_listing']; ?>
">
    	<tr>
        <th><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all"  onclick="CheckAll(document.formProfileComment.name, document.formProfileComment.check_all.name)" value="" /></th>
        <th><?php echo $this->_tpl_vars['LANG']['profile_post_comment_from']; ?>
</th>
        <th><?php echo $this->_tpl_vars['LANG']['profile_post_comment_date']; ?>
</th>
        <th><?php echo $this->_tpl_vars['LANG']['profile_comment']; ?>
</th>
        </tr>

      <?php $_from = $this->_tpl_vars['myobj']->form_view_comments['display_comments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['value']):
?>
      <tr class="<?php if ($this->_tpl_vars['count'] % 2 == 0): ?> clsAlternateRecord<?php endif; ?>">
      	<td class="clsWidth20">
        	<?php if ($this->_tpl_vars['value']['editable']): ?>
      			<input type="checkbox" class="clsCheckRadio" name="comments[]" value="<?php echo $this->_tpl_vars['value']['users_profile_comment_id']; ?>
"  onclick="disableHeading('formProfileComment');"/>
             <?php endif; ?>
        </td>
        <td class="clsWidth80">
			<div class="clsOverflow">
                <a href="<?php echo $this->_tpl_vars['value']['MemberProfileUrl']; ?>
" class="ClsImageContainer ClsImageBorder2 Cls66x66">
                    <img src="<?php echo $this->_tpl_vars['value']['profileIcon']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['value']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 7) : smarty_modifier_truncate($_tmp, 7)); ?>
" title="<?php echo $this->_tpl_vars['value']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['image_small_width'],$this->_config[0]['vars']['image_small_height'],$this->_tpl_vars['value']['profileIcon']['s_width'],$this->_tpl_vars['value']['profileIcon']['s_height']); ?>
/>
                </a>
            </div>
            <p  class="clsProfileThumbImg clsProfileComments">
            	<a href="<?php echo $this->_tpl_vars['value']['MemberProfileUrl']; ?>
"><?php echo $this->_tpl_vars['value']['user_name']; ?>
</a>
            </p>
        </td>
	    <td class="clsWidth90 clsMailDateWidth"><p><?php echo ((is_array($_tmp=$this->_tpl_vars['value']['comment_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_datetime']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_datetime'])); ?>
</p></td>
	    <td>
	    	  <div class="clsImageReSize"><p><?php echo $this->_tpl_vars['value']['comment']; ?>
</p></div>
		</td>
      </tr>
	  <?php $this->assign('count', $this->_tpl_vars['count']+1); ?>
      <?php endforeach; endif; unset($_from); ?>
      <?php if ($this->_tpl_vars['myobj']->found): ?>
      	<tr>
      		<td>&nbsp;</td>
        	<td colspan="3">
            	<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="button" class="clsSubmitButton" name="remove_submit" id="remove_submit" value="<?php echo $this->_tpl_vars['LANG']['profile_comment_submit_delete']; ?>
"  onclick="if(getMultiCheckBoxValue('formProfileComment', 'check_all', '<?php echo $this->_tpl_vars['LANG']['profile_comment_err_tip_select_comment']; ?>
', 'dAltMlti', -25, -290)) <?php echo ' { '; ?>
 Confirmation('selMsgConfirm', 'msgConfirmform', Array('comments', 'action', 'confirmMessage'), Array(multiCheckValue, 'remove_submit', '<?php echo $this->_tpl_vars['LANG']['profile_comment_confirm_message']; ?>
'), Array('value', 'value', 'innerHTML'), -25, -290); <?php echo ' } '; ?>
" /></div></div>
			</td>
      	</tr>
      <?php endif; ?>

    </table>
    </div>
  </form>
  <?php else: ?>

  <div id="selMsgAlert">
    <p><?php echo $this->_tpl_vars['LANG']['msg_no_comments']; ?>
</p>

            <?php if (! $this->_tpl_vars['myobj']->form_view_comments['currentAccount']): ?>

                <p class="clsUploadMsg"><a href="<?php echo $this->_tpl_vars['myobj']->form_view_comments['viewUrl']; ?>
">View '<?php echo $this->_tpl_vars['myobj']->form_view_comments['userDetails']['user_name']; ?>
' now</a></p>
                <p class="clsUploadMsg"><a href="<?php echo $this->_tpl_vars['myobj']->form_view_comments['postscrapUrl']; ?>
">Post your Scrap now</a></p>
            <?php endif; ?>
  </div>
	<?php endif; ?> <?php endif; ?></div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>