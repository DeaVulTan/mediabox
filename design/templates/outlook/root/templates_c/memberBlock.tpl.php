<?php /* Smarty version 2.6.18, created on 2012-03-05 14:35:52
         compiled from memberBlock.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'memberBlock.tpl', 24, false),array('function', 'counter', 'memberBlock.tpl', 120, false),array('modifier', 'truncate', 'memberBlock.tpl', 100, false),array('modifier', 'date_format', 'memberBlock.tpl', 115, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selMemberBlockFormHandler">
   <div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['LANG']['memberblock_title']; ?>
</h2></div>
   	<?php if (isMember ( )): ?>
     <div class="clsPaddingLeftRight">
	   	<p class="clsBrowseMemberLink">
	   	<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('memberslist'); ?>
" class="selMemberBrowseLinkID"><?php echo $this->_tpl_vars['LANG']['common_members_list_list_members']; ?>
</a>
	   	<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('membersbrowse'); ?>
" class="selMemberBrowseLinkID"><?php echo $this->_tpl_vars['LANG']['common_members_list_browse_members']; ?>
</a>
   		</p>
   </div>
   <?php endif; ?>

      <?php if (! $this->_tpl_vars['myobj']->isResultsFound()): ?>
		<div class="clsNoteMessage">
              <span class="clsNoteTitle"><?php echo $this->_tpl_vars['LANG']['memberblock_note']; ?>
</span>:&nbsp;<?php echo $this->_tpl_vars['LANG']['memberblock_info']; ?>
&nbsp;<?php echo $this->_tpl_vars['LANG']['memberblock_info1']; ?>

            </div>
      <?php endif; ?>

    <!-- confirmation box -->
    <div id="selMsgConfirm" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getUrl('memberblock'); ?>
">
			<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_confirm']; ?>
" />
			&nbsp;
			<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
"  onclick="return hideAllBlocks('selFormForums');" />
			<input type="hidden" name="block_ids" id="block_ids" />
            <input type="hidden" name="block_id" id="block_id" />
			<input type="hidden" name="action" id="action" />
            <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_block_listing')): ?>
				<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->paging_arr); ?>

            <?php endif; ?>
		</form>
	</div>
    <!-- confirmation box-->
 	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('msg_form_success_block_unblock') && isset ( $this->_tpl_vars['myobj']->success_msg ) && $this->_tpl_vars['myobj']->success_msg): ?>
		  <div id="selMsgSuccess">
		   	<p><?php echo $this->_tpl_vars['myobj']->success_msg; ?>
</p>
			<p class="clsMsgAdditionalText"><a href="<?php echo $this->_tpl_vars['myobj']->msg_form_success_block_unblock['blockUserProfileUrl']; ?>
"><?php echo $this->_tpl_vars['LANG']['memberblock_back_profile']; ?>
</a></p>
		  </div>
	<?php endif; ?>
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('msg_form_success_unblock')): ?>
        <div id="selMsgSuccess">
            <p><?php echo $this->_tpl_vars['LANG']['memberblock_unblock_success']; ?>
</p>
        </div>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_block') && $this->_tpl_vars['myobj']->getFormField('block_id')): ?>
        <div class="clsMsgConfirmation"><div class="clsMsgConfirm">
            <p>
           		<?php echo $this->_tpl_vars['myobj']->form_block['nl2br_user_name']; ?>

            </p>
                <form name="form_block" id="formAddToGroup" method="post" action="<?php echo $this->_tpl_vars['myobj']->getUrl('memberblock'); ?>
" autocomplete="off">
                    <table summary="<?php echo $this->_tpl_vars['LANG']['memberblock_tbl_summary']; ?>
" >
                        <tr>
                        <td>
                        <?php if ($this->_tpl_vars['myobj']->alreadyBlocked()): ?>
                        	<input type="button" class="clsSubmitButton" name="Unblock" id="Unblock" value="<?php echo $this->_tpl_vars['LANG']['memberblock_unblock']; ?>
" tabIndex="<?php echo smartyTabIndex(array(), $this);?>
"  onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('block_id', 'action', 'confirmMessage'), Array(document.form_block.block_id.value, 'Unblock', '<?php echo $this->_tpl_vars['LANG']['memberblock_unblock_confirm_message']; ?>
'), Array('value', 'value', 'html'),'selFormForums');"  />
                        <?php else: ?>
                        	<input type="button" class="clsSubmitButton" name="Block" id="Block" value="<?php echo $this->_tpl_vars['LANG']['memberblock_block']; ?>
" tabIndex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('block_id', 'action', 'confirmMessage'), Array(document.form_block.block_id.value, 'Block', '<?php echo $this->_tpl_vars['LANG']['memberblock_block_confirm_message']; ?>
'), Array('value', 'value', 'html'),'selFormForums');" />
                        <?php endif; ?>
                        &nbsp;&nbsp;
                        <a href="<?php echo $this->_tpl_vars['myobj']->form_block['blockUserProfileUrl']; ?>
"><input type="submit" class="clsSubmitButton" name="cancel" id="cancel" value="<?php echo $this->_tpl_vars['LANG']['memberblock_cancel']; ?>
" tabIndex="<?php echo smartyTabIndex(array(), $this);?>
"  /></a>
                        </td>
                        </tr>
                    </table>
                	<input type="hidden" name="block_id" value="<?php echo $this->_tpl_vars['myobj']->getFormField('block_id'); ?>
" />
                </form>
        </div></div>
	<?php endif; ?>
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_block_listing')): ?>
    	<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
            <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>

            <form name="formBlockedMembers" id="formBlockedMembers" method="post" action="<?php echo $this->_tpl_vars['myobj']->getUrl('memberblock'); ?>
">
           	<?php $this->assign('table_header', '1'); ?>
            <?php $this->assign('i', '0'); ?>
			<?php $this->assign('count', 1); ?>
            	<?php $_from = $this->_tpl_vars['myobj']->form_block_listing['showBlockList']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
                	<?php if ($this->_tpl_vars['table_header']): ?>
                    	<div class="clsDataTable clsMembersDataTable clsPaddingTop9">
                        <table summary="<?php echo $this->_tpl_vars['LANG']['blocklist_tbl_summary']; ?>
" class="clsMyPhotoAlbumTbl">
                            <tr>
                                <th class="clsWidth20"><input type="checkbox" class="clsCheckRadio" onclick="CheckAll(document.formBlockedMembers.name, document.formBlockedMembers.check_all.name)" name="check_all" id="check_all" value="" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></th>
                                <th colspan="2"><?php echo $this->_tpl_vars['LANG']['blocklist_details']; ?>
</th>
                            </tr>
                          <?php $this->assign('table_header', '0'); ?>
                     <?php endif; ?>
                     <tr class="<?php if ($this->_tpl_vars['count'] % 2 == 0): ?> clsAlternateRecord<?php endif; ?>">
							<td class="clsWidth20"><input type="checkbox" class="clsCheckRadio" name="block_ids[]" value="<?php echo $this->_tpl_vars['value']['record']['id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="disableHeading('formBlockedMembers');"/></td>
							<td class="clsUserThumImagetd selPhotoGallery">
                            <div class="clsOverflow">
								<?php if ($this->_tpl_vars['value']['icon']): ?>
									<div class="clsThumbImageContainer clsMemberImageContainer clsFloatLeft">
                                    	<div class="clsThumbImageContainer">
                                        	<a class="ClsImageContainer ClsImageBorder2 Cls66x66" href="<?php echo $this->_tpl_vars['value']['getMemberProfileUrl']; ?>
">
                                       			<img src="<?php echo $this->_tpl_vars['value']['icon']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['value']['record']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 7) : smarty_modifier_truncate($_tmp, 7)); ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['image_small_width'],$this->_config[0]['vars']['image_small_height'],$this->_tpl_vars['value']['icon']['s_width'],$this->_tpl_vars['value']['icon']['s_height']); ?>
 />
											</a>
                                        </div>
									</div>
                                <?php endif; ?>
								<p class="selMemberName clsGroupSmallImg clsFloatLeft">
									<a href="<?php echo $this->_tpl_vars['value']['getMemberProfileUrl']; ?>
">
										<?php echo $this->_tpl_vars['value']['name']; ?>

									</a>
								</p>
                             </div>								
							</td>
							<td>
							 <div class="clsBlockedList">
								<p><span><?php echo $this->_tpl_vars['LANG']['blocklist_name']; ?>
</span><?php echo $this->_tpl_vars['value']['record']['first_name']; ?>
&nbsp;<?php echo $this->_tpl_vars['value']['record']['last_name']; ?>
</p>
								<p><span><?php echo $this->_tpl_vars['LANG']['blocklist_date_added']; ?>
</span><?php echo ((is_array($_tmp=$this->_tpl_vars['value']['record']['date_added'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_date_year']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_date_year'])); ?>
</p>
							 </div>	
							</td>
						</tr>
							<?php $this->assign('count', $this->_tpl_vars['count']+1); ?>
                        	<?php echo smarty_function_counter(array('assign' => 'i'), $this);?>

                       <?php endforeach; endif; unset($_from); ?>
						</table>
                       <?php if (! $this->_tpl_vars['i']): ?>
                           <div id="selMsgAlert">
                                <p><?php echo $this->_tpl_vars['LANG']['blocklist_no_blocks']; ?>
</p>
                            </div>
                       <?php else: ?>
                       		<div class="clsOverflow">
				            	<div class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('unblock'); ?>
 clsPadding10">
							  		<input type="hidden" name="start" value="<?php echo $this->_tpl_vars['myobj']->getFormField('start'); ?>
" />
                                    <div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="button" class="clsSubmitButton" name="blocklist_unblock" id="blocklist_unblock" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['blocklist_unblock']; ?>
" onclick="getMultiCheckBoxValue('formBlockedMembers', 'check_all', '<?php echo $this->_tpl_vars['LANG']['memberblock_err_tip_select_titles']; ?>
');if(multiCheckValue!='') getAction()" /> </div></div>
																</div>
				            </div>
                        </div>
                       <?php endif; ?>

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
				<p><?php echo $this->_tpl_vars['LANG']['memberblock_no_blocked_member']; ?>
 </p>
			</div>
		<?php endif; ?>
    <?php endif; ?>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>