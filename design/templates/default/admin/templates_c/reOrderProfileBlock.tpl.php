<?php /* Smarty version 2.6.18, created on 2012-02-02 20:51:55
         compiled from reOrderProfileBlock.tpl */ ?>
<div id="selProfileBlock">
<h2 class="clsPopUpHeading"><?php echo $this->_tpl_vars['LANG']['reorderprofileblock_title']; ?>
</h2>
 <p class="clsPageLink"><a class="clsAdd" href="manageProfileBlock.php"><?php echo $this->_tpl_vars['LANG']['reorderprofileblock_add_block']; ?>
</a>
 <div id="selMsgSuccess">
        	<p><?php echo $this->_tpl_vars['LANG']['reorderprofileblock_note']; ?>
: <?php echo $this->_tpl_vars['LANG']['reorderprofileblock_note_message']; ?>
</p>
 </div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clsOverflow"><form name="reorder_form" id="reorder_form" method="post" action="#">
<div class="clsOverflow"><div class="workarea">
  <h3><?php echo $this->_tpl_vars['LANG']['reorderprofileblock_left_side_block']; ?>
</h3>
  <ul id="ul1" class="draglist">
   <?php $_from = $this->_tpl_vars['myobj']->show_profile_block['profile_block']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['scKey'] => $this->_tpl_vars['Lvalue']):
?>
     <?php if ($this->_tpl_vars['Lvalue']['position'] == 'left'): ?>
    <li class="list1" id="<?php echo $this->_tpl_vars['Lvalue']['block_name']; ?>
"><?php echo $this->_tpl_vars['Lvalue']['block_category_name']; ?>
</li>
      <?php endif; ?>
   <?php endforeach; endif; unset($_from); ?>
  </ul>
</div>

<div class="workarea">
  <h3><?php echo $this->_tpl_vars['LANG']['reorderprofileblock_right_side_block']; ?>
</h3>
  <ul id="ul2" class="draglist">
   <?php $_from = $this->_tpl_vars['myobj']->show_profile_block['profile_block']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['scKey'] => $this->_tpl_vars['Rvalue']):
?>
     <?php if ($this->_tpl_vars['Rvalue']['position'] == 'right'): ?>
    <li class="list2" id="<?php echo $this->_tpl_vars['Rvalue']['block_name']; ?>
"><?php echo $this->_tpl_vars['Rvalue']['block_category_name']; ?>
</li>
     <?php endif; ?>
   <?php endforeach; endif; unset($_from); ?>
  </ul>
</div></div>

<div id="user_actions">
<input id="left"  type="hidden" name="left"/>
<input id="right"  type="hidden" name="right"/><div class="clsPopUpUpdate">
<input class="clsSubmitButton" id="showButton" value="<?php echo $this->_tpl_vars['LANG']['common_update']; ?>
" name="update_order" type="submit"/></div>
</div>
</form></div>

</div>