<?php /* Smarty version 2.6.18, created on 2012-02-03 02:29:38
         compiled from tagsPlaylist.tpl */ ?>
<div id="selGroupCreate">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'audioindex_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div class="clsAudioIndex clsTagsDetails"><h3><?php echo $this->_tpl_vars['LANG']['page_playlist_title']; ?>
</h3></div>
	<p class="clsTags"><?php if ($this->_tpl_vars['myobj']->tag_arr['resultFound']): ?>
		<?php $_from = $this->_tpl_vars['myobj']->tag_arr['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tag']):
?>
			<span class="<?php echo $this->_tpl_vars['tag']['class']; ?>
"><a href="<?php echo $this->_tpl_vars['tag']['url']; ?>
" <?php echo $this->_tpl_vars['tag']['fontSizeClass']; ?>
><?php echo $this->_tpl_vars['tag']['name']; ?>
</a></span>
		<?php endforeach; endif; unset($_from); ?>
     <?php else: ?>
     	<div id="selMsgAlert">
		<?php echo $this->_tpl_vars['LANG']['no_tags_found']; ?>

        </div>
	<?php endif; ?></p>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'audioindex_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>