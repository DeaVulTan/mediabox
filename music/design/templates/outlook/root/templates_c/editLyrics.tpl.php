<?php /* Smarty version 2.6.18, created on 2013-08-17 00:16:19
         compiled from editLyrics.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'editLyrics.tpl', 51, false),)), $this); ?>
<?php if (! isAjaxPage ( )): ?>
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
<div class="clsAudioContentContainer">
	<?php if (! isAjaxPage ( )): ?>
		<div id="selViewLyrics">
		<!-- heading -->
		<div class="clsOverflow">
		<div class="clsHeadingLeft">
		<h2><span>
			<?php echo $this->_tpl_vars['LANG']['managelyrics_edit_title']; ?>

		</span></h2>
	</div>
</div>
	<!-- information div -->
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['myobj']->record_count): ?>
	<?php if (! isAjaxPage ( )): ?>
	<!-- music information -->
		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'musicInformation.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endif; ?>
<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
<?php if (isAjaxPage ( )): ?>
	<div class="clsOverflow">
		<p class="clsLeft">
			<?php if (isMember ( )): ?>
			<a href="javascript:void(0)" onclick="javascript: myLightWindow.activateWindow(<?php echo '{'; ?>
type:'external',href:'<?php echo $this->_tpl_vars['myobj']->addlyrics_light_window_url; ?>
',title:'<?php echo $this->_tpl_vars['LANG']['viewmusic_add_lyrics']; ?>
',width:450,height:280<?php echo '}'; ?>
);" ><?php echo $this->_tpl_vars['LANG']['common_music_lyrics_add']; ?>
</a></p>
				<?php else: ?>
			<a href="<?php echo $this->_tpl_vars['myobj']->memberviewMusicUrl; ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_music_lyrics_add']; ?>
"  ><?php echo $this->_tpl_vars['LANG']['common_music_lyrics_add']; ?>
</a>
			<?php endif; ?>
		</p>
		<?php if (isMember ( ) && $this->_tpl_vars['myobj']->chkisMusicOwner()): ?>
			<p class="clsRight"><a href="<?php echo $this->_tpl_vars['myobj']->managelyrics_url; ?>
" title="<?php echo $this->_tpl_vars['LANG']['viewlyrics_manage_lyrics_label']; ?>
"  ><?php echo $this->_tpl_vars['LANG']['viewlyrics_manage_lyrics_label']; ?>
</a></p>
		<?php endif; ?>

		</div>
		<?php endif; ?>
		<div id="editselMusicPlaylistManage" class="clsAudioContentContainer">
		<div class="clsLyrics">
			<form id="editFormLyrics" name="editFormLyrics" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
" class="clsDataTable">
				<table class="clsFormTableSection" width="100%" >
				<p class="clsLyricsPostedBy"><?php echo $this->_tpl_vars['LANG']['managelyrics_Post_by']; ?>
: <a href="<?php echo $this->_tpl_vars['myobj']->user_url; ?>
"><?php echo $this->_tpl_vars['myobj']->user_name; ?>
</a></p>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('edit_lyrics'); ?>
"><label for="edit_lyrics"><?php echo $this->_tpl_vars['LANG']['managelyrics_lyrics_label']; ?>
</label></td>
					<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('edit_lyrics'); ?>
">
					<textarea name="edit_lyrics" id="edit_lyrics" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" rows="10" cols="50"><?php echo $this->_tpl_vars['myobj']->showEditLyrics(); ?>
</textarea>
                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('edit_lyrics'); ?>

					</td>
				</tr>
				<tr>
                	<td>&nbsp;</td>
					<td>
                    <div class="clsSubmitLeft">
                        <div class="clsSubmitRight">
                        	<input type="submit" class="clsSubmitButton" name="edit_submit" id="edit_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['managelyrics_edit_submit_label']; ?>
"/>
                        </div>
                    </div>
                    </td>
                    <td>
						<input type="hidden" class="clsSubmitButton" name="music_lyric_id" id="music_lyric_id" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('music_lyric_id'); ?>
"/>
                    </td>
				</tr>
				<tr><td class="clsBack"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/manageLyrics.php?music_id=<?php echo $this->_tpl_vars['myobj']->getFormField('music_id'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['managelyrics_edit_back_label']; ?>
"><?php echo $this->_tpl_vars['LANG']['managelyrics_edit_back_label']; ?>
</a></td></tr>
				</table>
			</form>
	</div>
<?php endif; ?>
<?php endif; ?>
	<?php if (! isAjaxPage ( )): ?>
		</div>
	<?php endif; ?>
</div>
<?php if (! isAjaxPage ( )): ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

