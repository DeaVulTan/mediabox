<?php /* Smarty version 2.6.18, created on 2011-10-17 15:09:56
         compiled from indexTopChartCarouselTab.tpl */ ?>
<script type="text/javascript">
	removeLoadingBg('indexTopChartContainer');
</script>
<?php if ($this->_tpl_vars['total_top_chart_pages']): ?>
<div class="ClsTopChartListCarouselContainer">
    <ul id="<?php echo $this->_tpl_vars['top_chart_tab']; ?>
carouselTopChartList" class="jcarousel-skin-tango">    	
      	<!-- The content will be dynamically loaded here -->
    </ul>
    <?php if ($this->_tpl_vars['top_chart_tab'] == 'topChartAlbums'): ?>
    <div class="clsIndexViewAllLinks">
			<a title="<?php echo $this->_tpl_vars['LANG']['myhome_music_view_all_albums']; ?>
" href="<?php echo $this->_tpl_vars['myobj']->view_all_albums_url; ?>
"><?php echo $this->_tpl_vars['LANG']['myhome_music_view_all_albums']; ?>
</a>
	</div>
    <?php else: ?>
	<div class="clsIndexViewAllLinks">
			<a title="<?php echo $this->_tpl_vars['LANG']['myhome_music_view_all_music']; ?>
" href="<?php echo $this->_tpl_vars['myobj']->view_all_music_url; ?>
"><?php echo $this->_tpl_vars['LANG']['myhome_music_view_all_music']; ?>
</a>
	</div>
    <?php endif; ?>
</div>
<script type="text/javascript">
	var top_chart_carousel_tab = '<?php echo $this->_tpl_vars['top_chart_tab']; ?>
carouselTopChartList';
	<?php echo '
	jQuery(\'#\' + top_chart_carousel_tab).jcarousel({
		scroll: 1,
		size: '; ?>
<?php echo $this->_tpl_vars['total_top_chart_pages']; ?>
<?php echo ',
		topChart: \''; ?>
<?php echo $this->_tpl_vars['top_chart_tab']; ?>
<?php echo '\',
		itemFallbackDimension: 60,
		itemLoadCallback: topChartCarousel_itemLoadCallback
	});
	'; ?>

</script>
<?php else: ?>
<?php if ($this->_tpl_vars['top_chart_tab'] == 'topChartAlbums'): ?>
<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['sidebar_no_topchart_album_found_error_msg']; ?>
</div>
<?php elseif ($this->_tpl_vars['top_chart_tab'] == 'topChartDownloads'): ?>
<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['sidebar_no_topchart_downloads_found_error_msg']; ?>
</div>
<?php else: ?>
<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['sidebar_no_topchart_audio_found_error_msg']; ?>
</div>
<?php endif; ?>
<?php endif; ?>