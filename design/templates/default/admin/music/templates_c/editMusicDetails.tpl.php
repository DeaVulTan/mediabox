<?php /* Smarty version 2.6.18, created on 2011-10-17 15:08:16
         compiled from editMusicDetails.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'editMusicDetails.tpl', 27, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin'); ?>

<div id="selMusicUpload" class="clsMusicUploadPage">
	<div>
        <h3 class="clsH3Heading">
            <?php if ($this->_tpl_vars['myobj']->chkIsEditMode()): ?>
                <?php echo $this->_tpl_vars['LANG']['editmusic_edit_title']; ?>

            <?php else: ?>
                <?php echo $this->_tpl_vars['LANG']['editmusic_title']; ?>

            <?php endif; ?>
       </h3>
    </div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_editmusic_step3')): ?>
<table><tr>
<div id="selMsgSuccess">
	<?php echo $this->_tpl_vars['LANG']['editmusic_msg_update_success']; ?>

</div>
<td><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/musicManage.php" > <?php echo $this->_tpl_vars['LANG']['editmusic_back']; ?>
 </a></td>
</tr></table>
<?php endif; ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_editmusic_step2')): ?>
          <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
        <p id="msgConfirmText"></p>
        <form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getUrl('musiclist','?pg=mymusics','mymusics/','members','music'); ?>
" autocomplete="off">
            <input type="submit" class="clsSubmitButton" name="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /> &nbsp;
            <input type="button" class="clsSubmitButton" name="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hideAllBlocks()" />
        </form>
      </div>
    <div id="selUpload">

        <form name="music_upload_form" id="music_upload_form" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" autocomplete="off" enctype="multipart/form-data">
          <a id="anchor_upload"></a>

    <div id="selUploadBlock">


        <?php $this->assign('i', '0'); ?>
             <?php unset($this->_sections['audioDetails']);
$this->_sections['audioDetails']['name'] = 'audioDetails';
$this->_sections['audioDetails']['loop'] = is_array($_loop=$this->_tpl_vars['myobj']->getFormField('total_musics')) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['audioDetails']['show'] = true;
$this->_sections['audioDetails']['max'] = $this->_sections['audioDetails']['loop'];
$this->_sections['audioDetails']['step'] = 1;
$this->_sections['audioDetails']['start'] = $this->_sections['audioDetails']['step'] > 0 ? 0 : $this->_sections['audioDetails']['loop']-1;
if ($this->_sections['audioDetails']['show']) {
    $this->_sections['audioDetails']['total'] = $this->_sections['audioDetails']['loop'];
    if ($this->_sections['audioDetails']['total'] == 0)
        $this->_sections['audioDetails']['show'] = false;
} else
    $this->_sections['audioDetails']['total'] = 0;
if ($this->_sections['audioDetails']['show']):

            for ($this->_sections['audioDetails']['index'] = $this->_sections['audioDetails']['start'], $this->_sections['audioDetails']['iteration'] = 1;
                 $this->_sections['audioDetails']['iteration'] <= $this->_sections['audioDetails']['total'];
                 $this->_sections['audioDetails']['index'] += $this->_sections['audioDetails']['step'], $this->_sections['audioDetails']['iteration']++):
$this->_sections['audioDetails']['rownum'] = $this->_sections['audioDetails']['iteration'];
$this->_sections['audioDetails']['index_prev'] = $this->_sections['audioDetails']['index'] - $this->_sections['audioDetails']['step'];
$this->_sections['audioDetails']['index_next'] = $this->_sections['audioDetails']['index'] + $this->_sections['audioDetails']['step'];
$this->_sections['audioDetails']['first']      = ($this->_sections['audioDetails']['iteration'] == 1);
$this->_sections['audioDetails']['last']       = ($this->_sections['audioDetails']['iteration'] == $this->_sections['audioDetails']['total']);
?>
                <?php $this->assign('id_field_name', "music_id_".($this->_tpl_vars['i'])); ?>
                <?php $this->assign('title_field_name', "music_title_".($this->_tpl_vars['i'])); ?>
                <?php $this->assign('album_field_name', "music_album_".($this->_tpl_vars['i'])); ?>
                <?php $this->assign('album_id_field_name', "music_album_id_".($this->_tpl_vars['i'])); ?>
                <?php $this->assign('album_sale_field_name', "album_for_sale_".($this->_tpl_vars['i'])); ?>
                <?php $this->assign('album_price_field_name', "music_album_price_".($this->_tpl_vars['i'])); ?>
                <?php $this->assign('artist_field_name', "music_artist_".($this->_tpl_vars['i'])); ?>
                <?php $this->assign('caption_field_name', "music_caption_".($this->_tpl_vars['i'])); ?>
                <?php $this->assign('thumb_field_name', "music_thumb_ext_".($this->_tpl_vars['i'])); ?>
                <?php $this->assign('thumb_folder', "music_thumb_folder_".($this->_tpl_vars['i'])); ?>
                <?php $this->assign('thumb_image_field_name', "music_thumb_image_".($this->_tpl_vars['i'])); ?>
                <?php $this->assign('year_field_name', "music_year_released_".($this->_tpl_vars['i'])); ?>
                <?php $this->assign('music_status', "music_status_".($this->_tpl_vars['i'])); ?>
                <?php $this->assign('for_sale_field_name', "for_sale_".($this->_tpl_vars['i'])); ?>
                <?php $this->assign('music_price_field_name', "music_price_".($this->_tpl_vars['i'])); ?>
                <?php $this->assign('preview_start_field_name', "preview_start_".($this->_tpl_vars['i'])); ?>
                <?php $this->assign('preview_end_field_name', "preview_end_".($this->_tpl_vars['i'])); ?>
                <?php $this->assign('album_access_type_field_name', "album_access_type_".($this->_tpl_vars['i'])); ?>
                <?php if ($this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['thumb_field_name']) != ''): ?>
	                <?php $this->assign('image_container_div_show', ''); ?>
	                <?php $this->assign('image_upload_div_show', ' style="display:none"'); ?>
                <?php else: ?>
	                <?php $this->assign('image_container_div_show', ' style="display:none"'); ?>
	                <?php $this->assign('image_upload_div_show', ''); ?>
                <?php endif; ?>
        <table summary="<?php echo $this->_tpl_vars['LANG']['editmusic_tbl_summary']; ?>
" id="selUploadTbl" class="seleditmusic" style="margin-bottom:2px;">
        	<?php if ($this->_tpl_vars['myobj']->getFormField('total_musics') > 1): ?>
			<tr><th colspan="5"><?php echo $this->_tpl_vars['LANG']['editmusic_music']; ?>
 <?php echo $this->_tpl_vars['i']+1; ?>
</th></tr>
			<?php endif; ?>
            <tr>
                <td>
            	  <?php echo $this->_tpl_vars['LANG']['editmusic_music_image']; ?>

                </td>
                <td>
                    <?php echo $this->_tpl_vars['LANG']['editmusic_music_title']; ?>
&nbsp;<span class="clsMandatoryFieldIcon"><?php echo $this->_tpl_vars['LANG']['common_music_mandatory']; ?>
</span>
                </td>
               <td>
                    <?php echo $this->_tpl_vars['LANG']['editmusic_music_artist']; ?>

                    <?php if ($this->_tpl_vars['CFG']['admin']['musics']['music_upload_artist_name_compulsory']): ?>&nbsp;<span class="clsMandatoryFieldIcon"><?php echo $this->_tpl_vars['LANG']['common_music_mandatory']; ?>
</span><?php endif; ?>
                </td>
                <td>
                    <?php echo $this->_tpl_vars['LANG']['editmusic_year_released']; ?>

                    <?php if ($this->_tpl_vars['CFG']['admin']['musics']['music_upload_release_year_compulsory']): ?>&nbsp;<span class="clsMandatoryFieldIcon"><?php echo $this->_tpl_vars['LANG']['common_music_mandatory']; ?>
</span><?php endif; ?>
                </td>
            </tr>

                <tr>
			<td class="clsAudioUploadLabel">
                    	<div id="image_container_<?php echo $this->_tpl_vars['i']; ?>
"<?php echo $this->_tpl_vars['image_container_div_show']; ?>
>
                        	<?php if ($this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['thumb_field_name']) != ''): ?>
		                        <span>
                                    <img src="<?php echo $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['thumb_folder']); ?>
<?php echo $this->_tpl_vars['myobj']->getMusicImageName($this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['id_field_name'])); ?>
M.<?php echo $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['thumb_field_name']); ?>
" />
                                    <input type="hidden" name="music_thumb_ext_<?php echo $this->_tpl_vars['i']; ?>
" id="music_thumb_ext_<?php echo $this->_tpl_vars['i']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['thumb_field_name']); ?>
" />
                                    <input type="hidden" name="music_thumb_folder_<?php echo $this->_tpl_vars['i']; ?>
" id="music_thumb_folder_<?php echo $this->_tpl_vars['i']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['thumb_folder']); ?>
" />
                                </span>
                              <?php endif; ?>
                        </div>
                        <div id="image_upload_<?php echo $this->_tpl_vars['i']; ?>
"<?php echo $this->_tpl_vars['image_upload_div_show']; ?>
>
                        	<input type="file" class="clsFile" name="music_thumb_image_<?php echo $this->_tpl_vars['i']; ?>
" id="music_thumb_image_<?php echo $this->_tpl_vars['i']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" size="5" />
                              <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip($this->_tpl_vars['thumb_image_field_name']); ?>

                        </div>
                        <?php if ($this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['thumb_field_name']) != ''): ?>
	                        <a href="javascript:void(0)" onclick="toggleUploadImage(<?php echo $this->_tpl_vars['i']; ?>
);" id="change_image_anchor_<?php echo $this->_tpl_vars['i']; ?>
"><?php echo $this->_tpl_vars['LANG']['editmusic_change_image']; ?>
</a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span>
	                        <input type="text" class="clsTextField clsTitleField" name="music_title_<?php echo $this->_tpl_vars['i']; ?>
" id="music_title_<?php echo $this->_tpl_vars['i']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['title_field_name']); ?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['admin']['musics']['title_max_length']; ?>
" /><input type="hidden" name="music_status_<?php echo $this->_tpl_vars['i']; ?>
" id="music_status_<?php echo $this->_tpl_vars['i']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['music_status']); ?>
" />
                              <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip($this->_tpl_vars['title_field_name']); ?>

	                    </span>
                    </td>

                    <td>
                        <span>
      	                  <input type="text" class="clsTextField clsTitleField" name="music_artist_<?php echo $this->_tpl_vars['i']; ?>
" id="music_artist_<?php echo $this->_tpl_vars['i']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['artist_field_name']); ?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['admin']['musics']['artist_max_length']; ?>
" />
                              <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip($this->_tpl_vars['artist_field_name']); ?>

	                        <input type="hidden" name="music_old_artist_<?php echo $this->_tpl_vars['i']; ?>
" id="music_old_artist_<?php echo $this->_tpl_vars['i']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['artist_field_name']); ?>
" />
                    </span>
                    </td>
                    <td>
                        <span>
	                        <input type="text" class="clsTextField clsYearField" name="music_year_released_<?php echo $this->_tpl_vars['i']; ?>
" id="music_year_released_<?php echo $this->_tpl_vars['i']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['year_field_name']); ?>
" maxlength="4" />
                              <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip($this->_tpl_vars['year_field_name']); ?>

                        </span>
                    </td>
                </tr>
                <tr>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('music_caption'); ?>
 clsAudioUploadLabel">
                    <label for="music_caption"><?php echo $this->_tpl_vars['LANG']['editmusic_music_description']; ?>
</label>
                </td>
                <td colspan="4" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('music_caption'); ?>
">

                    <textarea name="music_caption_<?php echo $this->_tpl_vars['i']; ?>
" id="music_caption_<?php echo $this->_tpl_vars['i']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['caption_field_name']); ?>
</textarea>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('music_caption'); ?>

                </td>
            </tr>


         </table>
                <?php if ($this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['for_sale_field_name']) == 'No'): ?>
                <?php echo '
                <script type="text/javascript">
				disabledFormFields(Array(\'music_price_'; ?>
<?php echo $this->_tpl_vars['i']; ?>
<?php echo '\'));
				</script>
                '; ?>

                <?php endif; ?>
				<?php if ($this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['for_sale_field_name']) == 'No' && ( $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['album_id_field_name']) && $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['album_sale_field_name']) == 'No' )): ?>
				<?php echo '
                <script type="text/javascript">
				disabledFormFields(Array(\'preview_start_'; ?>
<?php echo $this->_tpl_vars['i']; ?>
<?php echo '\', \'preview_end_'; ?>
<?php echo $this->_tpl_vars['i']; ?>
<?php echo '\'));
				</script>
                '; ?>

                <?php endif; ?>
                <?php if ($this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['album_id_field_name']) && $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['album_access_type_field_name']) == 'Private'): ?>
                <?php echo '
                    <script type="text/javascript">
					getAlbumPrice('; ?>
<?php echo $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['album_id_field_name']); ?>
<?php echo ', \'music_price_'; ?>
<?php echo $this->_tpl_vars['i']; ?>
<?php echo '\', \'for_sale_'; ?>
<?php echo $this->_tpl_vars['i']; ?>
<?php echo '\')
					</script>
				'; ?>

                <?php endif; ?>

         <?php $this->assign('i', $this->_tpl_vars['i']+1); ?>
          <?php endfor; endif; ?>
         <?php echo '
         <script type="text/javascript">
		'; ?>

		<?php $this->assign('i', '0'); ?>
		<?php $this->assign('del', ","); ?>
		<?php unset($this->_sections['audioDetails']);
$this->_sections['audioDetails']['name'] = 'audioDetails';
$this->_sections['audioDetails']['loop'] = is_array($_loop=$this->_tpl_vars['myobj']->getFormField('total_musics')) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['audioDetails']['show'] = true;
$this->_sections['audioDetails']['max'] = $this->_sections['audioDetails']['loop'];
$this->_sections['audioDetails']['step'] = 1;
$this->_sections['audioDetails']['start'] = $this->_sections['audioDetails']['step'] > 0 ? 0 : $this->_sections['audioDetails']['loop']-1;
if ($this->_sections['audioDetails']['show']) {
    $this->_sections['audioDetails']['total'] = $this->_sections['audioDetails']['loop'];
    if ($this->_sections['audioDetails']['total'] == 0)
        $this->_sections['audioDetails']['show'] = false;
} else
    $this->_sections['audioDetails']['total'] = 0;
if ($this->_sections['audioDetails']['show']):

            for ($this->_sections['audioDetails']['index'] = $this->_sections['audioDetails']['start'], $this->_sections['audioDetails']['iteration'] = 1;
                 $this->_sections['audioDetails']['iteration'] <= $this->_sections['audioDetails']['total'];
                 $this->_sections['audioDetails']['index'] += $this->_sections['audioDetails']['step'], $this->_sections['audioDetails']['iteration']++):
$this->_sections['audioDetails']['rownum'] = $this->_sections['audioDetails']['iteration'];
$this->_sections['audioDetails']['index_prev'] = $this->_sections['audioDetails']['index'] - $this->_sections['audioDetails']['step'];
$this->_sections['audioDetails']['index_next'] = $this->_sections['audioDetails']['index'] + $this->_sections['audioDetails']['step'];
$this->_sections['audioDetails']['first']      = ($this->_sections['audioDetails']['iteration'] == 1);
$this->_sections['audioDetails']['last']       = ($this->_sections['audioDetails']['iteration'] == $this->_sections['audioDetails']['total']);
?>
		
		<?php $this->assign('i', $this->_tpl_vars['i']+1); ?>
		<?php endfor; endif; ?>
		<?php echo '
		//var uploaded_image = \''; ?>
<?php echo $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['thumb_field_name']); ?>
<?php echo '\';
		//alert(uploaded_image);
		function toggleUploadImage(song_no)
			{
				if($Jq(\'#image_upload_\'+song_no).css(\'display\') == \'none\')
					{
						$Jq(\'#image_upload_\'+song_no).show();
						$Jq(\'#image_container_\'+song_no).hide();
						if($Jq(\'#change_image_anchor_\'+song_no))
							$Jq(\'#change_image_anchor_\'+song_no).html(lang_keep_old_image);
					}
				else
					{
						$Jq(\'#image_container_\'+song_no).show();
						$Jq(\'#image_upload_\'+song_no).hide();
						if($Jq(\'#change_image_anchor_\'+song_no))
							$Jq(\'change_image_anchor_\'+song_no).html(lang_change_image);
					}
			}
		 </script>
         '; ?>


        <p class="clsStepsTitle">Other Info</p>
                  <div class="clsTableBackground">
         <table>
			<?php if ($this->_tpl_vars['myobj']->content_filter): ?>
            <tr id="selDateLocationRow" class="clsAllowOptions">
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('music_category_type'); ?>
">
                    <label for="music_category_type"><?php echo $this->_tpl_vars['LANG']['editmusic_music_category_type']; ?>
</label>
                </td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('music_category_type'); ?>
">
                    <input type="radio" class="clsCheckRadio" name="music_category_type" id="music_category_type1" value="Porn" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('music_category_type','Porn'); ?>
 onclick="document.getElementById('selGeneralCategory').style.display='none';document.getElementById('selPornCategory').style.display='';" />
                    &nbsp;<label for="music_category_type1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_porn']; ?>
</label>
                    &nbsp;&nbsp;
                    <input type="radio" class="clsCheckRadio" name="music_category_type" id="music_category_type2" value="General" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('music_category_type','General'); ?>

                    onClick="document.getElementById('selGeneralCategory').style.display='';document.getElementById('selPornCategory').style.display='none';" />
                    &nbsp;<label for="music_category_type2" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_general']; ?>
</label>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('music_category_type'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('editmusic_category_type'); ?>
        </td>
            </tr>
            <?php endif; ?>

            <tr id="selCategoryBlock">
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('music_category_id'); ?>
">
                    <label for="music_category_id_general"><?php echo $this->_tpl_vars['LANG']['editmusic_music_category']; ?>
</label>&nbsp;<span class="clsMandatoryFieldIcon"><?php echo $this->_tpl_vars['LANG']['common_music_mandatory']; ?>
</span>&nbsp;
                </td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('music_category_id'); ?>
">
                <div id="selGeneralCategory" style="display:<?php echo $this->_tpl_vars['myobj']->General; ?>
">
                    <select name="music_category_id_general" id="music_category_id_general" <?php if ($this->_tpl_vars['CFG']['admin']['musics']['sub_category']): ?> onChange="populateMusicSubCategory(this.value)" <?php endif; ?> tabindex="<?php echo smartyTabIndex(array(), $this);?>
" class="clsSelectLarge">
                      <option value=""><?php echo $this->_tpl_vars['LANG']['common_select_option']; ?>
</option>
                      <?php echo $this->_tpl_vars['myobj']->populateMusicCatagory('General'); ?>

                    </select>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('music_category_id'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('musicupload_category_id_general'); ?>

                    <p class="clsSelectNote"><?php echo $this->_tpl_vars['LANG']['editmusic_select_category']; ?>
</p>
                </div>
                <?php if ($this->_tpl_vars['myobj']->content_filter && isAdultUser ( '' , 'music' )): ?>
                      <div id="selPornCategory" style="display:<?php echo $this->_tpl_vars['myobj']->Porn; ?>
">
                          <select name="music_category_id_porn" id="music_category_id_porn" <?php if ($this->_tpl_vars['CFG']['admin']['musics']['sub_category']): ?> onChange="populateMusicSubCategory(this.value)" <?php endif; ?> tabindex="<?php echo smartyTabIndex(array(), $this);?>
" class="clsSelectLarge">
                          <option value=""><?php echo $this->_tpl_vars['LANG']['common_select_option']; ?>
</option>
                          <?php echo $this->_tpl_vars['myobj']->populateMusicCatagory('Porn'); ?>

                          </select>
                          <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('musicupload_category_id'); ?>

                          <p class="clsSelectNote"><?php echo $this->_tpl_vars['LANG']['editmusic_select_a_category']; ?>
</p>
                      </div>
                <?php endif; ?>
               </td>
            </tr>
            <?php if ($this->_tpl_vars['CFG']['admin']['musics']['sub_category']): ?>
            <tr id="selSubCategoryBlock">
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('music_sub_category_id'); ?>
">
                <label for="music_sub_category_id"><?php echo $this->_tpl_vars['LANG']['editmusic_music_sub_category']; ?>
</label>
                </td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('music_sub_category_id'); ?>
">
                <div id="selSubCategoryBox">
                    <select name="music_sub_category_id" id="music_sub_category_id" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                        <option value=""><?php echo $this->_tpl_vars['LANG']['common_select_option']; ?>
</option>
                    </select>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('music_sub_category_id'); ?>

                </div>
                <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('music_sub_category_id'); ?>

               </td>
            </tr>
            <?php endif; ?>
            <tr>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('music_tags'); ?>
">
                    <label for="music_tags"><?php echo $this->_tpl_vars['LANG']['editmusic_music_tags']; ?>
</label>&nbsp;<span class="clsMandatoryFieldIcon"><?php echo $this->_tpl_vars['LANG']['common_music_mandatory']; ?>
</span>&nbsp;
                </td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('music_tags'); ?>
">
                    <input type="text" class="clsTextBox" name="music_tags" id="music_tags" value="<?php echo $this->_tpl_vars['myobj']->getFormField('music_tags'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('music_tags'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('music_tags'); ?>

                    <p><?php echo $this->_tpl_vars['myobj']->editmusic_tags_msg; ?>
</p>
                    <p><?php echo $this->_tpl_vars['LANG']['editmusic_tags_msg2']; ?>
</p>
                </td>
            </tr>
        </table>
		 </div>
                <div id="musicsThumsDetailsLinks" class="clsShowHideFilter">
            <a href="javascript:void(0)" id="show_link" class="clsShowFilterSearch" onclick="divShowHide('otherUploadOption', 'show_link', 'hide_link')"><?php echo $this->_tpl_vars['LANG']['editmusic_show_other_option']; ?>
</a>
            <a href="javascript:void(0)" id="hide_link" style="display:none;" class="clsHideFilterSearch"  onclick="divShowHide('otherUploadOption', 'show_link', 'hide_link')"><?php echo $this->_tpl_vars['LANG']['editmusic_hide_other_option']; ?>
</a>
        </div>
        <div id="otherUploadOption" style="display:none" class="clsDataTable">
            <table summary="<?php echo $this->_tpl_vars['LANG']['editmusic_tbl_summary']; ?>
" id="selUploadTbl_otherOption">
                <tr class="clsAllowOptions">
                  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('music_language'); ?>
 clsAudioUploadLabel">
                    <label for="music_language"><?php echo $this->_tpl_vars['LANG']['editmusic_language']; ?>
</label>
                  </td>
                  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('music_language'); ?>
">
                    <select name="music_language" id="music_language"  tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                    <option value="0"><?php echo $this->_tpl_vars['LANG']['editmusic_sel_language']; ?>
</option>
                        <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->LANG_LANGUAGE_ARR,$this->_tpl_vars['myobj']->getFormField('music_language')); ?>

                    </select>
                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('music_language'); ?>

                    </td>
                  </tr>
                <tr>
                    <th><?php echo $this->_tpl_vars['LANG']['common_sharing']; ?>
</th>
                    <th>&nbsp;</th>
                </tr>
                <tr id="selAccessTypeRow">
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('music_access_type'); ?>
">
                        <label for="music_access_type1"><?php echo $this->_tpl_vars['LANG']['editmusic_music_access_type']; ?>
</label>
                    </td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('music_access_type'); ?>
">
                        <p><input type="radio" class="clsCheckRadio" name="music_access_type" id="music_access_type1" value="Public" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                        <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('music_access_type','Public'); ?>
 />&nbsp;<label for="music_access_type1"><?php echo $this->_tpl_vars['LANG']['editmusic_public']; ?>

                        </label><?php echo $this->_tpl_vars['LANG']['editmusic_share_your_music_world']; ?>
</p>
                        <p><input type="radio" class="clsCheckRadio" name="music_access_type" id="music_access_type2" value="Private" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                        <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('music_access_type','Private'); ?>
 />&nbsp;<label for="music_access_type2"><?php echo $this->_tpl_vars['LANG']['editmusic_private']; ?>

                        </label><?php echo $this->_tpl_vars['LANG']['editmusic_only_viewable_by_you']; ?>
</p>
                        <p class="clsSelectHighlightNote"><?php echo $this->_tpl_vars['LANG']['editmusic_only_viewable_you_email']; ?>
:</p>
                        <?php echo $this->_tpl_vars['myobj']->populateEditUserForRelationList(); ?>

                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('music_access_type'); ?>

                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('music_access_type'); ?>

                     </td>
                </tr>
                <tr id="selAllowCommentsRow">
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('allow_comments'); ?>
">
                        <label for="allow_comments1"><?php echo $this->_tpl_vars['LANG']['editmusic_allow_comments']; ?>
</label>        </td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('allow_comments'); ?>
">
                    <p>
                    <input type="radio" class="clsCheckRadio" name="allow_comments" id="allow_comments1" value="Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','Yes'); ?>
 />&nbsp;<label for="allow_comments1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
</label>
                    <?php echo $this->_tpl_vars['LANG']['editmusic_allow_comments_world']; ?>
</p>
                    <p><input type="radio" class="clsCheckRadio" name="allow_comments" id="allow_comments2" value="No" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','No'); ?>
 />&nbsp;<label for="allow_comments2" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
</label>&nbsp;<?php echo $this->_tpl_vars['LANG']['editmusic_disallow_comments']; ?>
        </p>
                    <p><input type="radio" class="clsCheckRadio" name="allow_comments" id="allow_comments3" value="Kinda" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','Kinda'); ?>
 />&nbsp;<label for="allow_comments3" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_kinda']; ?>
</label>
                    <?php echo $this->_tpl_vars['LANG']['editmusic_approval_comments']; ?>
       	</p>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('allow_comments'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('allow_comments'); ?>
	</td>
                </tr>
                <tr id="selDateLocationRow" class="clsAllowOptions">
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('allow_ratings'); ?>
">
                        <label for="allow_ratings"><?php echo $this->_tpl_vars['LANG']['editmusic_allow_ratings']; ?>
</label>		</td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('allow_ratings'); ?>
">
                    <p><input type="radio" class="clsCheckRadio" name="allow_ratings" id="allow_ratings1" value="Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_ratings','Yes'); ?>
 />&nbsp;<label for="allow_ratings1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
</label>
                    <?php echo $this->_tpl_vars['LANG']['editmusic_allow_ratings_world']; ?>
</p>
                    <p><input type="radio" class="clsCheckRadio" name="allow_ratings" id="allow_ratings2" value="No" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_ratings','No'); ?>
 />&nbsp;<label for="allow_ratings2" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
</label>&nbsp;<?php echo $this->_tpl_vars['LANG']['editmusic_disallow_ratings']; ?>
             </p>
                    <p id="selDisableNote"><?php echo $this->_tpl_vars['LANG']['editmusic_disallow_ratings_note']; ?>
</p>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('allow_ratings'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('allow_ratings'); ?>

                    </td>
                </tr>
                <tr id="selDateLocationRow" class="clsAllowOptions">
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('allow_lyrics'); ?>
">
                        <label for="allow_ratings"><?php echo $this->_tpl_vars['LANG']['editmusic_allow_lyrics']; ?>
</label>		</td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('allow_lyrics'); ?>
">
                    <p><input type="radio" class="clsCheckRadio" name="allow_lyrics" id="allow_lyrics1" value="Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_lyrics','Yes'); ?>
 />&nbsp;<label for="allow_lyrics1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
</label>
                    <?php echo $this->_tpl_vars['LANG']['editmusic_allow_lyrics_world']; ?>
</p>
                    <p><input type="radio" class="clsCheckRadio" name="allow_lyrics" id="allow_lyrics2" value="No" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_lyrics','No'); ?>
 />&nbsp;<label for="allow_lyrics2" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
</label>&nbsp;<?php echo $this->_tpl_vars['LANG']['editmusic_disallow_lyrics']; ?>
             </p>
                    <p id="selLyricsNote"><?php echo $this->_tpl_vars['LANG']['editmusic_lyrics_note']; ?>
</p>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('allow_lyrics'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('allow_lyrics'); ?>

                    </td>
                </tr>
                <tr id="selDateLocationRow" class="clsAllowOptions">
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('allow_embed'); ?>
">
                        <label for="allow_embed1"><?php echo $this->_tpl_vars['LANG']['editmusic_allow_embed']; ?>
</label>		</td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('allow_embed'); ?>
">
                        <p><input type="radio" class="clsCheckRadio" name="allow_embed" id="allow_embed1" value="Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                        <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_embed','Yes'); ?>
 />&nbsp;<label for="allow_embed1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['editmusic_enable']; ?>
</label>
                        <?php echo $this->_tpl_vars['LANG']['editmusic_allow_embed_external']; ?>
</p>
                        <p><input type="radio" class="clsCheckRadio" name="allow_embed" id="allow_embed2" value="No" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                        <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_embed','No'); ?>
 />&nbsp;<label for="allow_embed2" class="clsBold"><?php echo $this->_tpl_vars['LANG']['editmusic_disable']; ?>
</label>
                        <?php echo $this->_tpl_vars['LANG']['editmusic_disallow_embed_external']; ?>
</p>
                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('allow_embed'); ?>

                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('allow_embed'); ?>

                        </td>
                </tr>
            </table>
        </div>
        
                                <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_arr); ?>

                <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->multi_hidden_arr); ?>

                <div class="clsPaddingTop10">
                <?php if (! $this->_tpl_vars['myobj']->chkIsEditMode()): ?>
                    <input type="submit" class="clsSubmitButton" name="upload_music" id="upload_music" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['editmusic_submit']; ?>
" />
                <?php else: ?>
                   <input type="submit" name="upload_music" id="upload_music" class="clsSubmitButton" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['editmusic_update']; ?>
" />
                   <input type="button" onClick="redirectEdit()" class="clsCancelButton" name="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['editmusic_cancel']; ?>
" />
                <?php endif; ?>
                </div>

        </div>
        </form>
    </div>
<?php endif; ?>


</div>
