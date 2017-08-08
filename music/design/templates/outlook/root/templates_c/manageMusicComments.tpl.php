<?php /* Smarty version 2.6.18, created on 2012-02-02 23:12:44
         compiled from manageMusicComments.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'manageMusicComments.tpl', 21, false),)), $this); ?>
<script language="javascript" type="text/javascript" src=cfg_site_url+"js/functions.js"></script>
<?php echo '
<script language="javascript" type="text/javascript">
	var block_arr= new Array(\'selMsgConfirm\');
	function changeCommentStatus(statusVal)
		{
			document.commentStatusForm.submit();
		}
</script>
'; ?>

<div id="selManageMusicComments">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="clsOverflow">                    
              <div class="clsHeadingLeft">                        
                <h2><span><?php echo $this->_tpl_vars['myobj']->form_manage_comments['comments_title']; ?>
</span></h2>
        </div>
        <div class="clsHeadingRight">
				<form name="commentStatusForm" id="commentStatusForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
							<select name="comment_status" id="comment_status" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onchange="return changeCommentStatus(this.value)">
								<option value="" <?php if ($this->_tpl_vars['myobj']->getFormField('comment_status') == ''): ?>Selected<?php endif; ?>><?php echo $this->_tpl_vars['LANG']['managemusiccomments_selectbox_all']; ?>
</option>
								<option value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" <?php if ($this->_tpl_vars['myobj']->getFormField('comment_status') == $this->_tpl_vars['LANG']['common_yes_option']): ?>Selected<?php endif; ?>><?php echo $this->_tpl_vars['LANG']['managemusiccomments_activate']; ?>
</option>
								<option value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" <?php if ($this->_tpl_vars['myobj']->getFormField('comment_status') == $this->_tpl_vars['LANG']['common_no_option']): ?>Selected<?php endif; ?>><?php echo $this->_tpl_vars['LANG']['managemusiccomments_inactivate']; ?>
</option>																		
							</select>
				</form>		          	
        </div>
    </div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    
	<div id="selLeftNavigation">
		<div id="selMsgConfirm" style="display:none;" class="clsMsgConfirm">
    		<p id="selConfirmMsg"></p>
	      	<form name="confirm_form" id="confirm_form" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">

						  	<input type="submit" class="clsSubmitButton" name="yes" id="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /> &nbsp;
			              	<input type="button" class="clsSubmitButton" name="no" id="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hideAllBlocks()" />
			              	<input type="hidden" name="comment_id" id="comment_id" />
							<input type="hidden" name="act" id="act" />
							<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->form_manage_comments['form_hidden_value']); ?>


	      	</form> 
	    </div>
		<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('comments_form')): ?>
      		<div id="selManageCommentsDisplay">
				<?php if ($this->_tpl_vars['myobj']->form_manage_comments['record_found']): ?>
					<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
						<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php endif; ?>	
                    <div class="clsDataTable">
						<form name="commendsForm" id="commendsForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
						<table summary="<?php echo $this->_tpl_vars['myobj']->form_manage_comments['comments_tbl_summary']; ?>
" class="clsMyMusicAlbumTbl">
						  <tr>
							<th>
								<input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CheckAll(document.commendsForm.name, document.commendsForm.check_all.name)" />							</th>
							<th class="clsWidth150"><?php echo $this->_tpl_vars['myobj']->form_manage_comments['comments_module']; ?>
</th>
							<th class="clsWidth90"><?php echo $this->_tpl_vars['LANG']['managemusiccomments_by']; ?>
</th>
							<th class="clsWidth75"><?php echo $this->_tpl_vars['LANG']['managemusiccomments_date']; ?>
</th>
							<th class="clsWidth55"><?php echo $this->_tpl_vars['LANG']['managemusiccomments_status']; ?>
</th>
							<th><?php echo $this->_tpl_vars['LANG']['managemusiccomments_option']; ?>
</th>
						  </tr>
						  <?php if ($this->_tpl_vars['myobj']->form_manage_comments['comments_list']): ?>
							<?php $_from = $this->_tpl_vars['myobj']->form_manage_comments['comments_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
								<tr class="<?php echo $this->_tpl_vars['value']['tr_class']; ?>
">	
								  <td class="clsAlignCenter"><input type="checkbox" class="clsCheckRadio" name="comment_ids[]" value="<?php echo $this->_tpl_vars['value']['comment_id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['value']['comment_chk_value']; ?>
 onClick="disableHeading('commendsForm');"/></td>
								  <td id="selMusicGallery"><p id="selMusicTitle"><a href="<?php echo $this->_tpl_vars['value']['module_view_link']; ?>
"><?php echo $this->_tpl_vars['value']['comment_title']; ?>
</a></p></td>
								  <td id="selMusicGallery">
								  										<p id="selMemberName" class="clsGroupSmallImg"><a href="<?php echo $this->_tpl_vars['value']['member_profile_url']; ?>
"><?php echo $this->_tpl_vars['value']['user_details']; ?>
</a></p>								  </td>
								  <td><?php echo $this->_tpl_vars['value']['date_added']; ?>
</td>
								  <td>
                                  		<?php if ($this->_tpl_vars['value']['comment_status'] == 'Yes'): ?>
                                	  		<?php echo $this->_tpl_vars['LANG']['managemusiccomments_activate']; ?>

	                                    <?php elseif ($this->_tpl_vars['value']['comment_status'] == 'No'): ?>
	                            	  		<?php echo $this->_tpl_vars['LANG']['managemusiccomments_inactivate']; ?>

                                        <?php endif; ?>
                                  </td>
								  <td><span>
                                  <a href="<?php echo $this->_tpl_vars['value']['viewcomment_url']; ?>
" id="manage_<?php echo $this->_tpl_vars['value']['comment_id']; ?>
" title="<?php echo $this->_tpl_vars['value']['comment']; ?>
"><?php echo $this->_tpl_vars['value']['comment']; ?>
</a>
                                 </span></td>
								</tr>	
							<?php endforeach; endif; unset($_from); ?>
						  <?php endif; ?>	
						  <tr>
						  </tr>
						  </table>
						  
						  <table style="border-bottom:0; margin-bottom:0;">
						  <tr>
						  <td style="padding:0">
						  	<div class="clsOverflow"><a href="#" id="dAltMulti"></a>
								<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->form_manage_comments['form_hidden_value']); ?>

								<p class="clsSubmitButton-l">
<span class="clsSubmitButton-r"><input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['managemusiccomments_delete']; ?>
" onClick="if(getMultiCheckBoxValue('commendsForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['common_check_atleast_one']; ?>
', 'dAltMulti', -100, -500))Confirmation('selMsgConfirm', 'confirm_form', Array('comment_id','act', 'selConfirmMsg'), Array(multiCheckValue, 'delete', '<?php echo $this->_tpl_vars['LANG']['managemusiccomments_delete_confirmation']; ?>
'), Array('value','value', 'innerHTML'), 0, 0);" /></span></p>
																	<p class="clsSubmitButton-l">
<span class="clsSubmitButton-r"><input type="button" class="clsSubmitButton" name="activate" id="activate" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['managemusiccomments_activate_button_label']; ?>
" onClick="if(getMultiCheckBoxValue('commendsForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['common_check_atleast_one']; ?>
', 'dAltMulti', -100, -500))Confirmation('selMsgConfirm', 'confirm_form', Array('comment_id','act', 'selConfirmMsg'), Array(multiCheckValue, 'activate', '<?php echo $this->_tpl_vars['LANG']['managemusiccomments_activate_confirmation']; ?>
'), Array('value','value', 'innerHTML'), 200, 100);" /></span></p>
								</div>
						  </td>
						    <td style="padding:0">
						  	<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
						<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

						 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php endif; ?>
						  </td>
						  </tr>
						</table>

					  
</form>
                    </div>
					
				<?php else: ?>
					<div id="selMsgAlert">
						<p><?php echo $this->_tpl_vars['LANG']['common_no_records_found']; ?>
</p>
					</div>
				<?php endif; ?>
  		 	</div>
	    <?php endif; ?>
	</div>

<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<script>
<?php echo '
$Jq(window).load(function() {
    for(var i=0;i<manage_comment_ids.length;i++)
	{
	$Jq(\'#manage_\'+manage_comment_ids[i]).fancybox({
		\'width\'				: 865,
		\'height\'			: \'100%\',
		\'padding\'			:  0,
		\'autoScale\'     	: false,
		\'transitionIn\'		: \'none\',
		\'transitionOut\'		: \'none\',
		\'type\'				: \'iframe\'
	});
	}
});
'; ?>

</script>