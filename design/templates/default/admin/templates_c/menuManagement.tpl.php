<?php /* Smarty version 2.6.18, created on 2011-10-19 10:46:01
         compiled from menuManagement.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'capitalize', 'menuManagement.tpl', 35, false),array('function', 'smartyTabIndex', 'menuManagement.tpl', 54, false),)), $this); ?>
<h2><?php echo $this->_tpl_vars['LANG']['menu_management']; ?>
</h2>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "information.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_menu_manage')): ?>
    <p class="clsPageLink"><a class="clsAdd" href="menuManagement.php?action=add"><?php echo $this->_tpl_vars['LANG']['add_menu']; ?>
</a></p>
    <p><?php echo $this->_tpl_vars['LANG']['menumanagement_note']; ?>
</p>
    <form id="reorder_form" method="post" name="reorder_form">
      	<table class="clsNoBorder">
	      		      	<tr>
	            <td><label for="visible_menu_count"><?php echo $this->_tpl_vars['LANG']['visible_menu_count']; ?>
</label></td>
	          	<td><input type="text" name="visible_menu_count" id="visible_menu_count" value="<?php echo $this->_tpl_vars['myobj']->getFormField('visible_menu_count'); ?>
" /></td>
	      	</tr>
			      	</table>
      	<h3><?php echo $this->_tpl_vars['LANG']['reordermenu']; ?>
</h3>
      	<div class="menuOrderSection">
      		<div class="workarea">
          		<ul class="draglist" id="ul1">
            		<?php $_from = $this->_tpl_vars['myobj']->menu_keys; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['menu_id']):
?>
                  		<li id="<?php echo $this->_tpl_vars['menu_id']; ?>
" class="list1"><?php echo ((is_array($_tmp=$this->_tpl_vars['myobj']->menu_arr[$this->_tpl_vars['menu_id']]['menu_name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</li>
            		<?php endforeach; endif; unset($_from); ?>
            	</ul>
      		</div>
	    </div>
	    <div id="user_actions" style="clear:left;">
		    <input type="submit" class="clsSubmitButton" name="update_order" value="<?php echo $this->_tpl_vars['LANG']['update']; ?>
" id="showButton" />
	    </div>
	    <input type="hidden" name="left" id="left" />
    </form>
<?php endif; ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_add_menu')): ?>
	<!-- Confirmation message block start-->
    <div id="selMsgConfirm" style="display:none;">
        <p id="confirmMessage"></p>
        <form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
            <table summary="">
                <tr><td>
                    <input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_confirm']; ?>
" />
                    &nbsp;
                    <input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
"  onClick="return hideAllBlocks('selFormForums');" />
                </td></tr>
            </table>
	        <input type="hidden" name="action" id="action" />
	        <input type="hidden" name="menu_id" id="menu_id" />
        </form>
    </div>
 	<!-- Confirmation message block end-->
	<form id="add_menu" method="post" name="add_menu" <?php if ($this->_tpl_vars['myobj']->getFormField('action') != 'edit'): ?> action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
?action=add <?php endif; ?>" >
		<input type="hidden" name="increament" value="" />
		<table class="clsNoBorder">
			<tr>
				<td class="clsWidthSmall <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('menu_name'); ?>
"><label for="menu_name"><?php echo $this->_tpl_vars['LANG']['menu_name']; ?>
</label><?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
</td>
			    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('menu_name'); ?>
"><input type="text" class="clsTextBox" name="menu_name" id="menu_name" value="<?php echo $this->_tpl_vars['myobj']->getFormField('menu_name'); ?>
"/><br /><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('menu_name'); ?>
</td>
			</tr>
            <tr>
				<td class="clsWidthSmall <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('class_name'); ?>
"><label for="class_name"><?php echo $this->_tpl_vars['LANG']['class_name']; ?>
</label><?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
</td>
			    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('class_name'); ?>
"><input type="text" class="clsTextBox" name="class_name" id="class_name" value="<?php if ($this->_tpl_vars['myobj']->getFormField('class_name')): ?><?php echo $this->_tpl_vars['myobj']->getFormField('class_name'); ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('default_class_name'); ?>
<?php endif; ?>"/><br /><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('class_name'); ?>
</td>
			</tr>
			<tr>
				<td class="clsWidthSmall"><label for="page_type"><?php echo $this->_tpl_vars['LANG']['menu_page_type']; ?>
</label></td>
			    <td><select name="page_type" id="page_type" onchange="showElement()">
			    	<option value='normal' <?php if ($this->_tpl_vars['myobj']->getFormField('page_type') == 'normal'): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['menu_normal_page']; ?>
</option>
			        <option value='static' <?php if ($this->_tpl_vars['myobj']->getFormField('page_type') == 'static'): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['menu_static_page']; ?>
</option>
			        <option value='external_link' <?php if ($this->_tpl_vars['myobj']->getFormField('page_type') == 'external_link'): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['menu_external_link']; ?>
</option>
			    </select>
			    <br /><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('page_type'); ?>

			    </td>
			</tr>
			<tr >
				<td id="pg_row_ext_label" <?php if ($this->_tpl_vars['myobj']->getFormField('page_type') == 'normal'): ?> style="display:none" <?php endif; ?>><label for="menu_page_name_static" id="pg_name"><?php echo $this->_tpl_vars['LANG']['menu_page_name']; ?>
</label></td>
			    <td id="pg_row_ext" <?php if ($this->_tpl_vars['myobj']->getFormField('page_type') == 'normal'): ?> style="display:none" <?php endif; ?>> <span id="normalspan" <?php if ($this->_tpl_vars['myobj']->getFormField('page_type') == 'static'): ?> style="display:none" <?php endif; ?> ><input type="text" class="clsTextBox" name="menu_page_name_normal" id="menu_page_name_normal" value="<?php echo $this->_tpl_vars['myobj']->getFormField('menu_page_name'); ?>
" /></span>
			    	<span id="staticspan" <?php if ($this->_tpl_vars['myobj']->getFormField('page_type') != 'static'): ?> style="display:none" <?php endif; ?> >
			        <select name="menu_page_name_static" id="menu_page_name_static" onchange="getStaticUrl()">
				        <option value=""><?php echo $this->_tpl_vars['LANG']['common_select_option']; ?>
</option>
				        <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->staticPage_arr,$this->_tpl_vars['myobj']->getFormField('menu_page_name')); ?>

					</select>
			        </span>
			            <br /><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('menu_page_name'); ?>

			        <span id="staticUrl">
			        </span>
			    </td>
			</tr>
			<tr>
				<td class="normal_elemtents" ><label for="menu_normal_query_string"><?php echo $this->_tpl_vars['LANG']['menu_normal_query_string']; ?>
</label><?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
</td>
			    <td class="normal_elemtents"><span><?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
&nbsp;</span><input type="text" class="clsTextBox" name="menu_normal_query_string" id="menu_normal_query_string" value="<?php echo $this->_tpl_vars['myobj']->getFormField('menu_normal_query_string'); ?>
"/>
			     <br /><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('menu_normal_query_string'); ?>

			    </td>
			</tr>
			<tr>
				<td class="normal_elemtents"><label for="menu_htaccess_query_string"><?php echo $this->_tpl_vars['LANG']['menu_htaccess_query_string']; ?>
</label><?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
</td>
			    <td class="normal_elemtents"><span><?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
&nbsp;</span><input type="text" class="clsTextBox" name="menu_htaccess_query_string" id="menu_htaccess_query_string" value="<?php echo $this->_tpl_vars['myobj']->getFormField('menu_htaccess_query_string'); ?>
"/>
			    <br /><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('menu_htaccess_query_string'); ?>

			    </td>
			</tr>
			<tr>
				<td class="normal_elemtents"><label for="menu_module"><?php echo $this->_tpl_vars['LANG']['menu_module']; ?>
</label></td>
			    <td class="normal_elemtents">
			    	<select  name="menu_module" id="menu_module" >
				    <option value=""<?php if (! $this->_tpl_vars['myobj']->getFormField('menu_module')): ?> selected <?php endif; ?>>General</option>
			        <?php $_from = $this->_tpl_vars['myobj']->module; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module']):
?>
			        <option value="<?php echo $this->_tpl_vars['module']; ?>
"<?php if ($this->_tpl_vars['module'] == $this->_tpl_vars['myobj']->getFormField('menu_module')): ?> selected <?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['module'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</option>
			        <?php endforeach; endif; unset($_from); ?>
			        </select>
			      </td>
			</tr>
			<tr>
				<td><label for="link_target"><?php echo $this->_tpl_vars['LANG']['menumanagement_link_open_in']; ?>
</label></td>
			    <td>
			    	<select  name="link_target" id="link_target" >
				    <option value=""<?php if (! $this->_tpl_vars['myobj']->getFormField('link_target')): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['menumanagement_link_open_in_same_window']; ?>
</option>
			        <option value="_blank" <?php if ($this->_tpl_vars['myobj']->getFormField('link_target') == '_blank'): ?> selected <?php endif; ?> ><?php echo $this->_tpl_vars['LANG']['menumanagement_link_open_in_new_window']; ?>
</option>
			        <option value="popup" <?php if ($this->_tpl_vars['myobj']->getFormField('link_target') == 'popup'): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['menumanagement_link_open_in_popup_window']; ?>
</option>
			        </select>
			      </td>
			</tr>
			<tr>
				<td><label for="menu_display"><?php echo $this->_tpl_vars['LANG']['menu_display']; ?>
</label></td>
			    <td><input type="checkbox" name="menu_display" id="menu_display" value="Y" <?php if ($this->_tpl_vars['myobj']->getFormField('menu_display') == 'Ok'): ?> checked <?php endif; ?> /></td>
			</tr>
			<tr>
				<td><label for="member_menu"><?php echo $this->_tpl_vars['LANG']['is_member_menu']; ?>
</label></td>
			    <td><input type="checkbox" name="member_menu" id="member_menu" value="Yes" <?php if ($this->_tpl_vars['myobj']->getFormField('member_menu') == 'Yes'): ?> checked <?php endif; ?> /></td>
			</tr>
			<tr>
				<td><label for="hide_member_menu"><?php echo $this->_tpl_vars['LANG']['is_member_hide_menu']; ?>
</label></td>
			    <td><input type="checkbox" name="hide_member_menu" id="hide_member_menu" value="Yes" <?php if ($this->_tpl_vars['myobj']->getFormField('hide_member_menu') == 'Yes'): ?> checked <?php endif; ?> /></td>
			</tr>
			<tr>
				<td><label for="is_module_home_page"><?php echo $this->_tpl_vars['LANG']['is_module_home_page']; ?>
</label></td>
			    <td><input type="checkbox" name="is_module_home_page" id="is_module_home_page" value="Yes" <?php if ($this->_tpl_vars['myobj']->getFormField('is_module_home_page') == 'Yes'): ?> checked <?php endif; ?> /></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" class="clsSubmitButton" name="menu_add_submit" <?php if ($this->_tpl_vars['myobj']->getFormField('action') == 'edit'): ?>value="<?php echo $this->_tpl_vars['LANG']['update']; ?>
" <?php else: ?>value="<?php echo $this->_tpl_vars['LANG']['add']; ?>
"<?php endif; ?> /></td>
			</tr>
		</table>
	</form>
	<?php if ($this->_tpl_vars['myobj']->menuDetail_arr): ?>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<th><?php echo $this->_tpl_vars['LANG']['menumangement_serial_no']; ?>
</th>
				<th><?php echo $this->_tpl_vars['LANG']['menumangement_menu_name']; ?>
</th>
				<th><?php echo $this->_tpl_vars['LANG']['menu_page_type']; ?>
</th>
				<th><?php echo $this->_tpl_vars['LANG']['menu_url']; ?>
</th>
				<th><?php echo $this->_tpl_vars['LANG']['menumangement_module']; ?>
</th>
				<th><?php echo $this->_tpl_vars['LANG']['menumangement_action']; ?>
</th>
			</tr>

			<?php $_from = $this->_tpl_vars['myobj']->menuDetail_arr; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['menu']):
?>
				<?php $this->assign('inc', $this->_tpl_vars['inc']+1); ?>
				<tr>
					<td><?php echo $this->_tpl_vars['inc']; ?>
</td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['menu']['menu_name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</td>
				    <td><?php echo $this->_tpl_vars['menu']['page_type']; ?>
</td><td>
				    <?php if ($this->_tpl_vars['menu']['file_name_static']['normal']): ?>
				    	<p><?php echo $this->_tpl_vars['LANG']['menu_normal_text']; ?>
: <a href="<?php echo $this->_tpl_vars['menu']['file_name_static']['normal']; ?>
"><?php echo $this->_tpl_vars['menu']['file_name_static']['normal']; ?>
</a></p><br />
				    	<p><?php echo $this->_tpl_vars['LANG']['menu_seo_text']; ?>
: <a href="<?php echo $this->_tpl_vars['menu']['file_name_static']['seo']; ?>
"><?php echo $this->_tpl_vars['menu']['file_name_static']['seo']; ?>
</a></p>
				    <?php else: ?>
					    <?php if ($this->_tpl_vars['menu']['file_name']): ?>
					    	<a href="<?php echo $this->_tpl_vars['menu']['file_name']; ?>
"><?php echo $this->_tpl_vars['menu']['file_name']; ?>
</a>
					    <?php else: ?>
					      	<p><?php echo $this->_tpl_vars['LANG']['menu_normal_text']; ?>
: <a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
<?php echo $this->_tpl_vars['menu']['normal_querystring']; ?>
"><?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
<?php echo $this->_tpl_vars['menu']['normal_querystring']; ?>
</a></p><br />
					    	<p><?php echo $this->_tpl_vars['LANG']['menu_seo_text']; ?>
: <a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
<?php echo $this->_tpl_vars['menu']['seo_querystring']; ?>
"><?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
<?php echo $this->_tpl_vars['menu']['seo_querystring']; ?>
</a></p>
					    <?php endif; ?>
				   	<?php endif; ?>
				    </td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['menu']['module'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</td><td><a href="menuManagement.php?action=edit&menu_id=<?php echo $this->_tpl_vars['menu']['id']; ?>
"><?php echo $this->_tpl_vars['LANG']['menumangement_edit']; ?>
</a>&nbsp;<a href="javascript:void(0);" onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('menu_id', 'action', 'confirmMessage'), Array('<?php echo $this->_tpl_vars['menu']['id']; ?>
', 'delete', '<?php echo $this->_tpl_vars['LANG']['menumangement_confirmation_message']; ?>
'), Array('value', 'value', 'innerHTML'), 0,0);" ><?php echo $this->_tpl_vars['LANG']['menumangement_delete']; ?>
</a></td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>

		</table>
	<?php else: ?>
		<h3><?php echo $this->_tpl_vars['LANG']['menumanagement_norecords_found']; ?>
</h3>
	<?php endif; ?>
<?php endif; ?>