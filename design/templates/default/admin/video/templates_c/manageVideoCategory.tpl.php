<?php /* Smarty version 2.6.18, created on 2011-10-18 17:44:54
         compiled from manageVideoCategory.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'manageVideoCategory.tpl', 9, false),)), $this); ?>
<div id="selVideoCategory" class="clsVideoCategory">
	<h2><span><?php echo $this->_tpl_vars['LANG']['managevideocategory_title']; ?>
</span></h2>
	<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
			<table summary="<?php echo $this->_tpl_vars['LANG']['managevideocategory_confirm_tbl_summary']; ?>
">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" />&nbsp;
						<input type="button" class="clsSubmitButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" onClick="return hideAllBlocks();" />
						<input type="hidden" name="category_ids" id="category_ids" />
                        <input type="hidden" name="category_id" id="category_id" />
						<input type="hidden" name="action" id="action" />
						<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_arr1); ?>

					</td>
				</tr>
			</table>
		</form>
	</div>
	<div id="selMsgConfirmSub" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessageSub"></p>
		<form name="msgConfirmformSub" id="msgConfirmformSub" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
			<table summary="<?php echo $this->_tpl_vars['LANG']['managevideocategory_confirm_tbl_summary']; ?>
">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirm_actionSub" id="confirm_actionSub" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" />&nbsp;
						<input type="button" class="clsSubmitButton" name="cancelSub" id="cancelSub" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
"  onClick="return hideAllBlocks();" />
						<input type="hidden" name="category_ids" id="category_ids" />
						<input type="hidden" name="action" id="action" />
						<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_arr2); ?>

					</td>
				</tr>
			</table>
		</form>
	</div>
	<div class="clsLeftNavigation" id="selLeftNavigation">
  <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<p class="ClsMandatoryText"><?php echo $this->_tpl_vars['LANG']['common_mandatory_hint_1']; ?>
 <?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
<?php echo $this->_tpl_vars['LANG']['common_mandatory_hint_2']; ?>
</p>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_create_category')): ?>
	<div id="selCreateCategory">
		<form name="selCreateCategoryFrom" id="selCreateCategoryFrom" enctype="multipart/form-data" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" autocomplete="off">
		<table class="clsNoBorder" summary="<?php echo $this->_tpl_vars['LANG']['managevideocategory_create_tbl_summary']; ?>
">
		   	<tr>
				<td class="clsSmallWidth <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('category'); ?>
"><label for="category"><?php echo $this->_tpl_vars['LANG']['managevideocategory_category_name']; ?>
</label>  <?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('category'); ?>
">
					<input type="text" class="clsTextBox" maxlength="<?php echo $this->_tpl_vars['CFG']['admin']['videos']['category_accept_max_length']; ?>
" name="category" id="category" value="<?php echo $this->_tpl_vars['myobj']->getFormField('category'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                    <div><!-- -->
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('category'); ?>
</div>
                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('category'); ?>
				</td>
			</tr>
            <tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('category_image'); ?>
"><label for="category_image"><?php echo $this->_tpl_vars['LANG']['managevideocategory_category_image']; ?>
 (<?php echo $this->_tpl_vars['myobj']->imageFormat; ?>
) <?php echo $this->_tpl_vars['CFG']['admin']['videos']['category_image_max_size']; ?>
 KB
                </label>  <?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('category_image'); ?>
">
					<?php if ($this->_tpl_vars['myobj']->getFormField('category_id')): ?>
						<img src="<?php echo $this->_tpl_vars['myobj']->category_image; ?>
" alt="<?php echo $this->_tpl_vars['myobj']->getFormField('category'); ?>
" />
					<?php endif; ?>
					<input type="file" class="clsFileBox" name="category_image" id="category_image" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                    <div><!-- -->
                    	<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('category_image'); ?>

                     </div>
                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('category_image'); ?>
				</td>
			</tr>


			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('category_description'); ?>
"><label for="category_description"><?php echo $this->_tpl_vars['LANG']['managevideocategory_category_description']; ?>
</label>  <?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('category_description'); ?>
">
					<textarea rows="4" cols="50" name="category_description" id="category_description" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('category_description'); ?>
</textarea>
                    <div><!-- -->
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('category_description'); ?>
</div>
                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('category_description'); ?>

                    </td>
			</tr>
       <?php if ($this->_tpl_vars['myobj']->chkAllowedModule ( array ( 'content_filter' ) )): ?>
			<tr id="selDateLocationRow" class="clsAllowOptions">
         		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('allow_post'); ?>
">
					<label for="allow_post1"><?php echo $this->_tpl_vars['LANG']['manageVideocategory_allow_post']; ?>
</label>				</td>
          		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('allow_post'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('allow_post'); ?>

					<input type="radio" class="clsCheckRadio" name="allow_post" id="allow_post1" value="Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_post','Yes'); ?>
 />&nbsp;<label for="allow_post1"><?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
</label>
					&nbsp;&nbsp;
					<input type="radio" class="clsCheckRadio" name="allow_post" id="allow_post2" value="No" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"<?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_post','No'); ?>
 />&nbsp;<label for="allow_post2"><?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
</label>				</td>
        	</tr>
			<tr id="selDateLocationRow" class="clsAllowOptions">
         		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('video_category_type'); ?>
">
					<label for="video_category_type1"><?php echo $this->_tpl_vars['LANG']['managevideocategory_video_category_type']; ?>
</label>				</td>
          		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('video_category_type'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('video_category_type'); ?>

					<input type="radio" class="clsCheckRadio" name="video_category_type" id="video_category_type1" value="Porn" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"<?php echo $this->_tpl_vars['myobj']->isCheckedRadio('video_category_type','Porn'); ?>
 />&nbsp;<label for="video_category_type1" ><?php echo $this->_tpl_vars['LANG']['porn']; ?>
</label>
					&nbsp;&nbsp;
					<input type="radio" class="clsCheckRadio" name="video_category_type" id="video_category_type2" value="General" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"<?php echo $this->_tpl_vars['myobj']->isCheckedRadio('video_category_type','General'); ?>
/>&nbsp;<label for="video_category_type2"><?php echo $this->_tpl_vars['LANG']['general']; ?>
</label>				</td>
        	</tr>
<?php endif; ?>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('status'); ?>
"><label for="status_yes"><?php echo $this->_tpl_vars['LANG']['managevideocategory_category_status']; ?>
</label></td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('status'); ?>
">
					<input type="radio" class="clsCheckRadio" name="status" id="status_yes" value="Yes" <?php if ($this->_tpl_vars['myobj']->getFormField('status') == 'Yes'): ?> CHECKED <?php endif; ?> tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />&nbsp;<label for="status_yes"><?php echo $this->_tpl_vars['LANG']['managevideocategory_status_yes']; ?>
</label>
					&nbsp;&nbsp;
					<input type="radio" class="clsCheckRadio" name="status" id="status_no" value="No" <?php if ($this->_tpl_vars['myobj']->getFormField('status') == 'No'): ?> CHECKED <?php endif; ?> tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />&nbsp;<label for="status_no"><?php echo $this->_tpl_vars['LANG']['managevideocategory_status_no']; ?>
</label>				</td>
			</tr>
			<tr>
			  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('priority'); ?>
"><label for="priority"><?php echo $this->_tpl_vars['LANG']['manageVideocategory_priority']; ?>
</label></td>
			  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('priority'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('priority'); ?>

              <input type="text" class="clsTextBox" name="priority" id="priority"  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('priority'); ?>
"/>
               <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('about_priority','priority'); ?>

              </td>
		  </tr>
			<tr>
				<td colspan="2" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('category_submit'); ?>
">
			<?php if ($this->_tpl_vars['myobj']->chkIsEditMode()): ?>
					<input type="submit" class="clsSubmitButton" name="category_submit" id="category_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['managevideocategory_update_submit']; ?>
" />
					<input type="submit" class="clsCancelButton" name="category_cancel" id="category_cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['managevideocategory_cancel_submit']; ?>
" />
			<?php else: ?>
			        <input type="submit" class="clsSubmitButton" name="category_submit" id="category_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['managevideocategory_add_submit']; ?>
" />
			<?php endif; ?>				</td>
			</tr>
		</table>
        <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->form_create_category['hidden_arr']); ?>

		</form>
	</div>

<?php endif; ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_create_sub_category')): ?>
	<p class="clsPageLink"><a href="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
"><?php echo $this->_tpl_vars['LANG']['managevideocategory_back_to_main']; ?>
</a></p>
	<div id="selCreateSubCategory">
		<form name="selCreateSubCategory" id="selCreateSubCategory" enctype="multipart/form-data" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
" autocomplete="off">
		<table class="clsNoBorder" summary="<?php echo $this->_tpl_vars['LANG']['managevideocategory_create_tbl_summary']; ?>
">
		   	<tr>
				<td class="clsWidthSmall <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('sub_category'); ?>
"><label for="sub_category"><?php echo $this->_tpl_vars['LANG']['managevideocategory_subcategory_name']; ?>
</label>  <?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('sub_category'); ?>
">
					<input type="text" class="clsTextBox" maxlength="<?php echo $this->_tpl_vars['CFG']['admin']['videos']['category_accept_max_length']; ?>
" name="sub_category" id="sub_category" value="<?php echo $this->_tpl_vars['myobj']->getFormField('sub_category'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                    <div><!-- -->
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('sub_category'); ?>
</div>
                     <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('sub_category'); ?>
				</td>
			</tr>
            <tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('sub_category_image'); ?>
">
                <label for="sub_category_image"><?php echo $this->_tpl_vars['LANG']['managevideocategory_sub_category_image']; ?>
                </label>  <?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
                </td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('sub_category_image'); ?>
">
					<?php if ($this->_tpl_vars['myobj']->getFormField('sub_category_id') && $this->_tpl_vars['myobj']->getFormField('opt') == 'subedit'): ?>
						<img src="<?php echo $this->_tpl_vars['myobj']->category_image; ?>
" alt="<?php echo $this->_tpl_vars['myobj']->getFormField('sub_category'); ?>
" />
					<?php endif; ?>
					<input type="file" class="clsFileBox" name="sub_category_image" id="sub_category_image" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                    <div><!-- -->
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('sub_category_image'); ?>
</div>
                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('sub_category_image'); ?>
				</td>
			</tr>
            <tr>
              <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('priority'); ?>
"><label for="priority"><?php echo $this->_tpl_vars['LANG']['manageVideocategory_priority']; ?>
</label></td>
              <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('priority'); ?>
">
              	<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('priority'); ?>

                <input class="clsTextBox" type="text" name="priority" id="priority" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('priority'); ?>
"/>
                <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('about_priority','priority'); ?>
              </td>
            </tr>
<!--			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('status'); ?>
"><label for="status_yes"><?php echo $this->_tpl_vars['LANG']['managevideocategory_category_status']; ?>
</label></td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('status'); ?>
">
					<input type="radio" class="clsCheckRadio" name="status" id="status_yes" value="Yes" <?php if ($this->_tpl_vars['myobj']->getFormField('status') == 'Yes'): ?> CHECKED <?php endif; ?> tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />&nbsp;<label for="status_yes"><?php echo $this->_tpl_vars['LANG']['managevideocategory_status_yes']; ?>
</label>
					&nbsp;&nbsp;
					<input type="radio" class="clsCheckRadio" name="status" id="status_no" value="No" <?php if ($this->_tpl_vars['myobj']->getFormField('status') == 'No'): ?> CHECKED <?php endif; ?> tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />&nbsp;<label for="status_no"><?php echo $this->_tpl_vars['LANG']['managevideocategory_status_no']; ?>
</label>				</td>
			</tr>
-->
			<tr>
				<td colspan="2" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('category_submit'); ?>
">

				<?php if ($this->_tpl_vars['myobj']->chkIsEditModeSub()): ?>
					<input type="submit" class="clsSubmitButton" name="update_category_submit" id="sub_category_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['managevideocategory_update_submit']; ?>
" />
				  <input type="submit" class="clsCancelButton" name="sub_category_cancel" id="sub_category_cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['managevideocategory_cancel_submit']; ?>
" />
				<?php else: ?>
		          <input type="submit" class="clsSubmitButton" name="sub_category_submit" id="sub_category_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['managevideocategory_add_submit']; ?>
" />
				<?php endif; ?>				</td>
			</tr>
		</table>
        <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->form_create_sub_category['hidden_arr']); ?>

        <input type="hidden" id="category_id" name="category_id" value="<?php echo $this->_tpl_vars['myobj']->getFormField('category_id'); ?>
" />
        <input type="hidden" id="sub_category_id" name="sub_category_id" value="<?php echo $this->_tpl_vars['myobj']->getFormField('sub_category_id'); ?>
" />
		<input type="hidden" name="start" value="<?php echo $this->_tpl_vars['myobj']->getFormField('start'); ?>
" />
		</form>
	</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_show_sub_category')): ?>
    <?php if ($this->_tpl_vars['populateSubCategories_arr']['rs_PO_RecordCount']): ?>
    	<form name="selFormSubCategory" id="selFormSubCategory" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
        <table>
            <tr>
                <th><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="CheckAll(document.selFormSubCategory.name, document.selFormSubCategory.check_all.name)"/></th>
                <th><?php echo $this->_tpl_vars['LANG']['managevideocategory_subcategory_id']; ?>
</th>
              <!--                <th><?php echo $this->_tpl_vars['LANG']['managevideocategory_category']; ?>
</th>-->
                <th><?php echo $this->_tpl_vars['LANG']['managevideocategory_subcategory_name']; ?>
</th>
                <th><?php echo $this->_tpl_vars['LANG']['managevideocategory_date_added']; ?>
</th>
                <th>&nbsp;</th>
            </tr>
      	<?php $_from = $this->_tpl_vars['populateSubCategories_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pscValue']):
?>
        	<tr>
                <td class="clsAlignCenter"><input type="checkbox" class="clsCheckRadio" name="category_ids[]" value="<?php echo $this->_tpl_vars['pscValue']['record']['video_category_id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['pscValue']['checked']; ?>
 onClick="disableHeading('flaggedForm');"/></td>
                <td><?php echo $this->_tpl_vars['pscValue']['record']['video_category_id']; ?>
</td>
                <td>
                    <p id="categoryName"><?php echo $this->_tpl_vars['pscValue']['record']['video_category_name']; ?>
</p>                </td>
<!--                <td><?php echo $this->_tpl_vars['pscValue']['record']['video_category_name']; ?>
</td>-->
                <td><?php echo $this->_tpl_vars['pscValue']['record']['date_added']; ?>
</td>
                <td><p id="edit"><a href="manageVideoCategory.php?category_id=<?php echo $this->_tpl_vars['myobj']->getFormField('category_id'); ?>
&amp;sub_category_id=<?php echo $this->_tpl_vars['pscValue']['record']['video_category_id']; ?>
&amp;opt=subedit"><?php echo $this->_tpl_vars['LANG']['managevideocategory_edit']; ?>
</a></p></td>
            </tr>
        <?php endforeach; endif; unset($_from); ?>
            <tr>
                <td colspan="5">
                    <a href="#" id="dAltMltiSub" name="dAltMltiSub"></a>
                    <input type="button" value="<?php echo $this->_tpl_vars['LANG']['managevideocategory_action_delete']; ?>
" onClick="if(getMultiCheckBoxValue('selFormSubCategory', 'check_all', '<?php echo $this->_tpl_vars['LANG']['managevideocategory_err_tip_select_category']; ?>
', 'dAltMltiSub', -25, -290)) <?php echo ' { '; ?>
 Confirmation('selMsgConfirmSub', 'msgConfirmformSub', Array('category_ids', 'action', 'category_id', 'confirmMessageSub'), Array(multiCheckValue, 'delete', '<?php echo $this->_tpl_vars['myobj']->getFormField('category_id'); ?>
', '<?php echo $this->_tpl_vars['LANG']['managevideocategory_confirm_message']; ?>
'), Array('value', 'value', 'value', 'innerHTML'), -25, -290); <?php echo ' } '; ?>
" />                </td>
            </tr>
        </table>
      </form>
    <?php else: ?>
        <div id="selMsgAlert">
            <p><?php echo $this->_tpl_vars['LANG']['managevideocategory_no_sub_category']; ?>
</td>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_show_category')): ?>
	<form name="selFormCategory" id="selFormCategory" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
    <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->form_show_category['hidden_arr']); ?>


    <div id="selShowCategories">
        <?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
            <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>

                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>

            <table summary="<?php echo $this->_tpl_vars['LANG']['managevideocategory_tbl_summary']; ?>
">
                <tr>
                    <th><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="CheckAll(document.selFormCategory.name, document.selFormCategory.check_all.name)"/></th>
                    <th><?php echo $this->_tpl_vars['LANG']['managevideocategory_category_id']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['LANG']['managevideocategory_category']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['LANG']['managevideocategory_video_category_type']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['LANG']['managevideocategory_video_count']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['LANG']['managevideocategory_description']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['LANG']['managevideocategory_allow_post']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['LANG']['managevideocategory_status']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['LANG']['managevideocategory_date_added']; ?>
</th>
                    <th>&nbsp;</th>
                </tr>
			<?php $_from = $this->_tpl_vars['showCategories_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['scKey'] => $this->_tpl_vars['scValue']):
?>
                <tr>
                    <td class="clsAlignCenter"><input type="checkbox" class="clsCheckRadio" name="category_ids[]" value="<?php echo $this->_tpl_vars['scValue']['record']['video_category_id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['scValue']['checked']; ?>
 onClick="checkCheckBox(this.form, 'check_all');"/></td>
                    <td><?php echo $this->_tpl_vars['scValue']['record']['video_category_id']; ?>
</td>
                    <td>
                        <p id="categoryName"><a href="manageVideoCategory.php?category_id=<?php echo $this->_tpl_vars['scValue']['record']['video_category_id']; ?>
&amp;opt=sub"><?php echo $this->_tpl_vars['scValue']['record']['video_category_name']; ?>
</a></p>                    </td>
                    <td><?php echo $this->_tpl_vars['scValue']['record']['video_category_type']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['myobj']->getVideoCount($this->_tpl_vars['scValue']['record']['video_category_id']); ?>
</td>

                    <td><?php echo $this->_tpl_vars['scValue']['record']['video_category_description']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['myobj']->getVideoCount($this->_tpl_vars['scValue']['record']['allow_post']); ?>
</td>
                    <td>
                        <p><?php echo $this->_tpl_vars['scValue']['record']['video_category_status']; ?>
</p>                    </td>
                    <td>
                        <p><?php echo $this->_tpl_vars['scValue']['record']['date_added']; ?>
</p>                    </td>
                    <td>
                        <p id="edit"><a href="manageVideoCategory.php?category_id=<?php echo $this->_tpl_vars['scValue']['record']['video_category_id']; ?>
&amp;start=<?php echo $this->_tpl_vars['myobj']->getFormField('start'); ?>
"><?php echo $this->_tpl_vars['LANG']['managevideocategory_edit']; ?>
</a></p>
                        <?php if ($this->_tpl_vars['CFG']['admin']['videos']['sub_category']): ?>
                        <p>
                            <a href="manageVideoCategory.php?category_id=<?php echo $this->_tpl_vars['scValue']['record']['video_category_id']; ?>
&amp;opt=sub"><?php echo $this->_tpl_vars['LANG']['managevideosubgenrelink']; ?>
</a>
                            </p>
                         <?php endif; ?>

                                            </td>
                </tr>
            <?php endforeach; endif; unset($_from); ?>
				<tr>
					<td colspan="10" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('delete'); ?>
">
						<a href="#" id="dAltMlti"></a>
						<select name="video_options" id="video_options" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" >
							<option value="Enable"><?php echo $this->_tpl_vars['LANG']['managevideocategory_action_enable']; ?>
</option>
	  						<option value="Disable"><?php echo $this->_tpl_vars['LANG']['managevideocategory_action_disable']; ?>
</option>
	  						<option value="Delete"><?php echo $this->_tpl_vars['LANG']['managevideocategory_action_delete']; ?>
</option>
	  					</select>
						<input type="button" class="clsSubmitButton" name="action_submit" id="action_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['managevideocategory_submit']; ?>
" onClick="if(getMultiCheckBoxValue('selFormCategory', 'check_all', '<?php echo $this->_tpl_vars['LANG']['managevideocategory_err_tip_select_category']; ?>
', 'dAltMlti', -25, -290)) <?php echo ' { '; ?>
 Confirmation('selMsgConfirm', 'msgConfirmform', Array('category_ids', 'action', 'confirmMessage'), Array(multiCheckValue, document.selFormCategory.video_options.value, '<?php echo $this->_tpl_vars['LANG']['managevideocategory_confirm_message']; ?>
'), Array('value', 'value', 'innerHTML'), -25, -290); <?php echo ' } '; ?>
" />					</td>
				</tr>
			</table>

        <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>

                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>
        <?php else: ?>
            <div id="selMsgAlert">
                <p><?php echo $this->_tpl_vars['LANG']['managevideocategory_no_category']; ?>
</td>
            </div>
        <?php endif; ?>
    </div>
	</form>
<?php endif; ?>

	</div>
</div>