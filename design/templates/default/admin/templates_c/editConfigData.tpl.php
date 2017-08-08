<?php /* Smarty version 2.6.18, created on 2011-10-17 14:58:33
         compiled from editConfigData.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'editConfigData.tpl', 39, false),)), $this); ?>
<?php if (! isAjaxPage ( )): ?>
	<div id="tabsview">
		<ul>
			<?php $_from = $this->_tpl_vars['myobj']->cname_array; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cakey'] => $this->_tpl_vars['cavalue']):
?>
				<?php $this->assign('label_name', "config_data_".($this->_tpl_vars['cakey'])); ?>
				<?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin'): ?>
					<li><a href="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
?cname=<?php echo $this->_tpl_vars['cakey']; ?>
&module=<?php echo $this->_tpl_vars['myobj']->module; ?>
"><?php echo $this->_tpl_vars['LANG'][$this->_tpl_vars['label_name']]; ?>
</a></li>
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
<?php else: ?>
	<div id="seldevManageConfig">
		<div>
	  		<h2><?php echo $this->_tpl_vars['LANG']['editconfigdata_title']; ?>
</h2>
			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "information.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_config_edit')): ?>
				<div class="clsDataTable">
					<?php $this->assign('c_name', $this->_tpl_vars['myobj']->getFormField('cname')); ?>
					<form name="form_editconfig_<?php echo $this->_tpl_vars['myobj']->getFormField('cname'); ?>
" id="form_editconfig_<?php echo $this->_tpl_vars['myobj']->getFormField('cname'); ?>
" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" onsubmit="" autocomplete="off">
				        <table summary="<?php echo $this->_tpl_vars['LANG']['editconfigdata_tbl_summary']; ?>
">
				        	<?php $_from = $this->_tpl_vars['myobj']->block_config_edit['populateConfig']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cvkey'] => $this->_tpl_vars['cvvalue']):
?>
				        		<?php if ($this->_tpl_vars['cvvalue']['config_section']): ?>
						        	<tr>
						        		<th colspan="2"><?php echo $this->_tpl_vars['cvvalue']['config_section']; ?>
</td>
									</tr>
				        		<?php endif; ?>
							   	<tr>
									<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('dim1'); ?>
">
										<?php if ($this->_tpl_vars['cvvalue']['config_type'] == 'Boolean'): ?>
											<label for="<?php echo $this->_tpl_vars['cvvalue']['label_id']; ?>
1"><?php echo $this->_tpl_vars['cvvalue']['description']; ?>
</label>
										<?php else: ?>
											<label for="<?php echo $this->_tpl_vars['cvvalue']['label_id']; ?>
"><?php echo $this->_tpl_vars['cvvalue']['description']; ?>
</label>
										<?php endif; ?>
									</td>
									<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('dim1'); ?>
">
										<?php if ($this->_tpl_vars['cvvalue']['config_type'] == 'Boolean'): ?>
											<input type="radio" name="<?php echo $this->_tpl_vars['cvvalue']['label_id']; ?>
" id="<?php echo $this->_tpl_vars['cvvalue']['label_id']; ?>
1" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="1" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio($this->_tpl_vars['cvvalue']['label_id'],'1'); ?>
 /> <label for="<?php echo $this->_tpl_vars['cvvalue']['label_id']; ?>
1"><?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
</label>
											<input type="radio" name="<?php echo $this->_tpl_vars['cvvalue']['label_id']; ?>
" id="<?php echo $this->_tpl_vars['cvvalue']['label_id']; ?>
0" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="0" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio($this->_tpl_vars['cvvalue']['label_id'],'0'); ?>
 /> <label for="<?php echo $this->_tpl_vars['cvvalue']['label_id']; ?>
0"><?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
</label>
					                    <?php else: ?>
					                    	<input type="text" class="clsTextBox" name="<?php echo $this->_tpl_vars['cvvalue']['label_id']; ?>
" id="<?php echo $this->_tpl_vars['cvvalue']['label_id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['cvvalue']['label_id']); ?>
" />
					                    <?php endif; ?>
					                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip($this->_tpl_vars['cvvalue']['label_id']); ?>

					                    <?php if ($this->_tpl_vars['cvvalue']['help_text']): ?>
					                    	<?php echo $this->_tpl_vars['myobj']->ShowHelpTip($this->_tpl_vars['cvvalue']['help_text'],$this->_tpl_vars['cvvalue']['label_id']); ?>

					                    <?php endif; ?>
					                </td>
							   	</tr>
						   	<?php endforeach; endif; unset($_from); ?>
						   	<tr>
								<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
" colspan="2">
									<input type="submit" class="clsSubmitButton" name="add_submit" id="add_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_update']; ?>
" onClick="$Jq('#act_<?php echo $this->_tpl_vars['myobj']->getFormField('cname'); ?>
').val('add_submit'); return postAjaxForm('form_editconfig_<?php echo $this->_tpl_vars['myobj']->getFormField('cname'); ?>
', 'ui-tabs-<?php echo $this->_tpl_vars['myobj']->cname_array[$this->_tpl_vars['c_name']]; ?>
')" />
								</td>
							</tr>
						</table>
						<input type="hidden" name="cname" value="<?php echo $this->_tpl_vars['myobj']->getFormField('cname'); ?>
" />
						<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['myobj']->getFormField('module'); ?>
" />
						<input type="hidden" name="act" id="act_<?php echo $this->_tpl_vars['myobj']->getFormField('cname'); ?>
" value="" />

					</form>
			   	</div>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>