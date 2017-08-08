<?php /* Smarty version 2.6.18, created on 2012-02-02 14:07:51
         compiled from tags.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selArticlePlayListContainer">
   <div class="clsOverflow">
    	<div class="clsArticleListHeading">
   			<h2><?php echo $this->_tpl_vars['LANG']['page_article_tags_title']; ?>
</h2>
		</div>
	</div>
	<div class="clsTags clsOverflow">
		<?php if ($this->_tpl_vars['myobj']->tag_arr['resultFound']): ?>
			<?php $_from = $this->_tpl_vars['myobj']->tag_arr['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tag']):
?>
				<div class="clsFloatLeft clsMarginRight10"><div class="<?php echo $this->_tpl_vars['tag']['class']; ?>
"><a href="<?php echo $this->_tpl_vars['tag']['url']; ?>
" <?php echo $this->_tpl_vars['tag']['fontSizeClass']; ?>
><?php echo $this->_tpl_vars['tag']['name']; ?>
</a></div></div>
			<?php endforeach; endif; unset($_from); ?>
     	<?php else: ?>
     		<div id="selMsgAlert">
				<?php echo $this->_tpl_vars['LANG']['no_tags_found']; ?>

        	</div>
		<?php endif; ?>
	</div>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>