<?php /* Smarty version 2.6.18, created on 2011-10-17 14:53:22
         compiled from photoStack.tpl */ ?>
<div class="clsPhotoStackMain">
<div id="photo_stack" class="photo_stack" style="display:none">
<div class="stack_count"><?php echo $this->_tpl_vars['LANG']['header_photo_stack_title']; ?>
&nbsp;<span id="stack_count"></span></div>
  <div class="clsPhotoStackCloseButton"><a href="javascript:;" onclick="hideStack()" title="<?php echo $this->_tpl_vars['LANG']['common_close']; ?>
"><!-- --></a></div>
  <div id="stack_img"></div>
</div>
	<div id="photo_stack_info" class="photo_stack_info" style="display:none">
<!--  <div class="photo_stack_info_title"><?php echo $this->_tpl_vars['LANG']['header_photo_stack_title']; ?>
</div>-->
  <div class="clsOverflow">
    <div><span class="clsPhotoStackSlideShow"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('flashshow','?slideshow=ql','ql/','','photo'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['header_photo_stack_slide_show']; ?>
"></a></span></div>
    <div><span class="clsPhotoStackSaveSlide"><a href="javascript:;" onclick="manageSlideList(quick_mix_photo_id_arr, '<?php echo $this->_tpl_vars['CFG']['site']['photo_url']; ?>
createSlidelist.php?action=save_playlist&light_window=1', '<?php echo $this->_tpl_vars['LANG']['common_create_slidelist']; ?>
');" title="<?php echo $this->_tpl_vars['LANG']['header_photo_stack_save']; ?>
"></a></span></div>
    <div><span class="clsPhotoStackSlideClear"><a href="javascript:;" onclick="clearAllQuickSlideConfirmation()" title="<?php echo $this->_tpl_vars['LANG']['header_photo_stack_clear']; ?>
"></a></span></div>
  </div>
</div>
</div>