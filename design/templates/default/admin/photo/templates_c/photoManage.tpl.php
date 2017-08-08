<?php /* Smarty version 2.6.18, created on 2011-10-18 16:24:10
         compiled from photoManage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'photoManage.tpl', 9, false),)), $this); ?>
<div id="selphotoList">
  	<h2><span><?php echo $this->_tpl_vars['LANG']['photoManage_title']; ?>
</span></h2>
	<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
			<table summary="<?php echo $this->_tpl_vars['LANG']['photoManage_confirm_tbl_summary']; ?>
">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirmdel" id="confirmdel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['confirm']; ?>
" />
						&nbsp;
						<input type="button" class="clsSubmitButton" name="subcancel" id="subcancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['photoManage_cancel']; ?>
"  onClick="return hideAllBlocks();" />
						<input type="hidden" name="checkbox" id="checkbox" />
						<input type="hidden" name="action" id="action" />
						<input type="hidden" name="photo_categories" id="photo_categories" />
						<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_arr); ?>

					</td>
				</tr>
			</table>
		</form>
	</div>

<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('browse_photos')): ?>
      <div id="selActivationConfirm">
        <form name="photo_manage_form1" id="photo_manage_form1" method="post" action="photoManage.php" autocomplete="off">

                        <h3><label for="list"><?php echo $this->_tpl_vars['LANG']['photoManage_list']; ?>
</label>&nbsp;&nbsp;&nbsp;
                        <select name="list" id="list" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                            <?php echo $this->_tpl_vars['myobj']->browse_photos['list']; ?>

                        </select>
                        <input type="submit" class="clsSubmitButton" name="submit" id="submit" value="<?php echo $this->_tpl_vars['LANG']['photoManage_submit']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />&nbsp;</h3>

        </form>
      </div>
<?php endif; ?>
--><?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_search')): ?>
	<div id="selShowSearchGroup">
		<form name="selFormSearch" id="selFormSearch" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
			<table class="clsNoBorder clsphotoTable" summary="<?php echo $this->_tpl_vars['LANG']['photoManage_search_tbl_summary']; ?>
">
			<tr>
				<td class="clsWidthSmall <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('srch_uname'); ?>
"><label for="srch_uname"><?php echo $this->_tpl_vars['LANG']['photoManage_search_username']; ?>
</label></td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('srch_uname'); ?>
"><input type="text" class="clsTextBox" name="srch_uname" id="srch_uname" value="<?php echo $this->_tpl_vars['myobj']->getFormField('srch_uname'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/></td>
			</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('srch_title'); ?>
"><label for="srch_title"><?php echo $this->_tpl_vars['LANG']['photoManage_search_title']; ?>
</label></td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('srch_title'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('srch_title'); ?>
<input type="text" class="clsTextBox" name="srch_title" id="srch_title" value="<?php echo $this->_tpl_vars['myobj']->getFormField('srch_title'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/></td>
			</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('srch_flag'); ?>
"><label for="srch_flag"><?php echo $this->_tpl_vars['LANG']['photoManage_search_flaged']; ?>
</label></td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('srch_flag'); ?>
">
					<select name="srch_flag" id="srch_flag" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
						<option value=""><?php echo $this->_tpl_vars['LANG']['action_select']; ?>
</option>
						<option value="Yes" <?php if ($this->_tpl_vars['myobj']->getFormField('srch_flag') == 'Yes'): ?> SELECTED <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['photoManage_search_flag_yes']; ?>
</option>
						<option value="No" <?php if ($this->_tpl_vars['myobj']->getFormField('srch_flag') == 'No'): ?> SELECTED <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['photoManage_search_flag_no']; ?>
</option>
					</select></td>
			</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('srch_feature'); ?>
"><label for="srch_feature"><?php echo $this->_tpl_vars['LANG']['photoManage_search_featured']; ?>
</label></td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('srch_feature'); ?>
">
				<select name="srch_feature" id="srch_feature" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                  <option value=""><?php echo $this->_tpl_vars['LANG']['action_select']; ?>
</option>
                  <option value="Yes" <?php if ($this->_tpl_vars['myobj']->getFormField('srch_feature') == 'Yes'): ?> SELECTED <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['photoManage_search_feature_yes']; ?>
</option>
                  <option value="No" <?php if ($this->_tpl_vars['myobj']->getFormField('srch_feature') == 'No'): ?> SELECTED <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['photoManage_search_feature_no']; ?>
</option>
                </select></td>
			</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('srch_date_added'); ?>
"><label for="srch_date"><?php echo $this->_tpl_vars['LANG']['photoManage_search_date_created']; ?>
</label></td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('srch_date_added'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('srch_date_added'); ?>

					<select name="srch_date" id="srch_date" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
						<option value=""><?php echo $this->_tpl_vars['LANG']['photoManage_search_date']; ?>
</option>
						<?php echo $this->_tpl_vars['myobj']->populateBWNumbers(1,31,$this->_tpl_vars['myobj']->getFormField('srch_date')); ?>

					</select>
					<select name="srch_month" id="srch_month" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
						<option value=""><?php echo $this->_tpl_vars['LANG']['photoManage_search_month']; ?>
</option>
						<?php echo $this->_tpl_vars['myobj']->populateMonthsList($this->_tpl_vars['myobj']->getFormField('srch_month')); ?>

					</select>
					<select name="srch_year" id="srch_year" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
						<option value=""><?php echo $this->_tpl_vars['LANG']['photoManage_search_year']; ?>
</option>
						<?php echo $this->_tpl_vars['myobj']->populateBWNumbers(1920,$this->_tpl_vars['myobj']->current_year,$this->_tpl_vars['myobj']->getFormField('srch_year')); ?>

					</select></td>
			</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('srch_categories'); ?>
"><label for="srch_categories"><?php echo $this->_tpl_vars['LANG']['photoManage_search_categories']; ?>
</label></td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('srch_categories'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('srch_categories'); ?>

					<select name="srch_categories" id="srch_categories" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" class="clsSelectLarge">
						<option value=""><?php echo $this->_tpl_vars['LANG']['photoManage_select_categories']; ?>
</option>
						<?php echo $this->_tpl_vars['myobj']->populatephotoCategory(); ?>

					</select></td>
			</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('photoManage_search'); ?>
" colspan="2"><input type="submit" class="clsSubmitButton" value="<?php echo $this->_tpl_vars['LANG']['photoManage_search']; ?>
" id="search" name="search" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/></td>
			</tr>
			</table>
			<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->form_search['hidden_arr']); ?>

		</form>
	</div>
<?php endif; ?>

<table class="clsNoBorder clsPhotoTable" >
<td>
<a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/photo/photoFeaturedReorder.php" ><?php echo $this->_tpl_vars['LANG']['photoManage_manage_featured_photo_order_link']; ?>
</a>
</td>
</table>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_photo_form')): ?>
    <div id="selphotoList">
	<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
		   	<form name="photo_manage_form2" id="photo_manage_form2" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">

            <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
            	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>
			  	<table summary="<?php echo $this->_tpl_vars['LANG']['photoManage_tbl_summary']; ?>
">
					<tr>
						<th class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="CheckAll(document.photo_manage_form2.name, document.photo_manage_form2.check_all.name)"/></th>
						<th><?php echo $this->_tpl_vars['LANG']['photomanage_photo_id']; ?>
</th>
                        <th><?php echo $this->_tpl_vars['LANG']['photomanage_photo_title']; ?>
</th>
                        <th><?php echo $this->_tpl_vars['LANG']['photomanage_photo_image']; ?>
</th>
						<th><?php echo $this->_tpl_vars['LANG']['photomanage_photo_category']; ?>
</th>
                     <?php if ($this->_tpl_vars['CFG']['admin']['photos']['sub_category']): ?>
                        <th><?php echo $this->_tpl_vars['LANG']['photomanage_photo_sub_category']; ?>
</th>
                     <?php endif; ?>
						<th><?php echo $this->_tpl_vars['LANG']['photo_user_name']; ?>
</th>
						<th><?php echo $this->_tpl_vars['LANG']['photo_date_added']; ?>
</th>
						<th><?php echo $this->_tpl_vars['LANG']['photo_option']; ?>
</th>
						<th><?php echo $this->_tpl_vars['LANG']['photo_featured']; ?>
</th>
					</tr>
					<?php $_from = $this->_tpl_vars['displayphotoList_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dalKey'] => $this->_tpl_vars['dalValue']):
?>
						<tr>
							<td class="clsSelectAllItems"><input type='checkbox' name='checkbox[]' value="<?php echo $this->_tpl_vars['dalValue']['record']['photo_id']; ?>
-<?php echo $this->_tpl_vars['dalValue']['record']['user_id']; ?>
" onClick="disableHeading('photo_manage_form2');"/></td>
                            <td>
                            	<?php echo $this->_tpl_vars['dalValue']['record']['photo_id']; ?>

                            </td>
							<td>
                            	<?php echo $this->_tpl_vars['dalValue']['record']['photo_title']; ?>

                            </td>
							<td>
                                
                                                                 <a id="previewPhoto_<?php echo $this->_tpl_vars['dalValue']['record']['photo_id']; ?>
" href="<?php echo $this->_tpl_vars['dalValue']['previewURL']; ?>
"  class="lightwindow" title="<?php echo $this->_tpl_vars['dalValue']['record']['photo_title']; ?>
"><img src="<?php echo $this->_tpl_vars['dalValue']['file_path']; ?>
" alt="<?php echo $this->_tpl_vars['dalValue']['record']['photo_title']; ?>
"<?php echo $this->_tpl_vars['dalValue']['DISP_IMAGE']; ?>
 /></a>
                                
                                
								</td>

							<td><?php echo $this->_tpl_vars['myobj']->getphotoCategory($this->_tpl_vars['dalValue']['record']['photo_category_id']); ?>
</td>
                        <?php if ($this->_tpl_vars['CFG']['admin']['photos']['sub_category']): ?>
                            <td><?php echo $this->_tpl_vars['myobj']->getphotoCategory($this->_tpl_vars['dalValue']['record']['photo_sub_category_id']); ?>
</td>
                        <?php endif; ?>
							<td><?php echo $this->_tpl_vars['dalValue']['name']; ?>
</td>
							<td><?php echo $this->_tpl_vars['dalValue']['record']['date_added']; ?>
</td>
							<td><?php echo $this->_tpl_vars['dalValue']['record']['flagged_status']; ?>
</td>
							<td><?php echo $this->_tpl_vars['dalValue']['record']['featured']; ?>
</td>
						</tr>
                    <?php endforeach; endif; unset($_from); ?>
					<tr>
						<td colspan="9">
							<a href="javascript:void(0)" id="dAltMlti"></a>
							<select name="photo_options" id="photo_options" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
								<option value=""><?php echo $this->_tpl_vars['LANG']['action_select']; ?>
</option>
								<option value="Delete"><?php echo $this->_tpl_vars['LANG']['action_delete']; ?>
</option>
								<option value="Flag"><?php echo $this->_tpl_vars['LANG']['action_flag']; ?>
</option>
								<option value="UnFlag"><?php echo $this->_tpl_vars['LANG']['action_unflag']; ?>
</option>
								<option value="Featured"><?php echo $this->_tpl_vars['LANG']['action_featured']; ?>
</option>
								<option value="UnFeatured"><?php echo $this->_tpl_vars['LANG']['action_unfeatured']; ?>
</option>
							</select>&nbsp;
							<input type="button" class="clsSubmitButton" name="delete" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['photoManage_submit']; ?>
" onClick="if(getMultiCheckBoxValue('photo_manage_form2', 'check_all', '<?php echo $this->_tpl_vars['LANG']['photoManage_err_tip_select_photos']; ?>
'))  <?php echo ' { '; ?>
 getAction() <?php echo ' } '; ?>
" />
							&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="javascript:void(0)" id="dAltMlti"></a>
						</td>
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
			<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->list_photo_form['hidden_arr']); ?>

			</form>
	<?php else: ?>
    	<div id="selMsgSuccess">
        	<?php echo $this->_tpl_vars['LANG']['photoManage_no_records_found']; ?>

        </div>
	<?php endif; ?>
    </div>
<?php endif; ?>
</div>
<script>
<?php echo '
$Jq(document).ready(function() {
	'; ?>

	<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
	<?php $_from = $this->_tpl_vars['displayphotoList_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dalKey'] => $this->_tpl_vars['dalValue']):
?>
	<?php echo '

	$Jq(\'#previewPhoto_\'+'; ?>
<?php echo $this->_tpl_vars['dalValue']['record']['photo_id']; ?>
<?php echo ').fancybox({
		\'width\'				: 800,
		\'height\'			: 600,
		\'padding\'			:  0,
		\'autoScale\'     	: false,
		\'transitionIn\'		: \'none\',
		\'transitionOut\'		: \'none\',
		\'type\'				: \'iframe\'
	});
	'; ?>

	<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>
	<?php echo '
});
'; ?>

</script>