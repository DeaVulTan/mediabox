<?php /* Smarty version 2.6.18, created on 2012-01-05 23:07:59
         compiled from musicDefaultSettings.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'musicDefaultSettings.tpl', 29, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selMusicUpload" class="clsMusicUploadPage clsMusicDefaultSetting">
	<div class="clsOverflow">
	<div class="clsFloatLeft">
        <h3 class="clsH3Heading clsMusicDefaltSettingHead">
            <?php echo $this->_tpl_vars['LANG']['musicupload_default_settings']; ?>

       </h3>
    </div>

<div class="clsAudioListMenu clsFloatRight">
	<ul>
		<li id="selDefaultSettings" class="<?php echo $this->_tpl_vars['default_class']; ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/musicDefaultSettings.php" title="<?php echo $this->_tpl_vars['LANG']['musicupload_default_settings']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['musicupload_default_settings']; ?>
</span></a></li>
 <?php if ($this->_tpl_vars['CFG']['admin']['musics']['music_artist_feature']): ?>
		<li id="selArtistDefaultSettings" class="<?php echo $this->_tpl_vars['artist_class']; ?>
"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/musicDefaultSettings.php?page=artist" title="<?php echo $this->_tpl_vars['LANG']['musicupload_artist_promo_default_settings']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['musicupload_artist_promo_default_settings']; ?>
</span></a></li>

<?php endif; ?>
	</ul>
</div>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_music_default_form')): ?>
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
    <div class="clsMusicDetailHdMain clsOverflow">


    <?php if (! $this->_tpl_vars['myobj']->chkIsEditMode()): ?>
         <?php endif; ?>

    </div>
        <form name="music_upload_form" id="music_upload_form" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" autocomplete="off" enctype="multipart/form-data">
          <a id="anchor_upload"></a>

<?php if ($this->_tpl_vars['CFG']['admin']['musics']['allowed_usertypes_to_upload_for_sale'] != 'None'): ?>
    <div id="selUploadBlock">

        <div class="">
		<p class="clsStepsTitle"><?php echo $this->_tpl_vars['LANG']['musicuserpaymentsettings_title']; ?>
</p>
		<div class="clsNoteContainerblock">
		<p><?php echo $this->_tpl_vars['LANG']['musicupdatepaymentsettings_note_msg']; ?>
</p>
		<p><?php echo $this->_tpl_vars['LANG']['musicupdatepaymentsettings_note_msg2']; ?>
</p>
		<p><?php echo $this->_tpl_vars['LANG']['musicupdatepaymentsettings_note_msg3']; ?>
</p>
		</div>
		<div class="clsDataTable">
		<table>
		<tr>
			<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('paypal_id'); ?>
">
				<label for="paypal_id"><?php echo $this->_tpl_vars['LANG']['musicuserpaymentsettings_paypal_id']; ?>
</label>&nbsp;
			</td>
			<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('paypal_id'); ?>
">
            	<input type="text" class="clsTextBox" name="paypal_id" id="paypal_id" value="<?php echo $this->_tpl_vars['myobj']->getFormField('paypal_id'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
				<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('paypal_id'); ?>

				<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('paypal_id'); ?>

			</td>
		</tr>
		<tr>
			<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('threshold_amount'); ?>
">
				<label for="threshold_amount"><?php echo $this->_tpl_vars['LANG']['musicuserpaymentsettings_threshold_amount']; ?>
</label>&nbsp;(<?php echo $this->_tpl_vars['CFG']['currency']; ?>
)</label>&nbsp;
			</td>
			<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('threshold_amount'); ?>
">
            	<input type="text" class="clsTextBox" name="threshold_amount" id="threshold_amount" value="<?php echo $this->_tpl_vars['myobj']->getFormField('threshold_amount'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />&nbsp; (<?php echo $this->_tpl_vars['LANG']['musicupdatepaymentsettings_minimum']; ?>
<?php echo $this->_tpl_vars['CFG']['currency']; ?>
<?php echo $this->_tpl_vars['CFG']['admin']['musics']['minimum_threshold_amount']; ?>
)
				<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('threshold_amount'); ?>

				<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('threshold_amount'); ?>

			</td>
		</tr>

	  </table>
		</div>

<?php endif; ?>

        <p class="clsStepsTitle"><?php echo $this->_tpl_vars['LANG']['musicupload_music_file_settings']; ?>
</p>
                  <div class="clsNoteContainerblock">
		<p><?php echo $this->_tpl_vars['LANG']['musicupload_default_note_msg']; ?>
</p>
		</div>
         <div class="clsDataTable">
         <table class="clsMusicDefaltSettingTable">
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
</label>&nbsp;
                </td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('music_category_id'); ?>
">
                <div id="selGeneralCategory" style="display:<?php echo $this->_tpl_vars['myobj']->General; ?>
">
                    <select name="music_category_id" id="music_category_id" <?php if ($this->_tpl_vars['CFG']['admin']['musics']['sub_category']): ?> onChange="populateMusicSubCategory(this.value)" <?php endif; ?> tabindex="<?php echo smartyTabIndex(array(), $this);?>
" class="clsSelectLarge">
                      <option value=""><?php echo $this->_tpl_vars['LANG']['common_select_option']; ?>
</option>
                      <?php echo $this->_tpl_vars['myobj']->populateMusicCatagory('General'); ?>

                    </select>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('music_category_id'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('musicupload_category_id_general'); ?>

                    <p class="clsSelectNote clsUploadnotesmall"><?php echo $this->_tpl_vars['LANG']['musicupload_select_category']; ?>
</p>
                </div>
                <?php if (isAdultUser ( '' , 'music' ) && $this->_tpl_vars['myobj']->content_filter): ?>
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
			<?php if ($this->_tpl_vars['myobj']->chkIsAllowedForSale()): ?>
			<tr>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('for_sale'); ?>
">
                    <label for="for_sale"><?php echo $this->_tpl_vars['LANG']['musicupload_for_sale']; ?>
</label>&nbsp;
                </td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('for_sale'); ?>
">
                    <input type="radio" name="for_sale" id="for_sale1" value="Yes" onclick="enabledFormFields(Array('music_price', 'preview_start', 'preview_end'));" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
					<?php echo $this->_tpl_vars['myobj']->isCheckedRadio('for_sale','Yes'); ?>
/> &nbsp;<?php echo $this->_tpl_vars['LANG']['musicupload_yes']; ?>
&nbsp;
                    <input type="radio" name="for_sale" id="for_sale2" value="No" onclick="disabledFormFields(Array('music_price', 'preview_start', 'preview_end'));" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
					 <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('for_sale','No'); ?>
/> &nbsp;<?php echo $this->_tpl_vars['LANG']['musicupload_no']; ?>

                </td>
            </tr>
			<tr>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('music_price'); ?>
">
                    <label for="music_tags"><?php echo $this->_tpl_vars['LANG']['musicupload_music_price']; ?>
</label>&nbsp;(<?php echo $this->_tpl_vars['CFG']['currency']; ?>
)
                </td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('music_price'); ?>
">
                    <input type="text" class="clsTextBox" name="music_price" id="music_price" value="<?php echo $this->_tpl_vars['myobj']->getFormField('music_price'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('music_price'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('music_price'); ?>

                </td>
            </tr>
            <?php if (isset ( $this->_tpl_vars['CFG']['admin']['musics']['allow_members_to_choose_the_preview'] ) && $this->_tpl_vars['CFG']['admin']['musics']['allow_members_to_choose_the_preview']): ?>
            <tr>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('preview_start'); ?>
">
                    <label for="preview_start"><?php echo $this->_tpl_vars['LANG']['musicupload_preview_start']; ?>
</label>&nbsp;
                </td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('preview_start'); ?>
">
                    <input type="text" class="clsTextBox" name="preview_start" id="preview_start" value="<?php echo $this->_tpl_vars['myobj']->getFormField('preview_start'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('preview_start'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('preview_start'); ?>

                    <p><?php echo $this->_tpl_vars['LANG']['musicupload_preview_start_time_note_msg']; ?>
</p>
                </td>
            </tr>
            <tr>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('preview_end'); ?>
">
                    <label for="preview_end"><?php echo $this->_tpl_vars['LANG']['musicupload_preview_end']; ?>
</label>&nbsp;
                </td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('preview_end'); ?>
">
                    <input type="text" class="clsTextBox" name="preview_end" id="preview_end" value="<?php echo $this->_tpl_vars['myobj']->getFormField('preview_end'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('preview_end'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('preview_end'); ?>

                </td>
            </tr>
            <?php endif; ?>
            <?php endif; ?>
            <tr>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('music_tags'); ?>
">
                    <label for="music_tags"><?php echo $this->_tpl_vars['LANG']['musicupload_music_tags']; ?>
</label>&nbsp;
                </td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('music_tags'); ?>
">
                    <input type="text" class="clsTextBox" name="music_tags" id="music_tags" value="<?php echo $this->_tpl_vars['myobj']->getFormField('music_tags'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('music_tags'); ?>

                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('music_tags'); ?>

                    <p class="clsUploadnotesmall"><?php echo $this->_tpl_vars['myobj']->musicUpload_tags_msg; ?>
</p>
                    <p class="clsUploadnotesmall"><?php echo $this->_tpl_vars['LANG']['musicupload_tags_msg2']; ?>
</p>
                </td>
            </tr>
        </table>
		 </div>
        		<p class="clsStepsTitle"><?php echo $this->_tpl_vars['LANG']['musicupload_music_other_upload_settings']; ?>
</p>
        <div class="clsDataTable">
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
				  </table>
				  
                <p class="clsStepsTitle"><?php echo $this->_tpl_vars['LANG']['common_sharing']; ?>
</p>
			<table summary="<?php echo $this->_tpl_vars['LANG']['musicupload_tbl_summary']; ?>
" id="selUploadTbl_otherOption" class="clsMusicDefaltSettingTable">
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
                        <p class="clsUploadnotesmall"><?php echo $this->_tpl_vars['LANG']['musicupload_only_viewable_you_email_default']; ?>
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
                    <p id="selDisableNote" class="clsUploadnotesmall"><?php echo $this->_tpl_vars['LANG']['musicupload_disallow_ratings_note']; ?>
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
                    <p id="selLyricsNote" class="clsUploadnotesmall"><?php echo $this->_tpl_vars['LANG']['musicupload_lyrics_note']; ?>
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
		</div>
        </form>
    </div>
		<?php if ($this->_tpl_vars['myobj']->getFormField('for_sale') == 'No'): ?>
            <?php echo '
	            <script type="text/javascript">
					disabledFormFields(Array(\'music_price\', \'preview_start\', \'preview_end\'));
				</script>
            '; ?>

        <?php endif; ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_music_artist_default_form')): ?>
<div>
		<form name="music_upload_form" id="music_upload_form" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" autocomplete="off" enctype="multipart/form-data">
		<p class="clsStepsTitle">Promo Settings</p>
		<div class="clsNoteContainerblock">
		<p><?php echo $this->_tpl_vars['LANG']['musicupload_artist_promo_note_msg']; ?>
</p>
		<p><?php echo $this->_tpl_vars['LANG']['musicupload_artist_promo_note_msg2']; ?>
</p>
		</div>
		<div class="clsDataTable clsMarginBtm1px">
		<table>
		<tr>
			<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('artist_promo_file'); ?>
">
				<label for="artist_promo_file"><?php echo $this->_tpl_vars['LANG']['musicartist_promo_image']; ?>
&nbsp;(<?php echo $this->_tpl_vars['myobj']->image_format; ?>
)(<?php echo $this->_tpl_vars['CFG']['admin']['musics']['artist_promo_image_size']; ?>
 KB)</label>&nbsp;
			</td>
			<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('artist_promo_file'); ?>
">
                <input type="file" class="clsFile" accept="music/<?php echo $this->_tpl_vars['myobj']->music_format; ?>
" name="artist_promo_file" id="artist_promo_file" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('artist_promo_file'); ?>

            </td>
		</tr>
		<tr>
			<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('artist_promo_caption'); ?>
">
				<label for="artist_promo_caption"><?php echo $this->_tpl_vars['LANG']['musicartist_promo_caption']; ?>
</label>&nbsp;
			</td>
			<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('artist_promo_caption'); ?>
">
            	<textarea name="artist_promo_caption" id="artist_promo_caption" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('artist_promo_caption'); ?>
</textarea>
				<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('artist_promo_caption'); ?>

			</td>
		</tr>
		<tr>
			<td>
				<!--empty td-->
			</td>
			<td>
				<div class="clsOverflow">
                         <p class="clsSubmitButton-l clsPaddingbm0"><span class="clsSubmitButton-r"><input type="submit" name="upload" id="upload" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['musicupload_update']; ?>
" /></span></p>
                         <p class="clsCancelButton-l clsPaddingbm0"><span class="clsCancelButton-r"><input type="button" onClick="javascript:window.location='<?php echo (isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:getUrl('musiclist','?pg=mymusics','mymusics/','','music')); ?>'"class="clsmusicUploadButton" name="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['musicupload_cancel']; ?>
" /></span></p>
                     </div>
			</td>
		</tr>
		<input type="hidden" name="page" id="page" value="artist" />

	  </table>
	  </div>
        </form>

		<?php if ($this->_tpl_vars['myobj']->getFormField('artist_promo_image')): ?>
			<div class="clsArtistInfoTable">
			  <table>
				<tr>
				  <th colspan="2" class="text clsProfileTitle"><span class="whitetext12">Preview</span></th>
				</tr>
				<tr>
				  <td colspan="2">
				  <div class="clsArtistInfoContainer">
						<div class="clsArtistInfoImage">
							<div class="clsOverflow">
							  <div class="clsThumbImageLink">
								<a href="<?php echo $this->_tpl_vars['artist_info_arr']['memberProfileUrl']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls455x305">
									<img src="<?php echo $this->_tpl_vars['myobj']->getFormField('artist_promo_image'); ?>
" />
								 </a>
							   </div>
						   </div>
						</div>
					</div>
					</td>
				 </tr>
			  </table>
		   </div>
		<?php endif; ?>

		</div>
<?php endif; ?>

</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>