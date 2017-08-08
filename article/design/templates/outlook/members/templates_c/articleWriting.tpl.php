<?php /* Smarty version 2.6.18, created on 2012-01-04 19:24:17
         compiled from articleWriting.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'articleWriting.tpl', 21, false),array('modifier', 'nl2br', 'articleWriting.tpl', 103, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selArticleWriting" class="clsPageHeading">
	<div class="clsOverflow"><div class="clsArticleListHeading"><h2><?php if ($this->_tpl_vars['myobj']->chkIsEditMode()): ?> <?php echo $this->_tpl_vars['LANG']['articlewriting_edit_title']; ?>
 <?php else: ?> <?php echo $this->_tpl_vars['LANG']['articlewriting_title']; ?>
 <?php endif; ?></h2></div>
	<?php if ($this->_tpl_vars['myobj']->chkIsEditMode()): ?><div class="clsArticleListHeadingRight"><h4><a href="<?php echo $this->_tpl_vars['myobj']->article_writing_form['manage_attachments_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['articlewriting_manage_attachments']; ?>
</a></h4></div><?php endif; ?></div>
  		<div id="selLeftNavigation">
    	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

  		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('article_writing_form')): ?>
			<div id="selWriting">
				<?php if ($this->_tpl_vars['myobj']->chkIsEditMode()): ?>
					<form name="article_writing_form" id="article_writing_form" method="post" action="<?php echo $this->_tpl_vars['myobj']->article_writing_form['form_action']; ?>
" enctype="multipart/form-data" autocomplete="off">
					<input type="hidden" name="article_status" id="article_status" value="<?php echo $this->_tpl_vars['myobj']->getFormField('article_status'); ?>
">
				<?php else: ?>
					<form name="article_writing_form" id="article_writing_form" method="post" action="<?php echo $this->_tpl_vars['myobj']->getUrl('articlewriting','','','members','article'); ?>
" enctype="multipart/form-data"  autocomplete="off">
				<?php endif; ?>

				<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
      			<p id="msgConfirmText"></p>
					<input type="submit" class="clsSubmitButton" name="updateConfirm" id="updateConfirm" value="<?php echo $this->_tpl_vars['LANG']['common_confirm_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"  onClick = "document.article_writing_form.submit()" />&nbsp;
	            	<input type="button" class="clsSubmitButton" name="notconfirm" id="notconfirm" value="<?php echo $this->_tpl_vars['LANG']['common_cancel_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="return hideAllBlocks();" />
    			</div>

		        <div id="selWritingBlock">
		        	<table summary="<?php echo $this->_tpl_vars['LANG']['articlewriting_tbl_summary']; ?>
" id="selWritingTbl" class="clsRichTextTable clsFormTableSection clsWritingBlock">
		        		<?php if ($this->_tpl_vars['myobj']->chkIsEditMode()): ?>
		        			<?php if ($this->_tpl_vars['myobj']->getFormField('article_status')): ?>
		        			<tr>
		        				<td>&nbsp;</td>
		        				<td>
									<label class="clsBold">
										<?php echo $this->_tpl_vars['LANG']['articlewriting_article_status_msg1']; ?>
&nbsp;
										<?php if ($this->_tpl_vars['myobj']->getFormField('article_status') == 'Ok'): ?>
											<?php echo $this->_tpl_vars['LANG']['articlewriting_article_status_published']; ?>

										<?php else: ?>
											<?php echo $this->_tpl_vars['myobj']->getFormField('article_status'); ?>

										<?php endif; ?>
										&nbsp;<?php echo $this->_tpl_vars['LANG']['articlewriting_article_status_msg2']; ?>

									</label>
								</td>
		        			</tr>
		        			<?php endif; ?>
		        		<?php endif; ?>
		                <tr>
		                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('article_title'); ?>
">
		                        <?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
<label for="article_title"><?php echo $this->_tpl_vars['LANG']['articlewriting_article_title']; ?>
</label>
		                    </td>
		                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('article_title'); ?>
">
		                        <input type="text" class="clsTextBox" name="article_title" id="article_title" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('article_title'); ?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['admin']['articles']['title_length']; ?>
" />
		                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('article_title'); ?>

		                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('article_title'); ?>

		                    </td>
		                </tr>
		                <tr>
		                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('article_summary'); ?>
">
		                        <?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
<label for="article_summary"><?php echo $this->_tpl_vars['LANG']['articlewriting_article_summary']; ?>
</label>
		                    </td>
		                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('article_summary'); ?>
">
		                    	<textarea name="article_summary" id="article_summary" rows="5" cols="10"  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['admin']['articles']['summary_length']; ?>
" class="clsTextBox" ><?php echo $this->_tpl_vars['myobj']->getFormField('article_summary'); ?>
</textarea><br/>
		                    	<div id="ss" class="clsZeroColour"><span class="clsCharacterLimit"><?php if (! $this->_tpl_vars['myobj']->chkIsEditMode()): ?><?php echo $this->_tpl_vars['LANG']['articlewriting_summary_max_chars']; ?>
<?php endif; ?></span></div>
		                    	<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('article_summary'); ?>

		                    	<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('article_summary'); ?>

		                    </td>
		                </tr>
		                <tr>
		                    <td colspan="2" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('article_caption'); ?>
">
		                        <label for="article_caption"><?php echo $this->_tpl_vars['LANG']['articlewriting_article_caption']; ?>
</label>
		                    </td>
		                 </tr>
		                 <tr>
		                 	<td colspan="2" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('article_caption'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('article_caption'); ?>

		                    	<?php echo $this->_tpl_vars['myobj']->populateTinyMceEditor('article_caption','',$this->_tpl_vars['myobj']->tinyReadMode); ?>

		                        <div class="clsEditImageArticle">
		                            <div class="button2-left"><a id="article_pagebreak" href="<?php echo $this->_tpl_vars['myobj']->article_writing_form['page_break_url']; ?>
" class="pagebreak"><?php echo $this->_tpl_vars['LANG']['articlewriting_pagebreak']; ?>
</a></div>
		                            <?php if ($this->_tpl_vars['CFG']['admin']['articles']['article_insert_image']): ?>
		                            	<div class="button2-left"><a id="article_insertimage" href="<?php echo $this->_tpl_vars['myobj']->article_writing_form['insert_image_url']; ?>
" class="image"><?php echo $this->_tpl_vars['LANG']['articlewriting_inserimage']; ?>
</a></div>
		                            <?php endif; ?>
		                            		                        </div>
		                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('article_caption'); ?>

		                    </td>
		                </tr>
				        <?php if ($this->_tpl_vars['CFG']['admin']['articles']['article_attachment']): ?>
				            <?php if (! $this->_tpl_vars['myobj']->chkIsEditMode()): ?>
				                <tr>
				                  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('article_file'); ?>
">
				                  	<?php if ($this->_tpl_vars['CFG']['admin']['articles']['article_attachment_compulsory']): ?><?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
<?php endif; ?>
				                    <label for="article_file"><?php echo $this->_tpl_vars['LANG']['articlewriting_article_attachment']; ?>
</label>
				                 </td>
				                  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('article_file'); ?>
">
				                    <input type="file" name="article_file" id="article_file" class="clsFileBox" accept="image/<?php echo $this->_tpl_vars['myobj']->changeArrayToCommaSeparator($this->_tpl_vars['CFG']['admin']['articles']['attachment_format_arr']); ?>
"  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /><br/>
				                    <label class="clsBold"><?php echo $this->_tpl_vars['LANG']['articlewriting_attachment_max_filesize']; ?>
</label>&nbsp;<?php echo $this->_tpl_vars['CFG']['admin']['articles']['attachment_max_size']; ?>
&nbsp;<?php echo $this->_tpl_vars['LANG']['common_kilobyte']; ?>
<br />
									<label class="clsBold"><?php echo $this->_tpl_vars['LANG']['articlewriting_attachment_allowed_formats']; ?>
</label>&nbsp;<?php echo $this->_tpl_vars['myobj']->changeArrayToCommaSeparator($this->_tpl_vars['CFG']['admin']['articles']['attachment_format_arr']); ?>

									<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('article_file'); ?>

				                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('article_attachment','article_file'); ?>

				                    </td>
				                </tr>
				             <?php endif; ?>
				        <?php endif; ?>
		                <tr>
		                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('article_tags'); ?>
">
		                        <?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
<label for="article_tags"><?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['articlewriting_article_tags'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</label>
		                    </td>
		                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('article_tags'); ?>
">
		                        <input type="text" class="clsTextBox" name="article_tags" id="article_tags" value="<?php echo $this->_tpl_vars['myobj']->getFormField('article_tags'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /><br />
		                        <?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['articlewriting_tags_msg'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>

		                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('article_tags'); ?>

		                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('article_tags'); ?>

		                    </td>
		                </tr>
		                <?php if ($this->_tpl_vars['myobj']->content_filter): ?>
			                <tr id="selDateLocationRow">
			                	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('article_category_type'); ?>
">
			                    	<label for="article_category_type2"><?php echo $this->_tpl_vars['LANG']['articlewriting_article_category_type']; ?>
</label>
			                    </td>
			                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('article_category_type'); ?>
">
			                        <input type="radio" name="article_category_type" id="article_category_type1" class="clsRadioButtonBorder" value="Porn" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('article_category_type','Porn'); ?>
 onclick="document.getElementById('selGeneralCategory').style.display='none';document.getElementById('selPornCategory').style.display='';" />
			                        &nbsp;<label for="article_category_type1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_porn']; ?>
</label>
			                        &nbsp;&nbsp;
			                        <input type="radio" name="article_category_type" id="article_category_type2" class="clsRadioButtonBorder" value="General" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
			                        <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('article_category_type','General'); ?>

			                        onclick="document.getElementById('selGeneralCategory').style.display='';document.getElementById('selPornCategory').style.display='none';" />
			                        &nbsp;<label for="article_category_type2" class="clsBold"><?php echo $this->_tpl_vars['LANG']['common_general']; ?>
</label>
			                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('article_category_type'); ?>

			                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('article_category_type1'); ?>
 <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('article_category_type2'); ?>

								 </td>
			                </tr>
		                <?php endif; ?>
		                <tr id="selCategoryBlock">
		                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('article_category_id'); ?>
">
		                        <?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
<label for="article_category_id"><?php echo $this->_tpl_vars['LANG']['articlewriting_article_category_id']; ?>
</label>
		                    </td>
		                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('article_category_id'); ?>
">

		                        <div id="selGeneralCategory" style="display:<?php echo $this->_tpl_vars['myobj']->General; ?>
">
		                            <!--<select name="article_category_id" id="article_category_id" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php if ($this->_tpl_vars['CFG']['admin']['articles']['sub_category']): ?> onchange="return populate_article_sub_categories('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
article/article_ajax.php', 't=<?php echo smartyTabIndex(array(), $this);?>
','selGeneralSubCategory');" <?php endif; ?> class="required">-->
		                            <select name="article_category_id" id="article_category_id" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php if ($this->_tpl_vars['CFG']['admin']['articles']['sub_category']): ?> onchange="return populateArticleSubCategory(this.value);" <?php endif; ?>>
		                                <option value=""><?php echo $this->_tpl_vars['LANG']['articlewriting_select_category']; ?>
</option>
		                                <?php echo $this->_tpl_vars['myobj']->populateArticleCatagory('General'); ?>

		                                		                            </select>
		                        </div>
								<?php if ($this->_tpl_vars['myobj']->content_filter): ?>
		                        <div id="selPornCategory" style="display:<?php echo $this->_tpl_vars['myobj']->Porn; ?>
">
			                        <select name="article_category_id_porn" id="article_category_id_porn" <?php if ($this->_tpl_vars['CFG']['admin']['articles']['sub_category']): ?> onchange="populateArticleSubCategory(this.value)" <?php endif; ?> tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
		                            	<option value=""><?php echo $this->_tpl_vars['LANG']['articlewriting_select_category']; ?>
</option>
		                                <?php echo $this->_tpl_vars['myobj']->populateArticleCatagory('Porn'); ?>

		                              			                            </select>
		                            <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('article_category_id_porn'); ?>

		                        </div>
		                    	<?php endif; ?>
								<?php echo $this->_tpl_vars['LANG']['articlewriting_select_a_category']; ?>

								<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('article_category_id'); ?>

		                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('article_category_id'); ?>

		                    </td>
		                </tr>
		                <?php if ($this->_tpl_vars['CFG']['admin']['articles']['sub_category']): ?>
		                    <tr id="selSubCategoryBlock">
		                        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('article_sub_category_id'); ?>
">
		                            <label for="article_sub_category_id"><?php echo $this->_tpl_vars['LANG']['articlewriting_article_sub_category_id']; ?>
</label>
		                        </td>
		                        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('article_sub_category_id'); ?>
">
		                            <div id="selSubCategoryBox">
		                                <select name="article_sub_category_id" id="article_sub_category_id" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
		                                    <option value=""><?php echo $this->_tpl_vars['LANG']['articlewriting_select_sub_category']; ?>
</option>
		                                </select>
		                            </div>
		                            <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('article_sub_category_id'); ?>

		                            <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('article_sub_category_id'); ?>

		                        </td>
		                    </tr>
		                <?php endif; ?>
		                <tr>
		                    <th class="clsArticleSettings"><?php echo $this->_tpl_vars['LANG']['articlewriting_article_settings']; ?>
</th>
		                    <th>&nbsp;</th>
		                </tr>
		                <tr id="selAllowDraft" class="clsAllowOptions">
		                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('draft_mode'); ?>
">
		                        <label for="draft_mode"><?php echo $this->_tpl_vars['LANG']['articlewriting_draft_mode']; ?>
</label>
		                    </td>
		                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('draft_mode2'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('draft_mode'); ?>

		                        <p><input type="radio" class="clsCheckRadio" name="draft_mode" id="draft_mode1" value="Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"<?php echo $this->_tpl_vars['myobj']->isCheckedRadio('draft_mode','Yes'); ?>
 />&nbsp;<label for="draft_mode1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['articlewriting_yes']; ?>
</label><?php echo $this->_tpl_vars['LANG']['articlewriting_draft_mode_world']; ?>
</p>
		                        <p><input type="radio" class="clsCheckRadio" name="draft_mode" id="draft_mode2" value="No" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"<?php echo $this->_tpl_vars['myobj']->isCheckedRadio('draft_mode','No'); ?>
 />&nbsp;<label for="draft_mode2" class="clsBold"><?php echo $this->_tpl_vars['LANG']['articlewriting_no']; ?>
</label><?php echo $this->_tpl_vars['LANG']['articlewriting_undraft_mode_world']; ?>
</p>
		                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('draft_mode'); ?>

		                    </td>
		                </tr>
		                <?php if (! $this->_tpl_vars['myobj']->checkTinyMode()): ?>
				    	<tr>
		                	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('date_of_publish'); ?>
">
		                    	<?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
<label for="date_of_publish"><?php echo $this->_tpl_vars['LANG']['date_of_publish']; ?>
</label>
		                    </td>
		                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('date_of_publish'); ?>
">
		                        <input type="text" class="ClsTextBox" name="date_of_publish" id="date_of_publish" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('date_of_publish'); ?>
" />
		                        <?php echo $this->_tpl_vars['myobj']->populateDateCalendar('date_of_publish',$this->_tpl_vars['dob_calendar_opts_arr']); ?>

		                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('date_of_publish',true); ?>

		                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('date_of_publish'); ?>

		                    </td>
                		</tr>
		                <?php elseif ($this->_tpl_vars['myobj']->checkTinyMode()): ?>
		                <tr id="selPublishDate" class="clsAllowOptions">
							<td><?php echo $this->_tpl_vars['LANG']['articlewriting_article_status']; ?>
</td>
							<td><label class="clsBold"><?php echo $this->_tpl_vars['LANG']['articlewriting_article_published']; ?>
</label></td>
														<input type="hidden" name="date_of_publish" id="date_of_publish" value="<?php echo $this->_tpl_vars['myobj']->getFormField('date_of_publish'); ?>
">
		                </tr>
		                <?php endif; ?>
		                <tr id="selArticleAccessRow">
		                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('article_access_type'); ?>
">
		                        <label for="article_access_type1"><?php echo $this->_tpl_vars['LANG']['articlewriting_article_access_type']; ?>
</label>
		                    </td>
		                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('article_access_type'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('article_access_type'); ?>

		                        <p><input type="radio" class="clsCheckRadio" name="article_access_type" id="article_access_type1" value="Public" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"<?php echo $this->_tpl_vars['myobj']->isCheckedRadio('article_access_type','Public'); ?>
 />&nbsp;<label for="article_access_type1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['articlewriting_public']; ?>
</label><?php echo $this->_tpl_vars['LANG']['articlewriting_share_your_article_world']; ?>
</p>
		                        <p><input type="radio" class="clsCheckRadio" name="article_access_type" id="article_access_type2" value="Private" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"<?php echo $this->_tpl_vars['myobj']->isCheckedRadio('article_access_type','Private'); ?>
 />&nbsp;<label for="article_access_type2" class="clsBold"><?php echo $this->_tpl_vars['LANG']['articlewriting_private']; ?>
</label><?php echo $this->_tpl_vars['LANG']['articlewriting_only_viewable_you']; ?>
</p>
		                        <p class="clsSelectHighlightNote"><?php echo $this->_tpl_vars['LANG']['articlewriting_only_viewable_you_email']; ?>
</p>
		                        <br /><?php echo $this->_tpl_vars['myobj']->populateCheckBoxForRelationList(); ?>

		                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('article_access_type'); ?>

		                    </td>
		                </tr>
		                <tr id="selAllowCommentsRow" class="clsAllowOptions">
		                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('allow_comments'); ?>
">
		                        <label for="allow_comments1"><?php echo $this->_tpl_vars['LANG']['articlewriting_allow_comments']; ?>
</label>
		                    </td>
		                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('allow_comments'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('allow_comments'); ?>

		                        <p><input type="radio" class="clsCheckRadio" name="allow_comments" id="allow_comments1" value="Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"<?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','Yes'); ?>
 />&nbsp;<label for="allow_comments1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['articlewriting_yes']; ?>
</label><?php echo $this->_tpl_vars['LANG']['articlewriting_allow_comments_world']; ?>
</p>
		                        <p><input type="radio" class="clsCheckRadio" name="allow_comments" id="allow_comments2" value="No" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"<?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','No'); ?>
 />&nbsp;<label for="allow_comments2" class="clsBold"><?php echo $this->_tpl_vars['LANG']['articlewriting_no']; ?>
</label><?php echo $this->_tpl_vars['LANG']['articlewriting_disallow_comments']; ?>
</p>
		                        <p><input type="radio" class="clsCheckRadio" name="allow_comments" id="allow_comments3" value="Kinda" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"<?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','Kinda'); ?>
 />&nbsp;<label for="allow_comments3" class="clsBold"><?php echo $this->_tpl_vars['LANG']['articlewriting_kinda']; ?>
</label><?php echo $this->_tpl_vars['LANG']['articlewriting_approval_comments']; ?>
</p>
		                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('allow_comments'); ?>

		                    </td>
		                </tr>
		                <tr id="selAllowRatingsRow" class="clsAllowOptions">
		                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('allow_ratings'); ?>
">
		                        <label for="allow_ratings1"><?php echo $this->_tpl_vars['LANG']['articlewriting_allow_ratings']; ?>
</label>
		                    </td>
		                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('allow_ratings'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('allow_ratings'); ?>

		                        <p><input type="radio" class="clsCheckRadio" name="allow_ratings" id="allow_ratings1" value="Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"<?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_ratings','Yes'); ?>
 />&nbsp;<label for="allow_ratings1" class="clsBold"><?php echo $this->_tpl_vars['LANG']['articlewriting_yes']; ?>
</label><?php echo $this->_tpl_vars['LANG']['articlewriting_allow_ratings_world']; ?>
</p>
		                        <p><input type="radio" class="clsCheckRadio" name="allow_ratings" id="allow_ratings2" value="No" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"<?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_ratings','No'); ?>
 />&nbsp;<label for="allow_ratings2" class="clsBold"><?php echo $this->_tpl_vars['LANG']['articlewriting_no']; ?>
</label><?php echo $this->_tpl_vars['LANG']['articlewriting_disallow_ratings']; ?>
</p>
		                        <p id="selDisableNote"><?php echo $this->_tpl_vars['LANG']['articlewriting_disallow_ratings1']; ?>
</p>
		                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('allow_ratings'); ?>

		                    </td>
		                </tr>
		                <tr>
		                    <td>&nbsp;</td><td class="clsFormFieldCellDefault">

		                        <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_arr); ?>

		                        <?php if (! $this->_tpl_vars['myobj']->chkIsEditMode()): ?>
		                            <input type="submit" class="clsSubmitButton" name="submit" id="submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['articlewriting_submit_article']; ?>
"/>
		                        <?php else: ?>
		                        	<?php if (! $this->_tpl_vars['CFG']['admin']['articles']['auto_activate'] && $this->_tpl_vars['CFG']['admin']['articles']['allow_edit_article_to_approve'] && ! $this->_tpl_vars['CFG']['admin']['is_logged_in'] && ( $this->_tpl_vars['myobj']->getFormField('article_status') == 'Ok' || $this->_tpl_vars['myobj']->getFormField('article_status') == 'InFuture' )): ?>
		                            	<input type="button" class="clsSubmitButton" name="update" id="update" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['articlewriting_edit_update']; ?>
"  onclick="checkAdminConfirmation();" />
		                            	<input type="hidden" name="confirmSubmit" value="yes">
		                            <?php else: ?>
		                            	<input type="submit" class="clsSubmitButton" name="update" id="update" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['articlewriting_edit_update']; ?>
" />
		                            <?php endif; ?>
		                            <input type="submit" class="clsSubmitButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['articlewriting_cancel']; ?>
" />
		                        <?php endif; ?>
		                    </td>
		                </tr>
		            </table>
		        </div>
				</form>
		        <?php echo '
					<script type="text/javascript">
						/* Function to display admin approval confirmation if move to draft folder is not checked */
						function checkAdminConfirmation()
						{
							if(document.getElementById(\'draft_mode2\').checked)
							{
                            	Confirmation(\'selMsgConfirm\', \'article_writing_form\', Array(\'msgConfirmText\'), Array(\''; ?>
<?php echo $this->_tpl_vars['LANG']['articlewriting_article_editing_admin_approval']; ?>
<?php echo '\'), Array(\'innerHTML\'), -100, -500);
							}
                            else
                            {
								document.article_writing_form.submit();
							}
						}
		            </script>
		        '; ?>

			</div>
		<?php endif; ?>
	</div>
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_articleupload_paidmembership_upgrade_form')): ?>
		<div><?php echo $this->_tpl_vars['myobj']->articleupload_upgrade_membership; ?>
</div>
	<?php endif; ?>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script>
<?php echo '
$Jq(document).ready(function() {
	$Jq(\'#article_pagebreak\').fancybox({
		\'width\'				: 450,
		\'height\'			: \'40%\',
		\'padding\'			:  0,
		\'autoScale\'     	: false,
		\'transitionIn\'		: \'none\',
		\'transitionOut\'		: \'none\',
		\'type\'				: \'iframe\'
	});

	$Jq(\'#article_insertimage\').fancybox({
		\'width\'				: 580,
		\'height\'			: \'78%\',
		\'padding\'			:  0,
		\'autoScale\'     	: false,
		\'transitionIn\'		: \'none\',
		\'transitionOut\'		: \'none\',
		\'type\'				: \'iframe\'
	});
});
'; ?>

</script>