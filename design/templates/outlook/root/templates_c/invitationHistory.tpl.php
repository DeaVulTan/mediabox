<?php /* Smarty version 2.6.18, created on 2012-01-21 11:39:50
         compiled from invitationHistory.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'invitationHistory.tpl', 5, false),array('modifier', 'date_format', 'invitationHistory.tpl', 45, false),)), $this); ?>
<!-- Confirmation message block start-->
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
        <p id="confirmMessage"></p>
        <form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
">
				<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_confirm']; ?>
" />
				<input type="hidden" name="action" id="action" />
				<input type="hidden" name="id" id="id" />
				<input type="hidden" name="start" id="start" value='<?php echo $this->_tpl_vars['myobj']->getFormField('start'); ?>
' />
        </form>
    </div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selInvitationHistory">
		<div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['LANG']['invitation_history_title']; ?>
</h2></div>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php if (( $this->_tpl_vars['myobj']->isShowPageBlock('form_invite_history') )): ?>
		<div id="selLeftNavigation">
			<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
	 			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endif; ?>
			<form id="formInvitaionHistory" name="formInvitationHistory" method="post" action="<?php echo $this->_tpl_vars['myobj']->form_invitaion_history['pageActionUrl']; ?>
">
							<div class="clsDataTable clsMembersDataTable">
								<table summary="<?php echo $this->_tpl_vars['LANG']['invitation_history_tbl_summary']; ?>
" id="selInviteHistoryTbl">
									<tr>
                                    	<th class="">
                                        	<input type="checkbox" class="clsCheckRadio" name="history_id_all" id="history_id_all" onClick="checkAll(this.checked)" />
											<?php $_from = $this->_tpl_vars['myobj']->form_invitaion_history['showPopulateHidden']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ssokey'] => $this->_tpl_vars['ssovalue']):
?>
												<input type="hidden" name="<?php echo $this->_tpl_vars['ssovalue']['field_name']; ?>
" value="<?php echo $this->_tpl_vars['ssovalue']['field_value']; ?>
" />
											<?php endforeach; endif; unset($_from); ?>
                                        </th>
										<th class="<?php echo $this->_tpl_vars['myobj']->getCSSColumnHeaderCellClass('date_added'); ?>
"><a href="<?php echo $this->_tpl_vars['myobj']->form_invitaion_history['dateOrderByUrl']; ?>
" title="<?php echo $this->_tpl_vars['myobj']->form_invitaion_history['dateOrderByTitle']; ?>
"><?php echo $this->_tpl_vars['LANG']['invitation_history_date']; ?>
</a></th>
										<th><?php echo $this->_tpl_vars['LANG']['invitation_history_attempts']; ?>
</th>
										<th><?php echo $this->_tpl_vars['LANG']['invitation_history_email']; ?>
</th>
										<th><?php echo $this->_tpl_vars['LANG']['invitation_history_status']; ?>
</th>
										<th><?php echo $this->_tpl_vars['LANG']['invitation_history_action']; ?>
</th>
									</tr>
									<?php if ($this->_tpl_vars['myobj']->form_invitaion_history['inviteHistory']): ?>
										<?php $_from = $this->_tpl_vars['myobj']->form_invitaion_history['inviteHistory']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
											<tr>
												<td>
													<?php if ($this->_tpl_vars['value']['status'] != 'Joined'): ?>
														<input type="checkbox" class="clsCheckRadio" name="history_id[]" value="<?php echo $this->_tpl_vars['value']['check_box_value']; ?>
" onClick="isCheckedAll()"/>
													<?php endif; ?>
												</td>
												<td><?php echo ((is_array($_tmp=$this->_tpl_vars['value']['date_added'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_date_year']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_date_year'])); ?>
</td>
												<td><?php echo $this->_tpl_vars['value']['attempts']; ?>
</td>
												<td class="clsInviteEmail"><?php echo $this->_tpl_vars['value']['email']; ?>
</td>
												<td class="<?php echo $this->_tpl_vars['value']['class']; ?>
"><?php echo $this->_tpl_vars['value']['status']; ?>
</td>
												<td class="clsRemind">
													<?php if ($this->_tpl_vars['value']['status'] != 'Joined'): ?>
														<a id="selRemindLink" href="<?php echo $this->_tpl_vars['value']['remind_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['invitation_history_individual_remind']; ?>
</a>&nbsp;|&nbsp;
													<?php endif; ?>
													<a href="#" onClick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('id', 'action', 'confirmMessage'), Array('<?php echo $this->_tpl_vars['value']['check_box_value']; ?>
', 'delete', '<?php echo $this->_tpl_vars['LANG']['common_confirm_delete']; ?>
'), Array('value', 'value', 'innerHTML'));"><?php echo $this->_tpl_vars['LANG']['invitation_history_individual_delete']; ?>
</a>
												</td>
											</tr>
								        <?php endforeach; endif; unset($_from); ?>
							        <?php else: ?>
								        <tr>
										<td><?php echo $this->_tpl_vars['LANG']['exturl_no_exturl']; ?>
</td>
										</tr>
							        <?php endif; ?>
								</table>
										<div class="clsPadding10 clsOverflow">
											<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" name="remind_submit" id="remind_submit" value="<?php echo $this->_tpl_vars['LANG']['invitation_history_remind_all']; ?>
" onclick="<?php echo 'if(getMultiCheckBoxValue(\'formInvitationHistory\', \'history_id_all\', \''; ?>
<?php echo $this->_tpl_vars['LANG']['common_check_atleast_one']; ?>
<?php echo '\')){return true;}else{return false;}'; ?>
" /></div></div>
										</div>
                            </div>
	     	</form>
			<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
		         <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		    <?php endif; ?>

			<?php echo '
			<script language="javascript">
			  function checkAll(chkd){
				chks = document.formInvitationHistory.getElementsByTagName(\'input\');
					for(i=0; i<chks.length; i++){
							if(chks[i].type==\'checkbox\' && chks[i].name.indexOf(\'history_id\')==0)
							chks[i].checked = chkd;
					}
				}
				function isCheckedAll(){
				chks = document.formInvitationHistory.getElementsByTagName(\'input\');
				var tInput = 0;
				var tChkd = 0;
					for(i=0; i<chks.length; i++){
							if(chks[i].type==\'checkbox\'  && chks[i].name.indexOf(\'history_id\')==0 && chks[i].name!=\'history_id_all\'){
								tInput += 1;
								tChkd  += chks[i].checked?1:0
							}
						}
				document.formInvitationHistory.history_id_all.checked = (tInput==tChkd);
				}
			</script>
			'; ?>

		</div>
	<?php endif; ?>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>