<?php /* Smarty version 2.6.18, created on 2011-10-17 14:52:37
         compiled from mainIndexOtherBlocks.tpl */ ?>
<?php if (( chkAllowedModule ( array ( 'discussions' ) ) ) || ( chkAllowedModule ( array ( 'blog' ) ) ) || ( chkAllowedModule ( array ( 'article' ) ) )): ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'otherblock_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clsIndexOtherBlocksContainer">
    <div class="clsJQCarousel" id="recentListTabs">
        <ul class="clsJQCarouselTabs clsOverflow clsOtherTabs">
        	<?php if (( chkAllowedModule ( array ( 'article' ) ) )): ?>
            <li><a href="index.php?showtab=recentarticle"><span class="clsOuter"><span class="clsArticles"><?php echo $this->_tpl_vars['LANG']['common_article']; ?>
</span></span></a></li>
            <?php endif; ?>        	
           	<?php if (( chkAllowedModule ( array ( 'blog' ) ) )): ?>
            <li><a href="index.php?showtab=recentblog"><span class="clsOuter"><span class="clsBlogs"><?php echo $this->_tpl_vars['LANG']['common_blogs']; ?>
</span></span></a></li>
            <?php endif; ?>
            <?php if (( chkAllowedModule ( array ( 'discussions' ) ) )): ?>
            <li><a href="index.php?showtab=recentboard"><span class="clsOuter"><span class="clsForums"><?php echo $this->_tpl_vars['LANG']['common_boards']; ?>
</span></span></a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<script type="text/javascript">
	<?php echo '
	$Jq(window).load(function(){
		attachJqueryTabs(\'recentListTabs\');
	});
	'; ?>

</script>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'otherblock_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>