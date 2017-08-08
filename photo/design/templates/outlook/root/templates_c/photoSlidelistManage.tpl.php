<?php /* Smarty version 2.6.18, created on 2013-03-04 20:31:52
         compiled from photoSlidelistManage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'photoSlidelistManage.tpl', 28, false),)), $this); ?>
<?php echo '
	<script language="javascript" type="text/javascript">
       photoslidelistmanage = true;
    </script>
'; ?>


<div class="clsOverflow">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'photomain_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selPhotoPlaylistManage">
  <!-- heading -->
  <div class="clsMainBarHeading">
    <h3> <?php if ($this->_tpl_vars['myobj']->getFormField('photo_playlist_id') != ''): ?>
      <?php echo $this->_tpl_vars['LANG']['photoslidelist_update_playlist_label']; ?>

      <?php else: ?>
      <?php echo $this->_tpl_vars['LANG']['photoslidelist_createlist']; ?>

      <?php endif; ?> </h3>
  </div>
  <!-- information div -->
  <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <!-- Multi confirmation box -->
  <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
  <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

 	 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popupbox_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <p id="confirmMessage"></p>
    <form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
      <input type="submit" class="clsPopUpButtonSubmit" name="confirm_action" id="confirm_action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_confirm']; ?>
" />
      &nbsp;
      <input type="button" class="clsPopUpButtonReset" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
"  onClick="return hideAllBlocks('selFormForums');" />
      <input type="hidden" name="photo_playlist_ids" id="photo_playlist_ids" />
      <input type="hidden" name="action" id="action" />
      <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_arr); ?>

    </form>
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

   <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popupbox_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  </div>
  <!-- confirmation box-->
  <!-- Single confirmation box -->
  <div id="selMsgConfirmSingle" class="clsPopupConfirmation" style="display:none;">
  <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

 	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popupbox_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <p id="confirmMessageSingle"></p>
    <form name="msgConfirmformSingle" id="msgConfirmformSingle" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
      <input type="submit" class="clsPopUpButtonSubmit" name="confirm_action" id="confirm_action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_confirm']; ?>
" />
      &nbsp;
      <input type="button" class="clsPopUpButtonReset" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
"  onClick="return hideAllBlocks('selFormForums');" />
      <input type="hidden" name="photo_playlist_ids" id="photo_playlist_ids" />
      <input type="hidden" name="action" id="action" />
      <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_arr); ?>

    </form>
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popupbox_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  </div>
  <!-- confirmation box-->
  <!-- Create playlist block -->
  <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('create_playlist_block')): ?>
  <form name="photoPlayListManage" id="photoPlayListManage" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" >
    <div class="clsDataTable clsBorderBottom">
      <table class="clsCreateAlbumTb1">
        <tr>
          <td align="left" valign="top" class="clsFormFieldCellDefault"><label for="playlist_name"> <?php echo $this->_tpl_vars['LANG']['photoslidelist_name']; ?>
 </label>
            <span class="clsMandatoryFieldIcon">*</span> </td>
          <td align="left" valign="top" class="clsFormFieldCellDefault"><input type="text" name="playlist_name" id="playlist_name" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('playlist_name'); ?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['fieldsize']['photo_playlist_name']['max']; ?>
">
            <p><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('playlist_name'); ?>
</p>
            <p><?php echo $this->_tpl_vars['myobj']->ShowHelpTip('photo_playlist_name','playlist_name'); ?>
 </p></td>
        </tr>
        <tr>
          <td align="left" valign="top" class="clsFormFieldCellDefault"><label for="playlist_description"> <?php echo $this->_tpl_vars['LANG']['photoslidelist_description']; ?>
 </label>
            <span class="clsMandatoryFieldIcon">*</span> </td>
          <td align="left" valign="top" class="clsFormFieldCellDefault clsUploadBlock"><textarea name="playlist_description" id="playlist_description" cols="45" rows="5" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('playlist_description'); ?>
</textarea>
            <p><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('playlist_description'); ?>
</p>
            <p><?php echo $this->_tpl_vars['myobj']->ShowHelpTip('photo_playlist_description','playlist_description'); ?>
 </p></td>
        </tr>
        <tr>
          <td align="left" valign="top" class="clsFormFieldCellDefault">&nbsp;</td>
          <td align="left" valign="top" class="clsFormFieldCellDefault"><input  type="hidden" class="clsSubmitButton" name="photo_playlist_id" id="photo_playlist_id" value="<?php echo $this->_tpl_vars['myobj']->getFormField('photo_playlist_id'); ?>
" />
            <div class="clsSubmitButton-l"><span class="clsSubmitButton-r">
              <input type="submit" class="clsSubmitButton" name="playlist_submit" id="playlist_submit" value="<?php if ($this->_tpl_vars['myobj']->getFormField('photo_playlist_id') != ''): ?><?php echo $this->_tpl_vars['LANG']['photoslidelist_update_playlist_label']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['photoslidelist_create_palylist']; ?>
<?php endif; ?>" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
              </span></div>
            <?php if ($this->_tpl_vars['myobj']->chkIsAdminSide()): ?>
            <div class="clsDeleteButton-l"><span class="clsDeleteButton-r">
              <input type="button" class="clsSubmitButton" name="cancel_submit" id="cancel_submit" value="<?php echo $this->_tpl_vars['LANG']['photoslidelist_Cancel_label']; ?>
" onclick="Redirect2URL('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/photo/photoSlideList.php')"tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
              </span></div>
            <?php else: ?>
            <div class="clsDeleteButton-l"><span class="clsDeleteButton-r">
              <input type="button" class="clsSubmitButton" name="cancel_submit" id="cancel_submit" value="<?php echo $this->_tpl_vars['LANG']['photoslidelist_Cancel_label']; ?>
" onclick="Redirect2URL('<?php echo $this->_tpl_vars['myobj']->createplaylist_url; ?>
')"tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
              </span></div>
            <?php endif; ?> </td>
        </tr>
      </table>
    </div>
  </form>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_playlist_block') && ! $this->_tpl_vars['myobj']->chkIsAdminSide()): ?>
  <form id="delePhotoForm" name="delePhotoForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
    <div id="selPhotoPlaylistManageDisplay">
      <p class="clsPlayListStepsTitle"><?php echo $this->_tpl_vars['LANG']['photoslidelist_title']; ?>
</p>
      <?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
      <div class="clsOverflow clsManageSlideList">
      	<p class="clsPlayListStepsTitle clsFloatLeft">
	  		<input type="checkbox" name="check_all" id="check_all" class="clsRadioButtonBorder" onclick="CheckAll(document.delePhotoForm.name, document.delePhotoForm.check_all.name)" />
	  	</p>
	  		<div class="clsOverflow">
        		<div class="clsDeleteButton-l">
					<span class="clsDeleteButton-r">
          				<input type="button" class="clsSubmitButton" name="button" id="button" value="<?php echo $this->_tpl_vars['LANG']['photoslidelist_delete']; ?>
" onClick="getMultiCheckBoxValue('delePhotoForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['photoslidelist_err_tip_select_titles']; ?>
');if(multiCheckValue!='') getAction('delete')"/>
					</span>
				</div>
      		</div>
      </div>
      <div class="clsOverflow clsSlideBorder">
       <div class="clsPhotoPaging">
      	<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <?php endif; ?>
      </div>
      </div>
      <div class="clsOverflow">
        <?php $this->assign('count', 1); ?>
        <?php $_from = $this->_tpl_vars['myobj']->list_playlist_block['showPlaylists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['photoPlaylistKey'] => $this->_tpl_vars['photoplaylist']):
?>
         <div class="clsListContents">
         <div class="clsNewAlbumList <?php if ($this->_tpl_vars['count'] % 3 == 0): ?> clsThumbPhotoFinalRecord<?php endif; ?>">
           <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

           <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'listimage_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		    <?php if ($this->_tpl_vars['photoplaylist']['getPlaylistImageDetail']['total_record'] > 0): ?>
          		<div class="clsPhotoListDetails" onmouseover="showCaption('slideList_<?php echo $this->_tpl_vars['photoplaylist']['photo_playlist_id']; ?>
');" onmouseout="hideCaption('slideList_<?php echo $this->_tpl_vars['photoplaylist']['photo_playlist_id']; ?>
')">
	           		<div class="clsMultipleImage clsPointer">
           			  <?php $_from = $this->_tpl_vars['photoplaylist']['getPlaylistImageDetail']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['playlistImageDetailKey'] => $this->_tpl_vars['playlistImageDetailValue']):
?>
						   <table  <?php if ($this->_tpl_vars['playlistImageDetailKey'] % 2 == 0): ?>class="clsSlidelistFinalRecord"<?php endif; ?>>
								<tr>
									<td>
                                      <div>
										<a href="<?php echo $this->_tpl_vars['photoplaylist']['playlist_view_link']; ?>
">
											<img src="<?php echo $this->_tpl_vars['playlistImageDetailValue']['playlist_path']; ?>
" alt="<?php echo $this->_tpl_vars['playlistImageDetailValue']['photo_title_word_wrap']; ?>
" title="<?php echo $this->_tpl_vars['playlistImageDetailValue']['photo_title_word_wrap']; ?>
"/>
										</a>
                                      </div>
									</td>
								</tr>
							 </table>
						  <?php endforeach; endif; unset($_from); ?>
						  <?php if ($this->_tpl_vars['photoplaylist']['getPlaylistImageDetail']['total_record'] < 4): ?>
							  <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)0;
$this->_sections['foo']['loop'] = is_array($_loop=$this->_tpl_vars['photoplaylist']['getPlaylistImageDetail']['noimageCount']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
							  <?php $this->assign('countNoImage', $this->_sections['foo']['index']); ?>
							  							  <table <?php if ($this->_tpl_vars['photoplaylist']['getPlaylistImageDetail']['noimageCount'] == 4): ?>
											<?php if ($this->_tpl_vars['countNoImage'] % 2 == 0): ?>class="clsSlidelistFinalRecord"<?php endif; ?>
										<?php elseif ($this->_tpl_vars['photoplaylist']['getPlaylistImageDetail']['noimageCount'] == 3): ?>
											<?php if ($this->_tpl_vars['countNoImage'] == 0 || $this->_tpl_vars['countNoImage'] == 2): ?>class="clsSlidelistFinalRecord"<?php endif; ?>
										<?php elseif ($this->_tpl_vars['photoplaylist']['getPlaylistImageDetail']['noimageCount'] == 2): ?>
											<?php if ($this->_tpl_vars['countNoImage'] == 1): ?>class="clsSlidelistFinalRecord"<?php endif; ?>
										<?php elseif ($this->_tpl_vars['photoplaylist']['getPlaylistImageDetail']['noimageCount'] == 1): ?>
											class="clsSlidelistFinalRecord"
										<?php endif; ?>>
								<tr>
								  <td><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImageSlieList.jpg" /></td>
								</tr>
							  </table>
							  <?php endfor; endif; ?>
						  <?php endif; ?>
				 	</div>
          		</div>
			  <?php else: ?>
				  <div class="clsPhotoListDetails">
					<div class="clsPhotoSlideListNoImage">
						<img  src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/icon-noImageSlieList.jpg" />
					</div>
				</div>
			  <?php endif; ?>
		 <div class="clsOverflow">
          <div class="clsGetEditDel" onmouseover="showCaption('slideList_<?php echo $this->_tpl_vars['photoplaylist']['photo_playlist_id']; ?>
');" onmouseout="hideCaption('slideList_<?php echo $this->_tpl_vars['photoplaylist']['photo_playlist_id']; ?>
')" id="slideList_<?php echo $this->_tpl_vars['photoplaylist']['photo_playlist_id']; ?>
" style="display:none;">
        <ul class="clsContentEditLinks">
          <li class="clsEdit"><a href="<?php echo $this->_tpl_vars['photoplaylist']['edit_link']; ?>
" class="clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['photoslidelist_edit_playlist']; ?>
"><?php echo $this->_tpl_vars['LANG']['photoslidelist_edit_playlist']; ?>
</a></li>
          <li class="clsDelete"><a href="javascript:void(0);" class="clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['photoslidelist_delete_playlist']; ?>
" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle',Array('action','photo_playlist_ids', 'confirmMessageSingle'), Array('delete','<?php echo $this->_tpl_vars['photoplaylist']['photo_playlist_id']; ?>
', '<?php echo $this->_tpl_vars['LANG']['photoslidelist_delete_confirmation']; ?>
'), Array('value','value', 'innerHTML'), -100, -500);"><?php echo $this->_tpl_vars['LANG']['photoslidelist_delete_playlist']; ?>
</a></li>
       <li class="clsManageSlideListPop"><a class="clsPhotoVideoEditLinks" href="<?php echo $this->_tpl_vars['CFG']['site']['photo_url']; ?>
organizeSlidelist.php?photo_slidelist_id=<?php echo $this->_tpl_vars['photoplaylist']['record']['photo_playlist_id']; ?>
" id="manage_<?php echo $this->_tpl_vars['photoplaylist']['record']['photo_playlist_id']; ?>
"><?php echo $this->_tpl_vars['LANG']['photoslidelist_organize_playlist']; ?>
</a></li>
       </ul>
          </div>
          </div>
          <div class="clsAlbumContentDetails">
           <div>
            <p class="clsPhotoSlideListHeading"><input type="checkbox" name="forum_ids[]" id="check" class="clsRadioButtonBorder" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['photoplaylist']['photo_playlist_id']; ?>
" onClick="disableHeading('delePhotoForm');"/>
            <span class="clsHeading"><a href="<?php echo $this->_tpl_vars['photoplaylist']['playlist_view_link']; ?>
" title="<?php echo $this->_tpl_vars['photoplaylist']['playlist_name']; ?>
"><?php echo $this->_tpl_vars['photoplaylist']['playlist_name']; ?>
</a></span> </p>
           </div>
           <p class="clsAlbumContent"><?php echo $this->_tpl_vars['LANG']['photoslidelist_total_photo']; ?>
<span><?php echo $this->_tpl_vars['photoplaylist']['total_photos']; ?>
</span></p>
           </div>
			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

           <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'listimage_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
         </div>
         </div>
         <?php $this->assign('count', $this->_tpl_vars['count']+1); ?>
        <?php endforeach; endif; unset($_from); ?>
        </div>
            <div class="clsOverflow clsSlideBorder">
        <div id="bottomLinks" class="clsPhotoPaging">
         <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
         <?php endif; ?>
        </div>
      </div>
      <?php else: ?>
      <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

       <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popupbox_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
          <div id="selMsgAlert" class="clsNoMarginAlert"><p><?php echo $this->_tpl_vars['LANG']['photoslidelist_no_records_found']; ?>
</p></div>
		  <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

       <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popupbox_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <?php endif; ?> </div>
  </form>
  <?php endif; ?>
 </div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'photomain_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<script>
<?php echo '
$Jq(document).ready(function() {
    for(var i=0;i<manage_slidelist_ids.length;i++)
	{
	$Jq(\'#manage_\'+manage_slidelist_ids[i]).fancybox({
		\'width\'				: 865,
		\'height\'			: 336,
		\'padding\'			:  0,
		\'autoScale\'     	: false,
		\'transitionIn\'		: \'none\',
		\'transitionOut\'		: \'none\',
		\'type\'				: \'iframe\'
	});
	}
});
'; ?>

</script>