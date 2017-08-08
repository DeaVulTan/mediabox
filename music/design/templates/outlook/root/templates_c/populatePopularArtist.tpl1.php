<?php /* Smarty version 2.6.18, created on 2012-06-22 18:08:51
         compiled from populatePopularArtist.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <div class="clsAudioIndex clsIndexPopularArtist">
        <h3><?php echo $this->_tpl_vars['LANG']['sidebar_popular_artist_label']; ?>
</h3>
        <?php if ($this->_tpl_vars['populatePopularArtist_arr']['record_count']): ?>
		<div class="clsOverflow clsPopularArtistInnerpad">
           <?php $_from = $this->_tpl_vars['populatePopularArtist_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['artistValue']):
?>
                <div class="clsAudioMemberContainer">
                    <div class="clsAudioMemberThumb">
                        <div class="clsThumbImageLink">
                            <a href="<?php echo $this->_tpl_vars['artistValue']['viewartist_url']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls45x45">
									<?php if ($this->_tpl_vars['artistValue']['music_path'] != ''): ?>
										<img src="<?php echo $this->_tpl_vars['artistValue']['music_path']; ?>
" title="<?php echo $this->_tpl_vars['artistValue']['record']['artist_name']; ?>
" alt="<?php echo $this->_tpl_vars['artistValue']['record']['artist_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['music_index_activity_thumb_width'],$this->_config[0]['vars']['music_index_activity_thumb_width'],$this->_tpl_vars['artistValue']['mini_width'],$this->_tpl_vars['artistValue']['mini_height']); ?>
 />
									<?php else: ?>
										<img  src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_artist_M.jpg" title="<?php echo $this->_tpl_vars['artistValue']['record']['artist_name']; ?>
" alt="<?php echo $this->_tpl_vars['artistValue']['record']['artist_name']; ?>
"/>
									<?php endif; ?>
                            </a>
                        </div>
                    </div>
                <div class="clsAudioMemberDetails">
                    <p class="clsName"><a href="<?php echo $this->_tpl_vars['artistValue']['viewartist_url']; ?>
" title="<?php echo $this->_tpl_vars['artistValue']['record']['artist_name']; ?>
"><?php echo $this->_tpl_vars['artistValue']['record']['artist_name']; ?>
</a></p>
                    <?php if ($this->_tpl_vars['artistValue']['record']['total_songs'] != '0'): ?>
					<p><?php if ($this->_tpl_vars['artistValue']['record']['total_songs'] == '1'): ?> <?php echo $this->_tpl_vars['LANG']['sidebar_popular_artist_song_label']; ?>
: <?php else: ?> <?php echo $this->_tpl_vars['LANG']['sidebar_popular_artist_songs_label']; ?>
: <?php endif; ?><span><a href="<?php echo $this->_tpl_vars['artistValue']['viewartist_url']; ?>
"><?php echo $this->_tpl_vars['artistValue']['record']['total_songs']; ?>
</a></span></p>
					<?php endif; ?>
					<?php if ($this->_tpl_vars['artistValue']['record']['sum_plays'] != '0'): ?>
                    <p><?php if ($this->_tpl_vars['artistValue']['record']['sum_plays'] == '1'): ?> <?php echo $this->_tpl_vars['LANG']['sidebar_popular_artist_play_label']; ?>
: <?php else: ?> <?php echo $this->_tpl_vars['LANG']['sidebar_popular_artist_plays_label']; ?>
: <?php endif; ?><?php echo $this->_tpl_vars['artistValue']['record']['sum_plays']; ?>
</p>
					<?php endif; ?>
                </div>
                </div>
            <?php endforeach; endif; unset($_from); ?>
		</div>
            <!-- by Abror Ahmedov 22.06.2012
            <p class="clsViewMore"><a href="<?php echo $this->_tpl_vars['moreartist_url']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['sidebar_viewall_label']; ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_viewall_label']; ?>
</a></p>
            -->
         <?php else: ?>
         	<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['sidebar_no_popular_artist_found_error_msg']; ?>
</div>
         <?php endif; ?>
    </div>
	
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>