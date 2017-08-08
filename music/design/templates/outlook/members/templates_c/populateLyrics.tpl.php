<?php /* Smarty version 2.6.18, created on 2011-10-17 15:01:16
         compiled from populateLyrics.tpl */ ?>
<?php if (! isAjaxPage ( )): ?>
<div id="listenMusicLyrics" class="clsDisplayNone clsTextAlignLeft clsOverflow clsPlaylistLabel">
	<div id="clsMsgDisplay_lyrics_success" class="clsDisplayNone"></div>
    <div class="clsViewTopicLeft">
        <div class="clsViewTopicRight">
        	<?php if ($this->_tpl_vars['myobj']->isMember): ?>
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
    <?php if ($this->_tpl_vars['myobj']->getFormField('music_lyric_id')): ?>
    <div class="clsViewTopicLeft">
        <div class="clsViewTopicRight">
            <a href="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
" onclick="return populateViewLyrics();" title="<?php if ($this->_tpl_vars['myobj']->getFormField('music_best_lyric')): ?><?php echo $this->_tpl_vars['LANG']['viewmusic_view_bestlyrics']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['viewmusic_view_lyrics']; ?>
<?php endif; ?>"><?php if ($this->_tpl_vars['myobj']->getFormField('music_best_lyric')): ?><?php echo $this->_tpl_vars['LANG']['viewmusic_view_bestlyrics']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['viewmusic_view_lyrics']; ?>
<?php endif; ?></a>
        </div>
    </div>
    <?php endif; ?>    	    
    <?php if (isMember ( ) && $this->_tpl_vars['myobj']->chkisMusicOwner()): ?>
    <div class="clsViewTopicLeft">
        <div class="clsViewTopicRight">
            <a href="<?php echo $this->_tpl_vars['myobj']->managelyrics_url; ?>
" title="<?php echo $this->_tpl_vars['LANG']['viewmusic_manage_lyrics_label']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewmusic_manage_lyrics_label']; ?>
</a>
        </div>
    </div>
    <?php endif; ?>	
</div>
<div id="LyricsDiv" class="clsDisplayNone clsTextAlignLeft clsPlaylistLabel"></div>
<?php endif; ?>