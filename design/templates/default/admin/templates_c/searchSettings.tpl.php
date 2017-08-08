<?php /* Smarty version 2.6.18, created on 2011-10-19 10:47:27
         compiled from searchSettings.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'searchSettings.tpl', 12, false),array('modifier', 'ucfirst', 'searchSettings.tpl', 38, false),)), $this); ?>
<div id="searchSetting">
  <h2><?php echo $this->_tpl_vars['LANG']['searchsettings_title']; ?>
</h2>
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "information.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
     <!-- confirmation box -->
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
			<table summary="<?php echo $this->_tpl_vars['LANG']['confirm_tbl_summary']; ?>
">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_confirm']; ?>
" />
						&nbsp;
						<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
"  onClick="return hideAllBlocks('selFormForums');" />
					</td>
				</tr>
			</table>
			<input type="hidden" name="id" id="id" />
			<input type="hidden" name="action" id="action" />
			<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_arr); ?>

		</form>
	</div>
    <!-- confirmation box-->
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_search_settings_block')): ?>
    <form name="selFormAnnouncement" id="selFormAnnouncement" method="post" action="announcement.php">
        <table width="200" cellpadding="2" cellspacing="4">
          <tr>
            <th><?php echo $this->_tpl_vars['LANG']['searchsettings_label']; ?>
</th>
            <th><?php echo $this->_tpl_vars['LANG']['searchsettings_moduel']; ?>
</th>
            <th><?php echo $this->_tpl_vars['LANG']['searchsettings_priority']; ?>
</th>
            <th><?php echo $this->_tpl_vars['LANG']['searchsettings_default_search']; ?>
</th>
            <th><?php echo $this->_tpl_vars['LANG']['searchsettings_status']; ?>
</th>

          </tr>
           <?php if ($this->_tpl_vars['myobj']->list_search_settings_block['populateSearchSettings']['record_count']): ?>
              <?php $_from = $this->_tpl_vars['myobj']->list_search_settings_block['populateSearchSettings']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['searchKey'] => $this->_tpl_vars['searchValue']):
?>
                  <tr>
                    <td><?php echo ((is_array($_tmp=$this->_tpl_vars['searchValue']['record']['label'])) ? $this->_run_mod_handler('ucfirst', true, $_tmp) : ucfirst($_tmp)); ?>
</td>
                    <td><?php echo ((is_array($_tmp=$this->_tpl_vars['searchValue']['record']['module'])) ? $this->_run_mod_handler('ucfirst', true, $_tmp) : ucfirst($_tmp)); ?>
</td>
                    <td>
                        <a href="?action=priority&id=<?php echo $this->_tpl_vars['searchValue']['record']['id']; ?>
&priority=<?php echo $this->_tpl_vars['searchValue']['record']['priority']; ?>
&opt=up">
                   	 	<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/admin/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/uparrow.gif" title="<?php echo $this->_tpl_vars['LANG']['searchsettings_up']; ?>
" /></a>&nbsp;&nbsp;&nbsp;
                        <a href="?action=priority&id=<?php echo $this->_tpl_vars['searchValue']['record']['id']; ?>
&priority=<?php echo $this->_tpl_vars['searchValue']['record']['priority']; ?>
&opt=down">
                        	<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/admin/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/downarrow.gif" title="<?php echo $this->_tpl_vars['LANG']['searchsettings_dowm']; ?>
"/>                        </a>                   </td>
              <td>
                    	<?php if ($this->_tpl_vars['searchValue']['record']['default_search']): ?>
                        	<?php echo $this->_tpl_vars['LANG']['searchsettings_default_yes']; ?>

                        <?php else: ?>
                        	<a href="#" onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('id', 'action', 'confirmMessage'), Array('<?php echo $this->_tpl_vars['searchValue']['record']['id']; ?>
', 'default_search', '<?php echo $this->_tpl_vars['LANG']['searchsettings_default_confirm_message']; ?>
'), Array('value', 'value', 'innerHTML'), -25, -290);"><?php echo $this->_tpl_vars['LANG']['searchsettings_default_no']; ?>
</a>
                        <?php endif; ?>

                    </td>
                    <td>
                    	<?php if ($this->_tpl_vars['searchValue']['record']['status'] == 'No'): ?>
                        	<a href="#" onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('id', 'action', 'status', 'confirmMessage'), Array('<?php echo $this->_tpl_vars['searchValue']['record']['id']; ?>
', 'status', 'Yes', '<?php echo $this->_tpl_vars['LANG']['searchsettings_active_confirm_message']; ?>
'), Array('value', 'value', 'value', 'innerHTML'), -25, -290);"><?php echo $this->_tpl_vars['LANG']['searchsettings_active']; ?>
</a>
                    	<?php else: ?>
                        	<a href="#" onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('id', 'action', 'status', 'confirmMessage'), Array('<?php echo $this->_tpl_vars['searchValue']['record']['id']; ?>
', 'status', 'No', '<?php echo $this->_tpl_vars['LANG']['searchsettings_inactive_confirm_message']; ?>
'), Array('value', 'value', 'value', 'innerHTML'), -25, -290);"><?php echo $this->_tpl_vars['LANG']['searchsettings_inactive']; ?>
</a>
                        <?php endif; ?>
                    </td>

                  </tr>
              <?php endforeach; endif; unset($_from); ?>
          <?php else: ?>
          <tr>
            <td colspan="5"><?php echo $this->_tpl_vars['LANG']['searchsettings_norecords_found']; ?>
</td>
          </tr>
          <?php endif; ?>
        </table>
  </form>
  <?php endif; ?>
</div>