<?php /* Smarty version 2.6.18, created on 2011-10-18 17:04:09
         compiled from getSlidelist.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'getSlidelist.tpl', 23, false),)), $this); ?>
<?php if (! isAjaxPage ( )): ?>
<script type="text/javascript">
	var selectionError ="<?php echo $this->_tpl_vars['LANG']['playlist_selection_error']; ?>
";
	var invalidPlaylist="<?php echo $this->_tpl_vars['LANG']['playlist_invalid']; ?>
";
</script>
<div id="loginDiv" class="clsDisplayNone clsTextAlignLeft clsPlaylistLabelPopup">
</div>
<div id="playlistDiv" class="clsDisplayNone clsTextAlignLeft clsPlaylistLabelPopup">
	<div class="clsOverflow">
    	<div class="clsFlagTitle"><?php echo $this->_tpl_vars['LANG']['photoslidelist_label']; ?>
</div>
	</div>
    <div id="clsMsgDisplay_playlist_failure" class="clsDisplayNone clsPlaylistSuccess"></div>
    <div id="playlistFrmDiv" class="clsFlagTable">
        <input type="hidden" name="playlist_access_type" id="playlist_access_type" value="<?php echo $this->_tpl_vars['myobj']->getFormField('playlist_access_type'); ?>
" />
       	<div class="clsRow" id="selMyPlayListOpt">
<?php endif; ?>
<?php if (isAjaxPage ( )): ?>
<script type="text/javascript">
	var photo_id ="<?php echo $this->_tpl_vars['myobj']->getFormField('photo_id'); ?>
";
</script>
    	    <div class="clsTDLabel"><?php echo $this->_tpl_vars['LANG']['photoslidelist_name']; ?>
</div>
            <div class="clsTDText">
                <select name="playlist" id="playlist" onchange="chkPlaylist('playlist')" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                    <option value=""><?php echo $this->_tpl_vars['LANG']['photoslidelist_select_slidelist']; ?>
</option>
                    <option value="#new#"><?php echo $this->_tpl_vars['LANG']['photoslidelist_create_slidelist']; ?>
</option>
                    <?php echo $this->_tpl_vars['myobj']->generalPopulateArrayPlaylist($this->_tpl_vars['playlistInfoViewPhoto'],$this->_tpl_vars['myobj']->getFormField('playlist'),$this->_tpl_vars['playlist']); ?>

                </select>
            </div>
<?php endif; ?>
<?php if (! isAjaxPage ( )): ?>
		</div>
        <div id="createNewPlaylist" style="display:none">
            <div class="clsRow">
                <div class="clsTDLabel"><label for="playlist_name"><?php echo $this->_tpl_vars['LANG']['photoslidelist_name']; ?>
</label><span class="clsCompulsoryField"><?php echo $this->_tpl_vars['LANG']['common_photo_mandatory']; ?>
</span></div>
                <div class="clsTDText"><input class="clsFields" type="text" name="playlistTitle" id="playlistTitle" /><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('playlist_name'); ?>

                         <p><?php echo $this->_tpl_vars['myobj']->playlist_name_notes; ?>
</p>
                </div>
            </div>
            <div class="clsRow">
                <div class="clsTDLabel"><label for="playlist_description"><?php echo $this->_tpl_vars['LANG']['photoslidelist_description']; ?>
 </label></div>
                <div class="clsTDText"><textarea class="clsFields" name="playlistDesc" id="playlistDesc" cols="45" rows="5"></textarea><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('playlist_description'); ?>
</div>
            </div>
		</div>
        <div class="clsRow">
            <div class="clsTDLabel"><!----></div>
            <div class="clsTDText">
                <p class="clsButton clsSubmitButton-l">
					<span class="clsSubmitButton-r">
                    	<input type="button" value="<?php echo $this->_tpl_vars['LANG']['photoslidelist_submit_label']; ?>
" onclick="createPlayList('<?php echo $this->_tpl_vars['playlist_info']['playlistUrl']; ?>
', photo_id, $Jq('#playlist').val())" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
					</span>
                </p>
            </div>
        </div>
	</div>
</div>
<?php endif; ?>