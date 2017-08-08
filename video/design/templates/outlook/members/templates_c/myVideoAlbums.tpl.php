<?php /* Smarty version 2.6.18, created on 2011-11-07 10:30:01
         compiled from myVideoAlbums.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'myVideoAlbums.tpl', 22, false),)), $this); ?>
<script language="javascript">
	var block_arr= new Array('selMsgConfirm', 'selMsgConfirmMulti');
</script>
<div id="selMyAlbums">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clsPageHeading">
  	<h2><span><?php echo $this->_tpl_vars['LANG']['videoalbums_title']; ?>
</span></h2>
</div>
	<!--- Delete Single Albums --->
	<div id="selLeftNavigation">
		<div id="selMsgConfirm" style="display:none;" class="clsPopupConfirmation">
    		<p><?php echo $this->_tpl_vars['LANG']['videoalbums_delete_confirmation']; ?>
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
			              	<input type="button" class="clsSubmitButton" name="cancel" id="cancel" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hideAllBlocks()" />
			              	<input type="hidden" name="album_id" id="album_id"/></p>
							
	      	</form>
	    </div>
		<!--- Delete Multi Videos --->
		<div id="selMsgConfirmMulti" style="display:none;" class="clsMsgConfirm">
    		<p><?php echo $this->_tpl_vars['LANG']['multi_delete_confirmation']; ?>
</p>
			<form name="msgConfirmformMulti" id="msgConfirmformMulti" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
	        	<table summary="<?php echo $this->_tpl_vars['LANG']['videoalbums_tbl_summary']; ?>
" class="clsMyVideosTable">
				  	<tr>
		            	<td>
						  	<input type="submit" class="clsSubmitButton" name="delete" id="delete" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /> &nbsp;
			              	<input type="button" class="clsSubmitButton" name="cancel" id="cancel" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                             onClick="return hideAllBlocks()" />
			              	<input type="hidden" name="album_id" id="album_id"/>
													</td>
		          	</tr>
	        	</table>
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
		<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('my_albums_form')): ?>
            <div id="selMyAlbumsDisplay" class="clsLeftSideDisplayTable">
            <?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
                <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
                <div id="topLinks">
                    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                </div>
                <?php endif; ?>

                <p class="clsCreateAlbumTitle" id="selCreateAlbum">
                    <a href="<?php echo $this->_tpl_vars['myobj']->videoalbum_create_link; ?>
"><?php echo $this->_tpl_vars['LANG']['videoalbums_create_new']; ?>
</a>
                </p>
                <form name="deleVideoForm" id="deleVideoForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
                <div class="clsDataTable">
                    <table summary="" class="clsMyVideoAlbumTbl">
                        <tr>
                            <th>
                            <input type="checkbox" class="clsCheckRadio" name="check_all"
                            onclick = "CheckAll(document.deleVideoForm.name, document.deleVideoForm.check_all.name)" />
                            </th>
                            <th><?php echo $this->_tpl_vars['LANG']['videoalbums_album_image']; ?>
</th>
                            <th><?php echo $this->_tpl_vars['LANG']['videoalbums_album_name']; ?>
</th>
                            <th class="clsAlbumVideos"><?php echo $this->_tpl_vars['LANG']['videoalbums_videos']; ?>
</th>
                            <th><?php echo $this->_tpl_vars['LANG']['videoalbums_user_action']; ?>
</th>
                        </tr>
                        <?php $_from = $this->_tpl_vars['myobj']->my_albums_form; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['album']):
?>
                        <tr>
                            <td class="clsWidth20">
                                <input type="checkbox" class="clsCheckRadio" name="album_ids[]" value="<?php echo $this->_tpl_vars['album']['video_album_id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                                <?php echo $this->_tpl_vars['album']['checked']; ?>
 onClick="disableHeading('deleVideoForm');"/>
                            </td>
                            <?php if ($this->_tpl_vars['album']['video_path']): ?>
                            <td id="selVideoGallery" class="clsWidth90">
                                <a id="<?php echo $this->_tpl_vars['album']['anchor']; ?>
" href="#"></a>
                                <div class="">
                                    <div id="<?php echo $this->_tpl_vars['album']['anchor']; ?>
"  class="clsThumbImageLink">
                                        <a href="<?php echo $this->_tpl_vars['album']['abumvideolist_link']; ?>
" class="ClsImageContainer ClsImageBorder Cls107x80 clsPointer">
                                        <img src="<?php echo $this->_tpl_vars['album']['video_path']; ?>
" title="<?php echo $this->_tpl_vars['album']['album_title']; ?>
"  border="0"<?php echo $this->_tpl_vars['album']['disp_image']; ?>
 />
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <?php else: ?>
                            <td id="selVideoGallery">
                                <a id="<?php echo $this->_tpl_vars['anchor']; ?>
" href="#"></a>
                                <p id="selImageBorder">
                                    <a href="#" onClick="return false"><img src="<?php echo $this->_tpl_vars['album']['video_path']; ?>
" width="<?php echo $this->_tpl_vars['CFG']['admin']['videos']['small_width']; ?>
" /></a>
                                </p>
                            </td>
                            <?php endif; ?>
                            <td id="selAlbumName">
                            <?php if ($this->_tpl_vars['album']['total_videos']): ?>
                                <p>
                                    <a href="<?php echo $this->_tpl_vars['album']['abumvideolist_link']; ?>
"><?php echo $this->_tpl_vars['album']['album_title']; ?>
</a>
                                </p>
                            <?php else: ?>
                                <p><?php echo $this->_tpl_vars['album']['album_title']; ?>
</p>
                            <?php endif; ?>
                            </td>
                            <td class="clsAlbumVideos"><?php echo $this->_tpl_vars['album']['total_videos']; ?>
</td>
                            <td class="clsUserAlbumActions">
                                <span class="clsUpload">
                                    <a href="<?php echo $this->_tpl_vars['album']['videoUpload']; ?>
"><?php echo $this->_tpl_vars['LANG']['videoalbums_upload_video']; ?>
</a>
                                </span>

                                <span class="clsAlbumEdit">
                                    	<a href="<?php echo $this->_tpl_vars['album']['createalbum_edit_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['videoalbums_edit']; ?>
</a>
                                </span>
                                <span class="clsDeleteAlbum" id="anchor_<?php echo $this->_tpl_vars['album']['video_album_id']; ?>
">
                                    <a onclick="return Confirmation('selMsgConfirm', 'msgConfirmform',
                                                    Array('act','album_id', 'selVideoId', 'msgConfirmText'), Array('delete','<?php echo $this->_tpl_vars['album']['video_album_id']; ?>
', '<?php echo $this->_tpl_vars['album']['video_path']; ?>
','<?php echo $this->_tpl_vars['LANG']['videoalbums_delete_confirmation']; ?>
'), Array('value','value', 'src', 'innerHTML'), -100, -300,'anchor_<?php echo $this->_tpl_vars['album']['video_album_id']; ?>
');" title="<?php echo $this->_tpl_vars['LANG']['videoalbums_delete_album']; ?>
" class="clsVideoVideoEditLinks" href="#"><?php echo $this->_tpl_vars['LANG']['videoalbums_delete_album']; ?>
</a>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; endif; unset($_from); ?>
                        </table>
						<div class="clsOverflow">
                            <a href="#" id="dAltMulti"></a>
                            <div class="clsGreyButtonLeft">
                                 <div class="clsGreyButtonRight">
                                     <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit"
                                        tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_delete_option']; ?>
" onClick="return deleteMultiCheck('<?php echo $this->_tpl_vars['LANG']['check_atleast_one']; ?>
','dAltMulti','<?php echo $this->_tpl_vars['LANG']['multi_delete_confirmation']; ?>
','deleVideoForm','album_id')" />
                                 </div>
                            </div>
						</div>			

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
                <?php endif; ?>
            <?php else: ?>
            <div id="selMsgAlert">
                <p><?php echo $this->_tpl_vars['LANG']['videoalbums_no_records_found']; ?>
</p>
            </div>
            <p class="clsCreateAlbumTitle" id="selCreateAlbum">
                <a href="<?php echo $this->_tpl_vars['myobj']->videoalbum_create_link; ?>
"><?php echo $this->_tpl_vars['LANG']['videoalbums_create_new']; ?>
</a>
            </p>
            <?php endif; ?>
 		</div>
        <?php endif; ?>

	</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>