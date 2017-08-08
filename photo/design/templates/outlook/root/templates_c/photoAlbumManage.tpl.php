<?php /* Smarty version 2.6.18, created on 2012-01-21 09:36:59
         compiled from photoAlbumManage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'photoAlbumManage.tpl', 21, false),)), $this); ?>
<div id="selPhotoPlaylistManage" class="clsOverflow">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'photomain_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<!-- heading -->
	<div class="clsMainBarHeading"><h3>
    	<?php if ($this->_tpl_vars['myobj']->getFormField('photo_album_id') != ''): ?>
        	<?php echo $this->_tpl_vars['LANG']['photoalbum_update_album_label']; ?>

        <?php else: ?>
        	<?php echo $this->_tpl_vars['LANG']['photoalbum_createlist']; ?>

        <?php endif; ?>
    </h3></div>
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
                <input type="hidden" name="photo_album_ids" id="photo_album_ids" />
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
                <input type="hidden" name="photo_album_ids" id="photo_album_ids" />
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
    <!-- Create album block -->
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('create_album_block')): ?>
    <form name="photoAlbumManages" id="photoAlbumManages" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" >
            <div class="clsDataTable clsBorderBottom"><table class="clsCreateAlbumTable">
              <tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                	<label for="photoalbum_title">
                    	<?php echo $this->_tpl_vars['LANG']['photoalbum_title']; ?>

                    </label><?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>

                </td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">

                	<input type="text" name="photo_album_title" id="photo_album_title" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('photo_album_title'); ?>
">
                	<p><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('photo_album_title'); ?>
</p>
                   <p><?php echo $this->_tpl_vars['myobj']->ShowHelpTip('photo_album_title','photo_album_title'); ?>
 </p></td>
              </tr>
              <tr>
              	<td align="left" valign="top" class="clsFormFieldCellDefault"><label for="album_access_type"><?php echo $this->_tpl_vars['LANG']['photoalbum_album_access_type']; ?>
</label></td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                	<input type="radio" name="album_access_type" id="album_access_type" class="clsRadioButtonBorder" value="Private" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('album_access_type','Private'); ?>
 /> <strong><?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
</strong>
                	<input type="radio" name="album_access_type" id="album_access_type" class="clsRadioButtonBorder" value="Public" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('album_access_type','Public'); ?>
  /> <strong><?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
</strong>
                </td>
              </tr>
              <tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault">&nbsp;</td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">

                    <input  type="hidden" class="clsSubmitButton" name="photo_album_id" id="photo_album_id" value="<?php echo $this->_tpl_vars['myobj']->getFormField('photo_album_id'); ?>
" />
                  <div class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" class="clsSubmitButton" name="album_submit" id="album_submit" value="<?php if ($this->_tpl_vars['myobj']->getFormField('photo_album_id') != ''): ?><?php echo $this->_tpl_vars['LANG']['photoalbum_update_album_label']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['photoalbum_create_palylist']; ?>
<?php endif; ?>" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"></span></div>
                                	<div class="clsDeleteButton-l"><span class="clsDeleteButton-r"><input type="button" class="clsSubmitButton" name="cancel_submit" id="cancel_submit" value="<?php echo $this->_tpl_vars['LANG']['photoalbum_Cancel_label']; ?>
" onclick="Redirect2URL('<?php echo $this->_tpl_vars['myobj']->createalbum_url; ?>
')"tabindex="<?php echo smartyTabIndex(array(), $this);?>
"></span></div>
                                </td>
              </tr>
            </table>
          </div>
  </form>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_album_block')): ?>
    	<div id="selPhotoPlaylistManageDisplay" class="clsManageCommentsDisplay">
            <?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
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
               <form id="delePhotoForm" name="delePhotoForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
                    <div class="clsDataTable">
                        <table class="clsManageCommentsTb1 clsBorderBottom">
                            <tr>
                                <th class="clsBorderLeft"><input type="checkbox" name="check_all" id="check_all" class="clsRadioButtonBorder" onclick="CheckAll(document.delePhotoForm.name, document.delePhotoForm.check_all.name)" /></th>
                                 <th class="<?php echo $this->_tpl_vars['myobj']->getOrderCss('photoalbum_title'); ?>
 clsSelectLarge"><a href="javascript:void(0)" onclick="return changeOrderbyElements('delePhotoForm','photo_album_title')" title="<?php echo $this->_tpl_vars['LANG']['photoalbum_title']; ?>
"><?php echo $this->_tpl_vars['LANG']['photoalbum_title']; ?>
</a></th>
                                <th><?php echo $this->_tpl_vars['LANG']['photoalbum_totla_photo']; ?>
</th>
                                <th class="<?php echo $this->_tpl_vars['myobj']->getOrderCss('album_access_type'); ?>
"><a href="javascript:void(0)" onclick="return changeOrderbyElements('delePhotoForm','album_access_type')" title="<?php echo $this->_tpl_vars['LANG']['photoalbum_access_type']; ?>
"><?php echo $this->_tpl_vars['LANG']['photoalbum_access_type']; ?>
</a></th>
                                <th colspan="4" class="clsUserActionTh"><?php echo $this->_tpl_vars['LANG']['photoalbum_user_action']; ?>
</th>
                            </tr>
                            <?php $_from = $this->_tpl_vars['myobj']->list_album_block['showAlbums']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['photoPlaylistKey'] => $this->_tpl_vars['photoalbum']):
?>
                            <tr>
                                <td class="clsBorderLeft clsCheckBoxWidth">
									<?php if ($this->_tpl_vars['photoalbum']['photo_album_id'] != 1): ?>
									<input type="checkbox" name="photo_album_ids[]" id="check" class="clsRadioButtonBorder" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['photoalbum']['photo_album_id']; ?>
" onClick="disableHeading('delePhotoForm');"/>
									<?php endif; ?>
									</td>
                                <td><a href="<?php echo $this->_tpl_vars['photoalbum']['album_view_link']; ?>
" title="<?php echo $this->_tpl_vars['photoalbum']['photo_album_title']; ?>
"><?php echo $this->_tpl_vars['photoalbum']['album_wrap_title']; ?>
</a></td>
								<td><?php echo $this->_tpl_vars['myobj']->getPhotoCount($this->_tpl_vars['photoalbum']['photo_album_id']); ?>
</td>
								<td><?php echo $this->_tpl_vars['photoalbum']['album_access_type']; ?>
</td>
                                <td class="clsMngComments clsTableNoBorder"><a class="clsEdit clsPhotoVideoEditLinks"  href="<?php echo $this->_tpl_vars['photoalbum']['edit_link']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['photoalbum_edit_album']; ?>
"><?php echo $this->_tpl_vars['LANG']['photoalbum_edit_album']; ?>
</a></td>
								<td  class="clsMngComments">
								<?php if ($this->_tpl_vars['photoalbum']['photo_album_id'] != 1): ?>
								<a class="clsDelete clsPhotoVideoEditLinks" href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle',Array('action','photo_album_ids','confirmMessageSingle'), Array('delete','<?php echo $this->_tpl_vars['photoalbum']['photo_album_id']; ?>
', '<?php echo $this->_tpl_vars['LANG']['photoalbum_delete_confirmation']; ?>
'), Array('value','value','innerHTML'), -100, -500);" title="<?php echo $this->_tpl_vars['LANG']['photoalbum_delete_album']; ?>
"><?php echo $this->_tpl_vars['LANG']['photoalbum_delete_album']; ?>
</a>
								<?php endif; ?>
								</td>
                            <?php endforeach; endif; unset($_from); ?>
                            <tr>
                            <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_arr); ?>

                            </table>
                 <div class="clsManageCommentsBtn clsOverflow">
                 <div class="clsDeleteButton-l"><span class="clsDeleteButton-r">
				 <input type="button" class="clsSubmitButton" name="button" id="button" value="<?php echo $this->_tpl_vars['LANG']['photoalbum_delete']; ?>
" onClick="getMultiCheckBoxValue('delePhotoForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['photoalbum_err_tip_select_titles']; ?>
');if(multiCheckValue!='') getAction('delete')"/></span></div>

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
        		</div>
                 <?php else: ?>
                 <div id="selMsgAlert">
                    <p><?php echo $this->_tpl_vars['LANG']['photoalbum_no_records_found']; ?>
</p>
                 </div>
               <?php endif; ?>
              </div>
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