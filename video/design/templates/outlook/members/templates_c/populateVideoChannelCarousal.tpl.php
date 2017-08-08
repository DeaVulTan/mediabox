<?php /* Smarty version 2.6.18, created on 2011-10-25 15:04:47
         compiled from populateVideoChannelCarousal.tpl */ ?>
<?php if ($this->_tpl_vars['channel_block_record_count']): ?>
<div class="ClsMusicListCarouselContainer">
	<div class="ClsMusicListCarousel">
<div class="clsIndexVideosCategory">
<?php $_from = $this->_tpl_vars['videoIndexObj_category']->video_channels_category; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
<div class="clsMainCategory">
<div class="clsVideoSubCategeroy">
	<h3><?php echo $this->_tpl_vars['value']['video_category_name']; ?>
 <span>(<?php echo $this->_tpl_vars['value']['total_video_count']; ?>
)</span></h3>
</div>
<table class="clsCarouselList">
	<?php if ($this->_tpl_vars['value']['video_category_id']): ?>
		<tr>
			<?php echo $this->_tpl_vars['videoIndexObj_category']->populateCarouselCategoryVideo($this->_tpl_vars['value']['video_category_id']); ?>

		</tr>
	<?php endif; ?>
</table>
</div>
<?php endforeach; endif; unset($_from); ?>
</div>
</div>
</div>
<?php endif; ?>