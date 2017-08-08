<?php /* Smarty version 2.6.18, created on 2012-02-13 12:25:53
         compiled from musicPlaylistManage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'musicPlaylistManage.tpl', 15, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selMusicPlaylistManage">
	<!-- heading -->
	<div class="clsAudioIndex"><h3>
    	<?php echo $this->_tpl_vars['LANG']['musicplaylist_title']; ?>
    	
    </h3></div>
     <!-- information div -->
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <!-- Multi confirmation box -->
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
                <input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_confirm']; ?>
" />
                &nbsp;
                <input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
"  onClick="return hideAllBlocks('selFormForums');" />
                <input type="hidden" name="playlist_ids" id="playlist_ids" />
                <input type="hidden" name="action" id="action" />
                <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_arr); ?>

		</form>
	</div>
    <!-- confirmation box-->
    <!-- Single confirmation box -->
    <div id="selMsgConfirmSingle" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessageSingle"></p>
		<form name="msgConfirmformSingle" id="msgConfirmformSingle" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
                <input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_confirm']; ?>
" />
                &nbsp;
                <input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
"  onClick="return hideAllBlocks('selFormForums');" />
                <input type="hidden" name="playlist_ids" id="playlist_ids" />
                <input type="hidden" name="action" id="action" />
                <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_arr); ?>

		</form>
	</div>
    <!-- confirmation box-->
    <!-- Create playlist block -->
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('create_playlist_block')): ?>
        <form name="musicPlayListManage" id="musicPlayListManage" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" >
        <p class="clsStepsTitle">
        	<?php if ($this->_tpl_vars['myobj']->getFormField('playlist_id') != ''): ?>
                <?php echo $this->_tpl_vars['LANG']['musicplaylist_update_playlist_label']; ?>

            <?php else: ?>
                <?php echo $this->_tpl_vars['LANG']['musicplaylist_createlist']; ?>

            <?php endif; ?>
        </p>
            <div class="clsDataTable"><table class="clsCreateAlbumTable">
              <tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                	<label for="playlist_name">
                    	<?php echo $this->_tpl_vars['LANG']['musicplaylist_name']; ?>
                    </label> <span class="clsMandatoryFieldIcon">*</span>               </td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">

                	<input type="text" name="playlist_name" id="playlist_name" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('playlist_name'); ?>
">
                	<p><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('playlist_name'); ?>
</p>
                   <p><?php echo $this->_tpl_vars['myobj']->ShowHelpTip('music_playlist_name','playlist_name'); ?>
 </p></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                	<label for="playlist_description">
                    	<?php echo $this->_tpl_vars['LANG']['musicplaylist_description']; ?>
                    </label>  <span class="clsMandatoryFieldIcon">*</span>              </td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">

                	<textarea name="playlist_description" id="playlist_description" cols="45" rows="5" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('playlist_description'); ?>
</textarea>
                    <p><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('playlist_description'); ?>
</p><p><?php echo $this->_tpl_vars['myobj']->ShowHelpTip('music_playlist_description','playlist_description'); ?>
 </p></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                	<label for="playlist_tags">
                    	<?php echo $this->_tpl_vars['LANG']['musicplaylist_tags']; ?>
                    </label><span class="clsMandatoryFieldIcon">*</span>                </td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                	<input type="text" name="playlist_tags" id="playlist_tags" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('playlist_tags'); ?>
">
                   <p><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('playlist_tags'); ?>
</p>
                    <p><?php echo $this->_tpl_vars['myobj']->ShowHelpTip('music_playlist_tags','playlist_tags'); ?>
</p></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault"><label for="allow_comments"><?php echo $this->_tpl_vars['LANG']['musicplaylist_allow_comments']; ?>
</label></td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                <input type="radio" name="allow_comments" id="allow_comments" value="Yes" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','Yes'); ?>
  /> <strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_yes']; ?>
</strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_comments_yes']; ?>

                <br />

                <input type="radio" name="allow_comments" id="allow_comments" value="No" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','No'); ?>
 /> <strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_no']; ?>
</strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_comments_no']; ?>

                <br />
                <input type="radio" name="allow_comments" id="allow_comments" value="Kinda" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_comments','Kinda'); ?>
 /> <strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_kinda']; ?>
</strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_comments_kinda']; ?>
                </td>
              </tr>
              <tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault"><label for="allow_ratings"><?php echo $this->_tpl_vars['LANG']['musicplaylist_allow_ratings']; ?>
</label></td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                <input type="radio" name="allow_ratings" id="allow_ratings" value="Yes" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_ratings','Yes'); ?>
 /> <strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_yes']; ?>
</strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_ratings_yes']; ?>

                <br />
                <input type="radio" name="allow_ratings" id="allow_ratings" value="No" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_ratings','No'); ?>
 />
                <strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_no']; ?>
</strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_ratings_no']; ?>

                <br />
                <?php echo $this->_tpl_vars['LANG']['musicplaylist_ratings_helptips']; ?>
                 </td>
              </tr>
              <tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault"><?php echo $this->_tpl_vars['LANG']['musicplaylist_allow_embed']; ?>
</td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                <input type="radio" name="allow_embed" id="allow_embed" value="Yes" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_embed','Yes'); ?>
 /> <strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_enabled_embed']; ?>
:</strong> <?php echo $this->_tpl_vars['LANG']['musicplaylist_embed_yes']; ?>

                <br />
                <input type="radio" name="allow_embed" id="allow_embed" value="No" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('allow_embed','No'); ?>
 />
                <strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_disabled_embed']; ?>
:</strong> <?php echo $this->_tpl_vars['LANG']['musicplaylist_embed_no']; ?>

               </td>
              </tr>
              <tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault">&nbsp;</td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">

                    <input  type="hidden" class="clsSubmitButton" name="playlist_id" id="playlist_id" value="<?php echo $this->_tpl_vars['myobj']->getFormField('playlist_id'); ?>
" />
                  <div class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" class="clsSubmitButton" name="playlist_submit" id="playlist_submit" value="<?php if ($this->_tpl_vars['myobj']->getFormField('playlist_id') != ''): ?><?php echo $this->_tpl_vars['LANG']['musicplaylist_update_playlist_label']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['musicplaylist_create_palylist']; ?>
<?php endif; ?>" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"></span></div>
                <?php if ($this->_tpl_vars['myobj']->chkIsAdminSide()): ?>
                	<div class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="button" class="clsSubmitButton" name="cancel_submit" id="cancel_submit" value="<?php echo $this->_tpl_vars['LANG']['musicplaylist_Cancel_label']; ?>
" onclick="Redirect2URL('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/musicPlaylist.php')"tabindex="<?php echo smartyTabIndex(array(), $this);?>
"></span></div>
                <?php else: ?>
                	<div class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="button" class="clsSubmitButton" name="cancel_submit" id="cancel_submit" value="<?php echo $this->_tpl_vars['LANG']['musicplaylist_Cancel_label']; ?>
" onclick="Redirect2URL('<?php echo $this->_tpl_vars['myobj']->createplaylist_url; ?>
')"tabindex="<?php echo smartyTabIndex(array(), $this);?>
"></span></div>
                <?php endif; ?> 
                </td>
              </tr>
            </table>
          </div>
  </form>
  <?php endif; ?>
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_playlist_block') && ! $this->_tpl_vars['myobj']->chkIsAdminSide()): ?>
    	<div id="selMusicPlaylistManageDisplay" class="clsLeftSideDisplayTable">
        	<p class="clsStepsTitle"><?php echo $this->_tpl_vars['LANG']['musicplaylist_title']; ?>
</p>
            <?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
                <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
						<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                        <div class="clsAudioPaging"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
                <?php endif; ?>
                <form id="deleMusicForm" name="deleMusicForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
                    <div class="clsDataTable">
                        <table class="clsMyMusicPlaylistTbl">
                            <tr>
                                <th><input type="checkbox" name="check_all" id="check_all" onclick="CheckAll(document.deleMusicForm.name, document.deleMusicForm.check_all.name)" /></th>
                                <th><?php echo $this->_tpl_vars['LANG']['musicplaylist_image']; ?>
</th>
                                <th><?php echo $this->_tpl_vars['LANG']['musicplaylist_name']; ?>
</th>
                                <th><?php echo $this->_tpl_vars['LANG']['musicplaylist_totla_music']; ?>
</th>
                                <th colspan="4" class="clsUserActionTh"><?php echo $this->_tpl_vars['LANG']['musicplaylist_user_action']; ?>
</th>
                            </tr>
                            <?php $_from = $this->_tpl_vars['myobj']->list_playlist_block['showPlaylists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['musicPlaylistKey'] => $this->_tpl_vars['musicplaylist']):
?>
                            <tr>
                                <td><input type="checkbox" name="forum_ids[]" id="check" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['musicplaylist']['playlist_id']; ?>
" onClick="disableHeading('deleMusicForm');"/></td>
                                <td>
                                    <div class="clsMultipleImage clsPointer" onclick="Redirect2URL('<?php echo $this->_tpl_vars['musicplaylist']['playlist_view_link']; ?>
')" title="<?php echo $this->_tpl_vars['musicplaylist']['playlist_name']; ?>
">
                                        <?php if ($this->_tpl_vars['musicplaylist']['getPlaylistImageDetail']['total_record'] > 0): ?>
                                            <?php $_from = $this->_tpl_vars['musicplaylist']['getPlaylistImageDetail']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['playlistImageDetailKey'] => $this->_tpl_vars['playlistImageDetailValue']):
?>
                                                <table><tr><td><img src="<?php echo $this->_tpl_vars['playlistImageDetailValue']['playlist_path']; ?>
" /></td></tr></table>
                                            <?php endforeach; endif; unset($_from); ?>
                                            <?php if ($this->_tpl_vars['musicplaylist']['getPlaylistImageDetail']['total_record'] < 4): ?>
                                            	<?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)0;
$this->_sections['foo']['loop'] = is_array($_loop=$this->_tpl_vars['musicplaylist']['getPlaylistImageDetail']['noimageCount']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['foo']['show'] = true;
$this->_sections['foo']['max'] = $this->_sections['foo']['loop'];
if ($this->_sections['foo']['start'] < 0)
    $this->_sections['foo']['start'] = max($this->_sections['foo']['step'] > 0 ? 0 : -1, $this->_sections['foo']['loop'] + $this->_sections['foo']['start']);
else
    $this->_sections['foo']['start'] = min($this->_sections['foo']['start'], $this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] : $this->_sections['foo']['loop']-1);
if ($this->_sections['foo']['show']) {
    $this->_sections['foo']['total'] = min(ceil(($this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] - $this->_sections['foo']['start'] : $this->_sections['foo']['start']+1)/abs($this->_sections['foo']['step'])), $this->_sections['foo']['max']);
    if ($this->_sections['foo']['total'] == 0)
        $this->_sections['foo']['show'] = false;
} else
    $this->_sections['foo']['total'] = 0;
if ($this->_sections['foo']['show']):

            for ($this->_sections['foo']['index'] = $this->_sections['foo']['start'], $this->_sections['foo']['iteration'] = 1;
                 $this->_sections['foo']['iteration'] <= $this->_sections['foo']['total'];
                 $this->_sections['foo']['index'] += $this->_sections['foo']['step'], $this->_sections['foo']['iteration']++):
$this->_sections['foo']['rownum'] = $this->_sections['foo']['iteration'];
$this->_sections['foo']['index_prev'] = $this->_sections['foo']['index'] - $this->_sections['foo']['step'];
$this->_sections['foo']['index_next'] = $this->_sections['foo']['index'] + $this->_sections['foo']['step'];
$this->_sections['foo']['first']      = ($this->_sections['foo']['iteration'] == 1);
$this->_sections['foo']['last']       = ($this->_sections['foo']['iteration'] == $this->_sections['foo']['total']);
?>
                                           			<table><tr><td><img  width="65" height="44" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_audio_M.jpg" /></td></tr></table>
                                        		<?php endfor; endif; ?>	
                                            <?php endif; ?>
                                        <?php else: ?>    
                                            <div class="clsSingleImage"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_audio_T.jpg" /></div>
                                        <?php endif; ?>    
                                    </div>
                               	</td>
                                <td><a href="<?php echo $this->_tpl_vars['musicplaylist']['playlist_view_link']; ?>
" title="<?php echo $this->_tpl_vars['musicplaylist']['playlist_name']; ?>
" ><?php echo $this->_tpl_vars['musicplaylist']['playlist_name']; ?>
</a></td>
                                <td><?php echo $this->_tpl_vars['musicplaylist']['total_tracks']; ?>
</td>
                                <td><a href="<?php echo $this->_tpl_vars['musicplaylist']['playlist_view_link']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['musicplaylist_manage_music']; ?>
" ><?php echo $this->_tpl_vars['LANG']['musicplaylist_manage_music']; ?>
</a></td>
                                <td><a href="<?php echo $this->_tpl_vars['musicplaylist']['edit_link']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['musicplaylist_edit_playlist']; ?>
"><?php echo $this->_tpl_vars['LANG']['musicplaylist_edit_playlist']; ?>
</a></td>                                
								<td><a href="javascript:void(0);" title="<?php echo $this->_tpl_vars['LANG']['musicplaylist_delete_playlist']; ?>
" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle',Array('action','playlist_ids', 'confirmMessageSingle'), Array('delete','<?php echo $this->_tpl_vars['musicplaylist']['playlist_id']; ?>
', '<?php echo $this->_tpl_vars['LANG']['musicplaylist_delete_confirmation']; ?>
'), Array('value','value', 'innerHTML'), -100, -500);"><?php echo $this->_tpl_vars['LANG']['musicplaylist_delete_playlist']; ?>
</a></td>                            
								<td><a href="javascript:void(0);" onclick="managePlaylistReorder('<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
')" title="<?php echo $this->_tpl_vars['LANG']['musicplaylist_organize_playlist']; ?>
"><?php echo $this->_tpl_vars['LANG']['musicplaylist_organize_playlist']; ?>
</a></td></tr>
                            <?php endforeach; endif; unset($_from); ?>
                            <tr>
                                <td>&nbsp;</td>
                                <td colspan="6">
                                <div class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="button" class="clsSubmitButton" name="button" id="button" value="<?php echo $this->_tpl_vars['LANG']['musicplaylist_delete']; ?>
" onClick="getMultiCheckBoxValue('deleMusicForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['musicplaylist_err_tip_select_titles']; ?>
');if(multiCheckValue!='') getAction('delete')"/></span></div>                                </td>
                            </tr>
                        </table>
                  </div>
                </form>
                <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
                    <div id="bottomLinks" class="clsAudioPaging">
						<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    </div>
                <?php endif; ?>
              <?php else: ?>
                 <div id="selMsgAlert">
                    <p><?php echo $this->_tpl_vars['LANG']['musicplaylist_no_records_found']; ?>
</p>
                 </div>
               <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>