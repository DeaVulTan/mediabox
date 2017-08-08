<?php /* Smarty version 2.6.18, created on 2011-10-18 17:32:24
         compiled from slideList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'slideList.tpl', 52, false),)), $this); ?>
<?php if (! isAjaxPage ( )): ?>
<style type="text/css">
<?php echo '
.clsDisplayNone
{
display:none;
}
'; ?>

</style>
<script language="javascript" type="text/javascript">
	var selectionError ="<?php echo $this->_tpl_vars['LANG']['playlist_selection_error']; ?>
";
	var invalidPlaylist="<?php echo $this->_tpl_vars['LANG']['playlist_invalid']; ?>
";
</script>
<div id="viewPhotoSlidelist" class="clsTextAlignLeft clsOverflow clsPlaylistLabel">
	<div id="clsMsgDisplay_playlist_success" class="clsDisplayNone clsPlaylistSuccess"></div>
    <div class="clsViewTopicLeft">
        <div class="clsViewTopicRight">
        	<?php if (isMember ( )): ?>
            <a href="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
" onclick="return populateMyPlayList('<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
', 'create');" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_create_new']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewphoto_create_new']; ?>
</a>
            <?php else: ?>
            <a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['sidebar_login_comment_slidelist_err_msg']; ?>
','<?php echo $this->_tpl_vars['myobj']->memberviewPhotoUrl; ?>
'); return false;" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_create_new']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewphoto_create_new']; ?>
</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="clsViewTopicLeft">
        <div class="clsViewTopicRight">
        	<?php if (isMember ( )): ?>
            <a href="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
" onclick="return populateMyPlayList('<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
', 'select');" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_select_from_list']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewphoto_select_from_list']; ?>
</a>
            <?php else: ?>
            <a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['sidebar_login_comment_slidelist_err_msg']; ?>
','<?php echo $this->_tpl_vars['myobj']->memberviewPhotoUrl; ?>
'); return false;" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_select_from_list']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewphoto_select_from_list']; ?>
</a>
            <?php endif; ?>
        </div>
    </div>
</div>
<div id="loginDiv" class="clsDisplayNone clsTextAlignLeft clsPlaylistLabelPopup">
</div>
<div id="playlistDiv" class="clsDisplayNone clsPhotoListPopup">
	<div class="clsOverflow">
    	<div class="clsFlagTitle"><?php echo $this->_tpl_vars['LANG']['photoslidelist_label']; ?>
</div>
     </div>
       	<div id="clsMsgDisplay_playlist_failure" class="clsDisplayNone clsPlaylistSuccess clsAddErrorMsg"></div>
     	<div id="playlistFrmDiv" class="clsFlagTable">
	        <form method="post" name="photoListForm" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off" onsubmit="return false">
            <input type="hidden" name="playlist_access_type" id="playlist_access_type" value="<?php echo $this->_tpl_vars['myobj']->getFormField('playlist_access_type'); ?>
" />
        <table>
         <tr>
         	&nbsp;
            <td class="clsTDwidth"><label><?php echo $this->_tpl_vars['LANG']['photoslidelist_name']; ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></td>
            <td id="selMyPlayListOpt">
<?php endif; ?>
<?php if (isAjaxPage ( )): ?>
				<select name="playlist" id="playlist"  onchange="chkPlaylist('playlist')" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
            		<option value=""><?php echo $this->_tpl_vars['LANG']['photoslidelist_select_slidelist']; ?>
</option>
                    <option value="#new#"><?php echo $this->_tpl_vars['LANG']['photoslidelist_create_slidelist']; ?>
</option>
                    <?php echo $this->_tpl_vars['myobj']->generalPopulateArrayPlaylist($this->_tpl_vars['playlistInfoViewPhoto'],$this->_tpl_vars['myobj']->getFormField('playlist'),$this->_tpl_vars['playlist']); ?>

                </select>
<?php endif; ?>
<?php if (! isAjaxPage ( )): ?>
            </td>
         </tr>
         </table>
         <div id="createNewPlaylist" style="display:none">
	         <table>
                <tr>
         			&nbsp;
                    <td class="clsTDwidth"><label><?php echo $this->_tpl_vars['LANG']['photoslidelist_name']; ?>
&nbsp;<span class="clsCompulsoryField"><?php echo $this->_tpl_vars['LANG']['important']; ?>
</span></label></td>
                    <td><input class="clsFlagTextBox clsPhotoListPopupField" type="text" name="playlistTitle" id="playlistTitle" value="" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></td>
                </tr>
                <tr>
                    <td><label><?php echo $this->_tpl_vars['LANG']['photoslidelist_description']; ?>
&nbsp;</label></td>
                    <td><textarea name="playlistDesc" id="playlistDesc" cols="5" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" class="clsPhotoListPopupField"></textarea></td>
                </tr>
               </table>
            </div>
            <table>

         <tr>
         	<td class="clsTDwidth"><!-- --></td>
         	&nbsp;
            <td><div class="clsFlagButtonLeft"><div class="clsFlagButtonRight"><input type="button" value="<?php echo $this->_tpl_vars['LANG']['photoslidelist_submit_label']; ?>
" onclick="createPlayList('<?php echo $this->_tpl_vars['slide_info']['playlistUrl']; ?>
', photo_id, $Jq('#playlist').val())" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></div></div></td>
         </tr>
        </table>
        </form>
		</div>
</div>
<?php endif; ?>