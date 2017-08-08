<?php /* Smarty version 2.6.18, created on 2012-02-01 23:56:13
         compiled from populateTopContributors.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'populateTopContributors.tpl', 10, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clsSideBar">
<p class="clsSideBarLeftTitle"><?php echo $this->_tpl_vars['LANG']['sidebar_top_writters_label']; ?>
</p></div>
<div class="clsOverflow clsTopWriters">
<?php if ($this->_tpl_vars['record_count']): ?>
    <?php $_from = $this->_tpl_vars['contributor']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['member']):
?>
			<div class="clsArticleThumb">
		    	<a href="<?php echo $this->_tpl_vars['member']['memberProfileUrl']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls30x30 clsPointer">
		             <img src="<?php echo $this->_tpl_vars['member']['icon']['s_url']; ?>
"  title="<?php echo $this->_tpl_vars['member']['name']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['member']['name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 3) : smarty_modifier_truncate($_tmp, 3)); ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(30,30,$this->_tpl_vars['member']['icon']['s_width'],$this->_tpl_vars['member']['icon']['s_height']); ?>
 />
		        </a>
		    </div>
            	<?php endforeach; endif; unset($_from); ?>
<?php else: ?>
	<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['sidebar_no_topwritters_found_error_msg']; ?>
</div>
<?php endif; ?>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>