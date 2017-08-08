<?php /* Smarty version 2.6.18, created on 2011-12-29 19:01:59
         compiled from profileTheme.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'profileTheme.tpl', 77, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selCustomizeProfile">
  	<div id="selLeftNavigation">
    <div class="clsPageHeading">
    <h2>
    	<?php echo $this->_tpl_vars['LANG']['profile_theme']; ?>
&nbsp;
        <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_basic_blocks_handling')): ?>
    		 - <?php echo $this->_tpl_vars['myobj']->block_title; ?>

        <?php endif; ?>
    </h2>
    </div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_basic_blocks_handling')): ?>
	<form name="selFormEditProfile" id="selFormEditProfile" method="post" action="<?php echo $this->_tpl_vars['myobj']->formAction; ?>
" autocomplete="off">
		<div class="clsDataTable">
        <table summary="<?php echo $this->_tpl_vars['LANG']['profile_theme_tbl_summary']; ?>
" class="clsProfileEditTbl">

			<tr>
				<th colspan="2"><?php echo $this->_tpl_vars['LANG']['entire_block_design']; ?>
</th>
			</tr>
			<tr>
				<td><?php echo $this->_tpl_vars['LANG']['background_color']; ?>
</td>
				<td>
					<input type="color" text="hidden" name="main_bg" id="main_bg" value="<?php echo $this->_tpl_vars['myobj']->form_basic_blocks_handling['main_bg']; ?>
" class="color" />
				</td>
			</tr>
			<tr>
				<td><label for="main_font"><?php echo $this->_tpl_vars['LANG']['font_style']; ?>
</label></td>
				<td><select name="main_font" id="main_font" >
                    <?php if ($this->_tpl_vars['myobj']->form_basic_blocks_handling['main_font_arr'] != 0): ?>
                        <?php $_from = $this->_tpl_vars['myobj']->form_basic_blocks_handling['main_font_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['value']):
?>
                        <option value="<?php echo $this->_tpl_vars['value']['values']; ?>
" <?php echo $this->_tpl_vars['value']['selected']; ?>
><?php echo $this->_tpl_vars['value']['optionvalue']; ?>
</option>
                        <?php endforeach; endif; unset($_from); ?>
                     <?php endif; ?>
                    </select>
                </td>
			</tr>

			<tr>
				<td><?php echo $this->_tpl_vars['LANG']['font_color']; ?>
</td>
				<td>
					<input type="color" text="hidden" name="main_color" id="main_color" value="<?php echo $this->_tpl_vars['myobj']->form_basic_blocks_handling['main_color']; ?>
" class="color" />
				</td>
			</tr>

			<tr>
				<th colspan="2"><?php echo $this->_tpl_vars['LANG']['header_design']; ?>
</th>
			</tr>
			<tr>
				<td class="clsProfileThemeTD"><?php echo $this->_tpl_vars['LANG']['background']; ?>
</td>
				<td>
					<input type="color" text="hidden" name="header_bg" id="header_bg" value="<?php echo $this->_tpl_vars['myobj']->form_basic_blocks_handling['header_bg']; ?>
" class="color" />
				</td>
			</tr>
			<tr>
				<td><label for="header_font"><?php echo $this->_tpl_vars['LANG']['font']; ?>
</label></td>
				<td><select name="header_font" id="header_font">
               		<?php if ($this->_tpl_vars['myobj']->form_basic_blocks_handling['header_font_arr'] != 0): ?>
                        <?php $_from = $this->_tpl_vars['myobj']->form_basic_blocks_handling['header_font_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['value']):
?>
                        <option value="<?php echo $this->_tpl_vars['value']['values']; ?>
" <?php echo $this->_tpl_vars['value']['selected']; ?>
><?php echo $this->_tpl_vars['value']['optionvalue']; ?>
</option>
                        <?php endforeach; endif; unset($_from); ?>
                     <?php endif; ?>
                	</select>
                </td>
			</tr>
			<tr>
				<td><?php echo $this->_tpl_vars['LANG']['font_color']; ?>
</td>
				<td>
					<input type="color" text="hidden" name="header_color" id="header_color" value="<?php echo $this->_tpl_vars['myobj']->form_basic_blocks_handling['header_color']; ?>
" class="color" />
				</td>
			</tr>
		   <tr><td></td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
">
                <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->form_basic_blocks_handling['hidden_arr']); ?>

				<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="theme_submit" id="theme_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['profile_theme_submit']; ?>
" /></div></div></td>
		   </tr>
		</table>
        </div>
	</form>
<?php endif; ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_add_layout')): ?>

	<form name="formAddLayout" id="formAddLayout" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
		<div class="clsDataTable">
        <table summary="<?php echo $this->_tpl_vars['LANG']['profile_theme_tbl_summary']; ?>
">
			<tr>
				<th><?php echo $this->_tpl_vars['LANG']['addlayout_toyour_profile']; ?>
</th>
			</tr>
			<tr>
				<td><?php echo $this->_tpl_vars['LANG']['layout_code']; ?>
</td>
			</tr>
			<tr>
				<td><textarea id="layout" name="layout" rows="10" cols="60" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('layout'); ?>
</textarea></td>
			</tr>
		   <tr><td></td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
">
				<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->form_add_layout['hidden_arr']); ?>

				<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="layout_submit" id="layout_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['profile_theme_layout_submit']; ?>
" /></div></div></td>
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