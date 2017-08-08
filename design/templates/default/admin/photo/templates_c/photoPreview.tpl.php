<?php /* Smarty version 2.6.18, created on 2011-10-26 11:41:21
         compiled from photoPreview.tpl */ ?>
 <div id="selPostPreview">
  <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('view_photo_form')): ?>
  <div id="selPostPreviewFrm">
      <p>      
      		<img src="<?php echo $this->_tpl_vars['myobj']->getFormField('image'); ?>
" width="<?php echo $this->_tpl_vars['myobj']->getFormField('l_width'); ?>
" height="<?php echo $this->_tpl_vars['myobj']->getFormField('l_height'); ?>
" />

      </p>
   </div>
<?php endif; ?>

</div>