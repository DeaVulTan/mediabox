<?php /* Smarty version 2.6.18, created on 2012-03-03 11:21:56
         compiled from videoFileSettings.tpl */ ?>
<h2><?php echo $this->_tpl_vars['LANG']['videofile_setting_title']; ?>
</h2>

<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "information.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_video_file_settings')): ?>
<h3><?php echo $this->_tpl_vars['LANG']['videofile_setting_info_mesage']; ?>
</h3>
<form id="video_file_settings" method="post" name="video_file_settings" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
<table class="clsNoBorder">
<tr>
	<td class="clsWidthSmall <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('video_thumb_name'); ?>
"><label for="video_thumb_name"><?php echo $this->_tpl_vars['LANG']['videofile_setting_thumb_name']; ?>
</label></td>
    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('video_thumb_name'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('video_thumb_name'); ?>
<input type="text" class="clsTextBox" name="video_thumb_name" id="video_thumb_name" value="<?php echo $this->_tpl_vars['myobj']->getFormField('video_thumb_name'); ?>
"></td>
</tr>
<tr>
	<td class="clsWidthSmall <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('video_file_name'); ?>
"><label for="video_file_name"><?php echo $this->_tpl_vars['LANG']['videofile_setting_video_name']; ?>
</label></td>
    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('video_file_name'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('video_file_name'); ?>
<input type="text" class="clsTextBox" name="video_file_name" id="video_file_name" value="<?php echo $this->_tpl_vars['myobj']->getFormField('video_file_name'); ?>
"></td>
</tr>
<tr>
	<td class="clsWidthSmall <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('trimed_video_name'); ?>
"><label for="trimed_video_name"><?php echo $this->_tpl_vars['LANG']['videofile_setting_trimed_video_name']; ?>
</label></td>
    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('trimed_video_name'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('trimed_video_name'); ?>
<input type="text" class="clsTextBox" name="trimed_video_name" id="trimed_video_name" value="<?php echo $this->_tpl_vars['myobj']->getFormField('trimed_video_name'); ?>
"></td>
</tr>
<tr>
	<td></td>
	<td><input type="submit" class="clsSubmitButton" name="update_file_settings" value="<?php echo $this->_tpl_vars['LANG']['videofile_setting_update']; ?>
" />

    </td>

</tr>
</table>
</form>
<?php endif; ?>