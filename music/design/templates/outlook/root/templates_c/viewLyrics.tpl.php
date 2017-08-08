<?php /* Smarty version 2.6.18, created on 2012-02-12 08:30:55
         compiled from viewLyrics.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'viewLyrics.tpl', 70, false),)), $this); ?>
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
                <?php echo $this->_tpl_vars['LANG']['viewlyrics_title']; ?>

                </span></h2>
              </div>
              <?php if ($this->_tpl_vars['myobj']->flag && ! $this->_tpl_vars['myobj']->chkIsAdminSide()): ?>
                  <div class="clsHeadingRight">
                    <p class="clsHeadingLink"><a href="<?php echo $this->_tpl_vars['myobj']->morelyrics_url; ?>
">More lyrics</a></p>
                  </div>
              <?php endif; ?>
          </div>
    <!-- information div -->
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

    	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
	 <!-- view lyrics block -->
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
           <?php if (! isAjaxPage ( )): ?><div><?php endif; ?>
            <?php if (isAjaxPage ( )): ?>
            	<div class="clsOverflow">
            	<p class="clsLeft">
            	<div class="clsViewTopicLeft">
                    <div class="clsViewTopicRight">
                    	<?php if (isMember ( )): ?>
                        <a href="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
" onclick="return populateAddLyrics('<?php echo $this->_tpl_vars['myobj']->addlyrics_light_window_url; ?>
');" title="<?php echo $this->_tpl_vars['LANG']['common_music_lyrics_add']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_music_lyrics_add']; ?>
</a>
                        <?php else: ?>
                        <a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['sidebar_login_comment_lyrics_err_msg']; ?>
','<?php echo $this->_tpl_vars['myobj']->memberviewMusicUrl; ?>
');return false;" title="<?php echo $this->_tpl_vars['LANG']['common_music_lyrics_add']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_music_lyrics_add']; ?>
</a>
                        <?php endif; ?>
                    </div>
                </div>
                 </p>
                <?php if (isMember ( ) && $this->_tpl_vars['myobj']->chkisMusicOwner()): ?>
                    <p class="clsRight">
					<div class="clsViewTopicLeft">
                    <div class="clsViewTopicRight">
					<a href="<?php echo $this->_tpl_vars['myobj']->managelyrics_url; ?>
"  ><?php echo $this->_tpl_vars['LANG']['viewlyrics_manage_lyrics_label']; ?>
</a>
					</div></div></p>
                <?php endif; ?>
                </div>

             <?php endif; ?>
            	<p class="clsLyrics"><?php if (isAjaxPage ( )): ?><?php echo $this->_tpl_vars['myobj']->lyric; ?>
 <?php else: ?> <?php echo $this->_tpl_vars['myobj']->viewlyricpage; ?>
<?php endif; ?></p>
                <?php if (isAjaxPage ( )): ?>
                	<p class="clsOverflow">
                	<p class="clsRight">
					<div class="clsViewTopicLeft">
                    <div class="clsViewTopicRight">
					<a href="<?php echo $this->_tpl_vars['myobj']->morelyrics_url; ?>
"  ><?php echo $this->_tpl_vars['LANG']['viewlyrics_more_lyrics_label']; ?>
</a></p>
					</div></div>
                    </p>
                <?php endif; ?>
            <?php if (! isAjaxPage ( )): ?>
                <p class="clsLyricsPostedBy"><?php echo $this->_tpl_vars['LANG']['viewlyrics_Post_by']; ?>
: <a href="<?php echo $this->_tpl_vars['myobj']->user_url; ?>
"><?php echo $this->_tpl_vars['myobj']->user_name; ?>
</a></p>
                <?php if ($this->_tpl_vars['myobj']->chkIsAdminSide()): ?>
               	 <p><input type="button" class="clsSubmitButton" name="cancel_submit" id="cancel_submit" value="<?php echo $this->_tpl_vars['LANG']['viewlyrics_cancel_label']; ?>
" onclick="Redirect2URL('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/manageLyrics.php?music_id=<?php echo $this->_tpl_vars['myobj']->getFormField('music_id'); ?>
')"tabindex="<?php echo smartyTabIndex(array(), $this);?>
"></p>
           	    <?php endif; ?>
                </div>
            <?php endif; ?>
      	<?php else: ?>
          <div id="selMsgAlert"><?php echo $this->_tpl_vars['LANG']['viewlyrics_no_record_found']; ?>
</div>
          <?php if ($this->_tpl_vars['myobj']->chkIsAdminSide()): ?>
          	<p><input type="button" class="clsSubmitButton" name="cancel_submit" id="cancel_submit" value="<?php echo $this->_tpl_vars['LANG']['viewlyrics_cancel_label']; ?>
" onclick="Redirect2URL('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/manageLyrics.php?music_id=<?php echo $this->_tpl_vars['myobj']->getFormField('music_id'); ?>
')"tabindex="<?php echo smartyTabIndex(array(), $this);?>
"></p>
          <?php endif; ?>
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