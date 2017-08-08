<?php /* Smarty version 2.6.18, created on 2014-04-10 15:53:26
         compiled from reportBugs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'reportBugs.tpl', 56, false),)), $this); ?>
<?php echo '
	<script type="text/javascript" language="javascript">
		var block_arr= new Array(\'selMsgConfirm\', \'selDelInfoconfirm\');
		var bug_id = \'\';
		var confirm_message = \'\';
		function getAction()
			{
				var act_value = document.selListStaticForm.action.value;
				if(act_value)
					{
						switch(act_value)
							{
								case \''; ?>
<?php echo $this->_tpl_vars['LANG']['bug_close']; ?>
<?php echo '\':
									confirm_message = \''; ?>
<?php echo $this->_tpl_vars['LANG']['confirm_close']; ?>
<?php echo '\';
								break;
							}
						$Jq(\'#msgConfirmText\').html(confirm_message);
						document.msgConfirmform.action.value = act_value;
						document.msgConfirmform.act.value = \'\';
						Confirmation(\'selMsgConfirm\', \'msgConfirmform\', Array(\'bug_ids\'), Array(multiCheckValue), Array(\'value\'),\'selListStaticForm\');
					}
			}
		function postBugReply(url, pars, txt_id, bid)
			{
				var message = $Jq(\'#\'+txt_id).val();
				$Jq(\'#reply_bugs_\'+bid).attr(\'disabled\', \'true\');
				pars += \'&message=\'+escape(message);
				$Jq.ajax({
					type: "POST",
					url: url,
					data: pars,
					success: function(response){
						result = response.split(\'|\');
						if(result[0] == \'success\')
							{
								$Jq(\'#msgreplySpanID_\'+bid).hide();
								$Jq(\'#user_reply_\'+bid).val(\'\');
								$Jq(\'#trBugs_\'+bid).html(result[1]);
							}
						else if(result[0] == \'error\')
							{
								$Jq(\'#msgreplySpanID_\'+bid).html(result[1]);
							}
					}
				 });
				return false;
			}
		</script>
'; ?>

<div id="selMsgConfirm" style="display:none;">
	<p id="msgConfirmText"></p>
	<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCUrrentUrl(); ?>
" autocomplete="off">
		<table class="clsCommonTable" summary="<?php echo $this->_tpl_vars['LANG']['member_tbl_summary']; ?>
">
			<tr>
				<td>
					<input type="submit" class="clsSubmitButton" name="yes" id="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
					&nbsp;
					<input type="button" class="clsCancelButton" name="no" id="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hideAllBlocks('selListStaticForm')" />
				</td>
			</tr>
		</table>
        <input type="hidden" name="act" id="act" />
        <input type="hidden" name="bug_ids" id="bug_ids" />
        <input type="hidden" name="action" id="action" />
		<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->list_records_confirm_arr); ?>

	</form>
</div>
<div id="selReportBugs">
	<h2><?php echo $this->_tpl_vars['LANG']['reportbugs_title']; ?>
</h2>
	<div class="clsCommonInsideContent clsAdminReportBugs">
		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

		    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

			<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_reportbugs')): ?>
				<form name="form_reportbugs_show" id="form_reportbugs_show" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
					<!-- clsFormSection - starts here -->
					<table class="clsFormTbl">
						<tr class="clsFormRow">
							<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('subject'); ?>
">
								<?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>

								<label for="subject"><?php echo $this->_tpl_vars['LANG']['reportbugs_subject']; ?>
</label>
							</td>
							<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('subject'); ?>
">
								<select name="subject" id="subject" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('subject'); ?>
">
									<?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['bug_list_array'],$this->_tpl_vars['myobj']->getFormField('subject')); ?>

								</select>
								<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('subject'); ?>

							</td>
						</tr>
						<tr class="clsFormRow">
							<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('message'); ?>
">
								<?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>

								<label for="message"><?php echo $this->_tpl_vars['LANG']['reportbugs_message']; ?>
&nbsp;</label>
							</td>
							<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('message'); ?>
">
								<textarea name="message" id="message" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" rows="4" cols="45"><?php echo $this->_tpl_vars['myobj']->getFormField('message'); ?>
</textarea>
								<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('message'); ?>

							</td>
						</tr>
						<tr class="clsFormRow">
							<td class="clsButtonAlignment <?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('default'); ?>
"></td>
							<td>
								<input type="submit" class="clsSubmitButton" name="submit_reportbugs" id="submit_reportbugs" value="<?php echo $this->_tpl_vars['LANG']['reportbugs_submit']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
							</td>
						</tr>
					</table>
					<!-- clsFormSection - ends here -->
				</form>
			<?php endif; ?>
			<div class="clsReportBugLinks">
            	<?php if ($this->_tpl_vars['myobj']->getFormField('order') != 'all' && $this->_tpl_vars['myobj']->getFormField('order') != ''): ?>
            		<a href="reportBugs.php?order=all"><?php echo $this->_tpl_vars['LANG']['all']; ?>
</a>
                <?php else: ?>
                	<?php echo $this->_tpl_vars['LANG']['all']; ?>

                <?php endif; ?>
                |
                <?php if ($this->_tpl_vars['myobj']->getFormField('order') != 'open'): ?>
               		 <a href="reportBugs.php?order=open"><?php echo $this->_tpl_vars['LANG']['open']; ?>
</a>
                <?php else: ?>
                	<?php echo $this->_tpl_vars['LANG']['open']; ?>

                <?php endif; ?>
                |
                <?php if ($this->_tpl_vars['myobj']->getFormField('order') != 'close'): ?>
                    <a href="reportBugs.php?order=close"><?php echo $this->_tpl_vars['LANG']['close']; ?>
</a>
                <?php else: ?>
                	<?php echo $this->_tpl_vars['LANG']['close']; ?>

                <?php endif; ?>
            </div>
			<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_bugs_list')): ?>
				<h3 id="selBugsListHeading"><?php echo $this->_tpl_vars['LANG']['bugs_list']; ?>
</h3>
				<form name="selListStaticForm" id="selListStaticForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
">
					<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
							<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

                    		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array('opt' => 'top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    <?php endif; ?>
					<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->block_sel_page_list['hidden_arr']); ?>

					<!-- clsDataDisplaySection - starts here -->
					<div class="clsReportBugList">
	                    <table class="clsDataRow <?php echo $this->_tpl_vars['myobj']->getCSSRowClass(); ?>
">
						<tr>
							<?php if ($this->_tpl_vars['myobj']->getFormField('order') != 'close'): ?>
								<th class="clsAlignCenter"><input type="checkbox" class="clsCheckRadio" id="check_all" onclick="CheckAll(document.selListStaticForm.name, document.selListStaticForm.check_all.name)" name="check_all" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></th>
							<?php endif; ?>
							<th><?php echo $this->_tpl_vars['LANG']['reportbugs_subject']; ?>
</th>
							<th><?php echo $this->_tpl_vars['LANG']['reportbugs_message']; ?>
</th>
						</tr>
						<?php $_from = $this->_tpl_vars['myobj']->block_sel_page_list['populateBugsList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pblkey'] => $this->_tpl_vars['pblvalue']):
?>
							<tr>
								<?php if ($this->_tpl_vars['myobj']->getFormField('order') != 'close'): ?>
									<td class="clsAlignCenter"><input type="checkbox" class="clsCheckRadio" name="bug_ids[]" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['pblvalue']['record']['bug_id']; ?>
" onclick="deselectCheckBox(document.selListStaticForm.name, document.selListStaticForm.check_all.name)"/></td>
								<?php endif; ?>
								<td><p class="clsBugReportSubject"><?php echo $this->_tpl_vars['pblvalue']['record']['bug_subject']; ?>
</p></td>
								<td>
                                	<div class="clsReportSubject">
                                        <p class="clsReportBugTitle"><?php echo $this->_tpl_vars['pblvalue']['record']['bug_content']; ?>
</p>
                                        <p><span class=""><?php echo $this->_tpl_vars['LANG']['date_added']; ?>
</span>&nbsp;&nbsp;:&nbsp;&nbsp; <?php echo $this->_tpl_vars['myobj']->getFormatedDate($this->_tpl_vars['pblvalue']['record']['date_added'],$this->_config[0]['vars']['format_datetime']); ?>
</p>
                                        <p><span class=""><?php echo $this->_tpl_vars['LANG']['posted_by']; ?>
</span>&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $this->_tpl_vars['pblvalue']['record']['reply_from']; ?>
</p>
                                        <p><span class=""><?php echo $this->_tpl_vars['LANG']['common_status']; ?>
</span>&nbsp;:&nbsp;<?php echo $this->_tpl_vars['pblvalue']['record']['status']; ?>
</p>
                                    </div>
                                    <?php if ($this->_tpl_vars['pblvalue']['populateBugReplyList']): ?>
                                        <div class="clsAllReportRepplies">
                                            <div id="trBugs_<?php echo $this->_tpl_vars['pblvalue']['record']['bug_id']; ?>
" class="clsReportReplies">
                                                <div>

                                                    <?php $_from = $this->_tpl_vars['pblvalue']['populateBugReplyList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pbrlkey'] => $this->_tpl_vars['pbrlvalue']):
?>
                                                        <div class="clsBugReply">
                                                            <p class="clsReportBugTitle"><?php echo $this->_tpl_vars['pbrlvalue']['record']['bug_content']; ?>
</p>
                                                            <p><span class=""><?php echo $this->_tpl_vars['LANG']['date_added']; ?>
</span>&nbsp;&nbsp;:&nbsp;&nbsp; <?php echo $this->_tpl_vars['myobj']->getFormatedDate($this->_tpl_vars['pbrlvalue']['record']['date_added'],$this->_config[0]['vars']['format_datetime']); ?>
</p>
                                                            <p><span class=""><?php echo $this->_tpl_vars['LANG']['posted_by']; ?>
</span>&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $this->_tpl_vars['pbrlvalue']['record']['reply_from']; ?>
</p>
                                                            <p><span class=""><?php echo $this->_tpl_vars['LANG']['common_status']; ?>
</span>&nbsp;:&nbsp;<?php echo $this->_tpl_vars['pbrlvalue']['record']['status']; ?>
</p>
                                                        </div>
                                                    <?php endforeach; endif; unset($_from); ?>
                                                </div>
                                                <?php if ($this->_tpl_vars['pblvalue']['populateBugReplyList'] && $this->_tpl_vars['pblvalue']['record']['status'] != 'Closed'): ?>
                                                    <p class="clsReplayText"><a href="<?php echo $this->_tpl_vars['pblvalue']['replybugs_open']['url']; ?>
" onclick="$Jq('#msg<?php echo $this->_tpl_vars['pblvalue']['replySpanIDId']; ?>
').show();return false;"><?php echo $this->_tpl_vars['LANG']['replybugs_reply']; ?>
</a></p>
                                                <?php endif; ?>
                                                  <div class="clsReplaBugReplayTable">
                                              		  <div id="msg<?php echo $this->_tpl_vars['pblvalue']['replySpanIDId']; ?>
" style="display:none">

                                                        <table>
                                                        <tr class="clsFormRow">
                                                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('message'); ?>
">
																<label for="message">
                                                                	<?php echo $this->_tpl_vars['LANG']['reportbugs_message']; ?>

																</label>
                                                                <?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>

                                                            </td>
                                                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('message'); ?>
">
                                                                <textarea name="user_reply_<?php echo $this->_tpl_vars['pblvalue']['record']['bug_id']; ?>
" id="user_reply_<?php echo $this->_tpl_vars['pblvalue']['record']['bug_id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" rows="4" cols="45"><?php echo $this->_tpl_vars['myobj']->getFormField('message'); ?>
</textarea>
                                                                <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('message'); ?>

                                                            </td>
                                                        </tr>
                                                        <tr class="clsFormRow">
                                                            <td class="clsButtonAlignment <?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('default'); ?>
"></td>
                                                            <td>
                                                                <input type="hidden" name="bug_id" id="bug_id" value="<?php echo $this->_tpl_vars['pblvalue']['record']['bug_id']; ?>
"  />
                                                                <input type="button" class="clsSubmitButton" name="reply_bugs" id="reply_bugs_<?php echo $this->_tpl_vars['pblvalue']['record']['bug_id']; ?>
" value="<?php echo $this->_tpl_vars['LANG']['reportbugs_submit']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="postBugReply('<?php echo $this->_tpl_vars['pblvalue']['replybugs_open']['url']; ?>
','postYourReply=1&bug_id=<?php echo $this->_tpl_vars['pblvalue']['record']['bug_id']; ?>
&parent_id=<?php echo $this->_tpl_vars['pblvalue']['record']['parent_id']; ?>
','user_reply_<?php echo $this->_tpl_vars['pblvalue']['record']['bug_id']; ?>
','<?php echo $this->_tpl_vars['pblvalue']['record']['bug_id']; ?>
');" />
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    </div>
                                                </div>
											</div>
                                        </div>
                                     <?php endif; ?>
								</td>
							</tr>
						<?php endforeach; endif; unset($_from); ?>
						<?php if ($this->_tpl_vars['myobj']->getFormField('order') != 'close'): ?>
							<tr>
								<td colspan="3"  class="clsButtonAlignment <?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
">
                                    <input type="hidden" value="<?php echo $this->_tpl_vars['LANG']['bug_close']; ?>
" name="action" id="action" />
                                    <input type="button" class="clsSubmitButton" name="todo" id="todo" onclick="getMultiCheckBoxValue('selListStaticForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['select_a_bug']; ?>
');if(multiCheckValue!='')getAction()" value="<?php echo $this->_tpl_vars['LANG']['bug_close']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
								</td>
							</tr>
						<?php endif; ?>
					</table>
                    </div>
                    <!-- clsDataDisplaySection - ends here -->
                    <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
                    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array('opt' => 'bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    <?php endif; ?>
				</form>
			<?php endif; ?>
		</div>
</div>