<?php /* Smarty version 2.6.18, created on 2011-10-25 10:25:16
         compiled from profileSettings.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'profileSettings.tpl', 25, false),array('function', 'html_options', 'profileSettings.tpl', 26, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selEditAccountProfile">
	<div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['LANG']['account_profile_title']; ?>
</h2></div>
  	<div id="selLeftNavigation">
 		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

 		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_edit_account_profile')): ?>
			<div id="selPomptDialog" title="<?php echo $this->_tpl_vars['CFG']['site']['name']; ?>
" style="display:none;">
				<form action="#">
					<label for="newStatus"><?php echo $this->_tpl_vars['LANG']['account_profile_enter_new_status']; ?>
</label>
					<input type="text" name="newStatus" id="newStatus" class="text ui-widget-content ui-corner-all" maxlength="20"/>
				</form>
			</div>

			<form name="selFormEditAccountProfile" id="selFormEditAccountProfile" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
				<div class="clsDataTable">
			        <table summary="<?php echo $this->_tpl_vars['LANG']['account_profile_tbl_summary']; ?>
" class="clsCheckBoxList">
						<?php if ($this->_tpl_vars['show_languages']): ?>
						<tr>
			            	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('pref_lang'); ?>
">
			                	<label for="pref_lang"><?php echo $this->_tpl_vars['LANG']['account_profile_default_language']; ?>
</label>
			                </td>
			                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('current_password'); ?>
">
			                	<select name="pref_lang" id="pref_lang" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" >
					            	<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['myobj']->getLanguage(),'selected' => $this->_tpl_vars['myobj']->getFormField('pref_lang')), $this);?>

								</select>
			                </td>
			            </tr>
			            <?php endif; ?>
			            <?php if ($this->_tpl_vars['show_templates']): ?>
			            <tr>
							<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('template'); ?>
">
								<label for="template1"><?php echo $this->_tpl_vars['LANG']['account_profile_default_template']; ?>
</label>
							</td>
							<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('template'); ?>
">
								<select name="pref_template" id="pref_template" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
								  <?php $_from = $this->_tpl_vars['template_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['template'] => $this->_tpl_vars['css_arr']):
?>
									<optgroup label="<?php echo $this->_tpl_vars['template']; ?>
">
										<?php $_from = $this->_tpl_vars['css_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['css_key'] => $this->_tpl_vars['css']):
?>
											<?php $this->assign('smarty_current_template', ($this->_tpl_vars['template'])."__".($this->_tpl_vars['css'])); ?>
											 <option value="<?php echo $this->_tpl_vars['smarty_current_template']; ?>
" <?php if ($this->_tpl_vars['myobj']->getFormField('pref_template') == $this->_tpl_vars['smarty_current_template']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['css']; ?>
</option>
										<?php endforeach; endif; unset($_from); ?>
									</optgroup>
								  <?php endforeach; endif; unset($_from); ?>
								</select>
								<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('template'); ?>

							</td>
					   </tr>
					   <?php endif; ?>
						<tr>
							<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('privacy'); ?>
"><label for="privacyOnline"><?php echo $this->_tpl_vars['LANG']['account_profile_status']; ?>
</label></td>
							<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('privacy'); ?>
">
								<div class="formRadioButtons">
									<p><span class="clsCheckBox"><input type="radio" class="clsCheckRadio" name="privacy" id="privacyOnline" value="Online" onclick="showCustomMsgSelectBox(this.value)" <?php echo $this->_tpl_vars['myobj']->Online; ?>
 tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></span><label for="privacyOnline">&nbsp;&nbsp;<?php echo $this->_tpl_vars['LANG']['account_profile_status_online']; ?>
</label></p>
									<p><span class="clsCheckBox"><input type="radio" class="clsCheckRadio" name="privacy" id="privacyOffline"  value="Offline" onclick="showCustomMsgSelectBox(this.value)" <?php echo $this->_tpl_vars['myobj']->Offline; ?>
 tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></span><label for="privacyOffline">&nbsp;&nbsp;<?php echo $this->_tpl_vars['LANG']['account_profile_status_offline']; ?>
</label></p>
									<p><span class="clsCheckBox"><input type="radio" class="clsCheckRadio" name="privacy" id="privacyCustom" value="Custom" onclick="showCustomMsgSelectBox(this.value)" <?php echo $this->_tpl_vars['myobj']->Custom; ?>
 tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></span><label for="privacyCustom">&nbsp;&nbsp;<?php echo $this->_tpl_vars['LANG']['account_profile_status_custom']; ?>
</label></p>
										<p class="clsInputDetails" id="custom_msg_select" <?php if ($this->_tpl_vars['myobj']->getFormField('privacy') != 'Custom'): ?>style="display:none"<?php endif; ?>><select name="custom_status" id="custom_status" onchange="addNewStatusMessage(this)">
											<option value=""><?php echo $this->_tpl_vars['LANG']['account_profile_status_custom_select']; ?>
</option>
			                                <?php if ($this->_tpl_vars['myobj']->populateStatus != 0): ?>
			                                    <?php $_from = $this->_tpl_vars['myobj']->populateStatus; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['value']):
?>
			                                    <option value="<?php echo $this->_tpl_vars['value']['values']; ?>
" <?php echo $this->_tpl_vars['value']['selected']; ?>
><?php echo $this->_tpl_vars['value']['optionvalue']; ?>
</option>
			                                    <?php endforeach; endif; unset($_from); ?>
			                                <?php endif; ?>
											<optgroup label="<?php echo $this->_tpl_vars['LANG']['account_profile_status_new_optgroup']; ?>
">
												<option value="add"><?php echo $this->_tpl_vars['LANG']['account_profile_status_custom_add']; ?>
</option>
											</optgroup>
										</select></p>
										<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('privacy'); ?>

										<input type="hidden" name="status_msg_id_old" id="status_msg_id_old" value="<?php echo $this->_tpl_vars['myobj']->getFormField('status_msg_id_old'); ?>
" />
										<input type="hidden" name="new_status_hidden" id="new_status_hidden" />
								</div>
							</td>
					   	</tr>
			        	<tr>
							<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('show_profile'); ?>
"><label><?php echo $this->_tpl_vars['LANG']['account_profile_show']; ?>
</label></td>
							<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('show_profile'); ?>
">
								<div class="formRadioButtons">
			                    <?php $_from = $this->_tpl_vars['myobj']->populateShowProfile; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['value']):
?>
			                        <p><span class="clsCheckBox"><input type="radio" class="clsCheckRadio" name="<?php echo $this->_tpl_vars['value']['field_name']; ?>
" id="<?php echo $this->_tpl_vars['value']['field_name_id']; ?>
" <?php echo $this->_tpl_vars['value']['checked']; ?>
 value="<?php echo $this->_tpl_vars['value']['values']; ?>
"  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></span><label for ="<?php echo $this->_tpl_vars['value']['field_name_id']; ?>
">&nbsp;&nbsp;<?php echo $this->_tpl_vars['value']['desc']; ?>
</label></p>
			                    <?php endforeach; endif; unset($_from); ?>
			                    </div>
			                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('show_profile'); ?>

			                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('show_profile'); ?>

							</td>
					   	</tr>

						<?php if (chkAllowedModule ( array ( 'photo' ) )): ?>
					   		<tr>
								<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('icon_use_last_uploaded'); ?>
"><label for="icon_use_last_uploaded"><?php echo $this->_tpl_vars['LANG']['account_profile_icon']; ?>
</label></td>
								<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('icon_use_last_uploaded'); ?>
">
									<div class="formRadioButtons">
			                		<?php $_from = $this->_tpl_vars['myobj']->populateProfileIcon; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['value']):
?>
			                    		<p><span class="clsCheckBox"><input type="radio" class="clsCheckRadio" name="<?php echo $this->_tpl_vars['value']['field_name']; ?>
" id="<?php echo $this->_tpl_vars['value']['field_name_id']; ?>
" <?php echo $this->_tpl_vars['value']['checked']; ?>
 value="<?php echo $this->_tpl_vars['value']['values']; ?>
"  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></span><label for ="<?php echo $this->_tpl_vars['value']['field_name_id']; ?>
">&nbsp;&nbsp;<?php echo $this->_tpl_vars['value']['desc']; ?>
</label></p>
			                		<?php endforeach; endif; unset($_from); ?>
			                    	</div>
			                    	<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('icon_use_last_uploaded'); ?>

			                    	<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('icon_use_last_uploaded'); ?>

								</td>
					   		</tr>
						<?php endif; ?>
					   	<tr>
							<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('allow_comment'); ?>
"><label><?php echo $this->_tpl_vars['LANG']['account_profile_comments']; ?>
</label></td>
							<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('allow_comment'); ?>
">
								<div class="formRadioButtons">
			                    <?php $_from = $this->_tpl_vars['myobj']->populateAllowComment; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['value']):
?>
			                        <p><span class="clsCheckBox"><input type="radio" class="clsCheckRadio" name="<?php echo $this->_tpl_vars['value']['field_name']; ?>
" id="<?php echo $this->_tpl_vars['value']['field_name_id']; ?>
" <?php echo $this->_tpl_vars['value']['checked']; ?>
 value="<?php echo $this->_tpl_vars['value']['values']; ?>
"  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></span><label for ="<?php echo $this->_tpl_vars['value']['field_name_id']; ?>
">&nbsp;&nbsp;<?php echo $this->_tpl_vars['value']['desc']; ?>
</label></p>
			                    <?php endforeach; endif; unset($_from); ?>
			                    </div>
			                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('allow_comment'); ?>

			                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('allow_comment'); ?>

							</td>
					   	</tr>

						<?php if (chkAllowedModule ( array ( 'community' , 'bulletin' ) )): ?>
					   		<tr>
								<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('allow_bulletin'); ?>
"><label for="allow_bulletin"><?php echo $this->_tpl_vars['LANG']['account_profile_bulletins']; ?>
</label></td>
									<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('allow_bulletin'); ?>
">
										<div class="formRadioButtons">
					                    <?php $_from = $this->_tpl_vars['myobj']->populateAllowBulletin; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['value']):
?>
					                        <p><span class="clsCheckBox"><input type="radio" class="clsCheckRadio" name="<?php echo $this->_tpl_vars['value']['field_name']; ?>
" id="<?php echo $this->_tpl_vars['value']['field_name_id']; ?>
" <?php echo $this->_tpl_vars['value']['checked']; ?>
 value="<?php echo $this->_tpl_vars['value']['values']; ?>
"  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></span><label for ="<?php echo $this->_tpl_vars['value']['field_name_id']; ?>
">&nbsp;&nbsp;<?php echo $this->_tpl_vars['value']['desc']; ?>
</label></p>
					                    <?php endforeach; endif; unset($_from); ?>
					                    </div>
			                    		<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('allow_bulletin'); ?>

			                    		<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('allow_bulletin'); ?>

									</td>
					   		</tr>
						<?php endif; ?>
						<?php if (chkAllowedModule ( array ( 'content_filter' ) )): ?>
						   	<?php if (isAdultUser ( 'settings' )): ?>
							   	<tr>
									<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('content_filter'); ?>
"><label><?php echo $this->_tpl_vars['LANG']['account_profile_content_filter']; ?>
</label></td>
									<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('content_filter'); ?>
">
										<div class="formRadioButtons">
					                    <?php $_from = $this->_tpl_vars['myobj']->populateContentFilter; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['value']):
?>
					                        <p><span class="clsCheckBox"><input type="radio" class="clsCheckRadio" name="<?php echo $this->_tpl_vars['value']['field_name']; ?>
" id="<?php echo $this->_tpl_vars['value']['field_name_id']; ?>
" <?php echo $this->_tpl_vars['value']['checked']; ?>
 value="<?php echo $this->_tpl_vars['value']['values']; ?>
"  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></span><label for ="<?php echo $this->_tpl_vars['value']['field_name_id']; ?>
">&nbsp;&nbsp;<?php echo $this->_tpl_vars['value']['desc']; ?>
</label></p>
					                    <?php endforeach; endif; unset($_from); ?>
					                    </div>
					                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('content_filter'); ?>

					                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('content_filter'); ?>

									</td>
							   	</tr>
				    	   	<?php else: ?>
								<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->populateHidden_arr); ?>


						    <?php endif; ?>
						<?php endif; ?>
						<?php if ($this->_tpl_vars['myobj']->isFacebookUser()): ?>
						   	<tr>
								<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('facebook_image'); ?>
"><label for="facebook_image"><?php echo $this->_tpl_vars['LANG']['account_profile_facebook_image']; ?>
</label></td>
								<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('facebook_image'); ?>
">
									<div class="formRadioButtons">
				                    <?php $_from = $this->_tpl_vars['myobj']->updateFacebook; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['value']):
?>
				                        <p><span class="clsCheckBox"><input type="radio" class="clsCheckRadio" name="<?php echo $this->_tpl_vars['value']['field_name']; ?>
" id="<?php echo $this->_tpl_vars['value']['field_name_id']; ?>
" <?php echo $this->_tpl_vars['value']['checked']; ?>
 value="<?php echo $this->_tpl_vars['value']['values']; ?>
"  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></span><label for ="<?php echo $this->_tpl_vars['value']['field_name_id']; ?>
">&nbsp;&nbsp;<?php echo $this->_tpl_vars['value']['desc']; ?>
</label></p>
				                    <?php endforeach; endif; unset($_from); ?>
				                    </div>
				                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('facebook_image'); ?>

				                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('facebook_image'); ?>

								</td>
						   	</tr>
						<?php endif; ?>
					   	<tr>
						   	<td></td>
							<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
"><div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="account_submit" id="account_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['account_profile_submit']; ?>
" /></div></div></td>
			           	</tr>
					</table>
			    </div>
			</form>
		<?php endif; ?>	</div>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>