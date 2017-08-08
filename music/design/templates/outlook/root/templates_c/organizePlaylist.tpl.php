<?php /* Smarty version 2.6.18, created on 2012-01-21 07:09:07
         compiled from organizePlaylist.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'organizePlaylist.tpl', 21, false),array('function', 'smartyTabIndex', 'organizePlaylist.tpl', 49, false),)), $this); ?>
<?php if ($this->_tpl_vars['myobj']->isResultsFound): ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
var clsSuccessMessage = "clsSuccessMessage";
var clsErrorMessage = "clsErrorMessage";
</script>
	<div id="organize_playlist" style="display:none"></div>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_playlist_player')): ?>
	<div class="clsSongList">
	<div class="clsSongListHeader">
		<div class="clsListHeading">
			<p><?php echo $this->_tpl_vars['LANG']['common_msg_drag_songs_playlist']; ?>
</p>
		</div>
	</div>
	<form name="dragDropContainer_frm" id="dragDropContainer_frm" method="post" action="" autocomplete="off">
		<div id="dhtmlgoodies_dragDropContainer">
		<ul class="clsSongListContent clsDraglist" id="allItems" >
			<?php $this->assign('count', '0'); ?>
			<?php $_from = $this->_tpl_vars['myobj']->list_playlist_block['getOrganizePlaylistList']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['musicAlbumlistKey'] => $this->_tpl_vars['musicalbumlist']):
?>
			<?php echo smarty_function_counter(array('assign' => 'count'), $this);?>

				<div id="delete_<?php echo $this->_tpl_vars['musicalbumlist']['music_id']; ?>
">
					<li id="<?php echo $this->_tpl_vars['musicalbumlist']['music_id']; ?>
">
						<div class="clsTakeOut" >
							<a href="javascript:void(0);" onclick="deletePlaylistSongsInPlayer('<?php echo $this->_tpl_vars['musicalbumlist']['playlist_id']; ?>
','<?php echo $this->_tpl_vars['musicalbumlist']['music_id']; ?>
');" title="<?php echo $this->_tpl_vars['LANG']['common_delete']; ?>
"></a>
						</div>
						<div class="clsTitles" id="draggable" >
							<p style="padding:12px 0"><?php if ($this->_tpl_vars['musicalbumlist']['music_title'] != ''): ?><?php echo $this->_tpl_vars['musicalbumlist']['music_title']; ?>
<?php endif; ?></p>
						</div>
						<input type="hidden" name="music_id" id="music_id" value="<?php echo $this->_tpl_vars['count']; ?>
_<?php echo $this->_tpl_vars['musicalbumlist']['music_id']; ?>
"/>
						<input type="hidden" name="play_list_order_id" id="play_list_order_id" value="<?php echo $this->_tpl_vars['count']; ?>
"/>
					</li>
				</div>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
		</div>
	</form>
	</div>
<?php endif; ?>
<?php else: ?>
	<div id="selMsgAlert">
		<p><?php echo $this->_tpl_vars['LANG']['common_msg_no_playlist_song_added']; ?>
</p>
	</div>
<?php endif; ?>
<div id="selMsgPlaylistConfirmMulti" class="clsPopupConfirmation" style="display:none;">
	<p id="selPlaylistAlertLoginMessage"><?php echo $this->_tpl_vars['LANG']['sidebar_login_err_msg']; ?>
</p>
	<form name="msgPlaylistConfirmformMulti1" id="msgQuickMixConfirmformMulti1" method="post" action="" autocomplete="off">
		<input type="button" class="clsSubmitButton" name="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="clearAllPlaylistId('<?php echo $this->_tpl_vars['myobj']->getFormField('playlist_id'); ?>
');"/> &nbsp;
		<input type="button" class="clsSubmitButton" name="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hidingPlayListBlocks();" />
	</form>
</div>





