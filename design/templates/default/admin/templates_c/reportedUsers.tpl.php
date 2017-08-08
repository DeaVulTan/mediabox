<?php /* Smarty version 2.6.18, created on 2011-12-29 00:22:01
         compiled from reportedUsers.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'reportedUsers.tpl', 6, false),array('modifier', 'date_format', 'reportedUsers.tpl', 58, false),)), $this); ?>
<div id="selVideoList">
	<h2><span><?php echo $this->_tpl_vars['LANG']['reported_users_title']; ?>
</span></h2>
  	<div id="selMsgConfirm" style="display:none;">
  		<p id="confirmMessage"></p>
    	<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
    		<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" />&nbsp;
        	<input type="button" class="clsCancelButton" name="no" id="no" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
"  onClick="return hideAllBlocks();" />
        	<input type="hidden" name="reported_user_ids" id="reported_user_ids" />
        	<input type="hidden" name="select_action" id="select_action" />
			<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hiddenArr); ?>

    	</form>
  	</div>

	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_report_details')): ?>
	 	<div class="clsBackToReport"><a href="reportedUsers.php"><?php echo $this->_tpl_vars['LANG']['back_to_reports']; ?>
</a></div>
	<?php endif; ?>

	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "information.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

 	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_report_details')): ?>
 		<div id="selFlaggedDetails">
    		<?php if (isset ( $this->_tpl_vars['reported_user_details'] )): ?>
	        	<h4>
	        		<?php echo $this->_tpl_vars['LANG']['reports_for']; ?>

				</h4>
	        		<a href="<?php echo $this->_tpl_vars['reported_user_link']; ?>
">
		        		<img src="<?php echo $this->_tpl_vars['reported_user_details']['icon']['t_url']; ?>
" alt="<?php echo $this->_tpl_vars['reported_user_details']['display_name']; ?>
" title="<?php echo $this->_tpl_vars['reported_user_details']['display_name']; ?>
" <?php if ($this->_tpl_vars['reported_user_details']['icon']['t_width']): ?> <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['image_thumb_width'],$this->_config[0]['vars']['image_thumb_height'],$this->_tpl_vars['reported_user_details']['icon']['t_width'],$this->_tpl_vars['reported_user_details']['icon']['t_height']); ?>
" <?php endif; ?>/>
		        	</a>
	            	<p><a href="<?php echo $this->_tpl_vars['reported_user_link']; ?>
"><?php echo $this->_tpl_vars['reported_user_details']['display_name']; ?>
</a></p>
	    		<table summary="<?php echo $this->_tpl_vars['LANG']['reportedusers_tbl_summary']; ?>
">
	        		<tr>
	                	<th class="clsWidth100"><?php echo $this->_tpl_vars['LANG']['header_reported_by']; ?>
</th>
	                	<th class="clsSelectSmall"><?php echo $this->_tpl_vars['LANG']['reportedusers_flaged_text']; ?>
</th>
		                <th class="clsCustomMessage"><?php echo $this->_tpl_vars['LANG']['reportedusers_additional_message']; ?>
</th>
		                <th class="clsSelectSmall"><?php echo $this->_tpl_vars['LANG']['reportedusers_date_added']; ?>
</th>
			        </tr>
		            <?php unset($this->_sections['det']);
$this->_sections['det']['name'] = 'det';
$this->_sections['det']['loop'] = is_array($_loop=$this->_tpl_vars['myobj']->flaggedContents) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['det']['show'] = true;
$this->_sections['det']['max'] = $this->_sections['det']['loop'];
$this->_sections['det']['step'] = 1;
$this->_sections['det']['start'] = $this->_sections['det']['step'] > 0 ? 0 : $this->_sections['det']['loop']-1;
if ($this->_sections['det']['show']) {
    $this->_sections['det']['total'] = $this->_sections['det']['loop'];
    if ($this->_sections['det']['total'] == 0)
        $this->_sections['det']['show'] = false;
} else
    $this->_sections['det']['total'] = 0;
if ($this->_sections['det']['show']):

            for ($this->_sections['det']['index'] = $this->_sections['det']['start'], $this->_sections['det']['iteration'] = 1;
                 $this->_sections['det']['iteration'] <= $this->_sections['det']['total'];
                 $this->_sections['det']['index'] += $this->_sections['det']['step'], $this->_sections['det']['iteration']++):
$this->_sections['det']['rownum'] = $this->_sections['det']['iteration'];
$this->_sections['det']['index_prev'] = $this->_sections['det']['index'] - $this->_sections['det']['step'];
$this->_sections['det']['index_next'] = $this->_sections['det']['index'] + $this->_sections['det']['step'];
$this->_sections['det']['first']      = ($this->_sections['det']['iteration'] == 1);
$this->_sections['det']['last']       = ($this->_sections['det']['iteration'] == $this->_sections['det']['total']);
?>
		            	<tr>
		                    <td>
		                    	<a href="<?php echo $this->_tpl_vars['myobj']->flaggedContents[$this->_sections['det']['index']]['reporter_link']; ?>
">
		                    		<img src="<?php echo $this->_tpl_vars['myobj']->flaggedContents[$this->_sections['det']['index']]['reporter_avatar']; ?>
" alt="<?php echo $this->_tpl_vars['myobj']->flaggedContents[$this->_sections['det']['index']]['reporter_name']; ?>
" title="<?php echo $this->_tpl_vars['myobj']->flaggedContents[$this->_sections['det']['index']]['reporter_name']; ?>
" <?php if ($this->_tpl_vars['myobj']->flaggedContents[$this->_sections['det']['index']]['reporter_avatar_width']): ?> <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['image_thumb_width'],$this->_config[0]['vars']['image_thumb_height'],$this->_tpl_vars['myobj']->flaggedContents[$this->_sections['det']['index']]['reporter_avatar_width'],$this->_tpl_vars['myobj']->flaggedContents[$this->_sections['det']['index']]['reporter_avatar_height']); ?>
" <?php endif; ?>/>
		                    	</a>
		                    	<a href="<?php echo $this->_tpl_vars['myobj']->flaggedContents[$this->_sections['det']['index']]['reporter_link']; ?>
">
			                        <?php echo $this->_tpl_vars['myobj']->flaggedContents[$this->_sections['det']['index']]['reporter_name']; ?>

								</a>
							</td>
		                    <td>
		                    	<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['myobj']->flaggedContents[$this->_sections['det']['index']]['flag']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
			                    	<?php echo $this->_tpl_vars['myobj']->flaggedContents[$this->_sections['det']['index']]['flag'][$this->_sections['i']['index']]['flag']; ?>
 <br />
		                        <?php endfor; endif; ?>
							</td>
		                    <?php if ($this->_tpl_vars['myobj']->flaggedContents[$this->_sections['det']['index']]['custom_message']): ?>
			                    <td><?php echo $this->_tpl_vars['myobj']->flaggedContents[$this->_sections['det']['index']]['custom_message']; ?>
</td>
		                    <?php else: ?>
		                    	<td>-</td>
		                    <?php endif; ?>
		                    <td><?php echo ((is_array($_tmp=$this->_tpl_vars['myobj']->flaggedContents[$this->_sections['det']['index']]['date_added'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_date_year']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_date_year'])); ?>
</td>
		                  </tr>
		            <?php endfor; endif; ?>
		        </table>
		    <?php endif; ?>
    	</div>
 	<?php endif; ?>
 	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_reported_users')): ?>
 		<div id="selVideoList">
	    	<form name="reportedListForm" id="reportedListForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
	        	<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
	                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/pagination.tpl', 'smarty_include_vars' => array('opt' => 'top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	            <?php endif; ?>
	        	<table summary="<?php echo $this->_tpl_vars['LANG']['reportedusers_tbl_summary']; ?>
">
	            	<tr>
	                	<th class="clsAlignCenter clsWidth20">
	                        <input type="checkbox" class="clsCheckRadio" name="check_all" onclick = "CheckAll(document.reportedListForm.name, document.reportedListForm.check_all.name)" />
						</th>
	                    <th class="clsWidth100"><?php echo $this->_tpl_vars['LANG']['header_reported_user']; ?>
</th>
	                    <th><?php echo $this->_tpl_vars['LANG']['header_total_requests']; ?>
</th>
	                    <th class="clsSelectSmall"><?php echo $this->_tpl_vars['LANG']['header_option']; ?>
</th>
	                </tr>
	                <?php unset($this->_sections['reports']);
$this->_sections['reports']['name'] = 'reports';
$this->_sections['reports']['loop'] = is_array($_loop=$this->_tpl_vars['myobj']->reportedUsers) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['reports']['show'] = true;
$this->_sections['reports']['max'] = $this->_sections['reports']['loop'];
$this->_sections['reports']['step'] = 1;
$this->_sections['reports']['start'] = $this->_sections['reports']['step'] > 0 ? 0 : $this->_sections['reports']['loop']-1;
if ($this->_sections['reports']['show']) {
    $this->_sections['reports']['total'] = $this->_sections['reports']['loop'];
    if ($this->_sections['reports']['total'] == 0)
        $this->_sections['reports']['show'] = false;
} else
    $this->_sections['reports']['total'] = 0;
if ($this->_sections['reports']['show']):

            for ($this->_sections['reports']['index'] = $this->_sections['reports']['start'], $this->_sections['reports']['iteration'] = 1;
                 $this->_sections['reports']['iteration'] <= $this->_sections['reports']['total'];
                 $this->_sections['reports']['index'] += $this->_sections['reports']['step'], $this->_sections['reports']['iteration']++):
$this->_sections['reports']['rownum'] = $this->_sections['reports']['iteration'];
$this->_sections['reports']['index_prev'] = $this->_sections['reports']['index'] - $this->_sections['reports']['step'];
$this->_sections['reports']['index_next'] = $this->_sections['reports']['index'] + $this->_sections['reports']['step'];
$this->_sections['reports']['first']      = ($this->_sections['reports']['iteration'] == 1);
$this->_sections['reports']['last']       = ($this->_sections['reports']['iteration'] == $this->_sections['reports']['total']);
?>
	                	<tr class="<?php echo $this->_tpl_vars['myobj']->getCSSRowClass(); ?>
">
	                    	<td class="clsAlignCenter"><input type="checkbox" class="clsCheckRadio" name="reported_user_ids[]" value="<?php echo $this->_tpl_vars['myobj']->reportedUsers[$this->_sections['reports']['index']]['reported_user_id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick = "deselectCheckBox(document.reportedListForm.name, document.reportedListForm.check_all.name)"/></td>

	                         <td class="clsAlignCenter">
	                         	<?php if ($this->_tpl_vars['myobj']->reportedUsers[$this->_sections['reports']['index']]['user_details']): ?>
	                            	<a href="<?php echo $this->_tpl_vars['myobj']->reportedUsers[$this->_sections['reports']['index']]['memberProfileUrl']; ?>
">
	                                    <img src="<?php echo $this->_tpl_vars['myobj']->reportedUsers[$this->_sections['reports']['index']]['icon']['t_url']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['image_thumb_width'],$this->_config[0]['vars']['image_thumb_height'],$this->_tpl_vars['myobj']->reportedUsers[$this->_sections['reports']['index']]['icon']['t_width'],$this->_tpl_vars['myobj']->reportedUsers[$this->_sections['reports']['index']]['icon']['t_height']); ?>
 />
	                                </a>
		                         	<p><a href="<?php echo $this->_tpl_vars['myobj']->reportedUsers[$this->_sections['reports']['index']]['memberProfileUrl']; ?>
"><?php echo $this->_tpl_vars['myobj']->reportedUsers[$this->_sections['reports']['index']]['user_details']['display_name']; ?>
</a></p>
	                            <?php else: ?>
	                            	<?php echo $this->_tpl_vars['LANG']['common_user_deleted']; ?>

	                            <?php endif; ?>
	                         </td>
	                         <td>
								<?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['myobj']->reportedUsers[$this->_sections['reports']['index']]['reports']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['j']['show'] = true;
$this->_sections['j']['max'] = $this->_sections['j']['loop'];
$this->_sections['j']['step'] = 1;
$this->_sections['j']['start'] = $this->_sections['j']['step'] > 0 ? 0 : $this->_sections['j']['loop']-1;
if ($this->_sections['j']['show']) {
    $this->_sections['j']['total'] = $this->_sections['j']['loop'];
    if ($this->_sections['j']['total'] == 0)
        $this->_sections['j']['show'] = false;
} else
    $this->_sections['j']['total'] = 0;
if ($this->_sections['j']['show']):

            for ($this->_sections['j']['index'] = $this->_sections['j']['start'], $this->_sections['j']['iteration'] = 1;
                 $this->_sections['j']['iteration'] <= $this->_sections['j']['total'];
                 $this->_sections['j']['index'] += $this->_sections['j']['step'], $this->_sections['j']['iteration']++):
$this->_sections['j']['rownum'] = $this->_sections['j']['iteration'];
$this->_sections['j']['index_prev'] = $this->_sections['j']['index'] - $this->_sections['j']['step'];
$this->_sections['j']['index_next'] = $this->_sections['j']['index'] + $this->_sections['j']['step'];
$this->_sections['j']['first']      = ($this->_sections['j']['iteration'] == 1);
$this->_sections['j']['last']       = ($this->_sections['j']['iteration'] == $this->_sections['j']['total']);
?>
	                            	<p id="clsBold">
	                                	<?php echo $this->_tpl_vars['myobj']->reportedUsers[$this->_sections['reports']['index']]['reports'][$this->_sections['j']['index']]['flag']; ?>
 : <?php echo $this->_tpl_vars['myobj']->reportedUsers[$this->_sections['reports']['index']]['reports'][$this->_sections['j']['index']]['count']; ?>

	                                </p>
	                            <?php endfor; endif; ?>
							</td>
	                        <td><span id="detail"><a href="?action=detail&amp;rid=<?php echo $this->_tpl_vars['myobj']->reportedUsers[$this->_sections['reports']['index']]['reported_user_id']; ?>
&amp;start=<?php echo $this->_tpl_vars['myobj']->getFormField('start'); ?>
"><?php echo $this->_tpl_vars['LANG']['detail']; ?>
</a></span></td>
	                    </tr>
	                <?php endfor; endif; ?>
	                <tr>
					<td colspan="6" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('report_submit'); ?>
">
	           			<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hiddenArr); ?>

	                    <select name="select_action" id="select_action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" >
		                    <option value=""><?php echo $this->_tpl_vars['LANG']['select_one']; ?>
</option>
	                    	<option value="block_user"><?php echo $this->_tpl_vars['LANG']['reportedusers_block']; ?>
</option>
	                        <option value="delete_report"><?php echo $this->_tpl_vars['LANG']['reportedusers_delete_report']; ?>
</option>
	                        <option value="delete_user"><?php echo $this->_tpl_vars['LANG']['reportedusers_delete_user']; ?>
</option>
	                    </select>
						<input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['reportedusers_action_sumbit']; ?>
" onclick="<?php echo 'if(getMultiCheckBoxValue(\'reportedListForm\', \'check_all\', \''; ?>
<?php echo $this->_tpl_vars['LANG']['err_tip_select_user']; ?>
<?php echo '\')){getAction();}'; ?>
" />
					</td>
				</tr>
	            </table>
	            <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
	                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/pagination.tpl', 'smarty_include_vars' => array('opt' => 'bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	            <?php endif; ?>
	        </form>
    	</div>
 	<?php endif; ?>
</div>