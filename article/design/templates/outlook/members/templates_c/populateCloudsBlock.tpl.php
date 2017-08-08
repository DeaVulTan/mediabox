<?php /* Smarty version 2.6.18, created on 2011-10-18 14:49:59
         compiled from populateCloudsBlock.tpl */ ?>
<?php if ($this->_tpl_vars['opt'] == 'article'): ?>
	<div class="clsSideBarLeft">
		<div class="clsSideBar">
        	<p class="clsTagsHeading"><?php echo $this->_tpl_vars['LANG']['sidebar_article_tags_heading_label']; ?>
</p>
        	<span class=""></span>
    	</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebartags_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    	<div class="clsSideBarRight">
			<div class="clsSideBarContent">
	    		<?php if ($this->_tpl_vars['populateCloudsBlock']['resultFound']): ?>
	        		<p class="clsArticleTags">
	            		<?php $_from = $this->_tpl_vars['populateCloudsBlock']['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tag']):
?>
	                		<span class="<?php echo $this->_tpl_vars['tag']['class']; ?>
"><a style="font-size: 13px;" href="<?php echo $this->_tpl_vars['tag']['url']; ?>
" title="<?php echo $this->_tpl_vars['tag']['name']; ?>
"><?php echo $this->_tpl_vars['tag']['wordWrap_mb_ManualWithSpace_tag']; ?>
</a></span>
	                	<?php endforeach; endif; unset($_from); ?>
	            	</p>
	            	<div class="clsOverflow">
	            		<div class="clsViewMoreLinks">
	             			<p class="clsMoreTags"><a href="<?php echo $this->_tpl_vars['moreclouds_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_more_label']; ?>
</a></p>
	            		</div>
	           		</div>
	        	<?php else: ?>
	        		<div><p class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['sidebar_no_articletags_found_error_msg']; ?>
</p></div>
				<?php endif; ?>
			</div>
		</div>
	</div>
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebartags_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>