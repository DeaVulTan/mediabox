<?php /* Smarty version 2.6.18, created on 2011-10-18 14:50:10
         compiled from addDiscussionTitle.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'addDiscussionTitle.tpl', 38, false),)), $this); ?>
<?php if (! isAjax ( )): ?>
<div id="selDiscussionTitleCreate">
<div class="clsCommonIndexRoundedCorner clsClearFix">
  <!--rounded corners-->
  <div class="lbtopanalyst">
    <div class="rbtopanalyst">
      <div class="bbtopanalyst">
        <div class="blctopanalyst">
          <div class="brctopanalyst">
            <div class="tbtopanalyst">
              <div class="tlctopanalyst">
                <div class="trctopanalyst">
				 <div class="clsBoardsLink">
						<h3>
                <?php echo $this->_tpl_vars['LANG']['discussionslinks_add_title']; ?>

            </h3></div>
    <div class="clsInboxReadTbl">
    <div id="selLeftNavigation">

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_create_discussion')): ?>

    <div id="selShowCreateDiscussion">
        <div id="selGroupDiscussionPost">
        <h3 id="selBackToDiscussion">
            <a href="<?php echo $this->_tpl_vars['myobj']->back_to_discussions['url']; ?>
">
                <?php echo $this->_tpl_vars['LANG']['discussion_back_index']; ?>

            </a>
        </h3>
        </div>
        <form name="selAddDiscussionFrm" id="selAddDiscussionFrm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
            <table summary="<?php echo $this->_tpl_vars['LANG']['discussion_tbl_summary']; ?>
" class="clsLoginTable">
                <tr>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('discussion_title'); ?>
"><label for="discussion_title"><?php echo $this->_tpl_vars['LANG']['discussion_title_add']; ?>
</label>
                    <span class="clsRequired">*</span><?php echo $this->_tpl_vars['myobj']->ShowHelpTip('discussion_title'); ?>
</td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('discussion_title'); ?>
">
                        <input type="text" class="clsTextBox <?php echo $this->_tpl_vars['myobj']->getCSSFormFieldElementClass('discussion_title'); ?>
" name="discussion_title" id="discussion_title" maxlength="200" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('discussion_title'); ?>
" /><?php echo $this->_tpl_vars['myobj']->getFormFieldElementErrorTip('discussion_title'); ?>

                    </td>
                </tr>
                    <tr>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('discussion_description'); ?>
"><label for="discussion_description"><?php echo $this->_tpl_vars['LANG']['discussion_description']; ?>
</label>
                     <span class="clsRequired">*</span><?php echo $this->_tpl_vars['myobj']->ShowHelpTip('discussion_title_description','discussion_description'); ?>
</td>
                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('discussion_description'); ?>
">
                        <textarea name="discussion_description" id="discussion_description" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldElementClass('discussion_description'); ?>
 clsTextArea selInputLimiter" rows="5" cols="23" maxlength="<?php echo $this->_tpl_vars['myobj']->CFG['admin']['description']['limit']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" maxlimit="<?php echo $this->_tpl_vars['myobj']->CFG['admin']['description']['limit']; ?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('discussion_description'); ?>
</textarea><?php echo $this->_tpl_vars['myobj']->getFormFieldElementErrorTip('discussion_description'); ?>

                    </td>
                    </tr>
	                <tr id="selCategoryBlock">
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('category'); ?>
"><label for="category"><?php echo $this->_tpl_vars['LANG']['discuzz_common_category']; ?>
</label><?php if ($this->_tpl_vars['CFG']['admin']['category']['mandatory']): ?><span class="clsRequired">*</span><?php endif; ?>
					    	<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('board_category','category'); ?>

					    </td>
					    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('category'); ?>
">
					    	<div id="selGeneralCategory">
						        <select name="category" id="category" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldElementClass('category'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onchange="showNextCategory('<?php echo $this->_tpl_vars['myobj']->discussionsAddTitle_url; ?>
', this.value, 'subCategoryDiv');">
						        	<option value="" selected><?php echo $this->_tpl_vars['LANG']['discuzz_common_select_choose']; ?>
</option>
						            <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->populateCategories_arr,$this->_tpl_vars['myobj']->getFormField('category')); ?>

						        </select>
					        </div>
					        <div id="subCategoryDiv">
					        <?php $this->assign('nextitem', 0); ?>
							<?php $_from = $this->_tpl_vars['myobj']->sublevel_categories; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
								<?php if ($this->_tpl_vars['value']): ?>
									<?php $this->assign('nextitem', $this->_tpl_vars['inc']+1); ?>
									<div id="subCategoryDiv<?php echo $this->_tpl_vars['inc']; ?>
">
										<select name="subcategory[]" id="subcategory" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldElementClass('category'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onchange="showNextCategory('addDiscussionTitle.php', this.value, 'subCategoryDiv<?php echo $this->_tpl_vars['nextitem']; ?>
');">
											<option value="" selected><?php echo $this->_tpl_vars['LANG']['discuzz_common_select_choose']; ?>
</option>
										<?php $_from = $this->_tpl_vars['value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['cat_details']):
?>
											<option value="<?php echo $this->_tpl_vars['cat_details']['cat_id']; ?>
" <?php echo $this->_tpl_vars['cat_details']['selected']; ?>
><?php echo $this->_tpl_vars['cat_details']['cat_name']; ?>
</option>
										<?php endforeach; endif; unset($_from); ?>
										</select>
									</div>
								<?php endif; ?>
							<?php endforeach; endif; unset($_from); ?>
							<?php if ($this->_tpl_vars['nextitem'] > 0): ?><div id="subCategoryDiv<?php echo $this->_tpl_vars['nextitem']; ?>
"></div><?php endif; ?>
							<?php echo $this->_tpl_vars['myobj']->getFormFieldElementErrorTip('category','select'); ?>

							</div>
					    </td>
					</tr>
					<?php if ($this->_tpl_vars['CFG']['admin']['friends']['allowed'] && $this->_tpl_vars['CFG']['admin']['discussions']['visibility']['needed']): ?>
                        <tr>
                        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('visible_to'); ?>
"><label for="status_all"><?php echo $this->_tpl_vars['myobj']->LANG['discussion_visible_to']; ?>
</label>
                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('visible_to'); ?>

                        </td>
                        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('visible_to'); ?>
">
                        <div class="clsRadioBtn"><input type="radio" name="visible_to" id="status_all" value="All" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('visible_to','All'); ?>
 tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /><label for="status_all"><?php echo $this->_tpl_vars['LANG']['discuzz_common_all_option']; ?>
</label>
                        <input type="radio" name="visible_to" id="status_friends" value="Friends" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('visible_to','Friends'); ?>
 tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /><label for="status_friends"><?php echo $this->_tpl_vars['LANG']['discuzz_common_friends_option']; ?>
</label>
                        <input type="radio" name="visible_to" id="status_none" value="None" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('visible_to','None'); ?>
 tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /><label for="status_none"><?php echo $this->_tpl_vars['LANG']['discuzz_common_none_option']; ?>
</label>
                        </div>
						<p class="clsFormInfo"><?php echo $this->_tpl_vars['LANG']['discussion_msg_board_visible_to_help']; ?>
</p><?php echo $this->_tpl_vars['myobj']->getFormFieldElementErrorTip('visible_to'); ?>

                        </td>
                        </tr>
    	            <?php endif; ?>
                    <?php if (! $this->_tpl_vars['CFG']['admin']['board_auto_publish']['allowed']): ?>
                        <tr>
                        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('publish'); ?>
"><label for="status_yes"><?php echo $this->_tpl_vars['myobj']->LANG['discussion_publish_allboards']; ?>
</label>
                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('publish_boards','status_no'); ?>

                        </td>
                        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('publish'); ?>
">
                        <input type="radio" name="publish" id="status_yes" value="Yes" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('publish','Yes'); ?>
 tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /> 
						<label for="status_yes"><?php echo $this->_tpl_vars['LANG']['discuzz_common_yes_option']; ?>
</label>
                        <input type="radio" name="publish" id="status_no" value="No" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('publish','No'); ?>
 tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /> 
						<label for="status_no"><?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
</label>
                        <p class="clsCaption"><?php echo $this->_tpl_vars['LANG']['discussion_msg_board_publish_help']; ?>
</p><?php echo $this->_tpl_vars['myobj']->getFormFieldElementErrorTip('publish'); ?>

                        </td>
                        </tr>
    	            <?php endif; ?>
                    <tr>
                    <td></td>
                       <td  class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
">
                       <p class="clsSubmitButton">
						<span>
					    <input type="submit" class="clsSearchButtonInput" name="discussion_submit" id="submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->button_value; ?>
" onclick="return updatelengthMine(this.form.discussion_description);" />
                       </span></p>
					   <p class="clsCancelButton">
						<span>
                        <input type="submit" class="clsCancelButtonInput cancel" name="discussion_cancel" id="discussion_cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
" />
						</span></p>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="discussion_id" id="discussion_id" value="<?php echo $this->_tpl_vars['myobj']->getFormField('discussion_id'); ?>
" />
        </form>
    </div>
<?php endif; ?>
<?php if (! isAjax ( )): ?>
	</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div></div>
  <!--end of rounded corners-->
</div>
</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('sub_category_block')): ?>
	<?php if ($this->_tpl_vars['myobj']->subcategory_details): ?>
		<select name="subcategory[]" id="subcategory<?php echo $this->_tpl_vars['myobj']->getFormField('cat_id'); ?>
" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldElementClass('category'); ?>
" tabindex="1023" onchange="showNextCategory('addDiscussionTitle.php', this.value, 'subCategoryDiv<?php echo $this->_tpl_vars['myobj']->getFormField('cat_id'); ?>
');">
			<option value="" selected><?php echo $this->_tpl_vars['LANG']['discuzz_common_select_choose']; ?>
</option>
			<?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->subcategory_details,$this->_tpl_vars['myobj']->getFormField('subcategory')); ?>

		</select>
		<div id="subCategoryDiv<?php echo $this->_tpl_vars['myobj']->getFormField('cat_id'); ?>
"></div>
	<?php endif; ?>
<?php endif; ?>