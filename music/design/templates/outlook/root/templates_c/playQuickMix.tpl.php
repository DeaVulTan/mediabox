<?php /* Smarty version 2.6.18, created on 2011-11-08 14:16:36
         compiled from playQuickMix.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'playQuickMix.tpl', 40, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_music_playlist_player')): ?>
						<div class="clsQuickMixContainer"> 
			 <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'playlist_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			 <div class="clsQuickMixPlayer">
<?php echo $this->_tpl_vars['myobj']->populatePlayerWithPlaylist($this->_tpl_vars['music_fields']); ?>

			</div>
			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'playlist_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			</div>
	<div class="clsButtonHolder clsPopupPlayerButtons"><p class="clsEditButton" id="save_quick_mix">
		<span class=""><a title="<?php echo $this->_tpl_vars['LANG']['common_save_quick_mix']; ?>
" href="javascript:void(0)" onclick="managePlaylist('<?php echo $this->_tpl_vars['myobj']->getFormField('music_id'); ?>
', '<?php echo $this->_tpl_vars['myobj']->savePlaylistUrl; ?>
', '<?php echo $this->_tpl_vars['LANG']['common_create_playlist']; ?>
');"><?php echo $this->_tpl_vars['LANG']['common_save_quick_mix']; ?>
</a></span>
	</p>
	<p class="clsDeleteButton"><span class="">
		<a href="javascript:void(0)" title="<?php echo $this->_tpl_vars['LANG']['common_quickmix_clear_all']; ?>
" onclick="quickMixClearAlert('<?php echo $this->_tpl_vars['LANG']['common_clear_all_err_msg']; ?>
');"><?php echo $this->_tpl_vars['LANG']['common_quickmix_clear_all']; ?>
</a>
	</span></p></div>
	<p id='anchor_id'>
<?php endif; ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_music_add_quickmix')): ?>
	<div id="redirectQuickMix" class="clsRedirectMessage">
		<div class="clsNoRecordsFound"><p><?php echo $this->_tpl_vars['LANG']['common_msg_no_quickmix_added']; ?>
&nbsp;&nbsp;<a href="javascript:void(0)" onclick="addQuickMixRedirect('<?php echo $this->_tpl_vars['myobj']->getUrl('musiclist','?pg=music_new','music_new/','','music'); ?>
')" title="<?php echo $this->_tpl_vars['LANG']['common_close']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_close']; ?>
</a></p></div>
		<!--<img src="" /></a>-->
	</div>
<?php endif; ?>
 <div id="selMsgQuickMixConfirmMulti" class="clsPopupConfirmation" style="display:none;">
        <p id="selQuickMixAlertLoginMessage"><?php echo $this->_tpl_vars['LANG']['sidebar_login_err_msg']; ?>
</p>
        <form name="msgQuickMixConfirmformMulti1" id="msgQuickMixConfirmformMulti1" method="post" action="" autocomplete="off">
          <input type="submit" class="clsSubmitButton" name="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="clearQuickMix();" /> &nbsp;
          <input type="button" class="clsSubmitButton" name="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hidingQuickMixBlocks()" />
        </form>
 </div>