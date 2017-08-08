<?php /* Smarty version 2.6.18, created on 2011-10-18 21:22:58
         compiled from topContributors.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'topContributors.tpl', 22, false),)), $this); ?>
<?php if ($this->_tpl_vars['index_block_settings_arr']['RandomVideo'] == 'mainblock'): ?>
		<?php $this->assign('total_top_contributors', 10); ?>
<?php else: ?>
		<?php $this->assign('total_top_contributors', 4); ?>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<p class="clsSideBarLeftTitle clsTitleTopContributor"><?php echo $this->_tpl_vars['LANG']['index_top_contributors']; ?>
</p>
<div class="clsSideBarLinks" >
	<div class="clsSideBar clsTopContributorsSideBar">
		<div class="clsSideBarRight">
	<div class="clsSideBarContent">
      <?php $this->assign('inc', 0); ?>
       <?php $_from = $this->_tpl_vars['contributor']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['member']):
?>
    	  <div class="<?php if ($this->_tpl_vars['inc'] != 0): ?>clsTopContributors<?php else: ?>clsTopContributorsNoBg<?php endif; ?>">
        	<!--<div class="clsTopContributorsThumb"> -->
                <div  class="clsThumbImageLink clsPointer">
                    <a href="<?php echo $this->_tpl_vars['member']['memberProfileUrl']; ?>
" class="Cls30x30 ClsImageBorder1 ClsImageContainer">
                         <img src="<?php echo $this->_tpl_vars['member']['icon']['s_url']; ?>
" border="0"  title="<?php echo ((is_array($_tmp=$this->_tpl_vars['member']['name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['member']['name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(30,30,$this->_tpl_vars['member']['icon']['s_width'],$this->_tpl_vars['member']['icon']['s_height']); ?>
 />
                    </a>
            </div>
        </div>
         <?php $this->assign('inc', $this->_tpl_vars['inc']+1); ?>
          <?php endforeach; endif; unset($_from); ?>
    </div>
</div>
	</div>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
