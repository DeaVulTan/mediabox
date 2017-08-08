<?php /* Smarty version 2.6.18, created on 2011-11-08 13:48:18
         compiled from playSongsInPlaylist.tpl */ ?>
<?php if ($this->_tpl_vars['myobj']->total_tracks): ?>
<div class="clsPlaysonginPlaylist">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php echo $this->_tpl_vars['myobj']->populatePlayerWithPlaylist($this->_tpl_vars['music_fields']); ?>

</div>
<?php else: ?>
	<div id="selMsgAlert">
		<p><?php echo $this->_tpl_vars['LANG']['common_msg_no_playlist_song_added']; ?>
</p>
	</div>
<?php endif; ?>