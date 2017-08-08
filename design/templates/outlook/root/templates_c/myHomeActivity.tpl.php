<?php /* Smarty version 2.6.18, created on 2011-10-17 14:52:37
         compiled from myHomeActivity.tpl */ ?>
<?php $this->assign('div_alternate_class', ''); ?>
    <?php if (isset ( $this->_tpl_vars['activitiesView'] )): ?>
    	<?php $this->assign('totRecords', $this->_tpl_vars['activitiesView']); ?>
    <?php else: ?>
    	<?php $this->assign('totRecords', $this->_tpl_vars['CFG']['admin']['myhome']['total_recent_activities']); ?>
    <?php endif; ?>
	<?php if (isset ( $this->_tpl_vars['module_arr'] ) && ( $this->_tpl_vars['module_arr'] )): ?>
		<?php $_from = $this->_tpl_vars['module_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['keyValue'] => $this->_tpl_vars['moduleValue']):
?>
			<?php if ($this->_tpl_vars['moduleValue']['module'] == 'general'): ?>
				<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('members/'); ?>

			<?php else: ?>
				<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('members/',$this->_tpl_vars['moduleValue']['module']); ?>

			<?php endif; ?>
		
			<?php if ($this->_tpl_vars['keyValue'] < $this->_tpl_vars['totRecords']): ?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['moduleValue']['file_name'], 'smarty_include_vars' => array('key' => $this->_tpl_vars['moduleValue']['parent_id'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endif; ?>	
			<?php if ($this->_tpl_vars['CFG']['site']['script_name'] == 'myHome.php' || $this->_tpl_vars['CFG']['site']['script_name'] == 'index.php'): ?>
				<?php if ($this->_tpl_vars['keyValue'] == $this->_tpl_vars['module_total_records']): ?>
					<!--Total Activitity >4  view all link visible-->
					<?php if ($this->_tpl_vars['moduleValue']['total_count'] >= $this->_tpl_vars['totRecords']): ?>
					<p class="clsViewAllLinks"><a href="<?php echo $this->_tpl_vars['activity_view_all_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['myhome_recent_activities_view_all']; ?>
</a></p>
					<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>
			 <?php if ($this->_tpl_vars['div_alternate_class'] == ''): ?>
				<?php $this->assign('div_alternate_class', ' class="clsAlternativeClr "'); ?>
			 <?php else: ?>
				<?php $this->assign('div_alternate_class', ''); ?>
			 <?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
	<?php else: ?>
	  <div class="clsOverflow">
		<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['myhome_recent_activities_no_records']; ?>
</div>
	  </div>	
	<?php endif; ?>