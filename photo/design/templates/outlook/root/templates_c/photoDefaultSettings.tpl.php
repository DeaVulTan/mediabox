<?php /* Smarty version 2.6.18, created on 2012-02-02 19:29:24
         compiled from photoDefaultSettings.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'photoDefaultSettings.tpl', 19, false),)), $this); ?>
<div class="clsOverflow">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'photomain_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selphotoupload" class="clsPhotoUploadPage">
	<div class="clsMainBarHeading">
        <h3>
            <?php echo $this->_tpl_vars['LANG']['photoupload_default_settings']; ?>

       </h3>
    </div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_photo_default_form')): ?>
          <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
      <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

 	  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popupbox_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <p id="msgConfirmText"></p>
        <form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getUrl('photolist','?pg=myphotos','myphotos/','','photo'); ?>
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
		<?php if (! $this->_tpl_vars['myobj']->chkIsEditMode()): ?>
         <?php endif; ?>

    </div>
      <div class="clsFieldContainer clsNotesDesgin clsOverflow">
                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'notesupload_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <p class="clsNote">
        <span class="clsNotes"><?php echo $this->_tpl_vars['LANG']['common_photo_note']; ?>
: </span>
        <span class="clsNotesDet"><?php echo $this->_tpl_vars['LANG']['potoupload_default_note_msg']; ?>
</span></p>
                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'notesupload_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>
      <form name="photo_upload_form" id="photo_upload_form" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" autocomplete="off" enctype="multipart/form-data" >
   <div id="selUploadBlock">
   <p class="clsStepsTitle"><?php echo $this->_tpl_vars['LANG']['photoupload_default_settings_general_info']; ?>
</p>
                   <div class="clsNoteContainer clsTableBackground">
         <table>
		 	<tr>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('photo_album_type'); ?>
">
                    <label for="photo_album_type"><?php echo $this->_tpl_vars['LANG']['photoupload_private']; ?>
 <?php echo $this->_tpl_vars['LANG']['photoupload_photo_album']; ?>
</label>&nbsp;
                </td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('photo_album_type'); ?>
">
                    <p><input type="checkbox" class="clsCheckRadio clsRadioButtonBorder" name="photo_album_type" id="photo_album_type" value="Private" onclick="checkPublic();" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                        <?php if ($this->_tpl_vars['myobj']->getFormField('photo_album_type') == 'Private'): ?> checked <?php endif; ?> /></p>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('photo_album_type'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('photo_album_type'); ?>

                    <p class="clsFieldComments"><?php echo $this->_tpl_vars['LANG']['photoupload_photo_album_type']; ?>
</p>
                </td>
            </tr>
			  <?php echo '
			  <script type="text/javascript">
				var old_photo_album_name = \''; ?>
<?php echo $this->_tpl_vars['myobj']->getFormField('photo_album'); ?>
<?php echo '\';
			  </script>
			  '; ?>

		 	<tr>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('photo_album'); ?>
">
                    <label for="photo_album"><?php echo $this->_tpl_vars['LANG']['photoupload_photo_album']; ?>
</label>&nbsp;
                </td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('photo_album'); ?>
">
					<span id="selAlbumName" style="display:<?php if ($this->_tpl_vars['myobj']->getFormField('photo_album_type') == 'Private'): ?> none <?php else: ?> block <?php endif; ?>">
                    	<span id='selPhotoAlbumTextBox'><input type="text" class="clsTextBox" name="photo_album" id="photo_album" value="<?php echo $this->_tpl_vars['myobj']->getFormField('photo_album'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></span>
					</span>
					<span id="selAlbumId" style="display:<?php if ($this->_tpl_vars['myobj']->getFormField('photo_album_type') == 'Private'): ?> block <?php else: ?> none <?php endif; ?>">
						<select name="album_id" id="album_id"  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" class="clsSelectMedium">
                          <option value=""><?php echo $this->_tpl_vars['LANG']['common_select_option']; ?>
</option>
                          <?php echo $this->_tpl_vars['myobj']->populatePhotoAlbum('Private',$this->_tpl_vars['CFG']['user']['user_id']); ?>

                          </select>
                          <div class="clsOverflow">
                           <div id="selAlbumNew" class="clsNewAlbum" ><a href="javascript:void(0);" onclick="changToText();"><span><?php echo $this->_tpl_vars['LANG']['photoupload_new_album']; ?>
</span></a></div>
                          </div>
					</span>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('photo_album'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('photo_album_name'); ?>

                    <p class="clsFieldComments"><?php echo $this->_tpl_vars['LANG']['photoupload_photo_album_name']; ?>
</p>
                </td>
            </tr>
			<?php if ($this->_tpl_vars['myobj']->content_filter): ?>
            <tr id="selDateLocationRow" class="clsAllowOptions">
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('photo_category_type'); ?>
">
                    <label for="photo_category_type1"><?php echo $this->_tpl_vars['LANG']['photoupload_photo_category_type']; ?>
</label>
                </td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('photo_category_type'); ?>
">
                    <input type="radio" class="clsCheckRadio clsRadioButtonBorder" name="photo_category_type" id="photo_category_type1" value="Porn" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('photo_category_type','Porn'); ?>
 onclick="document.getElementById('selGeneralCategory').style.display='none';document.getElementById('selPornCategory').style.display='';" />
                    &nbsp;<label for="photo_category_type1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_porn']; ?>
</label>
                    &nbsp;&nbsp;
                    <input type="radio" class="clsCheckRadio clsRadioButtonBorder" name="photo_category_type" id="photo_category_type2" value="General" tabindex="<?php echo smartyTabIndex(array(), $this);?>
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
">
                    <select name="photo_category_id" id="photo_category_id" <?php if ($this->_tpl_vars['CFG']['admin']['photos']['sub_category']): ?> onChange="populatePhotoSubCategory(this.value)" <?php endif; ?> tabindex="<?php echo smartyTabIndex(array(), $this);?>
" class="clsSelectMedium">
                      <option value=""><?php echo $this->_tpl_vars['LANG']['common_select_option']; ?>
</option>
                      <?php echo $this->_tpl_vars['myobj']->populatePhotoCatagory('General'); ?>

                    </select>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('photo_category_id'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('photo_category_id'); ?>

                    <p class="clsSelectNote clsFieldComments"><?php echo $this->_tpl_vars['LANG']['photoupload_select_category']; ?>
</p>
                </div>
                <?php if ($this->_tpl_vars['myobj']->content_filter && isAdultUser ( '' , 'photo' )): ?>
                      <div id="selPornCategory" style="display:<?php echo $this->_tpl_vars['myobj']->Porn; ?>
">
                          <select name="photo_category_id_porn" id="photo_category_id_porn" <?php if ($this->_tpl_vars['CFG']['admin']['photos']['sub_category']): ?> onChange="populatePhotoSubCategory(this.value)" <?php endif; ?> tabindex="<?php echo smartyTabIndex(array(), $this);?>
" class="clsSelectMedium">
                          <option value=""><?php echo $this->_tpl_vars['LANG']['common_select_option']; ?>
</option>
                          <?php echo $this->_tpl_vars['myobj']->populatePhotoCatagory('Porn'); ?>

                          </select>
						  <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('photo_category_id_porn'); ?>

                          <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('photo_category_id'); ?>

                          <p class="clsSelectNote clsFieldComments"><?php echo $this->_tpl_vars['LANG']['photoupload_select_a_category']; ?>
</p>
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
                    <select name="photo_sub_category_id" id="photo_sub_category_id" class="clsSelectMedium" tabindex="<?php echo smartyTabIndex(array(), $this);?>
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
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('photo_tags'); ?>
">
                    <label for="photo_tags"><?php echo $this->_tpl_vars['LANG']['photoupload_photo_tags']; ?>
</label>&nbsp;<span class="clsBgMandatory"><?php echo $this->_tpl_vars['LANG']['common_photo_mandatory']; ?>
</span>&nbsp;
                </td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('photo_tags'); ?>
">
                    <input type="text" class="clsTextBox" name="photo_tags" id="photo_tags" value="<?php echo $this->_tpl_vars['myobj']->getFormField('photo_tags'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('photo_tags'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('photo_tags'); ?>

                    <p class="clsFieldComments"><?php echo $this->_tpl_vars['myobj']->photoUpload_tags_msg; ?>
</p>
                    <p class="clsFieldComments"><?php echo $this->_tpl_vars['LANG']['photoupload_tags_msg2']; ?>
</p>
                </td>
            </tr>
        </table>
		 </div>
                <div id="otherUploadOption" class="clsDataTable">
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
                        <p><input type="radio" class="clsCheckRadio clsRadioButtonBorder" name="photo_access_type" id="photo_access_type1" value="Public" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                        <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('photo_access_type','Public'); ?>
 />&nbsp;<label for="photo_access_type1"><?php echo $this->_tpl_vars['LANG']['photoupload_public']; ?>

                        </label><?php echo $this->_tpl_vars['LANG']['photoupload_share_your_photo_world']; ?>
</p>
                        <p><input type="radio" class="clsCheckRadio clsRadioButtonBorder" name="photo_access_type" id="photo_access_type2" value="Private" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                        <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('photo_access_type','Private'); ?>
 />&nbsp;<label for="photo_access_type2"><?php echo $this->_tpl_vars['LANG']['photoupload_private']; ?>

                        </label><?php echo $this->_tpl_vars['LANG']['photoupload_only_viewable_by_you']; ?>
</p>
                        <p class="clsSelectHighlightNote clsUploadSharing"><?php echo $this->_tpl_vars['LANG']['photoupload_only_viewable_you_email']; ?>
:</p>
                        <?php echo $this->_tpl_vars['myobj']->populateCheckBoxForRelationList(); ?>

                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('photo_access_type'); ?>

                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('photo_access_type'); ?>

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
                    <input type="radio" class="clsCheckRadio clsRadioButtonBorder" name="allow_comments" id="allow_comments1" value="Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','Yes'); ?>
 />&nbsp;<label for="allow_comments1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
</label>
                    <?php echo $this->_tpl_vars['LANG']['photoupload_allow_comments_world']; ?>
</p>
                    <p><input type="radio" class="clsCheckRadio clsRadioButtonBorder" name="allow_comments" id="allow_comments2" value="No" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','No'); ?>
 />&nbsp;<label for="allow_comments2" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
</label>&nbsp;<?php echo $this->_tpl_vars['LANG']['photoupload_disallow_comments']; ?>
        </p>
                    <p><input type="radio" class="clsCheckRadio clsRadioButtonBorder" name="allow_comments" id="allow_comments3" value="Kinda" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','Kinda'); ?>
 />&nbsp;<label for="allow_comments3" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_kinda']; ?>
</label>
                    <?php echo $this->_tpl_vars['LANG']['photoupload_approval_comments']; ?>
       	</p>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('allow_comments'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('allow_comments'); ?>
	</td>
                </tr>
                <tr id="selDateLocationRow" class="clsAllowOptions">
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('allow_ratings'); ?>
">
                        <label for="allow_ratings1"><?php echo $this->_tpl_vars['LANG']['photoupload_allow_ratings']; ?>
</label>		</td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('allow_ratings'); ?>
">
                    <p><input type="radio" class="clsCheckRadio clsRadioButtonBorder" name="allow_ratings" id="allow_ratings1" value="Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_ratings','Yes'); ?>
 />&nbsp;<label for="allow_ratings1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
</label>
                    <?php echo $this->_tpl_vars['LANG']['photoupload_allow_ratings_world']; ?>
</p>
                    <p><input type="radio" class="clsCheckRadio clsRadioButtonBorder" name="allow_ratings" id="allow_ratings2" value="No" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_ratings','No'); ?>
 />&nbsp;<label for="allow_ratings2" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
</label>&nbsp;<?php echo $this->_tpl_vars['LANG']['photoupload_disallow_ratings']; ?>
             </p>
                    <p id="selDisableNote" class="clsUploadSharing"><?php echo $this->_tpl_vars['LANG']['photoupload_disallow_ratings_note']; ?>
</p>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('allow_ratings'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('allow_ratings'); ?>

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
                    <div class="clsOverflow clsManageCommentsBtn">
                        <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" class="clsSubmitButton clsphotoUploadButton" name="upload_photo" id="upload_photo" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['photoupload_submit']; ?>
" />
                        </span></p>
                    </div>
                <?php else: ?>
                    <div class="clsOverflow clsManageCommentsBtn">
                         <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" name="upload_photo" id="upload_photo" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['photoupload_update']; ?>
" /></span></p>
                         <p class="clsDeleteButton-l"><span class="clsDeleteButton-r"><input type="button" onClick="javascript:window.location='<?php echo (isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:getUrl('photolist','?pg=myphotos','myphotos/','','photo')); ?>'"class="clsphotoUploadButton" name="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['photoupload_cancel']; ?>
" /></span></p>
                     </div>
                <?php endif; ?>
        	</div>
    	</div>
  	</form>
<?php endif; ?>


</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'photomain_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>