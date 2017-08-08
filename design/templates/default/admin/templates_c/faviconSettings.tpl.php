<?php /* Smarty version 2.6.18, created on 2011-10-19 10:47:58
         compiled from faviconSettings.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'faviconSettings.tpl', 20, false),)), $this); ?>
<div id="selGeneralConfiguration">
    
	<ul class="clsHeadingList">
    	<li><a href="<?php echo $this->_tpl_vars['myobj']->logoSettingUrl; ?>
" title="<?php echo $this->_tpl_vars['LANG']['faviconsetting_logo_link']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['faviconsetting_logo_link']; ?>
</span></a></li>
        <li class="clsActive"><a><span><?php echo $this->_tpl_vars['LANG']['faviconsetting_page_title']; ?>
</span></a></li>
    </ul>
    
	<div id="selLeftNavigation">
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
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
								<td class="clsFormLabelCellDefault clsWidth250">
									<label for="default_screen"><?php echo $this->_tpl_vars['LANG']['faviconsetting_select_template']; ?>
</label><?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
</td>
							  	<td>
							    	<?php $this->assign('smarty_default_template', ($this->_tpl_vars['CFG']['html']['template']['temp_default'])."__".($this->_tpl_vars['CFG']['html']['stylesheet']['screen']['temp_default'])); ?>
									<select name="default_screen" id="default_screen" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onChange="populateFaviconImage(this.value)">
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
				        			</select><br/>
				        			<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('default_screen'); ?>

                                </td>
						 	</tr>
						 	<tr>
								<td class="clsFormLabelCellDefault"><label for="site_favicon"><?php echo $this->_tpl_vars['LANG']['faviconsetting_upload_favicon']; ?>
</label><?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
</td>
								<td>
									<input type="file" class="clsFileBox" name="site_favicon" id="site_favicon" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/>
                                    <div class="clsTdDatas">
                                        <p><strong><?php echo $this->_tpl_vars['LANG']['common_allowed_file_formats']; ?>
:</strong>&nbsp;<?php echo $this->_tpl_vars['myobj']->changeArrayToCommaSeparator($this->_tpl_vars['CFG']['admin']['site']['favicon_image_format_arr']); ?>
</p>
                                        <p><strong><?php echo $this->_tpl_vars['LANG']['faviconsetting_favicon_max_width']; ?>
:&nbsp;</strong><?php echo $this->_tpl_vars['CFG']['admin']['site']['favicon_image_max_width']; ?>
px</p>
                                        <p><strong><?php echo $this->_tpl_vars['LANG']['faviconsetting_favicon_max_height']; ?>
:&nbsp;</strong><?php echo $this->_tpl_vars['CFG']['admin']['site']['favicon_image_max_height']; ?>
px</p>
                                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('site_favicon'); ?>

                                    </div>
                                </td>
							</tr>
							<tr>
                        		<td>&nbsp;</td>
								<td class="clsButtonAlignment clsFormFieldCellDefault">
									<input type="submit" class="clsSubmitButton" name="edit_submit" id="edit_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['faviconsetting_update']; ?>
" />
                            	</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td id="faviconImage" class="clsButtonAlignment clsFormFieldCellDefault"></td>
							</tr>
								<tr>
								<td>&nbsp;</td>
								<td id="faviconImage" class="clsButtonAlignment clsFormFieldCellDefault"></td>
							</tr>
						</table>
					</div>
				</form>
			</div>
		<?php endif; ?>
	</div>
</div>