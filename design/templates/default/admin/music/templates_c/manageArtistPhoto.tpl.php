<?php /* Smarty version 2.6.18, created on 2011-12-14 00:52:57
         compiled from manageArtistPhoto.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'manageArtistPhoto.tpl', 22, false),)), $this); ?>
<div id="selMusicPlaylistManage">
  <h2>
  		<?php if ($this->_tpl_vars['myobj']->getFormField('artist_id') == ''): ?>
        	<?php echo $this->_tpl_vars['LANG']['manageartist_title']; ?>

        <?php else: ?>
    		<?php echo $this->_tpl_vars['myobj']->page_title; ?>

        <?php endif; ?>
  </h2>
  <br />
  <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_artistlist_block')): ?>
    <form id="form1" name="form1" method="post" action="">
        <table class="clsNoBorder">
            <tr>
            <td class="clsWidthSmall clsFormLabelCellDefault">
                <label><?php echo $this->_tpl_vars['LANG']['manageartist_artist_name']; ?>
               
				</label>
				 </td>
            <td align="left" valign="middle" class="clsFormFieldCellDefault">
			<input type="text" name="name" id="name" class="clsTextBox" /></td>
			</tr>
			<tr>
            <td class="clsFormFieldCellDefault"><input type="submit" name="search" id="search" value="<?php echo $this->_tpl_vars['LANG']['manageartist_search']; ?>
" class="clsSubmitButton" /><input  type="reset" class="clsCancelButton" name="reset_submit" id="reset_submit" value="<?php echo $this->_tpl_vars['LANG']['manageartistphoto_reset_label']; ?>
" onclick="Redirect2URL('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/manageArtistPhoto.php')"tabindex="<?php echo smartyTabIndex(array(), $this);?>
"></td>
            </tr>
        </table>
    </form>
    <div id="selmusicArtistListManageDisplay" class="clsLeftSideDisplayTable">
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
                         <tr>
                            <th class="clsSmallWidth">
                                <?php echo $this->_tpl_vars['LANG']['manageartist_id']; ?>

                            </th>
                            <th class="clsSmallWidth">
                                <?php echo $this->_tpl_vars['LANG']['manageartist_image']; ?>

                            </th>
                            <th>
                                <?php echo $this->_tpl_vars['LANG']['manageartist_name']; ?>
            
				            </th>
                            <th>
                                <?php echo $this->_tpl_vars['LANG']['manageartist_manage_photo']; ?>
     
                           </th>
                        </tr>	
                    <?php $_from = $this->_tpl_vars['myobj']->list_artistlist_block['showArtistlists']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['musicArtistListKey'] => $this->_tpl_vars['musicArtistList']):
?>
                        <tr>
                        	<td class="clsSmallWidth"><?php echo $this->_tpl_vars['musicArtistList']['record']['music_artist_id']; ?>

                            </td>
                            <td class="clsSmallWidth">
                            <a href="manageArtistPhoto.php?artist_id=<?php echo $this->_tpl_vars['musicArtistList']['record']['music_artist_id']; ?>
&artist_name=<?php echo $this->_tpl_vars['musicArtistList']['record']['artist_name']; ?>
">
                            <?php if ($this->_tpl_vars['musicArtistList']['artist_path'] != ''): ?>
                            	<img   src="<?php echo $this->_tpl_vars['musicArtistList']['artist_path']; ?>
"<?php echo $this->_tpl_vars['musicArtistList']['disp_image']; ?>
 title="<?php echo $this->_tpl_vars['musicArtistList']['record']['artist_name']; ?>
"/> 
                            <?php else: ?>   
                               <img   src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_artist_T.jpg" title="<?php echo $this->_tpl_vars['musicArtistList']['record']['artist_name']; ?>
"/>                     
                            <?php endif; ?>
                            </a>
	                        </td>
                             <td>
                            <p><?php echo $this->_tpl_vars['musicArtistList']['record']['artist_name']; ?>
</p>
                            </td>
                          <td class="clsSmallWidth">
                          	<a href="manageArtistPhoto.php?artist_id=<?php echo $this->_tpl_vars['musicArtistList']['record']['music_artist_id']; ?>
&artist_name=<?php echo $this->_tpl_vars['musicArtistList']['record']['artist_name']; ?>
"><?php echo $this->_tpl_vars['LANG']['manageartist_clickhere']; ?>
</a>
                            <p><?php echo $this->_tpl_vars['LANG']['manageartistphoto_photo_approved']; ?>
(<?php echo $this->_tpl_vars['myobj']->getArtistPhotoStatusCount($this->_tpl_vars['musicArtistList']['record']['music_artist_id'],'Yes'); ?>
)</p>
                            <p> <?php echo $this->_tpl_vars['LANG']['manageartistphoto_photo_waiting']; ?>
(<?php echo $this->_tpl_vars['myobj']->getArtistPhotoStatusCount($this->_tpl_vars['musicArtistList']['record']['music_artist_id'],'ToActivate'); ?>
)</p>
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
                    <?php echo $this->_tpl_vars['LANG']['manageartist_no_records_found']; ?>

          </div>    
            <?php endif; ?>    
        </div>
     <?php endif; ?>
    <!-- information div -->		
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <!-- Upload photo block Start-->
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('upload_photo_block')): ?>
    	<a onclick="divShowHide('upload_photo_block', 'show_link', 'hide_link')"   id="show_link" href="javascript:void(0)"><?php echo $this->_tpl_vars['LANG']['manageartistphoto_upload_artist_photo']; ?>
</a>
        <a onclick="divShowHide('upload_photo_block', 'show_link', 'hide_link')"  style="display:none" id="hide_link" href="javascript:void(0)"><?php echo $this->_tpl_vars['LANG']['manageartistphoto_upload_artist_photo']; ?>
</a>
        <div id="upload_photo_block" <?php if (! $this->_tpl_vars['myobj']->flag): ?> style="display:none" <?php endif; ?>>
            <form action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" method="post"   enctype="multipart/form-data" name="musicPlayListManage" >
                <table  class="clsCreateAlbumTable clsNoBorder">
                    <tr>
                        <td class="clsSmallWidth" align="left" valign="top">
                            <label for="artist_photo">
                            <?php echo $this->_tpl_vars['LANG']['manageartistphoto_upload_photo']; ?>
 <?php echo $this->_tpl_vars['myobj']->photosize_detail; ?>

                            </label>        
                        </td>
                        <td align="left" valign="top">
                            <input type="file" name="artist_photo" id="artist_photo" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                            <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('artist_photo'); ?>

                            <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('artist_photo','artist_photo'); ?>
 
                        </td>
                    </tr>
                   <!-- <tr>
                        <td align="left" valign="top">
                            <label for="image_caption">
                            <?php echo $this->_tpl_vars['LANG']['manageartistphoto_photo_caption']; ?>

                            </label>
                        </td>
                        <td align="left" valign="top">
                            <textarea name="image_caption" id="image_caption" cols="45" rows="5" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('image_caption'); ?>
</textarea>
                            <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('image_caption'); ?>

                            <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('image_caption','image_caption'); ?>
 
                        </td>
                    </tr>-->
                    <tr>
                        <td>&nbsp;
                            
                        </td>
                        <td>
                            <input type="submit" name="upload" id="upload" value="<?php echo $this->_tpl_vars['LANG']['manageartistphoto_upload']; ?>
" class="clsSubmitButton" />
                       </td>
                    </tr>
                </table>
            </form>
        </div>
    <?php endif; ?>
    <!-- Upload photo block End-->
     <!-- Single confirmation box -->
    <div id="selMsgConfirmSingle" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessageSingle"></p>
		<form name="msgConfirmformSingle" id="msgConfirmformSingle" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
			<table summary="<?php echo $this->_tpl_vars['LANG']['manageartist_detail']; ?>
" class="clsNoBorder">
				<tr>
					<td>
                    	<img id="artistImg" border="0" />
					</td>
				</tr>
				<tr>
					<td>	
						
						<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_confirm']; ?>
" />
						&nbsp;
						<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
"  onClick="return hideAllBlocks('selFormForums');" />
						<input type="hidden" name="music_artist_image" id="music_artist_image" />
						<input type="hidden" name="action" id="action" />
						<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_arr); ?>

					</td>
				</tr>
			</table>
		</form>
	</div>
    <!-- confirmation box-->
    <!-- confirmation box -->
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
			<table summary="<?php echo $this->_tpl_vars['LANG']['manageartistphoto_confirm_tbl_summary']; ?>
">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_confirm']; ?>
" />
						&nbsp;
						<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
"  onClick="return hideAllBlocks('selFormForums');" />
						<input type="hidden" name="music_artist_image" id="music_artist_image" />
						<input type="hidden" name="action" id="action" />
						<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_arr); ?>

					</td>
				</tr>
			</table>
		</form>
	</div>
    <!-- confirmation box-->
    <!-- Photo list block start-->    
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_photo_block')): ?>
       	<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
            <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
                    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin'); ?>

                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>
            <form name="selFormArtistPhoto" id="selFormArtistPhoto" method="post" action="announcement.php">
            <table >
                <tr>
                    <th class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="CheckAll(document.selFormArtistPhoto.name, document.selFormArtistPhoto.check_all.name)"/></th>
                    <th><?php echo $this->_tpl_vars['LANG']['manageartistphoto_image']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['LANG']['manageartistphoto_photo_mainphoto']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['LANG']['manageartistphoto_photo_status']; ?>
</th>
                   <!-- <th><?php echo $this->_tpl_vars['LANG']['manageartistphoto_caption']; ?>
</th>-->
                    <th><?php echo $this->_tpl_vars['LANG']['manageartistphoto_action']; ?>
</th>
                </tr>
            <?php $_from = $this->_tpl_vars['myobj']->list_photo_block['showArtistImageList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['asKey'] => $this->_tpl_vars['saValue']):
?>
                <tr>
                    <td class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="forum_ids[]" value="<?php echo $this->_tpl_vars['saValue']['record']['music_artist_image']; ?>
" onClick="disableHeading('selFormArtistPhoto');" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/></td>
                    <td><p>
                    
                    	 <?php if ($this->_tpl_vars['saValue']['artist_image'] != ''): ?>
                            	<img src="<?php echo $this->_tpl_vars['saValue']['artist_image']; ?>
" title="" <?php echo $this->_tpl_vars['saValue']['disp_image']; ?>
/>
                            <?php else: ?>   
                               <img   src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_artist_T.jpg" title="<?php echo $this->_tpl_vars['musicArtistList']['record']['artist_name']; ?>
"/>                     
                            <?php endif; ?>
                    </p></td>
                    <td><?php if ($this->_tpl_vars['saValue']['record']['main_img'] == '1'): ?><?php echo $this->_tpl_vars['LANG']['manageartistphoto_yes_label']; ?>
<?php else: ?> <?php echo $this->_tpl_vars['LANG']['manageartistphoto_no_label']; ?>
<?php endif; ?></td>
                    <td>
                    	<?php if ($this->_tpl_vars['saValue']['record']['status'] == 'Yes'): ?> 
                        	<?php echo $this->_tpl_vars['LANG']['common_display_active']; ?>
 
                        <?php elseif ($this->_tpl_vars['saValue']['record']['status'] == 'No'): ?>
                        	<?php echo $this->_tpl_vars['LANG']['common_display_inactive']; ?>
 
                        <?php elseif ($this->_tpl_vars['saValue']['record']['status'] == 'ToActivate'): ?>    
                        	<?php echo $this->_tpl_vars['LANG']['manageartistphoto_photo_waiting']; ?>
 	
                        <?php endif; ?>
                    
                    </td>
                    <!--<td><p title="<?php echo $this->_tpl_vars['saValue']['record']['image_caption']; ?>
"><?php echo $this->_tpl_vars['saValue']['record']['image_caption']; ?>
</p></td>-->
                    <td>
                        <p>
	                        <a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle',Array('action', 'music_artist_image', 'artistImg', 'confirmMessageSingle'), Array('Delete', '<?php echo $this->_tpl_vars['saValue']['record']['music_artist_image']; ?>
', '<?php echo $this->_tpl_vars['saValue']['artist_image']; ?>
', '<?php echo $this->_tpl_vars['LANG']['manageartistphoto_delete_confirmation']; ?>
'), Array('value', 'value', 'src', 'innerHTML'), -100, -500);"><?php echo $this->_tpl_vars['LANG']['manageartistphoto_delete']; ?>
</a>                        
                        <p>
                        <?php if ($this->_tpl_vars['saValue']['record']['status'] == 'No'): ?>
                            <p>
                                <a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle',Array('action', 'music_artist_image', 'artistImg', 'confirmMessageSingle'), Array('Active', '<?php echo $this->_tpl_vars['saValue']['record']['music_artist_image']; ?>
', '<?php echo $this->_tpl_vars['saValue']['artist_image']; ?>
', '<?php echo $this->_tpl_vars['LANG']['manageartistphoto_active_confirm_message']; ?>
'), Array('value', 'value', 'src', 'innerHTML'), -100, -500);"><?php echo $this->_tpl_vars['LANG']['common_display_active']; ?>
</a>                        
                            <p>
                        <?php elseif ($this->_tpl_vars['saValue']['record']['status'] == 'Yes'): ?>
                            <p>
                                <a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle',Array('action', 'music_artist_image', 'artistImg', 'confirmMessageSingle'), Array('Inactive', '<?php echo $this->_tpl_vars['saValue']['record']['music_artist_image']; ?>
', '<?php echo $this->_tpl_vars['saValue']['artist_image']; ?>
', '<?php echo $this->_tpl_vars['LANG']['manageartistphoto_inactive_confirm_message']; ?>
'), Array('value', 'value', 'src', 'innerHTML'), -100, -500);"><?php echo $this->_tpl_vars['LANG']['common_display_inactive']; ?>
</a>                        
                            <p>
                        <?php elseif ($this->_tpl_vars['saValue']['record']['status'] == 'ToActivate'): ?>    
                            <p>
                                <a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle',Array('action', 'music_artist_image', 'artistImg', 'confirmMessageSingle'), Array('Approve', '<?php echo $this->_tpl_vars['saValue']['record']['music_artist_image']; ?>
', '<?php echo $this->_tpl_vars['saValue']['artist_image']; ?>
', '<?php echo $this->_tpl_vars['LANG']['manageartistphoto_approve_confirm_message']; ?>
'), Array('value', 'value', 'src', 'innerHTML'), -100, -500);"><?php echo $this->_tpl_vars['LANG']['manageartistphoto_photo_approve']; ?>
</a> /                       
                              	<a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle',Array('action', 'music_artist_image', 'artistImg', 'confirmMessageSingle'), Array('Delete', '<?php echo $this->_tpl_vars['saValue']['record']['music_artist_image']; ?>
', '<?php echo $this->_tpl_vars['saValue']['artist_image']; ?>
', '<?php echo $this->_tpl_vars['LANG']['manageartistphoto_disapprove_confirm_message']; ?>
'), Array('value', 'value', 'src', 'innerHTML'), -100, -500);"><?php echo $this->_tpl_vars['LANG']['manageartistphoto_photo_disapprove']; ?>
</a>                          
                            <p>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['saValue']['record']['main_img']): ?>	
                        	<p>	
                            	<a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle',Array('action', 'music_artist_image', 'artistImg', 'confirmMessageSingle'), Array('remove_main_img', '<?php echo $this->_tpl_vars['saValue']['record']['music_artist_image']; ?>
', '<?php echo $this->_tpl_vars['saValue']['artist_image']; ?>
', '<?php echo $this->_tpl_vars['LANG']['manageartist_confirm_remove_lyrics']; ?>
'), Array('value', 'value', 'src', 'innerHTML'), -100, -500);"><?php echo $this->_tpl_vars['LANG']['managelyrics_remove_main_photo']; ?>
</a>                           </p> 
                         <?php else: ?>   
                         	<p>	
                            	<a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle',Array('action', 'music_artist_image', 'artistImg', 'confirmMessageSingle'), Array('main_img', '<?php echo $this->_tpl_vars['saValue']['record']['music_artist_image']; ?>
', '<?php echo $this->_tpl_vars['saValue']['artist_image']; ?>
', '<?php echo $this->_tpl_vars['LANG']['manageartistphoto_confirm_main_image']; ?>
'), Array('value', 'value', 'src', 'innerHTML'), -100, -500);"><?php echo $this->_tpl_vars['LANG']['manageartistphoto_main_image']; ?>
</a>                           </p>             	
                         <?php endif; ?>					</td>
                </tr>
            <?php endforeach; endif; unset($_from); ?>  
             <tr>
                    <td colspan="6">
                    	<select name="action_val" id="action_val" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                        <option value=""><?php echo $this->_tpl_vars['LANG']['common_select_action']; ?>
</option>
                        <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->list_photo_block['action_arr'],$this->_tpl_vars['myobj']->getFormField('action')); ?>

                        </select>
                    	<input type="button" name="action_button" class="clsSubmitButton" id="action_button" value="<?php echo $this->_tpl_vars['LANG']['manageartistphoto_submit']; ?>
" onClick="getMultiCheckBoxValue('selFormArtistPhoto', 'check_all', '<?php echo $this->_tpl_vars['LANG']['manageartistphoto_err_tip_select_titles']; ?>
');if(multiCheckValue!='') getAction()"/>
                        <input type="button" class="clsCancelButton" name="cancel_submit" id="cancel_submit" value="<?php echo $this->_tpl_vars['LANG']['manageartistphoto_cancel_label']; ?>
" onclick="Redirect2URL('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/manageArtistPhoto.php')"tabindex="<?php echo smartyTabIndex(array(), $this);?>
">                        </td>
              </tr>   
             </table>   
  </form>
              
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
                <?php echo $this->_tpl_vars['LANG']['manageartistphoto_no_records_found']; ?>

            </div>    
        <?php endif; ?> 
    <?php endif; ?>
     <!-- Photo list block end-->   
</div>