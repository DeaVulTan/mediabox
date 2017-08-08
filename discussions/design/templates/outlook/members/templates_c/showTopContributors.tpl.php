<?php /* Smarty version 2.6.18, created on 2011-10-18 14:50:03
         compiled from showTopContributors.tpl */ ?>

<div id="selTopContributor" class="clsSideBarSections clsClearFix">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','discussions'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<h3><?php echo $this->_tpl_vars['LANG']['discuzz_common_top_contributor_title']; ?>
 : <?php echo $this->_tpl_vars['LANG']['contributors_all_time']; ?>
</h3>
		<div class="clsSideBarContents" id="top_contributors" style="display:block;">
			<?php if ($this->_tpl_vars['form_top_contributor']['displayTopContributor']['top_contributors']): ?>

					<?php $_from = $this->_tpl_vars['form_top_contributor']['displayTopContributor']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
						<div class="<?php echo $this->_tpl_vars['value']['clsOddOrEvenBoard']; ?>
 clsTopContributor">
                        	<div class="clsUserImage">
								<?php if (isUserImageAllowed ( )): ?>
                                	<?php echo $this->_tpl_vars['discussion']->displayProfileImage($this->_tpl_vars['value']['userDetails'],'small',false); ?>

								<?php endif; ?>
							</div>
							<div>
							<p class="clsTopName"><a href="<?php echo $this->_tpl_vars['value']['mysolutions_url']; ?>
"><?php echo $this->_tpl_vars['value']['stripString_display_name']; ?>
</a></p>
							<div class="clsClearFix">
								<p class="clsFloatLeft"><span class="clsTopText"><?php echo $this->_tpl_vars['LANG']['discuzz_common_boards']; ?>
: </span> <span class="clsBold"><?php echo $this->_tpl_vars['value']['userLog']['total_board']; ?>
</span></p>
								<p class="clsFloatLeft clsTopcartBestCount"><span class="clsTopText"><?php echo $this->_tpl_vars['LANG']['index_best_solutions']; ?>
: </span> <span class="clsBold"><?php echo $this->_tpl_vars['value']['userLog']['total_best_solution']; ?>
</span></p>
							</div>
							</div>
							<div class="<?php echo $this->_tpl_vars['value']['clsOddOrEvenBoard']; ?>
 clsUserPoints <?php echo $this->_tpl_vars['value']['point_class']; ?>
 clsPNGImage">
								 <p><?php echo $this->_tpl_vars['value']['userLog']['total_points']; ?>
</p>
							</div>
						</div>
					<?php endforeach; endif; unset($_from); ?>

							<?php endif; ?>
			<?php if (! $this->_tpl_vars['form_top_contributor']['displayTopContributor']['have_contributors']): ?>
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


