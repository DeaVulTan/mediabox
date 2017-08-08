<?php /* Smarty version 2.6.18, created on 2012-02-03 19:43:51
         compiled from songList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'songList.tpl', 62, false),)), $this); ?>
				<?php echo $this->_tpl_vars['myobj']->populatePlayerWithPlaylist($this->_tpl_vars['music_fields']); ?>

	<input type="hidden" name="hidden_player_status" id="hidden_player_status" value="" />
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('songlist_block')): ?>
	<?php if ($this->_tpl_vars['displaySongList_arr']['record_count']): ?>
    <div class="clsDataTable clsPopupContent"><table >
        <tr>
            <th class="clsSerialNo"><?php echo $this->_tpl_vars['LANG']['musicplaylist_admin_songlist_id']; ?>
</th>
            <th><?php echo $this->_tpl_vars['LANG']['musicplaylist_admin_songlist_songtitle']; ?>
</th>
            <th>
					                	<div class="clsVolumeBar">
                			<div id="volume_container" class="clsVolumeDisabled" onmouseover="show_what_is_this()">
       					   <div id="volume_speaker" onclick="mute_volume()" class="clsSpeakerOn"></div>
            			   <div class="clsVolumeAdjust">
                				<div id="volume_slider" class="slider">
                  					<div id="volume_slider_bg" class="clsActiveVolume"></div>
                				</div>
            				</div>
								            				  <div id="volume_what_is_this" class="" onmouseover="" onmouseout="" style="visibility:hidden;"></div>
					</div>
				</th>
        </tr>
            <?php $_from = $this->_tpl_vars['displaySongList_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['songListKey'] => $this->_tpl_vars['songListValue']):
?>
                <tr>
                    <td><?php echo $this->_tpl_vars['songListKey']; ?>
</td>
                    <td>
                    <?php if ($this->_tpl_vars['songListValue']['song_status']): ?>
	                    <p title="<?php echo $this->_tpl_vars['songListValue']['record']['music_title']; ?>
"><strong><?php echo $this->_tpl_vars['songListValue']['wordWrap_mb_ManualWithSpace_music_title']; ?>
</strong><?php if ($this->_tpl_vars['songListValue']['wordWrap_mb_ManualWithSpace_album_title'] != ''): ?>(<span title="<?php echo $this->_tpl_vars['songListValue']['record']['album_title']; ?>
" ><?php echo $this->_tpl_vars['songListValue']['wordWrap_mb_ManualWithSpace_album_title']; ?>
</span>)<?php endif; ?></p>
                   	<?php else: ?>
                    	<p><strong><?php echo $this->_tpl_vars['LANG']['musicplaylist_private_label']; ?>
</strong></p>
                    <?php endif; ?>
                    </td>
                    <td><div class="clsPlayerIcon">
                      	<a class="clsPlaySong" id="play_music_icon_<?php echo $this->_tpl_vars['songListValue']['record']['music_id']; ?>
" onClick="playSelectedSong(<?php echo $this->_tpl_vars['songListValue']['record']['music_id']; ?>
)" title="Play"  href="javascript:void(0)"></a>
                      	<a class="clsStopSong" id="play_playing_music_icon_<?php echo $this->_tpl_vars['songListValue']['record']['music_id']; ?>
" onClick="stopSong(<?php echo $this->_tpl_vars['songListValue']['record']['music_id']; ?>
)" Title="Pause" style="display:none" href="javascript:void(0)"></a></div>
                   </td>
                </tr>
            <?php endforeach; endif; unset($_from); ?>
    </table></div>
    <?php else: ?>
           <div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['musicplaylist_admin_songlist_norecords_found']; ?>
</div>
    <?php endif; ?>
<?php else: ?>
	<?php if ($this->_tpl_vars['displaySongList_arr']['record_count']): ?>
                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'details_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <?php $this->assign('count', '1'); ?>
                  <div class="clsSongListDetails">
            		<?php $_from = $this->_tpl_vars['displaySongList_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['songListKey'] => $this->_tpl_vars['songListValue']):
?>
                    	<?php echo smarty_function_counter(array('assign' => 'count'), $this);?>

                    	<p <?php if ($this->_tpl_vars['lastDiv'] == $this->_tpl_vars['count']): ?> <?php echo smarty_function_counter(array('start' => 0), $this);?>
 class="clsNoBorder"<?php endif; ?>title="<?php echo $this->_tpl_vars['songListValue']['record']['music_title']; ?>
"><strong><a href="<?php echo $this->_tpl_vars['songListValue']['viewmusic_url']; ?>
"><?php echo $this->_tpl_vars['songListValue']['wordWrap_mb_ManualWithSpace_music_title']; ?>
</a></strong><?php if ($this->_tpl_vars['songListValue']['wordWrap_mb_ManualWithSpace_album_title'] != ''): ?>(<span title="<?php echo $this->_tpl_vars['songListValue']['record']['album_title']; ?>
" ><a href="<?php echo $this->_tpl_vars['songListValue']['viewmusic_url']; ?>
"><?php echo $this->_tpl_vars['songListValue']['wordWrap_mb_ManualWithSpace_album_title']; ?>
</a></span>)<?php endif; ?></p>
                    <?php endforeach; endif; unset($_from); ?>
                  </div>
                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'details_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
     <?php endif; ?>
<?php endif; ?>
		<div id="view_album_player_div" class="clsHiddenPlayer" style="display:none"><!----></div>
<script type="text/javascript">
<?php echo '
var volume_slider = $Jq("#volume_slider").slider({
			min: 0,
			max: 100,
			value: playlist_player_volume,
			disabled: true,
			slide: function(event, ui) {
				playlist_player_volume = ui.value;
				//TO CHANGE MUTE CONTROL AND VOLUME CONTROL BACKGROUND
				toggle_volume_control(ui.value);
				setVolume(ui.value);
			},
			change: function(event, ui) {
				playlist_player_volume = ui.value;
				//TO CHANGE MUTE CONTROL AND VOLUME CONTROL BACKGROUND
				toggle_volume_control(ui.value);
				//FOR MUTE CONTROL
				//if(playlist_player_volume_mute_prev != playlist_player_volume_mute_cur)
					{
						playlist_player_volume_mute_prev = playlist_player_volume_mute_cur;
						playlist_player_volume_mute_cur = ui.value;
					}
				setVolume(ui.value);
				store_volume_in_session(ui.value);
	      	}
		});
$Jq(document).ready(function(){
	//TO CHANGE MUTE CONTROL AND VOLUME CONTROL BACKGROUND
	toggle_volume_control(playlist_player_volume);
});
'; ?>

</script>