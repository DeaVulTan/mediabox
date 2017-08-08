<?php /* Smarty version 2.6.18, created on 2011-10-18 14:49:54
         compiled from mail.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'mail.tpl', 12, false),array('modifier', 'truncate', 'mail.tpl', 59, false),array('modifier', 'date_format', 'mail.tpl', 74, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_form_mail')): ?>
<div id="selMsgConfirm" class="clsPopupAlert" style="display:none;">
  <form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
    <p id="confirmMessage"></p>
        <!-- clsFormSection - starts here -->
    <div class="clsFormSection">

      <div class="clsFormRow">
        <div class="clsFormFieldCellDefault">
          <input type="submit" class="clsSubmitButton" name="confirm" id="confirm" value="<?php echo $this->_tpl_vars['LANG']['mail_confirm']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
          &nbsp;
          <input type="button" class="clsCancelButton" name="cancel" id="cancel" value="<?php echo $this->_tpl_vars['LANG']['mail_cancel']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="return hideAllBlocks('selFormMail');" />
          <input type="hidden" name="message_ids" />
          <input type="hidden" name="action" />
        </div>
      </div>
    </div>
    <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->msg_confirm_form['msg_confirm_form_hidden_arr']); ?>

    <!-- clsFormSection - ends here -->
  </form>
</div>
<?php endif; ?>

<div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['LANG']['mail_page_title']; ?>
</h2></div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_form_mail')): ?>
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('msg_form_success')): ?>
	  <div id="selMsgSuccess">
		 <p><?php echo $this->_tpl_vars['myobj']->getCommonSuccessMsg(); ?>
</p>
	  </div>
	<?php endif; ?>
 	<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
	  <div class="clsPaddingRightBottom">
    	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	  </div> 	
   	<?php endif; ?>
 	
<?php $this->assign('count', 1); ?>
<form name="selFormMail" id="selFormMail" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
<div class="clsDataTable clsMailDataTable">
	<table summary="<?php echo $this->_tpl_vars['LANG']['mail_tbl_summary']; ?>
">
		<tr>
			<th class="clsCheckBoxTD"><input type="checkbox" class="clsCheckRadio" id="checkall" onclick="selectAll(this.form)" name="checkall" value="" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></th>
			<th class="clsFromTitle"><?php echo $this->_tpl_vars['LANG']['sender_name_title']; ?>
</th>
			<th><?php echo $this->_tpl_vars['LANG']['mail_status']; ?>
</th>
			<th><?php echo $this->_tpl_vars['LANG']['mail_subject']; ?>
</th>
			<th><?php echo $this->_tpl_vars['LANG']['mail_date']; ?>
</th>
		</tr>
	<?php $_from = $this->_tpl_vars['populateMessages_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
		<tr class="<?php if ($this->_tpl_vars['count'] % 2 == 0): ?> clsAlternateRecord<?php endif; ?>">
			<td>
				<input type="checkbox" class="clsCheckBox" name="message_ids[]" value="<?php echo $this->_tpl_vars['populateMessages_arr'][$this->_tpl_vars['inc']]['from_id']; ?>
_<?php echo $this->_tpl_vars['populateMessages_arr'][$this->_tpl_vars['inc']]['to_id']; ?>
_<?php echo $this->_tpl_vars['populateMessages_arr'][$this->_tpl_vars['inc']]['info_id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="disableHeading('selFormMail')" />
			</td>
			<td class="clsMailMemberWidth">
				<div class="clsOverflow">
					<p class="clsFloatLeft"><a href="<?php echo $this->_tpl_vars['populateMessages_arr'][$this->_tpl_vars['inc']]['user_profile_url']; ?>
" class="ClsImageContainer ClsImageBorder2 Cls45x45">
						<img src="<?php echo $this->_tpl_vars['populateMessages_arr'][$this->_tpl_vars['inc']]['user_profiles_icon']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['populateMessages_arr'][$this->_tpl_vars['inc']]['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 4) : smarty_modifier_truncate($_tmp, 4)); ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['populateMessages_arr'][$this->_tpl_vars['inc']]['user_profiles_icon']['s_width'],$this->_tpl_vars['populateMessages_arr'][$this->_tpl_vars['inc']]['user_profiles_icon']['s_height']); ?>
/>
					</a>
				    </p>
					<p class="clsMailMember" id="selMemberName_<?php echo $this->_tpl_vars['inc']; ?>
">
					  <a href="<?php echo $this->_tpl_vars['populateMessages_arr'][$this->_tpl_vars['inc']]['user_profile_url']; ?>
"><?php echo $this->_tpl_vars['populateMessages_arr'][$this->_tpl_vars['inc']]['display_user_name']; ?>
</a>
					</p>
				</div>
			</td>
			<td class="clsMailStatusWidth">
				<span class="<?php echo $this->_tpl_vars['populateMessages_arr'][$this->_tpl_vars['inc']]['row_css']; ?>
"><?php echo $this->_tpl_vars['populateMessages_arr'][$this->_tpl_vars['inc']]['mail_status']; ?>
</span>
			</td>
			<td>
				<span class="clsMailTitle"><a href="<?php echo $this->_tpl_vars['populateMessages_arr'][$this->_tpl_vars['inc']]['mail_read_link']; ?>
"><?php echo $this->_tpl_vars['populateMessages_arr'][$this->_tpl_vars['inc']]['subject']; ?>
</a></span>
			</td>
			<td class="clsMailDateWidth">
				<p><?php echo ((is_array($_tmp=$this->_tpl_vars['populateMessages_arr'][$this->_tpl_vars['inc']]['mess_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_date_year']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_date_year'])); ?>
</p>
				<p><?php echo ((is_array($_tmp=$this->_tpl_vars['populateMessages_arr'][$this->_tpl_vars['inc']]['mess_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_time']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_time'])); ?>
</p>
			</td>
		</tr>
		<?php $this->assign('count', $this->_tpl_vars['count']+1); ?>
	 <?php endforeach; endif; unset($_from); ?>
	</table>
	 <div class="clsOverflow clsDataTableButton">
		<div class="clsMailSelectBox">
			<select name="action" id="action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
			<option value=""><?php echo $this->_tpl_vars['LANG']['mail_select_action']; ?>
&nbsp;&nbsp;</option>
			<?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['action_arr'],$this->_tpl_vars['myobj']->getFormField('action')); ?>

			</select>
		</div>			
		<div class="clsSubmitLeft">
			<div class="clsSubmitRight">
				<input type="button" name="mail_action" id="mail_action" onclick="<?php echo $this->_tpl_vars['mail_action_onclick']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['mail_action']; ?>
" />
			</div>
		</div>
      <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
      	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <?php endif; ?>
	</div>	
		<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->msg_confirm_form['selFormMail_hidden_arr']); ?>

		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/box.tpl', 'smarty_include_vars' => array('opt' => 'data_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</form>
  
  <?php endif; ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>