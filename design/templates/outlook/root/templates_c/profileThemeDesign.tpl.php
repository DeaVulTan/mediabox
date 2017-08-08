<?php /* Smarty version 2.6.18, created on 2011-12-29 18:59:50
         compiled from profileThemeDesign.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'profileThemeDesign.tpl', 18, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selCustomizeProfile">
	<div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['LANG']['profile_theme_title']; ?>
</h2></div>
	<div id="selLeftNavigation">
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_msg_form_success')): ?>
			<p class="clsMsgAdditionalText"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('myprofile'); ?>
"><?php echo $this->_tpl_vars['LANG']['profile_theme_link_view_profile']; ?>
</a></p>
		<?php endif; ?>
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_add_layout')): ?>	
	<form name="formAddLayout" id="formAddLayout" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
		<div class="clsDataTable">
			<table summary="<?php echo $this->_tpl_vars['LANG']['profile_theme_tbl_summary']; ?>
" class="clsProfileEditTbl">
			<tr>
				<td class="clsFormLabelCellDefault"><label for="layout"><?php echo $this->_tpl_vars['LANG']['profile_theme_layout_code']; ?>
</label></td>
				<td class="clsFormFieldCellDefault">
				   <textarea class="clsEmbedTextArea" id="layout" name="layout" rows="10" cols="60" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('layout'); ?>
</textarea>
				</td>
			</tr>
			<tr>
				<td><!-- --></td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
">
				<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->poulatehidden_arr); ?>

					<div class="clsSubmitLeft">
						<div class="clsSubmitRight">
							<input type="button" class="clsSubmitButton" name="layout_submit_preview" id="layout_submit_preview" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['profile_theme_layout_submit']; ?>
" onClick="return popupWindow('<?php echo $this->_tpl_vars['myobj']->MemberProfileUrl; ?>
')" />
						</div>
					</div>
					
					<div class="clsCancelMargin">
						<div class="clsSubmitLeft">
						  <div class="clsSubmitRight">
						    <input type="submit" class="clsSubmitButton" name="save_layout" id="save_layout" value="<?php echo $this->_tpl_vars['LANG']['customize_preview_submit_save_layout']; ?>
" />
						  </div>
					    </div>
					</div>
					
					<div class="clsCancelMargin clsSubmitLeft clsMarginBottom10">
						<div class="clsSubmitRight">
							<input class="clsSubmitButton" type="button" name="preview_css" id="preview_css" value="<?php echo $this->_tpl_vars['LANG']['profile_preview_css_style']; ?>
" onclick="window.open('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/css/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/profile.css','','menubar=yes,width:50,height:50,scrollbars=yes')"/>
						</div>
					</div>
					
					<div class="clsCancelMargin">
					  	<div class="clsSubmitLeft">
							<div class="clsSubmitRight">
								<input class="clsSubmitButton" type="submit" name="reset_layout" id="reset_layout" value="<?php echo $this->_tpl_vars['LANG']['profile_theme_reset']; ?>
" />
							</div>
						</div>
					</div>
				
					<div class="clsCancelMargin">
					 	<div class="clsCancelLeft">
							<div class="clsCancelRight">
								<a id="cancel_layout" onclick="Redirect2URL('<?php echo $this->_tpl_vars['myobj']->getUrl('myprofile'); ?>
')"><?php echo $this->_tpl_vars['LANG']['customize_preview_submit_return']; ?>
</a>
							</div>
						</div>
					</div>
				</td>
			</tr>
			</table>
		</div>
	</form>
	<?php endif; ?>	
  </div>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>