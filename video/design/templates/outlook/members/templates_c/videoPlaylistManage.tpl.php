<?php /* Smarty version 2.6.18, created on 2011-10-31 10:10:00
         compiled from videoPlaylistManage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'videoPlaylistManage.tpl', 28, false),)), $this); ?>
<script language="javascript">
	var block_arr= new Array('selMsgConfirm', 'selMsgConfirmMulti');
</script>
<div id="selMyPlaylists">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div>
    <div class="clsPageHeading">
    <h2><?php echo $this->_tpl_vars['LANG']['playlist_create']; ?>
</h2>
    </div>
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('msg_form_success_create')): ?>
     <div id="selMsgSuccess">
        <p><?php echo $this->_tpl_vars['myobj']->getCommonSuccessMsg(); ?>
</p>
     </div>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('msg_form_error_create')): ?>
         <div id="selMsgError">
        <p><?php echo $this->_tpl_vars['myobj']->getCommonErrorMsg(); ?>
</p>
     </div>
    <?php endif; ?>
    <div class="clsDataTable" id="selUploadBlock">
    <form id="videoPlaylistManageFrm" name="videoPlaylistManagefrm" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" method="post" >
    <input type="hidden" name="use" value="<?php echo $this->_tpl_vars['myobj']->getFormField('use'); ?>
" />
    <table class="clsCreateAlbumTable">
                <tr>
                    <td class="clsFormFieldCellDefault"><label for="playlist_name"><?php echo $this->_tpl_vars['myobj']->videoplaylist_playlist_name_lang; ?>
<?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
</label></td>
                    <td class="clsFormFieldCellDefault"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('playlist_name'); ?>

                    <input class="clsTextBox" type="text" name="playlist_name" id="playlist_name" value="<?php echo $this->_tpl_vars['myobj']->getFormField('playlist_name'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                     <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('playlist_name'); ?>

                    </td>
                </tr>
                <tr>
                    <td class="clsFormFieldCellDefault"><label for="playlist_description"><?php echo $this->_tpl_vars['LANG']['playlist_description']; ?>
<?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
</label></td>
                    <td class="clsFormFieldCellDefault"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('playlist_description'); ?>

                    <textarea type="text" name="playlist_description" id="playlist_description" cols="20" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('playlist_description'); ?>
</textarea>
                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('playlist_description'); ?>

                    </td>
                </tr>
                <tr>
                     <td class="clsFormFieldCellDefault"><label for="playlist_tags"><?php echo $this->_tpl_vars['LANG']['playlist_tags']; ?>
<?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
</label></td>
                    <td class="clsFormFieldCellDefault"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('playlist_tags'); ?>

                    <input class="clsTextBox" type="text" name="playlist_tags" id="playlist_tags"  value="<?php echo $this->_tpl_vars['myobj']->getFormField('playlist_tags'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/>
                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('playlist_tags'); ?>

                    </td>
                </tr>
                
                <tr>
                	<td></td><td>   <div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="playlist_submit" id="playlist_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['playlist_create']; ?>
"/></div></div>
                    </td>
                </tr>

                </table>
               </form>
            </div>
    </div>
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clsPageHeading">
  	<h2><?php echo $this->_tpl_vars['LANG']['videoplaylist_title']; ?>
</h2>
</div>

    <?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
	<!--- Delete Single Playlists --->
	<div id="selLeftNavigation">
		<div id="selMsgConfirm" style="display:none;" class="clsPopupConfirmation">
    		<p><?php echo $this->_tpl_vars['LANG']['videoplaylist_delete_confirmation']; ?>
</p>
	      	<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">

							<p id="selImageBorder" class="clsPlainImageBorder">
                                <span id="selPlainCenterImage">
                                    <img id="selVideoId" border="0" />
                                </span>
                            </p>

						  	<p><input type="submit" class="clsSubmitButton" name="delete" id="delete" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /> &nbsp;
			              	 <input type="button" class="clsSubmitButton" name="no" id="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
"
                                            tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hideAllBlocks()" />
			              	<input type="hidden" name="playlist_id" id="playlist_id"/></p>
							
	      	</form>
	    </div>
		<!--- Delete Multi Videos --->
		<div id="selMsgConfirmMulti" style="display:none;" class="clsMsgConfirm">
    		<p><?php echo $this->_tpl_vars['LANG']['videoplaylist_multi_delete_confirmation']; ?>
</p>
	      	<form name="msgConfirmformMulti" id="msgConfirmformMulti" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">

						  	<p><input type="submit" class="clsSubmitButton" name="delete" id="delete" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /> &nbsp;
			              	<input type="button" class="clsSubmitButton" name="cancel" id="cancel" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                             onClick="return hideAllBlocks()" />
			              	<input type="hidden" name="playlist_id" id="playlist_id"/></p>
							
	      	</form>
	    </div>
		<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('msg_form_error')): ?>
		<div id="selMsgError">
			<p><?php echo $this->_tpl_vars['myobj']->getCommonErrorMsg(); ?>
</p>
		</div>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('msg_form_success')): ?>
    	<div id="selMsgSuccess">
			<p><?php echo $this->_tpl_vars['myobj']->getCommonErrorMsg(); ?>
</p>
		</div>
        <?php endif; ?>
		<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('my_playlist_form')): ?>
            <div id="selMyPlaylistsDisplay" class="clsLeftSideDisplayTable">
            <?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
                <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
                    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                 <?php endif; ?>
                <form name="deleVideoForm" id="deleVideoForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
                    <div class="clsDataTable">
                        <table summary="" class="clsMyVideoPlaylistTbl">
                            <tr>
                                <th>
                                <input type="checkbox" class="clsCheckRadio" name="check_all"
                                onclick="CheckAll(document.deleVideoForm.name, document.deleVideoForm.check_all.name)" />
                                </th>
                                <th><?php echo $this->_tpl_vars['LANG']['videoplaylist_playlist_image']; ?>
</th>
                                <th><?php echo $this->_tpl_vars['LANG']['videoplaylist_playlist_name']; ?>
</th>
                                <th class="clsPlaylistVideos"><?php echo $this->_tpl_vars['LANG']['videoplaylist_videos']; ?>
</th>
	                                                            <th class="clsUserActionTd"><?php echo $this->_tpl_vars['LANG']['videoplaylist_user_action']; ?>
</th>
                            </tr>
                            <?php $_from = $this->_tpl_vars['myobj']->my_playlists_form; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['playlist']):
?>
                            <tr>
                                <td class="clsWidth20">
                                    <input type="checkbox" class="clsCheckRadio" name="playlist_ids[]" value="<?php echo $this->_tpl_vars['playlist']['playlist_id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                                    <?php echo $this->_tpl_vars['playlist']['checked']; ?>
 onClick="disableHeading('deleVideoForm');"/>
                                </td>
                                <?php if ($this->_tpl_vars['playlist']['video_path']): ?>
                                <td id="selVideoGallery" class="clsWidth90">
                                    <a id="<?php echo $this->_tpl_vars['playlist']['anchor']; ?>
" href="#"></a>
                                    <p id="selImageBorder" class="clsViewThumbImage">
                                        <div  class="clsThumbImageLink clsPointer">
                                            <a href="<?php echo $this->_tpl_vars['playlist']['playlist_view_link']; ?>
" class="ClsImageContainer ClsImageBorder Cls107x80 clsPointer">
                                          	  <img src="<?php echo $this->_tpl_vars['playlist']['video_path']; ?>
" <?php echo $this->_tpl_vars['playlist']['disp_image']; ?>
 border="0" />
                                            </a>
                                        </div>
                                    </p>
                                </td>
                                <?php else: ?>
                                <td id="selVideoGallery">
                                    <a id="<?php echo $this->_tpl_vars['anchor']; ?>
" href="#"></a>
                                    <p id="selImageBorder">
                                        <div onclick="return false;" class="clsThumbImageLink clsPointer">
                                           <div class="ClsImageContainer ClsImageBorder Cls107x80 clsPointer">
			                                   <img src="<?php echo $this->_tpl_vars['playlist']['video_path']; ?>
" width="<?php echo $this->_tpl_vars['CFG']['admin']['videos']['small_width']; ?>
" />
                                           </div>
		                             </div>
                                    </p>
                                </td>
                                <?php endif; ?>
                                <td id="selPlaylistName">
                                    <p>
                                        <a href="<?php echo $this->_tpl_vars['playlist']['playlist_view_link']; ?>
"><?php echo $this->_tpl_vars['playlist']['playlist_name']; ?>
</a>
                                    </p>
                                </td>
                                <td class="clsPlaylistVideos"><?php echo $this->_tpl_vars['playlist']['total_videos']; ?>
</td>
                                                               <td class="clsUserPlaylistActions">
                                    <p class="clsEdit">
                                        <span><a href="<?php echo $this->_tpl_vars['playlist']['playlist_edit_link']; ?>
"><?php echo $this->_tpl_vars['LANG']['playlist_edit']; ?>
</a></span>
                                    </p>
                                    <p class="clsDelete">
                                    <span><a onclick="return Confirmation('selMsgConfirm', 'msgConfirmform',
                                                    Array('act','playlist_id', 'selVideoId', 'msgConfirmText'), Array('delete','<?php echo $this->_tpl_vars['playlist']['playlist_id']; ?>
', '<?php echo $this->_tpl_vars['playlist']['video_path']; ?>
','<?php echo $this->_tpl_vars['LANG']['videoplaylist_delete_confirmation']; ?>
'), Array('value','value', 'src', 'innerHTML'), -100, -500);" title="<?php echo $this->_tpl_vars['LANG']['videoplaylist_delete_playlist']; ?>
" class="clsVideoVideoEditLinks" href="#"><?php echo $this->_tpl_vars['LANG']['videoplaylist_delete_playlist']; ?>
</a></span>
                                    </p>
                                </td>
                            </tr>
                            <?php endforeach; endif; unset($_from); ?>
                            <tr>
                                <td></td><td colspan="5">
                                    <a href="#" id="dAltMulti"></a>
                                     <div class="clsGreyButtonLeft">
                                         <div class="clsGreyButtonRight">
                                             <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_delete_option']; ?>
" onClick="return deleteVideoMultiCheck('<?php echo $this->_tpl_vars['LANG']['common_check_atleast_one']; ?>
','dAltMulti','<?php echo $this->_tpl_vars['LANG']['videoplaylist_multi_delete_confirmation']; ?>
','deleVideoForm','playlist_id')" />
                                         </div>
                                     </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
                <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
                    <div id="bottomLinks">
                       <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                     </div>
                <?php else: ?>
                    <div id="selMsgAlert">
                    <p><?php echo $this->_tpl_vars['LANG']['videoplaylist_no_records_found']; ?>
</p>
                </div>
                <?php endif; ?>
            <?php endif; ?>
            </div>
        <?php endif; ?>
	</div>
    <?php else: ?>
    	 <div id="selMsgAlert">
            <p><?php echo $this->_tpl_vars['LANG']['common_video_no_records_found']; ?>
</p>
        </div>
   	<?php endif; ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>