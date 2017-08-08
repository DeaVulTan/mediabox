<?php /* Smarty version 2.6.18, created on 2011-10-18 15:30:22
         compiled from videoTagNavigation.tpl */ ?>
<!-- Static content Tag Clouds -->
<div class="clsSideBarLinks">
	<div class="clsSideBarMargin">
		<div class="clsTagsHeading clsOverflow">
			<div class="clsTagsLeftHead">
				<h3><?php echo $this->_tpl_vars['LANG']['header_nav_videotags_cloud_tags']; ?>
</h3>
			</div>
			<div class="clsTagsRightTab">
				
			</div>
		</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'cloudstag_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		  <div class="clsSideBarRight">
			  <div class="clsSideBarContent">
				<div class="clsCloudsTagsContainer">
                  <?php if ($this->_tpl_vars['tags']): ?><div class="clsOverflow">
					   	<p class="clsVideoTags">
							<?php $_from = $this->_tpl_vars['tags']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tag']):
?>
							<a  style="font-size: 13px;" href="<?php echo $this->_tpl_vars['tag']['url']; ?>
" class="<?php echo $this->_tpl_vars['tag']['class']; ?>
" ><?php echo $this->_tpl_vars['tag']['name']; ?>
</a>
          					<?php endforeach; endif; unset($_from); ?>
			  			</p>
					   </div>
					   <div class="clsOverflow">
					   	<div class="clsFloatRight">
				      <p class="clsViewMore"><a href="<?php echo $this->_tpl_vars['viewTagUrl']; ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_view_all_label_tags']; ?>
</a></p>
					  	</div>
					</div>	
				      <?php else: ?>
						<p class="clsNoDatas"><?php echo $this->_tpl_vars['LANG']['header_nav_videotags_no_tags_found']; ?>
</p>
    				<?php endif; ?>

                    </div>
			</div>
		  </div><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'cloudstag_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</div>
</div>
<!-- End Static content Tag Clouds -->
