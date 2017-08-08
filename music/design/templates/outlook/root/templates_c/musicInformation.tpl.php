<?php /* Smarty version 2.6.18, created on 2013-08-17 00:15:50
         compiled from musicInformation.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'musicInformation.tpl', 6, false),)), $this); ?>
<div id="musicImage" class="clsLyricContainer">
    <div class="clsThumb">
        <div class="clsLargeThumbImageBackground clsNoLink">
          <a href="<?php echo $this->_tpl_vars['musicInfo']['viewmusic_url']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls132x88">
                <?php if ($this->_tpl_vars['musicInfo']['music_image_src'] == ''): ?>
                   <img width="132" height="88" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_audio_T.jpg" title="<?php echo $this->_tpl_vars['musicInfo']['music_title']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['musicInfo']['music_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
"/>
                <?php else: ?>
                    <img alt="<?php echo $this->_tpl_vars['musicInfo']['music_title']; ?>
" src="<?php echo $this->_tpl_vars['musicInfo']['music_image_src']; ?>
" title="<?php echo $this->_tpl_vars['musicInfo']['music_title']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(132,88,$this->_tpl_vars['musicInfo']['thumb_width'],$this->_tpl_vars['musicInfo']['thumb_height']); ?>
/>
                <?php endif; ?>
          </a>
        </div>
    </div>
    <div class="clsThumbContent">
        <p class="clsLyricMusicTitle"><?php echo $this->_tpl_vars['LANG']['common_music_title']; ?>
: <a href="<?php echo $this->_tpl_vars['musicInfo']['viewmusic_url']; ?>
" title="<?php echo $this->_tpl_vars['musicInfo']['music_title']; ?>
"><?php echo $this->_tpl_vars['musicInfo']['music_title']; ?>
</a></p>
        <p><?php echo $this->_tpl_vars['LANG']['common_music_cast']; ?>
: <?php echo $this->_tpl_vars['myobj']->getArtistLink($this->_tpl_vars['musicInfo']['music_artist'],true); ?>
</p>
        <p><?php echo $this->_tpl_vars['LANG']['common_artist_name']; ?>
: <a href="<?php echo $this->_tpl_vars['musicInfo']['music_owner_url']; ?>
" title="<?php echo $this->_tpl_vars['musicInfo']['user_name']; ?>
"><?php echo $this->_tpl_vars['musicInfo']['user_name']; ?>
</a></p>
    </div>
</div>