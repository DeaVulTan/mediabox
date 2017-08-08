<?php /* Smarty version 2.6.18, created on 2011-10-25 18:05:11
         compiled from videoPreview.tpl */ ?>
<div id="selVideoPreview"> 
	<!-- heading start -->
	<h2>
			<?php echo $this->_tpl_vars['myobj']->getFormField('user_name'); ?>
 <?php echo $this->_tpl_vars['LANG']['preview_title']; ?>

	</h2> 
	<!-- Information div -->
	
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<!-- view_video_form start -->
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('view_video_form')): ?>
 		<div id="selVideoPreviewFrm">
        	<?php if ($this->_tpl_vars['myobj']->checkIsExternalEmebedCode()): ?>
            	<?php echo $this->_tpl_vars['myobj']->displayEmbededVideo(); ?>

       		<?php endif; ?>
        	<?php if (! $this->_tpl_vars['myobj']->checkIsExternalEmebedCode()): ?>
                <?php echo ' 
                <script type="text/javascript" src="'; ?>
<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
<?php echo 'js/swfobject.js"></script>'; ?>

                <div id="flashcontent2">
                </div>
                <?php echo '
                <script type="text/javascript">
                    var so1 = new SWFObject("'; ?>
<?php echo $this->_tpl_vars['myobj']->view_video_form['flv_player_url']; ?>
<?php echo '", "flvplayer", "450", "370", "7",  null, true);
                    so1.addParam("allowFullScreen", "true");
                    so1.addParam("allowSciptAccess", "always");
                    so1.addVariable("config", "'; ?>
<?php echo $this->_tpl_vars['myobj']->view_video_form['configXmlcode_url']; ?>
<?php echo '");
                    so1.write("flashcontent2");
                </script>	
                '; ?>
	  
           <?php endif; ?>	
		</div> 
	<?php endif; ?>
	<!-- view_video_form end --->
</div> 