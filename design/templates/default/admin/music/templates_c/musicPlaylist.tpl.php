<?php /* Smarty version 2.6.18, created on 2012-03-12 18:13:58
         compiled from musicPlaylist.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'musicPlaylist.tpl', 147, false),)), $this); ?>
<div id="musicPlaylist">
    <h2>
    	        <?php echo $this->_tpl_vars['LANG']['musicplaylist_manage_playlist']; ?>

  </h2>
   <!-- information div -->
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin'); ?>

    	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <br />
   	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('search_playlist_block')): ?>

        <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
        				<a onclick="divShowHide('advancedPlaylistSearch', 'show_link', 'hide_link')"  style="display:none" id="show_link" href="javascript:void(0)"><?php echo $this->_tpl_vars['LANG']['musicplaylist_show_advanced_filters']; ?>
</a>
            <a onclick="divShowHide('advancedPlaylistSearch', 'show_link', 'hide_link')"   id="hide_link" href="javascript:void(0)"><?php echo $this->_tpl_vars['LANG']['musicplaylist_hide_advanced_filters']; ?>
</a>
            <div id="advancedPlaylistSearch" >
                    <table class="clsNoBorder" >
                    <tr>
						<td class="clsWidthSmall clsFormLabelCellDefault">
							<label><?php echo $this->_tpl_vars['LANG']['musicplaylist_playlist_title']; ?>
</label>
						</td>
                        <td class="clsFormFieldCellDefault">
                            <input type="text" name="playlist_title" id="playlist_title"   value="<?php if ($this->_tpl_vars['myobj']->getFormField('playlist_title') == ''): ?><?php echo $this->_tpl_vars['LANG']['musicplaylist_playlist_title']; ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('playlist_title'); ?>
<?php endif; ?>" onblur="setOldValue('playlist_title')"  onfocus="clearValue('playlist_title')" class="clsTextBox"/>
                      </td>
					</tr>
					<tr>
						<td class="clsWidthSmall clsFormLabelCellDefault">
							<label><?php echo $this->_tpl_vars['LANG']['musicplaylist_createby']; ?>
</label>
						</td>
                      <td class="clsFormFieldCellDefault">
                            <input type="text" name="createby" id="createby" onfocus="clearValue('createby')"  onblur="setOldValue('createby')" value="<?php if ($this->_tpl_vars['myobj']->getFormField('createby') == ''): ?><?php echo $this->_tpl_vars['LANG']['musicplaylist_createby']; ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('createby'); ?>
<?php endif; ?>" class="clsTextBox" />
                      </td>
                    </tr>
                    <tr>
						<td class="clsWidthSmall clsFormLabelCellDefault">
							<label><?php echo $this->_tpl_vars['LANG']['musicplaylist_no_of_tracks']; ?>
</label>
						</td>
                        <td class="clsFormFieldCellDefault">
                            <input type="text" name="tracks" id="tracks" onfocus="clearValue('tracks')"  onblur="setOldValue('tracks')" value="<?php if ($this->_tpl_vars['myobj']->getFormField('tracks') == ''): ?><?php echo $this->_tpl_vars['LANG']['musicplaylist_no_of_tracks']; ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('tracks'); ?>
<?php endif; ?>" class="clsTextBox" />
                        </td>
					</tr>
					<tr>
						<td class="clsWidthSmall clsFormLabelCellDefault">
							<label><?php echo $this->_tpl_vars['LANG']['musicplaylist_no_of_plays']; ?>
</label>
						</td>
                        <td class="clsFormFieldCellDefault">
                            <input type="text" name="plays" id="plays" onfocus="clearValue('plays')"  onblur="setOldValue('plays')" value="<?php if ($this->_tpl_vars['myobj']->getFormField('plays') == ''): ?><?php echo $this->_tpl_vars['LANG']['musicplaylist_no_of_plays']; ?>
 <?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('plays'); ?>
<?php endif; ?>" class="clsTextBox" />
                        </td>
                    </tr>
                    <tr>
                    <td><input type="submit" name="search" id="search" value="<?php echo $this->_tpl_vars['LANG']['musicplaylist_search']; ?>
" class="clsSubmitButton" />
                      <input type="submit" value="Reset" id="avd_reset" name="avd_reset" class="clsSubmitButton"/>
                      </td>
                    </tr>
                    </table>
            </div>
        </form>
    <?php endif; ?>
   <!-- Single confirmation box -->
        <div id="selMsgConfirmSingle" class="clsPopupConfirmation" style="display:none;">
            <p id="confirmMessageSingle"></p>
            <form name="msgConfirmformSingle" id="msgConfirmformSingle" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
                <table summary="<?php echo $this->_tpl_vars['LANG']['musicplaylist_admin_conform_box']; ?>
" class="clsNoBorder">
                    <tr>
                        <td>
                            <input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_confirm']; ?>
" />
                            &nbsp;
                            <input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
"  onClick="return hideAllBlocks('selFormForums');" />
                            <input type="hidden" name="playlist_id" id="playlist_id" />
                            <input type="hidden" name="featured" id="featured" />
                            <input type="hidden" name="confirm" id="confirm" />
                            <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_array); ?>

                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <!-- confirmation box-->
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_playlist_block')): ?>
    	<div id="selMusicPlaylistManageDisplay" class="clsLeftSideDisplayTable">
    			<!--
            <div>
                <p><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/musicPlaylistManage.php"><?php echo $this->_tpl_vars['LANG']['musicplaylist_create_playlist_label']; ?>
</a></p>
            </div>-->
		    <?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
            	<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
                        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin'); ?>

                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <?php endif; ?>

                    <table>
                    <th><?php echo $this->_tpl_vars['LANG']['musicplaylist_image']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['LANG']['musicplaylist_name']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['LANG']['musicplaylist_totla_music']; ?>
</th>
                    <th colspan="4" class="clsUserActionTh"><?php echo $this->_tpl_vars['LANG']['musicplaylist_user_action']; ?>
</th>
					<?php $_from = $this->_tpl_vars['myobj']->list_playlist_block['showPlaylists']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['musicPlaylistKey'] => $this->_tpl_vars['musicplaylist']):
?>
                      <tr>
                        <td class="clsSmallWidth">

                        	<div class="clsMultipleImage clsPointer" onclick="Redirect2URL('<?php echo $this->_tpl_vars['musicplaylist']['view_playlisturl']; ?>
')" title="<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_name']; ?>
">
                                <?php if ($this->_tpl_vars['musicplaylist']['getPlaylistImageDetail']['total_record'] > 0): ?>
                                    <?php $_from = $this->_tpl_vars['musicplaylist']['getPlaylistImageDetail']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['playlistImageDetailKey'] => $this->_tpl_vars['playlistImageDetailValue']):
?>
                                       <table><tr><td><img src="<?php echo $this->_tpl_vars['playlistImageDetailValue']['playlist_path']; ?>
"/></td></tr></table>
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
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/admin/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_audio_S.jpg" /></td></tr></table>
                                        <?php endfor; endif; ?>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <div class="clsSingleImage"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/admin/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_audio_T.jpg" /></div>
                                <?php endif; ?>
                        </div>
                        </td>
                        <td>
                            <p><a href="<?php echo $this->_tpl_vars['musicplaylist']['view_playlisturl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_name']; ?>
</a> (<?php echo $this->_tpl_vars['musicplaylist']['record']['total_tracks']; ?>
 <?php echo $this->_tpl_vars['LANG']['musicplaylist_tracks']; ?>
 <?php if ($this->_tpl_vars['musicplaylist']['private_song'] > 0): ?> - <?php echo $this->_tpl_vars['LANG']['musicplaylist_private_label']; ?>
: <?php echo $this->_tpl_vars['musicplaylist']['private_song']; ?>
<?php endif; ?>)</p>
                            <p><?php echo $this->_tpl_vars['LANG']['musicplaylist_postby']; ?>
<a href="<?php echo $this->_tpl_vars['musicplaylist']['getMemberProfileUrl']; ?>
"><?php echo $this->_tpl_vars['musicplaylist']['record']['user_name']; ?>
</a></p>
                            <p><a id="play_music_icon_<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
" onClick="playlistInPlayListPlayer('<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
')" href="javascript:void(0)" title="<?php echo $this->_tpl_vars['LANG']['musicplaylist_playallsong_helptips']; ?>
"><?php echo $this->_tpl_vars['LANG']['musicplaylist_playall_label']; ?>
</a> </p>
                             <p><a href="<?php echo $this->_tpl_vars['musicplaylist']['view_playlisturl']; ?>
"><?php echo $this->_tpl_vars['LANG']['musicplaylist_admin_view_song']; ?>
</a> </p>
                        </td>
                        <td class="clsSmallWidth">
                            <p><?php echo $this->_tpl_vars['LANG']['musicplaylist_plays']; ?>
 <?php echo $this->_tpl_vars['musicplaylist']['record']['total_views']; ?>
</p>
                            <p><?php echo $this->_tpl_vars['LANG']['musicplaylist_comments']; ?>
 <?php echo $this->_tpl_vars['musicplaylist']['record']['total_comments']; ?>
</p>
                            <p><?php echo $this->_tpl_vars['LANG']['musicplaylist_favorites']; ?>
 <?php echo $this->_tpl_vars['musicplaylist']['record']['total_favorites']; ?>
</p>
                            <p><?php echo $this->_tpl_vars['LANG']['musicplaylist_featured']; ?>
 <?php echo $this->_tpl_vars['musicplaylist']['record']['total_featured']; ?>
   </p >                        </td>
                        <td class="clsSmallWidth">
                                                	<!--<p>
                            	<a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/musicPlaylistManage.php?playlist_id=<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
" ><?php echo $this->_tpl_vars['LANG']['musicplaylist_edit_label']; ?>
</a>
                            </p>
                        	<p>
                            <?php if ($this->_tpl_vars['musicplaylist']['record']['featured'] == 'Yes'): ?>
	                      		<a href="javascript:void(0)"  onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle', Array('confirm', 'playlist_id', 'featured', 'confirmMessageSingle'), Array('featured', '<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
', 'No', '<?php echo $this->_tpl_vars['LANG']['musicplaylist_admin_remove_featured']; ?>
'), Array('value', 'value', 'value', 'innerHTML'), -100, -500);" ><?php echo $this->_tpl_vars['LANG']['musicplaylist_remove_featured']; ?>
</a>
            				<?php else: ?>
                              <a href="javascript:void(0)"  onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle', Array('confirm', 'playlist_id', 'featured', 'confirmMessageSingle'), Array('featured', '<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
', 'Yes', '<?php echo $this->_tpl_vars['LANG']['musicplaylist_admin_set_featured']; ?>
'), Array('value', 'value', 'value', 'innerHTML'), -100, -500);" ><?php echo $this->_tpl_vars['LANG']['musicplaylist_set_featured']; ?>
</a>
                            <?php endif; ?>
                           </p>-->
                         <p><a href="javascript:void(0)" onclick="popupWindow('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/managePlaylistComments.php?playlist_id=<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
')" title="<?php echo $this->_tpl_vars['LANG']['musicplaylist_manage_playlist_comment']; ?>
"><?php echo $this->_tpl_vars['LANG']['musicplaylist_manage_comment']; ?>
(<?php echo $this->_tpl_vars['musicplaylist']['record']['total_comments']; ?>
)</a></p>
                        </td>
                      </tr>
               		 <?php endforeach; endif; unset($_from); ?>
          			</table>

              <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
                    <div id="bottomLinks">
                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    </div>
                <?php endif; ?>
             <?php else: ?>
             	<div id="selMsgAlert">
             		<?php echo $this->_tpl_vars['LANG']['musicplaylist_no_records_found']; ?>

                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>