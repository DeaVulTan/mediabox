<?php /* Smarty version 2.6.18, created on 2011-10-18 14:50:03
         compiled from featuredContributors.tpl */ ?>
<div id="selFeaturedContributor" class="clsFeaturedContributor clsSideBarSections clsClearFix">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','discussions'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<h3><?php echo $this->_tpl_vars['LANG']['discuzz_common_featured_contributor_title']; ?>
</h3>
		<div class="clsSideBarContents" id="featured_contributors" style="display:block;">
			<?php if ($this->_tpl_vars['form_featured_contributor']['displayFeaturedContributor']['featured_contributors']): ?>
				<div class="clsFeaturedContributors clsClearFix">
				<?php $_from = $this->_tpl_vars['form_featured_contributor']['displayFeaturedContributor']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
						<div class="clsFeaturedUser">
						<?php if (isUserImageAllowed ( )): ?>
							<?php echo $this->_tpl_vars['discussion']->displayProfileImage($this->_tpl_vars['value']['userDetails'],'small',false); ?>

						<?php endif; ?>
						<p class="clsUserName"><a href="<?php echo $this->_tpl_vars['value']['mysolutions_url']; ?>
"><?php echo $this->_tpl_vars['value']['stripString_display_name']; ?>
</a></p>
						</div>
				<?php endforeach; endif; unset($_from); ?>
				</div>
			<?php if ($this->_tpl_vars['form_featured_contributor']['displayFeaturedContributor']['have_users']): ?>
				<div class="clsMoreGreen"><span><a href="<?php echo $this->_tpl_vars['form_featured_contributor']['displayFeaturedContributor']['topcontributors_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_more']; ?>
</a></span></div>
			<?php endif; ?>
			<?php endif; ?>
			<?php if (! $this->_tpl_vars['form_featured_contributor']['displayFeaturedContributor']['have_users']): ?>
				<div class="clsNoRecords">
					<p><?php echo $this->_tpl_vars['LANG']['discuzz_common_no_contributors']; ?>
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