<?php /* Smarty version 2.6.18, created on 2011-10-17 15:03:23
         compiled from serverSettings.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'serverSettings.tpl', 16, false),array('function', 'html_options', 'serverSettings.tpl', 29, false),)), $this); ?>
<div id="selServerSettings">
	<h2><span><?php echo $this->_tpl_vars['LANG']['server_title']; ?>
</span></h2>
    <div class="clsServerSettingMain">
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "information.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_addDetails') || $this->_tpl_vars['myobj']->isShowPageBlock('form_editDetails')): ?>

    <form name="form_addServer" id="selFormAddServer" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" autocomplete="off">
		<table summary="<?php echo $this->_tpl_vars['LANG']['server_add_summary']; ?>
" class="clsFormTableSection">
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('server_url'); ?>
">
					<label for="server_url"><?php echo $this->_tpl_vars['LANG']['server_url']; ?>
</label>
					<?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>

				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('server_url'); ?>
">
					<input type="text" class="clsTextBox" name="server_url" id="server_url" maxlength="200" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('server_url'); ?>
" />&nbsp;(http://example.test.in/)
					<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('server_url'); ?>

				</td>
		   	</tr>
		   	<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('server_for'); ?>
">
                
                					<label for="server_for"><?php echo $this->_tpl_vars['LANG']['server_for']; ?>
</label>
					<?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>

				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('server_for'); ?>
">
					<select name="server_for" id="server_for" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onChange="changeCategory(this.value)">
						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['myobj']->modules_arr,'selected' => $this->_tpl_vars['myobj']->getFormField('server_for')), $this);?>

					</select>
					<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('server_for'); ?>

				</td>
		   	</tr>
		   	<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('server_status'); ?>
">
                                <label for="server_status"><?php echo $this->_tpl_vars['LANG']['server_status']; ?>
</label></td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('server_status'); ?>
">
					<select name="server_status" id="server_status" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
						<option <?php if ($this->_tpl_vars['myobj']->getFormField('server_status') == 'No'): ?>selected<?php endif; ?> value="No">No</option>
						<option <?php if ($this->_tpl_vars['myobj']->getFormField('server_status') == 'Yes'): ?>selected<?php endif; ?> value="Yes">Yes</option>
					</select>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('server_status'); ?>

				</td>
		   	</tr>
		   	<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('ftp_server'); ?>
">
					<label for="ftp_server"><?php echo $this->_tpl_vars['LANG']['server_ftp_server']; ?>
</label>
					<?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>

				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('ftp_server'); ?>
">
					<input type="text" class="clsTextBox" name="ftp_server" id="ftp_server" maxlength="200" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('ftp_server'); ?>
" />&nbsp;(example.test.in)
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('ftp_server'); ?>

				</td>
		   	</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('ftp_folder'); ?>
">
                					<label for="ftp_folder"><?php echo $this->_tpl_vars['LANG']['server_ftp_folder']; ?>
</label>
				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('ftp_folder'); ?>
">
					<input type="text" class="clsTextBox" name="ftp_folder" id="ftp_folder" maxlength="200" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('ftp_folder'); ?>
" />&nbsp;(/var/www/html/rayzz/media_server/)
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('ftp_folder'); ?>

				</td>
		   	</tr>
		   	<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('ftp_usrename'); ?>
">
					<label for="ftp_usrename"><?php echo $this->_tpl_vars['LANG']['server_ftp_username']; ?>
</label>
					<?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>

				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('ftp_usrename'); ?>
">
					<input type="text" class="clsTextBox" name="ftp_usrename" id="ftp_usrename" maxlength="200" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('ftp_usrename'); ?>
" />
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('ftp_usrename'); ?>

				</td>
		   	</tr>
		   	<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('ftp_password'); ?>
">
                					<label for="ftp_password"><?php echo $this->_tpl_vars['LANG']['server_ftp_password']; ?>
</label>
				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('ftp_password'); ?>
">
					<input type="text" class="clsTextBox" name="ftp_password" id="ftp_password" maxlength="200" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('ftp_password'); ?>
" />
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('ftp_password'); ?>

				</td>
		   	</tr>
			<tr>
            	<td></td>
            	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
">
				<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_editDetails')): ?>
					<input type="hidden" name="sid" id="sid" value="<?php echo $this->_tpl_vars['myobj']->getFormField('sid'); ?>
" />
					<input type="submit" class="clsSubmitButton" name="edit_submit" id="edit_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['server_submit_update']; ?>
" />
					<input type="submit" class="clsCancelButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['server_submit_cancel']; ?>
" />

				<?php else: ?>
					<input type="submit" class="clsSubmitButton" name="add_submit" id="add_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['server_submit_add']; ?>
" />
				<?php endif; ?>
				</td>
			</tr>
		</table>
	</form>
<?php endif; ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_details')): ?>
	<div id="selMsgConfirm" class="selMsgConfirm" style="display:none;">
		<form name="form_editprofile" id="selFormEditProfile" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" autocomplete="off">
			<input type="hidden" name="sid" id="sid" />
			<input type="hidden" name="action" id="action" />
			<p id="selConfirmMsg"></p>
			<table summary="<?php echo $this->_tpl_vars['LANG']['server_del_conf_summary']; ?>
">
			   	<tr>
					<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
">
						<input type="submit" class="clsSubmitButton" name="act_submit" id="act_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['server_submit_del']; ?>
" />
						<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['server_submit_cancel']; ?>
" onClick="return hideAllBlocks();" />
					</td>
			   	</tr>
			</table>
		</form>
	</div>
	<form name="form_listServers" id="selFormListServers" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" autocomplete="off">
		<table summary="<?php echo $this->_tpl_vars['LANG']['server_list_summary']; ?>
">
			<tr>
				<th><?php echo $this->_tpl_vars['LANG']['server_sno']; ?>
</th>
				<th><?php echo $this->_tpl_vars['LANG']['server_url']; ?>
</th>
				<th><?php echo $this->_tpl_vars['LANG']['server_for']; ?>
</th>
				<th><?php echo $this->_tpl_vars['LANG']['server_status']; ?>
</th>
				<th><?php echo $this->_tpl_vars['LANG']['server_ftp_server']; ?>
</th>
				<th><?php echo $this->_tpl_vars['LANG']['server_ftp_folder']; ?>
</th>
				<th><?php echo $this->_tpl_vars['LANG']['server_ftp_username']; ?>
</th>
				<th><?php echo $this->_tpl_vars['LANG']['server_ftp_password']; ?>
</th>
				<th><?php echo $this->_tpl_vars['LANG']['server_action']; ?>
</th>
			</tr>
			<?php $_from = $this->_tpl_vars['myobj']->form_details['listServerDetails']['record']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['spikey'] => $this->_tpl_vars['spivalue']):
?>
				<tr>
					<td><?php echo $this->_tpl_vars['spikey']; ?>
</td>
					<td><?php echo $this->_tpl_vars['spivalue']['row']['server_url']; ?>
</td>
					<td><?php echo $this->_tpl_vars['spivalue']['row']['server_for']; ?>
</td>
					<td><?php echo $this->_tpl_vars['spivalue']['row']['server_status']; ?>
</td>
					<td><?php echo $this->_tpl_vars['spivalue']['row']['ftp_server']; ?>
</td>
					<td><?php echo $this->_tpl_vars['spivalue']['row']['ftp_folder']; ?>
</td>
					<td><?php echo $this->_tpl_vars['spivalue']['row']['ftp_usrename']; ?>
</td>
					<td><?php echo $this->_tpl_vars['spivalue']['row']['ftp_password']; ?>
</td>
					<td id="selEditDelServer">
						<span class="clsEditServer"><a href="<?php echo $this->_tpl_vars['spivalue']['edit']; ?>
"><?php echo $this->_tpl_vars['LANG']['server_link_edit']; ?>
</a></span>
						<span class="clsDeleteServer"><a href="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" onClick="<?php echo $this->_tpl_vars['spivalue']['onclick']; ?>
"><?php echo $this->_tpl_vars['LANG']['server_link_delete']; ?>
</a></span>
					</td>
				</tr>
			<?php endforeach; else: ?>
			<tr>
				<td colspan="10">
					<div id="selMsgAlert">
						<p><?php echo $this->_tpl_vars['LANG']['no_servers_found']; ?>
</p>
					</div>
				</td>
			</tr>
			<?php endif; unset($_from); ?>
		</table>
	</form>
<?php endif; ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_already_exist_new')): ?>
	<table cellspacing="0" summary="<?php echo $this->_tpl_vars['LANG']['server_del_summary']; ?>
">
		<tr><th><?php echo $this->_tpl_vars['LANG']['server_url']; ?>
</th><td><?php echo $this->_tpl_vars['myobj']->getFormField('server_url'); ?>
</td></tr>
		<tr><th><?php echo $this->_tpl_vars['LANG']['server_for']; ?>
</th><td><?php echo $this->_tpl_vars['myobj']->getFormField('server_for'); ?>
</td></tr>
		<tr><th><?php echo $this->_tpl_vars['LANG']['server_status']; ?>
</th><td><?php echo $this->_tpl_vars['myobj']->getFormField('server_status'); ?>
</td></tr>
		<tr><th><?php echo $this->_tpl_vars['LANG']['server_ftp_server']; ?>
</th><td><?php echo $this->_tpl_vars['myobj']->getFormField('ftp_server'); ?>
</td></tr>
		<tr><th><?php echo $this->_tpl_vars['LANG']['server_ftp_folder']; ?>
</th><td><?php echo $this->_tpl_vars['myobj']->getFormField('ftp_folder'); ?>
</td></tr>
		<tr><th><?php echo $this->_tpl_vars['LANG']['server_ftp_username']; ?>
</th><td><?php echo $this->_tpl_vars['myobj']->getFormField('ftp_usrename'); ?>
</td></tr>
		<tr><th><?php echo $this->_tpl_vars['LANG']['server_ftp_password']; ?>
</th><td><?php echo $this->_tpl_vars['myobj']->getFormField('ftp_password'); ?>
</td></tr>
	</table>
<?php endif; ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_already_exist_add')): ?>
	<div><?php echo $this->_tpl_vars['LANG']['server_msg_already_exist_select']; ?>
</div>
	<form name="form_editprofile" id="selFormEditProfile" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" autocomplete="off">
		<input type="hidden" name="sid" id="sid" value="<?php echo $this->_tpl_vars['myobj']->getFormField('sid'); ?>
" />
		<input type="hidden" name="server_url" id="sid" value="<?php echo $this->_tpl_vars['myobj']->getFormField('server_url'); ?>
" />
		<input type="hidden" name="server_for" id="sid" value="<?php echo $this->_tpl_vars['myobj']->getFormField('server_for'); ?>
" />
		<input type="hidden" name="server_status" id="sid" value="<?php echo $this->_tpl_vars['myobj']->getFormField('server_status'); ?>
" />
		<input type="hidden" name="ftp_server" id="sid" value="<?php echo $this->_tpl_vars['myobj']->getFormField('ftp_server'); ?>
" />
		<input type="hidden" name="ftp_folder" id="sid" value="<?php echo $this->_tpl_vars['myobj']->getFormField('ftp_folder'); ?>
" />
		<input type="hidden" name="ftp_usrename" id="sid" value="<?php echo $this->_tpl_vars['myobj']->getFormField('ftp_usrename'); ?>
" />
		<input type="hidden" name="ftp_password" id="sid" value="<?php echo $this->_tpl_vars['myobj']->getFormField('ftp_password'); ?>
" />

		<table summary="<?php echo $this->_tpl_vars['LANG']['server_del_conf_summary']; ?>
">
		   	<tr>
				<td class="<<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
">
					<input type="submit" class="clsSubmitButton" name="add_yes_submit" id="add_yes_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['server_add_and_set_status_yes']; ?>
" />
				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
">
					<input type="submit" class="clsSubmitButton" name="add_no_submit" id="add_no_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['server_add_and_set_status_no']; ?>
" />
				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
">
					<input type="submit" class="clsSubmitButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['server_cancel_dont_add']; ?>
" />
				</td>
		   	</tr>
		</table>
	</form>
<?php endif; ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_already_exist_edit')): ?>
	<div><?php echo $this->_tpl_vars['LANG']['server_msg_already_exist_reference']; ?>
</div>
	<form name="form_editprofile" id="selFormEditProfile" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" autocomplete="off">
		<input type="hidden" name="sid" id="sid" value="<?php echo $this->_tpl_vars['myobj']->getFormField('sid'); ?>
" />
		<input type="hidden" name="server_url" id="sid" value="<?php echo $this->_tpl_vars['myobj']->getFormField('server_url'); ?>
" />
		<input type="hidden" name="server_for" id="sid" value="<?php echo $this->_tpl_vars['myobj']->getFormField('server_for'); ?>
" />
		<input type="hidden" name="server_status" id="sid" value="<?php echo $this->_tpl_vars['myobj']->getFormField('server_status'); ?>
" />
		<input type="hidden" name="ftp_server" id="sid" value="<?php echo $this->_tpl_vars['myobj']->getFormField('ftp_server'); ?>
" />
		<input type="hidden" name="ftp_folder" id="sid" value="<?php echo $this->_tpl_vars['myobj']->getFormField('ftp_folder'); ?>
" />
		<input type="hidden" name="ftp_usrename" id="sid" value="<?php echo $this->_tpl_vars['myobj']->getFormField('ftp_usrename'); ?>
" />
		<input type="hidden" name="ftp_password" id="sid" value="<?php echo $this->_tpl_vars['myobj']->getFormField('ftp_password'); ?>
" />

		<table summary="<?php echo $this->_tpl_vars['LANG']['server_del_conf_summary']; ?>
">
		   	<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
">
					<input type="submit" class="clsSubmitButton" name="edit_yes_submit" id="edit_yes_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['server_update_and_set_status_yes']; ?>
" />
				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
">
					<input type="submit" class="clsSubmitButton" name="edit_no_submit" id="edit_no_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['server_update_and_set_status_no']; ?>
" />
				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
">
					<input type="submit" class="clsSubmitButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['server_cancel_dont_update']; ?>
" />
				</td>
		   	</tr>
		</table>
	</form>
<?php endif; ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_already_exist_old')): ?>
	<hr />
	<?php echo $this->_tpl_vars['LANG']['for_your_reference']; ?>

	<table cellspacing="0" summary="<?php echo $this->_tpl_vars['LANG']['server_del_summary']; ?>
">
		<tr><th><?php echo $this->_tpl_vars['LANG']['server_sid']; ?>
</th><td><?php echo $this->_tpl_vars['myobj']->form_already_exist_old['curr_active']['server_id']; ?>
</td></tr>
		<tr><th><?php echo $this->_tpl_vars['LANG']['server_url']; ?>
</th><td><?php echo $this->_tpl_vars['myobj']->form_already_exist_old['curr_active']['server_url']; ?>
</td></tr>
		<tr><th><?php echo $this->_tpl_vars['LANG']['server_for']; ?>
</th><td><?php echo $this->_tpl_vars['myobj']->form_already_exist_old['curr_active']['server_for']; ?>
</td></tr>
		<tr><th><?php echo $this->_tpl_vars['LANG']['server_status']; ?>
</th><td><?php echo $this->_tpl_vars['myobj']->form_already_exist_old['curr_active']['server_status']; ?>
</td></tr>
		<tr><th><?php echo $this->_tpl_vars['LANG']['server_ftp_server']; ?>
</th><td><?php echo $this->_tpl_vars['myobj']->form_already_exist_old['curr_active']['ftp_server']; ?>
</td></tr>
		<tr><th><?php echo $this->_tpl_vars['LANG']['server_ftp_folder']; ?>
</th><td><?php echo $this->_tpl_vars['myobj']->form_already_exist_old['curr_active']['ftp_folder']; ?>
</td></tr>
		<tr><th><?php echo $this->_tpl_vars['LANG']['server_ftp_username']; ?>
</th><td><?php echo $this->_tpl_vars['myobj']->form_already_exist_old['curr_active']['ftp_usrename']; ?>
</td></tr>
		<tr><th><?php echo $this->_tpl_vars['LANG']['server_ftp_password']; ?>
</th><td><?php echo $this->_tpl_vars['myobj']->form_already_exist_old['curr_active']['ftp_password']; ?>
</td></tr>
	</table>
<?php endif; ?>
</div>
</div>