<?php /* Smarty version 2.6.18, created on 2011-10-24 12:07:28
         compiled from musicDownload.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "information.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if (! $this->_tpl_vars['CFG']['admin']['musics']['download_previlages'] == 'ALL'): ?>
<?php if ($this->_tpl_vars['myobj']->isPaidMemeberAlert()): ?>
      <div class="clsTrimmedMusic">
            <h4><?php echo $this->_tpl_vars['myobj']->alertMessage; ?>
</h4>
      </div>
<?php endif; ?>
<?php endif; ?>