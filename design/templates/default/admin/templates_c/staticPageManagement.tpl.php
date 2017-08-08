<?php /* Smarty version 2.6.18, created on 2011-12-16 23:30:02
         compiled from staticPageManagement.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'staticPageManagement.tpl', 8, false),array('modifier', 'date_format', 'staticPageManagement.tpl', 129, false),)), $this); ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_sel_page_list')): ?>
<div id="selMsgConfirm" class="selMsgConfirm" style="display:none;">
 	<h3 id="confirmation_msg"></h3>
    <form name="deleteForm" id="deleteForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
    	    <!-- clsFormSection - starts here -->
    	<table class="clsFormSection clsNoBorder">
	  		<tr><td>
				  	<input type="submit" class="clsSubmitButton" name="delete_add" id="delete_add" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /> &nbsp;
				  	<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
" onClick="return hideAllBlocks();" />
         	</td></tr>
      	</table>
		<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->deleteForm_hidden_arr); ?>

    <!-- clsFormSection - ends here -->
    </form>
</div>
<div id="selCodeForm" class="clsPopupAlert" style="display:none;">
	<h3 id="codeTitle"></h3>
    <form name="codeForm" id="codeForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
	<!-- clsFormSection - starts here -->
    <table class="clsFormSection clsNoBorder">

            	<tr><td class="clsFormLabelCellDefault">
					<label for="addCode"><?php echo $this->_tpl_vars['LANG']['outside_the_static']; ?>
</label>
				</td>
				<td class="clsFormFieldCellDefault">
					<textarea name="addCode" id="addCode" rows="3" cols="75"  onfocus="this.select()" onclick="this.select()" readonly></textarea>
				</td></tr>
            	<tr><td class="clsFormLabelCellDefault">
					<label for="addCodeStatic"><?php echo $this->_tpl_vars['LANG']['inside_the_static']; ?>
</label>
				</td>
				<td class="clsFormFieldCellDefault">
					<textarea name="addCodeStatic" id="addCodeStatic" rows="3" cols="75"  onfocus="this.select()" onclick="this.select()" readonly></textarea>
				</td></tr>
            	<tr><td class="clsFormLabelCellDefault">
					<label for="addCodeTemplate"><?php echo $this->_tpl_vars['LANG']['code_template']; ?>
</label>
				</td>
				<td class="clsFormFieldCellDefault">
					<textarea name="addCodeTemplate" id="addCodeTemplate" rows="3" cols="75"  onfocus="this.select()" onclick="this.select()" readonly></textarea>
					<p><?php echo $this->_tpl_vars['LANG']['code_instruction']; ?>
</p>
				</td></tr>
         	</table>
    <!-- clsFormSection - ends here -->
     </form>
</div>
<?php endif; ?>
<div id="selStaticPgMgt">
	<h2><?php echo $this->_tpl_vars['LANG']['document_editor']; ?>
</h2>
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "information.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_document_editor')): ?>
	<div id="selDocumentEditor">
		<?php if ($this->_tpl_vars['CFG']['admin']['static_page_editor']): ?>
		<form name="frmDocumentEditor" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" method="post" onsubmit="return <?php if ($this->_tpl_vars['CFG']['feature']['html_editor'] == 'richtext'): ?>getHTMLSource('rte1', 'frmDocumentEditor', 'page_content');<?php else: ?>true<?php endif; ?>">
		<?php else: ?>
		<form name="frmDocumentEditor" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" method="post">
		<?php endif; ?>
			<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->frmDocumentEditor_hidden_arr); ?>

			<table class="clsFormSection clsNoBorder">
				<tr>
					<td colspan="2" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('page_content'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('page_content'); ?>

						<?php if ($this->_tpl_vars['CFG']['feature']['html_editor'] == 'tinymce'): ?>
    	                    <?php echo $this->_tpl_vars['myobj']->populateHtmlEditor('page_content'); ?>

                        <?php else: ?>
							<textarea name="page_content" id="page_content" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" cols="100" rows="15"><?php echo $this->_tpl_vars['myobj']->getFormField('page_content'); ?>
</textarea>
						<?php endif; ?>
						<?php if ($this->_tpl_vars['CFG']['feature']['html_editor'] == 'textarea'): ?>
							<p><?php echo $this->_tpl_vars['LANG']['put_the_html_code']; ?>
</p>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('page_name'); ?>
">
						<label for="pagename"><?php echo $this->_tpl_vars['LANG']['save_as']; ?>
</label>
					</td>
					<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('page_name'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('page_name'); ?>

						<input type="text" class="clsTextBox" name="page_name" id="pagename" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('page_name'); ?>
" />
                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('static_page_name','page_name'); ?>

					</td>
			   	</tr>
				<tr>
					<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('title'); ?>
">
						<label for="title"><?php echo $this->_tpl_vars['LANG']['label_title']; ?>
</label>
					</td>
					<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('title'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('title'); ?>

						<input type="text" class="clsTextBox" name="title" id="title" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('title'); ?>
" />
					<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('static_title','title'); ?>
</td>
			   	</tr>
				<tr>
					<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('status'); ?>
">
						<label for="status2"><?php echo $this->_tpl_vars['LANG']['status']; ?>
</label>
					</td>
					<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('status'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('status'); ?>

						<input type="radio" class="clsRadioButton" name="status" id="status2" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="Activate"<?php echo $this->_tpl_vars['myobj']->isCheckedRadio('status','Activate'); ?>
 /><label for="status2"><?php echo $this->_tpl_vars['LANG']['label_activate']; ?>
</label>&nbsp;
						<input type="radio" class="clsRadioButton" name="status" id="status3" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="Toactivate"<?php echo $this->_tpl_vars['myobj']->isCheckedRadio('status','Toactivate'); ?>
 /><label for="status3"><?php echo $this->_tpl_vars['LANG']['label_toactivate']; ?>
</label>
					 <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('static_status','status'); ?>
</td>
			   	</tr>
					<tr>
						<td colspan="2" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('default'); ?>
">
							<input type="submit" class="clsSubmitButton" name="document_submit" id="document_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['submit_document']; ?>
" />
						</td>
					</tr>
				</table>
			</form>
		</div>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_sel_page_list')): ?>
		<form name="selListStaticForm" id="selListStaticForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
			<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
				<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endif; ?>
	  		    <!-- clsDataDisplaySection - starts here -->

    <div class="clsDataDisplaySection">
	  				<table>
                    <tr>
                        <th><input type="checkbox" class="clsCheckBox" name="check_all" onclick= "CheckAll(document.selListStaticForm.name, document.selListStaticForm.check_all.name)" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></td>
                        <th class="<?php echo $this->_tpl_vars['myobj']->getOrderCss('page_name'); ?>
"><a href="#" onclick="return changeOrderbyElements('selListStaticForm','page_name')"><?php echo $this->_tpl_vars['LANG']['th_page_name']; ?>
</a></th>
                        <th class="<?php echo $this->_tpl_vars['myobj']->getOrderCss('title'); ?>
"><a href="#" onclick="return changeOrderbyElements('selListStaticForm','title')"><?php echo $this->_tpl_vars['LANG']['th_title']; ?>
</a></th>
                        <th class="<?php echo $this->_tpl_vars['myobj']->getOrderCss('status'); ?>
"><a href="#" onclick="return changeOrderbyElements('selListStaticForm','status')"><?php echo $this->_tpl_vars['LANG']['th_status']; ?>
</a></th>
                        <th class="<?php echo $this->_tpl_vars['myobj']->getOrderCss('date_added'); ?>
"><a href="#" onclick="return changeOrderbyElements('selListStaticForm','date_added')"><?php echo $this->_tpl_vars['LANG']['th_date_added']; ?>
</a></th>
                        <th>&nbsp;</th>
					</tr>
                <?php $_from = $this->_tpl_vars['populateStaticPagesList_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
					<tr class="clsDataRow <?php echo $this->_tpl_vars['myobj']->getCSSRowClass(); ?>
">
                        <td><input type="checkbox" class="clsCheckBox" name="page_name[]" value="<?php echo $this->_tpl_vars['populateStaticPagesList_arr'][$this->_tpl_vars['inc']]['page_name']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="disableHeading('selListStaticForm');"/></td>
                        <td><?php echo $this->_tpl_vars['populateStaticPagesList_arr'][$this->_tpl_vars['inc']]['page_name']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['populateStaticPagesList_arr'][$this->_tpl_vars['inc']]['title']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['populateStaticPagesList_arr'][$this->_tpl_vars['inc']]['status']; ?>
</td>
                        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['populateStaticPagesList_arr'][$this->_tpl_vars['inc']]['date_added'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_date_year']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_date_year'])); ?>
</td>
                        <td>
						<a id="<?php echo $this->_tpl_vars['populateStaticPagesList_arr'][$this->_tpl_vars['inc']]['page_name']; ?>
" href="#"></a>
						<a href="<?php echo $this->_tpl_vars['populateStaticPagesList_arr'][$this->_tpl_vars['inc']]['edit_link']; ?>
"><?php echo $this->_tpl_vars['LANG']['edit']; ?>
</a>
						<a id="code_<?php echo $this->_tpl_vars['populateStaticPagesList_arr'][$this->_tpl_vars['inc']]['page_name']; ?>
" href="#" onclick="return populateCode('<?php echo $this->_tpl_vars['populateStaticPagesList_arr'][$this->_tpl_vars['inc']]['page_name']; ?>
', '<?php echo $this->_tpl_vars['populateStaticPagesList_arr'][$this->_tpl_vars['inc']]['title']; ?>
')"><?php echo $this->_tpl_vars['LANG']['code']; ?>
</a>
						</td>
					</tr>
				<?php endforeach; endif; unset($_from); ?>
	  				<tr>
						<td colspan="6">
	  					<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->selListStaticForm_hidden_arr); ?>

	  					<input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['add_delete']; ?>
" onclick="<?php echo $this->_tpl_vars['delete_submit_onclick']; ?>
" />
	  					<input type="button" class="clsSubmitButton" name="activate_submit" id="activate_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['add_activate']; ?>
" onclick="<?php echo $this->_tpl_vars['activate_submit_onclick']; ?>
" />
	  					<input type="button" class="clsSubmitButton" name="toactivate_submit" id="toactivate_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['add_toactivate']; ?>
" onclick="<?php echo $this->_tpl_vars['inactivate_submit_onclick']; ?>
" />
	  					</td>
					</tr>
	  		   	</table>
	  		</div>

        <!-- clsDataDisplaySection - ends here -->
			<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
				<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endif; ?>
		</form>
		<?php endif; ?>
</div>