<?php /* Smarty version 2.6.18, created on 2011-10-26 11:41:39
         compiled from photoFeaturedReorder.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'photoFeaturedReorder.tpl', 27, false),)), $this); ?>
<h2><span><?php echo $this->_tpl_vars['LANG']['photoManage_manage_featured_head_label']; ?>
</span></h2>
<?php if (! $this->_tpl_vars['myobj']->getFormField('type')): ?>
<p class="clsBackLink"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/photo/photoManage.php" ><?php echo $this->_tpl_vars['LANG']['common_photo_back']; ?>
</a></p>
<?php endif; ?>
<?php if ($this->_tpl_vars['myobj']->isResultsFound): ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="reOrder_playlist" class="clsSuccessMessages" style="display:none"><p><?php echo $this->_tpl_vars['LANG']['common_msg_reorder_featured_photo_list']; ?>
</p></div>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_photolist_player')): ?>
	<div class="clsPhotoList">
	<div class="clsPhotoListHeader">
		<div class="clsListHeading">
			<p><?php echo $this->_tpl_vars['LANG']['common_msg_drag_photos_playlist']; ?>
</p>
		</div>
		  <div class="clsHeaderButtonHolder">
			<p class="clsPopupSave" id="save_quick_mix">
				<input type="button" onclick="saveFeaturedPhotoDragDropNodes()" class="clsSubmitButton" value="Save">
				<!--<input type="button" onclick="feturedPhotoCancel();return false;" class="clsSubmitButton"value="Cancel">-->
			</p>
		  </div>
	</div>
	<form name="dragDropContainer_frm" id="dragDropContainer_frm" method="post" action="" autocomplete="off">
		<div id="dhtmlgoodies_dragDropContainer">
		<ul class="clsPhotoListContent clsDraglist" id="allItems" >
			<?php $this->assign('count', '0'); ?>
			<?php $_from = $this->_tpl_vars['myobj']->list_order_block['getOrganizePhotoList']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Key'] => $this->_tpl_vars['photolist']):
?>
			<?php echo smarty_function_counter(array('assign' => 'count'), $this);?>

				<div id="delete_<?php echo $this->_tpl_vars['photolist']['photo_id']; ?>
">
					<li id="<?php echo $this->_tpl_vars['photolist']['photo_id']; ?>
">
						<div class="clsTitles" id="draggable" >
							<p><?php if ($this->_tpl_vars['photolist']['photo_title'] != ''): ?><?php echo $this->_tpl_vars['photolist']['photo_title']; ?>
<?php endif; ?></p>
						</div>
						<input type="hidden" name="photo_id" id="photo_id" value="<?php echo $this->_tpl_vars['count']; ?>
_<?php echo $this->_tpl_vars['photolist']['photo_id']; ?>
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

	<div id="selMsgAlert" class="clsSuccessMessages">
		<p><?php echo $this->_tpl_vars['LANG']['sidebar_no_photo_found_error_msg']; ?>
</p>
	</div>

<?php endif; ?>

<div class="clsNote">
<?php echo $this->_tpl_vars['LANG']['photoManage_manage_featured_add_note']; ?>

<?php echo $this->_tpl_vars['LANG']['photoManage_manage_featured_add_note1']; ?>
<a href="#"  onclick="callPhotoHome();"><?php echo $this->_tpl_vars['LANG']['photoManage_manage_featured_add_note2']; ?>
</a><?php echo $this->_tpl_vars['LANG']['photoManage_manage_featured_add_note3']; ?>

</div>




<?php echo '
<script language="javascript">
	function callPhotoHome()
	{
		parent.location =\''; ?>
<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/photo/photoManage.php<?php echo '\';
	}
</script>
'; ?>