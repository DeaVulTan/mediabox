<?php /* Smarty version 2.6.18, created on 2011-10-18 17:54:55
         compiled from mainIndexVideoCarousel.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'mainIndexVideoCarousel.tpl', 11, false),)), $this); ?>

<?php if ($this->_tpl_vars['video_block_record_count']): ?>
	<?php $this->assign('row_count', 4); ?>
	<?php $this->assign('break_count', 1); ?>
	<?php $_from = $this->_tpl_vars['populateCarousalVideoBlock_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['upload_videoKey'] => $this->_tpl_vars['value']):
?>
		<div class="clsCarouselListContent <?php if ($this->_tpl_vars['break_count'] == $this->_tpl_vars['row_count']): ?> clsNoRightMargin <?php endif; ?>">
			<div class="clsCarouselListImage">
			 	<div class="clsTime"><?php echo $this->_tpl_vars['value']['playing_time']; ?>
</div>
                <a onclick="loadThisVideo('<?php echo $this->_tpl_vars['value']['record']['video_id']; ?>
')" href="javascript:void(0)" title="<?php echo $this->_tpl_vars['value']['record']['video_title']; ?>
" class="clsImageContainer clsImageBorder5 cls142x108">
                    <img src="<?php echo $this->_tpl_vars['value']['image_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['value']['record']['video_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 12) : smarty_modifier_truncate($_tmp, 12)); ?>
" title="<?php echo $this->_tpl_vars['value']['record']['video_title']; ?>
" <?php echo $this->_tpl_vars['mainIndexObj']->DISP_IMAGE(140,106,$this->_tpl_vars['value']['record']['t_width'],$this->_tpl_vars['value']['record']['t_height']); ?>
/>
                </a>
            </div>
        	<div class="clsCarouselListDetails">
            	<p class="clsTitle"><a href="<?php echo $this->_tpl_vars['value']['video_url']; ?>
" title=<?php echo $this->_tpl_vars['value']['record']['video_title']; ?>
><?php echo $this->_tpl_vars['value']['record']['video_title']; ?>
</a></p>
            	<p class="clsName"><?php echo $this->_tpl_vars['LANG']['mainIndex_by']; ?>
 <a href="<?php echo $this->_tpl_vars['value']['memberProfileUrl']; ?>
"><?php echo $this->_tpl_vars['value']['uploaded_by_user_name']; ?>
</a></p>
            	<p class="clsViews"><?php echo $this->_tpl_vars['LANG']['mainIndex_video_views']; ?>
: <span><?php echo $this->_tpl_vars['value']['total_views']; ?>
</span></p>
        	</div>
    	</div>
       <?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
    <?php endforeach; endif; unset($_from); ?>
<?php else: ?>
	<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['mainIndex_video_no_record']; ?>
</div>
<?php endif; ?>