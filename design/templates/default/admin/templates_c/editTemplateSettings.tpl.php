<?php /* Smarty version 2.6.18, created on 2011-10-17 15:07:05
         compiled from editTemplateSettings.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'editTemplateSettings.tpl', 15, false),array('modifier', 'replace', 'editTemplateSettings.tpl', 54, false),)), $this); ?>
<div id="selGeneralConfiguration">
	<h2 class="clsEditApiConfigTitle"><?php echo $this->_tpl_vars['LANG']['page_title']; ?>
</h2>
	<div id="selLeftNavigation">
		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "information.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('show_config_variable')): ?>
			<div id="selUpload">
				<form name="form_config" id="form_config" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off" enctype="multipart/form-data">
					<div id="selUploadBlock">
						<table class="clsCommonTable clsFormTbl" summary="" id="selUploadTbl" >
							<tr>
								<td class="clsFormLabelCellDefault">
									<label for="logo_name"><?php echo $this->_tpl_vars['LANG']['template_change']; ?>
</label> </td>
								<td>
									<input type="radio" class="clsCheckRadio" name="is_template_change" id="is_template_change" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="1" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('is_template_change','1'); ?>
 />&nbsp;<label for="animated_logo1"><?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
</label>
          							<input type="radio" class="clsCheckRadio" name="is_template_change" id="is_template_change" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="0" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('is_template_change','0'); ?>
 />&nbsp;<label for="animated_logo2"><?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
</label>
								</td>
							</tr>
						  	<tr>
								<td class="clsFormLabelCellDefault">
									<label for="default_screen"><?php echo $this->_tpl_vars['LANG']['template_default']; ?>
</label> </td>
							  	<td>
							    	<?php $this->assign('smarty_default_template', ($this->_tpl_vars['CFG']['html']['template']['temp_default'])."__".($this->_tpl_vars['CFG']['html']['stylesheet']['screen']['temp_default'])); ?>
									<select name="default_screen" id="default_screen" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
										<?php $_from = $this->_tpl_vars['template_arr12']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['template'] => $this->_tpl_vars['css_arr']):
?>
				          					<optgroup label="<?php echo $this->_tpl_vars['template']; ?>
">
												<?php $_from = $this->_tpl_vars['css_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['css_key'] => $this->_tpl_vars['css']):
?>
													<?php $this->assign('smarty_current_template', ($this->_tpl_vars['template'])."__".($this->_tpl_vars['css'])); ?>
				          							<option value="<?php echo $this->_tpl_vars['smarty_current_template']; ?>
" <?php if ($this->_tpl_vars['smarty_current_template'] == $this->_tpl_vars['smarty_default_template']): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['css']; ?>
</option>
												<?php endforeach; endif; unset($_from); ?>
											</optgroup>
										<?php endforeach; endif; unset($_from); ?>
				        			</select>
                                </td>
						 	</tr>
						 	<tr>
								<td class="clsFormLabelCellDefault">
									<label for="logo_url"><?php echo $this->_tpl_vars['LANG']['template_allowed']; ?>
</label> </td>
								<td>
     								<table class="clsFormTable clsTemplateSettingTa">
     									<tr>
	                                    	<th><?php echo $this->_tpl_vars['LANG']['template_templates']; ?>
</th>
	                                        <th><?php echo $this->_tpl_vars['LANG']['template_css']; ?>
</th>
                                        </tr>
                                        <?php $_from = $this->_tpl_vars['total_details']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['keyvalue'] => $this->_tpl_vars['tempvalue']):
?>
                                    		<tr>
                                            	<td>
                                                	<input type="checkbox" name="temp_arr[]" id="temp_arr[]" value="<?php echo $this->_tpl_vars['tempvalue']; ?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedCheckBoxArray('temp_arr',$this->_tpl_vars['tempvalue']); ?>
 /><?php echo $this->_tpl_vars['tempvalue']; ?>

                                                </td>
                                                <td>
                                                	<?php $this->assign('css_arr', $this->_tpl_vars['myobj']->populateCssDetails($this->_tpl_vars['tempvalue'])); ?>
                                                  	<?php $_from = $this->_tpl_vars['css_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cssvalue'] => $this->_tpl_vars['cvalue']):
?>
                                                       	<?php $this->assign('smarty_current_screen', ($this->_tpl_vars['tempvalue'])."__".($this->_tpl_vars['cvalue'])); ?>
														<input type="checkbox" name="css_arr[]" id="css_arr[]" value="<?php echo $this->_tpl_vars['smarty_current_screen']; ?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedCheckBoxArray('css_arr',$this->_tpl_vars['smarty_current_screen']); ?>
 /><?php echo ((is_array($_tmp=$this->_tpl_vars['cvalue'])) ? $this->_run_mod_handler('replace', true, $_tmp, '.css', '') : smarty_modifier_replace($_tmp, '.css', '')); ?>

                                                       	<br/>
                                                  	<?php endforeach; endif; unset($_from); ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; endif; unset($_from); ?>
                                   	</table>
                                </td>
							</tr>
							<tr>
                        		<td></td>
								<td class="clsButtonAlignment clsFormFieldCellDefault">
									<input type="submit" class="clsSubmitButton" name="edit_submit" id="edit_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_update']; ?>
" />
									<input type="reset" class="clsCancelButton" name="reset" id="reset" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['reset']; ?>
" />
                            	</td>
							</tr>
						</table>
					</div>
				</form>
			</div>
		<?php endif; ?>
	</div>
</div>