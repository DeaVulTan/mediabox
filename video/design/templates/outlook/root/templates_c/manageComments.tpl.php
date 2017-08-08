<?php /* Smarty version 2.6.18, created on 2012-02-03 21:13:51
         compiled from manageComments.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'manageComments.tpl', 20, false),)), $this); ?>
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
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clsOverflow">
		<div class="clsVideoListHeading">
 			<h2><span><?php echo $this->_tpl_vars['myobj']->form_manage_comments['comments_title']; ?>
</span></h2>
        </div>
        <div class="clsVideoListHeadingRight">
				<form name="commentStatusForm" id="commentStatusForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
							<select name="comment_status" id="comment_status" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onchange="return changeCommentStatus(this.value)">
								<option value="" <?php if ($this->_tpl_vars['myobj']->getFormField('comment_status') == ''): ?>Selected<?php endif; ?>><?php echo $this->_tpl_vars['LANG']['manage_selectbox_all']; ?>
</option>
								<option value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" <?php if ($this->_tpl_vars['myobj']->getFormField('comment_status') == $this->_tpl_vars['LANG']['common_yes_option']): ?>Selected<?php endif; ?>><?php echo $this->_tpl_vars['LANG']['manage_comment_active']; ?>
</option>
								<option value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" <?php if ($this->_tpl_vars['myobj']->getFormField('comment_status') == $this->_tpl_vars['LANG']['common_no_option']): ?>Selected<?php endif; ?>><?php echo $this->_tpl_vars['LANG']['manage_comment_inactive']; ?>
</option>
							</select>
				</form>
        </div>
    </div>
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

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
				<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
					<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
						<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

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
								<input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CheckAll(document.commendsForm.name, document.commendsForm.check_all.name)" />
							</th>
							<th class="clsWidth90"><?php echo $this->_tpl_vars['myobj']->form_manage_comments['comments_module']; ?>
</th>
							<th class="clsWidth90"><?php echo $this->_tpl_vars['LANG']['manage_comment_by']; ?>
</th>
							<th class="clsWidth90"><?php echo $this->_tpl_vars['LANG']['manage_comment_date']; ?>
</th>
							<th><?php echo $this->_tpl_vars['LANG']['manage_comment_option']; ?>
</th>
							<th><?php echo $this->_tpl_vars['LANG']['manage_comment_status']; ?>
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
								  <td id="selMusicGallery">
                                        <div class="clsOverflow">
                                              <div class="clsThumbImageLink">
                                                    <a href="<?php echo $this->_tpl_vars['value']['module_view_link']; ?>
" class="ClsImageContainer ClsImageBorder Cls107x80 clsPointer">
                                                       <img src="<?php echo $this->_tpl_vars['value']['respose_video_img_src']; ?>
" border="0" title="<?php echo $this->_tpl_vars['value']['comment_title']; ?>
" <?php echo $this->_tpl_vars['value']['disp_image']; ?>
/>
                                                      </a> 
                                              </div>
                                        </div>

                                        <a href="<?php echo $this->_tpl_vars['value']['module_view_link']; ?>
"><?php echo $this->_tpl_vars['value']['comment_title']; ?>
</a>
                                      </td>
								  <td id="selMusicGallery">
								  										<p id="selMemberName" class="clsGroupSmallImg"><a href="<?php echo $this->_tpl_vars['value']['member_profile_url']; ?>
"><?php echo $this->_tpl_vars['value']['user_details']; ?>
</a></p>
								  </td>
								  <td><?php echo $this->_tpl_vars['value']['date_added']; ?>
</td>
								  <td>
								  		<span class="clsVideoCommentsList">
                                        <a href="<?php echo $this->_tpl_vars['value']['viewcomment_url']; ?>
" id="manage_<?php echo $this->_tpl_vars['value']['comment_id']; ?>
" title="<?php echo $this->_tpl_vars['value']['comment']; ?>
"><?php echo $this->_tpl_vars['value']['comment']; ?>
</a>
										</span>
								  </td>
                                                  <td>
                                                      <?php if ($this->_tpl_vars['value']['comment_status'] == 'Yes'): ?>
                                                            <?php echo $this->_tpl_vars['LANG']['manage_comment_active']; ?>

                                                      <?php else: ?>
                                                            <?php echo $this->_tpl_vars['LANG']['manage_comment_inactive']; ?>

                                                      <?php endif; ?>
                                                  </td>
								</tr>
							<?php endforeach; endif; unset($_from); ?>
						  <?php endif; ?>
</table>
		                            <div class="clsOverflow">
								<a href="#" id="dAltMulti"></a>
								<div class="clsGreyButtonSelect">
                                                	<select class="clsWidth150" name="action" id="action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" >
                                                      <option value="" <?php if ($this->_tpl_vars['myobj']->getFormField('comment_status') == ''): ?>Selected<?php endif; ?>><?php echo $this->_tpl_vars['LANG']['common_select_option']; ?>
</option>
                                                      <option value="activate" ><?php echo $this->_tpl_vars['LANG']['manage_comment_activate']; ?>
</option>
                                                      <option value="inactivate" ><?php echo $this->_tpl_vars['LANG']['manage_comment_inactivate']; ?>
</option>
                                                      <option value="delete"><?php echo $this->_tpl_vars['LANG']['manage_comment_delete']; ?>
</option>
									</select>
                                                </div>
		                                	<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="button" name="action_button" id="action_button" value="<?php echo $this->_tpl_vars['LANG']['manage_comment_submit']; ?>
" onClick="getMultiCheckBoxValue('commendsForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['manage_comment_err_tip_select_titles']; ?>
');if(multiCheckValue!='') getAction()"/>						</div></div>
		</div>
					</form>
                    </div>
					<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
						<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

						 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php endif; ?>
				<?php else: ?>
					<div id="selMsgAlert">
						<p><?php echo $this->_tpl_vars['LANG']['common_no_records_found']; ?>
</p>
					</div>
				<?php endif; ?>
  		 	</div>
	    <?php endif; ?>
	</div>

<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<script>
<?php echo '
$Jq(document).ready(function() {
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