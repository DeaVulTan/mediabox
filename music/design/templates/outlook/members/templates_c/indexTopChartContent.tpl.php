<?php /* Smarty version 2.6.18, created on 2011-10-17 15:09:55
         compiled from indexTopChartContent.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'indexTopChartContent.tpl', 17, false),array('function', 'math', 'indexTopChartContent.tpl', 41, false),)), $this); ?>
<?php if ($this->_tpl_vars['opt'] == 'albums'): ?>
<?php if ($this->_tpl_vars['populateCarousalTopChartBlock_arr']['record_count']): ?>
<table class="clsCarouselTopChartList">
		<?php $this->assign('row_count', 2); ?>
	<?php $this->assign('break_count', 1); ?>
	<?php $_from = $this->_tpl_vars['populateCarousalTopChartBlock_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['musicKey'] => $this->_tpl_vars['musicValue']):
?>
	<?php if ($this->_tpl_vars['break_count'] == 1): ?>
    <tr>
    <?php endif; ?>
    	<td>

                        <div class="clsOverflow">
                            <div class="clsTopChartImage">
                                <a href="<?php echo $this->_tpl_vars['musicValue']['viewalbum_url']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls106x82">
									<?php if ($this->_tpl_vars['musicValue']['music_image_src'] != ''): ?>
										<img src="<?php echo $this->_tpl_vars['musicValue']['music_image_src']; ?>
" title="<?php echo $this->_tpl_vars['musicValue']['record']['album_title']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['music_index_topchart_thumb_width'],$this->_config[0]['vars']['music_index_topchart_thumb_height'],$this->_tpl_vars['musicValue']['thumb_width'],$this->_tpl_vars['musicValue']['thumb_height']); ?>
 alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['musicValue']['record']['album_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
"/>
									<?php else: ?>
										<img   src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_audio_M.jpg" title="<?php echo $this->_tpl_vars['musicValue']['record']['album_title']; ?>
" alt="<?php echo $this->_tpl_vars['musicValue']['record']['album_title']; ?>
"/>
									<?php endif; ?>
                                </a>
                            </div>
							<div class="clsTopChartDetails">
								<div class="clsTopChartTracks">
									<a class="clsTopChartSong" href="<?php echo $this->_tpl_vars['musicValue']['musiclistalbum_url']; ?>
" title="<?php echo $this->_tpl_vars['musicValue']['record']['album_title']; ?>
"><pre><?php echo $this->_tpl_vars['musicValue']['record']['album_title']; ?>
</pre></a>
                                    <p class="clsTopchartalbum"><span><?php echo $this->_tpl_vars['LANG']['sidebar_topchart_ablum_total_label']; ?>
:</span><?php echo $this->_tpl_vars['musicValue']['record']['total_song']; ?>
</p>
                                    <p class="clsTopchartalbum"><span><?php echo $this->_tpl_vars['LANG']['sidebar_topchart_total_plays_label']; ?>
:</span><?php echo $this->_tpl_vars['musicValue']['record']['total_count']; ?>
</p>
								</div>
							</div>
                        </div>
                   
		</td>
    <?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
    <?php if ($this->_tpl_vars['break_count'] > $this->_tpl_vars['row_count']): ?>
    </tr>
    <?php $this->assign('break_count', 1); ?>
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?> 
    <?php if ($this->_tpl_vars['break_count'] != 1): ?>
        <td colspan="<?php echo smarty_function_math(array('equation' => "(".($this->_tpl_vars['row_count'])."+1)-".($this->_tpl_vars['break_count'])), $this);?>
">&nbsp;</td>
    </tr>
    <?php endif; ?>
</table>
<?php else: ?>
<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['sidebar_no_topchart_album_found_error_msg']; ?>
</div>
<?php endif; ?>
<?php else: ?>
<?php if ($this->_tpl_vars['populateCarousalTopChartBlock_arr']['record_count']): ?>
<table class="clsCarouselTopChartList">
		<?php $this->assign('row_count', 2); ?>
	<?php $this->assign('break_count', 1); ?>
	<?php $_from = $this->_tpl_vars['populateCarousalTopChartBlock_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['musicKey'] => $this->_tpl_vars['musicValue']):
?> 
    <?php if ($this->_tpl_vars['break_count'] == 1): ?>
    <tr>
    <?php endif; ?>
    	<td>

                        <div class="clsOverflow">
                            <div class="clsTopChartImage">
                                <a href="<?php echo $this->_tpl_vars['musicValue']['title_url']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls106x82">
									<?php if ($this->_tpl_vars['musicValue']['music_image_src'] != ''): ?>
										<img src="<?php echo $this->_tpl_vars['musicValue']['music_image_src']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['musicValue']['record']['music_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['musicValue']['record']['music_title']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['music_index_topchart_thumb_width'],$this->_config[0]['vars']['music_index_topchart_thumb_height'],$this->_tpl_vars['musicValue']['thumb_width'],$this->_tpl_vars['musicValue']['thumb_height']); ?>
/>
									<?php else: ?>
										<img   src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_audio_M.jpg" title="<?php echo $this->_tpl_vars['musicValue']['record']['music_title']; ?>
" alt="<?php echo $this->_tpl_vars['musicValue']['record']['music_title']; ?>
"/>
									<?php endif; ?>
                                </a>
                            </div>
							<div class="clsTopChartDetails">
								<div class="clsTopChartTracks">
									<a class="clsTopChartSong" href="<?php echo $this->_tpl_vars['musicValue']['title_url']; ?>
" title="<?php echo $this->_tpl_vars['musicValue']['record']['music_title']; ?>
"><pre><?php echo $this->_tpl_vars['musicValue']['record']['music_title']; ?>
</pre></a>
									<p class="clsTopchartalbum"><span><?php echo $this->_tpl_vars['LANG']['album_title']; ?>
:</span><a  href="<?php echo $this->_tpl_vars['musicValue']['viewalbum_url']; ?>
" title="<?php echo $this->_tpl_vars['musicValue']['record']['album_title']; ?>
"><?php echo $this->_tpl_vars['musicValue']['record']['album_title']; ?>
</a></p>
									<p class="clsTopchartGenres"><span><?php echo $this->_tpl_vars['LANG']['music_genre_in']; ?>
</span><a  href="<?php echo $this->_tpl_vars['musicValue']['musiccategory_url']; ?>
" title="<?php echo $this->_tpl_vars['musicValue']['record']['music_category_name']; ?>
"><?php echo $this->_tpl_vars['musicValue']['record']['music_category_name']; ?>
</a></p>
								</div>
								<div class="clsOverflow">
									<div class="clsTopchartPlays">
											  <a class="clsPlaySong" id="<?php echo $this->_tpl_vars['script_case']; ?>
_play_music_icon_<?php echo $this->_tpl_vars['musicValue']['record']['music_id']; ?>
" onClick="playSelectedSong(<?php echo $this->_tpl_vars['musicValue']['record']['music_id']; ?>
, '<?php echo $this->_tpl_vars['script_case']; ?>
')" href="javascript:void(0)"></a>
											  <a class="clsStopSong" id="<?php echo $this->_tpl_vars['script_case']; ?>
_play_playing_music_icon_<?php echo $this->_tpl_vars['musicValue']['record']['music_id']; ?>
" onClick="stopSong(<?php echo $this->_tpl_vars['musicValue']['record']['music_id']; ?>
, '<?php echo $this->_tpl_vars['script_case']; ?>
')" style="display:none" href="javascript:void(0)"></a>
									</div>
									<div class="clsTopchartPlayCount">	
										<p>
											<span><?php echo $this->_tpl_vars['LANG']['sidebar_posted_plays_label']; ?>
</span>
											<?php echo $this->_tpl_vars['musicValue']['record']['total_count']; ?>

										</p>
									</div>
								</div>
							</div>
                        </div>
                   
    	</td>
	<?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
    <?php if ($this->_tpl_vars['break_count'] > $this->_tpl_vars['row_count']): ?>
    </tr>
    <?php $this->assign('break_count', 1); ?>
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>             
    <?php if ($this->_tpl_vars['break_count'] != 1): ?>
        <td colspan="<?php echo smarty_function_math(array('equation' => "(".($this->_tpl_vars['row_count'])."+1)-".($this->_tpl_vars['break_count'])), $this);?>
">&nbsp;</td>
    </tr>
    <?php endif; ?>
</table>
<?php else: ?>
<?php if ($this->_tpl_vars['top_chart_tab'] == 'topChartDownloads'): ?>
<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['sidebar_no_topchart_downloads_found_error_msg']; ?>
</div>
<?php else: ?>
<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['sidebar_no_topchart_audio_found_error_msg']; ?>
</div>
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>