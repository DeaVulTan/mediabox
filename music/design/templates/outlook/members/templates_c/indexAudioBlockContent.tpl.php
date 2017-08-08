<?php /* Smarty version 2.6.18, created on 2011-10-17 15:09:57
         compiled from indexAudioBlockContent.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'indexAudioBlockContent.tpl', 17, false),array('modifier', 'capitalize', 'indexAudioBlockContent.tpl', 26, false),array('function', 'math', 'indexAudioBlockContent.tpl', 61, false),)), $this); ?>
<?php if ($this->_tpl_vars['music_block_record_count']): ?>
<table class="clsCarouselList">
		<?php $this->assign('row_count', 4); ?>
	<?php $this->assign('break_count', 1); ?>
	<?php $_from = $this->_tpl_vars['populateCarousalMusicBlock_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['upload_musicKey'] => $this->_tpl_vars['upload_musicValue']):
?>
    <?php if ($this->_tpl_vars['break_count'] == 1): ?>
    <tr>
    <?php endif; ?>
        <td <?php if ($this->_tpl_vars['break_count'] == $this->_tpl_vars['row_count']): ?>class="clsFinalData"<?php endif; ?>>
                        <div class="clsLargeThumbImageBackground">
                <a href="<?php echo $this->_tpl_vars['upload_musicValue']['viewmusic_url']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls144x110">
                    <?php if ($this->_tpl_vars['upload_musicValue']['music_image_src'] != ''): ?>
                        <img src="<?php echo $this->_tpl_vars['upload_musicValue']['music_image_src']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['upload_musicValue']['record']['music_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 10) : smarty_modifier_truncate($_tmp, 10)); ?>
" title="<?php echo $this->_tpl_vars['upload_musicValue']['music_title']; ?>
 <?php echo $this->_tpl_vars['upload_musicValue']['extra_music_details']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['image_music_thumb_width'],$this->_config[0]['vars']['image_music_thumb_height'],$this->_tpl_vars['upload_musicValue']['thumb_width'],$this->_tpl_vars['upload_musicValue']['thumb_height']); ?>
/>
                    <?php else: ?>
                        <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_audio_T.jpg" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['upload_musicValue']['record']['music_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 10) : smarty_modifier_truncate($_tmp, 10)); ?>
" title="<?php echo $this->_tpl_vars['upload_musicValue']['record']['music_title']; ?>
 <?php echo $this->_tpl_vars['upload_musicValue']['extra_music_details']; ?>
"/>
                    <?php endif; ?>
                </a>
                <div class="clsTime"><?php echo $this->_tpl_vars['upload_musicValue']['playing_time']; ?>
</div>
            </div>
            <div class="clsAudioIndexCauroselListContent">
                <a href="<?php echo $this->_tpl_vars['upload_musicValue']['viewmusic_url']; ?>
" title="<?php echo $this->_tpl_vars['upload_musicValue']['music_title']; ?>
"><pre><?php echo $this->_tpl_vars['upload_musicValue']['music_title']; ?>
</pre></a>
				<p class="clsMusicalbum"><span><?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['in'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
: </span><a href="<?php echo $this->_tpl_vars['upload_musicValue']['get_viewalbum_url']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['album_title']; ?>
: <?php echo $this->_tpl_vars['upload_musicValue']['album_title']; ?>
"><?php echo $this->_tpl_vars['upload_musicValue']['album_title']; ?>
</a></p>
                <?php if (isset ( $this->_tpl_vars['upload_musicValue']['sale'] )): ?>
               	                <?php else: ?>
                                <?php endif; ?>
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
<?php if ($this->_tpl_vars['showtab'] == 'topratedmusic'): ?>
<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['sidebar_no_audio_rated_error_msg']; ?>
</div>
<?php else: ?>
<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['sidebar_no_audio_found_error_msg']; ?>
</div>
<?php endif; ?>
<?php endif; ?>