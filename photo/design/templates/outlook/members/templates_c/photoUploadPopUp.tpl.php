<?php /* Smarty version 2.6.18, created on 2011-10-17 14:53:22
         compiled from photoUploadPopUp.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'photoUploadPopUp.tpl', 81, false),)), $this); ?>
<div class="clsOverflow">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'photomain_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selPhotoUpload">
	<div class="clsMainBarHeading clsOverflow clsUploadPopupHeader">
        <h3>
            <?php if ($this->_tpl_vars['myobj']->chkIsEditMode()): ?>
                <?php echo $this->_tpl_vars['LANG']['photoupload_edit_title']; ?>

            <?php else: ?>
                <?php echo $this->_tpl_vars['LANG']['photoupload_title']; ?>

            <?php endif; ?>
       </h3>
       <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_photoupload_step1') && $this->_tpl_vars['myobj']->paidmembership_upgrade_form == 0): ?>
       <ul>
        	<?php if ($this->_tpl_vars['CFG']['admin']['photos']['upload_photo_multiupload']): ?>
	            <li id="selHeaderMultiUpload"><a href="javascript:void(0);" onclick="loadUploadType('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/photoUploadPopUp.php?ajax_page=true&pg=multiupload', 'selMultiUploadContent', 'selHeaderMultiUpload');"><span><?php echo $this->_tpl_vars['LANG']['photoupload_multi_upload_title']; ?>
</span></a></li>
            <?php endif; ?>
        	<?php if ($this->_tpl_vars['CFG']['admin']['photos']['upload_photo_normalupload']): ?>
	            <li id="selHeaderNormalUpload"><a href="javascript:void(0);" onclick="loadUploadType('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/photoUploadPopUp.php?ajax_page=true&pg=normal', 'selNormalUploadContent', 'selHeaderNormalUpload');"><span><?php echo $this->_tpl_vars['LANG']['photoupload_normal_upload_title']; ?>
</span></a></li>
            <?php endif; ?>
        	<?php if ($this->_tpl_vars['CFG']['admin']['photos']['upload_photo_externalupload']): ?>
	            <li id="selHeaderExternalUpload"><a href="javascript:void(0);" onclick="loadUploadType('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/photoUploadPopUp.php?ajax_page=true&pg=external', 'selExternalUploadContent', 'selHeaderExternalUpload');"><span><?php echo $this->_tpl_vars['LANG']['photoupload_external_upload_title']; ?>
</span></a></li>
            <?php endif; ?>
        	<?php if ($this->_tpl_vars['CFG']['admin']['photos']['upload_photo_capture'] && $this->_tpl_vars['myobj']->mugshot_licence_validation): ?>
	            <li id="selHeaderCapturePhoto"><a href="javascript:void(0);" onclick="loadUploadType('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/photoUploadPopUp.php?ajax_page=true&pg=capture', 'selCaptureContent', 'selHeaderCapturePhoto');"><span><?php echo $this->_tpl_vars['LANG']['photoupload_capture_photo_title']; ?>
</span></a></li>
            <?php endif; ?>
        </ul>
        <?php endif; ?>
    </div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_photoupload_step1') && $this->_tpl_vars['myobj']->paidmembership_upgrade_form == 0): ?>
    
	<script type="text/javascript">
        var subMenuClassName1='clsActiveTabNavigation';
        var hoverElement1  = '.clsTabNavigation li';
        loadChangeClass(hoverElement1,subMenuClassName1);
    </script>

	<div id="selMultiUploadContent" style="display:none">
    	<?php if ($this->_tpl_vars['myobj']->show_div == 'selMultiUploadContent'): ?>
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'multiUpload.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <?php endif; ?>
	</div>
    <div id="selNormalUploadContent" style="display:none">
		<?php if ($this->_tpl_vars['myobj']->show_div == 'selNormalUploadContent'): ?>
		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'normalUpload.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php endif; ?>
	</div>
    <div id="selExternalUploadContent" style="display:none">
    	<?php if ($this->_tpl_vars['myobj']->show_div == 'selExternalUploadContent'): ?>
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'externalUpload.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <?php endif; ?>
    </div>
	<!--div id="selCaptureContent" style="display:block">
    	<?php if ($this->_tpl_vars['myobj']->show_div == 'selCaptureContent'): ?>
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'capturePhoto.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <?php endif; ?>
    </div-->
	<?php if ($this->_tpl_vars['CFG']['admin']['photos']['upload_photo_capture'] && $this->_tpl_vars['myobj']->mugshot_licence_validation): ?>
	<div id="selCaptureContent" style="display:none">
    	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'capturePhoto.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>
	<?php endif; ?>


<?php endif; ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_photoupload_step2')): ?>
          <div id="selMsgConfirm" style="display:none;">
      $myobj->setTemplateFolder('general/','photo')}
 	 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popupbox_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <p id="msgConfirmText"></p>
        <form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getUrl('photolist','?pg=myphotos','myphotos/','members','photo'); ?>
" autocomplete="off">
            <input type="submit" class="clsPopUpButtonSubmit" name="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /> &nbsp;
            <input type="button" class="clsPopUpButtonReset" name="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hideAllBlocks()" />
        </form>
		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

     <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popupbox_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      </div>

    <div id="selUpload">
        <div class="clsPhotoDetailHdMain clsOverflow">
            <div class="clsOverflow">
                <div class="clsStepDisableLeft">
                    <div class="clsStepDisableRight">
                      <span><?php echo $this->_tpl_vars['LANG']['photoupload_step1']; ?>
: <strong><?php echo $this->_tpl_vars['LANG']['photoupload_step1_info']; ?>
</strong></span>
                   </div>
                </div>
            <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_photoupload_step2')): ?>
                  <div class="clsStepsBg">
                    <div class="clsStepOneLeft">
                        <div class="clsStepOneRight">
                         	 <span><?php echo $this->_tpl_vars['LANG']['photoupload_step']; ?>
: <strong><?php echo $this->_tpl_vars['LANG']['photoupload_step_info']; ?>
</strong></span>
                          </div>
                      </div>
                  </div>
            <?php endif; ?>
            </div>

            <?php if (! $this->_tpl_vars['myobj']->chkIsEditMode()): ?>
                           <?php endif; ?>
        </div>
        <form name="photo_upload_form" id="photo_upload_form" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" autocomplete="off" enctype="multipart/form-data">
          <a id="anchor_upload"></a>

    <div id="selUploadBlock" class="clsUploadBlock">
        <p class="clsStepsTitle"><?php echo $this->_tpl_vars['LANG']['photoupload_basic_info']; ?>
</p>
        <div class="clsFieldContainer clsNotesDesginStepTwo clsOverflow">
                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'notesupload_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <p class="clsNote"><span class="clsNotes"><?php echo $this->_tpl_vars['LANG']['common_photo_note']; ?>
:</span>
            <p  class="clsNotesDet"><?php if (! $this->_tpl_vars['myobj']->chkIsEditMode()): ?><span><?php echo $this->_tpl_vars['LANG']['photoupload_default_setting_applied_msg']; ?>
</span><?php endif; ?>
            <?php if ($this->_tpl_vars['myobj']->chkIsEditMode()): ?><span><?php echo $this->_tpl_vars['LANG']['photoupload_photo_album_type_step2_edit']; ?>
</span><?php else: ?><br/>
            <span><?php echo $this->_tpl_vars['LANG']['photoupload_photo_album_type_step2']; ?>
</span><?php endif; ?></p></p>
                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'notesupload_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </div>
        <div class="clsNoteContainer">
          <?php $this->assign('i', '0'); ?>
             <?php unset($this->_sections['photoDetails']);
$this->_sections['photoDetails']['name'] = 'photoDetails';
$this->_sections['photoDetails']['loop'] = is_array($_loop=$this->_tpl_vars['myobj']->getFormField('total_photos')) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['photoDetails']['show'] = true;
$this->_sections['photoDetails']['max'] = $this->_sections['photoDetails']['loop'];
$this->_sections['photoDetails']['step'] = 1;
$this->_sections['photoDetails']['start'] = $this->_sections['photoDetails']['step'] > 0 ? 0 : $this->_sections['photoDetails']['loop']-1;
if ($this->_sections['photoDetails']['show']) {
    $this->_sections['photoDetails']['total'] = $this->_sections['photoDetails']['loop'];
    if ($this->_sections['photoDetails']['total'] == 0)
        $this->_sections['photoDetails']['show'] = false;
} else
    $this->_sections['photoDetails']['total'] = 0;
if ($this->_sections['photoDetails']['show']):

            for ($this->_sections['photoDetails']['index'] = $this->_sections['photoDetails']['start'], $this->_sections['photoDetails']['iteration'] = 1;
                 $this->_sections['photoDetails']['iteration'] <= $this->_sections['photoDetails']['total'];
                 $this->_sections['photoDetails']['index'] += $this->_sections['photoDetails']['step'], $this->_sections['photoDetails']['iteration']++):
$this->_sections['photoDetails']['rownum'] = $this->_sections['photoDetails']['iteration'];
$this->_sections['photoDetails']['index_prev'] = $this->_sections['photoDetails']['index'] - $this->_sections['photoDetails']['step'];
$this->_sections['photoDetails']['index_next'] = $this->_sections['photoDetails']['index'] + $this->_sections['photoDetails']['step'];
$this->_sections['photoDetails']['first']      = ($this->_sections['photoDetails']['iteration'] == 1);
$this->_sections['photoDetails']['last']       = ($this->_sections['photoDetails']['iteration'] == $this->_sections['photoDetails']['total']);
?>
                <?php $this->assign('id_field_name', "photo_id_".($this->_tpl_vars['i'])); ?>
                <?php $this->assign('title_field_name', "photo_title_".($this->_tpl_vars['i'])); ?>
                <?php $this->assign('album_field_name', "photo_album_".($this->_tpl_vars['i'])); ?>
                <?php $this->assign('caption_field_name', "photo_caption_".($this->_tpl_vars['i'])); ?>
				<?php $this->assign('photo_status', "photo_status_".($this->_tpl_vars['i'])); ?>
				<?php $this->assign('photo_small_img', "small_img_src_".($this->_tpl_vars['i'])); ?>
                <?php $this->assign('photo_album_type_field_name', "photo_album_type_".($this->_tpl_vars['i'])); ?>
         <div class="clsTableUploadPopUp clsTableUploadPopUpSeperator">
		<table summary="<?php echo $this->_tpl_vars['LANG']['photoupload_tbl_summary']; ?>
" id="selUploadTbl" class="clsPhotoUploadStepTwo">
			<?php echo '
			  <script type="text/javascript">
				var old_photo_album_name_'; ?>
<?php echo $this->_tpl_vars['i']; ?>
<?php echo ' = \''; ?>
<?php echo $this->_tpl_vars['myobj']->getFormField('photo_album'); ?>
<?php echo '\';
			  </script>
			  '; ?>

			<tr>
            	<th class="clsNoBG"><!--&nbsp;--></th>

				<?php if ($this->_tpl_vars['CFG']['admin']['photos']['photo_auto_activate'] || $this->_tpl_vars['myobj']->chkIsEditMode()): ?>
				<th class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('photo_image'); ?>
 clsNoBgColor clsStep2Title1"><?php echo $this->_tpl_vars['LANG']['photoupload_photo_image']; ?>
</th>
				<?php endif; ?>
				<th class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('photo_title'); ?>
 clsNoBgColor clsStep2Title3"><label for="photo_title_<?php echo $this->_tpl_vars['i']; ?>
"><?php echo $this->_tpl_vars['LANG']['photoupload_photo_title']; ?>
&nbsp;</label><span><?php echo $this->_tpl_vars['LANG']['common_photo_mandatory']; ?>
</span></th>
				<th class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('photo_album_type'); ?>
 clsNoBgColor clsStep2Title3"><label for="photo_album_type_<?php echo $this->_tpl_vars['i']; ?>
"><?php echo $this->_tpl_vars['LANG']['photoupload_photo_album_type_label']; ?>
</label></th>
				<th class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('photo_album'); ?>
 clsNoBgColor clsStep2Title2"><label for="photo_album_<?php echo $this->_tpl_vars['i']; ?>
"><?php echo $this->_tpl_vars['LANG']['photoupload_photo_album']; ?>
</label></th>

            	<th class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('photo_caption'); ?>
 clsNoBorder">
                    <label for="photo_caption_<?php echo $this->_tpl_vars['i']; ?>
"><?php echo $this->_tpl_vars['LANG']['photoupload_photo_description']; ?>
</label>
                </th>
			</tr>
			<tr>
                                <td class="clsPhotoCountTitle clsNoBG"> <?php echo $this->_tpl_vars['i']+1; ?>
</td>
                				<?php if ($this->_tpl_vars['CFG']['admin']['photos']['photo_auto_activate'] || $this->_tpl_vars['myobj']->chkIsEditMode()): ?>
               		<td class="clsUploadImg" rowspan="4">
					<img src="<?php echo $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['photo_small_img']); ?>
" />
					<input type="hidden" name="small_img_src_<?php echo $this->_tpl_vars['i']; ?>
"  value="<?php echo $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['photo_small_img']); ?>
"/>
				</td>
				<?php endif; ?>
                <td>
                    <input type="text" name="photo_title_<?php echo $this->_tpl_vars['i']; ?>
" id="photo_title_<?php echo $this->_tpl_vars['i']; ?>
" class="clsSelectMidSmall" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['title_field_name']); ?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['admin']['photos']['title_max_length']; ?>
" /><input type="hidden" name="photo_status_<?php echo $this->_tpl_vars['i']; ?>
" id="photo_status_<?php echo $this->_tpl_vars['i']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['photo_status']); ?>
" />
                              <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip($this->_tpl_vars['title_field_name']); ?>

                </td>
				<td >
                    <input type="radio" name="photo_album_type_<?php echo $this->_tpl_vars['i']; ?>
" id="photo_album_type_<?php echo $this->_tpl_vars['i']; ?>
_1" class="clsRadioButtonBorder" value="Private" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="checkPublic(<?php echo $this->_tpl_vars['i']; ?>
);"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio($this->_tpl_vars['photo_album_type_field_name'],'Private'); ?>
/>&nbsp;<label for="photo_album_type_<?php echo $this->_tpl_vars['i']; ?>
_1" class=""><?php echo $this->_tpl_vars['LANG']['photoupload_private']; ?>
</label>

                    <input type="radio" name="photo_album_type_<?php echo $this->_tpl_vars['i']; ?>
" id="photo_album_type_<?php echo $this->_tpl_vars['i']; ?>
_2" class="clsRadioButtonBorder" value="Public" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="checkPublic(<?php echo $this->_tpl_vars['i']; ?>
);"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio($this->_tpl_vars['photo_album_type_field_name'],'Public'); ?>
 />&nbsp;<label for="photo_album_type_<?php echo $this->_tpl_vars['i']; ?>
_2" class=""><?php echo $this->_tpl_vars['LANG']['photoupload_public']; ?>
</label>

                </td>
				<td>
					<span id="selAlbumName_<?php echo $this->_tpl_vars['i']; ?>
" style="display:<?php if ($this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['photo_album_type_field_name']) == 'Private'): ?> none <?php else: ?> block <?php endif; ?>">
						<span id='selPhotoAlbumTextBox_<?php echo $this->_tpl_vars['i']; ?>
' >
							<input type="text" name="photo_album_<?php echo $this->_tpl_vars['i']; ?>
" id="photo_album_<?php echo $this->_tpl_vars['i']; ?>
" class="clsSelectMidMedium" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('photo_album'); ?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['admin']['photos']['album_max_length']; ?>
" /></span>
							<span id="selLoadImg_<?php echo $this->_tpl_vars['i']; ?>
" style="display:none"></span>
                          <div class="clsOverflow">
                             <div class="clsUploadAlbumCreate">
								<span id="selAlbumOk_<?php echo $this->_tpl_vars['i']; ?>
" class="clsNewAlbum" style="display:none"><a href="javascript:void(0);" onclick="savePublicAlbum(document.getElementById('photo_album_<?php echo $this->_tpl_vars['i']; ?>
').value,<?php echo $this->_tpl_vars['i']; ?>
,<?php echo $this->_tpl_vars['myobj']->getFormField('total_photos'); ?>
);"><span><?php echo $this->_tpl_vars['LANG']['potoupload_ok']; ?>
</span></a></span>
                              </div>
                              <div class="clsUploadAlbumCancel">
                    			<span id="selAlbumNewCancel_<?php echo $this->_tpl_vars['i']; ?>
" class="clsCancelAlbum" style="display:none"><a href="javascript:void(0);" onclick="cancelCreateNewAlbum(<?php echo $this->_tpl_vars['i']; ?>
);"><span><?php echo $this->_tpl_vars['LANG']['photoupload_new_album_cancel']; ?>
</span></a></span>
                              </div>
                          </div>
						</span>
					<span id="selAlbumId_<?php echo $this->_tpl_vars['i']; ?>
" style="display:<?php if ($this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['photo_album_type_field_name']) == 'Private'): ?> block <?php else: ?> none <?php endif; ?>">
						<select name="album_id_<?php echo $this->_tpl_vars['i']; ?>
" id="album_id_<?php echo $this->_tpl_vars['i']; ?>
"  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" class="clsSelectBoxMidMedium" onchange="chkAlbumValue(this.value,<?php echo $this->_tpl_vars['i']; ?>
);">
                          <option value=""><?php echo $this->_tpl_vars['LANG']['common_select_option']; ?>
</option>
						  <option value="new"><?php echo $this->_tpl_vars['LANG']['photoupload_create_new_album']; ?>
</option>
                          <?php echo $this->_tpl_vars['myobj']->populatePhotoAlbum('Private',$this->_tpl_vars['CFG']['user']['user_id']); ?>

                          </select>
					</span>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('photo_album'); ?>

                </td>

            	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('photo_caption'); ?>
 clsNoBorder">
                    <textarea name="photo_caption_<?php echo $this->_tpl_vars['i']; ?>
" id="photo_caption_<?php echo $this->_tpl_vars['i']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->getFormField($this->_tpl_vars['caption_field_name']); ?>
</textarea>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip($this->_tpl_vars['caption_field_name']); ?>

                </td>
            </tr>

         </table>
         </div>
         <?php $this->assign('i', $this->_tpl_vars['i']+1); ?>
          <?php endfor; endif; ?>
         <?php echo '
         <script type="text/javascript">
		'; ?>

		<?php $this->assign('i', '0'); ?>

		<?php echo '

		 </script>
         '; ?>

 </div>
        <p class="clsStepsTitle">Other Info</p>
                  <div class="clsNoteContainerTop clsTableUploadPopUp clsEditPhotoBlock2">
         <table>
            <?php if ($this->_tpl_vars['myobj']->content_filter): ?>
            <tr id="selDateLocationRow">
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('photo_category_type'); ?>
">
                    <label for="photo_category_type1"><?php echo $this->_tpl_vars['LANG']['photoupload_photo_category_type']; ?>
</label>
                </td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('photo_category_type'); ?>
">
                    <input type="radio" name="photo_category_type" id="photo_category_type1" class="clsRadioButtonBorder" value="Porn" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('photo_category_type','Porn'); ?>
 onclick="document.getElementById('selGeneralCategory').style.display='none';document.getElementById('selPornCategory').style.display='';" />
                    &nbsp;<label for="photo_category_type1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_porn']; ?>
</label>
                    &nbsp;&nbsp;
                    <input type="radio" name="photo_category_type" id="photo_category_type2" class="clsRadioButtonBorder" value="General" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('photo_category_type','General'); ?>

                    onClick="document.getElementById('selGeneralCategory').style.display='';document.getElementById('selPornCategory').style.display='none';" />
                    &nbsp;<label for="photo_category_type2" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_general']; ?>
</label>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('photo_category_type'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('photo_category_type1'); ?>
 <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('photo_category_type2'); ?>
       </td>
            </tr>
            <?php endif; ?>
            <tr id="selCategoryBlock">
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('photo_category_id'); ?>
">
                    <label for="photo_category_id"><?php echo $this->_tpl_vars['LANG']['photoupload_photo_category']; ?>
</label>&nbsp;<span class="clsBgMandatory"><?php echo $this->_tpl_vars['LANG']['common_photo_mandatory']; ?>
</span>&nbsp;
                </td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('photo_category_id'); ?>
">
                <div id="selGeneralCategory" style="display:<?php echo $this->_tpl_vars['myobj']->General; ?>
" class="clsOverflow">
                <div class="clsUploadAlbumCreate">
                    <select name="photo_category_id" id="photo_category_id" class="clsSelectMidSmall" <?php if ($this->_tpl_vars['CFG']['admin']['photos']['sub_category']): ?> onChange="populatePhotoSubCategory(this.value)" <?php endif; ?> tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                      <option value=""><?php echo $this->_tpl_vars['LANG']['common_select_option']; ?>
</option>
                      <?php echo $this->_tpl_vars['myobj']->populatePhotoCatagory('General'); ?>

                    </select>
                   <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('photo_category_id'); ?>

                   <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('photo_category_id'); ?>

                    </div>
                </div>
                <?php if ($this->_tpl_vars['myobj']->content_filter && isAdultUser ( '' , 'photo' )): ?>
                      <div id="selPornCategory" style="display:<?php echo $this->_tpl_vars['myobj']->Porn; ?>
">
                          <select name="photo_category_id_porn" class="clsSelectMidSmall" id="photo_category_id_porn" <?php if ($this->_tpl_vars['CFG']['admin']['photos']['sub_category']): ?> onChange="populatePhotoSubCategory(this.value)" <?php endif; ?> tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                          <option value=""><?php echo $this->_tpl_vars['LANG']['common_select_option']; ?>
</option>
                          <?php echo $this->_tpl_vars['myobj']->populatePhotoCatagory('Porn'); ?>

                          </select>
						  <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('photo_category_id_porn'); ?>

                          <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('photo_category_id'); ?>

                      </div>
                <?php endif; ?>
               </td>
            </tr>
            <?php if ($this->_tpl_vars['CFG']['admin']['photos']['sub_category']): ?>
            <tr id="selSubCategoryBlock">
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('photo_sub_category_id'); ?>
">
                <label for="photo_sub_category_id"><?php echo $this->_tpl_vars['LANG']['photoupload_photo_sub_category']; ?>
</label>
                </td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('photo_sub_category_id'); ?>
">
                <div id="selSubCategoryBox">
                    <select name="photo_sub_category_id" id="photo_sub_category_id" class="clsSelectMidSmall" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                        <option value=""><?php echo $this->_tpl_vars['LANG']['common_select_option']; ?>
</option>
                    </select>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('photo_sub_category_id'); ?>

                </div>
                <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('photo_sub_category_id'); ?>

               </td>
            </tr>
            <?php endif; ?>
			<tr>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('location_recorded'); ?>
">
                    <label for="location_recorded"><?php echo $this->_tpl_vars['LANG']['potoupload_photo_location']; ?>
</label>
                </td>
				<?php if ($this->_tpl_vars['CFG']['admin']['photos']['add_photo_location']): ?>
					 <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('location_recorded'); ?>
">
                <div class="clsOverflow">
                  <div class="clsUploadAlbumCreate">
                    <div class="clsContentLeft">
                     <input type="text" name="location_recorded" id="location_recorded" class="clsSelectMidSmall" value="<?php echo $this->_tpl_vars['myobj']->getFormField('location_recorded'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" readonly/>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('location_recorded'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('location_recorded'); ?>

                    </div>
                      <div class="clsContentLeft">
					 <span class="clsUpdatePopUpLocation"><a class="clsVideoVideoEditLinks clsPhotoVideoEditLinks" id="update_photo_location" href="javascript:;" title="<?php echo $this->_tpl_vars['LANG']['potoupload_update_photo_location']; ?>
" ></a></span>
                    </div>
                 </div>
                </div>
                </td>
				<?php else: ?>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('location_recorded'); ?>
">
                <div class="clsOverflow">
                  <div class="clsUploadAlbumCreate">
                    <input type="text" name="location_recorded" id="location_recorded" class="clsSelectMidSmall" value="<?php echo $this->_tpl_vars['myobj']->getFormField('location_recorded'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('location_recorded'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('location_recorded'); ?>

                 </div>
                </div>
                </td>
			   <?php endif; ?>
            </tr>
            <tr>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('photo_tags'); ?>
">
                    <label for="photo_tags"><?php echo $this->_tpl_vars['LANG']['photoupload_photo_tags']; ?>
</label>&nbsp;<span class="clsBgMandatory"><?php echo $this->_tpl_vars['LANG']['common_photo_mandatory']; ?>
</span>&nbsp;
                </td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('photo_tags'); ?>
">
                <div class="clsOverflow">
                  <div class="clsUploadAlbumCreate">
                    <input type="text" name="photo_tags" id="photo_tags" class="clsSelectMidSmall" value="<?php echo $this->_tpl_vars['myobj']->getFormField('photo_tags'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                 	<div class="clsFieldComments"><?php echo $this->_tpl_vars['myobj']->photoUpload_tags_msg; ?>
 <?php echo $this->_tpl_vars['LANG']['photoupload_tags_msg2']; ?>
</div>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('photo_tags'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('photo_tags'); ?>

                 </div>
                  <div class="clsUploadAlbumCreate clsSelectMidLarge">
                  </div>
                </div>
                </td>
            </tr>
        </table>
		 </div>

                <div id="photosThumsDetailsLinks" class="clsShowHideFilterPopUp clsOverflow">
            <a href="javascript:void(0)" id="show_link" class="clsShowFilterSearch" onclick="divShowHide('otherUploadOption', 'show_link', 'hide_link')"><span><?php echo $this->_tpl_vars['LANG']['photoupload_show_other_option']; ?>
</span></a>
            <a href="javascript:void(0)" id="hide_link" style="display:none;" class="clsHideFilterSearch" onclick="divShowHide('otherUploadOption', 'show_link', 'hide_link')"><span><?php echo $this->_tpl_vars['LANG']['photoupload_hide_other_option']; ?>
</span></a>
        </div>
       <div id="otherUploadOption" style="display:none" class="clsDataTable">
        <p class="clsStepsTitle"><?php echo $this->_tpl_vars['LANG']['common_sharing']; ?>
</p>
        <div class="clsNoteContainerTop">
            <table summary="<?php echo $this->_tpl_vars['LANG']['photoupload_tbl_summary']; ?>
" id="selUploadTbl_otherOption">
                <tr id="selAccessTypeRow">
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('photo_access_type'); ?>
">
                        <label for="photo_access_type1"><?php echo $this->_tpl_vars['LANG']['photoupload_photo_access_type']; ?>
</label>
                    </td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('photo_access_type'); ?>
">
                        <p class="clsNoBorder"><input type="radio" name="photo_access_type" id="photo_access_type1" class="clsRadioButtonBorder" value="Public" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                        <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('photo_access_type','Public'); ?>
 />&nbsp;<label for="photo_access_type1"><?php echo $this->_tpl_vars['LANG']['photoupload_public']; ?>

                        </label><?php echo $this->_tpl_vars['LANG']['photoupload_share_your_photo_world']; ?>
</p>
                        <p class="clsNoBorder"><input type="radio" name="photo_access_type" id="photo_access_type2" class="clsRadioButtonBorder" value="Private" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                        <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('photo_access_type','Private'); ?>
 />&nbsp;<label for="photo_access_type2"><?php echo $this->_tpl_vars['LANG']['photoupload_private']; ?>

                        </label><?php echo $this->_tpl_vars['LANG']['photoupload_only_viewable_by_you']; ?>
</p>
                        <p class="clsUploadSharing"><?php echo $this->_tpl_vars['LANG']['photoupload_only_viewable_you_email']; ?>
:</p>
                        <?php echo $this->_tpl_vars['myobj']->populateCheckBoxForRelationList(); ?>

                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('photo_access_type'); ?>

                                             </td>
                </tr>
                <tr id="selAllowCommentsRow">
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('allow_comments'); ?>
">
                        <label for="allow_comments1"><?php echo $this->_tpl_vars['LANG']['photoupload_allow_comments']; ?>
</label>        </td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('allow_comments'); ?>
">
                    <p>
                    <input type="radio" name="allow_comments" id="allow_comments1" class="clsRadioButtonBorder" value="Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','Yes'); ?>
 />&nbsp;<label for="allow_comments1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
</label>
                    <?php echo $this->_tpl_vars['LANG']['photoupload_allow_comments_world']; ?>
</p>
                    <p><input type="radio" name="allow_comments" id="allow_comments2" class="clsRadioButtonBorder" value="No" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','No'); ?>
 />&nbsp;<label for="allow_comments2" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
</label>&nbsp;<?php echo $this->_tpl_vars['LANG']['photoupload_disallow_comments']; ?>
        </p>
                    <p><input type="radio" name="allow_comments" id="allow_comments3" class="clsRadioButtonBorder" value="Kinda" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','Kinda'); ?>
 />&nbsp;<label for="allow_comments3" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_kinda']; ?>
</label>
                    <?php echo $this->_tpl_vars['LANG']['photoupload_approval_comments']; ?>
       	</p>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('allow_comments'); ?>

                    	</td>
                </tr>
                <tr id="selDateLocationRow">
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('allow_ratings'); ?>
">
                        <label for="allow_ratings"><?php echo $this->_tpl_vars['LANG']['photoupload_allow_ratings']; ?>
</label>		</td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('allow_ratings'); ?>
">
                    <p><input type="radio" name="allow_ratings" id="allow_ratings1" class="clsRadioButtonBorder" value="Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_ratings','Yes'); ?>
 />&nbsp;<label for="allow_ratings1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
</label>
                    <?php echo $this->_tpl_vars['LANG']['photoupload_allow_ratings_world']; ?>
</p>
                    <p><input type="radio" name="allow_ratings" id="allow_ratings2" class="clsRadioButtonBorder" value="No" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_ratings','No'); ?>
 />&nbsp;<label for="allow_ratings2" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
</label>&nbsp;<?php echo $this->_tpl_vars['LANG']['photoupload_disallow_ratings']; ?>
             </p>
                    <p id="selDisableNote" class="clsUploadSharing"><?php echo $this->_tpl_vars['LANG']['photoupload_disallow_ratings_note']; ?>
</p>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('allow_ratings'); ?>

                                        </td>
                </tr>
				<tr id="selDateLocationRow">
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('allow_tags'); ?>
">
                        <label for="allow_tags1"><?php echo $this->_tpl_vars['LANG']['photoupload_allow_tags']; ?>
</label>		</td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('allow_tags'); ?>
">
                        <p><input type="radio" name="allow_tags" id="allow_tags1" class="clsRadioButtonBorder" value="Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                        <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_tags','Yes'); ?>
 />&nbsp;<label for="allow_tags1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
</label>
                        <?php echo $this->_tpl_vars['LANG']['photoupload_allow_tags_others']; ?>
</p>
                        <p><input type="radio" name="allow_tags" id="allow_tags2" class="clsRadioButtonBorder" value="No" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                        <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_tags','No'); ?>
 />&nbsp;<label for="allow_tags2" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
</label>
                        <?php echo $this->_tpl_vars['LANG']['photoupload_disallow_tags_others']; ?>
</p>
                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('allow_tags'); ?>

                                                </td>
                </tr>
            </table>
        </div>
        </div>
        
                                <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_arr); ?>

                <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->multi_hidden_arr); ?>

                <?php if (! $this->_tpl_vars['myobj']->chkIsEditMode()): ?>
                         <div class="clsManageCommentsBtn clsOverflow">
                          <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" class="clsSubmitButton clsphotoUploadButton" name="upload_photo" id="upload_photo" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['photoupload_submit']; ?>
" /></span></p>
                    </div>
                <?php else: ?>
                  <div class="clsManageCommentsBtn clsOverflow">
                         <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" name="upload_photo" id="upload_photo" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['photoupload_update']; ?>
" /></span></p>
                         <p class="clsDeleteButton-l"><span class="clsDeleteButton-r"><input type="button" onClick="javascript:window.location='<?php echo (isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:getUrl('photolist','?pg=myphotos','myphotos/','','photo')); ?>'"class="clsphotoUploadButton" name="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['photoupload_cancel']; ?>
" /></span></p>
                     </div>
                <?php endif; ?>

        </div>
        </form>
    </div>
<?php endif; ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_photoupload_paidmembership_upgrade_form') || $this->_tpl_vars['myobj']->paidmembership_upgrade_form == 1): ?>
<div><?php echo $this->_tpl_vars['myobj']->potoupload_upgrade_membership; ?>
</div>
<?php endif; ?>
</div>

<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'photomain_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<script>
<?php echo '
$Jq(document).ready(function() {
	$Jq(\'#update_photo_location\').fancybox({
		\'width\'				: 560,
		\'height\'			: 420,
		\'padding\'			:  0,
		\'autoScale\'     	: false,
		\'href\'              : \''; ?>
<?php echo $this->_tpl_vars['myobj']->location_url; ?>
<?php echo '\',
		\'transitionIn\'		: \'none\',
		\'transitionOut\'		: \'none\',
		\'type\'				: \'iframe\'
	});
});
'; ?>

</script>