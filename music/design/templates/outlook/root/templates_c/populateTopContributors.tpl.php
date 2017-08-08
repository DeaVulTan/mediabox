<?php /* Smarty version 2.6.18, created on 2011-10-18 17:56:59
         compiled from populateTopContributors.tpl */ ?>
<div class="clsSideBarMargin">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clsAudioIndex clsTopContributorsSideBar">
	<div><p class="clsSideBarLeftTitle"><?php echo $this->_tpl_vars['LANG']['sidebar_top_contributos_label']; ?>
</p></div>
    <?php if ($this->_tpl_vars['record_count']): ?>
    <div class="clsOverflow">
    	<?php $_from = $this->_tpl_vars['contributor']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['member']):
?>    
    	<div class="clsTopContributors <?php echo $this->_tpl_vars['member']['noBoderStyle']; ?>
">
            <div class="clsTopContributorsThumb clsWidth55">
                <div class="clsThumbImageLink">
                    <a href="<?php echo $this->_tpl_vars['member']['memberProfileUrl']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls32x32">
                    	<img border="0" src="<?php echo $this->_tpl_vars['member']['profileIcon']['s_url']; ?>
" alt="<?php echo $this->_tpl_vars['member']['name']; ?>
" title="<?php echo $this->_tpl_vars['member']['name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(30,30,$this->_tpl_vars['member']['profileIcon']['s_width'],$this->_tpl_vars['member']['profileIcon']['s_height']); ?>
   />
                    </a>
                </div>
            </div>
        </div>     
		<?php endforeach; endif; unset($_from); ?>
     </div>     
     <?php else: ?>
     <div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['sidebar_no_topcontributors_found_error_msg']; ?>
</div>
     <?php endif; ?>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>