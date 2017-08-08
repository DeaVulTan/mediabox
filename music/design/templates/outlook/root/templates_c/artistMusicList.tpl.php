<?php /* Smarty version 2.6.18, created on 2012-01-01 20:17:24
         compiled from artistMusicList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'artistMusicList.tpl', 7, false),)), $this); ?>
<?php if ($this->_tpl_vars['displaySongList_arr']['record_count']): ?>
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'details_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php $this->assign('count', '1'); ?>
	  <div class="clsSongListDetails">
		<?php $_from = $this->_tpl_vars['displaySongList_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['songListKey'] => $this->_tpl_vars['songListValue']):
?>
			<?php echo smarty_function_counter(array('assign' => 'count'), $this);?>

			<p <?php if ($this->_tpl_vars['lastDiv'] == $this->_tpl_vars['count']): ?> <?php echo smarty_function_counter(array('start' => 0), $this);?>
 class="clsNoBorder"<?php endif; ?>title="<?php echo $this->_tpl_vars['songListValue']['record']['music_title']; ?>
"><strong><a  href="<?php echo $this->_tpl_vars['songListValue']['getUrl_viewMusic_url']; ?>
"><?php echo $this->_tpl_vars['songListValue']['wordWrap_mb_ManualWithSpace_music_title']; ?>
</a></strong>(<span title="<?php echo $this->_tpl_vars['songListValue']['record']['album_title']; ?>
" ><a href="<?php echo $this->_tpl_vars['songListValue']['get_album_url']; ?>
"><?php echo $this->_tpl_vars['songListValue']['wordWrap_mb_ManualWithSpace_album_title']; ?>
</a></span>)</p>
		<?php endforeach; endif; unset($_from); ?>
	  </div>
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'details_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>