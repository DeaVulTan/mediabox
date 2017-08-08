<?php /* Smarty version 2.6.18, created on 2011-10-18 15:30:24
         compiled from indexVideoChannelCarouselTab.tpl */ ?>
<?php if ($this->_tpl_vars['videoIndexObj']->total_channel_list_page): ?>
<!-- ** -->
<div class="clsCarouselContainer">
    <ul id="<?php echo $this->_tpl_vars['show_catgeroy']; ?>
carouselMusicList1" class="jcarousel-skin-tango">
      	<!-- The content will be dynamically loaded here -->
    </ul>
    	<div class="clsViewMoreChannels"><a href="<?php echo $this->_tpl_vars['videoIndexObj']->getUrl('videocategory','','','','video'); ?>
"><?php echo $this->_tpl_vars['LANG']['index_page_channel_block_viewall_link']; ?>
</a></div>
</div>
<script type="text/javascript">
	var music_carousel_tab1 = '<?php echo $this->_tpl_vars['show_catgeroy']; ?>
carouselMusicList1';
	<?php echo '
	jQuery(\'#\' + music_carousel_tab1).jcarousel({
		scroll: 1,
		size: '; ?>
<?php echo $this->_tpl_vars['videoIndexObj']->total_channel_list_page; ?>
<?php echo ',
		block_video: \''; ?>
<?php echo $this->_tpl_vars['show_catgeroy']; ?>
<?php echo '\',
		itemFallbackDimension: 610,
		itemLoadCallback: videoChannelCarousel_ItemLoadCallback
	});
	'; ?>

</script>
<?php else: ?>
<div id="video_category_no_records">
	<div id="selMsgAlert">
            <p>
				<?php echo $this->_tpl_vars['LANG']['sidebar_no_category_found_error_msg']; ?>

			</p>
	</div>			
</div>
<?php endif; ?>

