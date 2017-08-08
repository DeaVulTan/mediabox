<?php /* Smarty version 2.6.18, created on 2011-12-23 01:54:50
         compiled from profileInfo.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'profileInfo.tpl', 18, false),)), $this); ?>
<?php if ($this->_tpl_vars['myobj']->block_show_htmlfields): ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selProfileOtherInfo">
	<div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['myobj']->page_title; ?>
</h2></div>
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_show_htmlfields')): ?>
	<div class="clsDataTable clsProfileInfoTable">
	    <form name="selFormEditOtherInfoProfile" id="selFormEditOtherInfoProfile" method="post" action="" autocomplete="off">
	    <div id="selUploadBlock">
	    <table>
	     <?php $_from = $this->_tpl_vars['myobj']->block_show_htmlfields; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
	     <?php if ($this->_tpl_vars['value']['question_type'] == 'text'): ?>
	     <tr>
	     	<td class="<?php echo $this->_tpl_vars['value']['label_cell_class']; ?>
"><label for="<?php echo $this->_tpl_vars['value']['id']; ?>
"><?php echo $this->_tpl_vars['value']['question']; ?>
</label></td>
	        <td class="<?php echo $this->_tpl_vars['value']['field_cell_class']; ?>
">
	        <input type="text" class="clsTextBox" name="<?php echo $this->_tpl_vars['value']['id']; ?>
" id="<?php echo $this->_tpl_vars['value']['question']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['value']['answer_result']; ?>
" maxlength="<?php echo $this->_tpl_vars['value']['max_length']; ?>
" style="<?php echo $this->_tpl_vars['value']['width']; ?>
"/>
	        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip($this->_tpl_vars['value']['id']); ?>

	        <div class="clsHelpText" id="<?php echo $this->_tpl_vars['value']['id']; ?>
_Help" style="visibility:hidden"><?php echo $this->_tpl_vars['value']['instruction']; ?>
</div>
	        </td>
	     </tr>
	     <?php endif; ?>
	     <?php if ($this->_tpl_vars['value']['question_type'] == 'textarea'): ?>
	     <tr>
	        <td class="<?php echo $this->_tpl_vars['value']['label_cell_class']; ?>
"><label for="<?php echo $this->_tpl_vars['value']['id']; ?>
"><?php echo $this->_tpl_vars['value']['question']; ?>
</label></td>
	        <td class="<?php echo $this->_tpl_vars['value']['field_cell_class']; ?>
">
	        <textarea name="<?php echo $this->_tpl_vars['value']['id']; ?>
" id="<?php echo $this->_tpl_vars['value']['id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" rows="<?php echo $this->_tpl_vars['value']['rows']; ?>
" style="<?php echo $this->_tpl_vars['value']['width']; ?>
" class="selInputLimiter" maxlimit="<?php echo $this->_tpl_vars['CFG']['fieldsize']['profile']['info_description']; ?>
" maxlength="50"/><?php echo $this->_tpl_vars['value']['answer_result']; ?>
</textarea>
	        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip($this->_tpl_vars['value']['id']); ?>

	        <div class="clsHelpText" id="<?php echo $this->_tpl_vars['value']['id']; ?>
_Help" style="visibility:hidden"><?php echo $this->_tpl_vars['value']['instruction']; ?>
</div>
	        </td>
	     </tr>
	     <?php endif; ?>
	     <?php if ($this->_tpl_vars['value']['question_type'] == 'password'): ?>
	     <tr>
	        <td class="<?php echo $this->_tpl_vars['value']['label_cell_class']; ?>
"><label for="<?php echo $this->_tpl_vars['value']['id']; ?>
"><?php echo $this->_tpl_vars['value']['question']; ?>
</label></td>
	        <td class="<?php echo $this->_tpl_vars['value']['field_cell_class']; ?>
">
	        <input type="password" class="clsTextBox" name="<?php echo $this->_tpl_vars['value']['id']; ?>
" id="<?php echo $this->_tpl_vars['value']['question']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['value']['answer_result']; ?>
" maxlength="<?php echo $this->_tpl_vars['value']['max_length']; ?>
"/>
	        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip($this->_tpl_vars['value']['id']); ?>

	        <div class="clsHelpText" id="<?php echo $this->_tpl_vars['value']['id']; ?>
_Help" style="visibility:hidden"><?php echo $this->_tpl_vars['value']['instruction']; ?>
</div>
	        </td>
	     </tr>
	     <?php endif; ?>
	     <?php if ($this->_tpl_vars['value']['question_type'] == 'radio'): ?>
	     <tr>
	        <td class="<?php echo $this->_tpl_vars['value']['label_cell_class']; ?>
"><label for="opt_<?php echo $this->_tpl_vars['value']['id']; ?>
"><?php echo $this->_tpl_vars['value']['question']; ?>
</label></td>
	        <td class="<?php echo $this->_tpl_vars['value']['field_cell_class']; ?>
 clsCheckBoxList">
	        <?php $_from = $this->_tpl_vars['value']['option_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ssokey'] => $this->_tpl_vars['ssovalue']):
?>
	        	<p><span class="clsCheckBox"><input type="radio" class="clsCheckRadio" id="opt_<?php echo $this->_tpl_vars['value']['id']; ?>
_<?php echo $this->_tpl_vars['ssokey']; ?>
" name="<?php echo $this->_tpl_vars['value']['id']; ?>
"  <?php echo $this->_tpl_vars['value'][$this->_tpl_vars['ssovalue']]; ?>
 value="<?php echo $this->_tpl_vars['ssovalue']; ?>
"  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></span><label for="opt_<?php echo $this->_tpl_vars['value']['id']; ?>
_<?php echo $this->_tpl_vars['ssokey']; ?>
"><?php echo $this->_tpl_vars['ssovalue']; ?>
<?php echo $this->_tpl_vars['value']['display']; ?>
</label></p>
	        <?php endforeach; endif; unset($_from); ?>
	        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip($this->_tpl_vars['value']['id']); ?>

	        <div class="clsHelpText" id="opt_<?php echo $this->_tpl_vars['value']['id']; ?>
_Help" style="visibility:hidden"><?php echo $this->_tpl_vars['value']['instruction']; ?>
</div>
	        </td>
	     </tr>
	     <?php endif; ?>
	     <?php if ($this->_tpl_vars['value']['question_type'] == 'checkbox'): ?>
	     <tr>
	        <td class="<?php echo $this->_tpl_vars['value']['label_cell_class']; ?>
"><label><?php echo $this->_tpl_vars['value']['question']; ?>
</label></td>
	        <td class="<?php echo $this->_tpl_vars['value']['field_cell_class']; ?>
 clsCheckBoxList" align="left">
	        <?php $_from = $this->_tpl_vars['value']['option_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ssokey'] => $this->_tpl_vars['ssovalue']):
?>
	        	<p><span class="clsCheckBox"><input type="checkbox" class="clsCheckRadio" id="opt_<?php echo $this->_tpl_vars['value']['id']; ?>
_<?php echo $this->_tpl_vars['ssokey']; ?>
" name="<?php echo $this->_tpl_vars['value']['id']; ?>
[]"  <?php echo $this->_tpl_vars['value']['checked'][$this->_tpl_vars['ssokey']]; ?>
 value="<?php echo $this->_tpl_vars['ssovalue']; ?>
"  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></span><label for="opt_<?php echo $this->_tpl_vars['value']['id']; ?>
_<?php echo $this->_tpl_vars['ssokey']; ?>
"><?php echo $this->_tpl_vars['ssovalue']; ?>
<?php echo $this->_tpl_vars['value']['display']; ?>
</label></p>
	        <?php endforeach; endif; unset($_from); ?>
	        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip($this->_tpl_vars['value']['id']); ?>

	        <div class="clsHelpText" id="opt_<?php echo $this->_tpl_vars['value']['id']; ?>
_Help" style="visibility:hidden"><?php echo $this->_tpl_vars['value']['instruction']; ?>
</div>
	        </td>
	     </tr>
	     <?php endif; ?>
	     <?php if ($this->_tpl_vars['value']['question_type'] == 'select'): ?>
	     <tr>
	        <td class="<?php echo $this->_tpl_vars['value']['label_cell_class']; ?>
"><label for="<?php echo $this->_tpl_vars['value']['id']; ?>
"><?php echo $this->_tpl_vars['value']['question']; ?>
</label></td>
	        <td class="<?php echo $this->_tpl_vars['value']['field_cell_class']; ?>
">
	        <select name="<?php echo $this->_tpl_vars['value']['id']; ?>
" id="<?php echo $this->_tpl_vars['value']['id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
	           <option value="">Select</option>
	          <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['value']['option_arr'],$this->_tpl_vars['value']['answer_result']); ?>

	        </select>
	        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip($this->_tpl_vars['value']['id']); ?>

	        <div class="clsHelpText" id="<?php echo $this->_tpl_vars['value']['id']; ?>
_Help" style="visibility:hidden"><?php echo $this->_tpl_vars['value']['instruction']; ?>
</div>
	        </td>
	     </tr>
	     <?php endif; ?>
	     <?php endforeach; endif; unset($_from); ?>
	     <tr>
		 	<td>&nbsp;</td>
	        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('update_submit'); ?>
"><div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="update_submit" id="update_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_update']; ?>
" /></div></div></td>
	     </tr>
	    </table>
	    </div>
	    </form>
	</div>
	<?php endif; ?>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>