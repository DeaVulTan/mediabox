<?php /* Smarty version 2.6.18, created on 2011-10-18 17:31:50
         compiled from populateTopContributors.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'populateTopContributors.tpl', 22, false),)), $this); ?>
<div class="clsTopContributorsNoPadding">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 <div class="clsOverflow"><h3 class="clsSideBarLeftTitle clsPaddingLeft5"><?php echo $this->_tpl_vars['LANG']['sidebar_top_contributos_label']; ?>
</h3></div>
<div class="clsSideBarContent clsTopContributorsSideBar">
    <?php if ($this->_tpl_vars['record_count']): ?>
	    <table class="clsTopContributorsMain">
        <?php $this->assign('break_count', 1); ?>
		<?php if ($this->_tpl_vars['CFG']['site']['script_name'] == 'index.php'): ?>
			<?php $this->assign('num_of_rec', $this->_tpl_vars['CFG']['admin']['photos']['sidebar_top_contributors_num_record']); ?>
		<?php else: ?>
			<?php $this->assign('num_of_rec', $this->_tpl_vars['CFG']['admin']['photos']['sidebar_memberlist_top_contributors_num_record']); ?>
		<?php endif; ?>
        <?php $_from = $this->_tpl_vars['contributor']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['member']):
?>
        <?php if ($this->_tpl_vars['break_count'] == 1): ?>
        	<tr>
        <?php endif; ?>
             <td  <?php if ($this->_tpl_vars['break_count'] == $this->_tpl_vars['num_of_rec']): ?> class="clsFinalData" <?php endif; ?>>
        <div class="clsTopContributors">
            <div class="clsTopContributorsThumb">
                    <a href="<?php echo $this->_tpl_vars['member']['memberProfileUrl']; ?>
" class="Cls30x30 ClsImageBorder1 clsImageHolder clsPointer">
                                <img src="<?php echo $this->_tpl_vars['member']['icon']['s_url']; ?>
"  title="<?php echo $this->_tpl_vars['member']['name']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['member']['name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(30,30,$this->_tpl_vars['member']['icon']['s_width'],$this->_tpl_vars['member']['icon']['s_height']); ?>
 />
                    </a>
            </div>
            <!--<div class="clsTopContributorsThumbDetails">
                <p class="clsTopContributorsThumbDetailsTitle"><a href="<?php echo $this->_tpl_vars['member']['memberProfileUrl']; ?>
" title="<?php echo $this->_tpl_vars['member']['name']; ?>
"><?php echo $this->_tpl_vars['member']['name']; ?>
</a></p>
                <p><?php echo $this->_tpl_vars['LANG']['sidebar_posted_photo_label']; ?>
<span><a href="<?php echo $this->_tpl_vars['member']['user_photolist_url']; ?>
"><?php echo $this->_tpl_vars['member']['total_stats']; ?>
</a></span></p>
            </div>-->
        </div>
        </td>
        <?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
        <?php if ($this->_tpl_vars['break_count'] > $this->_tpl_vars['num_of_rec']): ?>
          </tr>
           <?php $this->assign('break_count', 1); ?>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
        </table>
     <?php else: ?>
     	<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['sidebar_no_topcontributors_found_error_msg']; ?>
</div>
     <?php endif; ?>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>