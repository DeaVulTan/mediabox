<?php /* Smarty version 2.6.18, created on 2011-10-17 15:09:57
         compiled from indexPopularPlaylistCarouselTab.tpl */ ?>
<script type="text/javascript">
	removeLoadingBg('indexPopularPlaylistContainer');
</script>
<?php if ($this->_tpl_vars['total_popular_playlist_pages']): ?>
<div class="clsCarouselContainer">
    <ul id="<?php echo $this->_tpl_vars['playlist_tab']; ?>
carouselMusicList" class="jcarousel-skin-tango">    	
      	<!-- The content will be dynamically loaded here -->
    </ul>
	<div class="clsIndexViewAllLinks">
			<a title="<?php echo $this->_tpl_vars['LANG']['myhome_music_view_all_playlist']; ?>
" href="<?php echo $this->_tpl_vars['myobj']->view_all_playlist_url; ?>
"><?php echo $this->_tpl_vars['LANG']['myhome_music_view_all_playlist']; ?>
</a>
	</div>
</div>
<script type="text/javascript">
	var playlist_carousel_tab = '<?php echo $this->_tpl_vars['playlist_tab']; ?>
carouselMusicList';
	<?php echo '
	jQuery(\'#\' + playlist_carousel_tab).jcarousel({
		scroll: 1,
		size: '; ?>
<?php echo $this->_tpl_vars['total_popular_playlist_pages']; ?>
<?php echo ',
		playlist_block: \''; ?>
<?php echo $this->_tpl_vars['playlist_tab']; ?>
<?php echo '\',
		itemFallbackDimension: 610,
		itemLoadCallback: popularPlaylistcarousel_itemLoadCallback
	});
	'; ?>

</script>
<?php else: ?>
<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['sidebar_no_playlist_found_error_msg']; ?>
</div>
<?php endif; ?>