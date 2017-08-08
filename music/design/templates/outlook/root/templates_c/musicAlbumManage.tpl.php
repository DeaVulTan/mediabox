<?php /* Smarty version 2.6.18, created on 2012-02-03 21:30:34
         compiled from musicAlbumManage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'musicAlbumManage.tpl', 15, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selMusicPlaylistManage">
	<!-- heading -->
	<div class="clsAudioIndex"><h3>
    	<?php echo $this->_tpl_vars['LANG']['commin_music_manage_albums_label']; ?>
    	
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
"  onclick="return hideAllBlocks('selFormForums');" />
                <input type="hidden" name="music_album_ids" id="music_album_ids" />
                <input type="hidden" name="action" id="action" />
                <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_arr); ?>

		</form>
	</div>
    <!-- confirmation box-->
    <!-- Single confirmation box -->
    <div id="selMsgConfirmSingle" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessageSingle"></p>
		<form name="msgConfirmformSingle" id="msgConfirmformSingle" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
">
                <input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_confirm']; ?>
" />
                &nbsp;
                <input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
"  onclick="return hideAllBlocks('selFormForums');" />
                <input type="hidden" name="music_album_ids" id="music_album_ids" />
                <input type="hidden" name="action" id="action" />
                <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_arr); ?>

		</form>
	</div>
    <!-- confirmation box-->
    <!-- Create album block -->
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('create_album_block')): ?>
		<p class="clsStepsTitle">
        	<?php if ($this->_tpl_vars['myobj']->getFormField('music_album_id') != ''): ?>
                <?php echo $this->_tpl_vars['LANG']['musicalbum_update_album_label']; ?>

            <?php else: ?>
                <?php echo $this->_tpl_vars['LANG']['musicalbum_createlist']; ?>

            <?php endif; ?>
        </p>
        <form id="frmMusicAlbumManage" name="frmMusicAlbumManage" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" >
        	<div class="clsNoteContainerblock">
        		<p class="clsNotehead"><?php echo $this->_tpl_vars['LANG']['common_music_note']; ?>
:</p>
        		<?php if ($this->_tpl_vars['CFG']['admin']['musics']['allowed_usertypes_to_upload_for_sale'] != 'None'): ?>
        		<p><?php echo $this->_tpl_vars['LANG']['musicalbum_album_note_msg1']; ?>
</p>
        		<?php endif; ?>
        		<p><?php echo $this->_tpl_vars['LANG']['musicalbum_album_note_msg2']; ?>
</p>
        	</div>
            <div class="clsDataTable"><table class="clsCreateAlbumTable">
              <tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                	<label for="album_title"><?php echo $this->_tpl_vars['LANG']['musicalbum_title']; ?>
</label>
                </td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                	<input type="text" name="album_title" id="album_title" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('album_title'); ?>
" />
                   	<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('album_title'); ?>

                   <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('music_album_title','album_title'); ?>

                 </td>
              </tr>
				<tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault"><label for="album_access_private"><?php echo $this->_tpl_vars['LANG']['musicalbum_album_access_type']; ?>
</label></td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                <input type="radio" name="album_access_type" id="album_access_private" onclick="enabledFormFields(Array('album_price'))"  value="Private" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('album_access_type','Private'); ?>
 /> <label for="album_access_private"><strong><?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
</strong></label>
                <input type="radio" name="album_access_type" id="album_access_public" onclick="disabledFormFields(Array('album_price'))"  value="Public" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('album_access_type','Public'); ?>
  /> <label for="album_access_public"><strong><?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
</strong></label>
                </td>
              </tr>
              <?php if ($this->_tpl_vars['CFG']['admin']['musics']['allowed_usertypes_to_upload_for_sale'] != 'None'): ?>
              <tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                	<label for="album_price">
                    	<?php echo $this->_tpl_vars['LANG']['musicalbum_price']; ?>
                   </label>                </td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                	(<?php echo $this->_tpl_vars['CFG']['currency']; ?>
) <input type="text" name="album_price" id="album_price" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('album_price'); ?>
" />
                   <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('album_price'); ?>

                   <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('music_album_price','album_price'); ?>

                </td>
              </tr>
              <?php endif; ?>
              <tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault">&nbsp;</td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                    <input  type="hidden" class="clsSubmitButton" name="music_album_id" id="music_album_id" value="<?php echo $this->_tpl_vars['myobj']->getFormField('music_album_id'); ?>
" />
                  <div class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" class="clsSubmitButton" name="album_submit" id="album_submit" value="<?php if ($this->_tpl_vars['myobj']->getFormField('music_album_id') != ''): ?><?php echo $this->_tpl_vars['LANG']['musicalbum_update_album_label']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['musicalbum_create_palylist']; ?>
<?php endif; ?>" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></span></div>
                <?php if ($this->_tpl_vars['myobj']->chkIsAdminSide()): ?>
                	<div class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="button" class="clsSubmitButton" name="cancel_submit" id="cancel_submit" value="<?php echo $this->_tpl_vars['LANG']['musicalbum_Cancel_label']; ?>
" onclick="Redirect2URL('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/musicPlaylist.php')"tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></span></div>
                <?php else: ?>
                	<div class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="button" class="clsSubmitButton" name="cancel_submit" id="cancel_submit" value="<?php echo $this->_tpl_vars['LANG']['musicalbum_Cancel_label']; ?>
" onclick="Redirect2URL('<?php echo $this->_tpl_vars['myobj']->createalbum_url; ?>
')"tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></span></div>
                <?php endif; ?>
                </td>
              </tr>
            </table>
          </div>
  </form>
  <?php endif; ?>
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_album_block') && ! $this->_tpl_vars['myobj']->chkIsAdminSide()): ?>
    	<div id="selMusicPlaylistManageDisplay" class="clsLeftSideDisplayTable">

            <?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
                <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
                        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                        <div class="clsAudioPaging"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
                <?php endif; ?>
                <form id="deleMusicForm" name="deleMusicForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
">
                    <div class="clsDataTable">
                        <table class="clsMyMusicPlaylistTbl clsAlbumManageTable">
                            <tr>
                                <th><input type="checkbox" name="check_all" id="check_all" onclick="CheckAll(document.deleMusicForm.name, document.deleMusicForm.check_all.name)" /></th>
                                 <th class="<?php echo $this->_tpl_vars['myobj']->getOrderCss('album_title'); ?>
 clsAlbumNameWidth"><a href="javascript:void(0)" onclick="return changeOrderbyElements('deleMusicForm','album_title')" title="<?php echo $this->_tpl_vars['LANG']['musicalbum_title']; ?>
"><?php echo $this->_tpl_vars['LANG']['musicalbum_title']; ?>
</a></th>
                                <th><?php echo $this->_tpl_vars['LANG']['musicalbum_totla_music']; ?>
</th>
                                <th class="<?php echo $this->_tpl_vars['myobj']->getOrderCss('album_access_type'); ?>
"><a href="javascript:void(0)" onclick="return changeOrderbyElements('deleMusicForm','album_access_type')"><?php echo $this->_tpl_vars['LANG']['musicalbum_access_type']; ?>
</a></th>
                                <?php if ($this->_tpl_vars['CFG']['admin']['musics']['allowed_usertypes_to_upload_for_sale'] != 'None'): ?>
                                <th class="<?php echo $this->_tpl_vars['myobj']->getOrderCss('album_price'); ?>
"><a href="javascript:void(0)" onclick="return changeOrderbyElements('deleMusicForm','album_price')"><?php echo $this->_tpl_vars['LANG']['musicalbum_album_price']; ?>
</a></th>
								<?php endif; ?>
                                <th colspan="4" class="clsUserActionTh"><?php echo $this->_tpl_vars['LANG']['musicalbum_user_action']; ?>
</th>
                            </tr>
                            <?php $_from = $this->_tpl_vars['myobj']->list_album_block['showAlbums']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['musicPlaylistKey'] => $this->_tpl_vars['musicalbum']):
?>
                            <tr>
                                <td><input type="checkbox" name="music_album_ids[]" id="check_<?php echo $this->_tpl_vars['musicalbum']['music_album_id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['musicalbum']['music_album_id']; ?>
" onclick="disableHeading('deleMusicForm');"/></td>
                                <td class="clsAlbumNameWidth"><a href="<?php echo $this->_tpl_vars['musicalbum']['album_view_link']; ?>
" title="<?php echo $this->_tpl_vars['musicalbum']['album_title']; ?>
"><?php echo $this->_tpl_vars['musicalbum']['album_wrap_title']; ?>
</a></td>
								<td><?php echo $this->_tpl_vars['myobj']->getMusicCount($this->_tpl_vars['musicalbum']['music_album_id']); ?>
</td>
								<td><?php echo $this->_tpl_vars['musicalbum']['album_access_type']; ?>
</td>
                                <?php if ($this->_tpl_vars['CFG']['admin']['musics']['allowed_usertypes_to_upload_for_sale'] != 'None'): ?>
								<td><?php echo $this->_tpl_vars['CFG']['currency']; ?>
<?php echo $this->_tpl_vars['musicalbum']['album_price']; ?>
</td>
                                <?php endif; ?>
								<?php if ($this->_tpl_vars['musicalbum']['edit_link'] != ''): ?>
								    <td class="clsOverflow">
                                    <span class="clsEditAlbum"><a href="<?php echo $this->_tpl_vars['musicalbum']['edit_link']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['musicalbum_edit_album']; ?>
"><?php echo $this->_tpl_vars['LANG']['musicalbum_edit_album']; ?>
</a></span>
									<span class="clsDeleteAlbumList"><a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle',Array('action','music_album_ids','confirmMessageSingle'), Array('delete','<?php echo $this->_tpl_vars['musicalbum']['music_album_id']; ?>
', '<?php echo $this->_tpl_vars['LANG']['musicalbum_delete_confirmation']; ?>
'), Array('value','value','innerHTML'), -100, -500);" title="<?php echo $this->_tpl_vars['LANG']['musicalbum_delete_album']; ?>
"><?php echo $this->_tpl_vars['LANG']['musicalbum_delete_album']; ?>
</a></span></td>
								<?php else: ?>
									<td colspan = "2"> <?php echo $this->_tpl_vars['LANG']['musicalbum_default_album']; ?>
</td>
								<?php endif; ?>
                             </tr>
                            <?php endforeach; endif; unset($_from); ?>
                            <tr>
                            <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_arr); ?>

                                <td>&nbsp;</td>
                                <td colspan="6">
                                <div class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="button" class="clsSubmitButton" name="button" id="button" value="<?php echo $this->_tpl_vars['LANG']['musicalbum_delete']; ?>
" onclick="getMultiCheckBoxValue('deleMusicForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['musicalbum_err_tip_select_titles']; ?>
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
                    <p><?php echo $this->_tpl_vars['LANG']['musicalbum_no_records_found']; ?>
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