<?php /* Smarty version 2.6.18, created on 2011-10-17 15:12:54
         compiled from videoChannelNavigation.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'videoChannelNavigation.tpl', 9, false),)), $this); ?>
<div class="clsSideBarMargin">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<p class="clsCategoryLeftTitle clsTitleTopContributor"><?php echo $this->_tpl_vars['LANG']['header_nav_videochannels_title']; ?>
</p>
	<div class="clsVideoCategoriesSidebar clsOverflow">
		<ul>
			 <?php if ($this->_tpl_vars['videoChannel']): ?>
			  <?php $_from = $this->_tpl_vars['videoChannel']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['channel']):
?>
			  	<li><a href="<?php echo $this->_tpl_vars['channel']['videoListUrl']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['channel']['video_category_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 30) : smarty_modifier_truncate($_tmp, 30)); ?>
</a> <span>(<?php echo $this->_tpl_vars['channel']['total_videos']; ?>
)</span></li>
			  <?php endforeach; endif; unset($_from); ?>
			  <?php else: ?>
				  <li class="clsNoSideBarData"><?php echo $this->_tpl_vars['LANG']['header_nav_videochannels_no_channels_found']; ?>
</li>
			  <?php endif; ?>
		</ul>

	</div>
	<div class="clsOverflow">
		<div class="clsFloatRight">
			<p class="clsViewMore">
				<a href="<?php echo $this->_tpl_vars['viewChannelUrl']; ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_view_all_category']; ?>
</a>
			</p>
		</div>
	</div>		
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
