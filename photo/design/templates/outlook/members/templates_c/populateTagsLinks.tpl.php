<?php /* Smarty version 2.6.18, created on 2011-10-19 22:18:00
         compiled from populateTagsLinks.tpl */ ?>
<?php $_from = $this->_tpl_vars['getTagsLink_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tagsValue']):
?>
	<a href="<?php echo $this->_tpl_vars['tagsValue']['tag_url']; ?>
" title="<?php echo $this->_tpl_vars['tagsValue']['title_tag_name']; ?>
"><?php echo $this->_tpl_vars['tagsValue']['wordWrap_mb_ManualWithSpace_tag_name']; ?>
</a>
<?php endforeach; endif; unset($_from); ?>