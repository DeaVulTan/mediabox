<?php /* Smarty version 2.6.18, created on 2012-02-10 20:25:04
         compiled from createPlaylist.tpl */ ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('create_playlist_block')): ?>
        <!-- information div start-->
        <div id="errorTips" style="display:none" class="clsErrorMessage">
        </div>
        <!-- information div end-->
        <div class="clsInnerPlaylist">
        	<div id="createPlaylist" class="clsCreatePlaylist">
        	<form id="createPlaylistForm" name="createPlaylistForm" method="post">
                <div class="clsRow" id="playlist">
                	<div class="clsTDLabel">
                    	<?php echo $this->_tpl_vars['LANG']['viewplaylist_playlist_label']; ?>

                    </div>
                	<div class="clsTDText">
                        <select name="playlist_name_select" id="playlist_name_select" onchange="playlistSelectBoxAction(this.value, 'playlistContent')">
                        <option value=""><?php echo $this->_tpl_vars['LANG']['viewplaylist_select_titles']; ?>
</option>
                        <option value="0"><?php echo $this->_tpl_vars['LANG']['viewplaylist_create_playlist_label']; ?>
</option>
                        <?php echo $this->_tpl_vars['myobj']->generalPopulateArrayPlaylist($this->_tpl_vars['playlistInfo'],$this->_tpl_vars['myobj']->getFormField('playlist_name_select'),$this->_tpl_vars['playlist']); ?>

                        </select>
                    </div>
                </div>
                <div id="playlistContent" style="display:none">
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
                            <p><input type="radio" name="allow_comments" id="allow_comments" value="Yes" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','Yes'); ?>
  /> <strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_yes']; ?>
</strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_comments_yes']; ?>
</p>
                            <p><input type="radio" name="allow_comments" id="allow_comments" value="No" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','No'); ?>
 /> <strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_no']; ?>
</strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_comments_no']; ?>
</p>
                            <p><input type="radio" name="allow_comments" id="allow_comments" value="Kinda" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','Kinda'); ?>
 /> <strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_kinda']; ?>
</strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_comments_kinda']; ?>
 </p>
                        </div>
                    </div>
                    <div class="clsRow">
                        <div class="clsTDLabel"><label for="allow_ratings"><?php echo $this->_tpl_vars['LANG']['musicplaylist_allow_ratings']; ?>
</label></div>
                        <div class="clsTDText">
                            <p><input type="radio" name="allow_ratings" id="allow_ratings" value="Yes" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_ratings','Yes'); ?>
 /> <strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_yes']; ?>
</strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_ratings_yes']; ?>
</p>
                            <p><input type="radio" name="allow_ratings" id="allow_ratings" value="No" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_ratings','No'); ?>
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
                            <p><input type="radio" name="allow_embed" id="allow_embed" value="Yes" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_embed','Yes'); ?>
 /> <strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_enabled_embed']; ?>
:</strong> <?php echo $this->_tpl_vars['LANG']['musicplaylist_embed_yes']; ?>
</p>
                            <p><input type="radio" name="allow_embed" id="allow_embed" value="No" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_embed','No'); ?>
 /> <strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_disabled_embed']; ?>
:</strong> <?php echo $this->_tpl_vars['LANG']['musicplaylist_embed_no']; ?>
 </p>
                        </div>
                    </div>
                </div>
                <div class="clsRow" style="display:none" id="playlist_loader_row">
                	<div class="clsTDLabel"><!----></div>
                    <div class="clsTDText">
                    	<div id="playlist_submitted"></div>
                    </div>
                  </div>
                <div class="clsRow">
                	<div class="clsTDLabel"><!----></div>
                    <div class="clsTDText">
                        <input type="hidden" id="playlist_id" name="playlist_id"  value="<?php echo $this->_tpl_vars['myobj']->getFormField('playlist_id'); ?>
"/>
                        <input type="hidden" name="music_id" id="music_id" value="<?php echo $this->_tpl_vars['myobj']->getFormField('music_id'); ?>
" />
                         <input type="hidden" name="mode" id="mode" value="<?php echo $this->_tpl_vars['myobj']->getFormField('mode'); ?>
" />
                        <p class="clsButton">
                            <span>
                            	<input type="button" name="playlist_submit" id="playlist_submit" value="<?php echo $this->_tpl_vars['LANG']['common_playlistsubmit_label']; ?>
" onclick="createPlaylist('<?php echo $this->_tpl_vars['myobj']->playlistUrl; ?>
')" />                            </span>
                        </p>
                    </div>
                </div>
            </form>
        </div></div>
<?php endif; ?>