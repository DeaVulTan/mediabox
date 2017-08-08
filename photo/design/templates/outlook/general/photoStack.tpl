<div class="clsPhotoStackMain">
<div id="photo_stack" class="photo_stack" style="display:none">
<div class="stack_count">{$LANG.header_photo_stack_title}&nbsp;<span id="stack_count"></span></div>
  <div class="clsPhotoStackCloseButton"><a href="javascript:;" onclick="hideStack()" title="{$LANG.common_close}"><!-- --></a></div>
  <div id="stack_img"></div>
</div>
	<div id="photo_stack_info" class="photo_stack_info" style="display:none">
<!--  <div class="photo_stack_info_title">{$LANG.header_photo_stack_title}</div>-->
  <div class="clsOverflow">
    <div><span class="clsPhotoStackSlideShow"><a href="{$myobj->getUrl('flashshow', '?slideshow=ql', 'ql/', '', 'photo')}" title="{$LANG.header_photo_stack_slide_show}"></a></span></div>
    <div><span class="clsPhotoStackSaveSlide"><a href="javascript:;" onclick="manageSlideList(quick_mix_photo_id_arr, '{$CFG.site.photo_url}createSlidelist.php?action=save_playlist&light_window=1', '{$LANG.common_create_slidelist}');" title="{$LANG.header_photo_stack_save}"></a></span></div>
    <div><span class="clsPhotoStackSlideClear"><a href="javascript:;" onclick="clearAllQuickSlideConfirmation()" title="{$LANG.header_photo_stack_clear}"></a></span></div>
  </div>
</div>
</div>