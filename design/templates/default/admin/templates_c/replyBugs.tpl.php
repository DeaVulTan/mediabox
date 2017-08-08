<?php /* Smarty version 2.6.18, created on 2014-04-10 15:53:23
         compiled from replyBugs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'replyBugs.tpl', 64, false),)), $this); ?>
<div id="selreplyBugs">
		<h2><?php echo $this->_tpl_vars['LANG']['replybugs_title']; ?>
</h2>
		<div class="clsCommonInsideContent clsReplayBugsMain">
			<div class="clsReportBugLinks">
				<?php if ($this->_tpl_vars['myobj']->getFormField('order') != 'all' && $this->_tpl_vars['myobj']->getFormField('order') != ''): ?>
					<a href="replyBugs.php?order=all"><?php echo $this->_tpl_vars['LANG']['all']; ?>
</a>
				<?php else: ?>
					<?php echo $this->_tpl_vars['LANG']['all']; ?>

				<?php endif; ?>
				|
				<?php if ($this->_tpl_vars['myobj']->getFormField('order') != 'open'): ?>
					 <a href="replyBugs.php?order=open"><?php echo $this->_tpl_vars['LANG']['open']; ?>
</a>
				<?php else: ?>
					<?php echo $this->_tpl_vars['LANG']['open']; ?>

				<?php endif; ?>
				|
				<?php if ($this->_tpl_vars['myobj']->getFormField('order') != 'close'): ?>
				    <a href="replyBugs.php?order=close"><?php echo $this->_tpl_vars['LANG']['close']; ?>
</a>
				<?php else: ?>
					<?php echo $this->_tpl_vars['LANG']['close']; ?>

				<?php endif; ?>
			</div>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_bugs_list')): ?>
				<form name="selListStaticForm" id="selListStaticForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
">
				<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->block_sel_page_list['hidden_arr']); ?>

				<!-- clsDataDisplaySection - starts here -->
				<?php $_from = $this->_tpl_vars['myobj']->block_sel_page_list['populateBugsList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pblkey'] => $this->_tpl_vars['pblvalue']):
?>
						<table class="clsBugManagementTbl <?php echo $this->_tpl_vars['myobj']->getCSSRowClass(); ?>
">
							<tr>
                            	<td>
									<div class="clsReportSubject">
										<p class="clsReportBugTitle"><?php echo $this->_tpl_vars['pblvalue']['record']['bug_subject']; ?>
</p>
										<p><?php echo $this->_tpl_vars['pblvalue']['record']['bug_site']; ?>
</p>
										<p><?php echo $this->_tpl_vars['pblvalue']['record']['bug_content']; ?>
</p>
										<p><span class=""><?php echo $this->_tpl_vars['LANG']['date_added']; ?>
</span>&nbsp;&nbsp;:&nbsp;&nbsp; <?php echo $this->_tpl_vars['myobj']->getFormatedDate($this->_tpl_vars['pblvalue']['record']['date_added'],$this->_config[0]['vars']['format_datetime']); ?>
</p>
										<p><span class=""><?php echo $this->_tpl_vars['LANG']['posted_by']; ?>
</span>&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $this->_tpl_vars['pblvalue']['record']['reply_from']; ?>
</p>
										<p><span class=""><?php echo $this->_tpl_vars['LANG']['status']; ?>
</span>&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $this->_tpl_vars['pblvalue']['record']['status']; ?>
</p>
									</div>
									<p class="clsReplayText"><a href="javascript:void(0);" onclick="$Jq('#msgreplySpanID_<?php echo $this->_tpl_vars['pblvalue']['record']['bug_id']; ?>
').show();return false;"><?php echo $this->_tpl_vars['LANG']['replybugs_reply']; ?>
</a></p>
									<?php if ($this->_tpl_vars['pblvalue']['populateBugReplyList']): ?>
										<div class="clsAllReportRepplies">
											<?php $_from = $this->_tpl_vars['pblvalue']['populateBugReplyList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pbrlkey'] => $this->_tpl_vars['pbrlvalue']):
?>
                                                <div class="clsBugReply <?php echo $this->_tpl_vars['pbrlvalue']['record']['class_client_post']; ?>
">
                                                    <p class="clsReportBugTitle"><?php echo $this->_tpl_vars['pbrlvalue']['record']['bug_content']; ?>
</p>
                                                    <p><span class=""><?php echo $this->_tpl_vars['LANG']['date_added']; ?>
</span>&nbsp;&nbsp;:&nbsp;&nbsp; <?php echo $this->_tpl_vars['myobj']->getFormatedDate($this->_tpl_vars['pbrlvalue']['record']['date_added'],$this->_config[0]['vars']['format_datetime']); ?>
</p>
                                                    <p><span class=""><?php echo $this->_tpl_vars['LANG']['posted_by']; ?>
</span>&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $this->_tpl_vars['pbrlvalue']['record']['reply_from']; ?>
</p>
												</div>
											<?php endforeach; endif; unset($_from); ?>
										</div>
									<?php endif; ?>

										<div id="msgreplySpanID_<?php echo $this->_tpl_vars['pblvalue']['record']['bug_id']; ?>
" style="display:none">
                                        	<div class="clsReplaBugReplayTable clsAllReportRepplies">
                                                <form name="form_replybugs_show" id="form_replybugs_show" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
?start=<?php echo $this->_tpl_vars['myobj']->getFormField('start'); ?>
&order=<?php echo $this->_tpl_vars['myobj']->getFormField('order'); ?>
">
                                                    <!-- clsFormSection - starts here -->
                                                    <table class="clsFormTbl">
                                                        <tr class="clsFormRow">
                                                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('message'); ?>
">
	                                                            <?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>

                                                                <label for="message"><?php echo $this->_tpl_vars['LANG']['replybugs_message']; ?>
</label>
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
                                                            <td></td>
                                                            <td class="clsButtonAlignment <?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('default'); ?>
">
                                                                                                                                <input type="hidden" name="bid" id="bid" value="<?php echo $this->_tpl_vars['pblvalue']['record']['bug_id']; ?>
" />
                                                                <input type="submit" class="clsSubmitButton" name="submit_replyBugs" id="submit_replyBugs" value="<?php echo $this->_tpl_vars['LANG']['replybugs_submit']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                                                                <input type="submit" class="clsCancelButton" name="submit_cancel" id="submit_cancel" value="<?php echo $this->_tpl_vars['LANG']['replybugs_cancel']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- clsFormSection - ends here -->
                                                </form>
											</div>
										</div>
								</td>
							</tr>
						</table>
					<?php endforeach; endif; unset($_from); ?>
					<!-- clsDataDisplaySection - ends here -->
					<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/pagination.tpl', 'smarty_include_vars' => array('opt' => 'bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php endif; ?>
				</form>
			<?php endif; ?>
		</div>
</div>