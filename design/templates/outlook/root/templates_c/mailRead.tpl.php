<?php /* Smarty version 2.6.18, created on 2011-10-31 10:32:35
         compiled from mailRead.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'mailRead.tpl', 15, false),array('modifier', 'truncate', 'mailRead.tpl', 44, false),array('modifier', 'date_format', 'mailRead.tpl', 55, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clsMessageDisplay">
  <div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['LANG']['mailread_page_title']; ?>
</h2></div>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_form_show_message')): ?>
	<!-- Confirmation Div -->
	<div id="selMsgConfirm" class="clsPopupAlert" style="display:none;">
	  <form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
		<p id="confirmMessage"></p>
			<!-- clsFormSection - starts here -->
		<div class="clsFormSection">
		 <div class="clsFormRow">
			<div class="clsFormLabelCellDefault">
			  <input type="submit" class="clsSubmitButton" name="confirm" id="confirm" value="<?php echo $this->_tpl_vars['LANG']['common_confirm']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
			  &nbsp;
			  <input type="button" class="clsCancelButton" name="cancel" id="cancel" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="return hideAllBlocks();" />
			  <input type="hidden" name="action" />
			</div>
		  </div>
		</div>
		<!-- clsFormSection - ends here -->
	  </form>
	</div>
<?php endif; ?>

  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('members/'); ?>

  <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_form_show_message')): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'mail_message_header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <div class="clsDataTable">
  <table>
  			 <tr>
             		<?php if ($this->_tpl_vars['myobj']->getFormField('folder') != 'sent'): ?>
                  <th class="clsFromTitle"><?php echo $this->_tpl_vars['LANG']['mailread_from']; ?>
</th>
                   <?php else: ?>
                   <th class="clsFromTitle"><?php echo $this->_tpl_vars['LANG']['mailread_to']; ?>
</th>
                   <?php endif; ?>
                  <th><?php echo $this->_tpl_vars['LANG']['mailread_message']; ?>
</th>
               </tr>
          <tr>
            <td id="selPhotoGallery" class="clsMailMemberWidth">
             	<div class="clsOverflow"><p class="clsViewThumbImage"><a href="<?php echo $this->_tpl_vars['mail_details_arr']['user_profiles_link']; ?>
" class="ClsImageContainer ClsImageBorder2 Cls45x45">
                   <img src="<?php echo $this->_tpl_vars['mail_details_arr']['user_profiles_icon']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['mail_details_arr']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 4) : smarty_modifier_truncate($_tmp, 4)); ?>
" title="<?php echo $this->_tpl_vars['mail_details_arr']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['mail_details_arr']['user_profiles_icon']['s_width'],$this->_tpl_vars['mail_details_arr']['user_profiles_icon']['s_height']); ?>
 />
                 </a></p></div>
                 <p class="clsMailUserLink">
                <a href="<?php echo $this->_tpl_vars['mail_details_arr']['user_profiles_link']; ?>
">
                <?php echo $this->_tpl_vars['mail_details_arr']['display_user_name']; ?>

                </a></p>


            </td>
            <td class="clsMessageDetailSection">
            <p>
            <span class="clsImageReSize"> <?php echo $this->_tpl_vars['LANG']['mailread_date']; ?>
 </span> <?php echo ((is_array($_tmp=$this->_tpl_vars['mail_details_arr']['mess_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_date_year']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_date_year'])); ?>
&nbsp;&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['mail_details_arr']['mess_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_time']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_time'])); ?>

            </p>
            <p>
            <span class="clsBold"><?php echo $this->_tpl_vars['LANG']['mailread_subject']; ?>
 </span> <?php echo $this->_tpl_vars['mail_details_arr']['subject']; ?>

            </p>
            <p><?php echo $this->_tpl_vars['mail_details_arr']['message']; ?>
</p>

            </td>
          </tr>

  </table>
  </div>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'mail_message_header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>