<?php /* Smarty version 2.6.18, created on 2012-02-03 21:13:52
         compiled from manageVideoResponses.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'manageVideoResponses.tpl', 11, false),)), $this); ?>
<div id="selManageMusicResponses">
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
     <div class="clsOverflow">
 		<div class="clsVideoListHeading">
	    <h2><span><?php echo $this->_tpl_vars['myobj']->form_manage_responses['responses_title']; ?>
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
" <?php if ($this->_tpl_vars['myobj']->getFormField('comment_status') == $this->_tpl_vars['LANG']['common_yes_option']): ?>Selected<?php endif; ?>><?php echo $this->_tpl_vars['LANG']['manage_comment_activate']; ?>
</option>
								<option value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" <?php if ($this->_tpl_vars['myobj']->getFormField('comment_status') == $this->_tpl_vars['LANG']['common_no_option']): ?>Selected<?php endif; ?>><?php echo $this->_tpl_vars['LANG']['manage_response_inactivate']; ?>
</option>
							</select>
				</form>
        </div>
    </div>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	 <!-- confirmation box -->
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
			<table summary="<?php echo $this->_tpl_vars['LANG']['manage_response_tbl_summary']; ?>
">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_confirm']; ?>
" />
						&nbsp;
						<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
"  onClick="return hideAllBlocks('selFormForums');" />
						<input type="hidden" name="response_ids" id="response_ids" />
						<input type="hidden" name="action" id="action" />
						<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->form_manage_responses['form_hidden_value']); ?>

					</td>
				</tr>
			</table>
		</form>
	</div>
    <!-- confirmation box-->
   	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('responses_form')): ?>
      		<div id="selManageResponsesDisplay" class="clsLeftSideDisplayTable">

				<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
					<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
						<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php endif; ?>
	  <form name="responsesForm" id="responsesForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
      					<div class="clsDataTable">
						<table summary="<?php echo $this->_tpl_vars['myobj']->form_manage_responses['responses_tbl_summary']; ?>
" class="clsMyMusicAlbumTbl">
						  <tr>
							<th class="clsAlignCenter">
								<input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CheckAll(document.responsesForm.name, document.responsesForm.check_all.name)" />							</th>
							<th><?php echo $this->_tpl_vars['LANG']['manage_response_video_image']; ?>
</th>
							<th><?php echo $this->_tpl_vars['LANG']['manage_response_original_image']; ?>
</th>
							<th><?php echo $this->_tpl_vars['LANG']['manage_response_by']; ?>
</th>
							<th><?php echo $this->_tpl_vars['LANG']['manage_response_date']; ?>
</th>
                            <th><?php echo $this->_tpl_vars['LANG']['manage_response_status']; ?>
</th>
						  </tr>
						  <?php if ($this->_tpl_vars['myobj']->form_manage_responses['responses_list']): ?>
							<?php $_from = $this->_tpl_vars['myobj']->form_manage_responses['responses_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
								<tr>
								  <td class="clsWidth20"><input type="checkbox" class="clsCheckRadio" name="response_ids[]" value="<?php echo $this->_tpl_vars['value']['response_id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="disableHeading('responsesForm');"/></td>
								  <td id="selMusicGallery" class="clsViewThumbImageMediumWidth">
                                      <div class="clsOverflow">
                                            <div class="clsThumbImageLink">
                                                <a href="<?php echo $this->_tpl_vars['value']['respose_video_url']; ?>
" class="ClsImageContainer ClsImageBorder Cls107x80 clsPointer">
                                                     <img src="<?php echo $this->_tpl_vars['value']['respose_video_img_src']; ?>
" border="0" title="<?php echo $this->_tpl_vars['value']['respose_video_title']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(93,70,$this->_tpl_vars['value']['s_width'],$this->_tpl_vars['value']['s_height']); ?>
/>
                                                 </a>
                                            </div>
                                      </div>
                                    <p class="clsResponseVideoText"><?php echo $this->_tpl_vars['value']['respose_video_title']; ?>
</p>
                                  </td>
                                <td id="selMusicGallery" class="clsViewThumbImageMediumWidth">
                                        <div class="clsOverflow">
                                          <div class="clsThumbImageLink clsPointer">
                                                <a href="<?php echo $this->_tpl_vars['value']['original_video_url']; ?>
"class="ClsImageContainer ClsImageBorder Cls107x80 clsPointer">
                                                <img src="<?php echo $this->_tpl_vars['value']['original_video_img_src']; ?>
" border="0" title="<?php echo $this->_tpl_vars['value']['original_video_title']; ?>
" />
                                                </a>
                                          </div>
                                  	 </div>
                                    <p class="clsResponseVideoText"><?php echo $this->_tpl_vars['value']['original_video_title']; ?>
</p>								  </td>
								  <td><a href="<?php echo $this->_tpl_vars['value']['response_user_url']; ?>
"><?php echo $this->_tpl_vars['value']['response_user_name']; ?>
</a></td>
								  <td class="clsWidth90"><?php echo $this->_tpl_vars['value']['response_date_added']; ?>
</td>
								  <td class="clsWidth90">
                                  	<?php if ($this->_tpl_vars['value']['video_responses_status'] == 'Yes'): ?>
                                   		<?php echo $this->_tpl_vars['LANG']['manage_response_activate']; ?>

                                    <?php else: ?>
                                    	<?php echo $this->_tpl_vars['LANG']['manage_response_inactive']; ?>

                                    <?php endif; ?>
                                  </td>
								</tr>
							<?php endforeach; endif; unset($_from); ?>
						  <?php endif; ?>
						  <tr>
							<td></td>
                            <td colspan="5" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('response_submit'); ?>
">
								<a href="#" id="dAltMulti"></a>

								<div class="clsGreyButtonSelect"><select name="action" id="action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" >
                                    <option value="" <?php if ($this->_tpl_vars['myobj']->getFormField('response_status') == ''): ?>Selected<?php endif; ?>><?php echo $this->_tpl_vars['LANG']['common_select_option']; ?>
</option>
                                    <option value="activate" ><?php echo $this->_tpl_vars['LANG']['manage_response_active']; ?>
</option>
                                   <option value="inactive" ><?php echo $this->_tpl_vars['LANG']['manage_response_inactive']; ?>
</option>
                                   	<option value="delete"><?php echo $this->_tpl_vars['LANG']['manage_response_delete']; ?>
</option>
								</select></div>
                                <div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="button" name="action_button" id="action_button" value="<?php echo $this->_tpl_vars['LANG']['manage_response_submit']; ?>
" onClick="getMultiCheckBoxValue('responsesForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['manage_response_err_tip_select_titles']; ?>
');if(multiCheckValue!='') getAction()"/>						</div></div>

                            </td>
						  </tr>
		  </table>
          				</div>
			  </form>
					<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
                    	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
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
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<script type="text/javascript">
<?php echo '
	function changeCommentStatus(statusVal)
		{
			document.commentStatusForm.submit();
		}
'; ?>

</script>