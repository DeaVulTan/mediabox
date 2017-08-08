<?php /* Smarty version 2.6.18, created on 2011-10-18 14:50:03
         compiled from featuredBoards.tpl */ ?>
<div id="selFeaturedboards" class="clsSideBarSections clsClearFix">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','discussions'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<h3><?php echo $this->_tpl_vars['LANG']['discuzz_common_featured_board_title']; ?>
</h3>
	<div id = "featured_boards" class="clsSidebarFeatured" style="display:block;">
		<?php if ($this->_tpl_vars['form_featured_boards']['displayFeaturedboards']['featured_boards']): ?>
			<?php $_from = $this->_tpl_vars['form_featured_boards']['displayFeaturedboards']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
				<div class="clsFeaturedContainer">
					<div class="clsFeaturedContent">
				  		<p class="clsBoardLink"><?php echo $this->_tpl_vars['value']['boardDetails']['board_link']; ?>
</p>
						<p class=""> <span class="clsPostBy"><?php echo $this->_tpl_vars['LANG']['index_posted_by']; ?>
 <?php echo $this->_tpl_vars['value']['boardDetails']['asked_by_link1']; ?>
</span>
						<span class="clsRatingDefault"><?php echo $this->_tpl_vars['value']['boardDetails']['total_stars']; ?>
 <?php echo $this->_tpl_vars['value']['index_rating_lang']; ?>
</span>
						</p>
					</div>
				</div>
			<?php endforeach; endif; unset($_from); ?>
			<?php if ($this->_tpl_vars['form_featured_boards']['displayFeaturedboards']['have_boards']): ?>
				<div class="clsMoreGreen"><span><a href="<?php echo $this->_tpl_vars['form_featured_boards']['displayFeaturedboards']['boards_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_more']; ?>
</a></span></div>
			<?php endif; ?>
		<?php endif; ?>
		<?php if (! $this->_tpl_vars['form_featured_boards']['displayFeaturedboards']['have_boards']): ?>
			<div class="clsNoRecords">
				<p><?php echo $this->_tpl_vars['LANG']['discuzz_common_no_boards']; ?>
</p>
			</div>
		<?php endif; ?>
	</div>
			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','discussions'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>  
</div>