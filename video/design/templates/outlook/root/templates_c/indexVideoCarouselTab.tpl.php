<?php /* Smarty version 2.6.18, created on 2011-10-18 15:30:24
         compiled from indexVideoCarouselTab.tpl */ ?>
<?php if ($this->_tpl_vars['videoIndexObj']->total_video_list_pages): ?>
<div class="clsCarouselContainer">
    <ul id="<?php echo $this->_tpl_vars['showtab']; ?>
carouselMusicList" class="jcarousel-skin-tango">
      	<!-- The content will be dynamically loaded here -->
    </ul>
	<div class="clsViewMoreChannels"><a href="<?php echo $this->_tpl_vars['videoIndexObj']->getUrl('videolist','?pg=videonew','videonew/','','video'); ?>
"><?php echo $this->_tpl_vars['LANG']['index_page_video_block_viewall_link']; ?>
</a></div>
</div>
<script type="text/javascript">
	var music_carousel_tab = '<?php echo $this->_tpl_vars['showtab']; ?>
carouselMusicList';
	<?php echo '
	jQuery(\'#\' + music_carousel_tab).jcarousel({
		scroll: 1,
		size:  \''; ?>
<?php echo $this->_tpl_vars['total_video_list_pages']; ?>
<?php echo '\',
		block: \''; ?>
<?php echo $this->_tpl_vars['showtab']; ?>
<?php echo '\',
		itemFallbackDimension: 610,
		itemLoadCallback: videocarousel_itemLoadCallback
	});
	'; ?>

</script>
<?php else: ?>
<div id="video_no_records">
	<div id="selMsgAlert"><p><?php if ($this->_tpl_vars['showtab'] == 'newvideo'): ?><?php echo $this->_tpl_vars['LANG']['index_page_video_block_recent_video_err_msg']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['index_page_video_block_top_rate_video_err_msg']; ?>
<?php endif; ?></p></div>
</div>
<?php endif; ?>