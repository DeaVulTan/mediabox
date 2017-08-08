<?php /* Smarty version 2.6.18, created on 2012-01-13 22:18:29
         compiled from populateCloudsBlock.tpl */ ?>
<?php if ($this->_tpl_vars['opt'] == 'blog'): ?>
<div class="clsTagsHeading clsOverflow">
			<div class="clsTagsLeftHead">
				<h3>Tag Clouds</h3>
			</div>
			<div class="clsTagsRightTab">

			</div>
		</div>
		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','blog'); ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'tags_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
       <!-- <p class="clsSideBarLeftTitle">
            <?php echo $this->_tpl_vars['LANG']['common_sidebar_blog_clouds_heading_label']; ?>

        </p> -->
        <div class="clsSideBarContent">
            <?php if ($this->_tpl_vars['populateCloudsBlock']['resultFound']): ?>
				<div class="clsOverflow">
                <p class="clsPhotoTags">
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
				 </div>
                <div class="clsOverflow">
                 <div class="clsViewMoreLinks">
	             <p class="clsViewMore"><a href="<?php echo $this->_tpl_vars['moreclouds_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_sidebar_more_label']; ?>
</a></p>
                </div>
               </div>
            <?php else: ?>
               <div><p class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['common_sidebar_no_blogclouds_found_error_msg']; ?>
</p></div>
			<?php endif; ?>
        </div>
	   <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','blog'); ?>

       <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'tags_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>