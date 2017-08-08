<?php /* Smarty version 2.6.18, created on 2011-12-24 00:16:25
         compiled from videoUploadPopUp.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'videoUploadPopUp.tpl', 66, false),)), $this); ?>
<div id="selVideoUpload" class="clsVideoUploadPopUpPage">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clsPageHeading">
	<h2>
	    <?php if ($this->_tpl_vars['myobj']->chkIsEditMode()): ?>
        	<?php echo $this->_tpl_vars['LANG']['videoupload_edit_title']; ?>

        <?php else: ?>
         <?php echo $this->_tpl_vars['myobj']->VideoUploadTitle; ?>

         <?php endif; ?>
   </h2>
</div>
	<div id="selLeftNavigation">
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('msg_form_error')): ?>
		<div id="selMsgError">
			<p><?php echo $this->_tpl_vars['myobj']->getCommonErrorMsg(); ?>
</p>
		</div>
     <?php endif; ?>
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('msg_form_success')): ?>
  	   <div id="selMsgSuccess">
	   <p><?php echo $this->_tpl_vars['myobj']->getCommonErrorMsg(); ?>
</p>
       <?php if (! $this->_tpl_vars['myobj']->chkIsEditMode()): ?>
	   <p><?php echo $this->_tpl_vars['myobj']->uploadAnother; ?>
</p>
       <?php endif; ?>
		<?php if (! $this->_tpl_vars['myobj']->chkIsEditMode()): ?>

			<script language="javascript" type="text/javascript">
				//alert("<?php echo $this->_tpl_vars['myobj']->videoupload_msg_success_uploaded; ?>
");
			</script>
         <?php endif; ?>
       </div>
   <?php endif; ?>

<div class="clsOverflow">

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('video_upload_form')): ?>
<div id="selUpload" class="clsDataTable clsNoBorder">
	<?php if ($this->_tpl_vars['myobj']->chkIsEditMode()): ?>
	<form name="video_update_form" id="video_update_form" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
	<div id="selCenterPlainImage">
            	<div id="selImageBorder">
                <div class="clsOverflow">
                    <p class="clsViewThumbImage">
                        <?php if ($this->_tpl_vars['myobj']->getFormField('is_external_embed_video') == 'Yes' && $this->_tpl_vars['myobj']->getFormField('embed_video_image_ext') == ''): ?>
                            <span><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
images/no-video.jpg" alt="<?php echo $this->_tpl_vars['myobj']->getFormField('video_title'); ?>
" <?php echo $this->_tpl_vars['myobj']->disp_image; ?>
 /></span>
                        <?php else: ?>
                            <span><img src="<?php echo $this->_tpl_vars['myobj']->imageSrc; ?>
" alt="<?php echo $this->_tpl_vars['myobj']->getFormField('video_title'); ?>
" <?php echo $this->_tpl_vars['myobj']->disp_image; ?>
 /></span>
                        <?php endif; ?>
                    </p>
                </div>
                <strong><a href="<?php echo $this->_tpl_vars['myobj']->changeThumbUrl; ?>
"><?php echo $this->_tpl_vars['LANG']['videoupload_change_thumbnail']; ?>
</a></strong>
            	</div>
	</div>
	<?php else: ?>
	<form name="video_upload_form" id="video_upload_form" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off"
    enctype="multipart/form-data" onsubmit="return chkMandatoryFields();">
	<?php endif; ?>
    <input type="hidden" name="use_vid" value="<?php echo $this->_tpl_vars['myobj']->getFormField('use_vid'); ?>
" />
	<div id="selUploadBlock">
	<table summary="<?php echo $this->_tpl_vars['LANG']['videoupload_tbl_summary']; ?>
" id="selUploadTbl" class="clsFormTableSection clsUploadBlock clsNoBorder">
	<tr>
		<td class="clsVideoUploadLabel <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('video_album_id'); ?>
">
			<label for="video_album_id"><?php echo $this->_tpl_vars['LANG']['videoupload_video_album_id']; ?>
</label></td>
		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('video_album_id'); ?>
">
		<select name="video_album_id" id="video_album_id" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" class="clsSelectLarge">
			<option value=""><?php echo $this->_tpl_vars['LANG']['videoupload_select_album']; ?>
</option>
			<?php echo $this->_tpl_vars['myobj']->populateVideoAlbums(); ?>

		</select>
            <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('video_album_id'); ?>

	      <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('video_album_id'); ?>

		<?php if (! $this->_tpl_vars['myobj']->chkIsEditMode()): ?>
		<p id="selCreateAlbum"><a href="<?php echo $this->_tpl_vars['myobj']->createAlbumUrl; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['LANG']['videoupload_create_album']; ?>
</a></p>
		<?php endif; ?>    	</td>
	</tr>
	<tr>
		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('video_title'); ?>
">
			<label for="video_title"><?php echo $this->_tpl_vars['LANG']['videoupload_video_title']; ?>
</label>&nbsp;<span class="clsMandatoryFieldIcon"><?php echo $this->_tpl_vars['LANG']['videoupload_important']; ?>
&nbsp;	</span>	</td>
		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('video_title'); ?>
">
			<input type="text" class="clsTextBox" name="video_title" id="video_title" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('video_title'); ?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['admin']['videos']['title_max_length']; ?>
" />
                  <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('video_title'); ?>

            	<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('video_title'); ?>

            </td>
	</tr>
	<tr>
		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('video_caption'); ?>
">
			<label for="video_caption"><?php echo $this->_tpl_vars['LANG']['videoupload_video_caption']; ?>
</label>		</td>
		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('video_caption'); ?>
">
			<textarea name="video_caption" id="video_caption" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('video_caption'); ?>
</textarea>
                  <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('video_caption'); ?>

            	<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('video_caption'); ?>

            </td>
	</tr>
	<tr>
        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('video_tags'); ?>
">
            <label for="video_tags"><?php echo $this->_tpl_vars['LANG']['videoupload_video_tags']; ?>
</label>&nbsp; <span class="clsMandatoryFieldIcon"><?php echo $this->_tpl_vars['LANG']['videoupload_important']; ?>
&nbsp; </span>       </td>
        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('video_tags'); ?>
">
           <p><input type="text" class="clsTextBox" name="video_tags" id="video_tags" value="<?php echo $this->_tpl_vars['myobj']->getFormField('video_tags'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></p>
            <p><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('video_tags'); ?>
</p>
            <p><?php echo $this->_tpl_vars['myobj']->ShowHelpTip('video_tags'); ?>
</p>
            <p><?php echo $this->_tpl_vars['myobj']->videoupload_tags_msg; ?>
</p>
        </td>
	</tr>
    <?php if ($this->_tpl_vars['myobj']->content_filter): ?>
	<tr id="selDateLocationRow" class="clsAllowOptions">
        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('video_category_type'); ?>
">
            <label for="video_category_type"><?php echo $this->_tpl_vars['LANG']['videoupload_video_category_type']; ?>
</label>        </td>
        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('video_category_type'); ?>
">
            <input type="radio" class="clsCheckRadio" name="video_category_type" id="video_category_type1" value="Porn" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('video_category_type','Porn'); ?>
 onclick="document.getElementById('selGeneralCategory').style.display='none';document.getElementById('selPornCategory').style.display='';" />
            &nbsp;<label for="video_category_type1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_porn']; ?>
</label>
            &nbsp;&nbsp;
            <input type="radio" class="clsCheckRadio" name="video_category_type" id="video_category_type2" value="General" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('video_category_type','General'); ?>
 onclick="document.getElementById('selGeneralCategory').style.display='';document.getElementById('selPornCategory').style.display='none';" />
            &nbsp;<label for="video_category_type2" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_general']; ?>
</label>
            <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('video_category_type'); ?>

            <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('video_category_type'); ?>

        </td>
	</tr>
   	<?php endif; ?>
	<tr id="selCategoryBlock">
        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('video_category_id'); ?>
">
            <label for="video_category_id_general"><?php echo $this->_tpl_vars['LANG']['videoupload_video_category_id']; ?>
</label>&nbsp; <span class="clsMandatoryFieldIcon"><?php echo $this->_tpl_vars['LANG']['videoupload_important']; ?>
&nbsp;</span>
        </td>
        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('video_category_id'); ?>
">
        <div id="selGeneralCategory" style="display:<?php echo $this->_tpl_vars['myobj']->General; ?>
">
        	<select name="video_category_id_general" id="video_category_id_general" <?php if ($this->_tpl_vars['CFG']['admin']['videos']['sub_category']): ?> onChange="populateSubCategory(this.value)" <?php endif; ?> tabindex="<?php echo smartyTabIndex(array(), $this);?>
" class="clsSelectLarge">
              <option value=""><?php echo $this->_tpl_vars['LANG']['common_select_option']; ?>
</option>
            <?php echo $this->_tpl_vars['myobj']->populateVideoCatagory('General'); ?>

            </select>
			<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('video_category_id'); ?>

            <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('video_category_id_general'); ?>

            <p class="clsSelectNote"><?php echo $this->_tpl_vars['LANG']['videoupload_select_a_category']; ?>
</p>
        </div>
        <?php if ($this->_tpl_vars['myobj']->content_filter && isAdultUser ( 'video' )): ?>
        <div id="selPornCategory" style="display:<?php echo $this->_tpl_vars['myobj']->Porn; ?>
">
                	<select name="video_category_id_porn" id="video_category_id_porn" <?php if ($this->_tpl_vars['CFG']['admin']['videos']['sub_category']): ?> onChange="populateSubCategory(this.value)" <?php endif; ?> tabindex="<?php echo smartyTabIndex(array(), $this);?>
" class="clsSelectLarge">
                    <option value=""><?php echo $this->_tpl_vars['LANG']['common_select_option']; ?>
</option>
		            <?php echo $this->_tpl_vars['myobj']->populateVideoCatagory('Porn'); ?>

            </select>
            <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('video_category_id'); ?>

		    <p class="clsSelectNote"><?php echo $this->_tpl_vars['LANG']['videoupload_select_a_category']; ?>
</p>
        </div>
        <?php endif; ?>
        </td>
	</tr>
    <?php if ($this->_tpl_vars['CFG']['admin']['videos']['sub_category']): ?>
	<tr id="selDateLocationRow">
		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('video_sub_category_id'); ?>
">
		<label for="video_sub_category_id"><?php echo $this->_tpl_vars['LANG']['videoupload_video_sub_category_id']; ?>
</label>
            </td>
		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('video_sub_category_id'); ?>
">
              <div id="selSubCategoryBox">
              <select name="video_sub_category_id" id="video_sub_category_id" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                  <option value=""><?php echo $this->_tpl_vars['LANG']['common_select_option']; ?>
</option>
              </select>
		</div>
              <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('video_sub_category_id'); ?>

	        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('video_sub_category_id'); ?>

        	</td>
	</tr>
    <?php endif; ?>
    </table>
    <div id="videosThumsDetailsLinks" class="clsVideoRight clsShowHideFilter">
    <a href="javascript:void(0)" id="show_link" class="clsShowFilterSearch" onclick="divShowHide('otherUploadOption', 'show_link', 'hide_link')"><span><?php echo $this->_tpl_vars['LANG']['videoupload_show_other_option']; ?>
</span></a>
                       		<a href="javascript:void(0)" id="hide_link" style="display:none;" class="clsHideFilterSearch"  onclick="divShowHide('otherUploadOption', 'show_link', 'hide_link')"><span><?php echo $this->_tpl_vars['LANG']['videoupload_hide_other_option']; ?>
</span></a>
                        </div>
        <div id="otherUploadOption" style="<?php echo $this->_tpl_vars['myobj']->other_upload_option_display; ?>
">
    <table summary="<?php echo $this->_tpl_vars['LANG']['videoupload_tbl_summary']; ?>
" id="selUploadTbl_otherOption" class="clsFormTableSection clsUploadBlock clsNoBorder">
   <tr>
        <th class="clsVideoUploadLabel"><?php echo $this->_tpl_vars['LANG']['videoupload_search_optmization']; ?>
</th>
        <th>&nbsp;</th>
    </tr>
    <tr class="clsAllowOptions">
	  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('video_page_title'); ?>
">
      	<label for="video_page_title"><?php echo $this->_tpl_vars['LANG']['videoupload_page_title']; ?>
</label>
      </td>
	  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('video_page_title'); ?>
">
      	<input name="video_page_title" id="video_page_title" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('video_page_title'); ?>
" class="clsTextBox" maxlength="<?php echo $this->_tpl_vars['CFG']['fieldsize']['video_page_title']['max']; ?>
" />
            <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('video_page_title'); ?>

        	<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('video_page_title'); ?>

        </td>
	  </tr>
      <tr class="clsAllowOptions">
	  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('video_meta_keyword'); ?>
">
      	<label for="video_meta_keyword"><?php echo $this->_tpl_vars['LANG']['videoupload_meta_keywords']; ?>
</label>
        </td>
	  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('video_meta_keyword'); ?>
">
      	<textarea name="video_meta_keyword" id="video_meta_keyword" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('video_meta_keyword'); ?>
</textarea>
            <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('video_meta_keyword'); ?>

        	<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('video_meta_keyword'); ?>

        </td>
	  </tr>
      <tr class="clsAllowOptions">
	  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('video_meta_description'); ?>
">
      	<label for="video_meta_description"><?php echo $this->_tpl_vars['LANG']['videoupload_meta_description']; ?>
</label>
        </td>
	  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('video_meta_description'); ?>
">
      	<textarea name="video_meta_description" id="video_meta_description" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('video_meta_description'); ?>
</textarea>
            <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('video_meta_description'); ?>

        	<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('video_meta_description'); ?>

        </td>
	  </tr>
    <tr>
        <th class="clsVideoUploadLabel"><?php echo $this->_tpl_vars['LANG']['videoupload_region_language']; ?>
</th>
        <th>&nbsp;</th>
    </tr>
    <tr class="clsAllowOptions">
	  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('allow_embed'); ?>
">
      	<label for="video_country"><?php echo $this->_tpl_vars['LANG']['videoupload_country']; ?>
</label>
      </td>
	  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('allow_embed'); ?>
">
      	<select name="video_country" id="video_country" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
              <option value="0"><?php echo $this->_tpl_vars['LANG']['videoupload_sel_country']; ?>
</option>
                  <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->LANG_COUNTRY_ARR,$this->_tpl_vars['myobj']->getFormField('video_country')); ?>

              </select>
            <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('video_country'); ?>

        </td>
	  </tr>
	<tr class="clsAllowOptions">
	  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('allow_embed'); ?>
">
      	<label for="video_language"><?php echo $this->_tpl_vars['LANG']['videoupload_language']; ?>
</label>
      </td>
	  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('allow_embed'); ?>
">
      	<select name="video_language" id="video_language"  tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
              <option value="0"><?php echo $this->_tpl_vars['LANG']['videoupload_sel_language']; ?>
</option>
                  <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->LANG_LANGUAGE_ARR,$this->_tpl_vars['myobj']->getFormField('video_language')); ?>

              </select>
            <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('video_language'); ?>

        </td>
	  </tr>
	<tr>
        <th><?php echo $this->_tpl_vars['LANG']['common_sharing']; ?>
</th>
        <th>&nbsp;</th>
    </tr>
    <tr id="selDateLocationRow">
        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('video_access_type'); ?>
">
            <label for="video_access_type1"><?php echo $this->_tpl_vars['LANG']['videoupload_video_access_type']; ?>
</label>        </td>
        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('video_access_type'); ?>
">
            <p><input type="radio" class="clsCheckRadio" name="video_access_type" id="video_access_type1" value="Public" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('video_access_type','Public'); ?>
 />&nbsp;<label for="video_access_type1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['videoupload_public']; ?>

            </label><?php echo $this->_tpl_vars['LANG']['videoupload_share_your_video_world']; ?>
</p>
            <p><input type="radio" class="clsCheckRadio" name="video_access_type" id="video_access_type2" value="Private" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('video_access_type','Private'); ?>
 />&nbsp;<label for="video_access_type2" class="clsBold"><?php echo $this->_tpl_vars['LANG']['videoupload_private']; ?>

            </label><?php echo $this->_tpl_vars['LANG']['videoupload_only_viewable_you']; ?>
</p>
            <p class="clsSelectHighlightNote"><?php echo $this->_tpl_vars['LANG']['videoupload_only_viewable_you_email']; ?>
</p>
            <br /><?php echo $this->_tpl_vars['myobj']->populateCheckBoxForRelationList(); ?>

		<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('video_access_type'); ?>

            <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('video_access_type'); ?>

         </td>
	</tr>
	<tr id="selDateLocationRow" class="clsAllowOptions">
        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('allow_comments'); ?>
">
            <label for="allow_comments1"><?php echo $this->_tpl_vars['LANG']['videoupload_allow_comments']; ?>
</label>        </td>
        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('allow_comments'); ?>
">
		<p>
        <input type="radio" class="clsCheckRadio" name="allow_comments" id="allow_comments1" value="Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','Yes'); ?>
 />&nbsp;	<label for="allow_comments1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
</label>
        <?php echo $this->_tpl_vars['LANG']['videoupload_allow_comments_world']; ?>
</p>
		<p><input type="radio" class="clsCheckRadio" name="allow_comments" id="allow_comments2" value="No" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','No'); ?>
 />&nbsp;<label for="allow_comments2" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
</label>&nbsp;<?php echo $this->_tpl_vars['LANG']['videoupload_disallow_comments']; ?>
        </p>
		<p><input type="radio" class="clsCheckRadio" name="allow_comments" id="allow_comments3" value="Kinda" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','Kinda'); ?>
 />&nbsp;<label for="allow_comments3" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_kinda']; ?>
</label>
        <?php echo $this->_tpl_vars['LANG']['videoupload_approval_comments']; ?>
       	</p>
        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('allow_comments'); ?>

        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('allow_comments'); ?>

        </td>
    </tr>
    <tr id="selDateLocationRow" class="clsAllowOptions">
        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('allow_ratings'); ?>
">
        	<label for="allow_ratings"><?php echo $this->_tpl_vars['LANG']['videoupload_allow_ratings']; ?>
</label>		</td>
		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('allow_ratings'); ?>
">
		<p><input type="radio" class="clsCheckRadio" name="allow_ratings" id="allow_ratings1" value="Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_ratings','Yes'); ?>
 />&nbsp;<label for="allow_ratings1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
</label>
        	<?php echo $this->_tpl_vars['LANG']['videoupload_allow_ratings_world']; ?>
</p>
		<p><input type="radio" class="clsCheckRadio" name="allow_ratings" id="allow_ratings2" value="No" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_ratings','No'); ?>
 />&nbsp;<label for="allow_ratings2" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
</label>&nbsp;<?php echo $this->_tpl_vars['LANG']['videoupload_disallow_ratings']; ?>
</p>
		<p id="selDisableNote"><?php echo $this->_tpl_vars['LANG']['videoupload_disallow_ratings1']; ?>
</p>
	      <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('allow_ratings'); ?>

            <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('allow_ratings'); ?>

        </td>
   	</tr>
	<tr id="selDateLocationRow" class="clsAllowOptions">
   		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('allow_embed'); ?>
">
			<label for="allow_embed1"><?php echo $this->_tpl_vars['LANG']['videoupload_allow_embed']; ?>
</label>		</td>
		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('allow_embed'); ?>
">
			<p><input type="radio" class="clsCheckRadio" name="allow_embed" id="allow_embed1" value="Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_embed','Yes'); ?>
 />&nbsp;<label for="allow_embed1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['videoupload_enabled']; ?>
</label>
            <?php echo $this->_tpl_vars['LANG']['videoupload_allow_embed_external']; ?>
</p>
			<p><input type="radio" class="clsCheckRadio" name="allow_embed" id="allow_embed2" value="No" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_embed','No'); ?>
 />&nbsp;<label for="allow_embed2" class="clsBold"><?php echo $this->_tpl_vars['LANG']['videoupload_disabled']; ?>
</label>
            <?php echo $this->_tpl_vars['LANG']['videoupload_disallow_embed_external']; ?>
</p>
		<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('allow_embed'); ?>

            <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('allow_embed'); ?>

            </td>
	</tr>
	<tr class="clsAllowOptions">
	  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('allow_response'); ?>
">
	        <label for="allow_response">
        <?php echo $this->_tpl_vars['LANG']['videoupload_allow_response']; ?>
</label>
      </td>
	  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('allow_response'); ?>
">
    	<p>
            <input type="radio" class="clsCheckRadio" name="allow_response" id="allow_response1" value="Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_response','Yes'); ?>
 />&nbsp;
            <label for="allow_ratings1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
</label>
            <?php echo $this->_tpl_vars['LANG']['videoupload_allow_response_world']; ?>

        </p>
        <p>
            <input type="radio" class="clsCheckRadio" name="allow_response" id="allow_response2" value="No" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_response','No'); ?>
 />&nbsp;
            <label for="allow_ratings1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
</label>
            <?php echo $this->_tpl_vars['LANG']['videoupload_notallow_response_world']; ?>

        </p>
        <p>
            <input type="radio" class="clsCheckRadio" name="allow_response" id="allow_response3" value="Kinda" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_response','Kinda'); ?>
 />&nbsp;
            <label for="allow_ratings1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_kinda']; ?>
</label>
            <?php echo $this->_tpl_vars['LANG']['videoupload_kinda_response_world']; ?>

        </p>
        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('allow_response'); ?>

      </td>
	  </tr>

	</table>
    </div>
    <table summary="<?php echo $this->_tpl_vars['LANG']['videoupload_tbl_summary']; ?>
" id="selUploadTbl_otherOption" class="clsFormTableSection clsUploadBlock clsNoBorder">
    <tr id="selDateLocationRow">
    	<td class="clsVideoUploadLabel"></td>
		<td class="clsAdminSubmitLeft clsBrowseUploadButton">
                        <?php if (! $this->_tpl_vars['myobj']->chkIsEditMode()): ?>
            	<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsBold" name="upload_video_file" id="upload_video_file" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
            value="<?php echo $this->_tpl_vars['LANG']['videoupload_upload_video_file']; ?>
" /></div></div>
            <?php else: ?>
            			 	<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsVideoUploadButton" name="update" id="update" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['videoupload_update']; ?>
" /></div></div>
			 	<div class="clsCancelMargin"><div class="clsCancelLeft"><div class="clsCancelRight"><input type="button" onClick="javascript:window.location='<?php echo (isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:getUrl('videolist','?pg=myvideos','myvideos/','','video')); ?>'"class="clsVideoUploadButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['videoupload_cancel']; ?>
" /></div></div></div>
            <?php endif; ?>		</td>
    </tr>
    </table>
	</div>
	</form>
	<?php if (! $this->_tpl_vars['myobj']->chkIsEditMode()): ?>
	<div id="selTimer">
	</div>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('video_upload_form_file')): ?>
    <div id="selVideoUploadRules" class="clsVideoUploadRules">
      <p></p>
    </div>
	<div class="clsNoteInfoLeft">
		<div class="clsNoteInfoRight">
			<div class="clsNoteInfoCenter">
		 		<div class="clsUploadNotes">NOTES:</div><div class="clsUploadInfo">[<?php echo $this->_tpl_vars['CFG']['admin']['videos']['max_size']; ?>
 MB]&nbsp;&nbsp;&nbsp;&nbsp;[<?php echo $this->_tpl_vars['myobj']->imageFormat; ?>
]</div>
		 	</div>
		</div>	
	</div>
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'otherupload_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div class="clsUploadSection" id="selUploadFlash" style="display:<?php echo $this->_tpl_vars['myobj']->selUploadFlash_display; ?>
">
	<form name="video_upload_form" id="video_upload_form" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
?upload=<?php echo $this->_tpl_vars['myobj']->session_variable; ?>
"
    autocomplete="off" enctype="multipart/form-data" onsubmit="return chkMandatoryFields();">
	<!--p>
    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
    codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="400" height="155" id="fileuploader"
    align="middle">
        <param name="allowScriptAccess" value="sameDomain" />
        <param name="movie" value="<?php echo $this->_tpl_vars['myobj']->swf_path; ?>
?config=<?php echo $this->_tpl_vars['myobj']->config_path; ?>
" />
        <param name="quality" value="high" />
        <param name="bgcolor" value="#ffffff" />
        <embed src="<?php echo $this->_tpl_vars['myobj']->swf_path; ?>
?config=<?php echo $this->_tpl_vars['myobj']->config_path; ?>
" quality="high" bgcolor="#ffffff" width="400" height="155" name="fileuploader"
        align="middle" allowDomain="always" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"
        pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="transparent"/>
	</object>

	</p->
    <div>
        <div class="fieldset flash" id="fsUploadProgress1">
            <span class="legend"></span>
        </div>
        <div style="padding-left: 5px;">
            <span id="spanButtonPlaceholder1"></span>
            <input id="btnCancel1" type="button" value="<?php echo $this->_tpl_vars['LANG']['videoupload_cancel']; ?>
" onclick="cancelQueue(multi_upload);" disabled="disabled" style="margin-left: 2px; height: 22px; font-size: 8pt;" />
            <input type="hidden" name="flv_upload_type" value="MultiUpload" />
            <br />
        </div>
    </div><br />-->
    <div>
    <table class="clsBrowseFileTable"><tr>
        <td><?php echo $this->_tpl_vars['LANG']['videoupload_select_file']; ?>
: <input type="text" id="txtFileName" disabled="true" class="clsTextBox" /></td>
        <td class="clsPlaceHolderButton"><p class="clsSubmitButton-l clsAdminUploadButton"><span class="clsSubmitButton-r"><span id="spanButtonPlaceholder1"></span></span></p></td>       
    </tr></table>
    </div>
    <div class="flash" id="fsUploadProgress">
        <!-- This is where the file progress gets shown.  SWFUpload doesn't update the UI directly.
                    The Handlers (in handlers.js) process the upload events and make the UI updates -->
    </div>


	<div class="clsOverflow clsBrowseUploadButton">
    	<div class="clsSubmitLeft">
        	<div class="clsSubmitRight">
			<input type="button" value="<?php echo $this->_tpl_vars['LANG']['videoupload_upload_video']; ?>
" id="btnSubmit" name="video_upload_flash" class="clsSubmitButton"/>
		    <!--<input class="clsVideoUploadButton" type="Button" Name="Upload" id="Upload" Value="<?php echo $this->_tpl_vars['LANG']['videoupload_upload_video']; ?>
" onClick="onClickThis()"/>-->
		    </div>
        </div><p class="clsPaddingTop5"><a href="javascript:void(0);" onclick="return showNormalUpload()"><?php echo $this->_tpl_vars['LANG']['common_click_here']; ?>
</a> <?php echo $this->_tpl_vars['LANG']['videoupload_proble_uploader']; ?>
</p>
   </div>
    <input type="hidden" name="file_extern" id="file_extern" />
    <input type="hidden" name="upload_video" id="upload_video" />
	</form>
	
	</div>
	<div id="selUploadNormal" class="clsUploadSection" style="display:<?php echo $this->_tpl_vars['myobj']->selUploadNormal_display; ?>
">
	<form name="video_upload_form_normal" id="video_upload_form_normal" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
?upload=<?php echo $this->_tpl_vars['myobj']->session_variable; ?>
"
    autocomplete="off" enctype="multipart/form-data" onsubmit="return chkMandatoryFields();">
	<div class="clsDataTable">
    <table summary="<?php echo $this->_tpl_vars['LANG']['videoupload_tbl_summary']; ?>
" id="selUploadTbl" class="clsFormTableSection clsUploadBlock">
		<tr class="clsVideoUploadFile">
			<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('video_file'); ?>
">
				<label for="video_file"><?php echo $this->_tpl_vars['LANG']['videoupload_video_file']; ?>
</label>&nbsp;<?php echo $this->_tpl_vars['LANG']['videoupload_important']; ?>
&nbsp;
				<input type="hidden" name="max_file_size" value="<?php echo $this->_tpl_vars['CFG']['admin']['videos']['max_size']*1024*1024; ?>
">
                <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('video_file'); ?>

			</td>
		    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('video_file'); ?>
">
				<input type="file" class="clsFileBox" accept="video/<?php echo $this->_tpl_vars['myobj']->changeArrayToCommaSeparator($this->_tpl_vars['CFG']['admin']['videos']['format_arr']); ?>
" name="video_file" id="video_file" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('video_file'); ?>

			</td>
		</tr>
		<tr>        	
			<td colspan="2" class="clsBrowseUploadButton">
				<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="upload_video_normal" id="upload_video_normal" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                value="<?php echo $this->_tpl_vars['LANG']['videoupload_upload_video']; ?>
" /></div></div>
				<p class="clsPaddingTop5"><a href="javascript:void(0);" onclick="return showFlashUpload()"><?php echo $this->_tpl_vars['LANG']['common_click_here']; ?>
</a> <?php echo $this->_tpl_vars['LANG']['videoupload_show_flash_uploader']; ?>
</p>
	        </td>
    	</tr>
	</table>
    </div>
	</form>    
	</div>
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'otherupload_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php if (! $this->_tpl_vars['myobj']->chkIsEditMode()): ?>
<script>
createJSFCommunicatorObject(thisMovie("fileuploader"));
</script>
<?php endif; ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('video_upload_form_external')): ?>
<div class="clsUploadSection">
	<form name="video_upload_form" id="video_upload_form" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
?upload=<?php echo $this->_tpl_vars['myobj']->session_variable; ?>
"
    autocomplete="off" onsubmit="return chkMandatoryFields();">
	<div class="clsDataTable">
    <table summary="<?php echo $this->_tpl_vars['LANG']['videoupload_tbl_summary']; ?>
" id="selUploadTbl" class="clsFormTableSection clsUploadBlock">
	    <tr class="clsVideoUploadFile">
    	    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('externalsite_viewvideo_url'); ?>
">
	            <label for="video_external_url"><?php echo $this->_tpl_vars['LANG']['videoupload_externalsite_viewvideo_url']; ?>
</label>&nbsp;<?php echo $this->_tpl_vars['LANG']['videoupload_important']; ?>
&nbsp;
        	</td>
   			<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('externalsite_viewvideo_url'); ?>
">
				<input type="text" class="clsTextBox" name="externalsite_viewvideo_url" id="externalsite_viewvideo_url" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('externalsite_viewvideo_url'); ?>
" />
                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('externalsite_viewvideo_url'); ?>

	                <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('externalsite_viewvideo_url'); ?>

			</td>
	    </tr>
		<tr>
        	<td></td>
			<td class="clsBrowseUploadButton">
				<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsBold" name="upload_video" id="upload_video" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                value="<?php echo $this->_tpl_vars['LANG']['videoupload_externalvideourl']; ?>
" /></div></div>
			</td>
		</tr>
	</table>
    </div>
	</form>
</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('video_upload_form_capture')): ?>
<div class="clsUploadSection">

	<form name="video_upload_form" id="video_upload_form" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
?upload=<?php echo $this->_tpl_vars['myobj']->session_variable; ?>
" autocomplete="off" >
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
    codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="460" height="390" id="QuickRecorder"
    align="middle">
        <param name="allowScriptAccess" value="sameDomain" />
        <param name="movie" value="<?php echo $this->_tpl_vars['myobj']->quick_recorder_path; ?>
" />
        <param name="quality" value="high" />
        <param name="bgcolor" value="#ffffff" />
        <embed src="<?php echo $this->_tpl_vars['myobj']->quick_recorder_path; ?>
" quality="high" bgcolor="#ffffff" width="460" height="390" name="QuickRecorder"
        align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
    </form>
</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('upload_video_embed_code_form')): ?>
<div class="clsUploadSection">
	<form name="video_upload_form" id="video_upload_form"  method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
?upload=<?php echo $this->_tpl_vars['myobj']->session_variable; ?>
"
    autocomplete="off" enctype="multipart/form-data" onsubmit="return chkMandatoryFields();">
	<div class="clsDataTable">
    <table summary="<?php echo $this->_tpl_vars['LANG']['videoupload_tbl_summary']; ?>
" id="selUploadTbl" class="clsFormTableSection clsUploadBlock">
		<tr class="clsVideoUploadFile">
	    	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('video_external_embed_code'); ?>
">
				<label for="video_external_embed_code"><?php echo $this->_tpl_vars['LANG']['videoupload_upload_external_embed_code']; ?>
</label>&nbsp;<?php echo $this->_tpl_vars['LANG']['videoupload_important']; ?>
&nbsp;<br />
                <?php echo $this->_tpl_vars['myobj']->embededcode_optimum_dimension; ?>

			</td>
	   		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('video_external_embed_code'); ?>
">
	       		<textarea name="video_external_embed_code" id="video_external_embed_code" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" cols="50" rows="5"><?php echo $this->_tpl_vars['myobj']->getFormField('video_external_embed_code'); ?>
</textarea>
                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('video_external_embed_code'); ?>

                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('video_external_embed_code'); ?>

			</td>
	    </tr>
		<tr>
	    	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('embed_video_image'); ?>
">
	        	<label for="embed_video_image"><?php echo $this->_tpl_vars['LANG']['videoupload_embed_video_image']; ?>
 &nbsp;<?php echo $this->_tpl_vars['LANG']['videoupload_important']; ?>
&nbsp;<br /> <?php echo $this->_tpl_vars['LANG']['upload_image_type']; ?>
(<?php echo $this->_tpl_vars['myobj']->imageFormat; ?>
)</label>
            </td>
	        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('embed_video_image'); ?>
">
	        	<input type="file" class="clsFileBox" name="embed_video_image" id="embed_video_image" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" accept="<?php echo $this->_tpl_vars['myobj']->imageFormat; ?>
"/>
                  <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('embed_video_image'); ?>

                  <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('embed_video_image'); ?>

	        </td>
	    </tr>
        <tr>
	    	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('embed_playing_time'); ?>
">
	        	<label for="embed_playing_time"><?php echo $this->_tpl_vars['LANG']['videoupload_embed_playingtime']; ?>
 &nbsp;<?php echo $this->_tpl_vars['LANG']['videoupload_important']; ?>
&nbsp;</label>
            </td>
	        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('embed_playing_time'); ?>
">
	        	<input type="text" class="clsFileBox" name="embed_playing_time" id="embed_playing_time" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('embed_playing_time'); ?>
"/>
                  <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('embed_playing_time'); ?>

                  <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('embed_playing_time','embed_playing_time'); ?>

	        </td>
	    </tr>
		<tr>
        	<td></td>
			<td class="clsBrowseUploadButton">
				<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsVideoUploadButton clsBold" name="upload_video_embed_code" id="upload_video_embed_code" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                value="<?php echo $this->_tpl_vars['LANG']['videoupload_upload_video']; ?>
" /></div></div>
			</td>
		</tr>
	</table>
    </div>
	</form>
</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['myobj']->upload_video_type): ?>
<div class="clsOtherUploadOptionsBg">
	<table class="clsAdminSwitchoverTable clsOtherUploadedVideos">
		<tr>
			<th><?php echo $this->_tpl_vars['LANG']['other_video_upload_options']; ?>
</th>
		</tr>
		<tr>
			<td>
				<div class="clsSwitchOver clsOverflow clsMarginTop5 clsBrowseUploadButton">
					<form name="switch_over_form" id="switch_over_form" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
?upload=<?php echo $this->_tpl_vars['myobj']->session_variable; ?>
"
					autocomplete="off">
					<?php if ($this->_tpl_vars['myobj']->upload_video_type != 'Normal'): ?>
					<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton clsBold" name="upload_video_file" id="upload_video_file" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['videoupload_upload_video_file']; ?>
" /></div></div>
					<?php endif; ?>
					<?php if ($this->_tpl_vars['myobj']->upload_video_type != 'externalsitevideourl' && $this->_tpl_vars['CFG']['admin']['upload_youtube_flv']): ?>
					<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton clsBold" name="upload_video_external" id="upload_video_external" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['videoupload_upload_external']; ?>
" /></div></div>
					<?php endif; ?>
					<?php if ($this->_tpl_vars['CFG']['admin']['upload_capture_flv'] && $this->_tpl_vars['myobj']->upload_video_type != 'Capture'): ?>
					<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton clsBold" name="upload_video_capture" id="upload_video_capture" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['videoupload_upload_capture']; ?>
" /></div></div>
					<?php endif; ?>
					<?php if ($this->_tpl_vars['CFG']['admin']['upload_video_embed_code'] && $this->_tpl_vars['myobj']->upload_video_type != 'embedcode'): ?>
					<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton clsBold" name="upload_video_embed_code" id="upload_video_embed_code" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['videoupload_upload_external_embed_code']; ?>
" /></div></div>
					<?php endif; ?>
					<div class="clsCancelLeft"><div class="clsCancelRight"><input type="button"  class="clsSubmitButton clsBold" onClick="javascript:window.location='<?php  echo getUrl('videolist','?pg=myvideos','myvideos/','','video'); ?>'" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['videoupload_cancel']; ?>
" /></div></div>
				
					<input type="hidden" name="switch_over" id="switch_over" value="switch_over" />
					</form>
				</div>
			</td>
		</tr>
	</table>
</div>	
<?php endif; ?>

</div>
	</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>