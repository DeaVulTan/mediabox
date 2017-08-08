<?php /* Smarty version 2.6.18, created on 2011-12-23 02:11:53
         compiled from friendAdd.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'friendAdd.tpl', 25, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div id="selFormAddFriend">
		<div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['LANG']['addfriend_title']; ?>
</h2></div>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_member_blocked')): ?>
    <div id="selMsgAlert">
        <p><?php echo $this->_tpl_vars['LANG']['addfriend_msg_blocked']; ?>
&nbsp;<a href="<?php echo $this->_tpl_vars['myobj']->form_member_blocked['memberProfileUrl']; ?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('friend_name'); ?>
</a></p>
        <p class="clsMsgAdditionalText"><?php echo $this->_tpl_vars['LANG']['addfriend_msg_blocked_hint']; ?>
</p>
        <p class="clsMsgAdditionalText"><a href="<?php echo $this->_tpl_vars['myobj']->form_member_blocked['memberblock_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['addfriend_link_unblock']; ?>
&nbsp;<?php echo $this->_tpl_vars['myobj']->getFormField('friend_name'); ?>
</a></p>
        <p class="clsMsgAdditionalText"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('memberblock','','','members'); ?>
"><?php echo $this->_tpl_vars['LANG']['addfriend_link_block_list']; ?>
</a></p>
    </div>
<?php endif; ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_confirmation')): ?>
		<form id="formAddFriend" name="formAddFriend" method="post" action="<?php echo $this->_tpl_vars['myobj']->getUrl('friendadd','','','members'); ?>
">
		<div class="clsPadding10">
			<p class="clsBold"><?php echo $this->_tpl_vars['LANG']['addfriend_msg_1']; ?>
<span class="clsUser"><?php echo $this->_tpl_vars['myobj']->getFormField('friend_name'); ?>
</span><?php echo $this->_tpl_vars['LANG']['addfriend_msg_2']; ?>
</p>
			<div class="clsDataTable">
            <table>
				<tr>
					<td id="selPhotoGallery">
                        <div class="clsOverflow">
							<a class="ClsImageContainer ClsImageBorder1 Cls90x90" href="<?php echo $this->_tpl_vars['myobj']->form_confirmation_arr['user_details']['profile_url']; ?>
"><img src="<?php echo $this->_tpl_vars['myobj']->form_confirmation_arr['icon']['t_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['myobj']->getFormField('friend_name'))) ? $this->_run_mod_handler('truncate', true, $_tmp, 9) : smarty_modifier_truncate($_tmp, 9)); ?>
"  title="<?php echo $this->_tpl_vars['myobj']->getFormField('friend_name'); ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['image_thumb_width'],$this->_config[0]['vars']['image_thumb_height'],$this->_tpl_vars['myobj']->form_confirmation_arr['icon']['t_width'],$this->_tpl_vars['myobj']->form_confirmation_arr['icon']['t_height']); ?>
 /></a>
                        </div>
                        <p><a href="<?php echo $this->_tpl_vars['myobj']->form_confirmation_arr['user_details']['profile_url']; ?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('friend_name'); ?>
</a></p>
					</td>
				</tr>
				<tr>
					<td>
						(<?php echo $this->_tpl_vars['LANG']['addfriend_optional_message']; ?>
)<br/>
						<textarea class="clsAddFriendsTextArea selInputLimiter" rows="4" cols="40" id="user_message" name="user_message" maxlimit="<?php echo $this->_tpl_vars['CFG']['fieldsize']['friendadd']['description']; ?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('user_message'); ?>
</textarea>
						<input type="hidden" name="backUrl" value="<?php echo $this->_tpl_vars['myobj']->getFormField('backUrl'); ?>
" />
						<input type="hidden" name="friend_name" value="<?php echo $this->_tpl_vars['myobj']->getFormField('friend_name'); ?>
" />
						<input type="hidden" name="friend" value="<?php echo $this->_tpl_vars['myobj']->getFormField('friend'); ?>
" />
					</td>
				</tr>
				<tr>
					<td>
						<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="confirmSubmit" id="confirmSubmit" value="<?php echo $this->_tpl_vars['LANG']['addfriend_submit_send']; ?>
" /></div></div><div class="clsCancelLeft clsMarginLeft5"><div class="clsCancelRight"><input type="submit" class="clsSubmitButton" name="cancel" id="cancel" value="<?php echo $this->_tpl_vars['LANG']['addfriend_submit_cancel']; ?>
" /></div></div></td>
				</tr>
			</table>
            </div>
		</div>
		</form>
	</div>
<?php endif; ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>