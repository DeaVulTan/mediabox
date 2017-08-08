<?php /* Smarty version 2.6.18, created on 2011-10-17 15:08:16
         compiled from populateMusicEditRelationList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'populateMusicEditRelationList.tpl', 4, false),)), $this); ?>
<?php if ($this->_tpl_vars['myobj']->relation_list_count): ?>
    <?php $_from = $this->_tpl_vars['populateCheckBoxForRelationList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['friends']):
?>
    <input type="checkbox" class="clsCheckRadio" name="relation_id[]" id="relation_id_<?php echo $this->_tpl_vars['friends']['record']['relation_id']; ?>
" 
    value="<?php echo $this->_tpl_vars['friends']['record']['relation_id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" 
    <?php echo $this->_tpl_vars['myobj']->isCheckedCheckBoxArray('relation_id',$this->_tpl_vars['friends']['record']['relation_id']); ?>
 />
                <label for="relation_id_<?php echo $this->_tpl_vars['friends']['record']['relation_id']; ?>
">
                    <b><?php echo $this->_tpl_vars['friends']['record']['relation_name']; ?>
(<?php echo $this->_tpl_vars['friends']['record']['total_contacts']; ?>
)</b>
                </label><br />
    <?php endforeach; endif; unset($_from); ?>
<?php else: ?>
<p><?php echo $this->_tpl_vars['LANG']['no_relation_list']; ?>
</p>
<?php endif; ?>