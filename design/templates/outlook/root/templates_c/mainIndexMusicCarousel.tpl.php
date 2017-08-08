<?php /* Smarty version 2.6.18, created on 2011-10-17 14:58:08
         compiled from mainIndexMusicCarousel.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'mainIndexMusicCarousel.tpl', 15, false),)), $this); ?>
<?php if ($this->_tpl_vars['music_block_record_count']): ?>

<?php $this->assign('row_count', 4); ?>

<?php $this->assign('break_count', 1); ?>

<?php $_from = $this->_tpl_vars['populateCarousalMusicBlock_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['upload_musicKey'] => $this->_tpl_vars['upload_musicValue']):
?>
<div class="clsCarouselListContent <?php if ($this->_tpl_vars['break_count'] == $this->_tpl_vars['row_count']): ?>clsNoRightMargin<?php endif; ?>">
	<div class="clsCarouselListImage">
    	<div class="clsTime"><?php echo $this->_tpl_vars['upload_musicValue']['playing_time']; ?>
</div>
        <a href="javascript:void(0);" onclick="loadThisMusic('<?php echo $this->_tpl_vars['upload_musicValue']['record']['music_id']; ?>
');return false;" class="clsImageContainer clsImageBorder6 cls142x108">
            <?php if ($this->_tpl_vars['upload_musicValue']['music_image_src'] != ''): ?>
            <img  src="<?php echo $this->_tpl_vars['upload_musicValue']['music_image_src']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['upload_musicValue']['record']['music_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 12) : smarty_modifier_truncate($_tmp, 12)); ?>
" title="<?php echo $this->_tpl_vars['upload_musicValue']['record']['music_title']; ?>
" <?php echo $this->_tpl_vars['mainIndexObj']->DISP_IMAGE(140,106,$this->_tpl_vars['upload_musicValue']['record']['thumb_width'],$this->_tpl_vars['upload_musicValue']['record']['thumb_height']); ?>
/>
            <?php else: ?>
            <img  src="<?php echo $this->_tpl_vars['mainIndexObj']->CFG['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['mainIndexObj']->CFG['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['mainIndexObj']->CFG['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_audio_T.jpg" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['upload_musicValue']['record']['music_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 12) : smarty_modifier_truncate($_tmp, 12)); ?>
" title="<?php echo $this->_tpl_vars['upload_musicValue']['record']['music_title']; ?>
"/>
            <?php endif; ?>
        </a>
    </div>
    <div class="clsCarouselListDetails">
        <p class="clsTitle"><a href="<?php echo $this->_tpl_vars['upload_musicValue']['viewmusic_url']; ?>
" title="<?php echo $this->_tpl_vars['upload_musicValue']['record']['music_title']; ?>
"><?php echo $this->_tpl_vars['upload_musicValue']['record']['music_title']; ?>
</a></p>
        <p class="clsName"><?php echo $this->_tpl_vars['LANG']['mainIndex_by']; ?>
 <a href="<?php echo $this->_tpl_vars['upload_musicValue']['memberprofile_url']; ?>
" title="<?php echo $this->_tpl_vars['upload_musicValue']['record']['user_name']; ?>
"><?php echo $this->_tpl_vars['upload_musicValue']['record']['user_name']; ?>
</a></p>
        <p class="clsViews"><?php echo $this->_tpl_vars['LANG']['mainIndex_music_plays']; ?>
: <span><?php echo $this->_tpl_vars['upload_musicValue']['record']['total_plays']; ?>
</span></p>
    </div>
</div>
<?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
<?php endforeach; endif; unset($_from); ?>

<?php else: ?>
<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['mainIndex_music_no_record']; ?>
</div>
<?php endif; ?>