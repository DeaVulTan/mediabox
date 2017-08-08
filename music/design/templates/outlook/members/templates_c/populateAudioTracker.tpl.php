<?php /* Smarty version 2.6.18, created on 2011-10-17 15:09:54
         compiled from populateAudioTracker.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'populateAudioTracker.tpl', 32, false),)), $this); ?>
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgCartSuccess');
</script>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <div class="clsAudioIndex clsAudioTrackerBlock">
    	<h3><?php echo $this->_tpl_vars['LANG']['sidebar_audio_tracker_label']; ?>
</h3>
        <?php if ($this->_tpl_vars['populateAudioTracker_arr']['record_count']): ?>
           <?php $_from = $this->_tpl_vars['populateAudioTracker_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['trackerValue']):
?>
                <div class="clsAudioTrackerContainer">
                    <div class="clsATDetials">
                        <p class="clsATName" title="<?php echo $this->_tpl_vars['trackerValue']['record']['music_title']; ?>
"><a href="<?php echo $this->_tpl_vars['trackerValue']['viewmusic_url']; ?>
" alt="<?php echo $this->_tpl_vars['trackerValue']['record']['music_title']; ?>
" title="<?php echo $this->_tpl_vars['trackerValue']['record']['music_title']; ?>
"><?php echo $this->_tpl_vars['trackerValue']['record']['music_title']; ?>
</a><span class="clsATDay"><?php echo $this->_tpl_vars['trackerValue']['getTimeDiffernceFormat_last_viewed']; ?>
</span></p>
						<p class="clsTopchartalbum"><span><?php echo $this->_tpl_vars['LANG']['myhome_my_music_tracker_album']; ?>
</span><a href="<?php echo $this->_tpl_vars['trackerValue']['viewalbum_url']; ?>
" alt="<?php echo $this->_tpl_vars['trackerValue']['record']['album_title']; ?>
" title="<?php echo $this->_tpl_vars['trackerValue']['record']['album_title']; ?>
"><?php echo $this->_tpl_vars['trackerValue']['record']['album_title']; ?>
</a></p>
                    </div>
                  <div class="clsPlayerIcon">
				   
                        <a class="clsPlaySong" id="music_tracker_play_music_icon_<?php echo $this->_tpl_vars['trackerValue']['record']['music_id']; ?>
" onclick="playSelectedSong(<?php echo $this->_tpl_vars['trackerValue']['record']['music_id']; ?>
, 'music_tracker')" href="javascript:void(0)" title="<?php echo $this->_tpl_vars['LANG']['common_play']; ?>
" alt="<?php echo $this->_tpl_vars['LANG']['common_play']; ?>
"></a>
                        <a class="clsStopSong" id="music_tracker_play_playing_music_icon_<?php echo $this->_tpl_vars['trackerValue']['record']['music_id']; ?>
" onclick="stopSong(<?php echo $this->_tpl_vars['trackerValue']['record']['music_id']; ?>
, 'music_tracker')" style="display:none" href="javascript:void(0)" title="<?php echo $this->_tpl_vars['LANG']['common_stop']; ?>
" alt="<?php echo $this->_tpl_vars['LANG']['common_stop']; ?>
"></a>
                  </div>
                </div>
            <?php endforeach; endif; unset($_from); ?>
            <p class="clsViewMore"><a href="<?php echo $this->_tpl_vars['audiotracker_url']; ?>
" alt="<?php echo $this->_tpl_vars['LANG']['sidebar_music_more_label']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['sidebar_music_more_label']; ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_music_more_label']; ?>
</a></p>
         <?php else: ?>
         	<div class="clsNoRecordsFound"> <?php echo $this->_tpl_vars['LANG']['sidebar_no_audio_found_error_msg']; ?>
</div>
         <?php endif; ?>

    </div>
    <div id="selMsgCartSuccess" class="clsPopupConfirmation" style="display:none;">
              <p id="selCartAlertSuccess"></p>
              <form name="msgCartFormSuccess" id="msgConfirmformMulti" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
                <input type="button" class="clsSubmitButton" name="no" value="<?php echo $this->_tpl_vars['LANG']['common_option_ok']; ?>
"
                tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="return hideAllBlocks()" />
              </form>
            </div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>