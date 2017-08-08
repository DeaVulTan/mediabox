<?php /* Smarty version 2.6.18, created on 2011-10-19 10:46:51
         compiled from articleManage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'articleManage.tpl', 9, false),)), $this); ?>
<div id="articleManage">
  	<h2><span><?php echo $this->_tpl_vars['LANG']['articleManage_title']; ?>
</span></h2>
	<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
">
			<table summary="<?php echo $this->_tpl_vars['LANG']['articleManage_confirm_tbl_summary']; ?>
">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirmdel" id="confirmdel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['confirm']; ?>
" />
						&nbsp;
						<input type="button" class="clsSubmitButton" name="subcancel" id="subcancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['articleManage_cancel']; ?>
"  onClick="return hideAllBlocks();" />
						<input type="hidden" name="checkbox" id="checkbox" />
						<input type="hidden" name="action" id="action" />
						<input type="hidden" name="article_categories" id="article_categories" />
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

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_search')): ?>
	<div id="selShowSearchGroup">
		<form name="selFormSearch" id="selFormSearch" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
">
			<table border="1" cellspacing="0" summary="<?php echo $this->_tpl_vars['LANG']['articleManage_search_tbl_summary']; ?>
">
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('srch_uname'); ?>
"><label for="srch_uname"><?php echo $this->_tpl_vars['LANG']['articleManage_search_username']; ?>
</label></td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('srch_uname'); ?>
"><input type="text" class="clsTextBox" name="srch_uname" id="srch_uname" value="<?php echo $this->_tpl_vars['myobj']->getFormField('srch_uname'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/></td>
			</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('srch_title'); ?>
"><label for="srch_title"><?php echo $this->_tpl_vars['LANG']['articleManage_search_title']; ?>
</label></td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('srch_title'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('srch_title'); ?>
<input type="text" class="clsTextBox" name="srch_title" id="srch_title" value="<?php echo $this->_tpl_vars['myobj']->getFormField('srch_title'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/></td>
			</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('srch_flag'); ?>
"><label for="srch_flag"><?php echo $this->_tpl_vars['LANG']['articleManage_search_flaged']; ?>
</label></td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('srch_flag'); ?>
">
					<select name="srch_flag" id="srch_flag" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
						<option value=""><?php echo $this->_tpl_vars['LANG']['action_select']; ?>
</option>
						<option value="Yes" <?php if ($this->_tpl_vars['myobj']->getFormField('srch_flag') == 'Yes'): ?> SELECTED <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['articleManage_search_flag_yes']; ?>
</option>
						<option value="No" <?php if ($this->_tpl_vars['myobj']->getFormField('srch_flag') == 'No'): ?> SELECTED <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['articleManage_search_flag_no']; ?>
</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('srch_feature'); ?>
"><label for="srch_feature"><?php echo $this->_tpl_vars['LANG']['articleManage_search_featured']; ?>
</label></td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('srch_feature'); ?>
">
					<select name="srch_feature" id="srch_feature" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
						<option value=""><?php echo $this->_tpl_vars['LANG']['action_select']; ?>
</option>
						<option value="Yes" <?php if ($this->_tpl_vars['myobj']->getFormField('srch_feature') == 'Yes'): ?> SELECTED <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['articleManage_search_feature_yes']; ?>
</option>
						<option value="No" <?php if ($this->_tpl_vars['myobj']->getFormField('srch_feature') == 'No'): ?> SELECTED <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['articleManage_search_feature_no']; ?>
</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('srch_date_added'); ?>
"><label for="srch_date"><?php echo $this->_tpl_vars['LANG']['articleManage_search_date_created']; ?>
</label></td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('srch_date_added'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('srch_date_added'); ?>

					<select name="srch_date" id="srch_date" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
						<option value=""><?php echo $this->_tpl_vars['LANG']['articleManage_search_date']; ?>
</option>
						<?php echo $this->_tpl_vars['myobj']->populateBWNumbers(1,31,$this->_tpl_vars['myobj']->getFormField('srch_date')); ?>

					</select>
					<select name="srch_month" id="srch_month" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
						<option value=""><?php echo $this->_tpl_vars['LANG']['articleManage_search_month']; ?>
</option>
						<?php echo $this->_tpl_vars['myobj']->populateMonthsList($this->_tpl_vars['myobj']->getFormField('srch_month')); ?>

					</select>
					<select name="srch_year" id="srch_year" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
						<option value=""><?php echo $this->_tpl_vars['LANG']['articleManage_search_year']; ?>
</option>
						<?php echo $this->_tpl_vars['myobj']->populateBWNumbers(1920,$this->_tpl_vars['myobj']->current_year,$this->_tpl_vars['myobj']->getFormField('srch_year')); ?>

					</select>

				</td>
			</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('srch_categories'); ?>
"><label for="srch_categories"><?php echo $this->_tpl_vars['LANG']['articleManage_search_categories']; ?>
</label></td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('srch_categories'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('srch_categories'); ?>

					<select name="srch_categories" id="srch_categories" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
						<option value=""><?php echo $this->_tpl_vars['LANG']['action_select']; ?>
</option>
                        <?php echo $this->_tpl_vars['myobj']->populateArticleCategory($this->_tpl_vars['myobj']->getFormField('srch_categories')); ?>

					</select>
				</td>
			</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('articleManage_search'); ?>
" colspan="2"><input type="submit" class="clsSubmitButton" value="<?php echo $this->_tpl_vars['LANG']['articleManage_search']; ?>
" id="search" name="search" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/></td>
			</tr>
			</table>
			<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->form_search['hidden_arr']); ?>

		</form>
	</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_article_form')): ?>
    <div id="selArticleList">

	<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
		   	<form name="article_manage_form2" id="article_manage_form2" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">

            <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
            	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>
            	<p><b><?php echo $this->_tpl_vars['LANG']['common_article_note']; ?>
</b>&nbsp;<?php echo $this->_tpl_vars['LANG']['common_article_articlepreview_note']; ?>
</p>
			  	<table summary="<?php echo $this->_tpl_vars['LANG']['articleManage_tbl_summary']; ?>
">
					<tr>
						<th class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="CheckAll(document.article_manage_form2.name, document.article_manage_form2.check_all.name)"/></th>
						<th><?php echo $this->_tpl_vars['LANG']['article_article_id']; ?>
</th>
                        <th><?php echo $this->_tpl_vars['LANG']['common_article_article_title']; ?>
</th>
						<th><?php echo $this->_tpl_vars['LANG']['article_article_category']; ?>
</th>
                     <?php if ($this->_tpl_vars['CFG']['admin']['articles']['sub_category']): ?>
                        <th><?php echo $this->_tpl_vars['LANG']['article_article_sub_category']; ?>
</th>
                     <?php endif; ?>
						<th><?php echo $this->_tpl_vars['LANG']['article_user_name']; ?>
</th>
						<th><?php echo $this->_tpl_vars['LANG']['article_date_added']; ?>
</th>
						<th><?php echo $this->_tpl_vars['LANG']['article_option']; ?>
</th>
						<th><?php echo $this->_tpl_vars['LANG']['article_featured']; ?>
</th>
						<th>&nbsp;</th>
					</tr>
					<?php $_from = $this->_tpl_vars['displayarticleList_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dalKey'] => $this->_tpl_vars['dalValue']):
?>
						<tr>
							<td class="clsSelectAllItems"><input type='checkbox' name='checkbox[]' value="<?php echo $this->_tpl_vars['dalValue']['record']['article_id']; ?>
-<?php echo $this->_tpl_vars['dalValue']['record']['user_id']; ?>
" /></td>
							<td><?php echo $this->_tpl_vars['dalValue']['record']['article_id']; ?>
</td>
                            <td><a id="previewArticle_<?php echo $this->_tpl_vars['dalValue']['record']['article_id']; ?>
" href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/article/articlePreview.php?article_id=<?php echo $this->_tpl_vars['dalValue']['record']['article_id']; ?>
" class="lightwindow"><?php echo $this->_tpl_vars['dalValue']['record']['article_title']; ?>
</a></td>
							<td><?php echo $this->_tpl_vars['myobj']->getArticleCategory($this->_tpl_vars['dalValue']['record']['article_category_id']); ?>
</td>
                        <?php if ($this->_tpl_vars['CFG']['admin']['articles']['sub_category']): ?>
                            <td><?php echo $this->_tpl_vars['myobj']->getArticleCategory($this->_tpl_vars['dalValue']['record']['article_sub_category_id']); ?>
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
							<td>
								<!--a href="articleWriting.php?article_id=<?php echo $this->_tpl_vars['dalValue']['record']['article_id']; ?>
" class="clsPhotoArticleEditLinks" title="<?php echo $this->_tpl_vars['LANG']['articlelist_edit_article']; ?>
"><?php echo $this->_tpl_vars['LANG']['articlelist_edit_article']; ?>
</a><br/-->
								<a id="viewArticleComment_<?php echo $this->_tpl_vars['dalValue']['record']['article_id']; ?>
" href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/article/manageArticleComments.php?article_id=<?php echo $this->_tpl_vars['dalValue']['record']['article_id']; ?>
"  class="lightwindow"><?php echo $this->_tpl_vars['dalValue']['comments_text']; ?>
</a>
							</td>
						</tr>
                    <?php endforeach; endif; unset($_from); ?>
					<tr>
						<td colspan="9">
							<a href="#" id="dAltMlti"></a>
							<select name="article_options" id="article_options" tabindex="<?php echo smartyTabIndex(array(), $this);?>
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
" value="<?php echo $this->_tpl_vars['LANG']['articleManage_submit']; ?>
" onClick="if(getMultiCheckBoxValue('article_manage_form2', 'check_all', '<?php echo $this->_tpl_vars['LANG']['articleManage_err_tip_select_articles']; ?>
'))  <?php echo ' { '; ?>
 getAction() <?php echo ' } '; ?>
" />
							&nbsp;&nbsp;&nbsp;&nbsp;
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

			<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->list_article_form['hidden_arr']); ?>


			</form>
	<?php else: ?>
        <?php echo $this->_tpl_vars['LANG']['articleManage_no_records_found']; ?>

	<?php endif; ?>

    </div>
<?php endif; ?>
</div>
<script>
<?php echo '
$Jq(document).ready(function() {
	'; ?>

	<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
	<?php $_from = $this->_tpl_vars['displayarticleList_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dalKey'] => $this->_tpl_vars['dalValue']):
?>
	<?php echo '
	$Jq(\'#viewArticleComment_\'+'; ?>
<?php echo $this->_tpl_vars['dalValue']['record']['article_id']; ?>
<?php echo ').fancybox({
		\'width\'				: 900,
		\'height\'			: 750,
		\'padding\'			:  0,
		\'autoScale\'     	: false,
		\'transitionIn\'		: \'none\',
		\'transitionOut\'		: \'none\',
		\'type\'				: \'iframe\'
	});

	$Jq(\'#previewArticle_\'+'; ?>
<?php echo $this->_tpl_vars['dalValue']['record']['article_id']; ?>
<?php echo ').fancybox({
		\'width\'				: 900,
		\'height\'			: 750,
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