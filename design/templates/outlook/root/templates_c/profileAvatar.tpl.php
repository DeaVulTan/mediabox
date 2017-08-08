<?php /* Smarty version 2.6.18, created on 2011-10-25 11:53:09
         compiled from profileAvatar.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'profileAvatar.tpl', 12, false),array('modifier', 'replace', 'profileAvatar.tpl', 43, false),array('modifier', 'truncate', 'profileAvatar.tpl', 52, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selEditPersonalProfile">
<div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['LANG']['profileavatar_title_basic']; ?>
</h2></div>
  	<div id="selLeftNavigation">
 <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selMsgConfirm" class="clsPopupAlert" style="display:none;">
	  <form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
		<p id="confirmMessage"></p>
			<!-- clsFormSection - starts here -->
			  <input type="submit" class="clsSubmitButton" name="confirm" id="confirm" value="<?php echo $this->_tpl_vars['LANG']['common_confirm']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
			  &nbsp;
			  <input type="button" class="clsCancelButton" name="cancel" id="cancel" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="return hideAllBlocks();" />
		<input type="hidden" name="action" />
		<!-- clsFormSection - ends here -->
	  </form>
	</div>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_editprofile')): ?>
	<form name="selFormEditPersonalProfile" id="selFormEditPersonalProfile" enctype="multipart/form-data" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
		<div class="clsDataTable">
        <table summary="<?php echo $this->_tpl_vars['LANG']['profileavatar_tbl_summary']; ?>
" class="clsProfileEditTbl">
        	<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('user_image'); ?>
"><label for="user_image"><?php echo $this->_tpl_vars['LANG']['profileavatar_image']; ?>
</label></td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('user_image'); ?>
">
					<input type="file" class="clsFileBox" name="user_image" id="user_image" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/>
                    (<?php echo $this->_tpl_vars['CFG']['admin']['members_profile']['profile_image_max_size']; ?>
&nbsp;KB)<br />(<?php echo $this->_tpl_vars['myobj']->changeArrayToCommaSeparator($this->_tpl_vars['CFG']['admin']['members_profile']['image_format_arr']); ?>
)<br />
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('user_image'); ?>

				</td>
			</tr>
		   	<tr>
				<td>&nbsp;</td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
">
					<div class="clsSubmitLeft"><div class="clsSubmitRight">
						<input type="submit" class="clsSubmitButton" name="editprofile_submit" id="editprofile_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['profileavatar_submit']; ?>
" />
					</div>
				</td>
		   	</tr>
		   	<?php if (isset ( $this->_tpl_vars['CFG']['admin']['module']['cam_profile_avatar'] ) && $this->_tpl_vars['CFG']['admin']['module']['cam_profile_avatar']): ?>
		   	<tr>
				<td>&nbsp;</td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
">
					<strong><?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['profileavatar_captured_images'])) ? $this->_run_mod_handler('replace', true, $_tmp, 'link', $this->_tpl_vars['myobj']->getUrl('profilecamavatar')) : smarty_modifier_replace($_tmp, 'link', $this->_tpl_vars['myobj']->getUrl('profilecamavatar'))); ?>
</strong>
				</td>
		   	</tr>
		   	<?php endif; ?>
		   	<?php if ($this->_tpl_vars['myobj']->avatar_image_exists): ?>
		   	<tr>
		   		<td>&nbsp;</td>
           		<td>
           		<a class="ClsImageContainer ClsImageBorder2 Cls90x90" href="<?php echo $this->_tpl_vars['myobj']->getUserDetail('user_id',$this->_tpl_vars['CFG']['user']['user_id'],'profile_url'); ?>
">
					<img src="<?php echo $this->_tpl_vars['myobj']->icon['t_url']; ?>
?<?php echo time() ?>" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['CFG']['user']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 9) : smarty_modifier_truncate($_tmp, 9)); ?>
" title="<?php echo $this->_tpl_vars['CFG']['user']['user_name']; ?>
" border="0" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['image_thumb_width'],$this->_config[0]['vars']['image_thumb_height'],$this->_tpl_vars['myobj']->icon['t_width'],$this->_tpl_vars['myobj']->icon['t_height']); ?>
/>
				</a>
               	</td>
		   	</tr>
		   	<tr>
		   		<td>&nbsp;</td>
		   		<td>
					<a onClick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('action', 'confirmMessage'), Array('delete_avatar', '<?php echo $this->_tpl_vars['LANG']['profileavatar_delete_confirmation']; ?>
'), Array('value', 'innerHTML'))"><?php echo $this->_tpl_vars['LANG']['profileavatar_delete_image']; ?>
</a>
               	</td>
		   	</tr>
		   	<?php endif; ?>
		</table>
        </div>
	</form>
<?php endif; ?>	</div>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>