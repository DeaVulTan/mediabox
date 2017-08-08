<?php /* Smarty version 2.6.18, created on 2011-10-17 15:10:09
         compiled from getPlaylist.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'getPlaylist.tpl', 27, false),)), $this); ?>
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
    	<div class="clsFlagTitle"><?php echo $this->_tpl_vars['LANG']['playlist_title']; ?>
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
	<?php if ($this->_tpl_vars['playlist_option'] == 'playlist'): ?>
		var music_id ="<?php echo $this->_tpl_vars['myobj']->getFormField('song_id'); ?>
";
	<?php else: ?>
		var music_id ="<?php echo $this->_tpl_vars['myobj']->getFormField('music_id'); ?>
";
	<?php endif; ?>
</script>				
    	    <div class="clsTDLabel"><?php echo $this->_tpl_vars['LANG']['playlist_title']; ?>
</div>
            <div class="clsTDText">
                <select name="playlist" id="playlist" onchange="chkPlaylist('playlist')" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                    <option value=""><?php echo $this->_tpl_vars['LANG']['playlist_select']; ?>
</option>
                    <option value="#new#"><?php echo $this->_tpl_vars['LANG']['playlist_create']; ?>
</option>
                    <?php echo $this->_tpl_vars['myobj']->generalPopulateArrayPlaylist($this->_tpl_vars['playlistInfo'],$this->_tpl_vars['myobj']->getFormField('playlist'),$this->_tpl_vars['playlist']); ?>

                </select>
            </div>        
<?php endif; ?>
<?php if (! isAjaxPage ( )): ?>
		</div>      
        <div id="createNewPlaylist" style="display:none">        	
            <div class="clsRow">
                <div class="clsTDLabel"><label for="playlist_name"><?php echo $this->_tpl_vars['LANG']['common_playlistname_label']; ?>
</label><span class="clsCompulsoryField"><?php echo $this->_tpl_vars['LANG']['common_music_mandatory']; ?>
</span></div>
                <div class="clsTDText"><input class="clsFields" type="text" name="playlist_name" id="playlist_name" /><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('playlist_name'); ?>

                         <p><?php echo $this->_tpl_vars['myobj']->playlist_name_notes; ?>
</p>
                </div>
            </div>
            <div class="clsRow">
                <div class="clsTDLabel"><label for="playlist_description"><?php echo $this->_tpl_vars['LANG']['viewplaylist_description_label']; ?>
 </label></div>
                <div class="clsTDText"><textarea class="clsFields" name="playlist_description" id="playlist_description" cols="45" rows="5"></textarea><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('playlist_description'); ?>
</div>
            </div>
            <div class="clsRow">
                <div class="clsTDLabel"><label for="playlist_tags"><?php echo $this->_tpl_vars['LANG']['common_playlisttags_label']; ?>
</label><span class="clsCompulsoryField"><?php echo $this->_tpl_vars['LANG']['common_music_mandatory']; ?>
</span></div>
                <div class="clsTDText"><input class="clsFields" type="text" name="playlist_tags" id="playlist_tags" /><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('playlist_tags'); ?>

                <p><?php echo $this->_tpl_vars['myobj']->playlist_tags_notes; ?>
</p>
                </div>
            </div>
            <div class="clsRow">
                <div class="clsTDLabel"><label for="allow_comments"><?php echo $this->_tpl_vars['LANG']['musicplaylist_allow_comments']; ?>
 </label></div>
                <div class="clsTDText">
                    <p><input type="radio" name="allow_comments" value="Yes" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','Yes'); ?>
  /> <strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_yes']; ?>
</strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_comments_yes']; ?>
</p>
                    <p><input type="radio" name="allow_comments" value="No" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','No'); ?>
 /> <strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_no']; ?>
</strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_comments_no']; ?>
</p>
                    <p><input type="radio" name="allow_comments" value="Kinda" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','Kinda'); ?>
 /> <strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_kinda']; ?>
</strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_comments_kinda']; ?>
 </p>
                </div>
            </div>
            <div class="clsRow">
                <div class="clsTDLabel"><label for="allow_ratings"><?php echo $this->_tpl_vars['LANG']['musicplaylist_allow_ratings']; ?>
</label></div>
                <div class="clsTDText">
                    <p><input type="radio" name="allow_ratings" value="Yes" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_ratings','Yes'); ?>
 /> <strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_yes']; ?>
</strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_ratings_yes']; ?>
</p>
                    <p><input type="radio" name="allow_ratings" value="No" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_ratings','No'); ?>
 /> <strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_no']; ?>
</strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_ratings_no']; ?>
 </p>
                    <?php echo $this->_tpl_vars['LANG']['musicplaylist_ratings_helptips']; ?>

                </div>
            </div>
            <div class="clsRow">
                <div class="clsTDLabel"><label for="allow_embed"><?php echo $this->_tpl_vars['LANG']['musicplaylist_allow_embed']; ?>
</label></div>
                <div class="clsTDText">
                    <p><input type="radio" name="allow_embed" value="Yes" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_embed','Yes'); ?>
 /> <strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_enabled_embed']; ?>
:</strong> <?php echo $this->_tpl_vars['LANG']['musicplaylist_embed_yes']; ?>
</p>
                    <p><input type="radio" name="allow_embed" value="No" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_embed','No'); ?>
 /> <strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_disabled_embed']; ?>
:</strong> <?php echo $this->_tpl_vars['LANG']['musicplaylist_embed_no']; ?>
 </p>
                </div>
            </div>
		</div>
        <div class="clsRow">
            <div class="clsTDLabel"><!----></div>
            <div class="clsTDText">
                <p class="clsButton">
                    <span><input type="button" value="<?php echo $this->_tpl_vars['LANG']['playlist_submit']; ?>
" onclick="createPlayList('<?php echo $this->_tpl_vars['playlist_info']['playlistUrl']; ?>
', music_id, $Jq('#playlist').val())" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></span>
                </p>
            </div>
        </div>
	</div>
</div>
<?php endif; ?>