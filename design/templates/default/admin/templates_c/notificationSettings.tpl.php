<?php /* Smarty version 2.6.18, created on 2011-12-22 23:51:23
         compiled from notificationSettings.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'notificationSettings.tpl', 21, false),)), $this); ?>
<div id="selNotificationSettings">
	<div>
  		<h2><?php echo $this->_tpl_vars['LANG']['notificationSettings_title']; ?>
</h2>
		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "information.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_notification_edit')): ?>
			<div class="clsDataTable">
				<form name="form_editnotification" id="form_editnotification" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" autocomplete="off">
			        <table summary="<?php echo $this->_tpl_vars['LANG']['notificationSettings_tbl_summary']; ?>
">
			        	<tr>
			        		<th><?php echo $this->_tpl_vars['LANG']['notificationSettings_notification']; ?>
</th>
			        		<th><?php echo $this->_tpl_vars['LANG']['notificationSettings_module']; ?>
</th>
			        		<th><?php echo $this->_tpl_vars['LANG']['notificationSettings_default_status']; ?>
</th>
			        		<th><?php echo $this->_tpl_vars['LANG']['notificationSettings_changeable_by_user']; ?>
</th>
			        	</tr>
			        	<?php $_from = $this->_tpl_vars['myobj']->block_notification_edit['populateNotification']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pnkey'] => $this->_tpl_vars['pnvalue']):
?>
					   	<tr>
							<td><?php echo $this->_tpl_vars['pnvalue']['notification_text']; ?>
</td>
							<td><?php echo $this->_tpl_vars['pnvalue']['module_text']; ?>
</td>
							<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass($this->_tpl_vars['pnvalue']['default_status_id']); ?>
">
								<input type="radio" name="<?php echo $this->_tpl_vars['pnvalue']['default_status_id']; ?>
" id="<?php echo $this->_tpl_vars['pnvalue']['default_status_id']; ?>
Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="Yes" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio($this->_tpl_vars['pnvalue']['default_status_id'],'Yes'); ?>
 /> <label for="<?php echo $this->_tpl_vars['pnvalue']['default_status_id']; ?>
Yes"><?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
</label>
								<input type="radio" name="<?php echo $this->_tpl_vars['pnvalue']['default_status_id']; ?>
" id="<?php echo $this->_tpl_vars['pnvalue']['default_status_id']; ?>
No" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="No" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio($this->_tpl_vars['pnvalue']['default_status_id'],'No'); ?>
 /> <label for="<?php echo $this->_tpl_vars['pnvalue']['default_status_id']; ?>
No"><?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
</label>
			                </td>
			                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass($this->_tpl_vars['pnvalue']['changeable_by_user_id']); ?>
">
								<input type="radio" name="<?php echo $this->_tpl_vars['pnvalue']['changeable_by_user_id']; ?>
" id="<?php echo $this->_tpl_vars['pnvalue']['changeable_by_user_id']; ?>
Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="Yes" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio($this->_tpl_vars['pnvalue']['changeable_by_user_id'],'Yes'); ?>
 /> <label for="<?php echo $this->_tpl_vars['pnvalue']['changeable_by_user_id']; ?>
Yes"><?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
</label>
								<input type="radio" name="<?php echo $this->_tpl_vars['pnvalue']['changeable_by_user_id']; ?>
" id="<?php echo $this->_tpl_vars['pnvalue']['changeable_by_user_id']; ?>
No" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="No" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio($this->_tpl_vars['pnvalue']['changeable_by_user_id'],'No'); ?>
 /> <label for="<?php echo $this->_tpl_vars['pnvalue']['changeable_by_user_id']; ?>
No"><?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
</label>
			                </td>
					   	</tr>
					   	<?php endforeach; endif; unset($_from); ?>
					   	<tr>
							<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
" colspan="4">
								<input type="submit" class="clsSubmitButton" name="update_submit" id="update_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_update']; ?>
" />
							</td>
						</tr>
					</table>
				</form>
		   	</div>
		<?php endif; ?>
	</div>
</div>