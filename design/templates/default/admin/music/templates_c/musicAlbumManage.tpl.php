<?php /* Smarty version 2.6.18, created on 2011-10-17 15:09:02
         compiled from musicAlbumManage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'musicAlbumManage.tpl', 9, false),)), $this); ?>
<div id="selmusicList">
  	<h2><span><?php echo $this->_tpl_vars['LANG']['musicAlbumManage_title']; ?>
</span></h2>
	<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
			<table summary="<?php echo $this->_tpl_vars['LANG']['musicAlbumManage_confirm_tbl_summary']; ?>
">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirmdel" id="confirmdel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['confirm']; ?>
" />
						&nbsp;
						<input type="button" class="clsSubmitButton" name="subcancel" id="subcancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['musicAlbumManage_cancel']; ?>
"  onclick="return hideAllBlocks();" />
						<input type="hidden" name="checkbox" id="checkbox" />
						<input type="hidden" name="action" id="action" />
						<input type="hidden" name="music_categories" id="music_categories" />
						<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_arr); ?>

					</td>
				</tr>
			</table>
		</form>
	</div>
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_music_album_form')): ?>
    <div id="selMusicAlbumList">
		<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
		<form name="music_album_form" id="music_album_form" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">

            <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
            	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>
		  	<table summary="<?php echo $this->_tpl_vars['LANG']['musicAlbumManage_tbl_summary']; ?>
">
				<tr>
					<th class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="CheckAll(document.music_album_form.name, document.music_album_form.check_all.name)"/></th>
					<th><?php echo $this->_tpl_vars['LANG']['musicAlbumManage_album_id']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['LANG']['musicAlbumManage_album_title']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['LANG']['musicAlbumManage_total_music']; ?>
</th>
					<th><?php echo $this->_tpl_vars['LANG']['musicAlbumManage_access_type']; ?>
</th>
					<th><?php echo $this->_tpl_vars['LANG']['album_user_name']; ?>
</th>
                    <?php if ($this->_tpl_vars['CFG']['admin']['musics']['allowed_usertypes_to_upload_for_sale'] != 'None'): ?>
					<th><?php echo $this->_tpl_vars['LANG']['album_price']; ?>
</th>
                    <?php endif; ?>
					<th><?php echo $this->_tpl_vars['LANG']['album_featured']; ?>
</th>
				</tr>
				<?php $_from = $this->_tpl_vars['displayalbumList_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dalKey'] => $this->_tpl_vars['dalValue']):
?>
				<tr>
					<td class="clsSelectAllItems"><input type='checkbox' name='checkbox[]' value="<?php echo $this->_tpl_vars['dalValue']['record']['music_album_id']; ?>
-<?php echo $this->_tpl_vars['dalValue']['record']['user_id']; ?>
" onclick="disableHeading('music_album_form');"/></td>
					<td>
                       	<?php echo $this->_tpl_vars['dalValue']['record']['music_album_id']; ?>

                    </td>
                    <td>
                       	<?php echo $this->_tpl_vars['dalValue']['record']['album_title']; ?>

                    </td>
					<td>
						<?php echo $this->_tpl_vars['dalValue']['record']['total_music']; ?>

					</td>
					<td><?php echo $this->_tpl_vars['dalValue']['record']['album_access_type']; ?>
</td>
					<td><?php echo $this->_tpl_vars['dalValue']['name']; ?>
</td>
                    <?php if ($this->_tpl_vars['CFG']['admin']['musics']['allowed_usertypes_to_upload_for_sale'] != 'None'): ?>
					<td><?php echo $this->_tpl_vars['dalValue']['record']['album_price']; ?>
</td>
                    <?php endif; ?>
					<td><?php echo $this->_tpl_vars['dalValue']['record']['album_featured']; ?>
</td>
				</tr>
                <?php endforeach; endif; unset($_from); ?>
				<tr>
					<td colspan="7">
						<a href="javascript:void(0)" id="dAltMlti"></a>
						<select name="album_options" id="album_options" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
							<option value=""><?php echo $this->_tpl_vars['LANG']['action_select']; ?>
</option>
							<option value="Featured"><?php echo $this->_tpl_vars['LANG']['action_featured']; ?>
</option>
							<option value="UnFeatured"><?php echo $this->_tpl_vars['LANG']['action_unfeatured']; ?>
</option>
						</select>&nbsp;
						<input type="button" class="clsSubmitButton" name="delete" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['musicAlbumManage_submit']; ?>
" onclick="if(getMultiCheckBoxValue('music_album_form', 'check_all', '<?php echo $this->_tpl_vars['LANG']['musicAlbumManage_err_tip_select_albums']; ?>
'))  <?php echo ' { '; ?>
 getAction() <?php echo ' } '; ?>
" />
						&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="javascript:void(0)" id="dAltMlti"></a>
					</td>
				</tr>
			</table>
            <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
            	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>
			<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->list_music_form['hidden_arr']); ?>

		</form>
		<?php else: ?>
    	<div id="selMsgSuccess">
        	<?php echo $this->_tpl_vars['LANG']['musicAlbumManage_no_records_found']; ?>

        </div>
		<?php endif; ?>
    </div>
	<?php endif; ?>
</div>