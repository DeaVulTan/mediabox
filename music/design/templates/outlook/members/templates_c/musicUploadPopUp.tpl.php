<?php /* Smarty version 2.6.18, created on 2011-10-17 14:55:34
         compiled from musicUploadPopUp.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'musicUploadPopUp.tpl', 191, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selMusicUpload" class="clsMusicUploadPage">
<div class="clsOverflow">
	<div class="clsFloatLeft">
        <h3 class="clsH3Heading">
            <?php if ($this->_tpl_vars['myobj']->chkIsEditMode()): ?>
                <?php echo $this->_tpl_vars['LANG']['musicupload_edit_title']; ?>

            <?php else: ?>
                <?php echo $this->_tpl_vars['LANG']['musicupload_title']; ?>

            <?php endif; ?>
       </h3>
    </div>
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_musicupload_step1')): ?>
    	<div class="clsAudioListMenu clsFloatRight">
        <ul>
        	<?php if ($this->_tpl_vars['CFG']['admin']['musics']['upload_music_multiupload']): ?>
	            <li id="selHeaderMultiUpload"><a href="javascript:void(0);" title="<?php echo $this->_tpl_vars['LANG']['musicupload_multi_upload_title']; ?>
" onclick="loadUploadType('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/musicUploadPopUp.php?ajax_page=true&pg=multiupload', 'selMultiUploadContent', 'selHeaderMultiUpload');"><span><?php echo $this->_tpl_vars['LANG']['musicupload_multi_upload_title']; ?>
</span></a></li>
            <?php endif; ?>
        	<?php if ($this->_tpl_vars['CFG']['admin']['musics']['upload_music_normalupload']): ?>
	            <li id="selHeaderNormalUpload"><a href="javascript:void(0);" title="<?php echo $this->_tpl_vars['LANG']['musicupload_normal_upload_title']; ?>
" onclick="loadUploadType('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/musicUploadPopUp.php?ajax_page=true&pg=normal', 'selNormalUploadContent', 'selHeaderNormalUpload');"><span><?php echo $this->_tpl_vars['LANG']['musicupload_normal_upload_title']; ?>
</span></a></li>
            <?php endif; ?>
        	<?php if ($this->_tpl_vars['CFG']['admin']['musics']['upload_music_externalupload']): ?>
	            <li id="selHeaderExternalUpload"><a href="javascript:void(0);" title="<?php echo $this->_tpl_vars['LANG']['musicupload_external_upload_title']; ?>
" onclick="loadUploadType('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/musicUploadPopUp.php?ajax_page=true&pg=external', 'selExternalUploadContent', 'selHeaderExternalUpload');"><span><?php echo $this->_tpl_vars['LANG']['musicupload_external_upload_title']; ?>
</span></a></li>
            <?php endif; ?>
        	<?php if ($this->_tpl_vars['CFG']['admin']['musics']['upload_music_recordaudio']): ?>
	            <li id="selHeaderRecordAudio"><a href="javascript:void(0);" title="<?php echo $this->_tpl_vars['LANG']['musicupload_record_audio_title']; ?>
" onclick="loadUploadType('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/musicUploadPopUp.php?ajax_page=true&pg=record', 'selRecordAudioContent', 'selHeaderRecordAudio');"><span><?php echo $this->_tpl_vars['LANG']['musicupload_record_audio_title']; ?>
</span></a></li>
            <?php endif; ?>
        </ul>
    </div>
	<?php endif; ?>

	</div>
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_musicupload_step1')): ?>
	<script type="text/javascript">
        var subMenuClassName1='clsActiveTabNavigation';
        var hoverElement1  = '.clsTabNavigation li';
        loadChangeClass(hoverElement1,subMenuClassName1);
    </script>

	<div id="selMultiUploadContent" style="display:none">
    	<?php if ($this->_tpl_vars['myobj']->show_div == 'selMultiUploadContent'): ?>
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'multiUpload.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <?php endif; ?>
	</div>
    <div id="selNormalUploadContent" style="display:none">
    	<?php if ($this->_tpl_vars['myobj']->show_div == 'selNormalUploadContent'): ?>
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'normalUpload.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <?php endif; ?>
    </div>
    <div id="selExternalUploadContent" style="display:none">
    	<?php if ($this->_tpl_vars['myobj']->show_div == 'selExternalUploadContent'): ?>
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'externalUpload.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <?php endif; ?>
    </div>
	<div id="selRecordAudioContent" style="display:none">
    	<?php if ($this->_tpl_vars['myobj']->show_div == 'selRecordAudioContent'): ?>
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'recordAudio.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <?php endif; ?>
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_musicupload_step2')): ?>
          <div id="selMsgConfirm"   class="clsPopupConfirmation" style="display:none;">
        <p id="msgConfirmText"></p>
        <form name="selFormCreateAlbum" id="selFormCreateAlbum"></form>
        <form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getUrl('musiclist','?pg=mymusics','mymusics/','members','music'); ?>
" autocomplete="off">
                    </form>
      </div>
	  <div class="clsOverflow">
	<div class="clsStepsBg2 clsFloatLeft"><p><span><?php echo $this->_tpl_vars['LANG']['musicupload_step1']; ?>
: <strong><?php echo $this->_tpl_vars['LANG']['musicupload_music_file']; ?>
</strong></span></p></div>
	<div class="clsStepsBg1 clsFloatLeft"><p><span><?php echo $this->_tpl_vars['LANG']['musicupload_step']; ?>
: <strong><?php echo $this->_tpl_vars['LANG']['musicupload_step_info']; ?>
</strong></span></p></div>
</div>
<div class="clsUploadHeading"><span><?php echo $this->_tpl_vars['LANG']['musicupload_basic_info']; ?>
</span></div>
<div class="clsNoteContainer">
		<div class="clsNoteContainerLeft">
			<div class="clsNoteContainerRight clsOverflow">
				<div class="clsFloatLeft">
					<p class="clsNote"><?php echo $this->_tpl_vars['LANG']['common_music_note']; ?>
:</p>
				</div>
				<div class="clsFloatLeft clsMusicUploadnoteMusic">
					<p><span class="clsBold"><?php echo $this->_tpl_vars['LANG']['musicupload_music_image']; ?>
</span>: [<?php echo $this->_tpl_vars['LANG']['musicupload_max_file_size']; ?>
:&nbsp;<?php echo $this->_tpl_vars['CFG']['admin']['musics']['image_max_size']; ?>
&nbsp;<?php echo $this->_tpl_vars['LANG']['common_kilobyte']; ?>
]&nbsp;[<?php echo $this->_tpl_vars['LANG']['musicupload_allowed_formats']; ?>
:&nbsp;<?php echo $this->_tpl_vars['myobj']->music_image_format; ?>
]</p>
        <p><span class="clsBold">
        	<?php if ($this->_tpl_vars['CFG']['admin']['musics']['music_artist_feature']): ?>
	        	<?php echo $this->_tpl_vars['LANG']['musicupload_music_cast']; ?>

	        <?php else: ?>
				<?php echo $this->_tpl_vars['LANG']['musicupload_music_artist']; ?>

			<?php endif; ?>
		</span>:&nbsp;<?php echo $this->_tpl_vars['myobj']->musicupload_artist_note_msg; ?>
</p>
			</div>
				<div class="clsFloatLeft">
					 <p class="clsCheckboxNote"><span><?php echo $this->_tpl_vars['LANG']['musicupload_music_album']; ?>
</span>:&nbsp;
					<?php if ($this->_tpl_vars['CFG']['admin']['musics']['allowed_usertypes_to_upload_for_sale'] != 'None'): ?>
						<?php echo $this->_tpl_vars['LANG']['musicupload_album_price_note_msg']; ?>

					<?php endif; ?>
					<?php echo $this->_tpl_vars['LANG']['musicupload_album_note_msg']; ?>
</p>
			</div>
			</div>
		</div>
	</div>
    <div id="selUpload">
    <div class="clsMusicDetailHdMain clsOverflow">

    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_musicupload_step2')): ?>
	
    <?php endif; ?>

    <?php if (! $this->_tpl_vars['myobj']->chkIsEditMode()): ?>
         <?php endif; ?>

    </div>
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
        <table summary="<?php echo $this->_tpl_vars['LANG']['musicupload_tbl_summary']; ?>
" id="selUploadTbl" class="clsStepsTable clsMultiUploadTb" style="margin-bottom:2px;">
        	<?php if ($this->_tpl_vars['myobj']->getFormField('total_musics') > 1): ?>
			<tr><th colspan="5"><?php echo $this->_tpl_vars['LANG']['musicupload_music']; ?>
 <?php echo $this->_tpl_vars['i']+1; ?>
</th></tr>
			<?php endif; ?>
            <tr>
                <th>
            	  <?php echo $this->_tpl_vars['LANG']['musicupload_music_image']; ?>

                </th>
                <th>
                    <?php echo $this->_tpl_vars['LANG']['musicupload_music_title']; ?>
&nbsp;<span class="clsMandatoryFieldIcon"><?php echo $this->_tpl_vars['LANG']['common_music_mandatory']; ?>
</span>
                </th>
                <th>
                    <?php echo $this->_tpl_vars['LANG']['musicupload_music_album']; ?>

                    <?php if ($this->_tpl_vars['CFG']['admin']['musics']['music_upload_album_name_compulsory']): ?>&nbsp;<span class="clsMandatoryFieldIcon"><?php echo $this->_tpl_vars['LANG']['common_music_mandatory']; ?>
</span><?php endif; ?>
                </th>
               <th>
                    <?php echo $this->_tpl_vars['LANG']['musicupload_music_artist']; ?>

                    <?php if ($this->_tpl_vars['CFG']['admin']['musics']['music_upload_artist_name_compulsory']): ?>&nbsp;<span class="clsMandatoryFieldIcon"><?php echo $this->_tpl_vars['LANG']['common_music_mandatory']; ?>
</span><?php endif; ?>
                </th>
                <th>
                    <?php echo $this->_tpl_vars['LANG']['musicupload_year_released']; ?>

                    <?php if ($this->_tpl_vars['CFG']['admin']['musics']['music_upload_release_year_compulsory']): ?>&nbsp;<span class="clsMandatoryFieldIcon"><?php echo $this->_tpl_vars['LANG']['common_music_mandatory']; ?>
</span><?php endif; ?>
                </th>
				 <th>
				 	<?php echo $this->_tpl_vars['LANG']['musicupload_music_description']; ?>

                </th>
            </tr>

                <tr>
			<td class="clsUploadAudioImage">
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
" title="<?php echo $this->_tpl_vars['LANG']['musicupload_change_image']; ?>
"><?php echo $this->_tpl_vars['LANG']['musicupload_change_image']; ?>
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
                    <td class="clsUploadAlumMusic">
					<div class="clsUploadAlumMusicDiv">
							<?php if (isset ( $this->_tpl_vars['CFG']['admin']['musics']['allow_members_to_set_price_for_album'] ) && $this->_tpl_vars['CFG']['admin']['musics']['allow_members_to_set_price_for_album']): ?>
                        	<input type="checkbox" class="clsCheckRadio clsAlbumCheckBox clsPhotoVideoEditLinks" name="album_access_type_<?php echo $this->_tpl_vars['i']; ?>
" id="album_access_type_<?php echo $this->_tpl_vars['i']; ?>
" value="Private" title="<?php echo $this->_tpl_vars['LANG']['musicupload_album_checkbox_msg']; ?>
" onclick="checkIsPublic(<?php echo $this->_tpl_vars['i']; ?>
);" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                        	<?php if ($this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['album_access_type_field_name']) == 'Private'): ?> checked <?php endif; ?> />

                        	<span id="selAlbumName_<?php echo $this->_tpl_vars['i']; ?>
" style="display:<?php if ($this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['album_access_type_field_name']) == 'Private'): ?> none <?php else: ?> block <?php endif; ?>" class="clsAlbumNameEdit">
                            <?php endif; ?>
							<input type="text" class="clsTextField clsTitleField" name="music_album_<?php echo $this->_tpl_vars['i']; ?>
" id="music_album_<?php echo $this->_tpl_vars['i']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['album_field_name']); ?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['admin']['musics']['album_max_length']; ?>
" />
							<?php if (isset ( $this->_tpl_vars['CFG']['admin']['musics']['allow_members_to_set_price_for_album'] ) && $this->_tpl_vars['CFG']['admin']['musics']['allow_members_to_set_price_for_album']): ?>
							</span>
							<?php endif; ?>
	                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip($this->_tpl_vars['album_field_name']); ?>

						<?php if (isset ( $this->_tpl_vars['CFG']['admin']['musics']['allow_members_to_set_price_for_album'] ) && $this->_tpl_vars['CFG']['admin']['musics']['allow_members_to_set_price_for_album']): ?>
                        <span id="selAlbumId_<?php echo $this->_tpl_vars['i']; ?>
" style="display:<?php if ($this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['album_access_type_field_name']) == 'Private'): ?> block <?php else: ?> none <?php endif; ?>" class="clsAlbumNameEdit">
						<select name="music_album_id_<?php echo $this->_tpl_vars['i']; ?>
" id="music_album_id_<?php echo $this->_tpl_vars['i']; ?>
"  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onchange="getAlbumPrice(this.value, 'music_price_<?php echo $this->_tpl_vars['i']; ?>
', 'for_sale_<?php echo $this->_tpl_vars['i']; ?>
')" class="clsSelectLarge">
                          <option value=""><?php echo $this->_tpl_vars['LANG']['common_select_option']; ?>
</option>
                          <?php echo $this->_tpl_vars['myobj']->populateMusicAlbum('Private',$this->_tpl_vars['CFG']['user']['user_id'],$this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['album_id_field_name'])); ?>

                          </select>
						  <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip($this->_tpl_vars['album_id_field_name']); ?>

						  <input type="hidden" id="album_for_sale_<?php echo $this->_tpl_vars['i']; ?>
" name="album_for_sale_<?php echo $this->_tpl_vars['i']; ?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['album_sale_field_name']); ?>
">
						  <p id="selAlbumNew_<?php echo $this->_tpl_vars['i']; ?>
">
						  <a href="#" onClick="return callAjaxAlbum('<?php echo $this->_tpl_vars['myobj']->getUrl('createalbum','','','members','music'); ?>
','selMsgConfirm','music_album_id_<?php echo $this->_tpl_vars['i']; ?>
', '<?php echo $this->_tpl_vars['myobj']->getFormField('total_musics'); ?>
')" title="<?php echo $this->_tpl_vars['LANG']['musicupload_new_album']; ?>
"><?php echo $this->_tpl_vars['LANG']['musicupload_new_album']; ?>
</a></p>
						</span>
                        <?php endif; ?>
					</div>
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
					<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('music_caption'); ?>
">

                    <textarea name="music_caption_<?php echo $this->_tpl_vars['i']; ?>
" id="music_caption_<?php echo $this->_tpl_vars['i']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" cols="50"><?php echo $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['caption_field_name']); ?>
</textarea>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('music_caption'); ?>

                </td>
                </tr>
                
            <?php if ($this->_tpl_vars['myobj']->chkIsAllowedForSale()): ?>
            <tr id="selMusicPriceDetails_<?php echo $this->_tpl_vars['i']; ?>
">
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('music_caption'); ?>
 clsAudioUploadLabel">
                    <label for="music_caption"><?php echo $this->_tpl_vars['LANG']['musicupload_price_info']; ?>
</label> <span class="clsMandatoryFieldIcon"><?php echo $this->_tpl_vars['LANG']['common_music_mandatory']; ?>
</span>
                </td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('for_sale'); ?>
 clsUploadDetailField">
                		<p><?php echo $this->_tpl_vars['LANG']['musicupload_for_sale']; ?>
</p>
                        <input type="radio" class="clsCheckRadio" name="for_sale_<?php echo $this->_tpl_vars['i']; ?>
" id="for_sale_<?php echo $this->_tpl_vars['i']; ?>
_1" value="Yes" onClick="enabledFormFields(Array('music_price_<?php echo $this->_tpl_vars['i']; ?>
','preview_start_<?php echo $this->_tpl_vars['i']; ?>
', 'preview_end_<?php echo $this->_tpl_vars['i']; ?>
'))" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                        <?php echo $this->_tpl_vars['myobj']->isCheckedRadio($this->_tpl_vars['for_sale_field_name'],'Yes'); ?>
 />&nbsp;<label for="for_sale1"><?php echo $this->_tpl_vars['LANG']['musicupload_yes']; ?>

                        </label>
                        <input type="radio" class="clsCheckRadio" name="for_sale_<?php echo $this->_tpl_vars['i']; ?>
" id="for_sale_<?php echo $this->_tpl_vars['i']; ?>
_2" value="No" onClick="disabledFormFields(Array('music_price_<?php echo $this->_tpl_vars['i']; ?>
','preview_start_<?php echo $this->_tpl_vars['i']; ?>
', 'preview_end_<?php echo $this->_tpl_vars['i']; ?>
'))" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                        <?php echo $this->_tpl_vars['myobj']->isCheckedRadio($this->_tpl_vars['for_sale_field_name'],'No'); ?>
 />&nbsp;<label for="for_sale2"><?php echo $this->_tpl_vars['LANG']['musicupload_no']; ?>

                        </label>
                </td>
               <?php if (isset ( $this->_tpl_vars['CFG']['admin']['musics']['allow_members_to_choose_the_preview'] ) && $this->_tpl_vars['CFG']['admin']['musics']['allow_members_to_choose_the_preview']): ?>
                <td class="clsUploadDetailField">
                        <span>
                        <p><?php echo $this->_tpl_vars['LANG']['musicupload_preview_start']; ?>
</p>
	                        <input type="text" class="clsTextField clsTitleField" name="preview_start_<?php echo $this->_tpl_vars['i']; ?>
" id="preview_start_<?php echo $this->_tpl_vars['i']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['preview_start_field_name']); ?>
" maxlength="4" />
                              <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip($this->_tpl_vars['preview_start_field_name']); ?>

                        </span>
                </td>
                <td class="clsUploadDetailField">
                        <span>
                        <p><?php echo $this->_tpl_vars['LANG']['musicupload_preview_end']; ?>
</p>
	                        <input type="text" class="clsTextField clsTitleField" name="preview_end_<?php echo $this->_tpl_vars['i']; ?>
" id="preview_end_<?php echo $this->_tpl_vars['i']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['preview_end_field_name']); ?>
" maxlength="4" />
                              <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip($this->_tpl_vars['preview_end_field_name']); ?>

                        </span>
                </td>
                <?php endif; ?>
                <td class="clsUploadDetailField" <?php if (isset ( $this->_tpl_vars['CFG']['admin']['musics']['allow_members_to_choose_the_preview'] ) && ! $this->_tpl_vars['CFG']['admin']['musics']['allow_members_to_choose_the_preview']): ?> colspan="3" <?php endif; ?>>
                        <span >
                        	<p id="selPriceDetails"><?php echo $this->_tpl_vars['LANG']['musicupload_music_price']; ?>
&nbsp;(<?php echo $this->_tpl_vars['CFG']['currency']; ?>
)</p>
	                        <input type="text" class="clsTextField clsYearField" name="music_price_<?php echo $this->_tpl_vars['i']; ?>
" id="music_price_<?php echo $this->_tpl_vars['i']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['music_price_field_name']); ?>
" maxlength="4" />
                              <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip($this->_tpl_vars['music_price_field_name']); ?>

                        </span>
                </td>

            </tr>
            <?php endif; ?>

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
							$Jq(\'#change_image_anchor_\'+song_no).html(lang_change_image);
					}
			}
		 </script>
         '; ?>

	<div class="clsUploadHeading"><span>Other Info</span></div>
                  <div class="">
         <table class="clsOtherinfotable">
			<?php if ($this->_tpl_vars['myobj']->content_filter): ?>
            <tr id="selDateLocationRow" class="clsAllowOptions">
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('music_category_type'); ?>
">
                    <label for="music_category_type"><?php echo $this->_tpl_vars['LANG']['musicupload_music_category_type']; ?>
</label>
                </td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('music_category_type'); ?>
">
                    <input type="radio" class="clsCheckRadio" name="music_category_type" id="music_category_type1" value="Porn" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('music_category_type','Porn'); ?>
 onclick="document.getElementById('selGeneralCategory').style.display='none';document.getElementById('selPornCategory').style.display='';" />
                    &nbsp;<label for="music_category_type1" class=""><?php echo $this->_tpl_vars['LANG']['common_porn']; ?>
</label>
                    &nbsp;&nbsp;
                    <input type="radio" class="clsCheckRadio" name="music_category_type" id="music_category_type2" value="General" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('music_category_type','General'); ?>

                    onClick="document.getElementById('selGeneralCategory').style.display='';document.getElementById('selPornCategory').style.display='none';" />
                    &nbsp;<label for="music_category_type2" class=""><?php echo $this->_tpl_vars['LANG']['common_general']; ?>
</label>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('music_category_type'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('musicupload_category_type'); ?>
        </td>
            </tr>
            <?php endif; ?>

            <tr id="selCategoryBlock">
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('music_category_id'); ?>
">
                    <label for="music_category_id_general"><?php echo $this->_tpl_vars['LANG']['musicupload_music_category']; ?>
</label>&nbsp;<span class="clsMandatoryFieldIcon"><?php echo $this->_tpl_vars['LANG']['common_music_mandatory']; ?>
</span>&nbsp;
                </td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('music_category_id'); ?>
">
                <div id="selGeneralCategory" style="display:<?php echo $this->_tpl_vars['myobj']->General; ?>
">
                    <select name="music_category_id_general" id="music_category_id_general" <?php if ($this->_tpl_vars['CFG']['admin']['musics']['sub_category']): ?> onChange="populateMusicSubCategory(this.value)" <?php endif; ?> tabindex="<?php echo smartyTabIndex(array(), $this);?>
" class="clsSelectLarge validate-selection">
                      <option value=""><?php echo $this->_tpl_vars['LANG']['common_select_option']; ?>
</option>
                      <?php echo $this->_tpl_vars['myobj']->populateMusicCatagory('General'); ?>

                    </select>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('music_category_id'); ?>

                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('music_category_id_general'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('musicupload_category_id_general'); ?>

                    <p class="clsSelectNote clsUploadnotesmall"><?php echo $this->_tpl_vars['LANG']['musicupload_select_category']; ?>
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

                          <p class="clsSelectNote clsUploadnotesmall"><?php echo $this->_tpl_vars['LANG']['musicupload_select_a_category']; ?>
</p>
                      </div>
                <?php endif; ?>
               </td>
            </tr>
            <?php if ($this->_tpl_vars['CFG']['admin']['musics']['sub_category']): ?>
            <tr id="selSubCategoryBlock">
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('music_sub_category_id'); ?>
">
                <label for="music_sub_category_id"><?php echo $this->_tpl_vars['LANG']['musicupload_music_sub_category']; ?>
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
                    <label for="music_tags"><?php echo $this->_tpl_vars['LANG']['musicupload_music_tags']; ?>
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

                    <p class="clsMusictagnote clsUploadnotesmall"><?php echo $this->_tpl_vars['myobj']->musicUpload_tags_msg; ?>
</p>
                </td>
            </tr>
        </table>
		 </div>
        		<div class="clsUploadHeading">
        <div id="musicsThumsDetailsLinks" class="clsShowHideFilter">
            <a href="javascript:void(0)" id="show_link" class="clsShowFilterSearch" onclick="divShowHide('otherUploadOption', 'show_link', 'hide_link')" title="<?php echo $this->_tpl_vars['LANG']['musicupload_show_other_option']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['musicupload_show_other_option']; ?>
</span></a>
            <a href="javascript:void(0)" id="hide_link" style="display:none;" class="clsHideFilterSearch"  onclick="divShowHide('otherUploadOption', 'show_link', 'hide_link')"><span><?php echo $this->_tpl_vars['LANG']['musicupload_hide_other_option']; ?>
</span></a>
        </div>
		</div>
        <div id="otherUploadOption" style="display:none" class="clsDataTable">
            <table summary="<?php echo $this->_tpl_vars['LANG']['musicupload_tbl_summary']; ?>
" id="selUploadTbl_otherOption">
                <tr class="clsAllowOptions">
                  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('music_language'); ?>
 clsAudioUploadLabel">
                    <label for="music_language"><?php echo $this->_tpl_vars['LANG']['musicupload_language']; ?>
</label>
                  </td>
                  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('music_language'); ?>
">
                    <select name="music_language" id="music_language"  tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                    <option value="0"><?php echo $this->_tpl_vars['LANG']['musicupload_sel_language']; ?>
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
                        <label for="music_access_type1"><?php echo $this->_tpl_vars['LANG']['musicupload_music_access_type']; ?>
</label>
                    </td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('music_access_type'); ?>
">
                        <p><input type="radio" class="clsCheckRadio" name="music_access_type" id="music_access_type1" value="Public" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                        <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('music_access_type','Public'); ?>
 />&nbsp;<label for="music_access_type1"><?php echo $this->_tpl_vars['LANG']['musicupload_public']; ?>

                        </label><?php echo $this->_tpl_vars['LANG']['musicupload_share_your_music_world']; ?>
</p>
                        <p><input type="radio" class="clsCheckRadio" name="music_access_type" id="music_access_type2" value="Private" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                        <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('music_access_type','Private'); ?>
 />&nbsp;<label for="music_access_type2"><?php echo $this->_tpl_vars['LANG']['musicupload_private']; ?>

                        </label><?php echo $this->_tpl_vars['LANG']['musicupload_only_viewable_by_you']; ?>
</p>
                        <p class="clsSelectHighlightNote"><?php echo $this->_tpl_vars['LANG']['musicupload_only_viewable_you_email']; ?>
:</p>
                        <?php echo $this->_tpl_vars['myobj']->populateCheckBoxForRelationList(); ?>

                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('music_access_type'); ?>

                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('music_access_type'); ?>

                     </td>
                </tr>
                <tr id="selAllowCommentsRow">
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('allow_comments'); ?>
">
                        <label for="allow_comments1"><?php echo $this->_tpl_vars['LANG']['musicupload_allow_comments']; ?>
</label>        </td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('allow_comments'); ?>
">
                    <p>
                    <input type="radio" class="clsCheckRadio" name="allow_comments" id="allow_comments1" value="Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','Yes'); ?>
 />&nbsp;<label for="allow_comments1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
</label>
                    <?php echo $this->_tpl_vars['LANG']['musicupload_allow_comments_world']; ?>
</p>
                    <p><input type="radio" class="clsCheckRadio" name="allow_comments" id="allow_comments2" value="No" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','No'); ?>
 />&nbsp;<label for="allow_comments2" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
</label>&nbsp;<?php echo $this->_tpl_vars['LANG']['musicupload_disallow_comments']; ?>
        </p>
                    <p><input type="radio" class="clsCheckRadio" name="allow_comments" id="allow_comments3" value="Kinda" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','Kinda'); ?>
 />&nbsp;<label for="allow_comments3" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_kinda']; ?>
</label>
                    <?php echo $this->_tpl_vars['LANG']['musicupload_approval_comments']; ?>
       	</p>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('allow_comments'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('allow_comments'); ?>
	</td>
                </tr>
                <tr id="selDateLocationRow" class="clsAllowOptions">
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('allow_ratings'); ?>
">
                        <label for="allow_ratings"><?php echo $this->_tpl_vars['LANG']['musicupload_allow_ratings']; ?>
</label>		</td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('allow_ratings'); ?>
">
                    <p><input type="radio" class="clsCheckRadio" name="allow_ratings" id="allow_ratings1" value="Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_ratings','Yes'); ?>
 />&nbsp;<label for="allow_ratings1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
</label>
                    <?php echo $this->_tpl_vars['LANG']['musicupload_allow_ratings_world']; ?>
</p>
                    <p><input type="radio" class="clsCheckRadio" name="allow_ratings" id="allow_ratings2" value="No" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_ratings','No'); ?>
 />&nbsp;<label for="allow_ratings2" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
</label>&nbsp;<?php echo $this->_tpl_vars['LANG']['musicupload_disallow_ratings']; ?>
             </p>
                    <p id="selDisableNote"><?php echo $this->_tpl_vars['LANG']['musicupload_disallow_ratings_note']; ?>
</p>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('allow_ratings'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('allow_ratings'); ?>

                    </td>
                </tr>
                <tr id="selDateLocationRow" class="clsAllowOptions">
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('allow_lyrics'); ?>
">
                        <label for="allow_ratings"><?php echo $this->_tpl_vars['LANG']['musicupload_allow_lyrics']; ?>
</label>		</td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('allow_lyrics'); ?>
">
                    <p><input type="radio" class="clsCheckRadio" name="allow_lyrics" id="allow_lyrics1" value="Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_lyrics','Yes'); ?>
 />&nbsp;<label for="allow_lyrics1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
</label>
                    <?php echo $this->_tpl_vars['LANG']['musicupload_allow_lyrics_world']; ?>
</p>
                    <p><input type="radio" class="clsCheckRadio" name="allow_lyrics" id="allow_lyrics2" value="No" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_lyrics','No'); ?>
 />&nbsp;<label for="allow_lyrics2" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
</label>&nbsp;<?php echo $this->_tpl_vars['LANG']['musicupload_disallow_lyrics']; ?>
             </p>
                    <p id="selLyricsNote"><?php echo $this->_tpl_vars['LANG']['musicupload_lyrics_note']; ?>
</p>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('allow_lyrics'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('allow_lyrics'); ?>

                    </td>
                </tr>
                <tr id="selDateLocationRow" class="clsAllowOptions">
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('allow_embed'); ?>
">
                        <label for="allow_embed1"><?php echo $this->_tpl_vars['LANG']['musicupload_allow_embed']; ?>
</label>		</td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('allow_embed'); ?>
">
                        <p><input type="radio" class="clsCheckRadio" name="allow_embed" id="allow_embed1" value="Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                        <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_embed','Yes'); ?>
 />&nbsp;<label for="allow_embed1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['musicupload_enable']; ?>
</label>
                        <?php echo $this->_tpl_vars['LANG']['musicupload_allow_embed_external']; ?>
</p>
                        <p><input type="radio" class="clsCheckRadio" name="allow_embed" id="allow_embed2" value="No" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                        <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_embed','No'); ?>
 />&nbsp;<label for="allow_embed2" class="clsBold"><?php echo $this->_tpl_vars['LANG']['musicupload_disable']; ?>
</label>
                        <?php echo $this->_tpl_vars['LANG']['musicupload_disallow_embed_external']; ?>
</p>
                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('allow_embed'); ?>

                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('allow_embed'); ?>

                        </td>
                </tr>
            </table>
        </div>
        
                                <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_arr); ?>

                <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->multi_hidden_arr); ?>

                <?php if (! $this->_tpl_vars['myobj']->chkIsEditMode()): ?>
                    <div class="clsOverflow">
                        <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" class="clsSubmitButton clsmusicUploadButton" name="upload_music" id="upload_music" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['musicupload_submit']; ?>
" />
                        </span></p>
                    </div>
                <?php else: ?>
                    <div class="clsOverflow">
                         <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" name="upload_music" id="upload_music" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['musicupload_update']; ?>
" /></span></p>
                         <p class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="button" onClick="javascript:window.location='<?php echo (isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:getUrl('musiclist','?pg=mymusics','mymusics/','','music')); ?>'"class="clsmusicUploadButton" name="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['musicupload_cancel']; ?>
" /></span></p>
                     </div>
                <?php endif; ?>

        </div>
        </form>
    </div>


<?php endif; ?>

</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>