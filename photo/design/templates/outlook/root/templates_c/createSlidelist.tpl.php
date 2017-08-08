<?php /* Smarty version 2.6.18, created on 2012-11-17 07:44:52
         compiled from createSlidelist.tpl */ ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('create_playlist_block')): ?>
        <!-- information div start-->
        <div id="errorTips" style="display:none" class="clsErrorMessage">
        </div>
        <!-- information div end-->
        <div class="clsOverflow">
        <div class="clsFlagTitle"><?php echo $this->_tpl_vars['LANG']['photoslidelist_label']; ?>
</div>
        </div>
        <div class="clsInnerPlaylist">
        	<div id="createPlaylist" class="clsCreatePlaylist">
        	<form id="createPlaylistForm" name="createPlaylistForm" method="post">
                <div class="clsRow" id="playlist">
                	<div class="clsTDLabel">
                    	<label for="playlist_name_select"><?php echo $this->_tpl_vars['LANG']['photoslidelist_name']; ?>
</label>
                    </div>
                	<div class="clsTDText">
                        <select name="playlist_name_select" id="playlist_name_select" onchange="playlistSelectBoxAction(this.value, 'playlistContent')">
	                        <option value=""><?php echo $this->_tpl_vars['LANG']['photoslidelist_select_slidelist']; ?>
</option>
	                        <option value="0"><?php echo $this->_tpl_vars['LANG']['photoslidelist_create_slidelist']; ?>
</option>
	                        <?php echo $this->_tpl_vars['myobj']->generalPopulateArrayPlaylist($this->_tpl_vars['playlistInfoViewPhoto'],$this->_tpl_vars['myobj']->getFormField('playlist_name_select'),$this->_tpl_vars['playlist']); ?>

                        </select>

					
                    </div>
                </div>
                <div id="playlistContent" style="display:none">
                    <div class="clsRow">
                    	<div class="clsTDLabel"><label for="playlist_name"><?php echo $this->_tpl_vars['LANG']['photoslidelist_name']; ?>
</label><span class="clsCompulsoryField"><?php echo $this->_tpl_vars['LANG']['common_photo_mandatory']; ?>
</span></div>
                        <div class="clsTDText"><input class="clsFields" type="text" name="playlist_name" id="playlist_name" maxlength="<?php echo $this->_tpl_vars['CFG']['fieldsize']['photo_playlist_name']['max']; ?>
"/><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('playlist_name'); ?>

                        		 <p class="clsNameLimitCharacter"><?php echo $this->_tpl_vars['myobj']->playlist_name_notes; ?>
</p>
                        </div>
                    </div>
                    <div class="clsRow">
                    	<div class="clsTDLabel"><label for="playlist_description"><?php echo $this->_tpl_vars['LANG']['photoslidelist_description']; ?>
 </label></div>
                        <div class="clsTDText"><textarea class="clsFields" name="playlist_description" id="playlist_description" cols="45" rows="5"></textarea><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('playlist_description'); ?>
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
                        <input type="hidden" id="photo_playlist_id" name="photo_playlist_id"  value="<?php echo $this->_tpl_vars['myobj']->getFormField('photo_playlist_id'); ?>
"/>
                        <input type="hidden" name="photo_id" id="photo_id" value="<?php echo $this->_tpl_vars['myobj']->getFormField('photo_id'); ?>
" />
                         <input type="hidden" name="mode" id="mode" value="<?php echo $this->_tpl_vars['myobj']->getFormField('mode'); ?>
" />
						 <input type="hidden" name="playlist_name_select" id="playlist_name_select"  />
                        <p class="clsButton clsSubmitButton-l">
							<span class="clsSubmitButton-r">
                                <input type="button" class="clsPointer" name="playlist_submit" id="playlist_submit" value="<?php echo $this->_tpl_vars['LANG']['photoslidelist_submit_label']; ?>
" onclick="createPlaylist('<?php echo $this->_tpl_vars['myobj']->playlistUrl; ?>
')" />
                           </span>
                        </p>
                    </div>
                </div>
            </form>
        </div></div>
<?php endif; ?>