<?php /* Smarty version 2.6.18, created on 2011-12-29 17:43:27
         compiled from musicPreview.tpl */ ?>
<div id="selMusicPreview">
	<!-- heading start -->
	<h2>
			<?php echo $this->_tpl_vars['myobj']->getFormField('user_name'); ?>
 <?php echo $this->_tpl_vars['LANG']['preview_title']; ?>

	</h2>
	<!-- Information div -->
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 		<div id="selMusicPreviewFrm">
        	                               <script type="text/javascript" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
js/swfobject.js"></script>
                                                                  <?php echo $this->_tpl_vars['myobj']->populateSinglePlayer($this->_tpl_vars['music_fields']); ?>

                                         
		</div>
</div>