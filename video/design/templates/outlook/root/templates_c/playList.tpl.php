<?php /* Smarty version 2.6.18, created on 2011-10-18 17:56:33
         compiled from playList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'playList.tpl', 51, false),)), $this); ?>
<?php if (! isAjaxPage ( )): ?>
<script language="javascript" type="text/javascript">
var selectionError ="<?php echo $this->_tpl_vars['LANG']['playlist_selection_error']; ?>
";
var invalidPlaylist="<?php echo $this->_tpl_vars['LANG']['playlist_invalid']; ?>
";
</script>
<div id="option-tab-1" class="clsDisplayNone clsTextAlignLeft clsOverflow clsPlaylistLabel">
	<div id="clsMsgDisplay_playlist_success" class="clsDisplayNone clsPlaylistSuccess"></div>
	<?php if (! $this->_tpl_vars['playlist']['is_external_embededcode']): ?>
		<div class="clsViewTopicLeft">
			<div class="clsViewTopicRight">
            	<?php if (isMember ( )): ?>
				<a href="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
" onclick="return populateMyPlayList('<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
', 'create');" title="<?php echo $this->_tpl_vars['LANG']['viewvideo_create_new']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewvideo_create_new']; ?>
</a>
                <?php else: ?>
                <a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['common_video_login_create_playlist_msg']; ?>
', '<?php echo $this->_tpl_vars['myobj']->notLoginVideoUrl; ?>
');return false;" title="<?php echo $this->_tpl_vars['LANG']['viewvideo_create_new']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewvideo_create_new']; ?>
</a>
                <?php endif; ?>
			</div>
		</div>
		<div class="clsViewTopicLeft">
			<div class="clsViewTopicRight">
            	<?php if (isMember ( )): ?>
				<a href="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
" onclick="return populateMyPlayList('<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
', 'select');" title="<?php echo $this->_tpl_vars['LANG']['viewvideo_select_from_list']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewvideo_select_from_list']; ?>
</a>
                <?php else: ?>
                <a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['common_video_login_create_playlist_msg']; ?>
', '<?php echo $this->_tpl_vars['myobj']->notLoginVideoUrl; ?>
');return false;" title="<?php echo $this->_tpl_vars['LANG']['viewvideo_select_from_list']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewvideo_select_from_list']; ?>
</a>
                <?php endif; ?>
			</div>
		</div>
	<?php else: ?>
		<p><?php echo $this->_tpl_vars['LANG']['externalembeded_playlist_message']; ?>
</p>
	<?php endif; ?>
</div>
<div id="loginDiv" class="clsDisplayNone clsTextAlignLeft clsPlaylistLabelPopup">
</div>
<div id="playlistDiv" class="clsDisplayNone clsTextAlignLeft clsPlaylistLabel">
<!--<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'flag_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>-->
<!--	<div class="clsOverflow">
    	<div class="clsFlagTitle"><?php echo $this->_tpl_vars['LANG']['playlist_title']; ?>
</div>
     </div> -->
       	<div id="clsMsgDisplay_playlist_failure" class="clsDisplayNone clsPlaylistSuccess"></div>
     	<div id="playlistFrmDiv" class="clsFlagTable">
        <?php if (! $this->_tpl_vars['playlist']['is_external_embededcode']): ?>
	        <form method="post" name="playlistfrm" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off" onsubmit="return false">
            <input type="hidden" name="playlist_access_type" id="playlist_access_type" value="<?php echo $this->_tpl_vars['myobj']->getFormField('playlist_access_type'); ?>
" />
        <table class="clsTable100">
         <tr>
            <td class="clsTDwidth"><label><?php echo $this->_tpl_vars['LANG']['playlist_title']; ?>
</label></td>
            <td id="selMyPlayListOpt">
        <?php endif; ?>
<?php endif; ?>
<?php if (isAjaxPage ( )): ?>
           <select name="playlist" id="playlist" onchange="chkPlaylist('playlist')" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                <option value=""><?php echo $this->_tpl_vars['LANG']['playlist_select']; ?>
</option>
                <option value="#new#"><?php echo $this->_tpl_vars['LANG']['playlist_create']; ?>
</option>
                <?php if ($this->_tpl_vars['playlist']['record']): ?>
                <?php $_from = $this->_tpl_vars['playlist']['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['playlistItem']):
?>
                <option value="<?php echo $this->_tpl_vars['playlistItem']['playlist_id']; ?>
"><?php echo $this->_tpl_vars['playlistItem']['playlist_name']; ?>
</option>
                <?php endforeach; endif; unset($_from); ?>
                <?php endif; ?>
                </select>
<?php endif; ?>
<?php if (! isAjaxPage ( )): ?>
		<?php if (! $this->_tpl_vars['playlist']['is_external_embededcode']): ?>
            </td>
         </tr>
         </table>
         <div id="createNewPlaylist" style="display:none">
	         <table class="clsTable100">
                <tr>
                    <td class="clsTDwidth"><label><?php echo $this->_tpl_vars['LANG']['playlist_name']; ?>
&nbsp;<span class="clsCompulsoryField"><?php echo $this->_tpl_vars['LANG']['important']; ?>
</span></label></td>
                    <td><input class="clsFlagTextBox" type="text" name="playlistTitle" id="playlistTitle" value="" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></td>
                </tr>
                <tr>
                    <td><label><?php echo $this->_tpl_vars['LANG']['playlist_description']; ?>
</label></td>
                    <td><textarea name="playlistDesc" id="playlistDesc" cols="5" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"></textarea></td>
                </tr>
                <tr>
                    <td><label><?php echo $this->_tpl_vars['LANG']['playlist_tags']; ?>
&nbsp;<span class="clsCompulsoryField"><?php echo $this->_tpl_vars['LANG']['important']; ?>
</span></label></td>
                    <td><input class="clsFlagTextBox" type="text" name="playlistTags" id="playlistTags" value="" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/></td>
                </tr>
               </table>
            </div>
            <table class="clsTable100">
                         <tr>
         	<td class="clsTDwidth"><!-- --></td>
            <td><div class="clsFlagButtonLeft"><div class="clsFlagButtonRight"><input type="button" value="<?php echo $this->_tpl_vars['LANG']['playlist_submit']; ?>
" onclick="createPlayList('<?php echo $this->_tpl_vars['playlist']['playlistUrl']; ?>
')" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></div></div></td>
         </tr>
        </table>
        </form>
       	<?php else: ?>
        	<p><?php echo $this->_tpl_vars['LANG']['externalembeded_playlist_message']; ?>
</p>
        <?php endif; ?>
		</div>
<!--<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'flag_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>-->
</div>
<script type="text/javascript">
//slideDiv('playlistDiv');
</script>
<?php endif; ?>