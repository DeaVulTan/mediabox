<?php /* Smarty version 2.6.18, created on 2012-01-23 23:05:23
         compiled from editMetaDetails.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'editMetaDetails.tpl', 19, false),)), $this); ?>
<div id="selHelpLangEdit">
	<div id="selManageLaguageFile">
    	<h2><?php echo $this->_tpl_vars['LANG']['langedit_lang_editing']; ?>
</h2>
    	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "information.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_edit_phrases')): ?>
    	<div id="selEditForm">
      		<form name="editFrm" id="editFrm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
">
        		<table class="clsFormSection clsNoBorder">
          			<tr>
            			<th class="clsFormLabelCellDefault"><?php echo $this->_tpl_vars['LANG']['langedit_variable_name']; ?>
</th>
            			<th class="clsFormFieldCellDefault"><?php echo $this->_tpl_vars['LANG']['langedit_new_value']; ?>
</th>
          			</tr>
          			<?php $_from = $this->_tpl_vars['myobj']->form_edit_phrases['LANG']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['value']):
?>
          			<tr>
            			<td class="clsWidthMedium <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('varable'); ?>
">
              				<label for="<?php echo $this->_tpl_vars['key']; ?>
"><?php echo $this->_tpl_vars['key']; ?>
</label>
            			</td>
            			<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('phrase'); ?>
">
              				<textarea name="<?php echo $this->_tpl_vars['key']; ?>
" id="<?php echo $this->_tpl_vars['key']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" rows="3" cols="50"><?php echo $this->_tpl_vars['myobj']->stripslashesNew($this->_tpl_vars['value']); ?>
</textarea>
            			</td>
          			</tr>
          			<?php endforeach; endif; unset($_from); ?>
          			<tr>
            			<td colspan="2" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
">
              				<input type="submit" class="clsSubmitButton" name="submit_phrases" id="selSubmitPhrases" value="<?php echo $this->_tpl_vars['LANG']['langedit_update']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
			  				<input type="submit" class="clsCancelButton" name="cancel_submit" id="cancel_submit" value="<?php echo $this->_tpl_vars['LANG']['langedit_cancel_submit']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
            			</td>
          			</tr>
        		</table>
      		</form>
    	</div>
		<?php endif; ?>
  	</div>
</div>